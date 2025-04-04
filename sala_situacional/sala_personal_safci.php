<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

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
                    <hr>                     
                    <h4 class="text-primary">SALA SITUACIONAL PERSONAL SAFCI</h4>
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->
<hr> 
                <div class="form-group row">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-6">
                        <h6 class="text-primary">1.- PERSONAL A NIVEL NACIONAL</h6>
                    </div>
                    <div class="col-sm-4">
                    <a href="personal_genero.php" target="_blank" onClick="window.open(this.href, this.target, 'width=1000,height=600,scrollbars=YES'); return false;">
                    <h6 class="text-info"><i class="fas fa-chart-pie"></i>   MOSTRAR REPORTE</h6></a>
                    </div>
                </div>    
                <div class="form-group row">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-6">
                        <h6 class="text-primary">2.- FORMACIÓN ACADÉMICA</h6>
                    </div>
                    <div class="col-sm-4">
                    <a href="personal_formacion_academica.php" target="_blank" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES'); return false;">
                    <h6 class="text-info"><i class="fas fa-chart-bar"></i> MOSTRAR REPORTE</h6></a>
                    </div>
                </div>  
                <div class="form-group row">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-6">
                        <h6 class="text-primary">3.- ESPECIALIDADES MÉDICAS</h6>
                    </div>
                    <div class="col-sm-4">
                    <a href="personal_especialidad_medica.php" target="_blank" onClick="window.open(this.href, this.target, 'width=900,height=800,scrollbars=YES'); return false;">
                    <h6 class="text-info"><i class="far fa-chart-bar"></i>   MOSTRAR REPORTE</h6></a>
                    </div>
                </div> 
         <!----- <div class="form-group row">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-6">
                        <h6 class="text-primary">4.- PERSONAL POR DEPARTAMENTO</h6>
                    </div>
                    <div class="col-sm-4">
                    <a href="establecimientos_tipo.php" target="_blank" onClick="window.open(this.href, this.target, 'width=1220,height=600,scrollbars=YES'); return false;">
                    <h6 class="text-info"><i class="far fa-chart-bar"></i>   MOSTRAR REPORTE</h6></a>
                    </div>
                </div> 
                <div class="form-group row">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-6">
                        <h6 class="text-primary">5.- PERSONAL POR DEPARTAMENTO Y RED DE SALUD</h6>
                    </div>
                    <div class="col-sm-4">
                    <a href="establecimientos_tipo.php" target="_blank" onClick="window.open(this.href, this.target, 'width=1220,height=600,scrollbars=YES'); return false;">
                    <h6 class="text-info"><i class="far fa-chart-bar"></i>   MOSTRAR REPORTE</h6></a>
                    </div>
                </div> 
-->
</div>                    
<!-- END aqui va el comntenido de la pagina ---->
            
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
                        <span aria-hidden="true"></span>
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
