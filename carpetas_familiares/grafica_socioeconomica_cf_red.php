<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$idred_salud = $_GET['idred_salud'];

$sql_red = " SELECT idred_salud, red_salud FROM red_salud WHERE idred_salud='$idred_salud' ";
$result_red = mysqli_query($link,$sql_red);
$row_red = mysqli_fetch_array($result_red);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>CARACTERISTICAS SOCIOECONOMICAS RED DE SALUD</title>

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
            text: 'CARACTERÍSTICAS SOCIOECONÓMICAS - Red de Salud: <?php echo mb_strtoupper($row_red[1]);?>'
        },
        subtitle: {
            text: 'Fuente: Sistema Medi-Safci al <?php echo $f_emision;?>'
        },
        xAxis: {
            categories: [

                <?php 
$numero = 0;
$sql = " SELECT idsocio_economica, socio_economica FROM socio_economica ORDER BY idsocio_economica ";
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
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'SOCIOECONÓMICAS'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} FAMILIAS </b></td></tr>',
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


            <?php 
$numero2 = 0;
$sql2 = " SELECT socio_economica_cf.valor FROM socio_economica_cf, carpeta_familiar, ubicacion_cf ";
$sql2.= " WHERE socio_economica_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
$sql2.= " AND ubicacion_cf.ubicacion_actual='SI' AND ubicacion_cf.idred_salud='$idred_salud' GROUP BY socio_economica_cf.valor ";
$result2 = mysqli_query($link,$sql2);
$total2 = mysqli_num_rows($result2);
 if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
	?>

{ name: '<?php  echo $row2[0]; ?>',

    data: [
<?php 
$numero3 = 0;
$sql3 = " SELECT idsocio_economica, socio_economica FROM socio_economica ORDER BY idsocio_economica ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
 if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
	?>
 
<?php
$sql_a =" SELECT COUNT(socio_economica_cf.valor) FROM socio_economica_cf, carpeta_familiar, ubicacion_cf  ";
$sql_a.=" WHERE socio_economica_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
$sql_a.=" AND ubicacion_cf.ubicacion_actual='SI' AND ubicacion_cf.idred_salud='$idred_salud' ";
$sql_a.=" AND socio_economica_cf.idsocio_economica='$row3[0]' AND socio_economica_cf.valor='$row2[0]' ";
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

<?php 
$numero2++;
if ($numero2 == $total2) {
echo "";
}
else {
echo ",";
}
} while ($row2 = mysqli_fetch_array($result2));
} else {
echo "";
/*
Si no se encontraron resultados
*/
}
?>
    
    ]
    });
});
		</script>
	</head>
	<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="min-width: 410px; height: 400px; margin: 0 auto"></div>

<?php
$sql_cf =" SELECT count(carpeta_familiar.idcarpeta_familiar) FROM carpeta_familiar, ubicacion_cf ";
$sql_cf.=" WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
$sql_cf.=" AND ubicacion_cf.ubicacion_actual='SI' AND ubicacion_cf.idred_salud='$idred_salud' ";
$result_cf = mysqli_query($link,$sql_cf);
$row_cf = mysqli_fetch_array($result_cf);  
$total_cf = $row_cf[0];
?>

<span style="font-family: Arial; font-size: 12px;"><h4 align="center">TOTAL DE CARPETAS FAMILIARES EN LA RED DE SALUD = <?php echo $total_cf;?> </h4></spam>

<?php
$sql_red =" SELECT ubicacion_cf.idestablecimiento_salud FROM carpeta_familiar, ubicacion_cf ";
$sql_red.=" WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
$sql_red.=" AND ubicacion_cf.ubicacion_actual='SI' AND ubicacion_cf.idred_salud='$idred_salud' GROUP BY ubicacion_cf.idestablecimiento_salud ";
$result_red = mysqli_query($link,$sql_red);
$establecimientos = mysqli_num_rows($result_red);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE ESTABLECIMIENTOS DE SALUD EN LA RED DE SALUD = <?php echo $establecimientos;?> </h4></spam>

<?php
$sql_int =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar, ubicacion_cf  ";
$sql_int.=" WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_int.=" AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO'  ";
$sql_int.=" AND integrante_cf.estado='CONSOLIDADO' AND ubicacion_cf.idred_salud='$idred_salud' ";
$result_int = mysqli_query($link,$sql_int);
$row_int = mysqli_fetch_array($result_int);  
$integrantes = $row_int[0];
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE INTEGRANTES DE FAMILIA REGISTRADOS EN LA RED DE SALUD= <?php echo $integrantes;?> </h4></spam>

<?php
$sql_per = " SELECT carpeta_familiar.idusuario FROM carpeta_familiar, ubicacion_cf WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_per.= " AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.idred_salud='$idred_salud' GROUP BY carpeta_familiar.idusuario ";
$result_per = mysqli_query($link,$sql_per);
$personal = mysqli_num_rows($result_per);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE PERSONAL SAFCI EN LA RED DE SALUD = <?php echo $personal;?></h4></spam>

	</body>
</html>