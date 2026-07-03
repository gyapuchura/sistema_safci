<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php

$parto = $_POST['parto'];

if ($parto == 'SI') { ?>
            <div class="card shadow mb-4">
            
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">2.2.- PARTO</h6>
                </div>
                <div class="card-body">
                    
                        <div class="form-group row">  
                        <div class="col-sm-2">
                        <h6 class="text-primary">PARTO</br></h6>
                        EUTOCICO <input type="radio" name="idtipo_parto" value="1" checked></br>
                        CESÁREA <input type="radio" name="idtipo_parto" value="2" >               
                        </div>                             
                        <div class="col-sm-2">
                        <h6 class="text-primary">FECHA DEL PARTO</br>[Fecha]:</h6>
                            <input type="date" class="form-control"              
                                name="fecha_parto" id="fecha_parto" required>                
                        </div>
                        <div class="col-sm-2">
                        <h6 class="text-primary">HORA DEL PARTO</br>[hrs]:</h6>
                            <input type="time" class="form-control" 
                                name="hora_parto" required>                
                        </div>
                        <div class="col-sm-2">
                        <h6 class="text-primary">EDAD GESTACIONAL</br>[Semanas]:</h6>
                            <input type="number" class="form-control" 
                                name="edad_gestacional" id="edad_gestacional" required>                 
                        </div>
                        <div class="col-sm-2">
                        <h6 class="text-primary">LÍQUIDO AMNIÓTICO:</br></h6> 
                            <input type="checkbox" name="liq_amniotico" id="liq_amniotico" value="SI">             
                        </div> 
                        <div class="col-sm-2">
                        <h6 class="text-primary">PESO</br>[gramos]</h6>
                            <input type="number" class="form-control"              
                                name="peso_rn" id="peso_rn" required>               
                        </div>
                    </div>
                
                    <div class="form-group row">
                        <div class="col-sm-2">
                        <h6 class="text-primary">TALLA</br>[centímetros]</h6>
                            <input type="number" class="form-control"              
                                name="talla_rn" required>               
                        </div>
                        <div class="col-sm-2">
                        <h6 class="text-primary">P.C.:</br>[perimetro]</h6>
                            <input type="number" class="form-control"              
                                name="pc_rn" required>  
                        </div>
                        <div class="col-sm-2">
                        <h6 class="text-primary">P.T.:</br>[perimetro]</h6>
                            <input type="number" class="form-control"              
                                name="pt_rn"  required>  
                        </div>
                        <div class="col-sm-3">
                        <h6 class="text-primary">APGAR:</br>[Primer Minuto]</h6>
                            <input type="number" class="form-control"              
                                name="apgar_uno" required>  
                        </div>
                        <div class="col-sm-3">
                        <h6 class="text-primary">APGAR:</br>[5 minutos]</h6>
                            <input type="number" class="form-control"              
                                name="apgar_cinco" required>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">INDICE DE CHOQUE:</br>[indice]</h6>
                            <input type="text" class="form-control"              
                                name="indice_choque" id="indice_choque" required>               
                        </div>
                        <div class="col-sm-3">
                        <h6 class="text-primary">CRITERIOS SOFA:</br>[indice]</h6>
                            <input type="number" class="form-control"              
                                name="criterio_sofa" required>  
                        </div>
                        <div class="col-sm-3">
                        <h6 class="text-primary">GÉNERO DEL RECIEN NACIDO</h6>
                            <select name="idgenero_rn" id="idgenero_rn" class="form-control" required>
                            <option value="">-SELECCIONE-</option>
                            <?php
                            $sql1 = "SELECT idgenero, genero FROM genero ";
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
                        <div class="col-sm-3">
                        <h6 class="text-primary">PESO - EDAD GESTACIONAL</h6>
                            <select name="idpeso_eg" id="idpeso_eg" class="form-control" required>
                            <option value="">-SELECCIONE-</option>
                            <?php
                            $sql1 = "SELECT idpeso_eg, peso_eg FROM peso_eg ";
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
                </div>
            </div>

<?php } else { ?>

        <input type="hidden" name="tipo_parto" value="" >
        <input type="hidden" name="fecha_parto" value="0000-00-00" >
        <input type="hidden" name="hora_parto" value="" >
        <input type="hidden" name="edad_gestacional" value="" >
        <input type="hidden" name="liq_amniotico" value="" >
        <input type="hidden" name="peso_rn" value="" >
        <input type="hidden" name="talla_rn" value="" >
        <input type="hidden" name="pc_rn" value="" >
        <input type="hidden" name="pt_rn" value="" >
        <input type="hidden" name="apgar_uno" value="" >
        <input type="hidden" name="apgar_cinco" value="" >
        <input type="hidden" name="indice_choque" value="" >
        <input type="hidden" name="criterios_sofa" value="" >

<?php } ?>

