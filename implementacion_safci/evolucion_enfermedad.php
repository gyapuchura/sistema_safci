
<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	   = date("Ymd");
$fecha 	       = date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$iddepartamento_ss          = $_SESSION['iddepartamento_ss'];
$idred_salud_ss             = $_SESSION['idred_salud_ss'];
$idmunicipio_ss             = $_SESSION['idmunicipio_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idnotificacion_ep_ss       = $_SESSION['idnotificacion_ep_ss'];
$idregistro_enfermedad_ss   = $_SESSION['idregistro_enfermedad_ss'];
$idficha_ep_ss              = $_SESSION['idficha_ep_ss'];
$idsospecha_diag_ss         = $_SESSION['idsospecha_diag_ss'];
$idgrupo_etareo_ss          = $_SESSION['idgrupo_etareo_ss'];
$idgenero_ss                = $_SESSION['idgenero_ss'];

$idseguimiento_ep_ss        = $_SESSION['idseguimiento_ep_ss'];

$sql = " SELECT ficha_ep.idficha_ep, ficha_ep.codigo, nombre.ci, nombre.nombre, nombre.paterno, nombre.materno, nombre.fecha_nac, ficha_ep.celular, ficha_ep.direccion, ficha_ep.latitud, ficha_ep.longitud, ficha_ep.idnombre, ficha_ep.idsospecha_diag ";
$sql.= " FROM ficha_ep, registro_enfermedad, notificacion_ep, nombre WHERE ficha_ep.idregistro_enfermedad=registro_enfermedad.idregistro_enfermedad ";
$sql.= " AND registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND ficha_ep.idnombre=nombre.idnombre ";
$sql.= " AND registro_enfermedad.idregistro_enfermedad='$idregistro_enfermedad_ss' AND ficha_ep.idficha_ep='$idficha_ep_ss' ";
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
                    <a href="fichas_ep_establecimiento.php">VOLVER</a> 
                    <hr>
                    <h4 class="text-primary">EVOLUCIÓN DE LA ENFERMEDAD</h4>
                    <h4 class="text-muted"><?php echo $row[1];?></h4>                    
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

                <div class="col-lg-12">  
                    <div class="p-5"> 
                    <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">REGISTRO EPIDEMIOLÓGICO:</h6>
                    </div>
                    <div class="col-sm-9">

                    <input type="hidden" name="idnombre_ep" value="<?php echo $row[11];?>">

                    <select name="idsospecha_diag"  id="idsospecha_diag" class="form-control" disabled >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$idsospecha_diag_ss) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-primary">DEPARTAMENTO:</h6>
                    </div>
                    <div class="col-sm-9">

                    <select name="iddepartamento"  id="iddepartamento" class="form-control" disabled >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT iddepartamento, departamento FROM departamento ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$iddepartamento_ss) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <select name="idred_salud"  id="idred_salud" class="form-control" disabled >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idred_salud, red_salud FROM red_salud ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$idred_salud_ss) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-primary">MUNICIPIO:</h6>
                    </div>
                    <div class="col-sm-9">

                    <select name="idmunicipio"  id="idmunicipio" class="form-control" disabled >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idmunicipio, municipio FROM municipios ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$idmunicipio_ss) echo "selected";?> ><?php echo $rowv[1];?></option>
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

                    <select name="idestablecimiento_salud"  id="idestablecimiento_salud" class="form-control" disabled >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$idestablecimiento_salud_ss) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-primary">GRUPO ETAREO DEL PACIENTE:</h6>
                    </div>
                    <div class="col-sm-9">

                    <select name="idgrupo_etareo"  id="idgrupo_etareo" class="form-control" disabled >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idgrupo_etareo, grupo_etareo FROM grupo_etareo ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$idgrupo_etareo_ss) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-primary">GÉNERO DEL PACIENTE:</h6>
                    </div>
                    <div class="col-sm-9">

                    <select name="idgenero"  id="idgenero" class="form-control" disabled >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idgenero, genero FROM genero ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$idgenero_ss) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <div class="col-sm-3">
                    <h6 class="text-primary">CÉDULA DE IDENTIDAD:</h6>
                        <input type="number" class="form-control" 
                        value="<?php echo $row[2];?>" name="cedula" disabled>
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary">NOMBRES:</h6>
                        <input type="text" class="form-control" 
                        value="<?php echo $row[3];?>" name="nombre" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary">PRIMER APELLIDO:</h6>
                        <input type="text" class="form-control" 
                        value="<?php echo $row[4];?>" name="paterno" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary">SEGUNDO APELLIDO:</h6>
                        <input type="text" class="form-control" 
                        value="<?php echo $row[5];?>" name="materno" disabled>                
                    </div>
                </div>


                <div class="form-group row">  
                    <div class="col-sm-4">
                    <h6 class="text-primary">FECHA DE NACIMIENTO:</h6>
                        <input type="date"  class="form-control" 
                            placeholder="ingresar fecha" name="fecha_nac" value="<?php echo $row[6];?>" disabled>
                    </div>      
                    <div class="col-sm-4">
                    <h6 class="text-primary">TELEFONO/CELULAR:</h6>
                        <input type="text" class="form-control" 
                        value="<?php echo $row[7];?>" name="celular" disabled>                
                    </div>                           
                    <div class="col-sm-4">
                    <h6 class="text-primary">DIRECCIÓN ACTUAL:</h6>
                    <textarea class="form-control" rows="2" name="direccion" disabled><?php echo $row[8]?></textarea>
                    </div>
                </div>                
               
                        <hr>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <h4 class="text-primary">SEGUIMIENTO MÉDICO</h4>
                    </div>
                </div>   

                <div class="form-group row">
                    <div class="col-sm-12">
                        
                    <div class="table-responsive">
                <table class="table table-striped" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-info">Nª</th>
                            <th class="text-info">FECHA DEL CONTROL</th>
                            <th class="text-info">REGISTRO EPIDEMIOLÓGICO</th>
                            <th class="text-info">SEMANA EP (CONTROL)</th>
                            <th class="text-info">ESTADO DEL PACIENTE</th>
                            <th class="text-info">MÉDICO</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                        $numero=1;
                        $sql4 =" SELECT seguimiento_ep.idficha_ep, sospecha_diag.sospecha_diag, semana_ep.semana_ep, estado_paciente.estado_paciente,  ";
                        $sql4.=" nombre.nombre, nombre.paterno, nombre.materno, seguimiento_ep.fecha_registro FROM seguimiento_ep, sospecha_diag, semana_ep, estado_paciente, usuarios, nombre ";
                        $sql4.=" WHERE seguimiento_ep.idsospecha_diag=sospecha_diag.idsospecha_diag AND seguimiento_ep.idsemana_ep=semana_ep.idsemana_ep  ";
                        $sql4.=" AND seguimiento_ep.idestado_paciente=estado_paciente.idestado_paciente AND seguimiento_ep.idusuario=usuarios.idusuario ";
                        $sql4.=" AND usuarios.idnombre=nombre.idnombre AND seguimiento_ep.idficha_ep='$idficha_ep_ss'  ";
                        $result4 = mysqli_query($link,$sql4);
                        if ($row4 = mysqli_fetch_array($result4)){
                        mysqli_field_seek($result4,0);
                        while ($field4 = mysqli_fetch_field($result4)){
                        } do { 
                        ?>
                        <tr>
                            <td><?php echo $numero;?></td>
                            <td>   
                                <?php 
                                $fecha_s = explode('-',$row4[7]);
                                $fecha_seg = $fecha_s[2].'/'.$fecha_s[1].'/'.$fecha_s[0];
                                echo $fecha_seg; ?>
                            </td>
                            <td><?php echo $row4[1];?></td>
                            <td><?php echo "Sem. ".$row4[2];?></td>
                            <td><?php echo $row4[3];?></td>
                            <td><?php echo mb_strtoupper($row4[4]." ".$row4[5]." ".$row4[6]);?></td>
                        </tr>                            
                        <?php
                        $numero=$numero+1;
                        }
                        while ($row4 = mysqli_fetch_array($result4));
                        } else {
                        }
                    ?>
                </tbody>
            </table>
        </div>

                    </div>
                </div> 
 
                <hr>

                <form name="EVOLUCION_ENF" action="guarda_evolucion_ficha_ep.php" method="post">

                <div class="form-group row">
                    <div class="col-sm-4">
                        <h6 class="text-primary">EVOLUCIÓN DE LA ENFERMEDAD A:</h6>
                </div>
                    <div class="col-sm-6">
                    <select name="idsospecha_diag_evol"  id="idsospecha_diag_evol" class="form-control" required >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE evolutiva='SI'";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row[12]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>                       
                    </div>
                    <div class="col-sm-2">

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
                <div class="col-sm-12">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    ACTUALIZAR SEGUIMIENTO
                    </button>  
                </div> 
            </div>                              
                            
                   <!-- modal de confirmacion de envio de datos-->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ACTUALIZAR SEGUIMIENTO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            
                            Esta seguro de Registrar los cambios en la SEGUIMIENTO EPIDEMIOLÓGICO?
                        
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-primary pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form>        
                    
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

</body>

</html>
