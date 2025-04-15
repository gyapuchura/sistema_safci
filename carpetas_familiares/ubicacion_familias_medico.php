<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$idusuario = $_GET['idusuario'];

$sql_op = " SELECT nombre.nombre, nombre.paterno, nombre.materno FROM nombre, usuarios WHERE usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$idusuario' ";
$result_op = mysqli_query($link,$sql_op);
$row_op = mysqli_fetch_array($result_op);
$operativo = mb_strtoupper($row_op[0]." ".$row_op[1]." ".$row_op[2]);

$sql1 = " SELECT establecimiento_salud.establecimiento_salud, establecimiento_salud.latitud, establecimiento_salud.longitud FROM dato_laboral, establecimiento_salud ";
$sql1.= " WHERE dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND dato_laboral.idusuario='$idusuario' ";
$result1 = mysqli_query($link,$sql1);
$row1 = mysqli_fetch_array($result1);

$latitud_c  = $row1[1];
$longitud_c = $row1[2];
$zoom_c     = "17";

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UBICACION FAMILIAR</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
</head>

<body>

<div class="sala"><h3 class="text-center">UBICACIÓN GEOGRÁFICA DE FAMILIAS DEL MÉDICO OPERATIVO : <?php echo mb_strtoupper($operativo);?></h3></div>  

<div id="mi_mapa" style="width: 100%; height: 800px;"></div>

<script>
    let map = L.map('mi_mapa').setView([<?php echo $latitud_c;?>, <?php echo $longitud_c;?>], <?php echo $zoom_c;?>);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        <?php
/****** Areas de influencia del Establecimiento de salud *********/
$numero4 = 0;
$sql4 = " SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.familia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia,  ";
$sql4.= " ubicacion_cf.avenida_calle, ubicacion_cf.no_puerta, ubicacion_cf.latitud, ubicacion_cf.longitud   ";
$sql4.= " FROM carpeta_familiar, area_influencia, tipo_area_influencia, ubicacion_cf WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND  ";
$sql4.= " ubicacion_cf.idarea_influencia=area_influencia.idarea_influencia AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia ";
$sql4.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idusuario='$idusuario' ";
$result4 = mysqli_query($link,$sql4);
$total4 = mysqli_num_rows($result4);
 if ($row4 = mysqli_fetch_array($result4)){
mysqli_field_seek($result4,0);
while ($field4 = mysqli_fetch_field($result4)){
} do {
	?>

        L.marker([<?php echo $row4[6];?>, <?php echo $row4[7];?>]).addTo(map).bindPopup('<?php echo 'FAMILIA: '.$row4[1].'</br>'.$row4[2].'  '.$row4[3].'</br>Direccion :'.$row4[4].' Nº '.$row4[5];?>')

        <?php 
$numero4++;
} while ($row4 = mysqli_fetch_array($result4));
} else {
}
?>

</script>

</body>
</html>