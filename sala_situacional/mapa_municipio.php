<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$idmunicipio = $_GET['idmunicipio_salud'];

$sql1 = " SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.latitud, establecimiento_salud.longitud, ";
$sql1.= " municipios.municipio FROM establecimiento_salud, municipios WHERE establecimiento_salud.idmunicipio=municipios.idmunicipio ";
$sql1.= " AND establecimiento_salud.latitud != '' AND establecimiento_salud.longitud != '' AND establecimiento_salud.idmunicipio='$idmunicipio' LIMIT 1 ";
$result1 = mysqli_query($link,$sql1);
$row1 = mysqli_fetch_array($result1);

$latitud_c  = $row1[1];
$longitud_c = $row1[2];
$zoom_c     = "12";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESTABLECIMIENTOS SAFCI MUNICIPAL</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
</head>

<body>

<h2>ESTABLECIMIENTOS DE SALUD CON IMPLEMENTACIÓN SAFCI - MUNICIPIO DE <a href="detalle_establecimientos_e.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="text-info" onClick="window.open(this.href, this.target, 'width=700,height=400,scrollbars=YES,top=70,left=400'); return false;"><?php echo mb_strtoupper($row1[3]);?></a> </h2>
<div id="mi_mapa" style="width: 100%; height: 700px;"></div>

</br>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td width="50" style="text-align: center"><img src="marcadores/marcador_rojo_bl.png" alt="" width="30px" height="30px"/></td>
      <td width="500" style="font-family: Arial; font-size: 12px;">CONSULTORIO VECINAL</td>
      <td width="50">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center"><img src="marcadores/marcador_amarillo.png" alt="" width="30px" height="30px"/></td>
      <td><span style="font-family: Arial; font-size: 12px;">PUESTO DE SALUD</span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center"><img src="marcadores/marcador_violeta.png" alt="" width="30px" height="30px"/></td>
      <td><span style="font-family: Arial; font-size: 12px;">CENTRO DE SALUD AMBULATORIO</span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center"><img src="marcadores/marcador_verde.png" alt="" width="30px" height="30px"/></td>
      <td><span style="font-family: Arial; font-size: 12px;">CENTRO DE SALUD CON INTERNACIÓN</span></td>
      <td>&nbsp;</td>
    </tr>
        <tr>
      <td style="text-align: center"><img src="marcadores/marcador_azul.png" alt="" width="30px" height="30px"/></td>
      <td><span style="font-family: Arial; font-size: 12px;">CENTRO DE SALUD INTEGRAL</span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center"><img src="marcadores/hospital_rojo.png" alt="" width="30px" height="30px"/></td>
      <td><span style="font-family: Arial; font-size: 12px;">HOSPITAL DE SEGUNDO NIVEL</span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center"><img src="marcadores/eess_blanco_celeste.png" alt="" width="30px" height="30px"/></td>
      <td><span style="font-family: Arial; font-size: 12px;">HOSPITAL GENERAL</span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center"><img src="marcadores/cruz_roja_blanco.png" alt="" width="30px" height="30px"/></td>
      <td><span style="font-family: Arial; font-size: 12px;">OTRO TIPO DE ESTABLECIMIENTO</span></td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>

<script>
    let map = L.map('mi_mapa').setView([<?php echo $row1[1];?>, <?php echo $row1[2];?>], 12);


     let Vecinal = L.icon({
        iconUrl: "marcadores/marcador_rojo_bl.png",
        iconSize: [40, 40],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Puesto_salud = L.icon({
        iconUrl: "marcadores/marcador_amarillo.png",
        iconSize: [40, 40],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Ambulatorio = L.icon({
        iconUrl: "marcadores/marcador_violeta.png",
        iconSize: [40, 40],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Internacion = L.icon({
        iconUrl: "marcadores/marcador_verde.png",
        iconSize: [40, 40],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Integral = L.icon({
        iconUrl: "marcadores/marcador_azul.png",
        iconSize: [40, 40],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Hospital_seg = L.icon({
        iconUrl: "marcadores/hospital_rojo.png",
        iconSize: [40, 40],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Hospital_gen = L.icon({
        iconUrl: "marcadores/eess_blanco_celeste.png",
        iconSize: [40, 40],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Establecim = L.icon({
        iconUrl: "marcadores/cruz_roja_blanco.png",
        iconSize: [40, 40],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        <?php 
$numero2 = 0;
$sql2 = " SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, nivel_establecimiento.nivel_establecimiento,  ";
$sql2.= " tipo_establecimiento.tipo_establecimiento, establecimiento_salud.latitud, establecimiento_salud.longitud, establecimiento_salud.idtipo_establecimiento  ";
$sql2.= " FROM establecimiento_salud, nivel_establecimiento, tipo_establecimiento WHERE establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento ";
$sql2.= " AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento AND establecimiento_salud.latitud !=''  ";
$sql2.= " AND establecimiento_salud.longitud !='' AND establecimiento_salud.idmunicipio = '$idmunicipio' ORDER BY idestablecimiento_salud ";
$result2 = mysqli_query($link,$sql2);
$total2 = mysqli_num_rows($result2);
 if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
	?>
        L.marker([<?php echo $row2[4];?>, <?php echo $row2[5];?>], { icon: 
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

</script>

</body>

</html>