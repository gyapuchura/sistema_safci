<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$idevento_safci_ss  =  $_SESSION['idevento_safci_ss'];

$ci = $_POST['ci'];


$sql_p =" SELECT idnombre, nombre, paterno, materno FROM nombre WHERE ci='$ci' ";
$result_p=mysqli_query($link,$sql_p);

if ($row_p=mysqli_fetch_array($result_p)) {

    $_SESSION['idnombre_paciente_ss'] = $row_p[0];

    header("Location:prepara_paciente.php");

} else {
    header("Location:mensaje_paciente_no_existe.php");
}

?>