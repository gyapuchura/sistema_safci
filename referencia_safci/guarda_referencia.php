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

$acompanante          = $_POST['acompanante'];
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

$internado          = $_POST['internado'];
$dias_internacion   = $_POST['dias_internacion'];
$resumen_anamnesis  = $_POST['resumen_anamnesis'];
$especificacion_hallazgos = $_POST['especificacion_hallazgos'];
$tratamiento_ref          = $_POST['tratamiento_ref'];
$observaciones_ref        = $_POST['observaciones_ref'];
$idconsentimiento         = $_POST['idconsentimiento'];

$idestablecimiento_salud_r      = $_POST['idestablecimiento_salud_r'];
$idespecialidad_medica      = $_POST['idespecialidad_medica'];


    $sql0 = " INSERT INTO referencia_hc (iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, correlativo, codigo, idnombre,";
    $sql0.= " discapacidad, nombre_aconpanante, celular_acompanante, tel_establecimiento, estuvo_internado, dias_internacion, resumen_anamnesis, especificacion_hallazgos, tratamiento_ref,";
    $sql0.= " observaciones_ref, idconsentimien_referencia, idespecialidad_medica, gestion, fecha_registro, hora_registro, idusuario )";
    $sql0.= " VALUES ('$iddepartamento','$idred_salud','$idmunicipio','$idestablecimiento_salud_ss','$correlativo','$codigo','$idnombre_integrante_ss',";
    $sql0.= " '$discapacidad','$nombre_aconpanante','$celular_acompanante','$tel_establecimiento','$estuvo_internado','$dias_internacion','$resumen_anamnesis','$especificacion_hallazgos','$tratamiento_ref',";
    $sql0.= " '$observaciones_ref','$idconsentimiento_referencia','$idespecialidad_medica','$gestion','$fecha','$hora_registro','$idusuario_ss')";
    $result0 = mysqli_query($link,$sql0);   
    $idreferencia_hc = mysqli_insert_id($link);

        $sql0 = " INSERT INTO deriva_referencia_hc (idreferencia_hc, idestablecimiento_salud_o, idestablecimiento_salud_r, idusuario_o, idusuario_r, ";
        $sql0.= " referido, admitido, adecuado, justificado, oportuno, fecha_deriva, fecha_admision, hora_admision )  ";
        $sql0.= " VALUES ('$idreferencia_hc','$idestablecimiento_salud_ss','$idestablecimiento_salud_r','$idusuario_ss','$idusuario_ss', ";
        $sql0.= " 'SI','NO','','','','$fecha','$fecha','$hora')";
        $result0 = mysqli_query($link,$sql0);   
        $idreferencia_hc = mysqli_insert_id($link);




$idexamen_complementario   = $_POST['idexamen_complementario'];



$idpatologia            = $_POST['idpatologia'];



$diagnostico_presuntivo = $_POST['diagnostico_presuntivo'];







/*********** se llenan otras tablas con relacion al CONTROL PERINATAL ***********/
    if ($discapacidad == 'SI') {

            $idtipo_discapacidad  = $_POST['idtipo_discapacidad'];
            $idnivel_discapacidad = $_POST['idnivel_discapacidad'];

    } else {  }

    if ($idgenero == '1' && $edad > '14') {
        
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

        if ($parto == 'SI') {
            
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

        } else {   }
        

    } else {  }
    


/*********** Guarda el registro de grupo de salud (BEGIN) *************/



/*********** Guarda el registro de grupo de salud (END) *************/
?>