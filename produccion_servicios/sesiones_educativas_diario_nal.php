<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];
$idcharla_psafci = $_GET['idcharla_psafci'];

$sql_ch = " SELECT idcharla_psafci, charla_psafci FROM charla_psafci WHERE idcharla_psafci='$idcharla_psafci' ";
$result_ch = mysqli_query($link,$sql_ch);
$row_ch = mysqli_fetch_array($result_ch);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>MEDI-SAFCI SESIONES EDUCATIVAS INTEGRALES - DIARIAS</title>

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
            text: 'SESIONES EDUCATIVAS POR DIA SISTEMA MEDI-SAFCI'
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
$sql = " SELECT fecha_sesion FROM sesion_educativa WHERE idcharla_psafci='$idcharla_psafci' GROUP BY fecha_sesion ORDER BY fecha_sesion ";
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
                text: 'SESIONES EDUCATIVAS PSAFCI DIARIAS'
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' Sesiones'
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
            name: 'Nª de Sesiones al Dia',
            data: [

             <?php

$numero = 0;
$sql = " SELECT fecha_sesion FROM sesion_educativa WHERE idcharla_psafci='$idcharla_psafci' GROUP BY fecha_sesion ORDER BY fecha_sesion ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT idsesion_educativa, fecha_sesion FROM sesion_educativa WHERE fecha_sesion='$row[0]' AND idcharla_psafci='$idcharla_psafci' ";
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
 
    ]
    });
});
		</script>
	</head>
	<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>
<div id="container" style="min-width: 300px; height: 350px; margin: 0 auto"></div>

<h4 style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;"><?php echo $row_ch[1];?></h4>

<p style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">&nbsp;</p>


<table width="1000" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
              <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">CÓDIGO SESIÓN</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">DEPARTAMENTO</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">MUNICIPIO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ESTABLECIMIENTO</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">FECHA DE LA SESIÓN</td>
              <td width="300" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">SESIÓN EDUCATIVA</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ASISTENTES</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">MÉDICO OPERATIVO</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">FECHA DE REGISTRO:</td>

		     <!--- <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">F302A</td>  --->
	        </tr>
            <?php
    $numero=1; 
    $sql =" SELECT sesion_educativa.idsesion_educativa, sesion_educativa.codigo, departamento.departamento, municipios.municipio,  ";
    $sql.=" establecimiento_salud.establecimiento_salud, sesion_educativa.fecha_sesion, sesion_educativa.asistentes, charla_psafci.charla_psafci,  ";
    $sql.=" nombre.nombre, nombre.paterno, nombre.materno, sesion_educativa.fecha_registro, sesion_educativa.hora_registro, sesion_educativa.idusuario  ";
    $sql.=" FROM sesion_educativa, charla_psafci, nombre, usuarios, departamento, municipios, establecimiento_salud WHERE sesion_educativa.idusuario=usuarios.idusuario  ";
    $sql.=" AND sesion_educativa.idcharla_psafci=charla_psafci.idcharla_psafci AND sesion_educativa.iddepartamento=departamento.iddepartamento  AND usuarios.idnombre=nombre.idnombre  ";
    $sql.="  AND sesion_educativa.idmunicipio=municipios.idmunicipio AND sesion_educativa.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud   ";
    $sql.=" AND sesion_educativa.idcharla_psafci='$idcharla_psafci' ORDER BY sesion_educativa.idsesion_educativa DESC  ";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);           
    while ($field = mysqli_fetch_field($result)){
    } do {
    ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[1];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[2];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[3];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[4];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                $fecha_s = explode('-',$row[5]);
                $f_sesion = $fecha_s[2].'/'.$fecha_s[1].'/'.$fecha_s[0];?>
                <?php echo $f_sesion;?></td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[7];?></td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[6];?></td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo mb_strtoupper($row[8]." ".$row[9]." ".$row[10]);?></td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">
                <?php 
                $fecha_r = explode('-',$row[11]);
                $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                <?php echo $f_registro;?> - <?php echo $row[12];?>
            </td>
		     <!--- <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">&nbsp;</td> --->
	        </tr>
            <?php
        $numero=$numero+1;
        }
        while ($row = mysqli_fetch_array($result));
        } else {
        }
        ?>
	      </tbody>
    </table>

</body>
</html>