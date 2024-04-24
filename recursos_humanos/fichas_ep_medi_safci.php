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
		<title>MEDI-SAFCI FICHAS EPID. DIARIAS</title>

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
            text: 'FICHAS EPIDEMIOLÓGICAS POR DIA SISTEMA MEDI-SAFCI'
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
$sql = " SELECT fecha_registro FROM ficha_ep WHERE gestion='$gestion' GROUP BY fecha_registro ORDER BY fecha_registro";
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
                text: 'FICHAS DIARIAS'
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' Fichas Ep.'
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
            name: 'Fichas Epidemiológicas',
            data: [

             <?php

$numero = 0;
$sql = " SELECT fecha_registro FROM ficha_ep WHERE gestion='$gestion' GROUP BY fecha_registro ORDER BY fecha_registro ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT idficha_ep, fecha_registro FROM ficha_ep WHERE gestion='$gestion' AND fecha_registro='$row[0]'";
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
        },

        {
            name: 'Fichas con datos Paciente',
            data: [

             <?php

$numero = 0;
$sql = " SELECT fecha_registro FROM ficha_ep WHERE gestion='$gestion' GROUP BY fecha_registro ORDER BY fecha_registro ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT idficha_ep, fecha_registro FROM ficha_ep WHERE gestion='$gestion' AND direccion !='' AND fecha_registro='$row[0]'";
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
        }
    
    ]
    });
});
		</script>
	</head>
	<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>
<div id="container" style="min-width: 300px; height: 350px; margin: 0 auto"></div>

<h4 style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">ULTIMOS 50 REGISTROS - FICHAS EPIDEMIOLÓGICAS</h4>

<table width="1000" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
              <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">CÓDIGO FICHA</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">CI PACIENTE</td>
              <td width="300" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">NOMBRE PACIENTE</td>
              <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">FECHA DE REGISTRO</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">DEPARTAMENTO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">MUNICIPIO</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ESTABLECIMIENTO</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">USUARIO MEDISAFCI</td>
              <td width="80" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">PERFIL</td>

             

		     <!--- <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">F302A</td>  --->
	        </tr>
            <?php
    $numero=1; 
    $sql2 = " SELECT ficha_ep.idficha_ep, ficha_ep.codigo,  nombre.ci, nombre.nombre, nombre.paterno, nombre.materno, ficha_ep.fecha_registro, departamento.departamento, municipios.municipio, ";
    $sql2.= " establecimiento_salud.establecimiento_salud, ficha_ep.idusuario FROM ficha_ep, registro_enfermedad, notificacion_ep, establecimiento_salud, departamento, red_salud, municipios, nombre ";
    $sql2.= " WHERE ficha_ep.idregistro_enfermedad=registro_enfermedad.idregistro_enfermedad  AND registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep ";
    $sql2.= " AND notificacion_ep.iddepartamento=departamento.iddepartamento AND notificacion_ep.idmunicipio=municipios.idmunicipio AND notificacion_ep.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
    $sql2.= " AND establecimiento_salud.idred_salud=red_salud.idred_salud AND ficha_ep.idnombre=nombre.idnombre AND notificacion_ep.gestion='$gestion' ";
    $sql2.= " AND ficha_ep.direccion !='' AND nombre.nombre !='' ORDER BY ficha_ep.fecha_registro DESC LIMIT 50 ";

    $result2 = mysqli_query($link,$sql2);
    if ($row2 = mysqli_fetch_array($result2)){
    mysqli_field_seek($result2,0);           
    while ($field2 = mysqli_fetch_field($result2)){
    } do {

        $sql6 = " SELECT nombre.nombre, nombre.paterno, nombre.materno, usuarios.perfil FROM usuarios, nombre  ";
        $sql6.= " WHERE usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row2[10]' ";
        $result6 = mysqli_query($link,$sql6);
        $row6    = mysqli_fetch_array($result6);

    ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row2[1];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row2[2];?></td>
              <td style="font-size: 12px; font-family: Arial;"><?php echo mb_strtoupper($row2[3]." ".$row2[4]." ".$row2[5]);?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                $fecha_r = explode('-',$row2[6]);
                $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                <?php echo $f_registro;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row2[7];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row2[8];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row2[9];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo mb_strtoupper($row6[0]." ".$row6[1]." ".$row6[2]);?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row6[3];?></td>
              

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