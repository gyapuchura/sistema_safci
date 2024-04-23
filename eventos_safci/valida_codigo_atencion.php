<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$idevento_safci_ss = $_SESSION['idevento_safci_ss'];

$codigo  = $_POST['codigo'];

$_SESSION['codigo_ss']  = $codigo;

header("Location:administrar_atencion_safci.php");

?>