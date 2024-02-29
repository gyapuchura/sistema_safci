<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$iddepartamento_ss          = $_SESSION['iddepartamento_ss'];
$idred_salud_ss             = $_SESSION['idred_salud_ss'];
$idmunicipio_ss             = $_SESSION['idmunicipio_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];

$idnotificacion_ep_ss       = $_SESSION['idnotificacion_ep_ss'];
$idregistro_enfermedad_ss   = $_SESSION['idregistro_enfermedad_ss'];
$idficha_ep_ss              = $_SESSION['idficha_ep_ss'];

$idsospecha_diag_ss         = $_SESSION['idsospecha_diag_ss'];
$idgrupo_etareo_ss          = $_SESSION['idgrupo_etareo_ss'];
$idgenero_ss                = $_SESSION['idgenero_ss'];

$idseguimiento_ep_ss        = $_SESSION['idseguimiento_ep_ss'];
$idsospecha_diag_evol_ss    = $_SESSION['idsospecha_diag_evol_ss'];

$sql = " SELECT ficha_ep.idficha_ep, ficha_ep.codigo, nombre.ci, nombre.nombre, nombre.paterno, nombre.materno, nombre.fecha_nac, ficha_ep.celular, ficha_ep.direccion, ficha_ep.latitud, ficha_ep.longitud, ficha_ep.idnombre, ficha_ep.idsospecha_diag ";
$sql.= " FROM ficha_ep, registro_enfermedad, notificacion_ep, nombre WHERE ficha_ep.idregistro_enfermedad=registro_enfermedad.idregistro_enfermedad ";
$sql.= " AND registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND ficha_ep.idnombre=nombre.idnombre ";
$sql.= " AND ficha_ep.idficha_ep='$idficha_ep_ss' ";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);

$sql_sos =" SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idsospecha_diag='$idsospecha_diag_ss'";
$result_sos = mysqli_query($link,$sql_sos);
$row_sos = mysqli_fetch_array($result_sos);

$sql_sev =" SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idsospecha_diag='$idsospecha_diag_evol_ss'";
$result_sev = mysqli_query($link,$sql_sev);
$row_sev = mysqli_fetch_array($result_sev);

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
    <link rel="stylesheet" href="../css/jquery-ui.min.css">

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
  
                <body class="bg-gradient-primary">

    <div class="container">
    </br>
        <div class="card o-hidden border-0 shadow-lg my-2">
            <div class="card-body p-0">
<!-- BEGIN aqui va el TITULO de la pagina ---->
                <div class="row">
                    <div class="col-lg-12">
                    <div class="p-3">               
                    <div class="text-center">   
                    
                    <hr>                     
                    <h4 class="text-secundary">La ficha Epidemiológica</h4>
                    <h4 class="text-primary"><?php echo $row[1];?> </h4>
                    <h4 class="text-secundary">Del(a) paciente:</h4>
                    <h4 class="text-primary"><?php echo $row[3];?> <?php echo $row[4];?> <?php echo $row[5];?></h4>
                    <h4 class="text-secundary">Con el registro epidemiológico:</h4>
                    <h4 class="text-primary"><?php echo mb_strtoupper($row_sos[1]);?></h4>
                    <h4 class="text-secundary">Ahora podra hacerse seguimiento en la bandeja de:</h4>
                    <h4 class="text-primary"><?php echo mb_strtoupper($row_sev[1]);?></h4>
                    <h4 class="text-secundary">Del Departamento, Municipio y Establecimiento de Salud correspondiente</h4>
                    <h4 class="text-secundary">En el módulo de SEGUIMIENTO EPIDEMIOLÓGICO.</h4>
                    </br>
                    <a href="fichas_ep_establecimiento.php"><h6>VOLVER A FICHAS DEL ESTABLECIMIENTO</h6></a>

                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

                <div class="form-group row">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                    </div>
                </div>                  
                    
<!-- END aqui va el comntenido de la pagina ---->
                </div>
               
                <div class="text-center">
                <hr>
                    <a class="small" href="#">PROGRAMA SAFCI - MI SALUD</a>
                </div>
                <div class="text-center">
                    <a class="small" href="#">Ministerio de Salud y Deportes</a>
                <hr>
                </div>
               
            </div>   
        </div> 
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
                    <a class="btn btn-primary" href="../salir.php">Salir de Sistema</a>
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
