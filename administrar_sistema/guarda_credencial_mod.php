<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	   = date("Ymd");
$fecha 		   = date("Y-m-d");
$hora          = date("H:i");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$password_old    = $_POST['password_old'];
$password_new    = $_POST['password_new'];
$password_new_op = $_POST['password_new_op'];

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

<div class="row">
    <div class="col-sm-12">
    <div class="text-center">
        <?php
                $sql =" SELECT idusuario, usuario FROM usuarios WHERE idusuario='$idusuario_ss' AND password ='$password_old' ";
                $result = mysqli_query($link,$sql);
                if ($row = mysqli_fetch_array($result)){
                mysqli_field_seek($result,0);
                while ($field = mysqli_fetch_field($result)){
                } do {

                    if ($password_new == $password_new_op) {

                        $sql0 = " UPDATE usuarios SET password = '$password_new' WHERE idusuario='$idusuario_ss' ";
                        $result0 = mysqli_query($link,$sql0);   

                        $sql1 = " INSERT INTO cambio_password (idusuario, password_old, password_new, fecha_registro, hora_registro ) ";
                        $sql1.= " VALUES ('$idusuario_ss','$password_old','$password_new','$fecha','$hora') ";
                        $result1 = mysqli_query($link,$sql1);  

                        echo "<h6 class='text-success'>SE HA MODIFICADO LA CONTRASEÑA DE INGRESO A SISTEMA !!! </h6>";
                        
                    } else {
                        echo "<h6 class='text-danger'>LAS NUEVAS CONTRASEÑAS NO COINCIDEN !!! </h6>";
                    }  
                }
                while ($row = mysqli_fetch_array($result));
                } else {
                        echo "<h6 class='text-danger'>HAY UN ERROR EN LA CONTRASEÑA ACTUAL !!! </h6>";
                }

        ?>
                            </br>
                            </br>
                    <a href="credenciales.php"><h6>IR A CREDENCIALES DE SISTEMA --></h6></a>
        </div>
    </div>
</div>


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
