<?php
/**
 * Muestra un PDF adjunto de referencia o contrarreferencia (carpeta files_ref/).
 *
 * - La carpeta files_ref/ no permite acceso directo desde el navegador (files_ref/.htaccess);
 *   los adjuntos solo se ven a través de esta página.
 * - Requiere sesión iniciada (cabf.php): sin sesión, se va al ingreso del sistema.
 * - Solo acepta nombres con el formato que genera el sistema y que estén registrados en esa referencia
 *   (referencia_hc.file_ref o file_contra_ref): no se puede pedir otro archivo del servidor.
 *
 * Uso: ../comun/ver_adjunto.php?f=REF_50_20261117_140408_4538.pdf
 */
include("../cabf.php");
include("../inc.config.php");

function va_no_disponible()
{
    http_response_code(404);
    header('Content-Type: text/html; charset=utf-8');
    echo '<!DOCTYPE html><html lang="es"><head><meta charset="utf-8"><title>Adjunto no disponible</title>'
       . '<link href="../css/sb-admin-2.min.css" rel="stylesheet"></head>'
       . '<body class="bg-gradient-light d-flex align-items-center justify-content-center" style="height:100vh;">'
       . '<div class="card shadow p-4 text-center" style="max-width:480px;"><h5 class="text-danger font-weight-bold">Adjunto no disponible</h5>'
       . '<p class="mb-0 text-gray-800">El archivo solicitado no existe o no corresponde a una referencia registrada.</p></div></body></html>';
    exit();
}

$nombre = isset($_GET['f']) ? (string)$_GET['f'] : '';
if (!preg_match('/^(REF|CONTRAREF)_(\d+)_\d{8}_\d{6}_\d{4}\.pdf$/', $nombre, $m)) {
    va_no_disponible();
}
$columna = ($m[1] === 'REF') ? 'file_ref' : 'file_contra_ref';
$idreferencia_hc = (int)$m[2];

// El archivo debe estar registrado en esa referencia
$st = mysqli_prepare($link, "SELECT idreferencia_hc FROM referencia_hc WHERE idreferencia_hc = ? AND $columna = ?");
mysqli_stmt_bind_param($st, 'is', $idreferencia_hc, $nombre);
mysqli_stmt_execute($st);
mysqli_stmt_store_result($st);
$registrado = mysqli_stmt_num_rows($st) === 1;
mysqli_stmt_close($st);
if (!$registrado) {
    va_no_disponible();
}

$ruta = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'files_ref' . DIRECTORY_SEPARATOR . $nombre;
if (!is_file($ruta)) {
    va_no_disponible();
}

session_write_close();   // no bloquear las demás pestañas del usuario mientras se envía el archivo

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . $nombre . '"');
header('Content-Length: ' . filesize($ruta));
header('X-Content-Type-Options: nosniff');
header('Cache-Control: private, no-store');
readfile($ruta);
exit();
