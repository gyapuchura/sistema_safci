<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$sqlus =" SELECT nombre, paterno, materno FROM nombre WHERE idnombre='$idnombre_ss'";
$resultus = mysqli_query($link,$sqlus);
$rowus = mysqli_fetch_array($resultus);
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
  

                <div class="card shadow mb-8">
                    <div class="card-header py-6">
                        <h6 class="m-0 font-weight-bold text-primary"></h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <img src="../img/fondo_inicio_safci.jpg" class="rounded" alt="Eniun">
                        </div>
                    </div>
                </div>
<!---- begin  reporte con fromato ----->
<hr>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h6 class="text-primary">
                        REPORTE DEL DIA DE HOY <?php 
                    $fecha_r = explode('-',$fecha);
                    $f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];
                    echo $f_emision;?>
                        </h6>
                    </div>

<div class="row">

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-2 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Nº DE INGRESOS AL SISTEMA</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                    <?php
                    $sql_l =" SELECT COUNT(idlog_login) FROM log_login WHERE fecha='$fecha' ";
                    $result_l = mysqli_query($link,$sql_l);
                    $row_l = mysqli_fetch_array($result_l);
                    $ingresos_medi_safci = $row_l[0];
                    echo $ingresos_medi_safci;
                    ?>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-2 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <a href="reporte_ep_semanal.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=700,height=600,scrollbars=YES,top=50,left=600'); return false;">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Nº DE NOTIFICACIONES (F302A)
                    </div></a>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                    <?php
                    $sql_d =" SELECT count(idnotificacion_ep) FROM notificacion_ep WHERE estado='CONSOLIDADO' AND fecha_registro='$fecha'  ";
                    $result_d = mysqli_query($link,$sql_d);
                    $row_d = mysqli_fetch_array($result_d);
                    $notificaciones_ep_hoy = $row_d[0];
                    echo $notificaciones_ep_hoy;
                    ?>
                    </div>
                   
                </div>
                <div class="col-auto">
                    <i class="fas fa-hospital fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-2 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                    N° FICHAS EPIDEMIOLOGICAS:</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                    <?php
                    $sql_f =" SELECT COUNT(idficha_ep) FROM ficha_ep WHERE fecha_registro='$fecha' ";
                    $result_f = mysqli_query($link,$sql_f);
                    $fichas_ep_hoy = mysqli_num_rows($result_f);
                    echo $fichas_ep_hoy;
                    ?>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-2 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                    N° SEGUIMIENTO A PACIENTES (FICHAS EPIDEMIOLÓGICAS)::</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                    <?php
                    $sql_p =" SELECT idseguimiento_ep FROM seguimiento_ep WHERE fecha_registro='$fecha'";
                    $result_p = mysqli_query($link,$sql_p);
                    $fichas_paciente = mysqli_num_rows($result_p);
                    echo $fichas_paciente;
                    ?>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-2 col-md-6 mb-4">
    <div class="card border-left-secondary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                    NUEVAS ÁREAS DE INFLUENCIA REGISTRADAS:</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                    <?php
                        $sql_2 = " SELECT count(idarea_influencia) FROM area_influencia WHERE fecha_registro='$fecha' ";
                        $result_2 = mysqli_query($link,$sql_2);           
                        $row_2 = mysqli_fetch_array($result_2); 
                        echo $row_2[0];
                    ?>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Requests Card Example -->
<div class="col-xl-2 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Nº DE CARPETAS FAMILIARES</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                    <?php
                    $sql_cf =" SELECT COUNT(idcarpeta_familiar) FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND fecha_registro='$fecha' ";
                    $result_cf = mysqli_query($link,$sql_cf);
                    $row_cf = mysqli_fetch_array($result_cf);
                    $carpetas_familiares = $row_cf[0];
                    echo $carpetas_familiares;
                    ?>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-file fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!---- end reporte con formato ----->

<!---- begin reporte con formato 2 ----->
<div class="row">

<!-- % de carpetizacion departamento BENI -->
<div class="col-xl-2 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">% CARPETIZACIÓN EN BENI:
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                            <?php
                                $sql_f =" SELECT sum(familias) FROM area_influencia WHERE iddepartamento='1' ";   
                                $result_f = mysqli_query($link,$sql_f);
                                $row_f = mysqli_fetch_array($result_f);
                                $meta_cf= $row_f[0];

                                $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar  WHERE estado='CONSOLIDADO' AND iddepartamento='1'  ";
                                $result_cf = mysqli_query($link,$sql_cf);
                                $row_cf = mysqli_fetch_array($result_cf);  
                                $carpetizacion  = $row_cf[0];

                                $p_departamento   = ($carpetizacion*100)/$meta_cf;
                                $p_beni    = number_format($p_departamento, 2, '.', '');
                                echo $p_beni;
                            ?> %
                            </div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar"
                                    style="width: <?php echo $p_beni;?>%" aria-valuenow="50" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- % de carpetizacion departamento  CBBA -->
