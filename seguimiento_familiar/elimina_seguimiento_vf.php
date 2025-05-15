<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idcarpeta_familiar_ss = $_SESSION['idcarpeta_familiar_ss'];

$idnombre_academico = $_POST['idnombre_academico'];

/* BORRAMOS EL REGISTRO VISITA FAMILIAR*/

$sql5 =" SELECT idseguimiento_cf FROM seguimiento_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
$result5 = mysqli_query($link,$sql5);
if ($row5 = mysqli_fetch_array($result5)){
mysqli_field_seek($result5,0);
while ($field5 = mysqli_fetch_field($result5)){
} do { 

    $sql = " DELETE FROM visita_cf WHERE idseguimiento_cf='$row5[0]' ";
    $result = mysqli_query($link,$sql);

}
while ($row5 = mysqli_fetch_array($result5));
} else {
}

    $sql2 = " DELETE FROM seguimiento_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
    $result2 = mysqli_query($link,$sql2);

header("Location:mensaje_seguimiento_eliminado.php");
?>