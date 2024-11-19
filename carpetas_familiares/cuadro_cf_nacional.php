<?php include("../cabf.php"); ?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRUPOS DE SALUD CARPETA FAMILIAR NACIONAL</title>
</head>
<body>
    
<h2 style="text-align: center; font-family: Arial; font-size: 14px; color: #2D56CF;">SALUD DE LOS INTEGRANTES DE LA FAMILIA</h2>
		<table width="700" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
              <td width="120" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">GRUPO DE SALUD</td>
              <td width="80" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° DE INTEGRANTES</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">DEPARTAMENTOS</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">ETÁREO</td>
		     <!--- <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">F302A</td>  --->
	        </tr>

		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">1</td>
              <td style="font-size: 12px; font-family: Arial;">APARENTEMENTE SANOS</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
                <?php
                $sql_a =" SELECT COUNT(integrante_ap_sano.idintegrante_ap_sano) FROM integrante_ap_sano, carpeta_familiar WHERE carpeta_familiar.estado='CONSOLIDADO'  ";
                $sql_a.=" AND integrante_ap_sano.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                $result_a = mysqli_query($link,$sql_a);
                $row_a = mysqli_fetch_array($result_a);
                $aparentemente_sano = $row_a[0];
                echo $aparentemente_sano;
                ?>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="aparentemente_sanos_deptos.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="piramide_aparentemente_sanos_nal.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">2</td>
              <td style="font-size: 12px; font-family: Arial;">CON FACTORES DE RIESGO</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
                <?php
                $sql_b =" SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, carpeta_familiar  ";
                $sql_b.=" WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
                $result_b = mysqli_query($link,$sql_b);
                $row_b = mysqli_fetch_array($result_b);
                $factor_riesgo = $row_b[0];
                echo $factor_riesgo;
                ?>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="grupo_riesgo_deptos.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="piramide_grupo_riesgo_nal.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">3</td>
              <td style="font-size: 12px; font-family: Arial;">CON MORBILIDAD</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
                <?php
                $sql_c =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar  ";
                $sql_c.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
                $result_c = mysqli_query($link,$sql_c);
                $row_c = mysqli_fetch_array($result_c);
                $morbilidad =$row_c[0];
                echo $morbilidad;
                ?>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="grupo_morbilidad_deptos.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="piramide_grupo_morbilidad_nal.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">4</td>
              <td style="font-size: 12px; font-family: Arial;">CON DISCAPACIDAD</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
                <?php
                $sql_d =" SELECT COUNT(integrante_discapacidad.idintegrante_discapacidad) FROM integrante_discapacidad, carpeta_familiar  ";
                $sql_d.=" WHERE integrante_discapacidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
                $result_d = mysqli_query($link,$sql_d);
                $row_d = mysqli_fetch_array($result_d);
                $discapacidad = $row_d[0];
                echo $discapacidad;
                ?>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="grupo_discapacidad_deptos.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="piramide_grupo_discapacidad_nal.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>
	      </tbody>
    </table>

</body>
</html>