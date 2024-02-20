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

$idregistro_enfermedad = $_POST['idregistro_enfermedad'];
$cifra                 = $_POST['cifra'];
$idgrupo_etareo        = $_POST['idgrupo_etareo'];
$idgenero              = $_POST['idgenero'];

if ($idregistro_enfermedad == '' ) {

    header("Location:notificacion_ep_etareos.php");

} else {

$sql8 =" UPDATE registro_enfermedad SET cifra='$cifra', fecha_registro='$fecha', hora_registro='$hora',";
$sql8.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad' ";
$result8 = mysqli_query($link,$sql8);

header("Location:notificacion_ep_etareos.php");
}

?>