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

$idevento_vacunacion_ss  =  $_SESSION['idevento_vacunacion_ss'];

$fecha_sesion    = $_POST['fecha_sesion'];
$duracion        = $_POST['duracion'];
$idcharla_psafci = $_POST['idcharla_psafci'];
$idsustantivo    = $_POST['idsustantivo'];
$asistentes      = $_POST['asistentes'];

if ($fecha_sesion == '' || $fecha_sesion == '' || $idcharla_psafci == '' || $idsustantivo == '' ) {
    
    header("Location:sesiones_educativas.php");
}  
else {

    $sqlm = " SELECT dato_laboral.iddato_laboral, dato_laboral.iddepartamento, establecimiento_salud.idmunicipio, dato_laboral.idestablecimiento_salud FROM dato_laboral, establecimiento_salud ";
    $sqlm.= " WHERE dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
    $sqlm.= " AND dato_laboral.idusuario='$idusuario_ss' ORDER BY dato_laboral.iddato_laboral DESC LIMIT 1 ";
    $resultm = mysqli_query($link,$sqlm);
    $rowm = mysqli_fetch_array($resultm);

        $iddepartamento = $rowm[1];
        $idmunicipio    = $rowm[2];
        $idestablecimiento_salud = $rowm[3];

        $sql_d = "SELECT sigla FROM departamento WHERE iddepartamento='$iddepartamento' ";
        $result_d = mysqli_query($link,$sql_d);
        $row_d = mysqli_fetch_array($result_d);

        $sqlm = "SELECT MAX(correlativo) FROM sesion_educativa WHERE gestion='$gestion' ";
        $resultm = mysqli_query($link,$sqlm);
        $rowm = mysqli_fetch_array($resultm);

        $correlativo=$rowm[0]+1;

    $codigo="SAFCI/PROM/".$row_d[0]."-".$correlativo."/".$gestion;

        $sql8 = " INSERT INTO sesion_educativa (iddepartamento, idmunicipio, idestablecimiento_salud, correlativo, codigo, gestion, ";
        $sql8.= " fecha_sesion, duracion, idcharla_psafci, idsustantivo, asistentes, fecha_registro, hora_registro, idusuario)";
        $sql8.= " VALUES ('$iddepartamento','$idmunicipio','$idestablecimiento_salud','$correlativo','$codigo','$gestion', ";
        $sql8.= " '$fecha_sesion','$duracion','$idcharla_psafci','$idsustantivo','$asistentes','$fecha','$hora','$idusuario_ss')";
        $result8 = mysqli_query($link,$sql8);  
    
        header("Location:mensaje_registro_sesion_ed.php");

    }


?>
