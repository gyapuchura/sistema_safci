<?php include("../inc.config.php");
$iddepartamento = $_POST["departamento"];
?>
<option value="">Elegir MUNICIPIO</option>
<?php
$numero = 1;
$sql2 = " SELECT municipios.idmunicipio, municipios.municipio FROM ficha_ep, notificacion_ep, municipios ";
$sql2.= " WHERE ficha_ep.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND notificacion_ep.idmunicipio=municipios.idmunicipio ";
$sql2.= " AND notificacion_ep.estado='CONSOLIDADO' AND ficha_ep.direccion != '' AND municipios.iddepartamento='$iddepartamento' GROUP BY municipios.idmunicipio ORDER BY municipios.municipio ";
$result2 = mysqli_query($link,$sql2);
if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
echo "<option value=".$row2[0].">".$numero.".- ".$row2[1]."</option>";
$numero = $numero + 1;
} while ($row2 = mysqli_fetch_array($result2));
} else {
echo "No se encontraron resultados!";
}
?>