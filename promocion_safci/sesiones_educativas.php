<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idevento_vacunacion_ss  =  $_SESSION['idevento_vacunacion_ss'];

$sql_ev =" SELECT idevento_vacunacion, codigo, idtipo_evento_vacunacion, idvacuna, descripcion, fecha_inicio, fecha_conclusion ";
$sql_ev.=" FROM evento_vacunacion WHERE idevento_vacunacion='$idevento_vacunacion_ss' ";
$result_ev=mysqli_query($link,$sql_ev);
$row_ev=mysqli_fetch_array($result_ev);

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
                                     
                    <hr>                                         
                    <h2 class="text-primary">SESIONES EDUCATIVAS</h2>
                    <h4 class="text-secundary"></h4>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

<form name="GUARDA_SESION" action="guarda_sesion_educativa.php" method="post">  

                <div class="col-lg-12">  
                    <div class="p-3"> 
   
                <div class="text-center">
                <h4 class="text-primary">NUEVO REGISTRO DE SESIÓN EDUCATIVA </h4>
                <hr>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"><i class="fas fa-calendar"> </i> FECHA DE LA SESIÓN EDUCATIVA:</h6>
                        <input type="date" name="fecha_sesion" id="fecha_sesion" class="form-control" required>
                        </div>
                        <div class="col-sm-6">
                    
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-12">
                        <h6 class="text-primary"> <i class="fas fa-list"> </i> SELECCIONE EL TIPO DE CHARLA EDUCATIVA:</h6>

                    <select name="idcharla_psafci"  id="idcharla_psafci" class="form-control" required>
                        <option value="">ELEGIR</option>
                        <?php
                        $sql1 = "SELECT idcharla_psafci, charla_psafci FROM charla_psafci";
                        $result1 = mysqli_query($link,$sql1);
                        if ($row1 = mysqli_fetch_array($result1)){
                        mysqli_field_seek($result1,0);
                        while ($field1 = mysqli_fetch_field($result1)){
                        } do {
                        echo "<option value=".$row1[0].">".$row1[1]."</option>";
                        } while ($row1 = mysqli_fetch_array($result1));
                        } else {
                        echo "No se encontraron resultados!";
                        }
                        ?>
                    </select>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                        <h6 class="text-primary"> <i class="fas fa-users"> </i>  INDIVIDUAL/GRUPAL:</h6>
                            <select name="idsustantivo"  id="idsustantivo" class="form-control" required>
                                <option value="">ELEGIR</option>
                                <?php
                                $sql1 = "SELECT idsustantivo, sustantivo FROM sustantivo";
                                $result1 = mysqli_query($link,$sql1);
                                if ($row1 = mysqli_fetch_array($result1)){
                                mysqli_field_seek($result1,0);
                                while ($field1 = mysqli_fetch_field($result1)){
                                } do {
                                echo "<option value=".$row1[0].">".$row1[1]."</option>";
                                } while ($row1 = mysqli_fetch_array($result1));
                                } else {
                                echo "No se encontraron resultados!";
                                }
                                ?>
                            </select>  
                        </div>
                    </div>

                    <div id="form_charla"></div>

                </br>
            <div class="text-center">
            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    REGISTRAR SESIÓN EDUCATIVA
                    </button>  
                </div> 
            </div>                              
                            
                   <!-- modal de confirmacion de envio de datos-->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">REGISTRO DE SESIÓN EDUCATIVA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            
                            Esta seguro de Registrar la SESIÓN EDUCATIVA?
                        
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
             </br>

<hr>
            <div class="text-center">
                <h4 class="text-primary">SESIONES EDUCATIVAS REGISTRADAS:</h4>
            </div>
