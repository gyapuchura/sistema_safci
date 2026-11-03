<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
// Catálogos de teleeducación (los mismos que valida el guardado)
include("inc_teleeducacion.php");

date_default_timezone_set('America/La_Paz');
$hoy     = date("Y-m-d");
$gestion = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$h = function ($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); };
$f_corta = function ($f) { $t = strtotime((string)$f); return ($t && $f !== '0000-00-00') ? date('d/m/Y', $t) : ''; };

// Catálogos desde la base de datos (tipos, actividades, modalidades, medios, recursos, grupos y géneros)
$cat = te_catalogos($link);

// Lugar de trabajo actual: define el establecimiento del registro y el municipio del listado
$lugar = te_lugar($link, $idusuario_ss);

// Avisos que devuelven guardar / eliminar
$avisos_ok = [
    'registrado' => 'LA SESIÓN SE REGISTRÓ CORRECTAMENTE CON EL CÓDIGO',
    'modificado' => 'LOS CAMBIOS SE GUARDARON EN LA SESIÓN',
    'eliminado'  => 'SE ELIMINÓ LA SESIÓN',
];
$avisos_error = [
    'sin_lugar'      => 'No encontramos su lugar de trabajo actual. Complete sus datos laborales.',
    'no_existe'      => 'La sesión ya no existe.',
    'fuera_de_plazo' => 'Solo quien registró la sesión puede modificarla o eliminarla, y únicamente dentro del mes de registro.',
    'fecha'          => 'La fecha de la sesión debe ser del mes en curso (del ' . date('01/m/Y') . ' a hoy). No se registran sesiones de meses anteriores.',
    'duracion'       => 'Indique la duración en horas y minutos (minutos de 0 a 59), entre 1 minuto y 24 horas.',
    'asistentes'     => 'Registre al menos 1 participante; los asistentes deben ser números enteros.',
    'recursos'       => 'Seleccione al menos un recurso usado.',
    'datos'          => 'Faltan datos de la actividad o alguna opción no es válida.',
    'guardar'        => 'No se pudo guardar la sesión. Intente nuevamente.',
    'eliminar'       => 'No se pudo eliminar la sesión. Intente nuevamente.',
];
$aviso_ok    = isset($_GET['ok'], $avisos_ok[$_GET['ok']]) ? $avisos_ok[$_GET['ok']] : '';
$aviso_error = isset($_GET['error'], $avisos_error[$_GET['error']]) ? $avisos_error[$_GET['error']] : '';
$aviso_cod   = isset($_GET['codigo']) ? (string)$_GET['codigo'] : '';

// Modo modificación (?editar=ID): solo quien la registró y dentro del mes de registro
$editar = null;
if (isset($_GET['editar']) && $lugar) {
    $editar = te_leer($link, $_GET['editar']);
    if (!$editar) { $aviso_error = $avisos_error['no_existe']; }
    elseif (!te_editable($editar, $idusuario_ss)) { $aviso_error = $avisos_error['fuera_de_plazo']; $editar = null; }
}
// Valores para precargar el formulario (modo modificación)
$ed_tipo = $editar ? (int)$editar['idtipo_teleeducacion'] : 0;
$ed_val  = function ($campo) use ($editar) { return $editar ? (int)$editar[$campo] : 0; };
$ed_num  = function ($idgrupo, $idgenero) use ($editar) {
    return $editar && !empty($editar['grupos'][$idgrupo][$idgenero]) ? (string)$editar['grupos'][$idgrupo][$idgenero] : '';
};

