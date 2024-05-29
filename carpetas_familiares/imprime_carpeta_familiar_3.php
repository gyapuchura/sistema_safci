<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		  = date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");
$idcarpeta_familiar_ss = '2';       
?>
<table width="1200" border="0" align="center">
  <tbody>
    <tr>
      <td width="454">&nbsp;</td>
      <td width="506" style="font-family: Arial; font-size: 24px; color: #503B92; text-align: center;"><strong>XI. DETERMINANTES DE LA SALUD</strong></td>
      <td width="326">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><table width="1200" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="300" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: center;"><strong>SERVICIOS BÁSICOS</strong></td>
            <td width="300" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: center;"><strong>ESTRUCTURA DE LA VIVIENDA</strong></td>
            <td width="300" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: center;"><strong>FUNCIONALIDAD DE LA VIVIENDA</strong></td>
            <td width="300" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: center;"><strong>SALUD ALIMENTARIA</strong></td>
          </tr>
          <tr>
            <td>
            <?php
                $sql1 =" SELECT idcat_determinante_salud, cat_determinante_salud FROM cat_determinante_salud WHERE iddeterminante_salud = '1' ";
                $result1 = mysqli_query($link,$sql1);
                if ($row1 = mysqli_fetch_array($result1)){
                mysqli_field_seek($result1,0);
                while ($field1 = mysqli_fetch_field($result1)){
                } do { 
                ?>
              
              <table width="300" border="1" cellspacing="0">
                <tbody>
                <tr>
                  <td colspan="2" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: left;"><?php echo $row1[1];?></td>
                </tr>
                <?php
                    $sql5 =" SELECT item_determinante_salud.item_determinante_salud, determinante_salud_cf.valor_cf FROM determinante_salud_cf, item_determinante_salud ";
                    $sql5.=" WHERE determinante_salud_cf.iditem_determinante_salud=item_determinante_salud.iditem_determinante_salud ";
                    $sql5.=" AND determinante_salud_cf.iddeterminante_salud='1' AND determinante_salud_cf.idcat_determinante_salud='$row1[0]' ";
                    $sql5.="  AND determinante_salud_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                    $result5 = mysqli_query($link,$sql5);
                    if ($row5 = mysqli_fetch_array($result5)){
                    mysqli_field_seek($result5,0);
                    while ($field5 = mysqli_fetch_field($result5)){
                    } do { 
                    ?>
                    <tr>
                      <td width="246" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;"><?php echo $row5[0];?></td>
                      <td width="38" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row5[1];?></td>
                    </tr>                           
                    <?php
                    }
                    while ($row5 = mysqli_fetch_array($result5));
                    } else {
                    }
                ?>
                </tbody>
              </table>
                                         
                <?php
                }
                while ($row1 = mysqli_fetch_array($result1));
                } else {
                }
                ?>

            </td>
            <td>
            <?php
                $sql2 =" SELECT idcat_determinante_salud, cat_determinante_salud FROM cat_determinante_salud WHERE iddeterminante_salud = '2' ";
                $result2 = mysqli_query($link,$sql2);
                if ($row2 = mysqli_fetch_array($result2)){
                mysqli_field_seek($result2,0);
                while ($field2 = mysqli_fetch_field($result2)){
                } do { 
                ?>
              
              <table width="300" border="1" cellspacing="0">
                <tbody>
                <tr>
                  <td colspan="2" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: left;"><?php echo $row2[1];?></td>
                </tr>
                <?php
                    $sql5 =" SELECT item_determinante_salud.item_determinante_salud, determinante_salud_cf.valor_cf FROM determinante_salud_cf, item_determinante_salud ";
                    $sql5.=" WHERE determinante_salud_cf.iditem_determinante_salud=item_determinante_salud.iditem_determinante_salud ";
                    $sql5.=" AND determinante_salud_cf.iddeterminante_salud='2' AND determinante_salud_cf.idcat_determinante_salud='$row2[0]' ";
                    $sql5.=" AND determinante_salud_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                    $result5 = mysqli_query($link,$sql5);
                    if ($row5 = mysqli_fetch_array($result5)){
                    mysqli_field_seek($result5,0);
                    while ($field5 = mysqli_fetch_field($result5)){
                    } do { 
                    ?>
                    <tr>
                      <td width="246" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;"><?php echo $row5[0];?></td>
                      <td width="38" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row5[1];?></td>
                    </tr>                           
                    <?php
                    }
                    while ($row5 = mysqli_fetch_array($result5));
                    } else {
                    }
                ?>
                </tbody>
              </table>
                                         
                <?php
                }
                while ($row2 = mysqli_fetch_array($result2));
                } else {
                }
                ?>
            </td>
            <td>
            <?php
                $sql3 =" SELECT idcat_determinante_salud, cat_determinante_salud FROM cat_determinante_salud WHERE iddeterminante_salud = '3' ";
                $result3 = mysqli_query($link,$sql3);
                if ($row3 = mysqli_fetch_array($result3)){
                mysqli_field_seek($result3,0);
                while ($field3 = mysqli_fetch_field($result3)){
                } do { 
                ?>
              
              <table width="300" border="1" cellspacing="0">
                <tbody>
                <tr>
                  <td colspan="2" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: left;"><?php echo $row3[1];?></td>
                </tr>
                <?php
                    $sql5 =" SELECT item_determinante_salud.item_determinante_salud, determinante_salud_cf.valor_cf FROM determinante_salud_cf, item_determinante_salud ";
                    $sql5.=" WHERE determinante_salud_cf.iditem_determinante_salud=item_determinante_salud.iditem_determinante_salud ";
                    $sql5.=" AND determinante_salud_cf.iddeterminante_salud='3' AND determinante_salud_cf.idcat_determinante_salud='$row3[0]' ";
                    $sql5.=" AND determinante_salud_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                    $result5 = mysqli_query($link,$sql5);
                    if ($row5 = mysqli_fetch_array($result5)){
                    mysqli_field_seek($result5,0);
                    while ($field5 = mysqli_fetch_field($result5)){
                    } do { 
                    ?>
                    <tr>
                      <td width="246" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;"><?php echo $row5[0];?></td>
                      <td width="38" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row5[1];?></td>
                    </tr>                           
                    <?php
                    }
                    while ($row5 = mysqli_fetch_array($result5));
                    } else {
                    }
                ?>
                </tbody>
              </table>

                    <?php
                    }
                    while ($row3 = mysqli_fetch_array($result3));
                    } else {
                    }
                    ?>
            </td>
            <td>
            <?php
                $sql4 =" SELECT idcat_determinante_salud, cat_determinante_salud FROM cat_determinante_salud WHERE iddeterminante_salud = '4' ";
                $result4 = mysqli_query($link,$sql4);
                if ($row4 = mysqli_fetch_array($result4)){
                mysqli_field_seek($result4,0);
                while ($field4 = mysqli_fetch_field($result4)){
                } do { 

                  if ($row4[0] == '20') { ?>

                  <table width="300" border="1" cellspacing="0">
                    <tbody>
                    <tr>
                      <td colspan="2" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: left;">a) Grados de la Seguridad Alimentaria</td>
                    </tr>
                    <tr>
                      <td width="246" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">
                      <?php  
    $sql_seg = " SELECT sum(valor_cf) FROM determinante_salud_cf WHERE idcarpeta_familiar='2' AND iddeterminante_salud='4' AND idcat_determinante_salud='19' ";
    $result_seg = mysqli_query($link,$sql_seg);
    $row_seg = mysqli_fetch_array($result_seg);
    $seguridad = $row_seg[0];

    if ($seguridad == '0') {
        $sql5 = " SELECT iditem_determinante_salud, item_determinante_salud FROM item_determinante_salud WHERE idcat_determinante_salud='20' AND iditem_determinante_salud='103'  ";
        $result5 = mysqli_query($link,$sql5);
        $row5 = mysqli_fetch_array($result5);
        echo $row5[1];
    } else {
        if ($seguridad <= 3) {
            $sql6 = " SELECT iditem_determinante_salud, item_determinante_salud FROM item_determinante_salud WHERE idcat_determinante_salud='20' AND iditem_determinante_salud='104' ";
            $result6 = mysqli_query($link,$sql6);
            $row6 = mysqli_fetch_array($result6);
            echo $row6[1];
        } else {
            if ($seguridad <= 5) {
                    $sql7 = " SELECT iditem_determinante_salud, item_determinante_salud FROM item_determinante_salud WHERE idcat_determinante_salud='20' AND iditem_determinante_salud='105' ";
                    $result7 = mysqli_query($link,$sql7);
                    $row7 = mysqli_fetch_array($result7);
                    echo $row7[1];
            } else {
                if ($seguridad >= 6) {
                        $sql8 = " SELECT iditem_determinante_salud, item_determinante_salud FROM item_determinante_salud WHERE idcat_determinante_salud='20' AND iditem_determinante_salud='106' ";
                        $result8 = mysqli_query($link,$sql8);
                        $row8 = mysqli_fetch_array($result8);
                        echo $row8[1];
                } else {  } } } }
?>
                    </td>
                      <td width="38" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">
                      <?php
                        $sqld = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='2' AND iddeterminante_salud='4' AND idcat_determinante_salud='19' ";
                        $resultd = mysqli_query($link,$sqld);
                        $rowd = mysqli_fetch_array($resultd);
                        $durante = $rowd[0];

                        if ($durante == '0') {
                            $grado_alimentario = '1';
                        } else {
                            if ($durante <= 3) {
                                $grado_alimentario = '3';
                            } else {
                                if ($durante <= 5) {
                                    $grado_alimentario = '4';
                                } else {
                                    if ($durante >= 6) {
                                        $grado_alimentario = '5';
                                    } else {  } } } }

                                    echo $grado_alimentario;
                    ?>
                    </td>
                    </tr>                           
                    </tbody>
                  </table>

                    
               <?php } else { ?> 

              <table width="300" border="1" cellspacing="0">
                <tbody>
                <tr>
                  <td colspan="2" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: left;"><?php echo $row4[1];?></td>
                </tr>
                <?php
                    $sql5 =" SELECT item_determinante_salud.item_determinante_salud, determinante_salud_cf.valor_cf FROM determinante_salud_cf, item_determinante_salud ";
                    $sql5.=" WHERE determinante_salud_cf.iditem_determinante_salud=item_determinante_salud.iditem_determinante_salud ";
                    $sql5.=" AND determinante_salud_cf.iddeterminante_salud='4' AND determinante_salud_cf.idcat_determinante_salud='$row4[0]' ";
                    $sql5.=" AND determinante_salud_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                    $result5 = mysqli_query($link,$sql5);
                    if ($row5 = mysqli_fetch_array($result5)){
                    mysqli_field_seek($result5,0);
                    while ($field5 = mysqli_fetch_field($result5)){
                    } do { 
                    ?>
                    <tr>
                      <td width="246" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;"><?php echo $row5[0];?></td>
                      <td width="38" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row5[1];?></td>
                    </tr>                           
                    <?php
                    }
                    while ($row5 = mysqli_fetch_array($result5));
                    } else {
                    }
                ?>
                </tbody>
              </table>
                                        
                <?php              
                }
              
              } 
                while ($row4 = mysqli_fetch_array($result4));
                } else {
                }
                ?>
    
    </td>
    </tr>
  </tbody>
</table>
