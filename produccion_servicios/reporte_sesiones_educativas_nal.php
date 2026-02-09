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
		<title>REPORTE SESIONES EDUCATIVAS</title>

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
            text: 'REPORTE SESIONES EDUCATIVAS PSAFCI - NACIONAL'
        },
        subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-SAFCI al <?php echo $f_emision;?>'
        },
        xAxis: {
            categories: [
                <?php 
$numero = 0;
$sql = " SELECT sesion_educativa.idcharla_psafci, charla_psafci.charla_psafci FROM sesion_educativa, charla_psafci  ";
$sql.= " WHERE sesion_educativa.idcharla_psafci=charla_psafci.idcharla_psafci GROUP BY sesion_educativa.idcharla_psafci ";
$result = mysqli_query($link,$sql);
$total = mysqli_num_rows($result);
 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>
 '<?php  echo $row[1];?> '

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
                text: ' Sesiones Educativas PSAFCI ',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' Sesiones'
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
name: 'SESIONES EDUCATIVAS',
data: [
    
    <?php 
$numero3 = 0;
$sql3 = " SELECT sesion_educativa.idcharla_psafci, charla_psafci.charla_psafci FROM sesion_educativa, charla_psafci  ";
$sql3.= " WHERE sesion_educativa.idcharla_psafci=charla_psafci.idcharla_psafci GROUP BY sesion_educativa.idcharla_psafci ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {

$sql4 =" SELECT count(idsesion_educativa) FROM sesion_educativa WHERE idcharla_psafci='$row3[0]' ";
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

<h4 align="center" style="font-family: Arial;">TOTAL DE SESIONES EDUCATIVAS = 
                <?php
                $sql_dgt = " SELECT count(idsesion_educativa) FROM sesion_educativa ";
                $result_dgt = mysqli_query($link,$sql_dgt);
                $row_dgt = mysqli_fetch_array($result_dgt);
                $sesiones_nal = $row_dgt[0];
                echo $sesiones_nal;
                ?>
</h4>
<table width="1000" border="1" align="center" bordercolor="#009999">
    <tr>
        <td width="50" bgcolor="#FFFFFF" style="font-family: Arial;"><span class="Estilo8 Estilo1 Estilo2" style="font-size: 12px"> N° </span></td>
        <td width="400" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">SESIONES EDUCATIVAS - PSAFCI</span></td>
            <?php
            $sql_d = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento != '10' ORDER BY iddepartamento ";
            $result_d = mysqli_query($link,$sql_d);
            if ($row_d = mysqli_fetch_array($result_d)){
            mysqli_field_seek($result_d,0);
            while ($field_d = mysqli_fetch_field($result_d)){
            } do { ?>
                <td width="200" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">
                
                <a href="reporte_sesiones_educativas_depto.php?iddepartamento=<?php echo $row_d[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1420,height=820,scrollbars=YES,top=50,left=200'); return false;"><?php echo $row_d[1] ?></a> </span></td>
            <?php                  
            } while ($row_d = mysqli_fetch_array($result_d));
            } else {  }
            ?>
            <td width="200" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">TOTAL DEPTO.</span></td>
        </tr>
            <?php
            $numero = 1;
            $sql = " SELECT sesion_educativa.idcharla_psafci, charla_psafci.charla_psafci FROM sesion_educativa, charla_psafci  ";
            $sql.= " WHERE sesion_educativa.idcharla_psafci=charla_psafci.idcharla_psafci GROUP BY sesion_educativa.idcharla_psafci ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {
           ?>
                <tr>
                    <td width="21" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $numero;?></td>
                    <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row[1];?></td>
            <?php
            $sql_d = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento != '10' ORDER BY iddepartamento ";
            $result_d = mysqli_query($link,$sql_d);
            if ($row_d = mysqli_fetch_array($result_d)){
            mysqli_field_seek($result_d,0);
            while ($field_d = mysqli_fetch_field($result_d)){
            } do {
                
                $sql_dg = " SELECT count(idsesion_educativa) FROM sesion_educativa WHERE idcharla_psafci='$row[0]' AND iddepartamento='$row_d[0]' ";
                $result_dg = mysqli_query($link,$sql_dg);
                $row_dg = mysqli_fetch_array($result_dg);
                $sesiones = $row_dg[0];
                
                ?>
                    <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $sesiones;?>
                
                
                
                </td>
            <?php                  
            } while ($row_d = mysqli_fetch_array($result_d));
            } else {  }
            ?>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;">

            <a href="sesiones_educativas_diario_nal.php?idcharla_psafci=<?php echo $row[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1420,height=820,scrollbars=YES,top=50,left=200'); return false;">
                <?php
                $sql_dgt = " SELECT count(idsesion_educativa) FROM sesion_educativa WHERE idcharla_psafci='$row[0]' ";
                $result_dgt = mysqli_query($link,$sql_dgt);
                $row_dgt = mysqli_fetch_array($result_dgt);
                $sesiones_charla = $row_dgt[0];
                echo $sesiones_charla;
                ?>
            </a>    

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