<?php include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

<table width="1400" border="0" align="center">
  <tbody>
    <tr>
      <td width="144">&nbsp;</td>
      <td width="598" bgcolor="#ffffff" style="text-align: center; font-family: 'Helvetica Condensed'; color: #496FDB; font-size: 24px;"><strong>POBLACIÓN POR MUNICIPIOS NIVEL NACIONAL</strong></td>
      <td width="144">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><table width="1394" border="0">
        <tbody>

        <?php
        $sql =" SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento !='10' ORDER BY departamento ";
        $result = mysqli_query($link,$sql);
        if ($row = mysqli_fetch_array($result)){
        mysqli_field_seek($result,0);
        while ($field = mysqli_fetch_field($result)){
        } do {
        ?>

          <tr>
            <td width="1">&nbsp;</td>
            <td width="588"></br> <?php echo mb_strtoupper($row[1]);?></br></td>
            <td width="628">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">
              <table width="1400" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td width="40">Nº</td>
                  <td width="200">MUNICIPIO</td>
                  <td width="83">0</td>
                  <td width="83">1</td>
                  <td width="83">2</td>
                  <td width="83">3</td>
                  <td width="83">4</td>
                  <td width="83">0-4</td>
                  <td width="83">5-9</td>
                  <td width="83">10-14</td>
                  <td width="83">15-19</td>
                  <td width="83">20-39</td>
                  <td width="83">40-49</td>
                  <td width="83">50-59</td>
                  <td width="83">60+</td>
                  <td width="90">TOTAL</td>
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
                  <td><?php echo $numero;?></td>
                  <td><?php echo $row_mun[1];?></td>
                  <td>
                  <?php 
                    $sql_0 =" SELECT integrante_cf.edad FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql_0.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$row_mun[0]' AND integrante_cf.edad = '0' ";
                    $result_0 = mysqli_query($link,$sql_0);
                    $row_0 = mysqli_num_rows($result_0);
                    echo $row_0;
                    ?>
                  </td>
                  <td>
                    <?php 
                    $sql_1 =" SELECT integrante_cf.edad FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql_1.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$row_mun[0]' AND integrante_cf.edad = '1' ";
                    $result_1 = mysqli_query($link,$sql_1);
                    $row_1 = mysqli_num_rows($result_1);
                    echo $row_1;
                    ?>
                  </td>
                  <td>
                    <?php 
                    $sql_2 =" SELECT integrante_cf.edad FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql_2.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$row_mun[0]' AND integrante_cf.edad = '2' ";
                    $result_2 = mysqli_query($link,$sql_2);
                    $row_2 = mysqli_num_rows($result_2);
                    echo $row_2;
                    ?>
                  </td>
                  <td>
                    <?php 
                    $sql_3 =" SELECT integrante_cf.edad FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql_3.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$row_mun[0]' AND integrante_cf.edad = '3' ";
                    $result_3 = mysqli_query($link,$sql_3);
                    $row_3 = mysqli_num_rows($result_3);
                    echo $row_3;
                    ?>
                  </td>
                  <td>
                    <?php 
                    $sql_4 =" SELECT integrante_cf.edad FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql_4.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$row_mun[0]' AND integrante_cf.edad = '4' ";
                    $result_4 = mysqli_query($link,$sql_4);
                    $row_4 = mysqli_num_rows($result_4);
                    echo $row_4;
                    ?>
                  </td>
                  <td>
                    <?php 
                    $row_04 = $row_0 + $row_1 + $row_2 + $row_3 + $row_4;
                    echo $row_04;
                    ?>
                  </td>
                  <td>
                    <?php 
                    $sql_59 =" SELECT integrante_cf.edad FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql_59.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$row_mun[0]' AND integrante_cf.edad BETWEEN '5' AND '9' ";
                    $result_59 = mysqli_query($link,$sql_59);
                    $row_59 = mysqli_num_rows($result_59);
                    echo $row_59;
                    ?>
                  </td>
                  <td>
                    <?php 
                    $sql_14 =" SELECT integrante_cf.edad FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql_14.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$row_mun[0]' AND integrante_cf.edad BETWEEN '10' AND '14' ";
                    $result_14 = mysqli_query($link,$sql_14);
                    $row_14 = mysqli_num_rows($result_14);
                    echo $row_14;
                    ?>
                  </td>
                  <td>
                    <?php 
                    $sql_19 =" SELECT integrante_cf.edad FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql_19.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$row_mun[0]' AND integrante_cf.edad BETWEEN '15' AND '19' ";
                    $result_19 = mysqli_query($link,$sql_19);
                    $row_19 = mysqli_num_rows($result_19);
                    echo $row_19;
                    ?>
                  </td>
                  <td>
                    <?php 
                    $sql_39 =" SELECT integrante_cf.edad FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql_39.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$row_mun[0]' AND integrante_cf.edad BETWEEN '20' AND '39' ";
                    $result_39 = mysqli_query($link,$sql_39);
                    $row_39 = mysqli_num_rows($result_39);
                    echo $row_39;
                    ?>
                  </td>
                  <td>
                    <?php 
                    $sql_49 =" SELECT integrante_cf.edad FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql_49.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$row_mun[0]' AND integrante_cf.edad BETWEEN '40' AND '49' ";
                    $result_49 = mysqli_query($link,$sql_49);
                    $row_49 = mysqli_num_rows($result_49);
                    echo $row_49;
                    ?>
                  </td>
                  <td>
                    <?php 
                    $sql_9 =" SELECT integrante_cf.edad FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql_9.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$row_mun[0]' AND integrante_cf.edad BETWEEN '50' AND '59' ";
                    $result_9 = mysqli_query($link,$sql_9);
                    $row_9 = mysqli_num_rows($result_9);
                    echo $row_9;
                    ?>
                  </td>
                  <td>                    
                    <?php 
                    $sql_60 =" SELECT integrante_cf.edad FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql_60.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$row_mun[0]' AND integrante_cf.edad > '60' ";
                    $result_60 = mysqli_query($link,$sql_60);
                    $row_60 = mysqli_num_rows($result_60);
                    echo $row_60;
                    ?></td>
                  <td>
                    <?php 
                    $row_total = $row_04 + $row_59 + $row_14 + $row_19 + $row_39 + $row_49 + $row_9 + $row_60;
                    echo $row_total;
                    ?>
                  </td>
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