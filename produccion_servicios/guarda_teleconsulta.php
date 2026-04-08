<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");

$hora       = date("H:i");
$gestion    = date("Y");

$idusuario_ss  = $_SESSION['idusuario_ss'];
$idnombre_ss   = $_SESSION['idnombre_ss'];
$perfil_ss     = $_SESSION['perfil_ss'];

$idcarpeta_familiar_ss      = $_SESSION['idcarpeta_familiar_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idintegrante_cf_ss         = $_SESSION['idintegrante_cf_ss'];
$idnombre_integrante_ss     = $_SESSION['idnombre_integrante_ss'];
$edad_ss                    = $_SESSION['edad_ss'];

/*********** ENVIO DATOS DEL PÀCIENTE *************/

$idrepeticion    = $_POST['idrepeticion'];
$idtipo_consulta = $_POST['idtipo_consulta'];
$idtipo_atencion = $_POST['idtipo_atencion'];
$fecha   = $_POST['fecha_registro'];

$idcaptacion_ts = $_POST['idcaptacion_ts'];
$idde_ts        = $_POST['idde_ts'];
$iden_ts        = $_POST['iden_ts'];
$idvia_comunicacion = $_POST['idvia_comunicacion'];
$consentimiento_informado = $_POST['consentimiento_informado'];

$motivo_teleconsulta      = $link->real_escape_string($_POST['motivo_teleconsulta']);
$historia_enfermedad      = $link->real_escape_string($_POST['historia_enfermedad']);
$examen_complementario    = $link->real_escape_string($_POST['examen_complementario']);
$tratamiento_teleconsulta = $link->real_escape_string($_POST['tratamiento_teleconsulta']);

$idespecialidad_medica    = $_POST['idespecialidad_medica'];
$subespecialidad          = $link->real_escape_string($_POST['subespecialidad']);
$idtiempo_ts        = $_POST['idtiempo_ts'];
$idestado_paciente  = $_POST['idestado_paciente'];
$fecha_seguimiento  = $_POST['fecha_seguimiento'];
$telefono_paciente  = $_POST['telefono_paciente'];

/******** SIGNOS VITALES  ********/

$talla              = $_POST['talla'];
$peso               = $_POST['peso'];
$temperatura        = $_POST['temperatura'];
$frec_cardiaca      = $_POST['frec_cardiaca'];
$frec_respiratoria  = $_POST['frec_respiratoria'];
$presion_arterial   = $_POST['presion_arterial'];
$presion_arterial_d = $_POST['presion_arterial_d'];
$saturacion         = $_POST['saturacion'];
$alergia            = $_POST['alergia'];
$descripcion_alergia       = $link->real_escape_string($_POST['descripcion_alergia']);

$sql_e    = " SELECT iddepartamento, idred_salud, idmunicipio FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud_ss' ";
$result_e = mysqli_query($link,$sql_e);
$row_e    = mysqli_fetch_array($result_e);

$sql_int    = " SELECT idgenero FROM nombre WHERE idnombre ='$idnombre_integrante_ss' ";
$result_int = mysqli_query($link,$sql_int);
$row_int    = mysqli_fetch_array($result_int);

$sql_nac    = " SELECT idnacion FROM integrante_cf WHERE idintegrante_cf ='$idintegrante_cf_ss' ";
$result_nac = mysqli_query($link,$sql_nac);
$row_nac    = mysqli_fetch_array($result_nac);

$iddepartamento = $row_e[0];
$idred_salud    = $row_e[1];
$idmunicipio    = $row_e[2];

$idgenero       = $row_int[0];
$idnacion       = $row_nac[0];

$sqlm    = " SELECT MAX(correlativo) FROM atencion_psafci WHERE gestion='$gestion'  ";
$resultm = mysqli_query($link,$sqlm);
$rowm    = mysqli_fetch_array($resultm);

$correlativo = $rowm[0]+1;

$codigo = "PSAFCI-ATENCION-".$correlativo."/".$gestion;

$sql0 = " INSERT INTO atencion_psafci (iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idnombre, edad, idgenero, ";
$sql0.= " idrepeticion, idtipo_consulta, idtipo_atencion, idnacion, codigo, correlativo, gestion, fecha_registro, hora_registro, idusuario)  ";
$sql0.= " VALUES ('$iddepartamento','$idred_salud','$idmunicipio','$idestablecimiento_salud_ss','$idnombre_integrante_ss','$edad_ss','$idgenero', ";
$sql0.= " '$idrepeticion','$idtipo_consulta','$idtipo_atencion','$idnacion','$codigo','$correlativo','$gestion', '$fecha','$hora','$idusuario_ss')";
$result0 = mysqli_query($link,$sql0);   
$idatencion_psafci = mysqli_insert_id($link);

$sql_dg = " INSERT INTO atencion_teleconsulta (idatencion_psafci, idcaptacion_ts, idde_ts, iden_ts, idvia_comunicacion, consentimiento_informado, motivo_teleconsulta, historia_enfermedad,  ";
$sql_dg.= " examen_complementario, tratamiento_teleconsulta, idespecialidad_medica, subespecialidad, idtiempo_ts, idestado_paciente, fecha_seguimiento, telefono_paciente, fecha_registro, hora_registro, idusuario) ";
$sql_dg.= " VALUES ('$idatencion_psafci','$idcaptacion_ts','$idde_ts','$iden_ts','$idvia_comunicacion','$consentimiento_informado','$motivo_teleconsulta','$historia_enfermedad', ";
$sql_dg.= " '$examen_complementario','$tratamiento_teleconsulta','$idespecialidad_medica','$subespecialidad','$idtiempo_ts','$idestado_paciente','$fecha_seguimiento','$telefono_paciente','$fecha','$hora','$idusuario_ss') ";
$result_dg = mysqli_query($link,$sql_dg);   

    $imc_i = $peso*10000/$talla**2;  //** Estatura en centimetros */
    $imc = number_format($imc_i, 6, '.', '');

    $sql1 = " INSERT INTO signo_vital_psafci (idatencion_psafci,idnombre, edad, frec_cardiaca, peso, talla, frec_respiratoria, presion_arterial, presion_arterial_d, temperatura, saturacion, imc, alergia, descripcion_alergia, fecha_registro, hora_registro, idusuario) ";
    $sql1.= " VALUES ('$idatencion_psafci','$idnombre_integrante_ss','$edad_ss','$frec_cardiaca','$peso','$talla','$frec_respiratoria','$presion_arterial','$presion_arterial_d','$temperatura','$saturacion','$imc','$alergia','$descripcion_alergia','$fecha','$hora','$idusuario_ss') ";
    $result1 = mysqli_query($link,$sql1);

    foreach($_POST['idgrupo_vulnerable'] as $idgrupo_vulnerable_i) {

    $sql2 = " INSERT INTO atencion_grupo_vulnerable (idatencion_psafci, idgrupo_vulnerable, fecha_registro, hora_registro, idusuario) ";
    $sql2.= " VALUES ('$idatencion_psafci','$idgrupo_vulnerable_i','$fecha','$hora','$idusuario_ss') ";
    $result2 = mysqli_query($link,$sql2);

    }

    foreach($_POST['idpatologia'] as $idpatologia_i) {

    $sql2 = " INSERT INTO diagnostico_teleconsulta (idatencion_psafci, idpatologia, fecha_registro, hora_registro, idusuario) ";
    $sql2.= " VALUES ('$idatencion_psafci','$idpatologia_i','$fecha','$hora','$idusuario_ss') ";
    $result2 = mysqli_query($link,$sql2);

    }

$_SESSION['idatencion_psafci_ss'] = $idatencion_psafci;

header("Location:mostrar_atencion_psafci.php");
      
?>