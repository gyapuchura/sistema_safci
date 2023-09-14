<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idpersonal_ss = $_SESSION['idpersonal_ss'];
$codigo_ss     = $_SESSION['codigo_ss'];

$sql = " SELECT personal.idpersonal, personal.idusuario, personal.idnombre, nombre.nombre, nombre.paterno, nombre.materno, nombre.fecha_nac, nombre.ci, nombre.complemento, ";
$sql.= " nombre.exp, nacionalidad.nacionalidad, genero.genero, formacion_academica.formacion_academica, profesion.profesion, especialidad_medica.especialidad_medica,";
$sql.= " nombre_datos.correo, nombre_datos.celular, nombre_datos.direccion_dom, nombre_datos.idprofesion, personal.iddato_laboral, nombre_datos.celular_emergencia ";
$sql.= " FROM personal, nombre, nacionalidad, genero, nombre_datos, formacion_academica, profesion, especialidad_medica ";
$sql.= " WHERE personal.idnombre=nombre.idnombre AND nombre.idnacionalidad=nacionalidad.idnacionalidad AND nombre.idgenero=genero.idgenero ";
$sql.= " AND personal.idnombre_datos=nombre_datos.idnombre_datos AND nombre_datos.idformacion_academica=formacion_academica.idformacion_academica ";
$sql.= " AND nombre_datos.idprofesion=profesion.idprofesion AND nombre_datos.idespecialidad_medica=especialidad_medica.idespecialidad_medica  ";
$sql.= " AND personal.idpersonal='$idpersonal_ss' ";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);

$sql_l = " SELECT iddato_laboral, idusuario, idnombre, iddependencia, entidad, cargo_entidad, idministerio, iddireccion, idarea, cargo_mds,";
$sql_l.= " iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud, item_mds, item_red_salud, idcargo_organigrama ";
$sql_l.= " FROM dato_laboral WHERE iddato_laboral='$row[19]' ";
$result_l = mysqli_query($link,$sql_l);
$row_l = mysqli_fetch_array($result_l);

$sql_ac = " SELECT idnombre_academico, idformacion_academica, descripcion_academica, entidad_academica, gestion, ";
$sql_ac.= " idformacion_academica_p, descripcion_academica_p, entidad_academica_p, gestion_p ";
$sql_ac.= " FROM nombre_academico WHERE idnombre='$row[2]' ORDER BY idnombre_academico DESC LIMIT 1 ";
$result_ac = mysqli_query($link,$sql_ac);
$row_ac    = mysqli_fetch_array($result_ac);
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
        <div class="card o-hidden border-0 shadow-lg my-2">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">                       
                        <div class="text-center">   
                        <a href="recursos_humanos.php">VOLVER</a> 
                        <hr>                    
                        <h4 class="text-primary">REGISTRO SAFCI</h4>
                        <h4><?php echo $codigo_ss;?></h4>
                        </div>
