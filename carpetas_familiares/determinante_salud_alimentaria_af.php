<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$idarea_influencia = $_GET['idarea_influencia'];

$sql_area = " SELECT area_influencia.idarea_influencia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia FROM area_influencia, tipo_area_influencia ";
$sql_area.= " WHERE area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND area_influencia.idarea_influencia='$idarea_influencia' ";
$result_area = mysqli_query($link,$sql_area);
$row_area = mysqli_fetch_array($result_area);
$area_af = $row_area[1]." ".$row_area[2];

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>SALUD ALIMENTARIA CF - ÁREA DE INFLUENCIA</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#consumo_alimentos').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Durante los últimos tres meses, por falta de dinero u otros factores hubo algún momento en el que:'
        },
        subtitle: {
            text: 'Fuente: REGISTRO SISTEMA MEDI-SAFCI - ÁREA DE INFLUENCIA: <?php echo mb_strtoupper($area_af);?> '
        },
        xAxis: {
            categories: [

                <?php 
$numero = 0;
$sql = " SELECT iditem_determinante_salud, item_determinante_salud FROM item_determinante_salud WHERE iddeterminante_salud='4' AND idcat_determinante_salud='19' ";
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
                text: 'Encuenta para grados de seguridad alimentaria'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}  Familias</b></td></tr>',
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
$sql2 = " SELECT determinante_salud_cf.valor_cf FROM determinante_salud_cf, carpeta_familiar ";
$sql2.= " WHERE determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql2.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idarea_influencia='$idarea_influencia' ";
$sql2.= " AND determinante_salud_cf.iddeterminante_salud='4' AND determinante_salud_cf.idcat_determinante_salud='19'  ";
$sql2.= " GROUP BY determinante_salud_cf.valor_cf ";
$result2 = mysqli_query($link,$sql2);
$total2 = mysqli_num_rows($result2);
 if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
	?>

{ name: '<?php  if ($row2[0] == '1') { echo "SI"; } else { echo "NO"; }?>',

    data: [
<?php 
$numero3 = 0;
$sql3 = " SELECT iditem_determinante_salud, item_determinante_salud FROM item_determinante_salud WHERE iddeterminante_salud='4' AND idcat_determinante_salud='19' ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
 if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
	?>

<?php
$sql_a =" SELECT count(determinante_salud_cf.valor_cf) FROM determinante_salud_cf, carpeta_familiar ";
$sql_a.=" WHERE determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_a.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idarea_influencia='$idarea_influencia' ";
$sql_a.=" AND determinante_salud_cf.iddeterminante_salud='4' AND determinante_salud_cf.idcat_determinante_salud='19' ";
$sql_a.=" AND determinante_salud_cf.iditem_determinante_salud='$row3[0]' AND determinante_salud_cf.valor_cf='$row2[0]' ";
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

<script type="text/javascript">
$(function () {
    $('#consumo_diario_alimentos').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'b) Consumo diario de alimentos - ÁREA DE INFLUENCIA: <?php echo mb_strtoupper($area_af);?>'
        },
        subtitle: {
            text: 'Fuente: REGISTRO SISTEMA MEDI-SAFCI'
        },
        xAxis: {
            categories: [

                <?php 
$numero = 0;
$sql = " SELECT iditem_determinante_salud, item_determinante_salud FROM item_determinante_salud WHERE iddeterminante_salud='4' AND idcat_determinante_salud='21' ";
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
                text: 'Consumo diario de alimentos'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}  Familias</b></td></tr>',
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
$sql2 = " SELECT determinante_salud_cf.valor_cf FROM determinante_salud_cf, carpeta_familiar ";
$sql2.= " WHERE determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql2.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idarea_influencia='$idarea_influencia' ";
$sql2.= " AND determinante_salud_cf.iddeterminante_salud='4' AND determinante_salud_cf.idcat_determinante_salud='21'  ";
$sql2.= " GROUP BY determinante_salud_cf.valor_cf ";
$result2 = mysqli_query($link,$sql2);
$total2 = mysqli_num_rows($result2);
 if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
	?>

{ name: '<?php  if ($row2[0] == '1') { echo "SI"; } else { echo "NO"; }?>',

    data: [
<?php 
$numero3 = 0;
$sql3 = " SELECT iditem_determinante_salud, item_determinante_salud FROM item_determinante_salud WHERE iddeterminante_salud='4' AND idcat_determinante_salud='21' ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
 if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
	?>

<?php
$sql_a =" SELECT count(determinante_salud_cf.valor_cf) FROM determinante_salud_cf, carpeta_familiar ";
$sql_a.=" WHERE determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_a.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idarea_influencia='$idarea_influencia' ";
$sql_a.=" AND determinante_salud_cf.iddeterminante_salud='4' AND determinante_salud_cf.idcat_determinante_salud='21' ";
$sql_a.=" AND determinante_salud_cf.iditem_determinante_salud='$row3[0]' AND determinante_salud_cf.valor_cf='$row2[0]' ";
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

<div id="consumo_alimentos" style="min-width: 410px; height: 400px; margin: 0 auto"></div>
<div id="consumo_diario_alimentos" style="min-width: 410px; height: 400px; margin: 0 auto"></div>

	</body>
</html>