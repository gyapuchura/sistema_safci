<?php	
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=REPORTE MORBILIDAD MUNICIPIOS.xls");
header("Pragma: no-cache");
header("Expires: 0");?>
<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");

$gestion       =  date("Y");

$iddepartamento = $_POST["iddepartamento"];
$idmorbilidad_cf = $_POST["idmorbilidad_cf"];

$sql_dep = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento' ";
$result_dep = mysqli_query($link,$sql_dep);
$row_dep = mysqli_fetch_array($result_dep);

$sql_mr = " SELECT idmorbilidad_cf, morbilidad_cf FROM morbilidad_cf WHERE idmorbilidad_cf='$idmorbilidad_cf' ";
$result_mr = mysqli_query($link,$sql_mr);
$row_mr = mysqli_fetch_array($result_mr);
$morbilidad = $row_mr[1];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <span style="font-family: Arial; font-size: 14px;"><h4 align="center">REPORTE MUNICIPIOS DEL DEPARTAMENTO DE <?php echo $row_dep[1]?> </h4></spam>

    <span style="font-family: Arial; font-size: 14px;"><h4 align="center"> <?php echo $morbilidad;?> </h4></spam>


	<table width="850" border="1" align="center" cellspacing="0">
	  <tbody>
        <tr>
            <td width="200" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>N°</strong></td>
            <td width="580" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>MUNICIPIO</strong></td>
            <td width="200" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>NÚMERO DE INTEGRANTES </strong></td>
 
        </tr>

        <?php
            $numero2=1;
            $sql2 = " SELECT carpeta_familiar.idmunicipio, municipios.municipio FROM integrante_morbilidad, carpeta_familiar, municipios ";
            $sql2.= " WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
            $sql2.= " AND carpeta_familiar.idmunicipio=municipios.idmunicipio AND carpeta_familiar.estado='CONSOLIDADO' ";
            $sql2.= " AND integrante_morbilidad.idmorbilidad_cf='$idmorbilidad_cf' ";
            $sql2.= " AND carpeta_familiar.iddepartamento='$iddepartamento' GROUP BY carpeta_familiar.idmunicipio ORDER BY municipios.municipio ";
            $result2 = mysqli_query($link,$sql2);
            if ($row2 = mysqli_fetch_array($result2)){
            mysqli_field_seek($result2,0);
            while ($field2 = mysqli_fetch_field($result2)){
            } do {
            ?>

	    <tr>
        <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $numero2;?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row2[1];?></td>
        
        <td style="font-family: Arial; font-size: 12px; text-align: center;">
            <?php 
                $sql_h =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_h.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='$idmorbilidad_cf' ";
                $sql_h.=" AND carpeta_familiar.idmunicipio='$row2[0]' ";
            $result_h = mysqli_query($link,$sql_h);
            $row_h = mysqli_fetch_array($result_h);
            $integrantes_cf   = number_format($row_h[0], 0, '.', '.');
            echo $integrantes_cf;?>
        </td>
        </tr>

        <?php
            $numero2=$numero2+1;  
            }
            while ($row2 = mysqli_fetch_array($result2));
            } else {
            }
            ?>

      </tbody>
    </table>
</body>
</html>