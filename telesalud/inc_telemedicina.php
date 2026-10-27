<?php
// =========================================================================
// TELEMEDICINA: bloque compartido por las 4 pestañas
//   (teleinterconsultas, teleinterconsultas_destino, teleconsultas, telemetrias)
//   0. Alcance del usuario según su perfil y lugar de trabajo (valores por defecto y campos fijos)
//   1. Filtros compartidos en la sesión: fechas, departamento, municipio, establecimiento y médico
//   2. Barra de pestañas en píldora
//   3. Estilos del diseño (variables derivadas de la paleta de SB Admin 2)
// Se incluye DESPUÉS de cabf.php (sesión iniciada) y ANTES de leer $_GET.
// Cada página interpreta el mismo filtro según su rol (origen, especialista o atención).
// =========================================================================

$tm_claves = ['fecha_inicio', 'fecha_fin', 'iddepartamento', 'idmunicipio', 'idestablecimiento', 'idusuario_medico'];

$tm_pestanas = [
    'consolidado'   => ['Consolidado', 'telesalud_dashboard.php', 'fa-th-large', 'Producción de'],
    'generadas'     => ['Generadas', 'teleinterconsultas.php', 'fa-share-square', 'Casos generados por'],
    'respuestas'    => ['Respuestas', 'teleinterconsultas_destino.php', 'fa-reply-all', 'Casos respondidos por'],
    'teleconsultas' => ['Teleconsultas', 'teleconsultas.php', 'fa-headset', 'Teleconsultas realizadas en'],
    'telemetrias'   => ['Telemetrías', 'telemetrias.php', 'fa-heartbeat', 'Telemetrías realizadas en'],
];

// --- 0. ALCANCE DEL USUARIO (según su perfil y su lugar de trabajo ACTUAL: personal.iddato_laboral) ---
//   1. ADMINISTRADOR ................................ todo el país, filtros libres
//   2. Trabaja en la Coordinación Nacional ........... todo el país, filtros libres
//   3. Trabaja en una Oficina de Coordinación Dptal. . su departamento por defecto, filtros libres
//   4. ADM-MUNICIPAL ................................ departamento y municipio fijos; establecimiento libre
//   5. PERSONAL ..................................... departamento y municipio fijos; su establecimiento por defecto
//   Sin lugar de trabajo cargado: aviso · Otros perfiles: sin acceso
function tm_alcance($link) {
    static $a = null;
    if ($a !== null) { return $a; }
    $perfil = isset($_SESSION['perfil_ss']) ? (string)$_SESSION['perfil_ss'] : '';
    $idu = isset($_SESSION['idusuario_ss']) ? (int)$_SESSION['idusuario_ss'] : 0;
    $a = ['nivel' => 'sin_acceso', 'fijos' => [], 'defecto' => [], 'lugar' => null];
    if (!in_array($perfil, ['ADMINISTRADOR', 'ADM-MUNICIPAL', 'PERSONAL'], true)) { return $a; }
    if ($perfil === 'ADMINISTRADOR') { $a['nivel'] = 'nacional'; return $a; }

    $res = mysqli_query($link, "SELECT es.idestablecimiento_salud AS est, es.idmunicipio AS mun, es.iddepartamento AS dep, UPPER(IFNULL(rs.red_salud, '')) AS red
        FROM personal p INNER JOIN dato_laboral dl ON dl.iddato_laboral = p.iddato_laboral
        INNER JOIN establecimiento_salud es ON es.idestablecimiento_salud = dl.idestablecimiento_salud
        LEFT JOIN red_salud rs ON rs.idred_salud = es.idred_salud
        WHERE p.idusuario = '$idu' ORDER BY p.idpersonal DESC LIMIT 1");
    $l = $res ? mysqli_fetch_assoc($res) : null;
    if (!$l || !$l['mun'] || !$l['dep']) { $a['nivel'] = 'sin_datos'; return $a; }
    $a['lugar'] = $l;

    $coordinacion = strpos($l['red'], 'COORDINACI') !== false;
    if ($coordinacion && strpos($l['red'], 'NACIONAL') !== false) {
        $a['nivel'] = 'nacional';
    } elseif ($coordinacion && strpos($l['red'], 'DEPARTAMENTAL') !== false) {
        $a['nivel'] = 'departamental';
        $a['defecto'] = ['iddepartamento' => (string)$l['dep']];
    } else {
        $a['nivel'] = 'municipal';
        $a['fijos'] = ['iddepartamento' => (string)$l['dep'], 'idmunicipio' => (string)$l['mun']];
        $a['defecto'] = $a['fijos'] + ($perfil === 'PERSONAL' ? ['idestablecimiento' => (string)$l['est']] : []);
    }
    return $a;
}
function tm_es_fijo($clave) {
    global $link;
    return isset(tm_alcance($link)['fijos'][$clave]);
}
// Atributos y candado para los campos fijados por el lugar de trabajo
function tm_bloqueo($clave) {
    return tm_es_fijo($clave) ? ' readonly aria-readonly="true" title="Fijado según su lugar de trabajo"' : '';
}
function tm_candado($clave) {
    return tm_es_fijo($clave) ? ' <i class="fas fa-lock" style="font-size: 9px; opacity: .7;" aria-hidden="true"></i>' : '';
}

// Médicos con producción de telesalud (o Personal Telesalud que trabaja ahí) en el lugar de los filtros elegidos
function tm_medicos($link, $f) {
    static $cache = [];
    $clave = (isset($f['iddepartamento']) ? $f['iddepartamento'] : '') . '|' . (isset($f['idmunicipio']) ? $f['idmunicipio'] : '') . '|' . (isset($f['idestablecimiento']) ? $f['idestablecimiento'] : '');
    if (isset($cache[$clave])) { return $cache[$clave]; }
    $w = '';
    foreach (['iddepartamento' => 'x.dep', 'idmunicipio' => 'x.mun', 'idestablecimiento' => 'x.est'] as $k => $col) {
        if (isset($f[$k]) && $f[$k] !== '') { $w .= " AND $col = '" . mysqli_real_escape_string($link, (string)$f[$k]) . "'"; }
    }
    $sql = "SELECT u.idusuario, n.nombre, n.paterno, n.materno FROM (
            SELECT r.idusuario AS u, r.iddepartamento AS dep, r.idmunicipio AS mun, r.idestablecimiento_salud AS est FROM referencia_hc r
          UNION SELECT d.idusuario_r, es.iddepartamento, es.idmunicipio, es.idestablecimiento_salud FROM deriva_referencia_hc d INNER JOIN establecimiento_salud es ON es.idestablecimiento_salud = d.idestablecimiento_salud_r
          UNION SELECT a.idusuario, a.iddepartamento, a.idmunicipio, a.idestablecimiento_salud FROM atencion_psafci a WHERE a.idtipo_atencion IN ('3', '4')
          UNION SELECT p.idusuario, es.iddepartamento, es.idmunicipio, es.idestablecimiento_salud FROM personal p INNER JOIN dato_laboral dl ON dl.iddato_laboral = p.iddato_laboral
                INNER JOIN establecimiento_salud es ON es.idestablecimiento_salud = dl.idestablecimiento_salud INNER JOIN usuarios ua ON ua.idusuario = p.idusuario
                WHERE dl.idcargo_organigrama = '54' AND ua.condicion = 'ACTIVO'
        ) x INNER JOIN usuarios u ON u.idusuario = x.u INNER JOIN nombre n ON n.idnombre = u.idnombre
        WHERE 1 = 1 $w GROUP BY u.idusuario, n.nombre, n.paterno, n.materno ORDER BY n.nombre, n.paterno, n.materno";
    $lista = [];
    $res = mysqli_query($link, $sql);
    if ($res) { while ($r = mysqli_fetch_array($res)) { $lista[] = ['id' => $r[0], 'nombre' => mb_strtoupper(trim($r[1] . ' ' . $r[2] . ' ' . $r[3]))]; } }
    return $cache[$clave] = $lista;
}

// Aplica el alcance a unos filtros: campos fijos forzados; establecimiento y médico deben estar dentro del alcance.
// $medico_fuera: valor para un médico sin producción en ese lugar. Pantallas: '' (se quita el filtro);
// reportes: '0' (ningún usuario tiene ese id, así el reporte sale vacío en vez de traer a todos los médicos)
function tm_forzar_alcance($link, $f, $medico_fuera = '') {
    $a = tm_alcance($link);
    foreach ($a['fijos'] as $k => $v) { $f[$k] = $v; }
    if (!empty($a['fijos']) && isset($f['idestablecimiento']) && $f['idestablecimiento'] !== '') {
        $res = mysqli_query($link, "SELECT 1 FROM establecimiento_salud WHERE idestablecimiento_salud = '" . mysqli_real_escape_string($link, $f['idestablecimiento']) . "' AND idmunicipio = '" . mysqli_real_escape_string($link, $a['fijos']['idmunicipio']) . "'");
        if (!$res || mysqli_num_rows($res) === 0) { $f['idestablecimiento'] = ''; }
    }
    if (isset($f['idusuario_medico']) && $f['idusuario_medico'] !== '') {
        $ids = array_map(function ($m) { return (string)$m['id']; }, tm_medicos($link, $f));
        if (!in_array((string)$f['idusuario_medico'], $ids, true)) { $f['idusuario_medico'] = $medico_fuera; }
    }
    return $f;
}

