<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>FUNCIONALIDAD FAMILIAR - NIVEL NACIONAL</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
        ${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'EVALUACION FUNCIONALIDAD FAMILIAR - NIVEL NACIONAL'
        },
        subtitle: {
            text: 'Fuente: Sistema Medi-Safci al <?php echo $f_emision;?>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Porcentaje',
            data: [
                <?php
                    $sql0 = " SELECT funcionalidad_familiar_cf.idcarpeta_familiar FROM funcionalidad_familiar_cf, funcionalidad_familiar  ";
                    $sql0.= " WHERE funcionalidad_familiar_cf.idfuncionalidad_familiar=funcionalidad_familiar.idfuncionalidad_familiar ";
                    $sql0.= " GROUP BY funcionalidad_familiar_cf.idcarpeta_familiar ";
                    $result0 = mysqli_query($link,$sql0);
                    $total = mysqli_num_rows($result0);

                    $sql_t = " SELECT funcionalidad_familiar_cf.idcarpeta_familiar FROM funcionalidad_familiar_cf, funcionalidad_familiar  ";
                    $sql_t.= " WHERE funcionalidad_familiar_cf.idfuncionalidad_familiar=funcionalidad_familiar.idfuncionalidad_familiar ";
                    $sql_t.= " AND funcionalidad_familiar.funcional='NO' GROUP BY funcionalidad_familiar_cf.idcarpeta_familiar ";
                    $result_t = mysqli_query($link,$sql_t);
                    $disfuncional = mysqli_num_rows($result_t);

                    $funcional = $total - $disfuncional;

                    $p_disfuncional = ($disfuncional*100)/$total;
                    $porcentaje_disfuncional = number_format($p_disfuncional, 2, '.', '');

                    $p_funcional   = ($funcional*100)/$total;
                    $porcentaje_funcional    = number_format($p_funcional, 2, '.', '');
                    ?>

                    ['FUNCIONAL', <?php echo $porcentaje_funcional;?>], ['DISFUNCIONAL', <?php echo $porcentaje_disfuncional;?>]


                    ]
        }]
    });
});
		</script>
	</head>
	<body>
<span style="font-size: 12px"></span><span style="font-family: Arial"></span><span style="font-size: 12px"></span><span style="font-size: 12px"></span>
<script src="../js/highcharts.js"></script>
<script src="../js/highcharts-3d.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="height: 400px"></div>



	</body>
</html>