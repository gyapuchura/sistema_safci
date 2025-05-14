<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");

$idusuario_ss  = $_SESSION['idusuario_ss'];
$idnombre_ss   = $_SESSION['idnombre_ss'];
$perfil_ss     = $_SESSION['perfil_ss'];

$idcarpeta_familiar_ss = $_SESSION['idcarpeta_familiar_ss'];

/*********** ENVIO DATOS DEL PÀCIENTE *************/

$idintegrante_cf      = $_POST['idintegrante_cf'];
$fecha_nac            = $_POST['fecha_nac'];
$idriesgo_personal_vf = $_POST['idriesgo_personal_vf'];
$idfrecuencia_vf      = $_POST['idfrecuencia_vf'];

foreach($idintegrante_cf as $clave => $integrante_cf_id) {

    echo $integrante_cf_id."</br>";
    echo $fecha_nac[$clave]."</br>";
    echo $idriesgo_personal_vf[$clave]."</br>";
    echo $idfrecuencia_vf[$clave]."</br>";
    echo "</br>";

    $fecha_r = explode('-',$fecha_nac[$clave]);
   
    $fecha_inicial = $gestion.'-'.$fecha_r[1].'-'.$fecha_r[2];

    echo $fecha_inicial."</br>";
    echo "</br>";

    $sql0 = " INSERT INTO seguimiento_cf (idcarpeta_familiar, idintegrante_cf, idriesgo_personal_vf, idfrecuencia_vf, fecha_inicial, fecha_registro, hora_registro, idusuario) ";
    $sql0.= " VALUES ('$idcarpeta_familiar_ss','$integrante_cf_id','$idriesgo_personal_vf[$clave]','$idfrecuencia_vf[$clave]','$fecha_inicial','$fecha','$hora','$idusuario_ss') ";
    $result0 = mysqli_query($link,$sql0);   

}

?>