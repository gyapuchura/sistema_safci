<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idmorbilidad_cf = $_GET['idmorbilidad_cf']; 

$sql_mr = " SELECT idmorbilidad_cf, morbilidad_cf FROM morbilidad_cf WHERE idmorbilidad_cf='$idmorbilidad_cf' ";
$result_mr = mysqli_query($link,$sql_mr);
$row_mr = mysqli_fetch_array($result_mr);
$morbilidad = $row_mr[1];

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>MORBILIDAD EN REDES DE SALUD</title>

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
            text: 'MORBILIDAD : <?php echo $morbilidad;?> - REDES DE SALUD A NIVEL NACIONAL'
        },
        subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-SAFCI al <?php echo $f_emision;?>'
        },
        xAxis: {
            categories: [
                <?php 
$numero = 0;
$sql = " SELECT carpeta_familiar.idred_salud, red_salud.red_salud, count(distinct integrante_morbilidad.idintegrante_cf) as total ";
$sql.= " FROM integrante_morbilidad, carpeta_familiar, red_salud WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql.= " AND carpeta_familiar.idred_salud=red_salud.idred_salud AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='$idmorbilidad_cf' ";
$sql.= " GROUP BY carpeta_familiar.idred_salud ORDER BY total DESC  ";
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
                text: ' Integrantes por Red de Salud',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' integrantes'
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
{
name: 'Integrantes con <?php echo $morbilidad;?>',
data: [
    
    <?php 
$numero3 = 0;
$sql3 = " SELECT carpeta_familiar.idred_salud, red_salud.red_salud, count(distinct integrante_morbilidad.idintegrante_cf) as total ";
$sql3.= " FROM integrante_morbilidad, carpeta_familiar, red_salud WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql3.= " AND carpeta_familiar.idred_salud=red_salud.idred_salud AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='$idmorbilidad_cf' ";
$sql3.= " GROUP BY carpeta_familiar.idred_salud ORDER BY total DESC  ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
?>

<?php  echo $row3[2]; ?>

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

}
?> 

] } ]

    });
});
		</script>
	</head>
	<body>
<script src="../js/grupo_tres.js"></script>
<script src="../js/modules/exporting.js"></script>
<script src="../js/modules/drilldown.js"></script>


<div id="container" style="min-width: 310px; max-width: 850px; height: <?php echo $numero3*60;?>px; margin: 0 auto"></div>

<span style="font-family: Arial; font-size: 14px;"><h4 align="center">N° de Redes de Salud = <?php echo $numero3;?></h4></spam>


	<table width="850" border="1" align="center" cellspacing="0">
	  <tbody>
        <tr>
            <td width="17" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>N°</strong></td>
            <td width="180" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>RED DE SALUD</strong></td>
            <td width="78" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>NÚMERO DE INTEGRANTES </strong></td>
            <td width="52" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>ESTABLECIMIENTOS</strong></td>	
 
        </tr>

    <?php
        $numero2=1;
        $sql2 = " SELECT carpeta_familiar.idred_salud, red_salud.red_salud, count(distinct integrante_morbilidad.idintegrante_cf) as total ";
        $sql2.= " FROM integrante_morbilidad, carpeta_familiar, red_salud WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
        $sql2.= " AND carpeta_familiar.idred_salud=red_salud.idred_salud AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='$idmorbilidad_cf' ";
        $sql2.= " GROUP BY carpeta_familiar.idred_salud ORDER BY total DESC  ";
        $result2 = mysqli_query($link,$sql2);
        if ($row2 = mysqli_fetch_array($result2)){
        mysqli_field_seek($result2,0);
        while ($field2 = mysqli_fetch_field($result2)){
        } do {
        ?>

	    <tr>
        <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $numero2;?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row2[1];?></td>
        
        <td style="font-family: Arial; font-size: 12px; text-align: center;">
            <?php 
            $integrantes_cf = number_format($row2[2], 0, '.', '.');
            echo $integrantes_cf;?>
        </td>
        <td style="font-family: Arial; font-size: 12px; text-align: center;">

              <a href="morbilidad_establecimientos_red.php?idred_salud=<?php echo $row2[0];?>&idmorbilidad_cf=<?php echo $idmorbilidad_cf;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=950,scrollbars=YES,top=60,left=600'); return false;">             
              ESTABLECIMIENTOS</a>


        </td>
        </tr>

        <?php
            $numero2=$numero2+1;  
            }
            while ($row2 = mysqli_fetch_array($result2));
            } else {
            }
            ?>

      </tbody>
    </table>
        </br>

<p>&nbsp;</p>
</body>
</html>
