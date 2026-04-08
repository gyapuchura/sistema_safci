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

$idatencion_psafci_ss      = $_SESSION['idatencion_psafci_ss'];

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
                    
                    <div class="col-sm-2">
                    <h6 class="text-info">EDAD:</h6>
                        <input type="number" class="form-control" value="<?php echo $edad_ss;?>" 
                         name="edad_actual" disabled>
                    </div>
                    <div class="col-sm-4">
                    <h6 class="text-warning">VER CARPETA FAMILIAR:</h6>
                    <a class="btn btn-warning btn-icon-split" href="../carpetas_familiares/imprime_carpeta_familiar.php?idcarpeta_familiar=<?php echo $idcarpeta_familiar_ss;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1300,height=1000,top=50, left=400, scrollbars=YES'); return false;">
                    <span class="icon text-white-50">
                        <i class="fas fa-book"></i>
                    </span>
                    <span class="text"> <?php echo $row_cf[1];?> </span></a>  
                    </div>
                </div>  

    <!-------- DATOS PERSONALES DEL INTEGRANTE FAMILIAR (End) --------->  

                <?php
                $sql4 =" SELECT integrante_datos_cf.idintegrante_datos_cf, estado_civil.estado_civil, nivel_instruccion.nivel_instruccion, profesion.profesion, integrante_datos_cf.ocupacion, contribuye_cf.contribuye_cf ";
                $sql4.=" FROM integrante_datos_cf, estado_civil, nivel_instruccion, profesion, contribuye_cf WHERE integrante_datos_cf.idestado_civil=estado_civil.idestado_civil ";
                $sql4.=" AND integrante_datos_cf.idnivel_instruccion=nivel_instruccion.idnivel_instruccion AND integrante_datos_cf.idprofesion=profesion.idprofesion ";
                $sql4.=" AND integrante_datos_cf.idcontribuye_cf=contribuye_cf.idcontribuye_cf AND integrante_datos_cf.idintegrante_cf='$idintegrante_cf_ss' ORDER BY integrante_datos_cf.idintegrante_datos_cf DESC LIMIT 1 ";
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
                        <div class="col-sm-4">
                        <h6 class="text-info">OCUPACIÓN:</h6>
                            <input type="text" class="form-control" value="<?php echo $row4[4];?>" 
                            name="" disabled>                
                        </div>
                        <div class="col-sm-4">
                        <h6 class="text-info">CONTRIBUYE AL SUSTENTO FAMILIAR:</h6>
                            <input type="text" class="form-control" value="<?php echo $row4[5];?>" 
                            name="" disabled>                
                        </div>
                        <div class="col-sm-4">
                        <h6 class="text-info">HISTORIA CLÍNICA:</h6>
                            <a class="btn btn-info btn-icon-split" href="imprime_historia_clinica.php" target="_blank" onClick="window.open(this.href, this.target, 'width=1000,height=1000,top=50, left=400, scrollbars=YES'); return false;">
                            <span class="icon text-white-50">
                                <i class="fas fa-book"></i>
                            </span>
                            <span class="text">HISTORIA CLÍNICA</span></a>                                        
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


