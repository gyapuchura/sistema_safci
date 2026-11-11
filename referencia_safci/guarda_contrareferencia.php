<?php
include("../cabf.php");
include("../inc.config.php");
include("inc_contrareferencia.php");

// =========================================================================
// GUARDA CONTRARREFERENCIA
// - El caso se identifica por el token del formulario (no por variables de sesión
//   que otra pestaña puede cambiar).
// - Se valida TODO antes de escribir; si algo no cuadra, no se guarda nada.
// - Se guardan los mismos IDs en las mismas columnas que antes.
// =========================================================================
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
date_default_timezone_set('America/La_Paz');

$fecha = date("Y-m-d");
$hora  = date("H:i");

$idusuario_ss = (int)$_SESSION['idusuario_ss'];

$MSG_ATRAS = "\nUse el botón ATRÁS del navegador para volver al formulario y corregirlo.";

// -------------------------------------------------------------------------
// 1. El envío debe llegar completo
// -------------------------------------------------------------------------
if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location:admitidos_referencia.php");
    exit();
}

if (empty($_POST)) {
    // PHP descarta todo el formulario cuando el envío supera post_max_size
    $bytes = isset($_SERVER['CONTENT_LENGTH']) ? (int)$_SERVER['CONTENT_LENGTH'] : 0;
    error_log("[contrarreferencia] POST vacio. CONTENT_LENGTH=$bytes usuario=$idusuario_ss");
    $limite_mb = round(cr_limite_envio() / 1048576, 1);
    cr_aviso("El envío superó el tamaño máximo permitido por el servidor ($limite_mb MB), probablemente por los archivos adjuntos.\n"
           . "La contrarreferencia NO se registró.$MSG_ATRAS Quite algunos adjuntos o use fotos más livianas.");
}

// -------------------------------------------------------------------------
// 2. Caso que se está contrarrefiriendo (token del formulario)
// -------------------------------------------------------------------------
$token = isset($_POST['token_contraref']) ? (string)$_POST['token_contraref'] : '';
$ctx   = cr_token_leer($token);
if ($ctx === null) {
    cr_aviso("Este formulario ya fue enviado o expiró, por eso no se registró nada nuevo.\n"
           . "Revise en la bandeja de admitidos: si el paciente sigue ahí, vuelva a abrir el caso.");
}

$idreferencia_hc        = (int)$ctx['idreferencia_hc'];
$idderiva_referencia_hc = (int)$ctx['idderiva_referencia_hc'];
$edad                   = (string)(int)$ctx['edad'];

if ($idreferencia_hc <= 0 || $idderiva_referencia_hc <= 0) {
    cr_aviso("No se pudo identificar el caso. La contrarreferencia NO se registró.\nVuelva a abrir el caso desde la bandeja de admitidos.");
}

// -------------------------------------------------------------------------
// 3. Lectura de campos
// -------------------------------------------------------------------------
function cr_txt($clave)
{
    return isset($_POST[$clave]) ? mb_strtoupper(trim((string)$_POST[$clave]), 'UTF-8') : '';
}
function cr_num($clave)
{
    if (!isset($_POST[$clave])) {
        return null;
    }
    $v = str_replace(',', '.', trim((string)$_POST[$clave]));
    return ($v !== '' && is_numeric($v)) ? $v : null;
}

$dias_internacion_ref = cr_num('dias_internacion_ref');
$dias_internacion_ref = ($dias_internacion_ref === null) ? '0' : (string)max(0, (int)$dias_internacion_ref);

// Signos vitales (vacío = NULL)
$talla              = cr_num('talla');
$peso               = cr_num('peso');
$temperatura        = cr_num('temperatura');
$frec_cardiaca      = cr_num('frec_cardiaca');
$frec_respiratoria  = cr_num('frec_respiratoria');
$presion_arterial   = cr_num('presion_arterial');
$presion_arterial_d = cr_num('presion_arterial_d');
$saturacion         = cr_num('saturacion');

