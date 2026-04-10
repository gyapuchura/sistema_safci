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

$sql_dg = " INSERT INTO diagnostico_psafci (idatencion_psafci, subjetivo, objetivo, analisis, plan, motivo_consulta, idpatologia, fecha_registro, hora_registro, idusuario) ";
$sql_dg.= " VALUES ('$idatencion_psafci','$subjetivo','$objetivo','$analisis','$plan','$motivo_consulta','$idpatologia_ap_sano','$fecha','$hora','$idusuario_ss') ";
$result_dg = mysqli_query($link,$sql_dg);   

    $imc_i = $peso*10000/$talla**2;  //** Estatura en centimetros */
    $imc = number_format($imc_i, 6, '.', '');

    $sql1 = " INSERT INTO signo_vital_psafci (idatencion_psafci,idnombre, edad, frec_cardiaca, peso, talla, frec_respiratoria, presion_arterial, presion_arterial_d, temperatura, saturacion, imc, alergia, descripcion_alergia, fecha_registro, hora_registro, idusuario) ";
    $sql1.= " VALUES ('$idatencion_psafci','$idnombre_integrante_ss','$edad_ss','$frec_cardiaca','$peso','$talla','$frec_respiratoria','$presion_arterial','$presion_arterial_d','$temperatura','$saturacion','$imc','$alergia','$descripcion_alergia','$fecha','$hora','$idusuario_ss') ";
    $result1 = mysqli_query($link,$sql1);

switch ($idpatologia_ap_sano) {
    case 239:

        $idnombre_madre  = $_POST['idnombre_madre'];
        $direccion_domicilio  = $_POST['direccion_domicilio'];
        $celular_madre   = $_POST['celular_madre'];
        $cuenta_madre    = $_POST['cuenta_madre'];
        $fecha_inscripcion_bono  = $_POST['fecha_inscripcion_bono'];

        $sql_con = " SELECT count(diagnostico_psafci.iddiagnostico_psafci) FROM diagnostico_psafci, atencion_psafci WHERE diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci ";
        $sql_con.= " AND atencion_psafci.idnombre='$idnombre_integrante_ss' AND idpatologia='$idpatologia_ap_sano' ";
        $result_con = mysqli_query($link,$sql_con);
        $row_con    = mysqli_fetch_array($result_con);  
        $numero_controles = $row_con[0];     

    $sql_bj = " INSERT INTO bono_nino_sano (iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idnombre_nino, idnombre_madre, numero_controles, nino_carpetizado, direccion_domicilio, celular_madre, cuenta_madre, fecha_inscripcion_bono, fecha_registro, hora_registro, idusuario) ";
    $sql_bj.= " VALUES ('$iddepartamento','$idred_salud','$idmunicipio','$idestablecimiento_salud_ss','$idnombre_integrante_ss','$idnombre_madre','$numero_controles','SI','$direccion_domicilio','$celular_madre','$cuenta_madre','$fecha_inscripcion_bono','$fecha','$hora','$idusuario_ss') ";
    $result_bj = mysqli_query($link,$sql_bj);

        break;
    
    default:
        
        break;
}


$_SESSION['idatencion_psafci_ss'] = $idatencion_psafci;

header("Location:mostrar_atencion_psafci.php");
      
?>