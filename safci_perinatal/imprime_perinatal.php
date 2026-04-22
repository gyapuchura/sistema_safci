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

$sql_d ="  ";
$sql_d.="  ";
$sql_d.="  ";
$result_d=mysqli_query($link,$sql_d);
$row_d=mysqli_fetch_array($result_d);

$sql4 =" SELECT integrante_datos_cf.idintegrante_datos_cf, estado_civil.estado_civil, nivel_instruccion.nivel_instruccion, profesion.profesion, integrante_datos_cf.ocupacion, contribuye_cf.contribuye_cf ";
$sql4.=" FROM integrante_datos_cf, estado_civil, nivel_instruccion, profesion, contribuye_cf WHERE integrante_datos_cf.idestado_civil=estado_civil.idestado_civil ";
$sql4.=" AND integrante_datos_cf.idnivel_instruccion=nivel_instruccion.idnivel_instruccion AND integrante_datos_cf.idprofesion=profesion.idprofesion ";
$sql4.=" AND integrante_datos_cf.idcontribuye_cf=contribuye_cf.idcontribuye_cf AND integrante_datos_cf.idintegrante_cf='$idintegrante_cf_ss'";
$result4 = mysqli_query($link,$sql4);
$row4 = mysqli_fetch_array($result4);

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
      <td style="font-family: Arial; font-size: 16px; text-align: center;">&nbsp;</td>
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
                  <td style="font-family: Arial; font-size: 12px;">NOMBRE: <?php echo $row_n[1];?> <?php echo $row_n[2];?> <?php echo $row_n[3];?></td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">DOMICILIO:      .....................ZONA:</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">LOCALIDAD/COMUNIDAD: MUNICIPIO:</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">RED: TELEFONO:</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">IDIOMA HABLADO: LENGUA MATERNA:</td>
                </tr>
              </tbody>
            </table></td>
            <td width="116"><table width="116" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td colspan="3" style="font-family: Arial; font-size: 12px; text-align: center;">FECHA DE NACIMIENTO</td>
                  </tr>
                <tr>
                  <td width="35" style="font-family: Arial; font-size: 12px;">DIA</td>
                  <td width="34" style="font-family: Arial; font-size: 12px;">MES</td>
                  <td width="33" style="font-family: Arial; font-size: 12px;">ANO</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3" style="font-family: Arial; font-size: 12px;">EDAD(anos)</td>
                  </tr>
                <tr>
                  <td colspan="2" bgcolor="#FFFF00">&nbsp;</td>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">&lt;de 15</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td bgcolor="#FFFFFF">&nbsp;</td>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">&gt;de 35</td>
                </tr>
              </tbody>
            </table></td>
            <td width="133" valign="top"><table width="132" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td width="126" style="font-family: Arial; font-size: 12px;">AUTO-IDENTIFICACION</td>
                  </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">ALFABETA</td>
                  </tr>
                <tr>
                  <td bgcolor="#FFFF00">&nbsp;</td>
                  </tr>
              </tbody>
            </table></td>
            <td width="69" valign="top"><table width="69" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td width="71" style="font-family: Arial; font-size: 12px; text-align: center;">ESTUDIOS</td>
                </tr>
                <tr>
                  <td bgcolor="#ffff00" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">anos en el mayor nivel</td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFff">&nbsp;</td>
                </tr>
              </tbody>
            </table></td>
            <td width="71" valign="top"><table width="71" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">ESTADO CIVIL</td>
                </tr>
                <tr>
                  <td bgcolor="#ffff00" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">vive sola</td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFff">&nbsp;</td>
                </tr>
              </tbody>
            </table></td>
            <td width="165" valign="top"><table width="168" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td width="67" style="font-family: Arial; font-size: 12px; text-align: rigth;">CONTROL PRENATAL EN:</td>
                  <td width="73">&nbsp;</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: rigth;">PARTO EN:</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: rigth;">C. IDENT.</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: rigth;">F. Nac. N° Reg.</td>
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
            <td colspan="3">&nbsp;</td>
            </tr>
          <tr>
            <td width="118" style="font-family: Arial; font-size: 12px; text-align: center;">FAMILIARES</td>
            <td colspan="2" style="font-family: Arial; font-size: 12px; text-align: center;">PERSONALES</td>
            <td colspan="3" style="font-family: Arial; font-size: 12px; text-align: center;">OBSTETRICOS</td>
            </tr>
          <tr>
            <td><table width="118" border="0">
              <tbody>
                <tr>
                  <td width="89" style="font-family: Arial; font-size: 12px; text-align: center;">ANTECEDENTE</td>
                  <td width="13" bgcolor="#FFFF00">&nbsp;</td>
                </tr>
              </tbody>
            </table></td>
            <td width="118"><table width="118" border="0">
              <tbody>
                <tr>
                  <td width="89" style="font-family: Arial; font-size: 12px; text-align: center;">ANTECEDENTE</td>
                  <td width="13" bgcolor="#FFFF00">&nbsp;</td>
                </tr>
              </tbody>
            </table></td>
            <td width="118"><table width="118" border="0">
              <tbody>
                <tr>
                  <td width="89" style="font-family: Arial; font-size: 12px; text-align: center;">ANTECEDENTE</td>
                  <td width="13" bgcolor="#FFFF00">&nbsp;</td>
                </tr>
              </tbody>
            </table></td>
            <td width="85" valign="top"><table width="100" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">ULTIMO PREVIO</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">Antecedente de gemelos</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  </tr>
              </tbody>
            </table></td>
            <td width="242" valign="top"><table width="250" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td width="67" style="font-family: Arial; font-size: 12px; text-align: center;">gestas previas</td>
                  <td width="87" style="font-family: Arial; font-size: 12px; text-align: center;">abortos</td>
                  <td width="68" style="font-family: Arial; font-size: 12px; text-align: center;">vaginales</td>
                  <td width="9" style="font-family: Arial; font-size: 12px; text-align: center;">nacidos vivos</td>
                  <td width="9" style="font-family: Arial; font-size: 12px; text-align: center;">muertos 1° Sem.</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td bgcolor="#ffff00">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td bgcolor="#ffff00">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">partos</td>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">cesareas</td>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">viven</td>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">despues 1° Sem.</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td bgcolor="#ffff00">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td bgcolor="#ffff00">&nbsp;</td>
                </tr>
              </tbody>
            </table></td>
            <td width="193" valign="top"><table width="185" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td colspan="3" style="font-family: Arial; font-size: 12px; text-align: center;">FIN DE EMBARAZO ANTERIOR</td>
                  </tr>
                <tr>
                  <td width="61" style="font-family: Arial; font-size: 12px; text-align: center;">dia</td>
                  <td width="60" style="font-family: Arial; font-size: 12px; text-align: center;">mes</td>
                  <td width="50" style="font-family: Arial; font-size: 12px; text-align: center;">ano</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" style="font-family: Arial; font-size: 12px; text-align: center;">menos de 1 ano</td>
                  <td bgcolor="#ffff00">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" style="font-family: Arial; font-size: 12px; text-align: center;">EMBARAZO PLANEADO</td>
                  <td bgcolor="#ffff00">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" style="font-family: Arial; font-size: 12px; text-align: center;">FRACASO METODO ANTICONCEPTIVO</td>
                  <td bgcolor="#ffff00">&nbsp;</td>
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
            <td colspan="2" bgcolor="#020202" style="font-size: 12px; font-family: Arial; color: #FFFFFF; text-align: center;">2. GESTACION ACTUAL</td>
            <td colspan="6">&nbsp;</td>
            </tr>
          <tr>
            <td width="100" valign="top"><table width="100" border="0">
              <tbody>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">PESO ANTERIOR</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
                </tr>
              </tbody>
            </table></td>
            <td width="100" valign="top"><table width="100" border="0">
              <tbody>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">TALLA[cm]</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
                </tr>
              </tbody>
            </table></td>
            <td width="100" valign="top"><table width="100" border="0">
              <tbody>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">IMC inicial</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">E - S - N - O</td>
                </tr>
                <tr>
                  <td bgcolor="#FFFF00" style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
                </tr>
              </tbody>
            </table></td>
            <td width="100" valign="top"><table width="150" border="0">
              <tbody>
                <tr>
                  <td colspan="3" style="font-family: Arial; font-size: 12px; text-align: center;">F.U.M.</td>
                  </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">dia</td>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">mes</td>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">ano</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3" style="font-family: Arial; font-size: 12px; text-align: center;">F.P.P.</td>
                  </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">dia</td>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">mes</td>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">ano</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </tbody>
            </table></td>
            <td width="111" valign="top"><table width="100" border="0">
              <tbody>
                <tr>
                  <td colspan="2" style="font-family: Arial; font-size: 12px; text-align: center;">EG. CONFIABLE por:</td>
                  </tr>
                <tr>
                  <td width="43" style="font-family: Arial; font-size: 12px; text-align: center;">F.U.M.</td>
                  <td width="47" style="font-family: Arial; font-size: 12px; text-align: center;">Eco&lt;20s</td>
                </tr>
                <tr>
                  <td bgcolor="#ffff00">&nbsp;</td>
                  <td bgcolor="#ffff00">&nbsp;</td>
                </tr>
              </tbody>
            </table></td>
            <td width="103" valign="top"><table width="150" border="0">
              <tbody>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">FUMA ACT.</td>
                  <td bgcolor="#FFFF00" style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">FUMA PAS.</td>
                  <td bgcolor="#FFFF00" style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">DROGAS</td>
                  <td bgcolor="#FFFF00" style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">ALCOHOL</td>
                  <td bgcolor="#FFFF00" style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px; text-align: center;">VIOLENCIA</td>
                  <td bgcolor="#FFFF00" style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
                </tr>
              </tbody>
            </table></td>
            <td width="118" valign="top"><table width="100" border="0">
              <tbody>
                <tr>
                  <td colspan="2"  style="font-family: Arial; font-size: 12px; text-align: center;">ANTIRUBEOLA</td>
                  </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                  </tr>
                <tr>
                  <td colspan="2"  style="font-family: Arial; font-size: 12px; text-align: center;">ANTITETANICA</td>
                  </tr>
                <tr>
                  <td colspan="2"  style="font-family: Arial; font-size: 12px; text-align: center;">vigente</td>
                  </tr>
                <tr>
                  <td colspan="2" style="font-family: Arial; font-size: 12px; text-align: center;">DOSIS</td>
                  </tr>
                <tr>
                  <td width="58"  style="font-family: Arial; font-size: 12px; text-align: center;">mes gestacion</td>
                  <td width="54">&nbsp;</td>
                </tr>
              </tbody>
            </table></td>
            <td width="134" valign="top"><table width="100" border="0">
              <tbody>
                <tr>
                  <td  style="font-family: Arial; font-size: 12px; text-align: center;">EX NORMAL</td>
                </tr>
                <tr>
                  <td  style="font-family: Arial; font-size: 12px; text-align: center;">ODONT.</td>
                </tr>
                <tr>
                  <td bgcolor="#FFFF00">&nbsp;</td>
                </tr>
                <tr>
                  <td  style="font-family: Arial; font-size: 12px; text-align: center;">MAMAS</td>
                </tr>
                <tr>
                  <td bgcolor="#FFFF00">&nbsp;</td>
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