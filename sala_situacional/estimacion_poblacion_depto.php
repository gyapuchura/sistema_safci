<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$iddepartamento = $_GET['iddepartamento'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESTIMACION POBLACIONAL</title>
</head>
<body>
    

<table width="1400" border="0" align="center">
  <tbody>

    <tr>
      <td height="164" colspan="3"><table width="1394" border="0">
        <tbody>

        <?php
        $sql =" SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento ='$iddepartamento'";
        $result = mysqli_query($link,$sql);
        if ($row = mysqli_fetch_array($result)){
        mysqli_field_seek($result,0);
        while ($field = mysqli_fetch_field($result)){
        } do {
        ?>

          <tr>
            <td width="1">&nbsp;</td>
            <td width="588" style="text-align: center; font-family: 'Helvetica Condensed'; color: #496FDB; font-size: 24px;"><strong>POBLACIÓN POR MUNICIPIOS DEPARTAMENTO DE <?php echo mb_strtoupper($row[1]);?></strong></br></td>
            <td width="628">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="16" style="font-size: 12px; font-family: Arial;">
              <table width="1400" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td width="40" style="text-align: center">Nº</td>
                  <td colspan="15" style="text-align: center; font-size: 14px;">MUNICIPIO</td>
                  </tr>
            <?php
            $numero=1;
            $sql_mun =" SELECT idmunicipio, municipio FROM municipios WHERE iddepartamento='$row[0]' ORDER BY idmunicipio ";
            $result_mun = mysqli_query($link,$sql_mun);
            if ($row_mun = mysqli_fetch_array($result_mun)){
            mysqli_field_seek($result_mun,0);
            while ($field_mun = mysqli_fetch_field($result_mun)){
            } do {
            ?>
                <tr>
                  <td rowspan="4" width="40" style="text-align: center"><?php echo $numero;?></td>
                  <td colspan="15" style="text-align: center; font-size: 14px;"><?php echo $row_mun[1];?></td>
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
                    $sql_f.=" AND integrante_cf.idnombre=nombre.idnombre AND carpeta_familiar.estado='CONSOLIDADO' AND nombre.idgenero = '1' ";
                    $sql_f.=" AND carpeta_familiar.idmunicipio='$row_mun[0]' AND integrante_cf.edad BETWEEN '$row_etf[2]' AND '$row_etf[3]' ";
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
                    $sql_m.=" AND integrante_cf.idnombre=nombre.idnombre AND carpeta_familiar.estado='CONSOLIDADO' AND nombre.idgenero = '2' ";
                    $sql_m.=" AND carpeta_familiar.idmunicipio='$row_mun[0]' AND integrante_cf.edad BETWEEN '$row_etm[2]' AND '$row_etm[3]' ";
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
            while ($row_mun = mysqli_fetch_array($result_mun));
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