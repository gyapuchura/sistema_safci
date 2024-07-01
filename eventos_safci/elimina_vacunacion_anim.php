<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idevento_vacunacion_ss  =  $_SESSION['idevento_vacunacion_ss'];

$idvacunacion_anim = $_POST['idvacunacion_anim'];

/* BORRAMOS EL REGISTRO*/

$sql = " DELETE FROM vacunacion_anim WHERE idvacunacion_anim='$idvacunacion_anim'";
$result = mysqli_query($link,$sql);

header("Location:registro_vacunaciones.php");
?>