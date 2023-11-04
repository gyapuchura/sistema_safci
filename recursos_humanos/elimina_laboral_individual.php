<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$iddato_laboral   = $_POST['iddato_laboral'];

/* BORRAMOS EL REGISTRO*/

$sql = " DELETE FROM dato_laboral WHERE iddato_laboral='$iddato_laboral'";
$result = mysqli_query($link,$sql);

header("Location:datos_laborales_individual.php");
?>