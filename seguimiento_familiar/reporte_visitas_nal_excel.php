
<?php	
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=REPORTE VISITAS NAL.xls");
header("Pragma: no-cache");
header("Expires: 0");?>
<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>MEDI-SAFCI VISITAS EXCEL</title>


<h4 style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">REPORTE DE VISITAS POR RIESGO PERSONAL AL <?php echo $f_emision;?></h4>

</br>
                    <form name="REPORTE_VF" action="reporte_visitas_dep_excel.php" method="post">
                        <p style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">
                        <button type="submit" class="btn btn-success">REPORTE VISITAS DEPARTAMENTAL EN EXCEL</button>
                        &nbsp;</p>
                    </form>
<table width="1000" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
              <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">SEGUIMIENTO</td>
              <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">PERSONA VISITADA</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">VISITA</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">DEPARTAMENTO</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">MUNICIPIO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ESTABLECIMIENTO</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ÁREA DE INFLUENCIA</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ESTADO DE LA VISITA</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">MÉDICO OPERATIVO</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">FECHA DE REGISTRO:</td>

		     <!--- <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">F302A</td>  --->
	        </tr>
            <?php
    $numero=1; 
    $sql =" SELECT visita_cf.idvisita_cf, visita_cf.idseguimiento_cf, visita_cf.fecha_visita, estado_visita_cf.estado_visita_cf, visita_cf.idusuario,";
    $sql.="  visita_cf.fecha_registro, visita_cf.hora_registro, visita_cf.numero_visita FROM visita_cf, estado_visita_cf  ";
    $sql.=" WHERE visita_cf.idestado_visita_cf=estado_visita_cf.idestado_visita_cf ORDER BY visita_cf.idvisita_cf DESC ";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);           
    while ($field = mysqli_fetch_field($result)){
    } do {

        $sql_v =" SELECT seguimiento_cf.idcarpeta_familiar, carpeta_familiar.codigo, nombre.nombre, nombre.paterno, nombre.materno, departamento.departamento, ";
        $sql_v.=" municipios.municipio, establecimiento_salud.establecimiento_salud, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia  ";
        $sql_v.=" FROM visita_cf, seguimiento_cf, carpeta_familiar, integrante_cf, nombre, departamento, municipios, establecimiento_salud, tipo_area_influencia, area_influencia  ";
        $sql_v.=" WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf AND seguimiento_cf.idintegrante_cf=integrante_cf.idintegrante_cf AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
        $sql_v.=" AND integrante_cf.idnombre=nombre.idnombre AND carpeta_familiar.iddepartamento=departamento.iddepartamento AND carpeta_familiar.idmunicipio=municipios.idmunicipio ";
        $sql_v.=" AND carpeta_familiar.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia ";
        $sql_v.=" AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND visita_cf.idvisita_cf ='$row[0]' ";
        $result_v = mysqli_query($link,$sql_v);
        $row_v = mysqli_fetch_array($result_v); 

    ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="imprime_seguimiento_familiar.php?idcarpeta_familiar=<?php echo $row_v[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1400,height=800,top=50, left=100, scrollbars=YES'); return false;">
              <?php echo $row_v[1];?></a>  
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo mb_strtoupper($row_v[2]." ".$row_v[3]." ".$row_v[4]);?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[7];?></td>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_v[5];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_v[6];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_v[7];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_v[8]." ".$row_v[9];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[3];?></td>
              <td style="font-size: 12px; font-family: Arial;">
              <?php 
                $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                $sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row[4]' ";
                $result_r = mysqli_query($link,$sql_r);
                $row_r = mysqli_fetch_array($result_r);                    
                echo mb_strtoupper($row_r[0]." ".$row_r[1]." ".$row_r[2]);?>
              </td>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                $fecha_r = explode('-',$row[5]);
                $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                <?php echo $f_registro;?> - <?php echo $row[6];?></td>
		     <!--- <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">&nbsp;</td> --->
	        </tr>
            <?php
        $numero=$numero+1;
        }
        while ($row = mysqli_fetch_array($result));
        } else {
        }
        ?>
</body>
</html>