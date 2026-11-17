<?php
/**
 * Formulario de paciente nuevo (atencion_persona_ncf.php): al escribir la cédula se revisa si ya la tiene
 * otra persona, ANTES de llenar la atención (respuesta JSON).
 *   GET  ci [+ nombre, paterno, materno, fecha_nac] -> personas con esa cédula; 'parecido' = los datos
 *        escritos coinciden con esa persona; token para "ES ESTA PERSONA" (valida_cedula_hc.php paso 2).
 *   POST accion=confirmar, ci -> "NO ES NINGUNA: ES OTRA PERSONA" (al guardar se crea con esa cédula).
 * Reglas en comun/inc_persona.php (per_ncf_*).
 */
include("../cabf.php");
include("../inc.config.php");
include("../comun/inc_persona.php");
date_default_timezone_set('America/La_Paz');

header('Content-Type: application/json; charset=utf-8');

function ncf_responder(array $r)
{
    echo json_encode($r, JSON_UNESCAPED_UNICODE);
    exit();
}

$entrada = ($_SERVER['REQUEST_METHOD'] === 'POST') ? $_POST : $_GET;
$d = per_ncf_datos($entrada);
if ($d['ci'] <= 0) {
    ncf_responder(array('estado' => 'ok', 'personas' => array()));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion']) && $_POST['accion'] === 'confirmar') {
        per_ncf_confirmar_otra($d['ci']);
        ncf_responder(array('estado' => 'ok', 'confirmado' => true));
    }
    ncf_responder(array('estado' => 'error'));
}

try {
    $personas = per_buscar_ci($link, $d['ci'], $d['complemento'], $d['fecha_nac']);
} catch (Throwable $e) {
    error_log('[ncf_verificar_ci] ci=' . $d['ci'] . ': ' . $e->getMessage());
    ncf_responder(array('estado' => 'error', 'personas' => array()));
}
if (!$personas) {
    ncf_responder(array('estado' => 'ok', 'personas' => array()));
}

$ids = array();
$lista = array();
foreach ($personas as $p) {
    $ids[] = (int)$p['idnombre'];
    $fn = ($p['fecha_nac'] && $p['fecha_nac'] !== '0000-00-00') ? date('d/m/Y', strtotime($p['fecha_nac'])) : '';
    $lista[] = array(
        'idnombre'     => (int)$p['idnombre'],
        'nombre'       => per_nombre_completo($p) !== '' ? per_nombre_completo($p) : '(sin nombre)',
        'ci'           => $p['ci_texto'],
        'fecha_nac'    => $fn,
        'edad'         => $p['edad'],
        'genero'       => (string)$p['genero'],
        'carpeta'      => $p['carpeta'],
        'ultima_fecha' => $p['ultima_fecha'] ? date('d/m/Y', strtotime($p['ultima_fecha'])) : '',
        'ultimo_eess'  => (string)$p['ultimo_eess'],
        'parecido'     => ($d['nombre'] !== '') && per_parece_misma_persona($p, $d),
    );
}
$token = per_token_crear(array('tipo' => 'hc', 'modo' => 'ci', 'ci' => $d['ci'], 'complemento' => $d['complemento'],
                               'fecha_nac' => $d['fecha_nac'], 'ids' => $ids,
                               'nombre' => $d['nombre'], 'paterno' => $d['paterno'], 'materno' => $d['materno']));

ncf_responder(array('estado' => 'ok', 'personas' => $lista, 'token' => $token,
                    'confirmado' => per_ncf_confirmada_otra($d['ci'])));
