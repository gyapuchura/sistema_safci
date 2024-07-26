<?php include("../cabf.php");?>
<?php

$integrantes  = 6;
$habitaciones  = 2 ;

$hacinamiento = $integrantes/$habitaciones;

if ($hacinamiento < 2.4 ) {
    echo "SIN HACINAMIENTO";
} else {
    if ($hacinamiento <= 4.9 ) {
        echo "HACINAMIENTO MEDIO";
    } else {
        if ($hacinamiento >= 5) {
            echo "HACINAMIENTO CRÍTICO";
        } else { } } }
?>
