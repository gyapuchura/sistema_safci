<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$inicio = $_GET['inicio'];
$finalizacion = $_GET['finalizacion'];

$fecha_i = explode('-',$inicio);
$f_inicio = $fecha_i[2].'/'.$fecha_i[1].'/'.$fecha_i[0];

$fecha_f = explode('-',$finalizacion);
$f_finalizacion = $fecha_f[2].'/'.$fecha_f[1].'/'.$fecha_f[0];

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {

    $('#container').highcharts({

        chart: {
            type: 'heatmap',
            marginTop: 100,
            marginBottom: 100
        },


        title: {
            text: 'REPORTE DIAGNÓSTICOS PREVENTIVOS PSAFCI - NACIONAL'
        },
        subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-SAFCI del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
        },
        xAxis: {
            categories: [
                    <?php
    $sql_d = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento != '10' ORDER BY iddepartamento ";
    $result_d = mysqli_query($link,$sql_d);
    if ($row_d = mysqli_fetch_array($result_d)){
    mysqli_field_seek($result_d,0);
    while ($field_d = mysqli_fetch_field($result_d)){
    } do { ?>
        
        '<?php echo $row_d[1];?>',
    <?php                  
    } while ($row_d = mysqli_fetch_array($result_d));
    } else {  }
    ?>
            ]
        },

        yAxis: {
            categories: [
                    <?php 
    $numero = 0;
    $sql = " SELECT diagnostico_psafci.idpatologia, patologia.patologia, patologia.cie FROM diagnostico_psafci, patologia ";
    $sql.= " WHERE diagnostico_psafci.idpatologia=patologia.idpatologia AND cie LIKE '%Z%' ";
    $sql.= " AND diagnostico_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY diagnostico_psafci.idpatologia ORDER BY patologia.patologia DESC";
    $result = mysqli_query($link,$sql);
    $total = mysqli_num_rows($result);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);
    while ($field = mysqli_fetch_field($result)){
    } do {
        ?>
    '<?php  echo $row[1];?> - <?php  echo $row[2];?>'

    <?php 
    $numero++;
    if ($numero == $total) {
    echo "";
    }
    else {
    echo ",";
    }
    } while ($row = mysqli_fetch_array($result));
    } else {
    echo "";
    }
    ?>
            ],
            title: null
        },

        colorAxis: {
            min: 0,
            minColor: '#FFFFFF',
            maxColor: Highcharts.getOptions().colors[0]
        },

        legend: {
            align: 'right',
            layout: 'vertical',
            margin: 0,
            verticalAlign: 'top',
            y: 150,
            symbolHeight: 280
        },

        tooltip: {
            formatter: function () {
                return '<b>' + this.series.xAxis.categories[this.point.x] + '</b> <br><b>' +
                    this.point.value + '</b> Diagnosticos <br><b>' + this.series.yAxis.categories[this.point.y] + '</b>';
            }
        },

        series: [{
            name: 'DIAGNOSTICOS PREVENTIVOS',
            borderWidth: 1,
            data: [
                    <?php
    $numero_d=0;
    $sql_d = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento != '10' ORDER BY iddepartamento ";
    $result_d = mysqli_query($link,$sql_d);
    $total_d = mysqli_num_rows($result_d);
    if ($row_d = mysqli_fetch_array($result_d)){
    mysqli_field_seek($result_d,0);
    while ($field_d = mysqli_fetch_field($result_d)){
    } do { ?>
        
    <?php 
    $numero_p = 0;
    $sql = " SELECT diagnostico_psafci.idpatologia, patologia.patologia, patologia.cie FROM diagnostico_psafci, patologia ";
    $sql.= " WHERE diagnostico_psafci.idpatologia=patologia.idpatologia AND cie LIKE '%Z%' ";
    $sql.= " AND diagnostico_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY diagnostico_psafci.idpatologia ORDER BY patologia.patologia DESC";
    $result = mysqli_query($link,$sql);
    $total = mysqli_num_rows($result);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);
    while ($field = mysqli_fetch_field($result)){
    } do {
                $sql_dg = " SELECT count(diagnostico_psafci.iddiagnostico_psafci) FROM diagnostico_psafci, atencion_psafci ";
                $sql_dg.= " WHERE diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci AND atencion_psafci.iddepartamento='$row_d[0]' ";
                $sql_dg.= " AND diagnostico_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND diagnostico_psafci.idpatologia = '$row[0]' ";
                $result_dg = mysqli_query($link,$sql_dg);
                $row_dg = mysqli_fetch_array($result_dg);
                $diagnosticos = $row_dg[0];
        ?>

            [<?php echo $numero_d;?>,<?php echo $numero_p;?>,<?php echo $diagnosticos;?>]

        <?php 
        $numero_p++;
        if ($numero_p == $total) {
        echo "";
        }
        else {
        echo ",";
        }
        } while ($row = mysqli_fetch_array($result));
        } else {
        echo "";
        }
        ?>   
            
        <?php  
        $numero_d++;    
        if ($numero_d == $total_d) {
        echo "";
        }
        else {
        echo ",";
        }
        } while ($row_d = mysqli_fetch_array($result_d));
        } else {  }
    ?>
            ],
            dataLabels: {
                enabled: true,
                color: '#000000'
            }
        }]

    });
});
		</script>
	</head>
	<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/heatmap.js"></script>
<script src="../js/modules/exporting.js"></script>


<div id="container" style="height: <?php echo $numero_p*50?>px; min-width: 410px; max-width: 1000px; margin: 0 auto"></div>

<h4></h4>

 