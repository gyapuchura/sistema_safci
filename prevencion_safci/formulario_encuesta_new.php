<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php
$fecha 		= date("Y-m-d");
$idtema_encuesta = $_POST['tema_encuesta'];

  
    switch ($idtema_encuesta) {
    case 1: ?>
<!--------------------------------------------->    
<!--------  ENCUESTA DETECCION DEL CANCER EN LA NIÑEZ Y ADOLESCENCIA - BEGIN ----------->
<!---------------------------------------------> 

<style>
    .tooltip-senior { position: relative; display: inline-block; cursor: help; }
    .tooltip-senior .tooltip-box {
        visibility: hidden; width: 280px; background-color: #2a3b4c; color: #ffffff;
        text-align: center; border-radius: 6px; padding: 10px 12px; position: absolute;
        z-index: 9999; bottom: 130%; left: 50%; transform: translateX(-50%);
        opacity: 0; transition: opacity 0.3s ease-in-out; font-size: 0.85rem;
        font-weight: 500; font-family: inherit; box-shadow: 0px 5px 15px rgba(0,0,0,0.3);
        line-height: 1.4; letter-spacing: 0.3px;
    }
    .tooltip-senior .tooltip-box::after {
        content: ""; position: absolute; top: 100%; left: 50%; margin-left: -6px;
        border-width: 6px; border-style: solid; border-color: #2a3b4c transparent transparent transparent;
    }
    .tooltip-senior:hover .tooltip-box { visibility: visible; opacity: 1; }
</style>
 
<form name="ATENCIONSANO" id="form-preventiva-ncf"  action="guarda_encuesta_cancer_new.php" method="post" class="needs-validation" novalidate>

    <input type="hidden" name="idtema_encuesta" value="<?php echo $idtema_encuesta;?>">   

    <div class="form-group row"> 
        <div class="col-sm-3"> </div> 
        <div class="col-sm-6 text-center">
            <h4 class="text-info">ENCUESTA MÉDICA</h4>
        </div> 
        <div class="col-sm-3"> </div> 
    </div> 
    <hr>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">1.- INFORMACIÓN PERSONAL</h6>
        </div>
        <div class="card-body">

            <div class="form-group row">    
                <div class="col-sm-4">
                <h6 class="text-info">NOMBRES:</h6>
                    <input type="text" class="form-control" name="nombre" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');" required >                
                    <div class="invalid-feedback">Requerido.</div>
                </div>                           
                <div class="col-sm-4">
                <h6 class="text-info">PRIMER APELLIDO:</h6>
                    <input type="text" class="form-control" name="paterno" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');" autofocus required>                
                    <div class="invalid-feedback">Requerido.</div>
                </div>
                <div class="col-sm-4">
                <h6 class="text-info">SEGUNDO APELLIDO:</h6>
                    <input type="text" class="form-control" name="materno" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');" required>                
                    <div class="invalid-feedback">Requerido.</div>
                </div>
            </div>

            <div class="form-group row">  
                <div class="col-sm-4">
                <h6 class="text-info">CÉDULA DE IDENTIDAD:</h6><h6 class="text-warning" style="font-size:0.85rem; margin-top:-5px;"> SI NO CUENTA ASIGNAR=0</h6>
                    <input type="number" class="form-control" name="ci" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" required >
                    <div class="invalid-feedback">Requerido.</div>
                </div>
                <div class="col-sm-4"><br>
                <h6 class="text-info">COMPLEMENTO:</h6>
                    <input type="text" class="form-control" name="complemento" >                
                </div>
                <div class="col-sm-4"><br>
                <h6 class="text-info">GÉNERO:</h6>
                    <select name="idgenero" id="idgenero" class="form-control" required>
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
                    } else { }
                    ?>
                    </select>
                    <div class="invalid-feedback">Requerido.</div>
                </div>      
            </div>   

            <div class="form-group row">  
                <div class="col-sm-4">
                    <h6 class="text-info">FECHA DE NACIMIENTO:</h6>
                        <input type="date"  class="form-control" name="fecha_nac" required>
                        <div class="invalid-feedback">Requerido.</div>
                </div> 
                <div class="col-sm-4">
                <h6 class="text-info">NACIONALIDAD:</h6>
                    <select name="idnacionalidad" id="idnacionalidad" class="form-control" required>
                    <option value="">-SELECCIONE-</option>
                    <?php
                    $sql1 = "SELECT idnacionalidad, nacionalidad FROM nacionalidad ";
                    $result1 = mysqli_query($link,$sql1);
                    if ($row1 = mysqli_fetch_array($result1)){
                    mysqli_field_seek($result1,0);
                    while ($field1 = mysqli_fetch_field($result1)){
                    } do {
                    echo "<option value=".$row1[0].">".$row1[1]."</option>";
                    } while ($row1 = mysqli_fetch_array($result1));
                    } else { }
                    ?>
                    </select>
                    <div class="invalid-feedback">Requerido.</div>
                </div>  
                <div class="col-sm-4">
                <h6 class="text-info">AUTO PERTENENCIA CULTURAL:</h6>
                    <select name="idnacion" id="idnacion" class="form-control" required>
                    <option value="">-SELECCIONE-</option>
                    <?php
                    $sql1 = "SELECT idnacion, nacion FROM nacion ";
                    $result1 = mysqli_query($link,$sql1);
                    if ($row1 = mysqli_fetch_array($result1)){
                    mysqli_field_seek($result1,0);
                    while ($field1 = mysqli_fetch_field($result1)){
                    } do {
                    echo "<option value=".$row1[0].">".$row1[1]."</option>";
                    } while ($row1 = mysqli_fetch_array($result1));
                    } else { }
                    ?>
                    </select>
                    <div class="invalid-feedback">Requerido.</div>
                </div>        
            </div> 
        
        <hr>
            
                </div>
            </div>

   <!-------- DATOS PERSONALES DEL INTEGRANTE FAMILIAR (End) --------->    
   
        <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">2.- INFORMACIÓN DE LA ATENCIÓN - ENCUESTA MÉDICA</h6>
        </div>
        <div class="card-body">

            <div class="form-group row">  
                <div class="col-sm-4">
                <h6 class="text-info">INCIDENCIA DE LA ATENCIÓN:</h6>
                <?php
                $sql_i =" SELECT idrepeticion, repeticion FROM repeticion ";
                $result_i = mysqli_query($link,$sql_i);
                if ($row_i = mysqli_fetch_array($result_i)){
                mysqli_field_seek($result_i,0);
                while ($field_i = mysqli_fetch_field($result_i)){
                } do { 
                ?>
                <?php echo " - ".$row_i[1]." -> ";?> <input type="radio" name="idrepeticion" value="<?php echo $row_i[0];?>" <?php if ($row_i[0] == '1') { echo "checked";} else { } ?> > <br>
                <?php }
                while ($row_i = mysqli_fetch_array($result_i));
                } else { } ?>
                </div>

                <div class="col-sm-4">
                <h6 class="text-info">LUGAR DE LA ATENCIÓN:</h6>
                <?php
                $sql_c =" SELECT idtipo_consulta, tipo_consulta FROM tipo_consulta ";
                $result_c = mysqli_query($link,$sql_c);
                if ($row_c = mysqli_fetch_array($result_c)){
                mysqli_field_seek($result_c,0);
                while ($field_c = mysqli_fetch_field($result_c)){
                } do { 
                ?>
                <?php echo " - ".$row_c[1]." -> ";?> <input type="radio" name="idtipo_consulta" value="<?php echo $row_c[0];?>" <?php if ($row_c[0] == '1') { echo "checked";} else { } ?> > <br>
                <?php }
                while ($row_c = mysqli_fetch_array($result_c));
                } else { } ?>
                </div>
                <div class="col-sm-4">
                <h6 class="text-info">FECHA DE LA ATENCIÓN:</h6>
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



