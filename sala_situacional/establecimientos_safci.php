<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ESTABLECIMIENTOS CON PRESENCIA SAFCI</title>

		<script type="text/javascript" src="jquery.min.js"></script>
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
            text: 'ESTABLECIMIENTOS CON PRESENCIA SAFCI A NIVEL NACIONAL'
        },
        subtitle: {
            text: 'Fuente: REPORTE MEDI-SAFCI'
        },
        xAxis: {
            categories: [

                <?php 
$numero = 0;
$sql = " SELECT iddepartamento, departamento FROM departamento ORDER BY iddepartamento";
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
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Cantidad de Establecimientos de Salud'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} Establecimientos de Salud </b></td></tr>',
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
$sql2 = " SELECT establecimiento_salud.idnivel_establecimiento, nivel_establecimiento.nivel_establecimiento  ";
$sql2.= " FROM personal, dato_laboral, establecimiento_salud, nivel_establecimiento WHERE personal.iddato_laboral=dato_laboral.iddato_laboral ";
$sql2.= " AND dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
$sql2.= " AND establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento ";
$sql2.= " GROUP BY establecimiento_salud.idnivel_establecimiento ";
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
$sql_a = " SELECT dato_laboral.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, establecimiento_salud.latitud, establecimiento_salud.longitud ";
$sql_a.= " FROM personal, dato_laboral, establecimiento_salud WHERE personal.iddato_laboral=dato_laboral.iddato_laboral ";
$sql_a.= " AND dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
$sql_a.= " AND dato_laboral.iddepartamento='$row3[0]' AND establecimiento_salud.idnivel_establecimiento='$row2[0]' GROUP BY dato_laboral.idestablecimiento_salud ";
$result_a = mysqli_query($link,$sql_a);
$row_a = mysqli_num_rows($result_a);
?>
<?php echo $row_a; ?>
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
	</head>
	<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="min-width: 410px; height: 400px; margin: 0 auto"></div>

<table width="806" border="1" align="center" cellspacing="0">
  <tbody>
    <tr>
      <td width="58" bgcolor="#C3EDD7" style="font-family: Arial; font-size: 12px; color: #205332;"><strong>NIVEL DEL ESTABLECIMIENTO</strong></td>
      <td width="732" bgcolor="#C3EDD7" style="font-family: Arial; font-size: 12px; color: #284A1F; text-align: center;"><strong>ESTABLECIMIENTOS POR DEPARTAMENTO</strong></td>
    </tr>
    <?php 

$sql4 = " SELECT establecimiento_salud.idnivel_establecimiento, nivel_establecimiento.nivel_establecimiento  ";
$sql4.= " FROM personal, dato_laboral, establecimiento_salud, nivel_establecimiento WHERE personal.iddato_laboral=dato_laboral.iddato_laboral ";
$sql4.= " AND dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud  ";
$sql4.= " AND establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento  ";
$sql4.= " GROUP BY establecimiento_salud.idnivel_establecimiento ";
$result4 = mysqli_query($link,$sql4);
$total4 = mysqli_num_rows($result4);
 if ($row4 = mysqli_fetch_array($result4)){
mysqli_field_seek($result4,0);
while ($field4 = mysqli_fetch_field($result4)){
} do {
	?>
    <tr>
      <td bgcolor="#E5F3EC" style="font-family: Arial; font-size: 12px;"><strong>
      <?php  echo $row4[1]; ?>
      <span style="color: #ABEDBF"></span>      <span style="color: #CEE9D7"></span></strong></td>
      <td>
      
      <table width="736" border="0">
        <tbody>
          <tr>
          <?php 
$numero5 = 0;
$sql5 = " SELECT iddepartamento, sigla FROM departamento ORDER BY iddepartamento";
$result5 = mysqli_query($link,$sql5);
$total5 = mysqli_num_rows($result5);
 if ($row5 = mysqli_fetch_array($result5)){
mysqli_field_seek($result5,0);
while ($field5 = mysqli_fetch_field($result5)){
} do {
	?>
    <td width="726">              
<span style="font-family: Arial; font-size: 12px;"><?php
$sql_s =" SELECT dato_laboral.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, establecimiento_salud.latitud, establecimiento_salud.longitud ";
$sql_s.=" FROM personal, dato_laboral, establecimiento_salud WHERE personal.iddato_laboral=dato_laboral.iddato_laboral ";
$sql_s.=" AND dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND dato_laboral.iddepartamento='$row5[0]' ";
$sql_s.=" AND establecimiento_salud.idnivel_establecimiento='$row4[0]' GROUP BY dato_laboral.idestablecimiento_salud ";
$result_s = mysqli_query($link,$sql_s);
$row_s = mysqli_num_rows($result_s);
?>
<?php echo $row5[1];?> <?php echo ":";?> 

<a href="detalle_establecimientos_niveles_safci.php?iddepartamento=<?php echo $row5[0];?>&idnivel_establecimiento=<?php echo $row4[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=700,scrollbars=YES,top=50,left=200'); return false;"><?php if ($row_s !='0') { echo $row_s; } else { } ?></a>  

</span></td>

            <?php 
} while ($row5 = mysqli_fetch_array($result5));
} else {
/*
Si no se encontraron resultados
*/
}
?>
          </tr>
        </tbody>
      </table>
    

    
    </td>
    </tr>
    <?php 

} while ($row4 = mysqli_fetch_array($result4));
} else {
echo "";
/*
Si no se encontraron resultados
*/
}
?>
  </tbody>
</table>

<?php 
        $sql0 = " SELECT dato_laboral.idestablecimiento_salud FROM personal, dato_laboral WHERE personal.iddato_laboral=dato_laboral.iddato_laboral GROUP BY dato_laboral.idestablecimiento_salud ";
        $result0 = mysqli_query($link,$sql0);
        $total = mysqli_num_rows($result0);
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">TOTAL DE ESTABLECIMIENTOS CON PRESENCIA SAFCI = <?php echo $total;?> </h4></spam>


	</body>
</html>