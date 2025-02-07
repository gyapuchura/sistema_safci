<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");
$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$idestablecimiento_salud = $_GET['idestablecimiento_salud'];

$sql_mun = " SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud' ";
$result_mun = mysqli_query($link,$sql_mun);
$row_mun = mysqli_fetch_array($result_mun);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ESTRUCTURA FAMILIAR ESTABLECIMIENTO DE SALUD</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>

		<script type="text/javascript">
$(function () {
    $('#suministro_agua').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true, 
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'ESTRUCTURA FAMILIAR - Establecimiento: <?php echo mb_strtoupper($row_mun[1]);?>'
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
                    $sql0 = " SELECT count(estructura_familiar_cf.idestructura_familiar_cf) FROM estructura_familiar_cf, carpeta_familiar ";
                    $sql0.= " WHERE estructura_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
                    $sql0.= " AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND estructura_familiar_cf.vigente='SI' ";
                    $result0 = mysqli_query($link,$sql0);
                    $row0 = mysqli_fetch_array($result0);
                    $total = $row0[0];

                    $numero = 0;
                    $sql = " SELECT estructura_familiar_cf.idestructura_familiar FROM estructura_familiar_cf, carpeta_familiar ";
                    $sql.= " WHERE estructura_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
                    $sql.= " AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND estructura_familiar_cf.vigente='SI' GROUP BY estructura_familiar_cf.idestructura_familiar ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT idestructura_familiar, estructura_familiar FROM estructura_familiar WHERE idestructura_familiar='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c = " SELECT count(estructura_familiar_cf.idestructura_familiar_cf) FROM estructura_familiar_cf, carpeta_familiar ";
                    $sql_c.= " WHERE estructura_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
                    $sql_c.= " AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND estructura_familiar_cf.vigente='SI' AND estructura_familiar_cf.idestructura_familiar='$row[0]' ";
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

<div id="suministro_agua" style="height: 350px"></div>

<table width="646" border="1" align="center" bordercolor="#009999">
    <tr>
        <td width="21" bgcolor="#FFFFFF" style="font-family: Arial;"><span class="Estilo8 Estilo1 Estilo2" style="font-size: 12px"> N° </span></td>
        <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">ESTRUCTURA FAMILIAR</span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">%</span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">CANTIDAD</span></td>
    </tr>
<?php
                    $numero = 1;
                    $sql = " SELECT estructura_familiar_cf.idestructura_familiar FROM estructura_familiar_cf, carpeta_familiar ";
                    $sql.= " WHERE estructura_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
                    $sql.= " AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND estructura_familiar_cf.vigente='SI' GROUP BY estructura_familiar_cf.idestructura_familiar ";
                    $result = mysqli_query($link,$sql);
                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT idestructura_familiar, estructura_familiar FROM estructura_familiar WHERE idestructura_familiar='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c = " SELECT count(estructura_familiar_cf.idestructura_familiar_cf) FROM estructura_familiar_cf, carpeta_familiar ";
                    $sql_c.= " WHERE estructura_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
                    $sql_c.= " AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND estructura_familiar_cf.vigente='SI' AND estructura_familiar_cf.idestructura_familiar='$row[0]' ";

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

                    <span style="font-family: Arial; font-size: 12px;"><h4 align="center">FAMILIAS CON REGISTRO DE ESTRUCTURA FAMILIAR = <?php echo $total;?></h4></spam>

	</body>
</html>
