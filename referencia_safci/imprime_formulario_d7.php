<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");

$idreferencia_hc_ss = $_GET['idreferencia_hc'];

$sql_ref =" SELECT idreferencia_hc, iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idatencion_psafci, codigo, idnombre, ";
$sql_ref.=" discapacidad, nombre_acompanante, idparentesco_acomp, celular_acompanante, tel_establecimiento, estuvo_internado, dias_internacion, ";
$sql_ref.=" resumen_anamnesis, especificacion_hallazgos, tratamiento_ref, observaciones_ref, idconsentimiento, idestablecimiento_receptor, idmotivo_referencia, idespecialidad_medica, ";
$sql_ref.=" fecha_registro, hora_registro, idusuario FROM referencia_hc WHERE idreferencia_hc='$idreferencia_hc_ss' ";
$result_ref=mysqli_query($link,$sql_ref);
$row_ref=mysqli_fetch_array($result_ref);

$sql_es =" SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, nivel_establecimiento.nivel_establecimiento, tipo_establecimiento.tipo_establecimiento,";
$sql_es.=" subsector_salud.subsector_salud, municipios.municipio, departamento.departamento FROM establecimiento_salud, subsector_salud, nivel_establecimiento, tipo_establecimiento, departamento, municipios ";
$sql_es.=" WHERE establecimiento_salud.idsubsector_salud=subsector_salud.idsubsector_salud AND establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento AND establecimiento_salud.iddepartamento=departamento.iddepartamento ";
$sql_es.=" AND establecimiento_salud.idmunicipio=municipios.idmunicipio AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento AND establecimiento_salud.idestablecimiento_salud='$row_ref[4]'";
$result_es = mysqli_query($link,$sql_es);
$row_es = mysqli_fetch_array($result_es);

$sql_cf =" SELECT idcarpeta_familiar, codigo, familia, fecha_apertura FROM carpeta_familiar WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
$result_cf=mysqli_query($link,$sql_cf);
$row_cf=mysqli_fetch_array($result_cf);

$sql_n =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$row_ref[7]' ";
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

    $edad = ($ano-$anonaz);  
        

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>FORMULARIO DE REFERENCIA - D7</title>
</head>

<body>

