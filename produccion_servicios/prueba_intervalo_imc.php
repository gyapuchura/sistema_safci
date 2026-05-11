<?php

$imc = '35';

echo $imc.'</br></br>';

if ($imc < '16.5') {
    $clasificacion_imc = 'BAJO PESO SEVERO';
    echo $clasificacion_imc;
} else {
    if ($imc < '18.5' && $imc >= '16.5') {
        $clasificacion_imc = 'BAJO PESO';
        echo $clasificacion_imc;
    } else {
        if ($imc < '25' && $imc >= '18.5') {
            $clasificacion_imc = 'PESO NORMAL';
            echo $clasificacion_imc;
        } else {
            if ($imc < '30' && $imc >= '25') {
                $clasificacion_imc = 'SOBREPESO';
                echo $clasificacion_imc;
            } else {
                if ($imc < '35' && $imc >= '30') {
                    $clasificacion_imc = 'OBESIDAD TIPO 1 (MODERADA)';
                    echo $clasificacion_imc;
                } else {
                    if ($imc < '40' && $imc >= '35') {
                        $clasificacion_imc = 'OBESIDAD TIPO 2 (SEVERA)';
                        echo $clasificacion_imc;
                    } else {
                        if ($imc >='40') {
                             $clasificacion_imc = 'OBESIDAD TIPO 3 (SEVERA)';
                             echo $clasificacion_imc;
                        } else { } } } } } } }

?>