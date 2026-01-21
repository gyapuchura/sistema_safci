
<?php
require('../fpdf/fpdf.php');
class PDF extends FPDF
{
   //Cabecera de página
   function Header()
   {
        $this->Image('logo_safci.png',62,10,80);
   }

function Footer()
{

$this->SetY(-10);

$this->SetFont('Arial','I',8);

$this->Cell(0,10,'Pagina '.$this->PageNo().'',0,0,'C');

}
}
//---- CODIGO PHP PARA GENERAR DATOS DE INSCRIPCION -----//

include("../inc.config.php");

date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha   	= date("Y-m-d");

session_start(); 

$idpersonal = $_GET['idpersonal'];

//---- CONECTAR CON $_GET['idinscripcion'] ----//
$gestion = date("Y");

$sql_n =" SELECT personal.idpersonal, personal.codigo, personal.idusuario, personal.idnombre, nombre.nombre, nombre.paterno, nombre.materno, nombre.fecha_nac, nombre.ci, nombre.complemento, ";
$sql_n.=" nombre.exp, nacionalidad.nacionalidad, genero.genero, formacion_academica.formacion_academica, profesion.profesion, especialidad_medica.especialidad_medica, ";
$sql_n.=" nombre_datos.correo, nombre_datos.celular, nombre_datos.direccion_dom, nombre_datos.idprofesion, personal.iddato_laboral, nombre_datos.celular_emergencia, personal.fecha_registro ";
$sql_n.=" FROM personal, nombre, nacionalidad, genero, nombre_datos, formacion_academica, profesion, especialidad_medica ";
$sql_n.=" WHERE personal.idnombre=nombre.idnombre AND nombre.idnacionalidad=nacionalidad.idnacionalidad AND nombre.idgenero=genero.idgenero ";
$sql_n.=" AND personal.idnombre_datos=nombre_datos.idnombre_datos AND nombre_datos.idformacion_academica=formacion_academica.idformacion_academica ";
$sql_n.=" AND nombre_datos.idprofesion=profesion.idprofesion AND nombre_datos.idespecialidad_medica=especialidad_medica.idespecialidad_medica ";
$sql_n.=" AND personal.idpersonal='$idpersonal' ";
$result_n = mysqli_query($link,$sql_n);
$row_n = mysqli_fetch_array($result_n);

$nombre_completo = mb_strtoupper($row_n[4].' '.$row_n[5].' '.$row_n[6]);

$fecha_nac    = explode('-',$row_n[7]);
$f_nacimiento = $fecha_nac[2].'/'.$fecha_nac[1].'/'.$fecha_nac[0];

$sql_l = " SELECT iddato_laboral, idusuario, idnombre, iddependencia, entidad, cargo_entidad, idministerio, iddireccion, idarea, cargo_mds,";
$sql_l.= " iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud, item_mds, item_red_salud, idcargo_organigrama ";
$sql_l.= " FROM dato_laboral WHERE iddato_laboral='$row_n[20]' ORDER BY iddato_laboral LIMIT 1";
$result_l = mysqli_query($link,$sql_l);
$row_l = mysqli_fetch_array($result_l);

$sql_ac = " SELECT idnombre_academico, idformacion_academica, descripcion_academica, entidad_academica, gestion, ";
$sql_ac.= " idformacion_academica_p, descripcion_academica_p, entidad_academica_p, gestion_p ";
$sql_ac.= " FROM nombre_academico WHERE idnombre='$row_n[3]' ORDER BY idnombre_academico DESC LIMIT 1 ";
$result_ac = mysqli_query($link,$sql_ac);
$row_ac    = mysqli_fetch_array($result_ac);

$sql_ad = " SELECT idnombre_academico, entidad_academica, gestion FROM nombre_academico ";
$sql_ad.= " WHERE idnombre='$row_n[3]' AND idusuario='$row_n[2]' ORDER BY idnombre_academico LIMIT 1";
$result_ad = mysqli_query($link,$sql_ad);
$row_ad = mysqli_fetch_array($result_ad);

