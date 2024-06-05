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
$idcat_determinante_salud  = $_POST['idcat_determinante_salud'];
$iditem_determinante_salud = $_POST['iditem_determinante_salud'];

$integrantes               = $_POST['integrantes'];
$habitaciones              = $_POST['habitaciones'];

/*********** Guarda el registro de dterminante de la salud (BEGIN) *************/

if ($idcat_determinante_salud == '14') {

    $iditem_determinante_salud_i = '72';
    
    foreach($_POST['campo'] as $campo) {
    
        $sql_a = " INSERT INTO determinante_salud_cf (idcarpeta_familiar, iddeterminante_salud, idcat_determinante_salud, iditem_determinante_salud, valor_cf, fecha_registro, hora_registro, idusuario) ";
        $sql_a.= " VALUES ('$idcarpeta_familiar_ss','$iddeterminante_salud','$idcat_determinante_salud','$iditem_determinante_salud_i','$campo','$fecha','$hora','$idusuario_ss') ";
        $result_a = mysqli_query($link,$sql_a);  
    
        $iditem_determinante_salud_i = $iditem_determinante_salud_i+1;
    }
    
    header("Location:determinantes_salud_cf.php");

} else { 
    
    if ($idcat_determinante_salud == '15') {

        $iditem_determinante_salud_f = '77';
    
        foreach($_POST['valor2'] as $valor2) {
    
            $sql_b = " INSERT INTO determinante_salud_cf (idcarpeta_familiar, iddeterminante_salud, idcat_determinante_salud, iditem_determinante_salud, valor_cf, fecha_registro, hora_registro, idusuario) ";
            $sql_b.= " VALUES ('$idcarpeta_familiar_ss','$iddeterminante_salud','$idcat_determinante_salud','$iditem_determinante_salud_f','$valor2','$fecha','$hora','$idusuario_ss') ";
            $result_b = mysqli_query($link,$sql_b);  
        
            $iditem_determinante_salud_f = $iditem_determinante_salud_f+1;
        }
        
        header("Location:determinantes_salud_cf.php");

} else {

        if ($idcat_determinante_salud == '17') {
            
            $hacinamiento = $integrantes/$habitaciones;

            if ($hacinamiento < 2.4 ) {
                $iditem_determinante_salud_a = '87';
                $valor_cfea = '1';
            } else {
                if ($hacinamiento <= 4.9 ) {
                    $iditem_determinante_salud_a = '88';
                    $valor_cfea = '3';
                } else {
                    if ($hacinamiento >= 5) {
                        $iditem_determinante_salud_a = '89';
                        $valor_cfea = '5';
                    } else { } } }

                    $sql_a = " INSERT INTO determinante_salud_cf (idcarpeta_familiar, iddeterminante_salud, idcat_determinante_salud, iditem_determinante_salud, valor_cf, fecha_registro, hora_registro, idusuario) ";
                    $sql_a.= " VALUES ('$idcarpeta_familiar_ss','$iddeterminante_salud','$idcat_determinante_salud','$iditem_determinante_salud_a','$valor_cfea','$fecha','$hora','$idusuario_ss') ";
                    $result_a = mysqli_query($link,$sql_a);   
                
                    header("Location:determinantes_salud_cf.php");
        
        } else {
            
            if ($idcat_determinante_salud == '19') {

            $iditem_determinante_salud_g = '95';

            foreach($_POST['valor3'] as $valor3) {
        
                $sql_c = " INSERT INTO determinante_salud_cf (idcarpeta_familiar, iddeterminante_salud, idcat_determinante_salud, iditem_determinante_salud, valor_cf, fecha_registro, hora_registro, idusuario) ";
                $sql_c.= " VALUES ('$idcarpeta_familiar_ss','$iddeterminante_salud','$idcat_determinante_salud','$iditem_determinante_salud_g','$valor3','$fecha','$hora','$idusuario_ss') ";
                $result_c = mysqli_query($link,$sql_c);  
            
                $iditem_determinante_salud_g = $iditem_determinante_salud_g+1;
            }
            
            header("Location:determinantes_salud_cf.php");


            } else {

                if ($idcat_determinante_salud == '21') {
                   
                    $iditem_determinante_salud_h = '107';

                    foreach($_POST['valor4'] as $valor4) {
                
                        $sql_d = " INSERT INTO determinante_salud_cf (idcarpeta_familiar, iddeterminante_salud, idcat_determinante_salud, iditem_determinante_salud, valor_cf, fecha_registro, hora_registro, idusuario) ";
                        $sql_d.= " VALUES ('$idcarpeta_familiar_ss','$iddeterminante_salud','$idcat_determinante_salud','$iditem_determinante_salud_h','$valor4','$fecha','$hora','$idusuario_ss') ";
                        $result_d = mysqli_query($link,$sql_d);  
                    
                        $iditem_determinante_salud_h = $iditem_determinante_salud_h+1;
                    }
                    
                    header("Location:determinantes_salud_cf.php");


                } else {

                                $sql1 = "SELECT iditem_determinante_salud, valor FROM item_determinante_salud WHERE iditem_determinante_salud='$iditem_determinante_salud' ";
                                $result1 = mysqli_query($link,$sql1);
                                $row1 = mysqli_fetch_array($result1);

                                $sql2 = " INSERT INTO determinante_salud_cf (idcarpeta_familiar, iddeterminante_salud, idcat_determinante_salud, iditem_determinante_salud, valor_cf, fecha_registro, hora_registro, idusuario) ";
                                $sql2.= " VALUES ('$idcarpeta_familiar_ss','$iddeterminante_salud','$idcat_determinante_salud','$iditem_determinante_salud','$row1[1]','$fecha','$hora','$idusuario_ss') ";
                                $result2 = mysqli_query($link,$sql2);   

                                header("Location:determinantes_salud_cf.php");
                            
        }
        }
        }
    }
}


        /*********** Guarda el registro de dterminante de la salud (END) *************/
        ?>