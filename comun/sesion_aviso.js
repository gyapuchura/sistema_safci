/**
 * Aviso de cierre de sesión por inactividad (compartido por los formularios largos).
 *
 * - Mientras el usuario trabaja en la página (teclado, mouse, toque), la sesión se renueva sola cada pocos minutos.
 * - Tras un tiempo sin actividad (por defecto 60 minutos) aparece un aviso con cuenta regresiva de 2 minutos
 *   y el botón CONTINUAR. Si nadie responde, se cierra la sesión.
 * - Antes de avisar revisa si el usuario sigue trabajando en otra pestaña del sistema; en ese caso no avisa
 *   (cerrar la sesión aquí también la cerraría en esa otra pestaña).
 * - Si la sesión ya se cerró (desde otra pestaña o por tiempo del servidor) o se ingresó con otro usuario, lo informa.
 *
 * Uso:
 *   <script src="../comun/sesion_aviso.js"></script>
 *   <script>SesionAviso.iniciar({ idusuario: 12, limiteServidor: 14400, formularioRecuperable: true });</script>
 *
 *   formularioRecuperable: true si el formulario puede guardarse después de volver a ingresar con el mismo usuario
 *                          (ej. referencia, con token firmado). false: se indica volver a abrir el caso.
 *   SesionAviso.verificar() -> Promise<boolean>: true si la sesión sigue activa con el mismo usuario
 *                          (usar justo antes de enviar el formulario).
 */
