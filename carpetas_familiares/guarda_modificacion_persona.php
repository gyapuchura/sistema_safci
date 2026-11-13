<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php include("../comun/inc_persona.php");?>
<?php
/**
 * Guarda la modificación de datos personales (modificar_persona_reg.php).
 * Usa la misma regla que historias clínicas (comun/inc_persona.php):
 *   - errores de validación      -> se muestran y se vuelve al formulario
 *   - "parece otra persona"      -> confirmación; si continúa se guarda (advertencia_aceptada = SI)
 *   - todo cambio queda en nombre_correccion
 */
date_default_timezone_set('America/La_Paz');

$idusuario_ss        = (int)$_SESSION['idusuario_ss'];
$idnombre_persona_ss = isset($_SESSION['idnombre_persona_ss']) ? (int)$_SESSION['idnombre_persona_ss'] : 0;

if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST' || $idnombre_persona_ss <= 0) {
    header("Location:buscar_persona_cf.php");
    exit();
}

// La persona que se abrió en el formulario debe ser la misma que sigue en sesión (otra pestaña pudo cambiarla)
$idnombre_form = isset($_POST['idnombre_form']) ? (int)$_POST['idnombre_form'] : 0;
if ($idnombre_form !== $idnombre_persona_ss) {
    per_pagina('Aviso del Sistema',
        '<p class="text-center">Se abrió otra persona en otra pestaña. Para evitar modificar a la persona equivocada, no se guardó ningún cambio.</p>'
        . '<p class="text-center"><a href="buscar_persona_cf.php">Volver a buscar -></a></p>');
}

$aceptar = isset($_POST['aceptar_advertencia']) && $_POST['aceptar_advertencia'] === 'SI';
$r = per_guardar_correccion($link, $idnombre_persona_ss, $_POST, $aceptar, 'carpetas_familiares', $idusuario_ss);

if ($r['estado'] === 'ok' || $r['estado'] === 'sin_cambios') {
    header("Location:mensaje_mod_success.php");
    exit();
}

if ($r['estado'] === 'error') {
    $html = '<ul>';
    foreach ($r['errores'] as $e) {
        $html .= '<li>' . per_h($e) . '</li>';
    }
    $html .= '</ul><p class="text-center mb-0"><a href="javascript:history.back()" class="btn btn-secondary">VOLVER AL FORMULARIO</a></p>';
    per_pagina('No se guardaron los cambios', $html);
}

if ($r['estado'] === 'bloqueado') {
    // Protege la carpeta familiar / historia clínica: no se ofrece continuar
    $html = '<p>Los siguientes cambios convierten a esta persona en otra:</p><ul>';
    foreach ($r['bloqueos'] as $b) {
        $html .= '<li>' . per_h($b) . '</li>';
    }
    $html .= '</ul><p>' . per_h($r['motivo']) . '</p>';
    $html .= '<p><b>Si es otra persona, regístrela como nueva.</b> Si es la misma persona, corrija solo los datos mal escritos.</p>';
    $html .= '<p class="text-center mb-0"><a href="javascript:history.back()" class="btn btn-secondary">VOLVER AL FORMULARIO</a></p>';
    per_pagina('No se puede guardar: esto parece otra persona', $html);
}

// Advertencia: confirmar reenviando los mismos datos
$html  = '<p>Revise los siguientes cambios:</p><ul>';
foreach ($r['advertencias'] as $a) {
    $html .= '<li>' . per_h($a) . '</li>';
}
$html .= '</ul><p class="font-weight-bold">¿Desea continuar de todos modos?</p>';
$html .= '<form action="guarda_modificacion_persona.php" method="post" class="text-center">';
foreach (array('idnombre_form', 'ci', 'complemento', 'exp', 'nombre', 'paterno', 'materno', 'fecha_nac', 'idgenero', 'idnacionalidad') as $campo) {
    $valor = isset($_POST[$campo]) ? (string)$_POST[$campo] : '';
    $html .= '<input type="hidden" name="' . $campo . '" value="' . per_h($valor) . '">';
}
$html .= '<input type="hidden" name="aceptar_advertencia" value="SI">';
$html .= '<a href="javascript:history.back()" class="btn btn-secondary mr-2">REVISAR</a>';
$html .= '<button type="submit" class="btn btn-warning">SÍ, CONTINUAR</button>';
$html .= '</form>';
per_pagina('Este cambio parece otra persona', $html, 'text-warning');
