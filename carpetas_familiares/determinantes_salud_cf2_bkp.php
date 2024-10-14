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
                                    <th class="text-info">ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                    $numero=1;
                                    $sql4 =" SELECT determinante_salud_cf.iddeterminante_salud_cf, cat_determinante_salud.cat_determinante_salud, item_determinante_salud.item_determinante_salud, determinante_salud_cf.valor_cf FROM ";
                                    $sql4.=" determinante_salud_cf, cat_determinante_salud, item_determinante_salud WHERE determinante_salud_cf.idcat_determinante_salud=cat_determinante_salud.idcat_determinante_salud AND ";
                                    $sql4.=" determinante_salud_cf.iditem_determinante_salud=item_determinante_salud.iditem_determinante_salud AND determinante_salud_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' AND determinante_salud_cf.iddeterminante_salud='2'";
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
                                        <td>
                                        <form name="BORRAR" action="elimina_determinante_salud_cf2.php" method="post">  
                                        <input type="hidden" name="iddeterminante_salud_cf" value="<?php echo $row4[0];?>">
                                        <button type="submit" class="btn btn-danger">QUITAR</button></form> </td>
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

            <div class="card shadow mb-4">
                    <div class="card-header py-3">
                    <h6 class="text-info">RIESGO DE LA ESTRUCTURA DE LA VIVIENDA</h6>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-4">
                            
                            <?php  

                                    $sqlb = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='2' ";
                                    $resultb = mysqli_query($link,$sqlb);
                                    $rowb = mysqli_fetch_array($resultb);
                                    echo "<h6>VALOR = ".$rowb[0]." </h6>";
                             ?>

                            </div>
                            <div class="col-sm-8">
                            <?php                                  
                                  $sumatoria = $rowb[0];
                                  if ($sumatoria <= 16 ) {
                                      $sql5 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='1'  ";
                                      $result5 = mysqli_query($link,$sql5);
                                      $row5 = mysqli_fetch_array($result5);
                                      echo "<h6 class='text-secundary'>".$row5[0]."</h6>";
                                  } else {
                                      if ($sumatoria <= 31 ) {
                                          $sql6 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='2' ";
                                          $result6 = mysqli_query($link,$sql6);
                                          $row6 = mysqli_fetch_array($result6);
                                          echo "<h6 class='text-info'>".$row6[0]."</h6>";
                                      } else {
                                          if ($sumatoria <= 41) {
                                                  $sql7 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='3' ";
                                                  $result7 = mysqli_query($link,$sql7);
                                                  $row7 = mysqli_fetch_array($result7);
                                                  echo "<h6 class='text-primary'>".$row7[0]."</h6>";
                                          } else {
                                              if ($sumatoria <= 56) {
                                                      $sql8 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='4' ";
                                                      $result8 = mysqli_query($link,$sql8);
                                                      $row8 = mysqli_fetch_array($result8);
                                                      echo "<h6 class='text-warning'>".$row8[0]."</h6>";
                                              } else { 
                                                  if ($sumatoria <= 80) {
                                                          $sql9 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='5' ";
                                                          $result9 = mysqli_query($link,$sql9);
                                                          $row9 = mysqli_fetch_array($result9);
                                                          echo "<h6 class='text-danger'>".$row9[0]."</h6>";
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
 
<div class="form-group row">
<div class="col-sm-3">

<input type="hidden" name="iddeterminante_salud" value="2">

<h6 class="text-info">ASPECTO DETERMINANTE</h6>
</div>
    <div class="col-sm-9">    
        <select name="idcat_determinante_salud" id="idcat_determinante_salud" class="form-control" required>
        <option value="">Elegir</option>
            <?php
            $sql2 = "SELECT idcat_determinante_salud, cat_determinante_salud FROM cat_determinante_salud WHERE iddeterminante_salud='2' AND idcat_determinante_salud !='20'";
            $result2 = mysqli_query($link,$sql2);
            if ($row2 = mysqli_fetch_array($result2)){
            mysqli_field_seek($result2,0);
            while ($field2 = mysqli_fetch_field($result2)){
            } do {
            echo "<option value=".$row2[0].">".$row2[1]."</option>";
            } while ($row2 = mysqli_fetch_array($result2));
            } else {
            echo "No se encontraron resultados!";
            }
            ?>
        </select>

    </div>
</div> 


<div class="form-group row" id="factor_determinante"></div> 

<div class="form-group row">      
        <div class="col-sm-12"></br>
            <button type="submit" class="btn btn-info btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-file"></i>
            </span>
            <span class="text">REGISTRAR FACTOR DETERMINANTE</span>    
            </button>
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

    <script language="javascript">
            $(document).ready(function(){
            $("#idcat_determinante_salud").change(function () {
                        $("#idcat_determinante_salud option:selected").each(function () {
                            cat_determinante_salud=$(this).val();
                        $.post("factor_determinante.php", {cat_determinante_salud:cat_determinante_salud}, function(data){
                        $("#factor_determinante").html(data);
                        });
                    });
            })
            });
        </script> 

</body>
</html>  