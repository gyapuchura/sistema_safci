<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		  = date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");

$idcarpeta_familiar_ss = $_GET['idcarpeta_familiar']; 

$sql_cf =" SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.codigo, ubicacion_cf.iddepartamento, ubicacion_cf.idred_salud, ubicacion_cf.idmunicipio, ubicacion_cf.idestablecimiento_salud, ";
$sql_cf.=" ubicacion_cf.idarea_influencia, carpeta_familiar.fecha_apertura, carpeta_familiar.familia, ubicacion_cf.avenida_calle, ubicacion_cf.no_puerta, ubicacion_cf.nombre_edificio, ";
$sql_cf.=" ubicacion_cf.latitud, ubicacion_cf.longitud, ubicacion_cf.altura, carpeta_familiar.fecha_registro, carpeta_familiar.hora_registro ";
$sql_cf.=" FROM carpeta_familiar, ubicacion_cf WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_cf.=" AND ubicacion_cf.ubicacion_actual='SI' AND carpeta_familiar.idcarpeta_familiar='$idcarpeta_familiar_ss' ";
$result_cf = mysqli_query($link,$sql_cf);
$row_cf = mysqli_fetch_array($result_cf);

$sql_dep = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$row_cf[2]' ";
$result_dep = mysqli_query($link,$sql_dep);
$row_dep = mysqli_fetch_array($result_dep);

$sql_mun = " SELECT provincias.idprovincia, provincias.provincia, municipios.municipio FROM provincias, municipios WHERE municipios.idprovincia=provincias.idprovincia AND  municipios.idmunicipio='$row_cf[4]' ";
$result_mun = mysqli_query($link,$sql_mun);
$row_mun = mysqli_fetch_array($result_mun);

$sql_es = " SELECT idestablecimiento_salud, establecimiento_salud, codigo_establecimiento FROM establecimiento_salud WHERE idestablecimiento_salud = '$row_cf[5]'";
$result_es = mysqli_query($link,$sql_es);
$row_es = mysqli_fetch_array($result_es);

$sql_ar = " SELECT area_influencia.idarea_influencia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia FROM area_influencia, tipo_area_influencia, establecimiento_salud ";
$sql_ar.= " WHERE area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND area_influencia.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
$sql_ar.= " AND area_influencia.idarea_influencia='$row_cf[6]' ";
$result_ar = mysqli_query($link,$sql_ar);
$row_ar = mysqli_fetch_array($result_ar);
        
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>

<!-------------- 1ra Pagina de la Carpeta Familiar ------------->


