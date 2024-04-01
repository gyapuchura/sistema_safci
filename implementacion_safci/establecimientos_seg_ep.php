
<?php include("../inc.config.php");
$idmunicipio = $_POST["municipio"];
?>

<option value="">Elegir Establecimiento de Salud</option>
<?php
$numero = 1;
$sql2 = " SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.establecimiento_salud FROM ficha_ep, notificacion_ep, establecimiento_salud ";
$sql2.= " WHERE ficha_ep.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND notificacion_ep.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
$sql2.= " AND notificacion_ep.estado='CONSOLIDADO' AND ficha_ep.direccion != '' AND establecimiento_salud.idmunicipio='$idmunicipio' GROUP BY establecimiento_salud.idestablecimiento_salud ORDER BY establecimiento_salud.establecimiento_salud ";
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
