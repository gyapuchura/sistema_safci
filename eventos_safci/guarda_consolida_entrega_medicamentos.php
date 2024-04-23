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

/*********** CONSOLIDA ENTREGA DE MEDICAMENTOS DEL PACIENTE *************/

$sql = " SELECT idtratamiento, idevento_safci, idatencion_safci, idespecialidad_atencion, iddiagnostico_atencion ";
$sql.= " FROM tratamiento WHERE idespecialidad_atencion='$idespecialidad_atencion_ss' AND cantidad_entregada ='0' ";
$result = mysqli_query($link,$sql);
if ($row = mysqli_fetch_array($result)){
    
    header("Location:mensaje_sin_entrega_medicamento.php");   

} else {

        $sql2 = " UPDATE tratamiento SET entregado_farmacia='SI', fecha_entrega='$fecha', hora_entrega='$hora', idusuario_farmacia='$idusuario_ss' ";
        $sql2.= " WHERE idespecialidad_atencion='$idespecialidad_atencion_ss' ";
        $result2 = mysqli_query($link,$sql2);  
        
        $sql3 = " UPDATE especialidad_atencion SET etapa='CON MEDICAMENTOS', fecha_registro='$fecha', hora_registro='$hora', idusuario='$idusuario_ss' ";
        $sql3.= " WHERE idespecialidad_atencion='$idespecialidad_atencion_ss' ";
        $result3 = mysqli_query($link,$sql3); 

                  
            header("Location:mensaje_entrega_medicamento.php");   

}

/*********** CONSOLIDA ENTREGA DE MEDICAMENTOS DEL PACIENTE  (END) *************/
?>