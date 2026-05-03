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

$idhistoria_perinatal_ss    = $_SESSION['idhistoria_perinatal_ss'];

$idcarpeta_familiar_ss      = $_SESSION['idcarpeta_familiar_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idintegrante_cf_ss         = $_SESSION['idintegrante_cf_ss'];
$idnombre_integrante_ss     = $_SESSION['idnombre_integrante_ss'];
$edad_ss                    = $_SESSION['edad_ss'];

/*********** ENVIO DATOS DEL PÀCIENTE *************/

$idhistoria_perinatal  = $_POST['idhistoria_perinatal'];
$anos_mayor_nivel  = $_POST['anos_mayor_nivel'];
$vive_sola         = $_POST['vive_sola'];
$celular           = $_POST['celular'];
$fecha             = $_POST['fecha_reg'];

$idantecedente_obstetrico  = $_POST['idantecedente_obstetrico'];
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
    $fecha_fea = '1111-11-11';
} else {
    $fecha_fea = $f_fea ;
}
$menos_ano            = $_POST['menos_ano'];

$embarazo_planeado      = $_POST['embarazo_planeado'];
$idmetodo_anticonceptivo  = $_POST['idmetodo_anticonceptivo'];

$idgestacion    = $_POST['idgestacion'];
$peso_anterior  = $_POST['peso_anterior'];
$talla          = $_POST['talla'];

$imc_i = $peso_anterior*10000/$talla**2;  //** Estatura en centimetros */
$imc = number_format($imc_i, 6, '.', '');

if ($imc < '18.5') {
    $idesno ='1';
} else {
    if ($imc < '24.9') {
        $idesno ='3';
    } else {
        if ($imc < '29.9') {
            $idesno ='2';
        } else {
            if ($imc >= '29.9') {
                $idesno ='4';
            } else { } } } }


$fecha_fum       = $_POST['fecha_fum'];
$eg_fum          = $_POST['eg_fum'];
$eco_veinte      = $_POST['eco_veinte'];

$fecha_pp        = date('Y-m-d', strtotime('+40 weeks', strtotime($fecha_fum)));

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


            $sql8 =" UPDATE integrante_cf SET celular='$celular' WHERE idintegrante_cf='$idintegrante_cf_ss' ";         
            $result8 = mysqli_query($link,$sql8);
       
            $sql0 = " UPDATE historia_perinatal SET anos_mayor_nivel ='$anos_mayor_nivel', vive_sola='$vive_sola', fecha_registro='$fecha',  ";
            $sql0.= " hora_registro='$hora', idusuario='$idusuario_ss' WHERE idhistoria_perinatal='$idhistoria_perinatal' ";
            $result0 = mysqli_query($link,$sql0);   

            $idantecedente_familiar_enf_i = 1;

            foreach($_POST['valor_antecedente_familiar'] as $valor_antecedente_familiar_i) {

            $sql_f = " UPDATE antecedente_perinatal SET valor_antecedente_perinatal='$valor_antecedente_familiar_i', fecha_registro='$fecha', hora_registro='$hora', idusuario='$idusuario_ss' ";
            $sql_f.= " WHERE idhistoria_perinatal='$idhistoria_perinatal' AND idantecedente_enfermedad='$idantecedente_familiar_enf_i' AND idtipo_antecedente_enfermedad='2' ";
            $result_f = mysqli_query($link,$sql_f);

            $idantecedente_familiar_enf_i = $idantecedente_familiar_enf_i + 1;
            }

            $idantecedente_personal_enf_i = 1;

            foreach($_POST['valor_antecedente_personal'] as $valor_antecedente_personal_i) {

            $sql_p = " UPDATE antecedente_perinatal SET valor_antecedente_perinatal='$valor_antecedente_personal_i', fecha_registro='$fecha', hora_registro='$hora', idusuario='$idusuario_ss' ";
            $sql_p.= " WHERE idhistoria_perinatal='$idhistoria_perinatal' AND idantecedente_enfermedad='$idantecedente_personal_enf_i' AND idtipo_antecedente_enfermedad='1' ";
            $result_p = mysqli_query($link,$sql_p);

            $idantecedente_personal_enf_i = $idantecedente_personal_enf_i + 1;
            }

                $sql_1 = " UPDATE antecedente_obstetrico SET  gestaciones='$gestaciones', partos='$partos', abortos='$abortos', cesareas='$cesareas', ";
                $sql_1.= " nacidos_vivos='$nacidos_vivos', viven='$viven', nacidos_muertos='$nacidos_muertos', muertos_a_semana='$muertos_a_semana', ";
                $sql_1.= " muertos_d_semana='$muertos_d_semana', vaginales='$vaginales', idultimo_previo='$idultimo_previo', antecedente_gemelos='$antecedente_gemelos', ";
                $sql_1.= " fecha_fea='$fecha_fea', menos_ano='$menos_ano', embarazo_planeado='$embarazo_planeado', idmetodo_anticonceptivo='$idmetodo_anticonceptivo',  ";
                $sql_1.= " fecha_registro='$fecha', hora_registro='$hora', idusuario='$idusuario_ss' WHERE idantecedente_obstetrico='$idantecedente_obstetrico' ";
                $result_1 = mysqli_query($link,$sql_1);   

                $sql_2 = " UPDATE gestacion SET peso_anterior='$peso_anterior', talla='$talla', idesno='$idesno', fecha_fum='$fecha_fum', eg_fum='$eg_fum', eco_veinte='$eco_veinte', fecha_pp='$fecha_pp', ";
                $sql_2.= " fuma_activo='$fuma_activo', fuma_pasivo='$fuma_pasivo', drogas='$drogas', alcohol='$alcohol', violencia='$violencia', idantirubeola='$idantirubeola', antitetanica='$antitetanica',  ";
                $sql_2.= " dosis_antitetanica='$dosis_antitetanica', ex_odontologico='$ex_odontologico', ex_mamas='$ex_mamas', fecha_registro='$fecha', hora_registro='$hora', idusuario='$idusuario_ss' ";
                $sql_2.= " WHERE idgestacion='$idgestacion' ";
                $result_2 = mysqli_query($link,$sql_2); 


        $_SESSION['idhistoria_perinatal_ss'] = $idhistoria_perinatal;

header("Location:mensaje_hcp_actualizada.php");
   
?>