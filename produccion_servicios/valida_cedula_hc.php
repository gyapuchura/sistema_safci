
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

$sql_hc = " SELECT integrante_cf.idintegrante_cf, integrante_cf.idnombre, integrante_cf.idcarpeta_familiar, carpeta_familiar.iddepartamento,  ";
$sql_hc.= " carpeta_familiar.idestablecimiento_salud FROM integrante_cf, nombre, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_hc.= " AND integrante_cf.idnombre=nombre.idnombre AND nombre.ci='$ci' ORDER BY integrante_cf.idintegrante_cf DESC LIMIT 1";
$result_hc = mysqli_query($link,$sql_hc);
if ($row_hc = mysqli_fetch_array($result_hc)) {

$idintegrante_cf = $row_hc[0];
$idnombre_integrante = $row_hc[1];
$idcarpeta_familiar = $row_hc[2];
$iddepartamento = $row_hc[3];
$idestablecimiento_salud = $row_hc[4];

$_SESSION['idintegrante_cf_ss'] = $idintegrante_cf;
$_SESSION['idnombre_integrante_ss'] = $idnombre_integrante;
$_SESSION['idcarpeta_familiar_ss'] = $idcarpeta_familiar;
$_SESSION['iddepartamento_ss'] = $iddepartamento;
$_SESSION['idestablecimiento_salud_ss'] = $idestablecimiento_salud;

header("Location:mostrar_persona_hc.php");
    
} else {   
header("Location:mensaje_persona_sin_hc.php");
}

?>