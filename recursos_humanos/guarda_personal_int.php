<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];


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

$correo  = $link->real_escape_string($_POST['correo']);
$celular = $link->real_escape_string($_POST['celular']);
$direccion_dom = $link->real_escape_string($_POST['direccion_dom']);


$iddependencia = $_POST['iddependencia'];

//para el caso de participante del Ministerio de Salud y Deportes.
$idministerio = $_POST['idministerio'];
$iddireccion  = $_POST['iddireccion'];
$idarea       = $_POST['idarea'];
$cargo_mds    = $link->real_escape_string($_POST['cargo_mds']);
$item_mds     = $link->real_escape_string($_POST['item_mds']);

//para el caso de participante de una Red de salud.
$iddepartamento = $_POST['iddepartamento'];
$idred_salud    = $_POST['idred_salud'];
$idestablecimiento_salud = $_POST['idestablecimiento_salud'];
$cargo_red_salud = $link->real_escape_string($_POST['cargo_red_salud']);
$item_red_salud = $link->real_escape_string($_POST['item_red_salud']);

//----- Guardamos datos de usuario nuevo ------//

//verificamos existencia del número de cedula de identidad y rescatamos los datos en sesion.
    $sql9 = " SELECT idnombre, paterno, materno, nombre, ci FROM nombre WHERE ci='$ci' ";
    $result9 = mysqli_query($link,$sql9);
      if ($row9 = mysqli_fetch_array($result9)) {
         
            $_SESSION['idnombre_inscrito_ss'] = $row9[0]; 
            $_SESSION['nombre_inscrito_ss']   = $row9[3]; 
            $_SESSION['paterno_inscrito_ss']  = $row9[1]; 
            $_SESSION['materno_inscrito_ss']  = $row9[2]; 
            $_SESSION['ci_inscrito_ss']       = $row9[4];  

            header("Location:personal_existe.php");
      }  
      else {

  /* Primero Insertamos los datos en la tabla de nombres */
  $sql0 = " INSERT INTO nombre ( paterno, materno, nombre, ci, exp, fecha_nac, complemento, idnacionalidad , idgenero ) ";
  $sql0.= " VALUES ('$paterno','$materno','$nombre','$ci','$exp','$fecha_nac','$complemento','$idnacionalidad','$idgenero') ";
  $result0 = mysqli_query($link,$sql0);
  
  $idnombre = mysqli_insert_id($link);

 /* Primero Insertamos los datos en la tabla de usuarios */
  $sql7 = " INSERT INTO usuarios (idnombre, usuario, password, fecha, condicion, perfil ) ";
  $sql7.= " VALUES ('$idnombre','$ci','$ci','$fecha','ACTIVO','PERSONAL')";
  $result7 = mysqli_query($link,$sql7);  

  $idusuario_in = mysqli_insert_id($link);

  $sql1 = " INSERT INTO nombre_datos (idnombre, idusuario, idformacion_academica, idprofesion, idespecialidad_medica, correo, celular, iddepartamento, direccion_dom ) ";
  $sql1.= " VALUES ('$idnombre','$idusuario_in','$idformacion_academica','$idprofesion','$idespecialidad_medica','$correo','$celular','$iddepartamento','$direccion_dom' ) ";
  $result1 = mysqli_query($link,$sql1);

  $idnombre_datos = mysqli_insert_id($link);

//----- Obtenemos el codigo y correlativo de inscripcion ------//

$sqlm="SELECT MAX(correlativo) FROM personal WHERE gestion='$gestion' ";
$resultm=mysqli_query($link,$sqlm);
$rowm=mysqli_fetch_array($resultm);

$correlativo=$rowm[0]+1;

$codigo="PS/MSYD-".$correlativo."-".$ci."-".$gestion;


//----- Realizamos la seleccion de tipo de dependencias ------//

if ($iddependencia == '1') {
//------ DEPENDE DE OTRA ENTIDAD -------------//

    $sql2 = " INSERT INTO dato_laboral (idnombre, idusuario, iddependencia, entidad, cargo_entidad, ";
    $sql2.= " idministerio, iddireccion, idarea, cargo_mds, iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud, item_mds, item_red_salud ) ";
    $sql2.= " VALUES ('$idnombre','$idusuario_in','$iddependencia','$entidad','$cargo_entidad',";
    $sql2.= " '0','0','0','','$iddepartamento','0','0','','','') ";
    $result2 = mysqli_query($link,$sql2);

    $iddato_laboral = mysqli_insert_id($link);

    $sql8 = " INSERT INTO personal (idusuario, idnombre, idnombre_datos, iddato_laboral, correlativo, codigo, ";
    $sql8.= " idestado_personal,fecha_registro, hora_registro, gestion)";
    $sql8.= " VALUES ('$idusuario_in','$idnombre','$idnombre_datos','$iddato_laboral','$correlativo','$codigo', ";
    $sql8.= " '1','$fecha','$hora','$gestion')";
    $result8 = mysqli_query($link,$sql8);  

    $idpersonal = mysqli_insert_id($link);
    $_SESSION['idpersonal_ss'] = $idpersonal; 

    header("Location:mostrar_personal_int.php");

} else {
    if ($iddependencia == '2') {

//------- DEPENDE DEL MINISTERIO DE SALUD Y DEPORTES -------//

        $sql2 = " INSERT INTO dato_laboral (idnombre, idusuario, iddependencia, entidad, cargo_entidad, ";
        $sql2.= " idministerio, iddireccion, idarea, cargo_mds, iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud, item_mds, item_red_salud ) ";
        $sql2.= " VALUES ('$idnombre','$idusuario_in','$iddependencia','','',";
        $sql2.= " '$idministerio','$iddireccion','$idarea','$cargo_mds','$iddepartamento','0','0','','$item_mds','') ";
        $result2 = mysqli_query($link,$sql2);
        $iddato_laboral = mysqli_insert_id($link);

        $sql8 = " INSERT INTO personal (idusuario, idnombre, idnombre_datos, iddato_laboral, correlativo, codigo, ";
        $sql8.= " idestado_personal,fecha_registro, hora_registro, gestion)";
        $sql8.= " VALUES ('$idusuario_in','$idnombre','$idnombre_datos','$iddato_laboral','$correlativo','$codigo', ";
        $sql8.= " '1','$fecha','$hora','$gestion')";
        $result8 = mysqli_query($link,$sql8);  
        $idpersonal = mysqli_insert_id($link);

        $sql9 = " INSERT INTO cargo_mds (idministerio, iddireccion, idarea, cargo_mds, item_mds)";
        $sql9.= " VALUES ('$idministerio','$iddireccion','$idarea','$cargo_mds','$item_mds')";
        $result9 = mysqli_query($link,$sql9);  
      
        $_SESSION['idpersonal_ss'] = $idpersonal; 
        $_SESSION['codigo_ss'] = $codigo; 

        header("Location:mostrar_personal_int.php");

    } else {
        if ($iddependencia == '3') {

// --------- DEPENDE DE UNA RED DE SALUD ------------ //

        $sql2 = " INSERT INTO dato_laboral (idnombre, idusuario, iddependencia, entidad, cargo_entidad, ";
        $sql2.= " idministerio, iddireccion, idarea, cargo_mds, iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud, item_mds, item_red_salud ) ";
        $sql2.= " VALUES ('$idnombre','$idusuario_in','$iddependencia','','',";
        $sql2.= "  '0','0','0','','$iddepartamento','$idred_salud','$idestablecimiento_salud','$cargo_red_salud','','$item_red_salud' ) ";
        $result2 = mysqli_query($link,$sql2);

        $iddato_laboral = mysqli_insert_id($link);

        $sql8 = " INSERT INTO personal (idusuario, idnombre, idnombre_datos, iddato_laboral, correlativo, codigo, ";
        $sql8.= " idestado_personal,fecha_registro, hora_registro, gestion)";
        $sql8.= " VALUES ('$idusuario_in','$idnombre','$idnombre_datos','$iddato_laboral','$correlativo','$codigo', ";
        $sql8.= " '1','$fecha','$hora','$gestion')";
        $result8 = mysqli_query($link,$sql8);  
        $idpersonal = mysqli_insert_id($link);

        $_SESSION['idpersonal_ss'] = $idpersonal; 
        $_SESSION['codigo_ss'] = $codigo;  

        $sql9 = " INSERT INTO cargo_red_salud (idred_salud, idestablecimiento_salud, cargo_red_salud, item_red_salud)";
        $sql9.= " VALUES ('$idred_salud','$idestablecimiento_salud','$cargo_red_salud','$item_red_salud' )";
        $result9 = mysqli_query($link,$sql9);  
    
        header("Location:mostrar_personal_int.php");

        } else {
//------ En caso de existir otro tipo de dependencia laboral del interesado ------//           
            }
        }
    }
}
    
?>
