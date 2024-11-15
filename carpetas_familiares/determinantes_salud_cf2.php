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

$sql_cf =" SELECT idcarpeta_familiar, codigo FROM carpeta_familiar WHERE idcarpeta_familiar='$idcarpeta_familiar_ss'";
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
                    <a href="determinantes_salud_cf.php"><h6 class="text-info"><- VOLVER</h6></a>
                    <hr>             
                    <h4 class="text-info">CARPETA FAMILIAR:</h4>
                    <h4 class="text-primary"><?php echo $row_cf[1]; ?></h4>
                    <h4 class="text-info">11.- DETERMINANTES DE LA SALUD</h4>
                    <h4 class="text-info">ESTRUCTURA DE LA VIVIENDA</h4>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

                <div class="col-lg-12">  
                    <div class="p-2"> 

    <!-------- ETAPA DE IDENTIFICACIÓN DEL INTEGRANTE FAMILIAR (BEGIN) --------->

    <div class="form-group row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped" id="example" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-info">Nª</th>
                                    <th class="text-info">ASPECTO</th>
                                    <th class="text-info">FACTOR DETERMINANTE</th>
                                    <th class="text-info">VALOR</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                    $numero=1;
                                    $sql4 =" SELECT determinante_salud_cf.iddeterminante_salud_cf, cat_determinante_salud.cat_determinante_salud, item_determinante_salud.item_determinante_salud, determinante_salud_cf.valor_cf, determinante_salud_cf.iddeterminante_salud FROM ";
                                    $sql4.=" determinante_salud_cf, cat_determinante_salud, item_determinante_salud WHERE determinante_salud_cf.idcat_determinante_salud=cat_determinante_salud.idcat_determinante_salud AND ";
                                    $sql4.=" determinante_salud_cf.iditem_determinante_salud=item_determinante_salud.iditem_determinante_salud AND determinante_salud_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' AND determinante_salud_cf.iddeterminante_salud='2' ";
                                    $result4 = mysqli_query($link,$sql4);
                                    if ($row4 = mysqli_fetch_array($result4)){
                                    mysqli_field_seek($result4,0);
                                    while ($field4 = mysqli_fetch_field($result4)){
                                    } do { 
                                    ?>
                                    <tr>
                                        <td><?php echo $numero;?></td>
                                        <td><?php echo $row4[1];?></td>
                                        <td><?php echo $row4[2];?></td>
                                        <td><?php echo $row4[3];?></td>

                                    </tr>   
                                    
                                    <?php
                                    $numero=$numero+1;
                                    }
                                    while ($row4 = mysqli_fetch_array($result4));
                                    } else {
                                    }
                                ?>
                                    <tr>                                     
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                        <form name="BORRAR" action="elimina_determinante_salud_cf2.php" method="post">  
                                        <button type="submit" class="btn btn-danger">QUITAR</button></form> 
                                        </td>
                                    </tr>
  
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>  

            <div class="card shadow mb-4">
                    <div class="card-header py-3">
                    <h6 class="text-info">RIESGO EN LA ESTRUCTURA DE LA VIVIENDA</h6>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-4">
                            
                            <?php  
                                $sqlb = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='2' ";
                                $resultb = mysqli_query($link,$sqlb);
                                $rowb = mysqli_fetch_array($resultb);
                                echo "<h6>VALOR  =  ".$rowb[0]." </h6>";
                             ?>

                            </div>
                            <div class="col-sm-8">
                            <?php
                                $sumatoria = $rowb[0];
                                if ($sumatoria <= 16 ) {
                                    echo "<h6 class='text-secundary'>SIN RIESGO</h6>";
                                } else {
                                    if ($sumatoria <= 31 ) {
                                        echo "<h6 class='text-info'>RIESGO LEVE</h6>";
                                    } else {
                                        if ($sumatoria <= 41) {
                                            echo "<h6 class='text-primary'>RIESGO MODERADO</h6>";
                                        } else {
                                            if ($sumatoria <= 56) {
                                                echo "<h6 class='text-warning'>RIESGO GRAVE</h6>";
                                            } else { 
                                                if ($sumatoria <= 80) {
                                                    echo "<h6 class='text-danger'>RIESGO MUY GRAVE</h6>";
                                                } else {  } } } } }

                            ?>

                            </div>
                        </div>   
                    </div>
                </div>
            


     <!-------- INGRESA NUEVO INTEGRANTE DE LA FAMILIA (Begin) --------->                         
        <hr>
        <div class="text-center">                                     
            <h4 class="text-info">AGREGAR ESTRUCTURA DE LA VIVIENDA:</h4>                    
        </div>
        <hr>
 
<form name="INTEGRANTE" action="guarda_determinante_salud2.php" method="post">   

