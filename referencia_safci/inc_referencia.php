<?php
/**
 * Funciones del flujo de REFERENCIA
 * (formulario_referencia_ps.php -> guarda_referencia.php -> mensaje_referencia_hc.php)
 *
 * - Reutiliza las funciones generales de inc_contrareferencia.php: consultas preparadas (cr_fila, cr_ejecutar),
 *   escape HTML (cr_h) y límite de adjuntos (cr_limite_adjunto, 10 MB).
 * - Token firmado por formulario: el paciente y la atención quedan fijados al ABRIR el formulario.
 *   Así otra pestaña (u otro paciente abierto después) no puede cambiar a quién se le registra la referencia.
 *   El token viaja en el formulario y está firmado: si la sesión se cierra, el médico puede volver a ingresar
 *   con el MISMO usuario y guardar sin perder lo escrito.
 */

include_once(__DIR__ . "/inc_contrareferencia.php");
include_once(dirname(__DIR__) . "/comun/inc_cie10.php");

if (!defined('REF_TOKEN_TTL')) {
    define('REF_TOKEN_TTL', 86400);   // 24 horas de vigencia de un formulario abierto
    define('REF_CLAVE_FIRMA', '6e7f0be0edf2a2bb7db1baafbe542e8366a2bade92706f861f68cbd82694cbc2');
    define('REF_MAX_USADOS', 50);     // tokens ya enviados que se recuerdan en la sesión (evita doble registro)
}

/**
 * Edad en años cumplidos (mismo cálculo que se usaba antes en el formulario y en el guardado).
 * Si la fecha de nacimiento falta o no es válida, devuelve $respaldo.
 */
function ref_edad($fecha_nac, $respaldo = 0)
{
    $t = $fecha_nac ? strtotime((string)$fecha_nac) : false;
    if ($t === false || (int)date("Y", $t) < 1900) {
        return (int)$respaldo;
    }
    $ano    = (int)date("Y");
    $mes    = (int)date("m");
    $dia    = (int)date("d");
    $anonaz = (int)date("Y", $t);
    $mesnaz = (int)date("m", $t);
    $dianaz = (int)date("d", $t);
    if (($mesnaz == $mes && $dianaz > $dia) || $mesnaz > $mes) {
        $ano--;
    }
    return max(0, $ano - $anonaz);
}

/** Datos del paciente que usa la referencia (o null si no existe). */
function ref_paciente($link, $idnombre)
{
    return cr_fila($link,
        "SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre = ?",
        'i', array((int)$idnombre));
}

/** Crea el token firmado del formulario: paciente.atención.usuario.edad.creado.firma */
function ref_token_crear($idnombre, $idatencion, $idusuario, $edad)
{
    $datos = sprintf('%d.%d.%d.%d.%d', (int)$idnombre, (int)$idatencion, (int)$idusuario, (int)$edad, time());
    return $datos . '.' . hash_hmac('sha256', $datos, REF_CLAVE_FIRMA);
}

/** Valida el token (firma y vigencia). Devuelve sus datos o null. */
function ref_token_leer($token)
{
    $token = is_string($token) ? trim($token) : '';
    if (!preg_match('/^(\d+)\.(\d+)\.(\d+)\.(\d+)\.(\d+)\.([a-f0-9]{64})$/', $token, $m)) {
        return null;
    }
    $datos = $m[1] . '.' . $m[2] . '.' . $m[3] . '.' . $m[4] . '.' . $m[5];
    if (!hash_equals(hash_hmac('sha256', $datos, REF_CLAVE_FIRMA), $m[6])) {
        return null;
    }
    $creado = (int)$m[5];
    if ($creado > time() + 300 || (time() - $creado) > REF_TOKEN_TTL) {
        return null;
    }
    return array(
        'idnombre'   => (int)$m[1],
        'idatencion' => (int)$m[2],
        'idusuario'  => (int)$m[3],
        'edad'       => (int)$m[4],
        'creado'     => $creado,
        'firma'      => $m[6],
    );
}

/** Referencia ya registrada con este token (en esta sesión), o 0. */
function ref_token_usado($ctx)
{
    $f = $ctx['firma'];
    return isset($_SESSION['ref_tokens_usados'][$f]) ? (int)$_SESSION['ref_tokens_usados'][$f] : 0;
}

/** Marca el token como enviado (un formulario registra una sola referencia). */
function ref_token_marcar_usado($ctx, $idreferencia_hc)
{
    if (!isset($_SESSION['ref_tokens_usados']) || !is_array($_SESSION['ref_tokens_usados'])) {
        $_SESSION['ref_tokens_usados'] = array();
    }
    $_SESSION['ref_tokens_usados'][$ctx['firma']] = (int)$idreferencia_hc;
    while (count($_SESSION['ref_tokens_usados']) > REF_MAX_USADOS) {
        array_shift($_SESSION['ref_tokens_usados']);
    }
}

/**
 * Página de aviso (mismo diseño que la contrarreferencia) y fin del proceso.
 * $volver_formulario = true muestra el enlace para regresar al formulario y corregir.
 */
function ref_aviso($mensaje, $titulo = 'Aviso del Sistema', $volver_formulario = false)
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
                    <?php if ($volver_formulario) { ?>
                    <a href="javascript:history.back()" style="text-decoration: none;">
                        <h6 class="text-info"><- VOLVER AL FORMULARIO</h6>
                    </a>
                    <?php } else { ?>
                    <a href="../administrar_sistema/inicio.php" style="text-decoration: none;">
                        <h6 class="text-info"><- IR AL INICIO</h6>
                    </a>
                    <?php } ?>
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
