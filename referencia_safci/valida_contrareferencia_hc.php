<?php
include("../cabf.php");
include("../inc.config.php");
include("inc_contrareferencia.php");
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$idderiva_referencia_hc  = isset($_POST['idderiva_referencia_hc'])  ? (int)$_POST['idderiva_referencia_hc']  : 0;
$idreferencia_hc         = isset($_POST['idreferencia_hc'])         ? (int)$_POST['idreferencia_hc']         : 0;
$idatencion_psafci       = isset($_POST['idatencion_psafci'])       ? (int)$_POST['idatencion_psafci']       : 0;
$idestablecimiento_salud = isset($_POST['idestablecimiento_salud']) ? (int)$_POST['idestablecimiento_salud'] : 0;
$idnombre_integrante     = isset($_POST['idnombre_integrante'])     ? (int)$_POST['idnombre_integrante']     : 0;
$edad                    = isset($_POST['edad'])                    ? (int)$_POST['edad']                    : 0;

// Sin caso válido (acceso directo, recarga, botón "atrás"): volver a la bandeja
if ($idderiva_referencia_hc <= 0 || $idreferencia_hc <= 0) {
    header("Location:admitidos_referencia.php");
    exit();
}

$row_em = cr_fila($link, "SELECT idintegrante_cf, idcarpeta_familiar FROM integrante_cf WHERE idnombre = ? LIMIT 1", 'i', array($idnombre_integrante));

$idintegrante_cf    = $row_em ? $row_em['idintegrante_cf'] : '';
$idcarpeta_familiar = $row_em ? $row_em['idcarpeta_familiar'] : '';

// Variables de sesión heredadas (otras pantallas aún las usan)
$_SESSION['idderiva_referencia_hc_ss']  = $idderiva_referencia_hc;
$_SESSION['idreferencia_hc_ss']         = $idreferencia_hc;
$_SESSION['idatencion_psafci_ss']       = $idatencion_psafci;
$_SESSION['idestablecimiento_salud_ss'] = $idestablecimiento_salud;

$_SESSION['idnombre_integrante_ss']     = $idnombre_integrante;
$_SESSION['edad_ss']                    = $edad;
$_SESSION['idintegrante_cf_ss']         = $idintegrante_cf;
$_SESSION['idcarpeta_familiar_ss']      = $idcarpeta_familiar;

// Token propio de ESTE caso: el formulario y el guardado trabajan con él,
// así otra pestaña u otra pantalla que cambie las variables de sesión no lo afecta.
$token = cr_token_crear(array(
    'idderiva_referencia_hc'  => $idderiva_referencia_hc,
    'idreferencia_hc'         => $idreferencia_hc,
    'idatencion_psafci'       => $idatencion_psafci,
    'idestablecimiento_salud' => $idestablecimiento_salud,
    'idnombre_integrante'     => $idnombre_integrante,
    'edad'                    => $edad,
    'idintegrante_cf'         => $idintegrante_cf,
    'idcarpeta_familiar'      => $idcarpeta_familiar,
));

header("Location:formulario_contrareferencia_hc.php?t=" . $token);
exit();
?>
