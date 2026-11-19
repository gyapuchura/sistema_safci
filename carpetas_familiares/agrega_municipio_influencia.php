<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
$gestion = date("Y");

$numero = 0;
$sql =" SELECT idestablecimiento_salud, idmunicipio FROM establecimiento_salud ORDER BY idestablecimiento_salud ";
$result = mysqli_query($link,$sql);
if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {

    $sql0 = " UPDATE area_influencia SET idmunicipio ='$row[1]' WHERE idestablecimiento_salud = '$row[0]' ";
    $result0 = mysqli_query($link,$sql0); 

$numero = $numero+1;

}
while ($row = mysqli_fetch_array($result));
} else {
}

echo "</br></br>Son ".$numero." Areas de Influencia con datos de municipio actualizado !!!";

?>
