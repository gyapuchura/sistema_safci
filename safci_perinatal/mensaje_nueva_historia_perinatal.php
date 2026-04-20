<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");

$hora       = date("H:i"); 
$gestion    = date("Y");

$idusuario_ss  = $_SESSION['idusuario_ss'];
$idnombre_ss   = $_SESSION['idnombre_ss'];
$perfil_ss     = $_SESSION['perfil_ss'];

$idhistoria_perinatal_ss      = $_SESSION['idhistoria_perinatal_ss'];

$idcarpeta_familiar_ss      = $_SESSION['idcarpeta_familiar_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idintegrante_cf_ss         = $_SESSION['idintegrante_cf_ss'];
$idnombre_integrante_ss     = $_SESSION['idnombre_integrante_ss'];
$edad_ss                    = $_SESSION['edad_ss'];

$sql_hp =" SELECT idhistoria_perinatal, codigo FROM historia_perinatal WHERE idhistoria_perinatal='$idhistoria_perinatal_ss' ";
$result_hp=mysqli_query($link,$sql_hp);
$row_hp=mysqli_fetch_array($result_hp);

$sql_n =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$idnombre_integrante_ss' ";
$result_n=mysqli_query($link,$sql_n);
$row_n=mysqli_fetch_array($result_n);
        
$sql_ub =" SELECT iddepartamento, idred_salud, idmunicipio FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud_ss' ";
$result_ub=mysqli_query($link,$sql_ub);
$row_ub=mysqli_fetch_array($result_ub);


?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HISTORIA PERINATAL GUARDADA</title>

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
                    <img src="../implementacion_safci/mds_logo.jpg" width="250" height="120" alt=""/>
                  </br>
                  </br>
               
                    <!-- Page Heading -->
                    
              <!--      <a class="text-center" href=""><h6><- VOLVER</h6></a>  -->
</br>
                    <h3 class="text-secundary">LA NUEVA HISTORIA CLÍNICA PERINATAL </h3>
                    <h3 class="text-secundary">A SIDO REGISTRADA EN SISTEMA !!!</h3>
                </div>
                <div class="row">
                  </br>
                </div>

        

                 <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h4 class="m-0 font-weight-bold text-warning">CÓDIGO DE HISTORIA Nº : <?php  echo $row_hp[1];?></h4>
                    </div>
                    
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-4">
                        <h6 class="text-warning">NOMBRE : </h6>
                        </div>
                        <div class="col-sm-8">

                        <input type="text" class="form-control" name="nombre" value="<?php echo mb_strtoupper($row_n[1]." ".$row_n[2]." ".$row_n[3]);?>" disabled>
                        </div>
                    </div>
                        
                    <div class="form-group row">
                        <div class="col-sm-4">
                        <h6 class="text-warning"></h6>
                        </div>
                        <div class="col-sm-8">                     
                                <a class="btn btn-warning btn-icon-split" href="../safci_perinatal/formulario_perinatal.php" target="_blank" onClick="window.open(this.href, this.target, 'width=900,height=800,top=50, left=800, scrollbars=YES'); return false;">
                                <span class="icon text-white-50">
                                    <i class="fas fa-book"></i>
                                </span>
                                <span class="text">VER FORMULARIO - CLAP</span></a> 
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
