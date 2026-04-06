/* =========================================================
   LÓGICA SISTEMA MEDI-SAFCI - VERSIÓN FINAL UNIFICADA
   ========================================================= */

function calcularEdadYCampos(idFecha, idEdad, idPC, idPT, idPab, idIMC) {
    var fechaNacInput = document.getElementById(idFecha);
    if (!fechaNacInput || !fechaNacInput.value) return;

    var edadInput = document.getElementById(idEdad);
    var containerPC = document.getElementById(idPC);
    var containerPT = document.getElementById(idPT);
    var containerPab = document.getElementById(idPab);
    var containerIMC = document.getElementById(idIMC);

    var partes = fechaNacInput.value.split('/'); 
    var fechaNac;
    
    if (partes.length === 3) {
        fechaNac = new Date(partes[2], partes[1] - 1, partes[0]);
    } else {
        fechaNac = new Date(fechaNacInput.value); 
    }

    var hoy = new Date();
    var edadAnios = hoy.getFullYear() - fechaNac.getFullYear();
    var mes = hoy.getMonth() - fechaNac.getMonth();
    
    if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNac.getDate())) edadAnios--;

    if (isNaN(edadAnios)) {
        if(edadInput) edadInput.value = "Fecha inválida";
        return;
    }

    if (edadAnios <= 0) {
        var edadMeses = (hoy.getFullYear() - fechaNac.getFullYear()) * 12 + hoy.getMonth() - fechaNac.getMonth();
        if (hoy.getDate() < fechaNac.getDate()) edadMeses--;
        if(edadInput) edadInput.value = edadMeses > 0 ? edadMeses + " meses" : "Recién nacido";
    } else {
        if(edadInput) edadInput.value = edadAnios + (edadAnios === 1 ? " año" : " años");
    }

    var mostrarPediatricos = edadAnios <= 5;
    if(containerPC) containerPC.style.display = mostrarPediatricos ? 'flex' : 'none';
    if(containerPT) containerPT.style.display = mostrarPediatricos ? 'flex' : 'none';
    if(containerPab) containerPab.style.display = mostrarPediatricos ? 'flex' : 'none';
    
    var mostrarIMC = edadAnios >= 2;
    if(containerIMC) containerIMC.style.display = mostrarIMC ? 'flex' : 'none';
}

function calcularIMC(idPeso, idTalla, idIMC) {
    var peso = parseFloat(document.getElementById(idPeso).value);
    var talla = parseFloat(document.getElementById(idTalla).value);
    var inputIMC = document.getElementById(idIMC);
    if(inputIMC) {
        if (!isNaN(peso) && !isNaN(talla) && talla > 0) {
            inputIMC.value = (peso / (talla * talla)).toFixed(2); 
        } else { 
            inputIMC.value = ''; 
        }
    }
}

function mostrarFormulario() {
    var seleccion = document.getElementById('proceso-select').value;
    var panelesInferiores = document.getElementById('paneles-comunes-inferiores');

    document.querySelectorAll('.form-process').forEach(function(p) { p.classList.remove('active'); p.style.display = 'none'; });

    document.querySelectorAll('input, select, textarea').forEach(function(campo) {
        campo.style.borderColor = ''; campo.style.boxShadow = '';
    });

    if (seleccion) {
        var procesoActivo = document.getElementById(seleccion);
        if(procesoActivo) {
            procesoActivo.classList.add('active');
            procesoActivo.style.display = 'block';
        }
        if(panelesInferiores) {
            panelesInferiores.classList.add('active');
            panelesInferiores.style.display = 'block';
        }

        // Lógica actualizada para los paneles 8 (Destino / Cierre)
        var panel8ti = document.getElementById('panel8-ti');
        var panel8tc = document.getElementById('panel8-tc');
        if(panel8ti) panel8ti.style.display = (seleccion === 'paneles-teleinterconsulta') ? 'block' : 'none';
        if(panel8tc) panel8tc.style.display = (seleccion === 'paneles-teleconsulta') ? 'block' : 'none';

        // Lógica de cambio de título Estudios/Conducta
        var tituloPanel = document.getElementById('titulo-estudios-conducta');
        var labelText = document.getElementById('label-tratamiento-comentario');
        if(tituloPanel && labelText) {
            if(seleccion === 'paneles-telemetria') {
                tituloPanel.innerText = '7.- ESTUDIOS COMPLEMENTARIOS Y COMENTARIOS';
                labelText.innerText = 'Comentarios';
            } else {
                tituloPanel.innerText = '7.- ESTUDIOS COMPLEMENTARIOS Y CONDUCTA';
                labelText.innerText = 'Tratamiento';
            }
        }

        if(seleccion === 'paneles-teleinterconsulta'){
            calcularEdadYCampos('paciente-fecha-nac', 'paciente-edad', 'ti-pc', 'ti-pt', 'ti-pab', 'ti-imc-box');
        } else if(seleccion === 'paneles-teleconsulta') {
            calcularEdadYCampos('paciente-fecha-nac', 'paciente-edad', 'tc-pc', 'tc-pt', 'tc-pab', 'tc-imc-box');
        } else if(seleccion === 'paneles-telemetria') {
            calcularEdadYCampos('paciente-fecha-nac', 'paciente-edad', 'tm-pc', 'tm-pt', 'tm-pab', 'tm-imc-box');
        }
    } else {
        if(panelesInferiores) {
            panelesInferiores.classList.remove('active');
            panelesInferiores.style.display = 'none';
        }
    }
}

