<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$ci_buscado  = isset($_GET['ci']) ? (int)$_GET['ci'] : 0;   // CI que no se encontró (valida_cedula_hc.php)
$por_nombre  = isset($_GET['nom']);                          // búsqueda por nombres y apellidos sin resultados
// Token de la búsqueda: "volver" muestra el formulario con lo que se había escrito
$volver = 'historias_clinicas.php' . (isset($_GET['b']) && preg_match('/^[a-f0-9]{32}$/', (string)$_GET['b']) ? '?b=' . $_GET['b'] : '');

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
        <div class="card o-hidden border-0 shadow-lg my-2">
            <div class="card-body p-0">
<!-- BEGIN aqui va el TITULO de la pagina ---->
                <div class="row">
                    <div class="col-lg-12">
                    <div class="p-3">               
                    <div class="text-center">   
                    
                    <a href="<?php echo $volver; ?>"><h6 class="text-primary"><- VOLVER</h6></a>
                    <hr>
                    <h4 class="text-primary">PERSONA NO ENCONTRADA</h4>
                    <p class="mb-1">
                        <?php if ($por_nombre && $ci_buscado > 0) { ?>
                        No existe ninguna persona registrada con la cédula <b><?php echo $ci_buscado; ?></b> ni con esos nombres y apellidos.
                        <?php } elseif ($por_nombre) { ?>
                        No existe ninguna persona registrada con esos nombres y apellidos.
                        <?php } elseif ($ci_buscado > 0) { ?>
                        No existe ninguna persona registrada con la cédula <b><?php echo $ci_buscado; ?></b>.
                        <?php } else { ?>
                        No existe ninguna persona registrada con esa cédula.
                        <?php } ?>
                    </p>
                    <p class="text-muted small"><?php echo $por_nombre
                        ? 'Verifique cómo están escritos los nombres y apellidos (pruebe solo con el primer nombre). Si no aparece, inicie la atención registrándolo como paciente nuevo.'
                        : 'Verifique el número con el paciente. Si es correcto, inicie la atención registrándolo como paciente nuevo.'; ?></p>
                    </br>
                    <!-- Misma entrada que el menú "ATENCIÓN PERSONA NO CARPETIZADA": carga el establecimiento del usuario y abre atencion_persona_ncf.php -->
                    <a href="valida_persona_ncf.php" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50"><i class="fas fa-user-plus"></i></span>
                        <span class="text">INICIAR ATENCIÓN COMO PACIENTE NUEVO</span>
                    </a>
                    <a href="<?php echo $volver; ?>" class="btn btn-light btn-icon-split ml-2">
                        <span class="icon text-gray-600"><i class="fas fa-search"></i></span>
                        <span class="text">VOLVER A BUSCAR</span>
                    </a>
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

                <div class="form-group row">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                    </div>
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

    <!-- scripts para calendario -->
   
</body>

</html>