// Sesiones registradas en el municipio del usuario
$sesiones = [];
if ($lugar) {
    $mun = (int)$lugar['idmunicipio'];
    $res = mysqli_query($link, "SELECT t.idteleeducacion, t.codigo, t.fecha_sesion, t.idtipo_teleeducacion, t.idactividad_teleeducacion, t.nombre_actividad,
            t.idmodalidad_teleeducacion, t.duracion_minutos, t.asistentes, t.fecha_registro, t.hora_registro, t.idusuario,
            es.establecimiento_salud, n.nombre, n.paterno, n.materno
        FROM teleeducacion t
        INNER JOIN establecimiento_salud es ON es.idestablecimiento_salud = t.idestablecimiento_salud
        INNER JOIN usuarios u ON u.idusuario = t.idusuario
        INNER JOIN nombre n ON n.idnombre = u.idnombre
        WHERE t.idmunicipio = '$mun'
        ORDER BY t.idteleeducacion DESC");
    if ($res) { while ($r = mysqli_fetch_assoc($res)) { $sesiones[] = $r; } }
}

// Tipos que se ofrecen en el formulario: los activos (y el de la sesión que se modifica)
$tipos_form = te_opciones($cat['tipos'], $ed_tipo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SISTEMA MEDI-SAFCI</title>

    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style>
        .badge-warning { background-color: #f6c23e !important; color: #3a3b45 !important; border: 1px solid white;}
        .caja-recursos { transition: border 0.3s ease-in-out; }
        /* Tabla UX para asistentes */
        .tabla-asistentes th { background-color: #f8f9fc; }
        .tabla-asistentes td { vertical-align: middle !important; }
        .fila-subdivision { background-color: #fdfdfd; }
        /* Colores sutiles para género */
        .input-masc { background-color: #e3f2fd !important; }
        .input-fem { background-color: #fce4ec !important; }
        /* Campos con error */
        .form-control.is-invalid { border: 2px solid #dc3545 !important; background-image: none; }
        .caja-invalida { border: 2px solid #dc3545 !important; }
        .asterisco-req { color: #e74a3b; font-size: 1.1em; font-weight: bold; }
        .acciones-tabla { display: flex; flex-wrap: wrap; gap: 4px; justify-content: center; }
        .acciones-tabla form { margin: 0; }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include("../menu.php");?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include("../top_bar.php"); ?>

                <div class="container">
                </br>
                    <div class="card o-hidden border-0 shadow-lg my-1">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-12">
                                <div class="p-3">
                                <div class="text-center">
                                <hr>
                                <h2 class="text-primary">REGISTRO DE TELEEDUCACIÓN</h2>
                                <?php if ($lugar) { ?>
                                <h6 class="text-secondary"><?php echo $h(mb_strtoupper($lugar['establecimiento_salud'])); ?> · <?php echo $h(mb_strtoupper((string)$lugar['municipio'])); ?></h6>
                                <?php } ?>
                                <hr>
                                </div>

                                <?php if ($aviso_ok !== '') { ?>
                                <div class="alert alert-success text-center" role="status"><i class="fas fa-check-circle"></i> <?php echo $h($aviso_ok); ?> <b><?php echo $h($aviso_cod); ?></b></div>
                                <?php } ?>
                                <?php if ($aviso_error !== '') { ?>
                                <div class="alert alert-danger text-center" role="alert"><i class="fas fa-exclamation-circle"></i> <?php echo $h($aviso_error); ?></div>
                                <?php } ?>

                                <?php if (!$lugar) { ?>
                                <div class="text-center p-4">
                                    <h5 class="text-danger">COMPLETE SUS DATOS LABORALES</h5>
                                    <p>Para registrar teleeducación necesitamos conocer su establecimiento de trabajo actual.</p>
                                    <a href="../recursos_humanos/datos_laborales_individual.php" class="btn btn-primary">COMPLETAR DATOS LABORALES</a>
                                </div>
                                <?php } else { ?>

                                <form name="GUARDA_TELEEDUCACION" id="form-teleeducacion" action="guarda_teleeducacion.php" method="post" novalidate>

                                    <?php if ($editar) { ?>
                                    <input type="hidden" name="idteleeducacion" value="<?php echo (int)$editar['idteleeducacion']; ?>">
                                    <div class="alert alert-warning d-flex align-items-center justify-content-between">
                                        <span><i class="fas fa-pen"></i> ESTÁ MODIFICANDO LA SESIÓN <b><?php echo $h($editar['codigo']); ?></b> (puede hacerlo hasta el <?php echo date('t/m/Y'); ?>)</span>
                                        <a href="teleeducacion.php" class="btn btn-sm btn-secondary">CANCELAR</a>
                                    </div>
                                    <?php } ?>

                                    <!-- Errores de validación -->
                                    <div class="alert alert-danger d-none" id="te-alerta" role="alert">
                                        <b>REVISE LOS CAMPOS MARCADOS:</b>
                                        <ul class="mb-0" id="te-alerta-lista"></ul>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="p-3">

                                            <div class="text-center">
                                                <div class="form-group row text-left">
                                                    <div class="col-sm-4">
                                                        <h6 class="text-danger font-weight-bold"><i class="fas fa-list"></i> TIPO DE TELEEDUCACIÓN: <span class="asterisco-req">*</span></h6>
                                                        <select name="idtipo_teleeducacion" id="tipo_teleeducacion" class="form-control border-left-danger te-req" data-nombre="Tipo de teleeducación">
                                                            <option value="">ELEGIR</option>
                                                            <?php foreach ($tipos_form as $idt => $t) { ?>
                                                            <option value="<?php echo $idt; ?>"<?php echo $ed_tipo === $idt ? ' selected' : ''; ?>><?php echo $h(mb_strtoupper($t['nombre'])); ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <h6 class="text-primary"><i class="fas fa-calendar"></i> FECHA DE SESIÓN: <span class="asterisco-req">*</span></h6>
                                                        <input type="date" name="fecha_sesion" id="fecha_sesion" class="form-control te-req" min="<?php echo te_mes_desde(); ?>" max="<?php echo $hoy; ?>" value="<?php echo $editar ? $h($editar['fecha_sesion']) : ''; ?>" data-nombre="Fecha de sesión">
                                                        <small class="text-muted">Solo sesiones del mes en curso</small>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <h6 class="text-primary"><i class="fas fa-clock"></i> DURACIÓN: <span class="asterisco-req">*</span></h6>
                                                        <div class="input-group">
                                                            <input type="number" name="duracion_horas" id="duracion_horas" class="form-control text-center" min="0" max="24" step="1" inputmode="numeric" placeholder="0"
                                                                   value="<?php echo $editar ? intdiv((int)$editar['duracion_minutos'], 60) : ''; ?>" aria-label="Horas">
                                                            <div class="input-group-append input-group-prepend"><span class="input-group-text">h</span></div>
                                                            <input type="number" name="duracion_minutos" id="duracion_minutos" class="form-control text-center" min="0" max="59" step="1" inputmode="numeric" placeholder="0"
                                                                   value="<?php echo $editar ? (int)$editar['duracion_minutos'] % 60 : ''; ?>" aria-label="Minutos">
                                                            <div class="input-group-append"><span class="input-group-text">min</span></div>
                                                        </div>
                                                        <small class="text-muted">Ej.: 1 h 59 min. Minutos de 0 a 59.</small>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>

                                            <?php foreach ($tipos_form as $idt => $tp) {
                                                $color = preg_replace('/[^a-z]/', '', $tp['color']);                // clase de color de Bootstrap (info, success...)
                                                $es_bloque = $ed_tipo === $idt;                                      // bloque de la sesión que se modifica
                                                $con_datos = $es_bloque ? array_keys($editar['grupos']) : [];       // grupos con datos (se muestran aunque estén desactivados)
                                                $filas = te_filas_grupos($cat, $idt, true, $con_datos); ?>
                                            <!-- =================================================== -->
                                            <!-- BLOQUE <?php echo $h($tp['nombre']); ?> (se genera desde tipo_teleeducacion) -->
                                            <!-- =================================================== -->
                                            <div id="bloque_tipo_<?php echo $idt; ?>" class="te-bloque" data-tipo="<?php echo $idt; ?>" data-recursos="<?php echo $tp['requiere_recursos'] ? 'SI' : 'NO'; ?>" style="display: none;">
                                                <div class="form-group row">
                                                    <div class="col-sm-3">
                                                        <h6 class="text-<?php echo $color; ?> font-weight-bold">TIPO DE ACTIVIDAD: <span class="asterisco-req">*</span></h6>
                                                        <select name="idactividad_teleeducacion" class="form-control te-req" data-nombre="Tipo de actividad">
                                                            <option value="">ELEGIR</option>
                                                            <?php foreach (te_opciones($cat['actividades'], $es_bloque ? $ed_val('idactividad_teleeducacion') : null, $idt) as $ida => $a) { ?><option value="<?php echo $ida; ?>"<?php echo $es_bloque && $ed_val('idactividad_teleeducacion') === $ida ? ' selected' : ''; ?>><?php echo $h($a['nombre']); ?></option><?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <h6 class="text-<?php echo $color; ?> font-weight-bold">NOMBRE DE LA ACTIVIDAD: <span class="asterisco-req">*</span></h6>
                                                        <input type="text" name="nombre_actividad" class="form-control te-req" maxlength="250" value="<?php echo $es_bloque ? $h($editar['nombre_actividad']) : ''; ?>" data-nombre="Nombre de la actividad">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <h6 class="text-<?php echo $color; ?> font-weight-bold">MODALIDAD: <span class="asterisco-req">*</span></h6>
                                                        <select name="idmodalidad_teleeducacion" class="form-control te-req" data-nombre="Modalidad">
                                                            <option value="">ELEGIR</option>
                                                            <?php foreach (te_opciones($cat['modalidades'], $es_bloque ? $ed_val('idmodalidad_teleeducacion') : null) as $idm => $m) { ?><option value="<?php echo $idm; ?>"<?php echo $es_bloque && $ed_val('idmodalidad_teleeducacion') === $idm ? ' selected' : ''; ?>><?php echo $h($m['nombre']); ?></option><?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <h6 class="text-<?php echo $color; ?> font-weight-bold">MEDIO DIGITAL: <span class="asterisco-req">*</span></h6>
                                                        <select name="idmedio_digital" class="form-control te-req" data-nombre="Medio digital">
                                                            <option value="">ELEGIR</option>
                                                            <?php foreach (te_opciones($cat['medios'], $es_bloque ? $ed_val('idmedio_digital') : null) as $idd => $d) { ?><option value="<?php echo $idd; ?>"<?php echo $es_bloque && $ed_val('idmedio_digital') === $idd ? ' selected' : ''; ?>><?php echo $h($d['nombre']); ?></option><?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <?php if ($tp['requiere_recursos']) {
                                                    $recursos_form = $cat['recursos'];
                                                    foreach ($recursos_form as $idr => $r) { if (!$r['activo'] && !($es_bloque && in_array($idr, $editar['recursos'], true))) { unset($recursos_form[$idr]); } } ?>
                                                <!-- RECURSOS USADOS (selección múltiple) -->
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <h6 class="text-<?php echo $color; ?> font-weight-bold">RECURSOS USADOS <small class="text-dark">(Selección múltiple)</small>: <span class="asterisco-req">*</span></h6>
                                                        <div class="row border-left-<?php echo $color; ?> bg-light rounded py-3 px-2 shadow-sm caja-recursos" tabindex="-1">
                                                            <?php foreach (array_chunk($recursos_form, (int)ceil(count($recursos_form) / 3), true) as $columna) { ?>
                                                            <div class="col-md-4">
                                                                <?php foreach ($columna as $idr => $r) { $id_chk = 'chk_' . $idt . '_' . $idr; ?>
                                                                <div class="custom-control custom-checkbox mb-2">
                                                                    <input type="checkbox" class="custom-control-input chk-medio" id="<?php echo $id_chk; ?>" name="recursos[]" value="<?php echo $idr; ?>"<?php echo $es_bloque && in_array($idr, $editar['recursos'], true) ? ' checked' : ''; ?>>
                                                                    <label class="custom-control-label text-dark" for="<?php echo $id_chk; ?>"><?php echo $h($r['nombre']); ?></label>
                                                                </div>
                                                                <?php } ?>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>

                                                <!-- PARTICIPANTES POR GRUPO Y GÉNERO -->
                                                <h6 class="text-<?php echo $color; ?> mt-4 font-weight-bold border-bottom-<?php echo $color; ?> pb-2">
                                                    <i class="fas fa-users"></i> <?php echo $h($tp['titulo_asistentes']); ?>
                                                    <small class="text-danger">(Mínimo 1 participante requerido)</small>
                                                    <span class="badge badge-warning text-dark ml-2 d-none span-total shadow-sm" style="font-size: 0.85em;"></span>
                                                </h6>

                                                <?php
                                                // Celdas de captura de un grupo: una por género (tabla genero del sistema)
                                                $celdas = function ($g) use ($cat, $es_bloque, $ed_num) {
                                                    $html = '';
                                                    foreach ($cat['generos'] as $idg => $gen) {
                                                        $clase = $gen === 'MASCULINO' ? 'input-masc' : ($gen === 'FEMENINO' ? 'input-fem' : '');
                                                        $html .= '<td><input type="number" name="asistentes[' . $g['id'] . '][' . $idg . ']" data-genero="' . $idg . '" class="form-control form-control-sm text-center te-num ' . $clase . '" min="0" step="1"'
                                                            . ' value="' . ($es_bloque ? $ed_num($g['id'], $idg) : '') . '"></td>';
                                                    }
                                                    return $html;
                                                };
                                                // Dos columnas solo si el tipo lo pide y no tiene encabezados
                                                $dos_columnas = $tp['columnas'] >= 2 && !array_filter($filas, function ($f) { return $f['nivel'] === 'encabezado'; });
                                                ?>
                                                <?php if ($dos_columnas) { list($izq, $der) = array_pad(array_chunk($filas, (int)ceil(count($filas) / 2)), 2, []); ?>
                                                <div class="table-responsive caja-asistentes mb-4">
                                                    <table class="table table-bordered table-sm text-center mb-0">
                                                        <thead class="bg-light text-<?php echo $color; ?>">
                                                            <tr>
                                                                <?php for ($c = 0; $c < 2; $c++) { ?><th><?php echo $h($tp['etiqueta_grupo']); ?></th><?php foreach ($cat['generos'] as $gen) { ?><th><?php echo $h($gen); ?></th><?php } } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php foreach ($izq as $i => $f1) { ?>
                                                            <tr>
                                                                <?php foreach ([$f1, isset($der[$i]) ? $der[$i] : null] as $f) {
                                                                    if ($f === null) { ?><td colspan="<?php echo 1 + count($cat['generos']); ?>"></td><?php continue; } ?>
                                                                <td class="align-middle"><?php echo $h($f['g']['nombre']); ?></td><?php echo $celdas($f['g']); ?>
                                                                <?php } ?>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <?php } else { ?>
                                                <div class="table-responsive shadow-sm rounded mb-4 caja-asistentes">
                                                    <table class="table table-bordered table-sm text-center mb-0 text-dark tabla-asistentes">
                                                        <thead class="text-<?php echo $color; ?> border-bottom-<?php echo $color; ?>">
                                                            <tr>
                                                                <th class="text-left align-middle" style="width: 70%;"><i class="fas fa-briefcase"></i> <?php echo $h($tp['etiqueta_grupo']); ?></th>
                                                                <?php foreach ($cat['generos'] as $gen) { ?><th class="align-middle" style="width: <?php echo round(30 / max(1, count($cat['generos']))); ?>%;"><?php echo $h($gen); ?></th><?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php foreach ($filas as $f) { $g = $f['g'];
                                                            if ($f['nivel'] === 'encabezado') { ?>
                                                            <tr class="bg-light">
                                                                <td colspan="<?php echo 1 + count($cat['generos']); ?>" class="text-left font-weight-bold text-<?php echo $color; ?>"><i class="fas fa-users"></i> <?php echo $h(mb_strtoupper($g['nombre'])); ?></td>
                                                            </tr>
                                                            <?php } elseif ($f['nivel'] === 'sub') { ?>
                                                            <tr class="fila-subdivision">
                                                                <td class="text-left pl-4 font-weight-bold text-secondary"><i class="fas fa-angle-right fa-sm"></i> <?php echo $h($g['nombre']); ?></td><?php echo $celdas($g); ?>
                                                            </tr>
                                                            <?php } else { ?>
                                                            <tr>
                                                                <td class="text-left font-weight-bold text-<?php echo $color; ?>"><i class="fas fa-user"></i> <?php echo $h(mb_strtoupper($g['nombre'])); ?></td><?php echo $celdas($g); ?>
                                                            </tr>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <?php } ?>

                                            <br>
                                            <div class="text-center">
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <button type="button" class="btn btn-primary" id="btn-registrar">
                                                            <?php echo $editar ? 'GUARDAR CAMBIOS' : 'REGISTRAR INFORMACIÓN VIRTUAL'; ?>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">REGISTRO DE TELEEDUCACIÓN</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <div class="modal-body text-left">
                                                                <p><?php echo $editar ? '¿Está seguro de GUARDAR LOS CAMBIOS de esta actividad de teleeducación?' : '¿Está seguro de GUARDAR ESTA ACTIVIDAD DE TELEEDUCACIÓN?'; ?></p>
                                                                <table class="table table-sm table-bordered mb-0 small" id="resumen-conf"></table>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                                                <button type="button" id="btn-confirmar-teleeducacion" class="btn btn-info">CONFIRMAR</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                                <?php } ?>

                                </div>
                                </div>
                            </div>

                            <div class="text-center">
                            <hr>
                                <a class="small" href="#">PROGRAMA SAFCI - MI SALUD</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="#">Ministerio de Salud y Deportes</a>
                            <hr>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- FIN SECCIÓN DE REGISTRO -->

                <?php if ($lugar) { ?>
                <!-- ========================================================= -->
                <!-- SECCIÓN DE SESIONES REGISTRADAS (ancho completo, como en atenciones_psafci.php) -->
                <!-- ========================================================= -->
                <div class="container-fluid mt-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">SESIONES DE TELEEDUCACIÓN REGISTRADAS EN SU MUNICIPIO</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>CÓDIGO</th>
                                            <th>ESTABLECIMIENTO</th>
                                            <th>FECHA DE SESIÓN</th>
                                            <th>TIPO</th>
                                            <th>ACTIVIDAD</th>
                                            <th>MODALIDAD</th>
                                            <th>DURACIÓN (h:min)</th>
                                            <th>N° ASISTENTES</th>
                                            <th>MÉDICO REGISTRADOR</th>
                                            <th>FECHA Y HORA DE REGISTRO</th>
                                            <th>OPCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($sesiones as $i => $s) {
                                        $tipo_s = isset($cat['tipos'][(int)$s['idtipo_teleeducacion']]) ? $cat['tipos'][(int)$s['idtipo_teleeducacion']] : ['nombre' => '', 'color' => 'secondary'];
                                        $propia = (string)$s['idusuario'] === (string)$idusuario_ss;
                                        $editable = te_editable($s, $idusuario_ss); ?>
                                        <tr>
                                            <!-- El código abre la ficha en una ventana aparte (igual que VER y que atenciones_psafci.php) -->
                                            <td class="align-middle font-weight-bold" data-order="<?php echo (int)$s['idteleeducacion']; ?>">
                                                <a href="imprime_teleeducacion.php?idteleeducacion=<?php echo (int)$s['idteleeducacion']; ?>" target="_blank" title="Ver la ficha de la sesión"
                                                   onClick="window.open(this.href, this.target, 'width=800,height=900,top=50, left=200, scrollbars=YES'); return false;"><?php echo $s['codigo'] !== '' ? $h($s['codigo']) : 'S/D'; ?></a>
                                            </td>
                                            <td class="align-middle"><?php echo $h($s['establecimiento_salud']); ?></td>
                                            <td class="align-middle" data-order="<?php echo $h($s['fecha_sesion']); ?>"><?php echo $h($f_corta($s['fecha_sesion'])); ?></td>
                                            <td class="align-middle font-weight-bold text-<?php echo $h(preg_replace('/[^a-z]/', '', $tipo_s['color'])); ?>"><?php echo $h($tipo_s['nombre']); ?></td>
                                            <td class="align-middle"><?php echo $h(te_nombre($cat['actividades'], $s['idactividad_teleeducacion'])); ?><br><small class="text-muted"><?php echo $h($s['nombre_actividad']); ?></small></td>
                                            <td class="align-middle"><?php echo $h(te_nombre($cat['modalidades'], $s['idmodalidad_teleeducacion'])); ?></td>
                                            <td class="align-middle" data-order="<?php echo (int)$s['duracion_minutos']; ?>"><?php echo $h(te_hm($s['duracion_minutos'])); ?></td>
                                            <td class="align-middle font-weight-bold text-dark"><?php echo (int)$s['asistentes']; ?></td>
                                            <td class="align-middle"><?php echo $h(mb_strtoupper($s['nombre'] . " " . $s['paterno'] . " " . $s['materno'])); ?></td>
                                            <td class="align-middle" data-order="<?php echo $h($s['fecha_registro'] . ' ' . $s['hora_registro']); ?>"><?php echo $h($f_corta($s['fecha_registro'])); ?> - <?php echo $h($s['hora_registro']); ?></td>
                                            <td class="align-middle">
                                            <?php if ($propia) { ?>
                                                <div class="acciones-tabla">
                                                    <!-- Se abre en una ventana aparte, igual que imprime_atencion_psafci.php -->
                                                    <a href="imprime_teleeducacion.php?idteleeducacion=<?php echo (int)$s['idteleeducacion']; ?>" target="_blank" class="btn btn-primary btn-icon-split btn-sm" title="Ver e imprimir"
                                                       onClick="window.open(this.href, this.target, 'width=800,height=900,top=50, left=200, scrollbars=YES'); return false;">
                                                        <span class="icon text-white-50"><i class="fas fa-eye"></i></span>
                                                        <span class="text">VER</span>
                                                    </a>
                                                    <?php if ($editable) { ?>
                                                    <a href="teleeducacion.php?editar=<?php echo (int)$s['idteleeducacion']; ?>" class="btn btn-warning btn-sm" title="Modificar (hasta el <?php echo date('t/m/Y'); ?>)"><i class="fas fa-pen"></i></a>
                                                    <button type="button" class="btn btn-danger btn-sm btn-eliminar" title="Eliminar (hasta el <?php echo date('t/m/Y'); ?>)" data-id="<?php echo (int)$s['idteleeducacion']; ?>" data-codigo="<?php echo $h($s['codigo']); ?>"><i class="fas fa-trash-alt"></i></button>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- FIN DATATABLE -->
                        </div>
                    </div>
                </div>

                            <!-- Modal para eliminar -->
                            <div class="modal fade" id="modal-eliminar" tabindex="-1" role="dialog" aria-labelledby="modal-eliminar-titulo" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form class="modal-content" action="elimina_teleeducacion.php" method="post">
                                        <input type="hidden" name="idteleeducacion" id="eliminar-id" value="">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modal-eliminar-titulo">ELIMINAR SESIÓN DE TELEEDUCACIÓN</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body text-left">¿Está seguro de ELIMINAR la sesión <b id="eliminar-codigo"></b> con todos sus participantes? Esta acción no se puede deshacer.</div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                            <button type="submit" class="btn btn-danger">ELIMINAR</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                <?php } ?>

                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="logoutModalLabel">¿ESTA SEGURO DE SALIR?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Seleccione la opcion Salir para cerrar sesion tendrá que volver a introducir su password.</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <a class="btn btn-primary" href="../salir.php">Salir de Sistema</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- LIBRERÍAS: jQuery una sola vez, antes de Bootstrap y DataTables -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
    $(function () {
        // Listado (DataTables en español)
        $('#example').DataTable({
            order: [],
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            columnDefs: [{ orderable: false, targets: -1 }],
            language: {
                lengthMenu: "Mostrar _MENU_ registros por pagina", zeroRecords: "No se encontraron resultados en su busqueda", searchPlaceholder: "Buscar registros",
                info: "Mostrando Registros de _START_ al _END_ de un total de  _TOTAL_ Registros", infoEmpty: "No existen Registros", emptyTable: "No existen Registros",
                infoFiltered: "(filtrado de un total de _MAX_ Registros)", search: "Buscar:",
                paginate: { first: "Primero", last: "Último", next: "Siguiente", previous: "Anterior" }
            }
        });

        // Eliminar: confirma con el código (delegado: funciona en todas las páginas de la tabla)
        $('#example').on('click', '.btn-eliminar', function () {
            $('#eliminar-id').val(this.getAttribute('data-id'));
            $('#eliminar-codigo').text(this.getAttribute('data-codigo'));
            $('#modal-eliminar').modal('show');
        });

        var form = document.getElementById('form-teleeducacion');
        if (!form) { return; } // sin lugar de trabajo: no hay formulario
        var $form = $(form);
        var $btnConfirmar = $('#btn-confirmar-teleeducacion');
        var confirmado = false;

        function bloqueActivo() { return $form.find('.te-bloque[data-tipo="' + $('#tipo_teleeducacion').val() + '"]'); }

        // Muestra el bloque del tipo elegido. Los campos del otro bloque se DESHABILITAN:
        // así no viajan al servidor aunque se hayan llenado antes de cambiar de tipo.
        function mostrarBloque(animar) {
            var tipo = $('#tipo_teleeducacion').val();
            $form.find('.te-bloque').each(function () {
                var activo = this.getAttribute('data-tipo') === tipo;
                $(this).find('input, select').prop('disabled', !activo);
                if (activo) { animar ? $(this).fadeIn(300) : $(this).show(); } else { $(this).hide(); }
            });
            limpiarErrores();
            actualizarTotales();
        }

        // Géneros de la tabla genero del sistema: [id, inicial] en el orden de las columnas
        var generos = <?php echo json_encode(array_map(function ($id, $nom) { return [$id, te_genero_corto($nom)]; }, array_keys($cat['generos']), $cat['generos'])); ?>;

        // Total de asistentes en tiempo real, por género, en todos los bloques
        function valorEntero(el) { var v = $.trim(el.value); return /^\d+$/.test(v) ? parseInt(v, 10) : 0; }

        // Duración en minutos (horas * 60 + minutos) y en texto: 119 -> "1 hora 59 minutos"
        function minutosDuracion() { return valorEntero(document.getElementById('duracion_horas')) * 60 + valorEntero(document.getElementById('duracion_minutos')); }
        function textoDuracion(min) {
            var h = Math.floor(min / 60), m = min % 60, partes = [];
            if (h > 0) { partes.push(h + (h === 1 ? ' hora' : ' horas')); }
            if (m > 0 || h === 0) { partes.push(m + (m === 1 ? ' minuto' : ' minutos')); }
            return partes.join(' ');
        }
        function actualizarTotales() {
            var activo = 0;
            $form.find('.te-bloque').each(function () {
                var total = 0, partes = [], $bloque = $(this);
                $.each(generos, function (i, g) {
                    var n = 0;
                    $bloque.find('.te-num[data-genero="' + g[0] + '"]').each(function () { n += valorEntero(this); });
                    total += n; partes.push(n + ' ' + g[1]);
                });
                var $badge = $bloque.find('.span-total');
                if (total > 0) { $badge.text('Total: ' + total + ' asistentes (' + partes.join(' · ') + ')').removeClass('d-none'); } else { $badge.addClass('d-none'); }
                if (this.getAttribute('data-tipo') === $('#tipo_teleeducacion').val()) { activo = total; }
            });
            return activo;
        }

        function limpiarErrores() {
            $form.find('.is-invalid').removeClass('is-invalid');
            $form.find('.caja-invalida').removeClass('caja-invalida');
            $('#te-alerta').addClass('d-none');
        }

        // Validación completa antes de pedir la confirmación
        function validar() {
            limpiarErrores();
            var errores = [], primero = null;
            var marcar = function (el, clase, texto) { $(el).addClass(clase); if (texto) { errores.push(texto); } if (!primero) { primero = el; } };

            $form.find('.te-req:visible').each(function () {
                if ($.trim(this.value) === '') { marcar(this, 'is-invalid', 'Complete: ' + this.getAttribute('data-nombre') + '.'); }
            });

            var fecha = document.getElementById('fecha_sesion');
            if (fecha.value && (fecha.value > fecha.max || fecha.value < fecha.min)) {
                marcar(fecha, 'is-invalid', 'La fecha de la sesión debe ser del mes en curso (del ' + fecha.min.split('-').reverse().join('/') + ' a hoy).');
            }

            // Duración: horas enteras (0 a 24) y minutos (0 a 59); en total entre 1 minuto y 24 horas
            var durH = document.getElementById('duracion_horas'), durM = document.getElementById('duracion_minutos');
            var vh = $.trim(durH.value), vm = $.trim(durM.value);
            if (vh === '' && vm === '') {
                marcar(durH, 'is-invalid', 'Complete: Duración (horas y/o minutos).'); $(durM).addClass('is-invalid');
            } else if ((vh !== '' && !/^\d+$/.test(vh)) || (vm !== '' && !/^\d+$/.test(vm)) || parseInt(vm || '0', 10) > 59 || parseInt(vh || '0', 10) > 24
                       || minutosDuracion() < 1 || minutosDuracion() > 1440) {
                marcar(durH, 'is-invalid', 'La duración debe tener horas enteras y minutos de 0 a 59 (ej.: 1 h 59 min), entre 1 minuto y 24 horas.'); $(durM).addClass('is-invalid');
            }

            var $b = bloqueActivo();
            if ($b.length) {
                if ($b.attr('data-recursos') === 'SI' && $b.find('.chk-medio:checked').length === 0) {
                    marcar($b.find('.caja-recursos')[0], 'caja-invalida', 'Seleccione al menos un recurso usado.');
                }
                var malos = $b.find('.te-num').filter(function () { return $.trim(this.value) !== '' && !/^\d+$/.test($.trim(this.value)); });
                if (malos.length) {
                    malos.each(function () { marcar(this, 'is-invalid', ''); });
                    errores.push('Los asistentes deben ser números enteros, sin decimales ni negativos.');
                } else if (actualizarTotales() < 1) {
                    $b.find('.te-num').addClass('is-invalid');
                    marcar($b.find('.te-num')[0], 'is-invalid', 'Registre al menos 1 participante.');
                }
            }

            if (errores.length) {
                $('#te-alerta-lista').html($.map(errores, function (e) { return $('<li>').text(e).prop('outerHTML'); }).join(''));
                $('#te-alerta').removeClass('d-none');
                primero.scrollIntoView({ behavior: 'smooth', block: 'center' });
                if (/^(INPUT|SELECT)$/.test(primero.tagName)) { setTimeout(function () { primero.focus({ preventScroll: true }); }, 300); }
            }
            return errores.length === 0;
        }

        // Resumen de lo que se va a guardar
        function llenarResumen() {
            var $b = bloqueActivo();
            var texto = function (sel) { var el = $b.find(sel)[0]; return el && el.selectedIndex > 0 ? el.options[el.selectedIndex].text : ''; };
            var tipo = document.getElementById('tipo_teleeducacion');
            var filas = [
                ['Tipo', tipo.options[tipo.selectedIndex].text],
                ['Actividad', texto('[name="idactividad_teleeducacion"]') + ' - ' + $.trim($b.find('[name="nombre_actividad"]').val())],
                ['Fecha de sesión', document.getElementById('fecha_sesion').value.split('-').reverse().join('/')],
                ['Duración', textoDuracion(minutosDuracion())],
                ['Modalidad / medio', texto('[name="idmodalidad_teleeducacion"]') + ' / ' + texto('[name="idmedio_digital"]')],
                ['Participantes', actualizarTotales()]
            ];
            $('#resumen-conf').html($.map(filas, function (f) { return '<tr>' + $('<th class="bg-light">').text(f[0]).prop('outerHTML') + $('<td>').text(f[1]).prop('outerHTML') + '</tr>'; }).join(''));
        }

        $('#tipo_teleeducacion').on('change', function () { mostrarBloque(true); });
        $form.on('input change', '.te-num', actualizarTotales);

        // Al corregir un campo se quita su marca roja
        $form.on('input change', 'input, select', function () {
            if ($.trim(this.value) !== '') { $(this).removeClass('is-invalid'); }
            if (this.id === 'duracion_horas' || this.id === 'duracion_minutos') { $('#duracion_horas, #duracion_minutos').removeClass('is-invalid'); }
            if ($(this).hasClass('chk-medio')) { $(this).closest('.caja-recursos').removeClass('caja-invalida'); }
            if ($(this).hasClass('te-num') && valorEntero(this) > 0) { bloqueActivo().find('.te-num').removeClass('is-invalid'); }
        });

        // Paso 1: validar y, si todo está bien, pedir confirmación
        $('#btn-registrar').on('click', function () {
            if (validar()) { llenarResumen(); $('#exampleModal').modal('show'); }
        });

        // Paso 2: confirmar y enviar una sola vez
        $btnConfirmar.on('click', function () {
            if (confirmado || !validar()) { $('#exampleModal').modal('hide'); return; }
            confirmado = true;
            $btnConfirmar.prop('disabled', true).text('GUARDANDO...');
            form.submit();
        });

        // La tecla Enter no envía el formulario sin validar y confirmar
        $form.on('submit', function (e) { if (!confirmado) { e.preventDefault(); $('#btn-registrar').trigger('click'); } });

        // Estado inicial (modo modificación o al volver con "Atrás")
        mostrarBloque(false);
        window.addEventListener('pageshow', function () { confirmado = false; $btnConfirmar.prop('disabled', false).text('CONFIRMAR'); mostrarBloque(false); });
    });
    </script>
</body>
</html>