// Textos
$evolucion_complicacion          = cr_txt('evolucion_complicacion');
$examenes_complementarios_egreso = cr_txt('examenes_complementarios_egreso');
$otros_examenes                  = cr_txt('otros_examenes');
$tratamientos_realizados         = cr_txt('tratamientos_realizados');
$recomendaciones_paciente        = cr_txt('recomendaciones_paciente');
$otros_anexos                    = cr_txt('otros_anexos');
$observaciones_recomendaciones   = cr_txt('observaciones_recomendaciones');
$contacto_contraref              = cr_txt('contacto_contraref');
$nombre_acompanante_cref         = cr_txt('nombre_acompanante_cref');
$tel_establecimiento_cref        = isset($_POST['tel_establecimiento_cref']) ? trim((string)$_POST['tel_establecimiento_cref']) : '';
$contacto_eess_cref              = (isset($_POST['contacto_eess_cref']) && $_POST['contacto_eess_cref'] === 'SI') ? 'SI' : 'NO';

// -------------------------------------------------------------------------
// 4. Telesalud (IDs del catálogo; sin marcar = NO)
// -------------------------------------------------------------------------
$por_telesalud = (isset($_POST['por_telesalud']) && $_POST['por_telesalud'] === 'SI') ? 'SI' : 'NO';

if ($por_telesalud === 'SI') {
    $idtiempo_ts              = isset($_POST['idtiempo_ts']) ? (int)$_POST['idtiempo_ts'] : 0;
    $idtipo_teleinterconsulta = isset($_POST['idtipo_teleinterconsulta']) ? (int)$_POST['idtipo_teleinterconsulta'] : 0;
    $atencion_sitio           = isset($_POST['atencion_sitio']) ? (string)$_POST['atencion_sitio'] : '';

    $ok_tiempo = $idtiempo_ts > 0 && cr_fila($link, "SELECT idtiempo_ts FROM tiempo_ts WHERE idtiempo_ts = ?", 'i', array($idtiempo_ts));
    $ok_tipo   = $idtipo_teleinterconsulta > 1 && cr_fila($link, "SELECT idtipo_teleinterconsulta FROM tipo_teleinterconsulta WHERE idtipo_teleinterconsulta = ?", 'i', array($idtipo_teleinterconsulta));
    $ok_sitio  = in_array($atencion_sitio, array('SI', 'NO'), true);

    if (!$ok_tiempo || !$ok_tipo || !$ok_sitio) {
        cr_aviso("Marcó POR TELESALUD pero falta TIEMPO, ATENCIÓN EN SITIO o TIPO DE TELEINTERCONSULTA.\nLa contrarreferencia NO se registró.$MSG_ATRAS");
    }
} else {
    // No es por Telesalud: tipo = 1 (NINGUNO, igual que guarda_referencia.php); tiempo y sitio vacíos
    $idtiempo_ts              = null;
    $atencion_sitio           = null;
    $idtipo_teleinterconsulta = 1;
}

// -------------------------------------------------------------------------
// 5. Diagnósticos de egreso: el 1 es obligatorio; 2 y 3 opcionales,
//    pero si tienen texto deben tener CIE-10.
// -------------------------------------------------------------------------
$diagnosticos = (isset($_POST['diagnostico_egreso']) && is_array($_POST['diagnostico_egreso'])) ? $_POST['diagnostico_egreso'] : array();
$patologias   = (isset($_POST['idpatologia']) && is_array($_POST['idpatologia'])) ? $_POST['idpatologia'] : array();

$claves = array_unique(array_merge(array_keys($diagnosticos), array_keys($patologias)));
$claves = array_filter($claves, function ($k) { return is_numeric($k) && (int)$k >= 0; });
sort($claves);

