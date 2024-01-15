<?php include("../cabf.php");?>
<?php include("../nc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$iddepartamento          = $_POST['iddepartamento'];
$idred_salud             = $_POST['idred_salud'];
$idmunicipio             = $_POST['idmunicipio'];
$idestablecimiento_salud = $_POST['idestablecimiento_salud'];
$idnotificacion_ep       = $_POST['idnotificacion_ep'];

$_SESSION['iddepartamento_ss'] = $iddepartamento;
$_SESSION['idred_salud_ss'] = $idred_salud;
$_SESSION['idmunicipio_ss'] = $idmunicipio;
$_SESSION['idestablecimiento_salud_ss'] = $idestablecimiento_salud;
$_SESSION['idnotificacion_ep_ss'] = $idnotificacion_ep;

header("Location:notificacion_ep.php");

?>