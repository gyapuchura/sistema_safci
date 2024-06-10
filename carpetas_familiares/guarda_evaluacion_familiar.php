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

$determinante_salud     = $_POST['determinante_salud'];
$salud_integrantes      = $_POST['salud_integrantes'];
$funcionalidad_familiar = $_POST['funcionalidad_familiar'];
$evaluacion_familiar    = $_POST['evaluacion_familiar'];


$fecha_registro = $_POST['fecha_registro'];
    
$sql_a = " INSERT INTO evaluacion_familiar_cf (idcarpeta_familiar, determinante_salud, salud_integrantes, funcionalidad_familiar, evaluacion_familiar, fecha_registro, hora_registro, idusuario) ";
$sql_a.= " VALUES ('$idcarpeta_familiar_ss','$determinante_salud','$salud_integrantes','$funcionalidad_familiar','$evaluacion_familiar','$fecha_registro','$hora','$idusuario_ss') ";
$result_a = mysqli_query($link,$sql_a);  

header("Location:consolidacion_carpeta_familiar.php");
    
        /*********** Guarda el registro de dterminante de la salud (END) *************/
        ?>