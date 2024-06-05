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

$idtenencia_animales_i = '1';
    
    foreach($_POST['valor'] as $valor) {
    
        $sql_a = " INSERT INTO tenencia_animales_cf (idcarpeta_familiar, idtenencia_animales, valor, fecha_registro, hora_registro, idusuario) ";
        $sql_a.= " VALUES ('$idcarpeta_familiar_ss','$idtenencia_animales_i','$valor','$fecha','$hora','$idusuario_ss') ";
        $result_a = mysqli_query($link,$sql_a);  
    
        $idtenencia_animales_i = $idtenencia_animales_i+1;
    
    }
    header("Location:tenencia_animales_cf.php");

        /*********** Guarda el registro de dterminante de la salud (END) *************/
        ?>