<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");

$iddepartamento = $_GET['iddepartamento'];

$sql_mun = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento' ";
$result_mun = mysqli_query($link,$sql_mun);
$row_mun = mysqli_fetch_array($result_mun);


$sql_t =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar WHERE  estado='CONSOLIDADO' AND iddepartamento='$iddepartamento' ";
$result_t = mysqli_query($link,$sql_t);
$row_t = mysqli_fetch_array($result_t);
$total = $row_t[0];

$sql_a =" SELECT evaluacion_familiar_cf.idcarpeta_familiar FROM evaluacion_familiar_cf, carpeta_familiar  ";
$sql_a.=" WHERE evaluacion_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_a.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' ";
$sql_a.=" AND evaluacion_familiar_cf.determinante_salud='SIN RIESGO EN LAS DETERMINANTES DE LA SALUD' GROUP BY evaluacion_familiar_cf.idcarpeta_familiar ";
$result_a = mysqli_query($link,$sql_a);
$sin_riesgo = mysqli_num_rows($result_a);

$sql_b =" SELECT evaluacion_familiar_cf.idcarpeta_familiar FROM evaluacion_familiar_cf, carpeta_familiar ";
$sql_b.=" WHERE evaluacion_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_b.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' ";
$sql_b.=" AND evaluacion_familiar_cf.determinante_salud='RIESGO LEVE EN LAS DETERMINANTES DE LA SALUD' GROUP BY evaluacion_familiar_cf.idcarpeta_familiar ";
$result_b = mysqli_query($link,$sql_b);
$riesgo_leve = mysqli_num_rows($result_b);

$sql_c =" SELECT evaluacion_familiar_cf.idcarpeta_familiar FROM evaluacion_familiar_cf, carpeta_familiar ";
$sql_c.=" WHERE evaluacion_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_c.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' ";
$sql_c.=" AND evaluacion_familiar_cf.determinante_salud='RIESGO MODERADO EN LAS DETERMINANTES DE LA SALUD' GROUP BY evaluacion_familiar_cf.idcarpeta_familiar ";
$result_c = mysqli_query($link,$sql_c);
$riesgo_moderado = mysqli_num_rows($result_c);

$sql_d =" SELECT evaluacion_familiar_cf.idcarpeta_familiar FROM evaluacion_familiar_cf, carpeta_familiar ";
$sql_d.=" WHERE evaluacion_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_d.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' ";
$sql_d.=" AND evaluacion_familiar_cf.determinante_salud='RIESGO GRAVE EN LAS DETERMINANTES DE LA SALUD' GROUP BY evaluacion_familiar_cf.idcarpeta_familiar ";
$result_d = mysqli_query($link,$sql_d);
$riesgo_grave = mysqli_num_rows($result_d);

$sql_e =" SELECT evaluacion_familiar_cf.idcarpeta_familiar FROM evaluacion_familiar_cf, carpeta_familiar ";
$sql_e.=" WHERE evaluacion_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_e.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' ";
$sql_e.=" AND evaluacion_familiar_cf.determinante_salud='RIESGO MUY GRAVE EN LAS DETERMINANTES DE LA SALUD' GROUP BY evaluacion_familiar_cf.idcarpeta_familiar ";
$result_e = mysqli_query($link,$sql_e);
$riesgo_muy_grave = mysqli_num_rows($result_e);

