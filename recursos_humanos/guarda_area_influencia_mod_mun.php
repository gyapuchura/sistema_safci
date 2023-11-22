<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idarea_influencia_ss = $_SESSION['idarea_influencia_ss'];

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

if ($latitud == '' || $longitud == '') {
    
    header("Location:mensaje_sin_coordenadas_ai_mun.php");
}  
else {
        $sql8 =" UPDATE area_influencia SET iddepartamento='$iddepartamento', idred_salud='$idred_salud', idestablecimiento_salud='$idestablecimiento_salud', ";
        $sql8.=" idtipo_area_influencia='$idtipo_area_influencia', area_influencia='$area_influencia', idnacion='$idnacion', ";
        $sql8.=" habitantes='$habitantes', familias='$familias', distancia='$distancia', ";
        $sql8.=" latitud='$latitud', longitud='$longitud', idusuario='$idusuario_ss', fecha_registro='$fecha' ";
        $sql8.=" WHERE idarea_influencia='$idarea_influencia_ss' ";
             
        $result8 = mysqli_query($link,$sql8); 
        
        header("Location:mensaje_actualiza_area_influencia_mun.php");
    }

?>
