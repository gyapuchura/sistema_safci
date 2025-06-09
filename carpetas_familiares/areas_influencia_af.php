<?php include("../cabf.php");?>
<?php include("../inc.config.php");

$idestablecimiento = $_POST["establecimiento_af"];
?>
<option value="">Elegir Área de Influencia</option>
<?php
$numero3 = 1;
$sql3 = " SELECT carpeta_familiar.idarea_influencia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia ";
$sql3.= " FROM area_influencia, tipo_area_influencia, carpeta_familiar WHERE carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia ";
$sql3.= " AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento' ";
$sql3.= " AND carpeta_familiar.estado='CONSOLIDADO' GROUP BY carpeta_familiar.idarea_influencia ";
$result3 = mysqli_query($link,$sql3);
if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
echo "<option value=".$row3[0].">".$numero3.".- ".$row3[1]." ".$row3[2]." </option>";
$numero3 = $numero3+1;
} while ($row3 = mysqli_fetch_array($result3));
} else {
echo "No se encontraron resultados!";
}
?>
