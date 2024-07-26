<?php include("../cabf.php");?>
<?php include("../inc.config.php");
$idcat_evento_safci = $_POST["cat_evento_safci"];
?>

<option value="">Elegir tipo de Evento</option>
<?php
$numero = 1;
$sql2 = " SELECT idtipo_evento_safci, tipo_evento_safci FROM tipo_evento_safci WHERE idcat_evento_safci='$idcat_evento_safci' ORDER BY tipo_evento_safci ";

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
