<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>REPORTE DIAGNOSTICOS POR MORBILIDAD</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
    <style type="text/css">
    ${demo.css}
            </style>
            <script type="text/javascript">
    $(function () {
    $('#container').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'REPORTE DIAGNÓSTICOS POR MORBILIDAD PSAFCI - NACIONAL'
        },
        subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-SAFCI al <?php echo $f_emision;?>'
        },
        xAxis: {
            categories: [
                <?php 
$numero = 0;
$sql = " SELECT diagnostico_psafci.idpatologia, patologia.patologia, patologia.cie FROM diagnostico_psafci, patologia ";
$sql.= " WHERE diagnostico_psafci.idpatologia=patologia.idpatologia AND patologia.cie NOT LIKE '%Z%' ";
$sql.= " GROUP BY diagnostico_psafci.idpatologia ";
$result = mysqli_query($link,$sql);
$total = mysqli_num_rows($result);
 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>
 '<?php  echo $row[1];?> - <?php  echo $row[2];?>'

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
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: ' Atenciones Preventivas PSAFCI ',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' Diagnósticos'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
      
        series: [
{
name: 'DIAGNÓSTICOS',
data: [
    
    <?php 
$numero3 = 0;
$sql3 = " SELECT diagnostico_psafci.idpatologia, patologia.patologia, patologia.cie FROM diagnostico_psafci, patologia ";
$sql3.= " WHERE diagnostico_psafci.idpatologia=patologia.idpatologia AND patologia.cie NOT LIKE '%Z%' ";
$sql3.= " GROUP BY diagnostico_psafci.idpatologia ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {

$sql4 =" SELECT count(diagnostico_psafci.iddiagnostico_psafci) FROM diagnostico_psafci, atencion_psafci ";
$sql4.=" WHERE diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci  ";
$sql4.=" AND diagnostico_psafci.idpatologia = '$row3[0]' ";
$result4 = mysqli_query($link,$sql4);
$row4 = mysqli_fetch_array($result4); 
?>

<?php  echo $row4[0]; ?>

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

}
?> 

] } ]

    });
});
		</script>

</head>
	<body>

<script src="../js/highcharts.js"></script>
<script src="../js/highcharts-3d.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; max-width: 850px; height: <?php echo $numero3*60;?>px; margin: 0 auto"></div>

<h4 align="center" style="font-family: Arial;">TOTAL DE DIAGNÓSTICOS POR MORBILIDAD = 
                <?php
                $sql_dgt = " SELECT count(diagnostico_psafci.iddiagnostico_psafci) FROM diagnostico_psafci, patologia ";
                $sql_dgt.= " WHERE diagnostico_psafci.idpatologia=patologia.idpatologia ";
                $sql_dgt.= " AND patologia.cie NOT LIKE '%Z%' ";
                $result_dgt = mysqli_query($link,$sql_dgt);
                $row_dgt = mysqli_fetch_array($result_dgt);
                $diagnostico_nal = $row_dgt[0];
                echo $diagnostico_nal;
                ?>
</h4>
<table width="1000" border="1" align="center" bordercolor="#009999">
    <tr>
        <td width="50" bgcolor="#FFFFFF" style="font-family: Arial;"><span class="Estilo8 Estilo1 Estilo2" style="font-size: 12px"> N° </span></td>
        <td width="400" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">DIAGNÓSTICOS PSAFCI</span></td>
        <td width="50" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">CIE</span></td>
            <?php
            $sql_d = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento != '10' ORDER BY iddepartamento ";
            $result_d = mysqli_query($link,$sql_d);
            if ($row_d = mysqli_fetch_array($result_d)){
            mysqli_field_seek($result_d,0);
            while ($field_d = mysqli_fetch_field($result_d)){
            } do { ?>
                <td width="200" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">
                
                <a href="reporte_por_morbilidad_dep.php?iddepartamento=<?php echo $row_d[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1420,height=820,scrollbars=YES,top=50,left=200'); return false;"><?php echo $row_d[1] ?></a> </span></td>
            <?php                  
            } while ($row_d = mysqli_fetch_array($result_d));
            } else {  }
            ?>
            <td width="200" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">TOTAL DEPTO.</span></td>
        </tr>
            <?php
            $numero = 1;
            $sql = " SELECT diagnostico_psafci.idpatologia, patologia.patologia, patologia.cie FROM diagnostico_psafci, patologia ";
            $sql.= " WHERE diagnostico_psafci.idpatologia=patologia.idpatologia AND patologia.cie NOT LIKE '%Z%' ";
            $sql.= " GROUP BY diagnostico_psafci.idpatologia ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {
           ?>
                <tr>
                    <td width="21" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $numero;?></td>
                    <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row[1];?></td>
                    <td width="50" bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $row[2];?></td>
            <?php
            $sql_d = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento != '10' ORDER BY iddepartamento ";
            $result_d = mysqli_query($link,$sql_d);
            if ($row_d = mysqli_fetch_array($result_d)){
            mysqli_field_seek($result_d,0);
            while ($field_d = mysqli_fetch_field($result_d)){
            } do {
                
                $sql_dg = " SELECT count(diagnostico_psafci.iddiagnostico_psafci) FROM diagnostico_psafci, atencion_psafci ";
                $sql_dg.= " WHERE diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci AND atencion_psafci.iddepartamento='$row_d[0]' ";
                $sql_dg.= " AND diagnostico_psafci.idpatologia = '$row[0]' ";
                $result_dg = mysqli_query($link,$sql_dg);
                $row_dg = mysqli_fetch_array($result_dg);
                $diagnosticos = $row_dg[0];
                
                ?>
                    <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $diagnosticos;?>
                
                
                
                </td>
            <?php                  
            } while ($row_d = mysqli_fetch_array($result_d));
            } else {  }
            ?>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;">
                <?php
                $sql_dgt = " SELECT count(diagnostico_psafci.iddiagnostico_psafci) FROM diagnostico_psafci, atencion_psafci ";
                $sql_dgt.= " WHERE diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci ";
                $sql_dgt.= " AND diagnostico_psafci.idpatologia = '$row[0]' ";
                $result_dgt = mysqli_query($link,$sql_dgt);
                $row_dgt = mysqli_fetch_array($result_dgt);
                $diagnostico_pat = $row_dgt[0];
                echo $diagnostico_pat;
                ?>
            </td>
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
</br>


	</body>
</html>