<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

$idsospecha_diag_estab = $_GET['idsospecha_diag_estab'];
$idestablecimiento_salud = $_GET['idestablecimiento_salud'];

$sql_sos = " SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idsospecha_diag='$idsospecha_diag_estab' ";
$result_sos = mysqli_query($link,$sql_sos);
$row_sos = mysqli_fetch_array($result_sos);


$sql_e = " SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud' ";
$result_e = mysqli_query($link,$sql_e);
$row_e = mysqli_fetch_array($result_e);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>VIGILANCIA POR ESTABLECIMIENTO</title>

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
            text: 'VIGILANCIA: <?php echo mb_strtoupper($row_sos[1]);?> - ESTABLECIMIENTO: <?php echo mb_strtoupper($row_e[1]);?>'
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
                text: 'CASOS REGISTRADOS'
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' CASOS '
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
            name: 'SOSPECHAS ',
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
$sql7 = " SELECT SUM(registro_enfermedad.cifra) FROM registro_enfermedad, notificacion_ep ";
$sql7.= " WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
$sql7.= " AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_estab' AND notificacion_ep.semana_ep='$row[0]' ";
$sql7.= " AND registro_enfermedad.gestion='$gestion' AND notificacion_ep.idestablecimiento_salud='$idestablecimiento_salud' AND notificacion_ep.estado='CONSOLIDADO'";
$result7 = mysqli_query($link,$sql7);
$row7 = mysqli_fetch_array($result7);
$cifra_semanal = $row7[0];
?>
             <?php echo $cifra_semanal; ?>

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
    name: 'RECUPERADOS',
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
$sql7 = " SELECT seguimiento_ep.idseguimiento_ep, seguimiento_ep.idsospecha_diag, seguimiento_ep.idestado_paciente, semana_ep.semana_ep FROM seguimiento_ep, notificacion_ep, semana_ep ";
$sql7.= " WHERE seguimiento_ep.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND seguimiento_ep.idsemana_ep=semana_ep.idsemana_ep AND seguimiento_ep.idestado_paciente='2' ";
$sql7.= " AND seguimiento_ep.idsospecha_diag='$idsospecha_diag_estab' AND semana_ep.semana_ep='$row[0]' AND notificacion_ep.idestablecimiento_salud='$idestablecimiento_salud' ";
$result7 = mysqli_query($link,$sql7);
$row7 = mysqli_num_rows($result7);
$recuperados = $row7;
?>
<?php echo $recuperados; ?>

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
]   }
        
    ]
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