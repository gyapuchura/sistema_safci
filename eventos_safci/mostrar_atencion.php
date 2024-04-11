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

$idevento_safci_ss    = $_SESSION['idevento_safci_ss'];
$idnombre_paciente_ss = $_SESSION['idnombre_paciente_ss'];
$idatencion_safci_ss  = $_SESSION['idatencion_safci_ss'];
$idsigno_vital_ss     = $_SESSION['idsigno_vital_ss'];

$sql_ev =" SELECT idevento_safci, iddepartamento, idmunicipio, idestablecimiento_salud, codigo, idcat_evento_safci, ";
$sql_ev.=" idtipo_evento_safci, descripcion FROM evento_safci WHERE idevento_safci='$idevento_safci_ss' ";
$result_ev=mysqli_query($link,$sql_ev);
$row_ev=mysqli_fetch_array($result_ev);

$sql_n =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$idnombre_paciente_ss' ";
$result_n=mysqli_query($link,$sql_n);
$row_n=mysqli_fetch_array($result_n);

$sql_at =" SELECT idatencion_safci, codigo, edad FROM atencion_safci WHERE idatencion_safci='$idatencion_safci_ss' ";
$result_at=mysqli_query($link,$sql_at);
$row_at=mysqli_fetch_array($result_at);

$sql_sg =" SELECT idsigno_vital, frec_cardiaca, peso, talla, frec_respiratoria, presion_arterial, temperatura, saturacion, combe, imc, presion_arterial_d, alergia, descripcion_alergia FROM signo_vital WHERE idsigno_vital ='$idsigno_vital_ss' ";
$result_sg=mysqli_query($link,$sql_sg);
$row_sg=mysqli_fetch_array($result_sg);

$presion = $row_sg[5]."/".$row_sg[10];
    
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
                    <h6 class="text-success">SE HA GENERADO EL CÓDIGO:</h6>        
                    <h4 class="text-primary"><?php echo $row_at[1];?></h4>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

                <div class="col-lg-12">  
                    <div class="p-5"> 

                    <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">CODIGO EVENTO:</h6>
                    </div>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?php echo $row_ev[4];?>"
                         name="evento" disabled> 
                    </div>
                    </div>
    
                    <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">DEPARTAMENTO:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="iddepartamento"  id="iddepartamento" class="form-control" disabled >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT iddepartamento, departamento FROM departamento ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_ev[1]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>

                    </div>
                </div>
   
                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">MUNICIPIO DEL EVENTO:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idmunicipio"  id="idmunicipio" class="form-control" disabled >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idmunicipio, municipio FROM municipios ";
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
                </div>

                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">ESTABLECIMIENTO DE SALUD:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idestablecimiento_salud"  id="idestablecimiento_salud" class="form-control" disabled >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud ";
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
    <!-------- begin NUEVO PACIENTE --------->   
                <hr>
                <div class="text-center">                                     
                    <h4 class="text-primary">DATOS DEL PACIENTE:</h4>                    
                </div>
                <hr> 

                <div class="form-group row">                               

                    <div class="col-sm-3">
                    <h6 class="text-primary">CÉDULA DE IDENTIDAD:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_n[4];?>" 
                         name="ci" disabled>
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary">NOMBRES:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_n[1];?>"
                         name="nombre" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary">PRIMER APELLIDO:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_n[2];?>"             
                         name="paterno" disabled >                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary">SEGUNDO APELLIDO:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_n[3];?>" 
                         name="materno" disabled>                
                    </div>
                </div>

                <div class="form-group row">  
                    <div class="col-sm-3">
                    <h6 class="text-primary">GÉNERO</h6>

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
                    <h6 class="text-primary">FECHA DE NACIMIENTO:</h6>
                        <input type="date"  class="form-control" 
                            placeholder="ingresar fecha" name="fecha_nac" value="<?php echo $row_n[5];?>" disabled>
                    </div>   
                    
                    <div class="col-sm-3">
                    <h6 class="text-primary">EDAD:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_at[2];?>" 
                         name="edad_actual" disabled>
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary"> </h6>
                    
                    </div>
                </div>  

<!------- datos de los signos vitales del paciente ---------->
                
                <hr>
                <div class="text-center">                                     
                    <h4 class="text-primary">DATOS SIGNOS VITALES:</h4>                    
                </div>
                <hr> 

                <div class="form-group row">                               
                    <div class="col-sm-3">
                    <h6 class="text-primary">FRECUENCIA CARDIACA [lpm]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[1];?>" disabled
                         name="frec_cardiaca">                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary">PESO </br>[kg]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[2];?>" disabled           
                         name="peso" >                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary">TALLA </br>[mtrs.]:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_sg[3];?>" disabled 
                         name="talla">                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary">I.M.C.:</br></br></h6>
                        <input type="text" class="form-control" value="<?php 
                        $indice = number_format($row_sg[9], 4, '.', '');
                        echo $indice;?>" disabled 
                         name="talla">                
                    </div>

                </div>

                <div class="form-group row">                               
                    <div class="col-sm-3">
                    <h6 class="text-primary">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[4];?>" disabled
                         name="frec_respiratoria">                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary">PRESIÓN ARTERIAL </br>[mmHg]:</h6>
                        <input type="text" class="form-control" value="<?php echo $presion;?>" disabled            
                         name="presion_arterial" >                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary">TEMPERATURA </br>[°C]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[6];?>" disabled
                         name="temperatura">                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary">SATURACIÓN </br>[% O2]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[7];?>" disabled
                         name="saturacion">                
                    </div>
                </div>

                <div class="form-group row">  
                    <div class="col-sm-3">
                    <h6 class="text-primary">COMBE:</h6>
                     <input type="text" class="form-control" value="<?php echo $row_sg[8];?>" disabled
                         name="combe">                 
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary">ES ALERGICO? :</h6>
                    <input type="text" class="form-control" value="<?php echo $row_sg[11];?>" disabled
                         name="combe">                  
                    </div>
                    <div class="col-sm-6">
                    <h6 class="text-primary">DESCRIPCIÓN DE LA ALÉRGIA</h6>
                    <textarea class="form-control" rows="2" name="descripcion_alergia" disabled><?php echo $row_sg[12];?></textarea> 
                    </div>

                </div>

                <hr>

                <div class="text-center">
                    <div class="form-group row">
                        <div class="col-sm-4">
                        <a href="nuevo_paciente.php" class="btn btn-info">REGISTRAR NUEVO</a>
                        </div>
                        <div class="col-sm-4">
                        <a href="registro_pacientes.php" class="btn btn-success">IR A REGISTRO DE PACIENTES</a>
                        </div>
                        <div class="col-sm-4">                       
                       </div>
                    </div>                               
                </div> 

    <!-------- END NUEVO PACIENTE --------->  
                              
                    
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

    <script type="text/javascript" src="../js/localizacion.js"></script>
    <script type="text/javascript" src="../js/initMap.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwC0dKzZNKNbnzsslPYLNSExYd8uLqRIk&callback=initMap"></script>

    <!-- scripts para calendario -->
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
        <script>$("#fecha1").datepicker($.datepicker.regional[ "es" ]);</script>

    
</body>
</html>