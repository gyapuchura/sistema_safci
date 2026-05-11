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

$idpatologia_ap_sano = $_POST['idpatologia_ap_sano'];
$subjetivo  = $link->real_escape_string($_POST['subjetivo']);
$objetivo   = $link->real_escape_string($_POST['objetivo']);
$analisis   = $link->real_escape_string($_POST['analisis']);
$plan       = $link->real_escape_string($_POST['plan']);

$motivo_consulta     = 'S.- '.$subjetivo .' O.- '.$objetivo.' A.- '.$analisis.' P.- '.$plan;

/******** SIGNOS VITALES  ********/

$talla                  = $link->real_escape_string($_POST['talla']);
$peso                   = $link->real_escape_string($_POST['peso']);
$perimetro_abdominal    = $link->real_escape_string($_POST['perimetro_abdominal']);
$circunferencia_cadera  = $link->real_escape_string($_POST['circunferencia_cadera']);
$presion_arterial           = $_POST['presion_arterial'];
$presion_arterial_d         = $_POST['presion_arterial_d'];
$presion_arterial_tobillo   = $_POST['presion_arterial_tobillo'];
$presion_arterial_tobillo_d = $_POST['presion_arterial_tobillo_d'];


$sql_e    = " SELECT iddepartamento, idred_salud, idmunicipio FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud_ss' ";
$result_e = mysqli_query($link,$sql_e);
$row_e    = mysqli_fetch_array($result_e);

$sql_int    = " SELECT idgenero FROM nombre WHERE idnombre ='$idnombre_integrante_ss' ";
$result_int = mysqli_query($link,$sql_int);
$row_int    = mysqli_fetch_array($result_int);

$sql_nac    = " SELECT idnacion FROM integrante_cf WHERE idintegrante_cf ='$idintegrante_cf_ss' ";
$result_nac = mysqli_query($link,$sql_nac);
$row_nac    = mysqli_fetch_array($result_nac);

$sql_af    = " SELECT idarea_influencia FROM carpeta_familiar WHERE idcarpeta_familiar ='$idcarpeta_familiar_ss' ";
$result_af = mysqli_query($link,$sql_af);
$row_af    = mysqli_fetch_array($result_af);

$iddepartamento = $row_e[0];
$idred_salud    = $row_e[1];
$idmunicipio    = $row_e[2];
$idarea_influencia = $row_af[0];

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

    $imc_i = $peso*10000/$talla**2;  //** Estatura en centimetros */
    $imc = number_format($imc_i, 6, '.', '');

    $sql1 = " INSERT INTO signo_vital_psafci (idatencion_psafci,idnombre, edad, peso, talla, perimetro_abdominal, circunferencia_cadera,";   
    $sql1.= " presion_arterial, presion_arterial_d, presion_arterial_tobillo, presion_arterial_tobillo_d, imc, fecha_registro, hora_registro, idusuario)  ";
    $sql1.= " VALUES ('$idatencion_psafci','$idnombre_integrante_ss','$edad_ss','$peso','$talla','$perimetro_abdominal','$circunferencia_cadera', ";
    $sql1.= " '$presion_arterial','$presion_arterial_d',"$presion_arterial_tobillo", "$presion_arterial_tobillo_d",'$imc','$fecha','$hora','$idusuario_ss') ";
    $result1 = mysqli_query($link,$sql1);
    $idsigno_vital_psafci = mysqli_insert_id($link);

    /********** evaluamos los riesgos e inter`retaciones BEGIN  ***********/

    $indice_abdomen_talla = $perimetro_abdominal/$talla;

    $indice_cintura_cadera = $perimetro_abdominal/$circunferencia_cadera;

    $indice_tobillo_brazo = $presion_arterial_tobillo/$presion_arterial;


/********** CLASIFICADOR IMC - BEGIN *********/

if ($imc < '16.5') {
    $clasificacion_imc = 'BAJO PESO SEVERO';
} else {
    if ($imc < '18.5' && $imc >= '16.5') {
        $clasificacion_imc = 'BAJO PESO';
    } else {
        if ($imc < '25' && $imc >= '18.5') {
            $clasificacion_imc = 'PESO NORMAL';
        } else {
            if ($imc < '30' && $imc >= '25') {
                $clasificacion_imc = 'SOBREPESO';
            } else {
                if ($imc < '35' && $imc >= '30') {
                    $clasificacion_imc = 'OBESIDAD TIPO 1 (MODERADA)';
                } else {
                    if ($imc < '40' && $imc >= '35') {
                        $clasificacion_imc = 'OBESIDAD TIPO 2 (SEVERA)';
                    } else {
                        if ($imc >='40') {
                             $clasificacion_imc = 'OBESIDAD TIPO 3 (SEVERA)';
                        } else { } } } } } } }

/********** CLASIFICADOR IMC - END *********/
                        

/********** RIESGO DE CINTURA / CADERA- BEGIN *********/

