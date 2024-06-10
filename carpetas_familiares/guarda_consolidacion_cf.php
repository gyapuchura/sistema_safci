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
    
$sql_a = " UPDATE carpeta_familiar SET estado='CONSOLIDADO' ";
$sql_a.= " WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
$result_a = mysqli_query($link,$sql_a);  

header("Location:mensaje_consolidacion_cf.php");
    
        /*********** Guarda el registro de dterminante de la salud (END) *************/
        ?>