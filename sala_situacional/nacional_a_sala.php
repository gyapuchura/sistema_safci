<?php include("../cabf.php"); ?>
<?php include("../inc.config.php");
$gestion = date("Y");

$latitud_c  = "-17.567775";
$longitud_c = "-66.346216";
$zoom_c     = "6";

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

                        <h4 class="m-0 font-weight-bold text-primary">SALA SITUACIONAL DE SALUD NACIONAL</h4>
                        </br>
                        <?php
                        $sql_int =" SELECT count(idintegrante_cf) FROM integrante_cf WHERE estado='CONSOLIDADO' ";
                        $result_int = mysqli_query($link,$sql_int);
                        $row_int = mysqli_fetch_array($result_int);  
                        $integrantes = $row_int[0];

                        $integrantes_cf   = number_format($integrantes, 0, '.', '.');
                        ?>
                        <h6 class="m-0 font-weight-bold text-primary">N° DE HABITANTES CARPETIZADOS EN EL PAÍS = <?php echo $integrantes_cf;?></h6>

                        <?php
                        $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar WHERE estado='CONSOLIDADO'  ";
                        $result_cf = mysqli_query($link,$sql_cf);
                        $row_cf = mysqli_fetch_array($result_cf);  
                        $total_cf  = number_format($row_cf[0], 0, '.', '.');
                        ?>
                        <h6 class="m-0 font-weight-bold text-primary">TOTAL DE FAMILIAS CARPETIZADAS = <?php echo $total_cf;?></h6>



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
                                        <a href="../sala_situacional/estimacion_poblacion_nal.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1500,height=800,scrollbars=YES,top=50,left=100'); return false;">
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
                                        <a href="../carpetas_familiares/piramide_poblacional_nal.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=750,scrollbars=YES,top=50,left=100'); return false;">  
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
                                        <a href="../carpetas_familiares/grafica_defuncion_cf.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=580,scrollbars=YES,top=50,left=100'); return false;">
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
                                        <a href="../carpetas_familiares/salud_integrantes_grafica.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=800,scrollbars=YES,top=50,left=100'); return false;">
                                        <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                        ESTADO DE SALUD FAMILIAR</div>
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
                                    <a href="../carpetas_familiares/grafica_programa_social_cf.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=650,scrollbars=YES,top=50,left=100'); return false;">
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
                                        <a href="../produccion_servicios/atenciones_psafci_diarias.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=850,scrollbars=YES,top=50,left=400'); return false;">
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
                                        <a href="../administrar_sistema/reporte_ep_semanal_nal.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=600,height=900,scrollbars=YES,top=50,left=400'); return false;">
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
                                        <a href="../administrar_sistema/reporte_ep_desastres_nal.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=600,height=850,scrollbars=YES,top=50,left=400'); return false;">
                                        <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                           DESASTRES</div></a>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <a href="../implementacion_safci/mapa_desastres_safci.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=850,scrollbars=YES,top=50,left=400'); return false;">
                                            <i class="fas fa-map fa-2x text-gray-300"></i>
                                        </a>
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
                                <a href="../sala_situacional/mapa_nacional_eess.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1400,height=900,scrollbars=YES,top=50,left=400'); return false;">
                                     <div class="card bg-info text-white shadow">
                                       <div class="card-body">
                                            MAPA PARLANTE NACIONAL
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
                                        <a href="../seguimiento_familiar/reporte_riesgos_nal.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=850,scrollbars=YES,top=50,left=400'); return false;">
                                        <div class="text-xm font-weight-bold text-info text-uppercase mb-1">
                                         RIÉSGO PERSONAL NACIONAL</div></a>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <a href="../seguimiento_familiar/mapa_visitas_nal.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1400,height=1100,scrollbars=YES,top=50,left=400'); return false;">
                                            <i class="fas fa-map fa-2x text-gray-300"></i>
                                        </a>
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
                                        <a href="../seguimiento_familiar/visitas_safci_diarias_nal.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1280,height=900,scrollbars=YES,top=50,left=400'); return false;">
                                        <div class="text-xm font-weight-bold text-danger text-uppercase mb-1">
                                           VISITAS DIARIAS - NACIONAL</div></a>
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
                                        <a href="../carpetas_familiares/avance_carpetas_familiares_nal.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=900,scrollbars=YES,top=50,left=100'); return false;">
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
                                        <a href="../carpetas_familiares/riesgo_determinante_salud_nal.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=600,scrollbars=YES,top=50,left=100'); return false;">
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
                                    <a href="../carpetas_familiares/grafica_socioeconomica_cf.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=700,scrollbars=YES,top=50,left=100'); return false;">
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
                                    <a href="../carpetas_familiares/grafica_pertenencia_cultural_cf.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=950,height=700,scrollbars=YES,top=50,left=100'); return false;">
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
                                    <a href="../gestion_participativa/imprime_reporte_gp.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=860,scrollbars=YES,top=50,left=100'); return false;">                                        
                                    <div class="text-xm font-weight-bold text-success text-uppercase mb-1">
                                        ÁREA INTERSECTORIAL</div>
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

        var lyr_streets   = L.tileLayer(mapbox_url, {id: 'safci', maxZoom: 18, tileSize: 512, zoomOffset: -1, attribution: mapbox_attribution});
        var lyr_satellite = L.tileLayer(esri_url, {id: 'safci', maxZoom: 19, tileSize: 512, zoomOffset: -1, attribution: esri_attribution});
        var marker = L.marker([<?php echo $latitud_c;?>, <?php echo $longitud_c;?>]).bindPopup('<?php echo " ESTADO PLURINACIONAL DE BOLIVIA";?>');

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
$numero2 = 0;
$sql2 = " SELECT establecimiento_salud.idmunicipio, municipios.municipio FROM establecimiento_salud, municipios  ";
$sql2.= " WHERE establecimiento_salud.idmunicipio=municipios.idmunicipio AND establecimiento_salud.latitud != '' ";
$sql2.= " AND establecimiento_salud.longitud != '' GROUP BY establecimiento_salud.idmunicipio ";
$result2 = mysqli_query($link,$sql2);
$total2 = mysqli_num_rows($result2);
 if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {

$sql3 = " SELECT idestablecimiento_salud, latitud, longitud FROM establecimiento_salud WHERE latitud != '' AND longitud != '' AND idmunicipio='$row2[0]' LIMIT 1 ";
$result3 = mysqli_query($link,$sql3);
$row3 = mysqli_fetch_array($result3);



?>

        L.marker([<?php echo $row3[1];?>, <?php echo $row3[2];?>]).addTo(map).bindPopup("<?php echo '<p>Municipio: '.$row2[1].'</p>';?>")

<?php 
$numero2++;
if ($numero2 == $total2) {
echo "";
}
else {
echo ",";
}
} while ($row2 = mysqli_fetch_array($result2));
} else {
echo "";
/*
Si no se encontraron resultados
*/
}
?>

      

    </script>

</body>

</html>
