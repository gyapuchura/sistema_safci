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

$idhistoria_perinatal = $_GET['idhistoria_perinatal'];

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

    <title>HISTORIA CLINICA PERINATAL - SAFCI</title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">


</head>

<body id="page-top">

    <!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!---------------------- FORMULARIO DE HISTORIA CLINICA PERINATAL D7 (begin) ------------->
                    </br>          
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="text-center">
                        <h4 class="m-0 font-weight-bold text-warning">ANTECEDENTES HISTORIA PERINATAL</h4>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-warning">IDENTIFICACIÓN DE LA INTEGRANTE DE LA FAMILIA</h6>
                            </div>
                            <div class="card-body">

                                <form name="PERINATAL" action="guarda_historia_perinatal.php" method="post"> 

                                <div class="form-group row">                               
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">CÉDULA DE IDENTIDAD:</h6>
                                        <input type="number" class="form-control" value="<?php echo $row_n[4];?>" 
                                        name="ci" disabled>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">NOMBRES:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row_n[1];?>"
                                        name="nombre" disabled>                
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">PRIMER APELLIDO:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row_n[2];?>"             
                                        name="paterno" disabled >                
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">SEGUNDO APELLIDO:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row_n[3];?>" 
                                        name="materno" disabled>                
                                    </div>
                                </div>

                                <div class="form-group row">  
                                <div class="col-sm-3">
                                <h6 class="text-warning">GÉNERO</h6>

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
                                <h6 class="text-warning">FECHA DE NACIMIENTO:</h6>
                                    <input type="date"  class="form-control" 
                                        placeholder="ingresar fecha" name="fecha_nac" value="<?php echo $row_n[5];?>" disabled>
                                </div>   
                                
                                <div class="col-sm-2">
                                <h6 class="text-warning">EDAD:</h6>
                                    <input type="number" class="form-control" value="<?php echo $edad_ss;?>" 
                                    name="edad_actual" disabled>
                                </div>
                                <div class="col-sm-4">
                                <h6 class="text-warning">VER CARPETA FAMILIAR:</h6>
                                <a class="btn btn-warning btn-icon-split" href="../carpetas_familiares/imprime_carpeta_familiar.php?idcarpeta_familiar=<?php echo $idcarpeta_familiar_ss;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1400,height=800,top=50, left=200, scrollbars=YES'); return false;">              
                                <span class="icon text-white-50">
                                    <i class="fas fa-file"></i>
                                </span>
                                <span class="text"><?php echo $row_cf[1];?></span></a> 
                                </div>
                                </div>  
                              
                            </div>                                
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-warning">1.- ANTECEDENTES </h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-6">
                                         <h6 class="text-warning">FAMILIARES:</h6>
                                            <?php
                                            $numero_e=0;
                                            $sql_e =" SELECT antecedente_enfermedad.idantecedente_enfermedad, antecedente_enfermedad.antecedente_enfermedad, antecedente_perinatal.valor_antecedente_perinatal  ";
                                            $sql_e.=" FROM antecedente_perinatal, antecedente_enfermedad WHERE antecedente_perinatal.idantecedente_enfermedad=antecedente_enfermedad.idantecedente_enfermedad  ";
                                            $sql_e.=" AND antecedente_perinatal.idtipo_antecedente_enfermedad='2' AND antecedente_perinatal.idhistoria_perinatal='$idhistoria_perinatal'  ";
                                            $result_e = mysqli_query($link,$sql_e);
                                            if ($row_e = mysqli_fetch_array($result_e)){
                                            mysqli_field_seek($result_e,0);
                                            while ($field_e = mysqli_fetch_field($result_e)){
                                            } do {
                                            ?>

                                                SI <input type="radio" name="valor_antecedente_familiar[<?php echo $numero_e;?>]" value="NO" <?php if ($row_e[2] =='NO') { echo 'checked'; } ?> disabled> - 
                                                NO <input type="radio" name="valor_antecedente_familiar[<?php echo $numero_e;?>]" value="SI" <?php if ($row_e[2] =='SI') { echo 'checked'; } ?> disabled> -> <?php echo $row_e[1];?></br> 
                                            <?php
                                            $numero_e=$numero_e+1;
                                            }
                                            while ($row_e = mysqli_fetch_array($result_e));
                                            } else {
                                            }
                                            ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <h6 class="text-warning">PERSONALES:</h6>
                                            <?php
                                            $numero_e=0;
                                            $sql_e =" SELECT antecedente_enfermedad.idantecedente_enfermedad, antecedente_enfermedad.antecedente_enfermedad, antecedente_perinatal.valor_antecedente_perinatal  ";
                                            $sql_e.=" FROM antecedente_perinatal, antecedente_enfermedad WHERE antecedente_perinatal.idantecedente_enfermedad=antecedente_enfermedad.idantecedente_enfermedad  ";
                                            $sql_e.=" AND antecedente_perinatal.idtipo_antecedente_enfermedad='1' AND antecedente_perinatal.idhistoria_perinatal='$idhistoria_perinatal'  ";
                                            $result_e = mysqli_query($link,$sql_e);
                                            if ($row_e = mysqli_fetch_array($result_e)){
                                            mysqli_field_seek($result_e,0);
                                            while ($field_e = mysqli_fetch_field($result_e)){
                                            } do {
                                            ?>
                                                SI <input type="radio" name="valor_antecedente_personal[<?php echo $numero_e;?>]" value="NO" <?php if ($row_e[2] =='NO') { echo 'checked'; } ?> disabled> - 
                                                NO <input type="radio" name="valor_antecedente_personal[<?php echo $numero_e;?>]" value="SI" <?php if ($row_e[2] =='SI') { echo 'checked'; } ?> disabled> -> <?php echo $row_e[1];?> 
                                                <?php  
                                                if ($numero_e == '7') { echo '</br></br>'; } else { echo '</br>'; }
                                                ?>
                                                   
                                            <?php
                                            $numero_e=$numero_e+1;
                                            }
                                            while ($row_e = mysqli_fetch_array($result_e));
                                            } else {
                                            }
                                            ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">                               
                                    <div class="col-sm-12">
                                        <h6 class="text-warning">ANTECEDENTES OBSTÉTRICOS</h6>
                                    </div>
                                </div>
                                <hr>
                                <?php
                                    $sql_hp =" SELECT idantecedente_obstetrico, gestaciones, partos, abortos, cesareas, nacidos_vivos, viven, nacidos_muertos, muertos_a_semana,  ";
                                    $sql_hp.=" muertos_d_semana, vaginales, idultimo_previo, antecedente_gemelos, fecha_fea, embarazo_planeado, idmetodo_anticonceptivo ";
                                    $sql_hp.=" FROM antecedente_obstetrico WHERE idhistoria_perinatal='$idhistoria_perinatal' ";
                                    $result_hp=mysqli_query($link,$sql_hp);
                                    $row_hp=mysqli_fetch_array($result_hp);
                                ?>
                                <div class="form-group row">                               
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">G</br>[Gestaciones]:</h6>
                                        <input type="number" class="form-control"              
                                            name="gestaciones" value="<?php echo $row_hp[1];?>" disabled>                
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">P</br>[Partos]:</h6>
                                        <input type="number" class="form-control" 
                                            name="partos" placeholder="" value="<?php echo $row_hp[2];?>" disabled>                
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">A</br>[Abortos]:</h6>
                                        <input type="number" class="form-control" 
                                            name="abortos" value="<?php echo $row_hp[3];?>" disabled>                
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">C</br>[Cesáreas]:</h6>
                                        <input type="number" class="form-control" 
                                            name="cesareas" placeholder="" value="<?php echo $row_hp[4];?>" disabled>                
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row"> 
                                    <div class="col-sm-3"> 
                                    <h6 class="text-warning"></br>NACIDOS VIVOS:</h6>
                                        <input type="number" class="form-control" 
                                            name="nacidos_vivos" placeholder="" value="<?php echo $row_hp[5];?>" disabled>                
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-warning"></br>VIVEN:</h6>
                                        <input type="number" class="form-control" 
                                            name="viven" placeholder="" value="<?php echo $row_hp[6];?>" disabled>                
                                    </div>
                                    <div class="col-sm-2"> 
                                    <h6 class="text-warning">NACIDOS MUERTOS:</h6>
                                        <input type="number" class="form-control" 
                                            name="nacidos muertos" placeholder="" value="<?php echo $row_hp[7];?>" disabled>                
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-warning">MUERTOS</br>(1 SEM):</h6>
                                        <input type="number" class="form-control" 
                                            name="muertos_a_semana" placeholder="" value="<?php echo $row_hp[8];?>" disabled>                
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-warning">DESPUÉS</br>(1 SEM):</h6>
                                        <input type="number" class="form-control" 
                                            name="muertos_d_semana" placeholder="" value="<?php echo $row_hp[9];?>" disabled>                
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">                               
                                    <div class="col-sm-3"></br>
                                    <h6 class="text-warning">VAGINALES:</h6>
                                        <input type="number" class="form-control"              
                                            name="vaginales" value="<?php echo $row_hp[10];?>" disabled>                
                                    </div>
                                    <div class="col-sm-3"></br>
                                    <h6 class="text-warning">ÚLTIMO PREVIO:</h6>
                                        <select name="idultimo_previo"  id="idultimo_previo" class="form-control" disabled >
                                            <option selected>Seleccione</option>
                                            <?php
                                            $sqlv = " SELECT idultimo_previo, ultimo_previo FROM ultimo_previo ";
                                            $resultv = mysqli_query($link,$sqlv);
                                            if ($rowv = mysqli_fetch_array($resultv)){
                                            mysqli_field_seek($resultv,0);
                                            while ($fieldv = mysqli_fetch_field($resultv)){
                                            } do {
                                            ?>
                                            <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_hp[11]) echo "selected";?> ><?php echo $rowv[1];?></option>
                                            <?php
                                            } while ($rowv = mysqli_fetch_array($resultv));
                                            } else {
                                            }
                                            ?>
                                        </select>
                                    </div> 
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">ANTECEDENTE DE GEMELOS:</h6>
                                        SI <input type="radio" name="antecedente_gemelos" value="SI" <?php if ($row_hp[12] =='SI') { echo 'checked'; } else { } ?> disabled>
                                        NO <input type="radio" name="antecedente_gemelos" value="NO" <?php if ($row_hp[12] =='NO') { echo 'checked'; } else { } ?> disabled>
              
                                    </div>               
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">FIN DE EMBARAZO ANTERIOR:</h6>
                                        <input type="date" class="form-control"  name="fecha_fea" value="<?php echo $row_hp[13];?>" disabled>               
                                    </div> 
                                </div>
                                <hr>
                                <div class="form-group row">                               
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">EMBARAZO PLANEADO:</h6>  
                                        SI <input type="radio" name="embarazo_planeado" value="SI" <?php if ($row_hp[14] =='SI') { echo 'checked'; }  ?> disabled>
                                        NO <input type="radio" name="embarazo_planeado" value="NO" <?php if ($row_hp[14] =='NO') { echo 'checked'; }  ?> disabled>
                                    </div> 
                                    <div class="col-sm-3">
                                        <h6 class="text-warning">FRACASO MÉTODO ANTICONCEPTIVO:</h6>
                                        <select name="idmetodo_anticonceptivo"  id="idmetodo_anticonceptivo" class="form-control" disabled >
                                            <option selected>Seleccione</option>
                                            <?php
                                            $sqlv = " SELECT idmetodo_anticonceptivo, metodo_anticonceptivo FROM metodo_anticonceptivo ";
                                            $resultv = mysqli_query($link,$sqlv);
                                            if ($rowv = mysqli_fetch_array($resultv)){
                                            mysqli_field_seek($resultv,0);
                                            while ($fieldv = mysqli_fetch_field($resultv)){
                                            } do {
                                            ?>
                                            <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_hp[15]) echo "selected";?> ><?php echo $rowv[1];?></option>
                                            <?php
                                            } while ($rowv = mysqli_fetch_array($resultv));
                                            } else {
                                            }
                                            ?>
                                        </select>
                                    </div> 
                                </div>
                                        
                            </div>
                        </div>

                    <?php
                        $sql_ge =" SELECT idgestacion, peso_anterior, talla, idesno, fecha_fum, fecha_pp, eg_fum, eco_veinte, fuma_activo, fuma_pasivo, drogas, alcohol, violencia, ";
                        $sql_ge.=" idantirubeola, antitetanica, dosis_antitetanica, ex_odontologico, ex_mamas FROM gestacion WHERE idhistoria_perinatal='$idhistoria_perinatal' ";
                        $result_ge=mysqli_query($link,$sql_ge);
                        $row_ge=mysqli_fetch_array($result_ge);
                    ?>
                    
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-warning">2.- GESTACIÓN ACTUAL</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row"> 
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">PESO ANTERIOR </br>[kg]:</h6>
                                        <input type="text" class="form-control" placeholder="En Kilogramos"             
                                            name="peso_anterior" value="<?php echo $row_ge[1];?>" disabled>                
                                    </div> 
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">TALLA </br>[Centímetros]:</h6>
                                        <input type="text" class="form-control" placeholder="En Centimetros"
                                            name="talla" value="<?php echo $row_ge[2];?>" disabled>                
                                    </div>                             

                                    <div class="col-sm-3"></br>
                                        <h6 class="text-warning">E - S - N - O:</h6>
                                        <select name="idesno"  id="idesno" class="form-control" disabled >
                                            <option selected>Seleccione</option>
                                            <?php
                                            $sqlv = " SELECT idesno, esno FROM esno ";
                                            $resultv = mysqli_query($link,$sqlv);
                                            if ($rowv = mysqli_fetch_array($resultv)){
                                            mysqli_field_seek($resultv,0);
                                            while ($fieldv = mysqli_fetch_field($resultv)){
                                            } do {
                                            ?>
                                            <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_ge[3]) echo "selected";?> ><?php echo $rowv[1];?></option>
                                            <?php
                                            } while ($rowv = mysqli_fetch_array($resultv));
                                            } else {
                                            }
                                            ?>
                                        </select>
              
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-warning"></br>F.U.M.:</h6>
                                        <input type="date" class="form-control" 
                                            name="fecha_fum" value="<?php echo $row_ge[4];?>" disabled>                
                                    </div>
                                </div>
