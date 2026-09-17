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



    
    foreach($_POST['idpregunta_encuesta'] as $idpregunta_encuesta_i) {
    
        echo $idpregunta_encuesta_i."</br>";
    
    }

        foreach($_POST['respuesta'] as $respuesta_i) {
    
        echo $respuesta_i."</br>";
    
    }



    foreach($_POST['iditem_senal_cancer'] as $iditem_senal_cancer_i) {
    
        echo $iditem_senal_cancer_i."</br>";
    
    }


        /*********** Guarda el registro de encuesta de deteccion del cancer (END) *************/
        ?>