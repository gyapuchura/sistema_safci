<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America?La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idred_salud_ss  =  $_SESSION['idred_salud_ss'];

$sqlus =" SELECT nombres, paterno, materno FROM nombres WHERE idnombre='$idnombre_ss'";
$resultus = mysqli_query($link,$sqlus);
$rowus = mysqli_fetch_array($resultus);
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

                    <h1 class="h3 mb-2 text-gray-800">ESTABLECIMIENTOS DE SALUD A NIVEL NACIONAL</h1>
                    <p class="mb-4">En esta seccion se puede encontrar el regsitro de REDES DE SALUD del PROGBRAMA NACIONAL SAFCI - MI SALUD.</p>

                    
                    <!-- DataTales Example -->

                    <div class="card shadow mb-4">

                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">ESTABLECIMIENTOS DE SALUD</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>  
                                            <th>N°</th>                                    
                                            <th>CÓDIGO</th>
                                            <th>DEPARTAMENTO</th>
                                            <th>RED DE SALUD</th>
                                            <th>MUNICIPIO</th>
                                            <th>ESTABLECIMIENTO DE SALUD</th>
                                            <th>NIVEL</th>               
                                            <th>ACCIÓN</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                        <?php
                        $numero=1;
                        $sql =" SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.codigo_establecimiento, municipios.municipio,  ";
                        $sql.=" establecimiento_salud.establecimiento_salud, nivel_establecimiento.nivel_establecimiento, red_salud.red_salud, departamento.departamento ";
                        $sql.=" FROM establecimiento_salud, municipios, nivel_establecimiento, red_salud, departamento WHERE establecimiento_salud.idmunicipio=municipios.idmunicipio ";
                        $sql.=" AND establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento AND red_salud.iddepartamento=departamento.iddepartamento ";
                        $sql.=" AND establecimiento_salud.idred_salud=red_salud.idred_salud ORDER BY establecimiento_salud.idestablecimiento_salud ";
                        $result = mysqli_query($link,$sql);
                        if ($row = mysqli_fetch_array($result)){
                        mysqli_field_seek($result,0);
                        while ($field = mysqli_fetch_field($result)){
                        } do {
                        ?>
                            <tr>
                                <td><?php echo $numero;?></td>
                                <td><?php echo $row[1];?></td>
                                <td><?php echo $row[6];?></td>
                                <td><?php echo $row[5];?></td>
                                <td><?php echo $row[2];?></td>
                                <td><?php echo $row[3];?></td>
                                <td><?php echo $row[4];?></td>
                                <td>
                                <form name="FORM_RED" action="valida_establecimiento_salud.php" method="post">
                                <input name="idestablecimiento_salud" type="hidden" value="<?php echo $row[0];?>">
                                    <button type="submit" class="btn btn-secondary btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-hospital"></i>
                                    </span>
                                    <span class="text">VER ESTABLECIMIENTO</span>    
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
