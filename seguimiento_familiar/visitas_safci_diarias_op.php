<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

$idusuario_op = $_GET['idusuario_op'];

$sqlus =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM nombre, usuarios ";
$sqlus.=" WHERE usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$idusuario_op' ";
$resultus = mysqli_query($link,$sqlus);
$rowus = mysqli_fetch_array($resultus);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>MEDI-SAFCI VISITAS FAMILIARES - OPERATIVO</title>

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
            text: 'VISITAS POR DÍA - <?php echo "MÉDICO : ".$rowus[0];?> <?php echo $rowus[1];?> <?php echo $rowus[2];?> : '
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
$sql = " SELECT fecha_visita FROM visita_cf WHERE fecha_visita LIKE '$gestion%' AND idusuario='$idusuario_op' GROUP BY fecha_visita ORDER BY fecha_visita ";
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
            valueSuffix: ' VISITAS FAMILIARES'
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
$sql = " SELECT fecha_visita FROM visita_cf WHERE fecha_visita LIKE '$gestion%' AND idusuario='$idusuario_op' GROUP BY fecha_visita ORDER BY fecha_visita ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT idvisita_cf, fecha_visita FROM visita_cf WHERE fecha_visita='$row[0]' AND idusuario='$idusuario_op' AND idestado_visita_cf='1'";
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
$sql = " SELECT fecha_visita FROM visita_cf WHERE fecha_visita LIKE '$gestion%' AND idusuario='$idusuario_op' GROUP BY fecha_visita ORDER BY fecha_visita ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT idvisita_cf, fecha_visita FROM visita_cf WHERE fecha_visita='$row[0]' AND idusuario='$idusuario_op' AND idestado_visita_cf='2' ";
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
$sql = " SELECT fecha_visita FROM visita_cf WHERE fecha_visita LIKE '$gestion%' AND idusuario='$idusuario_op' GROUP BY fecha_visita ORDER BY fecha_visita ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT idvisita_cf, fecha_visita FROM visita_cf WHERE fecha_visita='$row[0]' AND idusuario='$idusuario_op' AND idestado_visita_cf='3'";
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

<h4 style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">INFORME DE VISITAS POR RIESGO PERSONAL</h4>
<table width="900" border="0" align="center">
  <tbody>
    <tr>
      <td width="600"><span style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">N° DE INTEGRANTES CON SEGUIMIENTOS PLANIFICADOS =
          <?php 
    $sql_seg =" SELECT count(idseguimiento_cf) FROM seguimiento_cf WHERE idusuario='$idusuario_op' ";
    $result_seg = mysqli_query($link,$sql_seg);
    $row_seg = mysqli_fetch_array($result_seg);
    $seguimientos_int  = number_format($row_seg[0], 0, '.', '.');
    echo $seguimientos_int;?>
      </span></td>
      <td width="200">

      </td>
    </tr>
    <tr>
      <td><span style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">N° VISITAS PROGRAMADAS =
          <?php 
    $sql_pr =" SELECT count(idvisita_cf) FROM visita_cf WHERE idusuario='$idusuario_op' ";
    $result_pr = mysqli_query($link,$sql_pr);
    $row_pr = mysqli_fetch_array($result_pr);
    $programadas  = number_format($row_pr[0], 0, '.', '.');
    echo $programadas?>
      </span></td>
      <td>
      </td>
    </tr>
    <tr>
      <td><span style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">N° VISITAS REALIZADAS =
          <?php 
    $sql_re =" SELECT count(idvisita_cf) FROM visita_cf WHERE idestado_visita_cf='3' AND idusuario='$idusuario_op'";
    $result_re = mysqli_query($link,$sql_re);
    $row_re = mysqli_fetch_array($result_re);
    $realizadas  = number_format($row_re[0], 0, '.', '.');
    echo $realizadas;?>
      </span></td>
      <td>
      </td>
    </tr>
  </tbody>
</table>

</br>
</br>
<table width="1000" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
              <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">SEGUIMIENTO</td>
              <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">PERSONA VISITADA</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">VISITA</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">DEPARTAMENTO</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">MUNICIPIO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ESTABLECIMIENTO</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ÁREA DE INFLUENCIA</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ESTADO DE LA VISITA</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">MÉDICO OPERATIVO</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">FECHA DE REGISTRO:</td>

		     <!--- <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">F302A</td>  --->
	        </tr>
            <?php
    $numero=1; 
    $sql =" SELECT visita_cf.idvisita_cf, visita_cf.idseguimiento_cf, visita_cf.fecha_visita, estado_visita_cf.estado_visita_cf, visita_cf.idusuario,";
    $sql.="  visita_cf.fecha_registro, visita_cf.hora_registro, visita_cf.numero_visita FROM visita_cf, estado_visita_cf  ";
    $sql.=" WHERE visita_cf.idestado_visita_cf=estado_visita_cf.idestado_visita_cf AND visita_cf.idusuario='$idusuario_op' ORDER BY visita_cf.idvisita_cf DESC ";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);           
    while ($field = mysqli_fetch_field($result)){
    } do {

        $sql_v =" SELECT seguimiento_cf.idcarpeta_familiar, carpeta_familiar.codigo, nombre.nombre, nombre.paterno, nombre.materno, departamento.departamento, ";
        $sql_v.=" municipios.municipio, establecimiento_salud.establecimiento_salud, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia  ";
        $sql_v.=" FROM visita_cf, seguimiento_cf, carpeta_familiar, integrante_cf, nombre, departamento, municipios, establecimiento_salud, tipo_area_influencia, area_influencia  ";
        $sql_v.=" WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf AND seguimiento_cf.idintegrante_cf=integrante_cf.idintegrante_cf AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
        $sql_v.=" AND integrante_cf.idnombre=nombre.idnombre AND carpeta_familiar.iddepartamento=departamento.iddepartamento AND carpeta_familiar.idmunicipio=municipios.idmunicipio ";
        $sql_v.=" AND carpeta_familiar.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia ";
        $sql_v.=" AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND visita_cf.idvisita_cf ='$row[0]' ";
        $result_v = mysqli_query($link,$sql_v);
        $row_v = mysqli_fetch_array($result_v); 

    ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="imprime_seguimiento_familiar.php?idcarpeta_familiar=<?php echo $row_v[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1400,height=800,top=50, left=100, scrollbars=YES'); return false;">
              <?php echo $row_v[1];?></a>  
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo mb_strtoupper($row_v[2]." ".$row_v[3]." ".$row_v[4]);?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[7];?></td>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_v[5];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_v[6];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_v[7];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_v[8]." ".$row_v[9];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[3];?></td>
              <td style="font-size: 12px; font-family: Arial;">
              <?php 
                $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                $sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row[4]' ";
                $result_r = mysqli_query($link,$sql_r);
                $row_r = mysqli_fetch_array($result_r);                    
                echo mb_strtoupper($row_r[0]." ".$row_r[1]." ".$row_r[2]);?>
              </td>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                $fecha_r = explode('-',$row[5]);
                $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                <?php echo $f_registro;?> - <?php echo $row[6];?></td>
		     <!--- <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">&nbsp;</td> --->
	        </tr>
            <?php
        $numero=$numero+1;
        }
        while ($row = mysqli_fetch_array($result));
        } else {
        }
        ?>
</body>
</html>