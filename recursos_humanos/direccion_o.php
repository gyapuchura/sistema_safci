
<?php include("../inc.config.php");
$idministerio = $_POST["ministerio"];
?>
<option value="">Elegir DIRECCION</option>
<?php
$sql2 = "SELECT iddireccion, direccion, sigla FROM direccion WHERE idministerio='$idministerio' ORDER BY iddireccion";
$result2 = mysqli_query($link,$sql2);
if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
echo "<option value=".$row2[0].">".$row2[2].".- ".$row2[1]."</option>";
} while ($row2 = mysqli_fetch_array($result2));
} else {
echo "No se encontraron resultados!";
}
?>
