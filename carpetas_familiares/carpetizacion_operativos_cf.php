
<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");

$gestion       =  date("Y");

$idmunicipio = $_GET["idmunicipio"];

$sql_mun = " SELECT idmunicipio, municipio FROM municipios WHERE idmunicipio='$idmunicipio' ";
$result_mun = mysqli_query($link,$sql_mun);
$row_mun = mysqli_fetch_array($result_mun);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>CARPETIZACION OPERATIVOS - SAFCI</title>
</head>
	<body>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px; color: #294D7C;">PORCENTAJE DE CARPETIZACIÓN FAMILIAR POR ÁREA DE INFLUENCIA</h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px; color: #294D7C;">MUNICIPIO DE <?php echo mb_strtoupper($row_mun[1]);?></h3>
	<table width="850" border="1" align="center" cellpadding="1" cellspacing="0">
	  <tbody>
        <tr>
            <td width="27" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>N°</strong></td>
            <td width="105" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>ÁREA DE INFLUENCIA</strong></td>
            <td width="161" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>MÉDICO OPERATIVO</strong></td>
            <td width="135" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>ESTABLECIMIENTO DE SALUD</strong></td>
            <td width="60" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>FAMILIAS DEL ÁREA DE INFLUENCIA</strong></td>
            <td width="80" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>FAMILIAS CARPETIZADAS EN SISTEMA</strong></td>
            <td width="81" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>% DE CARPETIZACIÓN</strong></td>
            <td width="71" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>HABITANTES DEL ÁREA DE INFLUENCIA</strong></td>
            <td width="75" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>INTEGRANTES REGISTRADOS EN SISTEMA</strong></td>
            <td width="63" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>% DE POBLACIÓN</strong></td>	
 
        </tr>

        <?php
            $numero=1;
            $sql =" SELECT carpeta_familiar.idusuario, nombre.paterno, nombre.materno, nombre.nombre, establecimiento_salud.establecimiento_salud, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, carpeta_familiar.idarea_influencia  ";
            $sql.=" FROM carpeta_familiar, usuarios, nombre, establecimiento_salud, area_influencia, tipo_area_influencia WHERE carpeta_familiar.idusuario=usuarios.idusuario AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia  ";
            $sql.=" AND carpeta_familiar.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia ";
            $sql.=" AND usuarios.idnombre=nombre.idnombre AND carpeta_familiar.idmunicipio='$idmunicipio' GROUP BY area_influencia.area_influencia ORDER BY establecimiento_salud.establecimiento_salud ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {
            ?>

	    <tr>
        <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $numero;?></td>
        <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo mb_strtoupper($row[5]." ".$row[6]);?></td>
        <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo mb_strtoupper($row[1]." ".$row[2]." ".$row[3]);?></td>
        <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo mb_strtoupper($row[4]);?></td>

        <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php 
            $sql_c =" SELECT sum(familias) FROM area_influencia WHERE idarea_influencia='$row[7]' ";
            $result_c = mysqli_query($link,$sql_c);
            $row_c = mysqli_fetch_array($result_c);
            $integrantes_cf   = number_format($row_c[0], 0, '.', '.');
            echo $integrantes_cf;?></td>
        <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php 
            $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND idusuario='$row[0]' AND idarea_influencia='$row[7]' ";
            $result_cf = mysqli_query($link,$sql_cf);
            $row_cf = mysqli_fetch_array($result_cf);
            $integrantes_cf   = number_format($row_cf[0], 0, '.', '.');
            echo $integrantes_cf;?></td>
        <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php
                $porcentaje_mun   = ($row_cf[0]*100)/$row_c[0];
                $p_municipio    = number_format($porcentaje_mun, 2, ',', '');
                echo $p_municipio;
            ?> %
        </td>
        <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php 
            $sql_h =" SELECT sum(habitantes) FROM area_influencia WHERE idarea_influencia='$row[7]' ";
            $result_h = mysqli_query($link,$sql_h);
            $row_h = mysqli_fetch_array($result_h);
            $integrantes_cf   = number_format($row_h[0], 0, '.', '.');
            echo $integrantes_cf;?></td>
	    <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php 
            $sql_hf =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
            $sql_hf.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idusuario='$row[0]' AND carpeta_familiar.idarea_influencia='$row[7]' ";
            $result_hf = mysqli_query($link,$sql_hf);
            $row_hf = mysqli_fetch_array($result_hf);
            $integrantes_cf   = number_format($row_hf[0], 0, '.', '.');
            echo $integrantes_cf;?></td>
        <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php 
                $porcentaje_hab   = ($row_hf[0]*100)/$row_h[0];
                $p_habitantes = number_format($porcentaje_hab, 2, ',', '');
                echo $p_habitantes;
            ?> %</td>
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

	<p>&nbsp;</p>
    <form name="REPORTE_CF_OP" action="carpetizacion_op_excel.php" method="post">
        <input type="hidden" name="idmunicipio" value="<?php echo $idmunicipio;?>">
        <button type="submit" class="btn btn-success">REPORTE CARPETAS FAMILIARES EN EXCEL</button>
    </form>
    <p>&nbsp;</p>

</body>
</html>
