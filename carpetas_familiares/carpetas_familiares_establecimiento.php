<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$iddepartamento_ss = $_SESSION['iddepartamento_ss'];
$idmunicipio_ss    = $_SESSION['idmunicipio_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];

$sql0 =" SELECT departamento.departamento, red_salud.red_salud, municipios.municipio, establecimiento_salud.codigo_establecimiento, ";
$sql0.=" establecimiento_salud.establecimiento_salud, red_salud.idred_salud FROM  departamento, red_salud, municipios, establecimiento_salud  ";
$sql0.=" WHERE establecimiento_salud.iddepartamento=departamento.iddepartamento AND establecimiento_salud.idred_salud=red_salud.idred_salud ";
$sql0.=" AND establecimiento_salud.idmunicipio=municipios.idmunicipio AND establecimiento_salud.idestablecimiento_salud='$idestablecimiento_salud_ss' ";
$result0 = mysqli_query($link,$sql0);
$row0 = mysqli_fetch_array($result0);

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
                    <a href="carpetas_familiares_nal.php"><h6 class="text-success" ><i class="fas fa-fw fa-arrow-left"></i>VOLVER</h6></a>
                    </div>  
                    <hr>
                    <h4 class="m-0 font-weight-bold text-primary">CARPETAS FAMILIARES: </h4>
                    <hr>
                    <h6 class="text-primary">DEPARTAMENTO : <?php echo mb_strtoupper($row0[1]);?></h6>
                    <h6 class="text-primary">DEPARTAMENTO : <?php echo mb_strtoupper($row0[0]);?></h6>
                    <h6 class="text-primary">RED DE SALUD : <?php echo mb_strtoupper($row0[1]);?></h6>
                    <h6 class="text-primary">MUNICIPIO : <?php echo mb_strtoupper($row0[2]);?></h6>
                    <hr>
                    
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">CARPETAS DEL ESTABLECIMIENTO : <?php echo mb_strtoupper($row0[3]);?> - <?php echo mb_strtoupper($row0[4]);?></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>  
                                            <th>N°</th>                                     
                                            <th>CÓDIGO CARPETA</th>
                                            <th>FAMILIA</th>
                                            <th>ÁREA DE INFLUENCIA</th>
                                            <th>PERSONAL REGISTRADOR</th>
                                            <th>FECHA DE REGISTRO</th>
                                            <th>ACCIÓN</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                        <?php
                        $numero=1;
                        $sql =" SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.codigo, carpeta_familiar.familia, departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud,";
                        $sql.=" tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, carpeta_familiar.fecha_registro, carpeta_familiar.hora_registro, carpeta_familiar.estado, carpeta_familiar.idusuario ";
                        $sql.=" FROM carpeta_familiar, ubicacion_cf, departamento, municipios, establecimiento_salud, area_influencia, tipo_area_influencia WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                        $sql.=" AND ubicacion_cf.iddepartamento=departamento.iddepartamento AND ubicacion_cf.idmunicipio=municipios.idmunicipio ";
                        $sql.=" AND ubicacion_cf.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia ";
                        $sql.=" AND ubicacion_cf.idarea_influencia=area_influencia.idarea_influencia AND ubicacion_cf.ubicacion_actual='SI' AND ubicacion_cf.idestablecimiento_salud ='$idestablecimiento_salud_ss' ORDER BY carpeta_familiar.idcarpeta_familiar ";
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
                                            <td><?php echo $row[6];?></br><?php echo $row[7];?></td>
                                            <td><?php 
                                                $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                                                $sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row[11]' ";
                                                $result_r = mysqli_query($link,$sql_r);
                                                $row_r = mysqli_fetch_array($result_r);                    
                                            echo mb_strtoupper($row_r[0]." ".$row_r[1]." ".$row_r[2]);?></td>
                                            <td>
                                            <?php 
                                                $fecha_r = explode('-',$row[8]);
                                                $f_apertura = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                                            <?php echo $f_apertura;?></br><?php echo $row[9];?>   
                                            </td>
                                            <td>
                                                <?php if ($row[10] == 'CONSOLIDADO') { ?>
                                                   
                                                   <form name="FORM_P" action="valida_carpeta_familiar_nal.php" method="post">
                                                    <input name="idcarpeta_familiar" type="hidden" value="<?php echo $row[0];?>">
                                                    <button type="submit" class="btn btn-info btn-user btn-block">CONSOLIDADO</button></form>

                                               <?php } else { 
                                                
                                                if ($row[11] == $idusuario_ss) { ?>

                                                <h6 class="text-info">REVISAR EN BANDEJA DE CARPETAS FAMILIARES DEL OPERATIVO</h6>

                                               <?php } else {  ?>

                                                <h6 class="text-primary">EN PROCESO DE LLENADO</h6>
                                                
                                                 <?php }} ?>                                                                      
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
