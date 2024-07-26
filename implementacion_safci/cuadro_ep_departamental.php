<?php include("../cabf.php"); ?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");
$idsospecha_diag_nal = $_GET['sospecha_diag_nal'];

$sql_sos = " SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idsospecha_diag='$idsospecha_diag_nal' ";
$result_sos = mysqli_query($link,$sql_sos);
$row_sos = mysqli_fetch_array($result_sos);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUADRO DEPARTAMENTAL</title>
</head>
<body>
    
<h2 style="text-align: center; font-family: Arial; font-size: 14px; color: #2D56CF;">DEPARTAMENTOS CON SOSPECHAS DE <?php echo mb_strtoupper($row_sos[1]);?></h2>
		<table width="700" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
              <td width="199" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">DEPARTAMENTO</td>
              <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° SOSPECHAS</td>
		      <td width="101" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">REPORTE </td>
		      <td width="121" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">GRUPOS ETAREOS</td>
		     <!--- <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">F302A</td>  --->
	        </tr>
            <?php
    $numero=1; 
    $sql =" SELECT notificacion_ep.iddepartamento, departamento.departamento FROM notificacion_ep, registro_enfermedad,  departamento ";
    $sql.=" WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND notificacion_ep.iddepartamento=departamento.iddepartamento AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_nal'  ";
    $sql.=" AND notificacion_ep.estado='CONSOLIDADO' AND notificacion_ep.gestion='$gestion' GROUP BY notificacion_ep.iddepartamento ORDER BY notificacion_ep.iddepartamento ";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);           
    while ($field = mysqli_fetch_field($result)){
    } do {

        $sql_c =" SELECT SUM(registro_enfermedad.cifra) FROM notificacion_ep, registro_enfermedad ";
        $sql_c.=" WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep ";
        $sql_c.=" AND notificacion_ep.estado='CONSOLIDADO' AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_nal' ";
        $sql_c.=" AND notificacion_ep.gestion='$gestion' AND notificacion_ep.iddepartamento='$row[0]' ";
        $result_c = mysqli_query($link,$sql_c);
        $row_c = mysqli_fetch_array($result_c);

    ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero;?></td>
              <td style="font-size: 12px; font-family: Arial;"><?php echo $row[1];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_c[0];?></td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="marco_ep_departamental.php?sospecha_diag_deptal=<?php echo $idsospecha_diag_nal;?>&departamento_ep=<?php echo $row[0];?>" target="_blank" class="Estilo12" style="font-size: 12px; font-family: Arial;" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=400'); return false;">REPORTE</a>
              </td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="piramide_sospechas_deptal.php?sospecha_diag_deptal=<?php echo $idsospecha_diag_nal;?>&departamento_ep=<?php echo $row[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=400,scrollbars=YES,top=50,left=300'); return false;">             
              GRUPOS</a>
              </td>
		     <!--- <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">&nbsp;</td> --->
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