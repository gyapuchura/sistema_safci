<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idevento_safci_ss    = $_SESSION['idevento_safci_ss'];
$idnombre_paciente_ss = $_SESSION['idnombre_paciente_ss'];
$idatencion_safci_ss  = $_SESSION['idatencion_safci_ss'];

$idespecialidad_atencion = $_POST['idespecialidad_atencion'];

/* BORRAMOS EL REGISTRO*/

$sql = " DELETE FROM especialidad_atencion WHERE idespecialidad_atencion='$idespecialidad_atencion'";
$result = mysqli_query($link,$sql);

header("Location:triage_paciente.php");
?>