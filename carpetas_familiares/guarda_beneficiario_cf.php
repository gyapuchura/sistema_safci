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
$idintegrante_cf_ss     = $_SESSION['idintegrante_cf_ss'];
$idnombre_integrante_ss = $_SESSION['idnombre_integrante_ss'];
$idgenero_ss            = $_SESSION['idgenero_ss'];
$edad_ss                = $_SESSION['edad_ss'];

/*********** ENVIO DATOS PARA TRIAGE DEL PACIENTE *************/

$idprograma_social = $_POST['idprograma_social'];
$otros_beneficios  = $link->real_escape_string(mb_strtoupper($_POST['otros_beneficios']));

/*********** Guarda el registro de beneficiario de programa social de salud (BEGIN) *************/

$sql0 = " INSERT INTO integrante_beneficiario (idcarpeta_familiar, idintegrante_cf, idprograma_social, otros_beneficios, fecha_registro, hora_registro, idusuario) ";
$sql0.= " VALUES ('$idcarpeta_familiar_ss','$idintegrante_cf_ss','$idprograma_social','$otros_beneficios','$fecha','$hora','$idusuario_ss') ";
$result0 = mysqli_query($link,$sql0);   

header("Location:salud_integrante_beneficiario_cf.php");

/*********** Guarda el registro de beneficiario de programa social de salud (END) *************/
?>