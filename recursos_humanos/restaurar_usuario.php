<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$fecha 	      = date("Y-m-d");
$hora         = date("h:i");
$gestion      = date("Y");

$idnombre_reg_ss  =  $_SESSION['idnombre_reg_ss'];
 
//-----DATOS ENVIADOS EN EL FORMULARIO DE PREINSCRIPCION ----- // 

    $sql_n = "  SELECT idnombre, ci FROM nombre WHERE idnombre = '$idnombre_reg_ss' ";
    $result_n = mysqli_query($link,$sql_n);
    $row_n = mysqli_fetch_array($result_n);
    $idnombre_reg = $row_n[0];
    $ci = $row_n[1];

    $sql_u = "  SELECT idusuario FROM usuarios WHERE idnombre = '$idnombre_reg_ss' ORDER BY idusuario DESC LIMIT 1 ";
    $result_u = mysqli_query($link,$sql_u);
    $row_u = mysqli_fetch_array($result_u);
    $idusuario_reg = $row_u[0];

    $pass = $ci.'@Safci';

//verificamos existencia del número de cedula de identidad y rescatamos los datos en sesion.
    $sql_d = " SELECT idnombre_datos FROM nombre_datos WHERE idnombre = '$idnombre_reg_ss' ORDER BY idnombre_datos DESC LIMIT 1  ";
    $result_d = mysqli_query($link,$sql_d);
    $row_d = mysqli_fetch_array($result_d);
    $idnombre_datos = $row_d[0];

    $sql_a = " SELECT idnombre_academico FROM nombre_academico WHERE idnombre = '$idnombre_reg_ss' ORDER BY idnombre_academico DESC LIMIT 1  ";
    $result_a = mysqli_query($link,$sql_a);   
    if ($row_a = mysqli_fetch_array($result_a)) {
        $idnombre_academico = $row_a[0];
    } else {
        $idnombre_academico = '13';
    }
    
    $sql_l = " SELECT iddato_laboral FROM dato_laboral WHERE idnombre = '$idnombre_reg_ss' ORDER BY iddato_laboral DESC LIMIT 1  ";
    $result_l = mysqli_query($link,$sql_l);
    $row_l = mysqli_fetch_array($result_l);
    $iddato_laboral = $row_l[0];

    $sqlm = "SELECT MAX(correlativo) FROM personal WHERE gestion='$gestion' ";
    $resultm = mysqli_query($link,$sqlm);
    $rowm = mysqli_fetch_array($resultm);

    $correlativo = $rowm[0]+1;

    $codigo = "PS/MSYD-".$correlativo."-".$ci."-".$gestion;

        $sql8 = " INSERT INTO personal (idusuario, idnombre, idnombre_datos, idnombre_academico, iddato_laboral, correlativo, codigo, ";
        $sql8.= " idestado_personal, fecha_registro, hora_registro, gestion)";
        $sql8.= " VALUES ('$idusuario_reg','$idnombre_reg','$idnombre_datos','$idnombre_academico','$iddato_laboral','$correlativo','$codigo', ";
        $sql8.= " '1','$fecha','$hora','$gestion')";
        $result8 = mysqli_query($link,$sql8);  
        $idpersonal = mysqli_insert_id($link);

        $sql0 = " UPDATE usuarios SET password = '$pass', perfil='PERSONAL', condicion='ACTIVO' WHERE idusuario='$idusuario_reg' ";
        $result0 = mysqli_query($link,$sql0); 

        $_SESSION['idpersonal_ss'] = $idpersonal; 
        $_SESSION['codigo_ss'] = $codigo;  
    
        header("Location:mostrar_personal_int.php");

?>
