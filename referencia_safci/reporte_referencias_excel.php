<?php   
date_default_timezone_set('America/La_Paz');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=REPORTE_REFERENCIAS_" . date('Y-m-d') . ".xls");
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

// =========================================================================
// 1. RECIBIR Y SANITIZAR LOS FILTROS DINÁMICOS DESDE EL POST
// =========================================================================
$inicio_raw   = isset($_POST['inicio']) ? $_POST['inicio'] : '';
$fin_raw      = isset($_POST['finalizacion']) ? $_POST['finalizacion'] : '';

$inicio       = mysqli_real_escape_string($link, $inicio_raw);
$finalizacion = mysqli_real_escape_string($link, $fin_raw);

$iddepartamento    = isset($_POST['iddepartamento']) ? mysqli_real_escape_string($link, $_POST['iddepartamento']) : '';
$idmunicipio       = isset($_POST['idmunicipio']) ? mysqli_real_escape_string($link, $_POST['idmunicipio']) : '';
$idestablecimiento = isset($_POST['idestablecimiento']) ? mysqli_real_escape_string($link, $_POST['idestablecimiento']) : '';
$idusuario_medico  = isset($_POST['idusuario_medico']) ? mysqli_real_escape_string($link, $_POST['idusuario_medico']) : '';

// =========================================================================
// MOTOR DUAL DE BÚSQUEDA (Opción B: Aislamiento Total Corregido)
// =========================================================================
$filtro_origen = "1=1";
$filtro_destino = "1=1";
$hay_filtros = false;

if($iddepartamento != '') { 
    $filtro_origen .= " AND referencia_hc.iddepartamento = '$iddepartamento' "; 
    $filtro_destino .= " AND d_dest.iddepartamento = '$iddepartamento' ";
    $hay_filtros = true;
}
if($idmunicipio != '') { 
    $filtro_origen .= " AND referencia_hc.idmunicipio = '$idmunicipio' "; 
    $filtro_destino .= " AND m_dest.idmunicipio = '$idmunicipio' ";
    $hay_filtros = true;
}
if($idestablecimiento != '') { 
    $filtro_origen .= " AND referencia_hc.idestablecimiento_salud = '$idestablecimiento' "; 
    $filtro_destino .= " AND es_dest.idestablecimiento_salud = '$idestablecimiento' ";
    $hay_filtros = true;
}
if($idusuario_medico != '') { 
    $filtro_origen .= " AND referencia_hc.idusuario = '$idusuario_medico' "; 
    $filtro_destino .= " AND EXISTS (SELECT 1 FROM diagnostico_egreso de WHERE de.idreferencia_hc = referencia_hc.idreferencia_hc AND de.idusuario = '$idusuario_medico') ";
    $hay_filtros = true;
}

$filtro_extra = "";
if ($hay_filtros) {
    $filtro_extra = " AND (
        ($filtro_origen) 
        OR 
        (
            referencia_hc.idestado_referencia = '2' 
            AND EXISTS (
                SELECT 1 FROM establecimiento_salud es_dest 
                LEFT JOIN departamento d_dest ON es_dest.iddepartamento = d_dest.iddepartamento
                LEFT JOIN municipios m_dest ON es_dest.idmunicipio = m_dest.idmunicipio
                WHERE es_dest.idestablecimiento_salud = referencia_hc.idestablecimiento_receptor
                AND ($filtro_destino)
            )
        )
    ) ";
}
// =========================================================================

$fecha_i = explode('-',$inicio);
$f_inicio = isset($fecha_i[2]) ? $fecha_i[2].'/'.$fecha_i[1].'/'.$fecha_i[0] : '';

