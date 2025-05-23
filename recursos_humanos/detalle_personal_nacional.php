<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");
$gestion    = date("Y");

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>PERSONAL A NIVEL NACIONAL</title>
</head>
	<body>
  <h3 style="font-family: Arial; text-align: center;">PERSONAL DE SALUD - SAFCI MI SALUD</h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;">NIVEL NACIONAL</h3>
	<table width="664" border="1" align="center">
	  <tbody>
        <tr>
            <td width="20" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>N°</strong></td>
            <td width="70" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>CEDULA DE IDENTIDAD</strong></td>
            <td width="100" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>NOMBRES</strong></td>
            <td width="100" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>PATERNO</strong></td>
            <td width="100" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>MATERNO</strong></td>
            <td width="100" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>PROFESIÓN</strong></td>	
            <td width="200" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>CARGO ORGANIGRAMA</strong></td>	
            <td width="220" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>CARGO MEMORÁNDUM</strong></td>	
            <td width="100" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>ESPECIALIDAD MÉDICA</strong></td>
            <td width="70" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>DEPARTAMENTO</strong></td>
            <td width="150" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>RED DE SALUD</strong></td>
                        <td width="150" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>MUNICIPIO</strong></td>
            <td width="200" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>ESTABLECIMIENTO DE SALUD</strong></td>	
            <td width="60" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>Nro. ITEM</strong></td>	
            <td width="80" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>CELULAR</strong></td>	
            <td width="200" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>CORREO ELECTRONICO</strong></td>		
            <td width="80" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>ESTADO PERSONAL</strong></td>	
        </tr>

        <?php
            $numero=1;
            $sql =" SELECT personal.idpersonal, personal.codigo, nombre.nombre, nombre.paterno, nombre.materno, nombre.ci, nombre.complemento, nombre.exp, profesion.profesion, cargo_organigrama.cargo_organigrama, especialidad_medica.especialidad_medica,";
            $sql.=" departamento.departamento, dato_laboral.idred_salud, dato_laboral.idestablecimiento_salud, dato_laboral.item_red_salud, nombre_datos.celular, nombre_datos.correo,  usuarios.condicion, dato_laboral.cargo_red_salud, municipios.municipio  ";
            $sql.=" FROM personal, nombre, nacionalidad, genero, nombre_datos, formacion_academica, profesion, especialidad_medica, departamento, dato_laboral, cargo_organigrama, municipios, establecimiento_salud, usuarios ";
            $sql.=" WHERE personal.idnombre=nombre.idnombre AND nombre.idnacionalidad=nacionalidad.idnacionalidad AND nombre.idgenero=genero.idgenero AND personal.idnombre_datos=nombre_datos.idnombre_datos ";
            $sql.=" AND nombre_datos.idformacion_academica=formacion_academica.idformacion_academica AND dato_laboral.idcargo_organigrama=cargo_organigrama.idcargo_organigrama AND usuarios.idnombre=nombre.idnombre AND establecimiento_salud.idmunicipio=municipios.idmunicipio ";
            $sql.=" AND nombre_datos.iddepartamento=departamento.iddepartamento AND nombre_datos.idprofesion=profesion.idprofesion AND personal.iddato_laboral=dato_laboral.iddato_laboral AND dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
            $sql.=" AND nombre_datos.idespecialidad_medica=especialidad_medica.idespecialidad_medica ORDER BY departamento.departamento ";
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
	      <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[10]);?></td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[18]);?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[11]);?></td>
        <td style="font-family: Arial; font-size: 12px;">
        <?php 
            $sql_r =" SELECT idred_salud, red_salud FROM red_salud WHERE idred_salud='$row[12]'";
            $result_r = mysqli_query($link,$sql_r);
            $row_r = mysqli_fetch_array($result_r);
            echo $row_r[1];?></td>
                <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[19]);?></td>
        <td style="font-family: Arial; font-size: 12px;">
        <?php 
            $sql_e =" SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud WHERE idestablecimiento_salud='$row[13]'";
            $result_e = mysqli_query($link,$sql_e);
            $row_e = mysqli_fetch_array($result_e);
            echo mb_strtoupper($row_e[1]);?></td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[14];?></td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[15];?></td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[16];?></td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[17];?></td>
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
