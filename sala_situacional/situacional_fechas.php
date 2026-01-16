<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion 			    = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$inicio = $_POST['inicio'];
$finalizacion = $_POST['finalizacion'];

$fecha_i = explode('-',$inicio);
$f_inicio = $fecha_i[2].'/'.$fecha_i[1].'/'.$fecha_i[0];

$fecha_f = explode('-',$finalizacion);
$f_finalizacion = $fecha_f[2].'/'.$fecha_f[1].'/'.$fecha_f[0];

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
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">ANÁLISIS SITUACIONAL POR FECHAS</h1>
                    <p class="mb-4">Esta seccion permite generar la analitica por rangos de fechas y facilitar el analisis situacional de parametros mas importantes del PROGRAMA NACIONAL SAFCI - MI SALUD.</p>

            <!-- REPORTE POR FECHAS -->
                <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">ANÁLISIS POR INTERVALO DE FECHAS</h6>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">DESDE:</h6>
                        <input type="date" name="inicio" id="" class="form-control" value="<?php echo $inicio;?>" disabled>
                        </div>
                        <div class="col-sm-3">
                        <h6 class="text-primary">HASTA:</h6>
                        <input type="date" name="finalizacion" id="" class="form-control" value="<?php echo $finalizacion;?>" disabled>
                        </div>
                        <div class="col-sm-6">
                        </div>
                    </div>
                </div>
            </div>

             <!-- GRAFICA PRODUCCION DE CARPETAS FAMILIARES -->
                <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">PRODUCCIÓN DE CARPETAS FAMILIARES - DEL <?php echo $f_inicio;?> AL <?php echo $f_finalizacion;?></h6>
                </div>
                <div class="card-body">

                    <div class="form-group row">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4">
                            <a class="btn btn-primary btn-icon-split" href="../carpetas_familiares/carpetas_departamento_fechas.php?inicio=<?php echo $inicio;?>&finalizacion=<?php echo $finalizacion;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=800,scrollbars=YES,top=50,left=300'); return false;">
                            <span class="icon text-white-50">
                                <i class="fas fa-book"></i>
                            </span>
                            <span class="text">PRODUCCIÓN DE CARPETAS FAMILIARES </span></a>
                        </div>
                        <div class="col-sm-4">
                        </div>
                    </div>
                </div>
                </div>

                <!-- GRAFICA SALUD DE LOS INTEGRANTES POR RANGO DE FECHAS -->
                <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">SALUD DE LOS INTEGRANTES DE LA FAMILIA - DEL <?php echo $f_inicio;?> AL <?php echo $f_finalizacion;?></h6>
                </div>
                <div class="card-body">

                    <div class="form-group row">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4">
                            <a class="btn btn-primary btn-icon-split" href="../carpetas_familiares/salud_integrantes_grafica_fecha.php?inicio=<?php echo $inicio;?>&finalizacion=<?php echo $finalizacion;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=800,scrollbars=YES,top=50,left=300'); return false;">
                            <span class="icon text-white-50">
                                <i class="fas fa-book"></i>
                            </span>
                            <span class="text">SALUD DE LOS INTEGRANTES DE LA FAMILIA</span></a>
                        </div>
                        <div class="col-sm-4">
                        </div>
                    </div>
                </div>
                </div>

                <!-- GRAFICA DETERMINANTES DE LA SALUD POR RANGO DE FECHAS -->
                <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">RIESGO EN LAS DETERMINANTES DE LA SALUD - DEL <?php echo $f_inicio;?> AL <?php echo $f_finalizacion;?></h6>
                </div>
                <div class="card-body">

                    <div class="form-group row">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4">
                            <a class="btn btn-primary btn-icon-split" href="../carpetas_familiares/riesgo_determinante_salud_fecha.php?inicio=<?php echo $inicio;?>&finalizacion=<?php echo $finalizacion;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=600,scrollbars=YES,top=50,left=300'); return false;">
                            <span class="icon text-white-50">
                                <i class="fas fa-book"></i>
                            </span>
                            <span class="text">RIÉSGO DE LAS DETERMINANTES DE LA SALUD</span></a>
                        </div>
                        <div class="col-sm-4">
                        </div>
                    </div>
                </div>
                </div>
                <!-- GRAFICA RIESGO FMILIAR POR RANGO DE FECHAS -->
                <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">EVALUACIÓN DEL RIÉSGO FAMILIAR - DEL <?php echo $f_inicio;?> AL <?php echo $f_finalizacion;?></h6>
                </div>
                <div class="card-body">

                    <div class="form-group row">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4">
                            <a class="btn btn-primary btn-icon-split" href="../carpetas_familiares/grafica_evaluacion_salud_familiar_fecha.php?inicio=<?php echo $inicio;?>&finalizacion=<?php echo $finalizacion;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=600,scrollbars=YES,top=50,left=300'); return false;">
                            <span class="icon text-white-50">
                                <i class="fas fa-book"></i>
                            </span>
                            <span class="text">RIÉSGO FAMILIAR</span></a>
                        </div>
                        <div class="col-sm-4">
                        </div>
                    </div>
                </div>
                </div>


                  <!-- GRAFICA VISITAS FMILIARES POR RANGO DE FECHAS -->
                <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">VISITAS FAMILIARES - DEL <?php echo $f_inicio;?> AL <?php echo $f_finalizacion;?></h6>
                </div>
                <div class="card-body">

                    <div class="form-group row">
                        <div class="col-sm-4">
                            <a class="btn btn-info btn-icon-split" href="../seguimiento_familiar/visitas_safci_diarias_fecha.php?inicio=<?php echo $inicio;?>&finalizacion=<?php echo $finalizacion;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=650,scrollbars=YES,top=50,left=300'); return false;">
                            <span class="icon text-white-50">
                                <i class="fas fa-book"></i>
                            </span>
                            <span class="text">REGISTRO DIARIO - VISITAS FAMILIARES</span></a>
                        </div>
                        <div class="col-sm-4">
                            <a class="btn btn-primary btn-icon-split" href="../seguimiento_familiar/mapa_visitas_nal_fechas.php?inicio=<?php echo $inicio;?>&finalizacion=<?php echo $finalizacion;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=850,scrollbars=YES,top=50,left=300'); return false;">
                            <span class="icon text-white-50">
                                <i class="fas fa-map"></i>
                            </span>
                            <span class="text">MAPA DE PLANIFICACIÓN - VISITAS FAMILIARES</span></a>
                        </div>
                        <div class="col-sm-4">
                            <a class="btn btn-success btn-icon-split" href="../seguimiento_familiar/mapa_visitas_nal_fechas_ej.php?inicio=<?php echo $inicio;?>&finalizacion=<?php echo $finalizacion;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=850,scrollbars=YES,top=50,left=300'); return false;">
                            <span class="icon text-white-50">
                                <i class="fas fa-map"></i>
                            </span>
                            <span class="text">MAPA DE EJECUCIÓN - VISITAS FAMILIARES</span></a>
                        </div>
                    </div>
                </div>
                </div>
                        


                


           

  
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Ministerio de Salud y Deportes &copy; MSYD <?php echo $gestion; ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                    <a class="btn btn-primary" href="salir.php">Salir de Sistema</a>
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




</body>
</html>
