<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha 	 = date("Y-m-d");
$hora    = date("H:i");
$gestion = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idsospecha_diag_ss         = $_SESSION['idsospecha_diag_ss'];
$iddepartamento_ss          = $_SESSION['iddepartamento_ss'];
$idmunicipio_ss             = $_SESSION['idmunicipio_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];

//-----DATOS ENVIADOS EN EL FORMULARIO DE SEGUIMIENTO POR ESTABLECIMIENTO DE SALUD ----- //

$idficha_ep            = $_POST['idficha_ep']; 
$idregistro_enfermedad = $_POST['idregistro_enfermedad']; 
$idnotificacion_ep     = $_POST['idnotificacion_ep']; 
$idsemana_ep           = $_POST['idsemana_ep']; 
$idestado_paciente     = $_POST['idestado_paciente']; 

        $sql8 ="INSERT INTO seguimiento_ep (idficha_ep, idregistro_enfermedad, idnotificacion_ep, idsospecha_diag, idsemana_ep, idestado_paciente, idusuario, fecha_registro ) ";
        $sql8.=" VALUES ('$idficha_ep','$idregistro_enfermedad','$idnotificacion_ep','$idsospecha_diag_ss','$idsemana_ep','$idestado_paciente','$idusuario_ss','$fecha') ";           
        $result8 = mysqli_query($link,$sql8); 
        
        header("Location:fichas_ep_establecimiento.php");
    
?>