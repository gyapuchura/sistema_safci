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


    $sql_t = " SELECT iddeterminante_salud_cf FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='$iddeterminante_salud' ";
    $sql_t.= " AND idcat_determinante_salud='19' ";
    $result_t = mysqli_query($link,$sql_t);
    if ($row_t = mysqli_fetch_array($result_t)) {
        
        header("Location:mensaje_determinantes_salud_cf4.php");

    } else { 

 /*********** grados de seguiridad alimentaria *************/
 $idcat_determinante_salud_a = '19';
 $iditem_determinante_salud_a = '95';

 foreach($_POST['valor3'] as $valor3) {
        
    $sql_c = " INSERT INTO determinante_salud_cf (idcarpeta_familiar, iddeterminante_salud, idcat_determinante_salud, iditem_determinante_salud, valor_cf, fecha_registro, hora_registro, idusuario) ";
    $sql_c.= " VALUES ('$idcarpeta_familiar_ss','$iddeterminante_salud','$idcat_determinante_salud_a','$iditem_determinante_salud_a','$valor3','$fecha','$hora','$idusuario_ss') ";
    $result_c = mysqli_query($link,$sql_c);  

    $iditem_determinante_salud_a = $iditem_determinante_salud_a+1;
}

/*********** consumo diario de alimentos *************/

$idcat_determinante_salud_b  = '21';
$iditem_determinante_salud_b = '107';

foreach($_POST['valor4'] as $valor4) {
                
    $sql_d = " INSERT INTO determinante_salud_cf (idcarpeta_familiar, iddeterminante_salud, idcat_determinante_salud, iditem_determinante_salud, valor_cf, fecha_registro, hora_registro, idusuario) ";
    $sql_d.= " VALUES ('$idcarpeta_familiar_ss','$iddeterminante_salud','$idcat_determinante_salud_b','$iditem_determinante_salud_b','$valor4','$fecha','$hora','$idusuario_ss') ";
    $result_d = mysqli_query($link,$sql_d);  

    $iditem_determinante_salud_b = $iditem_determinante_salud_b+1;
}
                header("Location:determinantes_salud_cf4.php");
    }

/*********** Guarda el registro de dterminante de la salud alimentaria (END) *************/
?>