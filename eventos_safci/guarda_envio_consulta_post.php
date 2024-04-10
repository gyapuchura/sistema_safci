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

$idevento_safci_ss    = $_SESSION['idevento_safci_ss'];
$idatencion_safci_ss  = $_SESSION['idatencion_safci_ss'];
$idnombre_paciente_ss = $_SESSION['idnombre_paciente_ss'];

/*********** ENVIO DATOS PARA CONSULTA DEL PACIENTE *************/

$sql = " SELECT idespecialidad_atencion, idevento_safci, idatencion_safci, idespecialidad_medica ";
$sql.= " FROM especialidad_atencion WHERE idatencion_safci='$idatencion_safci_ss' AND etapa='PARA ESPECIALIDAD'";
$result = mysqli_query($link,$sql);
if ($row = mysqli_fetch_array($result)){

    $sql1 = " UPDATE especialidad_atencion SET etapa='CON ESPECIALIDAD', fecha_registro='$fecha', hora_registro='$hora', idusuario='$idusuario_ss'  ";
    $sql1.= " WHERE idatencion_safci='$idatencion_safci_ss' AND etapa='PARA ESPECIALIDAD'";
    $result1 = mysqli_query($link,$sql1); 
    
    header("Location:mensaje_consulta_paciente_post.php");

} else {
    header("Location:mensaje_sin_especialidad_post.php");
}




/*********** ENVIO DATOS PARA CONSULTA DEL PACIENTE  (END) *************/
?>