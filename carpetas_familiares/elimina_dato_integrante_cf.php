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

$idintegrante_datos_cf  = $_POST['idintegrante_datos_cf'];

/* BORRAMOS EL REGISTRO*/

$sql = " DELETE FROM integrante_datos_cf WHERE idintegrante_datos_cf='$idintegrante_datos_cf'";
$result = mysqli_query($link,$sql);

header("Location:mostrar_integrante_cf.php");

?>