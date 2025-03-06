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

$idmedicina_tradicional_con = $_POST['idmedicina_tradicional_con'];
$cantidad_con               = $_POST['cantidad_con'];

$idmedicina_tradicional_sin = $_POST['idmedicina_tradicional_sin'];
$cantidad_sin               = $_POST['cantidad_sin'];

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
        $sql8.= " asignacion_presupuestaria, salas_parto_intercultural,";
        $sql8.= " referencias_medicina_tradicional, correlativo, gestion, codigo, fecha_registro, hora_registro, idusuario) ";
        $sql8.= " VALUES ('$iddepartamento','$idred_salud','$idmunicipio','$numero_areas_influencia','$numero_als','$numero_eess','$numero_cls','$cosomusa','$autoridad_cosomusa', ";
        $sql8.= " '$autoridad_vigencia','$autoridad_celular','$plan_municipal','$ley_municipal','$proyectos_planificados','$proyectos_ejecutados','$idvigencia_convenio', ";
        $sql8.= " '$asignacion_presupuestaria','$salas_parto_intercultural',";
        $sql8.= " '$referencias_medicina_tradicional','$correlativo','$gestion','$codigo','$fecha','$hora','$idusuario_ss') ";
        $result8 = mysqli_query($link,$sql8);  
        $idgestion_participativa = mysqli_insert_id($link);

            //* medicos con rumetrap ****/
        $numero=0;
        $sql_m =" SELECT idmedicina_tradicional, medicina_tradicional FROM medicina_tradicional WHERE idmedicina_tradicional != '5' ";
        $result_m = mysqli_query($link,$sql_m);
        if ($row_m = mysqli_fetch_array($result_m)){
        mysqli_field_seek($result_m,0);
        while ($field_m = mysqli_fetch_field($result_m)){
        } do {

            $sql0 = " INSERT INTO medicina_tradicional_gp (idgestion_participativa, idmedicina_tradicional, runetrap, numero_med_trad, fecha_registro, hora_registro, idusuario) ";
            $sql0.= " VALUES ('$idgestion_participativa','$idmedicina_tradicional_con[$numero]','CON RUMETRAP','$cantidad_con[$numero]','$fecha','$hora','$idusuario_ss') ";
            $result0 = mysqli_query($link,$sql0); 

            $numero=$numero+1;  
        }
        while ($row_m = mysqli_fetch_array($result_m));
        } else {
        }

            //* medicos sin rumetrap ****/

        $numero=0;
        $sql_s =" SELECT idmedicina_tradicional, medicina_tradicional FROM medicina_tradicional WHERE idmedicina_tradicional != '5' ";
        $result_s = mysqli_query($link,$sql_s);
        if ($row_s = mysqli_fetch_array($result_s)){
        mysqli_field_seek($result_s,0);
        while ($field_s = mysqli_fetch_field($result_s)){
        } do {

            $sql1 = " INSERT INTO medicina_tradicional_gp (idgestion_participativa, idmedicina_tradicional, runetrap, numero_med_trad, fecha_registro, hora_registro, idusuario) ";
            $sql1.= " VALUES ('$idgestion_participativa','$idmedicina_tradicional_sin[$numero]','SIN RUMETRAP','$cantidad_sin[$numero]','$fecha','$hora','$idusuario_ss') ";
            $result1 = mysqli_query($link,$sql1); 

            $numero=$numero+1;  
        }
        while ($row_s = mysqli_fetch_array($result_s));
        } else {
        }


        $_SESSION['idgestion_participativa_ss'] = $idgestion_participativa;  
    
        header("Location:mostrar_gestion_participativa.php");
    
?>
