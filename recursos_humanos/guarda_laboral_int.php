<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha 		  = date("Y-m-d");
$gestion      = date("Y");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$idpersonal_ss = $_SESSION['idpersonal_ss'];
$codigo_ss     = $_SESSION['codigo_ss'];

//-----DATOS ENVIADOS EN EL FORMULARIO DE PREINSCRIPCION ----- //

$iddependencia = $_POST['iddependencia'];
$idusuario_per = $_POST['idusuario_per'];
$idnombre_per  = $_POST['idnombre_per'];

  //para el caso de participante de otra entidad.
  $entidad       = $link->real_escape_string(htmlentities($_POST['entidad']));
  $cargo_entidad = $link->real_escape_string(htmlentities($_POST['cargo_entidad']));
  
  //para el caso de personal del Ministerio de Salud y Deportes.
  $idministerio = $_POST['idministerio'];
  $iddireccion  = $_POST['iddireccion'];
  $idarea       = $_POST['idarea'];
  $cargo_mds    = $link->real_escape_string(htmlentities($_POST['cargo_mds']));
  $item_mds     = $link->real_escape_string(htmlentities($_POST['item_mds']));
  
  //para el caso de personal de una Red de salud.
  $iddepartamento = $_POST['iddepartamento'];
  $idred_salud    = $_POST['idred_salud'];
  $idestablecimiento_salud = $_POST['idestablecimiento_salud'];
  $cargo_red_salud = $link->real_escape_string(htmlentities($_POST['cargo_red_salud']));
  $item_red_salud  = $link->real_escape_string(htmlentities($_POST['item_red_salud']));

//----- Realizamos la seleccion de tipo de dependencias ------//

if ($iddependencia == '1') {
//------ DEPENDE DE OTRA ENTIDAD -------------//

    $sql2 = " INSERT INTO dato_laboral (idnombre, idusuario, iddependencia, entidad, cargo_entidad, ";
    $sql2.= " idministerio, iddireccion, idarea, cargo_mds, iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud, item_mds, item_red_salud ) ";
    $sql2.= " VALUES ('$idnombre_per','$idusuario_per','$iddependencia','$entidad','$cargo_entidad',";
    $sql2.= " '0','0','0','','$iddepartamento','0','0','','','') ";
    $result2 = mysqli_query($link,$sql2);

    $iddato_laboral = mysqli_insert_id($link);

    $sql3.= " UPDATE personal SET iddato_laboral='$iddato_laboral' WHERE idpersonal='$idpersonal_ss' ";
    $result3 = mysqli_query($link,$sql3);

    header("Location:mensaje_laboral_personal.php");

} else {
    if ($iddependencia == '2') {

//------- DEPENDE DEL MINISTERIO DE SALUD Y DEPORTES -------//

        $sql2 = " INSERT INTO dato_laboral (idnombre, idusuario, iddependencia, entidad, cargo_entidad, ";
        $sql2.= " idministerio, iddireccion, idarea, cargo_mds, iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud, item_mds, item_red_salud ) ";
        $sql2.= " VALUES ('$idnombre_per','$idusuario_per','$iddependencia','','', ";
        $sql2.= " '$idministerio','$iddireccion','$idarea','$cargo_mds','$iddepartamento','0','0','','$item_mds','') ";
        $result2 = mysqli_query($link,$sql2);

        $iddato_laboral = mysqli_insert_id($link);

        $sql3.= " UPDATE personal SET iddato_laboral='$iddato_laboral' WHERE idpersonal='$idpersonal_ss' ";
        $result3 = mysqli_query($link,$sql3);

        header("Location:mensaje_laboral_personal.php");

    } else {
        if ($iddependencia == '3') {

// --------- DEPENDE DE UNA RED DE SALUD ------------ //

        $sql2 = " INSERT INTO dato_laboral (idnombre, idusuario, iddependencia, entidad, cargo_entidad, ";
        $sql2.= " idministerio, iddireccion, idarea, cargo_mds, iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud, item_mds, item_red_salud ) ";
        $sql2.= " VALUES ('$idnombre_per','$idusuario_per','$iddependencia','','',";
        $sql2.= "  '0','0','0','','$iddepartamento','$idred_salud','$idestablecimiento_salud','$cargo_red_salud','','$item_red_salud' ) ";
        $result2 = mysqli_query($link,$sql2);

        $iddato_laboral = mysqli_insert_id($link);

        $sql3.= " UPDATE personal SET iddato_laboral='$iddato_laboral' WHERE idpersonal='$idpersonal_ss' ";
        $result3 = mysqli_query($link,$sql3);

        header("Location:mensaje_laboral_personal.php");

        } else {
//------ En caso de existir otro tipo de dependencia laboral del interesado ------//           
            }
        }
    }

?>
