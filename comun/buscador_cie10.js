/**
 * Buscador CIE-10 compartido por todo el sistema.
 *
 * - El catálogo se descarga UNA vez (comun/ajax_cie10.php) y queda en caché del navegador.
 * - La búsqueda se hace en el navegador, sin consultar al servidor en cada tecla.
 * - Busca por nombre o por código (ej. "neumonia", "J18", "hipert arterial"), sin importar tildes ni mayúsculas.
 * - Teclado: flechas para moverse, Enter para elegir, Escape para cerrar.
 * - Al elegir: el texto queda bloqueado (azul) y el ID va al campo oculto indicado en data-target.
 *   Para cambiarlo: doble clic o tecla Borrar / Suprimir (se avisa con un mensaje al pasar el mouse).
 *
 * Marcado esperado por cada buscador:
 *   <input type="text" class="form-control buscador-cie-inteligente" data-target="idpatologia_0" autocomplete="off">
 *   <div class="lista-flotante-cie" style="display:none; position:absolute; ..."></div>
 *   <input type="hidden" name="idpatologia[0]" id="idpatologia_0" value="">
 *
 * Inicio:
 *   BuscadorCIE10.iniciar(urlCatalogo [, { selector: '.buscador-cie-inteligente', maxResultados: 30 }]);
 *
 * Reglas de sexo/edad (opcional; ver cie10_reglas_sexo_edad() en inc_cie10.php):
 *   BuscadorCIE10.iniciar(url, { reglas: [...], paciente: { genero: 1|2, edad: 34 } });
 *   Los diagnósticos que no corresponden al paciente se muestran en gris, con el motivo, y no se pueden elegir.
 *   Sin la opción "reglas" el buscador funciona igual que siempre.
 */
