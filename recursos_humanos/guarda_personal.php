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

$nacimiento  = $_POST['fecha_nac'];
$fecha_n     = explode('/',$nacimiento);
$fecha_nac   = $fecha_n[2].'-'.$fecha_n[1].'-'.$fecha_n[0];

$idnacionalidad        = $_POST['idnacionalidad'];
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

if ($nombre=='' || $paterno=='' || $ci=='') 
{
    header("Location:registro_safci.php");

} else {

//verificamos existencia del número de cedula de identidad y rescatamos los datos en sesion.
    $sql9 = " SELECT idnombre, paterno, materno, nombre, ci FROM nombre WHERE ci='$ci' ";
    $result9 = mysqli_query($link,$sql9);
if ($row9 = mysqli_fetch_array($result9)) {
    
    header("Location:personal_existe.php");
    
}  
else {

    /* Primero Insertamos los datos en la tabla de nombres */
    $sql0 = " INSERT INTO nombre (paterno, materno, nombre, ci, exp, fecha_nac, complemento, idnacionalidad, idgenero) ";
    $sql0.= " VALUES ('$paterno','$materno','$nombre','$ci','$exp','$fecha_nac','$complemento','$idnacionalidad','$idgenero') ";
    $result0 = mysqli_query($link,$sql0);   
    $idnombre = mysqli_insert_id($link);

    /* Primero Insertamos los datos en la tabla de usuarios */
    $sql7 = " INSERT INTO usuarios (idnombre, usuario, password, fecha, condicion, perfil ) ";
    $sql7.= " VALUES ('$idnombre','$ci','$ci','$fecha','ACTIVO','PERSONAL')";
    $result7 = mysqli_query($link,$sql7);  
    $idusuario_in = mysqli_insert_id($link);

    $sql1 = " INSERT INTO nombre_datos (idnombre, idusuario, idformacion_academica, idprofesion, idespecialidad_medica, correo, celular, iddepartamento, direccion_dom, celular_emergencia ) ";
    $sql1.= " VALUES ('$idnombre','$idusuario_in','$idformacion_academica','$idprofesion','$idespecialidad_medica','$correo','$celular','$iddepartamento','$direccion_dom','$celular_emergencia' ) ";
    $result1 = mysqli_query($link,$sql1);
    $idnombre_datos = mysqli_insert_id($link);

    $sql10 = " INSERT INTO nombre_academico (idusuario, idnombre, idprofesion, idespecialidad_medica, idformacion_academica, descripcion_academica, entidad_academica, gestion, idformacion_academica_p, descripcion_academica_p, entidad_academica_p, gestion_p) ";
    $sql10.= " VALUES ('$idusuario_in','$idnombre','$idprofesion','$idespecialidad_medica','$idformacion_academica','$descripcion_academica','$entidad_academica','$gestion_ac','$idformacion_academica_p','$descripcion_academica_p','$entidad_academica_p','$gestion_p') ";
    $result10 = mysqli_query($link,$sql10);
    $idnombre_academico = mysqli_insert_id($link);

//----- Obtenemos el codigo y correlativo de PERSONAL ------//

    $sqlm="SELECT MAX(correlativo) FROM personal WHERE gestion='$gestion' ";
    $resultm=mysqli_query($link,$sqlm);
    $rowm=mysqli_fetch_array($resultm);

    $correlativo=$rowm[0]+1;

    $codigo="PS/MSYD-".$correlativo."-".$ci."-".$gestion;

// --------- LUGAR DE TRABAJO - RED DE SALUD ------------ //

        $sql2 = " INSERT INTO dato_laboral (idnombre, idusuario, iddependencia, entidad, cargo_entidad, ";
        $sql2.= " idministerio, iddireccion, idarea, cargo_mds, iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud, item_mds, item_red_salud, idcargo_organigrama ) ";
        $sql2.= " VALUES ('$idnombre','$idusuario_in','$iddependencia','','',";
        $sql2.= "  '0','0','0','','$iddepartamento','$idred_salud','$idestablecimiento_salud','$cargo_red_salud','','$item_red_salud','$idcargo_organigrama' ) ";
        $result2 = mysqli_query($link,$sql2);

        $iddato_laboral = mysqli_insert_id($link);

        $sql8 = " INSERT INTO personal (idusuario, idnombre, idnombre_datos, idnombre_academico, iddato_laboral, correlativo, codigo, ";
        $sql8.= " idestado_personal,fecha_registro, hora_registro, gestion)";
        $sql8.= " VALUES ('$idusuario_in','$idnombre','$idnombre_datos','$idnombre_academico','$iddato_laboral','$correlativo','$codigo', ";
        $sql8.= " '1','$fecha','$hora','$gestion')";
        $result8 = mysqli_query($link,$sql8);  
        $idpersonal = mysqli_insert_id($link);

        $_SESSION['idpersonal_ss'] = $idpersonal; 
        $_SESSION['codigo_ss'] = $codigo;  

        $sql11 = " INSERT INTO cargo_red_salud (idred_salud, idestablecimiento_salud, cargo_red_salud, item_red_salud)";
        $sql11.= " VALUES ('$idred_salud','$idestablecimiento_salud','$cargo_red_salud','$item_red_salud' )";
        $result11 = mysqli_query($link,$sql11);  
    
        header("Location:mostrar_personal.php");
    }
        
}


?>
