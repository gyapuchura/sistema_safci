<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$idgestion_participativa     = $_POST['idgestion_participativa'];

$_SESSION['idgestion_participativa_ss']     = $idgestion_participativa;


header("Location:mostrar_declaracion_gp_info.php");

?>