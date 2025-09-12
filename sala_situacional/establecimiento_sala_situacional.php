<?php include("../cabf.php"); ?>
<?php include("../inc.config.php");
$gestion = date("Y");

$idestablecimiento_salud = $_POST['establecimiento_salud'];

$sql_est = " SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, ubicacion_cf.latitud, ubicacion_cf.longitud  ";
$sql_est.= " FROM establecimiento_salud, carpeta_familiar, ubicacion_cf WHERE carpeta_familiar.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
$sql_est.= " AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ORDER BY carpeta_familiar.idestablecimiento_salud DESC LIMIT 1 ";
$result_est = mysqli_query($link,$sql_est);
$row_est = mysqli_fetch_array($result_est);

$latitud_c  = $row_est[2];
$longitud_c = $row_est[3];
$zoom_c     = "16";
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SALA SITUACIONAL DE SALUD - SAFCI</title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
        <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

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
                        <h4 class="m-0 font-weight-bold text-primary">SALA SITUACIONAL DE SALUD</h4>
                        <h4 class="m-0 font-weight-bold text-primary">ESTABLECIMIENTO DE SALUD: <?php echo mb_strtoupper($row_est[1]);?></h4>
                        <h4 class="m-0 font-weight-bold text-primary">COORDENADAS: <?php echo $latitud_c;?> <?php echo $longitud_c;?></h4>
                    </div> 
                     
                <div class="card-body">
                   
                        <div class="form-group row">
                            <div class="col-sm-3">
                                    <div class="card bg-primary text-white shadow">
                                        <div class="card-body">
                                            COMPONENTE DE ATENCIÓN INTEGRAL
                                        </div>
                                    </div>
                                    <hr>
                        <!-------- ATENCION INTEGRAL begin ------>
                <div class="row">
                    <div class="col-xl-12 col-md-3 mb-2">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                            POBLACIÓN (ÁREA DEMOGRÁFICA)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">40,000</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                <div class="col-xl-12 col-md-3 mb-2">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                            PIRÁMIDE POBLACIONAL</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-3 mb-2">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                            MORTALIDAD</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-3 mb-2">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                            MORBILIDAD</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-3 mb-2">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                            MONITOREO DE PROGRAMAS NACIONALES</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-3 mb-2">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                            MONITOREO DE ENFERMEDADES NO TRANSMISIBLES</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-3 mb-2">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                            VIGILANCIA EPIDEMIOLÓGICA</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-3 mb-2">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                           DESASTRES</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                        <!-------- ATENCION INTEGRAL end ------>
                            </div>
                            <div class="col-sm-6">                                
                                <div class="col-lg-12 mb-4">
                                    <div class="card bg-info text-white shadow">
                                        <div class="card-body">
                                            MAPA PARLANTE
                                        </div>
                                    </div>
                                </div>
                    <!-------- MAPA PARLANTE begin ------>

                    <div id="mi_mapa" style="width: 100%; height: 700px;"></div>

                    <!-------- MAPA PARLANTE begin ------>
                            </div>
                            <div class="col-sm-3">
                                <div class="card bg-success text-white shadow">
                                    <div class="card-body">
                                        COMPONENTE DE GESTIÓN PARTICIPATIVA
                                    </div>
                                </div>
                                <hr>
                        <!-------- GESTIÓN PARTICIPATIVA begin ------>
                <div class="row">
                    <div class="col-xl-12 col-md-3 mb-2">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xm font-weight-bold text-success text-uppercase mb-1">
                                            AVANCE DE CARPETAS FAMILIARES</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-3 mb-2">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xm font-weight-bold text-success text-uppercase mb-1">
                                            MONITOREO DETERMINANTES DE LA SALUD</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-3 mb-2">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xm font-weight-bold text-success text-uppercase mb-1">
                                            ÁREA SOCIOECONÓMICA-PRODUCTIVA</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-xl-12 col-md-3 mb-2">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xm font-weight-bold text-success text-uppercase mb-1">
                                            ÁREA INTERCULTURAL</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-3 mb-2">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xm font-weight-bold text-success text-uppercase mb-1">
                                            ÁREA INTERSECTORIAL</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-3 mb-2">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xm font-weight-bold text-success text-uppercase mb-1">
                                            ÁREA DE GESTIÓN PARTICIPATIVA</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        <!-------- GESTIÓN PARTICIPATIVA end ------>
                            </div>
                </div>
   

                                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-2">
                            <h6 class="text-info">FAMILIAS CARPETIZADAS:</h6>
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
                            <h6 class="text-info">N° DE INTEGRANTES DE FAMILIA REGISTRADOS (SNIS):</h6>
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
                            <h6 class="text-info">PERSONAL SAFCI:</h6>
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
                            <a href="../carpetas_familiares/informe_operativo_est.php?idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>" target="_blank" class="text-info" style="font-size: 15px; font-family: Arial;" onClick="window.open(this.href, this.target, 'width=950,height=900,scrollbars=YES,top=60,left=400'); return false;">
                                <h6 class="text-primary">INFORME SITUACIONAL - ESTABLECIMIENTO DE SALUD</h6></a>  
                            </div>
                        </div>   
                    </div>
                </div>   

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

    
    <script>
        let map = L.map('mi_mapa').setView([<?php echo $latitud_c;?>, <?php echo $longitud_c;?>], <?php echo $zoom_c;?>)

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);


            <?php
            /****** Areas de influencia del Establecimiento de salud *********/
            $numero4 = 0;
            $sql4 = " SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.familia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, ";
            $sql4.= " ubicacion_cf.avenida_calle, ubicacion_cf.no_puerta, ubicacion_cf.latitud, ubicacion_cf.longitud ";
            $sql4.= " FROM carpeta_familiar, area_influencia, tipo_area_influencia, ubicacion_cf WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ";
            $sql4.= " carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia ";
            $sql4.= " AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.ubicacion_actual='SI' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ORDER BY carpeta_familiar.idcarpeta_familiar DESC LIMIT 50 ";
            $result4 = mysqli_query($link,$sql4);
            $total4 = mysqli_num_rows($result4);
            if ($row4 = mysqli_fetch_array($result4)){
            mysqli_field_seek($result4,0);
            while ($field4 = mysqli_fetch_field($result4)){
            } do {
                ?>

        L.marker([<?php echo $row4[6];?>, <?php echo $row4[7];?>]).addTo(map).bindPopup('<?php echo 'FAMILIA: '.$row4[1].'</br>'.$row4[2].'  '.$row4[3].'</br>Direccion :'.$row4[4].' Nº '.$row4[5];?>')

            <?php 
            $numero4++;
            } while ($row4 = mysqli_fetch_array($result4));
            } else {
            }
            ?>

        

        map.on('click', onMapClick)

        function onMapClick(e) {
            alert("Posición: " + e.latlng)
        }
    </script>

</body>

</html>
