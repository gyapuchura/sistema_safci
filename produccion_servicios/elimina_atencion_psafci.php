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

$idatencion_psafci_ss = $_SESSION['idatencion_psafci_ss'];

/*********** ENVIO DATOS PARA TRIAGE DEL PACIENTE *************/
$idatencion_psafci = $_POST['idatencion_psafci'];
$idtipo_atencion   = $_POST['idtipo_atencion'];

/* BORRAMOS EL REGISTRO de atencion medica psafci*/

if ($idtipo_atencion =='3'  || $idtipo_atencion =='4' ) {

    $sql = " DELETE FROM examen_teleconsulta  WHERE idatencion_psafci ='$idatencion_psafci '";
    $result = mysqli_query($link,$sql);

    $sql = " DELETE FROM signo_vital_psafci  WHERE idatencion_psafci ='$idatencion_psafci '";
    $result = mysqli_query($link,$sql);

    $sql = " DELETE FROM diagnostico_teleconsulta  WHERE idatencion_psafci ='$idatencion_psafci '";
    $result = mysqli_query($link,$sql);

    $sql = " DELETE FROM atencion_grupo_vulnerable  WHERE idatencion_psafci ='$idatencion_psafci '";
    $result = mysqli_query($link,$sql);

    $sql = " DELETE FROM atencion_teleconsulta  WHERE idatencion_psafci ='$idatencion_psafci '";
    $result = mysqli_query($link,$sql);

    $sql = " DELETE FROM atencion_psafci  WHERE idatencion_psafci ='$idatencion_psafci '";
    $result = mysqli_query($link,$sql);


    header("Location:mensaje_borrado_atencion_psafci.php");

} else {

    $sql = " DELETE FROM signo_vital_psafci  WHERE idatencion_psafci ='$idatencion_psafci '";
    $result = mysqli_query($link,$sql);

    $sql = " DELETE FROM tratamiento_psafci  WHERE idatencion_psafci ='$idatencion_psafci '";
    $result = mysqli_query($link,$sql);

    $sql = " DELETE FROM diagnostico_psafci  WHERE idatencion_psafci ='$idatencion_psafci '";
    $result = mysqli_query($link,$sql);

    $sql = " DELETE FROM atencion_psafci  WHERE idatencion_psafci ='$idatencion_psafci '";
    $result = mysqli_query($link,$sql);

    header("Location:mensaje_borrado_atencion_psafci.php");

}




?>