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

$idcarpeta_familiar_ss      = $_SESSION['idcarpeta_familiar_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idintegrante_cf_ss         = $_SESSION['idintegrante_cf_ss'];
$idnombre_integrante_ss     = $_SESSION['idnombre_integrante_ss'];
$edad_ss                    = $_SESSION['edad_ss'];

$sql_cf =" SELECT idcarpeta_familiar, codigo, familia, fecha_apertura FROM carpeta_familiar WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
$result_cf=mysqli_query($link,$sql_cf);
$row_cf=mysqli_fetch_array($result_cf);

$sql_n =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$idnombre_integrante_ss' ";
$result_n=mysqli_query($link,$sql_n);
$row_n=mysqli_fetch_array($result_n);
        
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
                    <a href="personas_carpetizadas.php"><h6 class="text-info"><- VOLVER</h6></a>
                    <hr>             
                    <h4 class="text-info">HISTORIA CLÍNICA - SAFCI</h4>
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
                    <div class="col-sm-3">
                    <h6 class="text-info">VER CARPETA FAMILIAR:</h6>
                    <a href="../carpetas_familiares/imprime_carpeta_familiar.php?idcarpeta_familiar=<?php echo $idcarpeta_familiar_ss;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1400,height=800,top=50, left=200, scrollbars=YES'); return false;">
                    <h6 class="text-primary"><?php echo $row_cf[1];?></h6></a> 
                    </div>
                </div>  

    <!-------- DATOS PERSONALES DEL INTEGRANTE FAMILIAR (End) --------->  

                <?php
                $sql4 =" SELECT integrante_datos_cf.idintegrante_datos_cf, estado_civil.estado_civil, nivel_instruccion.nivel_instruccion, profesion.profesion, integrante_datos_cf.ocupacion, contribuye_cf.contribuye_cf ";
                $sql4.=" FROM integrante_datos_cf, estado_civil, nivel_instruccion, profesion, contribuye_cf WHERE integrante_datos_cf.idestado_civil=estado_civil.idestado_civil ";
                $sql4.=" AND integrante_datos_cf.idnivel_instruccion=nivel_instruccion.idnivel_instruccion AND integrante_datos_cf.idprofesion=profesion.idprofesion ";
                $sql4.=" AND integrante_datos_cf.idcontribuye_cf=contribuye_cf.idcontribuye_cf AND integrante_datos_cf.idintegrante_cf='$idintegrante_cf_ss'";
                $result4 = mysqli_query($link,$sql4);
                if ($row4 = mysqli_fetch_array($result4)){
                mysqli_field_seek($result4,0);
                while ($field4 = mysqli_fetch_field($result4)){
                } do { 
                ?>
                    <div class="form-group row">                               
                        <div class="col-sm-4">
                        <h6 class="text-info">ESTADO CIVIL:</h6>
                            <input type="text" class="form-control" value="<?php echo $row4[1];?>" 
                            name="" disabled>
                        </div>
                        <div class="col-sm-4">
                        <h6 class="text-info">NIVEL DE INSTRUCCIÓN:</h6>
                            <input type="text" class="form-control" value="<?php echo $row4[2];?>"
                            name="" disabled>                
                        </div>
                        <div class="col-sm-4">
                        <h6 class="text-info">PROFESIÓN:</h6>
                            <input type="text" class="form-control" value="<?php echo $row4[3];?>"             
                            name="" disabled >                
                        </div>

                    </div>
                    <div class="form-group row"> 
                    <div class="col-sm-6">
                        <h6 class="text-info">OCUPACIÓN:</h6>
                            <input type="text" class="form-control" value="<?php echo $row4[4];?>" 
                            name="" disabled>                
                        </div>
                        <div class="col-sm-6">
                        <h6 class="text-info">CONTRIBUYE AL SUSTENTO FAMILIAR:</h6>
                            <input type="text" class="form-control" value="<?php echo $row4[5];?>" 
                            name="" disabled>                
                        </div>
                    </div> 
                <?php
                }
                while ($row4 = mysqli_fetch_array($result4));
                } else {
                }
            ?>
                                </div>
                            </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">2.- ANTECEDENTES NO PATOLÓGICOS</h6>
        </div>
        <div class="card-body">

        <?php
            $numeroa=1;
            $sqla =" SELECT idintegrante_ap_sano, integrante_ap_sano FROM integrante_ap_sano WHERE idintegrante_cf='$idintegrante_cf_ss' ";
            $resulta = mysqli_query($link,$sqla);
            if ($rowa = mysqli_fetch_array($resulta)){
            mysqli_field_seek($resulta,0);
            while ($fielda = mysqli_fetch_field($resulta)){
            } do { 
            ?>
                <div class="form-group row">  
                    <div class="col-sm-4">
                        <h6 class="text-info">GRUPO I : APARENTEMENTE SANO(A)</h6>                   
                    </div>
                    <div class="col-sm-8">
                    <h6 class="text-secundary"><?php echo $rowa[1];?></h6>
                    </div>
                </div>
            <hr>
            <?php
            $numeroa=$numeroa+1;
            }
            while ($rowa = mysqli_fetch_array($resulta));
            } else {
            }
            ?>


        <?php
            $numerob=1;
            $sqlb =" SELECT integrante_factor_riesgo.idintegrante_factor_riesgo, factor_riesgo_cf.factor_riesgo_cf,  ";
            $sqlb.=" factor_riesgo_cf.vulnerable, integrante_factor_riesgo.otro_factor_riesgo  FROM integrante_factor_riesgo, factor_riesgo_cf ";
            $sqlb.=" WHERE integrante_factor_riesgo.idfactor_riesgo_cf=factor_riesgo_cf.idfactor_riesgo_cf ";
            $sqlb.=" AND integrante_factor_riesgo.idintegrante_cf='$idintegrante_cf_ss' ";
            $resultb = mysqli_query($link,$sqlb);
            if ($rowb = mysqli_fetch_array($resultb)){
            mysqli_field_seek($resultb,0);
            while ($fieldb = mysqli_fetch_field($resultb)){
            } do { 
            ?>
                <div class="form-group row">  
                    <div class="col-sm-4">
                        <h6 class="text-info">GRUPO II : FACTORES DE RIESGO</h6> 
                    </div>
                    <div class="col-sm-8">
                    <h6 class="text-secundary"><?php echo $rowb[1];
                    if ($rowb[2] == 'SI') { echo " - VULNERABLE"; } else { } ?>                    
                    <?php  echo $rowb[3];?>
                    </h6>
                    </div>
                </div>
                <hr>
            <?php
            $numerob=$numerob+1;
            }
            while ($rowb = mysqli_fetch_array($resultb));
            } else { ?>
                <div class="form-group row"> 
                    <div class="col-sm-4"></div> 
                    <div class="col-sm-8">
                        <h6 class="text-secundary">NO PRESENTA FACTORES DE RIESGO</h6> 
                    </div>
                </div>
                <?php } ?>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">3.- ANTECEDENTES PATOLÓGICOS</h6>
        </div>
        <div class="card-body">
        <?php
            $numeroc=1;
            $sqlc =" SELECT integrante_morbilidad.idintegrante_morbilidad, morbilidad_cf.morbilidad_cf, tipo_enfermedad_cf.tipo_enfermedad_cf, integrante_morbilidad.otra_enfermedad  ";
            $sqlc.=" FROM integrante_morbilidad, morbilidad_cf, tipo_enfermedad_cf WHERE integrante_morbilidad.idmorbilidad_cf=morbilidad_cf.idmorbilidad_cf ";
            $sqlc.=" AND morbilidad_cf.idtipo_enfermedad_cf=tipo_enfermedad_cf.idtipo_enfermedad_cf AND integrante_morbilidad.idintegrante_cf='$idintegrante_cf_ss' ";
            $resultc = mysqli_query($link,$sqlc);
            if ($rowc = mysqli_fetch_array($resultc)){
            mysqli_field_seek($resultc,0);
            while ($fieldc = mysqli_fetch_field($resultc)){
            } do { 
            ?>
                <div class="form-group row">  
                    <div class="col-sm-4">
                        <h6 class="text-info">GRUPO III - MORBILIDAD</h6> 
                    </div>
                    <div class="col-sm-8">
                    <h6 class="text-secundary"><?php echo $rowc[1];?> - <?php  echo $rowc[2];?> 
                    <?php if ($rowc[3] != ' ') { echo " - ".$rowc[3]; } else { } ?>
                    </h6>
                    </div>
                </div>
                <hr>
            <?php
            $numeroc=$numeroc+1;
            }
            while ($rowc = mysqli_fetch_array($resultc));
            } else {
                ?>
                <div class="form-group row">  
                    <div class="col-sm-4"></div>
                    <div class="col-sm-8">
                        <h6 class="text-secundary">NO PRESENTA MORBILIDAD</h6> 
                    </div>
                </div>
                <?php } ?>
        <?php
            $numerod=1;
            $sqld =" SELECT integrante_discapacidad.idintegrante_discapacidad, tipo_discapacidad_cf.tipo_discapacidad_cf, ";
            $sqld.=" nivel_discapacidad_cf.nivel_discapacidad_cf FROM integrante_discapacidad, tipo_discapacidad_cf, nivel_discapacidad_cf ";
            $sqld.=" WHERE integrante_discapacidad.idtipo_discapacidad_cf=tipo_discapacidad_cf.idtipo_discapacidad_cf ";
            $sqld.=" AND integrante_discapacidad.idnivel_discapacidad_cf=nivel_discapacidad_cf.idnivel_discapacidad_cf AND integrante_discapacidad.idintegrante_cf='$idintegrante_cf_ss' ";
            $resultd = mysqli_query($link,$sqld);
            if ($rowd = mysqli_fetch_array($resultd)){
            mysqli_field_seek($resultd,0);
            while ($fieldd = mysqli_fetch_field($resultd)){
            } do { 
            ?>
                <div class="form-group row">  
                    <div class="col-sm-4">
                        <h6 class="text-info">GRUPO IV - DISCAPACIDAD</h6> 
                    </div>
                    <div class="col-sm-8">
                    <h6 class="text-secundary"><?php echo "DISCAPACIDAD : ".$rowd[1];?> - <?php  echo $rowd[2];?> 
                    </h6>
                    </div>
                </div>
                <hr>
            <?php
            $numerod=$numerod+1;
            }
            while ($rowd = mysqli_fetch_array($resultd));
            } else {

            }
                ?>

        </div>
    </div>
        <!-- VENTANA DE ATENCION INTEGRAL ---->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">4.- ATENCIÓN INTEGRAL SAFCI</h6>
        </div>
        <div class="card-body">

            <div class="form-group row">    
                <div class="col-sm-12">
                <h6 class="text-info">TIPO DE ATENCIÓN SAFCI:</h6>
                <select name="idtipo_atencion" id="idtipo_atencion" class="form-control" required>
                <option value="">-SELECCIONE-</option>
                <?php
                $sql_at = "SELECT idtipo_atencion, tipo_atencion FROM tipo_atencion ";
                $result_at = mysqli_query($link,$sql_at);
                if ($row_at = mysqli_fetch_array($result_at)){
                mysqli_field_seek($result_at,0);
                while ($field_at = mysqli_fetch_field($result_at)){
                } do {
                echo "<option value=".$row_at[0].">".$row_at[1]."</option>";
                } while ($row_at = mysqli_fetch_array($result_at));
                } else {
                echo "No se encontraron resultados!";
                }
                ?>
                </select>
                </div>
            </div>
        </div>
        <div class="card-body" id="tipo_atencion"></div> 
        
    
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