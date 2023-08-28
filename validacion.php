<?php include("inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

//	SE INICIA LA SESION Y SE CREAN VARIABLES DE SESION PARA EL USUARIO QUE INGRESA AL SISTEMA
session_start();

$ip		 	= $_SERVER['REMOTE_ADDR'];
$fecha 		= date("Y-m-d H:i:s");

$usuario 	= $_POST['usuario'];
$password 	= $_POST['password'];

if($usuario == "" or $password == ""){

header("Location:login.php");

}else{
  	$sql = "  SELECT idusuario, idnombre, usuario, password, fecha, condicion, perfil, idarea ";
	$sql.= "  FROM usuarios WHERE usuarios.usuario = '$usuario'  ";
	$sql.= "  AND usuarios.password = '$password' AND usuarios.condicion = 'ACTIVO' ";
	$result = mysqli_query($link,$sql);
	if ($row = mysqli_fetch_array($result)){
	mysqli_field_seek($result,0);
	while ($field = mysqli_fetch_field($result)){
	} do {

		$_SESSION['idusuario_ss']		= $row[0];
		$_SESSION['idnombre_ss'] 		= $row[1];
		$_SESSION['usuario_ss'] 		= $row[2];
		$_SESSION['password_ss'] 		= $row[3];
		$_SESSION['fecha_ss'] 	    	= $row[4];
		$_SESSION['condicion_ss'] 	    = $row[5];
		$_SESSION['perfil_ss'] 	        = $row[6];
		$_SESSION['idarea_ss'] 	        = $row[7];

		$idusuario	= $row[0];
		$user       = $row[2];
		$perfil     = $row[6];

		//	SI EL USUARIO ES CORRECTO, SE REGISTRA EN UN HISTORIAL DE INGRESOS AL SISTEMA

		$sql_i = "INSERT INTO log_login (usuario, fecha, fecha_hora, ip, condicion)";
		$sql_i.= " VALUES ('$user', '$fecha', '$fecha', '$ip', 'OPEN')";
		$result_i = mysqli_query($link,$sql_i);

		//	SE REDIRECCIONA A LA PAGINA DE INICIO DEL SISTEMA

		 header("Location:inicio.php");


	} while ($row = mysqli_fetch_array($result));
	} else {

		//	SI EL USUARIO ES INCORRECTO, SE REGISTRA EN UN HISTORIAL DE INGRESOS FALLIDOS AL SISTEMA

		$sql_i = "INSERT INTO log_login_failure (usuario, password, fecha, fecha_hora, ip)";
		$sql_i.= " VALUES ('$usuario', '$password',  '$fecha', '$fecha', '$ip')";
		$result_i = mysqli_query($link,$sql_i);

		//	SE REDIRECCION AL LOGIN DEL SISTEMA
		header("Location:login.php");
	}

}
?>
