<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");

$iddepartamento = $_GET['iddepartamento'];

$sql_dep = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento' ";
$result_dep = mysqli_query($link,$sql_dep);
$row_dep = mysqli_fetch_array($result_dep);


    $num_servicios_sin = 0;
    $num_servicios_leve = 0;
    $num_servicios_moderado = 0;
    $num_servicios_grave = 0;
    $num_servicios_muy_grave = 0;

            $num_total=0;
            $sql = " SELECT determinante_salud_cf.idcarpeta_familiar FROM determinante_salud_cf, carpeta_familiar ";
            $sql.= " WHERE determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
            $sql.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' ";
            $sql.= " GROUP BY determinante_salud_cf.idcarpeta_familiar ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {
                 
/************ Evaluamos para cada detrminante de la salud  BEGIN ************/
       
        $sqla = " SELECT sum(determinante_salud_cf.valor_cf)  FROM determinante_salud_cf, carpeta_familiar ";
        $sqla.= " WHERE determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
        $sqla.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' ";
        $sqla.= " AND determinante_salud_cf.idcarpeta_familiar='$row[0]' AND determinante_salud_cf.iddeterminante_salud='1'  ";
        $resulta = mysqli_query($link,$sqla);
        $rowa = mysqli_fetch_array($resulta);  
        
        $sumatoria = $rowa[0];
        
            if ($sumatoria <= 7 ) {

                $num_servicios_sin =  $num_servicios_sin + 1;

            } else {
                if ($sumatoria <= 11 ) {

                    $num_servicios_leve = $num_servicios_leve + 1;

                } else {
                    if ($sumatoria <= 17) {

                        $num_servicios_moderado = $num_servicios_moderado + 1;

                    } else {
                        if ($sumatoria <= 24) {

                            $num_servicios_grave = $num_servicios_grave + 1;

                        } else { 
                            if ($sumatoria <= 35) {

                                $num_servicios_muy_grave = $num_servicios_muy_grave + 1;

                            } else {  } } } } }    
       
/************ Evaluamos para cada detrminante de la salud  END  ************/
                
                $num_total=$num_total+1;
            }
            while ($row = mysqli_fetch_array($result));
            } else {
            }

                $num_servicios_sin_p       = ($num_servicios_sin*100)/$num_total;
                $num_servicios_leve_p      = ($num_servicios_leve*100)/$num_total;
                $num_servicios_moderado_p  = ($num_servicios_moderado*100)/$num_total;
                $num_servicios_grave_p     = ($num_servicios_grave*100)/$num_total;
                $num_servicios_muy_grave_p = ($num_servicios_muy_grave*100)/$num_total;
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>EVALUACION DE SERVICIOS BASICOS - DEPTAL </title>

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
                    text: 'RIESGO EN LOS SERVICIOS BÁSICOS - DPTO. <?php echo mb_strtoupper($row_dep[1]);?>'
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
SIN RIESGO	  <?php echo $num_servicios_sin_p;?>%
RIESGO LEVE	  <?php echo $num_servicios_leve_p;?>%
RIESGO MODERADO 	<?php echo $num_servicios_moderado_p;?>%
RIESGO GRAVE	<?php echo $num_servicios_grave_p;?>%
RIESGO MUY GRAVE 	<?php echo $num_servicios_muy_grave_p;?>%
</pre>




	</body>
</html>
