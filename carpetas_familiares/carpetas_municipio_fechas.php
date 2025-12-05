<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$iddepartamento = $_GET['iddepartamento'];
$inicio       = $_GET['inicio'];
$finalizacion = $_GET['finalizacion'];


$fecha_i = explode('-',$inicio);
$f_inicio = $fecha_i[2].'/'.$fecha_i[1].'/'.$fecha_i[0];

$fecha_f = explode('-',$finalizacion);
$f_finalizacion = $fecha_f[2].'/'.$fecha_f[1].'/'.$fecha_f[0];

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
		<title>CARPETAS FAMILIARES POR MUNCIIPIO</title>

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
            text: 'Carpetas Familiares por Municipios - Departamento de <?php echo mb_strtoupper($row_dep[1]);?>'
        },
        subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-SAFCI del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
        },
        xAxis: {
            categories: [
                <?php 
$numero = 0;
$sql = " SELECT carpeta_familiar.idmunicipio, municipios.municipio FROM municipios, carpeta_familiar WHERE carpeta_familiar.idmunicipio=municipios.idmunicipio ";
$sql.= " AND carpeta_familiar.iddepartamento='$iddepartamento' AND carpeta_familiar.fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY carpeta_familiar.idmunicipio ORDER BY carpeta_familiar.idmunicipio ";
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
                text: ' Carpetas Familiares por Municipio del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?> ',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' Carpetas Familiares'
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
name: 'Carpetas CONSOLIDADAS',
data: [
    
    <?php 
$numero3 = 0;
$sql3 = " SELECT carpeta_familiar.idmunicipio FROM municipios, carpeta_familiar WHERE carpeta_familiar.idmunicipio=municipios.idmunicipio ";
$sql3.= " AND carpeta_familiar.iddepartamento='$iddepartamento' AND carpeta_familiar.fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY carpeta_familiar.idmunicipio ORDER BY carpeta_familiar.idmunicipio  ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {

$sql4 = " SELECT count(idcarpeta_familiar) FROM carpeta_familiar WHERE idmunicipio='$row3[0]' AND estado='CONSOLIDADO' AND fecha_registro BETWEEN '$inicio' AND '$finalizacion'";
$result4 = mysqli_query($link,$sql4);
$row4 = mysqli_fetch_array($result4); 
?>

<?php  echo $row4[0]; ?>

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
?> ] }
,
{
name: 'Carpetas SIN CONSOLIDAR',
data: [
    
    <?php 
$numero3 = 0;
$sql3 = " SELECT carpeta_familiar.idmunicipio FROM municipios, carpeta_familiar WHERE carpeta_familiar.idmunicipio=municipios.idmunicipio ";
$sql3.= " AND carpeta_familiar.iddepartamento='$iddepartamento' AND carpeta_familiar.fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY carpeta_familiar.idmunicipio ORDER BY carpeta_familiar.idmunicipio  ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {

$sql4 = " SELECT count(idcarpeta_familiar) FROM carpeta_familiar WHERE idmunicipio='$row3[0]' AND estado='' AND fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
$result4 = mysqli_query($link,$sql4);
$row4 = mysqli_fetch_array($result4); 
?>

<?php  echo $row4[0]; ?>

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
?>  ]}]

    });
});
		</script>
	</head>
	<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>
<script src="../js/modules/drilldown.js"></script>

<div id="container" style="min-width: 310px; max-width: 850px; height: <?php echo $numero3*60;?>px; margin: 0 auto"></div>

<span style="font-family: Arial; font-size: 14px;"><h4 align="center">N° de Municipios = <?php echo $numero3;?></h4></spam>

<p>&nbsp;</p>
</body>
</html>