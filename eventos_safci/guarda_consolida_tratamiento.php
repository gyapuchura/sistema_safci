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
$iddiagnostico_atencion_ss  = $_SESSION['iddiagnostico_atencion_ss'];
$idpatologia_ss             = $_SESSION['idpatologia_ss'];

/*********** ENVIO DATOS PARA CONSULTA DEL PACIENTE *************/

$sql = " SELECT idtratamiento, idevento_safci, idatencion_safci, idespecialidad_atencion, iddiagnostico_atencion ";
$sql.= " FROM tratamiento WHERE iddiagnostico_atencion='$iddiagnostico_atencion_ss' ";
$result = mysqli_query($link,$sql);
if ($row = mysqli_fetch_array($result)){

    
    $sql2 = " UPDATE diagnostico_atencion SET etapa='CON TRATAMIENTO', fecha_registro='$fecha', hora_registro='$hora', idusuario='$idusuario_ss'  ";
    $sql2.= " WHERE idespecialidad_atencion='$idespecialidad_atencion_ss' ";
    $result2 = mysqli_query($link,$sql2);   

    $sql3 = " UPDATE tratamiento SET etapa='RECETADO', fecha_registro='$fecha', hora_registro='$hora', idusuario='$idusuario_ss'  ";
    $sql3.= " WHERE iddiagnostico_atencion='$iddiagnostico_atencion_ss' ";
    $result3 = mysqli_query($link,$sql3);  
    
    header("Location:mensaje_tratamiento_paciente.php");

} else {
    header("Location:mensaje_sin_tratamiento.php");
}

/*********** ENVIO DATOS PARA CONSULTA DEL PACIENTE  (END) *************/
?>