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
                    <h1 class="h3 mb-2 text-gray-800">PERSONAS CARPETIZADAS - SAFCI</h1>
                    <p class="mb-4">En esta sección se puede encontrar el registro de PERSONAS CARPETIZADAS en el SISTEMA INTEGRADO MEDI-SAFCI.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">LISTADO GENERAL DE PERSONAS CON CARPETA FAMILIAR - SAFCI</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>  
                                            <th>N°</th>                                     
                                            <th>CÉDULA DE IDENTIDAD</th>
                                            <th>NOMBRE</th>
                                            <th>PRIMER APELLIDO</th>  
                                            <th>SEGUNDO APELLIDO</th>  
                                            <th>EDAD</th>   
                                            <th>GRUPO DE SALUD</th>                                            
                                            <th>CARPETA FAMILIAR</th>
                                            <th>ACCIÓN</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                        <?php
                        $numero=1;
                        $sql =" SELECT integrante_cf.idintegrante_cf, nombre.ci, nombre.nombre, nombre.paterno, nombre.materno, nombre.fecha_nac, carpeta_familiar.codigo, carpeta_familiar.idcarpeta_familiar, ";
                        $sql.=" nombre.idnombre FROM carpeta_familiar, integrante_cf, nombre WHERE integrante_cf.idnombre=nombre.idnombre  ";
                        $sql.=" AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
                        $sql.=" AND carpeta_familiar.idestablecimiento_salud ='$idestablecimiento_salud' ";
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
                                            <td><?php echo $row[3];?></td>
                                            <td><?php echo $row[4];?></td>
                                            <td><?php 

                                                    $fecha_nacimiento = $row[5];
                                                    $dia = date("d");
                                                    $mes = date("m");
                                                    $ano = date("Y");    
                                                    $dianaz = date("d",strtotime($fecha_nacimiento));
                                                    $mesnaz = date("m",strtotime($fecha_nacimiento));
                                                    $anonaz = date("Y",strtotime($fecha_nacimiento));         
                                                    if (($mesnaz == $mes) && ($dianaz > $dia)) {
                                                    $ano=($ano-1); }      
                                                    if ($mesnaz > $mes) {
                                                    $ano=($ano-1);}       
                                                    $edad=($ano-$anonaz);  
                                                    echo $edad ;
                                                    
                                                    ?></td>
                                                    <td><?php 
                                                                
                                                        $sql1 =" SELECT grupo_cf.idgrupo_cf, grupo_cf.grupo_cf FROM integrante_ap_sano, grupo_cf WHERE integrante_ap_sano.idgrupo_cf=grupo_cf.idgrupo_cf ";
                                                        $sql1.="  AND integrante_ap_sano.idintegrante_cf='$row[0]' GROUP BY grupo_cf.idgrupo_cf ";
                                                        $result1 = mysqli_query($link,$sql1);
                                                        if ($row1 = mysqli_fetch_array($result1)){
                                                        mysqli_field_seek($result1,0);
                                                        while ($field1 = mysqli_fetch_field($result1)){
                                                        } do { 
                                                        ?>
                                                           <?php echo "<h6 class='text-primary'>- ".$row1[1]."</h6>";?>
                                                        <?php
                                                        
                                                        }
                                                        while ($row1 = mysqli_fetch_array($result1));
                                                        } else {
                                                        }
                                                        ?>
                                                        <?php
                                                        $sql2 =" SELECT grupo_cf.idgrupo_cf, grupo_cf.grupo_cf FROM integrante_factor_riesgo, grupo_cf WHERE integrante_factor_riesgo.idgrupo_cf=grupo_cf.idgrupo_cf ";
                                                        $sql2.=" AND integrante_factor_riesgo.idintegrante_cf='$row[0]' GROUP BY grupo_cf.idgrupo_cf ";
                                                        $result2 = mysqli_query($link,$sql2);
                                                        if ($row2 = mysqli_fetch_array($result2)){
                                                        mysqli_field_seek($result2,0);
                                                        while ($field2 = mysqli_fetch_field($result2)){
                                                        } do { 
                                                        ?>
                                                           <?php echo "<h6 class='text-warning'>- ".$row2[1]."</h6>";?>
                                                        <?php
                                                        }
                                                        while ($row2 = mysqli_fetch_array($result2));
                                                        } else {
                                                        }
                                                        ?>
                                                        <?php
                                                        $sql3 =" SELECT grupo_cf.idgrupo_cf, grupo_cf.grupo_cf FROM integrante_morbilidad, grupo_cf WHERE integrante_morbilidad.idgrupo_cf=grupo_cf.idgrupo_cf  ";
                                                        $sql3.="  AND integrante_morbilidad.idintegrante_cf='$row[0]' GROUP BY grupo_cf.idgrupo_cf ";
                                                        $result3 = mysqli_query($link,$sql3);
                                                        if ($row3 = mysqli_fetch_array($result3)){
                                                        mysqli_field_seek($result3,0);
                                                        while ($field3 = mysqli_fetch_field($result3)){
                                                        } do { 
                                                        ?>
                                                           <?php echo "<h6 class='text-danger'>- ".$row3[1]."</h6>";?>
                                                        <?php
                                                        }
                                                        while ($row3 = mysqli_fetch_array($result3));
                                                        } else {
                                                        }
                                                        ?>
                                                        <?php
                                                        $sqld =" SELECT grupo_cf.idgrupo_cf, grupo_cf.grupo_cf FROM integrante_discapacidad, grupo_cf WHERE integrante_discapacidad.idgrupo_cf=grupo_cf.idgrupo_cf  ";
                                                        $sqld.=" AND integrante_discapacidad.idintegrante_cf='$row[0]' GROUP BY grupo_cf.idgrupo_cf ";
                                                        $resultd = mysqli_query($link,$sqld);
                                                        if ($rowd = mysqli_fetch_array($resultd)){
                                                        mysqli_field_seek($resultd,0);
                                                        while ($fieldd = mysqli_fetch_field($resultd)){
                                                        } do { 
                                                        ?>
                                                           <?php echo "<h6 class='text-info'>- ".$rowd[1]."</h6>";?>
                                                        <?php
                                                        }
                                                        while ($rowd = mysqli_fetch_array($resultd));
                                                        } else {
                                                        }
                                                        
                                            ?></td>
                                            <td>
                                            <a href="../carpetas_familiares/imprime_carpeta_familiar.php?idcarpeta_familiar=<?php echo $row[7];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1400,height=800,top=50, left=200, scrollbars=YES'); return false;">
                                            <h6 class="text-info"><?php echo $row[6];?></h6></a> 
                                            </td>                                           
                                        <td>
                                    <form name="ATENCION-SAFCI" action="valida_persona_cf.php" method="post">
                                    <input name="idintegrante_cf" type="hidden" value="<?php echo $row[0];?>">
                                    <input name="idcarpeta_familiar" type="hidden" value="<?php echo $row[7];?>">
                                    <input name="idestablecimiento_salud" type="hidden" value="<?php echo $idestablecimiento_salud;?>">
                                    <input name="idnombre_integrante" type="hidden" value="<?php echo $row[8];?>">
                                    <input name="edad" type="hidden" value="<?php echo $edad;?>">
                                        <button type="submit" class="btn btn-info btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-hospital"></i>
                                        </span>
                                        <span class="text">HISTORIA CLÍNICA SAFCI</span>    
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