$filas_dx = array();
foreach ($claves as $clave) {
    $clave  = (int)$clave;
    $texto  = isset($diagnosticos[$clave]) ? mb_strtoupper(trim((string)$diagnosticos[$clave]), 'UTF-8') : '';
    $id_pat = isset($patologias[$clave]) ? (int)$patologias[$clave] : 0;

    if ($texto === '' && $id_pat <= 0) {
        continue; // fila vacía (permitido en 2 y 3)
    }
    if ($id_pat <= 0) {
        if ($clave === 0) {
            continue; // se reporta abajo como falta del diagnóstico principal
        }
        cr_aviso("El diagnóstico " . ($clave + 1) . " tiene texto pero no tiene CIE-10 seleccionado.\nLa contrarreferencia NO se registró.$MSG_ATRAS");
    }
    if (!cr_fila($link, "SELECT idpatologia FROM patologia WHERE idpatologia = ?", 'i', array($id_pat))) {
        cr_aviso("El CIE-10 del diagnóstico " . ($clave + 1) . " no es válido.\nLa contrarreferencia NO se registró.$MSG_ATRAS");
    }
    $filas_dx[$clave] = array('texto' => $texto, 'id' => $id_pat);
}

if (!isset($filas_dx[0])) {
    cr_aviso("Falta el diagnóstico CIE-10 principal (diagnóstico 1).\nLa contrarreferencia NO se registró.$MSG_ATRAS");
}

