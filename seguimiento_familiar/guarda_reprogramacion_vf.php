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
$idvisita_cf_ss  =  $_SESSION['idvisita_cf_ss'];

$fecha_visita  = $_POST['fecha_visita'];

//-----DATOS ENVIADOS DEL NUMERO DE TELEFONO DEL INTEGRANTE FAMILIAR ----- //

    $sql8 = " UPDATE visita_cf SET fecha_visita = '$fecha_visita', fecha_registro='$fecha', hora_registro='$hora',  ";
    $sql8.= " idusuario='$idusuario_ss' WHERE idvisita_cf='$idvisita_cf_ss' ";       
    $result8 = mysqli_query($link,$sql8); 
    
    header("Location:mensaje_reprograma_vf.php");
    
?>
