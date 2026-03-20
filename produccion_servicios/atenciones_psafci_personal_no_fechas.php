<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$inicio = $_GET['inicio'];
$finalizacion = $_GET['finalizacion'];

$fecha_i = explode('-',$inicio);
$f_inicio = $fecha_i[2].'/'.$fecha_i[1].'/'.$fecha_i[0];

$fecha_f = explode('-',$finalizacion);
$f_finalizacion = $fecha_f[2].'/'.$fecha_f[1].'/'.$fecha_f[0];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REPORTE PRODUCCION PERSONAL SAFCI</title>
</head>
<body>
<span style="font-size: 12px"></span>
<table width="1200" border="0" align="center" cellspacing="0">
  <tbody>
    <tr>
      <td>
      
      </td>
      <td style="text-align: center; font-family: Arial; font-size: 16px; color: #17507F;">
        <strong>MUNICIPIOS SIN PRODUCCIÓN REGISTRADA EN SISTEMA</strong></br></br>
         <strong>DEL: <?php echo $f_inicio;?> AL : <?php echo $f_finalizacion;?></strong>
    </td>
      <td style="text-align: center; font-family: Arial; font-size: 16px; color: #17507F;">
              <form action="produccion_personal_no_nacional_excel.php" method="post">
              <input type="hidden" name="inicio" value="<?php echo $inicio;?>">
              <input type="hidden" name="finalizacion" value="<?php echo $finalizacion;?>">
              <button type="submit">DESCARGAR REPORTE EN EXCEL</button>
              </form> 
      </td>
    </tr>
    <tr>
      <td width="200">&nbsp;</td>
      <td width="581" style="text-align: center; font-family: Arial; font-size: 16px; color: #17507F;">&nbsp;</td>
      <td width="215">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">
        <table width="133" border="1" cellspacing="0">
        <tbody>
          <tr>
            <?php
            $sql_d = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento != '10' ORDER BY iddepartamento ";
            $result_d = mysqli_query($link,$sql_d);
            if ($row_d = mysqli_fetch_array($result_d)){
            mysqli_field_seek($result_d,0);
            while ($field_d = mysqli_fetch_field($result_d)){
            } do { ?>
            <td width="106" align="center" bgcolor="#ffdbe4" class="Estilo7" style="font-family: Arial; font-size: 12px; color: #FFFFFF;">
                
                <a href="produccion_personal_dep_fechas.php?iddepartamento=<?php echo $row_d[0];?>&inicio=<?php echo $inicio;?>&finalizacion=<?php echo $finalizacion;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=820,scrollbars=YES,top=50,left=200'); return false;"><?php echo $row_d[1] ?></a></td>
            <?php                  
            } while ($row_d = mysqli_fetch_array($result_d));
            } else {  }
            ?>
          </tr>
          <tr>
            <?php
            $sql_d = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento != '10' ORDER BY iddepartamento ";
            $result_d = mysqli_query($link,$sql_d);
            if ($row_d = mysqli_fetch_array($result_d)){
            mysqli_field_seek($result_d,0);
            while ($field_d = mysqli_fetch_field($result_d)){
            } do { ?>
            <td valign="top">
                <table width="133" border="0" cellspacing="0">
              <tbody>
                    <?php
                    $numero = 1;
                    $sql = " SELECT establecimiento_salud.idmunicipio, municipios.municipio FROM dato_laboral, establecimiento_salud, municipios WHERE dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND establecimiento_salud.idmunicipio=municipios.idmunicipio ";
                    $sql.= " AND establecimiento_salud.iddepartamento = '$row_d[0]' GROUP BY establecimiento_salud.idmunicipio ";
                    $result = mysqli_query($link,$sql);
                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_mun = " SELECT idatencion_psafci FROM atencion_psafci WHERE  idmunicipio = '$row[0]' AND fecha_registro BETWEEN '$inicio' AND '$finalizacion'  LIMIT 1 ";
                    $result_mun = mysqli_query($link,$sql_mun);
                    if (!($row_mun = mysqli_fetch_array($result_mun))){   
                    ?>

                    <tr>
                    <td valign="top" bgcolor="#ffedf1" style="font-family: Arial; font-size: 12px;">
                      <a href="produccion_personal_mun_fechas.php?idmunicipio=<?php echo $row[0];?>&inicio=<?php echo $inicio;?>&finalizacion=<?php echo $finalizacion;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=920,height=820,scrollbars=YES,top=50,left=200'); return false;"><?php echo $numero.'.- '.$row[1];?></a>
                      </br></br>
                    </td>
                    </tr>

                <?php  $numero++;   } ?>
                
                <?php                                 
                } while ($row = mysqli_fetch_array($result));
                } else {   }
                ?>
              </tbody>
            </table>
            </td>
             <?php                  
            } while ($row_d = mysqli_fetch_array($result_d));
            } else {  }
            ?>           
          </tr>
        </tbody>
      </table>
    
    </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
        <tr>
      <td>&nbsp;</td>
      <td>
&nbsp;
      </td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
    


</body>
</html>