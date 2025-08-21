<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$mes 					= date("m");

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
                    <h1 class="h3 mb-2 text-gray-800">DECLARACIONES GESTIÓN PARTICIPATIVA - SAFCI </h1>
                    <p class="mb-4">En esta sección se puede encontrar el registro de DECLARACIONES DE GESTIÓN PARTICIPATIVA del PROGRAMA NACIONAL SAFCI - MI SALUD.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">GESTIÓN PARTICIPATIVA - SAFCI</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>  
                                            <th>N°</th>  
                                            <th>CÓDIGO</th>                                   
                                            <th>DEPARTAMENTO</th>
                                            <th>MUNICIPIO</th>
                                            <th>RESPONSABLE MUNICIPAL</th>
                                            <th>FECHA DE REGISTRO</th>
                                            <th>ACCIÓN</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                        <?php
                        $numero=1;
                        $sql =" SELECT gestion_participativa.idgestion_participativa, gestion_participativa.codigo, departamento.departamento, municipios.municipio,  ";
                        $sql.=" nombre.nombre, nombre.paterno, nombre.materno, gestion_participativa.fecha_registro, gestion_participativa.hora_registro, gestion_participativa.idusuario FROM gestion_participativa, departamento, municipios, nombre, usuarios ";
                        $sql.=" WHERE gestion_participativa.iddepartamento=departamento.iddepartamento AND gestion_participativa.idmunicipio=municipios.idmunicipio  ";
                        $sql.=" AND gestion_participativa.idusuario=usuarios.idusuario AND usuarios.idnombre=nombre.idnombre ORDER BY gestion_participativa.idgestion_participativa ";
                        $result = mysqli_query($link,$sql);
                        if ($row = mysqli_fetch_array($result)){
                        mysqli_field_seek($result,0);
                        while ($field = mysqli_fetch_field($result)){
                        } do {
                        ?>
                                        <tr>
                                            <td><?php echo $numero;?></td>
                                            <td>
                                                <a href="formulario_gestion_participativa.php?idgestion_participativa=<?php echo $row[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=950,height=900,top=50, left=200, scrollbars=YES'); return false;">
                                                <?php echo $row[1];?></a>
                                            </td>
                                            <td><?php echo $row[2];?></td>
                                            <td><?php echo $row[3];?></td>
                                            <td><?php echo mb_strtoupper($row[4]." ".$row[5]." ".$row[6]);?></td>
                                            <td>
                                            <?php 
                                                $fecha_r = explode('-',$row[7]);
                                                $f_apertura = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                                            <?php echo $f_apertura;?></br><?php echo $row[8];?>   
                                            </td>
                                            <td>
                                                <form name="FORM_GP" action="valida_declaracion_gp.php" method="post">
                                                <input name="idgestion_participativa" type="hidden" value="<?php echo $row[0];?>">
                                                <button type="submit" class="btn btn-primary btn-user btn-block">VER</button></form>                                                             
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

                <hr>
                <div class="text-center">
                <div class="form-group row"> 
                        <div class="col-sm-4">
                        <a href="imprime_reporte_gp.php" target="_blank" class="text-info" style="font-size: 15px; font-family: Arial;" onClick="window.open(this.href, this.target, 'width=1220,height=800,scrollbars=YES,top=60,left=400'); return false;">
                        MOSTRAR DECLARACIONES GESTIÓN PARTICIPATIVA</a>   
                        </div>
                        <div class="col-sm-4">

                        </div>
                        <div class="col-sm-4">
                    <form name="REPORTE_CF" action="reporte_gp_excel.php" method="post">
                        <input type="hidden" name="idusuario_op" value="<?php echo $idusuario_op;?>">
                        <button type="submit" class="btn btn-success">REPORTE EXCEL DECLARACIONES</button>
                    </form>
                    </div>
                </div>   
                <hr>


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
