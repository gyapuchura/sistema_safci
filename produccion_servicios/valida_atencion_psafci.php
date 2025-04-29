
<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$idatencion_psafci       = $_POST['idatencion_psafci'];
$idestablecimiento_salud = $_POST['idestablecimiento_salud'];
$idnombre_integrante     = $_POST['idnombre_integrante'];
$edad                    = $_POST['edad'];

$sql1 =" SELECT idintegrante_cf, idcarpeta_familiar FROM integrante_cf WHERE idnombre='$idnombre_integrante' AND estado='CONSOLIDADO'";
$result1 = mysqli_query($link,$sql1);
if ($row1 = mysqli_fetch_array($result1)){

    $_SESSION['idatencion_psafci_ss']       = $idatencion_psafci;
    $_SESSION['idintegrante_cf_ss']         = $row1[0];
    $_SESSION['idcarpeta_familiar_ss']      = $row1[1];
    $_SESSION['idestablecimiento_salud_ss'] = $idestablecimiento_salud;
    $_SESSION['idnombre_integrante_ss']     = $idnombre_integrante;
    $_SESSION['edad_ss']                    = $edad;
     
    header("Location:mostrar_atencion_psafci.php");

} else {

    $_SESSION['idatencion_psafci_ss']       = $idatencion_psafci;
    $_SESSION['idestablecimiento_salud_ss'] = $idestablecimiento_salud;
    $_SESSION['idnombre_paciente_ss']       = $idnombre_integrante;
    $_SESSION['edad_ss']                    = $edad;

    header("Location:mostrar_atencion_psafci_ncf.php");
}




?>