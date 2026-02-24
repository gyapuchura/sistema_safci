<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$idsesion_educativa = $_POST['idsesion_educativa'];

$_SESSION['idsesion_educativa_ss'] = $idsesion_educativa;

header("Location:registro_sesion_educativa.php");

?>