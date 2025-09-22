
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idmunicipio = $_GET['idmunicipio'];

$sql_gp =" SELECT gestion_participativa.idgestion_participativa, departamento.departamento, red_salud.red_salud, municipios.municipio,  ";
$sql_gp.=" gestion_participativa.numero_areas_influencia, gestion_participativa.numero_als, gestion_participativa.numero_eess, gestion_participativa.numero_cls,  ";
$sql_gp.=" gestion_participativa.cosomusa, gestion_participativa.autoridad_cosomusa, gestion_participativa.autoridad_vigencia, gestion_participativa.autoridad_celular,  ";
$sql_gp.=" gestion_participativa.plan_municipal, gestion_participativa.ley_municipal, gestion_participativa.proyectos_planificados, gestion_participativa.proyectos_ejecutados,  ";
$sql_gp.=" vigencia_convenio.vigencia_convenio, gestion_participativa.asignacion_presupuestaria, gestion_participativa.salas_parto_intercultural,  ";
$sql_gp.=" gestion_participativa.referencias_medicina_tradicional, gestion_participativa.correlativo, gestion_participativa.gestion, gestion_participativa.codigo,  ";
$sql_gp.=" gestion_participativa.fecha_registro, gestion_participativa.hora_registro, gestion_participativa.idusuario ";
$sql_gp.=" FROM gestion_participativa, departamento, red_salud, municipios, vigencia_convenio WHERE gestion_participativa.iddepartamento=departamento.iddepartamento  ";
$sql_gp.=" AND gestion_participativa.idred_salud=red_salud.idred_salud AND gestion_participativa.idmunicipio=municipios.idmunicipio  ";
$sql_gp.=" AND gestion_participativa.idvigencia_convenio=vigencia_convenio.idvigencia_convenio AND gestion_participativa.idmunicipio='$idmunicipio' ORDER BY gestion_participativa.idgestion_participativa DESC LIMIT 1 ";

$result_gp=mysqli_query($link,$sql_gp);
$row_gp=mysqli_fetch_array($result_gp);

$idgestion_participativa = $row_gp[0];

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>GESTION PARTICIPATIVA</title>
</head>

