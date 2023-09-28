<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>

		<script type="text/javascript" src="jquery.min.js"></script>
		<style type="text/css">
#container {
	height: 400px;
	min-width: 310px;
	max-width: 800px;
	margin: 0 auto;
}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({

        chart: {
            type: 'column',
            options3d: {
                enabled: true,
                alpha: 15,
                beta: 15,
                viewDistance: 25,
                depth: 40
            },
            marginTop: 80,
            marginRight: 40
        },

        title: {
            text: 'NÚMERO DE ESTABLECIMIENTOS DE SALUD SEGÚN TIPO, TODOS LOS SUBSECTORES BOLIVIA'
        },

        xAxis: {
            categories: [
<?php
$numero = 0;
$sql = " SELECT idtipo_establecimiento, tipo_establecimiento FROM tipo_establecimiento ORDER BY idtipo_establecimiento ";
$result = mysqli_query($link,$sql);
$conteo_tipo = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
?>

'<?php echo $row[1];?>'

        <?php
        $numero++;
        if ($numero == $conteo_tipo) {
        echo "";
        }
        else {
        echo ",";
        }
        
} while ($row = mysqli_fetch_array($result));
} else {
/*
Si no se encontraron resultados
*/
}
?>
]
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Número de Establecimientos de Salud'
            }
        },

        tooltip: {
            headerFormat: '<b>{point.key}</b><br>',
            pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y} / {point.stackTotal}'
        },

        plotOptions: {
            column: {
                stacking: 'normal',
                depth: 40
            }
        },

        series: [
            {
            name: 'ESTABLECIMIENTOS',
            data: [
                <?php
$numero = 0;
$sql = " SELECT idtipo_establecimiento, tipo_establecimiento FROM tipo_establecimiento ORDER BY idtipo_establecimiento ";
$result = mysqli_query($link,$sql);
$conteo_tipo = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {

    $sql_c= " SELECT idestablecimiento_salud, idtipo_establecimiento FROM establecimiento_salud WHERE idtipo_establecimiento='$row[0]'  ";
    $result_c = mysqli_query($link,$sql_c);
    $conteo = mysqli_num_rows($result_c);

?>

<?php echo $conteo;?>

        <?php
        $numero++;
        if ($numero == $conteo_tipo) {
        echo "";
        }
        else {
        echo ",";
        }
        
} while ($row = mysqli_fetch_array($result));
} else {
/*
Si no se encontraron resultados
*/
}
?>
            ],
            stack: 'male'
        }
    ]
    });
});


		</script>
	</head>
	<body>

<script src="../js/highcharts.js"></script>
<script src="../js/highcharts-3d.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="height: 500px"></div>

</br>
	</body>
</html>
