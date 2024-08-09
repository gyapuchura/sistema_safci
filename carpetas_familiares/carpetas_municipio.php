<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$iddepartamento = $_GET['iddepartamento'];

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
            text: 'Fuente: Sistema Integrado MEDI-SAFCI al <?php echo $f_emision;?>'
        },
        xAxis: {
            categories: [
                <?php 
$numero = 0;
$sql = " SELECT ubicacion_cf.idmunicipio, municipios.municipio FROM ubicacion_cf, municipios, carpeta_familiar WHERE ubicacion_cf.idmunicipio=municipios.idmunicipio ";
$sql.= " AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idmunicipio=municipios.idmunicipio  ";
$sql.= " AND ubicacion_cf.iddepartamento='4' GROUP BY ubicacion_cf.idmunicipio ORDER BY ubicacion_cf.idmunicipio ";
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
                text: ' Carpetas Familiares por Municipio ',
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
$sql3 = " SELECT ubicacion_cf.idmunicipio FROM ubicacion_cf, municipios, carpeta_familiar WHERE ubicacion_cf.idmunicipio=municipios.idmunicipio ";
$sql3.= " AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
$sql3.= " AND ubicacion_cf.iddepartamento='$iddepartamento' GROUP BY ubicacion_cf.idmunicipio ORDER BY ubicacion_cf.idmunicipio  ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {

$sql4 = " SELECT count(carpeta_familiar.idcarpeta_familiar) FROM ubicacion_cf, carpeta_familiar  ";
$sql4.= " WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql4.= " AND ubicacion_cf.idmunicipio='$row3[0]' AND carpeta_familiar.estado='CONSOLIDADO' ";
$result4 = mysqli_query($link,$sql4);
$row4 = mysqli_fetch_array($result4); 
?>

<?php  echo $row4{0}; ?>

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
$sql3 = " SELECT ubicacion_cf.idmunicipio FROM ubicacion_cf, municipios, carpeta_familiar WHERE ubicacion_cf.idmunicipio=municipios.idmunicipio ";
$sql3.= " AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='' ";
$sql3.= " AND ubicacion_cf.iddepartamento='$iddepartamento' GROUP BY ubicacion_cf.idmunicipio ORDER BY ubicacion_cf.idmunicipio  ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {

$sql4 = " SELECT count(carpeta_familiar.idcarpeta_familiar) FROM ubicacion_cf, carpeta_familiar  ";
$sql4.= " WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql4.= " AND ubicacion_cf.idmunicipio='$row3[0]' AND carpeta_familiar.estado='' ";
$result4 = mysqli_query($link,$sql4);
$row4 = mysqli_fetch_array($result4); 
?>

<?php  echo $row4{0}; ?>

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
<div id="container" style="min-width: 310px; max-width: 850px; height: 600px; margin: 0 auto"></div>

<p>&nbsp;</p>
</body>
</html>
