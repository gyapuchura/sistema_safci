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
$idmunicipio             = $_POST['idmunicipio'];
$codigo_establecimiento  = $link->real_escape_string($_POST['codigo_establecimiento']);
$establecimiento_salud   = $link->real_escape_string($_POST['establecimiento_salud']);
$idnivel_establecimiento = $_POST['idnivel_establecimiento'];
$idtipo_establecimiento  = $_POST['idtipo_establecimiento'];
$idsubsector_salud       = $_POST['idsubsector_salud'];  
$iddependencia_institucion = $_POST['iddependencia_institucion']; 
$idambito_local = $_POST['idambito_local']; 
$latitud   = $_POST['latitud']; 
$longitud  = $_POST['longitud']; 

if ($latitud == '' || $longitud == '') {
    
    header("Location:mensaje_sin_coordenadas.php");
}  
else {
        $sql8 = " INSERT INTO establecimiento_salud (iddepartamento, idred_salud, idmunicipio, codigo_establecimiento, establecimiento_salud, idtipo_establecimiento, idnivel_establecimiento, ";
        $sql8.= " idsubsector_salud, iddependencia_institucion, idambito_local, latitud, longitud, idusuario, fecha_registro)";
        $sql8.= " VALUES ('$iddepartamento','$idred_salud','$idmunicipio','$codigo_establecimiento','$establecimiento_salud','$idtipo_establecimiento','$idnivel_establecimiento', ";
        $sql8.= " '$idsubsector_salud','$iddependencia_institucion','$idambito_local','$latitud','$longitud','$idusuario_ss','$fecha')";
        $result8 = mysqli_query($link,$sql8);  
        $idestablecimiento_salud = mysqli_insert_id($link);

        $_SESSION['idestablecimiento_salud_ss'] = $idestablecimiento_salud;  
    
        header("Location:mostrar_establecimiento_salud.php");
    }


?>