<table width="1200" border="0" align="center">
  <tbody>
    <tr>
      <td width="296" align="center"><img src="../implementacion_safci/mds_logo.jpg" width="363" height="104" alt=""/></td>
      <td width="586" align="center"><strong style="font-family: arial; font-size: 36px; color: #503B92;">CARPETA FAMILIAR</strong></br>
      <strong style="font-family: arial; font-size: 24px; color: #503B92;"><?php echo $row_cf[1]; ?></strong></td>
      <td width="296" align="center"><img src="../implementacion_safci/logo_safci_doc.png" width="179" height="117" alt=""/></td>
    </tr>
    <tr>
      <td colspan="3"><table width="1200" border="1" cellpadding="1" cellspacing="0">
        <tbody>
          <tr>
            <td style="font-family: arial; font-size: 12px; color: #503B92;">Código Establecimiento: <?php echo $row_es[2];?> - <?php echo $row_es[1];?></td>
            <td style="font-family: arial; font-size: 12px; color: #503B92;">Código Carpeta Familiar: <?php echo $row_cf[1]; ?></td>
            <td style="color: #503B92; font-family: arial; font-size: 12px;">Fecha de Apertura: 
                <?php 
                $fecha_cf = explode('-',$row_cf[7]);
                $fecha_reg = $fecha_cf[2].'/'.$fecha_cf[1].'/'.$fecha_cf[0];
                echo $fecha_reg;?></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="3"><table width="1200" border="1" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td width="207" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 12px;"><strong>I. DATOS PERSONALES</strong></td>
            <td width="268" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 12px;"><strong>II. UBICACIÓN GEOGRÁFICA Y DE LA VIVIENDA</strong></td>
            <td colspan="3" bgcolor="#503B92" style="color: #FBF9F9">&nbsp;</td>
            <td width="335" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 12px;"><strong>III. ACCESO GEOGRÁFICO AL ESTABLECIMIENTO DE SALUD</strong></td>
          </tr>
          <tr>
            <td rowspan="2" align="center"><strong style="font-family: arial; color: #503B92; font-size: 12px;">1. Familia: <?php echo $row_cf[8];?></strong></td>
            <td><strong style="font-family: arial; color: #503B92; font-size: 12px;">1. Departamento: <?php echo $row_dep[1];?></strong></td>
            <td colspan="3"><strong style="font-family: arial; color: #503B92; font-size: 12px;">5. Avenida/Calle/Carretera/Camino: <?php echo $row_cf[9];?></strong></td>
            <td rowspan="5"><table width="330" border="0" align="center">
              <tbody>
                <tr>
                  <td width="121" style="font-family: Arial; color: #503B92; font-size: 10px; text-align: center;">MEDIO DE TRANSPORTE</td>
                  <td width="109" style="font-size: 10px; font-family: Arial; color: #503B92; text-align: center;">TIEMPO EMPLEADO<br>
                    HH:MM</td>
                  <td width="86" style="color: #503B92; font-family: Arial; font-size: 10px; text-align: center;">DISTANCIA [km]</td>
                </tr>
              <?php
              $numero=1;
              $sql5 =" SELECT transporte_cf.idtransporte_cf, transporte.transporte, tiempo, distancia FROM transporte_cf, transporte ";
              $sql5.=" WHERE transporte_cf.idtransporte=transporte.idtransporte AND transporte_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ";
              $result5 = mysqli_query($link,$sql5);
              if ($row5 = mysqli_fetch_array($result5)){
              mysqli_field_seek($result5,0);
              while ($field5 = mysqli_fetch_field($result5)){
              } do { 
              ?>
                <tr>
                  <td align="center"><strong style="font-family: Arial; font-size: 10px; color: #503B92;"><?php echo $row5[1];?></strong></td>
                  <td align="center"><strong style="font-family: Arial; font-size: 10px; color: #503B92;"><?php echo $row5[2];?></strong></td>
                  <td align="center"><strong style="font-family: Arial; font-size: 10px; color: #503B92;"><?php echo $row5[3];?></strong></td>
                </tr>
              <?php
                $numero=$numero+1;
                }
                while ($row5 = mysqli_fetch_array($result5));
                } else {
                }
              ?>
              </tbody>
            </table></td>
          </tr>
          <tr>
            <td><strong style="font-family: arial; color: #503B92; font-size: 12px;">2. Provincia: <?php echo $row_mun[1];?></strong></td>
            <td colspan="3"><strong style="font-family: arial; color: #503B92; font-size: 12px;">6. Número de Puerta: <?php echo $row_cf[10];?></strong></td>
            </tr>
          <tr>
            <td rowspan="3"><table width="189" border="0" cellspacing="0" align="center">
              <tbody>
                  <tr>
                    <td width="81"><strong style="font-family: Arial; font-size: 12px; color: #503B92;">2. Idioma: </strong></td>
                    <td width="92">&nbsp;</td>
                  </tr>
                  <?php
                  $numero=1;
                  $sql4 =" SELECT idioma_cf.ididioma_cf, idioma.idioma, origen_idioma.origen_idioma  FROM idioma_cf, idioma, origen_idioma ";
                  $sql4.=" WHERE idioma_cf.ididioma=idioma.ididioma AND idioma_cf.idorigen_idioma=origen_idioma.idorigen_idioma ";
                  $sql4.=" AND idioma_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                  $result4 = mysqli_query($link,$sql4);
                  if ($row4 = mysqli_fetch_array($result4)){
                  mysqli_field_seek($result4,0);
                  while ($field4 = mysqli_fetch_field($result4)){
                  } do { 
                  ?>
                  <tr>
                    <td><strong style="font-family: Arial; font-size: 10px; color: #503B92;"><?php echo $row4[2];?></strong></td>
                    <td><strong style="font-family: Arial; font-size: 10px; color: #503B92;"><?php echo $row4[1];?></strong></td>
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
            <td><strong style="font-family: arial; color: #503B92; font-size: 12px;">3. Municipio: <?php echo $row_mun[2];?></strong></td>
            <td colspan="3"><strong style="font-family: arial; color: #503B92; font-size: 12px;">7. Nombre del edificio, Piso y No. de Departamento: <?php echo $row_cf[11];?></strong></td>
            </tr>
          <tr>
            <td rowspan="2"><p><strong style="font-family: arial; color: #503B92; font-size: 12px;">4. Comunidad/ Barrio/ Zona/ Unidad Vecinal:</br><?php echo $row_ar[1];?> <?php echo $row_ar[2];?></strong></p></td>
            <td width="95" align="center"><strong style="font-family: arial; color: #503B92; font-size: 12px;" >8. Latitud:</strong></td>
            <td width="117" align="center"><strong style="font-family: arial; color: #503B92; font-size: 12px;">9. Longitud:</strong></td>
            <td width="164" align="center"><strong style="font-family: arial; color: #503B92; font-size: 12px;">10. Altura [m.s.n.m.]:</strong></td>
            </tr>
          <tr>
            <td align="center"><strong style="font-family: arial; color: #503B92; font-size: 12px;"><?php echo $row_cf[12];?></strong></td>
            <td align="center"><strong style="font-family: arial; color: #503B92; font-size: 12px;"><?php echo $row_cf[13];?></strong></td>
            <td align="center"><strong style="font-family: arial; color: #503B92; font-size: 12px;"><?php echo $row_cf[14];?></strong></td>
            </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="3"><table width="1200" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td colspan="15" bgcolor="#503B92" style="font-family: Arial; font-size: 12px; color: #FFFFFF;"><strong>IV. IDENTIFICACIÓN DE LOS INTEGRANTES DE LA FAMILIA</strong></td>
            </tr>
          <tr>
            <td width="22" bgcolor="#EEEFF3"><span style="font-family: Arial; font-size: 12px; color: #503B92;"><strong>Nº</strong></span></td>
            <td width="96" bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><strong>Cédula de  Identidad</strong></td>
            <td width="110" bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><strong>Primer Apellido</strong></strong></td>
            <td width="114" bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><strong>Segundo Apellido</strong></td>
            <td width="119" bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><strong>Nombre(s)</strong></td>
            <td width="115" bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><strong>Parentesco</strong></strong></td>
            <td width="61" bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><strong>Sexo</strong></td>
            <td width="77" bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><strong>Fecha de<br>Nacimiento</strong></td>
            <td width="33" bgcolor="#EEEFF3" style="font-size: 12px; color: #503B92; font-family: Arial; text-align: center;"><strong>Edad</strong></td>
            <td width="78" bgcolor="#EEEFF3" style="font-size: 12px; color: #503B92; font-family: Arial; text-align: center;"><strong>Auto Pertenencia Cultural</strong></td>
            <td width="62" bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><strong>Estado Civil</strong></td>
            <td width="64" bgcolor="#EEEFF3" style="text-align: center; font-family: Arial; font-size: 12px; color: #503B92;"><strong>Nivel de Instrucción</strong></td>
            <td width="65" bgcolor="#EEEFF3" style="text-align: center; font-family: Arial; font-size: 12px; color: #503B92;"><strong>Profesión</strong></td>
            <td width="61" bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><strong>Ocupación</strong></td>
            <td width="61" bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><strong>Contribuye<br>al<br>Sustento<br>Familiar</strong></td>
            </tr>
            <?php
              $numero=1;
              $sql4 =" SELECT integrante_cf.idintegrante_cf, nombre.ci, nombre.complemento, nombre.paterno, nombre.materno, nombre.nombre, ";
              $sql4.=" parentesco.parentesco, genero.genero, nombre.fecha_nac, integrante_cf.edad, nacion.nacion, integrante_cf.estado, integrante_cf.idnombre, nombre.idgenero FROM integrante_cf, nombre, parentesco, genero, nacion ";
              $sql4.=" WHERE integrante_cf.idnombre=nombre.idnombre AND integrante_cf.idparentesco=parentesco.idparentesco AND integrante_cf.idnacion=nacion.idnacion ";
              $sql4.=" AND nombre.idgenero=genero.idgenero AND integrante_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ORDER BY integrante_cf.edad DESC ";
              $result4 = mysqli_query($link,$sql4);
              if ($row4 = mysqli_fetch_array($result4)){
              mysqli_field_seek($result4,0);
              while ($field4 = mysqli_fetch_field($result4)){
              } do { 

                $sql5 =" SELECT integrante_datos_cf.idintegrante_datos_cf, estado_civil.estado_civil, nivel_instruccion.nivel_instruccion, profesion.profesion, integrante_datos_cf.ocupacion, contribuye_cf.contribuye_cf ";
                $sql5.=" FROM integrante_datos_cf, estado_civil, nivel_instruccion, profesion, contribuye_cf WHERE integrante_datos_cf.idestado_civil=estado_civil.idestado_civil ";
                $sql5.=" AND integrante_datos_cf.idnivel_instruccion=nivel_instruccion.idnivel_instruccion AND integrante_datos_cf.idprofesion=profesion.idprofesion AND integrante_datos_cf.idcontribuye_cf=contribuye_cf.idcontribuye_cf ";
                $sql5.=" AND integrante_datos_cf.idintegrante_cf='$row4[0]' ORDER BY integrante_datos_cf.idintegrante_datos_cf DESC LIMIT 1";
                $result5 = mysqli_query($link,$sql5);
                $row5 = mysqli_fetch_array($result5)
              ?>
          <tr>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $numero;?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row4[1];?> <?php echo $row4[2];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row4[3];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row4[4];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row4[5];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row4[6];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row4[7];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php 
                        $fecha_s = explode('-',$row4[8]);
                        $fecha_n = $fecha_s[2].'/'.$fecha_s[1].'/'.$fecha_s[0];
                        echo $fecha_n;?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row4[9];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row4[10];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row5[1];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row5[2];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row5[3];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row5[4];?></td>
            <td style="font-family: Arial; font-size: 12px; color: #503B92; text-align: center;"><?php echo $row5[5];?></td>
            </tr>
            <?php
                $numero=$numero+1;
                }
                while ($row4 = mysqli_fetch_array($result4));
                } else {
                }
            ?>
          <tr>
            <td colspan="6" bgcolor="#EEEFF3" style="font-family: Arial; font-size: 12px; color: #503B92; text-align: left;"><strong>TOTAL</strong></td>
            <td colspan="4" bgcolor="#EEEFF3">&nbsp;</td>
            <td colspan="2" bgcolor="#EEEFF3">&nbsp;</td>
            <td bgcolor="#EEEFF3">&nbsp;</td>
            <td bgcolor="#EEEFF3">&nbsp;</td>
            <td bgcolor="#EEEFF3">&nbsp;</td>
            </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>

<!--------------- 2da pagina Carpeta Familiar ------------>


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

    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>

<!------ 3ra pagina Carpeta Familiar  ---------->

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
                                    echo " => ".$rowa[0]." - ";

                                    $sumatoria = $rowa[0];
                                        if ($sumatoria <= 7 ) {
                                            $sql5 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='1'  ";
                                            $result5 = mysqli_query($link,$sql5);
                                            $row5 = mysqli_fetch_array($result5);
                                            echo $row5[0];
                                        } else {
                                            if ($sumatoria <= 11 ) {
                                                $sql6 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='2' ";
                                                $result6 = mysqli_query($link,$sql6);
                                                $row6 = mysqli_fetch_array($result6);
                                                echo $row6[0];
                                            } else {
                                                if ($sumatoria <= 17) {
                                                        $sql7 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='3' ";
                                                        $result7 = mysqli_query($link,$sql7);
                                                        $row7 = mysqli_fetch_array($result7);
                                                        echo $row7[0];
                                                } else {
                                                    if ($sumatoria <= 24) {
                                                            $sql8 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='4' ";
                                                            $result8 = mysqli_query($link,$sql8);
                                                            $row8 = mysqli_fetch_array($result8);
                                                            echo $row8[0];
                                                    } else { 
                                                        if ($sumatoria <= 35) {
                                                                $sql9 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='5' ";
                                                                $result9 = mysqli_query($link,$sql9);
                                                                $row9 = mysqli_fetch_array($result9);
                                                                echo $row9[0];
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
                                        $sql5 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='1'  ";
                                        $result5 = mysqli_query($link,$sql5);
                                        $row5 = mysqli_fetch_array($result5);
                                        echo $row5[0];
                                    } else {
                                        if ($sumatoria <= 31 ) {
                                            $sql6 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='2' ";
                                            $result6 = mysqli_query($link,$sql6);
                                            $row6 = mysqli_fetch_array($result6);
                                            echo $row6[0];
                                        } else {
                                            if ($sumatoria <= 41) {
                                                    $sql7 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='3' ";
                                                    $result7 = mysqli_query($link,$sql7);
                                                    $row7 = mysqli_fetch_array($result7);
                                                    echo $row7[0];
                                            } else {
                                                if ($sumatoria <= 56) {
                                                        $sql8 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='4' ";
                                                        $result8 = mysqli_query($link,$sql8);
                                                        $row8 = mysqli_fetch_array($result8);
                                                        echo $row8[0];
                                                } else { 
                                                    if ($sumatoria <= 80) {
                                                            $sql9 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='5' ";
                                                            $result9 = mysqli_query($link,$sql9);
                                                            $row9 = mysqli_fetch_array($result9);
                                                            echo $row9[0];
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
                                        $sql5 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='1'  ";
                                        $result5 = mysqli_query($link,$sql5);
                                        $row5 = mysqli_fetch_array($result5);
                                        echo $row5[0];
                                    } else {
                                        if ($sumatoria <= 5) {
                                            $sql6 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='2' ";
                                            $result6 = mysqli_query($link,$sql6);
                                            $row6 = mysqli_fetch_array($result6);
                                            echo $row6[0];
                                        } else {
                                            if ($sumatoria <= 9) {
                                                    $sql7 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='3' ";
                                                    $result7 = mysqli_query($link,$sql7);
                                                    $row7 = mysqli_fetch_array($result7);
                                                    echo $row7[0];
                                            } else {
                                                if ($sumatoria <= 11) {
                                                        $sql8 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='4' ";
                                                        $result8 = mysqli_query($link,$sql8);
                                                        $row8 = mysqli_fetch_array($result8);
                                                        echo $row8[0];
                                                } else { 
                                                    if ($sumatoria <= 15) {
                                                            $sql9 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='5' ";
                                                            $result9 = mysqli_query($link,$sql9);
                                                            $row9 = mysqli_fetch_array($result9);
                                                            echo $row9[0];
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
                                        $sql5 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='1'  ";
                                        $result5 = mysqli_query($link,$sql5);
                                        $row5 = mysqli_fetch_array($result5);
                                        echo $row5[0];
                                    } else {
                                        if ($alimentaria <= 13) {
                                            $sql6 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='2' ";
                                            $result6 = mysqli_query($link,$sql6);
                                            $row6 = mysqli_fetch_array($result6);
                                            echo $row6[0];
                                        } else {
                                            if ($alimentaria <= 21) {
                                                    $sql7 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='3' ";
                                                    $result7 = mysqli_query($link,$sql7);
                                                    $row7 = mysqli_fetch_array($result7);
                                                    echo $row7[0];
                                            } else {
                                                if ($alimentaria <= 30) {
                                                        $sql8 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='4' ";
                                                        $result8 = mysqli_query($link,$sql8);
                                                        $row8 = mysqli_fetch_array($result8);
                                                        echo $row8[0];
                                                } else { 
                                                    if ($alimentaria <= 35) {
                                                            $sql9 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='5' ";
                                                            $result9 = mysqli_query($link,$sql9);
                                                            $row9 = mysqli_fetch_array($result9);
                                                            echo $row9[0];
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
                                    $sql5 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='1'  ";
                                    $result5 = mysqli_query($link,$sql5);
                                    $row5 = mysqli_fetch_array($result5);
                                    echo " => ".$riesgo_total." .- ".$row5[0];
                                } else {
                                    if ($riesgo_total <= 60) {
                                        $sql6 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='2' ";
                                        $result6 = mysqli_query($link,$sql6);
                                        $row6 = mysqli_fetch_array($result6);
                                        echo " => ".$riesgo_total." .- ".$row6[0];
                                    } else {
                                        if ($riesgo_total <= 88) {
                                                $sql7 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='3' ";
                                                $result7 = mysqli_query($link,$sql7);
                                                $row7 = mysqli_fetch_array($result7);
                                                echo " => ".$riesgo_total." .- ".$row7[0];
                                        } else {
                                            if ($riesgo_total <= 121) {
                                                    $sql8 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='4' ";
                                                    $result8 = mysqli_query($link,$sql8);
                                                    $row8 = mysqli_fetch_array($result8);
                                                    echo " => ".$riesgo_total." .- ".$row8[0];
                                            } else { 
                                                if ($riesgo_total <= 165) {
                                                        $sql9 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='5' ";
                                                        $result9 = mysqli_query($link,$sql9);
                                                        $row9 = mysqli_fetch_array($result9);
                                                        echo " => ".$riesgo_total." .- ".$row9[0];
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

            <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
          </tbody>
        </table>

<!--------------- 4ta pagina Carpeta Familiar ------------------>

<table width="1200" border="0" align="center">
  <tbody>
    <tr>
      <td width="378">&nbsp;</td>
      <td width="422" style="text-align: center; font-family: Arial; font-size: 24px; color: #503B92;"><strong>COMPORTAMIENTO FAMILIAR</strong></td>
      <td width="386">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><table width="1200" border="0">
        <tbody>
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
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
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
