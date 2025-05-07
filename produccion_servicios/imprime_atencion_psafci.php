<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		 = date("Y-m-d");
$gestion    = date("Y");

$idatencion_psafci = $_GET['idatencion_psafci'];

$sql =" SELECT atencion_psafci.idatencion_psafci, atencion_psafci.codigo, nombre.ci, nombre.nombre, nombre.paterno, nombre.materno, ";
$sql.=" departamento.departamento, red_salud.red_salud, municipios.municipio, establecimiento_salud.establecimiento_salud, tipo_consulta.tipo_consulta, ";
$sql.=" repeticion.repeticion, tipo_atencion.tipo_atencion, atencion_psafci.fecha_registro, nombre.fecha_nac, atencion_psafci.hora_registro, atencion_psafci.idusuario, atencion_psafci.edad, atencion_psafci.idtipo_atencion ";
$sql.=" FROM atencion_psafci, nombre, repeticion, tipo_consulta, tipo_atencion, departamento, red_salud, municipios, establecimiento_salud WHERE atencion_psafci.idnombre=nombre.idnombre ";
$sql.=" AND atencion_psafci.idtipo_consulta=tipo_consulta.idtipo_consulta AND atencion_psafci.idtipo_consulta=tipo_consulta.idtipo_consulta AND atencion_psafci.iddepartamento=departamento.iddepartamento ";
$sql.=" AND atencion_psafci.idrepeticion=repeticion.idrepeticion AND atencion_psafci.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud  ";
$sql.=" AND atencion_psafci.idtipo_atencion=tipo_atencion.idtipo_atencion AND atencion_psafci.idatencion_psafci='$idatencion_psafci'";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);

