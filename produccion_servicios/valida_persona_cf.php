
<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$idevento_safci_ss = $_SESSION['idevento_safci_ss'];

$idintegrante_cf         = $_POST['idintegrante_cf'];
$idcarpeta_familiar      = $_POST['idcarpeta_familiar'];
$idestablecimiento_salud = $_POST['idestablecimiento_salud'];
$idnombre_integrante     = $_POST['idnombre_integrante'];
$edad                    = $_POST['edad'];

$_SESSION['idintegrante_cf_ss']         = $idintegrante_cf;
$_SESSION['idcarpeta_familiar_ss']      = $idcarpeta_familiar;
$_SESSION['idestablecimiento_salud_ss'] = $idestablecimiento_salud;
$_SESSION['idnombre_integrante_ss']     = $idnombre_integrante;
$_SESSION['edad_ss']                    = $edad;


header("Location:atencion_persona_cf.php");

?>