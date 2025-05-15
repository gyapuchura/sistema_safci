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

$idcarpeta_familiar_ss  = $_SESSION['idcarpeta_familiar_ss'];
$idseguimiento_cf_ss    = $_SESSION['idseguimiento_cf_ss'];
$idintegrante_cf_ss     = $_SESSION['idintegrante_cf_ss'];
$idnombre_integrante_ss = $_SESSION['idnombre_integrante_ss'];
$idgenero_ss            = $_SESSION['idgenero_ss'];
$edad_ss                = $_SESSION['edad_ss'];

$celular  = $_POST['celular'];

//-----DATOS ENVIADOS DEL NUMERO DE TELEFONO DEL INTEGRANTE FAMILIAR ----- //

    $sql8 = " UPDATE integrante_cf SET celular = '$celular', fecha_registro='$fecha', hora_registro='$hora',  ";
    $sql8.= " idusuario='$idusuario_ss' WHERE idintegrante_cf='$idintegrante_cf_ss' ";       
    $result8 = mysqli_query($link,$sql8); 
    
    header("Location:mensaje_celular_vf.php");
    
?>
