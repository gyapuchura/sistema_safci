<?php
// 1. Iniciar conexión y sesión nativa
include("../cabf.php");
include("../inc.config.php");

// 2. Blindaje de sesiones para evitar errores en menu.php y top_bar.php
$idusuario_ss = $_SESSION['idusuario_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$gestion      = date("Y");

// Filtros compartidos entre pestañas, navegación en píldora y estilos del diseño
include("inc_telemedicina.php");

// Caché de 10 minutos: al volver a esta pestaña con los mismos filtros aparece al instante ("Actualizar" la recalcula)
tm_cache_pantalla();

// =========================================================================
// FASE 1: PUENTE DE DATOS Y CAPTURA DE FILTROS
// =========================================================================
$es_fecha = function ($f) { return is_string($f) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $f) && strtotime($f) !== false; };
$inicio       = (isset($_GET['fecha_inicio']) && $es_fecha($_GET['fecha_inicio'])) ? $_GET['fecha_inicio'] : date('Y-m-01');
$finalizacion = (isset($_GET['fecha_fin']) && $es_fecha($_GET['fecha_fin'])) ? $_GET['fecha_fin'] : date('Y-m-d');

$g_dep = isset($_GET['iddepartamento']) && $_GET['iddepartamento'] != '' ? $_GET['iddepartamento'] : '';
$g_mun = isset($_GET['idmunicipio']) && $_GET['idmunicipio'] != '' ? $_GET['idmunicipio'] : '';
$g_est = isset($_GET['idestablecimiento']) && $_GET['idestablecimiento'] != '' ? $_GET['idestablecimiento'] : '';
$g_med = isset($_GET['idusuario_medico']) && $_GET['idusuario_medico'] != '' ? $_GET['idusuario_medico'] : '';

$filtro_extra = "";
if ($g_dep != '') { $filtro_extra .= " AND a.iddepartamento = '" . mysqli_real_escape_string($link, $g_dep) . "' "; }
if ($g_mun != '') { $filtro_extra .= " AND a.idmunicipio = '" . mysqli_real_escape_string($link, $g_mun) . "' "; }
if ($g_est != '') { $filtro_extra .= " AND a.idestablecimiento_salud = '" . mysqli_real_escape_string($link, $g_est) . "' "; }
if ($g_med != '') { $filtro_extra .= " AND a.idusuario = '" . mysqli_real_escape_string($link, $g_med) . "' "; }

// Literales seguros para JS (null o string JSON)
$js_dep = $g_dep != '' ? json_encode((string)$g_dep) : 'null';
$js_mun = $g_mun != '' ? json_encode((string)$g_mun) : 'null';
$js_est = $g_est != '' ? json_encode((string)$g_est) : 'null';
$js_med = $g_med != '' ? json_encode((string)$g_med) : 'null';

// Catálogos para los selectores (Filtros en JSON)
// Catálogos de los filtros, recortados al alcance del usuario (inc_telemedicina.php)
list($deptos, $munis, $eess, $medicos) = tm_catalogos($link);

// =========================================================================
// ⚙️ MOTOR DE DATOS: CONSULTAS OPTIMIZADAS (SOLO TELECONSULTAS idtipo_atencion = '3')
// =========================================================================

