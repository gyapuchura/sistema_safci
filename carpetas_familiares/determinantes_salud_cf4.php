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
                    <a href="determinantes_salud_cf3.php"><h6 class="text-info"><- VOLVER</h6></a>
                    <hr>             
                    <h4 class="text-info">CARPETA FAMILIAR:</h4>
                    <h4 class="text-primary"><?php echo $row_cf[1]; ?></h4>
                    <h4 class="text-info">11.- DETERMINANTES DE LA SALUD</h4>
                    <h4 class="text-info">SALUD ALIMENTARIA</h4>
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
                                    $sql4 =" SELECT determinante_salud_cf.iddeterminante_salud_cf, cat_determinante_salud.cat_determinante_salud, item_determinante_salud.item_determinante_salud, determinante_salud_cf.valor_cf FROM ";
                                    $sql4.=" determinante_salud_cf, cat_determinante_salud, item_determinante_salud WHERE determinante_salud_cf.idcat_determinante_salud=cat_determinante_salud.idcat_determinante_salud AND ";
                                    $sql4.=" determinante_salud_cf.iditem_determinante_salud=item_determinante_salud.iditem_determinante_salud AND determinante_salud_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' AND determinante_salud_cf.iddeterminante_salud='4'";
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
                                <form name="BORRAR" action="elimina_determinante_salud_cf4.php" method="post">  
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
                    <h6 class="text-info">RIESGO DE LA SALUD ALIMENTARIA</h6>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-4">
                            
                            <?php  
                                $sqld = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='4' AND idcat_determinante_salud='19' ";
                                $resultd = mysqli_query($link,$sqld);
                                $rowd = mysqli_fetch_array($resultd);
                                $durante = $rowd[0];

                                if ($durante == '0' || $durante == '') {
                                    $grado_alimentario = '1';
                                } else {
                                    if ($durante <= 3) {
                                        $grado_alimentario = '3';
                                    } else {
                                        if ($durante <= 5) {
                                            $grado_alimentario = '4';
                                        } else {
                                            if ($durante >= 6) {
                                                $grado_alimentario = '5';
                                            } else {  } } } }                                                           

                                $sqlcon = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='4' AND idcat_determinante_salud='21' ";
                                $resultcon = mysqli_query($link,$sqlcon);
                                $rowcon = mysqli_fetch_array($resultcon);
                                $consumo = $rowcon[0];

                                $alimentaria = $grado_alimentario + $consumo;

                                echo "<h6>VALOR = ".$alimentaria."</h6>";

                             ?>

                            </div>
                            <div class="col-sm-8">
                            <?php                                  
                                     if ($alimentaria <= 7) {
                                        $sql5 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='1'  ";
                                        $result5 = mysqli_query($link,$sql5);
                                        $row5 = mysqli_fetch_array($result5);
                                        echo "<h6 class='text-secundary'>".$row5[0]."</h6>";
                                    } else {
                                        if ($alimentaria <= 13) {
                                            $sql6 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='2' ";
                                            $result6 = mysqli_query($link,$sql6);
                                            $row6 = mysqli_fetch_array($result6);
                                            echo "<h6 class='text-info'>".$row6[0]."</h6>";
                                        } else {
                                            if ($alimentaria <= 21) {
                                                    $sql7 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='3' ";
                                                    $result7 = mysqli_query($link,$sql7);
                                                    $row7 = mysqli_fetch_array($result7);
                                                    echo "<h6 class='text-primary'>".$row7[0]."</h6>";
                                            } else {
                                                if ($alimentaria <= 30) {
                                                        $sql8 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='4' ";
                                                        $result8 = mysqli_query($link,$sql8);
                                                        $row8 = mysqli_fetch_array($result8);
                                                        echo "<h6 class='text-warning'>".$row8[0]."</h6>";
                                                } else { 
                                                    if ($alimentaria <= 35) {
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
            <h4 class="text-info">AGREGAR FACTOR ALIMENTARIO:</h4>                    
        </div>
        <hr>
 
<form name="INTEGRANTE" action="guarda_determinante_salud4.php" method="post">   
 
<input type="hidden" name="iddeterminante_salud" value="4">

<div class="form-group row">
<div class="col-sm-12"><h6 class="text-info">- Durante los últimos 3 meses, por falta de dinero u otros factores hubo algún momento en el que:</h6></div>
</div>
<div class="form-group row">
    <div class="col-sm-3"></div>
    <div class="col-sm-7">    <h6 class="text-secundary">1, ¿Se preocupó (sintió pena) que en su hogar quedaran sin alimentos? </h6>
                              <h6 class="text-secundary">2. ¿Realmente en su hogar se quedaron sin alimentos? </h6>
                              <h6 class="text-secundary">3. ¿Dejó de tener una alimentación nutritiva y saludable? </h6>
                              <h6 class="text-secundary">4. ¿Tuvo una alimentación con poca variedad de alimentos? </h6>
                              <h6 class="text-secundary">5. ¿Dejó de desayunar almorzar y cenar? </h6>   
                              <h6 class="text-secundary">6. ¿Comió menos de lo que está acostumbrado a comer?</h6>
                              <h6 class="text-secundary">7. ¿Sintió hambre pero no comió? </h6>
                              <h6 class="text-secundary">8. ¿Comió solo una vez al día o dejó de comer todo el día? </h6>                       
    </div>        
    <div class="col-sm-2">
      <h6 class="text-info"> NO <input type="radio" name="valor3[0]" value="0" checked> SI <input type="radio" name="valor3[0]" value="1" ></h6>  
      <h6 class="text-info"> NO <input type="radio" name="valor3[1]" value="0" checked> SI <input type="radio" name="valor3[1]" value="1" ></h6>  
      <h6 class="text-info"> NO <input type="radio" name="valor3[2]" value="0" checked> SI <input type="radio" name="valor3[2]" value="1" ></h6> 
      <h6 class="text-info"> NO <input type="radio" name="valor3[3]" value="0" checked> SI <input type="radio" name="valor3[3]" value="1" ></h6>
      <h6 class="text-info"> NO <input type="radio" name="valor3[4]" value="0" checked> SI <input type="radio" name="valor3[4]" value="1" ></h6> 
      <h6 class="text-info"> NO <input type="radio" name="valor3[5]" value="0" checked> SI <input type="radio" name="valor3[5]" value="1" ></h6> 
      <h6 class="text-info"> NO <input type="radio" name="valor3[6]" value="0" checked> SI <input type="radio" name="valor3[6]" value="1" ></h6>
      <h6 class="text-info"> NO <input type="radio" name="valor3[7]" value="0" checked> SI <input type="radio" name="valor3[7]" value="1" ></h6> 
    </div>  
</div> 
<div class="form-group row">
<div class="col-sm-12"><h6 class="text-info">b) Consumo diario de alimentos:</h6></div>
</div>
<div class="form-group row">
<div class="col-sm-3"></div>
        <div class="col-sm-5"><h6 class="text-secundary">1. Consumo de cereales, tubérculos y derivados </h6>
                              <h6 class="text-secundary">2. Consumo de verduras </h6>
                              <h6 class="text-secundary">3. Consumo de frutas </h6>
                              <h6 class="text-secundary">4. Consumo de lácteos </h6>
                              <h6 class="text-secundary">5. Consumo de carnes </h6>  
                              <h6 class="text-secundary">6. Consumo de sal yodada </h6>                        
        </div>        
        <div class="col-sm-3">
      <h6 class="text-info"> NO <input type="radio" name="valor4[0]" value="5" checked> SI <input type="radio" name="valor4[0]" value="1" ></h6>  
      <h6 class="text-info"> NO <input type="radio" name="valor4[1]" value="5" checked> SI <input type="radio" name="valor4[1]" value="1" ></h6>  
      <h6 class="text-info"> NO <input type="radio" name="valor4[2]" value="5" checked> SI <input type="radio" name="valor4[2]" value="1" ></h6> 
      <h6 class="text-info"> NO <input type="radio" name="valor4[3]" value="5" checked> SI <input type="radio" name="valor4[3]" value="1" ></h6>
      <h6 class="text-info"> NO <input type="radio" name="valor4[4]" value="5" checked> SI <input type="radio" name="valor4[4]" value="1" ></h6> 
      <h6 class="text-info"> NO <input type="radio" name="valor4[5]" value="5" checked> SI <input type="radio" name="valor4[5]" value="1" ></h6>
        </div>
        <div class="col-sm-1"></div>
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
        <h5 class="modal-title" id="exampleModalLabel">DETERMINANTE SALUD ALIMENTARIA</h5>
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
               <a href="socioeconomicas_cf.php"><h6 class="text-success">SIGUIENTE-></h6></a>                                                                   
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