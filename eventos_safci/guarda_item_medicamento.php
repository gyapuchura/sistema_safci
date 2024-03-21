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
$iddiagnostico_atencion_ss  = $_SESSION['iddiagnostico_atencion_ss'];
$idpatologia_ss             = $_SESSION['idpatologia_ss'];

/*********** ENVIO DATOS PARA RECETA MEDICA DEL PACIENTE *************/

$idtipo_medicamento = $_POST['idtipo_medicamento'];
$idmedicamento      = $_POST['idmedicamento'];
$cantidad_recetada  = $_POST['cantidad_recetada'];
$indicacion         = $link->real_escape_string(mb_strtoupper($_POST['indicacion']));

/*********** Agregar RECETA medica (BEGIN) *************/

    $sql0 = " INSERT INTO tratamiento (idevento_safci, idatencion_safci, idespecialidad_atencion, idnombre, iddiagnostico_atencion, idpatologia, ";
    $sql0.= " idtipo_medicamento, idmedicamento, indicacion, cantidad_recetada, entregado_farmacia, fecha_registro, hora_registro, ";
    $sql0.= " idusuario_medico, idprocedencia_medicamento, fecha_entrega, hora_entrega, idusuario_farmacia) ";
    $sql0.= " VALUES ('$idevento_safci_ss','$idatencion_safci_ss','$idespecialidad_atencion_ss','$idnombre_paciente_ss','$iddiagnostico_atencion_ss','$idpatologia_ss', ";
    $sql0.= " '$idtipo_medicamento','$idmedicamento','$indicacion','$cantidad_recetada','NO','$fecha','$hora',  ";
    $sql0.= " '$idusuario_ss','1','$fecha','$hora','0') ";
    $result0 = mysqli_query($link,$sql0);   

header("Location:medicacion_paciente.php");

/*********** Agregar RECETA medica (END) *************/
?>