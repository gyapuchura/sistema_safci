<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram = date("Ymd");
$fecha     = date("Y-m-d");
$gestion   = date("Y");

$idbono_nino_sano = $_GET['idbono_nino_sano'];

        $sql =" SELECT bono_nino_sano.idbono_nino_sano, bono_nino_sano.codigo, departamento.departamento, municipios.municipio, red_salud.red_salud, establecimiento_salud.establecimiento_salud, ";
        $sql.=" tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, bono_nino_sano.idnombre_nino, bono_nino_sano.idnombre_madre, bono_nino_sano.numero_controles, bono_nino_sano.nino_carpetizado, ";
        $sql.=" bono_nino_sano.direccion_domicilio, bono_nino_sano.celular_madre, bono_nino_sano.cuenta_madre, bono_nino_sano.fecha_inscripcion_bono, bono_nino_sano.lug_nac_nino, bono_nino_sano.lug_nac_madre, bono_nino_sano.idparentesco";
        $sql.=" FROM bono_nino_sano, departamento, municipios, red_salud, establecimiento_salud, area_influencia, tipo_area_influencia WHERE bono_nino_sano.iddepartamento=departamento.iddepartamento ";
        $sql.=" AND bono_nino_sano.idmunicipio=municipios.idmunicipio AND bono_nino_sano.idred_salud=red_salud.idred_salud AND bono_nino_sano.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
        $sql.=" AND bono_nino_sano.idarea_influencia=area_influencia.idarea_influencia AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia ";
        $sql.=" AND bono_nino_sano.idbono_nino_sano='$idbono_nino_sano' ";
        $result = mysqli_query($link,$sql);
        $row = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FORMULARIO DE CONTROL NINO SANO</title>
</head>
<body>
  
