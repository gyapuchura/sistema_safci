<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha 		  = date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$gestion      = date("Y");

/* ingresamos los datos personales */

$idnombre_datos        = $_POST['idnombre_datos'];
$idnombre_academico    = $_POST['idnombre_academico'];

$idformacion_academica = $_POST['idformacion_academica'];
$idprofesion           = $_POST['idprofesion'];
$idespecialidad_medica = $_POST['idespecialidad_medica'];

$correo             = $link->real_escape_string(htmlentities($_POST['correo']));
$celular            = $link->real_escape_string(htmlentities($_POST['celular']));
$direccion_dom      = $link->real_escape_string(htmlentities($_POST['direccion_dom']));
$celular_emergencia = $link->real_escape_string(htmlentities($_POST['celular_emergencia']));

$entidad_academica  = $link->real_escape_string(htmlentities($_POST['entidad_academica']));
$gestion_ac         = $link->real_escape_string(htmlentities($_POST['gestion_ac']));

$sql8 =" UPDATE nombre_datos SET idformacion_academica='$idformacion_academica', idprofesion='$idprofesion', idespecialidad_medica='$idespecialidad_medica', ";
$sql8.=" correo='$correo', celular='$celular', celular_emergencia='$celular_emergencia', direccion_dom='$direccion_dom' WHERE idnombre_datos='$idnombre_datos' ";
$result8 = mysqli_query($link,$sql8); 

$sql9 =" UPDATE nombre_academico SET entidad_academica ='$entidad_academica', gestion ='$gestion_ac' WHERE idnombre_academico='$idnombre_academico' ";
$result9 = mysqli_query($link,$sql9); 

header("Location:mensaje_complementarios_mod_individual.php");

?>