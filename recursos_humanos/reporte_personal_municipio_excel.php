<?php	
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=REPORTE PERSONAL MUNICIPIO.xls");
header("Pragma: no-cache");
header("Expires: 0");?>
<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");

$idmunicipio_salud = $_POST['idmunicipio_salud'];

$sqld =" SELECT municipios.idmunicipio, municipios.municipio, departamento.departamento FROM departamento, municipios WHERE municipios.iddepartamento=departamento.iddepartamento AND municipios.idmunicipio='$idmunicipio_salud' ";
$resultd = mysqli_query($link,$sqld);
$rowd = mysqli_fetch_array($resultd);

$gestion       =  date("Y");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>PERSONAL FORMACION ACADERMICA</title>
</head>
	<body>
  <h3 style="font-family: Arial; text-align: center;">PERSONAL DE SALUD - SAFCI MI SALUD</h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;">Departamento: <?php echo $rowd[2];?></h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;">Municipio: <?php echo $rowd[1];?></h3>
	<table width="664" border="1" align="center">
	  <tbody>
        <tr>
            <td width="30" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>N°</strong></td>
            <td width="70" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>CEDULA DE IDENTIDAD</strong></td>
            <td width="90" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>NOMBRES</strong></td>
            <td width="90" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>PATERNO</strong></td>
            <td width="90" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>MATERNO</strong></td>
            <td width="84" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>PROFESIÓN</strong></td>	
            <td width="150" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>ESPECIALIDAD MÉDICA</strong></td>
            <td width="120" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>RED DE SALUD</strong></td>
            <td width="150" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>ESTABLECIMIENTO DE SALUD</strong></td>	
            <td width="51" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>Nro. ITEM</strong></td>	
            <td width="80" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>CELULAR</strong></td>	
            <td width="180" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>CORREO ELECTRONICO</strong></td>		
        </tr>

        <?php
            $numero=1;
            $sql =" SELECT personal.idpersonal, personal.codigo, nombre.nombre, nombre.paterno, nombre.materno, nombre.ci, nombre.complemento, nombre.exp, profesion.profesion, especialidad_medica.especialidad_medica,";
            $sql.=" nombre_datos.celular, departamento.departamento, dato_laboral.idred_salud, dato_laboral.idestablecimiento_salud, nombre_datos.correo, dato_laboral.item_red_salud, nombre_datos.celular ";
            $sql.=" FROM personal, nombre, nacionalidad, genero, nombre_datos, formacion_academica, profesion, especialidad_medica, departamento, dato_laboral, establecimiento_salud ";
            $sql.=" WHERE personal.idnombre=nombre.idnombre AND nombre.idnacionalidad=nacionalidad.idnacionalidad AND nombre.idgenero=genero.idgenero ";
            $sql.=" AND personal.idnombre_datos=nombre_datos.idnombre_datos AND nombre_datos.idformacion_academica=formacion_academica.idformacion_academica AND nombre_datos.iddepartamento=departamento.iddepartamento ";
            $sql.=" AND nombre_datos.idprofesion=profesion.idprofesion AND personal.iddato_laboral=dato_laboral.iddato_laboral AND dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
            $sql.=" AND nombre_datos.idespecialidad_medica=especialidad_medica.idespecialidad_medica AND establecimiento_salud.idmunicipio='$idmunicipio_salud' ORDER BY personal.idpersonal ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {
            ?>

	    <tr>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $numero;?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row[5];?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[2]);?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[3]);?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[4]);?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[8]);?></td>
	      <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[9]);?></td>
        <td style="font-family: Arial; font-size: 12px;">
        <?php 
            $sql_r =" SELECT idred_salud, red_salud FROM red_salud WHERE idred_salud='$row[12]'";
            $result_r = mysqli_query($link,$sql_r);
            $row_r = mysqli_fetch_array($result_r);
            echo $row_r[1];?></td>
        <td style="font-family: Arial; font-size: 12px;">
        <?php 
            $sql_e =" SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud WHERE idestablecimiento_salud='$row[13]'";
            $result_e = mysqli_query($link,$sql_e);
            $row_e = mysqli_fetch_array($result_e);
            echo $row_e[1];?></td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[15];?></td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[16];?></td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[14];?></td>
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
