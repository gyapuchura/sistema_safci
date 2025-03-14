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

/*********** ENVIO DATOS PARA ELIMINAR INTEGRANTE *************/

$idintegrante_cf = $_POST['idintegrante_cf'];

/* BORRAMOS EL REGISTRO*/

$sql = " DELETE FROM integrante_datos_cf WHERE idintegrante_cf='$idintegrante_cf' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM integrante_ap_sano WHERE idintegrante_cf='$idintegrante_cf' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM integrante_factor_riesgo WHERE idintegrante_cf='$idintegrante_cf' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM integrante_morbilidad WHERE idintegrante_cf='$idintegrante_cf' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM integrante_discapacidad WHERE idintegrante_cf='$idintegrante_cf' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM integrante_subsector_salud WHERE idintegrante_cf='$idintegrante_cf' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM integrante_beneficiario WHERE idintegrante_cf='$idintegrante_cf' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM integrante_tradicional WHERE idintegrante_cf='$idintegrante_cf' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM integrante_defuncion WHERE idintegrante_cf='$idintegrante_cf' ";
$result = mysqli_query($link,$sql);


$sql = " DELETE FROM integrante_cf WHERE idintegrante_cf='$idintegrante_cf' ";
$result = mysqli_query($link,$sql);

header("Location:integrantes_cf.php");

?>