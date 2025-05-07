<?php include("../cabf.php");?>
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
		<title>MEDI-SAFCI ATENCIONES INTEGRALES - DIARIAS</title>

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
            text: 'ATENCIONES INTEGRALES POR DIA SISTEMA MEDI-SAFCI'
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
$sql = " SELECT fecha_registro FROM atencion_psafci GROUP BY fecha_registro ORDER BY fecha_registro ";
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
                text: 'ATENCIONES PSAFCI DIARIAS'
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' Atenciones integrales'
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
            name: 'EN CONSULTA',
            data: [

             <?php

$numero = 0;
$sql = " SELECT fecha_registro FROM atencion_psafci GROUP BY fecha_registro ORDER BY fecha_registro ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT idatencion_psafci, fecha_registro FROM atencion_psafci WHERE fecha_registro='$row[0]' AND idtipo_consulta='1'";
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
            name: 'EN VISITA FAMILIAR',
            data: [

             <?php

$numero = 0;
$sql = " SELECT fecha_registro FROM atencion_psafci GROUP BY fecha_registro ORDER BY fecha_registro ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT idatencion_psafci, fecha_registro FROM atencion_psafci WHERE fecha_registro='$row[0]' AND idtipo_consulta='2' ";
$result7 = mysqli_query($link,$sql7);
$row7 = mysqli_num_rows($result7);

$cifra_diaria2 = $row7;
?>
             <?php echo $cifra_diaria2; ?>

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

<h4 style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">ATENCIONES DIARIAS PSAFCI</h4>

<table width="1000" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
              <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">CÓDIGO ATENCIÓN</td>
              <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">PERSONA ATENDIDA</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">DEPARTAMENTO</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">MUNICIPIO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ESTABLECIMIENTO</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">CONSULTA/VISITA</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">TIPO ATENCIÖN</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">MÉDICO OPERATIVO</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">FECHA DE REGISTRO:</td>

		     <!--- <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">F302A</td>  --->
	        </tr>
            <?php
    $numero=1; 
    $sql =" SELECT atencion_psafci.idatencion_psafci, atencion_psafci.codigo, nombre.nombre, nombre.paterno, nombre.materno, ";
    $sql.=" departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud, tipo_consulta.tipo_consulta,  ";
    $sql.=" tipo_atencion.tipo_atencion,atencion_psafci.fecha_registro, atencion_psafci.hora_registro, atencion_psafci.idusuario  ";
    $sql.=" FROM atencion_psafci, nombre, tipo_consulta, tipo_atencion, departamento, municipios, establecimiento_salud WHERE atencion_psafci.idnombre=nombre.idnombre ";
    $sql.=" AND atencion_psafci.idtipo_consulta=tipo_consulta.idtipo_consulta AND atencion_psafci.iddepartamento=departamento.iddepartamento  ";
    $sql.=" AND atencion_psafci.idmunicipio=municipios.idmunicipio AND atencion_psafci.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud  ";
    $sql.=" AND atencion_psafci.idtipo_atencion=tipo_atencion.idtipo_atencion ORDER BY atencion_psafci.idatencion_psafci DESC  LIMIT 1000";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);           
    while ($field = mysqli_fetch_field($result)){
    } do {
    ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="imprime_atencion_psafci.php?idatencion_psafci=<?php echo $row[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=800,height=900,top=50, left=200, scrollbars=YES'); return false;">
              <?php echo $row[1];?></a>  
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo mb_strtoupper($row[2]." ".$row[3]." ".$row[4]);?></td>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[5];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[6];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[7];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[8];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[9];?></td>
              <td style="font-size: 12px; font-family: Arial;">
              <?php 
                $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                $sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row[12]' ";
                $result_r = mysqli_query($link,$sql_r);
                $row_r = mysqli_fetch_array($result_r);                    
                echo mb_strtoupper($row_r[0]." ".$row_r[1]." ".$row_r[2]);?>
              </td>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                $fecha_r = explode('-',$row[10]);
                $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                <?php echo $f_registro;?> - <?php echo $row[11];?></td>
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