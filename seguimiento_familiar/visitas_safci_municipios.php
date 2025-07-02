<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram = date("Ymd");
$fecha 	   = date("Y-m-d");
$gestion   = date("Y");
$mes       = date("m");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$idmunicipio = $_GET['idmunicipio'];

$sql_mun =" SELECT idmunicipio, municipio FROM municipios ";
$sql_mun.=" WHERE idmunicipio='$idmunicipio' ";
$result_mun = mysqli_query($link,$sql_mun);
$row_mun = mysqli_fetch_array($result_mun);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>MEDI-SAFCI VISITAS FAMILIARES - MUNICIPIO</title>

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
            text: 'VISITAS FAMILIARES POR RIÉSGO PERSONAL - <?php echo "MUNICIPIO : ".$row_mun[1];?> '
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
$sql = " SELECT visita_cf.fecha_visita FROM visita_cf, seguimiento_cf, carpeta_familiar WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf ";
$sql.= " AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND visita_cf.fecha_visita < '$fecha' ";
$sql.= " AND carpeta_familiar.idmunicipio='$idmunicipio' GROUP BY visita_cf.fecha_visita ORDER BY visita_cf.fecha_visita ";
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
                text: 'VISITAS SAFCI DIARIAS'
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' VISITAS '
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            areaspline: {
                fillOpacity: 0.5
            }
        },
        series: [
            {
            name: ' VISITAS PLANIFICADAS',
            data: [

             <?php

$numero = 0;
$sql = " SELECT visita_cf.fecha_visita FROM visita_cf, seguimiento_cf, carpeta_familiar WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf ";
$sql.= " AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND visita_cf.fecha_visita < '$fecha' ";
$sql.= " AND carpeta_familiar.idmunicipio='$idmunicipio' GROUP BY visita_cf.fecha_visita ORDER BY visita_cf.fecha_visita ";
$result = mysqli_query($link,$sql);
$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT visita_cf.idvisita_cf, visita_cf.fecha_visita FROM visita_cf, seguimiento_cf, carpeta_familiar WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf ";
$sql7.= " AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND visita_cf.fecha_visita='$row[0]' ";
$sql7.= " AND carpeta_familiar.idmunicipio='$idmunicipio' AND visita_cf.idestado_visita_cf='1' ";
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
            name: ' VISITAS NO REALIZADAS ',
            data: [

             <?php

$numero = 0;
$sql = " SELECT visita_cf.fecha_visita FROM visita_cf, seguimiento_cf, carpeta_familiar WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf ";
$sql.= " AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND visita_cf.fecha_visita < '$fecha' ";
$sql.= " AND carpeta_familiar.idmunicipio='$idmunicipio' GROUP BY visita_cf.fecha_visita ORDER BY visita_cf.fecha_visita ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT visita_cf.idvisita_cf, visita_cf.fecha_visita FROM visita_cf, seguimiento_cf, carpeta_familiar WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf ";
$sql7.= " AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND visita_cf.fecha_visita='$row[0]' ";
$sql7.= " AND carpeta_familiar.idmunicipio='$idmunicipio' AND visita_cf.idestado_visita_cf='2' ";
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
        },
         {
            name: ' VISITAS REALIZADAS',
            data: [

             <?php

$numero = 0;
$sql = " SELECT visita_cf.fecha_visita FROM visita_cf, seguimiento_cf, carpeta_familiar WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf ";
$sql.= " AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND visita_cf.fecha_visita < '$fecha' ";
$sql.= " AND carpeta_familiar.idmunicipio='$idmunicipio' GROUP BY visita_cf.fecha_visita ORDER BY visita_cf.fecha_visita ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT visita_cf.idvisita_cf, visita_cf.fecha_visita FROM visita_cf, seguimiento_cf, carpeta_familiar WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf ";
$sql7.= " AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND visita_cf.fecha_visita='$row[0]' ";
$sql7.= " AND carpeta_familiar.idmunicipio='$idmunicipio' AND visita_cf.idestado_visita_cf='3' ";
$result7 = mysqli_query($link,$sql7);
$row7 = mysqli_num_rows($result7);

$cifra_diaria3 = $row7;
?>
             <?php echo $cifra_diaria3; ?>

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



    ]
    });
});
		</script>
	</head>
	<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>
