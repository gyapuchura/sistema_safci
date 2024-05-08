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
$idnombre_integrante_ss = $_SESSION['idnombre_integrante_ss'];
$idparentesco_ss        = $_SESSION['idparentesco_ss'];
$idnacion_ss            = $_SESSION['idnacion_ss'];

$idintegrante_cf_ss     = $_SESSION['idintegrante_cf_ss'];
$idgenero_ss            = $_SESSION['idgenero_ss'];
$edad_ss                = $_SESSION['edad_ss'];

/*********** ENVIO DATOS DEL PÀCIENTE *************/
$ci             = $link->real_escape_string($_POST['ci']);
$nombre         = $link->real_escape_string(mb_strtoupper($_POST['nombre']));
$paterno        = $link->real_escape_string(mb_strtoupper($_POST['paterno']));
$materno        = $link->real_escape_string(mb_strtoupper($_POST['materno']));
$idgenero       = $_POST['idgenero'];
$idnacionalidad = $_POST['idnacionalidad'];
$fecha_nac      = $_POST['fecha_nac'];

$fecha_nacimiento = $fecha_nac;
    $dia=date("d");
    $mes=date("m");
    $ano=date("Y");    
    $dianaz=date("d",strtotime($fecha_nacimiento));
    $mesnaz=date("m",strtotime($fecha_nacimiento));
    $anonaz=date("Y",strtotime($fecha_nacimiento));         
    if (($mesnaz == $mes) && ($dianaz > $dia)) {
    $ano=($ano-1); }      
    if ($mesnaz > $mes) {
    $ano=($ano-1);}       
    $edad=($ano-$anonaz);  

/*********** modificar el regsitro de datos personales del paciente (BEGIN) *************/

    $sql0 = " UPDATE nombre SET ci ='$ci', nombre = '$nombre', paterno = '$paterno', materno ='$materno', ";
    $sql0.= " idgenero = '$idgenero', fecha_nac = '$fecha_nac', idnacionalidad='$idnacionalidad' WHERE idnombre = '$idnombre_integrante_ss' ";
    $result0 = mysqli_query($link,$sql0);   

    $sql1 = " UPDATE integrante_cf SET edad ='$edad', fecha_registro='$fecha', hora_registro='$hora', idusuario='$idusuario_ss' ";
    $sql1.= " WHERE idintegrante_cf = '$idintegrante_cf_ss' ";
    $result1 = mysqli_query($link,$sql1);   

    $_SESSION['edad_ss'] = $edad;


header("Location:mostrar_integrante_cf.php");

/*********** modificar el regsitro de datos personales del paciente (END) *************/
?>