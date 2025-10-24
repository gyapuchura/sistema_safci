<?php include('../cabf.php');?>
<?php include("../inc.config.php");
$gestion = date("Y");

$idestablecimiento_salud = $_GET['idestablecimiento_salud'];
$idmorbilidad_cf = $_GET['idmorbilidad_cf'];

$sql_mor = " SELECT  idmorbilidad_cf, morbilidad_cf FROM morbilidad_cf WHERE idmorbilidad_cf='$idmorbilidad_cf' ";
$result_mor = mysqli_query($link,$sql_mor);
$row_mor = mysqli_fetch_array($result_mor);
$morbilidad = $row_mor[1];

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
  <title>MORBILIDAD ESTABLECIMIENTO</title>
  
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

<h2><?php echo $morbilidad;?> - ESTABLECIMIENTO : <?php echo mb_strtoupper($row_est[1]);?></h2>

<a href="detalle_morbilidad_integrantes_est.php?idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>&idmorbilidad_cf=<?php echo $idmorbilidad_cf;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=700,height=800,scrollbars=YES,top=60,left=700'); return false;">             
LISTADO DE INTEGRANTES</a>
</br></br>
<div id="safci"></div>

<script type="text/javascript" src="../js/municipios.js"></script>

<script>
var area_influencia ={"type":"FeatureCollection","features":[

        <?php
        /****** Areas de influencia del Establecimiento de salud *********/
        $numero5 = 1;
        $sql5 = " SELECT integrante_cf.idintegrante_cf, nombre.nombre, nombre.paterno, nombre.materno, integrante_cf.edad, ubicacion_cf.latitud, ubicacion_cf.longitud,  ";
        $sql5.= " ubicacion_cf.avenida_calle , ubicacion_cf.no_puerta FROM integrante_cf, nombre, integrante_morbilidad, carpeta_familiar, ubicacion_cf ";
        $sql5.= " WHERE integrante_morbilidad.idintegrante_cf=integrante_cf.idintegrante_cf AND integrante_cf.idnombre=nombre.idnombre  ";
        $sql5.= " AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
        $sql5.= " AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND integrante_morbilidad.idmorbilidad_cf='$idmorbilidad_cf' ";
        $result5 = mysqli_query($link,$sql5);
        $total5 = mysqli_num_rows($result5);
        if ($row5 = mysqli_fetch_array($result5)){
        mysqli_field_seek($result5,0);
        while ($field5 = mysqli_fetch_field($result5)){
        } do {
            ?>

    {"type":"Feature",
      "id":"<?php echo 'Integrante.'.$numero5;?>",
      "geometry":{"type":"Point",
                  "coordinates":[<?php echo $row5[6];?>,<?php echo $row5[5];?>]},
      "geometry_name":"the_geom",
      "properties":{"fid":<?php echo $numero5;?>,
                 "gml_id":"<?php echo 'Integrante.'.$numero5;?>",
                 "ID":<?php echo $row5[0];?>,
                 "TIPO":"4",
                 "INTEGRANTE":"<?php echo $row5[1].' '.$row5[2].' '.$row5[3];?>",
                 "EDAD":"<?php echo $row5[4];?>",
                 "MORBILIDAD_R":"<?php echo $morbilidad;?>",
                 "LAT":<?php echo $row5[5];?>,
                 "LONG":<?php echo $row5[6];?>,
                 "CALLE":"<?php echo $row5[7];?> <?php echo 'Nº '.$row5[8];?>"}},
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
        var marker = L.marker([<?php echo $row_est[2];?>, <?php echo $row_est[3];?>]).bindPopup('<?php echo "Establecimiento : ".$row_est[1];?>');
        var lg_markers = L.layerGroup([marker]);

          var map = L.map('safci', {
            center: [<?php echo $row_est[2];?>, <?php echo $row_est[3];?>],
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



  // Crear el grupo de cluster
var markers = L.markerClusterGroup();

        var Icono = L.icon({
        iconUrl: "../sala_situacional/marcadores/marcador_rojo_b.png",
        iconSize: [25, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Icono2 = L.icon({
        iconUrl: "../sala_situacional/marcadores/hospital_rojo.png",
        iconSize: [40, 40],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

// Cargar el archivo GeoJSON desde (base de datos) establecimientos.js (se asume que ya está cargado)
L.geoJson(area_influencia, {
  pointToLayer: function(feature, latlng) {
    // Crea un marcador por cada punto
    return L.marker(latlng, { icon:Icono });
  },
  onEachFeature: function(feature, layer) {
    // Agregar un popup con la información del integrante de la familia
    if (feature.properties) {
      layer.bindPopup(
        '<h3>Integrante : ' + feature.properties.INTEGRANTE + '</h3>' +
        '<p><b>Edad : </b> ' + feature.properties.EDAD + ' años </p>' +
        '<p><b>Morbilidad : </b> ' + feature.properties.MORBILIDAD_R + '</p>' +
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