<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php

date_default_timezone_set('America/La_Paz');
$fecha 		  = date("Y-m-d");

$idusuario_ss  = $_SESSION['idusuario_ss'];
$idnombre_ss   = $_SESSION['idnombre_ss'];
$perfil_ss     = $_SESSION['perfil_ss'];

$gestion       = date("Y");

/****** actualizamos los datos personales *******/

$numero=1;
$sql =" SELECT iddato_laboral, idusuario, idnombre, iddependencia, entidad, cargo_entidad, idministerio, iddireccion, idarea, cargo_mds, ";
$sql.=" iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud, item_mds, item_red_salud, idcargo_organigrama  ";
$sql.=" FROM dato_laboral WHERE idcargo_organigrama='19'  ";
$result = mysqli_query($link,$sql);
if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {

    echo $numero.".- ".$row[2]." - ".$row[3]." - ".$row[16]." - ".$row[13]."</br>";

$sql3 = " UPDATE usuarios SET perfil='ADM-MUNICIPAL' WHERE idusuario='$row[1]' ";
$result3 = mysqli_query($link,$sql3);

$numero=$numero+1;
}
while ($row = mysqli_fetch_array($result));
} else {
}
?>