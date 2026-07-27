
<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$sql_es = " SELECT iddato_laboral, idestablecimiento_salud, iddepartamento FROM dato_laboral WHERE idusuario='$idusuario_ss' ORDER BY iddato_laboral DESC LIMIT 1  ";
$result_es = mysqli_query($link,$sql_es);
$row_es = mysqli_fetch_array($result_es);
$idestablecimiento_salud_orig = $row_es[1];

$sql_e    = " SELECT iddepartamento, idred_salud, idmunicipio FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud_orig' ";
$result_e = mysqli_query($link,$sql_e);
$row_e    = mysqli_fetch_array($result_e);

$iddepartamento_orig = $row_e[0]; 
$idred_salud_orig    = $row_e[1];
$idmunicipio_orig    = $row_e[2];

$idnombre_persona = $_POST["idnombre_persona"];
$edad             = $_POST["edad"];

    $sql_int = " SELECT idintegrante_cf, idcarpeta_familiar FROM integrante_cf WHERE idnombre='$idnombre_persona' ORDER BY idintegrante_cf LIMIT 1 ";
    $result_int = mysqli_query($link,$sql_int);
    if ($row_int = mysqli_fetch_array($result_int)) {
        
    $sql_cf = " SELECT idcarpeta_familiar, iddepartamento, idestablecimiento_salud FROM carpeta_familiar WHERE idcarpeta_familiar='$row_int[1]' ";
    $result_cf = mysqli_query($link,$sql_cf);
    $row_cf = mysqli_fetch_array($result_cf);

    $idintegrante_cf = $row_int[0];
    $idcarpeta_familiar = $row_cf[0];
    $iddepartamento = $row_cf[1];
    $idestablecimiento_salud = $row_cf[2];

    $_SESSION['edad_ss'] = $edad;
    $_SESSION['idintegrante_cf_ss'] = $idintegrante_cf;
    $_SESSION['idnombre_integrante_ss'] = $idnombre_persona;
    $_SESSION['idcarpeta_familiar_ss'] = $idcarpeta_familiar;
    $_SESSION['iddepartamento_ss'] = $iddepartamento_orig;
    $_SESSION['idestablecimiento_salud_ss'] = $idestablecimiento_salud_orig;

    header("Location:mostrar_persona_hc.php");

    } else {
    /************* VERIFICAMOS QUE LA PERSONA NO TENGA ATENCION PREVIA ***********/
    $sql_ps = " SELECT idatencion_psafci, iddepartamento, idestablecimiento_salud, idnacion FROM atencion_psafci WHERE idnombre ='$idnombre_persona' LIMIT 1 ";
    $result_ps = mysqli_query($link,$sql_ps);
    if ($row_ps = mysqli_fetch_array($result_ps)) {

        $_SESSION['edad_ss'] = $edad;
        $_SESSION['idnombre_paciente_ss'] = $idnombre_persona;
        $_SESSION['iddepartamento_ss'] = $row_ps[1];
        $_SESSION['idestablecimiento_salud_ss'] = $row_ps[2];
        $_SESSION['idnacion_ss'] = $row_ps[3];

        header("Location:mostrar_persona_nhc.php");

    } else {

        $_SESSION['edad_ss'] = $edad;
        $_SESSION['idnacion_ss'] = '33';
        $_SESSION['idnombre_paciente_ss'] = $idnombre_persona;
        $_SESSION['iddepartamento_ss'] = $iddepartamento_orig;
        $_SESSION['idestablecimiento_salud_ss'] = $idestablecimiento_salud_orig;

        header("Location:registrar_persona_hc.php");

    } 
} 

?>