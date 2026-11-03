<?php
// =========================================================================
// TELEEDUCACIÓN: catálogos y reglas compartidas
//   (formulario, guardado, eliminación, impresión, consolidado y Excel)
// Los catálogos viven en la base de datos (base_datos/teleeducacion.sql): una opción nueva
// se agrega allí y aparece sola en el formulario, la validación, la ficha y los reportes.
// =========================================================================

// Catálogos completos, ordenados (incluye opciones desactivadas: los registros antiguos siguen mostrando su valor)
//   tipos        [id => id, nombre, descripcion, color, color_hex, titulo_asistentes, etiqueta_grupo, columnas, requiere_recursos, activo]
//   actividades  [id => id, idtipo, nombre, activo]
//   modalidades  [id => id, nombre, activo]
//   medios       [id => id, nombre, activo]
//   recursos     [id => id, nombre, activo]
//   grupos       [id => id, idtipo, idpadre, nombre, activo, hijos [ids]]
//   generos      [id => nombre]  (tabla genero del sistema)
function te_catalogos($link) {
    static $cat = null;
    if ($cat !== null) { return $cat; }
    $cat = ['tipos' => [], 'actividades' => [], 'modalidades' => [], 'medios' => [], 'recursos' => [], 'grupos' => [], 'generos' => []];
    $leer = function ($sql) use ($link) { $res = mysqli_query($link, $sql); $filas = []; if ($res) { while ($r = mysqli_fetch_assoc($res)) { $filas[] = $r; } } return $filas; };

    foreach ($leer("SELECT * FROM tipo_teleeducacion ORDER BY orden, idtipo_teleeducacion") as $r) {
        $cat['tipos'][(int)$r['idtipo_teleeducacion']] = [
            'id' => (int)$r['idtipo_teleeducacion'], 'nombre' => $r['tipo_teleeducacion'], 'descripcion' => (string)$r['descripcion'],
            'color' => $r['color'], 'color_hex' => $r['color_hex'],
            'titulo_asistentes' => $r['titulo_asistentes'], 'etiqueta_grupo' => $r['etiqueta_grupo'],
            'columnas' => max(1, (int)$r['columnas_asistentes']), 'requiere_recursos' => $r['requiere_recursos'] === 'SI', 'activo' => $r['activo'] === 'SI',
        ];
    }
    foreach ($leer("SELECT * FROM actividad_teleeducacion ORDER BY idtipo_teleeducacion, orden, idactividad_teleeducacion") as $r) {
        $cat['actividades'][(int)$r['idactividad_teleeducacion']] = ['id' => (int)$r['idactividad_teleeducacion'], 'idtipo' => (int)$r['idtipo_teleeducacion'],
            'nombre' => $r['actividad_teleeducacion'], 'activo' => $r['activo'] === 'SI'];
    }
    foreach ($leer("SELECT * FROM modalidad_teleeducacion ORDER BY orden, idmodalidad_teleeducacion") as $r) {
        $cat['modalidades'][(int)$r['idmodalidad_teleeducacion']] = ['id' => (int)$r['idmodalidad_teleeducacion'], 'nombre' => $r['modalidad_teleeducacion'], 'activo' => $r['activo'] === 'SI'];
    }
    foreach ($leer("SELECT * FROM medio_digital ORDER BY orden, idmedio_digital") as $r) {
        $cat['medios'][(int)$r['idmedio_digital']] = ['id' => (int)$r['idmedio_digital'], 'nombre' => $r['medio_digital'], 'activo' => $r['activo'] === 'SI'];
    }
    foreach ($leer("SELECT * FROM recurso_teleeducacion ORDER BY orden, idrecurso_teleeducacion") as $r) {
        $cat['recursos'][(int)$r['idrecurso_teleeducacion']] = ['id' => (int)$r['idrecurso_teleeducacion'], 'nombre' => $r['recurso_teleeducacion'], 'activo' => $r['activo'] === 'SI'];
    }
    foreach ($leer("SELECT * FROM grupo_asistente_te ORDER BY idtipo_teleeducacion, orden, idgrupo_asistente_te") as $r) {
        $cat['grupos'][(int)$r['idgrupo_asistente_te']] = [
            'id' => (int)$r['idgrupo_asistente_te'], 'idtipo' => (int)$r['idtipo_teleeducacion'], 'idpadre' => $r['idgrupo_padre'] !== null ? (int)$r['idgrupo_padre'] : null,
            'nombre' => $r['grupo_asistente_te'], 'activo' => $r['activo'] === 'SI', 'hijos' => [],
        ];
    }
    foreach ($cat['grupos'] as $id => $g) { if ($g['idpadre'] !== null && isset($cat['grupos'][$g['idpadre']])) { $cat['grupos'][$g['idpadre']]['hijos'][] = $id; } }
    // Masculino primero y luego femenino, como el formulario original (genero: 1 FEMENINO, 2 MASCULINO)
    foreach ($leer("SELECT idgenero, genero FROM genero ORDER BY idgenero DESC") as $r) { $cat['generos'][(int)$r['idgenero']] = mb_strtoupper(trim($r['genero'])); }
    return $cat;
}

