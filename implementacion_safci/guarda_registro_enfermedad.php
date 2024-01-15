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
$idnotificacion_ep_ss       = $_SESSION['idnotificacion_ep_ss'];

$fecha 	 = date("Y-m-d");
$hora    = date("h:i");
$gestion = date("Y");

//-----DATOS ENVIADOS EN EL FORMULARIO DE ESTABLECIMIENTO DE SALUD ----- //

$idsospecha_diag   = $_POST['idsospecha_diag'];

if ($idsospecha_diag == '') {
    
    header("Location:notificacion_ep.php");
}  
else {

//----- Guardamos en la tabla registro enfermedad por grupo etareo BEGIN ------//
$numero=1;
$sql4 =" SELECT idgrupo_etareo, grupo_etareo FROM grupo_etareo ";
$result4 = mysqli_query($link,$sql4);
if ($row4 = mysqli_fetch_array($result4)){
mysqli_field_seek($result4,0);
while ($field4 = mysqli_fetch_field($result4)){
} do { 

    $sql5 = " SELECT idgenero, genero FROM genero ";
    $result5 = mysqli_query($link,$sql5);
    if ($row5 = mysqli_fetch_array($result5)){
    mysqli_field_seek($result5,0);
    while ($field5 = mysqli_fetch_field($result5)){
    } do { 

        $sql2 = " INSERT INTO registro_enfermedad (idnotificacion_ep, idsospecha_diag, idgrupo_etareo, idgenero, cifra, fecha_registro, hora_registro, idusuario) ";
        $sql2.= " VALUES ('$idnotificacion_ep_ss','$idsospecha_diag','$row4[0]','$row5[0]','0','$fecha','$hora','$idusuario_ss') ";
        $result2 = mysqli_query($link,$sql2);

        }
        while ($row5 = mysqli_fetch_array($result5));
    } else {
    }  

$numero=$numero+1;
}
 while ($row4 = mysqli_fetch_array($result4));
 } else {
 }
//----- Guardamos en la tabla registro enfermedad por grupo etareo END ------//

        $_SESSION['idsospecha_diag_ss'] = $idsospecha_diag;  
    
        header("Location:notificacion_ep_etareos.php");
    }


?>
