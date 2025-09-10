<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");
$semana     = date("W");
$gestion    =  date("Y");

$idestablecimiento_salud = $_GET["idestablecimiento_salud"];

  $sql_u =" SELECT establecimiento_salud.idestablecimiento_salud, departamento.departamento, red_salud.red_salud, municipios.municipio, establecimiento_salud.establecimiento_salud ";   
  $sql_u.=" FROM departamento, red_salud, municipios, establecimiento_salud WHERE establecimiento_salud.idmunicipio=municipios.idmunicipio ";   
  $sql_u.=" AND establecimiento_salud.iddepartamento=departamento.iddepartamento AND establecimiento_salud.idred_salud=red_salud.idred_salud ";  
  $sql_u.=" AND establecimiento_salud.idestablecimiento_salud='$idestablecimiento_salud' ";  
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
      <td ></td>
      <td colspan="2" style="font-family: Arial; font-size: 18px; text-align: center">
      <img src="../implementacion_safci/logo_safci_doc.png" width="200" height="135" alt=""/> </br> 
      INFORME OPERATIVO ESTABLECIMIENTO DE SALUD</td>
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
            <td width="651" style="font-family: Arial; font-size: 12px;"><?php echo $row_u[1];?></td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">RED DE SALUD:</td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row_u[2];?></td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">MUNICIPIO:</td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row_u[3];?></td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">ESTABLECIMIENTO DE SALUD:</td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row_u[4];?></td>
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
                  $sql_h =" SELECT sum(habitantes) FROM area_influencia WHERE idestablecimiento_salud='$idestablecimiento_salud' ";   
                  $result_h = mysqli_query($link,$sql_h);
                  $row_h = mysqli_fetch_array($result_h);

                  $sql_int =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar  ";
                  $sql_int.=" WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                  $sql_int.=" AND carpeta_familiar.estado='CONSOLIDADO'  ";
                  $sql_int.=" AND integrante_cf.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
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
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $p_habitantes;?></td>
          </tr>
          <tr>
          <?php
                      $sql_f =" SELECT sum(familias) FROM area_influencia WHERE idestablecimiento_salud='$idestablecimiento_salud' ";   
                      $result_f = mysqli_query($link,$sql_f);
                      $row_f = mysqli_fetch_array($result_f);
                      $meta_cf = $row_f[0];

                      $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar ";
                      $sql_cf.=" WHERE  estado='CONSOLIDADO' ";
                      $sql_cf.=" AND idestablecimiento_salud='$idestablecimiento_salud' ";
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
                  $sql_f =" SELECT sum(familias) FROM area_influencia WHERE idestablecimiento_salud='$idestablecimiento_salud' ";   
                  $result_f = mysqli_query($link,$sql_f);
                  $row_f = mysqli_fetch_array($result_f);
                  $meta_cf = $row_f[0];

                  $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar ";
                  $sql_cf.=" WHERE  estado='CONSOLIDADO' ";
                  $sql_cf.=" AND idestablecimiento_salud='$idestablecimiento_salud' ";
                  $result_cf = mysqli_query($link,$sql_cf);
                  $row_cf = mysqli_fetch_array($result_cf);  
                  $carpetizacion = $row_cf[0];

                  $porcentaje_op   = ($carpetizacion*100)/$meta_cf;
                  $p_operativo    = number_format($porcentaje_op, 2, '.', '');
              ?>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">Nº DE FAMILIAS SEGÚN CARPETAS FAMILIARES</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $carpetizacion;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $p_operativo;?> </td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">Nº DE FAMILIAS SEGÚN SNIS</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $meta_cf;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"></td>
          </tr>
              <?php
                  $sql_af =" SELECT idarea_influencia FROM carpeta_familiar WHERE idestablecimiento_salud='$idestablecimiento_salud' AND estado='CONSOLIDADO' GROUP BY idarea_influencia ";   
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
            <td style="font-family: Arial; font-size: 12px; text-align: center;">POBLACIÓN GRUPO VULNERABLE</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD DE INTEGRANTES</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">POBLACIÓN MENOR DE 28 DÍAS (NEONATOS)</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">
              <?php 
              $numero_n=0;
              $sql4 =" SELECT DATEDIFF('$fecha', nombre.fecha_nac) FROM integrante_cf, nombre, carpeta_familiar WHERE integrante_cf.idnombre=nombre.idnombre ";
              $sql4.=" AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
              $result4 = mysqli_query($link,$sql4);
              if ($row4 = mysqli_fetch_array($result4)){
              mysqli_field_seek($result4,0);
              while ($field4 = mysqli_fetch_field($result4)){
              } do { 
              
                if ($row4[0] <= '28') {
                  $numero_n=$numero_n+1;
                } else {
                }
                
              }
              while ($row4 = mysqli_fetch_array($result4));
              } else {
              }
              echo $numero_n;
              ?>
            </td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">POBLACIÓN MENOR DE 5 AÑOS:</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">
              <?php
              $sql5 =" SELECT count(integrante_cf.idintegrante_cf) FROM carpeta_familiar, integrante_cf WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
              $sql5.=" AND integrante_cf.edad BETWEEN '0' AND '4'  AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
              $result5 = mysqli_query($link,$sql5);
              $row5 = mysqli_fetch_array($result5);
              echo $row5[0];
              ?>
            </td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">PERSONAS DE 60 Y MÁS AÑOS:</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">
              <?php
              $sql6 =" SELECT count(integrante_cf.idintegrante_cf) FROM carpeta_familiar, integrante_cf WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
              $sql6.=" AND integrante_cf.edad BETWEEN '60' AND '160'  AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
              $result6 = mysqli_query($link,$sql6);
              $row6 = mysqli_fetch_array($result6);
              echo $row6[0];
              ?>
            </td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">POBLACION MENOR A 1 AÑO:</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">
              <?php
              $sql_1 =" SELECT count(integrante_cf.idintegrante_cf) FROM carpeta_familiar, integrante_cf WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
              $sql_1.=" AND integrante_cf.edad BETWEEN '0' AND '1'  AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
              $result_1 = mysqli_query($link,$sql_1);
              $row_1 = mysqli_fetch_array($result_1);
              echo $row_1[0];
              ?>
            </td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">MUJERES EN EDAD FÉRTIL:</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">
              <?php
              $sql_2 =" SELECT count(integrante_cf.idintegrante_cf) FROM carpeta_familiar, integrante_cf, nombre WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
              $sql_2.=" AND integrante_cf.idnombre=nombre.idnombre AND nombre.idgenero='1' AND integrante_cf.edad BETWEEN '15' AND '49' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud'  ";
              $result_2 = mysqli_query($link,$sql_2);
              $row_2 = mysqli_fetch_array($result_2);
              echo $row_2[0];
              ?>
            </td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">EMBARAZOS EN ADOLESCENTES:</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">
              <?php
              $sql_3 =" SELECT count(integrante_cf.idintegrante_cf) FROM carpeta_familiar, integrante_cf, integrante_factor_riesgo, nombre WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
              $sql_3.=" AND integrante_cf.idnombre=nombre.idnombre AND nombre.idgenero='1' AND integrante_factor_riesgo.idintegrante_cf=integrante_cf.idintegrante_cf  ";
              $sql_3.=" AND integrante_factor_riesgo.idfactor_riesgo_cf='13' AND integrante_cf.edad BETWEEN '10' AND '19' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud'  ";
              $result_3 = mysqli_query($link,$sql_3);
              $row_3 = mysqli_fetch_array($result_3);
              echo $row_3[0];
              ?>
            </td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">TOTAL EMBARAZADAS:</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">
              <?php
              $sql_4 =" SELECT count(integrante_cf.idintegrante_cf) FROM carpeta_familiar, integrante_cf, integrante_factor_riesgo, nombre WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
              $sql_4.=" AND integrante_cf.idnombre=nombre.idnombre AND nombre.idgenero='1' AND integrante_factor_riesgo.idintegrante_cf=integrante_cf.idintegrante_cf  ";
              $sql_4.=" AND integrante_factor_riesgo.idfactor_riesgo_cf='13' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud'  ";
              $result_4 = mysqli_query($link,$sql_4);
              $row_4 = mysqli_fetch_array($result_4);
              echo $row_4[0];
              ?>
            </td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">PERSONAS CON DISCAPACIDAD:</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">
              <?php
                $sql_5 =" SELECT COUNT(integrante_discapacidad.idintegrante_discapacidad) FROM integrante_discapacidad, carpeta_familiar  ";
                $sql_5.=" WHERE integrante_discapacidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
                $sql_5.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
                $result_5 = mysqli_query($link,$sql_5);
                $row_5 = mysqli_fetch_array($result_5);
              echo $row_5[0];
              ?>
            </td>
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
            <td width="305" style="font-family: Arial; font-size: 12px; text-align: center;">AUTOPERTENENCIA CULTURAL</td>
            <td width="93" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD DE INTEGRANTES</td>
            <td width="38" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>
          <?php
