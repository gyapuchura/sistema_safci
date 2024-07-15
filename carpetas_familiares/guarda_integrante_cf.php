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

$idnombre_integrante_ss = $_SESSION['idnombre_integrante_ss'];
$idparentesco_ss        = $_SESSION['idparentesco_ss'];
$idnacion_ss            = $_SESSION['idnacion_ss'];

/*********** ENVIO DATOS DEL PÀCIENTE *************/

$sql_n =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$idnombre_integrante_ss' ";
$result_n=mysqli_query($link,$sql_n);
$row_n=mysqli_fetch_array($result_n);

$fecha_nacimiento = $row_n[5];
    $dia=date("d");
    $mes=date("m");
    $ano=date("Y");    
    $dianaz=date("d",strtotime($fecha_nacimiento));
    $mesnaz=date("m",strtotime($fecha_nacimiento));
    $anonaz=date("Y",strtotime($fecha_nacimiento));         
    if (($mesnaz == $mes) && ($dianaz > $dia)) {
    $ano=($ano-1); }      
    if ($mesnaz > $mes) {
    $ano=($ano-1);}       
    $edad=($ano-$anonaz);  

if ($edad <= 4) {
    $idgrupo_etareo_cf = '1';
    } else {
    if ($edad <= 9) {
    $idgrupo_etareo_cf = '2';
    } else {
    if ($edad <= 14) {
        $idgrupo_etareo_cf = '3';
    } else { 
        if ($edad <= 19) {
        $idgrupo_etareo_cf = '4';
    } else { 
        if ($edad <= 24) {
            $idgrupo_etareo_cf = '5';
        } else { 
            if ($edad <= 29) {
                $idgrupo_etareo_cf = '6';
            } else { 
                if ($edad <= 34) {
                    $idgrupo_etareo_cf = '7';
                } else { 
                    if ($edad <= 39) {
                        $idgrupo_etareo_cf = '8';
                    } else { 
                        if ($edad <= 44) {
                            $idgrupo_etareo_cf = '9';
                        } else { 
                            if ($edad <= 49) {
                                $idgrupo_etareo_cf = '10';
                            } else { 
                                if ($edad <= 54) {
                                    $idgrupo_etareo_cf = '11';
                                } else { 
                                    if ($edad <= 59) {
                                        $idgrupo_etareo_cf = '12';
                                    } else { 
                                        if ($edad <= 64) {
                                            $idgrupo_etareo_cf = '13';
                                        } else { 
                                            if ($edad <= 69) {
                                                $idgrupo_etareo_cf = '14';
                                            } else { 
                                                if ($edad <= 74) {
                                                    $idgrupo_etareo_cf = '15';
                                                } else { 
                                                    if ($edad <= 79) {
                                                        $idgrupo_etareo_cf = '16';
                                                    } else { 
                                                        if ($edad <= 84) {
                                                            $idgrupo_etareo_cf = '17';
                                                        } else { 
                                                            if ($edad <= 89) {
                                                                $idgrupo_etareo_cf = '18';
                                                            } else { 
                                                                if ($edad <= 94) {
                                                                    $idgrupo_etareo_cf = '19';
                                                                } else { 
                                                                    if ($edad >= 95) {
                                                                        $idgrupo_etareo_cf = '20';
                                                                    } else { 
    }}}}} }}}}} }}}}} }}}}}

/*********** Crear registros para fichas epidemiologicas (BEGIN) *************/

    $sql2 = " INSERT INTO integrante_cf (idcarpeta_familiar, idnombre, edad, idgrupo_etareo_cf, idparentesco, idnacion, fecha_registro, hora_registro, idusuario) ";
    $sql2.= " VALUES ('$idcarpeta_familiar_ss','$idnombre_integrante_ss','$edad','$idgrupo_etareo_cf','$idparentesco_ss','$idnacion_ss','$fecha','$hora','$idusuario_ss') ";
    $result2 = mysqli_query($link,$sql2);   
    $idnombre_paciente = mysqli_insert_id($link);

header("Location:integrantes_cf.php");

/*********** Crear registros para fichas epidemiologicas (END) *************/
?>