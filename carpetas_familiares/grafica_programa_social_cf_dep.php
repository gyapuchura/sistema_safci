<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$iddepartamento = $_GET['iddepartamento'];

$sql_dep = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento' ";
$result_dep = mysqli_query($link,$sql_dep);
$row_dep = mysqli_fetch_array($result_dep);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>PROGRAMAS SOCIALES SALUD FAMILIAR DEPTO</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>

		<script type="text/javascript">
$(function () {
    $('#corresponde_salud').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'BENEFICIARIOS DE PROGRAMAS SOCIALES - DPTO. <?php echo mb_strtoupper($row_dep[1]);?>'
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
                    $sql0 = " SELECT count(integrante_beneficiario.idintegrante_beneficiario) FROM integrante_beneficiario, carpeta_familiar ";
                    $sql0.= " WHERE integrante_beneficiario.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql0.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento'  ";
                    $result0 = mysqli_query($link,$sql0);
                    $row0 = mysqli_fetch_array($result0);
                    $total = $row0[0];

                    $numero = 0;
                    $sql = " SELECT integrante_beneficiario.idprograma_social FROM integrante_beneficiario, carpeta_familiar ";
                    $sql.= " WHERE integrante_beneficiario.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' GROUP BY integrante_beneficiario.idprograma_social ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT idprograma_social, programa_social FROM programa_social WHERE idprograma_social='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c = " SELECT count(integrante_beneficiario.idintegrante_beneficiario) FROM integrante_beneficiario, carpeta_familiar ";
                    $sql_c.= " WHERE integrante_beneficiario.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql_c.= " AND integrante_beneficiario.idprograma_social='$row[0]' ";
                    $sql_c.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento'  ";
                    $result_c = mysqli_query($link,$sql_c);
                    $row_c = mysqli_fetch_array($result_c);
                    $conteo = $row_c[0];

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

<div id="corresponde_salud" style="height: 350px"></div>

<table width="646" border="1" align="center" bordercolor="#009999">
    <tr>
        <td width="21" bgcolor="#FFFFFF" style="font-family: Arial;"><span class="Estilo8 Estilo1 Estilo2" style="font-size: 12px"> N° </span></td>
        <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">CONTRUBUYE AL SUSTENTO FAMILIAR</span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">%</span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">CANTIDAD DE INTEGRANTES</span></td>
    </tr>

<?php
$numeroa = 1;
$sqla = " SELECT integrante_beneficiario.idprograma_social, programa_social.programa_social FROM integrante_beneficiario, carpeta_familiar, programa_social ";
$sqla.= " WHERE integrante_beneficiario.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_beneficiario.idprograma_social=programa_social.idprograma_social ";
$sqla.= " AND carpeta_familiar.iddepartamento='$iddepartamento' GROUP BY integrante_beneficiario.idprograma_social ";
$resulta = mysqli_query($link,$sqla);
 if ($rowa = mysqli_fetch_array($resulta)){ 
mysqli_field_seek($resulta,0);
while ($fielda = mysqli_fetch_field($resulta)){
} do {

    $sql_c = " SELECT count(integrante_beneficiario.idintegrante_beneficiario) FROM integrante_beneficiario, carpeta_familiar ";
    $sql_c.= " WHERE integrante_beneficiario.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
    $sql_c.= " AND integrante_beneficiario.idprograma_social='$rowa[0]' ";
    $sql_c.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento'  ";
    $result_c = mysqli_query($link,$sql_c);
    $row_c = mysqli_fetch_array($result_c);
    $conteoa = $row_c[0];

    $p_conteoa   = ($conteoa*100)/$total;
    $porcentajea    = number_format($p_conteoa, 2, '.', '');
?>
        <tr>
          <td width="21" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $numeroa;?></td>
          <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $rowa[1];?></td>
          <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $porcentajea;?></td>
          <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $conteoa;?></td>
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
