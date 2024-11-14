<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");

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
		<title>SUBSECTOR SALUD FAMILIAR - RED DE SALUD</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>

		<script type="text/javascript">
$(function () {
    $('#corresponde_salud').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'CORRESPONDEN AL SUBSECTOR SALUD - Red de Salud: <?php echo mb_strtoupper($row_red[1]);?>'
        },
        subtitle: {
            text: 'Fuente: Sistema Medi-Safci al <?php echo $f_emision;?>'
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
            name: '% DE INTEGRANTES',
            data: [
                <?php
                    $sql0 = " SELECT count(integrante_subsector_salud.idintegrante_subsector_salud) FROM integrante_subsector_salud, ubicacion_cf, carpeta_familiar ";
                    $sql0.= " WHERE integrante_subsector_salud.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql0.= " AND integrante_subsector_salud.idsubsector_elige='1' AND ubicacion_cf.ubicacion_actual='SI' ";
                    $sql0.= " AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.idred_salud='$idred_salud'  ";
                    $result0 = mysqli_query($link,$sql0);
                    $row0 = mysqli_fetch_array($result0);
                    $total = $row0[0];

                    $numero = 0;
                    $sql = " SELECT integrante_subsector_salud.idsubsector_salud FROM integrante_subsector_salud, ubicacion_cf, carpeta_familiar ";
                    $sql.= " WHERE integrante_subsector_salud.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                    $sql.= " AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.idred_salud='$idred_salud'  ";
                    $sql.= " AND integrante_subsector_salud.idsubsector_elige='1' GROUP BY integrante_subsector_salud.idsubsector_salud ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT idsubsector_salud, subsector_salud FROM subsector_salud WHERE idsubsector_salud='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c = " SELECT count(integrante_subsector_salud.idintegrante_subsector_salud) FROM integrante_subsector_salud, ubicacion_cf, carpeta_familiar ";
                    $sql_c.= " WHERE integrante_subsector_salud.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql_c.= " AND integrante_subsector_salud.idsubsector_elige='1' AND ubicacion_cf.ubicacion_actual='SI' AND integrante_subsector_salud.idsubsector_salud='$row[0]' ";
                    $sql_c.= " AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.idred_salud='$idred_salud' ";
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


<script type="text/javascript">
$(function () {
    $('#asiste_salud').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'ASISTEN AL SUBSECTOR SALUD - Red de Salud: <?php echo mb_strtoupper($row_red[1]);?>'
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
            name: '% DE INTEGRANTES',
            data: [
                <?php
                    $sql0 = " SELECT count(integrante_subsector_salud.idintegrante_subsector_salud) FROM integrante_subsector_salud, ubicacion_cf, carpeta_familiar ";
                    $sql0.= " WHERE integrante_subsector_salud.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql0.= " AND integrante_subsector_salud.idsubsector_elige='2' AND ubicacion_cf.ubicacion_actual='SI' ";
                    $sql0.= " AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.idred_salud='$idred_salud'  ";
                    $result0 = mysqli_query($link,$sql0);
                    $row0 = mysqli_fetch_array($result0);
                    $total = $row0[0];

                    $numero = 0;
                    $sql = " SELECT integrante_subsector_salud.idsubsector_salud FROM integrante_subsector_salud, ubicacion_cf, carpeta_familiar ";
                    $sql.= " WHERE integrante_subsector_salud.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                    $sql.= " AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.idred_salud='$idred_salud'  ";
                    $sql.= " AND integrante_subsector_salud.idsubsector_elige='2' GROUP BY integrante_subsector_salud.idsubsector_salud ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT idsubsector_salud, subsector_salud FROM subsector_salud WHERE idsubsector_salud='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c = " SELECT count(integrante_subsector_salud.idintegrante_subsector_salud) FROM integrante_subsector_salud, ubicacion_cf, carpeta_familiar ";
                    $sql_c.= " WHERE integrante_subsector_salud.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql_c.= " AND integrante_subsector_salud.idsubsector_elige='2' AND ubicacion_cf.ubicacion_actual='SI' AND integrante_subsector_salud.idsubsector_salud='$row[0]' ";
                    $sql_c.= " AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.idred_salud='$idred_salud' ";
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

<div id="corresponde_salud" style="height: 350px"></div>

<div id="asiste_salud" style="height: 350px"></div>

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