<div id="container" style="min-width: 300px; height: 350px; margin: 0 auto"></div>

<h4 style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">INFORME DE VISITAS DEL MUNICIPIO AL <?php echo $f_emision;?></h4>
<table width="900" border="0" align="center">
  <tbody>

   <tr>
      <td width="600"><span style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">N° DE FAMILIAS CARPETIZADAS =
  <?php
    $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND idmunicipio='$idmunicipio' ";
    $result_cf = mysqli_query($link,$sql_cf);
    $row_cf = mysqli_fetch_array($result_cf);  
    $carpetizacion = $row_cf[0];
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
        $sql_int =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
        $sql_int.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_cf.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
        $result_int = mysqli_query($link,$sql_int);
        $row_int = mysqli_fetch_array($result_int);  
        $integrantes = $row_int[0];
      $integrantes_cf  = number_format($integrantes, 0, '.', '.');
      echo $integrantes_cf;
    ?>
      </span></br></br></td>
      <td width="400">

      </td>
    </tr>

    <tr>
    <td width="800"><span style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">N° DE FAMILIAS CON PLANIFICACIÓN DE VISITAS =
    <?php 
    $sql_cf =" SELECT seguimiento_cf.idcarpeta_familiar FROM seguimiento_cf, carpeta_familiar WHERE seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
    $sql_cf.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio' GROUP BY seguimiento_cf.idcarpeta_familiar ";
    $result_cf = mysqli_query($link,$sql_cf);
    $row_cf = mysqli_num_rows($result_cf);
    $seguimientos_cf  = number_format($row_cf, 0, '.', '.');
    echo $seguimientos_cf;?>
      </span></td>
      <td width="200">

      </td>
    </tr>
    <tr>
      <td width="800"><span style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">N° DE INTEGRANTES CON SEGUIMIENTO PLANIFICADO =
          <?php 
    $sql_seg =" SELECT count(seguimiento_cf.idseguimiento_cf) FROM seguimiento_cf, carpeta_familiar WHERE seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
    $sql_seg.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
    $result_seg = mysqli_query($link,$sql_seg);
    $row_seg = mysqli_fetch_array($result_seg);
    $seguimientos_int  = number_format($row_seg[0], 0, '.', '.');
    echo $seguimientos_int;?>
      </span></td>
      <td width="200">

      </td>
    </tr>
    <tr>
      <td><span style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">N° VISITAS PLANIFICADAS  =
          <?php 
    $sql_pr =" SELECT count(visita_cf.idvisita_cf) FROM visita_cf, seguimiento_cf, carpeta_familiar WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf  ";
    $sql_pr.=" AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.idmunicipio='$idmunicipio' ";
    $result_pr = mysqli_query($link,$sql_pr);
    $row_pr = mysqli_fetch_array($result_pr);
    $planificadas  = number_format($row_pr[0], 0, '.', '.');
    echo $planificadas?>
      </span></td>
      <td>
      </td>
    </tr>
    <tr>
      <td><span style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">N° VISITAS REALIZADAS =
          <?php 
    $sql_re =" SELECT count(visita_cf.idvisita_cf) FROM visita_cf, seguimiento_cf, carpeta_familiar WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf  ";
    $sql_re.=" AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.idmunicipio='$idmunicipio' AND visita_cf.idestado_visita_cf='3' ";
    $result_re = mysqli_query($link,$sql_re);
    $row_re = mysqli_fetch_array($result_re);
    $realizadas  = number_format($row_re[0], 0, '.', '.');
    echo $realizadas;?>
      </span></td>
     
    <td width="400"><span style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">
        % DE CUMPLIMIENTO = 
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
                    <form name="REPORTE_VF" action="reporte_visitas_mun_excel.php" method="post">
                      <input type="hidden" name="idmunicipio" value="<?php echo $idmunicipio;?>">
                        <p style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">
                        <button type="submit" class="btn btn-success">REPORTE VISITAS EN EXCEL</button>
                        &nbsp;</p>
                    </form>

