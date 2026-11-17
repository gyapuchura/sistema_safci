<?php
include("../cabf.php");
include("../inc.config.php");
include("inc_referencia.php");

// =========================================================================
// GUARDA REFERENCIA (formulario D7)
// - Paciente y atención se toman del token firmado del formulario (fijados al abrirlo),
//   no de las variables de sesión que otra pestaña puede cambiar.
// - Se valida todo antes de escribir; la referencia y sus tablas se guardan en una transacción:
//   o se guarda todo, o no se guarda nada.
// - Mismas tablas, columnas y valores que antes.
// - El bloque perinatal (módulo en desarrollo) se conserva tal como estaba y nunca impide guardar.
// =========================================================================
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
date_default_timezone_set('America/La_Paz');

$fecha   = date("Y-m-d");
$hora    = date("H:i");
$gestion = date("Y");

$idusuario_ss = (int)$_SESSION['idusuario_ss'];
$idestablecimiento_salud_ss = isset($_SESSION['idestablecimiento_salud_ss']) ? $_SESSION['idestablecimiento_salud_ss'] : '';

$MSG_ATRAS = "\nUse el botón VOLVER AL FORMULARIO (o ATRÁS del navegador) para corregirlo.";

// -------------------------------------------------------------------------
// 1. El envío debe llegar completo
// -------------------------------------------------------------------------
if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location:../administrar_sistema/inicio.php");
    exit();
}

if (empty($_POST)) {
    // PHP descarta todo el formulario cuando el envío supera post_max_size
    $bytes = isset($_SERVER['CONTENT_LENGTH']) ? (int)$_SERVER['CONTENT_LENGTH'] : 0;
    error_log("[referencia] POST vacio. CONTENT_LENGTH=$bytes usuario=$idusuario_ss");
    $limite_mb = round(cr_limite_envio() / 1048576, 1);
    ref_aviso("El envío superó el tamaño máximo permitido por el servidor ($limite_mb MB), probablemente por los archivos adjuntos.\n"
            . "La referencia NO se registró.$MSG_ATRAS Quite algunos adjuntos o use fotos más livianas.", 'Aviso del Sistema', true);
}

// -------------------------------------------------------------------------
// 2. Paciente y atención del formulario (token firmado)
// -------------------------------------------------------------------------
$ctx = ref_token_leer(isset($_POST['ref_token']) ? $_POST['ref_token'] : '');
if ($ctx === null) {
    ref_aviso("El formulario venció o no es válido, por eso la referencia NO se registró.\n"
            . "Vuelva a abrir la atención del paciente y elabore nuevamente la referencia.");
}
if ($ctx['idusuario'] !== $idusuario_ss) {
    ref_aviso("Este formulario fue abierto con otro usuario. La referencia NO se registró.\n"
            . "Ingrese al sistema con el usuario que abrió el formulario y vuelva a presionar REGISTRAR.", 'Aviso del Sistema', true);
}

// Un formulario registra una sola referencia (doble clic, botón ATRÁS y reenvío)
$ya_registrada = ref_token_usado($ctx);
if ($ya_registrada > 0) {
    header("Location:mensaje_referencia_hc.php?idref=" . $ya_registrada . "&dup=1");
    exit();
}

$idnombre_integrante_ss = $ctx['idnombre'];     // mismo nombre de variable que usa el bloque perinatal
$idatencion_psafci      = $ctx['idatencion'];

$pac  = ref_paciente($link, $idnombre_integrante_ss);
$aten = cr_fila($link, "SELECT idatencion_psafci, idnombre, idnacion FROM atencion_psafci WHERE idatencion_psafci = ?", 'i', array($idatencion_psafci));
if (!$pac || !$aten || (int)$aten['idnombre'] !== $idnombre_integrante_ss) {
    error_log("[referencia] token con paciente/atencion inconsistente n=$idnombre_integrante_ss a=$idatencion_psafci usuario=$idusuario_ss");
    ref_aviso("No se pudo confirmar el paciente de esta referencia. La referencia NO se registró.\n"
            . "Vuelva a abrir la atención del paciente y elabore nuevamente la referencia.");
}

$edad     = ref_edad($pac['fecha_nac'], $ctx['edad']);
$idgenero = $pac['idgenero'];
$idnacion = $aten['idnacion'];

