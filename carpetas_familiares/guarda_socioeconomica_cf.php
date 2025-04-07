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

$idcarpeta_familiar_ss  = $_SESSION['idcarpeta_familiar_ss'];


$sql_soc = " SELECT idsocio_economica FROM socio_economica_cf WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
$result_soc = mysqli_query($link,$sql_soc);   
if ($socioeconomia = mysqli_fetch_array($result_soc)) {

    header("Location:mensaje_socioeconomicas_cf.php");

} else {

$idsocio_economica_i = '1';
    
    foreach($_POST['valor4'] as $valor) {
    
        $sql_a = " INSERT INTO socio_economica_cf (idcarpeta_familiar, idsocio_economica, valor, fecha_registro, hora_registro, idusuario) ";
        $sql_a.= " VALUES ('$idcarpeta_familiar_ss','$idsocio_economica_i','$valor','$fecha','$hora','$idusuario_ss') ";
        $result_a = mysqli_query($link,$sql_a);  
    
        $idsocio_economica_i = $idsocio_economica_i+1;
    
    }

    header("Location:socioeconomicas_cf.php");

}

        /*********** Guarda el registro de dterminante de la salud (END) *************/
        ?>