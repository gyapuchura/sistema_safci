<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

</head>

<body>

<div id="mi_mapa" style="width: 100%; height: 600px;"></div>

<script>

    let map = L.map('mi_mapa').setView([19.432747, -99.133179], 15)

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([19.4327, -99.1331]).addTo(map).bindPopup("Zócalo de la Ciudad de México")
        L.marker([19.4349, -99.1313]).addTo(map).bindPopup("Templo Mayor")


        var lyr_satellite = L.tileLayer(esri_url, {id: 'mi_mapa', maxZoom: 20, tileSize: 512, zoomOffset: -1, attribution: esri_attribution});
          var lyr_streets   = L.tileLayer(mapbox_url, {id: 'mapbox/streets-v11', maxZoom: 28, tileSize: 512, zoomOffset: -1, attribution: mapbox_attribution});
          ...
          var map = L.map('map', {
            center: [54.17747885048963, -6.337641477584839],
            zoom: 18,
            layers: [lyr_satellite, lyr_streets, lg_markers]
          });

          var baseMaps = {
              "Streets": lyr_streets,
              "Satellite": lyr_satellite
          };
          var overlayMaps = {
              "Markers": lg_markers,
          };

          L.control.layers(baseMaps, overlayMaps).addTo(map);


</script>

</body>

</html>