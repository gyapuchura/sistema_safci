<?php include("../cabf.php"); ?>
<?php include("../inc.config.php");
$gestion = date("Y");

$iddepartamento = $_GET['iddepartamento'];

$sql_cord = " SELECT carpeta_familiar.iddepartamento, ubicacion_cf.latitud, ubicacion_cf.longitud ";
$sql_cord.= " FROM carpeta_familiar, ubicacion_cf WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
$sql_cord.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' ORDER BY carpeta_familiar.iddepartamento DESC LIMIT 1 ";
$result_cord = mysqli_query($link,$sql_cord);
$row_cord = mysqli_fetch_array($result_cord);


$sql_dep = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento'  ";
$result_dep = mysqli_query($link,$sql_dep);
$row_dep = mysqli_fetch_array($result_dep);

$latitud_c  = $row_cord[1];
$longitud_c = $row_cord[2];
$zoom_c     = "7";
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
                        <h2 class="m-0 font-weight-bold text-info">DEPARTAMENTO : <?php echo mb_strtoupper($row_dep[1]);?></h2>
                        </br>
                        <?php
                        $sql_int =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                        $sql_int.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' ";
                        $result_int = mysqli_query($link,$sql_int);
                        $row_int = mysqli_fetch_array($result_int);  
                        $integrantes = $row_int[0];

                        $integrantes_cf   = number_format($integrantes, 0, '.', '.');
                        ?>
                        <h6 class="m-0 font-weight-bold text-primary">N° DE HABITANTES CARPETIZADOS EN EL DEPARTAMENTO = <?php echo $integrantes_cf;?></h6>

                        <?php
                        $sql_mun =" SELECT idmunicipio FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND iddepartamento='$iddepartamento' GROUP BY idmunicipio  ";
                        $result_mun = mysqli_query($link,$sql_mun);
                        $municipios = mysqli_num_rows($result_mun);  
                        ?>
                        <h6 class="m-0 font-weight-bold text-primary">N° DE MUNICIPIOS CON COBERTURA SAFCI EN EL DEPARTAMENTO = <?php echo $municipios;?></h6>

                        <?php
                        $sql_dep =" SELECT idestablecimiento_salud FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND iddepartamento='$iddepartamento' GROUP BY idestablecimiento_salud  ";
                        $result_dep = mysqli_query($link,$sql_dep);
                        $establecimientos = mysqli_num_rows($result_dep);  
                        ?>
                        <h6 class="m-0 font-weight-bold text-primary">N° DE ESTABLECIMIENTOS DE SALUD EN EL DEPARTAMENTO = <?php echo $establecimientos;?></h6>

                        <?php
                        $sql_af =" SELECT idarea_influencia FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND iddepartamento='$iddepartamento' ";
                        $sql_af.=" GROUP BY idarea_influencia ";
                        $result_af = mysqli_query($link,$sql_af);
                        $row_af = mysqli_num_rows($result_af);  
                        $areas_influencia = $row_af;
                        ?>
                        <h6 class="m-0 font-weight-bold text-primary">N° DE ÁREAS DE INFLUENCIA EN EL DEPARTAMENTO = <?php echo $areas_influencia;?></h6>                  


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
                                        <a href="../sala_situacional/estimacion_poblacion_depto.php?iddepartamento=<?php echo $iddepartamento;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1500,height=800,scrollbars=YES,top=50,left=100'); return false;">
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
                                        <a href="../carpetas_familiares/piramide_poblacional_deptal.php?iddepartamento=<?php echo $iddepartamento;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=750,scrollbars=YES,top=50,left=100'); return false;">  
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
                                        <a href="../carpetas_familiares/grafica_defuncion_cf_dep.php?iddepartamento=<?php echo $iddepartamento;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=580,scrollbars=YES,top=50,left=100'); return false;">
                                        <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                        MORTALIDAD</div>
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
                                        <a href="../carpetas_familiares/salud_integrantes_grafica_dep.php?iddepartamento=<?php echo $iddepartamento;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=800,scrollbars=YES,top=50,left=100'); return false;">
                                        <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                        MORBILIDAD</div>
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
                                    <a href="../carpetas_familiares/grafica_programa_social_cf_dep.php?iddepartamento=<?php echo $iddepartamento;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=650,scrollbars=YES,top=50,left=100'); return false;">
                                    <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                    MONITOREO DE PROGRAMAS NACIONALES</div>
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
                                        <a href="../produccion_servicios/atenciones_psafci_diarias_dep.php?iddepartamento=<?php echo $iddepartamento;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=850,scrollbars=YES,top=50,left=400'); return false;">
                                        <div class="text-xm font-weight-bold text-primary text-uppercase mb-1">
                                        MONITOREO ATENCIONES MÉDICAS PSAFCI</div></a>
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
                                        <a href="../administrar_sistema/reporte_ep_semanal_dep.php?iddepartamento=<?php echo $iddepartamento;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=600,height=900,scrollbars=YES,top=50,left=400'); return false;">
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
                                        <a href="../administrar_sistema/reporte_ep_desastres_dep.php?iddepartamento=<?php echo $iddepartamento;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=400,height=750,scrollbars=YES,top=50,left=400'); return false;">
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
                                    <div class="card bg-info text-white shadow">
                                        <div class="card-body">
                                            MAPA PARLANTE
                                        </div>
                                    </div>
                                </div>
                    <!-------- MAPA PARLANTE begin ------>

                    <div id="mi_mapa" style="width: 100%; height: 680px;"></div>

