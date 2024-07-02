<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$idevento_vacunacion_ss  =  $_SESSION['idevento_vacunacion_ss'];
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>VACUNACION ANIMALES NIVEL NACIONAL</title>

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
            text: 'VACUNACIONES A ANIMALES DOMÉSTICOS - NIVEL NACIONAL'
        },
        subtitle: {
            text: 'Fuente: REGISTRO SISTEMA MEDI-SAFCI'
        },
        xAxis: {
            categories: [

                <?php 
$numero = 0;
$sql = " SELECT iddepartamento, departamento FROM departamento ORDER BY iddepartamento";
$result = mysqli_query($link,$sql);
$total = mysqli_num_rows($result);
 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>
 '<?php  echo $row[1]; ?>'

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
                text: 'VACUNACIONES - NIVEL NACIONAL'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} Vacunaciones </b></td></tr>',
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

            { name: 'CANES MACHOS',

data: [
<?php 
$numero3 = 0;
$sql3 = " SELECT iddepartamento, departamento FROM departamento  WHERE iddepartamento !='10' ORDER BY iddepartamento ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
?>

<?php
$sql_a =" SELECT SUM(can_macho) FROM vacunacion_anim WHERE idevento_vacunacion='$idevento_vacunacion_ss' AND iddepartamento='$row3[0]' ";
$result_a = mysqli_query($link,$sql_a);
$row_a = mysqli_fetch_array($result_a);
if ($row_a[0] !='') {
echo $row_a[0]; 
} else {
echo '0'; 
}



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
/*
Si no se encontraron resultados
*/
}
?>
    ]
},

