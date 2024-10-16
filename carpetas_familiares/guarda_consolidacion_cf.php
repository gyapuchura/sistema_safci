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

    $sql_t = " SELECT idintegrante_subsector_salud FROM integrante_subsector_salud WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
    $result_t = mysqli_query($link,$sql_t);    
    if (!($row_t = mysqli_fetch_array($result_t))) {

        $verificar = 'PUNTO 6 : SUBSECTOR SALUD';
        $_SESSION['verificar_ss']     = $verificar;
        header("Location:mensaje_verificar.php");

        } else {

    $sql_t = " SELECT idintegrante_beneficiario FROM integrante_beneficiario WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
    $result_t = mysqli_query($link,$sql_t);    
    if (!($row_t = mysqli_fetch_array($result_t))) {
        $verificar = 'PUNTO 7 : PROGRAMAS SOCIALES';
        $_SESSION['verificar_ss']     = $verificar;
        header("Location:mensaje_verificar.php");
    } else {
        
    $sql_t = " SELECT idintegrante_tradicional FROM integrante_tradicional WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
    $result_t = mysqli_query($link,$sql_t);    
    if (!($row_t = mysqli_fetch_array($result_t))) {
        $verificar = 'PUNTO 8 : MEDICINA TRADICIONAL';
        $_SESSION['verificar_ss']     = $verificar;
        header("Location:mensaje_verificar.php");
    } else {
    $sql_t = " SELECT idintegrante_defuncion FROM integrante_defuncion WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
    $result_t = mysqli_query($link,$sql_t);    
    if (!($row_t = mysqli_fetch_array($result_t))) {
        $verificar = 'PUNTO 9 : DEFUNCIÓN DEL INTEGRANTE FAMILIAR';
        $_SESSION['verificar_ss']     = $verificar;
        header("Location:mensaje_verificar.php");
    } else {
    $sql_t = " SELECT idsocio_economica_cf FROM socio_economica_cf WHERE idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
    $result_t = mysqli_query($link,$sql_t);    
    if (!($row_t = mysqli_fetch_array($result_t))) {
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

    } } } } } } } } } } } } } } }
    
        /*********** Guarda el registro de dterminante de la salud (END) *************/
?>