/*
 * Algoritmo para codificacion QR
 *
 * SE emplea el include con el scripti phpqrcode.php
 *
 */
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "phpqrcode.php";

    //capturamos el valor de "data"

    $separador='|';
    $tamano='M';

    $_REQUEST['data'] = 'Código:'.$row_n[1].' Nombre:'.$nombre_completo.' C.I.:'.$row_n[8].' '.$row_n[9].' '.$row_n[10];
    $_REQUEST['size'] = 2 ;
    $_REQUEST['level'] = $tamano ;

    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);


    $filename = $PNG_TEMP_DIR.'test.png';

    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];

    $matrixPointSize = 4;
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


    if (isset($_REQUEST['data'])) {

        //it's very important!
        if (trim($_REQUEST['data']) == '')
            die('data cannot be empty! <a href="?">back</a>');

        // user data
        $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);

    } else {

        //default data
        echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>
        <div align="right">';
        QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);

    }
//Creación del objeto de la clase heredada
$pdf=new PDF('P','mm','Letter');
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);

$pdf->Image($PNG_WEB_DIR.basename($filename),174,235,27);

$pdf->Cell(192,25,'',0,1,'C');

$pdf->Cell(192,10,mb_convert_encoding('REGISTRO DE PERSONAL - SAFCI','iso-8859-1','utf-8'),0,1,'C');
$pdf->SetFont('Arial','',12);
$pdf->Cell(192,10,$row_n[1],0,1,'C');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(192,8,mb_convert_encoding('I. DATOS PERSONALES','iso-8859-1','utf-8'),0,1,'L');

