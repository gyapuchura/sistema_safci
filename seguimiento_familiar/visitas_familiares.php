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
                    <h1 class="h3 mb-2 text-gray-800">VISITAS FAMILIARES - SAFCI</h1>
                    <p class="mb-4">En esta sección se puede encontrar el registro de Carpetas Familiares con VISITA FAMILIAR PLANIFICADA.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">CARPETAS FAMILIARES - SAFCI</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>  
                                            <th>N°</th>                                     
                                            <th>CÓDIGO CARPETA</th>
                                            <th>VER SEGUIMIENTO</th>
                                            <th>FAMILIA</th>   
                                            <th>RIESGO FAMILIAR</th>                                           
                                            <th>ÁREA DE INFLUENCIA</th>
                                            <th>NÚMERO DE INTEGRANTES</th>
                                            <th>UBICACIÓN GEOGRÁFICA</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                   <tbody>
                        <?php
                        $numero=1;
                        $sql =" SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.codigo, carpeta_familiar.familia, departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud, ";
                        $sql.=" tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, carpeta_familiar.fecha_registro, carpeta_familiar.hora_registro, carpeta_familiar.estado, carpeta_familiar.idusuario ";
                        $sql.=" FROM seguimiento_cf, carpeta_familiar, departamento, municipios, establecimiento_salud, area_influencia, tipo_area_influencia WHERE seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                        $sql.=" AND carpeta_familiar.iddepartamento=departamento.iddepartamento AND carpeta_familiar.estado='CONSOLIDADO' ";
                        $sql.=" AND carpeta_familiar.idmunicipio=municipios.idmunicipio AND carpeta_familiar.idusuario='$idusuario_ss' AND carpeta_familiar.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
                        $sql.=" AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia GROUP BY carpeta_familiar.idcarpeta_familiar ";
                        $result = mysqli_query($link,$sql);
                        if ($row = mysqli_fetch_array($result)){
                        mysqli_field_seek($result,0);
                        while ($field = mysqli_fetch_field($result)){
                        } do {
                        ?>
                                        <tr>
                                            <td><?php echo $numero;?></td>
                                            <td>
                                            <a href="../carpetas_familiares/imprime_carpeta_familiar.php?idcarpeta_familiar=<?php echo $row[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1280,height=800,top=50, left=200, scrollbars=YES'); return false;">
                                            <h6 class="text-primary"><?php echo $row[1];?></h6></a>     
                                            </td>
                                            <td>
                                            <a href="imprime_seguimiento_familiar.php?idcarpeta_familiar=<?php echo $row[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1400,height=800,top=50, left=200, scrollbars=YES'); return false;">
                                            <h6 class="text-info">ESTADO DE SEGUIMIENTO</h6></a>     
                                            </td>
                                            <td><?php echo $row[2];?></td>    
                                            <td><?php                                             
                                            $sql_r =" SELECT determinante_salud, salud_integrantes, funcionalidad_familiar, evaluacion_familiar FROM evaluacion_familiar_cf WHERE idcarpeta_familiar='$row[0]' ";
                                            $result_r = mysqli_query($link,$sql_r);
                                            $row_r = mysqli_fetch_array($result_r);

                                            if ($row_r[3] == 'FAMILIA CON RIESGO BAJO') {
                                                echo "<h6 class='text-success'> ".$row_r[3]."</h6>";
                                                echo "<h6 class='text-success'>- ".$row_r[0]."</h6>";
                                                echo "<h6 class='text-success'>- ".$row_r[1]."</h6>";
                                                echo "<h6 class='text-success'>- ".$row_r[2]."</h6>";
                                            } else {
                                                if ($row_r[3] == 'FAMILIA CON RIESGO MEDIANO') {
                                                    echo "<h6 class='text-warning'> ".$row_r[3]."</h6>";
                                                    echo "<h6 class='text-warning'>- ".$row_r[0]."</h6>";
                                                    echo "<h6 class='text-warning'>- ".$row_r[1]."</h6>";
                                                    echo "<h6 class='text-warning'>- ".$row_r[2]."</h6>";
                                                } else {
                                                    if ($row_r[3] == 'FAMILIA CON RIESGO ALTO') {
                                                        echo "<h6 class='text-danger'> ".$row_r[3]."</h6>";
                                                        echo "<h6 class='text-danger'>- ".$row_r[0]."</h6>";
                                                        echo "<h6 class='text-danger'>- ".$row_r[1]."</h6>";
                                                        echo "<h6 class='text-danger'>- ".$row_r[2]."</h6>";
                                                    } else { } } } ?>
                                            </td>                                         
                                            <td><?php echo $row[6];?></br><?php echo $row[7];?></td>
                                            <td>
                                            <?php 
                                            $sql_i = " SELECT count(idintegrante_cf) FROM integrante_cf WHERE idcarpeta_familiar='$row[0]' ";
                                            $result_i = mysqli_query($link,$sql_i);
                                            $row_i = mysqli_fetch_array($result_i); 
                                            echo $row_i[0];
                                            ?>
                                              
                                            </td>
                                            <td>                                                     
                                                    <a href="../carpetas_familiares/imprime_mapa_familiar.php?idcarpeta_familiar=<?php echo $row[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=800,height=700,top=50, left=600, scrollbars=YES'); return false;">
                                                    <h6 class="text-info">UBICACIÓN FAMILIAR</h6></a>                                                                                                              
                                        </td>
                                        <td>                                                                                    
                                                   <form name="FORM_P" action="valida_visita_familiar.php" method="post">
                                                   <input name="idcarpeta_familiar" type="hidden" value="<?php echo $row[0];?>">
                                                   <button type="submit" class="btn btn-info btn-user btn-block">ACTUALIZAR</br>VISITAS</button></form>     
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
                           
                <hr>
                <div class="text-center">
                <div class="form-group row"> 
                    <div class="col-sm-4">
                        <a class="btn btn-info btn-icon-split" href="calendario_visitas_familiares.php?idusuario_op=<?php echo $idusuario_op;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1400,height=900,scrollbars=YES,top=50,left=200'); return false;">
                        <span class="icon text-white-50">
                            <i class="fas fa-book"></i>
                        </span>
                        <span class="text">CALENDARIO DE VISITAS FAMILIARES</span></a>
                    </div>
                    <div class="col-sm-4">
                        <a class="btn btn-primary btn-icon-split" href="visitas_safci_diarias_op.php?idusuario_op=<?php echo $idusuario_ss;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=900,scrollbars=YES,top=50,left=200'); return false;">
                        <span class="icon text-white-50">
                            <i class="far fa-chart-bar"></i>
                        </span>
                        <span class="text">MOSTRAR REPORTE DIARIO</span></a>
                    </div>
                    <div class="col-sm-4">
                        <a class="btn btn-warning btn-icon-split" href="calendario_reprogramacion_visita.php?idusuario_op=<?php echo $idusuario_ss;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1100,height=800,scrollbars=YES,top=50,left=200'); return false;">
                        <span class="icon text-white-50">
                            <i class="fas fa-book"></i>
                        </span>
                        <span class="text">REPROGRAMACIÓN DE VISITAS</span></a>
                    </div>
                </div>   
                <hr>
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