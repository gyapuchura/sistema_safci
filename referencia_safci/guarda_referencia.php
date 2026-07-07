<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

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

$sql_e    = " SELECT iddepartamento, idred_salud, idmunicipio FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud_ss' ";
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
    $ano=($ano-1); }      
    if ($mesnaz > $mes) {
    $ano=($ano-1);}  

    $edad = ($ano-$anonaz);  
    $idgenero = $row_int[1];

/*********** ENVIO DATOS PARA TRIAGE DEL PACIENTE *************/

$discapacidad = $_POST['discapacidad'];

$nombre_acompanante   = $_POST['nombre_acompanante'];
$idparentesco_acomp   = $_POST['idparentesco_acomp'];
$celular_acompanante  = $_POST['celular_acompanante'];
$tel_establecimiento  = $_POST['tel_establecimiento'];

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

$datos_perinatales  = $_POST['datos_perinatales'];

$estuvo_internado     = $_POST['estuvo_internado'];
$dias_internacion     = $_POST['dias_internacion'];
$resumen_anamnesis    = $_POST['resumen_anamnesis'];
$especificacion_hallazgos = $_POST['especificacion_hallazgos'];
$tratamiento_ref          = $_POST['tratamiento_ref'];
$observaciones_ref        = $_POST['observaciones_ref'];
$idconsentimiento         = $_POST['idconsentimiento'];

$idmotivo_referencia        = $_POST['idmotivo_referencia'];
$idestablecimiento_salud_r  = $_POST['idestablecimiento_salud_r'];
$idespecialidad_medica      = $_POST['idespecialidad_medica'];

$sqlm    = " SELECT MAX(correlativo) FROM referencia_hc WHERE gestion='$gestion'";
$resultm = mysqli_query($link,$sqlm);
$rowm    = mysqli_fetch_array($resultm);

$correlativo = $rowm[0]+1;

