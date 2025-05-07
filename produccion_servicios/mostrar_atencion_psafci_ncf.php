<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idatencion_psafci_ss       = $_SESSION['idatencion_psafci_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idnombre_paciente_ss       = $_SESSION['idnombre_paciente_ss']; 
$edad_ss                    = $_SESSION['edad_ss'];

$sql_n =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$idnombre_paciente_ss' ";
$result_n=mysqli_query($link,$sql_n);
$row_n=mysqli_fetch_array($result_n);
        
$sql_ps =" SELECT idatencion_psafci, idrepeticion, idtipo_consulta, idtipo_atencion, codigo, fecha_registro FROM atencion_psafci WHERE idatencion_psafci='$idatencion_psafci_ss' ";
$result_ps=mysqli_query($link,$sql_ps);
$row_ps=mysqli_fetch_array($result_ps);

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
        <div class="card o-hidden border-0 shadow-lg my-1">
            <div class="card-body p-0">
<!-- BEGIN aqui va el TITULO de la pagina ---->
                <div class="row">
                    <div class="col-lg-12">
                    <div class="p-3">               
                    <div class="text-center">                          
                    <a href="atenciones_psafci.php"><h6 class="text-info"><- VOLVER</h6></a>
                    <hr>             
                    <h4 class="text-info">ATENCIÓN - SAFCI</h4>
                    <h4 class="text-secundary"><?php echo $row_ps[4]?></h4>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">1.- INFORMACIÓN DE FILIACIÓN</h6>
                </div>
                <div class="card-body">

                <div class="form-group row">                               
                    <div class="col-sm-3">
                    <h6 class="text-info">CÉDULA DE IDENTIDAD:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_n[4];?>" 
                         name="ci" disabled>
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">NOMBRES:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_n[1];?>"
                         name="nombre" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">PRIMER APELLIDO:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_n[2];?>"             
                         name="paterno" disabled >                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">SEGUNDO APELLIDO:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_n[3];?>" 
                         name="materno" disabled>                
                    </div>
                </div>

                <div class="form-group row">  
                    <div class="col-sm-3">
                    <h6 class="text-info">GÉNERO</h6>

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
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_n[7]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>

                    </div>  
                    <div class="col-sm-3">
                    <h6 class="text-info">FECHA DE NACIMIENTO:</h6>
                        <input type="date"  class="form-control" 
                            placeholder="ingresar fecha" name="fecha_nac" value="<?php echo $row_n[5];?>" disabled>
                    </div>   
                    
                    <div class="col-sm-3">
                    <h6 class="text-info">EDAD:</h6>
                        <input type="number" class="form-control" value="<?php echo $edad_ss;?>" 
                         name="edad_actual" disabled>
                    </div>
                    <div class="col-sm-3"></br>
                    <h6 class="text-warning">PERSONA NO CARPETIZADA</h6>
                    </div>
                </div>  

    <!-------- DATOS PERSONALES DEL INTEGRANTE FAMILIAR (End) --------->  
        </div>
    </div>
        <!-- VENTANA DE ATENCION INTEGRAL ---->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">2.- ATENCIÓN INTEGRAL SAFCI</h6>
        </div>
        <div class="card-body">

            <div class="form-group row">    
                <div class="col-sm-12">
                <h6 class="text-info">TIPO DE ATENCIÓN SAFCI:</h6>

                <select name="idtipo_atencion" id="idtipo_atencion" class="form-control" disabled>
                <option selected>Seleccione</option>
                <?php
                $sqlv = " SELECT idtipo_atencion, tipo_atencion FROM tipo_atencion ";
                $resultv = mysqli_query($link,$sqlv);
                if ($rowv = mysqli_fetch_array($resultv)){
                mysqli_field_seek($resultv,0);
                while ($fieldv = mysqli_fetch_field($resultv)){
                } do {
                ?>
                <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_ps[3]) echo "selected";?> ><?php echo $rowv[1];?></option>
                <?php
                } while ($rowv = mysqli_fetch_array($resultv));
                } else {
                }
                ?>
            </select>

                </div>
            </div>


