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

$idcarpeta_familiar_ss  = $_SESSION['idcarpeta_familiar_ss'];
$idintegrante_cf_ss     = $_SESSION['idintegrante_cf_ss'];
$idnombre_integrante_ss = $_SESSION['idnombre_integrante_ss'];
$idgenero_ss            = $_SESSION['idgenero_ss'];
$edad_ss                = $_SESSION['edad_ss'];

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
                    <a href="mostrar_integrante_cf.php"><h6 class="text-info"><- VOLVER</h6></a>
                    <hr>             
                    <h4 class="text-info">CARPETA FAMILIAR:</h4>
                    <h4 class="text-primary"><?php echo $row_cf[1]; ?></h4>
                    <h4 class="text-info">5.- SALUD DEL INTEGRANTE FAMILIAR</h4>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->


                <div class="col-lg-12">  
                    <div class="p-2"> 
                  
                <div class="form-group row">   
                    <div class="col-sm-3">
                    <h6 class="text-info">FECHA DE APERTURA:</h6>
                    </div>
                    <div class="col-sm-3">                    
                    <input type="date" class="form-control" name="fecha_apertura" value="<?php echo $row_cf[3];?>" disabled>                
                    </div>    
                    <div class="col-sm-2">
                    <h6 class="text-info">FAMILIA:</h6>
                    </div>                        
                    <div class="col-sm-4">    
                    <input type="text" class="form-control" name="familia" value="<?php echo $row_cf[2];?>" disabled>                                
                    </div>
                </div>
            <hr>
 
     <!-------- DATOS PERSONALES DEL INTEGRANTE FAMILIAR (Begin) --------->                         

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
                    </br>
                    
                    </div>
                </div>  


                          
        <hr>
        <div class="text-center">                                     
            <h4 class="text-info">5.- SALUD DEL INTEGRANTE FAMILIAR:</h4>                    
        </div>
        <hr>
    <!-------- DETALLE SALUD DEL INETGRANTE FAMILIAR (begin) --------->  

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
                    <div class="col-sm-2">
                        <h6 class="text-info">GRUPO I</h6>                   
                    </div>
                    <div class="col-sm-8">
                    <h6 class="text-secundary"><?php echo $rowa[1];?></h6>
                    </div>
                    <div class="col-sm-2">
                            <form name="BORRAR" action="elimina_integrante_sano_cf.php" method="post">  
                            <input type="hidden" name="idintegrante_ap_sano" value="<?php echo $rowa[0];?>">
                            <button type="submit" class="btn btn-warning">QUITAR</button></form>
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
                    <div class="col-sm-2">
                        <h6 class="text-info">GRUPO II</h6> 
                    </div>
                    <div class="col-sm-8">
                    <h6 class="text-secundary"><?php echo $rowb[1];
                    if ($rowb[2] == 'SI') { echo " - VULNERABLE"; } else { } ?>
                    
                    <?php  echo $rowb[3];?>
                    </h6>
                    </div>
                    <div class="col-sm-2">
                            <form name="BORRAR" action="elimina_integrante_factor_riesgo_cf.php" method="post">  
                            <input type="hidden" name="idintegrante_factor_riesgo" value="<?php echo $rowb[0];?>">
                            <button type="submit" class="btn btn-warning">QUITAR</button></form>
                    </div>
                </div>
                <hr>
            <?php
            $numerob=$numerob+1;
            }
            while ($rowb = mysqli_fetch_array($resultb));
            } else {
            }
            ?>

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
                    <div class="col-sm-2">
                        <h6 class="text-info">GRUPO III</h6> 
                    </div>
                    <div class="col-sm-8">
                    <h6 class="text-secundary"><?php echo $rowc[1];?> - <?php  echo $rowc[2];?> 
                    <?php if ($rowc[3] != ' ') { echo " - ".$rowc[3]; } else { } ?>
                    </h6>
                    </div>
                    <div class="col-sm-2">
                            <form name="BORRAR" action="elimina_integrante_morbilidad_cf.php" method="post">  
                            <input type="hidden" name="idintegrante_morbilidad" value="<?php echo $rowc[0];?>">
                            <button type="submit" class="btn btn-warning">QUITAR</button></form>
                    </div>
                </div>
                <hr>
            <?php
            $numeroc=$numeroc+1;
            }
            while ($rowc = mysqli_fetch_array($resultc));
            } else {
            }
            ?>

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
                    <div class="col-sm-2">
                        <h6 class="text-info">GRUPO IV</h6> 
                    </div>
                    <div class="col-sm-8">
                    <h6 class="text-secundary"><?php echo "DISCAPACIDAD : ".$rowd[1];?> - <?php  echo $rowd[2];?> 
                    </h6>
                    </div>
                    <div class="col-sm-2">
                            <form name="BORRAR" action="elimina_integrante_discapacidad_cf.php" method="post">  
                            <input type="hidden" name="idintegrante_discapacidad" value="<?php echo $rowd[0];?>">
                            <button type="submit" class="btn btn-warning">QUITAR</button></form>
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

    <!-------- DETALLE SALUD DEL INTEGRANTE FAMILIAR (end) --------->  
<div class="form-group row">  
    <div class="col-sm-3">
        <h6 class="text-info">GRUPO A CLASIFICAR::</h6>
    </div>
    <div class="col-sm-9">
        <select name="idgrupo_cf" id="idgrupo_cf" class="form-control" required autofocus>
        <option value="">-SELECCIONE-</option>
        <?php
        $sql1 = "SELECT idgrupo_cf, grupo_cf, denominacion FROM grupo_cf ";
        $result1 = mysqli_query($link,$sql1);
        if ($row1 = mysqli_fetch_array($result1)){
        mysqli_field_seek($result1,0);
        while ($field1 = mysqli_fetch_field($result1)){
        } do {
        echo "<option value=".$row1[0].">".$row1[1]." - ".$row1[2]."</option>";
        } while ($row1 = mysqli_fetch_array($result1));
        } else {
        echo "No se encontraron resultados!";
        }
        ?>
        </select>
    </div>
</div>

<div class="col-lg-12" id="grupo_salud_cf">  
    <div class="p-2">

    </div>
</div>
   
        <!-------- ETAPA DE IDENTIFICACIÓN DEL INTEGRANTE FAMILIAR (BEGIN) --------->
          <hr>
             <div class="text-center"> 
               <a href="salud_integrante_subsector_cf.php"><h6 class="text-success">CONTINUAR -></h6></a>                                                                   
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

    <script type="text/javascript" src="../js/localizacion.js"></script>
    <script type="text/javascript" src="../js/initMap.js"></script>

    <!-- scripts para calendario -->
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
        
    <script language="javascript">
        $(document).ready(function(){
        $("#idgrupo_cf").change(function () {
                    $("#idgrupo_cf option:selected").each(function () {
                        grupo_cf=$(this).val();
                    $.post("grupo_salud_cf.php", {grupo_cf:grupo_cf}, function(data){
                    $("#grupo_salud_cf").html(data);
                    });
                });
        })
        });
    </script> 

    
</body>
</html>