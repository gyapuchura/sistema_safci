<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$idsospecha_diag = $_GET['idsospecha_diag'];

$sql1 = " SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idsospecha_diag = '$idsospecha_diag' ";
$result1 = mysqli_query($link,$sql1);
$row1 = mysqli_fetch_array($result1);

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
    <title>SAFCI REPORTE EPIDEMIOLOGICO SEMANAL NIVEL NACIONAL</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
</head>

<body>

<h2>VIGILANCIA EPIDEMIOLÓGICA : <?php echo $row1[1];?></h2>
<a href="http://"></a>
<div id="mi_mapa" style="width: 100%; height: 800px;"></div>

<script>
    let map = L.map('mi_mapa').setView([<?php echo $latitud_c;?>,<?php echo $longitud_c;?>], <?php echo $zoom_c;?>);

        let Icono_ep = L.icon({
        iconUrl: "../sala_situacional/marcadores/sospecha_ep.png",
        iconSize: [25, 25],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});


    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        <?php 
        $sql2 = " SELECT notificacion_ep.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, establecimiento_salud.latitud, establecimiento_salud.longitud, municipios.municipio ";
        $sql2.= " FROM registro_enfermedad, notificacion_ep, establecimiento_salud, municipios WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep ";
        $sql2.= " AND notificacion_ep.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND notificacion_ep.idmunicipio=municipios.idmunicipio AND notificacion_ep.gestion='$gestion' ";
        $sql2.= " AND registro_enfermedad.gestion = '$gestion' AND establecimiento_salud.latitud != '' AND establecimiento_salud.longitud !='' AND registro_enfermedad.cifra !='0' ";
        $sql2.= " AND registro_enfermedad.idsospecha_diag='$idsospecha_diag' GROUP BY notificacion_ep.idestablecimiento_salud  ";
        $result2 = mysqli_query($link,$sql2);
        $total2 = mysqli_num_rows($result2);
        if ($row2 = mysqli_fetch_array($result2)){
        mysqli_field_seek($result2,0);
        while ($field2 = mysqli_fetch_field($result2)){
        } do {

                $sql_ca = " SELECT sum(registro_enfermedad.cifra) FROM registro_enfermedad, notificacion_ep WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
                $sql_ca.= " AND registro_enfermedad.idsospecha_diag = '$idsospecha_diag' AND notificacion_ep.idestablecimiento_salud='$row2[0]' AND notificacion_ep.gestion='$gestion' ";
                $result_ca = mysqli_query($link,$sql_ca);    
                $row_ca = mysqli_fetch_array($result_ca);
                $casos = $row_ca[0];

            ?>

                L.marker([<?php echo $row2[2];?>,<?php echo $row2[3];?>], {icon: Icono_ep }).addTo(map).bindPopup("<?php echo '<p>Establecimiento:'.$row2[1].'</p><p>Municipio:'.$row2[4].'</p><p>Casos: '.$casos.'</p><p><a href=../implementacion_safci/marco_ep_establecimiento_sala_mapa.php?idsospecha_diag_estab='.$idsospecha_diag.'&idestablecimiento_salud='.$row2[0].'  onClick=window.open(this.href, this.target, width=1000,height=650,scrollbars=YES,top=50,left=300); return false;>VIGILANCIA DEL ESTABLECIMIENTO</a></p>';?>")

                <?php 
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