<?php if ($row_ps[3] == '1') {  ?>
   
    <div class="form-group row"> 
    <div class="col-sm-3">
    </div> 
    <div class="col-sm-6">
    <h4 class="text-info">ATENCIÓN POR MORBILIDAD:</h4>
    </div> 
    <div class="col-sm-3"> 
    </div> 
    </div> 
<hr>
    <div class="form-group row">  
    <div class="col-sm-6">
                <h6 class="text-info">INCIDENCIA DE LA ATENCIÓN:</h6>
                <?php
                $sql_i =" SELECT idrepeticion, repeticion FROM repeticion ";
                $result_i = mysqli_query($link,$sql_i);
                if ($row_i = mysqli_fetch_array($result_i)){
                mysqli_field_seek($result_i,0);
                while ($field_i = mysqli_fetch_field($result_i)){
                } do { 
                ?>

                <?php echo " - ".$row_i[1]." -> ";?> <input type="radio" name="idrepeticion" value="<?php echo $row_i[0];?>"
                <?php if ($row_i[0] == $row_ps[1]) { echo "checked";} else { } ?> disabled> </br>

                <?php }
                while ($row_i = mysqli_fetch_array($result_i));
                } else { } ?>
                </div>

                <div class="col-sm-6">
                <h6 class="text-info">LUGAR DE LA ATENCIÓN:</h6>
                <?php
                $sql_c =" SELECT idtipo_consulta, tipo_consulta FROM tipo_consulta ";
                $result_c = mysqli_query($link,$sql_c);
                if ($row_c = mysqli_fetch_array($result_c)){
                mysqli_field_seek($result_c,0);
                while ($field_c = mysqli_fetch_field($result_c)){
                } do { 
                ?>

                <?php echo " - ".$row_c[1]." -> ";?> <input type="radio" name="idtipo_consulta" value="<?php echo $row_c[0];?>"
                <?php if ($row_c[0] == $row_ps[2]) { echo "checked";} else { } ?> disabled> </br>

                <?php }
                while ($row_c = mysqli_fetch_array($result_c));
                } else { } ?>
                </div>
    </div>  
<hr>

    <?php
    $numerod=1;
    $sql_dg =" SELECT iddiagnostico_psafci, idatencion_psafci, motivo_consulta, idpatologia FROM diagnostico_psafci WHERE idatencion_psafci='$idatencion_psafci_ss' ";
    $result_dg = mysqli_query($link,$sql_dg);
    if ($row_dg = mysqli_fetch_array($result_dg)){
    mysqli_field_seek($result_dg,0);
    while ($field_dg = mysqli_fetch_field($result_dg)){
    } do {
    ?>

 <div class="form-group row"> 
    <div class="col-sm-6">
    <h4 class="text-info">DIAGNÓSTICO <?php echo $numerod;?> :</h4>
    </div> 
    <div class="col-sm-6"> 
    <h6 class="text-info"></h6>
    </div> 
    </div> 

    <div class="form-group row"> 
    <div class="col-sm-6">
    <h6 class="text-info">MOTIVO DE LA CONSULTA <?php echo $numerod;?>:</h6>
    <textarea class="form-control" rows="3" name="motivo_consulta1" disabled ><?php echo $row_dg[2]?></textarea>
    </div> 
    <div class="col-sm-6">
    <h6 class="text-info">C.I.E. :</h6>

        <select name="idpatologia" id="idpatologia" class="form-control" disabled>
                <option selected>Seleccione</option>
                <?php
                $sqlv = " SELECT idpatologia, patologia, cie FROM patologia ";
                $resultv = mysqli_query($link,$sqlv);
                if ($rowv = mysqli_fetch_array($resultv)){
                mysqli_field_seek($resultv,0);
                while ($fieldv = mysqli_fetch_field($resultv)){
                } do {
                ?>
                <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_dg[3]) echo "selected";?> ><?php echo $rowv[1];?></option>
                <?php
                } while ($rowv = mysqli_fetch_array($resultv));
                } else {
                }
                ?>
        </select>
    </div> 
    </div> 
    <hr>

    <?php
    $numerot=1;
    $sql_tra =" SELECT idtratamiento_psafci, idatencion_psafci, iddiagnostico_psafci, idtipo_medicamento, idmedicamento FROM tratamiento_psafci WHERE iddiagnostico_psafci ='$row_dg[0]' ";
    $result_tra = mysqli_query($link,$sql_tra);
    if ($row_tra = mysqli_fetch_array($result_tra)){
    mysqli_field_seek($result_tra,0);
    while ($field_tra = mysqli_fetch_field($result_tra)){
    } do {
    ?>

        <div class="form-group row"> 
            <div class="col-sm-2"> 
            <h6 class="text-info">TRATAMIENTO <?php echo $numerod;?>,<?php echo $numerot;?>:</h6>
            </div> 
            <div class="col-sm-4">    

                <select name="idtipo_medicamento_11"  id="idtipo_medicamento_11" class="form-control" disabled>
                <option selected>Seleccione</option>
                <?php
                $sqlv = " SELECT idtipo_medicamento, tipo_medicamento FROM tipo_medicamento ORDER BY idtipo_medicamento ";
                $resultv = mysqli_query($link,$sqlv);
                if ($rowv = mysqli_fetch_array($resultv)){
                mysqli_field_seek($resultv,0);
                while ($fieldv = mysqli_fetch_field($resultv)){
                } do {
                ?>
                <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_tra[3]) echo "selected";?> ><?php echo $rowv[1];?></option>
                <?php
                } while ($rowv = mysqli_fetch_array($resultv));
                } else {
                }
                ?>
                </select>

            </div> 
            <div class="col-sm-2"> 
            <h6 class="text-info">MEDICAMENTO <?php echo $numerod;?>,<?php echo $numerot;?>:</h6>
            </div> 
            <div class="col-sm-4">
                <select name="idmedicamento_11"  id="idmedicamento_11" class="form-control" disabled>
                <option selected>Seleccione</option>
                <?php
                $sqlv = " SELECT idmedicamento, medicamento FROM medicamento ORDER BY idmedicamento ";
                $resultv = mysqli_query($link,$sqlv);
                if ($rowv = mysqli_fetch_array($resultv)){
                mysqli_field_seek($resultv,0);
                while ($fieldv = mysqli_fetch_field($resultv)){
                } do {
                ?>
                <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_tra[4]) echo "selected";?> ><?php echo $rowv[1];?></option>
                <?php
                } while ($rowv = mysqli_fetch_array($resultv));
                } else {
                }
                ?>
                </select>

            </div> 
            </div> 

    <?php
    $numerot=$numerot+1;
    }
    while ($row_tra = mysqli_fetch_array($result_tra));
    } else {
    }
    ?>
                    <hr> 
    <?php
    $numerod=$numerod+1;
    }
    while ($row_dg = mysqli_fetch_array($result_dg));
    } else {
    }
    ?>

    
