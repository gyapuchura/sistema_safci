<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];
$idgestion_participativa_ss = $_SESSION['idgestion_participativa_ss'];

$sql_gp =" SELECT idgestion_participativa, iddepartamento, idred_salud, idmunicipio, numero_areas_influencia, numero_als, numero_eess, numero_cls, cosomusa, autoridad_cosomusa, ";
$sql_gp.=" autoridad_vigencia, autoridad_celular, plan_municipal, ley_municipal, proyectos_planificados, proyectos_ejecutados, idvigencia_convenio, ";
$sql_gp.=" asignacion_presupuestaria, med_trad_con_rumetrap, parteras_con_rumetrap, med_trad_sin_rumetrap, parteras_sin_rumetrap, salas_parto_intercultural, ";
$sql_gp.=" referencias_medicina_tradicional, correlativo, gestion, codigo, fecha_registro, hora_registro, idusuario ";
$sql_gp.=" FROM gestion_participativa WHERE idgestion_participativa='$idgestion_participativa_ss' ";
$result_gp=mysqli_query($link,$sql_gp);
$row_gp=mysqli_fetch_array($result_gp);

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
                    <h4 class="text-primary">GESTIÓN PARTICIPATIVA</h4>                   
                    <h4 class="text-info">CODIGO <?php echo $idgestion_participativa_ss;?></h4>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

        <form name="EVENTO_SAFCI" action="guarda_gestion_participativa.php" method="post">  
                <div class="col-lg-12">  
                    <div class="p-5"> 

                    <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">DEPARTAMENTO:</h6>
                    </div>
                    <div class="col-sm-9">

                    <input type="hidden" name="iddepartamento" value="<?php echo $row_gp[1];?>">
                    <select name="iddepartamento_cf"  id="iddepartamento_cf" class="form-control" disabled>

                        <?php
                        $sqlv = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$row_gp[1]'";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_gp[1]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <input type="hidden" name="idred_salud" value="<?php echo $row_gp[2];?>">
                    <select name="idred_salud_cf"  id="idred_salud_cf" class="form-control" disabled>
                        <?php
                        $sqlv = " SELECT idred_salud, red_salud FROM red_salud WHERE idred_salud='$row_gp[2]'";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_gp[2]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <input type="hidden" name="idmunicipio" value="<?php echo $row_gp[3];?>">
                    <select name="idmunicipio_cf"  id="idmunicipio_cf" class="form-control" disabled>
                    
                        <?php
                        $sqlv = " SELECT idmunicipio, municipio FROM municipios WHERE idmunicipio='$row_gp[3]'";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_gp[3]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>
                    </div>
                </div>
                <hr>

                <div class="form-group row"> 
                    <div class="col-sm-3">   
                    <h6 class="text-info">NÚMERO DE COMUNIDADES</br>(ÁREAS DE INFLUENCIA) DE INTERVENCIÓN:</h6>
                    <input type="number" name="numero_areas_influencia" class="form-control" required>             
                    </div>
                    <div class="col-sm-3">   
                    <h6 class="text-info">NÚMERO DE A.L.S.</br>AUTORIDADES LOCALES</br>DE SALUD:</h6>
                    <input type="number" name="numero_als" class="form-control">             
                    </div>
                    <div class="col-sm-3">   
                    <h6 class="text-info">NÚMERO DE EE.SS.</br>ESTABLECIMIENTOS DE SALUD</br>EN EL MUNICIPIO:</h6>
                    <input type="number" name="numero_eess" class="form-control" required>             
                    </div>
                    <div class="col-sm-3">   
                    <h6 class="text-info">NÚMERO DE COMITÉS</br>LOCALES DE SALUD</br>EN EL MUNICIPIO:</h6>
                    <input type="number" name="numero_cls" class="form-control" required>             
                    </div>
                </div>

                <div class="form-group row"> 
                    <div class="col-sm-3">   
                    <h6 class="text-info">¿CUENTA CON COSOMUSA?</h6></br>
                    <h6 class="text-info">SI -> <input type="radio" name="cosomusa" value="SI" checked></h6>
                    <h6 class="text-info">NO -> <input type="radio" name="cosomusa" value="NO">  </h6>        
                    </div>
                    <div class="col-sm-3">   
                    <h6 class="text-info">NOMBRE Y APELLIDO</br>AUTORIDAD COSOMUSA:</h6>
                    <textarea class="form-control" rows="2" name="autoridad_cosomusa" required></textarea>              
                    </div>
                    <div class="col-sm-3">   
                    <h6 class="text-info">FECHA DE VIGENCIA</br>AUTORIDAD COSOMUSA:</h6>
                    <input type="date" name="autoridad_vigencia" class="form-control">             
                    </div>
                    <div class="col-sm-3">   
                    <h6 class="text-info">TELÉFONO CELULAR</br>AUTORIDAD COSOMUSA:</h6>
                    <input type="number" name="autoridad_celular" class="form-control" required>             
                    </div>
                </div>
                    
                <div class="form-group row"> 
                    <div class="col-sm-3">   
                    <h6 class="text-info">¿CUENTA CON PLAN MUNICIPAL DE SALUD?</h6></br>
                    <h6 class="text-info">SI -> <input type="radio" name="plan_municipal" value="SI" checked></h6>
                    <h6 class="text-info">NO -> <input type="radio" name="plan_municipal" value="NO">  </h6>        
                    </div>
                    <div class="col-sm-3">   
                    <h6 class="text-info">¿CUENTA CON LEY MUNICIPAL DE APROBACIÓN DE PLAN MUNICIPAL DE SALUD?</h6>
                    <h6 class="text-info">SI -> <input type="radio" name="ley_municipal" value="SI" checked></h6>
                    <h6 class="text-info">NO -> <input type="radio" name="ley_municipal" value="NO">  </h6>        
                    </div>
                    <div class="col-sm-3">   
                    <h6 class="text-info">NÚMERO DE PROYECTOS EN SALUD</br>PLANIFICADOS:</h6>
                    <input type="number" name="proyectos_planificados" class="form-control" required>             
                    </div>
                    <div class="col-sm-3">   
                    <h6 class="text-info">NÚMERO DE PROYECTOS EN SALUD</br>EJECUTADOS:</h6>
                    <input type="number" name="proyectos_ejecutados" class="form-control" required>             
                    </div>
                </div>

                <div class="form-group row"> 
                    <div class="col-sm-6">   
                    <h6 class="text-info">CONVENIO SAFCI</h6>
                    <select name="idvigencia_convenio"  id="idvigencia_convenio" class="form-control" required>
                        <option value="">ELEGIR</option>
                        <?php
                        $sql1 = "SELECT idvigencia_convenio, vigencia_convenio FROM vigencia_convenio";
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
                    <div class="col-sm-6">   
                    <h6 class="text-info">ASIGNACIÓN PRESUPUESTARIA [Bs]</h6>
                    <input type="number" name="asignacion_presupuestaria" class="form-control" required>             
                    </div>
                </div>
                <hr>

                <div class="form-group row"> 
                    <div class="col-sm-2">         
                    </div>
                    <div class="col-sm-10">   
                    <h6 class="text-info">MÉDICOS TRADICIONALES CON REGISTRO RUNETRAP</h6>    
                    </div>
                </div>
                <div class="form-group row"> 
                    <div class="col-sm-6">   
                    <h6 class="text-info">NÚMERO DE MÉDICOS TRADICIONALES (GUÍA ESPIRITUAL, NATURISTA, ETC):</h6>
                    <input type="number" name="med_trad_con_rumetrap" class="form-control" required>             
                    </div>
                    <div class="col-sm-6">   
                    <h6 class="text-info">NÚMERO DE PRESTADORES</br> (PARTERAS):</h6>
                    <input type="number" name="parteras_con_rumetrap" class="form-control" required>             
                    </div>
                </div>
                <hr>
                <div class="form-group row"> 
                    <div class="col-sm-2">         
                    </div>
                    <div class="col-sm-10">   
                    <h6 class="text-info">MÉDICOS TRADICIONALES SIN REGISTRO RUNETRAP</h6>    
                    </div>
                </div>
                <div class="form-group row"> 
                    <div class="col-sm-6">   
                    <h6 class="text-info">NÚMERO DE MÉDICOS TRADICIONALES (GUÍA ESPIRITUAL, NATURISTA, ETC):</h6>
                    <input type="number" name="med_trad_sin_rumetrap" class="form-control" required>             
                    </div>
                    <div class="col-sm-6">   
                    <h6 class="text-info">NÚMERO DE PRESTADORES</br> (PARTERAS):</h6>
                    <input type="number" name="parteras_sin_rumetrap" class="form-control" required>             
                    </div>
                </div>
                <hr>
                <div class="form-group row"> 
                    <div class="col-sm-6">   
                    <h6 class="text-info">NÚMERO DE SALAS DE PARTO INTERCULTURAL IMPLEMENTADAS:</h6>
                    <input type="number" name="salas_parto_intercultural" class="form-control" required>              
                    </div>
                    <div class="col-sm-6">   
                    <h6 class="text-info">NÚMERO DE REFERENCIAS Y CONTRAREFERENCIAS CON MEDICINA TRADICIONAL:</h6>
                    <input type="number" name="referencias_medicina_tradicional" class="form-control" required>             
                    </div>
                </div>
                <hr>
    <!-------- begin rejilla --------->   

    <!-------- end rejilla --------->                      
                  
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


    <!-- scripts para calendario -->
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
   
</body>
</html>
