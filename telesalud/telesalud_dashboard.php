<?php
include("../cabf.php");
include("../inc.config.php");

// Asignación de variables de sesión obligatorias
$idusuario_ss = $_SESSION['idusuario_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$gestion      = date("Y");

// Filtros compartidos entre pestañas, navegación en píldora, estilos y REGLAS DE PRODUCCIÓN
include("inc_telemedicina.php");

// =========================================================================
// FASE 1: FILTROS Y CATÁLOGOS
// =========================================================================
$es_fecha = function ($f) { return is_string($f) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $f) && strtotime($f) !== false; };
$inicio       = (isset($_GET['fecha_inicio']) && $es_fecha($_GET['fecha_inicio'])) ? $_GET['fecha_inicio'] : date('Y-m-01');
$finalizacion = (isset($_GET['fecha_fin']) && $es_fecha($_GET['fecha_fin'])) ? $_GET['fecha_fin'] : date('Y-m-d');

$g_dep = isset($_GET['iddepartamento']) ? (string)$_GET['iddepartamento'] : '';
$g_mun = isset($_GET['idmunicipio']) ? (string)$_GET['idmunicipio'] : '';
$g_est = isset($_GET['idestablecimiento']) ? (string)$_GET['idestablecimiento'] : '';
$g_med = isset($_GET['idusuario_medico']) ? (string)$_GET['idusuario_medico'] : '';
$js_dep = $g_dep !== '' ? json_encode($g_dep) : 'null';
$js_mun = $g_mun !== '' ? json_encode($g_mun) : 'null';
$js_est = $g_est !== '' ? json_encode($g_est) : 'null';
$js_med = $g_med !== '' ? json_encode($g_med) : 'null';

// Catálogos de los filtros, recortados al alcance del usuario (inc_telemedicina.php)
list($deptos, $munis, $eess, $medicos) = tm_catalogos($link);

// Periodo actual, periodo de comparación (mes o gestión anterior) y agrupación de la tendencia
$dt_ini = new DateTime($inicio);
$dt_fin = new DateTime($finalizacion);
$dias_periodo = max(1, (int)$dt_ini->diff($dt_fin)->format('%r%a') + 1);
list($dt_prev_ini, $dt_prev_fin) = tm_periodo_anterior($dt_ini, $dt_fin); // mismos días del mes anterior, o mismas fechas de la gestión anterior
$agrupar_mes = $dias_periodo > 92;

