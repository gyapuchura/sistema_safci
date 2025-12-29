<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");
$semana  = date("W");
$gestion    =  date("Y");

if ($semana == '01') {
    $semana_ep = '52';
} else {
    $semana_ep = $semana-1;
}

$idmunicipio = $_GET['idmunicipio'];

?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>REPORTE EPIDEMIOLOGICO SEMANAL MUNICIPIO - SAFCI</title>

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

                <div class="row">
                  </br>
                </div>
                    <!-- Page Heading -->

                    <h3 class="text-info">DESASTRES REPORTADOS A LA SEMANA EPIDEMIOLÓGICA. Nº <?php echo $semana_ep;?></h3>
                <div class="row">
                  </br>
                </div>

                    <?php
                    $numero=1;
                    $sql =" SELECT registro_evento_notificacion.idevento_notificacion, evento_notificacion.evento_notificacion FROM notificacion_ep, registro_evento_notificacion, evento_notificacion WHERE registro_evento_notificacion.idnotificacion_ep=notificacion_ep.idnotificacion_ep   ";
                    $sql.=" AND registro_evento_notificacion.idevento_notificacion=evento_notificacion.idevento_notificacion AND notificacion_ep.gestion='$gestion' AND notificacion_ep.estado='CONSOLIDADO' AND registro_evento_notificacion.numero_eventos !='0' ";
                    $sql.=" AND notificacion_ep.idmunicipio='$idmunicipio' GROUP BY registro_evento_notificacion.idevento_notificacion ORDER BY registro_evento_notificacion.idevento_notificacion  ";
                    $result = mysqli_query($link,$sql);
                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {
                    ?>

                    <div class="row">
                      <!-- begin reporte epidemiologico -->
                      <div class="col-xl-2 col-md-6 mb-4">
                          <div class="card border-left-info shadow h-100 py-2">
                              <div class="card-body">
                                  <div class="row no-gutters align-items-center">
                                      <div class="col mr-2">
                                                                    
                                         <a href="../implementacion_safci/marco_eventos_sala_mun.php?idevento_notificacion=<?php echo $row[0];?>&idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=800,scrollbars=YES,top=50,left=300'); return false;">
                                         <div class="text-xs font-weight-bold text-info text-uppercase mb-1"> 
                                         <?php echo $row[1];?>
                                         </div>
                                          </a> 
                                                                                    
                                          <div class="h5 mb-0 font-weight-bold text-gray-800">
                                          <?php 
                                            $sql_c =" SELECT sum(registro_evento_notificacion.numero_eventos) FROM registro_evento_notificacion, notificacion_ep WHERE registro_evento_notificacion.idnotificacion_ep=notificacion_ep.idnotificacion_ep    ";
                                            $sql_c.="  AND registro_evento_notificacion.idevento_notificacion='$row[0]' AND notificacion_ep.idmunicipio='$idmunicipio' AND registro_evento_notificacion.gestion='$gestion' AND notificacion_ep.estado='CONSOLIDADO'  ";
                                            $result_c = mysqli_query($link,$sql_c);
                                            $row_c = mysqli_fetch_array($result_c);
                                            $casos_semana   = number_format($row_c[0], 0, '.', '.');
                                            echo $casos_semana;?>
                                          </div>
                                        
                                      </div>
                                      <div class="col-auto">
                                        <a href="../implementacion_safci/mapa_eventos_mun.php?idevento_notificacion=<?php echo $row[0];?>&idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=850,scrollbars=YES,top=50,left=500'); return false;">
                                            <i class="fas fa-map fa-2x text-gray-300"></i>
                                        </a>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                    <!-- end reporte epidemiologico -->
                    </div>

                    <?php
            $numero=$numero+1;  
            }
            while ($row = mysqli_fetch_array($result));
            } else {
            }
            ?>

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