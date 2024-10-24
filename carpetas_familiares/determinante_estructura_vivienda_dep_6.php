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
		<title>CUARTO PARA COCINAR</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>


<script type="text/javascript">
$(function () {
    $('#cuarto_cocina').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'f) TIENE CUARTO SOLO PARA COCINAR - DPTO. <?php echo mb_strtoupper($row_dep[1]);?>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: '% DE FAMILIAS',
            data: [
                <?php
                    $sql0 = " SELECT count(determinante_salud_cf.iddeterminante_salud_cf) FROM determinante_salud_cf, carpeta_familiar ";
                    $sql0.= " WHERE  determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                    $sql0.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' ";
                    $sql0.= " AND determinante_salud_cf.iddeterminante_salud='2' AND determinante_salud_cf.idcat_determinante_salud='13' ";
                    $result0 = mysqli_query($link,$sql0);
                    $row0 = mysqli_fetch_array($result0);
                    $total = $row0[0];

                    $numero = 0;
                    $sql = " SELECT determinante_salud_cf.iditem_determinante_salud FROM determinante_salud_cf, carpeta_familiar ";
                    $sql.= " WHERE  determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                    $sql.= " AND determinante_salud_cf.iddeterminante_salud='2' AND determinante_salud_cf.idcat_determinante_salud='13' ";
                    $sql.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' GROUP BY determinante_salud_cf.iditem_determinante_salud ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT iditem_determinante_salud, item_determinante_salud FROM item_determinante_salud WHERE iditem_determinante_salud='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c = " SELECT count(determinante_salud_cf.iddeterminante_salud_cf) FROM determinante_salud_cf, carpeta_familiar ";
                    $sql_c.= " WHERE  determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                    $sql_c.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' ";
                    $sql_c.= " AND determinante_salud_cf.iddeterminante_salud='2' AND determinante_salud_cf.idcat_determinante_salud='13' AND determinante_salud_cf.iditem_determinante_salud='$row[0]' ";   
                    $result_c = mysqli_query($link,$sql_c);
                    $row_c = mysqli_fetch_array($result_c);
                    $conteo = $row_c[0];

                    $p_conteo   = ($conteo*100)/$total;
                    $porcentaje    = number_format($p_conteo, 2, '.', '');

                    ?>

                    ['<?php echo $row_t[1];?>', <?php echo $porcentaje;?>]

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
        }]
    });
});
		</script>

</head>
	<body>

<script src="../js/highcharts.js"></script>
<script src="../js/highcharts-3d.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="cuarto_cocina" style="height: 350px"></div>

	</body>
</html>