<body>
<table width="900" border="0" align="center">
  <tbody>
    <tr>
      <td width="290" style="text-align: center"><img src="../implementacion_safci/logo_safci_doc.png" width="200" height="135" alt=""/></td>
      <td width="306" style="font-family: Arial; font-size: 18px; color: #2D56CF; text-align: center"><h4>GESTIÓN PARTICIPATIVA</h4>
      <h4>DECLARACIÓN</br> <?php echo $row_gp[22];?></h4></td>
      <td width="296">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><table width="900" border="1" bordercolor="#2D56CF" cellspacing="0">
        <tbody>
          <tr>
            <td colspan="2" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: right">DEPARTAMENTO:</td>
            <td colspan="6" style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row_gp[1];?></td>
            </tr>
          <tr>
            <td colspan="2" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: right">RED DE SALUD:</td>
            <td colspan="6" style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row_gp[2];?></td>
            </tr>
          <tr>
            <td colspan="2" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: right">MUNICIPIO:</td>
            <td colspan="6" style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row_gp[3];?></td>
            </tr>
          <tr>
            <td width="165" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center">Nº DE COMUNIDADES<br>
              (ÁREAS DE INFLUENCIA) DE INTERVENCIÓN:</td>
            <td width="75" style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row_gp[4];?></td>
            <td width="154" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center">Nº DE A.L.S.<br>
              AUTORIDADES LOCALES<br>
              DE SALUD:</td>
            <td width="47" style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row_gp[5];?></td>
            <td width="156" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center">Nº DE ESTABLECIMIENTOS DE SALUD<br>
              EN EL MUNICIPIO:</td>
            <td width="67" style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row_gp[6];?></td>
            <td width="144" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center">Nº DE COMITÉS<br>
              LOCALES DE SALUD<br>
              EN EL MUNICIPIO:</td>
            <td width="58" style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row_gp[7];?></td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center">¿CUENTA CON COSOMUSA?</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row_gp[8];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center">NOMBRE Y APELLIDO<br>
              AUTORIDAD COSOMUSA:</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row_gp[9];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center">FECHA DE VIGENCIA<br>
              AUTORIDAD COSOMUSA:</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center">
            <?php 
                $fecha_v = explode('-',$row_gp[10]);
                $f_vigencia = $fecha_v[2].'/'.$fecha_v[1].'/'.$fecha_v[0];?>
                <?php echo $f_vigencia;?></td>
            <td style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center">TELÉFONO CELULAR<br>
              AUTORIDAD COSOMUSA:</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row_gp[11];?></td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center">¿CUENTA CON PLAN MUNICIPAL DE SALUD?</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row_gp[12];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center">¿CUENTA CON LEY MUNICIPAL DE APROBACIÓN DE PLAN MUNICIPAL DE SALUD?</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row_gp[13];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center">NÚMERO DE PROYECTOS EN SALUD<br>
              PLANIFICADOS:</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row_gp[14];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center">NÚMERO DE PROYECTOS EN SALUD<br>
              EJECUTADOS:</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row_gp[15];?></td>
          </tr>
          <tr>
            <td colspan="2" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center">CONVENIO SAFCI</td>
            <td colspan="2" style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row_gp[16];?></td>
            <td colspan="2" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center">ASIGNACIÓN PRESUPUESTARIA [Bs]</td>
            <td colspan="2" style="font-family: Arial; font-size: 12px; text-align: center"><?php 
              $presupuesto_gp  = number_format($row_gp[17], 0, '', '.');
              echo $presupuesto_gp;?></td>
            </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="text-align: center"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="font-family: Arial; font-size: 14px; color: #2D56CF; text-align: center">NÚMERO DE MÉDICOS TRADICIONALES CON REGISTRO RUMETRAB</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><table width="900" border="1" bordercolor="#2D56CF" cellspacing="0">
        <tbody>
          <tr>
            <?php
            $sqlm =" SELECT idmedicina_tradicional, medicina_tradicional FROM medicina_tradicional WHERE idmedicina_tradicional != '5' ORDER BY idmedicina_tradicional ";
            $resultm = mysqli_query($link,$sqlm);
            if ($rowm = mysqli_fetch_array($resultm)){
            mysqli_field_seek($resultm,0);
            while ($fieldm = mysqli_fetch_field($resultm)){
            } do {
            ?>
            <td style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center"><?php echo $rowm[1];?></td>
            <?php
            }
            while ($rowm = mysqli_fetch_array($resultm));
            } else {
            }
            ?>
          </tr>
          <tr>
              <?php          
              $sql_m =" SELECT medicina_tradicional_gp.idmedicina_tradicional_gp, medicina_tradicional.idmedicina_tradicional, medicina_tradicional_gp.numero_med_trad ";
              $sql_m.=" FROM medicina_tradicional_gp, medicina_tradicional WHERE medicina_tradicional_gp.idmedicina_tradicional=medicina_tradicional.idmedicina_tradicional ";
              $sql_m.=" AND medicina_tradicional_gp.rumetrab='CON RUMETRAB' AND medicina_tradicional_gp.idgestion_participativa='$idgestion_participativa' ORDER BY medicina_tradicional.idmedicina_tradicional ";
              $result_m = mysqli_query($link,$sql_m);
              if ($row_m = mysqli_fetch_array($result_m)){
              mysqli_field_seek($result_m,0);
              while ($field_m = mysqli_fetch_field($result_m)){
              } do {
              ?>
            <td style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row_m[2];?></td>
              <?php 
              }
              while ($row_m = mysqli_fetch_array($result_m));
              } else {
              }
              ?>
          </tr>
        </tbody>
      </table></td>
    </tr>
        <tr>
      <td>&nbsp;</td>
      <td style="text-align: center"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="font-family: Arial; font-size: 14px; color: #2D56CF; text-align: center">NÚMERO DE MÉDICOS TRADICIONALES SIN REGISTRO RUMETRAB</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><table width="900" border="1" bordercolor="#2D56CF" cellspacing="0">
        <tbody>
          <tr>
            <?php
            $sqlm =" SELECT idmedicina_tradicional, medicina_tradicional FROM medicina_tradicional WHERE idmedicina_tradicional != '5' ORDER BY idmedicina_tradicional ";
            $resultm = mysqli_query($link,$sqlm);
            if ($rowm = mysqli_fetch_array($resultm)){
            mysqli_field_seek($resultm,0);
            while ($fieldm = mysqli_fetch_field($resultm)){
            } do {
            ?>
            <td style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center"><?php echo $rowm[1];?></td>
            <?php
            }
            while ($rowm = mysqli_fetch_array($resultm));
            } else {
            }
            ?>
          </tr>
          <tr>
          <?php          
          $sql_m =" SELECT medicina_tradicional_gp.idmedicina_tradicional_gp, medicina_tradicional.idmedicina_tradicional, medicina_tradicional_gp.numero_med_trad ";
          $sql_m.=" FROM medicina_tradicional_gp, medicina_tradicional WHERE medicina_tradicional_gp.idmedicina_tradicional=medicina_tradicional.idmedicina_tradicional ";
          $sql_m.=" AND medicina_tradicional_gp.rumetrab='SIN RUMETRAB' AND medicina_tradicional_gp.idgestion_participativa='$idgestion_participativa' ORDER BY medicina_tradicional.idmedicina_tradicional ";
          $result_m = mysqli_query($link,$sql_m);
          if ($row_m = mysqli_fetch_array($result_m)){
          mysqli_field_seek($result_m,0);
          while ($field_m = mysqli_fetch_field($result_m)){
          } do {
          ?>
            <td style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row_m[2];?></td>
          <?php 
          }
          while ($row_m = mysqli_fetch_array($result_m));
          } else {
          }
          ?>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="text-align: center"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><table width="900" border="1" bordercolor="#2D56CF" cellspacing="0">
        <tbody>
          <tr>
            <td width="284" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center">NÚMERO DE SALAS DE PARTO INTERCULTURAL IMPLEMENTADAS:</td>
            <td width="158" style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row_gp[18];?></td>
            <td width="320" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center">NÚMERO DE REFERENCIAS Y CONTRAREFERENCIAS CON MEDICINA TRADICIONAL:</td>
            <td width="120" style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row_gp[19];?></td>
          </tr>
        </tbody>
      </table></td>
    </tr>

          <tr>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">&nbsp;</td>
            <td style="text-align: center">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">&nbsp;</td>
            
            <td style="text-align: center">&nbsp;</td>
            <td>&nbsp;  </td>
          </tr>
          <tr>
            <?php
            $sqlus =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM nombre, usuarios WHERE usuarios.idnombre=nombre.idnombre ";
            $sqlus.=" AND usuarios.idusuario='$row_gp[25]' ";
            $resultus = mysqli_query($link,$sqlus);
            $rowus = mysqli_fetch_array($resultus);?>
            
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><p>Yo: <?php echo mb_strtoupper($rowus[0]." ".$rowus[1]." ".$rowus[2]);?></p>
            <p>Declaro la veracidad de los datos del presente formulario</p>
            <p>Fecha de la Declaracion Jurada : 
                <?php 
                $fecha_d = explode('-',$row_gp[23]);
                $f_declaracion = $fecha_d[2].'/'.$fecha_d[1].'/'.$fecha_d[0];?>
                <?php echo $f_declaracion;?> </p>
          
          </td>
            <td style="text-align: center; font-size: 12px; font-family: Arial;"><p><span style="text-align: center">............................................................................</span></p>
            <p>FIRMA</p></td>
            <td style="text-align: center; font-size: 12px; font-family: Arial;">
              
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

    $_REQUEST['data'] = 'https://virtual-safci.minsalud.gob.bo/medi-safci/gestion_participativa/formulario_gestion_participativa.php?idgestion_participativa='.$idgestion_participativa;
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
      <td>&nbsp;</td>
      <td>
                

      </td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
</body>
</html>
