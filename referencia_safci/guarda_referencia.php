<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha 	 = date("Y-m-d");
$hora    = date("H:i");
$gestion = date("Y");

$idusuario_ss  = $_SESSION['idusuario_ss'];
$idnombre_ss   = $_SESSION['idnombre_ss'];
$perfil_ss     = $_SESSION['perfil_ss'];

$idatencion_psafci_ss       = $_SESSION['idatencion_psafci_ss'];

$idcarpeta_familiar_ss      = $_SESSION['idcarpeta_familiar_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idintegrante_cf_ss         = $_SESSION['idintegrante_cf_ss'];
$idnombre_integrante_ss     = $_SESSION['idnombre_integrante_ss'];
$edad_ss                    = $_SESSION['edad_ss'];


/*********** ENVIO DATOS PARA TRIAGE DEL PACIENTE *************/

$persona_discapacidad = $_POST['persona_discapacidad'];
$idtipo_discapacidad  = $_POST['idtipo_discapacidad'];
$idnivel_discapacidad = $_POST['idnivel_discapacidad'];
$acompanante          = $_POST['acompanante'];
$celular_acompanante  = $_POST['celular_acompanante'];

$talla                = $_POST['talla'];
$peso                 = $_POST['peso'];
$temperatura          = $_POST['temperatura'];
$frec_cardiaca        = $_POST['frec_cardiaca'];
$frec_respiratoria    = $_POST['frec_respiratoria'];
$presion_arterial     = $_POST['presion_arterial'];
$presion_arterial_d   = $_POST['presion_arterial_d'];
$saturacion           = $_POST['saturacion'];
$glascow              = $_POST['glascow'];
$alergia              = $_POST['alergia'];
$descripcion_alergia  = $_POST['descripcion_alergia'];

$fecha_fum      = $_POST['fecha_fum'];
$gestaciones    = $_POST['gestaciones'];
$partos         = $_POST['partos'];
$abortos        = $_POST['abortos'];
$cesareas       = $_POST['cesareas'];
$fecha_fpp      = $_POST['fecha_fpp'];
$hora_rpm       = $_POST['hora_rpm'];
$frecuencia_fcf       = $_POST['frecuencia_fcf'];
$controles_prenatales = $_POST['controles_prenatales'];
$maduracion_p       = $_POST['maduracion_p'];
$parto              = $_POST['parto'];
$tipo_parto         = $_POST['tipo_parto'];
$fecha_parto        = $_POST['fecha_parto'];
$hora_parto         = $_POST['hora_parto'];
$edad_gestacional   = $_POST['edad_gestacional'];
$liq_amniotico      = $_POST['liq_amniotico'];
$peso_rn            = $_POST['peso_rn'];
$talla_rn           = $_POST['talla_rn'];
$pc_rn              = $_POST['pc_rn'];
$pt_rn              = $_POST['pt_rn'];
$apgar_uno          = $_POST['apgar_uno'];
$apgar_cinco        = $_POST['apgar_cinco'];
$indice_choque      = $_POST['indice_choque'];
$criterios_sofa     = $_POST['criterios_sofa'];
$internado          = $_POST['internado'];
$dias_internacion   = $_POST['dias_internacion'];
$resumen_anamnesis  = $_POST['resumen_anamnesis'];
$rayos_x            = $_POST['rayos_x'];
$laboratorio        = $_POST['laboratorio'];
$ecografia          = $_POST['ecografia'];

$otros                    = $_POST['otros'];
$especificacion_hallazgos = $_POST['especificacion_hallazgos'];
$diagnostico_presuntivo   = $_POST['diagnostico_presuntivo'];
$cie                      = $_POST['cie'];
$tratamiento_ref          = $_POST['tratamiento_ref'];
$observaciones_ref        = $_POST['observaciones_ref'];
$idconsentimiento         = $_POST['idconsentimiento'];
$idestablecimiento_receptor = $_POST['idestablecimiento_receptor'];
$idmotivo_referencia        = $_POST['idmotivo_referencia'];
$idespecialidad_medica      = $_POST['idespecialidad_medica'];

/*********** Guarda el registro de grupo de salud (BEGIN) *************/



/*********** Guarda el registro de grupo de salud (END) *************/
?>