// Opciones de un catálogo para un formulario: solo las activas (y la ya guardada, aunque se haya desactivado);
// $idtipo filtra los catálogos que dependen del tipo (actividades)
function te_opciones($lista, $incluir = null, $idtipo = null) {
    $out = [];
    foreach ($lista as $id => $o) {
        if ($idtipo !== null && isset($o['idtipo']) && $o['idtipo'] !== (int)$idtipo) { continue; }
        if ($o['activo'] || (int)$id === (int)$incluir) { $out[$id] = $o; }
    }
    return $out;
}

// Nombre de una opción de catálogo por su id ('' si no existe)
function te_nombre($lista, $id) {
    return isset($lista[(int)$id]) ? $lista[(int)$id]['nombre'] : '';
}

// Filas de la tabla de asistentes de un tipo, en orden:
//   ['g' => grupo, 'nivel' => 'encabezado' | 'sub' | 'fila']
// Un encabezado solo agrupa (no recibe cantidades). $solo_activos oculta los desactivados,
// salvo los de $incluir (grupos con datos guardados en la sesión que se modifica o imprime)
function te_filas_grupos($cat, $idtipo, $solo_activos = true, $incluir = []) {
    $ver = function ($g) use ($solo_activos, $incluir) { return !$solo_activos || $g['activo'] || in_array($g['id'], $incluir, true); };
    $filas = [];
    foreach ($cat['grupos'] as $g) {
        if ($g['idtipo'] !== (int)$idtipo || $g['idpadre'] !== null || !$ver($g)) { continue; }
        if ($g['hijos']) {
            $sub = [];
            foreach ($g['hijos'] as $hid) { if ($ver($cat['grupos'][$hid])) { $sub[] = ['g' => $cat['grupos'][$hid], 'nivel' => 'sub']; } }
            if ($sub) { $filas[] = ['g' => $g, 'nivel' => 'encabezado']; $filas = array_merge($filas, $sub); }
        } else {
            $filas[] = ['g' => $g, 'nivel' => 'fila'];
        }
    }
    return $filas;
}

// Ids de los grupos de un tipo que reciben cantidades (los activos que no son encabezado)
function te_grupos_captura($cat, $idtipo) {
    $ids = [];
    foreach (te_filas_grupos($cat, $idtipo) as $f) { if ($f['nivel'] !== 'encabezado') { $ids[] = $f['g']['id']; } }
    return $ids;
}

// Inicial del género para encabezados cortos (MASCULINO -> M)
function te_genero_corto($nombre) {
    return mb_substr((string)$nombre, 0, 1);
}

