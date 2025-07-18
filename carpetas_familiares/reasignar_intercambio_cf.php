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

                    <h1 class="h3 mb-2 text-gray-800">INTERCAMBIO DE CARPETAS FAMILIARES ENTRE OPERATIVOS</h1>
                    <p class="mb-4">En esta seccion se puede INTERCAMBIAR CARPETAS FAMILIARES del PROGRAMA NACIONAL SAFCI - MI SALUD a NIVEL NACIOANL por ESTABLECIMIENTO DE SALUD.</p>

                    <!-- DataTales Example -->

            <form name="INTERCAMBIO_CF" action="guarda_intercambio_cf.php" method="post">

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">MÉDICO OPERATIVO - 1</h6>
                    </div>
                    <div class="card-body">

                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">DEPARTAMENTO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="iddepartamento_op1"  id="iddepartamento_op1" class="form-control" required>
                            <option value="">-SELECCIONE-</option>
                            <?php
                            $sql1 = " SELECT ubicacion_cf.iddepartamento, departamento.departamento FROM ubicacion_cf, departamento ";
                            $sql1.= " WHERE ubicacion_cf.iddepartamento=departamento.iddepartamento GROUP BY ubicacion_cf.iddepartamento ";
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
                        <select name="idmunicipio_salud_op1" id="idmunicipio_salud_op1" class="form-control" required></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">ESTABLECIMIENTO DE SALUD:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="idestablecimiento_salud_op1" id="idestablecimiento_salud_op1" class="form-control" required></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">PERSONAL OPERATIVO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="medico_operativo_cf1" id="medico_operativo_cf1" class="form-control" required></select>
                        </div>
                    </div>

                    </div>
                    <div class="card-body" id="carpetas_familiares_permutacion_1">                    
                    </div>
                </div>


                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">MÉDICO OPERATIVO - 2</h6>
                    </div>
                    <div class="card-body">

                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">DEPARTAMENTO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="iddepartamento_op2"  id="iddepartamento_op2" class="form-control" required>
                            <option value="">-SELECCIONE-</option>
                            <?php
                            $sql1 = " SELECT ubicacion_cf.iddepartamento, departamento.departamento FROM ubicacion_cf, departamento ";
                            $sql1.= " WHERE ubicacion_cf.iddepartamento=departamento.iddepartamento GROUP BY ubicacion_cf.iddepartamento ";
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
                        <select name="idmunicipio_salud_op2" id="idmunicipio_salud_op2" class="form-control" required></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">ESTABLECIMIENTO DE SALUD:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="idestablecimiento_salud_op2" id="idestablecimiento_salud_op2" class="form-control" required></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">PERSONAL OPERATIVO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="medico_operativo_cf2" id="medico_operativo_cf2" class="form-control" required></select>
                        </div>
                    </div>

                    </div>
                    <div class="card-body" id="carpetas_familiares_permutacion_2">                    
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">MOTIVO DE REASIGNACIÓN : </h6>
                    </div>
                    <div class="card-body">

                <div class="form-group row">
                <div class="col-sm-3">
                <h6 class="text-info">  </h6>
                </div> 
                <div class="col-sm-9">
                <select name="idmotivo_cambio_cf"  id="idmotivo_cambio_cf" class="form-control" required>
                    <option value="">-SELECCIONE-</option>
                    <?php
                    $sql1 = " SELECT idmotivo_cambio_cf, motivo_cambio_cf FROM motivo_cambio_cf ";
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
                <h6 class="text-info">  </h6>
                </div> 
                <div class="col-sm-9">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    GUARDAR INTERCAMBIO DE CARPETAS FAMILIARES
                    </button>  
                </div> 
                </div>      
            </div> 
            </div>                          
               <hr>             
                   <!-- modal de confirmacion de envio de datos-->

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">INTERCAMBIO DE CARPETAS FAMILIARES</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            
                            Esta seguro de Registrar EL CAMBIO DE CARPETAS FAMILIARES?
                        
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-primary pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form>        

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
        $("#iddepartamento_op1").change(function () {
                    $("#iddepartamento_op1 option:selected").each(function () {
                        departamento=$(this).val();
                    $.post("municipio_cf.php", {departamento:departamento}, function(data){
                    $("#idmunicipio_salud_op1").html(data);
                    });
                });
        })
        });
    </script>
    <script language="javascript">
        $(document).ready(function(){
        $("#idmunicipio_salud_op1").change(function () {
                    $("#idmunicipio_salud_op1 option:selected").each(function () {
                        municipio_salud=$(this).val();
                    $.post("establecimientos_cf.php", {municipio_salud:municipio_salud}, function(data){
                    $("#idestablecimiento_salud_op1").html(data);
                    });
                });
        })
        });
    </script>

    <script language="javascript">
        $(document).ready(function(){
        $("#idestablecimiento_salud_op1").change(function () {
                    $("#idestablecimiento_salud_op1 option:selected").each(function () {
                        establecimiento_salud=$(this).val();
                    $.post("medico_operativo_cf.php", {establecimiento_salud:establecimiento_salud}, function(data){
                    $("#medico_operativo_cf1").html(data);
                    });
                });
        })
        });
    </script>

    <script language="javascript">
        $(document).ready(function(){
        $("#medico_operativo_cf1").change(function () {
                    $("#medico_operativo_cf1 option:selected").each(function () {
                        medico_operativo=$(this).val();
                    $.post("carpetas_familiares_operativo_p1.php", {medico_operativo:medico_operativo}, function(data){
                    $("#carpetas_familiares_permutacion_1").html(data);
                    });
                });
        })
        });
    </script>



<script language="javascript">
        $(document).ready(function(){
        $("#iddepartamento_op2").change(function () {
                    $("#iddepartamento_op2 option:selected").each(function () {
                        departamento=$(this).val();
                    $.post("municipio_cf.php", {departamento:departamento}, function(data){
                    $("#idmunicipio_salud_op2").html(data);
                    });
                });
        })
        });
    </script>
    <script language="javascript">
        $(document).ready(function(){
        $("#idmunicipio_salud_op2").change(function () {
                    $("#idmunicipio_salud_op2 option:selected").each(function () {
                        municipio_salud=$(this).val();
                    $.post("establecimientos_cf.php", {municipio_salud:municipio_salud}, function(data){
                    $("#idestablecimiento_salud_op2").html(data);
                    });
                });
        })
        });
    </script>

    <script language="javascript">
        $(document).ready(function(){
        $("#idestablecimiento_salud_op2").change(function () {
                    $("#idestablecimiento_salud_op2 option:selected").each(function () {
                        establecimiento_salud=$(this).val();
                    $.post("medico_operativo_cf.php", {establecimiento_salud:establecimiento_salud}, function(data){
                    $("#medico_operativo_cf2").html(data);
                    });
                });
        })
        });
    </script>

    <script language="javascript">
        $(document).ready(function(){
        $("#medico_operativo_cf2").change(function () {
                    $("#medico_operativo_cf2 option:selected").each(function () {
                        medico_operativo=$(this).val();
                    $.post("carpetas_familiares_operativo_p2.php", {medico_operativo:medico_operativo}, function(data){
                    $("#carpetas_familiares_permutacion_2").html(data);
                    });
                });
        })
        });
    </script>

</body>
</html>