// Catálogos de los filtros, recortados al alcance (la lista de médicos sigue al lugar elegido)
function tm_catalogos($link) {
    $a = tm_alcance($link);
    $mun_fijo = isset($a['fijos']['idmunicipio']) ? mysqli_real_escape_string($link, $a['fijos']['idmunicipio']) : '';
    $dep_fijo = isset($a['fijos']['iddepartamento']) ? mysqli_real_escape_string($link, $a['fijos']['iddepartamento']) : '';
    $deptos = []; $munis = []; $eess = [];
    $res = mysqli_query($link, "SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento != '10'" . ($dep_fijo !== '' ? " AND iddepartamento = '$dep_fijo'" : ''));
    if ($res) { while ($r = mysqli_fetch_array($res)) { $deptos[] = ['id' => $r[0], 'nombre' => mb_strtoupper(trim($r[1]))]; } }
    $res = mysqli_query($link, "SELECT idmunicipio, municipio, iddepartamento FROM municipios" . ($mun_fijo !== '' ? " WHERE idmunicipio = '$mun_fijo'" : ''));
    if ($res) { while ($r = mysqli_fetch_array($res)) { $munis[] = ['id' => $r[0], 'nombre' => mb_strtoupper(trim($r[1])), 'idDepto' => $r[2]]; } }
    $res = mysqli_query($link, "SELECT idestablecimiento_salud, establecimiento_salud, idmunicipio FROM establecimiento_salud" . ($mun_fijo !== '' ? " WHERE idmunicipio = '$mun_fijo'" : ''));
    if ($res) { while ($r = mysqli_fetch_array($res)) { $eess[] = ['id' => $r[0], 'nombre' => mb_strtoupper(trim($r[1])), 'idMuni' => $r[2]]; } }
    return [$deptos, $munis, $eess, tm_medicos($link, $_GET)];
}

// Salida compacta de los reportes Excel (tabla HTML con extensión .xls):
//   1. Viaja comprimida con gzip si el navegador lo acepta (el archivo guardado no cambia, la descarga es mucho menor)
//   2. Se quitan los espacios y saltos de línea entre etiquetas (casi la mitad del peso del archivo)
// Se procesa por bloques de 1 MB para no cargar en memoria el reporte completo.
function tm_salida_excel_compacta() {
    if (!ini_get('zlib.output_compression')) { ob_start('ob_gzhandler'); }
    // Solo junto a etiquetas reales (<td ...>, </tr>...): un texto como "j) > 60 años" conserva sus espacios
    $etiqueta = '(<[a-zA-Z\/!][^<>]*>)';
    ob_start(function ($bloque) use ($etiqueta) { return preg_replace(["/$etiqueta\\s+/", "/\\s+$etiqueta/"], ['$1', '$1'], $bloque); }, 1048576);
}

// Pantalla para quien no tiene acceso o no tiene su lugar de trabajo cargado (las peticiones AJAX reciben JSON)
function tm_pantalla_sin_alcance($nivel) {
    $sin_datos = $nivel === 'sin_datos';
    $msg = $sin_datos ? 'Para ver Telemedicina, complete sus datos laborales (lugar de trabajo actual).' : 'Su perfil no tiene acceso al módulo de Telemedicina.';
    if (strpos(basename($_SERVER['SCRIPT_NAME']), 'ajax_') === 0) {
        http_response_code(403); header('Content-Type: application/json'); echo json_encode(['error' => $msg]); exit;
    }
    http_response_code(403); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SISTEMA MEDI-SAFCI - Telemedicina</title>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
    <div class="container" style="max-width: 560px; margin-top: 12vh;">
        <div class="card shadow-lg border-0"><div class="card-body p-5 text-center">
            <i class="fas <?php echo $sin_datos ? 'fa-id-card' : 'fa-lock'; ?> fa-3x text-primary mb-3"></i>
            <h5 class="text-gray-900 mb-3">Telemedicina</h5>
            <p class="text-gray-700"><?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php if ($sin_datos) { ?><a class="btn btn-primary mb-2" href="../recursos_humanos/datos_laborales_individual.php"><i class="fas fa-briefcase mr-1"></i> Completar datos laborales</a><br><?php } ?>
            <a href="../administrar_sistema/inicio.php">Volver al inicio</a>
        </div></div>
    </div>
</body>
</html>
<?php exit;
}

// Otras páginas (p. ej. la Matriz) solo necesitan las funciones de alcance
if (defined('TM_SOLO_ALCANCE')) { return; }

$tm_alc = tm_alcance($link);
if (!in_array($tm_alc['nivel'], ['nacional', 'departamental', 'municipal'], true)) { tm_pantalla_sin_alcance($tm_alc['nivel']); }

// --- 1. Filtros: la URL manda (el formulario siempre envía todos los campos); si no hay, se usa la sesión;
//        la primera vez y al limpiar, los valores por defecto del usuario. Siempre se aplica el alcance. ---
$tm_filtros = [];
$tm_desde_url = false;
foreach ($tm_claves as $k) { if (array_key_exists($k, $_GET)) { $tm_desde_url = true; break; } }
$tm_idu = isset($_SESSION['idusuario_ss']) ? (string)$_SESSION['idusuario_ss'] : '';
$tm_sesion_valida = isset($_SESSION['tm_filtros']) && is_array($_SESSION['tm_filtros'])
    && isset($_SESSION['tm_filtros_usuario']) && (string)$_SESSION['tm_filtros_usuario'] === $tm_idu;

if (isset($_GET['limpiar'])) {
    unset($_GET['limpiar']);
    $tm_desde_url = false;
    $tm_filtros = $tm_alc['defecto'];
} elseif ($tm_desde_url) {
    foreach ($tm_claves as $k) { $tm_filtros[$k] = isset($_GET[$k]) ? trim((string)$_GET[$k]) : ''; }
    foreach (['fecha_inicio', 'fecha_fin'] as $k) {
        if ($tm_filtros[$k] !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tm_filtros[$k])) { $tm_filtros[$k] = ''; }
    }
} elseif ($tm_sesion_valida) {
    $tm_filtros = $_SESSION['tm_filtros'];
} else {
    $tm_filtros = $tm_alc['defecto'];
}
foreach ($tm_claves as $k) { if (!isset($tm_filtros[$k])) { $tm_filtros[$k] = ''; } }
$tm_filtros = tm_forzar_alcance($link, $tm_filtros);
$_SESSION['tm_filtros'] = $tm_filtros;
$_SESSION['tm_filtros_usuario'] = $tm_idu;

// Se publican en $_GET para que cada página siga leyendo sus filtros como siempre.
// Siempre van todas las claves (vacías = sin filtro), así los enlaces de los chips las conservan.
foreach ($tm_claves as $k) { $_GET[$k] = isset($tm_filtros[$k]) ? (string)$tm_filtros[$k] : ''; }

// --- 2. Barra de pestañas en píldora ---
function tm_nav($activa) {
    global $tm_pestanas;
    echo '<nav class="nav-pildora vidrio" aria-label="Secciones de telemedicina">';
    foreach ($tm_pestanas as $clave => $p) {
        $es = $clave === $activa;
        echo '<a href="' . htmlspecialchars($p[1], ENT_QUOTES, 'UTF-8') . '"' . ($es ? ' class="activo" aria-current="page"' : '') . '>'
            . '<i class="fas ' . $p[2] . '"></i>' . htmlspecialchars($p[0], ENT_QUOTES, 'UTF-8') . '</a>';
    }
    echo '</nav>';
}

// Texto que explica cómo lee esta pestaña el filtro elegido
function tm_contexto($activa) {
    global $tm_pestanas;
    return isset($tm_pestanas[$activa]) ? $tm_pestanas[$activa][3] : 'Filtrando por';
}

// Enlace del botón "Limpiar": borra también los filtros guardados en la sesión
function tm_url_limpiar($pagina) {
    return $pagina . '?limpiar=1';
}

// =========================================================================
// REGLAS DE PRODUCCIÓN (definidas UNA sola vez; las usan la Central, la analítica anual y las pestañas)
// =========================================================================
// Procesos: nombre, color (paleta SB Admin 2), ícono
$tm_procesos = [
    'generadas'     => ['Generadas', '#4e73df', 'fa-share-square'],
    'respuestas'    => ['Respuestas', '#36b9cc', 'fa-reply-all'],
    'teleconsultas' => ['Teleconsultas', '#1cc88a', 'fa-headset'],
    'telemetrias'   => ['Telemetrías', '#fd7e14', 'fa-heartbeat'],
];

