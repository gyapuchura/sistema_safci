<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];

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
    
    header("Location:editar_establecimiento.php");
}  
else {
        $sql8 =" UPDATE establecimiento_salud SET iddepartamento='$iddepartamento', idred_salud='$idred_salud', idmunicipio='$idmunicipio', ";
        $sql8.=" codigo_establecimiento='$codigo_establecimiento', establecimiento_salud='$establecimiento_salud', idtipo_establecimiento='$idtipo_establecimiento', ";
        $sql8.=" idnivel_establecimiento='$idnivel_establecimiento', idsubsector_salud='$idsubsector_salud', iddependencia_institucion='$iddependencia_institucion', ";
        $sql8.=" idambito_local='$idambito_local', latitud='$latitud', longitud='$longitud', idusuario='$idusuario_ss', fecha_registro='$fecha' ";
        $sql8.=" WHERE idestablecimiento_salud='$idestablecimiento_salud_ss' ";
             
        $result8 = mysqli_query($link,$sql8); 
        
        header("Location:mensaje_actualiza_establecimiento_int.php");
    }

?>
