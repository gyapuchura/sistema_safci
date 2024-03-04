
<?php include("../inc.config.php");
$idmunicipio = $_POST["municipio"];
?>

<option value="">Elegir Establecimiento</option>
<?php
$numero = 1;
$sql2 = " SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud WHERE idmunicipio='$idmunicipio' ORDER BY establecimiento_salud ";

$result2 = mysqli_query($link,$sql2);
if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
echo "<option value=".$row2[0].">".$numero.".- Establecimiento: ".$row2[1]." </option>";
$numero = $numero+1;
} while ($row2 = mysqli_fetch_array($result2));
} else {
echo "No se encontraron resultados!";
}
?>
