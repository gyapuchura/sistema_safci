<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion    = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$sql_es = " SELECT iddato_laboral, idestablecimiento_salud FROM dato_laboral WHERE idusuario='$idusuario_ss' ORDER BY iddato_laboral DESC LIMIT 1  ";
$result_es = mysqli_query($link,$sql_es);
$row_es = mysqli_fetch_array($result_es);
$idestablecimiento_salud = $row_es[1];

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
                    <h1 class="h3 mb-2 text-gray-800">ATENCIONES INTEGRALES - PSAFCI - NIVEL NACIONAL</h1>
                    <p class="mb-4">En esta sección se puede encontrar el registro de ATENCIONES PSAFCI en el SISTEMA INTEGRADO MEDI-SAFCI a Nivel Nacional.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">REGISTRO DE ATENCIONES INTEGRALES - PSAFCI</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>  
                                            <th>N°</th>                                     
                                            <th>CÓDIGO PSAFCI</th>
                                            <th>DEPARTAMENTO</th>
                                            <th>MUNICIPIO</th>
                                            <th>ESTABLECIMIENTO</th>
                                            <th>PERSONA ATENDIDA</th>
                                            <th>EDAD</th>  
                                            <th>NUEVA/REPETIDA</th>  
                                            <th>CONSULTA/VISITA FAMILIAR</th>   
                                            <th>TIPO DE ATENCION SAFCI</th>                                            
                                            <th>FECHA Y HORA</th>
                                            <th>CARPETIZADO/NO CARPETIZADO</th>
                                            <th>MÉDICO OPERATIVO</th>
                                            <th>ACCIÓN</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                        <?php
                        $numero=1;
                        $sql =" SELECT atencion_psafci.idatencion_psafci, atencion_psafci.codigo, nombre.ci, nombre.nombre, nombre.paterno, nombre.materno, nombre.fecha_nac, nombre.idnombre,   ";
                        $sql.=" repeticion.repeticion, tipo_consulta.tipo_consulta, tipo_atencion.tipo_atencion,atencion_psafci.fecha_registro, atencion_psafci.hora_registro, atencion_psafci.idusuario,  ";
                        $sql.=" departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud  ";
                        $sql.=" FROM atencion_psafci, nombre, repeticion, tipo_consulta, tipo_atencion, departamento, municipios, establecimiento_salud WHERE atencion_psafci.idnombre=nombre.idnombre ";
                        $sql.=" AND atencion_psafci.idrepeticion=repeticion.idrepeticion AND atencion_psafci.idtipo_consulta=tipo_consulta.idtipo_consulta AND atencion_psafci.iddepartamento=departamento.iddepartamento ";
                        $sql.=" AND atencion_psafci.idmunicipio=municipios.idmunicipio AND atencion_psafci.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
                        $sql.=" AND atencion_psafci.idtipo_atencion=tipo_atencion.idtipo_atencion ORDER BY atencion_psafci.idatencion_psafci DESC ";
                        $result = mysqli_query($link,$sql);
                        if ($row = mysqli_fetch_array($result)){
                        mysqli_field_seek($result,0);
                        while ($field = mysqli_fetch_field($result)){
                        } do {
                        ?>
                                        <tr>
                                            <td><?php echo $numero;?></td>
                                            <td><?php echo $row[1];?></td>
                                            <td><?php echo $row[14];?></td>
                                            <td><?php echo $row[15];?></td>
                                            <td><?php echo $row[16];?></td>
                                            <td><?php echo mb_strtoupper($row[3]." ".$row[4]." ".$row[5]);?></td>
                                            <td><?php 
                                                    $fecha_nacimiento = $row[6];
                                                    $dia=date("d");
                                                    $mes=date("m");
                                                    $ano=date("Y");    
                                                    $dianaz=date("d",strtotime($fecha_nacimiento));
                                                    $mesnaz=date("m",strtotime($fecha_nacimiento));
                                                    $anonaz=date("Y",strtotime($fecha_nacimiento));         
                                                    if (($mesnaz == $mes) && ($dianaz > $dia)) {
                                                    $ano=($ano-1); }      
                                                    if ($mesnaz > $mes) {
                                                    $ano=($ano-1);}       
                                                    $edad=($ano-$anonaz);  
                                                    echo $edad ;?></td>
                                            <td><?php echo $row[8];?></td>
                                            <td><?php echo $row[9];?></td>
                                            <td><?php echo $row[10];?></td>
                                            <td>
                                            <?php 
                                                $fecha_r = explode('-',$row[11]);
                                                $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                                            <?php echo $f_registro;?></br><?php echo $row[12];?>     
                                            </td>  
                                            <td><?php 
                                            $sql1 =" SELECT idintegrante_cf, idcarpeta_familiar FROM integrante_cf WHERE idnombre='$row[7]' AND estado='CONSOLIDADO'";
                                            $result1 = mysqli_query($link,$sql1);
                                            if ($row1 = mysqli_fetch_array($result1)){ ?>
                                                
                                                <a href="../carpetas_familiares/imprime_carpeta_familiar.php?idcarpeta_familiar=<?php echo $row1[1];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1400,height=800,top=50, left=200, scrollbars=YES'); return false;">
                                                <h6 class="text-info">VER CARPETA FAMILIAR</h6></a> 

                                            <?php } else {
                                                echo "<h6 class='text-warning'>SIN CARPETA FAMILIAR</h6>";
                                            }
                                            ?></td> 
                                            <td><?php 
                                            $sql_n =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row[13]' ";
                                            $result_n = mysqli_query($link,$sql_n);
                                            $row_n = mysqli_fetch_array($result_n);
                                            echo mb_strtoupper($row_n[0]." ".$row_n[1]." ".$row_n[2]);
                                            ?></td>                                       
                                        <td>
                                        <form name="ATENCION-PSAFCI" action="valida_atencion_psafci_nac.php" method="post">
                                            <input name="idatencion_psafci" type="hidden" value="<?php echo $row[0];?>">
                                            <input name="idestablecimiento_salud" type="hidden" value="<?php echo $idestablecimiento_salud;?>">
                                            <input name="idnombre_integrante" type="hidden" value="<?php echo $row[7];?>">
                                            <input name="edad" type="hidden" value="<?php echo $edad;?>">
                                            <button type="submit" class="btn btn-info btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-hospital"></i>
                                            </span>
                                            <span class="text">VER ATENCIÓN INTEGRAL</span>    
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