<table width="900" border="1" align="center" cellspacing="0">
    <tbody>
    <tr>
        <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
        <td width="199" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">ESTABLECIMIENTO</td>
        <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° FAMILIAS CON PLANIFICACIÓN DE VISITAS</td>
        <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° DE INTEGRANTES CON SEGUIMIENTOS PLANIFICADOS</td>
        <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° VISITAS PLANIFICADAS (TOTAL)</td>
        <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° VISITAS REALIZADAS (TOTAL)</td>
        <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° VISITAS NO REALIZADAS (TOTAL)</td>
    </tr>
    <?php
    $numero=1; 
    $sql =" SELECT carpeta_familiar.idestablecimiento_salud, establecimiento_salud.establecimiento_salud FROM seguimiento_cf, carpeta_familiar, establecimiento_salud ";
    $sql.=" WHERE seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
    $sql.=" AND carpeta_familiar.idmunicipio='$idmunicipio' GROUP BY carpeta_familiar.idestablecimiento_salud ";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);           
    while ($field = mysqli_fetch_field($result)){
    } do {

        $sql_mun =" SELECT seguimiento_cf.idcarpeta_familiar FROM seguimiento_cf, carpeta_familiar  ";
        $sql_mun.=" WHERE seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
        $sql_mun.=" AND carpeta_familiar.idestablecimiento_salud='$row[0]' GROUP BY seguimiento_cf.idcarpeta_familiar ";
        $result_mun = mysqli_query($link,$sql_mun);
        $familias_mun = mysqli_num_rows($result_mun);

        $sql_int =" SELECT seguimiento_cf.idintegrante_cf FROM seguimiento_cf, carpeta_familiar  ";
        $sql_int.=" WHERE seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
        $sql_int.=" AND carpeta_familiar.idestablecimiento_salud='$row[0]' GROUP BY seguimiento_cf.idintegrante_cf ";
        $result_int = mysqli_query($link,$sql_int);
        $integrantes = mysqli_num_rows($result_int);

        $sql_vf =" SELECT visita_cf.idvisita_cf FROM visita_cf, seguimiento_cf, carpeta_familiar ";
        $sql_vf.=" WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
        $sql_vf.=" AND carpeta_familiar.idestablecimiento_salud='$row[0]' ";
        $result_vf = mysqli_query($link,$sql_vf);
        $visitas = mysqli_num_rows($result_vf);

        $sql_vfr =" SELECT visita_cf.idvisita_cf FROM visita_cf, seguimiento_cf, carpeta_familiar ";
        $sql_vfr.=" WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
        $sql_vfr.=" AND carpeta_familiar.idestablecimiento_salud='$row[0]' AND visita_cf.idestado_visita_cf='3' ";
        $result_vfr = mysqli_query($link,$sql_vfr);
        $visitas_r  = mysqli_num_rows($result_vfr);

        $visitas_nr = $visitas-$visitas_r;
    ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero;?></td>
              <td style="font-size: 12px; font-family: Arial;"><?php echo $row[1];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $familias_mun;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $integrantes;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
                    <a href="visitas_safci_mes_est.php?idestablecimiento_salud=<?php echo $row[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1200,height=1000,scrollbars=YES'); return false;">
                    <?php echo $visitas;?></a>
                </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
                    <a href="visitas_safci_mes_est_r.php?idestablecimiento_salud=<?php echo $row[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1200,height=1000,scrollbars=YES'); return false;">
                    <?php echo $visitas_r;?></a>  
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $visitas_nr;?></td>
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