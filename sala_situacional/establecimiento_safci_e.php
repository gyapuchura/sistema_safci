<?php include("../inc.config.php");
$idmunicipio_e = $_POST["municipio_e"];
?>
<option value="">Elegir Establecimiento</option>
<?php
$numero = 1;
$sqle = " SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud  ";
$sqle.= " WHERE latitud != '' AND longitud != '' AND idmunicipio = '$idmunicipio_e' ORDER BY establecimiento_salud  ";
$resulte = mysqli_query($link,$sqle);
if ($rowe = mysqli_fetch_array($resulte)){
mysqli_field_seek($resulte,0);
while ($fielde = mysqli_fetch_field($resulte)){
} do {
echo "<option value=".$rowe[0].">".$numero.".- Establecimiento : ".$rowe[1]." </option>";
$numero = $numero+1;
} while ($rowe = mysqli_fetch_array($resulte));
} else {
echo "No se encontraron resultados!";
}
?>