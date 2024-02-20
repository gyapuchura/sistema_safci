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

$iddepartamento_ss          = $_SESSION['iddepartamento_ss'];
$idred_salud_ss             = $_SESSION['idred_salud_ss'];
$idmunicipio_ss             = $_SESSION['idmunicipio_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idnotificacion_ep_ss       = $_SESSION['idnotificacion_ep_ss'];
$idsospecha_diag_ss         = $_SESSION['idsospecha_diag_ss'];

$idregistro_enfermedad = $_POST['idregistro_enfermedad'];
$cifra                 = $_POST['cifra'];
$idgrupo_etareo        = $_POST['idgrupo_etareo'];
$idgenero              = $_POST['idgenero'];

/*********** Crear registros para fichas epidemiologicas (BEGIN) *************/

$sql_v = " SELECT idficha_ep, idregistro_enfermedad FROM ficha_ep ";
$sql_v.= " WHERE idregistro_enfermedad='$idregistro_enfermedad' AND gestion='$gestion' ";
$result_v = mysqli_query($link,$sql_v);
if ($row_v=mysqli_fetch_array($result_v))
{
    header("Location:mensaje_ficha_ep_existe.php");

} else {

for ($i = 1; $i <= $cifra; $i++) {

    $sqlm="SELECT MAX(correlativo) FROM ficha_ep WHERE gestion='$gestion' ";
    $resultm=mysqli_query($link,$sqlm);
    $rowm=mysqli_fetch_array($resultm);

    $correlativo = $rowm[0]+1;

    $codigo = "SAFCI-FICHA-EP-".$correlativo."/".$gestion;

        $sql2 = " INSERT INTO ficha_ep (idregistro_enfermedad, idnotificacion_ep, idsospecha_diag, idgrupo_etareo, idgenero, correlativo, codigo, gestion, ";
        $sql2.= " nombres, apellidos, cedula, fecha_nac, celular, direccion, latitud, longitud, idusuario, fecha_registro ) ";
        $sql2.= " VALUES ('$idregistro_enfermedad','$idnotificacion_ep_ss','$idsospecha_diag_ss','$idgrupo_etareo','$idgenero','$correlativo','$codigo','$gestion', ";
        $sql2.= " '','','','$fecha','','','','','$idusuario_ss','$fecha') ";
        $result2 = mysqli_query($link,$sql2);
    
}

$sql8 =" UPDATE registro_enfermedad SET estado='CON FICHAS', fecha_registro='$fecha', hora_registro='$hora',";
$sql8.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad' ";
$result8 = mysqli_query($link,$sql8);

header("Location:notificacion_ep_seg.php");
}
/*********** Crear registros para fichas epidemiologicas (END) *************/
?>