<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idcarpeta_familiar_ss = $_SESSION['idcarpeta_familiar_ss'];

$sql_cf =" SELECT idcarpeta_familiar, codigo, familia, fecha_apertura FROM carpeta_familiar WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
$result_cf=mysqli_query($link,$sql_cf);
$row_cf=mysqli_fetch_array($result_cf); 
        
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
        <div class="card o-hidden border-0 shadow-lg my-1">
            <div class="card-body p-0">
<!-- BEGIN aqui va el TITULO de la pagina ---->
                <div class="row">
                    <div class="col-lg-12">
                    <div class="p-3">               
                    <div class="text-center">                          
                    <a href="determinantes_salud_cf4.php"><h6 class="text-info"><- VOLVER</h6></a>
                    <hr>             
                    <h4 class="text-info">CARPETA FAMILIAR:</h4>
                    <h4 class="text-primary"><?php echo $row_cf[1]; ?></h4>
                    <h4 class="text-info">12.- CARACTERÍSTICAS SOCIOECONÓMICAS</h4>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

                <div class="col-lg-12">  
                    <div class="p-2"> 

                <div class="form-group row">   
                    <div class="col-sm-3">
                    <h6 class="text-primary">FECHA DE APERTURA:</h6>
                    </div>
                    <div class="col-sm-3">                    
                    <input type="date" class="form-control" name="fecha_apertura" value="<?php echo $row_cf[3];?>" disabled>                
                    </div>    
                    <div class="col-sm-1">
                    <h6 class="text-primary">FAMILIA:</h6>
                    </div>                        
                    <div class="col-sm-5">    
                    <input type="text" class="form-control" name="familia" value="<?php echo $row_cf[2];?>" disabled>                                
                    </div>
                </div>
            <hr>

            <div class="text-center">                                     
                <h4 class="text-info">12.- CARACTERÍSTICAS SOCIOECONÓMICAS:</h4>                    
            </div>
          
            <div class="form-group row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped" id="example" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-info">Nª</th>
                                    <th class="text-info">EL HOGAR TIENE:</th>
                                    <th class="text-info">SI / NO</th>
                                </tr>
                            </thead>
                            <tbody>
                                        <?php
                                    $numero=1;
                                    $sql4 =" SELECT socio_economica_cf.idsocio_economica_cf, socio_economica.socio_economica, socio_economica_cf.valor ";
                                    $sql4.=" FROM socio_economica, socio_economica_cf WHERE socio_economica_cf.idsocio_economica=socio_economica.idsocio_economica ";
                                    $sql4.=" AND socio_economica_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                                    $result4 = mysqli_query($link,$sql4);
                                    if ($row4 = mysqli_fetch_array($result4)){
                                    mysqli_field_seek($result4,0);
                                    while ($field4 = mysqli_fetch_field($result4)){
                                    } do { 
                                    ?>
                                    <tr>
                                        <td><?php echo $numero;?></td>
                                        <td><?php echo $row4[1];?></td>
                                        <td><?php echo $row4[2];?></td>
                                    </tr>                            
                                    <?php
                                    $numero=$numero+1;
                                    }
                                    while ($row4 = mysqli_fetch_array($result4));
                                    } else {
                                    }
                                ?>
                                <tr>                                     
                                    <td></td>
                                    <td></td>
                                    <td>
                                    <form name="BORRAR" action="elimina_socioeconomica_cf.php" method="post">  
                                        <input type="hidden" name="idsocio_economica_cf" value="<?php echo $row4[0];?>">
                                        <button type="submit" class="btn btn-danger">QUITAR</button>
                                    </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>  
     <!-------- INGRESA DATOS DEL IDIOMA (Begin) --------->             
            
     <hr>
            <form name="SOCIO_ECONOMICA" action="guarda_socioeconomica_cf.php" method="post">                   

                <div class="form-group row">
                    <div class="col-sm-2">                          
                    </div>
                    <div class="col-sm-6">
                    <h6 class="text-info">EL HOGAR TIENE:</h6>
                   
                    </div>
                    <div class="col-sm-4">
                    <h6 class="text-info">NO / SI:</h6>
                       
                    </div>
                </div>
                <div class="form-group row">
                <div class="col-sm-2"></div>
                <div class="col-sm-6"><h6 class="text-info">1. Refrigerador o freezer </h6>
                                      <h6 class="text-info">2. Computadora / laptop </h6>
                                      <h6 class="text-info">3. Televisor </h6>
                                      <h6 class="text-info">4. Horno microondas </h6>
                                      <h6 class="text-info">5. Lavadora / Secadora de ropa </h6>  
                                      <h6 class="text-info">6. Aire acondicionado </h6>    
                                      <h6 class="text-info">7. Estufa </h6>
                                      <h6 class="text-info">8. Automóvil (uso del hogar) </h6>
                                      <h6 class="text-info">9. Servicio de internet </h6>  
                                      <h6 class="text-info">10. Servicio de televisión por cable o antena parabólica </h6>                      
                </div>        
                <div class="col-sm-4">
                <h6 class="text-info"> NO <input type="radio" name="valor4[0]" value="NO" checked> SI <input type="radio" name="valor4[0]" value="SI" ></h6>  
                <h6 class="text-info"> NO <input type="radio" name="valor4[1]" value="NO" checked> SI <input type="radio" name="valor4[1]" value="SI" ></h6>  
                <h6 class="text-info"> NO <input type="radio" name="valor4[2]" value="NO" checked> SI <input type="radio" name="valor4[2]" value="SI" ></h6> 
                <h6 class="text-info"> NO <input type="radio" name="valor4[3]" value="NO" checked> SI <input type="radio" name="valor4[3]" value="SI" ></h6>
                <h6 class="text-info"> NO <input type="radio" name="valor4[4]" value="NO" checked> SI <input type="radio" name="valor4[4]" value="SI" ></h6> 
                <h6 class="text-info"> NO <input type="radio" name="valor4[5]" value="NO" checked> SI <input type="radio" name="valor4[5]" value="SI" ></h6>
                <h6 class="text-info"> NO <input type="radio" name="valor4[6]" value="NO" checked> SI <input type="radio" name="valor4[6]" value="SI" ></h6> 
                <h6 class="text-info"> NO <input type="radio" name="valor4[7]" value="NO" checked> SI <input type="radio" name="valor4[7]" value="SI" ></h6>
                <h6 class="text-info"> NO <input type="radio" name="valor4[8]" value="NO" checked> SI <input type="radio" name="valor4[8]" value="SI" ></h6> 
                <h6 class="text-info"> NO <input type="radio" name="valor4[9]" value="NO" checked> SI <input type="radio" name="valor4[9]" value="SI" ></h6>
                </div>
                </div>


               
                    <div class="text-center">

                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModald">
                        AGREGAR CARACTERÍSTICA
                        </button>  
                    </div>  
                

                <!-- modal de confirmacion de envio de datos-->
                <div class="modal fade" id="exampleModald" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">CARACTERISTICAS SOCIOECONÓMICAS</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">                                    
                                    Esta seguro de agregar la caracteristica Socioeconómica? ?
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                <button type="submit" class="btn btn-info pull-center">CONFIRMAR</button>    
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


 
                <hr>
            <div class="text-center"> 
               <a href="tenencia_animales_cf.php"><h6 class="text-info">TENENCIA DE ANIMALES --></h6></a>                                                                   
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

    <!-- scripts para uso de mapas -->


    <!-- scripts para calendario -->
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
        <script>$("#fecha1").datepicker($.datepicker.regional[ "es" ]);</script>

    
</body>
</html>