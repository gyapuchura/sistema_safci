<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");

$idestablecimiento_salud = $_GET['idestablecimiento_salud'];

$sqle =" SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud' ";
$resulte = mysqli_query($link,$sqle);
$rowe = mysqli_fetch_array($resulte);

$gestion       =  date("Y");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
  <title>PERSONAL POR ESTABLECIMIENTO</title>

</head>
	<body>
  <h3 style="font-family: Arial; text-align: center;">PERSONAL SAFCI MI SALUD</h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;">Establecimiento :</h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;"><?php echo $rowe[1];?></h3>

	<table width="664" border="1" align="center">
	  <tbody>
        <tr>
            <td width="17" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>N°</strong></td>
            <td width="62" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>CÓDIGO</strong></td>
            <td width="78" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>NOMBRES</strong></td>
            <td width="88" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>PATERNO</strong></td>
            <td width="51" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>MATERNO</strong></td>
            <td width="54" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>PROFESIÓN</strong></td>	
            <td width="52" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>ESPECIALIDAD MÉDICA</strong></td>
            <td width="47" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>RED DE SALUD</strong></td>
            <td width="51" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>ESTABLECIMIENTO DE SALUD</strong></td>	
        </tr>

        <?php
            $numero=1;
            $sql =" SELECT personal.idpersonal, personal.codigo, nombre.nombre, nombre.paterno, nombre.materno,nombre.ci, nombre.complemento, nombre.exp, ";
            $sql.=" profesion.profesion, especialidad_medica.especialidad_medica, nombre_datos.celular, departamento.departamento, dato_laboral.idred_salud, dato_laboral.idestablecimiento_salud  ";
            $sql.=" FROM personal, nombre, nacionalidad, genero, nombre_datos, formacion_academica, profesion, especialidad_medica, departamento, dato_laboral   ";
            $sql.=" WHERE personal.idnombre=nombre.idnombre AND nombre.idnacionalidad=nacionalidad.idnacionalidad AND nombre.idgenero=genero.idgenero  ";
            $sql.=" AND personal.idnombre_datos=nombre_datos.idnombre_datos AND nombre_datos.idformacion_academica=formacion_academica.idformacion_academica  ";
            $sql.=" AND nombre_datos.iddepartamento=departamento.iddepartamento AND nombre_datos.idprofesion=profesion.idprofesion AND personal.iddato_laboral=dato_laboral.iddato_laboral ";
            $sql.=" AND nombre_datos.idespecialidad_medica=especialidad_medica.idespecialidad_medica ";
            $sql.=" AND dato_laboral.idestablecimiento_salud='$idestablecimiento_salud' ORDER BY personal.idpersonal ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {
            ?>

	    <tr>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $numero;?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row[1];?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[2]);?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[3]);?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[4]);?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[8]);?></td>
	    <td style="font-family: Arial; font-size: 12px;"><?php echo $row[9];?></td>
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