<hr>
                                 <div class="form-group row"> 
                                    <div class="col-sm-3">
                                        <h6 class="text-warning">EG CONFIABLE POR :</h6>
                                    </div>     
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">FUM:</h6>
                                        SI <input type="radio" name="eg_fum" value="SI" <?php if ($row_ge[6] =='SI') { echo 'checked'; } ?> disabled>
                                        NO <input type="radio" name="eg_fum" value="NO" <?php if ($row_ge[6] =='NO') { echo 'checked'; } ?> disabled>
                                    </div> 
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">ECO < 20s:</h6>                                        
                                        SI <input type="radio" name="eco_veinte" value="SI" <?php if ($row_ge[7] =='SI') { echo 'checked'; } ?> disabled>
                                        NO <input type="radio" name="eco_veinte" value="NO" <?php if ($row_ge[7] =='NO') { echo 'checked'; } ?> disabled>
                                    </div> 
                                    <div class="col-sm-3">
                                    </div> 
                                </div>
                                <hr>
                                 <div class="form-group row"> 
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">F.P.P.</br></h6>
                                        <input type="date" class="form-control"              
                                            name="fecha_pp" value="<?php echo $row_ge[5];?>" disabled>                
                                    </div> 
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">FUMA ACTIVO:</h6>      
                                        SI <input type="radio" name="fuma_activo" value="SI" <?php if ($row_ge[8] =='SI') { echo 'checked'; } ?> disabled>
                                        NO <input type="radio" name="fuma_activo" value="NO" <?php if ($row_ge[8] =='NO') { echo 'checked'; } ?> disabled>         
                                    </div>                             
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">FUMA PASIVO:</h6>
                                        SI <input type="radio" name="fuma_pasivo" value="SI" <?php if ($row_ge[9] =='SI') { echo 'checked'; } ?> disabled>
                                        NO <input type="radio" name="fuma_pasivo" value="NO" <?php if ($row_ge[9] =='NO') { echo 'checked'; } ?> disabled>             
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">DROGAS:</h6>
                                        SI <input type="radio" name="drogas" value="SI" <?php if ($row_ge[10] =='SI') { echo 'checked'; } ?> disabled>
                                        NO <input type="radio" name="drogas" value="NO" <?php if ($row_ge[10] =='NO') { echo 'checked'; } ?> disabled>             
                                    </div>
                                </div>
