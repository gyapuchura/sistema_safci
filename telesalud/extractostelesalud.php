<?php 
include("../cabf.php"); 
include("../inc.config.php"); 

// Blindaje de sesiones
$idusuario_ss = $_SESSION['idusuario_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss']; 
$gestion      = date("Y"); 

// =========================================================================
// FASE 1: PUENTE DE DATOS Y CAPTURA DE FILTROS EN CASCADA
// =========================================================================
$inicio       = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : date('Y-m-01');
$finalizacion = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : date('Y-m-t');

// Captura de variables para los combos anidados
$g_dep = isset($_GET['iddepartamento']) && $_GET['iddepartamento'] != '' ? $_GET['iddepartamento'] : 'null';
$g_mun = isset($_GET['idmunicipio']) && $_GET['idmunicipio'] != '' ? $_GET['idmunicipio'] : 'null';
$g_est = isset($_GET['idestablecimiento']) && $_GET['idestablecimiento'] != '' ? $_GET['idestablecimiento'] : 'null';
$g_med = isset($_GET['idusuario_medico']) && $_GET['idusuario_medico'] != '' ? $_GET['idusuario_medico'] : 'null';

// Extracción de Catálogos para la memoria caché del navegador (Mejora de rendimiento)
$deptos = []; $munis = []; $eess = []; $medicos = [];

$res_d = mysqli_query($link, "SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento != '10'");
if($res_d){ while($r = mysqli_fetch_array($res_d)) { $deptos[] = ['id'=>$r[0], 'nombre'=>mb_strtoupper(trim($r[1]))]; } }

$res_m = mysqli_query($link, "SELECT idmunicipio, municipio, iddepartamento FROM municipios");
if($res_m){ while($r = mysqli_fetch_array($res_m)) { $munis[] = ['id'=>$r[0], 'nombre'=>mb_strtoupper(trim($r[1])), 'idDepto'=>$r[2]]; } }

$res_e = mysqli_query($link, "SELECT idestablecimiento_salud, establecimiento_salud, idmunicipio FROM establecimiento_salud");
if($res_e){ while($r = mysqli_fetch_array($res_e)) { $eess[] = ['id'=>$r[0], 'nombre'=>mb_strtoupper(trim($r[1])), 'idMuni'=>$r[2]]; } }

