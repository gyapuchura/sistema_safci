<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>MEDI-SAFCI AREAS INFLUENCIA DIARIAS</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'areaspline'
        },
        title: {
            text: 'ÁREAS DE INFLUENCIA REGISTRADAS POR DIA'
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            verticalAlign: 'top',
            x: 150,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
        },
        xAxis: {
            categories: [
 <?php
$numero = 0;
$sql = " SELECT fecha_registro FROM area_influencia GROUP BY fecha_registro ORDER BY fecha_registro";
$result = mysqli_query($link,$sql);
$total = mysqli_num_rows($result);
 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {

    $fecha_s = explode('-',$row[0]);
    $fecha_log = $fecha_s[2].'/'.$fecha_s[1].'/'.$fecha_s[0];
    ?>

             '<?php echo $fecha_log;?>'

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


echo ",";

}
?>
            ],
            plotBands: [{ // visualize the weekend
                from: 4.5,
                to: 6.5,
                color: 'rgba(68, 170, 213, .2)'
            }]
        },
        yAxis: {
            title: {
                text: 'REGISTRO DE ÁREAS DE INFLUENCIA EN SISTEMA'
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' Registros'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            areaspline: {
                fillOpacity: 0.5
            }
        },
        series: [{
            name: ' Registro Área de influencia.',
            data: [

             <?php

$numero = 0;
$sql = " SELECT fecha_registro FROM area_influencia GROUP BY fecha_registro ORDER BY fecha_registro ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT idarea_influencia, fecha_registro FROM area_influencia WHERE fecha_registro='$row[0]'";
$result7 = mysqli_query($link,$sql7);
$row7 = mysqli_num_rows($result7);

$cifra_diaria = $row7;
?>
             <?php echo $cifra_diaria; ?>

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


echo ",";
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
<script src="../js/modules/exporting.js"></script>
<div id="container" style="min-width: 300px; height: 350px; margin: 0 auto"></div>

<table width="1000" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">DEPARTAMENTO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">RED DE SALUD</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">MUNICIPIO</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ESTABLECIMIENTO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">TIPO DE ÁREA DE INFLUENCIA</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">DENOMINACIÓN DEL ÁREA DE INFLUENCIA</td>
              <td width="80" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">REGISTRADA POR:</td>
              <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">FECHA DE REGISTRO</td>

             

		     <!--- <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">F302A</td>  --->
	        </tr>
            <?php
    $numero=1; 
    $sql2 = " SELECT area_influencia.idarea_influencia, departamento.departamento, red_salud.red_salud, municipios.municipio, establecimiento_salud.establecimiento_salud, tipo_area_influencia.tipo_area_influencia, ";
    $sql2.= " area_influencia.area_influencia, nombre.nombre, nombre.paterno, nombre.materno, area_influencia.fecha_registro FROM area_influencia, departamento, red_salud, municipios, tipo_area_influencia, establecimiento_salud, usuarios, nombre ";
    $sql2.= " WHERE area_influencia.iddepartamento=departamento.iddepartamento AND area_influencia.idred_salud=red_salud.idred_salud AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia  ";
    $sql2.= " AND area_influencia.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND area_influencia.idusuario=usuarios.idusuario AND usuarios.idnombre=nombre.idnombre ";
    $sql2.= " AND establecimiento_salud.idmunicipio=municipios.idmunicipio ORDER BY area_influencia.idarea_influencia DESC  LIMIT 50 ";
    $result2 = mysqli_query($link,$sql2);
    if ($row2 = mysqli_fetch_array($result2)){
    mysqli_field_seek($result2,0);           
    while ($field2 = mysqli_fetch_field($result2)){
    } do {

    ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row2[0];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row2[1];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row2[2];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row2[3];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row2[4];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row2[5];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row2[6];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo mb_strtoupper($row2[7]." ".$row2[8]." ".$row2[9]);?></td>
            
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                $fecha_r = explode('-',$row2[10]);
                $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                <?php echo $f_registro;?></td>
              

		     <!--- <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">&nbsp;</td> --->
	        </tr>
            <?php
        $numero=$numero+1;
        }
        while ($row2 = mysqli_fetch_array($result2));
        } else {
        }
        ?>
	      </tbody>
    </table>


</body>
</html>