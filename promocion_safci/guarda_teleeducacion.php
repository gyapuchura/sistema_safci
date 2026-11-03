<?php
include("../cabf.php");
include("../inc.config.php");
include("inc_teleeducacion.php");

// =========================================================================
// GUARDA UNA SESIÓN DE TELEEDUCACIÓN (nueva o modificada)
//   - El establecimiento sale del lugar de trabajo actual del usuario (no del formulario)
//   - Todas las opciones se validan por id contra los catálogos de la base (activas, y del tipo elegido)
//   - Asistentes: asistentes[idgrupo][idgenero] = cantidad, solo de los grupos del tipo elegido
//   - Fecha de la sesión: solo del mes en curso (te_fecha_permitida), como los demás servicios de Telemedicina
//   - Modificar: solo quien la registró y dentro del mes de registro (te_editable)
//   - Cabecera, asistentes y recursos se guardan juntos en una transacción
// =========================================================================
date_default_timezone_set('America/La_Paz');
$hoy     = date("Y-m-d");
$hora    = date("H:i");
$gestion = (int)date("Y");
$idusuario_ss = (int)$_SESSION['idusuario_ss'];

// Vuelve al formulario con un mensaje (ok=... o error=...)
function te_volver($params) {
    header("Location: teleeducacion.php?" . http_build_query($params));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { te_volver([]); }

$post = function ($k) { return isset($_POST[$k]) && !is_array($_POST[$k]) ? trim((string)$_POST[$k]) : ''; };
$id   = (int)$post('idteleeducacion');   // > 0 = modificación
$cat  = te_catalogos($link);

// --- 1. Lugar de trabajo actual ---
$lugar = te_lugar($link, $idusuario_ss);
if (!$lugar) { te_volver(['error' => 'sin_lugar']); }

// --- 2. Modificación: el registro debe existir y ser editable por este usuario ---
$actual = null;
if ($id > 0) {
    $actual = te_leer($link, $id);
    if (!$actual) { te_volver(['error' => 'no_existe']); }
    if (!te_editable($actual, $idusuario_ss)) { te_volver(['error' => 'fuera_de_plazo']); }
}

// Una opción es válida si existe, está activa y (si aplica) pertenece al tipo;
// al modificar se acepta también la opción ya guardada aunque luego se haya desactivado
$valida = function ($lista, $valor, $campo_actual, $idtipo = null) use ($actual) {
    $v = (int)$valor;
    if ($v <= 0 || !isset($lista[$v])) { return false; }
    if ($idtipo !== null && isset($lista[$v]['idtipo']) && $lista[$v]['idtipo'] !== $idtipo) { return false; }
    return $lista[$v]['activo'] || ($actual && (int)$actual[$campo_actual] === $v);
};

// --- 3. Datos generales ---
$idtipo = (int)$post('idtipo_teleeducacion');
if (!$valida($cat['tipos'], $idtipo, 'idtipo_teleeducacion')) { te_volver(['error' => 'datos']); }
$tipo = $cat['tipos'][$idtipo];

$fecha_sesion = $post('fecha_sesion');
$f = DateTime::createFromFormat('Y-m-d', $fecha_sesion);
if (!$f || $f->format('Y-m-d') !== $fecha_sesion) { te_volver(['error' => 'fecha']); }
// Solo sesiones del mes en curso (del día 1 a hoy), también al modificar
if (!te_fecha_permitida($fecha_sesion)) { te_volver(['error' => 'fecha']); }

// Duración: horas + minutos (0 a 59), se guarda en minutos
$dur_h = $post('duracion_horas') === '' ? '0' : $post('duracion_horas');
$dur_m = $post('duracion_minutos') === '' ? '0' : $post('duracion_minutos');
if (!te_duracion_valida($dur_h, $dur_m)) { te_volver(['error' => 'duracion']); }
$duracion = (int)$dur_h * 60 + (int)$dur_m;

// --- 4. Datos de la actividad (validados contra los catálogos) ---
$idactividad      = (int)$post('idactividad_teleeducacion');
$nombre_actividad = mb_substr(preg_replace('/\s+/u', ' ', $post('nombre_actividad')), 0, 255);
$idmodalidad      = (int)$post('idmodalidad_teleeducacion');
$idmedio          = (int)$post('idmedio_digital');
if (!$valida($cat['actividades'], $idactividad, 'idactividad_teleeducacion', $idtipo) || $nombre_actividad === ''
    || !$valida($cat['modalidades'], $idmodalidad, 'idmodalidad_teleeducacion') || !$valida($cat['medios'], $idmedio, 'idmedio_digital')) {
    te_volver(['error' => 'datos']);
}

// --- 5. Asistentes del tipo elegido: enteros >= 0, al menos 1 en total ---
// Grupos permitidos: los activos del tipo; al modificar, también los que ya tenían datos
$permitidos = te_grupos_captura($cat, $idtipo);
if ($actual && (int)$actual['idtipo_teleeducacion'] === $idtipo) {
    foreach (array_keys($actual['grupos']) as $gid) { if (isset($cat['grupos'][$gid]) && $cat['grupos'][$gid]['idtipo'] === $idtipo && !$cat['grupos'][$gid]['hijos']) { $permitidos[] = $gid; } }
}
$enviados = isset($_POST['asistentes']) && is_array($_POST['asistentes']) ? $_POST['asistentes'] : [];
$filas = []; $total = 0;
foreach (array_unique($permitidos) as $gid) {
    foreach (array_keys($cat['generos']) as $idgenero) {
        $v = isset($enviados[$gid][$idgenero]) && !is_array($enviados[$gid][$idgenero]) ? trim((string)$enviados[$gid][$idgenero]) : '';
        if ($v !== '' && !ctype_digit($v)) { te_volver(['error' => 'asistentes']); }
        $n = min((int)$v, 99999);
        if ($n > 0) { $filas[] = [$gid, $idgenero, $n]; $total += $n; }
    }
}
if ($total < 1) { te_volver(['error' => 'asistentes']); }

// --- 6. Recursos usados (solo tipos que los requieren, al menos uno) ---
$recursos = [];
if ($tipo['requiere_recursos']) {
    $env = isset($_POST['recursos']) && is_array($_POST['recursos']) ? $_POST['recursos'] : [];
    $guardados = $actual ? $actual['recursos'] : [];
    foreach ($env as $r) {
        $r = (int)$r;
        if (isset($cat['recursos'][$r]) && ($cat['recursos'][$r]['activo'] || in_array($r, $guardados, true)) && !in_array($r, $recursos, true)) { $recursos[] = $r; }
    }
    if (!$recursos) { te_volver(['error' => 'recursos']); }
}

// --- 7. Guardar en una transacción ---
$dep = (int)$lugar['iddepartamento']; $mun = (int)$lugar['idmunicipio']; $est = (int)$lugar['idestablecimiento_salud'];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    mysqli_begin_transaction($link);

    if ($id > 0) {
        // Modificación: conserva código, establecimiento y fecha de registro originales
        $st = mysqli_prepare($link, "UPDATE teleeducacion SET idtipo_teleeducacion = ?, fecha_sesion = ?, duracion_minutos = ?, idactividad_teleeducacion = ?, nombre_actividad = ?,
            idmodalidad_teleeducacion = ?, idmedio_digital = ?, asistentes = ?, fecha_modificacion = NOW()
            WHERE idteleeducacion = ? AND idusuario = ?");
        mysqli_stmt_bind_param($st, 'isiisiiiii', $idtipo, $fecha_sesion, $duracion, $idactividad, $nombre_actividad,
            $idmodalidad, $idmedio, $total, $id, $idusuario_ss);
        mysqli_stmt_execute($st);
        mysqli_query($link, "DELETE FROM teleeducacion_asistente WHERE idteleeducacion = '$id'");
        mysqli_query($link, "DELETE FROM teleeducacion_recurso WHERE idteleeducacion = '$id'");
        $codigo = $actual['codigo'];
    } else {
        // Correlativo nacional de la gestión; FOR UPDATE evita que dos registros simultáneos tomen el mismo número
        $res = mysqli_query($link, "SELECT IFNULL(MAX(correlativo), 0) + 1 FROM teleeducacion WHERE gestion = '$gestion' FOR UPDATE");
        $correlativo = (int)mysqli_fetch_row($res)[0];
        $codigo = "MSYD/TELEDU/$correlativo/$gestion";

        $st = mysqli_prepare($link, "INSERT INTO teleeducacion (iddepartamento, idmunicipio, idestablecimiento_salud, correlativo, codigo, gestion,
            idtipo_teleeducacion, fecha_sesion, duracion_minutos, idactividad_teleeducacion, nombre_actividad, idmodalidad_teleeducacion, idmedio_digital,
            asistentes, fecha_registro, hora_registro, idusuario)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($st, 'iiiisiisiisiiissi', $dep, $mun, $est, $correlativo, $codigo, $gestion,
            $idtipo, $fecha_sesion, $duracion, $idactividad, $nombre_actividad, $idmodalidad, $idmedio,
            $total, $hoy, $hora, $idusuario_ss);
        mysqli_stmt_execute($st);
        $id = (int)mysqli_insert_id($link);
    }

    $st = mysqli_prepare($link, "INSERT INTO teleeducacion_asistente (idteleeducacion, idgrupo_asistente_te, idgenero, cantidad) VALUES (?, ?, ?, ?)");
    foreach ($filas as $fl) {
        mysqli_stmt_bind_param($st, 'iiii', $id, $fl[0], $fl[1], $fl[2]);
        mysqli_stmt_execute($st);
    }
    if ($recursos) {
        $st = mysqli_prepare($link, "INSERT INTO teleeducacion_recurso (idteleeducacion, idrecurso_teleeducacion) VALUES (?, ?)");
        foreach ($recursos as $r) {
            mysqli_stmt_bind_param($st, 'ii', $id, $r);
            mysqli_stmt_execute($st);
        }
    }

    mysqli_commit($link);
} catch (mysqli_sql_exception $e) {
    mysqli_rollback($link);
    error_log('guarda_teleeducacion: ' . $e->getMessage());
    te_volver(['error' => 'guardar']);
}

te_volver(['ok' => $actual ? 'modificado' : 'registrado', 'codigo' => $codigo]);
