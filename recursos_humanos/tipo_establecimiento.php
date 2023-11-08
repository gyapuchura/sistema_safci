
<?php include("../inc.config.php");
$idnivel_establecimiento = $_POST["nivel_establecimiento"];
?>
<option value="">Elegir TIPO DE ESTABLECIMIENTO</option>
<?php
$sql2 = " SELECT idtipo_establecimiento, tipo_establecimiento FROM tipo_establecimiento WHERE idnivel_establecimiento='$idnivel_establecimiento' AND indice='SI' ";
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
