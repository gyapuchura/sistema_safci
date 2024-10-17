<?php include("../cabf.php"); ?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

$idestablecimiento_salud = $_GET['idestablecimiento_salud'];

$sql_est = " SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud' ";
$result_est = mysqli_query($link,$sql_est);
$row_est = mysqli_fetch_array($result_est);
$establecimiento = $row_est[1];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRUPOS DE SALUD CARPETA FAMILIAR</title>
</head>
<body>

<h2 style="text-align: center; font-family: Arial; font-size: 14px; color: #2D56CF;">ESTABLECIMIENTO: <?php echo mb_strtoupper($establecimiento);?></h2>
    
<h2 style="text-align: center; font-family: Arial; font-size: 14px; color: #2D56CF;">SALUD DE LOS INTEGRANTES DE LA FAMILIA</h2>
		<table width="700" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
              <td width="199" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">GRUPO DE SALUD</td>
              <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° DE INTEGRANTES</td>
		     <!--- <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">F302A</td>  --->
	        </tr>

		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">1</td>
              <td style="font-size: 12px; font-family: Arial;">APARENTEMENTE SANOS</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
                <?php
                $sql_a =" SELECT COUNT(integrante_ap_sano.idintegrante_ap_sano) FROM integrante_ap_sano, integrante_cf, ubicacion_cf, carpeta_familiar  ";
                $sql_a.=" WHERE integrante_ap_sano.idintegrante_cf=integrante_cf.idintegrante_cf AND integrante_cf.estado='CONSOLIDADO' AND ";
                $sql_a.=" integrante_ap_sano.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_a.=" AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.idestablecimiento_salud='$idestablecimiento_salud' ";
                $result_a = mysqli_query($link,$sql_a);
                $row_a = mysqli_fetch_array($result_a);
                $aparentemente_sano = $row_a[0];
                echo $aparentemente_sano;
                ?>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">2</td>
              <td style="font-size: 12px; font-family: Arial;">CON FACTORES DE RIESGO</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
                <?php
                $sql_b =" SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, integrante_cf, ubicacion_cf, carpeta_familiar  ";
                $sql_b.=" WHERE integrante_factor_riesgo.idintegrante_cf=integrante_cf.idintegrante_cf AND integrante_cf.estado='CONSOLIDADO' AND ";
                $sql_b.=" integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_b.=" AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.idestablecimiento_salud='$idestablecimiento_salud' ";
                $result_b = mysqli_query($link,$sql_b);
                $row_b = mysqli_fetch_array($result_b);
                $factor_riesgo = $row_b[0];
                echo $factor_riesgo;
                ?>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">3</td>
              <td style="font-size: 12px; font-family: Arial;">CON MORBILIDAD</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
                <?php
                $sql_c =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, integrante_cf, ubicacion_cf, carpeta_familiar  ";
                $sql_c.=" WHERE integrante_morbilidad.idintegrante_cf=integrante_cf.idintegrante_cf AND integrante_cf.estado='CONSOLIDADO' AND ";
                $sql_c.=" integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_c.=" AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.idestablecimiento_salud='$idestablecimiento_salud' ";

                $result_c = mysqli_query($link,$sql_c);
                $row_c = mysqli_fetch_array($result_c);
                $morbilidad =$row_c[0];
                echo $morbilidad;
                ?>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">4</td>
              <td style="font-size: 12px; font-family: Arial;">CON DISCAPACIDAD</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
                <?php
                $sql_d =" SELECT COUNT(integrante_discapacidad.idintegrante_discapacidad) FROM integrante_discapacidad, integrante_cf, ubicacion_cf, carpeta_familiar  ";
                $sql_d.=" WHERE integrante_discapacidad.idintegrante_cf=integrante_cf.idintegrante_cf AND integrante_cf.estado='CONSOLIDADO' AND  ";
                $sql_d.=" integrante_discapacidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_d.=" AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.idestablecimiento_salud='$idestablecimiento_salud' ";
                $result_d = mysqli_query($link,$sql_d);
                $row_d = mysqli_fetch_array($result_d);
                $discapacidad = $row_d[0];
                echo $discapacidad;
                ?>
              </td>
	        </tr>

	      </tbody>
    </table>

</body>
</html>