// DURACIÓN: se guarda en MINUTOS (entero exacto, se suma sin redondeos) y se captura como horas + minutos (0 a 59)
// Corta (tablas, Excel): 119 -> "1:59", 45 -> "0:45", 1530 -> "25:30" (los totales pueden pasar de 24 h)
function te_hm($minutos) {
    $m = max(0, (int)$minutos);
    return intdiv($m, 60) . ':' . str_pad((string)($m % 60), 2, '0', STR_PAD_LEFT);
}
// Larga (ficha): 119 -> "1 hora 59 minutos", 120 -> "2 horas", 45 -> "45 minutos"
function te_duracion($minutos) {
    $m = max(0, (int)$minutos); $h = intdiv($m, 60); $r = $m % 60;
    $partes = [];
    if ($h > 0) { $partes[] = $h . ($h === 1 ? ' hora' : ' horas'); }
    if ($r > 0 || $h === 0) { $partes[] = $r . ($r === 1 ? ' minuto' : ' minutos'); }
    return implode(' ', $partes);
}
// Duración válida: horas enteras de 0 a 24 y minutos de 0 a 59; en total entre 1 minuto y 24 horas
function te_duracion_valida($horas, $minutos) {
    if (!ctype_digit((string)$horas) || !ctype_digit((string)$minutos)) { return false; }
    $h = (int)$horas; $m = (int)$minutos;
    return $h <= 24 && $m <= 59 && ($h * 60 + $m) >= 1 && ($h * 60 + $m) <= 1440;
}

// REGLA DE REGISTRO: solo sesiones del MES EN CURSO, como los demás servicios de Telemedicina
// (del día 1 del mes a hoy; no se cargan casos de meses anteriores ni fechas futuras)
function te_mes_desde() { return date('Y-m-01'); }
function te_fecha_permitida($fecha) {
    return $fecha >= te_mes_desde() && $fecha <= date('Y-m-d');
}

// REGLA DE MODIFICACIÓN / ELIMINACIÓN: solo quien registró la sesión y solo dentro del MES DE REGISTRO
// (registrada el 2 de octubre -> se puede corregir o eliminar hasta el 31 de octubre)
function te_editable($fila, $idusuario) {
    return (string)$fila['idusuario'] === (string)$idusuario
        && substr((string)$fila['fecha_registro'], 0, 7) === date('Y-m');
}

