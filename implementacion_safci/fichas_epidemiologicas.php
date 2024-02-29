<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$iddepartamento_ss          = $_SESSION['iddepartamento_ss'];
$idred_salud_ss             = $_SESSION['idred_salud_ss'];
$idmunicipio_ss             = $_SESSION['idmunicipio_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idnotificacion_ep_ss       = $_SESSION['idnotificacion_ep_ss'];
$idsospecha_diag_ss         = $_SESSION['idsospecha_diag_ss'];
$idregistro_enfermedad_ss   = $_SESSION['idregistro_enfermedad_ss'];
$idgrupo_etareo_ss          = $_SESSION['idgrupo_etareo_ss'];
$idgenero_ss                = $_SESSION['idgenero_ss'];

$sql =" SELECT notificacion_ep.idnotificacion_ep, notificacion_ep.codigo, departamento.departamento, red_salud.red_salud,  ";
$sql.=" municipios.municipio, establecimiento_salud.establecimiento_salud, notificacion_ep.semana_ep, ";
$sql.=" notificacion_ep.fecha_registro, notificacion_ep.hora_registro, nombre.nombre, nombre.paterno, nombre.materno, ";
$sql.=" notificacion_ep.iddepartamento, notificacion_ep.idred_salud, notificacion_ep.idmunicipio, notificacion_ep.idestablecimiento_salud ";
$sql.=" FROM notificacion_ep, departamento, red_salud, municipios, establecimiento_salud, usuarios, nombre ";
$sql.=" WHERE notificacion_ep.iddepartamento=departamento.iddepartamento AND notificacion_ep.idred_salud=red_salud.idred_salud ";
$sql.=" AND notificacion_ep.idmunicipio=municipios.idmunicipio AND notificacion_ep.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
$sql.=" AND notificacion_ep.idusuario=usuarios.idusuario AND usuarios.idnombre=nombre.idnombre AND notificacion_ep.idnotificacion_ep='$idnotificacion_ep_ss ' ";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);

$sql_sos = " SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idsospecha_diag='$idsospecha_diag_ss' ";
$result_sos = mysqli_query($link,$sql_sos);
$row_sos = mysqli_fetch_array($result_sos);

$sql_et = " SELECT idgrupo_etareo, grupo_etareo FROM grupo_etareo WHERE idgrupo_etareo='$idgrupo_etareo_ss' ";
$result_et = mysqli_query($link,$sql_et);
$row_et = mysqli_fetch_array($result_et);

$sql_g = " SELECT idgenero, genero FROM genero WHERE idgenero='$idgenero_ss' ";
$result_g = mysqli_query($link,$sql_g);
$row_g = mysqli_fetch_array($result_g);

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
                    <div class="text-center"> 
                    <a href="notificacion_ep_seg.php"><h6 class="text-success" ><i class="fas fa-fw fa-arrow-left"></i>VOLVER</h6></a>
                    </div>  
                    <h4 class="text-primary">FICHAS EPIDEMIOLÓGICAS </h4>
                    <h4 class="text-secundary">NOTIFICACIÓN : <?php echo $row[1];?></h4>
                    <p class="mb-4">En esta seccion se puede administrar los registros de FICHAS EPIDEMIOLÓGICAS.</p>

                    
                    <!-- DataTales Example -->

                    <div class="card shadow mb-4">

                        <div class="card-header py-3">

                            <h4 class="m-0 font-weight-bold text-primary"><?php echo mb_strtoupper($row_sos[1]);?></h4>
                            <h6 class="m-0 font-weight-bold text-primary">GRUPO ETAREO: <?php echo $row_et[1];?> - <?php echo $row_g[1];?></h6>
                            <h6 class="m-0 font-weight-bold text-secundary">DEPARTAMENTO: <?php echo $row[2];?> - RED: <?php echo $row[3];?></h6>
                            <h6 class="m-0 font-weight-bold text-secundary"></h6>
                            <h6 class="m-0 font-weight-bold text-secundary">MUNICIPIO: <?php echo $row[4];?></h6>
                            <h6 class="m-0 font-weight-bold text-secundary">ESTABLECIMIENTO: <?php echo $row[5];?></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>  
                                            <th>N°</th>                                    
                                            <th>CÓDIGO FICHA</th>
                                            <th>CÉDULA</th>
                                            <th>PACIENTE</th> 
                                            <th>TELEFONO/CELULAR</th> 
                                            <th>MÉDICO REGISTRADOR</th>             
                                            <th>ACCIÓN</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                        <?php
                        $numero=1;
                        $sql =" SELECT ficha_ep.idficha_ep, ficha_ep.codigo, nombre.ci, nombre.nombre, nombre.paterno, nombre.materno, ficha_ep.celular, ficha_ep.idusuario ";
                        $sql.=" FROM ficha_ep, registro_enfermedad, notificacion_ep, nombre WHERE ficha_ep.idregistro_enfermedad=registro_enfermedad.idregistro_enfermedad ";
                        $sql.=" AND registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND ficha_ep.idnombre=nombre.idnombre ";
                        $sql.=" AND registro_enfermedad.idregistro_enfermedad='$idregistro_enfermedad_ss' ";
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
                                <td><?php echo mb_strtoupper($row[3]);?> <?php echo mb_strtoupper($row[4]);?> <?php echo mb_strtoupper($row[5]);?></td>
                                <td><?php echo $row[6];?></td>
                                <td><?php
                                $sql_med = " SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row[7]' ";
                                $result_med = mysqli_query($link,$sql_med);
                                $row_med = mysqli_fetch_array($result_med);
                                echo mb_strtoupper($row_med[0]." ".$row_med[1]." ".$row_med[2]);?></td>
                                <td>
                                <form name="FORM_RED" action="valida_ficha_paciente.php" method="post">
                                <input name="idficha_ep" type="hidden" value="<?php echo $row[0];?>">
                                    <button type="submit" class="btn btn-secondary btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-hospital"></i>
                                    </span>
                                    <span class="text">FICHA</span>    
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
