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

$idcarpeta_familiar_ss = $_SESSION['idcarpeta_familiar_ss'];

/*********** CONSOLIDA ENTREGA DE MEDICAMENTOS DEL PACIENTE *************/

        $sql2 = " UPDATE integrante_cf SET estado='CONSOLIDADO', fecha_registro='$fecha', hora_registro='$hora', idusuario='$idusuario_ss' ";
        $sql2.= " WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
        $result2 = mysqli_query($link,$sql2);  
                  
            header("Location:mensaje_consolida_integrantes.php");   

/*********** CONSOLIDA ENTREGA DE MEDICAMENTOS DEL PACIENTE  (END) *************/
?>
