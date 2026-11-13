<?php
/**
 * BÚSQUEDA Y CORRECCIÓN DE DATOS PERSONALES (tabla nombre)
 *
 * Usado por:
 *   - produccion_servicios: valida_cedula_hc.php, persona_encontrada_hc.php
 *   - carpetas_familiares:  persona_encontrada.php, modificar_persona_reg.php, guarda_modificacion_persona.php
 *   - comun/corregir_persona.php: guardado (JSON) de las ventanas de corrección de ambos módulos
 *
 * Reglas:
 *   - Búsqueda por CI: devuelve TODAS las personas con ese número. Complemento y fecha de
 *     nacimiento solo ordenan/resaltan (los datos antiguos no son confiables como filtro).
 *   - Formulario único (per_form_busqueda): cédula, o nombres + un apellido (un solo apellido se busca
 *     como primero y como segundo), o nombres + fecha de nacimiento si no tiene apellidos. Nombres
 *     "empieza con", apellidos completos; máximo PER_MAX_RESULTADOS. Si la cédula no existe y escribieron nombres, se busca por nombres.
 *   - La tarjeta enlaza a la carpeta familiar más reciente de la persona.
 *   - Complemento válido: 2 caracteres, un número y una letra en cualquier orden (1K, K1; "1-K" se guarda 1K).
 *     Lo demás (LP, CBBA, 0, SN, "-") no es complemento: si es un departamento se sugiere en EXPEDIDO.
 *   - Corrección (per_revisar_cambio): convertir la ficha en OTRA persona (nombres distintos o los dos
 *     apellidos distintos) se BLOQUEA si está en una carpeta familiar o tiene atenciones, o si además
 *     cambia el CI por otro totalmente distinto. Un apellido distinto, CI totalmente distinto o
 *     CI+complemento ya usado => advertencia "¿continuar?". Asignar CI a quien tenía 0, corregir 1-2
 *     dígitos, letras, fecha de nacimiento y género: sin aviso. Todo cambio queda en nombre_correccion.
 *   - Consultas preparadas sin depender de mysqlnd (no usa get_result).
 *
 * SQL: base_datos/correccion_persona.sql
 */

if (!defined('PER_TOKEN_TTL')) {
    define('PER_TOKEN_TTL', 14400);   // 4 horas de vigencia de una búsqueda abierta
    define('PER_MAX_TOKENS', 30);     // búsquedas abiertas que se recuerdan por usuario
    define('PER_MAX_RESULTADOS', 50);
}

/* ------------------------------------------------------------------ */
/* Utilidades de base de datos y salida                                */
/* ------------------------------------------------------------------ */

function per_h($valor)
{
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}

function per_stmt($link, $sql, $types = '', $params = array())
{
    $st = mysqli_prepare($link, $sql);
    if ($st === false) {
        throw new RuntimeException('Error preparando consulta: ' . mysqli_error($link));
    }
    if ($types !== '') {
        mysqli_stmt_bind_param($st, $types, ...$params);
    }
    if (!mysqli_stmt_execute($st)) {
        throw new RuntimeException('Error ejecutando consulta: ' . mysqli_stmt_error($st));
    }
    return $st;
}

/** Todas las filas como arrays asociativos. */
function per_filas($link, $sql, $types = '', $params = array())
{
    $st   = per_stmt($link, $sql, $types, $params);
    $meta = mysqli_stmt_result_metadata($st);
    $fila = array();
    $refs = array();
    while ($campo = mysqli_fetch_field($meta)) {
        $fila[$campo->name] = null;
        $refs[] = &$fila[$campo->name];
    }
    mysqli_stmt_bind_result($st, ...$refs);
    $salida = array();
    while (mysqli_stmt_fetch($st)) {
        $copia = array();
        foreach ($fila as $k => $v) {
            $copia[$k] = $v;
        }
        $salida[] = $copia;
    }
    mysqli_stmt_close($st);
    return $salida;
}

function per_fila($link, $sql, $types = '', $params = array())
{
    $filas = per_filas($link, $sql, $types, $params);
    return $filas ? $filas[0] : null;
}

function per_ejecutar($link, $sql, $types = '', $params = array())
{
    $st = per_stmt($link, $sql, $types, $params);
    $n  = mysqli_stmt_affected_rows($st);
    mysqli_stmt_close($st);
    return $n;
}

/* ------------------------------------------------------------------ */
/* Normalización de textos, complemento y expedido                     */
/* ------------------------------------------------------------------ */

/** Mayúsculas, sin espacios al inicio/fin ni dobles. */
function per_mayus($texto)
{
    $texto = preg_replace('/\s+/u', ' ', trim((string)$texto));
    return mb_strtoupper($texto, 'UTF-8');
}

/** Para comparar: mayúsculas y sin tildes. */
function per_sin_tildes($texto)
{
    return strtr(per_mayus($texto), array(
        'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U', 'Ü' => 'U', 'Ñ' => 'N',
        'À' => 'A', 'È' => 'E', 'Ì' => 'I', 'Ò' => 'O', 'Ù' => 'U',
    ));
}

/** Lugares de expedición del carnet (código => nombre). */
function per_expedidos()
{
    return array(
        'LP' => 'LA PAZ', 'OR' => 'ORURO', 'PT' => 'POTOSÍ', 'CB' => 'COCHABAMBA', 'CH' => 'CHUQUISACA',
        'TJ' => 'TARIJA', 'SC' => 'SANTA CRUZ', 'BE' => 'BENI', 'PD' => 'PANDO',
    );
}

/** Si un texto es un departamento escrito a mano (Cbba, L.P., La Paz, Potosi...), devuelve su código; si no, ''. */
function per_depto_desde_texto($texto)
{
    $t = preg_replace('/[^A-Z]/', '', per_sin_tildes($texto));
    $alias = array(
        'LP' => array('LP', 'LPZ', 'LAPAZ'),
        'OR' => array('OR', 'ORU', 'ORURO'),
        'PT' => array('PT', 'PO', 'PTS', 'POT', 'POTOSI'),
        'CB' => array('CB', 'CBB', 'CBBA', 'CBA', 'COCHABAMBA'),
        'CH' => array('CH', 'CHQ', 'CHU', 'CHUQ', 'CHUQUISACA', 'SUCRE'),
        'TJ' => array('TJ', 'TJA', 'TAR', 'TARIJA'),
        'SC' => array('SC', 'SCZ', 'STACRUZ', 'SANTACRUZ'),
        'BE' => array('BE', 'BN', 'BEN', 'BENI'),
        'PD' => array('PD', 'PA', 'PAN', 'PANDO'),
    );
    foreach ($alias as $codigo => $lista) {
        if (in_array($t, $lista, true)) {
            return $codigo;
        }
    }
    return '';
}

/** Quita espacios, guiones, puntos y barras: "1-k" => "1K". */
function per_complemento_normalizar($complemento)
{
    return preg_replace('/[\s\-\.\/_]/', '', per_mayus($complemento));
}

/** Vacío o 2 caracteres: un número y una letra en cualquier orden (1K, K1). */
function per_complemento_valido($complemento_normalizado)
{
    return $complemento_normalizado === ''
        || (bool)preg_match('/^([0-9][A-Z]|[A-Z][0-9])$/', $complemento_normalizado);
}

/** Complemento usable para buscar/mostrar: el normalizado si es válido, si no ''. */
function per_complemento_limpio($complemento)
{
    $c = per_complemento_normalizar($complemento);
    return per_complemento_valido($c) ? $c : '';
}

/**
 * Analiza el complemento guardado en un registro antiguo para precargar el formulario de corrección.
 * Devuelve: complemento (corregido), exp_sugerido, invalido (bool), original, motivo.
 */
function per_analizar_complemento($complemento_original, $exp_actual = '')
{
    $original = trim((string)$complemento_original);
    $norm     = per_complemento_normalizar($original);
    $r = array('complemento' => $norm, 'exp_sugerido' => '', 'invalido' => false, 'original' => $original, 'motivo' => '');
    if (per_complemento_valido($norm)) {
        return $r;
    }
    $r['complemento'] = '';
    $r['invalido']    = true;
    $depto = per_depto_desde_texto($original);
    if ($depto !== '') {
        $r['exp_sugerido'] = $depto;
        $r['motivo'] = 'era el lugar de expedición; se pasó a EXPEDIDO';
    } else {
        $r['motivo'] = 'no tiene el formato de un complemento; se dejó vacío';
    }
    return $r;
}

/** Código de expedido válido a partir de lo guardado (acepta textos antiguos como "PO" o "La Paz"). */
function per_expedido_codigo($exp)
{
    $exp = per_mayus($exp);
    if (isset(per_expedidos()[$exp])) {
        return $exp;
    }
    return per_depto_desde_texto($exp);
}

function per_edad($fecha_nac)
{
    if (!$fecha_nac || $fecha_nac === '0000-00-00') {
        return '';
    }
    try {
        $nac = new DateTime($fecha_nac);
    } catch (Exception $e) {
        return '';
    }
    return $nac->diff(new DateTime('today'))->y;
}

function per_nombre_completo(array $p)
{
    return trim(preg_replace('/\s+/', ' ', $p['nombre'] . ' ' . $p['paterno'] . ' ' . $p['materno']));
}

/** "1234567-1K" (sin complemento si no es válido). */
function per_ci_texto(array $p)
{
    $ci = ($p['ci'] === null || (string)$p['ci'] === '' || (int)$p['ci'] === 0) ? 'SIN CI' : (string)$p['ci'];
    $c  = per_complemento_limpio($p['complemento']);
    return $c !== '' ? $ci . '-' . $c : $ci;
}

/* ------------------------------------------------------------------ */
/* Tokens de búsqueda (evitan depender de una variable de sesión única) */
/* ------------------------------------------------------------------ */

function per_token_crear(array $contexto)
{
    if (!isset($_SESSION['persona_tokens']) || !is_array($_SESSION['persona_tokens'])) {
        $_SESSION['persona_tokens'] = array();
    }
    $ahora = time();
    foreach ($_SESSION['persona_tokens'] as $t => $c) {
        if (!isset($c['creado']) || ($ahora - $c['creado']) > PER_TOKEN_TTL) {
            unset($_SESSION['persona_tokens'][$t]);
        }
    }
    while (count($_SESSION['persona_tokens']) >= PER_MAX_TOKENS) {
        array_shift($_SESSION['persona_tokens']);
    }
    $token = bin2hex(random_bytes(16));
    $contexto['creado'] = $ahora;
    $_SESSION['persona_tokens'][$token] = $contexto;
    return $token;
}

function per_token_leer($token)
{
    $token = is_string($token) ? $token : '';
    if (!preg_match('/^[a-f0-9]{32}$/', $token) || empty($_SESSION['persona_tokens'][$token])) {
        return null;
    }
    $c = $_SESSION['persona_tokens'][$token];
    if (!isset($c['creado']) || (time() - $c['creado']) > PER_TOKEN_TTL) {
        unset($_SESSION['persona_tokens'][$token]);
        return null;
    }
    return $c;
}

/** La persona pertenece a la búsqueda del token (evita actuar sobre un idnombre cualquiera). */
function per_token_permite($contexto, $idnombre)
{
    return $contexto && isset($contexto['ids']) && in_array((int)$idnombre, $contexto['ids'], true);
}

