<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php include("../comun/inc_persona.php");?>
<?php
/**
 * Búsqueda de historia clínica por cédula (dos pasos):
 *   1. POST ci [+ complemento, fecha_nac]  -> busca TODAS las personas con ese CI
 *      o nombre + paterno/materno (o fecha_nac si no tiene apellidos) -> búsqueda por nombres (personas sin CI);
 *      si la cédula no existe y escribieron nombres, se busca por nombres (comun/inc_persona.php per_buscar_desde_post)
 *        0 -> mensaje_persona_sin_hc.php
 *        1 o más -> persona_encontrada_hc.php (tarjetas para confirmar/corregir)
 *   2. POST b (token de la búsqueda) + idnombre (persona elegida) -> inicia la atención
 *        (misma lógica de antes: carpeta familiar / atención previa / registro).
 */
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

/* ---------------- Paso 1: búsqueda ---------------- */
if (!isset($_POST['b'])) {

    // Por CI o, con modo=nombre, por nombres y apellidos (personas sin CI)
    $r = per_buscar_desde_post($link, $_POST, 'hc');
    if ($r['error'] !== '') {
        header("Location:historias_clinicas.php?e=" . $r['error']);
        exit();
    }

    if (!$r['personas']) {
        // Nadie encontrado: se ofrece iniciar la atención como paciente nuevo
        $ctx = $r['ctx'];
        $ci_msg = $ctx['modo'] === 'nombre' ? (int)$ctx['ci_no_encontrado'] : (int)$ctx['ci'];
        $token  = per_token_crear($ctx);   // para que "volver" muestre lo que se había escrito
        header("Location:mensaje_persona_sin_hc.php?" . ($ctx['modo'] === 'nombre' ? 'nom=1&' : '') . 'ci=' . $ci_msg . '&b=' . $token);
        exit();
    }

    $token = per_token_crear($r['ctx']);
    header("Location:persona_encontrada_hc.php?b=" . $token);
    exit();
}

/* ---------------- Paso 2: iniciar atención con la persona elegida ---------------- */
$ctx      = per_token_leer((string)$_POST['b']);
$idnombre = isset($_POST['idnombre']) ? (int)$_POST['idnombre'] : 0;
if (!per_token_permite($ctx, $idnombre)) {
    header("Location:historias_clinicas.php?e=exp");
    exit();
}

$row_es = per_fila($link, "SELECT iddato_laboral, idestablecimiento_salud, iddepartamento FROM dato_laboral WHERE idusuario = ? ORDER BY iddato_laboral DESC LIMIT 1", 'i', array((int)$idusuario_ss));
$idestablecimiento_salud_orig = $row_es ? $row_es['idestablecimiento_salud'] : null;

$row_e = per_fila($link, "SELECT iddepartamento, idred_salud, idmunicipio FROM establecimiento_salud WHERE idestablecimiento_salud = ?", 'i', array((int)$idestablecimiento_salud_orig));
$iddepartamento_orig = $row_e ? $row_e['iddepartamento'] : null;
$idred_salud_orig    = $row_e ? $row_e['idred_salud'] : null;
$idmunicipio_orig    = $row_e ? $row_e['idmunicipio'] : null;

$row_n = per_fila($link, "SELECT idnombre, ci, nombre, paterno, materno, fecha_nac FROM nombre WHERE idnombre = ?", 'i', array($idnombre));
if (!$row_n) {
    header("Location:mensaje_persona_sin_hc.php");
    exit();
}
$edad = per_edad($row_n['fecha_nac']);

$row_int = per_fila($link, "SELECT idintegrante_cf, idcarpeta_familiar FROM integrante_cf WHERE idnombre = ? ORDER BY idintegrante_cf LIMIT 1", 'i', array($idnombre));
if ($row_int) {

    $row_cf = per_fila($link, "SELECT idcarpeta_familiar, iddepartamento, idestablecimiento_salud FROM carpeta_familiar WHERE idcarpeta_familiar = ?", 'i', array((int)$row_int['idcarpeta_familiar']));

    $_SESSION['edad_ss']                    = $edad;
    $_SESSION['idintegrante_cf_ss']         = $row_int['idintegrante_cf'];
    $_SESSION['idnombre_integrante_ss']     = $idnombre;
    $_SESSION['idcarpeta_familiar_ss']      = $row_cf ? $row_cf['idcarpeta_familiar'] : null;
    $_SESSION['iddepartamento_ss']          = $row_cf ? $row_cf['iddepartamento'] : null;
    $_SESSION['idestablecimiento_salud_ss'] = $row_cf ? $row_cf['idestablecimiento_salud'] : null;

    header("Location:mostrar_persona_hc.php");
    exit();
}

/************* VERIFICAMOS QUE LA PERSONA NO TENGA ATENCION PREVIA ***********/
$row_ps = per_fila($link, "SELECT idatencion_psafci, iddepartamento, idestablecimiento_salud, idnacion FROM atencion_psafci WHERE idnombre = ? LIMIT 1", 'i', array($idnombre));
if ($row_ps) {

    $_SESSION['edad_ss']                    = $edad;
    $_SESSION['idnombre_paciente_ss']       = $idnombre;
    $_SESSION['iddepartamento_ss']          = $row_ps['iddepartamento'];
    $_SESSION['idestablecimiento_salud_ss'] = $row_ps['idestablecimiento_salud'];
    $_SESSION['idnacion_ss']                = $row_ps['idnacion'];

    header("Location:mostrar_persona_nhc.php");
    exit();
}

$_SESSION['edad_ss']                    = $edad;
$_SESSION['idnacion_ss']                = '33';
$_SESSION['idnombre_paciente_ss']       = $idnombre;
$_SESSION['iddepartamento_ss']          = $iddepartamento_orig;
$_SESSION['idestablecimiento_salud_ss'] = $idestablecimiento_salud_orig;

header("Location:registrar_persona_hc.php");
exit();