$sql_0 = " SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar ";
$sql_0.= " WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
$sql_0.= " AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
$result_0 = mysqli_query($link,$sql_0);
$row_0 = mysqli_fetch_array($result_0);
$totala = $row_0[0];

$numeroa = 1;
$sqla = " SELECT integrante_cf.idnacion, nacion.nacion FROM integrante_cf, nacion, carpeta_familiar ";
$sqla.= " WHERE integrante_cf.idnacion=nacion.idnacion AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO'";
$sqla.= " AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' GROUP BY integrante_cf.idnacion ";
$resulta = mysqli_query($link,$sqla);
 if ($rowa = mysqli_fetch_array($resulta)){
mysqli_field_seek($resulta,0);
while ($fielda = mysqli_fetch_field($resulta)){
} do {

    $sql_c = " SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar ";
    $sql_c.= " WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO'";
    $sql_c.= " AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND integrante_cf.idnacion='$rowa[0]' ";
    $result_c = mysqli_query($link,$sql_c);
    $row_c = mysqli_fetch_array($result_c);
    $conteoa = $row_c[0];

    $p_conteoa   = ($conteoa*100)/$totala;
    $porcentajea    = number_format($p_conteoa, 2, '.', '');
?>
          <tr>
            <td style="font-family: Arial; font-size: 12px; "><?php echo $rowa[1];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $conteoa;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $porcentajea;?></td>
          </tr>
        <?php
        $numeroa=$numeroa+1;
        } while ($rowa = mysqli_fetch_array($resulta));
        } else {
        }
        ?>
  
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
            <td width="305" style="font-family: Arial; font-size: 12px; text-align: center;">SALUD DE LOS INTEGRANTES DE LA FAMILIA</td>
            <td width="88" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD DE INTEGRANTES</td>
            <td width="43" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">APARENTEMENTE SANOS</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">
              <?php
              $sql_a =" SELECT COUNT(integrante_ap_sano.idintegrante_ap_sano) FROM integrante_ap_sano, carpeta_familiar  ";
              $sql_a.=" WHERE integrante_ap_sano.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
              $sql_a.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
              $result_a = mysqli_query($link,$sql_a);
              $row_a = mysqli_fetch_array($result_a);
              $aparentemente_sano = $row_a[0];

              $porcentaje_ap   = ($aparentemente_sano*100)/$integrantes;
              $p_apsanos    = number_format($porcentaje_ap, 2, '.', '');
              echo $aparentemente_sano;
              ?>
            </td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php  echo $p_apsanos;?> </td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px; ">CON FACTORES DE RIESGO</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">
              <?php
              $sql_b =" SELECT integrante_factor_riesgo.idintegrante_cf FROM integrante_factor_riesgo, carpeta_familiar  ";
              $sql_b.=" WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
              $sql_b.=" AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' GROUP BY integrante_factor_riesgo.idintegrante_cf ";
              $result_b = mysqli_query($link,$sql_b);
              $factor_riesgo = mysqli_num_rows($result_b);

              $porcentaje_fr   = ($factor_riesgo*100)/$integrantes;
              $p_friesgo    = number_format($porcentaje_fr, 2, '.', '');
              echo $factor_riesgo;
              ?>
            </td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php  echo $p_friesgo;?></td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px; ">CON MORBILIDAD</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">
              <?php
              $sql_c =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar  ";
              $sql_c.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
              $sql_c.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
              $result_c = mysqli_query($link,$sql_c);
              $row_c = mysqli_fetch_array($result_c);
              $morbilidad =$row_c[0];

              $porcentaje_mr   = ($morbilidad*100)/$integrantes;
              $p_morbilidad    = number_format($porcentaje_mr, 2, '.', '');
              echo $morbilidad;
              ?>
            </td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php  echo $p_morbilidad;?></td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px; ">CON DISCAPACIDAD</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_5[0];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php 
              $porcentaje_dis   = ($row_5[0] *100)/$integrantes;
              $p_discapacidad    = number_format($porcentaje_dis, 2, '.', '');
            echo $p_discapacidad;?> </td>
          </tr>
        </tbody>
      </table></td>
      <td colspan="2"><table width="450" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="305" style="font-family: Arial; font-size: 12px; text-align: center;">EVALUACIÓN DE LAS DETERMINANTES DE LA SALUD</td>
            <td width="93" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD DE FAMILIAS</td>
            <td width="38" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>
          <?php
                $sql_t =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar WHERE  estado='CONSOLIDADO' AND idestablecimiento_salud='$idestablecimiento_salud' ";
                $result_t = mysqli_query($link,$sql_t);
                $row_t = mysqli_fetch_array($result_t);
                $total = $row_t[0];

                $sql_a =" SELECT evaluacion_familiar_cf.idcarpeta_familiar FROM evaluacion_familiar_cf, carpeta_familiar  ";
                $sql_a.=" WHERE evaluacion_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                $sql_a.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
                $sql_a.=" AND evaluacion_familiar_cf.determinante_salud='SIN RIESGO EN LAS DETERMINANTES DE LA SALUD' GROUP BY evaluacion_familiar_cf.idcarpeta_familiar ";
                $result_a = mysqli_query($link,$sql_a);
                $sin_riesgo = mysqli_num_rows($result_a);

                $sql_b =" SELECT evaluacion_familiar_cf.idcarpeta_familiar FROM evaluacion_familiar_cf, carpeta_familiar ";
                $sql_b.=" WHERE evaluacion_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                $sql_b.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
                $sql_b.=" AND evaluacion_familiar_cf.determinante_salud='RIESGO LEVE EN LAS DETERMINANTES DE LA SALUD' GROUP BY evaluacion_familiar_cf.idcarpeta_familiar ";
                $result_b = mysqli_query($link,$sql_b);
                $riesgo_leve = mysqli_num_rows($result_b);

                $sql_c =" SELECT evaluacion_familiar_cf.idcarpeta_familiar FROM evaluacion_familiar_cf, carpeta_familiar ";
                $sql_c.=" WHERE evaluacion_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                $sql_c.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
                $sql_c.=" AND evaluacion_familiar_cf.determinante_salud='RIESGO MODERADO EN LAS DETERMINANTES DE LA SALUD' GROUP BY evaluacion_familiar_cf.idcarpeta_familiar ";
                $result_c = mysqli_query($link,$sql_c);
                $riesgo_moderado = mysqli_num_rows($result_c);

                $sql_d =" SELECT evaluacion_familiar_cf.idcarpeta_familiar FROM evaluacion_familiar_cf, carpeta_familiar ";
                $sql_d.=" WHERE evaluacion_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                $sql_d.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
                $sql_d.=" AND evaluacion_familiar_cf.determinante_salud='RIESGO GRAVE EN LAS DETERMINANTES DE LA SALUD' GROUP BY evaluacion_familiar_cf.idcarpeta_familiar ";
                $result_d = mysqli_query($link,$sql_d);
                $riesgo_grave = mysqli_num_rows($result_d);

                $sql_e =" SELECT evaluacion_familiar_cf.idcarpeta_familiar FROM evaluacion_familiar_cf, carpeta_familiar ";
                $sql_e.=" WHERE evaluacion_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                $sql_e.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
                $sql_e.=" AND evaluacion_familiar_cf.determinante_salud='RIESGO MUY GRAVE EN LAS DETERMINANTES DE LA SALUD' GROUP BY evaluacion_familiar_cf.idcarpeta_familiar ";
                $result_e = mysqli_query($link,$sql_e);
                $riesgo_muy_grave = mysqli_num_rows($result_e);

                $sin_riesgo_p    = ($sin_riesgo*100)/$total;
                $riesgo_leve_p   = ($riesgo_leve*100)/$total;
                $riesgo_moderado_p = ($riesgo_moderado*100)/$total;
                $riesgo_grave_p  = ($riesgo_grave*100)/$total;
                $riesgo_muy_grave_p = ($riesgo_muy_grave*100)/$total;

          ?>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">FAMILIAS SIN RIESGO</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $sin_riesgo;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo number_format($sin_riesgo_p, 2, '.', '');?></td>
          </tr>
                    <tr>
            <td style="font-family: Arial; font-size: 12px;">FAMILIAS CON RIESGO LEVE</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $riesgo_leve;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo number_format($riesgo_leve_p, 2, '.', '');?></td>
          </tr>
                    <tr>
            <td style="font-family: Arial; font-size: 12px;">FAMILIAS CON RIESGO MODERADO</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $riesgo_moderado;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo number_format($riesgo_moderado_p, 2, '.', '');?></td>
          </tr>
                    <tr>
            <td style="font-family: Arial; font-size: 12px;">FAMILIAS CON RIESGO GRAVE</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $riesgo_grave;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo number_format($riesgo_grave_p, 2, '.', '');?></td>
          </tr>
                    <tr>
            <td style="font-family: Arial; font-size: 12px;">FAMILIAS CON RIESGO MUY GRAVE</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $riesgo_muy_grave;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo number_format($riesgo_muy_grave_p, 2, '.', '');?></td>
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
            <td width="305" style="font-family: Arial; font-size: 12px; text-align: center;">GRUPO II - FACTORES DE RIÉSGO</td>
            <td width="93" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD DE INTEGRANTES</td>
            <td width="38" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>
                  <?php

        $sql_t =" SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, carpeta_familiar ";
        $sql_t.=" WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
        $sql_t.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
        $result_t = mysqli_query($link,$sql_t);
        $row_t = mysqli_fetch_array($result_t);
        $total_fr = $row_t[0];

        $sql ="  SELECT integrante_factor_riesgo.idfactor_riesgo_cf, factor_riesgo_cf.factor_riesgo_cf FROM integrante_factor_riesgo, carpeta_familiar, factor_riesgo_cf  ";
        $sql.="  WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
        $sql.="  AND integrante_factor_riesgo.idfactor_riesgo_cf=factor_riesgo_cf.idfactor_riesgo_cf AND carpeta_familiar.estado='CONSOLIDADO' ";
        $sql.="  AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' GROUP BY integrante_factor_riesgo.idfactor_riesgo_cf ";
        $result = mysqli_query($link,$sql);
        if ($row = mysqli_fetch_array($result)){
        mysqli_field_seek($result,0);
        while ($field = mysqli_fetch_field($result)){
        } do {
        ?>
          <tr>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[1];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">
        <?php
        $sql_c =" SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, carpeta_familiar  ";
        $sql_c.=" WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
        $sql_c.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND integrante_factor_riesgo.idfactor_riesgo_cf='$row[0]' ";
        $result_c = mysqli_query($link,$sql_c);
        $row_c = mysqli_fetch_array($result_c);
        $factor_riesgo_p = ($row_c[0]*100)/$total_fr;
        echo $row_c[0];?>
            </td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo number_format($factor_riesgo_p, 2, '.', '');?></td>
          </tr>
        <?php
        }
        while ($row = mysqli_fetch_array($result));
        } else {
        }
        ?>
        </tbody>
      </table></td>
      <td colspan="2">
        
      <table width="450" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="305" style="font-family: Arial; font-size: 12px; text-align: center;">FUNCIONALIDAD FAMILIAR</td>
            <td width="93" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD DE FAMILIAS</td>
            <td width="38" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>

          <?php
          $sql = " SELECT funcionalidad_familiar_cf.idfuncionalidad_familiar FROM funcionalidad_familiar_cf, carpeta_familiar ";
          $sql.= " WHERE funcionalidad_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
          $sql.= " AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND funcionalidad_familiar_cf.vigente='SI' GROUP BY funcionalidad_familiar_cf.idfuncionalidad_familiar ";                  
          $result = mysqli_query($link,$sql);
          if ($row = mysqli_fetch_array($result)){
          mysqli_field_seek($result,0);
          while ($field = mysqli_fetch_field($result)){
          } do {

          $sql_t = " SELECT idfuncionalidad_familiar, funcionalidad_familiar FROM funcionalidad_familiar WHERE idfuncionalidad_familiar='$row[0]' ";
          $result_t = mysqli_query($link,$sql_t);
          $row_t = mysqli_fetch_array($result_t);

          $sql_c =" SELECT count(funcionalidad_familiar_cf.idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf, carpeta_familiar ";
          $sql_c.=" WHERE funcionalidad_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
          $sql_c.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND funcionalidad_familiar_cf.idfuncionalidad_familiar ='$row[0]' ";

          $result_c = mysqli_query($link,$sql_c);
          $row_c = mysqli_fetch_array($result_c);
          $conteo_f = $row_c[0];

          $p_conteo_f  = ($conteo_f*100)/$carpetizacion;
          $porcentaje_f    = number_format($p_conteo_f, 2, '.', '');

          ?>

          <tr>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row_t[1];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $conteo_f;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $porcentaje_f;?></td>
          </tr>
           <?php                   
            } while ($row = mysqli_fetch_array($result));
            } else {
            }
            ?>
        </tbody>
      </table>
      
  
    
    </td>
    </tr>
    <tr>
      <td colspan="2">
      </br>  
      <table width="450" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="305" style="font-family: Arial; font-size: 12px; text-align: center;">GRUPO III - MORBILIDAD</td>
            <td width="93" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD DE INTEGRANTES</td>
            <td width="38" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>
           <?php
          $sql_t =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar   ";
          $sql_t.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
          $sql_t.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
          $result_t = mysqli_query($link,$sql_t);
          $row_t = mysqli_fetch_array($result_t);
          $total_m = $row_t[0];

        $sql =" SELECT integrante_morbilidad.idmorbilidad_cf, morbilidad_cf.morbilidad_cf FROM integrante_morbilidad, carpeta_familiar, morbilidad_cf ";
        $sql.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
        $sql.=" AND integrante_morbilidad.idmorbilidad_cf=morbilidad_cf.idmorbilidad_cf AND carpeta_familiar.estado='CONSOLIDADO' ";
        $sql.=" AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' GROUP BY integrante_morbilidad.idmorbilidad_cf  ";
        $result = mysqli_query($link,$sql);
        if ($row = mysqli_fetch_array($result)){
        mysqli_field_seek($result,0);
        while ($field = mysqli_fetch_field($result)){
        } do {
        ?>
            <tr>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[1];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">
            <?php
            $sql_m =" SELECT COUNT(integrante_morbilidad.idmorbilidad_cf) FROM integrante_morbilidad, carpeta_familiar ";
            $sql_m.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
            $sql_m.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND integrante_morbilidad.idmorbilidad_cf='$row[0]' ";
            $result_m = mysqli_query($link,$sql_m);
            $row_m = mysqli_fetch_array($result_m);

            $morbilidad_p = ($row_m[0]*100)/$total_m;

            ?>
          <?php echo $row_m[0];?>
            </td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo number_format($morbilidad_p, 2, '.', '');?></td>
          </tr>
        <?php
        }
        while ($row = mysqli_fetch_array($result));
        } else {
        }
        ?>
        </tbody>
      </table></td>
      <td colspan="2">
      
            <table width="450" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="305" style="font-family: Arial; font-size: 12px; text-align: center;">EVALUACIÓN DE LA FUNCIONALIDAD FAMILIAR</td>
            <td width="93" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD DE FAMILIAS</td>
            <td width="38" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>
                    <?php
                    $sql_ff = " SELECT funcionalidad_familiar_cf.idcarpeta_familiar FROM funcionalidad_familiar_cf, funcionalidad_familiar, carpeta_familiar ";
                    $sql_ff.= " WHERE funcionalidad_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                    $sql_ff.= " AND funcionalidad_familiar_cf.idfuncionalidad_familiar=funcionalidad_familiar.idfuncionalidad_familiar  ";
                    $sql_ff.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
                    $sql_ff.= " AND funcionalidad_familiar.funcional='NO' GROUP BY funcionalidad_familiar_cf.idcarpeta_familiar  ";
                    $result_ff = mysqli_query($link,$sql_ff);
                    $disfuncional = mysqli_num_rows($result_ff);

                    $funcional = $carpetizacion - $disfuncional;

                    $p_disfuncional = ($disfuncional*100)/$carpetizacion;
                    $porcentaje_disfuncional = number_format($p_disfuncional, 2, '.', '');

                    $p_funcional   = ($funcional*100)/$carpetizacion;
                    $porcentaje_funcional    = number_format($p_funcional, 2, '.', '');
                    ?>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">FAMILIAS FUNCIONALES</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $funcional;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $porcentaje_funcional;?></td>
          </tr>
            <tr>
            <td style="font-family: Arial; font-size: 12px;">FAMILIAS DISFUNCIONALES</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $disfuncional;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $porcentaje_disfuncional;?></td>
          </tr>
        
        </tbody>
      </table>

      </td>
    </tr>
    <tr>
      <td colspan="2">
           </br>  
      <table width="450" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="305" style="font-family: Arial; font-size: 12px; text-align: center;">GRUPO IV - DISCAPACIDAD</td>
            <td width="93" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD DE INTEGRANTES</td>
            <td width="38" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>
          <?php 

              $sql_td = " SELECT COUNT(integrante_discapacidad.idintegrante_discapacidad) FROM integrante_discapacidad, carpeta_familiar ";
              $sql_td.= " WHERE integrante_discapacidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO'  ";
              $sql_td.= " AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
              $result_td = mysqli_query($link,$sql_td);
              $row_td = mysqli_fetch_array($result_td);
              $total_td = $row_td[0];


          $sql3 = " SELECT idtipo_discapacidad_cf, tipo_discapacidad_cf FROM tipo_discapacidad_cf ORDER BY idtipo_discapacidad_cf ";
          $result3 = mysqli_query($link,$sql3);
          $total3 = mysqli_num_rows($result3);
          if ($row3 = mysqli_fetch_array($result3)){
          mysqli_field_seek($result3,0);
          while ($field3 = mysqli_fetch_field($result3)){
          } do {
            ?>
          <tr>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row3[1];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">
              <?php
              $sql_a = " SELECT COUNT(integrante_discapacidad.idintegrante_discapacidad) FROM integrante_discapacidad, carpeta_familiar ";
              $sql_a.= " WHERE integrante_discapacidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO'  ";
              $sql_a.= " AND integrante_discapacidad.idtipo_discapacidad_cf='$row3[0]' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
              $result_a = mysqli_query($link,$sql_a);
              $row_a = mysqli_fetch_array($result_a);
              echo $row_a[0];
                  if ($total_td =='0') {
                     $discapacidad_p = '0';
                  } else { 
                     $discapacidad_p = ($row_a[0]*100)/$total_td;
                  }            
              ?>  

            </td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo number_format($discapacidad_p, 2, '.', '');?></td>
          </tr>
          <?php 
          } while ($row3 = mysqli_fetch_array($result3));
          } else {
          }
          ?>
        </tbody>
      </table></td>
      <td colspan="2">
          <?php
          $sql_a =" SELECT evaluacion_familiar_cf.idcarpeta_familiar FROM evaluacion_familiar_cf, carpeta_familiar  ";
          $sql_a.=" WHERE evaluacion_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
          $sql_a.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
          $sql_a.=" AND evaluacion_familiar_cf.evaluacion_familiar='FAMILIA CON RIESGO BAJO' GROUP BY evaluacion_familiar_cf.idcarpeta_familiar ";
          $result_a = mysqli_query($link,$sql_a);
          $riesgo_bajo = mysqli_num_rows($result_a);

          $sql_b =" SELECT evaluacion_familiar_cf.idcarpeta_familiar FROM evaluacion_familiar_cf, carpeta_familiar ";
          $sql_b.=" WHERE evaluacion_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
          $sql_b.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
          $sql_b.=" AND evaluacion_familiar_cf.evaluacion_familiar='FAMILIA CON RIESGO MEDIANO' GROUP BY evaluacion_familiar_cf.idcarpeta_familiar ";
          $result_b = mysqli_query($link,$sql_b);
          $riesgo_mediano = mysqli_num_rows($result_b);

          $sql_c =" SELECT evaluacion_familiar_cf.idcarpeta_familiar FROM evaluacion_familiar_cf, carpeta_familiar ";
          $sql_c.=" WHERE evaluacion_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
          $sql_c.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
          $sql_c.=" AND evaluacion_familiar_cf.evaluacion_familiar='FAMILIA CON RIESGO ALTO' GROUP BY evaluacion_familiar_cf.idcarpeta_familiar ";
          $result_c = mysqli_query($link,$sql_c);
          $riesgo_alto = mysqli_num_rows($result_c);

          $riesgo_bajo_p    = ($riesgo_bajo*100)/$carpetizacion;
          $riesgo_mediano_p = ($riesgo_mediano*100)/$carpetizacion;
          $riesgo_alto_p    = ($riesgo_alto*100)/$carpetizacion;
          ?>

      
            <table width="450" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="305" style="font-family: Arial; font-size: 12px; text-align: center;">EVALUACIÓN DE LA SALUD FAMILIAR</td>
            <td width="93" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD DE FAMILIAS</td>
            <td width="38" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">FAMILIAS CON RIESGO BAJO</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $riesgo_bajo;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo number_format($riesgo_bajo_p, 2, '.', '');?></td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">FAMILIAS CON RIESGO MEDIANO</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $riesgo_mediano;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo number_format($riesgo_mediano_p, 2, '.', '');?></td>
          </tr>
                    <tr>
            <td style="font-family: Arial; font-size: 12px;">FAMILIAS CON RIESGO ALTO</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $riesgo_alto;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo number_format($riesgo_alto_p, 2, '.', '');?></td>
          </tr>
        </tbody>
      </table>

      </td>
    </tr>
    <tr>
      <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
      <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"></td>
      <td colspan="2"></td>
    </tr>

    <tr>
      <td colspan="2"><table width="450" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="405" style="font-family: Arial; font-size: 12px;">PLAN DE SGUIMIENTO FAMILIAR</td>
            <td width="53" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD</td>
            <td width="53" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">N° DE FAMILIAS CON PLANIFICACIÓN DE SEGUIMIENTO </td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">
    <?php 
    $sql_cf =" SELECT seguimiento_cf.idcarpeta_familiar FROM seguimiento_cf, carpeta_familiar WHERE seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
    $sql_cf.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' GROUP BY seguimiento_cf.idcarpeta_familiar ";
    $result_cf = mysqli_query($link,$sql_cf);
    $row_cf = mysqli_num_rows($result_cf);
    $seguimientos_cf  = number_format($row_cf, 0, '.', '.');
    $p_seguimientos_cf = ($row_cf*100)/$carpetizacion;
    echo $seguimientos_cf;?>
            </td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo number_format($p_seguimientos_cf, 2, '.', '');?></td>
          </tr>

        </tbody>
      </table></td>
      <td colspan="2">
        
    <table width="450" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="305" style="font-family: Arial; font-size: 12px;">PLAN DE SEGUIMIENTO RIÉSGO BIOLÓGICO PERSONAL</td>
            <td width="93" style="font-family: Arial; font-size: 12px; text-align: center;">CANTIDAD</td>
            <td width="38" style="font-family: Arial; font-size: 12px; text-align: center;">%</td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">N° DE INTEGRANTES CON SEGUIMIENTO PLANIFICADO</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">
            <?php 
            $sql_seg =" SELECT count(seguimiento_cf.idseguimiento_cf) FROM seguimiento_cf, carpeta_familiar ";
            $sql_seg.=" WHERE seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
            $result_seg = mysqli_query($link,$sql_seg);
            $row_seg = mysqli_fetch_array($result_seg);
            $seguimientos_int  = number_format($row_seg[0], 0, '.', '.');
            $p_seguimientos_int = ($row_seg[0]*100)/$integrantes;
            echo $seguimientos_int;?>
            </td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo number_format($p_seguimientos_int, 2, '.', '');?></td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">N° DE VISITAS PLANIFICADAS</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">
              <?php 
              $sql_pr =" SELECT count(visita_cf.idvisita_cf) FROM visita_cf, seguimiento_cf, carpeta_familiar WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf ";
              $sql_pr.=" AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
              $result_pr = mysqli_query($link,$sql_pr);
              $row_pr = mysqli_fetch_array($result_pr);
              $programadas  = number_format($row_pr[0], 0, '.', '.');
              echo $programadas;?>
            </td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"></td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">N° DE VISITAS REALIZADAS A LA FECHA</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">
            <?php 
              $sql_re =" SELECT count(visita_cf.idvisita_cf) FROM visita_cf, seguimiento_cf, carpeta_familiar WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf ";
              $sql_re.=" AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND visita_cf.idestado_visita_cf='3' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
              $result_re = mysqli_query($link,$sql_re);
              $row_re = mysqli_fetch_array($result_re);
              $realizadas  = number_format($row_re[0], 0, '.', '.');
              if ($row_pr[0]=='0') {
                $p_realizadas = 0;
              } else {
                $p_realizadas = ($row_re[0]*100)/$row_pr[0]; 
              }
              
              echo $realizadas;?>
            </td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo number_format($p_realizadas, 2, '.', '');?></td>
          </tr>
        </tbody>
      </table>

      </td>
    </tr>
    <tr>
      <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
      <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
    </tr>

    <tr>
      <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
      <td style="font-family: Arial; font-size: 12px; text-align: center;"></td>
      <td style="font-family: Arial; font-size: 12px;">
          <p style="text-align: center; font-size: 9px; font-family: Arial;">
