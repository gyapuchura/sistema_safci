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

$idcarpeta_familiar_ss = $_SESSION['idcarpeta_familiar_ss'];

$sql_cf =" SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.codigo, ubicacion_cf.iddepartamento, ubicacion_cf.idred_salud, ubicacion_cf.idmunicipio, ubicacion_cf.idestablecimiento_salud, ";
$sql_cf.=" ubicacion_cf.idarea_influencia, carpeta_familiar.fecha_apertura, carpeta_familiar.familia, ubicacion_cf.avenida_calle, ubicacion_cf.no_puerta, ubicacion_cf.nombre_edificio, ";
$sql_cf.=" ubicacion_cf.latitud, ubicacion_cf.longitud, ubicacion_cf.altura, carpeta_familiar.fecha_registro, carpeta_familiar.hora_registro ";
$sql_cf.=" FROM carpeta_familiar, ubicacion_cf WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_cf.=" AND ubicacion_cf.ubicacion_actual='SI' AND carpeta_familiar.idcarpeta_familiar='$idcarpeta_familiar_ss' ";
$result_cf=mysqli_query($link,$sql_cf);
$row_cf=mysqli_fetch_array($result_cf);
        
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
                    <a href="evaluacion_familiar_cf.php"><h6 class="text-info"><- VOLVER</h6></a>
                    <hr>             
                    <h4 class="text-info">CARPETA FAMILIAR:</h4>
                    <h4 class="text-primary"><?php echo $row_cf[1]; ?></h4>
                    <h4 class="text-info">19.- EVALUACIÓN DE SALUD FAMILIAR</h4>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->



                <div class="col-lg-12">  
                    <div class="p-2"> 

                    <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">DEPARTAMENTO:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="iddepartamento"  id="iddepartamento" class="form-control" disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT iddepartamento, departamento FROM departamento ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_cf[2]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <select name="idred_salud"  id="idred_salud" class="form-control" disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idred_salud, red_salud FROM red_salud ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_cf[3]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <select name="idmunicipio"  id="idmunicipio" class="form-control" disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idmunicipio, municipio FROM municipios ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_cf[4]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <select name="idestablecimiento_salud"  id="idestablecimiento_salud" class="form-control" disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_cf[5]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>
                    </div>
                </div>

