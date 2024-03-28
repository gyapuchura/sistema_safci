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

$idevento_safci_ss    = $_SESSION['idevento_safci_ss'];
$idatencion_safci_ss  = $_SESSION['idatencion_safci_ss'];
$idnombre_paciente_ss = $_SESSION['idnombre_paciente_ss'];

$idevento_safci_ss    = $_SESSION['idevento_safci_ss'];
$idnombre_paciente_ss = $_SESSION['idnombre_paciente_ss'];
$idatencion_safci_ss  = $_SESSION['idatencion_safci_ss'];

/*********** modificar el registro de atencion enviando a triage (BEGIN) *************/

    $sql0 = " UPDATE atencion_safci SET etapa='EN TRIAGE', fecha_registro='$fecha', hora_registro='$hora', idusuario='$idusuario_ss'  ";
    $sql0.= " WHERE idatencion_safci='$idatencion_safci_ss' ";
    $result0 = mysqli_query($link,$sql0);   
    $idnombre_paciente = mysqli_insert_id($link);

header("Location:mensaje_triage_paciente.php");

/*********** mmodificar el registro de atencion enviando a triage (END) *************/
?>