<?php
include("../cabf.php");
include("../inc.config.php");
include("inc_teleeducacion.php");

// =========================================================================
// ELIMINA UNA SESIÓN DE TELEEDUCACIÓN
//   Solo quien la registró y solo dentro del mes de registro (te_editable).
//   Se borran cabecera, asistentes y recursos juntos.
// =========================================================================
date_default_timezone_set('America/La_Paz');
$idusuario_ss = (int)$_SESSION['idusuario_ss'];

function te_volver($params) {
    header("Location: teleeducacion.php?" . http_build_query($params));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { te_volver([]); }

$id = isset($_POST['idteleeducacion']) ? (int)$_POST['idteleeducacion'] : 0;
$t  = $id > 0 ? te_leer($link, $id) : null;
if (!$t) { te_volver(['error' => 'no_existe']); }
if (!te_editable($t, $idusuario_ss)) { te_volver(['error' => 'fuera_de_plazo']); }

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    mysqli_begin_transaction($link);
    mysqli_query($link, "DELETE FROM teleeducacion_asistente WHERE idteleeducacion = '$id'");
    mysqli_query($link, "DELETE FROM teleeducacion_recurso WHERE idteleeducacion = '$id'");
    mysqli_query($link, "DELETE FROM teleeducacion WHERE idteleeducacion = '$id' AND idusuario = '$idusuario_ss'");
    mysqli_commit($link);
} catch (mysqli_sql_exception $e) {
    mysqli_rollback($link);
    error_log('elimina_teleeducacion: ' . $e->getMessage());
    te_volver(['error' => 'eliminar']);
}

te_volver(['ok' => 'eliminado', 'codigo' => $t['codigo']]);
