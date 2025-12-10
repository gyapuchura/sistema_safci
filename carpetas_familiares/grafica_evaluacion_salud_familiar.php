<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>EVALUACION DE SALUD FAMILIAR</title>

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
$sql_t =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar WHERE  estado='CONSOLIDADO' ";
$result_t = mysqli_query($link,$sql_t);
$row_t = mysqli_fetch_array($result_t);
$total = $row_t[0];

$sql_a =" SELECT evaluacion_familiar_cf.idcarpeta_familiar FROM evaluacion_familiar_cf, carpeta_familiar  ";
$sql_a.=" WHERE evaluacion_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_a.=" AND carpeta_familiar.estado='CONSOLIDADO' ";
$sql_a.=" AND evaluacion_familiar_cf.evaluacion_familiar='FAMILIA CON RIESGO BAJO' GROUP BY evaluacion_familiar_cf.idcarpeta_familiar ";
$result_a = mysqli_query($link,$sql_a);
$riesgo_bajo = mysqli_num_rows($result_a);

$sql_b =" SELECT evaluacion_familiar_cf.idcarpeta_familiar FROM evaluacion_familiar_cf, carpeta_familiar ";
$sql_b.=" WHERE evaluacion_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_b.=" AND carpeta_familiar.estado='CONSOLIDADO' ";
$sql_b.=" AND evaluacion_familiar_cf.evaluacion_familiar='FAMILIA CON RIESGO MEDIANO' GROUP BY evaluacion_familiar_cf.idcarpeta_familiar ";
$result_b = mysqli_query($link,$sql_b);
$riesgo_mediano = mysqli_num_rows($result_b);

$sql_c =" SELECT evaluacion_familiar_cf.idcarpeta_familiar FROM evaluacion_familiar_cf, carpeta_familiar ";
$sql_c.=" WHERE evaluacion_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_c.=" AND carpeta_familiar.estado='CONSOLIDADO' ";
$sql_c.=" AND evaluacion_familiar_cf.evaluacion_familiar='FAMILIA CON RIESGO ALTO' GROUP BY evaluacion_familiar_cf.idcarpeta_familiar ";
$result_c = mysqli_query($link,$sql_c);
$riesgo_alto = mysqli_num_rows($result_c);

$riesgo_bajo_p    = ($riesgo_bajo*100)/$total;
$riesgo_mediano_p = ($riesgo_mediano*100)/$total;
$riesgo_alto_p    = ($riesgo_alto*100)/$total;

?>
            $('#container').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'EVALUACIÓN DE LA SALUD FAMILIAR - NIVEL NACIONAL'
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

<table width="646" border="1" align="center" bordercolor="#009999">
    <tr>
        <td width="21" bgcolor="#FFFFFF" style="font-family: Arial;"><span class="Estilo8 Estilo1 Estilo2" style="font-size: 12px"> N° </span></td>
        <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">EVALUACIÓN DE LA SALUD FAMILIAR</span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">%</span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">CANTIDAD</span></td>
    </tr>

        <tr>
            <td width="21" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;">1</td>
            <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;">FAMILIAS CON RIESGO BAJO</td>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo number_format($riesgo_bajo_p, 2, '.', '');?></td>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $riesgo_bajo;?></td>
        </tr> 
        <tr>
            <td width="21" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;">2</td>
            <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;">FAMILIAS CON RIESGO MEDIANO</td>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo number_format($riesgo_mediano_p, 2, '.', '');?></td>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $riesgo_mediano;?></td>
        </tr> 
        <tr>
            <td width="21" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;">3</td>
            <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;">FAMILIAS CON RIESGO ALTO</td>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo number_format($riesgo_alto_p, 2, '.', '');?></td>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $riesgo_alto;?></td>
        </tr> 
    </table>

<?php
$sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar WHERE estado='CONSOLIDADO'  ";
$result_cf = mysqli_query($link,$sql_cf);
$row_cf = mysqli_fetch_array($result_cf);  
$total_cf = $row_cf[0];
?>

<span style="font-family: Arial; font-size: 12px;"><h4 align="center">TOTAL DE CARPETAS FAMILIARES = <?php echo $total_cf;?> </h4></spam>

<?php
$sql_p = " SELECT idmunicipio FROM ubicacion_cf WHERE ubicacion_actual='SI' GROUP BY idmunicipio ";
$result_p = mysqli_query($link,$sql_p);
$municipios = mysqli_num_rows($result_p);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE MUNICIPIOS = <?php echo $municipios;?> </h4></spam>

<?php
$sql_mun =" SELECT idestablecimiento_salud FROM ubicacion_cf WHERE ubicacion_actual='SI' GROUP BY idestablecimiento_salud ";
$result_mun = mysqli_query($link,$sql_mun);
$establecimientos = mysqli_num_rows($result_mun);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE ESTABLECIMIENTOS DE SALUD = <?php echo $establecimientos;?> </h4></spam>

<?php
$sql_int =" SELECT count(idintegrante_cf) FROM integrante_cf WHERE estado='CONSOLIDADO' ";
$result_int = mysqli_query($link,$sql_int);
$row_int = mysqli_fetch_array($result_int);  
$integrantes = $row_int[0];
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE INTEGRANTES DE FAMILIA REGISTRADOS = <?php echo $integrantes;?> </h4></spam>

<?php
$sql_per = " SELECT idusuario FROM carpeta_familiar WHERE estado='CONSOLIDADO' GROUP BY idusuario ";
$result_per = mysqli_query($link,$sql_per);
$personal = mysqli_num_rows($result_per);  

?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE PERSONAL SAFCI REGISTRADOR = <?php echo $personal;?> </h4></spam>

	</body>
</html>
