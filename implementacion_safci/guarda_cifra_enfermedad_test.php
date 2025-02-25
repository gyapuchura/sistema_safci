<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha 	 = date("Y-m-d");
$hora    = date("H:i");
$gestion = date("Y");

$idusuario_ss  = $_SESSION['idusuario_ss'];
$idnombre_ss   = $_SESSION['idnombre_ss'];
$perfil_ss     = $_SESSION['perfil_ss'];

$iddepartamento_ss          = $_SESSION['iddepartamento_ss'];
$idred_salud_ss             = $_SESSION['idred_salud_ss'];
$idmunicipio_ss             = $_SESSION['idmunicipio_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idnotificacion_ep_ss       = $_SESSION['idnotificacion_ep_ss'];
$idsospecha_diag_ss         = $_SESSION['idsospecha_diag_ss'];

$idregistro_enfermedad = $_POST['idregistro_enfermedad'];

$cifra = $_POST['cifra'];

echo " Este script es la solucion al problema </br>";

echo "idregistro_enfermedad = ".$idregistro_enfermedad[0]."</br>";
echo "idregistro_enfermedad = ".$idregistro_enfermedad[1]."</br>";
echo "idregistro_enfermedad = ".$idregistro_enfermedad[2]."</br>";
echo "idregistro_enfermedad = ".$idregistro_enfermedad[3]."</br>";
echo "idregistro_enfermedad = ".$idregistro_enfermedad[4]."</br>";
echo "idregistro_enfermedad = ".$idregistro_enfermedad[5]."</br></br>";

echo "cifra = ".$cifra[0]."</br>";
echo "cifra = ".$cifra[1]."</br>";
echo "cifra = ".$cifra[2]."</br>";
echo "cifra = ".$cifra[3]."</br>";
echo "cifra = ".$cifra[4]."</br>";
echo "cifra = ".$cifra[5]."</br>";

?>