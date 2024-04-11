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

/*********** ENVIO DATOS SIGNOS VITALES PACIENTE *************/

$idsigno_vital = $_POST['idsigno_vital'];
$edad          = $_POST['edad'];
$frec_cardiaca = $_POST['frec_cardiaca'];
$peso          = $_POST['peso'];
$talla         = $link->real_escape_string($_POST['talla']);
$frec_respiratoria  = $_POST['frec_respiratoria'];
$presion_arterial   = $_POST['presion_arterial'];
$presion_arterial_d = $_POST['presion_arterial_d'];
$temperatura        = $_POST['temperatura'];
$saturacion         = $_POST['saturacion'];
$combe              = $_POST['combe'];
$alergia            = $_POST['alergia'];
$descripcion_alergia = $link->real_escape_string($_POST['descripcion_alergia']);

$imc_i = $peso/$talla**2;
 
$imc = number_format($imc_i, 6, '.', '');

/*********** modificar el regsitro de datos personales del paciente (BEGIN) *************/

    $sql0 = " UPDATE signo_vital SET frec_cardiaca ='$frec_cardiaca', peso = '$peso', talla = '$talla', frec_respiratoria ='$frec_respiratoria', ";
    $sql0.= " presion_arterial = '$presion_arterial', presion_arterial_d = '$presion_arterial_d', temperatura = '$temperatura', saturacion='$saturacion', ";
    $sql0.= " combe='$combe', imc='$imc', alergia='$alergia', descripcion_alergia='$descripcion_alergia', ";
    $sql0.= " fecha_registro='$fecha', hora_registro='$hora', idusuario='$idusuario_ss' WHERE idsigno_vital = '$idsigno_vital' ";
    $result0 = mysqli_query($link,$sql0);   
    $idnombre_paciente = mysqli_insert_id($link);

header("Location:mensaje_atencion_mod.php");

/*********** modificar el regsitro de datos personales del paciente (END) *************/
?>