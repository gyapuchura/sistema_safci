<?php include("../cabf_o.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha 	 = date("Y-m-d");
$hora    = date("h:i");
$gestion = date("Y");
 
//-----DATOS ENVIADOS EN EL FORMULARIO DE PREINSCRIPCION ----- //
$nombre      = $link->real_escape_string($_POST['nombre']);
$paterno     = $link->real_escape_string($_POST['paterno']);
$materno     = $link->real_escape_string($_POST['materno']);
$ci          = $link->real_escape_string($_POST['ci']);
$complemento = $link->real_escape_string($_POST['complemento']);
$exp         = $link->real_escape_string($_POST['exp']);

$fecha_nac   = $_POST['fecha_nac'];

$idgenero              = $_POST['idgenero'];

$idformacion_academica = $_POST['idformacion_academica'];
$idprofesion           = $_POST['idprofesion'];
$idespecialidad_medica = $_POST['idespecialidad_medica'];  
$descripcion_academica = $link->real_escape_string($_POST['descripcion_academica']);
$entidad_academica     = $link->real_escape_string($_POST['entidad_academica']);
$gestion_ac            = $link->real_escape_string($_POST['gestion_ac']);

$idformacion_academica_p = $_POST['idformacion_academica_p'];
$descripcion_academica_p = $link->real_escape_string($_POST['descripcion_academica_p']);
$entidad_academica_p     = $link->real_escape_string($_POST['entidad_academica_p']);
$gestion_p               = $link->real_escape_string($_POST['gestion_p']);

$correo        = $link->real_escape_string($_POST['correo']);
$celular       = $link->real_escape_string($_POST['celular']);
$direccion_dom = $link->real_escape_string($_POST['direccion_dom']);
$celular_emergencia = $link->real_escape_string($_POST['celular_emergencia']);

$iddependencia = $_POST['iddependencia'];

//para el caso de participante del Ministerio de Salud y Deportes.

//para el caso de participante de una Red de salud.
$iddepartamento      = $_POST['iddepartamento'];
$idred_salud         = $_POST['idred_salud'];
$idestablecimiento_salud = $_POST['idestablecimiento_salud'];
$cargo_red_salud     = $link->real_escape_string($_POST['cargo_red_salud']);
$idcargo_organigrama = $_POST['idcargo_organigrama'];
$item_red_salud      = $link->real_escape_string($_POST['item_red_salud']);

//----- Guardamos datos de usuario nuevo ------//



echo $nombre;
echo '</br>';
echo $paterno;
echo '</br>';
echo $materno;
echo '</br>';
echo $ci;
echo '</br>';
echo $complemento;
echo '</br>';
echo $exp;
echo '</br>';
echo $fecha_nac;
echo '</br>';
echo $idnacionalidad;
echo '</br>';
echo $idgenero 



?>
