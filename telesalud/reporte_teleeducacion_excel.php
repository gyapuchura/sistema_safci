<?php
include("../cabf.php");
include("../inc.config.php");

// =========================================================================
// EXTRACTO EXCEL DE TELEEDUCACIÓN (Extractos de Telesalud y consolidado de Teleeducación)
//   1. Encabezado: periodo, lugar filtrado y fecha de emisión
//   2. Resumen por tipo: sesiones, horas y participantes por género
//   3. Una tabla por tipo, una fila por sesión, con SUS grupos (perfiles o grupos etarios) por género
// Todo se arma desde los catálogos: un tipo, grupo o género nuevo aparece solo.
// Mismos filtros y alcance que el consolidado: periodo por fecha de la sesión, lugar y médico (quien registró la sesión).
// =========================================================================
define('TM_SOLO_ALCANCE', true);
include("inc_telemedicina.php");
include("../promocion_safci/inc_teleeducacion.php");
date_default_timezone_set('America/La_Paz');

$es_fecha = function ($f) { return is_string($f) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $f) && strtotime($f) !== false; };
$inicio       = isset($_POST['inicio']) && $es_fecha($_POST['inicio']) ? $_POST['inicio'] : date('Y-m-01');
$finalizacion = isset($_POST['finalizacion']) && $es_fecha($_POST['finalizacion']) ? $_POST['finalizacion'] : date('Y-m-d');
if ($finalizacion < $inicio) { list($inicio, $finalizacion) = [$finalizacion, $inicio]; }
$post = function ($k) { return isset($_POST[$k]) ? (string)$_POST[$k] : ''; };

// El departamento y municipio del lugar de trabajo se aplican aunque se cambien los datos enviados;
// un médico fuera del alcance deja el reporte vacío ('0') en vez de traer a todos
$f = tm_forzar_alcance($link, ['iddepartamento' => $post('iddepartamento'), 'idmunicipio' => $post('idmunicipio'), 'idestablecimiento' => $post('idestablecimiento'), 'idusuario_medico' => $post('idusuario_medico')], '0');
$where = te_where($link, $inicio, $finalizacion, $f);
$cat = te_catalogos($link);

// Nombre del lugar filtrado (para el encabezado)
$nombre_de = function ($sql) use ($link) { $r = mysqli_query($link, $sql); $x = $r ? mysqli_fetch_row($r) : null; return $x ? mb_strtoupper(trim($x[0])) : ''; };
$lugar_txt = 'TODO EL PAÍS';
if ($f['idestablecimiento'] !== '') { $lugar_txt = 'ESTABLECIMIENTO: ' . $nombre_de("SELECT establecimiento_salud FROM establecimiento_salud WHERE idestablecimiento_salud = '" . (int)$f['idestablecimiento'] . "'"); }
elseif ($f['idmunicipio'] !== '') { $lugar_txt = 'MUNICIPIO: ' . $nombre_de("SELECT municipio FROM municipios WHERE idmunicipio = '" . (int)$f['idmunicipio'] . "'"); }
elseif ($f['iddepartamento'] !== '') { $lugar_txt = 'DEPARTAMENTO: ' . $nombre_de("SELECT departamento FROM departamento WHERE iddepartamento = '" . (int)$f['iddepartamento'] . "'"); }
if ($f['idusuario_medico'] !== '') {
    $lugar_txt .= ' · MÉDICO: ' . $nombre_de("SELECT CONCAT_WS(' ', n.nombre, n.paterno, n.materno) FROM usuarios u INNER JOIN nombre n ON n.idnombre = u.idnombre WHERE u.idusuario = '" . (int)$f['idusuario_medico'] . "'");
}

