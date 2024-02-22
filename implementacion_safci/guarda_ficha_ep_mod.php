<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha 	 = date("Y-m-d");
$hora    = date("h:i");
$gestion = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$iddepartamento_ss          = $_SESSION['iddepartamento_ss'];
$idred_salud_ss             = $_SESSION['idred_salud_ss'];
$idmunicipio_ss             = $_SESSION['idmunicipio_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idnotificacion_ep_ss       = $_SESSION['idnotificacion_ep_ss'];
$idsospecha_diag_ss         = $_SESSION['idsospecha_diag_ss'];
$idregistro_enfermedad_ss   = $_SESSION['idregistro_enfermedad_ss'];
$idgrupo_etareo_ss          = $_SESSION['idgrupo_etareo_ss'];
$idgenero_ss                = $_SESSION['idgenero_ss'];
$idficha_ep_ss              = $_SESSION['idficha_ep_ss'];

//-----DATOS ENVIADOS EN EL FORMULARIO DE ESTABLECIMIENTO DE SALUD ----- //

$cedula      = $link->real_escape_string($_POST['cedula']);
$nombres     = $link->real_escape_string(mb_strtoupper($_POST['nombres']));
$apellidos   = $link->real_escape_string(mb_strtoupper($_POST['apellidos']));
$fecha_nac   = $_POST['fecha_nac']; 
$celular     = $link->real_escape_string($_POST['celular']);
$direccion   = $link->real_escape_string(mb_strtoupper($_POST['direccion']));
$latitud     = $_POST['latitud']; 
$longitud    = $_POST['longitud']; 

        $sql8 =" UPDATE ficha_ep SET cedula='$cedula', nombres='$nombres', apellidos='$apellidos', ";
        $sql8.=" fecha_nac='$fecha_nac', celular='$celular', direccion='$direccion', ";
        $sql8.=" latitud='$latitud', longitud='$longitud', idusuario='$idusuario_ss', fecha_registro='$fecha'";
        $sql8.=" WHERE idficha_ep='$idficha_ep_ss' ";             
        $result8 = mysqli_query($link,$sql8); 
        
        header("Location:mensaje_ficha_reg.php");
    
?>