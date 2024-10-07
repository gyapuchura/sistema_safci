
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Leaflet Examples</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1/dist/css/bootstrap.min.css" rel="stylesheet"  crossorigin="anonymous">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
  </head>
  <body>
    
<main>

  <section class="py-5 container">
    <h1 class="fw-light">MAPA SATELITAL</h1>
    <div class="row py-lg-5">
        <style>
            #mapa_g { height: 580px; }
        </style>
        <div id="mapa_g"></div>
    </div>
  </section>

</main>

<footer class="text-muted py-5">
  <div class="container">

    <p class="mb-1"></p>  
  </div>
</footer>

    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
    <script>

        var mapbox_url = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1Ijoiam9ubnltY2N1bGxhZ2giLCJhIjoiY2xsYzdveWh4MGhwcjN0cXV5Z3BwMXA1dCJ9.QoEHzPNq9DtTRrdtXfOdrw';
        var mapbox_attribution = '© Mapbox © OpenStreetMap Contributors';
        var esri_url ='https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
        var esri_attribution = '© Esri © OpenStreetMap Contributors';

        var lyr_satellite = L.tileLayer(esri_url, {id: 'mapa_g', maxZoom: 20, tileSize: 512, zoomOffset: -1, attribution: esri_attribution});
        var lyr_streets   = L.tileLayer(mapbox_url, {id: 'mapa_g', maxZoom: 28, tileSize: 512, zoomOffset: -1, attribution: mapbox_attribution});
        var marker = L.marker([-16.528965, -68.189950], {draggable:'false'}).bindPopup('<b>safci ubicacion ej 1</b>');
        var lg_markers = L.layerGroup([marker]);


        var map = L.map('mapa_g', {
            center: [-16.528965, -68.189950],
            zoom: 18,
            layers: [lyr_satellite, lyr_streets, lg_markers]
        });

        var baseMaps = {
            "CROQUIS": lyr_streets,
            "SATELITAL": lyr_satellite
        };
        var overlayMaps = {
            "Markers": lg_markers,
        };

        L.control.layers(baseMaps, overlayMaps).addTo(map);

    </script>
  </body>
</html>

