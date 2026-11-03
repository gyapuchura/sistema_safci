<?php
include("../cabf.php");
include("../inc.config.php");

// Bloque compartido de Telemedicina: filtros de la sesión, alcance del usuario (lugar por defecto y campos fijos) y estilos
include("inc_telemedicina.php");

// Blindaje de sesiones
$idusuario_ss = $_SESSION['idusuario_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$gestion      = date("Y");

// =========================================================================
// FASE 1: PUENTE DE DATOS Y CAPTURA DE FILTROS EN CASCADA
// =========================================================================
$inicio       = !empty($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : date('Y-m-01');
$finalizacion = !empty($_GET['fecha_fin']) ? $_GET['fecha_fin'] : date('Y-m-d');   // del 1 del mes a la fecha actual

// Captura de variables para los combos anidados
$g_dep = isset($_GET['iddepartamento']) && $_GET['iddepartamento'] != '' ? $_GET['iddepartamento'] : 'null';
$g_mun = isset($_GET['idmunicipio']) && $_GET['idmunicipio'] != '' ? $_GET['idmunicipio'] : 'null';
$g_est = isset($_GET['idestablecimiento']) && $_GET['idestablecimiento'] != '' ? $_GET['idestablecimiento'] : 'null';
$g_med = isset($_GET['idusuario_medico']) && $_GET['idusuario_medico'] != '' ? $_GET['idusuario_medico'] : 'null';

// Catálogos de los filtros, recortados al alcance del usuario (inc_telemedicina.php)
list($deptos, $munis, $eess, $medicos) = tm_catalogos($link);

// =========================================================================
// PRESENTACIÓN
// =========================================================================
$h = function ($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); };
$f_corta = function ($f) { $t = strtotime($f); return $t ? date('d/m/Y', $t) : $f; };
$texto_periodo = $f_corta($inicio) . ' – ' . $f_corta($finalizacion);

// Filtros que viajan a cada reporte (mismos nombres y valores que antes)
$campos_filtro = [
    'inicio'            => $inicio,
    'finalizacion'      => $finalizacion,
    'iddepartamento'    => $g_dep != 'null' ? $g_dep : '',
    'idmunicipio'       => $g_mun != 'null' ? $g_mun : '',
    'idestablecimiento' => $g_est != 'null' ? $g_est : '',
    'idusuario_medico'  => $g_med != 'null' ? $g_med : '',
];

// Tarjetas de descarga: título, descripción, destino, método, ícono, color (paleta SB Admin 2), campos extra,
// progreso (true = el servidor entrega el archivo y la página muestra el avance de la descarga;
//           false = la página del reporte arma el Excel en el navegador y tiene su propia pantalla de carga)
$extractos = [
    ['Teleinterconsultas', 'Generadas y efectivizadas', 'Exporta las teleinterconsultas aplicando los filtros seleccionados.',
        '../referencia_safci/reporte_referencias_excel.php', 'POST', 'fa-hospital-user', '#4e73df', [], true],
    ['Teleconsultas y telemetrías', 'Atenciones', 'Exporta las atenciones aplicando los filtros seleccionados.',
        '../produccion_servicios/reporte_telesalud_excel.php', 'POST', 'fa-laptop-medical', '#1cc88a', [], true],
    ['Matriz de producción', 'Diaria de Telesalud', 'Producción diaria realizada por el médico de Telesalud, en números absolutos.',
        '../produccion_servicios/atenciones_psafci_diarias_fechas_tele.php', 'GET', 'fa-table', '#fd7e14', ['autodescarga' => '1'], false],
    ['Teleeducación', 'Telecapacitación y telepromoción', 'Resumen por tipo y el detalle de cada sesión con sus participantes por grupo y género, aplicando los filtros seleccionados (el médico es quien registró la sesión).',
        'reporte_teleeducacion_excel.php', 'POST', 'fa-graduation-cap', '#36b9cc', [], true],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SISTEMA MEDI-SAFCI - Extractos Telesalud</title>

    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <?php tm_estilos(); ?>
    <style>
        /* Tarjetas de descarga (vidrio), una por reporte */
        .px .grid-3 { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--gap); }
        @media (max-width: 1599.98px) { .px .grid-3 { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        .px .extracto { margin: 0; height: 100%; }
        .px .extracto .card-p { text-align: left; width: 100%; border: 1px solid var(--borde); font: inherit; cursor: pointer; gap: 14px; }
        .px .extracto .card-p:focus-visible { outline: 3px solid rgba(var(--p-rgb), .35); outline-offset: 2px; }
        .px .extracto .ico-ext { width: 58px; height: 58px; border-radius: 18px; display: inline-flex; align-items: center; justify-content: center; font-size: 24px;
            background: rgba(var(--cc-rgb), .12); color: var(--cc); box-shadow: inset 0 0 0 1px rgba(var(--cc-rgb), .18); }
        .px .extracto .tipo { display: block; font-size: 12px; font-weight: 500; color: var(--n-700); letter-spacing: .2px; }
        .px .extracto .titulo-ext { display: block; font-size: 20px; font-weight: 500; color: var(--p-osc); margin-top: 2px; }
        .px .extracto .desc { display: block; font-size: 13px; color: var(--n-700); flex: 1; }
        .px .extracto .descargar { display: inline-flex; align-items: center; gap: 8px; align-self: flex-start; padding: 9px 18px; border-radius: 999px;
            font-size: 13px; font-weight: 500; background: var(--cc-btn); color: var(--cc-btn-txt); transition: transform var(--t), box-shadow var(--t); }
        .px .extracto .card-p:hover .descargar { transform: translateX(3px); box-shadow: 0 6px 16px rgba(var(--cc-rgb), .35); }
        .px .nota-ext { display: flex; align-items: flex-start; gap: 8px; font-size: 12px; color: var(--n-700); margin-top: var(--gap); }
        .px .nota-ext i { color: var(--p); margin-top: 2px; }
        @media (max-width: 767.98px) { .px .grid-3 { grid-template-columns: minmax(0, 1fr); } }

        /* Tarjeta mientras se genera su reporte */
        .px .extracto.descargando .card-p { cursor: progress; opacity: .75; }
        .px .extracto.descargando .descargar i { animation: tmGiro .9s linear infinite; }

        /* Panel de avance de la descarga (vidrio, abajo a la derecha) */
        .px .descarga-panel { position: fixed; right: 24px; bottom: 24px; z-index: 1050; width: 360px; max-width: calc(100vw - 32px); padding: 16px 18px 14px;
            border-radius: var(--radio); background: rgba(255, 255, 255, .94); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--borde); box-shadow: 0 24px 50px -20px rgba(var(--p-rgb), .55), inset 0 1px 0 rgba(255, 255, 255, .95); animation: pxAparece .35s cubic-bezier(.2, .8, .2, 1) both; }
        .px .descarga-panel[hidden] { display: none; }
        .px .descarga-panel .dp-cab { display: flex; align-items: center; gap: 12px; }
        .px .descarga-panel .dp-ico { width: 40px; height: 40px; border-radius: 13px; display: inline-flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0;
            background: rgba(var(--ok-rgb), .14); color: #13855c; }
        .px .descarga-panel .dp-ico.error { background: rgba(var(--err-rgb), .12); color: var(--err-osc); }
        .px .descarga-panel .dp-txt { flex: 1; min-width: 0; }
        .px .descarga-panel .dp-txt b { display: block; font-size: 14px; font-weight: 500; color: var(--n-900); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .px .descarga-panel .dp-txt small { display: block; font-size: 12px; color: var(--n-700); }
        .px .descarga-panel .dp-cerrar { width: 30px; height: 30px; border-radius: 50%; border: 0; background: rgba(var(--p-rgb), .07); color: var(--n-700); cursor: pointer; flex-shrink: 0; }
        .px .descarga-panel .dp-cerrar:hover { background: rgba(var(--err-rgb), .12); color: var(--err-osc); }
        .px .descarga-panel .dp-barra { height: 8px; border-radius: 8px; background: rgba(var(--p-rgb), .1); overflow: hidden; margin: 14px 0 8px; }
        .px .descarga-panel .dp-barra span { display: block; height: 100%; width: 0; border-radius: 8px; background: linear-gradient(90deg, var(--acc), var(--p)); transition: width .3s ease; }
        .px .descarga-panel .dp-barra.indeterminada span { width: 35%; animation: dpVaiven 1.3s ease-in-out infinite; }
        .px .descarga-panel .dp-barra.listo span { background: var(--ok); }
        .px .descarga-panel .dp-barra.error span { background: var(--err); width: 100%; }
        .px .descarga-panel .dp-pie { display: flex; justify-content: space-between; font-size: 12px; color: var(--n-700); }
        @keyframes dpVaiven { 0% { transform: translateX(-100%); } 100% { transform: translateX(290%); } }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include("../menu.php"); ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <?php include("../top_bar.php"); ?>

                <div class="container-fluid mt-4 px">
                    <?php tm_cargador('Cargando extractos'); // indicador de carga al ir a otra página ?>

                    <!-- ===================== ENCABEZADO ===================== -->
                    <div class="encabezado aparece">
                        <div>
                            <h1>Extractos</h1>
                            <div class="meta">
                                <span><i class="far fa-calendar-alt mr-1"></i><?php echo $h($texto_periodo); ?></span>
                                <span><i class="fas fa-file-excel mr-1"></i>Reportes especializados de Telesalud en Excel</span>
                            </div>
                        </div>
                    </div>

                    <!-- ===================== FILTROS EN CASCADA CON AUTO-RECARGA (mismos campos e IDs) ===================== -->
                    <div class="barra-filtros filtros vidrio aparece">
                        <form id="form-filtros" method="GET" action="">
                            <div class="filtros-dropdowns">
                                <div>
                                    <label>Fecha inicio</label>
                                    <input type="date" name="fecha_inicio" value="<?php echo $h($inicio); ?>" onchange="document.getElementById('form-filtros').submit();">
                                </div>
                                <div>
                                    <label>Fecha fin</label>
                                    <input type="date" name="fecha_fin" value="<?php echo $h($finalizacion); ?>" onchange="document.getElementById('form-filtros').submit();">
                                </div>
                                <div>
                                    <label>Departamento<?php echo tm_candado('iddepartamento'); ?></label>
                                    <input list="dl-deptos" id="inp-depto" placeholder="- TODOS -" autocomplete="off"<?php echo tm_bloqueo('iddepartamento'); ?>>
                                    <input type="hidden" id="val-iddepartamento" name="iddepartamento" value="<?php echo $h($campos_filtro['iddepartamento']); ?>">
                                    <datalist id="dl-deptos"></datalist>
                                </div>
                                <div>
                                    <label>Municipio<?php echo tm_candado('idmunicipio'); ?></label>
                                    <input list="dl-munis" id="inp-muni" placeholder="- TODOS -" autocomplete="off"<?php echo tm_bloqueo('idmunicipio'); ?>>
                                    <input type="hidden" id="val-idmunicipio" name="idmunicipio" value="<?php echo $h($campos_filtro['idmunicipio']); ?>">
                                    <datalist id="dl-munis"></datalist>
                                </div>
                                <div>
                                    <label>Establecimiento</label>
                                    <input list="dl-ests" id="inp-est" placeholder="- TODOS -" autocomplete="off">
                                    <input type="hidden" id="val-idestablecimiento" name="idestablecimiento" value="<?php echo $h($campos_filtro['idestablecimiento']); ?>">
                                    <datalist id="dl-ests"></datalist>
                                </div>
                                <div>
                                    <label>Médico</label>
                                    <input list="dl-meds" id="inp-med" placeholder="- TODOS -" autocomplete="off">
                                    <input type="hidden" id="val-idusuario_medico" name="idusuario_medico" value="<?php echo $h($campos_filtro['idusuario_medico']); ?>">
                                    <datalist id="dl-meds"></datalist>
                                </div>
                                <div>
                                    <button type="button" class="btn-limpiar" onclick="window.location.href='<?php echo $h(tm_url_limpiar('extractostelesalud.php')); ?>'" title="Limpiar filtros (también en las demás pestañas)"><i class="fas fa-eraser mr-1"></i> Limpiar</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- ===================== PANELES DE DESCARGA ===================== -->
                    <div class="grid-3">
                        <?php foreach ($extractos as $i => $x) {
                            list($fondo_btn, $texto_btn) = tm_colores_legibles($x[6]); // botón con contraste AA
                            $rgb = hexdec(substr($x[6], 1, 2)) . ', ' . hexdec(substr($x[6], 3, 2)) . ', ' . hexdec(substr($x[6], 5, 2)); ?>
                        <form class="extracto aparece" action="<?php echo $h($x[3]); ?>" method="<?php echo $x[4]; ?>" target="_blank" data-titulo="<?php echo $h($x[0]); ?>" data-progreso="<?php echo $x[8] ? '1' : '0'; ?>"
                              style="--cc: <?php echo $x[6]; ?>; --cc-rgb: <?php echo $rgb; ?>; --cc-btn: <?php echo $fondo_btn; ?>; --cc-btn-txt: <?php echo $texto_btn; ?>; animation-delay: <?php echo .05 * ($i + 1); ?>s;">
                            <?php foreach ($campos_filtro + $x[7] as $nombre => $valor) { ?>
                                <input type="hidden" name="<?php echo $h($nombre); ?>" value="<?php echo $h($valor); ?>">
                            <?php } ?>
                            <button type="submit" class="vidrio card-p">
                                <span class="ico-ext"><i class="fas <?php echo $x[5]; ?>" aria-hidden="true"></i></span>
                                <span>
                                    <span class="tipo"><?php echo $h($x[1]); ?></span>
                                    <span class="titulo-ext"><?php echo $h($x[0]); ?></span>
                                </span>
                                <span class="desc"><?php echo $h($x[2]); ?></span>
                                <span class="descargar"><i class="fas fa-download" aria-hidden="true"></i> Descargar Excel</span>
                            </button>
                        </form>
                        <?php } ?>
                    </div>

                    <div class="nota-ext"><i class="fas fa-info-circle"></i><span>Cada reporte se genera con el periodo y los filtros seleccionados arriba. El avance de la descarga se muestra abajo a la derecha; la matriz de producción se abre en una pestaña nueva.</span></div>

                    <!-- Avance de la descarga (fuera de las tarjetas de vidrio para quedar fijo en pantalla) -->
                    <div class="descarga-panel" id="descarga-panel" role="status" aria-live="polite" hidden>
                        <div class="dp-cab">
                            <span class="dp-ico" id="dp-ico"><i class="fas fa-file-excel"></i></span>
                            <div class="dp-txt"><b id="dp-titulo"></b><small id="dp-estado"></small></div>
                            <button type="button" class="dp-cerrar" id="dp-cancelar" title="Cancelar la descarga" aria-label="Cancelar la descarga"><i class="fas fa-times"></i></button>
                        </div>
                        <div class="dp-barra indeterminada" id="dp-barra"><span id="dp-relleno"></span></div>
                        <div class="dp-pie"><span id="dp-detalle"></span><span id="dp-tiempo">0:00</span></div>
                    </div>

                </div>
            </div>

            <footer class="sticky-footer bg-white mt-auto">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Ministerio de Salud y Deportes © MSYD <?php echo $gestion; ?></span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Scripts Core -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- SCRIPT: MOTOR DE FILTROS EN CASCADA CON AUTO-RECARGA -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const dbDeptos = <?php echo json_encode($deptos, JSON_UNESCAPED_UNICODE); ?>;
        const dbMunis = <?php echo json_encode($munis, JSON_UNESCAPED_UNICODE); ?>;
        const dbEess = <?php echo json_encode($eess, JSON_UNESCAPED_UNICODE); ?>;
        const dbMeds = <?php echo json_encode($medicos, JSON_UNESCAPED_UNICODE); ?>;

        const initDepto = <?php echo $g_dep != 'null' ? json_encode((string)$g_dep) : 'null'; ?>;
        const initMuni = <?php echo $g_mun != 'null' ? json_encode((string)$g_mun) : 'null'; ?>;
        const initEess = <?php echo $g_est != 'null' ? json_encode((string)$g_est) : 'null'; ?>;
        const initMed = <?php echo $g_med != 'null' ? json_encode((string)$g_med) : 'null'; ?>;

        function poblarLista(datalistId, arrayData) {
            let html = '';
            arrayData.forEach(item => { html += `<option data-id="${item.id}" value="${item.nombre}"></option>`; });
            document.getElementById(datalistId).innerHTML = html;
        }

        // 1. Inicializamos las listas disponibles
        poblarLista('dl-deptos', dbDeptos);
        poblarLista('dl-meds', dbMeds);

        // 2. Comportamiento en Cascada guiado por la BD
        if(initDepto) {
            const dObj = dbDeptos.find(d => d.id == initDepto);
            if(dObj) document.getElementById('inp-depto').value = dObj.nombre;
            poblarLista('dl-munis', dbMunis.filter(m => m.idDepto == initDepto));
        } else { poblarLista('dl-munis', dbMunis); }

        if(initMuni) {
            const mObj = dbMunis.find(m => m.id == initMuni);
            if(mObj) document.getElementById('inp-muni').value = mObj.nombre;
            poblarLista('dl-ests', dbEess.filter(e => e.idMuni == initMuni));
        } else { poblarLista('dl-ests', dbEess); }

        if(initEess) {
            const eObj = dbEess.find(e => e.id == initEess);
            if(eObj) document.getElementById('inp-est').value = eObj.nombre;
        }

        if(initMed) {
            const medObj = dbMeds.find(u => u.id == initMed);
            if(medObj) document.getElementById('inp-med').value = medObj.nombre;
        }

        // 3. FUNCIÓN MÁGICA: Auto-recarga instantánea al seleccionar
        function aplicarFiltro(inputId, hiddenId, arrayData) {
            document.getElementById(inputId).addEventListener('change', function() {
                const val = this.value.trim().toUpperCase();
                const obj = arrayData.find(item => item.nombre.toUpperCase() === val);
                const hiddenInput = document.getElementById(hiddenId);

                if (obj) {
                    hiddenInput.value = obj.id;
                    document.getElementById('form-filtros').submit();
                } else if (val === "") {
                    hiddenInput.value = "";
                    document.getElementById('form-filtros').submit();
                }
            });
        }

        aplicarFiltro('inp-depto', 'val-iddepartamento', dbDeptos);
        aplicarFiltro('inp-muni', 'val-idmunicipio', dbMunis);
        aplicarFiltro('inp-est', 'val-idestablecimiento', dbEess);
        aplicarFiltro('inp-med', 'val-idusuario_medico', dbMeds);

        // =========================================================================
        // DESCARGA CON AVANCE: el reporte se pide en segundo plano y el panel muestra
        //   1. "Preparando el reporte": el servidor consulta y arma el archivo (con el tiempo transcurrido)
        //   2. "Descargando": lo recibido en KB/MB (y el porcentaje si el servidor informa el tamaño)
        //   3. "Listo": el archivo se guarda con su nombre original
        // Navegadores antiguos (sin fetch/streams): la descarga normal de siempre en una pestaña nueva.
        // =========================================================================
        if (!window.fetch || !window.AbortController || !window.Blob || !window.URL || !URL.createObjectURL) { return; }

        const panel = document.getElementById('descarga-panel');
        const el = function (id) { return document.getElementById(id); };
        let activa = null, reloj = null, ocultar = null;

        const tamano = function (b) { return b < 1048576 ? Math.max(1, Math.round(b / 1024)) + ' KB' : (b / 1048576).toFixed(1) + ' MB'; };
        const minutos = function (s) { const m = Math.floor(s / 60), r = s % 60; return m + ':' + (r < 10 ? '0' : '') + r; };

        function mostrar(titulo) {
            clearTimeout(ocultar);
            el('dp-titulo').textContent = titulo;
            el('dp-ico').className = 'dp-ico';
            el('dp-ico').innerHTML = '<i class="fas fa-file-excel"></i>';
            el('dp-cancelar').hidden = false;
            panel.hidden = false;
        }
        function estado(texto, detalle, porcentaje, clase) {
            el('dp-estado').textContent = texto;
            el('dp-detalle').textContent = detalle || '';
            el('dp-barra').className = 'dp-barra' + (clase ? ' ' + clase : (porcentaje === null ? ' indeterminada' : ''));
            el('dp-relleno').style.width = porcentaje === null ? '' : porcentaje + '%';
        }
        function terminar(form) {
            clearInterval(reloj);
            form.classList.remove('descargando');
            el('dp-cancelar').hidden = true;
            activa = null;
            ocultar = setTimeout(function () { panel.hidden = true; }, 6000);
        }

        el('dp-cancelar').addEventListener('click', function () { if (activa) { activa.abort(); } else { panel.hidden = true; } });

        document.querySelectorAll('form.extracto[data-progreso="1"]').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                if (activa) { return; }   // una descarga a la vez
                const ctrl = new AbortController();
                const inicio = Date.now();
                activa = ctrl;
                form.classList.add('descargando');
                mostrar(form.getAttribute('data-titulo'));
                estado('Preparando el reporte en el servidor…', 'Consultando la información', null);
                el('dp-tiempo').textContent = '0:00';
                reloj = setInterval(function () { el('dp-tiempo').textContent = minutos(Math.floor((Date.now() - inicio) / 1000)); }, 1000);

                fetch(form.action, { method: 'POST', body: new FormData(form), credentials: 'same-origin', signal: ctrl.signal })
                    .then(function (resp) {
                        const disp = resp.headers.get('Content-Disposition') || '';
                        // Sin archivo adjunto: la sesión expiró (respondió la pantalla de ingreso) o hubo un error
                        if (!resp.ok) { throw new Error('HTTP ' + resp.status); }
                        if (disp.indexOf('attachment') === -1) { throw new Error('sesion'); }
                        const nombre = ((disp.match(/filename="?([^";]+)"?/) || [])[1] || 'reporte.xls').trim();
                        const tipo = resp.headers.get('Content-Type') || 'application/vnd.ms-excel';
                        // Con compresión el tamaño informado no es el del archivo final: solo se muestra lo recibido
                        const total = resp.headers.get('Content-Encoding') ? 0 : parseInt(resp.headers.get('Content-Length') || '0', 10);
                        estado('Descargando…', 'Recibiendo el archivo', total ? 0 : null);
                        if (!resp.body || !resp.body.getReader) { return resp.blob().then(function (b) { return [b, nombre]; }); }
                        const lector = resp.body.getReader(), partes = [];
                        let recibido = 0;
                        const leer = function () {
                            return lector.read().then(function (r) {
                                if (r.done) { return [new Blob(partes, { type: tipo }), nombre]; }
                                partes.push(r.value);
                                recibido += r.value.length;
                                if (total) { estado('Descargando…', tamano(recibido) + ' de ' + tamano(total), Math.min(100, Math.round(recibido / total * 100))); }
                                else { el('dp-detalle').textContent = tamano(recibido) + ' recibidos'; }
                                return leer();
                            });
                        };
                        return leer();
                    })
                    .then(function (res) {
                        // Se guarda el archivo con el nombre que envía el servidor
                        const url = URL.createObjectURL(res[0]);
                        const a = document.createElement('a');
                        a.href = url; a.download = res[1]; a.style.display = 'none';
                        document.body.appendChild(a); a.click(); a.remove();
                        setTimeout(function () { URL.revokeObjectURL(url); }, 60000);
                        el('dp-ico').innerHTML = '<i class="fas fa-check"></i>';
                        estado('Descarga completa', res[1] + ' · ' + tamano(res[0].size), 100, 'listo');
                    })
                    .catch(function (err) {
                        el('dp-ico').className = 'dp-ico error';
                        el('dp-ico').innerHTML = '<i class="fas fa-exclamation"></i>';
                        if (err.name === 'AbortError') { estado('Descarga cancelada', '', 100, 'error'); }
                        else if (err.message === 'sesion') { estado('Su sesión expiró', 'Vuelva a ingresar al sistema y repita la descarga', 100, 'error'); }
                        else { estado('No se pudo generar el reporte', 'Intente nuevamente en unos minutos', 100, 'error'); }
                    })
                    .then(function () { terminar(form); });
            });
        });
    });
    </script>
</body>
</html>
