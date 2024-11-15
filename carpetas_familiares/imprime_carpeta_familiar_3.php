<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		  = date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");

$idcarpeta_familiar_ss = $_GET['idcarpeta_familiar'];      
?>
<table width="1200" border="0" align="center">
  <tbody>
    <tr>
      <td width="454">&nbsp;</td>
      <td width="506" style="font-family: Arial; font-size: 24px; color: #503B92; text-align: center;"><strong>XI. DETERMINANTES DE LA SALUD</strong></td>
      <td width="326">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><table width="1200" border="0" cellspacing="0">
        <tbody>
          <tr>
            <td width="300" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: center;"><strong>SERVICIOS BÁSICOS</strong></td>
            <td width="300" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: center;"><strong>ESTRUCTURA DE LA VIVIENDA</strong></td>
            <td width="300" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: center;"><strong>FUNCIONALIDAD DE LA VIVIENDA</strong></td>
            <td width="300" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: center;"><strong>SALUD ALIMENTARIA</strong></td>
          </tr>
          <tr>
            <td><?php
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
                while ($row1 = mysqli_fetch_array($result1));
                } else {
                }
                ?>
              
              <table width="300" border="1" cellspacing="0">
                  <tbody>
                    <tr>
                      <td colspan="3" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: center;">(*) Riesgo de los  Servicios Básicos </td>
                    </tr>
                    <tr>
                      <td width="36" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">1</td>
                      <td width="44" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">7</td>
                      <td width="198" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">Sin Riesgo</td>
                    </tr>
                    <tr>
                      <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">2</td>
                      <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">8-11</td>
                      <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">Riesgo Leve</td>
                    </tr>
                    <tr>
                      <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">3</td>
                      <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">12-17</td>
                      <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">Riesgo Moderado</td>
                    </tr>
                    <tr>
                      <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">4</td>
                      <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">18-24</td>
                      <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">Riesgo Grave</td>
                    </tr>
                    <tr>
                      <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">5</td>
                      <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">25-35</td>
                      <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">Riesgo Muy Grave</td>
                    </tr>
                  </tbody>
              </table>
              <table width="300" border="1" cellspacing="0">
                <tbody>
                  <tr>
                    <td colspan="3" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: center;">(**)Riesgo  estructural de  la vivienda </td>
                  </tr>
                  <tr>
                    <td width="36" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">1</td>
                    <td width="44" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">16</td>
                    <td width="198" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">Sin Riesgo</td>
                  </tr>
                  <tr>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">2</td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">17-31</td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">Riesgo Leve</td>
                  </tr>
                  <tr>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">3</td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">32-41</td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">Riesgo Moderado</td>
                  </tr>
                  <tr>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">4</td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">42-56</td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">Riesgo Grave</td>
                  </tr>
                  <tr>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">5</td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">57-80</td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">Riesgo Muy Grave</td>
                  </tr>
                </tbody>
            </table></td>
            <td><?php
                $sql2 =" SELECT idcat_determinante_salud, cat_determinante_salud FROM cat_determinante_salud WHERE iddeterminante_salud = '2' ";
                $result2 = mysqli_query($link,$sql2);
                if ($row2 = mysqli_fetch_array($result2)){
                mysqli_field_seek($result2,0);
                while ($field2 = mysqli_fetch_field($result2)){
                } do { 
                ?>
              
              <table width="300" border="1" cellpadding="1" cellspacing="0">
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
                ?></td>
            <td><?php
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
              <table width="300" border="1" cellspacing="0">
                      <tbody>
                        <tr>
                          <td colspan="3" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: center;">(***) Riesgo  funcional de  la vivienda</td>
                        </tr>
                        <tr>
                          <td width="36" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">1</td>
                          <td width="44" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">3</td>
                          <td width="198" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">Sin Riesgo</td>
                        </tr>
                        <tr>
                          <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">2</td>
                          <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">4-5</td>
                          <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">Riesgo Leve</td>
                        </tr>
                        <tr>
                          <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">3</td>
                          <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">6-9</td>
                          <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">Riesgo Moderado</td>
                        </tr>
                        <tr>
                          <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">4</td>
                          <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">10-11</td>
                          <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">Riesgo Grave</td>
                        </tr>
                        <tr>
                          <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">5</td>
                          <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">12-15</td>
                          <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">Riesgo Muy Grave</td>
                        </tr>
                      </tbody>
            </table>
              <table width="300" border="1" cellspacing="0">
                <tbody>
                  <tr>
                    <td colspan="3" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: center;">(****) Riesgo de  la Seguridad  Alimentaria</td>
                  </tr>
                  <tr>
                    <td width="36" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">1</td>
                    <td width="44" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">7</td>
                    <td width="198" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">Sin Riesgo</td>
                  </tr>
                  <tr>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">2</td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">8-13</td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">Riesgo Leve</td>
                  </tr>
                  <tr>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">3</td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">14-21</td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">Riesgo Moderado</td>
                  </tr>
                  <tr>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">4</td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">22-30</td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">Riesgo Grave</td>
                  </tr>
                  <tr>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">5</td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">31-35</td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">Riesgo Muy Grave</td>
                  </tr>
                </tbody>
            </table>
              <table width="300" border="1" cellspacing="0">
                <tbody>
                  <tr>
                    <td colspan="2" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: center;">EVALUACIÓN DE LAS DETERMINANTES</td>
                  </tr>
                  <tr>
                    <td width="48" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">(*)</td>
                    <td width="242" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">

                    <?php  
                                    $sqla = "SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='1' ";
                                    $resulta = mysqli_query($link,$sqla);
                                    $rowa = mysqli_fetch_array($resulta);
                                    echo " = ".$rowa[0]." - ";

                                    $sumatoria = $rowa[0];
                                        if ($sumatoria <= 7 ) {
                                            echo "SIN RIESGO";
                                        } else {
                                            if ($sumatoria <= 11 ) {
                                                echo "RIESGO LEVE";
                                            } else {
                                                if ($sumatoria <= 17) {
                                                        echo "RIESGO MODERADO";
                                                } else {
                                                    if ($sumatoria <= 24) {
                                                            echo "RIESGO GRAVE";
                                                    } else { 
                                                        if ($sumatoria <= 35) {
                                                                echo "RIESGO MUY GRAVE";
                                                        } else {  } } } } }

                            ?>

                    </td>
                  </tr>
                  <tr>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">(**)</td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">
                    <?php  
                                    $sqlb = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='2' ";
                                    $resultb = mysqli_query($link,$sqlb);
                                    $rowb = mysqli_fetch_array($resultb);
                                    echo " => ".$rowb[0]." - ";

                                    $sumatoria = $rowb[0];
                                    if ($sumatoria <= 16 ) {
                                        echo "SIN RIESGO";
                                    } else {
                                        if ($sumatoria <= 31 ) {
                                            echo "RIESGO LEVE";
                                        } else {
                                            if ($sumatoria <= 41) {
                                                    echo "RIESGO MODERADO";
                                            } else {
                                                if ($sumatoria <= 56) {
                                                        echo "RIESGO GRAVE";
                                                } else { 
                                                    if ($sumatoria <= 80) {
                                                            echo "RIESGO MUY GRAVE";
                                                    } else {  } } } } }

                            ?>
                    </td>
                  </tr>
                  <tr>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">(***)</td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">
                    <?php  
                                    $sqlc = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='3' ";
                                    $resultc = mysqli_query($link,$sqlc);
                                    $rowc = mysqli_fetch_array($resultc);
                                    echo " => ".$rowc[0]." - ";

                                    $sumatoria = $rowc[0];
                                    if ($sumatoria <= 3) {
                                        echo "SIN RIESGO";
                                    } else {
                                        if ($sumatoria <= 5) {
                                            echo "RIESGO LEVE";
                                        } else {
                                            if ($sumatoria <= 9) {
                                                    echo "RIESGO MODERADO";
                                            } else {
                                                if ($sumatoria <= 11) {
                                                        echo "RIESGO GRAVE";
                                                } else { 
                                                    if ($sumatoria <= 15) {
                                                            echo "RIESGO MUY GRAVE";
                                                    } else {  } } } } }

                            ?>
                    </td>
                  </tr>
                  <tr>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">(****)</td>
                    <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">
                    <?php  
                                    $sqld = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='4' AND idcat_determinante_salud='19' ";
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

                                    $sqlcon = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='4' AND idcat_determinante_salud='21' ";
                                    $resultcon = mysqli_query($link,$sqlcon);
                                    $rowcon = mysqli_fetch_array($resultcon);
                                    $consumo = $rowcon[0];

                                    $alimentaria = $grado_alimentario + $consumo;

                                    echo " => ".$alimentaria." - ";

                                    if ($alimentaria <= 7) {
                                        echo "SIN RIESGO";
                                    } else {
                                        if ($alimentaria <= 13) {
                                            echo "RIESGO LEVE";
                                        } else {
                                            if ($alimentaria <= 21) {
                                                    echo "RIESGO MODERADO";
                                            } else {
                                                if ($alimentaria <= 30) {
                                                        echo "RIESGO GRAVE";
                                                } else { 
                                                    if ($alimentaria <= 35) {
                                                            echo "RIESGO MUY GRAVE";
                                                    } else {  } } } } }

                            ?>
                    </td>
                  </tr>
                </tbody>
            </table>
              <table width="300" border="1" cellspacing="0">
                    <tbody>
                      <tr>
                        <td colspan="2" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: center;"> RIESGO TOTAL DE LAS DETERMINANTES DE LA SALUD FAMILIAR</td>
                      </tr>
                      <tr>
                        <td width="74" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">TOTAL</td>
                        <td width="216" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><span style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;">
                          <?php 
                                    $riesgo_total = $rowa[0] + $rowb[0] + $rowc[0] + $alimentaria;


                                  if ($riesgo_total <= 33) {
                                    echo " = ".$riesgo_total." .- SIN RIESGO";
                                } else {
                                    if ($riesgo_total <= 60) {
                                        echo " = ".$riesgo_total." .- RIESGO LEVE";
                                    } else {
                                        if ($riesgo_total <= 88) {
                                                echo " = ".$riesgo_total." .- RIESGO MODERADO";
                                        } else {
                                            if ($riesgo_total <= 121) {
                                                    echo " = ".$riesgo_total." .- RIESGO GRAVE";
                                            } else { 
                                                if ($riesgo_total <= 165) {
                                                        echo " = ".$riesgo_total." .- RIESGO MUY GRAVE";
                                                } else {  } } } } }                              
                                ?></span></td>
                      </tr>
                </tbody>
              </table></td>
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
    $sql_seg = " SELECT sum(valor_cf) FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='4' AND idcat_determinante_salud='19' ";
    $result_seg = mysqli_query($link,$sql_seg);
    $row_seg = mysqli_fetch_array($result_seg);
    $seguridad = $row_seg[0];

    if ($seguridad == '0') {
        echo "1. Seguridad Alimentaria";
    } else {
        if ($seguridad <= 3) {
            echo "2. Inseguridad Alimentaria Leve";
        } else {
            if ($seguridad <= 5) {
                    echo "3. Inseguridad Alimentaria Moderada";
            } else {
                if ($seguridad >= 6) {
                        echo "4. Inseguridad Alimentaria Severa";
                } else {  } } } }
?>
                    </td>
                      <td width="38" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;">
                      <?php
                        $sqld = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='4' AND idcat_determinante_salud='19' ";
                        $resultd = mysqli_query($link,$sqld);
                        $rowd = mysqli_fetch_array($resultd);
                        $durante = $rowd[0];

                        if ($durante == '0' || $durante == '') {
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

        <table width="1200" border="0">
          <tbody>
            <tr>
              <td width="163">&nbsp;</td>
              <td width="435">
                <table width="427" border="1" cellspacing="0">
                <tbody>
                  <tr>
                    <td colspan="2" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: left;">XII CARACTERÍSTICAS SOCIOECONÓMICAS</td>
                  </tr>
                  <?php
                    $numero=1;
                    $sql4 =" SELECT socio_economica_cf.idsocio_economica_cf, socio_economica.socio_economica, socio_economica_cf.valor ";
                    $sql4.=" FROM socio_economica, socio_economica_cf WHERE socio_economica_cf.idsocio_economica=socio_economica.idsocio_economica ";
                    $sql4.=" AND socio_economica_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                    $result4 = mysqli_query($link,$sql4);
                    if ($row4 = mysqli_fetch_array($result4)){
                    mysqli_field_seek($result4,0);
                    while ($field4 = mysqli_fetch_field($result4)){
                    } do { 
                    ?>
                  <tr>
                    
                    <td width="380" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;"><?php echo $row4[1];?></td>
                    <td width="44" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row4[2];?></td>
                  </tr>
                  <?php
                    $numero=$numero+1;
                    }
                    while ($row4 = mysqli_fetch_array($result4));
                    } else {
                    }
                ?>
                </tbody>
              </table></td>
              <td width="446"><table width="447" border="1" cellspacing="0">
                <tbody>
                  <tr>
                    <td colspan="2" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: left;">XIII. TENENCIA DE ANIMALES  DOMÉSTICOS DE COMPAÑÍA</td>
                  </tr>
                  <?php
                  $numero=1;
                  $sql4 =" SELECT tenencia_animales_cf.idtenencia_animales_cf, tenencia_animales.tenencia_animales, tenencia_animales_cf.valor  ";
                  $sql4.=" FROM tenencia_animales_cf, tenencia_animales WHERE tenencia_animales_cf.idtenencia_animales=tenencia_animales.idtenencia_animales ";
                  $sql4.=" AND tenencia_animales_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                  $result4 = mysqli_query($link,$sql4);
                  if ($row4 = mysqli_fetch_array($result4)){
                  mysqli_field_seek($result4,0);
                  while ($field4 = mysqli_fetch_field($result4)){
                  } do { 
                  ?>
                  <tr>
                    <td width="368" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;"><?php echo $row4[1];?></td>
                    <td width="38" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row4[2];?></td>
                  </tr>
                  <?php
                      $numero=$numero+1;
                      }
                      while ($row4 = mysqli_fetch_array($result4));
                      } else {
                      }
                  ?>
                </tbody>
              </table></td>
              <td width="138">&nbsp;</td>
            </tr>
          </tbody>
        </table>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
      