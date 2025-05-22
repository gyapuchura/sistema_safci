<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$idusuario_op_ss  =  $_SESSION['idusuario_op_ss'];
$idcarpeta_familiar = $_GET['idcarpeta_familiar'];

$_SESSION['idcarpeta_familiar_ss'] = $idcarpeta_familiar;

header("Location:imprime_seguimiento_familiar_op.php");

?>