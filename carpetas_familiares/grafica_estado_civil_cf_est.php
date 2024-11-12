<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");

$idestablecimiento_salud = $_GET["idestablecimiento_salud"];

$sql_est = " SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud' ";
$result_est = mysqli_query($link,$sql_est);
$row_est = mysqli_fetch_array($result_est);
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ESTADO CIVIL - ESTABLECIMIENTO DE SALUD</title>

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
            text: 'ESTADO CIVIL DE LOS INTEGRANTES DE LA FAMILIA - ESTABLECIMIENTO: <?php echo mb_strtoupper($row_est[1]);?>'
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
                    $sql0 = " SELECT count(integrante_datos_cf.idintegrante_datos_cf) FROM integrante_datos_cf, carpeta_familiar  ";
                    $sql0.= " WHERE integrante_datos_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
                    $sql0.= " AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
                    $result0 = mysqli_query($link,$sql0);
                    $row0 = mysqli_fetch_array($result0);
                    $total = $row0[0];

                    $numero = 0;
                    $sql = " SELECT integrante_datos_cf.idestado_civil FROM integrante_datos_cf, carpeta_familiar ";
                    $sql.= " WHERE  integrante_datos_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
                    $sql.= " AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' GROUP BY integrante_datos_cf.idestado_civil ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);
                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT idestado_civil, estado_civil FROM estado_civil WHERE idestado_civil='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c = " SELECT count(integrante_datos_cf.idintegrante_datos_cf) FROM integrante_datos_cf, carpeta_familiar ";
                    $sql_c.= " WHERE integrante_datos_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
                    $sql_c.= " AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND integrante_datos_cf.idestado_civil='$row[0]' ";
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


<table width="646" border="1" align="center" bordercolor="#009999">
    <tr>
        <td width="21" bgcolor="#FFFFFF" style="font-family: Arial;"><span class="Estilo8 Estilo1 Estilo2" style="font-size: 12px"> N° </span></td>
        <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">ESTADO CIVIL</span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">%</span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">CANTIDAD DE INTEGRANTES</span></td>
    </tr>

<?php
$numeroa = 1;
$sqla = " SELECT integrante_datos_cf.idestado_civil, estado_civil.estado_civil FROM integrante_datos_cf, estado_civil, carpeta_familiar WHERE integrante_datos_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sqla.= " AND integrante_datos_cf.idestado_civil=estado_civil.idestado_civil AND carpeta_familiar.estado='CONSOLIDADO' ";
$sqla.= " AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' GROUP BY integrante_datos_cf.idestado_civil ";
$resulta = mysqli_query($link,$sqla);
 if ($rowa = mysqli_fetch_array($resulta)){
mysqli_field_seek($resulta,0);
while ($fielda = mysqli_fetch_field($resulta)){
} do {

    $sql_c = " SELECT count(integrante_datos_cf.idintegrante_datos_cf) FROM integrante_datos_cf, carpeta_familiar ";
    $sql_c.= " WHERE integrante_datos_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
    $sql_c.= " AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND integrante_datos_cf.idestado_civil='$rowa[0]' ";
    $result_c = mysqli_query($link,$sql_c);
    $row_c = mysqli_fetch_array($result_c);
    $conteoa = $row_c[0];

    $p_conteoa   = ($conteoa*100)/$total;
    $porcentajea    = number_format($p_conteoa, 2, '.', '');
?>
        <tr>
          <td width="21" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $numeroa;?></td>
          <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $rowa[1];?></td>
          <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $porcentajea;?></td>
          <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $conteoa;?></td>
        </tr>   
        <?php
        $numeroa=$numeroa+1;
} while ($rowa = mysqli_fetch_array($resulta));
} else {
/*
Si no se encontraron resultados
*/
}
?>
    </table>

<span style="font-family: Arial; font-size: 12px;"><h4 align="center">INTEGRANTES CON REGISTRO - ESTADO CIVIL = <?php echo $total;?> </h4></spam>


	</body>
</html>
