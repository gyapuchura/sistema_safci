<?php include("../cabf.php"); ?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

$idarea_influencia = $_GET['idarea_influencia'];

$sql_area = " SELECT area_influencia.idarea_influencia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia FROM area_influencia, tipo_area_influencia ";
$sql_area.= " WHERE area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND area_influencia.idarea_influencia='$idarea_influencia' ";
$result_area = mysqli_query($link,$sql_area);
$row_area = mysqli_fetch_array($result_area);
$area_af = $row_area[1]." ".$row_area[2];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INTEGRANTES CON FACTORES DE RIESGO</title>
</head>
<body>

<h2 style="text-align: center; font-family: Arial; font-size: 14px; color: #2D56CF;">ÁREA DE INFLUENCIA: <?php echo mb_strtoupper($area_af);?></h2>
    
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
        $sql ="  SELECT integrante_factor_riesgo.idfactor_riesgo_cf, factor_riesgo_cf.factor_riesgo_cf FROM integrante_factor_riesgo, ubicacion_cf, carpeta_familiar, factor_riesgo_cf  ";
        $sql.="  WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
        $sql.="  AND integrante_factor_riesgo.idfactor_riesgo_cf=factor_riesgo_cf.idfactor_riesgo_cf AND carpeta_familiar.estado='CONSOLIDADO' ";
        $sql.="  AND ubicacion_cf.idarea_influencia='$idarea_influencia' GROUP BY integrante_factor_riesgo.idfactor_riesgo_cf ";
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
        $sql_c =" SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, ubicacion_cf, carpeta_familiar  ";
        $sql_c.=" WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
        $sql_c.=" AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.idarea_influencia='$idarea_influencia' AND integrante_factor_riesgo.idfactor_riesgo_cf='$row[0]' ";

        $result_c = mysqli_query($link,$sql_c);
        $row_c = mysqli_fetch_array($result_c);

          ?>
          <?php echo $row_c[0];?>
              </td>
              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="detalle_salud_integrantes.php?idarea_influencia=<?php echo $idarea_influencia;?>&idfactor_riesgo_cf=<?php echo $row[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=600'); return false;">             
              VER INTEGRANTES</a>
              </td>

              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="piramide_factores_riesgo.php?idarea_influencia=<?php echo $idarea_influencia;?>&idfactor_riesgo_cf=<?php echo $row[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=600'); return false;">             
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