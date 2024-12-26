<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>SEGUIMIENTO CARPETAS FAMILIARES - NIVEL NACIONAL</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
        ${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'SEGUIMIENTO DE CARPETAS FAMILIARES - NIVEL NACIONAL'
        },
        subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-SAFCI al <?php echo $f_emision;?>'
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
            name: 'Porcentaje',
            data: [
                <?php
                    $sql0 = " SELECT COUNT(idcarpeta_familiar) FROM carpeta_familiar WHERE gestion='$gestion'  ";
                    $result0 = mysqli_query($link,$sql0);
                    $row0 = mysqli_fetch_array($result0);
                    $total = $row0[0];

                    $sql_t    = " SELECT COUNT(idcarpeta_familiar) FROM carpeta_familiar WHERE gestion='$gestion' AND estado='CONSOLIDADO' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t    = mysqli_fetch_array($result_t);

                    $consolidado = $row_t[0];
                    $pendiente = $total - $consolidado;

                    $p_consolidado   = ($consolidado*100)/$total;
                    $porcentaje_consolidado    = number_format($p_consolidado, 2, '.', '');

                    $p_pendiente   = ($pendiente*100)/$total;
                    $porcentaje_pendiente    = number_format($p_pendiente, 2, '.', '');

                    ?>

                    ['CONSOLIDADO', <?php echo $porcentaje_consolidado;?>], ['EN PROCESO DE LLENADO', <?php echo $porcentaje_pendiente;?>]


                    ]
        }]
    });
});
		</script>
	</head>
	<body>
<span style="font-size: 12px"></span><span style="font-family: Arial"></span><span style="font-size: 12px"></span><span style="font-size: 12px"></span>
<script src="../js/highcharts.js"></script>
<script src="../js/highcharts-3d.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="height: 400px"></div>

<table width="768" border="1" align="center" bordercolor="#009999">

    <tr>
        <td width="20" align="center" bgcolor="#FFFFFF" class="Estilo8 Estilo1 Estilo2" style="font-family: Arial; font-size: 12px;"> N° </td>
        <td width="100" align="center" bgcolor="#FFFFFF" class="Estilo8 Estilo1 Estilo2" style="font-family: Arial; font-size: 12px;">CARPETAS CONSOLIDADAS</td>
        <td width="100" align="center" bgcolor="#FFFFFF" class="Estilo7" style="font-family: Arial; font-size: 12px;">CARPETAS EN PROCESO DE LLENADO</td>
        <td width="100" align="center" bgcolor="#FFFFFF" class="Estilo7" style="font-family: Arial; font-size: 12px;">TOTAL DE CARPETAS CREADAS</td>
        <td width="100" align="center" bgcolor="#FFFFFF" class="Estilo7" style="font-family: Arial; font-size: 12px;">% DE AVANCE</td>
    </tr>

        <tr>
          <td align="center" bgcolor="#FFFFFF" class="Estilo8 Estilo1 Estilo2">1</td>
          <td align="center" bgcolor="#FFFFFF" class="Estilo8 Estilo1 Estilo2">
          <a href="detalle_consolidado_cf.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=700,scrollbars=YES,top=50,left=200'); return false;"><?php echo $consolidado;?></a>   
          </td>
          <td align="center" bgcolor="#FFFFFF" class="Estilo7">          
          <a href="detalle_pendiente_cf.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=700,scrollbars=YES,top=50,left=200'); return false;"><?php echo $pendiente;?></a>           
          </td>
          <td align="center" bgcolor="#FFFFFF" class="Estilo7"><?php echo $total;?></td>
          <td align="center" bgcolor="#FFFFFF" class="Estilo7"><?php echo $porcentaje_consolidado;?> %</td>
        </tr>   
       
    </table>

    <?php
$sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar WHERE estado='CONSOLIDADO'  ";
$result_cf = mysqli_query($link,$sql_cf);
$row_cf = mysqli_fetch_array($result_cf);  
$total_cf = $row_cf[0];
?>

<span style="font-family: Arial; font-size: 12px;"><h4 align="center">TOTAL DE CARPETAS FAMILIARES = <?php echo $total_cf;?> </h4></spam>

<?php
$sql_p = " SELECT idmunicipio FROM carpeta_familiar WHERE estado='CONSOLIDADO' GROUP BY idmunicipio  ";
$result_p = mysqli_query($link,$sql_p);
$municipios = mysqli_num_rows($result_p);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE MUNICIPIOS = <?php echo $municipios;?> </h4></spam>

<?php
$sql_mun =" SELECT idestablecimiento_salud FROM carpeta_familiar WHERE estado='CONSOLIDADO' GROUP BY idestablecimiento_salud ";
$result_mun = mysqli_query($link,$sql_mun);
$establecimientos = mysqli_num_rows($result_mun);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE ESTABLECIMIENTOS DE SALUD = <?php echo $establecimientos;?> </h4></spam>

<?php
$sql_int =" SELECT count(idintegrante_cf) FROM integrante_cf WHERE estado='CONSOLIDADO' ";
$result_int = mysqli_query($link,$sql_int);
$row_int = mysqli_fetch_array($result_int);  
$integrantes = $row_int[0];
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE INTEGRANTES DE FAMILIA REGISTRADOS = <?php echo $integrantes;?> </h4></spam>

<?php
$sql_per = " SELECT idusuario FROM carpeta_familiar WHERE estado='CONSOLIDADO' GROUP BY idusuario ";
$result_per = mysqli_query($link,$sql_per);
$personal = mysqli_num_rows($result_per);  

?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE PERSONAL SAFCI REGISTRADOR = <?php echo $personal;?> </h4></spam>

	</body>
</html>