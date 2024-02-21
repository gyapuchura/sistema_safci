<?php include("../cabf.php");?>
<?php include("../nc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$idsospecha_diag         = $_POST['idsospecha_diag'];
$iddepartamento          = $_POST['iddepartamento'];
$idmunicipio             = $_POST['idmunicipio'];
$idestablecimiento_salud = $_POST['idestablecimiento_salud'];

$_SESSION['idsospecha_diag_ss']         = $idsospecha_diag;
$_SESSION['iddepartamento_ss']          = $iddepartamento;
$_SESSION['idmunicipio_ss']             = $idmunicipio;
$_SESSION['idestablecimiento_salud_ss'] = $idestablecimiento_salud;

header("Location:fichas_ep_establecimiento.php");

?>