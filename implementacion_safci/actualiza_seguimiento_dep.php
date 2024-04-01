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

//-----DATOS ENVIADOS EN EL FORMULARIO DE SEGUIMIENTO POR ESTABLECIMIENTO DE SALUD ----- //

$idficha_ep              = $_POST['idficha_ep']; 
$idred_salud             = $_POST['idred_salud']; 
$idmunicipio             = $_POST['idmunicipio']; 
$idestablecimiento_salud = $_POST['idestablecimiento_salud']; 
$idregistro_enfermedad   = $_POST['idregistro_enfermedad']; 
$idnotificacion_ep       = $_POST['idnotificacion_ep']; 
$idsemana_ep             = $_POST['idsemana_ep']; 
$idestado_paciente       = $_POST['idestado_paciente']; 

$idsospecha_diag = $_POST['idsospecha_diag']; 
$idgrupo_etareo  = $_POST['idgrupo_etareo']; 
$idgenero        = $_POST['idgenero']; 

if ($idestado_paciente == "6") {

        $_SESSION['idnotificacion_ep_ss'] = $idnotificacion_ep;
        $_SESSION['idregistro_enfermedad_ss'] = $idregistro_enfermedad;
        $_SESSION['idficha_ep_ss'] = $idficha_ep; 
        $_SESSION['idred_salud_ss'] = $idred_salud;            
        $_SESSION['idmunicipio_ss'] = $idmunicipio;
        $_SESSION['idestablecimiento_salud_ss'] = $idestablecimiento_salud;       
        $_SESSION['idsemana_ep_ss'] = $idsemana_ep;
        $_SESSION['idestado_paciente_ss'] = $idestado_paciente;
        $_SESSION['idsospecha_diag_ss'] = $idsospecha_diag;
        $_SESSION['idgrupo_etareo_ss']  = $idgrupo_etareo;
        $_SESSION['idgenero_ss']        = $idgenero;

        header("Location:evolucion_enfermedad_dep.php");
} else {

        $sql8 ="INSERT INTO seguimiento_ep (idficha_ep, idregistro_enfermedad, idnotificacion_ep, idsospecha_diag, idsemana_ep, idestado_paciente, idusuario, fecha_registro ) ";
        $sql8.=" VALUES ('$idficha_ep','$idregistro_enfermedad','$idnotificacion_ep','$idsospecha_diag_ss','$idsemana_ep','$idestado_paciente','$idusuario_ss','$fecha') ";           
        $result8 = mysqli_query($link,$sql8); 


        header("Location:fichas_ep_establecimiento_dep.php");
}
    
?>