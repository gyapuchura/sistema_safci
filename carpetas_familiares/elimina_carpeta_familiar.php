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

/*********** ENVIO DATOS PARA ELIMINAR INTEGRANTE *************/

$idcarpeta_familiar = $_POST['idcarpeta_familiar'];

/* BORRAMOS EL REGISTRO*/

$sql = " DELETE FROM integrante_datos_cf WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM integrante_ap_sano WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM integrante_factor_riesgo WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM integrante_morbilidad WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM integrante_discapacidad WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM integrante_subsector_salud WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM integrante_beneficiario WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM integrante_tradicional WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM integrante_defuncion WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM integrante_cf WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);


$sql = " DELETE FROM desconsolidacion_cf WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM reasignacion_cf WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);



$sql = " DELETE FROM idioma_cf WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM transporte_cf WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM determinante_salud_cf WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM ayuda_familiar_cf WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM evaluacion_salud_familiar_cf WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM evaluacion_familiar_cf WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM evaluacion_determinante_salud WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM etapa_familiar_cf WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM estructura_familiar_cf WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM funcionalidad_familiar_cf WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM ubicacion_cf WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM seguimiento_cf WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);


$sql = " DELETE FROM socio_economica_cf WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);

$sql = " DELETE FROM tenencia_animales_cf WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);


$sql = " DELETE FROM carpeta_familiar WHERE idcarpeta_familiar ='$idcarpeta_familiar' ";
$result = mysqli_query($link,$sql);


header("Location:mensaje_cf_eliminada.php");

?>