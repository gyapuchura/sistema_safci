<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa software libre</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
</head>

<body>

<div id="mi_mapa" style="width: 100%; height: 600px;"></div>

<script>
    let map = L.map('mi_mapa').setView([-16.528965, -68.189950], 14);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([-16.508886, -68.135533]).addTo(map).bindPopup("Localización SAFCI 1")
        L.marker([-16.528965, -68.189950]).addTo(map).bindPopup("Localización SAFCI 2")
        L.marker([-16.513742, -68.153279]).addTo(map).bindPopup("Localización SAFCI 3")

</script>

</body>
</html>