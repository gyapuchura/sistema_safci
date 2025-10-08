<?php include("../cabf.php"); ?>
<?php include("../inc.config.php");
$gestion = date("Y");

$idestablecimiento_salud = $_GET['idestablecimiento_salud'];

$sql_est = " SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, establecimiento_salud.latitud, establecimiento_salud.longitud, establecimiento_salud.idmunicipio ";
$sql_est.= " FROM establecimiento_salud, carpeta_familiar, ubicacion_cf WHERE carpeta_familiar.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
$sql_est.= " AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ORDER BY carpeta_familiar.idestablecimiento_salud DESC LIMIT 1 ";
$result_est = mysqli_query($link,$sql_est);
$row_est = mysqli_fetch_array($result_est);

$latitud_c  = $row_est[2];
$longitud_c = $row_est[3];
$zoom_c     = "18";
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

    <style>
    .filtro {
      display: flex;
      flex-direction: row;
      justify-content: flex-start;
      align-items: center;
      margin-bottom: 10px;
    }
    select {
      margin-right: 10px;
    }
    #location {
      margin-top: 10px;
    }
  </style>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

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
                        <h4 class="m-0 font-weight-bold text-info">ESTABLECIMIENTO DE SALUD: <?php echo mb_strtoupper($row_est[1]);?></h4>
                        </br>

                        <?php
                        $sql_int =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                        $sql_int.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
                        $result_int = mysqli_query($link,$sql_int);
                        $row_int = mysqli_fetch_array($result_int);  
                        $integrantes = $row_int[0];
                        $integrantes_cf   = number_format($integrantes, 0, '.', '.');
                        ?>
                        <h6 class="m-0 font-weight-bold text-primary">N° DE HABITANTES CARPETIZADOS EN EL ESTABLECIMIENTO = <?php echo $integrantes_cf;?></h6>

                        <?php
                        $sql_af =" SELECT idarea_influencia FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND idestablecimiento_salud='$idestablecimiento_salud' ";
                        $sql_af.=" GROUP BY idarea_influencia ";
                        $result_af = mysqli_query($link,$sql_af);
                        $row_af = mysqli_num_rows($result_af);  
                        $areas_influencia = $row_af;
                        ?>
                        <h6 class="m-0 font-weight-bold text-primary">N° DE ÁREAS DE INFLUENCIA DEL ESTABLECIMIENTO  = <?php echo $areas_influencia;?></h6>                  



                        <h6 class="m-0 font-weight-bold text-info">COORDENADAS: <?php echo $latitud_c;?> <?php echo $longitud_c;?></h6>
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
                                        <a href="../sala_situacional/estimacion_poblacion_est.php?idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1500,height=800,scrollbars=YES,top=50,left=100'); return false;">
                                        <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                            POBLACIÓN (ÁREA DEMOGRÁFICA)</div></a>  
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file fa-2x text-gray-300"></i>
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
                                        <a href="../carpetas_familiares/piramide_poblacional_est.php?idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=750,scrollbars=YES,top=50,left=100'); return false;">  
                                        <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                            PIRÁMIDE POBLACIONAL</div>
                                        </a>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file fa-2x text-gray-300"></i>
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
                                        <a href="../carpetas_familiares/grafica_defuncion_cf_est.php?idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=580,scrollbars=YES,top=50,left=100'); return false;">
                                        <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                        DEFUNCIÓN EN LA FAMILIA</div>
                                        </a> 
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file fa-2x text-gray-300"></i>
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
                                        <a href="../carpetas_familiares/morbilidad_est.php?idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=580,scrollbars=YES,top=50,left=100'); return false;">
                                        <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                        ESTADO DE LA SALUD FAMILIAR</div>
                                        </a>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file fa-2x text-gray-300"></i>
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
                                    <a href="../carpetas_familiares/grafica_programa_social_cf_est.php?idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=650,scrollbars=YES,top=50,left=100'); return false;">
                                    <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                    MONITOREO DE PROGRAMAS SOCIALES</div>
                                    </a>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file fa-2x text-gray-300"></i>
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
                                        <a href="../produccion_servicios/atenciones_psafci_diarias_est.php?idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=850,scrollbars=YES,top=50,left=400'); return false;">
                                        <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                        MONITOREO ATENCION INTEGRAL PSAFCI</div></a>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file fa-2x text-gray-300"></i>
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
                                        <a href="../administrar_sistema/reporte_ep_semanal_est.php?idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=600,height=900,scrollbars=YES,top=50,left=400'); return false;">
                                        <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                            VIGILANCIA EPIDEMIOLÓGICA</div></a>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file fa-2x text-gray-300"></i>
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
                                        <a href="../administrar_sistema/reporte_ep_desastres_est.php?idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=400,height=450,scrollbars=YES,top=50,left=400'); return false;">
                                        <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                           DESASTRES</div></a>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file fa-2x text-gray-300"></i>
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
                                <a href="../carpetas_familiares/ubicacion_familias_establecimiento.php?idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1400,height=900,scrollbars=YES,top=50,left=400'); return false;">
                                     <div class="card bg-info text-white shadow">
                                       <div class="card-body">
                                            MAPA PARLANTE
                                        </div>
                                    </div></a>
                                </div>
                    <!-------- MAPA PARLANTE begin ------>

                    <div id="safci" style="width: 100%; height: 680px;"></div>

