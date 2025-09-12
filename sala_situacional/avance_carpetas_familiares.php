<?php include("../cabf.php");?>
<?php include("../inc.config.php");
$gestion = date("Y");

$idestablecimiento_salud = $_GET["idestablecimiento_salud"];

$sql_est = " SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud' ";
$result_est = mysqli_query($link,$sql_est);
$row_est = mysqli_fetch_array($result_est);
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>REPORTE EPIDEMIOLOGICO SEMANAL - SAFCI</title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

            <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">AVANCE - CARPETAS FAMILIARES DEL ESTABLECIMIENTO : <?php echo mb_strtoupper($row_est[1]);?></h6>
                    </div>

                    <div class="card-header py-3">
                    <h6 class="text-info">CUADRO INFORMATIVO PARA SEGUIMIENTO</h6>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-2">
                            <h6 class="text-info">TOTAL DE CARPETAS FAMILIARES:</h6>
                            <?php
                            $sql_f =" SELECT sum(familias) FROM area_influencia WHERE idestablecimiento_salud='$idestablecimiento_salud' ";   
                            $result_f = mysqli_query($link,$sql_f);
                            $row_f = mysqli_fetch_array($result_f);
                            $meta_cf = $row_f[0];

                            $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar ";
                            $sql_cf.=" WHERE  estado='CONSOLIDADO' ";
                            $sql_cf.=" AND idestablecimiento_salud='$idestablecimiento_salud' ";
                            $result_cf = mysqli_query($link,$sql_cf);
                            $row_cf = mysqli_fetch_array($result_cf);  
                            $carpetizacion = $row_cf[0];

                            $porcentaje_est   = ($carpetizacion*100)/$meta_cf;
                            $p_establecmineto    = number_format($porcentaje_est, 2, '.', '');

                            ?>
                            <?php echo $carpetizacion;?>
                            <h6 class="text-info">De <?php echo $meta_cf;?> Familias</h6>
                            <h6 class="text-primary"><?php echo $p_establecmineto;?> %</h6>
                            </div>

                            <div class="col-sm-2">
                            <h6 class="text-info">N° DE INTEGRANTES DE FAMILIA REGISTRADOS:</h6>
                            <?php
                            $sql_h =" SELECT sum(habitantes) FROM area_influencia WHERE idestablecimiento_salud='$idestablecimiento_salud' ";   
                            $result_h = mysqli_query($link,$sql_h);
                            $row_h = mysqli_fetch_array($result_h);

                            $sql_int =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar  ";
                            $sql_int.=" WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                            $sql_int.=" AND carpeta_familiar.estado='CONSOLIDADO'  ";
                            $sql_int.=" AND integrante_cf.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
                            $result_int = mysqli_query($link,$sql_int);
                            $row_int = mysqli_fetch_array($result_int);  
                            $integrantes = $row_int[0];

                            $integrantes_cf   = number_format($integrantes, 0, '.', '.');
                            $integrantes_meta = number_format($row_h[0], 0, '.', '.');

                            $porcentaje_hab   = ($integrantes*100)/$row_h[0];
                            $p_habitantes = number_format($porcentaje_hab, 2, '.', ' ');
                            ?>
                            <?php echo $integrantes_cf;?> 
                            <h6 class="text-info">De <?php echo $integrantes_meta;?> Habitantes</h6>
                            <h6 class="text-primary"><?php echo $p_habitantes;?> %</h6>
                            </div>
                            <div class="col-sm-4">
                            <h6 class="text-info">PERSONAL SAFCI REGISTRADOR:</h6>
                            <?php
                                $numero = 1;
                                $sql =" SELECT idusuario FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND idestablecimiento_salud='$idestablecimiento_salud' GROUP BY idusuario ";   
                                $result = mysqli_query($link,$sql);
                                if ($row = mysqli_fetch_array($result)){
                                mysqli_field_seek($result,0);
                                while ($field = mysqli_fetch_field($result)){
                                } do {
                                    $sql_p =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row[0]'  ";
                                    $result_p = mysqli_query($link,$sql_p);
                                    $row_p = mysqli_fetch_array($result_p);
                                  
                                    echo mb_strtoupper("<h6 class='text-info'>".$numero.".- ". $row_p[0]." ".$row_p[1]." ".$row_p[2]."</h6>");

                                    $sql_af =" SELECT tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia FROM tipo_area_influencia, area_influencia, carpeta_familiar  WHERE carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia";   
                                    $sql_af.=" AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND carpeta_familiar.idusuario='$row[0]' GROUP BY area_influencia.area_influencia ";
                                    $result_af = mysqli_query($link,$sql_af);
                                    if ($row_af = mysqli_fetch_array($result_af)){
                                    mysqli_field_seek($result_af,0);
                                    while ($field_af = mysqli_fetch_field($result_af)){
                                    } do {  ?>

                                        <h6 class="text-info"><?php echo mb_strtoupper(" - ". $row_af[0]." ".$row_af[1]);?></h6>

                                        <?php
                                    }
                                    while ($row_af = mysqli_fetch_array($result_af));
                                    } else {
                                    }

                                    echo "</br>";

                                    $numero = $numero+1;
                                }
                                while ($row = mysqli_fetch_array($result));
                                } else {
                                }
                            ?>
                            <h6></h6>
                            </div>
                            <div class="col-sm-4">
                            <a href="informe_operativo_est.php?idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>" target="_blank" class="text-info" style="font-size: 15px; font-family: Arial;" onClick="window.open(this.href, this.target, 'width=950,height=900,scrollbars=YES,top=60,left=400'); return false;">
                                <h6 class="text-primary">INFORME SITUACIONAL - ESTABLECIMIENTO DE SALUD</h6></a>  
                            </div>
                        </div>   
                    </div>
                </div>    
                      
           
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>