<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

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
		<title>ESTRUCTURA VIVIENDA - ÁREA DE INFLUENCIA</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>

<script type="text/javascript">
$(function () {
    $('#techo_vivienda').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'b) TECHO DE LA VIVIENDA - ÁREA DE INFLUENCIA: <?php echo mb_strtoupper($area_af);?>'
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
            name: '% DE FAMILIAS',
            data: [
                <?php
                    $sql0 = " SELECT count(determinante_salud_cf.iddeterminante_salud_cf) FROM determinante_salud_cf, carpeta_familiar ";
                    $sql0.= " WHERE  determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql0.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idarea_influencia='$idarea_influencia' ";
                    $sql0.= " AND determinante_salud_cf.iddeterminante_salud='2' AND determinante_salud_cf.idcat_determinante_salud='9' ";
                    $result0 = mysqli_query($link,$sql0);
                    $row0 = mysqli_fetch_array($result0);
                    $total = $row0[0];

                    $numero = 0;
                    $sql = " SELECT determinante_salud_cf.iditem_determinante_salud FROM determinante_salud_cf, carpeta_familiar ";
                    $sql.= " WHERE  determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql.= " AND determinante_salud_cf.iddeterminante_salud='2' AND determinante_salud_cf.idcat_determinante_salud='9' ";
                    $sql.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idarea_influencia='$idarea_influencia' GROUP BY determinante_salud_cf.iditem_determinante_salud ";
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
                    $sql_c.= " WHERE  determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql_c.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idarea_influencia='$idarea_influencia' ";
                    $sql_c.= " AND determinante_salud_cf.iddeterminante_salud='2' AND determinante_salud_cf.idcat_determinante_salud='9' AND determinante_salud_cf.iditem_determinante_salud='$row[0]' ";
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

<div id="techo_vivienda" style="height: 350px"></div>

<table width="646" border="1" align="center" bordercolor="#009999">
    <tr>
        <td width="21" bgcolor="#FFFFFF" style="font-family: Arial;"><span class="Estilo8 Estilo1 Estilo2" style="font-size: 12px"> N° </span></td>
        <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">TECHO DE LA VIVIENDA</span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">%</span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">CANTIDAD</span></td>
    </tr>
<?php
                    $numero = 1;
                    $sql = " SELECT determinante_salud_cf.iditem_determinante_salud FROM determinante_salud_cf, carpeta_familiar ";
                    $sql.= " WHERE  determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql.= " AND determinante_salud_cf.iddeterminante_salud='2' AND determinante_salud_cf.idcat_determinante_salud='9' ";
                    $sql.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idarea_influencia='$idarea_influencia' GROUP BY determinante_salud_cf.iditem_determinante_salud ";
                    $result = mysqli_query($link,$sql);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT iditem_determinante_salud, item_determinante_salud FROM item_determinante_salud WHERE iditem_determinante_salud='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c = " SELECT count(determinante_salud_cf.iddeterminante_salud_cf) FROM determinante_salud_cf, carpeta_familiar ";
                    $sql_c.= " WHERE  determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql_c.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idarea_influencia='$idarea_influencia' ";
                    $sql_c.= " AND determinante_salud_cf.iddeterminante_salud='2' AND determinante_salud_cf.idcat_determinante_salud='9' AND determinante_salud_cf.iditem_determinante_salud='$row[0]' ";
                    $result_c = mysqli_query($link,$sql_c);
                    $row_c = mysqli_fetch_array($result_c);
                    $conteo = $row_c[0];

                    $p_conteo   = ($conteo*100)/$total;
                    $porcentaje    = number_format($p_conteo, 2, '.', '');

                    ?>
                        <tr>
                            <td width="21" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $numero;?></td>
                            <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row_t[1];?></td>
                            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $porcentaje;?></td>
                            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $conteo;?></td>
                            </tr> 

                        <?php
                        $numero++;                    
                    } while ($row = mysqli_fetch_array($result));
                    } else {
                    /*
                    Si no se encontraron resultados
                    */
                    }
                    ?>
                    </table>

                    <span style="font-family: Arial; font-size: 12px;"><h4 align="center">FAMILIAS CON REGISTRO DE DETERMINANTES DE SALUD = <?php echo $total;?></h4></spam>

	</body>
</html>
