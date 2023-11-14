<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$sql = " SELECT personal.idpersonal, personal.idusuario, personal.idnombre, nombre.nombre, nombre.paterno, nombre.materno, nombre.fecha_nac, ";
$sql.= " nombre.ci, nombre.complemento, nombre.exp, nombre.idnacionalidad, nombre.idgenero, nombre_datos.idformacion_academica, ";
$sql.= " nombre_datos.idprofesion, nombre_datos.idespecialidad_medica, nombre_datos.correo, nombre_datos.celular, ";
$sql.= " nombre_datos.direccion_dom, nombre_datos.idprofesion, personal.iddato_laboral, personal.idnombre_datos ";
$sql.= " FROM personal, nombre, nacionalidad, genero, nombre_datos, formacion_academica, profesion, especialidad_medica ";
$sql.= " WHERE personal.idnombre=nombre.idnombre AND nombre.idnacionalidad=nacionalidad.idnacionalidad AND nombre.idgenero=genero.idgenero ";
$sql.= " AND personal.idnombre_datos=nombre_datos.idnombre_datos AND nombre_datos.idformacion_academica=formacion_academica.idformacion_academica ";
$sql.= " AND nombre_datos.idprofesion=profesion.idprofesion AND nombre_datos.idespecialidad_medica=especialidad_medica.idespecialidad_medica  ";
$sql.= " AND personal.idnombre='$idnombre_ss' AND personal.idusuario='$idusuario_ss' ";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);

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
                    <a href="modifica_registro_safci_individual.php"><h6>VOLVER</h6></a>
                    <hr>                     
                    <h4 class="text-primary">ACTUALIZAR REGISTRO SAFCI</h4>
                    <h4></h4>
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->
                </br> 
<!---       <div class="text-center">  
                <h6 class="text-primary">DATOS LABORALES EN EL MINISTERIO DE SALUD</h6>  
            </div>   

        <div class="form-group row">
                <div class="col-sm-12">
                <div class="table-responsive">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nª</th>
                                            <th>DEPENDENCIA MSYD</th>
                                            <th>DIRECCIÓN</th>
                                            <th>UNIDAD</th>
                                            <th>CARGO MSYD</th>
                                            <th>ITEM MSYD</th>
                                            <th>DEPARTAMENTO</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                                    <?php
                                $numero=1;
                                $sql0 =" SELECT dato_laboral.iddato_laboral, dato_laboral.idusuario, dato_laboral.idnombre, ministerio.ministerio, direccion.direccion, area.area, dato_laboral.cargo_mds, dato_laboral.item_mds,";
                                $sql0.=" departamento.departamento FROM dato_laboral, ministerio, direccion, area, departamento WHERE dato_laboral.idministerio=ministerio.idministerio AND  ";
                                $sql0.=" dato_laboral.iddireccion=direccion.iddireccion AND dato_laboral.idarea=area.idarea AND dato_laboral.iddepartamento=departamento.iddepartamento AND ";
                                $sql0.=" dato_laboral.idnombre='$row[2]' AND dato_laboral.iddependencia='2' ";
                                $result0 = mysqli_query($link,$sql0);
                                if ($row0 = mysqli_fetch_array($result0)){
                                mysqli_field_seek($result0,0);
                                while ($field0 = mysqli_fetch_field($result0)){
                                } do {
                                ?>
                                    <tr>
                                        <td><?php echo $numero;?></td>
                                        <td><?php echo $row0[3];?></td>
                                        <td><?php echo $row0[4];?></td>
                                        <td><?php echo $row0[5];?></td>
                                        <td><?php echo $row0[6];?></td>
                                        <td><?php echo $row0[7];?></td>
                                        <td><?php echo $row0[8];?></td>
                                    </tr>                                    
                            <?php
                            $numero=$numero+1;
                            }
                            while ($row0 = mysqli_fetch_array($result0));
                            } else {
                            }
                            ?>
                                    </tbody>
                                </table>
                            </div>
                </div>
            </div>   
