<?php	
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=REPORTE ATENCIONES TELESALUD.xls");
header("Pragma: no-cache");
header("Expires: 0");?>
<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$inicio = $_POST['inicio'];
$finalizacion = $_POST['finalizacion'];

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
<h4 align="center" style="font-family: Arial;">REPORTE DE ATENCIONES POR TELESALUD 
 = 
<?php
$sql_tel = " SELECT count(idatencion_teleconsulta) FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion'  ";
$result_tel = mysqli_query($link,$sql_tel);
$row_tel = mysqli_fetch_array($result_tel);
$telesalud = $row_tel[0];
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
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">TIPO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">NIVEL</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">CONSULTA/VISITA</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">TIPO ATENCIÖN</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">CAPTACIÓN</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">PROCEDENCIA</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">CONTEXTO ATENCIÓN</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">MEDIO COMUNICACIÓN</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ESPECIALIDAD MÉDICA</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">TIEMPO</td>
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
            <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">TELÉFONO PACIENTE</td>
            <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">FECHA DE LA ATENCIÓN</td>
            <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">MÉDICO</td>
        </tr>     
    <?php
    $numero_te=1;
    $sql_te = " SELECT atencion_psafci.idatencion_psafci, atencion_psafci.codigo, nombre.nombre, nombre.paterno, nombre.materno, departamento.departamento,  ";
    $sql_te.= " municipios.municipio, establecimiento_salud.establecimiento_salud, tipo_establecimiento.tipo_establecimiento, nivel_establecimiento.nivel_establecimiento, ";
    $sql_te.= " tipo_consulta.tipo_consulta, tipo_atencion.tipo_atencion, captacion_ts.captacion_ts, de_ts.de_ts, en_ts.en_ts, via_comunicacion.via_comunicacion,  ";
    $sql_te.= " especialidad_medica.especialidad_medica, tiempo_ts.tiempo_ts, estado_paciente.estado_paciente, atencion_teleconsulta.telefono_paciente, atencion_psafci.fecha_registro, atencion_psafci.hora_registro,  ";
    $sql_te.= " atencion_psafci.idusuario FROM atencion_psafci, nombre, tipo_consulta, tipo_atencion, departamento, municipios, establecimiento_salud, tipo_establecimiento,  ";
    $sql_te.= " nivel_establecimiento, atencion_teleconsulta, captacion_ts, de_ts, en_ts, via_comunicacion, especialidad_medica, tiempo_ts, estado_paciente ";
    $sql_te.= " WHERE atencion_psafci.idnombre=nombre.idnombre AND atencion_teleconsulta.idatencion_psafci=atencion_psafci.idatencion_psafci  ";
    $sql_te.= " AND atencion_psafci.idtipo_consulta=tipo_consulta.idtipo_consulta AND atencion_psafci.iddepartamento=departamento.iddepartamento  ";
    $sql_te.= " AND atencion_psafci.idmunicipio=municipios.idmunicipio AND atencion_psafci.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud  ";
    $sql_te.= " AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento AND establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento ";
    $sql_te.= " AND atencion_psafci.idtipo_atencion=tipo_atencion.idtipo_atencion AND atencion_teleconsulta.idcaptacion_ts=captacion_ts.idcaptacion_ts  AND atencion_teleconsulta.idde_ts=de_ts.idde_ts ";
    $sql_te.= " AND atencion_teleconsulta.iden_ts=en_ts.iden_ts AND atencion_teleconsulta.idvia_comunicacion=via_comunicacion.idvia_comunicacion ";
    $sql_te.= " AND atencion_teleconsulta.idespecialidad_medica=especialidad_medica.idespecialidad_medica AND atencion_teleconsulta.idtiempo_ts=tiempo_ts.idtiempo_ts ";
    $sql_te.= " AND atencion_teleconsulta.idestado_paciente=estado_paciente.idestado_paciente ";
    $sql_te.= " AND atencion_teleconsulta.fecha_registro BETWEEN '2026-05-01' AND '2026-06-12' ORDER BY atencion_psafci.idatencion_psafci DESC  ";
    $result_te = mysqli_query($link,$sql_te);
    if ($row_te = mysqli_fetch_array($result_te)){
    mysqli_field_seek($result_te,0);
    while ($field_te = mysqli_fetch_field($result_te)){
    } do { ?>
        <tr>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $numero_te;?></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row_te[1]?></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo mb_strtoupper($row_te[2].' '.$row_te[3].' '.$row_te[4]);?></td> 
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row_te[5]?></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row_te[6]?></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row_te[7]?></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row_te[8]?></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row_te[9]?></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row_te[10]?></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row_te[11]?></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row_te[12]?></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row_te[13]?></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row_te[14]?></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row_te[15]?></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row_te[16]?></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row_te[17]?></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row_te[18]?></td>

            <?php
            $diagnostico=1;
            $sql_dg = " SELECT patologia.patologia, patologia.cie FROM diagnostico_teleconsulta, patologia WHERE diagnostico_teleconsulta.idpatologia=patologia.idpatologia  ";
            $sql_dg.= " AND diagnostico_teleconsulta.idatencion_psafci='$row_te[0]' ";
            $result_dg = mysqli_query($link,$sql_dg);
            if ($row_dg = mysqli_fetch_array($result_dg)){
            mysqli_field_seek($result_dg,0);
            while ($field_dg = mysqli_fetch_field($result_dg)){
            } do {                 
                ?>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row_dg[0]?> - <?php echo $row_dg[1]?></td>
            <?php    
            $diagnostico=$diagnostico+1;              
            } while ($row_dg = mysqli_fetch_array($result_dg));
            } else {  }
            ?>
            <?php 
            
            for ($i = $diagnostico; $i <= 4; $i++) {  ?>

                <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"></td>

            <?php } ?>
            

            <?php
            $sql_ec = " SELECT idexamen_complementario, examen_complementario FROM examen_complementario WHERE telesalud = 'SI' AND idexamen_complementario != '6' ORDER BY idexamen_complementario ";
            $result_ec = mysqli_query($link,$sql_ec);
            if ($row_ec = mysqli_fetch_array($result_ec)){
            mysqli_field_seek($result_ec,0);
            while ($field_ec = mysqli_fetch_field($result_ec)){
            } do { 
                                
                ?>

                <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px; text-align: center;" >
                    <?php
                        $sql_ex = " SELECT idexamen_teleconsulta FROM examen_teleconsulta WHERE idatencion_psafci='$row_te[0]' AND  idexamen_complementario='$row_ec[0]' ";
                        $result_ex = mysqli_query($link,$sql_ex);
                        if ($row_ex = mysqli_fetch_array($result_ex)){
                            echo $row_ec[1];                           
                        } ?>
                </td>

            <?php                  
            } while ($row_ec = mysqli_fetch_array($result_ec));
            } else {  }
            ?>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row_te[19]?></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"> 
                <?php 
                $fecha_r = explode('-',$row_te[20]);
                $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                <?php echo $f_registro;?>
            </td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"> 
              <?php 
                $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                $sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row_te[22]' ";
                $result_r = mysqli_query($link,$sql_r);
                $row_r = mysqli_fetch_array($result_r);                    
                echo mb_strtoupper($row_r[0]." ".$row_r[1]." ".$row_r[2]);?>
            </td>
        </tr>

    <?php 
    $numero_te=$numero_te+1;                 
    } while ($row_te = mysqli_fetch_array($result_te));
    } else {  }
    ?>
               
    </table>
</br>


	</body>
</html>