<!------- DATOS DEL AREA DE INFLUENCIA ---------->
      
                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">ÁREA DE INFLUENCIA:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idarea_influencia"  id="idarea_influencia" class="form-control" disabled>
                      
                        <?php
                        $sql1 = " SELECT area_influencia.idarea_influencia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia FROM area_influencia, tipo_area_influencia, establecimiento_salud ";
                        $sql1.= " WHERE area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND area_influencia.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
                        $sql1.= " AND area_influencia.idarea_influencia='$row_cf[6]' ";
                        $result1 = mysqli_query($link,$sql1);
                        if ($row1 = mysqli_fetch_array($result1)){
                        mysqli_field_seek($result1,0);
                        while ($field1 = mysqli_fetch_field($result1)){
                        } do {
                        echo "<option value=".$row1[0].">".$row1[1].".- ".$row1[2]."</option>";
                        } while ($row1 = mysqli_fetch_array($result1));
                        } else {
                        echo "No se encontraron resultados!";
                        }
                        ?>
                    </select>
                    </div>
                </div>         
                <div class="form-group row">   
                    <div class="col-sm-3">
                    <h6 class="text-primary">FECHA DE APERTURA:</h6>
                    </div>
                    <div class="col-sm-3">                    
                    <input type="date" class="form-control" name="fecha_apertura" value="<?php echo $row_cf[7];?>" disabled>                
                    </div>    
                    <div class="col-sm-1">
                    <h6 class="text-primary">FAMILIA:</h6>
                    </div>                        
                    <div class="col-sm-5">    
                    <input type="text" class="form-control" name="familia" value="<?php echo $row_cf[8];?>" disabled>                                
                    </div>
                </div>
            <hr>

            <div class="text-center">                                     
                <h4 class="text-info">19.- EVALUACIÓN DE SALUD FAMILIAR:</h4>                    
            </div>   
     <hr>

     <div class="form-group row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped" id="example" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-info">Nª</th>
                                    <th class="text-info">EVALUACIÓN DE LAS DETERMINANTES DE LA SALUD:</th>
                                    <th class="text-info">EVALUACIÓN DE LA SALUD DE LOS INTEGRANTES DE LA FAMILIA:</th>
                                    <th class="text-info">EVALUACIÓN DE LA FUNCIONALIDAD FAMILIAR:</th>
                                    <th class="text-info">EVALUACIÓN FAMILIAR:</th>
                                    <th class="text-info">FECHA DE REGISTRO</th>
                                    <th class="text-info">ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $numero5=1;
                                    $sql5 =" SELECT idevaluacion_familiar_cf, determinante_salud, salud_integrantes, funcionalidad_familiar, evaluacion_familiar, fecha_registro FROM evaluacion_familiar_cf ";
                                    $sql5.=" WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                                    $result5 = mysqli_query($link,$sql5);
                                    if ($row5 = mysqli_fetch_array($result5)){
                                    mysqli_field_seek($result5,0);
                                    while ($field5 = mysqli_fetch_field($result5)){
                                    } do { 
                                    ?>
                                    <tr>
                                        <td><?php echo $numero5;?></td>
                                        <td><?php echo $row5[1];?></td>
                                        <td><?php echo $row5[2];?></td>
                                        <td><?php echo $row5[3];?></td>
                                        <td><?php echo $row5[4];?></td>
                                        <td>
                                        <?php 
                                            $fecha_s = explode('-',$row5[5]);
                                            $fecha_reg = $fecha_s[2].'/'.$fecha_s[1].'/'.$fecha_s[0];
                                            echo $fecha_reg; ?>
                                        </td>
                                        <td>
                                        <form name="BORRAR" action="elimina_evaluacion_familiar_cf.php" method="post">  
                                        <input type="hidden" name="idevaluacion_familiar_cf" value="<?php echo $row5[0];?>">
                                        <button type="submit" class="btn btn-danger">QUITAR</button></form>
                                        </td>
                                    </tr>                            
                                    <?php
                                    $numero5=$numero5+1;
                                    }
                                    while ($row5 = mysqli_fetch_array($result5));
                                    } else {
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>  
        <hr> 

        <form name="GUARDA_EVALUACION" action="guarda_evaluacion_familiar.php" method="post"> 

            <div class="form-group row">  
            <div class="col-sm-6"><h6 class="text-info">RESULTADO DE LAS DETERMINANTES DE LA SALUD</h6>
            <h6> 
            <?php  
            /******  RIESGO DE LOS SERVICIOS BASICOS  ******/
                $sqla = "SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='1' ";
                $resulta = mysqli_query($link,$sqla);
                $rowa = mysqli_fetch_array($resulta);

        /***  RIESGO ESTRUCTURAL DE LA VIVIENDA *****/

                $sqlb = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='2' ";
                $resultb = mysqli_query($link,$sqlb);
                $rowb = mysqli_fetch_array($resultb);

        /** RIESGO DE LA FUNCIONALIDAD DE LA VIVIENDA ***/

                $sqlc = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='3' ";
                $resultc = mysqli_query($link,$sqlc);
                $rowc = mysqli_fetch_array($resultc);

        /** RIESGO DE LA SALUD ALIMENTARIA */

                $sqld = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='4' AND idcat_determinante_salud='19' ";
                $resultd = mysqli_query($link,$sqld);
                $rowd = mysqli_fetch_array($resultd);
                $durante = $rowd[0];

                if ($durante == '0') {
                    $grado_alimentario = '1';
                } else {
                    if ($durante <= 3) {
                        $grado_alimentario = '3';
                    } else {
                        if ($durante <= 5) {
                            $grado_alimentario = '4';
                        } else {
                            if ($durante >= 6) {
                                $grado_alimentario = '5';
                            } else {  } } } }

                $sqlcon = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='4' AND idcat_determinante_salud='21' ";
                $resultcon = mysqli_query($link,$sqlcon);
                $rowcon = mysqli_fetch_array($resultcon);
                $consumo = $rowcon[0];
                $alimentaria = $grado_alimentario + $consumo;

            /**RIESGO DE LAS DETERMINANTES DE LA SALUD */

                $riesgo_total = $rowa[0] + $rowb[0] + $rowc[0] + $alimentaria;

                if ($riesgo_total <= 33) {
                $sql5 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='1'  ";
                $result5 = mysqli_query($link,$sql5);
                $row5 = mysqli_fetch_array($result5);
                echo "<h6 class='text-secundary'> = ".$riesgo_total." .- ".$row5[0]."</h6>"; 
                $determinante_salud = $row5[0];
                ?>
                <input type="hidden" name="determinante_salud" value="<?php echo $row5[0]." EN LAS DETERMINANTES DE LA SALUD ";?>">
                <?php
            } else {
                if ($riesgo_total <= 60) {
                    $sql6 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='2' ";
                    $result6 = mysqli_query($link,$sql6);
                    $row6 = mysqli_fetch_array($result6);
                    echo "<h6 class='text-info'> = ".$riesgo_total." .- ".$row6[0]."</h6>";
                    $determinante_salud = $row6[0];
                    ?>
                    <input type="hidden" name="determinante_salud" value="<?php echo $row6[0]." EN LAS DETERMINANTES DE LA SALUD ";?>">
                    <?php
                } else {
                    if ($riesgo_total <= 88) {
                            $sql7 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='3' ";
                            $result7 = mysqli_query($link,$sql7);
                            $row7 = mysqli_fetch_array($result7);
                            echo "<h6 class='text-primary'> = ".$riesgo_total." .- ".$row7[0]."</h6>";
                            $determinante_salud = $row7[0];
                            ?>
                            <input type="hidden" name="determinante_salud" value="<?php echo $row7[0]." EN LAS DETERMINANTES DE LA SALUD ";?>">
                            <?php
                    } else {
                        if ($riesgo_total <= 121) {
                                $sql8 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='4' ";
                                $result8 = mysqli_query($link,$sql8);
                                $row8 = mysqli_fetch_array($result8);
                                echo "<h6 class='text-warning'> = ".$riesgo_total." .- ".$row8[0]."</h6>";
                                $determinante_salud = $row8[0];
                                ?>
                                <input type="hidden" name="determinante_salud" value="<?php echo $row8[0]." EN LAS DETERMINANTES DE LA SALUD ";?>">
                                <?php
                        } else { 
                            if ($riesgo_total <= 165) {
                                    $sql9 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='5' ";
                                    $result9 = mysqli_query($link,$sql9);
                                    $row9 = mysqli_fetch_array($result9);
                                    echo "<h6 class='text-danger'> ".$riesgo_total." .- ".$row9[0]."</h6>";
                                    $determinante_salud = $row9[0];
                                    ?>
                                    <input type="hidden" name="determinante_salud" value="<?php echo $row9[0]." EN LAS DETERMINANTES DE LA SALUD ";?>">
                                    <?php
                            } else {  } } } } }                              
            ?>
            
        
        </h6></div>
            <div class="col-sm-6"><h6 class="text-info">LA SALUD DE LOS INTEGRANTES DE LA FAMILIA</h6>
            <?php
            
                $sql_s = " SELECT idintegrante_discapacidad, idintegrante_cf, idgrupo_cf, idcarpeta_familiar FROM integrante_discapacidad WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                $result_s = mysqli_query($link,$sql_s);      
                $row_s = mysqli_fetch_array($result_s);
                  
                   $salud_integrantes_4 = "GRUPO IV";

                    $sql_t = " SELECT idintegrante_morbilidad, idintegrante_cf, idgrupo_cf, idcarpeta_familiar FROM integrante_morbilidad WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                    $result_t = mysqli_query($link,$sql_t);      
                    $row_t = mysqli_fetch_array($result_t);
                       
                     $salud_integrantes_3 = "GRUPO III";   
                               
                            $sql_u = " SELECT idintegrante_factor_riesgo, idintegrante_cf, idgrupo_cf, idcarpeta_familiar FROM integrante_factor_riesgo WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                            $result_u = mysqli_query($link,$sql_u);      
                            $row_u = mysqli_fetch_array($result_u);
                                
                                $salud_integrantes_2 = "GRUPO II";

                                $sql_u = " SELECT idintegrante_ap_sano, idintegrante_cf, idgrupo_cf, idcarpeta_familiar FROM integrante_ap_sano WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                                $result_u = mysqli_query($link,$sql_u);      
                                $row_u = mysqli_fetch_array($result_u);
                                    
                                    $salud_integrantes_1 = "GRUPO I";

                                    $salud_integrantes = $salud_integrantes_1." - ".$salud_integrantes_2." - ".$salud_integrantes_3." - ".$salud_integrantes_4;

                                    echo "Los integrantes de la familia corresponden a los: ".$salud_integrantes;

                                    ?>
                                    <input type="hidden" name="salud_integrantes" value="<?php echo $salud_integrantes; ?>">

            </div>
            </div>
            <hr>
            <div class="form-group row"> 
            <div class="col-sm-4"><h6 class="text-info">EL FUNCIONAMIENTO DE LA FAMILIA:</h6>
            <?php

                $sql_ev =" SELECT funcionalidad_familiar_cf.idfuncionalidad_familiar_cf, funcionalidad_familiar.funcionalidad_familiar, funcionalidad_familiar_cf.fecha_registro ";
                $sql_ev.=" FROM funcionalidad_familiar_cf, funcionalidad_familiar WHERE funcionalidad_familiar_cf.idfuncionalidad_familiar=funcionalidad_familiar.idfuncionalidad_familiar ";
                $sql_ev.=" AND funcionalidad_familiar_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' AND funcionalidad_familiar.funcional='NO' ";
                $result_ev = mysqli_query($link,$sql_ev);
                if ($row_ev = mysqli_fetch_array($result_ev)){

                    echo " <h6 class='text-danger'>FAMILIA DISFUNCIONAL</h6>";
                    $funcionalidad_familiar = "DISFUNCIONAL";
                    ?>
                    <input type="hidden" name="funcionalidad_familiar" value="DISFUNCIONAL">
                    <?php
                        
                    } else {

                        $sql_dev =" SELECT funcionalidad_familiar_cf.idfuncionalidad_familiar_cf, funcionalidad_familiar.funcionalidad_familiar, funcionalidad_familiar_cf.fecha_registro ";
                        $sql_dev.=" FROM funcionalidad_familiar_cf, funcionalidad_familiar WHERE funcionalidad_familiar_cf.idfuncionalidad_familiar=funcionalidad_familiar.idfuncionalidad_familiar ";
                        $sql_dev.=" AND funcionalidad_familiar_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' AND funcionalidad_familiar.funcional='SI' ";
                        $result_dev = mysqli_query($link,$sql_dev);
                        if ($row_dev = mysqli_fetch_array($result_dev)){
                            echo "<h6 class='text-primary'>FUNCIONAL </h6>";
                            $funcionalidad_familiar = "FUNCIONAL";
                            ?>
                            <input type="hidden" name="funcionalidad_familiar" value="FUNCIONAL">
                            <?php
                        } else {
                            echo " <h6>SIN EVALUAR</h6>"; 
                        }                                
                    }                                
            ?>
            </div>
            <div class="col-sm-4">
            <h6 class="text-info">EVALUACIÓN FAMILIAR:</h6> 
            <?php
                if ($determinante_salud == 'SIN RIESGO' || $determinante_salud == 'RIESGO LEVE') {
                    if ($salud_integrantes == 'GRUPO I') {
                       if ($funcionalidad_familiar == 'FUNCIONAL') {
                        echo "FAMILIA CON RIESGO BAJO";
                        $evaluacion_familiar = 'FAMILIA CON RIESGO BAJO';
                        ?>
                        <input type="hidden" name="evaluacion_familiar" value="FAMILIA CON RIESGO BAJO">
                        <?php
                       } else { }} else { }
                    
                } else {
                    if ($determinante_salud == 'RIESGO MODERADO') {
                        if ($salud_integrantes != 'GRUPO I') {
                            if ($funcionalidad_familiar == 'FUNCIONAL' || $funcionalidad_familiar == 'DISFUNCIONAL') {
                                echo "FAMILIA CON RIESGO MEDIANO";
                                $evaluacion_familiar = 'FAMILIA CON RIESGO MEDIANO';
                                ?>
                                <input type="hidden" name="evaluacion_familiar" value="FAMILIA CON RIESGO MEDIANO">
                                <?php
                            } else { }
                            
                        } else { }
                        
                    } else {
                        if ($determinante_salud == 'RIESGO GRAVE' || $determinante_salud == 'RIESGO MUY GRAVE') {
                            if ($salud_integrantes != 'GRUPO I') {
                               if ($funcionalidad_familiar == 'DISFUNCIONAL') {
                                echo "FAMILIA CON RIESGO ALTO";
                                $evaluacion_familiar = 'FAMILIA CON RIESGO ALTO';
                                ?>
                                <input type="hidden" name="evaluacion_familiar" value="FAMILIA CON RIESGO ALTO">
                                <?php
                               } else { }
                         } else { } } else { } } }
                
            ?>
            </div>
            <div class="col-sm-4">
            <h6 class="text-info">FECHA DE REGISTRO:</h6>    
            <input type="date"  class="form-control" name="fecha_registro" value="<?php echo $fecha;?>" autofocus>
            </div>
            </div>
            <hr>
            <div class="form-group row"> 
            <div class="col-sm-4"></div> 
            <div class="col-sm-8"></br>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalr">
            REGISTRAR EVALUACIÓN FAMILIAR
            </button>  
            </div>  
    </div>

    <div class="modal fade" id="exampleModalr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EVALUACIÓN FAMILIAR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">                                    
                    Esta seguro de agregar la EVALUACIÓN FAMILIAR? ?
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                <button type="submit" class="btn btn-info pull-center">CONFIRMAR</button>    
                </div>
            </div>
        </div>
    </div>
    </form>

    </div>  
       
     <!-------- CONSOLIDA CARPETA FAMILIAR (Begin) --------->   
    
            <form name="CONSOLIDA_CF" action="guarda_consolidacion_cf.php" method="post">                   

                <div class="form-group row">  
                    <div class="col-sm-3"></div>    
                    <div class="col-sm-9"> 
 
                    </div>
                </div>
                <hr>
                    <div class="text-center">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModale">
                        CONSOLIDAR CARPETA FAMILIAR
                        </button>  
                    </div>  
    
                <!-- modal de confirmacion de envio de datos-->
                <div class="modal fade" id="exampleModale" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">CONSOLIDAR CARPETA FAMILIAR</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">                                    
                                    Esta seguro de CONSOLIDAR la CONSOLIDAR la CARPETA FAMILIAR? ?
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                <button type="submit" class="btn btn-info pull-center">CONFIRMAR</button>    
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
<hr>

      
            <div class="text-center"> 
               <a href="finalizacion_visita.php"><h6 class="text-info">FINALIZAR VISITA -></h6></a>                                                                   
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
 
</body>
</html>