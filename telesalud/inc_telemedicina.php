<?php
// =========================================================================
// TELEMEDICINA: bloque compartido por las 4 pestañas
//   (teleinterconsultas, teleinterconsultas_destino, teleconsultas, telemetrias)
//   0. Alcance del usuario según su perfil y lugar de trabajo (valores por defecto y campos fijos)
//   1. Filtros compartidos en la sesión: fechas, departamento, municipio, establecimiento y médico
//   2. Barra de pestañas en píldora
//   3. Estilos del diseño (variables derivadas de la paleta de SB Admin 2)
// Se incluye DESPUÉS de cabf.php (sesión iniciada) y ANTES de leer $_GET.
// Cada página interpreta el mismo filtro según su rol (origen, especialista o atención).
// =========================================================================

$tm_claves = ['fecha_inicio', 'fecha_fin', 'iddepartamento', 'idmunicipio', 'idestablecimiento', 'idusuario_medico'];

$tm_pestanas = [
    'consolidado'   => ['Consolidado', 'telesalud_dashboard.php', 'fa-th-large', 'Producción de'],
    'generadas'     => ['Generadas', 'teleinterconsultas.php', 'fa-share-square', 'Casos generados por'],
    'respuestas'    => ['Respuestas', 'teleinterconsultas_destino.php', 'fa-reply-all', 'Casos respondidos por'],
    'teleconsultas' => ['Teleconsultas', 'teleconsultas.php', 'fa-headset', 'Teleconsultas realizadas en'],
    'telemetrias'   => ['Telemetrías', 'telemetrias.php', 'fa-heartbeat', 'Telemetrías realizadas en'],
];

// --- 0. ALCANCE DEL USUARIO (según su perfil y su lugar de trabajo ACTUAL: personal.iddato_laboral) ---
//   1. ADMINISTRADOR ................................ todo el país, filtros libres
//   2. Trabaja en la Coordinación Nacional ........... todo el país, filtros libres
//   3. Trabaja en una Oficina de Coordinación Dptal. . su departamento por defecto, filtros libres
//   4. ADM-MUNICIPAL ................................ departamento y municipio fijos; establecimiento libre
//   5. PERSONAL ..................................... departamento y municipio fijos; su establecimiento por defecto
//   Sin lugar de trabajo cargado: aviso · Otros perfiles: sin acceso
function tm_alcance($link) {
    static $a = null;
    if ($a !== null) { return $a; }
    $perfil = isset($_SESSION['perfil_ss']) ? (string)$_SESSION['perfil_ss'] : '';
    $idu = isset($_SESSION['idusuario_ss']) ? (int)$_SESSION['idusuario_ss'] : 0;
    $a = ['nivel' => 'sin_acceso', 'fijos' => [], 'defecto' => [], 'lugar' => null];
    if (!in_array($perfil, ['ADMINISTRADOR', 'ADM-MUNICIPAL', 'PERSONAL'], true)) { return $a; }
    if ($perfil === 'ADMINISTRADOR') { $a['nivel'] = 'nacional'; return $a; }

    $res = mysqli_query($link, "SELECT es.idestablecimiento_salud AS est, es.idmunicipio AS mun, es.iddepartamento AS dep, UPPER(IFNULL(rs.red_salud, '')) AS red
        FROM personal p INNER JOIN dato_laboral dl ON dl.iddato_laboral = p.iddato_laboral
        INNER JOIN establecimiento_salud es ON es.idestablecimiento_salud = dl.idestablecimiento_salud
        LEFT JOIN red_salud rs ON rs.idred_salud = es.idred_salud
        WHERE p.idusuario = '$idu' ORDER BY p.idpersonal DESC LIMIT 1");
    $l = $res ? mysqli_fetch_assoc($res) : null;
    if (!$l || !$l['mun'] || !$l['dep']) { $a['nivel'] = 'sin_datos'; return $a; }
    $a['lugar'] = $l;

    $coordinacion = strpos($l['red'], 'COORDINACI') !== false;
    if ($coordinacion && strpos($l['red'], 'NACIONAL') !== false) {
        $a['nivel'] = 'nacional';
    } elseif ($coordinacion && strpos($l['red'], 'DEPARTAMENTAL') !== false) {
        $a['nivel'] = 'departamental';
        $a['defecto'] = ['iddepartamento' => (string)$l['dep']];
    } else {
        $a['nivel'] = 'municipal';
        $a['fijos'] = ['iddepartamento' => (string)$l['dep'], 'idmunicipio' => (string)$l['mun']];
        $a['defecto'] = $a['fijos'] + ($perfil === 'PERSONAL' ? ['idestablecimiento' => (string)$l['est']] : []);
    }
    return $a;
}
function tm_es_fijo($clave) {
    global $link;
    return isset(tm_alcance($link)['fijos'][$clave]);
}
// Atributos y candado para los campos fijados por el lugar de trabajo
function tm_bloqueo($clave) {
    return tm_es_fijo($clave) ? ' readonly aria-readonly="true" title="Fijado según su lugar de trabajo"' : '';
}
function tm_candado($clave) {
    return tm_es_fijo($clave) ? ' <i class="fas fa-lock" style="font-size: 9px; opacity: .7;" aria-hidden="true"></i>' : '';
}

// Médicos con producción de telesalud (o Personal Telesalud que trabaja ahí) en el lugar de los filtros elegidos
function tm_medicos($link, $f) {
    static $cache = [];
    $clave = (isset($f['iddepartamento']) ? $f['iddepartamento'] : '') . '|' . (isset($f['idmunicipio']) ? $f['idmunicipio'] : '') . '|' . (isset($f['idestablecimiento']) ? $f['idestablecimiento'] : '');
    if (isset($cache[$clave])) { return $cache[$clave]; }
    $w = '';
    foreach (['iddepartamento' => 'x.dep', 'idmunicipio' => 'x.mun', 'idestablecimiento' => 'x.est'] as $k => $col) {
        if (isset($f[$k]) && $f[$k] !== '') { $w .= " AND $col = '" . mysqli_real_escape_string($link, (string)$f[$k]) . "'"; }
    }
    $sql = "SELECT u.idusuario, n.nombre, n.paterno, n.materno FROM (
            SELECT r.idusuario AS u, r.iddepartamento AS dep, r.idmunicipio AS mun, r.idestablecimiento_salud AS est FROM referencia_hc r
          UNION SELECT d.idusuario_r, es.iddepartamento, es.idmunicipio, es.idestablecimiento_salud FROM deriva_referencia_hc d INNER JOIN establecimiento_salud es ON es.idestablecimiento_salud = d.idestablecimiento_salud_r
          UNION SELECT a.idusuario, a.iddepartamento, a.idmunicipio, a.idestablecimiento_salud FROM atencion_psafci a WHERE a.idtipo_atencion IN ('3', '4')
          UNION SELECT p.idusuario, es.iddepartamento, es.idmunicipio, es.idestablecimiento_salud FROM personal p INNER JOIN dato_laboral dl ON dl.iddato_laboral = p.iddato_laboral
                INNER JOIN establecimiento_salud es ON es.idestablecimiento_salud = dl.idestablecimiento_salud INNER JOIN usuarios ua ON ua.idusuario = p.idusuario
                WHERE dl.idcargo_organigrama = '54' AND ua.condicion = 'ACTIVO'
        ) x INNER JOIN usuarios u ON u.idusuario = x.u INNER JOIN nombre n ON n.idnombre = u.idnombre
        WHERE 1 = 1 $w GROUP BY u.idusuario, n.nombre, n.paterno, n.materno ORDER BY n.nombre, n.paterno, n.materno";
    $lista = [];
    $res = mysqli_query($link, $sql);
    if ($res) { while ($r = mysqli_fetch_array($res)) { $lista[] = ['id' => $r[0], 'nombre' => mb_strtoupper(trim($r[1] . ' ' . $r[2] . ' ' . $r[3]))]; } }
    return $cache[$clave] = $lista;
}

// Aplica el alcance a unos filtros: campos fijos forzados; establecimiento y médico deben estar dentro del alcance.
// $medico_fuera: valor para un médico sin producción en ese lugar. Pantallas: '' (se quita el filtro);
// reportes: '0' (ningún usuario tiene ese id, así el reporte sale vacío en vez de traer a todos los médicos)
function tm_forzar_alcance($link, $f, $medico_fuera = '') {
    $a = tm_alcance($link);
    foreach ($a['fijos'] as $k => $v) { $f[$k] = $v; }
    if (!empty($a['fijos']) && isset($f['idestablecimiento']) && $f['idestablecimiento'] !== '') {
        $res = mysqli_query($link, "SELECT 1 FROM establecimiento_salud WHERE idestablecimiento_salud = '" . mysqli_real_escape_string($link, $f['idestablecimiento']) . "' AND idmunicipio = '" . mysqli_real_escape_string($link, $a['fijos']['idmunicipio']) . "'");
        if (!$res || mysqli_num_rows($res) === 0) { $f['idestablecimiento'] = ''; }
    }
    if (isset($f['idusuario_medico']) && $f['idusuario_medico'] !== '') {
        $ids = array_map(function ($m) { return (string)$m['id']; }, tm_medicos($link, $f));
        if (!in_array((string)$f['idusuario_medico'], $ids, true)) { $f['idusuario_medico'] = $medico_fuera; }
    }
    return $f;
}

// Catálogos de los filtros, recortados al alcance (la lista de médicos sigue al lugar elegido)
function tm_catalogos($link) {
    $a = tm_alcance($link);
    $mun_fijo = isset($a['fijos']['idmunicipio']) ? mysqli_real_escape_string($link, $a['fijos']['idmunicipio']) : '';
    $dep_fijo = isset($a['fijos']['iddepartamento']) ? mysqli_real_escape_string($link, $a['fijos']['iddepartamento']) : '';
    $deptos = []; $munis = []; $eess = [];
    $res = mysqli_query($link, "SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento != '10'" . ($dep_fijo !== '' ? " AND iddepartamento = '$dep_fijo'" : ''));
    if ($res) { while ($r = mysqli_fetch_array($res)) { $deptos[] = ['id' => $r[0], 'nombre' => mb_strtoupper(trim($r[1]))]; } }
    $res = mysqli_query($link, "SELECT idmunicipio, municipio, iddepartamento FROM municipios" . ($mun_fijo !== '' ? " WHERE idmunicipio = '$mun_fijo'" : ''));
    if ($res) { while ($r = mysqli_fetch_array($res)) { $munis[] = ['id' => $r[0], 'nombre' => mb_strtoupper(trim($r[1])), 'idDepto' => $r[2]]; } }
    $res = mysqli_query($link, "SELECT idestablecimiento_salud, establecimiento_salud, idmunicipio FROM establecimiento_salud" . ($mun_fijo !== '' ? " WHERE idmunicipio = '$mun_fijo'" : ''));
    if ($res) { while ($r = mysqli_fetch_array($res)) { $eess[] = ['id' => $r[0], 'nombre' => mb_strtoupper(trim($r[1])), 'idMuni' => $r[2]]; } }
    return [$deptos, $munis, $eess, tm_medicos($link, $_GET)];
}

