<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa software libre</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />

    <style>
        #mi_mapa { height: 580px; }
    </style>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

    
</head>
 
<body>

<div id="mi_mapa"></div>

    <script>

        var mapbox_url = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1Ijoiam9ubnltY2N1bGxhZ2giLCJhIjoiY2xsYzdveWh4MGhwcjN0cXV5Z3BwMXA1dCJ9.QoEHzPNq9DtTRrdtXfOdrw';
        var mapbox_attribution = '© Mapbox © OpenStreetMap Contributors';
        var esri_url ='https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
        var esri_attribution = '© Esri © OpenStreetMap Contributors';

        var lyr_satellite = L.tileLayer(esri_url, {id: 'mi_mapa', maxZoom: 20, tileSize: 512, zoomOffset: -1, attribution: esri_attribution});
        var lyr_streets   = L.tileLayer(mapbox_url, {id: 'mi_mapa', maxZoom: 20, tileSize: 512, zoomOffset: -1, attribution: mapbox_attribution});
        var marker = L.marker([-16.528965, -68.189950], {draggable:'false'}).bindPopup('<b>safci ubicacion ej 1</b>');
        var lg_markers = L.layerGroup([marker]);

            var map = L.map('mi_mapa', {
            center: [-16.528965, -68.189950],
            zoom: 18,
            layers: [lyr_satellite, lyr_streets, lg_markers]
        });

        var baseMaps = {
            "CROQUIS": lyr_streets,
            "SATELITAL": lyr_satellite
        };
        var overlayMaps = {
            "Marcador": lg_markers,
        };

        L.control.layers(baseMaps, overlayMaps).addTo(map);

        

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright"></a> contributors'
        }).addTo(map);

    </script>

</body>

</html>