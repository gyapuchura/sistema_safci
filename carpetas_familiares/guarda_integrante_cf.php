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

$idnombre_integrante_ss = $_SESSION['idnombre_integrante_ss'];
$idparentesco_ss        = $_SESSION['idparentesco_ss'];
$idnacion_ss            = $_SESSION['idnacion_ss'];

/*********** ENVIO DATOS DEL PÀCIENTE *************/

$sql_n =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$idnombre_integrante_ss' ";
$result_n=mysqli_query($link,$sql_n);
$row_n=mysqli_fetch_array($result_n);

$fecha_nacimiento = $row_n[5];
    $dia=date("d");
    $mes=date("m");
    $ano=date("Y");    
    $dianaz=date("d",strtotime($fecha_nacimiento));
    $mesnaz=date("m",strtotime($fecha_nacimiento));
    $anonaz=date("Y",strtotime($fecha_nacimiento));         
    if (($mesnaz == $mes) && ($dianaz > $dia)) {
    $ano=($ano-1); }      
    if ($mesnaz > $mes) {
    $ano=($ano-1);}       
    $edad=($ano-$anonaz);  

/*********** Crear registros para fichas epidemiologicas (BEGIN) *************/

    $sql2 = " INSERT INTO integrante_cf (idcarpeta_familiar, idnombre, edad, idparentesco, idnacion, fecha_registro, hora_registro, idusuario) ";
    $sql2.= " VALUES ('$idcarpeta_familiar_ss','$idnombre_integrante_ss','$edad','$idparentesco_ss','$idnacion_ss','$fecha','$hora','$idusuario_ss') ";
    $result2 = mysqli_query($link,$sql2);   
    $idnombre_paciente = mysqli_insert_id($link);

header("Location:integrantes_cf.php");

/*********** Crear registros para fichas epidemiologicas (END) *************/
?>