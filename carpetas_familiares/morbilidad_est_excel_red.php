<?php	
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=REPORTE MORBILIDAD ESTABLECIMIENTOSRED DE SALUD.xls");
header("Pragma: no-cache");
header("Expires: 0");?>
<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");

$gestion       =  date("Y");

$idred_salud = $_POST["idred_salud"];
$idmorbilidad_cf = $_POST["idmorbilidad_cf"];

$sql_red = " SELECT idred_salud, red_salud FROM red_salud WHERE idred_salud='$idred_salud' ";
$result_red = mysqli_query($link,$sql_red);
$row_red = mysqli_fetch_array($result_red);

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
    <span style="font-family: Arial; font-size: 14px;"><h4 align="center">REPORTE ESTABLECIMIENTOS DE LA RED DE SALUD DE <?php echo $row_red[1]?> </h4></spam>

    <span style="font-family: Arial; font-size: 14px;"><h4 align="center"> <?php echo $morbilidad;?> </h4></spam>

 
	<table width="850" border="1" align="center" cellspacing="0">
	  <tbody>
        <tr>
            <td width="200" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>N°</strong></td>
            <td width="280" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>DEPARTAMENTO</strong></td>
            <td width="280" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>MUNICIPIO</strong></td>
            <td width="280" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>ESTABLECIMIENTO DE SALUD</strong></td>
            <td width="100" style="font-family: Arial; font-size: 12px; text-align: center; color: #294D7C;"><strong>NÚMERO DE INTEGRANTES </strong></td>
 
        </tr>

        <?php
            $numero2=1;
            $sql2 = "  SELECT carpeta_familiar.idestablecimiento_salud, departamento.departamento, red_salud.red_salud, establecimiento_salud.establecimiento_salud  ";
            $sql2.= "  FROM integrante_morbilidad, carpeta_familiar, departamento, red_salud, establecimiento_salud  ";
            $sql2.= "  WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
            $sql2.= "  AND carpeta_familiar.iddepartamento=departamento.iddepartamento AND carpeta_familiar.idred_salud=red_salud.idred_salud  ";
            $sql2.= "  AND carpeta_familiar.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND carpeta_familiar.estado='CONSOLIDADO' ";
            $sql2.= "  AND integrante_morbilidad.idmorbilidad_cf='$idmorbilidad_cf' ";
            $sql2.= "  AND carpeta_familiar.idred_salud='$idred_salud' GROUP BY carpeta_familiar.idestablecimiento_salud ";

            $result2 = mysqli_query($link,$sql2);
            if ($row2 = mysqli_fetch_array($result2)){
            mysqli_field_seek($result2,0);
            while ($field2 = mysqli_fetch_field($result2)){
            } do {
            ?>

	    <tr>
        <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $numero2;?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row2[1];?></td>
         <td style="font-family: Arial; font-size: 12px;"><?php echo $row2[2];?></td>
          <td style="font-family: Arial; font-size: 12px;"><?php echo $row2[3];?></td>
        
        <td style="font-family: Arial; font-size: 12px; text-align: center;">
            <?php 
                $sql_h =" SELECT COUNT(distinct integrante_morbilidad.idintegrante_cf) FROM integrante_morbilidad, carpeta_familiar WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_h.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='$idmorbilidad_cf' ";
                $sql_h.=" AND carpeta_familiar.idestablecimiento_salud='$row2[0]' ";
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