<input type="hidden" name="iddeterminante_salud" value="2"> 

<div class="form-group row">
<div class="col-sm-4"><h6 class="text-info">a) Tipo de Vivienda</h6></div>
<div class="col-sm-8">    

<?php
            $sql2 = "SELECT iditem_determinante_salud, item_determinante_salud, valor FROM item_determinante_salud WHERE idcat_determinante_salud='8' ";
            $result2 = mysqli_query($link,$sql2);
            if ($row2 = mysqli_fetch_array($result2)){
            mysqli_field_seek($result2,0);
            while ($field2 = mysqli_fetch_field($result2)){
            } do { ?>

               <h6><?php echo $row2[1];?> -> <input type="radio" name="iditem_determinante_salud[0]" value="<?php echo $row2[0];?>" required></h6>

           <?php } while ($row2 = mysqli_fetch_array($result2));
            } else {
            echo "No se encontraron resultados!";
            }
            ?> 
</div>
</div> 
<hr>
<div class="form-group row">
<div class="col-sm-4"><h6 class="text-info">b) Techo de la Vivienda</h6></div>
<div class="col-sm-8">    

<?php
            $sql2 = "SELECT iditem_determinante_salud, item_determinante_salud, valor FROM item_determinante_salud WHERE idcat_determinante_salud='9' ";
            $result2 = mysqli_query($link,$sql2);
            if ($row2 = mysqli_fetch_array($result2)){
            mysqli_field_seek($result2,0);
            while ($field2 = mysqli_fetch_field($result2)){
            } do { ?>

               <h6><?php echo $row2[1];?> -> <input type="radio" name="iditem_determinante_salud[1]" value="<?php echo $row2[0];?>" required></h6>

           <?php } while ($row2 = mysqli_fetch_array($result2));
            } else {
            echo "No se encontraron resultados!";
            }
            ?> 
</div>
</div> 
<hr>
<div class="form-group row">
<div class="col-sm-4"><h6 class="text-info">c) Paredes de la Vivienda</h6></div>
<div class="col-sm-8">    

<?php
            $sql2 = "SELECT iditem_determinante_salud, item_determinante_salud, valor FROM item_determinante_salud WHERE idcat_determinante_salud='10' ";
            $result2 = mysqli_query($link,$sql2);
            if ($row2 = mysqli_fetch_array($result2)){
            mysqli_field_seek($result2,0);
            while ($field2 = mysqli_fetch_field($result2)){
            } do { ?>

               <h6><?php echo $row2[1];?> -> <input type="radio" name="iditem_determinante_salud[2]" value="<?php echo $row2[0];?>" required></h6>

           <?php } while ($row2 = mysqli_fetch_array($result2));
            } else {
            echo "No se encontraron resultados!";
            }
            ?> 
</div>
</div> 
<hr>
<div class="form-group row">
<div class="col-sm-4"><h6 class="text-info">d) Pisos de la Vivienda</h6></div>
<div class="col-sm-8">    

<?php
            $sql2 = "SELECT iditem_determinante_salud, item_determinante_salud, valor FROM item_determinante_salud WHERE idcat_determinante_salud='11' ";
            $result2 = mysqli_query($link,$sql2);
            if ($row2 = mysqli_fetch_array($result2)){
            mysqli_field_seek($result2,0);
            while ($field2 = mysqli_fetch_field($result2)){
            } do { ?>

               <h6><?php echo $row2[1];?> -> <input type="radio" name="iditem_determinante_salud[3]" value="<?php echo $row2[0];?>" required></h6>

           <?php } while ($row2 = mysqli_fetch_array($result2));
            } else {
            echo "No se encontraron resultados!";
            }
            ?> 
</div>
</div> 
<hr>
<div class="form-group row">
<div class="col-sm-4"><h6 class="text-info">e) Revoque de las paredes interiores</h6></div>
<div class="col-sm-8">    

<?php
            $sql2 = "SELECT iditem_determinante_salud, item_determinante_salud, valor FROM item_determinante_salud WHERE idcat_determinante_salud='12' ";
            $result2 = mysqli_query($link,$sql2);
            if ($row2 = mysqli_fetch_array($result2)){
            mysqli_field_seek($result2,0);
            while ($field2 = mysqli_fetch_field($result2)){
            } do { ?>

               <h6><?php echo $row2[1];?> -> <input type="radio" name="iditem_determinante_salud[4]" value="<?php echo $row2[0];?>" required></h6>

           <?php } while ($row2 = mysqli_fetch_array($result2));
            } else {
            echo "No se encontraron resultados!";
            }
            ?> 
