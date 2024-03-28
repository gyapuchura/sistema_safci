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

$idevento_safci_ss          = $_SESSION['idevento_safci_ss'];
$idnombre_paciente_ss       = $_SESSION['idnombre_paciente_ss'];
$idatencion_safci_ss        = $_SESSION['idatencion_safci_ss'];
$idespecialidad_atencion_ss = $_SESSION['idespecialidad_atencion_ss'];

/*********** ENVIO DATOS PARA TRIAGE DEL PACIENTE *************/

$idpatologia = $_POST['idpatologia'];
$diagnostico_atencion = $link->real_escape_string(mb_strtoupper($_POST['diagnostico_atencion']));

/*********** modificar el regsitro de datos personales del paciente (BEGIN) *************/

    $sql0 = " INSERT INTO diagnostico_atencion (idevento_safci, idatencion_safci, idespecialidad_atencion, idnombre, idpatologia, diagnostico_atencion, etapa, fecha_registro, hora_registro, idusuario) ";
    $sql0.= " VALUES ('$idevento_safci_ss','$idatencion_safci_ss','$idespecialidad_atencion_ss','$idnombre_paciente_ss','$idpatologia','$diagnostico_atencion','PARA DIAGNOSTICO','$fecha','$hora','$idusuario_ss') ";
    $result0 = mysqli_query($link,$sql0);   
    $idnombre_paciente = mysqli_insert_id($link);

header("Location:consulta_especialidad_paciente.php");

/*********** modificar el registro de datos personales del paciente (END) *************/
?>