switch ($idegenero) {
        case '1':
            
            if ($indice_cintura_cadera < '0.80' ) {
                $riesgo_indice_cintura_cadera = 'BAJO';
            } else {
                if ($indice_cintura_cadera >= '0.80' && $indice_cintura_cadera <= '0.85') {
                    $riesgo_indice_cintura_cadera = 'MODERADO';
                } else {
                    if ($indice_cintura_cadera >= '0.86') {
                        $riesgo_indice_cintura_cadera = 'ALTO';
                    } else { } } }

            if ($perimetro_abdominal < '82' ) {
                $riesgo_cintura = 'NORMAL';
            } else {
                if ($perimetro_abdominal >= '82' && $$perimetro_abdominal <= '88') {
                    $riesgo_cintura = 'RIESGO ELEVADO';
                } else {
                    if ($perimetro_abdominal > '88') {
                        $riesgo_cintura = 'RIESGO MUY ELEVADO';
                    } else { } } }

            break;
            
        case '2':

            if ($indice_cintura_cadera < '0.95' ) {
                $riesgo_indice_cintura_cadera = 'BAJO';
            } else {
                if ($indice_cintura_cadera >= '0.95' && $indice_cintura_cadera <= '1') {
                    $riesgo_indice_cintura_cadera = 'MODERADO';
                } else {
                    if ($indice_cintura_cadera > '1') {
                        $riesgo_indice_cintura_cadera = 'ALTO';
                    } else { } } }


            if ($perimetro_abdominal < '95' ) {
                $riesgo_cintura = 'NORMAL';
            } else {
                if ($perimetro_abdominal >= '95' && $$perimetro_abdominal <= '102') {
                    $riesgo_cintura = 'RIESGO ELEVADO';
                } else {
                    if ($perimetro_abdominal > '102') {
                        $riesgo_cintura = 'RIESGO MUY ELEVADO';
                    } else { } } }
            break;
    }

/********** RIESGO DE CINTURA / CADERA- END *********/

/********** RIESGO DEL INDICE TOBILLO / BRAZO - BEGIN *********/


if ($indice_tobillo_brazo >= '0' && $indice_tobillo_brazo <= '0.40') {
    $interpretacion_indice_tobillo_brazo = 'DISMINUCIÓN SEVERA: ISQUEMIA CRITICA, EXTREMIDAD AMENAZADA';
} else {
    if ($indice_tobillo_brazo >= '0.41' && $indice_tobillo_brazo <= '0.90') {
        $interpretacion_indice_tobillo_brazo = 'DISMINUCIÓN MODERADA';
    } else {
        if ($indice_tobillo_brazo >= '0.91' && $indice_tobillo_brazo <= '0.99') {
            $interpretacion_indice_tobillo_brazo = 'LIMÍTROFE';
        } else {
            if ($indice_tobillo_brazo >= '1.0' && $indice_tobillo_brazo <= '1.40') {
                $interpretacion_indice_tobillo_brazo = 'NORMAL';
            } else {
                if ($indice_tobillo_brazo > '1.40') {
                    $interpretacion_indice_tobillo_brazo = 'ELEVADO, VASOS NO COMPRESIBLES';
                } else { } } } } }

/********** RIESGO DEL INDICE TOBILLO / BRAZO - END *********/

/********** CLASIFICADOR DE PRESION ARTERIAL - BEGIN *********/

if ($presion_arterial < '120' && $presion_arterial_d < '80') {
    $clasificacion_presion_arterial ='ÓPTIMA';
} else {
    if (($presion_arterial >= '120' && $presion_arterial <= '129') || ($presion_arterial_d >= '80' && $presion_arterial_d <= '84')) {
        $clasificacion_presion_arterial ='NORMAL';
    } else {
        if (($presion_arterial >= '130' && $presion_arterial <= '139') || ($presion_arterial_d >= '85' && $presion_arterial_d <= '89')) {
            $clasificacion_presion_arterial ='NORMAL-ALTA';
        } else {
            if (($presion_arterial >= '140' && $presion_arterial <= '159') || ($presion_arterial_d >= '90' && $presion_arterial_d <= '99')) {
                $clasificacion_presion_arterial ='HIPERTENSIÓN DE GRADO 1';
            } else {
                if (($presion_arterial >= '160' && $presion_arterial <= '179') || ($presion_arterial_d >= '100' && $presion_arterial_d <= '109')) {
                    $clasificacion_presion_arterial ='HIPERTENSIÓN DE GRADO 2';
                } else {
                    if ($presion_arterial >= '180'  && $presion_arterial_d >= '110') {
                        $clasificacion_presion_arterial ='HIPERTENSIÓN DE GRADO 3';
                    } else {
                        if ($presion_arterial >= '140'  && $presion_arterial_d < '90') {
                            $clasificacion_presion_arterial ='HIPERTENSIÓN SOLO SISTÓLICA';
                        } else { } } } } } } }


/********** CLASIFICADOR DE PRESION ARTERIAL - END *********/

$riesgo_indice_cintura_cadera
    
    /********** evaluamos los riesgos e inter`retaciones END  ***********/

$sql_ev = " INSERT INTO evaluacion_preventiva (idatencion_psafci, idsigno_vital_psafci, idnombre, indice_abdomen_talla, indice_cintura_cadera, indice_tobillo_brazo, clasificacion_imc, ";
$sql_ev.= " riesgo_indice_cintura_cadera, interpretacion_indice_tobillo_brazo, clasificacion_presion_arterial, riesgo_cintura, fecha_registro, hora_registro, idusuario) ";
$sql_ev.= " VALUES ('$idatencion_psafci','$idsigno_vital_psafci','$idnombre_integrante_ss','$indice_abdomen_talla','$indice_cintura_cadera','$indice_tobillo_brazo','$clasificacion_imc',";
$sql_ev.= " '$riesgo_indice_cintura_cadera','$interpretacion_indice_tobillo_brazo','$clasificacion_presion_arterial','$riesgo_cintura','$fecha','$hora','$idusuario_ss')";
$result_ev = mysqli_query($link,$sql_ev);   

$_SESSION['idatencion_psafci_ss'] = $idatencion_psafci;

header("Location:mostrar_atencion_psafci.php");
      
?>