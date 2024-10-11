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

/*********** ENVIO DATOS PARA TRIAGE DEL PACIENTE *************/ 

$iddeterminante_salud      = $_POST['iddeterminante_salud'];

/*********** Guarda el registro de dterminante de la salud (BEGIN) *************/


    $sql_t = " SELECT iddeterminante_salud_cf FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='$iddeterminante_salud' ";
    $sql_t.= " AND idcat_determinante_salud='1' ";
    $result_t = mysqli_query($link,$sql_t);
    if ($row_t = mysqli_fetch_array($result_t)) {
        
        header("Location:mensaje_determinantes_salud_cf.php");

    } else { 

             $idcat_determinante_salud_i = '1';
    
            foreach($_POST['iditem_determinante_salud'] as $iditem_determinante_salud) {

                $sql1 = "SELECT iditem_determinante_salud, valor FROM item_determinante_salud WHERE iditem_determinante_salud='$iditem_determinante_salud' ";
                $result1 = mysqli_query($link,$sql1);
                $row1 = mysqli_fetch_array($result1);
            
                $sql2 = " INSERT INTO determinante_salud_cf (idcarpeta_familiar, iddeterminante_salud, idcat_determinante_salud, iditem_determinante_salud, valor_cf, fecha_registro, hora_registro, idusuario) ";
                $sql2.= " VALUES ('$idcarpeta_familiar_ss','$iddeterminante_salud','$idcat_determinante_salud_i','$iditem_determinante_salud','$row1[1]','$fecha','$hora','$idusuario_ss') ";
                $result2 = mysqli_query($link,$sql2);   
            
                $idcat_determinante_salud_i = $idcat_determinante_salud_i+1;

                }

                header("Location:determinantes_salud_cf.php");
    }


/*********** Guarda el registro de dterminante de la salud (END) *************/
        ?>