<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idestablecimiento_salud      = $_GET['idestablecimiento_salud']; 

$sql_est = " SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud' ";
$result_est = mysqli_query($link,$sql_est);
$row_est = mysqli_fetch_array($result_est);

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>FACTORES DE RIESGO EN AREAS DE INFLUENCIA</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'FACTORES DE RIESGO - ÁREAS DE INFLUENCIA DEL ESTABLECIMIENTO: <?php echo mb_strtoupper($row_est[1]);?>'
        },
        subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-SAFCI al <?php echo $f_emision;?>'
        },
        xAxis: {
            categories: [
                <?php 
$numero = 0;
$sql = " SELECT carpeta_familiar.idarea_influencia, area_influencia.area_influencia FROM integrante_factor_riesgo, carpeta_familiar, area_influencia ";
$sql.= " WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql.= " AND carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia AND carpeta_familiar.estado='CONSOLIDADO' ";
$sql.= " AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' GROUP BY carpeta_familiar.idarea_influencia  ";
$result = mysqli_query($link,$sql);
$total = mysqli_num_rows($result);
 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>
 '<?php  echo substr($row[1],0,30); ?>'

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
echo "";
/*
Si no se encontraron resultados
*/
}
?>
            ],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: ' Integrantes por Área de influencia',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' integrantes'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
      
        series: [
{
name: 'Integrantes FACTORES DE RIESGO',
data: [
    
    <?php 
$numero3 = 0;
$sql3 = " SELECT carpeta_familiar.idarea_influencia FROM integrante_factor_riesgo, carpeta_familiar ";
$sql3.= " WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql3.= " AND carpeta_familiar.estado='CONSOLIDADO' ";
$sql3.= " AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' GROUP BY carpeta_familiar.idarea_influencia ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {

$sql4 =" SELECT integrante_factor_riesgo.idintegrante_cf FROM integrante_factor_riesgo, carpeta_familiar WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql4.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idarea_influencia='$row3[0]' GROUP BY integrante_factor_riesgo.idintegrante_cf ";
$result4 = mysqli_query($link,$sql4);
$factor_riesgo = mysqli_num_rows($result4); 
?>

<?php  echo $factor_riesgo; ?>

<?php 
$numero3++;
if ($numero3 == $total3) {
echo "";
}
else {
echo ",";
}
} while ($row3 = mysqli_fetch_array($result3));
} else {
echo "";

}
?> 

] } ]

    });
});
		</script>
	</head>
	<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>
<script src="../js/modules/drilldown.js"></script>


<div id="container" style="min-width: 310px; max-width: 850px; height: <?php echo $numero3*200;?>px; margin: 0 auto"></div>

<span style="font-family: Arial; font-size: 14px;"><h4 align="center">N° de Áreas de influencia = <?php echo $numero3;?></h4></spam>
<p>&nbsp;</p>
</body>
</html>