/* ------------------------------------------------------------------ */
/* Búsqueda por CI                                                     */
/* ------------------------------------------------------------------ */

/**
 * Personas con ese CI (más $ids_extra: personas de la misma búsqueda cuyo CI se corrigió).
 * Cada fila trae: datos de nombre, genero, edad, ci_texto, ultima_fecha, ultimo_eess, carpeta,
 * coincide_complemento, coincide_fecha, posible_duplicado.
 * Orden: coincidencias primero, luego quien tiene atenciones/carpeta.
 */
function per_buscar_ci($link, $ci, $complemento = '', $fecha_nac = '', array $ids_extra = array())
{
    $ci = (int)$ci;
    $ids_extra = array_values(array_unique(array_filter(array_map('intval', $ids_extra))));
    if ($ci <= 0 && !$ids_extra) {
        return array();
    }

    $sql = "SELECT n.idnombre, n.nombre, n.paterno, n.materno, n.ci, n.complemento, n.exp, n.fecha_nac,
                   n.idgenero, n.idnacionalidad, g.genero
              FROM nombre n
         LEFT JOIN genero g ON g.idgenero = n.idgenero
             WHERE n.ci = ?";
    $types  = 'i';
    $params = array($ci);
    if ($ids_extra) {
        $sql   .= " OR n.idnombre IN (" . implode(',', array_fill(0, count($ids_extra), '?')) . ")";
        $types .= str_repeat('i', count($ids_extra));
        $params = array_merge($params, $ids_extra);
    }
    $sql .= " ORDER BY n.idnombre LIMIT " . PER_MAX_RESULTADOS;
    return per_completar_personas($link, per_filas($link, $sql, $types, $params), $complemento, $fecha_nac);
}

/** Columnas de nombre que usan las tarjetas. */
function per_columnas_persona()
{
    return "n.idnombre, n.nombre, n.paterno, n.materno, n.ci, n.complemento, n.exp, n.fecha_nac,
            n.idgenero, n.idnacionalidad, g.genero";
}

/** ¿Alcanzan los datos para buscar por nombres? Nombres + un apellido, o nombres + fecha (sin apellidos). */
function per_criterio_nombre_valido($nombre, $paterno, $materno, $fecha_nac)
{
    return per_mayus($nombre) !== '' && (per_mayus($paterno) !== '' || per_mayus($materno) !== '' || $fecha_nac !== '');
}

/**
 * Búsqueda por nombres y apellidos (personas sin CI, p. ej. recién nacidos registrados con CI 0,
 * o que no recuerdan su número). Nombres: "empieza con" (JUAN encuentra JUAN CARLOS); apellidos:
 * completos (LAURA no encuentra LAURAYZA). Mayúsculas y tildes no importan (colación de la tabla).
 *   - Dos apellidos: deben coincidir los dos.
 *   - Un solo apellido (en cualquier casilla): se busca en esa columna y también en la otra cuando
 *     la persona tiene esa otra vacía (quien tiene un apellido está guardado unas veces como primero
 *     y otras como segundo).
 *   - Sin apellidos: nombres + fecha de nacimiento (la fecha filtra).
 * Con apellidos la fecha no filtra: ordena primero a quienes coinciden.
 * Devuelve array('personas' => [...] (máximo PER_MAX_RESULTADOS), 'total' => cantidad real).
 */
function per_buscar_nombre($link, $nombre, $paterno, $materno, $fecha_nac = '')
{
    $nombre  = per_mayus($nombre);
    $paterno = per_mayus($paterno);
    $materno = per_mayus($materno);
    if (!per_criterio_nombre_valido($nombre, $paterno, $materno, $fecha_nac)) {
        return array('personas' => array(), 'total' => 0);
    }
    // Nombres: "empieza con" (JUAN encuentra JUAN CARLOS). Apellidos: el apellido completo
    // (LAURA no encuentra LAURAYZA). En ambos casos también si el dato antiguo quedó con un espacio al inicio.
    $like = function ($col, $texto) {
        if ($col !== 'n.nombre') {
            return array("($col = ? OR $col = ?)", array($texto, ' ' . $texto));
        }
        $t = addcslashes($texto, '\\%_') . '%';
        return array("($col LIKE ? OR $col LIKE ?)", array($t, ' ' . $t));
    };
    // Cada rama: lista de condiciones [sql, params]; las ramas se unen con UNION.
    // Primero va la condición de paterno para aprovechar el índice (paterno, nombre).
    $ramas = array();
    $nom   = $like('n.nombre', $nombre);
    if ($paterno !== '' && $materno !== '') {
        $ramas[] = array($like('n.paterno', $paterno), $nom, $like('n.materno', $materno));
    } elseif ($paterno !== '') {
        $ramas[] = array($like('n.paterno', $paterno), $nom);
        $ramas[] = array(array("n.paterno = ''", array()), $nom, $like('n.materno', $paterno));
        $ramas[] = array(array("n.paterno IS NULL", array()), $nom, $like('n.materno', $paterno));
    } elseif ($materno !== '') {
        $ramas[] = array($like('n.materno', $materno), $nom);
        $ramas[] = array($like('n.paterno', $materno), $nom, array("(n.materno IS NULL OR n.materno = '')", array()));
    } else {
        $ramas[] = array($nom, array("n.fecha_nac = ?", array($fecha_nac)));
    }

    $partes = array();
    $params = array();
    foreach ($ramas as $condiciones) {
        $sql = array();
        foreach ($condiciones as $c) {
            $sql[]  = $c[0];
            $params = array_merge($params, $c[1]);
        }
        $partes[] = "SELECT n.idnombre FROM nombre n WHERE " . implode(' AND ', $sql);
    }
    $types = str_repeat('s', count($params));

    // 1) Solo los idnombre (consulta directa: unida a otra tabla, MariaDB elige un plan muy lento)
    $ids = array();
    foreach (per_filas($link, implode(' UNION ', $partes), $types, $params) as $f) {
        $ids[] = (int)$f['idnombre'];
    }
    $total = count($ids);
    if ($total === 0) {
        return array('personas' => array(), 'total' => 0);
    }

    // Primero quien coincide en fecha de nacimiento; luego el nombre exacto; luego alfabético
    $orden_types  = 's';
    $orden_params = array($nombre);
    $orden = "(n.nombre = ?) DESC, n.paterno, n.materno, n.nombre";
    if ($fecha_nac !== '') {
        $orden        = "(n.fecha_nac = ?) DESC, " . $orden;
        $orden_types  = 's' . $orden_types;
        array_unshift($orden_params, $fecha_nac);
    }
    // 2) Datos de esas personas (por clave primaria), ordenados; máximo PER_MAX_RESULTADOS
    $filas = per_filas($link,
        "SELECT " . per_columnas_persona() . "
           FROM nombre n
      LEFT JOIN genero g ON g.idgenero = n.idgenero
          WHERE n.idnombre IN (" . implode(',', $ids) . ")
       ORDER BY $orden
          LIMIT " . PER_MAX_RESULTADOS,
        $orden_types, $orden_params);

    return array('personas' => per_completar_personas($link, $filas, '', $fecha_nac), 'total' => $total);
}

/** Personas por idnombre (para volver a mostrar una búsqueda ya hecha, con los datos corregidos). */
function per_personas_ids($link, array $ids, $complemento = '', $fecha_nac = '')
{
    $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));
    if (!$ids) {
        return array();
    }
    $filas = per_filas($link,
        "SELECT " . per_columnas_persona() . "
           FROM nombre n
      LEFT JOIN genero g ON g.idgenero = n.idgenero
          WHERE n.idnombre IN (" . implode(',', array_fill(0, count($ids), '?')) . ")",
        str_repeat('i', count($ids)), $ids);
    return per_completar_personas($link, $filas, $complemento, $fecha_nac);
}

/**
 * Completa las filas de nombre con lo que muestran las tarjetas (edad, última atención, carpeta,
 * coincidencias, posible duplicado) y las ordena: coincidencias primero, luego quien tiene atenciones/carpeta.
 */
function per_completar_personas($link, array $personas, $complemento = '', $fecha_nac = '')
{
    $comp_buscado = per_complemento_limpio($complemento);
    $claves = array();
    foreach ($personas as $i => $p) {
        $ult = per_fila($link,
            "SELECT a.fecha_registro, e.establecimiento_salud
               FROM atencion_psafci a
          LEFT JOIN establecimiento_salud e ON e.idestablecimiento_salud = a.idestablecimiento_salud
              WHERE a.idnombre = ?
           ORDER BY a.idatencion_psafci DESC LIMIT 1",
            'i', array((int)$p['idnombre']));
        // Si la persona está en más de una carpeta se muestra la más reciente (la vigente)
        $cf = per_fila($link,
            "SELECT cf.idcarpeta_familiar, cf.codigo
               FROM integrante_cf i
         INNER JOIN carpeta_familiar cf ON cf.idcarpeta_familiar = i.idcarpeta_familiar
              WHERE i.idnombre = ?
           ORDER BY i.idintegrante_cf DESC LIMIT 1",
            'i', array((int)$p['idnombre']));

        $p['edad']                 = per_edad($p['fecha_nac']);
        $p['ci_texto']             = per_ci_texto($p);
        $p['ultima_fecha']         = $ult ? $ult['fecha_registro'] : '';
        $p['ultimo_eess']          = $ult ? $ult['establecimiento_salud'] : '';
        $p['carpeta']              = $cf ? (string)$cf['codigo'] : '';
        $p['idcarpeta_familiar']   = $cf ? (int)$cf['idcarpeta_familiar'] : 0;
        $p['coincide_complemento'] = $comp_buscado !== '' && per_complemento_limpio($p['complemento']) === $comp_buscado;
        $p['coincide_fecha']       = $fecha_nac !== '' && $p['fecha_nac'] === $fecha_nac;
        $p['busco_complemento']    = $comp_buscado !== '';   // el usuario ingresó complemento (para avisar si no coincide)
        $p['busco_fecha']          = $fecha_nac !== '';
        $p['posible_duplicado']    = false;

        $clave = per_sin_tildes($p['nombre'] . '|' . $p['paterno'] . '|' . $p['materno']) . '|' . $p['fecha_nac'];
        $claves[$clave][] = $i;
        $personas[$i] = $p;
    }
    foreach ($claves as $indices) {
        if (count($indices) > 1) {
            foreach ($indices as $i) {
                $personas[$i]['posible_duplicado'] = true;
            }
        }
    }

    usort($personas, function ($a, $b) {
        $pa = ($a['coincide_complemento'] ? 4 : 0) + ($a['coincide_fecha'] ? 2 : 0) + (($a['ultima_fecha'] !== '' || $a['carpeta'] !== '') ? 1 : 0);
        $pb = ($b['coincide_complemento'] ? 4 : 0) + ($b['coincide_fecha'] ? 2 : 0) + (($b['ultima_fecha'] !== '' || $b['carpeta'] !== '') ? 1 : 0);
        if ($pa !== $pb) {
            return $pb - $pa;
        }
        return strcmp((string)$b['ultima_fecha'], (string)$a['ultima_fecha']);
    });
    return $personas;
}

