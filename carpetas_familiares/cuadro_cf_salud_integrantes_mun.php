<?php include("../cabf.php"); ?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

$idmunicipio = $_GET['idmunicipio'];

$sql_est = " SELECT idmunicipio, municipio FROM municipios WHERE idmunicipio='$idmunicipio' ";
$result_est = mysqli_query($link,$sql_est);
$row_est = mysqli_fetch_array($result_est);
$municipio_cf = $row_est[1];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INTEGRANTES CON FACTORES DE RIESGO</title>
</head>
<body>

<h2 style="text-align: center; font-family: Arial; font-size: 14px; color: #2D56CF;">MUNICIPIO: <?php echo mb_strtoupper($municipio_cf);?></h2>
    
<h2 style="text-align: center; font-family: Arial; font-size: 14px; color: #2D56CF;">INTEGRANTES DE LA FAMILIA CON FACTORES DE RIESGO</h2>
		<table width="700" border="1" align="center" cellspacing="0">
		  <tbody> 
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
              <td width="199" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">FACTORES DE RIESGO</td>
              <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° DE INTEGRANTES</td>
		      <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;"> </td> 
          <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">PIRAMIDE</td> 
	        </tr>
        <?php
        $numero=1;
        $sql ="  SELECT integrante_factor_riesgo.idfactor_riesgo_cf, factor_riesgo_cf.factor_riesgo_cf FROM integrante_factor_riesgo, carpeta_familiar, factor_riesgo_cf  ";
        $sql.="  WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
        $sql.="  AND integrante_factor_riesgo.idfactor_riesgo_cf=factor_riesgo_cf.idfactor_riesgo_cf AND carpeta_familiar.estado='CONSOLIDADO' ";
        $sql.="  AND carpeta_familiar.idmunicipio='$idmunicipio' GROUP BY integrante_factor_riesgo.idfactor_riesgo_cf ";
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
        $sql_c =" SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, carpeta_familiar  ";
        $sql_c.=" WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
        $sql_c.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio' AND integrante_factor_riesgo.idfactor_riesgo_cf='$row[0]' ";

        $result_c = mysqli_query($link,$sql_c);
        $row_c = mysqli_fetch_array($result_c);

          ?>
          <?php echo $row_c[0];?>
              </td>
              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="detalle_salud_integrantes_mun.php?idmunicipio=<?php echo $idmunicipio;?>&idfactor_riesgo_cf=<?php echo $row[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=600'); return false;">             
              VER INTEGRANTES</a>
              </td>

              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="piramide_factores_riesgo_mun.php?idmunicipio=<?php echo $idmunicipio;?>&idfactor_riesgo_cf=<?php echo $row[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=600'); return false;">             
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