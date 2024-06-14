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

$idcarpeta_familiar_ss  = $_SESSION['idcarpeta_familiar_ss'];

/*********** Desconsolidamos la carpeta familiar (BEGIN) *************/

$sql0 = " UPDATE carpeta_familiar SET estado = '' WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
$result0 = mysqli_query($link,$sql0);   

$sql1 = " INSERT INTO desconsolidacion_cf (idcarpeta_familiar, idusuario_desc, fecha_registro, hora_registro ) ";
$sql1.= " VALUES ('$idcarpeta_familiar_ss','$idusuario_ss','$fecha','$hora') ";
$result1 = mysqli_query($link,$sql1);  

header("Location:mensaje_desconsolidacion_cf.php");

/*********** Desconsolidamos la carpeta familiar (END) *************/
?>