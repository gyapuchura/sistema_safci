<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha 		  = date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$gestion      = date("Y");

/* ingresamos los datos personales */

$idnombre_datos = $_POST['idnombre_datos'];

$idformacion_academica = $_POST['idformacion_academica'];
$idprofesion           = $_POST['idprofesion'];
$idespecialidad_medica = $_POST['idespecialidad_medica'];

$correo         = $link->real_escape_string(htmlentities($_POST['correo']));
$celular        = $link->real_escape_string(htmlentities($_POST['celular']));
$direccion_dom  = $link->real_escape_string(htmlentities($_POST['direccion_dom']));

$sql8 =" UPDATE nombre_datos SET idformacion_academica='$idformacion_academica', idprofesion='$idprofesion', idespecialidad_medica='$idespecialidad_medica', ";
$sql8.=" correo='$correo', celular='$celular', direccion_dom='$direccion_dom' WHERE idnombre_datos='$idnombre_datos' ";
$result8 = mysqli_query($link,$sql8); 

header("Location:modifica_registro_safci.php");

?>