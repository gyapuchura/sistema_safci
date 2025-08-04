<?php include("../cabf.php"); ?>
<?php include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = $_GET['gestion'];

$idsospecha_diag_deptal = $_GET['sospecha_diag_deptal'];
$iddepartamento_ep = $_GET['departamento_ep'];

$sql_sos = " SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idsospecha_diag='$idsospecha_diag_deptal' ";
$result_sos = mysqli_query($link,$sql_sos);
$row_sos = mysqli_fetch_array($result_sos);

$sql_d = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento_ep' ";
$result_d = mysqli_query($link,$sql_d);
$row_d = mysqli_fetch_array($result_d);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>VIGILANCIA POR DEPARTAMWENTO</title>

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
            text: 'VIGILANCIA: <?php echo mb_strtoupper($row_sos[1]);?> - DEPARTAMENTO: <?php echo mb_strtoupper($row_d[1]);?> - GESTIÓN <?php echo $gestion;?>'
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
$sql.= " AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_deptal' AND notificacion_ep.iddepartamento='$iddepartamento_ep' AND notificacion_ep.gestion ='$gestion'  ";
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
$sql.= " AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_deptal' AND notificacion_ep.iddepartamento='$iddepartamento_ep' AND notificacion_ep.gestion ='$gestion'  ";
$sql.= " AND notificacion_ep.estado='CONSOLIDADO' GROUP BY notificacion_ep.semana_ep ORDER BY notificacion_ep.semana_ep ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT sum(registro_enfermedad.cifra) FROM registro_enfermedad, notificacion_ep ";
$sql7.= " WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
$sql7.= " AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_deptal' AND notificacion_ep.semana_ep='$row[0]' ";
$sql7.= " AND registro_enfermedad.gestion='$gestion' AND notificacion_ep.iddepartamento='$iddepartamento_ep' AND notificacion_ep.estado='CONSOLIDADO'";
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

$numero_r = 0;
$sql_r = " SELECT seguimiento_ep.idsemana_ep FROM seguimiento_ep, notificacion_ep WHERE seguimiento_ep.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
$sql_r.= " AND notificacion_ep.estado='CONSOLIDADO' AND seguimiento_ep.idsospecha_diag='$idsospecha_diag_deptal' AND notificacion_ep.iddepartamento='$iddepartamento_ep' ";
$sql_r.= " AND notificacion_ep.gestion='$gestion' GROUP BY seguimiento_ep.idsemana_ep ";
$result_r = mysqli_query($link,$sql_r);
$total_r = mysqli_num_rows($result_r);
if ($row_r = mysqli_fetch_array($result_r)){
mysqli_field_seek($result_r,0);
while ($field_r = mysqli_fetch_field($result_r)){
} do {
?>

<?php
$sql8 = " SELECT count(seguimiento_ep.idseguimiento_ep) FROM seguimiento_ep, notificacion_ep ";
$sql8.= " WHERE seguimiento_ep.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND seguimiento_ep.idestado_paciente='2' AND notificacion_ep.gestion='$gestion' ";
$sql8.= " AND seguimiento_ep.idsospecha_diag='$idsospecha_diag_deptal' AND seguimiento_ep.idsemana_ep='$row_r[0]' AND notificacion_ep.iddepartamento='$iddepartamento_ep' ";
$result8 = mysqli_query($link,$sql8);
$row8 = mysqli_fetch_array($result8);
$recuperados = $row8[0];
?>
<?php echo $recuperados; ?>

<?php
$numero_r++;
if ($numero_r == $total_r) {
echo "";
}
else {
echo ",";
}

} while ($row_r = mysqli_fetch_array($result_r));


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
<span style="font-family: Arial"></span><script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>
<div id="container" style="min-width: 300px; height: 350px; margin: 0 auto"></div>

<h2 style="text-align: center; font-family: Arial; font-size: 14px; color: #2D56CF;">DEPARTAMENTO DE <?php echo mb_strtoupper($row_d[1]);?></h2>
<h2 style="text-align: center; font-family: Arial; font-size: 14px; color: #2D56CF;">MUNICIPIOS CON SOSPECHAS DE <?php echo mb_strtoupper($row_sos[1]);?></h2>
		<table width="700" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
		      <td width="199" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">MUNICIPIO</td>
              <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° SOSPECHAS</td>
		      <td width="101" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">REPORTE </td>
		      <td width="121" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">GRUPOS ETAREOS</td>
		     <!--- <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">F302A</td>  --->
	        </tr>
            <?php
    $numero_m=1; 
    $sql_m =" SELECT notificacion_ep.idmunicipio, municipios.municipio FROM notificacion_ep, registro_enfermedad, municipios ";
    $sql_m.=" WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND notificacion_ep.idmunicipio=municipios.idmunicipio AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_deptal' AND registro_enfermedad.cifra !='0' ";
    $sql_m.=" AND notificacion_ep.estado='CONSOLIDADO' AND notificacion_ep.gestion='$gestion' AND notificacion_ep.iddepartamento='$iddepartamento_ep' GROUP BY notificacion_ep.idmunicipio ORDER BY municipios.municipio";
    $result_m = mysqli_query($link,$sql_m);
    if ($row_m = mysqli_fetch_array($result_m)){
    mysqli_field_seek($result_m,0);           
    while ($field_m = mysqli_fetch_field($result_m)){
    } do {

        $sql_ci =" SELECT sum(registro_enfermedad.cifra) FROM notificacion_ep, registro_enfermedad ";
        $sql_ci.=" WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
        $sql_ci.=" AND notificacion_ep.estado='CONSOLIDADO' AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_deptal' ";
        $sql_ci.=" AND notificacion_ep.gestion='$gestion' AND notificacion_ep.idmunicipio='$row_m[0]' ";
        $result_ci = mysqli_query($link,$sql_ci);
        $row_ci = mysqli_fetch_array($result_ci);
    ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero_m;?></td>
		      <td style="font-size: 12px; font-family: Arial;"><?php echo $row_m[1];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_ci[0];?></td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="marco_ep_municipal_gestion.php?idsospecha_diag_mun=<?php echo $idsospecha_diag_deptal;?>&idmunicipio=<?php echo $row_m[0];?>&gestion=<?php echo $gestion?>" target="_blank" class="Estilo12" style="font-size: 12px; font-family: Arial;" onClick="window.open(this.href, this.target, 'width=1000,height=600,scrollbars=YES,top=60,left=400'); return false;">REPORTE</a>
              </td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="piramide_sospechas_mun_gestion.php?idsospecha_diag_mun=<?php echo $idsospecha_diag_deptal;?>&idmunicipio=<?php echo $row_m[0];?>&gestion=<?php echo $gestion?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=400,scrollbars=YES,top=50,left=300'); return false;">             
              GRUPOS</a>
              </td>
		     <!--- <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">&nbsp;</td> --->
	        </tr>
            <?php
        $numero_m=$numero_m+1;
        }
        while ($row_m = mysqli_fetch_array($result_m));
        } else {
        }
        ?>
	      </tbody>
    </table>

</body>
</html>