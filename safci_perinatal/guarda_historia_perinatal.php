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

$codigo = "MSYD-HCP-".$correlativo."/".$gestion;

$anos_mayor_nivel  = $_POST['anos_mayor_nivel'];
$vive_sola         = $_POST['vive_sola'];

    foreach($_POST['idantecedente_familiar'] as $idantecedente_familiar_i) {

    $sql2 = " INSERT INTO antecedente_perinatal (idhistoria_perinatal, idtipo_antecedente_enfermedad, idantecedente_enfermedad, fecha_registro, hora_registro, idusuario) ";
    $sql2.= " VALUES ('$idhistoria_perinatal','2','$idantecedente_familiar_i','$fecha','$hora','$idusuario_ss') ";
    $result2 = mysqli_query($link,$sql2);

    }

        foreach($_POST['idantecedente_personal'] as $idantecedente_personal_i) {

    $sql2 = " INSERT INTO antecedente_perinatal (idhistoria_perinatal, idtipo_antecedente_enfermedad, idantecedente_enfermedad, fecha_registro, hora_registro, idusuario) ";
    $sql2.= " VALUES ('$idhistoria_perinatal','1','$idantecedente_personal_i','$fecha','$hora','$idusuario_ss') ";
    $result2 = mysqli_query($link,$sql2);

    }

$gestaciones = $_POST['gestaciones'];
$partos      = $_POST['partos'];
$abortos     = $_POST['abortos'];
$cesareas    = $_POST['cesareas'];

$nacidos_vivos   = $_POST['nacidos_vivos'];
$viven           = $_POST['viven'];
$nacidos_muertos = $_POST['nacidos_muertos'];
$muertos_a_semana = $_POST['muertos_a_semana'];
$muertos_d_semana = $_POST['muertos_d_semana'];

$vaginales            = $_POST['vaginales'];
$idultimo_previo      = $_POST['idultimo_previo'];
$antecedente_gemelos  = $_POST['antecedente_gemelos'];
$fecha_fea            = $_POST['fecha_fea'];

$embarazo_planeado      = $_POST['embarazo_planeado'];
$idmetodo_anticonceptivo  = $_POST['idmetodo_anticonceptivo'];

$peso_anterior   = $_POST['peso_anterior'];
$idesno          = $_POST['idesno'];
$fuma_activo     = $_POST['fuma_activo'];
$fuma_pasivo     = $_POST['fuma_pasivo'];
$drogas          = $_POST['drogas'];
$alcohol         = $_POST['alcohol'];
$violencia       = $_POST['violencia'];

$idantirubeola   = $_POST['idantirubeola'];
$antitetanica    = $_POST['antitetanica'];
$dosis_antitetanica = $_POST['dosis_antitetanica'];
$ex_odontologico    = $_POST['ex_odontologico'];
$ex_mamas           = $_POST['ex_mamas'];

/******** GUARDA HISTORIA PERINATAL  ********/


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
        $idparentesco    = $_POST['idparentesco'];
        $direccion_domicilio  = $_POST['direccion_domicilio'];
        $celular_madre   = $_POST['celular_madre'];
        $cuenta_madre    = $_POST['cuenta_madre'];
        $fecha_inscripcion_bono  = $_POST['fecha_inscripcion_bono'];
        $lug_nac_nino    = $link->real_escape_string($_POST['lug_nac_nino']);
        $lug_nac_madre   = $link->real_escape_string($_POST['lug_nac_madre']);

        $sql_con = " SELECT count(diagnostico_psafci.iddiagnostico_psafci) FROM diagnostico_psafci, atencion_psafci WHERE diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci ";
        $sql_con.= " AND atencion_psafci.idnombre='$idnombre_integrante_ss' AND idpatologia='$idpatologia_ap_sano' ";
        $result_con = mysqli_query($link,$sql_con);
        $row_con    = mysqli_fetch_array($result_con);  
        $numero_controles = $row_con[0];   
        
        $sql1 =" SELECT idbono_nino_sano, numero_controles FROM bono_nino_sano WHERE idnombre_nino = '$idnombre_integrante_ss' ";
        $result1 = mysqli_query($link,$sql1);
        if ($row1 = mysqli_fetch_array($result1)){
           
            $sql_bn = " UPDATE bono_nino_sano SET numero_controles = '$numero_controles' WHERE idbono_nino_sano = '$row1[0]' ";
            $result_bn = mysqli_query($link,$sql_bn);

        } else {
       
            $sql_bj    = " SELECT MAX(correlativo) FROM bono_nino_sano WHERE gestion='$gestion'  ";
            $result_bj = mysqli_query($link,$sql_bj);
            $row_bj    = mysqli_fetch_array($result_bj);

            $correlativo_bj = $row_bj[0]+1;

            $codigo_bj = "MSYD-BJA-".$correlativo_bj."/".$gestion;

            $sql_bj = " INSERT INTO bono_nino_sano (codigo, correlativo, iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idarea_influencia, idnombre_nino, idnombre_madre, idparentesco, numero_controles, nino_carpetizado, direccion_domicilio, lug_nac_nino, lug_nac_madre, celular_madre, cuenta_madre, fecha_inscripcion_bono, fecha_registro, hora_registro, gestion, idusuario) ";
            $sql_bj.= " VALUES ('$codigo_bj','$correlativo_bj','$iddepartamento','$idred_salud','$idmunicipio','$idestablecimiento_salud_ss','$idarea_influencia','$idnombre_integrante_ss','$idnombre_madre','$idparentesco','$numero_controles','SI','$direccion_domicilio','$lug_nac_nino','$lug_nac_madre','$celular_madre','$cuenta_madre','$fecha_inscripcion_bono','$fecha','$hora','$gestion','$idusuario_ss') ";
            $result_bj = mysqli_query($link,$sql_bj);

        }

        break;
    
    default:
        
        break;
}


$_SESSION['idatencion_psafci_ss'] = $idatencion_psafci;

header("Location:mostrar_atencion_psafci.php");
      
?>