// =========================================================================
// FASE 2: CÁLCULO DE LOS DATOS (se ejecuta DESPUÉS de mostrar el indicador de carga; ver más abajo)
//   Todas las cifras se calculan una vez y se guardan 10 minutos en la sesión del usuario:
//   al volver a Consolidado con los mismos filtros la página aparece al instante. "Actualizar" fuerza el recálculo.
// =========================================================================
$calcular_central = function () use ($link, $inicio, $finalizacion, $dt_prev_ini, $dt_prev_fin, $agrupar_mes, $deptos) {
    $consulta = function ($sql) use ($link) { $res = mysqli_query($link, $sql); $filas = []; if ($res) { while ($x = mysqli_fetch_assoc($res)) { $filas[] = $x; } } return $filas; };

    // Producción (mismas reglas que las pestañas, definidas en inc_telemedicina.php)
    $prod        = tm_produccion($link, $inicio, $finalizacion, $agrupar_mes ? 'mes' : 'dia');
    $prod_prev   = tm_produccion($link, $dt_prev_ini->format('Y-m-d'), $dt_prev_fin->format('Y-m-d'));
    $unicos      = tm_unicos($link, $inicio, $finalizacion);
    $unicos_prev = tm_unicos($link, $dt_prev_ini->format('Y-m-d'), $dt_prev_fin->format('Y-m-d'));

    // Condiciones trazadoras: los diagnósticos de los 4 procesos se traen UNA sola vez y se clasifican en PHP
    // (antes: 16 consultas que recalculaban toda la lista de diagnósticos)
    $trazadoras = [];
    foreach (tm_trazadoras() as $k => $t) {
        $trazadoras[$k] = ['titulo' => $t[0], 'icono' => $t[1], 'color' => $t[2], 'criterio' => $t[4],
            'pac' => [], 'serv' => [], 'proc' => [], 'dx' => [], 'tipo' => []];
    }
    // Orden de registro: así el PRIMER diagnóstico de cada condición en cada servicio llega primero
    $res_dx = mysqli_query($link, "SELECT pt.proceso, pt.sid, pt.pac, pt.cie, pt.patologia FROM (" . tm_sql_diagnosticos($link, $inicio, $finalizacion) . ") pt ORDER BY pt.proceso, pt.sid, pt.dxid");
    if ($res_dx) {
        while ($x = mysqli_fetch_assoc($res_dx)) {
            $serv_id = $x['proceso'] . '-' . $x['sid'];
            foreach ($trazadoras as $k => $t) {
                if (!tm_trazadora_cumple($k, $x['cie'])) { continue; }
                $trazadoras[$k]['pac'][$x['pac']] = true;
                $trazadoras[$k]['proc'][$x['proceso']][$serv_id] = true;
                if ($k === 'oncologico') { $trazadoras[$k]['tipo'][tm_tipo_oncologico($x['cie'])][$x['pac']] = true; }
                // Lista de diagnósticos: cada servicio se cuenta UNA vez por condición, en su primer diagnóstico de esa condición
                // (si el diagnóstico 1 es HTA y el 3 es de embarazo, en "Embarazo de riesgo" cuenta el 3; un 2.º de embarazo se ignora)
                if (isset($trazadoras[$k]['serv'][$serv_id])) { continue; }
                $trazadoras[$k]['serv'][$serv_id] = true;
                $dk = trim($x['cie']) . '|' . $x['patologia'];
                $trazadoras[$k]['dx'][$dk] = (isset($trazadoras[$k]['dx'][$dk]) ? $trazadoras[$k]['dx'][$dk] : 0) + 1;
            }
        }
    }
    foreach ($trazadoras as $k => $t) {
        $top = [];
        foreach ($t['dx'] as $dk => $n) { list($cie, $pat) = explode('|', $dk, 2); $top[] = ['cie' => $cie, 'patologia' => $pat, 'serv' => $n]; }
        usort($top, function ($a, $b) { return $b['serv'] - $a['serv'] ?: strcmp($a['cie'], $b['cie']); });
        $visibles = array_slice($top, 0, 8);
        $otros = array_slice($top, 8);
        $trazadoras[$k] = ['titulo' => $t['titulo'], 'icono' => $t['icono'], 'color' => $t['color'], 'criterio' => $t['criterio'],
            'pacientes' => count($t['pac']), 'servicios' => count($t['serv']),
            'por_proceso' => array_map('count', $t['proc']),
            'top' => $visibles,
            // "Otros diagnósticos": el resto, para que la lista sume exactamente los servicios
            'otros_serv' => array_sum(array_column($otros, 'serv')), 'otros_dx' => count($otros),
            'desglose' => array_map('count', $t['tipo'])];
    }

    $serv = "COUNT(DISTINCT CONCAT(pt.proceso, '-', pt.sid))"; // servicios únicos (un servicio con varios diagnósticos cuenta una vez)

    // Grupo priorizado (reglas de los reportes Excel; un servicio puede pertenecer a varios grupos)
    $nombres_grupo = ['D' => 'Discapacidad', 'ENT' => 'Enfermedades no transmisibles', 'ET' => 'Enfermedades transmisibles', 'SI' => 'Salud infantil', 'SM' => 'Salud materna', 'OTROS' => 'Otros'];
    $grupos = [];
    foreach ($consulta("SELECT pt.grupo, pt.proceso, $serv AS serv FROM (" . tm_sql_grupos($link, $inicio, $finalizacion) . ") pt GROUP BY pt.grupo, pt.proceso") as $x) {
        $g = $x['grupo'];
        if (!isset($grupos[$g])) { $grupos[$g] = ['nombre' => $nombres_grupo[$g], 'sigla' => $g === 'OTROS' ? '' : $g, 'total' => 0, 'proc' => []]; }
        $grupos[$g]['proc'][$x['proceso']] = (int)$x['serv'];
        $grupos[$g]['total'] += (int)$x['serv'];
    }
    // Base del porcentaje: todos los servicios del periodo (en telemetrías, cada atención)
    $serv_total = $consulta("SELECT $serv AS serv FROM (" . tm_sql_servicios($link, $inicio, $finalizacion) . ") pt");
    $serv_total = $serv_total ? (int)$serv_total[0]['serv'] : 0;
    uasort($grupos, function ($a, $b) { return $b['total'] - $a['total']; });

    // Pirámide poblacional: beneficiarios ÚNICOS, edad cumplida a su primera atención del periodo, por sexo
    $piramide = ['h' => array_fill(0, 17, 0), 'm' => array_fill(0, 17, 0)];
    $sin_dato_piramide = 0;
    foreach ($consulta("SELECT g.genero, CASE WHEN n.fecha_nac IS NULL OR n.fecha_nac = '0000-00-00' THEN NULL ELSE TIMESTAMPDIFF(YEAR, n.fecha_nac, u.f) END AS edad
            FROM (SELECT x.pac, MIN(x.fecha) AS f FROM (" . tm_sql_pacientes($link, $inicio, $finalizacion) . ") x GROUP BY x.pac) u
            LEFT JOIN nombre n ON n.idnombre = u.pac LEFT JOIN genero g ON g.idgenero = n.idgenero") as $x) {
        $sexo = mb_strtoupper(trim((string)$x['genero']));
        if ($x['edad'] === null || (int)$x['edad'] < 0 || ($sexo !== 'MASCULINO' && $sexo !== 'FEMENINO')) { $sin_dato_piramide++; continue; }
        $i = min(16, (int)floor((int)$x['edad'] / 5));
        $piramide[$sexo === 'MASCULINO' ? 'h' : 'm'][$i]++;
    }

    // Grupos vulnerables (solo se registran en teleconsultas y telemetrías)
    $f_at = tm_filtros_sql($link)['atencion'];
    $vul_ninguna = 0; $vul_lista = [];
    foreach ($consulta("SELECT gv.grupo_vulnerable AS grupo, COUNT(DISTINCT a.idatencion_psafci) AS n
        FROM atencion_psafci a INNER JOIN atencion_grupo_vulnerable agv ON agv.idatencion_psafci = a.idatencion_psafci
        INNER JOIN grupo_vulnerable gv ON gv.idgrupo_vulnerable = agv.idgrupo_vulnerable
        WHERE a.fecha_registro BETWEEN '$inicio' AND '$finalizacion'
          AND (a.idtipo_atencion = '3' OR (a.idtipo_atencion = '4' AND " . tm_cond_atencion_telemetria() . ")) $f_at
        GROUP BY gv.grupo_vulnerable ORDER BY n DESC") as $x) {
        if (mb_strtoupper(trim($x['grupo'])) === 'NINGUNA') { $vul_ninguna = (int)$x['n']; } else { $vul_lista[] = ['nombre' => mb_convert_case(mb_strtolower(trim($x['grupo'])), MB_CASE_TITLE), 'n' => (int)$x['n']]; }
    }

    // Producción por departamento (cada proceso según su rol: origen, especialista o atención)
    $nom_dep = []; foreach ($deptos as $d) { $nom_dep[(string)$d['id']] = mb_convert_case(mb_strtolower($d['nombre']), MB_CASE_TITLE); }
    $por_dep = [];
    foreach (tm_def_procesos($link) as $clave => $p) {
        foreach ($consulta("SELECT $p[dep] AS dep, $p[cnt] AS total $p[from] WHERE $p[fecha] BETWEEN '$inicio' AND '$finalizacion' AND $p[where] GROUP BY $p[dep]") as $x) {
            $id = $x['dep'] === null ? 'sd' : (string)$x['dep'];
            if (!isset($por_dep[$id])) { $por_dep[$id] = ['nombre' => isset($nom_dep[$id]) ? $nom_dep[$id] : 'Sin departamento', 'total' => 0]; }
            $por_dep[$id][$clave] = (int)$x['total']; $por_dep[$id]['total'] += (int)$x['total'];
        }
    }
    uasort($por_dep, function ($a, $b) { return $b['total'] - $a['total']; });

    return compact('prod', 'prod_prev', 'unicos', 'unicos_prev', 'trazadoras', 'grupos', 'serv_total', 'piramide', 'sin_dato_piramide', 'vul_ninguna', 'vul_lista', 'por_dep');
};

// Caché de la sesión: clave = filtros efectivos (ya recortados al alcance del usuario) + periodo
$cache_ttl = 600; // 10 minutos
$cache_clave = md5(json_encode([$inicio, $finalizacion, $g_dep, $g_mun, $g_est, $g_med, 'central-v3']));
$cache_central = (isset($_SESSION['tm_cache_central']) && is_array($_SESSION['tm_cache_central'])) ? $_SESSION['tm_cache_central'] : [];
foreach ($cache_central as $ck => $cv) { if (!isset($cv['t']) || time() - $cv['t'] > $cache_ttl) { unset($cache_central[$ck]); } }
$en_cache = !isset($_GET['refrescar']) && isset($cache_central[$cache_clave]);
unset($_GET['refrescar']); // que los enlaces de la página (chips) no vuelvan a forzar el recálculo

// =========================================================================
// FASE 3: PRESENTACIÓN
// =========================================================================
$pagina = 'telesalud_dashboard.php';
$pestana = 'consolidado';
$meses_es = ['', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
$fecha_larga = function (DateTime $f) use ($meses_es) { return (int)$f->format('j') . ' de ' . $meses_es[(int)$f->format('n')] . ' de ' . $f->format('Y'); };
$texto_periodo = 'Del ' . $fecha_larga($dt_ini) . ' al ' . $fecha_larga($dt_fin);
$ahora = new DateTime('now', new DateTimeZone('America/La_Paz'));
$h = function ($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); };

$buscar_nombre = function ($lista, $id) { foreach ($lista as $it) { if ((string)$it['id'] === (string)$id) { return $it['nombre']; } } return $id; };
$url_sin = function ($claves) use ($pagina) { $q = $_GET; foreach ($claves as $c) { unset($q[$c]); } return $pagina . (count($q) ? '?' . http_build_query($q) : ''); };
$chips = [];
if ($g_dep !== '') { $chips[] = ['fa-map', $buscar_nombre($deptos, $g_dep), (tm_es_fijo('iddepartamento') ? '' : $url_sin(['iddepartamento', 'idmunicipio', 'idestablecimiento']))]; }
if ($g_mun !== '') { $chips[] = ['fa-map-marker-alt', $buscar_nombre($munis, $g_mun), (tm_es_fijo('idmunicipio') ? '' : $url_sin(['idmunicipio', 'idestablecimiento']))]; }
if ($g_est !== '') { $chips[] = ['fa-hospital', $buscar_nombre($eess, $g_est), $url_sin(['idestablecimiento'])]; }
if ($g_med !== '') { $chips[] = ['fa-user-md', $buscar_nombre($medicos, $g_med), $url_sin(['idusuario_medico'])]; }

// Variación contra el mes o la gestión anterior (subir = bueno en producción)
$variacion = function ($actual, $anterior) {
    if ($anterior == 0 && $actual == 0) { return ['—', 'neutro', 'Sin cambios vs ' . tm_etq_anterior(true)]; }
    if ($anterior == 0) { return ['Nuevo', 'bueno', 'Sin registros en ' . tm_etq_anterior(true, true)]; }
    $pct = round((($actual - $anterior) / $anterior) * 100);
    if ($pct == 0) { return ['0%', 'neutro', 'Igual que ' . tm_etq_anterior(true, true)]; }
    return [($pct > 0 ? '▲ ' : '▼ ') . abs($pct) . '%', $pct > 0 ? 'bueno' : 'malo', ucfirst(tm_etq_anterior(true)) . ': ' . number_format($anterior)];
};
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SISTEMA MEDI-SAFCI - Central de Telesalud</title>

    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <?php tm_estilos(); ?>
    <style>
        /* ---------- Central: buscador, tabla de producción y acciones ---------- */
        .px .buscador { display: flex; align-items: center; gap: 0; padding: 4px 4px 4px 16px; border-radius: 999px; min-width: 300px; }
        .px .buscador i { color: var(--n-700); }
        .px .buscador input { flex: 1; border: 0; background: transparent; outline: none; font-family: inherit; font-size: 13px; color: var(--n-900); padding: 8px 10px; min-width: 0; }
        .px .buscador button { border: 0; border-radius: 999px; background: var(--p); color: var(--blanco); font-family: inherit; font-size: 13px; font-weight: 500; padding: 8px 16px; cursor: pointer; transition: background var(--t); }
        .px .buscador button:hover { background: var(--p-osc); }
        .px .encabezado .der { display: flex; flex-direction: column; align-items: flex-end; gap: 10px; }

        .px .tabla-prod { width: 100%; border-collapse: separate; border-spacing: 0; }
        .px .tabla-prod th { font-size: 11.5px; font-weight: 500; color: var(--n-700); padding: 6px 10px 10px; border-bottom: 1px solid rgba(var(--p-rgb), .12); white-space: nowrap; }
        .px .tabla-prod td { padding: 12px 10px; border-bottom: 1px solid rgba(var(--p-rgb), .08); vertical-align: middle; }
        .px .tabla-prod tbody tr { transition: background var(--t); }
        .px .tabla-prod tbody tr:hover td { background: rgba(var(--p-rgb), .04); }
        .px .tabla-prod .r { text-align: right; }
        .px .tabla-prod .proc { display: flex; align-items: center; gap: 12px; font-size: 14px; color: var(--n-900); }
        .px .tabla-prod .proc .pildora-ico { color: var(--cc); background: rgba(var(--cc-rgb), .12); border-color: rgba(var(--cc-rgb), .25); }
        .px .tabla-prod .num { font-size: 22px; font-weight: 300; color: var(--n-900); letter-spacing: -.5px; }
        .px .tabla-prod .pct { min-width: 140px; }
        .px .tabla-prod .pct small { font-size: 12px; color: var(--n-700); }
        .px .tabla-prod .pct .pista { height: 6px; border-radius: 6px; background: rgba(var(--p-rgb), .08); overflow: hidden; margin-top: 5px; }
        .px .tabla-prod .pct .pista span { display: block; height: 100%; width: 0; border-radius: 6px; background: var(--cc); transition: width 1.1s cubic-bezier(.2, .8, .2, 1); }
        .px .tabla-prod tfoot td { border-bottom: 0; padding-top: 14px; font-weight: 500; }
        .px .tabla-prod tfoot .num { font-weight: 400; }
        .px .nota { display: flex; gap: 8px; align-items: flex-start; font-size: 12px; color: var(--n-700); margin-top: 14px; padding: 10px 12px; border-radius: 14px; background: rgba(var(--p-rgb), .05); }
        .px .nota i { color: var(--p); margin-top: 2px; }
        .px .mini-cifras { display: flex; gap: 22px; flex-wrap: wrap; }
        .px .mini-cifras b { display: block; font-size: 22px; font-weight: 300; color: var(--n-900); }

        .px .acciones { display: flex; flex-wrap: wrap; justify-content: center; gap: 12px; margin: 6px 0 22px; }
        .px .btn-pildora { display: inline-flex; align-items: center; gap: 8px; border-radius: 999px; padding: 11px 22px; font-family: inherit; font-size: 14px; font-weight: 500; cursor: pointer; transition: transform var(--t), box-shadow var(--t), background var(--t); border: 1px solid var(--borde); }
        .px .btn-pildora.primario { background: var(--p); color: var(--blanco); border-color: var(--p); box-shadow: 0 6px 18px rgba(var(--p-rgb), .3); }
        .px .btn-pildora.primario:hover { background: var(--p-osc); transform: translateY(-1px); }
        .px .btn-pildora.secundario { background: var(--vidrio); color: var(--n-900); }
        .px .btn-pildora.secundario:hover { box-shadow: var(--sombra-hover); transform: translateY(-1px); }
        .px .btn-pildora:disabled { opacity: .75; cursor: default; transform: none; }
        .px .control-anio { display: flex; align-items: center; justify-content: center; gap: 18px; margin-bottom: 18px; }
        .px .control-anio button { width: 40px; height: 40px; border-radius: 50%; border: 1px solid var(--borde); background: var(--vidrio); color: var(--p); cursor: pointer; transition: transform var(--t); }
        .px .control-anio button:hover { transform: scale(1.06); }
        .px .control-anio h4 { margin: 0; font-size: 22px; font-weight: 500; color: var(--p-osc); }

        /* ---------- Producción por departamento (desplegable) ---------- */
        .px .btn-despliegue { display: inline-flex; align-items: center; gap: 8px; margin-top: 14px; border: 1px solid var(--borde); background: var(--blanco); color: var(--p-osc); border-radius: 999px; padding: 7px 16px; font-family: inherit; font-size: 13px; font-weight: 500; cursor: pointer; transition: background var(--t); }
        .px .btn-despliegue:hover { background: rgba(var(--p-rgb), .06); }
        .px .btn-despliegue i { transition: transform var(--t); }
        .px .btn-despliegue[aria-expanded="true"] i { transform: rotate(180deg); }
        .px .tabla-dep-wrap { max-height: 0; overflow: hidden; transition: max-height .4s cubic-bezier(.2, .8, .2, 1); }
        .px .tabla-dep-wrap.abierto { max-height: 900px; overflow-y: auto; }
        .px .tabla-dep { width: 100%; margin-top: 12px; font-size: 13px; }
        .px .tabla-dep th { font-weight: 500; color: var(--n-700); font-size: 11.5px; padding: 6px 8px; border-bottom: 1px solid rgba(var(--p-rgb), .12); text-align: right; white-space: nowrap; }
        .px .tabla-dep th:first-child, .px .tabla-dep td:first-child { text-align: left; }
        .px .tabla-dep td { padding: 8px; border-bottom: 1px solid rgba(var(--p-rgb), .07); text-align: right; color: var(--n-900); }
        .px .tabla-dep td.cero { color: var(--n-500); }
        .px .tabla-dep td b { font-weight: 600; }
        .px .tabla-dep .punto { display: inline-block; width: 8px; height: 8px; border-radius: 3px; margin-right: 6px; }

        /* ---------- Sección y condiciones trazadoras ---------- */
        .px .seccion { display: flex; align-items: baseline; justify-content: space-between; flex-wrap: wrap; gap: 8px; margin: 4px 2px 14px; }
        .px .seccion h5 { margin: 0; font-size: 20px; font-weight: 500; color: var(--p-osc); }
        .px .seccion span { font-size: 12.5px; color: var(--n-700); }
        .px .grid-5 { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: var(--gap); margin-bottom: var(--gap); }
        .px .traz .pildora-ico { color: var(--cc); background: rgba(var(--cc-rgb), .12); border-color: rgba(var(--cc-rgb), .25); }
        .px .traz .cifra { font-size: 44px; }
        .px .traz .cifra-sub { font-size: 12.5px; color: var(--n-700); margin-top: 4px; }
        .px .traz .prop { margin-top: 14px; }
        .px .traz .leyenda-proc { display: flex; flex-wrap: wrap; gap: 4px 10px; margin-top: 8px; font-size: 11.5px; color: var(--n-700); }
        .px .traz .leyenda-proc i { display: inline-block; width: 8px; height: 8px; border-radius: 3px; margin-right: 4px; }
        .px .traz .desglose-onco { display: flex; flex-direction: column; gap: 6px; margin-top: 12px; padding: 10px 12px; border-radius: 14px; background: rgba(var(--cc-rgb), .06); }
        .px .traz .desglose-onco div { display: flex; justify-content: space-between; align-items: center; font-size: 12.5px; color: var(--n-700); }
        .px .traz .desglose-onco b { color: var(--n-900); font-weight: 600; }
        .px .traz .desglose-onco i.p { display: inline-block; width: 8px; height: 8px; border-radius: 50%; margin-right: 6px; }
        .px .traz .top-dx { margin-top: 14px; padding-top: 12px; border-top: 1px dashed rgba(var(--p-rgb), .18); display: flex; flex-direction: column; gap: 7px; }
        .px .traz .top-dx div { display: flex; justify-content: space-between; gap: 8px; font-size: 12.5px; color: var(--n-900); }
        .px .traz .top-dx div span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .px .traz .top-dx div span small { color: var(--n-700); margin-right: 4px; }
        .px .traz .top-dx div b { font-weight: 600; flex-shrink: 0; }
        .px .traz .top-dx { gap: 6px; }
        .px .traz .top-dx div { font-size: 12px; }
        .px .traz .top-dx .otros-dx { padding-top: 6px; border-top: 1px dotted rgba(var(--p-rgb), .2); color: var(--n-700); }
        .px .traz .top-dx .otros-dx small { color: var(--n-700); }
        .px .traz .cifra-fila { display: flex; align-items: baseline; gap: 8px; flex-wrap: wrap; }
        .px .traz .cifra-etq { font-size: 14px; font-weight: 500; color: var(--n-700); }
        .px .traz .vacio { min-height: 120px; }

        /* ---------- Grupo priorizado ---------- */
        .px .lista-grupos { display: flex; flex-direction: column; gap: 16px; margin-top: 6px; }
        .px .lista-grupos .nom { display: flex; justify-content: space-between; gap: 8px; font-size: 13px; color: var(--n-900); margin-bottom: 6px; }
        .px .lista-grupos .nom small { color: var(--n-700); }
        .px .lista-grupos .nom b { font-weight: 600; white-space: nowrap; }
        .px .lista-grupos .pista-g { display: flex; height: 10px; border-radius: 10px; background: rgba(var(--p-rgb), .08); overflow: hidden; }
        .px .lista-grupos .pista-g span { height: 100%; width: 0; transition: width 1.1s cubic-bezier(.2, .8, .2, 1); }
        .px .lista-grupos .pista-g span + span { border-left: 2px solid var(--blanco); }

        @media (max-width: 1599.98px) { .px .grid-5 { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
        @media (max-width: 991.98px) { .px .grid-5 { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media (max-width: 575.98px) { .px .grid-5 { grid-template-columns: minmax(0, 1fr); } }

        /* Modal de la matriz (fuera de .px) */
        #modalMatrizGlobal .modal-content { border-radius: 22px; overflow: hidden; border: 1px solid rgba(78, 115, 223, .16); }
        #modalMatrizGlobal .modal-header { background: #eef2fb; border-bottom: 1px solid rgba(78, 115, 223, .12); }
        #modalMatrizGlobal .modal-title { font-family: 'Outfit', 'Segoe UI', Arial, sans-serif; font-weight: 500; color: #224abe; }
        .modal-fullscreen { width: 100vw !important; max-width: 100vw !important; height: 100vh !important; margin: 0 !important; }
        .modal-fullscreen .modal-content { height: 100vh !important; border-radius: 0 !important; }
        @media (max-width: 767.98px) { .px .buscador { min-width: 0; width: 100%; } .px .encabezado .der { align-items: stretch; width: 100%; } }
    </style>
</head>

<body id="page-top">
<div id="wrapper">
    <?php include("../menu.php"); ?>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include("../top_bar.php"); ?>

            <div class="container-fluid mt-4 px">
                <?php
                // Indicador de carga: se envía al navegador ANTES de calcular, así el médico ve que la Central está trabajando
                tm_cargador('Cargando Central de Telesalud', !$en_cache);
                if (!$en_cache) { @ob_flush(); @flush(); }

                // =========================================================================
                // DATOS: desde la caché de la sesión o recién calculados
                // =========================================================================
                if ($en_cache) {
                    $datos_central = $cache_central[$cache_clave]['datos'];
                    $datos_hora = $cache_central[$cache_clave]['t'];
                } else {
                    $datos_central = $calcular_central();
                    $datos_hora = time();
                    $cache_central[$cache_clave] = ['t' => $datos_hora, 'datos' => $datos_central];
                    if (count($cache_central) > 4) { uasort($cache_central, function ($a, $b) { return $b['t'] - $a['t']; }); $cache_central = array_slice($cache_central, 0, 4, true); }
                }
                $_SESSION['tm_cache_central'] = $cache_central;
                extract($datos_central);
                $hora_datos = (new DateTime('@' . $datos_hora))->setTimezone(new DateTimeZone('America/La_Paz'));
                $minutos_datos = (int)floor((time() - $datos_hora) / 60);

                // Derivados (rápidos): totales, tendencia, pirámide, variaciones y filas de la tabla
                $total_servicios = 0; $total_prev = 0;
                foreach ($prod as $k => $p) { $total_servicios += $p['total']; $total_prev += $prod_prev[$k]['total']; }

                // Tendencia: cubetas por día (o por mes si el rango supera 92 días)
                $tend_claves = []; $tend_lbl = [];
                if ($dt_fin >= $dt_ini) {
                    $p_ini = $agrupar_mes ? new DateTime($dt_ini->format('Y-m-01')) : clone $dt_ini;
                    $p_fin = clone $dt_fin; $p_fin->modify('+1 day');
                    foreach (new DatePeriod($p_ini, new DateInterval($agrupar_mes ? 'P1M' : 'P1D'), $p_fin) as $f) {
                        $tend_claves[] = $f->format($agrupar_mes ? 'Y-m' : 'Y-m-d');
                        $tend_lbl[] = $f->format($agrupar_mes ? 'm/Y' : 'd/m');
                    }
                }
                $tend_et = tm_etiquetas_tendencia($tend_lbl, $agrupar_mes);
                $tend_series = [];
                foreach ($tm_procesos as $k => $meta) {
                    $datos = []; foreach ($tend_claves as $c) { $datos[] = isset($prod[$k]['serie'][$c]) ? $prod[$k]['serie'][$c] : 0; }
                    $tend_series[] = ['name' => $meta[0], 'color' => $meta[1], 'data' => $datos];
                }
                $tend_totales = []; foreach ($tend_claves as $i => $c) { $s = 0; foreach ($tend_series as $se) { $s += $se['data'][$i]; } $tend_totales[] = $s; }
                $tend_pico = $tend_totales ? max($tend_totales) : 0;
                $tend_promedio = count($tend_totales) ? round(array_sum($tend_totales) / count($tend_totales), 1) : 0;

                $grupo_max = 1; foreach ($grupos as $g) { $grupo_max = max($grupo_max, $g['total']); }
                $grupos_edad = ['0-4', '5-9', '10-14', '15-19', '20-24', '25-29', '30-34', '35-39', '40-44', '45-49', '50-54', '55-59', '60-64', '65-69', '70-74', '75-79', '80+'];
                $total_h = array_sum($piramide['h']); $total_m = array_sum($piramide['m']);
                $vul_max = 1; foreach ($vul_lista as $x) { $vul_max = max($vul_max, $x['n']); }

                $v_total = $variacion($total_servicios, $total_prev);
                $v_pac   = $variacion($unicos['pacientes'], $unicos_prev['pacientes']);
                $v_est   = $variacion($unicos['establecimientos'], $unicos_prev['establecimientos']);

                // Filas de la tabla de producción
                $filas_prod = [];
                foreach ($tm_procesos as $k => $meta) {
                    $rgb = sscanf($meta[1], "#%02x%02x%02x");
                    $filas_prod[] = ['clave' => $k, 'nombre' => $meta[0], 'color' => $meta[1], 'rgb' => implode(', ', $rgb), 'icono' => $meta[2],
                        'total' => $prod[$k]['total'], 'pacientes' => $prod[$k]['pacientes'], 'pct' => $total_servicios > 0 ? $prod[$k]['total'] / $total_servicios * 100 : 0,
                        'var' => $variacion($prod[$k]['total'], $prod_prev[$k]['total'])];
                }
                ?>

                <!-- ===================== ENCABEZADO ===================== -->
                <div class="encabezado aparece">
                    <div>
                        <h1>Central de Telesalud</h1>
                        <div class="meta">
                            <span><i class="far fa-calendar-alt mr-1"></i><?php echo $h($texto_periodo); ?> · <?php echo $dias_periodo; ?> día<?php echo $dias_periodo == 1 ? '' : 's'; ?></span>
                            <span class="d-inline-flex align-items-center" style="gap: 8px;" title="Las cifras se guardan 10 minutos para que la Central abra al instante al volver a ella">
                                <span class="punto-vivo" aria-hidden="true"></span> Datos de las <?php echo $hora_datos->format('H:i'); ?><?php echo $minutos_datos > 0 ? ' (hace ' . $minutos_datos . ' min)' : ''; ?>
                                <a href="<?php echo $h($pagina . '?refrescar=1'); ?>" class="btn-actualizar" title="Volver a calcular con los datos más recientes"><i class="fas fa-sync-alt"></i> Actualizar</a>
                            </span>
                        </div>
                    </div>
                    <div class="der">
                        <?php tm_nav($pestana); ?>
                        <form action="valida_busqueda_telesalud.php" method="POST" class="buscador vidrio" role="search">
                            <i class="fas fa-search" aria-hidden="true"></i>
                            <input type="text" name="ci" placeholder="CI, código PSAFCI, REF o ENC" aria-label="Buscar beneficiario o caso" required>
                            <button type="submit">Buscar</button>
                        </form>
                    </div>
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

                <!-- ===================== RESUMEN: PRODUCCIÓN POR PROCESO + CIFRAS ===================== -->
                <div class="resumen aparece">
                    <div class="segmentos" role="img" aria-label="Producción por proceso de telemedicina">
                        <?php if ($total_servicios == 0) { ?>
                            <div class="etq"><i class="far fa-folder-open mr-1"></i> No hay producción para este filtro</div>
                        <?php } foreach ($filas_prod as $fp) { if ($fp['total'] <= 0) { continue; } list($fondo_seg, $texto_seg) = tm_colores_legibles($fp['color']); ?>
                            <div class="seg cc" data-grow="<?php echo round(max($fp['pct'], 6), 2); ?>" style="flex: 0 1 0%; --cc: <?php echo $fondo_seg; ?>; --cc-txt: <?php echo $texto_seg; ?>;" title="<?php echo $h($fp['nombre'] . ': ' . number_format($fp['total']) . ' (' . round($fp['pct']) . '%)'); ?>">
                                <span class="etq"><i class="fas <?php echo $fp['icono']; ?>" aria-hidden="true"></i><?php echo $h($fp['nombre']); ?> <b><?php echo number_format($fp['total']); ?></b></span>
                                <div class="barra"><?php echo round($fp['pct']); ?>%</div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="cifras">
                        <div class="item">
                            <span class="cifra contador-animado" data-objetivo="<?php echo $total_servicios; ?>">0</span>
                            <span class="pie"><span class="pildora-ico"><i class="fas fa-hand-holding-medical"></i></span><span class="etq">Servicios</span>
                                <span class="delta <?php echo $v_total[1]; ?>" title="<?php echo $h($v_total[2]); ?>"><?php echo $h($v_total[0]); ?></span></span>
                        </div>
                        <div class="item">
                            <span class="cifra contador-animado" data-objetivo="<?php echo $unicos['pacientes']; ?>">0</span>
                            <span class="pie"><span class="pildora-ico"><i class="fas fa-users"></i></span><span class="etq">Beneficiarios</span>
                                <span class="delta <?php echo $v_pac[1]; ?>" title="<?php echo $h($v_pac[2]); ?>"><?php echo $h($v_pac[0]); ?></span></span>
                        </div>
                        <div class="item">
                            <span class="cifra contador-animado" data-objetivo="<?php echo $unicos['establecimientos']; ?>">0</span>
                            <span class="pie"><span class="pildora-ico"><i class="fas fa-hospital"></i></span><span class="etq">Establecimientos</span>
                                <span class="delta <?php echo $v_est[1]; ?>" title="<?php echo $h($v_est[2]); ?>"><?php echo $h($v_est[0]); ?></span></span>
                        </div>
                    </div>
                </div>

                <!-- ===================== TABLA DE PRODUCCIÓN + TENDENCIA ===================== -->
                <div class="grid">
                    <div class="vidrio card-p g-mapa aparece" style="animation-delay: .05s;">
                        <div class="cab-card">
                            <div><h6 class="titulo-card">Producción total</h6><div class="sub-card">Servicios de telemedicina por proceso</div></div>
                            <span class="pildora-ico"><i class="fas fa-table"></i></span>
                        </div>
                        <div class="table-responsive">
                            <table class="tabla-prod">
                                <thead>
                                    <tr><th>Proceso</th><th class="r">Servicios</th><th>% del total</th><th class="r">Beneficiarios</th><th class="r">vs <?php echo $h(tm_etq_anterior()); ?></th></tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($filas_prod as $fp) { ?>
                                    <tr style="--cc: <?php echo $fp['color']; ?>; --cc-rgb: <?php echo $fp['rgb']; ?>;">
                                        <td><span class="proc"><span class="pildora-ico"><i class="fas <?php echo $fp['icono']; ?>"></i></span><?php echo $h($fp['nombre']); ?></span></td>
                                        <td class="r"><span class="num"><?php echo number_format($fp['total']); ?></span></td>
                                        <td class="pct"><small><?php echo round($fp['pct'], 1); ?>%</small><div class="pista"><span data-ancho="<?php echo round($fp['pct'], 2); ?>"></span></div></td>
                                        <td class="r"><?php echo number_format($fp['pacientes']); ?></td>
                                        <td class="r"><span class="delta <?php echo $fp['var'][1]; ?>" title="<?php echo $h($fp['var'][2]); ?>"><?php echo $h($fp['var'][0]); ?></span></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td><span class="proc"><span class="pildora-ico"><i class="fas fa-layer-group"></i></span>Total</span></td>
                                        <td class="r"><span class="num"><?php echo number_format($total_servicios); ?></span></td>
                                        <td class="pct"><small>100%</small></td>
                                        <td class="r" title="Beneficiarios únicos: cada persona se cuenta una sola vez aunque haya usado varios procesos"><?php echo number_format($unicos['pacientes']); ?> <i class="fas fa-info-circle" style="color: var(--p); font-size: 11px;"></i></td>
                                        <td class="r"><span class="delta <?php echo $v_total[1]; ?>" title="<?php echo $h($v_total[2]); ?>"><?php echo $h($v_total[0]); ?></span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div>
                            <button type="button" class="btn-despliegue" id="btn-ver-dep" aria-expanded="false" aria-controls="tabla-dep"><i class="fas fa-chevron-down"></i> Ver por departamento</button>
                        </div>
                        <div class="tabla-dep-wrap" id="tabla-dep">
                            <?php if (empty($por_dep)) { ?>
                                <div class="vacio" style="min-height: 80px;">Sin producción en el periodo</div>
                            <?php } else { ?>
                            <table class="tabla-dep">
                                <thead><tr><th>Departamento</th><?php foreach ($tm_procesos as $meta) { ?><th><span class="punto" style="background: <?php echo $meta[1]; ?>;"></span><?php echo $h($meta[0]); ?></th><?php } ?><th>Total</th></tr></thead>
                                <tbody>
                                <?php foreach ($por_dep as $fila) { ?>
                                    <tr><td><?php echo $h($fila['nombre']); ?></td>
                                        <?php foreach ($tm_procesos as $k => $meta) { $v = isset($fila[$k]) ? $fila[$k] : 0; ?><td class="<?php echo $v ? '' : 'cero'; ?>"><?php echo number_format($v); ?></td><?php } ?>
                                        <td><b><?php echo number_format($fila['total']); ?></b></td></tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <div class="etq mt-2" style="font-size: 11.5px;">Generadas por departamento de origen · Respuestas por departamento del hospital especialista · Teleconsultas y Telemetrías por departamento de la atención.</div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="vidrio card-p g-mapa aparece" style="animation-delay: .1s;">
                        <div class="cab-card">
                            <div><h6 class="titulo-card">Tendencia de producción</h6><div class="sub-card">Servicios realizados por <?php echo $agrupar_mes ? 'mes' : 'día'; ?>, apilados por proceso</div></div>
                            <span class="pildora-ico"><i class="fas fa-chart-bar"></i></span>
                        </div>
                        <div class="mini-cifras">
                            <div><span class="etq">Pico por <?php echo $agrupar_mes ? 'mes' : 'día'; ?></span><b><?php echo number_format($tend_pico); ?></b></div>
                            <div><span class="etq">Promedio por <?php echo $agrupar_mes ? 'mes' : 'día'; ?></span><b><?php echo $tend_promedio; ?></b></div>
                        </div>
                        <div id="grafico-tendencia" style="height: 330px; margin-top: 8px;"><div class="esqueleto"></div></div>
                    </div>
                </div>

                <!-- ===================== CONDICIONES TRAZADORAS ===================== -->
                <div class="seccion aparece">
                    <h5>Condiciones trazadoras</h5>
                    <span>Beneficiarios con al menos un diagnóstico de la condición, en cualquiera de los 4 procesos</span>
                </div>
                <div class="grid-5">
                    <?php $ti = 0; foreach ($trazadoras as $k => $t) { $ti++; $rgb_t = implode(', ', sscanf($t['color'], "#%02x%02x%02x")); $suma_proc = array_sum($t['por_proceso']); ?>
                    <div class="vidrio card-p traz aparece" style="--cc: <?php echo $t['color']; ?>; --cc-rgb: <?php echo $rgb_t; ?>; animation-delay: <?php echo 0.04 * $ti; ?>s;">
                        <div class="cab-card">
                            <div><h6 class="titulo-card"><?php echo $h($t['titulo']); ?></h6><div class="sub-card" title="Criterio"><?php echo $h($t['criterio']); ?></div></div>
                            <span class="pildora-ico"><i class="fas <?php echo $t['icono']; ?>"></i></span>
                        </div>
                        <?php if ($t['pacientes'] == 0) { ?>
                            <div class="vacio"><i class="fas <?php echo $t['icono']; ?>"></i>Sin casos en el periodo</div>
                        <?php } else { ?>
                        <div>
                            <div class="cifra-fila"><span class="cifra contador-animado" data-objetivo="<?php echo $t['pacientes']; ?>">0</span><span class="cifra-etq"><?php echo $t['pacientes'] == 1 ? 'Beneficiario' : 'Beneficiarios'; ?></span></div>
                            <div class="cifra-sub"><?php echo number_format($t['servicios']); ?> <?php echo $t['servicios'] == 1 ? 'servicio' : 'servicios'; ?></div>
                        </div>
                        <div class="prop" title="Servicios por proceso">
                            <?php foreach ($tm_procesos as $pk => $meta) { if (!empty($t['por_proceso'][$pk])) { ?><span data-ancho="<?php echo round($t['por_proceso'][$pk] / max(1, $suma_proc) * 100, 2); ?>" style="background: <?php echo $meta[1]; ?>;" title="<?php echo $h($meta[0]) . ': ' . $t['por_proceso'][$pk]; ?>"></span><?php } } ?>
                        </div>
                        <div class="leyenda-proc">
                            <?php foreach ($tm_procesos as $pk => $meta) { if (!empty($t['por_proceso'][$pk])) { ?><span><i style="background: <?php echo $meta[1]; ?>;"></i><?php echo $h($meta[0]); ?> <?php echo $t['por_proceso'][$pk]; ?></span><?php } } ?>
                        </div>
                        <?php if ($k === 'oncologico') { ?>
                        <div class="desglose-onco" title="Un beneficiario puede tener diagnósticos de más de un tipo">
                            <div><span><i class="p" style="background: #b8392d;"></i>Cáncer</span><b><?php echo isset($t['desglose']['cancer']) ? $t['desglose']['cancer'] : 0; ?></b></div>
                            <div><span><i class="p" style="background: #fd7e14;"></i>Comportamiento incierto</span><b><?php echo isset($t['desglose']['incierto']) ? $t['desglose']['incierto'] : 0; ?></b></div>
                            <div><span><i class="p" style="background: #858796;"></i>Tumor benigno</span><b><?php echo isset($t['desglose']['benigno']) ? $t['desglose']['benigno'] : 0; ?></b></div>
                        </div>
                        <?php } ?>
                        <div class="top-dx">
                            <span class="etq">Diagnósticos más frecuentes</span>
                            <?php foreach ($t['top'] as $dx) { ?>
                                <div title="<?php echo $h($dx['cie'] . ' - ' . $dx['patologia'] . ': ' . $dx['serv'] . ($dx['serv'] == 1 ? ' servicio' : ' servicios')); ?>"><span><small><?php echo $h($dx['cie']); ?></small><?php echo $h(mb_convert_case(mb_strtolower(trim($dx['patologia'])), MB_CASE_TITLE)); ?></span><b><?php echo (int)$dx['serv']; ?></b></div>
                            <?php } ?>
                            <?php if ($t['otros_serv'] > 0) { ?><div class="otros-dx" title="<?php echo $h($t['otros_dx'] . ' diagnóstico' . ($t['otros_dx'] == 1 ? '' : 's') . ' menos frecuente' . ($t['otros_dx'] == 1 ? '' : 's') . ': ' . $t['otros_serv'] . ($t['otros_serv'] == 1 ? ' servicio' : ' servicios')); ?>"><span>Otros diagnósticos <small>(<?php echo $t['otros_dx']; ?>)</small></span><b><?php echo $t['otros_serv']; ?></b></div><?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>

                <!-- ===================== PIRÁMIDE · GRUPO PRIORIZADO · GRUPOS VULNERABLES ===================== -->
                <div class="grid">
                    <div class="vidrio card-p g-mapa aparece">
                        <div class="cab-card">
                            <div><h6 class="titulo-card">Pirámide poblacional</h6><div class="sub-card">Beneficiarios únicos de todos los procesos · edad cumplida a su primera atención del periodo</div></div>
                            <span class="pildora-ico"><i class="fas fa-users"></i></span>
                        </div>
                        <div class="mini-cifras">
                            <div><span class="etq"><i class="fas fa-male mr-1" style="color: #4e73df;"></i>Hombres</span><b><?php echo number_format($total_h); ?></b></div>
                            <div><span class="etq"><i class="fas fa-female mr-1" style="color: #ec6aa5;"></i>Mujeres</span><b><?php echo number_format($total_m); ?></b></div>
                            <?php if ($sin_dato_piramide > 0) { ?><div><span class="etq">Sin fecha de nacimiento o sexo</span><b><?php echo number_format($sin_dato_piramide); ?></b></div><?php } ?>
                        </div>
                        <div id="grafico-piramide" style="height: 420px; margin-top: 6px;"><div class="esqueleto"></div></div>
                    </div>

                    <div class="vidrio card-p aparece">
                        <div class="cab-card">
                            <div><h6 class="titulo-card">Grupo priorizado</h6><div class="sub-card">Servicios según diagnóstico, edad y discapacidad</div></div>
                            <span class="pildora-ico"><i class="fas fa-notes-medical"></i></span>
                        </div>
                        <?php if (empty($grupos)) { ?>
                            <div class="vacio"><i class="fas fa-notes-medical"></i>Sin servicios en el periodo</div>
                        <?php } else { ?>
                        <div class="lista-grupos">
                            <?php foreach ($grupos as $g) { ?>
                                <div>
                                    <div class="nom"><span><?php echo $h($g['nombre']); ?></span>
                                        <b><?php echo number_format($g['total']); ?> <small><?php echo $serv_total > 0 ? round($g['total'] / $serv_total * 100) : 0; ?>%</small></b></div>
                                    <div class="pista-g" style="width: <?php echo round($g['total'] / $grupo_max * 100, 2); ?>%;">
                                        <?php foreach ($tm_procesos as $pk => $meta) { if (!empty($g['proc'][$pk])) { ?><span data-ancho="<?php echo round($g['proc'][$pk] / max(1, array_sum($g['proc'])) * 100, 2); ?>" style="background: <?php echo $meta[1]; ?>;" title="<?php echo $h($meta[0]) . ': ' . $g['proc'][$pk]; ?>"></span><?php } } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="leyenda-antig mt-3">
                            <?php foreach ($tm_procesos as $meta) { ?><span><i style="background: <?php echo $meta[1]; ?>;"></i><?php echo $h($meta[0]); ?></span><?php } ?>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="vidrio card-p aparece">
                        <div class="cab-card">
                            <div><h6 class="titulo-card">Grupos vulnerables</h6><div class="sub-card">Atenciones de teleconsulta y telemetría</div></div>
                            <span class="pildora-ico"><i class="fas fa-hands-helping"></i></span>
                        </div>
                        <?php if (empty($vul_lista)) { ?>
                            <div class="vacio"><i class="fas fa-hands-helping"></i>Sin atenciones a grupos vulnerables en el periodo</div>
                        <?php } else { ?>
                        <div class="lista-barras">
                            <?php foreach ($vul_lista as $x) { ?>
                                <div class="item">
                                    <span class="pildora-ico"><i class="fas fa-user-shield"></i></span>
                                    <div>
                                        <div class="nom"><span><?php echo $h($x['nombre']); ?></span><b><?php echo number_format($x['n']); ?></b></div>
                                        <div class="pista"><span data-ancho="<?php echo round($x['n'] / $vul_max * 100, 2); ?>"></span></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <?php } ?>
                        <div class="nota"><i class="fas fa-info-circle"></i><span><?php echo number_format($vul_ninguna); ?> atenciones registradas sin grupo vulnerable. Las teleinterconsultas no registran este dato.</span></div>
                    </div>
                </div>

                <!-- ===================== ACCIONES: ANALÍTICA ANUAL Y MATRIZ ===================== -->
                <div class="acciones">
                    <button id="btn-generar-analitica" class="btn-pildora primario"><i class="fas fa-chart-line"></i> Analítica anual detallada</button>
                    <button id="btn-ver-matriz" class="btn-pildora secundario" data-toggle="modal" data-target="#modalMatrizGlobal"><i class="fas fa-table"></i> Matriz de producción global</button>
                </div>

                <div id="contenedor-analitica-anual" style="display: none;" class="mb-4">
                    <div class="control-anio">
                        <button class="btn-cambio-anio" data-dir="-1" title="Año anterior" aria-label="Año anterior"><i class="fas fa-chevron-left"></i></button>
                        <h4 id="texto-gestion-analitica">Gestión <?php echo $gestion; ?></h4>
                        <button class="btn-cambio-anio" data-dir="1" title="Año siguiente" aria-label="Año siguiente"><i class="fas fa-chevron-right"></i></button>
                    </div>
                    <div id="loader-analitica" class="text-center py-4"><div class="esqueleto" style="height: 300px;"></div></div>
                    <div id="graficos-analitica" class="grid" style="display: none;">
                        <div class="vidrio card-p">
                            <div class="cab-card"><div><h6 class="titulo-card">Volumen anual</h6><div class="sub-card">Total del año por proceso</div></div></div>
                            <div id="chart-anual-barras" style="height: 340px;"></div>
                        </div>
                        <div class="vidrio card-p" style="grid-column: span 3;">
                            <div class="cab-card"><div><h6 class="titulo-card">Evolución mensual</h6><div class="sub-card">Haga clic en la leyenda para aislar un proceso</div></div></div>
                            <div id="chart-anual-lineas" style="height: 340px;"></div>
                        </div>
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

<a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

<!-- ===================== MODAL: MATRIZ DE PRODUCCIÓN GLOBAL (sin cambios de funcionamiento) ===================== -->
<div class="modal fade" id="modalMatrizGlobal" tabindex="-1" role="dialog" aria-labelledby="modalMatrizLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document" style="max-width: 95%; transition: all 0.3s ease;">
    <div class="modal-content shadow-lg">
      <div class="modal-header py-2">
        <h5 class="modal-title" id="modalMatrizLabel"><i class="fas fa-table mr-2"></i> Matriz de producción global (Telesalud)</h5>
        <div>
            <button type="button" class="close mr-3" id="btn-maximize-modal" title="Maximizar / Restaurar" style="outline: none;"><i class="fas fa-expand-arrows-alt" style="font-size: 16px;"></i></button>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" title="Cerrar" style="outline: none;"><span aria-hidden="true">&times;</span></button>
        </div>
      </div>
      <div class="modal-body p-0" style="height: 75vh; overflow-y: auto; background-color: #f8f9fc;">
         <iframe id="iframe-matriz" src="" style="width: 100%; height: 100%; border: none; display: none;"></iframe>
         <div id="loader-matriz" class="p-5 text-center">
             <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
             <h5 class="mt-3 text-gray-800">Cargando matriz global, por favor espere...</h5>
         </div>
      </div>
    </div>
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

<!-- Presentación: contadores y barras -->
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
        document.querySelectorAll('.tabla-prod .pista span, .traz .prop span, .lista-grupos .pista-g span, .lista-barras .pista span').forEach(el => { el.style.width = el.getAttribute('data-ancho') + '%'; });
        document.querySelectorAll('.seg').forEach(el => { el.style.flexGrow = el.getAttribute('data-grow'); });
    }, 150);

    // Desplegable "Ver por departamento"
    const btnDep = document.getElementById('btn-ver-dep');
    if (btnDep) {
        btnDep.addEventListener('click', function () {
            const caja = document.getElementById('tabla-dep');
            const abrir = !caja.classList.contains('abierto');
            caja.classList.toggle('abierto', abrir);
            this.setAttribute('aria-expanded', abrir ? 'true' : 'false');
            this.lastChild.textContent = abrir ? ' Ocultar departamentos' : ' Ver por departamento';
        });
    }
});
</script>

<!-- Gráficos (tema minimalista común) -->
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
        yAxis: { gridLineColor: 'rgba(78,115,223,0.08)', gridLineDashStyle: 'Dash', labels: { style: { color: '#5a5c69', fontSize: '11px' } }, title: { text: null } },
        legend: { itemStyle: { color: '#34353d', fontWeight: '400', fontSize: '12.5px' }, symbolRadius: 4 },
        exporting: { fallbackToExportServer: false, buttons: { contextButton: { symbol: 'menu', symbolStroke: '#858796', theme: { fill: 'transparent', r: 12, states: { hover: { fill: 'rgba(78,115,223,0.08)' }, select: { fill: 'rgba(78,115,223,0.12)' } } },
            menuItems: ['viewFullscreen', 'printChart', 'separator', 'downloadPNG', 'downloadSVG', 'separator', 'viewData', 'downloadCSV', 'downloadXLS'] } } },
        navigation: { menuStyle: { border: '1px solid rgba(78,115,223,.15)', borderRadius: '14px', boxShadow: 'none', padding: '6px 0', background: 'rgba(255,255,255,.97)' },
            menuItemStyle: { fontSize: '12.5px', padding: '6px 16px', fontFamily: FUENTE }, menuItemHoverStyle: { background: '#4e73df', color: '#ffffff' } }
    });

    // --- Tendencia apilada por proceso ---
    const etiquetas = <?php echo json_encode(array_map(function ($e) { return $e['ver'] ? $e['txt'] . ($e['sub'] !== '' ? '<br><span style="font-size:10px">' . $e['sub'] . '</span>' : '') : ''; }, $tend_et), JSON_UNESCAPED_UNICODE); ?>;
    const titulos = <?php echo json_encode(array_map(function ($e) { return $e['titulo']; }, $tend_et), JSON_UNESCAPED_UNICODE); ?>;
    const series = <?php echo json_encode($tend_series, JSON_UNESCAPED_UNICODE); ?>;
    if (!titulos.length || series.every(s => s.data.every(v => v === 0))) {
        document.getElementById('grafico-tendencia').innerHTML = '<div class="vacio"><i class="far fa-chart-bar"></i>Sin producción en el periodo</div>';
    } else {
        Highcharts.chart('grafico-tendencia', {
            chart: { type: 'column', spacingTop: 30 },
            xAxis: { categories: etiquetas, labels: { useHTML: true, style: { textAlign: 'center' } } },
            yAxis: { min: 0, allowDecimals: false, stackLabels: { enabled: false } },
            legend: { align: 'left', verticalAlign: 'top', y: -12, itemDistance: 18 },
            tooltip: { shared: true, useHTML: true, formatter: function () {
                let html = '<b>' + titulos[this.points[0].point.index] + '</b><br>'; let total = 0;
                this.points.forEach(p => { if (p.y > 0) { html += '<span style="color:' + p.color + '">●</span> ' + p.series.name + ': <b>' + p.y + '</b><br>'; } total += p.y; });
                return html + '<span style="color:#5a5c69">Total: <b>' + total + '</b></span>';
            } },
            plotOptions: { column: { stacking: 'normal', borderWidth: 0, borderRadius: 3, pointPadding: 0.08, groupPadding: 0.08, maxPointWidth: 26 } },
            series: series
        });
    }

    // --- Pirámide poblacional (hombres a la izquierda, mujeres a la derecha) ---
    const gruposEdad = <?php echo json_encode($grupos_edad); ?>;
    const hombres = <?php echo json_encode($piramide['h']); ?>;
    const mujeres = <?php echo json_encode($piramide['m']); ?>;
    if (hombres.every(v => v === 0) && mujeres.every(v => v === 0)) {
        document.getElementById('grafico-piramide').innerHTML = '<div class="vacio"><i class="fas fa-users"></i>Sin beneficiarios con fecha de nacimiento y sexo registrados</div>';
    } else {
        const maxP = Math.max.apply(null, hombres.concat(mujeres)) || 1;
        Highcharts.chart('grafico-piramide', {
            chart: { type: 'bar', spacingTop: 30 },
            xAxis: [
                { categories: gruposEdad, reversed: false, labels: { step: 1, style: { fontSize: '11px' } } },
                { opposite: true, reversed: false, categories: gruposEdad, linkedTo: 0, labels: { step: 1, style: { fontSize: '11px' } } }
            ],
            yAxis: { min: -maxP, max: maxP, allowDecimals: false, labels: { formatter: function () { return Math.abs(this.value); } }, plotLines: [{ value: 0, width: 1, color: 'rgba(90,92,105,0.25)' }] },
            legend: { align: 'left', verticalAlign: 'top', y: -12 },
            tooltip: { formatter: function () { return '<b>' + this.series.name + ', ' + this.point.category + ' años</b><br>Beneficiarios: <b>' + Math.abs(this.point.y) + '</b>'; } },
            plotOptions: { series: { stacking: 'normal', borderWidth: 0, borderRadius: 4, pointPadding: 0.06, groupPadding: 0.04 } },
            series: [
                { name: 'Hombres', color: '#4e73df', data: hombres.map(v => -v) },
                { name: 'Mujeres', color: '#ec6aa5', data: mujeres }
            ]
        });
    }

    // --- Analítica anual (mismas reglas, por mes) ---
    let anio = new Date().getFullYear();
    const COLORES = <?php echo json_encode(array_values(array_map(function ($m) { return $m[1]; }, $tm_procesos))); ?>;
    function cargarAnalitica(anioObjetivo) {
        $('#graficos-analitica').hide(); $('#loader-analitica').show();
        $('#texto-gestion-analitica').text('Gestión ' + anioObjetivo);
        $.ajax({
            url: 'ajax_analitica_anual.php', type: 'GET', cache: false, dataType: 'json', data: { gestion: anioObjetivo },
            success: function (res) {
                $('#loader-analitica').hide(); $('#graficos-analitica').css('display', 'grid');
                Highcharts.chart('chart-anual-barras', {
                    chart: { type: 'column' },
                    xAxis: { categories: ['Generadas', 'Respuestas', 'Teleconsultas', 'Telemetrías'] },
                    yAxis: { min: 0, allowDecimals: false },
                    legend: { enabled: false },
                    tooltip: { pointFormat: 'Total anual: <b>{point.y}</b>' },
                    plotOptions: { column: { colorByPoint: true, borderWidth: 0, borderRadius: 8, maxPointWidth: 46, dataLabels: { enabled: true, style: { fontWeight: '500', textOutline: 'none', color: '#34353d' } } } },
                    colors: COLORES,
                    series: [{ name: 'Servicios', data: [res.totales.ref, res.totales.cref, res.totales.tc, res.totales.tm] }]
                });
                Highcharts.chart('chart-anual-lineas', {
                    chart: { type: 'areaspline' },
                    xAxis: { categories: res.meses },
                    yAxis: { min: 0, allowDecimals: false },
                    legend: { align: 'left', verticalAlign: 'top', y: -6 },
                    tooltip: { shared: true },
                    plotOptions: { areaspline: { lineWidth: 2, fillOpacity: 0.08, marker: { enabled: false, states: { hover: { enabled: true, radius: 4 } } } } },
                    colors: COLORES,
                    series: [
                        { name: 'Generadas', data: res.series.ref }, { name: 'Respuestas', data: res.series.cref },
                        { name: 'Teleconsultas', data: res.series.tc }, { name: 'Telemetrías', data: res.series.tm }
                    ]
                });
            },
            error: function () { $('#loader-analitica').html('<div class="vacio"><i class="fas fa-exclamation-triangle"></i>No se pudo generar la analítica. Verifique su conexión.</div>'); }
        });
    }
    $('#btn-generar-analitica').on('click', function () {
        $(this).prop('disabled', true).html('<i class="fas fa-check-circle"></i> Analítica cargada');
        $('#contenedor-analitica-anual').slideDown(300);
        $('html, body').animate({ scrollTop: $('#contenedor-analitica-anual').offset().top - 60 }, 600);
        cargarAnalitica(anio);
    });
    $('.btn-cambio-anio').on('click', function () { anio += parseInt($(this).data('dir'), 10); cargarAnalitica(anio); });

    // --- Matriz de producción global (mismo funcionamiento que antes) ---
    $('#modalMatrizGlobal').on('show.bs.modal', function () {
        const params = new URLSearchParams({
            inicio: <?php echo json_encode($inicio); ?>, finalizacion: <?php echo json_encode($finalizacion); ?>,
            iddepartamento: <?php echo json_encode($g_dep); ?>, idmunicipio: <?php echo json_encode($g_mun); ?>,
            idestablecimiento: <?php echo json_encode($g_est); ?>, idusuario_medico: <?php echo json_encode($g_med); ?>, vista_limpia: '1'
        });
        const iframe = document.getElementById('iframe-matriz');
        iframe.src = '../produccion_servicios/atenciones_psafci_diarias_fechas_tele.php?' + params.toString();
        iframe.onload = function () { document.getElementById('loader-matriz').style.display = 'none'; iframe.style.display = 'block'; };
    });
    $('#modalMatrizGlobal').on('hidden.bs.modal', function () {
        document.getElementById('iframe-matriz').src = '';
        document.getElementById('loader-matriz').style.display = 'block';
        document.getElementById('iframe-matriz').style.display = 'none';
        const dialog = document.querySelector('#modalMatrizGlobal .modal-dialog');
        if (dialog.classList.contains('modal-fullscreen')) { document.getElementById('btn-maximize-modal').click(); }
    });
    document.getElementById('btn-maximize-modal').addEventListener('click', function () {
        const dialog = document.querySelector('#modalMatrizGlobal .modal-dialog');
        dialog.classList.toggle('modal-fullscreen');
        const icon = this.querySelector('i');
        icon.className = dialog.classList.contains('modal-fullscreen') ? 'fas fa-compress-arrows-alt' : 'fas fa-expand-arrows-alt';
    });
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
