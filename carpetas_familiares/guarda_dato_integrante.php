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

$idcarpeta_familiar_ss  = $_SESSION['idcarpeta_familiar_ss'];
$idintegrante_cf_ss     = $_SESSION['idintegrante_cf_ss'];
$idnombre_integrante_ss = $_SESSION['idnombre_integrante_ss'];
$idgenero_ss            = $_SESSION['idgenero_ss'];
$edad_ss                = $_SESSION['edad_ss'];

/*********** ENVIO DATOS PARA TRIAGE DEL PACIENTE *************/

$idestado_civil      = $_POST['idestado_civil'];
$idnivel_instruccion = $_POST['idnivel_instruccion'];
$idprofesion         = $_POST['idprofesion'];
$ocupacion           = $link->real_escape_string(mb_strtoupper($_POST['ocupacion']));
$idcontribuye_cf     = $_POST['idcontribuye_cf'];

/*********** modificar el regsitro de datos personales del paciente (BEGIN) *************/

    $sql0 = " INSERT INTO integrante_datos_cf (idcarpeta_familiar, idintegrante_cf, idnombre, idestado_civil, idnivel_instruccion, idprofesion, ocupacion, idcontribuye_cf, vigente, fecha_registro, hora_registro, idusuario) ";
    $sql0.= " VALUES ('$idcarpeta_familiar_ss','$idintegrante_cf_ss','$idnombre_integrante_ss','$idestado_civil','$idnivel_instruccion','$idprofesion','$ocupacion','$idcontribuye_cf','SI','$fecha','$hora','$idusuario_ss') ";
    $result0 = mysqli_query($link,$sql0);   
    $idnombre_paciente = mysqli_insert_id($link);

header("Location:mostrar_integrante_cf.php");

/*********** modificar el registro de datos personales del paciente (END) *************/
?>