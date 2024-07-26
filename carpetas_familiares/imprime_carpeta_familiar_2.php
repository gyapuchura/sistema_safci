<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");

$idcarpeta_familiar_ss = $_GET['idcarpeta_familiar']; 
        
?>
<table width="1200" border="0" align="center">
  <tbody>
    <tr>
      <td style="text-align: center; font-family: Arial; font-size: 24px; color: #503B92;"><strong>V.- SALUD DE LOS INTEGRANTES DE LA FAMILIA</strong></td>
    </tr>
    <tr>
      <td><table width="1200" border="1" align="center" cellspacing="0">
        <tbody>
          <tr>
            <td width="20" rowspan="2" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 12px;">Nº</td>
            <td width="258" rowspan="2" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 12px; text-align: center;"><strong>INTEGRANTE</strong></td>
            <td width="50" rowspan="2" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 12px; text-align: center;"><strong>EDAD</strong></td>
            <td width="204" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: center;"><strong>GRUPO I</strong></td>
            <td width="191" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: center;"><strong>GRUPO II</strong></td>
            <td width="174" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: center;"><strong>GRUPO III</strong></td>
            <td width="171" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: center;"><strong>GRUPO IV</strong></td>
            <td width="133" rowspan="2" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: center;">CLASIFICACIÓN DEL GRUPO DE RIESGO DE SALUD</td>
          </tr>
          <tr>
            <td bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><strong>APARENTEMENTE SANO</strong></td>
            <td bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><strong>FACTORES DE RIESGO</strong></td>
            <td bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><strong>MORBILIDAD</strong></td>
            <td bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><strong>DISCAPACIDAD</strong></td>
            </tr>
            <?php
              $numero=1;
              $sqli =" SELECT integrante_cf.idintegrante_cf, nombre.ci, nombre.complemento, nombre.paterno, nombre.materno, nombre.nombre, ";
              $sqli.=" parentesco.parentesco, genero.genero, nombre.fecha_nac, integrante_cf.edad, nacion.nacion, integrante_cf.estado, integrante_cf.idnombre, nombre.idgenero FROM integrante_cf, nombre, parentesco, genero, nacion ";
              $sqli.=" WHERE integrante_cf.idnombre=nombre.idnombre AND integrante_cf.idparentesco=parentesco.idparentesco AND integrante_cf.idnacion=nacion.idnacion ";
              $sqli.=" AND nombre.idgenero=genero.idgenero AND integrante_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ORDER BY integrante_cf.edad DESC ";
              $resulti = mysqli_query($link,$sqli);
              if ($rowi = mysqli_fetch_array($resulti)){
              mysqli_field_seek($resulti,0);
              while ($fieldi = mysqli_fetch_field($resulti)){
              } do { 
              ?>
          <tr>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $numero;?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;"><?php echo $rowi[3];?> <?php echo $rowi[4];?> <?php echo $rowi[5];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $rowi[9];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">
            <?php
            $numeroa=1;
            $sqla =" SELECT idintegrante_ap_sano, integrante_ap_sano FROM integrante_ap_sano WHERE idintegrante_cf='$rowi[0]' ";
            $resulta = mysqli_query($link,$sqla);
            if ($rowa = mysqli_fetch_array($resulta)){
            mysqli_field_seek($resulta,0);
            while ($fielda = mysqli_fetch_field($resulta)){
            } do { 
            ?>
              <?php echo "- ".$rowa[1];?>
            <?php
            $numeroa=$numeroa+1;
            }
            while ($rowa = mysqli_fetch_array($resulta));
            } else {
            }
            ?>
            </td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">
            <?php
            $numerob=1;
            $sqlb =" SELECT integrante_factor_riesgo.idintegrante_factor_riesgo, factor_riesgo_cf.factor_riesgo_cf,  ";
            $sqlb.=" factor_riesgo_cf.vulnerable, integrante_factor_riesgo.otro_factor_riesgo  FROM integrante_factor_riesgo, factor_riesgo_cf ";
            $sqlb.=" WHERE integrante_factor_riesgo.idfactor_riesgo_cf=factor_riesgo_cf.idfactor_riesgo_cf ";
            $sqlb.=" AND integrante_factor_riesgo.idintegrante_cf='$rowi[0]' ";
            $resultb = mysqli_query($link,$sqlb);
            if ($rowb = mysqli_fetch_array($resultb)){
            mysqli_field_seek($resultb,0);
            while ($fieldb = mysqli_fetch_field($resultb)){
            } do { 
            ?>
              <?php echo "- ".$rowb[1];
              if ($rowb[2] == 'SI') { echo " - VULNERABLE"; } else { } ?>                    
              <?php  echo $rowb[3];?></br>
            <?php
            $numerob=$numerob+1;
            }
            while ($rowb = mysqli_fetch_array($resultb));
            } else {
            }
            ?>
            </td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">
            <?php
            $numeroc=1;
            $sqlc =" SELECT integrante_morbilidad.idintegrante_morbilidad, morbilidad_cf.morbilidad_cf, tipo_enfermedad_cf.tipo_enfermedad_cf, integrante_morbilidad.otra_enfermedad  ";
            $sqlc.=" FROM integrante_morbilidad, morbilidad_cf, tipo_enfermedad_cf WHERE integrante_morbilidad.idmorbilidad_cf=morbilidad_cf.idmorbilidad_cf ";
            $sqlc.=" AND morbilidad_cf.idtipo_enfermedad_cf=tipo_enfermedad_cf.idtipo_enfermedad_cf AND integrante_morbilidad.idintegrante_cf='$rowi[0]' ";
            $resultc = mysqli_query($link,$sqlc);
            if ($rowc = mysqli_fetch_array($resultc)){
            mysqli_field_seek($resultc,0);
            while ($fieldc = mysqli_fetch_field($resultc)){
            } do { 
            ?>
                - <?php echo $rowc[1];?> - <?php  echo $rowc[2];?> 
                <?php if ($rowc[3] != ' ') { echo " - ".$rowc[3]; } else { } ?> </br>
            <?php
            $numeroc=$numeroc+1;
            }
            while ($rowc = mysqli_fetch_array($resultc));
            } else {
            }
            ?>
            </td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">
            <?php
            $numerod=1;
            $sqld =" SELECT integrante_discapacidad.idintegrante_discapacidad, tipo_discapacidad_cf.tipo_discapacidad_cf, ";
            $sqld.=" nivel_discapacidad_cf.nivel_discapacidad_cf FROM integrante_discapacidad, tipo_discapacidad_cf, nivel_discapacidad_cf ";
            $sqld.=" WHERE integrante_discapacidad.idtipo_discapacidad_cf=tipo_discapacidad_cf.idtipo_discapacidad_cf ";
            $sqld.=" AND integrante_discapacidad.idnivel_discapacidad_cf=nivel_discapacidad_cf.idnivel_discapacidad_cf AND integrante_discapacidad.idintegrante_cf='$rowi[0]' ";
            $resultd = mysqli_query($link,$sqld);
            if ($rowd = mysqli_fetch_array($resultd)){
            mysqli_field_seek($resultd,0);
            while ($fieldd = mysqli_fetch_field($resultd)){
            } do { 
            ?>
               <?php echo "- DISCAPACIDAD : ".$rowd[1];?> - <?php  echo $rowd[2];?></br>
            <?php
            $numerod=$numerod+1;
            }
            while ($rowd = mysqli_fetch_array($resultd));
            } else {
            }
            ?>
            </td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">
            <?php
            $sql1 =" SELECT grupo_cf.idgrupo_cf, grupo_cf.grupo_cf FROM integrante_ap_sano, grupo_cf WHERE integrante_ap_sano.idgrupo_cf=grupo_cf.idgrupo_cf ";
            $sql1.="  AND integrante_ap_sano.idintegrante_cf='$rowi[0]' GROUP BY grupo_cf.idgrupo_cf ";
            $result1 = mysqli_query($link,$sql1);
            if ($row1 = mysqli_fetch_array($result1)){
            mysqli_field_seek($result1,0);
            while ($field1 = mysqli_fetch_field($result1)){
            } do { 
            ?>
               <?php echo "- ".$row1[1];?></br>
            <?php
            
            }
            while ($row1 = mysqli_fetch_array($result1));
            } else {
            }
            ?>
            <?php
            $sql2 =" SELECT grupo_cf.idgrupo_cf, grupo_cf.grupo_cf FROM integrante_factor_riesgo, grupo_cf WHERE integrante_factor_riesgo.idgrupo_cf=grupo_cf.idgrupo_cf ";
            $sql2.=" AND integrante_factor_riesgo.idintegrante_cf='$rowi[0]' GROUP BY grupo_cf.idgrupo_cf ";
            $result2 = mysqli_query($link,$sql2);
            if ($row2 = mysqli_fetch_array($result2)){
            mysqli_field_seek($result2,0);
            while ($field2 = mysqli_fetch_field($result2)){
            } do { 
            ?>
               <?php echo "- ".$row2[1];?></br>
            <?php
            }
            while ($row2 = mysqli_fetch_array($result2));
            } else {
            }
            ?>
            <?php
            $sql3 =" SELECT grupo_cf.idgrupo_cf, grupo_cf.grupo_cf FROM integrante_morbilidad, grupo_cf WHERE integrante_morbilidad.idgrupo_cf=grupo_cf.idgrupo_cf  ";
            $sql3.="  AND integrante_morbilidad.idintegrante_cf='$rowi[0]' GROUP BY grupo_cf.idgrupo_cf ";
            $result3 = mysqli_query($link,$sql3);
            if ($row3 = mysqli_fetch_array($result3)){
            mysqli_field_seek($result3,0);
            while ($field3 = mysqli_fetch_field($result3)){
            } do { 
            ?>
               <?php echo "- ".$row3[1];?></br>
            <?php
            }
            while ($row3 = mysqli_fetch_array($result3));
            } else {
            }
            ?>
            <?php
            $sqld =" SELECT grupo_cf.idgrupo_cf, grupo_cf.grupo_cf FROM integrante_discapacidad, grupo_cf WHERE integrante_discapacidad.idgrupo_cf=grupo_cf.idgrupo_cf  ";
            $sqld.=" AND integrante_discapacidad.idintegrante_cf='$rowi[0]' GROUP BY grupo_cf.idgrupo_cf ";
            $resultd = mysqli_query($link,$sqld);
            if ($rowd = mysqli_fetch_array($resultd)){
            mysqli_field_seek($resultd,0);
            while ($fieldd = mysqli_fetch_field($resultd)){
            } do { 
            ?>
               <?php echo "- ".$rowd[1];?></br>
            <?php
            }
            while ($rowd = mysqli_fetch_array($resultd));
            } else {
            }
            ?>

            </td>
          </tr>
          <?php
                $numero=$numero+1;
                }
                while ($rowi = mysqli_fetch_array($resulti));
                } else {
                }
            ?>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td><table width="1200" height="225" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="20" rowspan="2" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 12px;"><strong>Nº</strong></td>
            <td width="262" rowspan="2" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 12px; text-align: center;"><strong>INTEGRANTE</strong></td>
            <td width="50" rowspan="2" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 12px; text-align: center;"><strong>EDAD</strong></td>
            <td colspan="3" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 12px; text-align: center;"><strong>VI. SUBSECTOR</strong></td>
            <td width="207" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 12px; text-align: center;"><strong>VII. BENEFICIARIO DE PROGRAMAS SOCIALES</strong></td>
            <td colspan="3" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 12px; text-align: center;"><strong>VII MEDICINA TRADICIONAL</strong></td>
            <td colspan="2" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 12px; text-align: center;"><strong>IX. DEFUNCIÓN</strong></td>
            </tr>
          <tr>
            <td width="92" bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">A que subsector le corresponde la atencion médica</td>
            <td width="89" bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">Acude al Subsector que le corresponde?</td>
            <td width="106" bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">A que subsector asiste</td>
            <td bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">Programas Sociales</td>
            <td width="77" bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">Recurre a la Medicina Tradicional?</td>
            <td width="103" bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">A qué Categoría de  la Medicina  Tradicional Recurre</td>
            <td width="73" bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">Dónde  fue  atendido</td>
            <td width="58" bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">¿El  integrante  de la familia  falleció?</td>
            <td width="59" bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">Tiene  certificado  de  defunción</td>
          </tr>
          <?php
              $numerof=1;
              $sqlf =" SELECT integrante_cf.idintegrante_cf, nombre.ci, nombre.complemento, nombre.paterno, nombre.materno, nombre.nombre, ";
              $sqlf.=" parentesco.parentesco, genero.genero, nombre.fecha_nac, integrante_cf.edad, nacion.nacion, integrante_cf.estado, integrante_cf.idnombre, nombre.idgenero FROM integrante_cf, nombre, parentesco, genero, nacion ";
              $sqlf.=" WHERE integrante_cf.idnombre=nombre.idnombre AND integrante_cf.idparentesco=parentesco.idparentesco AND integrante_cf.idnacion=nacion.idnacion ";
              $sqlf.=" AND nombre.idgenero=genero.idgenero AND integrante_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ORDER BY integrante_cf.edad DESC ";
              $resultf = mysqli_query($link,$sqlf);
              if ($rowf = mysqli_fetch_array($resultf)){
              mysqli_field_seek($resultf,0);
              while ($fieldf = mysqli_fetch_field($resultf)){
              } do { 
              ?>
          <tr>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $numerof;?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;"><?php echo $rowf[3];?> <?php echo $rowf[4];?> <?php echo $rowf[5];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $rowf[9];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">
            <?php
                
                  $sql4 =" SELECT integrante_subsector_salud.idintegrante_subsector_salud, subsector_elige.subsector_elige, subsector_salud.subsector_salud, integrante_subsector_salud.idsubsector_salud ";
                  $sql4.=" FROM integrante_subsector_salud, subsector_elige, subsector_salud WHERE integrante_subsector_salud.idsubsector_elige=subsector_elige.idsubsector_elige ";
                  $sql4.=" AND integrante_subsector_salud.idsubsector_salud=subsector_salud.idsubsector_salud AND integrante_subsector_salud.idintegrante_cf='$rowf[0]' AND integrante_subsector_salud.idsubsector_elige='1' ";
                  $result4 = mysqli_query($link,$sql4);
                  if ($row4 = mysqli_fetch_array($result4)){
                  mysqli_field_seek($result4,0);
                  while ($field4 = mysqli_fetch_field($result4)){
                  } do { 
                  ?>

                      <?php if ($row4[3] == '9') { } else { echo " ".$row4[1];} ?>
                      <?php echo $row4[2];?></br>
                                              
                  <?php
                  
                  }
                  while ($row4 = mysqli_fetch_array($result4));
                  } else {
                  }
            ?>
            </td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">
                <?php           
                  $sql6 =" SELECT idintegrante_subsector_salud, idsubsector_salud, idsubsector_elige FROM integrante_subsector_salud WHERE idintegrante_cf='$rowf[0]' GROUP BY idsubsector_salud ";
                  $result6 = mysqli_query($link,$sql6);
                  if ($row6 = mysqli_fetch_array($result6)){
                  mysqli_field_seek($result6,0);
                  while ($field6 = mysqli_fetch_field($result6)){
                  } do { 

                  $sql7 =" SELECT idintegrante_subsector_salud, idsubsector_salud, idsubsector_elige FROM integrante_subsector_salud WHERE idintegrante_cf='$rowf[0]' AND idsubsector_salud='$row6[1]' AND idsubsector_elige='1' ";
                  $result7 = mysqli_query($link,$sql7);
                  if ($row7 = mysqli_fetch_array($result7)){
                  mysqli_field_seek($result7,0);
                  while ($field7 = mysqli_fetch_field($result7)){
                  } do { 

                      $sql8 =" SELECT idintegrante_subsector_salud, idsubsector_salud, idsubsector_elige FROM integrante_subsector_salud WHERE idintegrante_cf='$rowf[0]' AND idsubsector_salud='$row6[1]' AND idsubsector_elige='2' ";
                      $result8 = mysqli_query($link,$sql8);
                      if ($row8 = mysqli_fetch_array($result8)){
                      mysqli_field_seek($result8,0);
                      while ($field8 = mysqli_fetch_field($result8)){
                      } do {     
                          echo " SI ";    
                      }
                      while ($row8 = mysqli_fetch_array($result8));
                      } else {
                          echo " NO ";
                      }
                  }
                  while ($row7 = mysqli_fetch_array($result7));
                  } else {              
                  }           
                  }
                  while ($row6 = mysqli_fetch_array($result6));
                  } else {
                  }
                ?>
            </td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">
            <?php
                  $numero=1;
                  $sql4 =" SELECT integrante_subsector_salud.idintegrante_subsector_salud, subsector_elige.subsector_elige, subsector_salud.subsector_salud, integrante_subsector_salud.idsubsector_salud ";
                  $sql4.=" FROM integrante_subsector_salud, subsector_elige, subsector_salud WHERE integrante_subsector_salud.idsubsector_elige=subsector_elige.idsubsector_elige ";
                  $sql4.=" AND integrante_subsector_salud.idsubsector_salud=subsector_salud.idsubsector_salud AND integrante_subsector_salud.idintegrante_cf='$rowf[0]' AND integrante_subsector_salud.idsubsector_elige='2' ";
                  $result4 = mysqli_query($link,$sql4);
                  if ($row4 = mysqli_fetch_array($result4)){
                  mysqli_field_seek($result4,0);
                  while ($field4 = mysqli_fetch_field($result4)){
                  } do { 
                  ?>

                      <?php if ($row4[3] == '9') { } else { echo " ".$row4[1];} ?>
                      <?php echo $row4[2];?>
                                              
                  <?php
                  $numero=$numero+1;
                  }
                  while ($row4 = mysqli_fetch_array($result4));
                  } else {
                  }
            ?>
            </td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">
            <?php
                $sql4 =" SELECT integrante_beneficiario.idintegrante_beneficiario, programa_social.programa_social,   ";
                $sql4.=" integrante_beneficiario.otros_beneficios FROM integrante_beneficiario, programa_social  ";
                $sql4.=" WHERE integrante_beneficiario.idprograma_social=programa_social.idprograma_social ";
                $sql4.=" AND integrante_beneficiario.idintegrante_cf='$rowf[0]' ";
                $result4 = mysqli_query($link,$sql4);
                if ($row4 = mysqli_fetch_array($result4)){
                mysqli_field_seek($result4,0);
                while ($field4 = mysqli_fetch_field($result4)){
                } do { 
                ?>
                    <?php echo "- ".$row4[1];?>
                    <?php if ($row4[2] != '') { echo " : ".$row4[2]; } else { } ?> </br>       
                <?php              
                }
                while ($row4 = mysqli_fetch_array($result4));
                } else {
                }
            ?>
            </td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">
            <?php
                $sql4 =" SELECT integrante_tradicional.idintegrante_tradicional, medicina_tradicional.medicina_tradicional, lugar_atencion_trad.lugar_atencion_trad, integrante_tradicional.idmedicina_tradicional ";
                $sql4.=" FROM integrante_tradicional, medicina_tradicional, lugar_atencion_trad WHERE integrante_tradicional.idmedicina_tradicional=medicina_tradicional.idmedicina_tradicional ";
                $sql4.=" AND integrante_tradicional.idlugar_atencion_trad=lugar_atencion_trad.idlugar_atencion_trad AND integrante_tradicional.idintegrante_cf='$rowf[0]' ORDER BY integrante_tradicional.idintegrante_tradicional DESC LIMIT 1 ";
                $result4 = mysqli_query($link,$sql4);
                if ($row4 = mysqli_fetch_array($result4)){
                mysqli_field_seek($result4,0);
                while ($field4 = mysqli_fetch_field($result4)){
                } do { 

                  if ($row4[3] == '5') {
                    echo "NO";
                  } else {
                    echo "SI";
                  }
                                                      
                }
                while ($row4 = mysqli_fetch_array($result4));
                } else {
                }
            ?>
            </td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">
            <?php

                $sql4 =" SELECT integrante_tradicional.idintegrante_tradicional, medicina_tradicional.medicina_tradicional, lugar_atencion_trad.lugar_atencion_trad ";
                $sql4.=" FROM integrante_tradicional, medicina_tradicional, lugar_atencion_trad WHERE integrante_tradicional.idmedicina_tradicional=medicina_tradicional.idmedicina_tradicional ";
                $sql4.=" AND integrante_tradicional.idlugar_atencion_trad=lugar_atencion_trad.idlugar_atencion_trad AND integrante_tradicional.idintegrante_cf='$rowf[0]' ";
                $result4 = mysqli_query($link,$sql4);
                if ($row4 = mysqli_fetch_array($result4)){
                mysqli_field_seek($result4,0);
                while ($field4 = mysqli_fetch_field($result4)){
                } do { 
                ?>
                <?php echo "- ".$row4[1];?></br>                        
                <?php
                }
                while ($row4 = mysqli_fetch_array($result4));
                } else {
                }
            ?>
            </td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">
            <?php
                $sql4 =" SELECT integrante_tradicional.idintegrante_tradicional, medicina_tradicional.medicina_tradicional, lugar_atencion_trad.lugar_atencion_trad ";
                $sql4.=" FROM integrante_tradicional, medicina_tradicional, lugar_atencion_trad WHERE integrante_tradicional.idmedicina_tradicional=medicina_tradicional.idmedicina_tradicional ";
                $sql4.=" AND integrante_tradicional.idlugar_atencion_trad=lugar_atencion_trad.idlugar_atencion_trad AND integrante_tradicional.idintegrante_cf='$rowf[0]' ";
                $result4 = mysqli_query($link,$sql4);
                if ($row4 = mysqli_fetch_array($result4)){
                mysqli_field_seek($result4,0);
                while ($field4 = mysqli_fetch_field($result4)){
                } do { 
                ?>
                <?php echo "- ".$row4[2];?></br>                             
                <?php
                }
                while ($row4 = mysqli_fetch_array($result4));
                } else {
                }
                ?>
            </td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">
            <?php
                $sql4 =" SELECT idintegrante_defuncion, defuncion_cf, certificado_defuncion_cf FROM integrante_defuncion WHERE idintegrante_cf ='$rowf[0]' ";
                $result4 = mysqli_query($link,$sql4);
                if ($row4 = mysqli_fetch_array($result4)){
                mysqli_field_seek($result4,0);
                while ($field4 = mysqli_fetch_field($result4)){
                } do { 

                  echo $row4[1];

                }
                while ($row4 = mysqli_fetch_array($result4));
                } else {
                }
            ?>
            </td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">
            <?php
                $sql4 =" SELECT idintegrante_defuncion, defuncion_cf, certificado_defuncion_cf FROM integrante_defuncion WHERE idintegrante_cf ='$rowf[0]' ";
                $result4 = mysqli_query($link,$sql4);
                if ($row4 = mysqli_fetch_array($result4)){
                mysqli_field_seek($result4,0);
                while ($field4 = mysqli_fetch_field($result4)){
                } do { 

                  echo $row4[2];

                }
                while ($row4 = mysqli_fetch_array($result4));
                } else {
                }
            ?>
            </td>
          </tr>
          <?php
                $numerof=$numerof+1;
                }
                while ($rowf = mysqli_fetch_array($resultf));
                } else {
                }
            ?>
         
        </tbody>
      </table></td>
    </tr>
  </tbody>
</table>
