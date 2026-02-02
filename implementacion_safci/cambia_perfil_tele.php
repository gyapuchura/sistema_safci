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

    $numero=1;
    $sql =" SELECT iddato_laboral, idusuario FROM dato_laboral WHERE idcargo_organigrama='54'  ";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);
    while ($field = mysqli_fetch_field($result)){
    } do {

        $sql8 =" UPDATE usuarios SET perfil='PERSONAL' WHERE idusuario = '$row[1]' ";
        $result8 = mysqli_query($link,$sql8);

        $numero=$numero+1;  
    }
    while ($row = mysqli_fetch_array($result));
    } else {
    }


    echo "Se han cambiado: ".$numero." perfiles de usuario a PERSONAL";
?>