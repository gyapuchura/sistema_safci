<?php include("../inc.config.php");
$iddepartamento = $_POST["departamento"];
?>
<option value="">Elegir Municipio</option>
<?php
$numero = 1;
$sql2 = " SELECT establecimiento_salud.idmunicipio, municipios.municipio FROM area_influencia, establecimiento_salud, municipios ";
$sql2.= " WHERE area_influencia.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
$sql2.= " AND establecimiento_salud.idmunicipio=municipios.idmunicipio AND establecimiento_salud.iddepartamento='$iddepartamento ' ";
$sql2.= " GROUP BY establecimiento_salud.idmunicipio ORDER BY municipios.municipio ";
$result2 = mysqli_query($link,$sql2);
if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
echo "<option value=".$row2[0].">".$numero.".- Municipio : ".$row2[1]." </option>";
$numero = $numero+1;
} while ($row2 = mysqli_fetch_array($result2));
} else {
echo "No se encontraron resultados!";
}
?>
