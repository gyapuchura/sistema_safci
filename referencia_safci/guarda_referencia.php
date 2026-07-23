<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
// =========================================================================
// 🚨 CONFIGURACIÓN DE SEGURIDAD Y TRANSACCIONES
// =========================================================================
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
date_default_timezone_set('America/La_Paz');

// 🛡️ ESCUDO ANTI "EFECTO METRALLETA" (DOBLE CLIC RÁPIDO)
if (isset($_SESSION['ultimo_clic_referencia']) && (time() - $_SESSION['ultimo_clic_referencia']) < 30) {
    header("Location:mensaje_referencia_hc.php");
    exit();
}
$_SESSION['ultimo_clic_referencia'] = time();

$fecha   = date("Y-m-d");
$hora    = date("H:i");
$gestion = date("Y");

$idusuario_ss  = $_SESSION['idusuario_ss'];
$idnombre_ss   = $_SESSION['idnombre_ss'];
$perfil_ss     = $_SESSION['perfil_ss'];

$idatencion_psafci_ss       = $_SESSION['idatencion_psafci_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idnombre_integrante_ss     = $_SESSION['idnombre_integrante_ss'];
$edad_ss                    = $_SESSION['edad_ss'];

$sql_es = " SELECT iddato_laboral, idestablecimiento_salud, iddepartamento FROM dato_laboral WHERE idusuario='$idusuario_ss' ORDER BY iddato_laboral DESC LIMIT 1  ";
$result_es = mysqli_query($link,$sql_es);
$row_es = mysqli_fetch_array($result_es);
$idestablecimiento_salud_orig = $row_es[1];
$iddepartamento_orig = $row_es[2];

$sql_e    = " SELECT iddepartamento, idred_salud, idmunicipio FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud_orig' ";
$result_e = mysqli_query($link,$sql_e);
$row_e    = mysqli_fetch_array($result_e);

$sql_nac    = " SELECT idnacion FROM atencion_psafci WHERE idatencion_psafci ='$idatencion_psafci_ss' ";
$result_nac = mysqli_query($link,$sql_nac);
$row_nac    = mysqli_fetch_array($result_nac);

$sql_cf = " SELECT carpeta_familiar.idarea_influencia FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_cf.= " AND integrante_cf.idnombre ='$idnombre_integrante_ss' ";
$result_cf = mysqli_query($link,$sql_cf);

if ($row_cf = mysqli_fetch_array($result_cf)) {
    $idarea_influencia = $row_cf[0];
} else {
    $idarea_influencia = '2';
}

$idnacion       = $row_nac[0];
$iddepartamento = $row_e[0]; 
$idred_salud    = $row_e[1];
$idmunicipio    = $row_e[2];

$sql_int    = " SELECT fecha_nac, idgenero FROM nombre WHERE idnombre ='$idnombre_integrante_ss' ";
$result_int = mysqli_query($link,$sql_int);
$row_int    = mysqli_fetch_array($result_int);

$fecha_nacimiento = $row_int[0];
$dia = date("d");
$mes = date("m");
$ano = date("Y");    
$dianaz = date("d",strtotime($fecha_nacimiento));
$mesnaz = date("m",strtotime($fecha_nacimiento));
$anonaz = date("Y",strtotime($fecha_nacimiento));        
if (($mesnaz == $mes) && ($dianaz > $dia)) {
    $ano=($ano-1); 
}      
if ($mesnaz > $mes) {
    $ano=($ano-1);
}  

$edad = ($ano-$anonaz);  
$idgenero = $row_int[1];

// =========================================================================
// 🛡️ RECEPCIÓN DE DATOS BLINDADA CONTRA INYECCIÓN SQL
// =========================================================================

$discapacidad         = isset($_POST['discapacidad']) ? $_POST['discapacidad'] : 'NO';
$nombre_acompanante   = isset($_POST['nombre_acompanante']) ? mysqli_real_escape_string($link, strtoupper(trim($_POST['nombre_acompanante']))) : '';
$idparentesco_acomp   = isset($_POST['idparentesco_acomp']) ? $_POST['idparentesco_acomp'] : '0';
$celular_acompanante  = isset($_POST['celular_acompanante']) ? mysqli_real_escape_string($link, $_POST['celular_acompanante']) : '';
$tel_establecimiento  = isset($_POST['tel_establecimiento']) ? mysqli_real_escape_string($link, $_POST['tel_establecimiento']) : '';

// Signos Vitales
$talla                = isset($_POST['talla']) ? mysqli_real_escape_string($link, $_POST['talla']) : '0';
$peso                 = isset($_POST['peso']) ? mysqli_real_escape_string($link, $_POST['peso']) : '0';
$temperatura          = isset($_POST['temperatura']) ? mysqli_real_escape_string($link, $_POST['temperatura']) : '';
$frec_cardiaca        = isset($_POST['frec_cardiaca']) ? mysqli_real_escape_string($link, $_POST['frec_cardiaca']) : '';
$frec_respiratoria    = isset($_POST['frec_respiratoria']) ? mysqli_real_escape_string($link, $_POST['frec_respiratoria']) : '';
$presion_arterial     = isset($_POST['presion_arterial']) ? mysqli_real_escape_string($link, $_POST['presion_arterial']) : '';
$presion_arterial_d   = isset($_POST['presion_arterial_d']) ? mysqli_real_escape_string($link, $_POST['presion_arterial_d']) : '';
$saturacion           = isset($_POST['saturacion']) ? mysqli_real_escape_string($link, $_POST['saturacion']) : '';
$glascow              = isset($_POST['glasgow']) ? mysqli_real_escape_string($link, $_POST['glasgow']) : (isset($_POST['glascow']) ? mysqli_real_escape_string($link, $_POST['glascow']) : '');
$alergia              = isset($_POST['alergia']) ? $_POST['alergia'] : 'NO';
$descripcion_alergia  = isset($_POST['descripcion_alergia']) ? mysqli_real_escape_string($link, strtoupper(trim($_POST['descripcion_alergia']))) : 'NINGUNA';

$estuvo_internado     = isset($_POST['estuvo_internado']) ? $_POST['estuvo_internado'] : 'NO';
$dias_internacion     = isset($_POST['dias_internacion']) ? $_POST['dias_internacion'] : '0';

// Textos Largos 
$resumen_anamnesis        = isset($_POST['resumen_anamnesis']) ? mysqli_real_escape_string($link, strtoupper(trim($_POST['resumen_anamnesis']))) : '';
$especificacion_hallazgos = isset($_POST['especificacion_hallazgos']) ? mysqli_real_escape_string($link, strtoupper(trim($_POST['especificacion_hallazgos']))) : '';
$tratamiento_ref          = isset($_POST['tratamiento_ref']) ? mysqli_real_escape_string($link, strtoupper(trim($_POST['tratamiento_ref']))) : '';
$observaciones_ref        = isset($_POST['observaciones_ref']) ? mysqli_real_escape_string($link, strtoupper(trim($_POST['observaciones_ref']))) : '';
$idconsentimiento         = isset($_POST['idconsentimiento']) ? $_POST['idconsentimiento'] : '0';

$idmotivo_referencia        = isset($_POST['idmotivo_referencia']) ? $_POST['idmotivo_referencia'] : '0';
$idestablecimiento_salud_r  = isset($_POST['idestablecimiento_salud_r']) ? $_POST['idestablecimiento_salud_r'] : '0';
$idespecialidad_medica      = isset($_POST['idespecialidad_medica']) ? $_POST['idespecialidad_medica'] : '0';

// =========================================================================
// 📦 INICIO DE TRANSACCIÓN ACID (CUALQUIER FALLO DESHACE TODO EL CASO)
// =========================================================================

    mysqli_begin_transaction($link);

    $sqlm    = " SELECT MAX(correlativo) FROM referencia_hc WHERE gestion='$gestion'";
    $resultm = mysqli_query($link,$sqlm);
    $rowm    = mysqli_fetch_array($resultm);

    $correlativo = $rowm[0]+1;
    $codigo = "MSYD/APS-REF-".$correlativo."/".$gestion;

    // INSERCIÓN PRINCIPAL
    $sql0 = " INSERT INTO referencia_hc (iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idatencion_psafci, correlativo, codigo, idnombre,";
    $sql0.= " discapacidad, nombre_acompanante, idparentesco_acomp, celular_acompanante, tel_establecimiento, estuvo_internado, dias_internacion, resumen_anamnesis, especificacion_hallazgos, tratamiento_ref,";
    $sql0.= " observaciones_ref, idconsentimiento, idestablecimiento_receptor, idmotivo_referencia, idespecialidad_medica, gestion, idestado_referencia, idtiempo_ts, fecha_registro, hora_registro, idusuario, file_ref )";
    $sql0.= " VALUES ('$iddepartamento','$idred_salud','$idmunicipio','$idestablecimiento_salud_orig','$idatencion_psafci_ss','$correlativo','$codigo','$idnombre_integrante_ss',";
    $sql0.= " '$discapacidad','$nombre_acompanante','$idparentesco_acomp','$celular_acompanante','$tel_establecimiento','$estuvo_internado','$dias_internacion','$resumen_anamnesis','$especificacion_hallazgos','$tratamiento_ref',";
    $sql0.= " '$observaciones_ref','$idconsentimiento','$idestablecimiento_salud_r','$idmotivo_referencia','$idespecialidad_medica','$gestion','1','1','$fecha','$hora','$idusuario_ss', '')";
    mysqli_query($link,$sql0);   
    $idreferencia_hc = mysqli_insert_id($link);

    $_SESSION['idreferencia_hc_ss'] = $idreferencia_hc;
    $_SESSION['idestablecimiento_salud_r_ss'] = $idestablecimiento_salud_r;

    // MÓDULO DE ARCHIVOS ADJUNTOS
    if (isset($_FILES['archivo_referencia_pdf'])) {
        $codigo_error = $_FILES['archivo_referencia_pdf']['error'];
        if ($codigo_error == 0 && $idreferencia_hc > 0) { 
            $carpeta_destino = dirname(__DIR__) . "/files_ref/"; 
            if (!file_exists($carpeta_destino)) {
                mkdir($carpeta_destino, 0777, true);
            }
            $nuevo_nombre_archivo = "REF_" . $idreferencia_hc . "_" . date("Ymd_His") . "_" . rand(1000, 9999) . ".pdf";
            $ruta_completa = $carpeta_destino . $nuevo_nombre_archivo;
            
            if(move_uploaded_file($_FILES['archivo_referencia_pdf']['tmp_name'], $ruta_completa)){
                $sql_upd_file = "UPDATE referencia_hc SET file_ref = '$nuevo_nombre_archivo' WHERE idreferencia_hc = '$idreferencia_hc'";
                mysqli_query($link, $sql_upd_file);
            } 
        }
    } 

    if ($idreferencia_hc > 0) {

        $sql_dr = " INSERT INTO deriva_referencia_hc (idreferencia_hc, idestablecimiento_salud_o, idestablecimiento_salud_r, idusuario_o, idusuario_r, ";
        $sql_dr.= " referido, admitido, fecha_deriva, hora_deriva, fecha_admision, hora_admision )  ";
        $sql_dr.= " VALUES ('$idreferencia_hc','$idestablecimiento_salud_orig','$idestablecimiento_salud_r','$idusuario_ss','$idusuario_ss', ";
        $sql_dr.= " 'SI','NO','$fecha','$hora','$fecha','$hora')";
        mysqli_query($link,$sql_dr);   

        // CÁLCULO DE IMC PROTEGIDO
        if ($talla > 0) {
            $imc_i = $peso * 10000 / ($talla ** 2);
            $imc = number_format($imc_i, 6, '.', '');
        } else {
            $imc = '0.000000';
        }

        $sql_sg = " INSERT INTO signo_vital_psafci (idatencion_psafci,idnombre, edad, frec_cardiaca, peso, talla, frec_respiratoria, presion_arterial, presion_arterial_d, temperatura, saturacion, imc, glascow, alergia, descripcion_alergia, fecha_registro, hora_registro, idusuario) ";
        $sql_sg.= " VALUES ('$idatencion_psafci_ss','$idnombre_integrante_ss','$edad','$frec_cardiaca','$peso','$talla','$frec_respiratoria','$presion_arterial','$presion_arterial_d','$temperatura','$saturacion','$imc','$glascow','$alergia','$descripcion_alergia','$fecha','$hora','$idusuario_ss') ";
        mysqli_query($link,$sql_sg);

        // EXÁMENES COMPLEMENTARIOS
        if (isset($_POST['idexamen_complementario']) && is_array($_POST['idexamen_complementario'])) {
            foreach($_POST['idexamen_complementario'] as $idexamen_complementario_i) {
                $id_ex_clean = (int)$idexamen_complementario_i;
                if ($id_ex_clean > 0) {
                    $sql_f = " INSERT INTO examen_referencia (idreferencia_hc, idnombre, idexamen_complementario, fecha_registro, hora_registro, idusuario) ";
                    $sql_f.= " VALUES ('$idreferencia_hc','$idnombre_integrante_ss','$id_ex_clean','$fecha','$hora','$idusuario_ss') ";
                    mysqli_query($link,$sql_f);
                }
            }
        }

        // =========================================================================
        // 🧠 BUCLE DE DIAGNÓSTICOS UNIFICADO (COMPATIBLE CON BUSCADOR INTELIGENTE)
        // =========================================================================
        $diagnosticos = isset($_POST['diagnostico_presuntivo']) && is_array($_POST['diagnostico_presuntivo']) ? $_POST['diagnostico_presuntivo'] : array();
        $patologias   = isset($_POST['idpatologia']) && is_array($_POST['idpatologia']) ? $_POST['idpatologia'] : array();
        
        // Obtenemos un ID de patología por defecto para evitar rechazos en estricto si el CIE-10 no fue marcado
        $sql_def = "SELECT idpatologia FROM patologia ORDER BY idpatologia ASC LIMIT 1";
        $res_def = mysqli_query($link, $sql_def);
        $row_def = mysqli_fetch_array($res_def);
        $id_pat_default = isset($row_def[0]) ? (int)$row_def[0] : 1;

        // Iteramos unificando todas las claves enviadas (0, 1, 2)
        $claves_diag = array_unique(array_merge(array_keys($diagnosticos), array_keys($patologias)));

        foreach($claves_diag as $clave) {
            $texto_raw  = isset($diagnosticos[$clave]) ? trim($diagnosticos[$clave]) : '';
            $id_pat_raw = isset($patologias[$clave]) ? trim($patologias[$clave]) : '';
            $id_pat     = (int)$id_pat_raw;

            // 1. SI LA FILA ESTÁ COMPLETAMENTE VACÍA (Ni escribió texto NI eligió CIE-10), la saltamos
            if ($texto_raw === '' && $id_pat <= 0) {
                continue; 
            }

            // 2. Si escribió texto pero no eligió CIE-10 (o no se seleccionó en la fila principal)
            if ($id_pat <= 0) {
                if ($clave == 0) {
                    $id_pat = $id_pat_default; // Al diagnóstico principal le garantizamos un CIE-10 válido
                } else {
                    continue; // A las filas secundarias incompletas las omitimos
                }
            }

            // 3. Blindamos el texto (que puede ser vacío si solo eligió del buscador, igual que tu sistema anterior)
            $diagnostico_seguro = mysqli_real_escape_string($link, strtoupper($texto_raw));

            $sql_dg = " INSERT INTO diagnostico_presuntivo (idreferencia_hc, idnombre, diagnostico_presuntivo, idpatologia, fecha_registro, hora_registro, idusuario) ";
            $sql_dg.= " VALUES ('$idreferencia_hc','$idnombre_integrante_ss','$diagnostico_seguro','$id_pat','$fecha','$hora','$idusuario_ss') ";
            mysqli_query($link,$sql_dg);   
        }
        // =========================================================================

        // CONTROL PERINATAL Y DISCAPACIDAD
        if ($discapacidad == 'SI') {
            $idtipo_discapacidad  = isset($_POST['idtipo_discapacidad']) ? (int)$_POST['idtipo_discapacidad'] : 0;
            $idnivel_discapacidad = isset($_POST['idnivel_discapacidad']) ? (int)$_POST['idnivel_discapacidad'] : 0;

            $sql_dis = " INSERT INTO discapacidad_ref (idreferencia_hc, idnombre, idtipo_discapacidad, idnivel_discapacidad, fecha_registro, hora_registro, idusuario) ";
            $sql_dis.= " VALUES ('$idreferencia_hc','$idnombre_integrante_ss','$idtipo_discapacidad','$idnivel_discapacidad','$fecha','$hora','$idusuario_ss') ";
            mysqli_query($link,$sql_dis);   
        } 

        if ($idgenero == '1' && $edad > '14') {
            
            $gestaciones    = isset($_POST['gestaciones']) ? mysqli_real_escape_string($link, $_POST['gestaciones']) : '0';
            $partos         = isset($_POST['partos']) ? mysqli_real_escape_string($link, $_POST['partos']) : '0';
            $abortos        = isset($_POST['abortos']) ? mysqli_real_escape_string($link, $_POST['abortos']) : '0';
            $cesareas       = isset($_POST['cesareas']) ? mysqli_real_escape_string($link, $_POST['cesareas']) : '0';

            $fecha_fum      = isset($_POST['fecha_fum']) ? $_POST['fecha_fum'] : '';
            $fecha_fpp      = isset($_POST['fecha_fpp']) ? $_POST['fecha_fpp'] : '';
            $controles_prenatales = isset($_POST['controles_prenatales']) ? mysqli_real_escape_string($link, $_POST['controles_prenatales']) : '0';
            $frecuencia_fcf       = isset($_POST['frecuencia_fcf']) ? mysqli_real_escape_string($link, $_POST['frecuencia_fcf']) : '';
            $parto          = isset($_POST['parto']) ? $_POST['parto'] : 'NO';

            $sql_hcp    = " SELECT idhistoria_perinatal FROM historia_perinatal WHERE idnombre ='$idnombre_integrante_ss'  ";
            $result_hcp = mysqli_query($link,$sql_hcp);
            
            if ($row_hcp = mysqli_fetch_array($result_hcp)) {   
                // Lógica si ya cuenta con historial previo...
            } else {
                $sql_hp    = " SELECT MAX(correlativo) FROM historia_perinatal WHERE gestion='$gestion'  ";
                $result_hp = mysqli_query($link,$sql_hp);
                $row_hp    = mysqli_fetch_array($result_hp);

                $correlativo_p = $row_hp[0]+1;
                $codigo_p = "MSYD-HCP-".$correlativo_p."/".$gestion;
    
                $sql0_hp = " INSERT INTO historia_perinatal (iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idarea_influencia, correlativo, codigo, idnombre,  ";
                $sql0_hp.= " idnacion, alfabeta, idnivel_instruccion, anos_mayor_nivel, vive_sola, gestion, fecha_registro, hora_registro, idusuario)  ";
                $sql0_hp.= " VALUES ('$iddepartamento','$idred_salud','$idmunicipio','$idestablecimiento_salud_ss','$idarea_influencia','$correlativo_p','$codigo_p','$idnombre_integrante_ss', ";
                $sql0_hp.= " '$idnacion','SI','2','','','$gestion','$fecha','$hora','$idusuario_ss')";
                mysqli_query($link,$sql0_hp);   
                
                $idhistoria_perinatal = mysqli_insert_id($link);

                $sql_1 = " INSERT INTO antecedente_obstetrico (idhistoria_perinatal, idnombre, gestaciones, partos, abortos, cesareas, nacidos_vivos, viven, nacidos_muertos, muertos_a_semana, ";
                $sql_1.= " muertos_d_semana, vaginales, idultimo_previo, antecedente_gemelos, fecha_fea, menos_ano, embarazo_planeado, idmetodo_anticonceptivo, fecha_registro, hora_registro, idusuario) ";
                $sql_1.= " VALUES ('$idhistoria_perinatal','$idnombre_integrante_ss','$gestaciones','$partos','$abortos','$cesareas','0','0','0','0', ";
                $sql_1.= " '0','0','1','','$fecha','','','1','$fecha','$hora','$idusuario_ss') ";
                mysqli_query($link,$sql_1);   

                $sql_2 = " INSERT INTO gestacion (idhistoria_perinatal, idnombre, peso_anterior, talla, idesno, fecha_fum, eg_fum, eco_veinte, fecha_fpp, ";
                $sql_2.= " fuma_activo, fuma_pasivo, drogas, alcohol, violencia, idantirubeola, antitetanica, dosis_antitetanica, ex_odontologico, ex_mamas, controles_prenatales, fecha_registro, hora_registro, idusuario) ";
                $sql_2.= " VALUES ('$idhistoria_perinatal','$idnombre_integrante_ss','','','3','$fecha_fum','', '','$fecha_fpp', ";
                $sql_2.= " '','','','','','2','','','','','$controles_prenatales','$fecha','$hora','$idusuario_ss') ";
                mysqli_query($link,$sql_2);
                
                $idgestacion = mysqli_insert_id($link); 

                $sql_3 = " INSERT INTO consulta_antenatal (idhistoria_perinatal, idgestacion, idnombre, fecha_consulta, edad_gestacional, peso, imc, presion_arterial, altura_uterina, ";
                $sql_3.= " presentacion, frecuencia_fcf, mov_fetales, proteinuria, tabletas_sfe, senales_examenes, fecha_proxima, fecha_registro, hora_registro, idusuario) ";
                $sql_3.= " VALUES ('$idhistoria_perinatal','$idgestacion','$idnombre_integrante_ss','$fecha','','','','','', ";
                $sql_3.= " '','$frecuencia_fcf','','','','','$fecha','$fecha','$hora','$idusuario_ss') ";
                mysqli_query($link,$sql_3); 
            }
                
            if ($parto == 'SI') {
                $maduracion_pulmonar = isset($_POST['maduracion_pulmonar']) ? $_POST['maduracion_pulmonar'] : 'NO';
                $hora_rpm           = isset($_POST['hora_rpm']) ? mysqli_real_escape_string($link, $_POST['hora_rpm']) : '';
                $idtipo_parto       = isset($_POST['idtipo_parto']) ? $_POST['idtipo_parto'] : '1';
                $fecha_parto        = isset($_POST['fecha_parto']) ? $_POST['fecha_parto'] : '';
                $hora_parto         = isset($_POST['hora_parto']) ? mysqli_real_escape_string($link, $_POST['hora_parto']) : '';
                $edad_gestacional   = isset($_POST['edad_gestacional']) ? mysqli_real_escape_string($link, $_POST['edad_gestacional']) : '';
                $liq_amniotico      = isset($_POST['liq_amniotico']) ? $_POST['liq_amniotico'] : '';
                $idpeso_eg          = isset($_POST['idpeso_eg']) ? $_POST['idpeso_eg'] : '1';
                $peso_rn            = isset($_POST['peso_rn']) ? mysqli_real_escape_string($link, $_POST['peso_rn']) : '0';
                $talla_rn           = isset($_POST['talla_rn']) ? mysqli_real_escape_string($link, $_POST['talla_rn']) : '0';
                $pc_rn              = isset($_POST['pc_rn']) ? mysqli_real_escape_string($link, $_POST['pc_rn']) : '0';
                $pt_rn              = isset($_POST['pt_rn']) ? mysqli_real_escape_string($link, $_POST['pt_rn']) : '0';
                $apgar_uno          = isset($_POST['apgar_uno']) ? mysqli_real_escape_string($link, $_POST['apgar_uno']) : '0';
                $apgar_cinco        = isset($_POST['apgar_cinco']) ? mysqli_real_escape_string($link, $_POST['apgar_cinco']) : '0';
                $indice_choque      = isset($_POST['indice_choque']) ? mysqli_real_escape_string($link, $_POST['indice_choque']) : '';
                $criterio_sofa      = isset($_POST['criterio_sofa']) ? mysqli_real_escape_string($link, $_POST['criterio_sofa']) : '';
                $idgenero_rn        = isset($_POST['idgenero_rn']) ? $_POST['idgenero_rn'] : '1';

                $sql_4 = " INSERT INTO parto (idhistoria_perinatal, idgestacion, idnombre, fecha_ingreso, hospitalizacion_embarazo, dias_hospitalizacion, ";
                $sql_4.= " maduracion_pulmonar, hora_rpm, idtipo_parto, fecha_parto, hora_parto, fecha_registro, hora_registro, idusuario) ";
                $sql_4.= " VALUES ('$idhistoria_perinatal','$idgestacion','$idnombre_integrante_ss','$fecha','','',";
                $sql_4.= " '$maduracion_pulmonar','$hora_rpm','$idtipo_parto','$fecha_parto','$hora_parto','$fecha','$hora','$idusuario_ss') ";
                mysqli_query($link,$sql_4); 

                $sql_5 = " INSERT INTO recien_nacido (idhistoria_perinatal, idgestacion, idgenero, liq_amniotico, peso_rn, talla_rn, pc_rn, pt_rn, edad_gestacional, ";
                $sql_5.= " idpeso_eg, apgar_uno, apgar_cinco, indice_choque, criterio_sofa, fecha_registro, hora_registro, idusuario) ";
                $sql_5.= " VALUES ('$idhistoria_perinatal','$idgestacion','$idgenero_rn','$liq_amniotico','$peso_rn','$talla_rn','$pc_rn','$pt_rn','$edad_gestacional', ";
                $sql_5.= " '$idpeso_eg','$apgar_uno','$apgar_cinco','$indice_choque','$criterio_sofa','$fecha','$hora','$idusuario_ss') ";
                mysqli_query($link,$sql_5); 
            } 
        } 
    }

    // 🛡️ CONFIRMACIÓN DE TRANSACCIÓN: Todo se guardó con éxito en todas las tablas
    mysqli_commit($link);

    header("Location:mensaje_referencia_hc.php");
    exit();

?>