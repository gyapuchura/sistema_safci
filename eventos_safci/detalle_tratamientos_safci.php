<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idmedicamento  =  $_GET['idmedicamento'];

$sql_med = " SELECT idmedicamento, medicamento FROM medicamento WHERE idmedicamento='$idmedicamento' ";
$result_med = mysqli_query($link,$sql_med);
$row_med = mysqli_fetch_array($result_med);
$medicamento = $row_med[1];

?>
<table width="1200" border="0" align="center">
  <tbody>
    <tr>
      <td width="313"><img src="../implementacion_safci/mds_logo.jpg" width="306" height="87" alt=""/></td>
      <td width="595" style="text-align: center; font-family: Arial; font-size: 16px;"><p>TRATAMNIENTOS QUE INCLUYEN AL MEDICAMENTO: </p>
      <p><strong><?php echo strtoupper($medicamento); ?></strong></p></td>
      <td width="278" align="center"><img src="../implementacion_safci/logo_safci_doc.png" width="178" height="109" alt=""/>&nbsp;</td>
    </tr>

    <tr>
      <td colspan="3"><table width="1200" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="27" style="font-family: Arial; font-size: 12px; text-align: center;">N°</td> 
            <td width="120" style="font-family: Arial; font-size: 12px; font-style: normal; text-align: center;">CÓDIGO ATENCIÓN</td> 
            <td width="125" style="font-family: Arial; font-size: 12px; text-align: center;">ESPECIALIDAD</td> 
            <td width="262" style="font-family: Arial; font-size: 12px; font-style: normal; text-align: center;">NOMBRE(S) Y APELLIDO(S)</td> 
            <td width="47" style="font-family: Arial; font-size: 12px; text-align: center;">EDAD</td> 
            <td width="83" style="font-family: Arial; font-size: 12px; text-align: center;">SEXO</td> 
            <td width="311" style="font-family: Arial; font-size: 12px; text-align: center;">DIAGNOSTICO</td> 
            <td width="191" style="font-family: Arial; font-size: 12px; text-align: center;">TRATAMIENTO</td> 
          </tr>
          <?php
                $numero=1;
                $sql =" SELECT idtratamiento, idevento_safci, idatencion_safci, idespecialidad_atencion FROM tratamiento   ";
                $sql.=" WHERE entregado_farmacia='SI' AND idmedicamento='$idmedicamento' ";
                $result = mysqli_query($link,$sql);
                if ($row = mysqli_fetch_array($result)){
                mysqli_field_seek($result,0);
                while ($field = mysqli_fetch_field($result)){
                } do {

                  $sql0 =" SELECT especialidad_atencion.idespecialidad_atencion, atencion_safci.codigo, especialidad_medica.especialidad_medica, nombre.ci, nombre.nombre, nombre.paterno, nombre.materno, ";
                  $sql0.=" atencion_safci.edad, genero.genero FROM especialidad_atencion, atencion_safci, nombre, especialidad_medica, genero ";
                  $sql0.=" WHERE especialidad_atencion.idatencion_safci=atencion_safci.idatencion_safci AND nombre.idgenero=genero.idgenero ";
                  $sql0.=" AND atencion_safci.idnombre=nombre.idnombre AND atencion_safci.idatencion_safci='$row[2]' AND especialidad_atencion.idespecialidad_atencion='$row[3]' ";
                  $sql0.=" AND especialidad_atencion.idespecialidad_medica=especialidad_medica.idespecialidad_medica ORDER BY atencion_safci.idatencion_safci DESC ";
                  $result0 = mysqli_query($link,$sql0);
                  $row0 = mysqli_fetch_array($result0);

                ?>
          <tr>
            <td height="34" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $numero;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row0[1];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row0[2];?></td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row0[4]." ".$row0[5]." ".$row0[6]);?></td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row0[7];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row0[8];?></td>
            <td style="font-family: Arial; font-size: 10px;"><?php
                $numero4=1;
                $sql4 =" SELECT diagnostico_atencion.iddiagnostico_atencion, patologia.patologia, patologia.cie, diagnostico_atencion.diagnostico_atencion ";
                $sql4.=" FROM diagnostico_atencion, patologia WHERE diagnostico_atencion.idpatologia=patologia.idpatologia ";
                $sql4.=" AND diagnostico_atencion.idespecialidad_atencion='$row0[0]' ORDER BY patologia.patologia ";
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
            $sql7.=" tratamiento.idmedicamento=medicamento.idmedicamento AND tratamiento.idespecialidad_atencion='$row0[0]' ";
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
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
  </tbody>
</table>
