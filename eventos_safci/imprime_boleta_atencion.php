<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

$idatencion_safci        = $_GET['idatencion_safci'];
$idespecialidad_atencion = $_GET['idespecialidad_atencion'];


$sql_n =" SELECT atencion_safci.idatencion_safci, atencion_safci.codigo, evento_safci.codigo, departamento.departamento, red_salud.red_salud, municipios.municipio, establecimiento_salud.establecimiento_salud, ";
$sql_n.=" nombre.ci, nombre.nombre, nombre.paterno, nombre.materno, genero.genero, nombre.fecha_nac, atencion_safci.edad FROM evento_safci, atencion_safci, departamento, red_salud, municipios, establecimiento_salud, nombre, genero ";
$sql_n.=" WHERE atencion_safci.idevento_safci=evento_safci.idevento_safci AND evento_safci.iddepartamento=departamento.iddepartamento AND evento_safci.idmunicipio=municipios.idmunicipio ";
$sql_n.=" AND evento_safci.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND atencion_safci.idnombre=nombre.idnombre AND establecimiento_salud.idred_salud=red_salud.idred_salud ";
$sql_n.=" AND nombre.idgenero=genero.idgenero AND atencion_safci.idatencion_safci='$idatencion_safci' ";
$result_n=mysqli_query($link,$sql_n);
$row_n=mysqli_fetch_array($result_n);

    $sql_esp =" SELECT especialidad_medica.especialidad_medica FROM especialidad_atencion, especialidad_medica WHERE especialidad_atencion.idespecialidad_medica=especialidad_medica.idespecialidad_medica ";
    $sql_esp.=" AND especialidad_atencion.idespecialidad_atencion='$idespecialidad_atencion'";
    $result_esp=mysqli_query($link,$sql_esp);
    $row_esp=mysqli_fetch_array($result_esp); 
    ?>
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.-->
<script>var __adobewebfontsappname__="dreamweaver"</script>
<script src="http://use.edgefonts.net/arimo:n4:default.js" type="text/javascript"></script>



<table width="687" border="0" align="center">
  <tbody>
    <tr>
      <td width="179" style="text-align: center"><img src="../implementacion_safci/logo_safci_doc.png" width="116" height="84" alt=""/></td>
      <td width="351" style="text-align: center; font-family: Arial; font-size: 16px;"><p>ATENCIÓN MÉDICA</p>
      <p><?php echo $row_n[1];?></p>
      <p><?php echo $row_esp[0];?></p></td>
      <td width="142">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><table width="680" border="0">
        <tbody>
          <tr>
            <td colspan="2" style="text-align: right; font-size: 12px; font-family: Arial;">&nbsp;</td>
            <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            </tr>

          <tr>
            <td colspan="4" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>EVENTO:<?php echo $row_n[2];?></strong></td>
            </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px; text-align: right;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px; text-align: right;">&nbsp;</td>
            <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
          </tr>
          <tr>
            <td width="173" style="font-family: Arial; font-size: 12px; text-align: right;">DEPARTAMENTO:</td>
            <td width="156" style="font-family: Arial; font-size: 12px;"><?php echo $row_n[3];?></td>
            <td width="204" style="font-family: Arial; font-size: 12px; text-align: right;">RED DE SALUD:</td>
            <td width="129" style="font-family: Arial; font-size: 12px;"><?php echo $row_n[4];?></td>
          </tr>
          <tr>
            <td style="font-size: 12px; font-family: Arial; text-align: right;">MUNICIPIO:</td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row_n[5];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: right;">ESTABLECIMIENTO DE SALUD:</td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row_n[6];?></td>
          </tr>

        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="3" style="font-family: Arial; font-size: 14px; text-align: center;" ><strong>1.- DATOS PERSONALES DEL PACIENTE</strong></td>
    </tr>
    <tr>
      <td colspan="3"><table width="680" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td colspan="2" style="font-family: Arial; font-size: 12px; text-align: right;">CÉDULA DE IDENTIDAD:</td>
            <td colspan="2" style="font-family: Arial; font-size: 12px;"><?php echo $row_n[7];?></td>
            </tr>
          <tr>
            <td width="168" style="font-family: Arial; font-size: 12px; text-align: right;">NOMBRES:</td>
            <td width="160" style="font-family: Arial; font-size: 12px;"><?php echo $row_n[8];?></td>
            <td width="168" style="font-family: Arial; font-size: 12px; text-align: right;">PRIMER APELLIDO:</td>
            <td width="166" style="font-size: 12px; font-family: Arial;"><?php echo $row_n[9];?></td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px; text-align: right;">SEGUNDO APELLIDO:</td>
            <td style="font-size: 12px; font-family: Arial;"><?php echo $row_n[10];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: right;"><span style="font-family: Arial">FECHA DE NACIMIENTO:</span></td>
            <td style="font-size: 12px; font-family: Arial;">
            <?php 
                  $fecha_n = explode('-',$row_n[12]);
                  $fecha_nac = $fecha_n[2].'/'.$fecha_n[1].'/'.$fecha_n[0];
                  echo $fecha_nac; ?>
            </td>
          </tr>
          <tr>
            <td width="168" style="font-family: Arial; font-size: 12px; text-align: right;">GENERO:</td>
            <td width="160" style="font-family: Arial; font-size: 12px;"><?php echo $row_n[11];?></td>
            <td width="168" style="font-family: Arial; font-size: 12px; text-align: right;">EDAD:</td>
            <td width="166" style="font-size: 12px; font-family: Arial;"><?php echo $row_n[13];?></td>
          </tr>

        </tbody>
      </table></td>
    </tr>

    <tr>
      <td colspan="3" style="font-family: Arial; font-size: 14px; text-align: center;" ><strong>2.- SIGNOS VITALES</strong></td>
    </tr>