// Dispositivo VÁLIDO de telemetría: telesalud='SI', sin el duplicado id 6, sin signos vitales, estetoscopio ni "OTRO"
function tm_cond_dispositivo($al) {
    return "$al.telesalud = 'SI' AND $al.idexamen_complementario != '6'
    AND UPPER($al.examen_complementario) NOT LIKE '%MONITOR DE SIGNOS VITALES%'
    AND UPPER($al.examen_complementario) NOT LIKE '%ESTETOSCOPIO%'
    AND UPPER($al.examen_complementario) NOT LIKE '%OTRO%'";
}

// Teleinterconsulta EFECTIVIZADA: contrarreferida (estado 2) y NO rechazada (calificación NO/NO/NO)
function tm_cond_efectivizada() {
    return "r.idestado_referencia = '2' AND NOT (UPPER(TRIM(IFNULL(r.adecuada,''))) = 'NO' AND UPPER(TRIM(IFNULL(r.justificada,''))) = 'NO' AND UPPER(TRIM(IFNULL(r.oportuna,''))) = 'NO')";
}

// Fecha de la RESPUESTA del especialista: la del diagnóstico de egreso (la última, como el Excel de referencias);
// si no hay egreso, la fila de deriva de retorno (se crea al guardar la contrarreferencia); en último caso, la referencia.
// Requiere los alias r (referencia_hc) y d (fila de deriva del especialista).
function tm_sql_fecha_respuesta() {
    return "COALESCE(
        (SELECT MAX(NULLIF(eg.fecha_registro, '0000-00-00')) FROM diagnostico_egreso eg WHERE eg.idreferencia_hc = r.idreferencia_hc),
        (SELECT MAX(NULLIF(dr.fecha_deriva, '0000-00-00')) FROM deriva_referencia_hc dr WHERE dr.idreferencia_hc = r.idreferencia_hc AND dr.idderiva_referencia_hc > d.idderiva_referencia_hc),
        r.fecha_registro)";
}

// Filtros compartidos traducidos a SQL según el rol de cada proceso
function tm_filtros_sql($link) {
    $v = function ($k) use ($link) { return isset($_GET[$k]) && $_GET[$k] !== '' ? mysqli_real_escape_string($link, (string)$_GET[$k]) : ''; };
    $dep = $v('iddepartamento'); $mun = $v('idmunicipio'); $est = $v('idestablecimiento'); $med = $v('idusuario_medico');
    $o = ''; $r = ''; $a = '';
    if ($dep !== '') { $o .= " AND r.iddepartamento = '$dep'";       $r .= " AND es_receptor.iddepartamento = '$dep'"; $a .= " AND a.iddepartamento = '$dep'"; }
    if ($mun !== '') { $o .= " AND r.idmunicipio = '$mun'";          $r .= " AND es_receptor.idmunicipio = '$mun'";    $a .= " AND a.idmunicipio = '$mun'"; }
    if ($est !== '') { $o .= " AND r.idestablecimiento_salud = '$est'"; $r .= " AND r.idestablecimiento_receptor = '$est'"; $a .= " AND a.idestablecimiento_salud = '$est'"; }
    if ($med !== '') { $o .= " AND r.idusuario = '$med'";            $r .= " AND d.idusuario_r = '$med' AND r.idusuario != '$med'"; $a .= " AND a.idusuario = '$med'"; }
    return ['origen' => $o, 'receptor' => $r, 'atencion' => $a];
}

// Definición SQL de cada proceso (FROM, WHERE base, conteo, columna de fecha, paciente y establecimiento)
function tm_def_procesos($link) {
    $f = tm_filtros_sql($link);
    $from_tic = "FROM referencia_hc r
        LEFT JOIN deriva_referencia_hc d ON d.idderiva_referencia_hc = (SELECT MIN(d2.idderiva_referencia_hc) FROM deriva_referencia_hc d2 WHERE d2.idreferencia_hc = r.idreferencia_hc)
        LEFT JOIN establecimiento_salud es_receptor ON es_receptor.idestablecimiento_salud = r.idestablecimiento_receptor";
    return [
        // Generadas: solo efectivizadas, vistas desde el ORIGEN
        'generadas' => ['from' => $from_tic, 'where' => tm_cond_efectivizada() . $f['origen'], 'cnt' => 'COUNT(r.idreferencia_hc)',
                        'fecha' => 'r.fecha_registro', 'pac' => 'r.idnombre', 'est' => 'r.idestablecimiento_salud', 'dep' => 'r.iddepartamento'],
        // Respuestas: solo efectivizadas, vistas desde el hospital ESPECIALISTA y fechadas el día en que se respondieron
        'respuestas' => ['from' => $from_tic, 'where' => tm_cond_efectivizada() . $f['receptor'], 'cnt' => 'COUNT(r.idreferencia_hc)',
                        'fecha' => tm_sql_fecha_respuesta(), 'pac' => 'r.idnombre', 'est' => 'r.idestablecimiento_receptor', 'dep' => 'es_receptor.iddepartamento'],
        'teleconsultas' => ['from' => 'FROM atencion_psafci a', 'where' => "a.idtipo_atencion = '3'" . $f['atencion'], 'cnt' => 'COUNT(a.idatencion_psafci)',
                        'fecha' => 'a.fecha_registro', 'pac' => 'a.idnombre', 'est' => 'a.idestablecimiento_salud', 'dep' => 'a.iddepartamento'],
        // Telemetrías: exámenes con dispositivo válido
        'telemetrias' => ['from' => 'FROM examen_teleconsulta et INNER JOIN atencion_psafci a ON et.idatencion_psafci = a.idatencion_psafci INNER JOIN examen_complementario ec ON et.idexamen_complementario = ec.idexamen_complementario',
                        'where' => "a.idtipo_atencion = '4' AND " . tm_cond_dispositivo('ec') . $f['atencion'], 'cnt' => 'COUNT(et.idexamen_teleconsulta)',
                        'fecha' => 'a.fecha_registro', 'pac' => 'a.idnombre', 'est' => 'a.idestablecimiento_salud', 'dep' => 'a.iddepartamento'],
    ];
}

// Atención de telemetría que cuenta: con al menos un dispositivo válido
function tm_cond_atencion_telemetria() {
    return "EXISTS (SELECT 1 FROM examen_teleconsulta etv INNER JOIN examen_complementario ecv ON etv.idexamen_complementario = ecv.idexamen_complementario
        WHERE etv.idatencion_psafci = a.idatencion_psafci AND " . tm_cond_dispositivo('ecv') . ")";
}

// Diagnósticos de TODOS los procesos en una sola tabla (UNION ALL), con las mismas reglas de producción:
//   proceso · sid (id del servicio) · pac (paciente) · fecha · cie · patologia · idgrupo_priorizado
//   Generadas: diagnóstico presuntivo · Respuestas: diagnóstico de egreso · Teleconsultas/Telemetrías: diagnóstico de la atención
//   $limitar = true: solo los primeros diagnósticos registrados, como los reportes Excel (3 en referencias, 4 en atenciones)
function tm_sql_diagnosticos($link, $ini, $fin, $limitar = false) {
    $d = tm_def_procesos($link); $f = tm_filtros_sql($link);
    $cols = "pt.cie, pt.patologia, pt.idgrupo_priorizado";
    $fr = $d['respuestas']['fecha'];
    $lim_p = $limitar ? " AND (SELECT COUNT(*) FROM diagnostico_presuntivo x WHERE x.idreferencia_hc = dx.idreferencia_hc AND x.iddiagnostico_presuntivo < dx.iddiagnostico_presuntivo) < 3" : '';
    $lim_e = $limitar ? " AND (SELECT COUNT(*) FROM diagnostico_egreso x WHERE x.idreferencia_hc = dx.idreferencia_hc AND x.iddiagnostico_egreso < dx.iddiagnostico_egreso) < 3" : '';
    $lim_a = $limitar ? " AND (SELECT COUNT(*) FROM diagnostico_teleconsulta x WHERE x.idatencion_psafci = dx.idatencion_psafci AND x.iddiagnostico_teleconsulta < dx.iddiagnostico_teleconsulta) < 4" : '';
    return "
        SELECT 'generadas' AS proceso, r.idreferencia_hc AS sid, r.idnombre AS pac, r.fecha_registro AS fecha, $cols
        {$d['generadas']['from']} INNER JOIN diagnostico_presuntivo dx ON dx.idreferencia_hc = r.idreferencia_hc INNER JOIN patologia pt ON pt.idpatologia = dx.idpatologia
        WHERE r.fecha_registro BETWEEN '$ini' AND '$fin' AND {$d['generadas']['where']} $lim_p
      UNION ALL
        SELECT 'respuestas', r.idreferencia_hc, r.idnombre, $fr, $cols
        {$d['respuestas']['from']} INNER JOIN diagnostico_egreso dx ON dx.idreferencia_hc = r.idreferencia_hc INNER JOIN patologia pt ON pt.idpatologia = dx.idpatologia
        WHERE $fr BETWEEN '$ini' AND '$fin' AND {$d['respuestas']['where']} $lim_e
      UNION ALL
        SELECT 'teleconsultas', a.idatencion_psafci, a.idnombre, a.fecha_registro, $cols
        FROM atencion_psafci a INNER JOIN diagnostico_teleconsulta dx ON dx.idatencion_psafci = a.idatencion_psafci INNER JOIN patologia pt ON pt.idpatologia = dx.idpatologia
        WHERE a.fecha_registro BETWEEN '$ini' AND '$fin' AND a.idtipo_atencion = '3' {$f['atencion']} $lim_a
      UNION ALL
        SELECT 'telemetrias', a.idatencion_psafci, a.idnombre, a.fecha_registro, $cols
        FROM atencion_psafci a INNER JOIN diagnostico_teleconsulta dx ON dx.idatencion_psafci = a.idatencion_psafci INNER JOIN patologia pt ON pt.idpatologia = dx.idpatologia
        WHERE a.fecha_registro BETWEEN '$ini' AND '$fin' AND a.idtipo_atencion = '4' AND " . tm_cond_atencion_telemetria() . " {$f['atencion']} $lim_a";
}

