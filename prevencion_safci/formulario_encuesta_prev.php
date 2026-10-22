<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha 		= date("Y-m-d");
$idtema_encuesta = $_POST['tema_encuesta'];
$edad_ss = $_SESSION['edad_ss'];

switch ($idtema_encuesta) {
    case 1: ?>

<form name="ENCUESTA_1"  action="guarda_encuesta_cancer.php" method="post" >
    <input type="hidden" name="idtema_encuesta" value="<?php echo $idtema_encuesta;?>">
    
    <div class="form-group row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6 text-center">
            <h4 class="text-info">FORMULARIO DE REGISTRO DE DETECCIÓN DEL CÁNCER EN LA NIÑEZ Y ADOLESCENCIA</h4>
        </div>
        <div class="col-sm-3"></div>
    </div>
    <hr>
    
    <div class="form-group row">
        <div class="col-sm-4">
            <h6 class="text-info">INCIDENCIA DE LA ENCUESTA:</h6>
            <?php
            $sql_i =" SELECT idrepeticion, repeticion FROM repeticion ";
            $result_i = mysqli_query($link,$sql_i);
            if ($row_i = mysqli_fetch_array($result_i)){
                mysqli_field_seek($result_i,0);
                while ($field_i = mysqli_fetch_field($result_i)){ }
                do { 
            ?>
            <?php echo " - ".$row_i[1]." -> ";?> <input type="radio" name="idrepeticion" value="<?php echo $row_i[0];?>" <?php if ($row_i[0] == '1') { echo "checked";} else { } ?> > <br>
            <?php 
                } while ($row_i = mysqli_fetch_array($result_i));
            } else { } 
            ?>
        </div>
        <div class="col-sm-4">
            <h6 class="text-info">LUGAR DE LA ENCUESTA:</h6>
            <?php
            $sql_c =" SELECT idtipo_consulta, tipo_consulta FROM tipo_consulta ";
            $result_c = mysqli_query($link,$sql_c);
            if ($row_c = mysqli_fetch_array($result_c)){
                mysqli_field_seek($result_c,0);
                while ($field_c = mysqli_fetch_field($result_c)){ }
                do { 
            ?>
            <?php echo " - ".$row_c[1]." -> ";?> <input type="radio" name="idtipo_consulta" value="<?php echo $row_c[0];?>" <?php if ($row_c[0] == '1') { echo "checked";} else { } ?> > <br>
            <?php 
                } while ($row_c = mysqli_fetch_array($result_c));
            } else { } 
            ?>
        </div>
        <div class="col-sm-4">
            <h6 class="text-info">FECHA DE LA ENCUESTA:</h6>
            <input type="date" name="fecha_registro" value="<?php echo $fecha;?>" class="form-control" required>
            <div class="invalid-feedback">Requerido.</div>
        </div>
    </div>
    <br>
    <hr>
    
    <div class="form-group row">
        <div class="col-sm-12">
            <h6 class="text-info">EXAMEN FÍSICO - SIGNOS VITALES:</h6>
        </div>
    </div>
    <hr>
    
    <div class="form-group row">
        <div class="col-sm-3">
            <h6 class="text-info">TALLA </br>[Centímetros]:</h6>
            <input type="number" min="20" max="280" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 280) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 20) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En Centímetros" name="talla" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 20 a 280 cm</div>
        </div>
        <div class="col-sm-3">
            <h6 class="text-info">PESO </br>[kg]:</h6>
            <input type="number" step="any" min="0.2" max="650" onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();" oninput="if(this.value > 650) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0.2) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En kilogramos" name="peso" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0.2 a 650 kg</div>
        </div>
        <div class="col-sm-3">
            <h6 class="text-info">TEMPERATURA</br>[EN GRADOS CENTIGRADOS]:</h6>
            <input type="number" step="any" min="10" max="47" onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();" oninput="if(this.value > 47) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 10) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" name="temperatura" placeholder="En GRADOS CENTÍGRADOS" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 10°C a 47°C</div>
        </div>
        <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA CARDIACA </br>[LATIDOS POR MINUTO]:</h6>
            <input type="number" min="0" max="350" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 350) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="LATIDOS POR MINUTO" name="frec_cardiaca" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 350 lpm</div>
        </div>
    </div>
    
    <?php if ($edad_ss > '5') { ?>
    <div class="form-group row">
        <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[CICLOS POR MINUTO]:</h6>
            <input type="number" min="0" max="80" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 80) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="CICLOS POR MINUTO" name="frec_respiratoria" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 80 cpm</div>
        </div>
        <div class="col-sm-3">
            <h6 class="text-info">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>
            <input type="number" min="0" max="300" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 300) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" name="presion_arterial" placeholder="Sistólica" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 300</div>
        </div>
        <div class="col-sm-3">
            <h6 class="text-info"> </br>diastólica [mmHg]</h6>
            <input type="number" min="0" max="200" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 200) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" name="presion_arterial_d" placeholder="Diastólica" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 200</div>
        </div>
        <div class="col-sm-3">
            <h6 class="text-info">PERÍMETRO CEFÁLICO</br>[PC]:</h6>
            <input type="number" min="20" max="280" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 100) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 20) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En Centímetros" name="perimetro_cefalico" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 20 a 100 cm</div>
        </div>
    </div>
    
    <?php } else { ?>
    <div class="form-group row">
        <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6>
            <input type="number" min="0" max="80" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 80) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="Cpm" name="frec_respiratoria" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 80 cpm</div>
        </div>
        <div class="col-sm-3">
            <h6 class="text-info">PERÍMETRO CEFÁLICO</br>[PC]:</h6>
            <input type="number" min="20" max="280" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 100) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 20) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En Centímetros" name="perimetro_cefalico" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 20 a 100 cm</div>
        </div>
        <div class="col-sm-3">
            <input type="hidden" class="form-control" name="presion_arterial" value="0">
        </div>
        <div class="col-sm-3">
            <input type="hidden" class="form-control" name="presion_arterial_d" value="0">
        </div>
    </div>
    

    <?php } ?>
    
    <hr>
    
    <div class="form-group row">
        <div class="col-sm-12">
            <h6 class="text-info">PREGUNTAR (Marque y describa lo objetivo):</h6>
        </div>
    </div>

    <hr>

    <?php
        $numero=0;
        $sql5 =" SELECT idpregunta_encuesta, pregunta_encuesta, pregunta_complementaria FROM pregunta_encuesta ORDER BY idpregunta_encuesta ";
        $result5 = mysqli_query($link,$sql5);
        if ($row5 = mysqli_fetch_array($result5)){
        mysqli_field_seek($result5,0);
        while ($field5 = mysqli_fetch_field($result5)){
        } do { 
    ?>
        <div class="form-group row">
            <div class="col-sm-2">
                <h6 class="text-info">Pregunta <?php echo $numero+1;?></h6>
                <input type="hidden" name="idpregunta_encuesta[]" value="<?php echo $row5[0];?>">
            </div>
            <div class="col-sm-8">
                <h6 class="text-secundary"><?php echo $row5[1];?></h6>
            </div>
            <div class="col-sm-2">
                <h6 class="text-info">SI <input type="radio" name="respuesta[<?php echo $numero;?>]" value="SI" > 
                                      NO <input type="radio" name="respuesta[<?php echo $numero;?>]" value="NO" checked ></h6>
            </div>        
        </div>

        <?php

        if ($row5[2] == '') { ?>

            <input type="hidden" class="form-control" name="retroalimentacion[<?php echo $numero;?>]" value="">
  
        <?php } else { ?>
            
        <div class="form-group row">
            <div class="col-sm-2">
            </div>
            <div class="col-sm-3">
                <h6 class="text-secundary"><?php echo $row5[2];?></h6>
            </div>
            <div class="col-sm-5">
                <textarea class="form-control" rows="2" name="retroalimentacion[<?php echo $numero;?>]" placeholder="Describa aqui ..."></textarea>
            </div>
            <div class="col-sm-2">
            </div>
        </div>
      
        <?php }
        $numero = $numero+1;
        }
        while ($row5 = mysqli_fetch_array($result5));
        } else {
        } ?>
