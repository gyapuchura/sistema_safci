<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>CARPETAS FAMILIARES DEPARTAMENTO</title>

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

            // Create the chart

            <?php
$sql_t =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar WHERE estado='CONSOLIDADO' ";
$result_t = mysqli_query($link,$sql_t);
$row_t = mysqli_fetch_array($result_t);
$total = $row_t[0];

$sql_a =" SELECT count(ubicacion_cf.iddepartamento) FROM ubicacion_cf, carpeta_familiar WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_a.=" AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.iddepartamento='1' ";
$result_a = mysqli_query($link,$sql_a);
$row_a = mysqli_fetch_array($result_a);
$beni = $row_a[0];

$sql_b =" SELECT count(ubicacion_cf.iddepartamento) FROM ubicacion_cf, carpeta_familiar WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_b.=" AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.iddepartamento='2' ";
$result_b = mysqli_query($link,$sql_b);
$row_b = mysqli_fetch_array($result_b);
$cbba =    $row_b[0];

$sql_c =" SELECT count(ubicacion_cf.iddepartamento) FROM ubicacion_cf, carpeta_familiar WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_c.=" AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.iddepartamento='3' ";
$result_c = mysqli_query($link,$sql_c);
$row_c = mysqli_fetch_array($result_c);
$chuquisaca =$row_c[0];

$sql_d =" SELECT count(ubicacion_cf.iddepartamento) FROM ubicacion_cf, carpeta_familiar WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_d.=" AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.iddepartamento='4' ";
$result_d = mysqli_query($link,$sql_d);
$row_d = mysqli_fetch_array($result_d);
$la_paz = $row_d[0];

$sql_e =" SELECT count(ubicacion_cf.iddepartamento) FROM ubicacion_cf, carpeta_familiar WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_e.=" AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.iddepartamento='5' ";
$result_e = mysqli_query($link,$sql_e);
$row_e = mysqli_fetch_array($result_e);
$oruro = $row_e[0];

$sql_f =" SELECT count(ubicacion_cf.iddepartamento) FROM ubicacion_cf, carpeta_familiar WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_f.=" AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.iddepartamento='6' ";
$result_f = mysqli_query($link,$sql_f);
$row_f = mysqli_fetch_array($result_f);
$pando = $row_f[0];

$sql_g =" SELECT count(ubicacion_cf.iddepartamento) FROM ubicacion_cf, carpeta_familiar WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_g.=" AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.iddepartamento='7' ";
$result_g = mysqli_query($link,$sql_g);
$row_g = mysqli_fetch_array($result_g);
$potosi =$row_g[0];

$sql_h =" SELECT count(ubicacion_cf.iddepartamento) FROM ubicacion_cf, carpeta_familiar WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_h.=" AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.iddepartamento='8' ";
$result_h = mysqli_query($link,$sql_h);
$row_h = mysqli_fetch_array($result_h);
$santa_cruz = $row_h[0];

$sql_i =" SELECT count(ubicacion_cf.iddepartamento) FROM ubicacion_cf, carpeta_familiar WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_i.=" AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.iddepartamento='9' ";
$result_i = mysqli_query($link,$sql_i);
$row_i = mysqli_fetch_array($result_i);
$tarija = $row_i[0];


$beni_p         = ($beni*100)/$total;
$cbba_p         = ($cbba*100)/$total;
$chuquisaca_p   = ($chuquisaca*100)/$total;
$la_paz_p       = ($la_paz*100)/$total;
$oruro_p        = ($oruro*100)/$total;
$pando_p        = ($pando*100)/$total;
$potosi_p       = ($potosi*100)/$total;
$santa_cruz_p   = ($santa_cruz*100)/$total;
$tarija_p       = ($tarija*100)/$total;

?>
            $('#container').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'CANTIDAD DE CARPETAS FAMILIARES POR DEPARTAMENTO'
                },
                subtitle: {
                    text: 'Fuente: Modulo de Carpetas Familiares sistema MEDI-SAFCI'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Porcetaje de un total de <?php echo $total;?>'
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
<script src="../js/highcharts.js"></script>
<script src="../js/modules/data.js"></script>
<script src="../js/modules/drilldown.js"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<!-- Data from www.netmarketshare.com. Select Browsers => Desktop share by version. Download as tsv. -->
<pre id="tsv" style="display:none">Browser Version	Total Market Share

BENI	<?php echo $beni_p;?>%
COCHABAMBA	<?php echo $cbba_p;?>%
CHUQUISACA 	<?php echo $chuquisaca_p;?>%
LA PAZ	<?php echo $la_paz_p;?>%
ORURO	<?php echo $oruro_p;?>%
PANDO	<?php echo $pando_p;?>%
POTOSI 	<?php echo $potosi_p;?>%
SANTA CRUZ 	<?php echo $santa_cruz_p;?>%
TARIJA 	<?php echo $tarija_p;?>%
</pre>

	</body>
</html>