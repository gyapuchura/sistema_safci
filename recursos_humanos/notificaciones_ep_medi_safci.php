<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>MEDI-SAFCI F302A DIARIA</title>

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
            text: 'NOTIFICACIONES F302A REGISTRADOS POR DIA SISTEMA MEDI-SAFCI'
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
$sql = " SELECT fecha_registro FROM notificacion_ep WHERE estado='CONSOLIDADO' GROUP BY fecha_registro ORDER BY fecha_registro";
$result = mysqli_query($link,$sql);
$total = mysqli_num_rows($result);
 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {

    $fecha_s = explode('-',$row[0]);
    $fecha_log = $fecha_s[2].'/'.$fecha_s[1].'/'.$fecha_s[0];
    ?>

             '<?php echo $fecha_log;?>'

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
                text: 'F302a'
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' Notificaciones'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            areaspline: {
                fillOpacity: 0.5
            }
        },
        series: [{
            name: 'Notificaciones F302A',
            data: [

             <?php

$numero = 0;
$sql = " SELECT fecha_registro FROM notificacion_ep WHERE estado='CONSOLIDADO' GROUP BY fecha_registro ORDER BY fecha_registro ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT idnotificacion_ep, fecha_registro FROM notificacion_ep WHERE estado='CONSOLIDADO' AND fecha_registro='$row[0]'";
$result7 = mysqli_query($link,$sql7);
$row7 = mysqli_num_rows($result7);

$cifra_diaria = $row7;
?>
             <?php echo $cifra_diaria; ?>

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
        }]
    });
});
		</script>
	</head>
	<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>
<div id="container" style="min-width: 300px; height: 350px; margin: 0 auto"></div>
</body>
</html>