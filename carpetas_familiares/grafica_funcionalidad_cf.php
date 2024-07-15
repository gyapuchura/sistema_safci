<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");
?>

<?php
$sql_t =" SELECT count(idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf  ";
$result_t = mysqli_query($link,$sql_t);
$row_t = mysqli_fetch_array($result_t);
$total = $row_t[0];

$sql_8 =" SELECT count(idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf WHERE idfuncionalidad_familiar ='1' ";
$sql_8.="  ";
$result_8 = mysqli_query($link,$sql_8);
$row_8 = mysqli_fetch_array($result_8);
$desmemb = $row_8[0];

$sql_b =" SELECT count(idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf WHERE idfuncionalidad_familiar ='2' ";
$sql_b.="  ";
$result_b = mysqli_query($link,$sql_b);
$row_b = mysqli_fetch_array($result_b);
$incremento = $row_b[0];

$sql_c =" SELECT count(idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf WHERE idfuncionalidad_familiar ='3'  ";
$sql_c.="  ";
$result_c = mysqli_query($link,$sql_c);
$row_c = mysqli_fetch_array($result_c);
$desmoralizacion =$row_c[0];

$sql_d =" SELECT count(idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf WHERE idfuncionalidad_familiar ='4'  ";
$sql_d.="  ";
$result_d = mysqli_query($link,$sql_d);
$row_d = mysqli_fetch_array($result_d);
$desorganizacion = $row_d[0];

$sql_e =" SELECT count(idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf WHERE idfuncionalidad_familiar ='5' ";
$sql_e.="  ";
$result_e = mysqli_query($link,$sql_e);
$row_e = mysqli_fetch_array($result_e);
$violencia = $row_e[0];

$sql_f =" SELECT count(idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf WHERE idfuncionalidad_familiar ='6' ";
$sql_f.="  ";
$result_f = mysqli_query($link,$sql_f);
$row_f = mysqli_fetch_array($result_f);
$tabaquismo = $row_f[0];

$sql_g =" SELECT count(idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf WHERE idfuncionalidad_familiar ='7' ";
$sql_g.="  ";
$result_g = mysqli_query($link,$sql_g);
$row_g = mysqli_fetch_array($result_g);
$alcohol =$row_g[0];

$sql_h =" SELECT count(idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf WHERE idfuncionalidad_familiar ='8' ";
$sql_h.="  ";
$result_h = mysqli_query($link,$sql_h);
$row_h = mysqli_fetch_array($result_h);
$drogas = $row_h[0];

$sql_i =" SELECT count(idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf WHERE idfuncionalidad_familiar ='9'  ";
$sql_i.="  ";
$result_i = mysqli_query($link,$sql_i);
$row_i = mysqli_fetch_array($result_i);
$economica = $row_i[0];

$sql_j =" SELECT count(idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf WHERE idfuncionalidad_familiar ='10' ";
$sql_j.="  ";
$result_j = mysqli_query($link,$sql_j);
$row_j = mysqli_fetch_array($result_j);
$educativa = $row_j[0];

$sql_k =" SELECT count(idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf WHERE idfuncionalidad_familiar ='11' ";
$sql_k.="  ";
$result_k = mysqli_query($link,$sql_k);
$row_k = mysqli_fetch_array($result_k);
$afectiva = $row_k[0];

$sql_l =" SELECT count(idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf WHERE idfuncionalidad_familiar ='12' ";
$sql_l.="  ";
$result_l = mysqli_query($link,$sql_l);
$row_l = mysqli_fetch_array($result_l);
$social = $row_l[0];


$desmem_p  = ($desmemb*100)/$total;
$incremento_p   = ($incremento*100)/$total;
$desmoralizacion_p  = ($desmoralizacion*100)/$total;
$desorganizacion_p  = ($desorganizacion*100)/$total;
$violencia_p        = ($violencia*100)/$total;
$tabaquismo_p = ($tabaquismo*100)/$total;
$alcohol_p      = ($alcohol*100)/$total;
$drogas_p   = ($drogas*100)/$total;
$economica_p    = ($economica*100)/$total;
$educativa_p    = ($educativa*100)/$total;
$afectiva_p     = ($afectiva*100)/$total;
$social_p    = ($social*100)/$total;

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>FUNCIONALIDAD FAMILIAR</title>

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
                    text: 'FUNCIONALIDAD FAMILIAR '
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

<div id="container" style="min-width: 510px; height: 400px; margin: 0 auto"></div>

<!-- Data from www.netmarketshare.com. Select Browsers => Desktop share by version. Download as tsv. -->
<pre id="tsv" style="display:none">Funcionalidad Familiar	Total Carpetas Familiares
DESMEMBRAMIENTO(*)	<?php echo $desmem_p;?>%
INCREMENTO(*)	<?php echo $incremento_p;?>%
DESMORALIZACIÓN(*)	<?php echo $desmoralizacion_p;?>%
DESORGANIZACIÓN(*)	<?php echo $desorganizacion_p;?>%
VIOLENCIA EN LA FAMILIA(*)	<?php echo $violencia_p;?>%
TABAQUISMO PASIVO(*)	<?php echo $tabaquismo_p;?>%
CONSUMO DE ALCOHOL CON REPERCUSIÓN EN LA FAMILIA(*) 	<?php echo $alcohol_p;?>%
CONSUMO DE DROGAS EN PRESENCIA DE LA FAMILIA(*) 	<?php echo $drogas_p;?>%
CUMPLE FUNCIÓN ECONÓMICA	<?php echo $economica_p;?>%
CUMPLE FUNCIÓN EDUCATIVA 	<?php echo $educativa_p;?>%
CUMPLE FUNCIÓN AFECTIVA	  <?php echo $afectiva_p;?>%
CUMPLE FUNCIÓN SOCIAL 	<?php echo $social_p;?>% </pre>

	</body>
</html>
