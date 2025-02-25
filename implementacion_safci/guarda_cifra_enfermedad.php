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

$sql4 =" SELECT idregistro_enfermedad, idnotificacion_ep, cifra FROM registro_enfermedad WHERE idnotificacion_ep='$idnotificacion_ep_ss' AND idsospecha_diag='$idsospecha_diag_ss' LIMIT 1  ";
$result4 = mysqli_query($link,$sql4);
$row4 = mysqli_fetch_array($result4);
$idregistro_enfermedad = $row4[0];

    foreach($_POST['cifra'] as $cifra) {
    
        $sql8 =" UPDATE registro_enfermedad SET cifra='$cifra', fecha_registro='$fecha', hora_registro='$hora', ";
        $sql8.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad' AND idsospecha_diag='$idsospecha_diag_ss' ";
        $result8 = mysqli_query($link,$sql8);
    
        $idregistro_enfermedad = $idregistro_enfermedad+1;
    }

    header("Location:notificacion_ep_etareos.php");   
?>