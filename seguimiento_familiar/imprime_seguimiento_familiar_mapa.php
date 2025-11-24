<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$hora     = date("H:i");
$mes      = date('m');
$gestion    = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idcarpeta_familiar = $_GET['idcarpeta_familiar'];

$sql_cf =" SELECT idcarpeta_familiar, codigo, familia, fecha_apertura, idusuario FROM carpeta_familiar WHERE idcarpeta_familiar='$idcarpeta_familiar' ";
$result_cf=mysqli_query($link,$sql_cf);
$row_cf=mysqli_fetch_array($result_cf);
          
?>
<table width="1200" border="0" align="center">
  <tbody>
    <tr>
      <td width="198" style="text-align: center"><img src="../implementacion_safci/logo_safci_doc.png" width="200" height="140" alt=""/></td>
      <td width="521" style="text-align: center; color: #4E73DF; font-family: 'Arial'; font-size: 24px;">

            <button onclick="history.back();" align="center">VOLVER</button>  

        <p><strong style="text-align: center">SEGUIMIENTO A RIESGOS PERSONALES</strong></p>
        <p><strong style="text-align: center">FAMILIA : <?php echo $row_cf[2];?></strong></p>
        <p><strong style="text-align: center"><?php echo $row_cf[1];?></strong></p>
        </td>
      <td width="167">&nbsp;</td>
    </tr>
        <tr>
      <td width="198" style="text-align: center"></td>
      <td width="521" style="text-align: center; color: #4E73DF; font-family: 'Arial'; font-size: 18px;">
</br>
      <p><strong style="text-align: center">
      <?php 
      $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
      $sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row_cf[4]' ";
      $result_r = mysqli_query($link,$sql_r);
      $row_r = mysqli_fetch_array($result_r);                    
  echo mb_strtoupper("MÉDICO : ".$row_r[0]." ".$row_r[1]." ".$row_r[2]);?></strong></p>

      </td>
      <td width="167">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><table width="1200" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="50" bgcolor="#4E73DF" style="text-align: center; color: #FFFFFF; font-family: 'Arial'; font-size: 14px;"><strong>N°</strong></td>
            <td width="250" bgcolor="#4E73DF" style="font-size: 14px; font-family: 'Arial'; color: #FFFFFF; text-align: center;"><strong>INTEGRANTE</strong></td>
            <td width="100" bgcolor="#4E73DF" style="font-size: 14px; font-family: 'Arial'; color: #FFFFFF; text-align: center;"><strong>FECHA NACIMIENTO</br>/CELULAR</strong></td>
            <td width="50" bgcolor="#4E73DF" style="font-size: 14px; font-family: 'Arial'; color: #FFFFFF; text-align: center;"><strong>EDAD</strong></td>
            <td width="250" bgcolor="#4E73DF" style="font-size: 14px; color: #FFFFFF; font-family: 'Arial'; text-align: center;"><strong>RIESGO PERSONAL</strong></td>
            <td width="500" bgcolor="#4E73DF" style="font-size: 14px; color: #FFFFFF; font-family: 'Arial'; text-align: center;">CRONOGRAMA DE VISITAS PLANIFICADO</strong></td>
          </tr>
            <?php
            $numero=0;
            $sql4 =" SELECT seguimiento_cf.idseguimiento_cf, nombre.ci, nombre.complemento, nombre.paterno, nombre.materno, nombre.nombre, parentesco.parentesco, genero.genero, integrante_cf.edad, integrante_cf.estado, ";
            $sql4.=" integrante_cf.idnombre, nombre.idgenero, seguimiento_cf.fecha_inicial, riesgo_personal_vf.riesgo_personal_vf, seguimiento_cf.idfrecuencia_vf, riesgo_personal_vf.color_valor, nombre.fecha_nac, integrante_cf.celular ";
            $sql4.=" FROM integrante_cf, nombre, parentesco, genero, seguimiento_cf, riesgo_personal_vf, frecuencia_vf ";
            $sql4.=" WHERE integrante_cf.idnombre=nombre.idnombre AND integrante_cf.idparentesco=parentesco.idparentesco AND nombre.idgenero=genero.idgenero ";
            $sql4.=" AND seguimiento_cf.idriesgo_personal_vf=riesgo_personal_vf.idriesgo_personal_vf AND seguimiento_cf.idintegrante_cf=integrante_cf.idintegrante_cf ";
            $sql4.=" AND seguimiento_cf.idfrecuencia_vf=frecuencia_vf.idfrecuencia_vf AND integrante_cf.idcarpeta_familiar='$idcarpeta_familiar' ORDER BY integrante_cf.edad DESC ";
            $result4 = mysqli_query($link,$sql4);
            if ($row4 = mysqli_fetch_array($result4)){
            mysqli_field_seek($result4,0);
            while ($field4 = mysqli_fetch_field($result4)){
            } do { 
            ?>
          <tr>
            <td style="text-align: center; font-size: 12px; font-family: Arial;"><?php echo $numero+1;?></td>
            <td style="font-size: 12px; text-align: center; font-family: Arial;"><?php echo mb_strtoupper($row4[5]." ".$row4[3]." ".$row4[4]);?></br></br><?php echo $row4[6];?></td>
            <td style="text-align: center; font-size: 12px; font-family: Arial;"><?php 
                $fecha_nac = explode('-',$row4[16]);
                $f_nacimiento = $fecha_nac[2].'/'.$fecha_nac[1].'/'.$fecha_nac[0];
                echo $f_nacimiento;?></br></br>
                <?php if ($row4[17] !='' ) { echo "Cel. ".$row4[17]; } ?>  
              </td>
            <td style="text-align: center; font-size: 12px; font-family: Arial;"><?php echo $row4[8];?></td>
            <td <?php echo 'bgcolor="#'.$row4[15].'" ';?> style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row4[13];?></td>
            <td><table width="800" border="0" cellspacing="0">
              <tbody>
                <tr>

            <?php
            $numero5=1;
            $sql5 =" SELECT visita_cf.idvisita_cf, visita_cf.fecha_visita, visita_cf.numero_visita, estado_visita_cf.estado_visita_cf, estado_visita_cf.valor_color ";
            $sql5.=" FROM visita_cf, estado_visita_cf WHERE visita_cf.idestado_visita_cf=estado_visita_cf.idestado_visita_cf  ";
            $sql5.=" AND visita_cf.idseguimiento_cf='$row4[0]' ORDER BY visita_cf.idvisita_cf ";  
            $result5 = mysqli_query($link,$sql5);
            if ($row5 = mysqli_fetch_array($result5)){
            mysqli_field_seek($result5,0);
            while ($field5 = mysqli_fetch_field($result5)){
            } do { 
            ?>
              <td style="text-align: center; font-size: 12px; color: #<?php echo $row5[4];?>; font-family: Arial;">
                <?php 
                $fecha_v = explode('-',$row5[1]);
                $f_visita = $fecha_v[2].'/'.$fecha_v[1].'/'.$fecha_v[0];

                echo "</br>".$row5[2]."</br>";
                echo $row5[3]."</br></br>";
                echo $f_visita."</br></br>";
                ?>
                </td>
            <?php
              $numero5=$numero5+1;
              }
              while ($row5 = mysqli_fetch_array($result5));
              } else {
              }
            ?>                    
                </tr>
              </tbody>
            </table></td>
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
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
