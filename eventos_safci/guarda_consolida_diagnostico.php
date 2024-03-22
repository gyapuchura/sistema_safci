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

$idevento_safci_ss          = $_SESSION['idevento_safci_ss'];
$idnombre_paciente_ss       = $_SESSION['idnombre_paciente_ss'];
$idatencion_safci_ss        = $_SESSION['idatencion_safci_ss'];
$idespecialidad_atencion_ss = $_SESSION['idespecialidad_atencion_ss'];

/*********** ENVIO DATOS PARA CONSULTA DEL PACIENTE *************/

$sql = " SELECT iddiagnostico_atencion, idevento_safci, idatencion_safci, idespecialidad_atencion ";
$sql.= " FROM diagnostico_atencion WHERE idespecialidad_atencion='$idespecialidad_atencion_ss' ";
$result = mysqli_query($link,$sql);
if ($row = mysqli_fetch_array($result)){

    $sql0 = " UPDATE atencion_safci SET etapa='DIAGNOSTICO', fecha_registro='$fecha', hora_registro='$hora', idusuario='$idusuario_ss'  ";
    $sql0.= " WHERE idatencion_safci='$idatencion_safci_ss' ";
    $result0 = mysqli_query($link,$sql0);   
    
    $sql1 = " UPDATE especialidad_atencion SET etapa='DIAGNOSTICO', fecha_registro='$fecha', hora_registro='$hora', idusuario='$idusuario_ss'  ";
    $sql1.= " WHERE idespecialidad_atencion='$idespecialidad_atencion_ss' ";
    $result1 = mysqli_query($link,$sql1);   
    
    $sql2 = " UPDATE diagnostico_atencion SET etapa='DIAGNOSTICO', fecha_registro='$fecha', hora_registro='$hora', idusuario='$idusuario_ss'  ";
    $sql2.= " WHERE idespecialidad_atencion='$idespecialidad_atencion_ss' ";
    $result2 = mysqli_query($link,$sql2);   
    
    header("Location:mensaje_diagnostico_paciente.php");

} else {
    header("Location:mensaje_sin_diagnostico.php");
}

/*********** ENVIO DATOS PARA CONSULTA DEL PACIENTE  (END) *************/
?>