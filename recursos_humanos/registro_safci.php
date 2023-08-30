<?php 
include("../inc.config.php"); 
date_default_timezone_set('America/La_Paz');
$fecha_ram = date("Ymd");
$fecha 	   = date("Y-m-d");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SISTEMA SAFCI</title>

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
                
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                <!-- Topbar -->
                <img src="../img/banner_safci_index2.jpg" alt="10" class="img-thumbnail">
                <!-- End of Topbar -->
            <br> <br> 

                <div class="card shadow mb-4">
                <div class="card-header py-3">                            
                        <div class="card-body">                        
                        <h2 class="text-primary">REGISTRO DE PERSONAL SAFCI-MI SALUD</h2> 
                        </div>                     
                </div>
                </div>

                <div class="card shadow mb-4">
                <div class="card-header py-3">  

            <form name="FORMREG" action="guarda_registroh_o.php" method="post">

                <div class="card-body">                              
                <h4 class="text-primary">1.- DATOS PERSONALES:</h4>
                </div>   

                <form name="FORMREG" action="guarda_registroh_o.php" method="post">               
                 <!--- begin registro personal safci -----> 
                <div class="card-body"> 
                <div class="form-group row">
                    <div class="col-sm-3 mb-3 mb-sm-0">
                    <h5 class="text-primary">NOMBRES:</h5>
                    <input type="text" class="form-control" name="nombre" placeholder="Nombres" 
                    required pattern="^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$" 
                    title="El nombre con Mayúscula al inicio y minúsculas despues."/>
                    </div>
                    <div class="col-sm-3">
                    <h5 class="text-primary">PRIMER APELLIDO:</h5>
                    <input type="text" class="form-control" name="paterno" placeholder="Paterno" 
                    required pattern="^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$" 
                    title="El apellido paterno con Mayúscula al inicio y minúsculas despues."/>
                    </div>
                    <div class="col-sm-3">
                    <h5 class="text-primary">SEGUNDO APELLIDO:</h5>
                    <input type="text" class="form-control" name="materno" placeholder="Materno"
                    required pattern="^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$" 
                    title="El apellido materno con Mayúscula al inicio y minúsculas despues."/>
                    </div>

                    <div class="col-sm-3">
                    <h5 class="text-primary">FECHA DE NACIMIENTO:</h5>
                    <input type="text" id="fecha1" class="form-control" name="fecha_nac" placeholder="DD/MM/AAAA" required>    
                    </div>
                    </div>

                    <div class="form-group row">
                    <div class="col-sm-2 mb-3 mb-sm-0">
                    <h5 class="text-primary">CÉDULA DE ID:</h5>
                    <input type="text" class="form-control" name="ci" placeholder="N° de CI"
                    required pattern="[A-Z0-9_-]{5,12}$" 
                    title="El numero de CI solo puede contener DIGITOS numéricos." >
                    </div>
                    <div class="col-sm-2 mb-3 mb-sm-0">
                    <h5 class="text-primary">COMPLEMENTO:</h5>
                    <input type="text" class="form-control" name="complemento" placeholder="COMPLEMENTO">
                    </div>
                    <div class="col-sm-2">
                    <h5 class="text-primary">EXPEDICIÓN:</h5>
                    <select name="exp"  id="exp" class="form-control" required>
                        <option value="">-SELECCIONE-</option>
                        <?php
                        $sql1 = "SELECT iddepartamento, departamento, sigla FROM departamento ";
                        $result1 = mysqli_query($link,$sql1);
                        if ($row1 = mysqli_fetch_array($result1)){
                        mysqli_field_seek($result1,0);
                        while ($field1 = mysqli_fetch_field($result1)){
                        } do {
                        echo "<option value=". $row1[2].">". $row1[2]."</option>";
                        } while ($row1 = mysqli_fetch_array($result1));
                        } else {
                        echo "No se encontraron resultados!";
                        }
                        ?>
                    </select>
                    </div>
                    <div class="col-sm-3">
                    <h5 class="text-primary">NACIONALIDAD:</h5>
                    <select name="idnacionalidad"  id="idnacionalidad" class="form-control" required>
                        <option value="">-SELECCIONE-</option>
                        <?php
                        $sql1 = "SELECT idnacionalidad, nacionalidad FROM nacionalidad ";
                        $result1 = mysqli_query($link,$sql1);
                        if ($row1 = mysqli_fetch_array($result1)){
                        mysqli_field_seek($result1,0);
                        while ($field1 = mysqli_fetch_field($result1)){
                        } do {
                        echo "<option value=". $row1[0].">". $row1[1]."</option>";
                        } while ($row1 = mysqli_fetch_array($result1));
                        } else {
                        echo "No se encontraron resultados!";
                        }
                        ?>
                    </select>
                    </div>
                    <div class="col-sm-3">
                    <h5 class="text-primary">GÉNERO:</h5>
                    <select name="idgenero" id="idgenero" class="form-control" required>
                        <option value="">-SELECCIONE-</option>
                        <?php
                        $sql1 = "SELECT idgenero, genero FROM genero ";
                        $result1 = mysqli_query($link,$sql1);
                        if ($row1 = mysqli_fetch_array($result1)){
                        mysqli_field_seek($result1,0);
                        while ($field1 = mysqli_fetch_field($result1)){
                        } do {
                        echo "<option value=". $row1[0].">". $row1[1]."</option>";
                        } while ($row1 = mysqli_fetch_array($result1));
                        } else {
                        echo "No se encontraron resultados!";
                        }
                        ?>
                    </select>
                    </div>
                </div>

             <!--- end registro personal safci ----->  
                        </div>                          
                </div>
                </div>
            <!--- Begin datos  laborales safci ----->  
                <div class="card shadow mb-4">
                <div class="card-header py-3">                            
                        <div class="card-body">                        
                        <h4 class="text-primary">2.- DATOS COMPLEMENTARIOS:</h4>
                        </div>  
                        <div class="card-body">

                        <div class="row">
                        <div class="col-md-3"><h5 class="text-primary">FORMACIÓN ACADÉMICA:</h5></div>
                        <div class="col-md-3">
                        <select name="idformacion_academica"  id="idformacion_academica" class="form-control" required>
                            <option value="">-SELECCIONE-</option>
                            <?php
                            $sql1 = "SELECT idformacion_academica, formacion_academica FROM formacion_academica ";
                            $result1 = mysqli_query($link,$sql1);
                            if ($row1 = mysqli_fetch_array($result1)){
                            mysqli_field_seek($result1,0);
                            while ($field1 = mysqli_fetch_field($result1)){
                            } do {
                            echo "<option value=". $row1[0].">". $row1[1]."</option>";
                            } while ($row1 = mysqli_fetch_array($result1));
                            } else {
                            echo "No se encontraron resultados!";
                            }
                            ?>
                        </select>
                        </div>
                        <div class="col-md-3"><h5 class="text-primary">PROFESIÓN/OCUPACIÓN:</h5></div>
                        <div class="col-md-3">
                        <select name="idprofesion"  id="idprofesion" class="form-control" required>
                            <option value="">-SELECCIONE-</option>
                            <?php
                            $sql1 = "SELECT idprofesion, profesion FROM profesion ORDER BY idprofesion ";
                            $result1 = mysqli_query($link,$sql1);
                            if ($row1 = mysqli_fetch_array($result1)){
                            mysqli_field_seek($result1,0);
                            while ($field1 = mysqli_fetch_field($result1)){
                            } do {
                            echo "<option value=". $row1[0].">". $row1[1]."</option>";
                            } while ($row1 = mysqli_fetch_array($result1));
                            } else {
                            echo "No se encontraron resultados!";
                            }
                            ?>
                        </select>
                        </div>
                        </div>

                        <div id="especialidad_medica"></div>

                        <div class="row">
                        <div class="col-md-12"><h5> </h5></div>
                        </div>
                        <div class="row">
                        <div class="col-md-12"><h5> </h5></div>
                        </div>

                        <div class="row">
                        <div class="col-md-3"><h5 class="text-primary">CORREO ELECTRÓNICO:</h5></div>
                        <div class="col-md-3"><input type="mail" class="form-control" name="correo" required></div>
                        <div class="col-md-3"><h5 class="text-primary">TELÉFONO CELULAR/WHATSAPP:</h5></div>
                        <div class="col-md-3"><input type="text" class="form-control" name="celular" required></div>
                        </div>

                        </div>  
                 <!--- End datos  laborales safci ----->                      
                </div>
                </div>

                <div class="card shadow mb-4">
                <div class="card-header py-3">                             
                    <div class="card-body">
                    <div class="row">
                    <div class="col-md-6"><h4 class="text-primary">3.- DATOS LABORALES:</h4></div>
                    <div class="col-md-6"></div>
                    </div>
                    </div>  
                    <div class="card-body">                        
                    <div class="row">
                    <div class="col-md-3"><h5 class="text-primary">TIPO DE DEPENDENCIA:</h5></div>
                    <div class="col-md-9">
                        <select name="iddependencia"  id="iddependencia" class="form-control" required>
                            <option value="">-SELECCIONE-</option>
                            <?php
                            $sql1 = "SELECT iddependencia, dependencia FROM dependencia WHERE iddependencia !='1' ";
                            $result1 = mysqli_query($link,$sql1);
                            if ($row1 = mysqli_fetch_array($result1)){
                            mysqli_field_seek($result1,0);
                            while ($field1 = mysqli_fetch_field($result1)){
                            } do {
                            echo "<option value=". $row1[0].">". $row1[1]."</option>";
                            } while ($row1 = mysqli_fetch_array($result1));
                            } else {
                            echo "No se encontraron resultados!";
                            }
                            ?>
                        </select>   
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12"><h5> </h5></div>
                    </div>
                    <div class="row">
                    <div class="col-md-12"><h5> </h5></div>
                    </div>
                    <div id="dependencia_mds"></div>
                    </div>                                      
                    <div class="row">
                        <div class="col-md-4"><h4></h4></div>
                        <div class="col-md-8">    
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            REGISTRAR PERSONAL
                            </button>
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
                        </div>
                        </div>

                        </form>
                    <!-- Modal -->
                    </div>
                    </div> 
                </div>
                </div>

                
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
               
    </div>

    </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Ministerio de Salud y Deportes &copy; MSYD 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
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

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>
    <script src="../js/datepicker-es.js"></script>
    <script src="../js/jquery.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
    <script src="../js/datepicker-es.js"></script>
    <script>
    $("#fecha1").datepicker($.datepicker.regional[ "es" ]);
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
    $("#iddependencia").change(function () {
            $("#iddependencia option:selected").each(function () {
                dependencia=$(this).val();
                $.post("dependencia_mds_o.php", {dependencia:dependencia}, function(data){
                $("#dependencia_mds").html(data);
                });
            });
    })
    });
    </script>
</body>
</html>