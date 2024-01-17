<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$iddepartamento_ss          = $_SESSION['iddepartamento_ss'];
$idred_salud_ss             = $_SESSION['idred_salud_ss'];
$idmunicipio_ss             = $_SESSION['idmunicipio_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idnotificacion_ep_ss       = $_SESSION['idnotificacion_ep_ss'];
$idsospecha_diag_ss         = $_SESSION['idsospecha_diag_ss'];

$sql =" SELECT notificacion_ep.idnotificacion_ep, notificacion_ep.codigo, departamento.departamento, red_salud.red_salud,  ";
$sql.=" municipios.municipio, establecimiento_salud.establecimiento_salud, notificacion_ep.semana_ep, ";
$sql.=" notificacion_ep.fecha_registro, notificacion_ep.hora_registro, nombre.nombre, nombre.paterno, nombre.materno, ";
$sql.=" notificacion_ep.iddepartamento, notificacion_ep.idred_salud, notificacion_ep.idmunicipio, notificacion_ep.idestablecimiento_salud ";
$sql.=" FROM notificacion_ep, departamento, red_salud, municipios, establecimiento_salud, usuarios, nombre ";
$sql.=" WHERE notificacion_ep.iddepartamento=departamento.iddepartamento AND notificacion_ep.idred_salud=red_salud.idred_salud ";
$sql.=" AND notificacion_ep.idmunicipio=municipios.idmunicipio AND notificacion_ep.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
$sql.=" AND notificacion_ep.idusuario=usuarios.idusuario AND usuarios.idnombre=nombre.idnombre AND notificacion_ep.idnotificacion_ep='$idnotificacion_ep_ss ' ";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);

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
        <div class="card o-hidden border-0 shadow-lg my-0">
            <div class="card-body p-0">
<!-- BEGIN aqui va el TITULO de la pagina ---->
                <div class="row">
                    <div class="col-lg-12">
                    <div class="p-3">               
                    <div class="text-center"> 
           
                    <hr>                     
                    <h2 class="text-success">ADMINISTRAR NOTIFICACIÓN</h2>
                    <h4 class="text-success"><?php echo $row[1];?></h4>
                    
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->
                <hr>

            <hr>
            <div class="text-center"> 
            <div class="form-group row">
                    <div class="col-sm-12">
                        <h6>PUEDE OBERVAR O DESCONSOLIDAR LA NOTIFICACIÓN GENERADO POR EL USUARIO ADM-MUNICIPAL</h6>
                    </div>
            </div>    
            </div>            
            
            <div class="text-center"> 
            <div class="form-group row">
                    <div class="col-sm-4">
                    <a href="imprime_notificacion_ep.php?idnotificacion_ep=<?php echo $row[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=650,scrollbars=YES,top=50,left=200'); return false;">IMPRIME NOTIFICACIÓN</a>
                    </div>
                    <div class="col-sm-4">
                    <form name="DESCONSOLIDA" action="guarda_desconsolida_notificacion_ep.php" method="post">    

                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal">
                                DESCONSOLIDAR NOTIFICACIÓN
                                </button>  
                                                       
                   <!-- modal de confirmacion de envio de datos-->
                   <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">DESCONSOLIDAR NOTIFICACIÓN</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    
                                    Esta seguro de DESCONSOLIDAR la Notificacion?
                                    , posteriormente la misma estara disponible para su edición.

                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                <button type="submit" class="btn btn-warning pull-center">CONFRMAR DESCONSOLIDACIÓN</button>    
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                    <!-- Modal -->
                    </div>
                    <div class="col-sm-4">
                    <a href="notificaciones_vigilancia_ep_adm.php"><h6 class="text-success">SALIR <i class="fas fa-fw fa-arrow-right"></i></h6></a>    
                    </div>
            </div>    
            </div>
    </div>                
    <!-------- begin rejilla --------->   

    <!-------- end rejilla --------->                      
                <div class="text-center">

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
    <!-- scripts para calendario -->
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
        <script>$("#fecha1").datepicker($.datepicker.regional[ "es" ]);</script>   
</body>
</html>