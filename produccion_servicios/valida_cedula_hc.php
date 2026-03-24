
<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$ci = $_POST["ci"];

$sql_n = " SELECT idnombre, ci, nombre, paterno, materno, fecha_nac FROM nombre WHERE ci='$ci' ";
$result_n = mysqli_query($link,$sql_n);
if ($row_n = mysqli_fetch_array($result_n)) {

        $fecha_nacimiento = $row_5[5];
        $dia = date("d");
        $mes = date("m");
        $ano = date("Y");    
        $dianaz = date("d",strtotime($fecha_nacimiento));
        $mesnaz = date("m",strtotime($fecha_nacimiento));
        $anonaz = date("Y",strtotime($fecha_nacimiento));         
        if (($mesnaz == $mes) && ($dianaz > $dia)) {
        $ano=($ano-1); }      
        if ($mesnaz > $mes) {
        $ano=($ano-1);}       
        $edad=($ano-$anonaz);  
        echo $edad ;

$sql_int = " SELECT idintegrante_cf, idcarpeta_familiar FROM integrante_cf WHERE idnombre='$row_n[0]' ORDER BY idintegrante_cf LIMIT 1 ";
$result_int = mysqli_query($link,$sql_int);
if ($row_int = mysqli_fetch_array($result_int)) {
    
$sql_cf = " SELECT idcarpeta_familiar, iddepartamento, idestablecimiento_salud FROM carpeta_familiar WHERE idcarpeta_familiar='$row_int[1]' ";
$result_cf = mysqli_query($link,$sql_cf);
$row_cf = mysqli_fetch_array($result_cf);

$idintegrante_cf = $row_int[0];
$idnombre_integrante = $row_n[0];
$idcarpeta_familiar = $row_cf[0];
$iddepartamento = $row_cf[1];
$idestablecimiento_salud = $row_cf[2];

$_SESSION['edad_ss'] = $edad;
$_SESSION['idintegrante_cf_ss'] = $idintegrante_cf;
$_SESSION['idnombre_integrante_ss'] = $idnombre_integrante;
$_SESSION['idcarpeta_familiar_ss'] = $idcarpeta_familiar;
$_SESSION['iddepartamento_ss'] = $iddepartamento;
$_SESSION['idestablecimiento_salud_ss'] = $idestablecimiento_salud;

header("Location:mostrar_persona_hc.php");

} else {

$sql_ps = " SELECT idatencion_psafci, iddepartamento, idestablecimiento_salud, idnacion FROM atencion_psafci WHERE idnombre ='$row_n[0]'  ";
$result_ps = mysqli_query($link,$sql_ps);
if ($row_ps = mysqli_fetch_array($result_ps)) {

    $_SESSION['edad_ss'] = $edad;
    $_SESSION['idnombre_paciente_ss'] = $row_n[0];
    $_SESSION['iddepartamento_ss'] = $row_ps[1];
    $_SESSION['idestablecimiento_salud_ss'] = $row_ps[2];
    $_SESSION['idnacion_ss'] = $row_ps[3];

    header("Location:mostrar_persona_nhc.php");

} else {
    header("Location:mensaje_persona_sin_hc.php");
} }
} else {   
    header("Location:mensaje_persona_sin_hc.php");
}

?>