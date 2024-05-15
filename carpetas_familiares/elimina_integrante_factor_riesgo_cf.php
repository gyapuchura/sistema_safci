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

/*********** ENVIO DATOS PARA ELIMINAR INTEGRANTE *************/

$idintegrante_factor_riesgo        = $_POST['idintegrante_factor_riesgo'];

/* BORRAMOS EL REGISTRO*/

$sql = " DELETE FROM integrante_factor_riesgo WHERE idintegrante_factor_riesgo='$idintegrante_factor_riesgo'";
$result = mysqli_query($link,$sql);


header("Location:salud_integrante_cf.php");

?>