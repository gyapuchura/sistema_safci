<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$iddepartamento_ss = $_SESSION['iddepartamento_ss'];
$idred_salud_ss    = $_SESSION['idred_salud_ss'];
$idmunicipio_ss    = $_SESSION['idmunicipio_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];

$fecha 	 = date("Y-m-d");
$hora    = date("H:i");
$gestion = date("Y");

//-----DATOS ENVIADOS EN EL FORMULARIO DE ESTABLECIMIENTO DE SALUD ----- //

$semana_ep   = $_POST['semana_ep'];

if ($semana_ep == '') {
    
    header("Location:iniciar_notificacion_ep.php");
}  
else {
    $sql_v = " SELECT idnotificacion_ep, idestablecimiento_salud, semana_ep, estado, idusuario FROM notificacion_ep ";
    $sql_v.= " WHERE idestablecimiento_salud='$idestablecimiento_salud_ss' AND semana_ep='$semana_ep' AND gestion='$gestion' ";
    $result_v = mysqli_query($link,$sql_v);
    if ($row_v=mysqli_fetch_array($result_v)) {

        header("Location:mensaje_notificacion_ep_existe.php");

    } else {

//----- Obtenemos el codigo y correlativo de notificacion ------//

$sqlm="SELECT MAX(correlativo) FROM notificacion_ep WHERE gestion='$gestion' ";
$resultm=mysqli_query($link,$sqlm);
$rowm=mysqli_fetch_array($resultm);

$correlativo = $rowm[0]+1;

$codigo = "MSYD-PSAFCI-302A-".$correlativo."/".$gestion;

        $sql8 = " INSERT INTO notificacion_ep (correlativo, codigo, gestion, iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, ";
        $sql8.= " semana_ep, fecha_registro, hora_registro, idusuario )";
        $sql8.= " VALUES ('$correlativo','$codigo','$gestion','$iddepartamento_ss','$idred_salud_ss','$idmunicipio_ss','$idestablecimiento_salud_ss', ";
        $sql8.= " '$semana_ep','$fecha','$hora','$idusuario_ss')";
        $result8 = mysqli_query($link,$sql8);  
        $idnotificacion_ep = mysqli_insert_id($link);

        $_SESSION['idnotificacion_ep_ss'] = $idnotificacion_ep;  

/******** Generamos el registro de eventos con la creacion de la notificacion ********8 */

$numero=1;
$sql4 =" SELECT idevento_notificacion, evento_notificacion FROM evento_notificacion ";
$result4 = mysqli_query($link,$sql4);
if ($row4 = mysqli_fetch_array($result4)){
mysqli_field_seek($result4,0);
while ($field4 = mysqli_fetch_field($result4)){
} do { 

        $sql2 = " INSERT INTO registro_evento_notificacion (idnotificacion_ep, idevento_notificacion, numero_eventos, personas_atendidas, personas_afectadas, personas_fallecidas, fecha_registro, hora_registro, idusuario, gestion) ";
        $sql2.= " VALUES ('$idnotificacion_ep','$row4[0]','0','0','0','0','$fecha','$hora','$idusuario_ss','$gestion') ";
        $result2 = mysqli_query($link,$sql2);

$numero=$numero+1;
}
 while ($row4 = mysqli_fetch_array($result4));
 } else {
 }
        header("Location:notificacion_ep.php");
    }
       
    }
?>