// Establecimiento de origen: el de trabajo del usuario (igual que antes)
$row_es = cr_fila($link, "SELECT idestablecimiento_salud FROM dato_laboral WHERE idusuario = ? ORDER BY iddato_laboral DESC LIMIT 1", 'i', array($idusuario_ss));
$idestablecimiento_salud_orig = $row_es ? (int)$row_es['idestablecimiento_salud'] : 0;
$row_e = cr_fila($link, "SELECT iddepartamento, idred_salud, idmunicipio FROM establecimiento_salud WHERE idestablecimiento_salud = ?", 'i', array($idestablecimiento_salud_orig));
if ($idestablecimiento_salud_orig <= 0 || !$row_e) {
    ref_aviso("Su usuario no tiene un establecimiento de trabajo registrado. La referencia NO se registró.\nComuníquese con el administrador.");
}
$iddepartamento = $row_e['iddepartamento'];
$idred_salud    = $row_e['idred_salud'];
$idmunicipio    = $row_e['idmunicipio'];

$row_cf = cr_fila($link,
    "SELECT carpeta_familiar.idarea_influencia FROM integrante_cf, carpeta_familiar
      WHERE integrante_cf.idcarpeta_familiar = carpeta_familiar.idcarpeta_familiar AND integrante_cf.idnombre = ? LIMIT 1",
    'i', array($idnombre_integrante_ss));
$idarea_influencia = $row_cf ? $row_cf['idarea_influencia'] : '2';

// -------------------------------------------------------------------------
// 3. Lectura de campos
// -------------------------------------------------------------------------
function ref_txt($clave)
{
    return isset($_POST[$clave]) ? mb_strtoupper(trim((string)$_POST[$clave]), 'UTF-8') : '';
}
function ref_num($clave)
{
    if (!isset($_POST[$clave])) {
        return '';
    }
    $v = str_replace(',', '.', trim((string)$_POST[$clave]));
    return ($v !== '' && is_numeric($v)) ? $v : '';
}
function ref_id($clave, $defecto = 0)
{
    return (isset($_POST[$clave]) && (int)$_POST[$clave] > 0) ? (int)$_POST[$clave] : (int)$defecto;
}

$discapacidad = isset($_POST['discapacidad']) ? (string)$_POST['discapacidad'] : '';
if ($discapacidad !== 'SI' && $discapacidad !== 'NO') {
    ref_aviso("Falta indicar si es PERSONA CON DISCAPACIDAD. La referencia NO se registró.$MSG_ATRAS", 'Aviso del Sistema', true);
}

// Textos cortos recortados al tamaño de su columna (evita error si el servidor de base de datos es estricto)
$nombre_acompanante  = isset($_POST['nombre_acompanante']) ? mb_substr(trim((string)$_POST['nombre_acompanante']), 0, 100, 'UTF-8') : '';
$idparentesco_acomp  = ref_id('idparentesco_acomp');
$idparentesco_acomp  = $idparentesco_acomp > 0 ? $idparentesco_acomp : null;
$celular_acompanante = isset($_POST['celular_acompanante']) ? substr(preg_replace('/[^0-9]/', '', (string)$_POST['celular_acompanante']), 0, 45) : '';
$tel_establecimiento = isset($_POST['tel_establecimiento']) ? substr(preg_replace('/[^0-9]/', '', (string)$_POST['tel_establecimiento']), 0, 45) : '';

// Signos vitales
$talla              = ref_num('talla');
$peso               = ref_num('peso');
$temperatura        = ref_num('temperatura');
$frec_cardiaca      = ref_num('frec_cardiaca');
$frec_respiratoria  = ref_num('frec_respiratoria');
$presion_arterial   = ref_num('presion_arterial');
$presion_arterial_d = ref_num('presion_arterial_d');
$saturacion         = ref_num('saturacion');
$glascow            = ref_num('glascow');

// Alergia: si el campo de descripción estaba bloqueado (NO), se guarda NINGUNA (igual que antes)
$alergia             = (isset($_POST['alergia']) && $_POST['alergia'] === 'SI') ? 'SI' : 'NO';
$descripcion_alergia = isset($_POST['descripcion_alergia']) ? ref_txt('descripcion_alergia') : 'NINGUNA';
if ($alergia === 'SI' && $descripcion_alergia === '') {
    ref_aviso("Marcó ALERGIAS = SI pero falta la descripción de la alergia. La referencia NO se registró.$MSG_ATRAS", 'Aviso del Sistema', true);
}