<?php 
switch ($row_ps[3]) {
    case 1: ?>

<!---------------------------------------------------------------->
<!------------- ATENCION POR MORBILIDAD - BEGIN -------------------->
<!---------------------------------------------------------------->
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
    $sql_sg =" SELECT idsigno_vital_psafci, frec_cardiaca, peso, talla, imc, frec_respiratoria, presion_arterial, presion_arterial_d, temperatura, saturacion, alergia,  ";
    $sql_sg.="  descripcion_alergia FROM signo_vital_psafci WHERE idnombre ='$idnombre_integrante_ss' AND idatencion_psafci='$idatencion_psafci_ss' ORDER BY idsigno_vital_psafci DESC LIMIT 1 ";
    $result_sg = mysqli_query($link,$sql_sg);
    if ($row_sg = mysqli_fetch_array($result_sg)){
    mysqli_field_seek($result_sg,0);           
    while ($field_sg = mysqli_fetch_field($result_sg)){
    } do {
?>
                <hr>
                <div class="text-center">                                     
                    <h6 class="text-info">SIGNOS VITALES:</h6>                    
                </div>
                <hr> 
                <div class="form-group row">                               
                    <div class="col-sm-3">
                    <h6 class="text-info">FRECUENCIA CARDIACA</br>[lpm]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[1];?>" 
                         name="frec_cardiaca" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">PESO</br>[kg]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[2];?>"            
                         name="peso" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">TALLA</br>[mtrs.]:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_sg[3];?>"  
                         name="talla" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info"></br>I.M.C.:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_sg[4];?>"  
                         name="imc" disabled>                
                    </div>
                </div>

                <div class="form-group row">                               
                    <div class="col-sm-3">
                    <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[5];?>" 
                         name="frec_respiratoria" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">PRESIÓN ARTERIAL </br>[mmHg]:</h6>

                     <?php  if ($edad_ss > '5') {  //******* PARA MAYOR DE 5 ANOS */ ?>
                        <input type="text" class="form-control" value="<?php echo $row_sg[6]."/".$row_sg[7];?>"             
                         name="presion_arterial" disabled>   
                    <?php } else { echo 'MENOR DE 5 AÑOS';}?>    

                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">TEMPERATURA</br>[°C]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[8];?>" 
                         name="temperatura" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">SATURACIÓN </br>[% O2]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[9];?>" 
                         name="saturacion" disabled>                
                    </div>
                </div>

                <div class="form-group row">  
                    <div class="col-sm-3">
                    <h6 class="text-info">ES ALERGICO? :</h6>
                    <input type="text" class="form-control" value="<?php echo $row_sg[10];?>" disabled
                         name="combe">                  
                    </div>
                    <div class="col-sm-6">
                    <h6 class="text-info">DESCRIPCIÓN DE LA ALÉRGIA</h6>
                    <textarea class="form-control" rows="2" name="descripcion_alergia" disabled><?php echo $row_sg[11];?></textarea> 
                    </div>
                    <div class="col-sm-3">
                    <!-- <h6 class="text-info">COMBE:</h6>  --->
                    
                    </div>
                </div> 
        <?php
        }
        while ($row_sg = mysqli_fetch_array($result_sg));
        } else {
        }
        ?>

<hr>

    <?php
    $numerod=1;
    $sql_dg =" SELECT iddiagnostico_psafci, idatencion_psafci, motivo_consulta, subjetivo, objetivo, analisis, plan, idpatologia FROM diagnostico_psafci WHERE idatencion_psafci='$idatencion_psafci_ss' ";
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
    <div class="col-sm-12">
    <h6 class="text-info">MOTIVO DE LA CONSULTA <?php echo $numerod;?>:</h6>
    <textarea class="form-control" rows="3" name="motivo_consulta1" disabled ><?php echo $row_dg[2]?></textarea>
    </div> 
    </div>
    <div class="form-group row"> 
    <div class="col-sm-6">
    <h6 class="text-info">SUBJETIVO <?php echo $numerod;?>:</h6>
    <textarea class="form-control" rows="3" name="subjetivo" disabled ><?php echo $row_dg[3]?></textarea>
    </div>
    <div class="col-sm-6">
    <h6 class="text-info">OBJETIVO <?php echo $numerod;?>:</h6>
    <textarea class="form-control" rows="3" name="objetivo" disabled ><?php echo $row_dg[4]?></textarea>
    </div> 
    </div>
    <div class="form-group row"> 
    <div class="col-sm-6">
    <h6 class="text-info">ANÁLISIS <?php echo $numerod;?>:</h6>
    <textarea class="form-control" rows="3" name="analisis" disabled ><?php echo $row_dg[5]?></textarea>
    </div>
    <div class="col-sm-6">
    <h6 class="text-info">PLAN <?php echo $numerod;?>:</h6>
    <textarea class="form-control" rows="3" name="plan" disabled ><?php echo $row_dg[6]?></textarea>
    </div> 
    </div>
    <div class="form-group row"> 
    <div class="col-sm-12">
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
                <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_dg[7]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
    $sql_tra =" SELECT idtratamiento_psafci, idatencion_psafci, iddiagnostico_psafci, idtipo_medicamento, idmedicamento FROM tratamiento_psafci WHERE iddiagnostico_psafci ='$row_dg[0]' AND idatencion_psafci='$idatencion_psafci_ss' ";
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
<!---------------------------------------------------------------->
<!------------- ATENCION POR MORBILIDAD - END -------------------->
<!---------------------------------------------------------------->

<?php   break;
        case 2: ?>

<!---------------------------------------------------------------->
<!------------- ATENCION PREVENTIVA - BEGIN ---------------------->
<!---------------------------------------------------------------->

  <?php
    $sql_dgs =" SELECT iddiagnostico_psafci, idatencion_psafci, motivo_consulta, idpatologia FROM diagnostico_psafci WHERE idatencion_psafci='$idatencion_psafci_ss' ";
    $result_dgs = mysqli_query($link,$sql_dgs);
    $row_dgs = mysqli_fetch_array($result_dgs);
    ?>
    
    <div class="form-group row"> 
    <div class="col-sm-3"> 
    </div> 
    <div class="col-sm-6">
    <h4 class="text-info">ATENCIÓN PREVENTIVA:</h4>
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
<?php
    $sql_sg =" SELECT idsigno_vital_psafci, frec_cardiaca, peso, talla, imc, frec_respiratoria, presion_arterial, presion_arterial_d, temperatura, saturacion, alergia,  ";
    $sql_sg.="  descripcion_alergia FROM signo_vital_psafci WHERE idnombre ='$idnombre_integrante_ss' AND idatencion_psafci='$idatencion_psafci_ss' ORDER BY idsigno_vital_psafci DESC LIMIT 1 ";
    $result_sg = mysqli_query($link,$sql_sg);
    if ($row_sg = mysqli_fetch_array($result_sg)){
    mysqli_field_seek($result_sg,0);           
    while ($field_sg = mysqli_fetch_field($result_sg)){
    } do {
?>
                <hr>
                <div class="text-center">                                     
                    <h6 class="text-info">SIGNOS VITALES:</h6>                    
                </div>
                <hr> 
                <div class="form-group row">                               
                    <div class="col-sm-3">
                    <h6 class="text-info">FRECUENCIA CARDIACA</br>[lpm]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[1];?>" 
                         name="frec_cardiaca" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">PESO</br>[kg]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[2];?>"            
                         name="peso" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">TALLA</br>[Centrimetros.]:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_sg[3];?>"  
                         name="talla" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info"></br>I.M.C.:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_sg[4];?>"  
                         name="imc" disabled>                
                    </div>
                </div>

                <div class="form-group row">                               
                    <div class="col-sm-3">
                    <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[5];?>" 
                         name="frec_respiratoria" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">PRESIÓN ARTERIAL </br>[mmHg]:</h6>

                     <?php  if ($edad_ss > '5') {  //******* PARA MAYOR DE 5 ANOS */ ?>
                        <input type="text" class="form-control" value="<?php echo $row_sg[6]."/".$row_sg[7];?>"             
                         name="presion_arterial" disabled>   
                    <?php } else { echo 'MENOR DE 5 AÑOS';}?>    

                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">TEMPERATURA</br>[°C]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[8];?>" 
                         name="temperatura" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">SATURACIÓN </br>[% O2]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[9];?>" 
                         name="saturacion" disabled>                
                    </div>
                </div>

                <div class="form-group row">  
                    <div class="col-sm-3">
                    <h6 class="text-info">ES ALERGICO? :</h6>
                    <input type="text" class="form-control" value="<?php echo $row_sg[10];?>" disabled
                         name="alergia">                  
                    </div>
                    <div class="col-sm-6">
                    <h6 class="text-info">DESCRIPCIÓN DE LA ALÉRGIA</h6>
                    <textarea class="form-control" rows="2" name="descripcion_alergia" disabled><?php echo $row_sg[11];?></textarea> 
                    </div>
                    <div class="col-sm-3">
                    <!-- <h6 class="text-info">COMBE:</h6>  --->
                    
                    </div>
                </div> 
           <?php
        }
        while ($row_sg = mysqli_fetch_array($result_sg));
        } else {
        }
        ?>


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
        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_dgs[3]) echo "selected" ;?> ><?php echo $rowv[1];?></option>
        <?php
        } while ($rowv = mysqli_fetch_array($resultv));
        } else {
        }
        ?>
        </select>

    </div> 
    <div class="col-sm-7"> 
    <h6 class="text-info">S.O.A.P. MÉDICO:</h6>
    <textarea class="form-control" rows="4" name="motivo_consulta" disabled><?php echo $row_dgs[2];?></textarea>
    </div> 
    </div> 

