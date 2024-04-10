<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ENFERMEDADES - NIVEL NACIONAL</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
        ${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'INMUNOPREVENIBLES - NIVEL NACIONAL'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Porcentaje',
            data: [
                <?php
                    $sql0 = " SELECT SUM(registro_enfermedad.cifra) FROM registro_enfermedad, notificacion_ep, sospecha_diag  ";
                    $sql0.= " WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND  ";
                    $sql0.= " registro_enfermedad.idsospecha_diag=sospecha_diag.idsospecha_diag AND sospecha_diag.idcat_registro='2' AND  ";
                    $sql0.= " registro_enfermedad.cifra !='0' AND registro_enfermedad.gestion='$gestion' AND notificacion_ep.estado='CONSOLIDADO' ";
                    $result0 = mysqli_query($link,$sql0);
                    $row0 = mysqli_fetch_array($result0);
                    $total = $row0[0];

                    $numero = 0;
                    $sql = " SELECT registro_enfermedad.idsospecha_diag FROM registro_enfermedad, notificacion_ep, sospecha_diag  ";
                    $sql.= " WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND  ";
                    $sql.= " registro_enfermedad.idsospecha_diag=sospecha_diag.idsospecha_diag AND sospecha_diag.idcat_registro='2' ";
                    $sql.= " AND notificacion_ep.estado='CONSOLIDADO' AND  registro_enfermedad.cifra !='0' ";
                    $sql.= " AND registro_enfermedad.gestion='$gestion' GROUP BY registro_enfermedad.idsospecha_diag ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t    = " SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idsospecha_diag ='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t    = mysqli_fetch_array($result_t);

                    $sql_c = " SELECT SUM(registro_enfermedad.cifra) FROM registro_enfermedad, notificacion_ep, sospecha_diag  ";
                    $sql_c.= " WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND  ";
                    $sql_c.= " registro_enfermedad.idsospecha_diag=sospecha_diag.idsospecha_diag AND sospecha_diag.idcat_registro='2' ";
                    $sql_c.= " AND registro_enfermedad.cifra !='0' AND registro_enfermedad.idsospecha_diag='$row[0]'  ";
                    $sql_c.= " AND registro_enfermedad.gestion='$gestion' AND notificacion_ep.estado='CONSOLIDADO' ";
                    $result_c = mysqli_query($link,$sql_c);
                    $row_c = mysqli_fetch_array($result_c);
                    $conteo = $row_c[0];

                    $p_conteo   = ($conteo*100)/$total;
                    $porcentaje    = number_format($p_conteo, 2, '.', '');

                    ?>

                    ['<?php echo $row_t[1];?>', <?php echo $porcentaje;?>]

                        <?php
                        $numero++;
                        if ($numero == $conteo_tipo) {
                        echo "";
                        }
                        else {
                        echo ",";
                        }
                        
                    } while ($row = mysqli_fetch_array($result));
                    } else {
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
<span style="font-size: 12px"></span><span style="font-family: Arial"></span><span style="font-size: 12px"></span><span style="font-size: 12px"></span>
<script src="../js/highcharts.js"></script>
<script src="../js/highcharts-3d.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="height: 400px"></div>

<table width="768" border="1" align="center" bordercolor="#009999">

    <tr>
        <td width="22" bgcolor="#FFFFFF" class="Estilo8 Estilo1 Estilo2" style="font-family: Arial; font-size: 12px;"> N° </td>
        <td width="391" bgcolor="#FFFFFF" class="Estilo8 Estilo1 Estilo2" style="font-family: Arial; font-size: 12px;">REGISTRO EPIDEMIOLÓGICO</td>
        <td width="70" align="center" bgcolor="#FFFFFF" class="Estilo7" style="font-family: Arial; font-size: 12px;">CANTIDAD</td>
        <td width="78" align="center" bgcolor="#FFFFFF" class="Estilo7" style="font-family: Arial; font-size: 12px;">  %</td>
        <td width="173" align="center" bgcolor="#FFFFFF" class="Estilo7" style="font-family: Arial; font-size: 12px;">VER</td>
    </tr>

<?php

$sql_ta = " SELECT SUM(registro_enfermedad.cifra) FROM registro_enfermedad, notificacion_ep, sospecha_diag  ";
$sql_ta.= " WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND  ";
$sql_ta.= " registro_enfermedad.idsospecha_diag=sospecha_diag.idsospecha_diag AND sospecha_diag.idcat_registro='2' AND  ";
$sql_ta.= " registro_enfermedad.cifra !='0' AND registro_enfermedad.gestion='$gestion' AND notificacion_ep.estado='CONSOLIDADO' ";
$result_ta = mysqli_query($link,$sql_ta);
$row_ta = mysqli_fetch_array($result_ta);
$total_ta = $row_ta[0];

$numeroa = 1;
$sqla = " SELECT registro_enfermedad.idsospecha_diag FROM registro_enfermedad, notificacion_ep, sospecha_diag   ";
$sqla.= " WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND ";
$sqla.= " registro_enfermedad.idsospecha_diag=sospecha_diag.idsospecha_diag AND sospecha_diag.idcat_registro='2' ";
$sqla.= " AND notificacion_ep.estado='CONSOLIDADO' AND  registro_enfermedad.cifra !='0' ";
$sqla.= " AND registro_enfermedad.gestion='$gestion' GROUP BY registro_enfermedad.idsospecha_diag ";
$resulta = mysqli_query($link,$sqla);
 if ($rowa = mysqli_fetch_array($resulta)){
mysqli_field_seek($resulta,0);
while ($fielda = mysqli_fetch_field($resulta)){
} do {

$sql_ta = " SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idsospecha_diag ='$rowa[0]' ";
$result_ta = mysqli_query($link,$sql_ta);
$row_ta = mysqli_fetch_array($result_ta);

$sql_ca = " SELECT SUM(registro_enfermedad.cifra) FROM registro_enfermedad, notificacion_ep, sospecha_diag  ";
$sql_ca.= " WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND  ";
$sql_ca.= " registro_enfermedad.idsospecha_diag=sospecha_diag.idsospecha_diag AND sospecha_diag.idcat_registro='2' ";
$sql_ca.= " AND registro_enfermedad.cifra !='0' AND registro_enfermedad.idsospecha_diag='$rowa[0]'  ";
$sql_ca.= " AND registro_enfermedad.gestion='$gestion' AND notificacion_ep.estado='CONSOLIDADO' ";
$result_ca = mysqli_query($link,$sql_ca);
$row_ca = mysqli_fetch_array($result_ca);
$conteoa = $row_ca[0];

$p_conteoa   = ($conteoa*100)/$total_ta;

$porcentajea = number_format($p_conteoa, 2, '.', '');

?>
        <tr>
          <td width="22" bgcolor="#FFFFFF" class="Estilo8 Estilo1 Estilo2"><?php echo $numeroa;?></td>
          <td width="391" bgcolor="#FFFFFF" class="Estilo8 Estilo1 Estilo2"><?php echo $row_ta[1];?></td>
          <td align="center" bgcolor="#FFFFFF" class="Estilo7"><?php echo $conteoa;?></td>
          <td width="78" align="center" bgcolor="#FFFFFF" class="Estilo7"><?php echo $porcentajea;?> %</td>
          <td bgcolor="#FFFFFF" align="center" class="Estilo8 Estilo1 Estilo2">

          <a class="btn btn-primary btn-icon-split" href="marco_ep_nacional.php?sospecha_diag_nal=<?php echo $rowa[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=650,scrollbars=YES,top=50,left=300'); return false;">
        REPORTE NACIONAL</a>
        </td>
        </tr>   
        <?php
        $numeroa=$numeroa+1;
} while ($rowa = mysqli_fetch_array($resulta));
} else {
/*
Si no se encontraron resultados
*/
}
?>
        <tr>
          <td width="22" bgcolor="#FFFFFF" class="Estilo8 Estilo1 Estilo2">&nbsp;</td>
          <td width="391" bgcolor="#FFFFFF" class="Estilo8 Estilo1 Estilo2">&nbsp;</td>
          <td align="center" bgcolor="#FFFFFF" class="Estilo7"><?php echo $total_ta;?></td>
          <td width="78" align="center" bgcolor="#FFFFFF" class="Estilo7"> 100 %</td>
          <td align="center" bgcolor="#FFFFFF" class="Estilo7">&nbsp;</td>
        </tr>
    </table>

	</body>
</html>