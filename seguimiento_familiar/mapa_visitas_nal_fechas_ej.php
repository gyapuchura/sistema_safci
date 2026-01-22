<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram   = date("Ymd");
$fecha 	     = date("Y-m-d");
$gestion     = date("Y");

$inicio = $_GET['inicio'];
$finalizacion = $_GET['finalizacion'];

$fecha_i = explode('-',$inicio);
$f_inicio = $fecha_i[2].'/'.$fecha_i[1].'/'.$fecha_i[0];

$fecha_f = explode('-',$finalizacion);
$f_finalizacion = $fecha_f[2].'/'.$fecha_f[1].'/'.$fecha_f[0];

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$latitud_c  = "-17.567775";
$longitud_c = "-66.346216";
$zoom_c     = "7";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">

    <title>SISTEMA MEDI-SAFCI</title>

    <style>
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


<h3 class="text-center">VISITAS EJECUTADAS A NIVEL NACIONAL DEL <?php echo $f_inicio;?> AL <?php echo $f_finalizacion;?></h3>
        <div class="depa"></div>
        <div class="col-sm-12" id="safci" style="width: 100%; height: 800px;"></div>

        </br>
                
    <script type="text/javascript" src="../js/municipios.js"></script>
    <script type="text/javascript" src="../js/establecimientos.js"></script>

    <script>
/** ubicacion actual de acuerdo a la ubicacion del establecimiento de salud = -16.5113374610014, -68.13400675671315 */
/** ubicacion prueba -16.536361, -68.154571*/

  var map = L.map('safci').setView([<?php echo $latitud_c;?>,<?php echo $longitud_c;?>], <?php echo $zoom_c;?>);

        var Vecinal = L.icon({
        iconUrl: "../sala_situacional/marcadores//marcador_rojo_bl.png",
        iconSize: [27, 27],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores//icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]}); 

        var Puesto_salud = L.icon({
        iconUrl: "../sala_situacional/marcadores//marcador_amarillo.png",
        iconSize: [27, 27],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores//icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Ambulatorio = L.icon({
        iconUrl: "../sala_situacional/marcadores//marcador_violeta.png",
        iconSize: [27, 27],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores//icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Internacion = L.icon({
        iconUrl: "../sala_situacional/marcadores//marcador_verde.png",
        iconSize: [27, 27],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores//icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Integral = L.icon({
        iconUrl: "../sala_situacional/marcadores//marcador_azul.png",
        iconSize: [27, 27],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores//icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Hospital_seg = L.icon({
        iconUrl: "../sala_situacional/marcadores//hospital_rojo.png",
        iconSize: [27, 27],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores//icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Hospital_gen = L.icon({
        iconUrl: "../sala_situacional/marcadores//eess_blanco_celeste.png",
        iconSize: [27, 27],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores//icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Establecim = L.icon({
        iconUrl: "../sala_situacional/marcadores//cruz_roja_blanco.png",
        iconSize: [27, 27],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores//icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Visita = L.icon({
        iconUrl: "../sala_situacional/marcadores/familia_visitas.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [30, 30],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

  L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: ' ',
    maxZoom: 18
  }).addTo(map);


   <?php 
$numero2 = 0;
$sql2 = " SELECT carpeta_familiar.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, nivel_establecimiento.nivel_establecimiento,  ";
$sql2.= " tipo_establecimiento.tipo_establecimiento, establecimiento_salud.latitud, establecimiento_salud.longitud, establecimiento_salud.idtipo_establecimiento, municipios.municipio ";
$sql2.= " FROM carpeta_familiar, seguimiento_cf, visita_cf, establecimiento_salud, nivel_establecimiento, tipo_establecimiento, municipios ";
$sql2.= " WHERE establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento AND establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento ";
$sql2.= " AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND establecimiento_salud.idmunicipio=municipios.idmunicipio AND visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf ";
$sql2.= " AND carpeta_familiar.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND establecimiento_salud.latitud !='' AND establecimiento_salud.longitud !=''  ";
$sql2.= " AND visita_cf.fecha_visita BETWEEN '$inicio' AND '$finalizacion' GROUP BY carpeta_familiar.idestablecimiento_salud ORDER BY carpeta_familiar.idestablecimiento_salud  ";
$result2 = mysqli_query($link,$sql2);
$total2 = mysqli_num_rows($result2);
 if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
	?>

        L.marker([<?php echo $row2[4];?>,<?php echo $row2[5];?>], {icon: Visita}).addTo(map).bindPopup("<?php echo '<p>Ejecucion de Visitas </p><p>Registradas del '.$f_inicio.' al '.$f_finalizacion.'</p><p>Establecimiento : '.$row2[1].'</p><p>Municipio : '.$row2[7].'</p><p><a href=../seguimiento_familiar/reporte_riesgos_est_nal.php?idestablecimiento_salud='.$row2[0].' onClick=window.open(this.href, this.target, width=1000,height=650,scrollbars=YES,top=50,left=300); return false;>MAPA DE VISITAS FAMILIARES</a></p> ';?>")

        <?php 
$numero2++;
if ($numero2 == $total2) {
echo "";
}
else {
echo ",";
}
} while ($row2 = mysqli_fetch_array($result2));
} else {
echo "";
/*
Si no se encontraron resultados
*/
}
?>

  
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


</script>


    <!-- scripts para calendario -->
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
</body>

</html>

