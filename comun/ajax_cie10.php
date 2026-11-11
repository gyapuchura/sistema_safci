<?php
/**
 * Catálogo CIE-10 para los buscadores de diagnósticos (compartido por todo el sistema).
 * - Requiere sesión iniciada (cabf.php).
 * - Devuelve SOLO id, nombre de la patología y código CIE (catálogo; ningún dato de pacientes).
 * - Formato compacto: [[id, "patologia", "cie"], ...]
 * - La URL lleva ?v=<versión del catálogo> (ver inc_cie10.php); el navegador lo guarda 30 días y
 *   no vuelve a descargarlo mientras la tabla patologia no cambie (si cambia, cambia la versión).
 */
include("../cabf.php");
include("../inc.config.php");

session_write_close(); // no bloquear otras peticiones del mismo usuario mientras se envía

$filas = array();
$res = mysqli_query($link, "SELECT idpatologia, patologia, cie FROM patologia ORDER BY patologia");
while ($res && $r = mysqli_fetch_row($res)) {
    $filas[] = array((int)$r[0], (string)$r[1], (string)$r[2]);
}

// JSON_INVALID_UTF8_SUBSTITUTE existe desde PHP 7.2; en versiones anteriores se omite
$json = json_encode($filas, JSON_UNESCAPED_UNICODE | (defined('JSON_INVALID_UTF8_SUBSTITUTE') ? JSON_INVALID_UTF8_SUBSTITUTE : 0));
$etag = '"' . md5($json) . '"';

// session_start() (en cabf.php) envía cabeceras "no-cache": se quitan para que el navegador sí guarde el catálogo
header_remove('Pragma');
header_remove('Expires');
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: private, max-age=2592000');
header('ETag: ' . $etag);

$etag_cliente = isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim(str_replace(array('W/', '"', '-gzip'), '', $_SERVER['HTTP_IF_NONE_MATCH'])) : '';
if ($etag_cliente !== '' && $etag_cliente === trim($etag, '"')) {
    http_response_code(304);
    exit();
}

// Compresión (si el servidor no la aplica ya)
if (!ini_get('zlib.output_compression') && extension_loaded('zlib')) {
    ob_start('ob_gzhandler');
}
echo $json;
