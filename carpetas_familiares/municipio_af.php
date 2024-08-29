<?php include("../cabf.php");?>
<?php include("../inc.config.php");
$iddepartamento = $_POST["departamento_af"];
?>
<option value="">Elegir Municipio</option>
<?php
$numero = 1;
$sql2 = " SELECT ubicacion_cf.idmunicipio, municipios.municipio FROM ubicacion_cf, municipios, carpeta_familiar  ";
$sql2.= " WHERE ubicacion_cf.idmunicipio=municipios.idmunicipio AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
$sql2.= " AND ubicacion_cf.iddepartamento='$iddepartamento' GROUP BY ubicacion_cf.idmunicipio ";
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
