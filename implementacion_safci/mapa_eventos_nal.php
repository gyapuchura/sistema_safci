<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$idevento_notificacion = $_GET['idevento_notificacion'];

$sql1 = " SELECT idevento_notificacion, evento_notificacion FROM evento_notificacion WHERE idevento_notificacion = '$idevento_notificacion' ";
$result1 = mysqli_query($link,$sql1);
$row1 = mysqli_fetch_array($result1);

$latitud_c  = "-17.567775";
$longitud_c = "-66.346216";
$zoom_c     = "5.8";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAFCI REPORTE EVENTOS DE NOTIFICACION INMEDIATA NIVEL NACIONAL</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
</head>

<body>

<h2>EVENTO DE NOTIFICACIÓN INMEDIATA : <?php echo $row1[1];?></h2>
<a href="http://"></a>
<div id="mi_mapa" style="width: 100%; height: 500px;"></div>
		<h2 style="text-align: center; font-family: Arial; font-size: 14px; color: #2D56CF;">REGISTRO DE EVENTOS DE NOTIFICACIÓN SOBRE: <?php echo mb_strtoupper($row1[1]);?></h2>

        <table width="700" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
		      <td width="199" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">SEMANA EPIDEMIOLÓGICA</td>
              <td width="199" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">DEPARTAMENTO</td>
              <td width="199" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">MUNICIPIO</td>
              <td width="199" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">ESTABLECIMIENTO</td>
              <td width="199" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° EVENTOS</td>
              <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">PERSONAS ATENDIDAS</td>
		      <td width="101" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">PERSONAS AFECTADAS</td>
		      <td width="121" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">PERSONAS FALLECIDAS</td>
	        </tr>
            <?php
    $numero=1; 
    $sql =" SELECT evento_notificacion.idevento_notificacion, notificacion_ep.semana_ep, evento_notificacion.evento_notificacion, ";
    $sql.=" departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud, registro_evento_notificacion.numero_eventos, ";
    $sql.=" registro_evento_notificacion.personas_atendidas, registro_evento_notificacion.personas_afectadas, registro_evento_notificacion.personas_fallecidas ";
    $sql.=" FROM registro_evento_notificacion, notificacion_ep, evento_notificacion, departamento, municipios, establecimiento_salud ";
    $sql.=" WHERE registro_evento_notificacion.idnotificacion_ep=notificacion_ep.idnotificacion_ep ";
    $sql.=" AND registro_evento_notificacion.idevento_notificacion=evento_notificacion.idevento_notificacion ";
    $sql.=" AND notificacion_ep.iddepartamento=departamento.iddepartamento AND notificacion_ep.idmunicipio=municipios.idmunicipio ";
    $sql.=" AND notificacion_ep.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND registro_evento_notificacion.numero_eventos != '0' AND notificacion_ep.gestion='$gestion' ";
    $sql.=" AND notificacion_ep.estado='CONSOLIDADO' AND registro_evento_notificacion.idevento_notificacion='$idevento_notificacion' ORDER BY notificacion_ep.semana_ep ";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);           
    while ($field = mysqli_fetch_field($result)){
    } do {

    ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero;?></td>
		      <td style="font-size: 12px; font-family: Arial; text-align: center"><?php echo "Semana ".$row[1];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center"><?php echo $row[3];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center"><?php echo $row[4];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center"><?php echo $row[5];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center"><?php echo $row[6];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center"><?php echo $row[7];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center"><?php echo $row[8];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center"><?php echo $row[9];?></td>
	        </tr>
            <?php
        $numero=$numero+1;
        }
        while ($row = mysqli_fetch_array($result));
        } else {
        }
        ?>
	      </tbody>
    </table>
		<p>&nbsp;</p>



