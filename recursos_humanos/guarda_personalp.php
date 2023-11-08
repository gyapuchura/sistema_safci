<?php include("../cabf_o.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha 	 = date("Y-m-d");
$hora    = date("h:i");
$gestion = date("Y");

//-----DATOS ENVIADOS EN EL FORMULARIO DE PREINSCRIPCION ----- //
$nombre      = '';
$paterno     = '';
$materno     = '';
$ci          = '';
$complemento = '';
$exp         = '';

//----- Guardamos datos de usuario nuevo ------//

if (isset($nombre, $paterno, $materno, $ci, $exp)) 
{
    echo "las variables nombre, paterno, materno, ci, exp fueron validadas";

} else {

    echo "No se valido nada!!!";
        
}

?>
