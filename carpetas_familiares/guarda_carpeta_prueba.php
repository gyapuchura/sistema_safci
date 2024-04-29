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
$familia         = $link->real_escape_string($_POST['familia']);
$avenida_calle   = $link->real_escape_string($_POST['avenida_calle']);
$no_puerta       = $_POST['no_puerta'];
$nombre_edificio = $link->real_escape_string($_POST['nombre_edificio']);
$latitud         = $_POST['latitud'];
$longitud        = $_POST['longitud'];
$altura          = $_POST['altura'];

echo $iddepartamento;
echo "</br>";
echo $idred_salud;
echo "</br>";
echo $idmunicipio;
echo "</br>";
echo $idestablecimiento_salud;
echo "</br>";
echo $idarea_influencia;
echo "</br>";
echo $fecha_apertura;
echo "</br>";
echo $familia;
echo "</br>";
echo $avenida_calle;
echo "</br>";
echo $no_puerta;
echo "</br>";
echo $nombre_edificio;
echo "</br>";
echo $latitud;
echo "</br>";
echo $longitud;
echo "</br>";
echo $altura;
echo "</br>";


?>