function volverAlSelector() {
    document.getElementById('proceso-select').value = '';
    mostrarFormulario();
}

// ==========================================
// DICTADO POR VOZ
// ==========================================
function iniciarDictado(textareaId) {
    var evt = window.event;
    var btnMic = evt ? evt.currentTarget : null;

    var SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    if (!SpeechRecognition) return alert("Navegador no soporta dictado por voz.");
    
    var recognition = new SpeechRecognition();
    recognition.lang = 'es-BO';
    
    var textarea = document.getElementById(textareaId);
    if (!textarea) return;
    
    recognition.onstart = function() { 
        if(btnMic) btnMic.classList.add('recording'); 
        textarea.setAttribute('data-placeholder-orig', textarea.placeholder || "");
        textarea.placeholder = "Escuchando..."; 
    };
    
    recognition.onresult = function(e) { 
        var texto = e.results[0][0].transcript;
        textarea.value += (textarea.value ? ' ' : '') + (textarea.value === "" ? texto.charAt(0).toUpperCase() + texto.slice(1) : texto);
    };
    
    recognition.onend = function() { 
        if(btnMic) btnMic.classList.remove('recording'); 
        textarea.placeholder = textarea.getAttribute('data-placeholder-orig') || ""; 
    };
    
    recognition.onerror = function(e) { 
        if(btnMic) btnMic.classList.remove('recording'); 
        alert('Error en el micrófono: ' + e.error); 
    };

    recognition.start();
}

// ==========================================
// AUTOCOMPLETADO
// ==========================================
var arrayEESS = [], arrayEspecialidades = [], arrayDiagnosticos = [];

async function descargarDatosDrive(urlCsv, tipo) {
    try {
        var res = await fetch(urlCsv); var text = await res.text();
        var filas = text.split('\n').map(function(f) { return f.trim(); }).filter(function(f) { return f.length > 0; });
        if (tipo === 'eess') arrayEESS = filas;
        if (tipo === 'especialidades') arrayEspecialidades = filas;
        if (tipo === 'diagnosticos') arrayDiagnosticos = filas;
    } catch (error) { console.error(error); }
}

function activarBuscador(inputId, listId, getArrayDatos) {
    var input = document.getElementById(inputId);
    var list = document.getElementById(listId);
    if(!input || !list) return;
    
    var btnClear = input.nextElementSibling;
    
    function actualizarLista(filtro) {
        if (input.readOnly && !input.hasAttribute('data-original-readonly')) return; 

        list.innerHTML = ''; 
        var datos = getArrayDatos();
        var resultados = filtro ? datos.filter(function(item) { return item.toLowerCase().includes(filtro.toLowerCase()); }) : datos;

        btnClear.style.display = input.value ? 'block' : 'none';

        if (resultados.length === 0) { list.style.display = 'none'; return; }

        list.style.display = 'block'; 
        
        var rect = input.getBoundingClientRect();
        var spaceBelow = window.innerHeight - rect.bottom;
        var spaceAbove = rect.top;
        
        if (spaceBelow < 260 && spaceAbove > spaceBelow) {
            list.style.top = 'auto'; list.style.bottom = '100%'; list.style.boxShadow = '0 -4px 6px rgba(0,0,0,0.1)';
        } else {
            list.style.top = '100%'; list.style.bottom = 'auto'; list.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
        }
        
        resultados.slice(0, 150).forEach(function(item) {
            var div = document.createElement('div'); 
            div.textContent = item;
            
            div.addEventListener('mousedown', function(e) { 
                e.preventDefault(); 
                input.value = this.textContent; 
                list.style.display = 'none'; 
                btnClear.style.display = 'block';

                input.readOnly = true; 
                input.style.backgroundColor = '#f6fbf7'; 
                input.style.color = '#495057'; 
                input.style.fontWeight = '400'; 
                input.style.borderColor = ''; input.style.boxShadow = '';
            });
            list.appendChild(div);
        });
    }

    input.addEventListener('focus', function() { actualizarLista(this.value); }); 
    input.addEventListener('input', function() { actualizarLista(this.value); }); 

    document.addEventListener('mousedown', function(e) { 
        if (e.target !== input && !list.contains(e.target) && e.target !== btnClear) {
            list.style.display = 'none';
            if (!input.readOnly && input.value !== '') { input.value = ''; btnClear.style.display = 'none'; }
        }
    });
}

