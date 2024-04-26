<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion    = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idsospecha_diag_ss         = $_SESSION['idsospecha_diag_ss'];
$iddepartamento_ss          = $_SESSION['iddepartamento_ss'];

$sql0 =" SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento_ss' ";
$result0 = mysqli_query($link,$sql0);
$row0 = mysqli_fetch_array($result0);

$sql_sos = " SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idsospecha_diag='$idsospecha_diag_ss' ";
$result_sos = mysqli_query($link,$sql_sos);
$row_sos = mysqli_fetch_array($result_sos);

?>
<table width="1200" border="0" align="center">
  <tbody>
    <tr>
      <td width="313"><img src="../implementacion_safci/mds_logo.jpg" width="306" height="87" alt=""/></td>
      <td width="595" style="text-align: center; font-family: Arial; font-size: 16px;"><p><?php echo $row_sos[1];?> </p>
      <p><strong>REPORTE - SEGUIMIENTO A FICHAS EPIDEMIOLÓGICAS</strong></p></td>
      <td width="278" align="center"><img src="../implementacion_safci/logo_safci_doc.png" width="178" height="109" alt=""/>&nbsp;</td>
    </tr>
    <tr>
      <td style="font-family: Arial; font-size: 12px;">DEPARTAMENTO: <?php echo $row0[1];?>   </td>
      <td style="font-family: Arial; font-size: 12px;"> </td>
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
            <td width="300" style="font-family: Arial; font-size: 12px; font-style: normal; text-align: center;">CÓDIGO FICHA</td>
            <td width="100" style="font-family: Arial; font-size: 12px; text-align: center;">FECHA REGISTRO</td>
            <td width="200" style="font-family: Arial; font-size: 12px; font-style: normal; text-align: center;">MUNICIPIO</td>
            <td width="250" style="font-family: Arial; font-size: 12px; text-align: center;">ESTABLECIMIENTO</td>
            <td width="300" style="font-family: Arial; font-size: 12px; text-align: center;">PACIENTE</td>
            <td width="80" style="font-family: Arial; font-size: 12px; text-align: center;">CELULAR</td>
            <td width="100" style="font-family: Arial; font-size: 12px; text-align: center;">SEMANA EPID.</td>
            <td width="150" style="font-family: Arial; font-size: 12px; text-align: center;">SEGUIMIENTO - MÉDICO</td>
          </tr>
          <?php
                $numero=1;
                $sql =" SELECT ficha_ep.idficha_ep, ficha_ep.codigo, nombre.ci, nombre.nombre, nombre.paterno, nombre.materno, ficha_ep.celular,  ficha_ep.idregistro_enfermedad, ficha_ep.idnotificacion_ep, registro_enfermedad.idsospecha_diag, registro_enfermedad.idgrupo_etareo, ";
                $sql.=" registro_enfermedad.idgenero, red_salud.idred_salud, notificacion_ep.idmunicipio, notificacion_ep.idestablecimiento_salud, ficha_ep.fecha_registro, municipios.municipio, establecimiento_salud.establecimiento_salud FROM ficha_ep, registro_enfermedad, notificacion_ep, establecimiento_salud, red_salud, municipios, nombre ";
                $sql.=" WHERE ficha_ep.idregistro_enfermedad=registro_enfermedad.idregistro_enfermedad  AND registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND notificacion_ep.idmunicipio=municipios.idmunicipio ";
                $sql.=" AND notificacion_ep.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND establecimiento_salud.idred_salud=red_salud.idred_salud AND ficha_ep.idnombre=nombre.idnombre AND notificacion_ep.gestion='$gestion' ";
                $sql.=" AND ficha_ep.direccion !='' AND nombre.nombre !='' AND notificacion_ep.iddepartamento='$iddepartamento_ss' AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_ss' ORDER BY ficha_ep.fecha_registro DESC ";
                $result = mysqli_query($link,$sql);
                if ($row = mysqli_fetch_array($result)){
                mysqli_field_seek($result,0);
                while ($field = mysqli_fetch_field($result)){
                } do {

                    $sql2 = " SELECT seguimiento_ep.idseguimiento_ep, semana_ep.semana_ep, estado_paciente.estado_paciente FROM seguimiento_ep, semana_ep, estado_paciente ";
                    $sql2.= " WHERE seguimiento_ep.idsemana_ep=semana_ep.idsemana_ep AND seguimiento_ep.idestado_paciente=estado_paciente.idestado_paciente AND";
                    $sql2.= " seguimiento_ep.idficha_ep='$row[0]' ORDER BY seguimiento_ep.idseguimiento_ep DESC LIMIT 1 ";
                    $result2 = mysqli_query($link,$sql2);

                ?>
          <tr>
            <td height="34" style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $numero;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row[1];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">
            <?php 
                $fecha_r = explode('-',$row[15]);
                $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                <?php echo $f_registro;?></td>
            <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[16];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row[17];?></td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[3]." ".$row[4]." ".$row[5]);?></td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[6];?></td>
            <td style="font-family: Arial; font-size: 12px;">
            <?php             
                                if($row2 = mysqli_fetch_array($result2))
                                {echo "Semana ".$row2[1];}
                                ?>
            </td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row2[2];?></td>
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
  </tbody>
</table>
