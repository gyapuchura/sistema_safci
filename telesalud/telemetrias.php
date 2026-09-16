<?php 
// 1. Iniciar conexión y sesión nativa
include("../cabf.php"); 
include("../inc.config.php"); 

// 2. Blindaje de sesiones para evitar errores en menu.php y top_bar.php
$idusuario_ss = $_SESSION['idusuario_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss']; 
$gestion      = date("Y"); 

// =========================================================================
// FASE 1: PUENTE DE DATOS Y CAPTURA DE FILTROS
// =========================================================================
$inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : date('Y-m-01');
$finalizacion = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : date('Y-m-t');

$g_dep = isset($_GET['iddepartamento']) && $_GET['iddepartamento'] != '' ? $_GET['iddepartamento'] : '';
$g_mun = isset($_GET['idmunicipio']) && $_GET['idmunicipio'] != '' ? $_GET['idmunicipio'] : '';
$g_est = isset($_GET['idestablecimiento']) && $_GET['idestablecimiento'] != '' ? $_GET['idestablecimiento'] : '';
$g_med = isset($_GET['idusuario_medico']) && $_GET['idusuario_medico'] != '' ? $_GET['idusuario_medico'] : '';

$filtro_extra = "";
if ($g_dep != '') { $filtro_extra .= " AND a.iddepartamento = '" . mysqli_real_escape_string($link, $g_dep) . "' "; }
if ($g_mun != '') { $filtro_extra .= " AND a.idmunicipio = '" . mysqli_real_escape_string($link, $g_mun) . "' "; }
if ($g_est != '') { $filtro_extra .= " AND a.idestablecimiento_salud = '" . mysqli_real_escape_string($link, $g_est) . "' "; }
if ($g_med != '') { $filtro_extra .= " AND a.idusuario = '" . mysqli_real_escape_string($link, $g_med) . "' "; }

// Catálogos para los selectores (Filtros en JSON)
$deptos = []; $munis = []; $eess = []; $medicos = [];

$res_d = mysqli_query($link, "SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento != '10'");
if($res_d){ while($r = mysqli_fetch_array($res_d)) { $deptos[] = ['id'=>$r[0], 'nombre'=>mb_strtoupper(trim($r[1]))]; } }

$res_m = mysqli_query($link, "SELECT idmunicipio, municipio, iddepartamento FROM municipios");
if($res_m){ while($r = mysqli_fetch_array($res_m)) { $munis[] = ['id'=>$r[0], 'nombre'=>mb_strtoupper(trim($r[1])), 'idDepto'=>$r[2]]; } }

$res_e = mysqli_query($link, "SELECT idestablecimiento_salud, establecimiento_salud, idmunicipio FROM establecimiento_salud");
if($res_e){ while($r = mysqli_fetch_array($res_e)) { $eess[] = ['id'=>$r[0], 'nombre'=>mb_strtoupper(trim($r[1])), 'idMuni'=>$r[2]]; } }

$res_u = mysqli_query($link, "SELECT u.idusuario, n.nombre, n.paterno, n.materno FROM usuarios u INNER JOIN nombre n ON u.idnombre = n.idnombre WHERE u.condicion = 'ACTIVO'");
if($res_u){ while($r = mysqli_fetch_array($res_u)) { $medicos[] = ['id'=>$r[0], 'nombre'=>mb_strtoupper(trim($r[1]." ".$r[2]." ".$r[3]))]; } }

// =========================================================================
// ⚙️ MOTOR DE DATOS: CONSULTAS OPTIMIZADAS (SOLO TELEMETRÍA idtipo_atencion = '4')
// =========================================================================

// A) KPIs Maestros (Edad Promedio)
$sql_kpi = "SELECT ROUND(AVG(TIMESTAMPDIFF(YEAR, n.fecha_nac, a.fecha_registro)), 1) as edad_media
    FROM atencion_psafci a INNER JOIN nombre n ON a.idnombre = n.idnombre
    WHERE a.idtipo_atencion = '4' AND a.fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND n.fecha_nac != '0000-00-00' $filtro_extra ";
$res_kpi = mysqli_query($link, $sql_kpi);
$row_kpi = mysqli_fetch_array($res_kpi);
$edad_promedio = $row_kpi['edad_media'] ? $row_kpi['edad_media'] : 0;

