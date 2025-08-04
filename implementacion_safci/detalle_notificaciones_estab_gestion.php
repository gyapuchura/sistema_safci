<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");
$gestion    = $_GET['gestion'];

$idmunicipio = $_GET['idmunicipio'];
$idestablecimiento_salud = $_GET['idestablecimiento_salud'];
$idsospecha_diag_estab = $_GET['idsospecha_diag'];

$sqlm =" SELECT municipios.idmunicipio, municipios.municipio, departamento.departamento FROM departamento, municipios WHERE municipios.iddepartamento=departamento.iddepartamento AND municipios.idmunicipio='$idmunicipio' ";
$resultm = mysqli_query($link,$sqlm);
$rowm = mysqli_fetch_array($resultm);

$sqle =" SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud'";
$resulte = mysqli_query($link,$sqle);
$rowe = mysqli_fetch_array($resulte);

$sql_sos =" SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idsospecha_diag='$idsospecha_diag_estab'";
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

  <title>NOTIFICACIONES EPIDEMIOLOGICAS DEPARTAMENTO</title>
</head>
	<body>
  <h3 style="font-family: Arial; text-align: center;">NOTIFICACIONES PARA LA VIGILANCIA EPIDEMIOLÓGICA - GESTIÓN <?php echo $gestion;?> </h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;">Departamento: <?php echo $rowm[2];?> - Municipio: <?php echo $rowm[1];?></h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;">Establecimiento: <?php echo $rowe[1];?></h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;"><?php echo $row_sos[1];?> </h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;">N° de Casos en el Establecimiento: <?php echo $cifra_establecimiento;?></h3>

	<table width="664" border="1" align="center">
	  <tbody>
        <tr>
            <td width="17" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>N°</strong></td>
            <td width="62" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>CÓDIGO</strong></td>
            <td width="54" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>SEMANA EP.</strong></td>	
            <td width="54" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>N° SOSPECHAS</strong></td>	
            <td width="52" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>USUARIO</strong></td>
            <td width="47" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>FECHA</strong></td>
            <td width="51" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>VER F302A</strong></td>		
        </tr>

        <?php
            $numero=1;
            $sql =" SELECT notificacion_ep.idnotificacion_ep, notificacion_ep.codigo, departamento.departamento, red_salud.red_salud,  ";
            $sql.=" municipios.municipio, establecimiento_salud.establecimiento_salud, notificacion_ep.semana_ep, ";
            $sql.=" notificacion_ep.fecha_registro, notificacion_ep.hora_registro, nombre.nombre, nombre.paterno, nombre.materno, ";
            $sql.=" notificacion_ep.iddepartamento, notificacion_ep.idred_salud, notificacion_ep.idmunicipio, notificacion_ep.idestablecimiento_salud, notificacion_ep.estado ";
            $sql.=" FROM notificacion_ep, departamento, red_salud, municipios, establecimiento_salud, usuarios, nombre WHERE notificacion_ep.iddepartamento=departamento.iddepartamento ";
            $sql.=" AND notificacion_ep.idred_salud=red_salud.idred_salud AND notificacion_ep.idmunicipio=municipios.idmunicipio AND notificacion_ep.gestion='$gestion' ";
            $sql.=" AND notificacion_ep.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND notificacion_ep.idusuario=usuarios.idusuario ";
            $sql.=" AND usuarios.idnombre=nombre.idnombre AND notificacion_ep.estado='CONSOLIDADO' AND notificacion_ep.idestablecimiento_salud='$idestablecimiento_salud'";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {

              $sql7 = " SELECT SUM(registro_enfermedad.cifra) FROM registro_enfermedad, notificacion_ep WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep ";
              $sql7.= " AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_estab' AND notificacion_ep.semana_ep='$row[6]' ";
              $sql7.= " AND registro_enfermedad.gestion='$gestion' AND notificacion_ep.idestablecimiento_salud='$idestablecimiento_salud' ";
              $sql7.= " AND notificacion_ep.estado='CONSOLIDADO'";
              $result7 = mysqli_query($link,$sql7);
              $row7 = mysqli_fetch_array($result7);
              $cifra_semanal = $row7[0];

            ?>

	    <tr>
        <td style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $numero;?></td>
        <td style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $row[1];?></td>
        <td style="font-family: Arial; font-size: 12px; text-align: center"><?php echo "Semana ".$row[6];?></td>
        <td style="font-family: Arial; font-size: 12px; text-align: center"><?php echo $cifra_semanal;?></td>
        <td style="font-family: Arial; font-size: 12px; text-align: center"><?php echo mb_strtoupper($row[9]." ".$row[10]." ".$row[11]);?></td>
        <td style="font-family: Arial; font-size: 12px; text-align: center">
        <?php 
            $fecha_r = explode('-',$row[7]);
            $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
        <?php echo $f_registro;?> </br> <?php echo $row[16];?></td>
        <td style="font-family: Arial; font-size: 12px; text-align: center">
        <a href="imprime_notificacion_ep.php?idnotificacion_ep=<?php echo $row[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=650,scrollbars=YES,top=50,left=200'); return false;">F-302A</a>
        </td>
        </tr>
        <?php
            $numero=$numero+1;  
            }
            while ($row = mysqli_fetch_array($result));
            } else {
            }
            ?>

      </tbody>
    </table>




</body>
</html>
