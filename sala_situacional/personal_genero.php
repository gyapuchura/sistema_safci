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
		<title>CANTIDAD POR DEPARTAMENTO</title>

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
            text: 'PERSONAL A NIVEL NACIONAL'
        },
        subtitle: {
            text: 'Fuente: SISTEMA MEDI-SAFCI'
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
                text: 'PERSONAL A NIVEL NACIONAL'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} Personal de Salud </b></td></tr>',
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
$sql2 = " SELECT idgenero, genero FROM genero ORDER BY idgenero ";
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
$sql_a ="SELECT COUNT(nombre.idgenero) FROM personal, nombre, nombre_datos WHERE personal.idnombre=nombre.idnombre AND personal.idnombre_datos=nombre_datos.idnombre_datos AND nombre.idgenero='$row2[0]' AND nombre_datos.iddepartamento='$row3[0]' ";
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
	</head>
	<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="min-width: 410px; height: 400px; margin: 0 auto"></div>
<p>&nbsp;</p>
<table width="806" border="1" align="center" cellspacing="0">
  <tbody>
    <tr>
      <td width="58" bgcolor="#C3EDD7" style="font-family: Arial; font-size: 12px; color: #205332;"><strong>GÉNERO (PERSONAL)</strong></td>
      <td width="732" bgcolor="#C3EDD7" style="font-family: Arial; font-size: 12px; color: #284A1F; text-align: center;"><strong>CANTIDAD DE PERSONAL POR DEPARTAMENTO</strong></td>
    </tr>
    <?php 

$sql4 = " SELECT idgenero, genero FROM genero ORDER BY idgenero ";
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
$sql_s =" SELECT COUNT(nombre.idgenero) FROM personal, nombre, nombre_datos WHERE personal.idnombre=nombre.idnombre AND personal.idnombre_datos=nombre_datos.idnombre_datos AND nombre.idgenero='$row4[0]' AND nombre_datos.iddepartamento='$row5[0]' ";
$result_s = mysqli_query($link,$sql_s);
$row_s = mysqli_fetch_array($result_s);
?>
<?php echo $row5[1];?> 
				<?php echo ":";?> 


<a href="detalle_personal_genero.php?iddepartamento=<?php echo $row5[0];?>&idgenero=<?php echo $row4[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=700,scrollbars=YES,top=50,left=200'); return false;"><?php if ($row_s[0] !='0') { echo $row_s[0]; } else { } ?></a>  
 

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
        $sql0 = " SELECT personal.idpersonal, nombre_datos.idformacion_academica FROM personal, nombre, nombre_datos WHERE personal.idnombre_datos=nombre_datos.idnombre_datos AND personal.idnombre=nombre.idnombre ";
        $result0 = mysqli_query($link,$sql0);
        $total = mysqli_num_rows($result0);
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">TOTAL DE PERSONAL REGISTRADO = <?php echo $total;?> </h4></spam>

</br>
</br>

</body>
</html>