(function (window, document) {
    'use strict';

    var ESTILOS =
        '.lista-flotante-cie .cie-item{padding:8px 12px;cursor:pointer;border-bottom:1px solid #eaecf4;font-size:.9rem;color:#5a5c69}' +
        '.lista-flotante-cie .cie-item:hover,.lista-flotante-cie .cie-item.activo{background-color:#eaecf4;color:#2e59d9}' +
        '.lista-flotante-cie .cie-mensaje{padding:8px 12px;font-size:.85rem}' +
        '.lista-flotante-cie .cie-item.cie-no-aplica,.lista-flotante-cie .cie-item.cie-no-aplica:hover,.lista-flotante-cie .cie-item.cie-no-aplica.activo{color:#b7b9cc;background-color:#fafafa;cursor:not-allowed}' +
        '.lista-flotante-cie .cie-motivo{display:block;font-size:.75rem;color:#e74a3b;margin-top:2px}' +
        // Globo de ayuda con efecto vidrio (reemplaza el fondo negro por defecto de Bootstrap)
        '.tooltip.tooltip-vidrio{opacity:1}' +
        '.tooltip.tooltip-vidrio .tooltip-inner{background:rgba(255,255,255,.78);color:#3a3b45;border:1px solid rgba(78,115,223,.35);' +
            'box-shadow:0 6px 18px rgba(58,59,69,.18);-webkit-backdrop-filter:blur(8px);backdrop-filter:blur(8px);' +
            'border-radius:8px;padding:8px 12px;font-size:.8rem;max-width:280px;text-align:left}' +
        '.tooltip.tooltip-vidrio .arrow::before{border-top-color:rgba(78,115,223,.35);border-bottom-color:rgba(78,115,223,.35)}' +
        '.tooltip.tooltip-vidrio.bs-tooltip-right .arrow::before,.tooltip.tooltip-vidrio.bs-tooltip-left .arrow::before{border-top-color:transparent;border-bottom-color:transparent;border-right-color:rgba(78,115,223,.35);border-left-color:rgba(78,115,223,.35)}';

    // Plantilla y separación para los globos de ayuda (también la usan otras partes del formulario)
    var TOOLTIP_VIDRIO = {
        template: '<div class="tooltip tooltip-vidrio" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>',
        offset: '0, 6'
    };

    var catalogo = null;     // [{id, texto, norm, cie}]
    var cargando = null;     // promesa en curso
    var urlCatalogo = '';
    var maxResultados = 30;
    var reglas = null;       // reglas de sexo/edad (opcional)
    var paciente = null;     // { genero, edad } del paciente del formulario

    var MSG_BLOQUEADO = 'Para borrar o cambiar este diagnóstico haga doble clic (o presione la tecla Borrar)';

    // Mensaje al pasar el mouse: globo de Bootstrap si está disponible; si no, el aviso nativo (title)
    function mostrarAyuda(input) {
        input.title = MSG_BLOQUEADO;
        var $ = window.jQuery;
        if ($ && $.fn && $.fn.tooltip) {
            $(input).tooltip($.extend({ placement: 'top', trigger: 'hover' }, TOOLTIP_VIDRIO));
        }
    }
    function quitarAyuda(input) {
        var $ = window.jQuery;
        if ($ && $.fn && $.fn.tooltip) {
            try { $(input).tooltip('dispose'); } catch (e) { }
        }
        input.removeAttribute('title');
        input.removeAttribute('data-original-title');
    }

    function normalizar(s) {
        return String(s).toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/\s+/g, ' ').trim();
    }

    function cargarCatalogo() {
        if (catalogo) return Promise.resolve(catalogo);
        if (cargando) return cargando;
        cargando = fetch(urlCatalogo, { credentials: 'same-origin' })
            .then(function (r) { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
            .then(function (filas) {
                catalogo = filas.map(function (f) {
                    var texto = f[1] + ' - ' + f[2];
                    var categoria = String(f[2]).toUpperCase().replace(/[^A-Z0-9]/g, '').substr(0, 3);
                    return { id: String(f[0]), texto: texto, norm: normalizar(texto), cie: normalizar(f[2]), categoria: categoria };
                });
                return catalogo;
            })
            .catch(function (err) { cargando = null; throw err; });  // permite reintentar
        return cargando;
    }

    function buscar(termino) {
        var t = normalizar(termino);
        if (t === '') return [];
        var palabras = t.split(' ');
        var porCodigo = [], porInicio = [], resto = [];
        for (var i = 0; i < catalogo.length; i++) {
            var p = catalogo[i];
            var todas = true;
            for (var j = 0; j < palabras.length; j++) {
                if (p.norm.indexOf(palabras[j]) === -1) { todas = false; break; }
            }
            if (!todas) continue;
            if (p.cie.indexOf(t) === 0) porCodigo.push(p);        // "j18" -> códigos que empiezan con J18
            else if (p.norm.indexOf(t) === 0) porInicio.push(p);  // nombre que empieza con lo escrito
            else resto.push(p);
        }
        var todos = porCodigo.concat(porInicio, resto);
        if (reglas) {
            // primero los que corresponden al paciente; los que no, al final (en gris)
            var validos = [], noAplican = [];
            todos.forEach(function (p) { (motivoRestriccion(p) ? noAplican : validos).push(p); });
            todos = validos.concat(noAplican);
        }
        return todos.slice(0, maxResultados);
    }

    // Motivo por el que el diagnóstico no corresponde al paciente ('' si corresponde).
    // Mismo criterio y textos que cie10_motivo_restriccion() en inc_cie10.php.
    function motivoRestriccion(p) {
        if (!reglas || !paciente || !p.categoria || p.categoria.length < 3) return '';
        var genero = parseInt(paciente.genero, 10);
        var edad = (paciente.edad === null || paciente.edad === undefined || paciente.edad === '') ? null : parseInt(paciente.edad, 10);
        for (var i = 0; i < reglas.length; i++) {
            var r = reglas[i];
            if (p.categoria < r.desde || p.categoria > r.hasta) continue;
            if ((genero === 1 || genero === 2) && genero !== parseInt(r.genero, 10)) {
                return r.grupo + ': diagnóstico exclusivo de ' + (parseInt(r.genero, 10) === 1 ? 'mujeres' : 'hombres') +
                       ' y el paciente es de sexo ' + (genero === 1 ? 'femenino' : 'masculino') + '.';
            }
            if (edad !== null && !isNaN(edad) &&
                ((r.edad_min !== null && edad < r.edad_min) || (r.edad_max !== null && edad > r.edad_max))) {
                return r.grupo + ': solo corresponde de ' + r.edad_min + ' a ' + r.edad_max +
                       ' años y el paciente tiene ' + edad + ' años.';
            }
            return '';
        }
        return '';
    }

    function prepararBuscador(input) {
        var campoId = document.getElementById(input.getAttribute('data-target'));  // campo oculto con el ID
        var lista = input.nextElementSibling;
        if (!campoId || !lista || input.getAttribute('data-cie-listo')) return;
        input.setAttribute('data-cie-listo', '1');

        var resultados = [];
        var activo = -1;
        var espera = null;

        function mensaje(texto, color) {
            lista.innerHTML = '';
            var d = document.createElement('div');
            d.className = 'cie-mensaje';
            d.style.color = color || '#858796';
            d.textContent = texto;
            lista.appendChild(d);
            lista.style.display = 'block';
        }

        function pintar() {
            lista.innerHTML = '';
            activo = -1;
            if (resultados.length === 0) {
                mensaje('Sin coincidencias. Pruebe con otra palabra o con el código CIE-10.');
                return;
            }
            var frag = document.createDocumentFragment();
            resultados.forEach(function (p, idx) {
                var item = document.createElement('div');
                item.className = 'cie-item';
                item.setAttribute('data-idx', idx);
                item.textContent = p.texto;
                var motivo = motivoRestriccion(p);
                if (motivo) {
                    item.className = 'cie-item cie-no-aplica';
                    var m = document.createElement('span');
                    m.className = 'cie-motivo';
                    m.textContent = 'No corresponde. ' + motivo;
                    item.appendChild(m);
                }
                frag.appendChild(item);
            });
            lista.appendChild(frag);
            lista.style.display = 'block';
            lista.scrollTop = 0;
        }

        function marcarActivo(nuevo) {
            var items = lista.querySelectorAll('.cie-item');
            if (items.length === 0) return;
            if (activo >= 0 && items[activo]) items[activo].classList.remove('activo');
            activo = (nuevo + items.length) % items.length;
            items[activo].classList.add('activo');
            items[activo].scrollIntoView({ block: 'nearest' });
        }

        function elegir(p) {
            if (motivoRestriccion(p)) return;   // no corresponde al paciente: no se puede elegir
            input.value = p.texto;   // texto visible
            campoId.value = p.id;    // ID real que se guarda
            lista.style.display = 'none';
            input.readOnly = true;   // candado visual
            input.style.backgroundColor = '#eaecf4';
            input.style.color = '#2e59d9';
            input.style.cursor = 'not-allowed';
            mostrarAyuda(input);
            campoId.dispatchEvent(new Event('change', { bubbles: true }));
        }

        function desbloquear() {
            if (!input.readOnly) return;
            input.readOnly = false;
            input.value = '';
            campoId.value = '';
            input.style.backgroundColor = '';
            input.style.color = '';
            input.style.cursor = 'text';
            quitarAyuda(input);
            input.focus();
        }

        function ejecutarBusqueda() {
            var termino = input.value;
            if (normalizar(termino) === '') { lista.style.display = 'none'; return; }
            if (!catalogo) mensaje('Cargando catálogo CIE-10...');
            cargarCatalogo().then(function () {
                if (input.readOnly || input.value !== termino) return;  // ya cambió lo escrito
                resultados = buscar(termino);
                pintar();
            }).catch(function () {
                mensaje('No se pudo cargar el catálogo CIE-10. Revise su conexión y vuelva a escribir.', '#e74a3b');
            });
        }

        input.addEventListener('input', function () {
            if (input.readOnly) return;
            // quitar el rojo de validación al empezar a buscar
            input.classList.remove('is-invalid');
            input.style.border = '';
            var fb = campoId.parentNode ? campoId.parentNode.querySelector('.invalid-feedback') : null;
            if (fb) fb.style.display = '';

            campoId.value = '';
            clearTimeout(espera);
            espera = setTimeout(ejecutarBusqueda, 150);
        });

        // mousedown para que no se dispare antes el blur
        lista.addEventListener('mousedown', function (e) {
            var item = e.target.closest('.cie-item');
            e.preventDefault();
            if (!item) return;
            var p = resultados[parseInt(item.getAttribute('data-idx'), 10)];
            if (p) elegir(p);
        });

        input.addEventListener('keydown', function (e) {
            if (input.readOnly) {
                if (e.key === 'Backspace' || e.key === 'Delete') { e.preventDefault(); desbloquear(); }
                else if (e.key !== 'Tab') { e.preventDefault(); }
                return;
            }
            var abierta = lista.style.display === 'block' && lista.querySelector('.cie-item');
            if (!abierta) return;
            if (e.key === 'ArrowDown') { e.preventDefault(); marcarActivo(activo + 1); }
            else if (e.key === 'ArrowUp') { e.preventDefault(); marcarActivo(activo - 1); }
            else if (e.key === 'Enter') {
                e.preventDefault();  // nunca enviar el formulario con Enter aquí
                if (activo >= 0 && resultados[activo]) elegir(resultados[activo]);
            }
            else if (e.key === 'Escape') { lista.style.display = 'none'; }
        });

        input.addEventListener('dblclick', desbloquear);

        // clic afuera sin elegir: se limpia lo escrito
        input.addEventListener('blur', function () {
            setTimeout(function () {
                lista.style.display = 'none';
                if (!input.readOnly) {
                    clearTimeout(espera);
                    input.value = '';
                    campoId.value = '';
                }
            }, 200);
        });
    }

    function iniciar(url, opciones) {
        opciones = opciones || {};
        urlCatalogo = url;
        if (opciones.maxResultados) maxResultados = opciones.maxResultados;
        if (opciones.reglas && opciones.reglas.length && opciones.paciente) {
            reglas = opciones.reglas;
            paciente = opciones.paciente;
        }

        if (!document.getElementById('buscador-cie10-estilos')) {
            var st = document.createElement('style');
            st.id = 'buscador-cie10-estilos';
            st.textContent = ESTILOS;
            document.head.appendChild(st);
        }

        var arrancar = function () {
            document.querySelectorAll(opciones.selector || '.buscador-cie-inteligente').forEach(prepararBuscador);
            cargarCatalogo().catch(function () {});  // precarga en segundo plano
        };
        if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', arrancar);
        else arrancar();
    }

    window.BuscadorCIE10 = { iniciar: iniciar, normalizar: normalizar, tooltipVidrio: TOOLTIP_VIDRIO };
})(window, document);
