<?php
//VALIDA SESSION/////////////////////////
session_start();
if($_SESSION['idnombre_ss'] == ""){
	header("Location: index.php");
}
////////////////////////////////////////
?>
