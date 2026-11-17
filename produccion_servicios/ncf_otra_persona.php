<?php
/**
 * "NO ES ESTA PERSONA: GUARDAR COMO PACIENTE NUEVO" (recuadro per_ncf_aviso_pendiente en
 * mostrar_persona_nhc_mensaje.php / mostrar_persona_hc_mensaje.php / mensaje_persona_sin_hc.php /
 * registrar_persona_hc_dos.php).
 *
 * El guardado de paciente nuevo (guarda_*_ncf.php) encontró la cédula en otra persona y dejó en sesión la
 * atención que el médico ya había llenado. Aquí se confirma que es otra persona y se vuelve a enviar esa
 * misma atención al mismo guardado, que ahora crea la persona nueva con esa cédula
 * (comun/inc_persona.php per_ncf_revisar_ci -> accion 'nuevo', anotado en persona_ci_conflicto).
 */
include("../cabf.php");
include("../inc.config.php");
include("../comun/inc_persona.php");

$p     = per_ncf_pendiente();
$clave = isset($_POST['clave']) ? (string)$_POST['clave'] : '';
if (!$p || $clave === '' || !hash_equals((string)$p['clave'], $clave) || !isset(per_ncf_archivos()[$p['archivo']])) {
    per_pagina('LA ATENCIÓN YA NO ESTÁ DISPONIBLE',
        '<p class="text-center">La atención que había llenado ya se guardó o pasó demasiado tiempo. Vuelva a registrarla.</p>'
        . '<div class="text-center"><a class="btn btn-primary" href="historias_clinicas.php">IR A HISTORIAS CLÍNICAS</a></div>');
}

per_ncf_confirmar_otra($p['ci']);
unset($_SESSION['ncf_pendiente']);   // se envía una sola vez

/** Campos ocultos con lo que se había enviado (incluye listas como idpatologia[]). */
function ncf_campos($nombre, $valor)
{
    if (is_array($valor)) {
        $html = '';
        foreach ($valor as $k => $v) {
            $html .= ncf_campos($nombre . (is_int($k) ? '[]' : '[' . $k . ']'), $v);
        }
        return $html;
    }
    return '<input type="hidden" name="' . per_h($nombre) . '" value="' . per_h($valor) . '">' . "\n";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>SISTEMA MEDI-SAFCI</title>
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-light">
    <div class="container text-center" style="margin-top: 20vh;">
        <h5 class="text-primary">Guardando la atención como paciente nuevo...</h5>
        <form id="reenvio" method="post" action="<?php echo per_h($p['archivo']); ?>">
            <?php foreach ($p['post'] as $k => $v) { echo ncf_campos($k, $v); } ?>
            <noscript><button type="submit" class="btn btn-primary mt-3">CONTINUAR</button></noscript>
        </form>
    </div>
    <script>document.getElementById('reenvio').submit();</script>
</body>
</html>
