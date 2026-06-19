<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha 	 = date("Y-m-d");
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

/*********** ENVIO DATOS PARA TRIAGE DEL PACIENTE *************/

// =========================================================================
// MÓDULO DEFINITIVO: ALMACENAMIENTO DE ADJUNTOS DE CONTRARREFERENCIA
// Con Ruta Absoluta Blindada para Windows XAMPP
// =========================================================================

// Detectamos automáticamente el nombre del input que esté enviando el formulario
$nombre_input_file = isset($_FILES['archivo_contrareferencia_pdf']) ? 'archivo_contrareferencia_pdf' : (isset($_FILES['archivo_referencia_pdf']) ? 'archivo_referencia_pdf' : null);

if ($nombre_input_file && $_FILES[$nombre_input_file]['error'] == 0) {
    
    // RUTA ABSOLUTA: Evita que Windows rechace la creación del archivo
    $carpeta_destino = dirname(__DIR__) . "/files_ref/"; 
    
    if (!file_exists($carpeta_destino)) {
        mkdir($carpeta_destino, 0777, true);
    }
    
    // Generamos nombre único con el prefijo CONTRAREF
    $nuevo_nombre_archivo = "CONTRAREF_" . $idreferencia_hc_ss . "_" . date("Ymd_His") . "_" . rand(1000, 9999) . ".pdf";
    $ruta_completa = $carpeta_destino . $nuevo_nombre_archivo;
    
    // Guardamos el PDF y actualizamos la base de datos
    if(move_uploaded_file($_FILES[$nombre_input_file]['tmp_name'], $ruta_completa)){
        $sql_upd_file = "UPDATE referencia_hc SET file_contra_ref = '$nuevo_nombre_archivo' WHERE idreferencia_hc = '$idreferencia_hc_ss'";
        mysqli_query($link, $sql_upd_file);
    }
}
// =========================================================================

$dias_internacion_ref = $_POST['dias_internacion_ref'];

$talla                = $link->real_escape_string($_POST['talla']);
$peso                 = $link->real_escape_string($_POST['peso']);
$temperatura          = $link->real_escape_string($_POST['temperatura']);
$frec_cardiaca        = $_POST['frec_cardiaca'];
$frec_respiratoria    = $_POST['frec_respiratoria'];
$presion_arterial     = $_POST['presion_arterial'];
$presion_arterial_d   = $_POST['presion_arterial_d'];
$saturacion           = $_POST['saturacion'];

$evolucion_complicacion             = $link->real_escape_string($_POST['evolucion_complicacion']);
$examenes_complementarios_egreso    = $link->real_escape_string($_POST['examenes_complementarios_egreso']);
$otros_examenes                     = $link->real_escape_string($_POST['otros_examenes']);
$tratamientos_realizados            = $link->real_escape_string($_POST['tratamientos_realizados']);
$recomendaciones_paciente           = $link->real_escape_string($_POST['recomendaciones_paciente']);
$otros_anexos                       = $link->real_escape_string($_POST['otros_anexos']);
$observaciones_recomendaciones      = $link->real_escape_string($_POST['observaciones_recomendaciones']);

$idestablecimiento_destino  = $_POST['idestablecimiento_destino'];
$tel_establecimiento_cref   = $_POST['tel_establecimiento_cref'];
$contacto_eess_cref         = $link->real_escape_string($_POST['contacto_eess_cref']);
$por_telesalud              = $_POST['por_telesalud'];

if ($por_telesalud == 'SI') {
            $idtiempo_ts    = $_POST['idtiempo_ts'];
            $atencion_sitio = $_POST['atencion_sitio'];
            $idtipo_teleinterconsulta = $_POST['idtipo_teleinterconsulta'];

} else {
            $idtiempo_ts = '1';
            $atencion_sitio = '1';
            $idtipo_teleinterconsulta = '1';
}

$contacto_contraref         = $link->real_escape_string($_POST['contacto_contraref']);
$nombre_acompanante_cref    = $link->real_escape_string($_POST['nombre_acompanante_cref']);