// Periodo de comparación de las flechas ▲▼ (todas las pantallas):
//   periodo dentro de un solo mes -> los mismos días del MES ANTERIOR (1–27 oct contra 1–27 sep)
//   cualquier otro periodo        -> las mismas fechas de la GESTIÓN ANTERIOR (ene–oct 2026 contra ene–oct 2025)
// Si el mes de destino tiene menos días, se usa su último día (31 mar -> 28/29 feb).
function tm_periodo_anterior(DateTime $ini, DateTime $fin) {
    $mismo_mes = $ini->format('Y-m') === $fin->format('Y-m');
    $meses = $mismo_mes ? 1 : 12;
    $mover = function (DateTime $f) use ($meses) {
        $y = (int)$f->format('Y'); $m = (int)$f->format('n') - $meses;
        while ($m < 1) { $m += 12; $y--; }
        $dias_mes = (int)(new DateTime(sprintf('%04d-%02d-01', $y, $m)))->format('t');
        return new DateTime(sprintf('%04d-%02d-%02d', $y, $m, min((int)$f->format('j'), $dias_mes)));
    };
    $a = $mover($ini); $b = $mover($fin);
    $mes_corto = ['', 'ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];
    $rango = (int)$a->format('j') . ' ' . $mes_corto[(int)$a->format('n')] . ($a->format('Y') !== $b->format('Y') ? ' ' . $a->format('Y') : '')
        . ' – ' . (int)$b->format('j') . ' ' . $mes_corto[(int)$b->format('n')] . ' ' . $b->format('Y');
    $GLOBALS['tm_anterior'] = ['etq' => $mismo_mes ? 'mes anterior' : 'gestión anterior', 'rango' => $rango];
    return [$a, $b];
}
// Nombre del periodo de comparación ("mes anterior" / "gestión anterior") y su rango de fechas, para textos y ayudas
// $articulo = true antepone "el" / "la" ("el mes anterior", "la gestión anterior")
function tm_etq_anterior($con_rango = false, $articulo = false) {
    $p = isset($GLOBALS['tm_anterior']) ? $GLOBALS['tm_anterior'] : ['etq' => 'periodo anterior', 'rango' => ''];
    $art = $articulo ? (strpos($p['etq'], 'gestión') === 0 ? 'la ' : 'el ') : '';
    return $art . $p['etq'] . ($con_rango && $p['rango'] !== '' ? ' (' . $p['rango'] . ')' : '');
}

// Caché de 10 minutos de una pantalla completa (Generadas, Respuestas, Teleconsultas, Telemetrías):
// la primera vez se calcula y se guarda; al volver con los mismos filtros se muestra al instante.
// La clave es usuario + pantalla + filtros efectivos (ya recortados a su alcance). ?refrescar=1 la recalcula.
function tm_cache_pantalla($ttl = 600) {
    $dir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'medisafci_telemedicina';
    if (!is_dir($dir)) { @mkdir($dir, 0700, true); }
    if (!is_dir($dir) || !is_writable($dir)) { unset($_GET['refrescar']); return; } // sin carpeta: funciona igual, sin caché
    $refrescar = isset($_GET['refrescar']);
    unset($_GET['refrescar']);
    $filtros = [];
    foreach (['fecha_inicio', 'fecha_fin', 'iddepartamento', 'idmunicipio', 'idestablecimiento', 'idusuario_medico'] as $k) { $filtros[$k] = isset($_GET[$k]) ? (string)$_GET[$k] : ''; }
    $clave = md5(json_encode([basename($_SERVER['SCRIPT_NAME']), isset($_SESSION['idusuario_ss']) ? $_SESSION['idusuario_ss'] : '', $filtros, date('Y-m-d'), 'v2'])); // subir la versión al cambiar el diseño, para no servir copias viejas
    $archivo = $dir . DIRECTORY_SEPARATOR . $clave . '.html';
    if (mt_rand(1, 30) === 1) { foreach ((array)glob($dir . DIRECTORY_SEPARATOR . '*.html') as $viejo) { if (is_file($viejo) && time() - filemtime($viejo) > $ttl) { @unlink($viejo); } } }
    if (!$refrescar && is_file($archivo) && time() - filemtime($archivo) < $ttl) { readfile($archivo); exit; }
    ob_start(function ($html) use ($archivo) {
        // Solo se guarda una página completa y sin errores
        if (stripos($html, '</html>') !== false && !preg_match('/(Fatal error|Warning|Parse error)<\/b>/', $html)) { @file_put_contents($archivo, $html, LOCK_EX); }
        return $html;
    });
}

// Contacto de WhatsApp del Personal Telesalud (cargo 54) del municipio de un establecimiento:
// primero quien trabaja en ese mismo establecimiento, luego cualquiera del municipio. null si no hay celular registrado.
// Se resuelven TODOS los establecimientos pedidos en UNA sola consulta (la lista de pendientes puede ser larga).
function tm_contacto_telesalud($link, $id_est) {
    $c = tm_contactos_telesalud($link, [$id_est]);
    return $c[(int)$id_est];
}
function tm_contactos_telesalud($link, $ids) {
    static $cache = [];
    $faltan = [];
    foreach ($ids as $id) { $id = (int)$id; if ($id > 0 && !array_key_exists($id, $cache)) { $faltan[$id] = $id; } }
    if ($faltan) {
        foreach ($faltan as $id) { $cache[$id] = null; }
        $res = mysqli_query($link, "SELECT es0.idestablecimiento_salud AS id_est, n.nombre, n.paterno, n.materno, nd.celular
            FROM establecimiento_salud es0
            INNER JOIN establecimiento_salud es ON es.idmunicipio = es0.idmunicipio
            INNER JOIN dato_laboral dl ON dl.idestablecimiento_salud = es.idestablecimiento_salud AND dl.idcargo_organigrama = '54'
            INNER JOIN personal p ON p.iddato_laboral = dl.iddato_laboral
            INNER JOIN usuarios u ON u.idusuario = p.idusuario AND u.condicion = 'ACTIVO'
            INNER JOIN nombre n ON n.idnombre = p.idnombre
            INNER JOIN nombre_datos nd ON nd.idnombre_datos = p.idnombre_datos
            WHERE es0.idestablecimiento_salud IN (" . implode(',', $faltan) . ") AND nd.celular REGEXP '[0-9]{7,}'
            ORDER BY es0.idestablecimiento_salud, (dl.idestablecimiento_salud = es0.idestablecimiento_salud) DESC, p.idpersonal DESC");
        if ($res) {
            while ($r = mysqli_fetch_assoc($res)) {
                $id = (int)$r['id_est'];
                if ($cache[$id] !== null) { continue; } // ya tiene el mejor contacto (primero el del mismo establecimiento)
                $num = preg_replace('/\D/', '', $r['celular']);
                if (strlen($num) === 8) { $num = '591' . $num; } // celular boliviano sin código de país
                $cache[$id] = ['nombre' => mb_convert_case(mb_strtolower(trim($r['nombre'] . ' ' . $r['paterno'] . ' ' . $r['materno'])), MB_CASE_TITLE),
                               'celular' => trim($r['celular']), 'wa' => $num];
            }
        }
    }
    $salida = [];
    foreach ($ids as $id) { $salida[(int)$id] = isset($cache[(int)$id]) ? $cache[(int)$id] : null; }
    return $salida;
}

// Enlace de WhatsApp con un mensaje ya escrito
function tm_enlace_whatsapp($contacto, $mensaje) {
    return 'https://wa.me/' . $contacto['wa'] . '?text=' . rawurlencode($mensaje);
}

// Círculo de una fila de pendientes ("A quién llamar" / "Bandejas atrasadas"): botón de WhatsApp del Personal Telesalud
// del municipio; si no hay celular registrado, el ícono del hospital de siempre
function tm_boton_whatsapp($link, $ph, $texto_pendientes) {
    $c = tm_contacto_telesalud($link, $ph['id']);
    if ($c === null) {
        return '<span class="ico" title="Sin Personal Telesalud con celular registrado en este municipio"><i class="fas fa-hospital"></i></span>';
    }
    $msg = 'Hola ' . $c['nombre'] . ', le escribo desde Telemedicina MEDI-SAFCI. ' . mb_convert_case(mb_strtolower($ph['nombre']), MB_CASE_TITLE)
        . ' tiene ' . ($ph['pa'] + $ph['ev']) . ' teleinterconsulta' . (($ph['pa'] + $ph['ev']) == 1 ? '' : 's') . ' pendiente' . (($ph['pa'] + $ph['ev']) == 1 ? '' : 's')
        . ' (' . $texto_pendientes . '). ¿Nos ayuda a revisarlas? Gracias.';
    $t = htmlspecialchars('WhatsApp a ' . $c['nombre'] . ' (Personal Telesalud) · ' . $c['celular'], ENT_QUOTES, 'UTF-8');
    return '<a class="ico wa" href="' . htmlspecialchars(tm_enlace_whatsapp($c, $msg), ENT_QUOTES, 'UTF-8') . '" target="_blank" rel="noopener" title="' . $t . '" aria-label="' . $t . '"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>';
}

// Indicador de carga con fondo de vidrio sobre el área de contenido (no tapa el menú lateral).
//   $visible = true: aparece de inmediato (la Central lo envía antes de calcular sus datos y lo oculta al terminar).
//   Siempre: aparece al salir de la página (menú, pestañas, filtros, Limpiar), mientras el servidor prepara la siguiente.
function tm_cargador($texto = 'Cargando datos', $visible = false) { ?>
    <div class="tm-cargando<?php echo $visible ? ' activo' : ''; ?>" id="tm-cargando" role="status" aria-live="polite">
        <div class="caja vidrio">
            <span class="anillo" aria-hidden="true"></span>
            <span class="t"><?php echo htmlspecialchars($texto, ENT_QUOTES, 'UTF-8'); ?>…</span>
            <span class="s">Preparando la información</span>
        </div>
    </div>
    <script>
    (function () {
        var c = document.getElementById('tm-cargando');
        var ajustar = function () { var sb = document.getElementById('accordionSidebar'); c.style.left = (sb ? Math.max(0, sb.getBoundingClientRect().right) : 0) + 'px'; };
        var mostrar = function () { ajustar(); c.classList.add('activo'); };
        var ocultar = function () { c.classList.remove('activo'); };
        ajustar();
        window.addEventListener('resize', ajustar);
        document.addEventListener('DOMContentLoaded', ocultar);
        window.addEventListener('pageshow', ocultar);            // al volver con "Atrás"
        window.addEventListener('beforeunload', function () {   // al ir a otra página
            mostrar();
            setTimeout(ocultar, 60000);                          // respaldo por si la navegación no ocurre
        });
    })();
    </script>
<?php }

// Salida compacta de los reportes Excel (tabla HTML con extensión .xls):
//   1. Viaja comprimida con gzip si el navegador lo acepta (el archivo guardado no cambia, la descarga es mucho menor)
//   2. Se quitan los espacios y saltos de línea entre etiquetas (casi la mitad del peso del archivo)
// Se procesa por bloques de 1 MB para no cargar en memoria el reporte completo.
function tm_salida_excel_compacta() {
    if (!ini_get('zlib.output_compression')) { ob_start('ob_gzhandler'); }
    // Solo junto a etiquetas reales (<td ...>, </tr>...): un texto como "j) > 60 años" conserva sus espacios
    $etiqueta = '(<[a-zA-Z\/!][^<>]*>)';
    ob_start(function ($bloque) use ($etiqueta) { return preg_replace(["/$etiqueta\\s+/", "/\\s+$etiqueta/"], ['$1', '$1'], $bloque); }, 1048576);
}

// Pantalla de aviso de Telemedicina (las peticiones AJAX reciben JSON):
//   'sesion'     -> la sesión expiró: volver a ingresar
//   'sin_datos'  -> falta el lugar de trabajo actual en Datos laborales
//   'sin_acceso' -> el perfil no tiene acceso al módulo
function tm_pantalla_sin_alcance($nivel) {
    $avisos = [
        'sesion'     => ['fa-user-clock', 'Su sesión ha expirado', 'Por seguridad, la sesión se cerró tras un tiempo sin actividad. Ingrese nuevamente para continuar trabajando en Telemedicina.',
                         '../index.php', 'fa-sign-in-alt', 'Iniciar sesión nuevamente', 401],
        'sin_datos'  => ['fa-id-card', 'Complete sus datos laborales', 'Para ver Telemedicina necesitamos conocer su lugar de trabajo actual. Regístrelo en Datos laborales y vuelva a ingresar.',
                         '../recursos_humanos/datos_laborales_individual.php', 'fa-briefcase', 'Completar datos laborales', 403],
        'sin_acceso' => ['fa-lock', 'Acceso restringido', 'Su perfil de usuario no tiene acceso al módulo de Telemedicina. Si necesita ingresar, consulte con el administrador del sistema.',
                         '../administrar_sistema/inicio.php', 'fa-home', 'Volver al inicio', 403],
    ];
    $a = isset($avisos[$nivel]) ? $avisos[$nivel] : $avisos['sin_acceso'];
    while (ob_get_level() > 0) { ob_end_clean(); } // sin avisos de PHP previos encima de la pantalla
    http_response_code($a[6]);
    if (strpos(basename($_SERVER['SCRIPT_NAME']), 'ajax_') === 0) {
        header('Content-Type: application/json'); echo json_encode(['error' => $a[1], 'motivo' => $nivel]); exit;
    }
    header('Cache-Control: no-store'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SISTEMA MEDI-SAFCI - Telemedicina</title>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <style>
        @font-face { font-family: 'Outfit'; font-weight: 400; font-display: swap; src: url('../vendor/fonts/outfit/outfit-latin-400-normal.woff2') format('woff2'); }
        @font-face { font-family: 'Outfit'; font-weight: 500; font-display: swap; src: url('../vendor/fonts/outfit/outfit-latin-500-normal.woff2') format('woff2'); }
        @font-face { font-family: 'Outfit'; font-weight: 600; font-display: swap; src: url('../vendor/fonts/outfit/outfit-latin-600-normal.woff2') format('woff2'); }
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px 16px; font-family: 'Outfit', 'Segoe UI', Roboto, Arial, sans-serif; color: #34353d;
            background-color: #eef2fb;
            background-image: radial-gradient(900px 520px at 8% 0%, rgba(78, 115, 223, .22), transparent 70%), radial-gradient(700px 480px at 100% 30%, rgba(54, 185, 204, .18), transparent 70%),
                radial-gradient(800px 600px at 40% 100%, rgba(78, 115, 223, .16), transparent 70%); }
        .aviso { width: 100%; max-width: 460px; text-align: center; padding: 40px 36px 32px; border-radius: 26px; background: rgba(255, 255, 255, .78);
            backdrop-filter: blur(18px) saturate(1.2); -webkit-backdrop-filter: blur(18px) saturate(1.2); border: 1px solid rgba(78, 115, 223, .16);
            box-shadow: 0 24px 60px -24px rgba(78, 115, 223, .45), 0 0 0 1px rgba(54, 185, 204, .12), inset 0 1px 0 rgba(255, 255, 255, .95); animation: entra .45s cubic-bezier(.2, .8, .2, 1) both; }
        .icono { width: 76px; height: 76px; margin: 0 auto 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 30px; color: #224abe;
            background: radial-gradient(circle at 30% 25%, #ffffff, rgba(78, 115, 223, .14)); box-shadow: 0 0 0 8px rgba(78, 115, 223, .07), 0 10px 26px -10px rgba(78, 115, 223, .6); }
        .marca { font-size: 12px; font-weight: 500; letter-spacing: .6px; text-transform: uppercase; color: #36b9cc; margin-bottom: 6px; }
        h1 { font-size: 24px; font-weight: 600; color: #224abe; margin: 0 0 10px; letter-spacing: -.3px; }
        p { font-size: 14.5px; line-height: 1.55; color: #5a5c69; margin: 0 0 26px; }
        .boton { display: inline-flex; align-items: center; gap: 10px; padding: 12px 26px; border-radius: 999px; background: linear-gradient(135deg, #4e73df, #224abe); color: #fff;
            font-size: 14.5px; font-weight: 500; text-decoration: none; box-shadow: 0 10px 24px -10px rgba(78, 115, 223, .8); transition: transform .2s, box-shadow .2s; }
        .boton:hover, .boton:focus-visible { transform: translateY(-1px); box-shadow: 0 14px 28px -10px rgba(78, 115, 223, .9); outline: none; color: #fff; }
        .pie { margin-top: 22px; font-size: 12px; color: #858796; }
        @keyframes entra { from { opacity: 0; transform: translateY(10px) scale(.98); } to { opacity: 1; transform: none; } }
        @media (prefers-reduced-motion: reduce) { .aviso { animation: none; } .boton { transition: none; } }
    </style>
</head>
<body>
    <main class="aviso" role="alert">
        <div class="icono"><i class="fas <?php echo $a[0]; ?>" aria-hidden="true"></i></div>
        <div class="marca">MEDI-SAFCI · Telemedicina</div>
        <h1><?php echo htmlspecialchars($a[1], ENT_QUOTES, 'UTF-8'); ?></h1>
        <p><?php echo htmlspecialchars($a[2], ENT_QUOTES, 'UTF-8'); ?></p>
        <a class="boton" href="<?php echo htmlspecialchars($a[3], ENT_QUOTES, 'UTF-8'); ?>"><i class="fas <?php echo $a[4]; ?>" aria-hidden="true"></i> <?php echo htmlspecialchars($a[5], ENT_QUOTES, 'UTF-8'); ?></a>
        <div class="pie">Ministerio de Salud y Deportes</div>
    </main>
</body>
</html>
<?php exit;
}

// Otras páginas (p. ej. la Matriz) solo necesitan las funciones de alcance
if (defined('TM_SOLO_ALCANCE')) { return; }

// Sesión vencida (si cabf.php no alcanzó a redirigir): aviso para volver a ingresar
if (empty($_SESSION['idusuario_ss']) || empty($_SESSION['perfil_ss'])) { tm_pantalla_sin_alcance('sesion'); }

$tm_alc = tm_alcance($link);
if (!in_array($tm_alc['nivel'], ['nacional', 'departamental', 'municipal'], true)) { tm_pantalla_sin_alcance($tm_alc['nivel']); }

// --- 1. Filtros: la URL manda (el formulario siempre envía todos los campos); si no hay, se usa la sesión;
//        la primera vez y al limpiar, los valores por defecto del usuario. Siempre se aplica el alcance. ---
$tm_filtros = [];
$tm_desde_url = false;
foreach ($tm_claves as $k) { if (array_key_exists($k, $_GET)) { $tm_desde_url = true; break; } }
$tm_idu = isset($_SESSION['idusuario_ss']) ? (string)$_SESSION['idusuario_ss'] : '';
$tm_sesion_valida = isset($_SESSION['tm_filtros']) && is_array($_SESSION['tm_filtros'])
    && isset($_SESSION['tm_filtros_usuario']) && (string)$_SESSION['tm_filtros_usuario'] === $tm_idu;

if (isset($_GET['limpiar'])) {
    unset($_GET['limpiar']);
    $tm_desde_url = false;
    $tm_filtros = $tm_alc['defecto'];
} elseif ($tm_desde_url) {
    foreach ($tm_claves as $k) { $tm_filtros[$k] = isset($_GET[$k]) ? trim((string)$_GET[$k]) : ''; }
    foreach (['fecha_inicio', 'fecha_fin'] as $k) {
        if ($tm_filtros[$k] !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tm_filtros[$k])) { $tm_filtros[$k] = ''; }
    }
} elseif ($tm_sesion_valida) {
    $tm_filtros = $_SESSION['tm_filtros'];
} else {
    $tm_filtros = $tm_alc['defecto'];
}
foreach ($tm_claves as $k) { if (!isset($tm_filtros[$k])) { $tm_filtros[$k] = ''; } }
$tm_filtros = tm_forzar_alcance($link, $tm_filtros);
$_SESSION['tm_filtros'] = $tm_filtros;
$_SESSION['tm_filtros_usuario'] = $tm_idu;

// Se publican en $_GET para que cada página siga leyendo sus filtros como siempre.
// Siempre van todas las claves (vacías = sin filtro), así los enlaces de los chips las conservan.
foreach ($tm_claves as $k) { $_GET[$k] = isset($tm_filtros[$k]) ? (string)$tm_filtros[$k] : ''; }

// --- 2. Barra de pestañas en píldora ---
function tm_nav($activa) {
    global $tm_pestanas;
    echo '<nav class="nav-pildora vidrio" aria-label="Secciones de telemedicina">';
    foreach ($tm_pestanas as $clave => $p) {
        $es = $clave === $activa;
        echo '<a href="' . htmlspecialchars($p[1], ENT_QUOTES, 'UTF-8') . '"' . ($es ? ' class="activo" aria-current="page"' : '') . '>'
            . '<i class="fas ' . $p[2] . '"></i>' . htmlspecialchars($p[0], ENT_QUOTES, 'UTF-8') . '</a>';
    }
    echo '</nav>';
}

// Texto que explica cómo lee esta pestaña el filtro elegido
function tm_contexto($activa) {
    global $tm_pestanas;
    return isset($tm_pestanas[$activa]) ? $tm_pestanas[$activa][3] : 'Filtrando por';
}

// Enlace del botón "Limpiar": borra también los filtros guardados en la sesión
function tm_url_limpiar($pagina) {
    return $pagina . '?limpiar=1';
}

// =========================================================================
// REGLAS DE PRODUCCIÓN (definidas UNA sola vez; las usan la Central, la analítica anual y las pestañas)
// =========================================================================
// Procesos: nombre, color (paleta SB Admin 2), ícono
$tm_procesos = [
    'generadas'     => ['Generadas', '#4e73df', 'fa-share-square'],
    'respuestas'    => ['Respuestas', '#36b9cc', 'fa-reply-all'],
    'teleconsultas' => ['Teleconsultas', '#1cc88a', 'fa-headset'],
    'telemetrias'   => ['Telemetrías', '#fd7e14', 'fa-heartbeat'],
];

// Dispositivo VÁLIDO de telemetría: telesalud='SI', sin el duplicado id 6, sin signos vitales, estetoscopio ni "OTRO"
function tm_cond_dispositivo($al) {
    return "$al.telesalud = 'SI' AND $al.idexamen_complementario != '6'
    AND UPPER($al.examen_complementario) NOT LIKE '%MONITOR DE SIGNOS VITALES%'
    AND UPPER($al.examen_complementario) NOT LIKE '%ESTETOSCOPIO%'
    AND UPPER($al.examen_complementario) NOT LIKE '%OTRO%'";
}

// Teleinterconsulta EFECTIVIZADA: contrarreferida (estado 2) y NO rechazada (calificación NO/NO/NO)
function tm_cond_efectivizada() {
    return "r.idestado_referencia = '2' AND NOT (UPPER(TRIM(IFNULL(r.adecuada,''))) = 'NO' AND UPPER(TRIM(IFNULL(r.justificada,''))) = 'NO' AND UPPER(TRIM(IFNULL(r.oportuna,''))) = 'NO')";
}

// Fecha de la RESPUESTA del especialista: la del diagnóstico de egreso (la última, como el Excel de referencias);
// si no hay egreso, la fila de deriva de retorno (se crea al guardar la contrarreferencia); en último caso, la referencia.
// Requiere los alias r (referencia_hc) y d (fila de deriva del especialista).
function tm_sql_fecha_respuesta() {
    return "COALESCE(
        (SELECT MAX(NULLIF(eg.fecha_registro, '0000-00-00')) FROM diagnostico_egreso eg WHERE eg.idreferencia_hc = r.idreferencia_hc),
        (SELECT MAX(NULLIF(dr.fecha_deriva, '0000-00-00')) FROM deriva_referencia_hc dr WHERE dr.idreferencia_hc = r.idreferencia_hc AND dr.idderiva_referencia_hc > d.idderiva_referencia_hc),
        r.fecha_registro)";
}

// Filtros compartidos traducidos a SQL según el rol de cada proceso
function tm_filtros_sql($link) {
    $v = function ($k) use ($link) { return isset($_GET[$k]) && $_GET[$k] !== '' ? mysqli_real_escape_string($link, (string)$_GET[$k]) : ''; };
    $dep = $v('iddepartamento'); $mun = $v('idmunicipio'); $est = $v('idestablecimiento'); $med = $v('idusuario_medico');
    $o = ''; $r = ''; $a = '';
    if ($dep !== '') { $o .= " AND r.iddepartamento = '$dep'";       $r .= " AND es_receptor.iddepartamento = '$dep'"; $a .= " AND a.iddepartamento = '$dep'"; }
    if ($mun !== '') { $o .= " AND r.idmunicipio = '$mun'";          $r .= " AND es_receptor.idmunicipio = '$mun'";    $a .= " AND a.idmunicipio = '$mun'"; }
    if ($est !== '') { $o .= " AND r.idestablecimiento_salud = '$est'"; $r .= " AND r.idestablecimiento_receptor = '$est'"; $a .= " AND a.idestablecimiento_salud = '$est'"; }
    if ($med !== '') { $o .= " AND r.idusuario = '$med'";            $r .= " AND d.idusuario_r = '$med' AND r.idusuario != '$med'"; $a .= " AND a.idusuario = '$med'"; }
    return ['origen' => $o, 'receptor' => $r, 'atencion' => $a];
}

// Definición SQL de cada proceso (FROM, WHERE base, conteo, columna de fecha, paciente y establecimiento)
function tm_def_procesos($link) {
    $f = tm_filtros_sql($link);
    $from_tic = "FROM referencia_hc r
        LEFT JOIN deriva_referencia_hc d ON d.idderiva_referencia_hc = (SELECT MIN(d2.idderiva_referencia_hc) FROM deriva_referencia_hc d2 WHERE d2.idreferencia_hc = r.idreferencia_hc)
        LEFT JOIN establecimiento_salud es_receptor ON es_receptor.idestablecimiento_salud = r.idestablecimiento_receptor";
    return [
        // Generadas: solo efectivizadas, vistas desde el ORIGEN
        'generadas' => ['from' => $from_tic, 'where' => tm_cond_efectivizada() . $f['origen'], 'cnt' => 'COUNT(r.idreferencia_hc)',
                        'fecha' => 'r.fecha_registro', 'pac' => 'r.idnombre', 'est' => 'r.idestablecimiento_salud', 'dep' => 'r.iddepartamento'],
        // Respuestas: solo efectivizadas, vistas desde el hospital ESPECIALISTA y fechadas el día en que se respondieron
        'respuestas' => ['from' => $from_tic, 'where' => tm_cond_efectivizada() . $f['receptor'], 'cnt' => 'COUNT(r.idreferencia_hc)',
                        'fecha' => tm_sql_fecha_respuesta(), 'pac' => 'r.idnombre', 'est' => 'r.idestablecimiento_receptor', 'dep' => 'es_receptor.iddepartamento'],
        'teleconsultas' => ['from' => 'FROM atencion_psafci a', 'where' => "a.idtipo_atencion = '3'" . $f['atencion'], 'cnt' => 'COUNT(a.idatencion_psafci)',
                        'fecha' => 'a.fecha_registro', 'pac' => 'a.idnombre', 'est' => 'a.idestablecimiento_salud', 'dep' => 'a.iddepartamento'],
        // Telemetrías: exámenes con dispositivo válido
        'telemetrias' => ['from' => 'FROM examen_teleconsulta et INNER JOIN atencion_psafci a ON et.idatencion_psafci = a.idatencion_psafci INNER JOIN examen_complementario ec ON et.idexamen_complementario = ec.idexamen_complementario',
                        'where' => "a.idtipo_atencion = '4' AND " . tm_cond_dispositivo('ec') . $f['atencion'], 'cnt' => 'COUNT(et.idexamen_teleconsulta)',
                        'fecha' => 'a.fecha_registro', 'pac' => 'a.idnombre', 'est' => 'a.idestablecimiento_salud', 'dep' => 'a.iddepartamento'],
    ];
}

// Atención de telemetría que cuenta: con al menos un dispositivo válido
function tm_cond_atencion_telemetria() {
    return "EXISTS (SELECT 1 FROM examen_teleconsulta etv INNER JOIN examen_complementario ecv ON etv.idexamen_complementario = ecv.idexamen_complementario
        WHERE etv.idatencion_psafci = a.idatencion_psafci AND " . tm_cond_dispositivo('ecv') . ")";
}

// Diagnósticos de TODOS los procesos en una sola tabla (UNION ALL), con las mismas reglas de producción:
//   proceso · sid (id del servicio) · pac (paciente) · fecha · cie · patologia · idgrupo_priorizado · dxid (orden de registro del diagnóstico)
//   Generadas: diagnóstico presuntivo · Respuestas: diagnóstico de egreso · Teleconsultas/Telemetrías: diagnóstico de la atención
//   $limitar = true: solo los primeros diagnósticos registrados, como los reportes Excel (3 en referencias, 4 en atenciones)
function tm_sql_diagnosticos($link, $ini, $fin, $limitar = false) {
    $d = tm_def_procesos($link); $f = tm_filtros_sql($link);
    $cols = "pt.cie, pt.patologia, pt.idgrupo_priorizado";
    $fr = $d['respuestas']['fecha'];
    $lim_p = $limitar ? " AND (SELECT COUNT(*) FROM diagnostico_presuntivo x WHERE x.idreferencia_hc = dx.idreferencia_hc AND x.iddiagnostico_presuntivo < dx.iddiagnostico_presuntivo) < 3" : '';
    $lim_e = $limitar ? " AND (SELECT COUNT(*) FROM diagnostico_egreso x WHERE x.idreferencia_hc = dx.idreferencia_hc AND x.iddiagnostico_egreso < dx.iddiagnostico_egreso) < 3" : '';
    $lim_a = $limitar ? " AND (SELECT COUNT(*) FROM diagnostico_teleconsulta x WHERE x.idatencion_psafci = dx.idatencion_psafci AND x.iddiagnostico_teleconsulta < dx.iddiagnostico_teleconsulta) < 4" : '';
    return "
        SELECT 'generadas' AS proceso, r.idreferencia_hc AS sid, r.idnombre AS pac, r.fecha_registro AS fecha, $cols, dx.iddiagnostico_presuntivo AS dxid
        {$d['generadas']['from']} INNER JOIN diagnostico_presuntivo dx ON dx.idreferencia_hc = r.idreferencia_hc INNER JOIN patologia pt ON pt.idpatologia = dx.idpatologia
        WHERE r.fecha_registro BETWEEN '$ini' AND '$fin' AND {$d['generadas']['where']} $lim_p
      UNION ALL
        SELECT 'respuestas', r.idreferencia_hc, r.idnombre, $fr, $cols, dx.iddiagnostico_egreso
        {$d['respuestas']['from']} INNER JOIN diagnostico_egreso dx ON dx.idreferencia_hc = r.idreferencia_hc INNER JOIN patologia pt ON pt.idpatologia = dx.idpatologia
        WHERE $fr BETWEEN '$ini' AND '$fin' AND {$d['respuestas']['where']} $lim_e
      UNION ALL
        SELECT 'teleconsultas', a.idatencion_psafci, a.idnombre, a.fecha_registro, $cols, dx.iddiagnostico_teleconsulta
        FROM atencion_psafci a INNER JOIN diagnostico_teleconsulta dx ON dx.idatencion_psafci = a.idatencion_psafci INNER JOIN patologia pt ON pt.idpatologia = dx.idpatologia
        WHERE a.fecha_registro BETWEEN '$ini' AND '$fin' AND a.idtipo_atencion = '3' {$f['atencion']} $lim_a
      UNION ALL
        SELECT 'telemetrias', a.idatencion_psafci, a.idnombre, a.fecha_registro, $cols, dx.iddiagnostico_teleconsulta
        FROM atencion_psafci a INNER JOIN diagnostico_teleconsulta dx ON dx.idatencion_psafci = a.idatencion_psafci INNER JOIN patologia pt ON pt.idpatologia = dx.idpatologia
        WHERE a.fecha_registro BETWEEN '$ini' AND '$fin' AND a.idtipo_atencion = '4' AND " . tm_cond_atencion_telemetria() . " {$f['atencion']} $lim_a";
}

// Servicios de TODOS los procesos (UNION ALL): proceso · sid · pac · fecha · disc (1 = persona con discapacidad)
//   Teleinterconsultas: campo "Persona con discapacidad" de la referencia (la contrarreferencia lo hereda)
//   Teleconsultas/Telemetrías: grupo vulnerable 5 "Persona con discapacidad". En telemetrías el servicio es la atención.
function tm_sql_servicios($link, $ini, $fin) {
    $d = tm_def_procesos($link); $f = tm_filtros_sql($link);
    $disc_r = "IF(UPPER(TRIM(IFNULL(r.discapacidad, ''))) = 'SI', 1, 0)";
    $disc_a = "IF(EXISTS (SELECT 1 FROM atencion_grupo_vulnerable agd WHERE agd.idatencion_psafci = a.idatencion_psafci AND agd.idgrupo_vulnerable = '5'), 1, 0)";
    $partes = [];
    foreach (['generadas', 'respuestas'] as $k) {
        $p = $d[$k];
        $partes[] = "SELECT '$k' AS proceso, r.idreferencia_hc AS sid, r.idnombre AS pac, $p[fecha] AS fecha, $disc_r AS disc $p[from] WHERE $p[fecha] BETWEEN '$ini' AND '$fin' AND $p[where]";
    }
    $partes[] = "SELECT 'teleconsultas', a.idatencion_psafci, a.idnombre, a.fecha_registro, $disc_a FROM atencion_psafci a WHERE a.fecha_registro BETWEEN '$ini' AND '$fin' AND a.idtipo_atencion = '3' {$f['atencion']}";
    $partes[] = "SELECT 'telemetrias', a.idatencion_psafci, a.idnombre, a.fecha_registro, $disc_a FROM atencion_psafci a WHERE a.fecha_registro BETWEEN '$ini' AND '$fin' AND a.idtipo_atencion = '4' AND " . tm_cond_atencion_telemetria() . " {$f['atencion']}";
    return implode(' UNION ALL ', $partes);
}

// Grupo priorizado por servicio, con las reglas de los reportes Excel (los grupos NO son excluyentes):
//   ENT / ET / SM / OTROS = grupo de la patología en los primeros 3 (referencias) o 4 (atenciones) diagnósticos
//   SI = menor de 5 años a la fecha del servicio · D = persona con discapacidad
function tm_sql_grupos($link, $ini, $fin) {
    $s = tm_sql_servicios($link, $ini, $fin);
    return "
        SELECT dg.proceso, dg.sid, CASE dg.idgrupo_priorizado WHEN 1 THEN 'ENT' WHEN 2 THEN 'ET' WHEN 3 THEN 'SM' ELSE 'OTROS' END AS grupo
        FROM (" . tm_sql_diagnosticos($link, $ini, $fin, true) . ") dg
      UNION ALL
        SELECT s.proceso, s.sid, 'SI' FROM ($s) s INNER JOIN nombre n ON n.idnombre = s.pac
        WHERE n.fecha_nac IS NOT NULL AND n.fecha_nac <> '0000-00-00' AND n.fecha_nac <= s.fecha AND TIMESTAMPDIFF(YEAR, n.fecha_nac, s.fecha) < 5
      UNION ALL
        SELECT s.proceso, s.sid, 'D' FROM ($s) s WHERE s.disc = 1";
}

// Pacientes atendidos en TODOS los procesos (UNION ALL): proceso · pac · fecha (para la pirámide)
function tm_sql_pacientes($link, $ini, $fin) {
    $partes = [];
    foreach (tm_def_procesos($link) as $clave => $p) {
        $where = $clave === 'telemetrias' ? "a.idtipo_atencion = '4' AND " . tm_cond_atencion_telemetria() . tm_filtros_sql($link)['atencion'] : $p['where'];
        $from = $clave === 'telemetrias' ? 'FROM atencion_psafci a' : $p['from'];
        $partes[] = "SELECT '$clave' AS proceso, $p[pac] AS pac, $p[fecha] AS fecha $from WHERE $p[fecha] BETWEEN '$ini' AND '$fin' AND $where";
    }
    return implode(' UNION ALL ', $partes);
}

// CONDICIONES TRAZADORAS (CIE-10 de 3 caracteres, comparadas desde el inicio del código)
// Oncológico = lista Dict_Oncologia del Excel del usuario (+ C26), con desglose cáncer / incierto / benigno
function tm_lista_oncologica() {
    $l = [];
    $rango = function ($letra, $a, $b) use (&$l) { for ($i = $a; $i <= $b; $i++) { $l[] = $letra . str_pad((string)$i, 2, '0', STR_PAD_LEFT); } };
    $rango('C', 0, 26); $rango('C', 30, 34); $rango('C', 37, 41); $rango('C', 43, 58); $rango('C', 60, 85); $l[] = 'C88'; $rango('C', 90, 97);
    $rango('D', 0, 7); $l[] = 'D09'; $rango('D', 10, 48);
    return $l;
}
// ¿El código CIE-10 es oncológico? (misma lista que la Central; se compara desde el inicio del código)
function tm_es_oncologico($cie) {
    static $lista = null;
    if ($lista === null) { $lista = array_flip(tm_lista_oncologica()); }
    return isset($lista[strtoupper(substr(trim((string)$cie), 0, 3))]);
}
// Las mismas reglas de tm_trazadoras() evaluadas en PHP (la Central trae los diagnósticos una sola vez y los clasifica aquí)
function tm_trazadora_cumple($clave, $cie) {
    $c = strtoupper(trim((string)$cie));
    switch ($clave) {
        case 'oncologico': return tm_es_oncologico($c);
        case 'renal':      return (bool)preg_match('/^N[0-2][0-9]/', $c);
        case 'embarazo':   return (bool)preg_match('/^(O[0-9]|Z35)/', $c);
        case 'diabetes':   return (bool)preg_match('/^E1[0-4]/', $c);
        case 'hta':        return (bool)preg_match('/^I1[0-5]/', $c);
    }
    return false;
}
// Desglose oncológico en PHP (igual que tm_sql_tipo_oncologico)
function tm_tipo_oncologico($cie) {
    $c = strtoupper(trim((string)$cie));
    if (preg_match('/^(C|D0)/', $c)) { return 'cancer'; }
    if (preg_match('/^D(1[0-9]|2[0-9]|3[0-6])/', $c)) { return 'benigno'; }
    return 'incierto';
}
function tm_trazadoras() {
    $onco = "'" . implode("','", tm_lista_oncologica()) . "'";
    return [
        'oncologico' => ['Oncológico', 'fa-ribbon', '#6f42c1', "LEFT(UPPER(TRIM(pt.cie)), 3) IN ($onco)", 'Lista oncológica (C00–C97, D00–D48)'],
        'renal'      => ['Enfermedad renal', 'fa-tint', '#36b9cc', "UPPER(TRIM(pt.cie)) REGEXP '^N[0-2][0-9]'", 'CIE-10 N00–N29'],
        'embarazo'   => ['Embarazo de riesgo', 'fa-baby', '#e83e8c', "UPPER(TRIM(pt.cie)) REGEXP '^(O[0-9]|Z35)'", 'CIE-10 O00–O99 y Z35'],
        'diabetes'   => ['Diabetes mellitus', 'fa-syringe', '#fd7e14', "UPPER(TRIM(pt.cie)) REGEXP '^E1[0-4]'", 'CIE-10 E10–E14'],
        'hta'        => ['Hipertensión arterial', 'fa-heartbeat', '#e74a3b', "UPPER(TRIM(pt.cie)) REGEXP '^I1[0-5]'", 'CIE-10 I10–I15'],
    ];
}
// Desglose del grupo oncológico
function tm_sql_tipo_oncologico() {
    return "CASE WHEN UPPER(TRIM(cie)) REGEXP '^(C|D0)' THEN 'cancer'
                 WHEN UPPER(TRIM(cie)) REGEXP '^D(1[0-9]|2[0-9]|3[0-6])' THEN 'benigno'
                 ELSE 'incierto' END";
}

// Producción por proceso en un rango. $agrupar: null | 'dia' | 'mes' (agrega la serie por fecha)
function tm_produccion($link, $ini, $fin, $agrupar = null) {
    $salida = [];
    foreach (tm_def_procesos($link) as $clave => $p) {
        $w = "$p[fecha] BETWEEN '$ini' AND '$fin' AND $p[where]";
        $res = mysqli_query($link, "SELECT $p[cnt] AS total, COUNT(DISTINCT $p[pac]) AS pacientes $p[from] WHERE $w");
        $row = $res ? mysqli_fetch_assoc($res) : null;
        $salida[$clave] = ['total' => $row ? (int)$row['total'] : 0, 'pacientes' => $row ? (int)$row['pacientes'] : 0, 'serie' => []];
        if ($agrupar) {
            $k = $agrupar === 'mes' ? "DATE_FORMAT($p[fecha], '%Y-%m')" : "DATE_FORMAT($p[fecha], '%Y-%m-%d')";
            $rs = mysqli_query($link, "SELECT $k AS clave, $p[cnt] AS total $p[from] WHERE $w GROUP BY clave");
            if ($rs) { while ($x = mysqli_fetch_assoc($rs)) { $salida[$clave]['serie'][$x['clave']] = (int)$x['total']; } }
        }
    }
    return $salida;
}

// Pacientes y establecimientos ÚNICOS sumando todos los procesos (sin contar dos veces)
function tm_unicos($link, $ini, $fin) {
    $partes_p = []; $partes_e = [];
    foreach (tm_def_procesos($link) as $p) {
        $w = "$p[fecha] BETWEEN '$ini' AND '$fin' AND $p[where]";
        $partes_p[] = "SELECT $p[pac] AS id $p[from] WHERE $w";
        $partes_e[] = "SELECT $p[est] AS id $p[from] WHERE $w";
    }
    $res_p = mysqli_query($link, "SELECT COUNT(DISTINCT id) AS n FROM (" . implode(' UNION ', $partes_p) . ") u");
    $res_e = mysqli_query($link, "SELECT COUNT(DISTINCT id) AS n FROM (" . implode(' UNION ', $partes_e) . ") u WHERE id IS NOT NULL");
    $p = $res_p ? mysqli_fetch_assoc($res_p) : null; $e = $res_e ? mysqli_fetch_assoc($res_e) : null;
    return ['pacientes' => $p ? (int)$p['n'] : 0, 'establecimientos' => $e ? (int)$e['n'] : 0];
}

// Etiquetas del gráfico de tendencia: como máximo ~7 visibles y repartidas de forma pareja.
// Por mes: "Ene", "Feb"... con el año debajo solo en la primera etiqueta y cuando cambia de año.
function tm_etiquetas_tendencia($etiquetas, $por_mes) {
    $meses = ['', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    $paso = max(1, (int)ceil(count($etiquetas) / 7));
    $salida = []; $anio_prev = null;
    foreach (array_values($etiquetas) as $i => $e) {
        $ver = ($i % $paso === 0);
        if ($por_mes && preg_match('/^(\d{2})\/(\d{4})$/', $e, $m)) {
            $txt = $meses[(int)$m[1]];
            $sub = ($ver && $m[2] !== $anio_prev) ? $m[2] : '';
            if ($ver) { $anio_prev = $m[2]; }
            $titulo = $txt . ' ' . $m[2];
        } else {
            $txt = $e; $sub = ''; $titulo = $e;
        }
        $salida[] = ['txt' => $txt, 'sub' => $sub, 'ver' => $ver, 'titulo' => $titulo];
    }
    return $salida;
}

// Edad promedio a partir de MESES cumplidos (la edad de cada paciente es la cumplida a la fecha de la atención).
// < 1 mes: "<1 mes" · 1–11 meses: "N meses" · 12–23 meses: "1 año y N meses" · desde 2 años: años redondeados.
function tm_texto_edad_exacta($meses) {
    if ($meses === null) { return 'Sin datos'; }
    $a = (int)floor($meses / 12); $m = (int)round($meses - $a * 12);
    if ($m == 12) { $a++; $m = 0; }
    if ($a == 0 && $m == 0) { return 'menos de 1 mes'; }
    $partes = [];
    if ($a > 0) { $partes[] = $a . ($a == 1 ? ' año' : ' años'); }
    if ($m > 0 || $a == 0) { $partes[] = $m . ($m == 1 ? ' mes' : ' meses'); }
    return implode(' ', $partes);
}
function tm_formato_edad($meses) {
    if ($meses === null) { return ['valor' => '0', 'numerico' => true, 'unidad' => 'años', 'exacto' => 'Sin datos de fecha de nacimiento']; }
    $exacto = 'Promedio exacto: ' . tm_texto_edad_exacta($meses);
    if ($meses < 1) { return ['valor' => '<1', 'numerico' => false, 'unidad' => 'mes', 'exacto' => $exacto]; }
    if ($meses < 12) { $m = (int)round($meses); if ($m < 12) { return ['valor' => (string)$m, 'numerico' => true, 'unidad' => $m == 1 ? 'mes' : 'meses', 'exacto' => $exacto]; } }
    if ($meses < 24) {
        $resto = (int)round($meses - 12);
        if ($resto < 12) { return ['valor' => '1', 'numerico' => true, 'unidad' => 'año' . ($resto > 0 ? ' y ' . $resto . ($resto == 1 ? ' mes' : ' meses') : ''), 'exacto' => $exacto]; }
    }
    $a = (int)round($meses / 12);
    return ['valor' => (string)$a, 'numerico' => true, 'unidad' => $a == 1 ? 'año' : 'años', 'exacto' => $exacto];
}
// Variación de la edad promedio en la misma unidad que se muestra (años desde los 2 años, meses antes)
function tm_variacion_edad($actual, $anterior) {
    if ($actual === null || $anterior === null) { return ['—', 'neutro', 'Sin datos para comparar']; }
    $tip = ucfirst(tm_etq_anterior(true)) . ': ' . tm_texto_edad_exacta($anterior);
    $dif = $actual - $anterior;
    if ($actual >= 24) {
        $n = (int)round($dif / 12);
        if ($n == 0) { return ['—', 'neutro', $tip]; }
        return [($n > 0 ? '▲ ' : '▼ ') . abs($n) . (abs($n) == 1 ? ' año' : ' años'), 'neutro', $tip];
    }
    $n = (int)round($dif);
    if ($n == 0) { return ['—', 'neutro', $tip]; }
    return [($n > 0 ? '▲ ' : '▼ ') . abs($n) . (abs($n) == 1 ? ' mes' : ' meses'), 'neutro', $tip];
}

// Fondo y color de texto legibles (WCAG AA 4.5:1) para un color de categoría.
// Elige texto oscuro o blanco según el contraste; si ninguno alcanza, oscurece el mismo color hasta lograrlo.
function tm_colores_legibles($hex) {
    $lum = function ($h) {
        $c = [hexdec(substr($h, 1, 2)), hexdec(substr($h, 3, 2)), hexdec(substr($h, 5, 2))];
        foreach ($c as $i => $v) { $v /= 255; $c[$i] = $v <= 0.03928 ? $v / 12.92 : pow(($v + 0.055) / 1.055, 2.4); }
        return 0.2126 * $c[0] + 0.7152 * $c[1] + 0.0722 * $c[2];
    };
    $contraste = function ($a, $b) { return (max($a, $b) + 0.05) / (min($a, $b) + 0.05); };
    $oscuro = '#34353d'; $l_osc = $lum($oscuro); $l_bla = 1.0;
    $fondo = $hex;
    for ($i = 0; $i < 12; $i++) {
        $l = $lum($fondo);
        if ($contraste($l, $l_osc) >= 4.5) { return [$fondo, $oscuro]; }
        if ($contraste($l, $l_bla) >= 4.5) { return [$fondo, '#ffffff']; }
        $r = (int)round(hexdec(substr($fondo, 1, 2)) * .9); $g = (int)round(hexdec(substr($fondo, 3, 2)) * .9); $b = (int)round(hexdec(substr($fondo, 5, 2)) * .9);
        $fondo = sprintf('#%02x%02x%02x', $r, $g, $b);
    }
    return [$fondo, '#ffffff'];
}

// --- 3. Estilos compartidos del diseño ---
function tm_estilos() { ?>
    <style>
        /* Outfit (licencia OFL) servida desde el propio sistema: no depende de internet */
        @font-face { font-family: 'Outfit'; font-style: normal; font-weight: 300; font-display: swap; src: url('../vendor/fonts/outfit/outfit-latin-300-normal.woff2') format('woff2'); }
        @font-face { font-family: 'Outfit'; font-style: normal; font-weight: 400; font-display: swap; src: url('../vendor/fonts/outfit/outfit-latin-400-normal.woff2') format('woff2'); }
        @font-face { font-family: 'Outfit'; font-style: normal; font-weight: 500; font-display: swap; src: url('../vendor/fonts/outfit/outfit-latin-500-normal.woff2') format('woff2'); }
        @font-face { font-family: 'Outfit'; font-style: normal; font-weight: 600; font-display: swap; src: url('../vendor/fonts/outfit/outfit-latin-600-normal.woff2') format('woff2'); }

        /* =====================================================================
           VARIABLES DE DISEÑO — derivadas EXCLUSIVAMENTE de la paleta de SB Admin 2
           (variaciones solo por opacidad o luminosidad del mismo color)
           ===================================================================== */
        .px {
            /* Primario y acento */
            --p: #4e73df;                       /* --primary */
            --p-rgb: 78, 115, 223;
            --p-osc: #224abe;                   /* extremo oscuro del degradado del menú */
            --p-prof: #183485;                  /* --p-osc con menor luminosidad (tarjeta oscura) */
            --acc: #36b9cc;                     /* --info: único acento */
            --acc-rgb: 54, 185, 204;
            /* Estados (uso suave) */
            --ok: #1cc88a; --ok-rgb: 28, 200, 138;
            --warn: #f6c23e; --warn-rgb: 246, 194, 62;
            --nar: #fd7e14; --nar-rgb: 253, 126, 20;
            --err: #e74a3b; --err-rgb: 231, 74, 59;
            --err-osc: #b8392d;                 /* --danger con menor luminosidad, para texto AA */
            /* Neutros */
            --blanco: #ffffff;
            --n-50: #f8f9fc;                    /* --light */
            --n-500: #858796;                   /* --gray: solo texto grande o decorativo */
            --n-700: #5a5c69;                   /* --gray-dark: etiquetas (6.9:1 sobre blanco) */
            --n-900: #34353d;                   /* --gray-dark con menor luminosidad: títulos y cifras */
            /* Superficies */
            --fondo: #eef2fb;                   /* --primary al ~9 % sobre blanco */
            --vidrio: rgba(255, 255, 255, .88);
            --borde: rgba(var(--p-rgb), .16);
            /* Elevación: contacto + sombra difusa azulada debajo + canto de vidrio (línea blanca interior arriba) */
            --sombra: 0 1px 2px rgba(var(--p-rgb), .06), 0 14px 30px -16px rgba(var(--p-rgb), .30), inset 0 1px 0 rgba(255, 255, 255, .95);
            --sombra-hover: 0 1px 2px rgba(var(--p-rgb), .08), 0 18px 36px -16px rgba(var(--p-rgb), .36), 0 0 0 1px rgba(var(--acc-rgb), .28), 0 0 26px rgba(var(--acc-rgb), .20), inset 0 1px 0 rgba(255, 255, 255, .95);
            --radio: 22px;
            --gap: 22px;
            --t: .25s cubic-bezier(.2, .8, .2, 1);
            font-family: 'Outfit', 'Segoe UI', Roboto, Arial, sans-serif;
            color: var(--n-900);
            font-size: 14px;
            padding-bottom: 12px;
        }
        #content-wrapper {
            background-color: #eef2fb;
            background-image:
                radial-gradient(900px 520px at 8% 0%, rgba(78, 115, 223, .10), transparent 70%),
                radial-gradient(700px 480px at 100% 30%, rgba(54, 185, 204, .09), transparent 70%),
                radial-gradient(800px 600px at 40% 100%, rgba(78, 115, 223, .08), transparent 70%);
            background-attachment: fixed;
        }

        /* ---------- Componentes base ---------- */
        .px .vidrio { background: var(--vidrio); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--borde); border-radius: var(--radio); box-shadow: var(--sombra); transition: transform var(--t), box-shadow var(--t), border-color var(--t); }
        /* Halo celeste solo como respuesta al pasar el mouse sobre una tarjeta de contenido */
        .px .vidrio.card-p:hover { box-shadow: var(--sombra-hover); border-color: rgba(var(--acc-rgb), .35); transform: translateY(-2px); }
        .px .card-p { padding: 22px 24px; height: 100%; display: flex; flex-direction: column; position: relative; }
        .px .etq { font-size: 12px; font-weight: 500; color: var(--n-700); letter-spacing: .2px; }
        .px .titulo-card { font-size: 18px; font-weight: 400; color: var(--n-900); margin: 0; }
        .px .sub-card { font-size: 12px; color: var(--n-700); margin-top: 2px; }
        .px .cifra { font-weight: 300; line-height: 1; color: var(--n-900); letter-spacing: -1px; }
        .px .pildora-ico { width: 34px; height: 34px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;
            background: var(--blanco); border: 1px solid var(--borde); color: var(--p); font-size: 13px; flex-shrink: 0; }
        .px .delta { display: inline-flex; align-items: center; gap: 4px; font-size: 12px; font-weight: 500; padding: 2px 9px; border-radius: 999px; white-space: nowrap; }
        .px .delta.bueno { background: rgba(var(--ok-rgb), .12); color: #13855c; }
        .px .delta.malo { background: rgba(var(--err-rgb), .10); color: var(--err-osc); }
        .px .delta.neutro { background: rgba(var(--p-rgb), .07); color: var(--n-700); }
        .px .punto-vivo { width: 8px; height: 8px; border-radius: 50%; background: var(--p); box-shadow: 0 0 0 4px rgba(var(--p-rgb), .15), 0 0 12px rgba(var(--p-rgb), .6); animation: pxLatido 2.4s ease-in-out infinite; display: inline-block; }
        @keyframes pxLatido { 0%, 100% { box-shadow: 0 0 0 3px rgba(var(--p-rgb), .15), 0 0 8px rgba(var(--p-rgb), .45); } 50% { box-shadow: 0 0 0 6px rgba(var(--p-rgb), .08), 0 0 16px rgba(var(--p-rgb), .7); } }
        .px .aparece { animation: pxAparece .5s cubic-bezier(.2, .8, .2, 1) both; }
        @keyframes pxAparece { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: none; } }

        /* ---------- Encabezado ---------- */
        .px .encabezado { display: flex; flex-wrap: wrap; align-items: flex-start; justify-content: space-between; gap: 18px; margin-bottom: 18px; }
        .px .encabezado h1 { font-size: 36px; font-weight: 600; letter-spacing: -.8px; color: var(--p-osc); margin: 0; }
        .px .encabezado .meta { display: flex; flex-wrap: wrap; align-items: center; gap: 14px; margin-top: 6px; font-size: 13px; color: var(--n-700); }
        .px .nav-pildora { display: inline-flex; flex-wrap: wrap; gap: 4px; padding: 5px; border-radius: 999px; }
        .px .nav-pildora a { display: inline-flex; align-items: center; gap: 7px; padding: 9px 16px; border-radius: 999px; font-size: 13px; font-weight: 500;
            color: var(--n-700); text-decoration: none; transition: background var(--t), color var(--t); }
        .px .nav-pildora a:hover { background: rgba(var(--p-rgb), .08); color: var(--p-osc); }
        .px .nav-pildora a.activo { background: var(--p); color: var(--blanco); box-shadow: 0 4px 14px rgba(var(--p-rgb), .35); }

        /* ---------- Filtros ---------- */
        .px .barra-filtros.filtros { padding: 14px 18px; margin-bottom: var(--gap); }
        .px .filtros .filtros-dropdowns { display: flex; flex-wrap: wrap; align-items: flex-end; gap: 12px; }
        .px .filtros .filtros-dropdowns > div { display: flex; flex-direction: column; gap: 4px; }
        .px .filtros label { font-size: 11.5px; font-weight: 500; color: var(--n-700); margin: 0 0 0 12px; }
        .px .filtros input[type=date], .px .filtros input[list] { height: 38px; padding: 6px 14px; border-radius: 999px; border: 1px solid var(--borde);
            background: rgba(255, 255, 255, .85); font-family: inherit; font-size: 13px; color: var(--n-900); outline: none; transition: border-color var(--t), box-shadow var(--t); }
        .px .filtros input[type=date] { width: 150px; }
        .px .filtros input[list] { width: 190px; text-transform: uppercase; }
        .px .filtros input:focus { border-color: var(--p); box-shadow: 0 0 0 3px rgba(var(--p-rgb), .15); }
        /* Campo fijado por el lugar de trabajo del usuario */
        .px .filtros input[readonly] { background: rgba(var(--p-rgb), .07); color: var(--n-700); cursor: not-allowed; box-shadow: none; }
        .px .filtros .btn-limpiar { height: 38px; border-radius: 999px; padding: 0 18px; font-size: 13px; font-weight: 500; border: 1px solid var(--borde); background: var(--blanco); color: var(--n-700); transition: background var(--t); }
        .px .filtros .btn-limpiar:hover { background: rgba(var(--p-rgb), .07); }
        .px .chips { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; margin-top: 12px; }
        .px .chip { display: inline-flex; align-items: center; gap: 8px; padding: 5px 6px 5px 13px; border-radius: 999px; background: rgba(var(--p-rgb), .08); color: var(--p-osc); font-size: 12.5px; font-weight: 500; }
        .px .chip a { width: 20px; height: 20px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; background: var(--blanco); color: var(--p-osc); font-size: 10px; text-decoration: none; }
        .px .chip a:hover { background: var(--err); color: var(--blanco); }

        /* ---------- Resumen: barra segmentada + cifras grandes ---------- */
        .px .resumen { display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 26px; margin-bottom: var(--gap); }
        .px .segmentos { flex: 1 1 520px; display: flex; flex-wrap: wrap; gap: 8px; align-items: flex-end; min-width: 0; }
        /* Cada segmento mide al menos lo que su etiqueta: el nombre y la cifra nunca se cortan, aunque la proporción sea pequeña */
        .px .seg { min-width: max-content; display: flex; flex-direction: column; gap: 8px; transition: flex-grow .8s cubic-bezier(.2, .8, .2, 1); }
        .px .seg .etq { white-space: nowrap; display: block; }
        .px .seg .etq i { margin-right: 5px; }
        .px .resumen .cifras { margin-left: 12px; }
        .px .seg .etq b { font-weight: 600; color: var(--n-900); }
        .px .seg .barra { height: 46px; border-radius: 999px; display: flex; align-items: center; padding: 0 16px; font-size: 13px; font-weight: 500; white-space: nowrap; overflow: hidden; }
        .px .seg.por_admitir .barra { background: repeating-linear-gradient(135deg, rgba(var(--warn-rgb), .9) 0 7px, rgba(var(--warn-rgb), .45) 7px 14px); color: var(--n-900); }
        .px .seg.en_valoracion .barra { background: var(--acc); color: var(--n-900); }
        .px .seg.efectivizadas .barra { background: var(--p); color: var(--blanco); }
        .px .seg.rechazadas .barra { background: transparent; border: 1.5px solid rgba(var(--err-rgb), .7); color: var(--err-osc); }
        .px .cifras { display: flex; flex-wrap: wrap; gap: 30px; }
        .px .cifras .item { display: flex; flex-direction: column; gap: 6px; }
        .px .cifras .item .cifra { font-size: 56px; }
        .px .cifras .item .cifra small { font-size: 22px; font-weight: 300; letter-spacing: 0; }
        .px .cifras .item .pie { display: flex; align-items: center; gap: 8px; }

        /* ---------- Grid principal (estilo de la muestra) ---------- */
        .px .grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--gap); margin-bottom: var(--gap); }
        .px .g-pend { grid-row: span 2; }
        .px .g-mapa { grid-column: span 2; }
        .px .grid-2 { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--gap); }
        .px .cab-card { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; margin-bottom: 12px; }

        /* Anillos */
        .px .anillo-wrap { position: relative; width: 190px; max-width: 100%; aspect-ratio: 1 / 1; margin: 6px auto 0; }
        .px .anillo-wrap svg { width: 100%; height: 100%; transform: rotate(-90deg); }
        .px .anillo-wrap .centro { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; }
        .px .anillo-wrap .centro .cifra { font-size: 40px; }
        .px .anillo-wrap .centro .cifra small { font-size: 18px; }
        .px .arco { fill: none; stroke-linecap: round; transition: stroke-dashoffset 1.4s cubic-bezier(.2, .8, .2, 1); }
        .px .pie-card { margin-top: auto; padding-top: 14px; display: flex; align-items: center; justify-content: space-between; gap: 10px; font-size: 12.5px; color: var(--n-700); }

        /* Tendencia: barras finas con punto */
        .px .tend { display: flex; align-items: flex-end; justify-content: space-between; gap: 4px; height: 170px; margin-top: 34px; }
        .px .tend .col { flex: 1 1 0; display: flex; flex-direction: column; align-items: center; justify-content: flex-end; gap: 6px; height: 100%; position: relative; min-width: 0; max-width: none; padding: 0; }
        .px .tend .pista { width: 6px; flex: 1; display: flex; align-items: flex-end; border-radius: 6px; background: repeating-linear-gradient(to top, rgba(var(--p-rgb), .14) 0 3px, transparent 3px 7px); }
        .px .tend .relleno { width: 100%; border-radius: 6px; background: var(--n-700); height: 0; transition: height 1s cubic-bezier(.2, .8, .2, 1); }
        .px .tend .col.max .relleno { background: var(--p); }
        .px .tend .dot { width: 6px; height: 6px; border-radius: 50%; background: var(--n-700); }
        .px .tend .col.max .dot { background: var(--p); }
        .px .tend .lbl { font-size: 10.5px; color: var(--n-700); white-space: nowrap; line-height: 1.15; text-align: center; min-height: 26px; }
        .px .tend .lbl small { display: block; font-size: 9.5px; color: var(--n-700); opacity: .85; }
        .px .tend.inclinada { margin-bottom: 14px; }
        .px .tend.inclinada .lbl { transform: rotate(-45deg); transform-origin: top center; margin-top: 6px; min-height: 18px; }
        /* Colores por categoría (canales y dispositivos): ícono, fondo suave y barra del mismo tono */
        .px .lista-barras .pildora-ico { color: var(--cc, var(--p)); background: rgba(var(--cc-rgb, var(--p-rgb)), .12); border-color: rgba(var(--cc-rgb, var(--p-rgb)), .25); }
        .px .lista-barras .item .pista span { background: var(--cc, var(--p)); }
        .px .tend .globo { position: absolute; top: -4px; transform: translateY(-100%); background: var(--p); color: var(--blanco); font-size: 11px; font-weight: 500; padding: 2px 8px; border-radius: 999px; white-space: nowrap; }

        /* Desglose de tiempos */
        .px .desglose { display: flex; gap: 8px; margin-top: 12px; }
        .px .desglose > div { flex: 1; border-radius: 14px; padding: 8px 12px; background: rgba(var(--p-rgb), .05); }
        .px .desglose b { display: block; font-size: 16px; font-weight: 500; color: var(--n-900); }

        /* Pendientes: segmentos de antigüedad + tarjeta oscura */
        .px .antig { display: flex; gap: 6px; align-items: flex-end; margin: 6px 0 4px; }
        .px .antig .s { display: flex; flex-direction: column; gap: 6px; min-width: 36px; transition: flex-grow .8s cubic-bezier(.2, .8, .2, 1); }
        .px .antig .s span { font-size: 12px; color: var(--n-700); border-left: 1px solid rgba(var(--p-rgb), .25); padding-left: 6px; white-space: nowrap; }
        .px .antig .s i { display: block; height: 34px; border-radius: 12px; }
        .px .antig .ok i { background: rgba(var(--ok-rgb), .75); } .px .antig .warn i { background: rgba(var(--warn-rgb), .85); }
        .px .antig .naranja i { background: rgba(var(--nar-rgb), .75); } .px .antig .err i { background: rgba(var(--err-rgb), .8); }
        .px .leyenda-antig { display: flex; flex-wrap: wrap; gap: 4px 12px; font-size: 11.5px; color: var(--n-700); margin-bottom: 14px; }
        .px .leyenda-antig i { display: inline-block; width: 8px; height: 8px; border-radius: 3px; margin-right: 5px; }
        .px .oscura { background: linear-gradient(165deg, var(--p-osc) 0%, var(--p-prof) 100%); color: var(--blanco); border-radius: 20px; padding: 20px 18px; display: flex; flex-direction: column; }
        .px .detalle-antig { margin-top: 18px; display: flex; flex-direction: column; gap: 12px; }
        .px .detalle-antig .fila-a { display: grid; grid-template-columns: 74px 1fr 30px; align-items: center; gap: 10px; font-size: 12.5px; color: var(--n-700); }
        .px .detalle-antig .pista-a { height: 8px; border-radius: 8px; background: rgba(var(--p-rgb), .08); overflow: hidden; }
        .px .detalle-antig .pista-a span { display: block; height: 100%; width: 0; border-radius: 8px; transition: width 1.1s cubic-bezier(.2, .8, .2, 1); }
        .px .detalle-antig .fila-a b { text-align: right; font-weight: 500; color: var(--n-900); }
        .px .detalle-antig small { grid-column: 2 / 4; margin-top: -8px; font-size: 11.5px; color: var(--n-700); }
        .px .oscura .cab { display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 10px; }
        .px .oscura .cab h6 { font-size: 16px; font-weight: 400; margin: 0; color: var(--blanco); }
        .px .oscura .cab .cifra { color: var(--blanco); font-size: 34px; }
        .px .oscura .fila { display: flex; align-items: center; gap: 12px; padding: 10px 0; border-top: 1px solid rgba(255, 255, 255, .12); }
        .px .oscura .fila .ico { width: 36px; height: 36px; border-radius: 50%; background: rgba(255, 255, 255, .12); display: inline-flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0; }
        .px .oscura .fila .txt { flex: 1; min-width: 0; }
        .px .oscura .fila .txt b { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; font-size: 12.5px; font-weight: 500; line-height: 1.3; }
        .px .oscura .fila .txt small { font-size: 11.5px; color: rgba(255, 255, 255, .78); }
        .px .oscura .fila .num { text-align: right; }
        /* WhatsApp del Personal Telesalud del municipio */
        .px .oscura .fila a.ico.wa { font-size: 18px; background: rgba(var(--ok-rgb), .22); color: #8af3cd; box-shadow: inset 0 0 0 1px rgba(var(--ok-rgb), .5);
            text-decoration: none; transition: background var(--t), transform var(--t), box-shadow var(--t), color var(--t); }
        .px .oscura .fila a.ico.wa:hover, .px .oscura .fila a.ico.wa:focus-visible { background: var(--ok); color: #fff; transform: scale(1.08); box-shadow: 0 0 14px rgba(var(--ok-rgb), .75); outline: none; }
        .px .oscura .fila .num b { display: block; font-size: 18px; font-weight: 400; }
        .px .oscura .fila .num small { font-size: 11px; color: rgba(255, 255, 255, .85); display: inline-flex; align-items: center; gap: 5px; }
        .px .oscura .sem { width: 7px; height: 7px; border-radius: 50%; display: inline-block; }
        .px .oscura .sem.ok { background: var(--ok); box-shadow: 0 0 8px rgba(var(--ok-rgb), .8); }
        .px .oscura .sem.naranja { background: var(--warn); box-shadow: 0 0 8px rgba(var(--warn-rgb), .8); }
        .px .oscura .sem.err { background: var(--err); box-shadow: 0 0 8px rgba(var(--err-rgb), .8); }
        .px .oscura .vacio { margin: auto; text-align: center; color: rgba(255, 255, 255, .85); font-size: 13px; }
        .px .oscura .mas { margin-top: auto; padding-top: 10px; font-size: 12px; color: rgba(255, 255, 255, .8); }
        /* Lista desplegable con el resto de establecimientos con pendientes */
        .px .oscura .pend-extra { max-height: 380px; overflow-y: auto; margin-right: -6px; padding-right: 6px; scrollbar-width: thin; scrollbar-color: rgba(255, 255, 255, .35) transparent; }
        .px .oscura .pend-extra::-webkit-scrollbar { width: 6px; }
        .px .oscura .pend-extra::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, .3); border-radius: 6px; }
        .px .oscura .pend-extra:not([hidden]) { animation: pxAparece .35s cubic-bezier(.2, .8, .2, 1) both; }
        .px .oscura .mas-btn { margin-top: auto; width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 9px 12px; border: 0; border-radius: 12px;
            background: rgba(255, 255, 255, .1); color: rgba(255, 255, 255, .92); font-family: inherit; font-size: 12px; font-weight: 500; cursor: pointer; transition: background var(--t); }
        .px .oscura .pend-extra + .mas-btn, .px .oscura .fila + .mas-btn { margin-top: 10px; }
        .px .oscura .mas-btn:hover, .px .oscura .mas-btn:focus-visible { background: rgba(255, 255, 255, .18); outline: none; }
        .px .oscura .mas-btn i { transition: transform var(--t); }
        .px .oscura .mas-btn.abierto i { transform: rotate(180deg); }

        /* Perfil en acordeón */
        .px .acord { border-top: 1px dashed rgba(var(--p-rgb), .18); }
        .px .acord:first-of-type { border-top: 0; }
        .px .acord-cab { width: 100%; background: none; border: 0; padding: 14px 0; display: flex; align-items: center; gap: 10px; cursor: pointer; text-align: left; font-family: inherit; }
        .px .acord-cab .t { flex: 1; font-size: 15px; font-weight: 400; color: var(--n-900); }
        .px .acord-cab .r { font-size: 12px; color: var(--n-700); }
        .px .acord-cab .chev { color: var(--n-700); transition: transform var(--t); }
        .px .acord.abierto .chev { transform: rotate(180deg); }
        .px .acord-cuerpo { max-height: 0; overflow: hidden; transition: max-height .35s cubic-bezier(.2, .8, .2, 1); }
        .px .acord.abierto .acord-cuerpo { max-height: 220px; }
        .px .acord-cuerpo .dentro { padding: 0 0 14px; }
        .px .prop { display: flex; height: 8px; border-radius: 8px; overflow: hidden; background: rgba(var(--p-rgb), .08); }
        .px .prop span { height: 100%; width: 0; transition: width 1.1s cubic-bezier(.2, .8, .2, 1); }
        .px .prop span + span { border-left: 2px solid var(--blanco); }
        .px .prop-items { display: flex; flex-direction: column; gap: 6px; margin-top: 10px; }
        .px .prop-items div { display: flex; align-items: center; gap: 8px; font-size: 12.5px; color: var(--n-700); }
        .px .prop-items div b { margin-left: auto; font-weight: 500; color: var(--n-900); }
        .px .prop-items i.p { width: 8px; height: 8px; border-radius: 3px; display: inline-block; }

        /* Mapa */
        .px .mapa-wrap { position: relative; border-radius: 16px; overflow: hidden; background: rgba(var(--p-rgb), .04); flex: 1; }
        .px #contenedor-mapa { height: 470px; }
        .px .mapa-capas { position: absolute; top: 12px; left: 12px; z-index: 5; display: inline-flex; padding: 4px; gap: 2px; border-radius: 999px; background: rgba(255, 255, 255, .85); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid var(--borde); }
        .px .mapa-capas button { border: 0; background: transparent; font-family: inherit; font-size: 12px; font-weight: 500; color: var(--n-700); padding: 6px 12px; border-radius: 999px; cursor: pointer; transition: background var(--t), color var(--t); }
        .px .mapa-capas button:hover { background: rgba(var(--p-rgb), .08); }
        .px .mapa-capas button.activo { background: var(--p); color: var(--blanco); }
        .px .mapa-capas button:disabled { opacity: .4; cursor: not-allowed; }
        .px .mapa-btn { position: absolute; top: 12px; right: 12px; z-index: 5; width: 38px; height: 38px; border-radius: 50%; border: 1px solid var(--borde); background: rgba(255, 255, 255, .9); color: var(--p); cursor: pointer; transition: transform var(--t); }
        .px .mapa-btn:hover { transform: scale(1.06); }
        .px .mapa-rutas { position: absolute; left: 12px; bottom: 12px; z-index: 5; min-width: 220px; max-width: 280px; padding: 12px 14px; border-radius: 16px; background: rgba(255, 255, 255, .85); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid var(--borde); }
        .px .mapa-rutas h6 { font-size: 12px; font-weight: 500; color: var(--n-700); margin: 0 0 6px; }
        .px .ruta { display: flex; align-items: center; gap: 8px; font-size: 12.5px; padding: 3px 0; }
        .px .ruta .n { width: 20px; height: 20px; border-radius: 50%; background: rgba(var(--p-rgb), .1); color: var(--p-osc); font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; justify-content: center; }
        .px .ruta .txt { flex: 1; color: var(--n-900); }
        .px .ruta .txt i { color: var(--p); font-size: 10px; margin: 0 4px; }
        .px .mapa-aviso { position: absolute; left: 12px; top: 58px; z-index: 5; font-size: 11.5px; padding: 5px 12px; border-radius: 999px; background: rgba(255, 255, 255, .9); color: var(--n-700); display: none; }
        .px .tic-mapa .highcharts-flowmap-series .highcharts-point { animation: pxPulso 2.6s ease-in-out infinite; filter: drop-shadow(0 0 3px rgba(var(--p-rgb), .5)); }
        @keyframes pxPulso { 0%, 100% { opacity: .55; } 50% { opacity: 1; } }
        .px .tic-mapa:fullscreen { border-radius: 0; background: var(--n-50); padding: 16px; }
        .px .tic-mapa:fullscreen #contenedor-mapa { height: calc(100vh - 110px); }

        /* Estados de carga y vacío */
        .px .esqueleto { height: 100%; min-height: 120px; border-radius: 16px; background: linear-gradient(90deg, rgba(var(--p-rgb), .05) 25%, rgba(var(--p-rgb), .09) 37%, rgba(var(--p-rgb), .05) 63%); background-size: 400% 100%; animation: pxBrillo 1.4s ease infinite; }
        @keyframes pxBrillo { 0% { background-position: 100% 50%; } 100% { background-position: 0 50%; } }
        .px .vacio { height: 100%; min-height: 180px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 6px; text-align: center; color: var(--n-700); font-size: 13px; }
        .px .vacio i { font-size: 34px; color: rgba(var(--p-rgb), .25); margin-bottom: 4px; }

        /* Menú de exportación de Highcharts */
        .highcharts-contextmenu, .highcharts-data-table table { font-family: 'Outfit', 'Segoe UI', Arial, sans-serif; }
        .highcharts-data-table table { font-size: 12.5px; border-collapse: collapse; width: 100%; margin-top: 10px; }
        .highcharts-data-table th, .highcharts-data-table td { padding: 6px 10px; border-bottom: 1px solid rgba(78, 115, 223, .1); text-align: left; }
        .highcharts-data-table caption { display: none; }


        /* Segmentos genéricos (Teleconsultas / Telemetrías): tonos del primario y el acento */
        .px .seg.s1 .barra { background: var(--p); color: var(--blanco); }
        .px .seg.s2 .barra { background: var(--acc); color: var(--n-900); }
        .px .seg.s3 .barra { background: rgba(var(--p-rgb), .45); color: var(--n-900); }
        .px .seg.s4 .barra { background: rgba(var(--p-rgb), .14); color: var(--p-osc); }
        .px .seg.s5 .barra { background: repeating-linear-gradient(135deg, rgba(var(--p-rgb), .22) 0 7px, rgba(var(--p-rgb), .08) 7px 14px); color: var(--n-900); }
        .px .resumen .titulo-seg { flex-basis: 100%; margin-bottom: -14px; }
        /* Segmento con el color de su categoría (mismo color que en la lista de dispositivos) */
        .px .seg.cc .barra { background: var(--cc); color: var(--cc-txt); }

        /* Lista con barras finas (canales, dispositivos, grupos) */
        .px .lista-barras { display: flex; flex-direction: column; gap: 14px; margin-top: 6px; }
        .px .lista-barras .item { display: grid; grid-template-columns: 34px minmax(0, 1fr); align-items: center; gap: 12px; }
        .px .lista-barras .nom { font-size: 13px; color: var(--n-900); display: flex; justify-content: space-between; gap: 8px; margin-bottom: 6px; }
        .px .lista-barras .nom b { font-weight: 500; white-space: nowrap; }
        .px .lista-barras .nom b small { color: var(--n-700); font-weight: 400; font-size: 12px; }
        .px .lista-barras .pista { height: 6px; border-radius: 6px; background: rgba(var(--p-rgb), .08); overflow: hidden; }
        .px .lista-barras .pista span { display: block; height: 100%; width: 0; border-radius: 6px; background: var(--p); transition: width 1.1s cubic-bezier(.2, .8, .2, 1); }

        @media (max-width: 1399.98px) {
            .px .grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .px .g-pend { grid-row: span 1; }
            .px .g-mapa { grid-column: span 2; }
        }
        @media (max-width: 767.98px) {
            .px .grid, .px .grid-2 { grid-template-columns: minmax(0, 1fr); }
            .px .g-mapa { grid-column: span 1; }
            .px .encabezado h1 { font-size: 28px; }
            .px .cifras .item .cifra { font-size: 42px; }
            .px .filtros input[type=date], .px .filtros input[list] { width: 100%; }
            .px .filtros .filtros-dropdowns > div { width: 100%; }
            .px #contenedor-mapa { height: 360px; }
            .px .mapa-rutas { display: none; }
            .px .segmentos { flex-wrap: wrap; }
        }
        /* Botón "Actualizar" junto a la hora de los datos (caché de 10 minutos) */
        .px .btn-actualizar { display: inline-flex; align-items: center; gap: 5px; padding: 3px 11px; border-radius: 999px; font-size: 12px; font-weight: 500;
            color: var(--p-osc); background: rgba(var(--p-rgb), .08); text-decoration: none; transition: background var(--t); }
        .px .btn-actualizar:hover { background: rgba(var(--p-rgb), .16); color: var(--p-osc); text-decoration: none; }

        /* ---------- Indicador de carga (vidrio esmerilado sobre el contenido) ---------- */
        .px .tm-cargando { position: fixed; top: 0; right: 0; bottom: 0; left: 0; z-index: 1040; display: flex; align-items: center; justify-content: center;
            background: rgba(238, 242, 251, .42); backdrop-filter: blur(9px) saturate(1.15); -webkit-backdrop-filter: blur(9px) saturate(1.15);
            opacity: 0; visibility: hidden; transition: opacity .25s ease, visibility .25s ease; }
        .px .tm-cargando.activo { opacity: 1; visibility: visible; }
        .px .tm-cargando .caja { display: flex; flex-direction: column; align-items: center; gap: 12px; padding: 28px 40px; border-radius: var(--radio);
            box-shadow: 0 20px 50px -18px rgba(var(--p-rgb), .45), 0 0 0 1px rgba(var(--acc-rgb), .18), inset 0 1px 0 rgba(255, 255, 255, .95); }
        .px .tm-cargando .anillo { width: 56px; height: 56px; border-radius: 50%;
            background: conic-gradient(from 0deg, rgba(var(--acc-rgb), 0) 0%, var(--acc) 45%, var(--p) 80%, rgba(var(--p-rgb), 0) 100%);
            -webkit-mask: radial-gradient(farthest-side, transparent calc(100% - 6px), #000 calc(100% - 5px));
            mask: radial-gradient(farthest-side, transparent calc(100% - 6px), #000 calc(100% - 5px));
            filter: drop-shadow(0 0 8px rgba(var(--acc-rgb), .45)); animation: tmGiro .9s linear infinite; }
        .px .tm-cargando .t { font-size: 15px; font-weight: 500; color: var(--p-osc); }
        .px .tm-cargando .s { font-size: 12px; color: var(--n-700); margin-top: -8px; }
        @keyframes tmGiro { to { transform: rotate(360deg); } }

        @media (prefers-reduced-motion: reduce) { .px *, .px *::before, .px *::after { animation: none !important; transition: none !important; }
            .px .tm-cargando .anillo { animation: tmGiro 2.4s linear infinite !important; } }
    </style>
<?php }
