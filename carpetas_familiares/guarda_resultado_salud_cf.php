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

$fecha_registro = $_POST['fecha_registro'];

$idsocio_economica_i = '1';
    
    foreach($_POST['evaluacion_salud_familiar_cf'] as $evaluacion_salud_familiar_cf) {
    
        $sql_a = " INSERT INTO evaluacion_salud_familiar_cf (idcarpeta_familiar, evaluacion_salud_familiar_cf, fecha_registro, hora_registro, idusuario) ";
        $sql_a.= " VALUES ('$idcarpeta_familiar_ss','$evaluacion_salud_familiar_cf','$fecha_registro','$hora','$idusuario_ss') ";
        $result_a = mysqli_query($link,$sql_a);  
    
        header("Location:evaluacion_resultados_cf.php");
    
    }
        /*********** Guarda el registro de dterminante de la salud (END) *************/
        ?>