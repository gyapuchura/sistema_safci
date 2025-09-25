<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");
$semana  = date("W");
$semana_ep = $semana-1;

$idsospecha_diag = $_GET['idsospecha_diag'];
$iddepartamento = $_GET['iddepartamento'];

$sql_sos = " SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idsospecha_diag='$idsospecha_diag' ";
$result_sos = mysqli_query($link,$sql_sos);
$row_sos = mysqli_fetch_array($result_sos);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>MEDI-SAFCI F302A SEMANAL</title>

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
            text: 'NOTIFICACIONES F302A - HASTA LA SEMANA Nº <?php echo $semana_ep;?> CON <?php echo mb_strtoupper($row_sos[1]);?>'
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
$sql = " SELECT notificacion_ep.fecha_registro FROM notificacion_ep, registro_enfermedad WHERE notificacion_ep.estado='CONSOLIDADO' ";
$sql.= " AND registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND registro_enfermedad.gestion='$gestion' AND registro_enfermedad.cifra !='0' ";
$sql.= " AND registro_enfermedad.idsospecha_diag='$idsospecha_diag' AND notificacion_ep.iddepartamento='$iddepartamento' GROUP BY notificacion_ep.fecha_registro ORDER BY notificacion_ep.fecha_registro ";
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
                text: 'F302a'
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' Casos'
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
            name: 'Casos <?php echo mb_strtoupper($row_sos[1]);?>',
            data: [

             <?php

$numero = 0;
$sql = " SELECT notificacion_ep.fecha_registro FROM notificacion_ep, registro_enfermedad WHERE notificacion_ep.estado='CONSOLIDADO' ";
$sql.= " AND registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND registro_enfermedad.gestion='$gestion' AND registro_enfermedad.cifra !='0' ";
$sql.= " AND registro_enfermedad.idsospecha_diag='$idsospecha_diag' AND notificacion_ep.iddepartamento='$iddepartamento' GROUP BY notificacion_ep.fecha_registro ORDER BY notificacion_ep.fecha_registro ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT sum(registro_enfermedad.cifra) FROM notificacion_ep, registro_enfermedad WHERE notificacion_ep.estado='CONSOLIDADO' ";
$sql7.= " AND registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND registro_enfermedad.idsospecha_diag='$idsospecha_diag' AND registro_enfermedad.cifra !='0' ";
$sql7.= " AND notificacion_ep.iddepartamento='$iddepartamento' AND registro_enfermedad.gestion='$gestion' AND notificacion_ep.fecha_registro='$row[0]' ";
$result7 = mysqli_query($link,$sql7);
$row7 = mysqli_fetch_array($result7);
$cifra_diaria = $row7[0];
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

<h4 style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">F302A - <?php echo mb_strtoupper($row_sos[1]);?></h4>

<table width="1000" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
              <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">CÓDIGO</td>
              <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">SEMANA EPIDEMIOLÓGICA</td>
              <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">Nª DE CASOS</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">DEPARTAMENTO</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">RED DE SALUD</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">MUNICIPIO</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ESTABLECIMIENTO</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">USUARIO DE SISTEMA</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">PERFIL</td>
              <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">FECHA Y HORA DE REGISTRO</td>

		     <!--- <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">F302A</td>  --->
	        </tr>
            <?php
    $numero=1; 
    $sql2 = " SELECT notificacion_ep.idnotificacion_ep, notificacion_ep.codigo, departamento.departamento, red_salud.red_salud, ";
    $sql2.= " municipios.municipio, establecimiento_salud.establecimiento_salud, notificacion_ep.semana_ep,  ";
    $sql2.= " notificacion_ep.fecha_registro, notificacion_ep.hora_registro, nombre.nombre, nombre.paterno, nombre.materno, usuarios.perfil ";
    $sql2.= " FROM notificacion_ep, registro_enfermedad, departamento, red_salud, municipios, establecimiento_salud, usuarios, nombre ";
    $sql2.= " WHERE notificacion_ep.iddepartamento=departamento.iddepartamento AND notificacion_ep.idred_salud=red_salud.idred_salud AND notificacion_ep.estado='CONSOLIDADO' ";
    $sql2.= " AND registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND registro_enfermedad.gestion='$gestion' AND notificacion_ep.idmunicipio=municipios.idmunicipio";
    $sql2.= " AND notificacion_ep.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND notificacion_ep.idusuario=usuarios.idusuario AND registro_enfermedad.cifra !='0' ";
    $sql2.= " AND usuarios.idnombre=nombre.idnombre AND notificacion_ep.iddepartamento='$iddepartamento' AND registro_enfermedad.idsospecha_diag='$idsospecha_diag' GROUP BY notificacion_ep.idnotificacion_ep DESC ";
    $result2 = mysqli_query($link,$sql2);
    if ($row2 = mysqli_fetch_array($result2)){
    mysqli_field_seek($result2,0);           
    while ($field2 = mysqli_fetch_field($result2)){
    } do {
    ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="../implementacion_safci/imprime_notificacion_ep.php?idnotificacion_ep=<?php echo $row2[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=650,scrollbars=YES,top=50,left=200'); return false;"><?php echo $row2[1];?></a>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo "Semana ".$row2[6];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
            <?php 
                    $sql_ca = " SELECT sum(cifra) FROM registro_enfermedad WHERE idsospecha_diag = '$idsospecha_diag' AND idnotificacion_ep='$row2[0]' ";
                    $result_ca = mysqli_query($link,$sql_ca);    
                    $row_ca = mysqli_fetch_array($result_ca);
                    $casos = $row_ca[0];
                    echo $casos;
              ?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row2[2];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row2[3];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row2[4];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row2[5];?></td>
              <td style="font-size: 12px; font-family: Arial;"><?php echo mb_strtoupper($row2[9]." ".$row2[10]." ".$row2[11]);?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row2[12];?></td>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                $fecha_r = explode('-',$row2[7]);
                $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                <?php echo $f_registro;?> - <?php echo $row2[8];?></td>
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