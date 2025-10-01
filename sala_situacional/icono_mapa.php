<?php include("../cabf.php"); ?>
<?php include("../inc.config.php");
$gestion = date("Y");

$idmunicipio = "12";

$sql_cord = "  SELECT area_influencia.idarea_influencia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, area_influencia.latitud, area_influencia.longitud  ";
$sql_cord.= "  FROM area_influencia, tipo_area_influencia, establecimiento_salud WHERE area_influencia.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud  ";
$sql_cord.= "  AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND establecimiento_salud.idmunicipio='$idmunicipio' ORDER BY area_influencia.idarea_influencia DESC LIMIT 1 ";
$result_cord = mysqli_query($link,$sql_cord);
$row_cord = mysqli_fetch_array($result_cord);

$sql_mun = " SELECT idmunicipio, municipio FROM municipios WHERE idmunicipio='$idmunicipio'  ";
$result_mun = mysqli_query($link,$sql_mun);
$row_mun = mysqli_fetch_array($result_mun);

$latitud_c  = $row_cord[3];
$longitud_c = $row_cord[4];
$zoom_c     = "14";
?>
<!DOCTYPE html> 
<html>
   <head>
      <meta charset="UTF-8" >
      <link rel="stylesheet" 
          href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" 
          integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" 
          crossorigin=""/>
      <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" 
          integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" 
          crossorigin="">
      </script> 
      <style> #map { width: 100%; height: 800px; } </style>
   </head>
   <body>
      <h2>MAPA PARLANTE MUNICIPIO <?php echo $row_mun[1];?></h2>
      <div id="map"></div>
      <script> 
    var map = L.map('map',{ 
          center: [<?php echo $latitud_c;?>, <?php echo $longitud_c;?>], 
          zoom: <?php echo $zoom_c;?>, 
          minZoom: 4, 
          maxZoom: 18  }); 
          




          L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {attribution: '© <a href="http://osm.org/copyright">OpenStreetMap</a> contributors' }).addTo(map); 
       </script> 
  <script>    
        var Icono = L.icon({
        iconUrl: "marcadores/comunidad.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Icono2 = L.icon({
        iconUrl: "marcadores/eess_blanco_celeste.png",
        iconSize: [40, 40],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});
        
    <?php

            /****** Areas de influencia del Establecimiento de salud *********/
            $numero4 = 0;
            $sql4 = " SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, ";
            $sql4.= " nivel_establecimiento.nivel_establecimiento, tipo_establecimiento.tipo_establecimiento, establecimiento_salud.latitud, establecimiento_salud.longitud ";
            $sql4.= " FROM establecimiento_salud, nivel_establecimiento, tipo_establecimiento WHERE establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento ";
            $sql4.= " AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento AND establecimiento_salud.latitud !=''  ";
            $sql4.= " AND establecimiento_salud.longitud !='' AND establecimiento_salud.idmunicipio = '$idmunicipio' ORDER BY establecimiento_salud.idestablecimiento_salud ";
            $result4 = mysqli_query($link,$sql4);
            $total4 = mysqli_num_rows($result4);
            if ($row4 = mysqli_fetch_array($result4)){
            mysqli_field_seek($result4,0);
            while ($field4 = mysqli_fetch_field($result4)){
            } do {
                ?>

                var establecimiento = L.marker([<?php echo $row4[4];?>, <?php echo $row4[5];?>], {
                    title: "<?php echo 'Establecimiento: '.$row4[1].' - '.$row4[2].'</br>Tipo:'.$row4[3];?>", 
                    draggable:false,
                    icon: Icono2
                        }).bindPopup("<?php echo 'Establecimiento: '.$row4[1].' - '.$row4[2].'</br>Tipo:'.$row4[3];?>")
                        .addTo(map);

            <?php 
            $numero4++;
            } while ($row4 = mysqli_fetch_array($result4));
            } else {
            }



            /****** Areas de influencia del Establecimiento de salud *********/
            $numero5 = 0;
            $sql5 = "  SELECT area_influencia.idarea_influencia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, area_influencia.latitud, area_influencia.longitud  ";
            $sql5.= "  FROM area_influencia, tipo_area_influencia, establecimiento_salud WHERE area_influencia.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud  ";
            $sql5.= "  AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND establecimiento_salud.idmunicipio='$idmunicipio' ";
            $result5 = mysqli_query($link,$sql5);
            $total5 = mysqli_num_rows($result5);
            if ($row5 = mysqli_fetch_array($result5)){
            mysqli_field_seek($result5,0);
            while ($field5 = mysqli_fetch_field($result5)){
            } do {
                ?>

                var areainfluencia = L.marker([<?php echo $row5[3];?>, <?php echo $row5[4];?>], {
                    title: "<?php echo $row5[1].' : '.$row5[2];?>", 
                    draggable:false, 
                    opacity: 1,
                    icon: Icono
                        }).bindPopup("<?php echo $row5[1].' : '.$row5[2];?>")
                        .addTo(map);

            <?php 
            $numero5++;
            } while ($row5 = mysqli_fetch_array($result5));
            } else {
            }
            ?>


    </script>
   </body>
</html>