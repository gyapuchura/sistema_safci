<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$fecha 	 = date("Y-m-d");
$hora    = date("H:i");
$gestion = date("Y");

//----- REVISAMOS TODAS LAS CARPETAS DEL OPERATIVO ----- //
 
$numero=1;
$sqla =" SELECT idcarpeta_familiar, codigo FROM carpeta_familiar WHERE idusuario='$idusuario_ss' AND estado='CONSOLIDADO'";
$resulta = mysqli_query($link,$sqla);
if ($rowa = mysqli_fetch_array($resulta)){
mysqli_field_seek($resulta,0);
while ($fielda = mysqli_fetch_field($resulta)){
} do { 

//----- INCORPORAR EN BANDEJA DE CARPETAS OPERATIVO BEGIN ----- //


    $numero_d=0;
    $sqld =" SELECT idcat_determinante_salud FROM determinante_salud_cf WHERE idcarpeta_familiar='$rowa[0]' GROUP BY idcat_determinante_salud ";
    $resultd = mysqli_query($link,$sqld);
    if ($rowd = mysqli_fetch_array($resultd)){
    mysqli_field_seek($resultd,0);
    while ($fieldd = mysqli_fetch_field($resultd)){
    } do { 

        $numero_d=$numero_d+1;
    }
    while ($rowd = mysqli_fetch_array($resultd));
    } else {
    }

    if ($numero_d == '20') {    

        echo $numero.".- ".$rowa[1]."</br>";

    } else {
        echo $numero.".- ".$rowa[1].".- AJUSTAR DETERMINANTES DE LA SALUD </br>";
    }

    $sql_t = " SELECT idintegrante_datos_cf FROM integrante_datos_cf WHERE idcarpeta_familiar = '$rowa[0]' ";
    $result_t = mysqli_query($link,$sql_t);    
    if ($row_t = mysqli_fetch_array($result_t)) {

        } else { 
            echo "AJUSTAR DATOS DE TODOS LOS INTEGRANTES </br>";
        }

    $sql_t = " SELECT idintegrante_subsector_salud FROM integrante_subsector_salud WHERE idcarpeta_familiar = '$rowa[0]' ";
    $result_t = mysqli_query($link,$sql_t);    
    if ($row_t = mysqli_fetch_array($result_t)) {

        } else { 
            echo "AJUSTAR DATOS DE SUBSECTOR SALUD </br>";
        }

        $sql_t = " SELECT idintegrante_beneficiario FROM integrante_beneficiario WHERE idcarpeta_familiar = '$rowa[0]' ";
        $result_t = mysqli_query($link,$sql_t);    
        if ($row_t = mysqli_fetch_array($result_t)) {
    
            } else { 
                echo "AJUSTAR DATOS DE PROGRAMAS SOCIALES </br>";
            }
        $sql_t = " SELECT idintegrante_tradicional FROM integrante_tradicional WHERE idcarpeta_familiar = '$rowa[0]' ";
        $result_t = mysqli_query($link,$sql_t);    
        if ($row_t = mysqli_fetch_array($result_t)) {
    
            } else { 
                echo "AJUSTAR DATOS DE MEDICINA TRADICIONAL </br>";
            }

        $sql_t = " SELECT idintegrante_defuncion FROM integrante_defuncion WHERE idcarpeta_familiar = '$rowa[0]' ";
        $result_t = mysqli_query($link,$sql_t);    
        if ($row_t = mysqli_fetch_array($result_t)) {
    
            } else { 
                echo "AJUSTAR DATOS DE DEFUNCION DE INTEGRANTES </br>";
            }

 //----- INCORPORAR EN BANDEJA DE CARPETAS OPERATIVO END ----- //   

$numero=$numero+1;
}
while ($rowa = mysqli_fetch_array($resulta));
} else {
}
?>
