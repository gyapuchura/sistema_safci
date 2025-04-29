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

$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];

/*********** ENVIO DATOS DEL PÀCIENTE *************/
$nombre        = $link->real_escape_string(mb_strtoupper($_POST['nombre']));
$paterno       = $link->real_escape_string(mb_strtoupper($_POST['paterno']));
$materno       = $link->real_escape_string(mb_strtoupper($_POST['materno']));
$ci            = $_POST['ci'];
$complemento   = $link->real_escape_string($_POST['complemento']);
$idgenero       = $_POST['idgenero'];
$fecha_nac      = $_POST['fecha_nac'];
$idnacionalidad = $_POST['idnacionalidad'];
$idnacion       = $_POST['idnacion'];

$fecha_nacimiento = $fecha_nac;
$dia=date("d");
$mes=date("m");
$ano=date("Y");    
$dianaz=date("d",strtotime($fecha_nacimiento));
$mesnaz=date("m",strtotime($fecha_nacimiento));
$anonaz=date("Y",strtotime($fecha_nacimiento));         
if (($mesnaz == $mes) && ($dianaz > $dia)) {
$ano=($ano-1); }      
if ($mesnaz > $mes) {
$ano=($ano-1);} 

$edad = ($ano-$anonaz);

$idrepeticion    = $_POST['idrepeticion'];
$idtipo_consulta = $_POST['idtipo_consulta'];
$idtipo_atencion = $_POST['idtipo_atencion'];

$idpatologia_ap_sano = $_POST['idpatologia_ap_sano'];
$motivo_consulta     = $link->real_escape_string($_POST['motivo_consulta']);

/*********** DETERMINACION DE VARIABLES *************/

$sql_e    = "SELECT iddepartamento, idred_salud, idmunicipio FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud_ss' ";
$result_e = mysqli_query($link,$sql_e);
$row_e    = mysqli_fetch_array($result_e);

$iddepartamento = $row_e[0];
$idred_salud    = $row_e[1];
$idmunicipio    = $row_e[2];

$sqlm    = "SELECT MAX(correlativo) FROM atencion_psafci WHERE gestion='$gestion'  ";
$resultm = mysqli_query($link,$sqlm);
$rowm    = mysqli_fetch_array($resultm);

$correlativo = $rowm[0]+1;

$codigo = "PSAFCI-ATENCION-".$correlativo."/".$gestion;

$sql_c = " INSERT INTO nombre (paterno, materno, nombre, ci, exp, fecha_nac, complemento, idnacionalidad, idgenero) ";
$sql_c.= " VALUES ('$paterno','$materno','$nombre','$ci','','$fecha_nac','$complemento','$idnacionalidad','$idgenero') ";
$result_c = mysqli_query($link,$sql_c);   
$idnombre_paciente = mysqli_insert_id($link);

$sql0 = " INSERT INTO atencion_psafci (iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idnombre, edad, idgenero, ";
$sql0.= " idrepeticion, idtipo_consulta, idtipo_atencion, idnacion, codigo, correlativo,  gestion, fecha_registro, hora_registro, idusuario)  ";
$sql0.= " VALUES ('$iddepartamento','$idred_salud','$idmunicipio','$idestablecimiento_salud_ss','$idnombre_paciente','$edad','$idgenero', ";
$sql0.= " '$idrepeticion','$idtipo_consulta','$idtipo_atencion','$idnacion','$codigo','$correlativo','$gestion', '$fecha','$hora','$idusuario_ss')";
$result0 = mysqli_query($link,$sql0);   
$idatencion_psafci = mysqli_insert_id($link);

$sql_dg = " INSERT INTO diagnostico_psafci (idatencion_psafci, motivo_consulta, idpatologia, fecha_registro, hora_registro, idusuario) ";
$sql_dg.= " VALUES ('$idatencion_psafci','$motivo_consulta','$idpatologia_ap_sano','$fecha','$hora','$idusuario_ss') ";
$result_dg = mysqli_query($link,$sql_dg);   

$_SESSION['idatencion_psafci_ss'] = $idatencion_psafci;

header("Location:mostrar_atencion_psafci_ncf.php");
      
?>