<hr>
                    <div class="col-xl-12 col-md-3 mb-2">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <a href="../seguimiento_familiar/reporte_riesgos_est.php?idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=850,scrollbars=YES,top=50,left=400'); return false;">
                                        <div class="text-xm font-weight-bold text-info text-uppercase mb-1">
                                           VISITAS FAMILIARES POR RIÉSGO PERSONAL</div></a>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-3 mb-2">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <a href="../seguimiento_familiar/valida_visitas_establecimiento.php?idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1280,height=900,scrollbars=YES,top=50,left=400'); return false;">
                                        <div class="text-xm font-weight-bold text-danger text-uppercase mb-1">
                                           CALENDARIO DE VISITAS - ESTABLECIMIENTO</div></a>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                        <a href="avance_carpetas_familiares.php?idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=500,scrollbars=YES,top=50,left=100'); return false;">
                                        <div class="text-xm font-weight-bold text-success text-uppercase mb-1">
                                            AVANCE DE CARPETAS FAMILIARES</div>
                                        </a>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file fa-2x text-gray-300"></i>
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
                                        <a href="../carpetas_familiares/monitoreo_determinantes_cf.php?idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=800,scrollbars=YES,top=50,left=100'); return false;">
                                        <div class="text-xm font-weight-bold text-success text-uppercase mb-1">
                                            MONITOREO DETERMINANTES DE LA SALUD</div>
                                        </a>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file fa-2x text-gray-300"></i>
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
                                    <a href="../carpetas_familiares/grafica_socioeconomica_cf_est.php?idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=700,scrollbars=YES,top=50,left=100'); return false;">
                                        <div class="text-xm font-weight-bold text-success text-uppercase mb-1">
                                            ÁREA SOCIOECONÓMICA-PRODUCTIVA</div>
                                    </a>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file fa-2x text-gray-300"></i>
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
                                    <a href="../carpetas_familiares/grafica_pertenencia_cultural_cf_est.php?idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=950,height=700,scrollbars=YES,top=50,left=100'); return false;">
                                        <div class="text-xm font-weight-bold text-success text-uppercase mb-1">
                                            ÁREA INTERCULTURAL</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </a>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file fa-2x text-gray-300"></i>
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
<?php

        $sql =" SELECT idgestion_participativa FROM gestion_participativa WHERE idmunicipio = '$row_est[4]' ";
        $result = mysqli_query($link,$sql);
        if ($row = mysqli_fetch_array($result)){
        mysqli_field_seek($result,0);
        while ($field = mysqli_fetch_field($result)){
        } do {
        ?>
            <a href="gestion_participativa_sala_est.php?idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=860,scrollbars=YES,top=50,left=100'); return false;">                                        
            <div class="text-xm font-weight-bold text-success text-uppercase mb-1">
                ÁREA INTERSECTORIAL</div>
            </a>
        <?php
        }
        while ($row = mysqli_fetch_array($result));
        } else {
            ?>

            <div class="text-xm font-weight-bold text-danger text-uppercase mb-1">
                SIN INFORMACIÓN DEL ÁREA INTERSECTORIAL</div>
            <?php } ?>



                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        <!-------- GESTIÓN PARTICIPATIVA end ------>

   

               

            
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

    <script type="text/javascript" src="../js/municipios.js"></script>
    <script type="text/javascript" src="../js/establecimientos.js"></script>

    <script>
        var mapbox_url = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1Ijoiam9ubnltY2N1bGxhZ2giLCJhIjoiY2xsYzdveWh4MGhwcjN0cXV5Z3BwMXA1dCJ9.QoEHzPNq9DtTRrdtXfOdrw';
        var mapbox_attribution = '© Mapbox © OpenStreetMap Contributors';
        var esri_url ='https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
        var esri_attribution = '© Esri © OpenStreetMap Contributors';

        var Icono = L.icon({
        iconUrl: "marcadores/eess_blanco_celeste.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});
      
        var Icono2 = L.icon({
        iconUrl: "marcadores/familia_verde.png",
        iconSize: [40, 40],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var lyr_streets   = L.tileLayer(mapbox_url, {id: 'safci', maxZoom: 18, tileSize: 512, zoomOffset: -1, attribution: mapbox_attribution});
        var lyr_satellite = L.tileLayer(esri_url, {id: 'safci', maxZoom: 19, tileSize: 512, zoomOffset: -1, attribution: esri_attribution});


        var marker = L.marker([<?php echo $latitud_c;?>, <?php echo $longitud_c;?>]).bindPopup('<?php echo "Establecimiento : ".$row_est[1];?>');

    
        var lg_markers = L.layerGroup([marker]);

          var map = L.map('safci', {
            center: [<?php echo $latitud_c;?>, <?php echo $longitud_c;?>],
            zoom: <?php echo $zoom_c;?>,
            layers: [lyr_streets, lyr_satellite,  lg_markers]
        });  

        var baseMaps = {
            "MAPA": lyr_streets,
            "SATÉLITE": lyr_satellite
        };
        var overlayMaps = {
            "Marcador": lg_markers,
        };

        L.control.layers(baseMaps, overlayMaps).addTo(map);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'PROGRAMA SAFCI-MI SALUD'
        }).addTo(map);

     
  

            <?php
            /****** Areas de influencia del Establecimiento de salud *********/
            $numero4 = 0;
            $sql4 = " SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.familia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, ";
            $sql4.= " ubicacion_cf.avenida_calle, ubicacion_cf.no_puerta, ubicacion_cf.latitud, ubicacion_cf.longitud ";
            $sql4.= " FROM carpeta_familiar, area_influencia, tipo_area_influencia, ubicacion_cf WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND ";
            $sql4.= " carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia ";
            $sql4.= " AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.ubicacion_actual='SI' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ORDER BY carpeta_familiar.idcarpeta_familiar DESC LIMIT 100 ";
            $result4 = mysqli_query($link,$sql4);
            $total4 = mysqli_num_rows($result4);
            if ($row4 = mysqli_fetch_array($result4)){
            mysqli_field_seek($result4,0);
            while ($field4 = mysqli_fetch_field($result4)){
            } do {
                ?>

        L.marker([<?php echo $row4[6];?>, <?php echo $row4[7];?>], {icon: Icono2}).addTo(map).bindPopup('<?php echo 'FAMILIA: '.$row4[1].'</br>'.$row4[2].'  '.$row4[3].'</br>Direccion :'.$row4[4].' Nº '.$row4[5];?>')

            <?php 
            $numero4++;
            } while ($row4 = mysqli_fetch_array($result4));
            } else {
            }
            ?>
      L.marker([<?php echo $latitud_c;?>, <?php echo $longitud_c;?>], {icon: Icono}).addTo(map).bindPopup('<?php echo 'Establecimeinto : '.$row_est[1];?>')
    </script>

</body>

</html>