<!---------------------------------------------------------------->
<!------------- ATENCION PREVENTIVA - END  ------------------------>
<!---------------------------------------------------------------->

<?php   break;
        case 3: ?>

<!---------------------------------------------------------------->
<!------------- ATENCION POR TELECONSULTA - BEGIN ------------------->
<!---------------------------------------------------------------->

  <?php
    $sql_tel =" SELECT idatencion_teleconsulta, idatencion_psafci, idcaptacion_ts, idde_ts, iden_ts, idvia_comunicacion, consentimiento_informado, motivo_teleconsulta, historia_enfermedad,  ";
    $sql_tel.=" examen_complementario, tratamiento_teleconsulta, idespecialidad_medica, subespecialidad, idtiempo_ts, idestado_paciente, fecha_seguimiento, telefono_paciente, fecha_registro,  ";
    $sql_tel.=" hora_registro, idusuario FROM atencion_teleconsulta WHERE idatencion_psafci='$idatencion_psafci_ss' ";
    $result_tel = mysqli_query($link,$sql_tel);
    $row_tel = mysqli_fetch_array($result_tel);
    ?>

<hr>
    <div class="form-group row"> 
    <div class="col-sm-6">
    <h6 class="text-info">PACIENTE DE GRUPO VULNERABLE:</h6>
    </div> 
    <div class="col-sm-3"> 
    </div> 
    <div class="col-sm-3"> 
    </div> 
    </div> 
    <div class="form-group row"> 
        <?php  
        $numero1=0;                  
        $sql1 =" SELECT atencion_grupo_vulnerable.idatencion_grupo_vulnerable, grupo_vulnerable.grupo_vulnerable FROM atencion_grupo_vulnerable, grupo_vulnerable ";
        $sql1.=" WHERE atencion_grupo_vulnerable.idgrupo_vulnerable=grupo_vulnerable.idgrupo_vulnerable AND atencion_grupo_vulnerable.idatencion_psafci='$idatencion_psafci_ss' ";
        $result1 = mysqli_query($link,$sql1);
        if ($row1 = mysqli_fetch_array($result1)){
        mysqli_field_seek($result1,0);
        while ($field1 = mysqli_fetch_field($result1)){
        } do { 
        ?>
            <div class="col-sm-3">
            <h6 class="text-secundary"><?php echo $row1[1];?> <input type="checkbox" name="idgrupo_vulnerable" checked disabled></h6>
            
            </div> 
        <?php
        $numero1=$numero1+1;
        }
        while ($row1 = mysqli_fetch_array($result1));
        } else {
        }
        ?>
    </div> 
    <hr>
    <div class="form-group row"> 
    <div class="col-sm-4">
        <h6 class="text-info">CAPTADO POR:</h6>
            <select name="idcaptacion_ts"  id="idcaptacion_ts" class="form-control" disabled >
            <option selected>Seleccione</option>
            <?php
            $sqlv = " SELECT idcaptacion_ts, captacion_ts FROM captacion_ts ";
            $resultv = mysqli_query($link,$sqlv);
            if ($rowv = mysqli_fetch_array($resultv)){
            mysqli_field_seek($resultv,0);
            while ($fieldv = mysqli_fetch_field($resultv)){
            } do {
            ?>
            <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_tel[2]) echo "selected";?> ><?php echo $rowv[1];?></option>
            <?php
            } while ($rowv = mysqli_fetch_array($resultv));
            } else {
            }
            ?>
        </select>
    </div> 
    <div class="col-sm-4">
        <h6 class="text-info">DE:</h6> 
            <select name="idde_ts"  id="idde_ts" class="form-control" disabled >
            <option selected>Seleccione</option>
            <?php
            $sqlv = " SELECT idde_ts, de_ts FROM de_ts ";
            $resultv = mysqli_query($link,$sqlv);
            if ($rowv = mysqli_fetch_array($resultv)){
            mysqli_field_seek($resultv,0);
            while ($fieldv = mysqli_fetch_field($resultv)){
            } do {
            ?>
            <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_tel[3]) echo "selected";?> ><?php echo $rowv[1];?></option>
            <?php
            } while ($rowv = mysqli_fetch_array($resultv));
            } else {
            }
            ?>
        </select>

    </div> 
    <div class="col-sm-4"> 
        <h6 class="text-info">EN:</h6>
            <select name="iden_ts"  id="iden_ts" class="form-control" disabled >
            <option selected>Seleccione</option>
            <?php
            $sqlv = " SELECT iden_ts, en_ts FROM en_ts ";
            $resultv = mysqli_query($link,$sqlv);
            if ($rowv = mysqli_fetch_array($resultv)){
            mysqli_field_seek($resultv,0);
            while ($fieldv = mysqli_fetch_field($resultv)){
            } do {
            ?>
            <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_tel[4]) echo "selected";?> ><?php echo $rowv[1];?></option>
            <?php
            } while ($rowv = mysqli_fetch_array($resultv));
            } else {
            }
            ?>
        </select>
    </div> 

    </div> 
    <div class="form-group row"> 
        <div class="col-sm-4"> 
            <h6 class="text-info">VÍA DE COMUNICACIÓN:</h6>
            <select name="idvia_comunicacion"  id="idvia_comunicacion" class="form-control" disabled >
            <option selected>Seleccione</option>
            <?php
            $sqlv = " SELECT idvia_comunicacion, via_comunicacion FROM via_comunicacion ";
            $resultv = mysqli_query($link,$sqlv);
            if ($rowv = mysqli_fetch_array($resultv)){
            mysqli_field_seek($resultv,0);
            while ($fieldv = mysqli_fetch_field($resultv)){
            } do {
            ?>
            <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_tel[5]) echo "selected";?> ><?php echo $rowv[1];?></option>
            <?php
            } while ($rowv = mysqli_fetch_array($resultv));
            } else {
            }
            ?>
        </select>
        </div>
        <div class="col-sm-4">
            <h6 class="text-info">CONSENTIMIENTO INFORMADO: <input type="radio" name="consentimiento_informado" <?php if ($row_tel[6]=='SI') { echo 'checked'; } else { } ?> disabled></h6>
            
        </div> 
        <div class="col-sm-4">
        </div> 
    </div>
