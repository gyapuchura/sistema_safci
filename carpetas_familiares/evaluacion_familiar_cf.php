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

$sql_cf =" SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.codigo, ubicacion_cf.iddepartamento, ubicacion_cf.idred_salud, ubicacion_cf.idmunicipio, ubicacion_cf.idestablecimiento_salud, ";
$sql_cf.=" ubicacion_cf.idarea_influencia, carpeta_familiar.fecha_apertura, carpeta_familiar.familia, ubicacion_cf.avenida_calle, ubicacion_cf.no_puerta, ubicacion_cf.nombre_edificio, ";
$sql_cf.=" ubicacion_cf.latitud, ubicacion_cf.longitud, ubicacion_cf.altura, carpeta_familiar.fecha_registro, carpeta_familiar.hora_registro ";
$sql_cf.=" FROM carpeta_familiar, ubicacion_cf WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_cf.=" AND ubicacion_cf.ubicacion_actual='SI' AND carpeta_familiar.idcarpeta_familiar='$idcarpeta_familiar_ss' ";
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
                    <a href="evaluacion_resultados_cf.php"><h6 class="text-info"><- VOLVER</h6></a>
                    <hr>             
                    <h4 class="text-info">CARPETA FAMILIAR:</h4>
                    <h4 class="text-primary"><?php echo $row_cf[1]; ?></h4>
                    <h4 class="text-info">18.- FORMA DE AYUDA FAMILIAR NECESARIA</h4>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->



                <div class="col-lg-12">  
                    <div class="p-2"> 

                    <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">DEPARTAMENTO:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="iddepartamento"  id="iddepartamento" class="form-control" disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT iddepartamento, departamento FROM departamento ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_cf[2]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <select name="idred_salud"  id="idred_salud" class="form-control" disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idred_salud, red_salud FROM red_salud ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_cf[3]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <select name="idmunicipio"  id="idmunicipio" class="form-control" disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idmunicipio, municipio FROM municipios ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_cf[4]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <select name="idestablecimiento_salud"  id="idestablecimiento_salud" class="form-control" disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_cf[5]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>
                    </div>
                </div>

<!------- DATOS DEL AREA DE INFLUENCIA ---------->
      
                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">ÁREA DE INFLUENCIA:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idarea_influencia"  id="idarea_influencia" class="form-control" disabled>
                      
                        <?php
                        $sql1 = " SELECT area_influencia.idarea_influencia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia FROM area_influencia, tipo_area_influencia, establecimiento_salud ";
                        $sql1.= " WHERE area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND area_influencia.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
                        $sql1.= " AND area_influencia.idarea_influencia='$row_cf[6]' ";
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
                <div class="form-group row">   
                    <div class="col-sm-3">
                    <h6 class="text-primary">FECHA DE APERTURA:</h6>
                    </div>
                    <div class="col-sm-3">                    
                    <input type="date" class="form-control" name="fecha_apertura" value="<?php echo $row_cf[7];?>" disabled>                
                    </div>    
                    <div class="col-sm-1">
                    <h6 class="text-primary">FAMILIA:</h6>
                    </div>                        
                    <div class="col-sm-5">    
                    <input type="text" class="form-control" name="familia" value="<?php echo $row_cf[8];?>" disabled>                                
                    </div>
                </div>
            <hr>

            <div class="text-center">                                     
                <h4 class="text-info">18.- FORMA DE AYUDA FAMILIAR NECESARIA:</h4>                    
            </div>
          
            <div class="form-group row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped" id="example" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-info">Nª</th>
                                    <th class="text-info">FORMA DE AYUDA FAMILIAR NECESARIA:</th>
                                    <th class="text-info">FECHA DE REGISTRO</th>
                                    <th class="text-info">ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                        <?php
                                    $numero=1;
                                    $sql4 =" SELECT ayuda_familiar_cf.idayuda_familiar_cf, ayuda_familiar.ayuda_familiar, ayuda_familiar_cf.fecha_registro FROM ayuda_familiar_cf, ayuda_familiar ";
                                    $sql4.=" WHERE ayuda_familiar_cf.idayuda_familiar=ayuda_familiar.idayuda_familiar  ";
                                    $sql4.=" AND ayuda_familiar_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                                    $result4 = mysqli_query($link,$sql4);
                                    if ($row4 = mysqli_fetch_array($result4)){
                                    mysqli_field_seek($result4,0);
                                    while ($field4 = mysqli_fetch_field($result4)){
                                    } do { 
                                    ?>
                                    <tr>
                                        <td><?php echo $numero;?></td>
                                        <td><?php echo $row4[1];?></td>
                                        <td>
                                        <?php 
                                            $fecha_s = explode('-',$row4[2]);
                                            $fecha_reg = $fecha_s[2].'/'.$fecha_s[1].'/'.$fecha_s[0];
                                            echo $fecha_reg; ?>
                                        </td>
                                        <td>
                                        <form name="BORRAR" action="elimina_ayuda_familiar_cf.php" method="post">  
                                        <input type="hidden" name="idayuda_familiar_cf" value="<?php echo $row4[0];?>">
                                        <button type="submit" class="btn btn-danger">QUITAR</button></form>
                                        </td>
                                    </tr>                            
                                    <?php
                                    $numero=$numero+1;
                                    }
                                    while ($row4 = mysqli_fetch_array($result4));
                                    } else {
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>  
     <!-------- INGRESA DATOS DEL IDIOMA (Begin) --------->             
            
     <hr>
       
     <!-------- ETAPA DEL CICLO FAMILIAR (Begin) --------->   
    
            <form name="AYUDA_FAMILIAR" action="guarda_ayuda_familiar_cf.php" method="post">                   

                <div class="form-group row">  
                    <div class="col-sm-3"></div>    
                    <div class="col-sm-9"> 
                    <h6>1. Ayuda Educativa <input type="checkbox" class="form-group" name="idayuda_familiar[0]" value="1" ></h6>  
                    <h6>2. Ayuda Terapéutica <input type="checkbox" class="form-group" name="idayuda_familiar[1]" value="2"></h6>  
                    <h6>3. Ayuda Comunitaria <input type="checkbox" class="form-group" name="idayuda_familiar[2]" value="3"></h6>  
                    </div>
                </div>
                <hr>
                    <div class="text-center">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModale">
                        AGREGAR AYUDA FAMILIAR
                        </button>  
                    </div>  
    
                <!-- modal de confirmacion de envio de datos-->
                <div class="modal fade" id="exampleModale" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">AYUDA FAMILIAR</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">                                    
                                    Esta seguro de agregar la AYUDA FAMILIAR? ?
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
               <a href="consolidacion_carpeta_familiar.php"><h6 class="text-info">CONSOLIDACIÓN DE CARPETA FAMILIAR -></h6></a>                                                                   
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