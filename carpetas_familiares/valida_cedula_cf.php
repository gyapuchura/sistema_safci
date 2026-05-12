
<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$ci = $_POST["ci"];

    $sql_n = " SELECT idnombre, nombre, paterno, materno, ci, complemento, exp, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE ci='$ci' ";
    $result_n = mysqli_query($link,$sql_n);
    if ($row_n = mysqli_fetch_array($result_n)) {

    $idnombre_persona = $row_n[0];
    $_SESSION['idnombre_persona_ss'] = $idnombre_persona;

    header("Location:agregar_persona_cf.php");

} else {
    header("Location:mensaje_psin_registro.php");
} 
?>