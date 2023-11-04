<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php

date_default_timezone_set('America/La_Paz');
$fecha 		  = date("Y-m-d");

$idusuario_ss  = $_SESSION['idusuario_ss'];
$idnombre_ss   = $_SESSION['idnombre_ss'];
$perfil_ss     = $_SESSION['perfil_ss'];

$idpersonal_ss = $_SESSION['idpersonal_ss'];
$codigo_ss     = $_SESSION['codigo_ss'];
$gestion       = date("Y");

/* ingresamos los datos personales */

$idnombre_mod   = $_POST['idnombre_mod'];
$idusuario_mod  = $_POST['idusuario_mod'];

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

$sqlm    = " SELECT idpersonal, correlativo FROM personal WHERE idpersonal='$idpersonal_ss' ";
$resultm = mysqli_query($link,$sqlm);
$rowm    = mysqli_fetch_array($resultm);
$correlativo = $rowm[1];

$codigo = "PS/MSYD-".$correlativo."-".$ci."-".$gestion;


/****** actualizamos los datos personales *******/

    $sql8 =" UPDATE nombre SET nombre='$nombre', paterno='$paterno', materno='$materno', fecha_nac='$fecha_nac', ci='$ci', ";
    $sql8.=" complemento='$complemento', exp='$exp', idnacionalidad='$idnacionalidad', idgenero='$idgenero' WHERE idnombre='$idnombre_mod' ";
    $result8 = mysqli_query($link,$sql8);

    $sql9 =" UPDATE personal SET codigo='$codigo' WHERE idpersonal='$idpersonal_ss' ";
    $result9 = mysqli_query($link,$sql9);

    $sql9 =" UPDATE usuarios SET usuario='$ci', password='$ci' WHERE idusuario='$idusuario_mod' ";
    $result9 = mysqli_query($link,$sql9);

    header("Location:mensaje_personal_mod.php");

?>