/**
 * Hace la búsqueda del formulario único (per_form_busqueda) y devuelve el contexto que se guarda
 * en el token. Mismo uso en historias clínicas y carpetas.
 *   - Con cédula: busca por cédula. Si nadie la tiene y escribieron nombres, busca por nombres
 *     (ctx['ci_no_encontrado'] = cédula buscada).
 *   - Sin cédula: nombres + un apellido, o nombres + fecha de nacimiento.
 * Devuelve array('error' => ''|'datos', 'ctx' => array, 'personas' => array).
 */
function per_buscar_desde_post($link, array $post, $tipo)
{
    $fecha_nac = isset($post['fecha_nac']) ? trim((string)$post['fecha_nac']) : '';
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_nac)) {
        $fecha_nac = '';
    }
    $ci          = isset($post['ci']) ? (int)preg_replace('/\D/', '', (string)$post['ci']) : 0;
    $complemento = per_complemento_limpio(isset($post['complemento']) ? $post['complemento'] : '');
    $nombre      = per_mayus(isset($post['nombre']) ? $post['nombre'] : '');
    $paterno     = per_mayus(isset($post['paterno']) ? $post['paterno'] : '');
    $materno     = per_mayus(isset($post['materno']) ? $post['materno'] : '');
    $por_nombre  = per_criterio_nombre_valido($nombre, $paterno, $materno, $fecha_nac);

    if ($ci > 0) {
        $personas = per_buscar_ci($link, $ci, $complemento, $fecha_nac);
        if ($personas || !$por_nombre) {
            $ids = array();
            foreach ($personas as $p) {
                $ids[] = (int)$p['idnombre'];
            }
            return array('error' => '', 'personas' => $personas, 'ctx' => array(
                'tipo' => $tipo, 'modo' => 'ci', 'ci' => $ci, 'complemento' => $complemento, 'fecha_nac' => $fecha_nac, 'ids' => $ids,
            ));
        }
        // Nadie con esa cédula: se busca por los nombres que también escribieron
    } elseif (!$por_nombre) {
        return array('error' => 'datos', 'ctx' => null, 'personas' => array());
    }

    $r   = per_buscar_nombre($link, $nombre, $paterno, $materno, $fecha_nac);
    $ids = array();
    foreach ($r['personas'] as $p) {
        $ids[] = (int)$p['idnombre'];
    }
    return array('error' => '', 'personas' => $r['personas'], 'ctx' => array(
        'tipo' => $tipo, 'modo' => 'nombre', 'nombre' => $nombre, 'paterno' => $paterno, 'materno' => $materno,
        'ci' => 0, 'ci_no_encontrado' => $ci, 'complemento' => '', 'fecha_nac' => $fecha_nac,
        'total' => $r['total'], 'ids' => $ids,
    ));
}

/** Vuelve a consultar las personas de una búsqueda guardada (refleja correcciones). */
function per_personas_contexto($link, array $ctx)
{
    if (empty($ctx['ids'])) {
        return array();
    }
    if (isset($ctx['modo']) && $ctx['modo'] === 'nombre') {
        return per_personas_ids($link, $ctx['ids'], '', $ctx['fecha_nac']);
    }
    // ids: personas de esta búsqueda aunque se les haya corregido el CI
    $personas = per_buscar_ci($link, $ctx['ci'], $ctx['complemento'], $ctx['fecha_nac'], $ctx['ids']);
    return array_values(array_filter($personas, function ($p) use ($ctx) {
        return in_array((int)$p['idnombre'], $ctx['ids'], true);
    }));
}

/** Encabezado del resultado según el tipo de búsqueda. */
function per_encabezado_contexto(array $ctx, array $personas, $instruccion, $color = 'info')
{
    if (isset($ctx['modo']) && $ctx['modo'] === 'nombre') {
        return per_resultado_encabezado_nombre($ctx, $personas, $instruccion, $color);
    }
    return per_resultado_encabezado($ctx['ci'], $ctx['complemento'], $ctx['fecha_nac'], $personas, $instruccion, $color);
}

/**
 * Formulario único de búsqueda de personas (mismo en historias clínicas y carpetas), en una fila:
 * cédula, complemento, nombres, apellidos, fecha de nacimiento. Muestra los avisos ?e= de la página.
 * $accion: página que recibe el POST; $titulo: título del recuadro.
 */
