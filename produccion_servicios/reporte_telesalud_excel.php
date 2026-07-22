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
        <style type="text/css">
            /* OPTIMIZACIÓN DE PESO DE ARCHIVO (CSS GLOBALES) */
            table { border-collapse: collapse; }
            .c-dato { font-family: Arial; font-size: 11px; text-align: center; background-color: #FFFFFF; }
            .c-izq { font-family: Arial; font-size: 11px; text-align: left; background-color: #FFFFFF; }
            .c-azul { font-family: Arial; font-size: 11px; text-align: center; background-color: #E1F5FE; color: #0D47A1; }
        </style>
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
              
              <!-- COLUMNA CÓDIGO EESS -->
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center; background-color: #eaecf4;">CÓDIGO DE EESS</td>
              
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
    // INGENIERÍA DE DATOS: Inyectamos es.codigo_establecimiento al final de la consulta (asegurándonos de que se jale a la matriz en memoria)
    $sql_te = " SELECT a.idatencion_psafci, a.codigo, n.nombre, n.paterno, n.materno, d.departamento, m.municipio, es.establecimiento_salud, te.tipo_establecimiento,  ";
    $sql_te.= " ne.nivel_establecimiento, tc.tipo_consulta, ta.tipo_atencion, c.captacion_ts, de.de_ts, en.en_ts, vc.via_comunicacion, em.especialidad_medica,  ";
    $sql_te.= " t.tiempo_ts, ep.estado_paciente, at.telefono_paciente, a.fecha_registro, a.hora_registro, a.idusuario, n.ci, a.idrepeticion, n.fecha_nac, g.genero, a.idtipo_atencion, nac.nacion, es.codigo_establecimiento FROM atencion_psafci a "; 
    
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
    $sql_te.= " LEFT JOIN nacion nac ON a.idnacion = nac.idnacion ";
    
    $sql_te.= " WHERE a.fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND (a.idtipo_atencion = '3' OR a.idtipo_atencion = '4') " . $filtro_extra . " ORDER BY a.idatencion_psafci DESC";
    
    $result_te = mysqli_query($link,$sql_te) or die(mysqli_error($link));
    if ($row_te = mysqli_fetch_array($result_te)){
    mysqli_field_seek($result_te,0);
    while ($field_te = mysqli_fetch_field($result_te)){
    } do { 
        $total_telemetrias_fila = 0;
        
        // Calcular la edad exacta al momento de la consulta
        $edad_calculada = "";
        if (!empty($row_te['fecha_nac']) && $row_te['fecha_nac'] != '0000-00-00') {
            $fecha_nac_dt = new DateTime($row_te['fecha_nac']);
            $fecha_ate_dt = new DateTime($row_te['fecha_registro']);
            $intervalo = $fecha_nac_dt->diff($fecha_ate_dt);
            $edad_calculada = $intervalo->y;
        }

        // REGLA DE NEGOCIO: Si idtipo_atencion es 4 (Telemetría), purgamos los campos exclusivos de Teleconsulta
        $es_telemetria = ($row_te['idtipo_atencion'] == '4');
        $especialidad_display = $es_telemetria ? "" : $row_te['especialidad_medica'];
        $tiempo_display       = $es_telemetria ? "" : $row_te['tiempo_ts'];
        $medio_display        = $es_telemetria ? "" : $row_te['via_comunicacion'];
        $estado_display       = $es_telemetria ? "" : $row_te['estado_paciente'];
        ?>
        <tr>
            <!-- CLASES CSS APLICADAS PARA MINIMIZAR EL TEXTO HTML Y ALIGERAR EL EXCEL -->
            <td class="c-dato"><?php echo $numero_te;?></td>
            <td class="c-dato"> 
                <?php 
                $fecha_r = explode('-',$row_te['fecha_registro']);
                echo isset($fecha_r[2]) ? $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0] : ''; ?>
            </td> 
            <td class="c-dato"><?php echo $row_te['tipo_atencion']?></td> 
            <td class="c-dato"><?php echo $row_te['codigo']?></td> 
            
            <!-- SOLUCIÓN QUIRÚRGICA: Llamada segura por llave asociativa limpiando espacios fantasmas -->
            <td class="c-dato">
                <?php 
                $codigo_eess = isset($row_te['codigo_establecimiento']) ? trim($row_te['codigo_establecimiento']) : (isset($row_te[29]) ? trim($row_te[29]) : '');
                echo ($codigo_eess !== '') ? $codigo_eess : "S/D"; 
                ?>
            </td> 

            <td class="c-izq"><?php echo $row_te['departamento']?></td> 
            <td class="c-izq"><?php echo $row_te['municipio']?></td> 
            <td class="c-dato"><?php echo $row_te['nivel_establecimiento']?></td> 
            <td class="c-izq"><?php echo $row_te['establecimiento_salud']?></td> 
            <td class="c-dato"><?php echo $row_te['tipo_establecimiento']?></td> 
            <td class="c-izq"><?php echo $row_te['de_ts']?></td> 
            <?php
            // EXTRACCIÓN MIGRADA: Muestra Código CIE-10 primero y luego la Patología
            $diagnostico=1;
            $sql_dg = " SELECT patologia.patologia, patologia.cie FROM diagnostico_teleconsulta, patologia WHERE diagnostico_teleconsulta.idpatologia=patologia.idpatologia  ";
            $sql_dg.= " AND diagnostico_teleconsulta.idatencion_psafci='{$row_te['idatencion_psafci']}' ";
            $result_dg = mysqli_query($link,$sql_dg);
            if ($row_dg = mysqli_fetch_array($result_dg)){
            mysqli_field_seek($result_dg,0);
            while ($field_dg = mysqli_fetch_field($result_dg)){
            } do {                
                ?>
            <td class="c-izq"><?php echo $row_dg[1]?> - <?php echo $row_dg[0]?></td>
            <?php    
            $diagnostico=$diagnostico+1;              
            } while ($row_dg = mysqli_fetch_array($result_dg));
            }
            for ($i = $diagnostico; $i <= 4; $i++) {  ?>
                <td class="c-izq"></td>
            <?php } ?>
            
            <td class="c-izq"><?php echo $row_te['captacion_ts']?></td> 
            <td class="c-izq"> 
              <?php 
                $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                $sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='{$row_te['idusuario']}' ";
                $result_r = mysqli_query($link,$sql_r);
                if($row_r = mysqli_fetch_array($result_r)){
                    echo mb_strtoupper($row_r[0]." " . $row_r[1]." ".$row_r[2]);
                } ?>
            </td> 
            <td class="c-dato"><?php echo $edad_calculada; ?></td> 
            <td class="c-izq"><?php echo $especialidad_display; ?></td> 
            <td class="c-dato"><?php echo $row_te['ci']?></td> 
            <td class="c-dato">
                <?php 
                if(!empty($row_te['fecha_nac']) && $row_te['fecha_nac'] != '0000-00-00'){
                    $fecha_n_partes = explode('-', $row_te['fecha_nac']);
                    echo isset($fecha_n_partes[2]) ? $fecha_n_partes[2].'/'.$fecha_n_partes[1].'/'.$fecha_n_partes[0] : '';
                } ?>
            </td> 
            <td class="c-izq"><?php echo mb_strtoupper($row_te['nombre'].' '.$row_te['paterno'].' '.$row_te['materno']);?></td> 
            <td class="c-dato"><?php echo !empty($row_te['genero']) ? mb_strtoupper($row_te['genero']) : "S/D"; ?></td> 
            <td class="c-dato"><?php echo $row_te['telefono_paciente']?></td> 
            
            <td class="c-dato"><?php echo !empty($row_te['nacion']) ? mb_strtoupper($row_te['nacion']) : "S/D"; ?></td> 
            <td class="c-dato">
                <?php 
                if($row_te['idrepeticion'] == '1') { echo "NUEVO"; } 
                else if($row_te['idrepeticion'] == '2') { echo "SEGUIMIENTO"; } 
                else { echo "S/D"; } 
                ?>
            </td> 
            <td class="c-dato"><?php echo $tiempo_display; ?></td> 
            <td class="c-dato"><?php echo !empty($row_te['tipo_consulta']) ? mb_strtoupper($row_te['tipo_consulta']) : "S/D"; ?></td> 
            <td class="c-izq"><?php echo $row_te['en_ts']?></td> 
            <td class="c-izq"><?php echo $medio_display; ?></td> 
            <td class="c-izq"><?php echo $estado_display; ?></td> 
            
            <?php
            // Evaluación del listado de dispositivos
            $sql_ec = " SELECT idexamen_complementario, examen_complementario FROM examen_complementario WHERE telesalud = 'SI' AND idexamen_complementario != '6' ORDER BY idexamen_complementario ";
            $result_ec = mysqli_query($link,$sql_ec);
            if ($row_ec = mysqli_fetch_array($result_ec)){
            mysqli_field_seek($result_ec,0);
            while ($field_ec = mysqli_fetch_field($result_ec)){
            } do { 
                ?>
                <td class="c-dato">
                    <?php
                        $sql_ex = " SELECT idexamen_teleconsulta FROM examen_teleconsulta WHERE idatencion_psafci='{$row_te['idatencion_psafci']}' AND  idexamen_complementario='{$row_ec[0]}' ";
                        $result_ex = mysqli_query($link,$sql_ex);
                        if ($row_ex = mysqli_fetch_array($result_ex)){
                            echo $row_ec[1]; 
                            
                            $nombre_equipo = strtoupper($row_ec[1]);
                            if (strpos($nombre_equipo, 'MONITOR DE SIGNOS VITALES') === false && 
                                strpos($nombre_equipo, 'ESTETOSCOPIO DIGITAL') === false && 
                                strpos($nombre_equipo, 'OTRO') === false) { 
                                $total_telemetrias_fila++;
                            }
                        } ?>
                </td>
            <?php                  
            } while ($row_ec = mysqli_fetch_array($result_ec));
            }
            ?>
            <td class="c-azul">
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