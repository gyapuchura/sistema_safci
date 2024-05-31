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
                    <a href="integrantes_cf.php"><h6 class="text-info"><- VOLVER</h6></a>
                    <hr>             
                    <h4 class="text-info">CARPETA FAMILIAR:</h4>
                    <h4 class="text-primary"><?php echo $row_cf[1]; ?></h4>
                    <h4 class="text-info">10.- DETERMINANTES DE LA SALUD</h4>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->


                <div class="col-lg-12">  
                    <div class="p-2"> 

                    <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-info">DEPARTAMENTO:</h6>
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
                    <h6 class="text-info">RED DE SALUD:</h6>
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
                    <h6 class="text-info">MUNICIPIO:</h6>
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
                    <h6 class="text-info">ESTABLECIMIENTO DE SALUD:</h6>
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
                    <h6 class="text-info">ÁREA DE INFLUENCIA:</h6>
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
                    <h6 class="text-info">FECHA DE APERTURA:</h6>
                    </div>
                    <div class="col-sm-3">                    
                    <input type="date" class="form-control" name="fecha_apertura" value="<?php echo $row_cf[7];?>" disabled>                
                    </div>    
                    <div class="col-sm-2">
                    <h6 class="text-info">FAMILIA:</h6>
                    </div>                        
                    <div class="col-sm-4">    
                    <input type="text" class="form-control" name="familia" value="<?php echo $row_cf[8];?>" disabled>                                
                    </div>
                </div>
            <hr>
 
    <!-------- ETAPA DE IDENTIFICACIÓN DEL INTEGRANTE FAMILIAR (BEGIN) --------->
        <hr>
            <div class="text-center">                                     
                <h4 class="text-info">10. DETERMINANTES DE LA SALUD:</h4>                    
            </div>
        <hr>

    <!-------- ETAPA DE IDENTIFICACIÓN DEL INTEGRANTE FAMILIAR (BEGIN) --------->

    <div class="form-group row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped" id="example" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-info">Nª</th>
                                    <th class="text-info">DETERMINANTE</th>
                                    <th class="text-info">ASPECTO</th>
                                    <th class="text-info">FACTOR DETERMINANTE</th>
                                    <th class="text-info">VALOR</th>
                                    <th class="text-info">ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                    $numero=1;
                                    $sql4 =" SELECT determinante_salud_cf.iddeterminante_salud_cf, determinante_salud.determinante_salud, cat_determinante_salud.cat_determinante_salud, ";
                                    $sql4.=" item_determinante_salud.item_determinante_salud, determinante_salud_cf.valor_cf FROM determinante_salud_cf, determinante_salud, cat_determinante_salud, item_determinante_salud ";
                                    $sql4.=" WHERE determinante_salud_cf.iddeterminante_salud=determinante_salud.iddeterminante_salud AND determinante_salud_cf.idcat_determinante_salud=cat_determinante_salud.idcat_determinante_salud AND ";
                                    $sql4.=" determinante_salud_cf.iditem_determinante_salud=item_determinante_salud.iditem_determinante_salud AND determinante_salud_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                                    $result4 = mysqli_query($link,$sql4);
                                    if ($row4 = mysqli_fetch_array($result4)){
                                    mysqli_field_seek($result4,0);
                                    while ($field4 = mysqli_fetch_field($result4)){
                                    } do { 
                                    ?>
                                    <tr>
                                        <td><?php echo $numero;?></td>
                                        <td><?php echo $row4[1];?></td>
                                        <td><?php echo $row4[2];?></td>
                                        <td><?php echo $row4[3];?></td>
                                        <td><?php echo $row4[4];?></td>
                                        <td>
                                        <form name="BORRAR" action="elimina_determinante_salud_cf.php" method="post">  
                                        <input type="hidden" name="iddeterminante_salud_cf" value="<?php echo $row4[0];?>">
                                        <button type="submit" class="btn btn-danger">QUITAR</button></form> </td>
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

            <div class="card shadow mb-4">
                    <div class="card-header py-3">
                    <h6 class="text-info">RIESGO DE LAS DETERMINANTES EN SALUD</h6>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-3">
                            <h6 class="text-info">RIESGO DE LOS SERVICIOS BÁSICOS</h6>
                            <?php  
                                    $sqla = "SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='1' ";
                                    $resulta = mysqli_query($link,$sqla);
                                    $rowa = mysqli_fetch_array($resulta);
                                    echo "</br> = ".$rowa[0];

                                    $sumatoria = $rowa[0];
                                        if ($sumatoria <= 7 ) {
                                            $sql5 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='1'  ";
                                            $result5 = mysqli_query($link,$sql5);
                                            $row5 = mysqli_fetch_array($result5);
                                            echo "<h6 class='text-secundary'>".$row5[0]."</h6>";
                                        } else {
                                            if ($sumatoria <= 11 ) {
                                                $sql6 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='2' ";
                                                $result6 = mysqli_query($link,$sql6);
                                                $row6 = mysqli_fetch_array($result6);
                                                echo "<h6 class='text-info'>".$row6[0]."</h6>";
                                            } else {
                                                if ($sumatoria <= 17) {
                                                        $sql7 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='3' ";
                                                        $result7 = mysqli_query($link,$sql7);
                                                        $row7 = mysqli_fetch_array($result7);
                                                        echo "<h6 class='text-primary'>".$row7[0]."</h6>";
                                                } else {
                                                    if ($sumatoria <= 24) {
                                                            $sql8 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='4' ";
                                                            $result8 = mysqli_query($link,$sql8);
                                                            $row8 = mysqli_fetch_array($result8);
                                                            echo "<h6 class='text-warning'>".$row8[0]."</h6>";
                                                    } else { 
                                                        if ($sumatoria <= 35) {
                                                                $sql9 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='5' ";
                                                                $result9 = mysqli_query($link,$sql9);
                                                                $row9 = mysqli_fetch_array($result9);
                                                                echo "<h6 class='text-danger'>".$row9[0]."</h6>";
                                                        } else {  } } } } }

                            ?>
                            <h6></h6>
                            </div>
                            <div class="col-sm-3">
                            <h6 class="text-info">RIESGO ESTRUCTURAL DE LA VIVIENDA</h6>
                            <?php  
                                    $sqlb = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='2' ";
                                    $resultb = mysqli_query($link,$sqlb);
                                    $rowb = mysqli_fetch_array($resultb);
                                    echo "</br> = ".$rowb[0];

                                    $sumatoria = $rowb[0];
                                    if ($sumatoria <= 16 ) {
                                        $sql5 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='1'  ";
                                        $result5 = mysqli_query($link,$sql5);
                                        $row5 = mysqli_fetch_array($result5);
                                        echo "<h6 class='text-secundary'>".$row5[0]."</h6>";
                                    } else {
                                        if ($sumatoria <= 31 ) {
                                            $sql6 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='2' ";
                                            $result6 = mysqli_query($link,$sql6);
                                            $row6 = mysqli_fetch_array($result6);
                                            echo "<h6 class='text-info'>".$row6[0]."</h6>";
                                        } else {
                                            if ($sumatoria <= 41) {
                                                    $sql7 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='3' ";
                                                    $result7 = mysqli_query($link,$sql7);
                                                    $row7 = mysqli_fetch_array($result7);
                                                    echo "<h6 class='text-primary'>".$row7[0]."</h6>";
                                            } else {
                                                if ($sumatoria <= 56) {
                                                        $sql8 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='4' ";
                                                        $result8 = mysqli_query($link,$sql8);
                                                        $row8 = mysqli_fetch_array($result8);
                                                        echo "<h6 class='text-warning'>".$row8[0]."</h6>";
                                                } else { 
                                                    if ($sumatoria <= 80) {
                                                            $sql9 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='5' ";
                                                            $result9 = mysqli_query($link,$sql9);
                                                            $row9 = mysqli_fetch_array($result9);
                                                            echo "<h6 class='text-danger'>".$row9[0]."</h6>";
                                                    } else {  } } } } }

                            ?>
                            <h6></h6>
                            </div>
                            <div class="col-sm-3">
                            <h6 class="text-info">RIESGO DE LA FUNCIONALIDAD DE LA VIVIENDA</h6>
                            <?php  
                                    $sqlc = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' AND iddeterminante_salud='3' ";
                                    $resultc = mysqli_query($link,$sqlc);
                                    $rowc = mysqli_fetch_array($resultc);
                                    echo " = ".$rowc[0];

                                    $sumatoria = $rowc[0];
                                    if ($sumatoria <= 3) {
                                        $sql5 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='1'  ";
                                        $result5 = mysqli_query($link,$sql5);
                                        $row5 = mysqli_fetch_array($result5);
                                        echo "<h6 class='text-secundary'>".$row5[0]."</h6>";
                                    } else {
                                        if ($sumatoria <= 5) {
                                            $sql6 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='2' ";
                                            $result6 = mysqli_query($link,$sql6);
                                            $row6 = mysqli_fetch_array($result6);
                                            echo "<h6 class='text-info'>".$row6[0]."</h6>";
                                        } else {
                                            if ($sumatoria <= 9) {
                                                    $sql7 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='3' ";
                                                    $result7 = mysqli_query($link,$sql7);
                                                    $row7 = mysqli_fetch_array($result7);
                                                    echo "<h6 class='text-primary'>".$row7[0]."</h6>";
                                            } else {
                                                if ($sumatoria <= 11) {
                                                        $sql8 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='4' ";
                                                        $result8 = mysqli_query($link,$sql8);
                                                        $row8 = mysqli_fetch_array($result8);
                                                        echo "<h6 class='text-warning'>".$row8[0]."</h6>";
                                                } else { 
                                                    if ($sumatoria <= 15) {
                                                            $sql9 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='5' ";
                                                            $result9 = mysqli_query($link,$sql9);
                                                            $row9 = mysqli_fetch_array($result9);
                                                            echo "<h6 class='text-danger'>".$row9[0]."</h6>";
                                                    } else {  } } } } }

                            ?>
                            <h6></h6>
                            </div>
                            <div class="col-sm-3">
                            <h6 class="text-info">RIESGO DE LA SALUD ALIMENTARIA</h6>
                            <?php  
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

                                    echo "</br>= ".$alimentaria;

                                    if ($alimentaria <= 7) {
                                        $sql5 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='1'  ";
                                        $result5 = mysqli_query($link,$sql5);
                                        $row5 = mysqli_fetch_array($result5);
                                        echo "<h6 class='text-secundary'>".$row5[0]."</h6>";
                                    } else {
                                        if ($alimentaria <= 13) {
                                            $sql6 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='2' ";
                                            $result6 = mysqli_query($link,$sql6);
                                            $row6 = mysqli_fetch_array($result6);
                                            echo "<h6 class='text-info'>".$row6[0]."</h6>";
                                        } else {
                                            if ($alimentaria <= 21) {
                                                    $sql7 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='3' ";
                                                    $result7 = mysqli_query($link,$sql7);
                                                    $row7 = mysqli_fetch_array($result7);
                                                    echo "<h6 class='text-primary'>".$row7[0]."</h6>";
                                            } else {
                                                if ($alimentaria <= 30) {
                                                        $sql8 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='4' ";
                                                        $result8 = mysqli_query($link,$sql8);
                                                        $row8 = mysqli_fetch_array($result8);
                                                        echo "<h6 class='text-warning'>".$row8[0]."</h6>";
                                                } else { 
                                                    if ($alimentaria <= 35) {
                                                            $sql9 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='5' ";
                                                            $result9 = mysqli_query($link,$sql9);
                                                            $row9 = mysqli_fetch_array($result9);
                                                            echo "<h6 class='text-danger'>".$row9[0]."</h6>";
                                                    } else {  } } } } }

                            ?>
                            <h6></h6>
                            </div>
                        </div>   

                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-5">
                            <h6 class="text-info">RIESGO DE LAS DETERMINANTES DE LA SALUD</h6>
                            </div>
                            <div class="col-sm-7">
                          
                                <?php 
                                    $riesgo_total = $rowa[0] + $rowb[0] + $rowc[0] + $alimentaria;

                                  if ($riesgo_total <= 33) {
                                    $sql5 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='1'  ";
                                    $result5 = mysqli_query($link,$sql5);
                                    $row5 = mysqli_fetch_array($result5);
                                    echo "<h6 class='text-secundary'> = ".$riesgo_total." .- ".$row5[0]."</h6>";
                                } else {
                                    if ($riesgo_total <= 60) {
                                        $sql6 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='2' ";
                                        $result6 = mysqli_query($link,$sql6);
                                        $row6 = mysqli_fetch_array($result6);
                                        echo "<h6 class='text-info'> = ".$riesgo_total." .- ".$row6[0]."</h6>";
                                    } else {
                                        if ($riesgo_total <= 88) {
                                                $sql7 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='3' ";
                                                $result7 = mysqli_query($link,$sql7);
                                                $row7 = mysqli_fetch_array($result7);
                                                echo "<h6 class='text-primary'> = ".$riesgo_total." .- ".$row7[0]."</h6>";
                                        } else {
                                            if ($riesgo_total <= 121) {
                                                    $sql8 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='4' ";
                                                    $result8 = mysqli_query($link,$sql8);
                                                    $row8 = mysqli_fetch_array($result8);
                                                    echo "<h6 class='text-warning'> = ".$riesgo_total." .- ".$row8[0]."</h6>";
                                            } else { 
                                                if ($riesgo_total <= 165) {
                                                        $sql9 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='5' ";
                                                        $result9 = mysqli_query($link,$sql9);
                                                        $row9 = mysqli_fetch_array($result9);
                                                        echo "<h6 class='text-danger'> ".$riesgo_total." .- ".$row9[0]."</h6>";
                                                } else {  } } } } }                              
                                ?>
                            </div>
                        </div>


                    </div>

                    </div>
            


     <!-------- INGRESA NUEVO INTEGRANTE DE LA FAMILIA (Begin) --------->                         
        <hr>
        <div class="text-center">                                     
            <h4 class="text-info">AGREGAR DETERMINANTES DE LA SALUD:</h4>                    
        </div>
        <hr>

<form name="INTEGRANTE" action="guarda_determinante_salud.php" method="post">  
 
<div class="form-group row">  
    <div class="col-sm-3">
    <h6 class="text-info">DETERMINANTE DE SALUD</h6>
    </div>
    <div class="col-sm-9">    
        <select name="iddeterminante_salud" id="iddeterminante_salud" class="form-control" required autofocus>
        <option value="">-SELECCIONE-</option>
        <?php
        $sql1 = "SELECT iddeterminante_salud, determinante_salud FROM determinante_salud ";
        $result1 = mysqli_query($link,$sql1);
        if ($row1 = mysqli_fetch_array($result1)){
        mysqli_field_seek($result1,0);
        while ($field1 = mysqli_fetch_field($result1)){
        } do {
        echo "<option value=".$row1[0].">".$row1[0].".- ".$row1[1]."</option>";
        } while ($row1 = mysqli_fetch_array($result1));
        } else {
        echo "No se encontraron resultados!";
        }
        ?>
        </select>
    </div>
</div>


<div id='cat_determinante_salud_cf'></div>

<div class="form-group row">      
        <div class="col-sm-12"></br>
            <button type="submit" class="btn btn-info btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-file"></i>
            </span>
            <span class="text">REGISTRAR FACTOR DETERMINANTE</span>    
            </button>
        </div>    
</div> 
    </form>
<hr>
                            
            
               
    <!-------- ETAPA DE IDENTIFICACIÓN DEL INTEGRANTE FAMILIAR (BEGIN) --------->
          
             <div class="text-center"> 
               <a href="#"><h6 class="text-success">SIGUIENTE -></h6></a>                                                                   
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
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
                
        <script language="javascript">
            $(document).ready(function(){
            $("#iddeterminante_salud").change(function () {
                        $("#iddeterminante_salud option:selected").each(function () {
                            determinante_salud=$(this).val();
                        $.post("cat_determinante_salud_cf.php", {determinante_salud:determinante_salud}, function(data){
                        $("#cat_determinante_salud_cf").html(data);
                        });
                    });
            })
            });
        </script> 

</body>
</html> 