function per_form_busqueda($accion, $titulo, $color = 'primary')
{
    $c = per_h($color);
    $e = isset($_GET['e']) ? (string)$_GET['e'] : '';
    $avisos = array(
        'exp'   => 'La búsqueda expiró. Vuelva a buscar.',
        'datos' => 'Ingrese el número de cédula, o los nombres con al menos un apellido (si la persona no tiene apellidos, los nombres y la fecha de nacimiento).',
    );
    $avisos['ci']  = $avisos['datos'];   // enlaces antiguos
    $avisos['nom'] = $avisos['datos'];

    // Al volver desde el resultado (?b=token) se muestra lo que se había escrito
    $v   = array('ci' => '', 'complemento' => '', 'nombre' => '', 'paterno' => '', 'materno' => '', 'fecha_nac' => '');
    $ctx = isset($_GET['b']) ? per_token_leer((string)$_GET['b']) : null;
    if ($ctx) {
        foreach ($v as $k => $x) {
            $v[$k] = isset($ctx[$k]) ? (string)$ctx[$k] : '';
        }
        if (!empty($ctx['ci_no_encontrado'])) {
            $v['ci'] = (string)$ctx['ci_no_encontrado'];
        }
        if ($v['ci'] === '0') {
            $v['ci'] = '';
        }
    }
    $v = array_map('per_h', $v);
    ob_start();
    ?>
    <style>
        /* Una fila: campos cortos (complemento, fecha) angostos; nombres y apellidos anchos */
        .busqueda-persona .campo h6 { font-size: .8rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        /* Ejemplo del complemento (1K) claro: que no parezca un dato ya escrito */
        .busqueda-persona [name="complemento"]::placeholder { color: #c5c7d4; opacity: 1; }
        @media (min-width: 992px) {
            .busqueda-persona .c-ci   { flex: 0 0 13%; max-width: 13%; }
            .busqueda-persona .c-comp { flex: 0 0 7%;  max-width: 7%; }
            .busqueda-persona .c-nom  { flex: 0 0 21%; max-width: 21%; }
            .busqueda-persona .c-ap   { flex: 0 0 17%; max-width: 17%; }
            .busqueda-persona .c-fn   { flex: 0 0 14%; max-width: 14%; }
            .busqueda-persona .c-btn  { flex: 0 0 11%; max-width: 11%; }
        }
    </style>
    <form action="<?php echo per_h($accion); ?>" method="post" class="busqueda-persona"<?php
        // Rellenado al volver: cédula anterior (si el médico la cambia, se borran los demás datos)
        if ($ctx && $v['ci'] !== '') { echo ' data-ci-anterior="' . $v['ci'] . '"'; } ?>>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-<?php echo $c; ?>"><?php echo per_h($titulo); ?></h6>
        </div>
        <div class="card-body">
            <?php if (isset($avisos[$e])) { ?>
            <div class="alert alert-warning py-2"><?php echo per_h($avisos[$e]); ?></div>
            <?php } ?>
            <div class="form-row">
                <div class="col-12 col-md-6 c-ci campo mb-2">
                    <h6 class="text-<?php echo $c; ?>" title="Número de cédula de identidad">N° CÉDULA:</h6>
                    <input type="number" name="ci" id="ci" min="1" class="form-control" value="<?php echo $v['ci']; ?>">
                </div>
                <div class="col-12 col-md-6 c-comp campo mb-2">
                    <h6 class="text-<?php echo $c; ?>" title="Complemento: solo si el carnet lo tiene (1234567-1K). No es el departamento.">COMPL.:</h6>
                    <input type="text" name="complemento" maxlength="3" class="form-control" placeholder="1K"
                           title="Solo si el carnet lo tiene (1234567-1K). No es el departamento." value="<?php echo $v['complemento']; ?>">
                </div>
                <div class="col-12 col-md-4 c-nom campo mb-2">
                    <h6 class="text-<?php echo $c; ?>">NOMBRES:</h6>
                    <input type="text" name="nombre" maxlength="45" class="form-control" value="<?php echo $v['nombre']; ?>">
                </div>
                <div class="col-12 col-md-4 c-ap campo mb-2">
                    <h6 class="text-<?php echo $c; ?>">PRIMER APELLIDO:</h6>
                    <input type="text" name="paterno" maxlength="45" class="form-control" value="<?php echo $v['paterno']; ?>">
                </div>
                <div class="col-12 col-md-4 c-ap campo mb-2">
                    <h6 class="text-<?php echo $c; ?>">SEGUNDO APELLIDO:</h6>
                    <input type="text" name="materno" maxlength="45" class="form-control" value="<?php echo $v['materno']; ?>">
                </div>
                <div class="col-12 col-md-6 c-fn campo mb-2">
                    <h6 class="text-<?php echo $c; ?>" title="Fecha de nacimiento">F. NACIMIENTO:</h6>
                    <input type="date" name="fecha_nac" max="<?php echo date('Y-m-d'); ?>" class="form-control" value="<?php echo $v['fecha_nac']; ?>">
                </div>
                <div class="col-12 col-md-6 c-btn campo mb-2">
                    <h6>&nbsp;</h6>
                    <button type="submit" class="btn btn-<?php echo $c; ?> btn-block">BUSCAR</button>
                </div>
            </div>
            <small class="text-muted">
                De preferencia busque por <b>cédula</b>. Sin cédula (por ejemplo, recién nacidos): nombres y al menos un apellido;
                si no tiene apellidos, nombres y fecha de nacimiento.
            </small>
        </div>
    </div>
    </form>
    <script>
    // Cédula, o nombres + (un apellido o fecha de nacimiento). Se revisa al pulsar BUSCAR y al escribir;
    // el servidor también lo exige.
    document.querySelectorAll('.busqueda-persona').forEach(function (f) {
        var ci = f.querySelector('[name="ci"]'), nom = f.querySelector('[name="nombre"]'), p = f.querySelector('[name="paterno"]'),
            m = f.querySelector('[name="materno"]'), fn = f.querySelector('[name="fecha_nac"]');
        function revisar() {
            [ci, nom, p].forEach(function (x) { x.setCustomValidity(''); });
            if (ci.value.trim() !== '') return;
            if (nom.value.trim() === '') {
                ci.setCustomValidity('Ingrese el número de cédula o los nombres de la persona.');
            } else if (p.value.trim() === '' && m.value.trim() === '' && fn.value === '') {
                p.setCustomValidity('Ingrese al menos un apellido. Si la persona no tiene apellidos, ingrese la fecha de nacimiento.');
            }
        }
        f.querySelector('button[type="submit"]').addEventListener('click', revisar);
        f.addEventListener('input', revisar);

        // Al volver con una búsqueda anterior: si cambian la cédula es otro paciente, así que se borran
        // complemento, nombres, apellidos y fecha que venían de esa búsqueda (no se mezclan dos pacientes).
        // Si solo agregan datos sin tocar la cédula, se mantienen.
        var anterior = f.getAttribute('data-ci-anterior');
        if (anterior) {
            ci.addEventListener('input', function () {
                if (!anterior || ci.value.trim() === '' || ci.value.trim() === anterior) return;
                ['complemento', 'nombre', 'paterno', 'materno', 'fecha_nac'].forEach(function (k) { f.querySelector('[name="' + k + '"]').value = ''; });
                anterior = null;   // una sola vez: después puede escribir los nombres que quiera
                revisar();
            });
        }
    });
    // Los datos de "volver" se muestran una sola vez: se quita ?b= (y ?e=) de la dirección,
    // así al actualizar la página (F5) el formulario queda vacío.
    if (window.history && history.replaceState && /[?&](b|e)=/.test(location.search)) {
        var u = new URL(location.href);
        u.searchParams.delete('b');
        u.searchParams.delete('e');
        history.replaceState(null, '', u.pathname + (u.searchParams.toString() ? '?' + u.searchParams.toString() : '') + u.hash);
    }
    </script>
    <?php
    return ob_get_clean();
}

/* ------------------------------------------------------------------ */
/* Corrección de datos personales                                      */
/* ------------------------------------------------------------------ */

function per_etiquetas()
{
    return array(
        'ci' => 'N° CÉDULA', 'complemento' => 'COMPLEMENTO', 'exp' => 'EXPEDIDO', 'nombre' => 'NOMBRES',
        'paterno' => 'PRIMER APELLIDO', 'materno' => 'SEGUNDO APELLIDO', 'fecha_nac' => 'FECHA DE NACIMIENTO',
        'idgenero' => 'GÉNERO', 'idnacionalidad' => 'NACIONALIDAD',
    );
}

/** Lee y normaliza los campos enviados por el formulario. */
function per_leer_formulario(array $post)
{
    $ci = isset($post['ci']) ? preg_replace('/\D/', '', (string)$post['ci']) : '';
    return array(
        'ci'             => $ci,
        'complemento'    => per_complemento_normalizar(isset($post['complemento']) ? $post['complemento'] : ''),
        'exp'            => per_mayus(isset($post['exp']) ? $post['exp'] : ''),
        'nombre'         => per_mayus(isset($post['nombre']) ? $post['nombre'] : ''),
        'paterno'        => per_mayus(isset($post['paterno']) ? $post['paterno'] : ''),
        'materno'        => per_mayus(isset($post['materno']) ? $post['materno'] : ''),
        'fecha_nac'      => trim(isset($post['fecha_nac']) ? (string)$post['fecha_nac'] : ''),
        'idgenero'       => isset($post['idgenero']) ? (int)$post['idgenero'] : 0,
        'idnacionalidad' => isset($post['idnacionalidad']) ? (int)$post['idnacionalidad'] : 0,
    );
}

function per_validar($link, array $d)
{
    $e = array();
    if ($d['ci'] !== '' && strlen($d['ci']) > 10) {
        $e[] = 'El N° de cédula es demasiado largo.';
    }
    if (!per_complemento_valido($d['complemento'])) {
        $depto = per_depto_desde_texto($d['complemento']);
        if ($depto !== '') {
            $e[] = '"' . $d['complemento'] . '" es el lugar de expedición, no el complemento: elíjalo en EXPEDIDO y deje el complemento vacío.';
        } else {
            $e[] = 'El complemento debe tener 2 caracteres, un número y una letra (ej.: 1K). Si el carnet no tiene complemento, déjelo vacío.';
        }
    }
    if ($d['complemento'] !== '' && ($d['ci'] === '' || (int)$d['ci'] === 0)) {
        $e[] = 'No puede registrar complemento sin número de cédula.';
    }
    if ($d['exp'] !== '' && !isset(per_expedidos()[$d['exp']])) {
        $e[] = 'Seleccione el lugar de expedición de la lista.';
    }
    if ($d['nombre'] === '') {
        $e[] = 'Los NOMBRES son obligatorios.';
    }
    if ($d['paterno'] === '' && $d['materno'] === '') {
        $e[] = 'Debe registrar al menos un apellido.';
    }
    foreach (array('nombre', 'paterno', 'materno') as $c) {
        if (mb_strlen($d[$c], 'UTF-8') > 45) {
            $e[] = per_etiquetas()[$c] . ' supera 45 caracteres.';
        }
        if ($d[$c] !== '' && preg_match('/[0-9]/', $d[$c])) {
            $e[] = per_etiquetas()[$c] . ' no debe tener números.';
        }
    }
    $f = DateTime::createFromFormat('Y-m-d', $d['fecha_nac']);
    if (!$f || $f->format('Y-m-d') !== $d['fecha_nac']) {
        $e[] = 'La FECHA DE NACIMIENTO no es válida.';
    } elseif ($d['fecha_nac'] > date('Y-m-d') || $d['fecha_nac'] < '1900-01-01') {
        $e[] = 'La FECHA DE NACIMIENTO está fuera de rango.';
    }
    if (!per_fila($link, "SELECT idgenero FROM genero WHERE idgenero = ?", 'i', array($d['idgenero']))) {
        $e[] = 'Seleccione el GÉNERO.';
    }
    if (!per_fila($link, "SELECT idnacionalidad FROM nacionalidad WHERE idnacionalidad = ?", 'i', array($d['idnacionalidad']))) {
        $e[] = 'Seleccione la NACIONALIDAD.';
    }
    return $e;
}

/**
 * ¿El cambio de un nombre/apellido parece otra persona?
 * Se acepta: corregir letras (MAMNI -> MAMANI), completar (JUAN -> JUAN CARLOS), tildes, llenar un vacío.
 * Se advierte: borrar el dato o reemplazarlo por algo distinto (MAMANI -> FLORES).
 */
function per_cambio_grande_texto($antes, $despues)
{
    $a = per_sin_tildes($antes);
    $b = per_sin_tildes($despues);
    if ($a === $b || $a === '') {
        return false;
    }
    if ($b === '') {
        return true;
    }
    if (strpos($b, $a) !== false || strpos($a, $b) !== false) {
        return false;
    }
    $dist = levenshtein($a, $b);
    return $dist > 2 && ($dist / max(strlen($a), strlen($b))) > 0.4;
}

/** Valor tal como se compara/guarda en la bitácora. */
function per_valor_texto($campo, $valor)
{
    if ($valor === null) {
        return '';
    }
    if ($campo === 'ci' || $campo === 'idgenero' || $campo === 'idnacionalidad') {
        return ((int)$valor === 0) ? '' : (string)(int)$valor;
    }
    return (string)$valor;
}

/**
 * Tipo de cambio del CI:
 *   igual    sin cambio
 *   asigna   no tenía CI (0/vacío) y se le pone uno: niño que saca su carnet
 *   tipeo    1 o 2 dígitos distintos: error de escritura
 *   distinto un número totalmente diferente
 *   borra    tenía CI y se deja vacío
 */
function per_tipo_cambio_ci($ci_antes, $ci_nuevo)
{
    if ($ci_antes === $ci_nuevo) {
        return 'igual';
    }
    if ($ci_antes === '') {
        return 'asigna';
    }
    if ($ci_nuevo === '') {
        return 'borra';
    }
    return levenshtein($ci_antes, $ci_nuevo) <= 2 ? 'tipeo' : 'distinto';
}

/** ¿La persona está en una carpeta familiar o tiene atenciones? (sus datos no se pueden reemplazar por otra persona) */
function per_vinculos($link, $idnombre)
{
    $cf = per_fila($link, "SELECT idintegrante_cf FROM integrante_cf WHERE idnombre = ? LIMIT 1", 'i', array((int)$idnombre));
    $at = per_fila($link, "SELECT idatencion_psafci FROM atencion_psafci WHERE idnombre = ? LIMIT 1", 'i', array((int)$idnombre));
    return array('carpeta' => (bool)$cf, 'atencion' => (bool)$at);
}

/**
 * Regla "parece otra persona" (protege carpetas familiares e historias clínicas).
 * Devuelve array('bloqueos' => [], 'motivo' => '', 'advertencias' => []):
 *   - bloqueos (no se guarda, ni aceptando): cambian los NOMBRES o los dos apellidos por otros distintos y
 *     la persona está en una carpeta / tiene atenciones, o además cambia el CI por uno totalmente distinto.
 *   - advertencias (puede continuar): un apellido distinto, CI totalmente distinto o borrado,
 *     CI+complemento que ya usa otra persona; o cambio de nombres en una ficha sin carpeta ni atenciones.
 *   - sin aviso: asignar CI a quien tenía 0, corregir 1-2 dígitos, corregir letras, fecha y género.
 */
function per_revisar_cambio($link, $idnombre, array $antes, array $nuevo)
{
    $et     = per_etiquetas();
    $grande = array();
    foreach (array('nombre', 'paterno', 'materno') as $c) {
        if (per_cambio_grande_texto($antes[$c], $nuevo[$c])) {
            $grande[$c] = $et[$c] . ': "' . $antes[$c] . '" → "' . ($nuevo[$c] === '' ? '(vacío)' : $nuevo[$c]) . '"';
        }
    }
    $ci_antes = per_valor_texto('ci', $antes['ci']);
    $ci_nuevo = per_valor_texto('ci', $nuevo['ci']);
    $tipo_ci  = per_tipo_cambio_ci($ci_antes, $ci_nuevo);
    $texto_ci = $et['ci'] . ': ' . $ci_antes . ' → ' . ($ci_nuevo === '' ? '(vacío)' : $ci_nuevo);

    // Otra persona = nombres distintos, o los dos apellidos distintos (un solo apellido puede ser un reconocimiento)
    $otra_persona = isset($grande['nombre']) || count($grande) >= 2;
    if ($otra_persona) {
        $v = per_vinculos($link, $idnombre);
        $ci_tambien = ($tipo_ci === 'distinto' || $tipo_ci === 'borra');
        if ($v['carpeta'] || $v['atencion'] || $ci_tambien) {
            $bloqueos = array_values($grande);
            if ($ci_tambien) {
                $bloqueos[] = $texto_ci;
            }
            if ($v['carpeta'] && $v['atencion']) {
                $donde = 'pertenece a una carpeta familiar y tiene atenciones registradas';
            } elseif ($v['carpeta']) {
                $donde = 'pertenece a una carpeta familiar';
            } elseif ($v['atencion']) {
                $donde = 'tiene atenciones registradas';
            } else {
                $donde = '';
            }
            $motivo = $donde !== ''
                ? 'Esta persona ' . $donde . '. Si se reemplazan sus datos por los de otra persona, esa otra persona quedaría '
                  . ($v['carpeta'] ? 'dentro de la familia' : '') . ($v['carpeta'] && $v['atencion'] ? ' y ' : '')
                  . ($v['atencion'] ? 'con la historia clínica de esta' : '') . '.'
                : 'Se están cambiando a la vez los nombres y el número de cédula: eso es registrar a otra persona.';
            return array('bloqueos' => $bloqueos, 'motivo' => $motivo, 'advertencias' => array());
        }
    }

    $adv = array_values($grande);
    if ($tipo_ci === 'distinto' || $tipo_ci === 'borra') {
        $adv[] = $texto_ci;
    }
    // Solo si cambia CI o complemento: los duplicados que ya existían no deben impedir corregir un nombre
    $cambia_id = ($ci_antes !== $ci_nuevo) || (per_complemento_limpio($antes['complemento']) !== $nuevo['complemento']);
    if ($ci_nuevo !== '' && $cambia_id) {
        $otros = per_filas($link,
            "SELECT idnombre, nombre, paterno, materno, ci, complemento FROM nombre WHERE ci = ? AND idnombre <> ? LIMIT 10",
            'ii', array((int)$ci_nuevo, (int)$idnombre));
        foreach ($otros as $o) {
            if (per_complemento_limpio($o['complemento']) === $nuevo['complemento']) {
                $adv[] = 'Ya existe otra persona con el CI ' . per_ci_texto($o) . ': ' . per_nombre_completo($o);
            }
        }
    }
    return array('bloqueos' => array(), 'motivo' => '', 'advertencias' => $adv);
}

/**
 * Valida y guarda la corrección de una persona.
 * Devuelve array('estado' => 'ok' | 'sin_cambios' | 'error' | 'advertencia' | 'bloqueado',
 *                'errores' => [], 'advertencias' => [], 'bloqueos' => [], 'motivo' => '', 'cambios' => [])
 * 'bloqueado' no se puede saltar con $aceptar_advertencia.
 */
function per_guardar_correccion($link, $idnombre, array $post, $aceptar_advertencia, $modulo, $idusuario)
{
    $idnombre = (int)$idnombre;
    $antes = per_fila($link,
        "SELECT idnombre, ci, complemento, exp, nombre, paterno, materno, fecha_nac, idgenero, idnacionalidad FROM nombre WHERE idnombre = ?",
        'i', array($idnombre));
    if (!$antes) {
        return array('estado' => 'error', 'errores' => array('La persona no existe.'));
    }

    $nuevo   = per_leer_formulario($post);
    $errores = per_validar($link, $nuevo);
    if ($errores) {
        return array('estado' => 'error', 'errores' => $errores);
    }

    $cambios = array();
    foreach (array_keys(per_etiquetas()) as $campo) {
        $va = per_valor_texto($campo, $antes[$campo]);
        $vn = per_valor_texto($campo, $nuevo[$campo]);
        // Espacios sobrantes o minúsculas no son una corrección (no se registran en la bitácora)
        if (in_array($campo, array('nombre', 'paterno', 'materno', 'exp'), true) && per_mayus($va) === $vn) {
            continue;
        }
        if ($va !== $vn) {
            $cambios[$campo] = array($va, $vn);
        }
    }
    if (!$cambios) {
        return array('estado' => 'sin_cambios');
    }

    $revision = per_revisar_cambio($link, $idnombre, $antes, $nuevo);
    if ($revision['bloqueos']) {
        return array('estado' => 'bloqueado', 'bloqueos' => $revision['bloqueos'], 'motivo' => $revision['motivo']);
    }
    $advertencias = $revision['advertencias'];
    if ($advertencias && !$aceptar_advertencia) {
        return array('estado' => 'advertencia', 'advertencias' => $advertencias, 'cambios' => $cambios);
    }

    // CI vacío: se conserva NULL si ya era NULL; si no, 0 (como registra el resto del sistema)
    $ci_guardar = ($nuevo['ci'] === '') ? ($antes['ci'] === null ? null : 0) : (int)$nuevo['ci'];

    $eess = per_fila($link, "SELECT idestablecimiento_salud FROM dato_laboral WHERE idusuario = ? ORDER BY iddato_laboral DESC LIMIT 1", 'i', array((int)$idusuario));
    $eess = $eess ? (int)$eess['idestablecimiento_salud'] : null;
    $marca = $advertencias ? 'SI' : 'NO';
    $fecha = date('Y-m-d');
    $hora  = date('H:i:s');

    mysqli_begin_transaction($link);
    try {
        per_ejecutar($link,
            "UPDATE nombre SET ci = ?, complemento = ?, exp = ?, nombre = ?, paterno = ?, materno = ?,
                    fecha_nac = ?, idgenero = ?, idnacionalidad = ?
              WHERE idnombre = ?",
            'issssssiii',
            array($ci_guardar, $nuevo['complemento'], $nuevo['exp'], $nuevo['nombre'], $nuevo['paterno'], $nuevo['materno'],
                  $nuevo['fecha_nac'], $nuevo['idgenero'], $nuevo['idnacionalidad'], $idnombre));
        foreach ($cambios as $campo => $par) {
            per_ejecutar($link,
                "INSERT INTO nombre_correccion (idnombre, campo, valor_anterior, valor_nuevo, advertencia_aceptada, modulo,
                        idusuario, idestablecimiento_salud, fecha_registro, hora_registro)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
                'isssssiiss',
                array($idnombre, $campo, mb_substr($par[0], 0, 120, 'UTF-8'), mb_substr($par[1], 0, 120, 'UTF-8'), $marca, $modulo,
                      (int)$idusuario, $eess, $fecha, $hora));
        }
        mysqli_commit($link);
    } catch (Throwable $e) {
        mysqli_rollback($link);
        error_log("[correccion_persona] idnombre=$idnombre usuario=$idusuario: " . $e->getMessage());
        return array('estado' => 'error', 'errores' => array('No se pudo guardar la corrección. Intente nuevamente.'));
    }
    return array('estado' => 'ok', 'cambios' => $cambios, 'advertencias' => $advertencias);
}

/* ------------------------------------------------------------------ */
/* Formulario de datos personales (compartido)                         */
/* ------------------------------------------------------------------ */

/**
 * Campos del formulario de corrección precargados con la persona.
 * Si el complemento guardado no es válido se precarga ya corregido y se avisa.
 * $clase_titulo: 'text-info' (carpetas) o 'text-primary' (historias clínicas).
 */
function per_form_campos($link, array $p, $clase_titulo = 'text-primary', $sufijo_id = '')
{
    $analisis = per_analizar_complemento($p['complemento']);
    $exp      = per_expedido_codigo($p['exp']);
    if ($exp === '' && $analisis['exp_sugerido'] !== '') {
        $exp = $analisis['exp_sugerido'];
    }
    $ci  = ((int)$p['ci'] === 0) ? '' : (int)$p['ci'];
    $t   = per_h($clase_titulo);
    $sid = per_h($sufijo_id);

    $generos = per_filas($link, "SELECT idgenero, genero FROM genero ORDER BY idgenero");
    $nacs    = per_filas($link, "SELECT idnacionalidad, nacionalidad FROM nacionalidad ORDER BY idnacionalidad");

    ob_start();
    ?>
    <div class="form-group row">
        <div class="col-sm-3">
            <h6 class="<?php echo $t; ?>">N° CÉDULA:</h6>
            <input type="number" min="0" class="form-control" name="ci" value="<?php echo per_h($ci); ?>">
        </div>
        <div class="col-sm-3">
            <h6 class="<?php echo $t; ?>">COMPLEMENTO:</h6>
            <input type="text" class="form-control per-complemento" name="complemento" maxlength="3" autocomplete="off"
                   value="<?php echo per_h($analisis['complemento']); ?>" placeholder="Ej.: 1K"
                   title="Solo si el carnet lo tiene: 2 caracteres, un número y una letra (1234567-1K). No es el departamento.">
            <small class="form-text text-muted">Solo si el carnet lo tiene. <b>No es el departamento.</b></small>
        </div>
        <div class="col-sm-3">
            <h6 class="<?php echo $t; ?>">EXPEDIDO:</h6>
            <select name="exp" class="form-control per-exp">
                <option value="">-SIN DATO-</option>
                <?php foreach (per_expedidos() as $cod => $dep) { ?>
                <option value="<?php echo $cod; ?>" <?php if ($cod === $exp) echo 'selected'; ?>><?php echo $cod . ' - ' . per_h($dep); ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-sm-3"></div>
    </div>
    <?php if ($analisis['invalido']) { ?>
    <div class="alert alert-warning py-2 small">
        <i class="fas fa-exclamation-triangle"></i>
        El complemento registrado <b>"<?php echo per_h($analisis['original']); ?>"</b> no es válido:
        <?php echo per_h($analisis['motivo']); ?>. Revise y guarde para corregirlo.
    </div>
    <?php } ?>
    <div class="form-group row">
        <div class="col-sm-4">
            <h6 class="<?php echo $t; ?>">NOMBRES:</h6>
            <input type="text" class="form-control" name="nombre" maxlength="45" value="<?php echo per_h($p['nombre']); ?>" required>
        </div>
        <div class="col-sm-4">
            <h6 class="<?php echo $t; ?>">PRIMER APELLIDO:</h6>
            <input type="text" class="form-control" name="paterno" maxlength="45" value="<?php echo per_h($p['paterno']); ?>">
        </div>
        <div class="col-sm-4">
            <h6 class="<?php echo $t; ?>">SEGUNDO APELLIDO:</h6>
            <input type="text" class="form-control" name="materno" maxlength="45" value="<?php echo per_h($p['materno']); ?>">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-4">
            <h6 class="<?php echo $t; ?>">GÉNERO:</h6>
            <select name="idgenero" class="form-control" required>
                <option value="">-SELECCIONE-</option>
                <?php foreach ($generos as $g) { ?>
                <option value="<?php echo (int)$g['idgenero']; ?>" <?php if ((int)$g['idgenero'] === (int)$p['idgenero']) echo 'selected'; ?>><?php echo per_h($g['genero']); ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-sm-4">
            <h6 class="<?php echo $t; ?>">FECHA DE NACIMIENTO:</h6>
            <input type="date" class="form-control" name="fecha_nac" max="<?php echo date('Y-m-d'); ?>" value="<?php echo per_h($p['fecha_nac']); ?>" required>
        </div>
        <div class="col-sm-4">
            <h6 class="<?php echo $t; ?>">NACIONALIDAD:</h6>
            <select name="idnacionalidad" class="form-control" required>
                <option value="">-SELECCIONE-</option>
                <?php foreach ($nacs as $n) { ?>
                <option value="<?php echo (int)$n['idnacionalidad']; ?>" <?php if ((int)$n['idnacionalidad'] === (int)$p['idnacionalidad']) echo 'selected'; ?>><?php echo per_h($n['nacionalidad']); ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Script del campo complemento: normaliza "1-k" a "1K" y, si escriben un departamento,
 * lo pasa a EXPEDIDO y vacía el complemento. Se imprime una vez por página (después de jQuery o sin él).
 */
function per_js_complemento()
{
    ob_start();
    ?>
    <script>
    (function () {
        var deptos = {LP:['LP','LPZ','LAPAZ'],OR:['OR','ORU','ORURO'],PT:['PT','PO','PTS','POT','POTOSI'],
            CB:['CB','CBB','CBBA','CBA','COCHABAMBA'],CH:['CH','CHQ','CHU','CHUQ','CHUQUISACA','SUCRE'],
            TJ:['TJ','TJA','TAR','TARIJA'],SC:['SC','SCZ','STACRUZ','SANTACRUZ'],BE:['BE','BN','BEN','BENI'],PD:['PD','PA','PAN','PANDO']};
        function depto(txt) {
            var t = txt.toUpperCase().normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/[^A-Z]/g, '');
            for (var k in deptos) { if (deptos[k].indexOf(t) >= 0) return k; }
            return '';
        }
        function revisar(inp) {
            var v = inp.value.toUpperCase().replace(/[\s\-\.\/_]/g, '');
            var form = inp.closest('form') || document;
            var exp = form.querySelector('.per-exp');
            var d = depto(inp.value);
            inp.setCustomValidity('');
            inp.classList.remove('is-invalid');
            if (v === '') { inp.value = ''; return; }
            if (/^([0-9][A-Z]|[A-Z][0-9])$/.test(v)) { inp.value = v; return; }
            if (d && exp) {
                exp.value = d;
                inp.value = '';
                alert('"' + v + '" es el lugar de expedición, no el complemento. Se seleccionó en EXPEDIDO.');
                return;
            }
            inp.setCustomValidity('El complemento debe tener un número y una letra (ej.: 1K).');
            inp.classList.add('is-invalid');
        }
        document.addEventListener('change', function (e) {
            if (e.target && e.target.classList && e.target.classList.contains('per-complemento')) revisar(e.target);
        });
    })();
    </script>
    <?php
    return ob_get_clean();
}

/* ------------------------------------------------------------------ */
/* Vista de resultados de búsqueda por CI (compartida)                 */
/*   carpetas_familiares/persona_encontrada.php      color 'info'      */
/*   produccion_servicios/persona_encontrada_hc.php  color 'primary'   */
/* ------------------------------------------------------------------ */

/** Estilos de las tarjetas (imprimir una vez, dentro de <head>). */
function per_css_tarjetas()
{
    return '<style>
        .tarjeta-persona.coincide { border-left: .25rem solid #1cc88a !important; }
        .tarjeta-persona .dato h6 { font-size: .75rem; margin-bottom: .2rem; }
        .tarjeta-persona .dato .valor { font-weight: bold; color: #3a3b45; overflow-wrap: normal; word-break: normal; }
        .tarjeta-persona .dato .sin-dato { font-size: .8rem; font-weight: normal; color: #858796; }
        .tarjeta-persona.recien-guardada { box-shadow: 0 0 0 .2rem rgba(28,200,138,.5) !important; transition: box-shadow 1s; }

        /* Ventana de corrección: centrada, 10% más ancha que modal-lg (800px) y arrastrable.
           Letras, campos y botones del mismo tamaño que la página; solo los espacios verticales son algo menores. */
        .modal-persona-dialog { max-width: 880px; }
        .modal-persona .modal-header { cursor: move; padding: .75rem 1.25rem; user-select: none; }
        .modal-persona .modal-header .close { cursor: pointer; }
        .modal-persona .modal-title { font-size: 1.1rem; }
        .modal-persona .modal-body { padding: .75rem 1.25rem; }
        .modal-persona .modal-footer { padding: .6rem 1.25rem; }
        .modal-persona .form-group { margin-bottom: .6rem; }
        .modal-persona h6 { margin-bottom: .25rem; }
        .modal-persona .form-text { margin-top: .1rem; }
        .modal-persona .alert { padding: .5rem 1rem; margin-bottom: .6rem; }

        /* Aviso "Cambios guardados" (después de recargar) */
        .aviso-guardado { position: fixed; top: 90px; left: 50%; z-index: 1080; min-width: 320px;
            background: #1cc88a; color: #fff; border-radius: .35rem; padding: .9rem 1.25rem; text-align: center;
            box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.25); opacity: 0; transform: translate(-50%, -12px);
            transition: opacity .3s, transform .3s, visibility .3s; cursor: pointer;
            visibility: hidden; pointer-events: none; }   /* oculto no debe tapar clics (p. ej. el enlace VOLVER) */
        .aviso-guardado.visible { opacity: 1; transform: translate(-50%, 0); visibility: visible; pointer-events: auto; }
        .aviso-guardado b { font-size: 1.1rem; }
        .aviso-guardado.info { background: #36b9cc; }
    </style>';
}

/**
 * Ventana (modal) de corrección de datos personales de una persona de la búsqueda.
 * $token: token de la búsqueda (per_token_crear); $color: color de títulos del módulo.
 */
function per_modal_correccion($link, array $p, $token, $color = 'primary')
{
    $id = (int)$p['idnombre'];
    ob_start();
    ?>
    <div class="modal fade modal-persona" id="modalCorregir<?php echo $id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-persona-dialog" role="document">
            <div class="modal-content">
                <form class="form-corregir-persona" novalidate>
                    <input type="hidden" name="b" value="<?php echo per_h($token); ?>">
                    <input type="hidden" name="idnombre" value="<?php echo $id; ?>">
                    <input type="hidden" name="aceptar_advertencia" value="NO">
                    <div class="modal-header" title="Arrastre para mover la ventana">
                        <h6 class="modal-title font-weight-bold text-<?php echo per_h($color); ?> m-0">
                            CORREGIR DATOS PERSONALES
                        </h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p class="small text-muted mb-2">Corrija errores de escritura o datos incompletos. Los cambios quedan registrados con su usuario.</p>
                        <?php echo per_form_campos($link, $p, 'text-' . $color, (string)$id); ?>
                        <div class="alert alert-danger d-none caja-errores"></div>
                        <div class="alert alert-danger d-none caja-bloqueo">
                            <b><i class="fas fa-ban"></i> No se puede guardar: esto parece otra persona.</b>
                            <ul class="mb-1 lista-bloqueos"></ul>
                            <span class="texto-motivo"></span>
                            <b>Si es otra persona, regístrela como nueva.</b> Si es la misma persona, corrija solo los datos mal escritos.
                            <div class="mt-1"><button type="button" class="btn btn-sm btn-secondary btn-revisar">REVISAR</button></div>
                        </div>
                        <div class="alert alert-warning d-none caja-advertencia">
                            <b><i class="fas fa-exclamation-triangle"></i> Este cambio parece otra persona.</b>
                            <ul class="mb-1 lista-advertencias"></ul>
                            ¿Desea continuar de todos modos?
                            <button type="button" class="btn btn-sm btn-warning btn-continuar ml-2">SÍ, CONTINUAR</button>
                            <button type="button" class="btn btn-sm btn-secondary btn-revisar">REVISAR</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-warning btn-guardar">GUARDAR CORRECCIÓN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Paginación de las tarjetas de resultados (5 por página), con el mismo diseño que las tablas
 * DataTables del sistema (p. ej. produccion_servicios/atenciones_psafci.php): texto "Mostrando…" a la
 * izquierda y "Anterior 1 2 … Siguiente" a la derecha. Requiere dataTables.bootstrap4.min.css.
 * Solo aparece con más de $por_pagina resultados. Con ?ok=idnombre (después de corregir) abre la página
 * de esa persona. Imprimir ANTES de per_js_correccion.
 */
function per_js_paginacion($por_pagina = 5)
{
    ob_start();
    ?>
    <script>
    (function () {
        var POR_PAGINA = <?php echo (int)$por_pagina; ?>;
        var tarjetas = Array.prototype.slice.call(document.querySelectorAll('.tarjeta-persona'));
        if (tarjetas.length <= POR_PAGINA) return;
        var paginas = Math.ceil(tarjetas.length / POR_PAGINA), actual = 0;

        // Mismo marcado que DataTables + Bootstrap 4
        var caja = document.createElement('div');
        caja.className = 'dataTables_wrapper dt-bootstrap4 paginacion-personas mb-4';
        caja.innerHTML = '<div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" role="status" aria-live="polite"></div></div>'
                       + '<div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers"><ul class="pagination"></ul></div></div></div>';
        var ultima = tarjetas[tarjetas.length - 1];
        ultima.parentNode.insertBefore(caja, ultima.nextSibling);
        var info = caja.querySelector('.dataTables_info'), lista = caja.querySelector('.pagination');

        // Botones numéricos como DataTables (máximo 7, con "…")
        function numeros() {
            var r = [], i;
            if (paginas <= 7) { for (i = 0; i < paginas; i++) r.push(i); }
            else if (actual <= 3) { for (i = 0; i < 5; i++) r.push(i); r.push('…', paginas - 1); }
            else if (actual >= paginas - 4) { r.push(0, '…'); for (i = paginas - 5; i < paginas; i++) r.push(i); }
            else { r.push(0, '…', actual - 1, actual, actual + 1, '…', paginas - 1); }
            return r;
        }
        function boton(texto, pagina, clase, deshabilitado, activo) {
            return '<li class="paginate_button page-item ' + clase + (deshabilitado ? ' disabled' : '') + (activo ? ' active' : '') + '">'
                 + '<a href="#" class="page-link"' + (pagina === null ? '' : ' data-pagina="' + pagina + '"') + '>' + texto + '</a></li>';
        }
        function mostrar(p, subir) {
            actual = Math.max(0, Math.min(paginas - 1, p));
            tarjetas.forEach(function (t, i) { t.style.display = Math.floor(i / POR_PAGINA) === actual ? '' : 'none'; });
            var desde = actual * POR_PAGINA + 1, hasta = Math.min(tarjetas.length, desde + POR_PAGINA - 1);
            info.textContent = 'Mostrando personas de ' + desde + ' al ' + hasta + ' de un total de ' + tarjetas.length + ' personas';
            var h = boton('Anterior', actual - 1, 'previous', actual === 0, false);
            numeros().forEach(function (n) { h += n === '…' ? boton('…', null, '', true, false) : boton(n + 1, n, '', false, n === actual); });
            h += boton('Siguiente', actual + 1, 'next', actual === paginas - 1, false);
            lista.innerHTML = h;
            if (subir) {
                // Al inicio de los resultados
                var primera = tarjetas[actual * POR_PAGINA];
                var y = primera.getBoundingClientRect().top + window.pageYOffset - 90;
                window.scrollTo({ top: Math.max(0, y), behavior: 'smooth' });
            }
        }
        lista.addEventListener('click', function (e) {
            var a = e.target.closest('a');
            if (!a) return;
            e.preventDefault();
            if (a.parentNode.classList.contains('disabled') || a.parentNode.classList.contains('active') || !a.hasAttribute('data-pagina')) return;
            mostrar(parseInt(a.getAttribute('data-pagina'), 10), true);
        });

        // Después de corregir (?ok=id): la página donde está esa persona
        var ok = new URLSearchParams(window.location.search).get('ok'), inicial = 0;
        if (ok) {
            tarjetas.forEach(function (t, i) { if (t.id === 'persona' + ok) inicial = Math.floor(i / POR_PAGINA); });
        }
        mostrar(inicial, false);
    })();
    </script>
    <?php
    return ob_get_clean();
}

/**
 * Script de las ventanas de corrección (guardar por AJAX, advertencia "¿continuar?", arrastrar,
 * aviso "Cambios guardados"). Requiere jQuery (solo $.ajax / serialize).
 * $url_guardar: comun/corregir_persona.php relativo a la página; $pagina: página de resultados (recarga con ?b=&ok=);
 * $url_expirado: a dónde ir si la búsqueda expiró.
 */
function per_js_correccion($url_guardar, $pagina, $url_expirado)
{
    $cfg = json_encode(array('guardar' => $url_guardar, 'pagina' => $pagina, 'expirado' => $url_expirado), JSON_UNESCAPED_SLASHES);
    ob_start();
    ?>
    <div class="aviso-guardado" id="avisoGuardado" title="Clic para cerrar"><i class="fas fa-check-circle mr-1"></i> <b class="aviso-titulo">Cambios guardados</b><div class="small aviso-texto">Los datos de la persona fueron actualizados y quedaron registrados.</div></div>
    <script>
    (function () {
        var CFG = <?php echo $cfg; ?>;
        // Las ventanas se mueven al final de <body>: así no quedan detrás del fondo oscuro
        // cuando la página las dibuja dentro de tarjetas o contenedores.
        document.querySelectorAll('.modal-persona').forEach(function (m) { document.body.appendChild(m); });
        function esc(t) { var d = document.createElement('div'); d.textContent = t; return d.innerHTML; }
        function mostrar(el, si) { if (el) el.classList.toggle('d-none', !si); }

        // Zona de datos de la página (la tarjeta grande): ventana y aviso se centran sobre ella, no sobre la pantalla
        function zona() {
            var t = document.querySelector('.tarjeta-persona');
            return (t && (t.closest('.card.o-hidden') || t.closest('.container'))) || document.getElementById('content') || document.body;
        }
        function centroZona() { var r = zona().getBoundingClientRect(); return r.left + r.width / 2; }

        // Aviso sobre la página del fondo
        var aviso = document.getElementById('avisoGuardado'), avisoTimer = null;
        function avisar(tipo, titulo, texto) {
            aviso.classList.toggle('info', tipo === 'info');
            aviso.querySelector('i').className = (tipo === 'info' ? 'fas fa-info-circle' : 'fas fa-check-circle') + ' mr-1';
            aviso.querySelector('.aviso-titulo').textContent = titulo;
            aviso.querySelector('.aviso-texto').textContent = texto;
            aviso.style.left = centroZona() + 'px';
            clearTimeout(avisoTimer);
            setTimeout(function () { aviso.classList.add('visible'); }, 150);
            avisoTimer = setTimeout(function () { aviso.classList.remove('visible'); }, 7000);
        }
        aviso.addEventListener('click', function () { aviso.classList.remove('visible'); });

        function cerrarVentana(form) {
            var x = form.closest('.modal') && form.closest('.modal').querySelector('[data-dismiss="modal"]');
            if (x) x.click();
        }

        function enviar(form, aceptar) {
            form.querySelector('[name="aceptar_advertencia"]').value = aceptar ? 'SI' : 'NO';
            ['.caja-errores', '.caja-advertencia', '.caja-bloqueo'].forEach(function (s) { mostrar(form.querySelector(s), false); });
            var botones = form.querySelectorAll('.btn-guardar, .btn-continuar');
            botones.forEach(function (b) { b.disabled = true; });
            jQuery.ajax({ url: CFG.guardar, method: 'POST', data: jQuery(form).serialize(), dataType: 'json' })
                .done(function (r) {
                    if (r.expirado) { window.location.href = CFG.expirado; return; }
                    if (r.estado === 'sin_cambios') {
                        // La ventana se cierra y el aviso sale en la página del fondo
                        cerrarVentana(form);
                        avisar('info', 'Sin cambios', 'Los datos son iguales a los registrados; no se modificó nada.');
                        return;
                    }
                    if (r.estado === 'ok') {
                        // La ventana se cierra y la lista se recarga con el aviso "Cambios guardados"
                        cerrarVentana(form);
                        window.location.href = CFG.pagina + '?b=' + encodeURIComponent(form.querySelector('[name="b"]').value)
                                + '&ok=' + encodeURIComponent(form.querySelector('[name="idnombre"]').value);
                        botones = [];   // quedan deshabilitados hasta recargar
                        return;
                    }
                    if (r.estado === 'bloqueado') {
                        // Protege la carpeta familiar / historia clínica: no hay "continuar"
                        var lb = form.querySelector('.lista-bloqueos'), hb = '';
                        (r.bloqueos || []).forEach(function (a) { hb += '<li>' + esc(a) + '</li>'; });
                        lb.innerHTML = hb;
                        form.querySelector('.texto-motivo').textContent = (r.motivo || '') + ' ';
                        mostrar(form.querySelector('.caja-bloqueo'), true);
                    } else if (r.estado === 'advertencia') {
                        var l = form.querySelector('.lista-advertencias'), html = '';
                        (r.advertencias || []).forEach(function (a) { html += '<li>' + esc(a) + '</li>'; });
                        l.innerHTML = html;
                        mostrar(form.querySelector('.caja-advertencia'), true);
                    } else {
                        var h = '<ul class="mb-0">';
                        (r.errores || ['No se pudo guardar.']).forEach(function (e) { h += '<li>' + esc(e) + '</li>'; });
                        var c = form.querySelector('.caja-errores'); c.innerHTML = h + '</ul>'; mostrar(c, true);
                    }
                })
                .fail(function () {
                    var c = form.querySelector('.caja-errores');
                    c.innerHTML = 'No se pudo comunicar con el servidor. Intente nuevamente.'; mostrar(c, true);
                })
                .always(function () { botones.forEach(function (b) { b.disabled = false; }); });
        }

        document.addEventListener('submit', function (e) {
            var f = e.target;
            if (!f.classList || !f.classList.contains('form-corregir-persona')) return;
            e.preventDefault();
            if (!f.checkValidity()) { f.reportValidity(); return; }
            enviar(f, false);
        });
        document.addEventListener('click', function (e) {
            var t = e.target.closest ? e.target.closest('.btn-continuar, .btn-revisar, [data-toggle="modal"]') : null;
            if (!t) return;
            if (t.classList.contains('btn-continuar')) { enviar(t.closest('form'), true); }
            else if (t.classList.contains('btn-revisar')) { mostrar(t.closest('.caja-advertencia, .caja-bloqueo'), false); }
            else {
                // Al abrir: centrada sobre la zona de datos (horizontal) y en el centro vertical de la pantalla
                var m = document.querySelector(t.getAttribute('data-target'));
                var d = m ? m.querySelector('.modal-persona-dialog') : null;
                if (d) {
                    d.style.transition = 'none';   // sin animación de Bootstrap: se mueve a la par del cursor
                    d.style.transform = 'translate(0px,0px)';
                    d.dataset.x = 0; d.dataset.y = 0;
                    // Se mide cuando la ventana ya está abierta (Bootstrap reacomoda la página al abrirla)
                    var intentos = 0;
                    var centrar = function () {
                        var r = d.querySelector('.modal-content').getBoundingClientRect();
                        if (!r.width) {   // todavía no visible (Bootstrap espera el fondo oscuro)
                            if (++intentos < 60) requestAnimationFrame(centrar);
                            return;
                        }
                        var dx = Math.round(+d.dataset.x + centroZona() - (r.left + r.width / 2));
                        d.style.transform = 'translate(' + dx + 'px,0px)';
                        d.dataset.x = dx;
                    };
                    requestAnimationFrame(centrar);
                }
            }
        });

        // Arrastrar la ventana desde su barra de título (sigue al cursor sin retraso)
        var arrastre = null, pendiente = null;
        document.addEventListener('mousedown', function (e) {
            var cab = e.target.closest ? e.target.closest('.modal-persona .modal-header') : null;
            if (!cab || e.target.closest('.close') || e.button !== 0) return;
            var d = cab.closest('.modal-persona-dialog');
            d.style.transition = 'none';
            arrastre = { d: d, x0: e.clientX, y0: e.clientY, x: +(d.dataset.x || 0), y: +(d.dataset.y || 0), nx: +(d.dataset.x || 0), ny: +(d.dataset.y || 0) };
            e.preventDefault();
        });
        document.addEventListener('mousemove', function (e) {
            if (!arrastre) return;
            arrastre.nx = arrastre.x + e.clientX - arrastre.x0;
            arrastre.ny = arrastre.y + e.clientY - arrastre.y0;
            if (!pendiente) {
                pendiente = requestAnimationFrame(function () {
                    pendiente = null;
                    if (arrastre) arrastre.d.style.transform = 'translate(' + arrastre.nx + 'px,' + arrastre.ny + 'px)';
                });
            }
        });
        document.addEventListener('mouseup', function () {
            if (!arrastre) return;
            arrastre.d.style.transform = 'translate(' + arrastre.nx + 'px,' + arrastre.ny + 'px)';
            arrastre.d.dataset.x = arrastre.nx;
            arrastre.d.dataset.y = arrastre.ny;
            arrastre = null;
        });

        // Aviso "Cambios guardados" (sobre la página, después de recargar) y resaltado de la tarjeta corregida
        var ok = new URLSearchParams(window.location.search).get('ok');
        if (ok) {
            avisar('ok', 'Cambios guardados', 'Los datos de la persona fueron actualizados y quedaron registrados.');
            var tarjeta = document.getElementById('persona' + ok);
            if (tarjeta) {
                tarjeta.classList.add('recien-guardada');
                tarjeta.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(function () { tarjeta.classList.remove('recien-guardada'); }, 3500);
            }
            // Quita ?ok de la dirección para que al recargar no vuelva a aparecer el aviso
            if (window.history && history.replaceState) {
                var u = new URL(window.location.href); u.searchParams.delete('ok'); history.replaceState(null, '', u.toString());
            }
        }
    })();
    </script>
    <?php
    return ob_get_clean();
}

/**
 * Encabezado del resultado: cédula buscada, complemento, fecha y cantidad de personas.
 * Si el usuario ingresó complemento o fecha de nacimiento y NINGUNA persona con ese CI coincide,
 * se muestra una alerta roja (puede ser un error en los datos registrados o una persona diferente).
 */
function per_resultado_encabezado($ci, $complemento, $fecha_nac, array $personas, $instruccion, $color = 'info')
{
    $c        = per_h($color);
    $cantidad = count($personas);
    $hay_comp = false;
    $hay_fn   = false;
    foreach ($personas as $p) {
        $hay_comp = $hay_comp || $p['coincide_complemento'];
        $hay_fn   = $hay_fn || $p['coincide_fecha'];
    }
    $no_coincide = array();
    if ($cantidad > 0 && $complemento !== '' && !$hay_comp) {
        $no_coincide[] = 'el complemento <b>' . per_h($complemento) . '</b>';
    }
    if ($cantidad > 0 && $fecha_nac !== '' && !$hay_fn) {
        $no_coincide[] = 'la fecha de nacimiento <b>' . per_h(date('d/m/Y', strtotime($fecha_nac))) . '</b>';
    }
    $texto_cantidad = $cantidad === 1 ? 'Se encontró 1 persona con este CI' : 'Se encontraron ' . (int)$cantidad . ' personas con este CI';
    ob_start();
    ?>
    <div class="text-center">
        <h4 class="text-<?php echo $c; ?>">RESULTADO DE LA BÚSQUEDA:</h4>
        <p class="mb-1">
            Cédula: <b><?php echo per_h($ci); ?></b>
            <?php if ($complemento !== '') { ?> &middot; Complemento: <b><?php echo per_h($complemento); ?></b><?php } ?>
            <?php if ($fecha_nac !== '') { ?> &middot; Fecha de nacimiento: <b><?php echo per_h(date('d/m/Y', strtotime($fecha_nac))); ?></b><?php } ?>
        </p>
        <?php if ($no_coincide) { ?>
        <div class="alert alert-danger text-left mx-auto my-2" style="max-width: 820px;">
            <i class="fas fa-exclamation-triangle"></i>
            <b>Atención:</b> <?php echo $texto_cantidad; ?>, pero <b>ninguna coincide</b> con <?php echo implode(' ni con ', $no_coincide); ?> que ingresó.
            Verifique con el paciente antes de continuar: puede ser un error en los datos registrados (corríjalos) o una persona diferente.
        </div>
        <?php } elseif ($cantidad > 0) { ?>
        <p class="text-muted small">
            <?php echo $cantidad === 1 ? 'Se encontró 1 persona.' : 'Se encontraron ' . (int)$cantidad . ' personas con este número.'; ?>
            <?php echo per_h($instruccion); ?>
        </p>
        <?php } ?>
    </div>
    <?php
    return ob_get_clean();
}

/** Encabezado del resultado de la búsqueda por nombres y apellidos. */
function per_resultado_encabezado_nombre(array $ctx, array $personas, $instruccion, $color = 'info')
{
    $c        = per_h($color);
    $cantidad = count($personas);
    $total    = isset($ctx['total']) ? (int)$ctx['total'] : $cantidad;
    $hay_fn   = false;
    foreach ($personas as $p) {
        $hay_fn = $hay_fn || $p['coincide_fecha'];
    }
    $datos = array('Nombres: <b>' . per_h($ctx['nombre']) . '</b>');
    if ($ctx['paterno'] !== '' || $ctx['materno'] !== '') {
        $datos[] = 'Apellidos: <b>' . per_h(trim($ctx['paterno'] . ' ' . $ctx['materno'])) . '</b>';
    } else {
        $datos[] = '<small class="text-muted">sin apellidos</small>';
    }
    if ($ctx['fecha_nac'] !== '') {
        $datos[] = 'Fecha de nacimiento: <b>' . per_h(date('d/m/Y', strtotime($ctx['fecha_nac']))) . '</b>';
    }
    ob_start();
    ?>
    <div class="text-center">
        <h4 class="text-<?php echo $c; ?>">RESULTADO DE LA BÚSQUEDA:</h4>
        <p class="mb-1"><?php echo implode(' &middot; ', $datos); ?></p>
        <?php if (!empty($ctx['ci_no_encontrado'])) { ?>
        <div class="alert alert-info text-left mx-auto my-2" style="max-width: 820px;">
            <i class="fas fa-info-circle"></i>
            La cédula <b><?php echo (int)$ctx['ci_no_encontrado']; ?></b> no está registrada; se muestran las personas con los nombres que escribió.
            Si es la persona correcta, puede registrarle la cédula corrigiendo sus datos.
        </div>
        <?php } ?>
        <?php if ($total > $cantidad) { ?>
        <div class="alert alert-warning text-left mx-auto my-2" style="max-width: 820px;">
            <i class="fas fa-exclamation-triangle"></i>
            Se encontraron <b><?php echo (int)$total; ?> personas</b>; se muestran las primeras <?php echo (int)$cantidad; ?>.
            Para encontrar a la persona correcta agregue el segundo apellido o la fecha de nacimiento.
        </div>
        <?php } ?>
        <?php if ($cantidad > 0 && $ctx['fecha_nac'] !== '' && !$hay_fn) { ?>
        <div class="alert alert-danger text-left mx-auto my-2" style="max-width: 820px;">
            <i class="fas fa-exclamation-triangle"></i>
            <b>Atención:</b> ninguna persona con esos nombres <b>coincide</b> con la fecha de nacimiento que ingresó.
            Verifique con el paciente antes de continuar: puede ser un error en los datos registrados (corríjalos) o una persona diferente.
        </div>
        <?php } elseif ($cantidad > 0 && $total <= $cantidad) { ?>
        <p class="text-muted small">
            <?php echo $cantidad === 1 ? 'Se encontró 1 persona.' : 'Se encontraron ' . (int)$cantidad . ' personas.'; ?>
            <?php echo per_h($instruccion); ?>
        </p>
        <?php } ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Tarjeta de una persona encontrada (fila de per_buscar_ci).
 * $op: color ('info'|'primary'), ultima_atencion (bool), botones (HTML ya escapado del módulo),
 *      editar (id del modal de corrección: enlace discreto "Corregir datos" dentro del recuadro de datos),
 *      historia (bool: enlace "Historia clínica" debajo de "Corregir datos").
 */
function per_tarjeta_persona(array $p, array $op = array())
{
    $c        = per_h(isset($op['color']) ? $op['color'] : 'info');
    $atencion = !empty($op['ultima_atencion']);
    $botones  = isset($op['botones']) ? $op['botones'] : '';
    $editar   = isset($op['editar']) ? (string)$op['editar'] : '';
    $enlaces  = array();
    if (!empty($op['historia'])) {
        // Mismo botón y destino que HISTORIA CLÍNICA de produccion_servicios/mostrar_atencion_psafci.php (arriba)
        $enlaces[] = '<a class="btn btn-info btn-icon-split enlace-historia" href="../produccion_servicios/imprime_historia_clinica_ps.php?idnombre_integrante=' . (int)$p['idnombre'] . '" target="_blank"'
                   . ' title="Ver el historial de atenciones del paciente"'
                   . ' onclick="window.open(this.href, this.target, \'width=1000,height=1000,top=50,left=400,scrollbars=YES\'); return false;">'
                   . '<span class="icon text-white-50"><i class="fas fa-book"></i></span><span class="text">HISTORIA CLÍNICA</span></a>';
    }
    if ($editar !== '') {
        // Enlace discreto para corregir datos (debajo)
        // Azul (text-primary); el amarillo lo usa la insignia de la carpeta familiar
        $enlaces[] = '<a href="#" class="small font-weight-bold text-primary enlace-editar" data-toggle="modal" data-target="#' . per_h($editar) . '"'
                   . ' title="Corregir errores de escritura o datos incompletos"><i class="fas fa-edit"></i> Corregir datos</a>';
    }
    $comp     = per_complemento_limpio($p['complemento']);
    $coincide = $p['coincide_complemento'] || $p['coincide_fecha'];

    $dato = function ($col, $titulo, $valor_html) use ($c) {
        return '<div class="col-sm-' . $col . ' mb-2 dato"><h6 class="text-' . $c . '">' . $titulo . '</h6><div class="valor">' . $valor_html . '</div></div>';
    };
    ob_start();
    ?>
    <div class="card shadow mb-4 tarjeta-persona <?php if ($coincide) echo 'coincide'; ?>" id="persona<?php echo (int)$p['idnombre']; ?>">
        <div class="card-header py-3 d-flex flex-wrap align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-<?php echo $c; ?>">
                <?php echo per_h(per_nombre_completo($p)); ?>
                <span class="text-gray-600 font-weight-normal">&middot; CI <?php echo per_h($p['ci_texto']); ?></span>
            </h6>
            <div>
                <?php if ($p['coincide_complemento']) { ?><span class="badge badge-success"><i class="fas fa-check"></i> Coincide complemento</span><?php } ?>
                <?php if ($p['coincide_fecha']) { ?><span class="badge badge-success"><i class="fas fa-check"></i> Coincide fecha de nacimiento</span><?php } ?>
                <?php if (!empty($p['busco_complemento']) && !$p['coincide_complemento']) { ?><span class="badge badge-danger"><i class="fas fa-times"></i> No coincide complemento</span><?php } ?>
                <?php if (!empty($p['busco_fecha']) && !$p['coincide_fecha']) { ?><span class="badge badge-danger"><i class="fas fa-times"></i> No coincide fecha de nacimiento</span><?php } ?>
                <?php if ($p['posible_duplicado']) { ?><span class="badge badge-warning" title="Hay otro registro con los mismos nombres, apellidos y fecha de nacimiento">Posible registro duplicado</span><?php } ?>
                <?php if ($p['carpeta'] !== '' && !empty($p['idcarpeta_familiar'])) {
                    // Mismo aspecto; abre la carpeta familiar (la más reciente) como en los reportes de carpetas ?>
                    <a class="badge badge-warning enlace-carpeta" href="../carpetas_familiares/imprime_carpeta_familiar.php?idcarpeta_familiar=<?php echo (int)$p['idcarpeta_familiar']; ?>"
                       target="_blank" title="Ver la carpeta familiar"
                       onclick="window.open(this.href, this.target, 'width=1400,height=800,top=50,left=200,scrollbars=YES'); return false;">Carpeta <?php echo per_h($p['carpeta']); ?></a>
                <?php } elseif ($p['carpeta'] !== '') { ?><span class="badge badge-warning">Carpeta <?php echo per_h($p['carpeta']); ?></span><?php
                } else {
                    // No es integrante de ninguna carpeta: se indica para que no parezca que falta el enlace ?>
                    <span class="badge badge-secondary" title="La persona no es integrante de ninguna carpeta familiar">Sin carpeta familiar</span>
                <?php } ?>
            </div>
        </div>
        <div class="card-body">
            <?php if ($enlaces) { ?><div class="row"><div class="col-md-9"><?php } ?>
            <div class="row">
                <?php
                echo $dato(2, 'N° CÉDULA', ((int)$p['ci'] === 0) ? 'SIN CI' : per_h($p['ci']));
                echo $dato(2, 'COMPLEMENTO', $comp !== '' ? per_h($comp) : '<span class="sin-dato">SIN COMPLEMENTO</span>');
                echo $dato(3, 'NOMBRES', per_h($p['nombre']));
                echo $dato(2, 'PRIMER APELLIDO', per_h($p['paterno']));
                echo $dato(3, 'SEGUNDO APELLIDO', per_h($p['materno']));
                ?>
            </div>
            <div class="row">
                <?php
                echo $dato(2, 'GÉNERO', per_h($p['genero']));
                echo $dato(2, 'FECHA DE NACIMIENTO', $p['fecha_nac'] ? per_h(date('d/m/Y', strtotime($p['fecha_nac']))) : '-');
                echo $dato(3, 'EDAD', $p['edad'] !== '' ? per_h($p['edad']) . ' años' : '-');
                if ($atencion) {
                    echo $dato(5, 'ÚLTIMA ATENCIÓN', $p['ultima_fecha'] !== ''
                        ? per_h(date('d/m/Y', strtotime($p['ultima_fecha']))) . ' &middot; ' . per_h($p['ultimo_eess'])
                        : 'Sin atenciones registradas');
                }
                ?>
            </div>
            <?php if ($enlaces) { ?>
                </div>
                <!-- Enlaces discretos dentro del recuadro de datos, uno debajo del otro -->
                <div class="col-md-3 text-md-right enlaces-persona">
                    <?php foreach ($enlaces as $e) { ?><div class="mb-2"><?php echo $e; ?></div><?php } ?>
                </div>
            </div>
            <?php } ?>
            <?php if ($botones !== '') { ?>
            <hr>
            <div class="text-center"><?php echo $botones; ?></div>
            <?php } ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/** Página simple de aviso/confirmación (para flujos sin AJAX). Termina la ejecución. */
function per_pagina($titulo, $html_cuerpo, $clase_titulo = 'text-danger')
{
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="utf-8">
        <title>SISTEMA MEDI-SAFCI</title>
        <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    </head>
    <body class="bg-gradient-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="container">
            <div class="card shadow mb-4 mx-auto" style="max-width: 680px;">
                <div class="card-body py-4">
                    <h4 class="<?php echo per_h($clase_titulo); ?> font-weight-bold text-center mb-4"><?php echo per_h($titulo); ?></h4>
                    <?php echo $html_cuerpo; ?>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit();
}
