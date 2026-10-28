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
$sql_ref.=" fecha_registro, hora_registro, idusuario, adecuada, justificada, oportuna FROM referencia_hc WHERE idreferencia_hc='$idreferencia_hc_ss' ";
$result_ref=mysqli_query($link,$sql_ref);
$row_ref=mysqli_fetch_array($result_ref);

$sql_es =" SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, nivel_establecimiento.nivel_establecimiento, tipo_establecimiento.tipo_establecimiento,";
$sql_es.=" subsector_salud.subsector_salud, municipios.municipio, departamento.departamento FROM establecimiento_salud, subsector_salud, nivel_establecimiento, tipo_establecimiento, departamento, municipios ";
$sql_es.=" WHERE establecimiento_salud.idsubsector_salud=subsector_salud.idsubsector_salud AND establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento AND establecimiento_salud.iddepartamento=departamento.iddepartamento ";
$sql_es.=" AND establecimiento_salud.idmunicipio=municipios.idmunicipio AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento AND establecimiento_salud.idestablecimiento_salud='$row_ref[4]'";
$result_es = mysqli_query($link,$sql_es);
$row_es = mysqli_fetch_array($result_es);

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
<style>
  /****** impresión por defecto en tamaño carta: la tabla de 902px se escala para entrar en el ancho de la hoja ****/
  @page { size: letter portrait; margin: 5mm; }
  /****** el sello se superpone centrado en su celda sin agrandar el alto de la fila ****/
  /****** a los lados se recorta en el borde de la celda: si sobresale del formulario, el navegador achica toda la hoja al imprimir ****/
  .celda-sello { position: relative; overflow-x: clip; overflow-y: visible; }
  /****** "caja invisible": el sello cabe en el ancho de su celda y hasta 240px de alto, sin deformarse (sirve para sellos cuadrados o anchos) ****/
  .sello-flotante { position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 100%; max-height: 240px; pointer-events: none; z-index: 2; }
  /****** el sello del establecimiento se ajusta al recuadro de C1 ****/
  .sello-eess { max-width: 96%; max-height: 96%; }
  @media print {
    /****** sin zoom: el navegador ajusta solo el formulario al ancho de la hoja (con zoom, Chrome lo achicaba dos veces) ****/
    body { margin: 0; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .no-print { display: none; }
    /****** no partir filas entre hojas ni dejar una barra de título sola al pie ****/
    tr, img { break-inside: avoid; page-break-inside: avoid; }
    tr.barra-titulo { break-after: avoid; page-break-after: avoid; }
  }
</style>
</head>

<body>

<table width="902" border="0" align="center" id="formulario_d7">
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
                    <strong style="font-family: Arial; font-size: 16px; color: #000000; text-align: right;">FORMULARIO REFERENCIA D7</strong></br>
                    <strong style="font-family: Arial; font-size: 16px; color: #000000; text-align: right;"><?php echo $row_ref[6]; ?></strong></td>
                  <td width="217" style="text-align: center; font-family: Arial; font-size: 12px;"><a href="#" id="btn_descargar_pdf" class="no-print" onclick="descargarPDF(); return false;">DESCARGAR EN PDF</a></td>
                  </tr>
                </tbody>
              </table></td>
          </tr>
          <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;"><strong>DATOS DEL ESTABLECIMIENTO DE SALUD REFERENTE (C1)</strong></td>
            </tr>
          <tr>
            <td colspan="3" bgcolor="#e7eaf0" style="font-family: Arial; font-size: 12px;">NOMBRE DEL ESTABLECIMIENTO</td>
            <td colspan="6" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_es[1];?></td>
            <td colspan="3" bgcolor="#e7eaf0" rowspan="4" class="celda-sello" style="text-align: center; font-size: 12px; font-family: Arial;">
              <?php
                /****** sello del establecimiento que refiere (consulta aparte por si aún no existe la columna sello_eess) ****/
                $sello_eess = '';
                $result_sl = @mysqli_query($link," SELECT sello_eess FROM establecimiento_salud WHERE idestablecimiento_salud='$row_ref[4]' AND sello_eess<>'' LIMIT 1 ");
                if ($result_sl && $row_sl = mysqli_fetch_array($result_sl)) {
                  $sello_eess = $row_sl[0];
                }
                if ($sello_eess != '' && is_file('../'.$sello_eess)) { ?>
                  <img src="../<?php echo htmlspecialchars($sello_eess);?>" class="sello-flotante sello-eess" alt="Sello del establecimiento"/>
              <?php } else { ?>
              SELLO DEL ESTABLECIMIENTO
              <?php } ?>
            </td>
            </tr>
          <tr>
            <td colspan="2" bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">NIVEL DEL ESTABLECIMIENTO</td>
            <td colspan="6" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_es[2];?> - <?php echo $row_es[3];?></td>
            <td width="107"><span style="text-align: left; font-size: 12px; font-family: Arial;">SELLO DEL EESS QUE REFIERE</span></td>
            </tr>
          <tr>
            <td colspan="2" bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">RED DE SALUD</td>
            <td width="53" style="font-family: Arial; font-size: 12px; text-align: center;">
              <?php
                $sql_rs =" SELECT red_salud FROM red_salud WHERE idred_salud='$row_ref[2]' ";
                $result_rs=mysqli_query($link,$sql_rs);
                $row_rs=mysqli_fetch_array($result_rs);
                echo $row_rs[0];
              ?>
            </td>
            <td width="77" bgcolor="#e7eaf0" style="font-family: Arial; font-size: 12px;">MUNICIPIO:</td>
            <td width="72" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_es[5];?></td>
            <td width="80" bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">FECHA:</td>
            <td width="28" style="font-family: Arial; font-size: 12px; text-align: center;">
              <?php 
                $fecha_r = explode('-',$row_ref[23]);
                $fecha_reg = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];
                echo $fecha_reg; ?>  
            </td>
            <td width="116" bgcolor="#e7eaf0" style="font-family: Arial; font-size: 12px;">HORA:</td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_ref[24];?></td>
            </tr>
          <tr>
            <td colspan="2" bgcolor="#e7eaf0" style="font-family: Arial; font-size: 12px;">FECHA DE ENVIO:</td>
            <td>&nbsp;</td>
            <td bgcolor="#e7eaf0" style="font-family: Arial; font-size: 12px;">HORA DE ENVIO:</td>
            <td>&nbsp;</td>
            <td bgcolor="#e7eaf0" style="font-family: Arial; font-size: 12px;">TELF/CEL DEL EESS.</td>
            <td colspan="3" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_ref[12];?></td>
            </tr>
          <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; font-family: Arial; font-size: 12px; color: #FFFFFF;"><strong>IDENTIFICACION DEL PACIENTE (C2)</strong></td>
            </tr>
          <tr>
            <td bgcolor="#e7eaf0" style="font-family: Arial; font-size: 12px;">NOMBRES:</td>
            <td colspan="3" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_n[1];?></td>
            <td bgcolor="#e7eaf0" style="font-family: Arial; font-size: 12px;">APELLIDOS:</td>
            <td colspan="3" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_n[2];?> <?php echo $row_n[3];?></td>
            <td bgcolor="#e7eaf0" colspan="2" style="font-family: Arial; font-size: 12px;">FECHA DE NACIMIENTO:</td>
            <td colspan="2" style="font-family: Arial; font-size: 12px; text-align: center;">
              <?php 
                $fecha_n = explode('-',$row_n[5]);
                $fecha_nac = $fecha_n[2].'/'.$fecha_n[1].'/'.$fecha_n[0];
                echo $fecha_nac; ?> 
            </td>
            </tr>
          <tr>
            <td bgcolor="#e7eaf0" width="104" style="font-size: 12px; font-family: Arial;">CI:</td>
            <td colspan="3" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_n[4];?></td>
            <td bgcolor="#e7eaf0" style="font-family: Arial; font-size: 12px;">DOMICILIO:</td>
            <td colspan="7" style="font-family: Arial; font-size: 12px; text-align: center;"></td>
            </tr>
          <tr>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">TEL./CEL.</td>
            <td colspan="3" style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">N° DE H.C.</td>
            <td colspan="2" style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">PROCEDENCIA:</td>
            <td colspan="4" style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
            </tr>
          <tr>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">EDAD:</td>
            <td colspan="6" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $edad;?> [años]</td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">SEXO:</td>
            <td colspan="4" style="font-family: Arial; font-size: 12px; text-align: center;">
                <?php 
                $sql_g =" SELECT genero FROM genero WHERE idgenero='$row_n[7]' ";
                $result_g=mysqli_query($link,$sql_g);
                $row_g=mysqli_fetch_array($result_g);
              echo $row_g[0];
              ?>
            </td>
            </tr>

          <?php  
          $sql_ds =" SELECT tipo_discapacidad_cf.tipo_discapacidad_cf, nivel_discapacidad_cf.nivel_discapacidad_cf FROM discapacidad_ref, tipo_discapacidad_cf, nivel_discapacidad_cf ";
          $sql_ds.=" WHERE discapacidad_ref.idtipo_discapacidad=tipo_discapacidad_cf.idtipo_discapacidad_cf AND discapacidad_ref.idnivel_discapacidad=nivel_discapacidad_cf.idnivel_discapacidad_cf ";
          $sql_ds.=" AND discapacidad_ref.idreferencia_hc='$idreferencia_hc_ss' ";
          $result_ds=mysqli_query($link,$sql_ds);
          if ($row_ds=mysqli_fetch_array($result_ds)) {  ?>
            <tr>
            <td bgcolor="#e7eaf0" colspan="2" style="font-size: 12px; font-family: Arial;">PERSONA CON DISCAPACIDAD</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_ref[8];?></td>
            <td bgcolor="#e7eaf0" colspan="2" style="font-size: 12px; font-family: Arial;">TIPO DE DISCAPACIDAD:</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_ds[0];?></td>
            <td bgcolor="#e7eaf0" colspan="2" style="font-size: 12px; font-family: Arial;">GRADO DE DISCAPACIDAD:</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_ds[1];?></td>
            </tr>        
          <?php }  ?>
          <tr>
            <td bgcolor="#e7eaf0" colspan="2" style="font-size: 12px; font-family: Arial;">NOMBRE DEL ACOMPANANTE:</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_ref[9];?></td>
            <td bgcolor="#e7eaf0" colspan="2" style="font-size: 12px; font-family: Arial;">PARENTESCO:</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                $sql_pa =" SELECT parentesco FROM parentesco WHERE idparentesco='$row_ref[10]' ";
                $result_pa=mysqli_query($link,$sql_pa);
                $row_pa=mysqli_fetch_array($result_pa);
              echo $row_pa[0];
              ?>
              </td>
            <td bgcolor="#e7eaf0" colspan="2" style="font-size: 12px; font-family: Arial;">TEL/CEL. DEL ACOMPANANTE:</td>
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
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial; text-align: right;">F.C.:</td>
            <td width="55" style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_sg[4];?></td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial; text-align: right;">F.R.:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_sg[5];?></td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial; text-align: right;">P.A.:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">  <?php echo $row_sg[6];?> / <?php echo $row_sg[7];?> mmHg</td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial; text-align: right;">T°:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_sg[3];?></td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial; text-align: right;">PESO:</td>
            <td width="51" style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_sg[2];?> Kg</td>
            <td width="55" bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial; text-align: right;">TALLA:</td>
            <td width="54" style="font-size: 12px; font-family: Arial; text-align: center;"> <?php echo $row_sg[1];?> cm</td>
          </tr>
          <tr>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial; text-align: right;">GLASCOW:</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial; text-align: center;"> <?php echo $row_sg[9];?> / 15</td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial; text-align: right;">SPO2:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"> <?php echo $row_sg[8];?> %</td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial; text-align: right;">IMC:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"> <?php echo $row_sg[12];?> </td>
            </tr>
            <!----------------------------- EN CASO DE MUJER EN ESTADO DE GESTACION - BEGIN ------------------------------->

      <?php
        $sql_h =" SELECT idhistoria_perinatal, fecha_registro FROM historia_perinatal WHERE idnombre='$row_ref[7]' ";
        $result_h = mysqli_query($link,$sql_h);
        if ($row_h = mysqli_fetch_array($result_h)){
        mysqli_field_seek($result_h,0);
        while ($field_h = mysqli_fetch_field($result_h)){
        } do { 
        ?>
                <?php
                    $sql_g = " SELECT idgestacion, fecha_fum, fecha_fpp, controles_prenatales FROM gestacion WHERE idhistoria_perinatal='$row_h[0]' ORDER BY idgestacion DESC LIMIT 1 ";
                    $result_g = mysqli_query($link,$sql_g);
                    $row_g = mysqli_fetch_array($result_g);

                    $sql_a =" SELECT idantecedente_obstetrico, gestaciones, partos, abortos, cesareas  FROM antecedente_obstetrico WHERE idhistoria_perinatal='$row_h[0]' ";
                    $result_a = mysqli_query($link,$sql_a);
                    $row_a = mysqli_fetch_array($result_a);

                    ?> 

          <tr>
            <td bgcolor="#e7eaf0" colspan="3" style="font-size: 12px; font-family: Arial;"><strong>ANTECEDENTES GINECOOBSTÉTRICOS:</strong></td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial; text-align: center;">F.U.M.:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                  $fecha_m = explode('-',$row_g[1]);
                  $fecha_um = $fecha_m[2].'/'.$fecha_m[1].'/'.$fecha_m[0];
                  echo $fecha_um; ?>
            </td>
            <td colspan="3" style="font-size: 12px; font-family: Arial; text-align: center;">G : <?php echo $row_a[1]?>... P : <?php echo $row_a[2]?>... A : <?php echo $row_a[3]?>... C : <?php echo $row_a[4]?> </td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial; text-align: center;">F.P.P.:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                $fecha_p = explode('-',$row_g[2]);
                $fecha_pp = $fecha_p[2].'/'.$fecha_p[1].'/'.$fecha_p[0];
                echo $fecha_pp; 
              ?>
            </td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;"></td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp; </td>
          </tr>

              <?php
                $sql_p =" SELECT idparto, hora_rpm, maduracion_pulmonar, idtipo_parto, fecha_parto, hora_parto FROM parto WHERE idnombre='$row_ref[7]' AND idgestacion='$row_g[0]' ORDER BY idparto DESC LIMIT 1  ";
                $result_p = mysqli_query($link,$sql_p);
                if ($row_p = mysqli_fetch_array($result_p)){
                mysqli_field_seek($result_p,0);
                while ($field_p = mysqli_fetch_field($result_p)){
                } do { 

                    $sql_ca =" SELECT idconsulta_antenatal, frecuencia_fcf, edad_gestacional FROM consulta_antenatal WHERE idnombre='$row_ref[7]' AND idgestacion='$row_g[0]' ORDER BY idconsulta_antenatal DESC LIMIT 1 ";
                    $result_ca = mysqli_query($link,$sql_ca);
                    $row_ca = mysqli_fetch_array($result_ca);
              ?>

          <tr>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">F.C.F.</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial; text-align: center;"> <?php echo $row_ca[1]?> </td>
            <td bgcolor="#e7eaf0" colspan="3" style="font-size: 12px; font-family: Arial;">NÚMERO DE CONTROLES PRENATALES:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_g[3]?></td>
            <td bgcolor="#e7eaf0" colspan="2" style="font-size: 12px; font-family: Arial;">MADURACIÓN PULMONAR</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"> <?php echo $row_p[2]?> </td>
            <td style="font-size: 12px; font-family: Arial;">R.P.M. Hrs. <?php echo $row_p[1]?></td>
          </tr>

          <tr>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">PARTO:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">
            <?php 
                $sql_p =" SELECT idparto, hora_rpm, maduracion_pulmonar, idtipo_parto, fecha_parto, hora_parto FROM parto WHERE idnombre='$row_ref[7]' AND idgestacion='$row_g[0]' ORDER BY idparto DESC LIMIT 1  ";
                $result_p = mysqli_query($link,$sql_p);
            if ($row_p = mysqli_fetch_array($result_p)) { echo 'SI'; } else { echo 'NO'; } ?>
            </td>
            <td style="font-size: 12px; font-family: Arial;"></td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">EUTOCICO</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php if ($row_p[3] == '1') { echo 'SI'; } ?>
            </td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">CESÁREA</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php if ($row_p[3] == '2') { echo 'SI'; } ?>
            </td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">FECHA PARTO:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                $fecha_fp = explode('-',$row_p[4]);
                $fecha_parto = $fecha_fp[2].'/'.$fecha_fp[1].'/'.$fecha_fp[0];
                echo $fecha_parto; 
              ?>
            </td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">HORA:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_p[5];?></td>
            <td style="font-size: 12px; font-family: Arial;">Hrs.</td>
          </tr>
              <?php
                $sql_rn =" SELECT idrecien_nacido, liq_amniotico, peso_rn, talla_rn, pc_rn, pt_rn, apgar_uno, apgar_cinco, indice_choque, criterio_sofa, edad_gestacional, idgenero FROM recien_nacido WHERE idgestacion='$row_g[0]' ORDER BY idrecien_nacido DESC LIMIT 1 ";
                $result_rn = mysqli_query($link,$sql_rn);
                $row_rn = mysqli_fetch_array($result_rn);
              ?>
          <tr>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">R.N.</td>
            <td bgcolor="#e7eaf0" colspan="2" style="font-size: 12px; font-family: Arial;">EDAD GESTACIONAL</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_rn[10];?>..sem</td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">LIQ. AMNIÓTICO</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_rn[1];?></td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">PESO:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_rn[2];?> gr.</td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">TALLA:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_rn[3];?> cm.</td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">P.C.</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_rn[4];?> cm</td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">P.T.</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_rn[5];?> cm</td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">APGAR:</td>
            <td bgcolor="#e7eaf0" colspan="2" style="font-size: 12px; font-family: Arial;">PRIMER MINUTO:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_rn[6];?></td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">5 MINUTOS:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_rn[7];?></td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#e7eaf0" colspan="3" style="font-size: 12px; font-family: Arial;">ÍNDICE DE CHOQUE:</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_rn[8];?></td>
            <td bgcolor="#e7eaf0" colspan="3" style="font-size: 12px; font-family: Arial;">CRITERIOS SOFA</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_rn[9];?></td>
            </tr>

          <?php
            }
            while ($row_p = mysqli_fetch_array($result_p));
            } else { } 
          ?>


        <?php
        }
        while ($row_h = mysqli_fetch_array($result_h));
        } else { } 
        ?>
 <!----------------------------- EN CASO DE MUJER EN ESTADO DE GESTACION - END ------------------------------->

          <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; font-family: Arial; font-size: 12px; color: #FFFFFF;"><strong>RESUMEN ANAMNESIS Y EXAMEN FÍSICO (C4)</strong></td>
            </tr>
          <tr>
            <td bgcolor="#e7eaf0" colspan="2" style="font-size: 12px; font-family: Arial; text-align: center;">ESTUVO INTERNADO:</td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial; text-align: center;">SI</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php if ($row_ref[13]=='SI') { echo 'X'; } else { } ?></td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial; text-align: center;">NO</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php if ($row_ref[13]=='NO') { echo 'X'; } else { } ?></td>
            <td bgcolor="#e7eaf0" colspan="3" style="font-size: 12px; font-family: Arial; text-align: center;">DIAS DE INTERNACIÓN:</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_ref[14];?></td>
            </tr>
          <tr>
            <td colspan="12" style="font-size: 12px; font-family: Arial;"><p><?php echo $row_ref[15];?></p>
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
            <td colspan="12" valign="top" style="font-size: 12px; font-family: Arial;">
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
            <td colspan="4" style="font-size: 12px; font-family: Arial;"><?php echo $row_dg[0];?></td>
            <td style="font-size: 12px; font-family: Arial;">CIE-10</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial;"><?php echo $row_dg[1];?></td>
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
            <td colspan="12" style="font-size: 12px; font-family: Arial;">
              <?php

              $sql_con =" SELECT idconsentimiento, consentimiento FROM consentimiento WHERE idconsentimiento='$row_ref[19]' ";
              $result_con = mysqli_query($link,$sql_con);
              $row_con = mysqli_fetch_array($result_con);
              if ($row_ref[19] == '1') { ?>
                <p> Yo  <?php echo mb_strtoupper($row_n[1].' '.$row_n[2].' '.$row_n[3]);?> de <?php echo $edad;?> años de edad, en calidad de <?php echo $row_con[1];?> habiéndome informado sobre el cuadro clínico, autorizo al médico tratante y personal de salud del establecimiento, realizar la referencia, teniendo en cuenta que he sido informado claramente sobre los riesgos, el traslado y posibles tratamientos, procedimientos durante el traslado e internación: .......................................y beneficios que se puede presentar.</p>
              <?php } else { ?>
                <p> Yo  <?php echo mb_strtoupper($row_ref[9]);?>, en calidad de <?php echo $row_con[1];?> habiéndome informado sobre el cuadro clínico, autorizo al médico tratante y personal de salud del establecimiento, realizar la referencia, teniendo en cuenta que he sido informado claramente sobre los riesgos, el traslado y posibles tratamientos, procedimientos durante el traslado e internación: .......................................y beneficios que se puede presentar.</p>
              <?php } ?>
            
           </td>
            </tr>
          <tr>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">FIRMA PACIENTE:</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">CI:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_n[4];?></td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">FIRMA DEL ACOMPAÑANTE:</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">CI:</td>
            <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;">NOMBRE Y CARGO DE QUIEN ENVIA AL PACIENTE O RESPONSABLE DEL ESTABLECIMIENTO DE SALUD QUE REFIERE (C10)</td>
            </tr>
          <tr>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">NOMBRE:</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial;">
                <?php 
                $sql_med =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                $sql_med.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row_ref[25]' ";
                $result_med = mysqli_query($link,$sql_med);
                $row_med = mysqli_fetch_array($result_med);                    
                echo mb_strtoupper($row_med[0]." ".$row_med[1]." ".$row_med[2]);?>
            </td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">CARGO:</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial; text-align: center;">
                <?php 
                $sql_cm =" SELECT cargo_red_salud FROM dato_laboral WHERE idusuario='$row_ref[25]' ";
                $result_cm = mysqli_query($link,$sql_cm);
                $row_cm = mysqli_fetch_array($result_cm);                    
                echo mb_strtoupper($row_cm[0]);?>
            </td>
            <td bgcolor="#e7eaf0" rowspan="3" style="font-size: 12px; font-family: Arial;">FIRMA Y SELLO</td>
            <td colspan="4" rowspan="3" class="celda-sello" style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php
                /****** sello y firma del médico que envía al paciente (consulta aparte por si aún no existe la columna url_sello) ****/
                $sello_env = '';
                $result_se = @mysqli_query($link," SELECT url_sello FROM personal WHERE idusuario='$row_ref[25]' AND url_sello<>'' LIMIT 1 ");
                if ($result_se && $row_se = mysqli_fetch_array($result_se)) {
                  $sello_env = $row_se[0];
                }
                if ($sello_env != '' && is_file('../'.$sello_env)) { ?>
                  <img src="../<?php echo htmlspecialchars($sello_env);?>" class="sello-flotante" alt="Sello y firma"/>
              <?php } else { echo '&nbsp;'; } ?>
            </td>
            </tr>
          <tr>
            <td bgcolor="#e7eaf0" colspan="4" style="font-size: 12px; font-family: Arial;">NRO. DE TEL./CEL. CONTACTO DEL MÉDICO QUE ENVIÓ</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial; text-align: center;">
                <?php 
                $sql_tm =" SELECT celular FROM nombre_datos WHERE idusuario='$row_ref[25]' ";
                $result_tm = mysqli_query($link,$sql_tm);
                $row_tm = mysqli_fetch_array($result_tm);                    
                echo mb_strtoupper($row_tm[0]);?>
            </td>
            </tr>
          <tr>
            <td bgcolor="#e7eaf0" colspan="4" style="font-size: 12px; font-family: Arial;">NOMBRE DEL PERSONAL DE SALUD QUE ACOMPAÑA</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="12" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;">MOTIVO DE REFERENCIA (C11) SOLO MARQUE UNO</td>
            </tr>

            <?php 
                $sql_es =" SELECT especialidad_medica FROM especialidad_medica WHERE idespecialidad_medica='$row_ref[22]' ";
                $result_es = mysqli_query($link,$sql_es);
                $row_es = mysqli_fetch_array($result_es);              
            ?>    
          <tr>
            <td colspan="2" style="font-size: 12px; font-family: Arial; text-align: center;">URGENCIA </br>( <?php if ($row_ref[21] == '1') { echo $row_es[0]; } else { echo ' '; } ?> )</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial; text-align: center;">EMERGENCIA </br>(<?php if ($row_ref[21] == '2') { echo $row_es[0]; } else { echo ' '; } ?> )</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial; text-align: center;">CONSULTA EXTERNA </br>( <?php if ($row_ref[21] == '3') { echo $row_es[0]; } else { echo ' '; } ?> )</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">SERVICIOS/ESPECIALIDAD </br>( <?php if ($row_ref[21] == '4') { echo $row_es[0]; } else { echo ' '; } ?> )</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial; text-align: center;">PSAFCI: </br>( <?php if ($row_ref[21] == '6') { echo $row_es[0]; } else { echo ' '; } ?> )</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial; text-align: center;">POR TELESALUD </br>( <?php if ($row_ref[21] == '5') { echo $row_es[0]; } else { echo ' '; } ?> )</td>
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
            <td bgcolor="#e7eaf0" colspan="2" style="font-size: 12px; font-family: Arial;">NOMBRE DEL ESTABLECIMIENTO:</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_er[1];?></td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">NIVEL:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_er[2];?> - <?php echo $row_er[3];?></td>
            <td bgcolor="#e7eaf0" rowspan="2" style="font-size: 12px; font-family: Arial;">SUBSECTOR:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">Público</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">Seguridad Social</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">Privado</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">Otro</td>
          </tr>
          <tr>
            <td bgcolor="#e7eaf0" colspan="2" style="font-size: 12px; font-family: Arial;">NOMBRE DE LA PERSONA CONTACTADA:</td>
            <td colspan="5" style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                $sql_pc =" SELECT idderiva_referencia_hc, persona_contactada, idvia_comunicacion, recibe_paciente, nombre_ccdes, fecha_admision, hora_admision, idusuario_r, admitido, motivo FROM deriva_referencia_hc WHERE idreferencia_hc='$idreferencia_hc_ss' ORDER BY idderiva_referencia_hc ASC LIMIT 1 ";
                $result_pc = mysqli_query($link,$sql_pc);
                $row_pc = mysqli_fetch_array($result_pc);
                /****** al referir se guarda idusuario_r = médico que refiere (provisional); solo tras la admisión corresponde al receptor ****/
                $admitida_pc = ($row_pc && $row_pc[8] == 'SI');
                $idusuario_receptor = $admitida_pc ? $row_pc[7] : '';
                echo mb_strtoupper($row_pc[1]);?>
            </td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php if ($row_er[4]=='6') { echo 'X'; } else { } ?></td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php if ($row_er[4]=='7') { echo 'X'; } else { } ?></td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php if ($row_er[4]=='8') { echo 'X'; } else { } ?></td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php if ($row_er[4]=='9') { echo 'X'; } else { } ?></td>
          </tr>
          <tr>
            <td bgcolor="#e7eaf0" colspan="2" style="font-size: 12px; font-family: Arial;">MEDIO DE COMUNICACIÓN</td>
            <td colspan="5" style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                $sql_mco =" SELECT idvia_comunicacion, via_comunicacion FROM via_comunicacion WHERE idvia_comunicacion='$row_pc[2]' ";
                $result_mco = mysqli_query($link,$sql_mco);           
                if ($row_mco = mysqli_fetch_array($result_mco) ) {
                  echo mb_strtoupper($row_mco[1]);
                } ?>
            </td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">REPORTADO A CCES-D-A:</td>
            <td colspan="4" style="font-size: 12px; font-family: Arial;"><?php echo $row_pc[4]; ?></td>
            </tr>
          <tr>
            <td bgcolor="#e7eaf0" colspan="2" style="font-size: 12px; font-family: Arial;">NOMBRE DE QUIEN RECIBE AL PACIENTE</td>
            <td colspan="5" style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_pc[3]; ?></td>
            <td colspan="5" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            </tr>
          <tr>
            <td bgcolor="#e7eaf0" colspan="2" style="font-size: 12px; font-family: Arial;">FECHA DE RECEPCIÓN:</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                if ($admitida_pc) {
                  $fecha_e = explode('-',$row_pc[5]);
                  $fecha_rec = $fecha_e[2].'/'.$fecha_e[1].'/'.$fecha_e[0];
                  echo $fecha_rec;
                }
              ?>  
            </td>
            <td bgcolor="#e7eaf0" style="font-size: 12px; font-family: Arial;">HORA DE LLEGADA:</td>
            <td colspan="2" style="font-size: 12px; font-family: Arial; text-align: center;"><?php if ($admitida_pc) { echo $row_pc[6]; } ?></td>
            <td bgcolor="#e7eaf0" colspan="2" style="font-size: 12px; font-family: Arial;">HORA DE RECEPCIÓN:</td>
            <td colspan="3" style="font-size: 12px; font-family: Arial;">&nbsp;</td>
            </tr>
          <tr>
            <td bgcolor="#e7eaf0" colspan="7" style="font-size: 12px; font-family: Arial;">MÉDICO RESPONSABLE DEL ESTABLECIMIENTO DE SALUD RECEPTOR QUE EVALUA LOS CRITERIOS DE CALIDAD A.J.O.</td>
            <td colspan="5" style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                if ($idusuario_receptor != '') {
                  $sql_med =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                  $sql_med.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$idusuario_receptor' ";
                  $result_med = mysqli_query($link,$sql_med);
                  $row_med = mysqli_fetch_array($result_med);
                  echo mb_strtoupper($row_med[0]." ".$row_med[1]." ".$row_med[2]);
                }
              ?>
            </td>
            </tr>
          <tr>
            <td bgcolor="#466CAD" colspan="3" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;">PACIENTE ADMITIDO:</td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">
              SI ( <?php if ($row_pc[8]=='SI') { echo 'X'; } else { } ?> )
            </td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;">
              NO ( <?php if ($row_pc[8]=='NO') { echo 'X'; } else { } ?> )
            </td>
            <td bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;">MOTIVO</td>
            <td colspan="6" style="font-size: 12px; font-family: Arial;"><p><?php echo $row_pc[9];?></p></td>
            </tr>
          <tr>
            <td colspan="6" valign="bottom" class="celda-sello" style="text-align: center; font-size: 12px; font-family: Arial;">
              <?php
                /****** sello y firma del médico responsable del establecimiento receptor (consulta aparte por si aún no existe la columna url_sello) ****/
                $sello_med = '';
                $result_sm = ($idusuario_receptor != '') ? @mysqli_query($link," SELECT url_sello FROM personal WHERE idusuario='$idusuario_receptor' AND url_sello<>'' LIMIT 1 ") : false;
                if ($result_sm && $row_sm = mysqli_fetch_array($result_sm)) {
                  $sello_med = $row_sm[0];
                }
                if ($sello_med != '' && is_file('../'.$sello_med)) { ?>
                  <img src="../<?php echo htmlspecialchars($sello_med);?>" class="sello-flotante" alt="Sello y firma"/>
              <?php } ?>
              FIRMA , SELLO DEL MÉDICO RESPONSABLE</td>
            <td colspan="6" valign="top" style="text-align: center; font-size: 12px; font-family: Arial;"><table width="489" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td colspan="3" rowspan="2" bgcolor="#466CAD" style="text-align: center; color: #FFFFFF; font-size: 12px; font-family: Arial;">CALIFICACIÓN POR EL ESTABLECIMIENTO RECEPTOR colocar SI o NO</td>
                  <td bgcolor="#e7eaf0" width="37" style="text-align: center; font-size: 12px; font-family: Arial;">A</td>
                  <td bgcolor="#e7eaf0" width="39" style="text-align: center; font-size: 12px; font-family: Arial;">J</td>
                  <td bgcolor="#e7eaf0" width="44" style="text-align: center; font-size: 12px; font-family: Arial;">O</td>
                  </tr>
                <tr>
                  <td style="font-size: 12px; font-family: Arial;"><?php echo $row_ref[26];?></td>
                  <td style="font-size: 12px; font-family: Arial;"><?php echo $row_ref[27];?></td>
                  <td style="font-size: 12px; font-family: Arial;"><?php echo $row_ref[28];?></td>
                  </tr>
                </tbody>
              </table>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p style="text-align: center">SELLO DEL ESTABLECIMIENTO RECEPTOR</p></td>
          </tr>
          <tr>
            <td colspan="2" style="text-align: center; font-size: 12px; font-family: Arial;">
            <!----- codigo QR de validacion digital BEGIN ------>  

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

    $_REQUEST['data'] = 'https://virtual-safci.minsalud.gob.bo/medi-safci/referencia_safci/imprime_formulario_d7.php?idreferencia_hc='.$idreferencia_hc_ss;
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
              <p style="text-align: center; font-size: 9px; font-family: Arial;"> Verificacion MEDI-APS</p>

            <!----- codigo QR de validacion digital END ------> 

            </td>
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
      </table>
    </tr>
    <tr>
      <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
      <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
      <td style="font-size: 12px; font-family: Arial;">&nbsp;</td>
    </tr>
  </tbody>
