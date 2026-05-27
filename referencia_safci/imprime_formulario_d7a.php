<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");

$idreferencia_hc_ss = $_GET['idreferencia_hc'];

$sql_ref =" SELECT idreferencia_hc, iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idatencion_psafci, codigo, idnombre, discapacidad,";
$sql_ref.=" nombre_acompanante, idparentesco_acomp, celular_acompanante, tel_establecimiento, estuvo_internado, dias_internacion, resumen_anamnesis, especificacion_hallazgos, ";
$sql_ref.=" tratamiento_ref, observaciones_ref, idconsentimiento, idestablecimiento_receptor, idmotivo_referencia, idespecialidad_medica, ";
$sql_ref.=" dias_internacion_ref, evolucion_complicacion, examenes_complementarios_egreso, otros_examenes, tratamientos_realizados, recomendaciones_paciente, "; 
$sql_ref.=" otros_anexos, observaciones_recomendaciones, contacto_eess_cref, por_telesalud, contacto_contraref, nombre_acompanante_cref, ";
$sql_ref.=" fecha_registro, hora_registro, idusuario, tel_establecimiento_cref FROM referencia_hc WHERE idreferencia_hc='$idreferencia_hc_ss' ";
$result_ref=mysqli_query($link,$sql_ref);
$row_ref=mysqli_fetch_array($result_ref);

$sql_es =" SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, nivel_establecimiento.nivel_establecimiento, tipo_establecimiento.tipo_establecimiento,";
$sql_es.=" subsector_salud.subsector_salud, municipios.municipio, departamento.departamento FROM establecimiento_salud, subsector_salud, nivel_establecimiento, tipo_establecimiento, departamento, municipios ";
$sql_es.=" WHERE establecimiento_salud.idsubsector_salud=subsector_salud.idsubsector_salud AND establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento AND establecimiento_salud.iddepartamento=departamento.iddepartamento ";
$sql_es.=" AND establecimiento_salud.idmunicipio=municipios.idmunicipio AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento AND establecimiento_salud.idestablecimiento_salud='$row_ref[20]'";
$result_es = mysqli_query($link,$sql_es);
$row_es = mysqli_fetch_array($result_es);

$sql_n =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$row_ref[7]' ";
$result_n=mysqli_query($link,$sql_n);
$row_n=mysqli_fetch_array($result_n);

$sql_ai =" SELECT idatencion_psafci, edad FROM atencion_psafci WHERE idatencion_psafci='$row_ref[5]' ";
$result_ai=mysqli_query($link,$sql_ai);
$row_ai=mysqli_fetch_array($result_ai);

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

    $edad = ($ano-$anonaz);  
        

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>FORMULARIO DE REFERENCIA - D7a</title>
</head>

<body>

