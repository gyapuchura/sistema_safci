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
        
$sql_ub =" SELECT iddepartamento, idred_salud, idmunicipio FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud_ss' ";
$result_ub=mysqli_query($link,$sql_ub);
$row_ub=mysqli_fetch_array($result_ub);

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
                        <h4 class="m-0 font-weight-bold text-warning">NUEVA HISTORIA CLÍNICA PERINATAL</h4>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-warning">IDENTIFICACIÓN DE LA INTEGRANTE DE LA FAMILIA</h6>
                            </div>
                            <div class="card-body">

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
                                    <h6 class="text-warning">ESTADO CIVIL:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row4[1];?>" 
                                        name="" disabled>
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-warning">NIVEL DE INSTRUCCIÓN:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row4[2];?>"
                                        name="" disabled>                
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-warning">PROFESIÓN:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row4[3];?>"             
                                        name="" disabled >                
                                    </div>

                                </div>
                                <div class="form-group row"> 
                                    <div class="col-sm-4">
                                    <h6 class="text-warning">OCUPACIÓN:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row4[4];?>" 
                                        name="" disabled>                
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-warning">CONTRIBUYE AL SUSTENTO FAMILIAR:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row4[5];?>" 
                                        name="" disabled>                
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-warning">HISTORIA CLÍNICA:</h6>
                                        <a class="btn btn-warning btn-icon-split" href="imprime_historia_clinica.php?idcarpeta_familiar=<?php echo $idcarpeta_familiar_ss;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1000,height=1000,top=50, left=400, scrollbars=YES'); return false;">                        
                                        <span class="icon text-white-50">
                                            <i class="fas fa-book"></i>
                                        </span>
                                        <span class="text">HISTORIA CLÍNICA DIGITAL</span>
                                            </a>                                      
                                    </div>
                                </div> 
                                <?php
                                }
                                while ($row4 = mysqli_fetch_array($result4));
                                } else {
                                }
                                ?>

                                <div class="form-group row">                               
                                    <div class="col-sm-6">
                                    <h6 class="text-warning">AÑOS EN EL MAYOR NIVEL ACADÉMICO:</h6>
                                        <input type="number" class="form-control" value="" name="anos_mayor_nivel" required autofocus>                                      
                                    </div>
                                    <div class="col-sm-6">
                                    <h6 class="text-warning">¿VIVE SOLA?:</h6>
                                        SI <input type="radio" name="vive_sola" value="SI" > </br>
                                        NO <input type="radio" name="vive_sola" value="NO" checked >                
                                    </div>             
                                </div>                                
                            </div>                                
                        </div>

                <form name="PERINATAL" action="guarda_historia_perinatal.php" method="post"> 

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-warning">1.- ANTECEDENTES</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-6">
                                         <h6 class="text-warning">FAMILIARES:</h6>
                                            <?php
                                            $numero_e=0;
                                            $sql_e =" SELECT idantecedente_enfermedad, antecedente_enfermedad FROM antecedente_enfermedad WHERE ambos='SI' ORDER BY idantecedente_enfermedad ";
                                            $result_e = mysqli_query($link,$sql_e);
                                            if ($row_e = mysqli_fetch_array($result_e)){
                                            mysqli_field_seek($result_e,0);
                                            while ($field_e = mysqli_fetch_field($result_e)){
                                            } do {
                                            ?>
                                                 SI <input type="radio" name="idantecedente_familiar[<?php echo $numero_e;?>]" value="SI">  NO <input type="radio" name="idantecedente_familiar[<?php echo $numero_e;?>]" value="NO" checked > -> <?php echo $row_e[1];?> </br>   
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
                                            $sql_e =" SELECT idantecedente_enfermedad, antecedente_enfermedad FROM antecedente_enfermedad ORDER BY idantecedente_enfermedad ";
                                            $result_e = mysqli_query($link,$sql_e);
                                            if ($row_e = mysqli_fetch_array($result_e)){
                                            mysqli_field_seek($result_e,0);
                                            while ($field_e = mysqli_fetch_field($result_e)){
                                            } do {
                                            ?>
                                                 SI <input type="radio" name="idantecedente_personal[<?php echo $numero_e;?>]" value="SI">  NO <input type="radio" name="idantecedente_personal[<?php echo $numero_e;?>]" value="NO" checked > -> <?php echo $row_e[1];?>
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
                                <div class="form-group row">                               
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">G</br>[Gestaciones]:</h6>
                                        <input type="number" class="form-control"              
                                            name="gestaciones" value="1" required>                
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">P</br>[Partos]:</h6>
                                        <input type="number" class="form-control" 
                                            name="partos" placeholder="" value="0" required>                
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">A</br>[Abortos]:</h6>
                                        <input type="number" class="form-control" 
                                            name="abortos" value="0" required>                
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">C</br>[Cesáreas]:</h6>
                                        <input type="number" class="form-control" 
                                            name="cesareas" placeholder="" value="0" required>                
                                    </div>
                                </div>
                                <div class="form-group row"> 
                                    <div class="col-sm-3"> 
                                    <h6 class="text-warning"></br>NACIDOS VIVOS:</h6>
                                        <input type="number" class="form-control" 
                                            name="nacidos_vivos" placeholder="" value="0" required>                
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-warning"></br>VIVEN:</h6>
                                        <input type="number" class="form-control" 
                                            name="viven" placeholder="" value="0" required>                
                                    </div>
                                    <div class="col-sm-2"> 
                                    <h6 class="text-warning">NACIDOS MUERTOS:</h6>
                                        <input type="number" class="form-control" 
                                            name="nacidos muertos" placeholder="" value="0" required>                
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-warning">MUERTOS</br>(1 SEM):</h6>
                                        <input type="number" class="form-control" 
                                            name="muertos_a_semana" placeholder="" value="0" required>                
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-warning">DESPUÉS</br>(1 SEM):</h6>
                                        <input type="number" class="form-control" 
                                            name="muertos_d_semana" placeholder="" value="0" required>                
                                    </div>
                                </div>
                                <div class="form-group row">                               
                                    <div class="col-sm-3"></br>
                                    <h6 class="text-warning">VAGINALES:</h6>
                                        <input type="number" class="form-control"              
                                            name="vaginales" value="1" required>                
                                    </div>
                                    <div class="col-sm-3"></br>
                                    <h6 class="text-warning">ÚLTIMO PREVIO:</h6>
                                        <select name="idultimo_previo"  id="idultimo_previo" class="form-control" required>
                                            <option value="">ELEGIR</option>
                                            <?php
                                            $sql1 = "SELECT idultimo_previo, ultimo_previo FROM ultimo_previo ";
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
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">ANTECEDENTE DE GEMELOS:</h6>
                                        SI <input type="radio" name="antecedente_gemelos" value="SI" >
                                        NO <input type="radio" name="antecedente_gemelos" value="NO" checked >               
                                    </div>               
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">FIN DE EMBARAZO ANTERIOR:</h6>
                                        <input type="date" class="form-control" 
                                            name="fecha_fea" placeholder=""  required>               
                                    </div> 
                                </div>
                                <div class="form-group row">                               
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">EMBARAZO PLANEADO:</h6>
                                        SI <input type="radio" name="embarazo_planeado" value="SI" >
                                        NO <input type="radio" name="embarazo_planeado" value="NO" checked >  
                                    </div> 
                                    <div class="col-sm-3">
                                        <h6 class="text-warning">FRACASO MÉTODO ANTICONCEPTIVO:</h6>
                                        <select name="idmetodo_anticonceptivo"  id="idmetodo_anticonceptivo" class="form-control" required>
                                            <option value="">ELEGIR</option>
                                            <?php
                                            $sql1 = "SELECT idmetodo_anticonceptivo, metodo_anticonceptivo FROM metodo_anticonceptivo ";
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
                                        
                            </div>
                        </div>
                    
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-warning">2.- GESTACIÓN ACTUAL</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row"> 
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">PESO ANTERIOR </br>[kg]:</h6>
                                        <input type="number" class="form-control"              
                                            name="peso_anterior" value="0" required>                
                                    </div> 
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">TALLA </br>[Centímetros]:</h6>
                                        <input type="text" class="form-control" placeholder="En Centrimetros"
                                            name="talla" value="0" required>                
                                    </div>                             

                                    <div class="col-sm-3"></br>
                                        <h6 class="text-warning">E - S - N - O:</h6>
                                        <select name="idesno"  id="idesno" class="form-control" required>
                                            <option value="">ELEGIR</option>
                                            <?php
                                            $sql1 = "SELECT idesno, esno, inicial FROM esno ";
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
                                    <div class="col-sm-3">
                                    <h6 class="text-warning"></br>F.U.M.:</h6>
                                        <input type="date" class="form-control" 
                                            name="fecha_fum" value="" required>                
                                    </div>
                                </div>

                                 <div class="form-group row"> 
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">F.P.P.</br></h6>
                                        <input type="date" class="form-control"              
                                            name="fecha_pp" value="" required>                
                                    </div> 
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">FUMA ACTIVO:</h6>
                                        SI <input type="radio" name="fuma_activo" value="SI" >
                                        NO <input type="radio" name="fuma_activo" value="NO" checked >                 
                                    </div>                             
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">FUMA PASIVO:</h6>
                                        SI <input type="radio" name="fuma_pasivo" value="SI" >
                                        NO <input type="radio" name="fuma_pasivo" value="NO" checked >  
              
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">DROGAS:</h6>
                                        SI <input type="radio" name="drogas" value="SI" >
                                        NO <input type="radio" name="drogas" value="NO" checked >              
                                    </div>
                                </div>

                                <div class="form-group row"> 
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">ALCOHOL:</h6>
                                        SI <input type="radio" name="alcohol" value="SI" >
                                        NO <input type="radio" name="alcohol" value="NO" checked >                
                                    </div> 
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">VIOLENCIA:</h6>
                                        SI <input type="radio" name="violencia" value="SI" >
                                        NO <input type="radio" name="violencia" value="NO" checked >                 
                                    </div>                             
                                    <div class="col-sm-3">
                                        <h6 class="text-warning">ANTIRUBEOLA:</h6>
                                        <select name="idantirubeola"  id="idantirubeola" class="form-control" required>
                                            <option value="">ELEGIR</option>
                                            <?php
                                            $sql1 = "SELECT idantirubeola, antirubeola FROM antirubeola ";
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
                                    <div class="col-sm-3">             
                                    </div>
                                </div>
                                <div class="form-group row"> 
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">ANTITETÁNICA:</br>(vigente)</h6>
                                        SI <input type="radio" name="antitetanica" value="SI" >
                                        NO <input type="radio" name="antitetanica" value="NO" checked >              
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">DÓSIS:</br>(mes de gestación)</h6>
                                        1ra <input type="radio" name="dosis_antitetanica" value="1ra" ></br>
                                        2da <input type="radio" name="dosis_antitetanica" value="2da" >                
                                    </div>                            
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">EX. NORMAL:</br>(ODONT.)</h6>
                                        SI <input type="radio" name="ex_odontologico" value="SI" >
                                        NO <input type="radio" name="ex_odontologico" value="NO" checked >  
              
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-warning">EX. NORMAL:</br>(MAMAS)</h6>
                                        SI <input type="radio" name="ex_mamas" value="SI" >
                                        NO <input type="radio" name="ex_mamas" value="NO" checked > 
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row"> 
                                    <div class="col-sm-4">
                                    </div>
                                    <div class="col-sm-8">
                                        <button type="submit" class="btn btn-warning" >
                                        REGISTRAR HISTORIA CLINICA PERINATAL
                                        </button>  
                                    </div>
                                </div>

                                <hr>
                            <!-- modal de confirmacion de envio de datos-->
                            <div class="modal fade" id="examplemodal" tabindex="-1" role="dialog" aria-labelledby="examplemodalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="examplemodalLabel">REGISTRAR HISTORIA CLINICA PERINATAL</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                                
                                                ¿Esta seguro de Registrar la NUEVA HISTORIA CLINICA PERINATAL?
                                                posteriormenete no se podran realizar cambios.

                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                            <button type="submit" class="btn btn-warning pull-center">CONFIRMAR REGISTRO</button>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                <!-- Modal -->

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


<script language="javascript"> 
    $(document).ready(function(){
    $("#idmotivo_referencia").change(function () {
                $("#idmotivo_referencia option:selected").each(function () {
                    motivo_referencia=$(this).val();
                $.post("motivo_referencia.php", {motivo_referencia:motivo_referencia}, function(data){
                $("#motivo_referencia").html(data);
                });
            });
    })
    });
</script> 

</body>
</html>