$idpatologia                = $_POST['idpatologia'];

    foreach($_POST['diagnostico_egreso'] as $clave => $diagnostico_egreso_i) {

            $sql_dg = " INSERT INTO diagnostico_egreso (idreferencia_hc, idnombre, diagnostico_egreso, idpatologia, fecha_registro, hora_registro, idusuario) ";
            $sql_dg.= " VALUES ('$idreferencia_hc_ss','$idnombre_integrante_ss','$diagnostico_egreso_i','$idpatologia[$clave]','$fecha','$hora','$idusuario_ss') ";
            $result_dg = mysqli_query($link,$sql_dg);   

            }

    $sql0 = " UPDATE referencia_hc SET dias_internacion_ref='$dias_internacion_ref', evolucion_complicacion='$evolucion_complicacion', examenes_complementarios_egreso='$examenes_complementarios_egreso', ";
    $sql0.= " otros_examenes='$otros_examenes', tratamientos_realizados='$tratamientos_realizados', recomendaciones_paciente='$recomendaciones_paciente', otros_anexos='$otros_anexos', observaciones_recomendaciones='$observaciones_recomendaciones', ";
    $sql0.= " contacto_eess_cref='$contacto_eess_cref', por_telesalud='$por_telesalud', idtiempo_ts='$idtiempo_ts', atencion_sitio='$atencion_sitio', idtipo_teleinterconsulta='$idtipo_teleinterconsulta', contacto_contraref='$contacto_contraref', ";
    $sql0.= " nombre_acompanante_cref='$nombre_acompanante_cref', idestado_referencia='2', tel_establecimiento_cref='$tel_establecimiento_cref' WHERE idreferencia_hc='$idreferencia_hc_ss' ";
    $result0 = mysqli_query($link,$sql0);   

        $sql1 = " UPDATE deriva_referencia_hc SET referido='SI', admitido='SI' WHERE idderiva_referencia_hc='$idderiva_referencia_hc_ss' ";
        $result1 = mysqli_query($link,$sql1);   

        $sql_dr = " INSERT INTO deriva_referencia_hc (idreferencia_hc, idestablecimiento_salud_o, idestablecimiento_salud_r, idusuario_o, idusuario_r, ";
        $sql_dr.= " referido, admitido, persona_contactada, idvia_comunicacion, fecha_deriva, hora_deriva, fecha_admision, hora_admision )  ";
        $sql_dr.= " VALUES ('$idreferencia_hc_ss','$idestablecimiento_salud_ss','$idestablecimiento_destino','$idusuario_ss','$idusuario_ss', ";
        $sql_dr.= " 'SI','NO','$contacto_contraref','2','$fecha','$hora','$fecha','$hora') ";
        $result_dr = mysqli_query($link,$sql_dr);   

            $imc_i = $peso*10000/$talla**2;  //** Estatura en centimetros */
            $imc = number_format($imc_i, 6, '.', '');

            $sql_sg = " INSERT INTO signo_vital_psafci (idatencion_psafci,idnombre, edad, frec_cardiaca, peso, talla, frec_respiratoria, presion_arterial, presion_arterial_d, temperatura, saturacion, imc, fecha_registro, hora_registro, idusuario) ";
            $sql_sg.= " VALUES ('$idatencion_psafci_ss','$idnombre_integrante_ss','$edad_ss','$frec_cardiaca','$peso','$talla','$frec_respiratoria','$presion_arterial','$presion_arterial_d','$temperatura','$saturacion','$imc','$fecha','$hora','$idusuario_ss') ";
            $result_sg = mysqli_query($link,$sql_sg);

    $_SESSION['idestablecimiento_destino_ss'] = $idestablecimiento_destino;

/*********** se llenan otras tablas con relacion al CONTROL PERINATAL ***********/
          
    
header("Location:mensaje_contrareferencia_hc.php");


?>