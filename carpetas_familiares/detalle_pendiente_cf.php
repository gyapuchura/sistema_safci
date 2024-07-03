<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");

$gestion       =  date("Y");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>SEGUIMIENTO CARPETAS FAMILIARES - SAFCI</title>
</head>
	<body>
  <h3 style="font-family: Arial; text-align: center;">SEGUIMIENTO CARPETAS FAMILIARES - SAFCI</h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;">NIVEL NACIONAL</h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;">CARPETAS FAMILIARES EN PROCESO DE LLENADO</h3>
	<table width="664" border="1" align="center">
	  <tbody>
        <tr>
            <td width="17" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>N°</strong></td>
            <td width="62" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>CÓDIGO</strong></td>
            <td width="62" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>FAMILIA</strong></td>
            <td width="62" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>DEPARTAMENTO</strong></td>
            <td width="62" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>MUNICIPIO</strong></td>
            <td width="78" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>ESTABLECIMIENTO DE SALUD</strong></td>
            <td width="78" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>ÁREA DE INFLUENCIA</strong></td>
            <td width="52" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>REGISTRADA POR:</strong></td>	
            <td width="47" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>FECHA DE REGISTRO:</strong></td>
        </tr>

        <?php
            $numero=1;
            $sql =" SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.codigo, carpeta_familiar.familia, departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud,";
            $sql.=" tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, carpeta_familiar.fecha_registro, carpeta_familiar.hora_registro, carpeta_familiar.estado, carpeta_familiar.idusuario ";
            $sql.=" FROM carpeta_familiar, ubicacion_cf, departamento, municipios, establecimiento_salud, area_influencia, tipo_area_influencia WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
            $sql.=" AND ubicacion_cf.iddepartamento=departamento.iddepartamento AND ubicacion_cf.idmunicipio=municipios.idmunicipio AND carpeta_familiar.estado='' ";
            $sql.=" AND ubicacion_cf.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia ";
            $sql.=" AND ubicacion_cf.idarea_influencia=area_influencia.idarea_influencia AND ubicacion_cf.ubicacion_actual='SI' ORDER BY carpeta_familiar.idcarpeta_familiar DESC ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {
            ?>

	    <tr>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $numero;?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row[1];?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row[2];?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row[3];?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row[4];?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[5]);?></td>
	    <td style="font-family: Arial; font-size: 12px;" align="center"><?php echo $row[6];?> - <?php echo $row[7];?></td>
        <td style="font-family: Arial; font-size: 12px;">
        <?php 
            $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
            $sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row[11]' ";
            $result_r = mysqli_query($link,$sql_r);
            $row_r = mysqli_fetch_array($result_r);                    
            echo mb_strtoupper($row_r[0]." ".$row_r[1]." ".$row_r[2]);?>
        </td>
        <td style="font-family: Arial; font-size: 12px;">
        <?php 
        $fecha_r = explode('-',$row[8]);
        $fecha_reg = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];
        echo $fecha_reg; ?> - <?php echo $row[9];?>
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

	<p>&nbsp;</p>

</body>
</html>