// Una sesión completa. null si no existe.
//   cabecera (t.*) + lugar + nombre de quien registró
//   grupos      [idgrupo => [idgenero => cantidad]]
//   por_genero  [idgenero => total]
//   recursos    [idrecurso, ...]
function te_leer($link, $id) {
    $id = (int)$id;
    $res = mysqli_query($link, "SELECT t.*, es.establecimiento_salud, m.municipio, d.departamento, n.nombre, n.paterno, n.materno
        FROM teleeducacion t
        INNER JOIN establecimiento_salud es ON es.idestablecimiento_salud = t.idestablecimiento_salud
        LEFT JOIN municipios m ON m.idmunicipio = t.idmunicipio
        LEFT JOIN departamento d ON d.iddepartamento = t.iddepartamento
        LEFT JOIN usuarios u ON u.idusuario = t.idusuario
        LEFT JOIN nombre n ON n.idnombre = u.idnombre
        WHERE t.idteleeducacion = '$id'");
    $t = $res ? mysqli_fetch_assoc($res) : null;
    if (!$t) { return null; }
    $t['grupos'] = []; $t['por_genero'] = []; $t['recursos'] = [];
    $res = mysqli_query($link, "SELECT idgrupo_asistente_te, idgenero, cantidad FROM teleeducacion_asistente WHERE idteleeducacion = '$id'");
    if ($res) {
        while ($r = mysqli_fetch_row($res)) {
            $t['grupos'][(int)$r[0]][(int)$r[1]] = (int)$r[2];
            $t['por_genero'][(int)$r[1]] = (isset($t['por_genero'][(int)$r[1]]) ? $t['por_genero'][(int)$r[1]] : 0) + (int)$r[2];
        }
    }
    $res = mysqli_query($link, "SELECT tr.idrecurso_teleeducacion FROM teleeducacion_recurso tr
        INNER JOIN recurso_teleeducacion r ON r.idrecurso_teleeducacion = tr.idrecurso_teleeducacion
        WHERE tr.idteleeducacion = '$id' ORDER BY r.orden, r.idrecurso_teleeducacion");
    if ($res) { while ($r = mysqli_fetch_row($res)) { $t['recursos'][] = (int)$r[0]; } }
    return $t;
}

// Condición SQL del CONSOLIDADO (pantalla y Excel): sesiones por FECHA DE LA SESIÓN dentro del periodo,
// con los filtros de lugar y médico (quien registró) ya recortados al alcance del usuario (tm_forzar_alcance). Alias de la tabla: t
function te_where($link, $ini, $fin, $f) {
    $e = function ($v) use ($link) { return mysqli_real_escape_string($link, (string)$v); };
    $w = "t.fecha_sesion BETWEEN '" . $e($ini) . "' AND '" . $e($fin) . "'";
    foreach (['iddepartamento' => 't.iddepartamento', 'idmunicipio' => 't.idmunicipio', 'idestablecimiento' => 't.idestablecimiento_salud', 'idusuario_medico' => 't.idusuario'] as $k => $col) {
        if (isset($f[$k]) && $f[$k] !== '') { $w .= " AND $col = '" . $e($f[$k]) . "'"; }
    }
    return $w;
}

// Variables CSS de un color de categoría: --cc (color), --cc-rgb (para transparencias) y
// --cc-txt (el mismo color oscurecido hasta ser legible como texto sobre fondo claro, WCAG AA 4.5:1)
function te_css_color($hex) {
    if (!preg_match('/^#[0-9a-fA-F]{6}$/', (string)$hex)) { $hex = '#4e73df'; }
    $canal = function ($h) { return [hexdec(substr($h, 1, 2)), hexdec(substr($h, 3, 2)), hexdec(substr($h, 5, 2))]; };
    $lum = function ($c) {
        foreach ($c as $i => $v) { $v /= 255; $c[$i] = $v <= 0.03928 ? $v / 12.92 : pow(($v + 0.055) / 1.055, 2.4); }
        return 0.2126 * $c[0] + 0.7152 * $c[1] + 0.0722 * $c[2];
    };
    $rgb = $canal($hex);
    $txt = $rgb;
    for ($i = 0; $i < 20 && 1.05 / ($lum($txt) + 0.05) < 4.5; $i++) { $txt = array_map(function ($v) { return (int)round($v * .9); }, $txt); }
    return '--cc: ' . $hex . '; --cc-rgb: ' . implode(', ', $rgb) . '; --cc-txt: ' . vsprintf('#%02x%02x%02x', $txt) . ';';
}

// Lugar de trabajo ACTUAL del usuario (personal.iddato_laboral, como Telemedicina);
// si no lo tiene, su último dato laboral. null si no tiene ninguno.
function te_lugar($link, $idusuario) {
    $idu = (int)$idusuario;
    $campos = "SELECT es.iddepartamento, es.idmunicipio, es.idestablecimiento_salud, es.establecimiento_salud, m.municipio
        FROM dato_laboral dl
        INNER JOIN establecimiento_salud es ON es.idestablecimiento_salud = dl.idestablecimiento_salud
        LEFT JOIN municipios m ON m.idmunicipio = es.idmunicipio";
    foreach ([
        "$campos INNER JOIN personal p ON p.iddato_laboral = dl.iddato_laboral WHERE p.idusuario = '$idu' ORDER BY p.idpersonal DESC LIMIT 1",
        "$campos WHERE dl.idusuario = '$idu' ORDER BY dl.iddato_laboral DESC LIMIT 1",
    ] as $sql) {
        $res = mysqli_query($link, $sql);
        $l = $res ? mysqli_fetch_assoc($res) : null;
        if ($l && $l['idmunicipio']) { return $l; }
    }
    return null;
}