<!----------- EFECTOS JAVASCRIPT ---------------->
<script>
    (function() {
        setTimeout(function() {
            var formPrevNcf = document.getElementById('form-preventiva-ncf') || document.querySelector('form[action*="guarda_atencion_psano_ncf.php"]');
            if(!formPrevNcf) return;

            // 1. DIBUJO AUTOMÁTICO DE ASTERISCOS
            var camposOb = formPrevNcf.querySelectorAll('input[required], select[required], textarea[required]');
            camposOb.forEach(function(campo) {
                var titulo = null;
                var contenedor = campo.closest('[class*="col-sm-"]');
                if (contenedor) titulo = contenedor.querySelector('h6');
                if (titulo && !titulo.hasAttribute('data-asterisco')) {
                    titulo.innerHTML += ' <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span>';
                    titulo.setAttribute('data-asterisco', 'true');
                }
            });

            // 2. LÓGICA DE ALERGIAS (Anti-fantasmas)
            var radiosAlergia = formPrevNcf.querySelectorAll('.radio-alergia-prev-ncf');
            var txtAlergia = formPrevNcf.querySelector('#d_alergia_prev_ncf');
            var micAlergia = formPrevNcf.querySelector('.mic-alergia-prev-ncf');
            var tituloAlergias = document.getElementById('titulo-alergias-prev-ncf');
            var alertaAlergias = document.getElementById('alerta-alergias-prev-ncf');
            var tituloDescAlergia = document.getElementById('titulo-desc-alergia-prev-ncf'); 
            
            if(radiosAlergia.length > 0 && txtAlergia) {
                radiosAlergia.forEach(function(radio) {
                    radio.addEventListener('change', function() {
                        if (Array.from(radiosAlergia).some(r => r.checked)) {
                            if(alertaAlergias) alertaAlergias.style.setProperty('display', 'none', 'important');
                            if(tituloAlergias) tituloAlergias.style.color = '';
                        }
                        if(this.value === 'SI' && this.checked) {
                            txtAlergia.readOnly = false;
                            txtAlergia.style.backgroundColor = '#fff';
                            txtAlergia.setAttribute('required', 'required'); 
                            txtAlergia.placeholder = "Escriba o utilice el botón de dictado por voz";
                            if(micAlergia) micAlergia.style.display = 'inline-block';
                            if(tituloDescAlergia && !tituloDescAlergia.hasAttribute('data-asterisco')) {
                                tituloDescAlergia.innerHTML += ' <span class="asterisco-dinamico" style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span>';
                                tituloDescAlergia.setAttribute('data-asterisco', 'true');
                            }
                        } else if(this.value === 'NO' && this.checked) {
                            txtAlergia.readOnly = true;
                            txtAlergia.style.backgroundColor = '#eaecf4';
                            txtAlergia.removeAttribute('required'); 
                            txtAlergia.value = '';
                            txtAlergia.classList.remove('is-invalid');
                            txtAlergia.style.border = ''; 
                            var fbAlergia = txtAlergia.parentNode ? txtAlergia.parentNode.querySelector('.invalid-feedback') : null;
                            if (fbAlergia) fbAlergia.style.display = '';
                            txtAlergia.placeholder = "Escriba detalles si marcó SI";
                            if(micAlergia) micAlergia.style.display = 'none';
                            if(tituloDescAlergia && tituloDescAlergia.hasAttribute('data-asterisco')) {
                                var ast = tituloDescAlergia.querySelector('.asterisco-dinamico');
                                if(ast) ast.remove();
                                tituloDescAlergia.removeAttribute('data-asterisco');
                            }
                        }
                    });
                });
            }

            // 3. BUSCADOR INTELIGENTE (DESPLIEGUE AUTOMÁTICO, SIN ACENTOS Y MAYÚSCULAS)
            var buscadores = formPrevNcf.querySelectorAll('.buscador-cie-prev-ncf');
            
            function quitarAcentos(cadena) {
                return cadena.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            }

            buscadores.forEach(function(input) {
                var targetId = input.getAttribute('data-target');
                var selectOriginal = document.getElementById(targetId);
                var listaFlotante = input.nextElementSibling; 
                if(!selectOriginal) return;
                
                var opciones = Array.from(selectOriginal.options).filter(opt => opt.value !== "");
                
                // Función Maestra: Construye la lista dependiendo si hay texto o no
                function mostrarOpciones(filtro) {
                    if (input.readOnly) return; 
                    
                    input.classList.remove('is-invalid');
                    input.style.border = '';
                    var fb = selectOriginal.parentNode.querySelector('.invalid-feedback');
                    if (fb) fb.style.display = '';

                    var term = quitarAcentos(filtro.toLowerCase().trim());
                    listaFlotante.innerHTML = ''; 
                    
                    // MAGIA UX: Si está vacío muestra TODO. Si tiene texto, filtra.
                    var coincidencias = (term === '') 
                        ? opciones 
                        : opciones.filter(opt => quitarAcentos(opt.text.toLowerCase()).includes(term));
                    
                    if (coincidencias.length > 0) {
                        listaFlotante.style.display = 'block'; 
                        coincidencias.slice(0, 100).forEach(function(opt) { 
                            var item = document.createElement('div');
                            item.textContent = opt.text.toUpperCase();
                            item.style.padding = '8px 12px';
                            item.style.cursor = 'pointer';
                            item.style.borderBottom = '1px solid #eaecf4';
                            item.style.fontSize = '0.9rem';
                            item.style.color = '#5a5c69';
                            item.addEventListener('mouseenter', function() { this.style.backgroundColor = '#eaecf4'; this.style.color = '#2e59d9'; });
                            item.addEventListener('mouseleave', function() { this.style.backgroundColor = 'transparent'; this.style.color = '#5a5c69'; });
                            item.addEventListener('mousedown', function(e) {
                                e.preventDefault(); 
                                input.value = opt.text.toUpperCase(); 
                                selectOriginal.value = opt.value; 
                                listaFlotante.style.display = 'none'; 
                                input.readOnly = true;
                                input.style.backgroundColor = '#eaecf4';
                                input.style.color = '#2e59d9';
                                input.style.cursor = 'not-allowed';
                                input.title = "Doble clic o presione Borrar para cambiar";
                            });
                            listaFlotante.appendChild(item);
                        });
                    } else {
                        listaFlotante.style.display = 'none';
                    }
                }

                // Disparadores de la Magia
                input.addEventListener('focus', function() { mostrarOpciones(this.value); });
                input.addEventListener('click', function() { mostrarOpciones(this.value); });
                input.addEventListener('input', function() { mostrarOpciones(this.value); });

                function desbloquear() {
                    if (input.readOnly) {
                        input.readOnly = false;
                        input.value = '';
                        selectOriginal.value = '';
                        input.style.backgroundColor = '';
                        input.style.color = '';
                        input.style.cursor = 'text';
                        input.removeAttribute('title');
                        input.focus(); // Al recuperar el foco, ¡volverá a desplegar la lista automáticamente!
                    }
                }

                input.addEventListener('keydown', function(e) {
                    if (input.readOnly) {
                        if (e.key === 'Backspace' || e.key === 'Delete') { e.preventDefault(); desbloquear(); } 
                        else if (e.key !== 'Tab') { e.preventDefault(); }
                    }
                });
                
                input.addEventListener('dblclick', desbloquear);
                
                input.addEventListener('blur', function() {
                    setTimeout(function() { 
                        listaFlotante.style.display = 'none'; 
                        if (!input.readOnly && input.value.trim() === '') {
                            input.value = ''; selectOriginal.value = ''; 
                        }
                    }, 200);
                });
            });

            // 4. VALIDADOR DE FUERZA BRUTA (INMUNE Y LIMPIADOR EN TIEMPO REAL)
            var btnConfirmar = formPrevNcf.querySelector('#btn-confirmar-preventiva-ncf') || formPrevNcf.querySelector('.modal-footer .btn-info');
            if (btnConfirmar) {
                var nuevoBtn = btnConfirmar.cloneNode(true);
                btnConfirmar.parentNode.replaceChild(nuevoBtn, btnConfirmar);
                
                nuevoBtn.addEventListener('click', function(e) {
                    e.preventDefault(); 
                    var hayErrores = false;
                    var primerInvalido = null;
                    
                    formPrevNcf.querySelectorAll('.is-invalid').forEach(function(el) {
                        el.classList.remove('is-invalid');
                        el.style.border = ''; 
                    });
                    formPrevNcf.querySelectorAll('.invalid-feedback').forEach(function(el) {
                        el.style.display = ''; 
                    });
                    
                    if(radiosAlergia.length > 0) {
                        var alergiaMarcada = Array.from(radiosAlergia).some(r => r.checked);
                        if(!alergiaMarcada) {
                            hayErrores = true;
                            if(alertaAlergias) alertaAlergias.style.setProperty('display', 'block', 'important');
                            if(tituloAlergias) {
                                tituloAlergias.style.color = '#dc3545';
                                if(!primerInvalido) primerInvalido = tituloAlergias;
                            }
                        }
                    }

                    var obligatorios = formPrevNcf.querySelectorAll('input[required], select[required], textarea[required]');
                    obligatorios.forEach(function(el) {
                        var valor = el.value ? el.value.trim() : '';
                        if (valor === '' || !el.checkValidity()) {
                            if(el.name === 'alergia') return; 

                            hayErrores = true;
                            
                            // Ajuste para el diagnóstico único de Preventiva
                            if (el.style.display === 'none' && el.id === 'idpatologia_ap_sano_ncf') {
                                var inputVisual = formPrevNcf.querySelector('input[data-target="' + el.id + '"]');
                                if (inputVisual) {
                                    inputVisual.classList.add('is-invalid');
                                    inputVisual.style.setProperty('border', '2px solid #dc3545', 'important');
                                    var fback = el.parentNode.querySelector('.invalid-feedback');
                                    if (fback) fback.style.setProperty('display', 'block', 'important');
                                    if (!primerInvalido) primerInvalido = inputVisual;
                                }
                            } else if (el.type !== 'hidden' && el.style.display !== 'none') {
                                el.classList.add('is-invalid');
                                el.style.setProperty('border', '2px solid #dc3545', 'important');
                                var fback2 = el.parentNode ? el.parentNode.querySelector('.invalid-feedback') : null;
                                if (fback2) fback2.style.setProperty('display', 'block', 'important');
                                if (!primerInvalido) primerInvalido = el;
                            }
                        }
                    });
                    
                    if (hayErrores) {
                        try {
                            var modalActivo = formPrevNcf.querySelector('.modal');
                            var btnCancelar = modalActivo ? modalActivo.querySelector('[data-dismiss="modal"]') : null;
                            if (btnCancelar) btnCancelar.click();
                            if (modalActivo) $(modalActivo).modal('hide'); 
                        } catch(err) {}
                        
                        setTimeout(function() {
                            document.body.classList.remove('modal-open');
                            var backdrops = document.querySelectorAll('.modal-backdrop');
                            backdrops.forEach(b => b.remove());
                            
                            if (primerInvalido) {
                                primerInvalido.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                setTimeout(() => { try { primerInvalido.focus({ preventScroll: true }); } catch(err) { primerInvalido.focus(); } }, 100);
                            }
                        }, 400);
                    } else {
                        nuevoBtn.innerHTML = "GUARDANDO...";
                        nuevoBtn.disabled = true;
                        formPrevNcf.submit(); 
                    }
                });
                
                ['input', 'change'].forEach(function(evt) {
                    formPrevNcf.addEventListener(evt, function(e) {
                        if (e.target && e.target.hasAttribute && e.target.hasAttribute('required')) {
                            var val = e.target.value || '';
                            if (val.trim() !== '') {
                                e.target.classList.remove('is-invalid');
                                e.target.style.border = '';
                                var fb = e.target.parentNode ? e.target.parentNode.querySelector('.invalid-feedback') : null;
                                if (fb) fb.style.display = '';
                            }
                        }
                    });
                });
            }
        }, 200); 
    })();
</script>

<hr>
            </div>
        </div>


<!--------------------------------------------->    
<!--------  ENCUESTA DETECCION DEL CANCER EN LA NIÑEZ Y ADOLESCENCIA - END ----------->
<!---------------------------------------------> 
    
   <?php 
    break;
    case 2: ?>
<!--------------------------------------------->    
<!--------  ENCUESTA 2 BEGIN ----------->
<!---------------------------------------------> 


<!--------------------------------------------->    
<!--------  ENCUESTA 2 END ----------->
<!---------------------------------------------> 
    <?php break;
    case 3: ?>
<!--------------------------------------------->    
<!--------  ENCUESTA 3 BEGIN ----------->
<!---------------------------------------------> 


<!--------------------------------------------->    
<!--------  ENCUESTA 3 END ----------->
<!---------------------------------------------> 
   
    <?php break;
    case 4: ?>
<!--------------------------------------------->    
<!--------  ENCUESTA 4 BEGIN ----------->
<!---------------------------------------------> 


<!--------------------------------------------->    
<!--------  ENCUESTA 4 END ----------->
<!---------------------------------------------> 

    <?php 
    break;
    }
    ?>

   