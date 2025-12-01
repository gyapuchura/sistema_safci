<?php include('../cabf.php');?>
<?php include("../inc.config.php");
$gestion = date("Y");

$idmunicipio = $_GET['idmunicipio'];
$idtipo_discapacidad_cf = $_GET['idtipo_discapacidad_cf'];
$idnivel_discapacidad_cf = $_GET['idnivel_discapacidad_cf'];

$sql_dis = " SELECT  idtipo_discapacidad_cf, tipo_discapacidad_cf FROM tipo_discapacidad_cf WHERE idtipo_discapacidad_cf='$idtipo_discapacidad_cf' ";
$result_dis = mysqli_query($link,$sql_dis);
$row_dis = mysqli_fetch_array($result_dis);
$discapacidad = $row_dis[1];

$sql_niv = " SELECT  idnivel_discapacidad_cf, nivel_discapacidad_cf FROM nivel_discapacidad_cf WHERE idnivel_discapacidad_cf='$idnivel_discapacidad_cf' ";
$result_niv = mysqli_query($link,$sql_niv);
$row_niv = mysqli_fetch_array($result_niv);
$nivel = $row_niv[1];

$sql_cord = " SELECT idcarpeta_familiar, latitud, longitud FROM ubicacion_cf WHERE idmunicipio='$idmunicipio' ORDER BY idcarpeta_familiar DESC LIMIT 1  ";
$result_cord = mysqli_query($link,$sql_cord);
$row_cord = mysqli_fetch_array($result_cord);

$sql_mun = " SELECT establecimiento_salud.idmunicipio, municipios.municipio, establecimiento_salud.latitud, establecimiento_salud.longitud FROM establecimiento_salud, municipios ";
$sql_mun.= " WHERE establecimiento_salud.idmunicipio=municipios.idmunicipio  AND establecimiento_salud.idmunicipio='$idmunicipio' ORDER BY establecimiento_salud.idmunicipio DESC LIMIT 1 ";
$result_mun = mysqli_query($link,$sql_mun);
$row_mun = mysqli_fetch_array($result_mun);

$latitud_c  = $row_cord[1];
$longitud_c = $row_cord[2];
$zoom_c     = "16";
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DISCAPACIDAD MUNICIPIO</title>
  
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

<h2><?php echo $discapacidad;?> <?php echo $nivel;?> -  MUNICIPIO : <?php echo mb_strtoupper($row_mun[1]);?></h2>

</br></br>
<div id="safci"></div>

<script type="text/javascript" src="../js/municipios.js"></script>

