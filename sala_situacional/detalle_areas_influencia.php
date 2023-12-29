<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");

$idtipo_area_influencia = $_GET['idtipo_area_influencia'];
$iddepartamento = $_GET['iddepartamento'];

$sqld =" SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento' ";
$resultd = mysqli_query($link,$sqld);
$rowd = mysqli_fetch_array($resultd);

$sqlh =" SELECT idtipo_area_influencia, tipo_area_influencia FROM tipo_area_influencia WHERE idtipo_area_influencia='$idtipo_area_influencia' ";
$resulth = mysqli_query($link,$sqlh);
$rowh = mysqli_fetch_array($resulth);

$gestion       =  date("Y");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>AREAS DE INFLUENCIA - SAFCI</title>
</head>
	<body>
  <h3 style="font-family: Arial; text-align: center;">ÁREAS DE INFLUENCIA SAFCI</h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;">DEPARTAMENTO: <?php echo $rowd[1];?></h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;">TIPO: <?php echo $rowh[1];?></h3>
	<table width="664" border="1" align="center">
	  <tbody>
        <tr>
            <td width="17" style="font-family: Arial; font-size: 12px;"><strong>N°</strong></td>
            <td width="62" style="font-family: Arial; font-size: 12px;"><strong>RED DE SALUD</strong></td>
            <td width="78" style="font-size: 12px; font-family: Arial;"><strong>ESTABLECIMIENTO DE SALUD</strong></td>
            <td width="88" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>TIPO DE ÁREA DE INFLUENCIA</strong></td>
            <td width="51" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>DENOMINACIÓN</strong></td>
            <td width="54" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>CANTIDAD DE HABITANTES</strong></td>	
            <td width="52" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>NÚMERO DE FAMILIAS</strong></td>	
            <td width="47" style="font-family: Arial; font-size: 12px;"><strong>REGISTRADA POR:</strong></td>
        </tr>

        <?php
            $numero=1;
            $sql =" SELECT area_influencia.idarea_influencia, departamento.departamento, red_salud.red_salud,   ";
            $sql.=" establecimiento_salud.establecimiento_salud, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, ";
            $sql.=" area_influencia.habitantes, area_influencia.familias, nombre.nombre, nombre.paterno, nombre.materno   ";
            $sql.=" FROM area_influencia, departamento, red_salud, tipo_area_influencia, establecimiento_salud, usuarios, nombre ";
            $sql.=" WHERE area_influencia.iddepartamento=departamento.iddepartamento   ";
            $sql.=" AND area_influencia.idred_salud=red_salud.idred_salud  ";
            $sql.=" AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia ";
            $sql.=" AND area_influencia.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud  ";
            $sql.=" AND area_influencia.idusuario=usuarios.idusuario AND usuarios.idnombre=nombre.idnombre ";
            $sql.=" AND area_influencia.iddepartamento='$iddepartamento' AND area_influencia.idtipo_area_influencia='$idtipo_area_influencia'  ";
            $sql.=" ORDER BY area_influencia.habitantes DESC  ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {
            ?>

	    <tr>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $numero;?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row[2];?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row[3];?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row[4];?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[5]);?></td>
	    <td style="font-family: Arial; font-size: 12px;"><?php echo $row[6];?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row[7];?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[8]." ".$row[9]." ".$row[10]);?></td>
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
