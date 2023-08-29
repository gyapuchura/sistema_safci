<option value="0">Elegir DIRECCION</option>
<?php
include("../inc.config.php");
$options="";

$idministerio = $_POST["ministerio"];

$sql2 = "SELECT iddireccion, direccion, sigla FROM direccion WHERE idministerio='$idministerio' ORDER BY iddireccion";
$result2 = mysqli_query($link,$sql2);
if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
echo "<option value=". $row2[0]. ">".$row2[2].".- ".$row2[1]."</option>";
} while ($row2 = mysqli_fetch_array($result2));
} else {
echo "No se encontraron resultados!";
}
?>