<table width="900" border="0" align="center">
  <tbody>
    <tr>
      <td colspan="3"><table width="902" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td colspan="12" bgcolor="#ffffff" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;"><table width="900" border="0">
              <tbody>
                <tr>
                  <td width="239" style="text-align: center"><img src="../implementacion_safci/mds_logo.jpg" width="193" height="85" alt=""/></td>
                  <td width="471" align="center">
                    <strong style="font-family: Arial; font-size: 16px; color: #000000; text-align: right;">FORMULARIO CONTRARREFERENCIA D7-a</strong></br>
                    <strong style="font-family: Arial; font-size: 16px; color: #000000; text-align: right;"><?php echo $row_ref[6]; ?></strong></td>
                  <td width="217">&nbsp;</td>
                  </tr>
                </tbody>
              </table></td>
          </tr>
          <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;"><strong>DATOS DEL ESTABLECIMIENTO DE SALUD REFERENTE (C1)</strong></td>
            </tr>
          <tr>
            <td colspan="12" bgcolor="#FFFFFF" style="text-align: center; font-family: Arial; font-size: 12px; color: #000000;"><table width="900" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td colspan="2">NOMBRE DEL ESTABLECIMIENTO</td>
                  <td colspan="2"><?php echo $row_es[1]?></td>
                  <td>SERVICIO:</td>
                  <td>
                  <?php 
                  $sql_red =" SELECT idespecialidad_medica, especialidad_medica FROM especialidad_medica WHERE idespecialidad_medica='$row_ref[22]' ";
                  $result_red=mysqli_query($link,$sql_red);
                  $row_red=mysqli_fetch_array($result_red);
                  echo $row_red[1];
                  ?>
                  </td>
                  <td colspan="2">RED DE SALUD</td>
                  <td colspan="2">
                  <?php 
                  $sql_red =" SELECT idred_salud, red_salud FROM red_salud WHERE idred_salud='$row_ref[2]' ";
                  $result_red=mysqli_query($link,$sql_red);
                  $row_red=mysqli_fetch_array($result_red);
                  echo $row_red[1];
                  ?>
                  </td>
                  </tr>
                <tr>
                  <td>MUNICIPIO</td>
                  <td><?php echo $row_es[5];?></td>
                  <td>TELÉFONO DE CONTACTO</td>
                  <td><?php echo $row_ref[38];?></td>
                  <td>FECHA:</td>
                  <td><?php echo $row_es[1];?></td>
                  <td>HORA:</td>
                  <td><?php echo $row_es[1];?></td>
                  <td>NIVEL DE ESTABLECIMIENTO</td>
                  <td><?php echo $row_es[1];?></td>
                </tr>
              </tbody>
            </table></td>
          </tr>
          <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; font-family: Arial; font-size: 12px; color: #FFFFFF;"><strong>IDENTIFICACION DEL PACIENTE (C2)</strong></td>
          </tr>
          <tr>
            <td colspan="12" align="center" valign="top" style="font-family: Arial; font-size: 12px;"><table width="900" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td width="84">NOMBRES:</td>
                  <td colspan="2"><?php echo $row_n[1];?></td>
                  <td width="92">APELLIDOS</td>
                  <td colspan="3"><?php echo $row_n[2];?> <?php echo $row_n[3];?></td>
                  <td width="59">C.I.:</td>
                  <td width="111"><?php echo $row_n[4];?></td>
                </tr>
                <?php
                $sql_di =" SELECT ubicacion_cf.avenida_calle, ubicacion_cf.no_puerta, integrante_cf.celular FROM ubicacion_cf, integrante_cf, carpeta_familiar  ";
                $sql_di.=" WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                $sql_di.=" AND ubicacion_cf.ubicacion_actual='SI' AND integrante_cf.idnombre='$row_n[0]' ";
                $result_di=mysqli_query($link,$sql_di);
                $row_di=mysqli_fetch_array($result_di);
                ?>
                <tr>
                  <td>DOMICILIO:</td>
                  <td colspan="2"><?php echo $row_di[0];?> <?php echo $row_di[1];?></td>
                  <td>TELEFONO:</td>
                  <td width="160"><?php echo $row_di[2];?></td>
                  <td width="64">EDAD:</td>
                  <td width="96"><?php echo $row_ai[1];?></td>
                  <td>SEXO:</td>
                  <td>
                  <?php 
                  $sql_gn =" SELECT idgenero, genero FROM genero WHERE idgenero='$row_n[7]' ";
                  $result_gn=mysqli_query($link,$sql_gn);
                  $row_gn=mysqli_fetch_array($result_gn);
                  echo $row_gn[1];
                  ?>
                  </td>
                </tr>

                <?php
                $sql_dc =" SELECT tipo_discapacidad_cf.tipo_discapacidad_cf, nivel_discapacidad_cf.nivel_discapacidad_cf FROM discapacidad_ref, tipo_discapacidad_cf, nivel_discapacidad_cf  ";
                $sql_dc.=" WHERE discapacidad_ref.idtipo_discapacidad=tipo_discapacidad_cf.idtipo_discapacidad_cf AND discapacidad_ref.idnivel_discapacidad=nivel_discapacidad_cf.idnivel_discapacidad_cf ";
                $sql_dc.=" AND discapacidad_ref.idreferencia_hc='$row_ref[0]' ";
                $result_dc=mysqli_query($link,$sql_dc);
                if ($row_dc=mysqli_fetch_array($result_dc)) { ?>
                <tr>
                  <td colspan="2">PERSONA CON DISCAPACIDAD:</td>
                  <td width="91">SI</td>
                  <td>TIPO DE DISCPACIDAD</td>
                  <td colspan="2"><?php echo $row_dc[0] ?></td>
                  <td>GRADO DE DICAPACIDAD:</td>
                  <td colspan="2"><?php echo $row_dc[1] ?></td>
                </tr>                
                <?php } ?>
              </tbody>
            </table></td>
            </tr>

          <?php  
          $sql_ds =" SELECT tipo_discapacidad_cf.tipo_discapacidad_cf, nivel_discapacidad_cf.nivel_discapacidad_cf FROM discapacidad_ref, tipo_discapacidad_cf, nivel_discapacidad_cf ";
          $sql_ds.=" WHERE discapacidad_ref.idtipo_discapacidad=tipo_discapacidad_cf.idtipo_discapacidad_cf AND discapacidad_ref.idnivel_discapacidad=nivel_discapacidad_cf.idnivel_discapacidad_cf ";
          $sql_ds.=" AND discapacidad_ref.idreferencia_hc='$idreferencia_hc_ss' ";
          $result_ds=mysqli_query($link,$sql_ds);
          if ($row_ds=mysqli_fetch_array($result_ds)) {  ?>        
          <?php }  ?>
          <tr>
            <td colspan="12" bgcolor="#466CAD" style="font-size: 12px; text-align: center; color: #FFFFFF; font-family: Arial;"><strong>DATOS CLINICOS DE ALTA (C3)</strong></td>
          </tr>

            <?php
            $sql_sg =" SELECT idsigno_vital_psafci, talla, peso, temperatura, frec_cardiaca, frec_respiratoria, presion_arterial, presion_arterial_d, saturacion, glascow, alergia, ";
            $sql_sg.=" descripcion_alergia, imc FROM signo_vital_psafci WHERE idnombre ='$row_ref[7]' AND idatencion_psafci='$row_ref[5]' ORDER BY idsigno_vital_psafci DESC LIMIT 1 ";
            $result_sg = mysqli_query($link,$sql_sg);
            $row_sg = mysqli_fetch_array($result_sg);
            ?> 

            <tr>
              <td colspan="12" align="center" valign="top" style="font-size: 12px; font-family: Arial; text-align: right;"><table width="900" border="1" cellspacing="0">
                <tbody>
                  <tr>
                    <td width="191">DIAS DE INTERNACION:</td>
                    <td width="65"><?php echo $row_ref[14];?></td>
                    <td width="108">PESO/IMC:</td>
                    <td width="9"><?php echo $row_sg[2];?> <?php echo $row_sg[12];?></td>
                    <td width="23">T°</td>
                    <td width="35"><?php echo $row_sg[3];?> °C</td>
                    <td width="37">P.A.</td>
                    <td width="89"><?php echo $row_sg[6];?>/<?php echo $row_sg[7];?> mmHg</td>
                    <td width="37">F.C.</td>
                    <td width="62"><?php echo $row_sg[4];?> LPM</td>
                    <td width="42">F.R.:</td>
                    <td width="63"><?php echo $row_sg[5];?> CPM</td>
                    <td width="64">% SPO</td>
                    <td width="17"><?php echo $row_sg[8];?> %</td>
                  </tr>
                </tbody>
              </table>  </td>
            </tr>
          <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; font-family: Arial; font-size: 12px; color: #FFFFFF;"><strong>DIAGNÓSTICOS DE INGRESO (C4)</strong></td>
          </tr>

      <?php
        $numero_dg=1;
        $sql_dg =" SELECT diagnostico_presuntivo.diagnostico_presuntivo, patologia.patologia, patologia.cie FROM diagnostico_presuntivo, patologia ";
        $sql_dg.=" WHERE diagnostico_presuntivo.idpatologia=patologia.idpatologia AND diagnostico_presuntivo.idreferencia_hc='$idreferencia_hc_ss' ";
        $result_dg = mysqli_query($link,$sql_dg);
        if ($row_dg = mysqli_fetch_array($result_dg)){
        mysqli_field_seek($result_dg,0);
        while ($field_dg = mysqli_fetch_field($result_dg)){
        } do { ?> 

          <tr>
            <td width="108" style="font-size: 12px; font-family: Arial;"><?php echo $numero_dg;?></td>
            <td colspan="5" style="font-size: 12px; font-family: Arial;"><?php echo $row_dg[0];?></td>
            <td width="28" style="font-size: 12px; font-family: Arial;">CIE-10</td>
            <td width="116"  style="font-size: 12px; font-family: Arial;"><?php echo $row_dg[1];?></td>
            <td width="107" style="font-size: 12px; font-family: Arial;"><?php echo $row_dg[2];?></td>
          </tr>
        <?php
        $numero_dg=$numero_dg+1;
        }
        while ($row_dg = mysqli_fetch_array($result_dg));
        } else {
        }
        ?>  
          
	  
	  <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; font-family: Arial; font-size: 12px; color: #FFFFFF;"><strong>DIAGNÓSTICOS DE EGRESO SEGUN CIE-10 (C5)</strong></td>
          </tr>

      <?php
        $numero_dg=1;
        $sql_dg =" SELECT diagnostico_egreso.diagnostico_egreso, patologia.patologia, patologia.cie FROM diagnostico_egreso, patologia ";
        $sql_dg.=" WHERE diagnostico_egreso.idpatologia=patologia.idpatologia AND diagnostico_egreso.idreferencia_hc='$idreferencia_hc_ss' ";
        $result_dg = mysqli_query($link,$sql_dg);
        if ($row_dg = mysqli_fetch_array($result_dg)){
        mysqli_field_seek($result_dg,0);
        while ($field_dg = mysqli_fetch_field($result_dg)){
        } do { ?> 

          <tr>
            <td width="108" style="font-size: 12px; font-family: Arial;"><?php echo $numero_dg;?>)</td>
            <td colspan="5" style="font-size: 12px; font-family: Arial;"><?php echo $row_dg[0];?></td>
            <td width="28" style="font-size: 12px; font-family: Arial;">CIE-10</td>
            <td width="116"  style="font-size: 12px; font-family: Arial;"><?php echo $row_dg[1];?></td>
            <td width="107" style="font-size: 12px; font-family: Arial;"><?php echo $row_dg[2];?></td>
          </tr>
        <?php
        $numero_dg=$numero_dg+1;
        }
        while ($row_dg = mysqli_fetch_array($result_dg));
        } else {
        }
        ?>  
          <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;">EVOLUCION COMPLICACIONES (C6)</td>
            </tr>
          <tr>
            <td colspan="12" style="font-size: 12px; font-family: Arial;"><p><?php echo $row_ref[24];?></p></td>
            </tr>
                      <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;">EXAMENES COMPLEMENTARIOS DE DIAGNOSTICO (C7)</td>
            </tr>
	  
          <tr>
            <td colspan="12" style="font-size: 12px; font-family: Arial;"><p><?php echo $row_ref[25];?></p></td>
            </tr>
	  <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;">OTROS EXAMENES E INTERCONSULTAS (C8)</td>
            </tr>
	  
          <tr>
            <td colspan="12" style="font-size: 12px; font-family: Arial;"><p><?php echo $row_ref[26];?></p></td>
            </tr>
	  <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;">TRATAMIENTOS REALIZADOS (C9)</td>
            </tr>
	  
          <tr>
            <td colspan="12" style="font-size: 12px; font-family: Arial;"><p><?php echo $row_ref[27];?></p></td>
            </tr>
	  <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;">RECOMENDACIONES PARA EL PACIENTE (C10)</td>
            </tr>
	  
          <tr>
            <td colspan="12" style="font-size: 12px; font-family: Arial;"><p><?php echo $row_ref[28];?></p></td>
            </tr>
	  <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;">OTROS ANEXOS O ESTUDIOS PENDIENTES (C11)</td>
            </tr>
	  
          <tr>
            <td colspan="12" style="font-size: 12px; font-family: Arial;"><p><?php echo $row_ref[29];?></p></td>
            </tr>
	  <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;">OBSERVACIONES / RECOMENDACIONES A LA CONTRAREFERENCIA (C12)</td>
            </tr>
	  
          <tr>
            <td colspan="12" style="font-size: 12px; font-family: Arial;"><p><?php echo $row_ref[30];?></p></td>
          </tr>
          <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;">ESTABLECIMIENTO DE SALUD AL QUE SE REALIZA LA CONTRAREFERENCIA (C13)</td>
          </tr>

            <?php
              $sql_er =" SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, nivel_establecimiento.nivel_establecimiento, tipo_establecimiento.tipo_establecimiento,";
              $sql_er.=" establecimiento_salud.idred_salud, municipios.municipio, departamento.departamento FROM establecimiento_salud, subsector_salud, nivel_establecimiento, tipo_establecimiento, departamento, municipios ";
              $sql_er.=" WHERE establecimiento_salud.idsubsector_salud=subsector_salud.idsubsector_salud AND establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento AND establecimiento_salud.iddepartamento=departamento.iddepartamento ";
              $sql_er.=" AND establecimiento_salud.idmunicipio=municipios.idmunicipio AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento AND establecimiento_salud.idestablecimiento_salud='$row_ref[4]'";
              $result_er = mysqli_query($link,$sql_er);
              $row_er = mysqli_fetch_array($result_er);
            ?>
            <tr>
              <td colspan="12" valign="bottom" style=" font-size: 12px; font-family: Arial;"><table width="900" border="1" cellspacing="0">
                <tbody>
                  <tr>
                    <td width="185">ESTABLECIMIENTO DE SALUD:</td>
                    <td width="83"><?php echo $row_er[1];?></td>
                    <td width="234">MUNICIPIO:</td>
                    <td width="102"><?php echo $row_er[5];?></td>
                    <td width="176">NIVEL DE ESTABLECIMIENTO:</td>
                    <td width="94"><?php echo $row_er[2];?> - <?php echo $row_er[3];?></td>
                  </tr>
                  <tr>
                    <td>RED DE SALUD:</td>
                    <td>                  
                    <?php 
                    $sql_rd =" SELECT idred_salud, red_salud FROM red_salud WHERE idred_salud='$row_er[4]' ";
                    $result_rd=mysqli_query($link,$sql_rd);
                    $row_rd=mysqli_fetch_array($result_rd);
                    echo $row_rd[1];
                    ?>
                    </td>
                    <td>SE CONTACTO AL ESTABLECIMIENTO:</td>
                    <td><?php echo $row_ref[31];?></td>
                    <td>POR TELESALUD:</td>
                    <td><?php echo $row_ref[32];?></td>
                  </tr>
                  <tr>
                    <td colspan="6">CONTACTO DEL ESTABLECIMIENTO QUE RECIBE LA CONTRAREFERENCIA: <?php echo $row_ref[33];?> </td>
                    </tr>
                  <tr>
                    <td colspan="6">NOMBRE DEL ACOMPANANTE, FAMILIAR Y OTROS: <?php echo $row_ref[34];?></td>
                    </tr>
                </tbody>
              </table></td>
            </tr>
            <tr>
            <td colspan="6" valign="bottom" style="text-align: center; font-size: 12px; font-family: Arial;">FIRMA , SELLO FDEL MÉDICO RESPONSABLE</td>
            <td colspan="6" valign="top" style="text-align: center; font-size: 12px; font-family: Arial;"><p>&nbsp;</p>
              <p>&nbsp;</p>
              <p style="text-align: center">SELLO DEL ESTABLECIMIENTO RECEPTOR</p></td>
          </tr>
          <tr>
            <td colspan="2" style="text-align: center; font-size: 12px; font-family: Arial;">RECUERDE:</td>
            <td width="389" colspan="10"><table width="780" border="0">
              <tbody>
                <tr>
                  <td width="763" style="font-size: 12px; font-family: Arial;">a) Original, para el establecimiento de salud receptor - Expediente Clínico</td>
                </tr>
                <tr>
                  <td style="font-size: 12px; font-family: Arial;">b) Copia 1, para el establecimiento de salud receptor1 - Comité de Referencia y Contrareferencia.</td>
                </tr>
                <tr>
                  <td style="font-size: 12px; font-family: Arial;">c) Copia 2, para tramites administrativos del SUS</td>
                </tr>
                <tr>
                  <td style="font-size: 12px; font-family: Arial;">d) Copia 3, para el establecimiento que realiza la referencia - Expediente Clínico.</td>
                </tr>
                <tr>
                  <td style="font-size: 12px; font-family: Arial;">e) Copia 4, para el establecimiento que realiza la referencia - Comité de referencia</td>
                </tr>
              </tbody>
            </table></td>
          </tr>
          </tbody>
      </table></td>
    </tr>
    <tr>
      <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
      <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
      <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
    </tr>
  </tbody>
</table>
</body>
</html>
