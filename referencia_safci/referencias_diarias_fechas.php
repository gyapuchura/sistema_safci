<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$inicio = $_GET['inicio'];
$finalizacion = $_GET['finalizacion'];

$fecha_i = explode('-',$inicio);
$f_inicio = $fecha_i[2].'/'.$fecha_i[1].'/'.$fecha_i[0];

$fecha_f = explode('-',$finalizacion);
$f_finalizacion = $fecha_f[2].'/'.$fecha_f[1].'/'.$fecha_f[0];

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>MEDI-APS REFERENCIAS - DIARIAS</title>

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
            text: 'REFERENCIAS POR DIA SISTEMA MEDI-APS'
        },
         subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-APS del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
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
$sql = " SELECT fecha_registro FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY fecha_registro ORDER BY fecha_registro ";
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
                text: 'REFERENCIAS DIARIAS'
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' Derivaciones'
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
            name: 'REFERIDA',
            data: [

             <?php

$numero = 0;
$sql = " SELECT fecha_registro FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY fecha_registro ORDER BY fecha_registro ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT idreferencia_hc, fecha_registro FROM referencia_hc WHERE fecha_registro='$row[0]' AND idestado_referencia='1'";
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
            name: 'CONTRARREFERIDA',
            data: [

             <?php

$numero = 0;
$sql = " SELECT fecha_registro FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY fecha_registro ORDER BY fecha_registro ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT idreferencia_hc, fecha_registro FROM referencia_hc WHERE fecha_registro='$row[0]' AND idestado_referencia='2' ";
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
        } 
  ]
    });
});
		</script>
	</head>
	<body>
<script src="../js/referencia.js"></script>
<script src="../js/modules/exporting.js"></script>
<div id="container" style="min-width: 300px; height: 350px; margin: 0 auto"></div>

<h4 style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">INFORME DE REFERENCIAS MÉDICAS DEL <?php echo $f_inicio;?> AL <?php echo $f_finalizacion;?></h4>
<table width="900" border="0" align="center">
  <tbody>
    <tr>
      <td width="444"><span style="font-family: Arial; font-size: 16px; color: #000000; text-align: center;">N° REFERENCIAS REGISTRADAS =
          <?php 
    $sql_ps =" SELECT count(idreferencia_hc) FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
    $result_ps = mysqli_query($link,$sql_ps);
    $row_ps = mysqli_fetch_array($result_ps);
    $atenciones_ps  = number_format($row_ps[0], 0, '.', '.');
    echo $atenciones_ps;?>
      </span>
      </td>
      <td>
          <span style="font-family: Arial; font-size: 16px; color: #000000; text-align: center;">N° DE MUNICIPIOS =
          <?php 
            $sql_mun =" SELECT idmunicipio FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY idmunicipio ";
            $result_mun = mysqli_query($link,$sql_mun);
            $municipios = mysqli_num_rows($result_mun);
            echo $municipios;?>
      </td>
    </tr>
    <tr>
      <td width="446">
        <span style="font-family: Arial; font-size: 16px; color: #f7a35c ; text-align: center;">N° REFERIDAS = 
          <?php 
    $sql_vf =" SELECT count(idreferencia_hc) FROM referencia_hc WHERE idestado_referencia ='1' AND fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
    $result_vf = mysqli_query($link,$sql_vf);
    $row_vf = mysqli_fetch_array($result_vf);
    $visita  = number_format($row_vf[0], 0, '.', '.');
    echo $visita;?></span>
      </td>
      <td>
          <span style="font-family: Arial; font-size: 16px; color: #000000; text-align: center;">N° DE ESTABLECIMIENTOS DE SALUD =
          <?php 
            $sql_es =" SELECT idestablecimiento_salud FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY idestablecimiento_salud ";
            $result_es = mysqli_query($link,$sql_es);
            $establecimientos = mysqli_num_rows($result_es);
            echo $establecimientos;?>
      </td>
    </tr>
    <tr>
      <td>
        <span style="font-family: Arial; font-size: 16px; color: #5ca3f7 ; text-align: center;">N° CONTRARREFERIDAS = 
            <?php 
            $sql_vf =" SELECT count(idreferencia_hc) FROM referencia_hc WHERE idestado_referencia ='2' AND fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
            $result_vf = mysqli_query($link,$sql_vf);
            $row_vf = mysqli_fetch_array($result_vf);
            $visita  = number_format($row_vf[0], 0, '.', '.');
            echo $visita;?></span>
      </td>
      <td>
          <span style="font-family: Arial; font-size: 16px; color: #000000; text-align: center;">N° DE MÉDICOS =
          <?php 
            $sql_op =" SELECT idusuario FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY idusuario ";
            $result_op = mysqli_query($link,$sql_op);
            $medicos = mysqli_num_rows($result_op);
            echo $medicos;?>
      </td>
    </tr>
    <tr>
        <td><span style="font-family: Arial; font-size: 16px; color: #008f39 ; text-align: center;">N° REFERENCIAS POR TELESALUD = 
            <?php 
            $sql_con =" SELECT count(idreferencia_hc) FROM referencia_hc WHERE por_telesalud='SI' AND fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
            $result_con = mysqli_query($link,$sql_con);
            $row_con = mysqli_fetch_array($result_con);
            $consulta  = number_format($row_con[0], 0, '.', '.');
            echo $consulta?>
            </span>
        </td>
        <td><span style="font-family: Arial; font-size: 16px; color: #000000 ; text-align: center;">N° DE REDES DE SALUD = 
            <?php 
            $sql_es =" SELECT idred_salud FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY idred_salud ";
            $result_es = mysqli_query($link,$sql_es);
            $redes_salud = mysqli_num_rows($result_es);
            echo $redes_salud;?>
            </span>
        </td>
    </tr>
    <tr>
        <td><span style="font-family: Arial; font-size: 16px; color: #8085e9 ; text-align: center;">REFERENCIAS A PERSONAS CON DISCAPACIDAD =
          <?php 
            $sql_vf =" SELECT count(idreferencia_hc) FROM referencia_hc WHERE discapacidad='SI' AND fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
            $result_vf = mysqli_query($link,$sql_vf);
            $row_vf = mysqli_fetch_array($result_vf);
            $visita  = number_format($row_vf[0], 0, '.', '.');
            echo $visita;?>
            </span>
        </td>
        <td>
            <span style="font-family: Arial; font-size: 16px; color: #000000; text-align: center;">
            </span>
        </td>
    </tr>  
  </tbody>
