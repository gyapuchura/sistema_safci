<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");

$idevento_vacunacion = $_GET['idevento_vacunacion'];
$iddepartamento      = $_GET['iddepartamento'];
$animal      = $_GET['animal'];

$sqld =" SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento' ";
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

  <title>VACUNACION ANIMAL DOMESTICO - SAFCI</title>
</head>
	<body>
  <h3 style="font-family: Arial; text-align: center;">VACUNACION A ANIMALES DOMÉSTICOS</h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;">DEPARTAMENTO: <?php echo $rowd[1];?></h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;"><?php echo $animal;?></h3>
	<table width="664" border="1" align="center">
	  <tbody>
        <tr>
            <td width="17" style="font-family: Arial; font-size: 12px;"><strong>N°</strong></td>
            <td width="62" style="font-family: Arial; font-size: 12px;"><strong>MUNICIPIO</strong></td>
            <td width="78" style="font-size: 12px; font-family: Arial;"><strong>ESTABLECIMIENTO DE SALUD</strong></td>
            <td width="88" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>N° CANES MACHOS</strong></td>
            <td width="52" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>REGISTRADA POR:</strong></td>	
            <td width="47" style="font-family: Arial; font-size: 12px;"><strong>FECHA DE REGISTRO:</strong></td>
        </tr>

        <?php
            $numero=1;
            $sql =" SELECT vacunacion_anim.idvacunacion_anim, departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud, ";
            $sql.=" nombre.nombre, nombre.paterno, nombre.materno, vacunacion_anim.can_macho, vacunacion_anim.can_hembra, vacunacion_anim.gato, vacunacion_anim.otro, ";
            $sql.=" vacunacion_anim.fecha_registro, vacunacion_anim.hora_registro FROM vacunacion_anim, departamento, municipios, establecimiento_salud, usuarios, nombre ";
            $sql.=" WHERE vacunacion_anim.iddepartamento=departamento.iddepartamento AND vacunacion_anim.idmunicipio=municipios.idmunicipio ";
            $sql.=" AND vacunacion_anim.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND vacunacion_anim.idusuario=usuarios.idusuario ";
            $sql.=" AND usuarios.idnombre=nombre.idnombre AND vacunacion_anim.idevento_vacunacion='$idevento_vacunacion' AND vacunacion_anim.iddepartamento='$iddepartamento' ORDER BY establecimiento_salud.establecimiento_salud DESC ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {
            ?>

	    <tr>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $numero;?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row[2];?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[3]);?></td>
	    <td style="font-family: Arial; font-size: 12px;" align="center"><?php echo $row[7];?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[4]." ".$row[5]." ".$row[6]);?></td>
        <td style="font-family: Arial; font-size: 12px;">
        <?php 
        $fecha_r = explode('-',$row[11]);
        $fecha_reg = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];
        echo $fecha_reg; ?> - <?php echo $row[12];?>
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
