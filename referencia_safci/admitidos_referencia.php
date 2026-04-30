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
                    <h1 class="h3 mb-2 text-gray-800">REFERENCIAS ADMITIDAS</h1>
                    <p class="mb-4">En esta sección se puede encontrar la bandeja de REFERENCIAS ADMITIDAS en el Establecimiento de Salud.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">REFERENCIAS ADMITIDAS EN EL ESTABLECIMIENTO</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>  
                                            <th>N°</th>                                     
                                            <th>CÓDIGO REFERENCIA</th>
                                            <th>PERSONA REFERIDA</th>
                                            <th>EDAD</th> 
                                            <th>CEDULA DE IDENTIDAD</th>   
                                            <th>MOTIVO REFERENCIA</th>  
                                            <th>ESPECIALIDAD MÉDICA</th>   
                                            <th>ESTABLECIMIENTO ORIGEN</th>                                            
                                            <th>NIVEL/TIPO</th>
                                            <th>FECHA REFERENCIA/HORA</th>
                                            <th>MÉDICO QUE REFIERE</th>
                                            <th>ACCIÓN</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                                <?php
                                $numero=1;
                                $sql =" SELECT deriva_referencia_hc.idderiva_referencia_hc, deriva_referencia_hc.idreferencia_hc, referencia_hc.codigo, nombre.nombre, nombre.paterno, nombre.materno, nombre.fecha_nac, nombre.ci,  ";
                                $sql.=" motivo_referencia.motivo_referencia, especialidad_medica.especialidad_medica, establecimiento_salud.establecimiento_salud, tipo_establecimiento.tipo_establecimiento, ";
                                $sql.=" nivel_establecimiento.nivel_establecimiento, deriva_referencia_hc.fecha_deriva, deriva_referencia_hc.hora_deriva, deriva_referencia_hc.idusuario_o, referencia_hc.idatencion_psafci, referencia_hc.idnombre ";
                                $sql.=" FROM deriva_referencia_hc, referencia_hc, nombre, motivo_referencia, especialidad_medica, establecimiento_salud, tipo_establecimiento, nivel_establecimiento ";
                                $sql.=" WHERE deriva_referencia_hc.idreferencia_hc=referencia_hc.idreferencia_hc AND referencia_hc.idnombre=nombre.idnombre AND referencia_hc.idmotivo_referencia=motivo_referencia.idmotivo_referencia ";
                                $sql.=" AND referencia_hc.idespecialidad_medica=especialidad_medica.idespecialidad_medica AND referencia_hc.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
                                $sql.=" AND establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento ";
                                $sql.=" AND deriva_referencia_hc.idestablecimiento_salud_r='$idestablecimiento_salud' AND deriva_referencia_hc.referido='SI' AND deriva_referencia_hc.admitido='SI' ";
                                $result = mysqli_query($link,$sql);
                                if ($row = mysqli_fetch_array($result)){
                                mysqli_field_seek($result,0);
                                while ($field = mysqli_fetch_field($result)){
                                } do {

                                ?>
                                        <tr>
                                            <td><?php echo $numero;?></td>
                                            <td>
                                            <a href="imprime_formulario_d7.php?idreferencia_hc=<?php echo $row[1];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=950,height=900,top=50, left=500, scrollbars=YES'); return false;">
                                            <?php echo $row[2];?></a>      
                                            </td>
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
                                            <td><?php echo $row[7];?></td>
                                            <td><?php echo $row[8];?></td>
                                            <td><?php echo $row[9];?></td>
                                            <td><?php echo $row[10];?></td>
                                            <td>
                                                <?php echo $row[12];?> / <?php echo $row[11];?>
                                            </td>  
                                            <td>
                                            <?php 
                                                $fecha_r = explode('-',$row[13]);
                                                $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                                            <?php echo $f_registro;?></br><?php echo $row[14];?> 
                                            </td> 
                                            <td>
                                                <?php 
                                                $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                                                $sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row[15]' ";
                                                $result_r = mysqli_query($link,$sql_r);
                                                $row_r = mysqli_fetch_array($result_r);                    
                                                echo mb_strtoupper($row_r[0]." ".$row_r[1]." ".$row_r[2]);?>
                                            </td>                                       
                                        <td>
                                        <form name="ATENCION-PSAFCI" action="valida_referencia_admitida.php" method="post">
                                            <input name="idderiva_referencia_hc" type="hidden" value="<?php echo $row[0];?>">
                                            <input name="idreferencia_hc" type="hidden" value="<?php echo $row[1];?>">
                                            <input name="idatencion_psafci" type="hidden" value="<?php echo $row[16];?>">
                                            <input name="idestablecimiento_salud" type="hidden" value="<?php echo $idestablecimiento_salud;?>">
                                            <input name="idnombre_integrante" type="hidden" value="<?php echo $row[17];?>">
                                            <input name="edad" type="hidden" value="<?php echo $edad;?>">
                                            <button type="submit" class="btn btn-info btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-hospital"></i>
                                            </span>
                                            <span class="text">VER REFERENCIA</span>    
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