function limpiarBuscador(inputId) { 
    var input = document.getElementById(inputId); 
    if(input){ 
        input.value = ''; 
        input.readOnly = false; 
        input.style.backgroundColor = ''; 
        input.style.color = '';
        input.style.fontWeight = '';
        input.focus(); 
        input.dispatchEvent(new Event('input')); 
    } 
}

// ==========================================
// VISOR DE MULTIMEDIA (CON ZOOM E IMPRESIÓN)
// ==========================================
var arrayArchivosGlobal = [];
function mostrarNombresArchivos(input, displayId) {
    var display = document.getElementById(displayId);
    if (!display) return;
    
    if (input && input.files && input.files.length > 0) {
        Array.from(input.files).forEach(function(file) { arrayArchivosGlobal.push({ file: file, displayId: displayId }); });
        input.value = ''; 
    }
    display.innerHTML = ''; 
    
    arrayArchivosGlobal.forEach(function(item, index) {
        if(item.displayId !== displayId) return;

        var file = item.file;
        var fileUrl = URL.createObjectURL(file);
        var thumb = document.createElement('div');
        thumb.className = 'file-thumb';
        thumb.title = file.name;

        if (file.type.startsWith('image/')) thumb.style.backgroundImage = 'url(' + fileUrl + ')';
        else if (file.type.startsWith('video/')) thumb.innerHTML = '🎥';
        else if (file.type.startsWith('audio/')) thumb.innerHTML = '🎵';
        else if (file.type === 'application/pdf') thumb.innerHTML = '📄';
        else thumb.innerHTML = '📁';

        var btnDelete = document.createElement('span');
        btnDelete.innerHTML = '✖'; btnDelete.className = 'btn-delete-file';
        btnDelete.onclick = function(e) { e.stopPropagation(); arrayArchivosGlobal.splice(index, 1); mostrarNombresArchivos({files: []}, displayId); };
        thumb.appendChild(btnDelete);

        thumb.onclick = function() {
            var newWin = window.open('', '_blank');
            if (file.type.startsWith('image/')) {
                var html = '<!DOCTYPE html><html><head><title>Visor de Imagen - ' + file.name + '</title>';
                html += '<style>';
                html += 'body { margin: 0; background-color: #222; display: flex; justify-content: center; align-items: center; height: 100vh; overflow: hidden; font-family: sans-serif; }';
                html += '.toolbar { position: absolute; top: 20px; right: 20px; z-index: 1000; display: flex; gap: 10px; }';
                html += '.btn-visor { background-color: #36b9cc; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 0.9rem; box-shadow: 0 4px 6px rgba(0,0,0,0.3); transition: background 0.2s; }';
                html += '.btn-visor:hover { background-color: #2a96a6; }';
                html += '#img-preview { max-width: 95%; max-height: 95vh; transition: transform 0.1s ease-out; transform-origin: center center; cursor: grab; }';
                html += '@media print { body { background-color: white; } .toolbar { display: none; } #img-preview { max-width: 100%; max-height: 100%; transform: scale(1) !important; } }';
                html += '</style></head><body>';
                
                html += '<div class="toolbar">';
                html += '<button class="btn-visor" onclick="window.print()">🖨️ IMPRIMIR</button>';
                html += '<button class="btn-visor" onclick="window.close()">✖ CERRAR</button>';
                html += '</div>';
                
                html += '<img id="img-preview" src="' + fileUrl + '" />';
                
                html += '<script>';
                html += 'var img = document.getElementById("img-preview");';
                html += 'var scale = 1;';
                html += 'window.addEventListener("wheel", function(e) {';
                html += '    e.preventDefault();';
                html += '    scale += e.deltaY * -0.001;';
                html += '    scale = Math.min(Math.max(0.3, scale), 5);'; 
                html += '    img.style.transform = "scale(" + scale + ")";';
                html += '}, { passive: false });';
                html += '</script></body></html>';
                
                newWin.document.write(html);
                newWin.document.close(); 
            } else { 
                newWin.location.href = fileUrl; 
            }
        };
        display.appendChild(thumb);
    });
}

