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

$iddepartamento = $_GET['iddepartamento'];

$sql_dep = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento' ";
$result_dep = mysqli_query($link,$sql_dep);
$row_dep = mysqli_fetch_array($result_dep);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRODUCCION PERSONAL DEPARTAMENTO</title>
</head>
<body>
<table width="900" border="0" align="center" cellspacing="0">
  <tbody>
    <tr>
      <td>&nbsp;</td>
      <td style="font-family: Arial; font-size: 14px; text-align: center;">PRODUCCIÓN PERSONAL 
</br>
</br>DEPARTAMENTO : <?php echo $row_dep[1];?></br></br>
DEL: <?php echo $f_inicio;?> AL : <?php echo $f_finalizacion;?></br></br>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="font-family: Arial; font-size: 14px; text-align: center;">
          <form action="produccion_personal_dep_excel.php" method="post">
            <input type="hidden" name="iddepartamento" value="<?php echo $iddepartamento;?>">
          <input type="hidden" name="inicio" value="<?php echo $inicio;?>">
          <input type="hidden" name="finalizacion" value="<?php echo $finalizacion;?>">
          <button type="submit">DESCARGAR REPORTE DEPARTAMENTAL EN EXCEL</button>
          </form> 
        </br>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><table width="900" border="1" cellspacing="0">
        <tbody>
          <tr>
            <td width="40" style="font-family: Arial; font-size: 12px; text-align: center;">Nº</td>
            <td width="256" style="font-family: Arial; font-size: 12px; text-align: center;">NOMBRE (PERSONAL MÉDICO)</td>
            <td width="148" style="font-family: Arial; font-size: 12px; text-align: center;">MUNICIPIO</td>
            <td width="148" style="font-family: Arial; font-size: 12px; text-align: center;">ESTABLECIMIENTO DE SALUD</td>
            <td width="148" style="font-family: Arial; font-size: 12px; text-align: center;">CARGO DE ACUERDO A ORGANIGRAMA</td>
            <td width="148" style="font-family: Arial; font-size: 12px; text-align: center;">ATENCIONES PREVENTIVAS</td>
            <td width="148" style="font-family: Arial; font-size: 12px; text-align: center;">ATENCIONES POR MORBILIDAD</td>
          </tr>
        <?php
            $numero = 1;
            $sql = "  SELECT personal.idusuario, nombre.nombre, nombre.paterno, nombre.materno, municipios.municipio, establecimiento_salud.establecimiento_salud   ";
            $sql.= "  FROM personal, nombre, usuarios, dato_laboral, municipios, establecimiento_salud WHERE personal.idusuario=usuarios.idusuario AND usuarios.idnombre=nombre.idnombre ";
            $sql.= "  AND personal.iddato_laboral=dato_laboral.iddato_laboral AND dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND establecimiento_salud.idmunicipio=municipios.idmunicipio  ";
            $sql.= "  AND establecimiento_salud.iddepartamento='$iddepartamento' AND dato_laboral.idestablecimiento_salud !='4196' AND usuarios.condicion='ACTIVO' GROUP BY personal.idusuario ORDER BY municipios.municipio   ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {
        ?>
          <tr>
            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $numero; ?></td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row[1]." ".$row[2]." ".$row[3]);?></td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[4];?></td>
            <td style="font-family: Arial; font-size: 12px;"><?php echo $row[5];?></td>
            <td style="font-family: Arial; font-size: 12px;">
                <?php  
            $sql_c = " SELECT dato_laboral.iddato_laboral, cargo_organigrama.cargo_organigrama FROM dato_laboral, cargo_organigrama WHERE dato_laboral.idcargo_organigrama=cargo_organigrama.idcargo_organigrama ";
            $sql_c.= " AND dato_laboral.idusuario='$row[0]' ORDER BY dato_laboral.iddato_laboral DESC  ";
            $result_c = mysqli_query($link,$sql_c);
            if ($row_c = mysqli_fetch_array($result_c)){ ?>
            <span class="Estilo7"><a href="produccion_operativo_prev_fechas.php?idusuario=<?php echo $row[0];?>&inicio=<?php echo $inicio;?>&finalizacion=<?php echo $finalizacion;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=920,scrollbars=YES,top=50,left=200'); return false;"><?php echo $row_c[1];?></a></span>
           <?php }  ?>

            </td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">
                <?php
                $sql_dg = " SELECT count(diagnostico_psafci.iddiagnostico_psafci) FROM diagnostico_psafci, patologia WHERE diagnostico_psafci.idpatologia=patologia.idpatologia ";
                $sql_dg.= " AND diagnostico_psafci.idusuario = '$row[0]' AND patologia.cie LIKE '%Z%' AND diagnostico_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
                $result_dg = mysqli_query($link,$sql_dg);
                $row_dg = mysqli_fetch_array($result_dg);
                $diagnosticos_prev = $row_dg[0];
                if ($diagnosticos_prev != '0' ) { 
                    echo $diagnosticos_prev;
                 } else {}  ?>
            </td>
            <td style="font-family: Arial; font-size: 12px; text-align: center;">
                <?php
                $sql_mb = " SELECT count(diagnostico_psafci.iddiagnostico_psafci) FROM diagnostico_psafci, patologia WHERE diagnostico_psafci.idpatologia=patologia.idpatologia ";
                $sql_mb.= " AND diagnostico_psafci.idusuario = '$row[0]' AND patologia.cie NOT LIKE '%Z%' AND diagnostico_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
                $result_mb = mysqli_query($link,$sql_mb);
                $row_mb = mysqli_fetch_array($result_mb);
                $diagnosticos_morb = $row_mb[0];
                if ($diagnosticos_morb !='0') {
                    echo $diagnosticos_morb;
                } else { }
                ?>
            </td>
          </tr>
        <?php
        $numero++;                    
        } while ($row = mysqli_fetch_array($result));
        } else {   }
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