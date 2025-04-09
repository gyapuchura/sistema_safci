<?php	
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=REPORTE CARPETIZACION MUNICIPIOS.xls");
header("Pragma: no-cache");
header("Expires: 0");?>
<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");

$gestion       =  date("Y");

$iddepartamento = $_POST["iddepartamento"];

$sql_dep = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento' ";
$result_dep = mysqli_query($link,$sql_dep);
$row_dep = mysqli_fetch_array($result_dep);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>CARPETIZACION MUNICIPIOS - SAFCI</title>
</head>
	<body>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px; color: #294D7C;">PORCENTAJE DE CARPETIZACIÓN FAMILIAR MUNICIPIOS</h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px; color: #294D7C;">DEPARTAMENTO DE <?php echo $row_dep[1];?></h3>
	<table width="950" border="1" align="center" cellspacing="0">
	  <tbody>
        <tr>
            <td width="50" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>N°</strong></td>
            <td width="300" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>MUNICIPIO</strong></td>
            <td width="100" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>FAMILIAS POR ÁREA DE INFLUENCIA</strong></td>
            <td width="100" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>FAMILIAS CARPETIZADAS EN SISTEMA</strong></td>
            <td width="80" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>% DE CARPETIZACIÓN</strong></td>
            <td width="100" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>HABITANTES POR ÁREA DE INFLUENCIA</strong></td>
            <td width="100" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>INTEGRANTES REGISTRADOS EN SISTEMA</strong></td>
            <td width="80" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>% DE POBLACIÓN</strong></td>	
 
        </tr>

        <?php
            $numero=1;
            $sql =" SELECT carpeta_familiar.idmunicipio, municipios.municipio FROM carpeta_familiar, municipios WHERE carpeta_familiar.idmunicipio=municipios.idmunicipio ";
            $sql.=" AND carpeta_familiar.iddepartamento='$iddepartamento' AND carpeta_familiar.estado='CONSOLIDADO' GROUP BY carpeta_familiar.idmunicipio ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {
            ?>

	    <tr>
        <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $numero;?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row[1];?></td>
        <td style="font-family: Arial; font-size: 12px; text-align: center;">
            <?php 
            $sql_c =" SELECT sum(area_influencia.familias) FROM establecimiento_salud, area_influencia WHERE area_influencia.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
            $sql_c.=" AND establecimiento_salud.idmunicipio='$row[0]' ";
            $result_c = mysqli_query($link,$sql_c);
            $row_c = mysqli_fetch_array($result_c);
            $integrantes_cf   = number_format($row_c[0], 0, '.', '.');
            echo $integrantes_cf;?>
          </td>
        <td style="font-family: Arial; font-size: 12px; text-align: center;">
            <?php 
            $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND idmunicipio='$row[0]'  ";
            $result_cf = mysqli_query($link,$sql_cf);
            $row_cf = mysqli_fetch_array($result_cf);
            $integrantes_cf   = number_format($row_cf[0], 0, '.', '.');
            echo $integrantes_cf;?>
        </td>
        <td style="font-family: Arial; font-size: 12px; text-align: center;">
            <?php
                $porcentaje_mun   = ($row_cf[0]*100)/$row_c[0];
                $p_municipio    = number_format($porcentaje_mun, 2, ',', '');
                echo $p_municipio;
            ?> %
        </td>
        <td style="font-family: Arial; font-size: 12px; text-align: center;">
            <?php 
            $sql_h =" SELECT sum(area_influencia.habitantes) FROM establecimiento_salud, area_influencia WHERE area_influencia.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
            $sql_h.=" AND establecimiento_salud.idmunicipio='$row[0]' ";
            $result_h = mysqli_query($link,$sql_h);
            $row_h = mysqli_fetch_array($result_h);
            $integrantes_cf   = number_format($row_h[0], 0, '.', '.');
            echo $integrantes_cf;?>
        </td>
	    <td style="font-family: Arial; font-size: 12px; text-align: center;">
            <?php 
            $sql_hf =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
            $sql_hf.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$row[0]'  ";
            $result_hf = mysqli_query($link,$sql_hf);
            $row_hf = mysqli_fetch_array($result_hf);
            $integrantes_cf   = number_format($row_hf[0], 0, '.', '.');
            echo $integrantes_cf;?>
        </td>
        <td style="font-family: Arial; font-size: 12px; text-align: center;">
            <?php 
                $porcentaje_hab   = ($row_hf[0]*100)/$row_h[0];
                $p_habitantes = number_format($porcentaje_hab, 2, ',', '');
                echo $p_habitantes;
            ?> %
        </td>
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
