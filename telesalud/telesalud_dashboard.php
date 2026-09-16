<?php
include("../cabf.php");
include("../inc.config.php");

// Asignación de variables de sesión obligatorias
$idusuario_ss = $_SESSION['idusuario_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$gestion      = date("Y");

// =========================================================================
// FASE 1: PUENTE DE DATOS Y CAPTURA DE FILTROS (PHP NATIVO)
// =========================================================================
$inicio       = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : date('Y-m-01');
$finalizacion = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : date('Y-m-t');

$g_dep = isset($_GET['iddepartamento']) && $_GET['iddepartamento'] != '' ? $_GET['iddepartamento'] : '';
$g_mun = isset($_GET['idmunicipio']) && $_GET['idmunicipio'] != '' ? $_GET['idmunicipio'] : '';
$g_est = isset($_GET['idestablecimiento']) && $_GET['idestablecimiento'] != '' ? $_GET['idestablecimiento'] : '';
$g_med = isset($_GET['idusuario_medico']) && $_GET['idusuario_medico'] != '' ? $_GET['idusuario_medico'] : '';

// Armado de sufijos SQL para cruces exactos
$filtro_ap = ""; $filtro_r = ""; $filtro_der = "";
if ($g_dep != '') {
    $filtro_ap  .= " AND ap.iddepartamento = '" . mysqli_real_escape_string($link, $g_dep) . "' ";
    $filtro_r   .= " AND r.iddepartamento = '" . mysqli_real_escape_string($link, $g_dep) . "' ";
    $filtro_der .= " AND es.iddepartamento = '" . mysqli_real_escape_string($link, $g_dep) . "' ";
}
if ($g_mun != '') {
    $filtro_ap  .= " AND ap.idmunicipio = '" . mysqli_real_escape_string($link, $g_mun) . "' ";
    $filtro_r   .= " AND r.idmunicipio = '" . mysqli_real_escape_string($link, $g_mun) . "' ";
    $filtro_der .= " AND es.idmunicipio = '" . mysqli_real_escape_string($link, $g_mun) . "' ";
}
if ($g_est != '') {
    $filtro_ap  .= " AND ap.idestablecimiento_salud = '" . mysqli_real_escape_string($link, $g_est) . "' ";
    $filtro_r   .= " AND r.idestablecimiento_salud = '" . mysqli_real_escape_string($link, $g_est) . "' ";
    $filtro_der .= " AND der.idestablecimiento_salud_o = '" . mysqli_real_escape_string($link, $g_est) . "' ";
}
if ($g_med != '') {
    $filtro_ap  .= " AND ap.idusuario = '" . mysqli_real_escape_string($link, $g_med) . "' ";
    $filtro_r   .= " AND r.idusuario = '" . mysqli_real_escape_string($link, $g_med) . "' ";
    $filtro_der .= " AND der.idusuario_o = '" . mysqli_real_escape_string($link, $g_med) . "' ";
}

// =========================================================================
// Catálogos para los selectores (Extracción masiva para memoria caché JS)
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

// =========================================================================
// MOTOR DEL GRÁFICO DIARIO (EJE X DINÁMICO POR RANGO DE FECHAS)
// =========================================================================
$eje_x_fechas = [];
$data_tc = []; $data_tm = []; $data_ref = []; $data_cref = [];

$periodo = new DatePeriod( new DateTime($inicio), new DateInterval('P1D'), (new DateTime($finalizacion))->modify('+1 day') );
foreach ($periodo as $fecha) {
    $f_str = $fecha->format('Y-m-d');
    $eje_x_fechas[] = $fecha->format('d/m');
    $data_tc[$f_str] = 0; $data_tm[$f_str] = 0; $data_ref[$f_str] = 0; $data_cref[$f_str] = 0;
}

$sql_g_tc = "SELECT DATE(ap.fecha_registro) as fecha_dia, COUNT(ap.idatencion_psafci) as total FROM atencion_psafci ap WHERE ap.fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND ap.idtipo_atencion = '3' $filtro_ap GROUP BY DATE(ap.fecha_registro)";
$res_g_tc = mysqli_query($link, $sql_g_tc);
if($res_g_tc){ while($row = mysqli_fetch_assoc($res_g_tc)){ if(isset($data_tc[$row['fecha_dia']])) { $data_tc[$row['fecha_dia']] = (int)$row['total']; } } }

$sql_g_tm = "SELECT DATE(ap.fecha_registro) as fecha_dia, COUNT(DISTINCT et.idatencion_psafci, et.idexamen_complementario) as total
             FROM examen_teleconsulta et
             INNER JOIN atencion_psafci ap ON et.idatencion_psafci = ap.idatencion_psafci
             INNER JOIN examen_complementario ec ON et.idexamen_complementario = ec.idexamen_complementario
             WHERE ap.fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND ap.idtipo_atencion = '4'
             AND UPPER(ec.examen_complementario) NOT LIKE '%MONITOR DE SIGNOS VITALES%' AND UPPER(ec.examen_complementario) NOT LIKE '%ESTETOSCOPIO DIGITAL%' AND UPPER(ec.examen_complementario) NOT LIKE '%OTRO%' $filtro_ap GROUP BY DATE(ap.fecha_registro)";
$res_g_tm = mysqli_query($link, $sql_g_tm);
if($res_g_tm){ while($row = mysqli_fetch_assoc($res_g_tm)){ if(isset($data_tm[$row['fecha_dia']])) { $data_tm[$row['fecha_dia']] = (int)$row['total']; } } }

$sql_g_ref = "SELECT DATE(r.fecha_registro) as fecha_dia, COUNT(r.idreferencia_hc) as total FROM referencia_hc r WHERE r.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_r GROUP BY DATE(r.fecha_registro)";
$res_g_ref = mysqli_query($link, $sql_g_ref);
if($res_g_ref){ while($row = mysqli_fetch_assoc($res_g_ref)){ if(isset($data_ref[$row['fecha_dia']])) { $data_ref[$row['fecha_dia']] = (int)$row['total']; } } }

$sql_g_cref = "SELECT DATE(der.fecha_deriva) as fecha_dia, COUNT(DISTINCT r.idreferencia_hc) as total
               FROM referencia_hc r
               INNER JOIN deriva_referencia_hc der ON r.idreferencia_hc = der.idreferencia_hc
               LEFT JOIN establecimiento_salud es ON der.idestablecimiento_salud_o = es.idestablecimiento_salud
               WHERE r.idestado_referencia = '2' AND der.admitido = 'SI' AND der.fecha_deriva BETWEEN '$inicio' AND '$finalizacion' $filtro_der GROUP BY DATE(der.fecha_deriva)";
$res_g_cref = mysqli_query($link, $sql_g_cref);
if($res_g_cref){ while($row = mysqli_fetch_assoc($res_g_cref)){ if(isset($data_cref[$row['fecha_dia']])) { $data_cref[$row['fecha_dia']] = (int)$row['total']; } } }
?>

<title>SISTEMA MEDI-SAFCI - Dashboard Telesalud</title>
<!-- Custom fonts & styles -->
<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="../css/sb-admin-2.min.css" rel="stylesheet">
<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/jquery-ui.min.css">
<link rel="stylesheet" href="../css/boton_mic.css">

<style>
    /* Estilos del buscador y tarjetas */
    .search-box { border-radius: 20px 0 0 20px !important; height: 35px !important; padding: 10px 20px; border: 1px solid #d1d3e2; border-right: none; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05); }
    .btn-search-fix { border-radius: 0 20px 20px 0 !important; height: 35px !important; padding: 0 20px; display: flex; align-items: center; border: 1px solid #4e73df; z-index: 0 !important; }
    
    .kpi-card { transition: transform 0.2s; border-radius: 10px; border-left: 5px solid; }
    .kpi-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    .kpi-clickable { cursor: pointer; transition: all 0.2s ease-in-out; }
    .kpi-clickable:hover { transform: scale(1.03); opacity: 0.9; }
    .kpi-clickable:active { transform: scale(0.98); }
    
    /* Colores personalizados para los bordes de las tarjetas */
    .border-ref { border-left-color: #f6c23e; }
    .border-cref { border-left-color: #e74a3b; }
    .border-tc { border-left-color: #4e73df; }
    .border-tm { border-left-color: #1cc88a; }
    .border-tot { border-left-color: #36b9cc; }
    .border-ben { border-left-color: #6f42c1; }
    .border-edu { border-left-color: #858796; }
    
    /* Diseño unificado: Barra de Filtros Inteligente */
    .barra-filtros { background-color: #f8f9fa; border: 1px solid #d1d3e2; border-radius: 6px; padding: 15px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .filtros-dropdowns { display: flex; flex-wrap: wrap; justify-content: center; align-items: flex-end; gap: 15px; width: 100%; }
    .filtros-dropdowns > div { display: flex; flex-direction: column; gap: 5px; position: relative; }
    .barra-filtros input[list] { padding: 5px 8px; border-radius: 4px; border: 1px solid #d1d3e2; font-size: 12px; color: #333; outline: none; width: 220px; text-transform: uppercase; }

    /* Estilos para el Modal a Pantalla Completa */
    .modal-fullscreen { width: 100vw !important; max-width: 100vw !important; height: 100vh !important; margin: 0 !important; }
    .modal-fullscreen .modal-content { height: 100vh !important; border-radius: 0 !important; }
    .modal-fullscreen .modal-body { height: calc(100vh - 120px) !important; }
</style>

<div id="wrapper">
    <?php include("../menu.php");?>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include("../top_bar.php"); ?>
            <div class="container-fluid mt-4">
                
                <!-- HEADER Y BUSCADOR INTELIGENTE -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-laptop-medical text-primary"></i> Central de Telesalud</h1>
                    
                    <form action="valida_busqueda_telesalud.php" method="POST" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" name="ci" class="form-control bg-white search-box" placeholder="N° Carnet o Código" aria-label="Search" required>
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-search-fix" type="submit">
                                    <i class="fas fa-search fa-sm mr-2"></i> BUSCAR
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- BARRA DE FILTROS EN CASCADA -->
                <div class="barra-filtros">
                    <form id="form-filtros" method="GET" action="">
                        <div class="filtros-dropdowns">
                            <div>
                                <label class="text-xs font-weight-bold text-gray-800">Fecha Inicio:</label>
                                <input type="date" name="fecha_inicio" class="form-control form-control-sm bg-white" style="width: 130px;" value="<?php echo isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : date('Y-m-01'); ?>" onchange="document.getElementById('form-filtros').submit();">
                            </div>
                            <div>
                                <label class="text-xs font-weight-bold text-gray-800">Fecha Fin:</label>
                                <input type="date" name="fecha_fin" class="form-control form-control-sm bg-white" style="width: 130px;" value="<?php echo isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : date('Y-m-t'); ?>" onchange="document.getElementById('form-filtros').submit();">
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
                                <button type="button" class="btn btn-secondary btn-sm shadow-sm font-weight-bold" onclick="window.location.href='telesalud_dashboard.php'" style="padding: 6px 15px; height: 31px;" title="Limpiar Filtros">
                                    <i class="fas fa-eraser"></i> Limpiar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <?php
                // === EXTRACCIÓN DE DATOS REALES PARA TARJETAS KPI ===
                
                // 1. T. Generadas
                $sql_tot_ref = "SELECT COUNT(r.idreferencia_hc) AS total FROM referencia_hc r WHERE r.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_r";
                $res_tot_ref = mysqli_query($link, $sql_tot_ref);
                $total_generadas = ($res_tot_ref && $row_ref = mysqli_fetch_assoc($res_tot_ref)) ? $row_ref['total'] : 0;

                // 2. T. Efectivizadas
                $sql_tot_cref = "SELECT COUNT(DISTINCT r.idreferencia_hc) AS total FROM referencia_hc r INNER JOIN deriva_referencia_hc der ON r.idreferencia_hc = der.idreferencia_hc LEFT JOIN establecimiento_salud es ON der.idestablecimiento_salud_o = es.idestablecimiento_salud WHERE r.idestado_referencia = '2' AND der.admitido = 'SI' AND der.fecha_deriva BETWEEN '$inicio' AND '$finalizacion' $filtro_der";
                $res_tot_cref = mysqli_query($link, $sql_tot_cref);
                $total_efectivizadas = ($res_tot_cref && $row_cref = mysqli_fetch_assoc($res_tot_cref)) ? $row_cref['total'] : 0;

                // 3. Teleconsultas
                $sql_tot_tc = "SELECT COUNT(ap.idatencion_psafci) AS total FROM atencion_psafci ap WHERE ap.fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND ap.idtipo_atencion = '3' $filtro_ap";
                $res_tot_tc = mysqli_query($link, $sql_tot_tc);
                $total_teleconsultas = ($res_tot_tc && $row_tc = mysqli_fetch_assoc($res_tot_tc)) ? $row_tc['total'] : 0;

                // 4. Telemetrías
                $sql_tot_tm = "SELECT COUNT(DISTINCT et.idatencion_psafci, et.idexamen_complementario) AS total FROM examen_teleconsulta et INNER JOIN atencion_psafci ap ON et.idatencion_psafci = ap.idatencion_psafci INNER JOIN examen_complementario ec ON et.idexamen_complementario = ec.idexamen_complementario WHERE ap.fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND ap.idtipo_atencion = '4' AND UPPER(ec.examen_complementario) NOT LIKE '%MONITOR DE SIGNOS VITALES%' AND UPPER(ec.examen_complementario) NOT LIKE '%ESTETOSCOPIO DIGITAL%' AND UPPER(ec.examen_complementario) NOT LIKE '%OTRO%' $filtro_ap";
                $res_tot_tm = mysqli_query($link, $sql_tot_tm);
                $total_telemetrias = ($res_tot_tm && $row_tm = mysqli_fetch_assoc($res_tot_tm)) ? $row_tm['total'] : 0;

                // 5. Total Servicios Brindados
                $total_servicios = $total_generadas + $total_efectivizadas + $total_teleconsultas + $total_telemetrias;

                // 6. Pacientes Únicos Beneficiados (Cálculo corregido al rango de fechas actual)
                $sql_tot_ben = "
                    SELECT COUNT(DISTINCT idnombre) AS total_unicos FROM (
                        SELECT ap.idnombre FROM atencion_psafci ap WHERE ap.fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND ap.idtipo_atencion IN ('3', '4') $filtro_ap
                        UNION
                        SELECT r.idnombre FROM referencia_hc r WHERE r.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_r
                    ) AS unicos";
                $res_tot_ben = mysqli_query($link, $sql_tot_ben);
                $total_beneficiados = ($res_tot_ben && $row_ben = mysqli_fetch_assoc($res_tot_ben)) ? $row_ben['total_unicos'] : 0;
                
                // 7. Teleeducación (Estático en 0 por ahora)
                $total_educacion = 0;
                ?>

                <!-- 7 TARJETAS KPI (Uso de 'col-xl' para que Bootstrap distribuya las 7 simétricamente en 1 fila) -->
                <div class="row">
                    <div class="col-xl col-md-4 mb-4">
                        <div class="card kpi-card border-ref shadow h-100 py-2 kpi-clickable" data-series="2">
                            <div class="card-body px-2">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-1">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="font-size: 10px;">T. Generadas</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800 contador-animado" data-objetivo="<?php echo $total_generadas; ?>">0</div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-share-square fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl col-md-4 mb-4">
                        <div class="card kpi-card border-cref shadow h-100 py-2 kpi-clickable" data-series="3">
                            <div class="card-body px-2">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-1">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1" style="font-size: 10px;">T. Efectivizadas</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800 contador-animado" data-objetivo="<?php echo $total_efectivizadas; ?>">0</div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-check-double fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl col-md-4 mb-4">
                        <div class="card kpi-card border-tc shadow h-100 py-2 kpi-clickable" data-series="0">
                            <div class="card-body px-2">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-1">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="font-size: 10px;">Teleconsultas</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800 contador-animado" data-objetivo="<?php echo $total_teleconsultas; ?>">0</div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-stethoscope fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl col-md-4 mb-4">
                        <div class="card kpi-card border-tm shadow h-100 py-2 kpi-clickable" data-series="1">
                            <div class="card-body px-2">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-1">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="font-size: 10px;">Telemetrías</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800 contador-animado" data-objetivo="<?php echo $total_telemetrias; ?>">0</div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-heartbeat fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl col-md-4 mb-4">
                        <div class="card kpi-card border-tot shadow h-100 py-2">
                            <div class="card-body px-2">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-1">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="font-size: 9px;">Total Servicios</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800 contador-animado" data-objetivo="<?php echo $total_servicios; ?>">0</div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-hand-holding-medical fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl col-md-4 mb-4">
                        <div class="card kpi-card border-ben shadow h-100 py-2" title="Pacientes Únicos Atendidos">
                            <div class="card-body px-2">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-1">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="font-size: 9px; color: #6f42c1;">Beneficiados</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800 contador-animado" data-objetivo="<?php echo $total_beneficiados; ?>">0</div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl col-md-4 mb-4">
                        <div class="card kpi-card border-edu shadow h-100 py-2">
                            <div class="card-body px-2">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-1">
                                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1" style="font-size: 9px;">Teleeducación</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800 contador-animado" data-objetivo="<?php echo $total_educacion; ?>">0</div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ESPACIO PARA EL GRÁFICO MAESTRO DIARIO -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary text-uppercase">FLUJO DE PRODUCCIÓN DIARIA - DEL <?php echo date("d/m/Y", strtotime($inicio)); ?> AL <?php echo date("d/m/Y", strtotime($finalizacion)); ?></h6>
                            </div>
                            <div class="card-body" style="height: 350px; display: flex; align-items: center; justify-content: center;">
                                <div id="grafico-maestro" style="width: 100%; height: 350px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========================================================================= -->
                <!-- SECCIÓN DE ACCIONES GERENCIALES (FASE 1)                                  -->
                <!-- ========================================================================= -->
                <div class="row mt-2 mb-5">
                    <div class="col-12 text-center">
                        <hr class="mb-4">
                        <button id="btn-generar-analitica" class="btn btn-primary btn-lg shadow-sm mr-2 mb-2" style="border-radius: 30px; padding: 10px 25px; font-size: 14px;">
                            <i class="fas fa-chart-pie mr-2"></i> Generar Analítica Anual Detallada
                        </button>
                        <button id="btn-ver-matriz" class="btn btn-warning btn-lg shadow-sm mb-2" style="border-radius: 30px; padding: 10px 25px; font-size: 14px; color: #333;" data-toggle="modal" data-target="#modalMatrizGlobal">
                            <i class="fas fa-table mr-2"></i> Ver Matriz de Producción Global
                        </button>
                    </div>
                </div>

                <!-- CONTENEDOR FANTASMA PARA LA ANALÍTICA ANUAL (FASE 2) -->
                <div id="contenedor-analitica-anual" style="display: none;" class="mb-5">
                    
                    <!-- Pantalla de Carga AJAX -->
                    <div id="loader-analitica" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
                        <h5 class="mt-3 text-primary font-weight-bold">Construyendo curvas de tendencia anual...</h5>
                    </div>

                    <!-- Div de Gráficos (Oculto hasta que lleguen los datos) -->
                    <div id="graficos-analitica" style="display: none;">
                        
                        <!-- CONTROLADOR HISTÓRICO DE GESTIÓN (Las Flechas) -->
                        <div class="d-flex justify-content-center align-items-center mb-4">
                            <button class="btn btn-outline-primary btn-sm btn-cambio-anio shadow-sm" data-dir="-1" style="border-radius: 50%; width: 35px; height: 35px;" title="Año Anterior">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <h4 class="mx-4 mb-0 font-weight-bold text-primary text-uppercase" id="texto-gestion-analitica">Gestión <?php echo $gestion; ?></h4>
                            <button class="btn btn-outline-primary btn-sm btn-cambio-anio shadow-sm" data-dir="1" style="border-radius: 50%; width: 35px; height: 35px;" title="Año Siguiente">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>

                        <div class="row">
                            <!-- Gráfico de Totales (Resumen) -->
                            <div class="col-xl-4 mb-4">
                                <div class="card shadow h-100">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-dark"><i class="fas fa-chart-bar text-primary"></i> Volúmenes Anuales Totales</h6>
                                    </div>
                                    <div class="card-body" id="chart-anual-barras" style="height: 380px;"></div>
                                </div>
                            </div>
                            
                            <!-- Gráfico de Tendencia Mensual (Interactivo) -->
                            <div class="col-xl-8 mb-4">
                                <div class="card shadow h-100">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-dark"><i class="fas fa-chart-line text-success"></i> Evolución Mensual Interactiva</h6>
                                        <small class="text-muted">Click en la leyenda para aislar curvas</small>
                                    </div>
                                    <div class="card-body" id="chart-anual-lineas" style="height: 380px;"></div>
                                </div>
                            </div>
                        </div>
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

<a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

<!-- ========================================================================= -->
<!-- MODAL GIGANTE: MATRIZ DE PRODUCCIÓN GLOBAL                                -->
<!-- ========================================================================= -->
<div class="modal fade" id="modalMatrizGlobal" tabindex="-1" role="dialog" aria-labelledby="modalMatrizLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document" style="max-width: 95%; transition: all 0.3s ease;">
    <div class="modal-content shadow-lg" style="border-radius: 15px; overflow: hidden; transition: all 0.3s ease;">
      
      <!-- Cabecera del Modal con Iconos de Control -->
      <div class="modal-header bg-warning py-1">
        <h5 class="modal-title font-weight-bold text-dark" id="modalMatrizLabel">
            <i class="fas fa-table mr-2"></i> MATRIZ DE PRODUCCIÓN GLOBAL (Telesalud)
        </h5>
        <div>
            <!-- Botón de Maximizar/Minimizar -->
            <button type="button" class="close text-dark mr-3" id="btn-maximize-modal" title="Maximizar / Restaurar" style="outline: none;">
              <i class="fas fa-expand-arrows-alt" style="font-size: 16px;"></i>
            </button>
            <!-- Botón de Cerrar -->
            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close" title="Cerrar" style="outline: none;">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      </div>
      
      <div class="modal-body p-0" style="height: 75vh; overflow-y: auto; background-color: #f8f9fa; transition: height 0.3s ease;">
         <iframe id="iframe-matriz" src="" style="width: 100%; height: 100%; border: none; display: none;"></iframe>
         <div id="loader-matriz" class="p-5 text-center">
             <div class="spinner-border text-warning" role="status" style="width: 3rem; height: 3rem;"></div>
             <h5 class="mt-3 text-dark font-weight-bold">Cargando matriz global, por favor espere...</h5>
         </div>
      </div>
      
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary shadow-sm" data-dismiss="modal">Cerrar Ventana</button>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../js/sb-admin-2.min.js"></script>
<script src="../js/telesalud_js/highcharts-10.3.3.js"></script>

<!-- Lógica del Odómetro, Gráfico y Filtros -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Animación de Odómetro
    const contadores = document.querySelectorAll('.contador-animado');
    const velocidad = 50;
    contadores.forEach(contador => {
        const actualizarConteo = () => {
            const objetivo = +contador.getAttribute('data-objetivo');
            const conteoActual = +contador.innerText.replace(/,/g, '');
            const incremento = objetivo / velocidad;
            if (conteoActual < objetivo) {
                contador.innerText = Math.ceil(conteoActual + incremento).toLocaleString('en-US');
                setTimeout(actualizarConteo, 15);
            } else {
                contador.innerText = objetivo.toLocaleString('en-US');
            }
        };
        if(+contador.getAttribute('data-objetivo') > 0) actualizarConteo();
    });

    // 2. Highcharts con Drill-down visual
    const chartMaestro = Highcharts.chart('grafico-maestro', {
        chart: { type: 'areaspline' },
        title: { text: null },
        xAxis: { categories: <?php echo json_encode($eje_x_fechas); ?>, crosshair: true },
        yAxis: { title: { text: 'N° de Casos' } },
        tooltip: {
            shared: true,
            useHTML: true,
            formatter: function () {
                let tooltipHtml = ''; 
                let sumaDia = 0;
                this.points.forEach(function (point) {
                    tooltipHtml += '<span style="color:' + point.color + '">\u25CF</span> ' + point.series.name + ': <b>' + point.y + '</b> Registros<br/>';
                    sumaDia += point.y;
                });
                if (this.points.length > 1) {
                    tooltipHtml += '<hr style="margin: 5px 0; border-top: 1px solid #d1d3e2;" />';
                    tooltipHtml += '<span style="color: #4a4a4a;">\u25CF</span> <b>TOTAL DEL DÍA: ' + sumaDia + '</b>';
                }
                return tooltipHtml;
            }
        },
        credits: { enabled: false },
        plotOptions: { areaspline: { fillOpacity: 0.15, marker: { enabled: false } } },
        series: [
            { name: 'Teleconsultas', data: <?php echo json_encode(array_values($data_tc)); ?>, color: '#4e73df' },
            { name: 'Telemetrías', data: <?php echo json_encode(array_values($data_tm)); ?>, color: '#1cc88a' },
            { name: 'T. Generadas', data: <?php echo json_encode(array_values($data_ref)); ?>, color: '#f6c23e' },
            { name: 'T. Efectivizadas', data: <?php echo json_encode(array_values($data_cref)); ?>, color: '#e74a3b' }
        ]
    });

    let serieActiva = null;
    document.querySelectorAll('.kpi-clickable').forEach(tarjeta => {
        tarjeta.addEventListener('click', function() {
            const indiceSerie = parseInt(this.getAttribute('data-series'));
            if (serieActiva === indiceSerie) {
                chartMaestro.series.forEach(serie => serie.setVisible(true, false));
                serieActiva = null;
            } else {
                chartMaestro.series.forEach((serie, idx) => { serie.setVisible(idx === indiceSerie, false); });
                serieActiva = indiceSerie;
            }
            chartMaestro.redraw();
        });
    });

    // 3. Modal de la Matriz (Iframe logic)
    $('#modalMatrizGlobal').on('show.bs.modal', function (e) {
        const iframe = document.getElementById('iframe-matriz');
        const loader = document.getElementById('loader-matriz');
        
        const params = new URLSearchParams({
            inicio: '<?php echo $inicio; ?>',
            finalizacion: '<?php echo $finalizacion; ?>',
            iddepartamento: '<?php echo $g_dep; ?>',
            idmunicipio: '<?php echo $g_mun; ?>',
            idestablecimiento: '<?php echo $g_est; ?>',
            idusuario_medico: '<?php echo $g_med; ?>',
            vista_limpia: '1'
        });
        iframe.src = '../produccion_servicios/atenciones_psafci_diarias_fechas_tele.php?' + params.toString();
        iframe.onload = function() {
            loader.style.display = 'none';
            iframe.style.display = 'block';
        };
    });
    
    $('#modalMatrizGlobal').on('hidden.bs.modal', function (e) {
        document.getElementById('iframe-matriz').src = "";
        document.getElementById('loader-matriz').style.display = 'block';
        document.getElementById('iframe-matriz').style.display = 'none';
        
        // Si el usuario maximizó, se lo restauramos al cerrar
        const dialog = document.querySelector('#modalMatrizGlobal .modal-dialog');
        if(dialog.classList.contains('modal-fullscreen')) {
            document.getElementById('btn-maximize-modal').click();
        }
    });

    // 4. Lógica del Botón Maximizar / Restaurar
    document.getElementById('btn-maximize-modal').addEventListener('click', function() {
        const dialog = document.querySelector('#modalMatrizGlobal .modal-dialog');
        dialog.classList.toggle('modal-fullscreen');
        
        const icon = this.querySelector('i');
        if(dialog.classList.contains('modal-fullscreen')) {
            icon.classList.remove('fa-expand-arrows-alt');
            icon.classList.add('fa-compress-arrows-alt');
        } else {
            icon.classList.remove('fa-compress-arrows-alt');
            icon.classList.add('fa-expand-arrows-alt');
        }
    });
});
</script>

<!-- SCRIPT DEL MOTOR DE FILTROS EN CASCADA Y AJAX -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // ---------------------------------------------------------
    // A) MOTOR DE FILTROS EN CASCADA
    // ---------------------------------------------------------
    const dbDeptos = <?php echo json_encode($deptos, JSON_UNESCAPED_UNICODE); ?>;
    const dbMunis = <?php echo json_encode($munis, JSON_UNESCAPED_UNICODE); ?>;
    const dbEess = <?php echo json_encode($eess, JSON_UNESCAPED_UNICODE); ?>;
    const dbMeds = <?php echo json_encode($medicos, JSON_UNESCAPED_UNICODE); ?>;

    const initDepto = "<?php echo $g_dep; ?>";
    const initMuni = "<?php echo $g_mun; ?>";
    const initEess = "<?php echo $g_est; ?>";
    const initMed = "<?php echo $g_med; ?>";

    function poblarLista(datalistId, arrayData) {
        let html = '';
        arrayData.forEach(item => { html += `<option data-id="${item.id}" value="${item.nombre}"></option>`; });
        document.getElementById(datalistId).innerHTML = html;
    }

    poblarLista('dl-deptos', dbDeptos);
    poblarLista('dl-meds', dbMeds);

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

    // ---------------------------------------------------------
    // B) MOTOR AJAX: CARGA BAJO DEMANDA DE LA ANALÍTICA ANUAL
    // ---------------------------------------------------------
    let anioActualAnalitica = new Date().getFullYear();

    function cargarAnaliticaAnual(anioTarget) {
        $('#loader-analitica').fadeIn(200);
        $('#graficos-analitica').hide();
        $('#texto-gestion-analitica').text('Gestión ' + anioTarget);

        $.ajax({
            url: 'ajax_analitica_anual.php',
            type: 'GET',
            data: {
                gestion: anioTarget,
                iddepartamento: '<?php echo $g_dep; ?>',
                idmunicipio: '<?php echo $g_mun; ?>',
                idestablecimiento: '<?php echo $g_est; ?>',
                idusuario_medico: '<?php echo $g_med; ?>'
            },
            dataType: 'json',
            success: function(res) {
                $('#loader-analitica').fadeOut(200, function() {
                    $('#graficos-analitica').fadeIn(400);
                    
                    // A) Gráfico de Barras (REORDENADO y con Colores Sincronizados)
                    Highcharts.chart('chart-anual-barras', {
                        chart: { type: 'column' },
                        title: { text: null },
                        xAxis: { categories: ['T. Generadas', 'T. Efectivizadas', 'Teleconsultas', 'Telemetrías'] },
                        yAxis: { min: 0, title: { text: 'Total Servicios' } },
                        tooltip: { pointFormat: 'Total Anual: <b>{point.y}</b>' },
                        plotOptions: { column: { borderRadius: 4, colorByPoint: true, dataLabels: { enabled: true } } },
                        colors: ['#f6c23e', '#e74a3b', '#4e73df', '#1cc88a'], // Amarillo, Rojo, Azul, Verde
                        credits: { enabled: false },
                        legend: { enabled: false },
                        series: [{
                            name: 'Servicios',
                            data: [res.totales.ref, res.totales.cref, res.totales.tc, res.totales.tm]
                        }]
                    });

                    // B) Gráfico de Líneas (REORDENADO y con Colores Sincronizados)
                    Highcharts.chart('chart-anual-lineas', {
                        chart: { type: 'spline' },
                        title: { text: null },
                        xAxis: { categories: res.meses },
                        yAxis: { title: { text: 'N° de Servicios' }, min: 0 },
                        tooltip: { shared: true, crosshairs: true },
                        plotOptions: {
                            spline: { marker: { radius: 4, lineColor: '#666', lineWidth: 1 } },
                            series: { cursor: 'pointer', events: { legendItemClick: function () { return true; } } }
                        },
                        colors: ['#f6c23e', '#e74a3b', '#4e73df', '#1cc88a'],
                        credits: { enabled: false },
                        series: [
                            { name: 'T. Generadas', data: res.series.ref },
                            { name: 'T. Efectivizadas', data: res.series.cref },
                            { name: 'Teleconsultas', data: res.series.tc },
                            { name: 'Telemetrías', data: res.series.tm }
                        ]
                    });
                });
            },
            error: function(xhr, status, error) {
                alert("Hubo un error al generar la analítica. Asegúrese de tener conexión.");
                $('#loader-analitica').hide();
            }
        });
    }

    // Evento del botón principal azul
    $('#btn-generar-analitica').click(function() {
        const btn = $(this);
        btn.prop('disabled', true);
        btn.html('<i class="fas fa-check-circle mr-2"></i> Analítica Cargada Exitosamente').removeClass('btn-primary').addClass('btn-success');
        
        $('#contenedor-analitica-anual').slideDown(400);
        $('html, body').animate({ scrollTop: $("#contenedor-analitica-anual").offset().top - 50 }, 800);
        
        // Dispara la función por primera vez con el año actual
        cargarAnaliticaAnual(anioActualAnalitica);
    });

    // Evento de las flechas (Cambio de Año)
    $('.btn-cambio-anio').click(function() {
        const direccion = parseInt($(this).data('dir')); // -1 (Atrás) o 1 (Adelante)
        anioActualAnalitica += direccion;
        cargarAnaliticaAnual(anioActualAnalitica);
    });
});
</script>
</body>
</html>