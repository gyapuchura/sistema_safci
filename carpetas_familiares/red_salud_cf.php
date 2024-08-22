<?php include("../cabf.php");?>
<?php include("../inc.config.php");
$iddepartamento = $_POST["departamento_red"];
?>
<option value="">Elegir Red de Salud</option>
<?php
$numero = 1;
$sql2 = " SELECT ubicacion_cf.idred_salud, red_salud.red_salud FROM ubicacion_cf, red_salud, carpeta_familiar  ";
$sql2.= " WHERE ubicacion_cf.idred_salud=red_salud.idred_salud AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
$sql2.= " AND ubicacion_cf.iddepartamento='$iddepartamento' GROUP BY ubicacion_cf.idred_salud ";
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
