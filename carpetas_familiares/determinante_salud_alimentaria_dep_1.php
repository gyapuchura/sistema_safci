<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");

$iddepartamento = $_GET['iddepartamento'];

$sql_dep = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento' ";
$result_dep = mysqli_query($link,$sql_dep);
$row_dep = mysqli_fetch_array($result_dep);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>SEGURIDAD ALIMENTARIA</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>

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
            text: 'Fuente: REGISTRO SISTEMA MEDI-SAFCI'
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
$sql2.= " WHERE determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql2.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' ";
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
$sql_a.=" WHERE determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_a.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' ";
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

</head>
	<body>

<script src="../js/highcharts.js"></script>
<script src="../js/highcharts-3d.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="consumo_alimentos" style="min-width: 410px; height: 400px; margin: 0 auto"></div>

<?php
$sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND iddepartamento='$iddepartamento'  ";
$result_cf = mysqli_query($link,$sql_cf);
$row_cf = mysqli_fetch_array($result_cf);  
$total_cf = $row_cf[0];
?>

<span style="font-family: Arial; font-size: 12px;"><h4 align="center">TOTAL DE CARPETAS FAMILIARES DEPARTAMENTO = <?php echo $total_cf;?> </h4></spam>

<?php
$sql_p = " SELECT idmunicipio FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND iddepartamento='$iddepartamento' GROUP BY idmunicipio  ";
$result_p = mysqli_query($link,$sql_p);
$municipios = mysqli_num_rows($result_p);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE MUNICIPIOS DEL DEPARTAMENTO= <?php echo $municipios;?> </h4></spam>

<?php
$sql_mun =" SELECT idestablecimiento_salud FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND iddepartamento='$iddepartamento' GROUP BY idestablecimiento_salud ";
$result_mun = mysqli_query($link,$sql_mun);
$establecimientos = mysqli_num_rows($result_mun);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE ESTABLECIMIENTOS DE SALUD EN EL DEPARTAMENTO = <?php echo $establecimientos;?> </h4></spam>

<?php
$sql_int =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_int.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' ";
$result_int = mysqli_query($link,$sql_int);
$row_int = mysqli_fetch_array($result_int);  
$integrantes = $row_int[0];
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE INTEGRANTES DE FAMILIA REGISTRADOS EN EL DEPARTAMENTO= <?php echo $integrantes;?> </h4></spam>

<?php
$sql_per = " SELECT idusuario FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND iddepartamento='$iddepartamento' GROUP BY idusuario  ";
$result_per = mysqli_query($link,$sql_per);
$personal = mysqli_num_rows($result_per);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE PERSONAL SAFCI EN EL DEPARTAMENTO = <?php echo $personal;?> </h4></spam>

	</body>
</html>