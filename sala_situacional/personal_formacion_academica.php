<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>PERSONAL FORMACION ACADEMICA</title>

		<script type="text/javascript" src="jquery.min.js"></script>
		<style type="text/css">
        ${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'FORMACIÓN ACADÉMICA SAFCI - NIVEL NACIONAL'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Porcentaje',
            data: [
                <?php
                    $sql0 = " SELECT personal.idpersonal, nombre_datos.idformacion_academica FROM personal, nombre, nombre_datos, dato_laboral WHERE personal.idnombre_datos=nombre_datos.idnombre_datos AND personal.iddato_laboral=dato_laboral.iddato_laboral AND personal.idnombre=nombre.idnombre ";
                    $result0 = mysqli_query($link,$sql0);
                    $total = mysqli_num_rows($result0);

                    $numero = 0;
                    $sql = " SELECT nombre_datos.idformacion_academica FROM personal, nombre_datos, dato_laboral WHERE personal.idnombre_datos=nombre_datos.idnombre_datos AND personal.iddato_laboral=dato_laboral.iddato_laboral GROUP BY nombre_datos.idformacion_academica ORDER BY nombre_datos.idformacion_academica ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT idformacion_academica, formacion_academica FROM formacion_academica WHERE idformacion_academica='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c= " SELECT personal.idpersonal, nombre_datos.idformacion_academica FROM personal, nombre_datos WHERE personal.idnombre_datos=nombre_datos.idnombre_datos AND nombre_datos.idformacion_academica='$row[0]'  ";
                    $result_c = mysqli_query($link,$sql_c);
                    $conteo = mysqli_num_rows($result_c);

                    $p_conteo   = ($conteo*100)/$total;
                    $porcentaje    = number_format($p_conteo, 2, '.', '');

                    ?>

                    ['<?php echo $row_t[1];?>', <?php echo $porcentaje;?>]

                        <?php
                        $numero++;
                        if ($numero == $conteo_tipo) {
                        echo "";
                        }
                        else {
                        echo ",";
                        }
                        
                    } while ($row = mysqli_fetch_array($result));
                    } else {
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
<script src="../js/highcharts-3d.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="height: 400px"></div>

<table width="646" border="1" align="center" bordercolor="#009999">

    <tr>
        <td width="21" bgcolor="#FFFFFF" style="font-family: Arial;"><span class="Estilo8 Estilo1 Estilo2" style="font-size: 12px"> N° </span></td>
        <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">SUBSECTOR SALUD</span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">CANTIDAD</span></td>
        <td width="73" align="center" bgcolor="#FFFFFF" style="font-family: Arial"><span class="Estilo7" style="font-size: 12px">  %</span></td>
        <td width="88" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">VER</span></td>
    </tr>

<?php

$sql_ta = " SELECT personal.idpersonal, nombre_datos.idformacion_academica FROM personal, nombre_datos WHERE personal.idnombre_datos=nombre_datos.idnombre_datos ";
$result_ta = mysqli_query($link,$sql_ta);
$total_ta = mysqli_num_rows($result_ta);

$numeroa = 1;
$sqla = " SELECT nombre_datos.idformacion_academica FROM personal, nombre_datos WHERE personal.idnombre_datos=nombre_datos.idnombre_datos GROUP BY nombre_datos.idformacion_academica ORDER BY nombre_datos.idformacion_academica  ";
$resulta = mysqli_query($link,$sqla);
 if ($rowa = mysqli_fetch_array($resulta)){
mysqli_field_seek($resulta,0);
while ($fielda = mysqli_fetch_field($resulta)){
} do {

$sql_ta = "  SELECT idformacion_academica, formacion_academica FROM formacion_academica WHERE idformacion_academica='$rowa[0]'  ";
$result_ta = mysqli_query($link,$sql_ta);
$row_ta = mysqli_fetch_array($result_ta);

$sql_ca = " SELECT personal.idpersonal, nombre_datos.idformacion_academica FROM personal, nombre, nombre_datos WHERE personal.idnombre=nombre.idnombre AND personal.idnombre_datos=nombre_datos.idnombre_datos AND nombre_datos.idformacion_academica='$rowa[0]'";
$result_ca = mysqli_query($link,$sql_ca);
$conteoa = mysqli_num_rows($result_ca);

$p_conteoa   = ($conteoa*100)/$total_ta;

$porcentajea = number_format($p_conteoa, 2, '.', '');

?>
        <tr>
          <td width="21" bgcolor="#FFFFFF"><span class="Estilo8 Estilo1 Estilo2"> <?php echo $numeroa;?> </span></td>
          <td width="315" bgcolor="#FFFFFF"><span class="Estilo8 Estilo1 Estilo2"> <?php echo $row_ta[1];?> </span></td>
          <td bgcolor="#FFFFFF" align="center"><span class="Estilo7"> <?php echo $conteoa;?> </span></td>
          <td width="73" bgcolor="#FFFFFF" align="center"><span class="Estilo7"> <?php echo $porcentajea;?> %</span></td>
          <td bgcolor="#FFFFFF" align="center">

          <a href="detalle_personal_academico.php?idformacion_academica=<?php echo $rowa[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=700,scrollbars=YES,top=50,left=200'); return false;">VER PERSONAL</a>  

        </td>
        </tr>   
        <?php
        $numeroa=$numeroa+1;
} while ($rowa = mysqli_fetch_array($resulta));
} else {
/*
Si no se encontraron resultados
*/
}
?>
        <tr>
          <td width="21" bgcolor="#FFFFFF"><span class="Estilo8 Estilo1 Estilo2"></span></td>
          <td width="315" bgcolor="#FFFFFF"><span class="Estilo8 Estilo1 Estilo2"></span></td>
          <td bgcolor="#FFFFFF" align="center"><span class="Estilo7"><?php echo $total;?></span></td>
          <td width="73" bgcolor="#FFFFFF" align="center"><span class="Estilo7"> 100 %</span></td>
          <td bgcolor="#FFFFFF" align="center"><span class="Estilo7"></span></td>
        </tr>
    </table>

	</body>
</html>