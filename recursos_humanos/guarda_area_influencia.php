<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$fecha 	 = date("Y-m-d");
$hora    = date("h:i");
$gestion = date("Y");

//-----DATOS ENVIADOS EN EL FORMULARIO DE ESTABLECIMIENTO DE SALUD ----- //

$iddepartamento          = $_POST['iddepartamento'];
$idred_salud             = $_POST['idred_salud'];
$idestablecimiento_salud = $_POST['idestablecimiento_salud'];
$idtipo_area_influencia  = $_POST['idtipo_area_influencia'];
$area_influencia         = $link->real_escape_string($_POST['area_influencia']);
$idnacion                = $_POST['idnacion'];
$habitantes              = $link->real_escape_string($_POST['habitantes']);
$familias                = $link->real_escape_string($_POST['familias']);
$distancia               = $link->real_escape_string($_POST['distancia']);
$latitud                 = $_POST['latitud']; 
$longitud                = $_POST['longitud']; 

$sql7 = " SELECT idmunicipio FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud'";
$result7 = mysqli_query($link,$sql7);
$row7 = mysqli_fetch_array($result7);

if ($latitud == '' || $longitud == '') {
    
    header("Location:mensaje_sin_coordenadas_influencia.php");
}  
else {
        $sql8 = " INSERT INTO area_influencia (iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idtipo_area_influencia, area_influencia, idnacion, habitantes, ";
        $sql8.= " familias, distancia, latitud, longitud, fecha_registro, idusuario)";
        $sql8.= " VALUES ('$iddepartamento','$idred_salud','$row7[0]','$idestablecimiento_salud','$idtipo_area_influencia','$area_influencia','$idnacion','$habitantes', ";
        $sql8.= " '$familias','$distancia','$latitud','$longitud','$fecha','$idusuario_ss')";
        $result8 = mysqli_query($link,$sql8);  
        $idarea_influencia = mysqli_insert_id($link);

        $_SESSION['idarea_influencia_ss'] = $idarea_influencia;  
    
        header("Location:mostrar_area_influencia.php");
    }


?>
