<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion 			    = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$iddepartamento_ss  =  $_SESSION['iddepartamento_ss'];
$idred_salud_ss     =  $_SESSION['idred_salud_ss'];
$idmunicipio_ss     =  $_SESSION['idmunicipio_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];

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
                <div class="container-fluid">

                    <!-- Page Heading -->
                        </br>

                    <h1 class="h3 mb-2 text-gray-800">ÁREAS DE INFLUENCIA - MUNICIPIO</h1>
                    <p class="mb-4">En esta seccion se puede encontrar el registro de ÁREAS DE INFLUENCIA del PROGRAMA NACIONAL SAFCI - MI SALUD.</p>

                    
                    <!-- DataTales Example -->

                <div class="card shadow mb-4">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">ÁREAS DE INFLUENCIA DEL MUNICIPIO</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                <thead>
                                    <tr>  
                                        <th>N°</th>                                    
                                        <th>DEPARTAMENTO</th>
                                        <th>RED DE SALUD</th> 
                                        <th>ESTABLECIMIENTO DE SALUD</th>
                                        <th>DENOMINACIÓN DEL ÁREA DE INFLUENCIA</th>
                                        <th>NUMERO DE CARPETAS FAMILIARES</th>
                                        <th>ACCIÓN</th>
                                        <th>CARPETAS FAMILIARES</th>
                                    </tr>
                                </thead>
                                <tbody>
                        <?php
                        $numero=1; 
                        $sql =" SELECT area_influencia.idarea_influencia, departamento.departamento, red_salud.red_salud, establecimiento_salud.establecimiento_salud, ";
                        $sql.=" tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia FROM area_influencia, departamento, red_salud, tipo_area_influencia, ";
                        $sql.=" establecimiento_salud WHERE area_influencia.iddepartamento=departamento.iddepartamento AND area_influencia.idred_salud=red_salud.idred_salud ";
                        $sql.=" AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND area_influencia.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
                        $sql.=" AND area_influencia.iddepartamento='$iddepartamento_ss' AND area_influencia.idred_salud='$idred_salud_ss' AND area_influencia.idestablecimiento_salud='$idestablecimiento_salud_ss' ";
                        $sql.=" ORDER BY area_influencia.idarea_influencia DESC ";
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
                                <td><?php echo mb_strtoupper($row[4]." ".$row[5]);?></td>
                                <td><?php 
                                $sql_cf = " SELECT count(idcarpeta_familiar) FROM carpeta_familiar WHERE carpeta_familiar.estado='CONSOLIDADO' AND idarea_influencia = '$row[0]' ";
                                $result_cf = mysqli_query($link,$sql_cf);    
                                $row_cf = mysqli_fetch_array($result_cf);
                                $carpetas_familiares = $row_cf[0];
                                echo $carpetas_familiares;
                                ?></td>
                                <td>
                                <form name="FORM_RED" action="valida_area_influencia_mun.php" method="post">
                                <input name="idarea_influencia" type="hidden" value="<?php echo $row[0];?>">
                                <button type="submit" class="btn btn-secondary btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-arrow-right"></i>
                                </span>
                                <span class="text">VER DETALLES</span>
                                </button>
                                </form>                                                                          
                                </td>
                                <td>
                                <form name="FORM_RED" action="valida_area_influencia_cfm.php" method="post">
                                <input name="idarea_influencia" type="hidden" value="<?php echo $row[0];?>">
                                <input name="idarea_influencia" type="hidden" value="<?php echo $row[0];?>">
                                <button type="submit" class="btn btn-warning btn-icon-split">
                                <span class="icon text-yellow-600">
                                <i class="fas fa-fw fa-folder"></i>
                                </span>
                                <span class="text">CARPETAS FAMILIARES</span>
                                </button>
                                </form>                                                                          
                                </td>
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
                </div>
            </div>

        </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Ministerio de Salud y Deportes &copy; MSYD <?php echo $gestion; ?></span>
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

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                    <a class="btn btn-primary" href="salir.php">Salir de Sistema</a>
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

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                        "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]] ,
                        "language": {
                            "lengthMenu": "Mostrar _MENU_ registros por pagina",
                            "zeroRecords": "No se encontraron resultados en su busqueda",
                            "searchPlaceholder": "Buscar registros",
                            "info": "Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros",
                            "infoEmpty": "No existen registros",
                            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
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
