<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$hora    = date("H:i");
$gestion = date("Y");

$idusuario_ss  = $_SESSION['idusuario_ss'];
$idnombre_ss   = $_SESSION['idnombre_ss'];
$perfil_ss     = $_SESSION['perfil_ss'];

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

/************* Se reciben los datos personales ************/

$nombre        = $link->real_escape_string(mb_strtoupper($_POST['nombre']));
$paterno       = $link->real_escape_string(mb_strtoupper($_POST['paterno']));
$materno       = $link->real_escape_string(mb_strtoupper($_POST['materno']));
$ci            = $_POST['ci'];
$complemento   = $link->real_escape_string($_POST['complemento']);
$idgenero       = $_POST['idgenero'];
$fecha_nac      = $_POST['fecha_nac'];
$idnacionalidad = $_POST['idnacionalidad'];
$idnacion       = $_POST['idnacion'];
$fecha          = $_POST['fecha_registro'];

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

    $edad_ss = ($ano-$anonaz);


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


/********** guardamos datos de nuevo paciente --- begin ********/

if ($ci == '0') {


    $sql_c = " INSERT INTO nombre (paterno, materno, nombre, ci, exp, fecha_nac, complemento, idnacionalidad, idgenero) ";
    $sql_c.= " VALUES ('$paterno','$materno','$nombre','$ci','','$fecha_nac','$complemento','$idnacionalidad','$idgenero') ";
    $result_c = mysqli_query($link,$sql_c);   
    $idnombre_paciente_ss = mysqli_insert_id($link);  
      
    $_SESSION['idnombre_paciente_ss'] = $idnombre_paciente_ss;

        $idnacion = '33';

        $sql_int    = " SELECT idgenero FROM nombre WHERE idnombre ='$idnombre_paciente_ss' ";
        $result_int = mysqli_query($link,$sql_int);
        $row_int    = mysqli_fetch_array($result_int);

        $idgenero       = $row_int[0];


    /*************** GUARDAMOS EL REGSITRO DE UNA ATENCION MEDICA PREVENTIVA *********/

        $sqlma    = " SELECT MAX(correlativo) FROM atencion_psafci WHERE gestion='$gestion' ";
        $resultma = mysqli_query($link,$sqlma);
        $rowma    = mysqli_fetch_array($resultma);

        $correlativoa = $rowma[0]+1;

        $codigoa = "PSAFCI-ATENCION-".$correlativoa."/".$gestion;

        $sql0 = " INSERT INTO atencion_psafci (iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idnombre, edad, idgenero, ";
        $sql0.= " idrepeticion, idtipo_consulta, idtipo_atencion, idnacion, codigo, correlativo, gestion, fecha_registro, hora_registro, idusuario)  ";
        $sql0.= " VALUES ('$iddepartamento_enc','$idred_salud_enc','$idmunicipio_enc','$idestablecimiento_salud_enc','$idnombre_paciente_ss','$edad_ss','$idgenero', ";
        $sql0.= " '$idrepeticion','$idtipo_consulta','6','$idnacion','$codigoa','$correlativoa','$gestion', '$fecha','$hora','$idusuario_ss')";
        $result0 = mysqli_query($link,$sql0);   
        $idatencion_psafci = mysqli_insert_id($link);

         $_SESSION['idatencion_psafci_ss'] = $idatencion_psafci;


$sqlm    = " SELECT MAX(correlativo) FROM encuesta_psafci WHERE gestion='$gestion'";
$resultm = mysqli_query($link,$sqlm);
$rowm    = mysqli_fetch_array($resultm);

$correlativo = $rowm[0]+1;

$codigo = "MSYD/APS-ENC-".$correlativo."/".$gestion; 

    $sql0 = " INSERT INTO encuesta_psafci (iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idatencion_psafci, correlativo, codigo, idnombre,";
    $sql0.= " idtema_encuesta, idrepeticion, idtipo_consulta, gestion, idclasificacion_riesgo_cancer, fecha_registro, hora_registro, idusuario) ";
    $sql0.= " VALUES ('$iddepartamento_enc','$idred_salud_enc','$idmunicipio_enc','$idestablecimiento_salud_enc','$idatencion_psafci','$correlativo','$codigo','$idnombre_paciente_ss',";
    $sql0.= " '$idtema_encuesta','$idrepeticion','$idtipo_consulta','$gestion','$idclasificacion_riesgo_cancer','$fecha','$hora','$idusuario_ss')";
    $result0 = mysqli_query($link,$sql0); 
    $idencuesta_psafci = mysqli_insert_id($link); 

    $_SESSION['idencuesta_psafci_ss'] = $idencuesta_psafci;



        $sql1 = " INSERT INTO signo_vital_psafci (idatencion_psafci, idnombre, edad, frec_cardiaca, peso, talla, frec_respiratoria, presion_arterial, presion_arterial_d, temperatura, perimetro_cefalico, fecha_registro, hora_registro, idusuario) ";
        $sql1.= " VALUES ('$idatencion_psafci','$idnombre_paciente_ss','$edad_ss','$frec_cardiaca','$peso','$talla','$frec_respiratoria','$presion_arterial','$presion_arterial_d','$temperatura','$perimetro_cefalico','$fecha','$hora','$idusuario_ss') ";
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


    header("Location:mostrar_encuesta_prev_nhc.php");


} else {

        $sql_n  = " SELECT idnombre, ci, nombre, paterno, materno, fecha_nac FROM nombre WHERE ci='$ci' ";
        $result_n = mysqli_query($link,$sql_n);    
        if ($row_n = mysqli_fetch_array($result_n)) {

                $fecha_nacimiento = $row_n[5];
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
                            $edad=($ano-$anonaz);  

    /********** VERIFICAMOS QUE LA PERSONA TENGA CARPETA FAMILIAR EN SISTEMA ***********/

                $sql_int = " SELECT idintegrante_cf, idcarpeta_familiar FROM integrante_cf WHERE idnombre='$row_n[0]' ORDER BY idintegrante_cf LIMIT 1 ";
                $result_int = mysqli_query($link,$sql_int);
                if ($row_int = mysqli_fetch_array($result_int)) {
                    
                $sql_cf = " SELECT idcarpeta_familiar, iddepartamento, idestablecimiento_salud FROM carpeta_familiar WHERE idcarpeta_familiar='$row_int[1]' ";
                $result_cf = mysqli_query($link,$sql_cf);
                $row_cf = mysqli_fetch_array($result_cf);

                $idintegrante_cf = $row_int[0];
                $idnombre_integrante = $row_n[0];
                $idcarpeta_familiar = $row_cf[0];
                $iddepartamento = $row_cf[1];
                $idestablecimiento_salud = $row_cf[2];

                $_SESSION['edad_ss'] = $edad_ss;
                $_SESSION['idintegrante_cf_ss'] = $idintegrante_cf;
                $_SESSION['idnombre_integrante_ss'] = $idnombre_integrante;
                $_SESSION['idcarpeta_familiar_ss'] = $idcarpeta_familiar;
                $_SESSION['iddepartamento_ss'] = $iddepartamento_enc;
                $_SESSION['idestablecimiento_salud_ss'] = $idestablecimiento_salud_enc;

                    header("Location:mostrar_persona_hc_enc.php");

                } else {

                /************* VERIFICAMOS QUE LA PERSONA NO TENGA HISTORIA CLINICA PREVIA ***********/

                    $sql_ps = " SELECT idatencion_psafci, iddepartamento, idestablecimiento_salud, idnacion FROM atencion_psafci WHERE idnombre ='$row_n[0]'  ";
                    $result_ps = mysqli_query($link,$sql_ps);
                    if ($row_ps = mysqli_fetch_array($result_ps)) {

                        $_SESSION['edad_ss'] = $edad;
                        $_SESSION['idnombre_paciente_ss'] = $row_n[0];
                        $_SESSION['iddepartamento_ss'] = $row_ps[1];
                        $_SESSION['idestablecimiento_salud_ss'] = $row_ps[2];
                        $_SESSION['idnacion_ss'] = $row_ps[3];

                        header("Location:mostrar_persona_nhc_enc.php");

                    } else {

                    /************* EL NOMBRE DE LA PERSONA EXISTE EN BASE DE DATOS PERO NO TIENE HISTORIA CLINICA ***********/

                            $_SESSION['edad_ss'] = $edad_ss;
                            $_SESSION['idnombre_paciente_ss'] = $row_n[0];
                            $_SESSION['iddepartamento_ss'] = $iddepartamento_enc;
                            $_SESSION['idestablecimiento_salud_ss'] = $idestablecimiento_salud_enc;
                            $_SESSION['idnacion_ss'] = '33';
                
                        header("Location:registrar_persona_hc_enc.php");
                        
                    }           
            }

        } else {

            /********** GUARDAMOS EL REGISTRO DE ENCUESTA PARA LA NUEVA PERSONA  ***********/

        $sql_c = " INSERT INTO nombre (paterno, materno, nombre, ci, exp, fecha_nac, complemento, idnacionalidad, idgenero) ";
        $sql_c.= " VALUES ('$paterno','$materno','$nombre','$ci','','$fecha_nac','$complemento','$idnacionalidad','$idgenero') ";
        $result_c = mysqli_query($link,$sql_c);   
        $idnombre_paciente_ss = mysqli_insert_id($link);  

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

        $edad_new = ($ano-$anonaz);

        $_SESSION['edad_ss'] = $edad_new;

        $_SESSION['idnombre_paciente_ss'] = $idnombre_paciente_ss;

        $idnacion = '33';

        $sql_int    = " SELECT idgenero FROM nombre WHERE idnombre ='$idnombre_paciente_ss' ";
        $result_int = mysqli_query($link,$sql_int);
        $row_int    = mysqli_fetch_array($result_int);

        $idgenero       = $row_int[0];

            /*************** GUARDAMOS EL REGSITRO DE UNA ATENCION MEDICA PREVENTIVA *********/

            $sqlma    = " SELECT MAX(correlativo) FROM atencion_psafci WHERE gestion='$gestion' ";
            $resultma = mysqli_query($link,$sqlma);
            $rowma    = mysqli_fetch_array($resultma);

            $correlativoa = $rowma[0]+1;

            $codigoa = "PSAFCI-ATENCION-".$correlativoa."/".$gestion;

            $sql0 = " INSERT INTO atencion_psafci (iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idnombre, edad, idgenero, ";
            $sql0.= " idrepeticion, idtipo_consulta, idtipo_atencion, idnacion, codigo, correlativo, gestion, fecha_registro, hora_registro, idusuario)  ";
            $sql0.= " VALUES ('$iddepartamento_enc','$idred_salud_enc','$idmunicipio_enc','$idestablecimiento_salud_enc','$idnombre_paciente_ss','$edad_new','$idgenero', ";
            $sql0.= " '$idrepeticion','$idtipo_consulta','6','$idnacion','$codigoa','$correlativoa','$gestion', '$fecha','$hora','$idusuario_ss')";
            $result0 = mysqli_query($link,$sql0);   
            $idatencion_psafci = mysqli_insert_id($link);

            $_SESSION['idatencion_psafci_ss'] = $idatencion_psafci;


        $sqlm    = " SELECT MAX(correlativo) FROM encuesta_psafci WHERE gestion='$gestion'";
        $resultm = mysqli_query($link,$sqlm);
        $rowm    = mysqli_fetch_array($resultm);

        $correlativo = $rowm[0]+1;

        $codigo = "MSYD/APS-ENC-".$correlativo."/".$gestion; 

            $sql0 = " INSERT INTO encuesta_psafci (iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idatencion_psafci, correlativo, codigo, idnombre,";
            $sql0.= " idtema_encuesta, idrepeticion, idtipo_consulta, gestion, idclasificacion_riesgo_cancer, fecha_registro, hora_registro, idusuario) ";
            $sql0.= " VALUES ('$iddepartamento_enc','$idred_salud_enc','$idmunicipio_enc','$idestablecimiento_salud_enc','$idatencion_psafci','$correlativo','$codigo','$idnombre_paciente_ss',";
            $sql0.= " '$idtema_encuesta','$idrepeticion','$idtipo_consulta','$gestion','$idclasificacion_riesgo_cancer','$fecha','$hora','$idusuario_ss')";
            $result0 = mysqli_query($link,$sql0); 
            $idencuesta_psafci = mysqli_insert_id($link); 

            $_SESSION['idencuesta_psafci_ss'] = $idencuesta_psafci;


                $sql1 = " INSERT INTO signo_vital_psafci (idatencion_psafci, idnombre, edad, frec_cardiaca, peso, talla, frec_respiratoria, presion_arterial, presion_arterial_d, temperatura, perimetro_cefalico, fecha_registro, hora_registro, idusuario) ";
                $sql1.= " VALUES ('$idatencion_psafci','$idnombre_paciente_ss','$edad_new','$frec_cardiaca','$peso','$talla','$frec_respiratoria','$presion_arterial','$presion_arterial_d','$temperatura','$perimetro_cefalico','$fecha','$hora','$idusuario_ss') ";
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

            header("Location:mostrar_encuesta_prev_nhc.php");

        }  
    }

?>