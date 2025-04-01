<?php include("../cabf.php");?>
<?php include("../inc.config.php");
$idestablecimiento_salud = $_POST["establecimiento_salud"];
?>
<option value="">Elegir Personal Operativo</option>
<?php
$numero3 = 1;
$sql3 = " SELECT personal.idusuario, personal.codigo, nombre.nombre, nombre.paterno, nombre.materno FROM personal, nombre, dato_laboral, establecimiento_salud, usuarios ";
$sql3.= " WHERE personal.idnombre=nombre.idnombre  AND personal.idusuario=usuarios.idusuario AND personal.iddato_laboral=dato_laboral.iddato_laboral  ";
$sql3.= " AND dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND establecimiento_salud.idestablecimiento_salud='$idestablecimiento_salud' ORDER BY personal.idusuario DESC  ";
$result3 = mysqli_query($link,$sql3);
if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
echo "<option value=".$row3[0].">".$numero3.".- ".$row3[2]." ".$row3[3]." ".$row3[4]."</option>";
$numero3 = $numero3+1;
} while ($row3 = mysqli_fetch_array($result3));
} else {
echo "No se encontraron resultados!";
}
?>
