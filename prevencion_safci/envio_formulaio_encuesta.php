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

$sql_es = " SELECT iddato_laboral, idestablecimiento_salud, iddepartamento, idred_salud FROM dato_laboral WHERE idusuario='$idusuario_ss' ORDER BY iddato_laboral DESC LIMIT 1  ";
$result_es = mysqli_query($link,$sql_es);
$row_es = mysqli_fetch_array($result_es);

$idestablecimiento_salud_enc = $row_es[1];
$iddepartamento_enc          = $row_es[2];
$idred_salud_enc             = $row_es[3];

$sql_e    = " SELECT iddepartamento, idred_salud, idmunicipio FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud_enc' ";
$result_e = mysqli_query($link,$sql_e);
$row_e    = mysqli_fetch_array($result_e);

$idmunicipio    = $row_e[2];

$idintegrante_cf_ss           = $_SESSION['idintegrante_cf_ss'];
$idnombre_integrante_ss       = $_SESSION['idnombre_integrante_ss'];
$edad_ss                      = $_SESSION['edad_ss'];

echo $idnombre_integrante_ss.'</br></br></br>';

$talla                = $link->real_escape_string($_POST['talla']);
$peso                 = $link->real_escape_string($_POST['peso']);
$temperatura          = $link->real_escape_string($_POST['temperatura']);
$frec_cardiaca        = $_POST['frec_cardiaca'];
$frec_respiratoria    = $_POST['frec_respiratoria'];
$presion_arterial     = $_POST['presion_arterial'];
$presion_arterial_d   = $_POST['presion_arterial_d'];
$perimetro_cefalico   = $_POST['perimetro_cefalico'];

echo $talla.'</br>';
echo $peso.'</br>';
echo $temperatura.'</br>';
echo $frec_cardiaca.'</br>';
echo $frec_respiratoria.'</br>';
echo $presion_arterial.'</br>';
echo $presion_arterial_d.'</br>';
echo $perimetro_cefalico.'</br></br>';



$respuesta = $_POST['respuesta'];
    
    foreach($_POST['idpregunta_encuesta'] as $clave => $idpregunta_encuesta_i) {
    
        echo $idpregunta_encuesta_i." -> ";
        echo $respuesta[$clave]."</br>";
    
    }


    foreach($_POST['iditem_senal_cancer'] as $iditem_senal_cancer_i) {
    
        echo $iditem_senal_cancer_i."</br>";
    
    }


        /*********** Guarda el registro de encuesta de deteccion del cancer (END) *************/
        ?>