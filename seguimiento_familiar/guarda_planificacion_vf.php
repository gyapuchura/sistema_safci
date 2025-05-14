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

$idcarpeta_familiar_ss = $_SESSION['idcarpeta_familiar_ss'];

/*********** ENVIO DATOS DEL PÀCIENTE *************/

$idintegrante_cf      = $_POST['idintegrante_cf'];
$fecha_nac            = $_POST['fecha_nac'];
$idriesgo_personal_vf = $_POST['idriesgo_personal_vf'];
$idfrecuencia_vf      = $_POST['idfrecuencia_vf'];

$sql3 =" SELECT idseguimiento_cf FROM seguimiento_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss'  ";
$result3 = mysqli_query($link,$sql3);
if ($row3 = mysqli_fetch_array($result3)){

       header("Location:mensaje_seguimiento_cf_existe.php");

    } else {

foreach($idintegrante_cf as $clave => $integrante_cf_id) {

    $fecha_r = explode('-',$fecha_nac[$clave]);
   
    $fecha_inicial = $gestion.'-'.$fecha_r[1].'-'.$fecha_r[2];

    $sql0 = " INSERT INTO seguimiento_cf (idcarpeta_familiar, idintegrante_cf, idriesgo_personal_vf, idfrecuencia_vf, fecha_inicial, fecha_registro, hora_registro, idusuario) ";
    $sql0.= " VALUES ('$idcarpeta_familiar_ss','$integrante_cf_id','$idriesgo_personal_vf[$clave]','$idfrecuencia_vf[$clave]','$fecha_inicial','$fecha','$hora','$idusuario_ss') ";
    $result0 = mysqli_query($link,$sql0);   
    $idseguimiento_cf = mysqli_insert_id($link);

    $meses_r = '12';
    $veces = intdiv($meses_r,$idfrecuencia_vf[$clave]);

   for ($i = 1; $i <= $veces; $i++) { 
                      
        $meses = $i*$idfrecuencia_vf[$clave];

        $fecha = date('Y-m-d');
        $fecha_v = strtotime ( '+'.$meses.' month' , strtotime ($fecha_inicial) ) ;
        $fecha_visita = date ( 'Y-m-d',$fecha_v);

        $numero_visita = 'Visita '.$i;

        $sql_v = " INSERT INTO visita_cf (idseguimiento_cf, fecha_visita, numero_visita, idestado_visita_cf, fecha_registro, hora_registro, idusuario) ";
        $sql_v.= " VALUES ('$idseguimiento_cf','$fecha_visita','$numero_visita','1','$fecha','$hora','$idusuario_ss') ";
        $result_v = mysqli_query($link,$sql_v);  

 }  

}

header("Location:mostrar_seguimiento_cf.php");

    }

?>