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

$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];

/*********** ENVIO DATOS DEL PÀCIENTE *************/
$nombre        = $link->real_escape_string(mb_strtoupper($_POST['nombre']));
$paterno       = $link->real_escape_string(mb_strtoupper($_POST['paterno']));
$materno       = $link->real_escape_string(mb_strtoupper($_POST['materno']));
$ci            = $_POST['ci'];
$complemento   = $link->real_escape_string($_POST['complemento']);
$idgenero       = $_POST['idgenero'];
$fecha_nac      = $_POST['fecha_nac'];
$idnacionalidad = $_POST['idnacionalidad'];
$idnacion       = $_POST['idnacion'];
$fecha   = $_POST['fecha_registro'];

// =========================================================================
// INICIO BLOQUE DATA GOVERNANCE: RESTRICCIÓN DE MES ACTUAL
// =========================================================================
$mes_enviado  = date("m", strtotime($fecha));
$anio_enviado = date("Y", strtotime($fecha));
$mes_actual   = date("m");
$anio_actual  = date("Y");

if ($mes_enviado != $mes_actual || $anio_enviado != $anio_actual) {
    die("
        <div style='text-align: center; margin-top: 50px; font-family: Arial, sans-serif;'>
            <h3 style='color: #e74a3b;'>ERROR DE SEGURIDAD Y RESTRICCIÓN DE DATOS</h3>
            <p>El sistema SAFCI está configurado para mantener la integridad estadística.</p>
            <p><b>Solo se permite registrar atenciones de TELECONSULTA (NCF) correspondientes al mes y año en curso.</b></p>
            <a href='javascript:history.back()' style='padding: 10px 20px; background: #36b9cc; color: white; text-decoration: none; border-radius: 5px;'>Volver al formulario</a>
        </div>
    ");
}
// =========================================================================
// FIN BLOQUE DATA GOVERNANCE
// =========================================================================

$fecha_nacimiento = $fecha_nac;
$dia=date("d");
$mes=date("m");
$ano=date("Y");    
$dianaz=date("d",strtotime($fecha_nacimiento));
$mesnaz=date("m",strtotime($fecha_nacimiento));
$anonaz=date("Y",strtotime($fecha_nacimiento));         
if (($mesnaz == $mes) && ($dianaz > $dia)) {
$ano=($ano-1); }      
if ($mesnaz > $mes) {
$ano=($ano-1);} 

$edad = ($ano-$anonaz);

$idrepeticion    = $_POST['idrepeticion'];
$idtipo_consulta = $_POST['idtipo_consulta'];
$idtipo_atencion = $_POST['idtipo_atencion'];

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

$sql_e    = " SELECT iddepartamento, idred_salud, idmunicipio FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud_ss' ";
$result_e = mysqli_query($link,$sql_e);
$row_e    = mysqli_fetch_array($result_e);

$iddepartamento = $row_e[0];
$idred_salud    = $row_e[1];
$idmunicipio    = $row_e[2];

$sqlm    = " SELECT MAX(correlativo) FROM atencion_psafci WHERE gestion='$gestion'  ";
$resultm = mysqli_query($link,$sqlm);
$rowm    = mysqli_fetch_array($resultm);

$correlativo = $rowm[0]+1;

$codigo = "PSAFCI-ATENCION-".$correlativo."/".$gestion;

$sql_c = " INSERT INTO nombre (paterno, materno, nombre, ci, exp, fecha_nac, complemento, idnacionalidad, idgenero) ";
$sql_c.= " VALUES ('$paterno','$materno','$nombre','$ci','','$fecha_nac','$complemento','$idnacionalidad','$idgenero') ";
$result_c = mysqli_query($link,$sql_c);   
$idnombre_paciente = mysqli_insert_id($link);

$sql0 = " INSERT INTO atencion_psafci (iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idnombre, edad, idgenero, ";
$sql0.= " idrepeticion, idtipo_consulta, idtipo_atencion, idnacion, codigo, correlativo,  gestion, fecha_registro, hora_registro, idusuario)  ";
$sql0.= " VALUES ('$iddepartamento','$idred_salud','$idmunicipio','$idestablecimiento_salud_ss','$idnombre_paciente','$edad','$idgenero', ";
$sql0.= " '$idrepeticion','$idtipo_consulta','$idtipo_atencion','$idnacion','$codigo','$correlativo','$gestion', '$fecha','$hora','$idusuario_ss')";
$result0 = mysqli_query($link,$sql0);   
$idatencion_psafci = mysqli_insert_id($link); 

$sql_dg = " INSERT INTO atencion_teleconsulta (idatencion_psafci, idcaptacion_ts, idde_ts, iden_ts, idvia_comunicacion, consentimiento_informado, motivo_teleconsulta, historia_enfermedad,  ";
$sql_dg.= " examen_complementario, tratamiento_teleconsulta, idespecialidad_medica, subespecialidad, idtiempo_ts, idestado_paciente, fecha_seguimiento, telefono_paciente, fecha_registro, hora_registro, idusuario) ";
$sql_dg.= " VALUES ('$idatencion_psafci','$idcaptacion_ts','$idde_ts','$iden_ts','$idvia_comunicacion','$consentimiento_informado','$motivo_teleconsulta','$historia_enfermedad', ";
$sql_dg.= " '$examen_complementario','$tratamiento_teleconsulta','$idespecialidad_medica','$subespecialidad','$idtiempo_ts','$idestado_paciente','$fecha_seguimiento','$telefono_paciente','$fecha','$hora','$idusuario_ss') ";
$result_dg = mysqli_query($link,$sql_dg);   


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
$_SESSION['idnombre_paciente_ss'] = $idnombre_paciente;
$_SESSION['edad_ss'] = $edad;

header("Location:mostrar_atencion_psafci_ncf.php");
      
?>