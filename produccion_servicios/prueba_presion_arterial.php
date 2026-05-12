<?php

$presion_arterial   = '190';
$presion_arterial_d = '88';

echo $presion_arterial.'</br>';
echo $presion_arterial_d.'</br></br>';


if ($presion_arterial < '120' && $presion_arterial_d < '80') {
    $clasificacion_presion_arterial ='ÓPTIMA';
    echo $clasificacion_presion_arterial.'</br>';
} else {
    if (($presion_arterial >= '120' && $presion_arterial <= '129') || ($presion_arterial_d >= '80' && $presion_arterial_d <= '84')) {
        $clasificacion_presion_arterial ='NORMAL';
        echo $clasificacion_presion_arterial.'</br>';
    } else {
        if (($presion_arterial >= '130' && $presion_arterial <= '139') || ($presion_arterial_d >= '85' && $presion_arterial_d <= '89')) {
            $clasificacion_presion_arterial ='NORMAL-ALTA';
            echo $clasificacion_presion_arterial.'</br>';
        } else {
            if (($presion_arterial >= '140' && $presion_arterial <= '159') || ($presion_arterial_d >= '90' && $presion_arterial_d <= '99')) {
                $clasificacion_presion_arterial ='HIPERTENSIÓN DE GRADO 1';
                echo $clasificacion_presion_arterial.'</br>';
            } else {
                if (($presion_arterial >= '160' && $presion_arterial <= '179') || ($presion_arterial_d >= '100' && $presion_arterial_d <= '109')) {
                    $clasificacion_presion_arterial ='HIPERTENSIÓN DE GRADO 2';
                    echo $clasificacion_presion_arterial.'</br>';
                } else {
                    if ($presion_arterial >= '180'  && $presion_arterial_d >= '110') {
                        $clasificacion_presion_arterial ='HIPERTENSIÓN DE GRADO 3';
                        echo $clasificacion_presion_arterial.'</br>';
                    } else {
                        if ($presion_arterial >= '140'  && $presion_arterial_d < '90') {
                            $clasificacion_presion_arterial ='HIPERTENSIÓN SOLO SISTÓLICA';
                            echo $clasificacion_presion_arterial.'</br>';
                        } else { } } } } } } }

?>