(function (window, document) {
    'use strict';

    var cfg = {
        ping: '../comun/sesion_ping.php',
        salir: '../salir.php',
        login: '../login.php',
        inicio: '../administrar_sistema/inicio.php',
        inactividadMin: 60,        // minutos sin actividad antes del aviso (ej. el médico atiende una emergencia)
        avisoSeg: 120,             // duración de la cuenta regresiva
        renovarMin: 5,             // cada cuánto se renueva la sesión mientras hay actividad
        limiteServidor: 0,         // session.gc_maxlifetime (segundos); el aviso siempre termina antes
        idusuario: 0,
        formularioRecuperable: false
    };

    var ultimaActividad = Date.now();
    var ultimaRenovacion = Date.now();
    var estado = 'normal';         // normal | aviso | perdida | cerrando
    var finAviso = 0;
    var relojAviso = null;
    var consultando = false;
    var capa = null;

    // ---------------------------------------------------------------- servidor
    function pedir(consulta) {
        return fetch(cfg.ping + (consulta ? '?consulta=1' : ''), { credentials: 'same-origin', cache: 'no-store' })
            .then(function (r) { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); });
    }

    // '' si todo está bien; 'cerrada' o 'otro_usuario' si hay un problema
    function problema(d) {
        if (!d || !d.activa) return 'cerrada';
        if (cfg.idusuario && parseInt(d.usuario, 10) !== parseInt(cfg.idusuario, 10)) return 'otro_usuario';
        return '';
    }

    function renovar() {
        ultimaRenovacion = Date.now();
        return pedir(false).then(function (d) {
            var p = problema(d);
            if (p) mostrarPerdida(p);
            return d;
        }).catch(function () { return null; });   // sin conexión: se reintenta con la próxima actividad
    }

    // ¿Hubo peticiones de otra pestaña después de la última actividad en esta?
    function otraPestanaActiva(d, inactivoMs) {
        if (!d || !d.ultima_actividad || !d.ahora) return false;
        var hace = (d.ahora - d.ultima_actividad) * 1000;
        if (hace < inactivoMs - 30000) {
            ultimaActividad = Date.now() - hace;   // se toma esa actividad como propia
            return true;
        }
        return false;
    }

    function inactividadMs() {
        var ms = cfg.inactividadMin * 60000;
        if (cfg.limiteServidor > 0) {
            var maximo = (cfg.limiteServidor - cfg.avisoSeg - 60) * 1000;
            if (maximo < ms) ms = Math.max(60000, maximo);
        }
        return ms;
    }

    // ---------------------------------------------------------------- actividad
    function actividad() {
        if (estado !== 'normal') return;
        ultimaActividad = Date.now();
        if (Date.now() - ultimaRenovacion > cfg.renovarMin * 60000) renovar();
    }

    function revisar() {
        if (estado === 'aviso') { pintarCuenta(); return; }
        if (estado !== 'normal' || consultando) return;
        var inactivo = Date.now() - ultimaActividad;
        if (inactivo < inactividadMs()) return;

        consultando = true;
        pedir(true).then(function (d) {
            consultando = false;
            if (estado !== 'normal') return;
            var p = problema(d);
            if (p) { mostrarPerdida(p); return; }
            if (otraPestanaActiva(d, inactivo)) return;
            abrirAviso();
        }).catch(function () {
            consultando = false;
            if (estado === 'normal') abrirAviso();
        });
    }

    // ---------------------------------------------------------------- ventana del aviso
    function estilosBoton(color) {
        return 'margin:4px;min-width:150px;font-weight:600;' + (color ? 'background:' + color + ';border-color:' + color + ';' : '');
    }

    function crearCapa(html) {
        cerrarCapa();
        capa = document.createElement('div');
        capa.setAttribute('role', 'dialog');
        capa.setAttribute('aria-modal', 'true');
        capa.style.cssText = 'position:fixed;top:0;left:0;right:0;bottom:0;z-index:2000;background:rgba(33,37,41,.55);display:flex;' +
            'align-items:center;justify-content:center;padding:16px;';
        capa.innerHTML =
            '<div style="background:#fff;border-radius:12px;max-width:460px;width:100%;box-shadow:0 1rem 3rem rgba(0,0,0,.25);' +
            'padding:28px 26px;text-align:center;font-family:inherit;color:#5a5c69;">' + html + '</div>';
        document.body.appendChild(capa);
        return capa;
    }

    function cerrarCapa() {
        if (capa && capa.parentNode) capa.parentNode.removeChild(capa);
        capa = null;
    }

    function icono(color, clase) {
        return '<div style="width:64px;height:64px;border-radius:50%;margin:0 auto 14px;display:flex;align-items:center;' +
            'justify-content:center;background:' + color + '1a;color:' + color + ';font-size:28px;">' +
            '<i class="fas ' + clase + '"></i></div>';
    }

    function abrirAviso() {
        estado = 'aviso';
        finAviso = Date.now() + cfg.avisoSeg * 1000;
        crearCapa(
            icono('#4e73df', 'fa-clock') +
            '<h5 style="color:#3a3b45;font-weight:700;margin-bottom:8px;">Su sesión está por cerrarse</h5>' +
            '<p style="margin-bottom:6px;">No se detectó actividad en los últimos minutos. Por seguridad, la sesión se cerrará en:</p>' +
            '<div id="sesion-aviso-cuenta" style="font-size:2.4rem;font-weight:700;color:#e74a3b;letter-spacing:1px;margin:6px 0 14px;">2:00</div>' +
            '<p style="font-size:.85rem;margin-bottom:18px;">Presione <b>CONTINUAR</b> para seguir trabajando. Lo que haya escrito se mantiene.</p>' +
            '<button type="button" class="btn btn-primary" id="sesion-aviso-continuar" style="' + estilosBoton('') + '">CONTINUAR</button>'
        );
        document.getElementById('sesion-aviso-continuar').addEventListener('click', continuar);
        try { document.getElementById('sesion-aviso-continuar').focus(); } catch (e) { }
        pintarCuenta();
        clearInterval(relojAviso);
        relojAviso = setInterval(pintarCuenta, 1000);
    }

    function pintarCuenta() {
        if (estado !== 'aviso') return;
        var restante = Math.max(0, finAviso - Date.now());
        var s = Math.ceil(restante / 1000);
        var el = document.getElementById('sesion-aviso-cuenta');
        if (el) el.textContent = Math.floor(s / 60) + ':' + ('0' + (s % 60)).slice(-2);
        if (restante <= 0) {
            clearInterval(relojAviso);
            relojAviso = null;
            finCuenta();
        }
    }

    function continuar() {
        clearInterval(relojAviso);
        relojAviso = null;
        cerrarCapa();
        estado = 'normal';
        ultimaActividad = Date.now();
        renovar();
    }

    function finCuenta() {
        estado = 'cerrando';
        // última revisión: si trabaja en otra pestaña, no se cierra
        pedir(true).then(function (d) {
            var p = problema(d);
            if (p) { estado = 'normal'; mostrarPerdida(p); return; }
            if (otraPestanaActiva(d, Date.now() - ultimaActividad)) { cerrarCapa(); estado = 'normal'; return; }
            cerrarSesion();
        }).catch(cerrarSesion);
    }

    function cerrarSesion() {
        estado = 'cerrando';
        window.location.href = cfg.salir;
    }

    function mostrarPerdida(tipo) {
        if (estado === 'perdida' || estado === 'cerrando') return;
        clearInterval(relojAviso);
        relojAviso = null;
        estado = 'perdida';

        var titulo, texto, botones;
        if (tipo === 'otro_usuario') {
            titulo = 'Se ingresó con otro usuario';
            texto = cfg.formularioRecuperable
                ? 'En este navegador se ingresó al sistema con otro usuario. Este formulario solo puede registrarse con el usuario que lo abrió.<br><br>' +
                  '1. Presione <b>INGRESAR EN PESTAÑA NUEVA</b> e ingrese con el usuario que abrió este formulario.<br>' +
                  '2. Vuelva a esta pestaña y presione <b>YA INGRESÉ</b>. Lo escrito se mantiene.'
                : 'En este navegador se ingresó al sistema con otro usuario. Para continuar, vuelva a abrir el caso con su usuario.';
        } else {
            titulo = 'Su sesión se cerró';
            texto = cfg.formularioRecuperable
                ? 'La sesión terminó por tiempo o se cerró desde otra pestaña. Lo escrito en este formulario se mantiene.<br><br>' +
                  '1. Presione <b>INGRESAR EN PESTAÑA NUEVA</b> e ingrese con su mismo usuario.<br>' +
                  '2. Vuelva a esta pestaña y presione <b>YA INGRESÉ</b> para continuar.'
                : 'La sesión terminó por tiempo o se cerró desde otra pestaña. Debe ingresar nuevamente al sistema y volver a abrir el caso.';
        }

        if (cfg.formularioRecuperable) {
            botones =
                '<button type="button" class="btn btn-outline-primary" id="sesion-aviso-login" style="' + estilosBoton('') + '">INGRESAR EN PESTAÑA NUEVA</button>' +
                '<button type="button" class="btn btn-primary" id="sesion-aviso-reintentar" style="' + estilosBoton('') + '">YA INGRESÉ</button>' +
                '<div id="sesion-aviso-nota" style="font-size:.8rem;color:#e74a3b;margin-top:10px;min-height:1em;"></div>';
        } else {
            botones = '<button type="button" class="btn btn-primary" id="sesion-aviso-ir" style="' + estilosBoton('') + '">' +
                (tipo === 'otro_usuario' ? 'IR AL INICIO' : 'INGRESAR NUEVAMENTE') + '</button>';
        }

        crearCapa(
            icono('#e74a3b', 'fa-user-lock') +
            '<h5 style="color:#3a3b45;font-weight:700;margin-bottom:10px;">' + titulo + '</h5>' +
            '<p style="font-size:.9rem;text-align:left;margin-bottom:18px;">' + texto + '</p>' + botones
        );

        if (cfg.formularioRecuperable) {
            document.getElementById('sesion-aviso-login').addEventListener('click', function () {
                window.open(cfg.login, '_blank');
            });
            document.getElementById('sesion-aviso-reintentar').addEventListener('click', function () {
                var nota = document.getElementById('sesion-aviso-nota');
                if (nota) nota.textContent = 'Verificando...';
                pedir(true).then(function (d) {
                    if (problema(d)) {
                        if (nota) nota.textContent = 'Todavía no se detecta el ingreso con el usuario que abrió este formulario.';
                        return;
                    }
                    cerrarCapa();
                    estado = 'normal';
                    ultimaActividad = Date.now();
                    renovar();
                }).catch(function () {
                    if (nota) nota.textContent = 'No se pudo verificar. Revise su conexión e intente nuevamente.';
                });
            });
        } else {
            document.getElementById('sesion-aviso-ir').addEventListener('click', function () {
                window.location.href = (tipo === 'otro_usuario') ? cfg.inicio : cfg.login;
            });
        }
    }

    // ---------------------------------------------------------------- API
    function verificar() {
        return pedir(true).then(function (d) {
            var p = problema(d);
            if (p) { mostrarPerdida(p); return false; }
            return true;
        }).catch(function () { return true; });   // sin respuesta: el servidor decidirá al guardar
    }

    function iniciar(opciones) {
        opciones = opciones || {};
        for (var k in opciones) {
            if (Object.prototype.hasOwnProperty.call(opciones, k)) cfg[k] = opciones[k];
        }
        cfg.limiteServidor = parseInt(cfg.limiteServidor, 10) || 0;

        ['mousemove', 'mousedown', 'keydown', 'wheel', 'touchstart', 'input', 'change'].forEach(function (ev) {
            document.addEventListener(ev, actividad, { capture: true, passive: true });
        });
        window.addEventListener('scroll', actividad, { passive: true });

        // al volver a la pestaña: es actividad y además se confirma que la sesión siga abierta
        document.addEventListener('visibilitychange', function () {
            if (!document.hidden && estado === 'normal') {
                ultimaRenovacion = 0;
                actividad();
            }
        });

        setInterval(revisar, 15000);
    }

    window.SesionAviso = { iniciar: iniciar, verificar: verificar };
})(window, document);
