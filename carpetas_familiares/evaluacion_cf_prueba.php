<?php include("../cabf.php");?>
<?php

$determinante_salud = 'RIESGO GRAVE';

$salud_integrantes_1 = 'GRUPO I';
$salud_integrantes_2 = '';
$salud_integrantes_3 = '';
$salud_integrantes_4 = '';

$salud_integrantes = $salud_integrantes_1.$salud_integrantes_2.$salud_integrantes_3.$salud_integrantes_4;

$funcionalidad_familiar = 'FUNCIONAL';

/** VALORES INTRODUCIDOS BEGIN */

echo $determinante_salud;
echo "</br>";
echo $salud_integrantes;
echo "</br>";
echo $funcionalidad_familiar;
echo "</br>";
echo "</br>";
echo "RESULTADO DE LA EVALUACION = ";

/** VALORES INTRODUCIDOS BEGIN */
?>
            <?php
                if ($determinante_salud == 'SIN RIESGO' || $determinante_salud == 'RIESGO LEVE') {
                    
                    if ($salud_integrantes == 'GRUPO I') {

                       if ($funcionalidad_familiar == 'FUNCIONAL') {
                        echo "FAMILIA CON RIESGO BAJO";
                        $evaluacion_familiar = 'FAMILIA CON RIESGO BAJO';
                        ?>
                        <input type="hidden" name="evaluacion_familiar" value="FAMILIA CON RIESGO BAJO">
                        <?php

                       } else {

                        echo "FAMILIA CON RIESGO MEDIANO";
                        $evaluacion_familiar = 'FAMILIA CON RIESGO MEDIANO';
                        ?>
                        <input type="hidden" name="evaluacion_familiar" value="FAMILIA CON RIESGO MEDIANO">
                        <?php

                        }
                    } else { 

                        echo "FAMILIA CON RIESGO MEDIANO";
                        $evaluacion_familiar = 'FAMILIA CON RIESGO MEDIANO';
                        ?>
                        <input type="hidden" name="evaluacion_familiar" value="FAMILIA CON RIESGO MEDIANO">
                        <?php
                       }
                    
                } else {

                    if ($determinante_salud == 'RIESGO MODERADO') {

                        echo "FAMILIA CON RIESGO MEDIANO";
                        $evaluacion_familiar = 'FAMILIA CON RIESGO MEDIANO';
                        ?>
                        <input type="hidden" name="evaluacion_familiar" value="FAMILIA CON RIESGO MEDIANO">
                        <?php
                        
                    } else {

                        if ($determinante_salud == 'RIESGO GRAVE' || $determinante_salud == 'RIESGO MUY GRAVE') {   

                            echo "FAMILIA CON RIESGO ALTO";
                            $evaluacion_familiar = 'FAMILIA CON RIESGO ALTO';
                            ?>
                            <input type="hidden" name="evaluacion_familiar" value="FAMILIA CON RIESGO ALTO">
                            <?php
                         }                         
                        } }                
            ?>