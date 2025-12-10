<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$idred_salud = $_GET['idred_salud'];

$sql_red = " SELECT idred_salud, red_salud FROM red_salud WHERE idred_salud='$idred_salud' ";
$result_red = mysqli_query($link,$sql_red);
$row_red = mysqli_fetch_array($result_red);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>EVALUACION DE SALUD FAMILIAR - RED DE SALUD</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {

    Highcharts.data({
        csv: document.getElementById('tsv').innerHTML,
        itemDelimiter: '\t',
        parsed: function (columns) {

            var brands = {},
                brandsData = [],
                versions = {},
                drilldownSeries = [];

            // Parse percentage strings
            columns[1] = $.map(columns[1], function (value) {
                if (value.indexOf('%') === value.length - 1) {
                    value = parseFloat(value);
                }
                return value;
            });

            $.each(columns[0], function (i, name) {
                var brand,
                    version;

                if (i > 0) {

                    // Remove special edition notes
                    name = name.split(' -')[0];

                    // Split into brand and version
                    version = name.match(/([0-9]+[\.0-9x]*)/);
                    if (version) {
                        version = version[0];
                    }
                    brand = name.replace(version, '');

                    // Create the main data
                    if (!brands[brand]) {
                        brands[brand] = columns[1][i];
                    } else {
                        brands[brand] += columns[1][i];
                    }

                    // Create the version data
                    if (version !== null) {
                        if (!versions[brand]) {
                            versions[brand] = [];
                        }
                        versions[brand].push(['v' + version, columns[1][i]]);
                    }
                }

            });

            $.each(brands, function (name, y) {
                brandsData.push({
                    name: name,
                    y: y,
                    drilldown: versions[name] ? name : null
                });
            });
            $.each(versions, function (key, value) {
                drilldownSeries.push({
                    name: key,
                    id: key,
                    data: value
                });
            });

            // creamos el grafico

            <?php
$sql_t =" SELECT count(evaluacion_familiar_cf.idevaluacion_familiar_cf) FROM evaluacion_familiar_cf, carpeta_familiar, ubicacion_cf  ";
$sql_t.=" WHERE evaluacion_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_t.=" AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.ubicacion_actual='SI' AND ubicacion_cf.idred_salud='$idred_salud'  ";
$sql_t.=" AND evaluacion_familiar_cf.evaluacion_familiar !='' ";
$result_t = mysqli_query($link,$sql_t);
$row_t = mysqli_fetch_array($result_t);
$total = $row_t[0];

$sql_a =" SELECT count(evaluacion_familiar_cf.idevaluacion_familiar_cf) FROM evaluacion_familiar_cf, carpeta_familiar, ubicacion_cf  ";
$sql_a.=" WHERE evaluacion_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_a.=" AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.ubicacion_actual='SI' AND ubicacion_cf.idred_salud='$idred_salud' ";
$sql_a.=" AND evaluacion_familiar_cf.evaluacion_familiar='FAMILIA CON RIESGO BAJO' ";
$result_a = mysqli_query($link,$sql_a);
$row_a = mysqli_fetch_array($result_a);
$riesgo_bajo = $row_a[0];

$sql_b =" SELECT count(evaluacion_familiar_cf.idevaluacion_familiar_cf) FROM evaluacion_familiar_cf, carpeta_familiar, ubicacion_cf ";
$sql_b.=" WHERE evaluacion_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_b.=" AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.ubicacion_actual='SI' AND ubicacion_cf.idred_salud='$idred_salud' ";
$sql_b.=" AND evaluacion_familiar_cf.evaluacion_familiar='FAMILIA CON RIESGO MEDIANO' ";
$result_b = mysqli_query($link,$sql_b);
$row_b = mysqli_fetch_array($result_b);
$riesgo_mediano = $row_b[0];

$sql_c =" SELECT count(evaluacion_familiar_cf.idevaluacion_familiar_cf) FROM evaluacion_familiar_cf, carpeta_familiar, ubicacion_cf ";
$sql_c.=" WHERE evaluacion_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_c.=" AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.ubicacion_actual='SI' AND ubicacion_cf.idred_salud='$idred_salud' ";
$sql_c.=" AND evaluacion_familiar_cf.evaluacion_familiar='FAMILIA CON RIESGO ALTO' ";
$result_c = mysqli_query($link,$sql_c);
$row_c = mysqli_fetch_array($result_c);
$riesgo_alto =$row_c[0];

$riesgo_bajo_p    = ($riesgo_bajo*100)/$total;
$riesgo_mediano_p = ($riesgo_mediano*100)/$total;
$riesgo_alto_p    = ($riesgo_alto*100)/$total;

?>
            $('#container').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'EVALUACIÓN DE LA SALUD FAMILIAR - Red de Salud <?php echo mb_strtoupper($row_red[1]);?>'
                },
                subtitle: {
                    text: 'Fuente: Sistema Medi-Safci al <?php echo $f_emision;?>'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Porcetaje del Total'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f}%'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                },

                series: [{
                    name: 'Carpetas Familiares',
                    colorByPoint: true,
                    data: brandsData
                }],
                drilldown: {
                    series: drilldownSeries
                }
            });
        }
    });
});


		</script>
	</head>
	<body>
