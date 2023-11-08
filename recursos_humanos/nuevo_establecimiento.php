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
$sql.= " nombre.ci, nombre.complemento, nombre.exp, nombre.idnacionalidad, nombre.idgenero, nombre_datos.idformacion_academica, ";
$sql.= " nombre_datos.idprofesion, nombre_datos.idespecialidad_medica, nombre_datos.correo, nombre_datos.celular, nombre_datos.direccion_dom, nombre_datos.idprofesion, personal.iddato_laboral, personal.idnombre_datos ";
$sql.= " FROM personal, nombre, nacionalidad, genero, nombre_datos, formacion_academica, profesion, especialidad_medica ";
$sql.= " WHERE personal.idnombre=nombre.idnombre AND nombre.idnacionalidad=nacionalidad.idnacionalidad AND nombre.idgenero=genero.idgenero ";
$sql.= " AND personal.idnombre_datos=nombre_datos.idnombre_datos AND nombre_datos.idformacion_academica=formacion_academica.idformacion_academica ";
$sql.= " AND nombre_datos.idprofesion=profesion.idprofesion AND nombre_datos.idespecialidad_medica=especialidad_medica.idespecialidad_medica  ";
$sql.= " AND personal.idpersonal='$idpersonal_ss' ";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);

$sql_l = " SELECT iddato_laboral, idusuario, idnombre, iddependencia, entidad, cargo_entidad, idministerio, iddireccion, idarea, cargo_mds,";
$sql_l.= " iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud, item_mds, item_red_salud ";
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
<!-- BEGIN aqui va el TITULO de la pagina ---->
                <div class="row">
                    <div class="col-lg-12">
                    <div class="p-3">               
                    <div class="text-center">                     
                    <hr>                     
                    <h4 class="text-primary">NUEVO ESTABLECIMIENTO DE SALUD</h4>
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

<form name="ESTABLECIMIENTO" action="guarda_establecimiento.php" method="post">  
                <div class="col-lg-12">  
                    <div class="p-5"> 

                    <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">DEPARTAMENTO:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="iddepartamento"  id="iddepartamento" class="form-control" required>
                        <option value="">ELEGIR</option>
                        <?php
                        $sql1 = "SELECT iddepartamento, departamento FROM departamento";
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
                    <h6 class="text-primary">RED DE SALUD:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idred_salud" id="idred_salud" class="form-control" required></select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">MUNICIPIO:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idmunicipio" id="idmunicipio" class="form-control" required></select>
                    </div>
                </div>
                <hr>
                <div class="form-group row">                               
                    <div class="col-sm-4">
                    <h6 class="text-primary">CÓDIGO DE ESTABLECIMIENTO:</h6>
                        <input type="text" class="form-control" 
                        placeholder="Codigo Establecimiento" name="codigo_establecimiento" required>
                    </div>
                    <div class="col-sm-8">
                    <h6 class="text-primary">NOMBRE DEL ESTABLECIMIENTO DE SALUD:</h6>
                    <textarea class="form-control" rows="2" name="establecimiento_salud" required></textarea>
                    </div>
                </div>
                <hr>
                <div class="form-group row">                               
                    <div class="col-sm-4">
                    <h6 class="text-primary">NIVEL DE ESTABLECIMIENTO:</h6>
                    <select name="idnivel_establecimiento"  id="idnivel_establecimiento" class="form-control" required>
                        <option value="">ELEGIR</option>
                        <?php
                        $sql1 = "SELECT idnivel_establecimiento, nivel_establecimiento FROM nivel_establecimiento WHERE nivel_oficial='NIVEL'";
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
                    <div class="col-sm-4">
                    <h6 class="text-primary">TIPO DE ESTABLECIMIENTO:</h6>
                    <select name="idtipo_establecimiento"  id="idtipo_establecimiento" class="form-control" required></select>
                    
                    </div>
                    <div class="col-sm-4">
                    <h6 class="text-primary">SUB-SECTOR SALUD:</h6>
                    <select name="idsubsector_salud"  id="idsubsector_salud" class="form-control" required>
                        <option value="">ELEGIR</option>
                        <?php
                        $sql1 = "SELECT idsubsector_salud, subsector_salud FROM subsector_salud WHERE indice='SI'";
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
                <div class="form-group row">                               
                    <div class="col-sm-6">
                    <h6 class="text-primary">DEPENDENCIA INSTITUCIONAL:</h6>
                    <select name="iddependencia_institucion"  id="iddependencia_institucion" class="form-control" required>
                        <option value="">ELEGIR</option>
                        <?php
                        $sql1 = "SELECT iddependencia_institucion, dependencia_institucion FROM dependencia_institucion WHERE indice='SI'";
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
                    <h6 class="text-primary">ÁMBITO LOCAL:</h6>
                    <select name="idambito_local"  id="idambito_local" class="form-control" required>
                        <option value="">ELEGIR</option>
                        <?php
                        $sql1 = "SELECT idambito_local, ambito_local, descripcion FROM ambito_local";
                        $result1 = mysqli_query($link,$sql1);
                        if ($row1 = mysqli_fetch_array($result1)){
                        mysqli_field_seek($result1,0);
                        while ($field1 = mysqli_fetch_field($result1)){
                        } do {
                        echo "<option value=".$row1[0].">".$row1[1].".- ".$row1[2]."</option>";
                        } while ($row1 = mysqli_fetch_array($result1));
                        } else {
                        echo "No se encontraron resultados!";
                        }
                        ?>
                    </select> 
                    
                    </div>
                </div>
