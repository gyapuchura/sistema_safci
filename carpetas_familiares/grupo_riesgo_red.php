<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$iddepartamento      = $_GET['iddepartamento']; //

$sql_dep = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento' ";
$result_dep = mysqli_query($link,$sql_dep);
$row_dep = mysqli_fetch_array($result_dep);

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>FACTORES DE RIESGO POR REDES DE SALUD</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'FACTORES DE RIESGO - REDES DE SALUD DEL DEPARTAMENTO DE <?php echo mb_strtoupper($row_dep[1]);?>'
        },
        subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-SAFCI al <?php echo $f_emision;?>'
        },
        xAxis: {
            categories: [
                <?php 
$numero = 0;
$sql = " SELECT carpeta_familiar.idred_salud, red_salud.red_salud, COUNT(distinct integrante_factor_riesgo.idintegrante_cf) as total  ";
$sql.= " FROM integrante_factor_riesgo, carpeta_familiar, red_salud WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idred_salud=red_salud.idred_salud ";
$sql.= " AND carpeta_familiar.iddepartamento='$iddepartamento' GROUP BY carpeta_familiar.idred_salud ORDER BY total DESC ";
$result = mysqli_query($link,$sql);
$total = mysqli_num_rows($result);
 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>
 '<?php  echo $row[1]; ?>'

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
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: ' Integrantes por Red de Salud',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' integrantes'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
      
        series: [
{
name: 'Integrantes con Factores de Riesgo',
data: [
    
    <?php 
$numero3 = 0;
$sql3 = " SELECT carpeta_familiar.idred_salud, red_salud.red_salud, COUNT(distinct integrante_factor_riesgo.idintegrante_cf) as total  ";
$sql3.= " FROM integrante_factor_riesgo, carpeta_familiar, red_salud WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql3.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idred_salud=red_salud.idred_salud ";
$sql3.= " AND carpeta_familiar.iddepartamento='$iddepartamento' GROUP BY carpeta_familiar.idred_salud ORDER BY total DESC ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {

?>

<?php  echo $row3[2]; ?>

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
echo "";

}
?> 

] } ]

    });
});
		</script>
	</head>
	<body>
<script src="../js/referencia.js"></script>
<script src="../js/modules/exporting.js"></script>
<script src="../js/modules/drilldown.js"></script>


<div id="container" style="min-width: 310px; max-width: 850px; height: <?php echo $numero3*60;?>px; margin: 0 auto"></div>

<span style="font-family: Arial; font-size: 14px;"><h4 align="center">N° de Redes de Saluds = <?php echo $numero3;?></h4></spam>
<p>&nbsp;</p>
</body>
</html>
