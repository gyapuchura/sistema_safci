<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php

date_default_timezone_set('America/La_Paz');
$fecha 		  = date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idpersonal_ss = $_SESSION['idpersonal_ss'];
$codigo_ss     = $_SESSION['codigo_ss'];
$gestion       = date("Y");

/* ingresamos los datos del posgrado */
 
$idnombre_mod           = $_POST['idnombre_mod'];
$idusuario_mod          = $_POST['idusuario_mod'];
$idprofesion            = $_POST['idprofesion'];
$idespecialidad_medica  = $_POST['idespecialidad_medica'];
$idformacion_academica  = $_POST['idformacion_academica'];
$descripcion_academica  = $link->real_escape_string($_POST['descripcion_academica']);
$entidad_academica      = $link->real_escape_string($_POST['entidad_academica']);
$gestion_ac             = $link->real_escape_string($_POST['gestion_ac']);

$idformacion_academica_p = $_POST['idformacion_academica_p'];
$descripcion_academica_p = $link->real_escape_string($_POST['descripcion_academica_p']);
$entidad_academica_p     = $link->real_escape_string($_POST['entidad_academica_p']);
$gestion_p               = $link->real_escape_string($_POST['gestion_p']);

/****** actualizamos los datos personales *******/

$sql1 = " INSERT INTO nombre_academico (idusuario, idnombre, idprofesion, idespecialidad_medica, idformacion_academica, descripcion_academica, entidad_academica, gestion, idformacion_academica_p, descripcion_academica_p, entidad_academica_p, gestion_p, posgrado) ";
$sql1.= " VALUES ('$idusuario_mod','$idnombre_mod','$idprofesion','$idespecialidad_medica','$idformacion_academica','$descripcion_academica','$entidad_academica','$gestion_ac','$idformacion_academica_p','$descripcion_academica_p','$entidad_academica_p','$gestion_p','POSGRADO') ";
$result1 = mysqli_query($link,$sql1);

$idnombre_academico = mysqli_insert_id($link);

$sql3.= " UPDATE personal SET idnombre_academico='$idnombre_academico' WHERE idpersonal='$idpersonal_ss'";
$result3 = mysqli_query($link,$sql3);

    header("Location:modifica_registro_safci_mun.php");

?>

