<?php
date_default_timezone_set('America/La_Paz');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=REPORTE_TELESALUD_" . date('Y-m-d') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
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

// MATRIZ FIJA Y ESTRICTA PARA EL ORDEN DE LOS EQUIPOS DE TELEMETRÍA
$equipos_orden_estricto = array(
    "Electrocardiografo",
    "Videocolposcopio",
    "Oftalmoscopio",
    "Otoscopio",
    "Espirometro",
    "Monitor de signos vitales",
    "Sonda de Ultrasonido digital",
    "Ecografo portatil",
    "Ecografo",
    "Camara de examen general",
    "Estetoscopio digital",
    "Camara Multiproposito",
    "Glucometro",
    "Monitor Materno Fetal",
    "Monitor Multiparametrico básico"
);

// Diccionario inverso para buscar en la base de datos por el nombre estandarizado
$mapeo_db = array(
    'ELECTROCARDIOGRAFO'              => 'Electrocardiografo',
    'ELECTROCARDIÓGRAFO'              => 'Electrocardiografo',
    'VIDEO-COLPOSCOPIO'               => 'Videocolposcopio',
    'VIDEOCOLPOSCOPIO'                => 'Videocolposcopio',
    'OFTALMOSCOPIO'                   => 'Oftalmoscopio',
    'OTOSCOPIO'                       => 'Otoscopio',
    'ESPIROMETRO DIGITAL'             => 'Espirometro',
    'ESPIRÓMETRO DIGITAL'             => 'Espirometro',
    'ESPIROMETRO'                     => 'Espirometro',
    'MONITOR DE SIGNOS VITALES'       => 'Monitor de signos vitales',
    'SONDA DE ULTRASONIDO'            => 'Sonda de Ultrasonido digital',
    'SONDA DE ULTRASONIDO DIGITAL'    => 'Sonda de Ultrasonido digital',
    'ECOGRAFO PORTATIL'               => 'Ecografo portatil',
    'ECÓGRAFO PORTÁTIL'               => 'Ecografo portatil',
    'ECOGRAFO'                        => 'Ecografo',
    'ECÓGRAFO'                        => 'Ecografo',
    'CAMARA EXAMEN GENERAL'           => 'Camara de examen general',
    'CÁMARA EXAMEN GENERAL'           => 'Camara de examen general',
    'CÁMARA DE EXAMEN GENERAL'        => 'Camara de examen general',
    'ESTETOSCOPIO DIGITAL'            => 'Estetoscopio digital',
    'CAMARA MULTIPROPOSITO'           => 'Camara Multiproposito',
    'CÁMARA MULTIPROPÓSITO'           => 'Camara Multiproposito',
    'GLUCOMETRO'                      => 'Glucometro',
    'GLUCÓMETRO'                      => 'Glucometro',
    'MONITOR MATERNO FETAL'           => 'Monitor Materno Fetal',
    'MONITOR MULTIPARAMETRICO BASICO' => 'Monitor Multiparametrico básico',
    'MONITOR MULTIPARAMÉTRICO BÁSICO' => 'Monitor Multiparametrico básico',
    'MONITOR MULTIPARAMETRICO BÁSICO' => 'Monitor Multiparametrico básico'
);

