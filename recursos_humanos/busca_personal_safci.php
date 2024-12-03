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

$ci = $_POST['ci'];

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
                    <a href="buscar_personal.php" class="text-info">VOLVER</a>    
                    <hr>             
                </div>             

    <!-------- begin NUEVO PACIENTE --------->   

                <?php
                $numero=1; 
                $sql =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE ci='$ci'  ";
                $result = mysqli_query($link,$sql);
                if ($row = mysqli_fetch_array($result)){
                mysqli_field_seek($result,0);
                while ($field = mysqli_fetch_field($result)){
                } do {

                    $fecha_nacimiento = $row[5];
                    $dia=date("d");
                    $mes=date("m");
                    $ano=date("Y");    
                    $dianaz=date("d",strtotime($fecha_nacimiento));
                    $mesnaz=date("m",strtotime($fecha_nacimiento));
                    $anonaz=date("Y",strtotime($fecha_nacimiento));         
                    if (($mesnaz == $mes) && ($dianaz > $dia)) {
                    $ano=($ano-1); }      
                    if ($mesnaz > $mes) {
                    $ano=($ano-1);}       
                    $edad=($ano-$anonaz);  

                ?>

                <div class="text-center">    
                    <h4 class="text-info">REGISTRO ENCONTRADO</h4>                                 
                    <h4 class="text-info">LA CÉDULA DE IDENTIDAD CORRESPONDE A:</h4>                    
                </div>
       
                    <div class="form-group row">    
                    <div class="col-sm-1"></br>
                    <h6 class="text-info"><?php echo $numero;?>.-</h6>
                    </div>                           
                    <div class="col-sm-2">
                    <h6 class="text-info">CÉDULA:</h6>
                        <input type="number" class="form-control" value="<?php echo $row[4];?>" 
                        name="ci" disabled>                   
                    </div>
                    <div class="col-sm-2">
                    <h6 class="text-info">NOMBRES:</h6>
                        <input type="text" class="form-control" value="<?php echo $row[1];?>"
                        name="nombre" disabled>                
                    </div>
                    <div class="col-sm-2">
                    <h6 class="text-info">PRIMER APELLIDO:</h6>
                        <input type="text" class="form-control" value="<?php echo $row[2];?>"             
                        name="paterno" disabled >                
                    </div>
                    <div class="col-sm-2">
                    <h6 class="text-info">SEGUNDO APELLIDO:</h6>
                        <input type="text" class="form-control" value="<?php echo $row[3];?>" 
                        name="materno" disabled>                
                    </div>
                    <div class="col-sm-1">
                    <h6 class="text-info">EDAD:</h6>
                        <input type="number" class="form-control" value="<?php echo $edad;?>" 
                         name="edad_actual" disabled>
                    </div>
                    <div class="col-sm-2">
                </br>
                <?php
                $sql_r =" SELECT idpersonal, idnombre FROM personal WHERE idnombre='$row[0]' ";
                $result_r = mysqli_query($link,$sql_r);
                if ($row_r = mysqli_fetch_array($result_r)){
                mysqli_field_seek($result_r,0);
                while ($field_r = mysqli_fetch_field($result_r)){
                } do {                
                ?>
                    <a class="btn btn-info btn-icon-split" href="imprime_ficha_personal.php?idpersonal=<?php echo $row_r[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=920,height=1000,scrollbars=YES,top=50,left=200'); return false;">
                        <span class="icon text-white-50">
                            <i class="fas fa-info-circle"></i>
                        </span>
                        <span class="text">VER FICHA DE PERSONAL</span>
                    </a>
                <?php
                }
                while ($row_r = mysqli_fetch_array($result_r));
                } else {
                ?>                                       
                    <form name="SEARCH" action="valida_registro_ci.php" method="post"> 
                    <input type="hidden" value="<?php echo $row[0];?>" name="idnombre_reg">
                    <button type="submit" class="btn btn-info">VER OPCIONES</button></form>
                    <?php } ?>

                    </div>
                    </div>    
                <?php
                $numero=$numero+1;
                }
                while ($row = mysqli_fetch_array($result));
                } else { ?>

                <div class="text-center">                                     
                    <h4 class="text-danger">LA CÉDULA DE IDENTIDAD NO ESTA REGISTRADA EN SISTEMA!!!</h4>                    
                </div>     
           

                <?php } ?>


                          


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