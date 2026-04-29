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

$idreferencia_hc_ss         = $_SESSION['idreferencia_hc_ss'];

$idatencion_psafci_ss       = $_SESSION['idatencion_psafci_ss'];
$idcarpeta_familiar_ss      = $_SESSION['idcarpeta_familiar_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idintegrante_cf_ss         = $_SESSION['idintegrante_cf_ss'];
$idnombre_integrante_ss     = $_SESSION['idnombre_integrante_ss'];
$edad_ss                    = $_SESSION['edad_ss'];

$sql_ref =" SELECT idreferencia_hc, iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idatencion_psafci, codigo, idnombre, ";
$sql_ref.=" discapacidad, nombre_acompanante, idparentesco_acomp, celular_acompanante, tel_establecimiento, estuvo_internado, dias_internacion, ";
$sql_ref.=" resumen_anamnesis, especificacion_hallazgos, tratamiento_ref, observaciones_ref, idconsentimiento, idestablecimiento_receptor, idmotivo_referencia, idespecialidad_medica, ";
$sql_ref.=" fecha_registro, hora_registro, idusuario FROM referencia_hc WHERE idreferencia_hc='$idreferencia_hc_ss' ";
$result_ref=mysqli_query($link,$sql_ref);
$row_ref=mysqli_fetch_array($result_ref);

$sql_cf =" SELECT idcarpeta_familiar, codigo, familia, fecha_apertura FROM carpeta_familiar WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
$result_cf=mysqli_query($link,$sql_cf);
$row_cf=mysqli_fetch_array($result_cf);

$sql_n =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$idnombre_integrante_ss' ";
$result_n=mysqli_query($link,$sql_n);
$row_n=mysqli_fetch_array($result_n);

    $fecha_nacimiento = $row_n[5];
    $dia = date("d");
    $mes = date("m");
    $ano = date("Y");    
    $dianaz = date("d",strtotime($fecha_nacimiento));
    $mesnaz = date("m",strtotime($fecha_nacimiento));
    $anonaz = date("Y",strtotime($fecha_nacimiento));         
    if (($mesnaz == $mes) && ($dianaz > $dia)) {
    $ano=($ano-1); }      
    if ($mesnaz > $mes) {
    $ano=($ano-1);}  

    $edad = ($ano-$anonaz);  
        

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
                <!-- BEGIN aqui va el comntenido de la pagina ---->

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                            <div class="text-center">                          
                            <a href="../produccion_servicios/mostrar_atencion_psafci.php"><h6 class="text-info"><- VOLVER</h6></a>
                            <hr>  
                        <div class="text-center">
                        <h4 class="m-0 font-weight-bold text-primary">REFERENCIA</h4>
                        <h4 class="m-0 font-weight-bold text-primary"><?php echo $row_ref[6]; ?></h4>
                        </div>
                    </div>
                    <div class="card-body">

                     <form name="GUARDA_REFERENCIA" action="guarda_referencia.php" method="post"> 
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
  
                                <h6 class="m-0 font-weight-bold text-primary">1.- IDENTIFICACIÓN DEL PACIENTE</h6>
                            </div>
                            <div class="card-body">

                                <div class="form-group row">                               
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">CÉDULA DE IDENTIDAD:</h6>
                                        <input type="number" class="form-control" value="<?php echo $row_n[4];?>" 
                                        name="ci" disabled>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">NOMBRES:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row_n[1];?>"
                                        name="nombre" disabled>                
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">PRIMER APELLIDO:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row_n[2];?>"             
                                        name="paterno" disabled >                
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">SEGUNDO APELLIDO:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row_n[3];?>" 
                                        name="materno" disabled>                
                                    </div>
                                </div>

                                <div class="form-group row">  
                                <div class="col-sm-3">
                                <h6 class="text-primary">GÉNERO</h6>

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
                                <h6 class="text-primary">FECHA DE NACIMIENTO:</h6>
                                    <input type="date"  class="form-control" 
                                        placeholder="ingresar fecha" name="fecha_nac" value="<?php echo $row_n[5];?>" disabled>
                                </div>   
                                
                                <div class="col-sm-2">
                                <h6 class="text-primary">EDAD:</h6>
                                    <input type="number" class="form-control" value="<?php echo $edad_ss;?>" 
                                    name="edad_actual" disabled>
                                </div>
                                <div class="col-sm-4">
                                <h6 class="text-primary">VER CARPETA FAMILIAR:</h6>
                                <a class="btn btn-info btn-icon-split" href="../carpetas_familiares/imprime_carpeta_familiar.php?idcarpeta_familiar=<?php echo $idcarpeta_familiar_ss;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1400,height=800,top=50, left=200, scrollbars=YES'); return false;">              
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
                                $sql4.=" AND integrante_datos_cf.idcontribuye_cf=contribuye_cf.idcontribuye_cf AND integrante_datos_cf.idintegrante_cf='$idintegrante_cf_ss' ORDER BY integrante_datos_cf.idintegrante_datos_cf DESC LIMIT 1 ";
                                $result4 = mysqli_query($link,$sql4);
                                if ($row4 = mysqli_fetch_array($result4)){
                                mysqli_field_seek($result4,0);
                                while ($field4 = mysqli_fetch_field($result4)){
                                } do { 
                                ?>
                                <div class="form-group row">                               
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">ESTADO CIVIL:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row4[1];?>" 
                                        name="" disabled>
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">NIVEL DE INSTRUCCIÓN:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row4[2];?>"
                                        name="" disabled>                
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">PROFESIÓN:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row4[3];?>"             
                                        name="" disabled >                
                                    </div>

                                </div>
                                <div class="form-group row"> 
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">OCUPACIÓN:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row4[4];?>" 
                                        name="" disabled>                
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">CONTRIBUYE AL SUSTENTO FAMILIAR:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row4[5];?>" 
                                        name="" disabled>                
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">HISTORIA CLÍNICA:</h6>
                                        <a class="btn btn-primary btn-icon-split" href="../produccion_servicios/imprime_historia_clinica.php?idcarpeta_familiar=<?php echo $idcarpeta_familiar_ss;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1000,height=1000,top=50, left=400, scrollbars=YES'); return false;">                        
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
                                    <div class="col-sm-4">                             
                                    <h6 class="text-primary">PERSONA CON DISCAPACIDAD:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row_ref[8];?>"             
                                        name="discapacidad" disabled > 
                                    </div>
                                    <?php  if ($row_ref[8]=='SI') { 
                                       $sql_ds =" SELECT tipo_discapacidad_cf.tipo_discapacidad_cf, nivel_discapacidad_cf.nivel_discapacidad_cf FROM discapacidad_ref, tipo_discapacidad_cf, nivel_discapacidad_cf ";
                                       $sql_ds.=" WHERE discapacidad_ref.idtipo_discapacidad=tipo_discapacidad_cf.idtipo_discapacidad_cf AND discapacidad_ref.idnivel_discapacidad=nivel_discapacidad_cf.idnivel_discapacidad_cf ";
                                       $sql_ds.=" AND discapacidad_ref.idreferencia_hc='$idreferencia_hc_ss' ";
                                       $result_ds=mysqli_query($link,$sql_ds);
                                       $row_ds=mysqli_fetch_array($result_ds);    
                                        ?>
                                    <div class="col-sm-4">
                                        <h6 class="text-primary">TIPO DE DISCAPACIDAD:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row_ds[0];?>"             
                                        name="tipo_discapacidad" disabled > 
                                    </div>
                                    <div class="col-sm-4">
                                        <h6 class="text-primary">NIVEL DE DISCAPACIDAD:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row_ds[1];?>"             
                                        name="nivel_discapacidad" disabled > 
                                    </div>
                                    <?php } else {  ?>
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-4"></div>
                                    <?php } ?>

                                </div>
                                <div class="form-group row" id="persona_discapacidad"> 
                                </div>
                                <div class="form-group row">                               
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">NOMBRE DEL ACOMPAÑANTE:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row_ref[9];?>" 
                                        name="nombre_acompanante" disabled>
                                    </div>
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">PARENTESCO:</h6>
                                        <select name="idparentesco_acomp"  id="idparentesco_acomp" class="form-control" disabled >
                                        <option selected>Seleccione</option>
                                        <?php
                                        $sqlv = " SELECT idparentesco, parentesco FROM parentesco ";
                                        $resultv = mysqli_query($link,$sqlv);
                                        if ($rowv = mysqli_fetch_array($resultv)){
                                        mysqli_field_seek($resultv,0);
                                        while ($fieldv = mysqli_fetch_field($resultv)){
                                        } do {
                                        ?>
                                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_ref[10]) echo "selected";?> ><?php echo $rowv[1];?></option>
                                        <?php
                                        } while ($rowv = mysqli_fetch_array($resultv));
                                        } else {
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">                               
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">TEL/CEL DEL ACOMPAÑANTE:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row_ref[11];?>"             
                                        name="celular_acompanante" disabled>                
                                    </div>

                                    <div class="col-sm-6">
                                    <h6 class="text-primary">TEL/CEL DEL ESTABLECIMIENTO DE SALUD:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row_ref[12];?>"             
                                        name="tel_establecimiento" disabled >                
                                    </div>
                                </div>
                                
                            </div>                                
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">2.- DATOS CLÍNICOS Y SIGNOS VITALES</h6>
                            </div>
                            <div class="card-body">
                                    <?php
                                    $sql_sg =" SELECT idsigno_vital_psafci, talla, peso, temperatura, frec_cardiaca, frec_respiratoria, presion_arterial, presion_arterial_d, saturacion, glascow, alergia, ";
                                    $sql_sg.=" descripcion_alergia, imc FROM signo_vital_psafci WHERE idnombre ='$idnombre_integrante_ss' AND idatencion_psafci='$idatencion_psafci_ss' ORDER BY idsigno_vital_psafci DESC LIMIT 1 ";
                                    $result_sg = mysqli_query($link,$sql_sg);
                                    $row_sg = mysqli_fetch_array($result_sg);
                                    ?>                               
                                <div class="form-group row">  
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">TALLA </br>[Centímetros]:</h6>
                                        <input type="text" class="form-control" placeholder="En Centrimetros"
                                            name="talla" value="<?php echo $row_sg[1];?>" disabled>                
                                    </div>                             
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">PESO </br>[kg]:</h6>
                                        <input type="number" class="form-control"              
                                            name="peso" value="<?php echo $row_sg[2];?>" disabled>                
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">TEMPERATURA</br>[°C]:</h6>
                                        <input type="text" class="form-control" 
                                            name="temperatura" placeholder="" value="<?php echo $row_sg[3];?>" disabled>                
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FRECUENCIA CARDIACA </br>[lpm]:</h6>
                                        <input type="text" class="form-control" 
                                            name="frec_cardiaca" value="<?php echo $row_sg[4];?>" disabled>                
                                    </div>
                                </div>

                                <?php  if ($edad_ss > '5') {  //******* PARA MAYOR DE 5 ANOS */ ?>
                            
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                                        <input type="number" class="form-control" 
                                            name="frec_respiratoria" value="<?php echo $row_sg[5];?>" disabled>                
                                    </div> 
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>
                                        <input type="number" class="form-control"              
                                            name="presion_arterial"  placeholder="Sistólica" value="<?php echo $row_sg[6];?>" disabled>               
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary"> </br>diastólica [mmHg]</h6>
                                            <input type="number" class="form-control"              
                                            name="presion_arterial_d" placeholder="Diastólica" value="<?php echo $row_sg[7];?>" disabled>                
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">SATURACIÓN</br>[% O2]:</h6>
                                        <input type="number" class="form-control"
                                            name="saturacion" value="<?php echo $row_sg[8];?>" disabled>                
                                    </div>
                                </div>

                                <div class="form-group row">  
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">GLASCOW:</br> </h6>
                                        <input type="number" class="form-control" 
                                            name="glascow" placeholder="" value="<?php echo $row_sg[9];?>" disabled>                
                                    </div>  
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">ALÉRGIAS:</h6>
                                    SI <input type="radio" name="alergia" value="SI" <?php if ($row_sg[10] =='SI') { echo 'checked'; } else { } ?> disabled></br>
                                    NO <input type="radio" name="alergia" value="NO" <?php if ($row_sg[10] =='NO') { echo 'checked'; } else { } ?> disabled>
                                    </div>
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">DESCRIPCIÓN DE LA ALÉRGIA</h6>
                                    <textarea class="form-control" rows="3" name="descripcion_alergia"  disabled ><?php echo $row_sg[11];?></textarea>
                                    <button type="button" class="btn-mic" onclick="iniciarDictado('descripcion_alergia')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                                    </div>
                                </div>

                                <?php } else { ?>

                                <div class="form-group row">
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                                        <input type="number" class="form-control" 
                                            name="frec_respiratoria" value="0" disabled>                
                                    </div> 
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">SATURACIÓN</br>[% O2]:</h6>   
                                        <input type="number" class="form-control"
                                            name="saturacion" value="0" disabled>             
                                    </div>
                                    <div class="col-sm-3">
                                    <!-- <h6 class="text-primary">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>  para menor de 5 anos -->
                                        <input type="hidden" class="form-control"              
                                            name="presion_arterial"  placeholder="Sistólica" value="0">               
                                    </div>
                                    <div class="col-sm-3">
                                    <!-- <h6 class="text-primary"> </br>diastólica [mmHg]</h6>   para menor de 5 anos    --> 
                                            <input type="hidden" class="form-control"              
                                            name="presion_arterial_d" placeholder="Diastólica" value="0">          
                                    </div>
                                </div>

                                <div class="form-group row">  
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">GLASCOW:</br> </h6>
                                        <input type="number" class="form-control" 
                                            name="glascow" placeholder="" value="<?php echo $row_sg[9];?>" disabled>               
                                    </div>  
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">ALÉRGIAS:</h6>
                                    SI <input type="radio" name="alergia" value="SI" <?php if ($row_sg[10] =='SI') { echo 'checked'; } else { } ?> disabled></br>
                                    NO <input type="radio" name="alergia" value="NO" <?php if ($row_sg[10] =='NO') { echo 'checked'; } else { } ?> disabled>
                                    </div>
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">DESCRIPCIÓN DE LA ALÉRGIA</h6>
                                    <textarea class="form-control" rows="3" name="descripcion_alergia" id="descripcion_alergia"></textarea>
                                    <button type="button" class="btn-mic" onclick="iniciarDictado('descripcion_alergia')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>                            
                                    </div>
                                </div>

                            <?php } ?>

                            </div>
                        </div>

                        <?php  if ($row_n[7] == '1' && $edad > '14') {  //******* PARA MUJERES MAYORES A 14 AÑOS EN ESTADO DE EMBARAZO O NACIMIENTO */ ?>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">2.1.- ANTECEDENTES GINECO OBTETRICOS</h6>
                            </div>
                            <div class="card-body">
                                
                                    <div class="form-group row">  
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">F.U.M. </br>[fecha]</h6>
                                        <input type="date" class="form-control" placeholder="En Centrimetros"
                                            name="fecha_fum" value="1" disabled>                
                                    </div>                             
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">G</br>[Gestaciones]:</h6>
                                        <input type="number" class="form-control"              
                                            name="gestaciones" value="1" required>                
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">P</br>[Partos]:</h6>
                                        <input type="number" class="form-control" 
                                            name="partos" placeholder="" value="0" required>                
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">A</br>[Abortos]:</h6>
                                        <input type="number" class="form-control" 
                                            name="abortos" value="0" required>                
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">C</br>[Cesáreas]:</h6>
                                        <input type="number" class="form-control" 
                                            name="cesareas" placeholder="" value="0" required>                
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">F.P.P.</br>[fecha]</h6>
                                        <input type="date" class="form-control" 
                                            name="fecha_fpp" value="0" required>                
                                    </div>
                                </div>
                            
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">R.P.M. </br>[hrs.]:</h6> 
                                        <input type="time" class="form-control" 
                                            name="hora_rpm" value="0" required>                
                                    </div> 
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">F.C.F.</br></br></h6>
                                        <input type="number" class="form-control"              
                                            name="frecuencia_fcf"  placeholder="" value="0" required>               
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">Nº CONTROLES</br>PRENATALES</h6>
                                        <input type="number" class="form-control"              
                                            name="controles_prenatales"  placeholder="" value="0" required>               
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">MADURACIÓN PULMONAR:</h6>
                                    SI <input type="radio" name="maduracion_p" value="SI" > </br>
                                    NO <input type="radio" name="maduracion_p" value="NO" checked >  
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">PARTO:</h6>
                                    <select name="parto" id="parto" class="form-control" required>
                                        <option value="">Seleccione</option>
                                        <option value="NO">NO</option>
                                        <option value="SI">SI</option>
                                    </select>
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary"></h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="datos_parto">
                        </div>

                        <?php } else { ?>
                        <?php } ?>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">3.- RESUMEN DE ANAMNESIS Y EXAMEN FISICO</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">¿ESTUVO INTERNADO?:</h6>
                                        SI <input type="radio" name="estuvo_internado" value="SI" <?php if ($row_ref[13] =='SI') { echo 'checked'; } else { } ?> disabled></br>
                                        NO <input type="radio" name="estuvo_internado" value="NO" <?php if ($row_ref[13] =='NO') { echo 'checked'; } else { } ?> disabled>              
                                    </div>

                                    <div class="col-sm-3">
                                    <h6 class="text-primary">DÍAS DE INTERNACIÓN:</h6>
                                        <input type="number" class="form-control" value="<?php echo $row_ref[14];?>"             
                                        name="dias_internacion" disabled >                
                                    </div>
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">RESUMEN ANAMNESIS</h6>
                                    <textarea class="form-control" rows="3" name="resumen_anamnesis" id="resumen_anamnesis" disabled><?php echo $row_ref[15];?></textarea>
                                    <button type="button" class="btn-mic" onclick="iniciarDictado('resumen_anamnesis')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">4.- REALIZO EXÁMENES COMPLEMENTARIOS DE DIAGNÓSTICO</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row"> 
                                    <div class="col-sm-12">
                                    <div class="text-center">
                                        <h6 class="text-primary">HALLAZGOS LLAMATIVOS:</h6>
                                    </div>
                                    <hr>
                                    </div>
                                </div>
                                <div class="form-group row">   
                                    <?php
                                    $numero_c=0;
                                    $sql_c =" SELECT examen_referencia.idexamen_complementario, examen_complementario.examen_complementario FROM examen_referencia, examen_complementario ";
                                    $sql_c.=" WHERE examen_referencia.idexamen_complementario=examen_complementario.idexamen_complementario AND examen_referencia.idreferencia_hc='$idreferencia_hc_ss' ";
                                    $result_c = mysqli_query($link,$sql_c);
                                    if ($row_c = mysqli_fetch_array($result_c)){
                                    mysqli_field_seek($result_c,0);
                                    while ($field_c = mysqli_fetch_field($result_c)){
                                    } do { ?>                            
                                            <div class="col-sm-2">
                                            <h6 class="text-primary"><?php echo $row_c[1];?> : <input type="checkbox" name="idexamen_complementario[<?php echo $numero_c;?>]" value="<?php echo $row_c[0];?>" checked disabled></h6>    
                                            </div>
                                    <?php
                                    $numero_c=$numero_c+1;
                                    }
                                    while ($row_c = mysqli_fetch_array($result_c));
                                    } else {
                                    }
                                    ?>

                                </div>
                                <div class="form-group row">  
                                    <div class="col-sm-12">
                                    <h6 class="text-primary">ESPECIFIQUE : </h6>  
                                    <textarea class="form-control" rows="3" name="especificacion_hallazgos" id="especificacion_hallazgos" disabled><?php echo $row_ref[16];?></textarea>
                                    <button type="button" class="btn-mic" onclick="iniciarDictado('especificacion_hallazgos')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>  
                                    </div>
                                </div>
                            </div>
                        </div>  
                        


                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">5.- DIAGNÓSTICOS PRESUNTIVOS</h6>
                            </div>
                            <div class="card-body">

                                <?php
                                $numero_dg=0;
                                $sql_dg =" SELECT iddiagnostico_presuntivo, diagnostico_presuntivo, idpatologia FROM diagnostico_presuntivo ";
                                $sql_dg.=" WHERE idreferencia_hc='$idreferencia_hc_ss' ";
                                $result_dg = mysqli_query($link,$sql_dg);
                                if ($row_dg = mysqli_fetch_array($result_dg)){
                                mysqli_field_seek($result_dg,0);
                                while ($field_dg = mysqli_fetch_field($result_dg)){
                                } do { ?> 
                                <div class="form-group row">                               
                                    <div class="col-sm-6">
                                    <h6 class="m-0 font-weight-bold text-primary">DIAGNÓSTICO PRESUNTIVO </h6>
                                    <textarea class="form-control" rows="3" name="diagnostico_presuntivo[0]"  disabled><?php echo $row_dg[1];?></textarea>
                                    <button type="button" class="btn-mic" onclick="iniciarDictado('diagnostico_presuntivo[0]')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>    
                                    </div>
                                    <div class="col-sm-6">
                                        <h6 class="m-0 font-weight-bold text-primary">CIE - 10</h6>
                                        <select name="idpatologia[]"  id="idpatologia[]" class="form-control" disabled >
                                        <option selected>Seleccione</option>
                                        <?php
                                        $sqlv = " SELECT idpatologia, patologia, cie FROM patologia WHERE cie NOT LIKE '%Z%' ORDER BY patologia ";
                                        $resultv = mysqli_query($link,$sqlv);
                                        if ($rowv = mysqli_fetch_array($resultv)){
                                        mysqli_field_seek($resultv,0);
                                        while ($fieldv = mysqli_fetch_field($resultv)){
                                        } do {
                                        ?>
                                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_dg[2]) echo "selected";?> ><?php echo $rowv[1];?> - <?php echo $rowv[2];?></option>
                                        <?php
                                        } while ($rowv = mysqli_fetch_array($resultv));
                                        } else {
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>

                        <?php
                        $numero_dg=$numero_dg+1;
                        }
                        while ($row_dg = mysqli_fetch_array($result_dg));
                        } else {
                        }
                        ?>                                

                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">6.- TRATAMIENTO</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-12">
                                    <textarea class="form-control" rows="3" name="tratamiento_ref" disabled><?php echo $row_ref[17];?></textarea>
                                    <button type="button" class="btn-mic" onclick="iniciarDictado('tratamiento_ref')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>      
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">7.- OBSERVACIONES</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-12">
                                    <textarea class="form-control" rows="3" name="observaciones_ref" disabled><?php echo $row_ref[18];?></textarea>
                                    <button type="button" class="btn-mic" onclick="iniciarDictado('observaciones_ref')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>   
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">8.- CONSENTIMIENTO</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-6">
                                        <h6 class="m-0 font-weight-bold text-primary">LA PERSONA QUIEN FIRMA EL CONSENTIMIENTO ES EL: </h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <select name="idconsentimiento" id="idconsentimiento" class="form-control" disabled >
                                        <option selected>Seleccione</option>
                                        <?php
                                        $sqlv = " SELECT idconsentimiento, consentimiento FROM consentimiento ";
                                        $resultv = mysqli_query($link,$sqlv);
                                        if ($rowv = mysqli_fetch_array($resultv)){
                                        mysqli_field_seek($resultv,0);
                                        while ($fieldv = mysqli_fetch_field($resultv)){
                                        } do {
                                        ?>
                                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_ref[19]) echo "selected";?> ><?php echo $rowv[1];?></option>
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

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">9.- ESTABLECIMIENTO RECEPTOR</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">   
                                    <div class="col-sm-12">  
                                        <select name="idconsentimiento" id="idconsentimiento" class="form-control" disabled >
                                        <option selected>Seleccione</option>
                                        <?php
                                        $sqlv =" SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, nivel_establecimiento.nivel_establecimiento, tipo_establecimiento.tipo_establecimiento,";
                                        $sqlv.=" subsector_salud.subsector_salud, municipios.municipio, departamento.departamento FROM establecimiento_salud, subsector_salud, nivel_establecimiento, tipo_establecimiento, departamento, municipios ";
                                        $sqlv.=" WHERE establecimiento_salud.idsubsector_salud=subsector_salud.idsubsector_salud AND establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento AND establecimiento_salud.iddepartamento=departamento.iddepartamento ";
                                        $sqlv.=" AND establecimiento_salud.idmunicipio=municipios.idmunicipio  AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento ";
                                        $resultv = mysqli_query($link,$sqlv);
                                        if ($rowv = mysqli_fetch_array($resultv)){
                                        mysqli_field_seek($resultv,0);
                                        while ($fieldv = mysqli_fetch_field($resultv)){
                                        } do {
                                        ?>
                                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_ref[20]) echo "selected";?> ><?php echo $rowv[1];?> - <?php echo $rowv[2];?> - <?php echo $rowv[3];?> / <?php echo $rowv[4];?> - Mun. <?php echo $rowv[5];?> / Dep. <?php echo $rowv[6];?> </option>
                                        <?php
                                        } while ($rowv = mysqli_fetch_array($resultv));
                                        } else {
                                        }
                                        ?>
                                        </select>
                                    </div>   
                                </div> 
                                <div class="form-group row">                           
                                    <div class="col-sm-6">  
                                        <h6 class="text-primary">MOTIVO:</h6> 
                                        <select name="idmotivo_referencia" id="idmotivo_referencia" class="form-control" disabled >
                                        <option selected>Seleccione</option>
                                        <?php
                                        $sqlv = " SELECT idmotivo_referencia, motivo_referencia FROM motivo_referencia ";
                                        $resultv = mysqli_query($link,$sqlv);
                                        if ($rowv = mysqli_fetch_array($resultv)){
                                        mysqli_field_seek($resultv,0);
                                        while ($fieldv = mysqli_fetch_field($resultv)){
                                        } do {
                                        ?>
                                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_ref[21]) echo "selected";?> ><?php echo $rowv[1];?></option>
                                        <?php
                                        } while ($rowv = mysqli_fetch_array($resultv));
                                        } else {
                                        }
                                        ?>
                                        </select>
                                        </div>
                                        <div class="col-sm-6">
                                        <h6 class="text-primary">ESPECIALIDAD MÉDICA :</h6> 
                                        <select name="idespecialidad_medica" id="idespecialidad_medica" class="form-control" disabled >
                                            <option selected>Seleccione</option>
                                            <?php
                                            $sqlv = " SELECT idespecialidad_medica, especialidad_medica FROM especialidad_medica WHERE idespecialidad_medica !='45' ORDER BY especialidad_medica  ";
                                            $resultv = mysqli_query($link,$sqlv);
                                            if ($rowv = mysqli_fetch_array($resultv)){
                                            mysqli_field_seek($resultv,0);
                                            while ($fieldv = mysqli_fetch_field($resultv)){
                                            } do {
                                            ?>
                                            <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_ref[22]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                          
                        </div>

                            <div class="text-center">   
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <a class="btn btn-success btn-icon-split" href="../referencia_safci/imprime_formulario_d7.php?idreferencia_hc=<?php echo $idreferencia_hc_ss;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1000,height=1000,top=50, left=600, scrollbars=YES'); return false;">                        
                                        <span class="icon text-white-50">
                                            <i class="fas fa-book"></i>
                                        </span>
                                        <span class="text">IMPRIMIR FORMULARIO D7</span>
                                        </a> 
                                    </div>                              
                                </div>                            
                            </div>



                            <!-- modal de confirmacion de envio de datos-->
                            <div class="modal fade" id="examplemodal_f" tabindex="-1" role="dialog" aria-labelledby="examplemodal_fLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="examplemodal_fLabel">REGISTRAR REFERENCIA</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                                
                                                Esta seguro de Registrar la Referencia?
                                                posteriormenete no se podran realizar cambios.

                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                            <button type="submit" class="btn btn-primary pull-center">CONFIRMAR REGISTRO</button>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                <!-- Modal -->


                    </div>
                </div>


                <!-- END aqui va el comntenido de la pagina ---->  
                
            </div>

                    <div class="text-center">
                        <a class="small" href="#">PROGRAMA SAFCI - MI SALUD</a>
                    </div>
                    <div class="text-center">
                        <a class="small" href="#">Ministerio de Salud y Deportes</a>
                    </div> 
                    </br> 
                        <!-- Logout Modal begin -->
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
                        <!-- Logout Modal end-->

        </div> 
    </div> 
</div>       
<!-- END aqui va el comntenido de la pagina ---->
        

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
        <script>$("#fecha1").datepicker($.datepicker.regional[ "es" ]);</script>
        <script src="../js/funciones.js"></script>

 

</body>
</html>