<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");

$idusuario_ss  = $_SESSION['idusuario_ss'];
$idnombre_ss   = $_SESSION['idnombre_ss'];
$perfil_ss     = $_SESSION['perfil_ss'];

$idevento_safci_ss    = $_SESSION['idevento_safci_ss'];
$idnombre_paciente_ss = $_SESSION['idnombre_paciente_ss'];

/*********** ENVIO DATOS DEL PÀCIENTE *************/

$edad               = $_POST['edad'];
$frec_cardiaca      = $_POST['frec_cardiaca'];
$peso               = $_POST['peso'];
$talla              = $link->real_escape_string($_POST['talla']);
$frec_respiratoria  = $_POST['frec_respiratoria'];
$presion_arterial   = $_POST['presion_arterial'];
$temperatura        = $_POST['temperatura'];
$saturacion         = $_POST['saturacion'];
$combe              = $_POST['combe'];

/*********** Crear registros para fichas epidemiologicas (BEGIN) *************/

$sqlm="SELECT MAX(correlativo) FROM atencion_safci WHERE gestion='$gestion' ";
$resultm=mysqli_query($link,$sqlm);
$rowm=mysqli_fetch_array($resultm);

$correlativo = $rowm[0]+1;

$codigo = "SAFCI-ATENCION-".$correlativo."/".$gestion;

$imc_i = $peso/$talla**2;
 
$imc = number_format($imc_i, 6, '.', '');


    $sql0 = " INSERT INTO atencion_safci (idevento_safci, gestion, correlativo, codigo, idnombre, edad, fecha_registro, hora_registro, idusuario) ";
    $sql0.= " VALUES ('$idevento_safci_ss','$gestion','$correlativo','$codigo','$idnombre_paciente_ss','$edad','$fecha','$hora','$idusuario_ss') ";
    $result0 = mysqli_query($link,$sql0);   
    $idatencion_safci = mysqli_insert_id($link);

    $_SESSION['idatencion_safci_ss'] = $idatencion_safci;

    $sql1 = " INSERT INTO signo_vital (idevento_safci, idatencion_safci, idnombre, frec_cardiaca, peso, talla, frec_respiratoria, presion_arterial, temperatura, saturacion, combe, imc, fecha_registro, hora_registro, idusuario) ";
    $sql1.= " VALUES ('$idevento_safci_ss','$idatencion_safci','$idnombre_paciente_ss','$frec_cardiaca','$peso','$talla','$frec_respiratoria','$presion_arterial','$temperatura','$saturacion','$combe','$imc','$fecha','$hora','$idusuario_ss') ";
    $result1 = mysqli_query($link,$sql1);
    $idsigno_vital = mysqli_insert_id($link);   

    $_SESSION['idsigno_vital_ss'] = $idsigno_vital;

 header("Location:mostrar_atencion.php");

?>