<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");
$semana_ep  = date("W");
$gestion    =  date("Y");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>REPORTE EPIDEMIOLOGICO SEMANAL - SAFCI</title>
</head>
	<body>
  <h4 style="font-family: Arial; text-align: center; font-size: 12px; color: #294D7C;">REPORTE EPIDEMIOLÓGICO</h4>
  <h4 style="font-family: Arial; text-align: center; font-size: 16px; color: #294D7C;">SEMANA EP. Nº <?php echo $semana_ep;?></h4>
  <h4 style="font-family: Arial; text-align: center; font-size: 12px; color: #294D7C;">GESTIÓN <?php echo $gestion;?></h4>
	<table width="600" border="1" align="center" cellspacing="0">
	  <tbody>
        <tr>
            <td width="17" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>N°</strong></td>
            <td width="280" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>REGISTRO EPIDEMIOLÓGICO</strong></td>
            <td width="62" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>NÚMERO DE CASOS EN LA SEMANA <?php echo $semana_ep;?></strong></td>
            <td width="50" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>REPORTE NACIONAL</strong></td>
 
        </tr>

        <?php
            $numero=1;
            $sql =" SELECT registro_enfermedad.idsospecha_diag, sospecha_diag.sospecha_diag FROM notificacion_ep, registro_enfermedad, sospecha_diag WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
            $sql.=" AND registro_enfermedad.idsospecha_diag=sospecha_diag.idsospecha_diag AND notificacion_ep.gestion='$gestion' AND notificacion_ep.semana_ep='$semana_ep' ";
            $sql.=" AND registro_enfermedad.cifra !='0' GROUP BY sospecha_diag.sospecha_diag ORDER BY sospecha_diag.sospecha_diag ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {
            ?>

	    <tr>
        <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $numero;?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row[1];?></td>
        <td style="font-family: Arial; font-size: 12px; text-align: center;">
            <?php 
            $sql_c =" SELECT sum(registro_enfermedad.cifra) FROM registro_enfermedad, notificacion_ep WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
            $sql_c.=" AND registro_enfermedad.idsospecha_diag='$row[0]' AND registro_enfermedad.cifra !='0' AND notificacion_ep.gestion='$gestion' AND notificacion_ep.semana_ep='$semana_ep' ";
            $result_c = mysqli_query($link,$sql_c);
            $row_c = mysqli_fetch_array($result_c);
            $casos_semana   = number_format($row_c[0], 0, '.', '.');
            echo $casos_semana;?>
        </td>
        <td style="font-family: Arial; font-size: 12px; text-align: center;">
        <a class="btn btn-primary btn-icon-split" href="../implementacion_safci/marco_ep_nacional.php?sospecha_diag_nal=<?php echo $row[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=650,scrollbars=YES,top=50,left=300'); return false;">REPORTE</a>
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

	<p>&nbsp;</p>

</body>
</html>
