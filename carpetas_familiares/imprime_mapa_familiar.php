<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		  = date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");

$idcarpeta_familiar_ss = $_GET['idcarpeta_familiar']; 

$sql_cf = " SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.familia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia,  ";
$sql_cf.= " ubicacion_cf.avenida_calle, ubicacion_cf.no_puerta, ubicacion_cf.latitud, ubicacion_cf.longitud   ";
$sql_cf.= " FROM carpeta_familiar, area_influencia, tipo_area_influencia, ubicacion_cf WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND  ";
$sql_cf.= " carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia ";
$sql_cf.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idcarpeta_familiar='$idcarpeta_familiar_ss' AND ubicacion_cf.ubicacion_actual='SI' ";
$result_cf = mysqli_query($link,$sql_cf);
$row_cf = mysqli_fetch_array($result_cf);
        
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

<h2>UBICACIÓN DOMICILIO DE LA FAMILIA: <?php echo $row_cf[1];?></h2>

<div id="mi_mapa" style="width: 100%; height: 600px;"></div>

<script>
    let map = L.map('mi_mapa').setView([<?php echo $row_cf[6];?>,<?php echo $row_cf[7];?>], 15);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([<?php echo $row_cf[6];?>,<?php echo $row_cf[7];?>]).addTo(map).bindPopup("<?php echo 'FAMILIA: '.$row_cf[1].'</br>'.$row_cf[2].'  '.$row_cf[3].'</br>Direccion :'.$row_cf[4].' Nº '.$row_cf[5];?>")

</script>

</body>
</html>