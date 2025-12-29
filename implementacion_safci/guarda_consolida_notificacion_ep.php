<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha 	 = date("Y-m-d");
$hora    = date("H:i");
$gestion = date("Y");
$semana  = date('W');

$idusuario_ss  = $_SESSION['idusuario_ss'];
$idnombre_ss   = $_SESSION['idnombre_ss'];
$perfil_ss     = $_SESSION['perfil_ss'];

$iddepartamento_ss          = $_SESSION['iddepartamento_ss'];
$idred_salud_ss             = $_SESSION['idred_salud_ss'];
$idmunicipio_ss             = $_SESSION['idmunicipio_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idnotificacion_ep_ss       = $_SESSION['idnotificacion_ep_ss'];
$idsospecha_diag_ss         = $_SESSION['idsospecha_diag_ss'];

$sql =" SELECT semana_ep FROM notificacion_ep WHERE idnotificacion_ep ='$idnotificacion_ep_ss' ";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);

if ($semana == '01') {
    $semana_ep = '53';
} else {
    $semana_ep = $semana-1;
}


if ($row[0] <= $semana_ep) {
    
    $sql8 =" UPDATE notificacion_ep SET estado='CONSOLIDADO' ";
    $sql8.=" WHERE idnotificacion_ep ='$idnotificacion_ep_ss' ";
    $result8 = mysqli_query($link,$sql8);

    header("Location:mensaje_notificacion_ep_end.php");
} else {

    header("Location:mensaje_notificacion_ep_err.php");

}
?>