<?php include("../cabf.php");?>
<?php include("../inc.config.php");
$idcat_determinante_salud = $_POST["cat_determinante_salud"];
?>
<option value="">Elegir</option>
<?php
$sql2 = "SELECT iditem_determinante_salud, item_determinante_salud, valor FROM item_determinante_salud WHERE idcat_determinante_salud='$idcat_determinante_salud'";
$result2 = mysqli_query($link,$sql2);
if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
echo "<option value=".$row2[0].">".$row2[1]."</option>";
} while ($row2 = mysqli_fetch_array($result2));
} else {
echo "No se encontraron resultados!";
}
?> 
