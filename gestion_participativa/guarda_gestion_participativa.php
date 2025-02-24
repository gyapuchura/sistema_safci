<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$fecha 	 = date("Y-m-d");
$hora    = date("H:i");
$gestion = date("Y");

//-----DATOS ENVIADOS EN EL FORMULARIO DE ESTABLECIMIENTO DE SALUD ----- //

$iddepartamento          = $_POST['iddepartamento'];
$idred_salud             = $_POST['idred_salud'];
$idmunicipio             = $_POST['idmunicipio'];
$numero_areas_influencia = $_POST['numero_areas_influencia'];
$numero_als              = $_POST['numero_als'];
$numero_eess             = $_POST['numero_eess'];
$numero_cls              = $_POST['numero_cls'];
$cosomusa                = $_POST['cosomusa'];
$autoridad_cosomusa      = $link->real_escape_string($_POST['autoridad_cosomusa']);
$autoridad_vigencia      = $_POST['autoridad_vigencia'];
$autoridad_celular       = $_POST['autoridad_celular'];
$plan_municipal          = $_POST['plan_municipal'];
$ley_municipal           = $_POST['ley_municipal'];
$proyectos_planificados  = $_POST['proyectos_planificados'];
$proyectos_ejecutados    = $_POST['proyectos_ejecutados'];
$idvigencia_convenio     = $_POST['idvigencia_convenio'];
$asignacion_presupuestaria = $_POST['asignacion_presupuestaria'];
$med_trad_con_rumetrap     = $_POST['med_trad_con_rumetrap'];
$parteras_con_rumetrap     = $_POST['parteras_con_rumetrap'];
$med_trad_sin_rumetrap     = $_POST['med_trad_sin_rumetrap'];
$parteras_sin_rumetrap     = $_POST['parteras_sin_rumetrap'];
$salas_parto_intercultural = $_POST['salas_parto_intercultural'];
$referencias_medicina_tradicional = $_POST['referencias_medicina_tradicional'];

            $sql_d = "SELECT sigla FROM departamento WHERE iddepartamento='$iddepartamento' ";
            $result_d = mysqli_query($link,$sql_d);
            $row_d = mysqli_fetch_array($result_d);

            $departamento = $row_d[0];

            $sqlm = "SELECT MAX(correlativo) FROM gestion_participativa WHERE gestion='$gestion' "; 
            $resultm = mysqli_query($link,$sqlm);
            $rowm = mysqli_fetch_array($resultm);

            $correlativo=$rowm[0]+1;

            $codigo="SAFCI/GP/".$departamento."-".$correlativo."/".$gestion;

        $sql8 = " INSERT INTO gestion_participativa (iddepartamento, idred_salud, idmunicipio, numero_areas_influencia, numero_als, numero_eess, numero_cls, cosomusa, autoridad_cosomusa, ";
        $sql8.= " autoridad_vigencia, autoridad_celular, plan_municipal, ley_municipal, proyectos_planificados, proyectos_ejecutados, idvigencia_convenio, ";
        $sql8.= " asignacion_presupuestaria, med_trad_con_rumetrap, parteras_con_rumetrap, med_trad_sin_rumetrap, parteras_sin_rumetrap, salas_parto_intercultural,";
        $sql8.= " referencias_medicina_tradicional, correlativo, gestion, codigo, fecha_registro, hora_registro, idusuario) ";
        $sql8.= " VALUES ('$iddepartamento','$idred_salud','$idmunicipio','$numero_areas_influencia','$numero_als','$numero_eess','$numero_cls','$cosomusa','$autoridad_cosomusa', ";
        $sql8.= " '$autoridad_vigencia','$autoridad_celular','$plan_municipal','$ley_municipal','$proyectos_planificados','$proyectos_ejecutados','$idvigencia_convenio', ";
        $sql8.= " '$asignacion_presupuestaria','$med_trad_con_rumetrap','$parteras_con_rumetrap','$med_trad_sin_rumetrap','$parteras_sin_rumetrap','$salas_parto_intercultural',";
        $sql8.= " '$referencias_medicina_tradicional','$correlativo','$gestion','$codigo','$fecha','$hora','$idusuario_ss') ";
        $result8 = mysqli_query($link,$sql8);  
        $idgestion_participativa = mysqli_insert_id($link);

        $_SESSION['idgestion_participativa_ss'] = $idgestion_participativa;  
    
        header("Location:mostrar_gestion_participativa.php");
    
?>
