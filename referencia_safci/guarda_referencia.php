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

echo $idatencion_psafci_ss."</br>";
echo $idcarpeta_familiar_ss."</br>";
echo $idestablecimiento_salud_ss."</br>";
echo $idintegrante_cf_ss."</br>";
echo $idnombre_integrante_ss."</br>";
echo $edad_ss."</br>";
echo "</br>";

echo $persona_discapacidad."</br>";
echo $idtipo_discapacidad."</br>";  
echo $idnivel_discapacidad."</br>";
echo $acompanante."</br>";          
echo $celular_acompanante."</br>";
echo $tel_establecimiento."</br>";
echo "</br>";
echo $talla."</br>";                
echo $peso."</br>"  ;               
echo $frec_cardiaca."</br>" ;       
echo $frec_respiratoria."</br>";   
echo $presion_arterial."</br>" ;    
echo $presion_arterial_d."</br>" ;  
echo $saturacion."</br>" ;          
echo $glascow."</br>";              
echo $temperatura."</br>";          
echo $alergia."</br>" ;            
echo $descripcion_alergia."</br>";  
echo "</br>";
echo $fecha_fum."</br>";     
echo $gestaciones."</br>";   
echo $partos."</br>";         
echo $abortos."</br>";        
echo $cesareas."</br>" ;      
echo $fecha_fpp."</br>" ;     
echo $hora_rpm."</br>" ;      
echo "</br>";
echo $frecuencia_fcf."</br>";       
echo $controles_prenatales."</br>"; 
echo $maduracion_p."</br>";      
echo $parto."</br>";            
echo $tipo_parto."</br>";       
echo $fecha_parto."</br>";       
echo $hora_parto."</br>";        
echo $edad_gestacional."</br>";  
echo $liq_amniotico."</br>";      
echo $peso_rn."</br>";           
echo $talla_rn."</br>";        
echo $pc_rn."</br>";             
echo $pt_rn."</br>";             
echo $apgar_uno."</br>" ;         
echo $apgar_cinco."</br>";       
echo $indice_choque."</br>";     
echo $criterios_sofa."</br>" ;    
echo $internado."</br>" ;         
echo $dias_internacion."</br>" ;  
echo $resumen_anamnesis."</br>";  
echo "</br>";

    foreach($_POST['idtipo_examen_ref'] as $idtipo_examen_ref_i) {
     echo $idtipo_examen_ref_i."</br>";
    }

echo "</br>";
echo $especificacion_hallazgos."</br>"; 
echo "</br>";

    foreach($_POST['diagnostico_presuntivo'] as $diagnostico_presuntivo_i) { 
     echo $diagnostico_presuntivo_i."</br>";
    }

    foreach($_POST['cie'] as $cie_i) { 
     echo $cie_i."</br>";
    }

echo "</br>";
echo $tratamiento_ref."</br>";          
echo $observaciones_ref."</br>" ;      
echo $idconsentimiento."</br>" ;       
echo $idestablecimiento_receptor."</br>"; 
echo $idmotivo_referencia."</br>" ;       
echo $idespecialidad_medica."</br>" ;     

/*********** Guarda el registro de grupo de salud (END) *************/
?>