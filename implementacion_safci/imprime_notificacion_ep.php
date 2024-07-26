<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idnotificacion_ep = $_GET['idnotificacion_ep'];

$sql =" SELECT notificacion_ep.idnotificacion_ep, notificacion_ep.codigo, departamento.departamento, red_salud.red_salud,  ";
$sql.=" municipios.municipio, establecimiento_salud.establecimiento_salud, notificacion_ep.semana_ep, ";
$sql.=" notificacion_ep.fecha_registro, notificacion_ep.hora_registro, nombre.nombre, nombre.paterno, nombre.materno, ";
$sql.=" notificacion_ep.iddepartamento, notificacion_ep.idred_salud, notificacion_ep.idmunicipio, notificacion_ep.idestablecimiento_salud, notificacion_ep.gestion ";
$sql.=" FROM notificacion_ep, departamento, red_salud, municipios, establecimiento_salud, usuarios, nombre ";
$sql.=" WHERE notificacion_ep.iddepartamento=departamento.iddepartamento AND notificacion_ep.idred_salud=red_salud.idred_salud ";
$sql.=" AND notificacion_ep.idmunicipio=municipios.idmunicipio AND notificacion_ep.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
$sql.=" AND notificacion_ep.idusuario=usuarios.idusuario AND usuarios.idnombre=nombre.idnombre AND notificacion_ep.idnotificacion_ep='$idnotificacion_ep ' ";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);

?>

<table width="1200" border="0" align="center">
  <tbody>
    <tr>
      <td width="144"><p style="text-align: center"><img src="logo_safci_doc.png" width="141" height="97" alt=""/></p></td>
      <td width="694" style="font-family: Arial; font-style: normal; font-weight: normal; font-size: 14px; text-align: center;"><p>NOTIFICACIÓN PARA LA VIGILANCIA EPIDEMIOLÓGICA</p>
      <p>CÓDIGO: <?php echo $row[1];?></p></td>
      <td width="418" style="font-family: Arial; font-size: 10px;"><p>Semana Epidemiológica N° <?php echo $row[6]; ?></p>
      <p>CAMBIE DE FORMULARIO EL DIA DOMINGO DE CADA SEMANA</p></td>
    </tr>
    <tr>
      <td colspan="3"><table width="1264" border="0">
        <tbody>
          <tr>
            <td width="438" style="font-size: 10px">SEDES: <?php echo $row[2];?></td>
            <td width="72">&nbsp;</td>
            <td width="251" style="font-size: 10px; font-family: Arial;">Red de Salud: <?php echo $row[3];?></td>
            <td width="71">&nbsp;</td>
            <td width="349" style="font-size: 10px; font-family: Arial;">Municipio: <?php echo $row[4];?></td>
            <td width="57">&nbsp;</td>
          </tr>
          <tr>
            <td style="font-size: 10px; font-family: Arial;">Establecimiento: <?php echo $row[5];?></td>
            <td>&nbsp;</td>
            <td><p style="font-size: 10px; font-family: Arial;">Año: <?php echo $row[16];?></p></td>
            <td>&nbsp;</td>
            <td style="font-size: 10px; font-family: Arial;">Subsector:</td>
            <td>&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td style="font-size: 10px; font-family: Arial; text-align: left;">&nbsp;</td>
      <td style="font-size: 10px; font-family: Arial; text-align: left;">Los datos siguientes deben ser consolidados semanalmente por la enfermera o el médico y certificados por el Médico Director.</td>
      <td style="font-size: 10px; font-family: Arial; text-align: left;">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" style="text-align: center">&nbsp;</td>
    </tr>




