<?php include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$latitud_c  = "-17.567775";
$longitud_c = "-66.346216";
$zoom_c     = "7";
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
<h3 class="text-center">VISITAS FAMILIARES A NIVEL NACIONAL</h3>
<div id="mi_mapa" style="width: 100%; height: 900px;"></div>

<script>

        let Visita = L.icon({
        iconUrl: "../sala_situacional/marcadores/familia_verde.png",
        iconSize: [28, 28],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [30, 30],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

    let map = L.map('mi_mapa').setView([<?php echo $latitud_c;?>, <?php echo $longitud_c;?>], <?php echo $zoom_c;?>);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        <?php 
$numero2 = 0;
$sql2 = " SELECT carpeta_familiar.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, establecimiento_salud.latitud, establecimiento_salud.longitud, municipios.municipio ";
$sql2.= " FROM carpeta_familiar, seguimiento_cf, establecimiento_salud, municipios WHERE seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND establecimiento_salud.idmunicipio=municipios.idmunicipio AND";
$sql2.= " carpeta_familiar.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND establecimiento_salud.latitud !='' AND establecimiento_salud.longitud !='' ";
$sql2.= " GROUP BY carpeta_familiar.idestablecimiento_salud ORDER BY carpeta_familiar.idestablecimiento_salud  ";
$result2 = mysqli_query($link,$sql2);
 if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {

?>

        L.marker([<?php echo $row2[2];?>, <?php echo $row2[3];?>], {icon : Visita}).addTo(map).bindPopup("<?php echo '<p>Visitas del Establecimiento : '.$row2[1].'</p><p>Municipio : '.$row2[4].'</p><p><a href=../seguimiento_familiar/reporte_riesgos_est_nal.php?idestablecimiento_salud='.$row2[0].' onClick=window.open(this.href, this.target, width=1000,height=650,scrollbars=YES,top=50,left=300); return false;>MAPA DE VISITAS FAMILIARES</a></p> ';?>")


<?php 
$numero2++;
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