$codigo = "MSYD/APS-REF-".$correlativo."/".$gestion;

    // AQUI MODIFIQUÉ LA CONSULTA: Añadí la columna archivo_adjunto y el valor '$archivo_adjunto_db' al final
    $sql0 = " INSERT INTO referencia_hc (iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idatencion_psafci, correlativo, codigo, idnombre,";
    $sql0.= " discapacidad, nombre_acompanante, idparentesco_acomp, celular_acompanante, tel_establecimiento, estuvo_internado, dias_internacion, resumen_anamnesis, especificacion_hallazgos, tratamiento_ref,";
    $sql0.= " observaciones_ref, idconsentimiento, idestablecimiento_receptor, idmotivo_referencia, idespecialidad_medica, gestion, idestado_referencia, idtiempo_ts, fecha_registro, hora_registro, idusuario, file_ref )";
    $sql0.= " VALUES ('$iddepartamento','$idred_salud','$idmunicipio','$idestablecimiento_salud_ss','$idatencion_psafci_ss','$correlativo','$codigo','$idnombre_integrante_ss',";
    $sql0.= " '$discapacidad','$nombre_acompanante','$idparentesco_acomp','$celular_acompanante','$tel_establecimiento','$estuvo_internado','$dias_internacion','$resumen_anamnesis','$especificacion_hallazgos','$tratamiento_ref',";
    $sql0.= " '$observaciones_ref','$idconsentimiento','$idestablecimiento_salud_r','$idmotivo_referencia','$idespecialidad_medica','$gestion','1','1','$fecha','$hora','$idusuario_ss', '')";
    $result0 = mysqli_query($link,$sql0);
    //***** en caso de fallo en alguna columna */ or die("<div style='background:#e74a3b; color:white; padding:30px; font-size:18px; border-radius:10px; font-family:Arial;'><b>🚨 ERROR FATAL DE MYSQL:</b><br><br>" . mysqli_error($link) . "</div><br><div style='background:#f8f9fc; padding:20px; font-family:monospace;'><b>TU CONSULTA SQL ES:</b><br>" . $sql0 . "</div>"); ***/  
    $idreferencia_hc = mysqli_insert_id($link);

    $_SESSION['idreferencia_hc_ss'] = $idreferencia_hc;
    // =========================================================================
    // MÓDULO DE ARCHIVOS CON PANTALLA DE DIAGNÓSTICO EN VIVO
    // =========================================================================
    $ESTADO_PROCESO = "No iniciado";
    $DETALLE_PROCESO = "";

    if (isset($_FILES['archivo_referencia_pdf'])) {
        $codigo_error = $_FILES['archivo_referencia_pdf']['error'];
        
        if ($codigo_error == 0) {
            $carpeta_destino = "../files_ref/"; 
            if (!file_exists($carpeta_destino)) {
                mkdir($carpeta_destino, 0777, true);
            }
            
            $nuevo_nombre_archivo = "REF_" . $idreferencia_hc . "_" . date("Ymd_His") . "_" . rand(1000, 9999) . ".pdf";
            $ruta_completa = $carpeta_destino . $nuevo_nombre_archivo;
            
            if(move_uploaded_file($_FILES['archivo_referencia_pdf']['tmp_name'], $ruta_completa)){
                $sql_upd_file = "UPDATE referencia_hc SET file_ref = '$nuevo_nombre_archivo' WHERE idreferencia_hc = '$idreferencia_hc'";
                if(mysqli_query($link, $sql_upd_file)) {
                    $ESTADO_PROCESO = "ÉXITO TOTAL";
                    $DETALLE_PROCESO = "El archivo se subió físicamente como <b>$nuevo_nombre_archivo</b> y se actualizó la columna <b>file_ref</b> para el ID de referencia: <b>$idreferencia_hc</b>.";
                } else {
                    $ESTADO_PROCESO = "FALLO EN BD";
                    $DETALLE_PROCESO = "El archivo se guardó en la carpeta, pero la consulta UPDATE falló: " . mysqli_error($link);
                }
            } else {
                $ESTADO_PROCESO = "FALLO DE PERMISOS";
                $DETALLE_PROCESO = "PHP recibió el archivo temporal, pero move_uploaded_file no pudo moverlo a: $ruta_completa";
            }
        } else {
            $ESTADO_PROCESO = "ARCHIVO CON ERROR DE ORIGEN";
            if($codigo_error == 4) {
                $DETALLE_PROCESO = "Código error 4: El navegador NO envió ningún archivo binario a PHP (llegó vacío). Esto ocurre si el formulario_referencia_ps.php limpió el input antes de enviar.";
            } else {
                $DETALLE_PROCESO = "Código error $codigo_error: Problema de tamaño límite.";
            }
        }
    } else {
        $ESTADO_PROCESO = "FORMULARIO SIN PERMISOS MULTIPART";
        $DETALLE_PROCESO = "La variable \$_FILES está vacía. Esto confirma al 100% que la etiqueta &lt;form&gt; en <b>formulario_referencia_ps.php</b> no tiene el atributo <b>enctype='multipart/form-data'</b>.";
    }
    // =========================================================================
    $_SESSION['idestablecimiento_salud_r_ss'] = $idestablecimiento_salud_r;

        $sql_dr = " INSERT INTO deriva_referencia_hc (idreferencia_hc, idestablecimiento_salud_o, idestablecimiento_salud_r, idusuario_o, idusuario_r, ";
        $sql_dr.= " referido, admitido, fecha_deriva, hora_deriva, fecha_admision, hora_admision )  ";
        $sql_dr.= " VALUES ('$idreferencia_hc','$idestablecimiento_salud_ss','$idestablecimiento_salud_r','$idusuario_ss','$idusuario_ss', ";
        $sql_dr.= " 'SI','NO','$fecha','$hora','$fecha','$hora')";
        $result_dr = mysqli_query($link,$sql_dr);   

            $imc_i = $peso*10000/$talla**2;  //** Estatura en centimetros */
            $imc = number_format($imc_i, 6, '.', '');

            $sql_sg = " INSERT INTO signo_vital_psafci (idatencion_psafci,idnombre, edad, frec_cardiaca, peso, talla, frec_respiratoria, presion_arterial, presion_arterial_d, temperatura, saturacion, imc, glascow, alergia, descripcion_alergia, fecha_registro, hora_registro, idusuario) ";
            $sql_sg.= " VALUES ('$idatencion_psafci_ss','$idnombre_integrante_ss','$edad','$frec_cardiaca','$peso','$talla','$frec_respiratoria','$presion_arterial','$presion_arterial_d','$temperatura','$saturacion','$imc','$glascow','$alergia','$descripcion_alergia','$fecha','$hora','$idusuario_ss') ";
            $result_sg = mysqli_query($link,$sql_sg);

            if (isset($_POST['idexamen_complementario'])) {
                foreach($_POST['idexamen_complementario'] as $idexamen_complementario_i) {
                    $sql_f = " INSERT INTO examen_referencia (idreferencia_hc, idnombre, idexamen_complementario, fecha_registro, hora_registro, idusuario) ";
                    $sql_f.= " VALUES ('$idreferencia_hc','$idnombre_integrante_ss','$idexamen_complementario_i','$fecha','$hora','$idusuario_ss') ";
                    $result_f = mysqli_query($link,$sql_f);
                }
            }

    $idpatologia = $_POST['idpatologia'];

    foreach($_POST['diagnostico_presuntivo'] as $clave => $diagnostico_presuntivo_i) {

            $sql_dg = " INSERT INTO diagnostico_presuntivo (idreferencia_hc, idnombre, diagnostico_presuntivo, idpatologia, fecha_registro, hora_registro, idusuario) ";
            $sql_dg.= " VALUES ('$idreferencia_hc','$idnombre_integrante_ss','$diagnostico_presuntivo_i','$idpatologia[$clave]','$fecha','$hora','$idusuario_ss') ";
            $result_dg = mysqli_query($link,$sql_dg);   
            }