<hr>
                                <div class="form-group row"> 
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">ALCOHOL:</h6>  
                                        SI <input type="radio" name="alcohol" value="SI" <?php if ($row_ge[11] =='SI') { echo 'checked'; } ?> disabled>
                                        NO <input type="radio" name="alcohol" value="NO" <?php if ($row_ge[11] =='NO') { echo 'checked'; } ?> disabled>              
                                    </div> 
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">VIOLENCIA:</h6>   
                                        SI <input type="radio" name="violencia" value="SI" <?php if ($row_ge[12] =='SI') { echo 'checked'; } ?> disabled>
                                        NO <input type="radio" name="violencia" value="NO" <?php if ($row_ge[12] =='NO') { echo 'checked'; } ?> disabled>             
                                    </div>                             
                                    <div class="col-sm-3">
                                        <h6 class="text-warning">ANTIRUBEOLA:</h6>
                                        <select name="idantirubeola"  id="idantirubeola" class="form-control" disabled >
                                            <option selected>Seleccione</option>
                                            <?php
                                            $sqlv = " SELECT idantirubeola, antirubeola FROM antirubeola ";
                                            $resultv = mysqli_query($link,$sqlv);
                                            if ($rowv = mysqli_fetch_array($resultv)){
                                            mysqli_field_seek($resultv,0);
                                            while ($fieldv = mysqli_fetch_field($resultv)){
                                            } do {
                                            ?>
                                            <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_ge[13]) echo "selected";?> ><?php echo $rowv[1];?></option>
                                            <?php
                                            } while ($rowv = mysqli_fetch_array($resultv));
                                            } else {
                                            }
                                            ?>
                                        </select>
              
                                    </div>
                                    <div class="col-sm-3">             
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row"> 
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">ANTITETÁNICA:</br>(vigente)</h6> 
                                        SI <input type="radio" name="antitetanica" value="SI" <?php if ($row_ge[14] =='SI') { echo 'checked'; } ?> disabled>
                                        NO <input type="radio" name="antitetanica" value="NO" <?php if ($row_ge[14] =='NO') { echo 'checked'; } ?> disabled>           
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">DÓSIS:</br>(mes de gestación)</h6>
                                        1ra <input type="radio" name="dosis_antitetanica" value="1ra" <?php if ($row_ge[15] =='1ra') { echo 'checked'; } ?> disabled>
                                        2da <input type="radio" name="dosis_antitetanica" value="2da" <?php if ($row_ge[15] =='2da') { echo 'checked'; } ?> disabled>                
                                    </div>                            
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">EX. NORMAL:</br>(ODONT.)</h6>
                                        SI <input type="radio" name="ex_odontologico" value="SI" <?php if ($row_ge[16] =='SI') { echo 'checked'; } ?> disabled>
                                        NO <input type="radio" name="ex_odontologico" value="NO" <?php if ($row_ge[16] =='NO') { echo 'checked'; } ?> disabled> 
              
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">EX. NORMAL:</br>(MAMAS)</h6> 
                                        SI <input type="radio" name="ex_mamas" value="SI" <?php if ($row_ge[17] =='SI') { echo 'checked'; } ?> disabled>
                                        NO <input type="radio" name="ex_mamas" value="NO" <?php if ($row_ge[17] =='NO') { echo 'checked'; } ?> disabled> 
                                    </div>
                                </div>
                                <hr>
                        <!--        <div class="form-group row"> 
                                    <div class="col-sm-4">
                                    </div>
                                    <div class="col-sm-8">
                                        <button type="submit" class="btn btn-warning" >
                                        REGISTRAR HISTORIA CLINICA PERINATAL
                                        </button>  </form>
                                    </div>
                                </div>  --->

                                <hr>
                            </div>                                    
                        </div>


            </div>
                <!-- /.container-fluid -->
        </div>
            <!-- End of Main Content -->
    </div>
        <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>


</body>
</html>