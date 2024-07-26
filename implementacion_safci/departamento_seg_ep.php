<?php include("../cabf.php"); ?>
<?php include("../inc.config.php");
$idsospecha_diag = $_POST["sospecha_diag"];
?>

<option value="">Elegir Departamento</option>
<?php
$numero = 1;
$sql2 = " SELECT departamento.iddepartamento, departamento.departamento FROM ficha_ep, notificacion_ep, departamento ";
$sql2.= " WHERE ficha_ep.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND notificacion_ep.iddepartamento=departamento.iddepartamento AND notificacion_ep.estado='CONSOLIDADO' ";
$sql2.= " AND ficha_ep.idsospecha_diag='$idsospecha_diag' GROUP BY departamento.iddepartamento ORDER BY departamento.departamento ";
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
