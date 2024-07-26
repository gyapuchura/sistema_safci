<?php include("../cabf.php");?>
<?php include("../inc.config.php");
$iddepartamento = $_POST["departamento_e"];
?>
<option value="">Elegir Municipio</option>
<?php
$numero = 1;
$sql2 = " SELECT municipios.idmunicipio, municipios.municipio, municipios.cod_municipio FROM municipios, establecimiento_salud  ";
$sql2.= " WHERE municipios.idmunicipio=establecimiento_salud.idmunicipio AND establecimiento_salud.latitud != '' AND establecimiento_salud.longitud != '' ";
$sql2.= " AND municipios.iddepartamento='$iddepartamento' GROUP BY municipios.idmunicipio ORDER BY municipios.municipio ";
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
