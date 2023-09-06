<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php

date_default_timezone_set('America/La_Paz');
$fecha 		  = date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idpersonal_ss = $_SESSION['idpersonal_ss'];
$codigo_ss     = $_SESSION['codigo_ss'];
$gestion       = date("Y");

/* ingresamos los datos personales */

$idnombre_mod    = $_POST['idnombre_mod'];

$nombre         = $link->real_escape_string(htmlentities($_POST['nombre']));
$paterno        = $link->real_escape_string(htmlentities($_POST['paterno']));
$materno        = $link->real_escape_string(htmlentities($_POST['materno']));

$nacimiento  = $_POST['fecha_nac'];
$fecha_n     = explode('/',$nacimiento);
$fecha_nac   = $fecha_n[2].'-'.$fecha_n[1].'-'.$fecha_n[0];

$ci             = $link->real_escape_string(htmlentities($_POST['ci']));
$complemento    = $link->real_escape_string(htmlentities($_POST['complemento']));
$exp            = $_POST['exp'];
$idnacionalidad = $_POST['idnacionalidad'];
$idgenero       = $_POST['idgenero'];

/****** actualizamos los datos personales *******/

    $sql8 =" UPDATE nombre SET nombre='$nombre', paterno='$paterno', materno='$materno', fecha_nac='$fecha_nac', ci='$ci', ";
    $sql8.=" complemento='$complemento', exp='$exp', idnacionalidad='$idnacionalidad', idgenero='$idgenero' WHERE idnombre='$idnombre_mod' ";
    $result8 = mysqli_query($link,$sql8);
    header("Location:modifica_registro_safci.php");

?>