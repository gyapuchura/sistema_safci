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

$iddepartamento_ss          = $_SESSION['iddepartamento_ss'];
$idred_salud_ss             = $_SESSION['idred_salud_ss'];
$idmunicipio_ss             = $_SESSION['idmunicipio_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idnotificacion_ep_ss       = $_SESSION['idnotificacion_ep_ss'];
$idsospecha_diag_ss         = $_SESSION['idsospecha_diag_ss'];

$idregistro_enfermedad = $_POST['idregistro_enfermedad'];
$cifra                 = $_POST['cifra'];
$idgrupo_etareo        = $_POST['idgrupo_etareo'];
$idgenero              = $_POST['idgenero'];

$idregistro_enfermedad = $_POST['idregistro_enfermedad'];
$cifra                 = $_POST['cifra'];

$sql0 =" UPDATE registro_enfermedad SET cifra='$cifra[0]', fecha_registro='$fecha', hora_registro='$hora',";
$sql0.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad[0]' ";
$result0 = mysqli_query($link,$sql0);

$sql1 =" UPDATE registro_enfermedad SET cifra='$cifra[1]', fecha_registro='$fecha', hora_registro='$hora',";
$sql1.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad[1]' ";
$result1 = mysqli_query($link,$sql1);

$sql2 =" UPDATE registro_enfermedad SET cifra='$cifra[2]', fecha_registro='$fecha', hora_registro='$hora',";
$sql2.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad[2]' ";
$result2 = mysqli_query($link,$sql2);

$sql3 =" UPDATE registro_enfermedad SET cifra='$cifra[3]', fecha_registro='$fecha', hora_registro='$hora',";
$sql3.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad[3]' ";
$result3 = mysqli_query($link,$sql3);

$sql4 =" UPDATE registro_enfermedad SET cifra='$cifra[4]', fecha_registro='$fecha', hora_registro='$hora',";
$sql4.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad[4]' ";
$result4 = mysqli_query($link,$sql4);

$sql5 =" UPDATE registro_enfermedad SET cifra='$cifra[5]', fecha_registro='$fecha', hora_registro='$hora',";
$sql5.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad[5]' ";
$result5 = mysqli_query($link,$sql5);

$sql6 =" UPDATE registro_enfermedad SET cifra='$cifra[6]', fecha_registro='$fecha', hora_registro='$hora',";
$sql6.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad[6]' ";
$result6 = mysqli_query($link,$sql6);

$sql7 =" UPDATE registro_enfermedad SET cifra='$cifra[7]', fecha_registro='$fecha', hora_registro='$hora',";
$sql7.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad[7]' ";
$result7 = mysqli_query($link,$sql7);

$sql8 =" UPDATE registro_enfermedad SET cifra='$cifra[8]', fecha_registro='$fecha', hora_registro='$hora',";
$sql8.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad[8]' ";
$result8 = mysqli_query($link,$sql8);

$sql9 =" UPDATE registro_enfermedad SET cifra='$cifra[9]', fecha_registro='$fecha', hora_registro='$hora',";
$sql9.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad[9]' ";
$result9 = mysqli_query($link,$sql9);

$sql10 =" UPDATE registro_enfermedad SET cifra='$cifra[10]', fecha_registro='$fecha', hora_registro='$hora',";
$sql10.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad[10]' ";
$result10 = mysqli_query($link,$sql10);

$sql11 =" UPDATE registro_enfermedad SET cifra='$cifra[11]', fecha_registro='$fecha', hora_registro='$hora',";
$sql11.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad[11]' ";
$result11 = mysqli_query($link,$sql11);

$sql12 =" UPDATE registro_enfermedad SET cifra='$cifra[12]', fecha_registro='$fecha', hora_registro='$hora',";
$sql12.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad[12]' ";
$result12 = mysqli_query($link,$sql12);

$sql13 =" UPDATE registro_enfermedad SET cifra='$cifra[13]', fecha_registro='$fecha', hora_registro='$hora',";
$sql13.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad[13]' ";
$result13 = mysqli_query($link,$sql13);

$sql14 =" UPDATE registro_enfermedad SET cifra='$cifra[14]', fecha_registro='$fecha', hora_registro='$hora',";
$sql14.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad[14]' ";
$result14 = mysqli_query($link,$sql14);

$sql15 =" UPDATE registro_enfermedad SET cifra='$cifra[15]', fecha_registro='$fecha', hora_registro='$hora',";
$sql15.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad[15]' ";
$result15 = mysqli_query($link,$sql15);

$sql16 =" UPDATE registro_enfermedad SET cifra='$cifra[16]', fecha_registro='$fecha', hora_registro='$hora',";
$sql16.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad[16]' ";
$result16 = mysqli_query($link,$sql16);

$sql17 =" UPDATE registro_enfermedad SET cifra='$cifra[17]', fecha_registro='$fecha', hora_registro='$hora',";
$sql17.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad[17]' ";
$result17 = mysqli_query($link,$sql17);

$sql18 =" UPDATE registro_enfermedad SET cifra='$cifra[18]', fecha_registro='$fecha', hora_registro='$hora',";
$sql18.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad[18]' ";
$result18 = mysqli_query($link,$sql18);

$sql19 =" UPDATE registro_enfermedad SET cifra='$cifra[19]', fecha_registro='$fecha', hora_registro='$hora',";
$sql19.=" idusuario='$idusuario_ss' WHERE idregistro_enfermedad='$idregistro_enfermedad[19]' ";
$result19 = mysqli_query($link,$sql19);

header("Location:notificacion_ep_etareos.php");



?>
