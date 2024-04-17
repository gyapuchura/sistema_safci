<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");
$gestion    = date("Y");

$idsospecha_diag   = $_GET['idsospecha_diag'];
$iddepartamento    = $_GET['iddepartamento'];
$idestado_paciente = $_GET['idestado_paciente'];

$sqld =" SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento' ";
$resultd = mysqli_query($link,$sqld);
$rowd = mysqli_fetch_array($resultd);

$sqle =" SELECT idestado_paciente, estado_paciente FROM estado_paciente WHERE idestado_paciente='$idestado_paciente'";
$resulte = mysqli_query($link,$sqle);
$rowe = mysqli_fetch_array($resulte);

$sql_sos =" SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idsospecha_diag='$idsospecha_diag'";
$result_sos = mysqli_query($link,$sql_sos);
$row_sos = mysqli_fetch_array($result_sos);

$gestion       =  date("Y");

$sql8 = " SELECT SUM(registro_enfermedad.cifra) FROM registro_enfermedad, notificacion_ep ";
$sql8.= " WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
$sql8.= " AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_estab' AND registro_enfermedad.gestion='$gestion' ";
$sql8.= " AND notificacion_ep.idestablecimiento_salud='$idestablecimiento_salud' AND notificacion_ep.estado='CONSOLIDADO'";
$result8 = mysqli_query($link,$sql8);
$row8 = mysqli_fetch_array($result8);
$cifra_establecimiento = $row8[0];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>FICHAS EPIDEMIOLGICAS DEPARTAMENTO</title>
</head>
	<body>
  <h3 style="font-family: Arial; text-align: center;">FICHAS DE SEGUIMIENTO - SAFCI MI SALUD</h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;">Departamento: <?php echo $rowd[1];?></h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;"><?php echo $row_sos[1];?> </h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;">N° de Casos con seguimiento: <?php echo $rowe[1];?></h3>

	<table width="664" border="1" align="center">
	  <tbody>
        <tr>
            <td width="17" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>N°</strong></td>
            <td width="62" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>CÓDIGO FICHA</strong></td>
            <td width="54" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>MUNICIPIO</strong></td>	
            <td width="54" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>ESTABLECIMIENTO</strong></td>	
            <td width="47" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>FECHA DE REGISTRO</strong></td>
            <td width="51" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>VER F302A</strong></td>		
        </tr>

        <?php
        $cantidad=0;
        $sql3 ="  SELECT ficha_ep.idficha_ep, ficha_ep.codigo, municipios.municipio, establecimiento_salud.establecimiento_salud, ficha_ep.fecha_registro FROM ficha_ep, registro_enfermedad, notificacion_ep, establecimiento_salud, red_salud, municipios, nombre ";
        $sql3.=" WHERE ficha_ep.idregistro_enfermedad=registro_enfermedad.idregistro_enfermedad  AND registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND notificacion_ep.idmunicipio=municipios.idmunicipio ";
        $sql3.=" AND notificacion_ep.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND establecimiento_salud.idred_salud=red_salud.idred_salud AND ficha_ep.idnombre=nombre.idnombre AND notificacion_ep.gestion='$gestion' ";
        $sql3.=" AND ficha_ep.direccion !='' AND notificacion_ep.iddepartamento='$iddepartamento' AND registro_enfermedad.idsospecha_diag='$idsospecha_diag' ORDER BY ficha_ep.fecha_registro DESC ";
        $result3 = mysqli_query($link,$sql3);
        if ($row3 = mysqli_fetch_array($result3)){
        mysqli_field_seek($result3,0);
        while ($field3 = mysqli_fetch_field($result3)){
        } do {

            $sql2 = " SELECT seguimiento_ep.idseguimiento_ep, semana_ep.semana_ep, estado_paciente.estado_paciente, seguimiento_ep.idestado_paciente FROM seguimiento_ep, semana_ep, estado_paciente ";
            $sql2.= " WHERE seguimiento_ep.idsemana_ep=semana_ep.idsemana_ep AND seguimiento_ep.idestado_paciente=estado_paciente.idestado_paciente AND";
            $sql2.= " seguimiento_ep.idficha_ep='$row3[0]' ORDER BY seguimiento_ep.idseguimiento_ep DESC LIMIT 1 ";
            $result2 = mysqli_query($link,$sql2);
            $row2    = mysqli_fetch_array($result2);
            if ($row2[3] == $idestado_paciente) { 
        ?> 
          <tr>
            <td style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $cantidad+1;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row3[1];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row3[2];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row3[3];?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center">
            <?php 
                $fecha_r = explode('-',$row3[4]);
                $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
            <?php echo $f_registro;?></td>
            <td style="font-family: Arial; font-size: 12px; text-align: center">
            <a href="imprime_ficha_ep.php?idficha_ep=<?php echo $row3[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=850,scrollbars=YES,top=50,left=200'); return false;">FICHA SEGUIMIENTO</a>
            </td>
            </tr>
      <?php    
      $cantidad=$cantidad+1; } else { }      
        }
      while ($row3 = mysqli_fetch_array($result3));
      } else {
      }        
      ?>


      </tbody>
    </table>




</body>
</html>
