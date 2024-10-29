<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$idmunicipio = $_GET['idmunicipio'];

$sql1 = " SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.latitud, establecimiento_salud.longitud, ";
$sql1.= " municipios.municipio FROM establecimiento_salud, municipios WHERE establecimiento_salud.idmunicipio=municipios.idmunicipio ";
$sql1.= " AND establecimiento_salud.latitud != '' AND establecimiento_salud.longitud != '' AND establecimiento_salud.idmunicipio='$idmunicipio' LIMIT 1 ";
$result1 = mysqli_query($link,$sql1);
$row1 = mysqli_fetch_array($result1);

$latitud_c  = $row1[1];
$longitud_c = $row1[2];
$zoom_c     = "12";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESTABLECIMIENTOS EN EL MUNICIPIO</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
</head>

<body>

<h2>MUNICIPIO DE <a href="../sala_situacional/detalle_establecimientos_e.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="text-info" onClick="window.open(this.href, this.target, 'width=700,height=400,scrollbars=YES,top=70,left=400'); return false;"><?php echo mb_strtoupper($row1[3]);?></a> </h2>

<div id="mi_mapa" style="width: 100%; height: 900px;"></div>

<script>
    let map = L.map('mi_mapa').setView([<?php echo $row1[1];?>, <?php echo $row1[2];?>], 12);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        <?php 
$numero2 = 0;
$sql2 = " SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, ";
$sql2.= " nivel_establecimiento.nivel_establecimiento, tipo_establecimiento.tipo_establecimiento, establecimiento_salud.latitud, establecimiento_salud.longitud ";
$sql2.= " FROM establecimiento_salud, nivel_establecimiento, tipo_establecimiento WHERE establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento ";
$sql2.= " AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento AND establecimiento_salud.latitud !=''  ";
$sql2.= " AND establecimiento_salud.longitud !='' AND establecimiento_salud.idmunicipio = '$idmunicipio' ORDER BY idestablecimiento_salud ";
$result2 = mysqli_query($link,$sql2);
$total2 = mysqli_num_rows($result2);
 if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
	?>
        L.marker([<?php echo $row2[4];?>, <?php echo $row2[5];?>]).addTo(map).bindPopup("<?php echo 'Establecimiento: '.$row2[1].' - '.$row2[2].'</br>Tipo:'.$row2[3];?>")

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