// -------------------------------------------------------------------------
// 6. Adjunto: se valida ANTES de guardar (se mueve al final, si todo salió bien)
// -------------------------------------------------------------------------
$adjunto = null;
if (isset($_FILES['archivo_contrareferencia_pdf']) && $_FILES['archivo_contrareferencia_pdf']['error'] !== UPLOAD_ERR_NO_FILE) {
    $f = $_FILES['archivo_contrareferencia_pdf'];
    $limite_mb = cr_limite_adjunto_mb();
    if ($f['error'] === UPLOAD_ERR_INI_SIZE || $f['error'] === UPLOAD_ERR_FORM_SIZE) {
        cr_aviso("Los archivos adjuntos superan el tamaño máximo permitido ($limite_mb MB).\nLa contrarreferencia NO se registró.$MSG_ATRAS");
    }
    if ($f['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($f['tmp_name'])) {
        error_log("[contrarreferencia] error de subida " . $f['error'] . " ref=$idreferencia_hc usuario=$idusuario_ss");
        cr_aviso("El archivo adjunto no llegó completo (posible corte de conexión).\nLa contrarreferencia NO se registró.$MSG_ATRAS");
    }
    if ((int)$f['size'] > cr_limite_adjunto()) {
        cr_aviso("Los archivos adjuntos suman " . round($f['size'] / 1048576, 1) . " MB y el máximo permitido es $limite_mb MB.\nLa contrarreferencia NO se registró.$MSG_ATRAS");
    }
    if (file_get_contents($f['tmp_name'], false, null, 0, 5) !== '%PDF-') {
        cr_aviso("El archivo adjunto no es un PDF válido.\nLa contrarreferencia NO se registró.$MSG_ATRAS");
    }
    $adjunto = $f['tmp_name'];
}

// -------------------------------------------------------------------------
// 7. Transacción: verificación del caso + escritura
// -------------------------------------------------------------------------
$en_transaccion = false;

function cr_fallar($link, &$en_transaccion, $mensaje)
{
    if ($en_transaccion) {
        mysqli_rollback($link);
        $en_transaccion = false;
    }
    cr_aviso($mensaje);
}

try {
    mysqli_begin_transaction($link);
    $en_transaccion = true;

    // Fila de admisión de ESTE caso (bloqueada hasta terminar)
    $caso = cr_fila($link,
        "SELECT d.idestablecimiento_salud_r, d.referido, d.admitido,
                r.idestablecimiento_salud, r.idatencion_psafci, r.idnombre
           FROM deriva_referencia_hc d
     INNER JOIN referencia_hc r ON r.idreferencia_hc = d.idreferencia_hc
          WHERE d.idderiva_referencia_hc = ? AND d.idreferencia_hc = ?
            FOR UPDATE",
        'ii', array($idderiva_referencia_hc, $idreferencia_hc));

    if (!$caso) {
        cr_fallar($link, $en_transaccion, "El caso no corresponde a una referencia admitida. La contrarreferencia NO se registró.");
    }

    $eess_usuario = cr_eess_usuario($link, $idusuario_ss);
    if ($eess_usuario <= 0 || (int)$caso['idestablecimiento_salud_r'] !== $eess_usuario) {
        cr_fallar($link, $en_transaccion, "Este caso no está admitido en su establecimiento. La contrarreferencia NO se registró.");
    }

    // Antes de contrarreferir, la fila de admisión debe estar: referido = NO, admitido = SI
    if ($caso['referido'] !== 'NO' || $caso['admitido'] !== 'SI') {
        cr_token_cerrar($token);
        cr_fallar($link, $en_transaccion, "Este caso ya fue contrarreferido o ya no está pendiente en la bandeja de admitidos.\nNo se registró nada nuevo.");
    }

    // Destino = establecimiento que originó la referencia (calculado aquí, no enviado por el formulario)
    $idestablecimiento_destino = (int)$caso['idestablecimiento_salud'];
    $idestablecimiento_origen  = (int)$caso['idestablecimiento_salud_r'];
    $idnombre_paciente         = (int)$caso['idnombre'];
    $idatencion_psafci         = ($caso['idatencion_psafci'] === null) ? null : (int)$caso['idatencion_psafci'];

    if ($idestablecimiento_destino <= 0) {
        cr_fallar($link, $en_transaccion, "La referencia no tiene establecimiento de origen registrado. La contrarreferencia NO se registró.\nComuníquese con el administrador.");
    }

    // 7.1 Cerrar el tramo de admisión (solo si sigue pendiente: evita doble registro)
    $n = cr_ejecutar($link,
        "UPDATE deriva_referencia_hc SET referido = 'SI', admitido = 'SI'
          WHERE idderiva_referencia_hc = ? AND referido = 'NO' AND admitido = 'SI'",
        'i', array($idderiva_referencia_hc));
    if ($n !== 1) {
        cr_token_cerrar($token);
        cr_fallar($link, $en_transaccion, "Este caso ya fue contrarreferido. No se registró nada nuevo.");
    }

    // 7.2 Diagnósticos de egreso
    cr_ejecutar($link, "DELETE FROM diagnostico_egreso WHERE idreferencia_hc = ?", 'i', array($idreferencia_hc));
    foreach ($filas_dx as $dx) {
        cr_ejecutar($link,
            "INSERT INTO diagnostico_egreso (idreferencia_hc, idnombre, diagnostico_egreso, idpatologia, fecha_registro, hora_registro, idusuario)
             VALUES (?, ?, ?, ?, ?, ?, ?)",
            'iisissi', array($idreferencia_hc, $idnombre_paciente, $dx['texto'], $dx['id'], $fecha, $hora, $idusuario_ss));
    }

    // 7.3 Datos de la contrarreferencia
    cr_ejecutar($link,
        "UPDATE referencia_hc SET dias_internacion_ref = ?, evolucion_complicacion = ?, examenes_complementarios_egreso = ?,
                otros_examenes = ?, tratamientos_realizados = ?, recomendaciones_paciente = ?, otros_anexos = ?,
                observaciones_recomendaciones = ?, contacto_eess_cref = ?, por_telesalud = ?, idtiempo_ts = ?,
                atencion_sitio = ?, idtipo_teleinterconsulta = ?, contacto_contraref = ?, nombre_acompanante_cref = ?,
                idestado_referencia = '2', tel_establecimiento_cref = ?
          WHERE idreferencia_hc = ?",
        'ssssssssss' . 'isi' . 'sss' . 'i',
        array($dias_internacion_ref, $evolucion_complicacion, $examenes_complementarios_egreso,
              $otros_examenes, $tratamientos_realizados, $recomendaciones_paciente, $otros_anexos,
              $observaciones_recomendaciones, $contacto_eess_cref, $por_telesalud, $idtiempo_ts,
              $atencion_sitio, $idtipo_teleinterconsulta, $contacto_contraref, $nombre_acompanante_cref,
              $tel_establecimiento_cref, $idreferencia_hc));

    // 7.4 Nuevo tramo hacia el origen: referido = SI, admitido = NO (pendiente de admisión por el origen)
    cr_ejecutar($link,
        "INSERT INTO deriva_referencia_hc (idreferencia_hc, idestablecimiento_salud_o, idestablecimiento_salud_r, idusuario_o, idusuario_r,
                referido, admitido, persona_contactada, idvia_comunicacion, fecha_deriva, hora_deriva, fecha_admision, hora_admision)
         VALUES (?, ?, ?, ?, ?, 'SI', 'NO', ?, '2', ?, ?, ?, ?)",
        'iiiiisssss',
        array($idreferencia_hc, $idestablecimiento_origen, $idestablecimiento_destino, $idusuario_ss, $idusuario_ss,
              $contacto_contraref, $fecha, $hora, $fecha, $hora));

    // 7.5 Signos vitales de alta
    $imc = null;
    if ($talla !== null && $peso !== null && (float)$talla > 0) {
        $imc = number_format((float)$peso * 10000 / ((float)$talla ** 2), 6, '.', '');
    }
    cr_ejecutar($link,
        "INSERT INTO signo_vital_psafci (idatencion_psafci, idnombre, edad, frec_cardiaca, peso, talla, frec_respiratoria,
                presion_arterial, presion_arterial_d, temperatura, saturacion, imc, fecha_registro, hora_registro, idusuario)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
        'ii' . 'ssssssssss' . 'ss' . 'i',
        array($idatencion_psafci, $idnombre_paciente, $edad, $frec_cardiaca, $peso, $talla, $frec_respiratoria,
              $presion_arterial, $presion_arterial_d, $temperatura, $saturacion, $imc, $fecha, $hora, $idusuario_ss));

    mysqli_commit($link);
    $en_transaccion = false;

} catch (Throwable $e) {
    if ($en_transaccion) {
        try { mysqli_rollback($link); } catch (Throwable $e2) { }
    }
    error_log("[contrarreferencia] ref=$idreferencia_hc deriva=$idderiva_referencia_hc usuario=$idusuario_ss: " . $e->getMessage());
    cr_aviso("No se pudo procesar la contrarreferencia y no se guardó ningún cambio.\nPor favor, intente nuevamente o consulte con el administrador.");
}

