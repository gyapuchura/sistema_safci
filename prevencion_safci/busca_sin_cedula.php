<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$hora    = date("H:i");
$gestion = date("Y");

$idusuario_ss  = $_SESSION['idusuario_ss'];
$idnombre_ss   = $_SESSION['idnombre_ss'];
$perfil_ss     = $_SESSION['perfil_ss'];

$ci      = '0';
$paterno = 'MAMANI';
$materno = 'QUISPE';
$nombre  = 'MARIA LUCY';
$fecha_nac = '1994-05-31';

if ($ci == '0') {

# en caso de cedula de identidad igual a 0 ...
$sql = " SELECT idnombre, paterno, materno, nombre, ci, fecha_nac FROM nombre WHERE paterno='$paterno' AND materno='$materno' AND nombre='$nombre' AND fecha_nac='$fecha_nac' ";
$result = mysqli_query($link,$sql);
if ($row = mysqli_fetch_array($result)) {

    echo 'La persona buscada es ...'.$row[3].' '.$row[1].' '.$row[2];

} else {

    echo 'La persona con los nombres, apellidos y fecha de nacimiento no estan registrados en sistema';

}

} else {

    echo 'La cedula de identidad es diferente de 0';

}


?>