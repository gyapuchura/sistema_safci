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

$idbono_nino_sano_ss      = $_SESSION['idbono_nino_sano_ss'];

$sql_bj =" SELECT idbono_nino_sano, codigo, correlativo, iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idarea_influencia, ";
$sql_bj.=" idnombre_nino, idnombre_madre, idparentesco, numero_controles, nino_carpetizado, direccion_domicilio, lug_nac_nino, lug_nac_madre, ";
$sql_bj.=" celular_madre, cuenta_madre, fecha_inscripcion_bono, fecha_registro, hora_registro, idusuario FROM bono_nino_sano WHERE idbono_nino_sano='$idbono_nino_sano_ss' ";
$result_bj=mysqli_query($link,$sql_bj);
$row_bj=mysqli_fetch_array($result_bj);
         
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
    <link rel="stylesheet" href="../css/boton_mic.css">
    

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
                    <a href="inscritos_bono.php"><h6 class="text-info"><- VOLVER</h6></a>
                    <hr>             
                    <h4 class="text-info">DATOS DEL BENEFICIARIO</h4>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">1.- INFORMACIÓN DE INSCRIPIÓN</h6>
                </div>
                <div class="card-body">

                    <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-info">DEPARTAMENTO:</h6>
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
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_bj[3]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-info">MUNICIPIO:</h6>
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
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_bj[5]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-info">RED DE SALUD:</h6>
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
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_bj[4]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-info">ESTABLECIMIENTO DE SALUD:</h6>
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
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_bj[5]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-info">ÁREA DE INFLUENCIA:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idarea_influencia"  id="idarea_influencia" class="form-control" disabled >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT area_influencia.idarea_influencia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia FROM area_influencia, tipo_area_influencia ";
                        $sqlv.= " WHERE area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND area_influencia.idestablecimiento_salud='$row_bj[6]' ORDER BY area_influencia.idarea_influencia  ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_bj[7]) echo "selected";?>><?php echo $rowv[1];?> <?php echo $rowv[2];?></option>
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
                    $sql_n =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$row_bj[8]' ";
                    $result_n=mysqli_query($link,$sql_n);
                    $row_n=mysqli_fetch_array($result_n);?>

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
                    
                    <div class="col-sm-2">
                    <h6 class="text-info">EDAD:</h6>
                    <?php 
                            $fecha_nino = $row_n[5];
                            $dia = date("d");
                            $mes = date("m");
                            $ano = date("Y");    
                            $dianaz = date("d",strtotime($fecha_nino));
                            $mesnaz = date("m",strtotime($fecha_nino));
                            $anonaz = date("Y",strtotime($fecha_nino));         
                            if (($mesnaz == $mes) && ($dianaz > $dia)) {
                            $ano=($ano-1); }      
                            if ($mesnaz > $mes) {
                            $ano=($ano-1);}       
                            $edad_n=($ano-$anonaz);                             
                            ?>
                        <input type="number" class="form-control" value="<?php echo $edad_n;?>" name="edad_actual" disabled>
                    </div>
                    <div class="col-sm-4">
                        <h6 class="text-info">CONTROLES DEL NIÑO SANO:</h6>  
                            <a class="btn btn-primary btn-icon-split" href="imprime_bja_nino.php?idbono_nino_sano=<?php echo $idbono_nino_sano_ss?>" target="_blank" onClick="window.open(this.href, this.target, 'width=950,height=1000,top=50, left=600, scrollbars=YES'); return false;">
                            <span class="icon text-white-50">
                                <i class="fas fa-book"></i>
                            </span>
                            <span class="text">FORMULARIO DE CONTROLES</span></a>  
                    </div>
                </div> 
                <div class="form-group row">  
                    <div class="col-sm-3">
                        <h6 class="text-info">LUGAR DE NACIMIENTO DEL NIÑO/NIÑA</h6>
                        <textarea name="lug_nac_titular" id="lug_nac_madre" class="form-control" disabled><?php echo $row_bj[15];?></textarea>
                    </div>
                    <div class="col-sm-2">
                        <h6 class="text-info">NUMERO DE CONTROLES</h6>
                        <input type="text" class="form-control" value="<?php echo $row_bj[11];?>" name="celular_madre" disabled> 
                    </div>
                    <div class="col-sm-3">
                        <h6 class="text-info">DIRECCION DEL DOMICILIO</h6>
                        <textarea name="lug_nac_titular" id="lug_nac_madre" class="form-control" disabled><?php echo $row_bj[13];?></textarea>
                    </div>
                    <div class="col-sm-4">
                        <h6 class="text-info">NIÑO CARPETIZADO</h6>
                        <?php
                        $sql_cf =" SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.codigo FROM carpeta_familiar, integrante_cf WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND integrante_cf.idnombre='$row_bj[8]' ";
                        $result_cf=mysqli_query($link,$sql_cf);
                        $row_cf=mysqli_fetch_array($result_cf);?>                       
                        <a class="btn btn-warning btn-icon-split" href="../carpetas_familiares/imprime_carpeta_familiar.php?idcarpeta_familiar=<?php echo $row_cf[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1300,height=1000,top=50, left=400, scrollbars=YES'); return false;">
                        <span class="icon text-white-50">
                            <i class="fas fa-book"></i>
                        </span>
                        <span class="text"> <?php echo $row_cf[1];?> </span></a> 
                    </div>
                </div>  


        <!-- DATOS DEL TITULAR DEL PAGO - BEGIN---->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">2.- IDENTIFICACIÓN DEL TITULAR DEL PAGO</h6>
        </div>
                <hr>
                    <?php
                    $sql_m =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$row_bj[9]' ";
                    $result_m=mysqli_query($link,$sql_m);
                    $row_m=mysqli_fetch_array($result_m);?>
            <div class="card-body">
                <div class="form-group row">                               
                    <div class="col-sm-3">
                    <h6 class="text-info">CÉDULA DE IDENTIDAD DEL TITULAR DEL PAGO:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_m[4];?>" 
                         name="ci" disabled>
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">NOMBRES DEL TITULAR DEL PAGO:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_m[1];?>"
                         name="nombre" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">PRIMER APELLIDO:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_m[2];?>"             
                         name="paterno" disabled >                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">SEGUNDO APELLIDO:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_m[3];?>" 
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
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_m[7]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                            placeholder="ingresar fecha" name="fecha_mac" value="<?php echo $row_m[5];?>" disabled>
                    </div>   
                    
                    <div class="col-sm-2">
                    <h6 class="text-info">EDAD:</h6>
                    <?php 
                            $fecha_mater = $row_m[5];
                            $dia = date("d");
                            $mes = date("m");
                            $ano = date("Y");    
                            $dianaz = date("d",strtotime($fecha_mater));
                            $mesnaz = date("m",strtotime($fecha_mater));
                            $anonaz = date("Y",strtotime($fecha_mater));         
                            if (($mesnaz == $mes) && ($dianaz > $dia)) {
                            $ano=($ano-1); }      
                            if ($mesnaz > $mes) {
                            $ano=($ano-1);}       
                            $edad_m=($ano-$anonaz);  
                        ?>
                        <input type="text" class="form-control" value="<?php echo $edad_m?>" name="edad_actual" disabled>
                    </div>
                    <div class="col-sm-4">
                        <h6 class="text-info">PARENTESCO CON EL NIÑO/NIÑA:</h6>  
                            <?php
                            $sql_pa =" SELECT parentesco FROM parentesco WHERE idparentesco='$row_bj[10]' ";
                            $result_pa=mysqli_query($link,$sql_pa);
                            $row_pa=mysqli_fetch_array($result_pa);
                            ?>
                            <input type="text" class="form-control" value="<?php echo $row_pa[0];?>" name="parentesco" disabled>  
                    </div>
                </div>  
                <div class="form-group row">  
                    <div class="col-sm-3">
                        <h6 class="text-info">LUGAR DE NACIMIENTO DEL TITULAR</h6>
                        <textarea name="lug_nac_titular" id="lug_nac_madre" class="form-control" disabled><?php echo $row_bj[15];?></textarea>
                    </div>
                    <div class="col-sm-3">
                        <h6 class="text-info">NUMERO DE CELULAR DEL TITULAR</h6>
                        <input type="text" class="form-control" value="<?php echo $row_bj[16];?>" name="celular_madre" disabled> 
                    </div>
                    <div class="col-sm-3">
                        <h6 class="text-info">CUENTA BANCARIA DEL TITULAR</h6>
                        <input type="text" class="form-control" value="<?php echo $row_bj[17];?>" name="cuanta_madre" disabled> 
                    </div>
                    <div class="col-sm-3">
                        <h6 class="text-info">FECHA DE INSCRIPCIÓN AL BONO</h6>
                        <input type="date" class="form-control" value="<?php echo $row_bj[18];?>" name="fecha_inscripcion_bono" disabled> 
                    </div>
                </div> 

        <!-- DATOS DEL TITULAR DEL PAGO - END ---->       

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

         <script src="../js/funciones.js"></script>

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