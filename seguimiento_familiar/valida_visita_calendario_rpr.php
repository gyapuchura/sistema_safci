<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$idcarpeta_familiar = $_GET['idcarpeta_familiar'];
$idvisita_cf = $_GET['idvisita_cf'];

$_SESSION['idcarpeta_familiar_ss'] = $idcarpeta_familiar;
$_SESSION['idvisita_cf_ss'] = $idvisita_cf;

header("Location:reprograma_visita.php");

?>