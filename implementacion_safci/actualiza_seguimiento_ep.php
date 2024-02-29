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
$idmunicipio_ss             = $_SESSION['idmunicipio_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];

//-----DATOS ENVIADOS EN EL FORMULARIO DE SEGUIMIENTO POR ESTABLECIMIENTO DE SALUD ----- //

$idficha_ep            = $_POST['idficha_ep']; 
$idregistro_enfermedad = $_POST['idregistro_enfermedad']; 
$idnotificacion_ep     = $_POST['idnotificacion_ep']; 
$idsemana_ep           = $_POST['idsemana_ep']; 
$idestado_paciente     = $_POST['idestado_paciente']; 

$idsospecha_diag = $_POST['idsospecha_diag']; 
$idgrupo_etareo  = $_POST['idgrupo_etareo']; 
$idgenero        = $_POST['idgenero']; 

        $sql8 ="INSERT INTO seguimiento_ep (idficha_ep, idregistro_enfermedad, idnotificacion_ep, idsospecha_diag, idsemana_ep, idestado_paciente, idusuario, fecha_registro ) ";
        $sql8.=" VALUES ('$idficha_ep','$idregistro_enfermedad','$idnotificacion_ep','$idsospecha_diag_ss','$idsemana_ep','$idestado_paciente','$idusuario_ss','$fecha') ";           
        $result8 = mysqli_query($link,$sql8); 
        $idseguimiento_ep = mysqli_insert_id($link);

                $_SESSION['idnotificacion_ep_ss'] = $idnotificacion_ep;
                $_SESSION['idregistro_enfermedad_ss'] = $idregistro_enfermedad;
                $_SESSION['idficha_ep_ss'] = $idficha_ep; 
                            
                $_SESSION['idseguimiento_ep_ss'] = $idseguimiento_ep;

                $_SESSION['idsospecha_diag_ss'] = $idsospecha_diag;
                $_SESSION['idgrupo_etareo_ss']  = $idgrupo_etareo;
                $_SESSION['idgenero_ss']        = $idgenero;

        if ($idestado_paciente == "6") {
                header("Location:evolucion_enfermedad.php");
        } else {
                header("Location:fichas_ep_establecimiento.php");
        }
        
        
        
    
?>