// -------------------------------------------------------------------------
// 8. Adjunto (después de confirmar el guardado)
// -------------------------------------------------------------------------
$adjunto_ok = true;
if ($adjunto !== null) {
    try {
        $carpeta_destino = dirname(__DIR__) . "/files_ref/";
        if (!is_dir($carpeta_destino)) {
            mkdir($carpeta_destino, 0755, true);
        }
        $nuevo_nombre_archivo = "CONTRAREF_" . $idreferencia_hc . "_" . date("Ymd_His") . "_" . random_int(1000, 9999) . ".pdf";
        if (move_uploaded_file($adjunto, $carpeta_destino . $nuevo_nombre_archivo)) {
            cr_ejecutar($link, "UPDATE referencia_hc SET file_contra_ref = ? WHERE idreferencia_hc = ?", 'si', array($nuevo_nombre_archivo, $idreferencia_hc));
        } else {
            $adjunto_ok = false;
        }
    } catch (Throwable $e) {
        $adjunto_ok = false;
    }
    if (!$adjunto_ok) {
        error_log("[contrarreferencia] no se pudo guardar el adjunto ref=$idreferencia_hc usuario=$idusuario_ss");
    }
}

// -------------------------------------------------------------------------
// 9. Fin
// -------------------------------------------------------------------------
cr_token_cerrar($token);
$_SESSION['idestablecimiento_destino_ss'] = $idestablecimiento_destino; // compatibilidad
$_SESSION['idreferencia_hc_ss']           = $idreferencia_hc;           // compatibilidad

header("Location:mensaje_contrareferencia_hc.php?idref=" . $idreferencia_hc . ($adjunto_ok ? "" : "&adj=0"));
exit();
