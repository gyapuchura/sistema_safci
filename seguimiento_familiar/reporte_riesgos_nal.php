<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>RIESGO PERSONAL - NACIONAL</title>

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
            text: 'VISITAS FAMILIARES POR RIÉSGO PERSONAL - NIVEL NACIONAL'
        },
        subtitle: {
            text: 'Fuente: REGISTRO SISTEMA MEDI-SAFCI al <?php echo $f_emision;?>'
        },
        xAxis: {
            categories: [

                <?php 
$numero = 0;
$sql = " SELECT idriesgo_personal_vf, riesgo_personal_vf FROM riesgo_personal_vf ORDER BY idriesgo_personal_vf ";
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
$sql3 = " SELECT idriesgo_personal_vf, riesgo_personal_vf FROM riesgo_personal_vf ORDER BY idriesgo_personal_vf ";
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
$sql_a.=" AND seguimiento_cf.idriesgo_personal_vf='$row3[0]'  ";
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
        <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° DE INTEGRANTES CON SEGUIMIENTOS PLANIFICADOS</td>
        <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° VISITAS PLANIFICADAS A INTEGRANTES A LA FECHA</td>
        <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° VISITAS REALIZADAS A INTEGRANTES A LA FECHA</td>
        <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° VISITAS NO REALIZADAS A LA FECHA</td>
    </tr>
            <?php 
            $numero3 = 1;
            $sql = " SELECT idriesgo_personal_vf, riesgo_personal_vf FROM riesgo_personal_vf ORDER BY idriesgo_personal_vf ";
            $result = mysqli_query($link,$sql);
            $total = mysqli_num_rows($result);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do { 
                
                $sql_int =" SELECT seguimiento_cf.idintegrante_cf FROM seguimiento_cf, carpeta_familiar  ";
                $sql_int.=" WHERE seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                $sql_int.=" AND seguimiento_cf.idriesgo_personal_vf='$row[0]' GROUP BY seguimiento_cf.idintegrante_cf ";
                $result_int = mysqli_query($link,$sql_int);
                $integrantes = mysqli_num_rows($result_int);              
                
                $sql_vf =" SELECT visita_cf.idvisita_cf FROM visita_cf, seguimiento_cf, carpeta_familiar ";
                $sql_vf.=" WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_vf.=" AND seguimiento_cf.idriesgo_personal_vf='$row[0]'  ";
                $result_vf = mysqli_query($link,$sql_vf);
                $visitas = mysqli_num_rows($result_vf);

                $sql_vfr =" SELECT visita_cf.idvisita_cf FROM visita_cf, seguimiento_cf, carpeta_familiar ";
                $sql_vfr.=" WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_vfr.=" AND seguimiento_cf.idriesgo_personal_vf='$row[0]' AND visita_cf.idestado_visita_cf='3' ";
                $result_vfr = mysqli_query($link,$sql_vfr);
                $visitas_r  = mysqli_num_rows($result_vfr);

                $visitas_nr = $visitas-$visitas_r;
                
                ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero3;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[1];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $integrantes;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="visitas_safci_rp_nal.php?idriesgo_personal_vf=<?php echo $row[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1200,height=1000,scrollbars=YES'); return false;">
              <?php echo $visitas;?></a>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="visitas_safci_rp_r_nal.php?idriesgo_personal_vf=<?php echo $row[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1200,height=1000,scrollbars=YES'); return false;">
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


<h4 style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">INFORME DE VISITAS AL <?php echo $f_emision;?> - NIVEL NACIONAL </h4>
<table width="900" border="0" align="center">
  <tbody>

    <tr>
      <td width="600"><span style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">N° DE FAMILIAS CARPETIZADAS =
  <?php
    $sql_cf =" SELECT idcarpeta_familiar FROM carpeta_familiar WHERE estado='CONSOLIDADO' ";
    $result_cf = mysqli_query($link,$sql_cf);
    $carpetizacion = mysqli_num_rows($result_cf);  
    $carpetizacion_nal  = number_format($carpetizacion, 0, '', '.');
    echo $carpetizacion_nal;
  ?>
      </span></td>
      <td width="400">

      </td>
    </tr>

        <tr>
      <td width="600"><span style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">N° DE INTEGRANTES CARPETIZADOS =
    <?php
      $sql_int =" SELECT integrante_cf.idintegrante_cf FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
      $sql_int.=" AND carpeta_familiar.estado='CONSOLIDADO' ";
      $result_int = mysqli_query($link,$sql_int);
      $integrantes = mysqli_num_rows($result_int);  
      $integrantes_cf  = number_format($integrantes, 0, '.', '.');
      echo $integrantes_cf;
    ?>
      </span></br></br></td>
      <td width="400">

      </td>
    </tr>

    <tr>
      <td width="600"><span style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">N° DE FAMILIAS CON PLANIFICACIÓN DE VISITAS =
    <?php 
    $sql_cf =" SELECT seguimiento_cf.idcarpeta_familiar FROM seguimiento_cf, carpeta_familiar WHERE seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
    $sql_cf.=" AND carpeta_familiar.estado='CONSOLIDADO' GROUP BY seguimiento_cf.idcarpeta_familiar ";
    $result_cf = mysqli_query($link,$sql_cf);
    $row_cf = mysqli_num_rows($result_cf);
    $seguimientos_cf  = number_format($row_cf, 0, '.', '.');
    echo $seguimientos_cf;?>
      </span></td>
      <td width="400">

      </td>
    </tr>
    <tr>
      <td width="600"><span style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">N° DE INTEGRANTES CON SEGUIMIENTOS PLANIFICADOS =
          <?php 

    $sql_seg =" SELECT seguimiento_cf.idintegrante_cf FROM seguimiento_cf, carpeta_familiar  ";
    $sql_seg.=" WHERE seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
    $sql_seg.=" GROUP BY seguimiento_cf.idintegrante_cf ";
    $result_seg = mysqli_query($link,$sql_seg);
    $row_seg = mysqli_num_rows($result_seg); 
    $seguimientos_int  = number_format($row_seg, 0, '.', '.');
    echo $seguimientos_int;?>
      </span></td>
      <td width="400">

      </td>
    </tr>
    <tr>
      <td><span style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">N° TOTAL DE VISITAS PLANIFICADAS =
          <?php 
    $sql_pr =" SELECT count(visita_cf.idvisita_cf) FROM visita_cf, seguimiento_cf, carpeta_familiar WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf  ";
    $sql_pr.=" AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
    $result_pr = mysqli_query($link,$sql_pr);
    $row_pr = mysqli_fetch_array($result_pr);
    $planificadas  = number_format($row_pr[0], 0, '.', '.');
    echo $planificadas?>
      </span></td>
     <td width="400">
      </td>
    </tr>
    <tr>
      <td><span style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">N° TOTAL DE VISITAS REALIZADAS =
          <?php 
    $sql_re =" SELECT count(visita_cf.idvisita_cf) FROM visita_cf, seguimiento_cf, carpeta_familiar WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf  ";
    $sql_re.=" AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND visita_cf.idestado_visita_cf='3' ";
    $result_re = mysqli_query($link,$sql_re);
    $row_re = mysqli_fetch_array($result_re);
    $realizadas  = number_format($row_re[0], 0, '.', '.');
    echo $realizadas;?>
      </span></td>
     <td width="400"><span style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">
        % DE CUMPLIMIENTO DE VISITAS = 
        <?php
            $cumplimiento = $row_re[0]*100/$row_pr[0];
            $p_cumplimiento  = number_format($cumplimiento, 2, '.', '.');
            echo $p_cumplimiento;
        ?> % </span>
      </td>
    </tr>
  </tbody>
</table>

            </br>
            </br>

	</body>
</html>