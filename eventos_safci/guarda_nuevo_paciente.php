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

$idevento_safci_ss  =  $_SESSION['idevento_safci_ss'];

/*********** ENVIO DATOS DEL PÀCIENTE *************/
$ci            = $link->real_escape_string($_POST['ci']);
$nombre        = $link->real_escape_string(mb_strtoupper($_POST['nombre']));
$paterno       = $link->real_escape_string(mb_strtoupper($_POST['paterno']));
$materno       = $link->real_escape_string(mb_strtoupper($_POST['materno']));
$idgenero      = $_POST['idgenero'];
$fecha_nac     = $_POST['fecha_nac'];

/*********** Crear registros para fichas epidemiologicas (BEGIN) *************/

if ($ci == '0') {

    $sql0 = " INSERT INTO nombre (paterno, materno, nombre, ci, exp, fecha_nac, complemento, idnacionalidad, idgenero) ";
    $sql0.= " VALUES ('$paterno','$materno','$nombre','$ci','','$fecha_nac','','1','$idgenero') ";
    $result0 = mysqli_query($link,$sql0);   
    $idnombre_paciente = mysqli_insert_id($link);

    $_SESSION['idnombre_paciente_ss'] = $idnombre_paciente;

    header("Location:prepara_paciente.php");

} else {

        $sql_p =" SELECT idnombre, nombre, paterno, materno FROM nombre WHERE ci='$ci' ";
        $result_p=mysqli_query($link,$sql_p);
        if ($row_p=mysqli_fetch_array($result_p)) 
        {

            $_SESSION['idnombre_paciente_ss'] = $row_p[0];
            header("Location:prepara_paciente.php");

        } else {

            $sql0 = " INSERT INTO nombre (paterno, materno, nombre, ci, exp, fecha_nac, complemento, idnacionalidad, idgenero) ";
            $sql0.= " VALUES ('$paterno','$materno','$nombre','$ci','','$fecha_nac','','1','$idgenero') ";
            $result0 = mysqli_query($link,$sql0);   
            $idnombre_paciente = mysqli_insert_id($link);

            $_SESSION['idnombre_paciente_ss'] = $idnombre_paciente;

        header("Location:prepara_paciente.php");
        }
}

/*********** Crear registros para fichas epidemiologicas (END) *************/
?>