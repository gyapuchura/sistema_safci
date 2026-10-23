<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

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
		<title>ATENCIONES PREVENTIVAS - DEPARTAMENTOS</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'ATENCIONES PREVENTIVAS - NACIONAL'
        },
        subtitle: {
            text: 'Fuente: REGISTRO SISTEMA MEDI-SAFCI'
        },
        xAxis: {
            categories: [

                <?php 
$numero = 0;
$sql = " SELECT d.iddepartamento, d.departamento, COUNT(i.iddiagnostico_psafci) as total  ";
$sql.= " FROM diagnostico_psafci i, departamento d, atencion_psafci a, patologia p ";
$sql.= " WHERE d.iddepartamento=a.iddepartamento AND i.idatencion_psafci=a.idatencion_psafci AND i.idpatologia=p.idpatologia ";
$sql.= " AND p.cie LIKE '%Z%' AND i.fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY d.iddepartamento ORDER BY total DESC  ";
$result = mysqli_query($link,$sql);
$total = mysqli_num_rows($result);
 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

 '<?php  echo $row[1];?>'

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
/*
Si no se encontraron resultados
*/
}
?>
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'ATENCIONES PREVENTIVAS'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} ATENCIONES </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: { enabled: true } 
            }
         
        },
        series: [


{ name: 'Atenciones Preventivas',

    data: [
<?php 
$numero3 = 0;
$sql3 = " SELECT d.iddepartamento, d.departamento, COUNT(i.iddiagnostico_psafci) as total  ";
$sql3.= " FROM diagnostico_psafci i, departamento d, atencion_psafci a, patologia p ";
$sql3.= " WHERE d.iddepartamento=a.iddepartamento AND i.idatencion_psafci=a.idatencion_psafci AND i.idpatologia=p.idpatologia ";
$sql3.= " AND p.cie LIKE '%Z%' AND i.fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY d.iddepartamento ORDER BY total DESC  ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
 if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
	?>
 
<?php echo $row3[2]; ?>
<?php 
$numero3++;
if ($numero3 == $total3) {
echo "";
}
else {
echo ",";
}
} while ($row3 = mysqli_fetch_array($result3));
} else {
}
?>

        ]
}
  
    ]
    });
});
		</script>
	</head>
	<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="min-width: 400px; height: 420px; margin: 0 auto"></div>

	</body>
</html>