<table width="900" border="0" align="center">
  <tbody>
    <tr>
      <td width="150" rowspan="3"><img src="../implementacion_safci/mds_logo.jpg" width="193" height="85" alt=""/></td>
      <td style="text-align: center; font-family: Arial; font-size: 14px;">BONO JUANA AZURDUY</td>
      <td width="150" rowspan="3"><img src="bono_juana_azurduy.png" width="164" height="77"></td>
    </tr>
    <tr>
      <td style="text-align: center; font-family: Arial; font-size: 14px;">FORMULARIO ÚNICO DE INSCRIPCIÓN Y CONTROL DE</td>
    </tr>
    <tr>
      <td width="590" style="text-align: center; font-size: 14px; font-family: Arial;">CORRESPONSABILIDADES NIÑO / NIÑA MENOR DE 2 AÑOS</td>
    </tr>
    <tr>
      <td colspan="3" style="text-align: center; font-size: 14px; font-family: Arial;">CÓDIGO : <?php echo $row[1];?></td>
    </tr>
    <tr>
      <td colspan="3"><table width="900" border="0">
        <tbody>
          <tr>
            <td width="250" bgcolor="#1D2E8B" style="font-family: Arial; font-size: 12px; color: #FFFFFF; text-align: center;">LUGAR GEOGRÁFICO</td>
            <td width="327" bgcolor="#1D2E8B" style="font-size: 12px; font-family: Arial; color: #FFFFFF; text-align: center;">DATOS DEL BENEFICIARIO NIÑO/NIÑA</td>
            <td width="309" bgcolor="#1D2E8B" style="font-size: 12px; font-family: Arial; color: #FFFFFF; text-align: center;">DATOS DE LA TITULAR DE PAGO</td>
          </tr>
          <tr>
            <td valign="top"><table width="250" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td width="118" style="font-family: Arial; font-size: 12px;">DEPARTAMENTO:</td>
                  <td width="122" style="font-family: Arial; font-size: 12px;"><?php echo $row[2];?></td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">MUNICIPIO:</td>
                  <td style="font-family: Arial; font-size: 12px;"><?php echo $row[3];?></td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">RED DE SALUD:</td>
                  <td style="font-family: Arial; font-size: 12px;"><?php echo $row[4];?></td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">ESTABLECIMIENTO DE SALUD:</td>
                  <td style="font-family: Arial; font-size: 12px;"><?php echo $row[5];?></td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">ÁREA DE INFLUENCIA:</td>
                  <td style="font-family: Arial; font-size: 12px;"><?php echo $row[6];?> <?php echo $row[7];?></td>
                </tr>
              </tbody>
            </table>
              <table width="250" border="1" cellspacing="0">
                <tbody>
                  <tr>
                    <td bgcolor="#1D2E8B" style="font-family: Arial; font-size: 12px; color: #FFFFFF; text-align: center;">FECHA DE INSCRIPCION AL PROGRAMA:</td>
                  </tr>
                  <tr>
                    <td style="font-family: Arial; font-size: 12px; text-align: center;">
                      <?php 
                      $fecha_ins = explode('-',$row[15]);
                      $fecha_inscripcion = $fecha_ins[2].'/'.$fecha_ins[1].'/'.$fecha_ins[0];
                      echo $fecha_inscripcion; ?>  
                  </td>
                  </tr>
                </tbody>
              </table></td>
            <td valign="top"><table width="325" border="1" cellspacing="0">
              <tbody>
                     <?php
                    $sql_n =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$row[8]' ";
                    $result_n=mysqli_query($link,$sql_n);
                    $row_n=mysqli_fetch_array($result_n);?>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">NOMBRES:</td>
                  <td colspan="4" style="font-family: Arial; font-size: 12px;">
                    <?php  echo mb_strtoupper($row_n[1]);?>
                  </td>
                  </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">PRIMER APELLIDO:</td>
                  <td colspan="4" style="font-family: Arial; font-size: 12px;"><?php  echo mb_strtoupper($row_n[2]);?></td>
                  </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">SEGUNDO APELLIDO:</td>
                  <td colspan="4" style="font-family: Arial; font-size: 12px;"><?php  echo mb_strtoupper($row_n[3]);?></td>
                </tr>
                <tr>
                  <td colspan="5" style="font-family: Arial; font-size: 9px;">NÚMERO DE CERTIFICADO DE NACIMIENTO (COMPLETO)</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 10px;">OFICIALIA:</td>
                  <td width="121" style="font-family: Arial; font-size: 10px;">LIBRO:</td>
                  <td width="15" style="font-family: Arial; font-size: 10px;">ANO:</td>
                  <td width="15" style="font-family: Arial; font-size: 10px;">PARTIDA:</td>
                  <td width="18" style="font-family: Arial; font-size: 10px;">FOLIO:</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">NÚMERO DE CEDULA DE IDENTIDAD:</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;"><?php  echo mb_strtoupper($row_n[4]);?></td>
                  <td style="font-family: Arial; font-size: 12px;">COMPLEMENTO:</td>
                  <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">SEXO:</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">
                    <?php
                    $sql_g =" SELECT genero FROM genero WHERE idgenero='$row_n[7]' ";
                    $result_g=mysqli_query($link,$sql_g);
                    $row_g=mysqli_fetch_array($result_g);
                    echo mb_strtoupper($row_g[0]);?>
                    </td>
                  <td style="font-family: Arial; font-size: 12px;">FECHA DE NACIMIENTO:</td>
                  <td style="font-family: Arial; font-size: 12px;">
                      <?php 
                      $fecha_ni = explode('-',$row_n[5]);
                      $fecha_nino = $fecha_ni[2].'/'.$fecha_ni[1].'/'.$fecha_ni[0];
                      echo $fecha_nino; ?>   
                  </td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">LUGAR DE NACIMIENTO:</td>
                  <td colspan="4" style="font-family: Arial; font-size: 12px;"><?php echo $row[16];?></td>
                  </tr>
              </tbody>
            </table></td>
            <td valign="top"><table width="325" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">NOMBRES:</td>
                  <td colspan="3" style="font-family: Arial; font-size: 12px;">
                    <?php
                    $sql_m =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$row[9]' ";
                    $result_m=mysqli_query($link,$sql_m);
                    $row_m=mysqli_fetch_array($result_m); 
                    echo mb_strtoupper($row_m[1]);?>
                  </td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">PRIMER APELLIDO:</td>
                  <td colspan="3" style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row_m[2]);?></td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">SEGUNDO APELLIDO:</td>
                  <td colspan="3" style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row_m[3]);?></td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">NÚMERO DE CÉDULA DE IDENTIDAD:</td>
                  <td width="136" style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row_m[4]);?></td>
                  <td width="15" style="font-family: Arial; font-size: 12px;">COMPLEMENTO:</td>
                  <td width="18" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">PARENTESCO:</td>
                  <td colspan="3" style="font-family: Arial; font-size: 12px;">
                    <?php
                    $sql_pa =" SELECT parentesco FROM parentesco WHERE idparentesco='$row[18]' ";
                    $result_pa=mysqli_query($link,$sql_pa);
                    $row_pa=mysqli_fetch_array($result_pa);
                    echo mb_strtoupper($row_pa[0]);?>  
                  </td>
                  </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">SEXO:</td>
                  <td style="font-family: Arial; font-size: 12px;">
                    <?php
                    $sql_ge =" SELECT genero FROM genero WHERE idgenero='$row_m[7]' ";
                    $result_ge=mysqli_query($link,$sql_ge);
                    $row_ge=mysqli_fetch_array($result_ge);
                    echo mb_strtoupper($row_ge[0]);?>  
                </td>
                  <td style="font-family: Arial; font-size: 12px;">FECHA DE NACIMIENTO:</td>
                  <td style="font-family: Arial; font-size: 12px;">
                      <?php 
                      $fecha_ma = explode('-',$row_m[5]);
                      $fecha_ma = $fecha_ma[2].'/'.$fecha_ma[1].'/'.$fecha_ma[0];
                      echo $fecha_ma; 
                      ?>    
                  </td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">LUGAR DE NACIMIENTO:</td>
                  <td colspan="3" style="font-family: Arial; font-size: 12px;"><?php echo $row[17];?></td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">DIRECCIÓN ACTUAL:</td>
                  <td colspan="3" style="font-family: Arial; font-size: 12px;"><?php echo $row[12];?></td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">TEL/CELULAR:</td>
                  <td colspan="3" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row[13];?></td>
                </tr>
              </tbody>
            </table></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#1D2E8B" style="font-family: Arial; font-size: 12px; color: #FFFFFF; text-align: center;">CONTROL DE CORRESPONSABILIDADES DEL NIÑO / NIÑA</td>
    </tr>
    <tr>
      <td colspan="3"><table width="225" border="0">
        <tbody>
         
           
        <tr>

        <?php
        $numero=0; 
        $sql1 =" SELECT diagnostico_psafci.iddiagnostico_psafci, diagnostico_psafci.idatencion_psafci, diagnostico_psafci.fecha_registro, diagnostico_psafci.idusuario FROM diagnostico_psafci, atencion_psafci WHERE diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci ";
        $sql1.=" AND diagnostico_psafci.idpatologia='239' AND atencion_psafci.idnombre='$row[8]' ";
        $result1 = mysqli_query($link,$sql1);
        if ($row1 = mysqli_fetch_array($result1)){
        mysqli_field_seek($result1,0);
        while ($field = mysqli_fetch_field($result1)){
        } do {

        $sql_sg =" SELECT idsigno_vital_psafci, frec_cardiaca, peso, talla, imc, frec_respiratoria, presion_arterial, presion_arterial_d, temperatura, saturacion, alergia, descripcion_alergia FROM signo_vital_psafci WHERE idatencion_psafci ='$row1[1]' ";
        $result_sg=mysqli_query($link,$sql_sg);
        $row_sg=mysqli_fetch_array($result_sg);

        ?>       
            <td> 

            <table width="225" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td colspan="4" bgcolor="#B5C7D8" style="text-align: center; font-family: Arial; font-size: 12px;">FECHA DE CONTROL</td>
                  </tr>
                <tr>
                  <td colspan="4" style="text-align: center; font-family: Arial; font-size: 12px;">
                      <?php 
                      $fecha_con = explode('-',$row1[2]);
                      $fecha_control = $fecha_con[2].'/'.$fecha_con[1].'/'.$fecha_con[0];
                      echo $fecha_control; 
                      ?>   
                  </td>
                  </tr>
                <tr>
                  <td bgcolor="#B5C7D8" style="text-align: center; font-family: Arial; font-size: 12px;">TALLA:</td>
                  <td style="text-align: center; font-family: Arial; font-size: 12px;"><?php echo $row_sg[3];?> [cm]</td>
                  <td bgcolor="#B5C7D8" style="text-align: center; font-family: Arial; font-size: 12px;">PESO:</td>
                  <td style="text-align: center; font-family: Arial; font-size: 12px;"><?php echo $row_sg[2];?> [kg]</td>
                </tr>
                <tr>
                  <td colspan="4" style="text-align: center; font-family: Arial; font-size: 12px;">
                    <p style="text-align: center; font-family: Arial; font-size: 10px;">&nbsp;</p>
                    <p style="text-align: center; font-family: Arial; font-size: 24px;"><?php echo $numero+1;?>°</p>
                    <p style="text-align: center; font-family: Arial; font-size: 10px;">
                          <?php 
                          $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                          $sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row1[3]' ";
                          $result_r = mysqli_query($link,$sql_r);
                          $row_r = mysqli_fetch_array($result_r);                    
                          echo mb_strtoupper("Médico: ".$row_r[0]." ".$row_r[1]." ".$row_r[2]);
                          ?>
                    </p>
                    <p style="text-align: center; font-family: Arial; font-size: 10px;">FIRMA Y SELLO</p></td>
                </tr>
                </tbody>
            </table>

        <?php
        $numero=$numero+1;

          if ($numero == '4' || $numero == '8' || $numero == '12' || $numero == '16' || $numero == '20' || $numero == '24' || $numero == '28' || $numero == '32') {
            echo '</td></tr><tr>';
          } else {
            echo '</td>';
          }
        
        }
        while ($row1 = mysqli_fetch_array($result1));
        } else {
        }
        ?>         
          </tr>
         
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>

</body>
</html>