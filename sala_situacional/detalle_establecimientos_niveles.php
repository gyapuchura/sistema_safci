<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");

$idnivel_establecimiento = $_GET['idnivel_establecimiento'];
$iddepartamento = $_GET['iddepartamento'];

$sqld =" SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento' ";
$resultd = mysqli_query($link,$sqld);
$rowd = mysqli_fetch_array($resultd);

$sqlh =" SELECT idnivel_establecimiento, nivel_establecimiento FROM nivel_establecimiento WHERE idnivel_establecimiento='$idnivel_establecimiento' ";
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

  <title>ESTABLECIMIENTOS POR NIVEL</title>
</head>
	<body>
  <h3 style="font-family: Arial; text-align: center;">ESTABLECIMIENTOS DE SALUD</h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;">NIVEL: <?php echo $rowh[1];?></h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;">DEPARTAMENTO: <?php echo $rowd[1];?></h3>
	<table width="664" border="1" align="center">
	  <tbody>
        <tr>
            <td width="17" style="font-family: Arial; font-size: 12px;"><strong>N°</strong></td>
            <td width="62" style="font-family: Arial; font-size: 12px;"><strong>CÓDIGO</strong></td>
            <td width="47" style="font-family: Arial; font-size: 12px;"><strong>DEPARTAMENTO</strong></td>
            <td width="78" style="font-size: 12px; font-family: Arial;"><strong>RED DE SALUD</strong></td>
            <td width="88" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>MUNICIPIO</strong></td>
            <td width="51" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>ESTABLECIMIENTO DE SALUD</strong></td>
            <td width="54" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>NIVEL</strong></td>	
            <td width="52" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>TIPO DE ESTABLECIMIENTO</strong></td>	
        </tr>

        <?php
            $numero=1;
            $sql =" SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.codigo_establecimiento, departamento.departamento, red_salud.red_salud, ";
            $sql.=" municipios.municipio, establecimiento_salud.establecimiento_salud, nivel_establecimiento.nivel_establecimiento, tipo_establecimiento.tipo_establecimiento ";
            $sql.=" FROM establecimiento_salud, municipios, nivel_establecimiento, red_salud, departamento, tipo_establecimiento WHERE establecimiento_salud.idmunicipio=municipios.idmunicipio ";
            $sql.=" AND establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento  AND red_salud.iddepartamento=departamento.iddepartamento ";
            $sql.=" AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento AND establecimiento_salud.idred_salud=red_salud.idred_salud ";
            $sql.=" AND establecimiento_salud.idnivel_establecimiento='$idnivel_establecimiento' AND establecimiento_salud.iddepartamento='$iddepartamento'  ORDER BY establecimiento_salud.idestablecimiento_salud ";
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
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row[5];?></td>
	    <td style="font-family: Arial; font-size: 12px;"><?php echo $row[6];?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row[7];?></td>
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
