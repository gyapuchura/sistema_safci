<?php include("../cabf.php"); ?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

$idsospecha_diag_mun = $_GET['idsospecha_diag_mun'];
$idmunicipio = $_GET['idmunicipio'];

$sql_sos = " SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idsospecha_diag='$idsospecha_diag_mun' ";
$result_sos = mysqli_query($link,$sql_sos);
$row_sos = mysqli_fetch_array($result_sos);

$sql_d = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento_ep' ";
$result_d = mysqli_query($link,$sql_d);
$row_d = mysqli_fetch_array($result_d);

$sql_m = " SELECT idmunicipio, municipio FROM municipios WHERE idmunicipio='$idmunicipio' ";
$result_m = mysqli_query($link,$sql_m);
$row_m = mysqli_fetch_array($result_m);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>VIGILANCIA POR MUNICIPIO</title>

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
            text: 'VIGILANCIA: <?php echo mb_strtoupper($row_sos[1]);?> - MUNICIPIO: <?php echo mb_strtoupper($row_m[1]);?>'
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
$sql = " SELECT notificacion_ep.semana_ep FROM notificacion_ep, registro_enfermedad WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
$sql.= " AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_mun' AND notificacion_ep.idmunicipio='$idmunicipio' AND notificacion_ep.gestion ='$gestion'  ";
$sql.= " AND notificacion_ep.estado='CONSOLIDADO' GROUP BY notificacion_ep.semana_ep ORDER BY notificacion_ep.semana_ep ";
$result = mysqli_query($link,$sql);
$total = mysqli_num_rows($result);
 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>
             'SEMANA <?php echo $row[0];?>'

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
                text: 'CASOS REGISTRADOS'
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' CASOS '
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
            name: 'SOSPECHAS ',
            data: [

             <?php

$numero = 0;
$sql = " SELECT notificacion_ep.semana_ep FROM notificacion_ep, registro_enfermedad WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
$sql.= " AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_mun' AND notificacion_ep.idmunicipio='$idmunicipio' AND notificacion_ep.gestion ='$gestion'  ";
$sql.= " AND notificacion_ep.estado='CONSOLIDADO' GROUP BY notificacion_ep.semana_ep ORDER BY notificacion_ep.semana_ep ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT SUM(registro_enfermedad.cifra) FROM registro_enfermedad, notificacion_ep ";
$sql7.= " WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
$sql7.= " AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_mun' AND notificacion_ep.semana_ep='$row[0]' ";
$sql7.= " AND registro_enfermedad.gestion='$gestion' AND notificacion_ep.idmunicipio='$idmunicipio' AND notificacion_ep.estado='CONSOLIDADO'";
$result7 = mysqli_query($link,$sql7);
$row7 = mysqli_fetch_array($result7);
$cifra_semanal = $row7[0];
?>
             <?php echo $cifra_semanal; ?>

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
    name: 'RECUPERADOS',
    data: [

<?php

$numero = 0;
$sql_r = " SELECT seguimiento_ep.idsemana_ep FROM seguimiento_ep, notificacion_ep WHERE seguimiento_ep.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
$sql_r.= " AND notificacion_ep.estado='CONSOLIDADO' AND seguimiento_ep.idsospecha_diag='$idsospecha_diag_mun' AND notificacion_ep.idmunicipio='$idmunicipio' ";
$sql_r.= " AND notificacion_ep.gestion='$gestion' GROUP BY seguimiento_ep.idsemana_ep ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
?>

<?php
$sql7 = " SELECT count(seguimiento_ep.idseguimiento_ep) FROM seguimiento_ep, notificacion_ep ";
$sql7.= " WHERE seguimiento_ep.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND seguimiento_ep.idestado_paciente='2' AND notificacion_ep.gestion='$gestion' ";
$sql7.= " AND seguimiento_ep.idsospecha_diag='$idsospecha_diag_deptal' AND seguimiento_ep.idsemana_ep='$row[0]' AND notificacion_ep.idmunicipio='$idmunicipio' ";
$result7 = mysqli_query($link,$sql7);
$row7 = mysqli_fetch_array($result7);
$recuperados = $row7[0];
?>
<?php echo $recuperados; ?>

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
]   }
    
    ]
    });
});
		</script>
	</head>
	<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>
<div id="container" style="min-width: 300px; height: 350px; margin: 0 auto"></div>
		<h2 style="text-align: center; font-family: Arial; font-size: 14px; color: #2D56CF;">ESTABLECIMIENTOS CON SOSPECHAS DE <?php echo mb_strtoupper($row_sos[1]);?></h2>
		<table width="700" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
		      <td width="199" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">ESTABLECIMIENTO</td>
              <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° SOSPECHAS</td>
		      <td width="101" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">REPORTE </td>
		      <td width="121" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">GRUPOS ETAREOS</td>
		      <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">F302A</td>
	        </tr>
            <?php
    $numero=1; 
    $sql =" SELECT notificacion_ep.idestablecimiento_salud, establecimiento_salud.establecimiento_salud FROM notificacion_ep, registro_enfermedad, establecimiento_salud ";
    $sql.=" WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND notificacion_ep.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND notificacion_ep.estado='CONSOLIDADO' ";
    $sql.=" AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_mun' AND notificacion_ep.gestion='$gestion' AND notificacion_ep.idmunicipio='$idmunicipio' GROUP BY notificacion_ep.idestablecimiento_salud ORDER BY establecimiento_salud.establecimiento_salud ";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);           
    while ($field = mysqli_fetch_field($result)){
    } do {

        $sql_c =" SELECT SUM(registro_enfermedad.cifra) FROM notificacion_ep, registro_enfermedad ";
        $sql_c.=" WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep ";
        $sql_c.=" AND notificacion_ep.estado='CONSOLIDADO' AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_mun' AND notificacion_ep.estado='CONSOLIDADO' ";
        $sql_c.=" AND notificacion_ep.gestion='$gestion' AND notificacion_ep.idestablecimiento_salud='$row[0]' ";
        $result_c = mysqli_query($link,$sql_c);
        $row_c = mysqli_fetch_array($result_c);
    ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero;?></td>
		      <td style="font-size: 12px; font-family: Arial;"><?php echo $row[1];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_c[0];?></td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="marco_ep_establecimiento.php?idsospecha_diag_estab=<?php echo $idsospecha_diag_mun;?>&idestablecimiento_salud=<?php echo $row[0];?>" target="_blank" class="Estilo12" style="font-size: 12px; font-family: Arial;" onClick="window.open(this.href, this.target, 'width=1000,height=400,scrollbars=YES,top=60,left=400'); return false;">REPORTE</a>
              </td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="piramide_sospechas_estab.php?idsospecha_diag_estab=<?php echo $idsospecha_diag_mun;?>&idestablecimiento_salud=<?php echo $row[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=400,scrollbars=YES,top=50,left=300'); return false;">GRUPOS</a></td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="detalle_notificaciones_estab.php?idestablecimiento_salud=<?php echo $row[0];?>&idmunicipio=<?php echo $idmunicipio;?>&idsospecha_diag=<?php echo $idsospecha_diag_mun?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=300'); return false;">NOTIFICACIONES</a></td>
            </td>
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
		<p>&nbsp;</p>
</body>
</html>