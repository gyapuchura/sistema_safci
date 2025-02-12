<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$iddepartamento = $_GET["iddepartamento"];

$sql_dep = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento' ";
$result_dep = mysqli_query($link,$sql_dep);
$row_dep = mysqli_fetch_array($result_dep);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>AUTOPERTENENCIA CULTURAL - DEPARTAMENTAL </title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>

		<script type="text/javascript">
$(function () {
    $('#autopertenencia-cultural').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'AUTOPERTENENCIA CULTURAL DE LOS INTEGRANTES DE LA FAMILIA - DEPARTAMENTO DE <?php echo $row_dep[1];?>'
        },
        subtitle: {
            text: 'Fuente: Sistema Medi-Safci al <?php echo $f_emision;?>'
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
            name: '% DE INTEGRANTES',
            data: [
                <?php
                    $sql0 = " SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar ";
                    $sql0.= " WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
                    $sql0.= " AND carpeta_familiar.iddepartamento='$iddepartamento' ";
                    $result0 = mysqli_query($link,$sql0);
                    $row0 = mysqli_fetch_array($result0);
                    $total = $row0[0];

                    $numero = 0;
                    $sql = " SELECT integrante_cf.idnacion, nacion.nacion FROM integrante_cf, nacion, carpeta_familiar ";
                    $sql.= " WHERE integrante_cf.idnacion=nacion.idnacion AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO'";
                    $sql.= " AND carpeta_familiar.iddepartamento='$iddepartamento' GROUP BY integrante_cf.idnacion ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);
                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_c = " SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar ";
                    $sql_c.= " WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
                    $sql_c.= " AND carpeta_familiar.iddepartamento='$iddepartamento' AND integrante_cf.idnacion='$row[0]' ";
                    $result_c = mysqli_query($link,$sql_c);
                    $row_c = mysqli_fetch_array($result_c);
                    $conteo = $row_c[0];

                    $p_conteo   = ($conteo*100)/$total;
                    $porcentaje    = number_format($p_conteo, 2, '.', '');

                    ?>

                    ['<?php echo $row[1];?>', <?php echo $porcentaje;?>]

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

<div id="autopertenencia-cultural" style="height: 580px"></div>

<table width="646" border="1" align="center" bordercolor="#009999">

    <tr>
        <td width="21" bgcolor="#FFFFFF" style="font-family: Arial;"><span class="Estilo8 Estilo1 Estilo2" style="font-size: 12px"> N° </span></td>
        <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">NACIÓN</span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">%</span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">CANTIDAD DE INTEGRANTES</span></td>
    </tr>

<?php
$numeroa = 1;
$sqla = " SELECT integrante_cf.idnacion, nacion.nacion FROM integrante_cf, nacion, carpeta_familiar ";
$sqla.= " WHERE integrante_cf.idnacion=nacion.idnacion AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO'";
$sqla.= " AND carpeta_familiar.iddepartamento='$iddepartamento' GROUP BY integrante_cf.idnacion ";
$resulta = mysqli_query($link,$sqla);
$conteo_tipo = mysqli_num_rows($resulta);
$resulta = mysqli_query($link,$sqla);
 if ($rowa = mysqli_fetch_array($resulta)){
mysqli_field_seek($resulta,0);
while ($fielda = mysqli_fetch_field($resulta)){
} do {

    $sql_c = " SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar ";
    $sql_c.= " WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
    $sql_c.= " AND carpeta_familiar.iddepartamento='$iddepartamento' AND integrante_cf.idnacion='$rowa[0]' ";
    $result_c = mysqli_query($link,$sql_c);
    $row_c = mysqli_fetch_array($result_c);
    $conteoa = $row_c[0];

    $p_conteoa   = ($conteoa*100)/$total;
    $porcentajea    = number_format($p_conteoa, 2, '.', '');
?>
        <tr>
          <td width="21" bgcolor="#FFFFFF"><span class="Estilo8 Estilo1 Estilo2"> <?php echo $numeroa;?> </span></td>
          <td width="315" bgcolor="#FFFFFF"><span class="Estilo8 Estilo1 Estilo2"> <?php echo $rowa[1];?> </span></td>
          <td bgcolor="#FFFFFF" align="center"><span class="Estilo7"> <?php echo $porcentajea;?> </span></td>
          <td bgcolor="#FFFFFF" align="center"><span class="Estilo7"> <?php echo $conteoa;?> </span></td>
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
    </table>

<?php
$sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND iddepartamento='$iddepartamento'  ";
$result_cf = mysqli_query($link,$sql_cf);
$row_cf = mysqli_fetch_array($result_cf);  
$total_cf = $row_cf[0];
?>

<span style="font-family: Arial; font-size: 12px;"><h4 align="center">TOTAL DE CARPETAS FAMILIARES DEPARTAMENTO = <?php echo $total_cf;?> </h4></spam>

<?php
$sql_p = " SELECT idmunicipio FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND iddepartamento='$iddepartamento' GROUP BY idmunicipio  ";
$result_p = mysqli_query($link,$sql_p);
$municipios = mysqli_num_rows($result_p);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE MUNICIPIOS DEL DEPARTAMENTO= <?php echo $municipios;?> </h4></spam>

<?php
$sql_mun =" SELECT idestablecimiento_salud FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND iddepartamento='$iddepartamento' GROUP BY idestablecimiento_salud ";
$result_mun = mysqli_query($link,$sql_mun);
$establecimientos = mysqli_num_rows($result_mun);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE ESTABLECIMIENTOS DE SALUD EN EL DEPARTAMENTO = <?php echo $establecimientos;?> </h4></spam>

<?php
$sql_int =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_int.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' ";
$result_int = mysqli_query($link,$sql_int);
$row_int = mysqli_fetch_array($result_int);  
$integrantes = $row_int[0];
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE INTEGRANTES DE FAMILIA REGISTRADOS EN EL DEPARTAMENTO= <?php echo $integrantes;?> </h4></spam>

<?php
$sql_per = " SELECT idusuario FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND iddepartamento='$iddepartamento' GROUP BY idusuario  ";
$result_per = mysqli_query($link,$sql_per);
$personal = mysqli_num_rows($result_per);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE PERSONAL SAFCI EN EL DEPARTAMENTO = <?php echo $personal;?> </h4></spam>


	</body>
</html>
