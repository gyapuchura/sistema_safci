<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$sql_es = " SELECT iddato_laboral, idestablecimiento_salud, iddepartamento, idred_salud FROM dato_laboral WHERE idusuario='$idusuario_ss' ORDER BY iddato_laboral DESC LIMIT 1  ";
$result_es = mysqli_query($link,$sql_es);
$row_es = mysqli_fetch_array($result_es);

$idestablecimiento_salud_enc = $row_es[1];
$iddepartamento_enc          = $row_es[2];
$idred_salud_enc             = $row_es[3];

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

                    <h1 class="h3 mb-2 text-gray-800">ENCUESTA DE PREVENCIÓN DE ENFERMEDADES</h1>
                    <p class="mb-4">En esta seccion se puede encontrar los registros de ENCUESTA DE PREVENCIÓN DE ENFERMEDADES a NIVEL NACIOANL.</p>

                <form name="HISTORIA_CLINICA" action="valida_cedula_enc.php" method="post">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">BUSCAR PERSONA PARA ENCUESTA POR CÉDULA DE IDENTIDAD</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-3">
                            <h6 class="text-primary">NÚMERO DE CEDULA:</h6>
                            </div>
                            <div class="col-sm-3">
                           <input type="number" name="ci" id="ci" class="form-control">
                            </div>
                            <div class="col-sm-3">
                            <button type="submit" class="btn btn-primary">BUSCAR POR CÉDULA</button>
                            </div>
                            <div class="col-sm-3">
                            </div>
                        </div>
                    </div>
                </div>
                </form>

                
                <!-- /.container-fluid -->

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">ENCUESTAS DEL ESTABLECIMIENTO DE SALUD</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>  
                                            <th>N°</th>                                     
                                            <th>CODIGO ENCUESTA</th>
                                            <th>CI - HISTORIA CLÍNICA</th>
                                            <th>PERSONA ENCUESTADA</th>
                                            <th>TEMA ENCUESTA</th>
                                            <th>CLASIFICACIÓN</th>
                                            <th>MÉDICO ENCUESTADOR</th>
                                            <th>FECHA/HORA</th>
                                            <th>ACCIÓN</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                        <?php
                        $numero=1;
                        $sql =" SELECT encuesta_psafci.idencuesta_psafci, encuesta_psafci.codigo, nombre.ci, nombre.nombre, nombre.paterno, nombre.materno, ";
                        $sql.=" tema_encuesta.tema_encuesta, clasificacion_riesgo_cancer.clasificacion_riesgo_cancer, encuesta_psafci.idatencion_psafci, ";
                        $sql.=" encuesta_psafci.fecha_registro, encuesta_psafci.hora_registro, encuesta_psafci.idusuario, encuesta_psafci.idestablecimiento_salud, ";
                        $sql.=" encuesta_psafci.idnombre, nombre.fecha_nac FROM encuesta_psafci, nombre, tema_encuesta, clasificacion_riesgo_cancer  ";
                        $sql.=" WHERE encuesta_psafci.idnombre=nombre.idnombre AND encuesta_psafci.idtema_encuesta=tema_encuesta.idtema_encuesta  ";
                        $sql.=" AND encuesta_psafci.idclasificacion_riesgo_cancer=clasificacion_riesgo_cancer.idclasificacion_riesgo_cancer AND encuesta_psafci.idusuario='$idusuario_ss' ORDER BY encuesta_psafci.idencuesta_psafci DESC ";
                        $result = mysqli_query($link,$sql);
                        if ($row = mysqli_fetch_array($result)){
                        mysqli_field_seek($result,0);
                        while ($field = mysqli_fetch_field($result)){
                        } do {

                            $fecha_nacimiento = $row[14];
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

                            $edad = ($ano-$anonaz);

                        ?>
                            <tr>
                                <td><?php echo $numero;?></td>
                                <td>
                                    <a href="../produccion_servicios/imprime_atencion_psafci.php?idatencion_psafci=<?php echo $row[8];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=800,height=900,top=50, left=200, scrollbars=YES'); return false;">
                                    <?php echo $row[1];?></a>     
                                </td>
                                <td><?php echo $row[2];?></td>
                                <td><?php echo mb_strtoupper($row[3].' '.$row[4].' '.$row[5]);?></td>
                                <td><?php echo $row[6];?></td>
                                <td><?php echo $row[7];?></td>
                                <td>
                                    <?php 
                                    $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                                    $sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row[11]' ";
                                    $result_r = mysqli_query($link,$sql_r);
                                    $row_r = mysqli_fetch_array($result_r);                    
                                    echo mb_strtoupper($row_r[0]." ".$row_r[1]." ".$row_r[2]);
                                    ?>
                                </td>
                                <td>         
                                    <?php 
                                        $fecha_r = explode('-',$row[9]);
                                        $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                                    <?php echo $f_registro;?></br><?php echo $row[10];?>  
                                </td>
                                <td>
                                        <form name="ATENCION-PSAFCI" action="valida_encuesta_ps.php" method="post">
                                            <input name="idencuesta_psafci" type="hidden" value="<?php echo $row[0];?>">
                                            <input name="idatencion_psafci" type="hidden" value="<?php echo $row[8];?>">
                                            <input name="idestablecimiento_salud" type="hidden" value="<?php echo $row[12];?>">
                                            <input name="idnombre_integrante" type="hidden" value="<?php echo $row[13];?>">
                                            <input name="edad" type="hidden" value="<?php echo $edad;?>">
                                            <button type="submit" class="btn btn-info btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-hospital"></i>
                                            </span>
                                            <span class="text">VER ENCUESTA MÉDICA</span>    
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
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Ministerio de Salud y Deportes &copy; MSYD <?php echo $gestion;?></span>
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

    <!-- Page level plugins -->
    <script language="javascript">
        $(document).ready(function(){
        $("#iddepartamento").change(function () {
                    $("#iddepartamento option:selected").each(function () {
                        departamento=$(this).val();
                    $.post("municipio_af.php", {departamento:departamento}, function(data){
                    $("#idmunicipio_salud").html(data);
                    });
                });
        })
        });
    </script> 

    <script language="javascript">
        $(document).ready(function(){
        $("#idmunicipio_salud").change(function () {
                    $("#idmunicipio_salud option:selected").each(function () {
                        municipio_af=$(this).val();
                    $.post("establecimientos_af.php", {municipio_af:municipio_af}, function(data){
                    $("#idestablecimiento_salud").html(data);
                    });
                });
        })
        });
    </script>

    <script language="javascript">
        $(document).ready(function(){
        $("#idestablecimiento_salud").change(function () {
                    $("#idestablecimiento_salud option:selected").each(function () {
                        establecimiento_salud=$(this).val();
                    $.post("historias_clinicas_est.php", {establecimiento_salud:establecimiento_salud}, function(data){
                    $("#historias_clinicas_est").html(data);
                    });
                });
        })
        });
    </script>

    <script language="javascript">
            $(document).ready(function(){
            $("#iddepartamento_mun").change(function () {
                        $("#iddepartamento_mun option:selected").each(function () {
                            departamento=$(this).val();
                        $.post("municipio_af.php", {departamento:departamento}, function(data){
                        $("#idmunicipio_salud_mun").html(data);
                        });
                    });
            })
            });
    </script> 

    <script language="javascript">
        $(document).ready(function(){
        $("#idmunicipio_salud_mun").change(function () {
                    $("#idmunicipio_salud_mun option:selected").each(function () {
                        municipio=$(this).val();
                    $.post("historias_clinicas_mun.php", {municipio:municipio}, function(data){
                    $("#historias_clinicas_mun").html(data);
                    });
                });
        })
        });
    </script>


    <script language="javascript">
        $(document).ready(function(){
        $("#iddepartamento_af").change(function () {
                    $("#iddepartamento_af option:selected").each(function () {
                        departamento=$(this).val();
                    $.post("municipio_af.php", {departamento:departamento}, function(data){
                    $("#idmunicipio_salud_af").html(data);
                    });
                });
        })
        });
    </script>
    <script language="javascript">
        $(document).ready(function(){
        $("#idmunicipio_salud_af").change(function () {
                    $("#idmunicipio_salud_af option:selected").each(function () {
                        municipio_af=$(this).val();
                    $.post("establecimientos_af.php", {municipio_af:municipio_af}, function(data){
                    $("#idestablecimiento_salud_af").html(data);
                    });
                });
        })
        });
    </script>

    <script language="javascript">
        $(document).ready(function(){
        $("#idestablecimiento_salud_af").change(function () {
                    $("#idestablecimiento_salud_af option:selected").each(function () {
                        establecimiento_af=$(this).val();
                    $.post("area_influencia_hc.php", {establecimiento_af:establecimiento_af}, function(data){
                    $("#idarea_influencia_hc").html(data);
                    });
                });
        })
        });
    </script>

    <script language="javascript">
        $(document).ready(function(){
        $("#idarea_influencia_hc").change(function () {
                    $("#idarea_influencia_hc option:selected").each(function () {
                        area_influencia_hc=$(this).val();
                    $.post("historias_clinicas_af.php", {area_influencia_hc:area_influencia_hc}, function(data){
                    $("#historias_clinicas_af").html(data);
                    });
                });
        })
        });
    </script>

</body>
</html>
