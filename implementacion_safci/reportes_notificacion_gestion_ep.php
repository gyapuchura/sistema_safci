<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram  = date("Ymd");
$fecha 	    = date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$gestion_ss     =  $_SESSION['gestion_ss'];

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
                    <h1 class="h3 mb-2 text-primary-800">GESTIÓN <?php echo $gestion_ss?></h1>
                    <p class="mb-4">En esta seccion se puede encontrar informción sobre Vigilancia Epidemiológica del PROGRAMA NACIONAL SAFCI - MI SALUD por GESTIÓN</p>

                <!-- REPORTE ENFERMEDAD NACIONAL  -->

                <div class="card shadow mb-4">
                    <div class="card-header py-3">                    
                        <a href="reporte_enfermedad_nacional.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=800,scrollbars=YES,top=50,left=150'); return false;">
                        <h6 class="m-0 font-weight-bold text-info">REPORTE PORCENTUAL F302A NACIONAL GESTIÓN <?php echo $gestion_ss?></h6></a>

                    </div>
                  
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-4">
                        <h6 class="text-info">ELEGIR SECCION F302A:</h6>
                        </div>
                        <div class="col-sm-8">
                        <select name="idcat_registro"  id="idcat_registro" class="form-control" required>
                            <option value="">-SELECCIONE-</option>
                            <?php
                            $sql1 = " SELECT idcat_registro, cat_registro FROM cat_registro  ";
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
                    <div class="card-body" id="vigilancia_enf_nal_gestion"></div>
                </div>

            
            <!-- REPORTE NACIONAL -->




                    <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">REPORTE EPIDEMIOLÓGICO NACIONAL - GESTIÓN <?php echo $gestion_ss?></h6>
                    </div>
                  
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-4">
                        <h6 class="text-primary">ELEGIR REGISTRO EPIDEMIOLÓGICO:</h6>
                        </div>
                        <div class="col-sm-8">
                        <select name="idsospecha_diag_nal"  id="idsospecha_diag_nal" class="form-control" required>
                            <option value="">-SELECCIONE-</option>
                            <?php
                            $sql1 = " SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag ";
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
                    <div class="card-body" id="vigilancia_ep_nal_gestion"></div>
                </div>
                    
     <!-- REPORTE DE EVENTOS DE NOTIFICACIÓN -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">REPORTE EVENTOS DE NOTIFICACIÓN INMEDIATA - GESTIÓN <?php echo $gestion_ss?></h6>
                    </div>

                <div class="card-body">
                   
                    <div class="form-group row">
                        <div class="col-sm-4">
                        <h6 class="text-primary">ELEGIR EVENTO:</h6>
                        </div>
                        <div class="col-sm-8">
                        <select name="idevento_notificacion" id="idevento_notificacion" class="form-control" required>
                        <option value="">-SELECCIONE-</option>
                        <?php
                            $sql2 = " SELECT idevento_notificacion, evento_notificacion FROM evento_notificacion ";
                            $result2 = mysqli_query($link,$sql2);
                            if ($row2 = mysqli_fetch_array($result2)){
                            mysqli_field_seek($result2,0);
                            while ($field2 = mysqli_fetch_field($result2)){
                            } do {
                            echo "<option value=".$row2[0].">".$row2[1]."</option>";
                            } while ($row2 = mysqli_fetch_array($result2));
                            } else {
                            echo "No se encontraron resultados!";
                            }
                        ?>
                        </select>
                        </div>
                    </div>
                </div>
                    <div class="card-body" id="vigilancia_evento_gestion"></div>
                </div>

       <!-- REPORTE POR MUNICIPIO -->


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
        $("#idcat_registro").change(function () {
                    $("#idcat_registro option:selected").each(function () {
                        cat_registro=$(this).val();
                    $.post("vigilancia_enf_nal_gestion.php", {cat_registro:cat_registro}, function(data){
                    $("#vigilancia_enf_nal_gestion").html(data);
                    });
                });
        })
        });
    </script>

    <script language="javascript">
        $(document).ready(function(){
        $("#idsospecha_diag_nal").change(function () {
                    $("#idsospecha_diag_nal option:selected").each(function () {
                        sospecha_diag_nal=$(this).val();
                    $.post("vigilancia_ep_nal_gestion.php", {sospecha_diag_nal:sospecha_diag_nal}, function(data){
                    $("#vigilancia_ep_nal_gestion").html(data);
                    });
                });
        })
        });
    </script>

    <script language="javascript">
        $(document).ready(function(){
        $("#idevento_notificacion").change(function () {
                    $("#idevento_notificacion option:selected").each(function () {
                        evento_notificacion=$(this).val();
                    $.post("vigilancia_evento_gestion.php", {evento_notificacion:evento_notificacion}, function(data){
                    $("#vigilancia_evento_gestion").html(data);
                    });
                });
        })
        });
    </script>

</body>
</html>
