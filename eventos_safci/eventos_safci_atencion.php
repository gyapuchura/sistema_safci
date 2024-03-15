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

                    <h1 class="h3 mb-2 text-gray-800">ATENCIÓN MÉDICA EN EVENTOS SAFCI</h1>
                    <p class="mb-4">En esta seccion se puede registrar el proceso de atencion medica en eventoa SAFCI.</p>

                    
                    <!-- DataTales Example -->

                    <div class="card shadow mb-4">

                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">EVENTOS DE ATENCIÓN MÉDICA SAFCI</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>  
                                            <th>N°</th>                                    
                                            <th>CÓDIGO</th>
                                            <th>TIPO DE EVENTO</th>
                                            <th>DEPARTAMENTO</th>
                                            <th>MUNICIPIO</th>
                                            <th>ESTABLECIMIENTO DE SALUD</th>  
                                            <th>USUARIO REGISTRADOR</th>           
                                            <th>ACCIÓN</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                        <?php
                        $numero=1;
                        $sql =" SELECT evento_safci.idevento_safci, evento_safci.codigo, departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud, ";
                        $sql.=" cat_evento_safci.cat_evento_safci, tipo_evento_safci.tipo_evento_safci, nombre.nombre, nombre.paterno, nombre.materno ";
                        $sql.=" FROM evento_safci, departamento, municipios, establecimiento_salud, cat_evento_safci, tipo_evento_safci, usuarios, nombre ";
                        $sql.=" WHERE evento_safci.iddepartamento=departamento.iddepartamento AND evento_safci.idmunicipio=municipios.idmunicipio AND ";
                        $sql.=" evento_safci.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND evento_safci.idcat_evento_safci=cat_evento_safci.idcat_evento_safci AND ";
                        $sql.=" evento_safci.idtipo_evento_safci=tipo_evento_safci.idtipo_evento_safci AND evento_safci.idusuario=usuarios.idusuario AND  ";
                        $sql.=" usuarios.idnombre=nombre.idnombre ORDER BY evento_safci.idevento_safci DESC ";
                        $result = mysqli_query($link,$sql);
                        if ($row = mysqli_fetch_array($result)){
                        mysqli_field_seek($result,0);
                        while ($field = mysqli_fetch_field($result)){
                        } do {
                        ?>
                            <tr>
                                <td><?php echo $numero;?></td>
                                <td><?php echo $row[1];?></td>
                                <td><?php echo $row[5];?>-<?php echo $row[6];?></td>
                                <td><?php echo $row[2];?></td>
                                <td><?php echo $row[3];?></td>
                                <td><?php echo $row[4];?></td>
                                <td><?php echo mb_strtoupper($row[7]." ".$row[8]." ".$row[9]);?></td>
                                <td>
                                <form name="FORM_EVENTO" action="valida_evento_safci_atencion.php" method="post">
                                <input name="idevento_safci" type="hidden" value="<?php echo $row[0];?>">
                                    <button type="submit" class="btn btn-primary btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-hospital"></i>
                                    </span>
                                    <span class="text">ATENCIONES</span>    
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
                        "info": "Mostrando Establecimientos de _START_ al _END_ de un total de  _TOTAL_ Establecimientos",
                        "infoEmpty": "No existen Establecimientos",
                        "infoFiltered": "(filtrado de un total de _MAX_ Establecimientos)",
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