</table>
<p style="font-family: Arial; font-size: 16px; color: #000000; text-align: center;">&nbsp;</p>

<table width="1000" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
              <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">CÓDIGO REFERENCIA</td>
              <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">PERSONA REFERIDA</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">DEPARTAMENTO</td>
              <td width="150" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">RED DE SALUD</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">MUNICIPIO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ESTABLECIMIENTO</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ESTADO/ETAPA</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">POR TELESALUD</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">MÉDICO OPERATIVO</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">CARGO ORGANIZACIONAL</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">FECHA DE REGISTRO:</td>

		     <!--- <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">F302A</td>  --->
	        </tr>
            <?php
    $numero=1; 
    $sql =" SELECT referencia_hc.idreferencia_hc, referencia_hc.codigo, nombre.nombre, nombre.paterno, nombre.materno, ";
    $sql.=" departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud, estado_referencia.estado_referencia,  ";
    $sql.=" referencia_hc.idmotivo_referencia, referencia_hc.fecha_registro, referencia_hc.hora_registro, referencia_hc.idusuario, red_salud.red_salud ";
    $sql.=" FROM referencia_hc, nombre, estado_referencia, departamento, red_salud, municipios, establecimiento_salud WHERE referencia_hc.idnombre=nombre.idnombre ";
    $sql.=" AND referencia_hc.idestado_referencia=estado_referencia.idestado_referencia AND referencia_hc.iddepartamento=departamento.iddepartamento AND referencia_hc.idred_salud=red_salud.idred_salud ";
    $sql.=" AND referencia_hc.idmunicipio=municipios.idmunicipio AND referencia_hc.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud  ";
    $sql.=" AND referencia_hc.fecha_registro BETWEEN '$inicio' AND '$finalizacion' ORDER BY referencia_hc.idreferencia_hc DESC LIMIT 3000 ";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);           
    while ($field = mysqli_fetch_field($result)){
    } do {
    ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="imprime_formulario_d7.php?idreferencia_hc=<?php echo $row[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1000,height=1000,top=50, left=200, scrollbars=YES'); return false;">
              <?php echo $row[1];?></a>  
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo mb_strtoupper($row[2]." ".$row[3]." ".$row[4]);?></td>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[5];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[13];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[6];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[7];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[8];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php if ($row[9] == '5') { echo 'SI'; } else { echo 'SI'; } ?></td></td>
              <td style="font-size: 12px; font-family: Arial;">
              <?php 
                $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                $sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row[12]' ";
                $result_r = mysqli_query($link,$sql_r);
                $row_r = mysqli_fetch_array($result_r);                    
                echo mb_strtoupper($row_r[0]." ".$row_r[1]." ".$row_r[2]);?>
              </td>
              <td style="font-size: 12px; font-family: Arial;">
              <?php 
                $sql_c =" SELECT dato_laboral.idcargo_organigrama, cargo_organigrama.cargo_organigrama FROM usuarios, dato_laboral, cargo_organigrama  ";
                $sql_c.=" WHERE dato_laboral.idusuario=usuarios.idusuario AND dato_laboral.idcargo_organigrama=cargo_organigrama.idcargo_organigrama ";
                $sql_c.=" AND usuarios.idusuario='$row[12]' ORDER BY dato_laboral.idcargo_organigrama DESC LIMIT 1 ";
                $result_c = mysqli_query($link,$sql_c);
                $row_c = mysqli_fetch_array($result_c);                    
                echo $row_c[1];?>
            </td>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                $fecha_r = explode('-',$row[10]);
                $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                <?php echo $f_registro;?> - <?php echo $row[11];?></td>
		     <!--- <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">&nbsp;</td> --->
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