<?php include("../inc.config.php");
$idestablecimiento_salud = $_POST["establecimiento_salud"];
?>
<option value="">Elegir Registro Epidemiológico</option>
<?php
$numero = 1;
$sql2 = " SELECT ficha_ep.idsospecha_diag, sospecha_diag.sospecha_diag FROM ficha_ep, notificacion_ep, sospecha_diag  ";
$sql2.= " WHERE ficha_ep.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND ficha_ep.idsospecha_diag=sospecha_diag.idsospecha_diag ";
$sql2.= " AND notificacion_ep.idestablecimiento_salud='$idestablecimiento_salud' GROUP BY ficha_ep.idsospecha_diag ";
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