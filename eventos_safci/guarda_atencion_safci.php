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

$idarea_influencia  = $_POST['idarea_influencia'];
$edad               = $_POST['edad'];
$frec_cardiaca      = $_POST['frec_cardiaca'];
$peso               = $_POST['peso'];
$talla              = $link->real_escape_string($_POST['talla']);
$frec_respiratoria  = $_POST['frec_respiratoria'];
$presion_arterial   = $_POST['presion_arterial'];
$presion_arterial_d = $_POST['presion_arterial_d'];
$temperatura        = $_POST['temperatura'];
$saturacion         = $_POST['saturacion'];
$combe              = $_POST['combe'];
$alergia            = $_POST['alergia'];
$descripcion_alergia = $link->real_escape_string($_POST['descripcion_alergia']);

/*********** Crear registros para fichas epidemiologicas (BEGIN) *************/

$sql_e    = "SELECT correlativo FROM evento_safci WHERE gestion='$gestion' AND idevento_safci='$idevento_safci_ss' ";
$result_e = mysqli_query($link,$sql_e);
$row_e    = mysqli_fetch_array($result_e);

$evento = $row_e[0];

$sqlm    = "SELECT MAX(correlativo) FROM atencion_safci WHERE gestion='$gestion' AND idevento_safci='$idevento_safci_ss' ";
$resultm = mysqli_query($link,$sqlm);
$rowm    = mysqli_fetch_array($resultm);

$correlativo = $rowm[0]+1;

$codigo = "SAFCI-ATENCION-".$correlativo."/".$evento."/".$gestion;

$imc_i = $peso/$talla**2;
 
$imc = number_format($imc_i, 6, '.', '');


    $sql0 = " INSERT INTO atencion_safci (idevento_safci, gestion, correlativo, codigo, idnombre, edad, idarea_influencia, etapa, fecha_registro, hora_registro, idusuario) ";
    $sql0.= " VALUES ('$idevento_safci_ss','$gestion','$correlativo','$codigo','$idnombre_paciente_ss','$edad','$idarea_influencia','REGISTRADO','$fecha','$hora','$idusuario_ss') ";
    $result0 = mysqli_query($link,$sql0);   
    $idatencion_safci = mysqli_insert_id($link);

    $_SESSION['idatencion_safci_ss'] = $idatencion_safci;

    $sql1 = " INSERT INTO signo_vital (idevento_safci, idatencion_safci, idnombre, frec_cardiaca, peso, talla, frec_respiratoria, presion_arterial, presion_arterial_d, temperatura, saturacion, combe, alergia, descripcion_alergia, imc, fecha_registro, hora_registro, idusuario) ";
    $sql1.= " VALUES ('$idevento_safci_ss','$idatencion_safci','$idnombre_paciente_ss','$frec_cardiaca','$peso','$talla','$frec_respiratoria','$presion_arterial','$presion_arterial_d','$temperatura','$saturacion','$combe','$alergia','$descripcion_alergia','$imc','$fecha','$hora','$idusuario_ss') ";
    $result1 = mysqli_query($link,$sql1);
    $idsigno_vital = mysqli_insert_id($link);   

    $_SESSION['idsigno_vital_ss'] = $idsigno_vital;

 header("Location:mostrar_atencion.php");

?>