<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$idcarpeta_familiar_ss = $_SESSION['idcarpeta_familiar_ss'];

$idseguimiento_cf = $_POST['idseguimiento_cf'];
$idintegrante_cf  = $_POST['idintegrante_cf'];
$idnombre_integrante  = $_POST['idnombre_integrante'];
$idgenero  = $_POST['idgenero'];
$edad    = $_POST['edad'];

$_SESSION['idseguimiento_cf_ss'] = $idseguimiento_cf;
$_SESSION['idintegrante_cf_ss']  = $idintegrante_cf;
$_SESSION['idnombre_integrante_ss']  = $idnombre_integrante;
$_SESSION['idgenero_ss']  = $idgenero;
$_SESSION['edad_ss']   = $edad;

header("Location:opciones_integrantes_vf.php");

?>