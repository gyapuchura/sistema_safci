<?php
/**
 * Estado de la sesión del usuario (lo usa comun/sesion_aviso.js). Responde siempre JSON, nunca redirige.
 *
 *   sesion_ping.php            -> renueva la sesión (el médico está trabajando en el formulario)
 *   sesion_ping.php?consulta=1 -> solo consulta, sin renovar (para saber si trabaja en otra pestaña)
 *
 * Respuesta: { activa, usuario, ultima_actividad, ahora, limite }
 *   ultima_actividad: hora (servidor) de la última petición de CUALQUIER pestaña de esta sesión;
 *                     se toma de la fecha del archivo de sesión, antes de abrirla. null si no se puede saber.
 *   limite:           tiempo de vida de la sesión configurado en el servidor (session.gc_maxlifetime), en segundos.
 */

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('X-Content-Type-Options: nosniff');

$solo_consulta = isset($_GET['consulta']);
$nombre_cookie = session_name();
$limite        = (int)ini_get('session.gc_maxlifetime');

function sp_responder($datos)
{
    echo json_encode($datos);
    exit();
}

// Sin cookie de sesión: no hay sesión que revisar (no se crea una nueva)
$sid = isset($_COOKIE[$nombre_cookie]) ? preg_replace('/[^A-Za-z0-9,-]/', '', (string)$_COOKIE[$nombre_cookie]) : '';
if ($sid === '') {
    sp_responder(array('activa' => false, 'usuario' => 0, 'ultima_actividad' => null, 'ahora' => time(), 'limite' => $limite));
}

// Última actividad de la sesión (solo con el manejador de archivos, el de XAMPP por defecto)
$ultima = null;
if (ini_get('session.save_handler') === 'files') {
    $ruta = (string)session_save_path();
    if (strpos($ruta, ';') !== false) {
        $ruta = substr(strrchr($ruta, ';'), 1);   // formato "N;/ruta" o "N;MODO;/ruta"
    }
    if ($ruta === '') {
        $ruta = sys_get_temp_dir();
    }
    $archivo = rtrim($ruta, '/\\') . DIRECTORY_SEPARATOR . 'sess_' . $sid;
    clearstatcache(true, $archivo);
    if (is_file($archivo)) {
        $ultima = filemtime($archivo);
    }
}

if ($solo_consulta) {
    session_start(array('read_and_close' => true));   // no modifica ni renueva la sesión
} else {
    session_start();
}

$activa = !empty($_SESSION['idusuario_ss']) && !empty($_SESSION['idnombre_ss']) && !empty($_SESSION['perfil_ss']);
$usuario = $activa ? (int)$_SESSION['idusuario_ss'] : 0;

if (!$solo_consulta) {
    if ($activa) {
        $_SESSION['sesion_renovada'] = time();   // fuerza la escritura: la sesión queda renovada
    }
    session_write_close();
}

sp_responder(array(
    'activa'           => $activa,
    'usuario'          => $usuario,
    'ultima_actividad' => $ultima,
    'ahora'            => time(),
    'limite'           => $limite,
));
