<?php	
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=REPORTE VISITAS DEPTAL.xls");
header("Pragma: no-cache");
header("Expires: 0");?>
<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram = date("Ymd");
$fecha 		 = date("Y-m-d");
$gestion   = date("Y");
$mes       = date("m");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$iddepartamento = $_POST['iddepartamento'];

$sql_dep =" SELECT iddepartamento, departamento FROM departamento ";
$sql_dep.=" WHERE iddepartamento='$iddepartamento' ";
$result_dep = mysqli_query($link,$sql_dep);
$row_dep = mysqli_fetch_array($result_dep);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>MEDI-SAFCI VISITAS FAMILIARES - DEPARTAMENTO</title>

		<style type="text/css">

		</style>

<h4 style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">REPORTE DE VISITAS DEL DEPARTAMENTO DE <?php echo $row_dep[1];?> AL <?php echo $f_emision;?></h4>
</br>

<table width="1000" border="1" align="center" cellspacing="0">
    <tbody>
    <tr>
        <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
        <td width="199" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">MUNICIPIO</td>
        <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° FAMILIAS CON PLANIFICACIÓN DE VISITAS</td>
        <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° DE INTEGRANTES CON SEGUIMIENTOS PLANIFICADOS</td>
        <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° VISITAS PLANIFICADAS (TOTAL)</td>
        <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° VISITAS REALIZADAS (TOTAL)</td>
        <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° VISITAS NO REALIZADAS (TOTAL)</td>
    </tr>
    <?php
    $numero=1; 
    $sql =" SELECT carpeta_familiar.idmunicipio, municipios.municipio FROM seguimiento_cf, carpeta_familiar, municipios ";
    $sql.=" WHERE seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.idmunicipio=municipios.idmunicipio ";
    $sql.=" AND carpeta_familiar.iddepartamento='$iddepartamento' GROUP BY carpeta_familiar.idmunicipio ";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);           
    while ($field = mysqli_fetch_field($result)){
    } do {

        $sql_mun =" SELECT seguimiento_cf.idcarpeta_familiar FROM seguimiento_cf, carpeta_familiar  ";
        $sql_mun.=" WHERE seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
        $sql_mun.=" AND carpeta_familiar.idmunicipio='$row[0]' GROUP BY seguimiento_cf.idcarpeta_familiar ";
        $result_mun = mysqli_query($link,$sql_mun);
        $familias_mun = mysqli_num_rows($result_mun);

        $sql_int =" SELECT seguimiento_cf.idintegrante_cf FROM seguimiento_cf, carpeta_familiar  ";
        $sql_int.=" WHERE seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
        $sql_int.=" AND carpeta_familiar.idmunicipio='$row[0]' GROUP BY seguimiento_cf.idintegrante_cf ";
        $result_int = mysqli_query($link,$sql_int);
        $integrantes = mysqli_num_rows($result_int);

        $sql_vf =" SELECT visita_cf.idvisita_cf FROM visita_cf, seguimiento_cf, carpeta_familiar ";
        $sql_vf.=" WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
        $sql_vf.=" AND carpeta_familiar.idmunicipio='$row[0]'  ";
        $result_vf = mysqli_query($link,$sql_vf);
        $visitas = mysqli_num_rows($result_vf);

        $sql_vfr =" SELECT visita_cf.idvisita_cf FROM visita_cf, seguimiento_cf, carpeta_familiar ";
        $sql_vfr.=" WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
        $sql_vfr.=" AND carpeta_familiar.idmunicipio='$row[0]' AND visita_cf.idestado_visita_cf='3' ";
        $result_vfr = mysqli_query($link,$sql_vfr);
        $visitas_r  = mysqli_num_rows($result_vfr);

        $visitas_nr = $visitas-$visitas_r;
    ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero;?></td>
              <td style="font-size: 12px; font-family: Arial;"><?php echo $row[1];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $familias_mun;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $integrantes;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
                <?php echo $visitas;?>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
                <?php echo $visitas_r;?>  
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $visitas_nr;?></td>
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