// Servicios de TODOS los procesos (UNION ALL): proceso · sid · pac · fecha · disc (1 = persona con discapacidad)
//   Teleinterconsultas: campo "Persona con discapacidad" de la referencia (la contrarreferencia lo hereda)
//   Teleconsultas/Telemetrías: grupo vulnerable 5 "Persona con discapacidad". En telemetrías el servicio es la atención.
function tm_sql_servicios($link, $ini, $fin) {
    $d = tm_def_procesos($link); $f = tm_filtros_sql($link);
    $disc_r = "IF(UPPER(TRIM(IFNULL(r.discapacidad, ''))) = 'SI', 1, 0)";
    $disc_a = "IF(EXISTS (SELECT 1 FROM atencion_grupo_vulnerable agd WHERE agd.idatencion_psafci = a.idatencion_psafci AND agd.idgrupo_vulnerable = '5'), 1, 0)";
    $partes = [];
    foreach (['generadas', 'respuestas'] as $k) {
        $p = $d[$k];
        $partes[] = "SELECT '$k' AS proceso, r.idreferencia_hc AS sid, r.idnombre AS pac, $p[fecha] AS fecha, $disc_r AS disc $p[from] WHERE $p[fecha] BETWEEN '$ini' AND '$fin' AND $p[where]";
    }
    $partes[] = "SELECT 'teleconsultas', a.idatencion_psafci, a.idnombre, a.fecha_registro, $disc_a FROM atencion_psafci a WHERE a.fecha_registro BETWEEN '$ini' AND '$fin' AND a.idtipo_atencion = '3' {$f['atencion']}";
    $partes[] = "SELECT 'telemetrias', a.idatencion_psafci, a.idnombre, a.fecha_registro, $disc_a FROM atencion_psafci a WHERE a.fecha_registro BETWEEN '$ini' AND '$fin' AND a.idtipo_atencion = '4' AND " . tm_cond_atencion_telemetria() . " {$f['atencion']}";
    return implode(' UNION ALL ', $partes);
}

// Grupo priorizado por servicio, con las reglas de los reportes Excel (los grupos NO son excluyentes):
//   ENT / ET / SM / OTROS = grupo de la patología en los primeros 3 (referencias) o 4 (atenciones) diagnósticos
//   SI = menor de 5 años a la fecha del servicio · D = persona con discapacidad
function tm_sql_grupos($link, $ini, $fin) {
    $s = tm_sql_servicios($link, $ini, $fin);
    return "
        SELECT dg.proceso, dg.sid, CASE dg.idgrupo_priorizado WHEN 1 THEN 'ENT' WHEN 2 THEN 'ET' WHEN 3 THEN 'SM' ELSE 'OTROS' END AS grupo
        FROM (" . tm_sql_diagnosticos($link, $ini, $fin, true) . ") dg
      UNION ALL
        SELECT s.proceso, s.sid, 'SI' FROM ($s) s INNER JOIN nombre n ON n.idnombre = s.pac
        WHERE n.fecha_nac IS NOT NULL AND n.fecha_nac <> '0000-00-00' AND n.fecha_nac <= s.fecha AND TIMESTAMPDIFF(YEAR, n.fecha_nac, s.fecha) < 5
      UNION ALL
        SELECT s.proceso, s.sid, 'D' FROM ($s) s WHERE s.disc = 1";
}

// Pacientes atendidos en TODOS los procesos (UNION ALL): proceso · pac · fecha (para la pirámide)
function tm_sql_pacientes($link, $ini, $fin) {
    $partes = [];
    foreach (tm_def_procesos($link) as $clave => $p) {
        $where = $clave === 'telemetrias' ? "a.idtipo_atencion = '4' AND " . tm_cond_atencion_telemetria() . tm_filtros_sql($link)['atencion'] : $p['where'];
        $from = $clave === 'telemetrias' ? 'FROM atencion_psafci a' : $p['from'];
        $partes[] = "SELECT '$clave' AS proceso, $p[pac] AS pac, $p[fecha] AS fecha $from WHERE $p[fecha] BETWEEN '$ini' AND '$fin' AND $where";
    }
    return implode(' UNION ALL ', $partes);
}

// CONDICIONES TRAZADORAS (CIE-10 de 3 caracteres, comparadas desde el inicio del código)
// Oncológico = lista Dict_Oncologia del Excel del usuario (+ C26), con desglose cáncer / incierto / benigno
function tm_lista_oncologica() {
    $l = [];
    $rango = function ($letra, $a, $b) use (&$l) { for ($i = $a; $i <= $b; $i++) { $l[] = $letra . str_pad((string)$i, 2, '0', STR_PAD_LEFT); } };
    $rango('C', 0, 26); $rango('C', 30, 34); $rango('C', 37, 41); $rango('C', 43, 58); $rango('C', 60, 85); $l[] = 'C88'; $rango('C', 90, 97);
    $rango('D', 0, 7); $l[] = 'D09'; $rango('D', 10, 48);
    return $l;
}
// ¿El código CIE-10 es oncológico? (misma lista que la Central; se compara desde el inicio del código)
function tm_es_oncologico($cie) {
    static $lista = null;
    if ($lista === null) { $lista = array_flip(tm_lista_oncologica()); }
    return isset($lista[strtoupper(substr(trim((string)$cie), 0, 3))]);
}
function tm_trazadoras() {
    $onco = "'" . implode("','", tm_lista_oncologica()) . "'";
    return [
        'oncologico' => ['Oncológico', 'fa-ribbon', '#6f42c1', "LEFT(UPPER(TRIM(pt.cie)), 3) IN ($onco)", 'Lista oncológica (C00–C97, D00–D48)'],
        'renal'      => ['Enfermedad renal', 'fa-tint', '#36b9cc', "UPPER(TRIM(pt.cie)) REGEXP '^N[0-2][0-9]'", 'CIE-10 N00–N29'],
        'embarazo'   => ['Embarazo de riesgo', 'fa-baby', '#e83e8c', "UPPER(TRIM(pt.cie)) REGEXP '^(O[0-9]|Z35)'", 'CIE-10 O00–O99 y Z35'],
        'diabetes'   => ['Diabetes mellitus', 'fa-syringe', '#fd7e14', "UPPER(TRIM(pt.cie)) REGEXP '^E1[0-4]'", 'CIE-10 E10–E14'],
        'hta'        => ['Hipertensión arterial', 'fa-heartbeat', '#e74a3b', "UPPER(TRIM(pt.cie)) REGEXP '^I1[0-5]'", 'CIE-10 I10–I15'],
    ];
}
// Desglose del grupo oncológico
function tm_sql_tipo_oncologico() {
    return "CASE WHEN UPPER(TRIM(cie)) REGEXP '^(C|D0)' THEN 'cancer'
                 WHEN UPPER(TRIM(cie)) REGEXP '^D(1[0-9]|2[0-9]|3[0-6])' THEN 'benigno'
                 ELSE 'incierto' END";
}

// Producción por proceso en un rango. $agrupar: null | 'dia' | 'mes' (agrega la serie por fecha)
function tm_produccion($link, $ini, $fin, $agrupar = null) {
    $salida = [];
    foreach (tm_def_procesos($link) as $clave => $p) {
        $w = "$p[fecha] BETWEEN '$ini' AND '$fin' AND $p[where]";
        $res = mysqli_query($link, "SELECT $p[cnt] AS total, COUNT(DISTINCT $p[pac]) AS pacientes $p[from] WHERE $w");
        $row = $res ? mysqli_fetch_assoc($res) : null;
        $salida[$clave] = ['total' => $row ? (int)$row['total'] : 0, 'pacientes' => $row ? (int)$row['pacientes'] : 0, 'serie' => []];
        if ($agrupar) {
            $k = $agrupar === 'mes' ? "DATE_FORMAT($p[fecha], '%Y-%m')" : "DATE_FORMAT($p[fecha], '%Y-%m-%d')";
            $rs = mysqli_query($link, "SELECT $k AS clave, $p[cnt] AS total $p[from] WHERE $w GROUP BY clave");
            if ($rs) { while ($x = mysqli_fetch_assoc($rs)) { $salida[$clave]['serie'][$x['clave']] = (int)$x['total']; } }
        }
    }
    return $salida;
}

