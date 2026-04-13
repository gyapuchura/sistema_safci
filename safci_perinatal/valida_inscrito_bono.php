
<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$idbono_nino_sano         = $_POST['idbono_nino_sano'];
$_SESSION['idbono_nino_sano_ss'] = $idbono_nino_sano;


header("Location:mostrar_inscrito_bono.php");    

?>