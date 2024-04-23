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

$idevento_safci_ss = $_SESSION['idevento_safci_ss'];
$codigo_ss         = $_SESSION['codigo_ss'];

$idnombre_paciente       = $_POST['idnombre_paciente'];
$idatencion_safci        = $_POST['idatencion_safci'];
$idespecialidad_atencion = $_POST['idespecialidad_atencion'];

/*********** ENVIO DATOS PARA CONSULTA DEL PACIENTE *************/
    $sql = " UPDATE especialidad_atencion SET etapa='CON ESPECIALIDAD', fecha_registro='$fecha', hora_registro='$hora', idusuario='$idusuario_ss' ";
    $sql.= " WHERE idespecialidad_atencion='$idespecialidad_atencion' ";
    $result = mysqli_query($link,$sql);  

    $sql2 = " UPDATE diagnostico_atencion SET etapa='PARA DIAGNOSTICO', fecha_registro='$fecha', hora_registro='$hora', idusuario='$idusuario_ss' ";
    $sql2.= " WHERE idespecialidad_atencion='$idespecialidad_atencion' ";
    $result2 = mysqli_query($link,$sql2);   

    $sql3 = " UPDATE tratamiento SET etapa='PARA TRATAMIENTO', fecha_registro='$fecha', hora_registro='$hora', idusuario_medico='$idusuario_ss' ";
    $sql3.= " WHERE idespecialidad_atencion='$idespecialidad_atencion' ";
    $result3 = mysqli_query($link,$sql3);  

    $sql4 = " UPDATE tratamiento SET entregado_farmacia='NO', fecha_entrega='$fecha', hora_entrega='$hora', idusuario_farmacia='$idusuario_ss' ";
    $sql4.= " WHERE idespecialidad_atencion='$idespecialidad_atencion' ";
    $result4 = mysqli_query($link,$sql4); 
         
    header("Location:mensaje_atencion_desconsolida.php");

/*********** ENVIO DATOS PARA CONSULTA DEL PACIENTE  (END) *************/
?>