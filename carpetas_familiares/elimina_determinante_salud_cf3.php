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

$idcarpeta_familiar_ss  = $_SESSION['idcarpeta_familiar_ss'];

/*********** ENVIO DATOS PARA ELIMINAR INTEGRANTE *************/

$iddeterminante_salud_cf = $_POST['iddeterminante_salud_cf'];

/* BORRAMOS EL REGISTRO*/

$sql = " DELETE FROM determinante_salud_cf WHERE iddeterminante_salud_cf='$iddeterminante_salud_cf'";
$result = mysqli_query($link,$sql);


header("Location:determinantes_salud_cf3.php");

?>