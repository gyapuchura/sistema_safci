<?php
/**
 * Guarda la corrección de datos personales desde las ventanas de corrección (respuesta JSON):
 *   produccion_servicios/persona_encontrada_hc.php  (token tipo 'hc')
 *   carpetas_familiares/persona_encontrada.php      (token tipo 'cf')
 * Solo acepta personas que pertenecen a la búsqueda del token (b).
 * Estados: ok | sin_cambios | error | advertencia (el usuario puede continuar)
 *          | bloqueado (convierte a una persona con carpeta/atenciones en otra: no se guarda).
 */
include("../cabf.php");
include("../inc.config.php");
include("inc_persona.php");
date_default_timezone_set('America/La_Paz');

header('Content-Type: application/json; charset=utf-8');

function responder(array $r)
{
    echo json_encode($r, JSON_UNESCAPED_UNICODE);
    exit();
}

if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    responder(array('estado' => 'error', 'errores' => array('Solicitud no válida.')));
}

$modulos  = array('hc' => 'historias_clinicas', 'cf' => 'carpetas_familiares');
$ctx      = per_token_leer(isset($_POST['b']) ? (string)$_POST['b'] : '');
$idnombre = isset($_POST['idnombre']) ? (int)$_POST['idnombre'] : 0;
if (!per_token_permite($ctx, $idnombre) || !isset($ctx['tipo'], $modulos[$ctx['tipo']])) {
    responder(array('estado' => 'error', 'expirado' => true, 'errores' => array('La búsqueda expiró. Vuelva a buscar.')));
}

$aceptar = isset($_POST['aceptar_advertencia']) && $_POST['aceptar_advertencia'] === 'SI';

try {
    $r = per_guardar_correccion($link, $idnombre, $_POST, $aceptar, $modulos[$ctx['tipo']], (int)$_SESSION['idusuario_ss']);
} catch (Throwable $e) {
    error_log("[corregir_persona] idnombre=$idnombre: " . $e->getMessage());
    $r = array('estado' => 'error', 'errores' => array('No se pudo guardar la corrección. Intente nuevamente.'));
}
responder($r);
