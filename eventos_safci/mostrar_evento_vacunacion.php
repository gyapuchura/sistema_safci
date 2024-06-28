<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idevento_vacunacion_ss  =  $_SESSION['idevento_vacunacion_ss'];

$sql_ev =" SELECT idevento_vacunacion, codigo, idtipo_evento_vacunacion, idvacuna, descripcion, fecha_inicio, fecha_conclusion ";
$sql_ev.=" FROM evento_vacunacion WHERE idevento_vacunacion='$idevento_vacunacion_ss' ";
$result_ev=mysqli_query($link,$sql_ev);
$row_ev=mysqli_fetch_array($result_ev);

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
                    <hr>                     
                    <h4 class="text-success">SE HA CREADO EL EVENTO:</h4>
                    <h4 class="text-secundary"><?php echo $row_ev[1];?></h4>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

                <div class="col-lg-12">  
                    <div class="p-3"> 

                <div class="form-group row">                               
                    <div class="col-sm-6">
                    <h6 class="text-primary">CATEGORÍA DEL EVENTO:</h6>

                    <select name="idtipo_evento_vacunacion"  id="idtipo_evento_vacunacion" class="form-control" disabled >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idtipo_evento_vacunacion, tipo_evento_vacunacion FROM tipo_evento_vacunacion ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_ev[2]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>
                                      
                    </div>
                    <div class="col-sm-6">
                    <h6 class="text-primary">TIPO DE EVENTO:</h6>

                    <select name="idvacuna"  id="idvacuna" class="form-control" disabled >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idvacuna, vacuna FROM vacuna ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_ev[3]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>
                 
                    </div>

                    </div>
                    <div class="form-group row"> 
                        <div class="col-sm-12">   
                        <h6 class="text-primary">DESCRIPCIÓN DEL EVENTO:</h6>
                        <textarea class="form-control" rows="2" name="descripcion" disabled><?php echo $row_ev[4];?></textarea>              
                        </div>
                    </div>

    <!-------- begin rejilla --------->   

                <div class="form-group row"> 
                        <div class="col-sm-6">   
                        <h6 class="text-primary">FECHA DE INICIO:</h6>
                        <input type="date" class="form-control" 
                        placeholder="ingresar fecha" name="fecha_inicio" value="<?php echo $row_ev[5]?>" disabled>
                        </div>
                        <div class="col-sm-6"> 
                        <h6 class="text-primary">FECHA DE CONCLUSIÓN:</h6>  
                        <input type="date" class="form-control" 
                        placeholder="ingresar fecha" name="fecha_conclusion" value="<?php echo $row_ev[6]?>" disabled>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                    <div class="form-group row">
                        <div class="col-sm-12">
                        <a href="eventos_vacunacion.php" class="btn btn-success">IR A EVENTOS DE VACUNACIÓN</a>
                        </div>
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
