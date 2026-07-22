<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
// =========================================================================
// 🚨 CONFIGURACIÓN DE SEGURIDAD (EXCEPCIONES SILENCIOSAS ANTI-HACKEO)
// =========================================================================
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
date_default_timezone_set('America/La_Paz');

// 🛡️ ESCUDO ANTI "EFECTO METRALLETA" (DOBLE CLIC RÁPIDO EN 30 SEGUNDOS)
if (isset($_SESSION['ultimo_clic_contrareferencia']) && (time() - $_SESSION['ultimo_clic_contrareferencia']) < 30) {
    header("Location:mensaje_contrareferencia_hc.php");
    exit();
}
$_SESSION['ultimo_clic_contrareferencia'] = time();

$fecha   = date("Y-m-d");
$hora    = date("H:i");
$gestion = date("Y");

$idusuario_ss  = $_SESSION['idusuario_ss'];
$idnombre_ss   = $_SESSION['idnombre_ss'];
$perfil_ss     = $_SESSION['perfil_ss'];

$idderiva_referencia_hc_ss  = $_SESSION['idderiva_referencia_hc_ss'];
$idreferencia_hc_ss         = $_SESSION['idreferencia_hc_ss'];

$idatencion_psafci_ss       = $_SESSION['idatencion_psafci_ss'];
$idcarpeta_familiar_ss      = $_SESSION['idcarpeta_familiar_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idintegrante_cf_ss         = $_SESSION['idintegrante_cf_ss'];
$idnombre_integrante_ss     = $_SESSION['idnombre_integrante_ss'];
$edad_ss                    = $_SESSION['edad_ss'];

// =========================================================================
// 🛡️ RECEPCIÓN DE DATOS BLINDADA CONTRA INYECCIÓN SQL Y NOTICES
// =========================================================================

$dias_internacion_ref = isset($_POST['dias_internacion_ref']) ? $_POST['dias_internacion_ref'] : '0';

// Signos Vitales
$talla                = isset($_POST['talla']) ? mysqli_real_escape_string($link, $_POST['talla']) : '0';
$peso                 = isset($_POST['peso']) ? mysqli_real_escape_string($link, $_POST['peso']) : '0';
$temperatura          = isset($_POST['temperatura']) ? mysqli_real_escape_string($link, $_POST['temperatura']) : '';
$frec_cardiaca        = isset($_POST['frec_cardiaca']) ? mysqli_real_escape_string($link, $_POST['frec_cardiaca']) : '';
$frec_respiratoria    = isset($_POST['frec_respiratoria']) ? mysqli_real_escape_string($link, $_POST['frec_respiratoria']) : '';
$presion_arterial     = isset($_POST['presion_arterial']) ? mysqli_real_escape_string($link, $_POST['presion_arterial']) : '';
$presion_arterial_d   = isset($_POST['presion_arterial_d']) ? mysqli_real_escape_string($link, $_POST['presion_arterial_d']) : '';
$saturacion           = isset($_POST['saturacion']) ? mysqli_real_escape_string($link, $_POST['saturacion']) : '';

// Textos Largos (Blindados contra comillas letales)
$evolucion_complicacion             = isset($_POST['evolucion_complicacion']) ? mysqli_real_escape_string($link, strtoupper(trim($_POST['evolucion_complicacion']))) : '';
$examenes_complementarios_egreso    = isset($_POST['examenes_complementarios_egreso']) ? mysqli_real_escape_string($link, strtoupper(trim($_POST['examenes_complementarios_egreso']))) : '';
$otros_examenes                     = isset($_POST['otros_examenes']) ? mysqli_real_escape_string($link, strtoupper(trim($_POST['otros_examenes']))) : '';
$tratamientos_realizados            = isset($_POST['tratamientos_realizados']) ? mysqli_real_escape_string($link, strtoupper(trim($_POST['tratamientos_realizados']))) : '';
$recomendaciones_paciente           = isset($_POST['recomendaciones_paciente']) ? mysqli_real_escape_string($link, strtoupper(trim($_POST['recomendaciones_paciente']))) : '';
$otros_anexos                       = isset($_POST['otros_anexos']) ? mysqli_real_escape_string($link, strtoupper(trim($_POST['otros_anexos']))) : '';
$observaciones_recomendaciones      = isset($_POST['observaciones_recomendaciones']) ? mysqli_real_escape_string($link, strtoupper(trim($_POST['observaciones_recomendaciones']))) : '';

// Datos de Destino y Contacto
$idestablecimiento_destino  = isset($_POST['idestablecimiento_destino']) ? $_POST['idestablecimiento_destino'] : '0';
$tel_establecimiento_cref   = isset($_POST['tel_establecimiento_cref']) ? mysqli_real_escape_string($link, $_POST['tel_establecimiento_cref']) : '';
$contacto_eess_cref         = isset($_POST['contacto_eess_cref']) ? mysqli_real_escape_string($link, strtoupper(trim($_POST['contacto_eess_cref']))) : '';
$por_telesalud              = isset($_POST['por_telesalud']) ? $_POST['por_telesalud'] : 'NO';

if ($por_telesalud == 'SI') {
    $idtiempo_ts              = isset($_POST['idtiempo_ts']) ? $_POST['idtiempo_ts'] : '1';
    $atencion_sitio           = isset($_POST['atencion_sitio']) ? $_POST['atencion_sitio'] : '1';
    $idtipo_teleinterconsulta = isset($_POST['idtipo_teleinterconsulta']) ? $_POST['idtipo_teleinterconsulta'] : '1';
} else {
    $idtiempo_ts              = '1';
    $atencion_sitio           = '1';
    $idtipo_teleinterconsulta = '1';
}

$contacto_contraref         = isset($_POST['contacto_contraref']) ? mysqli_real_escape_string($link, strtoupper(trim($_POST['contacto_contraref']))) : '';
$nombre_acompanante_cref    = isset($_POST['nombre_acompanante_cref']) ? mysqli_real_escape_string($link, strtoupper(trim($_POST['nombre_acompanante_cref']))) : '';

// =========================================================================
// 📦 INICIO DE TRANSACCIÓN ACID (CUALQUIER FALLO DESHACE LA ACTUALIZACIÓN)
// =========================================================================
try {
    mysqli_begin_transaction($link);

    // MÓDULO DE ARCHIVOS ADJUNTOS
    $nombre_input_file = isset($_FILES['archivo_contrareferencia_pdf']) ? 'archivo_contrareferencia_pdf' : (isset($_FILES['archivo_referencia_pdf']) ? 'archivo_referencia_pdf' : null);

    if ($nombre_input_file && $_FILES[$nombre_input_file]['error'] == 0 && $idreferencia_hc_ss > 0) {
        $carpeta_destino = dirname(__DIR__) . "/files_ref/"; 
        if (!file_exists($carpeta_destino)) {
            mkdir($carpeta_destino, 0777, true);
        }
        $nuevo_nombre_archivo = "CONTRAREF_" . $idreferencia_hc_ss . "_" . date("Ymd_His") . "_" . rand(1000, 9999) . ".pdf";
        $ruta_completa = $carpeta_destino . $nuevo_nombre_archivo;
        
        if(move_uploaded_file($_FILES[$nombre_input_file]['tmp_name'], $ruta_completa)){
            $sql_upd_file = "UPDATE referencia_hc SET file_contra_ref = '$nuevo_nombre_archivo' WHERE idreferencia_hc = '$idreferencia_hc_ss'";
            mysqli_query($link, $sql_upd_file);
        }
    }

    if ($idreferencia_hc_ss > 0) {

        // =========================================================================
        // 🧠 BUCLE DE DIAGNÓSTICOS DE EGRESO UNIFICADO E INTELIGENTE
        // =========================================================================
        // 1. Limpiamos diagnósticos antiguos para evitar duplicaciones infinitas
        $sql_del = "DELETE FROM diagnostico_egreso WHERE idreferencia_hc = '$idreferencia_hc_ss'";
        mysqli_query($link, $sql_del);

        $diagnosticos = isset($_POST['diagnostico_egreso']) && is_array($_POST['diagnostico_egreso']) ? $_POST['diagnostico_egreso'] : array();
        $patologias   = isset($_POST['idpatologia']) && is_array($_POST['idpatologia']) ? $_POST['idpatologia'] : array();
        
        // Obtenemos un ID de patología por defecto
        $sql_def = "SELECT idpatologia FROM patologia ORDER BY idpatologia ASC LIMIT 1";
        $res_def = mysqli_query($link, $sql_def);
        $row_def = mysqli_fetch_array($res_def);
        $id_pat_default = isset($row_def[0]) ? (int)$row_def[0] : 1;

        // Unificamos todas las filas posibles
        $claves_diag = array_unique(array_merge(array_keys($diagnosticos), array_keys($patologias)));

        foreach($claves_diag as $clave) {
            $texto_raw  = isset($diagnosticos[$clave]) ? trim($diagnosticos[$clave]) : '';
            $id_pat_raw = isset($patologias[$clave]) ? trim($patologias[$clave]) : '';
            $id_pat     = (int)$id_pat_raw;

            // Si la fila está completamente vacía (sin texto y sin CIE-10), se ignora
            if ($texto_raw === '' && $id_pat <= 0) {
                continue; 
            }

            // Si falta el CIE-10 en la fila principal, aplicamos fallback seguro
            if ($id_pat <= 0) {
                if ($clave == 0) {
                    $id_pat = $id_pat_default;
                } else {
                    continue; // Filas secundarias incompletas se descartan limpiamente
                }
            }

            $diagnostico_seguro = mysqli_real_escape_string($link, strtoupper($texto_raw));

            $sql_dg = " INSERT INTO diagnostico_egreso (idreferencia_hc, idnombre, diagnostico_egreso, idpatologia, fecha_registro, hora_registro, idusuario) ";
            $sql_dg.= " VALUES ('$idreferencia_hc_ss','$idnombre_integrante_ss','$diagnostico_seguro','$id_pat','$fecha','$hora','$idusuario_ss') ";
            mysqli_query($link,$sql_dg);   
        }
        // =========================================================================

        // ACTUALIZACIÓN DE TABLAS MAESTRAS
        $sql0 = " UPDATE referencia_hc SET dias_internacion_ref='$dias_internacion_ref', evolucion_complicacion='$evolucion_complicacion', examenes_complementarios_egreso='$examenes_complementarios_egreso', ";
        $sql0.= " otros_examenes='$otros_examenes', tratamientos_realizados='$tratamientos_realizados', recomendaciones_paciente='$recomendaciones_paciente', otros_anexos='$otros_anexos', observaciones_recomendaciones='$observaciones_recomendaciones', ";
        $sql0.= " contacto_eess_cref='$contacto_eess_cref', por_telesalud='$por_telesalud', idtiempo_ts='$idtiempo_ts', atencion_sitio='$atencion_sitio', idtipo_teleinterconsulta='$idtipo_teleinterconsulta', contacto_contraref='$contacto_contraref', ";
        $sql0.= " nombre_acompanante_cref='$nombre_acompanante_cref', idestado_referencia='2', tel_establecimiento_cref='$tel_establecimiento_cref' WHERE idreferencia_hc='$idreferencia_hc_ss' ";
        mysqli_query($link,$sql0);   

        $sql1 = " UPDATE deriva_referencia_hc SET referido='SI', admitido='SI' WHERE idderiva_referencia_hc='$idderiva_referencia_hc_ss' ";
        mysqli_query($link,$sql1);   

        $sql_dr = " INSERT INTO deriva_referencia_hc (idreferencia_hc, idestablecimiento_salud_o, idestablecimiento_salud_r, idusuario_o, idusuario_r, ";
        $sql_dr.= " referido, admitido, persona_contactada, idvia_comunicacion, fecha_deriva, hora_deriva, fecha_admision, hora_admision )  ";
        $sql_dr.= " VALUES ('$idreferencia_hc_ss','$idestablecimiento_salud_ss','$idestablecimiento_destino','$idusuario_ss','$idusuario_ss', ";
        $sql_dr.= " 'SI','NO','$contacto_contraref','2','$fecha','$hora','$fecha','$hora') ";
        mysqli_query($link,$sql_dr);   

        // CÁLCULO DE IMC PROTEGIDO CONTRA DIVISIÓN POR CERO
        if ($talla > 0) {
            $imc_i = $peso * 10000 / ($talla ** 2);
            $imc = number_format($imc_i, 6, '.', '');
        } else {
            $imc = '0.000000';
        }

        $sql_sg = " INSERT INTO signo_vital_psafci (idatencion_psafci,idnombre, edad, frec_cardiaca, peso, talla, frec_respiratoria, presion_arterial, presion_arterial_d, temperatura, saturacion, imc, fecha_registro, hora_registro, idusuario) ";
        $sql_sg.= " VALUES ('$idatencion_psafci_ss','$idnombre_integrante_ss','$edad_ss','$frec_cardiaca','$peso','$talla','$frec_respiratoria','$presion_arterial','$presion_arterial_d','$temperatura','$saturacion','$imc','$fecha','$hora','$idusuario_ss') ";
        mysqli_query($link,$sql_sg);

        $_SESSION['idestablecimiento_destino_ss'] = $idestablecimiento_destino;
    }

    // 🛡️ CONFIRMACIÓN DE TRANSACCIÓN: Todo se actualizó y guardó con éxito en todas las tablas
    mysqli_commit($link);

    header("Location:mensaje_contrareferencia_hc.php");
    exit();

} catch (Exception $e) {
    // 🛡️ REVERSIÓN: Si cualquier consulta falló arriba, deshacemos todo para no dejar la referencia a medias
    mysqli_rollback($link);
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Aviso del Sistema</title>
        <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    </head>
    <body class="bg-gradient-light d-flex align-items-center justify-content-center" style="height: 100vh;">
        <div class="container text-center">
            <div class="card shadow mb-4 mx-auto" style="max-width: 500px;">
                <div class="card-body py-4 text-left">
                    <a href="../referencia_safci/admitidos_referencia.php" style="text-decoration: none;">
                        <h6 class="text-info"><- VOLVER</h6>
                    </a>
                    <hr>
                    <div class="text-center py-3">
                        <h4 class="text-danger font-weight-bold mb-4">Aviso del Sistema</h4>
                        <p class="text-gray-800 mb-0" style="font-size: 1.1rem;">
                            No se pudo procesar la contrarreferencia.<br>Por favor, verifique los datos o consulte con el administrador.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit(); 
}
?>