---- datos laborales RED DE SALUD --------->

            <div class="text-center">  
                <h4 class="text-primary">LUGARES DE TRABAJO </h4>  
            </div>   
            <hr>
            <div class="form-group row">
                <div class="col-sm-12">
                <div class="table-responsive">
            <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nª</th>
                        <th>RED DE SALUD</th>
                        <th>ESTABLECIMIENTO</th>
                        <th>CARGO</th>
                        <th>ITEM </th>
                        <th>DEPARTAMENTO</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $numerodos=1;
                $sql0 =" SELECT dato_laboral.iddato_laboral, dato_laboral.idusuario, dato_laboral.idnombre, departamento.departamento, red_salud.red_salud, establecimiento_salud.establecimiento_salud,  ";
                $sql0.=" dato_laboral.cargo_red_salud, dato_laboral.item_red_salud FROM dato_laboral, red_salud, establecimiento_salud, departamento WHERE dato_laboral.idred_salud=red_salud.idred_salud AND  ";
                $sql0.=" dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND dato_laboral.iddepartamento=departamento.iddepartamento AND ";
                $sql0.=" dato_laboral.idnombre='$row[2]' AND dato_laboral.iddependencia='3' ";
                $result0 = mysqli_query($link,$sql0);
                if ($row0 = mysqli_fetch_array($result0)){
                mysqli_field_seek($result0,0);
                while ($field0 = mysqli_fetch_field($result0)){
                } do {
                ?>
                    <tr>
                        <td><?php echo $numerodos;?></td>
                        <td><?php echo $row0[4];?></td>
                        <td><?php echo $row0[5];?></td>
                        <td><?php echo $row0[6];?></td>
                        <td><?php echo $row0[7];?></td>
                        <td><?php echo $row0[3];?></td>
                        <td>
                        <form name="FORM11" action="elimina_laboral_individual.php" method="post">
                        <input name="iddato_laboral" type="hidden" value="<?php echo $row0[0];?>">
                            <button class="btn btn-danger btn-icon-split" type="submit">
                                <span class="icon text-white-50">
                                    <i class="fas fa-trash"></i>
                                </span>
                                <span class="text">Eliminar</span>
                            </button>
                        </form>
                        </td>
                    </tr>
                    
                    <?php
                    $numerodos = $numerodos+1;
    }
    while ($row0 = mysqli_fetch_array($result0));
    } else {
    }
    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>   

                <div class="text-center">  
                <h6 class="text-primary">ACTUALIZAR LUGAR DE TRABAJO:</h6>  
                </div>                                 
          
                </br> 
                <form name="LABORALES" action="guarda_laboral_int_individual.php" method="post">  
                <input type="hidden" name="idpersonal" value="<?php echo $row[0];?>">
                <input type="hidden" name="iddependencia" value="3">

<div class="form-group row">
    <div class="col-sm-3">
    <h6 class="text-primary">DEPARTAMENTO:</h6>
    </div>
    <div class="col-sm-9">
    <select name="iddepartamento"  id="iddepartamento" class="form-control" required>
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
    <h6 class="text-primary">RED DE SALUD:</h6>
    </div>
    <div class="col-sm-9">
    <select name="idred_salud" id="idred_salud" class="form-control" required></select>
    </div>
</div>

<div class="form-group row">
    <div class="col-sm-3">
    <h6 class="text-primary">ESTABLECIMIENTO DE SALUD:</h6>
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
    <h6 class="text-primary">NÚMERO DE ÍTEM:</h6><h6 class="text-primary">(DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN):</h6>
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
            REGISTRAR LUGAR DE TRABAJO
            </button>  
        </div>                              
    </div>                            
</div>
   <!-- modal de confirmacion de envio de datos-->
   <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">REGISTRAR LUGAR DE TRABAJO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    
                    Esta seguro de Agregar el nuevo lugar de trabajo?
    
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