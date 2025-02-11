<?php include("../cabf.php"); ?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

$idevento_notificacion = $_GET['idevento_notificacion'];

$sql_ev = " SELECT idevento_notificacion, evento_notificacion FROM evento_notificacion WHERE idevento_notificacion='$idevento_notificacion' ";
$result_ev = mysqli_query($link,$sql_ev);
$row_ev = mysqli_fetch_array($result_ev);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>EVENTOS DE NOTIFICACION INMEDIATA</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'areaspline'
        },
        title: {
            text: 'EVENTO: <?php echo mb_strtoupper($row_ev[1]);?>'
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            verticalAlign: 'top',
            x: 150,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
        },
        xAxis: {
            categories: [
 <?php
$numero = 0;
$sql = " SELECT semana_ep FROM notificacion_ep WHERE gestion ='$gestion' AND estado='CONSOLIDADO' GROUP BY semana_ep ORDER BY semana_ep";
$result = mysqli_query($link,$sql);
$total = mysqli_num_rows($result);
 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>
             'SEMANA <?php echo $row[0];?>'

                           <?php

$numero++;

if ($numero == $total) {

echo "";


}
else {



echo ",";

}


} while ($row = mysqli_fetch_array($result));


} else {


echo ",";

}
?>
            ],
            plotBands: [{ // visualize the weekend
                from: 4.5,
                to: 6.5,
                color: 'rgba(68, 170, 213, .2)'
            }]
        },
        yAxis: {
            title: {
                text: 'PERSONAS'
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' Personas '
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            areaspline: {
                fillOpacity: 0.5
            }
        },
        series: [

            {
            name: 'PERSONAS ATENDIDAS',
            data: [

             <?php

$numero = 0;
$sql = " SELECT semana_ep FROM notificacion_ep WHERE gestion ='$gestion' AND estado='CONSOLIDADO' GROUP BY semana_ep ORDER BY semana_ep ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT SUM(registro_evento_notificacion.personas_atendidas) FROM notificacion_ep, registro_evento_notificacion  ";
$sql7.= " WHERE registro_evento_notificacion.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
$sql7.= " AND notificacion_ep.estado='CONSOLIDADO' AND registro_evento_notificacion.idevento_notificacion='$idevento_notificacion' ";
$sql7.= " AND notificacion_ep.gestion='$gestion' AND notificacion_ep.semana_ep='$row[0]' ";
$result7 = mysqli_query($link,$sql7);
$row7 = mysqli_fetch_array($result7);
$atencion_semanal = $row7[0];
?>
             <?php echo $atencion_semanal; ?>

<?php
$numero++;
if ($numero == $total) {
echo "";
}
else {
echo ",";
}

} while ($row = mysqli_fetch_array($result));


} else {


echo ",";
/*
Si no se encontraron resultados
*/
}
?>
]
        },
        {
            name: 'PERSONAS AFECTADAS',
            data: [

             <?php

$numeroa = 0;
$sqla = " SELECT semana_ep FROM notificacion_ep WHERE gestion ='$gestion' AND estado='CONSOLIDADO' GROUP BY semana_ep ORDER BY semana_ep ";
$resulta = mysqli_query($link,$sqla);

$totala = mysqli_num_rows($resulta);

 if ($rowa = mysqli_fetch_array($resulta)){

mysqli_field_seek($resulta,0);
while ($fielda = mysqli_fetch_field($resulta)){
} do {
	?>

<?php
$sqlca = " SELECT SUM(registro_evento_notificacion.personas_afectadas) FROM notificacion_ep, registro_evento_notificacion  ";
$sqlca.= " WHERE registro_evento_notificacion.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
$sqlca.= " AND notificacion_ep.estado='CONSOLIDADO' AND registro_evento_notificacion.idevento_notificacion='$idevento_notificacion' ";
$sqlca.= " AND notificacion_ep.gestion='$gestion' AND notificacion_ep.semana_ep='$rowa[0]' ";
$resultca = mysqli_query($link,$sqlca);
$rowca = mysqli_fetch_array($resultca);
$atencion_semanal_ca = $rowca[0];
?>
             <?php echo $atencion_semanal_ca; ?>

<?php
$numeroa++;
if ($numeroa == $totala) {
echo "";
}
else {
echo ",";
}

} while ($rowa = mysqli_fetch_array($resulta));


} else {


echo ",";
/*
Si no se encontraron resultados
*/
}
?>
]
        },
        {
            name: 'PERSONAS FALLECIDAS',
            data: [

             <?php

$numero = 0;
$sql = " SELECT semana_ep FROM notificacion_ep WHERE gestion ='$gestion' AND estado='CONSOLIDADO' GROUP BY semana_ep ORDER BY semana_ep ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT SUM(registro_evento_notificacion.personas_fallecidas) FROM notificacion_ep, registro_evento_notificacion  ";
$sql7.= " WHERE registro_evento_notificacion.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
$sql7.= " AND notificacion_ep.estado='CONSOLIDADO' AND registro_evento_notificacion.idevento_notificacion='$idevento_notificacion' ";
$sql7.= " AND notificacion_ep.gestion='$gestion' AND notificacion_ep.semana_ep='$row[0]' ";
$result7 = mysqli_query($link,$sql7);
$row7 = mysqli_fetch_array($result7);
$atencion_semanal = $row7[0];
?>
             <?php echo $atencion_semanal; ?>

<?php
$numero++;
if ($numero == $total) {
echo "";
}
else {
echo ",";
}

} while ($row = mysqli_fetch_array($result));


} else {


echo ",";
/*
Si no se encontraron resultados
*/
}
?>
]
        }
        
        ]
    });
});
		</script>
	</head>
	<body>
<span style="font-family: Arial"></span><script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>
<div id="container" style="min-width: 300px; height: 350px; margin: 0 auto"></div>
		<h2 style="text-align: center; font-family: Arial; font-size: 14px; color: #2D56CF;">REGISTRO DE EVENTOS DE NOTIFICACIÓN SOBRE: <?php echo mb_strtoupper($row_ev[1]);?></h2>
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

</body>
</html>