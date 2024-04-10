<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha 	 = date("Y-m-d");
$hora    = date("H:i");
$gestion = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idsospecha_diag_ss         = $_SESSION['idsospecha_diag_ss'];
$iddepartamento_ss          = $_SESSION['iddepartamento_ss'];
$idnotificacion_ep_ss       = $_SESSION['idnotificacion_ep_ss'];
$idregistro_enfermedad_ss   = $_SESSION['idregistro_enfermedad_ss'];
$idficha_ep_ss              = $_SESSION['idficha_ep_ss'];
$idred_salud_ss             = $_SESSION['idred_salud_ss'];
$idmunicipio_ss             = $_SESSION['idmunicipio_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idgrupo_etareo_ss          = $_SESSION['idgrupo_etareo_ss'];
$idgenero_ss                = $_SESSION['idgenero_ss'];

$idsemana_ep        = $_POST['idsemana_ep'];
$idestado_paciente  = $_POST['idestado_paciente'];

if ($idsemana_ep == '' || $idestado_paciente == '') {

        header("Location:actualiza_estado_enfermedad_ep.php");

} else {

if ($idestado_paciente == "6") {

        $_SESSION['idsemana_ep_ss']       = $idsemana_ep;
        $_SESSION['idestado_paciente_ss'] = $idestado_paciente;

        header("Location:evolucion_enfermedad_ep.php");

} else {

        $sql8 ="INSERT INTO seguimiento_ep (idficha_ep, idregistro_enfermedad, idnotificacion_ep, idsospecha_diag, idsemana_ep, idestado_paciente, idusuario, fecha_registro ) ";
        $sql8.=" VALUES ('$idficha_ep_ss','$idregistro_enfermedad_ss','$idnotificacion_ep_ss','$idsospecha_diag_ss','$idsemana_ep','$idestado_paciente','$idusuario_ss','$fecha') ";           
        $result8 = mysqli_query($link,$sql8); 

        header("Location:actualiza_estado_enfermedad_ep.php");
}
}

    
?>