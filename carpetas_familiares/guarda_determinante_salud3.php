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

$idcat_determinante_salud_a  ='16';
$iditem_determinante_salud_a = $_POST['iditem_determinante_salud_a'];

$integrantes  = $_POST['integrantes'];
$habitaciones = $_POST['habitaciones'];


/*********** Guarda el registro de dterminante de la salud (BEGIN) *************/

    $sql_t = " SELECT iddeterminante_salud_cf FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='$iddeterminante_salud' ";
    $sql_t.= " AND idcat_determinante_salud='16' ";
    $result_t = mysqli_query($link,$sql_t);
    if ($row_t = mysqli_fetch_array($result_t)) {
        
        header("Location:mensaje_determinantes_salud_cf3.php");

    } else { 

        $sql1 = "SELECT iditem_determinante_salud, valor FROM item_determinante_salud WHERE iditem_determinante_salud='$iditem_determinante_salud_a' ";
        $result1 = mysqli_query($link,$sql1);
        $row1 = mysqli_fetch_array($result1);

        $sql2 = " INSERT INTO determinante_salud_cf (idcarpeta_familiar, iddeterminante_salud, idcat_determinante_salud, iditem_determinante_salud, valor_cf, fecha_registro, hora_registro, idusuario) ";
        $sql2.= " VALUES ('$idcarpeta_familiar_ss','$iddeterminante_salud','$idcat_determinante_salud_a','$iditem_determinante_salud_a','$row1[1]','$fecha','$hora','$idusuario_ss') ";
        $result2 = mysqli_query($link,$sql2);   

        /** indice de hacinamiento  */

        $idcat_determinante_salud_h = '17';

            $hacinamiento = $integrantes/$habitaciones;

            if ($hacinamiento < 2.4 ) {
                $iditem_determinante_salud_h = '87';
                $valor_cfea = '1';
            } else {
                if ($hacinamiento <= 4.9 ) {
                    $iditem_determinante_salud_h = '88';
                    $valor_cfea = '3';
                } else {
                    if ($hacinamiento >= 5) {
                        $iditem_determinante_salud_h = '89';
                        $valor_cfea = '5';
                    } else { } } }

                    $sql_a = " INSERT INTO determinante_salud_cf (idcarpeta_familiar, iddeterminante_salud, idcat_determinante_salud, iditem_determinante_salud, valor_cf, fecha_registro, hora_registro, idusuario) ";
                    $sql_a.= " VALUES ('$idcarpeta_familiar_ss','$iddeterminante_salud','$idcat_determinante_salud_h','$iditem_determinante_salud_h','$valor_cfea','$fecha','$hora','$idusuario_ss') ";
                    $result_a = mysqli_query($link,$sql_a);   

                    /** tenencia de animales en la vivienda */

        $idcat_determinante_salud_anim = '18';
        $iditem_determinante_salud_anim = $_POST['iditem_determinante_salud_anim'];
    
        $sql9 = "SELECT iditem_determinante_salud, valor FROM item_determinante_salud WHERE iditem_determinante_salud='$iditem_determinante_salud_anim' ";
        $result9 = mysqli_query($link,$sql9);
        $row9 = mysqli_fetch_array($result9);

        $sqld = " INSERT INTO determinante_salud_cf (idcarpeta_familiar, iddeterminante_salud, idcat_determinante_salud, iditem_determinante_salud, valor_cf, fecha_registro, hora_registro, idusuario) ";
        $sqld.= " VALUES ('$idcarpeta_familiar_ss','$iddeterminante_salud','$idcat_determinante_salud_anim','$iditem_determinante_salud_anim','$row9[1]','$fecha','$hora','$idusuario_ss') ";
        $resultd = mysqli_query($link,$sqld);  

                header("Location:determinantes_salud_cf3.php");
    }


/*********** Guarda el registro de dterminante de la salud (END) *************/
        ?>