<hr>
        <div class="form-group row">
            <div class="col-sm-12">
                <h6 class="text-info">OBSERVAR Y DETERMINAR</h6>
                <h6 class="text-info">Marque o subraye lo objetivo</h6>
            </div>      
        </div>

        <div class="form-group row">
            <div class="col-sm-2">
                <h6 class="text-info"></h6>
            </div>
            <div class="col-sm-10">

    <?php
        $numero6=0;
        $sql6 =" SELECT idseccion_encuesta, seccion_encuesta FROM seccion_encuesta ORDER BY idseccion_encuesta ";
        $result6 = mysqli_query($link,$sql6);
        if ($row6 = mysqli_fetch_array($result6)){
        mysqli_field_seek($result6,0);
        while ($field6 = mysqli_fetch_field($result6)){
        } do { 
    ?>

                <h6 class="text-info"><?php echo $row6[1];?></h6>

            <?php
                $numero7=0;
                $sql7 =" SELECT iditem_senal_cancer, item_senal_cancer FROM item_senal_cancer WHERE idseccion_encuesta = '$row6[0]' ORDER BY iditem_senal_cancer ";
                $result7 = mysqli_query($link,$sql7);
                if ($row7 = mysqli_fetch_array($result7)){
                mysqli_field_seek($result7,0);
                while ($field7 = mysqli_fetch_field($result7)){
                } do { 
            ?>

                <h6 class="text-secundary"> - <?php echo $row7[1];?> -> <input type="checkbox" name="iditem_senal_cancer[]" value="<?php echo $row7[0];?>" ></h6>

            <?php 
                $numero7 = $numero7+1;
                }
                while ($row7 = mysqli_fetch_array($result7));
                } else {
                } 
            ?>

    <?php 
        $numero6 = $numero6+1;
        }
        while ($row6 = mysqli_fetch_array($result6));
        } else {
        } 
    ?>
    
            </div>      
        </div>
        <hr>

        <div class="form-group row">
            <div class="col-sm-12">
                <h6 class="text-info">CRITERIOS PARA LA CLASIFICACIÓN</h6>
            </div>
        </div> 
        <div class="form-group row">
            <div class="col-sm-4">
                <h6 class="text-danger">1. POSIBLE CÁNCER </h6>
                <h6 class="text-danger">Basta con presentar UNO de los signos graves: Fiebre >7 días y/o sudoración importante, cefalea que despierta al niño, dolor óseo progresivo, petequias/sangrados, palidez severa, alteraciones oculares (leucocoria, estrabismo, etc.), ganglios duros >2cm, masa SIN signos de inflamación o hepatomegalia/esplenomegalia.</h6>
            </div>
            <div class="col-sm-4">
                <h6 class="text-warning">2. ALGÚN RIESGO</h6>
                <h6 class="text-warning">Ausencia de signos rojos, pero con UNO de estos signos: Pérdida de peso/apetito/fatiga en últimos 3 meses, palidez leve, masa CON signos de inflamación, o linfoadenopatía menor a 2.5cm / dolorosa.</h6>
            </div>
            <div class="col-sm-4">
                <h6 class="text-success">3. NO TIENE CÁNCER</h6>
                <h6 class="text-success">No cumple criterios para clasificarse en ninguna de las anteriores. Asegure inmunizaciones y control de crecimiento y desarrollo.</h6>
            </div>
        </div> 

        <hr>
        <div class="form-group row">
            <div class="col-sm-2">
                <h6 class="text-info">CLASIFICACIÓN</h6>
            </div>  
            <div class="col-sm-10">
                <select name="idclasificacion_riesgo_cancer"  id="idclasificacion_riesgo_cancer" class="form-control" required>
                    <option value="">-SELECCIONE-</option>
                    <?php
                    $sql1 = "SELECT idclasificacion_riesgo_cancer, clasificacion_riesgo_cancer FROM clasificacion_riesgo_cancer ORDER BY idclasificacion_riesgo_cancer DESC ";
                    $result1 = mysqli_query($link,$sql1);
                    if ($row1 = mysqli_fetch_array($result1)){
                    mysqli_field_seek($result1,0);
                    while ($field1 = mysqli_fetch_field($result1)){
                    } do {
                    echo "<option value=".$row1[0].">".$row1[1]."</option>";
                    } while ($row1 = mysqli_fetch_array($result1));
                    } else {
                    echo "No se encontraron resultados!";
                    }
                    ?>
                </select>
            </div>    
        </div>


                <hr>
                   <div class="text-center">   
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                            REGISTRAR ENCUESTA
                            </button>  
                        </div>                              
                    </div>                            
                </div>
                   <!-- modal de confirmacion de envio de datos-->
                   <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">REGISTRAR ENCUESTA</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    
                                    Esta seguro de Registrar?
                                    posteriormenete no se podran realizar cambios.

                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                <button type="submit" class="btn btn-info pull-center">CONFIRMAR REGISTRO</button>    
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                    <!-- Modal -->
<!-- INICIO DE SCRIPT DE AUTOMATIZACIÓN Y SEMAFORIZACIÓN -->
<script>
(function() {
    const selectClasificacion = document.getElementById('idclasificacion_riesgo_cancer');
    
    if (!selectClasificacion) {
        console.error("No se encontró el select de clasificación.");
        return;
    }

    const formulario = document.forms['ENCUESTA_1'] || document.body;
    let clasificacionManual = false;

    // Aviso bajo el select cuando la elección manual no coincide con la guía
    const avisoGuia = document.createElement('small');
    avisoGuia.style.cssText = 'display:block; margin-top:5px; color:#b91817; font-weight:bold;';
    selectClasificacion.insertAdjacentElement('afterend', avisoGuia);

    // Clasificación según CUADRO N° 2 de la "Guía de Diagnóstico Oportuno del Cáncer
    // en la Niñez y la Adolescencia" (MSyD, Publicación 544, 2024)
    // Ítems (iditem_senal_cancer) que por sí solos son POSIBLE CÁNCER
    const ITEMS_POSIBLE_CANCER = ["1", "2", "24",              // Moretes, sangrado, petequias
                                  "4",                         // Palidez intensa
                                  "5", "6", "7", "8", "9", "10", // Anormalidad en los ojos
                                  "13", "14", "15", "16", "17", "18", "19", // Signos neurológicos focales / visión
                                  "20",                        // Masa palpable abdominal
                                  "21", "22",                  // Hepatomegalia / esplenomegalia
                                  "23"];                       // Masa en alguna región del cuerpo

    function autoClassificar() {
        // 1. Preguntas respondidas SI, identificadas por su idpregunta_encuesta
        const si = {};
        formulario.querySelectorAll('input[name="idpregunta_encuesta[]"]').forEach((input, i) => {
            const radioSI = formulario.querySelector('input[type="radio"][name="respuesta[' + i + ']"][value="SI"]');
            si[input.value] = !!(radioSI && radioSI.checked);
        });

        // 2. Signos marcados en OBSERVAR Y DETERMINAR
        const item = {};
        formulario.querySelectorAll('input[type="checkbox"][name="iditem_senal_cancer[]"]:checked').forEach(chk => {
            item[chk.value] = true;
        });
        const ganglioMayor = !!item["11"]; // Tamaño mayor a 2,5 cm sin dolor ni inflamación
        const ganglioDuro  = !!item["12"]; // Consistencia dura y firme mayor a 4 semanas

        // POSIBLE CÁNCER
        const riesgoAlto =
            si["1"] ||                               // Fiebre > 7 días y/o sudoración importante
            (si["2"] && (si["3"] || si["4"])) ||     // Cefalea progresiva que despierta al niño y/o con vómitos
            (si["5"] && si["6"] && si["7"]) ||       // Dolor óseo en el último mes, progresivo, que interrumpe su actividad
            si["10"] ||                              // Cambios en la marcha / detención del desarrollo psicomotor
            ITEMS_POSIBLE_CANCER.some(id => item[id]) ||
            (ganglioMayor && ganglioDuro);           // Ganglio > 2,5 cm, no doloroso, duro, >= 4 semanas

        // ALGÚN RIESGO DE CÁNCER
        const riesgoMedio =
            si["8"] ||                               // Pérdida de apetito, peso o fatiga en los últimos 3 meses
            !!item["3"] ||                           // Palidez leve
            (ganglioMayor !== ganglioDuro);          // Linfoadenopatía que no cumple todos los criterios de posible cáncer

        // (Riesgo alto siempre domina si hay una mezcla de síntomas)
        // 1 = POSIBLE CÁNCER, 2 = ALGÚN RIESGO, 3 = NO TIENE CÁNCER
        const sugerida = riesgoAlto ? "1" : (riesgoMedio ? "2" : "3");

        // 3. Autoselección: si el médico eligió la clasificación a mano se respeta y solo se avisa
        if (clasificacionManual && selectClasificacion.value !== "") {
            avisoGuia.textContent = (selectClasificacion.value !== sugerida)
                ? "Según la guía corresponde: " + selectClasificacion.querySelector('option[value="' + sugerida + '"]').textContent + " (clasificación cambiada manualmente)"
                : "";
        } else {
            clasificacionManual = false;
            selectClasificacion.value = sugerida;
            avisoGuia.textContent = "";
        }
        pintarSemaforo();
    }

    function pintarSemaforo() {
        const v = selectClasificacion.value;
        if (v === "1") {
            selectClasificacion.style.backgroundColor = "#fdf0f0"; selectClasificacion.style.color = "#b91817"; selectClasificacion.style.fontWeight = "bold";
        } else if (v === "2") {
            selectClasificacion.style.backgroundColor = "#fff8e1"; selectClasificacion.style.color = "#b59545"; selectClasificacion.style.fontWeight = "bold";
        } else if (v === "3") {
            selectClasificacion.style.backgroundColor = "#e8f5e9"; selectClasificacion.style.color = "#28a745"; selectClasificacion.style.fontWeight = "bold";
        } else {
            selectClasificacion.style.backgroundColor = "#fff"; selectClasificacion.style.color = "#495057"; selectClasificacion.style.fontWeight = "normal";
        }
    }

    // 4. Delegación de eventos anclada al formulario actual
    formulario.addEventListener('change', function(e) {
        if (e.target.type === 'radio' || e.target.type === 'checkbox') {
            autoClassificar();
        }
    });

    // 5. Si el médico cambia el select manualmente, su elección ya no se sobrescribe.
    //    Volver a "-SELECCIONE-" reactiva la clasificación automática.
    selectClasificacion.addEventListener('change', function() {
        clasificacionManual = (this.value !== "");
        autoClassificar();
    });

    // Forzar la evaluación inicial al abrir el panel
    setTimeout(autoClassificar, 300);

})();
</script>
<!-- FIN DE SCRIPT DE AUTOMATIZACIÓN -->


  <?php
    break;
    case 2:

    break;
    case 3:

    break; 
    case 4:

    break;
    case 5:

    break; 
    }     
    ?>


