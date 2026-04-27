<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y"); 

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idhistoria_perinatal = $_GET['idhistoria_perinatal'];

$sql_hp =" SELECT idhistoria_perinatal, iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idarea_influencia, codigo, idnombre, ";
$sql_hp.=" idnacion, alfabeta, idnivel_instruccion, anos_mayor_nivel, vive_sola, gestion, fecha_registro, hora_registro, idusuario ";
$sql_hp.=" FROM historia_perinatal WHERE idhistoria_perinatal = '$idhistoria_perinatal' ";
$result_hp=mysqli_query($link,$sql_hp);
$row_hp=mysqli_fetch_array($result_hp);

$sql_n =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$row_hp[7]' ";
$result_n=mysqli_query($link,$sql_n);
$row_n=mysqli_fetch_array($result_n);

      $fecha_nacimiento = $row_n[5];
      $dia = date("d");
      $mes = date("m");
      $ano = date("Y");    
      $dianaz = date("d",strtotime($fecha_nacimiento));
      $mesnaz = date("m",strtotime($fecha_nacimiento));
      $anonaz = date("Y",strtotime($fecha_nacimiento));         
      if (($mesnaz == $mes) && ($dianaz > $dia)) {
      $ano=($ano-1); }      
      if ($mesnaz > $mes) {
      $ano=($ano-1);}       
      $edad=($ano-$anonaz);  

$sql_d =" SELECT integrante_datos_cf.idintegrante_datos_cf, estado_civil.estado_civil, nivel_instruccion.nivel_instruccion, integrante_datos_cf.idcarpeta_familiar, integrante_datos_cf.idnivel_instruccion, ";
$sql_d.=" integrante_datos_cf.idestado_civil FROM integrante_datos_cf, estado_civil, nivel_instruccion WHERE integrante_datos_cf.idestado_civil=estado_civil.idestado_civil  ";
$sql_d.=" AND integrante_datos_cf.idnivel_instruccion=nivel_instruccion.idnivel_instruccion AND integrante_datos_cf.idnombre='$row_hp[7]' ";
$result_d=mysqli_query($link,$sql_d);
$row_d=mysqli_fetch_array($result_d);

$sql_cf =" SELECT ubicacion_cf.idubicacion_cf, departamento.departamento, red_salud.red_salud, municipios.municipio, establecimiento_salud.establecimiento_salud, tipo_area_influencia.tipo_area_influencia, ";
$sql_cf.=" area_influencia.area_influencia, carpeta_familiar.codigo, ubicacion_cf.avenida_calle, ubicacion_cf.no_puerta, ubicacion_cf.nombre_edificio, nacion.nacion  ";
$sql_cf.=" FROM ubicacion_cf, carpeta_familiar, departamento, red_salud, municipios, establecimiento_salud, area_influencia, tipo_area_influencia, nacion, integrante_cf ";
$sql_cf.=" WHERE carpeta_familiar.iddepartamento=departamento.iddepartamento AND carpeta_familiar.idred_salud=red_salud.idred_salud AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_cf.=" AND carpeta_familiar.idmunicipio=municipios.idmunicipio AND carpeta_familiar.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND integrante_cf.idnacion=nacion.idnacion ";
$sql_cf.=" AND carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia  ";
$sql_cf.=" AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ubicacion_cf.idcarpeta_familiar='$row_d[3]'  ";
$result_cf=mysqli_query($link,$sql_cf);
$row_cf=mysqli_fetch_array($result_cf);

$idnivel_instruccion = $row_d[4];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  

