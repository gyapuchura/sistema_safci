<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$idevento_notificacion = '1';

$idmunicipio = $_GET['idmunicipio'];

$sql_mun = " SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.latitud, establecimiento_salud.longitud, ";
$sql_mun.= " municipios.municipio FROM establecimiento_salud, municipios WHERE establecimiento_salud.idmunicipio=municipios.idmunicipio ";
$sql_mun.= " AND establecimiento_salud.latitud != '' AND establecimiento_salud.longitud != '' AND establecimiento_salud.idmunicipio='$idmunicipio' LIMIT 1 ";
$result_mun = mysqli_query($link,$sql_mun);
$row_mun = mysqli_fetch_array($result_mun);

$latitud_c  = $row_mun[1];
$longitud_c = $row_mun[2];
$zoom_c     = "12";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAFCI REPORTE EVENTOS DE NOTIFICACION INMEDIATA NIVEL MUNICIPAL</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
</head>

<body>

<h2>EVENTOS DE NOTIFICACIÓN INMEDIATA - Municipio : <?php echo $row_mun[3];?></h2>
<a href="http://"></a>
<div id="mi_mapa" style="width: 100%; height: 700px;"></div>
		

<script>
    let map = L.map('mi_mapa').setView([<?php echo $latitud_c;?>,<?php echo $longitud_c;?>], <?php echo $zoom_c;?>);

        let Riada = L.icon({
        iconUrl: "../sala_situacional/marcadores/riada.png",
        iconSize: [25, 25],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Helada = L.icon({
        iconUrl: "../sala_situacional/marcadores/nevada.png",
        iconSize: [25, 25],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Incendio = L.icon({
        iconUrl: "../sala_situacional/marcadores/incendio.png",
        iconSize: [25, 25],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Deslizaniento = L.icon({
        iconUrl: "../sala_situacional/marcadores/sismo.png",
        iconSize: [25, 25],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Inundacion = L.icon({
        iconUrl: "../sala_situacional/marcadores/inundacion.png",
        iconSize: [25, 25],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Otros = L.icon({
        iconUrl: "../sala_situacional/marcadores/desastres.png",
        iconSize: [25, 25],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>PROGRAMA SAFCI-MI SALUD'
        }).addTo(map);

        <?php 
        $sql2 = " SELECT notificacion_ep.idestablecimiento_salud, municipios.municipio, establecimiento_salud.establecimiento_salud, establecimiento_salud.latitud, establecimiento_salud.longitud, registro_evento_notificacion.idevento_notificacion ";
        $sql2.= " FROM registro_evento_notificacion, notificacion_ep, municipios, establecimiento_salud WHERE registro_evento_notificacion.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
        $sql2.= " AND notificacion_ep.idmunicipio=municipios.idmunicipio AND notificacion_ep.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND notificacion_ep.gestion='$gestion' ";
        $sql2.= " AND establecimiento_salud.latitud != '' AND establecimiento_salud.longitud != '' AND registro_evento_notificacion.numero_eventos != '0' ";
        $sql2.= " AND notificacion_ep.estado='CONSOLIDADO' AND notificacion_ep.idmunicipio='$idmunicipio' GROUP BY notificacion_ep.idestablecimiento_salud ";
        $result2 = mysqli_query($link,$sql2);
        $total2 = mysqli_num_rows($result2);
        if ($row2 = mysqli_fetch_array($result2)){
        mysqli_field_seek($result2,0);
        while ($field2 = mysqli_fetch_field($result2)){
        } do {
       
            $sql5 = " SELECT registro_evento_notificacion.idevento_notificacion, evento_notificacion.evento_notificacion FROM registro_evento_notificacion, notificacion_ep, evento_notificacion ";
            $sql5.= " WHERE registro_evento_notificacion.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND registro_evento_notificacion.idevento_notificacion=evento_notificacion.idevento_notificacion ";
            $sql5.= " AND registro_evento_notificacion.numero_eventos !='0' AND notificacion_ep.gestion ='$gestion' AND notificacion_ep.idestablecimiento_salud = '$row2[0]' GROUP BY registro_evento_notificacion.idevento_notificacion ";
            $result5 = mysqli_query($link,$sql5);
            $total5 = mysqli_num_rows($result5);
            if ($row5 = mysqli_fetch_array($result5)){
            mysqli_field_seek($result5,0);
            while ($field5 = mysqli_fetch_field($result5)){
            } do {

                $sql_ev = " SELECT sum(registro_evento_notificacion.numero_eventos) FROM registro_evento_notificacion, notificacion_ep WHERE registro_evento_notificacion.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
                $sql_ev.= " AND registro_evento_notificacion.idevento_notificacion = '$row5[0]' AND notificacion_ep.idestablecimiento_salud='$row2[0]' AND notificacion_ep.gestion='$gestion' ";
                $result_ev = mysqli_query($link,$sql_ev);    
                $row_ev = mysqli_fetch_array($result_ev);
                $eventos = $row_ev[0];

                $sql_af = " SELECT sum(registro_evento_notificacion.personas_afectadas) FROM registro_evento_notificacion, notificacion_ep WHERE registro_evento_notificacion.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
                $sql_af.= " AND registro_evento_notificacion.idevento_notificacion = '$row5[0]' AND notificacion_ep.idestablecimiento_salud='$row2[0]' AND notificacion_ep.gestion='$gestion' ";
                $result_af = mysqli_query($link,$sql_af);    
                $row_af = mysqli_fetch_array($result_af);
                $afectadas = $row_af[0];

                $sql_at = " SELECT sum(registro_evento_notificacion.personas_atendidas) FROM registro_evento_notificacion, notificacion_ep WHERE registro_evento_notificacion.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
                $sql_at.= " AND registro_evento_notificacion.idevento_notificacion = '$row5[0]' AND notificacion_ep.idestablecimiento_salud='$row2[0]' AND notificacion_ep.gestion='$gestion' ";
                $result_at = mysqli_query($link,$sql_at);    
                $row_at = mysqli_fetch_array($result_at);
                $atendidas = $row_at[0];
            ?>
                L.marker([<?php echo $row2[3];?>,<?php echo $row2[4];?>], {icon: 
                     <?php   
                switch ($row5[0]) {
                    case 1:
                        echo "Riada";
                        break;
                    case 2:
                        echo "Helada";
                        break;
                    case 3:
                        echo "Incendio";
                        break;
                    case 4:
                        echo "Deslizaniento";
                        break;
                    case 5:
                        echo "Inundacion";
                        break;
                    case 6:
                        echo "Otros";
                        break;
            } ?> 
                 }).addTo(map).bindPopup("<?php echo '<p>Evento : '.$row5[1].'</p><p>Municipio :'.mb_strtoupper($row2[1]).'</p><p>Establecimiento :'.$row2[2].'</p><p>Número de Eventos : '.$eventos.'</p><p>Personas Afectadas : '.$afectadas.'</p></p><p>Personas Atendidas : '.$atendidas.'</p>';?>")

                <?php 

            } while ($row5 = mysqli_fetch_array($result5));
            } else {
            }

        } while ($row2 = mysqli_fetch_array($result2));
        } else {
        }
        ?>
</script>

</body>

</html>