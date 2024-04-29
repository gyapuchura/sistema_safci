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

$iddepartamento_ss          = $_SESSION['iddepartamento_ss'];
$idred_salud_ss             = $_SESSION['idred_salud_ss'];
$idmunicipio_ss             = $_SESSION['idmunicipio_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idnotificacion_ep_ss       = $_SESSION['idnotificacion_ep_ss'];
$idsospecha_diag_ss         = $_SESSION['idsospecha_diag_ss'];

$sql_v = " SELECT idficha_ep, idregistro_enfermedad, idnotificacion_ep FROM ficha_ep WHERE idnotificacion_ep='$idnotificacion_ep_ss' ";
$result_v = mysqli_query($link,$sql_v);
if ($row_v=mysqli_fetch_array($result_v)) {

    header("Location:mensaje_notificacion_ep_con_fichas.php");

} else {

$sql8 =" UPDATE notificacion_ep SET estado='' ";
$sql8.=" WHERE idnotificacion_ep ='$idnotificacion_ep_ss' ";
$result8 = mysqli_query($link,$sql8);

$sql9 =" INSERT INTO desconsolidacion_ep (idnotificacion_ep, idusuario_desc, fecha_registro, hora_registro) ";
$sql9.=" VALUES ('$idnotificacion_ep_ss','$idusuario_ss','$fecha','$hora') ";
$result9 = mysqli_query($link,$sql9);

header("Location:mensaje_notificacion_ep_end_adm.php");

}
?>