$datos_perinatales = isset($_POST['datos_perinatales']) ? $_POST['datos_perinatales'] : 'NO';

$estuvo_internado = (isset($_POST['estuvo_internado']) && $_POST['estuvo_internado'] === 'SI') ? 'SI' : 'NO';
$dias_internacion = isset($_POST['dias_internacion']) ? substr(preg_replace('/[^0-9]/', '', (string)$_POST['dias_internacion']), 0, 5) : '0';
if ($estuvo_internado === 'SI' && (int)$dias_internacion < 1) {
    ref_aviso("Marcó ESTUVO INTERNADO = SI pero faltan los días de internación. La referencia NO se registró.$MSG_ATRAS", 'Aviso del Sistema', true);
}

$resumen_anamnesis        = ref_txt('resumen_anamnesis');
$especificacion_hallazgos = ref_txt('especificacion_hallazgos');
$tratamiento_ref          = ref_txt('tratamiento_ref');
$observaciones_ref        = ref_txt('observaciones_ref');

$idconsentimiento          = ref_id('idconsentimiento', 1);
$idmotivo_referencia       = ref_id('idmotivo_referencia', 5);
$idestablecimiento_salud_r = ref_id('idestablecimiento_salud_r', 0);
$idespecialidad_medica     = ref_id('idespecialidad_medica', 46);

if ($idestablecimiento_salud_r <= 0 || !cr_fila($link, "SELECT idestablecimiento_salud FROM establecimiento_salud WHERE idestablecimiento_salud = ?", 'i', array($idestablecimiento_salud_r))) {
    ref_aviso("Falta seleccionar el ESTABLECIMIENTO RECEPTOR de la lista. La referencia NO se registró.$MSG_ATRAS", 'Aviso del Sistema', true);
}

// Exámenes complementarios marcados
$examenes = array();
if (isset($_POST['idexamen_complementario']) && is_array($_POST['idexamen_complementario'])) {
    foreach ($_POST['idexamen_complementario'] as $v) {
        $v = (int)$v;
        if ($v > 0 && !in_array($v, $examenes, true)
            && cr_fila($link, "SELECT idexamen_complementario FROM examen_complementario WHERE idexamen_complementario = ?", 'i', array($v))) {
            $examenes[] = $v;
        }
    }
}

// Discapacidad
$idtipo_discapacidad  = ref_id('idtipo_discapacidad');
$idnivel_discapacidad = ref_id('idnivel_discapacidad');
if ($discapacidad === 'SI' && (
        !cr_fila($link, "SELECT idtipo_discapacidad_cf FROM tipo_discapacidad_cf WHERE idtipo_discapacidad_cf = ?", 'i', array($idtipo_discapacidad)) ||
        !cr_fila($link, "SELECT idnivel_discapacidad_cf FROM nivel_discapacidad_cf WHERE idnivel_discapacidad_cf = ?", 'i', array($idnivel_discapacidad)))) {
    ref_aviso("Marcó PERSONA CON DISCAPACIDAD = SI pero falta el tipo o el nivel de discapacidad. La referencia NO se registró.$MSG_ATRAS", 'Aviso del Sistema', true);
}

// -------------------------------------------------------------------------
// 4. Diagnósticos presuntivos: el 1 es obligatorio; 2 y 3 opcionales, pero si tienen texto deben tener CIE-10.
//    El CIE-10 debe corresponder al sexo y edad del paciente (comun/inc_cie10.php).
// -------------------------------------------------------------------------
$diagnosticos = (isset($_POST['diagnostico_presuntivo']) && is_array($_POST['diagnostico_presuntivo'])) ? $_POST['diagnostico_presuntivo'] : array();
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
        ref_aviso("El diagnóstico " . ($clave + 1) . " tiene texto pero no tiene CIE-10 seleccionado de la lista.\nLa referencia NO se registró.$MSG_ATRAS", 'Aviso del Sistema', true);
    }
    $pat = cr_fila($link, "SELECT idpatologia, patologia, cie FROM patologia WHERE idpatologia = ?", 'i', array($id_pat));
    if (!$pat) {
        ref_aviso("El CIE-10 del diagnóstico " . ($clave + 1) . " no es válido.\nLa referencia NO se registró.$MSG_ATRAS", 'Aviso del Sistema', true);
    }
    // Misma edad con la que se abrió el formulario (la que usó el buscador), para que el resultado sea idéntico
    $motivo = cie10_motivo_restriccion($pat['cie'], $idgenero, $ctx['edad']);
    if ($motivo !== '') {
        ref_aviso("El diagnóstico " . ($clave + 1) . " (" . $pat['patologia'] . " - " . $pat['cie'] . ") no corresponde a este paciente.\n"
                . $motivo . "\nLa referencia NO se registró.$MSG_ATRAS", 'Aviso del Sistema', true);
    }
    $filas_dx[$clave] = array('texto' => $texto, 'id' => $id_pat);
}

