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
                <tr>
                  <td width="246">&nbsp;</td>
                  <td width="38">&nbsp;</td>
                </tr>
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
                <tr>
                  <td width="246">&nbsp;</td>
                  <td width="38">&nbsp;</td>
                </tr>
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
                    $numero5=1;
                    $sql5 =" SELECT determinante_salud_cf.iddeterminante_salud_cf, determinante_salud.determinante_salud, cat_determinante_salud.cat_determinante_salud, ";
                    $sql5.=" item_determinante_salud.item_determinante_salud, determinante_salud_cf.valor_cf FROM determinante_salud_cf, determinante_salud, cat_determinante_salud, item_determinante_salud ";
                    $sql5.=" WHERE determinante_salud_cf.iddeterminante_salud=determinante_salud.iddeterminante_salud AND determinante_salud_cf.idcat_determinante_salud=cat_determinante_salud.idcat_determinante_salud AND ";
                    $sql5.=" determinante_salud_cf.iditem_determinante_salud=item_determinante_salud.iditem_determinante_salud AND determinante_salud_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                    $result5 = mysqli_query($link,$sql5);
                    if ($row5 = mysqli_fetch_array($result5)){
                    mysqli_field_seek($result5,0);
                    while ($field5 = mysqli_fetch_field($result5)){
                    } do { 
                    ?>
                    <tr>
                      <td width="246"><?php echo $row5[3];?></td>
                      <td width="38"><?php echo $row5[4];?></td>
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
                ?>
              
              <table width="300" border="1" cellspacing="0">
                <tbody>
                <tr>
                  <td colspan="2" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: left;"><?php echo $row4[1];?></td>
                </tr>
                <tr>
                  <td width="246">&nbsp;</td>
                  <td width="38">&nbsp;</td>
                </tr>
                </tbody>
              </table>
                                         
                <?php
                }
                while ($row4 = mysqli_fetch_array($result4));
                } else {
                }
                ?>
            </td>
          </tr>
        </tbody>
      </table></td>
    </tr>
  </tbody>
</table>
