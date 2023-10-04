<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php

date_default_timezone_set('America/La_Paz');
$fecha 		  = date("Y-m-d");

$idusuario_ss  = $_SESSION['idusuario_ss'];
$idnombre_ss   = $_SESSION['idnombre_ss'];
$perfil_ss     = $_SESSION['perfil_ss'];

$idpersonal_ss = $_SESSION['idpersonal_ss'];
$codigo_ss     = $_SESSION['codigo_ss'];
$gestion       = date("Y");

/* ingresamos los datos del posgrado */

$idusuario_mod = $_POST['idusuario_mod'];
$condicion_mod = $_POST['condicion_mod'];
$perfil_mod    = $_POST['perfil_mod'];

/****** actualizamos los datos personales *******/

$sql3.= " UPDATE usuarios SET condicion='$condicion_mod', perfil='$perfil_mod' WHERE idusuario='$idusuario_mod'";
$result3 = mysqli_query($link,$sql3);

    header("Location:mensaje_condicion.php");

?>

