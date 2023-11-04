
<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idarea_influencia_ss = $_SESSION['idarea_influencia_ss'];

$sql = " SELECT idarea_influencia, iddepartamento, idred_salud, idestablecimiento_salud, idtipo_area_influencia, area_influencia, ";
$sql.= " idnacion, habitantes, familias, distancia, latitud, longitud, fecha_registro, idusuario";
$sql.= " FROM area_influencia WHERE idarea_influencia='$idarea_influencia_ss' ";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);

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
    <link rel="stylesheet" href="../css/jquery-ui.min.css">

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
  
                <body class="bg-gradient-primary">

    <div class="container">
    </br>
        <div class="card o-hidden border-0 shadow-lg my-2">
            <div class="card-body p-0">
<!-- BEGIN aqui va el TITULO de la pagina ---->
                <div class="row">
                    <div class="col-lg-12">
                    <div class="p-3">               
                    <div class="text-center">                     
                    <hr>   
                    <a href="areas_influencia.php">VOLVER</a> 
                    <hr>
                    <h6 class="text-primary">ÁREA DE INFLUENCIA</h6>
                    <h4 class="text-muted">
                    <?php 
                    $sql_i    = " SELECT idtipo_area_influencia, tipo_area_influencia FROM tipo_area_influencia WHERE idtipo_area_influencia='$row[4]' ";
                    $result_i = mysqli_query($link,$sql_i);
                    $row_i    = mysqli_fetch_array($result_i);
                    echo $row_i[1];?> : <?php echo $row[5];?></h4>                 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

        <form name="INFLUENCIA" action="guarda_area_influencia.php" method="post">  
                <div class="col-lg-12">  
                    <div class="p-5"> 

                    <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">DEPARTAMENTO:</h6>
                    </div>
                    <div class="col-sm-9">

                    <select name="iddepartamento"  id="iddepartamento" class="form-control" required disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT iddepartamento, departamento FROM departamento ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row[1]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>
                    </div>
                </div>
   
                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">RED DE SALUD:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idred_salud"  id="idred_salud" class="form-control" required disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idred_salud, red_salud FROM red_salud ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row[2]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">ESTABLECIMIENTO DE SALUD:</h6>
                    </div>
                    <div class="col-sm-9">

                    <select name="idestablecimiento_salud"  id="idestablecimiento_salud" class="form-control" required disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row[3]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>
                    </div>
                </div>

                <hr>
                <div class="form-group row">                               
                    <div class="col-sm-4">
                    <h6 class="text-primary">TIPO DE ÁREA DE INFLUENCIA:</h6>

                    <select name="idtipo_area_influencia"  id="idtipo_area_influencia" class="form-control" required disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idtipo_area_influencia, tipo_area_influencia FROM tipo_area_influencia ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row[4]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>
                    
                    </div>
                    <div class="col-sm-8">
                    <h6 class="text-primary">NOMBRE O DENOMINACIÓN:</h6>
                    <textarea class="form-control" rows="2" name="area_influencia" disabled><?php echo $row[5]?></textarea>
                    </div>
                </div>

                
                <?php
                           if ($row[4] =='1') {
                            ?>
                            <div class="form-group row">                                
                                <div class="col-sm-12">
                                <h6 class="text-primary">NACIÓN:</h6>
                                <select name="idnacion"  id="idnacion" class="form-control" disabled >
                                    <option selected>Seleccione</option>
                                    <?php
                                    $sqlv = " SELECT idnacion, nacion FROM nacion ";
                                    $resultv = mysqli_query($link,$sqlv);
                                    if ($rowv = mysqli_fetch_array($resultv)){
                                    mysqli_field_seek($resultv,0);
                                    while ($fieldv = mysqli_fetch_field($resultv)){
                                    } do {
                                    ?>
                                    <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row[6]) echo "selected";?> ><?php echo $rowv[1];?></option>
                                    <?php
                                    } while ($rowv = mysqli_fetch_array($resultv));
                                    } else {
                                    }
                                    ?>
                                </select>
                                </div>
                            </div>
                            <?php
                           } else {
                            
                           }
                           ?>


                <hr>

                <div class="form-group row">                               
                    <div class="col-sm-4">
                    <h6 class="text-primary">CANTIDAD DE HABITANTES (Según lista de afiliados):</h6>
                        <input type="text" class="form-control" 
                        value="<?php echo $row[7];?>" name="habitantes" disabled>
                    </div>
                    <div class="col-sm-4">
                    <h6 class="text-primary">NÚMERO DE FAMILIAS (Según lista de afiliados):</h6>
                        <input type="text" class="form-control" 
                        value="<?php echo $row[8];?>" name="familias" disabled>                
                    </div>
                    <div class="col-sm-4">
                    <h6 class="text-primary">DISTANCIA HACIA EL ESTABLECIMIENTO DE SALUD EN Km (Vía Terrestre):</h6>
                        <input type="text" class="form-control" 
                        value="<?php echo $row[9];?>" name="distancia" disabled>                
                    </div>
                </div>
                        <hr>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <h4 class="text-primary">UBICACIÓN GEOGRÁFICA CENTRAL DEL ÁREA DE INFLUENCIA</h4>
                    </div>
                </div>   
                <div class="form-group row">
                    <div class="col-sm-6">
                        <h6 class="text-primary">LATITUD</h6>
                        <input type="NUMBER" name="latitud" class="form-control" value="<?php echo $row[10];?>" disabled>
                    </div>
                    <div class="col-sm-6">
                        <h6 class="text-primary">LONGITUD</h6>
                        <input type="number"  name="longitud" class="form-control" value="<?php echo $row[11];?>" disabled>
                       <!-- <input type="number" style="display:none" id="COD_MUN" readonly="readonly" > --->
                    </div>
                </div>   
                <hr>
                
    <!-------- begin rejilla --------->   
                <div class="form-group row">
                    <div class="col-sm-6">

                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>
    <!-------- end rejilla --------->                      
                <div class="text-center">
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <a href="nueva_area_influencia.php" class="btn btn-success">SALIR DE REGISTRO </a>
                        </div>
                        <div class="col-sm-3">                       
                        </div>
                        <div class="col-sm-3">                       
                       </div>
                        <div class="col-sm-3">

                        <?php
                            if ($perfil_ss == 'ADMINISTRADOR' || $perfil_ss == 'ADM-MUNICIPAL' || $perfil_ss == 'ADM-ESTABLECIMIENTO' ) {
                            ?>  
                        <a href="editar_area_influencia.php" class="btn btn-warning">MODIFICAR REGISTRO</a>
                        <?php
                            } else {
                            }
                            ?> 



                        </div>
                    </div>                               
                </div>           
                
                <div class="form-group row">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                    </div>
                </div>                  
                    
<!-- END aqui va el comntenido de la pagina ---->
                </div>
               
                <div class="text-center">
                <hr>
                    <a class="small" href="#">PROGRAMA SAFCI - MI SALUD</a>
                </div>
                <div class="text-center">
                    <a class="small" href="#">Ministerio de Salud y Deportes</a>
                <hr>
                </div>
               
            </div>   
        </div> 
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
                    <a class="btn btn-primary" href="../salir.php">Salir de Sistema</a>
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

    <script type="text/javascript" src="../js/localizacion.js"></script>
    <script type="text/javascript" src="../js/initMap.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwC0dKzZNKNbnzsslPYLNSExYd8uLqRIk&callback=initMap"></script>

    <!-- scripts para calendario -->
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
        <script>$("#fecha1").datepicker($.datepicker.regional[ "es" ]);</script>

        <script language="javascript">
        $(document).ready(function(){
        $("#idtipo_area_influencia").change(function () {
                    $("#idtipo_area_influencia option:selected").each(function () {
                        tipo_area_influencia=$(this).val();
                    $.post("nacion.php", {tipo_area_influencia:tipo_area_influencia}, function(data){
                    $("#nacion").html(data);
                    });
                });
        })
        });
        </script>

</body>

</html>
