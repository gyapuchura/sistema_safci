<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$hora    = date("H:i");
$gestion = date("Y");

$idusuario_ss  = $_SESSION['idusuario_ss'];
$idnombre_ss   = $_SESSION['idnombre_ss'];
$perfil_ss     = $_SESSION['perfil_ss'];

$idintegrante_cf_ss           = $_SESSION['idintegrante_cf_ss'];
$idnombre_integrante_ss       = $_SESSION['idnombre_integrante_ss'];
$edad_ss                      = $_SESSION['edad_ss'];

$sql_es = " SELECT iddato_laboral, idestablecimiento_salud, iddepartamento, idred_salud FROM dato_laboral WHERE idusuario='$idusuario_ss' ORDER BY iddato_laboral DESC LIMIT 1  ";
$result_es = mysqli_query($link,$sql_es);
$row_es = mysqli_fetch_array($result_es);

$idestablecimiento_salud_enc = $row_es[1];
$iddepartamento_enc          = $row_es[2];
$idred_salud_enc             = $row_es[3];

$sql_e    = " SELECT iddepartamento, idred_salud, idmunicipio FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud_enc' ";
$result_e = mysqli_query($link,$sql_e);
$row_e    = mysqli_fetch_array($result_e);

$idmunicipio_enc = $row_e[2];

$sql_int    = " SELECT idgenero FROM nombre WHERE idnombre ='$idnombre_integrante_ss' ";
$result_int = mysqli_query($link,$sql_int);
$row_int    = mysqli_fetch_array($result_int);

$sql_nac    = " SELECT idnacion FROM integrante_cf WHERE idintegrante_cf ='$idintegrante_cf_ss' ";
$result_nac = mysqli_query($link,$sql_nac);
$row_nac    = mysqli_fetch_array($result_nac);

$idgenero       = $row_int[0];
$idnacion       = $row_nac[0];

$idtema_encuesta      = $_POST['idtema_encuesta'];

$idrepeticion         = $_POST['idrepeticion'];
$idtipo_consulta      = $_POST['idtipo_consulta'];
$fecha                = $_POST['fecha_registro'];

$talla                = $link->real_escape_string($_POST['talla']);
$peso                 = $link->real_escape_string($_POST['peso']);
$temperatura          = $link->real_escape_string($_POST['temperatura']);
$frec_cardiaca        = $_POST['frec_cardiaca'];
$frec_respiratoria    = $_POST['frec_respiratoria'];
$presion_arterial     = $_POST['presion_arterial'];
$presion_arterial_d   = $_POST['presion_arterial_d'];
$perimetro_cefalico   = $_POST['perimetro_cefalico'];

$idclasificacion_riesgo_cancer  = $_POST['idclasificacion_riesgo_cancer'];

$sqlm    = " SELECT MAX(correlativo) FROM encuesta_psafci WHERE gestion='$gestion'";
$resultm = mysqli_query($link,$sqlm);
$rowm    = mysqli_fetch_array($resultm);

$correlativo = $rowm[0]+1;

$codigo = "MSYD/APS-ENC-".$correlativo."/".$gestion; 

    $sql0 = " INSERT INTO encuesta_psafci (iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, correlativo, codigo, idnombre,";
    $sql0.= " idtema_encuesta, gestion, idclasificacion_riesgo_cancer, fecha_registro, hora_registro, idusuario ";
    $sql0.= " VALUES ('$iddepartamento_enc','$idred_salud_enc','$idmunicipio_enc','$idestablecimiento_salud_enc','$correlativo','$codigo','$idnombre_integrante_ss',";
    $sql0.= " '$idtema_encuesta','$gestion','$idclasificacion_riesgo_cancer','$fecha','$hora','$idusuario_ss' ";
    $result0 = mysqli_query($link,$sql0); 
    $idencuesta_psafci = mysqli_insert_id($link); 

    /*************** GUARDAMOS EL REGSITRO DE UNA ATENCION MEDICA PREVENTIVA *********/

        $sqlma    = " SELECT MAX(correlativo) FROM atencion_psafci WHERE gestion='$gestion' ";
        $resultma = mysqli_query($link,$sqlma);
        $rowma    = mysqli_fetch_array($resultma);

        $correlativoa = $rowma[0]+1;

        $codigoa = "PSAFCI-ATENCION-".$correlativoa."/".$gestion;

        $sql0 = " INSERT INTO atencion_psafci (iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idnombre, edad, idgenero, ";
        $sql0.= " idrepeticion, idtipo_consulta, idtipo_atencion, idnacion, codigo, correlativo, gestion, fecha_registro, hora_registro, idusuario)  ";
        $sql0.= " VALUES ('$iddepartamento_enc','$idred_salud_enc','$idmunicipio_enc','$idestablecimiento_salud_enc','$idnombre_integrante_ss','$edad_ss','$idgenero', ";
        $sql0.= " '$idrepeticion','$idtipo_consulta','2','$idnacion','$codigoa','$correlativoa','$gestion', '$fecha','$hora','$idusuario_ss')";
        $result0 = mysqli_query($link,$sql0);   
        $idatencion_psafci = mysqli_insert_id($link);

        $sql1 = " INSERT INTO signo_vital_psafci (idatencion_psafci, idnombre, edad, frec_cardiaca, peso, talla, frec_respiratoria, presion_arterial, presion_arterial_d, temperatura, perimetro_cefalico, fecha_registro, hora_registro, idusuario) ";
        $sql1.= " VALUES ('$idatencion_psafci','$idnombre_integrante_ss','$edad_ss','$frec_cardiaca','$peso','$talla','$frec_respiratoria','$presion_arterial','$presion_arterial_d','$temperatura','$perimetro_cefalico','$fecha','$hora','$idusuario_ss') ";
        $result1 = mysqli_query($link,$sql1);


    /************* GUARDAMOS LAS RESPUESTAS QUE CARGA EL MEDICO ENCUESTADOR ************/

    $respuesta         = $_POST['respuesta'];
    $retroalimentacion = $_POST['retroalimentacion'];
    
    foreach($_POST['idpregunta_encuesta'] as $clave => $idpregunta_encuesta_i) {
    
        $sql2 = " INSERT INTO respuesta_encuesta (idencuesta_psafci, idpregunta_encuesta, respuesta, retroalimentacion, fecha_registro, hora_registro, idusuario) ";
        $sql2.= " VALUES ('$idencuesta_psafci','$idpregunta_encuesta_i','$respuesta[$clave]','$retroalimentacion[$clave]','$fecha','$hora','$idusuario_ss') ";
        $result2 = mysqli_query($link,$sql2);

    }

    foreach($_POST['iditem_senal_cancer'] as $iditem_senal_cancer_i) {
    
        $sql3 = " INSERT INTO respuesta_item_cancer (idencuesta_psafci, iditem_senal_cancer, fecha_registro, hora_registro, idusuario) ";
        $sql3.= " VALUES ('$idencuesta_psafci','$iditem_senal_cancer_i','$fecha','$hora','$idusuario_ss') ";
        $result3 = mysqli_query($link,$sql3);
    
    }


        /*********** Guarda el registro de encuesta de deteccion del cancer (END) *************/
        ?>