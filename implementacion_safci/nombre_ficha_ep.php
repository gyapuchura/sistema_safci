<?php include("../cabf.php"); ?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

//----- Guardamos en la tabla registro enfermedad por grupo etareo BEGIN ------//
$numero=1;
$sql4 =" SELECT idficha_ep, nombres, apellidos, cedula, fecha_nac, idgenero FROM ficha_ep ";
$result4 = mysqli_query($link,$sql4);
if ($row4 = mysqli_fetch_array($result4)){
mysqli_field_seek($result4,0);
while ($field4 = mysqli_fetch_field($result4)){
} do { 

    $apellidos = explode(' ',$row4[2]);
    
    $paterno = $apellidos[0];
    $materno = $apellidos[1];
    $nombre = $row4[1];
    $ci = $row4[3];
    $exp = "";
    $fecha_nac = $row4[4];
    $complemento = "";
    $idgenero = $row4[5];

    $sql0 = " INSERT INTO nombre (paterno, materno, nombre, ci, exp, fecha_nac, complemento, idnacionalidad, idgenero) ";
    $sql0.= " VALUES ('$paterno','$materno','$nombre','$ci','$exp','$fecha_nac','$complemento','1','$idgenero') ";
    $result0 = mysqli_query($link,$sql0);   
    $idnombre = mysqli_insert_id($link);

    $sql8 =" UPDATE ficha_ep SET idnombre='$idnombre' WHERE idficha_ep='$row4[0]'";
    $result8 = mysqli_query($link,$sql8);

}
 while ($row4 = mysqli_fetch_array($result4));
 } else {
 }

 header("Location:correcion_exitosa.php");
//----- Guardamos en la tabla registro enfermedad por grupo etareo END ------//

?>
