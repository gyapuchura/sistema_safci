<?php include("../cabf.php"); ?>
<?php include("../inc.config.php");
$gestion = date("Y");

$idmunicipio = $_GET['idmunicipio'];

$sql_cord = "  SELECT area_influencia.idarea_influencia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, area_influencia.latitud, area_influencia.longitud  ";
$sql_cord.= "  FROM area_influencia, tipo_area_influencia, establecimiento_salud WHERE area_influencia.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud  ";
$sql_cord.= "  AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND establecimiento_salud.idmunicipio='$idmunicipio' ORDER BY area_influencia.idarea_influencia DESC LIMIT 1 ";
$result_cord = mysqli_query($link,$sql_cord);
$row_cord = mysqli_fetch_array($result_cord);

$sql_mun = " SELECT idmunicipio, municipio FROM municipios WHERE idmunicipio='$idmunicipio'  ";
$result_mun = mysqli_query($link,$sql_mun);
$row_mun = mysqli_fetch_array($result_mun);

$latitud_c  = $row_cord[3];
$longitud_c = $row_cord[4];
$zoom_c     = "13";
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
                        <h2 class="m-0 font-weight-bold text-info">MUNICIPIO : <?php echo mb_strtoupper($row_mun[1]);?></h2>
                        </br>
                        <?php
                        $sql_int =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                        $sql_int.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                        $result_int = mysqli_query($link,$sql_int);
                        $row_int = mysqli_fetch_array($result_int);  
                        $integrantes = $row_int[0];

                        $integrantes_cf   = number_format($integrantes, 0, '.', '.');
                        ?>
                        <h6 class="m-0 font-weight-bold text-primary">N° DE HABITANTES CARPETIZADOS EN EL MUNICIPIO = <?php echo $integrantes_cf;?></h6>

                        <?php
                        $sql_af =" SELECT idarea_influencia FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND idmunicipio='$idmunicipio' ";
                        $sql_af.=" GROUP BY idarea_influencia ";
                        $result_af = mysqli_query($link,$sql_af);
                        $row_af = mysqli_num_rows($result_af);  
                        $areas_influencia = $row_af;
                        ?>
                        <h6 class="m-0 font-weight-bold text-primary">N° DE ÁREAS DE INFLUENCIA EN EL MUNICIPIO = <?php echo $areas_influencia;?></h6>                  

                        <?php
                        $sql_mun =" SELECT idestablecimiento_salud FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND idmunicipio='$idmunicipio' GROUP BY idestablecimiento_salud  ";
                        $result_mun = mysqli_query($link,$sql_mun);
                        $establecimientos = mysqli_num_rows($result_mun);  
                        ?>
                        <h6 class="m-0 font-weight-bold text-primary">N° DE ESTABLECIMIENTOS DE SALUD EN EL MUNICIPIO = <?php echo $establecimientos;?></h6>

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
                                        <a href="../sala_situacional/estimacion_poblacion_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1500,height=800,scrollbars=YES,top=50,left=100'); return false;">
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
                                        <a href="../carpetas_familiares/piramide_poblacional_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=750,scrollbars=YES,top=50,left=100'); return false;">  
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
                                        <a href="../carpetas_familiares/grafica_defuncion_cf_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=580,scrollbars=YES,top=50,left=100'); return false;">
                                        <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                        DEFUNCIÓN EN LAS FAMILIAS</div>
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
                                        <a href="../carpetas_familiares/salud_integrantes_grafica_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=800,scrollbars=YES,top=50,left=100'); return false;">
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
                                    <a href="../carpetas_familiares/grafica_programa_social_cf_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=650,scrollbars=YES,top=50,left=100'); return false;">
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
                                        <a href="../produccion_servicios/atenciones_psafci_diarias_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=850,scrollbars=YES,top=50,left=400'); return false;">
                                        <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                        MONITOREO ATENCIÓN INTEGRAL PSAFCI</div></a>
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
                                        <a href="../administrar_sistema/reporte_ep_semanal_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=600,height=900,scrollbars=YES,top=50,left=400'); return false;">
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
                                        <a href="../administrar_sistema/reporte_ep_desastres_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=400,height=450,scrollbars=YES,top=50,left=400'); return false;">
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
                                <a href="../carpetas_familiares/areas_influencia_municipio.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1400,height=900,scrollbars=YES,top=50,left=400'); return false;">
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
                                        <a href="../seguimiento_familiar/reporte_riesgos_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1300,height=850,scrollbars=YES,top=50,left=400'); return false;">
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
                                        <a href="../seguimiento_familiar/valida_visitas_municipio.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1280,height=900,scrollbars=YES,top=50,left=400'); return false;">
                                        <div class="text-xm font-weight-bold text-danger text-uppercase mb-1">
                                           CALENDARIO DE VISITAS - MUNICIPIO</div></a>
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
                                        <a href="avance_carpetas_familiares_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=900,scrollbars=YES,top=50,left=100'); return false;">
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
                                        <a href="../carpetas_familiares/monitoreo_determinantes_cf_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=800,scrollbars=YES,top=50,left=100'); return false;">
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
                                    <a href="../carpetas_familiares/grafica_socioeconomica_cf_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=700,scrollbars=YES,top=50,left=100'); return false;">
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
                                    <a href="../carpetas_familiares/grafica_pertenencia_cultural_cf_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=950,height=700,scrollbars=YES,top=50,left=100'); return false;">
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

        $sql =" SELECT idgestion_participativa FROM gestion_participativa WHERE idmunicipio = '$idmunicipio' ";
        $result = mysqli_query($link,$sql);
        if ($row = mysqli_fetch_array($result)){
        mysqli_field_seek($result,0);
        while ($field = mysqli_fetch_field($result)){
        } do {
        ?>
            <a href="gestion_participativa_sala_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=860,scrollbars=YES,top=50,left=100'); return false;">                                        
            <div class="text-xm font-weight-bold text-success text-uppercase mb-1">
                ÁREA INTERSECTORIAL</div>
            </a>
        <?php
        }
        while ($row = mysqli_fetch_array($result));
        } else {
            ?>

            <div class="text-xm font-weight-bold text-danger text-uppercase mb-1">
                SIN INFORMACIÓN DE ÁREA INTERSECTORIAL</div>
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
        iconUrl: "marcadores/comunidad.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Icono2 = L.icon({
        iconUrl: "marcadores/marcador_blanco_azul.png",
        iconSize: [40, 40],
        iconAnchor: [15, 40],
        shadowUrl: "marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Vecinal = L.icon({
        iconUrl: "../sala_situacional/marcadores/marcador_rojo_bl.png",
        iconSize: [25, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Puesto_salud = L.icon({
        iconUrl: "../sala_situacional/marcadores/marcador_amarillo.png",
        iconSize: [45, 45],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Ambulatorio = L.icon({
        iconUrl: "../sala_situacional/marcadores/marcador_violeta.png",
        iconSize: [30, 30],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Internacion = L.icon({
        iconUrl: "../sala_situacional/marcadores/marcador_verde.png",
        iconSize: [25, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Integral = L.icon({
        iconUrl: "../sala_situacional/marcadores/marcador_azul.png",
        iconSize: [45, 40],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Hospital_seg = L.icon({
        iconUrl: "../sala_situacional/marcadores/hospital_rojo.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Hospital_gen = L.icon({
        iconUrl: "../sala_situacional/marcadores/eess_blanco_celeste.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});

        var Establecim = L.icon({
        iconUrl: "../sala_situacional/marcadores/cruz_roja_blanco.png",
        iconSize: [35, 35],
        iconAnchor: [15, 40],
        shadowUrl: "../sala_situacional/marcadores/icono_sombra.png",
        shadowSize: [35, 50],
        shadowAnchor: [0, 55],
        popupAnchor: [0, -40]});


        var lyr_streets   = L.tileLayer(mapbox_url, {id: 'safci', maxZoom: 18, tileSize: 512, zoomOffset: -1, attribution: mapbox_attribution});
        var lyr_satellite = L.tileLayer(esri_url, {id: 'safci', maxZoom: 19, tileSize: 512, zoomOffset: -1, attribution: esri_attribution});
        var marker = L.marker([<?php echo $latitud_c;?>, <?php echo $longitud_c;?>],{icon: Icono} ).bindPopup('<?php echo "Municipio : ".$row_mun[1];?>');

    
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
            $numero5 = 0;
            $sql5 = " SELECT carpeta_familiar.idarea_influencia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, area_influencia.latitud, area_influencia.longitud, carpeta_familiar.idusuario   ";
            $sql5.= " FROM carpeta_familiar, area_influencia, tipo_area_influencia WHERE carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia ";
            $sql5.= " AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND carpeta_familiar.idmunicipio='$idmunicipio' GROUP BY carpeta_familiar.idarea_influencia ";
            $result5 = mysqli_query($link,$sql5);
            $total5 = mysqli_num_rows($result5);
            if ($row5 = mysqli_fetch_array($result5)){
            mysqli_field_seek($result5,0);
            while ($field5 = mysqli_fetch_field($result5)){
            } do {


                    $sql6 = " SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql6.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idarea_influencia='$row5[0]' ";
                    $result6 = mysqli_query($link,$sql6);
                    $row6 = mysqli_fetch_array($result6);
                    $habitamtes = $row6[0];

                    $sql7 = " SELECT count(idcarpeta_familiar) FROM carpeta_familiar WHERE carpeta_familiar.estado='CONSOLIDADO' AND idarea_influencia='$row5[0]' ";
                    $result7 = mysqli_query($link,$sql7);
                    $row7 = mysqli_fetch_array($result7);
                    $familias = $row7[0];

                    $sql10 = " SELECT nombre.nombre, nombre.paterno, nombre.materno FROM carpeta_familiar, usuarios, nombre WHERE carpeta_familiar.idusuario=usuarios.idusuario ";
                    $sql10.= " AND usuarios.idnombre=nombre.idnombre AND carpeta_familiar.idusuario='$row5[5]' LIMIT 1 ";
                    $result10 = mysqli_query($link,$sql10);
                    $row10 = mysqli_fetch_array($result10);

                    $medico = $row10[0]." ".$row10[1]." ".$row10[2];


                ?>

        L.marker([<?php echo $row5[3];?>, <?php echo $row5[4];?>], {icon: Icono}).addTo(map).bindPopup("<?php echo '<p>'.$row5[1].' : '.$row5[2].'</p><p>Habitantes Carpetizados : '.$habitamtes.'</p><p>Familias Carpetizadas : '.$familias.'</p><p>Médico : '.$medico.'</p>';?>")

            <?php 
            $numero5++;
            } while ($row5 = mysqli_fetch_array($result5));
            } else {
            }
            ?>
 
        <?php
            /****** Areas de influencia del Establecimiento de salud *********/
            $numero4 = 0;
            $sql4 = " SELECT carpeta_familiar.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, nivel_establecimiento.nivel_establecimiento, tipo_establecimiento.tipo_establecimiento, ";
            $sql4.= " establecimiento_salud.latitud, establecimiento_salud.longitud, establecimiento_salud.idtipo_establecimiento FROM carpeta_familiar, establecimiento_salud, nivel_establecimiento, tipo_establecimiento  ";
            $sql4.= " WHERE carpeta_familiar.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND  establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento ";
            $sql4.= " AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento  AND establecimiento_salud.latitud !='' ";
            $sql4.= "  AND establecimiento_salud.longitud !='' AND carpeta_familiar.idmunicipio = '$idmunicipio' GROUP BY carpeta_familiar.idestablecimiento_salud  ";
            $result4 = mysqli_query($link,$sql4);
            $total4 = mysqli_num_rows($result4);
            if ($row4 = mysqli_fetch_array($result4)){
            mysqli_field_seek($result4,0);
            while ($field4 = mysqli_fetch_field($result4)){
            } do {
                ?>
        L.marker([<?php echo $row4[4];?>, <?php echo $row4[5];?>], {icon: 

<?php   
    switch ($row4[6]) {
        case 1:
            echo "Establecim";
            break;
        case 2:
            echo "Establecim";
            break;
        case 3:
            echo "Ambulatorio";
            break;
        case 4:
            echo "Internacion";
            break;
        case 5:
            echo "Integral";
            break;
        case 6:
            echo "Establecim";
            break;
        case 7:
            echo "Establecim";
            break;
        case 8:
            echo "Establecim";
            break;
        case 9:
            echo "Establecim";
            break;
        case 10:
            echo "Vecinal";
            break;
        case 11:
            echo "Hospital_gen";
            break;
        case 12:
            echo "Hospital_seg";
            break;
        case 13:
            echo "Establecim";
            break;
        case 14:
            echo "Establecim";
            break;
        case 15:
            echo "Establecim";
            break;
        case 16:
            echo "Establecim";
            break;
        case 17:
            echo "Establecim";
            break;
        case 18:
            echo "Puesto_salud";
            break;
        case 19:
            echo "Establecim";
            break;
        case 20:
            echo "Establecim";
            break;
    }  ?> 
        }).addTo(map).bindPopup("<?php echo '<p>Establecimiento : '.$row4[1].'</p><p>'.$row4[2].'</p><p>Tipo : '.$row4[3].'</p>';?>")
            <?php 
            $numero4++;
            } while ($row4 = mysqli_fetch_array($result4));
            } else {
            }
            ?>
    </script>

</body>

</html>
