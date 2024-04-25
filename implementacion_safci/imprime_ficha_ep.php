<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

$idficha_ep = $_GET['idficha_ep'];

$sql =" SELECT ficha_ep.codigo, notificacion_ep.codigo, sospecha_diag.sospecha_diag, departamento.departamento, red_salud.red_salud, municipios.municipio, ";
$sql.=" establecimiento_salud.establecimiento_salud, grupo_etareo.grupo_etareo, genero.genero, nombre.ci, nombre.nombre, ";
$sql.=" nombre.paterno, nombre.materno, nombre.fecha_nac, ficha_ep.celular, ficha_ep.direccion, ficha_ep.fecha_registro FROM ficha_ep, registro_enfermedad, notificacion_ep, ";
$sql.=" sospecha_diag, departamento, red_salud, municipios, establecimiento_salud, grupo_etareo, genero, nombre ";
$sql.=" WHERE ficha_ep.idregistro_enfermedad=registro_enfermedad.idregistro_enfermedad AND registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep ";
$sql.=" AND registro_enfermedad.idsospecha_diag=sospecha_diag.idsospecha_diag AND notificacion_ep.iddepartamento=departamento.iddepartamento ";
$sql.=" AND notificacion_ep.idmunicipio=municipios.idmunicipio AND notificacion_ep.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
$sql.=" AND registro_enfermedad.idgrupo_etareo=grupo_etareo.idgrupo_etareo AND registro_enfermedad.idgenero=genero.idgenero ";
$sql.=" AND establecimiento_salud.idred_salud=red_salud.idred_salud AND ficha_ep.idnombre=nombre.idnombre AND ficha_ep.idficha_ep='$idficha_ep' ";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);

