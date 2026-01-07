<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$latitud_c  = "-17.567775";
$longitud_c = "-66.346216";
$zoom_c     = "5.8";
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

<h2>ESTABLECIMIENTOS DE SALUD CON IMPLEMENTACIÓN SAFCI - NIVEL NACIONAL</h2>
          
        <div class="depa"></div>
        <div class="col-sm-12" id="safci" style="width: 100%; height: 700px;"></div>

        </br>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td width="50" style="text-align: center"><img src="../sala_situacional/marcadores/marcador_rojo_bl.png" alt="" width="30px" height="30px"/></td>
      <td width="300" style="font-family: Arial; font-size: 12px;">
        <?php
        $sql_est = " SELECT count(idestablecimiento_salud) FROM establecimiento_salud WHERE latitud != '' AND longitud !='' AND idtipo_establecimiento = '10' ";
        $result_est = mysqli_query($link,$sql_est);
        $row_est = mysqli_fetch_array($result_est);
        echo $row_est[0];
        ?>   
      -> CONSULTORIO VECINAL</td>
      <td width="100">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center"><img src="../sala_situacional/marcadores/marcador_amarillo.png" alt="" width="30px" height="30px"/></td>
      <td><span style="font-family: Arial; font-size: 12px;">
    <?php
        $sql_est = " SELECT count(idestablecimiento_salud) FROM establecimiento_salud WHERE latitud != '' AND longitud !='' AND idtipo_establecimiento = '18' ";
        $result_est = mysqli_query($link,$sql_est);
        $row_est = mysqli_fetch_array($result_est);
        echo $row_est[0];
        ?>   
      -> PUESTO DE SALUD</span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center"><img src="../sala_situacional/marcadores/marcador_violeta.png" alt="" width="30px" height="30px"/></td>
      <td><span style="font-family: Arial; font-size: 12px;">
        <?php
        $sql_est = " SELECT count(idestablecimiento_salud) FROM establecimiento_salud WHERE latitud != '' AND longitud !='' AND idtipo_establecimiento = '3' ";
        $result_est = mysqli_query($link,$sql_est);
        $row_est = mysqli_fetch_array($result_est);
        echo $row_est[0];
        ?>   
      -> CENTRO DE SALUD AMBULATORIO</span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center"><img src="../sala_situacional/marcadores/marcador_verde.png" alt="" width="30px" height="30px"/></td>
      <td><span style="font-family: Arial; font-size: 12px;">
        <?php
        $sql_est = " SELECT count(idestablecimiento_salud) FROM establecimiento_salud WHERE latitud != '' AND longitud !='' AND idtipo_establecimiento = '4' ";
        $result_est = mysqli_query($link,$sql_est);
        $row_est = mysqli_fetch_array($result_est);
        echo $row_est[0];
        ?>   
      -> CENTRO DE SALUD CON INTERNACIÓN</span></td>
      <td>&nbsp;</td>
    </tr>
        <tr>
      <td style="text-align: center"><img src="../sala_situacional/marcadores/marcador_azul.png" alt="" width="30px" height="30px"/></td>
      <td><span style="font-family: Arial; font-size: 12px;">
        <?php
        $sql_est = " SELECT count(idestablecimiento_salud) FROM establecimiento_salud WHERE latitud != '' AND longitud !='' AND idtipo_establecimiento = '5' ";
        $result_est = mysqli_query($link,$sql_est);
        $row_est = mysqli_fetch_array($result_est);
        echo $row_est[0];
        ?>   
      ->  CENTRO DE SALUD INTEGRAL</span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center"><img src="../sala_situacional/marcadores/hospital_rojo.png" alt="" width="30px" height="30px"/></td>
      <td><span style="font-family: Arial; font-size: 12px;">
          <?php
        $sql_est = " SELECT count(idestablecimiento_salud) FROM establecimiento_salud WHERE latitud != '' AND longitud !='' AND idtipo_establecimiento = '12' ";
        $result_est = mysqli_query($link,$sql_est);
        $row_est = mysqli_fetch_array($result_est);
        echo $row_est[0];
        ?>   
      -> HOSPITAL DE SEGUNDO NIVEL</span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center"><img src="../sala_situacional/marcadores/eess_blanco_celeste.png" alt="" width="30px" height="30px"/></td>
      <td><span style="font-family: Arial; font-size: 12px;">
            <?php
        $sql_est = " SELECT count(idestablecimiento_salud) FROM establecimiento_salud WHERE latitud != '' AND longitud !='' AND idtipo_establecimiento = '11' ";
        $result_est = mysqli_query($link,$sql_est);
        $row_est = mysqli_fetch_array($result_est);
        echo $row_est[0];
        ?> -> HOSPITAL GENERAL</span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center"><img src="../sala_situacional/marcadores/cruz_roja_blanco.png" alt="" width="30px" height="30px"/></td>
      <td><span style="font-family: Arial; font-size: 12px;">OTRO TIPO DE ESTABLECIMIENTO</span></td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
                
    <script type="text/javascript" src="../js/municipios.js"></script>
    <script type="text/javascript" src="../js/establecimientos.js"></script>

    <script>
