<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha 	 = date("Y-m-d");
$hora    = date("h:i");
$gestion = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idcarpeta_familiar_ss  = $_SESSION['idcarpeta_familiar_ss'];
$idseguimiento_cf_ss    = $_SESSION['idseguimiento_cf_ss'];
$idintegrante_cf_ss     = $_SESSION['idintegrante_cf_ss'];
$idnombre_integrante_ss = $_SESSION['idnombre_integrante_ss'];
$idgenero_ss            = $_SESSION['idgenero_ss'];
$edad_ss                = $_SESSION['edad_ss'];

$motivo_suspension      = $link->real_escape_string($_POST['motivo_suspension']);


//-----DATOS ENVIADOS EN EL FORMULARIO DE ACTUALIZACION DE SEGUIMIENTO ----- //

    $sql8 = " UPDATE visita_cf SET idestado_visita_cf = '4', fecha_registro='$fecha', hora_registro='$hora',  ";
    $sql8.= " idusuario='$idusuario_ss' WHERE idseguimiento_cf='$idseguimiento_cf_ss' ";       
    $result8 = mysqli_query($link,$sql8); 

    $sql8 = " INSERT INTO suspension_vf (idseguimiento_cf, motivo_suspension, fecha_registro, hora_registro, idusuario) ";
    $sql8.= " VALUES ('$idseguimiento_cf_ss','$motivo_suspension ','$fecha','$hora','$idusuario_ss') ";       
    $result8 = mysqli_query($link,$sql8); 
    
    header("Location:mensaje_suspension_vf.php");
    
?>