// Pacientes y establecimientos ÚNICOS sumando todos los procesos (sin contar dos veces)
function tm_unicos($link, $ini, $fin) {
    $partes_p = []; $partes_e = [];
    foreach (tm_def_procesos($link) as $p) {
        $w = "$p[fecha] BETWEEN '$ini' AND '$fin' AND $p[where]";
        $partes_p[] = "SELECT $p[pac] AS id $p[from] WHERE $w";
        $partes_e[] = "SELECT $p[est] AS id $p[from] WHERE $w";
    }
    $res_p = mysqli_query($link, "SELECT COUNT(DISTINCT id) AS n FROM (" . implode(' UNION ', $partes_p) . ") u");
    $res_e = mysqli_query($link, "SELECT COUNT(DISTINCT id) AS n FROM (" . implode(' UNION ', $partes_e) . ") u WHERE id IS NOT NULL");
    $p = $res_p ? mysqli_fetch_assoc($res_p) : null; $e = $res_e ? mysqli_fetch_assoc($res_e) : null;
    return ['pacientes' => $p ? (int)$p['n'] : 0, 'establecimientos' => $e ? (int)$e['n'] : 0];
}

// Etiquetas del gráfico de tendencia: como máximo ~7 visibles y repartidas de forma pareja.
// Por mes: "Ene", "Feb"... con el año debajo solo en la primera etiqueta y cuando cambia de año.
function tm_etiquetas_tendencia($etiquetas, $por_mes) {
    $meses = ['', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    $paso = max(1, (int)ceil(count($etiquetas) / 7));
    $salida = []; $anio_prev = null;
    foreach (array_values($etiquetas) as $i => $e) {
        $ver = ($i % $paso === 0);
        if ($por_mes && preg_match('/^(\d{2})\/(\d{4})$/', $e, $m)) {
            $txt = $meses[(int)$m[1]];
            $sub = ($ver && $m[2] !== $anio_prev) ? $m[2] : '';
            if ($ver) { $anio_prev = $m[2]; }
            $titulo = $txt . ' ' . $m[2];
        } else {
            $txt = $e; $sub = ''; $titulo = $e;
        }
        $salida[] = ['txt' => $txt, 'sub' => $sub, 'ver' => $ver, 'titulo' => $titulo];
    }
    return $salida;
}

// Edad promedio a partir de MESES cumplidos (la edad de cada paciente es la cumplida a la fecha de la atención).
// < 1 mes: "<1 mes" · 1–11 meses: "N meses" · 12–23 meses: "1 año y N meses" · desde 2 años: años redondeados.
function tm_texto_edad_exacta($meses) {
    if ($meses === null) { return 'Sin datos'; }
    $a = (int)floor($meses / 12); $m = (int)round($meses - $a * 12);
    if ($m == 12) { $a++; $m = 0; }
    if ($a == 0 && $m == 0) { return 'menos de 1 mes'; }
    $partes = [];
    if ($a > 0) { $partes[] = $a . ($a == 1 ? ' año' : ' años'); }
    if ($m > 0 || $a == 0) { $partes[] = $m . ($m == 1 ? ' mes' : ' meses'); }
    return implode(' ', $partes);
}
function tm_formato_edad($meses) {
    if ($meses === null) { return ['valor' => '0', 'numerico' => true, 'unidad' => 'años', 'exacto' => 'Sin datos de fecha de nacimiento']; }
    $exacto = 'Promedio exacto: ' . tm_texto_edad_exacta($meses);
    if ($meses < 1) { return ['valor' => '<1', 'numerico' => false, 'unidad' => 'mes', 'exacto' => $exacto]; }
    if ($meses < 12) { $m = (int)round($meses); if ($m < 12) { return ['valor' => (string)$m, 'numerico' => true, 'unidad' => $m == 1 ? 'mes' : 'meses', 'exacto' => $exacto]; } }
    if ($meses < 24) {
        $resto = (int)round($meses - 12);
        if ($resto < 12) { return ['valor' => '1', 'numerico' => true, 'unidad' => 'año' . ($resto > 0 ? ' y ' . $resto . ($resto == 1 ? ' mes' : ' meses') : ''), 'exacto' => $exacto]; }
    }
    $a = (int)round($meses / 12);
    return ['valor' => (string)$a, 'numerico' => true, 'unidad' => $a == 1 ? 'año' : 'años', 'exacto' => $exacto];
}
// Variación de la edad promedio en la misma unidad que se muestra (años desde los 2 años, meses antes)
function tm_variacion_edad($actual, $anterior) {
    if ($actual === null || $anterior === null) { return ['—', 'neutro', 'Sin datos para comparar']; }
    $tip = 'Periodo anterior: ' . tm_texto_edad_exacta($anterior);
    $dif = $actual - $anterior;
    if ($actual >= 24) {
        $n = (int)round($dif / 12);
        if ($n == 0) { return ['—', 'neutro', $tip]; }
        return [($n > 0 ? '▲ ' : '▼ ') . abs($n) . (abs($n) == 1 ? ' año' : ' años'), 'neutro', $tip];
    }
    $n = (int)round($dif);
    if ($n == 0) { return ['—', 'neutro', $tip]; }
    return [($n > 0 ? '▲ ' : '▼ ') . abs($n) . (abs($n) == 1 ? ' mes' : ' meses'), 'neutro', $tip];
}

// Fondo y color de texto legibles (WCAG AA 4.5:1) para un color de categoría.
// Elige texto oscuro o blanco según el contraste; si ninguno alcanza, oscurece el mismo color hasta lograrlo.
function tm_colores_legibles($hex) {
    $lum = function ($h) {
        $c = [hexdec(substr($h, 1, 2)), hexdec(substr($h, 3, 2)), hexdec(substr($h, 5, 2))];
        foreach ($c as $i => $v) { $v /= 255; $c[$i] = $v <= 0.03928 ? $v / 12.92 : pow(($v + 0.055) / 1.055, 2.4); }
        return 0.2126 * $c[0] + 0.7152 * $c[1] + 0.0722 * $c[2];
    };
    $contraste = function ($a, $b) { return (max($a, $b) + 0.05) / (min($a, $b) + 0.05); };
    $oscuro = '#34353d'; $l_osc = $lum($oscuro); $l_bla = 1.0;
    $fondo = $hex;
    for ($i = 0; $i < 12; $i++) {
        $l = $lum($fondo);
        if ($contraste($l, $l_osc) >= 4.5) { return [$fondo, $oscuro]; }
        if ($contraste($l, $l_bla) >= 4.5) { return [$fondo, '#ffffff']; }
        $r = (int)round(hexdec(substr($fondo, 1, 2)) * .9); $g = (int)round(hexdec(substr($fondo, 3, 2)) * .9); $b = (int)round(hexdec(substr($fondo, 5, 2)) * .9);
        $fondo = sprintf('#%02x%02x%02x', $r, $g, $b);
    }
    return [$fondo, '#ffffff'];
}

// --- 3. Estilos compartidos del diseño ---
function tm_estilos() { ?>
    <style>
        /* Outfit (licencia OFL) servida desde el propio sistema: no depende de internet */
        @font-face { font-family: 'Outfit'; font-style: normal; font-weight: 300; font-display: swap; src: url('../vendor/fonts/outfit/outfit-latin-300-normal.woff2') format('woff2'); }
        @font-face { font-family: 'Outfit'; font-style: normal; font-weight: 400; font-display: swap; src: url('../vendor/fonts/outfit/outfit-latin-400-normal.woff2') format('woff2'); }
        @font-face { font-family: 'Outfit'; font-style: normal; font-weight: 500; font-display: swap; src: url('../vendor/fonts/outfit/outfit-latin-500-normal.woff2') format('woff2'); }
        @font-face { font-family: 'Outfit'; font-style: normal; font-weight: 600; font-display: swap; src: url('../vendor/fonts/outfit/outfit-latin-600-normal.woff2') format('woff2'); }

        /* =====================================================================
           VARIABLES DE DISEÑO — derivadas EXCLUSIVAMENTE de la paleta de SB Admin 2
           (variaciones solo por opacidad o luminosidad del mismo color)
           ===================================================================== */
        .px {
            /* Primario y acento */
            --p: #4e73df;                       /* --primary */
            --p-rgb: 78, 115, 223;
            --p-osc: #224abe;                   /* extremo oscuro del degradado del menú */
            --p-prof: #183485;                  /* --p-osc con menor luminosidad (tarjeta oscura) */
            --acc: #36b9cc;                     /* --info: único acento */
            --acc-rgb: 54, 185, 204;
            /* Estados (uso suave) */
            --ok: #1cc88a; --ok-rgb: 28, 200, 138;
            --warn: #f6c23e; --warn-rgb: 246, 194, 62;
            --nar: #fd7e14; --nar-rgb: 253, 126, 20;
            --err: #e74a3b; --err-rgb: 231, 74, 59;
            --err-osc: #b8392d;                 /* --danger con menor luminosidad, para texto AA */
            /* Neutros */
            --blanco: #ffffff;
            --n-50: #f8f9fc;                    /* --light */
            --n-500: #858796;                   /* --gray: solo texto grande o decorativo */
            --n-700: #5a5c69;                   /* --gray-dark: etiquetas (6.9:1 sobre blanco) */
            --n-900: #34353d;                   /* --gray-dark con menor luminosidad: títulos y cifras */
            /* Superficies */
            --fondo: #eef2fb;                   /* --primary al ~9 % sobre blanco */
            --vidrio: rgba(255, 255, 255, .88);
            --borde: rgba(var(--p-rgb), .16);
            /* Elevación: contacto + sombra difusa azulada debajo + canto de vidrio (línea blanca interior arriba) */
            --sombra: 0 1px 2px rgba(var(--p-rgb), .06), 0 14px 30px -16px rgba(var(--p-rgb), .30), inset 0 1px 0 rgba(255, 255, 255, .95);
            --sombra-hover: 0 1px 2px rgba(var(--p-rgb), .08), 0 18px 36px -16px rgba(var(--p-rgb), .36), 0 0 0 1px rgba(var(--acc-rgb), .28), 0 0 26px rgba(var(--acc-rgb), .20), inset 0 1px 0 rgba(255, 255, 255, .95);
            --radio: 22px;
            --gap: 22px;
            --t: .25s cubic-bezier(.2, .8, .2, 1);
            font-family: 'Outfit', 'Segoe UI', Roboto, Arial, sans-serif;
            color: var(--n-900);
            font-size: 14px;
            padding-bottom: 12px;
        }
        #content-wrapper {
            background-color: #eef2fb;
            background-image:
                radial-gradient(900px 520px at 8% 0%, rgba(78, 115, 223, .10), transparent 70%),
                radial-gradient(700px 480px at 100% 30%, rgba(54, 185, 204, .09), transparent 70%),
                radial-gradient(800px 600px at 40% 100%, rgba(78, 115, 223, .08), transparent 70%);
            background-attachment: fixed;
        }

        /* ---------- Componentes base ---------- */
        .px .vidrio { background: var(--vidrio); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--borde); border-radius: var(--radio); box-shadow: var(--sombra); transition: transform var(--t), box-shadow var(--t), border-color var(--t); }
        /* Halo celeste solo como respuesta al pasar el mouse sobre una tarjeta de contenido */
        .px .vidrio.card-p:hover { box-shadow: var(--sombra-hover); border-color: rgba(var(--acc-rgb), .35); transform: translateY(-2px); }
        .px .card-p { padding: 22px 24px; height: 100%; display: flex; flex-direction: column; position: relative; }
        .px .etq { font-size: 12px; font-weight: 500; color: var(--n-700); letter-spacing: .2px; }
        .px .titulo-card { font-size: 18px; font-weight: 400; color: var(--n-900); margin: 0; }
        .px .sub-card { font-size: 12px; color: var(--n-700); margin-top: 2px; }
        .px .cifra { font-weight: 300; line-height: 1; color: var(--n-900); letter-spacing: -1px; }
        .px .pildora-ico { width: 34px; height: 34px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;
            background: var(--blanco); border: 1px solid var(--borde); color: var(--p); font-size: 13px; flex-shrink: 0; }
        .px .delta { display: inline-flex; align-items: center; gap: 4px; font-size: 12px; font-weight: 500; padding: 2px 9px; border-radius: 999px; white-space: nowrap; }
        .px .delta.bueno { background: rgba(var(--ok-rgb), .12); color: #13855c; }
        .px .delta.malo { background: rgba(var(--err-rgb), .10); color: var(--err-osc); }
        .px .delta.neutro { background: rgba(var(--p-rgb), .07); color: var(--n-700); }
        .px .punto-vivo { width: 8px; height: 8px; border-radius: 50%; background: var(--p); box-shadow: 0 0 0 4px rgba(var(--p-rgb), .15), 0 0 12px rgba(var(--p-rgb), .6); animation: pxLatido 2.4s ease-in-out infinite; display: inline-block; }
        @keyframes pxLatido { 0%, 100% { box-shadow: 0 0 0 3px rgba(var(--p-rgb), .15), 0 0 8px rgba(var(--p-rgb), .45); } 50% { box-shadow: 0 0 0 6px rgba(var(--p-rgb), .08), 0 0 16px rgba(var(--p-rgb), .7); } }
        .px .aparece { animation: pxAparece .5s cubic-bezier(.2, .8, .2, 1) both; }
        @keyframes pxAparece { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: none; } }

        /* ---------- Encabezado ---------- */
        .px .encabezado { display: flex; flex-wrap: wrap; align-items: flex-start; justify-content: space-between; gap: 18px; margin-bottom: 18px; }
        .px .encabezado h1 { font-size: 36px; font-weight: 600; letter-spacing: -.8px; color: var(--p-osc); margin: 0; }
        .px .encabezado .meta { display: flex; flex-wrap: wrap; align-items: center; gap: 14px; margin-top: 6px; font-size: 13px; color: var(--n-700); }
        .px .nav-pildora { display: inline-flex; flex-wrap: wrap; gap: 4px; padding: 5px; border-radius: 999px; }
        .px .nav-pildora a { display: inline-flex; align-items: center; gap: 7px; padding: 9px 16px; border-radius: 999px; font-size: 13px; font-weight: 500;
            color: var(--n-700); text-decoration: none; transition: background var(--t), color var(--t); }
        .px .nav-pildora a:hover { background: rgba(var(--p-rgb), .08); color: var(--p-osc); }
        .px .nav-pildora a.activo { background: var(--p); color: var(--blanco); box-shadow: 0 4px 14px rgba(var(--p-rgb), .35); }

        /* ---------- Filtros ---------- */
        .px .barra-filtros.filtros { padding: 14px 18px; margin-bottom: var(--gap); }
        .px .filtros .filtros-dropdowns { display: flex; flex-wrap: wrap; align-items: flex-end; gap: 12px; }
        .px .filtros .filtros-dropdowns > div { display: flex; flex-direction: column; gap: 4px; }
        .px .filtros label { font-size: 11.5px; font-weight: 500; color: var(--n-700); margin: 0 0 0 12px; }
        .px .filtros input[type=date], .px .filtros input[list] { height: 38px; padding: 6px 14px; border-radius: 999px; border: 1px solid var(--borde);
            background: rgba(255, 255, 255, .85); font-family: inherit; font-size: 13px; color: var(--n-900); outline: none; transition: border-color var(--t), box-shadow var(--t); }
        .px .filtros input[type=date] { width: 150px; }
        .px .filtros input[list] { width: 190px; text-transform: uppercase; }
        .px .filtros input:focus { border-color: var(--p); box-shadow: 0 0 0 3px rgba(var(--p-rgb), .15); }
        /* Campo fijado por el lugar de trabajo del usuario */
        .px .filtros input[readonly] { background: rgba(var(--p-rgb), .07); color: var(--n-700); cursor: not-allowed; box-shadow: none; }
        .px .filtros .btn-limpiar { height: 38px; border-radius: 999px; padding: 0 18px; font-size: 13px; font-weight: 500; border: 1px solid var(--borde); background: var(--blanco); color: var(--n-700); transition: background var(--t); }
        .px .filtros .btn-limpiar:hover { background: rgba(var(--p-rgb), .07); }
        .px .chips { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; margin-top: 12px; }
        .px .chip { display: inline-flex; align-items: center; gap: 8px; padding: 5px 6px 5px 13px; border-radius: 999px; background: rgba(var(--p-rgb), .08); color: var(--p-osc); font-size: 12.5px; font-weight: 500; }
        .px .chip a { width: 20px; height: 20px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; background: var(--blanco); color: var(--p-osc); font-size: 10px; text-decoration: none; }
        .px .chip a:hover { background: var(--err); color: var(--blanco); }

        /* ---------- Resumen: barra segmentada + cifras grandes ---------- */
        .px .resumen { display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 26px; margin-bottom: var(--gap); }
        .px .segmentos { flex: 1 1 520px; display: flex; gap: 8px; align-items: flex-end; min-width: 0; }
        .px .seg { min-width: 96px; display: flex; flex-direction: column; gap: 8px; transition: flex-grow .8s cubic-bezier(.2, .8, .2, 1); }
        .px .seg .etq { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; }
        .px .seg .etq i { margin-right: 5px; }
        .px .resumen .cifras { margin-left: 12px; }
        .px .seg .etq b { font-weight: 600; color: var(--n-900); }
        .px .seg .barra { height: 46px; border-radius: 999px; display: flex; align-items: center; padding: 0 16px; font-size: 13px; font-weight: 500; white-space: nowrap; overflow: hidden; }
        .px .seg.por_admitir .barra { background: repeating-linear-gradient(135deg, rgba(var(--warn-rgb), .9) 0 7px, rgba(var(--warn-rgb), .45) 7px 14px); color: var(--n-900); }
        .px .seg.en_valoracion .barra { background: var(--acc); color: var(--n-900); }
        .px .seg.efectivizadas .barra { background: var(--p); color: var(--blanco); }
        .px .seg.rechazadas .barra { background: transparent; border: 1.5px solid rgba(var(--err-rgb), .7); color: var(--err-osc); }
        .px .cifras { display: flex; flex-wrap: wrap; gap: 30px; }
        .px .cifras .item { display: flex; flex-direction: column; gap: 6px; }
        .px .cifras .item .cifra { font-size: 56px; }
        .px .cifras .item .cifra small { font-size: 22px; font-weight: 300; letter-spacing: 0; }
        .px .cifras .item .pie { display: flex; align-items: center; gap: 8px; }

        /* ---------- Grid principal (estilo de la muestra) ---------- */
        .px .grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--gap); margin-bottom: var(--gap); }
        .px .g-pend { grid-row: span 2; }
        .px .g-mapa { grid-column: span 2; }
        .px .grid-2 { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--gap); }
        .px .cab-card { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; margin-bottom: 12px; }

        /* Anillos */
        .px .anillo-wrap { position: relative; width: 190px; max-width: 100%; aspect-ratio: 1 / 1; margin: 6px auto 0; }
        .px .anillo-wrap svg { width: 100%; height: 100%; transform: rotate(-90deg); }
        .px .anillo-wrap .centro { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; }
        .px .anillo-wrap .centro .cifra { font-size: 40px; }
        .px .anillo-wrap .centro .cifra small { font-size: 18px; }
        .px .arco { fill: none; stroke-linecap: round; transition: stroke-dashoffset 1.4s cubic-bezier(.2, .8, .2, 1); }
        .px .pie-card { margin-top: auto; padding-top: 14px; display: flex; align-items: center; justify-content: space-between; gap: 10px; font-size: 12.5px; color: var(--n-700); }

        /* Tendencia: barras finas con punto */
        .px .tend { display: flex; align-items: flex-end; justify-content: space-between; gap: 4px; height: 170px; margin-top: 34px; }
        .px .tend .col { flex: 1 1 0; display: flex; flex-direction: column; align-items: center; justify-content: flex-end; gap: 6px; height: 100%; position: relative; min-width: 0; max-width: none; padding: 0; }
        .px .tend .pista { width: 6px; flex: 1; display: flex; align-items: flex-end; border-radius: 6px; background: repeating-linear-gradient(to top, rgba(var(--p-rgb), .14) 0 3px, transparent 3px 7px); }
        .px .tend .relleno { width: 100%; border-radius: 6px; background: var(--n-700); height: 0; transition: height 1s cubic-bezier(.2, .8, .2, 1); }
        .px .tend .col.max .relleno { background: var(--p); }
        .px .tend .dot { width: 6px; height: 6px; border-radius: 50%; background: var(--n-700); }
        .px .tend .col.max .dot { background: var(--p); }
        .px .tend .lbl { font-size: 10.5px; color: var(--n-700); white-space: nowrap; line-height: 1.15; text-align: center; min-height: 26px; }
        .px .tend .lbl small { display: block; font-size: 9.5px; color: var(--n-700); opacity: .85; }
        .px .tend.inclinada { margin-bottom: 14px; }
        .px .tend.inclinada .lbl { transform: rotate(-45deg); transform-origin: top center; margin-top: 6px; min-height: 18px; }
        /* Colores por categoría (canales y dispositivos): ícono, fondo suave y barra del mismo tono */
        .px .lista-barras .pildora-ico { color: var(--cc, var(--p)); background: rgba(var(--cc-rgb, var(--p-rgb)), .12); border-color: rgba(var(--cc-rgb, var(--p-rgb)), .25); }
        .px .lista-barras .item .pista span { background: var(--cc, var(--p)); }
        .px .tend .globo { position: absolute; top: -4px; transform: translateY(-100%); background: var(--p); color: var(--blanco); font-size: 11px; font-weight: 500; padding: 2px 8px; border-radius: 999px; white-space: nowrap; }

        /* Desglose de tiempos */
        .px .desglose { display: flex; gap: 8px; margin-top: 12px; }
        .px .desglose > div { flex: 1; border-radius: 14px; padding: 8px 12px; background: rgba(var(--p-rgb), .05); }
        .px .desglose b { display: block; font-size: 16px; font-weight: 500; color: var(--n-900); }

        /* Pendientes: segmentos de antigüedad + tarjeta oscura */
        .px .antig { display: flex; gap: 6px; align-items: flex-end; margin: 6px 0 4px; }
        .px .antig .s { display: flex; flex-direction: column; gap: 6px; min-width: 36px; transition: flex-grow .8s cubic-bezier(.2, .8, .2, 1); }
        .px .antig .s span { font-size: 12px; color: var(--n-700); border-left: 1px solid rgba(var(--p-rgb), .25); padding-left: 6px; white-space: nowrap; }
        .px .antig .s i { display: block; height: 34px; border-radius: 12px; }
        .px .antig .ok i { background: rgba(var(--ok-rgb), .75); } .px .antig .warn i { background: rgba(var(--warn-rgb), .85); }
        .px .antig .naranja i { background: rgba(var(--nar-rgb), .75); } .px .antig .err i { background: rgba(var(--err-rgb), .8); }
        .px .leyenda-antig { display: flex; flex-wrap: wrap; gap: 4px 12px; font-size: 11.5px; color: var(--n-700); margin-bottom: 14px; }
        .px .leyenda-antig i { display: inline-block; width: 8px; height: 8px; border-radius: 3px; margin-right: 5px; }
        .px .oscura { background: linear-gradient(165deg, var(--p-osc) 0%, var(--p-prof) 100%); color: var(--blanco); border-radius: 20px; padding: 20px 18px; display: flex; flex-direction: column; }
        .px .detalle-antig { margin-top: 18px; display: flex; flex-direction: column; gap: 12px; }
        .px .detalle-antig .fila-a { display: grid; grid-template-columns: 74px 1fr 30px; align-items: center; gap: 10px; font-size: 12.5px; color: var(--n-700); }
        .px .detalle-antig .pista-a { height: 8px; border-radius: 8px; background: rgba(var(--p-rgb), .08); overflow: hidden; }
        .px .detalle-antig .pista-a span { display: block; height: 100%; width: 0; border-radius: 8px; transition: width 1.1s cubic-bezier(.2, .8, .2, 1); }
        .px .detalle-antig .fila-a b { text-align: right; font-weight: 500; color: var(--n-900); }
        .px .detalle-antig small { grid-column: 2 / 4; margin-top: -8px; font-size: 11.5px; color: var(--n-700); }
        .px .oscura .cab { display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 10px; }
        .px .oscura .cab h6 { font-size: 16px; font-weight: 400; margin: 0; color: var(--blanco); }
        .px .oscura .cab .cifra { color: var(--blanco); font-size: 34px; }
        .px .oscura .fila { display: flex; align-items: center; gap: 12px; padding: 10px 0; border-top: 1px solid rgba(255, 255, 255, .12); }
        .px .oscura .fila .ico { width: 36px; height: 36px; border-radius: 50%; background: rgba(255, 255, 255, .12); display: inline-flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0; }
        .px .oscura .fila .txt { flex: 1; min-width: 0; }
        .px .oscura .fila .txt b { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; font-size: 12.5px; font-weight: 500; line-height: 1.3; }
        .px .oscura .fila .txt small { font-size: 11.5px; color: rgba(255, 255, 255, .78); }
        .px .oscura .fila .num { text-align: right; }
        .px .oscura .fila .num b { display: block; font-size: 18px; font-weight: 400; }
        .px .oscura .fila .num small { font-size: 11px; color: rgba(255, 255, 255, .85); display: inline-flex; align-items: center; gap: 5px; }
        .px .oscura .sem { width: 7px; height: 7px; border-radius: 50%; display: inline-block; }
        .px .oscura .sem.ok { background: var(--ok); box-shadow: 0 0 8px rgba(var(--ok-rgb), .8); }
        .px .oscura .sem.naranja { background: var(--warn); box-shadow: 0 0 8px rgba(var(--warn-rgb), .8); }
        .px .oscura .sem.err { background: var(--err); box-shadow: 0 0 8px rgba(var(--err-rgb), .8); }
        .px .oscura .vacio { margin: auto; text-align: center; color: rgba(255, 255, 255, .85); font-size: 13px; }
        .px .oscura .mas { margin-top: auto; padding-top: 10px; font-size: 12px; color: rgba(255, 255, 255, .8); }

        /* Perfil en acordeón */
        .px .acord { border-top: 1px dashed rgba(var(--p-rgb), .18); }
        .px .acord:first-of-type { border-top: 0; }
        .px .acord-cab { width: 100%; background: none; border: 0; padding: 14px 0; display: flex; align-items: center; gap: 10px; cursor: pointer; text-align: left; font-family: inherit; }
        .px .acord-cab .t { flex: 1; font-size: 15px; font-weight: 400; color: var(--n-900); }
        .px .acord-cab .r { font-size: 12px; color: var(--n-700); }
        .px .acord-cab .chev { color: var(--n-700); transition: transform var(--t); }
        .px .acord.abierto .chev { transform: rotate(180deg); }
        .px .acord-cuerpo { max-height: 0; overflow: hidden; transition: max-height .35s cubic-bezier(.2, .8, .2, 1); }
        .px .acord.abierto .acord-cuerpo { max-height: 220px; }
        .px .acord-cuerpo .dentro { padding: 0 0 14px; }
        .px .prop { display: flex; height: 8px; border-radius: 8px; overflow: hidden; background: rgba(var(--p-rgb), .08); }
        .px .prop span { height: 100%; width: 0; transition: width 1.1s cubic-bezier(.2, .8, .2, 1); }
        .px .prop span + span { border-left: 2px solid var(--blanco); }
        .px .prop-items { display: flex; flex-direction: column; gap: 6px; margin-top: 10px; }
        .px .prop-items div { display: flex; align-items: center; gap: 8px; font-size: 12.5px; color: var(--n-700); }
        .px .prop-items div b { margin-left: auto; font-weight: 500; color: var(--n-900); }
        .px .prop-items i.p { width: 8px; height: 8px; border-radius: 3px; display: inline-block; }

        /* Mapa */
        .px .mapa-wrap { position: relative; border-radius: 16px; overflow: hidden; background: rgba(var(--p-rgb), .04); flex: 1; }
        .px #contenedor-mapa { height: 470px; }
        .px .mapa-capas { position: absolute; top: 12px; left: 12px; z-index: 5; display: inline-flex; padding: 4px; gap: 2px; border-radius: 999px; background: rgba(255, 255, 255, .85); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid var(--borde); }
        .px .mapa-capas button { border: 0; background: transparent; font-family: inherit; font-size: 12px; font-weight: 500; color: var(--n-700); padding: 6px 12px; border-radius: 999px; cursor: pointer; transition: background var(--t), color var(--t); }
        .px .mapa-capas button:hover { background: rgba(var(--p-rgb), .08); }
        .px .mapa-capas button.activo { background: var(--p); color: var(--blanco); }
        .px .mapa-capas button:disabled { opacity: .4; cursor: not-allowed; }
        .px .mapa-btn { position: absolute; top: 12px; right: 12px; z-index: 5; width: 38px; height: 38px; border-radius: 50%; border: 1px solid var(--borde); background: rgba(255, 255, 255, .9); color: var(--p); cursor: pointer; transition: transform var(--t); }
        .px .mapa-btn:hover { transform: scale(1.06); }
        .px .mapa-rutas { position: absolute; left: 12px; bottom: 12px; z-index: 5; min-width: 220px; max-width: 280px; padding: 12px 14px; border-radius: 16px; background: rgba(255, 255, 255, .85); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid var(--borde); }
        .px .mapa-rutas h6 { font-size: 12px; font-weight: 500; color: var(--n-700); margin: 0 0 6px; }
        .px .ruta { display: flex; align-items: center; gap: 8px; font-size: 12.5px; padding: 3px 0; }
        .px .ruta .n { width: 20px; height: 20px; border-radius: 50%; background: rgba(var(--p-rgb), .1); color: var(--p-osc); font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; justify-content: center; }
        .px .ruta .txt { flex: 1; color: var(--n-900); }
        .px .ruta .txt i { color: var(--p); font-size: 10px; margin: 0 4px; }
        .px .mapa-aviso { position: absolute; left: 12px; top: 58px; z-index: 5; font-size: 11.5px; padding: 5px 12px; border-radius: 999px; background: rgba(255, 255, 255, .9); color: var(--n-700); display: none; }
        .px .tic-mapa .highcharts-flowmap-series .highcharts-point { animation: pxPulso 2.6s ease-in-out infinite; filter: drop-shadow(0 0 3px rgba(var(--p-rgb), .5)); }
        @keyframes pxPulso { 0%, 100% { opacity: .55; } 50% { opacity: 1; } }
        .px .tic-mapa:fullscreen { border-radius: 0; background: var(--n-50); padding: 16px; }
        .px .tic-mapa:fullscreen #contenedor-mapa { height: calc(100vh - 110px); }

        /* Estados de carga y vacío */
        .px .esqueleto { height: 100%; min-height: 120px; border-radius: 16px; background: linear-gradient(90deg, rgba(var(--p-rgb), .05) 25%, rgba(var(--p-rgb), .09) 37%, rgba(var(--p-rgb), .05) 63%); background-size: 400% 100%; animation: pxBrillo 1.4s ease infinite; }
        @keyframes pxBrillo { 0% { background-position: 100% 50%; } 100% { background-position: 0 50%; } }
        .px .vacio { height: 100%; min-height: 180px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 6px; text-align: center; color: var(--n-700); font-size: 13px; }
        .px .vacio i { font-size: 34px; color: rgba(var(--p-rgb), .25); margin-bottom: 4px; }

        /* Menú de exportación de Highcharts */
        .highcharts-contextmenu, .highcharts-data-table table { font-family: 'Outfit', 'Segoe UI', Arial, sans-serif; }
        .highcharts-data-table table { font-size: 12.5px; border-collapse: collapse; width: 100%; margin-top: 10px; }
        .highcharts-data-table th, .highcharts-data-table td { padding: 6px 10px; border-bottom: 1px solid rgba(78, 115, 223, .1); text-align: left; }
        .highcharts-data-table caption { display: none; }


        /* Segmentos genéricos (Teleconsultas / Telemetrías): tonos del primario y el acento */
        .px .seg.s1 .barra { background: var(--p); color: var(--blanco); }
        .px .seg.s2 .barra { background: var(--acc); color: var(--n-900); }
        .px .seg.s3 .barra { background: rgba(var(--p-rgb), .45); color: var(--n-900); }
        .px .seg.s4 .barra { background: rgba(var(--p-rgb), .14); color: var(--p-osc); }
        .px .seg.s5 .barra { background: repeating-linear-gradient(135deg, rgba(var(--p-rgb), .22) 0 7px, rgba(var(--p-rgb), .08) 7px 14px); color: var(--n-900); }
        .px .resumen .titulo-seg { flex-basis: 100%; margin-bottom: -14px; }
        /* Segmento con el color de su categoría (mismo color que en la lista de dispositivos) */
        .px .seg.cc .barra { background: var(--cc); color: var(--cc-txt); }

        /* Lista con barras finas (canales, dispositivos, grupos) */
        .px .lista-barras { display: flex; flex-direction: column; gap: 14px; margin-top: 6px; }
        .px .lista-barras .item { display: grid; grid-template-columns: 34px minmax(0, 1fr); align-items: center; gap: 12px; }
        .px .lista-barras .nom { font-size: 13px; color: var(--n-900); display: flex; justify-content: space-between; gap: 8px; margin-bottom: 6px; }
        .px .lista-barras .nom b { font-weight: 500; white-space: nowrap; }
        .px .lista-barras .nom b small { color: var(--n-700); font-weight: 400; font-size: 12px; }
        .px .lista-barras .pista { height: 6px; border-radius: 6px; background: rgba(var(--p-rgb), .08); overflow: hidden; }
        .px .lista-barras .pista span { display: block; height: 100%; width: 0; border-radius: 6px; background: var(--p); transition: width 1.1s cubic-bezier(.2, .8, .2, 1); }

        @media (max-width: 1399.98px) {
            .px .grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .px .g-pend { grid-row: span 1; }
            .px .g-mapa { grid-column: span 2; }
        }
        @media (max-width: 767.98px) {
            .px .grid, .px .grid-2 { grid-template-columns: minmax(0, 1fr); }
            .px .g-mapa { grid-column: span 1; }
            .px .encabezado h1 { font-size: 28px; }
            .px .cifras .item .cifra { font-size: 42px; }
            .px .filtros input[type=date], .px .filtros input[list] { width: 100%; }
            .px .filtros .filtros-dropdowns > div { width: 100%; }
            .px #contenedor-mapa { height: 360px; }
            .px .mapa-rutas { display: none; }
            .px .segmentos { flex-wrap: wrap; }
        }
        @media (prefers-reduced-motion: reduce) { .px *, .px *::before, .px *::after { animation: none !important; transition: none !important; } }
    </style>
<?php }
