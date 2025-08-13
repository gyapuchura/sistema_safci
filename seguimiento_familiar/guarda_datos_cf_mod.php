<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$fecha 	 = date("Y-m-d");
$hora    = date("H:i");
$gestion = date("Y");

//-----DATOS ENVIADOS EN EL FORMULARIO DE ESTABLECIMIENTO DE SALUD ----- //

$idcarpeta_familiar_ss = $_SESSION['idcarpeta_familiar_ss'];

$idarea_influencia  = $_POST['idarea_influencia'];

$fecha_apertura  = $_POST['fecha_apertura'];
$familia         = $link->real_escape_string(mb_strtoupper($_POST['familia']));
$avenida_calle   = $link->real_escape_string(mb_strtoupper($_POST['avenida_calle']));
$no_puerta       = $link->real_escape_string($_POST['no_puerta']);
$nombre_edificio = $link->real_escape_string(mb_strtoupper($_POST['nombre_edificio']));
$latitud         = $_POST['latitud'];
$longitud        = $_POST['longitud'];
$altura          = $_POST['altura'];

$sql_cf =" SELECT idubicacion_cf FROM ubicacion_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND ubicacion_actual='SI' ";
$result_cf=mysqli_query($link,$sql_cf);
$row_cf=mysqli_fetch_array($result_cf);


        $sql8 = " UPDATE ubicacion_cf SET idarea_influencia='$idarea_influencia', avenida_calle='$avenida_calle', no_puerta='$no_puerta', ";
        $sql8.= " nombre_edificio='$nombre_edificio', latitud='$latitud', longitud='$longitud', altura='$altura', fecha_registro='$fecha', ";
        $sql8.= " hora_registro='$hora', idusuario='$idusuario_ss' WHERE idubicacion_cf='$row_cf[0]' ";
        $result8 = mysqli_query($link,$sql8); 

        $sql9 = " UPDATE carpeta_familiar SET familia='$familia', fecha_apertura='$fecha_apertura', idarea_influencia='$idarea_influencia', ";
        $sql9.= " fecha_registro='$fecha', hora_registro='$hora', idusuario='$idusuario_ss' WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
        $result9 = mysqli_query($link,$sql9);  
    
        header("Location:mensaje_datos_cf_mod.php");
        
?>