$sin_riesgo_p    = ($sin_riesgo*100)/$total;
$riesgo_leve_p   = ($riesgo_leve*100)/$total;
$riesgo_moderado_p = ($riesgo_moderado*100)/$total;
$riesgo_grave_p  = ($riesgo_grave*100)/$total;
$riesgo_muy_grave_p = ($riesgo_muy_grave*100)/$total;
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>EVALUACION RIESGO EN LAS DETERMINANTES DE LA SALUD - DEPARTAMENTAL </title>

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
                    text: 'RIESGO EN LAS DETERMINANTES DE LA SALUD - DEPARTAMENTO: <?php echo mb_strtoupper($row_mun[1]);?>'
                },
                subtitle: {
                    text: 'Fuente: Módulo de Carpetas Familiares sistema MEDI-SAFCI'
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
                    name: '% de Familias :',
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
<pre id="tsv" style="display:none">Evaluacion salud	familiar 
SIN RIESGO EN LAS DETERMINANTES DE LA SALUD	  <?php echo $sin_riesgo_p;?>%
RIESGO LEVE EN LAS DETERMINANTES DE LA SALUD	  <?php echo $riesgo_leve_p;?>%
RIESGO MODERADO EN LAS DETERMINANTES DE LA SALUD	<?php echo $riesgo_moderado_p;?>%
RIESGO GRAVE EN LAS DETERMINANTES DE LA SALUD	<?php echo $riesgo_grave_p;?>%
RIESGO MUY GRAVE EN LAS DETERMINANTES DE LA SALUD	<?php echo $riesgo_muy_grave_p;?>%
</pre>

</br>
</br>
<table width="646" border="1" align="center" bordercolor="#009999">
    <tr>
        <td width="21" bgcolor="#FFFFFF" style="font-family: Arial;"><span class="Estilo8 Estilo1 Estilo2" style="font-size: 12px"> N° </span></td>
        <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">EVALUACIÓN DE LAS DETERMINANTES DE LA SALUD</span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">%</span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">CANTIDAD</span></td>
    </tr>

        <tr>
            <td width="21" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;">1</td>
            <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;">FAMILIAS SIN RIESGO</td>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo number_format($sin_riesgo_p, 2, '.', '');?></td>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $sin_riesgo;?></td>
        </tr> 
        <tr>
            <td width="21" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;">2</td>
            <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;">FAMILIAS CON RIESGO LEVE</td>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo number_format($riesgo_leve_p, 2, '.', '');?></td>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $riesgo_leve;?></td>
        </tr> 
        <tr>
            <td width="21" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;">3</td>
            <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;">FAMILIAS CON RIESGO MODERADO</td>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo number_format($riesgo_moderado_p, 2, '.', '');?></td>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $riesgo_moderado;?></td>
        </tr> 
        <tr>
            <td width="21" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;">3</td>
            <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;">FAMILIAS CON RIESGO GRAVE</td>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo number_format($riesgo_grave_p, 2, '.', '');?></td>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $riesgo_grave;?></td>
        </tr> 
        <tr>
            <td width="21" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;">3</td>
            <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;">FAMILIAS CON RIESGO MUY GRAVE</td>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo number_format($riesgo_muy_grave_p, 2, '.', '');?></td>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $riesgo_muy_grave;?></td>
        </tr> 
    </table>

    <?php
$sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND iddepartamento='$iddepartamento'  ";
$result_cf = mysqli_query($link,$sql_cf);
$row_cf = mysqli_fetch_array($result_cf);  
$total_cf = $row_cf[0];
?>

<span style="font-family: Arial; font-size: 12px;"><h4 align="center">TOTAL DE CARPETAS FAMILIARES DEPARTAMENTO = <?php echo $total_cf;?> </h4></spam>

<?php
$sql_p = " SELECT idmunicipio FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND iddepartamento='$iddepartamento' GROUP BY idmunicipio  ";
$result_p = mysqli_query($link,$sql_p);
$municipios = mysqli_num_rows($result_p);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE MUNICIPIOS DEL DEPARTAMENTO= <?php echo $municipios;?> </h4></spam>

<?php
$sql_mun =" SELECT idestablecimiento_salud FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND iddepartamento='$iddepartamento' GROUP BY idestablecimiento_salud ";
$result_mun = mysqli_query($link,$sql_mun);
$establecimientos = mysqli_num_rows($result_mun);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE ESTABLECIMIENTOS DE SALUD EN EL DEPARTAMENTO = <?php echo $establecimientos;?> </h4></spam>

<?php
$sql_int =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_int.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' ";
$result_int = mysqli_query($link,$sql_int);
$row_int = mysqli_fetch_array($result_int);  
$integrantes = $row_int[0];
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE INTEGRANTES DE FAMILIA REGISTRADOS EN EL DEPARTAMENTO= <?php echo $integrantes;?> </h4></spam>

<?php
$sql_per = " SELECT idusuario FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND iddepartamento='$iddepartamento' GROUP BY idusuario  ";
$result_per = mysqli_query($link,$sql_per);
$personal = mysqli_num_rows($result_per);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE PERSONAL SAFCI EN EL DEPARTAMENTO = <?php echo $personal;?> </h4></spam>


	</body>
</html>
