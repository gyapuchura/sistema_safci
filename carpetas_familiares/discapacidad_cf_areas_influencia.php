<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$idestablecimiento_salud = $_GET['idestablecimiento_salud']; 
$idnivel_discapacidad_cf = $_GET['idnivel_discapacidad_cf']; 
$idtipo_discapacidad_cf  = $_GET['idtipo_discapacidad_cf']; 

$sql_est = " SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud' ";
$result_est = mysqli_query($link,$sql_est);
$row_est = mysqli_fetch_array($result_est);

$sql_n = " SELECT idnivel_discapacidad_cf, nivel_discapacidad_cf FROM nivel_discapacidad_cf WHERE idnivel_discapacidad_cf='$idnivel_discapacidad_cf' ";
$result_n = mysqli_query($link,$sql_n);
$row_n = mysqli_fetch_array($result_n);
$nivel = $row_n[1];

$sql_t = " SELECT idtipo_discapacidad_cf, tipo_discapacidad_cf FROM tipo_discapacidad_cf WHERE idtipo_discapacidad_cf='$idtipo_discapacidad_cf' ";
$result_t = mysqli_query($link,$sql_t);
$row_t = mysqli_fetch_array($result_t);
$tipo_dis = $row_t[1];

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>DISCAPACIDAD POR ESTABLECIMIENTOS</title>

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
            text: 'DISCAPACIDAD - <?php echo $tipo_dis;?> <?php echo $nivel;?> - ESTABLECIMIENTOS DEL ESTABLECIMIENTO DE SALUD DE <?php echo mb_strtoupper($row_est[1]);?>'
        },
        subtitle: {
            text: 'Fuente: REGISTRO SISTEMA MEDI-SAFCI'
        },
        xAxis: {
            categories: [

                <?php 
$numero = 0;
$sql = " SELECT carpeta_familiar.idestablecimiento_salud, establecimiento_salud.establecimiento_salud FROM integrante_discapacidad, carpeta_familiar, establecimiento_salud ";
$sql.= " WHERE integrante_discapacidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql.= " AND carpeta_familiar.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND carpeta_familiar.estado='CONSOLIDADO' ";
$sql.= " AND integrante_discapacidad.idtipo_discapacidad_cf='$idtipo_discapacidad_cf' AND integrante_discapacidad.idnivel_discapacidad_cf='$idnivel_discapacidad_cf' ";
$sql.= " AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' GROUP BY carpeta_familiar.idestablecimiento_salud ";
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
                text: 'N° INTEGRANTES CON DISCAPACIDAD'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} N° INTEGRANTES CON DISCAPACIDAD</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [


{ name: '<?php echo $tipo_dis." ".$nivel;?>',

    data: [
<?php 
$numero3 = 0;
$sql3 = " SELECT carpeta_familiar.idestablecimiento_salud FROM integrante_discapacidad, carpeta_familiar ";
$sql3.= " WHERE integrante_discapacidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql3.= " AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_discapacidad.idtipo_discapacidad_cf='$idtipo_discapacidad_cf' ";
$sql3.= " AND integrante_discapacidad.idnivel_discapacidad_cf='$idnivel_discapacidad_cf' ";
$sql3.= " AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' GROUP BY carpeta_familiar.idestablecimiento_salud  ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
 if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
	?>
 
<?php
$sql_a =" SELECT COUNT(integrante_discapacidad.idintegrante_discapacidad) FROM integrante_discapacidad, carpeta_familiar WHERE integrante_discapacidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_a.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_discapacidad.idnivel_discapacidad_cf='$idnivel_discapacidad_cf' ";
$sql_a.=" AND integrante_discapacidad.idtipo_discapacidad_cf='$idtipo_discapacidad_cf' AND carpeta_familiar.idestablecimiento_salud='$row3[0]' ";
$result_a = mysqli_query($link,$sql_a);
$row_a = mysqli_fetch_array($result_a);
?>
<?php echo $row_a[0]; ?>
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
/*
Si no se encontraron resultados
*/
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

<div id="container" style="min-width: 410px; height: 400px; margin: 0 auto"></div>

	</body>
</html>