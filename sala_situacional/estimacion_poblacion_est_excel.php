<?php	
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=REPORTE POBLACION ESTABLECIMIENTO.xls");
header("Pragma: no-cache");
header("Expires: 0");?>
<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$idestablecimiento_salud = $_POST['idestablecimiento_salud'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESTIMACION POBLACIONAL ESTABLECIMIENTO SALUD</title>
</head>
<body>
    

<table width="1400" border="0" align="center">
  <tbody>

    <tr>
      <td height="164" colspan="3"><table width="1394" border="0">
        <tbody>

        <?php
        $sql =" SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud WHERE idestablecimiento_salud ='$idestablecimiento_salud'";
        $result = mysqli_query($link,$sql);
        if ($row = mysqli_fetch_array($result)){
        mysqli_field_seek($result,0);
        while ($field = mysqli_fetch_field($result)){
        } do {
        ?>


          <tr>
            <td>&nbsp;</td>
            <td colspan="16" style="font-size: 12px; font-family: Arial;">
              <table width="1400" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td width="40" style="text-align: center">Nº</td>
                  <td colspan="15" style="text-align: center; font-size: 20px;">POBLACIÓN POR ÁREAS DE INFLUENCIA DEL ESTABLECIMIENTO : <?php echo mb_strtoupper($row[1]);?></td>
                  </tr>
            <?php
            $numero=1;
            $sql_af =" SELECT carpeta_familiar.idarea_influencia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia FROM area_influencia, tipo_area_influencia, carpeta_familiar  ";
            $sql_af.=" WHERE carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND carpeta_familiar.estado='CONSOLIDADO' ";
            $sql_af.="  AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' GROUP BY carpeta_familiar.idarea_influencia ORDER BY area_influencia.area_influencia ";
            $result_af = mysqli_query($link,$sql_af);
            if ($row_af = mysqli_fetch_array($result_af)){
            mysqli_field_seek($result_af,0);
            while ($field_af = mysqli_fetch_field($result_af)){
            } do {
            ?>
                <tr>
                  <td rowspan="4" width="40" style="text-align: center"><?php echo $numero;?></td>
                  <td colspan="15" style="text-align: center; font-size: 14px;"><?php echo $row_af[1];?> <?php echo $row_af[2];?></td>
                  </tr>
                <tr>
                  <td style="text-align: center">Género</td>
            <?php
            $sql_et =" SELECT idgrupo_etareo_pb, grupo_etareo_pb FROM grupo_etareo_pb ORDER BY idgrupo_etareo_pb ";
            $result_et = mysqli_query($link,$sql_et);
            if ($row_et = mysqli_fetch_array($result_et)){
            mysqli_field_seek($result_et,0);
            while ($field_et = mysqli_fetch_field($result_et)){
            } do {
            ?>
                  <td width="40" style="text-align: center"><?php echo $row_et[1];?></td>
            <?php
            }
            while ($row_et = mysqli_fetch_array($result_et));
            } else {
            }
            ?>

                </tr>
                <tr>
                  <td width="80" style="text-align: center">1.- Mujer </td>
            <?php
            $sql_etf =" SELECT idgrupo_etareo_pb, grupo_etareo_pb, valor_inf, valor_sup FROM grupo_etareo_pb ORDER BY idgrupo_etareo_pb ";
            $result_etf = mysqli_query($link,$sql_etf);
            if ($row_etf = mysqli_fetch_array($result_etf)){
            mysqli_field_seek($result_etf,0);
            while ($field_etf = mysqli_fetch_field($result_etf)){
            } do {
            ?>
                  <td width="40" style="text-align: center">

                    <?php 
                    $sql_f =" SELECT integrante_cf.edad FROM integrante_cf, carpeta_familiar, nombre WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                    $sql_f.=" AND integrante_cf.idnombre=nombre.idnombre AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_cf.estado='CONSOLIDADO' AND nombre.idgenero = '1' ";
                    $sql_f.=" AND carpeta_familiar.idarea_influencia='$row_af[0]' AND integrante_cf.edad BETWEEN '$row_etf[2]' AND '$row_etf[3]' ";
                    $result_f = mysqli_query($link,$sql_f);
                    $row_f = mysqli_num_rows($result_f);
                    echo $row_f;
                    ?>

                  </td>
            <?php
            }
            while ($row_etf = mysqli_fetch_array($result_etf));
            } else {
            }
            ?>
                </tr>
                <tr>
                  <td width="80" style="text-align: center">2.- Hombre</td>
            <?php
            $sql_etm =" SELECT idgrupo_etareo_pb, grupo_etareo_pb, valor_inf, valor_sup FROM grupo_etareo_pb ORDER BY idgrupo_etareo_pb ";
            $result_etm = mysqli_query($link,$sql_etm);
            if ($row_etm = mysqli_fetch_array($result_etm)){
            mysqli_field_seek($result_etm,0);
            while ($field_etm = mysqli_fetch_field($result_etm)){
            } do {
            ?>
                  <td width="40" style="text-align: center">

                    <?php 
                    $sql_m =" SELECT integrante_cf.edad FROM integrante_cf, carpeta_familiar, nombre WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                    $sql_m.=" AND integrante_cf.idnombre=nombre.idnombre AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_cf.estado='CONSOLIDADO' AND nombre.idgenero = '2' ";
                    $sql_m.=" AND carpeta_familiar.idarea_influencia='$row_af[0]' AND integrante_cf.edad BETWEEN '$row_etm[2]' AND '$row_etm[3]' ";
                    $result_m = mysqli_query($link,$sql_m);
                    $row_m = mysqli_num_rows($result_m);
                    echo $row_m;
                    ?>

                  </td>
            <?php
            }
            while ($row_etm = mysqli_fetch_array($result_etm));
            } else {
            }
            ?>
                  </tr>
            <?php
            $numero=$numero+1;  
            }
            while ($row_af = mysqli_fetch_array($result_af));
            } else {
            }
            ?>
              </tbody>
            </table></td>
            </tr>
        <?php
        }
        while ($row = mysqli_fetch_array($result));
        } else {
        }
        ?>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>

</body>
</html>