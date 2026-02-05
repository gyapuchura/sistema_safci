<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$idmunicipio = '199';

$sql_mun = " SELECT idmunicipio, municipio FROM municipios WHERE idmunicipio='$idmunicipio' ";
$result_mun = mysqli_query($link,$sql_mun);
$row_mun = mysqli_fetch_array($result_mun);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>CONSUMO DIARIO DE ALIMENTOS</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>


<script type="text/javascript">
$(function () {
    $('#consumo_diario_alimentos').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'b) Consumo diario de alimentos - Mun. <?php echo mb_strtoupper($row_mun[1]);?>'
        },
        subtitle: {
            text: 'Fuente: Sistema Medi-Safci al <?php echo $f_emision;?>'
        },
        xAxis: {
            categories: [  'DIAGNÓSTICOS'  ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Consumo diario de alimentos'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}  Diagnósticos</b></td></tr>',
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
$sql2 = " SELECT diagnostico_psafci.idpatologia, patologia.patologia, patologia.cie FROM diagnostico_psafci, patologia ";
$sql2.= " WHERE diagnostico_psafci.idpatologia=patologia.idpatologia AND cie LIKE '%Z%' ";
$sql2.= " GROUP BY diagnostico_psafci.idpatologia ";
$result2 = mysqli_query($link,$sql2);
$total2 = mysqli_num_rows($result2);
 if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
	?>

{ name: '<?php  echo $row2[1];?> - <?php  echo $row2[2];?>',

<?php
$sql_a =" SELECT count(diagnostico_psafci.iddiagnostico_psafci) FROM diagnostico_psafci, atencion_psafci ";
$sql_a.=" WHERE diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci AND atencion_psafci.iddepartamento='1' ";
$sql_a.=" AND diagnostico_psafci.idpatologia = '$row2[0]' ";
$result_a = mysqli_query($link,$sql_a);
$row_a = mysqli_fetch_array($result_a);
?>

    data: [ <?php echo $row_a[0]; ?> ]
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
<script src="../js/highcharts-3d.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="consumo_diario_alimentos" style="min-width: 410px; height: 400px; margin: 0 auto"></div>

<table width="646" border="1" align="center" bordercolor="#009999">
    <tr>
        <td width="21" bgcolor="#FFFFFF" style="font-family: Arial;"><span class="Estilo8 Estilo1 Estilo2" style="font-size: 12px"> N° </span></td>
        <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">Consumo diario de alimentos</span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">SI</span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">NO</span></td>
    </tr>
<?php
            $numero = 1;
            $sql = " SELECT iditem_determinante_salud, item_determinante_salud FROM item_determinante_salud WHERE iddeterminante_salud='4' AND idcat_determinante_salud='21' ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {

            $sql_si = " SELECT count(determinante_salud_cf.valor_cf) FROM determinante_salud_cf, carpeta_familiar ";
            $sql_si.= " WHERE  determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
            $sql_si.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
            $sql_si.= " AND determinante_salud_cf.iditem_determinante_salud='$row[0]' AND determinante_salud_cf.valor_cf='1'  ";
            $result_si = mysqli_query($link,$sql_si);
            $row_si = mysqli_fetch_array($result_si);
            $res_si = $row_si[0];

            $sql_no = " SELECT count(determinante_salud_cf.valor_cf) FROM determinante_salud_cf, carpeta_familiar ";
            $sql_no.= " WHERE determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
            $sql_no.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
            $sql_no.= " AND determinante_salud_cf.iditem_determinante_salud='$row[0]' AND determinante_salud_cf.valor_cf='5'  ";
            $result_no = mysqli_query($link,$sql_no);
            $row_no = mysqli_fetch_array($result_no);
            $res_no = $row_no[0];

            ?>
                <tr>
                    <td width="21" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $numero;?></td>
                    <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row[1];?></td>
                    <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $res_si;?></td>
                    <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $res_no;?></td>
                    </tr> 

                <?php
                $numero++;                    
            } while ($row = mysqli_fetch_array($result));
            } else {
            /*
            Si no se encontraron resultados
            */
            }
            ?>
    </table>

	</body>
</html>