<div class="col-xl-2 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">% CARPETIZACIÓN EN COCHABAMBA:
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                            <?php
                                $sql_f =" SELECT sum(familias) FROM area_influencia WHERE iddepartamento='2' ";   
                                $result_f = mysqli_query($link,$sql_f);
                                $row_f = mysqli_fetch_array($result_f);
                                $meta_cf= $row_f[0];

                                $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar  WHERE estado='CONSOLIDADO' AND iddepartamento='2'  ";
                                $result_cf = mysqli_query($link,$sql_cf);
                                $row_cf = mysqli_fetch_array($result_cf);  
                                $carpetizacion  = $row_cf[0];

                                $p_departamento   = ($carpetizacion*100)/$meta_cf;
                                $p_beni    = number_format($p_departamento, 2, '.', '');
                                echo $p_beni;
                            ?> %
                            </div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar"
                                    style="width: <?php echo $p_beni;?>%" aria-valuenow="50" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- % de carpetizacion departamento  CHUQUISACA -->
<div class="col-xl-2 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">% CARPETIZACIÓN EN CHUQUISACA:
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                            <?php
                                $sql_f =" SELECT sum(familias) FROM area_influencia WHERE iddepartamento='3' ";   
                                $result_f = mysqli_query($link,$sql_f);
                                $row_f = mysqli_fetch_array($result_f);
                                $meta_cf= $row_f[0];

                                $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar  WHERE estado='CONSOLIDADO' AND iddepartamento='3'  ";
                                $result_cf = mysqli_query($link,$sql_cf);
                                $row_cf = mysqli_fetch_array($result_cf);  
                                $carpetizacion  = $row_cf[0];

                                $p_departamento   = ($carpetizacion*100)/$meta_cf;
                                $p_beni    = number_format($p_departamento, 2, '.', '');
                                echo $p_beni;
                            ?> %
                            </div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar"
                                    style="width: <?php echo $p_beni;?>%" aria-valuenow="50" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- % de carpetizacion departamento  LA PAZ -->
<div class="col-xl-2 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">% CARPETIZACIÓN EN LA PAZ:
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                            <?php
                                $sql_f =" SELECT sum(familias) FROM area_influencia WHERE iddepartamento='4' ";   
                                $result_f = mysqli_query($link,$sql_f);
                                $row_f = mysqli_fetch_array($result_f);
                                $meta_cf= $row_f[0];

                                $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar  WHERE estado='CONSOLIDADO' AND iddepartamento='4'  ";
                                $result_cf = mysqli_query($link,$sql_cf);
                                $row_cf = mysqli_fetch_array($result_cf);  
                                $carpetizacion  = $row_cf[0];

                                $p_departamento   = ($carpetizacion*100)/$meta_cf;
                                $p_beni    = number_format($p_departamento, 2, '.', '');
                                echo $p_beni;
                            ?> %
                            </div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar"
                                    style="width: <?php echo $p_beni;?>%" aria-valuenow="50" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- % de carpetizacion departamento  ORURO -->
<div class="col-xl-2 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">% CARPETIZACIÓN EN ORURO:
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                            <?php
                                $sql_f =" SELECT sum(familias) FROM area_influencia WHERE iddepartamento='5' ";   
                                $result_f = mysqli_query($link,$sql_f);
                                $row_f = mysqli_fetch_array($result_f);
                                $meta_cf= $row_f[0];

                                $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar  WHERE estado='CONSOLIDADO' AND iddepartamento='5'  ";
                                $result_cf = mysqli_query($link,$sql_cf);
                                $row_cf = mysqli_fetch_array($result_cf);  
                                $carpetizacion  = $row_cf[0];

                                $p_departamento   = ($carpetizacion*100)/$meta_cf;
                                $p_beni    = number_format($p_departamento, 2, '.', '');
                                echo $p_beni;
                            ?> %
                            </div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar"
                                    style="width: <?php echo $p_beni;?>%" aria-valuenow="50" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- % de carpetizacion departamento  PANDO -->
