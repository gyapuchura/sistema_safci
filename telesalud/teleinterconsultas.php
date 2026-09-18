<?php 
include("../cabf.php"); 
include("../inc.config.php"); 

// Blindaje de sesiones para evitar errores en menu.php y top_bar.php
$idusuario_ss = $_SESSION['idusuario_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss']; 
$gestion      = date("Y"); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SISTEMA MEDI-SAFCI - Centro de Mando Teleinterconsultas Generadas</title>
    
    <!-- Fuentes y Estilos nativos de tu sistema -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    
    <style>
        .barra-filtros { background-color: #f8f9fa; border: 1px solid #d1d3e2; border-radius: 6px; padding: 15px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .kpi-card { transition: transform 0.2s; border-radius: 10px; border-left: 5px solid; }
        .kpi-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .border-generadas { border-left-color: #f6c23e; } /* Warning */
        .border-efectivas { border-left-color: #1cc88a; } /* Success */
        .border-rechazadas { border-left-color: #e74a3b; } /* Danger */
        .border-tasa { border-left-color: #4e73df; } /* Primary */
        .barra-filtros { background-color: #f8f9fa; border: 1px solid #d1d3e2; border-radius: 6px; padding: 15px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .barra-filtros { background-color: #f8f9fa; border: 1px solid #d1d3e2; border-radius: 6px; padding: 15px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .filtros-dropdowns { display: flex; flex-wrap: wrap; justify-content: center; align-items: flex-end; gap: 15px; width: 100%; }
        .filtros-dropdowns > div { display: flex; flex-direction: column; gap: 5px; position: relative; }
        .barra-filtros input[list] { padding: 5px 8px; border-radius: 4px; border: 1px solid #d1d3e2; font-size: 12px; color: #333; outline: none; width: 220px; text-transform: uppercase; }
        .kpi-card { transition: transform 0.2s; border-radius: 10px; border-left: 5px solid; }
        .kpi-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .border-generadas { border-left-color: #f6c23e; }
        .border-efectivas { border-left-color: #1cc88a; }
        .border-rechazadas { border-left-color: #e74a3b; }
        .border-tasa { border-left-color: #4e73df; }
        .border-total { border-left-color: #36b9cc; } /* Info / Celeste */
    </style>

    <?php
    // =========================================================================
    // FASE 1: PUENTE DE DATOS EN MEMORIA (CATÁLOGOS JSON)
    // =========================================================================
    $deptos = []; $munis = []; $eess = []; $medicos = [];
    
    $res_d = mysqli_query($link, "SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento != '10'");
    if($res_d){ while($r = mysqli_fetch_array($res_d)) { $deptos[] = ['id'=>$r[0], 'nombre'=>mb_strtoupper(trim($r[1]))]; } }

    $res_m = mysqli_query($link, "SELECT idmunicipio, municipio, iddepartamento FROM municipios");
    if($res_m){ while($r = mysqli_fetch_array($res_m)) { $munis[] = ['id'=>$r[0], 'nombre'=>mb_strtoupper(trim($r[1])), 'idDepto'=>$r[2]]; } }

    $res_e = mysqli_query($link, "SELECT idestablecimiento_salud, establecimiento_salud, idmunicipio FROM establecimiento_salud");
    if($res_e){ while($r = mysqli_fetch_array($res_e)) { $eess[] = ['id'=>$r[0], 'nombre'=>mb_strtoupper(trim($r[1])), 'idMuni'=>$r[2]]; } }

    $res_u = mysqli_query($link, "SELECT u.idusuario, n.nombre, n.paterno, n.materno FROM usuarios u INNER JOIN nombre n ON u.idnombre = n.idnombre WHERE u.condicion = 'ACTIVO'");
    if($res_u){ while($r = mysqli_fetch_array($res_u)) { $medicos[] = ['id'=>$r[0], 'nombre'=>mb_strtoupper(trim($r[1]." ".$r[2]." ".$r[3]))]; } }

    // Captura de variables iniciales
    $g_dep = isset($_GET['iddepartamento']) && $_GET['iddepartamento'] != '' ? $_GET['iddepartamento'] : 'null';
    $g_mun = isset($_GET['idmunicipio']) && $_GET['idmunicipio'] != '' ? $_GET['idmunicipio'] : 'null';
    $g_est = isset($_GET['idestablecimiento']) && $_GET['idestablecimiento'] != '' ? $_GET['idestablecimiento'] : 'null';
    $g_med = isset($_GET['idusuario_medico']) && $_GET['idusuario_medico'] != '' ? $_GET['idusuario_medico'] : 'null';
    ?>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        
        <!-- Sidebar -->
        <?php include("../menu.php"); ?>
        
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            
            <!-- Main Content -->
            <div id="content">
                
                <!-- Topbar -->
                <?php include("../top_bar.php"); ?>
                
                <!-- Begin Page Content -->
                <div class="container-fluid mt-4">
                    
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-network-wired text-primary"></i> Centro de Mando: Teleinterconsultas Generadas</h1>
                    </div>

                    <!-- BARRA DE FILTROS EN CASCADA CON AUTO-RECARGA -->
                    <div class="barra-filtros">
                        <form id="form-filtros" method="GET" action="">
                            <div class="filtros-dropdowns">
                                <div>
                                    <label class="text-xs font-weight-bold text-gray-800">Fecha Inicio:</label>
                                    <input type="date" name="fecha_inicio" class="form-control form-control-sm" style="width: 130px;" value="<?php echo isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : date('Y-m-01'); ?>" onchange="document.getElementById('form-filtros').submit();">
                                </div>
                                <div>
                                    <label class="text-xs font-weight-bold text-gray-800">Fecha Fin:</label>
                                    <input type="date" name="fecha_fin" class="form-control form-control-sm" style="width: 130px;" value="<?php echo isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : date('Y-m-t'); ?>" onchange="document.getElementById('form-filtros').submit();">
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
                                    <button type="button" class="btn btn-secondary btn-sm shadow-sm font-weight-bold" onclick="window.location.href='teleinterconsultas.php'" style="padding: 6px 15px; height: 31px;" title="Limpiar Filtros">
                                        <i class="fas fa-eraser"></i> Limpiar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php
                    // =========================================================================
                    // FASE 2: EXTRACCIÓN MAESTRA DE DATOS (MITIGACIÓN N+1)
                    // =========================================================================
                    // 1. Recepción de Fechas del Filtro (o defecto al mes actual)
                    $inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : date('Y-m-01');
                    $finalizacion = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : date('Y-m-t');
                    
                    // FASE 3: ACUMULADOR DE FILTROS EN CASCADA
                    // Usamos la variable $filtro_depto para no romper las consultas maestras que ya hicimos abajo
                    $filtro_depto = "";
                    if (isset($_GET['iddepartamento']) && $_GET['iddepartamento'] != '') {
                        $filtro_depto .= " AND r.iddepartamento = '" . mysqli_real_escape_string($link, $_GET['iddepartamento']) . "'";
                    }
                    if (isset($_GET['idmunicipio']) && $_GET['idmunicipio'] != '') {
                        $filtro_depto .= " AND r.idmunicipio = '" . mysqli_real_escape_string($link, $_GET['idmunicipio']) . "'";
                    }
                    if (isset($_GET['idestablecimiento']) && $_GET['idestablecimiento'] != '') {
                        $filtro_depto .= " AND r.idestablecimiento_salud = '" . mysqli_real_escape_string($link, $_GET['idestablecimiento']) . "'";
                    }
                    if (isset($_GET['idusuario_medico']) && $_GET['idusuario_medico'] != '') {
                        $filtro_depto .= " AND r.idusuario = '" . mysqli_real_escape_string($link, $_GET['idusuario_medico']) . "'";
                    }

                    // 2. Consulta 1: Totales para KPI y Gráfico de Dona (Estado de Referencias)
                    // Ajustado estrictamente al flujo clínico: 
                    // Generadas = Estado 1 (Pendientes)
                    // Efectivizadas = Estado 2 (Contrarreferidas) + SI Admitidas
                    // Rechazadas = Estado 2 (Contrarreferidas) + NO Admitidas
                    
                    $sql_estados = "
                        SELECT 
                            (SELECT COUNT(r.idreferencia_hc) FROM referencia_hc r WHERE r.idestado_referencia = '1' AND r.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_depto) as generadas,
                            (SELECT COUNT(DISTINCT r.idreferencia_hc) FROM referencia_hc r INNER JOIN deriva_referencia_hc d ON r.idreferencia_hc = d.idreferencia_hc WHERE r.idestado_referencia = '2' AND d.admitido = 'SI' AND r.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_depto) as efectivizadas,
                            (SELECT COUNT(DISTINCT r.idreferencia_hc) FROM referencia_hc r INNER JOIN deriva_referencia_hc d ON r.idreferencia_hc = d.idreferencia_hc WHERE r.idestado_referencia = '2' AND d.admitido = 'NO' AND r.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_depto) as rechazadas
                    ";
                    $res_estados = mysqli_query($link, $sql_estados);
                    $total_generadas = 0; $total_efectivizadas = 0; $total_rechazadas = 0;
                    
                    if ($res_estados && $row_est = mysqli_fetch_assoc($res_estados)) {
                        $total_generadas = (int)$row_est['generadas'];
                        $total_efectivizadas = (int)$row_est['efectivizadas'];
                        $total_rechazadas = (int)$row_est['rechazadas'];
                    }
                    
                    /// El Universo Bruto: Suma TODO lo que el médico intentó
                    $total_absoluto = $total_generadas + $total_efectivizadas + $total_rechazadas;
                    
                    // La tasa de efectividad (Éxitos vs Total Intentado)
                    $tasa_efectividad = ($total_absoluto > 0) ? round(($total_efectivizadas / $total_absoluto) * 100, 1) : 0;

                    // 3. Consulta 2: Motor Geo-Espacial (Flujo Origen -> Destino)
                    // Extraemos el departamento de origen y el departamento del establecimiento receptor
                    $sql_mapa = "
                        SELECT 
                            d_origen.departamento as depto_origen,
                            d_destino.departamento as depto_destino,
                            COUNT(r.idreferencia_hc) as volumen
                        FROM referencia_hc r
                        INNER JOIN departamento d_origen ON r.iddepartamento = d_origen.iddepartamento
                        INNER JOIN establecimiento_salud e_receptor ON r.idestablecimiento_receptor = e_receptor.idestablecimiento_salud
                        INNER JOIN departamento d_destino ON e_receptor.iddepartamento = d_destino.iddepartamento
                        WHERE r.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_depto
                        GROUP BY d_origen.departamento, d_destino.departamento
                    ";
                    $res_mapa = mysqli_query($link, $sql_mapa);
                    
                    $datos_flujo_mapa = [];
                    if ($res_mapa) {
                        while ($rm = mysqli_fetch_assoc($res_mapa)) {
                            // Limpieza estricta de tildes para sincronizar con el mapa JS
                            $origen = str_replace(['Á','É','Í','Ó','Ú'], ['A','E','I','O','U'], mb_strtoupper(trim($rm['depto_origen'])));
                            $destino = str_replace(['Á','É','Í','Ó','Ú'], ['A','E','I','O','U'], mb_strtoupper(trim($rm['depto_destino'])));
                            
                            $datos_flujo_mapa[] = [
                                'origen' => $origen,
                                'destino' => $destino,
                                'peso' => (int)$rm['volumen']
                            ];
                        }
                    }
                    ?>

                    <!-- TARJETAS KPI (ODÓMETROS) -->
                    <div class="row">
                        <!-- 1. TOTAL GENERADAS (El Universo Bruto) -->
                        <div class="col-xl col-lg-4 col-md-6 mb-4">
                            <div class="card kpi-card shadow h-100 py-2" style="border-left-color: #6c757d;">
                                <div class="card-body px-2">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-1">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="font-size: 10.5px; color: #6c757d;">Total Generadas</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 contador-animado" data-objetivo="<?php echo $total_absoluto; ?>">0</div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-layer-group fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. T. EN ESPERA (Pendientes Estado 1) -->
                        <div class="col-xl col-md-6 mb-4">
                            <div class="card kpi-card border-generadas shadow h-100 py-2">
                                <div class="card-body px-2">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-1">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="font-size: 10.5px;">Por admitir</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 contador-animado" data-objetivo="<?php echo $total_generadas; ?>">0</div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-clock fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. T. EFECTIVIZADAS (Admitidas Estado 2) -->
                        <div class="col-xl col-md-6 mb-4">
                            <div class="card kpi-card border-efectivas shadow h-100 py-2">
                                <div class="card-body px-2">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-1">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="font-size: 10.5px;">T. Efectivizadas</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 contador-animado" data-objetivo="<?php echo $total_efectivizadas; ?>">0</div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-check-double fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. T. RECHAZADAS (No Admitidas Estado 2) -->
                        <div class="col-xl col-md-6 mb-4">
                            <div class="card kpi-card border-rechazadas shadow h-100 py-2">
                                <div class="card-body px-2">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-1">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1" style="font-size: 10.5px;">No Admitidas</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 contador-animado" data-objetivo="<?php echo $total_rechazadas; ?>">0</div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-ban fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 5. TASA DE EFECTIVIDAD -->
                        <div class="col-xl col-md-6 mb-4">
                            <div class="card kpi-card border-tasa shadow h-100 py-2">
                                <div class="card-body px-2">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-1">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="font-size: 10.5px;">Tasa Efectividad</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><span class="contador-animado" data-objetivo="<?php echo $tasa_efectividad; ?>">0</span>%</div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-chart-line fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ESPACIO RESERVADO FASE 2: MAPA Y TORTAS -->
                    <div class="row">
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Mapa de Flujo (Origen - Destino)</h6>
                                </div>
                                <div class="card-body" id="contenedor-mapa" style="height: 500px; display: flex; align-items: center; justify-content: center; background: radial-gradient(circle at center, #ffffff 0%, #f8f9fc 100%); border-radius: 0 0 0.35rem 0.35rem;">
                                    <span class="text-muted"><i class="fas fa-map-marker-alt"></i> Cargando Motor geoespacial...</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Estado Global</h6>
                                </div>
                                <div class="card-body" id="contenedor-torta" style="height: 500px; display: flex; align-items: center; justify-content: center;">
                                    <span class="text-muted">Gráfico de Dona pendiente...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- FASE 3: PERFIL EPIDEMIOLÓGICO -->
                    <?php
                    // Top 10 Patologías de Origen (Buscando en diagnostico_presuntivo)
                    $sql_top_origen = "
                        SELECT p.patologia, COUNT(dp.iddiagnostico_presuntivo) as total
                        FROM diagnostico_presuntivo dp
                        INNER JOIN referencia_hc r ON dp.idreferencia_hc = r.idreferencia_hc
                        INNER JOIN patologia p ON dp.idpatologia = p.idpatologia
                        WHERE r.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_depto
                        GROUP BY p.patologia
                        ORDER BY total DESC LIMIT 10
                    ";
                    $res_top_origen = mysqli_query($link, $sql_top_origen);
                    $cat_origen = []; $data_origen = [];
                    if($res_top_origen){
                        while($row = mysqli_fetch_assoc($res_top_origen)){
                            $cat_origen[] = mb_strtoupper(trim($row['patologia']));
                            $data_origen[] = (int)$row['total'];
                        }
                    }

                    // 4. Consulta 3: Resolución y Modalidad (Solo Efectivizadas)
                    // CORRECCIÓN BLINDADA: Soporta datos heredados ('SI'/'NO') y datos nuevos ('1'/'2')
                    $sql_resolucion = "
                        SELECT 
                            SUM(CASE WHEN r.atencion_sitio IN ('1', 'SI') THEN 1 ELSE 0 END) as en_sitio,
                            SUM(CASE WHEN r.atencion_sitio IN ('2', 'NO') THEN 1 ELSE 0 END) as referencia,
                            SUM(CASE WHEN r.idtiempo_ts = '1' THEN 1 ELSE 0 END) as tiempo_real,
                            SUM(CASE WHEN r.idtiempo_ts = '2' THEN 1 ELSE 0 END) as tiempo_diferido
                        FROM referencia_hc r
                        INNER JOIN deriva_referencia_hc d ON r.idreferencia_hc = d.idreferencia_hc
                        WHERE r.idestado_referencia = '2' AND d.admitido = 'SI'
                        AND r.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_depto
                    ";
                    $res_res = mysqli_query($link, $sql_resolucion);
                    $tot_en_sitio = 0; $tot_referencia = 0; $tot_tiempo_real = 0; $tot_tiempo_diferido = 0;
                    
                    if ($res_res && $row_res = mysqli_fetch_assoc($res_res)) {
                        $tot_en_sitio = (int)$row_res['en_sitio'];
                        $tot_referencia = (int)$row_res['referencia'];
                        $tot_tiempo_real = (int)$row_res['tiempo_real'];
                        $tot_tiempo_diferido = (int)$row_res['tiempo_diferido'];
                    }
                    // 5. Consulta 4: Nuevo/Seguimiento y Tipo de Teleinterconsulta
                    $sql_extra = "
                        SELECT 
                            SUM(CASE WHEN a.idrepeticion = '1' THEN 1 ELSE 0 END) as nuevo,
                            SUM(CASE WHEN a.idrepeticion = '2' THEN 1 ELSE 0 END) as seguimiento,
                            SUM(CASE WHEN r.idtipo_teleinterconsulta = '1' THEN 1 ELSE 0 END) as t_diag,
                            SUM(CASE WHEN r.idtipo_teleinterconsulta = '2' THEN 1 ELSE 0 END) as t_disc,
                            SUM(CASE WHEN r.idtipo_teleinterconsulta = '3' THEN 1 ELSE 0 END) as t_emer
                        FROM referencia_hc r
                        LEFT JOIN atencion_psafci a ON r.idatencion_psafci = a.idatencion_psafci
                        WHERE r.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_depto
                    ";
                    $res_ex = mysqli_query($link, $sql_extra);
                    $tot_nuevo = 0; $tot_seguimiento = 0; $tot_diag = 0; $tot_disc = 0; $tot_emer = 0;
                    if ($res_ex && $row_ex = mysqli_fetch_assoc($res_ex)) {
                        $tot_nuevo = (int)$row_ex['nuevo'];
                        $tot_seguimiento = (int)$row_ex['seguimiento'];
                        $tot_diag = (int)$row_ex['t_diag'];
                        $tot_disc = (int)$row_ex['t_disc'];
                        $tot_emer = (int)$row_ex['t_emer'];
                    }

                    // 6. Consulta 5: Ranking de Especialidades Solicitadas
                    $sql_top_esp = "
                        SELECT e.especialidad_medica, COUNT(r.idreferencia_hc) as total
                        FROM referencia_hc r
                        INNER JOIN especialidad_medica e ON r.idespecialidad_medica = e.idespecialidad_medica
                        WHERE r.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_depto
                        GROUP BY e.especialidad_medica
                        ORDER BY total DESC LIMIT 10
                    ";
                    $res_top_esp = mysqli_query($link, $sql_top_esp);
                    $cat_esp = []; $data_esp = [];
                    if($res_top_esp){
                        while($row_esp = mysqli_fetch_assoc($res_top_esp)){
                            $cat_esp[] = mb_strtoupper(trim($row_esp['especialidad_medica']));
                            $data_esp[] = (int)$row_esp['total'];
                        }
                    }
                    ?>
                    
                    <!-- FILA INTERMEDIA: 4 GRÁFICOS CIRCULARES -->
                    <div class="row mt-4">
                        <div class="col-xl-3 col-lg-6 mb-4">
                            <div class="card shadow h-100">
                                <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-info" style="font-size:13px;"><i class="fas fa-stethoscope"></i> Resolución</h6></div>
                                <div class="card-body" id="donut-resolucion" style="height: 300px;"></div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 mb-4">
                            <div class="card shadow h-100">
                                <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary" style="font-size:13px;"><i class="fas fa-network-wired"></i> Modalidad</h6></div>
                                <div class="card-body" id="torta-modalidad" style="height: 300px;"></div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 mb-4">
                            <div class="card shadow h-100">
                                <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-success" style="font-size:13px;"><i class="fas fa-user-plus"></i> Tipo de Paciente</h6></div>
                                <div class="card-body" id="donut-paciente" style="height: 300px;"></div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 mb-4">
                            <div class="card shadow h-100">
                                <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-warning" style="font-size:13px;"><i class="fas fa-laptop-medical"></i> Tipo Teleinterconsulta</h6></div>
                                <div class="card-body" id="torta-tipo" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- FASE 4: DIAGNÓSTICOS (ORIGEN) Y ESPECIALIDADES COMPARTEN FILA -->
                    <div class="row mt-4" id="contenedor-epidemiologico">
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow mb-4 h-100">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-warning">Top 10 Diagnósticos (Origen / Sospecha)</h6>
                                </div>
                                <div class="card-body" id="grafico-origen" style="height: 400px;"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow mb-4 h-100">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-dark"><i class="fas fa-star text-warning"></i> Top 10 Especialidades Solicitadas</h6>
                                </div>
                                <div class="card-body" id="grafico-especialidades" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>
            
            <!-- Footer -->
            <footer class="sticky-footer bg-white mt-auto">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Ministerio de Salud y Deportes © MSYD <?php echo $gestion; ?></span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scripts Core -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Animación KPI -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
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
            actualizarConteo();
        });
    });
    </script>
    <!-- 1. LIBRERÍAS (SIEMPRE ANTES DEL SCRIPT DE LÓGICA) -->
    <!-- Highcharts Core & Maps (RUTAS CDN EXACTAS PARA VERSIÓN 11.3.0) -->
    <script src="../js/telesalud_js/highcharts-11.3.0.js"></script>
    <script src="../js/telesalud_js/map-11.3.0.js"></script>
    <script src="../js/telesalud_js/flowmap-11.3.0.js"></script> 
    <script src="../js/telesalud_js/bo-all.js"></script>

    <!-- 2. RENDERIZADO VISUAL FASE 2 -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // ====================================================================
        // 1. GRÁFICO DE DONA (ESTADOS DE TELEINTERCONSULTAS)
        // ====================================================================
        const dataGeneradas = <?php echo (int)$total_generadas; ?>;
        const dataEfectivas = <?php echo (int)$total_efectivizadas; ?>;
        const dataRechazadas = <?php echo (int)$total_rechazadas; ?>;

        Highcharts.chart('contenedor-torta', {
            chart: { type: 'pie' },
            title: { text: null },
            tooltip: { pointFormat: '{series.name}: <b>{point.y} ({point.percentage:.1f}%)</b>' },
            plotOptions: {
                pie: {
                    innerSize: '60%',
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: { enabled: true, format: '<b>{point.name}</b>: {point.percentage:.1f} %' }
                }
            },
            credits: { enabled: false },
            series: [{
                name: 'Interconsultas',
                colorByPoint: true,
                data: [
                    { name: 'Generadas (En espera de respuesta)', y: dataGeneradas, color: '#f6c23e' },
                    { name: 'Efectivizadas (Respondidas)', y: dataEfectivas, color: '#1cc88a' },
                    { name: 'No Admitidas (Rechazadas)', y: dataRechazadas, color: '#e74a3b' }
                ]
            }]
        });

        // ====================================================================
        // 2. HIGHMAPS: MOTOR GEOESPACIAL 100% NATIVO (SIN PUNTOS NI PROJ4)
        // ====================================================================
        try {
            const flujoData = <?php echo json_encode(isset($datos_flujo_mapa) ? $datos_flujo_mapa : []); ?>;
            
            const dicDeptos = {
                'BENI':       { id: 1, hcKey: 'bo-eb', nombre: 'El Beni' },
                'COCHABAMBA': { id: 2, hcKey: 'bo-cb', nombre: 'Cochabamba' },
                'CHUQUISACA': { id: 3, hcKey: 'bo-cq', nombre: 'Chuquisaca' },
                'LA PAZ':     { id: 4, hcKey: 'bo-lp', nombre: 'La Paz' },
                'ORURO':      { id: 5, hcKey: 'bo-or', nombre: 'Oruro' },
                'PANDO':      { id: 6, hcKey: 'bo-pa', nombre: 'Pando' },
                'POTOSI':     { id: 7, hcKey: 'bo-po', nombre: 'Potosí' },
                'SANTA CRUZ': { id: 8, hcKey: 'bo-sc', nombre: 'Santa Cruz' },
                'TARIJA':     { id: 9, hcKey: 'bo-tr', nombre: 'Tarija' }
            };

            let heatData = [];
            let mapLines = [];

            for (let depto in dicDeptos) {
                let totalCarga = 0;
                flujoData.forEach(f => {
                    if (f.origen === depto || f.destino === depto) totalCarga += f.peso;
                });
                
                heatData.push({ 
                    'hc-key': dicDeptos[depto].hcKey, 
                    id: dicDeptos[depto].hcKey,
                    name: dicDeptos[depto].nombre, 
                    value: totalCarga, 
                    idDepto: dicDeptos[depto].id 
                });
            }

            // 1. MODIFICACIÓN: Grosor fijo de "1" para todas las flechas
            flujoData.forEach(flujo => {
                if (dicDeptos[flujo.origen] && dicDeptos[flujo.destino] && flujo.origen !== flujo.destino) {
                    mapLines.push({ 
                        from: dicDeptos[flujo.origen].hcKey, 
                        to: dicDeptos[flujo.destino].hcKey, 
                        weight: 1, // Fuerzan la línea a ser delgada y uniforme
                        totalCasos: flujo.peso, // Resguardamos el valor real para el tooltip
                        origenNom: dicDeptos[flujo.origen].nombre,
                        destinoNom: dicDeptos[flujo.destino].nombre
                    });
                }
            });

            let seriesMapa = [
                { 
                    type: 'map', 
                    id: 'capa-base', 
                    name: 'Carga Térmica', 
                    allAreas: true, 
                    data: heatData, 
                    joinBy: ['hc-key', 'hc-key'], 
                    borderColor: '#ffffff', 
                    borderWidth: 1.5, 
                    states: { hover: { color: '#f6c23e' } }, 
                    showInLegend: false,
                    dataLabels: { enabled: true, format: '{point.name}', style: { fontSize: '10px', textOutline: '2px #ffffff', color: '#333' } }
                }
            ];

            // 2. MODIFICACIÓN: Reducción de la cabeza de la flecha y ancho base
            if (mapLines.length > 0) {
                seriesMapa.push({
                    type: 'flowmap', 
                    linkedTo: 'capa-base', 
                    name: 'Flujo de Derivación', 
                    data: mapLines,
                    color: '#e74a3b', 
                    fillOpacity: 0.85, 
                    width: 0.0, // Cuerpo más delgado
                    curveFactor: 0.35, 
                    markerEnd: { width: '10px', height: '10px' }, // Punta de flecha más fina
                    animation: { defer: 400, duration: 1800 }
                });
            }

            const contMapa = document.getElementById('contenedor-mapa');
            if (contMapa) {
                contMapa.innerHTML = '';
                Highcharts.mapChart('contenedor-mapa', {
                    chart: { map: 'countries/bo/bo-all', backgroundColor: 'transparent', style: { filter: 'drop-shadow(0px 15px 20px rgba(0,0,0,0.15))' } },
                    title: { text: null },
                    mapNavigation: { enabled: true, buttonOptions: { verticalAlign: 'bottom' } },
                    credits: { enabled: false },
                    colorAxis: { min: 0, minColor: '#e3f2fd', maxColor: '#2e59d9' },
                    plotOptions: {
                        series: {
                            cursor: 'pointer',
                            point: {
                                events: {
                                    click: function () {
                                        if(this.idDepto) {
                                            document.getElementById('inp-depto').value = this.name.toUpperCase();
                                            document.getElementById('val-iddepartamento').value = this.idDepto;
                                            document.getElementById('form-filtros').submit();
                                        }
                                    }
                                }
                            }
                        }
                    },
                    tooltip: {
                        useHTML: true,
                        formatter: function () {
                            if (this.series.name === 'Carga Térmica') return `<b>${this.point.name}</b><br>Volumen Global de Casos: <b>${this.point.value || 0}</b>`;
                            // 3. MODIFICACIÓN: El tooltip lee la nueva variable totalCasos
                            if (this.series.name === 'Flujo de Derivación') return `<b>Origen:</b> ${this.point.options.origenNom}<br><b>Destino:</b> ${this.point.options.destinoNom}<br><b>Total Referencias:</b> ${this.point.options.totalCasos}`;
                            return this.point.name;
                        }
                    },
                    series: seriesMapa
                });
            }
        } catch (error) {
            console.error("🔥 Error Atrapado en Motor Geoespacial:", error);
            document.getElementById('contenedor-mapa').innerHTML = `<div class="text-danger text-center p-4">
                <i class="fas fa-exclamation-triangle fa-2x mb-2"></i><br>
                Error Interno del Mapa.<br>
                <small style="color:#858796;">${error.message}</small>
            </div>`;
        }

        // ====================================================================
        // 3. GRÁFICOS CIRCULARES INFERIORES (¡Ahora se dibujarán sin problemas!)
        // ====================================================================
        const resSitio = <?php echo (int)$tot_en_sitio; ?>;
        const resReferencia = <?php echo (int)$tot_referencia; ?>;
        Highcharts.chart('donut-resolucion', {
            chart: { type: 'pie' }, title: { text: null },
            tooltip: { pointFormat: '{series.name}: <b>{point.y} ({point.percentage:.1f}%)</b>' },
            plotOptions: { pie: { innerSize: '60%', dataLabels: { enabled: true, format: '<b>{point.name}</b>: {point.percentage:.1f} %' } } },
            credits: { enabled: false },
            series: [{ name: 'Pacientes', colorByPoint: true, data: [ { name: 'Atención en Sitio', y: resSitio, color: '#36b9cc' }, { name: 'Requiere Referencia', y: resReferencia, color: '#e74a3b' } ] }]
        });

        const modReal = <?php echo (int)$tot_tiempo_real; ?>;
        const modDiferido = <?php echo (int)$tot_tiempo_diferido; ?>;
        Highcharts.chart('torta-modalidad', {
            chart: { type: 'pie' }, title: { text: null },
            tooltip: { pointFormat: '{series.name}: <b>{point.y} ({point.percentage:.1f}%)</b>' },
            plotOptions: { pie: { dataLabels: { enabled: true, format: '<b>{point.name}</b>: {point.percentage:.1f} %' } } },
            credits: { enabled: false },
            series: [{ name: 'Pacientes', colorByPoint: true, data: [ { name: 'Tiempo Real', y: modReal, color: '#4e73df' }, { name: 'Tiempo Diferido', y: modDiferido, color: '#858796' } ] }]
        });

        const totNuevo = <?php echo (int)$tot_nuevo; ?>;
        const totSeguimiento = <?php echo (int)$tot_seguimiento; ?>;
        Highcharts.chart('donut-paciente', {
            chart: { type: 'pie' }, title: { text: null },
            tooltip: { pointFormat: '{series.name}: <b>{point.y} ({point.percentage:.1f}%)</b>' },
            plotOptions: { pie: { innerSize: '60%', dataLabels: { enabled: true, distance: -15, format: '{point.percentage:.0f}%', style: { color: 'white', textOutline: 'none' } }, showInLegend: true } },
            credits: { enabled: false },
            series: [{ name: 'Pacientes', colorByPoint: true, data: [ { name: 'Nuevo', y: totNuevo, color: '#1cc88a' }, { name: 'Seguimiento', y: totSeguimiento, color: '#f6c23e' } ] }]
        });

        const tDiag = <?php echo (int)$tot_diag; ?>;
        const tDisc = <?php echo (int)$tot_disc; ?>;
        const tEmer = <?php echo (int)$tot_emer; ?>;
        Highcharts.chart('torta-tipo', {
            chart: { type: 'pie' }, title: { text: null },
            tooltip: { pointFormat: '{series.name}: <b>{point.y} ({point.percentage:.1f}%)</b>' },
            plotOptions: { pie: { dataLabels: { enabled: false }, showInLegend: true } },
            credits: { enabled: false },
            series: [{ name: 'Casos', colorByPoint: true, data: [ { name: 'Telediagnóstico', y: tDiag, color: '#4e73df' }, { name: 'Telediscusión', y: tDisc, color: '#36b9cc' }, { name: 'Teleemergencia', y: tEmer, color: '#e74a3b' } ] }]
        });

        const espCategorias = <?php echo json_encode(empty($cat_esp) ? ['Sin Registros'] : $cat_esp, JSON_UNESCAPED_UNICODE); ?>;
        const espDatos = <?php echo json_encode(empty($data_esp) ? [0] : $data_esp); ?>;
        Highcharts.chart('grafico-especialidades', {
            chart: { type: 'bar' }, title: { text: null },
            xAxis: { categories: espCategorias, title: { text: null } },
            yAxis: { min: 0, title: { text: 'N° de Solicitudes', align: 'high' } },
            plotOptions: { bar: { dataLabels: { enabled: true }, color: '#5a5c69' } },
            credits: { enabled: false },
            series: [{ name: 'Solicitudes Requeridas', data: espDatos }]
        });

        // ====================================================================
        // 4. PERFIL EPIDEMIOLÓGICO (BARRAS HORIZONTALES)
        // ====================================================================
        const orCategorias = <?php echo json_encode(empty($cat_origen) ? ['Sin Registros'] : $cat_origen, JSON_UNESCAPED_UNICODE); ?>;
        const orDatos = <?php echo json_encode(empty($data_origen) ? [0] : $data_origen); ?>;
        Highcharts.chart('grafico-origen', {
            chart: { type: 'bar' }, title: { text: null },
            xAxis: { categories: orCategorias, title: { text: null } },
            yAxis: { min: 0, title: { text: 'N° de Casos', align: 'high' } },
            plotOptions: { bar: { dataLabels: { enabled: true }, color: '#f6c23e' } },
            credits: { enabled: false },
            series: [{ name: 'Casos Referidos', data: orDatos }]
        });

    });
    </script>
    <!-- SCRIPT DEL MOTOR DE FILTROS EN CASCADA -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const dbDeptos = <?php echo json_encode($deptos, JSON_UNESCAPED_UNICODE); ?>;
        const dbMunis = <?php echo json_encode($munis, JSON_UNESCAPED_UNICODE); ?>;
        const dbEess = <?php echo json_encode($eess, JSON_UNESCAPED_UNICODE); ?>;
        const dbMeds = <?php echo json_encode($medicos, JSON_UNESCAPED_UNICODE); ?>;

        const initDepto = <?php echo $g_dep; ?>;
        const initMuni = <?php echo $g_mun; ?>;
        const initEess = <?php echo $g_est; ?>;
        const initMed = <?php echo $g_med; ?>;

        const inpDepto = document.getElementById('inp-depto');
        const inpMuni = document.getElementById('inp-muni');
        const inpEst = document.getElementById('inp-est');
        const inpMed = document.getElementById('inp-med');
        
        const valDepto = document.getElementById('val-iddepartamento');
        const valMuni = document.getElementById('val-idmunicipio');
        const valEst = document.getElementById('val-idestablecimiento');
        const valMed = document.getElementById('val-idusuario_medico');

        const dlDeptos = document.getElementById('dl-deptos');
        const dlMunis = document.getElementById('dl-munis');
        const dlEess = document.getElementById('dl-ests');
        const dlMeds = document.getElementById('dl-meds');

        function poblarLista(datalist, arrayData) {
            let html = '';
            arrayData.forEach(item => { html += `<option data-id="${item.id}" value="${item.nombre}"></option>`; });
            datalist.innerHTML = html;
        }

        function initListas() {
            poblarLista(dlDeptos, dbDeptos);
            poblarLista(dlMeds, dbMeds);

            if(initDepto) {
                const dObj = dbDeptos.find(d => d.id == initDepto);
                if(dObj) { inpDepto.value = dObj.nombre; valDepto.value = dObj.id; }
                poblarLista(dlMunis, dbMunis.filter(m => m.idDepto == initDepto));
            } else { poblarLista(dlMunis, dbMunis); }

            if(initMuni) {
                const mObj = dbMunis.find(m => m.id == initMuni);
                if(mObj) { inpMuni.value = mObj.nombre; valMuni.value = mObj.id; }
                poblarLista(dlEess, dbEess.filter(e => e.idMuni == initMuni));
            } else { poblarLista(dlEess, dbEess); }
            
            if(initEess) {
                const eObj = dbEess.find(e => e.id == initEess);
                if(eObj) { inpEst.value = eObj.nombre; valEst.value = eObj.id; }
            }

            if(initMed) {
                const medObj = dbMeds.find(u => u.id == initMed);
                if(medObj) { inpMed.value = medObj.nombre; valMed.value = medObj.id; }
            }
        }
        initListas();

        // LÓGICA DE EVENTOS (CASCADA)
        inpDepto.addEventListener('input', function() {
            const val = this.value.trim().toLowerCase();
            const obj = dbDeptos.find(d => d.nombre.toLowerCase() === val);
            if (obj) {
                valDepto.value = obj.id;
                poblarLista(dlMunis, dbMunis.filter(m => m.idDepto == obj.id));
                inpMuni.value = ""; valMuni.value = "";
                inpEst.value = ""; valEst.value = "";
                poblarLista(dlEess, []); 
            } else {
                valDepto.value = "";
                poblarLista(dlMunis, dbMunis);
                poblarLista(dlEess, dbEess);
            }
        });

        inpMuni.addEventListener('input', function() {
            const val = this.value.trim().toLowerCase();
            const mObj = dbMunis.find(m => m.nombre.toLowerCase() === val);
            if (mObj) {
                valMuni.value = mObj.id;
                const dObj = dbDeptos.find(d => d.id == mObj.idDepto);
                if(dObj) { inpDepto.value = dObj.nombre; valDepto.value = dObj.id; }
                poblarLista(dlEess, dbEess.filter(e => e.idMuni == mObj.id));
                inpEst.value = ""; valEst.value = "";
            } else { valMuni.value = ""; }
        });

        inpEst.addEventListener('input', function() {
            const val = this.value.trim().toLowerCase();
            const eObj = dbEess.find(e => e.nombre.toLowerCase() === val);
            if (eObj) {
                valEst.value = eObj.id;
                const mObj = dbMunis.find(m => m.id == eObj.idMuni);
                if(mObj) {
                    inpMuni.value = mObj.nombre; valMuni.value = mObj.id;
                    const dObj = dbDeptos.find(d => d.id == mObj.idDepto);
                    if(dObj) { inpDepto.value = dObj.nombre; valDepto.value = dObj.id; }
                }
            } else { valEst.value = ""; }
        });

        inpMed.addEventListener('input', function() {
            const option = document.querySelector(`#dl-meds option[value="${this.value}"]`);
            if(option) valMed.value = option.getAttribute('data-id');
            else valMed.value = "";
        });
    });
    </script>
    <!-- SCRIPT DEL MOTOR DE FILTROS CON AUTO-RECARGA -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const dbDeptos = <?php echo json_encode($deptos, JSON_UNESCAPED_UNICODE); ?>;
        const dbMunis = <?php echo json_encode($munis, JSON_UNESCAPED_UNICODE); ?>;
        const dbEess = <?php echo json_encode($eess, JSON_UNESCAPED_UNICODE); ?>;
        const dbMeds = <?php echo json_encode($medicos, JSON_UNESCAPED_UNICODE); ?>;

        const initDepto = <?php echo $g_dep; ?>;
        const initMuni = <?php echo $g_mun; ?>;
        const initEess = <?php echo $g_est; ?>;
        const initMed = <?php echo $g_med; ?>;

        function poblarLista(datalistId, arrayData) {
            let html = '';
            arrayData.forEach(item => { html += `<option data-id="${item.id}" value="${item.nombre}"></option>`; });
            document.getElementById(datalistId).innerHTML = html;
        }

        // 1. Inicializamos las listas disponibles
        poblarLista('dl-deptos', dbDeptos);
        poblarLista('dl-meds', dbMeds);

        // 2. Comportamiento en Cascada guiado por la Base de Datos
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
                    document.getElementById('form-filtros').submit(); // Gatilla la recarga
                } else if (val === "") {
                    hiddenInput.value = "";
                    document.getElementById('form-filtros').submit(); // Recarga si se borra el campo
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