</table>

<!----- descarga en PDF: se genera a partir de esta misma página para que quede idéntica (tamaño carta, con sellos) ------>
<script src="../js/modules/html2canvas.min.js"></script>
<script src="../js/modules/jspdf.umd.min.js"></script>
<script>
/****** las filas que son solo una barra azul de título se marcan para no separarlas de la fila siguiente ****/
(function () {
  var filas = document.querySelectorAll('#formulario_d7 tr');
  for (var i = 0; i < filas.length; i++) {
    var c = filas[i].cells;
    if (c.length >= 1 && c[0].getAttribute('bgcolor') && c[0].getAttribute('bgcolor').toUpperCase() == '#466CAD' && c[0].colSpan >= 8)
      filas[i].classList.add('barra-titulo');
  }
})();

/****** alturas (en px de pantalla, desde el inicio del formulario) donde se puede cortar la hoja sin partir ninguna celda ****/
function cortesPermitidos(formulario) {
  var base = formulario.getBoundingClientRect().top;
  var tabla = formulario.querySelector('table');
  var celdas = [], cortes = [];
  for (var i = 0; i < tabla.rows.length; i++) {
    var fila = tabla.rows[i];
    //no se corta justo debajo de una barra azul de título, para que no quede sola al pie de la hoja
    if (!fila.classList.contains('barra-titulo'))
      cortes.push(fila.getBoundingClientRect().bottom - base);
    for (var j = 0; j < fila.cells.length; j++) {
      var r = fila.cells[j].getBoundingClientRect();
      celdas.push([r.top - base, r.bottom - base]);
    }
  }
  return cortes.filter(function (y) {
    return !celdas.some(function (c) { return c[0] < y - 1 && c[1] > y + 1; });
  });
}