<!-- END aqui va el TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->
                            <div class="form-group row">
                                    <h5 class="text-primary">1.- DATOS PERSONALES:</h5>                                 
                                </div>
                                <hr>

                                <div class="form-group row">                             
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">NOMBRES</h6>
                                    <input type="text" class="form-control"  value="<?php echo $row[3];?>" disabled>                       
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">PRIMER APELLIDO:</h6>
                                    <input type="text" class="form-control"  value="<?php echo $row[4];?>" disabled>                                     
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">SEGUNDO APELLIDO:</h6>
                                    <input type="text" class="form-control"  value="<?php echo $row[5];?>" disabled>                                    
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FECHA DE NACIMIENTO:</h6>
                                    <input type="text" id="fecha1" class="form-control" name="fecha_nac" value="<?php 
                                        $fecha_n = explode('-',$row[6]);
                                        $fecha_nac = $fecha_n[2].'/'.$fecha_n[1].'/'.$fecha_n[0];
                                        echo $fecha_nac;
                                        ?>" disabled>    
                                    </div>                              
                                </div>

                                <div class="form-group row">                            
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">CÉDULA DE ID:</h6>
                                    <input type="text" class="form-control"  value="<?php echo $row[7];?>" disabled> 
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">COMPLEMENTO:</h6>
                                    <input type="text" class="form-control"  value="<?php echo $row[8];?>" disabled> 
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">EXPEDICIÓN:</h6>
                                    <input type="text" class="form-control"  value="<?php echo $row[9];?>" disabled> 
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">NACIONALIDAD</h6>
                                    <input type="text" class="form-control"  value="<?php echo $row[10];?>" disabled> 
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">GÉNERO</h6>
                                    <input type="text" class="form-control"  value="<?php echo $row[10];?>" disabled> 
                                    </div>                          
                                </div>

                                <hr>
                                </br>
                <div class="form-group row">
                    <h5 class="text-primary">2.- DATOS COMPLEMENTARIOS:</h5>                                 
                </div>
                                <hr>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FORMACIÓN ACADÉMICA:</h6>
                                    <input type="text" class="form-control"  value="<?php echo $row[12];?>" disabled> 
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">ENTIDAD DE FORMACIÓN:</h6>
                                    <textarea name="" rows="3" class="form-control" disabled><?php echo $row_ac[3];?></textarea>
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">AÑO DE TIULACIÓN:</h6>
                                    <input type="text" class="form-control"  value="<?php echo $row_ac[4];?>" disabled> 
                                    </div> 
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">PROFESIÓN/OCUPACIÓN:</h6>
                                    <input type="text" class="form-control"  value="<?php echo $row[13];?>" disabled> 
                                    </div>                              
                                </div>
                                
                           <?php
                           if ($row[18] =='1') {
                            ?>
                                <div class="form-group row">                                
                                    <div class="col-sm-12">
                                    <h6 class="text-primary">ESPECIALIDAD MÉDICA:</h6>
                                    <input type="text" class="form-control"  value="<?php echo $row[14];?>" disabled>
                                    </div>
                                </div>
                            <?php
                           } else {
                            
                           }
                           ?>
                                <hr>
                                </br>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FORMACIÓN POSGRADO: </h6>
                                    <select name="formacion_academica_p"  id="formacion_academica_p" class="form-control" required disabled>
                                        <option selected>Seleccione</option>
                                        <?php
                                        $sqlv = " SELECT idformacion_academica, formacion_academica FROM formacion_academica  ";
                                        $resultv = mysqli_query($link,$sqlv);
                                        if ($rowv = mysqli_fetch_array($resultv)){
                                        mysqli_field_seek($resultv,0);
                                        while ($fieldv = mysqli_fetch_field($resultv)){
                                        } do {
                                        ?>
                                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_ac[5]) echo "selected";?> ><?php echo $rowv[1];?></option>
                                        <?php
                                        } while ($rowv = mysqli_fetch_array($resultv));
                                        } else {
                                        }
                                        ?>
                                    </select>
                                    </div>
                                    <hr>
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">DESCRIPCIÓN DEL POSGRADO:</h6>
                                    <textarea name="" rows="3" class="form-control" disabled><?php echo $row_ac[6];?></textarea>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">ENTIDAD DEL POSGRADO:</h6>
                                    <textarea name="" rows="3" class="form-control" disabled><?php echo $row_ac[7];?></textarea>
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">AÑO:</h6>
                                    <input type="text" class="form-control"  value="<?php echo $row_ac[8];?>" disabled> 
                                    </div>                     
                                </div>
                                    </br>
                                <div class="form-group row">                                
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">CORREO ELECTRÓNICO:</h6>
                                    <input type="text" class="form-control"  value="<?php echo $row[15];?>" disabled>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">TELÉFONO CELULAR/WHATSAPP:</h6>
                                    <input type="text" class="form-control"  value="<?php echo $row[16];?>" disabled>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">DIRECCIÓN/DOMICILIO:</h6>
                                    <textarea name="" rows="3" class="form-control" disabled><?php echo $row[17];?></textarea>                                   
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">TELÉFONO DE EMERGENCIA:</h6>
                                    <input type="text" class="form-control"  value="<?php echo $row[20];?>" disabled>
                                    </div>
                                </div>      
       <!-- Begin datos laborales -->
                <hr>
                </br>
                <div class="form-group row">
                    <h5 class="text-primary">3.- LUGAR DE TRABAJO:</h5>                                 
                </div>   


                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">DEPARTAMENTO:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="iddepartamento"  id="iddepartamento" class="form-control" required disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT iddepartamento, departamento FROM departamento  ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[10]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <select name="idred_salud"  id="idred_salud" class="form-control" required disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idred_salud, red_salud FROM red_salud  ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[11]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <select name="idestablecimiento_salud"  id="idestablecimiento_salud" class="form-control" required disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud  ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[12]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-primary">CARGO (DE ACUERDO A ORGANIGRAMA):</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idcargo_organigrama"  id="idcargo_organigrama" class="form-control" required disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idcargo_organigrama, cargo_organigrama FROM cargo_organigrama  ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[16]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-primary">CARGO (DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN):</h6>
                    </div>
                    <div class="col-sm-9">
                    <textarea class="form-control" rows="2" name="cargo_red_salud" required disabled><?php echo $row_l[13];?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">NÚMERO DE ÍTEM:</h6>
                    </div>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" name="item_mds" value="<?php echo $row_l[15];?>" disabled>
                    </div>
                </div>             
              


            </br>
                <div class="form-group row">
                <div class="col-sm-12">
                    <div class="text-center">
                    <a class="btn btn-warning" href="modifica_registro_safci.php">ACTUALIZAR REGISTRO</a>
                    </div>
                </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">

                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>                  


                    
<!-- END aqui va el comntenido de la pagina ---->
                </div>
                <div class="text-center">
                    <a class="small" href="#">PROGRAMA SAFCI - MI SALUD</a>
                </div>
                <div class="text-center">
                    <a class="small" href="#">Ministerio de Salud y Deportes</a>
                </div>
            </br>
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
   



</body>

</html>
