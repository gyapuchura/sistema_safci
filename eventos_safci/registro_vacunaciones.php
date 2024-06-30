<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idevento_vacunacion_ss  =  $_SESSION['idevento_vacunacion_ss'];

$sql_ev =" SELECT idevento_vacunacion, codigo, idtipo_evento_vacunacion, idvacuna, descripcion, fecha_inicio, fecha_conclusion ";
$sql_ev.=" FROM evento_vacunacion WHERE idevento_vacunacion='$idevento_vacunacion_ss' ";
$result_ev=mysqli_query($link,$sql_ev);
$row_ev=mysqli_fetch_array($result_ev);

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
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
                    <a href="eventos_vacunacion.php" class="text-info">VOLVER</a>                   
                    <hr>                                         
                    <h4 class="text-primary">REGISTRO DE VACUNACIONES:</h4>
                    <h4 class="text-secundary"><?php echo $row_ev[1];?></h4>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

<form name="GUARDA_VACUNACION" action="guarda_vacunacion_anim.php" method="post">  

                <div class="col-lg-12">  
                    <div class="p-3"> 
   
                <div class="text-center">
                <h4 class="text-primary">NUEVO REGISTRO DE VACUNACIÓN:</h4>
                <hr>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"><i class="fas fa-dog"> </i> CANES MACHOS:</h6>
                        <input type="number" class="form-control" 
                        placeholder="ingresar cantidad" name="can_macho" required>
                        </div>
                        <div class="col-sm-6">
                        <h6 class="text-danger"> <i class="fas fa-dog"> </i> CANES HEMBRAS:</h6>
                        <input type="number" class="form-control" 
                        placeholder="ingresar cantidad" name="can_hembra" required>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-secundary"> <i class="fas fa-cat"> </i>  GATOS:</h6>
                        <input type="number" class="form-control" 
                        placeholder="ingresar cantidad" name="gato" required>
                        </div>
                        <div class="col-sm-6">
                        <h6 class="text-info"> <i class="fas fa-chicken"> </i> OTROS ANIMALES:</h6>
                        <input type="number" class="form-control" 
                        placeholder="ingresar cantidad" name="otro" required>
                        </div>
                    </div>
                </br>
                    <div class="text-center">
            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    REGISTRAR VACUNACIÓN
                    </button>  
                </div> 
            </div>                              
                            
                   <!-- modal de confirmacion de envio de datos-->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">REGISTRO DE VACUNACIÓN</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            
                            Esta seguro de Registrar la VACUNACIÓN?
                        
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-primary pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form>        
                    
                </div>
             </br>

<hr>
            <div class="text-center">
                <h4 class="text-primary">VACUNACIONES REGISTRADAS:</h4>
            </div>
<hr>
        <div class="table-responsive">
            <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                <thead>
                    <tr>  
                        <th>N°</th> 
                        <th>DEPTO.</th>
                        <th>MUNICIPIO</th>
                        <th>ESTABLECIMIENTO</th>
                        <th>PERSONAL SAFCI</th>                                   
                        <th>N° </br>CANES</br> MACHOS</th>
                        <th>N° </br>CANES</br> HEMBRAS </th>
                        <th>N° GATOS</th>
                        <th>OTROS</th>
                        <th>FECHA Y HORA DE REGISTRO</th>         
                    </tr>
                </thead>
                <tbody>
                <?php
                $numero=1;
                $sql =" SELECT vacunacion_anim.idvacunacion_anim, departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud, ";
                $sql.=" nombre.nombre, nombre.paterno, nombre.materno, vacunacion_anim.can_macho, vacunacion_anim.can_hembra, vacunacion_anim.gato, vacunacion_anim.otro, ";
                $sql.=" vacunacion_anim.fecha_registro, vacunacion_anim.hora_registro FROM vacunacion_anim, departamento, municipios, establecimiento_salud, usuarios, nombre ";
                $sql.=" WHERE vacunacion_anim.iddepartamento=departamento.iddepartamento AND vacunacion_anim.idmunicipio=municipios.idmunicipio  ";
                $sql.=" AND vacunacion_anim.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND vacunacion_anim.idusuario=usuarios.idusuario  ";
                $sql.=" AND usuarios.idnombre=nombre.idnombre AND vacunacion_anim.idevento_vacunacion='$idevento_vacunacion_ss' ORDER BY vacunacion_anim.idvacunacion_anim DESC ";
                $result = mysqli_query($link,$sql);
                if ($row = mysqli_fetch_array($result)){
                mysqli_field_seek($result,0);
                while ($field = mysqli_fetch_field($result)){
                } do {
                ?>
                    <tr>
                        <td><?php echo $numero;?></td>
                        <td><?php echo $row[1];?></td>
                        <td><?php echo $row[2];?></td>
                        <td><?php echo $row[3];?></td>
                        <td><?php echo mb_strtoupper($row[4]." ".$row[5]." ".$row[6]);?></td>
                        <td><?php echo $row[7];?></td>
                        <td><?php echo $row[8];?></td>
                        <td><?php echo $row[9];?></td>
                        <td><?php echo $row[10];?></td>
                        <td><?php 
                        $fecha_r = explode('-',$row[11]);
                        $fecha_reg = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];
                        echo $fecha_reg; ?> - <?php echo $row[12];?></td>

                    </tr>
                                
                <?php
                $numero=$numero+1;
                }
                while ($row = mysqli_fetch_array($result));
                } else {
                }
                ?>
                    </tbody>
                </table>
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
<!-- Page level plugins -->
<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

    <script>
    $(document).ready(function() {
        $('#example').DataTable( {
                    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]] ,
                    "language": {
                        "lengthMenu": "Mostrar _MENU_ registros por pagina",
                        "zeroRecords": "No se encontraron resultados en su busqueda",
                        "searchPlaceholder": "Buscar registros",
                        "info": "Mostrando Registros de _START_ al _END_ de un total de  _TOTAL_ Registros",
                        "infoEmpty": "No existen Registros",
                        "infoFiltered": "(filtrado de un total de _MAX_ Registros)",
                        "search": "Buscar:",
                        "paginate": {
                            "first":    "Primero",
                            "last":    "Último",
                            "next":    "Siguiente",
                            "previous": "Anterior"
                        },
                    }
                } );
            } );
    </script>
    
</body>
</html>