<?php
/*
 * Algoritmo para codificacion QR
 *
 * SE emplea el include con el scripti phpqrcode.php
 *
 */
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "../implementacion_safci/phpqrcode.php";

    //capturamos el valor de "data"

    $separador='|';
    $tamano='M';

    $_REQUEST['data'] = 'https://virtual-safci.minsalud.gob.bo/medi-safci/carpetas_familiares/informe_operativo.php?idestablecimiento_salud='.$idestablecimiento_salud;
    $_REQUEST['size'] = 2 ;
    $_REQUEST['level'] = $tamano ;

    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);


    $filename = $PNG_TEMP_DIR.'test.png';

    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];

    $matrixPointSize = 4;
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


    if (isset($_REQUEST['data'])) {

        //it's very important!
        if (trim($_REQUEST['data']) == '')
            die('data cannot be empty! <a href="?">back</a>');

        // user data
        $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);

    } else {

        //default data
        echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>
        <div align="right">';
        QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);

    }

    //display generated file


echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" />';

?></p>
              <p style="text-align: center; font-size: 9px; font-family: Arial;"> Verificacion MEDI-SAFCI</p> 
      </td>
      <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="412" style="font-family: Arial; font-size: 12px; text-align: center;"><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p style="text-align: center">............................................................................................</p>
      <p style="text-align: center">Firma </p>
        <p>Fecha de la Declaracion Jurada : 
        <?php 
        $fecha_d = explode('-',$fecha);
        $f_declaracion = $fecha_d[2].'/'.$fecha_d[1].'/'.$fecha_d[0];?>
        <?php echo $f_declaracion;?> </p>
    </td>
      <td width="409" style="font-family: Arial; font-size: 12px; text-align: center;">
        

      
      </td>
      <td style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
    </tr>
  </tbody>
</table>

</body>
</html>