// Participantes por sesión, grupo y género
$part = [];
$res = mysqli_query($link, "SELECT a.idteleeducacion, a.idgrupo_asistente_te, a.idgenero, a.cantidad FROM teleeducacion t
    INNER JOIN teleeducacion_asistente a ON a.idteleeducacion = t.idteleeducacion WHERE $where");
while ($r = mysqli_fetch_row($res)) { $part[(int)$r[0]][(int)$r[1]][(int)$r[2]] = (int)$r[3]; }
// Recursos usados por sesión (en el orden del catálogo)
$recursos = [];
$res = mysqli_query($link, "SELECT tr.idteleeducacion, tr.idrecurso_teleeducacion FROM teleeducacion t
    INNER JOIN teleeducacion_recurso tr ON tr.idteleeducacion = t.idteleeducacion
    INNER JOIN recurso_teleeducacion rc ON rc.idrecurso_teleeducacion = tr.idrecurso_teleeducacion
    WHERE $where ORDER BY rc.orden, rc.idrecurso_teleeducacion");
while ($r = mysqli_fetch_row($res)) { $recursos[(int)$r[0]][] = te_nombre($cat['recursos'], $r[1]); }

// Sesiones agrupadas por tipo
$por_tipo = [];
$res = mysqli_query($link, "SELECT t.*, d.departamento, m.municipio, es.establecimiento_salud, n.nombre, n.paterno, n.materno
    FROM teleeducacion t
    INNER JOIN establecimiento_salud es ON es.idestablecimiento_salud = t.idestablecimiento_salud
    LEFT JOIN municipios m ON m.idmunicipio = t.idmunicipio
    LEFT JOIN departamento d ON d.iddepartamento = t.iddepartamento
    LEFT JOIN usuarios u ON u.idusuario = t.idusuario
    LEFT JOIN nombre n ON n.idnombre = u.idnombre
    WHERE $where ORDER BY t.fecha_sesion, t.idteleeducacion");
while ($s = mysqli_fetch_assoc($res)) { $por_tipo[(int)$s['idtipo_teleeducacion']][] = $s; }

// Tipos del extracto: los activos y los que tengan sesiones en el periodo
$tipos = [];
foreach ($cat['tipos'] as $idt => $tp) { if ($tp['activo'] || isset($por_tipo[$idt])) { $tipos[$idt] = $tp; } }

$h = function ($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); };
$f_corta = function ($x) { $t = strtotime((string)$x); return $t ? date('d/m/Y', $t) : ''; };
$generos = $cat['generos'];
$n_gen = count($generos);

header('Content-type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename=EXTRACTO_TELEEDUCACION_' . date('Y-m-d') . '.xls');
header('Pragma: no-cache');
header('Expires: 0');
tm_salida_excel_compacta();
?>
<html>
<head>
<meta charset="utf-8">
<style>
  td, th { font-family: Arial; font-size: 10pt; vertical-align: middle; }
  .titulo { font-size: 14pt; font-weight: bold; background: #224abe; color: #ffffff; text-align: center; }
  .meta { text-align: left; color: #34353d; }
  .seccion { font-size: 12pt; font-weight: bold; color: #ffffff; text-align: left; }
  .cab { font-weight: bold; text-align: center; background: #eaecf4; color: #34353d; }
  .cab-grupo { font-weight: bold; text-align: center; color: #34353d; }
  .total td { font-weight: bold; background: #eaecf4; }
  .n { text-align: center; }
  .txt { mso-number-format: "\@"; }
</style>
</head>
<body>
<?php
// Columnas fijas de cada tabla de tipo (sin las de participantes)
$fijas_ini = ['N°', 'CÓDIGO', 'DEPARTAMENTO', 'MUNICIPIO', 'ESTABLECIMIENTO', 'TIPO DE ACTIVIDAD', 'NOMBRE DE LA ACTIVIDAD', 'FECHA SESIÓN', 'DURACIÓN (H:MIN)', 'MODALIDAD', 'MEDIO DIGITAL'];
$fijas_fin = ['REGISTRADO POR', 'FECHA REGISTRO', 'HORA', 'MODIFICADO'];
$ancho_max = 0;
foreach ($tipos as $idt => $tp) {
    $cols = 0; foreach (te_filas_grupos($cat, $idt, false) as $fl) { if ($fl['nivel'] !== 'encabezado') { $cols++; } }
    $ancho_max = max($ancho_max, count($fijas_ini) + ($tp['requiere_recursos'] ? 1 : 0) + ($cols + 1) * $n_gen + 1 + count($fijas_fin));
}
$ancho_max = max($ancho_max, 6);
?>
<table border="1">
    <tr><th colspan="<?php echo $ancho_max; ?>" class="titulo">EXTRACTO DE TELEEDUCACIÓN - PROGRAMA NACIONAL DE TELESALUD - MINISTERIO DE SALUD Y DEPORTES</th></tr>
    <tr><td colspan="<?php echo $ancho_max; ?>" class="meta"><b>Periodo (fecha de la sesión):</b> <?php echo $f_corta($inicio); ?> al <?php echo $f_corta($finalizacion); ?> &nbsp;·&nbsp; <b>Lugar:</b> <?php echo $h($lugar_txt); ?> &nbsp;·&nbsp; <b>Emitido:</b> <?php echo date('d/m/Y H:i'); ?></td></tr>
    <tr><td colspan="<?php echo $ancho_max; ?>"></td></tr>

    <!-- ===================== RESUMEN POR TIPO ===================== -->
    <tr><td colspan="<?php echo $ancho_max; ?>" class="seccion" style="background: #4e73df;">RESUMEN POR TIPO DE TELEEDUCACIÓN</td></tr>
    <tr>
        <th class="cab">TIPO</th><th class="cab">SESIONES</th><th class="cab">HORAS (H:MIN)</th>
        <?php foreach ($generos as $gen) { ?><th class="cab"><?php echo $h($gen); ?></th><?php } ?>
        <th class="cab">TOTAL PARTICIPANTES</th>
    </tr>
    <?php $tot_res = ['s' => 0, 'h' => 0, 'p' => 0, 'g' => array_fill_keys(array_keys($generos), 0)];
    foreach ($tipos as $idt => $tp) {
        $lista = isset($por_tipo[$idt]) ? $por_tipo[$idt] : [];
        $hrs = 0; $pt = 0; $pg = array_fill_keys(array_keys($generos), 0);
        foreach ($lista as $s) {
            $hrs += (int)$s['duracion_minutos']; $pt += (int)$s['asistentes'];
            if (isset($part[(int)$s['idteleeducacion']])) { foreach ($part[(int)$s['idteleeducacion']] as $porg) { foreach ($porg as $idg => $c) { if (isset($pg[$idg])) { $pg[$idg] += $c; } } } }
        }
        $tot_res['s'] += count($lista); $tot_res['h'] += $hrs; $tot_res['p'] += $pt;
        foreach ($pg as $idg => $c) { $tot_res['g'][$idg] += $c; } ?>
    <tr>
        <td style="color: <?php echo $h($tp['color_hex']); ?>; font-weight: bold;"><?php echo $h($tp['nombre']); ?></td>
        <td class="n"><?php echo count($lista); ?></td>
        <td class="n txt"><?php echo te_hm($hrs); ?></td>
        <?php foreach ($pg as $c) { ?><td class="n"><?php echo $c; ?></td><?php } ?>
        <td class="n"><b><?php echo $pt; ?></b></td>
    </tr>
    <?php } ?>
    <tr class="total">
        <td>TOTAL</td><td class="n"><?php echo $tot_res['s']; ?></td><td class="n txt"><?php echo te_hm($tot_res['h']); ?></td>
        <?php foreach ($tot_res['g'] as $c) { ?><td class="n"><?php echo $c; ?></td><?php } ?>
        <td class="n"><?php echo $tot_res['p']; ?></td>
    </tr>

    <?php
    // ===================== UNA TABLA POR TIPO =====================
    foreach ($tipos as $idt => $tp) {
        $lista = isset($por_tipo[$idt]) ? $por_tipo[$idt] : [];
        // Grupos con datos en el periodo (aunque luego se hayan desactivado) + los activos
        $con_datos = [];
        foreach ($lista as $s) { if (isset($part[(int)$s['idteleeducacion']])) { $con_datos = array_merge($con_datos, array_keys($part[(int)$s['idteleeducacion']])); } }
        $filas_g = te_filas_grupos($cat, $idt, true, array_values(array_unique($con_datos)));
        // Columnas de participantes: [idgrupo, nombre, encabezado al que pertenece]
        $cols = []; $enc = '';
        foreach ($filas_g as $fl) {
            if ($fl['nivel'] === 'encabezado') { $enc = $fl['g']['nombre']; continue; }
            $cols[] = [$fl['g']['id'], $fl['g']['nombre'], $fl['nivel'] === 'sub' ? $enc : ''];
        }
        $fijas = $fijas_ini; if ($tp['requiere_recursos']) { $fijas[] = 'RECURSOS USADOS'; }
        // En Excel no hay transparencias: el encabezado de los grupos usa el color del tipo mezclado con blanco
        $mezcla = function ($hex, $p) { $c = []; for ($i = 1; $i < 7; $i += 2) { $c[] = (int)round(hexdec(substr($hex, $i, 2)) * $p + 255 * (1 - $p)); } return vsprintf('#%02x%02x%02x', $c); };
        $fondo_cab = $mezcla($tp['color_hex'], .25);
    ?>
    <tr><td colspan="<?php echo $ancho_max; ?>"></td></tr>
    <tr><td colspan="<?php echo $ancho_max; ?>" class="seccion" style="background: <?php echo $h($tp['color_hex']); ?>;"><?php echo $h($tp['nombre']); ?> &nbsp;·&nbsp; <?php echo count($lista) . (count($lista) === 1 ? ' SESIÓN' : ' SESIONES'); ?> &nbsp;·&nbsp; <?php echo $h($tp['titulo_asistentes']); ?></td></tr>
    <?php if (!$lista) { ?>
    <tr><td colspan="<?php echo $ancho_max; ?>">Sin sesiones en el periodo.</td></tr>
    <?php continue; } ?>
    <tr>
        <?php foreach ($fijas as $c) { ?><th class="cab" rowspan="2"><?php echo $h($c); ?></th><?php } ?>
        <?php foreach ($cols as $c) { ?><th class="cab-grupo" colspan="<?php echo $n_gen; ?>" style="background: <?php echo $fondo_cab; ?>;"><?php echo $h(mb_strtoupper(($c[2] !== '' ? $c[2] . ' - ' : '') . $c[1])); ?></th><?php } ?>
        <th class="cab-grupo" colspan="<?php echo $n_gen + 1; ?>" style="background: <?php echo $fondo_cab; ?>;">TOTAL PARTICIPANTES</th>
        <?php foreach ($fijas_fin as $c) { ?><th class="cab" rowspan="2"><?php echo $h($c); ?></th><?php } ?>
    </tr>
    <tr>
        <?php foreach ($cols as $c) { foreach ($generos as $gen) { ?><th class="cab"><?php echo $h(te_genero_corto($gen)); ?></th><?php } } ?>
        <?php foreach ($generos as $gen) { ?><th class="cab"><?php echo $h(te_genero_corto($gen)); ?></th><?php } ?><th class="cab">TOTAL</th>
    </tr>
    <?php $i = 0; $sum_h = 0; $sum_cols = []; $sum_gen = array_fill_keys(array_keys($generos), 0); $sum_t = 0;
    foreach ($lista as $s) { $i++; $id = (int)$s['idteleeducacion']; $sum_h += (int)$s['duracion_minutos']; $sum_t += (int)$s['asistentes'];
        $gen_ses = array_fill_keys(array_keys($generos), 0); ?>
    <tr>
        <td class="n"><?php echo $i; ?></td>
        <td class="txt"><?php echo $h($s['codigo']); ?></td>
        <td><?php echo $h(mb_strtoupper((string)$s['departamento'])); ?></td>
        <td><?php echo $h(mb_strtoupper((string)$s['municipio'])); ?></td>
        <td><?php echo $h(mb_strtoupper($s['establecimiento_salud'])); ?></td>
        <td><?php echo $h(te_nombre($cat['actividades'], $s['idactividad_teleeducacion'])); ?></td>
        <td><?php echo $h($s['nombre_actividad']); ?></td>
        <td class="n txt"><?php echo $f_corta($s['fecha_sesion']); ?></td>
        <td class="n txt"><?php echo te_hm($s['duracion_minutos']); ?></td>
        <td><?php echo $h(te_nombre($cat['modalidades'], $s['idmodalidad_teleeducacion'])); ?></td>
        <td><?php echo $h(te_nombre($cat['medios'], $s['idmedio_digital'])); ?></td>
        <?php if ($tp['requiere_recursos']) { ?><td><?php echo $h(isset($recursos[$id]) ? implode(', ', $recursos[$id]) : ''); ?></td><?php } ?>
        <?php foreach ($cols as $c) { foreach (array_keys($generos) as $idg) {
            $v = isset($part[$id][$c[0]][$idg]) ? $part[$id][$c[0]][$idg] : 0;
            $gen_ses[$idg] += $v; $sum_cols[$c[0]][$idg] = (isset($sum_cols[$c[0]][$idg]) ? $sum_cols[$c[0]][$idg] : 0) + $v; ?>
        <td class="n"><?php echo $v; ?></td>
        <?php } } ?>
        <?php foreach ($gen_ses as $idg => $v) { $sum_gen[$idg] += $v; ?><td class="n"><?php echo $v; ?></td><?php } ?>
        <td class="n"><b><?php echo (int)$s['asistentes']; ?></b></td>
        <td><?php echo $h(mb_strtoupper(trim($s['nombre'] . ' ' . $s['paterno'] . ' ' . $s['materno']))); ?></td>
        <td class="n txt"><?php echo $f_corta($s['fecha_registro']); ?></td>
        <td class="n txt"><?php echo $h($s['hora_registro']); ?></td>
        <td class="n txt"><?php echo $s['fecha_modificacion'] ? date('d/m/Y H:i', strtotime($s['fecha_modificacion'])) : ''; ?></td>
    </tr>
    <?php } ?>
    <tr class="total">
        <td colspan="8">TOTAL <?php echo $h($tp['nombre']); ?>: <?php echo $i . ($i === 1 ? ' SESIÓN' : ' SESIONES'); ?></td>
        <td class="n txt"><?php echo te_hm($sum_h); ?></td>
        <td colspan="<?php echo count($fijas) - 9; ?>"></td>
        <?php foreach ($cols as $c) { foreach (array_keys($generos) as $idg) { ?><td class="n"><?php echo isset($sum_cols[$c[0]][$idg]) ? $sum_cols[$c[0]][$idg] : 0; ?></td><?php } } ?>
        <?php foreach ($sum_gen as $v) { ?><td class="n"><?php echo $v; ?></td><?php } ?>
        <td class="n"><?php echo $sum_t; ?></td>
        <td colspan="<?php echo count($fijas_fin); ?>"></td>
    </tr>
    <?php } ?>
</table>
</body>
</html>
