<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$idevento_safci_ss       = $_SESSION['idevento_safci_ss'];

$idatencion_safci        = $_POST['idatencion_safci'];
$idespecialidad_atencion = $_POST['idespecialidad_atencion'];
$idnombre_paciente       = $_POST['idnombre_paciente'];

$_SESSION['idatencion_safci_ss']        = $idatencion_safci;
$_SESSION['idespecialidad_atencion_ss'] = $idespecialidad_atencion;
$_SESSION['idnombre_paciente_ss']       = $idnombre_paciente;

header("Location:entrega_medicamento_paciente.php");

?>