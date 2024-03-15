<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$idpersonal = $_POST['idpersonal'];
$codigo     = $_POST['codigo'];

$_SESSION['idpersonal_ss'] = $idpersonal;
$_SESSION['codigo_ss'] = $codigo;

header("Location:mostrar_registro_safci_mun_adm.php");

?>