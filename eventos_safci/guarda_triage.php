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
$idnombre_paciente_ss = $_SESSION['idnombre_paciente_ss'];
$idatencion_safci_ss  = $_SESSION['idatencion_safci_ss'];

/*********** ENVIO DATOS PARA TRIAGE DEL PACIENTE *************/

$idespecialidad_medica = $_POST['idespecialidad_medica'];
$anamnesis           = $link->real_escape_string(mb_strtoupper($_POST['anamnesis']));
$prediagnostico      = $link->real_escape_string(mb_strtoupper($_POST['prediagnostico']));

/*********** modificar el regsitro de datos personales del paciente (BEGIN) *************/

    $sql0 = " INSERT INTO especialidad_atencion (idevento_safci, idatencion_safci, idespecialidad_medica, idnombre, anamnesis, prediagnostico, etapa, fecha_registro, hora_registro, idusuario) ";
    $sql0.= " VALUES ('$idevento_safci_ss','$idatencion_safci_ss','$idespecialidad_medica','$idnombre_paciente_ss','$anamnesis','$prediagnostico','PARA ESPECIALIDAD','$fecha','$hora','$idusuario_ss') ";
    $result0 = mysqli_query($link,$sql0);   
    $idespecialidad_atencion = mysqli_insert_id($link);

    $_SESSION['idespecialidad_atencion_ss'] = $idespecialidad_atencion;
    
    header("Location:consulta_especialidad_paciente.php");

// ******  header("Location:triage_paciente.php");    ****/

/*********** modificar el registro de datos personales del paciente (END) *************/
?>