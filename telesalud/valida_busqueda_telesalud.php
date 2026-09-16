<?php
session_start();
include("../inc.config.php");

$busqueda = isset($_POST['ci']) ? mysqli_real_escape_string($link, trim($_POST['ci'])) : '';

if (empty($busqueda)) {
    header("Location: telesalud_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Validando Búsqueda...</title>
    <!-- Librería de Alertas Premium -->
    <script src="../js/telesalud_js/sweetalert2.js"></script>
    <style>body { background-color: #f8f9fc; font-family: Arial, sans-serif; }</style>
</head>
<body>

<?php
// =========================================================================================
// RUTA 1: BÚSQUEDA POR CÓDIGO DE ATENCIÓN (PSAFCI)
// =========================================================================================
if (strpos(strtoupper($busqueda), 'PSAFCI') !== false) {
    
    $sql = "SELECT ap.idatencion_psafci, ap.idnombre, n.fecha_nac, i.idcarpeta_familiar, i.idintegrante_cf
            FROM atencion_psafci ap
            INNER JOIN nombre n ON ap.idnombre = n.idnombre 
            LEFT JOIN integrante_cf i ON n.idnombre = i.idnombre
            WHERE ap.codigo = '$busqueda' LIMIT 1";
            
    $res = mysqli_query($link, $sql);
    
    if (!$res) {
        $error_db = mysqli_real_escape_string($link, mysqli_error($link));
        echo "<script>
            Swal.fire({ title: 'Error SQL', text: '$error_db', icon: 'error', confirmButtonColor: '#e74a3b' })
            .then(() => { window.location.href = 'telesalud_dashboard.php'; });
        </script>";
        exit();
    }

    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_array($res);
        $edad = 0;
        if (!empty($row['fecha_nac']) && $row['fecha_nac'] != '0000-00-00') {
            $fecha_nac = new DateTime($row['fecha_nac']);
            $edad = (new DateTime())->diff($fecha_nac)->y;
        }

        $_SESSION['idatencion_psafci_ss']       = $row['idatencion_psafci'];
        $_SESSION['idnombre_integrante_ss']     = $row['idnombre'];
        $_SESSION['edad_ss']                    = $edad;
        $_SESSION['idcarpeta_familiar_ss']      = !empty($row['idcarpeta_familiar']) ? $row['idcarpeta_familiar'] : 0;
        $_SESSION['idintegrante_cf_ss']         = !empty($row['idintegrante_cf']) ? $row['idintegrante_cf'] : 0;

        echo "<script>window.location.href='../produccion_servicios/mostrar_atencion_psafci.php';</script>";
        exit();
    } else {
        // ERROR: Código PSAFCI no encontrado -> Alerta y regreso a Central Telesalud
        echo "<script>
            Swal.fire({
                title: 'Atención Médica no encontrada',
                text: 'El código de atención \"$busqueda\" no se encuentra en el sistema.',
                icon: 'warning',
                confirmButtonColor: '#f6c23e',
                confirmButtonText: 'Volver a Central'
            }).then(() => { window.location.href = 'telesalud_dashboard.php'; });
        </script>";
        exit();
    }
}
// =========================================================================================
// RUTA 2: BÚSQUEDA POR CÓDIGO DE REFERENCIA (REF)
// =========================================================================================
elseif (strpos(strtoupper($busqueda), 'REF') !== false) {
    
    $sql_ref = "SELECT r.idreferencia_hc, r.idatencion_psafci, r.idnombre, n.fecha_nac
                FROM referencia_hc r
                INNER JOIN nombre n ON r.idnombre = n.idnombre
                WHERE r.codigo = '$busqueda' LIMIT 1";
                
    $res_ref = mysqli_query($link, $sql_ref);
    
    if (!$res_ref) {
        $error_db = mysqli_real_escape_string($link, mysqli_error($link));
        echo "<script>
            Swal.fire({ title: 'Error SQL', text: '$error_db', icon: 'error', confirmButtonColor: '#e74a3b' })
            .then(() => { window.location.href = 'telesalud_dashboard.php'; });
        </script>";
        exit();
    }

    if (mysqli_num_rows($res_ref) > 0) {
        $row_ref = mysqli_fetch_array($res_ref);
        $edad = 0;
        if (!empty($row_ref['fecha_nac']) && $row_ref['fecha_nac'] != '0000-00-00') {
            $fecha_nac = new DateTime($row_ref['fecha_nac']);
            $edad = (new DateTime())->diff($fecha_nac)->y;
        }

        $_SESSION['idreferencia_hc_ss']         = $row_ref['idreferencia_hc'];
        $_SESSION['idatencion_psafci_ss']       = $row_ref['idatencion_psafci'];
        $_SESSION['idnombre_integrante_ss']     = $row_ref['idnombre'];
        $_SESSION['edad_ss']                    = $edad;

        echo "<script>window.location.href='../referencia_safci/mostrar_referencia_hc.php';</script>";
        exit();
    } else {
        // ERROR: Código REF no encontrado -> Alerta y regreso a Central Telesalud
        echo "<script>
            Swal.fire({
                title: 'Interconsulta no encontrada',
                text: 'El código de referencia \"$busqueda\" no figura en los registros.',
                icon: 'warning',
                confirmButtonColor: '#f6c23e',
                confirmButtonText: 'Volver a Central'
            }).then(() => { window.location.href = 'telesalud_dashboard.php'; });
        </script>";
        exit();
    }
}
// =========================================================================================
// RUTA 3: BÚSQUEDA POR CÉDULA DE IDENTIDAD (Derivación Inteligente)
// =========================================================================================
else {
    $sql_check = "SELECT idnombre FROM nombre WHERE ci = '$busqueda' LIMIT 1";
    $res_check = mysqli_query($link, $sql_check);

    if (mysqli_num_rows($res_check) > 0) {
        // ÉXITO: Paciente encontrado, lo mandamos en silencio por el puente POST
        ?>
        <h3 style="text-align:center; color:#4e73df; margin-top:15%;">Buscando Historial del Paciente...</h3>
        <form id="routerForm" action="../produccion_servicios/valida_cedula_hc.php" method="POST">
            <input type="hidden" name="ci" value="<?php echo htmlspecialchars($busqueda); ?>">
        </form>
        <script>document.getElementById('routerForm').submit();</script>
        <?php
    } else {
        // NUEVO PACIENTE: Alerta con doble opción (Registrar o Verificar)
        ?>
        <script>
            Swal.fire({
                title: 'Paciente No Encontrado',
                html: 'El N° de Cédula <b><?php echo htmlspecialchars($busqueda); ?></b> no figura en el sistema MEDI-APS.<br><br>Verifique el número o proceda a iniciar nuevo registro.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#4e73df',
                cancelButtonColor: '#858796',
                confirmButtonText: '<i class="fas fa-user-plus"></i> Nuevo Registro',
                cancelButtonText: '<i class="fas fa-search"></i> Verificar',
                reverseButtons: true, // Invierte el orden para que "Verificar" quede a la izquierda
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Acción 1: Salto al registro en blanco
                    window.location.href = '../produccion_servicios/atencion_persona_ncf.php';
                } else {
                    // Acción 2: Regreso a la Central Telesalud
                    window.location.href = 'telesalud_dashboard.php';
                }
            });
        </script>
        <?php
    }
}
?>
</body>
</html>