$res_u = mysqli_query($link, "SELECT u.idusuario, n.nombre, n.paterno, n.materno FROM usuarios u INNER JOIN nombre n ON u.idnombre = n.idnombre WHERE u.condicion = 'ACTIVO'");
if($res_u){ while($r = mysqli_fetch_array($res_u)) { $medicos[] = ['id'=>$r[0], 'nombre'=>mb_strtoupper(trim($r[1]." ".$r[2]." ".$r[3]))]; } }
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
    
    <style>
        /* Diseño unificado: Barra de Filtros y Tarjetas Accionables */
        .barra-filtros { background-color: #f8f9fa; border: 1px solid #d1d3e2; border-radius: 6px; padding: 15px; margin-bottom: 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .filtros-dropdowns { display: flex; flex-wrap: wrap; justify-content: center; align-items: flex-end; gap: 15px; width: 100%; }
        .filtros-dropdowns > div { display: flex; flex-direction: column; gap: 5px; position: relative; }
        .barra-filtros input[list] { padding: 5px 8px; border-radius: 4px; border: 1px solid #d1d3e2; font-size: 12px; color: #333; outline: none; width: 220px; text-transform: uppercase; }
        
        .extract-card { transition: all 0.3s cubic-bezier(.25,.8,.25,1); border: none; border-radius: 15px; cursor: pointer; overflow: hidden; }
        .extract-card:hover { transform: translateY(-8px); box-shadow: 0 15px 25px rgba(0,0,0,0.15) !important; }
        .icon-circle { height: 90px; width: 90px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
        .card-btn { background: none; border: none; width: 100%; text-align: inherit; padding: 0; font: inherit; outline: none; }
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
                
                <div class="container-fluid mt-4">
                    
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
                            <i class="fas fa-file-excel text-success mr-2"></i> Generación de Extractos Especializados
                        </h1>
                    </div>

                    <!-- BARRA DE FILTROS EN CASCADA CON AUTO-RECARGA -->
                    <div class="barra-filtros">
                        <form id="form-filtros" method="GET" action="">
                            <div class="filtros-dropdowns">
                                <div>
                                    <label class="text-xs font-weight-bold text-gray-800">Fecha Inicio:</label>
                                    <input type="date" name="fecha_inicio" class="form-control form-control-sm" style="width: 130px;" value="<?php echo $inicio; ?>" onchange="document.getElementById('form-filtros').submit();">
                                </div>
                                <div>
                                    <label class="text-xs font-weight-bold text-gray-800">Fecha Fin:</label>
                                    <input type="date" name="fecha_fin" class="form-control form-control-sm" style="width: 130px;" value="<?php echo $finalizacion; ?>" onchange="document.getElementById('form-filtros').submit();">
                                </div>
                                
                                <div>
                                    <label class="text-xs font-weight-bold text-gray-800">Departamento:</label>
                                    <input list="dl-deptos" id="inp-depto" placeholder="- TODOS -" autocomplete="off">
                                    <input type="hidden" id="val-iddepartamento" name="iddepartamento" value="<?php echo $g_dep != 'null' ? $g_dep : ''; ?>">
                                    <datalist id="dl-deptos"></datalist>
                                </div>
                                <div>
                                    <label class="text-xs font-weight-bold text-gray-800">Municipio:</label>
                                    <input list="dl-munis" id="inp-muni" placeholder="- TODOS -" autocomplete="off">
                                    <input type="hidden" id="val-idmunicipio" name="idmunicipio" value="<?php echo $g_mun != 'null' ? $g_mun : ''; ?>">
                                    <datalist id="dl-munis"></datalist>
                                </div>
                                <div>
                                    <label class="text-xs font-weight-bold text-gray-800">Establecimiento:</label>
                                    <input list="dl-ests" id="inp-est" placeholder="- TODOS -" autocomplete="off">
                                    <input type="hidden" id="val-idestablecimiento" name="idestablecimiento" value="<?php echo $g_est != 'null' ? $g_est : ''; ?>">
                                    <datalist id="dl-ests"></datalist>
                                </div>
                                <div>
                                    <label class="text-xs font-weight-bold text-gray-800">Médico:</label>
                                    <input list="dl-meds" id="inp-med" placeholder="- TODOS -" autocomplete="off">
                                    <input type="hidden" id="val-idusuario_medico" name="idusuario_medico" value="<?php echo $g_med != 'null' ? $g_med : ''; ?>">
                                    <datalist id="dl-meds"></datalist>
                                </div>
                                
                                <div>
                                    <button type="button" class="btn btn-secondary btn-sm shadow-sm font-weight-bold" onclick="window.location.href='extractostelesalud.php'" style="padding: 6px 15px; height: 31px;" title="Limpiar Filtros">
                                        <i class="fas fa-eraser"></i> Limpiar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- PANELES DE DESCARGA -->
                    <div class="row justify-content-center">
                        
                        <!-- TARJETA 1: Teleinterconsultas -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <form action="../referencia_safci/reporte_referencias_excel.php" method="POST" target="_blank" style="margin: 0;">
                                <input type="hidden" name="inicio" value="<?php echo $inicio; ?>">
                                <input type="hidden" name="finalizacion" value="<?php echo $finalizacion; ?>">
                                <input type="hidden" name="iddepartamento" value="<?php echo $g_dep != 'null' ? $g_dep : ''; ?>">
                                <input type="hidden" name="idmunicipio" value="<?php echo $g_mun != 'null' ? $g_mun : ''; ?>">
                                <input type="hidden" name="idestablecimiento" value="<?php echo $g_est != 'null' ? $g_est : ''; ?>">
                                <input type="hidden" name="idusuario_medico" value="<?php echo $g_med != 'null' ? $g_med : ''; ?>">
                                
                                <button type="submit" class="card-btn">
                                    <div class="card shadow py-4 extract-card w-100 bg-white border-left-primary">
                                        <div class="card-body text-center">
                                            <div class="icon-circle bg-primary text-white shadow mb-3">
                                                <i class="fas fa-hospital-user fa-3x"></i>
                                            </div>
                                            <h5 class="font-weight-bold text-primary mb-2">Teleinterconsultas Generadas<br>y Efectivizadas</h5>
                                            <p class="text-muted mb-0 small">Exporta las Teleinterconsultas aplicando los filtros seleccionados arriba.</p>
                                        </div>
                                    </div>
                                </button>
                            </form>
                        </div>

                        <!-- TARJETA 2: Teleconsultas y Telemetrías -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <form action="../produccion_servicios/reporte_telesalud_excel.php" method="POST" target="_blank" style="margin: 0;">
                                <input type="hidden" name="inicio" value="<?php echo $inicio; ?>">
                                <input type="hidden" name="finalizacion" value="<?php echo $finalizacion; ?>">
                                <input type="hidden" name="iddepartamento" value="<?php echo $g_dep != 'null' ? $g_dep : ''; ?>">
                                <input type="hidden" name="idmunicipio" value="<?php echo $g_mun != 'null' ? $g_mun : ''; ?>">
                                <input type="hidden" name="idestablecimiento" value="<?php echo $g_est != 'null' ? $g_est : ''; ?>">
                                <input type="hidden" name="idusuario_medico" value="<?php echo $g_med != 'null' ? $g_med : ''; ?>">
                                
                                <button type="submit" class="card-btn">
                                    <div class="card shadow py-4 extract-card w-100 bg-white border-left-success">
                                        <div class="card-body text-center">
                                            <div class="icon-circle bg-success text-white shadow mb-3">
                                                <i class="fas fa-laptop-medical fa-3x"></i>
                                            </div>
                                            <h5 class="font-weight-bold text-success mb-2">Extracto Teleconsultas<br>y Telemetrías</h5>
                                            <p class="text-muted mb-0 small">Exporta las atenciones aplicando los filtros seleccionados.</p>
                                        </div>
                                    </div>
                                </button>
                            </form>
                        </div>

                        <!-- TARJETA 3: Matriz de Producción Global (Autodescarga) -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <form action="../produccion_servicios/atenciones_psafci_diarias_fechas_tele.php" method="GET" target="_blank" style="margin: 0;">
                                <input type="hidden" name="inicio" value="<?php echo $inicio; ?>">
                                <input type="hidden" name="finalizacion" value="<?php echo $finalizacion; ?>">
                                <input type="hidden" name="iddepartamento" value="<?php echo $g_dep != 'null' ? $g_dep : ''; ?>">
                                <input type="hidden" name="idmunicipio" value="<?php echo $g_mun != 'null' ? $g_mun : ''; ?>">
                                <input type="hidden" name="idestablecimiento" value="<?php echo $g_est != 'null' ? $g_est : ''; ?>">
                                <input type="hidden" name="idusuario_medico" value="<?php echo $g_med != 'null' ? $g_med : ''; ?>">
                                
                                <!-- EL PARÁMETRO MÁGICO DE AUTODESCARGA -->
                                <input type="hidden" name="autodescarga" value="1">
                                
                                <button type="submit" class="card-btn">
                                    <div class="card shadow py-4 extract-card w-100 bg-white border-left-warning">
                                        <div class="card-body text-center">
                                            <div class="icon-circle bg-warning text-white shadow mb-3">
                                                <i class="fas fa-table fa-3x"></i>
                                            </div>
                                            <h5 class="font-weight-bold text-warning mb-2">Matriz de Producción<br>Diaria Telesalud</h5>
                                            <p class="text-muted mb-0 small">Exportación de la producción diaria realizada por el médico de Telesalud en números absolutos.</p>
                                        </div>
                                    </div>
                                </button>
                            </form>
                        </div>

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

        const initDepto = <?php echo $g_dep != 'null' ? "'".$g_dep."'" : 'null'; ?>;
        const initMuni = <?php echo $g_mun != 'null' ? "'".$g_mun."'" : 'null'; ?>;
        const initEess = <?php echo $g_est != 'null' ? "'".$g_est."'" : 'null'; ?>;
        const initMed = <?php echo $g_med != 'null' ? "'".$g_med."'" : 'null'; ?>;

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