<hr>
    <div class="form-group row"> 
    <div class="col-sm-6">
    <h6 class="text-info">MOTIVO DE LA TELECONSULTA E HISTORIA:</h6>
    </div> 
    <div class="col-sm-6">       
    </div> 
    </div> 
<hr>
    <div class="form-group row"> 
        <div class="col-sm-6">
        <h6 class="text-info">MOTIVO DE LA TELECONSULTA:</h6>
        <textarea class="form-control" rows="2" name="motivo_teleconsulta" id="tm_motivo" disabled><?php echo $row_tel[7];?></textarea>
        </div> 
        <div class="col-sm-6"> 
            
        </div> 
    </div>
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">HISTORIA DE LA ENFERMEDAD ACTUAL:</h6>
        <textarea class="form-control" rows="3" name="historia_enfermedad" id="tm_historia" disabled><?php echo $row_tel[8];?></textarea>
        </div> 
    </div> 
            <hr>
            <div class="text-center">                                     
                <h6 class="text-info">EXAMEN FÍSICO - SIGNOS VITALES:</h6>                    
            </div>
            <hr> 
            <?php
                $sql_sv =" SELECT idsigno_vital_psafci, frec_cardiaca, peso, talla, imc, frec_respiratoria, presion_arterial, presion_arterial_d, temperatura, saturacion, alergia,  ";
                $sql_sv.="  descripcion_alergia FROM signo_vital_psafci WHERE idnombre ='$idnombre_integrante_ss' AND idatencion_psafci='$idatencion_psafci_ss' ORDER BY idsigno_vital_psafci DESC LIMIT 1 ";
                $result_sv = mysqli_query($link,$sql_sv);
                if ($row_sv = mysqli_fetch_array($result_sv)){
                mysqli_field_seek($result_sv,0);           
                while ($field_sv = mysqli_fetch_field($result_sv)){
                } do {
            ?>
                <div class="form-group row">                               
                    <div class="col-sm-3">
                    <h6 class="text-info">FRECUENCIA CARDIACA</br>[lpm]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sv[1];?>" 
                         name="frec_cardiaca" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">PESO</br>[kg]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sv[2];?>"            
                         name="peso" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">TALLA</br>[Centrimetros.]:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_sv[3];?>"  
                         name="talla" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info"></br>I.M.C.:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_sv[4];?>"  
                         name="imc" disabled>                
                    </div>
                </div>

                <div class="form-group row">                               
                    <div class="col-sm-3">
                    <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sv[5];?>" 
                         name="frec_respiratoria" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">PRESIÓN ARTERIAL </br>[mmHg]:</h6>

                     <?php  if ($edad_ss > '5') {  //******* PARA MAYOR DE 5 ANOS */ ?>
                        <input type="text" class="form-control" value="<?php echo $row_sv[6]."/".$row_sv[7];?>"             
                         name="presion_arterial" disabled>   
                    <?php } else { echo 'MENOR DE 5 AÑOS';}?>    

                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">TEMPERATURA</br>[°C]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sv[8];?>" 
                         name="temperatura" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">SATURACIÓN </br>[% O2]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sv[9];?>" 
                         name="saturacion" disabled>                
                    </div>
                </div>

                <div class="form-group row">  
                    <div class="col-sm-3">
                    <h6 class="text-info">ES ALERGICO? :</h6>
                    <input type="text" class="form-control" value="<?php echo $row_sv[10];?>" disabled
                         name="alergia">                  
                    </div>
                    <div class="col-sm-6">
                    <h6 class="text-info">DESCRIPCIÓN DE LA ALÉRGIA</h6>
                    <textarea class="form-control" rows="2" name="descripcion_alergia" disabled><?php echo $row_sv[11];?></textarea> 
                    </div>
                    <div class="col-sm-3">
                    <!-- <h6 class="text-info">COMBE:</h6>  --->
                    
                    </div>
                </div> 
    <?php
    }
    while ($row_sv = mysqli_fetch_array($result_sv));
    } else {
    }
    ?>

   <div class="form-group row"> 
        <div class="col-sm-6">
        <h6 class="text-info">IMPRESIÓN DIAGNÓSTICA:</h6>
        </div> 
        <div class="col-sm-3"> 
        </div> 
        <div class="col-sm-3"> 
        </div> 
    </div> 

     <?php
    $numero_dg =1;
    $sql_dg ="  SELECT iddiagnostico_teleconsulta, idpatologia FROM diagnostico_teleconsulta WHERE idatencion_psafci='$idatencion_psafci_ss' ";
    $result_dg = mysqli_query($link,$sql_dg);
    if ($row_dg = mysqli_fetch_array($result_dg)){
    mysqli_field_seek($result_dg,0);           
    while ($field_dg = mysqli_fetch_field($result_dg)){
    } do {
    ?>
        <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">DIAGNOSTICO <?php echo $numero_dg;?>:</h6>
            <select name="idpatologia"  id="idpatologia" class="form-control" disabled >
                <option selected>Seleccione</option>
                <?php
                $sqlv = " SELECT idpatologia, patologia, cie FROM patologia ";
                $resultv = mysqli_query($link,$sqlv);
                if ($rowv = mysqli_fetch_array($resultv)){
                mysqli_field_seek($resultv,0);
                while ($fieldv = mysqli_fetch_field($resultv)){
                } do {
                ?>
                <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_dg[1]) echo "selected";?> ><?php echo $rowv[1];?> - <?php echo $rowv[2];?></option>
                <?php
                } while ($rowv = mysqli_fetch_array($resultv));
                } else {
                }
                ?>
            </select>
        </div>  
    </div> 

    <?php
    $numero_dg = $numero_dg+1;
    }
    while ($row_dg = mysqli_fetch_array($result_dg));
    } else {
    }
    ?>

        <div class="form-group row"> 
            <div class="col-sm-6">
            <h6 class="text-info">EXÁMENES COMPLEMENTARIOS O DE GABINETE:</h6>
            <textarea class="form-control" rows="3" name="examen_complementario" disabled><?php echo $row_tel[9];?></textarea>
            </div> 
            <div class="col-sm-6">
            <h6 class="text-info">TRATAMIENTO:</h6>
            <textarea class="form-control" rows="3" name="tratamiento_teleconsulta" disabled><?php echo $row_tel[10];?></textarea>
            </div> 
        </div>


           <div class="form-group row"> 
                <div class="col-sm-12">
                <h6 class="text-info">ESPECIALIDAD Y CIERRE DE TELECONSULTA:</h6>
                    <select name="idespecialidad_medica"  id="idespecialidad_medica" class="form-control" disabled >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idespecialidad_medica, especialidad_medica FROM especialidad_medica ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_tel[11]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>
                </div> 
            </div>

            <div class="form-group row"> 
                <div class="col-sm-12">
                <h6 class="text-info">SUBESPECIALIDAD:</h6>
                <input type="text" name="subespecialidad" class="form-control" value="<?php echo $row_tel[12];?>" disabled>
                </div> 
            </div>

            <div class="form-group row"> 
                <div class="col-sm-2">
                <h6 class="text-info">TIEMPO:</h6></br>
                    <select name="idtiempo_ts"  id="idtiempo_ts" class="form-control" disabled >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idtiempo_ts, tiempo_ts FROM tiempo_ts ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_tel[13]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-4">
                <h6 class="text-info">ESTADO DEL PACIENTE:</h6></br>
                <select name="idestado_paciente"  id="idestado_paciente" class="form-control" disabled >
                    <option selected>Seleccione</option>
                    <?php
                    $sqlv = " SELECT idestado_paciente, estado_paciente FROM estado_paciente ";
                    $resultv = mysqli_query($link,$sqlv);
                    if ($rowv = mysqli_fetch_array($resultv)){
                    mysqli_field_seek($resultv,0);
                    while ($fieldv = mysqli_fetch_field($resultv)){
                    } do {
                    ?>
                    <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_tel[14]) echo "selected";?> ><?php echo $rowv[1];?></option>
                    <?php
                    } while ($rowv = mysqli_fetch_array($resultv));
                    } else {
                    }
                    ?>
                </select>
                </div> 
                <div class="col-sm-3">
                    <h6 class="text-info">FECHA CONSULTA DE SEGUIMIENTO:</h6>
                    <input type="date" name="fecha_seguimiento" value="<?php echo $row_tel[15];?>" class="form-control" disabled>
                </div>
                <div class="col-sm-3">
                    <h6 class="text-info">TELEFÓNO CELULAR DEL PACIENTE/FAMILIAR:</h6>
                    <input type="number" name="telefono_paciente" value="<?php echo $row_tel[16];?>" class="form-control" disabled>
                </div>
            </div>
            <hr>