<script>
    let map = L.map('mi_mapa').setView([<?php echo $latitud_c;?>,<?php echo $longitud_c;?>], <?php echo $zoom_c;?>);

        let Riada = L.icon({
        iconUrl: "../sala_situacional/marcadores/riada.png",
        iconSize: [25, 25],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Helada = L.icon({
        iconUrl: "../sala_situacional/marcadores/nevada.png",
        iconSize: [25, 25],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Incendio = L.icon({
        iconUrl: "../sala_situacional/marcadores/incendio.png",
        iconSize: [25, 25],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Deslizaniento = L.icon({
        iconUrl: "../sala_situacional/marcadores/sismo.png",
        iconSize: [25, 25],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Inundacion = L.icon({
        iconUrl: "../sala_situacional/marcadores/inundacion.png",
        iconSize: [25, 25],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Otros = L.icon({
        iconUrl: "../sala_situacional/marcadores/desastres.png",
        iconSize: [25, 25],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});


    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        <?php 
        $sql2 = " SELECT notificacion_ep.idestablecimiento_salud, municipios.municipio, establecimiento_salud.establecimiento_salud, establecimiento_salud.latitud, establecimiento_salud.longitud ";
        $sql2.= " FROM registro_evento_notificacion, notificacion_ep, municipios, establecimiento_salud WHERE registro_evento_notificacion.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
        $sql2.= " AND notificacion_ep.idmunicipio=municipios.idmunicipio AND notificacion_ep.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND notificacion_ep.gestion='$gestion' ";
        $sql2.= " AND establecimiento_salud.latitud != '' AND establecimiento_salud.longitud != '' AND registro_evento_notificacion.numero_eventos != '0' ";
        $sql2.= " AND notificacion_ep.estado='CONSOLIDADO' AND registro_evento_notificacion.idevento_notificacion ='$idevento_notificacion' GROUP BY notificacion_ep.idestablecimiento_salud ";
        $result2 = mysqli_query($link,$sql2);
        $total2 = mysqli_num_rows($result2);
        if ($row2 = mysqli_fetch_array($result2)){
        mysqli_field_seek($result2,0);
        while ($field2 = mysqli_fetch_field($result2)){
        } do {

                $sql_ev = " SELECT sum(registro_evento_notificacion.numero_eventos) FROM registro_evento_notificacion, notificacion_ep WHERE registro_evento_notificacion.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
                $sql_ev.= " AND registro_evento_notificacion.idevento_notificacion = '$idevento_notificacion' AND notificacion_ep.idestablecimiento_salud='$row2[0]' AND notificacion_ep.gestion='$gestion' ";
                $result_ev = mysqli_query($link,$sql_ev);    
                $row_ev = mysqli_fetch_array($result_ev);
                $eventos = $row_ev[0];

                $sql_af = " SELECT sum(registro_evento_notificacion.personas_afectadas) FROM registro_evento_notificacion, notificacion_ep WHERE registro_evento_notificacion.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
                $sql_af.= " AND registro_evento_notificacion.idevento_notificacion = '$idevento_notificacion' AND notificacion_ep.idestablecimiento_salud='$row2[0]' AND notificacion_ep.gestion='$gestion' ";
                $result_af = mysqli_query($link,$sql_af);    
                $row_af = mysqli_fetch_array($result_af);
                $afectadas = $row_af[0];

                $sql_at = " SELECT sum(registro_evento_notificacion.personas_atendidas) FROM registro_evento_notificacion, notificacion_ep WHERE registro_evento_notificacion.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
                $sql_at.= " AND registro_evento_notificacion.idevento_notificacion = '$idevento_notificacion' AND notificacion_ep.idestablecimiento_salud='$row2[0]' AND notificacion_ep.gestion='$gestion' ";
                $result_at = mysqli_query($link,$sql_at);    
                $row_at = mysqli_fetch_array($result_at);
                $atendidas = $row_at[0];
            ?>

                L.marker([<?php echo $row2[3];?>,<?php echo $row2[4];?>], {icon:                 
            <?php   
                switch ($idevento_notificacion) {
                    case 1:
                        echo "Riada";
                        break;
                    case 2:
                        echo "Helada";
                        break;
                    case 3:
                        echo "Incendio";
                        break;
                    case 4:
                        echo "Deslizaniento";
                        break;
                    case 5:
                        echo "Inundacion";
                        break;
                    case 6:
                        echo "Otros";
                        break;
            } ?> 
                }).addTo(map).bindPopup("<?php echo '<p>Municipio :'.$row2[1].'</p><p>Establecimiento :'.$row2[2].'</p><p>Número de Eventos : '.$eventos.'</p><p>Personas Afectadas : '.$afectadas.'</p></p><p>Personas Atendidas : '.$atendidas.'</p>';?>")

                <?php 
        } while ($row2 = mysqli_fetch_array($result2));
        } else {
        echo "";
        /*
        Si no se encontraron resultados
        */
        }
        ?>
</script>

</body>

</html>