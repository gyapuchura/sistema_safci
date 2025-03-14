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
                    <a href="idioma_transporte.php"><h6 class="text-info"><- VOLVER</h6></a>
                    <hr>             
                    <h4 class="text-info">CARPETA FAMILIAR: <?php echo $idcarpeta_familiar_ss;?></h4>
                    <h4 class="text-primary"><?php echo $row_cf[1]; ?></h4>
                    <h4 class="text-info">3.- INTEGRANTES DE LA FAMILIA</h4>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->


                <div class="col-lg-12">  
                    <div class="p-2"> 

                

<!------- DATOS DEL AREA DE INFLUENCIA ---------->
              
                <div class="form-group row">   
                    <div class="col-sm-3">
                    <h6 class="text-info">FECHA DE APERTURA:</h6>
                    </div>
                    <div class="col-sm-3">                    
                    <input type="date" class="form-control" name="fecha_apertura" value="<?php echo $row_cf[3];?>" disabled>                
                    </div>    
                    <div class="col-sm-2">
                    <h6 class="text-info">FAMILIA:</h6>
                    </div>                        
                    <div class="col-sm-4">    
                    <input type="text" class="form-control" name="familia" value="<?php echo $row_cf[2];?>" disabled>                                
                    </div>
                </div>
            <hr>

            <div class="text-center">                                     
                <h4 class="text-info">INTEGRANTES:</h4>                    
            </div>
          
            <div class="form-group row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped" id="example" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-info">Nª</th>
                                    <th class="text-info">CÉDULA DE IDENTIDAD</th>
                                    <th class="text-info">PRIMER APELLIDO</th>
                                    <th class="text-info">SEGUNDO APELLIDO</th>
                                    <th class="text-info">NOMBRE(S)</th>
                                    <th class="text-info">PARENTESCO</th>
                                    <th class="text-info">GÉNERO</th>
                                    <th class="text-info">EDAD</th>
                                    <th class="text-info">ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                    $numero=1;
                                    $sql4 =" SELECT integrante_cf.idintegrante_cf, nombre.ci, nombre.complemento, nombre.paterno, nombre.materno, nombre.nombre, ";
                                    $sql4.=" parentesco.parentesco, genero.genero, integrante_cf.edad, integrante_cf.estado, integrante_cf.idnombre, nombre.idgenero FROM integrante_cf, nombre, parentesco, genero ";
                                    $sql4.=" WHERE integrante_cf.idnombre=nombre.idnombre AND integrante_cf.idparentesco=parentesco.idparentesco ";
                                    $sql4.=" AND nombre.idgenero=genero.idgenero AND integrante_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ORDER BY integrante_cf.edad DESC ";
                                    $result4 = mysqli_query($link,$sql4);
                                    if ($row4 = mysqli_fetch_array($result4)){
                                    mysqli_field_seek($result4,0);
                                    while ($field4 = mysqli_fetch_field($result4)){
                                    } do { 
                                    ?>
                                    <tr>
                                        <td><?php echo $numero;?></td>
                                        <td><?php echo $row4[1];?> <?php echo $row4[2];?></td>
                                        <td><?php echo $row4[3];?></td>
                                        <td><?php echo $row4[4];?></td>
                                        <td><?php echo $row4[5];?></td>
                                        <td><?php echo $row4[6];?></td>
                                        <td><?php echo $row4[7];?></td>
                                        <td><?php echo $row4[8];?></td>
                                        <td>
                        <?php if ($row4[9] == 'CONSOLIDADO') { ?>
                            <form name="INTEGRANTE" action="valida_integrante_cf.php" method="post">
                            <input name="idintegrante_cf" type="hidden" value="<?php echo $row4[0];?>">
                            <input name="idnombre_integrante" type="hidden" value="<?php echo $row4[10];?>">
                            <input name="idgenero" type="hidden" value="<?php echo $row4[11];?>">
                            <input name="edad" type="hidden" value="<?php echo $row4[8];?>">
                                <button type="submit" class="btn btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-user"></i>
                                </span>
                                <span class="text">INFORMACIÓN</br>INTEGRANTE</span>    
                                </button>
                            </form> 
                        <?php } else { ?>
                            <form name="BORRAR" action="elimina_integrante_cf.php" method="post">  
                            <input type="hidden" name="idintegrante_cf" value="<?php echo $row4[0];?>">
                            <button type="submit" class="btn btn-danger">QUITAR</button></form>
                        <?php } ?>
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
             <!-------- DESCONSOLIDAR LISTA DE INTEGRANTES (Begin) --------->   
             <hr>
        <div class="form-group row">  
        <div class="col-sm-4">
         <h6 class="text-info">OPCIONES DE LISTA FAMILIAR:</h6>                           
        </div>
        <div class="col-sm-4">
        <form name="DESCONSOLIDA" action="guarda_desconsolida_lista_familiar.php" method="post">  
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModald">
                DESCONSOLIDAR LISTA DE INTEGRANTES
                </button>             
          <div class="modal fade" id="exampleModald" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title_warning" id="exampleModalLabel">DESCONSOLIDA LISTA FAMILIAR</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            
                            Esta seguro de DESCONSOLIDAR LA LISTA DE INTEGRANTES DE LA FAMILIA?
                        
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-info">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form>  
        </div>
        <div class="col-sm-4">
        <form name="ENVIA_CONSULTA" action="guarda_consolida_lista_familiar.php" method="post">  
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalc">
                    CONSOLIDAR LA LISTA DE INTEGRANTES
                    </button>  
                   <!-- modal de confirmacion de envio de datos-->
            <div class="modal fade" id="exampleModalc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title_warning" id="exampleModalLabel">CONSOLIDA LISTA FAMILIAR</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            
                            Esta seguro de CONSOLIDAR LA LISTA DE INTEGRANTES DE LA FAMILIA?
                        
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-warning pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form>        
        </div>
        </div>
      
         <!-------- DESCONSOLIDAR LISTA DE INTEGRANTES (End) ---------> 
 
     <!-------- INGRESA NUEVO INTEGRANTE DE LA FAMILIA (Begin) --------->                         
        <hr>
        <div class="text-center">                                     
            <h4 class="text-info">AGREGAR INTEGRANTE:</h4>                    
        </div>
        <hr>

<form name="INTEGRANTE" action="guarda_nuevo_integrante.php" method="post">  

<div class="form-group row">                               
    <div class="col-sm-4">
    <h6 class="text-info">PRIMER APELLIDO:</h6>
        <input type="text" class="form-control" 
         name="paterno" autofocus>                
    </div>
    <div class="col-sm-4">
    <h6 class="text-info">SEGUNDO APELLIDO:</h6>
        <input type="text" class="form-control" 
         name="materno" required>                
    </div>
    <div class="col-sm-4">
    <h6 class="text-info">NOMBRES:</h6>
        <input type="text" class="form-control" 
         name="nombre" required >                
    </div>
</div>

<div class="form-group row">  
    <div class="col-sm-3">
    <h6 class="text-info">CÉDULA DE IDENTIDAD:</h6><h6 class="text-warning"> SI NO CUENTA ASIGNAR=0</h6>
        <input type="number" class="form-control" 
         name="ci" required >
    </div>
    <div class="col-sm-3">
    <h6 class="text-info">COMPLEMENTO:</h6>
        <input type="text" class="form-control" 
         name="complemento" >                
    </div>
    <div class="col-sm-3">
    <h6 class="text-info">GÉNERO</h6>
        <select name="idgenero" id="idgenero" class="form-control" required>
        <option value="">-SELECCIONE-</option>
        <?php
        $sql1 = "SELECT idgenero, genero FROM genero ";
        $result1 = mysqli_query($link,$sql1);
        if ($row1 = mysqli_fetch_array($result1)){
        mysqli_field_seek($result1,0);
        while ($field1 = mysqli_fetch_field($result1)){
        } do {
        echo "<option value=".$row1[0].">".$row1[1]."</option>";
        } while ($row1 = mysqli_fetch_array($result1));
        } else {
        echo "No se encontraron resultados!";
        }
        ?>
        </select>
    </div>  
    <div class="col-sm-3">
    <h6 class="text-info">FECHA DE NACIMIENTO:</h6>
        <input type="date"  class="form-control" 
            placeholder="ingresar fecha" name="fecha_nac" required>
    </div>      
</div>   

<div class="form-group row">  

<div class="col-sm-3"></br>
    <h6 class="text-info">NACIONALIDAD:</h6>

        <select name="idnacionalidad" id="idnacionalidad" class="form-control" required>
        <option value="">-SELECCIONE-</option>
        <?php
        $sql1 = "SELECT idnacionalidad, nacionalidad FROM nacionalidad ";
        $result1 = mysqli_query($link,$sql1);
        if ($row1 = mysqli_fetch_array($result1)){
        mysqli_field_seek($result1,0);
        while ($field1 = mysqli_fetch_field($result1)){
        } do {
        echo "<option value=".$row1[0].">".$row1[1]."</option>";
        } while ($row1 = mysqli_fetch_array($result1));
        } else {
        echo "No se encontraron resultados!";
        }
        ?>
        </select>
    </div>  

    <div class="col-sm-3"></br>
    <h6 class="text-info">PARENTESCO</h6>

        <select name="idparentesco" id="idparentesco" class="form-control" required>
        <option value="">-SELECCIONE-</option>
        <?php
        $sql1 = "SELECT idparentesco, parentesco FROM parentesco ";
        $result1 = mysqli_query($link,$sql1);
        if ($row1 = mysqli_fetch_array($result1)){
        mysqli_field_seek($result1,0);
        while ($field1 = mysqli_fetch_field($result1)){
        } do {
        echo "<option value=".$row1[0].">".$row1[1]."</option>";
        } while ($row1 = mysqli_fetch_array($result1));
        } else {
        echo "No se encontraron resultados!";
        }
        ?>
        </select>
    </div>  

    <div class="col-sm-3"></br>
    <h6 class="text-info">AUTO PERTENENCIA CULTURAL</h6>

        <select name="idnacion" id="idnacion" class="form-control" required>
        <option value="">-SELECCIONE-</option>
        <?php
        $sql1 = "SELECT idnacion, nacion FROM nacion ";
        $result1 = mysqli_query($link,$sql1);
        if ($row1 = mysqli_fetch_array($result1)){
        mysqli_field_seek($result1,0);
        while ($field1 = mysqli_fetch_field($result1)){
        } do {
        echo "<option value=".$row1[0].">".$row1[1]."</option>";
        } while ($row1 = mysqli_fetch_array($result1));
        } else {
        echo "No se encontraron resultados!";
        }
        ?>
        </select>
    </div>  
    <div class="col-sm-3"></br></br>

    </div>     
</div> 
<hr>

<div class="form-group row">  
<div class="col-sm-4"></div> 
<div class="col-sm-4">
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
    AGREGAR INTEGRANTE
    </button>  </div> 
<div class="col-sm-4"></div> 
</div> 
                        
            
   <!-- modal de confirmacion de envio de datos-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">REGISTRO DE INTEGRANTE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            
            Esta seguro de Registrar al INTEGRANTE?
        
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
    <!-------- INGRESA NUEVO INTEGRANTE DE LA FAMILIA (End) --------->  

    
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