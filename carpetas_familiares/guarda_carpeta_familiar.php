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
 
$iddepartamento          = $_POST['iddepartamento'];
$idred_salud             = $_POST['idred_salud'];
$idmunicipio             = $_POST['idmunicipio'];
$idestablecimiento_salud = $_POST['idestablecimiento_salud'];
$idarea_influencia       = $_POST['idarea_influencia'];

$fecha_apertura  = $_POST['fecha_apertura'];
$familia         = $link->real_escape_string(mb_strtoupper($_POST['familia']));
$avenida_calle   = $link->real_escape_string(mb_strtoupper($_POST[ 'avenida_calle']));
$no_puerta       = $link->real_escape_string($_POST['no_puerta']);
$nombre_edificio = $link->real_escape_string(mb_strtoupper($_POST['nombre_edificio']));
$latitud         = $_POST['latitud'];
$longitud        = $_POST['longitud'];
$altura          = $link->real_escape_string($_POST['altura']);

if ($iddepartamento == '' || $idmunicipio == '' || $idestablecimiento_salud == '' || $idarea_influencia == '' || $familia == '' || $latitud == '' || $longitud == '') {
    
    header("Location:mensaje_coordenadas_cf.php");
}  
else {
        $sql8 = " INSERT INTO carpeta_familiar (gestion, correlativo, codigo, fecha_apertura, familia, estado,";
        $sql8.= " iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idarea_influencia, fecha_registro, hora_registro, idusuario )";
        $sql8.= " VALUES ('$gestion','0','EN ELABORACIÓN','$fecha_apertura','$familia','',";
        $sql8.= " '$iddepartamento','$idred_salud','$idmunicipio','$idestablecimiento_salud','$idarea_influencia','$fecha','$hora','$idusuario_ss')";
        $result8 = mysqli_query($link,$sql8);  
        $idcarpeta_familiar = mysqli_insert_id($link);

        $sql9 = " INSERT INTO ubicacion_cf (idcarpeta_familiar, iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idarea_influencia, ";
        $sql9.= " avenida_calle, no_puerta, nombre_edificio, latitud, longitud, altura, ubicacion_actual, fecha_registro, hora_registro, idusuario )";
        $sql9.= " VALUES ('$idcarpeta_familiar','$iddepartamento','$idred_salud','$idmunicipio','$idestablecimiento_salud','$idarea_influencia', ";
        $sql9.= " '$avenida_calle','$no_puerta','$nombre_edificio','$latitud','$longitud','$altura','SI','$fecha','$hora','$idusuario_ss')";
        $result9 = mysqli_query($link,$sql9);  

        $_SESSION['idcarpeta_familiar_ss'] = $idcarpeta_familiar;  
    
        header("Location:mensaje_carpeta_familiar.php");
    }
?>