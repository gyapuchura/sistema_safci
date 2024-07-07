<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$idcarpeta_familiar =  $_SESSION['idcarpeta_familiar'];
 
$sql_a =" SELECT COUNT(idintegrante_ap_sano) FROM integrante_ap_sano ";
$sql_a.="  ";
$result_a = mysqli_query($link,$sql_a);
$row_a = mysqli_fetch_array($result_a);
$aparentemente_sano = $row_a[0];

$sql_b =" SELECT COUNT(idintegrante_factor_riesgo) FROM integrante_factor_riesgo ";
$sql_b.="  ";
$result_b = mysqli_query($link,$sql_b);
$row_b = mysqli_fetch_array($result_b);
$factor_riesgo = $row_b[0];

$sql_c =" SELECT COUNT(idintegrante_morbilidad) FROM integrante_morbilidad ";
$sql_c.="  ";
$result_c = mysqli_query($link,$sql_c);
$row_c = mysqli_fetch_array($result_c);
$morbilidad =$row_c[0];

$sql_d =" SELECT COUNT(idintegrante_discapacidad) FROM integrante_discapacidad ";
$sql_d.="  ";
$result_d = mysqli_query($link,$sql_d);
$row_d = mysqli_fetch_array($result_d);
$discapacidad = $row_d[0];

$total = $aparentemente_sano + $factor_riesgo + $morbilidad + $discapacidad;

$grupo_1       = ($aparentemente_sano*100)/$total;
$grupo_2       = ($factor_riesgo*100)/$total;
$grupo_3       = ($morbilidad*100)/$total;
$grupo_4       = ($discapacidad*100)/$total;

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>SALUD DE INTEGRANTES DE LA FAMILIA</title>

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
            $('#container').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: ' SALUD DE LOS INTEGRANTES DE LA FAMILIA  '
                },
                subtitle: {
                    text: 'GRUPOS DE SALUD'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'PORCENTAJE DE INTEGRANTES'
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
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total de Integrantes<br/>'
                },

                series: [{
                    name: 'Grupo de Salud',
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
GRUPO I  APARENTEMENTE SANOS	    <?php echo $grupo_1;?>%
GRUPO II  FACTORES DE RIESGO	<?php echo $grupo_2;?>%
GRUPO III  MORBILIDAD	<?php echo $grupo_3;?>%
GRUPO IV  DISCAPACIDAD	<?php echo $grupo_4;?>%
</pre>
	<p style="text-align: center; font-family: Arial; font-size: 16px; color: #3167AC;"><strong>SALUD DE LOS INTEGRANTES DE LA FAMILIA</strong></p>
	<table width="600" border="0" align="center">
	  <tbody>
	    <tr>
	      <td width="40" style="font-family: Arial; text-align: center; color: #3167AC; font-size: 12px;"><strong>N°</strong></td>
	      <td width="126" style="font-family: Arial; text-align: center; color: #3167AC; font-size: 12px;"><strong>GRUPO </strong></td>
	      <td width="233" style="text-align: center"><strong style="font-family: Arial; font-size: 12px; color: #3167AC;">DESCRIPCION</strong></td>
	      <td width="183" style="font-family: Arial; font-size: 12px; text-align: center; color: #3167AC;"><strong>REPORTE</strong></td>
        </tr>
	    <tr>
	      <td style="text-align: center; font-family: Arial; font-size: 12px;">1</td>
	      <td style="font-family: Arial; font-size: 12px; text-align: center;">GRUPO I</td>
	      <td style="font-family: Arial; font-size: 12px; text-align: center;">APARENTEMENTE SANO</td>
	      <td>&nbsp;</td>
        </tr>
	    <tr>
	      <td style="font-family: Arial; font-size: 12px; text-align: center;">2</td>
	      <td style="font-family: Arial; text-align: center; font-size: 12px;">GRUPO II</td>
	      <td style="font-family: Arial; font-size: 12px; text-align: center;">FACTORES DE RIESGO</td>
	      <td>&nbsp;</td>
        </tr>
	    <tr>
	      <td style="font-family: Arial; font-size: 12px; text-align: center;">3</td>
	      <td style="text-align: center; font-family: Arial; font-size: 12px;">GRUPO III</td>
	      <td style="font-family: Arial; text-align: center; font-size: 12px;">MORBILIDAD</td>
	      <td>&nbsp;</td>
        </tr>
	    <tr>
	      <td style="font-family: Arial; font-size: 12px; text-align: center;">4</td>
	      <td style="font-size: 12px; font-family: Arial; text-align: center;">GRUPO IV</td>
	      <td style="font-family: Arial; text-align: center; font-size: 12px;">DISCAPACIDAD</td>
	      <td>&nbsp;</td>
        </tr>
      </tbody>
    </table>
	<p>&nbsp;</p>
	</body>
</html>
