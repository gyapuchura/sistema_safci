<?php include("../cabf.php");?>
<?php include("../inc.config.php");
$idcat_registro = $_POST["cat_registro"];
?>
<option value="">Elegir</option>
<?php

$sql2 = " SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idcat_registro='$idcat_registro' ORDER BY idsospecha_diag";
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