<table width="902" border="0" align="center">
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
                    <strong style="font-family: Arial; font-size: 16px; color: #000000; text-align: right;">FORMULARIO D7 REFERENCIA</strong></br>
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
            <td colspan="3" style="font-family: Arial; font-size: 12px;">NOMBRE DEL ESTABLECIMIENTO</td>
            <td colspan="6" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_es[1];?></td>
            <td colspan="3" rowspan="4" style="text-align: center; font-size: 12px; font-family: Arial;">SELLO DEL ESTABLECIMIENTO</td>
            </tr>
          <tr>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">NIVEL DEL ESTABLECIMIENTO</td>
            <td colspan="6" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_es[2];?> - <?php echo $row_es[3];?></td>
            <td width="107"><span style="text-align: left; font-size: 12px; font-family: Arial;">SELLO DEL EESS QUE REFIERE</span></td>
            </tr>
          <tr>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">RED DE SALUD</td>
            <td width="53" style="font-family: Arial; font-size: 12px; text-align: center;">
              <?php
                $sql_rs =" SELECT red_salud FROM red_salud WHERE idred_salud='$row_ref[2]' ";
                $result_rs=mysqli_query($link,$sql_rs);
                $row_rs=mysqli_fetch_array($result_rs);
                echo $row_rs[0];
              ?>
            </td>
            <td width="77" style="font-family: Arial; font-size: 12px;">MUNICIPIO:</td>
            <td width="72" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_es[5];?></td>
            <td width="80" style="font-size: 12px; font-family: Arial;">FECHA:</td>
            <td width="28" style="font-family: Arial; font-size: 12px; text-align: center;">
              <?php 
                $fecha_r = explode('-',$row_ref[23]);
                $fecha_reg = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];
                echo $fecha_reg; ?>  
            </td>
            <td width="116" style="font-family: Arial; font-size: 12px;">HORA:</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_ref[24];?></td>
            </tr>
          <tr>
            <td colspan="2" style="font-family: Arial; font-size: 12px;">FECHA DE ENVIO:</td>
            <td>&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">HORA DE ENVIO:</td>
            <td>&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">TELF/CEL DEL EESS.</td>
            <td colspan="3" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_ref[12];?></td>
            </tr>
          <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; font-family: Arial; font-size: 12px; color: #FFFFFF;"><strong>IDENTIFICACION DEL PACIENTE (C2)</strong></td>
            </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;">NOMBRES:</td>
            <td colspan="3" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_n[1];?></td>
            <td style="font-family: Arial; font-size: 12px;">APELLIDOS:</td>
            <td colspan="3" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_n[2];?> <?php echo $row_n[3];?></td>
            <td colspan="2" style="font-family: Arial; font-size: 12px;">FECHA DE NACIMIENTO:</td>
            <td colspan="2" style="font-family: Arial; font-size: 12px; text-align: center;">
              <?php 
                $fecha_n = explode('-',$row_n[5]);
                $fecha_nac = $fecha_n[2].'/'.$fecha_n[1].'/'.$fecha_n[0];
                echo $fecha_nac; ?> 
            </td>
            </tr>
          <tr>
            <td width="104" style="font-size: 12px; font-family: Arial;">CI:</td>
            <td colspan="3" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_n[4];?></td>
            <td style="font-family: Arial; font-size: 12px;">DOMICILIO:</td>
            <td colspan="7" style="font-family: Arial; font-size: 12px; text-align: center;"></td>
            </tr>
          <tr>
            <td style="font-size: 12px; font-family: Arial;">TEL./CEL.</td>
            <td colspan="3" style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
            <td style="font-size: 12px; font-family: Arial;">N° DE H.C.</td>
            <td colspan="2" style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
            <td style="font-size: 12px; font-family: Arial;">PROCEDENCIA:</td>
            <td colspan="4" style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
            </tr>
          <tr>
            <td style="font-size: 12px; font-family: Arial;">EDAD:</td>
            <td colspan="6" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $edad;?> [años]</td>
            <td style="font-size: 12px; font-family: Arial;">SEXO:</td>
            <td colspan="4" style="font-family: Arial; font-size: 12px; text-align: center;">
                <?php 
                $sql_g =" SELECT genero FROM genero WHERE idgenero='$row_n[7]' ";
                $result_g=mysqli_query($link,$sql_g);
                $row_g=mysqli_fetch_array($result_g);
              echo $row_g[0];
              ?>
            </td>
            </tr>

          <?php  if ($row_ref[8]=='SI') { 
          $sql_ds =" SELECT tipo_discapacidad_cf.tipo_discapacidad_cf, nivel_discapacidad_cf.nivel_discapacidad_cf FROM discapacidad_ref, tipo_discapacidad_cf, nivel_discapacidad_cf ";
          $sql_ds.=" WHERE discapacidad_ref.idtipo_discapacidad=tipo_discapacidad_cf.idtipo_discapacidad_cf AND discapacidad_ref.idnivel_discapacidad=nivel_discapacidad_cf.idnivel_discapacidad_cf ";
          $sql_ds.=" AND discapacidad_ref.idreferencia_hc='$idreferencia_hc_ss' ";
          $result_ds=mysqli_query($link,$sql_ds);
          $row_ds=mysqli_fetch_array($result_ds);  }  
          ?>
          <tr>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">PERSONA CON DISCAPACIDAD</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_ref[8];?></td>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">TIPO DE DISCAPACIDAD:</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_ds[0];?></td>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">GRADO DE DISCAPACIDAD:</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_ds[1];?></td>
            </tr>
          <tr>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">NOMBRE DEL ACOMPANANTE:</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_ref[9];?></td>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">PARENTESCO:</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                $sql_pa =" SELECT parentesco FROM parentesco WHERE idparentesco='$row_ref[10]' ";
                $result_pa=mysqli_query($link,$sql_pa);
                $row_pa=mysqli_fetch_array($result_pa);
              echo $row_pa[0];
              ?>
              </td>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">TEL/CEL. DEL ACOMPANANTE:</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_ref[11];?></td>
            </tr>
          <tr>
            <td colspan="12" bgcolor="#466CAD" style="font-size: 12px; text-align: center; color: #FFFFFF; font-family: Arial;"><strong>DATOS CLINICOS Y SIGNOS VITALES (C3)</strong></td>
            </tr>

            <?php
            $sql_sg =" SELECT idsigno_vital_psafci, talla, peso, temperatura, frec_cardiaca, frec_respiratoria, presion_arterial, presion_arterial_d, saturacion, glascow, alergia, ";
            $sql_sg.=" descripcion_alergia, imc FROM signo_vital_psafci WHERE idnombre ='$row_ref[7]' AND idatencion_psafci='$row_ref[5]' ORDER BY idsigno_vital_psafci DESC LIMIT 1 ";
            $result_sg = mysqli_query($link,$sql_sg);
            $row_sg = mysqli_fetch_array($result_sg);
            ?> 

          <tr>
            <td style="font-size: 12px; font-family: Arial; text-align: right;">F.C.:</td>
            <td width="55" style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_sg[4];?></td>
            <td style="font-size: 12px; font-family: Arial; text-align: right;">F.R.:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_sg[5];?></td>
            <td style="font-size: 12px; font-family: Arial; text-align: right;">P.A.:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">  <?php echo $row_sg[6];?> / <?php echo $row_sg[7];?> mmHg</td>
            <td style="font-size: 12px; font-family: Arial; text-align: right;">T°:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_sg[3];?></td>
            <td style="font-size: 12px; font-family: Arial; text-align: right;">PESO:</td>
            <td width="51" style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_sg[2];?> Kg</td>
            <td width="55" style="font-size: 12px; font-family: Arial; text-align: right;">TALLA:</td>
            <td width="54" style="font-size: 12px; font-family: Arial; text-align: center;"> <?php echo $row_sg[1];?> cm</td>
          </tr>
          <tr>
            <td style="font-size: 12px; font-family: Arial; text-align: right;">GLASCOW:</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial; text-align: center;"> <?php echo $row_sg[9];?> / 15</td>
            <td style="font-size: 12px; font-family: Arial; text-align: right;">SPO2:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"> <?php echo $row_sg[8];?> %</td>
            <td style="font-size: 12px; font-family: Arial; text-align: right;">IMC:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"> <?php echo $row_sg[12];?> </td>
            </tr>
          <tr>
            <td colspan="3" style="font-size: 12px; font-family: Arial;"><strong>ANTECEDENTES GINECOOBSTÉTRICOS:</strong></td>
            <td style="font-size: 12px; font-family: Arial;">F.U.M.:</td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial;">G:...P:....A:....C:</td>
            <td style="font-size: 12px; font-family: Arial;">F.P.P.:</td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td style="font-size: 12px; font-family: Arial;">R.P.M. Hrs.</td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp; </td>
          </tr>
          <tr>
            <td style="font-size: 12px; font-family: Arial;">F.C.F.</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial;"> </td>
            <td colspan="3" style="font-size: 12px; font-family: Arial;">NÚMERO DE CONTROLES PRENATALES:</td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">MADURACIÓN PULMONAR</td>
            <td style="font-size: 12px; font-family: Arial;">SI</td>
            <td style="font-size: 12px; font-family: Arial;">NO</td>
          </tr>
          <tr>
            <td style="font-size: 12px; font-family: Arial;">PARTO:</td>
            <td style="font-size: 12px; font-family: Arial;">SI</td>
            <td style="font-size: 12px; font-family: Arial;">NO</td>
            <td style="font-size: 12px; font-family: Arial;">EUTOCICO</td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td style="font-size: 12px; font-family: Arial;">CESÁREA</td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td style="font-size: 12px; font-family: Arial;">PARTO:</td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td style="font-size: 12px; font-family: Arial;">HORA:</td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
          </tr>
          <tr>
            <td style="font-size: 12px; font-family: Arial;">R.N.</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">EDAD GESTACIONAL</td>
            <td style="font-size: 12px; font-family: Arial;">....sem</td>
            <td style="font-size: 12px; font-family: Arial;">LIQ. AMNIÓTICO</td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td style="font-size: 12px; font-family: Arial;">PESO:</td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td style="font-size: 12px; font-family: Arial;">TALLA:</td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
          </tr>
          <tr>
            <td style="font-size: 12px; font-family: Arial;">P.C.</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">...cm</td>
            <td style="font-size: 12px; font-family: Arial;">P.T.</td>
            <td style="font-size: 12px; font-family: Arial;">...cm</td>
            <td style="font-size: 12px; font-family: Arial;">APGAR:</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">PRIMER MINUTO:</td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td style="font-size: 12px; font-family: Arial;">5 MINUTOS:</td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" style="font-size: 12px; font-family: Arial;">INDICE DE CHOQUE:</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial;">CRITERIOS SOFA</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; font-family: Arial; font-size: 12px; color: #FFFFFF;"><strong>RESUMEN ANAMNESIS Y EXAMEN FÍSICO (C4)</strong></td>
            </tr>
          <tr>
            <td colspan="2" style="font-size: 12px; font-family: Arial; text-align: center;">ESTUVO INTERNADO:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">SI</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php if ($row_ref[13]=='SI') { echo 'X'; } else { } ?></td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">NO</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php if ($row_ref[13]=='NO') { echo 'X'; } else { } ?></td>
            <td colspan="3" style="font-size: 12px; font-family: Arial; text-align: center;">DIAS DE INTERNACIÓN:</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_ref[14];?></td>
            </tr>
          <tr>
            <td colspan="12" style="font-size: 12px; font-family: Arial;"><p>(Descripcion Cualitativa)</p><p><?php echo $row_ref[15];?></p>
            </td>
            </tr>
          <tr>
            <td colspan="8" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-family: Arial; font-size: 12px;"><strong>REALIZÓ EXAMENES COMPLEMENTARIOS DE DIAGNÓSTICO (C5)</strong></td>
            <td bgcolor="#466CAD" style="text-align: center; font-size: 12px; font-family: Arial; color: #466CAD;"><strong></strong></td>
            <td bgcolor="#466CAD" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td bgcolor="#466CAD" style="font-family: Arial; font-size: 12px; text-align: center; color: #466CAD;"></td>
            <td bgcolor="#466CAD" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
          </tr>
          <tr>
            <td style="font-size: 12px; font-family: Arial;">HALLAZGOS LLAMATIVOS</td>
            <?php
            $numero_c=0;
            $sql_c =" SELECT examen_referencia.idexamen_complementario, examen_complementario.examen_complementario FROM examen_referencia, examen_complementario ";
            $sql_c.=" WHERE examen_referencia.idexamen_complementario=examen_complementario.idexamen_complementario AND examen_referencia.idreferencia_hc='$idreferencia_hc_ss' ";
            $result_c = mysqli_query($link,$sql_c);
            if ($row_c = mysqli_fetch_array($result_c)){
            mysqli_field_seek($result_c,0);
            while ($field_c = mysqli_fetch_field($result_c)){
            } do { ?> 

            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_c[1];?>:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">SI</td>

            <?php
            $numero_c=$numero_c+1;
            }
            while ($row_c = mysqli_fetch_array($result_c));
            } else {
            }
            ?>

            <td colspan="2">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="12" valign="top" style="font-size: 12px; font-family: Arial;"><p>(Descripcion Cualitativa)</p>
              <p><?php echo $row_ref[16];?></p>
            </td>
            </tr>
          <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; font-family: Arial; font-size: 12px; color: #FFFFFF;"><strong>DIAGNÓSTICOS PRESUNTIVOS (C6)</strong></td>
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
            <td style="font-size: 12px; font-family: Arial;"><?php echo $numero_dg;?>)</td>
            <td colspan="5" style="font-size: 12px; font-family: Arial;"><?php echo $row_dg[0];?></td>
            <td style="font-size: 12px; font-family: Arial;">CIE-10</td>
            <td  style="font-size: 12px; font-family: Arial;"><?php echo $row_dg[1];?></td>
            <td style="font-size: 12px; font-family: Arial;"><?php echo $row_dg[2];?></td>
          </tr>
        <?php
        $numero_dg=$numero_dg+1;
        }
        while ($row_dg = mysqli_fetch_array($result_dg));
        } else {
        }
        ?>  
          
          <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;">TRATAMIENTO (C8)</td>
            </tr>
          <tr>
            <td colspan="12" style="font-size: 12px; font-family: Arial;"><p><?php echo $row_ref[17];?></p></td>
            </tr>
                      <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;">OBSERVACIONES (C9)</td>
            </tr>
          <tr>
            <td colspan="12" style="font-size: 12px; font-family: Arial;"><p><?php echo $row_ref[18];?></p></td>
            </tr>
          <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;">CONSENTIMIENTO INFORMADO PARA EL TRASLADO (C9)</td>
            </tr>
          <tr>
            <td colspan="12" style="font-size: 12px; font-family: Arial;">Yo..................... de ........ años de edad, en calidad de ....... habiéndome informado sobre el cuadro clínico, autorizo al médico tratante y personal de salud del establecimiento, realizar la referencia, teniendo en cuenta que he sido informado claramente sobre los riesgos, el traslado y posibles tratamientos, procedimientos durante el traslado e internación: .......................................y beneficios que se puede presentar.</td>
            </tr>
          <tr>
            <td style="font-size: 12px; font-family: Arial;">FIRMA PACIENTE:</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td style="font-size: 12px; font-family: Arial;">CI:</td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td style="font-size: 12px; font-family: Arial;">FIRMA DEL ACOMPAÑANTE:</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td style="font-size: 12px; font-family: Arial;">CI:</td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;">NOMBRE Y CARGO DE QUIEN ENVIA AL PACIENTE O RESPONSABLE DEL ESTABLECIMIENTO DE SALUD QUE REFIERE (C10)</td>
            </tr>
          <tr>
            <td style="font-size: 12px; font-family: Arial;">NOMBRE:</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td style="font-size: 12px; font-family: Arial;">CARGO:</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td rowspan="3" style="font-size: 12px; font-family: Arial;">FIRMA Y SELLO</td>
            <td colspan="4" rowspan="3" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="4" style="font-size: 12px; font-family: Arial;">NRO. DE TEL./CEL. CONTACTO DEL MÉDICO QUE ENVIÓ</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="4" style="font-size: 12px; font-family: Arial;">NOMBRE DEL PERSONAL DE SALUD QUE ACOMPAÑA</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;">MOTIVO DE REFERENCIA (C11) SOLO MARQUE UNO</td>
            </tr>
          <tr>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">URGENCIA (....)</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">EMERGENCIA (....)</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">CONSULTA EXTERNA (...)</td>
            <td style="font-size: 12px; font-family: Arial;">SERVICIOS/ESPECIALIDAD (....)</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">PSAFCI: (...)</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial;">POR TELESALUD (....)</td>
            </tr>
          <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;">ESTABLECIMIENTO DE SALUD RECEPTOR (C12)</td>
            </tr>

            <?php
              $sql_er =" SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, nivel_establecimiento.nivel_establecimiento, tipo_establecimiento.tipo_establecimiento,";
              $sql_er.=" subsector_salud.idsubsector_salud, municipios.municipio, departamento.departamento FROM establecimiento_salud, subsector_salud, nivel_establecimiento, tipo_establecimiento, departamento, municipios ";
              $sql_er.=" WHERE establecimiento_salud.idsubsector_salud=subsector_salud.idsubsector_salud AND establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento AND establecimiento_salud.iddepartamento=departamento.iddepartamento ";
              $sql_er.=" AND establecimiento_salud.idmunicipio=municipios.idmunicipio AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento AND establecimiento_salud.idestablecimiento_salud='$row_ref[20]'";
              $result_er = mysqli_query($link,$sql_er);
              $row_er = mysqli_fetch_array($result_er);
            ?>

          <tr>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">NOMBRE DEL ESTABLECIMIENTO:</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_er[1];?></td>
            <td style="font-size: 12px; font-family: Arial;">NIVEL:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_er[2];?> - <?php echo $row_er[3];?></td>
            <td rowspan="2" style="font-size: 12px; font-family: Arial;">SUBSECTOR:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">Público</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">Seguridad Social</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">Privado</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">Otro</td>
          </tr>
          <tr>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">NOMBRE DE LA PERSONA CONTACTADA:</td>
            <td colspan="5" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php if ($row_er[4]=='6') { echo 'X'; } else { } ?></td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php if ($row_er[4]=='7') { echo 'X'; } else { } ?></td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php if ($row_er[4]=='8') { echo 'X'; } else { } ?></td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php if ($row_er[4]=='9') { echo 'X'; } else { } ?></td>
          </tr>
          <tr>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">MEDIO DE COMUNICACIÓN</td>
            <td colspan="5" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td style="font-size: 12px; font-family: Arial;">REPORTADO A CCES-D-A:</td>
            <td colspan="4" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">NOMBRE DE QUIEN RECIBE AL PACIENTE</td>
            <td colspan="5" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td colspan="5" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">FECHA DE RECEPCIÓN:</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td style="font-size: 12px; font-family: Arial;">HORA DE LLEGADA:</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial;">HORA DE RECEPCIÓN:</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="7" style="font-size: 12px; font-family: Arial;">MÉDICO RESPONSABLE DEL ESTABLECIMIENTO DE SALUD RECEPTOR QUE EVALUA LOS CRITERIOS DE CALIDAD A.J.O.</td>
            <td colspan="5" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="3" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;">PACIENTE ADMITIDO:</td>
            <td style="font-size: 12px; font-family: Arial;">SI</td>
            <td style="font-size: 12px; font-family: Arial;">NO</td>
            <td bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;">MOTIVO</td>
            <td colspan="6" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="6" valign="bottom" style="text-align: center; font-size: 12px; font-family: Arial;">FIRMA , SELLO FDEL MÉDICO RESPONSABLE</td>
            <td colspan="6" valign="top" style="text-align: center; font-size: 12px; font-family: Arial;"><table width="489" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td colspan="3" rowspan="2" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;">CALIFICACIÓN POR EL ESTABLECIMIENTO RECEPTOR colocar SI o NO</td>
                  <td width="37" style="text-align: center; font-size: 12px; font-family: Arial;">A</td>
                  <td width="39" style="text-align: center; font-size: 12px; font-family: Arial;">J</td>
                  <td width="44" style="text-align: center; font-size: 12px; font-family: Arial;">O</td>
                  </tr>
                <tr>
                  <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
                  <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
                  <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
                  </tr>
                </tbody>
              </table>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p style="text-align: center">SELLO DEL ESTABLECIMIENTO RECEPTOR</p></td>
          </tr>
          <tr>
            <td colspan="2" style="text-align: center; font-size: 12px; font-family: Arial;">RECUERDE:</td>
            <td colspan="10"><table width="780" border="0">
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
