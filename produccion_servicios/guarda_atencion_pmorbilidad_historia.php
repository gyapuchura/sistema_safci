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


$idestablecimiento_salud_ss = $_POST['idestablecimiento_salud'];
$idnombre_integrante_ss     = $_POST['idnombre_integrante'];
$edad_ss                    = $_POST['edad'];
$idnacion                   = $_POST['idnacion'];

/*********** ENVIO DATOS DEL PÀCIENTE *************/

$idrepeticion    = $_POST['idrepeticion'];
$idtipo_consulta = $_POST['idtipo_consulta'];
$idtipo_atencion = $_POST['idtipo_atencion'];
$fecha   = $_POST['fecha_registro'];

$talla              = $_POST['talla'];
$peso               = $_POST['peso'];
$temperatura        = $_POST['temperatura'];
$frec_cardiaca      = $_POST['frec_cardiaca'];
$frec_respiratoria  = $_POST['frec_respiratoria'];
$presion_arterial   = $_POST['presion_arterial'];
$presion_arterial_d = $_POST['presion_arterial_d'];
$saturacion         = $_POST['saturacion'];
$alergia            = $_POST['alergia'];
$descripcion_alergia  = $link->real_escape_string($_POST['descripcion_alergia']);

$subjetivo  = $link->real_escape_string($_POST['subjetivo']);
$objetivo   = $link->real_escape_string($_POST['objetivo']);
$analisis   = $link->real_escape_string($_POST['analisis']);
$plan       = $link->real_escape_string($_POST['plan']);

/*********** PRUEBA DE VARIABLES *************/

/*********** PRUEBA DE VARIABLES *************/
$sql_e    = " SELECT iddepartamento, idred_salud, idmunicipio FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud_ss' ";
$result_e = mysqli_query($link,$sql_e);
$row_e    = mysqli_fetch_array($result_e);

$sql_int    = " SELECT idgenero FROM nombre WHERE idnombre ='$idnombre_integrante_ss' ";
$result_int = mysqli_query($link,$sql_int);
$row_int    = mysqli_fetch_array($result_int);

$iddepartamento = $row_e[0];
$idred_salud    = $row_e[1];
$idmunicipio    = $row_e[2];
$idgenero       = $row_int[0];

$sqlm    = " SELECT MAX(correlativo) FROM atencion_psafci WHERE gestion='$gestion' ";
$resultm = mysqli_query($link,$sqlm);
$rowm    = mysqli_fetch_array($resultm);

$correlativo = $rowm[0]+1;

$codigo = "PSAFCI-ATENCION-".$correlativo."/".$gestion;

   
$sql0 = " INSERT INTO atencion_psafci (iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idnombre, edad, idgenero, ";
$sql0.= " idrepeticion, idtipo_consulta, idtipo_atencion, idnacion, codigo, correlativo,  gestion, fecha_registro, hora_registro, idusuario)  ";
$sql0.= " VALUES ('$iddepartamento','$idred_salud','$idmunicipio','$idestablecimiento_salud_ss','$idnombre_integrante_ss','$edad_ss','$idgenero', ";
$sql0.= " '$idrepeticion','$idtipo_consulta','$idtipo_atencion','$idnacion','$codigo','$correlativo','$gestion', '$fecha','$hora','$idusuario_ss')";
$result0 = mysqli_query($link,$sql0);   
$idatencion_psafci = mysqli_insert_id($link);


    $imc_i = $peso*10000/$talla**2;  //** Estatura en centimetros */
    $imc = number_format($imc_i, 6, '.', '');

    $sql1 = " INSERT INTO signo_vital_psafci (idatencion_psafci,idnombre, edad, frec_cardiaca, peso, talla, frec_respiratoria, presion_arterial, presion_arterial_d, temperatura, saturacion, imc, alergia, descripcion_alergia, fecha_registro, hora_registro, idusuario) ";
    $sql1.= " VALUES ('$idatencion_psafci','$idnombre_integrante_ss','$edad_ss','$frec_cardiaca','$peso','$talla','$frec_respiratoria','$presion_arterial','$presion_arterial_d','$temperatura','$saturacion','$imc','$alergia','$descripcion_alergia','$fecha','$hora','$idusuario_ss') ";
    $result1 = mysqli_query($link,$sql1);


        foreach($_POST['idpatologia'] as $clave => $idpatologia_i) {

            $sql_dg = " INSERT INTO diagnostico_psafci (idatencion_psafci, motivo_consulta, subjetivo, objetivo, analisis, plan, idpatologia, fecha_registro, hora_registro, idusuario) ";
            $sql_dg.= " VALUES ('$idatencion_psafci','','$subjetivo','$objetivo','$analisis','$plan','$idpatologia_i','$fecha','$hora','$idusuario_ss') ";
            $result_dg = mysqli_query($link,$sql_dg);  
            $iddiagnostico_psafci = mysqli_insert_id($link);
            }

        foreach($_POST['idmedicamento'] as $clavem => $idmedicamento_i) {

            $sql_tm    = " SELECT idtipo_medicamento FROM medicamento WHERE idmedicamento='$idmedicamento_i' ";
            $result_tm = mysqli_query($link,$sql_tm);
            $row_tm    = mysqli_fetch_array($result_tm);

            $sql_tr = " INSERT INTO tratamiento_psafci (idatencion_psafci, iddiagnostico_psafci, idtipo_medicamento, idmedicamento, fecha_registro, hora_registro, idusuario) ";
            $sql_tr.= " VALUES ('$idatencion_psafci','$iddiagnostico_psafci','$row_tm[0]','$idmedicamento_i','$fecha','$hora','$idusuario_ss') ";
            $result_tr = mysqli_query($link,$sql_tr);  
                  
            }

        $_SESSION['idatencion_psafci_ss'] = $idatencion_psafci;
        header("Location:mostrar_atencion_psafci_ncf.php");
    
?>