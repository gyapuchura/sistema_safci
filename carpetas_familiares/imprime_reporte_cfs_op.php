<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

$idusuario_op = $_GET['idusuario_op'];

$sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
$sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$idusuario_op' ";
$result_r = mysqli_query($link,$sql_r);
$row_r = mysqli_fetch_array($result_r);                    


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REPORTE CARPETAS FAMILIARES POR PERSONAL OPERATIVO</title>
</head>
<body>

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
            text: 'CARPETAS FAMILIARES REGISTRADOS POR EL PERSONAL <?php echo mb_strtoupper($row_r[0]." ".$row_r[1]." ".$row_r[2]);?>'
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
$sql = " SELECT fecha_registro FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND idusuario='$idusuario_op' GROUP BY fecha_registro ORDER BY fecha_registro";
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
                text: 'CARPETAS FAMILIARES DIARIAS'
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' Carpetas Familiares'
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
            name: 'Carpetas Familiares',
            data: [

             <?php

$numero = 0;
$sql = " SELECT fecha_registro FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND idusuario='$idusuario_op' GROUP BY fecha_registro ORDER BY fecha_registro ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT idcarpeta_familiar, fecha_registro FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND idusuario='$idusuario_op' AND fecha_registro='$row[0]'";
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
        }]
    });
});
		</script>
	</head>
	<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>
<div id="container" style="min-width: 300px; height: 350px; margin: 0 auto"></div>


    
<h4 style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">REGISTRADOS POR:  <?php echo mb_strtoupper($row_r[0]." ".$row_r[1]." ".$row_r[2]);?></h4>

