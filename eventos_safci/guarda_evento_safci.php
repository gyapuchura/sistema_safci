<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$fecha 	 = date("Y-m-d");
$hora    = date("H:i");
$gestion = date("Y");

//-----DATOS ENVIADOS EN EL FORMULARIO DE ESTABLECIMIENTO DE SALUD ----- //

$iddepartamento          = $_POST['iddepartamento'];
$idmunicipio             = $_POST['idmunicipio'];
$idestablecimiento_salud = $_POST['idestablecimiento_salud'];
$idcat_evento_safci      = $_POST['idcat_evento_safci'];
$idtipo_evento_safci     = $_POST['idtipo_evento_safci'];
$descripcion             = $link->real_escape_string($_POST['descripcion']);

if ($iddepartamento == '' || $idmunicipio == '' || $idestablecimiento_salud == '' || $idcat_evento_safci == '' || $idtipo_evento_safci == '') {
    
    header("Location:nuevo_evento_safci.php");
}  
else {

    $sql_d = "SELECT sigla FROM departamento WHERE iddepartamento='$iddepartamento' ";
    $result_d = mysqli_query($link,$sql_d);
    $row_d = mysqli_fetch_array($result_d);

    $sql_t = "SELECT tipo_evento_safci FROM tipo_evento_safci WHERE idtipo_evento_safci='$idtipo_evento_safci' ";
    $result_t = mysqli_query($link,$sql_t);
    $row_t = mysqli_fetch_array($result_t);

    $tipo_evento = $row_t[0];
    $departamento = $row_d[0];

    $sqlm = "SELECT MAX(correlativo) FROM evento_safci WHERE gestion='$gestion' ";
    $resultm = mysqli_query($link,$sqlm);
    $rowm = mysqli_fetch_array($resultm);

    $correlativo=$rowm[0]+1;

    $codigo="SAFCI/".$tipo_evento."/".$departamento."-".$correlativo."/".$gestion;

        $sql8 = " INSERT INTO evento_safci (iddepartamento, idmunicipio, idestablecimiento_salud, gestion, correlativo, codigo, idcat_evento_safci, idtipo_evento_safci, ";
        $sql8.= " descripcion, fecha_registro, hora_registro, idusuario)";
        $sql8.= " VALUES ('$iddepartamento','$idmunicipio','$idestablecimiento_salud','$gestion','$correlativo','$codigo','$idcat_evento_safci','$idtipo_evento_safci', ";
        $sql8.= " '$descripcion','$fecha','$hora','$idusuario_ss')";
        $result8 = mysqli_query($link,$sql8);  
        $idevento_safci = mysqli_insert_id($link);

        $_SESSION['idevento_safci_ss'] = $idevento_safci;  
    
        header("Location:mostrar_evento_safci.php");
    }


?>
