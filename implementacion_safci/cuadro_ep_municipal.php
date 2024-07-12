<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

$idsospecha_diag_deptal = $_GET['sospecha_diag_deptal'];
$iddepartamento_ep = $_GET['departamento_ep'];

$sql_sos = " SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idsospecha_diag='$idsospecha_diag_deptal' ";
$result_sos = mysqli_query($link,$sql_sos);
$row_sos = mysqli_fetch_array($result_sos);

$sql_d = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento_ep' ";
$result_d = mysqli_query($link,$sql_d);
$row_d = mysqli_fetch_array($result_d);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2 style="text-align: center; font-family: Arial; font-size: 14px; color: #2D56CF;">DEPARTAMENTO DE <?php echo mb_strtoupper($row_d[1]);?></h2>
<h2 style="text-align: center; font-family: Arial; font-size: 14px; color: #2D56CF;">MUNICIPIOS CON SOSPECHAS DE <?php echo mb_strtoupper($row_sos[1]);?></h2>
		<table width="700" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
		      <td width="199" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">MUNICIPIO</td>
              <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° SOSPECHAS</td>
		      <td width="101" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">REPORTE </td>
		      <td width="121" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">GRUPOS ETAREOS</td>
		     <!--- <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">F302A</td>  --->
	        </tr>
            <?php
    $numero_m=1; 
    $sql_m =" SELECT notificacion_ep.idmunicipio, municipios.municipio FROM notificacion_ep, registro_enfermedad, municipios ";
    $sql_m.=" WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND notificacion_ep.idmunicipio=municipios.idmunicipio AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_deptal' ";
    $sql_m.=" AND notificacion_ep.estado='CONSOLIDADO' AND notificacion_ep.gestion='$gestion' AND notificacion_ep.iddepartamento='$iddepartamento_ep' GROUP BY notificacion_ep.idmunicipio ORDER BY municipios.municipio";
    $result_m = mysqli_query($link,$sql_m);
    if ($row_m = mysqli_fetch_array($result_m)){
    mysqli_field_seek($result_m,0);           
    while ($field_m = mysqli_fetch_field($result_m)){
    } do {

        $sql_ci =" SELECT SUM(registro_enfermedad.cifra) FROM notificacion_ep, registro_enfermedad ";
        $sql_ci.=" WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep ";
        $sql_ci.=" AND notificacion_ep.estado='CONSOLIDADO' AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_deptal' ";
        $sql_ci.=" AND notificacion_ep.gestion='$gestion' AND notificacion_ep.idmunicipio='$row_m[0]' ";
        $result_ci = mysqli_query($link,$sql_ci);
        $row_ci = mysqli_fetch_array($result_ci);
    ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero_m;?></td>
		      <td style="font-size: 12px; font-family: Arial;"><?php echo $row_m[1];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_ci[0];?></td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="marco_ep_municipal.php?idsospecha_diag_mun=<?php echo $idsospecha_diag_deptal;?>&idmunicipio=<?php echo $row_m[0];?>" target="_blank" class="Estilo12" style="font-size: 12px; font-family: Arial;" onClick="window.open(this.href, this.target, 'width=1000,height=600,scrollbars=YES,top=60,left=400'); return false;">REPORTE</a>
              </td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="piramide_sospechas_mun.php?idsospecha_diag_mun=<?php echo $idsospecha_diag_deptal;?>&idmunicipio=<?php echo $row_m[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=400,scrollbars=YES,top=50,left=300'); return false;">             
              GRUPOS</a>
              </td>
		     <!--- <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">&nbsp;</td> --->
	        </tr>
            <?php
        $numero_m=$numero_m+1;
        }
        while ($row_m = mysqli_fetch_array($result_m));
        } else {
        }
        ?>
	      </tbody>
    </table>
		   
</body>
</html>