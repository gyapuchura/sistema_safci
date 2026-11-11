<?php
/**
 * Funciones compartidas del flujo de CONTRARREFERENCIA
 * (valida_contrareferencia_hc -> formulario_contrareferencia_hc -> guarda_contrareferencia -> mensaje_contrareferencia_hc)
 *
 * - Consultas preparadas sin depender de mysqlnd (no usa get_result).
 * - Token por caso: permite tener varias contrarreferencias abiertas en pestañas
 *   sin que una pise a la otra (antes todo dependía de una sola variable de sesión).
 */

if (!defined('CR_MAX_TOKENS')) {
    define('CR_MAX_TOKENS', 30);       // casos abiertos simultáneos que se recuerdan por usuario
    define('CR_TOKEN_TTL', 43200);     // 12 horas de vigencia de un formulario abierto
    define('CR_MAX_ADJUNTO_MB', 10);   // tamaño máximo TOTAL de los adjuntos (PDF unificado), en MB
}

/** Escapa un valor para mostrarlo en HTML (evita inyección de código en la página). */
function cr_h($valor)
{
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}

/** Ejecuta una consulta preparada y devuelve el statement ya ejecutado. */
function cr_stmt($link, $sql, $types = '', $params = array())
{
    $st = mysqli_prepare($link, $sql);
    if ($types !== '') {
        mysqli_stmt_bind_param($st, $types, ...$params);
    }
    mysqli_stmt_execute($st);
    return $st;
}

/** Devuelve la primera fila (array asociativo) o null. */
function cr_fila($link, $sql, $types = '', $params = array())
{
    $st   = cr_stmt($link, $sql, $types, $params);
    $meta = mysqli_stmt_result_metadata($st);
    $fila = array();
    $refs = array();
    while ($campo = mysqli_fetch_field($meta)) {
        $fila[$campo->name] = null;
        $refs[] = &$fila[$campo->name];
    }
    mysqli_stmt_bind_result($st, ...$refs);
    $ok = mysqli_stmt_fetch($st);
    mysqli_stmt_close($st);
    if (!$ok) {
        return null;
    }
    $copia = array();
    foreach ($fila as $k => $v) {
        $copia[$k] = $v;
    }
    return $copia;
}

/** Ejecuta INSERT/UPDATE/DELETE y devuelve las filas afectadas. */
function cr_ejecutar($link, $sql, $types = '', $params = array())
{
    $st = cr_stmt($link, $sql, $types, $params);
    $n  = mysqli_stmt_affected_rows($st);
    mysqli_stmt_close($st);
    return $n;
}

/** Establecimiento de trabajo del usuario (mismo criterio que admitidos_referencia.php). */
function cr_eess_usuario($link, $idusuario)
{
    $f = cr_fila($link, "SELECT idestablecimiento_salud FROM dato_laboral WHERE idusuario = ? ORDER BY iddato_laboral DESC LIMIT 1", 'i', array((int)$idusuario));
    return $f ? (int)$f['idestablecimiento_salud'] : 0;
}

/** Registra un caso abierto y devuelve su token. */
function cr_token_crear(array $contexto)
{
    if (!isset($_SESSION['contraref_tokens']) || !is_array($_SESSION['contraref_tokens'])) {
        $_SESSION['contraref_tokens'] = array();
    }
    $ahora = time();
    foreach ($_SESSION['contraref_tokens'] as $t => $c) {
        if (!isset($c['creado']) || ($ahora - $c['creado']) > CR_TOKEN_TTL) {
            unset($_SESSION['contraref_tokens'][$t]);
        }
    }
    while (count($_SESSION['contraref_tokens']) >= CR_MAX_TOKENS) {
        array_shift($_SESSION['contraref_tokens']);
    }
    $token = bin2hex(random_bytes(16));
    $contexto['creado'] = $ahora;
    $_SESSION['contraref_tokens'][$token] = $contexto;
    return $token;
}

/** Devuelve el contexto de un token válido o null. */
function cr_token_leer($token)
{
    $token = is_string($token) ? $token : '';
    if (!preg_match('/^[a-f0-9]{32}$/', $token)) {
        return null;
    }
    if (empty($_SESSION['contraref_tokens'][$token])) {
        return null;
    }
    $c = $_SESSION['contraref_tokens'][$token];
    if (!isset($c['creado']) || (time() - $c['creado']) > CR_TOKEN_TTL) {
        unset($_SESSION['contraref_tokens'][$token]);
        return null;
    }
    return $c;
}

function cr_token_cerrar($token)
{
    if (is_string($token) && isset($_SESSION['contraref_tokens'][$token])) {
        unset($_SESSION['contraref_tokens'][$token]);
    }
}

/** Convierte "8M", "2G", "512K" a bytes. */
function cr_ini_bytes($valor)
{
    $valor = trim((string)$valor);
    if ($valor === '') {
        return 0;
    }
    $num  = (float)$valor;
    $unit = strtolower(substr($valor, -1));
    switch ($unit) {
        case 'g': $num *= 1024;
        // no break
        case 'm': $num *= 1024;
        // no break
        case 'k': $num *= 1024;
    }
    return (int)$num;
}

/** Tamaño máximo que el servidor acepta en un envío con adjunto (bytes). */
function cr_limite_envio()
{
    $post   = cr_ini_bytes(ini_get('post_max_size'));
    $upload = cr_ini_bytes(ini_get('upload_max_filesize'));
    $limites = array_filter(array($post, $upload), function ($v) { return $v > 0; });
    return $limites ? min($limites) : 0;
}

/**
 * Tamaño máximo permitido para el PDF de adjuntos (bytes):
 * el menor entre el límite de la aplicación (CR_MAX_ADJUNTO_MB) y el 90 % del límite del servidor
 * (el 10 % restante queda para los demás campos del formulario).
 */
function cr_limite_adjunto()
{
    $app      = CR_MAX_ADJUNTO_MB * 1048576;
    $servidor = cr_limite_envio();
    return $servidor > 0 ? (int)min($app, $servidor * 0.9) : $app;
}

/** El mismo límite en MB, para mostrarlo en mensajes. */
function cr_limite_adjunto_mb()
{
    return round(cr_limite_adjunto() / 1048576, 1);
}

/** Muestra la página de aviso (mismo diseño que tenía guarda_contrareferencia) y termina. */
function cr_aviso($mensaje, $titulo = 'Aviso del Sistema')
{
    $mensaje = htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8');
    $titulo  = htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8');
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Aviso del Sistema</title>
        <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    </head>
    <body class="bg-gradient-light d-flex align-items-center justify-content-center" style="height: 100vh;">
        <div class="container text-center">
            <div class="card shadow mb-4 mx-auto" style="max-width: 560px;">
                <div class="card-body py-4 text-left">
                    <a href="../referencia_safci/admitidos_referencia.php" style="text-decoration: none;">
                        <h6 class="text-info"><- VOLVER A LA BANDEJA DE ADMITIDOS</h6>
                    </a>
                    <hr>
                    <div class="text-center py-3">
                        <h4 class="text-danger font-weight-bold mb-4"><?php echo $titulo; ?></h4>
                        <p class="text-gray-800 mb-0" style="font-size: 1.1rem;"><?php echo nl2br($mensaje); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit();
}
