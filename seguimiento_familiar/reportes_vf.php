<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

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

                    <h1 class="h3 mb-2 text-gray-800">REPORTES VISITAS FAMILIARES SAFCI</h1>
                    <p class="mb-4">En esta seccion se puede encontrar los registros de VISITAS FAMILIARES del PROGRAMA NACIONAL SAFCI - MI SALUD a NIVEL NACIOANL por ESTABLECIMIENTO DE SALUD.</p>

                    <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">REPORTE DE VISITAS FAMILIARES A NIVEL ESTABLECIMIENTO</h6>
                    </div>
                    
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">DEPARTAMENTO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="iddepartamento"  id="iddepartamento" class="form-control" required>
                            <option value="">-SELECCIONE-</option>
                            <?php
                            $sql1 = " SELECT carpeta_familiar.iddepartamento, departamento.departamento FROM seguimiento_cf, carpeta_familiar, departamento WHERE carpeta_familiar.iddepartamento=departamento.iddepartamento ";
                            $sql1.= " AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar GROUP BY carpeta_familiar.iddepartamento ";
                            $result1 = mysqli_query($link,$sql1);
                            if ($row1 = mysqli_fetch_array($result1)){
                            mysqli_field_seek($result1,0);
                            while ($field1 = mysqli_fetch_field($result1)){
                            } do {
                            echo "<option value=".$row1[0].">".$row1[1]."</option>";
                            } while ($row1 = mysqli_fetch_array($result1));
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
                        <select name="idmunicipio_salud" id="idmunicipio_salud" class="form-control" required></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">ESTABLECIMIENTO DE SALUD:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="idestablecimiento_salud" id="idestablecimiento_salud" class="form-control" required></select>
                        </div>
                    </div>
                </div>
                    <div class="card-body" id="visitas_familiares_establecimiento">                    
                    </div>
                </div>
                <!-- /.container-fluid -->


                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">REPORTE DE VISITAS FAMILIARES POR MUNICIPIO</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-3">
                            <h6 class="text-primary">DEPARTAMENTO:</h6>
                            </div>
                            <div class="col-sm-9">
                            <select name="iddepartamento_mun"  id="iddepartamento_mun" class="form-control" required>
                                <option value="">-SELECCIONE-</option>
                                <?php
                                $sql1 = " SELECT carpeta_familiar.iddepartamento, departamento.departamento FROM seguimiento_cf, carpeta_familiar, departamento WHERE carpeta_familiar.iddepartamento=departamento.iddepartamento ";
                                $sql1.= " AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar GROUP BY carpeta_familiar.iddepartamento ";
                                $result1 = mysqli_query($link,$sql1);
                                if ($row1 = mysqli_fetch_array($result1)){
                                mysqli_field_seek($result1,0);
                                while ($field1 = mysqli_fetch_field($result1)){
                                } do {
                                echo "<option value=".$row1[0].">".$row1[1]."</option>";
                                } while ($row1 = mysqli_fetch_array($result1));
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
                            <select name="idmunicipio_salud_mun" id="idmunicipio_salud_mun" class="form-control" required></select>
                            </div>
                        </div>

                    </div>
                    <div class="card-body" id="visitas_familiares_municipio">                    
                    </div>
                </div>
                

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">REPORTE DE VISITAS FAMILIARES POR DEPARTAMENTO</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-3">
                            <h6 class="text-primary">DEPARTAMENTO:</h6>
                            </div>
                            <div class="col-sm-9">
                            <select name="iddepartamento_dep"  id="iddepartamento_dep" class="form-control" required>
                                <option value="">-SELECCIONE-</option>
                                <?php
                                $sql1 = " SELECT carpeta_familiar.iddepartamento, departamento.departamento FROM seguimiento_cf, carpeta_familiar, departamento WHERE carpeta_familiar.iddepartamento=departamento.iddepartamento ";
                                $sql1.= " AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar GROUP BY carpeta_familiar.iddepartamento ";
                                $result1 = mysqli_query($link,$sql1);
                                if ($row1 = mysqli_fetch_array($result1)){
                                mysqli_field_seek($result1,0);
                                while ($field1 = mysqli_fetch_field($result1)){
                                } do {
                                echo "<option value=".$row1[0].">".$row1[1]."</option>";
                                } while ($row1 = mysqli_fetch_array($result1));
                                } else {
                                echo "No se encontraron resultados!";
                                }
                                ?>
                            </select>
                            </div>
                            </div>

                        </div>

                    </div>
                    <div class="card-body" id="visitas_familiares_departamento">                    
                    </div>


                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">REPORTE DE VISITAS FAMILIARES POR MÉDICO OPERATIVO</h6>
                    </div>
                    <div class="card-body">

                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">DEPARTAMENTO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="iddepartamento_op"  id="iddepartamento_op" class="form-control" required>
                            <option value="">-SELECCIONE-</option>
                            <?php
                            $sql1 = " SELECT carpeta_familiar.iddepartamento, departamento.departamento FROM seguimiento_cf, carpeta_familiar, departamento WHERE carpeta_familiar.iddepartamento=departamento.iddepartamento ";
                            $sql1.= " AND seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar GROUP BY carpeta_familiar.iddepartamento ";
                            $result1 = mysqli_query($link,$sql1);
                            if ($row1 = mysqli_fetch_array($result1)){
                            mysqli_field_seek($result1,0);
                            while ($field1 = mysqli_fetch_field($result1)){
                            } do {
                            echo "<option value=".$row1[0].">".$row1[1]."</option>";
                            } while ($row1 = mysqli_fetch_array($result1));
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
                        <select name="idmunicipio_salud_op" id="idmunicipio_salud_op" class="form-control" required></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">ESTABLECIMIENTO DE SALUD:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="idestablecimiento_salud_op" id="idestablecimiento_salud_op" class="form-control" required></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">PERSONAL OPERATIVO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="medico_operativo_cf" id="medico_operativo_cf" class="form-control" required></select>
                        </div>
                    </div>

                    </div>
                    <div class="card-body" id="carpetas_familiares_operativo">                    
                    </div>
                </div>

            </div>
        </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Ministerio de Salud y Deportes &copy; MSYD <?php echo $gestion;?></span>
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
                    $.post("municipio_vf.php", {departamento:departamento}, function(data){
                    $("#idmunicipio_salud").html(data);
                    });
                });
        })
        });
    </script> 

    <script language="javascript">
        $(document).ready(function(){
        $("#idmunicipio_salud").change(function () {
                    $("#idmunicipio_salud option:selected").each(function () {
                        municipio_salud=$(this).val();
                    $.post("establecimientos_vf.php", {municipio_salud:municipio_salud}, function(data){
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
                    $.post("visitas_familiares_establecimiento.php", {establecimiento_salud:establecimiento_salud}, function(data){
                    $("#visitas_familiares_establecimiento").html(data);
                    });
                });
        })
        });
    </script>

    <script language="javascript">
            $(document).ready(function(){
            $("#iddepartamento_mun").change(function () {
                        $("#iddepartamento_mun option:selected").each(function () {
                            departamento=$(this).val();
                        $.post("municipio_vf.php", {departamento:departamento}, function(data){
                        $("#idmunicipio_salud_mun").html(data);
                        });
                    });
            })
            });
    </script> 

    <script language="javascript">
        $(document).ready(function(){
        $("#idmunicipio_salud_mun").change(function () {
                    $("#idmunicipio_salud_mun option:selected").each(function () {
                        municipio=$(this).val();
                    $.post("visitas_familiares_municipio.php", {municipio:municipio}, function(data){
                    $("#visitas_familiares_municipio").html(data);
                    });
                });
        })
        });
    </script>

    <script language="javascript">
        $(document).ready(function(){
        $("#iddepartamento_dep").change(function () {
                    $("#iddepartamento_dep option:selected").each(function () {
                        departamento=$(this).val();
                    $.post("visitas_familiares_departamento.php", {departamento:departamento}, function(data){
                    $("#visitas_familiares_departamento").html(data);
                    });
                });
        })
        });
    </script>

    <script language="javascript">
        $(document).ready(function(){
        $("#iddepartamento_op").change(function () {
                    $("#iddepartamento_op option:selected").each(function () {
                        departamento=$(this).val();
                    $.post("municipio_vf.php", {departamento:departamento}, function(data){
                    $("#idmunicipio_salud_op").html(data);
                    });
                });
        })
        });
    </script>
    <script language="javascript">
        $(document).ready(function(){
        $("#idmunicipio_salud_op").change(function () {
                    $("#idmunicipio_salud_op option:selected").each(function () {
                        municipio_salud=$(this).val();
                    $.post("establecimientos_vf.php", {municipio_salud:municipio_salud}, function(data){
                    $("#idestablecimiento_salud_op").html(data);
                    });
                });
        })
        });
    </script>

    <script language="javascript">
        $(document).ready(function(){
        $("#idestablecimiento_salud_op").change(function () {
                    $("#idestablecimiento_salud_op option:selected").each(function () {
                        establecimiento_salud=$(this).val();
                    $.post("medico_operativo_vf.php", {establecimiento_salud:establecimiento_salud}, function(data){
                    $("#medico_operativo_cf").html(data);
                    });
                });
        })
        });
    </script>

    <script language="javascript">
        $(document).ready(function(){
        $("#medico_operativo_cf").change(function () {
                    $("#medico_operativo_cf option:selected").each(function () {
                        medico_operativo=$(this).val();
                    $.post("visitas_familiares_operativo.php", {medico_operativo:medico_operativo}, function(data){
                    $("#carpetas_familiares_operativo").html(data);
                    });
                });
        })
        });
    </script>

</body>
</html>