<?php } else {  
    
    $sql_dgs =" SELECT iddiagnostico_psafci, idatencion_psafci, motivo_consulta, idpatologia FROM diagnostico_psafci WHERE idatencion_psafci='$idatencion_psafci_ss' ";
    $result_dgs = mysqli_query($link,$sql_dgs);
    $row_dgs = mysqli_fetch_array($result_dgs);

    ?>
    
    <div class="form-group row"> 
    <div class="col-sm-3"> 
    </div> 
    <div class="col-sm-6">
    <h4 class="text-info">ATENCIÓN APARENTEMENTE SANO(A):</h4>
    </div> 
    <div class="col-sm-3"> 
    </div> 
    </div> 
<hr>
    <div class="form-group row">  
    <div class="col-sm-6">
                <h6 class="text-info">INCIDENCIA DE LA ATENCIÓN:</h6>
                <?php
                $sql_i =" SELECT idrepeticion, repeticion FROM repeticion ";
                $result_i = mysqli_query($link,$sql_i);
                if ($row_i = mysqli_fetch_array($result_i)){
                mysqli_field_seek($result_i,0);
                while ($field_i = mysqli_fetch_field($result_i)){
                } do { 
                ?>

                <?php echo " - ".$row_i[1]." -> ";?> <input type="radio" name="idrepeticion" value="<?php echo $row_i[0];?>"
                <?php if ($row_i[0] == $row_ps[1]) { echo "checked";} else { } ?> disabled> </br>

                <?php }
                while ($row_i = mysqli_fetch_array($result_i));
                } else { } ?>
                </div>

                <div class="col-sm-6">
                <h6 class="text-info">LUGAR DE LA ATENCIÓN:</h6>
                <?php
                $sql_c =" SELECT idtipo_consulta, tipo_consulta FROM tipo_consulta ";
                $result_c = mysqli_query($link,$sql_c);
                if ($row_c = mysqli_fetch_array($result_c)){
                mysqli_field_seek($result_c,0);
                while ($field_c = mysqli_fetch_field($result_c)){
                } do { 
                ?>

                <?php echo " - ".$row_c[1]." -> ";?> <input type="radio" name="idtipo_consulta" value="<?php echo $row_c[0];?>"
                <?php if ($row_c[0] == $row_ps[2]) { echo "checked";} else { } ?> disabled> </br>

                <?php }
                while ($row_c = mysqli_fetch_array($result_c));
                } else { } ?>
                </div>
    </div>  
    </br>
    <div class="form-group row"> 
    <div class="col-sm-5">
    <h6 class="text-info">DIAGNÓSTICO:</h6>

        <select name="idpatologia_ap_sano"  id="idpatologia_ap_sano" class="form-control" disabled>
        <option selected>Seleccione</option>
        <?php
        $sqlv = " SELECT idpatologia, patologia, cie FROM patologia ";
        $resultv = mysqli_query($link,$sqlv);
        if ($rowv = mysqli_fetch_array($resultv)){
        mysqli_field_seek($resultv,0);
        while ($fieldv = mysqli_fetch_field($resultv)){
        } do {
        ?>
        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_dgs[3]) echo "selected";?> ><?php echo $rowv[1];?></option>
        <?php
        } while ($rowv = mysqli_fetch_array($resultv));
        } else {
        }
        ?>
        </select>


    </div> 
    <div class="col-sm-7"> 
    <h6 class="text-info">ORIENTACIÓN MÉDICA:</h6>
    <textarea class="form-control" rows="4" name="motivo_consulta" disabled><?php echo $row_dgs[2];?></textarea>
    </div> 
    </div> 

<?php } ?>


<div class="text-center">                          
                    <a href="atenciones_psafci.php"><h6 class="text-info"> IR A BANDEJA DE ATENCIONES -></h6></a>
                    <hr> 

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

    <!-- scripts para uso de mapas -->

    <!-- scripts para calendario -->
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
        <script>$("#fecha1").datepicker($.datepicker.regional[ "es" ]);</script>

        <script language="javascript">
        $(document).ready(function(){
        $("#idtipo_atencion").change(function () {
                    $("#idtipo_atencion option:selected").each(function () {
                        tipo_atencion=$(this).val();
                    $.post("tipo_atencion.php", {tipo_atencion:tipo_atencion}, function(data){
                    $("#tipo_atencion").html(data);
                    });
                });
        })
        });
    </script> 

</body>
</html>