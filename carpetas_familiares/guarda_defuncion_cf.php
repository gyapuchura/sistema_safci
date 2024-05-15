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

$defuncion_cf             = $_POST['defuncion_cf'];
$certificado_defuncion_cf = $_POST['certificado_defuncion_cf'];

/*********** Guarda el registro de beneficiario de programa social de salud (BEGIN) *************/

$sql0 = " INSERT INTO integrante_defuncion (idcarpeta_familiar, idintegrante_cf, defuncion_cf, certificado_defuncion_cf, fecha_registro, hora_registro, idusuario) ";
$sql0.= " VALUES ('$idcarpeta_familiar_ss','$idintegrante_cf_ss','$defuncion_cf','$certificado_defuncion_cf','$fecha','$hora','$idusuario_ss') ";
$result0 = mysqli_query($link,$sql0);   

header("Location:salud_integrante_defuncion_cf.php");

/*********** Guarda el registro de beneficiario de programa social de salud (END) *************/
?>