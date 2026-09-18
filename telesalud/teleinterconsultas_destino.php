<?php 
include("../cabf.php"); 
include("../inc.config.php"); 

// Blindaje de sesiones para evitar errores
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
    <title>SISTEMA MEDI-SAFCI - Centro de Mando Destino</title>
    
    <!-- Fuentes y Estilos nativos -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    
    <style>
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
        .border-total { border-left-color: #36b9cc; }
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

    $g_dep = isset($_GET['iddepartamento']) && $_GET['iddepartamento'] != '' ? $_GET['iddepartamento'] : 'null';
    $g_mun = isset($_GET['idmunicipio']) && $_GET['idmunicipio'] != '' ? $_GET['idmunicipio'] : 'null';
    $g_est = isset($_GET['idestablecimiento']) && $_GET['idestablecimiento'] != '' ? $_GET['idestablecimiento'] : 'null';
    $g_med = isset($_GET['idusuario_medico']) && $_GET['idusuario_medico'] != '' ? $_GET['idusuario_medico'] : 'null';
    ?>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include("../menu.php"); ?>
        
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include("../top_bar.php"); ?>
                
                <div class="container-fluid mt-4">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-network-wired text-primary"></i> Centro de Mando: Teleinterconsultas Respuestas</h1>
                    </div>

                    <!-- BARRA DE FILTROS -->
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
                                    <label class="text-xs font-weight-bold text-gray-800">Médico Especialista:</label>
                                    <input list="dl-meds" id="inp-med" placeholder="- TODOS -" autocomplete="off">
                                    <input type="hidden" id="val-idusuario_medico" name="idusuario_medico" value="<?php echo $g_med != 'null' ? $g_med : ''; ?>">
                                    <datalist id="dl-meds"></datalist>
                                </div>
                                
                                <div>
                                    <button type="button" class="btn btn-secondary btn-sm shadow-sm font-weight-bold" onclick="window.location.href='teleinterconsultas_destino.php'" style="padding: 6px 15px; height: 31px;" title="Limpiar Filtros">
                                        <i class="fas fa-eraser"></i> Limpiar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php
                    // =========================================================================
                    // FASE 2: EXTRACCIÓN MAESTRA DE DATOS (RED ESPECIALISTA / DESTINO)
                    // =========================================================================
                    $inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : date('Y-m-01');
                    $finalizacion = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : date('Y-m-t');
                    
                    // FASE 3: ACUMULADOR DE FILTROS EN CASCADA
                    $filtro_destino = "";
                    if (isset($_GET['iddepartamento']) && $_GET['iddepartamento'] != '') {
                        $filtro_destino .= " AND es_receptor.iddepartamento = '" . mysqli_real_escape_string($link, $_GET['iddepartamento']) . "'";
                    }
                    if (isset($_GET['idmunicipio']) && $_GET['idmunicipio'] != '') {
                        $filtro_destino .= " AND es_receptor.idmunicipio = '" . mysqli_real_escape_string($link, $_GET['idmunicipio']) . "'";
                    }
                    if (isset($_GET['idestablecimiento']) && $_GET['idestablecimiento'] != '') {
                        $filtro_destino .= " AND r.idestablecimiento_receptor = '" . mysqli_real_escape_string($link, $_GET['idestablecimiento']) . "'";
                    }
                    if (isset($_GET['idusuario_medico']) && $_GET['idusuario_medico'] != '') {
                        $id_med = mysqli_real_escape_string($link, $_GET['idusuario_medico']);
                        $filtro_destino .= " AND (der.idusuario_r = '$id_med' OR der.idusuario_o = '$id_med') ";
                    }

                    // 1. Estados KPI (Sin MAX, usando tu regla exacta)
                    $sql_estados = "
                        SELECT 
                            (SELECT COUNT(r.idreferencia_hc) FROM referencia_hc r LEFT JOIN deriva_referencia_hc der ON r.idreferencia_hc = der.idreferencia_hc LEFT JOIN establecimiento_salud es_receptor ON r.idestablecimiento_receptor = es_receptor.idestablecimiento_salud WHERE r.idestado_referencia = '1' AND (der.admitido IS NULL OR (der.admitido != 'SI' AND der.admitido != 'NO')) AND r.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_destino) as espera_admitir,
                            (SELECT COUNT(DISTINCT r.idreferencia_hc) FROM referencia_hc r INNER JOIN deriva_referencia_hc der ON r.idreferencia_hc = der.idreferencia_hc LEFT JOIN establecimiento_salud es_receptor ON r.idestablecimiento_receptor = es_receptor.idestablecimiento_salud WHERE r.idestado_referencia = '1' AND der.admitido = 'SI' AND r.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_destino) as espera_responder,
                            (SELECT COUNT(DISTINCT r.idreferencia_hc) FROM referencia_hc r INNER JOIN deriva_referencia_hc der ON r.idreferencia_hc = der.idreferencia_hc LEFT JOIN establecimiento_salud es_receptor ON r.idestablecimiento_receptor = es_receptor.idestablecimiento_salud WHERE r.idestado_referencia = '2' AND der.admitido = 'SI' AND r.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_destino) as efectivizadas,
                            (SELECT COUNT(DISTINCT r.idreferencia_hc) FROM referencia_hc r INNER JOIN deriva_referencia_hc der ON r.idreferencia_hc = der.idreferencia_hc LEFT JOIN establecimiento_salud es_receptor ON r.idestablecimiento_receptor = es_receptor.idestablecimiento_salud WHERE r.idestado_referencia = '2' AND der.admitido = 'NO' AND r.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_destino) as rechazadas
                    ";
                    $res_estados = mysqli_query($link, $sql_estados);
                    $total_espera_admitir = 0; $total_espera_responder = 0; $total_efectivizadas = 0; $total_rechazadas = 0;
                    
                    if ($res_estados && $row_est = mysqli_fetch_assoc($res_estados)) {
                        $total_espera_admitir = (int)$row_est['espera_admitir'];
                        $total_espera_responder = (int)$row_est['espera_responder'];
                        $total_efectivizadas = (int)$row_est['efectivizadas'];
                        $total_rechazadas = (int)$row_est['rechazadas'];
                    }
                    
                    // Lógica solicitada: Desglose total del Universo
                    $total_admitidos = $total_espera_responder + $total_efectivizadas;
                    $total_general_recibidos = $total_espera_admitir + $total_admitidos + $total_rechazadas;
                    
                    $tasa_efectividad = ($total_admitidos > 0) ? round(($total_efectivizadas / $total_admitidos) * 100, 1) : 0;

                    // 2. Motor Geo-Espacial INVERTIDO 
                    $filtro_mapa = "";
                    if (isset($_GET['iddepartamento']) && $_GET['iddepartamento'] != '') $filtro_mapa .= " AND es_origen.iddepartamento = '" . mysqli_real_escape_string($link, $_GET['iddepartamento']) . "'";
                    if (isset($_GET['idmunicipio']) && $_GET['idmunicipio'] != '') $filtro_mapa .= " AND es_origen.idmunicipio = '" . mysqli_real_escape_string($link, $_GET['idmunicipio']) . "'";
                    if (isset($_GET['idestablecimiento']) && $_GET['idestablecimiento'] != '') $filtro_mapa .= " AND der.idestablecimiento_salud_o = '" . mysqli_real_escape_string($link, $_GET['idestablecimiento']) . "'";
                    if (isset($_GET['idusuario_medico']) && $_GET['idusuario_medico'] != '') $filtro_mapa .= " AND der.idusuario_o = '" . mysqli_real_escape_string($link, $_GET['idusuario_medico']) . "'";

                    $sql_mapa = "
                        SELECT 
                            d_origen.departamento as depto_origen,
                            d_destino.departamento as depto_destino,
                            COUNT(DISTINCT r.idreferencia_hc) as volumen
                        FROM referencia_hc r
                        INNER JOIN deriva_referencia_hc der ON r.idreferencia_hc = der.idreferencia_hc
                        INNER JOIN establecimiento_salud es_origen ON der.idestablecimiento_salud_o = es_origen.idestablecimiento_salud
                        INNER JOIN departamento d_origen ON es_origen.iddepartamento = d_origen.iddepartamento
                        INNER JOIN establecimiento_salud es_destino ON der.idestablecimiento_salud_r = es_destino.idestablecimiento_salud
                        INNER JOIN departamento d_destino ON es_destino.iddepartamento = d_destino.iddepartamento
                        WHERE r.idestado_referencia = '2' AND der.admitido = 'SI' 
                        AND r.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_mapa
                        GROUP BY d_origen.departamento, d_destino.departamento
                    ";
                    $res_mapa = mysqli_query($link, $sql_mapa);
                    $datos_flujo_mapa = [];
                    if ($res_mapa) {
                        while ($rm = mysqli_fetch_assoc($res_mapa)) {
                            $origen = str_replace(['Á','É','Í','Ó','Ú'], ['A','E','I','O','U'], mb_strtoupper(trim($rm['depto_origen'])));
                            $destino = str_replace(['Á','É','Í','Ó','Ú'], ['A','E','I','O','U'], mb_strtoupper(trim($rm['depto_destino'])));
                            $datos_flujo_mapa[] = ['origen' => $origen, 'destino' => $destino, 'peso' => (int)$rm['volumen']];
                        }
                    }

                    // 3. Top 10 Patologías Confirmadas (Destino)
                    $sql_top_destino = "
                        SELECT p.patologia, COUNT(de.iddiagnostico_egreso) as total
                        FROM diagnostico_egreso de
                        INNER JOIN deriva_referencia_hc der ON de.idreferencia_hc = der.idreferencia_hc
                        INNER JOIN referencia_hc r ON der.idreferencia_hc = r.idreferencia_hc
                        LEFT JOIN establecimiento_salud es_receptor ON r.idestablecimiento_receptor = es_receptor.idestablecimiento_salud
                        INNER JOIN patologia p ON de.idpatologia = p.idpatologia
                        WHERE r.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_destino
                        AND der.admitido = 'SI'
                        GROUP BY p.patologia ORDER BY total DESC LIMIT 10
                    ";
                    $res_top_destino = mysqli_query($link, $sql_top_destino);
                    $cat_destino = []; $data_destino = [];
                    if($res_top_destino){
                        while($row = mysqli_fetch_assoc($res_top_destino)){
                            $cat_destino[] = mb_strtoupper(trim($row['patologia']));
                            $data_destino[] = (int)$row['total'];
                        }
                    }

                    // 4. Top 10 Especialidades Solicitadas
                    $sql_top_esp = "
                        SELECT e.especialidad_medica, COUNT(r.idreferencia_hc) as total
                        FROM referencia_hc r
                        LEFT JOIN deriva_referencia_hc der ON r.idreferencia_hc = der.idreferencia_hc
                        LEFT JOIN establecimiento_salud es_receptor ON r.idestablecimiento_receptor = es_receptor.idestablecimiento_salud
                        INNER JOIN especialidad_medica e ON r.idespecialidad_medica = e.idespecialidad_medica
                        WHERE r.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_destino
                        GROUP BY e.especialidad_medica ORDER BY total DESC LIMIT 10
                    ";
                    $res_top_esp = mysqli_query($link, $sql_top_esp);
                    $cat_esp = []; $data_esp = [];
                    if($res_top_esp){
                        while($row_esp = mysqli_fetch_assoc($res_top_esp)){
                            $cat_esp[] = mb_strtoupper(trim($row_esp['especialidad_medica']));
                            $data_esp[] = (int)$row_esp['total'];
                        }
                    }

                    // 5. Consultas Torta (Resolución, Modalidad, Paciente, Tipo) adaptadas
                    $sql_torta = "
                        SELECT 
                            SUM(CASE WHEN r.atencion_sitio IN ('1', 'SI') THEN 1 ELSE 0 END) as en_sitio,
                            SUM(CASE WHEN r.atencion_sitio IN ('2', 'NO') THEN 1 ELSE 0 END) as referencia,
                            SUM(CASE WHEN r.idtiempo_ts = '1' THEN 1 ELSE 0 END) as tiempo_real,
                            SUM(CASE WHEN r.idtiempo_ts = '2' THEN 1 ELSE 0 END) as tiempo_diferido,
                            SUM(CASE WHEN a.idrepeticion = '1' THEN 1 ELSE 0 END) as nuevo,
                            SUM(CASE WHEN a.idrepeticion = '2' THEN 1 ELSE 0 END) as seguimiento,
                            SUM(CASE WHEN r.idtipo_teleinterconsulta = '1' THEN 1 ELSE 0 END) as t_diag,
                            SUM(CASE WHEN r.idtipo_teleinterconsulta = '2' THEN 1 ELSE 0 END) as t_disc,
                            SUM(CASE WHEN r.idtipo_teleinterconsulta = '3' THEN 1 ELSE 0 END) as t_emer
                        FROM referencia_hc r
                        LEFT JOIN deriva_referencia_hc der ON r.idreferencia_hc = der.idreferencia_hc
                        LEFT JOIN establecimiento_salud es_receptor ON r.idestablecimiento_receptor = es_receptor.idestablecimiento_salud
                        LEFT JOIN atencion_psafci a ON r.idatencion_psafci = a.idatencion_psafci
                        WHERE r.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_destino
                    ";
                    $res_torta = mysqli_query($link, $sql_torta);
                    $tot_en_sitio = 0; $tot_referencia = 0; $tot_tiempo_real = 0; $tot_tiempo_diferido = 0;
                    $tot_nuevo = 0; $tot_seguimiento = 0; $tot_diag = 0; $tot_disc = 0; $tot_emer = 0;
                    if ($res_torta && $row_t = mysqli_fetch_assoc($res_torta)) {
                        $tot_en_sitio = (int)$row_t['en_sitio']; $tot_referencia = (int)$row_t['referencia'];
                        $tot_tiempo_real = (int)$row_t['tiempo_real']; $tot_tiempo_diferido = (int)$row_t['tiempo_diferido'];
                        $tot_nuevo = (int)$row_t['nuevo']; $tot_seguimiento = (int)$row_t['seguimiento'];
                        $tot_diag = (int)$row_t['t_diag']; $tot_disc = (int)$row_t['t_disc']; $tot_emer = (int)$row_t['t_emer'];
                    }
                    ?>

                    <!-- TARJETAS KPI (ODÓMETROS) -->
                    <div class="row">
                        <!-- 1. TOTAL RECIBIDOS (El Universo Bruto) -->
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-4">
                            <div class="card kpi-card shadow h-100 py-2" style="border-left-color: #6c757d;">
                                <div class="card-body px-2">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-1">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="font-size: 10.5px; color: #6c757d;">Total Recibidos</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 contador-animado" data-objetivo="<?php echo $total_general_recibidos; ?>">0</div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-layer-group fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. POR ADMITIR (Bandeja Cruda) -->
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-4">
                            <div class="card kpi-card border-generadas shadow h-100 py-2">
                                <div class="card-body px-2">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-1">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="font-size: 10.5px;">Por Admitir</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 contador-animado" data-objetivo="<?php echo $total_espera_admitir; ?>">0</div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-inbox fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. POR RESPONDER -->
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-4">
                            <div class="card kpi-card shadow h-100 py-2" style="border-left-color: #fd7e14;">
                                <div class="card-body px-2">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-1">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="font-size: 10.5px; color: #fd7e14;">Por Responder</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 contador-animado" data-objetivo="<?php echo $total_espera_responder; ?>">0</div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-user-clock fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. TOTAL EFECTIVIZADAS -->
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-4">
                            <div class="card kpi-card border-efectivas shadow h-100 py-2">
                                <div class="card-body px-2">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-1">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="font-size: 10.5px;">Efectivizadas</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 contador-animado" data-objetivo="<?php echo $total_efectivizadas; ?>">0</div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-check-double fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 5. TOTAL RECHAZADAS -->
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-4">
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

                        <!-- 6. TASA DE EFECTIVIDAD -->
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-4">
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

                    <!-- FASE 2: MAPA Y TORTAS -->
                    <div class="row">
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Mapa de Flujo (Red consultor -> Red Emisora)</h6>
                                </div>
                                <div class="card-body" id="contenedor-mapa" style="height: 500px; display: flex; align-items: center; justify-content: center; background: radial-gradient(circle at center, #ffffff 0%, #f8f9fc 100%); border-radius: 0 0 0.35rem 0.35rem;"></div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Estado de Teleinterconsultas Respuestas</h6>
                                </div>
                                <div class="card-body" id="contenedor-torta" style="height: 500px;"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- FASE 3: GRÁFICOS CIRCULARES -->
                    <div class="row mt-4">
                        <div class="col-xl-3 col-lg-6 mb-4"><div class="card shadow h-100"><div class="card-header py-3"><h6 class="m-0 font-weight-bold text-info" style="font-size:13px;"><i class="fas fa-stethoscope"></i> Resolución</h6></div><div class="card-body" id="donut-resolucion" style="height: 300px;"></div></div></div>
                        <div class="col-xl-3 col-lg-6 mb-4"><div class="card shadow h-100"><div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary" style="font-size:13px;"><i class="fas fa-network-wired"></i> Modalidad</h6></div><div class="card-body" id="torta-modalidad" style="height: 300px;"></div></div></div>
                        <div class="col-xl-3 col-lg-6 mb-4"><div class="card shadow h-100"><div class="card-header py-3"><h6 class="m-0 font-weight-bold text-success" style="font-size:13px;"><i class="fas fa-user-plus"></i> Tipo de Paciente</h6></div><div class="card-body" id="donut-paciente" style="height: 300px;"></div></div></div>
                        <div class="col-xl-3 col-lg-6 mb-4"><div class="card shadow h-100"><div class="card-header py-3"><h6 class="m-0 font-weight-bold text-warning" style="font-size:13px;"><i class="fas fa-laptop-medical"></i> Tipo Interconsulta</h6></div><div class="card-body" id="torta-tipo" style="height: 300px;"></div></div></div>
                    </div>

                    <!-- FASE 4: DIAGNÓSTICOS Y ESPECIALIDADES COMPARTEN FILA -->
                    <div class="row mt-4" id="contenedor-epidemiologico">
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow mb-4 h-100">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-success">Top 10 Diagnósticos (Confirmados por Especialista)</h6>
                                </div>
                                <div class="card-body" id="grafico-destino" style="height: 400px;"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow mb-4 h-100">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-warning"><i class="fas fa-star text-warning"></i> Top 10 Especialidades Solicitadas</h6>
                                </div>
                                <div class="card-body" id="grafico-especialidades" style="height: 400px;"></div>
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

    <!-- Scripts Core -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Librerías Highcharts -->
    <script src="../js/telesalud_js/highcharts-11.3.0.js"></script>
    <script src="../js/telesalud_js/map-11.3.0.js"></script>
    <script src="../js/telesalud_js/flowmap-11.3.0.js"></script> 
    <script src="../js/telesalud_js/bo-all.js"></script>

    <!-- ANIMACIÓN Y RENDERIZADO VISUAL -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // Odómetros
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

        // 1. Dona Estado de Bandeja (Desglose Real del Flujo)
        const dataPorAdmitir = <?php echo (int)$total_espera_admitir; ?>;
        const dataPorResponder = <?php echo (int)$total_espera_responder; ?>;
        const dataEfectivas = <?php echo (int)$total_efectivizadas; ?>;
        const dataRechazadas = <?php echo (int)$total_rechazadas; ?>;

        Highcharts.chart('contenedor-torta', {
            chart: { type: 'pie' }, title: { text: null },
            tooltip: { pointFormat: '{series.name}: <b>{point.y} ({point.percentage:.1f}%)</b>' },
            plotOptions: { pie: { innerSize: '60%', allowPointSelect: true, cursor: 'pointer', dataLabels: { enabled: true, format: '<b>{point.name}</b>: {point.percentage:.1f} %' } } },
            credits: { enabled: false },
            series: [{ 
                name: 'Casos', colorByPoint: true, 
                data: [ 
                    { name: 'Por Admitir (Bandeja)', y: dataPorAdmitir, color: '#f6c23e' }, 
                    { name: 'Por Responder', y: dataPorResponder, color: '#fd7e14' }, 
                    { name: 'Efectivizadas (Respondidas)', y: dataEfectivas, color: '#1cc88a' }, 
                    { name: 'No Admitidas (Rechazadas)', y: dataRechazadas, color: '#e74a3b' } 
                ] 
            }]
        });

        // 2. Highmaps Motor Geoespacial
        try {
            const flujoData = <?php echo json_encode(isset($datos_flujo_mapa) ? $datos_flujo_mapa : []); ?>;
            const dicDeptos = {
                'BENI': { id: 1, hcKey: 'bo-eb', nombre: 'El Beni' }, 'COCHABAMBA': { id: 2, hcKey: 'bo-cb', nombre: 'Cochabamba' },
                'CHUQUISACA': { id: 3, hcKey: 'bo-cq', nombre: 'Chuquisaca' }, 'LA PAZ': { id: 4, hcKey: 'bo-lp', nombre: 'La Paz' },
                'ORURO': { id: 5, hcKey: 'bo-or', nombre: 'Oruro' }, 'PANDO': { id: 6, hcKey: 'bo-pa', nombre: 'Pando' },
                'POTOSI': { id: 7, hcKey: 'bo-po', nombre: 'Potosí' }, 'SANTA CRUZ': { id: 8, hcKey: 'bo-sc', nombre: 'Santa Cruz' },
                'TARIJA': { id: 9, hcKey: 'bo-tr', nombre: 'Tarija' }
            };

            let heatData = []; let mapLines = [];

            for (let depto in dicDeptos) {
                let totalCarga = 0;
                flujoData.forEach(f => { if (f.origen === depto || f.destino === depto) totalCarga += f.peso; });
                heatData.push({ 'hc-key': dicDeptos[depto].hcKey, id: dicDeptos[depto].hcKey, name: dicDeptos[depto].nombre, value: totalCarga, idDepto: dicDeptos[depto].id });
            }

            flujoData.forEach(flujo => {
                if (dicDeptos[flujo.origen] && dicDeptos[flujo.destino] && flujo.origen !== flujo.destino) {
                    mapLines.push({ 
                        from: dicDeptos[flujo.origen].hcKey, to: dicDeptos[flujo.destino].hcKey, 
                        weight: 1, totalCasos: flujo.peso, origenNom: dicDeptos[flujo.origen].nombre, destinoNom: dicDeptos[flujo.destino].nombre
                    });
                }
            });

            let seriesMapa = [{ type: 'map', id: 'capa-base', name: 'Carga Térmica', allAreas: true, data: heatData, joinBy: ['hc-key', 'hc-key'], borderColor: '#ffffff', borderWidth: 1.5, states: { hover: { color: '#f6c23e' } }, showInLegend: false, dataLabels: { enabled: true, format: '{point.name}', style: { fontSize: '10px', textOutline: '2px #ffffff', color: '#333' } } }];

            if (mapLines.length > 0) {
                seriesMapa.push({ type: 'flowmap', linkedTo: 'capa-base', name: 'Flujo de Derivación', data: mapLines, color: '#e74a3b', fillOpacity: 0.85, width: 0.0, curveFactor: 0.35, markerEnd: { width: '10px', height: '10px' }, animation: { defer: 400, duration: 1800 } });
            }

            const contMapa = document.getElementById('contenedor-mapa');
            if (contMapa) {
                contMapa.innerHTML = '';
                Highcharts.mapChart('contenedor-mapa', {
                    chart: { map: 'countries/bo/bo-all', backgroundColor: 'transparent', style: { filter: 'drop-shadow(0px 15px 20px rgba(0,0,0,0.15))' } },
                    title: { text: null }, mapNavigation: { enabled: true, buttonOptions: { verticalAlign: 'bottom' } }, credits: { enabled: false },
                    colorAxis: { min: 0, minColor: '#e3f2fd', maxColor: '#2e59d9' },
                    plotOptions: { series: { cursor: 'pointer', point: { events: { click: function () { if(this.idDepto) { document.getElementById('inp-depto').value = this.name.toUpperCase(); document.getElementById('val-iddepartamento').value = this.idDepto; document.getElementById('form-filtros').submit(); } } } } } },
                    tooltip: { useHTML: true, formatter: function () { if (this.series.name === 'Carga Térmica') return `<b>${this.point.name}</b><br>Volumen Global de Casos: <b>${this.point.value || 0}</b>`; if (this.series.name === 'Flujo de Derivación') return `<b>Origen:</b> ${this.point.options.origenNom}<br><b>Destino:</b> ${this.point.options.destinoNom}<br><b>Total Referencias:</b> ${this.point.options.totalCasos}`; return this.point.name; } },
                    series: seriesMapa
                });
            }
        } catch (error) {}

        // 3. Mini Tortas
        const resSitio = <?php echo (int)$tot_en_sitio; ?>; const resReferencia = <?php echo (int)$tot_referencia; ?>;
        Highcharts.chart('donut-resolucion', { chart: { type: 'pie' }, title: { text: null }, tooltip: { pointFormat: '{series.name}: <b>{point.y} ({point.percentage:.1f}%)</b>' }, plotOptions: { pie: { innerSize: '60%', dataLabels: { enabled: true, format: '<b>{point.name}</b>: {point.percentage:.1f} %' } } }, credits: { enabled: false }, series: [{ name: 'Pacientes', colorByPoint: true, data: [ { name: 'Atención en Sitio', y: resSitio, color: '#36b9cc' }, { name: 'Requiere Referencia', y: resReferencia, color: '#e74a3b' } ] }] });

        const modReal = <?php echo (int)$tot_tiempo_real; ?>; const modDiferido = <?php echo (int)$tot_tiempo_diferido; ?>;
        Highcharts.chart('torta-modalidad', { chart: { type: 'pie' }, title: { text: null }, tooltip: { pointFormat: '{series.name}: <b>{point.y} ({point.percentage:.1f}%)</b>' }, plotOptions: { pie: { dataLabels: { enabled: true, format: '<b>{point.name}</b>: {point.percentage:.1f} %' } } }, credits: { enabled: false }, series: [{ name: 'Pacientes', colorByPoint: true, data: [ { name: 'Tiempo Real', y: modReal, color: '#4e73df' }, { name: 'Tiempo Diferido', y: modDiferido, color: '#858796' } ] }] });

        const totNuevo = <?php echo (int)$tot_nuevo; ?>; const totSeguimiento = <?php echo (int)$tot_seguimiento; ?>;
        Highcharts.chart('donut-paciente', { chart: { type: 'pie' }, title: { text: null }, tooltip: { pointFormat: '{series.name}: <b>{point.y} ({point.percentage:.1f}%)</b>' }, plotOptions: { pie: { innerSize: '60%', dataLabels: { enabled: true, distance: -15, format: '{point.percentage:.0f}%', style: { color: 'white', textOutline: 'none' } }, showInLegend: true } }, credits: { enabled: false }, series: [{ name: 'Pacientes', colorByPoint: true, data: [ { name: 'Nuevo', y: totNuevo, color: '#1cc88a' }, { name: 'Seguimiento', y: totSeguimiento, color: '#f6c23e' } ] }] });

        const tDiag = <?php echo (int)$tot_diag; ?>; const tDisc = <?php echo (int)$tot_disc; ?>; const tEmer = <?php echo (int)$tot_emer; ?>;
        Highcharts.chart('torta-tipo', { chart: { type: 'pie' }, title: { text: null }, tooltip: { pointFormat: '{series.name}: <b>{point.y} ({point.percentage:.1f}%)</b>' }, plotOptions: { pie: { dataLabels: { enabled: false }, showInLegend: true } }, credits: { enabled: false }, series: [{ name: 'Casos', colorByPoint: true, data: [ { name: 'Telediagnóstico', y: tDiag, color: '#4e73df' }, { name: 'Telediscusión', y: tDisc, color: '#36b9cc' }, { name: 'Teleemergencia', y: tEmer, color: '#e74a3b' } ] }] });

        // 4. Diagnósticos y Especialidades (Barras Horizontales)
        const desCategorias = <?php echo json_encode(empty($cat_destino) ? ['Sin Registros'] :$cat_destino, JSON_UNESCAPED_UNICODE); ?>;
        const desDatos = <?php echo json_encode(empty($data_destino) ? [0] :$data_destino); ?>;
        Highcharts.chart('grafico-destino', {
            chart: { type: 'bar' }, title: { text: null }, xAxis: { categories: desCategorias, title: { text: null } },
            yAxis: { min: 0, title: { text: 'N° de Casos', align: 'high' } }, plotOptions: { bar: { dataLabels: { enabled: true }, color: '#1cc88a' } },
            credits: { enabled: false }, series: [{ name: 'Casos Confirmados', data: desDatos }]
        });

        const espCategorias = <?php echo json_encode(empty($cat_esp) ? ['Sin Registros'] :$cat_esp, JSON_UNESCAPED_UNICODE); ?>;
        const espDatos = <?php echo json_encode(empty($data_esp) ? [0] :$data_esp); ?>;
        Highcharts.chart('grafico-especialidades', {
            chart: { type: 'bar' }, title: { text: null }, xAxis: { categories: espCategorias, title: { text: null } },
            yAxis: { min: 0, title: { text: 'N° de Solicitudes', align: 'high' } }, plotOptions: { bar: { dataLabels: { enabled: true }, color: '#f6c23e' } },
            credits: { enabled: false }, series: [{ name: 'Solicitudes Requeridas', data: espDatos }]
        });
    });
    </script>
    
    <!-- SCRIPT DE FILTROS EN CASCADA Y AUTO-RECARGA -->
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
                if (obj) { hiddenInput.value = obj.id; document.getElementById('form-filtros').submit(); } 
                else if (val === "") { hiddenInput.value = ""; document.getElementById('form-filtros').submit(); }
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