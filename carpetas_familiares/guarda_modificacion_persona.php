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

$idnombre_persona_ss = $_SESSION['idnombre_persona_ss'];

/*********** ENVIO DATOS DEL PÀCIENTE *************/
$ci             = $link->real_escape_string($_POST['ci']);
$nombre         = $link->real_escape_string(mb_strtoupper($_POST['nombre']));
$paterno        = $link->real_escape_string(mb_strtoupper($_POST['paterno']));
$materno        = $link->real_escape_string(mb_strtoupper($_POST['materno']));
$idgenero       = $_POST['idgenero'];
$idnacionalidad = $_POST['idnacionalidad'];
$fecha_nac      = $_POST['fecha_nac'];
$complemento    = $link->real_escape_string(mb_strtoupper($_POST['complemento']));


/*********** modificar el regsitro de datos personales de la persona (BEGIN) *************/

$sql0 = " UPDATE nombre SET ci ='$ci', complemento='$complemento', nombre = '$nombre', paterno = '$paterno', materno ='$materno', ";
$sql0.= " idgenero = '$idgenero', fecha_nac = '$fecha_nac', idnacionalidad='$idnacionalidad' WHERE idnombre = '$idnombre_persona_ss' ";
$result0 = mysqli_query($link,$sql0);   

$result1 = mysqli_query($link,$sql1);   

header("Location:mensaje_mod_success.php");

/*********** modificar el regsitro de datos personales de la persona (END) *************/
?>
