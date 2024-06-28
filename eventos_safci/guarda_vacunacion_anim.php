<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$fecha 	 = date("Y-m-d");
$hora    = date("H:i");
$gestion = date("Y");

//-----DATOS ENVIADOS EN EL FORMULARIO DE ESTABLECIMIENTO DE SALUD ----- //

$idevento_vacunacion_ss  =  $_SESSION['idevento_vacunacion_ss'];

$can_macho   = $_POST['can_macho'];
$can_hembra  = $_POST['can_hembra'];
$gato        = $_POST['gato'];
$otro        = $_POST['otro'];

if ($can_macho == '' || $can_hembra == '' || $gato == '' || $otro == '' ) {
    
    header("Location:registro_vacunaciones.php");
}  
else {

    $sqlm = " SELECT dato_laboral.iddato_laboral, dato_laboral.iddepartamento, establecimiento_salud.idmunicipio, dato_laboral.idestablecimiento_salud FROM dato_laboral, establecimiento_salud ";
    $sqlm.= " WHERE dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
    $sqlm.= " AND dato_laboral.idusuario='$idusuario_ss' ORDER BY dato_laboral.iddato_laboral DESC LIMIT 1 ";
    $resultm = mysqli_query($link,$sqlm);
    $rowm = mysqli_fetch_array($resultm);

        $iddepartamento = $rowm[1];
        $idmunicipio    = $rowm[2];
        $idestablecimiento_salud = $rowm[3];

        $sql8 = " INSERT INTO vacunacion_anim (idevento_vacunacion, iddepartamento, idmunicipio, idestablecimiento_salud, can_macho, ";
        $sql8.= " can_hembra, gato, otro, fecha_registro, hora_registro, idusuario)";
        $sql8.= " VALUES ('$idevento_vacunacion_ss','$iddepartamento','$idmunicipio','$idestablecimiento_salud','$can_macho', ";
        $sql8.= " '$can_hembra','$gato','$otro','$fecha','$hora','$idusuario_ss')";
        $result8 = mysqli_query($link,$sql8);  
    
        header("Location:mensaje_registro_vacunaciones.php");

    }


?>
