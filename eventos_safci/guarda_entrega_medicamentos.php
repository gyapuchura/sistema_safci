<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha 	 = date("Y-m-d");
$hora    = date("H:i");
$gestion = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idevento_safci_ss          = $_SESSION['idevento_safci_ss'];
$idnombre_paciente_ss       = $_SESSION['idnombre_paciente_ss'];
$idatencion_safci_ss        = $_SESSION['idatencion_safci_ss'];
$idespecialidad_atencion_ss = $_SESSION['idespecialidad_atencion_ss'];

/*********** ENVIO DATOS DEL tratamiento del PÀCIENTE *************/

$idtratamiento      = $_POST['idtratamiento'];
$cantidad_entregada = $_POST['cantidad_entregada'];
$insumos_entregados = $link->real_escape_string(mb_strtoupper($_POST['insumos_entregados']));

/*********** Modificar el registro de tratamiento del paciente (BEGIN) *************/

    $sql0 = " UPDATE tratamiento SET cantidad_entregada ='$cantidad_entregada', insumos_entregados = '$insumos_entregados', fecha_entrega = '$fecha', hora_entrega ='$hora', ";
    $sql0.= " idusuario_farmacia = '$idusuario_ss' WHERE idtratamiento = '$idtratamiento' ";
    $result0 = mysqli_query($link,$sql0);   

header("Location:mensaje_entrega_medicamento_paciente.php");

/*********** Modificar el registro de tratamiento del paciente (END) *************/
?>