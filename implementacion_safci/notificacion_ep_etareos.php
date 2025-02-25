<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$iddepartamento_ss          = $_SESSION['iddepartamento_ss'];
$idred_salud_ss             = $_SESSION['idred_salud_ss'];
$idmunicipio_ss             = $_SESSION['idmunicipio_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idnotificacion_ep_ss       = $_SESSION['idnotificacion_ep_ss'];
$idsospecha_diag_ss         = $_SESSION['idsospecha_diag_ss'];

$sql =" SELECT idnotificacion_ep, codigo FROM notificacion_ep WHERE idnotificacion_ep='$idnotificacion_ep_ss' ";
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
        <div class="card o-hidden border-0 shadow-lg my-0">
            <div class="card-body p-0">
<!-- BEGIN aqui va el TITULO de la pagina ---->
                <div class="row">
                    <div class="col-lg-12">
                    <div class="p-3">               
                    <div class="text-center"> 
                    <a href="notificacion_ep.php"><h6 class="text-success"><i class="fas fa-fw fa-arrow-left"></i>VOLVER</h6></a>              
                    <hr>                     
                    <h4 class="text-primary">NOTIFICACIÓN</h4>
                    <h4 class="text-primary"><?php echo $row[1];?></h4>
                    <h5 class="text-info">I. REGISTRO DE ENFERMEDADES DE NOTIFICACIÓN INMEDIATA</h5>
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->
                <hr>
 
                 <div class="form-group row">
                    <div class="col-sm-4">
                    <h6 class="text-primary">SOSPECHA DIAGNÓSTICA (ENFERMEDAD):</h6>
                    </div>
                    <div class="col-sm-8">
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
                            <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$idsospecha_diag_ss) echo "selected";?>><?php echo $rowv[1];?></option>
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
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-striped" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-info">Nª</th>
                            <th class="text-info">GRUPO ETAREO</th>
                            <th class="text-info">GÉNERO</th>
                            <th class="text-info">CIFRA</th>
                        </tr>
                    </thead>
                    <tbody>
                    <form name="CIFRA_ENF" action="guarda_cifra_enfermedad.php" method="post">  
                        <?php
                        $numero=0;
                        $sql4 =" SELECT registro_enfermedad.idregistro_enfermedad, grupo_etareo.grupo_etareo, genero.genero, registro_enfermedad.cifra, registro_enfermedad.idgenero, registro_enfermedad.idgrupo_etareo ";
                        $sql4.=" FROM registro_enfermedad, grupo_etareo, genero WHERE registro_enfermedad.idgrupo_etareo=grupo_etareo.idgrupo_etareo ";
                        $sql4.=" AND registro_enfermedad.idgenero=genero.idgenero AND registro_enfermedad.idnotificacion_ep='$idnotificacion_ep_ss' ";
                        $sql4.=" AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_ss' ORDER BY registro_enfermedad.idregistro_enfermedad ";
                        $result4 = mysqli_query($link,$sql4);
                        if ($row4 = mysqli_fetch_array($result4)){
                        mysqli_field_seek($result4,0);
                        while ($field4 = mysqli_fetch_field($result4)){
                        } do { 
                        ?>
                        <tr>
                            <td><?php echo $numero+1;?></td>
                            <td><?php 
                            if ($row4[4] == '1') { echo "<h6 class='text-danger'>".$row4[1]."</h6>"; } else { echo "<h6 class='text-primary'>".$row4[1]."</h6>"; }
                            ?></td>
                            <td><?php 
                            if ($row4[4] == '1') { echo "<h6 class='text-danger'>".$row4[2]."</h6>"; } else { echo "<h6 class='text-primary'>".$row4[2]."</h6>"; }
                            ?>
                            </td>
                            <td>
                            <input type="number" class="form-control" name="cifra[<?php echo $numero;?>]" value="<?php echo $row4[3];?>"> 
                            </td>
                        </tr>                            
                        <?php
                        $numero=$numero+1;
                        }
                        while ($row4 = mysqli_fetch_array($result4));
                        } else {
                        }
                    ?>
                    <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">REGISTRAR CASOS</button> 
                    </td>
                    <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>   
                   <!-- modal de confirmacion de envio de datos-->
                   <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">REGISTRAR CASOS</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    
                                    Esta seguro de Registrar los casos?

                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                <button type="submit" class="btn btn-primary pull-center">CONFIRMAR REGISTRO</button>    
                                </div>
                            </div>
                        </div>
                    </div>
                </form> 
                    <!-- Modal -->
            <hr>
            <div class="text-center"> 
            <a href="notificacion_ep_eventos.php"><h6 class="text-success"><i class="fas fa-fw fa-arrow-right"></i>IR A REGISTRO DE EVENTOS</h6></a>     
            </div>

    </div>
                
    <!-------- begin rejilla --------->   

    <!-------- end rejilla --------->                      
                <div class="text-center">

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
    <!-- scripts para calendario -->
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
        <script>$("#fecha1").datepicker($.datepicker.regional[ "es" ]);</script>
        <script language="javascript">
        $(document).ready(function(){
        $("#iddepartamento").change(function () {
                    $("#iddepartamento option:selected").each(function () {
                        departamento=$(this).val();
                    $.post("red_salud_o.php", {departamento:departamento}, function(data){
                    $("#idred_salud").html(data);
                    });
                });
        })
        });
        </script>
        <script language="javascript">
        $(document).ready(function(){
        $("#iddepartamento").change(function () {
                    $("#iddepartamento option:selected").each(function () {
                        departamento=$(this).val();
                    $.post("municipios.php", {departamento:departamento}, function(data){
                    $("#idmunicipio").html(data);
                    });
                });
        })
        });
        </script>        
        <script language="javascript">
        $(document).ready(function(){
        $("#idnivel_establecimiento").change(function () {
                    $("#idnivel_establecimiento option:selected").each(function () {
                        nivel_establecimiento=$(this).val();
                    $.post("tipo_establecimiento.php", {nivel_establecimiento:nivel_establecimiento}, function(data){
                    $("#idtipo_establecimiento").html(data);
                    });
                });
        })
        });
        </script>
   
</body>

</html>
