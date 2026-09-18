<?php
include("../cabf.php");
include("../inc.config.php"); // <-- ¡ESTA ES LA LÍNEA MÁGICA QUE FALTABA!

// Si el JS envía un año específico, lo usamos, si no, usamos el año en curso
$gestion = isset($_GET['gestion']) ? (int)mysqli_real_escape_string($link, $_GET['gestion']) : date("Y");

// 1. Recepción de Filtros de la Cascada
$g_dep = isset($_GET['iddepartamento']) ? mysqli_real_escape_string($link, $_GET['iddepartamento']) : '';
$g_mun = isset($_GET['idmunicipio']) ? mysqli_real_escape_string($link, $_GET['idmunicipio']) : '';
$g_est = isset($_GET['idestablecimiento']) ? mysqli_real_escape_string($link, $_GET['idestablecimiento']) : '';
$g_med = isset($_GET['idusuario_medico']) ? mysqli_real_escape_string($link, $_GET['idusuario_medico']) : '';

$filtro_ap = ""; $filtro_r = ""; $filtro_der = "";
if ($g_dep != '') { $filtro_ap .= " AND ap.iddepartamento = '$g_dep' "; $filtro_r .= " AND r.iddepartamento = '$g_dep' "; $filtro_der .= " AND es_receptor.iddepartamento = '$g_dep' "; }
if ($g_mun != '') { $filtro_ap .= " AND ap.idmunicipio = '$g_mun' "; $filtro_r .= " AND r.idmunicipio = '$g_mun' "; $filtro_der .= " AND es_receptor.idmunicipio = '$g_mun' "; }
if ($g_est != '') { $filtro_ap .= " AND ap.idestablecimiento_salud = '$g_est' "; $filtro_r .= " AND r.idestablecimiento_salud = '$g_est' "; $filtro_der .= " AND r.idestablecimiento_receptor = '$g_est' "; }
if ($g_med != '') { $filtro_ap .= " AND ap.idusuario = '$g_med' "; $filtro_r .= " AND r.idusuario = '$g_med' "; $filtro_der .= " AND der.idusuario = '$g_med' "; }

// 2. Estructura de Datos Base (Enero a Diciembre)
$meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
$data_tc = array_fill(0, 12, 0);
$data_tm = array_fill(0, 12, 0);
$data_ref = array_fill(0, 12, 0);
$data_cref = array_fill(0, 12, 0);

// 3. Consultas Agrupadas por Mes (Máximo Rendimiento)
// Teleconsultas
$sql_tc = "SELECT MONTH(ap.fecha_registro) as mes, COUNT(ap.idatencion_psafci) as total FROM atencion_psafci ap WHERE YEAR(ap.fecha_registro) = '$gestion' AND ap.idtipo_atencion = '3' $filtro_ap GROUP BY MONTH(ap.fecha_registro)";
$res_tc = mysqli_query($link, $sql_tc);
if($res_tc) { while($r = mysqli_fetch_assoc($res_tc)) { $data_tc[(int)$r['mes'] - 1] = (int)$r['total']; } }

// Telemetrías (Con Filtro Estricto Intacto)
$sql_tm = "SELECT MONTH(ap.fecha_registro) as mes, COUNT(DISTINCT et.idatencion_psafci, et.idexamen_complementario) as total 
           FROM examen_teleconsulta et INNER JOIN atencion_psafci ap ON et.idatencion_psafci = ap.idatencion_psafci INNER JOIN examen_complementario ec ON et.idexamen_complementario = ec.idexamen_complementario 
           WHERE YEAR(ap.fecha_registro) = '$gestion' AND ap.idtipo_atencion = '4' AND UPPER(ec.examen_complementario) NOT LIKE '%MONITOR DE SIGNOS VITALES%' AND UPPER(ec.examen_complementario) NOT LIKE '%ESTETOSCOPIO DIGITAL%' AND UPPER(ec.examen_complementario) NOT LIKE '%OTRO%' $filtro_ap GROUP BY MONTH(ap.fecha_registro)";
$res_tm = mysqli_query($link, $sql_tm);
if($res_tm) { while($r = mysqli_fetch_assoc($res_tm)) { $data_tm[(int)$r['mes'] - 1] = (int)$r['total']; } }

// Referencias Generadas (Alineado al extracto: Solo Admitidas y Estado 2)
$sql_ref = "SELECT MONTH(r.fecha_registro) as mes, COUNT(DISTINCT r.idreferencia_hc) as total 
            FROM referencia_hc r 
            INNER JOIN deriva_referencia_hc der ON r.idreferencia_hc = der.idreferencia_hc 
            WHERE YEAR(r.fecha_registro) = '$gestion' AND r.idestado_referencia = '2' AND der.admitido = 'SI' $filtro_r 
            GROUP BY MONTH(r.fecha_registro)";
$res_ref = mysqli_query($link, $sql_ref);
if($res_ref){ while($row = mysqli_fetch_assoc($res_ref)){ $data_ref[(int)$row['mes'] - 1] = (int)$row['total']; } }

// Contrarreferencias Efectivizadas (Respuestas - Blindado para evitar duplicidad mensual)
$sql_cref = "SELECT mes, COUNT(idreferencia_hc) as total FROM (
                 SELECT r.idreferencia_hc, MONTH(MIN(der.fecha_deriva)) as mes
                 FROM referencia_hc r 
                 INNER JOIN deriva_referencia_hc der ON r.idreferencia_hc = der.idreferencia_hc 
                 LEFT JOIN establecimiento_salud es_receptor ON r.idestablecimiento_receptor = es_receptor.idestablecimiento_salud 
                 WHERE YEAR(der.fecha_deriva) = '$gestion' AND r.idestado_referencia = '2' AND der.admitido = 'SI' $filtro_der 
                 GROUP BY r.idreferencia_hc
             ) as sub_chart GROUP BY mes";
$res_cref = mysqli_query($link, $sql_cref);
if($res_cref) { while($r = mysqli_fetch_assoc($res_cref)) { $data_cref[(int)$r['mes'] - 1] = (int)$r['total']; } }

// 4. Empaquetado y Envío en formato JSON
$respuesta = [
    'meses' => $meses,
    'series' => [
        'tc' => $data_tc,
        'tm' => $data_tm,
        'ref' => $data_ref,
        'cref' => $data_cref
    ],
    'totales' => [
        'tc' => array_sum($data_tc),
        'tm' => array_sum($data_tm),
        'ref' => array_sum($data_ref),
        'cref' => array_sum($data_cref)
    ],
    'gestion' => $gestion
];

header('Content-Type: application/json');
echo json_encode($respuesta);
exit;
?>