<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

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

                    <h1 class="h3 mb-2 text-gray-800">VACUNACIÓN A NIVEL NACIONAL</h1>
                    <p class="mb-4">En esta seccion se puede encontrar el registro de EVENTOS DE ATENCIÓN SAFCI.</p>

                    
                    <!-- DataTales Example -->

                    <div class="card shadow mb-4">

                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">EVENTOS DE VACUNACIÓN SAFCI</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>  
                                            <th>N°</th>                                    
                                            <th>CÓDIGO</th>
                                            <th>EVENTO DE VACUNACIÓN</th>
                                            <th>VACUNA</th>
                                            <th>FECHA DE INICIO</th>
                                            <th>FECHA DE CONCLUSIÓN</th>
                                            <th>USUARIO REGISTRADOR</th>           
                                            <th>ACCIÓN</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                        <?php
                        $numero=1;
                        $sql =" SELECT evento_vacunacion.idevento_vacunacion, evento_vacunacion.codigo, tipo_evento_vacunacion.tipo_evento_vacunacion, vacuna.vacuna, nombre.nombre, ";
                        $sql.=" nombre.paterno, nombre.materno, evento_vacunacion.fecha_inicio, fecha_conclusion FROM evento_vacunacion, tipo_evento_vacunacion, vacuna, usuarios, nombre ";
                        $sql.=" WHERE evento_vacunacion.idtipo_evento_vacunacion=tipo_evento_vacunacion.idtipo_evento_vacunacion ";
                        $sql.=" AND evento_vacunacion.idvacuna=vacuna.idvacuna AND evento_vacunacion.idusuario=usuarios.idusuario ";
                        $sql.=" AND usuarios.idnombre=nombre.idnombre ORDER BY evento_vacunacion.idevento_vacunacion DESC ";
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
                                <td>
                                <?php 
                                 $fecha_i = explode('-',$row[7]);
                                 $f_inicio = $fecha_i[2].'/'.$fecha_i[1].'/'.$fecha_i[0];
                                 echo $f_inicio;?>
                                 </td>
                                 <td>
                                <?php 
                                 $fecha_f = explode('-',$row[8]);
                                 $f_conclusion = $fecha_f[2].'/'.$fecha_f[1].'/'.$fecha_f[0];
                                 echo $f_conclusion;?>
                                </td>
                                <td><?php echo mb_strtoupper($row[4]." ".$row[5]." ".$row[6]);?></td>
                                <td>
                                <form name="FORM_EVENTO" action="valida_evento_vacunacion.php" method="post">
                                <input name="idevento_vacunacion" type="hidden" value="<?php echo $row[0];?>">
                                    <button type="submit" class="btn btn-primary btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-hospital"></i>
                                    </span>
                                    <span class="text">INGRESAR A EVENTO</span>    
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
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]] ,
                    "language": {
                        "lengthMenu": "Mostrar _MENU_ registros por pagina",
                        "zeroRecords": "No se encontraron resultados en su busqueda",
                        "searchPlaceholder": "Buscar registros",
                        "info": "Mostrando Eventos de _START_ al _END_ de un total de  _TOTAL_ Eventos",
                        "infoEmpty": "No existen Eventos",
                        "infoFiltered": "(filtrado de un total de _MAX_ Eventos)",
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
