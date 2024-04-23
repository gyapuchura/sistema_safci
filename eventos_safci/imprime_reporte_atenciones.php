<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idevento_safci_ss  =  $_SESSION['idevento_safci_ss'];

$sql_ev =" SELECT evento_safci.idevento_safci, departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud,  ";
$sql_ev.=" evento_safci.codigo FROM evento_safci, departamento, municipios, establecimiento_salud WHERE  ";
$sql_ev.=" evento_safci.iddepartamento=departamento.iddepartamento AND evento_safci.idmunicipio=municipios.idmunicipio AND ";
$sql_ev.=" evento_safci.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND idevento_safci='$idevento_safci_ss' ";
$result_ev=mysqli_query($link,$sql_ev);
$row_ev=mysqli_fetch_array($result_ev);

?>
<table width="1200" border="0" align="center">
  <tbody>
    <tr>
      <td width="313"><img src="../implementacion_safci/mds_logo.jpg" width="306" height="87" alt=""/></td>
      <td width="595" style="text-align: center; font-family: Arial; font-size: 16px;"><p>EVENTO: <?php echo $row_ev[4];?> </p>
      <p><strong>PLANILLA DE ATENCION MEDICA - TRIAGE Y OTROS</strong></p></td>
      <td width="278" align="center"><img src="../implementacion_safci/logo_safci_doc.png" width="178" height="109" alt=""/>&nbsp;</td>
    </tr>
    <tr>
      <td style="font-family: Arial; font-size: 12px;">Municipio: <?php echo $row_ev[2];?>   </td>
      <td style="font-family: Arial; font-size: 12px;">Establecimiento de Salud: <?php echo $row_ev[3];?></td>
      <td style="font-size: 12px; font-family: Arial;">Fecha: 
      <?php 
              $fecha_p = explode('-',$fecha);
              $fecha_planilla = $fecha_p[2].'/'.$fecha_p[1].'/'.$fecha_p[0];
              echo $fecha_planilla; ?></td>
    </tr>
    <tr>
      <td colspan="3"><table width="1200" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="27" style="font-family: Arial; font-size: 12px; text-align: center;">N°</td>
            <td width="120" style="font-family: Arial; font-size: 12px; font-style: normal; text-align: center;">CODIGO ATENCION</td>
            <td width="125" style="font-family: Arial; font-size: 12px; text-align: center;">ESPECIALIDAD</td>
            <td width="262" style="font-family: Arial; font-size: 12px; font-style: normal; text-align: center;">NOMBRE(S) Y APELLIDO(S)</td>
            <td width="47" style="font-family: Arial; font-size: 12px; text-align: center;">EDAD</td>
            <td width="83" style="font-family: Arial; font-size: 12px; text-align: center;">SEXO</td>
            <td width="311" style="font-family: Arial; font-size: 12px; text-align: center;">DIAGNOSTICO</td>
            <td width="191" style="font-family: Arial; font-size: 12px; text-align: center;">TRATAMIENTO</td>
          </tr>
          <?php
                $numero=1;
                $sql =" SELECT especialidad_atencion.idespecialidad_atencion, atencion_safci.codigo, especialidad_medica.especialidad_medica, nombre.ci, nombre.nombre, nombre.paterno, nombre.materno, ";
                $sql.=" atencion_safci.edad, genero.genero FROM especialidad_atencion, atencion_safci, nombre, especialidad_medica, genero ";
                $sql.=" WHERE especialidad_atencion.idatencion_safci=atencion_safci.idatencion_safci AND nombre.idgenero=genero.idgenero ";
                $sql.=" AND atencion_safci.idnombre=nombre.idnombre AND atencion_safci.idevento_safci='$idevento_safci_ss' ";
                $sql.=" AND especialidad_atencion.idespecialidad_medica=especialidad_medica.idespecialidad_medica ORDER BY atencion_safci.idatencion_safci DESC ";
                $result = mysqli_query($link,$sql);
                if ($row = mysqli_fetch_array($result)){
                mysqli_field_seek($result,0);
                while ($field = mysqli_fetch_field($result)){
                } do {
                ?>
          <tr>
            <td height="34" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $numero;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row[1];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row[2];?></td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[4]." ".$row[5]." ".$row[6]);?></td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[7];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row[8];?></td>
            <td style="font-family: Arial; font-size: 10px;"><?php
                $numero4=1;
                $sql4 =" SELECT diagnostico_atencion.iddiagnostico_atencion, patologia.patologia, patologia.cie, diagnostico_atencion.diagnostico_atencion ";
                $sql4.=" FROM diagnostico_atencion, patologia WHERE diagnostico_atencion.idpatologia=patologia.idpatologia ";
                $sql4.=" AND diagnostico_atencion.idespecialidad_atencion='$row[0]' ORDER BY patologia.patologia ";
                $result4 = mysqli_query($link,$sql4);
                if ($row4 = mysqli_fetch_array($result4)){
                mysqli_field_seek($result4,0);
                while ($field4 = mysqli_fetch_field($result4)){
                } do {                                         
              ?>
              <?php echo $numero4;?>.- <?php echo $row4[3];?> - <?php echo $row4[2];?> - <?php echo $row4[1];?></br>

              <?php
                $numero4=$numero4+1;
                }
                while ($row4 = mysqli_fetch_array($result4));
                } else {
                }
              ?></td>
            <td style="font-family: Arial; font-size: 10px;">
            <?php
            $numero7=1;
            $sql7 =" SELECT tratamiento.idtratamiento, tipo_medicamento.tipo_medicamento, medicamento.medicamento, tratamiento.cantidad_recetada, tratamiento.indicacion, tratamiento.insumos  ";
            $sql7.=" FROM tratamiento, tipo_medicamento, medicamento WHERE tratamiento.idtipo_medicamento=tipo_medicamento.idtipo_medicamento AND ";
            $sql7.=" tratamiento.idmedicamento=medicamento.idmedicamento AND tratamiento.idespecialidad_atencion='$row[0]' ";
            $result7 = mysqli_query($link,$sql7);
            if ($row7 = mysqli_fetch_array($result7)){
            mysqli_field_seek($result7,0);
            while ($field7 = mysqli_fetch_field($result7)){
            } do { 
            ?>
              <?php echo $numero7;?>.- <?php echo $row7[1];?> : <?php echo $row7[2];?></br>
          <?php
              $numero7=$numero7+1;
              }
              while ($row7 = mysqli_fetch_array($result7));
              } else {
              }
          ?></td>
          </tr>
          <?php
                $numero=$numero+1;
                }
                while ($row = mysqli_fetch_array($result));
                } else {
                }
                ?>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><table width="312" border="0">
        <tbody>
          <tr>
            <td width="135">&nbsp;</td>
            <td width="85" style="text-align: center; font-family: Arial; font-size: 14px;"><strong>M</strong></td>
            <td width="85" style="font-size: 14px; font-family: Arial; text-align: center;"><strong>F</strong></td>
          </tr>
          <tr>
            <td style="font-family: Arial; font-size: 12px;"><strong>TOTAL ATENCIONES</strong></td>
            <td colspan="2"><table width="174" height="22" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td style="text-align: center; font-family: Arial; font-size: 14px;">
                  <?php               
                    $sql8 =" SELECT count(idespecialidad_atencion) FROM especialidad_atencion, atencion_safci, nombre, genero ";
                    $sql8.=" WHERE especialidad_atencion.idatencion_safci=atencion_safci.idatencion_safci AND nombre.idgenero=genero.idgenero ";
                    $sql8.=" AND atencion_safci.idnombre=nombre.idnombre AND atencion_safci.idevento_safci='$idevento_safci_ss'  ";
                    $sql8.="  AND nombre.idgenero='2' ORDER BY atencion_safci.idatencion_safci DESC ";
                    $result8 = mysqli_query($link,$sql8);
                    $row8 = mysqli_fetch_array($result8);
                    echo $row8[0];
                    ?>                  
                  </td>
                  <td style="text-align: center; font-family: Arial; font-size: 14px;">
                  <?php               
                    $sql9 =" SELECT count(idespecialidad_atencion) FROM especialidad_atencion, atencion_safci, nombre, genero ";
                    $sql9.=" WHERE especialidad_atencion.idatencion_safci=atencion_safci.idatencion_safci AND nombre.idgenero=genero.idgenero ";
                    $sql9.=" AND atencion_safci.idnombre=nombre.idnombre AND atencion_safci.idevento_safci='$idevento_safci_ss'  ";
                    $sql9.="  AND nombre.idgenero='1' ORDER BY atencion_safci.idatencion_safci DESC ";
                    $result9 = mysqli_query($link,$sql9);
                    $row9 = mysqli_fetch_array($result9);
                    echo $row9[0];
                    ?>   
                  </td>
                </tr>
              </tbody>
            </table></td>
            </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
  </tbody>
</table>
