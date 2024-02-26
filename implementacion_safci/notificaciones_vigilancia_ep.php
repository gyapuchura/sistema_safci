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

$sqle =" SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud_ss'  ";
$resulte = mysqli_query($link,$sqle);
$rowe = mysqli_fetch_array($resulte);

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
                    <h2 class="h3 mb-2 text-gray-800">NOTIFICACIONES DEL ESTABLECIMIENTO: <?php echo $rowe[1];?></h2>
                    <p class="mb-4">En esta seccion se puede encontrar el registro de ÁREAS DE INFLUENCIA del PROGRAMA NACIONAL SAFCI - MI SALUD.</p>
                    
                    <!-- DataTales Example -->

                <div class="card shadow mb-4">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">NOTIFICACIONES A NIVEL DE ESTABLECIMIENTO (OPERATIVO)</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                <thead>
                                    <tr>  
                                        <th>N°</th>  
                                        <th>CÓDIGO NOTIFICACIÓN</th>                                  
                                        <th>MUNICIPIO</th>
                                        <th>ESTABLECIMIENTO</th>                                      
                                        <th>SEMANA EPIDEM.</th>
                                        <th>USUARIO:</th>
                                        <th>FECHA</th>
                                        <th>ACCIÓN</th>
                                        <th>FICHAS </br>EPIDEMIOLÓGICAS</th>
                                    </tr>
                                </thead>
                                <tbody>
                        <?php
                        $numero=1; 
                        $sql =" SELECT notificacion_ep.idnotificacion_ep, notificacion_ep.codigo, departamento.departamento, red_salud.red_salud,  ";
                        $sql.=" municipios.municipio, establecimiento_salud.establecimiento_salud, notificacion_ep.semana_ep, ";
                        $sql.=" notificacion_ep.fecha_registro, notificacion_ep.hora_registro, nombre.nombre, nombre.paterno, nombre.materno, ";
                        $sql.=" notificacion_ep.iddepartamento, notificacion_ep.idred_salud, notificacion_ep.idmunicipio, notificacion_ep.idestablecimiento_salud, notificacion_ep.estado ";
                        $sql.=" FROM notificacion_ep, departamento, red_salud, municipios, establecimiento_salud, usuarios, nombre ";
                        $sql.=" WHERE notificacion_ep.iddepartamento=departamento.iddepartamento AND notificacion_ep.idred_salud=red_salud.idred_salud ";
                        $sql.=" AND notificacion_ep.idmunicipio=municipios.idmunicipio AND notificacion_ep.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
                        $sql.=" AND notificacion_ep.idusuario=usuarios.idusuario AND usuarios.idnombre=nombre.idnombre AND notificacion_ep.idusuario='$idusuario_ss' ";
                        $result = mysqli_query($link,$sql);
                        if ($row = mysqli_fetch_array($result)){
                        mysqli_field_seek($result,0);           
                        while ($field = mysqli_fetch_field($result)){
                        } do {

                        ?>
                            <tr>
                                <td><?php echo $numero;?></td>
                                <td><?php echo $row[1];?></td>
                                <td><?php echo $row[4];?></td>
                                <td><?php echo mb_strtoupper($row[5]);?></td>
                                <td><?php echo mb_strtoupper($row[6]);?></td>
                                <td><?php echo mb_strtoupper($row[9]." ".$row[10]." ".$row[11]);?></td>
                                <td><?php 
                                    $fecha_r = explode('-',$row[7]);
                                    $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                                <?php echo $f_registro;?></td>
                                <td>

                                <?php
                                if ($row[16] == 'CONSOLIDADO') { ?>
                                <a href="imprime_notificacion_ep.php?idnotificacion_ep=<?php echo $row[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=650,scrollbars=YES,top=50,left=200'); return false;">IMPRIME NOTIFICACIÓN</a>
                                <?php } else { ?>
                                <form name="FORM_EP" action="valida_notificacion_ep.php" method="post">
                                <input name="idnotificacion_ep" type="hidden" value="<?php echo $row[0];?>">
                                <input name="iddepartamento" type="hidden" value="<?php echo $row[12];?>">
                                <input name="idred_salud" type="hidden" value="<?php echo $row[13];?>">
                                <input name="idmunicipio" type="hidden" value="<?php echo $row[14];?>">
                                <input name="idestablecimiento_salud" type="hidden" value="<?php echo $row[15];?>">
                                <button type="submit" class="btn btn-info btn-icon-split">
                                <span class="icon text-yellow-600">
                                <i class="fas fa-fw fa-book"></i>
                                </span>
                                <span class="text">VER</span>
                                </button>
                                </form> 

                                <?php } ?>
                                                                         
                                </td>
                                <td>
                                    
                                <?php
                                if ($row[16] == 'CONSOLIDADO') { ?>
                       <!---   <form name="FORM_EP" action="valida_notificacion_ep_seguimiento.php" method="post"> 
                           <input name="idnotificacion_ep" type="hidden" value="<?php echo $row[0];?>">
                                <input name="iddepartamento" type="hidden" value="<?php echo $row[12];?>">
                                <input name="idred_salud" type="hidden" value="<?php echo $row[13];?>">
                                <input name="idmunicipio" type="hidden" value="<?php echo $row[14];?>">
                                <input name="idestablecimiento_salud" type="hidden" value="<?php echo $row[15];?>">
                                <button type="submit" class="btn btn-primary btn-icon-split">
                                <span class="icon text-yellow-600">
                                <i class="fas fa-fw fa-book"></i>
                                </span>
                                <span class="text">FICHAS EP.</span>
                                </button>
                                </form>  ---->
                                <?php } else { ?>

                                <?php } ?>

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
