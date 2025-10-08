<?php include('../cabf.php');?>
<?php include("../inc.config.php");
$gestion = date("Y");

$idestablecimiento_salud = $_GET['idestablecimiento_salud'];

$sql_cord = " SELECT idcarpeta_familiar, latitud, longitud FROM ubicacion_cf WHERE idestablecimiento_salud='$idestablecimiento_salud' ORDER BY idcarpeta_familiar DESC LIMIT 1  ";
$result_cord = mysqli_query($link,$sql_cord);
$row_cord = mysqli_fetch_array($result_cord);

$sql_est = " SELECT idestablecimiento_salud, establecimiento_salud, latitud, longitud FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud' ";
$result_est = mysqli_query($link,$sql_est);
$row_est = mysqli_fetch_array($result_est);

$latitud_c  = $row_cord[1];
$longitud_c = $row_cord[2];
$zoom_c     = "16";
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FAMILIAS - ESTABLECIMIENTO</title>
  
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

<h2>MAPA DE UBICACIÓN DE LAS FAMILIAS - ESTABLECIMIENTO : <?php echo mb_strtoupper($row_est[1]);?></h2>

<div id="safci"></div>

<script type="text/javascript" src="../js/municipios.js"></script>

<script>
var area_influencia ={"type":"FeatureCollection","features":[

        <?php
        /****** Areas de influencia del Establecimiento de salud *********/
        $numero5 = 1;
        $sql5 = " SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.familia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, ";
        $sql5.= " ubicacion_cf.avenida_calle, ubicacion_cf.no_puerta, ubicacion_cf.latitud, ubicacion_cf.longitud ";
        $sql5.= " FROM carpeta_familiar, area_influencia, tipo_area_influencia, ubicacion_cf WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ";
        $sql5.= " carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia ";
        $sql5.= " AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.ubicacion_actual='SI' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ORDER BY carpeta_familiar.idcarpeta_familiar DESC  ";
        $result5 = mysqli_query($link,$sql5);
        $total5 = mysqli_num_rows($result5);
        if ($row5 = mysqli_fetch_array($result5)){
        mysqli_field_seek($result5,0);
        while ($field5 = mysqli_fetch_field($result5)){
        } do {
            ?>

    {"type":"Feature",
      "id":"<?php echo 'familia.'.$numero5;?>",
      "geometry":{"type":"Point",
                  "coordinates":[<?php echo $row5[7];?>,<?php echo $row5[6];?>]},
      "geometry_name":"the_geom",
      "properties":{"fid":<?php echo $numero5;?>,
                 "gml_id":"<?php echo 'familia.'.$numero5;?>",
                 "ID":<?php echo $row5[0];?>,
                 "TIPO":"4",
                 "FAMILY":"<?php echo $row5[1];?>",
                 "UBICACION":"<?php echo $row5[2];?> <?php echo $row5[3];?>",
                 "LAT":<?php echo $row5[6];?>,
                 "LONG":<?php echo $row5[7];?>,
                 "CALLE":"<?php echo $row5[4];?> <?php echo 'Nº '.$row5[5];?>"}},
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




  var map = L.map('safci').setView([<?php echo $latitud_c;?>,<?php echo $longitud_c;?>], <?php echo $zoom_c;?>);

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



  // Crear el grupo de cluster
var markers = L.markerClusterGroup();

        var Icono = L.icon({
        iconUrl: "../sala_situacional/marcadores/familia_verde.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Icono2 = L.icon({
        iconUrl: "../sala_situacional/marcadores/eess_blanco_celeste.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

// Cargar el archivo GeoJSON desde establecimientos.js (se asume que ya está cargado)
L.geoJson(area_influencia, {
  pointToLayer: function(feature, latlng) {
    // Crea un marcador por cada punto
    return L.marker(latlng, { icon:Icono });
  },
  onEachFeature: function(feature, layer) {
    // Agregar un popup con la información del establecimiento
    if (feature.properties) {
      layer.bindPopup(
        '<h3>Familia : ' + feature.properties.FAMILY + '</h3>' +
        '<p><b>Ubicación : </b> ' + feature.properties.UBICACION + '</p>' +
        '<p><b>Coordenadas : </b> ' + feature.geometry.coordinates[1] + ', ' + feature.geometry.coordinates[0] + '</p>' +
        '<p><b>Avenida/Calle/Carretera/camino : </b> ' + feature.properties.CALLE + '</p>'
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


L.marker([<?php echo $row_est[2];?>, <?php echo $row_est[3];?>], {icon: Icono2}).addTo(map).bindPopup('<?php echo 'Establecimeinto : '.$row_est[1];?>')
</script>

</body>
</html>