// A) KPIs Maestros: total, pacientes únicos y edad promedio
//    (el total ya NO excluye pacientes sin fecha de nacimiento; esa condición solo aplica a la edad)
$resumen_tc = function ($ini, $fin) use ($link, $filtro_extra) {
    $res = mysqli_query($link, "SELECT COUNT(a.idatencion_psafci) AS total, COUNT(DISTINCT a.idnombre) AS pacientes,
            AVG(CASE WHEN n.fecha_nac IS NOT NULL AND n.fecha_nac != '0000-00-00' THEN TIMESTAMPDIFF(MONTH, n.fecha_nac, a.fecha_registro) END) AS edad_media
        FROM atencion_psafci a LEFT JOIN nombre n ON a.idnombre = n.idnombre
        WHERE a.idtipo_atencion = '3' AND a.fecha_registro BETWEEN '$ini' AND '$fin' $filtro_extra");
    $row = $res ? mysqli_fetch_assoc($res) : null;
    return ['total' => $row ? (int)$row['total'] : 0, 'pacientes' => $row ? (int)$row['pacientes'] : 0, 'edad' => ($row && $row['edad_media'] !== null) ? (float)$row['edad_media'] : null];
};

$dt_ini = new DateTime($inicio);
$dt_fin = new DateTime($finalizacion);
$dias_periodo = max(1, (int)$dt_ini->diff($dt_fin)->format('%r%a') + 1);
list($dt_prev_ini, $dt_prev_fin) = tm_periodo_anterior($dt_ini, $dt_fin); // mismos días del mes anterior, o mismas fechas de la gestión anterior

$kpi      = $resumen_tc($inicio, $finalizacion);
$kpi_prev = $resumen_tc($dt_prev_ini->format('Y-m-d'), $dt_prev_fin->format('Y-m-d'));
$total_teleconsultas = $kpi['total'];
$edad_promedio = $kpi['edad'] !== null ? $kpi['edad'] : 0;

// Tendencia (sparklines): por día, o por mes si el rango supera 92 días
$agrupar_mes = $dias_periodo > 92;
$spark_etiquetas = []; $spark = ['total' => [], 'pacientes' => []]; $spark_idx = [];
if ($dt_fin >= $dt_ini) {
    $p_ini = $agrupar_mes ? new DateTime($dt_ini->format('Y-m-01')) : clone $dt_ini;
    $p_fin = clone $dt_fin; $p_fin->modify('+1 day');
    foreach (new DatePeriod($p_ini, new DateInterval($agrupar_mes ? 'P1M' : 'P1D'), $p_fin) as $f) {
        $spark_idx[$f->format($agrupar_mes ? 'Y-m' : 'Y-m-d')] = count($spark_etiquetas);
        $spark_etiquetas[] = $f->format($agrupar_mes ? 'm/Y' : 'd/m');
        $spark['total'][] = 0; $spark['pacientes'][] = 0;
    }
}
$sql_clave_spark = $agrupar_mes ? "DATE_FORMAT(a.fecha_registro, '%Y-%m')" : "DATE_FORMAT(a.fecha_registro, '%Y-%m-%d')";
$res_spark = mysqli_query($link, "SELECT $sql_clave_spark AS clave, COUNT(*) AS total, COUNT(DISTINCT a.idnombre) AS pacientes FROM atencion_psafci a
    WHERE a.idtipo_atencion = '3' AND a.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_extra GROUP BY clave");
if ($res_spark) {
    while ($row = mysqli_fetch_assoc($res_spark)) {
        if (isset($spark_idx[$row['clave']])) { $i = $spark_idx[$row['clave']]; $spark['total'][$i] = (int)$row['total']; $spark['pacientes'][$i] = (int)$row['pacientes']; }
    }
}

// B) Modalidad de tiempo: Real vs Diferido
$arr_tiempo = []; $tot_tiempo_real = 0; $tot_tiempo_reg = 0;
$sql_tiempo = "SELECT t.tiempo_ts, COUNT(*) as cantidad FROM atencion_psafci a
    INNER JOIN atencion_teleconsulta at ON a.idatencion_psafci = at.idatencion_psafci
    INNER JOIN tiempo_ts t ON at.idtiempo_ts = t.idtiempo_ts
    WHERE a.idtipo_atencion = '3' AND a.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_extra GROUP BY t.tiempo_ts";
$res_tiempo = mysqli_query($link, $sql_tiempo);
if ($res_tiempo) {
    while ($row_t = mysqli_fetch_array($res_tiempo)) {
        $arr_tiempo[] = ['name' => ucfirst(mb_strtolower($row_t['tiempo_ts'])), 'y' => (int)$row_t['cantidad']];
        $tot_tiempo_reg += (int)$row_t['cantidad'];
        if (mb_strpos(mb_strtoupper($row_t['tiempo_ts']), 'REAL') !== false) { $tot_tiempo_real += (int)$row_t['cantidad']; }
    }
}
$pct_tiempo_real = $tot_tiempo_reg > 0 ? round($tot_tiempo_real / $tot_tiempo_reg * 100, 1) : 0;

// C) Estado del Paciente
$arr_estado = [];
$sql_estado = "SELECT ep.estado_paciente, COUNT(*) as cantidad FROM atencion_psafci a
    INNER JOIN atencion_teleconsulta at ON a.idatencion_psafci = at.idatencion_psafci
    INNER JOIN estado_paciente ep ON at.idestado_paciente = ep.idestado_paciente
    WHERE a.idtipo_atencion = '3' AND a.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_extra GROUP BY ep.estado_paciente ORDER BY cantidad DESC";
$res_estado = mysqli_query($link, $sql_estado);
if ($res_estado) { while ($row_e = mysqli_fetch_array($res_estado)) { $arr_estado[] = ['name' => ucfirst(mb_strtolower($row_e['estado_paciente'])), 'y' => (int)$row_e['cantidad']]; } }

// D) Nuevo vs Seguimiento
$arr_rep = [];
$sql_rep = "SELECT a.idrepeticion, COUNT(*) as cantidad FROM atencion_psafci a
    WHERE a.idtipo_atencion = '3' AND a.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_extra GROUP BY a.idrepeticion";
$res_rep = mysqli_query($link, $sql_rep);
if ($res_rep) {
    while ($row_r = mysqli_fetch_array($res_rep)) {
        $nombre_rep = ($row_r['idrepeticion'] == '1') ? 'Nuevo' : 'Seguimiento';
        $arr_rep[] = ['name' => $nombre_rep, 'y' => (int)$row_r['cantidad']];
    }
}

// E) Sexo de los pacientes atendidos
$arr_sexo = [];
$res_sexo = mysqli_query($link, "SELECT IFNULL(g.genero, 'SIN DATO') AS genero, COUNT(*) AS cantidad FROM atencion_psafci a
    LEFT JOIN nombre n ON a.idnombre = n.idnombre LEFT JOIN genero g ON n.idgenero = g.idgenero
    WHERE a.idtipo_atencion = '3' AND a.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_extra GROUP BY genero ORDER BY cantidad DESC");
if ($res_sexo) { while ($row_s = mysqli_fetch_assoc($res_sexo)) { $arr_sexo[] = ['name' => ucfirst(mb_strtolower($row_s['genero'])), 'y' => (int)$row_s['cantidad']]; } }

// F) Vías de Comunicación (ordenado)
$cat_vias = []; $data_vias = []; $via_principal = "S/D"; $via_principal_cant = 0;
$sql_vias = "SELECT vc.via_comunicacion, COUNT(*) as cantidad FROM atencion_psafci a
    INNER JOIN atencion_teleconsulta at ON a.idatencion_psafci = at.idatencion_psafci
    INNER JOIN via_comunicacion vc ON at.idvia_comunicacion = vc.idvia_comunicacion
    WHERE a.idtipo_atencion = '3' AND a.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_extra
    GROUP BY vc.via_comunicacion ORDER BY cantidad DESC";
$res_vias = mysqli_query($link, $sql_vias);
$isFirst = true; $tot_vias = 0;
if ($res_vias) {
    while ($row_v = mysqli_fetch_array($res_vias)) {
        $nombre_via = ucwords(mb_strtolower($row_v['via_comunicacion']));
        if($isFirst) { $via_principal = $nombre_via; $via_principal_cant = (int)$row_v['cantidad']; $isFirst = false; }
        $cat_vias[] = $nombre_via;
        $data_vias[] = (int)$row_v['cantidad'];
        $tot_vias += (int)$row_v['cantidad'];
    }
}
$pct_via_principal = $tot_vias > 0 ? round($via_principal_cant / $tot_vias * 100) : 0;

// G) Top 10 Diagnósticos CIE-10
$cat_diag = []; $data_diag = [];
$sql_diag = "SELECT p.patologia, p.cie, COUNT(dt.iddiagnostico_teleconsulta) as total FROM atencion_psafci a
    INNER JOIN diagnostico_teleconsulta dt ON a.idatencion_psafci = dt.idatencion_psafci
    INNER JOIN patologia p ON dt.idpatologia = p.idpatologia
    WHERE a.idtipo_atencion = '3' AND a.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_extra
    GROUP BY p.idpatologia ORDER BY total DESC LIMIT 10";
$res_diag = mysqli_query($link, $sql_diag);
if ($res_diag) { while($row_d = mysqli_fetch_array($res_diag)){ $cat_diag[] = $row_d['cie']." - ".$row_d['patologia']; $data_diag[] = (int)$row_d['total']; } }

// H) Grupos Vulnerables
$cat_vul = []; $data_vul = [];
$sql_vul = "SELECT gv.grupo_vulnerable, COUNT(agv.idatencion_grupo_vulnerable) as total FROM atencion_psafci a
    INNER JOIN atencion_grupo_vulnerable agv ON a.idatencion_psafci = agv.idatencion_psafci
    INNER JOIN grupo_vulnerable gv ON agv.idgrupo_vulnerable = gv.idgrupo_vulnerable
    WHERE a.idtipo_atencion = '3' AND a.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_extra
    GROUP BY gv.idgrupo_vulnerable ORDER BY total DESC";
$res_vul = mysqli_query($link, $sql_vul);
if ($res_vul) { while($row_v = mysqli_fetch_array($res_vul)){ $cat_vul[] = mb_strtoupper($row_v['grupo_vulnerable']); $data_vul[] = (int)$row_v['total']; } }

// I) Establecimientos con más teleconsultas
$ranking_eess = [];
$res_re = mysqli_query($link, "SELECT es.establecimiento_salud, dep.departamento, COUNT(*) AS total FROM atencion_psafci a
    LEFT JOIN establecimiento_salud es ON a.idestablecimiento_salud = es.idestablecimiento_salud
    LEFT JOIN departamento dep ON es.iddepartamento = dep.iddepartamento
    WHERE a.idtipo_atencion = '3' AND a.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_extra
    GROUP BY a.idestablecimiento_salud, es.establecimiento_salud, dep.departamento ORDER BY total DESC LIMIT 10");
if ($res_re) {
    while ($row = mysqli_fetch_assoc($res_re)) {
        $ranking_eess[] = ['nombre' => $row['establecimiento_salud'] ? mb_strtoupper(trim($row['establecimiento_salud'])) : 'ESTABLECIMIENTO NO REGISTRADO',
            'depto' => $row['departamento'] ? mb_convert_case(mb_strtolower(trim($row['departamento'])), MB_CASE_TITLE) : '', 'total' => (int)$row['total']];
    }
}
$ranking_max = $ranking_eess ? max(1, $ranking_eess[0]['total']) : 1;

// =========================================================================
// PRESENTACIÓN (textos, chips de filtros, variaciones, perfil)
// =========================================================================
$paleta = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#6f42c1', '#fd7e14'];
$a_items = function ($arr) use ($paleta) { $out = []; foreach ($arr as $i => $it) { $out[] = [$it['name'], $it['y'], $paleta[$i % count($paleta)]]; } return $out; };
$perfil_bloques = [
    ['titulo' => 'Modalidad de tiempo', 'icono' => 'fa-history', 'items' => $a_items($arr_tiempo)],
    ['titulo' => 'Tipo de paciente', 'icono' => 'fa-user-plus', 'items' => $a_items($arr_rep)],
    ['titulo' => 'Sexo', 'icono' => 'fa-venus-mars', 'items' => $a_items($arr_sexo)],
    ['titulo' => 'Estado del paciente', 'icono' => 'fa-notes-medical', 'items' => $a_items($arr_estado)],
];

$meses_es = ['', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
$fecha_larga = function (DateTime $f) use ($meses_es) { return (int)$f->format('j') . ' de ' . $meses_es[(int)$f->format('n')] . ' de ' . $f->format('Y'); };
$texto_periodo = 'Del ' . $fecha_larga($dt_ini) . ' al ' . $fecha_larga($dt_fin);
$ahora = new DateTime('now', new DateTimeZone('America/La_Paz'));

// Chips de filtros activos (cada ✕ quita el filtro y sus dependientes en cascada)
$buscar_nombre = function ($lista, $id) { foreach ($lista as $it) { if ((string)$it['id'] === (string)$id) { return $it['nombre']; } } return $id; };
$url_sin = function ($claves) { $q = $_GET; foreach ($claves as $c) { unset($q[$c]); } return 'teleconsultas.php' . (count($q) ? '?' . http_build_query($q) : ''); };
$chips = [];
if ($g_dep != '') { $chips[] = ['fa-map', $buscar_nombre($deptos, $g_dep), (tm_es_fijo('iddepartamento') ? '' : $url_sin(['iddepartamento', 'idmunicipio', 'idestablecimiento']))]; }
if ($g_mun != '') { $chips[] = ['fa-map-marker-alt', $buscar_nombre($munis, $g_mun), (tm_es_fijo('idmunicipio') ? '' : $url_sin(['idmunicipio', 'idestablecimiento']))]; }
if ($g_est != '') { $chips[] = ['fa-hospital', $buscar_nombre($eess, $g_est), $url_sin(['idestablecimiento'])]; }
if ($g_med != '') { $chips[] = ['fa-user-md', $buscar_nombre($medicos, $g_med), $url_sin(['idusuario_medico'])]; }

// Variación contra el mes o la gestión anterior. $sentido: 1 = subir es bueno, -1 = subir es malo, 0 = neutral
$variacion = function ($actual, $anterior, $sentido) {
    if ($anterior == 0 && $actual == 0) { return ['—', 'neutro', 'Sin cambios vs ' . tm_etq_anterior(true)]; }
    if ($anterior == 0) { return ['Nuevo', $sentido >= 0 ? 'bueno' : 'malo', 'Sin registros en ' . tm_etq_anterior(true, true)]; }
    $pct = round((($actual - $anterior) / $anterior) * 100);
    if ($pct == 0) { return ['0%', 'neutro', 'Igual que ' . tm_etq_anterior(true, true)]; }
    $clase = $sentido == 0 ? 'neutro' : ((($pct > 0) == ($sentido > 0)) ? 'bueno' : 'malo');
    return [($pct > 0 ? '▲ ' : '▼ ') . abs($pct) . '%', $clase, ucfirst(tm_etq_anterior(true)) . ': ' . number_format($anterior)];
};
// Edad promedio: se calcula en meses cumplidos y se muestra en la unidad adecuada (meses, año y meses, o años)
$edad_fmt = tm_formato_edad($kpi['edad']);
$var_edad = tm_variacion_edad($kpi['edad'], $kpi_prev['edad']);

$circ_anillo = 2 * M_PI * 26;
$offset_anillo = round($circ_anillo * (1 - min(100, $pct_tiempo_real) / 100), 2);

$h = function ($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); };

// =========================================================================
// PRESENTACIÓN: datos derivados solo para la vista (no cambian las consultas de arriba)
// =========================================================================
$pagina = 'teleconsultas.php';
$pestana = 'teleconsultas';

// Segmentos del encabezado: estado del paciente (4 principales + otros)
$seg_clases = ['s1', 's2', 's3', 's4', 's5'];
$seg_total = 0; foreach ($arr_estado as $e) { $seg_total += $e['y']; }
$seg_estados = [];
foreach (array_slice($arr_estado, 0, 4) as $i => $e) { $seg_estados[] = ['titulo' => $e['name'], 'valor' => $e['y'], 'clase' => $seg_clases[$i]]; }
$seg_resto = 0; foreach (array_slice($arr_estado, 4) as $e) { $seg_resto += $e['y']; }
if ($seg_resto > 0) { $seg_estados[] = ['titulo' => 'Otros', 'valor' => $seg_resto, 'clase' => 's5']; }
foreach ($seg_estados as $k => $s) { $seg_estados[$k]['pct'] = $seg_total > 0 ? $s['valor'] / $seg_total * 100 : 0; }

$v_total = $variacion($kpi['total'], $kpi_prev['total'], 1);
$v_pac   = $variacion($kpi['pacientes'], $kpi_prev['pacientes'], 1);

// Tendencia: barras finas; si hay más de 16 puntos se agrupan por semana
$tend_lbl = $spark_etiquetas; $tend_val = $spark['total'];
if (!$agrupar_mes && count($tend_val) > 16) {
    $l2 = []; $v2 = [];
    foreach (array_chunk($tend_val, 7, true) as $chunk) { $l2[] = $tend_lbl[array_keys($chunk)[0]]; $v2[] = array_sum($chunk); }
    $tend_lbl = $l2; $tend_val = $v2;
}
$tend_max = $tend_val ? max(1, max($tend_val)) : 1;
$tend_et = tm_etiquetas_tendencia($tend_lbl, $agrupar_mes);
$tend_idx_max = $tend_val ? array_search(max($tend_val), $tend_val) : -1;
$tend_unidad = count($tend_val) != count($spark['total']) ? 'semana' : ($agrupar_mes ? 'mes' : 'día');

// Anillo con marcas: atención en tiempo real
$anillo = function ($pct, $r) { $c = 2 * M_PI * $r; return ['c' => round($c, 2), 'o' => round($c * (1 - max(0, min(100, $pct)) / 100), 2)]; };
$an_real = $anillo($pct_tiempo_real, 76);
$ticks = []; for ($i = 0; $i < 60; $i++) { $a = deg2rad($i * 6 - 90); $r1 = $i % 5 == 0 ? 86 : 89; $ticks[] = [round(100 + $r1 * cos($a), 2), round(100 + $r1 * sin($a), 2), round(100 + 94 * cos($a), 2), round(100 + 94 * sin($a), 2)]; }

// Canales de comunicación
$icono_via = function ($n) {
    $n = mb_strtolower($n);
    if (mb_strpos($n, 'video') !== false) { return 'fa-video'; }
    if (mb_strpos($n, 'mensaj') !== false || mb_strpos($n, 'whatsapp') !== false) { return 'fa-comment-dots'; }
    if (mb_strpos($n, 'telef') !== false || mb_strpos($n, 'llamada') !== false) { return 'fa-phone-alt'; }
    if (mb_strpos($n, 'correo') !== false) { return 'fa-envelope'; }
    return 'fa-satellite-dish';
};
// Color por canal (paleta SB Admin 2): ícono, fondo suave y barra del mismo tono
$color_via = function ($n) {
    $n = mb_strtolower($n);
    if (mb_strpos($n, 'video') !== false) { return ['#4e73df', '78, 115, 223']; }
    if (mb_strpos($n, 'mensaj') !== false || mb_strpos($n, 'whatsapp') !== false) { return ['#36b9cc', '54, 185, 204']; }
    if (mb_strpos($n, 'telef') !== false || mb_strpos($n, 'llamada') !== false) { return ['#1cc88a', '28, 200, 138']; }
    if (mb_strpos($n, 'correo') !== false) { return ['#fd7e14', '253, 126, 20']; }
    return ['#5a5c69', '90, 92, 105'];
};
$vias_max = $data_vias ? max(1, max($data_vias)) : 1;

// Establecimientos (tarjeta oscura) y grupos vulnerables
$ranking_lista = array_slice($ranking_eess, 0, 5);
$ranking_total = 0; foreach ($ranking_eess as $re) { $ranking_total += $re['total']; }
$vul_max = $data_vul ? max(1, max($data_vul)) : 1;

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
    <title>SISTEMA MEDI-SAFCI - Telemedicina: Teleconsultas</title>

    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <?php tm_estilos(); ?>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include("../menu.php"); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include("../top_bar.php"); ?>

                <div class="container-fluid mt-4 px">
                    <?php tm_cargador('Cargando teleconsultas'); // indicador de carga al ir a otra página ?>

                    <!-- ===================== ENCABEZADO ===================== -->
                    <div class="encabezado aparece">
                        <div>
                            <h1>Teleconsultas</h1>
                            <div class="meta">
                                <span><i class="far fa-calendar-alt mr-1"></i><?php echo $h($texto_periodo); ?> · <?php echo $dias_periodo; ?> día<?php echo $dias_periodo == 1 ? '' : 's'; ?></span>
                                <span class="d-inline-flex align-items-center" style="gap: 8px;" title="Las cifras se guardan 10 minutos para que la pestaña abra al instante al volver a ella"><span class="punto-vivo" aria-hidden="true"></span> Datos de las <?php echo $ahora->format('H:i'); ?> <a href="<?php echo $h($pagina . '?refrescar=1'); ?>" class="btn-actualizar" title="Volver a calcular con los datos más recientes"><i class="fas fa-sync-alt"></i> Actualizar</a></span>
                            </div>
                        </div>
                        <?php tm_nav($pestana); ?>
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
                                    <input type="hidden" id="val-iddepartamento" name="iddepartamento" value="<?php echo $h($g_dep); ?>">
                                    <datalist id="dl-deptos"></datalist>
                                </div>
                                <div>
                                    <label>Municipio<?php echo tm_candado('idmunicipio'); ?></label>
                                    <input list="dl-munis" id="inp-muni" placeholder="- TODOS -" autocomplete="off"<?php echo tm_bloqueo('idmunicipio'); ?>>
                                    <input type="hidden" id="val-idmunicipio" name="idmunicipio" value="<?php echo $h($g_mun); ?>">
                                    <datalist id="dl-munis"></datalist>
                                </div>
                                <div>
                                    <label>Establecimiento</label>
                                    <input list="dl-ests" id="inp-est" placeholder="- TODOS -" autocomplete="off">
                                    <input type="hidden" id="val-idestablecimiento" name="idestablecimiento" value="<?php echo $h($g_est); ?>">
                                    <datalist id="dl-ests"></datalist>
                                </div>
                                <div>
                                    <label>Médico</label>
                                    <input list="dl-meds" id="inp-med" placeholder="- TODOS -" autocomplete="off">
                                    <input type="hidden" id="val-idusuario_medico" name="idusuario_medico" value="<?php echo $h($g_med); ?>">
                                    <datalist id="dl-meds"></datalist>
                                </div>
                                <div>
                                    <button type="button" class="btn-limpiar" onclick="window.location.href='<?php echo $h(tm_url_limpiar($pagina)); ?>'" title="Limpiar filtros (también en las demás pestañas)"><i class="fas fa-eraser mr-1"></i> Limpiar</button>
                                </div>
                            </div>
                            <?php if (!empty($chips)) { ?>
                            <div class="chips">
                                <span class="etq"><i class="fas fa-filter mr-1"></i> <?php echo $h(tm_contexto($pestana)); ?>:</span>
                                <?php foreach ($chips as $chip) { ?>
                                    <span class="chip"><i class="fas <?php echo $chip[0]; ?>"></i> <?php echo $h($chip[1]); ?><?php if ($chip[2] !== '') { ?><a href="<?php echo $h($chip[2]); ?>" title="Quitar filtro" aria-label="Quitar filtro <?php echo $h($chip[1]); ?>"><i class="fas fa-times"></i></a><?php } else { ?><i class="fas fa-lock ml-1" style="font-size: 10px; opacity: .6;" title="Fijado según su lugar de trabajo"></i><?php } ?></span>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </form>
                    </div>

                    <!-- ===================== RESUMEN: ESTADO DEL PACIENTE + CIFRAS ===================== -->
                    <div class="resumen aparece">
                        <div class="segmentos" role="img" aria-label="Estado del paciente tras la teleconsulta">
                            <?php if ($seg_total == 0) { ?>
                                <div class="etq"><i class="far fa-folder-open mr-1"></i> No hay teleconsultas con estado registrado para este filtro</div>
                            <?php } foreach ($seg_estados as $s) { if ($s['valor'] <= 0) { continue; } ?>
                                <div class="seg <?php echo $s['clase']; ?>" data-grow="<?php echo round(max($s['pct'], 6), 2); ?>" style="flex: 0 1 0%;" title="<?php echo $h($s['titulo'] . ': ' . number_format($s['valor']) . ' (' . round($s['pct']) . '%)'); ?>">
                                    <span class="etq"><?php echo $h($s['titulo']); ?> <b><?php echo number_format($s['valor']); ?></b></span>
                                    <div class="barra"><?php echo round($s['pct']); ?>%</div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="cifras">
                            <div class="item">
                                <span class="cifra contador-animado" data-objetivo="<?php echo $kpi['total']; ?>">0</span>
                                <span class="pie"><span class="pildora-ico"><i class="fas fa-laptop-medical"></i></span><span class="etq">Teleconsultas</span>
                                    <span class="delta <?php echo $v_total[1]; ?>" title="<?php echo $h($v_total[2]); ?>"><?php echo $h($v_total[0]); ?></span></span>
                            </div>
                            <div class="item">
                                <span class="cifra contador-animado" data-objetivo="<?php echo $kpi['pacientes']; ?>">0</span>
                                <span class="pie"><span class="pildora-ico"><i class="fas fa-users"></i></span><span class="etq">Pacientes</span>
                                    <span class="delta <?php echo $v_pac[1]; ?>" title="<?php echo $h($v_pac[2]); ?>"><?php echo $h($v_pac[0]); ?></span></span>
                            </div>
                            <div class="item">
                                <span class="cifra" title="<?php echo $h($edad_fmt['exacto']); ?>"><?php if ($edad_fmt['numerico']) { ?><span class="contador-animado" data-objetivo="<?php echo $h($edad_fmt['valor']); ?>">0</span><?php } else { echo $h($edad_fmt['valor']); } ?><small> <?php echo $h($edad_fmt['unidad']); ?></small></span>
                                <span class="pie"><span class="pildora-ico"><i class="fas fa-user-clock"></i></span><span class="etq">Edad promedio</span>
                                    <span class="delta <?php echo $var_edad[1]; ?>" title="<?php echo $h($var_edad[2]); ?>"><?php echo $h($var_edad[0]); ?></span></span>
                            </div>
                        </div>
                    </div>

                    <!-- ===================== GRID PRINCIPAL ===================== -->
                    <div class="grid">

                        <!-- TIEMPO REAL -->
                        <div class="vidrio card-p aparece" style="animation-delay: .05s;">
                            <div class="cab-card">
                                <div><h6 class="titulo-card">Tiempo real</h6><div class="sub-card">Atendidas en el momento (vs diferido)</div></div>
                                <span class="pildora-ico"><i class="fas fa-history"></i></span>
                            </div>
                            <div class="anillo-wrap">
                                <svg viewBox="0 0 200 200" aria-hidden="true">
                                    <?php foreach ($ticks as $i => $tk) { ?><line x1="<?php echo $tk[0]; ?>" y1="<?php echo $tk[1]; ?>" x2="<?php echo $tk[2]; ?>" y2="<?php echo $tk[3]; ?>" stroke="rgba(90,92,105,<?php echo $i % 5 == 0 ? '.45' : '.2'; ?>)" stroke-width="<?php echo $i % 5 == 0 ? '1.6' : '1'; ?>"/><?php } ?>
                                    <circle cx="100" cy="100" r="76" fill="none" stroke="rgba(78,115,223,.1)" stroke-width="9"/>
                                    <circle class="arco" cx="100" cy="100" r="76" stroke="#4e73df" stroke-width="9" stroke-dasharray="<?php echo $an_real['c']; ?>" stroke-dashoffset="<?php echo $an_real['c']; ?>" data-offset="<?php echo $an_real['o']; ?>"/>
                                </svg>
                                <div class="centro">
                                    <span class="cifra"><span class="contador-animado" data-objetivo="<?php echo $pct_tiempo_real; ?>">0</span><small>%</small></span>
                                    <span class="etq">en tiempo real</span>
                                </div>
                            </div>
                            <div class="pie-card">
                                <span><?php echo number_format($tot_tiempo_real); ?> de <?php echo number_format($tot_tiempo_reg); ?> con modalidad registrada</span>
                            </div>
                        </div>

                        <!-- TENDENCIA -->
                        <div class="vidrio card-p aparece" style="animation-delay: .1s;">
                            <div class="cab-card">
                                <div><h6 class="titulo-card">Tendencia</h6><div class="sub-card">Teleconsultas por <?php echo $tend_unidad; ?></div></div>
                                <span class="pildora-ico"><i class="fas fa-chart-bar"></i></span>
                            </div>
                            <div class="d-flex align-items-baseline" style="gap: 10px;">
                                <span class="cifra" style="font-size: 40px;"><?php echo number_format($kpi['total']); ?></span>
                                <span class="etq">en el periodo</span>
                            </div>
                            <?php if (empty($tend_val) || $kpi['total'] == 0) { ?>
                                <div class="vacio"><i class="far fa-chart-bar"></i>Sin datos en el periodo</div>
                            <?php } else { ?>
                            <div class="tend" role="img" aria-label="Teleconsultas por periodo">
                                <?php foreach ($tend_val as $i => $v) { $esMax = $i === $tend_idx_max && $v > 0; ?>
                                    <div class="col <?php echo $esMax ? 'max' : ''; ?>" title="<?php echo $h($tend_et[$i]['titulo']) . ': ' . $v; ?>">
                                        <?php if ($esMax) { ?><span class="globo"><?php echo $v; ?></span><?php } ?>
                                        <span class="pista"><span class="relleno" data-alto="<?php echo round($v / $tend_max * 100, 2); ?>"></span></span>
                                        <span class="dot"></span>
                                        <span class="lbl"><?php if ($tend_et[$i]['ver']) { echo $h($tend_et[$i]['txt']); if ($tend_et[$i]['sub'] !== '') { echo '<small>' . $h($tend_et[$i]['sub']) . '</small>'; } } else { echo '&nbsp;'; } ?></span>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>

                        <!-- CANALES -->
                        <div class="vidrio card-p aparece" style="animation-delay: .15s;">
                            <div class="cab-card">
                                <div><h6 class="titulo-card">Canales</h6><div class="sub-card">Vía de comunicación utilizada</div></div>
                                <span class="pildora-ico" style="color: var(--acc);"><i class="fas fa-satellite-dish"></i></span>
                            </div>
                            <?php if (empty($data_vias)) { ?>
                                <div class="vacio"><i class="fas fa-satellite-dish"></i>Sin datos en el periodo</div>
                            <?php } else { ?>
                            <div class="d-flex align-items-baseline" style="gap: 10px;">
                                <span class="cifra" style="font-size: 40px;"><?php echo $pct_via_principal; ?><small style="font-size: 18px;">%</small></span>
                                <span class="etq">por <?php echo $h(mb_strtolower($via_principal)); ?></span>
                            </div>
                            <div class="lista-barras mt-3">
                                <?php foreach ($cat_vias as $i => $nom) { ?>
                                    <?php $cc = $color_via($nom); ?>
                                    <div class="item" style="--cc: <?php echo $cc[0]; ?>; --cc-rgb: <?php echo $cc[1]; ?>;">
                                        <span class="pildora-ico"><i class="fas <?php echo $icono_via($nom); ?>"></i></span>
                                        <div>
                                            <div class="nom"><span><?php echo $h($nom); ?></span><b><?php echo number_format($data_vias[$i]); ?> <small>· <?php echo $tot_vias > 0 ? round($data_vias[$i] / $tot_vias * 100) : 0; ?>%</small></b></div>
                                            <div class="pista"><span data-ancho="<?php echo round($data_vias[$i] / $vias_max * 100, 2); ?>"></span></div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>

                        <!-- ESTABLECIMIENTOS + GRUPOS VULNERABLES (columna alta) -->
                        <div class="vidrio card-p g-pend aparece" style="animation-delay: .2s;">
                            <div class="cab-card">
                                <div><h6 class="titulo-card">Establecimientos</h6><div class="sub-card">Donde se realizaron las teleconsultas</div></div>
                                <span class="cifra" style="font-size: 40px;"><?php echo count($ranking_eess); ?></span>
                            </div>
                            <div class="oscura">
                                <div class="cab">
                                    <h6><i class="fas fa-hospital mr-2" style="opacity: .8;"></i>Más activos</h6>
                                    <span class="cifra"><?php echo count($ranking_lista); ?><small style="font-size: 16px; opacity: .75;">/<?php echo count($ranking_eess); ?></small></span>
                                </div>
                                <?php if (empty($ranking_lista)) { ?>
                                    <div class="vacio"><i class="far fa-hospital" style="font-size: 28px; display: block; margin-bottom: 8px;"></i>Sin registros en el periodo</div>
                                <?php } else { foreach ($ranking_lista as $i => $re) { ?>
                                    <div class="fila">
                                        <span class="ico"><?php echo $i + 1; ?></span>
                                        <span class="txt"><b title="<?php echo $h($re['nombre']); ?>"><?php echo $h($re['nombre']); ?></b><small><?php echo $h($re['depto'] ? $re['depto'] : 'Sin departamento'); ?></small></span>
                                        <span class="num"><b><?php echo number_format($re['total']); ?></b><small><?php echo $ranking_total > 0 ? round($re['total'] / $ranking_total * 100) : 0; ?>% del total</small></span>
                                    </div>
                                <?php } } ?>
                            </div>
                            <div class="detalle-antig">
                                <span class="etq"><i class="fas fa-hands-helping mr-1"></i> Grupos vulnerables</span>
                                <?php if (empty($data_vul)) { ?>
                                    <span class="etq">Sin registros en el periodo</span>
                                <?php } else { foreach ($cat_vul as $i => $nom) { ?>
                                    <div class="fila-a" style="grid-template-columns: minmax(0, 1fr) 90px 30px;">
                                        <span title="<?php echo $h($nom); ?>" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php echo $h(mb_convert_case(mb_strtolower($nom), MB_CASE_TITLE)); ?></span>
                                        <span class="pista-a"><span data-ancho="<?php echo round($data_vul[$i] / $vul_max * 100, 2); ?>" style="background: var(--p);"></span></span>
                                        <b><?php echo number_format($data_vul[$i]); ?></b>
                                    </div>
                                <?php } } ?>
                            </div>
                        </div>

                        <!-- PERFIL EN ACORDEÓN -->
                        <div class="vidrio card-p aparece" style="animation-delay: .25s;">
                            <div class="cab-card">
                                <div><h6 class="titulo-card">Perfil de atención</h6><div class="sub-card">Distribución de las teleconsultas</div></div>
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
                                            <?php if (empty($b['items'])) { ?><div>Sin datos en el periodo</div><?php } ?>
                                        </div>
                                    </div></div>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- DIAGNÓSTICOS (tarjeta grande) -->
                        <div class="vidrio card-p g-mapa aparece" style="animation-delay: .3s;">
                            <div class="cab-card">
                                <div><h6 class="titulo-card">Top 10 diagnósticos (CIE-10)</h6><div class="sub-card">Diagnósticos registrados en las teleconsultas</div></div>
                                <span class="pildora-ico"><i class="fas fa-notes-medical"></i></span>
                            </div>
                            <div id="grafico-diagnosticos" style="height: 430px;"><div class="esqueleto"></div></div>
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
    <script src="../js/telesalud_js/exporting-11.3.0.js"></script>
    <script src="../js/telesalud_js/export-data-11.3.0.js"></script>
    <script src="../js/telesalud_js/offline-exporting-11.3.0.js"></script>

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
            document.querySelectorAll('.prop span, .pista-a span, .lista-barras .pista span').forEach(el => { el.style.width = el.getAttribute('data-ancho') + '%'; });
            document.querySelectorAll('.seg').forEach(el => { el.style.flexGrow = el.getAttribute('data-grow'); });
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

    <!-- Gráfico de diagnósticos (estilo minimalista) -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const FUENTE = "'Outfit', 'Segoe UI', Arial, sans-serif";
        Highcharts.setOptions({
            lang: {
                thousandsSep: ',', decimalPoint: '.',
                contextButtonTitle: 'Opciones del gráfico', viewFullscreen: 'Ver en pantalla completa', exitFullscreen: 'Salir de pantalla completa',
                printChart: 'Imprimir', downloadPNG: 'Descargar imagen PNG', downloadJPEG: 'Descargar imagen JPEG', downloadSVG: 'Descargar imagen SVG',
                downloadCSV: 'Descargar CSV', downloadXLS: 'Descargar Excel', viewData: 'Ver tabla de datos', hideData: 'Ocultar tabla de datos', noData: 'Sin datos'
            },
            chart: { backgroundColor: 'transparent', style: { fontFamily: FUENTE } },
            title: { text: null }, credits: { enabled: false }, accessibility: { enabled: false },
            tooltip: { backgroundColor: 'rgba(255,255,255,0.96)', borderWidth: 1, borderColor: 'rgba(78,115,223,0.15)', borderRadius: 14, padding: 10, shadow: false, style: { fontSize: '12.5px', color: '#34353d' } },
            xAxis: { lineWidth: 0, tickWidth: 0, labels: { style: { color: '#5a5c69', fontSize: '11.5px' } } },
            yAxis: { gridLineWidth: 0, labels: { enabled: false }, title: { text: null } },
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
        alVisible('grafico-diagnosticos', () => barras('grafico-diagnosticos', <?php echo json_encode($cat_diag, JSON_UNESCAPED_UNICODE); ?>, <?php echo json_encode($data_diag); ?>, 'Casos diagnosticados'));
    });
    </script>

    <!-- MOTOR DE FILTROS EN CASCADA CON AUTO-RECARGA -->
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
