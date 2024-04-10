<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idsospecha_diag_ss         = $_SESSION['idsospecha_diag_ss'];
$iddepartamento_ss          = $_SESSION['iddepartamento_ss'];
$idmunicipio_ss             = $_SESSION['idmunicipio_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];

$sql0 =" SELECT departamento.departamento, red_salud.red_salud, municipios.municipio, establecimiento_salud.codigo_establecimiento, ";
$sql0.=" establecimiento_salud.establecimiento_salud, red_salud.idred_salud FROM  departamento, red_salud, municipios, establecimiento_salud  ";
$sql0.=" WHERE establecimiento_salud.iddepartamento=departamento.iddepartamento AND establecimiento_salud.idred_salud=red_salud.idred_salud ";
$sql0.=" AND establecimiento_salud.idmunicipio=municipios.idmunicipio AND establecimiento_salud.idestablecimiento_salud='$idestablecimiento_salud_ss' ";
$result0 = mysqli_query($link,$sql0);
$row0 = mysqli_fetch_array($result0);

$sql_sos = " SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idsospecha_diag='$idsospecha_diag_ss' ";
$result_sos = mysqli_query($link,$sql_sos);
$row_sos = mysqli_fetch_array($result_sos);

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
                    <a href="seguimiento_epidemiologico.php"><h6 class="text-success" ><i class="fas fa-fw fa-arrow-left"></i>VOLVER</h6></a>
                    </div>  
                    <hr>
                    <h4 class="m-0 font-weight-bold text-primary">FICHAS EPIDEMIOLÓGICAS : <?php echo mb_strtoupper($row_sos[1]);?></h4>
                    <hr>
                    <h6 class="text-primary">DEPARTAMENTO : <?php echo mb_strtoupper($row0[1]);?></h6>
                    <h6 class="text-primary">DEPARTAMENTO : <?php echo mb_strtoupper($row0[0]);?></h6>
                    <h6 class="text-primary">RED DE SALUD : <?php echo mb_strtoupper($row0[1]);?></h6>
                    <h6 class="text-primary">MUNICIPIO : <?php echo mb_strtoupper($row0[2]);?></h6>
                    <h6 class="text-primary">ESTABLECIMIENTO : <?php echo mb_strtoupper($row0[3]);?> - <?php echo mb_strtoupper($row0[4]);?>
                    
                </h6>

                <p class="mb-4">En esta sección se puede realizar el SEGUIMIENTO de FICHAS EPIDEMIOLÓGICAS por Departamento, se podra ver el 

                    <a href="marco_ep_departamental.php?sospecha_diag_deptal=<?php echo $idsospecha_diag_ss;?>&departamento_ep=<?php echo $iddepartamento_ss;?>" target="_blank" class="Estilo12" style="font-size: 12px; font-family: Arial;" onClick="window.open(this.href, this.target, 'width=1000,height=800,scrollbars=YES,top=60,left=400'); return false;">REPORTE POR SEMANA</a>
                    y ver los 
                    <a href="piramide_sospechas_deptal.php?sospecha_diag_deptal=<?php echo $idsospecha_diag_ss;?>&departamento_ep=<?php echo $iddepartamento_ss;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=400,scrollbars=YES,top=50,left=300'); return false;">GRUPOS ETAREOS AFECTADOS</a>
                </p>
                
                    <!-- DataTales Example -->

                    <div class="card shadow mb-4">

                        <div class="card-header py-3">

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>  
                                            <th class="text-info">N°</th>                                    
                                            <th class="text-info">CÓDIGO</br>FICHA</th>
                                            <th class="text-info">FECHA REGISTRO</th>
                                            <th class="text-info">CÉDULA</th>
                                            <th class="text-info">PACIENTE</th> 
                                            <th class="text-info">CELULAR</th> 
                                            <th class="text-info">SEMANA EPID.</th>  
                                            <th class="text-info">ÚLTIMO SEGUIMIENTO</th>            
                                            <th class="text-info">ACCIÓN</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                        <?php
                        $numero=1;
                        $sql =" SELECT ficha_ep.idficha_ep, ficha_ep.codigo, nombre.ci, nombre.nombre, nombre.paterno, nombre.materno, ficha_ep.celular, ";
                        $sql.=" ficha_ep.idregistro_enfermedad, ficha_ep.idnotificacion_ep, registro_enfermedad.idsospecha_diag, registro_enfermedad.idgrupo_etareo, registro_enfermedad.idgenero, ficha_ep.fecha_registro ";
                        $sql.=" FROM ficha_ep, registro_enfermedad, notificacion_ep, nombre WHERE ficha_ep.idregistro_enfermedad=registro_enfermedad.idregistro_enfermedad ";
                        $sql.=" AND registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND ficha_ep.idnombre=nombre.idnombre ";
                        $sql.=" AND ficha_ep.direccion != '' AND notificacion_ep.idestablecimiento_salud='$idestablecimiento_salud_ss' AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_ss ' ";
                        $result = mysqli_query($link,$sql);
                        if ($row = mysqli_fetch_array($result)){
                        mysqli_field_seek($result,0);
                        while ($field = mysqli_fetch_field($result)){
                        } do {

                            $sql2 = " SELECT seguimiento_ep.idseguimiento_ep, semana_ep.semana_ep, estado_paciente.estado_paciente FROM seguimiento_ep, semana_ep, estado_paciente ";
                            $sql2.= " WHERE seguimiento_ep.idsemana_ep=semana_ep.idsemana_ep AND seguimiento_ep.idestado_paciente=estado_paciente.idestado_paciente AND";
                            $sql2.= " seguimiento_ep.idficha_ep='$row[0]' ORDER BY seguimiento_ep.idseguimiento_ep DESC LIMIT 1 ";
                            $result2 = mysqli_query($link,$sql2);
                            

                        ?>
                            <tr>
                                <td><?php echo $numero;?></td>
                                <td>
                                <a href="imprime_ficha_ep.php?idficha_ep=<?php echo $row[0];?>" target="_blank" class="Estilo12" style="font-size: 15px; font-family: Arial;" onClick="window.open(this.href, this.target, 'width=700,height=700,scrollbars=YES,top=60,left=400'); return false;">
                                <?php echo $row[1];?></a>    
                                </td>
                                <td>
                                <?php 
                                    $fecha_r = explode('-',$row[12]);
                                    $fecha_reg = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];
                                    echo $fecha_reg; ?>
                                </td>
                                <td><?php echo $row[2];?></td>
                                <td><?php echo mb_strtoupper($row[3]);?></br><?php echo mb_strtoupper($row[4]);?></br><?php echo mb_strtoupper($row[5]);?></td>
                                <td><?php echo $row[6];?></td>
                                <td>
                        <form name="ACT_SEGUIMIENTO_EP" action="valida_seguimiento_ep.php" method="post">
 
                                <input name="idnotificacion_ep" type="hidden" value="<?php echo $row[8];?>">
                                <input name="idregistro_enfermedad" type="hidden" value="<?php echo $row[7];?>">
                                <input name="idficha_ep" type="hidden" value="<?php echo $row[0];?>">

                                <input name="idred_salud" type="hidden" value="<?php echo $row0[5];?>">

                                <input name="idsospecha_diag" type="hidden" value="<?php echo $row[9];?>">
                                <input name="idgrupo_etareo" type="hidden" value="<?php echo $row[10];?>">
                                <input name="idgenero" type="hidden" value="<?php echo $row[11];?>">
                                <?php             
                                if($row2 = mysqli_fetch_array($result2))
                                {echo "Semana ".$row2[1];}
                                ?>
                                </td>
                                <td>
                                <?php             
                                echo $row2[2];
                                ?>
                                </td>
                                <td> 
                                    <button type="submit" class="btn btn-info btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <span class="text">ACTUALIZAR</span>    
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
                        "info": "Mostrando Fichas de _START_ al _END_ de un total de  _TOTAL_ Fichas",
                        "infoEmpty": "No existen Fichas",
                        "infoFiltered": "(filtrado de un total de _MAX_ Fichas)",
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
