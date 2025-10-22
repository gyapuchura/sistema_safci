<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	   = date("Ymd");
$fecha 		   = date("Y-m-d");
$hora          = date("H:i");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idusuario_mod   = $_POST['idusuario_mod'];

$sqlus = " SELECT usuario FROM usuarios WHERE idusuario='$idusuario_mod' ";
$resultus = mysqli_query($link,$sqlus);
$rowus = mysqli_fetch_array($resultus);

$new_pass =  $rowus[0]."@Safci";

$sql0 = " UPDATE usuarios SET password = '$new_pass' WHERE idusuario='$idusuario_mod' ";
$result0 = mysqli_query($link,$sql0);   

$sql1 = " INSERT INTO cambio_password (idusuario, password_old, password_new, fecha_registro, hora_registro ) ";
$sql1.= " VALUES ('$idusuario_ss','$rowus[0]','$rowus[0]','$fecha','$hora') ";
$result1 = mysqli_query($link,$sql1);  

header("Location:mensaje_password_mod_mun.php");
?>
