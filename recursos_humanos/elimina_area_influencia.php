<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$hora    = date("H:i");
$gestion = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idarea_influencia = $_POST['idarea_influencia'];

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
        <div class="card o-hidden border-0 shadow-lg my-2">
        <div class="card-body p-0">
    </br>
            
                <div class="row">
                <div class="col-lg-12">
                <div class="p-3">               
                <div class="text-center">   
                <hr>                     
                <h2 class="text-danger">IMPORTANTE</h2>

                </div>

            <?php
            $numero=1;
            $sql =" SELECT idcarpeta_familiar, codigo, familia, estado FROM carpeta_familiar WHERE idarea_influencia='$idarea_influencia' ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {
            ?>

<div class="row">
<table class="table">

  <tbody>
    <tr>
         <td> </td>
      <th scope="row"><h6 class="text-danger"><?php echo $numero; ?></h6></th>
      <td><h6 class="text-danger">NO SE PUEDE EELIMINAR !!</h6>
          <h6 class="text-danger">EL ÁREA DE INFLUENCIA:</h6>
          <h6 class="text-danger">ESTA ASOCIADA A LA CARPETA FAMILIAR:</h6></td>
      <td>
        <h6 class="text-danger">CÓDIGO:</h6><?php echo $row[1];?></td>
      <td>
        <h6 class="text-danger">FAMILIA:</h6><?php echo $row[2];?></td>
      <td>
        <h6 class="text-danger">ESTADO:</h6><?php echo $row[3];?></td>

    </tr>

  </tbody>
</table>
            </div>
         


            <?php
            $numero=$numero+1;
            }
            while ($row = mysqli_fetch_array($result));
            } else {

                $sql_d = " DELETE FROM area_influencia WHERE idarea_influencia='$idarea_influencia'";
                $result_d = mysqli_query($link,$sql_d);

                $sql8 = " INSERT INTO elimina_area_influencia (idarea_influencia, hora, fecha_eliminacion, idusuario) ";
                $sql8.= " VALUES ('$idarea_influencia','$hora','$fecha','$idusuario_ss') ";
                $result8 = mysqli_query($link,$sql8); 

            ?>
                <div class="row">
                <div class="col-lg-12">
                <div class="p-3">               
                <div class="text-center">   
                <hr>                     
                <h4 class="text-danger">El Área de Influencia</h4>
                <h4 class="text-danger">Fue eliminada de sistema !!!</h4>
                </div>
            <?php
            }
            ?>
   </div> 
            <div class="row">
                <div class="col-lg-12">
                <div class="p-3">               
                <div class="text-center"> 
             </br>
                <a href="areas_influencia_municipio.php"><h6>IR A ÁREAS DE INFLUENCIA</h6></a>
            </div> 

<!-- BEGIN aqui va el TITULO de la pagina ---->

<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

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