$pdf->SetFont('Arial','',9);
$pdf->Cell(86,5,mb_convert_encoding('NÚMERO DE DOCUMENTO DE IDENTIDAD C.I.','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(106,5,mb_convert_encoding($row_n[8].' '.$row_n[9].' '.$row_n[10],'iso-8859-1','utf-8'),1,1,'L');
$pdf->Cell(86,5,mb_convert_encoding('NOMBRE COMPLETO DEL SOLICITANTE:','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(106,5,mb_convert_encoding($nombre_completo,'iso-8859-1','utf-8'),1,1,'L');
$pdf->Cell(86,5,mb_convert_encoding('FECHA DE NACIMIENTO:','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(106,5,mb_convert_encoding($f_nacimiento ,'iso-8859-1','utf-8'),1,1,'L');
$pdf->Cell(86,5,mb_convert_encoding('TIPO DE NACIONALIDAD:','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(106,5,mb_convert_encoding($row_n[11],'iso-8859-1','utf-8'),1,1,'L');
$pdf->Cell(86,5,mb_convert_encoding('GÉNERO:','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(106,5,mb_convert_encoding($row_n[12],'iso-8859-1','utf-8'),1,1,'L');

$pdf->Cell(86,5,mb_convert_encoding('CORREO ELECTRÓNICO:','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(106,5,mb_convert_encoding($row_n[16],'iso-8859-1','utf-8'),1,1,'L');
$pdf->Cell(86,5,mb_convert_encoding('Nº DE CELULAR:','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(106,5,mb_convert_encoding($row_n[17],'iso-8859-1','utf-8'),1,1,'L');

$pdf->Cell(86,5,mb_convert_encoding('Nº DE CELULAR (EN CASO DE EMERGENCIA):','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(106,5,mb_convert_encoding($row_n[21],'iso-8859-1','utf-8'),1,1,'L');

$pdf->Cell(86,5,mb_convert_encoding('DIRECCIÓN DOMICILIO:','iso-8859-1','utf-8'),1,0,'L');
$pdf->MultiCell(106,5,mb_convert_encoding(mb_strtoupper($row_n[18]),'iso-8859-1','utf-8'),'LTRB','L',false);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(192,8,mb_convert_encoding('II. DATOS COMPLEMENTARIOS','iso-8859-1','utf-8'),0,1,'L');

$pdf->SetFont('Arial','',9);

$pdf->Cell(86,5,mb_convert_encoding('FORMACIÓN ACADÉMICA:','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(106,5,mb_convert_encoding($row_n[13],'iso-8859-1','utf-8'),1,1,'L');
$pdf->Cell(86,5,mb_convert_encoding('PROFESIÓN / OCUPACIÓN:','iso-8859-1','utf-8'),1,0,'L');
$profesion_user = mb_strtoupper($row_n[14]);
$pdf->Cell(106,5,mb_convert_encoding($profesion_user,'iso-8859-1','utf-8'),1,1,'L');
if ($row_n[19] == '1') {
    $pdf->Cell(86,5,mb_convert_encoding('ESPECIALIDAD MÉDICA:','iso-8859-1','utf-8'),1,0,'L');
    $pdf->Cell(106,5,mb_convert_encoding($row_n[15],'iso-8859-1','utf-8'),1,1,'L');
} else {  }
$pdf->Cell(86,5,mb_convert_encoding('ENTIDAD DE FORMACIÓN:','iso-8859-1','utf-8'),1,0,'L');
$pdf->MultiCell(106,5,mb_convert_encoding(mb_strtoupper($row_ad[1]),'iso-8859-1','utf-8'),'LTRB','L',false);
$pdf->Cell(86,5,mb_convert_encoding('AÑO DE TIULACIÓN:','iso-8859-1','utf-8'),1,0,'L');
$pdf->MultiCell(106,5,mb_convert_encoding($row_ad[2],'iso-8859-1','utf-8'),'LTRB','L',false);
$pdf->Cell(86,5,mb_convert_encoding('FORMACIÓN POSGRADO:','iso-8859-1','utf-8'),1,0,'L');

$sqlf =" SELECT idformacion_academica, formacion_academica FROM formacion_academica WHERE idformacion_academica='$row_ac[5]' ";
$resultf = mysqli_query($link,$sqlf);
$rowf = mysqli_fetch_array($resultf);

$pdf->MultiCell(106,5,mb_convert_encoding($rowf[1],'iso-8859-1','utf-8'),'LTRB','L',false);
$pdf->Cell(86,5,mb_convert_encoding('DESCRIPCIÓN DEL POSGRADO:','iso-8859-1','utf-8'),1,0,'L');
$pdf->MultiCell(106,5,mb_convert_encoding($row_ac[6],'iso-8859-1','utf-8'),'LTRB','L',false);
$pdf->Cell(86,5,mb_convert_encoding('ENTIDAD DE FORMACIÓN EN POSGRADO:','iso-8859-1','utf-8'),1,0,'L');
$pdf->MultiCell(106,5,mb_convert_encoding($row_ac[7],'iso-8859-1','utf-8'),'LTRB','L',false);
$pdf->Cell(86,5,mb_convert_encoding('GESTIÓN:','iso-8859-1','utf-8'),1,0,'L');
$pdf->MultiCell(106,5,mb_convert_encoding($row_ac[8],'iso-8859-1','utf-8'),'LTRB','L',false);


$pdf->SetFont('Arial','B',10);
$pdf->Cell(192,8,mb_convert_encoding('III. LUGAR DE TRABAJO','iso-8859-1','utf-8'),0,1,'L');

$pdf->SetFont('Arial','',9);

$sql_dep =" SELECT iddependencia, dependencia FROM dependencia WHERE iddependencia = '$row_l[3]' ";
$result_dep = mysqli_query($link,$sql_dep);
$row_dep = mysqli_fetch_array($result_dep);
//* $pdf->Cell(86,5,mb_convert_encoding('TIPO DE DEPENDENCIA:','iso-8859-1','utf-8'),1,0,'L');  ****//
//* $pdf->Cell(106,5,mb_convert_encoding($row_dep[1],'iso-8859-1','utf-8'),1,1,'L'); *****//

if ($row_l[3] == '1') {
    $pdf->Cell(64,5,mb_convert_encoding('DEPARTAMENTO:','iso-8859-1','utf-8'),1,0,'L');

    $sql_d =" SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento = '$row_l[10]' ";
    $result_d = mysqli_query($link,$sql_d);
    $row_d = mysqli_fetch_array($result_d);
    $pdf->Cell(128,5,mb_convert_encoding($row_d[1],'iso-8859-1','utf-8'),1,1,'L');

    $pdf->Cell(64,5,mb_convert_encoding('ENTIDAD A LA QUE PERTENECE:','iso-8859-1','utf-8'),1,0,'L');
    $entidad_publica = mb_strtoupper($row_l[4]);
    $pdf->MultiCell(128,5,mb_convert_encoding($entidad_publica,'iso-8859-1','utf-8'),'LTRB','L',false);
    $pdf->Cell(64,5,mb_convert_encoding('CARGO QUE OCUPA:','iso-8859-1','utf-8'),1,0,'L');
    $cargo_entidad = mb_strtoupper($row_l[5]);
    $pdf->MultiCell(128,5,mb_convert_encoding($cargo_entidad,'iso-8859-1','utf-8'),'LTRB','L',false);

//  cargo_entidad

} else {
    if ($row_l[3] == '2') {
        $sql_d =" SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento = '$row_l[10]' ";
        $result_d = mysqli_query($link,$sql_d);
        $row_d = mysqli_fetch_array($result_d);
        
        $pdf->Cell(64,5,mb_convert_encoding('DEPARTAMENTO:','iso-8859-1','utf-8'),1,0,'L');
        $pdf->Cell(128,5,mb_convert_encoding($row_d[1],'iso-8859-1','utf-8'),1,1,'L');

        $sql_r =" SELECT idministerio, ministerio FROM ministerio WHERE idministerio = '$row_l[6]' ";
        $result_r = mysqli_query($link,$sql_r);
        $row_r = mysqli_fetch_array($result_r);

        $pdf->Cell(64,5,mb_convert_encoding('INSTANCIA:','iso-8859-1','utf-8'),1,0,'L');
        $pdf->MultiCell(128,5,mb_convert_encoding($row_r[1],'iso-8859-1','utf-8'),'LTRB','L',false);

        $sql_r =" SELECT iddireccion, direccion FROM direccion WHERE iddireccion = '$row_l[7]' ";
        $result_r = mysqli_query($link,$sql_r);
        $row_r = mysqli_fetch_array($result_r);
        $direccion_general = mb_strtoupper($row_r[1]);

        $pdf->Cell(64,5,mb_convert_encoding('DIRECCIÓN GENERAL:','iso-8859-1','utf-8'),1,0,'L');
        $pdf->MultiCell(128,5,mb_convert_encoding($direccion_general,'iso-8859-1','utf-8'),'LTRB','L',false);

        $sql_r =" SELECT idarea, area FROM area WHERE idarea = '$row_l[8]' ";
        $result_r = mysqli_query($link,$sql_r);
        $row_r = mysqli_fetch_array($result_r);
        $unidad_area = mb_strtoupper($row_r[1]);
   
        $pdf->Cell(64,5,mb_convert_encoding('UNIDAD ORGANIZACIONAL:','iso-8859-1','utf-8'),1,0,'L');
        $pdf->MultiCell(128,5,mb_convert_encoding($unidad_area,'iso-8859-1','utf-8'),'LTRB','L',false);
        $cargo_salud = mb_strtoupper($row_l[9]);

        $pdf->Cell(64,5,mb_convert_encoding('CARGO:','iso-8859-1','utf-8'),1,0,'L');
        $pdf->MultiCell(128,5,mb_convert_encoding($cargo_salud,'iso-8859-1','utf-8'),'LTRB','L',false);
        
// variable $cargo_salud

    } else {
        if ($row_l[3] == '3') {

                $sql_d =" SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento = '$row_l[10]' ";
                $result_d = mysqli_query($link,$sql_d);
                $row_d = mysqli_fetch_array($result_d);
            $pdf->Cell(86,5,mb_convert_encoding('DEPARTAMENTO:','iso-8859-1','utf-8'),1,0,'L');
            $pdf->Cell(106,5,mb_convert_encoding($row_d[1],'iso-8859-1','utf-8'),1,1,'L');

                $sql_r =" SELECT idred_salud, red_salud FROM red_salud WHERE idred_salud = '$row_l[11]' ";
                $result_r = mysqli_query($link,$sql_r);
                $row_r = mysqli_fetch_array($result_r);    
            $pdf->Cell(86,5,mb_convert_encoding('RED DE SALUD:','iso-8859-1','utf-8'),1,0,'L');
            $pdf->MultiCell(106,5,mb_convert_encoding($row_r[1],'iso-8859-1','utf-8'),'LTRB','L',false);

                $sql_s =" SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud WHERE idestablecimiento_salud = '$row_l[12]' ";
            $result_s = mysqli_query($link,$sql_s);
            $row_s = mysqli_fetch_array($result_s);
            $pdf->Cell(86,5,mb_convert_encoding('ESTABLECIMIENTO:','iso-8859-1','utf-8'),1,0,'L');
            $pdf->MultiCell(106,5,mb_convert_encoding($row_s[1],'iso-8859-1','utf-8'),'LTRB','L',false);

                $sqlc =" SELECT idcargo_organigrama, cargo_organigrama FROM cargo_organigrama WHERE idcargo_organigrama='$row_l[16]' ";
                $resultc = mysqli_query($link,$sqlc);
                $rowc = mysqli_fetch_array($resultc);  

            $cargo_org = mb_strtoupper($rowc[1]);
            $pdf->Cell(86,5,mb_convert_encoding('CARGO (DE ACUERDO A ORGANIGRAMA):','iso-8859-1','utf-8'),1,0,'L');
            $pdf->MultiCell(106,5,mb_convert_encoding($cargo_org,'iso-8859-1','utf-8'),'LTRB','L',false);

         

            $cargo_red = mb_strtoupper($row_l[13]);
            $pdf->Cell(86,5,mb_convert_encoding('CARGO:','iso-8859-1','utf-8'),1,0,'L');
            $pdf->MultiCell(106,5,mb_convert_encoding($cargo_red,'iso-8859-1','utf-8'),'LTRB','L',false);
            $pdf->Cell(86,5,mb_convert_encoding('NÚMERO DE ÍTEM:','iso-8859-1','utf-8'),1,0,'L');
            $pdf->MultiCell(106,5,mb_convert_encoding($row_l[15],'iso-8859-1','utf-8'),'LTRB','L',false);

        } else {        
        }       
    }   
}
            

$pdf->SetFont('Arial','B',8);
$pdf->Cell(10,8,mb_convert_encoding('Nota:','iso-8859-1','utf-8'),0,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(86,8,mb_convert_encoding('El contenido de la Información registrada en el presente formulario es de entera responsabilidad del usuario del sistema.','iso-8859-1','utf-8'),0,1,'L');

$fecha_r = explode('-',$row_n[22]);
$f_inicio    = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

switch ($fecha_r[1]) {
    case 1:
        $mes_reg = "Enero";
        break;
    case 2:
        $mes_reg = "Febrero";
        break;
    case 3:
        $mes_reg = "Marzo";
        break;
    case 4:
      $mes_reg = "Abril";
      break;
    case 5:
      $mes_reg = "Mayo";
      break;
    case 6:
      $mes_reg = "Junio";
      break;
    case 7:
      $mes_reg = "Julio";
      break;
    case 8:
      $mes_reg = "Agosto";
      break;
    case 9:
      $mes_reg = "Septiembre";
      break;
    case 10:
      $mes_reg = "Octubre";
      break;
    case 11:
      $mes_reg = "Noviembre";
      break;
    case 12:
      $mes_reg = "Diciembre";
      break;
}              

$sqld =" SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$row_l[10]' ";
$resultd = mysqli_query($link,$sqld);
$rowd = mysqli_fetch_array($resultd); 

$lugar = strtolower($rowd[1]);
$lugar_reg = ucwords($lugar);

$pdf->SetFont('Arial','',8);
$pdf->Cell(48,6,mb_convert_encoding('Lugar y Fecha de Registro SAFCI:','iso-8859-1','utf-8'),0,0,'L');
$pdf->Cell(48,6,mb_convert_encoding($lugar_reg.' '.$fecha_r[2].' de '.$mes_reg.' de '.$fecha_r[0],'iso-8859-1','utf-8'),0,0,'L');
$pdf->Cell(96,6,mb_convert_encoding('','iso-8859-1','utf-8'),0,1,'C');

$pdf->Cell(96,6,mb_convert_encoding('','iso-8859-1','utf-8'),0,1,'C');

$pdf->Output();
?>

