<?php include("../cabf.php");?>
<?php include("../inc.config.php");
$idestablecimiento_salud = $_POST["establecimiento_salud"];
?>
<option value="">Elegir Personal Operativo</option>
<?php
$numero3 = 1;
$sql3 = " SELECT carpeta_familiar.idusuario, nombre.nombre, nombre.paterno, nombre.materno FROM carpeta_familiar, usuarios, nombre WHERE carpeta_familiar.idusuario=usuarios.idusuario ";
$sql3.= " AND usuarios.idnombre=nombre.idnombre AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' GROUP BY carpeta_familiar.idusuario  ";
$result3 = mysqli_query($link,$sql3);
if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
echo "<option value=".$row3[0].">".$numero3.".- ".$row3[1]." ".$row3[2]." ".$row3[3]."</option>";
$numero3 = $numero3+1;
} while ($row3 = mysqli_fetch_array($result3));
} else {
echo "No se encontraron resultados!";
}
?>
