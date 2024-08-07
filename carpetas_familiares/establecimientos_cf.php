<?php include("../cabf.php");?>
<?php include("../inc.config.php");
$idmunicipio = $_POST["municipio_salud"];
?>
<option value="">Elegir Establecimiento de Salud</option>
<?php
$numero3 = 1;
$sql3 = " SELECT ubicacion_cf.idestablecimiento_salud, establecimiento_salud.establecimiento_salud FROM ubicacion_cf, establecimiento_salud, carpeta_familiar ";
$sql3.= " WHERE ubicacion_cf.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
$sql3.= " AND ubicacion_cf.idmunicipio='$idmunicipio' GROUP BY ubicacion_cf.idestablecimiento_salud ORDER BY establecimiento_salud.establecimiento_salud ";
$result3 = mysqli_query($link,$sql3);
if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
echo "<option value=".$row3[0].">".$numero3.".- ".$row3[1]." </option>";
$numero3 = $numero3+1;
} while ($row3 = mysqli_fetch_array($result3));
} else {
echo "No se encontraron resultados!";
}
?>