<hr>
        <div class="table-responsive">
            <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                <thead>
                    <tr>  
                        <th>N°</th> 
                        <th>DEPTO.</th>
                        <th>MUNICIPIO</th>
                        <th>ESTABLECIMIENTO</th> 
                        <th>FECHA DE SESIÓN</th>                                
                        <th>TIPO DE CHARLA EDUCATIVA</th>
                        <th>PÚBLICO</th>
                        <th>N° ASISTENTES</th>
                        <th>PERSONAL SAFCI</th> 
                        <th>FECHA Y HORA DE REGISTRO</th>         
                    </tr>
                </thead>
                <tbody>
                <?php
                $numero=1;
                $sql ="  ";
                $sql.="  ";
                $sql.="  ";
                $sql.="  ";
                $result = mysqli_query($link,$sql);
                if ($row = mysqli_fetch_array($result)){
                mysqli_field_seek($result,0);
                while ($field = mysqli_fetch_field($result)){
                } do {
                ?>
                    <tr>
                        <td><?php echo $numero;?></td>
                        <td><?php echo $row[1];?></td>
                        <td><?php echo $row[2];?></td>
                        <td><?php echo $row[3];?></td>
                        <td><?php 
                        $fecha_e = explode('-',$row[11]);
                        $fecha_ej = $fecha_e[2].'/'.$fecha_e[1].'/'.$fecha_e[0];
                        echo $fecha_ej; ?> - <?php echo $row[12];?></td>
                        <td><?php echo $row[8];?></td>
                        <td><?php echo $row[9];?></td>
                        <td><?php echo $row[10];?></td>
                        <td><?php echo mb_strtoupper($row[4]." ".$row[5]." ".$row[6]);?></td>
                        <td><?php 
                        $fecha_r = explode('-',$row[11]);
                        $fecha_reg = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];
                        echo $fecha_reg; ?> - <?php echo $row[12];?></td>
                    </tr>
                                
                <?php
                $numero=$numero+1;
                }
                while ($row = mysqli_fetch_array($result));
                } else {
                }
                ?>
                    </tbody>
                </table>
            </div>
        </div>
<hr>
            <div class="form-group row">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-6">
                        <h6 class="text-primary">1.- REPORTE NACIONAL SESIÓN EDUCATIVA - NIVEL NACIONAL</h6>
                    </div>
                    <div class="col-sm-4">
                    <a href="vacunacion_anim_safci.php" target="_blank" onClick="window.open(this.href, this.target, 'width=1220,height=700,scrollbars=YES'); return false;">
                    <h6 class="text-info"><i class="far fa-chart-bar"></i> MOSTRAR REPORTE</h6></a>
                    </div>
            </div>
            
            <div class="form-group row">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                    <form name="NACIONAL_VACUNACION_ANIMAL" action="reporte_vacunacion_nacional_excel.php" method="post">
                        <button type="submit" class="btn btn-success">REPORTE NACIONAL EN EXCEL</button>
                    </form>
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
<!-- Page level plugins -->
<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

    <script>
    $(document).ready(function() {
        $('#example').DataTable( {
                    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]] ,
                    "language": {
                        "lengthMenu": "Mostrar _MENU_ registros por pagina",
                        "zeroRecords": "No se encontraron resultados en su busqueda",
                        "searchPlaceholder": "Buscar registros",
                        "info": "Mostrando Registros de _START_ al _END_ de un total de  _TOTAL_ Registros",
                        "infoEmpty": "No existen Registros",
                        "infoFiltered": "(filtrado de un total de _MAX_ Registros)",
                        "search": "Buscar:",
                        "paginate": {
                            "first":    "Primero",
                            "last":    "Último",
                            "next":    "Siguiente",
                            "previous": "Anterior"
                        },
                    }
                } );
            } );
    </script>

        <script language="javascript">
        $(document).ready(function(){
        $("#idsustantivo").change(function () {
                    $("#idsustantivo option:selected").each(function () {
                        sustantivo=$(this).val();
                    $.post("form_charla.php", {sustantivo:sustantivo}, function(data){
                    $("#form_charla").html(data);
                    });
                });
        })
        });
        </script>
    
</body>
</html>