<hr>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <h4 class="text-primary">UBICACIÓN GEOGRÁFICA DEL ESTABLECIMIENTO</h4>
                    </div>
                </div>   
                <div class="form-group row">
                    <div class="col-sm-6">
                        <h6 class="text-primary">LATITUD</h6>
                        <input type="NUMBER" name="latitud" class="form-control" id="LAT" placeholder=" Seleccione LATITUD en el mapa" min="-9.662687" max="-22.908152" title="Debe ingresar latitud correspondiente a Bolivia" readonly required>
                    </div>
                    <div class="col-sm-6">
                        <h6 class="text-primary">LONGITUD</h6>
                        <input type="number"  name="longitud" class="form-control" id="LONGI" placeholder="Seleccione LONGITUD en el mapa" min="-57.452675" max="-69.626293" title="Debe ingresar Longitud correspondiente a Bolivia" readonly required>
                       <!-- <input type="number" style="display:none" id="COD_MUN" readonly="readonly" > --->
                    </div>
                </div>   
                <hr>
                <div class="form-group row">
                    <div class="col-sm-9" id="safci" style="width: 660px; height: 250px;">
                    </div>
                    <div class="col-sm-3">
                    <h6>Arrastre el marcador rojo para seleccionar la ubicacion de su Establecimiento de salud</h6>
                    </div>
                </div>  
                
    <!-------- begin rejilla --------->   
                <div class="form-group row">
                    <div class="col-sm-6">

                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>
    <!-------- end rejilla --------->                      
                <div class="text-center">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                REGISTRAR ESTABLECIMIENTO
                                </button>  
                            </div>                              
                                

                   <!-- modal de confirmacion de envio de datos-->
                   <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">REGISTRAR ESTABLECIMIENTO</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    
                                    Esta seguro de Registrar el Establecimiento de Salud?
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
                
                <div class="form-group row">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                    </div>
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

    <script type="text/javascript" src="../js/localizacion.js"></script>
    <script type="text/javascript" src="../js/initMap.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwC0dKzZNKNbnzsslPYLNSExYd8uLqRIk&callback=initMap"></script>

    <!-- scripts para calendario -->
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
        <script>$("#fecha1").datepicker($.datepicker.regional[ "es" ]);</script>
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
        $("#iddepartamento").change(function () {
                    $("#iddepartamento option:selected").each(function () {
                        departamento=$(this).val();
                    $.post("municipios.php", {departamento:departamento}, function(data){
                    $("#idmunicipio").html(data);
                    });
                });
        })
        });
        </script>        
        <script language="javascript">
        $(document).ready(function(){
        $("#idnivel_establecimiento").change(function () {
                    $("#idnivel_establecimiento option:selected").each(function () {
                        nivel_establecimiento=$(this).val();
                    $.post("tipo_establecimiento.php", {nivel_establecimiento:nivel_establecimiento}, function(data){
                    $("#idtipo_establecimiento").html(data);
                    });
                });
        })
        });
        </script>
   
</body>

</html>