?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>REPORTE TELESALUD</title>
        <style type="text/css">
            table { border-collapse: collapse; }
            .c-cabecera { font-family: Arial; font-size: 12px; color: #ffffff; text-align: center; background-color: #2D56CF; font-weight: bold; padding: 5px; }
            .c-dato { font-family: Arial; font-size: 11px; text-align: center; background-color: #FFFFFF; }
            .c-izq { font-family: Arial; font-size: 11px; text-align: left; background-color: #FFFFFF; }
            .c-azul { font-family: Arial; font-size: 11px; text-align: center; background-color: #E1F5FE; color: #0D47A1; }
        </style>
</head>
<body>
<h4 align="center" style="font-family: Arial;">REPORTE DE ATENCIONES POR TELESALUD </h4>
<h4 align="center" style="font-family: Arial;"> DEL <?php echo $f_inicio;?> AL <?php echo $f_finalizacion;?></h4>
<table width="100%" border="1" align="center" bordercolor="#009999">
    <thead>
        <tr>
            <td class="c-cabecera">N°</td>
            <td class="c-cabecera">FECHA DE ATENCIÓN</td>
            <td class="c-cabecera">TIPO ATENCIÓN</td>
            <td class="c-cabecera">CÓDIGO ATENCIÓN</td>
            <td class="c-cabecera">CÓDIGO DE EESS</td>
            <td class="c-cabecera">DEPARTAMENTO</td>
            <td class="c-cabecera">MUNICIPIO</td>
            <td class="c-cabecera">NIVEL</td>
            <td class="c-cabecera">ESTABLECIMIENTO</td>
            <td class="c-cabecera">TIPO</td>
            <td class="c-cabecera">PROCEDENCIA</td>
            <td class="c-cabecera">DIAGNÓSTICO 1</td>
            <td class="c-cabecera">DIAGNÓSTICO 2</td>
            <td class="c-cabecera">DIAGNÓSTICO 3</td>
            <td class="c-cabecera">DIAGNÓSTICO 4</td>
            
            <td class="c-cabecera" style="background-color: #8e44ad;">D</td>
            <td class="c-cabecera" style="background-color: #1A237E;">ENT</td>
            <td class="c-cabecera" style="background-color: #e74a3b;">ET</td>
            <td class="c-cabecera" style="background-color: #1cc88a;">SI</td>
            <td class="c-cabecera" style="background-color: #e83e8c;">SM</td>
            <td class="c-cabecera">OTROS</td>

            <td class="c-cabecera">CAPTACIÓN</td>
            <td class="c-cabecera">MÉDICO</td>
            
            <td class="c-cabecera">GRUPO ETAREO</td>
            <td class="c-cabecera">EDAD</td>
            
            <td class="c-cabecera">ESPECIALIDAD MÉDICA</td>
            <td class="c-cabecera">CARNET DE IDENTIDAD</td>
            <td class="c-cabecera">FECHA DE NACIMIENTO</td>
            <td class="c-cabecera">PERSONA ATENDIDA</td>
            <td class="c-cabecera">GENERO</td>
            <td class="c-cabecera">TELÉFONO PACIENTE</td>
            <td class="c-cabecera">NACIÓN</td>
            
            <td class="c-cabecera">GRUPOS VULNERABLES</td>
            
            <td class="c-cabecera">NUEVO / SEGUIMIENTO</td>
            <td class="c-cabecera">TIEMPO</td>
            <!-- FASE DE MEJORA: Se eliminó la columna CONSULTA/VISITA -->
            <td class="c-cabecera">CONTEXTO ATENCIÓN</td>
            <td class="c-cabecera">MEDIO COMUNICACIÓN</td>
            <td class="c-cabecera">ESTADO DEL PACIENTE</td>
            <?php
            // ENCABEZADOS DE TELEMETRÍA FIJOS
            foreach ($equipos_orden_estricto as $equipo) {
                echo "<td class='c-cabecera'>" . $equipo . "</td>";
            }
            ?>
            <td class="c-cabecera">TELEMETRIAS</td>
        </tr> 
    </thead>
    <tbody>
    <?php
    $numero_te=1;
    // INGENIERÍA DE DATOS
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
        
        // =========================================================================
        // CÁLCULOS DEMOGRÁFICOS Y EPIDEMIOLÓGICOS (EDAD, SI Y GRUPO ETAREO)
        // =========================================================================
        $edad_calculada = "";
        $indicador_si = ""; 
        $grupo_etareo = "S/D";
        
        if (!empty($row_te['fecha_nac']) && $row_te['fecha_nac'] != '0000-00-00') {
            $fecha_nac_dt = new DateTime($row_te['fecha_nac']);
            $fecha_ate_dt = new DateTime($row_te['fecha_registro']);
            $intervalo = $fecha_nac_dt->diff($fecha_ate_dt);
            
            $edad_calculada = $intervalo->y;
            $meses_totales = ($intervalo->y * 12) + $intervalo->m;
            
            if ($edad_calculada < 5) {
                $indicador_si = "SALUD INFANTIL";
            }
            
            if ($meses_totales < 6) { $grupo_etareo = "a) < 6 meses"; }
            elseif ($meses_totales >= 6 && $meses_totales <= 11) { $grupo_etareo = "b) 6 a 11 Meses"; }
            elseif ($edad_calculada >= 1 && $edad_calculada <= 4) { $grupo_etareo = "c) 1 a 4 años"; }
            elseif ($edad_calculada >= 5 && $edad_calculada <= 9) { $grupo_etareo = "d) 5 a 9 años"; }
            elseif ($edad_calculada >= 10 && $edad_calculada <= 14) { $grupo_etareo = "e) 10 a 14 años"; }
            elseif ($edad_calculada >= 15 && $edad_calculada <= 19) { $grupo_etareo = "f) 15 a 19 años"; }
            elseif ($edad_calculada >= 20 && $edad_calculada <= 39) { $grupo_etareo = "g) 20 a 39 años"; }
            elseif ($edad_calculada >= 40 && $edad_calculada <= 49) { $grupo_etareo = "h) 40 a 49 años"; }
            elseif ($edad_calculada >= 50 && $edad_calculada <= 59) { $grupo_etareo = "i) 50 a 59 años"; }
            else { $grupo_etareo = "j) > 60 años"; }
        }

        $genero_final = "S/D";
        if (!empty($row_te['genero'])) {
            $g_upper = strtoupper($row_te['genero']);
            if ($g_upper == 'MASCULINO' || $g_upper == 'M') { $genero_final = 'M'; }
            else if ($g_upper == 'FEMENINO' || $g_upper == 'F') { $genero_final = 'F'; }
            else { $genero_final = $g_upper; }
        }

        // =========================================================================
        // EXTRACCIÓN DE GRUPOS VULNERABLES Y DISCAPACIDAD
        // =========================================================================
        $indicador_discapacidad = "";
        $txt_grupos_vulnerables = "";
        $arr_gv = array();

        $sql_gv = " SELECT gv.idgrupo_vulnerable, gv.grupo_vulnerable FROM atencion_grupo_vulnerable agv INNER JOIN grupo_vulnerable gv ON agv.idgrupo_vulnerable = gv.idgrupo_vulnerable WHERE agv.idatencion_psafci = '{$row_te['idatencion_psafci']}' ";
        $res_gv = mysqli_query($link, $sql_gv);
        
        if ($res_gv && mysqli_num_rows($res_gv) > 0) {
            while ($row_gv = mysqli_fetch_array($res_gv)) {
                $id_gv = $row_gv[0];
                $nombre_gv = mb_strtoupper($row_gv[1]);
                $arr_gv[] = $nombre_gv;
                
                if ($id_gv == '5') {
                    $indicador_discapacidad = "DISCAPACIDAD";
                }
            }
            $txt_grupos_vulnerables = implode(", ", $arr_gv);
        } else {
            $txt_grupos_vulnerables = "S/D";
        }

        // =========================================================================
        // EXTRACCIÓN DE DIAGNÓSTICOS Y CÁLCULO DE GRUPOS PRIORIZADOS (4 DIAGNÓSTICOS)
        // =========================================================================
        $diag_array = array("", "", "", "");
        $d_idx = 0;
        
        $aten_ent = false;
        $aten_et = false;
        $aten_sm = false;
        $aten_otros = false;

        $sql_dg = " SELECT p.patologia, p.cie, p.idgrupo_priorizado FROM diagnostico_teleconsulta dt INNER JOIN patologia p ON dt.idpatologia=p.idpatologia WHERE dt.idatencion_psafci='{$row_te['idatencion_psafci']}' LIMIT 4";
        $res_dg = mysqli_query($link,$sql_dg);
        if ($res_dg && $row_dg = mysqli_fetch_array($res_dg)){
            do {
                if ($d_idx < 4) {
                    $diag_array[$d_idx] = $row_dg[1]." - ".$row_dg[0];
                }
                $d_idx++;
                
                $id_gp = $row_dg[2];
                if ($id_gp == '1') { $aten_ent = true; }
                elseif ($id_gp == '2') { $aten_et = true; }
                elseif ($id_gp == '3') { $aten_sm = true; }
                else { $aten_otros = true; } 
                
            } while ($row_dg = mysqli_fetch_array($res_dg));
        }

        $txt_aten_ent = $aten_ent ? "ENT" : "";
        $txt_aten_et = $aten_et ? "ET" : "";
        $txt_aten_sm = $aten_sm ? "SALUD MATERNA" : "";
        $txt_aten_otros = $aten_otros ? "OTROS" : "";

        // =========================================================================
        // ESTANDARIZACIÓN TEXTUAL (TIPO ORACIÓN Y TIPO TÍTULO)
        // =========================================================================
        $txt_nacion       = !empty($row_te['nacion']) ? ucwords(mb_strtolower(trim($row_te['nacion']))) : "S/D";
        $txt_procedencia  = !empty($row_te['de_ts']) ? ucfirst(mb_strtolower(trim($row_te['de_ts']))) : "S/D";
        $txt_captacion    = !empty($row_te['captacion_ts']) ? ucfirst(mb_strtolower(trim($row_te['captacion_ts']))) : "S/D";
        
        $es_telemetria = ($row_te['idtipo_atencion'] == '4');
        $especialidad_display = $es_telemetria ? "" : $row_te['especialidad_medica'];
        $tiempo_display       = $es_telemetria ? "" : ucfirst(mb_strtolower(trim($row_te['tiempo_ts']))); 
        $medio_display        = $es_telemetria ? "" : ucwords(mb_strtolower(trim($row_te['via_comunicacion']))); 
        $contexto_display     = $es_telemetria ? "" : ucfirst(mb_strtolower(trim($row_te['en_ts'])));
        $estado_display       = $es_telemetria ? "" : $row_te['estado_paciente'];
        
        $txt_seguimiento = "S/D";
        if($row_te['idrepeticion'] == '1') { $txt_seguimiento = "Nuevo"; } 
        else if($row_te['idrepeticion'] == '2') { $txt_seguimiento = "Seguimiento"; } 

        ?>
        <tr>
            <td class="c-dato"><?php echo $numero_te;?></td>
            <td class="c-dato"> 
                <?php 
                $fecha_r = explode('-',$row_te['fecha_registro']);
                echo isset($fecha_r[2]) ? $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0] : ''; ?>
            </td> 
            <td class="c-dato"><?php echo $row_te['tipo_atencion']?></td> 
            <td class="c-dato"><?php echo $row_te['codigo']?></td> 
            
            <td class="c-dato">
                <?php 
                $codigo_eess = isset($row_te['codigo_establecimiento']) ? trim($row_te['codigo_establecimiento']) : (isset($row_te[29]) ? trim($row_te[29]) : '');
                echo ($codigo_eess !== '') ? $codigo_eess : "S/D"; 
                ?>
            </td> 

            <td class="c-izq"><?php echo mb_strtoupper($row_te['departamento']);?></td> 
            <td class="c-izq"><?php echo mb_strtoupper($row_te['municipio']);?></td> 
            <td class="c-dato"><?php echo mb_strtoupper($row_te['nivel_establecimiento']);?></td> 
            <td class="c-izq"><?php echo mb_strtoupper($row_te['establecimiento_salud']);?></td> 
            <td class="c-dato"><?php echo mb_strtoupper($row_te['tipo_establecimiento']);?></td> 
            <td class="c-izq"><?php echo $txt_procedencia;?></td> 
            
            <td class="c-izq"><?php echo $diag_array[0]; ?></td>
            <td class="c-izq"><?php echo $diag_array[1]; ?></td>
            <td class="c-izq"><?php echo $diag_array[2]; ?></td>
            <td class="c-izq"><?php echo $diag_array[3]; ?></td>
            
            <td class="c-dato"><?php echo $indicador_discapacidad; ?></td>
            <td class="c-dato"><?php echo $txt_aten_ent; ?></td>
            <td class="c-dato"><?php echo $txt_aten_et; ?></td>
            <td class="c-dato"><?php echo $indicador_si; ?></td>
            <td class="c-dato"><?php echo $txt_aten_sm; ?></td>
            <td class="c-dato"><?php echo $txt_aten_otros; ?></td>
            
            <td class="c-izq"><?php echo $txt_captacion; ?></td> 
            <td class="c-izq"> 
              <?php 
                $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                $sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='{$row_te['idusuario']}' ";
                $result_r = mysqli_query($link,$sql_r);
                if($row_r = mysqli_fetch_array($result_r)){
                    echo mb_strtoupper($row_r[0]." " . $row_r[1]." ".$row_r[2]);
                } ?>
            </td> 
            <td class="c-dato"><?php echo $grupo_etareo; ?></td> 
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
            <td class="c-dato"><?php echo $genero_final; ?></td> 
            <td class="c-dato"><?php echo $row_te['telefono_paciente']?></td> 
            
            <td class="c-izq"><?php echo $txt_nacion; ?></td> 
            
            <td class="c-izq"><?php echo $txt_grupos_vulnerables; ?></td> 
            
            <td class="c-dato"><?php echo $txt_seguimiento; ?></td> 
            <td class="c-dato"><?php echo $tiempo_display; ?></td> 
            <td class="c-izq"><?php echo $contexto_display; ?></td> 
            <td class="c-izq"><?php echo $medio_display; ?></td> 
            <td class="c-izq"><?php echo $estado_display; ?></td> 
            
            <?php
            // Lógica para extraer los equipos del paciente y asignarlos a un array temporal
            $equipos_paciente = array();
            $sql_ex = " SELECT ec.examen_complementario FROM examen_teleconsulta et INNER JOIN examen_complementario ec ON et.idexamen_complementario = ec.idexamen_complementario WHERE et.idatencion_psafci='{$row_te['idatencion_psafci']}' ";
            $result_ex = mysqli_query($link,$sql_ex);
            if ($result_ex) {
                while ($row_ex = mysqli_fetch_array($result_ex)) {
                    $nom_db = strtoupper(trim($row_ex[0]));
                    // Traducir nombre de BD a Estandarizado
                    $nom_estandar = isset($mapeo_db[$nom_db]) ? $mapeo_db[$nom_db] : "";
                    if ($nom_estandar != "") {
                        $equipos_paciente[] = $nom_estandar;
                    }
                }
            }

            // Llenado de columnas usando la matriz estricta ($equipos_orden_estricto)
            foreach ($equipos_orden_estricto as $equipo_columna) {
                if (in_array($equipo_columna, $equipos_paciente)) {
                    echo "<td class='c-dato'>" . $equipo_columna . "</td>";
                    
                    // Sumamos para la columna total (excluyendo Mon.Signos y Estetoscopio)
                    if ($equipo_columna != "Monitor de signos vitales" && $equipo_columna != "Estetoscopio digital") {
                        $total_telemetrias_fila++;
                    }
                } else {
                    echo "<td class='c-dato'></td>";
                }
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