/** ubicacion actual de acuerdo a la ubicacion del establecimiento de salud = -16.5113374610014, -68.13400675671315 */
/** ubicacion prueba -16.536361, -68.154571*/

  var map = L.map('safci').setView([<?php echo $latitud_c;?>,<?php echo $longitud_c;?>], <?php echo $zoom_c;?>);

        var Vecinal = L.icon({
        iconUrl: "marcadores/marcador_rojo_bl.png",
        iconSize: [30, 30],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Puesto_salud = L.icon({
        iconUrl: "marcadores/marcador_amarillo.png",
        iconSize: [30, 30],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Ambulatorio = L.icon({
        iconUrl: "marcadores/marcador_violeta.png",
        iconSize: [30, 30],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Internacion = L.icon({
        iconUrl: "marcadores/marcador_verde.png",
        iconSize: [30, 30],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Integral = L.icon({
        iconUrl: "marcadores/marcador_azul.png",
        iconSize: [30, 30],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Hospital_seg = L.icon({
        iconUrl: "marcadores/hospital_rojo.png",
        iconSize: [30, 30],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Hospital_gen = L.icon({
        iconUrl: "marcadores/eess_blanco_celeste.png",
        iconSize: [30, 30],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Establecim = L.icon({
        iconUrl: "marcadores/cruz_roja_blanco.png",
        iconSize: [30, 30],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

  L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'PROGRAMA SAFCI-MI SALUD',
    maxZoom: 18
  }).addTo(map);


   <?php 
$numero2 = 0;
$sql2 = " SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, nivel_establecimiento.nivel_establecimiento, ";
$sql2.= " tipo_establecimiento.tipo_establecimiento, establecimiento_salud.latitud, establecimiento_salud.longitud, establecimiento_salud.idtipo_establecimiento ";
$sql2.= " FROM establecimiento_salud, nivel_establecimiento, tipo_establecimiento WHERE establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento ";
$sql2.= " AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento AND establecimiento_salud.latitud !=''  ";
$sql2.= " AND establecimiento_salud.longitud !='' ORDER BY idestablecimiento_salud ";
$result2 = mysqli_query($link,$sql2);
$total2 = mysqli_num_rows($result2);
 if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
	?>

        L.marker([<?php echo $row2[4];?>,<?php echo $row2[5];?>], {icon:
<?php   
    switch ($row2[6]) {
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
    }
                ?> 
        }).addTo(map).bindPopup("<?php echo '<p>Establecimiento: '.$row2[1].'</p><p>'.$row2[2].'</p><p>Tipo: '.$row2[3].'</p>';?>")

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

