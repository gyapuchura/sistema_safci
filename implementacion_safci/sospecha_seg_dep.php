<?php include("../inc.config.php");
$iddepartamento_dep = $_POST["departamento_dep"];
?>
<option value="">Elegir Registro Epidemiológico</option>
<?php
$numero = 1;
$sql2 = " SELECT ficha_ep.idsospecha_diag, sospecha_diag.sospecha_diag FROM ficha_ep, notificacion_ep, sospecha_diag  ";
$sql2.= " WHERE ficha_ep.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND ficha_ep.idsospecha_diag=sospecha_diag.idsospecha_diag ";
$sql2.= " AND notificacion_ep.iddepartamento='$iddepartamento_dep' AND ficha_ep.direccion != '' GROUP BY ficha_ep.idsospecha_diag ";
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