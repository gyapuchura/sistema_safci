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

/*********** ENVIO DATOS PARA TRIAGE DEL PACIENTE *************/

$idfuncionalidad_familiar = $_POST['idfuncionalidad_familiar'];

/*********** Guarda el registro de beneficiario de programa social de salud (BEGIN) *************/


foreach($_POST['idfuncionalidad_familiar'] as $idfuncionalidad_familiar) {

    $sql0 = " INSERT INTO funcionalidad_familiar_cf (idcarpeta_familiar, idfuncionalidad_familiar, vigente, fecha_registro, hora_registro, idusuario) ";
    $sql0.= " VALUES ('$idcarpeta_familiar_ss','$idfuncionalidad_familiar','SI','$fecha','$hora','$idusuario_ss') ";
    $result0 = mysqli_query($link,$sql0);   

}

header("Location:funcionalidad_familiar_cf.php");

/*********** Guarda el registro de beneficiario de programa social de salud (END) *************/
?>