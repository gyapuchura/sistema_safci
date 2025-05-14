<?php 

$meses = '4';

$fecha = date('Y-m-d');
$nuevafecha = strtotime ( '+'.$meses.' month' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
echo $nuevafecha;



?>