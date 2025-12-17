<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$idestablecimiento_salud = $_GET['idestablecimiento_salud'];

$sql1 = " SELECT idestablecimiento_salud, establecimiento_salud, latitud, longitud FROM establecimiento_salud ";
$sql1.= " WHERE latitud != '' AND longitud != '' AND idestablecimiento_salud='$idestablecimiento_salud' ";
$result1 = mysqli_query($link,$sql1);
$row1 = mysqli_fetch_array($result1);

$latitud_c  = $row1[2];
$longitud_c = $row1[3];
$zoom_c     = "12";

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>RIESGO PERSONAL - ESTABLECIMIENTO DE SALUD</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    </head>

<body>

<div style="text-align: center;"><button onclick="history.back();" align="center">VOLVER AL MAPA DE VISITAS</button> </div>       

<div class="sala"><h3 class="text-center">INTEGRANTES IDENTIFICADOS DEL ESTABLECIMIENTO : <?php echo mb_strtoupper($row1[1]);?></h3></div>  

<div id="mi_mapa" style="width: 100%; height: 500px;"></div>


</br></br>
<table width="1000" border="1" align="center" cellspacing="0">
    <tbody>
    <tr>
        <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
        <td width="299" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">RIÉSGO PERSONAL</td>
        <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">SEMAFORIZACIÓN</td>
        <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° DE INTEGRANTES CON SEGUIMIENTOS PLANIFICADOS</td>
        <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° VISITAS PLANIFICADAS A INTEGRANTES A LA FECHA</td>
        <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° VISITAS REALIZADAS A INTEGRANTES A LA FECHA</td>
        <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° VISITAS NO REALIZADASA A LA FECHA</td>
    </tr>
            <?php 
            $numero3 = 1;
            $sql = " SELECT idriesgo_personal_vf, riesgo_personal_vf, color, color_valor FROM riesgo_personal_vf ORDER BY idriesgo_personal_vf ";
            $result = mysqli_query($link,$sql);
            $total = mysqli_num_rows($result);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){ 
            } do { 
                
                $sql_int =" SELECT seguimiento_cf.idintegrante_cf FROM seguimiento_cf, carpeta_familiar  ";
                $sql_int.=" WHERE seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                $sql_int.=" AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND seguimiento_cf.idriesgo_personal_vf='$row[0]' GROUP BY seguimiento_cf.idintegrante_cf ";
                $result_int = mysqli_query($link,$sql_int);
                $integrantes = mysqli_num_rows($result_int);              
                
                $sql_vf =" SELECT visita_cf.idvisita_cf FROM visita_cf, seguimiento_cf, carpeta_familiar ";
                $sql_vf.=" WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_vf.=" AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND seguimiento_cf.idriesgo_personal_vf='$row[0]'  ";
                $result_vf = mysqli_query($link,$sql_vf);
                $visitas = mysqli_num_rows($result_vf);

                $sql_vfr =" SELECT visita_cf.idvisita_cf FROM visita_cf, seguimiento_cf, carpeta_familiar ";
                $sql_vfr.=" WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_vfr.=" AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND seguimiento_cf.idriesgo_personal_vf='$row[0]' AND visita_cf.idestado_visita_cf='3' ";
                $result_vfr = mysqli_query($link,$sql_vfr);
                $visitas_r  = mysqli_num_rows($result_vfr);

                $visitas_nr = $visitas-$visitas_r;
                
                ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero3;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[1];?></td>
              <td <?php echo 'bgcolor="#'.$row[3].'" ';?> style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[2];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $integrantes;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="visitas_safci_rp_est.php?idriesgo_personal_vf=<?php echo $row[0];?>&idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1200,height=1000,scrollbars=YES'); return false;">
              <?php echo $visitas;?></a>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="visitas_safci_rp_r_est.php?idriesgo_personal_vf=<?php echo $row[0];?>&idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1200,height=1000,scrollbars=YES'); return false;">
              <?php echo $visitas_r;?></a> 
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $visitas_nr;?></td>
	        </tr>
                <?php 
                $numero3=$numero3+1;
                } while ($row = mysqli_fetch_array($result));
                } else {
                }
                ?>
	      </tbody>
    </table>
            </br></br>

    <script>
        let Vecinal = L.icon({
        iconUrl: "marcadores/marcador_rojo_bl.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Neonato = L.icon({
        iconUrl: "../sala_situacional/riesgo_personal/neonato.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Menor_dos = L.icon({
        iconUrl: "../sala_situacional/riesgo_personal/mes_vida.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Menor_cinco = L.icon({
        iconUrl: "../sala_situacional/riesgo_personal/menor_cinco.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Desnutricion = L.icon({
        iconUrl: "../sala_situacional/riesgo_personal/desnutricion_aguda.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Talla_baja = L.icon({
        iconUrl: "../sala_situacional/riesgo_personal/talla_baja.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Embarazo = L.icon({
        iconUrl: "../sala_situacional/riesgo_personal/embarazada.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Puerpera = L.icon({
        iconUrl: "../sala_situacional/riesgo_personal/puerpera.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Tuberculosis = L.icon({
        iconUrl: "../sala_situacional/riesgo_personal/tuberculosis.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Transmisibles = L.icon({
        iconUrl: "../sala_situacional/riesgo_personal/transmisible.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let No_transmisibles = L.icon({
        iconUrl: "../sala_situacional/riesgo_personal/no_transmisible.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Vectoriales = L.icon({
        iconUrl: "../sala_situacional/riesgo_personal/vectoriales.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Mayor_sesenta = L.icon({
        iconUrl: "../sala_situacional/riesgo_personal/mayor_sesenta.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Discapacidad = L.icon({
        iconUrl: "../sala_situacional/riesgo_personal/discapacidad.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Violencia = L.icon({
        iconUrl: "../sala_situacional/riesgo_personal/violencia.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        let Sin_riesgo = L.icon({
        iconUrl: "../sala_situacional/riesgo_personal/sin_riesgo.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});


    let map = L.map('mi_mapa').setView([<?php echo $latitud_c;?>, <?php echo $longitud_c;?>], <?php echo $zoom_c;?>);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);


        /****** Areas de influencia del Establecimiento de salud *********/

        <?php
/****** Areas de influencia del Establecimiento de salud *********/

$numero4 = 0;
$sql4 = " SELECT seguimiento_cf.idseguimiento_cf, carpeta_familiar.familia, riesgo_personal_vf.riesgo_personal_vf, seguimiento_cf.idriesgo_personal_vf,  ";
$sql4.= " ubicacion_cf.latitud, ubicacion_cf.longitud, seguimiento_cf.idcarpeta_familiar FROM riesgo_personal_vf, seguimiento_cf, carpeta_familiar, ubicacion_cf ";
$sql4.= " WHERE seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql4.= " AND seguimiento_cf.idriesgo_personal_vf=riesgo_personal_vf.idriesgo_personal_vf AND ubicacion_cf.ubicacion_actual='SI' AND seguimiento_cf.idriesgo_personal_vf !='15' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
$result4 = mysqli_query($link,$sql4);
 if ($row4 = mysqli_fetch_array($result4)){
mysqli_field_seek($result4,0);
while ($field4 = mysqli_fetch_field($result4)){
} do {
	?>

 L.marker([<?php echo $row4[4];?>,<?php echo $row4[5];?>], {icon : 
      <?php   
      switch ($row4[3]) {
        case 1:
            echo "Neonato";
            break;
        case 2:
            echo "Menor_dos";
            break;
        case 3:
            echo "Menor_cinco";
            break;
        case 4:
            echo "Desnutricion";
            break;
        case 5:
            echo "Talla_baja";
            break;
        case 6:
            echo "Embarazo";
            break;
        case 7:
            echo "Puerpera";
            break;
        case 8:
            echo "Tuberculosis";
            break;
        case 9:
            echo "Transmisibles";
            break;
        case 10:
            echo "No_transmisibles";
            break;
        case 11:
            echo "Vectoriales";
            break;
        case 12:
            echo "Mayor_sesenta";
            break;
        case 13:
            echo "Discapacidad";
            break;
        case 14:
            echo "Violencia";
            break;
        case 15:
            echo "Sin_riesgo";
            break;

    }
                ?> 
 }).addTo(map).bindPopup("<?php echo '<p>Riesgo : '.$row4[2].'</p><p> Familia : '.$row4[1].'</p><p><a href=../seguimiento_familiar/imprime_seguimiento_familiar_mapa.php?idcarpeta_familiar='.$row4[6].' onClick=window.open(this.href, this.target, width=1000,height=650,scrollbars=YES,top=50,left=300); return false;>SEGUIMIENTO DE VISITAS</a></p> ';?>")

<?php 
$numero4++;

} while ($row4 = mysqli_fetch_array($result4));
} else {
}
?>




</script>


	</body>
</html>