<!---------------------------------------------------------------->
<!------------- ATENCION POR TELECONSULTA - END ------------------>
<!---------------------------------------------------------------->

<?php   break; } ?>
    
    
    

<hr>

    <div class="form-group row"> 
    <div class="col-sm-3"> 
    </div> 
    <div class="col-sm-6">
    <h4 class="text-info">OPCIONES ADICIONALES DE ATENCIÓN</h4>
    </div> 
    <div class="col-sm-3"> 
    </div> 
    </div> 
 <form name="ELIMINA_SESION" action="elimina_atencion_psafci.php" method="post">  
    <div class="form-group row"> 
    <div class="col-sm-4"> 
         <input type="hidden" name="idatencion_psafci" value="<?php echo $idatencion_psafci_ss;?>" >
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModald">
            ELIMINAR ATENCIÓN MÉDICA
        </button> 
                <!--  MODAL DE ELIMINACION DE ATENCION MEDICA BEGIN ---->
            <div class="modal fade" id="exampleModald" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ELIMINAR DE ATENCIÓN MÉDICA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            
                            Esta seguro de ELIMINAR la ATENCIÓN MÉDICA?
                        
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-danger pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form>  
 <!--  MODAL DE ELIMINACION DE ATENCION MEDICA BEGIN ---->
    </div> 
    <div class="col-sm-4"> 
        <a href="atenciones_psafci.php"><h6 class="text-success"><- IR A BANDEJA DE ATENCIONES</h6></a>
    </div> 
    <div class="col-sm-4"> 
        <a class="btn btn-primary btn-icon-split" href="../referencia_safci/formulario_referencia_ps.php" >
        <span class="icon text-white-50">
            <i class="fas fa-hospital"></i>
        </span>
        <span class="text">REFERENCIA DEL INTEGRANTE DE LA FAMILIA</span></a>   
    </div> 
    </div> 


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