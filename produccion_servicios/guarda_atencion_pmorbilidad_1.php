<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");

$idusuario_ss  = $_SESSION['idusuario_ss'];
$idnombre_ss   = $_SESSION['idnombre_ss'];
$perfil_ss     = $_SESSION['perfil_ss'];

$idcarpeta_familiar_ss      = $_SESSION['idcarpeta_familiar_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idintegrante_cf_ss         = $_SESSION['idintegrante_cf_ss'];
$idnombre_integrante_ss     = $_SESSION['idnombre_integrante_ss'];
$edad_ss                    = $_SESSION['edad_ss'];

/*********** ENVIO DATOS DEL PÀCIENTE *************/

$idrepeticion    = $_POST['idrepeticion'];
$idtipo_consulta = $_POST['idtipo_consulta'];
$idtipo_atencion = $_POST['idtipo_atencion'];

$motivo_consulta1     = $link->real_escape_string($_POST['motivo_consulta1']);
$idpatologia1         = $_POST['idpatologia1'];
$idtipo_medicamento11 = $_POST['idtipo_medicamento11'];
$idmedicamento11      = $_POST['idmedicamento11'];

$idtipo_medicamento12 = $_POST['idtipo_medicamento12'];
$idmedicamento12      = $_POST['idmedicamento12'];

$motivo_consulta2     = $link->real_escape_string($_POST['motivo_consulta2']);
$idpatologia2         = $_POST['idpatologia2'];
$idtipo_medicamento21 = $_POST['idtipo_medicamento21'];
$idmedicamento21      = $_POST['idmedicamento21'];

$idtipo_medicamento22 = $_POST['idtipo_medicamento22'];
$idmedicamento22      = $_POST['idmedicamento22'];

/*********** DETERMINACION DE VARIABLES *************/

$sql_e    = "SELECT iddepartamento, idred_salud, idmunicipio FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud_ss' ";
$result_e = mysqli_query($link,$sql_e);
$row_e    = mysqli_fetch_array($result_e);

$sql_int    = "SELECT idgenero FROM nombre WHERE idnombre ='$idnombre_integrante_ss' ";
$result_int = mysqli_query($link,$sql_int);
$row_int    = mysqli_fetch_array($result_int);

$sql_nac    = "SELECT idnacion FROM integrante_cf WHERE idintegrante_cf ='$idintegrante_cf_ss' ";
$result_nac = mysqli_query($link,$sql_nac);
$row_nac    = mysqli_fetch_array($result_nac);

$iddepartamento = $row_e[0];
$idred_salud    = $row_e[1];
$idmunicipio    = $row_e[2];
$idgenero       = $row_int[0];
$idnacion       = $row_nac[0];

$sqlm    = "SELECT MAX(correlativo) FROM atencion_psafci WHERE gestion='$gestion'  ";
$resultm = mysqli_query($link,$sqlm);
$rowm    = mysqli_fetch_array($resultm);

$correlativo = $rowm[0]+1;

$codigo = "PSAFCI-ATENCION-".$correlativo."/".$gestion;

$sql0 = " INSERT INTO atencion_psafci (iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idnombre, edad, idgenero, ";
$sql0.= " idrepeticion, idtipo_consulta, idtipo_atencion, idnacion, codigo, correlativo,  gestion, fecha_registro, hora_registro, idusuario)  ";
$sql0.= " VALUES ('$iddepartamento','$idred_salud','$idmunicipio','$idestablecimiento_salud_ss','$idnombre_integrante_ss','$edad_ss','$idgenero', ";
$sql0.= " '$idrepeticion','$idtipo_consulta','$idtipo_atencion','$idnacion','$codigo','$correlativo','$gestion', '$fecha','$hora','$idusuario_ss')";
$result0 = mysqli_query($link,$sql0);   
$idatencion_psafci = mysqli_insert_id($link);

/**** se guarda el primer diagnostico con su(s) tratamientos *******/

$sql_dg1 = " INSERT INTO diagnostico_psafci (idatencion_psafci, motivo_consulta, idpatologia, fecha_registro, hora_registro, idusuario) ";
$sql_dg1.= " VALUES ('$idatencion_psafci','$motivo_consulta1','$idpatologia1','$fecha','$hora','$idusuario_ss') ";
$result_dg1 = mysqli_query($link,$sql_dg1);   
$iddiagnostico_psafci_1 = mysqli_insert_id($link);

$sql_tr1 = " INSERT INTO tratamiento_psafci (idatencion_psafci, iddiagnostico_psafci, idtipo_medicamento, idmedicamento, fecha_registro, hora_registro, idusuario) ";
$sql_tr1.= " VALUES ('$idatencion_psafci','$iddiagnostico_psafci_1','$idtipo_medicamento11','$idmedicamento11','$fecha','$hora','$idusuario_ss') ";
$result_tr1 = mysqli_query($link,$sql_tr1);

if (!($idtipo_medicamento12 == "" && $idmedicamento12 == "" )) {
    
    $sql_tr11 = " INSERT INTO tratamiento_psafci (idatencion_psafci, iddiagnostico_psafci, idtipo_medicamento, idmedicamento, fecha_registro, hora_registro, idusuario) ";
    $sql_tr11.= " VALUES ('$idatencion_psafci','$iddiagnostico_psafci_1','$idtipo_medicamento12','$idmedicamento12','$fecha','$hora','$idusuario_ss') ";
    $result_tr11 = mysqli_query($link,$sql_tr11);
    
} 


if (!($motivo_consulta2 == "" && $idpatologia2 == "" && $idtipo_medicamento21 == "" && $idmedicamento21 == "")) {
    
$sql_dg2 = " INSERT INTO diagnostico_psafci (idatencion_psafci, motivo_consulta, idpatologia, fecha_registro, hora_registro, idusuario) ";
$sql_dg2.= " VALUES ('$idatencion_psafci','$motivo_consulta2','$idpatologia2','$fecha','$hora','$idusuario_ss') ";
$result_dg2 = mysqli_query($link,$sql_dg2);   
$iddiagnostico_psafci_2 = mysqli_insert_id($link);

        $sql_tr2 = " INSERT INTO tratamiento_psafci (idatencion_psafci, iddiagnostico_psafci, idtipo_medicamento, idmedicamento, fecha_registro, hora_registro, idusuario) ";
        $sql_tr2.= " VALUES ('$idatencion_psafci','$iddiagnostico_psafci_2','$idtipo_medicamento21','$idmedicamento21','$fecha','$hora','$idusuario_ss') ";
        $result_tr2 = mysqli_query($link,$sql_tr);


 if (!($idtipo_medicamento22 == "" && $idmedicamento22 == "")) {
    
        $sql_tr22 = " INSERT INTO tratamiento_psafci (idatencion_psafci, iddiagnostico_psafci, idtipo_medicamento, idmedicamento, fecha_registro, hora_registro, idusuario) ";
        $sql_tr22.= " VALUES ('$idatencion_psafci','$iddiagnostico_psafci_2','$idtipo_medicamento22','$idmedicamento22','$fecha','$hora','$idusuario_ss') ";
        $result_tr22 = mysqli_query($link,$sql_tr22);  

}
}
$_SESSION['idatencion_psafci_ss'] = $idatencion_psafci;

header("Location:mostrar_atencion_psafci.php");
      

echo "Nro. de diagnosticos = ".$diagnosticos."</br>";

echo "Nro. de tratamientos_1 = ".$tratamientos_1."</br>";
echo "Nro. de tratamientos_2 = ".$tratamientos_2."</br>";

echo "motivo_consulta1 = ".$motivo_consulta1."</br>";
echo "idpatologia1 = ".$idpatologia1."</br>";
echo "idtipo_medicamento_11 = ".$idtipo_medicamento_11."</br>";
echo "idmedicamento_11 = ".$idmedicamento_11."</br>";
echo "idtipo_medicamento_12 = ".$idtipo_medicamento_12."</br>";
echo "idmedicamento_12 = ".$idmedicamento_12."</br>";

echo "motivo_consulta2 = ".$motivo_consulta2."</br>";
echo "idpatologia2 = ".$idpatologia2."</br>";
echo "idtipo_medicamento_21 = ".$idtipo_medicamento_21."</br>";
echo "idmedicamento_21 = ".$idmedicamento_21."</br>";
echo "idtipo_medicamento_22 = ".$idtipo_medicamento_22."</br>";
echo "idmedicamento_22 = ".$idmedicamento_22."</br>";



?>