<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idsesion_educativa_ss  =  $_SESSION['idsesion_educativa_ss'];

    $sql =" SELECT sesion_educativa.idsesion_educativa, departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud,  ";
    $sql.=" sesion_educativa.fecha_sesion, sesion_educativa.codigo, sesion_educativa.duracion, sesion_educativa.idcharla_psafci, sesion_educativa.idsustantivo, sesion_educativa.asistentes, ";
    $sql.=" nombre.nombre, nombre.paterno, nombre.materno, sesion_educativa.fecha_registro, sesion_educativa.hora_registro FROM sesion_educativa, departamento, municipios, establecimiento_salud, ";
    $sql.=" charla_psafci, sustantivo, usuarios, nombre WHERE sesion_educativa.iddepartamento=departamento.iddepartamento AND sesion_educativa.idmunicipio=municipios.idmunicipio ";
    $sql.=" AND sesion_educativa.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND sesion_educativa.idcharla_psafci=charla_psafci.idcharla_psafci  ";
    $sql.=" AND sesion_educativa.idsustantivo=sustantivo.idsustantivo AND sesion_educativa.idusuario=usuarios.idusuario AND usuarios.idnombre=nombre.idnombre ";
    $sql.=" AND sesion_educativa.idsesion_educativa='$idsesion_educativa_ss' ORDER BY sesion_educativa.idsesion_educativa DESC  ";
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
  
                <body class="bg-gradient-primary">

    <div class="container">
    </br>
        <div class="card o-hidden border-0 shadow-lg my-1">
            <div class="card-body p-0">
<!-- BEGIN aqui va el TITULO de la pagina ---->
                <div class="row">
                    <div class="col-lg-12">
                    <div class="p-3">               
                    <div class="text-center">   
                        <a href="sesiones_educativas.php" class="btn btn-secundary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-arrow-left"></i>
                            </span>
                            <span class="text">VOLVER</span>
                        </a>                                    
                    <hr>                                         
                    <h2 class="text-primary">MODIFICAR SESIÓN EDUCATIVA</h2>
                    <h4 class="text-secundary"></h4>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

                <div class="col-lg-12">  
                    <div class="p-3"> 

                    <form name="MODIFICA_SESION" action="modifica_sesion_educativa.php" method="post">  
                    
                <div class="text-center">
                <h4 class="text-primary"><?php echo $row[5];?></h4>
                <hr>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"><i class="fas fa-calendar"> </i> FECHA DE LA SESIÓN EDUCATIVA:</h6>
                        <input type="date" name="fecha_sesion" id="fecha_sesion" class="form-control" value="<?php echo $row[4];?>" required>
                        </div>
                        <div class="col-sm-6">
                        <h6 class="text-primary"><i class="fas fa-clock"> </i> DURACIÓN DE LA SESIÓN EDUCATIVA:</h6>
                        <input type="number" name="duracion" id="duracion" class="form-control" value="<?php echo $row[6];?>"
                        Placeholder="Cantidad de horas" required>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-12">
                        <h6 class="text-primary"> <i class="fas fa-list"> </i> SELECCIONE EL TIPO DE CHARLA EDUCATIVA:</h6>

                    <select name="idcharla_psafci"  id="idcharla_psafci" class="form-control" required >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idcharla_psafci, charla_psafci FROM charla_psafci ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row[7]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                        <h6 class="text-primary"> <i class="fas fa-users"> </i>  INDIVIDUAL/GRUPAL:</h6>
                        <select name="idsustantivo"  id="idsustantivo" class="form-control" required >
                            <option selected>Seleccione</option>
                            <?php
                            $sqlv = " SELECT idsustantivo, sustantivo FROM sustantivo ";
                            $resultv = mysqli_query($link,$sqlv);
                            if ($rowv = mysqli_fetch_array($resultv)){
                            mysqli_field_seek($resultv,0);
                            while ($fieldv = mysqli_fetch_field($resultv)){
                            } do {
                            ?>
                            <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row[8]) echo "selected";?> ><?php echo $rowv[1];?></option>
                            <?php
                            } while ($rowv = mysqli_fetch_array($resultv));
                            } else {
                            }
                            ?>
                        </select>
                        </div>
                    </div>

<?php if ($row[8] == '1') { ?>
    
        <input type="hidden" name="asistentes" value="1" >

<?php } else { ?>
    
        <div class="form-group row">
        <div class="col-sm-6">
        <h6 class="text-primary"> <i class="fas fa-users"> </i> Número de Asistentes:</h6>
        <input type="number" class="form-control" value="<?php echo $row[9];?>"
        placeholder="ingresar número de asistentes" name="asistentes" required>
        </div>
        </div>

<?php } ?>  


        </br>
            <div class="text-center">
            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    MODIFICAR SESIÓN EDUCATIVA
                    </button>  
                </div> 
            </div>                              
        </br>                   
                   <!-- modal de confirmacion de envio de datos-->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">MODIFICAR DE SESIÓN EDUCATIVA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            
                            Esta seguro de MODIFICAR la SESIÓN EDUCATIVA?
                        
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-primary pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form>        
                    
                </div>
            
   <form name="ELIMINA_SESION" action="elimina_sesion_educativa.php" method="post">  
<hr>
            <div class="text-center">
                <input type="hidden" name="idsesion_educativa" value="<?php echo $idsesion_educativa_ss;?>" >

                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModald">
                    ELIMINAR SESIÓN EDUCATIVA
                    </button> 
            </div>
<hr>
                  <div class="modal fade" id="exampleModald" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ELIMINAR DE SESIÓN EDUCATIVA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            
                            Esta seguro de ELIMINAR la SESIÓN EDUCATIVA?
                        
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-danger pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form>  
            
        </div>
<hr>
        
               
                    
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

    <!-- scripts para calendario -->
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
        <script>$("#fecha1").datepicker($.datepicker.regional[ "es" ]);</script>
<!-- Page level plugins -->
<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>


    
</body>
</html>