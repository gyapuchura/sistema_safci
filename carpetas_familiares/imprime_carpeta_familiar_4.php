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
      <td width="378">&nbsp;</td>
      <td width="422" style="text-align: center; font-family: Arial; font-size: 24px; color: #503B92;"><p><strong>COMPORTAMIENTO FAMILIAR</strong></p></td>
      <td width="386">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><table width="1200" border="0">
        <tbody>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="601"><table width="601" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td width="38" bgcolor="#503B92" style="font-family: Arial; font-size: 12px; color: #FEFEFE; text-align: center;"><strong>N° </strong></td>
                  <td width="116" bgcolor="#503B92" style="font-family: Arial; color: #FFFFFF; font-size: 12px; text-align: center;"><strong>FECHA DE VISITA </strong></td>
                  <td width="433" bgcolor="#503B92" style="text-align: center; font-family: Arial; font-size: 12px; color: #FFFFFF;"><strong>XIV. ESTRUCTURA FAMILIAR</strong></td>
                </tr>
                <?php
                $numero=1;
                $sql4 =" SELECT estructura_familiar_cf.idestructura_familiar_cf, estructura_familiar.estructura_familiar, estructura_familiar_cf.fecha_registro ";
                $sql4.=" FROM estructura_familiar_cf, estructura_familiar WHERE estructura_familiar_cf.idestructura_familiar=estructura_familiar.idestructura_familiar ";
                $sql4.=" AND estructura_familiar_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                $result4 = mysqli_query($link,$sql4);
                if ($row4 = mysqli_fetch_array($result4)){
                mysqli_field_seek($result4,0);
                while ($field4 = mysqli_fetch_field($result4)){
                } do { 
                ?>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $numero; ?> </td>
                  <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">                                        
                    <?php 
                    $fecha_s = explode('-',$row4[2]);
                    $fecha_reg = $fecha_s[2].'/'.$fecha_s[1].'/'.$fecha_s[0];
                    echo $fecha_reg; ?></td>
                  <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row4[1];?></td>
                </tr>
                <?php
                    $numero=$numero+1;
                    }
                    while ($row4 = mysqli_fetch_array($result4));
                    } else {
                    }
                ?>
              </tbody>
            </table>
              <table width="601" border="1" cellspacing="0">
                <tbody>
                  <tr>
                    <td width="38" bgcolor="#503B92" style="font-family: Arial; font-size: 12px; color: #FEFEFE; text-align: center;"><strong>N° </strong></td>
                    <td width="114" bgcolor="#503B92" style="font-family: Arial; color: #FFFFFF; font-size: 12px; text-align: center;"><strong>FECHA DE VISITA </strong></td>
                    <td width="435" bgcolor="#503B92" style="text-align: center; font-family: Arial; font-size: 12px; color: #FFFFFF;">XV. ETAPA DEL CICLO  VITAL FAMILIAR</td>
                  </tr>
                  <?php
                    $numero5=1;
                    $sql5 =" SELECT etapa_familiar_cf.idetapa_familiar_cf, etapa_familiar.etapa_familiar, etapa_familiar_cf.fecha_registro ";
                    $sql5.=" FROM etapa_familiar_cf, etapa_familiar WHERE etapa_familiar_cf.idetapa_familiar=etapa_familiar.idetapa_familiar ";
                    $sql5.=" AND etapa_familiar_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                    $result5 = mysqli_query($link,$sql5);
                    if ($row5 = mysqli_fetch_array($result5)){
                    mysqli_field_seek($result5,0);
                    while ($field5 = mysqli_fetch_field($result5)){
                    } do { 
                    ?>
                  <tr>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $numero5;?></td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">
                    <?php 
                    $fecha_s = explode('-',$row5[2]);
                    $fecha_reg = $fecha_s[2].'/'.$fecha_s[1].'/'.$fecha_s[0];
                    echo $fecha_reg; ?>
                    </td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row5[1];?></td>
                  </tr>
                  <?php
                        $numero5=$numero5+1;
                        }
                        while ($row5 = mysqli_fetch_array($result5));
                        } else {
                        }
                    ?>
                </tbody>
              </table>
              <table width="601" border="1" cellspacing="0">
                <tbody>
                  <tr>
                    <td width="38" bgcolor="#503B92" style="font-family: Arial; font-size: 12px; color: #FEFEFE; text-align: center;"><strong>N° </strong></td>
                    <td width="114" bgcolor="#503B92" style="font-family: Arial; color: #FFFFFF; font-size: 12px; text-align: center;"><strong>FECHA DE VISITA </strong></td>
                    <td width="435" bgcolor="#503B92" style="text-align: center; font-family: Arial; font-size: 12px; color: #FFFFFF;">XVI. FUNCIONALIDAD FAMILIAR</td>
                  </tr>
                  <?php
                    $numero5=1;
                    $sql5 =" SELECT funcionalidad_familiar_cf.idfuncionalidad_familiar_cf, funcionalidad_familiar.funcionalidad_familiar, funcionalidad_familiar_cf.fecha_registro ";
                    $sql5.=" FROM funcionalidad_familiar_cf, funcionalidad_familiar WHERE funcionalidad_familiar_cf.idfuncionalidad_familiar=funcionalidad_familiar.idfuncionalidad_familiar ";
                    $sql5.=" AND funcionalidad_familiar_cf.idcarpeta_familiar='$idcarpeta_familiar_ss'  ";
                    $result5 = mysqli_query($link,$sql5);
                    if ($row5 = mysqli_fetch_array($result5)){
                    mysqli_field_seek($result5,0);
                    while ($field5 = mysqli_fetch_field($result5)){
                    } do { 
                    ?>
                  <tr>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $numero5;?></td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">                                        
                        <?php 
                        $fecha_s = explode('-',$row5[2]);
                        $fecha_reg = $fecha_s[2].'/'.$fecha_s[1].'/'.$fecha_s[0];
                        echo $fecha_reg; ?>
                    </td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;"><?php echo $row5[1];?></td>
                  </tr>
                  <?php
                    $numero5=$numero5+1;
                    }
                    while ($row5 = mysqli_fetch_array($result5));
                    } else {
                    }
                ?>
                </tbody>
              </table>
              <table width="601" border="1" cellspacing="0">
                <tbody>
                  <tr>
                    <td width="38" bgcolor="#503B92" style="font-family: Arial; font-size: 12px; color: #FEFEFE; text-align: center;"><strong>N° </strong></td>
                    <td width="114" bgcolor="#503B92" style="font-family: Arial; color: #FFFFFF; font-size: 12px; text-align: center;"><strong>FECHA DE VISITA </strong></td>
                    <td width="435" bgcolor="#503B92" style="text-align: center; font-family: Arial; font-size: 12px; color: #FFFFFF;">EVALUACIÓN DE LA FUNCIONALIDAD FAMILIAR</td>
                  </tr>
                <?php
                $numero_f=1;
                $sql_f =" SELECT fecha_registro FROM funcionalidad_familiar_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' GROUP BY fecha_registro ORDER BY fecha_registro";
                $result_f = mysqli_query($link,$sql_f);
                if ($row_f = mysqli_fetch_array($result_f)){
                mysqli_field_seek($result_f,0);
                while ($field_f = mysqli_fetch_field($result_f)){
                } do { 
                ?>
                  <tr>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $numero_f; ?></td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">
                    <?php 
                      $fecha_se = explode('-',$row_f[0]);
                      $fecha_seg = $fecha_se[2].'/'.$fecha_se[1].'/'.$fecha_se[0];
                      echo $fecha_seg; ?>
                    </td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">
                    <?php
                        $sql_ev =" SELECT funcionalidad_familiar_cf.idfuncionalidad_familiar_cf, funcionalidad_familiar.funcionalidad_familiar, funcionalidad_familiar_cf.fecha_registro ";
                        $sql_ev.=" FROM funcionalidad_familiar_cf, funcionalidad_familiar WHERE funcionalidad_familiar_cf.idfuncionalidad_familiar=funcionalidad_familiar.idfuncionalidad_familiar ";
                        $sql_ev.=" AND funcionalidad_familiar_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' AND funcionalidad_familiar.funcional='NO' AND funcionalidad_familiar_cf.fecha_registro='$row_f[0]' ";
                        $result_ev = mysqli_query($link,$sql_ev);
                        if ($row_ev = mysqli_fetch_array($result_ev)){

                            echo "DISFUNCIONAL";
                                
                            } else {

                                $sql_dev =" SELECT funcionalidad_familiar_cf.idfuncionalidad_familiar_cf, funcionalidad_familiar.funcionalidad_familiar, funcionalidad_familiar_cf.fecha_registro ";
                                $sql_dev.=" FROM funcionalidad_familiar_cf, funcionalidad_familiar WHERE funcionalidad_familiar_cf.idfuncionalidad_familiar=funcionalidad_familiar.idfuncionalidad_familiar ";
                                $sql_dev.=" AND funcionalidad_familiar_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' AND funcionalidad_familiar.funcional='SI' AND funcionalidad_familiar_cf.fecha_registro='$row_f[0]' ";
                                $result_dev = mysqli_query($link,$sql_dev);
                                if ($row_dev = mysqli_fetch_array($result_dev)){
                                    echo "FUNCIONAL";
                                } else {
                                    echo " <h6> SIN EVALUAR  </h6>";
                                }                                
                            }                                
                    ?>
                    </td>
                  </tr>
                <?php
                $numero_f=$numero_f+1;
                }
                while ($row_f = mysqli_fetch_array($result_f));
                } else {
                }
                ?>
                </tbody>
              </table></td>
            <td width="589">
              <table width="601" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td width="38" bgcolor="#503B92" style="font-family: Arial; font-size: 12px; color: #FEFEFE; text-align: center;"><strong>N° </strong></td>
                  <td width="115" bgcolor="#503B92" style="font-family: Arial; color: #FFFFFF; font-size: 12px; text-align: center;"><strong>FECHA DE VISITA </strong></td>
                  <td colspan="2" bgcolor="#503B92" style="text-align: center; font-family: Arial; font-size: 12px; color: #FFFFFF;">XVII. RESULTADO DE LA EVALUACION DE LA SALUD FAMILIAR</td>
                </tr>
                <?php
                  $numero5=1;
                  $sql5 =" SELECT idevaluacion_salud_familiar_cf, evaluacion_salud_familiar_cf, fecha_registro, idcarpeta_familiar ";
                  $sql5.=" FROM evaluacion_salud_familiar_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                  $result5 = mysqli_query($link,$sql5);
                  if ($row5 = mysqli_fetch_array($result5)){
                  mysqli_field_seek($result5,0);
                  while ($field5 = mysqli_fetch_field($result5)){
                  } do { 
                ?>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $numero5;?></td>
                  <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">                                        
                    <?php 
                    $fecha_s = explode('-',$row5[2]);
                    $fecha_reg = $fecha_s[2].'/'.$fecha_s[1].'/'.$fecha_s[0];
                    echo $fecha_reg; ?></td>
                  <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;"><?php echo $row5[1];?></td>
                </tr>
                <?php
                  $numero5=$numero5+1;
                  }
                  while ($row5 = mysqli_fetch_array($result5));
                  } else {
                  }
                ?>
              </tbody>
            </table>
              <table width="601" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td width="38" bgcolor="#503B92" style="font-family: Arial; font-size: 12px; color: #FEFEFE; text-align: center;"><strong>N° </strong></td>
                  <td width="114" bgcolor="#503B92" style="font-family: Arial; color: #FFFFFF; font-size: 12px; text-align: center;"><strong>FECHA DE VISITA </strong></td>
                  <td width="435" bgcolor="#503B92" style="text-align: center; font-family: Arial; font-size: 12px; color: #FFFFFF;">XVIII. FORMA DE AYUDA FAMILIAR NECESARIA</td>
                </tr>
                <?php
                  $numero=1;
                  $sql4 =" SELECT ayuda_familiar_cf.idayuda_familiar_cf, ayuda_familiar.ayuda_familiar, ayuda_familiar_cf.fecha_registro FROM ayuda_familiar_cf, ayuda_familiar ";
                  $sql4.=" WHERE ayuda_familiar_cf.idayuda_familiar=ayuda_familiar.idayuda_familiar  ";
                  $sql4.=" AND ayuda_familiar_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                  $result4 = mysqli_query($link,$sql4);
                  if ($row4 = mysqli_fetch_array($result4)){
                  mysqli_field_seek($result4,0);
                  while ($field4 = mysqli_fetch_field($result4)){
                  } do { 
                  ?>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $numero;?></td>
                  <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">                                        
                    <?php 
                    $fecha_s = explode('-',$row4[2]);
                    $fecha_reg = $fecha_s[2].'/'.$fecha_s[1].'/'.$fecha_s[0];
                    echo $fecha_reg; ?>
                  </td>
                  <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;"><?php echo $row4[1];?></td>
                </tr>
                <?php
                  $numero=$numero+1;
                  }
                  while ($row4 = mysqli_fetch_array($result4));
                  } else {
                  }
              ?>
              </tbody>
            </table>
              <table width="601" border="1" cellspacing="0">
                <tbody>
                  <tr>
                    <td width="38" bgcolor="#503B92" style="font-family: Arial; font-size: 12px; color: #FEFEFE; text-align: center;"><strong>N° </strong></td>
                    <td width="114" bgcolor="#503B92" style="font-family: Arial; color: #FFFFFF; font-size: 12px; text-align: center;"><strong>FECHA DE VISITA </strong></td>
                    <td width="435" bgcolor="#503B92" style="text-align: center; font-family: Arial; font-size: 12px; color: #FFFFFF;">XIX. EVALUACIÓN DE SALUD FAMILIAR</td>
                  </tr>
                  <?php
                    $numero5=1;
                    $sql5 =" SELECT idevaluacion_familiar_cf, determinante_salud, salud_integrantes, funcionalidad_familiar, evaluacion_familiar, fecha_registro FROM evaluacion_familiar_cf ";
                    $sql5.=" WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                    $result5 = mysqli_query($link,$sql5);
                    if ($row5 = mysqli_fetch_array($result5)){
                    mysqli_field_seek($result5,0);
                    while ($field5 = mysqli_fetch_field($result5)){
                    } do { 
                    ?>
                  <tr>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $numero5;?></td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">                                        
                      <?php 
                      $fecha_s = explode('-',$row5[5]);
                      $fecha_reg = $fecha_s[2].'/'.$fecha_s[1].'/'.$fecha_s[0];
                      echo $fecha_reg; ?>
                    </td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row5[4];?></td>
                  </tr>
                  <?php
                    $numero5=$numero5+1;
                    }
                    while ($row5 = mysqli_fetch_array($result5));
                    } else {
                    }
                ?> 
                </tbody>
              </table></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><p style="font-family: Arial; font-size: 16px; text-align: center;"><strong style="font-family: Arial; color: #503B92;"></br> EVALUACIÓN CARPETA FAMILIAR </strong></p>
        <table width="601" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="142" bgcolor="#503B92" style="font-family: Arial; font-size: 12px; color: #FEFEFE; text-align: center;">EVALUACION DE LAS DETERMINANTES DE LA SALUD</td>
            <td width="149" bgcolor="#503B92" style="font-family: Arial; color: #FFFFFF; font-size: 12px; text-align: center;">EVALUACIÓN DE LA SALUD DE LOS INTEGRANTES DE LA FAMILIA</td>
            <td width="159" bgcolor="#503B92" style="text-align: center; font-family: Arial; font-size: 12px; color: #FFFFFF;">EVALUACIÓN DE LA FUNCIONALIDAD FAMILIAR</td>
            <td width="133" bgcolor="#503B92" style="text-align: center; font-family: Arial; font-size: 12px; color: #FFFFFF;">EVALUACIÓN FAMILIAR</td>
          </tr>
          <?php
                    $numero5=1;
                    $sql5 =" SELECT idevaluacion_familiar_cf, determinante_salud, salud_integrantes, funcionalidad_familiar, evaluacion_familiar, fecha_registro FROM evaluacion_familiar_cf ";
                    $sql5.=" WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ORDER BY idevaluacion_familiar_cf DESC LIMIT 1";
                    $result5 = mysqli_query($link,$sql5);
                    if ($row5 = mysqli_fetch_array($result5)){
                    mysqli_field_seek($result5,0);
                    while ($field5 = mysqli_fetch_field($result5)){
                    } do { 
                    ?>
          <tr>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row5[1];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row5[2];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row5[3];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row5[4];?></td>
          </tr>
          <?php
                    $numero5=$numero5+1;
                    }
                    while ($row5 = mysqli_fetch_array($result5));
                    } else {
                    }
                ?>
        </tbody>
      </table></td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
