<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$idtipo_medicamento = $_GET['idtipo_medicamento'];

$sql_tm = " SELECT idtipo_medicamento, tipo_medicamento FROM tipo_medicamento WHERE idtipo_medicamento='$idtipo_medicamento' ";
$result_tm = mysqli_query($link,$sql_tm);
$row_tm = mysqli_fetch_array($result_tm);
$tipo_medicamento = $row_tm[1];

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>MEDICAMENTOS - NACIONAL</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'REPORTE DE MEDICAMENTOS ENTREGADOS - TIPO : <?php  echo strtoupper($tipo_medicamento);?>'
        },
        subtitle: {
            text: 'Fuente: REGISTRO SISTEMA MEDI-SAFCI'
        },
        xAxis: {
            categories: [

                <?php 
$numero = 0;
$sql = " SELECT tratamiento.idmedicamento, medicamento.medicamento FROM medicamento, tratamiento ";
$sql.= " WHERE tratamiento.idmedicamento=medicamento.idmedicamento AND tratamiento.idtipo_medicamento='$idtipo_medicamento' GROUP BY tratamiento.idmedicamento "; 
$result = mysqli_query($link,$sql);
$total = mysqli_num_rows($result);
 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>
 '<?php  echo strtoupper($row[1]);?>'

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
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'CANTIDAD DE MEDICAMENTOS'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} Unidades </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [


{ name: 'Cantidad de Medicamentos Entregados',

    data: [
<?php 
$numero3 = 0;
$sql3 = " SELECT tratamiento.idmedicamento, medicamento.medicamento FROM medicamento, tratamiento ";
$sql3.= " WHERE tratamiento.idmedicamento=medicamento.idmedicamento AND tratamiento.idtipo_medicamento='$idtipo_medicamento' GROUP BY tratamiento.idmedicamento ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
 if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
	?>
 
<?php
$sql_a =" SELECT count(idtratamiento) FROM tratamiento WHERE idmedicamento='$row3[0]' AND idtipo_medicamento='$idtipo_medicamento' AND entregado_farmacia='SI' ";
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
}
?>

        ]
}

    
    ]
    });
});
		</script>
	</head>
	<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="min-width: 400px; height: 420px; margin: 0 auto"></div>

<table width="646" border="1" align="center" bordercolor="#009999">

    <tr>
        <td width="21" bgcolor="#FFFFFF" style="font-family: Arial;"><span class="Estilo8 Estilo1 Estilo2" style="font-size: 12px"> N° </span></td>
        <td width="215" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">MEDICAMENTO</span></td>
        <td width="215" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">CANTIDAD</span></td>
        <td width="188" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">VER</span></td>
    </tr>

<?php
$numeroa = 1;
$sqla = " SELECT tratamiento.idmedicamento, medicamento.medicamento FROM medicamento, tratamiento ";
$sqla.= " WHERE tratamiento.idmedicamento=medicamento.idmedicamento AND tratamiento.idtipo_medicamento='$idtipo_medicamento' GROUP BY tratamiento.idmedicamento ";
$resulta = mysqli_query($link,$sqla);
 if ($rowa = mysqli_fetch_array($resulta)){
mysqli_field_seek($resulta,0);
while ($fielda = mysqli_fetch_field($resulta)){
} do {

    $sql_ac =" SELECT count(idtratamiento) FROM tratamiento WHERE idmedicamento='$rowa[0]' AND tratamiento.idtipo_medicamento='$idtipo_medicamento' AND entregado_farmacia='SI' ";
    $result_ac = mysqli_query($link,$sql_ac);
    $row_ac = mysqli_fetch_array($result_ac);
?>
        <tr>
          <td width="21" bgcolor="#FFFFFF"><span class="Estilo8 Estilo1 Estilo2"> <?php echo $numeroa;?> </span></td>
          <td width="315" bgcolor="#FFFFFF"><span class="Estilo8 Estilo1 Estilo2"> <?php echo strtoupper($rowa[1]);?> </span></td>
          <td bgcolor="#FFFFFF" align="center"><span class="Estilo7"> <?php echo $row_ac[0];?> </span></td>
          <td bgcolor="#FFFFFF" align="center">

          <a href="detalle_tratamientos_safci.php?idmedicamento=<?php echo $rowa[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=700,scrollbars=YES,top=50,left=200'); return false;">TRATAMIENTOS</a>  

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
 <!--   <tr>
          <td width="21" bgcolor="#FFFFFF"><span class="Estilo8 Estilo1 Estilo2"></span></td>
          <td width="315" bgcolor="#FFFFFF"><span class="Estilo8 Estilo1 Estilo2"></span></td>
          <td bgcolor="#FFFFFF" align="center"><span class="Estilo7"><?php echo $total;?></span></td>
          <td width="73" bgcolor="#FFFFFF" align="center"><span class="Estilo7"> 100 %</span></td>
          <td bgcolor="#FFFFFF" align="center"><span class="Estilo7"></span></td>
        </tr> --->
    </table>
	</body>
</html>