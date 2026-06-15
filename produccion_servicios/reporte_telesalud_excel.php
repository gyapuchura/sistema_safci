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
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>REPORTE TELESALUD</title>
</head>
<h4 align="center" style="font-family: Arial;">Nº ATENCIONES POR TELESALUD 
 = 
                <?php
                $sql_tel = " SELECT count(idatencion_teleconsulta) FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion'  ";
                $result_tel = mysqli_query($link,$sql_tel);
                $row_tel = mysqli_fetch_array($result_tel);
                $diagnostico_nal = $row_tel[0];
                echo $telesalud;
                ?>
</h4>
<h4 align="center" style="font-family: Arial;"> DEL <?php echo $f_inicio;?> AL <?php echo $f_finalizacion;?></h4>
<table width="1200" border="1" align="center" bordercolor="#009999">
    <tr>
              <td width="40" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">CÓDIGO ATENCIÓN</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">PERSONA ATENDIDA</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">DEPARTAMENTO</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">MUNICIPIO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ESTABLECIMIENTO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">CONSULTA/VISITA</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">TIPO ATENCIÖN</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">CAPTACIÓN</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">PROCEDENCIA</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">CONTEXTO ATENCIÓN</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">MEDIO COMUNICACIÓN</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ESPECIALIDAD MÉDICA</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ESTADO DEL PACIENTE</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">DIAGNÓSTICO 1</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">DIAGNÓSTICO 2</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">DIAGNÓSTICO 3</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">DIAGNÓSTICO 4</td>
            <?php
            $sql_d = " SELECT idexamen_complementario, examen_complementario FROM examen_complementario WHERE telesalud = 'SI' AND idexamen_complementario != '6' ORDER BY idexamen_complementario ";
            $result_d = mysqli_query($link,$sql_d);
            if ($row_d = mysqli_fetch_array($result_d)){
            mysqli_field_seek($result_d,0);
            while ($field_d = mysqli_fetch_field($result_d)){
            } do { ?>
                <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;"><?php echo $row_d[1] ?></td>
            <?php                  
            } while ($row_d = mysqli_fetch_array($result_d));
            } else {  }
            ?>
            <td width="200" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">TOTAL</span></td>
        </tr>

        <tr>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"></td>
            <?php
            $sql_ec = " SELECT idexamen_complementario, examen_complementario FROM examen_complementario WHERE telesalud = 'SI' AND idexamen_complementario != '6' ORDER BY idexamen_complementario ";
            $result_ec = mysqli_query($link,$sql_ec);
            if ($row_ec = mysqli_fetch_array($result_ec)){
            mysqli_field_seek($result_ec,0);
            while ($field_ec = mysqli_fetch_field($result_ec)){
            } do { 
                
                
                ?>

            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"></td>

            <?php                  
            } while ($row_ec = mysqli_fetch_array($result_ec));
            } else {  }
            ?>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"></td>

        </tr>


               
    </table>
</br>


	</body>
</html>