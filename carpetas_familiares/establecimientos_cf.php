<?php include("../inc.config.php");
$idmunicipio = $_POST["municipio_salud"];
?>
<option value="">Elegir Establecimiento de Salud</option>
<?php
$numero = 1;
$sql2 = " SELECT ubicacion_cf.idestablecimiento_salud, establecimiento_salud.establecimiento_salud ";
$sql2.= " FROM ubicacion_cf, establecimiento_salud  ";
$sql2.= " WHERE ubicacion_cf.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
$sql2.= " AND ubicacion_cf.idmunicipio='$idmunicipio' GROUP BY ubicacion_cf.idestablecimiento_salud ORDER BY establecimiento_salud.establecimiento_salud ";
$result2 = mysqli_query($link,$sql2);
if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
echo "<option value=".$row2[0].">".$numero.".- ".$row2[1]." </option>";
$numero = $numero+1;
} while ($row2 = mysqli_fetch_array($result2));
} else {
echo "No se encontraron resultados!";
}
?>
