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

$num_estructura_sin = 0;
$num_estructura_leve = 0;
$num_estructura_moderado = 0;
$num_estructura_grave = 0;
$num_estructura_muy_grave = 0;

            $num_total=0;
            $sql = " SELECT determinante_salud_cf.idcarpeta_familiar FROM determinante_salud_cf, ubicacion_cf, carpeta_familiar ";
            $sql.= " WHERE determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
            $sql.= " AND ubicacion_cf.ubicacion_actual='SI' AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.iddepartamento='$iddepartamento' ";
            $sql.= " GROUP BY determinante_salud_cf.idcarpeta_familiar ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {
                 
/************ Evaluamos para cada detrminante de la salud  BEGIN ************/
       
        $sqla = " SELECT sum(determinante_salud_cf.valor_cf)  FROM determinante_salud_cf, ubicacion_cf, carpeta_familiar ";
        $sqla.= " WHERE determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
        $sqla.= " AND ubicacion_cf.ubicacion_actual='SI' AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.iddepartamento='$iddepartamento' ";
        $sqla.= " AND determinante_salud_cf.idcarpeta_familiar='$row[0]' AND determinante_salud_cf.iddeterminante_salud='2'  ";
        $resulta = mysqli_query($link,$sqla);
        $rowa = mysqli_fetch_array($resulta);  
        
        $sumatoria = $rowa[0];
        
        if ($sumatoria <= 16 ) {

            $num_estructura_sin = $num_estructura_sin + 1;

        } else {
            if ($sumatoria <= 31 ) {

                $num_estructura_leve = $num_estructura_leve + 1;                

            } else {
                if ($sumatoria <= 41) {

                    $num_estructura_moderado =  $num_estructura_moderado + 1;

                } else {
                    if ($sumatoria <= 56) {

                        $num_estructura_grave = $num_estructura_grave + 1;                        

                    } else { 
                        if ($sumatoria <= 80) {

                            $num_estructura_muy_grave = $num_estructura_muy_grave + 1;

                        } else {  } } } } } 
       
/************ Evaluamos para cada detrminante de la salud  END  ************/
                
                $num_total=$num_total+1;
            }
            while ($row = mysqli_fetch_array($result));
            } else {
            }

                $num_estructura_sin_p       = ($num_estructura_sin*100)/$num_total;
                $num_estructura_leve_p      = ($num_estructura_leve*100)/$num_total;
                $num_estructura_moderado_p  = ($num_estructura_moderado*100)/$num_total;
                $num_estructura_grave_p     = ($num_estructura_grave*100)/$num_total;
                $num_estructura_muy_grave_p = ($num_estructura_muy_grave*100)/$num_total;

?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>RIESGO EN ESTRUCTURA DE LA VIVIENDA - DEPTO</title>

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
                    text: 'RIESGO ESTRUCTURAL DE LA VIVIENDA  - DPTO. <?php echo mb_strtoupper($row_dep[1]);?>'
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
SIN RIESGO	  <?php echo $num_estructura_sin_p;?>%
RIESGO LEVE	  <?php echo $num_estructura_leve_p;?>%
RIESGO MODERADO 	<?php echo $num_estructura_moderado_p;?>%
RIESGO GRAVE	<?php echo $num_estructura_grave_p;?>%
RIESGO MUY GRAVE 	<?php echo $num_estructura_muy_grave;?>%
</pre>

<?php
$sql_cf =" SELECT count(carpeta_familiar.idcarpeta_familiar) FROM carpeta_familiar, ubicacion_cf ";
$sql_cf.=" WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
$sql_cf.=" AND ubicacion_cf.ubicacion_actual='SI' AND ubicacion_cf.iddepartamento='$iddepartamento' ";
$result_cf = mysqli_query($link,$sql_cf);
$row_cf = mysqli_fetch_array($result_cf);  
$total_cf = $row_cf[0];
?>

<span style="font-family: Arial; font-size: 12px;"><h4 align="center">TOTAL DE CARPETAS FAMILIARES DEPARTAMENTO = <?php echo $total_cf;?> </h4></spam>

<?php
$sql_p = " SELECT ubicacion_cf.idmunicipio FROM carpeta_familiar, ubicacion_cf ";
$sql_p.= " WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
$sql_p.= " AND ubicacion_cf.ubicacion_actual='SI' AND ubicacion_cf.iddepartamento='$iddepartamento' GROUP BY ubicacion_cf.idmunicipio ";
$result_p = mysqli_query($link,$sql_p);
$municipios = mysqli_num_rows($result_p);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE MUNICIPIOS DEL DEPARTAMENTO= <?php echo $municipios;?> </h4></spam>

<?php
$sql_mun =" SELECT ubicacion_cf.idestablecimiento_salud FROM carpeta_familiar, ubicacion_cf ";
$sql_mun.=" WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
$sql_mun.=" AND ubicacion_cf.ubicacion_actual='SI' AND ubicacion_cf.iddepartamento='$iddepartamento' GROUP BY ubicacion_cf.idestablecimiento_salud ";
$result_mun = mysqli_query($link,$sql_mun);
$establecimientos = mysqli_num_rows($result_mun);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE ESTABLECIMIENTOS DE SALUD EN EL DEPARTAMENTO = <?php echo $establecimientos;?> </h4></spam>

<?php
$sql_int =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar, ubicacion_cf  ";
$sql_int.=" WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_int.=" AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO'  ";
$sql_int.=" AND integrante_cf.estado='CONSOLIDADO' AND ubicacion_cf.iddepartamento='$iddepartamento' ";
$result_int = mysqli_query($link,$sql_int);
$row_int = mysqli_fetch_array($result_int);  
$integrantes = $row_int[0];
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE INTEGRANTES DE FAMILIA REGISTRADOS EN EL DEPARTAMENTO= <?php echo $integrantes;?> </h4></spam>

<?php
$sql_per = " SELECT carpeta_familiar.idusuario FROM carpeta_familiar, ubicacion_cf WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_per.= " AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.iddepartamento='$iddepartamento' GROUP BY carpeta_familiar.idusuario ";
$result_per = mysqli_query($link,$sql_per);
$personal = mysqli_num_rows($result_per);  

?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE PERSONAL SAFCI EN EL DEPARTAMENTO = <?php echo $personal;?> </h4></spam>

	</body>
</html>