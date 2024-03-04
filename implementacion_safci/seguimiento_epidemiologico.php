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
                    <h1 class="h3 mb-2 text-gray-800">SEGUIMIENTO EPIDEMIOLÓGICO SAFCI</h1>
                    <p class="mb-4">En esta seccion se puede realizar el Seguimiento Epidemiológico del PROGRAMA NACIONAL SAFCI - MI SALUD.</p>

                <!-- REPORTE NACIONAL  -->
            
            <!-- REPORTE POR DEPARTAMENTO -->
                    <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">SEGUIMIENTO DE FICHAS EPIDEMIOLOGICAS</h6>
                    </div>

                    <form name="SOSPECHA" action="valida_seguimiento_fichas_ep.php" method="post"> 

                <div class="card-body">

                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">DEPARTAMENTO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="iddepartamento"  id="iddepartamento" class="form-control" required>

                        <option value="">Elegir Departamento</option>
                            <?php
                            $numero = 1;
                            $sql2 = " SELECT departamento.iddepartamento, departamento.departamento FROM ficha_ep, notificacion_ep, departamento ";
                            $sql2.= " WHERE ficha_ep.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND notificacion_ep.iddepartamento=departamento.iddepartamento AND notificacion_ep.estado='CONSOLIDADO' ";
                            $sql2.= " GROUP BY departamento.iddepartamento ORDER BY departamento.departamento ";
                            $result2 = mysqli_query($link,$sql2);
                            if ($row2 = mysqli_fetch_array($result2)){
                            mysqli_field_seek($result2,0);
                            while ($field2 = mysqli_fetch_field($result2)){
                            } do {
                            echo "<option value=".$row2[0].">".$numero.".- ".$row2[1]." </option>";
                            $numero = $numero+1;
                            } while ($row2 = mysqli_fetch_array($result2));
                            } else {
                            echo "No se encontraron resultados!";
                            }
                            ?>

                        </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">MUNICIPIO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="idmunicipio" id="idmunicipio" class="form-control" required></select>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">ESTABLECIMIENTO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="idestablecimiento_salud" id="idestablecimiento_salud" class="form-control" required></select>
                        </div>
                    </div> 

                    <div class="form-group row">
                        <div class="col-sm-4">
                        <h6 class="text-primary">ELEGIR REGISTRO EPIDEMIOLÓGICO:</h6>
                        </div>
                        <div class="col-sm-8">
                        <select name="idsospecha_diag"  id="idsospecha_diag" class="form-control" required></select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4">
                        
                        </div>
                        <div class="col-sm-8">
                        <button type="submit" class="btn btn-primary">INGRESAR A FICHAS EPIDEMIOLÓGICAS</button></form>
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
                        <span>Ministerio de Salud y Deportes &copy; MSYD 2023</span>
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



    <script language="javascript">
        $(document).ready(function(){
        $("#iddepartamento").change(function () {
                    $("#iddepartamento option:selected").each(function () {
                        departamento=$(this).val();
                    $.post("municipios_seg_ep.php", {departamento:departamento}, function(data){
                    $("#idmunicipio").html(data);
                    });
                });
        })
        });
    </script>

        <script language="javascript">
        $(document).ready(function(){
        $("#idmunicipio").change(function () {
                    $("#idmunicipio option:selected").each(function () {
                        municipio=$(this).val();
                    $.post("establecimientos_seg_ep.php", {municipio:municipio}, function(data){
                    $("#idestablecimiento_salud").html(data);
                    });
                });
        })
        });
    </script>

<script language="javascript">
        $(document).ready(function(){
        $("#idestablecimiento_salud").change(function () {
                    $("#idestablecimiento_salud option:selected").each(function () {
                        establecimiento_salud=$(this).val();
                    $.post("sospecha_seg_ep.php", {establecimiento_salud:establecimiento_salud}, function(data){
                    $("#idsospecha_diag").html(data);
                    });
                });
        })
        });
    </script>

</body>
</html>
