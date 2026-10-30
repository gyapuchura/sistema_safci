<?php include('../cabf.php');?>
<?php include("../inc.config.php");
$gestion = date("Y");

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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FAMILIAS - MUNICIPIO</title>
  
  <style>
    #safci {
      width: 100%;
      height: 800px;
      box-shadow: 5px 5px 5px #888;
    }
    .filtro {
      display: flex;
      flex-direction: row;
      justify-content: flex-start;
      align-items: center;
      margin-bottom: 10px;
    }
    select {
      margin-right: 10px;
    }
    #location {
      margin-top: 10px;
    }
    .icon-container {
  background-color: white;
  border: 1px solid black;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
}
.custom-icon {
  font-size: 24px;
}
  </style>
  
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
  <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

</head>
<body>

<div class="filtro">
  <div class="nivel"></div>

  <div class="depa"></div>


</div>

<h2>MAPA DE UBICACIÓN DE LAS FAMILIAS - <?php echo mb_strtoupper('Municipio : '.$row1[3]);?></h2>

<div id="safci"></div>

<script type="text/javascript" src="../js/municipios.js"></script>

<script>


var familia ={"type":"FeatureCollection","features":[

        <?php
        /****** Areas de influencia del Establecimiento de salud *********/
        $numero5 = 1;
        $sql5 = " SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.familia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia,  ";
        $sql5.= "  ubicacion_cf.avenida_calle, ubicacion_cf.no_puerta, ubicacion_cf.latitud, ubicacion_cf.longitud, evaluacion_familiar_cf.evaluacion_familiar ";
        $sql5.= "  FROM evaluacion_familiar_cf, carpeta_familiar, area_influencia, tipo_area_influencia, ubicacion_cf WHERE  evaluacion_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
        $sql5.= "  AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND  carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia ";
        $sql5.= "  AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.ubicacion_actual='SI' ";
        $sql5.= "  AND carpeta_familiar.idmunicipio='$idmunicipio' AND evaluacion_familiar_cf.evaluacion_familiar='FAMILIA CON RIESGO MEDIANO' ORDER BY carpeta_familiar.idcarpeta_familiar DESC ";
        $result5 = mysqli_query($link,$sql5);
        $total5 = mysqli_num_rows($result5);
        if ($row5 = mysqli_fetch_array($result5)){
        mysqli_field_seek($result5,0);
        while ($field5 = mysqli_fetch_field($result5)){
        } do {

                $sql_r = " SELECT idevaluacion_familiar_cf, evaluacion_familiar FROM evaluacion_familiar_cf WHERE idcarpeta_familiar='$row5[0]' ";
                $sql_r.= " ORDER BY idevaluacion_familiar_cf DESC LIMIT 1  ";
                $result_r = mysqli_query($link,$sql_r);
                $row_r = mysqli_fetch_array($result_r);
                $riesgo_cf = $row_r[1];

                $famnilia_name = json_encode($row5[1]);

                $calle_familia=json_encode($row5[4].' Nro. '.$row5[5]);

            ?>

    {"type":"Feature",
      "id":"<?php echo 'familia.'.$numero5;?>",
      "geometry":{"type":"Point",
                  "coordinates":[<?php echo $row5[7];?>,<?php echo $row5[6];?>]},
      "geometry_name":"the_geom",
      "properties":{"fid":<?php echo $numero5;?>,
                 "gml_id":<?php echo json_encode('familia.'.$numero5);?>,
                 "ID":<?php echo $row5[0];?>,
                 "TIPO":"4",
                 "FAMILY":<?php echo json_encode($row5[1]);?>,
                 "UBICACION":"<?php echo $row5[2];?> <?php echo $row5[3];?>",
                 "LAT":<?php echo $row5[6];?>,
                 "LONG":<?php echo $row5[7];?>,
                 "CALLE":<?php echo json_encode($row5[4].' Nro. '.$row5[5]);?>,
                 "RIESGO_CF":"<?php echo $row5[8];?>"

                }},
        <?php 
        $numero5++;
        } while ($row5 = mysqli_fetch_array($result5));
        } else {
        }
        ?>  

          ],
        "totalFeatures":2810,
        "numberMatched":2810,
        "numberReturned":2810,
        "timeStamp":"2024-03-15T14:34:27.724Z",
        "crs":{"type":"name",
               "properties":{"name":"urn:ogc:def:crs:EPSG::4326"}}}

        var mapbox_url = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1Ijoiam9ubnltY2N1bGxhZ2giLCJhIjoiY2xsYzdveWh4MGhwcjN0cXV5Z3BwMXA1dCJ9.QoEHzPNq9DtTRrdtXfOdrw';
        var mapbox_attribution = '© Mapbox © OpenStreetMap Contributors';
        var esri_url ='https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
        var esri_attribution = '© Esri © OpenStreetMap Contributors';
                 
        var lyr_streets   = L.tileLayer(mapbox_url, {id: 'safci', maxZoom:18, tileSize: 512, zoomOffset: -1, attribution: mapbox_attribution});
        var lyr_satellite = L.tileLayer(esri_url, {id: 'safci', maxZoom: 18, tileSize: 512, zoomOffset: -1, attribution: esri_attribution});
        var marker = L.marker([<?php echo $row1[1];?>, <?php echo $row1[2];?>]).bindPopup('<?php echo 'Municipio : '.$row1[3];?>');
        var lg_markers = L.layerGroup([marker]);

          var map = L.map('safci', {
            center: [<?php echo $row1[1];?>, <?php echo $row1[2];?>],
            zoom: <?php echo $zoom_c;?>,
            layers: [lyr_streets, lyr_satellite,  lg_markers]
        });  

          var baseMaps = {
            "MAPA": lyr_streets,
            "SATÉLITE": lyr_satellite
        };
          var overlayMaps = {
            "Marcador": lg_markers,
        };

        L.control.layers(baseMaps, overlayMaps).addTo(map);

  L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>',
    maxZoom: 18
  }).addTo(map);
  
  var datosGjson; // Asegúrate de cargar correctamente tus datos GeoJSON

  function Filtrarnivel(DEPARTAMEN) {
    return datosGjson.features.filter(function(feature) {
      return feature.properties.DEPARTAMEN === DEPARTAMEN;
    });
  }

  document.getElementsByClassName('depa')[0].addEventListener('change', function() {
    var depsel = this.value;
    var municipiosel = Filtrarnivel(depsel);
    var selectmun = document.getElementsByClassName('Mun')[0];
    selectmun.innerHTML = ''; // Limpiar opciones actuales

    municipiosel.forEach(function(munis) {
      var option = document.createElement('option');
      option.value = munis.properties.MUNICIPIO;
      option.textContent = munis.properties.MUNICIPIO; // Agregar texto de visualización
      selectmun.appendChild(option);
    });
  });

  function getColor(d) {
    return  d === 'Beni' ? '#E37CA8' :
            d === 'Chuquisaca' ? '#FD8D3C' : 
            d === 'Cochabamba' ? '#FC4E2A' :
            d === 'La Paz' ? '#E3E17C' : 
            d === 'Oruro' ? '#BD0026' :
            d === 'Pando' ? '#7CE3A8' : 
            d === 'Potosí' ? '#00A65A' :  
            d === 'Santa Cruz' ? '#7C7FE3' :
            d === 'Tarija' ? '#800026' :
            '#FFEDA0'; 
  }

  function style(feature) { 
    return { 
      fillColor: getColor(feature.properties.DEPARTAMEN), 
      weight: 1, 
      opacity: 1, 
      color: 'black', 
      dashArray: '2', 
      fillOpacity: 0.1 
    }; 
  }

  function popup(feature, layer) { 
    layer.bindPopup('<h3> Municipio: ' + feature.properties.MUNICIPIO + '</h3><h4> Departamento: ' + feature.properties.DEPARTAMEN + '</h4>');
  }
  
  L.geoJson(municipios, { style: style, onEachFeature: popup }).addTo(map);
  L.control.scale().addTo(map); 

  // Crear un marcador
  var marker = L.marker([<?php echo $latitud_c;?>,<?php echo $longitud_c;?>], { draggable: true }).addTo(map);

  // Listener para el movimiento del marcador
  marker.on('dragend', function(event) {
    var position = marker.getLatLng();
    document.getElementById('lat').value = position.lat.toFixed(6); // Mostrar latitud
    document.getElementById('lng').value = position.lng.toFixed(6); // Mostrar longitud
  });

        var Icono_v = L.icon({
        iconUrl: "../sala_situacional/marcadores/casa_verde.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Icono_a = L.icon({
        iconUrl: "../sala_situacional/marcadores/casa_amarilla.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Icono_r = L.icon({
        iconUrl: "../sala_situacional/marcadores/casa_roja.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Vecinal = L.icon({
        iconUrl: "../sala_situacional/marcadores/marcador_rojo_bl.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Puesto_salud = L.icon({
        iconUrl: "../sala_situacional/marcadores/marcador_amarillo.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Ambulatorio = L.icon({
        iconUrl: "../sala_situacional/marcadores/marcador_violeta.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Internacion = L.icon({
        iconUrl: "../sala_situacional/marcadores/marcador_verde.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Integral = L.icon({
        iconUrl: "../sala_situacional/marcadores/marcador_azul.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Hospital_seg = L.icon({
        iconUrl: "../sala_situacional/marcadores/hospital_rojo.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Hospital_gen = L.icon({
        iconUrl: "../sala_situacional/marcadores/eess_blanco_celeste.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Establecim = L.icon({
        iconUrl: "../sala_situacional/marcadores/cruz_roja_blanco.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

  // Crear el grupo de cluster
var markers = L.markerClusterGroup();


// Cargar el archivo GeoJSON desde establecimientos.js (se asume que ya está cargado)
L.geoJson(familia, {
  pointToLayer: function(feature, latlng) {
    // Crea un marcador por cada punto
    return L.marker(latlng, { icon: Icono_a });
  },
  onEachFeature: function(feature, layer) {
    // Agregar un popup con la información del establecimiento
    if (feature.properties) {
      layer.bindPopup(
        '<h3>Familia : ' + feature.properties.FAMILY + '</h3>' +
        '<p><b>Ubicación : </b> ' + feature.properties.UBICACION + '</p>' +
        '<p><b>Coordenadas : </b> ' + feature.geometry.coordinates[1] + ', ' + feature.geometry.coordinates[0] + '</p>' +
        '<p><b>Avenida/Calle/Carretera/camino : </b> ' + feature.properties.CALLE + '</p>' +
        '<p><b>Riésgo : </b> ' + feature.properties.RIESGO_CF + '</p>' 

      );
    }
  }
}).eachLayer(function(layer) {
  // Agregar cada capa al grupo de marcadores
  markers.addLayer(layer);
});

// Agregar el grupo de cluster al mapa
map.addLayer(markers);

// Datos de todos los areas de influencia 

            <?php
            /****** Areas de influencia del Establecimiento de salud *********/
            $numero4 = 0;
            $sql4 = " SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.familia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia,  ";
            $sql4.= "  ubicacion_cf.avenida_calle, ubicacion_cf.no_puerta, ubicacion_cf.latitud, ubicacion_cf.longitud, evaluacion_familiar_cf.evaluacion_familiar ";
            $sql4.= "  FROM evaluacion_familiar_cf, carpeta_familiar, area_influencia, tipo_area_influencia, ubicacion_cf WHERE  evaluacion_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
            $sql4.= "  AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND  carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia ";
            $sql4.= "  AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.ubicacion_actual='SI' ";
            $sql4.= "  AND carpeta_familiar.idmunicipio='$idmunicipio' AND evaluacion_familiar_cf.evaluacion_familiar !='FAMILIA CON RIESGO MEDIANO' ORDER BY carpeta_familiar.idcarpeta_familiar DESC   ";
            $result4 = mysqli_query($link,$sql4);
            $total4 = mysqli_num_rows($result4);
            if ($row4 = mysqli_fetch_array($result4)){
            mysqli_field_seek($result4,0);
            while ($field4 = mysqli_fetch_field($result4)){
            } do {
           
    
            $popup_familia = json_encode('<p>FAMILIA: '.$row4[1].'</p><p>'.$row4[2].' '.$row4[3].'</p><p>Direccion :'.$row4[4].' Nº '.$row4[5].'</p><p>'.$row4[8].'</p>');
?>

        L.marker([<?php echo $row4[6];?>, <?php echo $row4[7];?>], 
        {icon:
        <?php if ($row4[8] == 'FAMILIA CON RIESGO BAJO') {echo "Icono_v"; } else { if ($row4[8] == 'FAMILIA CON RIESGO MEDIANO') {echo "Icono_a";} else {if ($row4[8] == 'FAMILIA CON RIESGO ALTO') {echo "Icono_r";} else { } } } ?>
        }).addTo(map).bindPopup(<?php echo $popup_familia;?>)

            <?php 
            $numero4++;
            } while ($row4 = mysqli_fetch_array($result4));
            } else {
            }
            ?>
  

</script>

</body>
</html>