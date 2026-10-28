<?php
include("../cabf.php");
include("../inc.config.php");

// Blindaje de sesiones para evitar errores en menu.php y top_bar.php
$idusuario_ss = $_SESSION['idusuario_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$gestion      = date("Y");

// Filtros compartidos entre pestañas, navegación en píldora y estilos del diseño
include("inc_telemedicina.php");

// Caché de 10 minutos: al volver a esta pestaña con los mismos filtros aparece al instante ("Actualizar" la recalcula)
tm_cache_pantalla();

// =========================================================================
// FASE 1: PUENTE DE DATOS EN MEMORIA (CATÁLOGOS JSON)
// =========================================================================
// Catálogos de los filtros, recortados al alcance del usuario (inc_telemedicina.php)
list($deptos, $munis, $eess, $medicos) = tm_catalogos($link);

// Captura de variables iniciales
$g_dep = isset($_GET['iddepartamento']) && $_GET['iddepartamento'] != '' ? $_GET['iddepartamento'] : 'null';
$g_mun = isset($_GET['idmunicipio']) && $_GET['idmunicipio'] != '' ? $_GET['idmunicipio'] : 'null';
$g_est = isset($_GET['idestablecimiento']) && $_GET['idestablecimiento'] != '' ? $_GET['idestablecimiento'] : 'null';
$g_med = isset($_GET['idusuario_medico']) && $_GET['idusuario_medico'] != '' ? $_GET['idusuario_medico'] : 'null';

// Literales seguros para JS (null o string JSON)
$js_dep = $g_dep != 'null' ? json_encode((string)$g_dep) : 'null';
$js_mun = $g_mun != 'null' ? json_encode((string)$g_mun) : 'null';
$js_est = $g_est != 'null' ? json_encode((string)$g_est) : 'null';
$js_med = $g_med != 'null' ? json_encode((string)$g_med) : 'null';

// =========================================================================
// FASE 2: FECHAS (validadas) Y ACUMULADOR DE FILTROS EN CASCADA
// =========================================================================
$es_fecha = function ($f) { return is_string($f) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $f) && strtotime($f) !== false; };
$inicio       = (isset($_GET['fecha_inicio']) && $es_fecha($_GET['fecha_inicio'])) ? $_GET['fecha_inicio'] : date('Y-m-01');
$finalizacion = (isset($_GET['fecha_fin']) && $es_fecha($_GET['fecha_fin'])) ? $_GET['fecha_fin'] : date('Y-m-d');

// Vista DESTINO: los filtros se aplican al hospital receptor (especialista), no al origen
$filtro_depto = "";
if (isset($_GET['iddepartamento']) && $_GET['iddepartamento'] != '') {
    $filtro_depto .= " AND es_receptor.iddepartamento = '" . mysqli_real_escape_string($link, $_GET['iddepartamento']) . "'";
}
if (isset($_GET['idmunicipio']) && $_GET['idmunicipio'] != '') {
    $filtro_depto .= " AND es_receptor.idmunicipio = '" . mysqli_real_escape_string($link, $_GET['idmunicipio']) . "'";
}
if (isset($_GET['idestablecimiento']) && $_GET['idestablecimiento'] != '') {
    $filtro_depto .= " AND r.idestablecimiento_receptor = '" . mysqli_real_escape_string($link, $_GET['idestablecimiento']) . "'";
}
if (isset($_GET['idusuario_medico']) && $_GET['idusuario_medico'] != '') {
    // El especialista es quien admitió el caso (idusuario_r de su fila de deriva) y no es el mismo que lo generó
    $id_med_seguro = mysqli_real_escape_string($link, $_GET['idusuario_medico']);
    $filtro_depto .= " AND d.idusuario_r = '$id_med_seguro' AND r.idusuario != '$id_med_seguro'";
}

// =========================================================================
// FASE 3: CLASIFICACIÓN ÚNICA DE CADA TELEINTERCONSULTA (en orden de prioridad)
//   1. Rechazadas  = calificación NO / NO / NO del especialista (prevalece aunque luego tenga contrarreferencia)
//   2. Efectivizadas = Estado 2 (contrarreferidas)
//   3. En valoración = admitidas por el especialista, aún sin respuesta
//   4. Por admitir   = todavía en la bandeja del especialista
// Solo se evalúa la fila de deriva del especialista (la primera, MIN(idderiva)); la fila de retorno
// al origen que crea la contrarreferencia nace con admitido='NO' y NO significa rechazo.
// =========================================================================
$sql_estado_tic = "CASE
        WHEN UPPER(TRIM(IFNULL(r.adecuada,''))) = 'NO' AND UPPER(TRIM(IFNULL(r.justificada,''))) = 'NO' AND UPPER(TRIM(IFNULL(r.oportuna,''))) = 'NO' THEN 'rechazadas'
        WHEN r.idestado_referencia = '2' THEN 'efectivizadas'
        WHEN d.admitido = 'SI' THEN 'en_valoracion'
        ELSE 'por_admitir'
    END";
$sql_from_tic = "FROM referencia_hc r
    LEFT JOIN deriva_referencia_hc d ON d.idderiva_referencia_hc = (
        SELECT MIN(d2.idderiva_referencia_hc) FROM deriva_referencia_hc d2 WHERE d2.idreferencia_hc = r.idreferencia_hc
    )
    LEFT JOIN establecimiento_salud es_receptor ON es_receptor.idestablecimiento_salud = r.idestablecimiento_receptor";
// Fecha de cada caso en esta bandeja: las efectivizadas cuentan el día en que se RESPONDIERON (como la Central);
// las demás (pendientes y rechazadas) el día en que se generó la referencia
$sql_fecha_tic = "(CASE WHEN ($sql_estado_tic) = 'efectivizadas' THEN " . tm_sql_fecha_respuesta() . " ELSE r.fecha_registro END)";

$contar_estados = function ($ini, $fin) use ($link, $sql_estado_tic, $sql_from_tic, $sql_fecha_tic, $filtro_depto) {
    $c = ['por_admitir' => 0, 'en_valoracion' => 0, 'efectivizadas' => 0, 'rechazadas' => 0];
    $res = mysqli_query($link, "SELECT $sql_estado_tic AS estado, COUNT(*) AS total $sql_from_tic WHERE $sql_fecha_tic BETWEEN '$ini' AND '$fin' $filtro_depto GROUP BY estado");
    if ($res) { while ($row = mysqli_fetch_assoc($res)) { $c[$row['estado']] = (int)$row['total']; } }
    return $c;
};

// Periodo actual
$kpi = $contar_estados($inicio, $finalizacion);
$total_generadas     = $kpi['por_admitir'];
$total_en_valoracion = $kpi['en_valoracion'];
$total_efectivizadas = $kpi['efectivizadas'];
$total_rechazadas    = $kpi['rechazadas'];
$total_absoluto      = array_sum($kpi);
$tasa_efectividad    = ($total_absoluto > 0) ? round(($total_efectivizadas / $total_absoluto) * 100, 1) : 0;

// Periodo de comparación del indicador ▲▼: mes anterior o gestión anterior (inc_telemedicina.php)
$dt_ini = new DateTime($inicio);
$dt_fin = new DateTime($finalizacion);
$dias_periodo = max(1, (int)$dt_ini->diff($dt_fin)->format('%r%a') + 1);
list($dt_prev_ini, $dt_prev_fin) = tm_periodo_anterior($dt_ini, $dt_fin); // mismos días del mes anterior, o mismas fechas de la gestión anterior
$kpi_prev = $contar_estados($dt_prev_ini->format('Y-m-d'), $dt_prev_fin->format('Y-m-d'));
$total_prev = array_sum($kpi_prev);
$tasa_prev  = ($total_prev > 0) ? round(($kpi_prev['efectivizadas'] / $total_prev) * 100, 1) : 0;

// Tendencia (sparklines): por día, o por mes si el rango supera 92 días
$agrupar_mes = $dias_periodo > 92;
$spark_etiquetas = [];
$spark = ['total' => [], 'por_admitir' => [], 'en_valoracion' => [], 'efectivizadas' => [], 'rechazadas' => []];
$spark_idx = [];
if ($dt_fin >= $dt_ini) {
    $p_ini = $agrupar_mes ? new DateTime($dt_ini->format('Y-m-01')) : clone $dt_ini;
    $p_fin = clone $dt_fin; $p_fin->modify('+1 day');
    $periodo_spark = new DatePeriod($p_ini, new DateInterval($agrupar_mes ? 'P1M' : 'P1D'), $p_fin);
    foreach ($periodo_spark as $f) {
        $clave = $f->format($agrupar_mes ? 'Y-m' : 'Y-m-d');
        $spark_idx[$clave] = count($spark_etiquetas);
        $spark_etiquetas[] = $f->format($agrupar_mes ? 'm/Y' : 'd/m');
        foreach ($spark as $k => $v) { $spark[$k][] = 0; }
    }
}
$sql_clave_spark = $agrupar_mes ? "DATE_FORMAT($sql_fecha_tic, '%Y-%m')" : "DATE_FORMAT($sql_fecha_tic, '%Y-%m-%d')";
$res_spark = mysqli_query($link, "SELECT $sql_clave_spark AS clave, $sql_estado_tic AS estado, COUNT(*) AS total $sql_from_tic WHERE $sql_fecha_tic BETWEEN '$inicio' AND '$finalizacion' $filtro_depto GROUP BY clave, estado");
if ($res_spark) {
    while ($row = mysqli_fetch_assoc($res_spark)) {
        if (isset($spark_idx[$row['clave']])) {
            $i = $spark_idx[$row['clave']];
            $spark[$row['estado']][$i] += (int)$row['total'];
            $spark['total'][$i] += (int)$row['total'];
        }
    }
}

// =========================================================================
// FASE 3B: PENDIENTES POR HOSPITAL, ANTIGÜEDAD Y TIEMPO DE RESPUESTA
// Envío = fecha/hora de la fila de deriva del especialista (respaldo: registro de la referencia)
// Respuesta = fila de deriva siguiente, que se crea al guardar la contrarreferencia
// =========================================================================
$sql_envio_tic = "COALESCE(TIMESTAMP(d.fecha_deriva, IFNULL(NULLIF(d.hora_deriva, ''), '00:00')), TIMESTAMP(r.fecha_registro, IFNULL(NULLIF(r.hora_registro, ''), '00:00')))";
$sql_pend_base = "SELECT COALESCE(d.idestablecimiento_salud_r, r.idestablecimiento_receptor) AS id_rec, $sql_estado_tic AS estado,
        TIMESTAMPDIFF(HOUR, $sql_envio_tic, NOW()) AS horas
    $sql_from_tic
    WHERE $sql_fecha_tic BETWEEN '$inicio' AND '$finalizacion' $filtro_depto";
