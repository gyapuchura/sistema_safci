<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
$gestion = date("Y");

$fecha_i = $_POST['fecha_i'];
$fecha_f = $_POST['fecha_f'];

$numero = 0;
$sql =" SELECT carpeta_familiar.idcarpeta_familiar, departamento.sigla, carpeta_familiar.correlativo, carpeta_familiar.codigo, carpeta_familiar.fecha_registro FROM carpeta_familiar, ubicacion_cf, departamento  ";
$sql.=" WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.iddepartamento=departamento.iddepartamento ";
$sql.=" AND carpeta_familiar.fecha_registro BETWEEN '$fecha_i' AND '$fecha_f' ";    
$result = mysqli_query($link,$sql);
if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {

    if ($row[0] != $row[2]) {

        $codigo="SAFCI/".$row[1]."-CF-".$row[0]."/".$gestion;

        $sql0 = " UPDATE carpeta_familiar SET codigo='$codigo', correlativo='$row[0]' WHERE idcarpeta_familiar = '$row[0]' ";
        $result0 = mysqli_query($link,$sql0);  

            echo $row[0].".-".$row[3]." - ".$row[2]." - ".$row[4]."</br>";

        $numero = $numero+1;

    } else { }
}
while ($row = mysqli_fetch_array($result));
} else {
}

echo "</br></br>Son ".$numero." carpetas con codigo que fue corregido !!!";

?>
