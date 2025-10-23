<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$idmunicipio = $_GET['idmunicipio'];
$sql_d = " SELECT idmunicipio, municipio FROM municipios WHERE idmunicipio ='$idmunicipio'";
$result_d = mysqli_query($link,$sql_d);
$row_d = mysqli_fetch_array($result_d);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>RIESGO PERSONAL - MUNICIPIO</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'VISITAS FAMILIARES POR RIÉSGO PERSONAL - MUNICIPIO : <?php echo $row_d[1];?>'
        },
        subtitle: {
            text: 'Fuente: REGISTRO SISTEMA MEDI-SAFCI'
        },
        xAxis: {
            categories: [

                <?php 
$numero = 0;
$sql = " SELECT idriesgo_personal_vf, riesgo_personal_vf FROM riesgo_personal_vf WHERE idriesgo_personal_vf !='15' ORDER BY idriesgo_personal_vf ";
$result = mysqli_query($link,$sql);
$total = mysqli_num_rows($result);
 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>
 '<?php  echo $row[1];?>'

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
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'RIÉSGO PERSONAL'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} INTEGRANTES </b></td></tr>',
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


{ name: 'RIÉSGO PERSONAL',

    data: [
<?php 
$numero3 = 0;
$sql3 = " SELECT idriesgo_personal_vf, riesgo_personal_vf FROM riesgo_personal_vf WHERE idriesgo_personal_vf !='15' ORDER BY idriesgo_personal_vf ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
 if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
	?>
 
<?php
$sql_a =" SELECT COUNT(seguimiento_cf.idseguimiento_cf) FROM seguimiento_cf, carpeta_familiar  ";
$sql_a.=" WHERE seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_a.=" AND seguimiento_cf.idriesgo_personal_vf='$row3[0]' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
$result_a = mysqli_query($link,$sql_a);
$row_a = mysqli_fetch_array($result_a);
?>
<?php echo $row_a[0]; ?>
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

<div id="container" style="min-width: 400px; height: 420px; margin: 0 auto"></div>


<table width="1000" border="1" align="center" cellspacing="0">
    <tbody>
    <tr>
        <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
        <td width="299" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">RIÉSGO PERSONAL</td>
        <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">SEMAFORIZACIÓN</td>
        <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° DE INTEGRANTES CON SEGUIMIENTOS PLANIFICADOS</td>
        <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° VISITAS PLANIFICADAS A INTEGRANTES A LA FECHA</td>
        <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° VISITAS REALIZADAS A INTEGRANTES A LA FECHA</td>
        <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° VISITAS NO REALIZADASA A LA FECHA</td>
    </tr>
            <?php 
            $numero3 = 1;
            $sql = " SELECT idriesgo_personal_vf, riesgo_personal_vf, color, color_valor FROM riesgo_personal_vf ORDER BY idriesgo_personal_vf ";
            $result = mysqli_query($link,$sql);
            $total = mysqli_num_rows($result);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do { 
                
                $sql_int =" SELECT seguimiento_cf.idintegrante_cf FROM seguimiento_cf, carpeta_familiar  ";
                $sql_int.=" WHERE seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                $sql_int.=" AND carpeta_familiar.idmunicipio='$idmunicipio' AND seguimiento_cf.idriesgo_personal_vf='$row[0]' GROUP BY seguimiento_cf.idintegrante_cf ";
                $result_int = mysqli_query($link,$sql_int);
                $integrantes = mysqli_num_rows($result_int);              
                
                $sql_vf =" SELECT visita_cf.idvisita_cf FROM visita_cf, seguimiento_cf, carpeta_familiar ";
                $sql_vf.=" WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_vf.=" AND carpeta_familiar.idmunicipio='$idmunicipio' AND seguimiento_cf.idriesgo_personal_vf='$row[0]'  ";
                $result_vf = mysqli_query($link,$sql_vf);
                $visitas = mysqli_num_rows($result_vf);

                $sql_vfr =" SELECT visita_cf.idvisita_cf FROM visita_cf, seguimiento_cf, carpeta_familiar ";
                $sql_vfr.=" WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_vfr.=" AND carpeta_familiar.idmunicipio='$idmunicipio' AND seguimiento_cf.idriesgo_personal_vf='$row[0]' AND visita_cf.idestado_visita_cf='3' ";
                $result_vfr = mysqli_query($link,$sql_vfr);
                $visitas_r  = mysqli_num_rows($result_vfr);

                $visitas_nr = $visitas-$visitas_r;
                
                ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero3;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[1];?></td>
              <td <?php echo 'bgcolor="#'.$row[3].'" ';?> style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[2];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $integrantes;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="visitas_safci_rp_mun.php?idriesgo_personal_vf=<?php echo $row[0];?>&idmunicipio=<?php echo $idmunicipio;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1200,height=1000,scrollbars=YES'); return false;">
              <?php echo $visitas;?></a>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="visitas_safci_rp_r_mun.php?idriesgo_personal_vf=<?php echo $row[0];?>&idmunicipio=<?php echo $idmunicipio;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1200,height=1000,scrollbars=YES'); return false;">
              <?php echo $visitas_r;?></a> 
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $visitas_nr;?></td>
	        </tr>
                <?php 
                $numero3=$numero3+1;
                } while ($row = mysqli_fetch_array($result));
                } else {
                }
                ?>
	      </tbody>
    </table>




	</body>
</html>