</div>
</div> 
<hr>
<div class="form-group row">
<div class="col-sm-4"><h6 class="text-info">f) Tiene cuarto solo para cocinar</h6></div>
<div class="col-sm-8">    
<?php
            $sql2 = "SELECT iditem_determinante_salud, item_determinante_salud, valor FROM item_determinante_salud WHERE idcat_determinante_salud='13' ";
            $result2 = mysqli_query($link,$sql2);
            if ($row2 = mysqli_fetch_array($result2)){
            mysqli_field_seek($result2,0);
            while ($field2 = mysqli_fetch_field($result2)){
            } do { ?>

               <h6><?php echo $row2[1];?> -> <input type="radio" name="iditem_determinante_salud[5]" value="<?php echo $row2[0];?>" required></h6>

           <?php } while ($row2 = mysqli_fetch_array($result2));
            } else {
            echo "No se encontraron resultados!";
            }
            ?> 
</div>
</div>
<hr>
<div class="form-group row">
<div class="col-sm-4"><h6 class="text-info">g) Riesgos externos con relación a la vivienda (NO = 1) (SI = 5)</h6></div>

<div class="col-sm-4">    <h6 class="text-secundary">1. Cerca al rio o charco: </h6>
                          <h6 class="text-secundary">2. Cerca al corral: </h6>
                          <h6 class="text-secundary">3. Cerca a basura: </h6>
                          <h6 class="text-secundary">4. Inseguridad ciudadana: </h6>
                          <h6 class="text-secundary">5. Otros: </h6>                         
    </div>        
    <div class="col-sm-4">
    <h6 class="text-info"> NO <input type="radio" name="campo[0]" value="1" checked> SI <input type="radio" name="campo[0]" value="5" ></h6>  
    <h6 class="text-info"> NO <input type="radio" name="campo[1]" value="1" checked> SI <input type="radio" name="campo[1]" value="5" ></h6>  
    <h6 class="text-info"> NO <input type="radio" name="campo[2]" value="1" checked> SI <input type="radio" name="campo[2]" value="5" ></h6> 
    <h6 class="text-info"> NO <input type="radio" name="campo[3]" value="1" checked> SI <input type="radio" name="campo[3]" value="5" ></h6>
    <h6 class="text-info"> NO <input type="radio" name="campo[4]" value="1" checked> SI <input type="radio" name="campo[4]" value="5" ></h6> 
    </div>
</div>

<div class="form-group row">
    <div class="col-sm-4"><h6 class="text-info">h) Riesgos internos con relación a la vivienda (NO = 1) (SI = 5)</h6></div>

    <div class="col-sm-4"><h6 class="text-secundary">1. Falta de higiene en la vivienda: </h6>
                          <h6 class="text-secundary">2. Gradas precarias: </h6>
                          <h6 class="text-secundary">3. Vivienda en construcción: </h6>
                          <h6 class="text-secundary">4. Animales de granja y corral en vivienda: </h6>
                          <h6 class="text-secundary">5. Otros: </h6>                         
    </div>        
    <div class="col-sm-4">
      <h6 class="text-info"> NO <input type="radio" name="valor2[0]" value="1" checked> SI <input type="radio" name="valor2[0]" value="5" ></h6>  
      <h6 class="text-info"> NO <input type="radio" name="valor2[1]" value="1" checked> SI <input type="radio" name="valor2[1]" value="5" ></h6>  
      <h6 class="text-info"> NO <input type="radio" name="valor2[2]" value="1" checked> SI <input type="radio" name="valor2[2]" value="5" ></h6> 
      <h6 class="text-info"> NO <input type="radio" name="valor2[3]" value="1" checked> SI <input type="radio" name="valor2[3]" value="5" ></h6>
      <h6 class="text-info"> NO <input type="radio" name="valor2[4]" value="1" checked> SI <input type="radio" name="valor2[4]" value="5" ></h6> 
        </div>
</div>

<div class="form-group row">  
<div class="col-sm-4"></div> 
<div class="col-sm-4">
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
    REGISTRAR DETERMINANTE
    </button>  </div> 
<div class="col-sm-4"></div> 
</div> 
                        
   <!-- modal de confirmacion de envio de datos-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">DETERMINANTE ESTRUCTURA DE LA VIVIENDA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            
            Esta seguro de Registrar el DETERMINANTE DE LA SALUD?
        
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
                                                
    <!-------- ETAPA DE IDENTIFICACIÓN DEL INTEGRANTE FAMILIAR (BEGIN) --------->
          
             <div class="text-center"> 
               <a href="determinantes_salud_cf3.php"><h6 class="text-success">SIGUIENTE DETERMINANTE-></h6></a>                                                                   
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
    <script src="../js/jquery.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
    <script src="../js/datepicker-es.js"></script>               
</body>
</html>  