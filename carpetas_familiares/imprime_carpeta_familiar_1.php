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
            <td rowspan="5" style="color: #503B92; font-family: Arial; font-size: 12px; text-align: center;" ><table width="330" border="0" align="center">
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
            </table>
              </br>
              </br>

            <a href="imprime_mapa_familiar.php?idcarpeta_familiar=<?php echo $idcarpeta_familiar_ss;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=800,height=700,top=50, left=600, scrollbars=YES'); return false;">
            MAPA DE UBICACIÓN</a>
          </td>
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
      <td style="font-family: Arial; font-size: 14px; color: #503B92; text-align: center;">
      <a href="imprime_carpeta_familiar_2.php?idcarpeta_familiar=<?php echo $idcarpeta_familiar_ss;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1400,height=800,top=50, left=200, scrollbars=YES'); return false;">
      VER SALUD DE LOS INTEGRANTES</a>
      </td>
      <td style="font-family: Arial; font-size: 14px; color: #503B92; text-align: center;">
      <a href="imprime_carpeta_familiar_3.php?idcarpeta_familiar=<?php echo $idcarpeta_familiar_ss;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1400,height=800,top=50, left=200, scrollbars=YES'); return false;">
      VER DETERMINANTES DE LA SALUD</a>
      </td>
      <td style="font-family: Arial; font-size: 14px; color: #503B92; text-align: center;">
      <a href="imprime_carpeta_familiar_4.php?idcarpeta_familiar=<?php echo $idcarpeta_familiar_ss;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1400,height=800,top=50, left=200, scrollbars=YES'); return false;">
      VER COMPORTAMIENTO FAMILIAR</a>
      </td>
    </tr>
  </tbody>
</table>
</body>
</html>
