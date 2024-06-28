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

$idtipo_evento_vacunacion = $_POST['idtipo_evento_vacunacion'];
$idvacuna                 = $_POST['idvacuna'];
$descripcion              = $link->real_escape_string($_POST['descripcion']);
$fecha_inicio             = $_POST['fecha_inicio'];
$fecha_conclusion         = $_POST['fecha_conclusion'];

if ($idtipo_evento_vacunacion == '' || $idvacuna == '') {
    
    header("Location:nuevo_evento_vacunacion.php");
}  
else {

    $sqlm = "SELECT MAX(correlativo) FROM evento_vacunacion WHERE gestion='$gestion' ";
    $resultm = mysqli_query($link,$sqlm);
    $rowm = mysqli_fetch_array($resultm);

    $correlativo=$rowm[0]+1;

    $codigo="SAFCI/VACUNACION-".$correlativo."/".$gestion;

        $sql8 = " INSERT INTO evento_vacunacion (gestion, correlativo, codigo, idtipo_evento_vacunacion, idvacuna, ";
        $sql8.= " descripcion, fecha_inicio, fecha_conclusion, fecha_registro, hora_registro, idusuario)";
        $sql8.= " VALUES ('$gestion','$correlativo','$codigo','$idtipo_evento_vacunacion','$idvacuna', ";
        $sql8.= " '$descripcion','$fecha_inicio','$fecha_conclusion','$fecha','$hora','$idusuario_ss')";
        $result8 = mysqli_query($link,$sql8);  
        $idevento_vacunacion = mysqli_insert_id($link);

        $_SESSION['idevento_vacunacion_ss'] = $idevento_vacunacion;  
    
        header("Location:mostrar_evento_vacunacion.php");
    }


?>
