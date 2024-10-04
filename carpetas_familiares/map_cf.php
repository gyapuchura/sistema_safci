<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  
  <style>
  #safci {
      width: 900px;
      height: 700px;
      box-shadow: 5px 5px 5px #888;
  }
  </style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>
<body>
  <div id="safci"></div>         
  
    <script type="text/javascript" src="../js/municipios.js"></script>
    <script type="text/javascript" src="establecimientos.js"></script>
  <script>
  var map = L.map('safci').
     setView([-16.5113374610014, -68.13400675671315],
     6);

   L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
   attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>',
   maxZoom: 18
   }).addTo(map);
  

   function getColor(d) {
    return  d == 'Beni' ?'#E37CA8' :
            d == 'Chuquisaca' ?'#FD8D3C' : 
            d == 'Cochabamba' ?'#FC4E2A' :
            d == 'La Paz' ?'#E3E17C' : 
            d == 'Oruro' ?'#BD0026' :
            d == 'Pando' ?'#7CE3A8' : 
            d == 'Potosí' ?'#00A65A' :  
            d == 'Santa Cruz' ?'#7C7FE3' :
            d == 'Tarija' ?'#800026' :
              '#FFEDA0'; 
          }
   function style(features) { 
    return { 
        fillColor: getColor(features.properties.DEPARTAMEN), 
        weight: 1, 
        opacity: 1, 
        color: 'black', 
        dashArray: '2', 
        fillOpacity: 0.6 
        }; 
        }
        function popup(features, layer) { 
          {layer.bindPopup('<h3> Municipio:'+features.properties.MUNICIPIO+'</h3><h4> Departamento: '+features.properties.DEPARTAMEN+'</h4>');}}
    
        L.geoJson(municipios,{style:style, onEachFeature:popup}).addTo(map);
     
   L.control.scale().addTo(map); 
   L.marker([-16.5113374610014, -68.13400675671315],{draggable: true}).addTo(map);

  

    </script>
</body>
</html>