<script>
var area_influencia ={"type":"FeatureCollection","features":[

        <?php
        /****** Areas de influencia del Establecimiento de salud *********/
        $numero5 = 1;
        $sql5 = " SELECT integrante_cf.idintegrante_cf, nombre.nombre, nombre.paterno, nombre.materno, integrante_cf.edad, ubicacion_cf.latitud, ubicacion_cf.longitud, ubicacion_cf.avenida_calle , ubicacion_cf.no_puerta  ";
        $sql5.= " FROM integrante_cf, nombre, integrante_discapacidad, carpeta_familiar, ubicacion_cf WHERE integrante_discapacidad.idintegrante_cf=integrante_cf.idintegrante_cf  ";
        $sql5.= " AND integrante_cf.idnombre=nombre.idnombre AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
        $sql5.= " AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.idmunicipio='$idmunicipio' ";
        $sql5.= " AND integrante_discapacidad.idtipo_discapacidad_cf='$idtipo_discapacidad_cf' AND integrante_discapacidad.idnivel_discapacidad_cf='$idnivel_discapacidad_cf' ";
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
                 "DISCAPACIDAD_R":"<?php echo $discapacidad;?> - <?php echo $nivel;?>",
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
        var marker = L.marker([<?php echo $row_mun[2];?>, <?php echo $row_mun[3];?>], { draggable: true }).bindPopup('<?php echo "Municipio : ".$row_mun[1];?>');
        var lg_markers = L.layerGroup([marker]);

          var map = L.map('safci', {
            center: [<?php echo $row_mun[2];?>, <?php echo $row_mun[3];?>],
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

  // Listener para el movimiento del marcador
  marker.on('dragend', function(event) {
    var position = marker.getLatLng();
    document.getElementById('lat').value = position.lat.toFixed(6); // Mostrar latitud
    document.getElementById('lng').value = position.lng.toFixed(6); // Mostrar longitud
  });



  // Crear el grupo de cluster
var markers = L.markerClusterGroup();

        var Icono = L.icon({
        iconUrl: "../sala_situacional/marcadores/marcador_celeste_b.png",
        iconSize: [35, 35],
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

        var Vecinal = L.icon({
        iconUrl: "../sala_situacional/marcadores/marcador_rojo_bl.png",
        iconSize: [25, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Puesto_salud = L.icon({
        iconUrl: "../sala_situacional/marcadores/marcador_amarillo.png",
        iconSize: [45, 45],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Ambulatorio = L.icon({
        iconUrl: "../sala_situacional/marcadores/marcador_violeta.png",
        iconSize: [30, 30],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Internacion = L.icon({
        iconUrl: "../sala_situacional/marcadores/marcador_verde.png",
        iconSize: [25, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Integral = L.icon({
        iconUrl: "../sala_situacional/marcadores/marcador_azul.png",
        iconSize: [45, 40],
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
        '<p><b>Discapacidad : </b> ' + feature.properties.DISCAPACIDAD_R + '</p>' +
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

<?php
            /****** Areas de influencia del Establecimiento de salud *********/
            $numero4 = 0;
            $sql4 = " SELECT carpeta_familiar.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, nivel_establecimiento.nivel_establecimiento, tipo_establecimiento.tipo_establecimiento, ";
            $sql4.= " establecimiento_salud.latitud, establecimiento_salud.longitud, establecimiento_salud.idtipo_establecimiento FROM carpeta_familiar, establecimiento_salud, nivel_establecimiento, tipo_establecimiento  ";
            $sql4.= " WHERE carpeta_familiar.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND  establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento ";
            $sql4.= " AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento  AND establecimiento_salud.latitud !='' ";
            $sql4.= " AND establecimiento_salud.longitud !='' AND carpeta_familiar.idmunicipio = '$idmunicipio' GROUP BY carpeta_familiar.idestablecimiento_salud  ";;
            $result4 = mysqli_query($link,$sql4);
            $total4 = mysqli_num_rows($result4);
            if ($row4 = mysqli_fetch_array($result4)){
            mysqli_field_seek($result4,0);
            while ($field4 = mysqli_fetch_field($result4)){
            } do {
                ?>
        L.marker([<?php echo $row4[4];?>, <?php echo $row4[5];?>], {icon:
          <?php   
    switch ($row4[6]) {
        case 1:
            echo "Establecim";
            break;
        case 2:
            echo "Establecim";
            break;
        case 3:
            echo "Ambulatorio";
            break;
        case 4:
            echo "Internacion";
            break;
        case 5:
            echo "Integral";
            break;
        case 6:
            echo "Establecim";
            break;
        case 7:
            echo "Establecim";
            break;
        case 8:
            echo "Establecim";
            break;
        case 9:
            echo "Establecim";
            break;
        case 10:
            echo "Vecinal";
            break;
        case 11:
            echo "Hospital_gen";
            break;
        case 12:
            echo "Hospital_seg";
            break;
        case 13:
            echo "Establecim";
            break;
        case 14:
            echo "Establecim";
            break;
        case 15:
            echo "Establecim";
            break;
        case 16:
            echo "Establecim";
            break;
        case 17:
            echo "Establecim";
            break;
        case 18:
            echo "Puesto_salud";
            break;
        case 19:
            echo "Establecim";
            break;
        case 20:
            echo "Establecim";
            break;
    }  ?> 
        }).addTo(map).bindPopup("<?php echo '<p>Establecimiento: '.$row4[1].'</p><p>'.$row4[2].'<p></p>Tipo:'.$row4[3].'</p>';?>")
            <?php 
            $numero4++;
            } while ($row4 = mysqli_fetch_array($result4));
            } else {
            }
            ?>

</script>

</body>
</html>