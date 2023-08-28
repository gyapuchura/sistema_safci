<?php
/**
* Realiza la funcion de validacion de sesion de usuario
* @idnombre_ss es una variable de sesion para identificar el nombre personal del usuario que ha ingresado al sistema
* @idusuario_ss es una variable de sesion del usuario que ha ingresado al sistema
* @perfil_ss es una variable de sesion referente al perfil del usuario que ingresa al sistema
*/
//VALIDA SESSION/////////////////////////
session_start();
if($_SESSION['idusuario_ss'] == "" || $_SESSION['idnombre_ss'] == "" || $_SESSION['perfil_ss'] == ""){
	header("Location:../index.php");
}
/////////////////////////////////////////

?>