// B) KPI Total Telemetrías Realizadas (Conteo estricto de equipos válidos)
$sql_tot_tm = "SELECT COUNT(et.idexamen_teleconsulta) AS total 
    FROM examen_teleconsulta et 
    INNER JOIN atencion_psafci a ON et.idatencion_psafci = a.idatencion_psafci 
    INNER JOIN examen_complementario ec ON et.idexamen_complementario = ec.idexamen_complementario 
    WHERE a.idtipo_atencion = '4' AND a.fecha_registro BETWEEN '$inicio' AND '$finalizacion' 
    AND ec.idexamen_complementario != '6' 
    AND UPPER(ec.examen_complementario) NOT LIKE '%MONITOR DE SIGNOS VITALES%' 
    AND UPPER(ec.examen_complementario) NOT LIKE '%ESTETOSCOPIO%' 
    AND UPPER(ec.examen_complementario) NOT LIKE '%OTRO%' $filtro_extra";
$res_tot_tm = mysqli_query($link, $sql_tot_tm);
$row_tot_tm = mysqli_fetch_array($res_tot_tm);
$total_telemetrias = $row_tot_tm['total'] ? $row_tot_tm['total'] : 0;

// C) Dona: Nuevo vs Seguimiento
$arr_rep = [];
$sql_rep = "SELECT a.idrepeticion, COUNT(*) as cantidad FROM atencion_psafci a
    WHERE a.idtipo_atencion = '4' AND a.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_extra GROUP BY a.idrepeticion";
$res_rep = mysqli_query($link, $sql_rep);
while ($row_r = mysqli_fetch_array($res_rep)) {
    $nombre_rep = ($row_r['idrepeticion'] == '1') ? 'Nuevo' : 'Seguimiento';
    $arr_rep[] = ['name' => $nombre_rep, 'y' => (int)$row_r['cantidad']];
}

// D) Gráfico de Barras: Equipos Biomédicos (Orden DESC Puro)
$cat_vias = []; $data_vias = []; $via_principal = "S/D";
$sql_vias = "SELECT ec.examen_complementario, COUNT(et.idexamen_teleconsulta) as cantidad FROM atencion_psafci a
    INNER JOIN examen_teleconsulta et ON a.idatencion_psafci = et.idatencion_psafci
    INNER JOIN examen_complementario ec ON et.idexamen_complementario = ec.idexamen_complementario
    WHERE a.idtipo_atencion = '4' AND a.fecha_registro BETWEEN '$inicio' AND '$finalizacion' 
    AND ec.idexamen_complementario != '6' 
    AND UPPER(ec.examen_complementario) NOT LIKE '%MONITOR DE SIGNOS VITALES%'
    AND UPPER(ec.examen_complementario) NOT LIKE '%ESTETOSCOPIO%'
    AND UPPER(ec.examen_complementario) NOT LIKE '%OTRO%' $filtro_extra
    GROUP BY ec.examen_complementario ORDER BY cantidad DESC";
$res_vias = mysqli_query($link, $sql_vias);
$isFirst = true;
while ($row_v = mysqli_fetch_array($res_vias)) {
    $nombre_via = ucwords(mb_strtolower($row_v['examen_complementario']));
    if($isFirst) { $via_principal = $nombre_via; $isFirst = false; } 
    $cat_vias[] = $nombre_via;
    $data_vias[] = (int)$row_v['cantidad'];
}

// E) Grupos Vulnerables
$arr_vul = [];
$sql_vul = "SELECT gv.grupo_vulnerable, COUNT(agv.idatencion_grupo_vulnerable) as total FROM atencion_psafci a
    INNER JOIN atencion_grupo_vulnerable agv ON a.idatencion_psafci = agv.idatencion_psafci
    INNER JOIN grupo_vulnerable gv ON agv.idgrupo_vulnerable = gv.idgrupo_vulnerable
    WHERE a.idtipo_atencion = '4' AND a.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_extra
    GROUP BY gv.idgrupo_vulnerable";
$res_vul = mysqli_query($link, $sql_vul);
while($row_v = mysqli_fetch_array($res_vul)){
    $arr_vul[] = ['name' => mb_strtoupper($row_v['grupo_vulnerable']), 'y' => (int)$row_v['total']];
}

// F) Top 10 Diagnósticos CIE-10 (Orden DESC Puro)
$cat_diag = []; $data_diag = [];
$sql_diag = "SELECT p.patologia, p.cie, COUNT(dt.iddiagnostico_teleconsulta) as total FROM atencion_psafci a
    INNER JOIN diagnostico_teleconsulta dt ON a.idatencion_psafci = dt.idatencion_psafci
    INNER JOIN patologia p ON dt.idpatologia = p.idpatologia
    WHERE a.idtipo_atencion = '4' AND a.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_extra
    GROUP BY p.idpatologia ORDER BY total DESC LIMIT 10"; 
