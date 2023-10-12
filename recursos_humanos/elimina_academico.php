<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idpersonal_ss = $_SESSION['idpersonal_ss'];
$codigo_ss     = $_SESSION['codigo_ss'];

$idnombre_academico   = $_POST['idnombre_academico'];

/* BORRAMOS EL REGISTRO*/

$sql = " DELETE FROM nombre_academico WHERE idnombre_academico='$idnombre_academico'";
$result = mysqli_query($link,$sql);

header("Location:modifica_registro_safci.php");
?>