<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idsesion_educativa_ss  =  $_SESSION['idsesion_educativa_ss'];

$fecha 	 = date("Y-m-d");
$hora    = date("h:i");
$gestion = date("Y");

//-----DATOS ENVIADOS EN EL FORMULARIO DE ESTABLECIMIENTO DE SALUD ----- //

$fecha_sesion    = $_POST['fecha_sesion'];
$duracion        = $_POST['duracion'];
$idcharla_psafci = $_POST['idcharla_psafci'];
$idsustantivo    = $_POST['idsustantivo'];
$asistentes      = $_POST['asistentes'];

if ($duracion == '0' || $asistentes == '0') {
    
    header("Location:registro_sesion_educativa.php");
}  
else {
        $sql8 =" UPDATE sesion_educativa SET fecha_sesion='$fecha_sesion', duracion='$duracion', idcharla_psafci='$idcharla_psafci', ";
        $sql8.=" idsustantivo='$idsustantivo', asistentes='$asistentes', ";
        $sql8.=" idusuario='$idusuario_ss', fecha_registro='$fecha', hora_registro='$hora' ";
        $sql8.=" WHERE idsesion_educativa='$idsesion_educativa_ss' ";            
        $result8 = mysqli_query($link,$sql8); 
        
        header("Location:mensaje_actualiza_sesion_educativa.php");
    }

?>
