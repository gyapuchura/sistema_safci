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
  

                <div class="card shadow mb-8">
                    <div class="card-header py-6">
                        <h6 class="m-0 font-weight-bold text-primary"></h6>
                    </div>
<!-- BEGIN aqui va el TITULO de la pagina ---->
                    <div class="card-body">
                        <div class="text-center">                        
                        <h4 class="text-primary">NUEVO REGISTRO SAFCI</h4>
                        </div>
<!-- END aqui va el TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->
        <div class="col-lg-12">  
            <div class="p-5"> 

            <div class="form-group row">
                                    <h5 class="text-primary">1.- DATOS PERSONALES:</h5>                                 
                                </div>
                                <hr>
                            <form name="FORMREG" action="guarda_personal_int.php" method="post">  
                                <div class="form-group row">
                                
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">NOMBRES</h6>
                                    <input type="hidden" name="gestion" value="<?php echo $row[4];?>">
                                        <input type="text" class="form-control" 
                                         placeholder="Nombre Completo" name="nombre" required>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">PRIMER APELLIDO:</h6>
                                        <input type="text" class="form-control"
                                            placeholder="Primer Apellido" name="paterno" required>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">SEGUNDO APELLIDO:</h6>
                                        <input type="text" class="form-control"
                                            placeholder="Segundo Apellido" name="materno" required>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FECHA DE NACIMIENTO:</h6>
                                        <input type="text" id="fecha1" class="form-control" 
                                         placeholder="ingresar fecha" name="fecha_nac" required>
                                    </div>
                              
                                </div>

                                <div class="form-group row">
                                
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">CÉDULA DE ID:</h6>
                                    <input type="text" class="form-control" name="ci" placeholder="N° de CI"
                                    required pattern="[A-Z0-9_-]{5,12}$" 
                                    title="El numero de CI solo puede contener DIGITOS numéricos." >
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">COMPLEMENTO:</h6>
                                    <input type="text" class="form-control" name="complemento" placeholder="COMPLEMENTO">
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">EXPEDICIÓN:</h6>
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
                                    echo "<option value=". $row1[0].">". $row1[1]."</option>";
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
                                    echo "<option value=". $row1[0].">". $row1[1]."</option>";
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
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">PROFESIÓN/OCUPACIÓN:</h6>
                                    <select name="idprofesion"  id="idprofesion" class="form-control" required>
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
                                </div>
                                
                                <div id="especialidad_medica"> </div>

                                <div class="form-group row">                                
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">CORREO ELECTRÓNICO:</h6>
                                    <input type="mail" class="form-control" name="correo" required>
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">TELÉFONO CELULAR/WHATSAPP:</h6>
                                    <input type="text" class="form-control" name="celular" required>
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">DIRECCIÓN/DOMICILIO:</h6>
                                    <textarea class="form-control" rows="2" name="direccion_dom" required></textarea>
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

                <div id="dependencia_mds"></div>

                <div class="form-group row">
                    <div class="col-sm-6">

                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>
                          
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    REGISTRAR PERSONAL
                                    </button>  
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
                    </div>
                    <hr>                  
                   
<!-- END aqui va el comntenido de la pagina ---->
                </div>
                <div class="text-center">
                    <a class="small" href="#">PROGRAMA SAFCI - MI SALUD</a>
                </div>
                <div class="text-center">
                    <a class="small" href="#">Ministerio de Salud y Deportes</a>
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
        <script>$("#fecha1").datepicker($.datepicker.regional[ "es" ]);</script>
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