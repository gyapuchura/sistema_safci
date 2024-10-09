<?php include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$latitud_c  = "-17.567775";
$longitud_c = "-66.346216";
$zoom_c     = "5.8";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRESENCIA PROGRAMA SAFCI - NIVEL NACIONAL</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
</head>

<body>
<h3 class="text-center">PRESENCIA DEL PROGRAMA SAFCI MI SALUD A NIVEL NACIONAL</h3>
<div id="mi_mapa" style="width: 100%; height: 900px;"></div>

<script>
    let map = L.map('mi_mapa').setView([<?php echo $latitud_c;?>, <?php echo $longitud_c;?>], <?php echo $zoom_c;?>);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        <?php 
$numero2 = 0;
$sql2 = " SELECT establecimiento_salud.idmunicipio, municipios.municipio FROM establecimiento_salud, municipios  ";
$sql2.= " WHERE establecimiento_salud.idmunicipio=municipios.idmunicipio AND establecimiento_salud.latitud != '' ";
$sql2.= " AND establecimiento_salud.longitud != '' GROUP BY establecimiento_salud.idmunicipio ";
$result2 = mysqli_query($link,$sql2);
$total2 = mysqli_num_rows($result2);
 if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {

$sql3 = " SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.latitud, establecimiento_salud.longitud,  ";
$sql3.= " municipios.municipio, departamento.departamento FROM establecimiento_salud, municipios, departamento ";
$sql3.= " WHERE establecimiento_salud.idmunicipio=municipios.idmunicipio AND establecimiento_salud.iddepartamento=departamento.iddepartamento ";
$sql3.= " AND establecimiento_salud.latitud != '' AND establecimiento_salud.longitud != '' AND establecimiento_salud.idmunicipio='$row2[0]' LIMIT 1 ";
$result3 = mysqli_query($link,$sql3);
$row3 = mysqli_fetch_array($result3);
?>

        L.marker([<?php echo $row3[1];?>, <?php echo $row3[2];?>]).addTo(map).bindPopup("<?php echo 'Municipio: '.$row2[1];?>")

<?php 
$numero2++;
if ($numero2 == $total2) {
echo "";
}
else {
echo ",";
}
} while ($row2 = mysqli_fetch_array($result2));
} else {
echo "";
/*
Si no se encontraron resultados
*/
}
?>

</script>

</body>

</html>