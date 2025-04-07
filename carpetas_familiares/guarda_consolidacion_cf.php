<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha 	 = date("Y-m-d");
$hora    = date("H:i");
$gestion = date("Y");

$idusuario_ss  = $_SESSION['idusuario_ss'];
$idnombre_ss   = $_SESSION['idnombre_ss'];
$perfil_ss     = $_SESSION['perfil_ss'];

$idcarpeta_familiar_ss  = $_SESSION['idcarpeta_familiar_ss'];


$sql_t = " SELECT ididioma_cf FROM idioma_cf WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
$result_t = mysqli_query($link,$sql_t);
    if (!($row_t = mysqli_fetch_array($result_t))) {

        $verificar = 'PUNTO 2 : IDIOMA';
        $_SESSION['verificar_ss']     = $verificar;
        header("Location:mensaje_verificar.php");

    } else {

    $sql_t = " SELECT idtransporte_cf FROM transporte_cf WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
    $result_t = mysqli_query($link,$sql_t);    
    if (!($row_t = mysqli_fetch_array($result_t))) {

        $verificar = 'PUNTO 2 : TRANSPORTE ';
        $_SESSION['verificar_ss']     = $verificar;
        header("Location:mensaje_verificar.php");

    } else {
    $sql_t = " SELECT idintegrante_cf FROM integrante_cf WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
    $result_t = mysqli_query($link,$sql_t);    
    if (!($row_t = mysqli_fetch_array($result_t))) {

        $verificar = 'PUNTO 3 : INTEGRANTES DE LA FAMILIA ';
        $_SESSION['verificar_ss']     = $verificar;
        header("Location:mensaje_verificar.php");

        } else {

            $sql_in = " SELECT count(idintegrante_cf) FROM integrante_cf WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
            $result_in = mysqli_query($link,$sql_in);    
            $row_in = mysqli_fetch_array($result_in);
            $integrantes = $row_in[0];

            $sql_1 = " SELECT idintegrante_cf FROM integrante_datos_cf WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' GROUP BY idintegrante_cf ";
            $result_1 = mysqli_query($link,$sql_1);  
            $integrantes_datos = mysqli_num_rows($result_1);  

            if (!($integrantes == $integrantes_datos)) {

                $verificar = 'PUNTO 4 : DATOS DE TODOS LOS INTEGRANTES ';
                $_SESSION['verificar_ss']     = $verificar;
                header("Location:mensaje_verificar.php");

                } else {

    $sql_2 = " SELECT idintegrante_cf FROM integrante_subsector_salud WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' GROUP BY idintegrante_cf ";
    $result_2 = mysqli_query($link,$sql_2);  
    $integrantes_sub = mysqli_num_rows($result_2);  
    if (!($integrantes_sub >= $integrantes)) {

        $verificar = 'PUNTO 6 : SUBSECTOR SALUD DE TODOS LOS INTEGRANTES';
        $_SESSION['verificar_ss']     = $verificar;
        header("Location:mensaje_verificar.php");

        } else {   

    $sql_3 = " SELECT idintegrante_cf FROM integrante_beneficiario WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' GROUP BY idintegrante_cf ";
    $result_3 = mysqli_query($link,$sql_3); 
    $integrante_ben = mysqli_num_rows($result_3);   
    if (!($integrante_ben >= $integrantes)) {

        $verificar = 'PUNTO 7 : PROGRAMAS SOCIALES EN TODOS LOS INTEGRANTES';
        $_SESSION['verificar_ss']     = $verificar;

        header("Location:mensaje_verificar.php");
    } else {
        
        $sql_4 = " SELECT idintegrante_cf FROM integrante_tradicional WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' GROUP BY idintegrante_cf ";
        $result_4 = mysqli_query($link,$sql_4);   
        $integrante_trad = mysqli_num_rows($result_4); 
        if (!($integrante_trad >= $integrantes)) {

        $verificar = 'PUNTO 8 : MEDICINA TRADICIONAL EN TODOS LOS INTEGRANTES';
        $_SESSION['verificar_ss']     = $verificar;
        header("Location:mensaje_verificar.php");

    } else {

        $sql_5 = " SELECT idintegrante_cf FROM integrante_defuncion WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' GROUP BY idintegrante_cf";
        $result_5 = mysqli_query($link,$sql_5);   
        $integrante_def = mysqli_num_rows($result_5); 
        if (!($integrante_def >= $integrantes)) {

        $verificar = 'PUNTO 9 : DEFUNCIÓN O NO DEFUNCIÓN DE TODOS LOS INTEGRANTES ';
        $_SESSION['verificar_ss']     = $verificar;
        header("Location:mensaje_verificar.php");

    } else {

        $sql_soc = " SELECT idsocio_economica FROM socio_economica_cf WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
        $result_soc = mysqli_query($link,$sql_soc);   
        $socioeconomia = mysqli_num_rows($result_soc); 
        if (!($socioeconomia == '10')) {

        $verificar = 'PUNTO 12 : CARACTERÍSTICAS SOCIOECONÓMICAS';
        $_SESSION['verificar_ss']     = $verificar;
        header("Location:mensaje_verificar.php");
        
    } else {
    $sql_t = " SELECT idtenencia_animales_cf FROM tenencia_animales_cf WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
    $result_t = mysqli_query($link,$sql_t);    
    if (!($row_t = mysqli_fetch_array($result_t))) {
        $verificar = 'PUNTO 13 : TENENCIA DE ANIMALES';
        $_SESSION['verificar_ss']     = $verificar;
        header("Location:mensaje_verificar.php");
       } else {
    $sql_t = " SELECT idestructura_familiar_cf FROM estructura_familiar_cf WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
    $result_t = mysqli_query($link,$sql_t);    
    if (!($row_t = mysqli_fetch_array($result_t))) {
        $verificar = 'PUNTO 14 : ESTRUCTURA FAMILIAR';
        $_SESSION['verificar_ss']     = $verificar;
        header("Location:mensaje_verificar.php");
    } else {
    $sql_t = " SELECT idetapa_familiar_cf FROM etapa_familiar_cf WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
    $result_t = mysqli_query($link,$sql_t);    
    if (!($row_t = mysqli_fetch_array($result_t))) {
        $verificar = 'PUNTO 15 : ETAPA DEL CICLO VITAL FAMILIAR';
        $_SESSION['verificar_ss']     = $verificar;
        header("Location:mensaje_verificar.php");
    } else {
    $sql_t = " SELECT idfuncionalidad_familiar_cf FROM funcionalidad_familiar_cf WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
    $result_t = mysqli_query($link,$sql_t);    
    if (!($row_t = mysqli_fetch_array($result_t))) {
        $verificar = 'PUNTO 16.2 : FUNCIONALIDAD FAMILIAR';
        $_SESSION['verificar_ss']     = $verificar;
        header("Location:mensaje_verificar.php");
    } else {
    $sql_t = " SELECT idevaluacion_salud_familiar_cf FROM evaluacion_salud_familiar_cf WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
    $result_t = mysqli_query($link,$sql_t);    
    if (!($row_t = mysqli_fetch_array($result_t))) {
        $verificar = 'NO SE HA GUARDADO EL PUNTO 17 : EVALUACIÓN DE LA SALUD FAMILIAR ';
        $_SESSION['verificar_ss']     = $verificar;
        header("Location:mensaje_verificar.php");
        } else {
    $sql_t = " SELECT idayuda_familiar_cf FROM ayuda_familiar_cf WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
    $result_t = mysqli_query($link,$sql_t);    
    if (!($row_t = mysqli_fetch_array($result_t))) {
        $verificar = 'EL PUNTO 18 : FORMA DE AYUDA FAMILIAR NECESARIA';
        $_SESSION['verificar_ss']     = $verificar;
        header("Location:mensaje_verificar.php");
    } else {
    $sql_t = " SELECT idevaluacion_familiar_cf FROM evaluacion_familiar_cf WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
    $result_t = mysqli_query($link,$sql_t);    
    if (!($row_t = mysqli_fetch_array($result_t))) {
        $verificar = 'NO HA GUARDADO EL PUNTO 19 : EVALUACIÓN DE SALUD FAMILIAR';
        $_SESSION['verificar_ss']     = $verificar;
        header("Location:mensaje_verificar.php");
    } else {


        
        /************** guardar consolidacion de carpeta familiar **************/ 

        $sql_d = " SELECT departamento.sigla FROM departamento, ubicacion_cf, carpeta_familiar WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
        $sql_d.= " AND ubicacion_cf.iddepartamento=departamento.iddepartamento AND carpeta_familiar.idcarpeta_familiar='$idcarpeta_familiar_ss' ";
        $result_d = mysqli_query($link,$sql_d);
        $row_d = mysqli_fetch_array($result_d);
    
        $departamento_sigla = $row_d[0];
    
        $correlativo = $idcarpeta_familiar_ss;
    
        $codigo="SAFCI/".$departamento_sigla."-CF-".$correlativo."/".$gestion;

        $sql_a = " UPDATE carpeta_familiar SET estado='CONSOLIDADO', codigo='$codigo', correlativo='$correlativo' ";
        $sql_a.= " WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
        $result_a = mysqli_query($link,$sql_a);  

        header("Location:mensaje_consolidacion_cf.php");

    } } } } } } } } } } } } } } } }
    
        /*********** Guarda el registro de dterminante de la salud (END) *************/
?>