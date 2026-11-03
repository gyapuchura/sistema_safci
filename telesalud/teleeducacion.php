<?php
include("../cabf.php");
include("../inc.config.php");

$idusuario_ss = $_SESSION['idusuario_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$gestion      = date("Y");

// Bloque compartido de Telemedicina: alcance del usuario (nacional / departamental / municipal),
// filtros guardados en la sesión y estilos. El registro se hace en Promoción de la Salud > Teleeducación.
include("inc_telemedicina.php");
include("../promocion_safci/inc_teleeducacion.php");

// =========================================================================
// CONSOLIDADO DE TELEEDUCACIÓN (sesiones por fecha de la sesión)
// =========================================================================
$es_fecha = function ($f) { return is_string($f) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $f) && strtotime($f) !== false; };
$inicio       = (isset($_GET['fecha_inicio']) && $es_fecha($_GET['fecha_inicio'])) ? $_GET['fecha_inicio'] : date('Y-m-01');
$finalizacion = (isset($_GET['fecha_fin']) && $es_fecha($_GET['fecha_fin'])) ? $_GET['fecha_fin'] : date('Y-m-d');
if ($finalizacion < $inicio) { list($inicio, $finalizacion) = [$finalizacion, $inicio]; }

$g_dep = isset($_GET['iddepartamento']) ? (string)$_GET['iddepartamento'] : '';
$g_mun = isset($_GET['idmunicipio']) ? (string)$_GET['idmunicipio'] : '';
$g_est = isset($_GET['idestablecimiento']) ? (string)$_GET['idestablecimiento'] : '';
$g_med = isset($_GET['idusuario_medico']) ? (string)$_GET['idusuario_medico'] : '';   // quien registró la sesión
$filtros = ['iddepartamento' => $g_dep, 'idmunicipio' => $g_mun, 'idestablecimiento' => $g_est, 'idusuario_medico' => $g_med];

$where = te_where($link, $inicio, $finalizacion, $filtros);

// Periodo anterior para las flechas ▲▼ (misma regla que Telemedicina)
$dt_ini = new DateTime($inicio); $dt_fin = new DateTime($finalizacion);
list($ant_ini, $ant_fin) = tm_periodo_anterior($dt_ini, $dt_fin);
$where_ant = te_where($link, $ant_ini->format('Y-m-d'), $ant_fin->format('Y-m-d'), $filtros);

// Catálogos desde la base de datos (tipos, actividades, medios, grupos y géneros)
$cat = te_catalogos($link);

// --- Cifras generales ---
$kpi_sql = "SELECT COUNT(*) AS sesiones, IFNULL(SUM(t.duracion_minutos), 0) AS minutos, IFNULL(SUM(t.asistentes), 0) AS part,
    COUNT(DISTINCT t.idestablecimiento_salud) AS eess FROM teleeducacion t WHERE ";
$kpi      = mysqli_fetch_assoc(mysqli_query($link, $kpi_sql . $where));
$kpi_prev = mysqli_fetch_assoc(mysqli_query($link, $kpi_sql . $where_ant));

// --- Por tipo. Se muestran los tipos activos y los que tengan sesiones en el periodo ---
$por_tipo = [];
$res = mysqli_query($link, "SELECT t.idtipo_teleeducacion, COUNT(*), SUM(t.duracion_minutos), SUM(t.asistentes) FROM teleeducacion t WHERE $where GROUP BY t.idtipo_teleeducacion");
while ($r = mysqli_fetch_row($res)) { $por_tipo[(int)$r[0]] = ['sesiones' => (int)$r[1], 'minutos' => (int)$r[2], 'part' => (int)$r[3]]; }
$tipos_ver = [];
foreach ($cat['tipos'] as $idt => $tp) {
    if ($tp['activo'] || isset($por_tipo[$idt])) { $tipos_ver[$idt] = $tp; }
    if (!isset($por_tipo[$idt])) { $por_tipo[$idt] = ['sesiones' => 0, 'minutos' => 0, 'part' => 0]; }
}

