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

                    <h1 class="h3 mb-2 text-gray-800">ANALÍTICA DE CARPETAS FAMILIARES SAFCI</h1>
                    <p class="mb-4">En esta seccion se puede encontrar los resultados de los registros de CARPETAS FAMILIARES del PROGRAMA NACIONAL SAFCI - MI SALUD.</p>

                    <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">ANALÍTICA - CARPETAS FAMILIARES A NIVEL DE ESTABLECIMIENTO</h6>
                    </div>
 
                <form name="CARPETAS_FAMILIARES" action="valida_carpetas_eess.php" method="post">
                    
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">DEPARTAMENTO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="iddepartamento"  id="iddepartamento" class="form-control" required>
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
                    <div class="card-body" id="establecimiento_a_cf">                    
                    </div>
                    </div>

              
                <!-- ANALITICA A N9VEL MUNICIPAL BEGIN -->

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">ANALÍTICA - CARPETAS FAMILIARES A NIVEL DE MUNICIPIO</h6>
                    </div>
 
                <form name="CARPETAS_FAMILIARES" action="valida_carpetas_eess.php" method="post">
                    
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">DEPARTAMENTO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="iddepartamento_m"  id="iddepartamento_m" class="form-control" required>
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
                        <select name="idmunicipio_salud_m" id="idmunicipio_salud_m" class="form-control" required></select>
                        </div>
                    </div>
                </div>
                    <div class="card-body" id="municipio_a_cf">                    
                    </div>
                    </div>

                <!-- ANALITICA A N9VEL MUNICIPAL END -->

       
                       <!-- ANALITICA A N9VEL DEPARTAMENTAL BEGIN -->

                       <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">ANALÍTICA - CARPETAS FAMILIARES A NIVEL DEPARTAMENTAL</h6>
                    </div>
 
                <form name="CARPETAS_FAMILIARES" action="valida_carpetas_eess.php" method="post">
                    
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">DEPARTAMENTO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="iddepartamento_d"  id="iddepartamento_d" class="form-control" required>
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

                </div>
                    <div class="card-body" id="departamento_a_cf">                    
                    </div>
                    </div>
                <!-- ANALITICA A N9VEL DEPARTAMENTAL END -->


                       <!-- ANALITICA A N9VEL NACIONAL BEGIN -->

                       <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">ANALÍTICA - CARPETAS FAMILIARES A NIVEL NACIONAL</h6>
                    </div>
 
                <form name="CARPETAS_FAMILIARES" action="valida_carpetas_eess.php" method="post">
                    
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">I. POBLACIÓN NIVEL NACIONAL:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="piramide_poblacional_nal.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=750,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">PIRÁMIDE POBLACIONAL</h6></a>  
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV. SALUD DE LOS INTEGRANTES DE LA FAMILIA:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="salud_integrantes_grafica.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ANALITICA GRUPOS DE SALUD FAMILIAR</h6></a>  
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XI. DETERMINANTES DE LA SALUD</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SERVICIOS BÁSICOS</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ESTRUCTURA DE LA VIVIENDA</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_funcionalidad_vivienda.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">FUNCIONALIDAD DE LA VIVIENDA</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_salud_alimentaria.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SALUD ALIMENTARIA</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XII. CARACTERÍSTICAS SOCIOECONÓMICAS</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_socioeconomica_cf.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SOCIOECONOMÍA DE LOS HOGARES</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XIII. TENENCIA DE ANIMALES DOMÉSTICOS DE COMPAÑÍA</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_tenencia_animales_cf.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=400,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ANIMALES DOMESTICOS EN CADA HOGAR</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XIV. ESTRUCTURA FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_estructura_familiar_cf.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=400,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ESTRUCTURA FAMILIAR</h6></a>  
                        </div>
                    </div>

                    </div>
                </div>
            </div>
                <!-- ANALITICA A N9VEL NACIONAL END -->

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
                    $.post("municipio_cf.php", {departamento:departamento}, function(data){
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
                    $.post("establecimientos_cf.php", {municipio_salud:municipio_salud}, function(data){
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
                    $.post("establecimiento_a_cf.php", {establecimiento_salud:establecimiento_salud}, function(data){
                    $("#establecimiento_a_cf").html(data);
                    });
                });
        })
        });
</script>

<script language="javascript">
        $(document).ready(function(){
        $("#iddepartamento_m").change(function () {
                    $("#iddepartamento_m option:selected").each(function () {
                        departamento_m=$(this).val();
                    $.post("municipio_cfa.php", {departamento_m:departamento_m}, function(data){
                    $("#idmunicipio_salud_m").html(data);
                    });
                });
        })
        });
</script> 

<script language="javascript">
        $(document).ready(function(){
        $("#idmunicipio_salud_m").change(function () {
                    $("#idmunicipio_salud_m option:selected").each(function () {
                        municipio_salud_m=$(this).val();
                    $.post("municipio_a_cf.php", {municipio_salud_m:municipio_salud_m}, function(data){
                    $("#municipio_a_cf").html(data);
                    });
                });
        })
        });
</script>

<script language="javascript">
        $(document).ready(function(){
        $("#iddepartamento_d").change(function () {
                    $("#iddepartamento_d option:selected").each(function () {
                        departamento_d=$(this).val();
                    $.post("departamento_a_cf.php", {departamento_d:departamento_d}, function(data){
                    $("#departamento_a_cf").html(data);
                    });
                });
        })
        });
</script> 

</body>
</html>
