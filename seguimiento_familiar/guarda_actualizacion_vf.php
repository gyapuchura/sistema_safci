<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha 	 = date("Y-m-d");
$hora    = date("h:i");
$gestion = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idcarpeta_familiar_ss = $_SESSION['idcarpeta_familiar_ss'];

$idvisita_cf        = $_POST['idvisita_cf'];
$fecha_visita       = $_POST['fecha_visita'];
$idestado_visita_cf = $_POST['idestado_visita_cf'];

//-----DATOS ENVIADOS EN EL FORMULARIO DE ACTUALIZACION DE SEGUIMIENTO ----- //

if ($fecha_visita == $fecha ) {

    $sql8 = " UPDATE visita_cf SET idestado_visita_cf = '$idestado_visita_cf', fecha_registro='$fecha', hora_registro='$hora',  ";
    $sql8.= " idusuario='$idusuario_ss' WHERE idvisita_cf='$idvisita_cf' ";       
    $result8 = mysqli_query($link,$sql8); 
    
    header("Location:actualiza_seguimiento_familiar.php");
    
}  
else {

    header("Location:mensaje_fuera_fecha.php");
    
}
?>
