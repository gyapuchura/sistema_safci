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

$idcarpeta_familiar_ss = $_SESSION['idcarpeta_familiar_ss'];

/*********** ENVIO DATOS PARA TRIAGE DEL PACIENTE *************/

$idestructura_familiar_cf  = $_POST['idestructura_familiar_cf'];

/* BORRAMOS EL REGISTRO*/

$sql = " DELETE FROM estructura_familiar_cf WHERE idestructura_familiar_cf='$idestructura_familiar_cf'";
$result = mysqli_query($link,$sql);

header("Location:estructura_etapa_cf.php");

?>