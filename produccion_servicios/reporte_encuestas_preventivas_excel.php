<?php	
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=REPORTE ENCUESTA TDETECCION DEL CANCER.xls");
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

$inicio = $_POST['inicio'];
$finalizacion = $_POST['finalizacion'];

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
    <title>REPORTE ENCUESTA PREVENTIVA CANCER - NACIONAL</title>
</head>
<body>
    <h2 style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">ENCUESTAS PREVENTIVAS</h2>

    <table width="1000" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">DEPARTAMENTO</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">MUNICIPIO</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">RED DE SALUD</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ESTABLECIMIENTO</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">CÓDIGO ENCUESTA</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">CÉDULA DE IDENTIDAD</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">PERSONA ATENDIDA</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">EDAD</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">GENERO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">CLASIFICACIÓN DE RIESGO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">MÉDICO OPERATIVO</td>
              <td width="250" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">CARGO ORGANIZACIONAL</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">FECHA DE REGISTRO:</td>

		     <!--- <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">F302A</td>  --->
	        </tr>
            <?php
    $numero=1; 
    $sql =" SELECT encuesta_psafci.idencuesta_psafci, departamento.departamento, municipios.municipio, red_salud.red_salud, establecimiento_salud.establecimiento_salud,  ";
    $sql.=" encuesta_psafci.codigo, nombre.ci, nombre.nombre, nombre.paterno, nombre.materno, genero.genero, nombre.fecha_nac, ";
    $sql.=" clasificacion_riesgo_cancer.clasificacion_riesgo_cancer, encuesta_psafci.fecha_registro, encuesta_psafci.hora_registro, encuesta_psafci.idusuario  ";
    $sql.=" FROM encuesta_psafci, departamento, municipios, red_salud, establecimiento_salud, clasificacion_riesgo_cancer, nombre, genero ";
    $sql.=" WHERE encuesta_psafci.iddepartamento=departamento.iddepartamento AND encuesta_psafci.idmunicipio=municipios.idmunicipio  ";
    $sql.=" AND encuesta_psafci.idnombre=nombre.idnombre AND nombre.idgenero=genero.idgenero AND encuesta_psafci.idred_salud=red_salud.idred_salud  ";
    $sql.=" AND encuesta_psafci.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND encuesta_psafci.idclasificacion_riesgo_cancer=clasificacion_riesgo_cancer.idclasificacion_riesgo_cancer  ";
    $sql.=" AND encuesta_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' ORDER BY encuesta_psafci.idencuesta_psafci; ";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);           
    while ($field = mysqli_fetch_field($result)){
    } do {
    ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[1];?></td>                
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[2];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[3];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[4];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[5];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[6];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo mb_strtoupper($row[7]." ".$row[8]." ".$row[9]);?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
                <?php
                $fecha_nacimiento = $row[11];
                $dia = date("d");
                $mes = date("m");
                $ano = date("Y");    
                $dianaz = date("d",strtotime($fecha_nacimiento));
                $mesnaz = date("m",strtotime($fecha_nacimiento));
                $anonaz = date("Y",strtotime($fecha_nacimiento));         
                if (($mesnaz == $mes) && ($dianaz > $dia)) {
                $ano=($ano-1); }      
                if ($mesnaz > $mes) {
                $ano=($ano-1);}       
                $edad=($ano-$anonaz);  
                echo $edad ;?>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[10];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[12];?></td>
              <td style="font-size: 12px; font-family: Arial;">
              <?php 
                $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                $sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row[15]' ";
                $result_r = mysqli_query($link,$sql_r);
                $row_r = mysqli_fetch_array($result_r);                    
                echo mb_strtoupper($row_r[0]." ".$row_r[1]." ".$row_r[2]);?>
              </td>
              <td style="font-size: 12px; font-family: Arial;">
              <?php 
                $sql_c =" SELECT dato_laboral.idcargo_organigrama, cargo_organigrama.cargo_organigrama FROM usuarios, dato_laboral, cargo_organigrama  ";
                $sql_c.=" WHERE dato_laboral.idusuario=usuarios.idusuario AND dato_laboral.idcargo_organigrama=cargo_organigrama.idcargo_organigrama ";
                $sql_c.=" AND usuarios.idusuario='$row[15]' ORDER BY dato_laboral.idcargo_organigrama DESC LIMIT 1 ";
                $result_c = mysqli_query($link,$sql_c);
                $row_c = mysqli_fetch_array($result_c);                    
                echo $row_c[1];?>
              </td>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                $fecha_r = explode('-',$row[13]);
                $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                <?php echo $f_registro;?> - <?php echo $row[14];?></td>
		     <!--- <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">&nbsp;</td> --->
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