$fecha_f = explode('-',$finalizacion);
$f_finalizacion = isset($fecha_f[2]) ? $fecha_f[2].'/'.$fecha_f[1].'/'.$fecha_f[0] : '';
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>REPORTE REFERENCIAS MEDI-APS</title>
        <style type="text/css">
            table { border-collapse: collapse; }
            .c-cabecera { font-family: Arial; font-size: 12px; color: #ffffff; text-align: center; background-color: #36b9cc; font-weight: bold; padding: 5px; }
            .c-dato { font-family: Arial; font-size: 11px; text-align: center; background-color: #FFFFFF; }
            .c-izq { font-family: Arial; font-size: 11px; text-align: left; background-color: #FFFFFF; }
        </style>
</head>
<body>
<h4 align="center" style="font-family: Arial; color: #36b9cc;">REPORTE DE REFERENCIAS Y CONTRARREFERENCIAS MEDI-APS</h4>
<h4 align="center" style="font-family: Arial;"> DEL <?php echo $f_inicio;?> AL <?php echo $f_finalizacion;?></h4>

<table border="1" align="center" bordercolor="#36b9cc">
    <thead>
        <tr>
            <td class="c-cabecera">N°</td>
            <td class="c-cabecera">FECHA DE REGISTRO</td>
            <td class="c-cabecera">TIPO ATENCIÓN</td>
            <td class="c-cabecera">CÓDIGO REFERENCIA</td>
            <td class="c-cabecera">CÓDIGO DE EESS</td>
            <td class="c-cabecera">DEPARTAMENTO</td>
            <td class="c-cabecera">RED DE SALUD</td>
            <td class="c-cabecera">MUNICIPIO</td>
            <td class="c-cabecera">NIVEL</td>
            <td class="c-cabecera">ESTABLECIMIENTO ORIGEN</td>
            <td class="c-cabecera">ESTABLECIMIENTO RECEPTOR</td>
            <td class="c-cabecera">TIPO</td>
            <td class="c-cabecera">PROCEDENCIA</td>
            <td class="c-cabecera">DIAGNÓSTICO 1</td>
            <td class="c-cabecera">DIAGNÓSTICO 2</td>
            <td class="c-cabecera">DIAGNÓSTICO 3</td>
            
            <td class="c-cabecera" style="background-color: #8e44ad;">D</td>
            <td class="c-cabecera" style="background-color: #1A237E;">ENT</td>
            <td class="c-cabecera" style="background-color: #e74a3b;">ET</td>
            <td class="c-cabecera" style="background-color: #1cc88a;">SI</td>
            <td class="c-cabecera" style="background-color: #e83e8c;">SM</td>
            <td class="c-cabecera">OTROS</td>
            
            <td class="c-cabecera">CAPTACIÓN</td>
            <td class="c-cabecera">MÉDICO OPERATIVO</td>
            <td class="c-cabecera">CARGO ORGANIZACIONAL</td>
            
            <td class="c-cabecera">GRUPO ETAREO</td>
            <td class="c-cabecera">EDAD</td>
            
            <td class="c-cabecera">ESPECIALIDAD MÉDICA</td>
            <td class="c-cabecera">CARNET DE IDENTIDAD</td>
            <td class="c-cabecera">FECHA DE NACIMIENTO</td>
            <td class="c-cabecera">PERSONA REFERIDA</td>
            <td class="c-cabecera">GENERO</td>
            <td class="c-cabecera">TELÉFONO PACIENTE</td>
            <td class="c-cabecera">NACIÓN</td>
            
            <td class="c-cabecera">GRUPOS VULNERABLES</td>
            <td class="c-cabecera">TIC EFECTIVIZADA</td>
            
            <td class="c-cabecera">NUEVO / SEGUIMIENTO</td>
            <td class="c-cabecera">TIEMPO</td>
            <td class="c-cabecera">CONTEXTO ATENCIÓN</td>
            <td class="c-cabecera">TIPO DE TELEINTERCONSULTA</td>
            <td class="c-cabecera">MEDIO COMUNICACIÓN</td>
            <td class="c-cabecera">ESTADO/ETAPA</td>
        </tr> 
    </thead>
    <tbody>
    <?php
    $numero = 1; 
    
    // CONSULTA BASE RESTRINGIDA A CICLOS COMPLETOS (ESTADO 2 + ADMITIDO POR EL ESPECIALISTA)
    $sql =" SELECT referencia_hc.idreferencia_hc, referencia_hc.codigo, nombre.nombre, nombre.paterno, nombre.materno, ";
    $sql.=" departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud, estado_referencia.estado_referencia,  ";
    $sql.=" especialidad_medica.especialidad_medica, referencia_hc.fecha_registro, referencia_hc.hora_registro, referencia_hc.idusuario, red_salud.red_salud, referencia_hc.idestablecimiento_receptor, referencia_hc.idestado_referencia, establecimiento_salud.codigo_establecimiento, ";
    $sql.=" ne.nivel_establecimiento, nombre.ci, nombre.fecha_nac, g.genero, atc.telefono_paciente, nac.nacion, a.idrepeticion, tc.tipo_consulta, de.de_ts, vc.via_comunicacion, ta.tipo_atencion, t_ref.tiempo_ts, te_est.tipo_establecimiento, cap.captacion_ts, en.en_ts, referencia_hc.discapacidad, referencia_hc.idatencion_psafci, ";
    $sql.=" referencia_hc.iddepartamento, referencia_hc.idmunicipio, referencia_hc.idestablecimiento_salud, referencia_hc.idusuario ";
    
    $sql.=" FROM referencia_hc ";
    $sql.=" INNER JOIN nombre ON referencia_hc.idnombre = nombre.idnombre ";
    $sql.=" INNER JOIN estado_referencia ON referencia_hc.idestado_referencia = estado_referencia.idestado_referencia ";
    $sql.=" LEFT JOIN especialidad_medica ON referencia_hc.idespecialidad_medica = especialidad_medica.idespecialidad_medica ";
    $sql.=" INNER JOIN departamento ON referencia_hc.iddepartamento = departamento.iddepartamento ";
    $sql.=" LEFT JOIN red_salud ON referencia_hc.idred_salud = red_salud.idred_salud ";
    $sql.=" INNER JOIN municipios ON referencia_hc.idmunicipio = municipios.idmunicipio ";
    $sql.=" INNER JOIN establecimiento_salud ON referencia_hc.idestablecimiento_salud = establecimiento_salud.idestablecimiento_salud ";
    $sql.=" LEFT JOIN nivel_establecimiento ne ON establecimiento_salud.idnivel_establecimiento = ne.idnivel_establecimiento ";
    $sql.=" LEFT JOIN tipo_establecimiento te_est ON establecimiento_salud.idtipo_establecimiento = te_est.idtipo_establecimiento ";
    $sql.=" LEFT JOIN genero g ON nombre.idgenero = g.idgenero ";
    $sql.=" LEFT JOIN atencion_psafci a ON referencia_hc.idatencion_psafci = a.idatencion_psafci ";
    $sql.=" LEFT JOIN atencion_teleconsulta atc ON referencia_hc.idatencion_psafci = atc.idatencion_psafci ";
    $sql.=" LEFT JOIN nacion nac ON a.idnacion = nac.idnacion ";
    $sql.=" LEFT JOIN tipo_consulta tc ON a.idtipo_consulta = tc.idtipo_consulta ";
    $sql.=" LEFT JOIN de_ts de ON atc.idde_ts = de.idde_ts ";
    $sql.=" LEFT JOIN en_ts en ON atc.iden_ts = en.iden_ts ";
    $sql.=" LEFT JOIN via_comunicacion vc ON atc.idvia_comunicacion = vc.idvia_comunicacion ";
    $sql.=" LEFT JOIN tipo_atencion ta ON a.idtipo_atencion = ta.idtipo_atencion ";
    $sql.=" LEFT JOIN captacion_ts cap ON atc.idcaptacion_ts = cap.idcaptacion_ts ";
    $sql.=" LEFT JOIN tiempo_ts t_ref ON referencia_hc.idtiempo_ts = t_ref.idtiempo_ts ";
    
    // AQUÍ ESTÁ LA NUEVA MAGIA DEL FILTRO: Buscar eventos de Ida o de Vuelta dentro del mes
    $sql.=" WHERE (
                (referencia_hc.fecha_registro BETWEEN '$inicio' AND '$finalizacion') 
                OR 
                EXISTS (SELECT 1 FROM diagnostico_egreso de WHERE de.idreferencia_hc = referencia_hc.idreferencia_hc AND de.fecha_registro BETWEEN '$inicio' AND '$finalizacion')
            ) ";
    $sql.=" AND referencia_hc.idestado_referencia = '2' ";
    $sql.=" AND EXISTS (SELECT 1 FROM deriva_referencia_hc der_req WHERE der_req.idreferencia_hc = referencia_hc.idreferencia_hc AND der_req.admitido = 'SI' AND der_req.idestablecimiento_salud_r = referencia_hc.idestablecimiento_receptor) ";
    $sql.=" $filtro_extra ";
    $sql.=" ORDER BY referencia_hc.fecha_registro ASC, referencia_hc.hora_registro ASC "; 
    
    $result = mysqli_query($link,$sql);
    if ($result && $row = mysqli_fetch_array($result)){
        mysqli_field_seek($result,0);           
        while ($field = mysqli_fetch_field($result)){
        } do {
            // --- INICIO: EXTRACCIÓN TIPO DE TELEINTERCONSULTA ---
            $txt_tipo_tele = "S/D";
            $sql_tele = "SELECT idtipo_teleinterconsulta FROM referencia_hc WHERE idreferencia_hc = '{$row[0]}'";
            $res_tele = mysqli_query($link, $sql_tele);
            if ($res_tele && $row_tele = mysqli_fetch_array($res_tele)) {
                switch ($row_tele[0]) {
                    case '1': $txt_tipo_tele = "Telediagnóstico Médico"; break;
                    case '2': $txt_tipo_tele = "Telediscusión"; break;
                    case '3': $txt_tipo_tele = "Teleemergencia"; break;
                    default:  $txt_tipo_tele = "No aplica"; break;
                }
            }
            // --- FIN: EXTRACCIÓN TIPO DE TELEINTERCONSULTA ---

            // --- INICIO: EXTRACCIÓN TELEINTERCONSULTA EFECTIVIZADA ---
            $atencion_sitio = "NO";
            // Consultamos directamente a referencia_hc usando el ID de la referencia actual
            $sql_sitio = "SELECT atencion_sitio FROM referencia_hc WHERE idreferencia_hc = '{$row[0]}'";
            $res_sitio = mysqli_query($link, $sql_sitio);
            if ($res_sitio && $row_sitio = mysqli_fetch_array($res_sitio)) {
                $atencion_sitio = trim(strtoupper($row_sitio[0]));
            }
            
            $txt_efectivizada_fila2 = ($atencion_sitio == 'SI') ? "Atención en Sitio" : "Referencia";
            // --- FIN: EXTRACCIÓN TELEINTERCONSULTA EFECTIVIZADA ---

            // EVALUACIÓN DE AISLAMIENTO: ¿Pertenece la Fila 1 (Referencia) al filtro solicitado?
            $mostrar_fila_1 = true;
            if($iddepartamento != '' && $row[34] != $iddepartamento) { $mostrar_fila_1 = false; }
            if($idmunicipio != '' && $row[35] != $idmunicipio) { $mostrar_fila_1 = false; }
            if($idestablecimiento != '' && $row[36] != $idestablecimiento) { $mostrar_fila_1 = false; }
            if($idusuario_medico != '' && $row[37] != $idusuario_medico) { $mostrar_fila_1 = false; }
            // AISLAMIENTO TEMPORAL: Ocultar Fila 1 si su fecha no pertenece al mes filtrado
            if($row[10] < $inicio || $row[10] > $finalizacion) { $mostrar_fila_1 = false; }

            // =========================================================================
            // CÁLCULOS DEMOGRÁFICOS Y EPIDEMIOLÓGICOS (FASE 1 y FASE 2)
            // =========================================================================
            $edad_calculada = "";
            $indicador_si = ""; 
            $grupo_etareo = "S/D";
            
            if (!empty($row[19]) && $row[19] != '0000-00-00') {
                $fecha_nac_dt = new DateTime($row[19]);
                $fecha_ate_dt = new DateTime($row[10]); 
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
            if (!empty($row[20])) {
                $g_upper = strtoupper($row[20]);
                if ($g_upper == 'MASCULINO' || $g_upper == 'M') { $genero_final = 'M'; }
                else if ($g_upper == 'FEMENINO' || $g_upper == 'F') { $genero_final = 'F'; }
                else { $genero_final = $g_upper; }
            }

            // OBTENER ESTABLECIMIENTO RECEPTOR PARA FILA 1
            $eess_receptor_inicial = "-";
            $sql_er =" SELECT establecimiento_salud FROM establecimiento_salud WHERE idestablecimiento_salud='{$row[14]}' ";
            $res_er = mysqli_query($link,$sql_er);
            if($res_er && $row_er = mysqli_fetch_array($res_er)) { $eess_receptor_inicial = mb_strtoupper($row_er[0]); }

            // OBTENER MEDICO ORIGEN PARA FILA 1
            $medico_origen = "-";
            $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='{$row[12]}' ";
            $res_r = mysqli_query($link,$sql_r);
            if($res_r && $row_r = mysqli_fetch_array($res_r)) { $medico_origen = mb_strtoupper($row_r[0]." ".$row_r[1]." ".$row_r[2]); }

            // OBTENER CARGO ORIGEN PARA FILA 1
            $cargo_origen = "-";
            $sql_c =" SELECT cargo_organigrama.cargo_organigrama FROM usuarios, dato_laboral, cargo_organigrama WHERE dato_laboral.idusuario=usuarios.idusuario AND dato_laboral.idcargo_organigrama=cargo_organigrama.idcargo_organigrama AND usuarios.idusuario='{$row[12]}' ORDER BY dato_laboral.idcargo_organigrama DESC LIMIT 1 ";
            $res_c = mysqli_query($link,$sql_c);
            if($res_c && $row_c = mysqli_fetch_array($res_c)) { $cargo_origen = $row_c[0]; }

            // =========================================================================
            // FORMATEO TIPO ORACIÓN Y TIPO TÍTULO (ESTANDARIZACIÓN)
            // =========================================================================
            $txt_procedencia  = !empty($row[25]) ? ucfirst(mb_strtolower(trim($row[25]))) : "S/D";
            $txt_captacion    = !empty($row[30]) ? ucfirst(mb_strtolower(trim($row[30]))) : "S/D";
            $txt_nacion       = !empty($row[22]) ? ucwords(mb_strtolower(trim($row[22]))) : "S/D";
            $txt_tiempo       = !empty($row[28]) ? ucfirst(mb_strtolower(trim($row[28]))) : "S/D";
            $txt_contexto     = !empty($row[31]) ? ucfirst(mb_strtolower(trim($row[31]))) : "S/D";
            $txt_medio_origen = !empty($row[26]) ? ucwords(mb_strtolower(trim($row[26]))) : "S/D";
            
            $txt_seguimiento = "S/D";
            if($row[23] == '1') { $txt_seguimiento = "Nuevo"; } 
            else if($row[23] == '2') { $txt_seguimiento = "Seguimiento"; } 

            // =========================================================================
            // LECTURA DIRECTA DE DISCAPACIDAD DESDE EL FORMULARIO DE REFERENCIA
            // =========================================================================
            $indicador_discapacidad = "";
            $valor_discapacidad = isset($row[32]) ? strtoupper(trim($row[32])) : "";
            
            if ($valor_discapacidad === 'SI') {
                $indicador_discapacidad = "DISCAPACIDAD";
            }

            // =========================================================================
            // EXTRACCIÓN EXCLUSIVA DE GRUPOS VULNERABLES (Separado de Discapacidad)
            // =========================================================================
            $txt_grupos_vulnerables = "";
            $arr_gv = array();
            $idatencion_origen = $row[33]; 

            if (!empty($idatencion_origen)) {
                $sql_gv = " SELECT gv.idgrupo_vulnerable, gv.grupo_vulnerable FROM atencion_grupo_vulnerable agv INNER JOIN grupo_vulnerable gv ON agv.idgrupo_vulnerable = gv.idgrupo_vulnerable WHERE agv.idatencion_psafci = '$idatencion_origen' AND agv.idgrupo_vulnerable != '5' ";
                $res_gv = mysqli_query($link, $sql_gv);
                
                if ($res_gv && mysqli_num_rows($res_gv) > 0) {
                    while ($row_gv = mysqli_fetch_array($res_gv)) {
                        $arr_gv[] = mb_strtoupper($row_gv[1]);
                    }
                    $txt_grupos_vulnerables = implode(", ", $arr_gv);
                } else {
                    $txt_grupos_vulnerables = "S/D";
                }
            } else {
                $txt_grupos_vulnerables = "S/D";
            }

            // =========================================================================
            // EXTRACCIÓN DE DIAGNÓSTICOS PARA FILA 1 Y CÁLCULO DE GRUPOS PRIORIZADOS (FASE 3)
            // =========================================================================
            $diag_origen = array("", "", "");
            $d_idx = 0;
            
            $ref_ent = false;
            $ref_et = false;
            $ref_sm = false;
            $ref_otros = false;

            $sql_dg = " SELECT p.patologia, p.cie, p.idgrupo_priorizado FROM diagnostico_presuntivo dp INNER JOIN patologia p ON dp.idpatologia=p.idpatologia WHERE dp.idreferencia_hc='{$row[0]}' LIMIT 3";
            $res_dg = mysqli_query($link,$sql_dg);
            if ($res_dg && $row_dg = mysqli_fetch_array($res_dg)){
                do {
                    $diag_origen[$d_idx] = $row_dg[1]." - ".$row_dg[0];
                    $d_idx++;
                    
                    $id_gp = $row_dg[2];
                    if ($id_gp == '1') { $ref_ent = true; }
                    elseif ($id_gp == '2') { $ref_et = true; }
                    elseif ($id_gp == '3') { $ref_sm = true; }
                    else { $ref_otros = true; } 
                    
                } while ($row_dg = mysqli_fetch_array($res_dg));
            }

            $txt_ref_ent = $ref_ent ? "ENT" : "";
            $txt_ref_et = $ref_et ? "ET" : "";
            $txt_ref_sm = $ref_sm ? "SALUD MATERNA" : "";
            $txt_ref_otros = $ref_otros ? "OTROS" : "";

            // =========================================================================
            // IMPRESIÓN DE FILA 1 (Solo si pertenece al filtro original)
            // =========================================================================
            if ($mostrar_fila_1) {
                ?>
                <tr>
                    <td class="c-dato"><?php echo $numero;?></td>
                    <td class="c-dato"><?php $f_l = explode('-',$row[10]); echo isset($f_l[2]) ? $f_l[2].'/'.$f_l[1].'/'.$f_l[0] : ''; ?></td>
                    <td class="c-dato" style="color: #f7a35c;"><b>REFERENCIA</b></td> 
                    <td class="c-dato"><b><?php echo $row[1];?></b></td>
                    <td class="c-dato"><?php echo !empty($row[16]) ? $row[16] : "S/D"; ?></td>
                    <td class="c-izq"><?php echo mb_strtoupper($row[5]);?></td> 
                    <td class="c-izq"><?php echo !empty($row[13]) ? mb_strtoupper($row[13]) : "S/D"; ?></td> 
                    <td class="c-izq"><?php echo mb_strtoupper($row[6]);?></td> 
                    <td class="c-dato"><?php echo !empty($row[17]) ? mb_strtoupper($row[17]) : "S/D"; ?></td> 
                    <td class="c-izq"><?php echo mb_strtoupper($row[7]);?></td> 
                    <td class="c-izq"><?php echo $eess_receptor_inicial; ?></td> 
                    <td class="c-dato"><?php echo !empty($row[29]) ? mb_strtoupper($row[29]) : "S/D"; ?></td>
                    
                    <td class="c-izq"><?php echo $txt_procedencia; ?></td>
                    
                    <td class="c-izq"><?php echo $diag_origen[0]; ?></td>
                    <td class="c-izq"><?php echo $diag_origen[1]; ?></td>
                    <td class="c-izq"><?php echo $diag_origen[2]; ?></td>
                    
                    <td class="c-dato"><?php echo $indicador_discapacidad; ?></td>
                    <td class="c-dato"><?php echo $txt_ref_ent; ?></td>
                    <td class="c-dato"><?php echo $txt_ref_et; ?></td>
                    <td class="c-dato"><?php echo $indicador_si; ?></td>
                    <td class="c-dato"><?php echo $txt_ref_sm; ?></td>
                    <td class="c-dato"><?php echo $txt_ref_otros; ?></td>
                    
                    <td class="c-izq"><?php echo $txt_captacion; ?></td>
                    <td class="c-izq"><?php echo $medico_origen; ?></td>
                    <td class="c-dato"><?php echo $cargo_origen; ?></td>
                    <td class="c-dato"><?php echo $grupo_etareo; ?></td>
                    <td class="c-dato"><?php echo $edad_calculada; ?></td>
                    <td class="c-izq"><?php echo !empty($row[9]) ? mb_strtoupper($row[9]) : "S/D"; ?></td>
                    <td class="c-dato"><?php echo !empty($row[18]) ? $row[18] : "S/D"; ?></td>
                    <td class="c-dato"><?php if(!empty($row[19]) && $row[19] != '0000-00-00'){ $fn = explode('-', $row[19]); echo $fn[2].'/'.$fn[1].'/'.$fn[0]; } ?></td>
                    <td class="c-izq"><?php echo mb_strtoupper($row[2]." ".$row[3]." ".$row[4]);?></td>
                    <td class="c-dato"><?php echo $genero_final; ?></td>
                    <td class="c-dato"><?php echo !empty($row[21]) ? $row[21] : "S/D"; ?></td>
                    
                    <td class="c-izq"><?php echo $txt_nacion; ?></td>
                    
                    <td class="c-izq"><?php echo $txt_grupos_vulnerables; ?></td> 
                    <td class="c-dato"></td> <td class="c-dato"><?php echo $txt_seguimiento; ?></td>
                    <td class="c-dato"><?php echo $txt_tiempo; ?></td>
                    
                    <td class="c-izq"><?php echo $txt_contexto; ?></td>
                    <td class="c-dato"><?php echo $txt_tipo_tele; ?></td>
                    <td class="c-izq"><?php echo $txt_medio_origen; ?></td>
                    
                    <?php
                    $txt_estado = trim(mb_strtoupper($row[8]));
                    // Traductor Interceptor Ortográfico
                    if ($txt_estado === 'CONTRAREFERIDA') {
                        $txt_estado = 'CONTRARREFERIDA';
                    }
                    ?>
                    <td class="c-dato"><b><?php echo $txt_estado; ?></b></td>
                </tr>
                <?php
                $numero++;
            } // Fin mostrar_fila_1

            // =========================================================================
            // FILA 2: CLONACIÓN DE CONTRAREFERENCIA (CAMINO B: EXTRACCIÓN INSTANTÁNEA Y REAL)
            // =========================================================================
            if ($row[15] == '2') {
                // 1. HOSPITAL ESPECIALISTA (Es siempre el Receptor original de la Fila 1)
                $id_eess_especialista = $row[14]; 
                
                $eess_contra_nombre = "-"; 
                $codigo_eess_contra = "S/D"; 
                $dpto_contra = "S/D"; 
                $mun_contra = "S/D"; 
                $nivel_contra = "S/D"; 
                $tipo_eess_contra = "S/D"; 
                $red_contra = "S/D";
                $id_dep_contra = ''; 
                $id_mun_contra = '';

                if (!empty($id_eess_especialista)) {
                    $sql_eess_c = "SELECT es.establecimiento_salud, es.codigo_establecimiento, d.departamento, m.municipio, ne.nivel_establecimiento, te.tipo_establecimiento, rs.red_salud, d.iddepartamento, m.idmunicipio 
                                   FROM establecimiento_salud es 
                                   LEFT JOIN departamento d ON es.iddepartamento = d.iddepartamento 
                                   LEFT JOIN municipios m ON es.idmunicipio = m.idmunicipio 
                                   LEFT JOIN nivel_establecimiento ne ON es.idnivel_establecimiento = ne.idnivel_establecimiento 
                                   LEFT JOIN tipo_establecimiento te ON es.idtipo_establecimiento = te.idtipo_establecimiento 
                                   LEFT JOIN red_salud rs ON es.idred_salud = rs.idred_salud 
                                   WHERE es.idestablecimiento_salud='$id_eess_especialista'";
                    $res_eess_c = mysqli_query($link, $sql_eess_c);
                    if($res_eess_c && $row_eess_c = mysqli_fetch_array($res_eess_c)) {
                        $eess_contra_nombre = mb_strtoupper($row_eess_c[0]); 
                        $codigo_eess_contra = !empty($row_eess_c[1]) ? $row_eess_c[1] : "S/D";
                        $dpto_contra = !empty($row_eess_c[2]) ? mb_strtoupper($row_eess_c[2]) : "S/D"; 
                        $mun_contra = !empty($row_eess_c[3]) ? mb_strtoupper($row_eess_c[3]) : "S/D"; 
                        $nivel_contra = !empty($row_eess_c[4]) ? mb_strtoupper($row_eess_c[4]) : "S/D"; 
                        $tipo_eess_contra = !empty($row_eess_c[5]) ? mb_strtoupper($row_eess_c[5]) : "S/D"; 
                        $red_contra = !empty($row_eess_c[6]) ? mb_strtoupper($row_eess_c[6]) : "S/D"; 
                        $id_dep_contra = $row_eess_c[7];
                        $id_mun_contra = $row_eess_c[8];
                    }
                }

                // 2. MÉDICO ESPECIALISTA Y FECHA (Extracción Inmediata desde Diagnóstico de Egreso)
                $id_usuario_especialista = "";
                $f_reg_contra = "S/D";
                $f_reg_contra_cruda = ""; // <-- ¡Nueva variable para auditoría temporal!
                $medico_contra_nombre = "-";
                $cargo_contra = "-";

                $sql_eg = "SELECT idusuario, fecha_registro FROM diagnostico_egreso WHERE idreferencia_hc='{$row[0]}' ORDER BY iddiagnostico_egreso DESC LIMIT 1";
                $res_eg = mysqli_query($link, $sql_eg);
                if ($res_eg && $row_eg = mysqli_fetch_array($res_eg)) {
                    $id_usuario_especialista = $row_eg['idusuario'];
                    if(!empty($row_eg['fecha_registro']) && $row_eg['fecha_registro'] != '0000-00-00') {
                        $f_reg_contra_cruda = $row_eg['fecha_registro'];
                        $fr = explode('-', $row_eg['fecha_registro']);
                        $f_reg_contra = isset($fr[2]) ? $fr[2].'/'.$fr[1].'/'.$fr[0] : '';
                    }
                }

                // --- SISTEMA DE RESCATE (FALLBACK) ---
                // Si no hay diagnóstico de egreso, la fecha y el médico están vacíos y la fila se ocultará.
                // Rescatamos la fecha de retorno y al especialista desde el historial de derivaciones.
                if (empty($f_reg_contra_cruda) || empty($id_usuario_especialista)) {
                    $sql_fb = "SELECT idusuario_o, fecha_deriva FROM deriva_referencia_hc WHERE idreferencia_hc='{$row[0]}' AND idestablecimiento_salud_o='{$id_eess_especialista}' ORDER BY idderiva_referencia_hc DESC LIMIT 1";
                    $res_fb = mysqli_query($link, $sql_fb);
                    if ($res_fb && $row_fb = mysqli_fetch_array($res_fb)) {
                        $id_usuario_especialista = !empty($row_fb['idusuario_o']) ? $row_fb['idusuario_o'] : $id_usuario_especialista;
                        if(!empty($row_fb['fecha_deriva']) && $row_fb['fecha_deriva'] != '0000-00-00') {
                            $f_reg_contra_cruda = $row_fb['fecha_deriva'];
                            $fr = explode('-', $row_fb['fecha_deriva']);
                            $f_reg_contra = isset($fr[2]) ? $fr[2].'/'.$fr[1].'/'.$fr[0] : '';
                        }
                    }
                }
                // -------------------------------------

                if (!empty($id_usuario_especialista)) {
                    $sql_med_c = "SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios INNER JOIN nombre ON usuarios.idnombre=nombre.idnombre WHERE usuarios.idusuario='$id_usuario_especialista'";
                    $res_med_c = mysqli_query($link, $sql_med_c);
                    if($res_med_c && $row_med_c = mysqli_fetch_array($res_med_c)) { 
                        $medico_contra_nombre = mb_strtoupper($row_med_c[0]." ".$row_med_c[1]." ".$row_med_c[2]); 
                    }

                    $sql_car_c = "SELECT co.cargo_organigrama FROM dato_laboral dl INNER JOIN cargo_organigrama co ON dl.idcargo_organigrama=co.idcargo_organigrama WHERE dl.idusuario='$id_usuario_especialista' ORDER BY dl.idcargo_organigrama DESC LIMIT 1";
                    $res_car_c = mysqli_query($link, $sql_car_c);
                    if($res_car_c && $row_car_c = mysqli_fetch_array($res_car_c)) { 
                        $cargo_contra = $row_car_c[0]; 
                    }
                }

                // 3. MEDIO DE COMUNICACIÓN (Heredado de la Admisión original del Especialista)
                $medio_comunicacion_contra = $txt_medio_origen; 

                // EVALUACIÓN DE AISLAMIENTO: ¿Pertenece la Fila 2 (Contrarreferencia) al filtro solicitado?
                $mostrar_fila_2 = true;
                if($iddepartamento != '' && $id_dep_contra != '' && $id_dep_contra != $iddepartamento) { $mostrar_fila_2 = false; }
                if($idmunicipio != '' && $id_mun_contra != '' && $id_mun_contra != $idmunicipio) { $mostrar_fila_2 = false; }
                if($idestablecimiento != '' && $id_eess_especialista != '' && $id_eess_especialista != $idestablecimiento) { $mostrar_fila_2 = false; }
                if($idusuario_medico != '' && $id_usuario_especialista != '' && $id_usuario_especialista != $idusuario_medico) { $mostrar_fila_2 = false; }
                // AISLAMIENTO TEMPORAL: Ocultar Fila 2 si su fecha de respuesta no pertenece al mes filtrado
                if(empty($f_reg_contra_cruda) || $f_reg_contra_cruda < $inicio || $f_reg_contra_cruda > $finalizacion) { $mostrar_fila_2 = false; }

                if ($mostrar_fila_2) {
                    // =========================================================================
                    // EXTRACCIÓN DE DIAGNÓSTICOS DE EGRESO Y CÁLCULO DE GRUPOS PRIORIZADOS (FASE 3 - VUELTA)
                    // =========================================================================
                    $diag_contra = array("", "", "");
                    $d_idx2 = 0;
                    
                    $cref_ent = false;
                    $cref_et = false;
                    $cref_sm = false;
                    $cref_otros = false;

                    $sql_dg2 = " SELECT p.patologia, p.cie, p.idgrupo_priorizado FROM diagnostico_egreso de INNER JOIN patologia p ON de.idpatologia=p.idpatologia WHERE de.idreferencia_hc='{$row[0]}' LIMIT 3";
                    $res_dg2 = mysqli_query($link,$sql_dg2);
                    if ($res_dg2 && $row_dg2 = mysqli_fetch_array($res_dg2)){
                        do {
                            $diag_contra[$d_idx2] = $row_dg2[1]." - ".$row_dg2[0];
                            $d_idx2++;
                            
                            $id_gp_cref = $row_dg2[2];
                            if ($id_gp_cref == '1') { $cref_ent = true; }
       