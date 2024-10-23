<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
$gestion = date("Y");

$numero = 0;
$sql =" SELECT idubicacion_cf, idcarpeta_familiar, iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idarea_influencia ";
$sql.=" FROM ubicacion_cf WHERE iddepartamento='8' AND idcarpeta_familiar !='0' "; 
$result = mysqli_query($link,$sql);
if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {

    $sql0 = " UPDATE carpeta_familiar SET iddepartamento ='$row[2]', idred_salud ='$row[3]', idmunicipio ='$row[4]', ";
    $sql0.= " idestablecimiento_salud ='$row[5]', idarea_influencia ='$row[6]' WHERE idcarpeta_familiar = '$row[1]' ";
    $result0 = mysqli_query($link,$sql0); 

$numero = $numero+1;

}
while ($row = mysqli_fetch_array($result));
} else {
}

echo "</br></br>Son ".$numero." carpetas con datos de ubicacion actualizado !!!";

?>