// ==========================================
// GUARDAR REGISTRO Y MODO VISTA DE LECTURA
// ==========================================
function guardarRegistro(event) {
    event.preventDefault(); 

    var camposFaltantes = 0;
    var primerCampoVacio = null;

    document.querySelectorAll('input[required], select[required], textarea[required]').forEach(function(campo) {
        if (campo.offsetParent !== null) {
            if (campo.value.trim() === '' || (campo.tagName === 'SELECT' && campo.value === '')) {
                campo.style.borderColor = '#dc3545';
                campo.style.boxShadow = '0 0 5px rgba(220, 53, 69, 0.3)';
                camposFaltantes++;
                if(!primerCampoVacio) primerCampoVacio = campo;
            } else {
                campo.style.borderColor = ''; 
                campo.style.boxShadow = '';
            }
        }
    });

    if (camposFaltantes > 0) {
        alert("⚠️ Faltan " + camposFaltantes + " campos obligatorios por llenar.\nEstán resaltados en rojo.");
        if(primerCampoVacio) primerCampoVacio.focus();
        return; 
    }

    document.querySelectorAll('.btn-mic, .clear-btn, .file-upload-wrapper, #selector-area-inline').forEach(function(el) { 
        el.style.display = 'none'; 
    });

    document.querySelectorAll('.form-group, .vital-sign-item').forEach(function(grupo) {
        var campo = grupo.querySelector('textarea, input:not([type="file"]), select');
        
        if (campo && campo.type !== 'radio' && campo.type !== 'checkbox') {
            if (campo.value.trim() === '' || (campo.tagName === 'SELECT' && campo.value === '')) {
                grupo.style.display = 'none'; 
                grupo.classList.add('ocultado-por-guardado');
            } else {
                if(!campo.hasAttribute('data-original-readonly')) campo.setAttribute('data-original-readonly', campo.readOnly);
                if(!campo.hasAttribute('data-original-disabled')) campo.setAttribute('data-original-disabled', campo.disabled);
                
                campo.readOnly = true;
                if(campo.tagName === 'SELECT') campo.disabled = true;
                
                campo.style.backgroundColor = '#ffffff';
                campo.style.borderColor = 'transparent'; 
                campo.style.boxShadow = 'none';
                campo.style.paddingLeft = '0'; 
                campo.style.paddingTop = '0';
                campo.style.backgroundImage = 'none'; 
                campo.style.fontWeight = 'bold';
                campo.style.color = '#3457cd'; 
            }
        } else if(campo && (campo.type === 'radio' || campo.type === 'checkbox')) {
            var opciones = grupo.querySelectorAll('input[type="radio"], input[type="checkbox"]');
            opciones.forEach(function(op) { 
                op.disabled = true; 
                
                if (op.type === 'checkbox' && !op.checked) {
                    var parentCheckboxItem = op.closest('.checkbox-item');
                    if (parentCheckboxItem) {
                        parentCheckboxItem.style.display = 'none';
                        parentCheckboxItem.classList.add('ocultado-por-guardado');
                    }
                }
            });
        }
    });

    // 4. Cambiar botones inferiores (Botones modernos + Botón Ver Respuesta)
    var contenedorSubmit = document.querySelector('.submit-container');
    
    // NOTA: Esta variable "respuesta_existe" simula que ya llegó una respuesta.
    var respuesta_existe = true; 

    var botonesNuevos = '<button type="button" class="btn-submit" style="background-color: #ffffff; color: var(--medi-blue); border: 2px solid var(--medi-blue); margin-right: 15px; box-shadow: none;" onclick="editarRegistro()">✏️ EDITAR REGISTRO</button>' +
                        '<button type="button" class="btn-submit" style="background-color: var(--medi-blue); color: white; border: 2px solid var(--medi-blue); margin-right: 15px;" onclick="window.print()">🖨️ IMPRIMIR REPORTE</button>';

    // Si la respuesta existe, agregamos el botón verde
    if (respuesta_existe) {
        botonesNuevos += '<button type="button" class="btn-submit" style="background-color: #1cc88a; color: white; border: 2px solid #1cc88a;" onclick="window.location.href=\'respuesta_especialista.html\'">📥 VER RESPUESTA</button>';
    }

    contenedorSubmit.innerHTML = botonesNuevos;
        
    var btnRespuesta = document.getElementById('btn-flotante-respuesta');
    if (btnRespuesta) btnRespuesta.style.display = 'flex';

    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function editarRegistro() {
    document.querySelectorAll('.btn-mic, .file-upload-wrapper, #selector-area-inline').forEach(function(el) { 
        el.style.display = ''; 
    });

    document.querySelectorAll('.form-group, .vital-sign-item, .checkbox-item').forEach(function(grupo) {
        if (grupo.classList.contains('ocultado-por-guardado')) {
            grupo.style.display = ''; 
            grupo.classList.remove('ocultado-por-guardado');
        }
        
        var campo = grupo.querySelector('textarea, input:not([type="file"]), select');
        
        if (campo && campo.type !== 'radio' && campo.type !== 'checkbox') {
            if(campo.getAttribute('data-original-readonly') === 'false') campo.readOnly = false;
            if(campo.tagName === 'SELECT' && campo.getAttribute('data-original-disabled') === 'false') campo.disabled = false;
            
            campo.style.backgroundColor = '';
            campo.style.borderColor = '';
            campo.style.boxShadow = '';
            campo.style.paddingLeft = '';
            campo.style.paddingTop = '';
            campo.style.backgroundImage = '';
            campo.style.fontWeight = '';
            campo.style.color = '';
        } else if(campo && (campo.type === 'radio' || campo.type === 'checkbox')) {
            var opciones = grupo.querySelectorAll('input[type="radio"], input[type="checkbox"]');
            opciones.forEach(function(op) { op.disabled = false; });
        }
    });

    var contenedorSubmit = document.querySelector('.submit-container');
    contenedorSubmit.innerHTML = '<button type="submit" class="btn-submit">GUARDAR REGISTRO</button>';

    var btnRespuesta = document.getElementById('btn-flotante-respuesta');
    if (btnRespuesta) btnRespuesta.style.display = 'none';
}

// ==========================================
// CARGA INICIAL
// ==========================================
window.onload = async function() {
    var urlEESS = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQ6KTetPPMOzwiVClqqbMAyZ1MIBC3w0rDQ1xwbXwuINHBwVZm3AuFUP6wkxHDr3A/pub?gid=1074868790&single=true&output=csv';
    var urlEspecialidades = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQ6KTetPPMOzwiVClqqbMAyZ1MIBC3w0rDQ1xwbXwuINHBwVZm3AuFUP6wkxHDr3A/pub?gid=230572026&single=true&output=csv';
    var urlDiagnosticos = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQ6KTetPPMOzwiVClqqbMAyZ1MIBC3w0rDQ1xwbXwuINHBwVZm3AuFUP6wkxHDr3A/pub?gid=681742173&single=true&output=csv';
    
    await descargarDatosDrive(urlEESS, 'eess'); 
    await descargarDatosDrive(urlEspecialidades, 'especialidades'); 
    await descargarDatosDrive(urlDiagnosticos, 'diagnosticos');
    
    activarBuscador('ti-eess-destino', 'ti-eess-destino-list', function() { return arrayEESS; });
    activarBuscador('ti-esp-dest', 'ti-esp-dest-list', function() { return arrayEspecialidades; });
    activarBuscador('tc-especialidad', 'tc-especialidad-list', function() { return arrayEspecialidades; });

    activarBuscador('global-diag1-input', 'global-diag1-list', function() { return arrayDiagnosticos; });
    activarBuscador('global-diag2-input', 'global-diag2-list', function() { return arrayDiagnosticos; });
    activarBuscador('global-diag3-input', 'global-diag3-list', function() { return arrayDiagnosticos; });
    activarBuscador('global-diag4-input', 'global-diag4-list', function() { return arrayDiagnosticos; });
    
    calcularEdadYCampos('paciente-fecha-nac', 'paciente-edad');
};