<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");

$num_alimentaria_sin = 0;
$num_alimentaria_leve = 0;
$num_alimentaria_moderado = 0;
$num_alimentaria_grave = 0;
$num_alimentaria_muy_grave = 0;

            $num_total=0;
            $sql =" SELECT idcarpeta_familiar FROM determinante_salud_cf GROUP BY idcarpeta_familiar";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {
                 
/************ Evaluamos para cada detrminante de la salud  BEGIN ************/
       
$sqld = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$row[0]' AND iddeterminante_salud='4' AND idcat_determinante_salud='19' ";
$resultd = mysqli_query($link,$sqld);
$rowd = mysqli_fetch_array($resultd);
$durante = $rowd[0];

if ($durante == '0' || $durante == '') {
   $grado_alimentario = '1';
} else {
    if ($durante <= 3) {
        $grado_alimentario = '3';
    } else {
        if ($durante <= 5) {
            $grado_alimentario = '4';
        } else {
            if ($durante >= 6) {
                $grado_alimentario = '5';
            } else {  } } } }                                                           

$sqlcon = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$row[0]' AND iddeterminante_salud='4' AND idcat_determinante_salud='21' ";
$resultcon = mysqli_query($link,$sqlcon);
$rowcon = mysqli_fetch_array($resultcon);
$consumo = $rowcon[0];

$alimentaria = $grado_alimentario + $consumo;

if ($alimentaria <= 7) {

    $num_alimentaria_sin = $num_alimentaria_sin + 1;

} else {
    if ($alimentaria <= 13) {

        $num_alimentaria_leve = $num_alimentaria_leve + 1;

    } else {
        if ($alimentaria <= 21) {

            $num_alimentaria_moderado = $num_alimentaria_moderado + 1;
            
        } else {
            if ($alimentaria <= 30) {

                $num_alimentaria_grave = $num_alimentaria_grave + 1;

            } else { 
                if ($alimentaria <= 35) {

                    $num_alimentaria_muy_grave = $num_alimentaria_muy_grave + 1;

                } else {  } } } } }    
       
/************ Evaluamos para cada detrminante de la salud  END  ************/
                
                $num_total=$num_total+1;
            }
            while ($row = mysqli_fetch_array($result));
            } else {
            }

                $num_alimentaria_sin_p       = ($num_alimentaria_sin*100)/$num_total;
                $num_alimentaria_leve_p      = ($num_alimentaria_leve*100)/$num_total;
                $num_alimentaria_moderado_p  = ($num_alimentaria_moderado*100)/$num_total;
                $num_alimentaria_grave_p     = ($num_alimentaria_grave*100)/$num_total;
                $num_alimentaria_muy_grave_p = ($num_alimentaria_muy_grave*100)/$num_total;
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>RIESGO DE LA SALUD ALIMENTARIA</title>

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
                    text: 'RIESGO DE LA SALUD ALIMENTARIA - NIVEL NACIONAL'
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
SIN RIESGO	  <?php echo $num_alimentaria_sin_p;?>%
RIESGO LEVE	  <?php echo $num_alimentaria_leve_p;?>%
RIESGO MODERADO 	<?php echo $num_alimentaria_moderado_p;?>%
RIESGO GRAVE	<?php echo $num_alimentaria_grave_p;?>%
RIESGO MUY GRAVE 	<?php echo $num_alimentaria_muy_grave_p;?>%
</pre>

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
