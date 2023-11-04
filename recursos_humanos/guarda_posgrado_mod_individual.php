<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php

date_default_timezone_set('America/La_Paz');
$fecha 		  = date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$gestion       = date("Y");

/* ingresamos los datos del posgrado */
$idpersonal            = $_POST['idpersonal'];
$idprofesion           = $_POST['idprofesion'];
$idespecialidad_medica = $_POST['idespecialidad_medica'];
$idformacion_academica = $_POST['idformacion_academica'];
$descripcion_academica = $link->real_escape_string($_POST['descripcion_academica']);
$entidad_academica     = $link->real_escape_string($_POST['entidad_academica']);
$gestion_ac            = $link->real_escape_string($_POST['gestion_ac']);

$idformacion_academica_p = $_POST['idformacion_academica_p'];
$descripcion_academica_p = $link->real_escape_string($_POST['descripcion_academica_p']);
$entidad_academica_p     = $link->real_escape_string($_POST['entidad_academica_p']);
$gestion_p               = $link->real_escape_string($_POST['gestion_p']);

/****** actualizamos los datos personales *******/

$sql1 = " INSERT INTO nombre_academico (idusuario, idnombre, idprofesion, idespecialidad_medica, idformacion_academica, descripcion_academica, entidad_academica, gestion, idformacion_academica_p, descripcion_academica_p, entidad_academica_p, gestion_p) ";
$sql1.= " VALUES ('$idusuario_ss','$idnombre_ss','$idprofesion','$idespecialidad_medica','$idformacion_academica','$descripcion_academica','$entidad_academica','$gestion_ac','$idformacion_academica_p','$descripcion_academica_p','$entidad_academica_p','$gestion_p') ";
$result1 = mysqli_query($link,$sql1);

$idnombre_academico = mysqli_insert_id($link);

$sql3.= " UPDATE personal SET idnombre_academico='$idnombre_academico' WHERE idpersonal='$idpersonal'";
$result3 = mysqli_query($link,$sql3);

    header("Location:modifica_registro_safci_individual.php");

?>

