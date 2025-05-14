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
                    <a href="planificador_visitas.php"><h6 class="text-info"><- VOLVER</h6></a>
                    <hr>     
                    <h4 class="text-info">VISITAS PLANIFICADAS</h4>        
                    <h4 class="text-info">CARPETA FAMILIAR : <?php echo $row_cf[1]; ?></h4>
                    <h4 class="text-info">FAMILIA : <?php echo $row_cf[2];?></h4>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->


                <div class="col-lg-12">  
                    <div class="p-2"> 

<!------- DATOS DEL AREA DE INFLUENCIA ---------->
            <div class="text-center">  
                <h6 class="text-info">IDENTIFICACION DE RIÉSGOS</h6>                                                  
            <?php                                             
                $sql_r =" SELECT determinante_salud, salud_integrantes, funcionalidad_familiar, evaluacion_familiar FROM evaluacion_familiar_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                $result_r = mysqli_query($link,$sql_r);
                $row_r = mysqli_fetch_array($result_r);

                if ($row_r[3] == 'FAMILIA CON RIESGO BAJO') {
                    echo "<h6 class='text-success'> ".$row_r[3]."</h6>";
                    echo "<h6 class='text-success'>- ".$row_r[0]."</h6>";
                    echo "<h6 class='text-success'>- ".$row_r[1]."</h6>";
                    echo "<h6 class='text-success'>- ".$row_r[2]."</h6>";
                } else {
                    if ($row_r[3] == 'FAMILIA CON RIESGO MEDIANO') {
                        echo "<h6 class='text-warning'> ".$row_r[3]."</h6>";
                        echo "<h6 class='text-warning'>- ".$row_r[0]."</h6>";
                        echo "<h6 class='text-warning'>- ".$row_r[1]."</h6>";
                        echo "<h6 class='text-warning'> ".$row_r[2]."</h6>";
                    } else {
                        if ($row_r[3] == 'FAMILIA CON RIESGO ALTO') {
                            echo "<h6 class='text-danger'> ".$row_r[3]."</h6>";
                            echo "<h6 class='text-danger'>- ".$row_r[0]."</h6>";
                            echo "<h6 class='text-danger'>- ".$row_r[1]."</h6>";
                            echo "<h6 class='text-danger'>- ".$row_r[2]."</h6>";
                        } else { } } }
                    ?>                  
            </div>   
            
            <input type="hidden" name="idintegrante_cf" value="idintegrante_cf_valor">
            <div class="form-group row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped" id="example" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-info">Nª</th>
                                    <th class="text-info">NOMBRES Y APELLIDOS</th>
                                    <th class="text-info">PARENTESCO</th>
                                    <th class="text-info">GÉNERO</th>
                                    <th class="text-info">EDAD</th>
                                    <th class="text-info">RIESGO PERSONAL</th>
                                    <th class="text-info">FRECUENCIA DE VISITA</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                    $numero=0;
                                    $sql4 =" SELECT integrante_cf.idintegrante_cf, nombre.ci, nombre.complemento, nombre.paterno, nombre.materno, nombre.nombre, parentesco.parentesco, genero.genero, ";
                                    $sql4.=" integrante_cf.edad, integrante_cf.estado, integrante_cf.idnombre, nombre.idgenero, nombre.fecha_nac, seguimiento_cf.idriesgo_personal_vf, seguimiento_cf.idfrecuencia_vf ";
                                    $sql4.=" FROM integrante_cf, nombre, parentesco, genero, seguimiento_cf, riesgo_personal_vf, frecuencia_vf ";
                                    $sql4.=" WHERE integrante_cf.idnombre=nombre.idnombre AND integrante_cf.idparentesco=parentesco.idparentesco AND nombre.idgenero=genero.idgenero ";
                                    $sql4.=" AND seguimiento_cf.idriesgo_personal_vf=riesgo_personal_vf.idriesgo_personal_vf AND seguimiento_cf.idintegrante_cf=integrante_cf.idintegrante_cf ";
                                    $sql4.=" AND seguimiento_cf.idfrecuencia_vf=frecuencia_vf.idfrecuencia_vf AND integrante_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ORDER BY integrante_cf.edad DESC ";
                                    $result4 = mysqli_query($link,$sql4);
                                    if ($row4 = mysqli_fetch_array($result4)){
                                    mysqli_field_seek($result4,0);
                                    while ($field4 = mysqli_fetch_field($result4)){
                                    } do { 
                                    ?>
                                    <tr>
                                    <td><?php echo $numero+1;?> 
                                    <input type="hidden" name="idintegrante_cf[<?php echo $numero;?>]" value="<?php echo $row4[0];?>">
                                    <input type="hidden" name="fecha_nac[<?php echo $numero;?>]" value="<?php echo $row4[12];?>"></td>
                                        <td><?php echo mb_strtoupper($row4[5]." ".$row4[3]." ".$row4[4]);?> </td>
                                        <td><?php echo $row4[6];?></td>
                                        <td><?php echo $row4[7];?></td>
                                        <td><?php echo $row4[8];?></td>
                                        <td>
                                        <select name="idriesgo_personal_vf[<?php echo $numero;?>]"  id="idriesgo_personal_vf" class="form-control" disabled>
                                            <option selected>Seleccione</option>
                                            <?php
                                            $sqlv = " SELECT idriesgo_personal_vf, riesgo_personal_vf FROM riesgo_personal_vf ";
                                            $resultv = mysqli_query($link,$sqlv);
                                            if ($rowv = mysqli_fetch_array($resultv)){
                                            mysqli_field_seek($resultv,0);
                                            while ($fieldv = mysqli_fetch_field($resultv)){
                                            } do {
                                            ?>
                                            <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row4[13]) echo "selected";?> ><?php echo $rowv[1];?></option>
                                            <?php
                                            } while ($rowv = mysqli_fetch_array($resultv));
                                            } else {
                                            }
                                            ?>
                                        </select>
                                        </td>
                                        <td> 
                                        <select name="idfrecuencia_vf[<?php echo $numero;?>]"  id="idfrecuencia_vf" class="form-control" disabled>
                                            <option selected>Seleccione</option>
                                            <?php
                                            $sqlv = " SELECT idfrecuencia_vf, frecuencia_vf FROM frecuencia_vf ";
                                            $resultv = mysqli_query($link,$sqlv);
                                            if ($rowv = mysqli_fetch_array($resultv)){
                                            mysqli_field_seek($resultv,0);
                                            while ($fieldv = mysqli_fetch_field($resultv)){
                                            } do {
                                            ?>
                                            <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row4[14]) echo "selected";?> ><?php echo $rowv[1];?></option>
                                            <?php
                                            } while ($rowv = mysqli_fetch_array($resultv));
                                            } else {
                                            }
                                            ?>
                                        </select>
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
<div class="col-sm-4"><a href="visitas_familiares.php"><h6 class="text-info"><- VOLVER</h6></a></div> 
<div class="col-sm-4">
    <a href="imprime_seguimiento_familiar.php?idcarpeta_familiar=<?php echo $idcarpeta_familiar_ss;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1300,height=800,top=50, left=200, scrollbars=YES'); return false;">
    <h6 class="text-info">IMPRIMIR SEGUIMIENTO</h6></a>  
</div>
<div class="col-sm-4"></div> 
</div> 
      
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