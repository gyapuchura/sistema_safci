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
$recmoendaciones_paciente           = $link->real_escape_string($_POST['recmoendaciones_paciente']);
$otros_anexos                       = $link->real_escape_string($_POST['otros_anexos']);
$observaciones_recomendaciones      = $link->real_escape_string($_POST['observaciones_recomendaciones']);

$idestablecimiento_destino  = $_POST['idestablecimiento_destino'];
$contacto_eess_cref         = $link->real_escape_string($_POST['contacto_eess_cref']);
$por_telesalud              = $_POST['por_telesalud'];
$contacto_contraref         = $link->real_escape_string($_POST['contacto_contraref']);
$nombre_acompanante_cref    = $link->real_escape_string($_POST['nombre_acompanante_cref']);

$idpatologia                = $_POST['idpatologia'];

    foreach($_POST['diagnostico_egreso'] as $clave => $diagnostico_egreso_i) {

            $sql_dg = " INSERT INTO diagnostico_egreso (idreferencia_hc, idnombre, diagnostico_egreso, idpatologia, fecha_registro, hora_registro, idusuario) ";
            $sql_dg.= " VALUES ('$idreferencia_hc_ss','$idnombre_integrante_ss','$diagnostico_egreso_i','$idpatologia[$clave]','$fecha','$hora','$idusuario_ss') ";
            $result_dg = mysqli_query($link,$sql_dg);   

            }

    $sql0 = " UPDATE referencia_hc SET dias_internacion_ref='$dias_internacion_ref', evolucion_complicacion='$evolucion_complicacion', examenes_complementarios_egreso='$examenes_complementarios_egreso', ";
    $sql0.= " otros_examenes='$otros_examenes', tratamientos_realizados='$tratamientos_realizados', recmoendaciones_paciente='$recmoendaciones_paciente', otros_anexos='$otros_anexos', observaciones_recomendaciones='$observaciones_recomendaciones', ";
    $sql0.= " contacto_eess_cref='$contacto_eess_cref', por_telesalud='$por_telesalud', contacto_contraref='$contacto_contraref', nombre_acompanante_cref='$nombre_acompanante_cref', idestado_referencia='2' ";
    $sql0.= "  WHERE idreferencia_hc='$idreferencia_hc_ss' ";
    $result0 = mysqli_query($link,$sql0);   

        $sql1 = " UPDATE deriva_referencia_hc SET referido='SI', admitido='SI' WHERE idderiva_referencia_hc='$idderiva_referencia_hc_ss' ";
        $result1 = mysqli_query($link,$sql1);   

        $sql_dr = " INSERT INTO deriva_referencia_hc (idreferencia_hc, idestablecimiento_salud_o, idestablecimiento_salud_r, idusuario_o, idusuario_r, ";
        $sql_dr.= " referido, admitido, adecuada, justificada, oportuna, persona_contactada, idvia_comunicacion, fecha_deriva, hora_deriva, fecha_admision, hora_admision )  ";
        $sql_dr.= " VALUES ('$idreferencia_hc_ss','$idestablecimiento_salud_ss','$idestablecimiento_destino','$idusuario_ss','$idusuario_ss', ";
        $sql_dr.= " 'SI','NO','','','','$contacto_contraref','2','$fecha','$hora','$fecha','$hora') ";
        $result_dr = mysqli_query($link,$sql_dr);   

            $imc_i = $peso*10000/$talla**2;  //** Estatura en centimetros */
            $imc = number_format($imc_i, 6, '.', '');

            $sql_sg = " INSERT INTO signo_vital_psafci (idatencion_psafci,idnombre, edad, frec_cardiaca, peso, talla, frec_respiratoria, presion_arterial, presion_arterial_d, temperatura, saturacion, imc, fecha_registro, hora_registro, idusuario) ";
            $sql_sg.= " VALUES ('$idatencion_psafci_ss','$idnombre_integrante_ss','$edad','$frec_cardiaca','$peso','$talla','$frec_respiratoria','$presion_arterial','$presion_arterial_d','$temperatura','$saturacion','$imc','$fecha','$hora','$idusuario_ss') ";
            $result_sg = mysqli_query($link,$sql_sg);

/*********** se llenan otras tablas con relacion al CONTROL PERINATAL ***********/
          
    
header("Location:mensaje_contrareferencia_hc.php");


?>