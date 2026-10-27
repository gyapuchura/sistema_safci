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
$finalizacion = !empty($_GET['fecha_fin']) ? $_GET['fecha_fin'] : date('Y-m-t');

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

// Tarjetas de descarga: título, descripción, destino, método, ícono, color (paleta SB Admin 2), campos extra
$extractos = [
    ['Teleinterconsultas', 'Generadas y efectivizadas', 'Exporta las teleinterconsultas aplicando los filtros seleccionados.',
        '../referencia_safci/reporte_referencias_excel.php', 'POST', 'fa-hospital-user', '#4e73df', []],
    ['Teleconsultas y telemetrías', 'Atenciones', 'Exporta las atenciones aplicando los filtros seleccionados.',
        '../produccion_servicios/reporte_telesalud_excel.php', 'POST', 'fa-laptop-medical', '#1cc88a', []],
    ['Matriz de producción', 'Diaria de Telesalud', 'Producción diaria realizada por el médico de Telesalud, en números absolutos.',
        '../produccion_servicios/atenciones_psafci_diarias_fechas_tele.php', 'GET', 'fa-table', '#fd7e14', ['autodescarga' => '1']],
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
        .px .grid-3 { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--gap); }
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
        @media (max-width: 1199.98px) { .px .grid-3 { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media (max-width: 767.98px) { .px .grid-3 { grid-template-columns: minmax(0, 1fr); } }
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
                        <form class="extracto aparece" action="<?php echo $h($x[3]); ?>" method="<?php echo $x[4]; ?>" target="_blank"
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

                    <div class="nota-ext"><i class="fas fa-info-circle"></i><span>Cada reporte se abre en una pestaña nueva con el periodo y los filtros seleccionados arriba.</span></div>

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
    });
    </script>
</body>
</html>
