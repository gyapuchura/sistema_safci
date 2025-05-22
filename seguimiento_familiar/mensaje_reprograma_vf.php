<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");
$semana  = date("W");
$gestion    =  date("Y");

$idcarpeta_familiar_ss = $_SESSION['idcarpeta_familiar_ss'];
$idvisita_cf_ss  =  $_SESSION['idvisita_cf_ss'];

$sql =" SELECT seguimiento_cf.idcarpeta_familiar, nombre.nombre, nombre.paterno, nombre.materno, visita_cf.numero_visita, ";
$sql.=" visita_cf.fecha_visita, visita_cf.idestado_visita_cf, visita_cf.idvisita_cf FROM nombre, seguimiento_cf, integrante_cf, visita_cf  ";
$sql.=" WHERE visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf AND integrante_cf.idnombre=nombre.idnombre  ";
$sql.=" AND seguimiento_cf.idintegrante_cf=integrante_cf.idintegrante_cf AND visita_cf.idvisita_cf='$idvisita_cf_ss'";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>REPORTE EPIDEMIOLOGICO SEMANAL - SAFCI</title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                <div class="text-center">
                    <img src="../implementacion_safci/logo_safci_doc.png" width="152" height="106" alt=""/>
                  </br>
                  </br>
               
                    <!-- Page Heading -->
                    
                    <a class="text-center" href="calendario_reprogramacion_visita.php"><h6><- VOLVER</h6></a>
</br>
                    <h3 class="text-success">LA FECHA DE VISITA</h3>
                    <h3 class="text-success">A SIDO MODIFICADA !!!</h3>
                </div>
                <div class="row">
                  </br>
                </div>

        

                 <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">FECHA DE VISITA FAMILIAR POR RIÉSGO PERSONAL</h6>
                    </div>
                    
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-4">
                        <h6 class="text-success">NOMBRE DE INTEGRANTE DE LA FAMILIA : </h6>
                        </div>
                        <div class="col-sm-8">

                        <input type="text" class="form-control" name="nombre" value="<?php echo mb_strtoupper($row[1]." ".$row[2]." ".$row[3]);?>" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4">
                        <h6 class="text-success">NÚMERO DE VISITA : </h6>
                        </div>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" name="nombre" value="<?php echo $row[4];?>" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                        <h6 class="text-success">NUEVA FECHA DE VISITA:</h6>
                        </div>
                        <div class="col-sm-8">
                      <input type="date" class="form-control" name="fecha_visita" value="<?php echo $row[5];?>" disabled>
                        </div>
                    </div>
                        
                    <div class="form-group row">
                        <div class="col-sm-4">
                        <h6 class="text-success"></h6>
                        </div>
                        <div class="col-sm-8">                     
                        <a class="btn btn-success btn-icon-split" href="calendario_reprogramacion_visita.php">
                        <span class="icon text-white-50">
                            <i class="fas fa-book"></i>
                        </span>
                        <span class="text"><- VOLVER AL CALENDARIO DE REPROGRAMACIÓN</span></a>
                        </div>
                    </div>
                </div>
                                 
                    </div>
                </div>

   <!-- modal de confirmacion de envio de datos-->


                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