$res_diag = mysqli_query($link, $sql_diag);
while($row_d = mysqli_fetch_array($res_diag)){
    $cat_diag[] = $row_d['cie']." - ".$row_d['patologia'];
    $data_diag[] = (int)$row_d['total'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SISTEMA MEDI-SAFCI - Analítica Telemetría</title>
    
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    
    <style>
        .barra-filtros { background-color: #f8f9fa; border: 1px solid #d1d3e2; border-radius: 6px; padding: 15px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .filtros-dropdowns { display: flex; flex-wrap: wrap; justify-content: center; align-items: flex-end; gap: 15px; width: 100%; }
        .filtros-dropdowns > div { display: flex; flex-direction: column; gap: 5px; position: relative; }
        .barra-filtros input[list] { padding: 5px 8px; border-radius: 4px; border: 1px solid #d1d3e2; font-size: 12px; color: #333; outline: none; width: 180px; text-transform: uppercase; }
        .kpi-card { transition: transform 0.2s; border-radius: 10px; border-left: 5px solid; }
        .kpi-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    </style>
</head>

<body id="page-top">
<div id="wrapper">
    <!-- Sidebar -->
    <?php include("../menu.php");?>
    
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <!-- Topbar -->
            <?php include("../top_bar.php"); ?>
            
            <div class="container-fluid mt-4">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-heartbeat text-primary"></i> Analítica de Telemetrías</h1>
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
                                <input type="hidden" id="val-iddepartamento" name="iddepartamento" value="<?php echo $g_dep; ?>">
                                <datalist id="dl-deptos"></datalist>
                            </div>
                            <div>
                                <label class="text-xs font-weight-bold text-gray-800">Municipio:</label>
                                <input list="dl-munis" id="inp-muni" placeholder="- TODOS -" autocomplete="off">
                                <input type="hidden" id="val-idmunicipio" name="idmunicipio" value="<?php echo $g_mun; ?>">
                                <datalist id="dl-munis"></datalist>
                            </div>
                            <div>
                                <label class="text-xs font-weight-bold text-gray-800">Establecimiento:</label>
                                <input list="dl-ests" id="inp-est" placeholder="- TODOS -" autocomplete="off">
                                <input type="hidden" id="val-idestablecimiento" name="idestablecimiento" value="<?php echo $g_est; ?>">
                                <datalist id="dl-ests"></datalist>
                            </div>
                            <div>
                                <label class="text-xs font-weight-bold text-gray-800">Médico:</label>
                                <input list="dl-meds" id="inp-med" placeholder="- TODOS -" autocomplete="off">
                                <input type="hidden" id="val-idusuario_medico" name="idusuario_medico" value="<?php echo $g_med; ?>">
                                <datalist id="dl-meds"></datalist>
                            </div>
                            
                            <div>
                                <button type="button" class="btn btn-secondary btn-sm shadow-sm font-weight-bold" onclick="window.location.href='telemetrias.php'" style="padding: 6px 15px; height: 31px;" title="Limpiar Filtros">
                                    <i class="fas fa-eraser"></i> Limpiar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- FILA 1: TARJETAS KPI -->
                <div class="row">
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-primary kpi-card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Telemetrías</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800 contador-animado" data-objetivo="<?php echo $total_telemetrias; ?>">0</div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-laptop-medical fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-success kpi-card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Promedio de Edad</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><span class="contador-animado" data-objetivo="<?php echo $edad_promedio; ?>">0</span> Años</div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-user-clock fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-info kpi-card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Dispositivo Top</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $via_principal; ?></div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-microchip fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FILA 2: DISTRIBUCIÓN CLÍNICA Y DISPOSITIVOS (3 Columnas Simétricas) -->
                <div class="row mt-2">
                    <!-- Dona 1: Tipo de Paciente -->
                    <div class="col-xl-4 mb-4">
                        <div class="card shadow h-100">
                            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-success" style="font-size:13px;"><i class="fas fa-user-plus"></i> Tipo de Paciente</h6></div>
                            <div class="card-body" id="donut-paciente" style="height: 350px;"></div>
                        </div>
                    </div>
                    
                    <!-- Pie 2: Grupos Vulnerables -->
                    <div class="col-xl-4 mb-4">
                        <div class="card shadow h-100">
                            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-warning" style="font-size:13px;"><i class="fas fa-hands-helping"></i> Grupos Vulnerables</h6></div>
                            <div class="card-body" id="pie-vulnerables" style="height: 350px;"></div>
                        </div>
                    </div>

                    <!-- Barras: Dispositivos (Ranking) -->
                    <div class="col-xl-4 mb-4">
                        <div class="card shadow h-100">
                            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-dark" style="font-size:13px;"><i class="fas fa-heartbeat text-primary"></i> Ranking Dispositivos Usados</h6></div>
                            <div class="card-body" id="bar-vias" style="height: 350px;"></div>
                        </div>
                    </div>
                </div>

                <!-- FILA 3: PERFIL EPIDEMIOLÓGICO CENTRALIZADO -->
                <div class="row mt-2">
                    <div class="col-xl-12 mb-4">
                        <div class="card shadow h-100">
                            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-danger"><i class="fas fa-virus"></i> Top 10 Diagnósticos (CIE-10)</h6></div>
                            <div class="card-body" id="bar-diagnosticos" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div> 
        
        <footer class="sticky-footer bg-white mt-auto">
            <div class="container my-auto">
                <div class="copyright text-center my-auto"><span>Ministerio de Salud y Deportes © MSYD <?php echo $gestion; ?></span></div>
            </div>
        </footer>
    </div>
</div>

<a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

<!-- Scripts Core -->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../js/sb-admin-2.min.js"></script>
<script src="../js/telesalud_js/highcharts-10.3.3.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    
    // ANIMACIÓN DE NÚMEROS
    const contadores = document.querySelectorAll('.contador-animado');
    const velocidad = 40; 
    contadores.forEach(contador => {
        const actualizarConteo = () => {
            const objetivo = parseFloat(contador.getAttribute('data-objetivo'));
            const conteoActual = parseFloat(contador.innerText.replace(/,/g, ''));
            const incremento = objetivo / velocidad;

            if (conteoActual < objetivo) {
                let nuevoValor = conteoActual + incremento;
                contador.innerText = Number.isInteger(objetivo) ? Math.ceil(nuevoValor).toLocaleString('en-US') : nuevoValor.toFixed(1);
                setTimeout(actualizarConteo, 20);
            } else {
                contador.innerText = Number.isInteger(objetivo) ? objetivo.toLocaleString('en-US') : objetivo.toFixed(1);
            }
        };
        if(parseFloat(contador.getAttribute('data-objetivo')) > 0) actualizarConteo();
    });

    // CONFIGURACIÓN HIGHCHARTS
    Highcharts.setOptions({
        colors: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#6f42c1', '#fd7e14'],
        plotOptions: {
            pie: { innerSize: '60%', allowPointSelect: true, cursor: 'pointer', dataLabels: { enabled: true, distance: -25, format: '{point.percentage:.0f}%', style: { color: 'white', textOutline: 'none', fontSize: '11px' } }, showInLegend: true }
        },
        tooltip: { pointFormat: '<b>{point.y} Registros ({point.percentage:.1f}%)</b>' },
        credits: { enabled: false }, title: { text: null }
    });

    // RENDERIZAR DONA Y PIE
    Highcharts.chart('donut-paciente', { chart: { type: 'pie' }, series: [{ name: 'Paciente', colorByPoint: true, data: <?php echo json_encode(empty($arr_rep) ? [['name'=>'Sin datos', 'y'=>0]] : $arr_rep, JSON_UNESCAPED_UNICODE); ?> }] });
    
    Highcharts.chart('pie-vulnerables', {
        chart: { type: 'pie' },
        plotOptions: { pie: { innerSize: '0%', dataLabels: { distance: -15, style: { color: 'white', textOutline: 'none' } } } },
        series: [{ name: 'Pacientes', colorByPoint: true, data: <?php echo json_encode(empty($arr_vul) ? [['name'=>'Ninguno/Sin Datos', 'y'=>0]] : $arr_vul, JSON_UNESCAPED_UNICODE); ?> }]
    });

    // BARRAS ILUSTRADAS (DISPOSITIVOS ORDENADOS DE MAYOR A MENOR)
    const catVias = <?php echo json_encode($cat_vias, JSON_UNESCAPED_UNICODE); ?>;
    const getIconoDispositivo = (n) => {
        n = n.toLowerCase();
        if (n.includes('camara') || n.includes('cámara')) return '<i class="fas fa-camera" style="color: #36b9cc; font-size:16px;"></i>';
        if (n.includes('gluco') || n.includes('glucó')) return '<i class="fas fa-tint" style="color: #e74a3b; font-size:16px;"></i>';
        if (n.includes('eco') || n.includes('ultra')) return '<i class="fas fa-desktop" style="color: #4e73df; font-size:16px;"></i>';
        if (n.includes('multipara') || n.includes('materno')) return '<i class="fas fa-tv" style="color: #f6c23e; font-size:16px;"></i>';
        if (n.includes('electro')) return '<i class="fas fa-heartbeat" style="color: #e74a3b; font-size:16px;"></i>';
        if (n.includes('oftal') || n.includes('otos') || n.includes('video')) return '<i class="fas fa-eye" style="color: #1cc88a; font-size:16px;"></i>';
        return '<i class="fas fa-microchip" style="color: #858796; font-size:16px;"></i>';
    };
    
    Highcharts.chart('bar-vias', {
        chart: { type: 'bar' },
        xAxis: { 
            categories: catVias, 
            labels: { 
                useHTML: true, 
                style: { fontSize: '10px' }, 
                formatter: function() { return getIconoDispositivo(this.value) + ' <span style="margin-left:5px;">' + this.value + '</span>'; } 
            } 
        },
        yAxis: { min: 0, title: { text: null } },
        tooltip: { pointFormat: '<b>{point.y} Veces</b>' },
        plotOptions: { bar: { borderRadius: 3, colorByPoint: true, dataLabels: { enabled: true, style: { fontWeight: 'bold', fontSize: '10px' } } } },
        series: [{ name: 'Dispositivo', data: <?php echo json_encode($data_vias); ?> }]
    });

    // TOP 10 DIAGNÓSTICOS (ORDENADOS DE MAYOR A MENOR)
    Highcharts.chart('bar-diagnosticos', {
        chart: { type: 'bar' },
        xAxis: { categories: <?php echo json_encode(empty($cat_diag) ? ['Sin Diagnósticos'] : $cat_diag, JSON_UNESCAPED_UNICODE); ?>, title: { text: null } },
        yAxis: { min: 0, title: { text: 'N° de Casos' } },
        tooltip: { pointFormat: '<b>{point.y} Casos Diagnosticados</b>' },
        plotOptions: { bar: { borderRadius: 3, dataLabels: { enabled: true }, color: '#e74a3b' } },
        series: [{ name: 'Diagnósticos', data: <?php echo json_encode(empty($data_diag) ? [0] : $data_diag); ?> }]
    });
});
</script>

<!-- SCRIPT DEL MOTOR DE FILTROS EN CASCADA CON AUTO-RECARGA -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const dbDeptos = <?php echo json_encode($deptos, JSON_UNESCAPED_UNICODE); ?>;
    const dbMunis = <?php echo json_encode($munis, JSON_UNESCAPED_UNICODE); ?>;
    const dbEess = <?php echo json_encode($eess, JSON_UNESCAPED_UNICODE); ?>;
    const dbMeds = <?php echo json_encode($medicos, JSON_UNESCAPED_UNICODE); ?>;

    const initDepto = <?php echo $g_dep != '' ? "'".$g_dep."'" : 'null'; ?>;
    const initMuni = <?php echo $g_mun != '' ? "'".$g_mun."'" : 'null'; ?>;
    const initEess = <?php echo $g_est != '' ? "'".$g_est."'" : 'null'; ?>;
    const initMed = <?php echo $g_med != '' ? "'".$g_med."'" : 'null'; ?>;

    function poblarLista(datalistId, arrayData) {
        let html = '';
        arrayData.forEach(item => { html += `<option data-id="${item.id}" value="${item.nombre}"></option>`; });
        document.getElementById(datalistId).innerHTML = html;
    }

    // Inicializamos listas maestras
    poblarLista('dl-deptos', dbDeptos);
    poblarLista('dl-meds', dbMeds);

    // Precargamos si ya hay filtro
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

    // Listener mágico para enviar el formulario automáticamente al hacer clic en una opción
    function aplicarFiltro(inputId, hiddenId, arrayData) {
        document.getElementById(inputId).addEventListener('change', function() {
            const val = this.value.trim().toUpperCase();
            const obj = arrayData.find(item => item.nombre.toUpperCase() === val);
            const hiddenInput = document.getElementById(hiddenId);
            
            if (obj) {
                hiddenInput.value = obj.id;
                document.getElementById('form-filtros').submit(); // Recarga automática
            } else if (val === "") {
                hiddenInput.value = "";
                document.getElementById('form-filtros').submit(); // Limpia y recarga
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