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
                    <h1 class="h3 mb-2 text-gray-800">MAPAS DEL PROGRAMA SAFCI</h1>
                    <p class="mb-4">En esta seccion se puede encontrar informción geográfica de los Establecimientos de Salud, Áreas de Influencia y Recursos Humanos del PROGRAMA NACIONAL SAFCI - MI SALUD.</p>

                <!-- REPORTE NACIONAL  -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">MAPA SAFCI NACIONAL</h6>
                    </div>
                <div class="card-body">
                    <div class="form-group row">
                    <div class="col-sm-6">
                    <a class="btn btn-success btn-icon-split" href="mapa_nacional.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=800,scrollbars=YES,top=50,left=200'); return false;">
                    <span class="icon text-white-50">
                        <i class="fas fa-book"></i>
                    </span>
                    <span class="text">MAPA SAFCI NACIONAL</span></a>
                    </div>
                    <div class="col-sm-6">
                    <a class="btn btn-primary btn-icon-split" href="mapa_nacional_eess.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=950,scrollbars=YES,top=50,left=200'); return false;">
                    <span class="icon text-white-50">
                        <i class="fas fa-map"></i>
                    </span>
                    <span class="text">MAPA SAFCI DE ESTABLECIMIENTOS DE SALUD</span></a>
                    </div>
                </div>
            </div>    
            </div>
            <!-- REPORTE POR DEPARTAMENTO -->
                    <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">MAPA SAFCI POR DEPARTAMENTO</h6>
                    </div>
                  
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">DEPARTAMENTO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="iddepartamento_mapa"  id="iddepartamento_mapa" class="form-control" required>
                            <option value="">-SELECCIONE-</option>
                            <?php
                            $sql1 = "SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento != '10' ";
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
                    <div class="card-body" id="mapa_ventana_departamento">                                            
                    </div>
                </div>

                    <!-- REPORTE POR MUNICIPIO -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">MAPA SAFCI POR MUNICIPIO</h6>
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
                            $sql1 = "SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento != '10'";
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
                        <h6 class="text-primary">MUNICIPIO DE LA RED DE SALUD:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="idmunicipio_salud" id="idmunicipio_salud" class="form-control" required></select>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="mapa_ventana_municipio">     
                </div>
                </div>

                <!-- MAPA POR ESTABLECIMIENTO DE SALUD Y AREAS DE INFLUENCIA -->

       <!-- REPORTE POR MUNICIPIO -->
       <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">MAPA SAFCI POR ESTABLECIMIENTO DE SALUD</h6>
                    </div>

                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">DEPARTAMENTO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="iddepartamento_e"  id="iddepartamento_e" class="form-control" required>
                            <option value="">-SELECCIONE-</option>
                            <?php
                            $sql1 = "SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento != '10' ";
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
                        <select name="idmunicipio_e" id="idmunicipio_e" class="form-control" required></select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">ESTABLECIMIENTO DE SALUD:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="idestablecimiento_e" id="idestablecimiento_e" class="form-control" required></select>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="mapa_ventana_establecimiento">     
                </div>
                </div>

                <form name="COORDENADAS" action="mapa_coordenadas_ej.php" method="post">  

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">MAPA SAFCI POR COORDENADAS</h6>
                    </div>
                  
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-4">
                        <h6 class="text-primary">LATITUD:</h6>
                            <input type="text" class="form-control" name="latitud" placeholder="Latitud" >
                        </div>
                        <div class="col-sm-4">
                        <h6 class="text-primary">LONGITUD:</h6>
                            <input type="text" class="form-control" name="longitud" placeholder="Longitud" >
                        </div>
                        <div class="col-sm-4">
                        
                        </br>
                            <button type="submit" class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-file"></i>
                            </span>
                            <span class="text">GENERAR MAPA</span>    
                            </button>
                             </form>
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
                    $.post("municipios_combo_safci.php", {departamento:departamento}, function(data){
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
                    $.post("mapa_ventana_municipio.php", {municipio_salud:municipio_salud}, function(data){
                    $("#mapa_ventana_municipio").html(data);
                    });
                });
        })
        });
    </script>
<!------ para mapa departamental --->
    <script language="javascript">
        $(document).ready(function(){
        $("#iddepartamento_mapa").change(function () {
                    $("#iddepartamento_mapa option:selected").each(function () {
                        departamento_mapa=$(this).val();
                    $.post("mapa_ventana_departamento.php", {departamento_mapa:departamento_mapa}, function(data){
                    $("#mapa_ventana_departamento").html(data);
                    });
                });
        })
        });
    </script>
    <!-----   mapas safci Ing. Gonzalo Yapuchura---->

    <script language="javascript">
        $(document).ready(function(){
        $("#iddepartamento_e").change(function () {
                    $("#iddepartamento_e option:selected").each(function () {
                        departamento_e=$(this).val();
                    $.post("municipios_combo_safci_e.php", {departamento_e:departamento_e}, function(data){
                    $("#idmunicipio_e").html(data);
                    });
                });
        })
        });
    </script> 

        <script language="javascript">
        $(document).ready(function(){
        $("#idmunicipio_e").change(function () {
                    $("#idmunicipio_e option:selected").each(function () {
                        municipio_e=$(this).val();
                    $.post("establecimiento_safci_e.php", {municipio_e:municipio_e}, function(data){
                    $("#idestablecimiento_e").html(data);
                    });
                });
        })
        });
        </script>
        <script language="javascript">
        $(document).ready(function(){
        $("#idestablecimiento_e").change(function () {
                    $("#idestablecimiento_e option:selected").each(function () {
                        establecimiento_e=$(this).val();
                    $.post("mapa_ventana_establecimiento.php", {establecimiento_e:establecimiento_e}, function(data){
                    $("#mapa_ventana_establecimiento").html(data);
                    });
                });
        })
        });
        </script>

</body>
</html>