if (!isset($filas_dx[0])) {
    ref_aviso("Falta el CIE-10 del diagnóstico principal (diagnóstico 1).\nLa referencia NO se registró.$MSG_ATRAS", 'Aviso del Sistema', true);
}

// -------------------------------------------------------------------------
// 5. Adjunto: se valida ANTES de guardar (se mueve al final, si todo salió bien)
// -------------------------------------------------------------------------
$adjunto = null;
if (isset($_FILES['archivo_referencia_pdf']) && $_FILES['archivo_referencia_pdf']['error'] !== UPLOAD_ERR_NO_FILE) {
    $f = $_FILES['archivo_referencia_pdf'];
    $limite_mb = cr_limite_adjunto_mb();
    if ($f['error'] === UPLOAD_ERR_INI_SIZE || $f['error'] === UPLOAD_ERR_FORM_SIZE) {
        ref_aviso("Los archivos adjuntos superan el tamaño máximo permitido ($limite_mb MB).\nLa referencia NO se registró.$MSG_ATRAS", 'Aviso del Sistema', true);
    }
    if ($f['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($f['tmp_name'])) {
        error_log("[referencia] error de subida " . $f['error'] . " usuario=$idusuario_ss");
        ref_aviso("El archivo adjunto no llegó completo (posible corte de conexión).\nLa referencia NO se registró.$MSG_ATRAS", 'Aviso del Sistema', true);
    }
    if ((int)$f['size'] > cr_limite_adjunto()) {
        ref_aviso("Los archivos adjuntos suman " . round($f['size'] / 1048576, 1) . " MB y el máximo permitido es $limite_mb MB.\nLa referencia NO se registró.$MSG_ATRAS", 'Aviso del Sistema', true);
    }
    if (file_get_contents($f['tmp_name'], false, null, 0, 5) !== '%PDF-') {
        ref_aviso("El archivo adjunto no es un PDF válido.\nLa referencia NO se registró.$MSG_ATRAS", 'Aviso del Sistema', true);
    }
    $adjunto = $f['tmp_name'];
}

// -------------------------------------------------------------------------
// 6. Doble registro: misma atención, paciente, usuario, receptor y especialidad,
//    registrada después de abrir este formulario (ej. reenvío tras volver a ingresar al sistema)
// -------------------------------------------------------------------------
$dup = cr_fila($link,
    "SELECT idreferencia_hc FROM referencia_hc
      WHERE idatencion_psafci = ? AND idnombre = ? AND idusuario = ? AND idestablecimiento_receptor = ? AND idespecialidad_medica = ?
        AND CONCAT(fecha_registro, ' ', hora_registro) >= ?
      ORDER BY idreferencia_hc DESC LIMIT 1",
    'iiiiis', array($idatencion_psafci, $idnombre_integrante_ss, $idusuario_ss, $idestablecimiento_salud_r, $idespecialidad_medica,
                    date('Y-m-d H:i', $ctx['creado'])));
if ($dup) {
    ref_token_marcar_usado($ctx, $dup['idreferencia_hc']);
    header("Location:mensaje_referencia_hc.php?idref=" . (int)$dup['idreferencia_hc'] . "&dup=1");
    exit();
}

// -------------------------------------------------------------------------
// 7. Transacción: referencia, derivación, signos vitales, exámenes, diagnósticos y discapacidad
// -------------------------------------------------------------------------
$idreferencia_hc = 0;
$en_transaccion  = false;

try {
    mysqli_begin_transaction($link);
    $en_transaccion = true;

    // Correlativo de la gestión (bloqueado hasta terminar para que dos registros no tomen el mismo número)
    $rowm = cr_fila($link, "SELECT MAX(correlativo) AS maximo FROM referencia_hc WHERE gestion = ? FOR UPDATE", 's', array($gestion));
    $correlativo = (int)($rowm ? $rowm['maximo'] : 0) + 1;
    $codigo = "MSYD/APS-REF-" . $correlativo . "/" . $gestion;

    // 7.1 Referencia
    cr_ejecutar($link,
        "INSERT INTO referencia_hc (iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idatencion_psafci, correlativo, codigo, idnombre,
                discapacidad, nombre_acompanante, idparentesco_acomp, celular_acompanante, tel_establecimiento, estuvo_internado, dias_internacion,
                resumen_anamnesis, especificacion_hallazgos, tratamiento_ref, observaciones_ref, idconsentimiento, idestablecimiento_receptor,
                idmotivo_referencia, idespecialidad_medica, gestion, idestado_referencia, idtiempo_ts, idtipo_teleinterconsulta,
                fecha_registro, hora_registro, idusuario, file_ref)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?,  ?, ?, ?, ?, ?, ?, ?,  ?, ?, ?, ?, ?, ?,  ?, ?, ?, '1', '1', '1',  ?, ?, ?, '')",
        'iiiiiisi' . 'ssissss' . 'ssssii' . 'iis' . 'ssi',
        array($iddepartamento, $idred_salud, $idmunicipio, $idestablecimiento_salud_orig, $idatencion_psafci, $correlativo, $codigo, $idnombre_integrante_ss,
              $discapacidad, $nombre_acompanante, $idparentesco_acomp, $celular_acompanante, $tel_establecimiento, $estuvo_internado, $dias_internacion,
              $resumen_anamnesis, $especificacion_hallazgos, $tratamiento_ref, $observaciones_ref, $idconsentimiento, $idestablecimiento_salud_r,
              $idmotivo_referencia, $idespecialidad_medica, $gestion,
              $fecha, $hora, $idusuario_ss));
    $idreferencia_hc = (int)mysqli_insert_id($link);
    if ($idreferencia_hc <= 0) {
        throw new Exception("No se obtuvo el ID de la referencia");
    }

    // 7.2 Derivación al establecimiento receptor (pendiente de admisión)
    cr_ejecutar($link,
        "INSERT INTO deriva_referencia_hc (idreferencia_hc, idestablecimiento_salud_o, idestablecimiento_salud_r, idusuario_o, idusuario_r,
                referido, admitido, idvia_comunicacion, fecha_deriva, hora_deriva, fecha_admision, hora_admision)
         VALUES (?, ?, ?, ?, ?, 'SI', 'NO', '5', ?, ?, ?, ?)",
        'iiiiissss',
        array($idreferencia_hc, $idestablecimiento_salud_orig, $idestablecimiento_salud_r, $idusuario_ss, $idusuario_ss, $fecha, $hora, $fecha, $hora));

    // 7.3 Signos vitales al momento de referir
    $imc = '';
    if ($talla !== '' && $peso !== '' && (float)$talla > 0) {
        $imc = number_format((float)$peso * 10000 / ((float)$talla ** 2), 6, '.', '');
    }
    cr_ejecutar($link,
        "INSERT INTO signo_vital_psafci (idatencion_psafci, idnombre, edad, frec_cardiaca, peso, talla, frec_respiratoria, presion_arterial,
                presion_arterial_d, temperatura, saturacion, imc, glascow, alergia, descripcion_alergia, fecha_registro, hora_registro, idusuario)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
        'ii' . 'sssssss' . 'ssssss' . 'ss' . 'i',
        array($idatencion_psafci, $idnombre_integrante_ss, (string)$edad, $frec_cardiaca, $peso, $talla, $frec_respiratoria, $presion_arterial,
              $presion_arterial_d, $temperatura, $saturacion, $imc, $glascow, $alergia, $descripcion_alergia, $fecha, $hora, $idusuario_ss));

    // 7.4 Exámenes complementarios
    foreach ($examenes as $idexamen_complementario_i) {
        cr_ejecutar($link,
            "INSERT INTO examen_referencia (idreferencia_hc, idnombre, idexamen_complementario, fecha_registro, hora_registro, idusuario)
             VALUES (?, ?, ?, ?, ?, ?)",
            'iiissi', array($idreferencia_hc, $idnombre_integrante_ss, $idexamen_complementario_i, $fecha, $hora, $idusuario_ss));
    }

    // 7.5 Diagnósticos presuntivos (solo filas con CIE-10)
    foreach ($filas_dx as $dx) {
        cr_ejecutar($link,
            "INSERT INTO diagnostico_presuntivo (idreferencia_hc, idnombre, diagnostico_presuntivo, idpatologia, fecha_registro, hora_registro, idusuario)
             VALUES (?, ?, ?, ?, ?, ?, ?)",
            'iisissi', array($idreferencia_hc, $idnombre_integrante_ss, $dx['texto'], $dx['id'], $fecha, $hora, $idusuario_ss));
    }

    // 7.6 Discapacidad
    if ($discapacidad === 'SI') {
        cr_ejecutar($link,
            "INSERT INTO discapacidad_ref (idreferencia_hc, idnombre, idtipo_discapacidad, idnivel_discapacidad, fecha_registro, hora_registro, idusuario)
             VALUES (?, ?, ?, ?, ?, ?, ?)",
            'iiiissi', array($idreferencia_hc, $idnombre_integrante_ss, $idtipo_discapacidad, $idnivel_discapacidad, $fecha, $hora, $idusuario_ss));
    }

    mysqli_commit($link);
    $en_transaccion = false;

} catch (Throwable $e) {
    if ($en_transaccion) {
        try { mysqli_rollback($link); } catch (Throwable $e2) { }
    }
    error_log("[referencia] paciente=$idnombre_integrante_ss atencion=$idatencion_psafci usuario=$idusuario_ss: " . $e->getMessage());
    ref_aviso("No se pudo registrar la referencia y no se guardó ningún dato.\nPor favor, intente nuevamente o consulte con el administrador.$MSG_ATRAS", 'Aviso del Sistema', true);
}

