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
                    <h1 class="h3 mb-2 text-gray-800">CARPETAS FAMILIARES - SAFCI</h1>
                    <p class="mb-4">En esta sección se puede encontrar el registro de Carpetas Familiares del PROGRAMA NACIONAL SAFCI - MI SALUD.</p>

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
                                            <th>FAMILIA</th>
                                            
                                            <th>ÁREA DE INFLUENCIA</th>
                                            <th>FECHA DE REGISTRO</th>
                                            <th>ACCIÓN</th>
                                            <th>OBSERVACIONES</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                   <tbody>
                        <?php
                        $numero=1;
                        $sql =" SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.codigo, carpeta_familiar.familia, departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud, ";
                        $sql.=" tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, carpeta_familiar.fecha_registro, carpeta_familiar.hora_registro, carpeta_familiar.estado, carpeta_familiar.idusuario ";
                        $sql.=" FROM carpeta_familiar, departamento, municipios, establecimiento_salud, area_influencia, tipo_area_influencia WHERE carpeta_familiar.iddepartamento=departamento.iddepartamento ";
                        $sql.=" AND carpeta_familiar.idmunicipio=municipios.idmunicipio AND carpeta_familiar.idusuario='$idusuario_ss' AND carpeta_familiar.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
                        $sql.=" AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia ORDER BY carpeta_familiar.idcarpeta_familiar ";
                        $result = mysqli_query($link,$sql);
                        if ($row = mysqli_fetch_array($result)){
                        mysqli_field_seek($result,0);
                        while ($field = mysqli_fetch_field($result)){
                        } do {

                        $sql_n = " SELECT integrante_cf.idintegrante_cf, nombre.fecha_nac FROM integrante_cf, nombre WHERE integrante_cf.idnombre=nombre.idnombre ";
                        $sql_n.= " AND integrante_cf.idcarpeta_familiar ='$row[0]' ";
                        $result_n = mysqli_query($link,$sql_n);
                        if ($row_n = mysqli_fetch_array($result_n)){
                        mysqli_field_seek($result_n,0);
                        while ($field_n = mysqli_fetch_field($result_n)){
                        } do {

$fecha_nacimiento = $row_n[1];
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

if ($edad <= 4) {
    $idgrupo_etareo_cf = '1';
    } else {
    if ($edad <= 9) {
    $idgrupo_etareo_cf = '2';
    } else {
    if ($edad <= 14) {
        $idgrupo_etareo_cf = '3';
    } else { 
        if ($edad <= 19) {
        $idgrupo_etareo_cf = '4';
    } else { 
        if ($edad <= 24) {
            $idgrupo_etareo_cf = '5';
        } else { 
            if ($edad <= 29) {
                $idgrupo_etareo_cf = '6';
            } else { 
                if ($edad <= 34) {
                    $idgrupo_etareo_cf = '7';
                } else { 
                    if ($edad <= 39) {
                        $idgrupo_etareo_cf = '8';
                    } else { 
                        if ($edad <= 44) {
                            $idgrupo_etareo_cf = '9';
                        } else { 
                            if ($edad <= 49) {
                                $idgrupo_etareo_cf = '10';
                            } else { 
                                if ($edad <= 54) {
                                    $idgrupo_etareo_cf = '11';
                                } else { 
                                    if ($edad <= 59) {
                                        $idgrupo_etareo_cf = '12';
                                    } else { 
                                        if ($edad <= 64) {
                                            $idgrupo_etareo_cf = '13';
                                        } else { 
                                            if ($edad <= 69) {
                                                $idgrupo_etareo_cf = '14';
                                            } else { 
                                                if ($edad <= 74) {
                                                    $idgrupo_etareo_cf = '15';
                                                } else { 
                                                    if ($edad <= 79) {
                                                        $idgrupo_etareo_cf = '16';
                                                    } else { 
                                                        if ($edad <= 84) {
                                                            $idgrupo_etareo_cf = '17';
                                                        } else { 
                                                            if ($edad <= 89) {
                                                                $idgrupo_etareo_cf = '18';
                                                            } else { 
                                                                if ($edad <= 94) {
                                                                    $idgrupo_etareo_cf = '19';
                                                                } else { 
                                                                    if ($edad >= 95) {
                                                                        $idgrupo_etareo_cf = '20';
                                                                    } else { 
    }}}}} }}}}} }}}}} }}}}}

        $sql0 = " UPDATE integrante_cf SET idgrupo_etareo_cf ='$idgrupo_etareo_cf', edad ='$edad'  WHERE idintegrante_cf = '$row_n[0]'";
        $result0 = mysqli_query($link,$sql0);

                }
                while ($row_n = mysqli_fetch_array($result_n));
                } else {
                }

                        ?>
                                        <tr>
                                            <td><?php echo $numero;?></td>
                                            <td><?php echo $row[1];?></td>
                                            <td><?php echo $row[2];?></td>
                                            
                                            <td><?php echo $row[6];?></br><?php echo $row[7];?></td>
                                            <td>
                                            <?php 
                                                $fecha_r = explode('-',$row[8]);
                                                $f_apertura = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                                            <?php echo $f_apertura;?></br><?php echo $row[9];?>   
                                            </td>
                                            <td>
                                                <?php if ($row[10] == 'CONSOLIDADO') { ?>
                                                   
                                                    <a href="imprime_carpeta_familiar.php?idcarpeta_familiar=<?php echo $row[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1280,height=800,top=50, left=200, scrollbars=YES'); return false;">
                                                    <h6 class="text-info">IMPRIMIR CARPETA FAMILIAR</h6></a>

                                               <?php } else { 
                                                
                                                if ($row[11] == $idusuario_ss) { ?>

                                                    <form name="FORM_P" action="valida_carpeta_familiar.php" method="post">
                                                    <input name="idcarpeta_familiar" type="hidden" value="<?php echo $row[0];?>">
                                                    <button type="submit" class="btn btn-primary btn-user btn-block">VER/MODIFICAR</button></form>

                                               <?php } else {  ?>

                                                <h6 class="text-primary">EN PROCESO DE LLENADO</h6>
                                                
                                                 <?php }} ?>                                                                      
                                        </td>
                                        <td>
                                        <?php                                         
                                        $numero_d=0;
                                        $sqld =" SELECT idcat_determinante_salud FROM determinante_salud_cf WHERE idcarpeta_familiar='$row[0]' GROUP BY idcat_determinante_salud ";
                                        $resultd = mysqli_query($link,$sqld);
                                        if ($rowd = mysqli_fetch_array($resultd)){
                                        mysqli_field_seek($resultd,0);
                                        while ($fieldd = mysqli_fetch_field($resultd)){
                                        } do { 
                                    
                                            $numero_d=$numero_d+1;
                                        }
                                        while ($rowd = mysqli_fetch_array($resultd));
                                        } else {
                                        }
                                    
                                        if ($numero_d == '20') {    
                                                   
                                        } else {
                                            echo "<h6 class='text-danger'>- AJUSTAR DETERMINANTES DE LA SALUD </h6>";
                                        }

                                        $sql_in = " SELECT count(idintegrante_cf) FROM integrante_cf WHERE idcarpeta_familiar = '$row[0]' ";
                                        $result_in = mysqli_query($link,$sql_in);    
                                        $row_in = mysqli_fetch_array($result_in);
                                        $integrantes = $row_in[0];

                                        $sql_1 = " SELECT idintegrante_cf FROM integrante_datos_cf WHERE idcarpeta_familiar = '$row[0]' GROUP BY idintegrante_cf ";
                                        $result_1 = mysqli_query($link,$sql_1);  
                                        $integrantes_datos = mysqli_num_rows($result_1);  
                                        if ($integrantes == $integrantes_datos) {                                    
                                            } else { 
                                                echo "<h6 class='text-danger'>- AJUSTAR DATOS DE TODOS LOS INTEGRANTES </h6>";
                                            }

                                            $sql_dp = " SELECT count(idintegrante_datos_cf) FROM integrante_datos_cf WHERE idcarpeta_familiar = '$row[0]' ";
                                            $result_dp = mysqli_query($link,$sql_dp);  
                                            $datos_dup = mysqli_fetch_array($result_dp);  
                                            if ($integrantes < $datos_dup[0]) {   
                                                    echo "<h6 class='text-danger'>- AJUSTAR DUPLICIDAD DE DATOS DE LOS INTEGRANTES </h6>";
                                                } else {                                                 
                                                }
                                    
                                        $sql_2 = " SELECT idintegrante_cf FROM integrante_subsector_salud WHERE idcarpeta_familiar = '$row[0]' GROUP BY idintegrante_cf ";
                                        $result_2 = mysqli_query($link,$sql_2);  
                                        $integrantes_sub = mysqli_num_rows($result_2);  
                                        if ($integrantes_sub >= $integrantes) {
                                    
                                            } else { 
                                                echo "<h6 class='text-danger'>- AJUSTAR DATOS DE SUBSECTOR SALUD </h6>";
                                            }
                                   
                                            $sql_3 = " SELECT idintegrante_cf FROM integrante_beneficiario WHERE idcarpeta_familiar = '$row[0]' GROUP BY idintegrante_cf ";
                                            $result_3 = mysqli_query($link,$sql_3); 
                                            $integrante_ben = mysqli_num_rows($result_3);   
                                            if ($integrante_ben >= $integrantes) {
                                        
                                                } else { 
                                                    echo "<h6 class='text-danger'>- AJUSTAR DATOS DE PROGRAMAS SOCIALES </h6>";
                                                }
                                            $sql_4 = " SELECT idintegrante_cf FROM integrante_tradicional WHERE idcarpeta_familiar = '$row[0]' GROUP BY idintegrante_cf ";
                                            $result_4 = mysqli_query($link,$sql_4);   
                                            $integrante_trad = mysqli_num_rows($result_4); 
                                            if ($integrante_trad >= $integrantes) {
                                        
                                                } else { 
                                                    echo "<h6 class='text-danger'>- AJUSTAR DATOS DE MEDICINA TRADICIONAL </h6>";
                                                }
                                    
                                            $sql_5 = " SELECT idintegrante_cf FROM integrante_defuncion WHERE idcarpeta_familiar = '$row[0]' GROUP BY idintegrante_cf";
                                            $result_5 = mysqli_query($link,$sql_5);   
                                            $integrante_def = mysqli_num_rows($result_5); 
                                            if ($integrante_def >= $integrantes) {
                                        
                                                } else { 
                                                    echo "<h6 class='text-danger'>- AJUSTAR DATOS DE DEFUNCION DE INTEGRANTES </h6>";
                                                }
                                    

                                                $sql_soc = " SELECT idsocio_economica FROM socio_economica_cf WHERE idcarpeta_familiar = '$row[0]' ";
                                                $result_soc = mysqli_query($link,$sql_soc);   
                                                $socioeconomia = mysqli_num_rows($result_soc); 
                                                if ($socioeconomia == '10') {
                                            
                                                    } else { 
                                                        echo "<h6 class='text-danger'>- AJUSTAR CARACTERÍSTICAS SOCIOECONÓMICAS </h6>";
                                                    }
                                     //----- INCORPORAR EN BANDEJA DE CARPETAS OPERATIVO END ----- //   
                                                                                
                                        ?>
                                        </td>
                                        <td>
                                        <?php if ($row[10] == 'CONSOLIDADO') { ?>
                                                
                                                   <form name="FORM_P" action="valida_carpeta_familiar.php" method="post">
                                                   <input name="idcarpeta_familiar" type="hidden" value="<?php echo $row[0];?>">
                                                   <button type="submit" class="btn btn-info btn-user btn-block">ACTUALIZAR</br>CARPETA FAMILIAR</button></form>

                                        <?php } else {  ?>      
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


                            <hr>
                <div class="text-center">
                <div class="form-group row"> 
                        <div class="col-sm-4">
                        <a href="imprime_reporte_cfs_op.php?idusuario_op=<?php echo $idusuario_ss;?>" target="_blank" class="text-info" style="font-size: 15px; font-family: Arial;" onClick="window.open(this.href, this.target, 'width=1220,height=800,scrollbars=YES,top=60,left=400'); return false;">
                        IMPRIMIR REPORTE DE CARPETAS FAMILIARES</a>   
                        </div>
                        <div class="col-sm-4">
                        <a href="operativo_a_cfs.php?idusuario_op=<?php echo $idusuario_ss;?>" target="_blank" class="text-info" style="font-size: 15px; font-family: Arial;" onClick="window.open(this.href, this.target, 'width=900,height=900,scrollbars=YES,top=60,left=400'); return false;">
                        ANALÍTICA DEL MÉDICO OPERATIVO</a>   
                        </div>
                        <div class="col-sm-4">
                    <form name="REPORTE_CF" action="reporte_cf_op_excel.php" method="post">
                        <input type="hidden" name="idusuario_op" value="<?php echo $idusuario_ss;?>">
                        <button type="submit" class="btn btn-success">REPORTE CARPETAS FAMILIARES EN EXCEL</button>
                    </form>
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