<script src="../js/salud_integrantes.js"></script>
<script src="../js/modules/data.js"></script>
<script src="../js/modules/drilldown.js"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<!-- Data from www.netmarketshare.com. Select Browsers => Desktop share by version. Download as tsv. -->
<pre id="tsv" style="display:none">Evaluacion salud	familiar 
FAMILIAS CON RIESGO BAJO	<?php echo $riesgo_bajo_p;?>%
FAMILIAS CON RIESGO MEDIANO	<?php echo $riesgo_mediano_p;?>%
FAMILIAS CON RIESGO ALTO 	<?php echo $riesgo_alto_p;?>%
</pre>

<?php
$sql_cf =" SELECT count(carpeta_familiar.idcarpeta_familiar) FROM carpeta_familiar, ubicacion_cf ";
$sql_cf.=" WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
$sql_cf.=" AND ubicacion_cf.ubicacion_actual='SI' AND ubicacion_cf.idred_salud='$idred_salud' ";
$result_cf = mysqli_query($link,$sql_cf);
$row_cf = mysqli_fetch_array($result_cf);  
$total_cf = $row_cf[0];
?>

<span style="font-family: Arial; font-size: 12px;"><h4 align="center">TOTAL DE CARPETAS FAMILIARES EN LA RED DE SALUD = <?php echo $total_cf;?> </h4></spam>

<?php
$sql_red =" SELECT ubicacion_cf.idestablecimiento_salud FROM carpeta_familiar, ubicacion_cf ";
$sql_red.=" WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
$sql_red.=" AND ubicacion_cf.ubicacion_actual='SI' AND ubicacion_cf.idred_salud='$idred_salud' GROUP BY ubicacion_cf.idestablecimiento_salud ";
$result_red = mysqli_query($link,$sql_red);
$establecimientos = mysqli_num_rows($result_red);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE ESTABLECIMIENTOS DE SALUD EN LA RED DE SALUD = <?php echo $establecimientos;?> </h4></spam>

<?php
$sql_int =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar, ubicacion_cf  ";
$sql_int.=" WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_int.=" AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO'  ";
$sql_int.=" AND integrante_cf.estado='CONSOLIDADO' AND ubicacion_cf.idred_salud='$idred_salud' ";
$result_int = mysqli_query($link,$sql_int);
$row_int = mysqli_fetch_array($result_int);  
$integrantes = $row_int[0];
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE INTEGRANTES DE FAMILIA REGISTRADOS EN LA RED DE SALUD= <?php echo $integrantes;?> </h4></spam>

<?php
$sql_per = " SELECT carpeta_familiar.idusuario FROM carpeta_familiar, ubicacion_cf WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_per.= " AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.idred_salud='$idred_salud' GROUP BY carpeta_familiar.idusuario ";
$result_per = mysqli_query($link,$sql_per);
$personal = mysqli_num_rows($result_per);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE PERSONAL SAFCI EN LA RED DE SALUD = <?php echo $personal;?></h4></spam>

	</body>
</html>
