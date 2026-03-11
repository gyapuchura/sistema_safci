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
      
      <a href="produccion_personal_diaria_nal_fechas.php?inicio=<?php echo $inicio;?>&finalizacion=<?php echo $finalizacion;?>" target="_blank" class="Estilo12" style="font-family: Arial" onClick="window.open(this.href, this.target, 'width=1200,height=820,scrollbars=YES,top=50,left=200'); return false;">ATENCIONES POR DIA - NACIONAL</a>

      </td>
      <td style="text-align: center; font-family: Arial; font-size: 16px; color: #17507F;">
        <strong>REPORTE PRODUCCION DE SERVICIOS DEL PERSONAL SAFCI-MISALUD</strong></br></br>
         <strong>DEL: <?php echo $f_inicio;?> AL : <?php echo $f_finalizacion;?></strong>
    </td>
      <td style="text-align: center; font-family: Arial; font-size: 16px; color: #17507F;">
              <form action="produccion_personal_nal_excel.php" method="post">
              <input type="hidden" name="inicio" value="<?php echo $inicio;?>">
              <input type="hidden" name="finalizacion" value="<?php echo $finalizacion;?>">
              <button type="submit">DESCARGAR REPORTE NACIONAL EN EXCEL</button>
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
            <td width="106" align="center" bgcolor="#ffd5b1" class="Estilo7" style="font-family: Arial; font-size: 12px; color: #FFFFFF;">
                
                <a href="produccion_personal_dep_fechas.php?iddepartamento=<?php echo $row_d[0];?>&inicio=<?php echo $inicio;?>&finalizacion=<?php echo $finalizacion;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1420,height=820,scrollbars=YES,top=50,left=200'); return false;"><?php echo $row_d[1] ?></a></td>
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
                    $sql = " SELECT atencion_psafci.idmunicipio, municipios.municipio FROM atencion_psafci, municipios WHERE atencion_psafci.idmunicipio=municipios.idmunicipio  ";
                    $sql.= " AND atencion_psafci.iddepartamento='$row_d[0]' AND atencion_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY atencion_psafci.idmunicipio ";
                    $result = mysqli_query($link,$sql);
                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {
                ?>
                <tr>
                  <td valign="top" bgcolor="#fff2cd" style="font-family: Arial; font-size: 12px;">
                  <a href="produccion_personal_mun_fechas.php?idmunicipio=<?php echo $row[0];?>&inicio=<?php echo $inicio;?>&finalizacion=<?php echo $finalizacion;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=920,height=820,scrollbars=YES,top=50,left=200'); return false;"><?php echo $numero.'.- '.$row[1];?></a>
                    </br></br>
                    </td>
                </tr>
                    <?php
                    $numero++;                    
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
  </tbody>
</table>
    


</body>
</html>