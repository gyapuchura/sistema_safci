<?php   
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=REPORTE_TELESALUD_" . date('Y-m-d') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");?>
<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram      = date("Ymd");
$fecha          = date("Y-m-d");
$gestion        = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$inicio = $_POST['inicio'];
$finalizacion = $_POST['finalizacion'];

// =========================================================================
// 1. RECIBIR LOS FILTROS DINÁMICOS DESDE EL DASHBOARD
// =========================================================================
$iddepartamento    = isset($_POST['iddepartamento']) ? $_POST['iddepartamento'] : '';
$idmunicipio       = isset($_POST['idmunicipio']) ? $_POST['idmunicipio'] : '';
$idestablecimiento = isset($_POST['idestablecimiento']) ? $_POST['idestablecimiento'] : '';
$idusuario_medico  = isset($_POST['idusuario_medico']) ? $_POST['idusuario_medico'] : '';

$filtro_extra = "";
if($iddepartamento != '') { $filtro_extra .= " AND a.iddepartamento = '$iddepartamento' "; }
if($idmunicipio != '') { $filtro_extra .= " AND a.idmunicipio = '$idmunicipio' "; }
if($idestablecimiento != '') { $filtro_extra .= " AND a.idestablecimiento_salud = '$idestablecimiento' "; }
if($idusuario_medico != '') { $filtro_extra .= " AND a.idusuario = '$idusuario_medico' "; }
// =========================================================================

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
<body>
<h4 align="center" style="font-family: Arial;">REPORTE DE ATENCIONES POR TELESALUD </h4>
<h4 align="center" style="font-family: Arial;"> DEL <?php echo $f_inicio;?> AL <?php echo $f_finalizacion;?></h4>
<table width="1200" border="1" align="center" bordercolor="#009999">
    <thead>
        <tr>
              <td width="40" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center; background-color: #eaecf4;">N°</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center; background-color: #eaecf4;">FECHA DE LA ATENCIÓN</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center; background-color: #eaecf4;">TIPO ATENCIÓN</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center; background-color: #eaecf4;">CÓDIGO ATENCIÓN</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center; background-color: #eaecf4;">DEPARTAMENTO</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center; background-color: #eaecf4;">MUNICIPIO</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center; background-color: #eaecf4;">NIVEL</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">ESTABLECIMIENTO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">TIPO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">PROCEDENCIA</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">DIAGNÓSTICO 1</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">DIAGNÓSTICO 2</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">DIAGNÓSTICO 3</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">DIAGNÓSTICO 4</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">CAPTACIÓN</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">MÉDICO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">EDAD</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">ESPECIALIDAD MÉDICA</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">CARNET DE IDENTIDAD</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">FECHA DE NACIMIENTO</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center; background-color: #eaecf4;">PERSONA ATENDIDA</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">GENERO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">TELÉFONO PACIENTE</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">NACIÓN</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">NUEVO / SEGUIMIENTO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">TIEMPO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">CONSULTA/VISITA</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">CONTEXTO ATENCIÓN</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">MEDIO COMUNICACIÓN</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">ESTADO DEL PACIENTE</td>
            <?php
            // El listado dinámico de dispositivos se mantiene intacto
            $sql_d = " SELECT idexamen_complementario, examen_complementario FROM examen_complementario WHERE telesalud = 'SI' AND idexamen_complementario != '6' ORDER BY idexamen_complementario ";
            $result_d = mysqli_query($link,$sql_d);
            if ($row_d = mysqli_fetch_array($result_d)){
            mysqli_field_seek($result_d,0);
            while ($field_d = mysqli_fetch_field($result_d)){
            } do { ?>
                <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;"><?php echo $row_d[1] ?></td>
            <?php                  
            } while ($row_d = mysqli_fetch_array($result_d));
            }
            ?>
            <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center; background-color: #eaecf4;">TELEMETRIAS</td>
        </tr> 
    </thead>
    <tbody>
    <?php
    $numero_te=1;
    // INGENIERÍA DE DATOS: Inyectamos la columna nac.nacion en el select (índice 28)
    $sql_te = " SELECT a.idatencion_psafci, a.codigo, n.nombre, n.paterno, n.materno, d.departamento, m.municipio, es.establecimiento_salud, te.tipo_establecimiento,  ";
    $sql_te.= " ne.nivel_establecimiento, tc.tipo_consulta, ta.tipo_atencion, c.captacion_ts, de.de_ts, en.en_ts, vc.via_comunicacion, em.especialidad_medica,  ";
    $sql_te.= " t.tiempo_ts, ep.estado_paciente, at.telefono_paciente, a.fecha_registro, a.hora_registro, a.idusuario, n.ci, a.idrepeticion, n.fecha_nac, g.genero, a.idtipo_atencion, nac.nacion FROM atencion_psafci a "; 
    
    $sql_te.= " INNER JOIN nombre n ON a.idnombre = n.idnombre ";
    $sql_te.= " LEFT JOIN atencion_teleconsulta at ON a.idatencion_psafci = at.idatencion_psafci ";
    $sql_te.= " LEFT JOIN tipo_consulta tc ON a.idtipo_consulta = tc.idtipo_consulta ";
    $sql_te.= " INNER JOIN departamento d ON a.iddepartamento = d.iddepartamento  ";
    $sql_te.= " INNER JOIN municipios m ON a.idmunicipio = m.idmunicipio ";
    $sql_te.= " INNER JOIN establecimiento_salud es ON a.idestablecimiento_salud = es.idestablecimiento_salud  ";
    $sql_te.= " INNER JOIN tipo_atencion ta ON a.idtipo_atencion = ta.idtipo_atencion ";
    $sql_te.= " INNER JOIN tipo_establecimiento te ON es.idtipo_establecimiento = te.idtipo_establecimiento "; 
    $sql_te.= " INNER JOIN nivel_establecimiento ne ON es.idnivel_establecimiento = ne.idnivel_establecimiento ";
    $sql_te.= " LEFT JOIN captacion_ts c ON at.idcaptacion_ts = c.idcaptacion_ts  "; 
    $sql_te.= " LEFT JOIN de_ts de ON at.idde_ts = de.idde_ts ";
    $sql_te.= " LEFT JOIN en_ts en ON at.iden_ts = en.iden_ts ";
    $sql_te.= " LEFT JOIN via_comunicacion vc ON at.idvia_comunicacion = vc.idvia_comunicacion ";
    $sql_te.= " LEFT JOIN especialidad_medica em ON at.idespecialidad_medica = em.idespecialidad_medica ";
    $sql_te.= " LEFT JOIN tiempo_ts t ON at.idtiempo_ts = t.idtiempo_ts ";
    $sql_te.= " LEFT JOIN genero g ON n.idgenero = g.idgenero ";
    $sql_te.= " LEFT JOIN estado_paciente ep ON at.idestado_paciente = ep.idestado_paciente ";
    $sql_te.= " LEFT JOIN nacion nac ON a.idnacion = nac.idnacion "; // <-- EL CRUCE CON LA TABLA NACIÓN
    
    $sql_te.= " WHERE a.fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND (a.idtipo_atencion = '3' OR a.idtipo_atencion = '4') " . $filtro_extra . " ORDER BY a.idatencion_psafci DESC";
    
    $result_te = mysqli_query($link,$sql_te) or die(mysqli_error($link));
    if ($row_te = mysqli_fetch_array($result_te)){
    mysqli_field_seek($result_te,0);
    while ($field_te = mysqli_fetch_field($result_te)){
    } do { 
        $total_telemetrias_fila = 0;
        
        // Calcular la edad exacta al momento de la consulta
        $edad_calculada = "";
        if (!empty($row_te[25]) && $row_te[25] != '0000-00-00') {
            $fecha_nac_dt = new DateTime($row_te[25]);
            $fecha_ate_dt = new DateTime($row_te[20]);
            $intervalo = $fecha_nac_dt->diff($fecha_ate_dt);
            $edad_calculada = $intervalo->y;
        }

        // REGLA DE NEGOCIO: Si idtipo_atencion es 4 (Telemetría), purgamos los campos exclusivos de Teleconsulta
        $es_telemetria = ($row_te[27] == '4');
        $especialidad_display = $es_telemetria ? "" : $row_te[16];
        $tiempo_display       = $es_telemetria ? "" : $row_te[17];
        $medio_display        = $es_telemetria ? "" : $row_te[15];
        $estado_display       = $es_telemetria ? "" : $row_te[18];
        ?>
        <tr>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px; text-align: center;"><?php echo $numero_te;?></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px; text-align: center;"> 
                <?php 
                $fecha_r = explode('-',$row_te[20]);
                echo $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0]; ?>
            </td> 
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px; text-align: center;"><?php echo $row_te[11]?></td> 
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px; text-align: center;"><?php echo $row_te[1]?></td> 
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px;"><?php echo $row_te[5]?></td> 
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px;"><?php echo $row_te[6]?></td> 
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px; text-align: center;"><?php echo $row_te[9]?></td> 
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px;"><?php echo $row_te[7]?></td> 
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px; text-align: center;"><?php echo $row_te[8]?></td> 
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px;"><?php echo $row_te[13]?></td> 
            <?php
            // EXTRACCIÓN MIGRADA: Muestra Código CIE-10 primero y luego la Patología
            $diagnostico=1;
            $sql_dg = " SELECT patologia.patologia, patologia.cie FROM diagnostico_teleconsulta, patologia WHERE diagnostico_teleconsulta.idpatologia=patologia.idpatologia  ";
            $sql_dg.= " AND diagnostico_teleconsulta.idatencion_psafci='$row_te[0]' ";
            $result_dg = mysqli_query($link,$sql_dg);
            if ($row_dg = mysqli_fetch_array($result_dg)){
            mysqli_field_seek($result_dg,0);
            while ($field_dg = mysqli_fetch_field($result_dg)){
            } do {                 
                ?>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px;"><?php echo $row_dg[1]?> - <?php echo $row_dg[0]?></td>
            <?php    
            $diagnostico=$diagnostico+1;              
            } while ($row_dg = mysqli_fetch_array($result_dg));
            }
            for ($i = $diagnostico; $i <= 4; $i++) {  ?>
                <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px;"></td>
            <?php } ?>
            
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px;"><?php echo $row_te[12]?></td> 
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px;"> 
              <?php 
                $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                $sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row_te[22]' ";
                $result_r = mysqli_query($link,$sql_r);
                if($row_r = mysqli_fetch_array($result_r)){
                    echo mb_strtoupper($row_r[0]." " . $row_r[1]." ".$row_r[2]);
                } ?>
            </td> 
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px; text-align: center;"><?php echo $edad_calculada; ?></td> 
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px;"><?php echo $especialidad_display; ?></td> 
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px; text-align: center;"><?php echo $row_te[23]?></td> 
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px; text-align: center;">
                <?php 
                if(!empty($row_te[25]) && $row_te[25] != '0000-00-00'){
                    $fecha_n_partes = explode('-', $row_te[25]);
                    echo $fecha_n_partes[2].'/'.$fecha_n_partes[1].'/'.$fecha_n_partes[0];
                } ?>
            </td> 
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px;"><?php echo mb_strtoupper($row_te[2].' '.$row_te[3].' '.$row_te[4]);?></td> 
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px; text-align: center;"><?php echo !empty($row_te[26]) ? mb_strtoupper($row_te[26]) : "S/D"; ?></td> 
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px; text-align: center;"><?php echo $row_te[19]?></td> 
            
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px; text-align: center;"><?php echo !empty($row_te[28]) ? mb_strtoupper($row_te[28]) : "S/D"; ?></td> <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px; text-align: center;">
                <?php 
                if($row_te[24] == '1') { echo "NUEVO"; } 
                else if($row_te[24] == '2') { echo "SEGUIMIENTO"; } 
                else { echo "S/D"; } 
                ?>
            </td> 
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px; text-align: center;"><?php echo $tiempo_display; ?></td> 
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px; text-align: center;"><?php echo !empty($row_te[10]) ? mb_strtoupper($row_te[10]) : "S/D"; ?></td> 
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px;"><?php echo $row_te[14]?></td> 
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px;"><?php echo $medio_display; ?></td> 
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px;"><?php echo $estado_display; ?></td> 
            
            <?php
            // Evaluación del listado de dispositivos
            $sql_ec = " SELECT idexamen_complementario, examen_complementario FROM examen_complementario WHERE telesalud = 'SI' AND idexamen_complementario != '6' ORDER BY idexamen_complementario ";
            $result_ec = mysqli_query($link,$sql_ec);
            if ($row_ec = mysqli_fetch_array($result_ec)){
            mysqli_field_seek($result_ec,0);
            while ($field_ec = mysqli_fetch_field($result_ec)){
            } do { 
                ?>
                <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 11px; text-align: center;" >
                    <?php
                        // INGENIERÍA DE DATOS: Validación perfecta aislando errores de tipeo y excluyendo de la suma
                        $sql_ex = " SELECT idexamen_teleconsulta FROM examen_teleconsulta WHERE idatencion_psafci='$row_te[0]' AND  idexamen_complementario='$row_ec[0]' ";
                        $result_ex = mysqli_query($link,$sql_ex);
                        if ($row_ex = mysqli_fetch_array($result_ex)){
                            echo $row_ec[1]; 
                            
                            $nombre_equipo = strtoupper($row_ec[1]);
                            if (strpos($nombre_equipo, 'MONITOR DE SIGNOS VITALES') === false && 
                                strpos($nombre_equipo, 'ESTETOSCOPIO DIGITAL') === false && 
                                strpos($nombre_equipo, 'OTRO') === false) { // Elimina todo lo que tenga la palabra OTRO
                                $total_telemetrias_fila++;
                            }
                        } ?>
                </td>
            <?php                  
            } while ($row_ec = mysqli_fetch_array($result_ec));
            }
            ?>
            <td bgcolor="#E1F5FE" style="font-family: Arial; font-size: 11px; text-align: center; color: #0D47A1;">
                <?php echo $total_telemetrias_fila; ?>
            </td> 
        </tr>
    <?php 
    $numero_te=$numero_te+1;                 
    } while ($row_te = mysqli_fetch_array($result_te));
    } 
    ?>               
    </tbody>
</table>
</body>
</html>