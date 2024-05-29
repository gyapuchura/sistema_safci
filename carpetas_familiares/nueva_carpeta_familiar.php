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

$sql_lab =" SELECT dato_laboral.iddato_laboral, dato_laboral.iddepartamento, dato_laboral.idred_salud, establecimiento_salud.idmunicipio, dato_laboral.idestablecimiento_salud FROM dato_laboral, establecimiento_salud ";
$sql_lab.=" WHERE dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND dato_laboral.idnombre='$idnombre_ss' ORDER BY dato_laboral.iddato_laboral DESC LIMIT 1 ";
$result_lab=mysqli_query($link,$sql_lab);
$row_lab=mysqli_fetch_array($result_lab);
        
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
                    <h4 class="text-primary">NUEVA CARPETA FAMILIAR</h4>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

<form name="GUARDA_CARPETA" action="guarda_carpeta_familiar.php" method="post"> 

                <div class="col-lg-12">  
                    <div class="p-5"> 

                    <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">DEPARTAMENTO:</h6>
                    </div>
                    <div class="col-sm-9">

                    <input type="hidden" name="iddepartamento" value="<?php echo $row_lab[1];?>">
                    <select name="iddepartamento"  id="iddepartamento" class="form-control" disabled>

                        <?php
                        $sqlv = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$row_lab[1]'";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_lab[1]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-primary">RED DE SALUD:</h6>
                    </div>
                    <div class="col-sm-9">
                    <input type="hidden" name="idred_salud" value="<?php echo $row_lab[2];?>">
                    <select name="idred_salud"  id="idred_salud" class="form-control" disabled>
                        <?php
                        $sqlv = " SELECT idred_salud, red_salud FROM red_salud WHERE idred_salud='$row_lab[2]'";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_lab[2]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-primary">MUNICIPIO:</h6>
                    </div>
                    <div class="col-sm-9">
                    <input type="hidden" name="idmunicipio" value="<?php echo $row_lab[3];?>">
                    <select name="idmunicipio"  id="idmunicipio" class="form-control" disabled>
                    
                        <?php
                        $sqlv = " SELECT idmunicipio, municipio FROM municipios WHERE idmunicipio='$row_lab[3]'";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_lab[3]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <input type="hidden" name="idestablecimiento_salud" value="<?php echo $row_lab[4];?>">
                    <select name="idestablecimiento_salud"  id="idestablecimiento_salud" class="form-control" disabled>
                        
                        <?php
                        $sqlv = " SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud WHERE idestablecimiento_salud='$row_lab[4]'";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_lab[4]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>
                    </div>
                </div>

<!------- DATOS DEL AREA DE INFLUENCIA ---------->
      
                <hr>
                <div class="text-center">                                     
                    <h4 class="text-primary">ÁREA DE INFLUENCIA</h4>
                    <h6 class="text-primary">(COMUNIDAD/ZONA/UNIDAD-VECINAL/BARRIO):</h6>                       
                </div>
                <hr> 

                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">ÁREA DE INFLUENCIA:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idarea_influencia"  id="idarea_influencia" class="form-control" required>
                        <option selected>Seleccione</option>
                        <?php
                        $sql1 = " SELECT area_influencia.idarea_influencia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia FROM area_influencia, tipo_area_influencia, establecimiento_salud ";
                        $sql1.= " WHERE area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND area_influencia.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
                        $sql1.= " AND area_influencia.idestablecimiento_salud='$row_lab[4]' ";
                        $result1 = mysqli_query($link,$sql1);
                        if ($row1 = mysqli_fetch_array($result1)){
                        mysqli_field_seek($result1,0);
                        while ($field1 = mysqli_fetch_field($result1)){
                        } do {
                        echo "<option value=".$row1[0].">".$row1[1].".- ".$row1[2]."</option>";
                        } while ($row1 = mysqli_fetch_array($result1));
                        } else {
                        echo "No se encontraron resultados!";
                        }
                        ?>
                    </select>
                    </div>
                </div>
       
                <hr>
                <div class="text-center">                                     
                    <h4 class="text-primary">DATOS CARPETA FAMILIAR:</h4>                    
                </div>
                <hr> 

                <div class="form-group row">   
                    <div class="col-sm-3">
                    <h6 class="text-primary"></br>FECHA DE APERTURA:</h6>
                        <input type="date" class="form-control" name="fecha_apertura" value="<?php echo $fecha;?>" required>                
                    </div>                            
                    <div class="col-sm-4">
                    <h6 class="text-primary"></br>FAMILIA:</h6>
                    <textarea class="form-control" rows="2" name="familia" placeholder=""></textarea>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary">AVENIDA/CALLE</br>/CARRETERA/CAMINO:</h6>
                    <textarea class="form-control" rows="2" name="avenida_calle" placeholder=""></textarea>                  
                    </div>
                    <div class="col-sm-2">
                    <h6 class="text-primary"></br>N° DE PUERTA:</h6>
                    <input type="number" class="form-control" name="no_puerta">            
                    </div>
                </div>

                <div class="form-group row">                               
                    <div class="col-sm-3">
                    <h6 class="text-primary">NOMBRE DEL EDIFICIO, PISO Y N° DE DEPARTAMENTO:</h6>
                    <textarea class="form-control" rows="2" name="nombre_edificio" placeholder=""></textarea>               
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary"></br>LATITUD:</h6>
                    <input type="NUMBER" name="latitud" class="form-control" id="LAT" placeholder=" Seleccione LATITUD en el mapa" min="-9.662687" max="-22.908152" title="Debe ingresar latitud correspondiente a Bolivia" readonly required>            
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary"></br>LONGITUD:</h6>
                    <input type="number"  name="longitud" class="form-control" id="LONGI" placeholder="Seleccione LONGITUD en el mapa" min="-57.452675" max="-69.626293" title="Debe ingresar Longitud correspondiente a Bolivia" readonly required>              
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary"></br>ELEVACIÓN [msnm]:</h6>
                        <input type="number" class="form-control" name="altura" required>                
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-9" id="safci" style="width: 660px; height: 250px;">
                    </div>
                    <div class="col-sm-3">
                    <h6>Arrastre el marcador rojo para seleccionar la ubicacion de la VIVIENDA FAMILIAR</h6>
                    </div>
                </div> 
             <hr>   
            <div class="text-center">
            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    REGISTRAR CARPETA FAMILIAR
                    </button>  
                </div> 
            </div>                              
               <hr>             
                   <!-- modal de confirmacion de envio de datos-->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">REGISTRO DE CARPETA FAMILIAR</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            
                            Esta seguro de Registrar LA CARPETA FAMILIAR?
                        
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-primary pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form>        
                    
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

    <!-- scripts para uso de mapas -->

    <!-- scripts para calendario -->
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
        <script>$("#fecha1").datepicker($.datepicker.regional[ "es" ]);</script>

    
</body>
</html>