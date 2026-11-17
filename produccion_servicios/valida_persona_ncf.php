
<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php include("../comun/inc_persona.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$sql_es = " SELECT iddato_laboral, idestablecimiento_salud FROM dato_laboral WHERE idusuario='$idusuario_ss' ORDER BY iddato_laboral DESC LIMIT 1  ";
$result_es = mysqli_query($link,$sql_es);
$row_es = mysqli_fetch_array($result_es);
$idestablecimiento_salud = $row_es[1];

$_SESSION['idestablecimiento_salud_ss'] = $idestablecimiento_salud;

/* Desde la búsqueda de historias clínicas (?b=token): el formulario de paciente nuevo se abre con la
 * cédula, nombres y fecha que se buscaron. Si la búsqueda fue por cédula y mostró personas, el médico
 * pulsó "NINGUNA ES MI PACIENTE": queda confirmado que es otra persona con esa cédula
 * (comun/inc_persona.php per_ncf_*). Sin ?b= (menú) el formulario se abre vacío, como siempre. */
unset($_SESSION['ncf_precarga'], $_SESSION['ncf_ci_otra']);   // cada formulario nuevo empieza sin confirmaciones anteriores
$ctx = isset($_GET['b']) ? per_token_leer((string)$_GET['b']) : null;
if ($ctx && isset($ctx['tipo']) && $ctx['tipo'] === 'hc') {
    $otra = isset($ctx['modo']) && $ctx['modo'] === 'ci' && !empty($ctx['ids']) && (int)$ctx['ci'] > 0;
    if ($otra) {
        per_ncf_confirmar_otra($ctx['ci']);
    }
    per_ncf_precarga_guardar($ctx, $otra);
}

header("Location:atencion_persona_ncf.php");

?>
