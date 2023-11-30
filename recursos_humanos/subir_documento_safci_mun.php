<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php

date_default_timezone_set('America/La_Paz');
$fecha_ram	   = date("Ymd");
$fecha 		   = date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idpersonal = $_POST['idpersonal'];

$file_name = $_FILES['file']['name'];

$directorio = 'files/';
   
/****** subimos el arcvhivo adjunto al directorio "files" ****/

        if ($file_name != '' || $file_name != null) {

                    $subir_archivo = $directorio.basename($file_name);

                if (move_uploaded_file($_FILES['file']['tmp_name'],'../'.$subir_archivo)) {

                    $ins = $link->query(" UPDATE personal SET url='$subir_archivo' WHERE idpersonal='$idpersonal' "); 

                    header("Location:mensaje_documento_mun.php");
      
                    } else {
                    
                    header("Location:mensaje_documento_error_mun.php");

                    }
                }
        else
            {
                /******* En caso de modificar sin adjuntar o cambiar el archivo adjunnto ******/
                header("Location:mensaje_sin_documento_mun.php");        
            }  
?>