/*********** se llenan otras tablas con relacion al CONTROL PERINATAL ***********/

    if ($discapacidad == 'SI') {

            $idtipo_discapacidad  = $_POST['idtipo_discapacidad'];
            $idnivel_discapacidad = $_POST['idnivel_discapacidad'];

            $sql_dis = " INSERT INTO discapacidad_ref (idreferencia_hc, idnombre, idtipo_discapacidad, idnivel_discapacidad, fecha_registro, hora_registro, idusuario) ";
            $sql_dis.= " VALUES ('$idreferencia_hc','$idnombre_integrante_ss','$idtipo_discapacidad','$idnivel_discapacidad','$fecha','$hora','$idusuario_ss') ";
            $result_dis = mysqli_query($link,$sql_dis);   

    } else {  }

    if ($idgenero == '1' && $edad >'12') {

    if ($datos_perinatales = 'SI') {
    
            $gestaciones    = $_POST['gestaciones'];
            $partos         = $_POST['partos'];
            $abortos        = $_POST['abortos'];
            $cesareas       = $_POST['cesareas'];

            $fecha_fum      = $_POST['fecha_fum'];
            $fecha_fpp      = $_POST['fecha_fpp'];
            $controles_prenatales = $_POST['controles_prenatales'];

            $frecuencia_fcf       = $_POST['frecuencia_fcf'];

            $parto        = $_POST['parto'];

            $sql_hcp    = " SELECT idhistoria_perinatal FROM historia_perinatal WHERE idnombre ='$idnombre_integrante_ss'  ";
            $result_hcp = mysqli_query($link,$sql_hcp);
            if ($row_hcp = mysqli_fetch_array($result_hcp)) {    

            /****** SI YA HAY HISTORIA PERINATAL SOLO ACTUALIZAMOS TABLAS QUE CORRESPONDAN - BEGIN*******/



            /****** SI YA HAY HISTORIA PERINATAL SOLO ACTUALIZAMOS TABLAS QUE CORRESPONDAN - END  *******/
                        
            } else {

            /********* INSERTAMOS/REGISTRAMOS LA HISTORIA PERINATAL Y LAS DEMAS TABLAS *******/

                $sql_hp    = " SELECT MAX(correlativo) FROM historia_perinatal WHERE gestion='$gestion'  ";
                $result_hp = mysqli_query($link,$sql_hp);
                $row_hp    = mysqli_fetch_array($result_hp);

                $correlativo_p = $row_hp[0]+1;

                $codigo_p = "MSYD-HCP-".$correlativo_p."/".$gestion;
    
                $sql0 = " INSERT INTO historia_perinatal (iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idarea_influencia, correlativo, codigo, idnombre,  ";
                $sql0.= " idnacion, alfabeta, idnivel_instruccion, anos_mayor_nivel, vive_sola, gestion, fecha_registro, hora_registro, idusuario)  ";
                $sql0.= " VALUES ('$iddepartamento','$idred_salud','$idmunicipio','$idestablecimiento_salud_ss','$idarea_influencia','$correlativo_p','$codigo_p','$idnombre_integrante_ss', ";
                $sql0.= " '$idnacion','SI','2','','','$gestion','$fecha','$hora','$idusuario_ss')";
                $result0 = mysqli_query($link,$sql0);   
                $idhistoria_perinatal = mysqli_insert_id($link);

                $sql_1 = " INSERT INTO antecedente_obstetrico (idhistoria_perinatal, idnombre, gestaciones, partos, abortos, cesareas, nacidos_vivos, viven, nacidos_muertos, muertos_a_semana, ";
                $sql_1.= " muertos_d_semana, vaginales, idultimo_previo, antecedente_gemelos, fecha_fea, menos_ano, embarazo_planeado, idmetodo_anticonceptivo, fecha_registro, hora_registro, idusuario) ";
                $sql_1.= " VALUES ('$idhistoria_perinatal','$idnombre_integrante_ss','$gestaciones','$partos','$abortos','$cesareas','0','0','0','0', ";
                $sql_1.= " '0','0','1','','$fecha','','','1','$fecha','$hora','$idusuario_ss') ";
                $result_1 = mysqli_query($link,$sql_1);   

                $sql_2 = " INSERT INTO gestacion (idhistoria_perinatal, idnombre, peso_anterior, talla, idesno, fecha_fum, eg_fum, eco_veinte, fecha_fpp, ";
                $sql_2.= " fuma_activo, fuma_pasivo, drogas, alcohol, violencia, idantirubeola, antitetanica, dosis_antitetanica, ex_odontologico, ex_mamas, controles_prenatales, fecha_registro, hora_registro, idusuario) ";
                $sql_2.= " VALUES ('$idhistoria_perinatal','$idnombre_integrante_ss','','','3','$fecha_fum','', '','$fecha_fpp', ";
                $sql_2.= " '','','','','','2','','','','','$controles_prenatales','$fecha','$hora','$idusuario_ss') ";
                $result_2 = mysqli_query($link,$sql_2);
                $idgestacion = mysqli_insert_id($link); 

                /***** consultas antenatales ****** */

                $sql_3 = " INSERT INTO consulta_antenatal (idhistoria_perinatal, idgestacion, idnombre, fecha_consulta, edad_gestacional, peso, imc, presion_arterial, altura_uterina, ";
                $sql_3.= " presentacion, frecuencia_fcf, mov_fetales, proteinuria, tabletas_sfe, senales_examenes, fecha_proxima, fecha_registro, hora_registro, idusuario) ";
                $sql_3.= " VALUES ('$idhistoria_perinatal','$idgestacion','$idnombre_integrante_ss','$fecha','','','','','', ";
                $sql_3.= " '','$frecuencia_fcf','','','','','$fecha','$fecha','$hora','$idusuario_ss') ";
                $result_3 = mysqli_query($link,$sql_3); 

            }
                
        if ($parto == 'SI') {

            $maduracion_pulmonar = $_POST['maduracion_pulmonar'];
            $hora_rpm           = $_POST['hora_rpm'];
           
            $idtipo_parto       = $_POST['idtipo_parto'];
            $fecha_parto        = $_POST['fecha_parto'];
            $hora_parto         = $_POST['hora_parto'];
            $edad_gestacional   = $_POST['edad_gestacional'];
            $liq_amniotico      = $_POST['liq_amniotico'];
            $idpeso_eg          = $_POST['idpeso_eg'];
            $peso_rn            = $_POST['peso_rn'];
            $talla_rn           = $_POST['talla_rn'];
            $pc_rn              = $_POST['pc_rn'];
            $pt_rn              = $_POST['pt_rn'];
            $apgar_uno          = $_POST['apgar_uno'];
            $apgar_cinco        = $_POST['apgar_cinco'];
            $indice_choque      = $_POST['indice_choque'];
            $criterio_sofa      = $_POST['criterio_sofa'];
            $idgenero_rn        = $_POST['idgenero_rn'];

                $sql_4 = " INSERT INTO parto (idhistoria_perinatal, idgestacion, idnombre, fecha_ingreso, hospitalizacion_embarazo, dias_hospitalizacion, ";
                $sql_4.= " maduracion_pulmonar, hora_rpm, idtipo_parto, fecha_parto, hora_parto, fecha_registro, hora_registro, idusuario) ";
                $sql_4.= " VALUES ('$idhistoria_perinatal','$idgestacion','$idnombre_integrante_ss','$fecha','','',";
                $sql_4.= " '$maduracion_pulmonar','$hora_rpm','$idtipo_parto','$fecha_parto','$hora_parto','$fecha','$hora','$idusuario_ss') ";
                $result_4 = mysqli_query($link,$sql_4); 

                $sql_5 = " INSERT INTO recien_nacido (idhistoria_perinatal, idgestacion, idgenero, liq_amniotico, peso_rn, talla_rn, pc_rn, pt_rn, edad_gestacional, ";
                $sql_5.= " idpeso_eg, apgar_uno, apgar_cinco, indice_choque, criterio_sofa, fecha_registro, hora_registro, idusuario) ";
                $sql_5.= " VALUES ('$idhistoria_perinatal','$idgestacion','$idgenero_rn','$liq_amniotico','$peso_rn','$talla_rn','$pc_rn','$pt_rn','$edad_gestacional', ";
                $sql_5.= " '$idpeso_eg','$apgar_uno','$apgar_cinco','$indice_choque','$criterio_sofa','$fecha','$hora','$idusuario_ss') ";
                $result_5 = mysqli_query($link,$sql_5); 

        } else {  }        
        
        } else {  }

        } else {  }
         
    
// Comentamos temporalmente la redirección para auditar el sistema
header("Location:mensaje_referencia_hc.php");


/*********** Guarda el registro de grupo de salud (BEGIN) *************/



/*********** Guarda el registro de grupo de salud (END) *************/
?>