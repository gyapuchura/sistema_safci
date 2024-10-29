<?php include("../cabf.php"); ?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

$idmunicipio = $_GET['idmunicipio'];

$sql_mun = " SELECT idmunicipio, municipio FROM municipios ";
$sql_mun.= " WHERE idmunicipio='$idmunicipio' ";
$result_mun = mysqli_query($link,$sql_mun);
$row_mun = mysqli_fetch_array($result_mun);
$municipio_cf = $row_mun[1];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INTEGRANTES CON MORBILIDAD - MUNICIPIO</title>
</head>
<body>

<h2 style="text-align: center; font-family: Arial; font-size: 14px; color: #2D56CF;">MUNICIPIO: <?php echo mb_strtoupper($municipio_cf);?></h2>
    
<h2 style="text-align: center; font-family: Arial; font-size: 14px; color: #2D56CF;">INTEGRANTES DE LA FAMILIA CON MORBILIDAD</h2>
		<table width="700" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
              <td width="199" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">MORBILIDAD</td>
              <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° DE INTEGRANTES</td>
		      <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;"> </td> 
          <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">PIRAMIDE</td> 
	        </tr>
        <?php
        $numero=1;
        $sql =" SELECT integrante_morbilidad.idmorbilidad_cf, morbilidad_cf.morbilidad_cf FROM integrante_morbilidad, carpeta_familiar, morbilidad_cf ";
        $sql.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
        $sql.=" AND integrante_morbilidad.idmorbilidad_cf=morbilidad_cf.idmorbilidad_cf AND carpeta_familiar.estado='CONSOLIDADO' ";
        $sql.=" AND carpeta_familiar.idmunicipio='$idmunicipio' GROUP BY integrante_morbilidad.idmorbilidad_cf  ";
        $result = mysqli_query($link,$sql);
        if ($row = mysqli_fetch_array($result)){
        mysqli_field_seek($result,0);
        while ($field = mysqli_fetch_field($result)){
        } do {
        ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero;?></td>
              <td style="font-size: 12px; font-family: Arial;"><?php echo $row[1];?></td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
          <?php
        $sql_c =" SELECT COUNT(integrante_morbilidad.idmorbilidad_cf) FROM integrante_morbilidad, carpeta_familiar ";
        $sql_c.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
        $sql_c.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio' AND integrante_morbilidad.idmorbilidad_cf='$row[0]' ";
        $result_c = mysqli_query($link,$sql_c);
        $row_c = mysqli_fetch_array($result_c);

          ?>
          <?php echo $row_c[0];?>
              </td>
              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="detalle_morbilidad_integrantes_mun.php?idmunicipio=<?php echo $idmunicipio;?>&idmorbilidad_cf=<?php echo $row[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=600'); return false;">             
              VER INTEGRANTES</a>
              </td>

              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="piramide_morbilidad_mun.php?idmunicipio=<?php echo $idmunicipio;?>&idmorbilidad_cf=<?php echo $row[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=600'); return false;">             
              VER PIRAMIDE</a>
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

</body>
</html>