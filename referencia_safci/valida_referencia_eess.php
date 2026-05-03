
<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];


$idreferencia_hc         = $_POST['idreferencia_hc'];
$idatencion_psafci       = $_POST['idatencion_psafci'];
$idestablecimiento_salud = $_POST['idestablecimiento_salud'];
$idnombre_integrante     = $_POST['idnombre_integrante'];
$edad                    = $_POST['edad'];

$sql_em =" SELECT idintegrante_cf, idcarpeta_familiar FROM integrante_cf WHERE idnombre='$idnombre_integrante' ";
$result_em=mysqli_query($link,$sql_em);
$row_em=mysqli_fetch_array($result_em);

$idintegrante_cf = $row_em[0];
$idcarpeta_familiar = $row_em[1];

$_SESSION['idreferencia_hc_ss']         = $idreferencia_hc;
$_SESSION['idatencion_psafci_ss']       = $idatencion_psafci;
$_SESSION['idestablecimiento_salud_ss'] = $idestablecimiento_salud;

$_SESSION['idnombre_integrante_ss']     = $idnombre_integrante;
$_SESSION['edad_ss']                    = $edad;
$_SESSION['idintegrante_cf_ss']         = $idintegrante_cf;
$_SESSION['idcarpeta_familiar_ss']      = $idcarpeta_familiar;

header("Location:mostrar_referencia_hc.php");    

?>