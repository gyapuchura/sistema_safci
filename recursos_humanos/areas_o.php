<?php include("../cabf.php");?>
<?php include("../inc.config.php");
$iddireccion = $_POST["direccion"];
?>
<option value="">Elegir UNIDAD ORGANIZACIONAL</option>
<?php
$sql2 = "SELECT idarea, area FROM area WHERE iddireccion='$iddireccion' ORDER BY idarea";
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