{ name: 'CANES HEMBRAS',

data: [
<?php 
$numero3 = 0;
$sql3 = " SELECT iddepartamento, departamento FROM departamento  WHERE iddepartamento !='10' ORDER BY iddepartamento ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
?>

<?php
$sql_a =" SELECT SUM(can_hembra) FROM vacunacion_anim WHERE idevento_vacunacion='$idevento_vacunacion_ss' AND iddepartamento='$row3[0]' ";
$result_a = mysqli_query($link,$sql_a);
$row_a = mysqli_fetch_array($result_a);
if ($row_a[0] !='') {
echo $row_a[0]; 
} else {
echo '0'; 
}

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
/*
Si no se encontraron resultados
*/
}
?>
]
}
,
{ name: 'GATOS',

data: [
<?php 
$numero3 = 0;
$sql3 = " SELECT iddepartamento, departamento FROM departamento  WHERE iddepartamento !='10' ORDER BY iddepartamento ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
?>

<?php
$sql_a =" SELECT SUM(gato) FROM vacunacion_anim WHERE idevento_vacunacion='$idevento_vacunacion_ss' AND iddepartamento='$row3[0]' ";
$result_a = mysqli_query($link,$sql_a);
$row_a = mysqli_fetch_array($result_a);
if ($row_a[0] !='') {
echo $row_a[0]; 
} else {
echo '0'; 
}
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
/*
Si no se encontraron resultados
*/
}
?>
]
}
,
{ name: 'OTROS',

data: [
<?php 
$numero3 = 0;
$sql3 = " SELECT iddepartamento, departamento FROM departamento  WHERE iddepartamento !='10' ORDER BY iddepartamento ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
?>

<?php
$sql_a =" SELECT SUM(otro) FROM vacunacion_anim WHERE idevento_vacunacion='$idevento_vacunacion_ss' AND iddepartamento='$row3[0]' ";
$result_a = mysqli_query($link,$sql_a);
$row_a = mysqli_fetch_array($result_a);
if ($row_a[0] !='') {
echo $row_a[0]; 
} else {
echo '0'; 
}

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
<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="min-width: 410px; height: 400px; margin: 0 auto"></div>

<table width="806" border="1" align="center" cellspacing="0">
  <tbody>
    <tr>
      <td width="190" bgcolor="#C3EDD7" style="font-family: Arial; font-size: 12px; color: #205332;"><strong>TIPO ANIMAL DOMÉSTICO</strong></td>
      <td width="600" bgcolor="#C3EDD7" style="font-family: Arial; font-size: 12px; color: #284A1F; text-align: center;"><strong>VACUNACIONES REALIZADAS POR DEPARTAMENTO</strong></td>
    </tr>

    <tr>
      <td bgcolor="#E5F3EC" style="font-family: Arial; font-size: 12px;"><strong>
      CANES MACHOS
      <td>
      
      <table width="636" border="0">
        <tbody>
          <tr>
          <?php 
$numero5 = 0;
$sql5 = " SELECT iddepartamento, sigla FROM departamento WHERE iddepartamento !='10' ORDER BY iddepartamento";
$result5 = mysqli_query($link,$sql5);
$total5 = mysqli_num_rows($result5);
 if ($row5 = mysqli_fetch_array($result5)){
mysqli_field_seek($result5,0);
while ($field5 = mysqli_fetch_field($result5)){
} do {
	?>
            <td width="726">              
              <span style="font-family: Arial; font-size: 12px;">
                <?php
                $sql_s =" SELECT SUM(can_macho) FROM vacunacion_anim WHERE idevento_vacunacion='$idevento_vacunacion_ss' AND iddepartamento='$row5[0]' ";
                $result_s = mysqli_query($link,$sql_s);
                $row_s = mysqli_fetch_array($result_s);                
                ?>
                <?php echo $row5[1];?> 
                
                <?php echo ":";?> 
                <a href="detalle_vacunacion_anim_m.php?iddepartamento=<?php echo $row5[0];?>&idevento_vacunacion=<?php echo $idevento_vacunacion_ss;?>&animal=CANES MACHOS" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=700,scrollbars=YES,top=50,left=200'); return false;"><?php if ($row_s[0] !='') { echo $row_s[0]; } else { } ?></a>  
                </span></td>

            <?php 

$machos = $row_s[0];

} while ($row5 = mysqli_fetch_array($result5));
} else {
/*
Si no se encontraron resultados
*/
}
?>
          </tr>
        </tbody>
      </table>
        
    </td>
    </tr>

    <tr>
      <td bgcolor="#E5F3EC" style="font-family: Arial; font-size: 12px;"><strong>
      CANES HEMBRAS
      <td>
      
      <table width="636" border="0">
        <tbody>
          <tr>
          <?php 
$numero5 = 0;
$sql5 = " SELECT iddepartamento, sigla FROM departamento WHERE iddepartamento !='10' ORDER BY iddepartamento";
$result5 = mysqli_query($link,$sql5);
$total5 = mysqli_num_rows($result5);
 if ($row5 = mysqli_fetch_array($result5)){
mysqli_field_seek($result5,0);
while ($field5 = mysqli_fetch_field($result5)){
} do {
	?>
            <td width="726">              
              <span style="font-family: Arial; font-size: 12px;">
                <?php
                $sql_s =" SELECT SUM(can_hembra) FROM vacunacion_anim WHERE idevento_vacunacion='$idevento_vacunacion_ss' AND iddepartamento='$row5[0]' ";
                $result_s = mysqli_query($link,$sql_s);
                $row_s = mysqli_fetch_array($result_s);                
                ?>
                <?php echo $row5[1];?> 
                
                <?php echo ":";?> 
                <a href="detalle_vacunacion_anim_h.php?iddepartamento=<?php echo $row5[0];?>&idevento_vacunacion=<?php echo $idevento_vacunacion_ss;?>&animal=CANES HEMBRAS" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=700,scrollbars=YES,top=50,left=200'); return false;"><?php if ($row_s[0] !='') { echo $row_s[0]; } else { } ?></a>  
                </span></td>

            <?php 

$hembras = $row_s[0];

} while ($row5 = mysqli_fetch_array($result5));
} else {
/*
Si no se encontraron resultados
*/
}
?>
          </tr>
        </tbody>
      </table>
        
    </td>
    </tr>

    <tr>
      <td bgcolor="#E5F3EC" style="font-family: Arial; font-size: 12px;"><strong>
      GATOS
      <td>
      
      <table width="636" border="0">
        <tbody>
          <tr>
          <?php 
$numero5 = 0;
$sql5 = " SELECT iddepartamento, sigla FROM departamento WHERE iddepartamento !='10' ORDER BY iddepartamento";
$result5 = mysqli_query($link,$sql5);
$total5 = mysqli_num_rows($result5);
 if ($row5 = mysqli_fetch_array($result5)){
mysqli_field_seek($result5,0);
while ($field5 = mysqli_fetch_field($result5)){
} do {
	?>
            <td width="726">              
              <span style="font-family: Arial; font-size: 12px;">
                <?php
                $sql_s =" SELECT SUM(gato) FROM vacunacion_anim WHERE idevento_vacunacion='$idevento_vacunacion_ss' AND iddepartamento='$row5[0]' ";
                $result_s = mysqli_query($link,$sql_s);
                $row_s = mysqli_fetch_array($result_s);                
                ?>
                <?php echo $row5[1];?> 
                
                <?php echo ":";?> 
                <a href="detalle_vacunacion_anim_g.php?iddepartamento=<?php echo $row5[0];?>&idevento_vacunacion=<?php echo $idevento_vacunacion_ss;?>&animal=GATOS" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=700,scrollbars=YES,top=50,left=200'); return false;"><?php if ($row_s[0] !='') { echo $row_s[0]; } else { } ?></a>  
                </span></td>

            <?php 
            $gatos = $row_s[0];
} while ($row5 = mysqli_fetch_array($result5));
} else {
/*
Si no se encontraron resultados
*/
}
?>
          </tr>
        </tbody>
      </table>
        
    </td>
    </tr>


    <tr>
      <td bgcolor="#E5F3EC" style="font-family: Arial; font-size: 12px;"><strong>
      OTROS
      <td>
      
      <table width="636" border="0">
        <tbody>
          <tr>
          <?php 
$numero5 = 0;
$sql5 = " SELECT iddepartamento, sigla FROM departamento WHERE iddepartamento !='10' ORDER BY iddepartamento";
$result5 = mysqli_query($link,$sql5);
$total5 = mysqli_num_rows($result5);
 if ($row5 = mysqli_fetch_array($result5)){
mysqli_field_seek($result5,0);
while ($field5 = mysqli_fetch_field($result5)){
} do {
	?>
            <td width="726">              
              <span style="font-family: Arial; font-size: 12px;">
                <?php
                $sql_s =" SELECT SUM(otro) FROM vacunacion_anim WHERE idevento_vacunacion='$idevento_vacunacion_ss' AND iddepartamento='$row5[0]' ";
                $result_s = mysqli_query($link,$sql_s);
                $row_s = mysqli_fetch_array($result_s);                
                ?>
                <?php echo $row5[1];?> 
                
                <?php echo ":";?> 
                <a href="detalle_vacunacion_anim_o.php?iddepartamento=<?php echo $row5[0];?>&idevento_vacunacion=<?php echo $idevento_vacunacion_ss;?>&animal=OTROS ANIMALES" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=700,scrollbars=YES,top=50,left=200'); return false;"><?php if ($row_s[0] !='') { echo $row_s[0]; } else { } ?></a>  
                </span></td>

            <?php 
             $otros = $row_s[0];
} while ($row5 = mysqli_fetch_array($result5));
} else {
/*
Si no se encontraron resultados
*/
}
?>
          </tr>
        </tbody>
      </table>
        
    </td>
    </tr>


  </tbody>
</table>

<?php 

$sql_m =" SELECT SUM(can_macho) FROM vacunacion_anim WHERE idevento_vacunacion='$idevento_vacunacion_ss' ";
$result_m = mysqli_query($link,$sql_m);
$row_m = mysqli_fetch_array($result_m);  
$machos_m = $row_m[0];

$sql_h =" SELECT SUM(can_hembra) FROM vacunacion_anim WHERE idevento_vacunacion='$idevento_vacunacion_ss' ";
$result_h = mysqli_query($link,$sql_h);
$row_h = mysqli_fetch_array($result_h);  
$hembra_h = $row_h[0];

$sql_g =" SELECT SUM(gato) FROM vacunacion_anim WHERE idevento_vacunacion='$idevento_vacunacion_ss' ";
$result_g = mysqli_query($link,$sql_g);
$row_g = mysqli_fetch_array($result_g);  
$gato_g = $row_g[0];

$sql_o =" SELECT SUM(otro) FROM vacunacion_anim WHERE idevento_vacunacion='$idevento_vacunacion_ss' ";
$result_o = mysqli_query($link,$sql_o);
$row_o = mysqli_fetch_array($result_o);  
$otro_o = $row_o[0];

        $total = $machos_m + $hembra_h + $gato_g + $otro_o;
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">TOTAL DE VACUNACIONES = <?php echo $total;?> </h4></spam>

<?php
$sql_p =" SELECT idmunicipio FROM vacunacion_anim WHERE idevento_vacunacion='$idevento_vacunacion_ss' GROUP BY idmunicipio; ";
$result_p = mysqli_query($link,$sql_p);
$municipios = mysqli_num_rows($result_p);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">NÚMERO DE MUNICIPIOS = <?php echo $municipios;?> </h4></spam>

<?php
$sql_mun =" SELECT idestablecimiento_salud FROM vacunacion_anim WHERE idevento_vacunacion='$idevento_vacunacion_ss' GROUP BY idestablecimiento_salud ";
$result_mun = mysqli_query($link,$sql_mun);
$establecimientos = mysqli_num_rows($result_mun);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">NÚMERO DE ESTABLECIMIENTOS = <?php echo $establecimientos;?> </h4></spam>

<?php
$sql_mun =" SELECT idusuario FROM vacunacion_anim WHERE idevento_vacunacion='$idevento_vacunacion_ss' GROUP BY idusuario ";
$result_mun = mysqli_query($link,$sql_mun);
$establecimientos = mysqli_num_rows($result_mun);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">NÚMERO DE PERSONAL OPERATIVO = <?php echo $establecimientos;?> </h4></spam>

	</body>
</html>