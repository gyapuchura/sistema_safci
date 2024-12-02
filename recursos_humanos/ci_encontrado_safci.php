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

$idnombre_reg_ss     =  $_SESSION['idnombre_reg_ss'];

$sql_n =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$idnombre_reg_ss' ";
$result_n=mysqli_query($link,$sql_n);
$row_n=mysqli_fetch_array($result_n);

$fecha_nacimiento = $row_n[5];
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
                    <h4 class="text-info">REGISTRO ENCONTRADO</h4>
                    <hr> 
                    </div>

    <!-------- begin NUEVO PACIENTE --------->   
                <div class="text-center">                                     
                    <h4 class="text-info">LA CÉDULA DE IDENTIDAD CORRESPONDE A:</h4>                    
                </div>
                <hr> 

                <div class="form-group row">                               

                    <div class="col-sm-3">
                    <h6 class="text-info">CÉDULA DE IDENTIDAD:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_n[4];?>" 
                         name="ci" disabled>
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">NOMBRES:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_n[1];?>"
                         name="nombre" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">PRIMER APELLIDO:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_n[2];?>"             
                         name="paterno" disabled >                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">SEGUNDO APELLIDO:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_n[3];?>" 
                         name="materno" disabled>                
                    </div>
                </div>

                <div class="form-group row">  
                    <div class="col-sm-3">
                    <h6 class="text-info">GÉNERO</h6>

                    <select name="idgenero"  id="idgenero" class="form-control" disabled >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idgenero, genero FROM genero ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_n[7]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>

                    </div>  
                    <div class="col-sm-3">
                    <h6 class="text-info">FECHA DE NACIMIENTO:</h6>
                        <input type="date"  class="form-control" 
                            placeholder="ingresar fecha" name="fecha_nac" value="<?php echo $row_n[5];?>" disabled>
                    </div>   
                    
                    <div class="col-sm-3">
                    <h6 class="text-info">EDAD:</h6>
                        <input type="number" class="form-control" value="<?php echo $edad;?>" 
                         name="edad_actual" disabled>
                    </div>
                    <div class="col-sm-3">
                    </br>
                    <a href="modificar_integrante_cf.php"><h6 class="text-info">MODIFICAR</br>DATOS PERSONALES</h6></a>
                    </div>
                </div>  
            <hr>
<!------- datos de los signos vitales del paciente ---------->
<form name="GUARDA_CI" action="registrar_ci_medisafci.php" method="post">  
          
            <div class="text-center">
            <div class="form-group row">
                <div class="col-sm-6">
       
                </div> 
                <div class="col-sm-6">

                <button type="submit" class="btn btn-info">CREAR USUARIO MEDI-SAFCI</button></form>
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