<!----------- SE GENERA LA TABLA DE GRUPOS ETAREOS POR ENFERMEDAD -------->
    <tr>
      <td colspan="3" style="text-align: center; font-family: Arial; font-size: 12px;">REGISTRO DE ENFERMEDADES DE NOTIFICACIÓN INMEDIATA</td>
    </tr>
    <tr>
      <td colspan="3"><table width="1188" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="104" rowspan="2" style="font-size: 10px; font-family: Arial;">Sospecha Diagnóstica</td>
            <?php
                $sql4 =" SELECT idgrupo_etareo, grupo_etareo FROM grupo_etareo ORDER BY idgrupo_etareo ";
                $result4 = mysqli_query($link,$sql4);
                if ($row4 = mysqli_fetch_array($result4)){
                mysqli_field_seek($result4,0);
                while ($field4 = mysqli_fetch_field($result4)){
                } do { 
              ?>
            <td width="104" colspan="2" style="font-size: 10px; font-family: Arial; text-align: center;"><?php echo $row4[1]; ?></td>
            <?php
                }
                while ($row4 = mysqli_fetch_array($result4));
                } else {
                }
            ?>
          </tr>
          <tr>
            <?php
                $sql5 =" SELECT idgrupo_etareo, grupo_etareo FROM grupo_etareo ORDER BY idgrupo_etareo ";
                $result5 = mysqli_query($link,$sql5);
                if ($row5 = mysqli_fetch_array($result5)){
                mysqli_field_seek($result5,0);
                while ($field5 = mysqli_fetch_field($result5)){
                } do { 
              ?>
            <?php
                $sql6 =" SELECT idgenero, genero FROM genero ORDER BY idgenero ";
                $result6 = mysqli_query($link,$sql6);
                if ($row6 = mysqli_fetch_array($result6)){
                mysqli_field_seek($result6,0);
                while ($field6 = mysqli_fetch_field($result6)){
                } do { 
              ?>
            <td style="font-size: 7px; font-family: Arial; text-align: center;"><?php echo $row6[1]; ?></td>
            <?php
                }
                while ($row6 = mysqli_fetch_array($result6));
                } else {
                }
            ?>
            <?php
                }
                while ($row5 = mysqli_fetch_array($result5));
                } else {
                }
            ?>
          </tr>
          <?php
            $sql7 =" SELECT registro_enfermedad.idsospecha_diag, sospecha_diag.sospecha_diag FROM registro_enfermedad, sospecha_diag ";
            $sql7.=" WHERE registro_enfermedad.idsospecha_diag=sospecha_diag.idsospecha_diag AND sospecha_diag.idcat_registro='1' AND ";
            $sql7.=" registro_enfermedad.idnotificacion_ep = '$idnotificacion_ep' GROUP BY registro_enfermedad.idsospecha_diag ";
            $result7 = mysqli_query($link,$sql7);
            if ($row7 = mysqli_fetch_array($result7)){
            mysqli_field_seek($result7,0);
            while ($field7 = mysqli_fetch_field($result7)){
            } do { 
            ?>
          <tr>
            <td width="104"  style="font-size: 10px; font-family: Arial;"><?php echo $row7[1];?></td>
            <?php
                  $sql8 =" SELECT registro_enfermedad.idregistro_enfermedad, grupo_etareo.grupo_etareo, genero.genero, registro_enfermedad.cifra, registro_enfermedad.idgenero ";
                  $sql8.=" FROM registro_enfermedad, grupo_etareo, genero WHERE registro_enfermedad.idgrupo_etareo=grupo_etareo.idgrupo_etareo ";
                  $sql8.=" AND registro_enfermedad.idgenero=genero.idgenero AND registro_enfermedad.idnotificacion_ep='$idnotificacion_ep' ";
                  $sql8.=" AND registro_enfermedad.idsospecha_diag='$row7[0]' ORDER BY registro_enfermedad.idregistro_enfermedad ";
                  $result8 = mysqli_query($link,$sql8);
                  if ($row8 = mysqli_fetch_array($result8)){
                  mysqli_field_seek($result8,0);
                  while ($field8 = mysqli_fetch_field($result8)){
                  } do { 
              ?>
            <td style="font-size: 10px; font-family: Arial; text-align: center;"><?php echo $row8[3];?></td>
            <?php
                  }
                  while ($row8 = mysqli_fetch_array($result8));
                  } else {
                  }
              ?>
          </tr>
          <?php
              }
              while ($row7 = mysqli_fetch_array($result7));
              } else {
              }
          ?>
        </tbody>
      </table></td>
    </tr>

    <tr>
      <td colspan="3" style="text-align: center; font-family: Arial; font-size: 12px;">REGISTRO DE EVENTOS DE NOTIFICACIÓN INMEDIATA</span></td>
    </tr>
    <tr>
      <td colspan="3"><table width="1210" border="0">
        <tbody>
          <tr>
            <td width="600"><table width="535" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td width="17" style="font-family: Arial; font-size: 10px; text-align: center;">N°</td>
                  <td width="118" style="font-family: Arial; font-size: 10px; text-align: center;">Evento</td>
                  <td width="83" style="font-size: 10px; font-family: Arial; text-align: center;">N* de Eventos</td>
                  <td width="89" style="font-family: Arial; font-size: 10px; text-align: center;">No. de personas atendidas</td>
                  <td width="98" style="font-family: Arial; font-size: 10px; text-align: center;">No. de personas afectadas</td>
                  <td width="104" style="font-family: Arial; font-size: 10px; text-align: center;">No. de personas fallecidas</td>
                </tr>
                <?php
                        $numero9=1;
                        $sql9 =" SELECT registro_evento_notificacion.idregistro_evento_notificacion, evento_notificacion.evento_notificacion, ";
                        $sql9.=" registro_evento_notificacion.numero_eventos, registro_evento_notificacion.personas_atendidas, registro_evento_notificacion.personas_afectadas, registro_evento_notificacion.personas_fallecidas ";
                        $sql9.=" FROM registro_evento_notificacion, evento_notificacion WHERE registro_evento_notificacion.idevento_notificacion=evento_notificacion.idevento_notificacion ";
                        $sql9.=" AND registro_evento_notificacion.idnotificacion_ep='$idnotificacion_ep' AND evento_notificacion.columna='L' ORDER BY registro_evento_notificacion.idregistro_evento_notificacion ";
                        $result9 = mysqli_query($link,$sql9);
                        if ($row9 = mysqli_fetch_array($result9)){
                        mysqli_field_seek($result9,0);
                        while ($field9 = mysqli_fetch_field($result9)){
                        } do { 
                        ?>
                <tr>
                  <td style="font-size: 10px; font-family: Arial; text-align: center;"><?php echo $numero9;?></td>
                  <td style="font-size: 10px; font-family: Arial;"><?php echo $row9[1];?></td>
                  <td style="font-size: 10px; font-family: Arial; text-align: center;"><?php echo $row9[2];?></td>
                  <td style="font-size: 10px; font-family: Arial; text-align: center;"><?php echo $row9[3];?></td>
                  <td style="font-size: 10px; font-family: Arial; text-align: center;"><?php echo $row9[4];?></td>
                  <td style="font-size: 10px; font-family: Arial; text-align: center;"><?php echo $row9[5];?></td>
                </tr>
                <?php
                    $numero9=$numero9+1;
                    }
                    while ($row9 = mysqli_fetch_array($result9));
                    } else {
                    }
                ?>
              </tbody>
            </table></td>
            <td width="650"><table width="599" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td width="17" style="font-family: Arial; font-size: 10px; text-align: center;">N°</span></td>
                  <td width="152" style="font-family: Arial; font-size: 10px; text-align: center;">Evento</span></td>
                  <td width="106" style="font-size: 10px; font-family: Arial; text-align: center;">N* de Eventos</span></td>
                  <td width="98" style="font-family: Arial; font-size: 10px; text-align: center;">No. de personas atendidas</td>
                  <td width="100" style="font-family: Arial; font-size: 10px; text-align: center;">No. de personas afectadas</span></td>
                  <td width="106" style="font-family: Arial; font-size: 10px; text-align: center;">No. de personas fallecidass</td>
                </tr>
                <?php
                    $numeror=4;
                    $sqlr =" SELECT registro_evento_notificacion.idregistro_evento_notificacion, evento_notificacion.evento_notificacion, ";
                    $sqlr.=" registro_evento_notificacion.numero_eventos, registro_evento_notificacion.personas_atendidas, registro_evento_notificacion.personas_afectadas, registro_evento_notificacion.personas_fallecidas ";
                    $sqlr.=" FROM registro_evento_notificacion, evento_notificacion WHERE registro_evento_notificacion.idevento_notificacion=evento_notificacion.idevento_notificacion ";
                    $sqlr.=" AND registro_evento_notificacion.idnotificacion_ep='$idnotificacion_ep' AND evento_notificacion.columna='R' ORDER BY registro_evento_notificacion.idregistro_evento_notificacion ";
                    $resultr = mysqli_query($link,$sqlr);
                    if ($rowr = mysqli_fetch_array($resultr)){
                    mysqli_field_seek($resultr,0);
                    while ($fieldr = mysqli_fetch_field($resultr)){
                    } do { 
                    ?>             
                <tr>
                  <td style="text-align: center; font-family: Arial; font-size: 10px;"><?php echo $numeror;?></td>
                  <td style="font-size: 10px; font-family: Arial;"><?php echo $rowr[1];?></td>
                  <td style="text-align: center; font-size: 10px; font-family: Arial;"><?php echo $rowr[2];?></td>
                  <td style="font-family: Arial; font-size: 10px; text-align: center;"><?php echo $rowr[3];?></td>
                  <td style="font-family: Arial; font-size: 10px; text-align: center;"><?php echo $rowr[4];?></td>
                  <td style="font-size: 10px; font-family: Arial; text-align: center;"><?php echo $rowr[5];?></td>
                </tr>
                <?php
                    $numeror=$numeror+1;
                    }
                    while ($rowr = mysqli_fetch_array($resultr));
                    } else {
                    }
                ?>
              </tbody>
            </table></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <?php
        $sql_sem =" SELECT cat_registro.idcat_registro, cat_registro.cat_registro FROM cat_registro, sospecha_diag, registro_enfermedad, notificacion_ep ";
        $sql_sem.=" WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND registro_enfermedad.idsospecha_diag=sospecha_diag.idsospecha_diag ";
        $sql_sem.=" AND sospecha_diag.idcat_registro=cat_registro.idcat_registro AND cat_registro.idcat_registro !='1' AND notificacion_ep.estado='CONSOLIDADO' ";
        $sql_sem.=" AND notificacion_ep.idnotificacion_ep='$idnotificacion_ep'  GROUP BY cat_registro.idcat_registro ORDER BY cat_registro.idcat_registro  ";
        $result_sem = mysqli_query($link,$sql_sem);
        if ($row_sem = mysqli_fetch_array($result_sem)){
    ?>
    <tr>
      <td colspan="3" style="text-align: center; font-family: Arial; font-size: 12px;">REGISTRO DE ENFERMEDADES DE NOTIFICACIÓN SEMANAL</td>
    </tr>
    <?php } else { } ?>
    
    <?php
        $sql_t =" SELECT cat_registro.idcat_registro, cat_registro.cat_registro FROM cat_registro, sospecha_diag, registro_enfermedad, notificacion_ep ";
        $sql_t.=" WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND registro_enfermedad.idsospecha_diag=sospecha_diag.idsospecha_diag ";
        $sql_t.=" AND sospecha_diag.idcat_registro=cat_registro.idcat_registro AND cat_registro.idcat_registro !='1' AND notificacion_ep.estado='CONSOLIDADO' ";
        $sql_t.=" AND notificacion_ep.idnotificacion_ep='$idnotificacion_ep'  GROUP BY cat_registro.idcat_registro ORDER BY cat_registro.idcat_registro  ";
        $result_t = mysqli_query($link,$sql_t);
        if ($row_t = mysqli_fetch_array($result_t)){
        mysqli_field_seek($result_t,0);
        while ($field_t = mysqli_fetch_field($result_t)){
        } do { 
    ?>

    <!------ DE CREA OTRA TABLA PARA CADA SECCION DEL FORMULARIO F302A ------->

    <tr>
      <td colspan="3"><table width="1188" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="104" rowspan="2" style="font-size: 10px; font-family: Arial;"><?php echo $row_t[1];?></td>
            <?php
                $sql4 =" SELECT idgrupo_etareo, grupo_etareo FROM grupo_etareo ORDER BY idgrupo_etareo ";
                $result4 = mysqli_query($link,$sql4);
                if ($row4 = mysqli_fetch_array($result4)){
                mysqli_field_seek($result4,0);
                while ($field4 = mysqli_fetch_field($result4)){
                } do { 
              ?>
            <td width="104" colspan="2" style="font-size: 10px; font-family: Arial; text-align: center;"><?php echo $row4[1]; ?></td>
            <?php
                }
                while ($row4 = mysqli_fetch_array($result4));
                } else {
                }
            ?>
          </tr>
          <tr>
            <?php
                $sql5 =" SELECT idgrupo_etareo, grupo_etareo FROM grupo_etareo ORDER BY idgrupo_etareo ";
                $result5 = mysqli_query($link,$sql5);
                if ($row5 = mysqli_fetch_array($result5)){
                mysqli_field_seek($result5,0);
                while ($field5 = mysqli_fetch_field($result5)){
                } do { 
              ?>
            <?php
                $sql6 =" SELECT idgenero, genero FROM genero ORDER BY idgenero ";
                $result6 = mysqli_query($link,$sql6);
                if ($row6 = mysqli_fetch_array($result6)){
                mysqli_field_seek($result6,0);
                while ($field6 = mysqli_fetch_field($result6)){
                } do { 
              ?>
            <td style="font-size: 7px; font-family: Arial; text-align: center;"><?php echo $row6[1]; ?></td>
            <?php
                }
                while ($row6 = mysqli_fetch_array($result6));
                } else {
                }
            ?>
            <?php
                }
                while ($row5 = mysqli_fetch_array($result5));
                } else {
                }
            ?>
          </tr>
          <?php
            $sql7 =" SELECT registro_enfermedad.idsospecha_diag, sospecha_diag.sospecha_diag FROM registro_enfermedad, sospecha_diag ";
            $sql7.=" WHERE registro_enfermedad.idsospecha_diag=sospecha_diag.idsospecha_diag AND sospecha_diag.idcat_registro='$row_t[0]' AND ";
            $sql7.=" registro_enfermedad.idnotificacion_ep = '$idnotificacion_ep' GROUP BY registro_enfermedad.idsospecha_diag ";
            $result7 = mysqli_query($link,$sql7);
            if ($row7 = mysqli_fetch_array($result7)){
            mysqli_field_seek($result7,0);
            while ($field7 = mysqli_fetch_field($result7)){
            } do { 
            ?>
          <tr>
            <td width="104"  style="font-size: 10px; font-family: Arial;"><?php echo $row7[1];?></td>
            <?php
                  $sql8 =" SELECT registro_enfermedad.idregistro_enfermedad, grupo_etareo.grupo_etareo, genero.genero, registro_enfermedad.cifra, registro_enfermedad.idgenero ";
                  $sql8.=" FROM registro_enfermedad, grupo_etareo, genero WHERE registro_enfermedad.idgrupo_etareo=grupo_etareo.idgrupo_etareo ";
                  $sql8.=" AND registro_enfermedad.idgenero=genero.idgenero AND registro_enfermedad.idnotificacion_ep='$idnotificacion_ep' ";
                  $sql8.=" AND registro_enfermedad.idsospecha_diag='$row7[0]' ORDER BY registro_enfermedad.idregistro_enfermedad ";
                  $result8 = mysqli_query($link,$sql8);
                  if ($row8 = mysqli_fetch_array($result8)){
                  mysqli_field_seek($result8,0);
                  while ($field8 = mysqli_fetch_field($result8)){
                  } do { 
              ?>
            <td style="font-size: 10px; font-family: Arial; text-align: center;"><?php echo $row8[3];?></td>
            <?php
                  }
                  while ($row8 = mysqli_fetch_array($result8));
                  } else {
                  }
              ?>
          </tr>

          <?php
              }
              while ($row7 = mysqli_fetch_array($result7));
              } else {
              }
          ?>
        </tbody>
      </table></td>
    </tr>
<!--    <tr>
        <td>&nbsp;</td>
        </tr>   -->

<!----- TABLA CREADA PARA LAS SECCIONES DEL F-302A END ----->
      <?php
          }
          while ($row_t = mysqli_fetch_array($result_t));
          } else {
          }
      ?>

    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><table width="1187" border="0">
        <tbody>
          <tr>
            <td width="196">
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

    include "phpqrcode.php";

    //capturamos el valor de "data"

    $separador='|';
    $tamano='M';

    $_REQUEST['data'] = 'https://virtual-safci.minsalud.gob.bo/medi-safci/implementacion_safci/imprime_notificacion_ep.php?idnotificacion_ep='.$idnotificacion_ep;
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
              <p style="text-align: center; font-size: 9px; font-family: Arial;"> Verificacion MEDI-SAFCI</p></td>
            <td width="245">&nbsp;</td>
            <td width="258">&nbsp;</td>
            <td width="236">&nbsp;</td>
            <td width="230">&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="3"><table width="777" border="0" align="center">
        <tbody>
          <tr>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">Yo: <?php echo mb_strtoupper($row[9]." ".$row[10]." ".$row[11]);?></td>
            <td>&nbsp;  </td>
            <td style="text-align: center">............................................................................</td>
          </tr>
          <tr>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">Declaro la veracidad de los datos del presente formulario</td>
            <td style="text-align: center; font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td style="text-align: center; font-size: 12px; font-family: Arial;">FIRMA</td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
  </tbody>
</table>