<table width="900" border="0" align="center">
  <tbody>
    <tr>
      <td width="226" rowspan="3" style="text-align: center"><img src="../implementacion_safci/mds_logo.jpg" width="193" height="85" alt=""/></td>
      <td width="432" style="font-family: Arial; font-size: 14px; text-align: center;">MINISTERIO DE SALUD Y DEPORTES</td>
      <td width="228" style="font-family: Arial; font-size: 14px; text-align: center;"><p>N° de Carpeta Familiar: </p></td>
    </tr>

    <tr>
      <td style="font-family: Arial; font-size: 16px; text-align: center;">HISTORIA CLINICA PERINATAL</td>
      <td style="font-family: Arial; font-size: 16px; text-align: center;"><?php echo $row_cf[7];?></td>
    </tr>
    <tr>
      <td style="font-family: Arial; font-size: 16px; text-align: center;"><?php echo $row_hp[6];?></td>
      <td>&nbsp;</td>
    </tr>
        <tr>
      <td style="font-family: Arial; font-size: 14px; text-align: center;">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><table width="900" border="0">
        <tbody>
          <tr>
            <td width="320" valign="top"><table width="320" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td width="314" bgcolor="#020202" style="font-size: 12px; font-family: Arial; color: #FFFFFF; text-align: center;"><strong>HISTORIA CLINICA PERINATAL</strong></td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">NOMBRE : <?php echo $row_n[1];?> <?php echo $row_n[2];?> <?php echo $row_n[3];?></td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">DOMICILIO : <?php echo $row_cf[8];?> <?php echo $row_cf[9];?> <?php echo $row_cf[10];?></td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;"><?php echo $row_cf[5];?> : <?php echo $row_cf[6];?></td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">MUNICIPIO : <?php echo $row_cf[3];?></td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">RED DE SALUD : <?php echo $row_cf[2];?></td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">TELEFONO :</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">IDIOMA :
                  <?php
                  $numero=1;
                  $sql4 =" SELECT idioma_cf.ididioma_cf, idioma.idioma, origen_idioma.origen_idioma  FROM idioma_cf, idioma, origen_idioma ";
                  $sql4.=" WHERE idioma_cf.ididioma=idioma.ididioma AND idioma_cf.idorigen_idioma=origen_idioma.idorigen_idioma ";
                  $sql4.=" AND idioma_cf.idcarpeta_familiar='$row_d[3]' ";
                  $result4 = mysqli_query($link,$sql4);
                  if ($row4 = mysqli_fetch_array($result4)){
                  mysqli_field_seek($result4,0);
                  while ($field4 = mysqli_fetch_field($result4)){
                  } do { 
                  ?>
                  <?php echo $row4[2];?> : <?php echo $row4[1];?></br>
                  <?php
                    $numero=$numero+1;
                    }
                    while ($row4 = mysqli_fetch_array($result4));
                    } else {
                    }
                ?>
                </td>
                </tr>

              </tbody>
            </table></td>
            <td width="116"><table width="116" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td colspan="3" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">FECHA DE NACIMIENTO</td>
                  </tr>
                <tr>
                  <td width="35" style="font-family: Arial; font-size: 12px; text-align: center;">DIA</td>
                  <td width="34" style="font-family: Arial; font-size: 12px; text-align: center;">MES</td>
                  <td width="33" style="font-family: Arial; font-size: 12px; text-align: center;">ANO</td>
                </tr>
                <?php $fecha_n = explode('-',$row_n[5]); ?>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $fecha_n[2];?></td>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $fecha_n[1];?></td>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $fecha_n[0];?></td>
                </tr>
                <tr>
                  <td colspan="3" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">EDAD(anos)</td>
                  </tr>
                <tr>
                  <td colspan="2" rowspan="2" bgcolor="#<?php if ($edad < '15' || $edad > '35') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $edad;?></td>
                  <td bgcolor="#<?php if ($edad < '15') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;">&lt;de 15</td>
                </tr>
                <tr>
                  <td bgcolor="#<?php if ($edad > '35') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;">&gt;de 35</td>
                </tr>
              </tbody>
            </table></td>
            <td width="133" valign="top"><table width="132" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td width="126" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">AUTO-IDENTIFICACION</td>
                  </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_cf[11];?></td>
                  </tr>
                <tr>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">ALFABETA</td>
                  </tr>

                  <?php
                    if ($idnivel_instruccion =='1' || $idnivel_instruccion =='2' || $idnivel_instruccion =='3') {
                        $alfabeta = 'NO';
                    } else {
                        $alfabeta = 'SI';
                    }
                  ?>
                <tr>
                  <td bgcolor="#<?php if ($alfabeta == 'NO') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $alfabeta;?></td>
                  </tr>
              </tbody>
            </table></td>
            <td width="69" valign="top"><table width="69" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td width="71" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">ESTUDIOS</td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#<?php if ($idnivel_instruccion =='1' || $idnivel_instruccion =='2') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px;"><?php echo $row_d[2];?></td>
                </tr>
                <tr>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">años en el mayor nivel</td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFff" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_hp[11];?></td>
                </tr>
              </tbody>
            </table></td>
            <td width="71" valign="top"><table width="71" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">ESTADO CIVIL</td>
                </tr>
                <tr>
                  <td bgcolor="#<?php if ($row_d[5] =='1' || $row_d[5] =='4' || $row_d[5] =='5' || $row_d[5] =='6') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_d[1];?></td>
                </tr>
                <tr>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">vive sola</td>
                </tr>
                <tr>
                  <td bgcolor="#<?php if ($row_hp[12] =='SI') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_hp[12];?></td>
                </tr>
              </tbody>
            </table></td>
            <td width="165" valign="top"><table width="168" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td bgcolor="#cbddf4" width="67" style="font-family: Arial; font-size: 12px; text-align: left;">CONTROL PRENATAL EN:</td>
                  <td width="73" align="center" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_cf[4];?></td>
                </tr>
                <tr>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: left;">PARTO EN:</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: left;">C. IDENT.</td>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_n[4];?></td>
                </tr>
                <tr>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: left;">F. Nac. N° Reg.</td>
                  <td>&nbsp;</td>
                </tr>
              </tbody>
            </table></td>
            </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="3"><table width="900" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td colspan="3" bgcolor="#020202" style="font-size: 12px; font-family: Arial; color: #FFFFFF; text-align: center;">1. ANTECEDENTES</td>
            <td colspan="3" rowspan="2" align="center" valign="bottom" style="font-size: 12px; font-family: Arial; text-align: center;">OBSTETRICOS</td>
            </tr>
          <tr>
            <td width="118" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">FAMILIARES</td>
            <td colspan="2" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">PERSONALES</td>
            </tr>
          <tr>
            <td valign="top">

              <table width="118" border="0">
              <tbody>
              <?php
              $numero_e=0;
              $sql_e =" SELECT antecedente_enfermedad.idantecedente_enfermedad, antecedente_enfermedad.antecedente_enfermedad, antecedente_perinatal.valor_antecedente_perinatal  ";
              $sql_e.=" FROM antecedente_perinatal, antecedente_enfermedad WHERE antecedente_perinatal.idantecedente_enfermedad=antecedente_enfermedad.idantecedente_enfermedad  ";
              $sql_e.=" AND antecedente_perinatal.idtipo_antecedente_enfermedad='2' AND antecedente_perinatal.idhistoria_perinatal='$idhistoria_perinatal'  ";
              $result_e = mysqli_query($link,$sql_e);
              if ($row_e = mysqli_fetch_array($result_e)){
              mysqli_field_seek($result_e,0);
              while ($field_e = mysqli_fetch_field($result_e)){
              } do {
              ?>
                <tr>
                  <td width="89" style="font-family: Arial; font-size: 12px; text-align: right;"><?php echo $row_e[1];?></td>
                  <td width="13" bgcolor="#<?php if ($row_e[2] =='SI') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_e[2];?></td>
                </tr>
              <?php
              $numero_e=$numero_e+1;
              }
              while ($row_e = mysqli_fetch_array($result_e));
              } else {
              }
              ?>
              </tbody>
            </table>
          
          </td>
            <td width="118" valign="top">
              <table width="118" border="0">
              <tbody>
                <?php
                $numero_e=0;
                $sql_e =" SELECT antecedente_enfermedad.idantecedente_enfermedad, antecedente_enfermedad.antecedente_enfermedad, antecedente_perinatal.valor_antecedente_perinatal  ";
                $sql_e.=" FROM antecedente_perinatal, antecedente_enfermedad WHERE antecedente_perinatal.idantecedente_enfermedad=antecedente_enfermedad.idantecedente_enfermedad  ";
                $sql_e.=" AND antecedente_perinatal.idtipo_antecedente_enfermedad='1' AND antecedente_perinatal.idhistoria_perinatal='$idhistoria_perinatal' AND antecedente_enfermedad.idantecedente_enfermedad <'9'  ";
                $result_e = mysqli_query($link,$sql_e);
                if ($row_e = mysqli_fetch_array($result_e)){
                mysqli_field_seek($result_e,0);
                while ($field_e = mysqli_fetch_field($result_e)){
                } do {
                ?>
                <tr>
                  <td width="89" style="font-family: Arial; font-size: 12px; text-align: right;"><?php echo $row_e[1];?> </td>
                  <td width="13" bgcolor="#<?php if ($row_e[2] =='SI') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_e[2];?></td>
                </tr>
              <?php
              $numero_e=$numero_e+1;
              }
              while ($row_e = mysqli_fetch_array($result_e));
              } else {
              }
              ?>
              </tbody>
            </table>
          </td>
            <td width="118" valign="top">
              <table width="118" border="0">
              <tbody>
                <?php
                $numero_e=0;
                $sql_e =" SELECT antecedente_enfermedad.idantecedente_enfermedad, antecedente_enfermedad.antecedente_enfermedad, antecedente_perinatal.valor_antecedente_perinatal  ";
                $sql_e.=" FROM antecedente_perinatal, antecedente_enfermedad WHERE antecedente_perinatal.idantecedente_enfermedad=antecedente_enfermedad.idantecedente_enfermedad  ";
                $sql_e.=" AND antecedente_perinatal.idtipo_antecedente_enfermedad='1' AND antecedente_perinatal.idhistoria_perinatal='$idhistoria_perinatal' AND antecedente_enfermedad.idantecedente_enfermedad >'8'  ";
                $result_e = mysqli_query($link,$sql_e);
                if ($row_e = mysqli_fetch_array($result_e)){
                mysqli_field_seek($result_e,0);
                while ($field_e = mysqli_fetch_field($result_e)){
                } do {
                ?>
                <tr>
                  <td width="89" style="font-family: Arial; font-size: 12px; text-align: right;"><?php echo $row_e[1];?>  </td>
                  <td width="13" bgcolor="#<?php if ($row_e[2] =='SI') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_e[2];?></td>
                </tr>
              <?php
              $numero_e=$numero_e+1;
              }
              while ($row_e = mysqli_fetch_array($result_e));
              } else {
              }
              ?>
              </tbody>
            </table></td>

            <?php
              $sql_ao =" SELECT idantecedente_obstetrico, gestaciones, partos, abortos, cesareas, nacidos_vivos, viven, nacidos_muertos, muertos_a_semana,  ";
              $sql_ao.=" muertos_d_semana, vaginales, idultimo_previo, antecedente_gemelos, fecha_fea, menos_ano, embarazo_planeado, idmetodo_anticonceptivo  ";
              $sql_ao.=" FROM antecedente_obstetrico WHERE idhistoria_perinatal='$idhistoria_perinatal'  ";
              $result_ao=mysqli_query($link,$sql_ao);
              $row_ao=mysqli_fetch_array($result_ao);
            ?>

            <td width="85" valign="top"><table width="100" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">ULTIMO PREVIO</td>
                  </tr>
                <tr>
                  <td bgcolor="#<?php if ($row_ao[11] =='2' || $row_ao[11] =='4') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;">
                    </br>
                    <?php 
                    $sql_up = "SELECT idultimo_previo, ultimo_previo FROM ultimo_previo WHERE idultimo_previo='$row_ao[11]'";
                    $result_up = mysqli_query($link,$sql_up);
                    $row_up = mysqli_fetch_array($result_up);
                    echo $row_up[1];?>
                    </br></br>
                  </td>                 
                  </tr>
                <tr>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">Antecedente de gemelos</td>
                  </tr>
                <tr>
                  <td bgcolor="#<?php if ($row_ao[12] =='SI') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ao[12];?></br></br></td>
                  </tr>
              </tbody>
            </table></td>
            <td width="242" valign="top"><table width="250" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td width="67" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">gestas previas</td>
                  <td width="87" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">abortos</td>
                  <td width="68" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">vaginales</td>
                  <td width="9" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">nacidos vivos</td>
                  <td width="9" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">viven</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ao[1];?></br></br></td>
                  <td bgcolor="#<?php if ($row_ao[3] > '0') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>"  style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ao[3];?></br></br></td>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ao[10];?></br></br></td>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ao[5];?></br></br></td>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ao[6];?></br></br></td>
                </tr>
                <tr>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">partos</span></td>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">cesareas</td>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">nacidos muertos</td>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">muertos 1° Sem.</td>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">despues 1° Sem.</td>
                </tr>
                <tr>
                  <td  style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ao[2];?></br></br></td>
                  <td bgcolor="#<?php if ($row_ao[4] > '0') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ao[4];?></br></br></td>
                  <td bgcolor="#<?php if ($row_ao[7] > '0') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ao[7];?></br></br></td>
                  <td bgcolor="#<?php if ($row_ao[8] > '0') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ao[8];?></br></br></td>
                  <td bgcolor="#<?php if ($row_ao[9] > '0') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ao[9];?></br></br></td>
                </tr>
              </tbody>
            </table></td>
            <td width="193" valign="top"><table width="185" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td colspan="3" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">FIN DE EMBARAZO ANTERIOR</td>
                  </tr>
                  <?php $fecha_fea = explode('-',$row_ao[13]); ?>
                <tr>
                  <td width="61" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">dia</td>
                  <td width="60" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">mes</td>
                  <td width="50" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">año</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php if ($fecha_fea[2]=='11') {  } else { echo $fecha_fea[2]; }?></br></br></td>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php if ($fecha_fea[1]=='11') {  } else { echo $fecha_fea[1]; }?></br></br></td>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php if ($fecha_fea[0]=='1111') {  } else { echo $fecha_fea[0]; }?></br></br></td>
                </tr>
                <tr>
                  <td colspan="2" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">menos de 1 ano</td>
                  <td bgcolor="#<?php if ($row_ao[14] == 'SI') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_ao[14];?></td>
                </tr>
                <tr>
                  <td colspan="2" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">EMBARAZO PLANEADO</td>
                  <td bgcolor="#<?php if ($row_ao[3] == 'NO') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_ao[15];?></td>
                </tr>
                <tr>
                  <td colspan="2" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">FRACASO METODO ANTICONCEPTIVO</td>
                  <td bgcolor="#<?php if ($row_ao[16] == '1') { echo 'FFFFFF'; } else { echo 'FFFF00'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;">
                    <?php 
                    $sql_ma = "SELECT idmetodo_anticonceptivo, metodo_anticonceptivo FROM metodo_anticonceptivo WHERE idmetodo_anticonceptivo='$row_ao[16]'";
                    $result_ma = mysqli_query($link,$sql_ma);
                    $row_ma = mysqli_fetch_array($result_ma);  
                    echo $row_ma[1];?>
                  </td>
                </tr>
              </tbody>
            </table></td>
            </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="3">
        
      <?php
        $sql_ga =" SELECT idhistoria_perinatal, idnombre, peso_anterior, talla, idesno, fecha_fum, fecha_pp, eg_fum, eco_veinte,  ";
        $sql_ga.=" fuma_activo, fuma_pasivo, drogas, alcohol, violencia, idantirubeola, antitetanica, dosis_antitetanica,  ";
        $sql_ga.=" ex_odontologico, ex_mamas FROM gestacion WHERE idhistoria_perinatal='$idhistoria_perinatal' ";
        $result_ga=mysqli_query($link,$sql_ga);
        $row_ga=mysqli_fetch_array($result_ga);
      ?>
      
      <table width="900" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td colspan="2" bgcolor="#020202" style="font-size: 12px; font-family: Arial; color: #FFFFFF; text-align: center;">2. GESTACION ACTUAL</td>
            <td colspan="6">&nbsp;</td>
            </tr>
          <tr>
            <td width="100" valign="top"><table width="100" cellspacing="0" border="1">
              <tbody>
                <tr>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">PESO ANTERIOR</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ga[2];?></br></br></td>
                </tr>
              </tbody>
            </table></td>
            <td width="100" valign="top"><table width="100" cellspacing="0" border="1">
              <tbody>
                <tr>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;"></br>TALLA[cm]</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ga[3];?></br></br></td>
                </tr>
              </tbody>
            </table></td>
            <td width="100" valign="top"><table width="100" cellspacing="0" border="1">
              <tbody>
                <tr>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">IMC inicial</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">
                </br><?php 
                    $imc_i = $row_ga[2]*10000/$row_ga[3]**2;  //** Estatura en centimetros */
                    $imc = number_format($imc_i, 6, '.', '');
                  echo $imc;
                  ?></br></br>
                  </td>
                </tr>
                <tr>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">E - S - N - O</td>
                </tr>
                <tr>
                  <td bgcolor="#<?php if ($row_ga[4] == '3') { echo 'FFFFFF'; } else { echo 'FFFF00'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"></br>
                  <?php 
                    $sql_es = "SELECT idesno, esno FROM esno WHERE idesno='$row_ga[4]'";
                    $result_es = mysqli_query($link,$sql_es);
                    $row_es = mysqli_fetch_array($result_es);
                    echo $row_es[1];
                  ?></br></br>
                  
                </td>
                </tr>
              </tbody>
            </table></td>
            <td width="100" valign="top"><table width="150" cellspacing="0" border="1">
              <tbody>
                <tr>
                  <td colspan="3" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">F.U.M.</td>
                  <?php $fecha_fum = explode('-',$row_ga[5]); ?>
                  </tr>
                <tr>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">dia</td>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">mes</td>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">ano</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $fecha_fum[2];?></br></br></td>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $fecha_fum[1];?></br></br></td>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $fecha_fum[0];?></br></br></td>
                </tr>
                <tr>
                  <td colspan="3" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">F.P.P.</td>
                  <?php $fecha_pp = explode('-',$row_ga[6]); ?>
                  </tr>
                <tr>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">dia</td>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">mes</td>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">ano</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $fecha_pp[2];?></br></br></td>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $fecha_pp[1];?></br></br></td>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $fecha_pp[0];?></br></br></td>
                </tr>
              </tbody>
            </table></td>
            <td width="111" valign="top"><table width="100" cellspacing="0" border="1">
              <tbody>
                <tr>
                  <td colspan="2" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">EG. CONFIABLE por:</td>
                  </tr>
                <tr>
                  <td width="43" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">F.U.M.</td>
                  <td width="47" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">Eco&lt;20s</td>
                </tr>
                <tr>
                  <td bgcolor="#<?php if ($row_ga[7] == 'NO') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ga[7];?></br></br></td>
                  <td bgcolor="#<?php if ($row_ga[8] == 'NO') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ga[8];?></br></br></td>
                </tr>
              </tbody>
            </table></td>
            <td width="103" valign="top"><table width="100" cellspacing="0" border="1">
              <tbody>
                <tr>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">FUMA ACT.</td>
                  <td bgcolor="#<?php if ($row_ga[9] == 'SI') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ga[9];?></br></br></td>
                </tr>
                <tr>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">FUMA PAS.</td>
                  <td bgcolor="#<?php if ($row_ga[10] == 'SI') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ga[10];?></br></br></td>
                </tr>
                <tr>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">DROGAS</td>
                  <td bgcolor="#<?php if ($row_ga[11] == 'SI') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ga[11];?></br></br></td>
                </tr>
                <tr>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">ALCOHOL</td>
                  <td bgcolor="#<?php if ($row_ga[12] == 'SI') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ga[12];?></br></br></td>
                </tr>
                <tr>
                  <td bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">VIOLENCIA</td>
                  <td bgcolor="#<?php if ($row_ga[13] == 'SI') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ga[13];?></br></br></td>
                </tr>
              </tbody>
            </table></td>
            <td width="118" valign="top"><table width="100" cellspacing="0" border="1">
              <tbody>
                <tr>
                  <td colspan="2"  bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">ANTIRUBEOLA</td>
                  </tr>
                <tr>
                  <td colspan="2" bgcolor="#<?php if ($row_ga[14] == '1') { echo 'FFFFFF'; } else { echo 'FFFF00'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;">
                  </br>
                  <?php 
                    $sql_ar = "SELECT idantirubeola, antirubeola FROM antirubeola WHERE idantirubeola='$row_ga[14]'";
                    $result_ar = mysqli_query($link,$sql_ar);
                    $row_ar = mysqli_fetch_array($result_ar);        
                    echo $row_ar[1];?>
                </br></br></td>
                  </tr>
                <tr>
                  <td colspan="2"  bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">ANTITETANICA</td>
                  </tr>

                <tr>
                  <td colspan="2"  bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">vigente</td>
                </tr>
                <tr>
                  <td colspan="2" bgcolor="#<?php if ($row_ga[15] == 'NO') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ga[15];?></br></br></td>
                </tr>
                <tr>
                  <td colspan="2" bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">DOSIS</td>
                </tr>

                <tr>
                  <td width="58"  bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">mes gestacion</td>
                  <td width="54" style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ga[16];?></br></br></td>
                </tr>
              </tbody>
            </table></td>
            <td width="134" valign="top"><table width="100" cellspacing="0" border="1">
              <tbody>
                <tr>
                  <td  bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">EX NORMAL</td>
                </tr>
                <tr>
                  <td  bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">ODONT.</td>
                </tr>
                <tr>
                  <td bgcolor="#<?php if ($row_ga[17] == 'NO') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ga[17];?></br></br></td>
                </tr>
                <tr>
                  <td  bgcolor="#cbddf4" style="font-family: Arial; font-size: 12px; text-align: center;">MAMAS</td>
                </tr>
                <tr>
                  <td bgcolor="#<?php if ($row_ga[18] == 'NO') { echo 'FFFF00'; } else { echo 'FFFFFF'; } ?>" style="font-family: Arial; font-size: 12px; text-align: center;"></br><?php echo $row_ga[18];?></br></br></td>
                </tr>
              </tbody>
            </table></td>
          </tr>
    <!--      <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>  --->
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