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

$idregistro_evento_notificacion = $_POST['idregistro_evento_notificacion'];
$numero_eventos      = $_POST['numero_eventos'];
$personas_atendidas  = $_POST['personas_atendidas'];
$personas_afectadas  = $_POST['personas_afectadas'];
$personas_fallecidas = $_POST['personas_fallecidas'];

if ($idregistro_evento_notificacion == '' ) {

    header("Location:notificacion_ep_eventos.php");

} else {

$sql8 =" UPDATE registro_evento_notificacion SET numero_eventos='$numero_eventos', personas_afectadas='$personas_afectadas', ";
$sql8.=" personas_atendidas='$personas_atendidas', personas_fallecidas='$personas_fallecidas', fecha_registro='$fecha', hora_registro='$hora', ";
$sql8.=" idusuario='$idusuario_ss' WHERE idregistro_evento_notificacion='$idregistro_evento_notificacion' ";
$result8 = mysqli_query($link,$sql8);

header("Location:notificacion_ep_eventos.php");
}

?>