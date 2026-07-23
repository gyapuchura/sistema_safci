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

$sql_es = " SELECT iddato_laboral, idestablecimiento_salud, iddepartamento FROM dato_laboral WHERE idusuario='$idusuario_ss' ORDER BY iddato_laboral DESC LIMIT 1  ";
$result_es = mysqli_query($link,$sql_es);
$row_es = mysqli_fetch_array($result_es);
$idestablecimiento_salud_ss = $row_es[1];

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

$idpatologia_ap_sano = $_POST['idpatologia_ap_sano'];
$subjetivo  = $link->real_escape_string($_POST['subjetivo']);
$objetivo   = $link->real_escape_string($_POST['objetivo']);
$analisis   = $link->real_escape_string($_POST['analisis']);
$plan       = $link->real_escape_string($_POST['plan']);

$motivo_consulta     = 'S.- '.$subjetivo .' O.- '.$objetivo.' A.- '.$analisis.' P.- '.$plan;

/*********** DETERMINACION DE VARIABLES *************/

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

$iddepartamento = $row_e[0];
$idred_salud    = $row_e[1];
$idmunicipio    = $row_e[2];

$sqlm    = " SELECT MAX(correlativo) FROM atencion_psafci WHERE gestion='$gestion'  ";
$resultm = mysqli_query($link,$sqlm);
$rowm    = mysqli_fetch_array($resultm);

$correlativo = $rowm[0]+1;

$codigo = "PSAFCI-ATENCION-".$correlativo."/".$gestion;

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

        $_SESSION['edad_ss'] = $edad;
        $_SESSION['idintegrante_cf_ss'] = $idintegrante_cf;
        $_SESSION['idnombre_integrante_ss'] = $idnombre_integrante;
        $_SESSION['idcarpeta_familiar_ss'] = $idcarpeta_familiar;
        $_SESSION['iddepartamento_ss'] = $iddepartamento;
        $_SESSION['idestablecimiento_salud_ss'] = $idestablecimiento_salud;

        header("Location:mostrar_persona_hc_mensaje.php");

        } else {
        /************* VERIFICAMOS QUE LA PERSONA NO TENGA ATENCION PREVIA ***********/
        $sql_ps = " SELECT idatencion_psafci, iddepartamento, idestablecimiento_salud, idnacion FROM atencion_psafci WHERE idnombre ='$row_n[0]'  ";
        $result_ps = mysqli_query($link,$sql_ps);
        if ($row_ps = mysqli_fetch_array($result_ps)) {

            $_SESSION['edad_ss'] = $edad;
            $_SESSION['idnombre_paciente_ss'] = $row_n[0];
            $_SESSION['iddepartamento_ss'] = $row_ps[1];
            $_SESSION['idestablecimiento_salud_ss'] = $row_ps[2];
            $_SESSION['idnacion_ss'] = $row_ps[3];

            header("Location:mostrar_persona_nhc_mensaje.php");

        } else {
            header("Location:mensaje_persona_sin_hc.php");
        } 
        }

} else {

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

$sql_dg = " INSERT INTO diagnostico_psafci (idatencion_psafci, subjetivo, objetivo, analisis, plan, motivo_consulta, idpatologia, fecha_registro, hora_registro, idusuario) ";
$sql_dg.= " VALUES ('$idatencion_psafci','$subjetivo','$objetivo','$analisis','$plan','$motivo_consulta','$idpatologia_ap_sano','$fecha','$hora','$idusuario_ss') ";
$result_dg = mysqli_query($link,$sql_dg);  

    $imc_i = $peso*10000/$talla**2;  //** Estatura en centimetros */
    $imc = number_format($imc_i, 6, '.', '');

    $sql1 = " INSERT INTO signo_vital_psafci (idatencion_psafci,idnombre, edad, frec_cardiaca, peso, talla, frec_respiratoria, presion_arterial, presion_arterial_d, temperatura, saturacion, imc, alergia, descripcion_alergia, fecha_registro, hora_registro, idusuario) ";
    $sql1.= " VALUES ('$idatencion_psafci','$idnombre_paciente','$edad','$frec_cardiaca','$peso','$talla','$frec_respiratoria','$presion_arterial','$presion_arterial_d','$temperatura','$saturacion','$imc','$alergia','$descripcion_alergia','$fecha','$hora','$idusuario_ss') ";
    $result1 = mysqli_query($link,$sql1);

$_SESSION['idatencion_psafci_ss'] = $idatencion_psafci;
$_SESSION['idnombre_paciente_ss'] = $idnombre_paciente;
$_SESSION['edad_ss'] = $edad;

header("Location:mostrar_atencion_psafci_ncf.php");
      
    }
?> 