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

$idsesion_educativa_ss  =  $_SESSION['idsesion_educativa_ss'];

/*********** ENVIO DATOS PARA TRIAGE DEL PACIENTE *************/

$idsesion_educativa  = $_POST['idsesion_educativa'];

/* BORRAMOS EL REGISTRO*/

$sql = " DELETE FROM sesion_educativa  WHERE idsesion_educativa ='$idsesion_educativa '";
$result = mysqli_query($link,$sql);

header("Location:mensaje_borrado_sesion_educativa.php");

?>