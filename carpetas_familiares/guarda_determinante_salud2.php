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

$iddeterminante_salud = $_POST['iddeterminante_salud'];

/*********** Guarda el registro de dterminante de la salud (BEGIN) *************/


    $sql_t = " SELECT iddeterminante_salud_cf FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='$iddeterminante_salud' ";
    $sql_t.= " AND idcat_determinante_salud='8' ";
    $result_t = mysqli_query($link,$sql_t);
    if ($row_t = mysqli_fetch_array($result_t)) {
        
        header("Location:mensaje_determinantes_salud_cf2.php");

    } else { 

             $idcat_determinante_salud_i = '8';
    
            foreach($_POST['iditem_determinante_salud'] as $iditem_determinante_salud) {

                $sql1 = "SELECT iditem_determinante_salud, valor FROM item_determinante_salud WHERE iditem_determinante_salud='$iditem_determinante_salud' ";
                $result1 = mysqli_query($link,$sql1);
                $row1 = mysqli_fetch_array($result1);
            
                $sql2 = " INSERT INTO determinante_salud_cf (idcarpeta_familiar, iddeterminante_salud, idcat_determinante_salud, iditem_determinante_salud, valor_cf, fecha_registro, hora_registro, idusuario) ";
                $sql2.= " VALUES ('$idcarpeta_familiar_ss','$iddeterminante_salud','$idcat_determinante_salud_i','$iditem_determinante_salud','$row1[1]','$fecha','$hora','$idusuario_ss') ";
                $result2 = mysqli_query($link,$sql2);   
            
                $idcat_determinante_salud_i = $idcat_determinante_salud_i+1;

                }

                $idcat_determinante_salud_g = '14';
                $iditem_determinante_salud_i = '72';

                foreach($_POST['campo'] as $campo) {
    
                    $sql_a = " INSERT INTO determinante_salud_cf (idcarpeta_familiar, iddeterminante_salud, idcat_determinante_salud, iditem_determinante_salud, valor_cf, fecha_registro, hora_registro, idusuario) ";
                    $sql_a.= " VALUES ('$idcarpeta_familiar_ss','$iddeterminante_salud','$idcat_determinante_salud_g','$iditem_determinante_salud_i','$campo','$fecha','$hora','$idusuario_ss') ";
                    $result_a = mysqli_query($link,$sql_a);  

                    $iditem_determinante_salud_i = $iditem_determinante_salud_i+1;
                  
                } 

                $idcat_determinante_salud_h = '15';
                $iditem_determinante_salud_h = '77';

                foreach($_POST['valor2'] as $valor2) {
    
                    $sql_b = " INSERT INTO determinante_salud_cf (idcarpeta_familiar, iddeterminante_salud, idcat_determinante_salud, iditem_determinante_salud, valor_cf, fecha_registro, hora_registro, idusuario) ";
                    $sql_b.= " VALUES ('$idcarpeta_familiar_ss','$iddeterminante_salud','$idcat_determinante_salud_h','$iditem_determinante_salud_h','$valor2','$fecha','$hora','$idusuario_ss') ";
                    $result_b = mysqli_query($link,$sql_b);  
                
                    $iditem_determinante_salud_h = $iditem_determinante_salud_h+1;
                }

                header("Location:determinantes_salud_cf2.php");
    }


/*********** Guarda el registro de dterminante de la salud (END) *************/
        ?>