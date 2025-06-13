<?php	
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=REPORTE PERSONAL NACIONAL.xls");
header("Pragma: no-cache");
header("Expires: 0");?>
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

  <title>PERSONAL NIVEL NACIONAL</title>
</head>
	<body>
  <h3 style="font-family: Arial; text-align: center;">PERSONAL DE SALUD - SAFCI MI SALUD</h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;">NIVEL NACIONAL</h3>
	<table width="664" border="1" align="center">
	  <tbody>
        <tr>
            <td width="40" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>N°</strong></td>
            <td width="70" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>CEDULA DE IDENTIDAD</strong></td>
            <td width="100" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>NOMBRES</strong></td>
            <td width="100" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>PATERNO</strong></td>
            <td width="100" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>MATERNO</strong></td>
            <td width="100" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>PROFESIÓN</strong></td>	
            <td width="200" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>CARGO ORGANIGRAMA</strong></td>	
            <td width="250" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>CARGO MEMORÁDUM</strong></td>	
            <td width="60" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>Nro. ITEM</strong></td>	
            <td width="150" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>ESPECIALIDAD MÉDICA</strong></td>
            <td width="70" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>DEPARTAMENTO</strong></td>
            <td width="150" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>RED DE SALUD</strong></td>
            <td width="150" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>MUNICIPIO</strong></td>
            <td width="100" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>TIPO DE ESTABLECIMIENTO </strong></td>	
            <td width="200" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>ESTABLECIMIENTO DE SALUD</strong></td>	
            <td width="100" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>LATITUD</strong></td>	
            <td width="100" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>LONGITUD</strong></td>	
            <td width="151" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>ÁREAS DE INFLUENCIA</strong></td>	
            <td width="51" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>Nº DE FAMILIAS CFs</strong></td>	
            <td width="51" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>POBLACIÓN CFs</strong></td>	
            <td width="80" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>CELULAR</strong></td>	
            <td width="200" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>CORREO ELECTRONICO</strong></td>		
            <td width="80" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>ESTADO PERSONAL</strong></td>	
            <td width="100" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>FECHA DE REGISTRO</strong></td>
            <td width="100" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>PERFIL</strong></td>
        </tr>

        <?php
            $numero=1;
            $sql =" SELECT personal.idpersonal, personal.codigo, nombre.nombre, nombre.paterno, nombre.materno, nombre.ci, nombre.complemento, nombre.exp, profesion.profesion, cargo_organigrama.cargo_organigrama, especialidad_medica.especialidad_medica,";
            $sql.=" departamento.departamento, dato_laboral.idred_salud, dato_laboral.idestablecimiento_salud, dato_laboral.item_red_salud, nombre_datos.celular, nombre_datos.correo,  usuarios.condicion, dato_laboral.cargo_red_salud, municipios.municipio, ";
            $sql.=" establecimiento_salud.latitud, establecimiento_salud.longitud, personal.idusuario, personal.fecha_registro, usuarios.perfil ";
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
        <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[18]);?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row[14];?></td>
	      <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[10]);?></td>
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
            $sql_e =" SELECT establecimiento_salud.idestablecimiento_salud, tipo_establecimiento.tipo_establecimiento, establecimiento_salud.establecimiento_salud FROM establecimiento_salud, tipo_establecimiento ";
            $sql_e.=" WHERE establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento AND establecimiento_salud.idestablecimiento_salud='$row[13]' ";
            $result_e = mysqli_query($link,$sql_e);
            $row_e = mysqli_fetch_array($result_e);
            echo $row_e[1];?></td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row_e[2];?></td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[20];?></td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[21];?></td>
            <td style="font-family: Arial; font-size: 12px;">
            <?php 
              $numeroa=1;
              $sqla =" SELECT carpeta_familiar.idarea_influencia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia FROM carpeta_familiar, area_influencia, tipo_area_influencia ";
              $sqla.=" WHERE carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia  ";
              $sqla.=" AND carpeta_familiar.idusuario='$row[22]' AND carpeta_familiar.estado='CONSOLIDADO' GROUP BY carpeta_familiar.idarea_influencia ";
              $resulta = mysqli_query($link,$sqla);
              if ($rowa = mysqli_fetch_array($resulta)){
              mysqli_field_seek($resulta,0);
              while ($fielda = mysqli_fetch_field($resulta)){
              } do {

                echo $numeroa.".-".$rowa[1]." ".$rowa[2]." ; ";
                 $numeroa=$numeroa+1; 
                                                }
              while ($rowa = mysqli_fetch_array($resulta));
              } else {
              }
            ?></td>
            <td style="font-family: Arial; font-size: 12px;">
            <?php 
            $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND idusuario='$row[22]' ";
            $result_cf = mysqli_query($link,$sql_cf);
            $row_cf = mysqli_fetch_array($result_cf);
            $familias_cf   = number_format($row_cf[0], 0, '.', '.');
            echo $familias_cf;?>
            </td>
            <td style="font-family: Arial; font-size: 12px;">
            <?php 
            $sql_hf =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
            $sql_hf.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_cf.estado='CONSOLIDADO' AND carpeta_familiar.idusuario='$row[22]' ";
            $result_hf = mysqli_query($link,$sql_hf);
            $row_hf = mysqli_fetch_array($result_hf);
            $integrantes_cf   = number_format($row_hf[0], 0, '.', '.');
            echo $integrantes_cf;
            ?></td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[15];?></td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[16];?></td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[17];?></td>
            <td style="font-family: Arial; font-size: 12px;">
          <?php 
              $fecha_r = explode('-',$row[23]);
              $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
          <?php echo $f_registro;?>
        </td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[24];?></td>
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
