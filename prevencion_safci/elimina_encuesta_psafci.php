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
$idencuesta_psafci = $_POST['idencuesta_psafci'];

/* VERIFICAMOS QUE NO TENGA REGISTROS DE REFERENCIAS ASOCIADAS A LA ATENCOON MEDICA  idatencion_psafci*/

    $sql1 =" SELECT idreferencia_hc, codigo FROM referencia_hc WHERE idatencion_psafci ='$idatencion_psafci' ";
    $result1 = mysqli_query($link,$sql1);
    if ($row1 = mysqli_fetch_array($result1)) {

        header("Location:mensaje_referencia_atencion_psafci.php");
        
    } else {

/* BORRAMOS EL REGISTRO de encuesta medica psafci*/

    $sql = " DELETE FROM respuesta_item_cancer  WHERE idencuesta_psafci ='$idencuesta_psafci'";
    $result = mysqli_query($link,$sql);

    $sql = " DELETE FROM respuesta_encuesta  WHERE idencuesta_psafci ='$idencuesta_psafci'";
    $result = mysqli_query($link,$sql);

    $sql = " DELETE FROM encuesta_psafci  WHERE idencuesta_psafci ='$idencuesta_psafci'";
    $result = mysqli_query($link,$sql);

    $sql = " DELETE FROM signo_vital_psafci  WHERE idatencion_psafci ='$idatencion_psafci'";
    $result = mysqli_query($link,$sql);

    $sql = " DELETE FROM atencion_psafci  WHERE idatencion_psafci ='$idatencion_psafci'";
    $result = mysqli_query($link,$sql);

    header("Location:mensaje_borrado_encuesta_psafci.php");

}


?>