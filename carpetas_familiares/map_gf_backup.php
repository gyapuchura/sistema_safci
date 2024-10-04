<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  
  <style>
    #safci {
      width: 860px;
      height: 500px;
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
  </style>
  
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>
<body>

<div class="filtro">

  <select class="nivel">
    <option selected>NIVEL</option>
    <option value="Local">Local</option>
    <option value="Municipal">Municipal</option>
    <option value="Departamental">Departamental</option>
    <option value="Nacional">Nacional</option>
  </select>

  <select class="depa">
    <option selected>DEPARTAMENTO</option>
    <option value="La Paz">La Paz</option>
    <option value="Oruro">Oruro</option>
    <option value="Potosí">Potosí</option>
    <option value="Cochabamba">Cochabamba</option>
    <option value="Chuquisaca">Chuquisaca</option>
    <option value="Tarija">Tarija</option>
    <option value="Pando">Pando</option>
    <option value="Beni">Beni</option>
    <option value="Santa Cruz">Santa Cruz</option>
  </select>

  <select class="Mun">
    <option selected>MUNICIPIO</option>
  </select>

  <select class="Est">
    <option selected>ESTABLECIMIENTO</option>
    <option value="La Paz">La Paz</option>
    <option value="Oruro">Oruro</option>
    <option value="Potosí">Potosí</option>
    <option value="Cochabamba">Cochabamba</option>
    <option value="Chuquisaca">Chuquisaca</option>
    <option value="Tarija">Tarija</option>
    <option value="Pando">Pando</option>
    <option value="Beni">Beni</option>
    <option value="Santa Cruz">Santa Cruz</option>
  </select>

  <select class="MEDICO">
    <option selected>MEDICO</option>
    <option value="La Paz">La Paz</option>
    <option value="Oruro">Oruro</option>
    <option value="Potosí">Potosí</option>
    <option value="Cochabamba">Cochabamba</option>
    <option value="Chuquisaca">Chuquisaca</option>
    <option value="Tarija">Tarija</option>
    <option value="Pando">Pando</option>
    <option value="Beni">Beni</option>
    <option value="Santa Cruz">Santa Cruz</option>
  </select>

  <input type="number" class="form-control" id="lat" placeholder="LATITUD" title="Latitud" readonly>
  <input type="number" class="form-control" id="lng" placeholder="LONGITUD" title="Longitud" readonly>

</div>

<div id="safci"></div>

<script type="text/javascript" src="../js/municipios.js"></script>
<script type="text/javascript" src="../js/establecimientos.js"></script>

<script>
/** ubicacion actual de acuerdo a la ubicacion del establecimiento de salud = -16.5113374610014, -68.13400675671315 */
/** ubicacion prueba -16.536361, -68.154571*/

  var map = L.map('safci').setView([-16.536361, -68.154571], 15);

  L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: ' ',
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
  var marker = L.marker([-16.536361, -68.154571], { draggable: true }).addTo(map);

  // Listener para el movimiento del marcador
  marker.on('dragend', function(event) {
    var position = marker.getLatLng();
    document.getElementById('lat').value = position.lat.toFixed(6); // Mostrar latitud
    document.getElementById('lng').value = position.lng.toFixed(6); // Mostrar longitud
  });
</script>
</body>
</html>
