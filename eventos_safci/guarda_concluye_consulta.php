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

/*********** ENVIO DATOS PARA CONSULTA DEL PACIENTE *************/


    $sql0 = " UPDATE atencion_safci SET etapa='CONCLUIDA', fecha_registro='$fecha', hora_registro='$hora', idusuario='$idusuario_ss'  ";
    $sql0.= " WHERE idatencion_safci='$idatencion_safci_ss' ";
    $result0 = mysqli_query($link,$sql0);   

    header("Location:tratamiento_especialidad_paciente.php");


/*********** ENVIO DATOS PARA CONSULTA DEL PACIENTE  (END) *************/
?>