<script>
$(document).ready(function() {
    
    // Tabla de Referencia CLAP (Semanas 24 a 42). Formato: semana: [P10, P90] en gramos.
    const curvasCLAP = {
        24: [480, 840],   25: [560, 980],   26: [650, 1140],  27: [750, 1320],
        28: [870, 1520],  29: [1000, 1740], 30: [1150, 1980], 31: [1310, 2240],
        32: [1490, 2510], 33: [1680, 2800], 34: [1880, 3100], 35: [2090, 3400],
        36: [2300, 3690], 37: [2510, 3970], 38: [2710, 4230], 39: [2890, 4460],
        40: [3050, 4660], 41: [3180, 4820], 42: [3280, 4950]
    };

    // =====================================================================
    // 1. FUNCIÓN CORE: CALCULAR EDAD GESTACIONAL 
    // =====================================================================
    function calcularEdadGestacionalReal() {
        let fumVal = $('input[name="fecha_fum"]').val(); 
        let partoVal = $('input[name="fecha_parto"]').val();
        let inputEg = $('input[name="edad_gestacional"]');
        
        if (fumVal && partoVal) {
            let dFum = new Date(fumVal + 'T00:00:00');
            let dParto = new Date(partoVal + 'T00:00:00');
            
            if (dParto >= dFum) {
                let diffTime = Math.abs(dParto - dFum);
                let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                let semanas = Math.floor(diffDays / 7);
                
                inputEg.val(semanas);
                
                // UX: Efecto visual permanente de campo gris (simula bloqueado)
                inputEg.css({'background-color': '#eaecf4', 'color': '#6e707e', 'transition': 'background-color 0.4s ease'});
                
                evaluarClasificacionPesoCLAP();
            } else {
                // Si la fecha es inconsistente, se limpia y vuelve a blanco
                inputEg.val('').css({'background-color': '', 'color': ''});
            }
        } else {
            // Si faltan datos, se asegura de que el fondo vuelva a ser blanco
            inputEg.css({'background-color': '', 'color': ''});
        }
    }

    // Escuchador dinámico sobre el input de Fecha de Parto
    $(document).off('change', 'input[name="fecha_parto"]').on('change', 'input[name="fecha_parto"]', function() {
        calcularEdadGestacionalReal();
    });

    // ARQUITECTURA DE ESCUCHO GLOBAL: Captura si el médico sube y edita la FUM
    $(document).off('change', 'input[name="fecha_fum"]').on('change', 'input[name="fecha_fum"]', function() {
        calcularEdadGestacionalReal();
    });

    // =====================================================================
    // 2. CLASIFICADOR AUTOMÁTICO DE PESO CON SEMÁFORO DE ALERTAS
    // =====================================================================
    function evaluarClasificacionPesoCLAP() {
        let peso = parseFloat($('input[name="peso_rn"]').val());
        let semanas = parseInt($('input[name="edad_gestacional"]').val(), 10);
        let selectCondicion = $('select[name="idpeso_eg"]'); 
        
        if (peso > 0 && semanas > 0) {
            let palabraBuscada = ""; 
            let colorFondo = "";
            
            let semanaCurva = semanas;
            if (semanas < 24) semanaCurva = 24; 
            if (semanas > 42) semanaCurva = 42;

            let P10 = curvasCLAP[semanaCurva][0];
            let P90 = curvasCLAP[semanaCurva][1];

            // Evaluación estricta percentilar con inyección de estilos de Semáforo
            if (peso < P10) {
                palabraBuscada = "PEQUE"; 
                colorFondo = "#e74a3b"; // Rojo Crítico
            } else if (peso > P90) {
                palabraBuscada = "GRANDE"; 
                colorFondo = "#f6c23e"; // Naranja Alerta
            } else {
                palabraBuscada = "ADECUADO"; 
                colorFondo = "#1cc88a"; // Verde Óptimo
            }
            
            let idRealBD = "";
            selectCondicion.find('option').each(function() {
                let texto = $(this).text().toUpperCase();
                if (texto.includes(palabraBuscada)) {
                    idRealBD = $(this).val();
                    return false; 
                }
            });
            
            if (idRealBD !== "") {
                selectCondicion.val(idRealBD);
                
                selectCondicion.css({
                    'background-color': colorFondo,
                    'color': 'white',
                    'font-weight': 'bold',
                    'transition': 'all 0.4s ease'
                });
                
                selectCondicion.data('ultimo_valor', idRealBD);
            }
        } else {
            selectCondicion.css({'background-color': '', 'color': '', 'font-weight': ''});
        }
    }

    $(document).off('input', 'input[name="peso_rn"], input[name="edad_gestacional"]').on('input', 'input[name="peso_rn"], input[name="edad_gestacional"]', function() {
        evaluarClasificacionPesoCLAP();
    });

    $(document).off('change', 'select[name="idpeso_eg"]').on('change', 'select[name="idpeso_eg"]', function() {
        let textoSeleccionado = $(this).find('option:selected').text().toUpperCase();
        if (textoSeleccionado.includes("PEQUE")) {
            $(this).css({'background-color': '#e74a3b', 'color': 'white', 'font-weight': 'bold'});
        } else if (textoSeleccionado.includes("GRANDE")) {
            $(this).css({'background-color': '#f6c23e', 'color': 'white', 'font-weight': 'bold'});
        } else if (textoSeleccionado.includes("ADECUADO")) {
            $(this).css({'background-color': '#1cc88a', 'color': 'white', 'font-weight': 'bold'});
        } else {
            $(this).css({'background-color': '', 'color': '', 'font-weight': ''});
        }
    });

    // =====================================================================
    // 3. ÍNDICE DE CHOQUE AUTOMÁTICO
    // =====================================================================
    function calcularIndiceChoque() {
        let fc_input = $('input[name="frec_cardiaca"]').val(); 
        let pa_input = $('input[name="presion_arterial"]').val(); 
        let inputChoque = $('input[name="indice_choque"]');
        
        if (inputChoque.length === 0) return; 

        if (fc_input === undefined || pa_input === undefined || fc_input === "" || pa_input === "") {
            inputChoque.val('Faltan Signos'); 
            inputChoque.css({'background-color': '#f8d7da', 'color': '#721c24'});
            return; 
        }

        let fc = parseFloat(fc_input);
        let pas = 0;
        
        if(pa_input) {
            if(pa_input.includes('/')) {
                pas = parseFloat(pa_input.split('/')[0]); 
            } else {
                pas = parseFloat(pa_input);
            }
        }
        
        if (fc > 0 && pas > 0) {
            let choque = (fc / pas).toFixed(2);
            inputChoque.val(choque);
            
            if (choque <= 0.7) {
                inputChoque.css({'background-color': '#1cc88a', 'color': 'white', 'font-weight': 'bold'});
            } else if (choque > 0.7 && choque <= 0.9) {
                inputChoque.css({'background-color': '#f6c23e', 'color': '#fff', 'font-weight': 'bold'});
            } else if (choque > 0.9) {
                inputChoque.css({'background-color': '#e74a3b', 'color': 'white', 'font-weight': 'bold'});
            }
        }
    }

    $(document).off('input', 'input[name="frec_cardiaca"], input[name="presion_arterial"]').on('input', 'input[name="frec_cardiaca"], input[name="presion_arterial"]', function() {
        calcularIndiceChoque();
    });

    $(document).off('click focus mouseenter', 'input[name="indice_choque"]').on('click focus mouseenter', 'input[name="indice_choque"]', function() {
        calcularIndiceChoque();
    });
    
    // Inicializadores de renderizado seguro
    setTimeout(calcularIndiceChoque, 300);
    setTimeout(calcularEdadGestacionalReal, 300);
});
</script>