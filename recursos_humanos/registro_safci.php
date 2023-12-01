<?php include("../cabf_o.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$hora       = date("h:i");
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
            <h6 class="text-primary"><a href="../index.php">VOLVER</a></h6>
        </div>
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h4 class="text-primary">NUEVO REGISTRO DE PERSONAL SAFCI</h4>
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
                                        <input type="text" class="form-control" 
                                         placeholder="Nombre Completo" name="nombre" required
                                          title="El nombre con Mayúscula al inicio y minúsculas después.">
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">PRIMER APELLIDO:</h6>
                                        <input type="text" class="form-control"
                                        placeholder="Primer Apellido" name="paterno" required
                                         title="El apellido paterno con Mayúscula al inicio y minúsculas después.">
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">SEGUNDO APELLIDO:</h6>
                                        <input type="text" class="form-control"
                                        placeholder="Segundo Apellido" name="materno" required
                                         title="El apellido materno con Mayúscula al inicio y minúsculas despues.">
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FECHA DE NACIMIENTO:</h6>
                                        <input type="date"  class="form-control" 
                                         placeholder="ingresar fecha" name="fecha_nac" required>
                                    </div>                              
                                </div>

                                <div class="form-group row">
                                
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">CÉDULA DE ID:</h6>
                                    <input type="text" class="form-control" name="ci" placeholder="N° de CI" required
                                    pattern="^[0-9]+" title="El numero de CI solo puede contener DIGITOS numéricos." >
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">COMPLEMENTO:</h6>
                                    <input type="text" class="form-control" name="complemento" placeholder="">
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">EXPEDICIÓN:</h6>
                                    <select name="exp" id="exp" class="form-control" required>
                                    <option value="">-SELECCIONE-</option>
                                    <?php
                                    $sql1 = "SELECT iddepartamento, departamento, sigla FROM departamento ";
                                    $result1 = mysqli_query($link,$sql1);
                                    if ($row1 = mysqli_fetch_array($result1)){
                                    mysqli_field_seek($result1,0);
                                    while ($field1 = mysqli_fetch_field($result1)){
                                    } do {
                                    echo "<option value=".$row1[2].">".$row1[2]."</option>";
                                    } while ($row1 = mysqli_fetch_array($result1));
                                    } else {
                                    echo "No se encontraron resultados!";
                                    }
                                    ?>
                                    </select>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">NACIONALIDAD</h6>
                                    <select name="idnacionalidad"  id="idnacionalidad" class="form-control" required>
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
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">GÉNERO</h6>
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
                                    <select name="idformacion_academica" id="idformacion_academica" class="form-control" required>
                                        <option value="">-SELECCIONE-</option>
                                        <?php
                                        $sql1 = "SELECT idformacion_academica, formacion_academica FROM formacion_academica WHERE etapa_academica='GRADO' ";
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
                                    <div class="col-sm-6"></div>                              
                                </div>
 
                                <div class="form-group row" id="grado">  
                                </div>

                                <div class="form-group row">                                
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">PROFESIÓN/OCUPACIÓN:</h6>
                                    <select name="idprofesion" id="idprofesion" class="form-control" required>
                                        <option value="">-SELECCIONE-</option>
                                        <?php
                                        $sql1 = "SELECT idprofesion, profesion FROM profesion ORDER BY idprofesion ";
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
                                    <div class="col-sm-8" id="especialidad_medica"></div>                                                                            
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">POSGRADO:</h6>
                                    <select name="idformacion_academica_p"  id="idformacion_academica_p" class="form-control" required>
                                        <option value="">-SELECCIONE-</option>
                                        <?php
                                        $sql1 = "SELECT idformacion_academica, formacion_academica FROM formacion_academica WHERE etapa_academica='POSGRADO' ";
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
                                    <div class="col-sm-6"></div>                              
                                </div>
                                <div class="form-group row" id="posgrado">  
                                </div>

                                <div class="form-group row">                                
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">CORREO ELECTRÓNICO:</h6>
                                    <input type="mail" class="form-control" name="correo" required>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">CELULAR/WHATSAPP:</h6>
                                    <input type="text" class="form-control" name="celular" required>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">DIRECCIÓN/DOMICILIO:</h6>
                                    <textarea class="form-control" rows="2" name="direccion_dom" required></textarea>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">CELULAR EN CASO DE EMERGENCIA:</h6>
                                    <input type="text" class="form-control" name="celular_emergencia" required>
                                    </div>
                                </div>


       <!-- Begin datos laborales -->
                <hr>
                </br>
                <div class="form-group row">
                    <h5 class="text-primary">3.- LUGAR DE TRABAJO:</h5>                                 
                </div>   

                <input type="hidden" name="iddependencia" value="3">

                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">DEPARTAMENTO:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="iddepartamento" id="iddepartamento" class="form-control" required>
                        <option value="">-SELECCIONE-</option>
                        <?php
                        $sql1 = "SELECT iddepartamento, departamento FROM departamento ";
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
                </div>

                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">RED DE SALUD/COORDINACIÓN:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idred_salud" id="idred_salud" class="form-control" required></select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">ESTABLECIMIENTO DE SALUD/OFICINA:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idestablecimiento_salud" id="idestablecimiento_salud" class="form-control" required></select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4">
                    <h6 class="text-primary">CARGO:</h6><h6 class="text-primary">(DE ACUERDO A ORGANIGRAMA):</h6>
                    </div>
                    <div class="col-sm-8">
                    <select name="idcargo_organigrama"  id="idcargo_organigrama" class="form-control" required>
                        <option value="">-SELECCIONE-</option>
                        <?php
                        $sql1 = "SELECT idcargo_organigrama, cargo_organigrama FROM cargo_organigrama ORDER BY cargo_organigrama DESC ";
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
                </div>

                <div class="form-group row">
                    <div class="col-sm-4">
                    <h6 class="text-primary">CARGO:</h6><h6 class="text-primary">(DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN):</h6>
                    </div>
                    <div class="col-sm-8">
                    <textarea class="form-control" rows="2" name="cargo_red_salud" required></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4">
                    <h6 class="text-primary">NÚMERO DE ÍTEM/N° CONTRATO:</h6><h6 class="text-primary">(DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN Ó CONTRATO):</h6>
                    </div>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" name="item_red_salud" placeholder="N° de Ítem"
                    required >
                    </div>
                </div>

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
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            REGISTRAR PERSONAL
                            </button>  
                        </div>                              
                    </div>                            
                </div>
                   <!-- modal de confirmacion de envio de datos-->
                   <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">REGISTRAR PERSONAL</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    
                                    Esta seguro de Registrarse?
                                    posteriormenete no se podran realizar cambios.

                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                <button type="submit" class="btn btn-primary pull-center">CONFIRMAR REGISTRO</button>    
                                </div>
                            </div>
                        </div>
                    </div>
                        </form>
                    <!-- Modal -->

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
        <script>$("#fecha1").datepicker($.datepicker.regional[ "es" ]);</script>

        <script language="javascript">
            $(document).ready(function(){
            $("#idformacion_academica").change(function () {
                    $("#idformacion_academica option:selected").each(function () {
                        formacion_academica=$(this).val();
                        $.post("grado.php", {formacion_academica:formacion_academica}, function(data){
                        $("#grado").html(data);
                        });
                    });
            })
            });
        </script>
        <script language="javascript">
            $(document).ready(function(){
            $("#idformacion_academica_p").change(function () {
                    $("#idformacion_academica_p option:selected").each(function () {
                        formacion_academica_p=$(this).val();
                        $.post("posgrado.php", {formacion_academica_p:formacion_academica_p}, function(data){
                        $("#posgrado").html(data);
                        });
                    });
            })
            });
        </script>
        <script language="javascript">
            $(document).ready(function(){
            $("#idprofesion").change(function () {
                    $("#idprofesion option:selected").each(function () {
                        profesion=$(this).val();
                        $.post("especialidad_medica_o.php", {profesion:profesion}, function(data){
                        $("#especialidad_medica").html(data);
                        });
                    });
            })
            });
        </script>
        <script language="javascript">
        $(document).ready(function(){
        $("#iddepartamento").change(function () {
                    $("#iddepartamento option:selected").each(function () {
                        departamento=$(this).val();
                    $.post("red_salud_o.php", {departamento:departamento}, function(data){
                    $("#idred_salud").html(data);
                    });
                });
        })
        });
        </script> 

        <script language="javascript">
        $(document).ready(function(){
        $("#idred_salud").change(function () {
                    $("#idred_salud option:selected").each(function () {
                        red_salud=$(this).val();
                    $.post("establecimiento_salud_o.php", {red_salud:red_salud}, function(data){
                    $("#idestablecimiento_salud").html(data);
                    });
                });
        })
        });
        </script>
    </body>
</html>
