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

$idcarpeta_familiar_ss = $_SESSION['idcarpeta_familiar_ss'];

/*********** ENVIO DATOS PARA TRIAGE DEL PACIENTE *************/

$idtenencia_animales_cf        = $_POST['idtenencia_animales_cf'];

/* BORRAMOS EL REGISTRO*/

$sql = " DELETE FROM tenencia_animales_cf WHERE idtenencia_animales_cf='$idtenencia_animales_cf'";
$result = mysqli_query($link,$sql);

header("Location:tenencia_animales_cf.php");

?>