function descargarPDF() {
  var boton = document.getElementById('btn_descargar_pdf');
  var formulario = document.getElementById('formulario_d7');
  boton.textContent = 'GENERANDO PDF...';

  var margen = 5, anchoHoja = 215.9, altoHoja = 279.4;
  var anchoUtil = anchoHoja - 2*margen, altoUtil = altoHoja - 2*margen;
  var escala = 3;   //resolución de la captura (unos 330 ppp en la hoja), para que el texto se vea nítido
  var cortes = cortesPermitidos(formulario);

  html2canvas(formulario, {
    scale: escala, useCORS: true, backgroundColor: '#ffffff',
    ignoreElements: function (el) { return el.classList && el.classList.contains('no-print'); },
    //html2canvas trata el recorte lateral del sello como recorte total; en la copia se quita para que el sello quede encima de las filas vecinas
    onclone: function (doc) {
      var celdas = doc.querySelectorAll('.celda-sello');
      for (var i = 0; i < celdas.length; i++) celdas[i].style.overflow = 'visible';
    }
  }).then(function (canvas) {
    var pdf = new jspdf.jsPDF({ unit: 'mm', format: 'letter', orientation: 'portrait' });
    var anchoPx = formulario.getBoundingClientRect().width;
    var altoTotal = canvas.height / escala;
    var altoHojaPx = altoUtil * anchoPx / anchoUtil;   //alto de una hoja expresado en px del formulario
    var inicio = 0, primera = true;

    while (inicio < altoTotal - 1) {
      var fin = Math.min(inicio + altoHojaPx, altoTotal);
      if (fin < altoTotal) {
        //se corta en la última fila completa que entra en la hoja
        var validos = cortes.filter(function (y) { return y > inicio + 20 && y <= fin; });
        if (validos.length) fin = validos[validos.length - 1];
      }
      var trozo = document.createElement('canvas');
      trozo.width = canvas.width;
      trozo.height = Math.round((fin - inicio) * escala);
      var ctx = trozo.getContext('2d');
      ctx.fillStyle = '#ffffff';
      ctx.fillRect(0, 0, trozo.width, trozo.height);
      ctx.drawImage(canvas, 0, Math.round(inicio * escala), canvas.width, trozo.height, 0, 0, canvas.width, trozo.height);

      if (!primera) pdf.addPage();
      //PNG sin pérdida: el texto queda nítido (JPEG lo dejaba borroso)
      pdf.addImage(trozo, 'PNG', margen, margen, anchoUtil, (fin - inicio) * anchoUtil / anchoPx, undefined, 'FAST');
      primera = false;
      inicio = fin;
    }
    pdf.save('formulario_d7_<?php echo preg_replace('/[^A-Za-z0-9_-]/', '-', $row_ref[6]); ?>.pdf');
  }).catch(function (e) {
    alert('No se pudo generar el PDF: ' + e);
  }).then(function () {
    boton.textContent = 'DESCARGAR EN PDF';
  });
}
</script>
</body>
</html>
