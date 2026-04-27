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

$sql_id    = " SELECT idnivel_instruccion FROM integrante_datos_cf WHERE idintegrante_cf ='$idintegrante_cf_ss' ";
$result_id = mysqli_query($link,$sql_id);
$row_id    = mysqli_fetch_array($result_id);

$sql_af    = " SELECT idarea_influencia FROM carpeta_familiar WHERE idcarpeta_familiar ='$idcarpeta_familiar_ss' ";
$result_af = mysqli_query($link,$sql_af);
$row_af    = mysqli_fetch_array($result_af);

$iddepartamento = $row_e[0]; 
$idred_salud    = $row_e[1];
$idmunicipio    = $row_e[2];
$idarea_influencia = $row_af[0];

$idgenero       = $row_int[0];
$idnacion       = $row_nac[0];

$sqlm    = " SELECT MAX(correlativo) FROM historia_perinatal WHERE gestion='$gestion'  ";
$resultm = mysqli_query($link,$sqlm);
$rowm    = mysqli_fetch_array($resultm);

$correlativo = $rowm[0]+1;

$codigo = "MSYD-HCP-".$correlativo."/".$gestion;

$fecha  = $_POST['fecha_reg'];

$anos_mayor_nivel  = $_POST['anos_mayor_nivel'];
$vive_sola         = $_POST['vive_sola'];

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
$f_fea            = $_POST['fecha_fea'];
if ($f_fea == '') {
    $fecha_fea = '0000-00-00';
} else {
    $fecha_fea = $f_fea ;
}
$menos_ano            = $_POST['menos_ano'];

$embarazo_planeado      = $_POST['embarazo_planeado'];
$idmetodo_anticonceptivo  = $_POST['idmetodo_anticonceptivo'];

$peso_anterior   = $_POST['peso_anterior'];
$talla   = $_POST['talla'];
$idesno          = $_POST['idesno'];
$fecha_fum       = $_POST['fecha_fum'];
$eg_fum          = $_POST['eg_fum'];
$eco_veinte      = $_POST['eco_veinte'];
$fecha_pp        = $_POST['fecha_pp'];
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
$idnivel_instruccion = $row_id[0];

if ($idnivel_instruccion =='1' || $idnivel_instruccion =='2' || $idnivel_instruccion =='3') {
    $alfabeta = 'NO';
} else {
    $alfabeta = 'SI';
}

    $sql_hp = " SELECT idhistoria_perinatal, codigo FROM historia_perinatal WHERE idnombre='$idnombre_integrante_ss' ";
    $result_hp = mysqli_query($link,$sql_hp);
    if ($row_hp = mysqli_fetch_array($result_hp)){

    header("Location:mensaje_hcp_existe.php");
            
    } else {
       
            $sql0 = " INSERT INTO historia_perinatal (iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idarea_influencia, correlativo, codigo, idnombre,  ";
            $sql0.= " idnacion, alfabeta, idnivel_instruccion, anos_mayor_nivel, vive_sola, gestion, fecha_registro, hora_registro, idusuario)  ";
            $sql0.= " VALUES ('$iddepartamento','$idred_salud','$idmunicipio','$idestablecimiento_salud_ss','$idarea_influencia','$correlativo','$codigo','$idnombre_integrante_ss', ";
            $sql0.= " '$idnacion','$alfabeta','$idnivel_instruccion','$anos_mayor_nivel','$vive_sola','$gestion','$fecha','$hora','$idusuario_ss')";
            $result0 = mysqli_query($link,$sql0);   
            $idhistoria_perinatal = mysqli_insert_id($link);


            $idantecedente_familiar_enf_i = 1;

            foreach($_POST['valor_antecedente_familiar'] as $valor_antecedente_familiar_i) {

            $sql_f = " INSERT INTO antecedente_perinatal (idhistoria_perinatal, idtipo_antecedente_enfermedad, idantecedente_enfermedad, valor_antecedente_perinatal, fecha_registro, hora_registro, idusuario) ";
            $sql_f.= " VALUES ('$idhistoria_perinatal','2','$idantecedente_familiar_enf_i','$valor_antecedente_familiar_i','$fecha','$hora','$idusuario_ss') ";
            $result_f = mysqli_query($link,$sql_f);
            $idantecedente_familiar_enf_i = $idantecedente_familiar_enf_i + 1;
            }

            $idantecedente_personal_enf_i = 1;

            foreach($_POST['valor_antecedente_personal'] as $valor_antecedente_personal_i) {

            $sql_p = " INSERT INTO antecedente_perinatal (idhistoria_perinatal, idtipo_antecedente_enfermedad, idantecedente_enfermedad, valor_antecedente_perinatal, fecha_registro, hora_registro, idusuario) ";
            $sql_p.= " VALUES ('$idhistoria_perinatal','1','$idantecedente_personal_enf_i','$valor_antecedente_personal_i','$fecha','$hora','$idusuario_ss') ";
            $result_p = mysqli_query($link,$sql_p);
            $idantecedente_personal_enf_i = $idantecedente_personal_enf_i + 1;
            }

                $sql_1 = " INSERT INTO antecedente_obstetrico (idhistoria_perinatal, idnombre, gestaciones, partos, abortos, cesareas, nacidos_vivos, viven, nacidos_muertos, muertos_a_semana, ";
                $sql_1.= " muertos_d_semana, vaginales, idultimo_previo, antecedente_gemelos, fecha_fea, menos_ano, embarazo_planeado, idmetodo_anticonceptivo, fecha_registro, hora_registro, idusuario) ";
                $sql_1.= " VALUES ('$idhistoria_perinatal','$idnombre_integrante_ss','$gestaciones','$partos','$abortos','$cesareas','$nacidos_vivos','$viven','$nacidos_muertos','$muertos_a_semana', ";
                $sql_1.= " '$muertos_d_semana','$vaginales','$idultimo_previo','$antecedente_gemelos','$fecha_fea','$menos_ano','$embarazo_planeado','$idmetodo_anticonceptivo','$fecha','$hora','$idusuario_ss') ";
                $result_1 = mysqli_query($link,$sql_1);   
                $idantecedente_obstetrico = mysqli_insert_id($link);

                $sql_2 = " INSERT INTO gestacion (idhistoria_perinatal, idnombre, peso_anterior, talla, idesno, fecha_fum, eg_fum, eco_veinte, fecha_pp, ";
                $sql_2.= " fuma_activo, fuma_pasivo, drogas, alcohol, violencia, idantirubeola, antitetanica, dosis_antitetanica, ex_odontologico, ex_mamas, fecha_registro, hora_registro, idusuario) ";
                $sql_2.= " VALUES ('$idhistoria_perinatal','$idnombre_integrante_ss','$peso_anterior','$talla','$idesno','$fecha_fum','$eg_fum', '$eco_veinte','$fecha_pp', ";
                $sql_2.= " '$fuma_activo','$fuma_pasivo','$drogas','$alcohol','$violencia','$idantirubeola','$antitetanica','$dosis_antitetanica','$ex_odontologico','$ex_mamas','$fecha','$hora','$idusuario_ss') ";
                $result_2 = mysqli_query($link,$sql_2); 

        $_SESSION['idhistoria_perinatal_ss'] = $idhistoria_perinatal;

header("Location:mensaje_nueva_historia_perinatal.php");

}
      
?>