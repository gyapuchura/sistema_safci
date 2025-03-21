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

/*********** ENVIO DATOS DEL PÀCIENTE *************/

$paterno       = $link->real_escape_string(mb_strtoupper($_POST['paterno']));
$materno       = $link->real_escape_string(mb_strtoupper($_POST['materno']));
$nombre        = $link->real_escape_string(mb_strtoupper($_POST['nombre']));
$ci            = $_POST['ci'];
$complemento   = $link->real_escape_string($_POST['complemento']);
$idgenero       = $_POST['idgenero'];
$fecha_nac      = $_POST['fecha_nac'];
$idnacionalidad = $_POST['idnacionalidad'];
$idparentesco   = $_POST['idparentesco'];
$idnacion       = $_POST['idnacion'];

$fecha_nacimiento = $fecha_nac;
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

$edad = ($ano-$anonaz);  

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

/*********** Crear registros para integrante de la familia (BEGIN) *************/

if ($ci == '0') {

    $sql_c = " INSERT INTO nombre (paterno, materno, nombre, ci, exp, fecha_nac, complemento, idnacionalidad, idgenero) ";
    $sql_c.= " VALUES ('$paterno','$materno','$nombre','0','','$fecha_nac','$complemento','$idnacionalidad','$idgenero') ";
    $result_c = mysqli_query($link,$sql_c);   
    $idnombre_integrante = mysqli_insert_id($link);

    $sql_d = " INSERT INTO integrante_cf (idcarpeta_familiar, idnombre, edad, idgrupo_etareo_cf, idparentesco, idnacion, fecha_registro, hora_registro, idusuario) ";
    $sql_d.= " VALUES ('$idcarpeta_familiar_ss','$idnombre_integrante','$edad','$idgrupo_etareo_cf','$idparentesco','$idnacion','$fecha','$hora','$idusuario_ss') ";
    $result_d = mysqli_query($link,$sql_d);   
    $idnombre_paciente = mysqli_insert_id($link);

header("Location:integrantes_cf.php");

} else {
   
$sql_p =" SELECT idnombre, nombre, paterno, materno FROM nombre WHERE ci='$ci' AND ci !='0'";
$result_p=mysqli_query($link,$sql_p);
if ($row_p=mysqli_fetch_array($result_p)) 
{
    $_SESSION['idnombre_integrante_ss'] = $row_p[0];
    $_SESSION['idparentesco_ss'] = $idparentesco;
    $_SESSION['idnacion_ss'] = $idnacion;
    
    header("Location:integrante_existe.php");
 
} else {

    $sql0 = " INSERT INTO nombre (paterno, materno, nombre, ci, exp, fecha_nac, complemento, idnacionalidad, idgenero) ";
    $sql0.= " VALUES ('$paterno','$materno','$nombre','$ci','','$fecha_nac','$complemento','$idnacionalidad','$idgenero') ";
    $result0 = mysqli_query($link,$sql0);   
    $idnombre_integrante = mysqli_insert_id($link);

    $sql2 = " INSERT INTO integrante_cf (idcarpeta_familiar, idnombre, edad, idgrupo_etareo_cf, idparentesco, idnacion, fecha_registro, hora_registro, idusuario) ";
    $sql2.= " VALUES ('$idcarpeta_familiar_ss','$idnombre_integrante','$edad','$idgrupo_etareo_cf','$idparentesco','$idnacion','$fecha','$hora','$idusuario_ss') ";
    $result2 = mysqli_query($link,$sql2);   

header("Location:integrantes_cf.php");
}
}
/*********** Crear registros para integrante de la familia (END) *************/
?>