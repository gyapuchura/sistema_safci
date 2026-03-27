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
                <!-- BEGIN aqui va el comntenido de la pagina ---->

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="text-center">
                        <h4 class="m-0 font-weight-bold text-primary">FORMULARIO DE REFERENCIA</h4>
                        </div>
                    </div>
                    <div class="card-body">

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
                                $sql4.=" AND integrante_datos_cf.idcontribuye_cf=contribuye_cf.idcontribuye_cf AND integrante_datos_cf.idintegrante_cf='$idintegrante_cf_ss'";
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

                                <form name="GUARDA_REFERENCIA" action="guarda_referencia.php" method="post">  
                                
                                <div class="form-group row">  
                                    <div class="col-sm-4">                             
                                    <h6 class="text-primary">PERSONA CON DISCAPACIDAD:</h6>
                                    <select name="persona_discapacidad" id="persona_discapacidad" class="form-control">
                                        <option value="NO">NO</option>
                                        <option value="SI">SI</option>
                                    </select>
                                    </div>
                                    <div class="col-sm-8"></div>
                                </div>

                                <div class="form-group row" id="discapacidad">                                    
                                </div> 

                                <div class="form-group row">                               
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">NOMBRE DEL ACOMPAÑANTE:</h6>
                                        <input type="text" class="form-control" value="" 
                                        name="acompanante" required>
                                    </div>
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">PARENTESCO:</h6>
                                    <select name="idparentesco_acomp" id="idparentesco_acomp" class="form-control" required>
                                        <option value="">-SELECCIONE-</option>
                                        <?php
                                        $sql1 = "SELECT idparentesco, parentesco FROM parentesco ";
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
                                <div class="form-group row">                               
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">TEL/CEL DEL ACOMPAÑANTE:</h6>
                                        <input type="text" class="form-control" value=""             
                                        name="celular_acompanante" required>                
                                    </div>

                                    <div class="col-sm-6">
                                    <h6 class="text-primary">TEL/CEL DEL ESTABLECIMIENTO DE SALUD:</h6>
                                        <input type="text" class="form-control" value=""             
                                        name="tel_establecimiento" required >                
                                    </div>
                                </div>
                                
                            </div>                                
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">2.- DATOS CLÍNICOS Y SIGNOS VITALES</h6>
                            </div>
                            <div class="card-body">
                                
                                <div class="form-group row">  
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">TALLA </br>[Centímetros]:</h6>
                                        <input type="text" class="form-control" placeholder="En Centrimetros"
                                            name="talla" value="1" required>                
                                    </div>                             
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">PESO </br>[kg]:</h6>
                                        <input type="number" class="form-control"              
                                            name="peso" value="1" required>                
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">TEMPERATURA</br>[°C]:</h6>
                                        <input type="text" class="form-control" 
                                            name="temperatura" placeholder="" value="0" required>                
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FRECUENCIA CARDIACA </br>[lpm]:</h6>
                                        <input type="text" class="form-control" 
                                            name="frec_cardiaca" value="0" required>                
                                    </div>
                                </div>

                                <?php  if ($edad_ss > '5') {  //******* PARA MAYOR DE 5 ANOS */ ?>
                            
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                                        <input type="number" class="form-control" 
                                            name="frec_respiratoria" value="0" required>                
                                    </div> 
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>
                                        <input type="number" class="form-control"              
                                            name="presion_arterial"  placeholder="Sistólica" value="0" required>               
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary"> </br>diastólica [mmHg]</h6>
                                            <input type="number" class="form-control"              
                                            name="presion_arterial_d" placeholder="Diastólica" value="0" required>                
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">SATURACIÓN</br>[% O2]:</h6>
                                        <input type="number" class="form-control"
                                            name="saturacion" value="0" required>                
                                    </div>
                                </div>

                                <div class="form-group row">  
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">GLASCOW:</br> </h6>
                                        <input type="number" class="form-control" 
                                            name="glascow" placeholder="" value="0" required>                
                                    </div>  
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">ALÉRGIAS:</h6>
                                    SI <input type="radio" name="alergia" value="SI" > </br>
                                    NO <input type="radio" name="alergia" value="NO" checked >  
                                    </div>
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">DESCRIPCIÓN DE LA ALÉRGIA</h6>
                                    <textarea class="form-control" rows="2" name="descripcion_alergia"></textarea> 
                                    </div>
                                </div>

                                <?php } else { ?>

                                <div class="form-group row">
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                                        <input type="number" class="form-control" 
                                            name="frec_respiratoria" value="0" required>                
                                    </div> 
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">SATURACIÓN</br>[% O2]:</h6>   
                                        <input type="number" class="form-control"
                                            name="saturacion" value="0" required>             
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
                                            name="glascow" placeholder="" value="0" required>                
                                    </div>  
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">ALÉRGIAS:</h6>
                                    SI <input type="radio" name="alergia" value="SI" > </br>
                                    NO <input type="radio" name="alergia" value="NO" checked >  
                                    </div>
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">DESCRIPCIÓN DE LA ALÉRGIA</h6>
                                    <textarea class="form-control" rows="2" name="descripcion_alergia"></textarea> 
                                    </div>
                                </div>

                            <?php } ?>

                            </div>
                        </div>

                        <?php  if ($row_n[7] == '1') {  //******* PARA MUJERES EN ESTADO DE EMBARAZO O NACIMIENTO */ ?>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">2.1.- ANTECEDENTES GINECO OBTETRICOS</h6>
                            </div>
                            <div class="card-body">
                                
                                    <div class="form-group row">  
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">F.U.M. </br>[fecha]</h6>
                                        <input type="date" class="form-control" placeholder="En Centrimetros"
                                            name="fecha_fum" value="1" required>                
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
                                    <select name="parto" id="parto" class="form-control">
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

                        <div class="card shadow mb-4" id="datos_parto">
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
                                        SI <input type="radio" name="internado" value="SI" > </br>
                                        NO <input type="radio" name="internado" value="NO" checked >                
                                    </div>

                                    <div class="col-sm-3">
                                    <h6 class="text-primary">DÍAS DE INTERNACIÓN:</h6>
                                        <input type="number" class="form-control" value=""             
                                        name="dias_internacion"  >                
                                    </div>
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">RESUMEN ANAMNESIS</h6>
                                    <textarea class="form-control" rows="3" name="resumen_anamnesis"></textarea> 
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
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">RX : <input type="checkbox" name="rayos_x" id="rx"></h6>    
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">LABORATORIO : <input type="checkbox" name="laboratorio" id="laboratorio" ></h6>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">ECOGRAFÍA : <input type="checkbox" name="ecografia" id="ecografia" ></h6>                   
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">TOMOGRAFÍA : <input type="checkbox" name="tomografia" id="tomografia"></h6>                       
                                    </div>
                                </div>
                                <div class="form-group row">  

                                    <div class="col-sm-3">
                                    <h6 class="text-primary">OTROS : <input type="checkbox" name="otros" id="otros"></h6>           
                                    </div>
                                    <div class="col-sm-9">
                                    <h6 class="text-primary">ESPECIFIQUE : </h6>  
                                    <textarea class="form-control" rows="2" name="especificacion_hallazgos" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">5.- DIAGNÓSTICOS PRESUNTIVOS</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-8">
                                    <textarea class="form-control" rows="2" name="diagnostico_presuntivo[0]" required></textarea>    
                                    </div>
                                    <div class="col-sm-1">
                                    <h6 class="text-primary">CIE : </h6>         
                                    </div>
                                    <div class="col-sm-3">
                                    <input type="text" class="form-control" value=""  name="cie[0]" />
                                    </div>
                                </div>
                                <div class="form-group row">                               
                                    <div class="col-sm-8">
                                    <textarea class="form-control" rows="2" name="diagnostico_presuntivo[1]"></textarea>    
                                    </div>
                                    <div class="col-sm-1">
                                    <h6 class="text-primary">CIE : </h6>         
                                    </div>
                                    <div class="col-sm-3">
                                    <input type="text" class="form-control" value=""  name="cie[1]" />
                                    </div>
                                </div>
                                <div class="form-group row">                               
                                    <div class="col-sm-8">
                                    <textarea class="form-control" rows="2" name="diagnostico_presuntivo[2]"></textarea>    
                                    </div>
                                    <div class="col-sm-1">
                                    <h6 class="text-primary">CIE : </h6>         
                                    </div>
                                    <div class="col-sm-3">
                                    <input type="text" class="form-control" value=""  name="cie[2]" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">6.- TRATAMIENTO</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-12">
                                    <textarea class="form-control" rows="3" name="tratamiento_ref" required></textarea>    
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
                                    <textarea class="form-control" rows="2" name="observaciones_ref"></textarea>    
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
                                        <h6 class="m-0 font-weight-bold text-primary">SELECCIONE QUIEN FIRMARÁ EL CONSENTIMIENTO : </h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <select name="idconsentimiento"  id="idconsentimiento" class="form-control" required>
                                            <?php
                                            $sql1 = "SELECT idconsentimiento, consentimiento FROM consentimiento ";
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
                                <h6 class="m-0 font-weight-bold text-primary">9.- ESTABLECIMIENTO RECEPTOR</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">   
                                    <div class="col-sm-12">  
                                        <h6 class="m-0 font-weight-bold text-primary">ESCRIBA Y LUEGO SELECCIONE DEL ESTABLECIMIENTO : </h6>  </br>                               
                                        <input type="text" class="form-control" placeholder="NOMBRE DEL ESTABLECIMIENTO DE SALUD" id="busqueda" required/>
                                    </div>   
                                </div> 
                                <div class="form-group row">                           
                                    <div class="col-sm-12" id="resultado">  
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">10.- MOTIVO DE REFERENCIA</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                              
                                    <div class="col-sm-6">  
                                        <h6 class="text-primary">MOTIVO:</h6> 
                                        <select name="idmotivo_referencia" id="idmotivo_referencia" class="form-control" required>
                                        <option value="">-SELECCIONE-</option>
                                        <?php
                                        $numero_mr=1;
                                        $sql_mr = " SELECT idmotivo_referencia, motivo_referencia FROM motivo_referencia ORDER BY idmotivo_referencia"; 
                                        $result_mr = mysqli_query($link,$sql_mr);
                                        if ($row_mr = mysqli_fetch_array($result_mr)){
                                        mysqli_field_seek($result_mr,0);
                                        while ($field_mr = mysqli_fetch_field($result_mr)){
                                        } do {
                                        echo "<option value=".$row_mr[0].">".$numero_mr.".- ".$row_mr[1]." </option>";
                                        $numero_mr=$numero_mr+1;
                                        } while ($row_mr = mysqli_fetch_array($result_mr));
                                        } else {
                                        echo "No se encontraron resultados!";
                                        }
                                        ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <h6 class="text-primary">ESPECIALIDAD MÉDICA:</h6> 
                                        <select name="idespecialidad_medica"  id="idespecialidad_medica" class="form-control" required>
                                            <option value="">ELEGIR</option>
                                            <?php
                                            $sql1 = "SELECT idespecialidad_medica, especialidad_medica FROM especialidad_medica WHERE idespecialidad_medica !='45' ORDER BY especialidad_medica ";
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


                            <div class="text-center">   
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                        REGISTRAR REFERENCIA
                                        </button>  
                                    </div>                              
                                </div>                            
                            </div>
                            <!-- modal de confirmacion de envio de datos-->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">REGISTRAR REFERENCIA</h5>
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

  <script>
			$(document).ready(function(){
				  var consulta;

				  $("#busqueda").keyup(function(e){
						//obtenemos el texto introducido en el campo de b�squeda
						consulta = $("#busqueda").val();
						 //hace la b�squeda
							 $.ajax({
								   type: "POST",
								   url: "buscar_establecimiento.php",
								   data: "b="+consulta,
								   dataType: "html",
								   beforeSend: function(){
											  //imagen de carga
										   $("#resultado").html("<p align='center'><img src='ajax-loader.gif' /></p>");
								   },
								   error: function(){
										   alert("error peticion ajax");
									 },
								  success: function(data){
										$("#resultado").empty();
										$("#resultado").append(data);
										//$("#busqueda").val(consulta);
									}
							});
				  });
			});
	    </script>

        <script language="javascript"> 
            $(document).ready(function(){
            $("#parto").change(function () {
                        $("#parto option:selected").each(function () {
                            parto=$(this).val();
                        $.post("datos_parto.php", {parto:parto}, function(data){
                        $("#datos_parto").html(data);
                        });
                    });
            })
            });
        </script>

        <script language="javascript"> 
            $(document).ready(function(){
            $("#persona_discapacidad").change(function () {
                        $("#persona_discapacidad option:selected").each(function () {
                            persona_discapacidad=$(this).val();
                        $.post("persona_discapacidad.php", {persona_discapacidad:persona_discapacidad}, function(data){
                        $("#discapacidad").html(data);
                        });
                    });
            })
            });
        </script>

</body>
</html>