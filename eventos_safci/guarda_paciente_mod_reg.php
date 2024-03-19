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

/*********** ENVIO DATOS DEL PÀCIENTE *************/
$ci            = $link->real_escape_string($_POST['ci']);
$nombre        = $link->real_escape_string(mb_strtoupper($_POST['nombre']));
$paterno       = $link->real_escape_string(mb_strtoupper($_POST['paterno']));
$materno       = $link->real_escape_string(mb_strtoupper($_POST['materno']));
$idgenero      = $_POST['idgenero'];
$fecha_nac     = $_POST['fecha_nac'];


/*********** modificar el regsitro de datos personales del paciente (BEGIN) *************/

    $sql0 = " UPDATE nombre SET ci ='$ci', nombre = '$nombre', paterno = '$paterno', materno ='$materno', ";
    $sql0.= " idgenero = '$idgenero', fecha_nac = '$fecha_nac' WHERE idnombre = '$idnombre_paciente_ss' ";
    $result0 = mysqli_query($link,$sql0);   
    $idnombre_paciente = mysqli_insert_id($link);

header("Location:mensaje_registro_paciente_mod.php");

/*********** modificar el regsitro de datos personales del paciente (END) *************/
?>