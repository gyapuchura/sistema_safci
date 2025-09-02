<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");
$semana     = date("W");
$gestion    =  date("Y");

$idusuario = $_GET["idusuario_op"];

  $sql_u =" SELECT departamento.departamento, red_salud.red_salud, municipios.municipio, establecimiento_salud.establecimiento_salud, nombre.nombre, nombre.paterno, nombre.materno, nombre.ci  ";   
  $sql_u.=" FROM departamento, red_salud, municipios, establecimiento_salud, dato_laboral, nombre WHERE dato_laboral.idnombre=nombre.idnombre AND dato_laboral.iddepartamento=departamento.iddepartamento ";   
  $sql_u.=" AND dato_laboral.idred_salud=red_salud.idred_salud AND dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";   
  $sql_u.=" AND establecimiento_salud.idmunicipio=municipios.idmunicipio AND dato_laboral.idusuario='$idusuario' ";
  $result_u = mysqli_query($link,$sql_u);
  $row_u = mysqli_fetch_array($result_u);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<table width="900" border="0" align="center">
  <tbody>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2" style="font-family: Arial; font-size: 18px; text-align: center">INFORME OPERATIVO MENSUAL</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="29">&nbsp;</td>
      <td colspan="2" style="text-align: center">&nbsp;</td>
      <td width="32">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><table width="900" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="239" style="font-family: Arial; font-size: 12px;">DEPARTAMENTO:</td>
            <td width="651" style="font-family: Arial; font-size: 12px;"><?php echo $row_u[0];?></td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">RED DE SALUD:</td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row_u[1];?></td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">MUNICIPIO:</td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row_u[2];?></td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">ESTABLECIMIENTO DE SALUD:</td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row_u[3];?></td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">PERSONAL OPERATIVO:</td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row_u[4]." ".$row_u[5]." ".$row_u[6]);?></td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">CEDULA DE IDENTIDAD:</td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row_u[7];?></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    
    <tr>
      <td colspan="2"><table width="450" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="303" style="font-family: Arial; font-size: 12px;">VARIABLE</td>
            <td width="94" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD</td>
            <td width="39" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">POBLACIÓN CARPETAS FAMILIARES (Nº DE INTEGRANTES DE FAMILIA REGISTRADOS)</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">
              <?php
                  $sql_h =" SELECT sum(habitantes) FROM area_influencia WHERE idusuario='$idusuario' ";   
                  $result_h = mysqli_query($link,$sql_h);
                  $row_h = mysqli_fetch_array($result_h);

                  $sql_int =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar  ";
                  $sql_int.=" WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                  $sql_int.=" AND carpeta_familiar.estado='CONSOLIDADO'  ";
                  $sql_int.=" AND integrante_cf.estado='CONSOLIDADO' AND carpeta_familiar.idusuario='$idusuario' ";
                  $result_int = mysqli_query($link,$sql_int);
                  $row_int = mysqli_fetch_array($result_int);  
                  $integrantes = $row_int[0];

                  $integrantes_cf   = number_format($integrantes, 0, '.', '.');
                  $integrantes_meta = number_format($row_h[0], 0, '.', '.');

                  $porcentaje_hab   = ($integrantes*100)/$row_h[0];
                  $p_habitantes = number_format($porcentaje_hab, 2, '.', ' ');
              ?>
              <?php echo $integrantes_cf;?>
            </td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $p_habitantes;?> %</td>
          </tr>
          <tr>
          <?php
                      $sql_f =" SELECT sum(familias) FROM area_influencia WHERE idusuario='$idusuario' ";   
                      $result_f = mysqli_query($link,$sql_f);
                      $row_f = mysqli_fetch_array($result_f);
                      $meta_cf = $row_f[0];

                      $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar ";
                      $sql_cf.=" WHERE  estado='CONSOLIDADO' ";
                      $sql_cf.=" AND idusuario='$idusuario' ";
                      $result_cf = mysqli_query($link,$sql_cf);
                      $row_cf = mysqli_fetch_array($result_cf);  
                      $carpetizacion = $row_cf[0];

                      $porcentaje_op   = ($carpetizacion*100)/$meta_cf;
                      $p_operativo    = number_format($porcentaje_op, 2, '.', '');

                      ?>
            <td style="font-family: Arial; font-size: 12px;">POBLACIÓN SNIS (Nº DE INTEGRANTES SNIS)</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $integrantes_meta;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"></td>
          </tr>
              <?php
                  $sql_f =" SELECT sum(familias) FROM area_influencia WHERE idusuario='$idusuario' ";   
                  $result_f = mysqli_query($link,$sql_f);
                  $row_f = mysqli_fetch_array($result_f);
                  $meta_cf = $row_f[0];

                  $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar ";
                  $sql_cf.=" WHERE  estado='CONSOLIDADO' ";
                  $sql_cf.=" AND idusuario='$idusuario' ";
                  $result_cf = mysqli_query($link,$sql_cf);
                  $row_cf = mysqli_fetch_array($result_cf);  
                  $carpetizacion = $row_cf[0];

                  $porcentaje_op   = ($carpetizacion*100)/$meta_cf;
                  $p_operativo    = number_format($porcentaje_op, 2, '.', '');
              ?>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">Nº DE FAMILIAS SEGÚN CARPETAS FAMILIARES</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $carpetizacion;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $p_operativo;?> %</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">Nº DE FAMILIAS SEGÚN SNIS</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $meta_cf;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"></td>
          </tr>
              <?php
                  $sql_af =" SELECT idarea_influencia FROM carpeta_familiar WHERE idusuario='$idusuario' AND estado='CONSOLIDADO' GROUP BY idarea_influencia ";   
                  $result_af = mysqli_query($link,$sql_af);
                  $row_af = mysqli_num_rows($result_af);
                  $areas_influencia = $row_af;
              ?>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">Nº DE ÁREAS DE INFLUENCIA SEGÚN CARPETAS FAMILIARES.</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $areas_influencia;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
          </tr>

        </tbody>
      </table></td>
      <td colspan="2"><table width="450" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">POBLACIÓN GRUPO VULNERABLE</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">POBLACIÓN MENOR DE 28 DÍAS (NEONATOS)</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">POBLACIÓN MENOR DE 5 AÑOS:</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">PERSONAS DE 60 Y MÁS AÑOS:</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">POBLACION MENOR A 1 AÑO:</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">MUJERES EN EDAD FÉRTIL:</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">EMBARAZOS EN ADOLESCENTES:</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">TOTAL EMBARAZADAS:</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">PERSONAS CON DISCAPACIDAD:</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
      <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" style="font-family: Arial; font-size: 12px;"><table width="450" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="305" style="font-family: Arial; font-size: 12px;">AUTOPERTENENCIA CULTURAL</td>
            <td width="93" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD</td>
            <td width="38" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
      <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
      <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" style="font-family: Arial; font-size: 12px;"><table width="450" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="305" style="font-family: Arial; font-size: 12px;">SALUD DE LOS INTEGRANTES DE LA FAMILIA</td>
            <td width="88" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD</td>
            <td width="43" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
      <td colspan="2"><table width="450" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="305" style="font-family: Arial; font-size: 12px;">EVALUACIÓN DE LAS DETERMINANTES DE LA SALUD</td>
            <td width="93" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD</td>
            <td width="38" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
      <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><table width="450" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="305" style="font-family: Arial; font-size: 12px;">GRUPO II - FACTORES DE RIÉSGO</td>
            <td width="93" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD</td>
            <td width="38" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
      <td colspan="2"><table width="450" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="305" style="font-family: Arial; font-size: 12px;">EVALUACIÓN DE LA FUNCIONALIDAD FAMILIAR</td>
            <td width="93" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD</td>
            <td width="38" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="2"><table width="450" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="305" style="font-family: Arial; font-size: 12px;">GRUPO III - MORBILIDAD</td>
            <td width="93" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD</td>
            <td width="38" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><table width="450" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="305" style="font-family: Arial; font-size: 12px;">GRUPO IV - DISCAPACIDAD</td>
            <td width="93" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD</td>
            <td width="38" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
      <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><table width="450" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="305" style="font-family: Arial; font-size: 12px;">FUNCIONALIDAD FAMILIAR</td>
            <td width="93" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD</td>
            <td width="38" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
      <td colspan="2"><table width="450" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="305" style="font-family: Arial; font-size: 12px;">EVALUACIÓN DE LA FUNCIONALIDAD FAMILIAR</td>
            <td width="93" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD</td>
            <td width="38" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
      <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><table width="450" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="305" style="font-family: Arial; font-size: 12px;">PLAN DE SGUIMIENTO FAMILIAR</td>
            <td width="93" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD</td>
            <td width="38" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
      <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><table width="450" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="305" style="font-family: Arial; font-size: 12px;">PLAN DE SEGUIMIENTO RIÉSGO BIOLÓGICO PERSONAL</td>
            <td width="93" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD</td>
            <td width="38" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
      <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
    </tr>
    <tr>
      <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
      <td style="font-family: Arial; font-size: 12px;">Yo......... Declaro la veracidad de la información del presente documento.</td>
      <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
      <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="412" style="font-family: Arial; font-size: 12px;"><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p style="text-align: center">............................................................................................</p>
      <p style="text-align: center">Firma </p></td>
      <td width="409" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
      <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
    </tr>
  </tbody>
</table>

</body>
</html>