<?php
$sql_sg =" SELECT idsigno_vital, frec_cardiaca, peso, talla, imc, frec_respiratoria, presion_arterial, temperatura, saturacion, combe FROM signo_vital WHERE idatencion_safci ='$idatencion_safci' ";
$result_sg=mysqli_query($link,$sql_sg);
$row_sg=mysqli_fetch_array($result_sg);
?>
    <tr>
      <td colspan="3"><table width="680" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="217" style="font-family: Arial; font-size: 12px; text-align: right;">FRECUENCIA CARDIACA [lpm]::</td>
            <td width="111" style="text-align: center; font-family: ARIAL; font-style: normal; font-weight: 400; font-size: 12px;"><?php echo $row_sg[1];?></td>
            <td width="217" style="font-family: Arial; font-size: 12px; text-align: right;">PESO [kg]:</td>
            <td width="117" style="text-align: center; font-family: ARIAL; font-size: 12px;"><?php echo $row_sg[2];?></td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px; text-align: right;">TALLA [mtrs.]:</td>
            <td style="text-align: center; font-family: ARIAL; font-size: 12px;"><?php echo $row_sg[3];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: right;">I.M.C.:</td>
            <td style="text-align: center; font-family: ARIAL; font-size: 12px;"><?php echo $row_sg[4];?></td>
          </tr>
          <tr>
            <td width="217" style="font-family: Arial; font-size: 12px; text-align: right;">FRECUENCIA RESPIRATORIA [cpm]:</td>
            <td width="111" style="text-align: center; font-family: ARIAL; font-size: 12px;"><?php echo $row_sg[5];?></td>
            <td width="217" style="font-family: Arial; font-size: 12px; text-align: right;">PRESIÓN ARTERIAL [mmHg]:</td>
            <td width="117" style="text-align: center; font-family: ARIAL; font-size: 12px;"><?php echo $row_sg[6];?></td>
          </tr>
          <tr>
            <td width="217" style="font-family: Arial; font-size: 12px; text-align: right;">TEMPERATURA [°C]:</td>
            <td width="111" style="text-align: center; font-family: ARIAL; font-size: 12px;"><?php echo $row_sg[7];?></td>
            <td width="217" style="font-family: Arial; font-size: 12px; text-align: right;">SATURACIÓN [% O2]:</td>
            <td width="117" style="text-align: center; font-family: ARIAL; font-size: 12px;"><?php echo $row_sg[8];?></td>
          </tr>
          <tr>
            <td colspan="2" style="font-family: Arial; font-size: 12px; text-align: right;">COMBE:</td>
            <td colspan="2" style="font-family: Arial; font-size: 12px;"><?php echo $row_sg[9];?></td>
            </tr>

        </tbody>
      </table></td>
    </tr>


    <tr>
      <td colspan="3" style="font-family: Arial; font-size: 14px; text-align: center;" ><strong>3.- DIAGNÓSTICO MÉDICO:</strong></td>
    </tr>
    <tr>
      <td colspan="3">
          <?php
            $numero=1;
            $sql_s =" SELECT diagnostico_atencion.iddiagnostico_atencion, patologia.patologia, patologia.cie, diagnostico_atencion.diagnostico_atencion, diagnostico_atencion.etapa, ";
            $sql_s.=" diagnostico_atencion.idpatologia, nombre.nombre, nombre.paterno, nombre.materno FROM diagnostico_atencion, patologia, usuarios, nombre ";
            $sql_s.=" WHERE diagnostico_atencion.idpatologia=patologia.idpatologia AND diagnostico_atencion.idusuario=usuarios.idusuario AND usuarios.idnombre=nombre.idnombre ";
            $sql_s.=" AND diagnostico_atencion.idespecialidad_atencion='$idespecialidad_atencion' ORDER BY patologia.patologia  ";
            $result_s = mysqli_query($link,$sql_s);
            if ($row_s = mysqli_fetch_array($result_s)){
            mysqli_field_seek($result_s,0);
            while ($field_s = mysqli_fetch_field($result_s)){
            } do {
           ?>

        <table width="680" border="1" cellspacing="0">
          <tbody>
          <tr>
            <td width="30" style="text-align: center; font-family: Arial; font-size: 12px;">N°</td>
            <td width="207" style="font-family: Arial; font-size: 12px; text-align: center;">PATOLOGÍA</td>
            <td width="41" style="font-family: Arial; font-size: 12px; text-align: center;">CIE</td>
            <td width="234" style="font-size: 12px; font-family: Arial; text-align: center;">DIAGNÓSTICO</td>
            <td width="146" style="font-size: 12px; font-family: Arial; text-align: center;">DIAGNOSTICADO POR:</td>
            </tr>


          <tr>
            <td style="text-align: center; font-family: Arial; font-size: 12px;"><?php echo $numero;?></td>
            <td style="text-align: center; font-family: Arial; font-size: 12px;"><?php echo $row_s[1];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_s[2];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_s[3];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo mb_strtoupper($row_s[6]." ".$row_s[7]." ".$row_s[8]);?></td>
          </tr>
          <tr>
            <td colspan="5" style="text-align: center; font-family: Arial; font-size: 12px;">TRATAMIENTO MÉDICO</td>
            </tr>
          <tr>
            <td colspan="5" style="text-align: center; font-family: Arial; font-size: 10px;"><table width="666" border="0" cellspacing="0">
              <tbody>
                  <tr>
                    <td width="84" style="text-align: center; font-size: 12px;">CANTIDAD</td>
                    <td width="103" style="text-align: center; font-size: 12px;">TIPO</td>
                    <td width="237" style="text-align: center; font-size: 12px;">MEDICAMENTO</td>
                    <td width="234" style="text-align: center; font-size: 12px;">INDICACIONES</td>
                    </tr>
            <?php
               
                $sql4 =" SELECT tratamiento.idtratamiento, tipo_medicamento.tipo_medicamento, medicamento.medicamento, tratamiento.cantidad_recetada, tratamiento.indicacion  ";
                $sql4.=" FROM tratamiento, tipo_medicamento, medicamento WHERE tratamiento.idtipo_medicamento=tipo_medicamento.idtipo_medicamento AND ";
                $sql4.=" tratamiento.idmedicamento=medicamento.idmedicamento AND tratamiento.iddiagnostico_atencion='$row_s[0]' ";
                $result4 = mysqli_query($link,$sql4);
                if ($row4 = mysqli_fetch_array($result4)){
                mysqli_field_seek($result4,0);
                while ($field4 = mysqli_fetch_field($result4)){
                } do { 
                ?>
                  <tr>
                    <td style="text-align: center; font-size: 12px;"><?php echo $row4[3];?></td>
                    <td style="text-align: center; font-size: 12px;"><?php echo $row4[1];?></td>
                    <td style="text-align: center; font-size: 12px;"><?php echo $row4[2];?></td>
                    <td style="text-align: center; font-size: 12px;"><?php echo $row4[4];?></td>
                  </tr>
                <?php
                    
                    }
                    while ($row4 = mysqli_fetch_array($result4));
                    } else {
                    }
                ?>
                    
                </tbody>
            </table></td>
            </tr>

            </tbody>
      </table>
</br>
          <?php
          $numero=$numero+1;
          }
          while ($row_s = mysqli_fetch_array($result_s));
          } else {
          }
          ?>

</td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
  </tbody>
</table>
