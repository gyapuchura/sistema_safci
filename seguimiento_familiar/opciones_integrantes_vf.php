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

$idcarpeta_familiar_ss  = $_SESSION['idcarpeta_familiar_ss'];
$idseguimiento_cf_ss    = $_SESSION['idseguimiento_cf_ss'];
$idintegrante_cf_ss     = $_SESSION['idintegrante_cf_ss'];
$idnombre_integrante_ss = $_SESSION['idnombre_integrante_ss'];
$idgenero_ss            = $_SESSION['idgenero_ss'];
$edad_ss                = $_SESSION['edad_ss'];

$sql_cf =" SELECT idcarpeta_familiar, codigo, familia, fecha_apertura FROM carpeta_familiar WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
$result_cf=mysqli_query($link,$sql_cf);
$row_cf=mysqli_fetch_array($result_cf); 

$sql_n =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$idnombre_integrante_ss' ";
$result_n=mysqli_query($link,$sql_n);
$row_n=mysqli_fetch_array($result_n);

$sql_s =" SELECT idriesgo_personal_vf, idfrecuencia_vf FROM seguimiento_cf WHERE idseguimiento_cf='$idseguimiento_cf_ss' ";
$result_s=mysqli_query($link,$sql_s);
$row_s=mysqli_fetch_array($result_s);
        
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
                    <a href="visita_integrantes_vf.php"><h6 class="text-info"><- VOLVER</h6></a>
                    <hr>             
                    <h4 class="text-info">CARPETA FAMILIAR:</h4>
                    <h4 class="text-primary"><?php echo $row_cf[1]; ?></h4>
                    <h4 class="text-info">OPCIONES DE SEGUIMIENTO - INTEGRANTE FAMILIAR</h4>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->


                <div class="col-lg-12">  
                    <div class="p-2"> 
                
 
     <!-------- DATOS PERSONALES DEL INTEGRANTE FAMILIAR (Begin) --------->                         

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
                        <input type="number" class="form-control" value="<?php echo $edad_ss;?>" 
                         name="edad_actual" disabled>
                    </div>
                    <div class="col-sm-3">
                    </br>
                    
                    </div>
                </div>  
    <!-------- MODIFICACIÓN DE RIESGO PERSONAL (begin) --------->    
        <hr>
        <div class="text-center">                                     
            <h4 class="text-info">1.- TELÉFONO DEL INTEGRANTE PARA SEGUIMIENTO:</h4>                    
        </div>
        <hr>
 <form name="CELULAR" action="guarda_celular_vf.php" method="post">  

        <div class="form-group row">  
        <div class="col-sm-6">
            <h6 class="text-info">NÚMERO TELEFÓNICO DEL INTEGRANTE</h6>
              <input type="number" name="celular" class="form-control" >
        </div>
        <div class="col-sm-6">
            </br>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal2">
                REGISTRAR NÚMERO TELEFÓNICO
            </button>  
        </div>

        </div>    
            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">NÚMERO TELEFÓNICO DEL INTEGRANTE FAMILIAR</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">                           
                            Esta seguro de GUARDAR EL NUMERO DE TELÉFONO?                          
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-info pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form>  
                    </br>
                  
        <hr>
        <div class="text-center">                                     
            <h4 class="text-info">2.- MODIFICACIÓN DE RIESGO PERSONAL:</h4>                    
        </div>
          <form name="RIESGO" action="guarda_modifica_seguimiento_vf.php" method="post">  
        <hr>
        <div class="form-group row">  
        <div class="col-sm-4">
            <h6 class="text-info">MODIFICAR RIESGO PERSONAL</h6>
            <select name="idriesgo_personal_vf"  id="idriesgo_personal_vf" class="form-control" >
            <option selected>Seleccione</option>
            <?php
            $sqlv = " SELECT idriesgo_personal_vf, riesgo_personal_vf FROM riesgo_personal_vf ";
            $resultv = mysqli_query($link,$sqlv);
            if ($rowv = mysqli_fetch_array($resultv)){
            mysqli_field_seek($resultv,0);
            while ($fieldv = mysqli_fetch_field($resultv)){
            } do {
            ?>
            <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_s[0]) echo "selected";?> ><?php echo $rowv[1];?></option>
            <?php
            } while ($rowv = mysqli_fetch_array($resultv));
            } else {
            }
            ?>
        </select>
        </div>
        <div class="col-sm-4">
            <h6 class="text-info">MODIFICAR FRECUENCIA DE VISITAS</h6>

            <select name="idfrecuencia_vf"  id="idfrecuencia_vf" class="form-control" >
            <option selected>Seleccione</option>
            <?php
            $sqlv = " SELECT idfrecuencia_vf, frecuencia_vf FROM frecuencia_vf ";
            $resultv = mysqli_query($link,$sqlv);
            if ($rowv = mysqli_fetch_array($resultv)){
            mysqli_field_seek($resultv,0);
            while ($fieldv = mysqli_fetch_field($resultv)){
            } do {
            ?>
            <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_s[1]) echo "selected";?> ><?php echo $rowv[1];?></option>
            <?php
            } while ($rowv = mysqli_fetch_array($resultv));
            } else {
            }
            ?>
        </select>
        </div>
        <div class="col-sm-4">
                </br>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal0">
                GUARDAR CAMBIO
                </button>  
        </div>
        </div>

            <div class="modal fade" id="exampleModal0" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel0" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel0">MODIFICACIÓN DE SEGUIMIENTO PERSONAL</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">                           
                            Esta seguro de CAMBIAR EL SEGUIMIENTO DE RIESGO PERSONAL?                          
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-info pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form>  

<!-------- SUSPENSION DEL SEGUIMIENTO PERSONAL (begin) ---------> 
        </br>
 
         <hr>
        <div class="text-center">                                     
            <h4 class="text-info">3.- SUSPENSION DEL SEGUIMIENTO PERSONAL:</h4>                    
        </div>
        <hr>
 <form name="SUSPENSION" action="guarda_suspension_seguimiento_vf.php" method="post">  

        <div class="form-group row">  
        <div class="col-sm-8">
            <h6 class="text-info">MOTIVO DE LA SUSPENSION DEL SEGUIMIENTO</h6>
              <textarea class="form-control" rows="3" name="motivo_suspension" required></textarea>
        </div>
        <div class="col-sm-4">
            </br>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal1">
                SUSPENDER SEGUIMIENTO
            </button>  
        </div>

        </div>    
            <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel0" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">SUSPENSION DE SEGUIMIENTO PERSONAL</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">                           
                            Esta seguro de SUSPENDER EL SEGUIMIENTO DE RIESGO PERSONAL?                          
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-info pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form>  

   
        <!-------- ETAPA DE IDENTIFICACIÓN DEL INTEGRANTE FAMILIAR (BEGIN) --------->
          <hr>
             <div class="text-center"> 
               <a href="visita_integrantes_vf.php"><h6 class="text-success">CONTINUAR -></h6></a>                                                                   
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

    <script type="text/javascript" src="../js/localizacion.js"></script>
    <script type="text/javascript" src="../js/initMap.js"></script>

    <!-- scripts para calendario -->
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
        
    <script language="javascript">
        $(document).ready(function(){
        $("#idgrupo_cf").change(function () {
                    $("#idgrupo_cf option:selected").each(function () {
                        grupo_cf=$(this).val();
                    $.post("grupo_salud_cf.php", {grupo_cf:grupo_cf}, function(data){
                    $("#grupo_salud_cf").html(data);
                    });
                });
        })
        });
    </script> 

    
</body>
</html>