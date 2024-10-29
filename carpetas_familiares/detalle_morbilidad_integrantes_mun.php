<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");
$gestion    = date("Y");

$idmunicipio = $_GET['idmunicipio'];
$idmorbilidad_cf = $_GET['idmorbilidad_cf']; 

$sql_mun = " SELECT idmunicipio, municipio FROM municipios ";
$sql_mun.= " WHERE idmunicipio='$idmunicipio' ";
$result_mun = mysqli_query($link,$sql_mun);
$row_mun = mysqli_fetch_array($result_mun);
$municipio_cf = $row_mun[1];

$sql_morb = " SELECT idmorbilidad_cf, morbilidad_cf FROM morbilidad_cf WHERE idmorbilidad_cf='$idmorbilidad_cf' ";
$result_morb = mysqli_query($link,$sql_morb);
$row_morb = mysqli_fetch_array($result_morb);
$morbilidad = $row_morb[1];

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>DETALLE MORBILIDAD DE INTEGRANTES - MUNICIPIO</title>
</head>
	<body>
  <h3 style="font-family: Arial; text-align: center;">MORBILIDAD</h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;"><?php echo mb_strtoupper($morbilidad);?></h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;"><?php echo "MUNICIPIO: ".mb_strtoupper($municipio_cf);?></h3>
	<table width="664" border="1" align="center">
	  <tbody>
        <tr>
            <td width="17" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>N°</strong></td>
            <td width="62" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>CÓDIGO</strong></td>
            <td width="62" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>FAMILIA</strong></td>
            <td width="62" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>NOMBRE</strong></td>
            <td width="62" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>PATERNO</strong></td>
            <td width="78" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>MATERNO</strong></td>
            <td width="78" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>EDAD</strong></td>
            <td width="47" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>CARPETA FAMILIAR</strong></td>
        </tr>

        <?php
            $numero=1;
            $sql =" SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.codigo, carpeta_familiar.familia, nombre.nombre, nombre.paterno, nombre.materno, integrante_cf.edad  ";
            $sql.=" FROM carpeta_familiar, integrante_cf, nombre, integrante_morbilidad WHERE integrante_morbilidad.idintegrante_cf=integrante_cf.idintegrante_cf ";
            $sql.=" AND integrante_cf.idnombre=nombre.idnombre ";
            $sql.=" AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO'";
            $sql.=" AND integrante_morbilidad.idmorbilidad_cf='$idmorbilidad_cf' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {
            ?>

	    <tr>
        <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $numero;?></td>
        <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row[1];?></td>
        <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row[2];?></td>
        <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo mb_strtoupper($row[3]);?></td>
        <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo mb_strtoupper($row[4]);?></td>
        <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo mb_strtoupper($row[5]);?></td>
	    <td style="font-family: Arial; font-size: 12px; text-align: center;" align="center"><?php echo $row[6];?></td>
        <td style="font-family: Arial; font-size: 12px; text-align: center;">
        <a href="imprime_carpeta_familiar.php?idcarpeta_familiar=<?php echo $row[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1400,height=800,top=50, left=200, scrollbars=YES'); return false;">
        <?php echo $row[1];?></a> 
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
