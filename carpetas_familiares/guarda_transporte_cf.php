<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha 	 = date("Y-m-d");
$hora    = date("H:i");
$gestion = date("Y");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$idcarpeta_familiar_ss = $_SESSION['idcarpeta_familiar_ss'];

/*********** ENVIO DATOS PARA TRIAGE DEL PACIENTE *************/

$idtransporte = $_POST['idtransporte'];
$tiempo       = $link->real_escape_string($_POST['tiempo']); 
$distancia    = $_POST['distancia'];

/*********** modificar el regsitro de datos personales del paciente (BEGIN) *************/

    $sql0 = " INSERT INTO transporte_cf (idcarpeta_familiar, idtransporte, tiempo, distancia, fecha_registro, hora_registro, idusuario) ";
    $sql0.= " VALUES ('$idcarpeta_familiar_ss','$idtransporte','$tiempo','$distancia','$fecha','$hora','$idusuario_ss') ";
    $result0 = mysqli_query($link,$sql0);   
    $idnombre_paciente = mysqli_insert_id($link);

header("Location:idioma_transporte.php");

/*********** modificar el registro de datos personales del paciente (END) *************/
?>