?>
<table width="680" border="0" align="center">
  <tbody>
    <tr>
      <td width="177" style="text-align: center"><img src="../implementacion_safci/logo_safci_doc.png" width="116" height="84" alt=""/></td>
      <td width="323" style="text-align: center; font-family: Arial; font-size: 16px;"><p>ATENCIÓN PSAFCI</p>
      <p>CÓDIGO : <?php echo $row[1];?></p></td>
      <td width="166">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><table width="700" border="0">
        <tbody>
          <tr>
            <td colspan="2" style="text-align: right; font-size: 12px; font-family: Arial;">FECHA DE REGISTRO </br>(ATENCIÓN INTEGRAL):</td>
            <td colspan="2" style="font-size: 14px; font-family: Arial;">
            <?php 
                $fecha_r = explode('-',$row[13]);
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
            <td  style="font-family: Arial; font-size: 12px; text-align: right;">DEPARTAMENTO:</td>
            <td  style="font-family: Arial; font-size: 12px;"><?php echo $row[6];?></td>
            <td  style="font-family: Arial; font-size: 12px; text-align: right;">RED DE SALUD:</td>
            <td  style="font-family: Arial; font-size: 12px;"><?php echo $row[7];?></td>
          </tr>
          <tr>
            <td style="font-size: 12px; font-family: Arial; text-align: right;">MUNICIPIO:</td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[8];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: right;">ESTABLECIMIENTO DE SALUD:</td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[9];?></td>
          </tr>
          <tr>
            <td style="font-size: 12px; font-family: Arial; text-align: right;">CONSULTA/VISITA:</td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[10];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: right;">TIPO DE ATENCIÓN:</td>
            <td style="font-size: 12px; font-family: Arial;"><?php echo $row[12];?></td>
          </tr>
          <tr>
            <td style="font-size: 12px; font-family: Arial; text-align: right;">INCIDENCIA:</td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[11];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: right;"></td>
            <td style="font-size: 12px; font-family: Arial;"></td>
          </tr>
          <tr>  
            <td style="font-size: 12px; font-family: Arial; text-align: right;"></td>
            <td style="font-family: Arial; font-size: 12px;"></td>
            <td style="font-family: Arial; font-size: 12px; text-align: right;"></td>
            <td style="font-size: 12px; font-family: Arial;"></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="3" style="font-family: Arial; font-size: 14px; text-align: center;" >INFORMACIÓN DE FILIACIÓN</td>
    </tr>

    <tr>
      <td colspan="3"><table width="680" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td colspan="2" style="font-family: Arial; font-size: 12px; text-align: right;">CÉDULA DE IDENTIDAD (PACIENTE):</td>
            <td colspan="2" style="font-family: Arial; font-size: 12px;"><?php echo $row[2];?></td>
            </tr>
          <tr>
            <td width="168" style="font-family: Arial; font-size: 12px; text-align: right;">NOMBRES:</td>
            <td width="160" style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[3]);?></td>
            <td width="168" style="font-family: Arial; font-size: 12px; text-align: right;">APELLIDOS:</td>
            <td width="166" style="font-size: 12px; font-family: Arial;"><?php echo mb_strtoupper($row[4]." ".$row[5]);?></td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px; text-align: right;">FECHA DE NACIMIENTO:</td>
            <td style="font-size: 12px; font-family: Arial;">
            <?php 
                  $fecha_n = explode('-',$row[14]);
                  $fecha_nac = $fecha_n[2].'/'.$fecha_n[1].'/'.$fecha_n[0];
                  echo $fecha_nac; ?>
            </td>
            <td style="font-family: Arial; font-size: 12px; text-align: right;">EDAD:</td>
            <td style="font-size: 12px; font-family: Arial;"><?php echo $row[17];?></td>
          </tr>

        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" style="font-family: Arial; font-size: 14px; text-align: center;" >INFORMACIÓN DE LA ATENCIÓN</td>
    </tr>
    <tr>
      <td colspan="3">
        <table width="680" border="1" align="center" cellspacing="0">
        <tbody>
          <tr>
            <td width="41" style="text-align: center; font-family: Arial; font-size: 12px;">N°</td>
            <td width="109" style="font-family: Arial; font-size: 12px; text-align: center;">MOTIVO CONSULTA</td>
            <td width="143" style="font-family: Arial; font-size: 12px; text-align: center;">DIAGNÓSTICO</td>
            <td width="109" style="font-family: Arial; font-size: 12px; text-align: center;">MÉDICO</td>
          </tr>
          <?php
            $numero_s=1;
            $sql_s =" SELECT diagnostico_psafci.iddiagnostico_psafci, diagnostico_psafci.motivo_consulta, patologia.patologia, patologia.cie FROM diagnostico_psafci, patologia  ";
            $sql_s.=" WHERE diagnostico_psafci.idpatologia=patologia.idpatologia AND diagnostico_psafci.idatencion_psafci='$idatencion_psafci' ";
            $result_s = mysqli_query($link,$sql_s);
            if ($row_s = mysqli_fetch_array($result_s)){
            mysqli_field_seek($result_s,0);
            while ($field_s = mysqli_fetch_field($result_s)){
            } do {
              ?>
          <tr>
            <td style="text-align: center; font-family: Arial; font-size: 12px;"><?php echo "Diagnóstico ".$numero_s;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_s[1];?></td>
            <td style="text-align: center; font-family: Arial; font-size: 12px;"><?php echo $row_s[2]." - ".$row_s[3];?></td>
            <td style="text-align: center; font-family: Arial; font-size: 12px;">
            <?php 
                $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                $sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row[16]' ";
                $result_r = mysqli_query($link,$sql_r);
                $row_r = mysqli_fetch_array($result_r);                    
                echo mb_strtoupper($row_r[0]." ".$row_r[1]." ".$row_r[2]);?>
            </td>
          </tr>
          <?php
          $numero_s=$numero_s+1;
          }
          while ($row_s = mysqli_fetch_array($result_s));
          } else {
          }
          ?>
        </tbody>
      </table>
      </td>
      </tr>
      <tr>
      <td colspan="3" style="font-family: Arial; font-size: 14px; text-align: center;" ></td>
      </tr>
      <tr>
        <td colspan="3" style="font-family: Arial; font-size: 14px; text-align: center;" >&nbsp;</td>
      </tr>

      <?php  if ($row[18] == '1') {  ?>
            
      <tr>
        <td colspan="3" style="font-family: Arial; font-size: 14px; text-align: center;" >TRATAMIENTO(S)</td>
      </tr>
      <tr>
        <td colspan="3" style="font-family: Arial; font-size: 10px; text-align: center;" ><table width="680" align="center" border="1" cellspacing="0">
          <tbody>
            <tr>
              <td width="41" style="text-align: center; font-family: Arial; font-size: 12px;">N°</td>
              <td width="109" style="font-family: Arial; font-size: 12px; text-align: center;">TIPO DE MEDICAMENTO</td>
              <td width="143" style="font-family: Arial; font-size: 12px; text-align: center;">MEDICAMENTO</td>
              <td width="109" style="font-family: Arial; font-size: 12px; text-align: center;">MÉDICO</td>
            </tr>
            <?php
            $numero_t=1;
            $sql_t =" SELECT tratamiento_psafci.idtratamiento_psafci, tipo_medicamento.tipo_medicamento, medicamento.medicamento FROM tratamiento_psafci, tipo_medicamento, medicamento ";
            $sql_t.=" WHERE tratamiento_psafci.idtipo_medicamento=tipo_medicamento.idtipo_medicamento AND tratamiento_psafci.idmedicamento=medicamento.idmedicamento AND  ";
            $sql_t.=" tratamiento_psafci.idatencion_psafci ='$idatencion_psafci' ";
            $result_t = mysqli_query($link,$sql_t);
            if ($row_t = mysqli_fetch_array($result_t)){
            mysqli_field_seek($result_t,0);
            while ($field_t = mysqli_fetch_field($result_t)){
            } do {
              ?>
            <tr>
            <td style="text-align: center; font-family: Arial; font-size: 12px;"><?php echo "Tratamiento ".$numero_t;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_t[1];?></td>
            <td style="text-align: center; font-family: Arial; font-size: 12px;"><?php echo $row_t[2];?></td>
            <td style="text-align: center; font-family: Arial; font-size: 12px;">
            <?php 
                $sql_dr =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                $sql_dr.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row[16]' ";
                $result_dr = mysqli_query($link,$sql_dr);
                $row_dr = mysqli_fetch_array($result_dr);                    
                echo mb_strtoupper($row_dr[0]." ".$row_dr[1]." ".$row_dr[2]);?>
            </td>
            </tr>
            <?php
          $numero_t=$numero_t+1;
          }
          while ($row_t = mysqli_fetch_array($result_t));
          } else {
           
          }
          ?>
          </tbody>
        </table></td>
      </tr>

      <?php } else { }  ?>
      <tr>
        <td colspan="3" style="font-family: Arial; font-size: 14px; text-align: center;" >&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" style="font-family: Arial; font-size: 14px; text-align: center;" >
        
        </td>
      </tr>
      <tr>
      <td colspan="3">

      </td>
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

    include "../implementacion_safci/phpqrcode.php";

    //capturamos el valor de "data"

    $separador='|';
    $tamano='M';

    $_REQUEST['data'] = 'https://virtual-safci.minsalud.gob.bo/medi-safci/produccion_servicios/imprime_atencion_psafci.php?idatencion_psafci='.$idatencion_psafci;
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

    
  </tbody>
</table>
