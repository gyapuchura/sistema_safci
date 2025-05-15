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

$idcarpeta_familiar_ss  = $_SESSION['idcarpeta_familiar_ss'];

$idseguimiento_cf_ss    = $_SESSION['idseguimiento_cf_ss'];
$idintegrante_cf_ss     = $_SESSION['idintegrante_cf_ss'];
$idnombre_integrante_ss = $_SESSION['idnombre_integrante_ss'];
$idgenero_ss            = $_SESSION['idgenero_ss'];
$edad_ss                = $_SESSION['edad_ss'];

/*********** ENVIO DATOS DEL PÀCIENTE *************/

$idriesgo_personal_vf = $_POST['idriesgo_personal_vf'];
$idfrecuencia_vf      = $_POST['idfrecuencia_vf'];

$sql_s =" SELECT fecha_inicial FROM seguimiento_cf WHERE idseguimiento_cf='$idseguimiento_cf_ss' ";
$result_s=mysqli_query($link,$sql_s);
$row_s=mysqli_fetch_array($result_s);

$fecha_inicial =$row_s[0];

/********* actualizamos la tabla seguimiento del integrante */

    $sql8 = " UPDATE seguimiento_cf SET idriesgo_personal_vf = '$idriesgo_personal_vf', idfrecuencia_vf = '$idfrecuencia_vf', ";
    $sql8.= " fecha_registro='$fecha', hora_registro='$hora', idusuario='$idusuario_ss' WHERE idseguimiento_cf='$idseguimiento_cf_ss' ";       
    $result8 = mysqli_query($link,$sql8); 

    /****** borramos las visitas anteriores begin *****/

    $sql_d = " DELETE FROM visita_cf WHERE idseguimiento_cf='$idseguimiento_cf_ss' ";
    $resul_d = mysqli_query($link,$sql_d);

    /****** borramos las visitas anteriores end *****/

     /****** insertamos nuevo rol de visitas al integrante *****/
    $meses_r = '12';
    $veces = intdiv($meses_r,$idfrecuencia_vf);

   for ($i = 1; $i <= $veces; $i++) { 
                      
        $meses = $i*$idfrecuencia_vf;

        $fecha = date('Y-m-d');
        $fecha_v = strtotime ( '+'.$meses.' month' , strtotime ($fecha_inicial) ) ;
        $fecha_visita = date ( 'Y-m-d',$fecha_v);

        $numero_visita = 'Visita '.$i;

        $sql_v = " INSERT INTO visita_cf (idseguimiento_cf, fecha_visita, numero_visita, idestado_visita_cf, fecha_registro, hora_registro, idusuario) ";
        $sql_v.= " VALUES ('$idseguimiento_cf_ss','$fecha_visita','$numero_visita','1','$fecha','$hora','$idusuario_ss') ";
        $result_v = mysqli_query($link,$sql_v);  

   }

header("Location:mensaje_opciones_seguimiento_vf.php");

?>