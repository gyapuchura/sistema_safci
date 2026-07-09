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

$idderiva_referencia_hc_ss  = $_SESSION['idderiva_referencia_hc_ss'];
$idreferencia_hc_ss         = $_SESSION['idreferencia_hc_ss'];

$idatencion_psafci_ss       = $_SESSION['idatencion_psafci_ss'];
$idcarpeta_familiar_ss      = $_SESSION['idcarpeta_familiar_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idintegrante_cf_ss         = $_SESSION['idintegrante_cf_ss'];
$idnombre_integrante_ss     = $_SESSION['idnombre_integrante_ss'];
$edad_ss                    = $_SESSION['edad_ss'];

$idestado_referencia = $_POST['idestado_referencia'];

if ($idestado_referencia == '1' || $idestado_referencia == '3') {

    $persona_contactada = $_POST['persona_contactada'];
    $idvia_comunicacion = $_POST['idvia_comunicacion'];
    $recibe_paciente    = $_POST['recibe_paciente'];
    $nombre_ccdes       = $_POST['nombre_ccdes'];
    $motivo      = $_POST['motivo'];

    $adecuada    = $_POST['adecuada'];
    $justificada = $_POST['justificada'];
    $oportuna    = $_POST['oportuna'];

        $sql8 =" UPDATE deriva_referencia_hc SET persona_contactada='$persona_contactada', idvia_comunicacion='$idvia_comunicacion', "; 
        $sql8.=" recibe_paciente='$recibe_paciente', nombre_ccdes='$nombre_ccdes', referido='NO', admitido='SI', motivo ='$motivo', ";
        $sql8.=" idusuario_r='$idusuario_ss', fecha_admision='$fecha', hora_admision='$hora' ";
        $sql8.=" WHERE idderiva_referencia_hc='$idderiva_referencia_hc_ss' ";
        $result8 = mysqli_query($link,$sql8);  
        
        $sql9 =" UPDATE referencia_hc SET adecuada='$adecuada', justificada='$justificada', oportuna='$oportuna' "; 
        $sql9.=" WHERE idreferencia_hc='$idreferencia_hc_ss' ";
        $result9 = mysqli_query($link,$sql9); 

    header("Location:mensaje_admite_referencia_hc.php");

} else {
        
        $sql9 =" UPDATE deriva_referencia_hc SET referido='SI', admitido='SI', idusuario_r='$idusuario_ss', "; 
        $sql9.=" fecha_admision='$fecha', hora_admision='$hora' WHERE idderiva_referencia_hc='$idderiva_referencia_hc_ss' ";
        $result9 = mysqli_query($link,$sql9); 

    header("Location:mensaje_concluye_referencia_hc.php");
}

?>