// --- Participantes por grupo (perfil profesional / grupo etario) y género ---
$grupos_tipo = [];   // [idtipo => [idgrupo => [idgenero => cantidad]]]
$res = mysqli_query($link, "SELECT t.idtipo_teleeducacion, a.idgrupo_asistente_te, a.idgenero, SUM(a.cantidad)
    FROM teleeducacion t INNER JOIN teleeducacion_asistente a ON a.idteleeducacion = t.idteleeducacion
    WHERE $where GROUP BY t.idtipo_teleeducacion, a.idgrupo_asistente_te, a.idgenero");
while ($r = mysqli_fetch_row($res)) { $grupos_tipo[(int)$r[0]][(int)$r[1]][(int)$r[2]] = (int)$r[3]; }
// Participantes por género (todos los tipos)
$part_genero = array_fill_keys(array_keys($cat['generos']), 0);
foreach ($grupos_tipo as $gs) { foreach ($gs as $porg) { foreach ($porg as $idg => $n) { if (isset($part_genero[$idg])) { $part_genero[$idg] += $n; } } } }

// --- Actividades por tipo ---
$act_por_tipo = array_fill_keys(array_keys($tipos_ver), []);
$res = mysqli_query($link, "SELECT t.idtipo_teleeducacion, t.idactividad_teleeducacion, COUNT(*) AS n, SUM(t.asistentes) AS part FROM teleeducacion t WHERE $where
    GROUP BY t.idtipo_teleeducacion, t.idactividad_teleeducacion ORDER BY n DESC, part DESC");
while ($r = mysqli_fetch_row($res)) {
    if (isset($act_por_tipo[(int)$r[0]])) { $act_por_tipo[(int)$r[0]][] = ['nombre' => te_nombre($cat['actividades'], $r[1]), 'n' => (int)$r[2], 'part' => (int)$r[3]]; }
}

// --- Medios digitales, con el desglose por tipo ---
$medios = [];
$res = mysqli_query($link, "SELECT t.idmedio_digital, t.idtipo_teleeducacion, COUNT(*), SUM(t.asistentes) FROM teleeducacion t WHERE $where GROUP BY t.idmedio_digital, t.idtipo_teleeducacion");
while ($r = mysqli_fetch_row($res)) {
    $idm = (int)$r[0];
    if (!isset($medios[$idm])) {
        $medios[$idm] = ['nombre' => te_nombre($cat['medios'], $idm), 'n' => 0, 'part' => 0, 'por_tipo' => []];
    }
    $medios[$idm]['n'] += (int)$r[2]; $medios[$idm]['part'] += (int)$r[3]; $medios[$idm]['por_tipo'][(int)$r[1]] = (int)$r[2];
}
uasort($medios, function ($a, $b) { return $b['n'] - $a['n']; });

// --- Producción por lugar: departamentos -> municipios -> establecimientos, según el filtro ---
if ($g_mun !== '' || $g_est !== '') {
    $nivel_lugar = ['Establecimientos', 'fa-hospital', "es.establecimiento_salud", "INNER JOIN establecimiento_salud es ON es.idestablecimiento_salud = t.idestablecimiento_salud", "t.idestablecimiento_salud"];
} elseif ($g_dep !== '') {
    $nivel_lugar = ['Municipios', 'fa-map-marker-alt', "m.municipio", "INNER JOIN municipios m ON m.idmunicipio = t.idmunicipio", "t.idmunicipio"];
} else {
    $nivel_lugar = ['Departamentos', 'fa-map', "d.departamento", "INNER JOIN departamento d ON d.iddepartamento = t.iddepartamento", "t.iddepartamento"];
}
$lugares = [];
$res = mysqli_query($link, "SELECT $nivel_lugar[4] AS id, $nivel_lugar[2] AS nombre, t.idtipo_teleeducacion AS tipo, COUNT(*) AS sesiones, SUM(t.duracion_minutos) AS minutos, SUM(t.asistentes) AS part
    FROM teleeducacion t $nivel_lugar[3] WHERE $where GROUP BY $nivel_lugar[4], nombre, t.idtipo_teleeducacion");
while ($r = mysqli_fetch_assoc($res)) {
    $k = $r['id'];
    if (!isset($lugares[$k])) { $lugares[$k] = ['nombre' => $r['nombre'], 'sesiones' => 0, 'minutos' => 0, 'part' => 0, 'por_tipo' => []]; }
    $lugares[$k]['sesiones'] += (int)$r['sesiones']; $lugares[$k]['minutos'] += (int)$r['minutos']; $lugares[$k]['part'] += (int)$r['part'];
    $lugares[$k]['por_tipo'][(int)$r['tipo']] = (int)$r['sesiones'];
}
uasort($lugares, function ($a, $b) { return $b['sesiones'] !== $a['sesiones'] ? $b['sesiones'] - $a['sesiones'] : $b['part'] - $a['part']; });
$lugares = array_values($lugares);

// --- Listado de sesiones del periodo ---
$limite = 3000;
$sesiones = [];
$res = mysqli_query($link, "SELECT t.idteleeducacion, t.codigo, t.fecha_sesion, t.idtipo_teleeducacion, t.idactividad_teleeducacion, t.nombre_actividad,
        t.idmodalidad_teleeducacion, t.idmedio_digital, t.duracion_minutos, t.asistentes, d.departamento, m.municipio, es.establecimiento_salud, n.nombre, n.paterno, n.materno
    FROM teleeducacion t
    INNER JOIN establecimiento_salud es ON es.idestablecimiento_salud = t.idestablecimiento_salud
    LEFT JOIN municipios m ON m.idmunicipio = t.idmunicipio
    LEFT JOIN departamento d ON d.iddepartamento = t.iddepartamento
    LEFT JOIN usuarios u ON u.idusuario = t.idusuario
    LEFT JOIN nombre n ON n.idnombre = u.idnombre
    WHERE $where ORDER BY t.fecha_sesion DESC, t.idteleeducacion DESC LIMIT " . ($limite + 1));
while ($r = mysqli_fetch_assoc($res)) { $sesiones[] = $r; }
$recortado = count($sesiones) > $limite;
if ($recortado) { array_pop($sesiones); }

// --- Catálogos de los filtros, recortados al alcance (inc_telemedicina.php): lugares y médicos del lugar elegido ---
list($deptos, $munis, $eess, $medicos) = tm_catalogos($link);

// =========================================================================
// PRESENTACIÓN
// =========================================================================
$h = function ($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); };
$f_corta = function ($f) { $x = strtotime((string)$f); return $x ? date('d/m/Y', $x) : ''; };
$num = function ($n) { return number_format((float)$n, fmod((float)$n, 1) == 0 ? 0 : 1, '.', ','); };
$pagina = 'teleeducacion.php';

$meses_es = ['', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
$fecha_larga = function (DateTime $f) use ($meses_es) { return (int)$f->format('j') . ' de ' . $meses_es[(int)$f->format('n')] . ' de ' . $f->format('Y'); };
$texto_periodo = 'Del ' . $fecha_larga($dt_ini) . ' al ' . $fecha_larga($dt_fin);

// Variación contra el periodo anterior ($fmt: cómo escribir el valor anterior, p. ej. minutos como "5:30 h")
$variacion = function ($actual, $anterior, $fmt = null) {
    if ($anterior == 0 && $actual == 0) { return ['—', 'neutro', 'Sin cambios vs ' . tm_etq_anterior(true)]; }
    if ($anterior == 0) { return ['Nuevo', 'bueno', 'Sin registros en ' . tm_etq_anterior(true, true)]; }
    $pct = round((($actual - $anterior) / $anterior) * 100);
    if ($pct == 0) { return ['0%', 'neutro', 'Igual que ' . tm_etq_anterior(true, true)]; }
    $ant = $fmt ? $fmt($anterior) : number_format($anterior, fmod($anterior, 1) == 0 ? 0 : 1);
    return [($pct > 0 ? '▲ ' : '▼ ') . abs($pct) . '%', $pct > 0 ? 'bueno' : 'malo', ucfirst(tm_etq_anterior(true)) . ': ' . $ant];
};
$v_ses  = $variacion((int)$kpi['sesiones'], (int)$kpi_prev['sesiones']);
$v_hrs  = $variacion((int)$kpi['minutos'], (int)$kpi_prev['minutos'], function ($m) { return te_hm($m) . ' h'; });
$v_part = $variacion((int)$kpi['part'], (int)$kpi_prev['part']);

// Chips de filtros activos (cada ✕ quita el filtro y sus dependientes)
$buscar_nombre = function ($lista, $id) { foreach ($lista as $it) { if ((string)$it['id'] === (string)$id) { return $it['nombre']; } } return $id; };
$url_sin = function ($claves) use ($pagina) { $q = $_GET; foreach ($claves as $c) { unset($q[$c]); } return $pagina . (count($q) ? '?' . http_build_query($q) : ''); };
$chips = [];
if ($g_dep !== '') { $chips[] = ['fa-map', $buscar_nombre($deptos, $g_dep), tm_es_fijo('iddepartamento') ? '' : $url_sin(['iddepartamento', 'idmunicipio', 'idestablecimiento'])]; }
if ($g_mun !== '') { $chips[] = ['fa-map-marker-alt', $buscar_nombre($munis, $g_mun), tm_es_fijo('idmunicipio') ? '' : $url_sin(['idmunicipio', 'idestablecimiento'])]; }
if ($g_est !== '') { $chips[] = ['fa-hospital', $buscar_nombre($eess, $g_est), $url_sin(['idestablecimiento'])]; }
if ($g_med !== '') { $chips[] = ['fa-user-md', $buscar_nombre($medicos, $g_med), $url_sin(['idusuario_medico'])]; }

// Barras de participantes de un tipo: [texto, [idgenero => cantidad]] en el orden del catálogo
// (las filas de un encabezado llevan su nombre delante: "Médicos generales · Telesalud")
$filas_grupo = function ($idt) use ($cat, $grupos_tipo) {
    $datos = isset($grupos_tipo[$idt]) ? $grupos_tipo[$idt] : [];
    $out = []; $encabezado = '';
    foreach (te_filas_grupos($cat, $idt, true, array_keys($datos)) as $f) {
        if ($f['nivel'] === 'encabezado') { $encabezado = $f['g']['nombre']; continue; }
        $porg = [];
        foreach (array_keys($cat['generos']) as $idg) { $porg[$idg] = isset($datos[$f['g']['id']][$idg]) ? $datos[$f['g']['id']][$idg] : 0; }
        $out[] = [($f['nivel'] === 'sub' ? $encabezado . ' · ' : '') . $f['g']['nombre'], $porg];
    }
    return $out;
};
// Colores por género para las barras (paleta SB Admin 2): masculino azul, femenino rojo suave, otros gris
$color_genero = function ($nombre) { return $nombre === 'MASCULINO' ? 'var(--p)' : ($nombre === 'FEMENINO' ? 'rgba(var(--err-rgb), .75)' : 'var(--n-500)'); };

$medios_max = $medios ? max(1, (int)reset($medios)['n']) : 1;
$lugar_max = $lugares ? max(1, (int)$lugares[0]['sesiones']) : 1;
$total_tipos = array_sum(array_column($por_tipo, 'sesiones'));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SISTEMA MEDI-SAFCI - Teleeducación</title>

    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <?php tm_estilos(); ?>
    <style>
        .px .lista-barras .nom small.mf { margin-left: 6px; }
        .px .punto-tipo { display: inline-flex; align-items: center; gap: 4px; margin-left: 8px; font-size: 12px; font-weight: 500; color: var(--n-700); white-space: nowrap; }
        .px .punto-tipo i { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }
        .px .pista.mf { display: flex; }
        .px .pista.mf span { border-radius: 0; }
        .px .pista.mf span.m { background: var(--p); }
        .px .pista.mf span.f { background: var(--err); opacity: .75; }
        .px .leyenda-mf { display: flex; gap: 14px; font-size: 12px; color: var(--n-700); }
        .px .leyenda-mf i { display: inline-block; width: 8px; height: 8px; border-radius: 3px; margin-right: 5px; }
        .px .tabla-lugar { width: 100%; font-size: 13px; }
        .px .tabla-lugar th { font-size: 11.5px; font-weight: 500; color: var(--n-700); text-transform: uppercase; padding: 6px 8px; border-bottom: 1px solid var(--borde); }
        .px .tabla-lugar td { padding: 7px 8px; border-bottom: 1px dashed rgba(var(--p-rgb), .12); }
        .px .tabla-lugar th.n, .px .tabla-lugar td.n { text-align: right; white-space: nowrap; }
        .px .tabla-lugar .barra-mini { height: 4px; border-radius: 4px; background: rgba(var(--p-rgb), .08); margin-top: 4px; overflow: hidden; }
        .px .tabla-lugar .barra-mini span { display: block; height: 100%; width: 0; background: var(--p); border-radius: 4px; transition: width 1.1s cubic-bezier(.2, .8, .2, 1); }
        .px .lista-card { padding: 22px 24px; margin-top: var(--gap); }
        .px table.dataTable { font-size: 13px; color: var(--n-900); border-collapse: collapse !important; }
        .px table.dataTable thead th { font-size: 11.5px; font-weight: 500; color: var(--n-700); text-transform: uppercase; border-bottom: 1px solid var(--borde) !important; border-top: 0; white-space: nowrap; }
        .px table.dataTable td { vertical-align: middle; border-top: 1px dashed rgba(var(--p-rgb), .12); }
        .px .dataTables_wrapper .form-control { border-radius: 999px; border: 1px solid var(--borde); font-size: 13px; }
        .px .page-item.active .page-link { background: var(--p); border-color: var(--p); }
        .px .page-link { border-radius: 999px !important; margin: 0 2px; border: 0; color: var(--p-osc); }
        .px .tipo-tag { display: inline-flex; align-items: center; gap: 6px; padding: 3px 10px; border-radius: 999px; font-size: 11.5px; font-weight: 500; white-space: nowrap; background: rgba(var(--cc-rgb), .13); color: var(--cc-txt); }
        .px .sub-celda { display: block; font-size: 11.5px; color: var(--n-700); }
        .px .codigo { font-weight: 500; color: var(--p); white-space: nowrap; text-decoration: none; }
        .px a.codigo:hover, .px a.codigo:focus-visible { color: var(--p-osc); text-decoration: underline; }
        .px .btn-ver { display: inline-flex; align-items: center; gap: 6px; padding: 5px 13px; border-radius: 999px; font-size: 12px; font-weight: 500; background: rgba(var(--p-rgb), .1); color: var(--p-osc); text-decoration: none; white-space: nowrap; }
        .px .btn-ver:hover { background: rgba(var(--p-rgb), .18); color: var(--p-osc); text-decoration: none; }
        .px .aviso-limite { font-size: 12px; color: var(--n-700); margin-top: 8px; }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include("../menu.php"); ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include("../top_bar.php"); ?>

                <div class="container-fluid mt-4 px">
                    <?php tm_cargador('Cargando teleeducación'); ?>

                    <!-- ===================== ENCABEZADO ===================== -->
                    <div class="encabezado aparece">
                        <div>
                            <h1>Teleeducación</h1>
                            <div class="meta">
                                <span><i class="far fa-calendar-alt mr-1"></i><?php echo $h($texto_periodo); ?></span>
                                <span><i class="fas fa-graduation-cap mr-1"></i>Consolidado de telecapacitación y telepromoción</span>
                            </div>
                        </div>
                    </div>

                    <!-- ===================== FILTROS ===================== -->
                    <div class="barra-filtros filtros vidrio aparece">
                        <form id="form-filtros" method="GET" action="">
                            <div class="filtros-dropdowns">
                                <div>
                                    <label>Fecha inicio</label>
                                    <input type="date" name="fecha_inicio" value="<?php echo $h($inicio); ?>" onchange="this.form.submit();">
                                </div>
                                <div>
                                    <label>Fecha fin</label>
                                    <input type="date" name="fecha_fin" value="<?php echo $h($finalizacion); ?>" onchange="this.form.submit();">
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
                                    <input list="dl-meds" id="inp-med" placeholder="- TODOS -" autocomplete="off" title="Quien registró la sesión">
                                    <input type="hidden" id="val-idusuario_medico" name="idusuario_medico" value="<?php echo $h($g_med); ?>">
                                    <datalist id="dl-meds"></datalist>
                                </div>
                                <div>
                                    <button type="button" class="btn-limpiar" onclick="window.location.href='<?php echo $h(tm_url_limpiar($pagina)); ?>'" title="Limpiar filtros (también en Telemedicina)"><i class="fas fa-eraser mr-1"></i> Limpiar</button>
                                </div>
                            </div>
                            <?php if ($chips) { ?>
                            <div class="chips">
                                <span class="etq"><i class="fas fa-filter mr-1"></i> Sesiones registradas en:</span>
                                <?php foreach ($chips as $chip) { ?>
                                    <span class="chip"><i class="fas <?php echo $chip[0]; ?>"></i> <?php echo $h($chip[1]); ?><?php if ($chip[2] !== '') { ?><a href="<?php echo $h($chip[2]); ?>" title="Quitar filtro" aria-label="Quitar filtro <?php echo $h($chip[1]); ?>"><i class="fas fa-times"></i></a><?php } else { ?><i class="fas fa-lock ml-1" style="font-size: 10px; opacity: .6;" title="Fijado según su lugar de trabajo"></i><?php } ?></span>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </form>
                    </div>

                    <!-- ===================== RESUMEN: TIPO + CIFRAS ===================== -->
                    <div class="resumen aparece">
                        <div class="segmentos" role="img" aria-label="Sesiones por tipo de teleeducación">
                            <?php if ($total_tipos == 0) { ?>
                                <div class="etq"><i class="far fa-folder-open mr-1"></i> No hay sesiones de teleeducación en este periodo y lugar</div>
                            <?php } foreach ($tipos_ver as $k => $tp) { $n = $por_tipo[$k]['sesiones']; if ($n <= 0) { continue; }
                                $pct = $n / $total_tipos * 100; list($fondo, $texto) = tm_colores_legibles($tp['color_hex']); ?>
                                <div class="seg cc" data-grow="<?php echo round(max($pct, 6), 2); ?>" style="flex: 0 1 0%; --cc: <?php echo $fondo; ?>; --cc-txt: <?php echo $texto; ?>;"
                                     title="<?php echo $h($tp['nombre'] . ': ' . $n . ' sesiones · ' . te_hm($por_tipo[$k]['minutos']) . ' h · ' . $por_tipo[$k]['part'] . ' participantes'); ?>">
                                    <span class="etq"><i class="fas fa-chalkboard-teacher"></i><?php echo $h($tp['nombre']); ?> <b><?php echo number_format($n); ?></b></span>
                                    <div class="barra"><?php echo round($pct); ?>%</div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="cifras">
                            <?php foreach ([
                                [(int)$kpi['sesiones'], 'Sesiones', 'fa-chalkboard', $v_ses, ''],
                                [te_hm($kpi['minutos']), 'Horas', 'fa-clock', $v_hrs, '<small> h</small>'],
                                [(int)$kpi['part'], 'Participantes', 'fa-users', $v_part, ''],
                            ] as $c) { ?>
                            <div class="item">
                                <span class="cifra"><?php echo (is_string($c[0]) ? $h($c[0]) : $num($c[0])) . $c[4]; ?></span>
                                <span class="pie"><span class="pildora-ico"><i class="fas <?php echo $c[2]; ?>"></i></span><span class="etq"><?php echo $c[1]; ?></span>
                                    <span class="delta <?php echo $c[3][1]; ?>" title="<?php echo $h($c[3][2]); ?>"><?php echo $h($c[3][0]); ?></span></span>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- ===================== PARTICIPANTES POR GRUPO Y GÉNERO (una tarjeta por tipo) ===================== -->
                    <div class="grid-2 mb-4">
                        <?php foreach ($tipos_ver as $k => $tp) { $filas = $filas_grupo($k);
                            $tot = 0; $max = 1; foreach ($filas as $f) { $s = array_sum($f[1]); $tot += $s; $max = max($max, $s); } ?>
                        <div class="vidrio card-p aparece" style="<?php echo te_css_color($tp['color_hex']); ?>">
                            <div class="cab-card">
                                <div>
                                    <h3 class="titulo-card"><?php echo $h(mb_convert_case(mb_strtolower($tp['nombre']), MB_CASE_TITLE)); ?></h3>
                                    <div class="sub-card"><?php echo $h(mb_convert_case(mb_strtolower($tp['etiqueta_grupo']), MB_CASE_TITLE)); ?> y género · <?php echo number_format($tot); ?> participantes</div>
                                </div>
                                <span class="pildora-ico" style="color: var(--cc-txt);"><i class="fas fa-chalkboard-teacher"></i></span>
                            </div>
                            <?php if ($tot == 0) { ?>
                                <div class="vacio"><i class="fas fa-chalkboard-teacher"></i>Sin participantes en el periodo</div>
                            <?php } else { ?>
                            <div class="leyenda-mf"><?php foreach ($cat['generos'] as $gen) { ?><span><i style="background: <?php echo $color_genero($gen); ?>;"></i><?php echo $h(mb_convert_case(mb_strtolower($gen), MB_CASE_TITLE)); ?></span><?php } ?></div>
                            <div class="lista-barras mt-2">
                                <?php foreach ($filas as $f) { $n = array_sum($f[1]); if ($n == 0) { continue; }
                                    $partes = []; foreach ($f[1] as $idg => $c) { $partes[] = $c . ' ' . te_genero_corto($cat['generos'][$idg]); } ?>
                                <div class="item">
                                    <span class="pildora-ico" style="color: var(--cc-txt);"><i class="fas fa-user"></i></span>
                                    <div>
                                        <div class="nom"><span><?php echo $h($f[0]); ?></span><b><?php echo number_format($n); ?><small class="mf"><?php echo $h(implode(' · ', $partes)); ?></small></b></div>
                                        <div class="pista mf" style="width: <?php echo round($n / $max * 100, 2); ?>%;">
                                            <?php foreach ($f[1] as $idg => $c) { ?><span data-ancho="<?php echo round($c / $n * 100, 2); ?>" style="background: <?php echo $color_genero($cat['generos'][$idg]); ?>;"></span><?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>

                    <!-- ===================== ACTIVIDADES (una tarjeta por tipo) ===================== -->
                    <div class="grid-2 mb-4">
                        <?php foreach ($tipos_ver as $k => $tp) { $lista = $act_por_tipo[$k]; $max = $lista ? max(1, (int)$lista[0]['n']) : 1; $tipo_min = mb_strtolower($tp['nombre']); ?>
                        <div class="vidrio card-p aparece" style="<?php echo te_css_color($tp['color_hex']); ?>">
                            <div class="cab-card">
                                <div>
                                    <h3 class="titulo-card">Actividades de <?php echo $h($tipo_min); ?></h3>
                                    <div class="sub-card"><?php echo number_format($por_tipo[$k]['sesiones']); ?> sesiones · <?php echo te_hm($por_tipo[$k]['minutos']); ?> h · <?php echo number_format($por_tipo[$k]['part']); ?> participantes</div>
                                </div>
                                <span class="pildora-ico" style="color: var(--cc-txt);"><i class="fas fa-chalkboard-teacher"></i></span>
                            </div>
                            <?php if (!$lista) { ?>
                                <div class="vacio"><i class="fas fa-chalkboard-teacher"></i>Sin actividades de <?php echo $h($tipo_min); ?> en el periodo</div>
                            <?php } else { ?>
                            <div class="lista-barras">
                                <?php foreach ($lista as $a) { ?>
                                <div class="item">
                                    <span class="pildora-ico" style="color: var(--cc-txt);"><i class="fas fa-chalkboard-teacher"></i></span>
                                    <div>
                                        <div class="nom"><span><?php echo $h($a['nombre']); ?></span><b><?php echo number_format($a['n']); ?> <small>sesión<?php echo $a['n'] == 1 ? '' : 'es'; ?> · <?php echo number_format($a['part']); ?> part.</small></b></div>
                                        <div class="pista"><span data-ancho="<?php echo round($a['n'] / $max * 100, 2); ?>" style="background: var(--cc);"></span></div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>

                    <?php // Puntos de color por tipo (lugar y medios): "● 3  ● 1"
                    $puntos_tipo = function ($por) use ($tipos_ver, $h) {
                        $html = '';
                        foreach ($tipos_ver as $idt => $tp) {
                            if (empty($por[$idt])) { continue; }
                            $html .= '<span class="punto-tipo" title="' . $h($tp['nombre']) . '"><i style="background: ' . $h($tp['color_hex']) . ';"></i>' . (int)$por[$idt] . '</span>';
                        }
                        return $html;
                    }; ?>

                    <!-- ===================== LUGAR | MEDIOS DIGITALES ===================== -->
                    <div class="grid-2">
                        <div class="vidrio card-p aparece">
                            <div class="cab-card">
                                <div>
                                    <h3 class="titulo-card"><?php echo $nivel_lugar[0]; ?></h3>
                                    <div class="sub-card">Sesiones, horas y participantes por lugar de registro</div>
                                </div>
                                <span class="pildora-ico"><i class="fas <?php echo $nivel_lugar[1]; ?>"></i></span>
                            </div>
                            <?php if (!$lugares) { ?>
                                <div class="vacio"><i class="fas <?php echo $nivel_lugar[1]; ?>"></i>Sin sesiones en el periodo</div>
                            <?php } else { ?>
                            <div class="leyenda-mf mb-2"><?php foreach ($tipos_ver as $tp) { ?><span><i style="background: <?php echo $h($tp['color_hex']); ?>;"></i><?php echo $h(mb_convert_case(mb_strtolower($tp['nombre']), MB_CASE_TITLE)); ?></span><?php } ?></div>
                            <div class="table-responsive">
                                <table class="tabla-lugar">
                                    <thead><tr><th><?php echo $nivel_lugar[0]; ?></th><th class="n">Sesiones</th><th class="n">Por tipo</th><th class="n">Horas</th><th class="n">Participantes</th></tr></thead>
                                    <tbody>
                                    <?php foreach ($lugares as $l) { ?>
                                        <tr>
                                            <td><?php echo $h(mb_strtoupper((string)$l['nombre'])); ?><div class="barra-mini"><span data-ancho="<?php echo round($l['sesiones'] / $lugar_max * 100, 2); ?>"></span></div></td>
                                            <td class="n"><b><?php echo number_format($l['sesiones']); ?></b></td>
                                            <td class="n"><?php echo $puntos_tipo($l['por_tipo']); ?></td>
                                            <td class="n"><?php echo te_hm($l['minutos']); ?></td>
                                            <td class="n"><?php echo number_format($l['part']); ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php } ?>
                        </div>

                        <div class="vidrio card-p aparece">
                            <div class="cab-card">
                                <div>
                                    <h3 class="titulo-card">Medios digitales</h3>
                                    <div class="sub-card">Plataformas usadas en las sesiones del periodo</div>
                                </div>
                                <span class="pildora-ico"><i class="fas fa-wifi"></i></span>
                            </div>
                            <?php if (!$medios) { ?>
                                <div class="vacio"><i class="fas fa-wifi"></i>Sin sesiones en el periodo</div>
                            <?php } else { ?>
                            <div class="leyenda-mf mb-2"><?php foreach ($tipos_ver as $tp) { ?><span><i style="background: <?php echo $h($tp['color_hex']); ?>;"></i><?php echo $h(mb_convert_case(mb_strtolower($tp['nombre']), MB_CASE_TITLE)); ?></span><?php } ?></div>
                            <div class="lista-barras">
                                <?php foreach ($medios as $m) { $n = max(1, (int)$m['n']); ?>
                                <div class="item">
                                    <span class="pildora-ico"><i class="fas fa-desktop"></i></span>
                                    <div>
                                        <div class="nom"><span><?php echo $h($m['nombre']); ?></span><b><?php echo number_format($m['n']); ?> <small>· <?php echo round($m['n'] / max(1, $kpi['sesiones']) * 100); ?>%</small> <?php echo $puntos_tipo($m['por_tipo']); ?></b></div>
                                        <div class="pista mf" style="width: <?php echo round($m['n'] / $medios_max * 100, 2); ?>%;">
                                            <?php foreach ($tipos_ver as $idt => $tp) { if (empty($m['por_tipo'][$idt])) { continue; } ?><span data-ancho="<?php echo round($m['por_tipo'][$idt] / $n * 100, 2); ?>" style="background: <?php echo $h($tp['color_hex']); ?>;"></span><?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- ===================== LISTADO DE SESIONES ===================== -->
                    <div class="vidrio lista-card aparece">
                        <div class="cab-card">
                            <div>
                                <h3 class="titulo-card">Sesiones del periodo</h3>
                                <div class="sub-card"><?php echo number_format(count($sesiones)); ?> sesión<?php echo count($sesiones) === 1 ? '' : 'es'; ?> · <?php echo number_format((int)$kpi['eess']); ?> establecimiento<?php echo (int)$kpi['eess'] === 1 ? '' : 's'; ?></div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="tabla-sesiones" width="100%">
                                <thead>
                                    <tr>
                                        <th>Código</th><th>Fecha</th><th>Tipo</th><th>Actividad</th><th>Modalidad</th><th>Duración</th><th>Part.</th>
                                        <th>Departamento</th><th>Municipio</th><th>Establecimiento</th><th>Registrado por</th><th>Ver</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($sesiones as $s) { $tp = isset($cat['tipos'][(int)$s['idtipo_teleeducacion']]) ? $cat['tipos'][(int)$s['idtipo_teleeducacion']] : ['nombre' => '', 'color_hex' => '#4e73df']; ?>
                                    <tr>
                                        <td data-order="<?php echo (int)$s['idteleeducacion']; ?>"><a class="codigo" href="../promocion_safci/imprime_teleeducacion.php?idteleeducacion=<?php echo (int)$s['idteleeducacion']; ?>" target="_blank" title="Ver la ficha de la sesión"
                                            onClick="window.open(this.href, this.target, 'width=800,height=900,top=50, left=200, scrollbars=YES'); return false;"><?php echo $h($s['codigo']); ?></a></td>
                                        <td data-order="<?php echo $h($s['fecha_sesion']); ?>"><?php echo $h($f_corta($s['fecha_sesion'])); ?></td>
                                        <td><span class="tipo-tag" style="<?php echo te_css_color($tp['color_hex']); ?>"><i class="fas fa-chalkboard-teacher"></i><?php echo $h($tp['nombre']); ?></span></td>
                                        <td><?php echo $h($s['nombre_actividad']); ?><span class="sub-celda"><?php echo $h(te_nombre($cat['actividades'], $s['idactividad_teleeducacion'])); ?></span></td>
                                        <td><?php echo $h(te_nombre($cat['modalidades'], $s['idmodalidad_teleeducacion'])); ?><span class="sub-celda"><?php echo $h(te_nombre($cat['medios'], $s['idmedio_digital'])); ?></span></td>
                                        <td data-order="<?php echo (int)$s['duracion_minutos']; ?>"><?php echo $h(te_hm($s['duracion_minutos'])); ?></td>
                                        <td><b><?php echo (int)$s['asistentes']; ?></b></td>
                                        <td><?php echo $h(mb_strtoupper((string)$s['departamento'])); ?></td>
                                        <td><?php echo $h(mb_strtoupper((string)$s['municipio'])); ?></td>
                                        <td><?php echo $h(mb_strtoupper($s['establecimiento_salud'])); ?></td>
                                        <td><?php echo $h(mb_strtoupper(trim($s['nombre'] . ' ' . $s['paterno'] . ' ' . $s['materno']))); ?></td>
                                        <td><a class="btn-ver" href="../promocion_safci/imprime_teleeducacion.php?idteleeducacion=<?php echo (int)$s['idteleeducacion']; ?>" target="_blank"
                                            onClick="window.open(this.href, this.target, 'width=800,height=900,top=50, left=200, scrollbars=YES'); return false;"><i class="fas fa-eye"></i> Ver</a></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if ($recortado) { ?><div class="aviso-limite"><i class="fas fa-info-circle mr-1"></i>Se muestran las <?php echo number_format($limite); ?> sesiones más recientes. Descargue el Excel para ver todas.</div><?php } ?>
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

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // ---- Filtros en cascada con auto-recarga (mismo comportamiento que Telemedicina) ----
        var dbDeptos = <?php echo json_encode($deptos, JSON_UNESCAPED_UNICODE); ?>;
        var dbMunis = <?php echo json_encode($munis, JSON_UNESCAPED_UNICODE); ?>;
        var dbEess = <?php echo json_encode($eess, JSON_UNESCAPED_UNICODE); ?>;
        var initDepto = <?php echo $g_dep !== '' ? json_encode($g_dep) : 'null'; ?>;
        var initMuni = <?php echo $g_mun !== '' ? json_encode($g_mun) : 'null'; ?>;
        var initEess = <?php echo $g_est !== '' ? json_encode($g_est) : 'null'; ?>;
        var dbMeds = <?php echo json_encode($medicos, JSON_UNESCAPED_UNICODE); ?>;
        var initMed = <?php echo $g_med !== '' ? json_encode($g_med) : 'null'; ?>;
        var form = document.getElementById('form-filtros');

        function poblarLista(id, datos) {
            var dl = document.getElementById(id); dl.innerHTML = '';
            datos.forEach(function (it) { var o = document.createElement('option'); o.value = it.nombre; dl.appendChild(o); });
        }
        function buscar(datos, id) { for (var i = 0; i < datos.length; i++) { if (String(datos[i].id) === String(id)) { return datos[i]; } } return null; }

        poblarLista('dl-deptos', dbDeptos);
        if (initDepto) { var d = buscar(dbDeptos, initDepto); if (d) { document.getElementById('inp-depto').value = d.nombre; } }
        poblarLista('dl-munis', initDepto ? dbMunis.filter(function (m) { return String(m.idDepto) === String(initDepto); }) : dbMunis);
        if (initMuni) { var m = buscar(dbMunis, initMuni); if (m) { document.getElementById('inp-muni').value = m.nombre; } }
        poblarLista('dl-ests', initMuni ? dbEess.filter(function (e) { return String(e.idMuni) === String(initMuni); }) : (initDepto ? [] : dbEess));
        if (initEess) { var e = buscar(dbEess, initEess); if (e) { document.getElementById('inp-est').value = e.nombre; } }
        poblarLista('dl-meds', dbMeds);
        if (initMed) { var md = buscar(dbMeds, initMed); if (md) { document.getElementById('inp-med').value = md.nombre; } }

        // Al elegir un lugar se limpian los que dependen de él
        function aplicarFiltro(inputId, hiddenId, datos, dependientes) {
            document.getElementById(inputId).addEventListener('change', function () {
                var val = this.value.trim().toUpperCase();
                var obj = datos.filter(function (it) { return it.nombre.toUpperCase() === val; })[0];
                if (!obj && val !== '') { return; }
                document.getElementById(hiddenId).value = obj ? obj.id : '';
                dependientes.forEach(function (dep) { document.getElementById(dep).value = ''; });
                form.submit();
            });
        }
        aplicarFiltro('inp-depto', 'val-iddepartamento', dbDeptos, ['val-idmunicipio', 'val-idestablecimiento']);
        aplicarFiltro('inp-muni', 'val-idmunicipio', dbMunis, ['val-idestablecimiento']);
        aplicarFiltro('inp-est', 'val-idestablecimiento', dbEess, []);
        aplicarFiltro('inp-med', 'val-idusuario_medico', dbMeds, []);

        // ---- Animaciones: segmentos y barras crecen hasta su valor ----
        requestAnimationFrame(function () {
            document.querySelectorAll('.px .seg[data-grow]').forEach(function (s) { s.style.flexGrow = s.getAttribute('data-grow'); });
            document.querySelectorAll('.px [data-ancho]').forEach(function (b) { b.style.width = b.getAttribute('data-ancho') + '%'; });
        });

        // ---- Listado ----
        $('#tabla-sesiones').DataTable({
            order: [[1, 'desc']],
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
            columnDefs: [{ orderable: false, targets: -1 }],
            language: {
                lengthMenu: 'Mostrar _MENU_ registros', zeroRecords: 'No se encontraron resultados', searchPlaceholder: 'Buscar registros',
                info: 'Registros _START_ al _END_ de _TOTAL_', infoEmpty: 'Sin sesiones en el periodo', infoFiltered: '(filtrado de _MAX_)',
                emptyTable: 'Sin sesiones en el periodo', search: 'Buscar:',
                paginate: { first: 'Primero', last: 'Último', next: 'Siguiente', previous: 'Anterior' }
            }
        });
    });
    </script>
</body>
</html>
