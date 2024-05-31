<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha 	 = date("Y-m-d");
$hora    = date("H:i");
$gestion = date("Y");


/*********** Guarda el registro de dterminante de la salud (BEGIN) *************/
$idcarpeta_familiar = '2';
$iddeterminante_salud = '2';
$idcat_determinante_salud = '14';
$iditem_determinante_salud = 72;

foreach($_POST['campo'] as $campo) {

    echo "<p>Valor recibido: $campo</p>";
    echo $iditem_determinante_salud;

    $sql_a = " INSERT INTO determinante_salud_cf (idcarpeta_familiar, iddeterminante_salud, idcat_determinante_salud, iditem_determinante_salud, valor_cf, fecha_registro, hora_registro, idusuario) ";
    $sql_a.= " VALUES ('$idcarpeta_familiar','$iddeterminante_salud','$idcat_determinante_salud','$iditem_determinante_salud','$campo','$fecha','$hora','1') ";
    $result_a = mysqli_query($link,$sql_a);  

    $iditem_determinante_salud = $iditem_determinante_salud+1;
}
/*********** Guarda el registro de dterminante de la salud (END) *************/
?>