<hr>
                    <div class="col-xl-12 col-md-3 mb-2">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <a href="../seguimiento_familiar/reporte_riesgos_dep.php?iddepartamento=<?php echo $iddepartamento;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=850,scrollbars=YES,top=50,left=400'); return false;">
                                        <div class="text-xm font-weight-bold text-info text-uppercase mb-1">
                                         RIÉSGO PERSONAL</div></a>
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
                                        <a href="../seguimiento_familiar/visitas_safci_diarias_dep.php?iddepartamento=<?php echo $iddepartamento;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1280,height=900,scrollbars=YES,top=50,left=400'); return false;">
                                        <div class="text-xm font-weight-bold text-danger text-uppercase mb-1">
                                           VISITAS DIARIAS - DEPARTAMENTO</div></a>
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
                                        <a href="avance_carpetas_familiares_dep.php?iddepartamento=<?php echo $iddepartamento;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=900,scrollbars=YES,top=50,left=100'); return false;">
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
                                        <a href="../carpetas_familiares/monitoreo_determinantes_cf_dep.php?iddepartamento=<?php echo $iddepartamento;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=600,scrollbars=YES,top=50,left=100'); return false;">
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
                                    <a href="../carpetas_familiares/grafica_socioeconomica_cf_dep.php?iddepartamento=<?php echo $iddepartamento;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=700,scrollbars=YES,top=50,left=100'); return false;">
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
                                    <a href="../carpetas_familiares/grafica_pertenencia_cultural_cf_dep.php?iddepartamento=<?php echo $iddepartamento;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=950,height=700,scrollbars=YES,top=50,left=100'); return false;">
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

        $sql =" SELECT idgestion_participativa FROM gestion_participativa WHERE iddepartamento = '$iddepartamento' LIMIT 1 ";
        $result = mysqli_query($link,$sql);
        if ($row = mysqli_fetch_array($result)){
        mysqli_field_seek($result,0);
        while ($field = mysqli_fetch_field($result)){
        } do {
        ?>
            <a href="gestion_participativa_sala_dep.php?iddepartamento=<?php echo $iddepartamento;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=860,scrollbars=YES,top=50,left=100'); return false;">                                        
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

    
    <script>


        let map = L.map('mi_mapa').setView([<?php echo $latitud_c;?>, <?php echo $longitud_c;?>], <?php echo $zoom_c;?>)

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

<?php 
$numero2 = 0;
$sql2 = " SELECT establecimiento_salud.idmunicipio, municipios.municipio FROM establecimiento_salud, municipios  ";
$sql2.= " WHERE establecimiento_salud.idmunicipio=municipios.idmunicipio AND establecimiento_salud.latitud != '' ";
$sql2.= " AND establecimiento_salud.longitud != '' AND establecimiento_salud.iddepartamento='$iddepartamento' GROUP BY establecimiento_salud.idmunicipio ";
$result2 = mysqli_query($link,$sql2);
$total2 = mysqli_num_rows($result2);
 if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {

$sql3 = " SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.latitud, establecimiento_salud.longitud,  ";
$sql3.= " municipios.municipio, departamento.departamento FROM establecimiento_salud, municipios, departamento ";
$sql3.= " WHERE establecimiento_salud.idmunicipio=municipios.idmunicipio AND establecimiento_salud.iddepartamento=departamento.iddepartamento ";
$sql3.= " AND establecimiento_salud.latitud != '' AND establecimiento_salud.longitud != '' AND establecimiento_salud.idmunicipio='$row2[0]' ORDER BY establecimiento_salud.idestablecimiento_salud DESC LIMIT 1 ";
$result3 = mysqli_query($link,$sql3);
$row3 = mysqli_fetch_array($result3);
?>

        L.marker([<?php echo $row3[1];?>, <?php echo $row3[2];?>]).addTo(map).bindPopup("<?php echo 'Municipio: '.$row2[1];?>")

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
