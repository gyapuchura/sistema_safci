<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");
$hora    = date("H:i");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idusuario_origen  = $_POST['medico_operativo_cf1'];
$idusuario_destino = $_POST['medico_operativo_cf2'];
$idmotivo_cambio_cf = $_POST['idmotivo_cambio_cf'];


if (isset($_POST['idcarpeta_familiar'])) {

$idcarpeta_familiar = $_POST['idcarpeta_familiar'];

    foreach($idcarpeta_familiar as $idcarpeta_familiar_i) {

    
                    $sql1 = " UPDATE carpeta_familiar SET idusuario ='$idusuario_destino' ";
                    $sql1.= " WHERE idcarpeta_familiar = '$idcarpeta_familiar_i' ";
                    $result1 = mysqli_query($link,$sql1);   

                    $sql_s = " UPDATE seguimiento_cf SET idusuario ='$idusuario_destino' ";
                    $sql_s.= " WHERE idcarpeta_familiar = '$idcarpeta_familiar_i' ";
                    $result_s = mysqli_query($link,$sql_s); 

                    $sql2 = " INSERT INTO reasignacion_cf (idcarpeta_familiar, idusuario_origen, idusuario_destino, idmotivo_cambio_cf, transferido,fecha_registro, hora_registro, idusuario) ";
                    $sql2.= " VALUES ('$idcarpeta_familiar_i','$idusuario_origen','$idusuario_destino','$idmotivo_cambio_cf','SI','$fecha','$hora','$idusuario_ss') ";
                    $result2 = mysqli_query($link,$sql2);   


                    $sql_seg =" SELECT idseguimiento_cf FROM seguimiento_cf WHERE idcarpeta_familiar = '$idcarpeta_familiar_i'";
                    $result_seg = mysqli_query($link,$sql_seg);
                    if ($row_seg = mysqli_fetch_array($result_seg)){
                    mysqli_field_seek($result_seg,0);
                    while ($field_seg = mysqli_fetch_field($result_seg)){
                    } do { 

                        $sql_v = " UPDATE visita_cf SET idusuario ='$idusuario_destino' ";
                        $sql_v.= " WHERE idseguimiento_cf = '$row_seg[0]' ";
                        $result_v = mysqli_query($link,$sql_v); 

                    }
                    while ($row_seg = mysqli_fetch_array($result_seg));
                    } else {
                    }

            }

                header("Location:mensaje_transferencia_parcial_cf.php");
} else
{
    header("Location:mensaje_transferencia_sin_cf.php");
}
    
?>