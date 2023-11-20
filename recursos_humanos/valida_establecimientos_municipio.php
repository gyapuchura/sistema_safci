<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$sql_l = " SELECT iddato_laboral, idusuario, idnombre, iddepartamento, idred_salud, idestablecimiento_salud ";
$sql_l.= " FROM dato_laboral WHERE idusuario='$idusuario_ss' AND idnombre='$idnombre_ss' ORDER BY iddato_laboral DESC LIMIT 1 ";
$result_l = mysqli_query($link,$sql_l);
$row_l = mysqli_fetch_array($result_l);

$sql_e = " SELECT idestablecimiento_salud, idmunicipio FROM establecimiento_salud WHERE idestablecimiento_salud='$row_l[5]' ";
$result_e = mysqli_query($link,$sql_e);
$row_e = mysqli_fetch_array($result_e);

$_SESSION['iddepartamento_ss'] = $row_l[3];
$_SESSION['idred_salud_ss'] = $row_l[4];
$_SESSION['idmunicipio_ss'] = $row_e[1];
$_SESSION['idestablecimiento_salud_ss'] = $row_l[5];

header("Location:establecimientos_salud_municipio.php");

?>