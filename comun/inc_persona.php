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
 *   - Complemento válido: 2 caracteres, un número y una letra en cualquier orden (1K, K1; "1-K" se guarda 1K).
 *     Lo demás (LP, CBBA, 0, SN, "-") no es complemento: si es un departamento se sugiere en EXPEDIDO.
 *   - Corrección: nombres/apellidos con cambio grande, cambio de CI o CI+complemento ya usado por otra
 *     persona => advertencia "parece otra persona; ¿continuar?". Si el usuario continúa se guarda.
 *     Fecha de nacimiento y género se corrigen sin advertencia. Todo cambio queda en nombre_correccion.
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
    $personas = per_filas($link, $sql, $types, $params);

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
        $cf = per_fila($link,
            "SELECT cf.codigo
               FROM integrante_cf i
         INNER JOIN carpeta_familiar cf ON cf.idcarpeta_familiar = i.idcarpeta_familiar
              WHERE i.idnombre = ?
           ORDER BY i.idintegrante_cf LIMIT 1",
            'i', array((int)$p['idnombre']));

        $p['edad']                 = per_edad($p['fecha_nac']);
        $p['ci_texto']             = per_ci_texto($p);
        $p['ultima_fecha']         = $ult ? $ult['fecha_registro'] : '';
        $p['ultimo_eess']          = $ult ? $ult['establecimiento_salud'] : '';
        $p['carpeta']              = $cf ? $cf['codigo'] : '';
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

/** Mensajes de "parece otra persona". */
function per_advertencias($link, $idnombre, array $antes, array $nuevo)
{
    $adv = array();
    $et  = per_etiquetas();
    foreach (array('nombre', 'paterno', 'materno') as $c) {
        if (per_cambio_grande_texto($antes[$c], $nuevo[$c])) {
            $adv[] = $et[$c] . ': "' . $antes[$c] . '" → "' . ($nuevo[$c] === '' ? '(vacío)' : $nuevo[$c]) . '"';
        }
    }
    $ci_antes = per_valor_texto('ci', $antes['ci']);
    $ci_nuevo = per_valor_texto('ci', $nuevo['ci']);
    if ($ci_antes !== '' && $ci_antes !== $ci_nuevo) {
        $adv[] = $et['ci'] . ': ' . $ci_antes . ' → ' . ($ci_nuevo === '' ? '(vacío)' : $ci_nuevo);
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
    return $adv;
}

/**
 * Valida y guarda la corrección de una persona.
 * Devuelve array('estado' => 'ok' | 'sin_cambios' | 'error' | 'advertencia', 'errores' => [], 'advertencias' => [], 'cambios' => [])
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

    $advertencias = per_advertencias($link, $idnombre, $antes, $nuevo);
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
            ['.caja-errores', '.caja-advertencia'].forEach(function (s) { mostrar(form.querySelector(s), false); });
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
                    if (r.estado === 'advertencia') {
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
            else if (t.classList.contains('btn-revisar')) { mostrar(t.closest('.caja-advertencia'), false); }
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
        $enlaces[] = '<a href="#" class="small font-weight-bold text-warning enlace-editar" data-toggle="modal" data-target="#' . per_h($editar) . '"'
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
                <?php if ($p['carpeta'] !== '') { ?><span class="badge badge-info">Carpeta <?php echo per_h($p['carpeta']); ?></span><?php } ?>
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
