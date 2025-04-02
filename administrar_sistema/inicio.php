<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$sqlus =" SELECT nombre, paterno, materno FROM nombre WHERE idnombre='$idnombre_ss'";
$resultus = mysqli_query($link,$sqlus);
$rowus = mysqli_fetch_array($resultus);
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


                <div class="card shadow mb-2">
                    <div class="card-header py-2">
                    <h6 class="text-primary">REPORTE DEL DIA DE HOY <?php 
                    $fecha_r = explode('-',$fecha);
                    $f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];
                    echo $f_emision;?></h6>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">

                            <div class="col-sm-2">
                            <h6 class="text-info">Nº DE INGRESOS AL SISTEMA</h6>
                    <?php
                    $sql_l =" SELECT COUNT(idlog_login) FROM log_login WHERE fecha='$fecha' ";
                    $result_l = mysqli_query($link,$sql_l);
                    $row_l = mysqli_fetch_array($result_l);
                    $ingresos_medi_safci = $row_l[0];
                    ?>
                            <h6><?php echo $ingresos_medi_safci;?></h6>
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-info">NOTIFICACIONES (F302A) </h6>
                    <?php
                    $sql_d =" SELECT COUNT(idnotificacion_ep) FROM notificacion_ep WHERE estado='CONSOLIDADO' AND fecha_registro='$fecha'  ";
                    $result_d = mysqli_query($link,$sql_d);
                    $row_d = mysqli_fetch_array($result_d);
                    $notificaciones_ep_hoy = $row_d[0];
                    ?>
                            <h6><?php echo $notificaciones_ep_hoy;?></h6>
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-info">N° FICHAS EPIDEMIOLOGICAS:</h6>
                            <?php
                    $sql_f =" SELECT COUNT(idficha_ep) FROM ficha_ep WHERE fecha_registro='$fecha' ";
                    $result_f = mysqli_query($link,$sql_f);
                    $fichas_ep_hoy = mysqli_num_rows($result_f);
                    ?>
                            <h6><?php echo $fichas_ep_hoy;?></h6>
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-info">N° SEGUIMIENTO A PACIENTES (FICHAS EPIDEMIOLÓGICAS):</h6>
                            <?php
                    $sql_p =" SELECT idseguimiento_ep FROM seguimiento_ep WHERE fecha_registro='$fecha'";
                    $result_p = mysqli_query($link,$sql_p);
                    $fichas_paciente = mysqli_num_rows($result_p);
                    ?>
                            <h6><?php echo $fichas_paciente;?></h6>
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-info">NUEVAS ÁREAS DE INFLUENCIA REGISTRADAS:</h6>

                    <?php
                        $sql_2 = " SELECT count(idarea_influencia) FROM area_influencia WHERE fecha_registro='$fecha' ";
                        $result_2 = mysqli_query($link,$sql_2);           
                        $row_2 = mysqli_fetch_array($result_2); 
                    ?>
                            <h6><?php echo $row_2[0];?></h6>
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-info">Nº DE CARPETAS FAMILIARES</h6>
                    <?php
                    $sql_cf =" SELECT COUNT(idcarpeta_familiar) FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND fecha_registro='$fecha' ";
                    $result_cf = mysqli_query($link,$sql_cf);
                    $row_cf = mysqli_fetch_array($result_cf);
                    $carpetas_familiares = $row_cf[0];
                    ?>
                            <h6><?php echo $carpetas_familiares;?></h6>
                            </div>
                        </div>   
                    </div>
                </div>
  

                            <div class="card shadow mb-8">
                                <div class="card-header py-6">
                                    <h6 class="m-0 font-weight-bold text-primary"></h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <img src="../img/fondo_inicio_safci.jpg" class="rounded" alt="Eniun">
                                    </div>
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
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- scripts para calendario -->
   
</body>

</html>
