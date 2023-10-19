<?php 

$fecha_nacimiento = "1945-11-18";
$dia_actual = date("Y-m-d");
$edad_diff = date_diff(date_create($fecha_nacimiento), date_create($dia_actual));

echo 'Mi edad es: '.$edad_diff->format('%y');

?>