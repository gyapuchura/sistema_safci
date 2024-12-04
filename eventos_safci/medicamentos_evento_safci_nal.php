<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");


$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

?> 
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>MEDICAMENTOS ENTREGADOS NIVEL NACIONAL</title>

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
            text: 'TRATAMIENTOS EMITIDOS - NIVEL NACIONAL'
        },
        subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-SAFCI al <?php echo $f_emision;?>'
        },
        xAxis: {
            categories: [
              
                <?php 
                    $numero = 0;
                    $sql = " SELECT tratamiento.idtipo_medicamento,tipo_medicamento.tipo_medicamento FROM tratamiento, tipo_medicamento WHERE tratamiento.idtipo_medicamento=tipo_medicamento.idtipo_medicamento "; // DEMICAMENTO EN FUNCION DE TIPO DE MEDICAMENTO
                    $sql.= " AND tratamiento.entregado_farmacia='SI' GROUP BY tratamiento.idtipo_medicamento ";
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
                text: ' Medicamento ',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' Unidades'
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

            <?php 
$numero2 = 0;

$sql2 = " SELECT tratamiento.idmedicamento, medicamento.medicamento FROM tratamiento, medicamento WHERE tratamiento.idmedicamento=medicamento.idmedicamento ";
$sql2.= " AND tratamiento.entregado_farmacia='SI' GROUP BY tratamiento.idmedicamento, medicamento.medicamento ";
$result2 = mysqli_query($link,$sql2);
$total2 = mysqli_num_rows($result2);
 if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
	?>

{ name: '<?php  echo $row2[1]; ?>',

    data: [
<?php 
$numero3 = 0;

$sql3 = " SELECT tratamiento.idtipo_medicamento FROM tratamiento, tipo_medicamento WHERE tratamiento.idtipo_medicamento=tipo_medicamento.idtipo_medicamento "; // DEMICAMENTO EN FUNCION DE TIPO DE MEDICAMENTO
$sql3.= " AND tratamiento.entregado_farmacia='SI' GROUP BY tratamiento.idtipo_medicamento ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
 if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
	?>

<?php
$sql_a =" SELECT count(idmedicamento) FROM tratamiento WHERE idtipo_medicamento='$row3[0]' AND idmedicamento='$row2[0]'";
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
]}
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


]});
});
		</script>
	</head>
	<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>
<script src="../js/modules/drilldown.js"></script>

<div id="container" style="min-width: 310px; max-width: 850px; height: <?php echo $numero2*250;?>px; margin: 0 auto"></div>

<span style="font-family: Arial; font-size: 14px;"><h4 align="center">N° de Medicamentos Empleados = <?php echo $numero2;?></h4></spam>
<span style="font-family: Arial; font-size: 14px;"><h4 align="center">Tipos de Medicamentos = <?php echo $numero3;?></h4></spam>



</body>
</html>