<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	   = date("Ymd");
$fecha 		   = date("Y-m-d");

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


                <div class="container-fluid">
  

                <div class="card shadow mb-8">
                    <div class="card-header py-6">
                        <h6 class="m-0 font-weight-bold text-primary">CREDENCIALES DE ACCESO AL SISTEMA</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                        <h3 class="text-primary">
                        MODIFICAR CONTRASEÑA DE ACCESO AL SISTEMA
                        </h3>
                    </div>
                    <hr>
<div class="row">
<div class="col-sm-12">
</div>
</div>

<!---- begin  CAMBIO DE CONTRASEÑA  ----->

<form class="user" method="post" action="guarda_credencial_mod.php" >

<div class="form-group row">
    <div class="col-sm-4 mb-3 mb-sm-0">
    <h6 class="text-primary">CONTRASEÑA ACTUAL:</h6>
    <input type="password" class="form-control" name="password_old" placeholder="Contraseña">
    </div>
    <div class="col-sm-4">
    <h6 class="text-primary">NUEVA CONTRASEÑA:</h6>
    <input type="password" class="form-control" name="password_new" placeholder="Contraseña"
    required pattern="^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{8,25}$" 
  title="La contraseña debe tener al menos un dígito numérico, al menos una minúscula, al menos una mayúscula y al menos un caracter no alfanumérico"
    >
    </div>
        <div class="col-sm-4">
    <h6 class="text-primary">REPETIR NUEVA CONTRASEÑA:</h6>
    <input type="password" class="form-control" name="password_new_op" placeholder="Contraseña"
    required pattern="^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{8,25}$" 
  title="La contraseña debe tener al menos un dígito numérico, al menos una minúscula, al menos una mayúscula y al menos un caracter no alfanumérico"
    >
    </div>
    </div>

<div class="row">
<div class="col-sm-12">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#saveModal">
            GUARDAR CAMBIO DE CONTRASEÑA
    </button>
</div>
</div>

<!--  Modal para envio a guardar -->
<div class="modal fade" id="saveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel2">¿ESTA SEGURO DE CAMBIAR LA CONTRASEÑA DE INGRESO A SISTEMA?</h5>
<button class="close" type="button" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body">Seleccione la opción GUARDAR para realizar el cambio de contraseña.</div>
<div class="modal-footer">
<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
<button class="btn btn-primary" type="submit">GUARDAR CAMBIO</a>
</div>
</div>
</div>
</div>
<hr>
</form>
<!-------- agrega nuevo usuario end --------->



<!---- end  CAMBIO DE CONTRASEÑA ---->
                    </div>
                </div>
<!---- begin  reporte con fromato ----->
<hr>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">

                    </div>


<!---- end reporte con formato 2 ----->
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