?>
<table width="680" border="0" align="center">
  <tbody>
    <tr>
      <td width="177" style="text-align: center"><img src="logo_safci_doc.png" width="116" height="84" alt=""/></td>
      <td width="323" style="text-align: center; font-family: Arial; font-size: 16px;"><p>FICHA EPIDEMIOLÓGICA</p>
      <p>CÓDIGO : <?php echo $row[0];?></p></td>
      <td width="166">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><table width="680" border="0">
        <tbody>
          <tr>
            <td colspan="2" style="text-align: right; font-size: 12px; font-family: Arial;">N° NOTIFICACION:</td>
            <td colspan="2" style="font-family: Arial; font-size: 12px;"><?php echo $row[1];?></td>
            </tr>
          <tr>
            <td colspan="2" style="text-align: right; font-size: 12px; font-family: Arial;">REGISTRO EPIDEMIOLÓGICO:</td>
            <td colspan="2" style="font-size: 14px; font-family: Arial;"><?php echo $row[2];?></td>
          </tr>
          <tr>
            <td colspan="2" style="text-align: right; font-size: 12px; font-family: Arial;">FECHA DE REGISTRO </br>(FICHA EPIDEMIOLÓGICA):</td>
            <td colspan="2" style="font-size: 14px; font-family: Arial;">
            <?php 
                $fecha_r = explode('-',$row[16]);
                $fecha_reg = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];
                echo $fecha_reg; ?>
            </td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
          </tr>
          <tr>
            <td width="173" style="font-family: Arial; font-size: 12px; text-align: right;">DEPARTAMENTO:</td>
            <td width="156" style="font-family: Arial; font-size: 12px;"><?php echo $row[3];?></td>
            <td width="204" style="font-family: Arial; font-size: 12px; text-align: right;">RED DE SALUD:</td>
            <td width="129" style="font-family: Arial; font-size: 12px;"><?php echo $row[4];?></td>
          </tr>
          <tr>
            <td style="font-size: 12px; font-family: Arial; text-align: right;">MUNICIPIO:</td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[5];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: right;">ESTABLECIMIENTO DE SALUD:</td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[6];?></td>
          </tr>
          <tr>
            <td style="font-size: 12px; font-family: Arial; text-align: right;">GRUPO ETAREO DEL PACIENTE:</td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[7];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: right;">GÉNERO DEL PACIENTE:</td>
            <td style="font-size: 12px; font-family: Arial;"><?php echo $row[8];?></td>
          </tr>
        </tbody>
      </table></td>
    </tr>

    <tr>
      <td colspan="3"><table width="680" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td colspan="2" style="font-family: Arial; font-size: 12px; text-align: right;">CÉDULA DE IDENTIDAD (PACIENTE):</td>
            <td colspan="2" style="font-family: Arial; font-size: 12px;"><?php echo $row[9];?></td>
            </tr>
          <tr>
            <td width="168" style="font-family: Arial; font-size: 12px; text-align: right;">NOMBRES:</td>
            <td width="160" style="font-family: Arial; font-size: 12px;"><?php echo $row[10];?></td>
            <td width="168" style="font-family: Arial; font-size: 12px; text-align: right;">APELLIDOS:</td>
            <td width="166" style="font-size: 12px; font-family: Arial;"><?php echo $row[11];?> <?php echo $row[12];?></td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px; text-align: right;">FECHA DE NACIMIENTO:</td>
            <td style="font-size: 12px; font-family: Arial;">
            <?php 
                  $fecha_n = explode('-',$row[13]);
                  $fecha_nac = $fecha_n[2].'/'.$fecha_n[1].'/'.$fecha_n[0];
                  echo $fecha_nac; ?>
            </td>
            <td style="font-family: Arial; font-size: 12px; text-align: right;">N° DE CELULAR</td>
            <td style="font-size: 12px; font-family: Arial;"><?php echo $row[14];?></td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px; text-align: right;">DIRECCION DOMICILIO:</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial;"><?php echo $row[15];?></td>
            </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" style="font-family: Arial; font-size: 14px; text-align: center;" >SEGUIMIENTO (HISTORIAL)</td>
    </tr>
    <tr>
      <td colspan="3"><table width="680" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="41" style="text-align: center; font-family: Arial; font-size: 12px;">N°</td>
            <td width="109" style="font-family: Arial; font-size: 12px; text-align: center;">FECHA DEL CONTROL</td>
            <td width="143" style="font-family: Arial; font-size: 12px; text-align: center;">REGISTRO EPIDEMIOLOGICO</td>
            <td width="108" style="font-size: 12px; font-family: Arial; text-align: center;">SEMANA EP (CONTROL)</td>
            <td width="144" style="font-family: Arial; font-size: 12px; text-align: center;">ESTADO DEL PACIENTE</td>
            <td width="109" style="font-family: Arial; font-size: 12px; text-align: center;">MÉDICO</td>

          </tr>
          <?php
            $numero=1;
            $sql_s =" SELECT seguimiento_ep.idseguimiento_ep, sospecha_diag.sospecha_diag, semana_ep.semana_ep, estado_paciente.estado_paciente,  ";
            $sql_s.=" nombre.nombre, nombre.paterno, nombre.materno, seguimiento_ep.fecha_registro FROM seguimiento_ep, sospecha_diag, semana_ep, estado_paciente, usuarios, nombre ";
            $sql_s.=" WHERE seguimiento_ep.idsospecha_diag=sospecha_diag.idsospecha_diag AND seguimiento_ep.idsemana_ep=semana_ep.idsemana_ep  ";
            $sql_s.=" AND seguimiento_ep.idestado_paciente=estado_paciente.idestado_paciente AND seguimiento_ep.idusuario=usuarios.idusuario ";
            $sql_s.=" AND usuarios.idnombre=nombre.idnombre AND seguimiento_ep.idficha_ep='$idficha_ep' ORDER BY seguimiento_ep.idseguimiento_ep ";
            $result_s = mysqli_query($link,$sql_s);
            if ($row_s = mysqli_fetch_array($result_s)){
            mysqli_field_seek($result_s,0);
            while ($field_s = mysqli_fetch_field($result_s)){
            } do {
              ?>
          <tr>
            <td style="text-align: center; font-family: Arial; font-size: 12px;"><?php echo $numero;?></td>
            <td style="text-align: center; font-family: Arial; font-size: 12px;">
            <?php 
              $fecha_s = explode('-',$row_s[7]);
              $fecha_seg = $fecha_s[2].'/'.$fecha_s[1].'/'.$fecha_s[0];
              echo $fecha_seg; ?>
            </td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_s[1];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo "Sem. ".$row_s[2];?></td>
            <td style="text-align: center; font-family: Arial; font-size: 12px;"><?php echo $row_s[3];?></td>
            <td style="text-align: center; font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row_s[4]." ".$row_s[5]." ".$row_s[6]);?></td>
          </tr>
          <?php
          $numero=$numero+1;
          }
          while ($row_s = mysqli_fetch_array($result_s));
          } else {
          }
          ?>

        </tbody>
      </table></td>
    </tr>
    <tr>
      <td>
      <p>&nbsp;</p>  
      <p>&nbsp;</p>  
      <p>&nbsp;</p> 
      <p style="text-align: center; font-size: 9px; font-family: Arial;">FIRMA PACIENTE</p></td>
      <td>
      <p>&nbsp;</p>  
      <p>&nbsp;</p>  
      <p>&nbsp;</p> 
      <p style="text-align: center; font-size: 9px; font-family: Arial;">FIRMA MÉDICO</p></td>
      </td>
      <td>
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

    $_REQUEST['data'] = 'https://virtual-safci.minsalud.gob.bo/medi-safci/implementacion_safci/imprime_ficha_ep.php?idficha_ep='.$idficha_ep;
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
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
  </tbody>
</table>
