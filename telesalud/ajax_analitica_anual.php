<?php
include("../cabf.php");
include("../inc.config.php");

// Filtros compartidos (se leen de la sesión: los mismos que el usuario ve en pantalla) y REGLAS DE PRODUCCIÓN únicas
include("inc_telemedicina.php");

// Si el JS envía un año específico, lo usamos; si no, el año en curso
$gestion = isset($_GET['gestion']) ? (int)$_GET['gestion'] : (int)date("Y");
if ($gestion < 2000 || $gestion > 2100) { $gestion = (int)date("Y"); }

// Producción del año agrupada por mes, con las mismas reglas que la Central y las pestañas:
//   Generadas y Respuestas = solo efectivizadas · Telemetrías = exámenes con dispositivo válido
$prod = tm_produccion($link, $gestion . '-01-01', $gestion . '-12-31', 'mes');

$serie = function ($clave) use ($prod, $gestion) {
    $datos = array_fill(0, 12, 0);
    foreach ($prod[$clave]['serie'] as $mes => $total) {
        if (substr($mes, 0, 4) == $gestion) { $datos[(int)substr($mes, 5, 2) - 1] = $total; }
    }
    return $datos;
};

$respuesta = [
    'meses' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    'series' => [
        'tc'   => $serie('teleconsultas'),
        'tm'   => $serie('telemetrias'),
        'ref'  => $serie('generadas'),
        'cref' => $serie('respuestas'),
    ],
    'totales' => [
        'tc'   => $prod['teleconsultas']['total'],
        'tm'   => $prod['telemetrias']['total'],
        'ref'  => $prod['generadas']['total'],
        'cref' => $prod['respuestas']['total'],
    ],
    'gestion' => $gestion
];

header('Content-Type: application/json');
echo json_encode($respuesta);
exit;