ref_token_marcar_usado($ctx, $idreferencia_hc);

// -------------------------------------------------------------------------
// 8. Datos perinatales (módulo de historia perinatal en desarrollo)
//    Se conserva el comportamiento anterior sin cambios. Se ejecuta aparte, sin transacción y sin
//    detener el proceso ante errores, para que nunca impida el registro de la referencia.
//    Mujeres de 10 a 12 años: solo si se respondió SÍ a la pregunta de embarazo.
// -------------------------------------------------------------------------
mysqli_report(MYSQLI_REPORT_OFF);
$nivel_errores = error_reporting(E_ERROR | E_PARSE);   // el bloque lee campos que pueden no venir (avisos sin importancia)
try {

    if ($idgenero == '1' && ($edad > 12 || ($edad >= 10 && $datos_perinatales === 'SI'))) {

    if ($datos_perinatales = 'SI') {

            $gestaciones    = $_POST['gestaciones'];
            $partos         = $_POST['partos'];
            $abortos        = $_POST['abortos'];
            $cesareas       = $_POST['cesareas'];

            $fecha_fum      = $_POST['fecha_fum'];
            $fecha_fpp      = $_POST['fecha_fpp'];
            $controles_prenatales = $_POST['controles_prenatales'];

            $frecuencia_fcf       = $_POST['frecuencia_fcf'];

            $parto        = $_POST['parto'];

            $sql_hcp    = " SELECT idhistoria_perinatal FROM historia_perinatal WHERE idnombre ='$idnombre_integrante_ss'  ";
            $result_hcp = mysqli_query($link,$sql_hcp);
            if ($row_hcp = mysqli_fetch_array($result_hcp)) {

            /****** SI YA HAY HISTORIA PERINATAL SOLO ACTUALIZAMOS TABLAS QUE CORRESPONDAN - BEGIN*******/



            /****** SI YA HAY HISTORIA PERINATAL SOLO ACTUALIZAMOS TABLAS QUE CORRESPONDAN - END  *******/

            } else {

            /********* INSERTAMOS/REGISTRAMOS LA HISTORIA PERINATAL Y LAS DEMAS TABLAS *******/

                $sql_hp    = " SELECT MAX(correlativo) FROM historia_perinatal WHERE gestion='$gestion'  ";
                $result_hp = mysqli_query($link,$sql_hp);
                $row_hp    = mysqli_fetch_array($result_hp);

                $correlativo_p = $row_hp[0]+1;

                $codigo_p = "MSYD-HCP-".$correlativo_p."/".$gestion;

                $sql0 = " INSERT INTO historia_perinatal (iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idarea_influencia, correlativo, codigo, idnombre,  ";
                $sql0.= " idnacion, alfabeta, idnivel_instruccion, anos_mayor_nivel, vive_sola, gestion, fecha_registro, hora_registro, idusuario)  ";
                $sql0.= " VALUES ('$iddepartamento','$idred_salud','$idmunicipio','$idestablecimiento_salud_ss','$idarea_influencia','$correlativo_p','$codigo_p','$idnombre_integrante_ss', ";
                $sql0.= " '$idnacion','SI','2','','','$gestion','$fecha','$hora','$idusuario_ss')";
                $result0 = mysqli_query($link,$sql0);
                $idhistoria_perinatal = mysqli_insert_id($link);

                $sql_1 = " INSERT INTO antecedente_obstetrico (idhistoria_perinatal, idnombre, gestaciones, partos, abortos, cesareas, nacidos_vivos, viven, nacidos_muertos, muertos_a_semana, ";
                $sql_1.= " muertos_d_semana, vaginales, idultimo_previo, antecedente_gemelos, fecha_fea, menos_ano, embarazo_planeado, idmetodo_anticonceptivo, fecha_registro, hora_registro, idusuario) ";
                $sql_1.= " VALUES ('$idhistoria_perinatal','$idnombre_integrante_ss','$gestaciones','$partos','$abortos','$cesareas','0','0','0','0', ";
                $sql_1.= " '0','0','1','','$fecha','','','1','$fecha','$hora','$idusuario_ss') ";
                $result_1 = mysqli_query($link,$sql_1);

                $sql_2 = " INSERT INTO gestacion (idhistoria_perinatal, idnombre, peso_anterior, talla, idesno, fecha_fum, eg_fum, eco_veinte, fecha_fpp, ";
                $sql_2.= " fuma_activo, fuma_pasivo, drogas, alcohol, violencia, idantirubeola, antitetanica, dosis_antitetanica, ex_odontologico, ex_mamas, controles_prenatales, fecha_registro, hora_registro, idusuario) ";
                $sql_2.= " VALUES ('$idhistoria_perinatal','$idnombre_integrante_ss','','','3','$fecha_fum','', '','$fecha_fpp', ";
                $sql_2.= " '','','','','','2','','','','','$controles_prenatales','$fecha','$hora','$idusuario_ss') ";
                $result_2 = mysqli_query($link,$sql_2);
                $idgestacion = mysqli_insert_id($link);

                /***** consultas antenatales ****** */

                $sql_3 = " INSERT INTO consulta_antenatal (idhistoria_perinatal, idgestacion, idnombre, fecha_consulta, edad_gestacional, peso, imc, presion_arterial, altura_uterina, ";
                $sql_3.= " presentacion, frecuencia_fcf, mov_fetales, proteinuria, tabletas_sfe, senales_examenes, fecha_proxima, fecha_registro, hora_registro, idusuario) ";
                $sql_3.= " VALUES ('$idhistoria_perinatal','$idgestacion','$idnombre_integrante_ss','$fecha','','','','','', ";
                $sql_3.= " '','$frecuencia_fcf','','','','','$fecha','$fecha','$hora','$idusuario_ss') ";
                $result_3 = mysqli_query($link,$sql_3);

            }

        if ($parto == 'SI') {

            $maduracion_pulmonar = $_POST['maduracion_pulmonar'];
            $hora_rpm           = $_POST['hora_rpm'];

            $idtipo_parto       = $_POST['idtipo_parto'];
            $fecha_parto        = $_POST['fecha_parto'];
            $hora_parto         = $_POST['hora_parto'];
            $edad_gestacional   = $_POST['edad_gestacional'];
            $liq_amniotico      = $_POST['liq_amniotico'];
            $idpeso_eg          = $_POST['idpeso_eg'];
            $peso_rn            = $_POST['peso_rn'];
            $talla_rn           = $_POST['talla_rn'];
            $pc_rn              = $_POST['pc_rn'];
            $pt_rn              = $_POST['pt_rn'];
            $apgar_uno          = $_POST['apgar_uno'];
            $apgar_cinco        = $_POST['apgar_cinco'];
            $indice_choque      = $_POST['indice_choque'];
            $criterio_sofa      = $_POST['criterio_sofa'];
            $idgenero_rn        = $_POST['idgenero_rn'];

                $sql_4 = " INSERT INTO parto (idhistoria_perinatal, idgestacion, idnombre, fecha_ingreso, hospitalizacion_embarazo, dias_hospitalizacion, ";
                $sql_4.= " maduracion_pulmonar, hora_rpm, idtipo_parto, fecha_parto, hora_parto, fecha_registro, hora_registro, idusuario) ";
                $sql_4.= " VALUES ('$idhistoria_perinatal','$idgestacion','$idnombre_integrante_ss','$fecha','','',";
                $sql_4.= " '$maduracion_pulmonar','$hora_rpm','$idtipo_parto','$fecha_parto','$hora_parto','$fecha','$hora','$idusuario_ss') ";
                $result_4 = mysqli_query($link,$sql_4);

                $sql_5 = " INSERT INTO recien_nacido (idhistoria_perinatal, idgestacion, idgenero, liq_amniotico, peso_rn, talla_rn, pc_rn, pt_rn, edad_gestacional, ";
                $sql_5.= " idpeso_eg, apgar_uno, apgar_cinco, indice_choque, criterio_sofa, fecha_registro, hora_registro, idusuario) ";
                $sql_5.= " VALUES ('$idhistoria_perinatal','$idgestacion','$idgenero_rn','$liq_amniotico','$peso_rn','$talla_rn','$pc_rn','$pt_rn','$edad_gestacional', ";
                $sql_5.= " '$idpeso_eg','$apgar_uno','$apgar_cinco','$indice_choque','$criterio_sofa','$fecha','$hora','$idusuario_ss') ";
                $result_5 = mysqli_query($link,$sql_5);

        } else {  }

        } else {  }

        } else {  }

} catch (Throwable $e) {
    error_log("[referencia] bloque perinatal ref=$idreferencia_hc: " . $e->getMessage());
}
error_reporting($nivel_errores);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// -------------------------------------------------------------------------
// 9. Adjunto (después de confirmar el guardado)
// -------------------------------------------------------------------------
$adjunto_ok = true;
if ($adjunto !== null) {
    try {
        $carpeta_destino = dirname(__DIR__) . "/files_ref/";
        if (!is_dir($carpeta_destino)) {
            mkdir($carpeta_destino, 0755, true);
        }
        $nuevo_nombre_archivo = "REF_" . $idreferencia_hc . "_" . date("Ymd_His") . "_" . random_int(1000, 9999) . ".pdf";
        if (move_uploaded_file($adjunto, $carpeta_destino . $nuevo_nombre_archivo)) {
            cr_ejecutar($link, "UPDATE referencia_hc SET file_ref = ? WHERE idreferencia_hc = ?", 'si', array($nuevo_nombre_archivo, $idreferencia_hc));
        } else {
            $adjunto_ok = false;
        }
    } catch (Throwable $e) {
        $adjunto_ok = false;
    }
    if (!$adjunto_ok) {
        error_log("[referencia] no se pudo guardar el adjunto ref=$idreferencia_hc usuario=$idusuario_ss");
    }
}

// -------------------------------------------------------------------------
// 10. Fin: la sesión queda apuntando a ESTE paciente y ESTA referencia (lo usan las páginas siguientes)
// -------------------------------------------------------------------------
$_SESSION['idreferencia_hc_ss']           = $idreferencia_hc;
$_SESSION['idestablecimiento_salud_r_ss'] = $idestablecimiento_salud_r;
$_SESSION['idnombre_integrante_ss']       = $idnombre_integrante_ss;
$_SESSION['idatencion_psafci_ss']         = $idatencion_psafci;
$_SESSION['edad_ss']                      = $edad;

header("Location:mensaje_referencia_hc.php?idref=" . $idreferencia_hc . ($adjunto_ok ? "" : "&adj=0"));
exit();