$sql_buckets = "SUM(x.horas < 24) AS b0, SUM(x.horas >= 24 AND x.horas < 96) AS b1, SUM(x.horas >= 96 AND x.horas < 192) AS b2, SUM(x.horas >= 192) AS b3";

// Rangos de antigüedad / tiempo (semáforo)
$rangos_tiempo = [
    ['< 1 día', '#1cc88a'],
    ['1–3 días', '#f6c23e'],
    ['4–7 días', '#fd7e14'],
    ['> 7 días', '#e74a3b'],
];

// Pendientes por hospital receptor (por admitir + en valoración)
$pend_hosp = [];
$res_ph = mysqli_query($link, "
    SELECT x.id_rec, es.establecimiento_salud, dp.departamento,
        SUM(x.estado = 'por_admitir') AS pa, SUM(x.estado = 'en_valoracion') AS ev, MAX(x.horas) AS max_h, $sql_buckets
    FROM ($sql_pend_base) x
    LEFT JOIN establecimiento_salud es ON es.idestablecimiento_salud = x.id_rec
    LEFT JOIN departamento dp ON dp.iddepartamento = es.iddepartamento
    WHERE x.estado IN ('por_admitir', 'en_valoracion')
    GROUP BY x.id_rec, es.establecimiento_salud, dp.departamento
    ORDER BY (SUM(x.estado = 'por_admitir') + SUM(x.estado = 'en_valoracion')) DESC, MAX(x.horas) DESC
");
if ($res_ph) {
    while ($row = mysqli_fetch_assoc($res_ph)) {
        $pend_hosp[] = [
            'id'     => $row['id_rec'],
            'nombre' => $row['establecimiento_salud'] ? mb_strtoupper(trim($row['establecimiento_salud'])) : 'ESTABLECIMIENTO NO REGISTRADO',
            'depto'  => $row['departamento'] ? mb_convert_case(mb_strtolower(trim($row['departamento'])), MB_CASE_TITLE) : '',
            'pa' => (int)$row['pa'], 'ev' => (int)$row['ev'], 'max_h' => $row['max_h'] === null ? null : (int)$row['max_h'],
            'b' => [(int)$row['b0'], (int)$row['b1'], (int)$row['b2'], (int)$row['b3']],
        ];
    }
}
$pend_total = 0; foreach ($pend_hosp as $ph) { $pend_total += $ph['pa'] + $ph['ev']; }
$pend_top = array_slice($pend_hosp, 0, 10);
$pend_resto_hosp = count($pend_hosp) - count($pend_top);
$pend_resto_casos = 0; foreach (array_slice($pend_hosp, 10) as $ph) { $pend_resto_casos += $ph['pa'] + $ph['ev']; }

// Antigüedad de los pendientes (desglose por estado)
$antig = ['por_admitir' => [0, 0, 0, 0], 'en_valoracion' => [0, 0, 0, 0]];
$res_ant = mysqli_query($link, "SELECT x.estado, $sql_buckets FROM ($sql_pend_base) x WHERE x.estado IN ('por_admitir', 'en_valoracion') GROUP BY x.estado");
if ($res_ant) {
    while ($row = mysqli_fetch_assoc($res_ant)) { $antig[$row['estado']] = [(int)$row['b0'], (int)$row['b1'], (int)$row['b2'], (int)$row['b3']]; }
}
$antig_total = []; for ($i = 0; $i < 4; $i++) { $antig_total[$i] = $antig['por_admitir'][$i] + $antig['en_valoracion'][$i]; }
$antig_max = max(1, max($antig_total));

// Tiempo de respuesta (solo efectivizadas): envío -> admisión -> contrarreferencia
$t_total = []; $t_admitir = []; $t_responder = [];
$res_tr = mysqli_query($link, "
    SELECT TIMESTAMPDIFF(MINUTE, $sql_envio_tic, TIMESTAMP(db.fecha_deriva, IFNULL(NULLIF(db.hora_deriva, ''), '00:00'))) AS min_total,
           TIMESTAMPDIFF(MINUTE, $sql_envio_tic, TIMESTAMP(d.fecha_admision, IFNULL(NULLIF(d.hora_admision, ''), '00:00'))) AS min_admitir
    $sql_from_tic
    LEFT JOIN deriva_referencia_hc db ON db.idderiva_referencia_hc = (
        SELECT MIN(d3.idderiva_referencia_hc) FROM deriva_referencia_hc d3 WHERE d3.idreferencia_hc = r.idreferencia_hc AND d3.idderiva_referencia_hc > d.idderiva_referencia_hc
    )
    WHERE $sql_fecha_tic BETWEEN '$inicio' AND '$finalizacion' $filtro_depto AND ($sql_estado_tic) = 'efectivizadas'
");
if ($res_tr) {
    while ($row = mysqli_fetch_assoc($res_tr)) {
        if ($row['min_total'] === null || (int)$row['min_total'] < 0) { continue; }
        $total_h = (int)$row['min_total'] / 60;
        $t_total[] = $total_h;
        if ($row['min_admitir'] !== null && (int)$row['min_admitir'] >= 0 && (int)$row['min_admitir'] <= (int)$row['min_total']) {
            $t_admitir[] = (int)$row['min_admitir'] / 60;
            $t_responder[] = ((int)$row['min_total'] - (int)$row['min_admitir']) / 60;
        }
    }
}
$mediana = function ($v) { if (!$v) { return null; } sort($v); $n = count($v); return $n % 2 ? $v[($n - 1) / 2] : ($v[$n / 2 - 1] + $v[$n / 2]) / 2; };
$promedio = function ($v) { return $v ? array_sum($v) / count($v) : null; };
$fmt_duracion = function ($horas) {
    if ($horas === null) { return '—'; }
    if ($horas < 1) { return max(1, round($horas * 60)) . ' min'; }
    if ($horas < 24) { return round($horas, 1) . ' h'; }
    $dias = round($horas / 24, 1);
    return $dias . ($dias == 1 ? ' día' : ' días');
};
$resp_hist = [0, 0, 0, 0];
foreach ($t_total as $hh) { $resp_hist[$hh < 24 ? 0 : ($hh < 96 ? 1 : ($hh < 192 ? 2 : 3))]++; }
$resp_hist_max = max(1, max($resp_hist));

// =========================================================================
// FASE 4: MOTOR GEO-ESPACIAL INVERTIDO (Hospital consultor -> Red emisora)
// Solo respuestas efectivizadas; una fila por referencia (sin duplicar por filas de deriva)
// =========================================================================
$sql_mapa = "
    SELECT
        d_consultor.departamento as depto_origen,
        d_emisor.departamento as depto_destino,
        COUNT(r.idreferencia_hc) as volumen
    $sql_from_tic
    INNER JOIN departamento d_consultor ON es_receptor.iddepartamento = d_consultor.iddepartamento
    INNER JOIN departamento d_emisor ON r.iddepartamento = d_emisor.iddepartamento
    WHERE $sql_fecha_tic BETWEEN '$inicio' AND '$finalizacion' $filtro_depto AND ($sql_estado_tic) = 'efectivizadas'
    GROUP BY d_consultor.departamento, d_emisor.departamento
";
$res_mapa = mysqli_query($link, $sql_mapa);

$datos_flujo_mapa = [];
if ($res_mapa) {
    while ($rm = mysqli_fetch_assoc($res_mapa)) {
        // Limpieza estricta de tildes para sincronizar con el mapa JS
        $origen = str_replace(['Á','É','Í','Ó','Ú'], ['A','E','I','O','U'], mb_strtoupper(trim($rm['depto_origen'])));
        $destino = str_replace(['Á','É','Í','Ó','Ú'], ['A','E','I','O','U'], mb_strtoupper(trim($rm['depto_destino'])));
        $datos_flujo_mapa[] = ['origen' => $origen, 'destino' => $destino, 'peso' => (int)$rm['volumen']];
    }
}

// Top 3 rutas entre departamentos
$rutas_top = array_values(array_filter($datos_flujo_mapa, function ($f) { return $f['origen'] !== $f['destino']; }));
usort($rutas_top, function ($a, $b) { return $b['peso'] - $a['peso']; });
$rutas_top = array_slice($rutas_top, 0, 3);

// =========================================================================
// FASE 5: PERFIL EPIDEMIOLÓGICO Y DE ATENCIÓN
// =========================================================================
// Top 10 Diagnósticos confirmados por el especialista (diagnóstico de egreso de la contrarreferencia)
$sql_top_destino = "
    SELECT p.patologia, COUNT(de.iddiagnostico_egreso) as total
    $sql_from_tic
    INNER JOIN diagnostico_egreso de ON de.idreferencia_hc = r.idreferencia_hc
    INNER JOIN patologia p ON de.idpatologia = p.idpatologia
    WHERE $sql_fecha_tic BETWEEN '$inicio' AND '$finalizacion' $filtro_depto
    GROUP BY p.patologia
    ORDER BY total DESC LIMIT 10
";
$res_top_destino = mysqli_query($link, $sql_top_destino);
$cat_destino = []; $data_destino = [];
if($res_top_destino){
    while($row = mysqli_fetch_assoc($res_top_destino)){
        $cat_destino[] = mb_strtoupper(trim($row['patologia']));
        $data_destino[] = (int)$row['total'];
    }
}

// Resolución y Modalidad (Solo Efectivizadas, una fila por referencia)
// CORRECCIÓN BLINDADA: Soporta datos heredados ('SI'/'NO') y datos nuevos ('1'/'2')
$sql_resolucion = "
    SELECT
        SUM(CASE WHEN r.atencion_sitio IN ('1', 'SI') THEN 1 ELSE 0 END) as en_sitio,
        SUM(CASE WHEN r.atencion_sitio IN ('2', 'NO') THEN 1 ELSE 0 END) as referencia,
        SUM(CASE WHEN r.idtiempo_ts = '1' THEN 1 ELSE 0 END) as tiempo_real,
        SUM(CASE WHEN r.idtiempo_ts = '2' THEN 1 ELSE 0 END) as tiempo_diferido
    $sql_from_tic
    WHERE $sql_fecha_tic BETWEEN '$inicio' AND '$finalizacion' $filtro_depto AND ($sql_estado_tic) = 'efectivizadas'
";
$res_res = mysqli_query($link, $sql_resolucion);
$tot_en_sitio = 0; $tot_referencia = 0; $tot_tiempo_real = 0; $tot_tiempo_diferido = 0;
if ($res_res && $row_res = mysqli_fetch_assoc($res_res)) {
    $tot_en_sitio = (int)$row_res['en_sitio'];
    $tot_referencia = (int)$row_res['referencia'];
    $tot_tiempo_real = (int)$row_res['tiempo_real'];
    $tot_tiempo_diferido = (int)$row_res['tiempo_diferido'];
}

// Nuevo/Seguimiento y Tipo de Teleinterconsulta
$sql_extra = "
    SELECT
        SUM(CASE WHEN a.idrepeticion = '1' THEN 1 ELSE 0 END) as nuevo,
        SUM(CASE WHEN a.idrepeticion = '2' THEN 1 ELSE 0 END) as seguimiento,
        SUM(CASE WHEN r.idtipo_teleinterconsulta = '1' THEN 1 ELSE 0 END) as t_diag,
        SUM(CASE WHEN r.idtipo_teleinterconsulta = '2' THEN 1 ELSE 0 END) as t_disc,
        SUM(CASE WHEN r.idtipo_teleinterconsulta = '3' THEN 1 ELSE 0 END) as t_emer
    $sql_from_tic
    LEFT JOIN atencion_psafci a ON r.idatencion_psafci = a.idatencion_psafci
    WHERE $sql_fecha_tic BETWEEN '$inicio' AND '$finalizacion' $filtro_depto
";
$res_ex = mysqli_query($link, $sql_extra);
$tot_nuevo = 0; $tot_seguimiento = 0; $tot_diag = 0; $tot_disc = 0; $tot_emer = 0;
if ($res_ex && $row_ex = mysqli_fetch_assoc($res_ex)) {
    $tot_nuevo = (int)$row_ex['nuevo'];
    $tot_seguimiento = (int)$row_ex['seguimiento'];
    $tot_diag = (int)$row_ex['t_diag'];
    $tot_disc = (int)$row_ex['t_disc'];
    $tot_emer = (int)$row_ex['t_emer'];
}

// Ranking de Especialidades Solicitadas
$sql_top_esp = "
    SELECT e.especialidad_medica, COUNT(r.idreferencia_hc) as total
    $sql_from_tic
    INNER JOIN especialidad_medica e ON r.idespecialidad_medica = e.idespecialidad_medica
    WHERE $sql_fecha_tic BETWEEN '$inicio' AND '$finalizacion' $filtro_depto
    GROUP BY e.especialidad_medica
    ORDER BY total DESC LIMIT 10
";
$res_top_esp = mysqli_query($link, $sql_top_esp);
$cat_esp = []; $data_esp = [];
if($res_top_esp){
    while($row_esp = mysqli_fetch_assoc($res_top_esp)){
        $cat_esp[] = mb_strtoupper(trim($row_esp['especialidad_medica']));
        $data_esp[] = (int)$row_esp['total'];
    }
}

// Bloques del panel "Perfil de atención" (barras de proporción)
$perfil_bloques = [
    ['titulo' => 'Resolución', 'icono' => 'fa-stethoscope', 'nota' => 'Casos efectivizados', 'items' => [
        ['Atención en sitio', $tot_en_sitio, '#36b9cc'], ['Requiere referencia', $tot_referencia, '#e74a3b']]],
    ['titulo' => 'Modalidad', 'icono' => 'fa-network-wired', 'nota' => 'Casos efectivizados', 'items' => [
        ['Tiempo real', $tot_tiempo_real, '#4e73df'], ['Tiempo diferido', $tot_tiempo_diferido, '#858796']]],
    ['titulo' => 'Tipo de paciente', 'icono' => 'fa-user-plus', 'nota' => 'Todos los recibidos', 'items' => [
        ['Nuevo', $tot_nuevo, '#1cc88a'], ['Seguimiento', $tot_seguimiento, '#f6c23e']]],
    ['titulo' => 'Tipo de teleinterconsulta', 'icono' => 'fa-laptop-medical', 'nota' => 'Todos los recibidos', 'items' => [
        ['Telediagnóstico', $tot_diag, '#4e73df'], ['Telediscusión', $tot_disc, '#36b9cc'], ['Teleemergencia', $tot_emer, '#e74a3b']]],
];

// =========================================================================
// FASE 6: PRESENTACIÓN (textos, chips de filtros, variaciones)
// =========================================================================
$meses_es = ['', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
$fecha_larga = function (DateTime $f) use ($meses_es) { return (int)$f->format('j') . ' de ' . $meses_es[(int)$f->format('n')] . ' de ' . $f->format('Y'); };
$texto_periodo = 'Del ' . $fecha_larga($dt_ini) . ' al ' . $fecha_larga($dt_fin);
$ahora = new DateTime('now', new DateTimeZone('America/La_Paz'));

// Chips de filtros activos (cada ✕ quita el filtro y sus dependientes en cascada)
$buscar_nombre = function ($lista, $id) { foreach ($lista as $it) { if ((string)$it['id'] === (string)$id) { return $it['nombre']; } } return $id; };
$url_sin = function ($claves) { $q = $_GET; foreach ($claves as $c) { unset($q[$c]); } return 'teleinterconsultas_destino.php' . (count($q) ? '?' . http_build_query($q) : ''); };
$chips = [];
if ($g_dep != 'null') { $chips[] = ['fa-map', $buscar_nombre($deptos, $g_dep), (tm_es_fijo('iddepartamento') ? '' : $url_sin(['iddepartamento', 'idmunicipio', 'idestablecimiento']))]; }
if ($g_mun != 'null') { $chips[] = ['fa-map-marker-alt', $buscar_nombre($munis, $g_mun), (tm_es_fijo('idmunicipio') ? '' : $url_sin(['idmunicipio', 'idestablecimiento']))]; }
if ($g_est != 'null') { $chips[] = ['fa-hospital', $buscar_nombre($eess, $g_est), $url_sin(['idestablecimiento'])]; }
if ($g_med != 'null') { $chips[] = ['fa-user-md', $buscar_nombre($medicos, $g_med), $url_sin(['idusuario_medico'])]; }

// Variación contra el mes o la gestión anterior. $sentido: 1 = subir es bueno, -1 = subir es malo, 0 = neutral
$variacion = function ($actual, $anterior, $sentido) {
    if ($anterior == 0 && $actual == 0) { return ['—', 'neutro', 'Sin cambios vs ' . tm_etq_anterior(true)]; }
    if ($anterior == 0) { return ['Nuevo', $sentido >= 0 ? 'bueno' : 'malo', 'Sin registros en ' . tm_etq_anterior(true, true)]; }
    $pct = round((($actual - $anterior) / $anterior) * 100);
    if ($pct == 0) { return ['0%', 'neutro', 'Igual que ' . tm_etq_anterior(true, true)]; }
    $clase = $sentido == 0 ? 'neutro' : ((($pct > 0) == ($sentido > 0)) ? 'bueno' : 'malo');
    return [($pct > 0 ? '▲ ' : '▼ ') . abs($pct) . '%', $clase, ucfirst(tm_etq_anterior(true)) . ': ' . number_format($anterior)];
};

$kpi_tarjetas = [
    ['clave' => 'total', 'titulo' => 'Total recibidas', 'valor' => $total_absoluto, 'icono' => 'fa-layer-group', 'color' => '#4e73df',
     'ayuda' => 'Todas las teleinterconsultas que llegaron a los hospitales especialistas en el periodo', 'var' => $variacion($total_absoluto, $total_prev, 0)],
    ['clave' => 'por_admitir', 'titulo' => 'Por admitir', 'valor' => $total_generadas, 'icono' => 'fa-inbox', 'color' => '#f6c23e',
     'ayuda' => 'En la bandeja del especialista: aún no fueron abiertas ni aceptadas', 'var' => $variacion($total_generadas, $kpi_prev['por_admitir'], -1)],
    ['clave' => 'en_valoracion', 'titulo' => 'Por responder', 'valor' => $total_en_valoracion, 'icono' => 'fa-user-clock', 'color' => '#36b9cc',
     'ayuda' => 'Admitidas por el especialista, todavía sin contrarreferencia', 'var' => $variacion($total_en_valoracion, $kpi_prev['en_valoracion'], -1)],
    ['clave' => 'efectivizadas', 'titulo' => 'Efectivizadas', 'valor' => $total_efectivizadas, 'icono' => 'fa-check-double', 'color' => '#1cc88a',
     'ayuda' => 'Admitidas y respondidas con contrarreferencia', 'var' => $variacion($total_efectivizadas, $kpi_prev['efectivizadas'], 1)],
    ['clave' => 'rechazadas', 'titulo' => 'Rechazadas', 'valor' => $total_rechazadas, 'icono' => 'fa-ban', 'color' => '#e74a3b',
     'ayuda' => 'Calificadas NO / NO / NO por el especialista (incluye respuesta)', 'var' => $variacion($total_rechazadas, $kpi_prev['rechazadas'], -1)],
];
$dif_tasa = round($tasa_efectividad - $tasa_prev, 1);
$circ_anillo = 2 * M_PI * 26;
$offset_anillo = round($circ_anillo * (1 - min(100, $tasa_efectividad) / 100), 2);

$h = function ($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); };

// =========================================================================
// PRESENTACIÓN: datos derivados solo para la vista (no cambian las reglas de arriba)
// =========================================================================
$pagina = basename(__FILE__);
$url_sin = function ($claves) use ($pagina) { $q = $_GET; foreach ($claves as $c) { unset($q[$c]); } return $pagina . (count($q) ? '?' . http_build_query($q) : ''); };
$chips = [];
if ($g_dep != 'null') { $chips[] = ['fa-map', $buscar_nombre($deptos, $g_dep), (tm_es_fijo('iddepartamento') ? '' : $url_sin(['iddepartamento', 'idmunicipio', 'idestablecimiento']))]; }
if ($g_mun != 'null') { $chips[] = ['fa-map-marker-alt', $buscar_nombre($munis, $g_mun), (tm_es_fijo('idmunicipio') ? '' : $url_sin(['idmunicipio', 'idestablecimiento']))]; }
if ($g_est != 'null') { $chips[] = ['fa-hospital', $buscar_nombre($eess, $g_est), $url_sin(['idestablecimiento'])]; }
if ($g_med != 'null') { $chips[] = ['fa-user-md', $buscar_nombre($medicos, $g_med), $url_sin(['idusuario_medico'])]; }


// Barra segmentada de estados (cada caso en un solo estado)
$seg_estados = [];
foreach (array_slice($kpi_tarjetas, 1) as $t) {
    $seg_estados[] = ['clave' => $t['clave'], 'titulo' => $t['titulo'], 'valor' => $t['valor'], 'icono' => $t['icono'], 'ayuda' => $t['ayuda'],
        'pct' => $total_absoluto > 0 ? $t['valor'] / $total_absoluto * 100 : 0, 'var' => $t['var']];
}
$var_total = $kpi_tarjetas[0]['var'];

// Tendencia: barras finas; si hay más de 16 puntos se agrupan por semana
$tend_lbl = $spark_etiquetas; $tend_val = $spark['total'];
if (!$agrupar_mes && count($tend_val) > 16) {
    $l2 = []; $v2 = [];
    foreach (array_chunk($tend_val, 7, true) as $i => $chunk) { $l2[] = $tend_lbl[array_keys($chunk)[0]]; $v2[] = array_sum($chunk); }
    $tend_lbl = $l2; $tend_val = $v2;
}
$tend_max = $tend_val ? max(1, max($tend_val)) : 1;
$tend_et = tm_etiquetas_tendencia($tend_lbl, $agrupar_mes);
$tend_idx_max = $tend_val ? array_search(max($tend_val), $tend_val) : -1;

// Anillos
$anillo = function ($pct, $r) { $c = 2 * M_PI * $r; return ['c' => round($c, 2), 'o' => round($c * (1 - max(0, min(100, $pct)) / 100), 2)]; };
$an_efe = $anillo($tasa_efectividad, 76);
$resp_total = count($t_total);
$pct_resp_24 = $resp_total > 0 ? round($resp_hist[0] / $resp_total * 100) : 0;
$an_resp = $anillo($pct_resp_24, 62);
$ticks = []; for ($i = 0; $i < 60; $i++) { $a = deg2rad($i * 6 - 90); $r1 = $i % 5 == 0 ? 86 : 89; $ticks[] = [round(100 + $r1 * cos($a), 2), round(100 + $r1 * sin($a), 2), round(100 + 94 * cos($a), 2), round(100 + 94 * sin($a), 2)]; }

// Antigüedad de pendientes en porcentaje
$antig_pct = []; foreach ($antig_total as $i => $v) { $antig_pct[$i] = $pend_total > 0 ? round($v / $pend_total * 100) : 0; }
$pct_mas7 = $antig_pct[3];
$pend_lista = array_slice($pend_hosp, 0, 5);
$rangos_cls = ['ok', 'warn', 'naranja', 'err'];

// Resumen corto de cada bloque del perfil (para el acordeón cerrado)
foreach ($perfil_bloques as $k => $b) {
    $suma = 0; $top = null; foreach ($b['items'] as $it) { $suma += $it[1]; if ($top === null || $it[1] > $top[1]) { $top = $it; } }
    $perfil_bloques[$k]['suma'] = $suma;
    $perfil_bloques[$k]['resumen'] = ($suma > 0 && $top) ? round($top[1] / $suma * 100) . '% ' . mb_strtolower($top[0]) : 'Sin datos';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SISTEMA MEDI-SAFCI - Telemedicina: Teleinterconsultas Respuestas</title>

    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <?php tm_estilos(); ?>
    <style>
        /* Pendientes: todos los establecimientos en una lista con scroll dentro de la tarjeta oscura (~5 visibles) */
        .px .oscura .pend-scroll { max-height: 420px; overflow-y: auto; margin-right: -8px; padding-right: 8px; overscroll-behavior: contain;
            scrollbar-width: thin; scrollbar-color: rgba(255, 255, 255, .38) transparent; }
        .px .oscura .pend-scroll::-webkit-scrollbar { width: 6px; }
        .px .oscura .pend-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, .32); border-radius: 6px; }
        .px .oscura .pend-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, .5); }
        /* Desvanecido inferior que avisa que hay más filas; desaparece al llegar al final */
        .px .oscura .pend-scroll.hay-mas { -webkit-mask-image: linear-gradient(to bottom, #000 calc(100% - 46px), transparent);
            mask-image: linear-gradient(to bottom, #000 calc(100% - 46px), transparent); }
        .px .oscura .pend-scroll:focus-visible { outline: 2px solid rgba(255, 255, 255, .45); outline-offset: 4px; border-radius: 8px; }
        .px .oscura .pista-scroll { margin-top: 10px; display: flex; align-items: center; justify-content: center; gap: 7px; font-size: 11.5px; color: rgba(255, 255, 255, .78); }

        /* Mapa: las flechas de derivación entre departamentos brillan con un pulso suave */
        .px .tic-mapa .highcharts-flowmap-series .highcharts-point { filter: drop-shadow(0 0 3px rgba(54, 185, 204, .7)) drop-shadow(0 0 8px rgba(78, 115, 223, .55)); animation: ticBrillo 2.6s ease-in-out infinite; }
        @keyframes ticBrillo {
            0%, 100% { opacity: .82; filter: drop-shadow(0 0 2px rgba(54, 185, 204, .6)) drop-shadow(0 0 6px rgba(78, 115, 223, .45)); }
            50%      { opacity: 1;   filter: drop-shadow(0 0 5px rgba(120, 225, 240, .95)) drop-shadow(0 0 14px rgba(78, 115, 223, .8)); }
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include("../menu.php"); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include("../top_bar.php"); ?>

                <div class="container-fluid mt-4 px">
                    <?php tm_cargador('Cargando respuestas'); // indicador de carga al ir a otra página ?>

                    <!-- ===================== ENCABEZADO ===================== -->
                    <div class="encabezado aparece">
                        <div>
                            <h1>Teleinterconsultas respuestas</h1>
                            <div class="meta">
                                <span><i class="far fa-calendar-alt mr-1"></i><?php echo $h($texto_periodo); ?> · <?php echo $dias_periodo; ?> día<?php echo $dias_periodo == 1 ? '' : 's'; ?></span>
                                <span class="d-inline-flex align-items-center" style="gap: 8px;" title="Las cifras se guardan 10 minutos para que la pestaña abra al instante al volver a ella"><span class="punto-vivo" aria-hidden="true"></span> Datos de las <?php echo $ahora->format('H:i'); ?> <a href="<?php echo $h($pagina . '?refrescar=1'); ?>" class="btn-actualizar" title="Volver a calcular con los datos más recientes"><i class="fas fa-sync-alt"></i> Actualizar</a></span>
                            </div>
                        </div>
                        <?php tm_nav('respuestas'); ?>
                    </div>

                    <!-- ===================== FILTROS (mismos campos e IDs) ===================== -->
                    <div class="barra-filtros filtros vidrio aparece">
                        <form id="form-filtros" method="GET" action="">
                            <div class="filtros-dropdowns">
                                <div>
                                    <label>Fecha inicio</label>
                                    <input type="date" name="fecha_inicio" value="<?php echo $h($inicio); ?>" onchange="document.getElementById('form-filtros').submit();">
                                </div>
                                <div>
                                    <label>Fecha fin</label>
                                    <input type="date" name="fecha_fin" value="<?php echo $h($finalizacion); ?>" onchange="document.getElementById('form-filtros').submit();">
                                </div>
                                <div>
                                    <label>Departamento<?php echo tm_candado('iddepartamento'); ?></label>
                                    <input list="dl-deptos" id="inp-depto" placeholder="- TODOS -" autocomplete="off"<?php echo tm_bloqueo('iddepartamento'); ?>>
                                    <input type="hidden" id="val-iddepartamento" name="iddepartamento" value="<?php echo $g_dep != 'null' ? $h($g_dep) : ''; ?>">
                                    <datalist id="dl-deptos"></datalist>
                                </div>
                                <div>
                                    <label>Municipio<?php echo tm_candado('idmunicipio'); ?></label>
                                    <input list="dl-munis" id="inp-muni" placeholder="- TODOS -" autocomplete="off"<?php echo tm_bloqueo('idmunicipio'); ?>>
                                    <input type="hidden" id="val-idmunicipio" name="idmunicipio" value="<?php echo $g_mun != 'null' ? $h($g_mun) : ''; ?>">
                                    <datalist id="dl-munis"></datalist>
                                </div>
                                <div>
                                    <label>Establecimiento</label>
                                    <input list="dl-ests" id="inp-est" placeholder="- TODOS -" autocomplete="off">
                                    <input type="hidden" id="val-idestablecimiento" name="idestablecimiento" value="<?php echo $g_est != 'null' ? $h($g_est) : ''; ?>">
                                    <datalist id="dl-ests"></datalist>
                                </div>
                                <div>
                                    <label>Médico especialista</label>
                                    <input list="dl-meds" id="inp-med" placeholder="- TODOS -" autocomplete="off">
                                    <input type="hidden" id="val-idusuario_medico" name="idusuario_medico" value="<?php echo $g_med != 'null' ? $h($g_med) : ''; ?>">
                                    <datalist id="dl-meds"></datalist>
                                </div>
                                <div>
                                    <button type="button" class="btn-limpiar" onclick="window.location.href='<?php echo $h(tm_url_limpiar($pagina)); ?>'" title="Limpiar filtros (también en las demás pestañas)"><i class="fas fa-eraser mr-1"></i> Limpiar</button>
                                </div>
                            </div>
                            <?php if (!empty($chips)) { ?>
                            <div class="chips">
                                <span class="etq"><i class="fas fa-filter mr-1"></i> <?php echo $h(tm_contexto('respuestas')); ?>:</span>
                                <?php foreach ($chips as $chip) { ?>
                                    <span class="chip"><i class="fas <?php echo $chip[0]; ?>"></i> <?php echo $h($chip[1]); ?><?php if ($chip[2] !== '') { ?><a href="<?php echo $h($chip[2]); ?>" title="Quitar filtro" aria-label="Quitar filtro <?php echo $h($chip[1]); ?>"><i class="fas fa-times"></i></a><?php } else { ?><i class="fas fa-lock ml-1" style="font-size: 10px; opacity: .6;" title="Fijado según su lugar de trabajo"></i><?php } ?></span>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </form>
                    </div>

                    <!-- ===================== RESUMEN: ESTADOS + CIFRAS ===================== -->
                    <div class="resumen aparece">
                        <div class="segmentos" role="img" aria-label="Distribución de estados de las teleinterconsultas">
                            <?php if ($total_absoluto == 0) { ?>
                                <div class="etq"><i class="far fa-folder-open mr-1"></i> No hay teleinterconsultas para este filtro</div>
                            <?php } foreach ($seg_estados as $s) { if ($s['valor'] <= 0) { continue; } ?>
                                <div class="seg <?php echo $s['clave']; ?>" data-grow="<?php echo round(max($s['pct'], 6), 2); ?>" style="flex: 0 1 0%;" title="<?php echo $h($s['titulo'] . ': ' . number_format($s['valor']) . ' (' . round($s['pct']) . '%) — ' . $s['ayuda']); ?>">
                                    <span class="etq"><i class="fas <?php echo $s['icono']; ?>" aria-hidden="true"></i><?php echo $h($s['titulo']); ?> <b><?php echo number_format($s['valor']); ?></b></span>
                                    <div class="barra"><?php echo round($s['pct']); ?>%</div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="cifras">
                            <div class="item">
                                <span class="cifra contador-animado" data-objetivo="<?php echo $total_absoluto; ?>">0</span>
                                <span class="pie"><span class="pildora-ico"><i class="fas fa-layer-group"></i></span><span class="etq">Total recibidas</span>
                                    <span class="delta <?php echo $var_total[1]; ?>" title="<?php echo $h($var_total[2]); ?>"><?php echo $h($var_total[0]); ?></span></span>
                            </div>
                            <div class="item">
                                <span class="cifra"><span class="contador-animado" data-objetivo="<?php echo $tasa_efectividad; ?>">0</span><small>%</small></span>
                                <span class="pie"><span class="pildora-ico"><i class="fas fa-check-double"></i></span><span class="etq">Efectividad</span></span>
                            </div>
                            <div class="item">
                                <span class="cifra"><?php echo $h($fmt_duracion($mediana($t_total))); ?></span>
                                <span class="pie"><span class="pildora-ico"><i class="fas fa-stopwatch"></i></span><span class="etq">Mediana de respuesta</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- ===================== GRID PRINCIPAL ===================== -->
                    <div class="grid">

                        <!-- EFECTIVIDAD -->
                        <div class="vidrio card-p aparece" style="animation-delay: .05s;">
                            <div class="cab-card">
                                <div><h6 class="titulo-card">Efectividad</h6><div class="sub-card">Efectivizadas sobre el total</div></div>
                                <span class="pildora-ico"><i class="fas fa-bullseye"></i></span>
                            </div>
                            <div class="anillo-wrap">
                                <svg viewBox="0 0 200 200" aria-hidden="true">
                                    <?php foreach ($ticks as $i => $tk) { ?><line x1="<?php echo $tk[0]; ?>" y1="<?php echo $tk[1]; ?>" x2="<?php echo $tk[2]; ?>" y2="<?php echo $tk[3]; ?>" stroke="rgba(90,92,105,<?php echo $i % 5 == 0 ? '.45' : '.2'; ?>)" stroke-width="<?php echo $i % 5 == 0 ? '1.6' : '1'; ?>"/><?php } ?>
                                    <circle cx="100" cy="100" r="76" fill="none" stroke="rgba(78,115,223,.1)" stroke-width="9"/>
                                    <circle class="arco" cx="100" cy="100" r="76" stroke="#4e73df" stroke-width="9" stroke-dasharray="<?php echo $an_efe['c']; ?>" stroke-dashoffset="<?php echo $an_efe['c']; ?>" data-offset="<?php echo $an_efe['o']; ?>"/>
                                </svg>
                                <div class="centro">
                                    <span class="cifra"><span class="contador-animado" data-objetivo="<?php echo $tasa_efectividad; ?>">0</span><small>%</small></span>
                                    <span class="etq">efectividad</span>
                                </div>
                            </div>
                            <?php $cls_tasa = $dif_tasa > 0 ? 'bueno' : ($dif_tasa < 0 ? 'malo' : 'neutro'); ?>
                            <div class="pie-card">
                                <span><?php echo number_format($total_efectivizadas); ?> de <?php echo number_format($total_absoluto); ?> casos</span>
                                <span class="delta <?php echo $cls_tasa; ?>" title="<?php echo $h(ucfirst(tm_etq_anterior(true)) . ': ' . $tasa_prev . '%'); ?>"><?php echo $dif_tasa == 0 ? '— sin cambio' : (($dif_tasa > 0 ? '▲ ' : '▼ ') . abs($dif_tasa) . ' pts'); ?></span>
                            </div>
                        </div>

                        <!-- TENDENCIA -->
                        <div class="vidrio card-p aparece" style="animation-delay: .1s;">
                            <div class="cab-card">
                                <div><h6 class="titulo-card">Tendencia</h6><div class="sub-card">Teleinterconsultas recibidas por <?php echo count($tend_val) != count($spark['total']) ? 'semana' : ($agrupar_mes ? 'mes' : 'día'); ?></div></div>
                                <span class="pildora-ico"><i class="fas fa-chart-bar"></i></span>
                            </div>
                            <div class="d-flex align-items-baseline" style="gap: 10px;">
                                <span class="cifra" style="font-size: 40px;"><?php echo number_format($total_absoluto); ?></span>
                                <span class="etq">casos en el periodo</span>
                            </div>
                            <?php if (empty($tend_val) || $total_absoluto == 0) { ?>
                                <div class="vacio"><i class="far fa-chart-bar"></i>Sin datos en el periodo</div>
                            <?php } else { ?>
                            <div class="tend" role="img" aria-label="Casos por periodo">
                                <?php foreach ($tend_val as $i => $v) { $esMax = $i === $tend_idx_max && $v > 0; ?>
                                    <div class="col <?php echo $esMax ? 'max' : ''; ?>" title="<?php echo $h($tend_et[$i]['titulo']) . ': ' . $v . ' casos'; ?>">
                                        <?php if ($esMax) { ?><span class="globo"><?php echo $v; ?></span><?php } ?>
                                        <span class="pista"><span class="relleno" data-alto="<?php echo round($v / $tend_max * 100, 2); ?>"></span></span>
                                        <span class="dot"></span>
                                        <span class="lbl"><?php if ($tend_et[$i]['ver']) { echo $h($tend_et[$i]['txt']); if ($tend_et[$i]['sub'] !== '') { echo '<small>' . $h($tend_et[$i]['sub']) . '</small>'; } } else { echo '&nbsp;'; } ?></span>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>

                        <!-- TIEMPO DE RESPUESTA -->
                        <div class="vidrio card-p aparece" style="animation-delay: .15s;">
                            <div class="cab-card">
                                <div><h6 class="titulo-card">Tiempo de respuesta</h6><div class="sub-card">Del envío a la contrarreferencia</div></div>
                                <span class="pildora-ico" style="color: var(--acc);"><i class="fas fa-stopwatch"></i></span>
                            </div>
                            <?php if ($resp_total == 0) { ?>
                                <div class="vacio"><i class="far fa-clock"></i>Aún no hay casos efectivizados para medir</div>
                            <?php } else { ?>
                            <div class="anillo-wrap" style="width: 160px;">
                                <svg viewBox="0 0 160 160" aria-hidden="true">
                                    <circle cx="80" cy="80" r="62" fill="none" stroke="rgba(54,185,204,.14)" stroke-width="7"/>
                                    <circle class="arco" cx="80" cy="80" r="62" stroke="#36b9cc" stroke-width="7" stroke-dasharray="<?php echo $an_resp['c']; ?>" stroke-dashoffset="<?php echo $an_resp['c']; ?>" data-offset="<?php echo $an_resp['o']; ?>"/>
                                </svg>
                                <div class="centro">
                                    <span class="cifra" style="font-size: 30px;"><?php echo $h($fmt_duracion($mediana($t_total))); ?></span>
                                    <span class="etq">mediana</span>
                                </div>
                            </div>
                            <div class="text-center etq mt-2"><b style="font-weight: 600; color: var(--n-900);"><?php echo $pct_resp_24; ?>%</b> respondidas en menos de 24 h</div>
                            <div class="desglose">
                                <div title="Mediana desde el envío hasta la admisión"><span class="etq">Hasta admitir</span><b><?php echo $h($fmt_duracion($mediana($t_admitir))); ?></b></div>
                                <div title="Mediana desde la admisión hasta la contrarreferencia"><span class="etq">Admisión → respuesta</span><b><?php echo $h($fmt_duracion($mediana($t_responder))); ?></b></div>
                            </div>
                            <div class="pie-card"><span>Promedio: <?php echo $h($fmt_duracion($promedio($t_total))); ?></span><span><?php echo $resp_total; ?> casos</span></div>
                            <?php } ?>
                        </div>

                        <!-- PENDIENTES (tarjeta alta, ocupa 2 filas) -->
                        <div class="vidrio card-p g-pend aparece" style="animation-delay: .2s;">
                            <div class="cab-card">
                                <div><h6 class="titulo-card">Pendientes</h6><div class="sub-card">Por admitir o por responder</div></div>
                                <span class="cifra" style="font-size: 40px;"><?php echo number_format($pend_total); ?></span>
                            </div>
                            <?php if ($pend_total > 0) { ?>
                                <div class="antig" role="img" aria-label="Antigüedad de los pendientes">
                                    <?php foreach ($rangos_tiempo as $i => $rt) { if ($antig_total[$i] <= 0) { continue; } ?>
                                        <div class="s <?php echo $rangos_cls[$i]; ?>" data-grow="<?php echo max($antig_pct[$i], 8); ?>" style="flex: 0 1 0%;" title="<?php echo $h($rt[0]) . ': ' . $antig_total[$i] . ' casos'; ?>">
                                            <span><?php echo $antig_pct[$i]; ?>%</span><i></i>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="leyenda-antig">
                                    <?php foreach ($rangos_tiempo as $i => $rt) { ?><span><i style="background: <?php echo $rt[1]; ?>;"></i><?php echo $h($rt[0]); ?></span><?php } ?>
                                </div>
                            <?php } ?>
                            <div class="oscura">
                                <div class="cab">
                                    <h6><i class="fas fa-inbox mr-2" style="opacity: .8;"></i>Bandejas atrasadas</h6>
                                    <span class="cifra" title="Establecimientos con pendientes"><?php echo count($pend_hosp); ?></span>
                                </div>
                                <?php if (empty($pend_lista)) { ?>
                                    <div class="vacio"><i class="far fa-check-circle" style="font-size: 28px; display: block; margin-bottom: 8px;"></i>Sin pendientes en el periodo</div>
                                <?php } else { tm_contactos_telesalud($link, array_column($pend_hosp, 'id')); // WhatsApp de todos en UNA consulta
                                    echo '<div class="pend-scroll' . (count($pend_hosp) > 5 ? ' hay-mas' : '') . '" id="pend-scroll" tabindex="0" aria-label="Lista de establecimientos con pendientes">';
                                    foreach ($pend_hosp as $ph) {
                                    if ($ph['max_h'] === null) { $sc = 'ok'; $stxt = 'sin fecha'; }
                                    else { $sc = $ph['max_h'] < 96 ? 'ok' : ($ph['max_h'] < 192 ? 'naranja' : 'err'); $dd = (int)floor($ph['max_h'] / 24); $stxt = $dd < 1 ? '< 1 día' : $dd . ($dd == 1 ? ' día' : ' días'); } ?>
                                    <div class="fila">
                                        <?php echo tm_boton_whatsapp($link, $ph, $ph['pa'] . ' por admitir, ' . $ph['ev'] . ' por responder'); ?>
                                        <span class="txt"><b title="<?php echo $h($ph['nombre']); ?>"><?php echo $h($ph['nombre']); ?></b><small><?php echo $ph['pa']; ?> por admitir · <?php echo $ph['ev']; ?> por responder</small></span>
                                        <span class="num"><b><?php echo $ph['pa'] + $ph['ev']; ?></b><small><span class="sem <?php echo $sc; ?>" aria-hidden="true"></span><?php echo $stxt; ?></small></span>
                                    </div>
                                <?php } echo '</div>'; } ?>
                                <?php if (count($pend_hosp) > 5) { ?><div class="pista-scroll"><i class="fas fa-arrows-alt-v" aria-hidden="true"></i> Desliza para ver los <?php echo count($pend_hosp); ?> hospitales especialistas</div>
                                <script>(function () { var l = document.getElementById('pend-scroll'); if (!l) return; var f = function () { l.classList.toggle('hay-mas', l.scrollTop + l.clientHeight < l.scrollHeight - 4); }; l.addEventListener('scroll', f, { passive: true }); window.addEventListener('load', f); })();</script><?php } ?>
                            </div>
                            <?php if ($pend_total > 0) { $antig_max_p = max(1, max($antig_total)); ?>
                            <div class="detalle-antig">
                                <span class="etq">Detalle por antigüedad</span>
                                <?php foreach ($rangos_tiempo as $i => $rt) { ?>
                                    <div class="fila-a">
                                        <span><?php echo $h($rt[0]); ?></span>
                                        <span class="pista-a"><span data-ancho="<?php echo round($antig_total[$i] / $antig_max_p * 100, 2); ?>" style="background: <?php echo $rt[1]; ?>;"></span></span>
                                        <b><?php echo number_format($antig_total[$i]); ?></b>
                                        <small><?php echo number_format($antig['por_admitir'][$i]); ?> por admitir · <?php echo number_format($antig['en_valoracion'][$i]); ?> por responder</small>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>

                        <!-- PERFIL EN ACORDEÓN -->
                        <div class="vidrio card-p aparece" style="animation-delay: .25s;">
                            <div class="cab-card">
                                <div><h6 class="titulo-card">Perfil de atención</h6><div class="sub-card">Distribución de los casos</div></div>
                                <span class="pildora-ico"><i class="fas fa-clipboard-list"></i></span>
                            </div>
                            <?php foreach ($perfil_bloques as $k => $b) { ?>
                                <div class="acord <?php echo $k === 0 ? 'abierto' : ''; ?>">
                                    <button type="button" class="acord-cab" aria-expanded="<?php echo $k === 0 ? 'true' : 'false'; ?>">
                                        <span class="t"><?php echo $h($b['titulo']); ?></span>
                                        <span class="r"><?php echo $h($b['resumen']); ?></span>
                                        <i class="fas fa-chevron-down chev" aria-hidden="true"></i>
                                    </button>
                                    <div class="acord-cuerpo"><div class="dentro">
                                        <?php if ($b['suma'] > 0) { ?>
                                        <div class="prop">
                                            <?php foreach ($b['items'] as $it) { if ($it[1] > 0) { ?><span data-ancho="<?php echo round($it[1] / $b['suma'] * 100, 2); ?>" style="background: <?php echo $it[2]; ?>;"></span><?php } } ?>
                                        </div>
                                        <?php } ?>
                                        <div class="prop-items">
                                            <?php foreach ($b['items'] as $it) { ?>
                                                <div><i class="p" style="background: <?php echo $it[2]; ?>;"></i><?php echo $h($it[0]); ?><b><?php echo number_format($it[1]); ?><?php if ($b['suma'] > 0) { ?> <span style="color: var(--n-700); font-weight: 400;">· <?php echo round($it[1] / $b['suma'] * 100); ?>%</span><?php } ?></b></div>
                                            <?php } ?>
                                        </div>
                                        <div class="etq mt-2" style="font-size: 11.5px;"><?php echo $h($b['nota']); ?></div>
                                    </div></div>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- MAPA (tarjeta grande) -->
                        <div class="vidrio card-p g-mapa tic-mapa aparece" id="card-mapa" style="animation-delay: .3s;">
                            <div class="cab-card">
                                <div><h6 class="titulo-card">Mapa de respuestas</h6><div class="sub-card">Hospital consultor → red emisora · Solo efectivizadas · Clic en un departamento para filtrar</div></div>
                            </div>
                            <div class="mapa-wrap">
                                <div class="mapa-capas" id="mapa-capas">
                                    <button type="button" data-capa="relieve">Relieve</button>
                                    <button type="button" data-capa="satelite">Satélite</button>
                                    <button type="button" data-capa="claro">Claro</button>
                                    <button type="button" data-capa="plano">Plano</button>
                                </div>
                                <button type="button" class="mapa-btn" id="btn-mapa-full" title="Pantalla completa" aria-label="Pantalla completa"><i class="fas fa-expand"></i></button>
                                <div id="contenedor-mapa"><div class="esqueleto"></div></div>
                                <div class="mapa-rutas">
                                    <h6><i class="fas fa-exchange-alt mr-1"></i> Top rutas de respuesta</h6>
                                    <?php if (empty($rutas_top)) { ?>
                                        <div class="etq">Sin respuestas entre departamentos</div>
                                    <?php } else { foreach ($rutas_top as $i => $ruta) { ?>
                                        <div class="ruta"><span class="n"><?php echo $i + 1; ?></span>
                                            <span class="txt"><?php echo $h(mb_convert_case(mb_strtolower($ruta['origen']), MB_CASE_TITLE)); ?><i class="fas fa-long-arrow-alt-right"></i><?php echo $h(mb_convert_case(mb_strtolower($ruta['destino']), MB_CASE_TITLE)); ?></span>
                                            <b style="font-weight: 600;"><?php echo number_format($ruta['peso']); ?></b></div>
                                    <?php } } ?>
                                </div>
                                <div class="mapa-aviso" id="mapa-aviso"><i class="fas fa-wifi mr-1"></i> Sin conexión al mapa base: vista plana</div>
                            </div>
                        </div>
                    </div>

                    <!-- ===================== DIAGNÓSTICOS Y ESPECIALIDADES ===================== -->
                    <div class="grid-2">
                        <div class="vidrio card-p aparece">
                            <div class="cab-card">
                                <div><h6 class="titulo-card">Top 10 diagnósticos confirmados</h6><div class="sub-card">Diagnóstico de egreso registrado por el especialista</div></div>
                                <span class="pildora-ico"><i class="fas fa-notes-medical"></i></span>
                            </div>
                            <div id="grafico-origen" style="height: 380px;"><div class="esqueleto"></div></div>
                        </div>
                        <div class="vidrio card-p aparece">
                            <div class="cab-card">
                                <div><h6 class="titulo-card">Top 10 especialidades</h6><div class="sub-card">Especialidades más requeridas al hospital consultor</div></div>
                                <span class="pildora-ico"><i class="fas fa-star"></i></span>
                            </div>
                            <div id="grafico-especialidades" style="height: 380px;"><div class="esqueleto"></div></div>
                        </div>
                    </div>

                </div>
            </div>

            <footer class="sticky-footer bg-white mt-auto">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto"><span>Ministerio de Salud y Deportes © MSYD <?php echo $gestion; ?></span></div>
                </div>
            </footer>
        </div>
    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>
    <script src="../js/telesalud_js/highcharts-11.3.0.js"></script>
    <script src="../js/telesalud_js/map-11.3.0.js"></script>
    <script src="../js/telesalud_js/flowmap-11.3.0.js"></script>
    <script src="../js/telesalud_js/tiledwebmap-11.3.0.js"></script>
    <script src="../js/telesalud_js/exporting-11.3.0.js"></script>
    <script src="../js/telesalud_js/export-data-11.3.0.js"></script>
    <script src="../js/telesalud_js/offline-exporting-11.3.0.js"></script>
    <script src="../js/telesalud_js/bo-all-topo.js"></script>

    <!-- Presentación: contadores, barras, anillos y acordeón -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.contador-animado').forEach(contador => {
            const objetivo = parseFloat(contador.getAttribute('data-objetivo')) || 0;
            const pasos = 40; let paso = 0;
            const tick = () => {
                paso++;
                const v = objetivo * Math.min(1, paso / pasos);
                contador.innerText = Number.isInteger(objetivo) ? Math.round(v).toLocaleString('en-US') : v.toFixed(1);
                if (paso < pasos) setTimeout(tick, 20);
            };
            tick();
        });

        setTimeout(function() {
            document.querySelectorAll('.prop span, .pista-a span').forEach(el => { el.style.width = el.getAttribute('data-ancho') + '%'; });
            document.querySelectorAll('.seg, .antig .s').forEach(el => { el.style.flexGrow = el.getAttribute('data-grow'); });
            document.querySelectorAll('.tend .relleno').forEach(el => { el.style.height = el.getAttribute('data-alto') + '%'; });
            document.querySelectorAll('.arco').forEach(el => { el.style.strokeDashoffset = el.getAttribute('data-offset'); });
        }, 150);

        document.querySelectorAll('.acord-cab').forEach(btn => {
            btn.addEventListener('click', function() {
                const item = this.closest('.acord');
                const abrir = !item.classList.contains('abierto');
                item.classList.toggle('abierto', abrir);
                this.setAttribute('aria-expanded', abrir ? 'true' : 'false');
            });
        });
    });
    </script>

    <!-- Gráficos (mismos datos que la página actual, estilo minimalista) -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const FUENTE = "'Outfit', 'Segoe UI', Arial, sans-serif";
        Highcharts.setOptions({
            lang: {
                thousandsSep: ',', decimalPoint: '.',
                contextButtonTitle: 'Opciones del gráfico', viewFullscreen: 'Ver en pantalla completa', exitFullscreen: 'Salir de pantalla completa',
                printChart: 'Imprimir', downloadPNG: 'Descargar imagen PNG', downloadJPEG: 'Descargar imagen JPEG', downloadSVG: 'Descargar imagen SVG',
                downloadCSV: 'Descargar CSV', downloadXLS: 'Descargar Excel', viewData: 'Ver tabla de datos', hideData: 'Ocultar tabla de datos',
                zoomIn: 'Acercar', zoomOut: 'Alejar', loading: 'Cargando...', noData: 'Sin datos'
            },
            chart: { backgroundColor: 'transparent', style: { fontFamily: FUENTE } },
            title: { text: null }, credits: { enabled: false }, accessibility: { enabled: false },
            tooltip: { backgroundColor: 'rgba(255,255,255,0.96)', borderWidth: 1, borderColor: 'rgba(78,115,223,0.15)', borderRadius: 14, padding: 10, shadow: false,
                style: { fontSize: '12.5px', color: '#34353d' } },
            xAxis: { lineWidth: 0, tickWidth: 0, labels: { style: { color: '#5a5c69', fontSize: '11.5px' } } },
            yAxis: { gridLineWidth: 0, labels: { enabled: false }, title: { text: null } },
            legend: { itemStyle: { color: '#5a5c69', fontWeight: '400', fontSize: '12px' } },
            exporting: { fallbackToExportServer: false, buttons: { contextButton: { symbol: 'menu', symbolStroke: '#858796', theme: { fill: 'transparent', r: 12, states: { hover: { fill: 'rgba(78,115,223,0.08)' }, select: { fill: 'rgba(78,115,223,0.12)' } } },
                menuItems: ['viewFullscreen', 'printChart', 'separator', 'downloadPNG', 'downloadSVG', 'separator', 'viewData', 'downloadCSV', 'downloadXLS'] } } },
            navigation: { menuStyle: { border: '1px solid rgba(78,115,223,.15)', borderRadius: '14px', boxShadow: 'none', padding: '6px 0', background: 'rgba(255,255,255,.97)' },
                menuItemStyle: { fontSize: '12.5px', padding: '6px 16px', fontFamily: FUENTE }, menuItemHoverStyle: { background: '#4e73df', color: '#ffffff' } }
        });
        const suave = (c, o) => Highcharts.color(c).setOpacity(o).get('rgba');

        function alVisible(id, dibujar) {
            const el = document.getElementById(id); if (!el) return;
            if (!('IntersectionObserver' in window)) { dibujar(); return; }
            const obs = new IntersectionObserver(e => { if (e.some(x => x.isIntersecting)) { obs.disconnect(); dibujar(); } }, { rootMargin: '0px 0px -60px 0px' });
            obs.observe(el);
        }

        // --- Barras horizontales minimalistas (pista tenue + barra fina) ---
        function barras(id, categorias, datos, nombre) {
            if (!datos.length || datos.every(v => v === 0)) {
                document.getElementById(id).innerHTML = '<div class="vacio"><i class="far fa-chart-bar"></i>Sin datos para el periodo y filtros seleccionados</div>'; return;
            }
            const max = Math.max.apply(null, datos);
            Highcharts.chart(id, {
                chart: { type: 'bar', spacingTop: 36 },
                xAxis: { categories: categorias, labels: { style: { color: '#5a5c69', fontSize: '11.5px', textOverflow: 'ellipsis' } } },
                yAxis: { min: 0, max: max * 1.12 },
                legend: { enabled: false },
                tooltip: { headerFormat: '<span style="font-size:11.5px;color:#5a5c69">{point.key}</span><br/>', pointFormat: nombre + ': <b>{point.y}</b>' },
                plotOptions: { bar: { grouping: false, borderWidth: 0, borderRadius: 7, pointWidth: 11, dataLabels: { enabled: true, style: { fontWeight: '500', color: '#34353d', textOutline: 'none', fontSize: '12px' } } } },
                series: [
                    { name: 'pista', data: datos.map(() => max * 1.12), color: 'rgba(78,115,223,0.07)', enableMouseTracking: false, dataLabels: { enabled: false }, animation: false },
                    { name: nombre, data: datos, color: { linearGradient: { x1: 0, y1: 0, x2: 1, y2: 0 }, stops: [[0, suave('#4e73df', 0.55)], [1, '#4e73df']] } }
                ]
            });
        }
        alVisible('grafico-origen', () => barras('grafico-origen', <?php echo json_encode($cat_destino, JSON_UNESCAPED_UNICODE); ?>, <?php echo json_encode($data_destino); ?>, 'Casos confirmados'));
        alVisible('grafico-especialidades', () => barras('grafico-especialidades', <?php echo json_encode($cat_esp, JSON_UNESCAPED_UNICODE); ?>, <?php echo json_encode($data_esp); ?>, 'Solicitudes'));

        // --- Mapa de flujo (misma lógica que la página actual) ---
        let chartMapa = null;
        try {
            const flujoData = <?php echo json_encode(isset($datos_flujo_mapa) ? $datos_flujo_mapa : []); ?>;
            const mapaBolivia = Highcharts.maps['countries/bo/bo-all-topo'];
            const dicDeptos = {
                'BENI': { id: 1, hcKey: 'bo-eb', nombre: 'El Beni' }, 'COCHABAMBA': { id: 2, hcKey: 'bo-cb', nombre: 'Cochabamba' },
                'CHUQUISACA': { id: 3, hcKey: 'bo-cq', nombre: 'Chuquisaca' }, 'LA PAZ': { id: 4, hcKey: 'bo-lp', nombre: 'La Paz' },
                'ORURO': { id: 5, hcKey: 'bo-or', nombre: 'Oruro' }, 'PANDO': { id: 6, hcKey: 'bo-pa', nombre: 'Pando' },
                'POTOSI': { id: 7, hcKey: 'bo-po', nombre: 'Potosí' }, 'SANTA CRUZ': { id: 8, hcKey: 'bo-sc', nombre: 'Santa Cruz' },
                'TARIJA': { id: 9, hcKey: 'bo-tr', nombre: 'Tarija' }
            };
            let heatData = [], bubbleData = [], mapLines = [];
            for (let depto in dicDeptos) {
                let total = 0; flujoData.forEach(f => { if (f.origen === depto || f.destino === depto) total += f.peso; });
                heatData.push({ 'hc-key': dicDeptos[depto].hcKey, id: dicDeptos[depto].hcKey, name: dicDeptos[depto].nombre, value: total, idDepto: dicDeptos[depto].id });
                if (total > 0) bubbleData.push({ 'hc-key': dicDeptos[depto].hcKey, name: dicDeptos[depto].nombre, z: total, idDepto: dicDeptos[depto].id });
            }
            flujoData.forEach(f => {
                if (dicDeptos[f.origen] && dicDeptos[f.destino] && f.origen !== f.destino) {
                    mapLines.push({ from: dicDeptos[f.origen].hcKey, to: dicDeptos[f.destino].hcKey, weight: f.peso, totalCasos: f.peso, origenNom: dicDeptos[f.origen].nombre, destinoNom: dicDeptos[f.destino].nombre });
                }
            });
            const capasBase = { relieve: { type: 'Esri', theme: 'WorldShadedRelief' }, satelite: { type: 'Esri', theme: 'WorldImagery' }, claro: { type: 'Esri', theme: 'WorldGrayCanvas' } };
            const hayTiles = !!(Highcharts.seriesTypes && Highcharts.seriesTypes.tiledwebmap);
            let capa0 = 'satelite'; // por defecto Satélite; luego se recuerda la capa que elija el usuario en su navegador
            try { const g = localStorage.getItem('tm_capa_mapa'); if (g && (capasBase[g] || g === 'plano')) capa0 = g; } catch (e) {}
            if (!hayTiles) capa0 = 'plano';
            const opac = { relieve: 0.82, satelite: 0.65, claro: 0.88, plano: 1 };
            let series = [];
            if (hayTiles) series.push({ type: 'tiledwebmap', id: 'capa-fondo', provider: capasBase[capa0 === 'plano' ? 'claro' : capa0], visible: capa0 !== 'plano', showInLegend: false, enableMouseTracking: false });
            series.push({ type: 'map', id: 'capa-base', name: 'Carga Térmica', mapData: mapaBolivia, allAreas: true, data: heatData, joinBy: ['hc-key', 'hc-key'],
                opacity: opac[capa0], borderColor: '#ffffff', borderWidth: 1.5, states: { hover: { color: '#36b9cc', opacity: 1 } }, showInLegend: false,
                dataLabels: { enabled: true, format: '{point.name}', style: { fontSize: '11px', fontWeight: '500', textOutline: '2.5px #ffffff', color: '#34353d' } } });
            if (bubbleData.length) series.push({ type: 'mapbubble', name: 'Volumen', mapData: mapaBolivia, joinBy: ['hc-key', 'hc-key'], data: bubbleData, colorAxis: false,
                color: 'rgba(34, 74, 190, 0.85)', minSize: 22, maxSize: '12%', marker: { lineColor: '#ffffff', lineWidth: 2 }, showInLegend: false,
                dataLabels: { enabled: true, format: '{point.z}', style: { color: '#ffffff', textOutline: 'none', fontWeight: '500', fontSize: '11.5px' } } });
            if (mapLines.length) series.push({ type: 'flowmap', linkedTo: 'capa-base', name: 'Flujo de Derivación', data: mapLines, color: '#4e73df', fillOpacity: 0.85,
                minWidth: 2, maxWidth: 8, curveFactor: 0.35, markerEnd: { width: '50%', height: '50%' }, animation: { defer: 400, duration: 1800 } });

            document.getElementById('contenedor-mapa').innerHTML = '';
            chartMapa = Highcharts.mapChart('contenedor-mapa', {
                chart: { backgroundColor: 'transparent', spacing: [0, 0, 0, 0] },
                mapView: { projection: { name: 'WebMercator' }, padding: [50, 20, 20, 20] },
                mapNavigation: { enabled: true, buttonOptions: { verticalAlign: 'bottom', align: 'right', x: -12, theme: { fill: 'rgba(255,255,255,0.92)', 'stroke-width': 1, stroke: 'rgba(78,115,223,0.15)', r: 12, style: { color: '#4e73df' } } },
                    buttons: { zoomIn: { y: -62 }, zoomOut: { y: -32 } } },
                exporting: { enabled: false },
                credits: { enabled: capa0 !== 'plano', text: 'Mapa base © Esri', href: 'https://www.esri.com', style: { fontSize: '9px', color: '#5a5c69' } },
                colorAxis: { min: 0, minColor: '#e9eefb', maxColor: '#4e73df' },
                legend: { enabled: true, align: 'right', verticalAlign: 'top', floating: true, layout: 'horizontal', y: 52, x: -12, backgroundColor: 'rgba(255,255,255,0.85)', borderRadius: 12, padding: 8, symbolWidth: 130,
                    title: { text: 'Casos', style: { fontSize: '11px', fontWeight: '500', color: '#5a5c69' } } },
                plotOptions: { series: { cursor: 'pointer', point: { events: { click: function () {
                    if (this.idDepto) { document.getElementById('inp-depto').value = this.name.toUpperCase(); document.getElementById('val-iddepartamento').value = this.idDepto; document.getElementById('form-filtros').submit(); }
                } } } } },
                tooltip: { useHTML: true, formatter: function () {
                    if (this.series.name === 'Carga Térmica' || this.series.name === 'Volumen') {
                        const v = this.series.name === 'Volumen' ? this.point.z : (this.point.value || 0);
                        return `<b>${this.point.name}</b><br>Volumen global de casos: <b>${v}</b><br><span style="font-size:11px;color:#5a5c69">Clic para filtrar este departamento</span>`;
                    }
                    if (this.series.name === 'Flujo de Derivación') return `<b>Hospital consultor:</b> ${this.point.options.origenNom}<br><b>Red emisora:</b> ${this.point.options.destinoNom}<br><b>Respuestas efectivizadas:</b> ${this.point.options.totalCasos}`;
                    return this.point.name;
                } },
                series: series
            });

            const botones = document.querySelectorAll('#mapa-capas button');
            const marcar = c => botones.forEach(b => b.classList.toggle('activo', b.getAttribute('data-capa') === c));
            function aplicarCapa(c) {
                const fondo = chartMapa.get('capa-fondo'), areas = chartMapa.get('capa-base');
                if (c !== 'plano' && fondo) { fondo.update({ provider: capasBase[c] }, false); fondo.setVisible(true, false); } else if (fondo) { fondo.setVisible(false, false); }
                areas.update({ opacity: opac[c], dataLabels: { style: { color: c === 'satelite' ? '#ffffff' : '#34353d', textOutline: c === 'satelite' ? '2.5px #34353d' : '2.5px #ffffff' } } }, false);
                if (chartMapa.credits && chartMapa.credits.element) chartMapa.credits.element.style.display = c === 'plano' ? 'none' : '';
                chartMapa.redraw(); marcar(c);
                try { localStorage.setItem('tm_capa_mapa', c); } catch (e) {}
            }
            botones.forEach(b => b.addEventListener('click', () => aplicarCapa(b.getAttribute('data-capa'))));
            marcar(capa0); if (capa0 === 'satelite') aplicarCapa('satelite');
            function sinTeselas() { botones.forEach(b => { if (b.getAttribute('data-capa') !== 'plano') b.disabled = true; }); document.getElementById('mapa-aviso').style.display = 'block'; aplicarCapa('plano'); }
            if (!hayTiles) sinTeselas();
            else { const img = new Image(); const to = setTimeout(sinTeselas, 8000); img.onload = () => clearTimeout(to); img.onerror = () => { clearTimeout(to); sinTeselas(); };
                img.src = 'https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/0/0/0?t=' + Date.now(); }

            const card = document.getElementById('card-mapa');
            document.getElementById('btn-mapa-full').addEventListener('click', () => { if (document.fullscreenElement) document.exitFullscreen(); else if (card.requestFullscreen) card.requestFullscreen(); });
            document.addEventListener('fullscreenchange', () => { document.querySelector('#btn-mapa-full i').className = document.fullscreenElement ? 'fas fa-compress' : 'fas fa-expand'; setTimeout(() => chartMapa && chartMapa.reflow(), 150); });
        } catch (error) {
            console.error('Error en el mapa:', error);
            document.getElementById('contenedor-mapa').innerHTML = '<div class="vacio"><i class="fas fa-exclamation-triangle"></i>Error interno del mapa</div>';
        }
    });
    </script>

    <!-- MOTOR DE FILTROS EN CASCADA CON AUTO-RECARGA (idéntico a la página actual) -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const dbDeptos = <?php echo json_encode($deptos, JSON_UNESCAPED_UNICODE); ?>;
        const dbMunis = <?php echo json_encode($munis, JSON_UNESCAPED_UNICODE); ?>;
        const dbEess = <?php echo json_encode($eess, JSON_UNESCAPED_UNICODE); ?>;
        const dbMeds = <?php echo json_encode($medicos, JSON_UNESCAPED_UNICODE); ?>;
        const initDepto = <?php echo $js_dep; ?>, initMuni = <?php echo $js_mun; ?>, initEess = <?php echo $js_est; ?>, initMed = <?php echo $js_med; ?>;
        const inpDepto = document.getElementById('inp-depto'), inpMuni = document.getElementById('inp-muni'), inpEst = document.getElementById('inp-est'), inpMed = document.getElementById('inp-med');
        const valDepto = document.getElementById('val-iddepartamento'), valMuni = document.getElementById('val-idmunicipio'), valEst = document.getElementById('val-idestablecimiento'), valMed = document.getElementById('val-idusuario_medico');
        const dlDeptos = document.getElementById('dl-deptos'), dlMunis = document.getElementById('dl-munis'), dlEess = document.getElementById('dl-ests'), dlMeds = document.getElementById('dl-meds');
        function poblarLista(dl, arr) { let html = ''; arr.forEach(item => { html += `<option data-id="${item.id}" value="${item.nombre}"></option>`; }); dl.innerHTML = html; }

        poblarLista(dlDeptos, dbDeptos); poblarLista(dlMeds, dbMeds);
        if (initDepto) { const o = dbDeptos.find(d => d.id == initDepto); if (o) { inpDepto.value = o.nombre; valDepto.value = o.id; } poblarLista(dlMunis, dbMunis.filter(m => m.idDepto == initDepto)); } else { poblarLista(dlMunis, dbMunis); }
        if (initMuni) { const o = dbMunis.find(m => m.id == initMuni); if (o) { inpMuni.value = o.nombre; valMuni.value = o.id; } poblarLista(dlEess, dbEess.filter(e => e.idMuni == initMuni)); } else { poblarLista(dlEess, dbEess); }
        if (initEess) { const o = dbEess.find(e => e.id == initEess); if (o) { inpEst.value = o.nombre; valEst.value = o.id; } }
        if (initMed) { const o = dbMeds.find(u => u.id == initMed); if (o) { inpMed.value = o.nombre; valMed.value = o.id; } }

        inpDepto.addEventListener('input', function() {
            const obj = dbDeptos.find(d => d.nombre.toLowerCase() === this.value.trim().toLowerCase());
            if (obj) { valDepto.value = obj.id; poblarLista(dlMunis, dbMunis.filter(m => m.idDepto == obj.id)); inpMuni.value = ""; valMuni.value = ""; inpEst.value = ""; valEst.value = ""; poblarLista(dlEess, []); }
            else { valDepto.value = ""; poblarLista(dlMunis, dbMunis); poblarLista(dlEess, dbEess); }
        });
        inpMuni.addEventListener('input', function() {
            const m = dbMunis.find(x => x.nombre.toLowerCase() === this.value.trim().toLowerCase());
            if (m) { valMuni.value = m.id; const d = dbDeptos.find(x => x.id == m.idDepto); if (d) { inpDepto.value = d.nombre; valDepto.value = d.id; } poblarLista(dlEess, dbEess.filter(e => e.idMuni == m.id)); inpEst.value = ""; valEst.value = ""; }
            else { valMuni.value = ""; }
        });
        inpEst.addEventListener('input', function() {
            const e = dbEess.find(x => x.nombre.toLowerCase() === this.value.trim().toLowerCase());
            if (e) { valEst.value = e.id; const m = dbMunis.find(x => x.id == e.idMuni); if (m) { inpMuni.value = m.nombre; valMuni.value = m.id; const d = dbDeptos.find(x => x.id == m.idDepto); if (d) { inpDepto.value = d.nombre; valDepto.value = d.id; } } }
            else { valEst.value = ""; }
        });
        inpMed.addEventListener('input', function() { const op = document.querySelector(`#dl-meds option[value="${this.value}"]`); valMed.value = op ? op.getAttribute('data-id') : ""; });

        function aplicarFiltro(input, hidden, arr) {
            input.addEventListener('change', function() {
                const val = this.value.trim().toUpperCase();
                const obj = arr.find(item => item.nombre.toUpperCase() === val);
                if (obj) { hidden.value = obj.id; document.getElementById('form-filtros').submit(); }
                else if (val === "") { hidden.value = ""; document.getElementById('form-filtros').submit(); }
            });
        }
        aplicarFiltro(inpDepto, valDepto, dbDeptos); aplicarFiltro(inpMuni, valMuni, dbMunis); aplicarFiltro(inpEst, valEst, dbEess); aplicarFiltro(inpMed, valMed, dbMeds);
    });
    </script>
</body>
</html>