<table width="1000" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
              <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">CÓDIGO</td>
              <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">FAMILIA</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">DEPARTAMENTO</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">MUNICIPIO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ESTABLECIMIENTO</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ÁREA DE INFLUENCIA</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">NÚMERO DE INTEGRANTES</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">OBSERVACIONES DE REGISTRO:</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">FECHA DE REGISTRO:</td>

		     <!--- <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">F302A</td>  --->
	        </tr>
            <?php
    $numero=1; 
    $sql =" SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.codigo, carpeta_familiar.familia, departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud,";
    $sql.=" tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, carpeta_familiar.fecha_registro, carpeta_familiar.hora_registro, carpeta_familiar.estado, carpeta_familiar.idusuario  ";
    $sql.=" FROM carpeta_familiar, departamento, municipios, establecimiento_salud, area_influencia, tipo_area_influencia WHERE carpeta_familiar.iddepartamento=departamento.iddepartamento ";
    $sql.=" AND carpeta_familiar.idmunicipio=municipios.idmunicipio AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
    $sql.=" AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia AND carpeta_familiar.idusuario='$idusuario_op' ";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);           
    while ($field = mysqli_fetch_field($result)){
    } do {
    ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="../carpetas_familiares/imprime_carpeta_familiar.php?idcarpeta_familiar=<?php echo $row[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1400,height=800,top=50, left=200, scrollbars=YES'); return false;">
              <?php echo $row[1];?></a>  
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[2];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[3];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[4];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo mb_strtoupper($row[5]);?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[6];?> - <?php echo $row[7];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                    $sql_i =" SELECT count(idintegrante_cf) FROM integrante_cf WHERE idcarpeta_familiar='$row[0]' ";
                    $result_i = mysqli_query($link,$sql_i);
                    $row_i = mysqli_fetch_array($result_i); 
                    echo $row_i[0];
              ?>
              </td>
              <td style="font-size: 12px; font-family: Arial;">
              <?php 
                    $numero_d=0;
                    $sqld =" SELECT idcat_determinante_salud FROM determinante_salud_cf WHERE idcarpeta_familiar='$row[0]' GROUP BY idcat_determinante_salud ";
                    $resultd = mysqli_query($link,$sqld);
                    if ($rowd = mysqli_fetch_array($resultd)){
                    mysqli_field_seek($resultd,0);
                    while ($fieldd = mysqli_fetch_field($resultd)){
                    } do { 

                        $numero_d=$numero_d+1;
                    }
                    while ($rowd = mysqli_fetch_array($resultd));
                    } else {
                    }

                    if ($numero_d == '20') {    
                                
                    } else {
                        echo "- AJUSTAR DETERMINANTES DE LA SALUD </br>";
                    }

                    $sql_in = " SELECT count(idintegrante_cf) FROM integrante_cf WHERE idcarpeta_familiar = '$row[0]' ";
                    $result_in = mysqli_query($link,$sql_in);    
                    $row_in = mysqli_fetch_array($result_in);
                    $integrantes = $row_in[0];

                    $sql_1 = " SELECT count(idintegrante_datos_cf) FROM integrante_datos_cf WHERE idcarpeta_familiar = '$row[0]' ";
                    $result_1 = mysqli_query($link,$sql_1);  
                    $row_1 = mysqli_fetch_array($result_1);  
                    $integrantes_datos = $row_1[0];
                    if ($integrantes <= $integrantes_datos) {                                    
                        } else { 
                            echo "- AJUSTAR DATOS DE TODOS LOS INTEGRANTES </br>";
                        }

                    $sql_2 = " SELECT idintegrante_cf FROM integrante_subsector_salud WHERE idcarpeta_familiar = '$row[0]' GROUP BY idintegrante_cf ";
                    $result_2 = mysqli_query($link,$sql_2);  
                    $integrantes_sub = mysqli_num_rows($result_2);  
                    if ($integrantes_sub >= $integrantes) {

                        } else { 
                            echo "- AJUSTAR DATOS DE SUBSECTOR SALUD </br>";
                        }

                        $sql_3 = " SELECT idintegrante_cf FROM integrante_beneficiario WHERE idcarpeta_familiar = '$row[0]' GROUP BY idintegrante_cf ";
                        $result_3 = mysqli_query($link,$sql_3); 
                        $integrante_ben = mysqli_num_rows($result_3);   
                        if ($integrante_ben >= $integrantes) {
                    
                            } else { 
                                echo "- AJUSTAR DATOS DE PROGRAMAS SOCIALES </br>";
                            }
                        $sql_4 = " SELECT idintegrante_cf FROM integrante_tradicional WHERE idcarpeta_familiar = '$row[0]' GROUP BY idintegrante_cf ";
                        $result_4 = mysqli_query($link,$sql_4);   
                        $integrante_trad = mysqli_num_rows($result_4); 
                        if ($integrante_trad >= $integrantes) {
                    
                            } else { 
                                echo "- AJUSTAR DATOS DE MEDICINA TRADICIONAL </br>";
                            }

                        $sql_5 = " SELECT idintegrante_cf FROM integrante_defuncion WHERE idcarpeta_familiar = '$row[0]' GROUP BY idintegrante_cf";
                        $result_5 = mysqli_query($link,$sql_5);   
                        $integrante_def = mysqli_num_rows($result_5); 
                        if ($integrante_def >= $integrantes) {
                    
                            } else { 
                                echo "- AJUSTAR DATOS DE DEFUNCION DE INTEGRANTES </br>";
                            }


                            $sql_soc = " SELECT idsocio_economica FROM socio_economica_cf WHERE idcarpeta_familiar = '$row[0]' ";
                            $result_soc = mysqli_query($link,$sql_soc);   
                            $socioeconomia = mysqli_num_rows($result_soc); 
                            if ($socioeconomia == '10') {
                        
                                } else { 
                                    echo "- AJUSTAR CARACTERÍSTICAS SOCIOECONÓMICAS </br>";
                                }
                    //----- INCORPORAR EN BANDEJA DE CARPETAS OPERATIVO END ----- //   

                ?>
              </td>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                $fecha_r = explode('-',$row[8]);
                $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                <?php echo $f_registro;?> - <?php echo $row[9];?></td>
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