<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$inicio = $_GET['inicio'];
$finalizacion = $_GET['finalizacion'];

$fecha_i = explode('-',$inicio);
$f_inicio = $fecha_i[2].'/'.$fecha_i[1].'/'.$fecha_i[0];

$fecha_f = explode('-',$finalizacion);
$f_finalizacion = $fecha_f[2].'/'.$fecha_f[1].'/'.$fecha_f[0];

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>REPORTE TELEMETRIA</title>
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
            text: 'REPORTE ATENCIÓN POR TELEMETRÍA - NIVEL NACIONAL'
        },
            subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-SAFCI del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
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
                    $sql0 = " SELECT idexamen_complementario FROM examen_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idexamen_complementario !='6'  ";
                    $result0 = mysqli_query($link,$sql0);
                    $total = mysqli_num_rows($result0);

                    $numero = 0;
                    $sql = " SELECT idexamen_complementario FROM examen_teleconsulta WHERE idexamen_complementario !='6' AND fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY idexamen_complementario ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT idexamen_complementario, examen_complementario FROM examen_complementario WHERE idexamen_complementario='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c= " SELECT idexamen_complementario FROM examen_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idexamen_complementario ='$row[0]' ";
                    $result_c = mysqli_query($link,$sql_c);
                    $conteo = mysqli_num_rows($result_c);

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

<div id="container" style="height: 400px"></div>

<table width="646" border="1" align="center" bordercolor="#009999">

    <tr>
        <td width="21" bgcolor="#FFFFFF" style="font-family: Arial;"><span class="Estilo8 Estilo1 Estilo2" style="font-size: 12px"> N° </span></td>
        <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">EXAMEN COMPLEMENTARIO</span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">CANTIDAD DE TELEMETRÍAS REALIZADAS</span></td>
        <td width="73" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">  %</span></td>
        <td width="88" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">VER ATENCIONES</span></td>
    </tr>

<?php

$sql_ta = " SELECT idexamen_complementario FROM examen_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idexamen_complementario !='6' ";
$result_ta = mysqli_query($link,$sql_ta);
$total_ta = mysqli_num_rows($result_ta);

$numeroa = 1;
$sqla = " SELECT idexamen_complementario FROM examen_teleconsulta WHERE idexamen_complementario !='6' AND fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY idexamen_complementario ";
$resulta = mysqli_query($link,$sqla);
 if ($rowa = mysqli_fetch_array($resulta)){
mysqli_field_seek($resulta,0);
while ($fielda = mysqli_fetch_field($resulta)){
} do {

$sql_ta = "  SELECT idexamen_complementario, examen_complementario FROM examen_complementario WHERE idexamen_complementario='$rowa[0]'  ";
$result_ta = mysqli_query($link,$sql_ta);
$row_ta = mysqli_fetch_array($result_ta);

$sql_ca = " SELECT idexamen_complementario FROM examen_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idexamen_complementario ='$rowa[0]' ";
$result_ca = mysqli_query($link,$sql_ca);
$conteoa = mysqli_num_rows($result_ca);

$p_conteoa   = ($conteoa*100)/$total_ta;

$porcentajea = number_format($p_conteoa, 2, '.', '');

?>
        <tr>
          <td width="21" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $numeroa;?></td>
          <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row_ta[1];?></td>
          <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $conteoa;?></td>
          <td width="73" bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $porcentajea;?> %</td>
          <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;">
          <a href="atenciones_telemetria_ec.php?idexamen_complementario=<?php echo $rowa[0];?>&inicio=<?php echo $inicio;?>&finalizacion=<?php echo $finalizacion;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=900,left=600,scrollbars=YES,top=50,left=200'); return false;">VER</a>  
        </td>
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
        <tr>
          <td width="21" bgcolor="#FFFFFF"><span class="Estilo8 Estilo1 Estilo2"></span></td>
          <td width="315" bgcolor="#FFFFFF"><span class="Estilo8 Estilo1 Estilo2"></span></td>
          <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $total;?></td>
          <td width="73" bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"> 100 %</td>
          <td bgcolor="#FFFFFF" align="center"></td>
        </tr>
    </table>



 



	</body>
</html>