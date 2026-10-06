<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram      = date("Ymd");
$fecha          = date("Y-m-d");
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
		<title>DETECCION DEL CANCER - NACIONAL</title>

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
            text: 'ENCUESTA MÉDICA NACIONAL - DETECCIÓN DE CÁNCER EN LA NIÑEZ Y ADOLESCENCIA'
        },
        subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-APS del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
        },
        xAxis: {
            categories: [

                <?php 
$numero = 0;
$sql = " SELECT d.iddepartamento, d.departamento, COUNT(distinct e.idencuesta_psafci) as total FROM encuesta_psafci e, departamento d ";
$sql.= " WHERE e.iddepartamento=d.iddepartamento AND fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
$sql.= " GROUP BY d.iddepartamento ORDER BY total DESC ";
$result = mysqli_query($link,$sql);
$total = mysqli_num_rows($result);
 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>
 '<?php  echo $row[1];?>'

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
                text: 'ENCUESTAS MÉDICAS'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} ENCUESTAS MÉDICAS </b></td></tr>',
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


{ name: 'Nº de Encuestas',

    data: [
<?php 
$numero3 = 0;
$sql3 = " SELECT d.iddepartamento, d.departamento, COUNT(distinct e.idencuesta_psafci) as total FROM encuesta_psafci e, departamento d ";
$sql3.= " WHERE e.iddepartamento=d.iddepartamento AND fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
$sql3.= " GROUP BY d.iddepartamento ORDER BY total DESC ";
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
/*
Si no se encontraron resultados
*/
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


<div id="container" style="min-width: 410px; height: 400px; margin: 0 auto"></div>
<!------------------------------------------------------------------------->
<!--------- clasificacion de riesgos a nivel nacional --- begin ----------->
<!------------------------------------------------------------------------->

<script type="text/javascript">
$(function () {
    $('#riesgo_cancer_nal').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'NIVEL DE RIÉSGO EN CÁNCER DETECTADO - NIVEL NACIONAL'
        },
        subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-APS del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
        },
        xAxis: {
            categories: [

                <?php 
$numero = 0;
$sql = " SELECT iddepartamento, departamento FROM departamento ORDER BY iddepartamento";
$result = mysqli_query($link,$sql);
$total1 = mysqli_num_rows($result);
 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>
 '<?php  echo $row[1]; ?>'

<?php 
$numero++;
if ($numero == $total1) {
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
                text: 'CLASIFICACIÓN RIESGO DE CÁNCER - NIVEL NACIONAL'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} Encuestas médicas </b></td></tr>',
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


            <?php 
$numero2 = 0;
$sql2 = " SELECT idclasificacion_riesgo_cancer, clasificacion_riesgo_cancer FROM clasificacion_riesgo_cancer ORDER BY idclasificacion_riesgo_cancer DESC ";
$result2 = mysqli_query($link,$sql2);
$total2 = mysqli_num_rows($result2);
 if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
	?>

{ name: '<?php  echo $row2[1]; ?>',

    data: [
<?php 
$numero3 = 0;
$sql3 = " SELECT iddepartamento, departamento FROM departamento ORDER BY iddepartamento ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
 if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
	?>

<?php
$sql_a =" SELECT count(idencuesta_psafci) FROM encuesta_psafci WHERE iddepartamento='$row3[0]' AND idclasificacion_riesgo_cancer='$row2[0]' AND fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
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
echo "";
/*
Si no se encontraron resultados
*/
}
?>


        ]
}

<?php 
$numero2++;
if ($numero2 == $total2) {
echo "";
}
else {
echo ",";
}
} while ($row2 = mysqli_fetch_array($result2));
} else {
echo "";
/*
Si no se encontraron resultados
*/
}
?>
    
    ]
    });
});
		</script>

        <h4 align="center" style="font-family: Arial;">Nº ENCUESTAS MÉDICAS PREVENTIVAS: 
<?php
$sql_dgt = " SELECT count(idencuesta_psafci) FROM encuesta_psafci WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
$result_dgt = mysqli_query($link,$sql_dgt);
$row_dgt = mysqli_fetch_array($result_dgt);
echo $row_dgt[0];
?>
</h4>
<h4 align="center" style="font-family: Arial;"> DEL <?php echo $f_inicio;?> AL <?php echo $f_finalizacion;?></h4>

<div id="riesgo_cancer_nal" style="min-width: 410px; height: 400px; margin: 0 auto"></div>

<!------------------------------------------------------------------------->
<!--------- clasificacion de riesgos a nivel nacional --- end ----------->
<!------------------------------------------------------------------------->


<script src="../js/modules/exporting.js"></script>
<script src="../js/salud_integrantes.js"></script>
<script src="../js/modules/data.js"></script>
<script src="../js/modules/drilldown.js"></script>


<table width="800" border="1" align="center" cellspacing="0">
  <tbody>
    <tr>
      <td width="350" bgcolor="#C3EDD7" style="font-family: Arial; font-size: 12px; color: #205332;"><strong>NIVEL DE RIESGO DETECTADO</strong></td>
      <td width="450" bgcolor="#C3EDD7" style="font-family: Arial; font-size: 12px; color: #284A1F; text-align: center;"><strong>DEPARTAMENTOS</strong></td>
    </tr>
    <?php 
$numero2 = 0;
$sql2 = " SELECT idclasificacion_riesgo_cancer, clasificacion_riesgo_cancer FROM clasificacion_riesgo_cancer ORDER BY idclasificacion_riesgo_cancer DESC";
$result2 = mysqli_query($link,$sql2);
$total2 = mysqli_num_rows($result2);
 if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
	?>
    <tr>
      <td bgcolor="#E5F3EC" style="font-family: Arial; font-size: 12px;"><strong>
      <?php  echo $row2[1]; ?>
      <span style="color: #ABEDBF"></span>      <span style="color: #CEE9D7"></span></strong></td>
      <td>
      
      <table width="736" border="0">
        <tbody>
          <tr>
          <?php 
$numero3 = 0;
$sql3 = " SELECT iddepartamento, departamento, sigla FROM departamento WHERE iddepartamento !='10' ORDER BY iddepartamento ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
 if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
	?>
            <td width="138 ">              
              <span style="font-family: Arial; font-size: 12px;">
        <?php
        $sql_a = " SELECT COUNT(idencuesta_psafci) FROM encuesta_psafci WHERE iddepartamento='$row3[0]' ";
        $sql_a.= " AND idclasificacion_riesgo_cancer='$row2[0]' AND fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
        $result_a = mysqli_query($link,$sql_a);
        $row_a = mysqli_fetch_array($result_a);
        ?>
        <?php echo $row3[2]; ?>
				<?php echo ":";?> 
                <?php if ($row_a[0] !='0') { echo $row_a[0]; } else { } ?>

</span></td>

<?php 
$numero3++;
} while ($row3 = mysqli_fetch_array($result3));
} else {
}
?>
          </tr>
        </tbody>
      </table>
        
    </td>
    </tr>
    <?php 
$numero2++;
} while ($row2 = mysqli_fetch_array($result2));
} else {
}
?>
  </tbody>
</table>
</br>




	</body>
</html>