<div class="col-xl-2 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">% CARPETIZACIÓN EN PANDO:
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                            <?php
                                $sql_f =" SELECT sum(familias) FROM area_influencia WHERE iddepartamento='6' ";   
                                $result_f = mysqli_query($link,$sql_f);
                                $row_f = mysqli_fetch_array($result_f);
                                $meta_cf= $row_f[0];

                                $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar  WHERE estado='CONSOLIDADO' AND iddepartamento='6'  ";
                                $result_cf = mysqli_query($link,$sql_cf);
                                $row_cf = mysqli_fetch_array($result_cf);  
                                $carpetizacion  = $row_cf[0];

                                $p_departamento   = ($carpetizacion*100)/$meta_cf;
                                $p_beni    = number_format($p_departamento, 2, '.', '');
                                echo $p_beni;
                            ?> %
                            </div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar"
                                    style="width: <?php echo $p_beni;?>%" aria-valuenow="50" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

</div>



<div class="row">

<!-- % de carpetizacion departamento  POTOSI -->
<div class="col-xl-2 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">% CARPETIZACIÓN EN POTOSI:
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                            <?php
                                $sql_f =" SELECT sum(familias) FROM area_influencia WHERE iddepartamento='7' ";   
                                $result_f = mysqli_query($link,$sql_f);
                                $row_f = mysqli_fetch_array($result_f);
                                $meta_cf= $row_f[0];

                                $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar  WHERE estado='CONSOLIDADO' AND iddepartamento='7'  ";
                                $result_cf = mysqli_query($link,$sql_cf);
                                $row_cf = mysqli_fetch_array($result_cf);  
                                $carpetizacion  = $row_cf[0];

                                $p_departamento   = ($carpetizacion*100)/$meta_cf;
                                $p_beni    = number_format($p_departamento, 2, '.', '');
                                echo $p_beni;
                            ?> %
                            </div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar"
                                    style="width: <?php echo $p_beni;?>%" aria-valuenow="50" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- % de carpetizacion departamento  SANTA CRUZ -->
<div class="col-xl-2 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">% CARPETIZACIÓN EN SANTA CRUZ:
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                            <?php
                                $sql_f =" SELECT sum(familias) FROM area_influencia WHERE iddepartamento='8' ";   
                                $result_f = mysqli_query($link,$sql_f);
                                $row_f = mysqli_fetch_array($result_f);
                                $meta_cf= $row_f[0];

                                $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar  WHERE estado='CONSOLIDADO' AND iddepartamento='8'  ";
                                $result_cf = mysqli_query($link,$sql_cf);
                                $row_cf = mysqli_fetch_array($result_cf);  
                                $carpetizacion  = $row_cf[0];

                                $p_departamento   = ($carpetizacion*100)/$meta_cf;
                                $p_beni    = number_format($p_departamento, 2, '.', '');
                                echo $p_beni;
                            ?> %
                            </div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar"
                                    style="width: <?php echo $p_beni;?>%" aria-valuenow="50" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- % de carpetizacion departamento  TARIJA -->
<div class="col-xl-2 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">% CARPETIZACIÓN EN TARIJA:
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                            <?php
                                $sql_f =" SELECT sum(familias) FROM area_influencia WHERE iddepartamento='9' ";   
                                $result_f = mysqli_query($link,$sql_f);
                                $row_f = mysqli_fetch_array($result_f);
                                $meta_cf= $row_f[0];

                                $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar  WHERE estado='CONSOLIDADO' AND iddepartamento='9'  ";
                                $result_cf = mysqli_query($link,$sql_cf);
                                $row_cf = mysqli_fetch_array($result_cf);  
                                $carpetizacion  = $row_cf[0];

                                $p_departamento   = ($carpetizacion*100)/$meta_cf;
                                $p_beni    = number_format($p_departamento, 2, '.', '');
                                echo $p_beni;
                            ?> %
                            </div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar"
                                    style="width: <?php echo $p_beni;?>%" aria-valuenow="50" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- % de carpetizacion NACIONAL -->
<div class="col-xl-2 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">% CARPETIZACIÓN NACIONAL:
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                            <?php
                                $sql_f =" SELECT sum(familias) FROM area_influencia ";   
                                $result_f = mysqli_query($link,$sql_f);
                                $row_f = mysqli_fetch_array($result_f);
                                $meta_cf= $row_f[0];

                                $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar  WHERE estado='CONSOLIDADO'  ";
                                $result_cf = mysqli_query($link,$sql_cf);
                                $row_cf = mysqli_fetch_array($result_cf);  
                                $carpetizacion  = $row_cf[0];

                                $p_departamento   = ($carpetizacion*100)/$meta_cf;
                                $p_beni    = number_format($p_departamento, 2, '.', '');
                                echo $p_beni;
                            ?> %
                            </div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-warning" role="progressbar"
                                    style="width: <?php echo $p_beni;?>%" aria-valuenow="50" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-file fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>


</div>
<!---- end reporte con formato 2 ----->
    </div>
<!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

    <!-- scripts para calendario -->
   
</body>

</html>
