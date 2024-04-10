<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idsospecha_diag_ss         = $_SESSION['idsospecha_diag_ss'];
$iddepartamento_ss          = $_SESSION['iddepartamento_ss'];

$idnotificacion_ep_ss       = $_SESSION['idnotificacion_ep_ss'];
$idregistro_enfermedad_ss   = $_SESSION['idregistro_enfermedad_ss'];
$idficha_ep_ss              = $_SESSION['idficha_ep_ss'];

$idred_salud_ss             = $_SESSION['idred_salud_ss'];
$idmunicipio_ss             = $_SESSION['idmunicipio_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];

$idgrupo_etareo_ss          = $_SESSION['idgrupo_etareo_ss'];
$idgenero_ss                = $_SESSION['idgenero_ss'];

$idseguimiento_ep  = $_POST['idseguimiento_ep'];

/* BORRAMOS EL REGISTRO*/

$sql = " DELETE FROM seguimiento_ep WHERE idseguimiento_ep='$idseguimiento_ep'";
$result = mysqli_query($link,$sql);

header("Location:actualiza_estado_enfermedad_ep.php");
?>