<?php include("../cabf_o.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$hora       = date("h:i");

$idpersonal_ss = $_SESSION['idpersonal_ss'];
$codigo_ss     = $_SESSION['codigo_ss'];

$sql = " SELECT personal.idpersonal, personal.idusuario, personal.idnombre, nombre.nombre, nombre.paterno, nombre.materno, nombre.fecha_nac, ";
$sql.= " nombre.ci, nombre.complemento, nombre.exp, nacionalidad.nacionalidad, genero.genero, formacion_academica.formacion_academica, ";
$sql.= " profesion.profesion, especialidad_medica.especialidad_medica, nombre_datos.correo, nombre_datos.celular, nombre_datos.direccion_dom, nombre_datos.idprofesion, personal.iddato_laboral ";
$sql.= " FROM personal, nombre, nacionalidad, genero, nombre_datos, formacion_academica, profesion, especialidad_medica ";
$sql.= " WHERE personal.idnombre=nombre.idnombre AND nombre.idnacionalidad=nacionalidad.idnacionalidad AND nombre.idgenero=genero.idgenero ";
$sql.= " AND personal.idnombre_datos=nombre_datos.idnombre_datos AND nombre_datos.idformacion_academica=formacion_academica.idformacion_academica ";
$sql.= " AND nombre_datos.idprofesion=profesion.idprofesion AND nombre_datos.idespecialidad_medica=especialidad_medica.idespecialidad_medica  ";
$sql.= " AND personal.idpersonal='$idpersonal_ss' ";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);

$sql_l = " SELECT iddato_laboral, idusuario, idnombre, iddependencia, entidad, cargo_entidad, idministerio, iddireccion, idarea, cargo_mds,";
$sql_l.= "  iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud, item_mds, item_red_salud ";
$sql_l.= " FROM dato_laboral WHERE iddato_laboral='$row[19]' ";
$result_l = mysqli_query($link,$sql_l);
$row_l = mysqli_fetch_array($result_l);
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

        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <img src="../img/banner_safci_index2.jpg" alt="10" class="img-thumbnail">
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
  
                <body class="bg-gradient-primary">

    <div class="container">
    </br>
        <div class="text-center">          
            <h6 class="text-primary"><a href="registro_safci.php">VOLVER</a></h6>
        </div>
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h4 class="text-success">REGISTRO SATISFACTORIO !!!</h4>
                                <h4 class="text-success">VERIFIQUE LOS DATOS!!!</h4>
                                <h4 class="text-primary">REGISTRO SAFCI</h4>
                                <h4><?php echo $codigo_ss;?></h4>
                            </div>
                            </br>
                                <div class="form-group row">
                                    <h5 class="text-primary">1.- DATOS PERSONALES:</h5>                                 
                                </div>
                                <hr>
                        <form name="FORMREG" action="guarda_personal.php" method="post">  
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
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">FORMACIÓN ACADÉMICA:</h6>
                                    <input type="text" class="form-control"  value="<?php echo $row[12];?>" disabled> 
                                    </div>
                                    <div class="col-sm-6">
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
                                <div class="form-group row">                                
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">CORREO ELECTRÓNICO:</h6>
                                    <input type="text" class="form-control"  value="<?php echo $row[15];?>" disabled>
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">TELÉFONO CELULAR/WHATSAPP:</h6>
                                    <input type="text" class="form-control"  value="<?php echo $row[16];?>" disabled>
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">DIRECCIÓN/DOMICILIO:</h6>
                                    <input type="text" class="form-control"  value="<?php echo $row[17];?>" disabled>
                                    </div>
                                </div>


       <!-- Begin datos laborales -->
                <hr>
                </br>
                <div class="form-group row">
                    <h5 class="text-primary">3.- DATOS LABORALES:</h5>                                 
                </div>   
                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">TIPO DE DEPENDENCIA:</h6>  
                    </div>
                    <div class="col-sm-9">                  
                    <select name="iddependencia"  id="iddependencia" class="form-control" required disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT iddependencia, dependencia FROM dependencia ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[3]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>
                    </div>
                </div>
                <?php if ($row_l[3] == '1') { ?>

                <?php } else { if ($row_l[3] == '2') { ?>

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
                    <h6 class="text-primary">DEPENDIENTE DEL:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idministerio"  id="idministerio" class="form-control" required disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idministerio, ministerio, sigla FROM ministerio ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[6]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-primary">DIRECCIÓN/INSTITUCIÓN::</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="iddireccion"  id="iddireccion" class="form-control" required disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT iddireccion, direccion FROM direccion ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[7]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-primary">UNIDAD ORGANIZACIONAL:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idarea"  id="idarea" class="form-control" required disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idarea, area FROM area ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[8]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-primary">CARGO:</h6>
                    </div>
                    <div class="col-sm-9">
                    <textarea class="form-control" rows="2" name="cargo_mds" required disabled><?php echo $row_l[9];?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">NÚMERO DE ÍTEM:</h6>
                    </div>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" name="item_mds" value="<?php echo $row_l[14];?>" disabled>
                    </div>
                </div>
                <?php } else { ?>

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
                    <h6 class="text-primary">CARGO:</h6>
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
              
                <?php } } ?>

                <div class="form-group row">
                    <div class="col-sm-6">

                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>

                    <!-- Begin formulario microcurricular -->
                    <div class="text-center">    
                        <div class="form-group row">
                            <div class="col-sm-12"> 
                                <a class="btn btn-success" href="registro_safci.php">FINALIZAR REGISTRO SAFCI</a>
                            </div>                              
                        </div>
                    </div>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="#">PROGRAMA SAFCI - MI SALUD</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="#">Ministerio de Salud y Deportes</a>
                            </div>
                        </div>
                    </div>
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

        <!-- scripts para calendario -->
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
    </body>
</html>