<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php include("../comun/inc_persona.php"); ?>
<?php
/**
 * Resultado de la búsqueda de historia clínica por cédula.
 * Muestra TODAS las personas con el CI buscado (tarjeta compartida con carpetas familiares:
 * comun/inc_persona.php), para confirmar a la persona correcta antes de iniciar la atención,
 * con opción de corregir sus datos (ventana compartida; guarda en comun/corregir_persona.php).
 */
date_default_timezone_set('America/La_Paz');
$gestion = date("Y");

// Las usan menu.php y top_bar.php
$idusuario_ss  = $_SESSION['idusuario_ss'];
$idnombre_ss   = $_SESSION['idnombre_ss'];
$perfil_ss     = $_SESSION['perfil_ss'];

$token = isset($_GET['b']) ? (string)$_GET['b'] : '';
$ctx   = per_token_leer($token);
if ($ctx === null || !isset($ctx['tipo']) || $ctx['tipo'] !== 'hc') {
    header("Location:historias_clinicas.php?e=exp");
    exit();
}

// Se vuelve a consultar (refleja correcciones). Búsqueda por CI o por nombres y apellidos.
$personas   = per_personas_contexto($link, $ctx);
$por_nombre = isset($ctx['modo']) && $ctx['modo'] === 'nombre';
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
    <!-- Estilos del paginador (mismo diseño que las tablas DataTables del sistema) -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <?php echo per_css_tarjetas(); ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include("../menu.php");?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include("../top_bar.php"); ?>
                <!-- End of Topbar -->

    <!-- Mismo armazón que carpetas_familiares/persona_encontrada.php -->
    <div class="container">
    </br>
        <div class="card o-hidden border-0 shadow-lg my-1">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                    <div class="p-3">
                    <div class="text-center">
                    <!-- ?b=: el formulario vuelve con lo que se había escrito -->
                    <a href="historias_clinicas.php?b=<?php echo per_h($token); ?>"><h6 class="text-primary"><- VOLVER</h6></a>
                    <hr>
                    </div>

                <div class="col-lg-12">
                    <div class="p-2">

            <?php echo per_encabezado_contexto($ctx, $personas, 'Confirme que los datos correspondan al paciente antes de iniciar la atención.', 'primary'); ?>

            <?php foreach ($personas as $p) {
                $id = (int)$p['idnombre'];
                $botones = '<form action="valida_cedula_hc.php" method="post" class="d-inline">'
                         . '<input type="hidden" name="b" value="' . per_h($token) . '">'
                         . '<input type="hidden" name="idnombre" value="' . $id . '">'
                         . '<button type="submit" class="btn btn-primary btn-icon-split">'
                         . '<span class="icon text-white-50"><i class="fas fa-stethoscope"></i></span>'
                         . '<span class="text">CONFIRMAR E INICIAR ATENCIÓN</span></button></form>';
                // "Corregir datos" e "Historia clínica": enlaces dentro del recuadro de datos (uno debajo del otro)
                echo per_tarjeta_persona($p, array('color' => 'primary', 'ultima_atencion' => true, 'botones' => $botones,
                                                   'editar' => 'modalCorregir' . $id, 'historia' => true));
                echo per_modal_correccion($link, $p, $token, 'primary');
            } ?>

            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <span class="text-gray-700">¿Ninguna de estas personas es el paciente? <?php echo $por_nombre ? 'Verifique cómo están escritos los nombres y apellidos.' : 'Verifique el número de cédula.'; ?></span>
                    <a href="historias_clinicas.php?b=<?php echo per_h($token); ?>" class="ml-2">Volver a buscar -></a>
                </div>
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
            </div>
        </div>
    </div>

            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

<!-- Botón para volver al inicio (sb-admin-2) -->
<a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">¿ESTA SEGURO DE SALIR?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">Seleccione la opcion Salir para cerrar sesion tendrá que volver a introducir su password.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="../salir.php">Salir de Sistema</a>
            </div>
        </div>
    </div>
</div>

<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../js/sb-admin-2.min.js"></script>
<?php echo per_js_complemento(); ?>
<!-- Resultados de 5 en 5 (antes de per_js_correccion) -->
<?php echo per_js_paginacion(5); ?>
<!-- Ventanas de corrección compartidas con carpetas familiares (comun/inc_persona.php) -->
<?php echo per_js_correccion('../comun/corregir_persona.php', 'persona_encontrada_hc.php', 'historias_clinicas.php?e=exp'); ?>
</body>
</html>
