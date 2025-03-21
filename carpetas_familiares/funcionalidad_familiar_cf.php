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
                    <a href="estructura_etapa_cf.php"><h6 class="text-info"><- VOLVER</h6></a>
                    <hr>             
                    <h4 class="text-info">CARPETA FAMILIAR:</h4>
                    <h4 class="text-primary"><?php echo $row_cf[1]; ?></h4>
                    <h4 class="text-info">16.- FUNCIONALIDAD FAMILIAR</h4>
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
                <h4 class="text-info">16.1.- CRISIS FAMILIAR:</h4>                    
            </div>
          
            <div class="form-group row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped" id="example" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-info">Nª</th>
                                    <th class="text-info">CRISIS FAMILIAR:</th>
                                    <th class="text-info">FECHA DE REGISTRO</th>
                                    <th class="text-info">ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                        <?php
                                    $numero=1;
                                    $sql4 =" SELECT funcionalidad_familiar_cf.idfuncionalidad_familiar_cf, funcionalidad_familiar.funcionalidad_familiar, funcionalidad_familiar_cf.fecha_registro ";
                                    $sql4.=" FROM funcionalidad_familiar_cf, funcionalidad_familiar WHERE funcionalidad_familiar_cf.idfuncionalidad_familiar=funcionalidad_familiar.idfuncionalidad_familiar ";
                                    $sql4.=" AND funcionalidad_familiar_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' AND funcionalidad_familiar.crisis_familiar='SI' ";
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
                                        <form name="BORRAR" action="elimina_crisis_familiar_cf.php" method="post">  
                                        <input type="hidden" name="idfuncionalidad_familiar_cf" value="<?php echo $row4[0];?>">
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
            <form name="CRISIS_FAMILIAR" action="guarda_crisis_familiar_cf.php" method="post">                   

                <div class="form-group row">
                    <div class="col-sm-3"></div>        
                    <div class="col-sm-9">
                    <h6>Desmembramiento* <input type="radio" class="form-group" name="idfuncionalidad_familiar" value="1" checked ></h6>  
                    <h6>Incremento* <input type="radio" class="form-group" name="idfuncionalidad_familiar" value="2" ></h6> 
                    <h6>Desmoralización* <input type="radio" class="form-group" name="idfuncionalidad_familiar" value="3" ></h6> 
                    <h6>Desorganización* <input type="radio" class="form-group" name="idfuncionalidad_familiar" value="4" ></h6>
                    </div>
                </div>
                <hr>
                    <div class="text-center"> <h6 class="text-info">Agregar SOLO si hay crisis familiar</h6>
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModald">
                        AGREGAR
                        </button>  
                    </div>  
    
                <!-- modal de confirmacion de envio de datos-->
                <div class="modal fade" id="exampleModald" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">CRISIS FAMILIAR</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">                                    
                                    Esta seguro de agregar la CRISIS FAMILIAR? ?
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
     <!-------- ETAPA DEL CICLO FAMILIAR (Begin) --------->   

                <div class="text-center">                                     
                <h4 class="text-info">16.2.- FUNCIONALIDAD FAMILIAR:</h4>                    
            </div>
          
        
            <div class="form-group row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped" id="example" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-info">Nª</th>
                                    <th class="text-info">FUNCIONALIDAD FAMILIAR:</th>
                                    <th class="text-info">FECHA DE REGISTRO</th>
                                    <th class="text-info">ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                    $numero5=1;
                                    $sql5 =" SELECT funcionalidad_familiar_cf.idfuncionalidad_familiar_cf, funcionalidad_familiar.funcionalidad_familiar, funcionalidad_familiar_cf.fecha_registro ";
                                    $sql5.=" FROM funcionalidad_familiar_cf, funcionalidad_familiar WHERE funcionalidad_familiar_cf.idfuncionalidad_familiar=funcionalidad_familiar.idfuncionalidad_familiar ";
                                    $sql5.=" AND funcionalidad_familiar_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' AND funcionalidad_familiar.crisis_familiar='NO' ";
                                    $result5 = mysqli_query($link,$sql5);
                                    if ($row5 = mysqli_fetch_array($result5)){
                                    mysqli_field_seek($result5,0);
                                    while ($field5 = mysqli_fetch_field($result5)){
                                    } do { 
                                    ?>
                                    <tr>
                                        <td><?php echo $numero5;?></td>
                                        <td><?php echo $row5[1];?></td>
                                        <td>
                                        <?php 
                                            $fecha_s = explode('-',$row5[2]);
                                            $fecha_reg = $fecha_s[2].'/'.$fecha_s[1].'/'.$fecha_s[0];
                                            echo $fecha_reg; ?>
                                        </td>
                                        <td>
                                        <form name="BORRAR" action="elimina_funcionalidad_familiar_cf.php" method="post">  
                                        <input type="hidden" name="idfuncionalidad_familiar_cf" value="<?php echo $row5[0];?>">
                                        <button type="submit" class="btn btn-danger">QUITAR</button></form>
                                        </td>
                                    </tr>                            
                                    <?php
                                    $numero5=$numero5+1;
                                    }
                                    while ($row5 = mysqli_fetch_array($result5));
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

     <?php
        $numero_f=1;
        $sql_f =" SELECT fecha_registro FROM funcionalidad_familiar_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' GROUP BY fecha_registro ORDER BY fecha_registro";
        $result_f = mysqli_query($link,$sql_f);
        if ($row_f = mysqli_fetch_array($result_f)){
        mysqli_field_seek($result_f,0);
        while ($field_f = mysqli_fetch_field($result_f)){
        } do { 
        ?>

            <div class="form-group row">  
                <div class="col-sm-2"><h6 class="text-info">VISITA: <?php echo $numero_f; ?></h6></div>  
                <div class="col-sm-5"><h6 class="text-info">EVALUACIÓN DE LA FUNCIONALIDAD FAMILIAR:</h6></div>    
                <div class="col-sm-2">
                    <?php
                        $sql_ev =" SELECT funcionalidad_familiar_cf.idfuncionalidad_familiar_cf, funcionalidad_familiar.funcionalidad_familiar, funcionalidad_familiar_cf.fecha_registro ";
                        $sql_ev.=" FROM funcionalidad_familiar_cf, funcionalidad_familiar WHERE funcionalidad_familiar_cf.idfuncionalidad_familiar=funcionalidad_familiar.idfuncionalidad_familiar ";
                        $sql_ev.=" AND funcionalidad_familiar_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' AND funcionalidad_familiar.funcional='NO' AND funcionalidad_familiar_cf.fecha_registro='$row_f[0]' ";
                        $result_ev = mysqli_query($link,$sql_ev);
                        if ($row_ev = mysqli_fetch_array($result_ev)){

                            echo " <h6 class='text-danger'>DISFUNCIONAL</h6>";
                                
                            } else {

                                $sql_dev =" SELECT funcionalidad_familiar_cf.idfuncionalidad_familiar_cf, funcionalidad_familiar.funcionalidad_familiar, funcionalidad_familiar_cf.fecha_registro ";
                                $sql_dev.=" FROM funcionalidad_familiar_cf, funcionalidad_familiar WHERE funcionalidad_familiar_cf.idfuncionalidad_familiar=funcionalidad_familiar.idfuncionalidad_familiar ";
                                $sql_dev.=" AND funcionalidad_familiar_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' AND funcionalidad_familiar.funcional='SI' AND funcionalidad_familiar_cf.fecha_registro='$row_f[0]' ";
                                $result_dev = mysqli_query($link,$sql_dev);
                                if ($row_dev = mysqli_fetch_array($result_dev)){
                                    echo "<h6 class='text-primary'>FUNCIONAL </h6>";
                                } else {
                                    echo " <h6> SIN EVALUAR  </h6>";
                                }                                
                            }                                
                    ?>
                </div>
                <div class="col-sm-3"><h6 class="text-info">FECHA: <?php 
                 $fecha_se = explode('-',$row_f[0]);
                 $fecha_seg = $fecha_se[2].'/'.$fecha_se[1].'/'.$fecha_se[0];
                 echo $fecha_seg; ?></h6></div> 
                </div>
                <hr>
        <?php
            $numero_f=$numero_f+1;
            }
            while ($row_f = mysqli_fetch_array($result_f));
            } else {
            }
        ?>
 

         
            <form name="FUNCIONALIDAD_CF" action="guarda_funcionalidad_familiar_cf.php" method="post">                   

                <div class="form-group row">  
                    <div class="col-sm-3"></div>    
                    <div class="col-sm-9"> 
                    <h6>2. Violencia en la Familia* <input type="checkbox" class="form-group" name="idfuncionalidad_familiar[0]" value="5" ></h6>  
                    <h6>3. Tabaquismo Pasivo* <input type="checkbox" class="form-group" name="idfuncionalidad_familiar[1]" value="6"></h6>  
                    <h6>4. Consumo de alcohol con repercusión en la familia* <input type="checkbox" class="form-group" name="idfuncionalidad_familiar[2]" value="7"></h6>  
                    <h6>5. Consumo de drogas ilícitas en presencia de la familia*  <input type="checkbox" class="form-group" name="idfuncionalidad_familiar[3]" value="8"></h6> 
                    <h6>6. Cumple función Económica <input type="checkbox" class="form-group" name="idfuncionalidad_familiar[4]" value="9" ></h6>  
                    <h6>7. Cumple función Educativa <input type="checkbox" class="form-group" name="idfuncionalidad_familiar[5]" value="10"></h6>  
                    <h6>8. Cumple función Afectiva <input type="checkbox" class="form-group" name="idfuncionalidad_familiar[6]" value="11"></h6>  
                    <h6>9. Cumple función Social <input type="checkbox" class="form-group" name="idfuncionalidad_familiar[7]" value="12"></h6> 
                    </div>
                </div>
                <hr>
                    <div class="text-center">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModale">
                        AGREGAR FUNCIONALIDAD FAMILIAR
                        </button>  
                    </div>  
    
                <!-- modal de confirmacion de envio de datos-->
                <div class="modal fade" id="exampleModale" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">FUNCIONALIDAD FAMILIAR</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">                                    
                                    Esta seguro de agregar la FUNCIONALIDAD FAMILIAR ?
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
               <a href="evaluacion_resultados_cf.php"><h6 class="text-info">EVALUACIÓN Y RESULTADOS -></h6></a>                                                                   
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