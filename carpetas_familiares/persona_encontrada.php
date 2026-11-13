<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php include("../comun/inc_persona.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

// Misma búsqueda que historias clínicas (comun/inc_persona.php): todas las personas con ese CI;
// complemento y fecha de nacimiento solo ordenan/resaltan.
// POST (desde buscar_persona_cf.php) -> se guarda la búsqueda en un token y se redirige a ?b=token,
// así la página se puede recargar después de corregir datos (ventana de corrección).
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Por CI o, con modo=nombre, por nombres y apellidos (personas sin CI)
    $r = per_buscar_desde_post($link, $_POST, 'cf');
    if ($r['error'] !== '') {
        header("Location:buscar_persona_cf.php?e=" . $r['error']);
        exit();
    }
    $token = per_token_crear($r['ctx']);
    header("Location:persona_encontrada.php?b=" . $token);
    exit();
}

$token = isset($_GET['b']) ? (string)$_GET['b'] : '';
$ctx   = per_token_leer($token);
if ($ctx === null || !isset($ctx['tipo']) || $ctx['tipo'] !== 'cf') {
    header("Location:buscar_persona_cf.php");
    exit();
}
$por_nombre = isset($ctx['modo']) && $ctx['modo'] === 'nombre';
$personas   = per_personas_contexto($link, $ctx);

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

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/jquery-ui.min.css">
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

                <!-- Begin Page Content -->
  
                <body class="bg-gradient-primary">

    <div class="container">
    </br>
        <div class="card o-hidden border-0 shadow-lg my-1">
            <div class="card-body p-0">
<!-- BEGIN aqui va el TITULO de la pagina ---->
                <div class="row">
                    <div class="col-lg-12">
                    <div class="p-3">               
                    <div class="text-center">                          
                    <!-- ?b=: el formulario vuelve con lo que se había escrito -->
                    <a href="buscar_persona_cf.php?b=<?php echo per_h($token); ?>"><h6 class="text-info"><- VOLVER</h6></a>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->


                <div class="col-lg-12">  
                    <div class="p-2"> 

            <?php echo per_encabezado_contexto($ctx, $personas, 'Elija la persona que corresponde para modificar sus datos.', 'info'); ?>

     <!-------- PERSONAS ENCONTRADAS CON EL MISMO CI (tarjeta compartida con historias clínicas: comun/inc_persona.php) --------->

    <?php if ($personas) {
        foreach ($personas as $p) {
            $botones = '<button type="button" class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#modalCorregir' . (int)$p['idnombre'] . '">'
                     . '<span class="icon text-white-50"><i class="fas fa-user-edit"></i></span>'
                     . '<span class="text">MODIFICAR DATOS PERSONALES</span></button>';
            echo per_tarjeta_persona($p, array('color' => 'info', 'ultima_atencion' => false, 'botones' => $botones));
            echo per_modal_correccion($link, $p, $token, 'info');
        }
    } else { ?>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">PERSONA NO ENCONTRADA:</h6>
            </div>
            <div class="card-body">

                <div class="form-group row">                               
                    <div class="col-sm-12">
                    <h6 class="text-danger"><?php
                        if ($por_nombre && !empty($ctx['ci_no_encontrado'])) {
                            echo 'NO EXISTE NINGUNA PERSONA REGISTRADA CON LA CÉDULA ' . (int)$ctx['ci_no_encontrado'] . ' NI CON ESOS NOMBRES Y APELLIDOS';
                        } elseif ($por_nombre) {
                            echo 'NO EXISTE NINGUNA PERSONA REGISTRADA CON ESOS NOMBRES Y APELLIDOS';
                        } else {
                            echo 'EL NÚMERO DE CÉDULA NO SE ENCUENTRA REGISTRADO EN SISTEMA';
                        } ?></h6>
            
                    </div>
                </div>
                <div class="form-group row">                               
                    <div class="col-sm-12">
                    <h6 class="text-danger"></h6>
                    <a href="buscar_persona_cf.php?b=<?php echo per_h($token); ?>"><h6 class="text-info">CONTINUAR -></h6></a>
                    </div>
                </div>
              
            </div>     
        </div> 

            <?php } ?>
             
    <!-------- BUCLE PERSONAS ENCONTRADAS CON CEDULA IGUAL PERO CON DIFERENTE COMPLEMENTO (End) --------->      
    </div>                    
        <!-- END aqui va el comntenido de la pagina ---->
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
<!-- Botón para volver al inicio (sb-admin-2) -->
<a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿ESTA SEGURO DE SALIR?</h5>
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

   
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- scripts para uso de mapas -->

    <!-- scripts para calendario -->
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
        <script>$("#fecha1").datepicker($.datepicker.regional[ "es" ]);</script>

    <!-- Ventanas de corrección compartidas con historias clínicas (comun/inc_persona.php) -->
        <?php echo per_js_complemento(); ?>
        <!-- Resultados de 5 en 5 (antes de per_js_correccion) -->
        <?php echo per_js_paginacion(5); ?>
        <?php echo per_js_correccion('../comun/corregir_persona.php', 'persona_encontrada.php', 'buscar_persona_cf.php'); ?>

</body>
</html>