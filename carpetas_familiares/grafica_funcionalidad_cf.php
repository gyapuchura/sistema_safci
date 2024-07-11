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
$sql_t =" SELECT count(idsocio_economica_cf) FROM socio_economica_cf  ";
$result_t = mysqli_query($link,$sql_t);
$row_t = mysqli_fetch_array($result_t);
$total = $row_t[0];

$sql_a =" SELECT count(idsocio_economica_cf) FROM socio_economica_cf WHERE idsocio_economica ='1' ";
$sql_a.="  ";
$result_a = mysqli_query($link,$sql_a);
$row_a = mysqli_fetch_array($result_a);
$refrigerador = $row_a[0];

$sql_b =" SELECT count(idsocio_economica_cf) FROM socio_economica_cf WHERE idsocio_economica ='2' ";
$sql_b.="  ";
$result_b = mysqli_query($link,$sql_b);
$row_b = mysqli_fetch_array($result_b);
$computadora = $row_b[0];

$sql_c =" SELECT count(idsocio_economica_cf) FROM socio_economica_cf WHERE idsocio_economica ='3'  ";
$sql_c.="  ";
$result_c = mysqli_query($link,$sql_c);
$row_c = mysqli_fetch_array($result_c);
$televisor =$row_c[0];

$sql_d =" SELECT count(idsocio_economica_cf) FROM socio_economica_cf WHERE idsocio_economica ='4'  ";
$sql_d.="  ";
$result_d = mysqli_query($link,$sql_d);
$row_d = mysqli_fetch_array($result_d);
$microondas = $row_d[0];

$sql_e =" SELECT count(idsocio_economica_cf) FROM socio_economica_cf WHERE idsocio_economica ='5' ";
$sql_e.="  ";
$result_e = mysqli_query($link,$sql_e);
$row_e = mysqli_fetch_array($result_e);
$lavadora = $row_e[0];

$sql_f =" SELECT count(idsocio_economica_cf) FROM socio_economica_cf WHERE idsocio_economica ='6' ";
$sql_f.="  ";
$result_f = mysqli_query($link,$sql_f);
$row_f = mysqli_fetch_array($result_f);
$aire_acondicionado = $row_f[0];

$sql_g =" SELECT count(idsocio_economica_cf) FROM socio_economica_cf WHERE idsocio_economica ='7' ";
$sql_g.="  ";
$result_g = mysqli_query($link,$sql_g);
$row_g = mysqli_fetch_array($result_g);
$estufa =$row_g[0];

$sql_h =" SELECT count(idsocio_economica_cf) FROM socio_economica_cf WHERE idsocio_economica ='8' ";
$sql_h.="  ";
$result_h = mysqli_query($link,$sql_h);
$row_h = mysqli_fetch_array($result_h);
$automovil = $row_h[0];

$sql_i =" SELECT count(idsocio_economica_cf) FROM socio_economica_cf WHERE idsocio_economica ='9'  ";
$sql_i.="  ";
$result_i = mysqli_query($link,$sql_i);
$row_i = mysqli_fetch_array($result_i);
$internet = $row_i[0];

$sql_j =" SELECT count(idsocio_economica_cf) FROM socio_economica_cf WHERE idsocio_economica ='10' ";
$sql_j.="  ";
$result_j = mysqli_query($link,$sql_j);
$row_j = mysqli_fetch_array($result_j);
$cable = $row_j[0];


$refrigerador_p = ($refrigerador*100)/$total;
$computadora_p  = ($computadora*100)/$total;
$televisor_p    = ($televisor*100)/$total;
$microondas_p   = ($microondas*100)/$total;
$lavadora_p     = ($lavadora*100)/$total;
$aire_acondicionado_p = ($aire_acondicionado*100)/$total;
$estufa_p      = ($estufa*100)/$total;
$automovil_p   = ($automovil*100)/$total;
$internet_p    = ($internet*100)/$total;
$cable_p    = ($cable*100)/$total;

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
<pre id="tsv" style="display:none">
REFRIGERADOR O FREEZER	<?php echo $refrigerador_p;?>%
COMPUTADORA/LAPTOP	<?php echo $computadora_p;?>%
TELEVISOR 	<?php echo $televisor_p;?>%
HORNO MICROONDAS	<?php echo $microondas_p;?>%
LAVADORA/SECADORA DE ROPA	<?php echo $lavadora_p;?>%
AIRE ACONDICIONADO	<?php echo $aire_acondicionado_p;?>%
ESTUFA 	<?php echo $estufa_p;?>%
AUTOMOVIL (USO DEL HOGAR) 	<?php echo $automovil_p;?>%
SERVICIO DE INTERNET 	<?php echo $internet_p;?>%
SERVICIO DE TELEVISIÓN POR CABLE O ANTENA PARABOLICA 	<?php echo $cable_p;?>%
</pre>

	</body>
</html>
