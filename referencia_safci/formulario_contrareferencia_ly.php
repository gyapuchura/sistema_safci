<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
// Desactiva todos los avisos de PHP
error_reporting(E_ALL ^ E_NOTICE);
?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idderiva_referencia_hc_ss  = $_SESSION['idderiva_referencia_hc_ss'];
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
$sql_ref.=" fecha_registro, hora_registro, idusuario, adecuada, justificada, oportuna FROM referencia_hc WHERE idreferencia_hc='$idreferencia_hc_ss' ";
$result_ref=mysqli_query($link,$sql_ref);
$row_ref=mysqli_fetch_array($result_ref);

$sql_e    = " SELECT iddepartamento, idred_salud, idmunicipio FROM establecimiento_salud WHERE idestablecimiento_salud='$row_ref[20]' ";
$result_e = mysqli_query($link,$sql_e);
$row_e    = mysqli_fetch_array($result_e);

$iddepartamento = $row_e[0]; 
$idred_salud    = $row_e[1];
$idmunicipio    = $row_e[2];

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
                            <a href="../referencia_safci/admitidos_referencia.php"><h6 class="text-info"><- VOLVER</h6></a>
                            <hr>  
                        <div class="text-center">
                        <h4 class="m-0 font-weight-bold text-primary">FORMULARIO D7A - CONTRAREFERENCIA</h4>
                        <h4 class="m-0 font-weight-bold text-primary"><?php echo $row_ref[6]; ?></h4>
                        </div>
                    </div>
                    <div class="card-body">

                     <form name="GUARDA_CONTRAREF" action="guarda_contrareferencia.php" method="post" class="needs-validation" novalidate> <!-- Modificado -->

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">DATOS DEL ESTABLECIMIENTO DE SALUD QUE CONTRAREFIERE</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                <div class="col-sm-3">
                                <h6 class="text-primary">DEPARTAMENTO:</h6>
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
                                    <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$iddepartamento) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                                    <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$idmunicipio) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                                    <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$idred_salud) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                                    <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_ref[20]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                                <h6 class="m-0 font-weight-bold text-primary">CALIFICACIÓN POR EL ESTABLECIMIENTO RECEPTOR</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">ADECUADA :</h6>
                                    <input type="text" class="form-control" value="<?php echo $row_ref[26];?>" 
                                    name="adecuada" disabled>
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">JUSTIFICADA :</h6>
                                    <input type="text" class="form-control" value="<?php echo $row_ref[27];?>" 
                                    name="justificada" disabled>
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">OPORTUNA :</h6>
                                    <input type="text" class="form-control" value="<?php echo $row_ref[28];?>" 
                                    name="oportuna" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
  
                                <h6 class="m-0 font-weight-bold text-primary">IDENTIFICACIÓN DEL PACIENTE</h6>
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
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">OCUPACIÓN:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row4[4];?>" 
                                        name="" disabled>                
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">CONTRIBUYE AL SUSTENTO FAMILIAR:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row4[5];?>" 
                                        name="" disabled>                
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">HISTORIA CLÍNICA:</h6>
                                        <a class="btn btn-primary btn-icon-split" href="../produccion_servicios/imprime_historia_clinica.php?idcarpeta_familiar=<?php echo $idcarpeta_familiar_ss;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1000,height=1000,top=50, left=400, scrollbars=YES'); return false;">                        
                                        <span class="icon text-white-50">
                                            <i class="fas fa-book"></i>
                                        </span>
                                        <span class="text">HISTORIA CLÍNICA DIGITAL</span>
                                        </a>                                      
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FORMULARIO - D7:</h6>
                                        <a class="btn btn-success btn-icon-split" href="../referencia_safci/imprime_formulario_d7.php?idreferencia_hc=<?php echo $idreferencia_hc_ss;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1000,height=1000,top=50, left=600, scrollbars=YES'); return false;">                        
                                        <span class="icon text-white-50">
                                            <i class="fas fa-print"></i>
                                        </span>
                                        <span class="text">IMPRIMIR FORMULARIO D7</span>
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
                                <div class="form-group row">   <!-- Modificado -->                            
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">TEL/CEL DEL ACOMPAÑANTE:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row_ref[11];?>"             
                                        name="celular_acompanante" disabled>                
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">TEL/CEL DEL ESTABLECIMIENTO DE SALUD:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row_ref[12];?>"             
                                        name="tel_establecimiento" disabled >                
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">TEL/CEL DEL ESTABLECIMIENTO QUE CONTRARREFIERE:</h6>
                                        <input type="number" class="form-control" value=""             
                                        name="tel_establecimiento_cref" required autofocus >                
                                        <div class="invalid-feedback" style="margin-top: 5px;">Debe indicar el teléfono de contacto.</div> </div>
                                </div>                                
                            </div>                                
                        </div>

                        <div class="card shadow mb-4"> <!-- Modificado toda la seccion -->
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">DATOS CLÍNICOS DE ALTA</h6>
                            </div>
                            <div class="card-body">                             
                                <div class="form-group row">  
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">DÍAS DE INTERNACIÓN </br>[dias]:</h6>
                                        <input type="number" min="0" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value < 0) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" class="form-control" placeholder="En Días Calendario"
                                            name="dias_internacion_ref" value="" required> <div class="invalid-feedback" style="margin-top: 5px;">Indique los días de internación.</div> 
                                    </div>  
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">TALLA </br>[Centímetros]:</h6>
                                        <input type="text" min="20" max="280" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 280) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 20) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En Centímetros"
                                            name="talla" value="" required> <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 20 a 280 cm</div> 
                                    </div>                             
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">PESO </br>[kg]:</h6>
                                        <input type="text" step="any" min="0.2" max="650" onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();" oninput="if(this.value > 650) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0.2) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En kilogramos"              
                                            name="peso" value="" required> <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0.2 a 650 kg</div> 
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">TEMPERATURA</br>[°C]:</h6>
                                        <input type="text" step="any" min="10" max="47" onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();" oninput="if(this.value > 47) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 10) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En grados celsius"
                                            name="temperatura" value="" required> <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 10°C a 47°C</div> 
                                    </div>

                                </div>
                            
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FRECUENCIA CARDIACA </br>[lpm]:</h6>
                                        <input type="number" min="0" max="350" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 350) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En latidos por minuto"
                                            name="frec_cardiaca" value="" required> <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 350 lpm</div> 
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                                        <input type="number" min="0" max="80" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 80) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En Ciclos por Minuto"
                                            name="frec_respiratoria" value="" required> <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 80 cpm</div> 
                                    </div> 
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">SATURACIÓN</br>[% O2]:</h6>
                                        <input type="number" min="0" max="100" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 100) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="% de oxígeno"
                                            name="saturacion" value="" required> <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0% a 100%</div> 
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">PRESIÓN ARTERIAL</br>[mmHg]:</h6>
                                        <input type="number" min="0" max="300" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 300) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="Sistólica"             
                                            name="presion_arterial"  placeholder="Sistólica" value="" required> <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 300 (Sistólica)</div> 
                                        </br>
                                        <input type="number" min="0" max="200" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 200) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="Diastólica"             
                                            name="presion_arterial_d" placeholder="Diastólica" value="" required> <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 200 (Diastólica)</div> 
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">DIAGNÓSTICOS DE INGRESO </h6>
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
                                <h6 class="m-0 font-weight-bold text-primary">DIAGNÓSTICOS DE EGRESO SEGÚN CIE - 10</h6>
                            </div>
                            <div class="card-body">
                                
                                <div class="form-group row">                               
                                    <div class="col-sm-6">
                                    <textarea class="form-control" rows="3" name="diagnostico_egreso[0]" id="diagnostico_egreso[0]" placeholder="Diagnóstico Específico si corresponde escriba o utilice el botón de dictado de voz"></textarea> <button type="button" class="btn-mic" onclick="iniciarDictado('diagnostico_egreso[0]')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>    
                                    </div>
                                    <div class="col-sm-6"> 
                                         <h6 class="m-0 font-weight-bold text-primary">CIE - 10</h6>
                                        <input type="text" class="form-control buscador-cie-inteligente" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_0" autocomplete="off"> 
                                        <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 95%; max-height: 200px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

                                        <select name="idpatologia[0]" id="idpatologia_0" class="form-control" required style="display: none;"> <option value="">-SELECCIONE-</option>
                                        <?php
                                        $numero=1;
                                        $sql1 = "SELECT idpatologia, patologia, cie FROM patologia WHERE cie NOT LIKE '%Z%' ORDER BY patologia";
                                        $result1 = mysqli_query($link,$sql1);
                                        if ($row1 = mysqli_fetch_array($result1)){
                                        mysqli_field_seek($result1,0);
                                        while ($field1 = mysqli_fetch_field($result1)){
                                        } do {
                                        echo "<option value=".$row1[0].">".$row1[1]." - ".$row1[2]."</option>";
                                        $numero=$numero+1;
                                        } while ($row1 = mysqli_fetch_array($result1));
                                        } else {
                                        echo "No se encontraron resultados!";
                                        }
                                        ?>
                                        </select>
                                        <div class="invalid-feedback" style="margin-top: 5px;">Debe seleccionar un diagnóstico CIE-10.</div> 
                                    </div>
                                </div>

                                <div class="form-group row">                               
                                    <div class="col-sm-6">
                                    <textarea class="form-control" rows="3" name="diagnostico_egreso[1]" id="diagnostico_egreso[1]" placeholder="Diagnóstico Específico si corresponde escriba o utilice el botón de dictado de voz"></textarea> <button type="button" class="btn-mic" onclick="iniciarDictado('diagnostico_egreso[1]')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>   
                                    </div>
                                    <div class="col-sm-6"> 
                                        <h6 class="m-0 font-weight-bold text-primary">CIE - 10</h6>
                                        <input type="text" class="form-control buscador-cie-inteligente" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_1" autocomplete="off"> 
                                        <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 95%; max-height: 200px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

                                        <select name="idpatologia[1]" id="idpatologia_1" class="form-control" style="display: none;"> <option value="">-SELECCIONE-</option>
                                        <?php
                                        $numero=1;
                                        $sql1 = "SELECT idpatologia, patologia, cie FROM patologia WHERE cie NOT LIKE '%Z%' ORDER BY patologia";
                                        $result1 = mysqli_query($link,$sql1);
                                        if ($row1 = mysqli_fetch_array($result1)){
                                        mysqli_field_seek($result1,0);
                                        while ($field1 = mysqli_fetch_field($result1)){
                                        } do {
                                        echo "<option value=".$row1[0].">".$row1[1]." - ".$row1[2]."</option>";
                                        $numero=$numero+1;
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
                                    <textarea class="form-control" rows="3" name="diagnostico_egreso[2]" id="diagnostico_egreso[2]" placeholder="Diagnóstico Específico si corresponde escriba o utilice el botón de dictado de voz"></textarea> <button type="button" class="btn-mic" onclick="iniciarDictado('diagnostico_egreso[2]')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>      
                                    </div>
                                    <div class="col-sm-6"> 
                                        <h6 class="m-0 font-weight-bold text-primary">CIE - 10</h6>
                                        <input type="text" class="form-control buscador-cie-inteligente" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_2" autocomplete="off"> 
                                        <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 95%; max-height: 200px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

                                        <select name="idpatologia[2]" id="idpatologia_2" class="form-control" style="display: none;"> <option value="">-SELECCIONE-</option>
                                        <?php
                                        $numero=1;
                                        $sql1 = "SELECT idpatologia, patologia, cie FROM patologia WHERE cie NOT LIKE '%Z%' ORDER BY patologia";
                                        $result1 = mysqli_query($link,$sql1);
                                        if ($row1 = mysqli_fetch_array($result1)){
                                        mysqli_field_seek($result1,0);
                                        while ($field1 = mysqli_fetch_field($result1)){
                                        } do {
                                        echo "<option value=".$row1[0].">".$row1[1]." - ".$row1[2]."</option>";
                                        $numero=$numero+1;
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
                                <h6 class="m-0 font-weight-bold text-primary">EVOLUCIÓN, COMPLICACIONES</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-12"> <!-- Modificado la seccion-->
                                    <textarea class="form-control" rows="3" name="evolucion_complicacion" id="evolucion_complicacion" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
                                    <div class="invalid-feedback" style="margin-top: 5px;">Debe escribir la evolución y/o complicaciones.</div> <button type="button" class="btn-mic" onclick="iniciarDictado('evolucion_complicacion')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>      
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">EXÁMENES COMPLEMENTARIO DE DIAGNÓSTICO</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">  <!-- Modificado la seccion-->                             
                                    <div class="col-sm-12">
                                    <textarea class="form-control" rows="3" name="examenes_complementarios_egreso" id="examenes_complementarios_egreso" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
                                    <div class="invalid-feedback" style="margin-top: 5px;">Debe especificar los exámenes complementarios.</div> <button type="button" class="btn-mic" onclick="iniciarDictado('examenes_complementarios_egreso')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>   
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">OTROS EXÁMENES O INTERCONSULTAS</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row"> <!-- Modificado la seccion-->                              
                                    <div class="col-sm-12">
                                    <textarea class="form-control" rows="3" name="otros_examenes" id="otros_examenes" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
                                    <div class="invalid-feedback" style="margin-top: 5px;">Debe especificar si hay otros exámenes o interconsultas.</div> <button type="button" class="btn-mic" onclick="iniciarDictado('otros_examenes')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>   
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">TRATAMIENTOS REALIZADOS</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-12">
                                    <textarea class="form-control" rows="3" name="tratamientos_realizados" id="tratamientos_realizados" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea> <!-- Modificado, asegurando que tiene required -->
                                    <div class="invalid-feedback" style="margin-top: 5px;">Debe detallar los tratamientos realizados. Este campo es obligatorio.</div> <!-- Modificado, alerta agregada -->
                                    <button type="button" class="btn-mic" onclick="iniciarDictado('tratamientos_realizados')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>   
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">RECOMENDACIONES PARA EL PACIENTE</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row"> <!-- Modificado la seccion-->                              
                                    <div class="col-sm-12">
                                    <textarea class="form-control" rows="3" name="recomendaciones_paciente" id="recomendaciones_paciente" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
                                    <div class="invalid-feedback" style="margin-top: 5px;">Debe escribir las recomendaciones para el paciente.</div> <button type="button" class="btn-mic" onclick="iniciarDictado('recomendaciones_paciente')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>   
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">OTROS ANEXOS O ESTUDIOS PENDIENTES</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row"> <!-- Modificado la seccion-->                              
                                    <div class="col-sm-12">
                                    <textarea class="form-control" rows="3" name="otros_anexos" id="otros_anexos" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
                                    <div class="invalid-feedback" style="margin-top: 5px;">Debe indicar si hay otros anexos o estudios pendientes.</div> <button type="button" class="btn-mic" onclick="iniciarDictado('otros_anexos')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>   
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">OBSERVACIONES / RECOMENDACIONES A LA CONTARREFERENCIA</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">  <!-- Modificado la seccion-->                             
                                    <div class="col-sm-12">
                                    <textarea class="form-control" rows="3" name="observaciones_recomendaciones" id="observaciones_recomendaciones" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
                                    <div class="invalid-feedback" style="margin-top: 5px;">Debe escribir las observaciones o recomendaciones.</div> <button type="button" class="btn-mic" onclick="iniciarDictado('observaciones_recomendaciones')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>   
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">ESTABLECIMIENTO DE SALUD AL QUE SE REALIZA LA CONTRAREFERENCIA</h6>
                            </div>
                                <?php
                                $sql_est =" SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, nivel_establecimiento.nivel_establecimiento, tipo_establecimiento.tipo_establecimiento,";
                                $sql_est.=" subsector_salud.subsector_salud, municipios.municipio, departamento.departamento FROM establecimiento_salud, subsector_salud, nivel_establecimiento, tipo_establecimiento, departamento, municipios ";
                                $sql_est.=" WHERE establecimiento_salud.idsubsector_salud=subsector_salud.idsubsector_salud AND establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento AND establecimiento_salud.iddepartamento=departamento.iddepartamento ";
                                $sql_est.=" AND establecimiento_salud.idmunicipio=municipios.idmunicipio  AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento AND establecimiento_salud.idestablecimiento_salud='$row_ref[4]'";
                                $result_est = mysqli_query($link,$sql_est);
                                $row_est = mysqli_fetch_array($result_est);
                                ?>
                                <input type="hidden" name="idestablecimiento_destino" value="<?php echo $row_ref[4];?>">
                            <div class="card-body">
                                <div class="form-group row">   
                                    <div class="col-sm-4">  
                                        <h6 class="text-primary">ESTABLECIMIENTO DE SALUD:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row_est[1];?> "             
                                        name="establecimiento_salud" disabled > 
                                    </div>  
                                    <div class="col-sm-4">  
                                        <h6 class="text-primary">MUNICIPIO:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row_est[5];?>"             
                                        name="municipio" disabled > 
                                    </div> 
                                    <div class="col-sm-4">  
                                        <h6 class="text-primary">NIVEL DEL ESTABLECIMIENTO:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row_est[2];?>"             
                                        name="nivel_establecimiento" disabled > 
                                    </div>  
                                </div> 
                                <div class="form-group row">   
                                    <div class="col-sm-3">  
                                        <h6 class="text-primary">TIPO DE ESTABLECIMIENTO:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row_est[3];?>"             
                                        name="tipo_establecimiento" disabled > 
                                    </div>  
                                    <div class="col-sm-3">  
                                        <h6 class="text-primary">RED DE SALUD:</h6>
                                        <input type="text" class="form-control" value="<?php 
                                        $sql_rs =" SELECT red_salud FROM red_salud WHERE idred_salud='$row_ref[2]' ";
                                        $result_rs = mysqli_query($link,$sql_rs);
                                        $row_rs = mysqli_fetch_array($result_rs);
                                        echo $row_rs[0];?>"  name="establecimiento_salud" disabled > 
                                    </div> 
                                    <div class="col-sm-3">  
                                        <h6 class="text-primary">SE CONTACTO AL ESTABLECIMIENTO:</h6>
                                            SI <input type="radio" name="contacto_eess_cref" value="SI" >  
                                            NO <input type="radio" name="contacto_eess_cref" value="NO" checked >  
                                    </div> 
                                    <div class="col-sm-3"></br>  
                                        <h6 class="text-primary">POR TELESALUD:</h6>
                                        <input type="checkbox" name="por_telesalud" value="SI">
                                    </div>   
                                </div> 
                                <hr>
                                <div class="form-group row"> <!-- Modificado toda la seccion-->  
                                    <div class="col-sm-6">  
                                        <h6 class="text-primary">CONTACTO DEL ESTABLECIMIENTO DE SALUD QUE RECIBE LA CONTRAREFERENCIA:</h6>  <!-- Modificado, se corrige recibe-->
                                        <input type="text" class="form-control" value=""             
                                        name="contacto_contraref" required > 
                                        <div class="invalid-feedback" style="margin-top: 5px;">Debe indicar el contacto del establecimiento.</div> </div> 
                                    <div class="col-sm-6"> </br> 
                                        <h6 class="text-primary">NOMBRE DEL ACOMPAÑANTE, FAMILIAR Y OTROS :</h6>
                                        <input type="text" class="form-control" value=""             
                                        name="nombre_acompanante_cref" required > 
                                        <div class="invalid-feedback" style="margin-top: 5px;">Debe indicar el nombre del acompañante.</div> </div> 
                                </div> 

                               
                            </div>
                        </div>

                          
                    </div>

                            <div class="text-center">   
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#examplemodal_f">
                                        REGISTRAR CONTRAREFERENCIA
                                        </button>  
                                    </div>                              
                                </div>                            
                            </div>

                            <!-- modal de confirmacion de envio de datos-->
                            <div class="modal fade" id="examplemodal_f" tabindex="-1" role="dialog" aria-labelledby="examplemodal_fLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="examplemodal_fLabel">REGISTRAR CONTRAREFERENCIA</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                                
                                                Esta seguro de Registrar la CONTRAREFERENCIA?
                                                posteriormente no se podran realizar cambios.

                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                            <button type="button" id="btn-confirmar-registro" class="btn btn-primary pull-center">CONFIRMAR REGISTRO</button> ``` <!-- Modificado -->    
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

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                
                // 1. DIBUJO AUTOMÁTICO DE ASTERISCOS EN CAMPOS OBLIGATORIOS
                var camposObligatorios = document.querySelectorAll('input[required], select[required], textarea[required]');
                camposObligatorios.forEach(function(campo) {
                    var titulo = null;
                    
                    // Estrategia A: Buscar título en el contenedor directo (ej. signos vitales o inputs pequeños)
                    var contenedor = campo.closest('[class*="col-sm-"]');
                    if (contenedor) {
                        titulo = contenedor.querySelector('h6');
                    }
                    
                    // Estrategia B: Si no hay título abajo, buscar en la cabecera de la Tarjeta (ej. Textareas grandes)
                    if (!titulo) {
                        var tarjeta = campo.closest('.card');
                        if (tarjeta) {
                            titulo = tarjeta.querySelector('.card-header h6');
                        }
                    }

                    // Si encontramos el título y no tiene el asterisco, lo dibujamos majestuosamente
                    if (titulo && !titulo.hasAttribute('data-asterisco')) {
                        titulo.innerHTML += ' <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span>';
                        titulo.setAttribute('data-asterisco', 'true');
                    }
                });

                // 2. VALIDADOR ESTRICTO Y FUERZA BRUTA (Cierra modal, scroll y marca rojo)
                var form = document.querySelector('form[name="GUARDA_CONTRAREF"]');
                var btnConfirmar = document.getElementById('btn-confirmar-registro');
                
                if (form && btnConfirmar) {
                    btnConfirmar.addEventListener('click', function(e) {
                        e.preventDefault(); 
                        
                        var hayErrores = false;
                        var primerInvalido = null;
                        
                        // Limpiamos alertas previas de toda la pantalla
                        form.querySelectorAll('.is-invalid').forEach(function(el) {
                            el.classList.remove('is-invalid');
                            el.style.border = ''; 
                        });
                        form.querySelectorAll('.invalid-feedback').forEach(function(el) {
                            el.style.display = ''; 
                        });
                        
                        // REVISIÓN MANUAL CAMPO POR CAMPO
                        var elementosObligatorios = form.querySelectorAll('input[required], select[required], textarea[required]');
                        
                        elementosObligatorios.forEach(function(el) {
                            var valor = el.value ? el.value.trim() : '';
                            
                            if (valor === '' || !el.checkValidity()) {
                                hayErrores = true;
                                
                                // 👉 CASO ESPECIAL: Si falla el Select oculto del CIE-10, pintamos el Input Visual
                                if (el.style.display === 'none' && el.id && el.id.includes('idpatologia')) {
                                    var inputVisual = document.querySelector('input[data-target="' + el.id + '"]');
                                    if (inputVisual) {
                                        inputVisual.classList.add('is-invalid');
                                        inputVisual.style.setProperty('border', '2px solid #dc3545', 'important');
                                        
                                        var contenedor = el.parentNode;
                                        var feedback = contenedor.querySelector('.invalid-feedback');
                                        if (feedback) feedback.style.setProperty('display', 'block', 'important');
                                        
                                        if (!primerInvalido) primerInvalido = inputVisual;
                                    }
                                } 
                                // 👉 CASO NORMAL: Campos visibles que no se llenaron
                                else if (el.type !== 'hidden' && el.style.display !== 'none') {
                                    el.classList.add('is-invalid');
                                    el.style.setProperty('border', '2px solid #dc3545', 'important');
                                    
                                    var contenedor = el.parentNode;
                                    var feedback = contenedor ? contenedor.querySelector('.invalid-feedback') : null;
                                    if (feedback) {
                                        feedback.style.setProperty('display', 'block', 'important');
                                    }
                                    
                                    if (!primerInvalido) primerInvalido = el;
                                }
                            }
                        });
                        
                        // ACCIONES FINALES
                        if (hayErrores) {
                            // Cerramos el modal usando múltiples métodos por seguridad
                            try {
                                var btnCancelar = document.querySelector('#examplemodal_f [data-dismiss="modal"]');
                                if (btnCancelar) btnCancelar.click();
                                $('#examplemodal_f').modal('hide'); 
                            } catch(err) {}
                            
                            // Esperamos que desaparezca el cuadro gris y viajamos al error
                            setTimeout(function() {
                                document.body.classList.remove('modal-open');
                                document.body.style.paddingRight = '';
                                
                                if (primerInvalido) {
                                    primerInvalido.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                    try { primerInvalido.focus({ preventScroll: true }); } catch(e) { primerInvalido.focus(); }
                                }
                            }, 400);
                            
                        } else {
                            // TODO ESTÁ PERFECTO: Bloqueamos el boton para evitar doble envío y guardamos
                            btnConfirmar.innerHTML = "GUARDANDO...";
                            btnConfirmar.disabled = true;
                            form.submit(); 
                        }
                    });
                    
                    // EFECTO MAGIA: Borrar el rojo individualmente cuando el médico empieza a escribir
                    ['input', 'change'].forEach(function(evt) {
                        form.addEventListener(evt, function(e) {
                            if (e.target.hasAttribute('required') && e.target.value.trim() !== '') {
                                e.target.classList.remove('is-invalid');
                                e.target.style.border = '';
                                var feedback = e.target.parentNode ? e.target.parentNode.querySelector('.invalid-feedback') : null;
                                if (feedback) feedback.style.display = '';
                            }
                        });
                    });
                }

                // 3. CANDADO DE INTEGRIDAD VISUAL PARA DIAGNÓSTICOS CIE-10 (Solo Egreso)
                var buscadores = document.querySelectorAll('.buscador-cie-inteligente');
                buscadores.forEach(function(input) {
                    var targetId = input.getAttribute('data-target');
                    var selectOriginal = document.getElementById(targetId);
                    var listaFlotante = input.nextElementSibling; 
                    
                    if(!selectOriginal) return;
                    
                    // Obtenemos todas las opciones válidas del select oculto original
                    var opciones = Array.from(selectOriginal.options).filter(opt => opt.value !== "");
                    
                    // Escuchamos lo que el médico escribe
                    input.addEventListener('input', function() {
                        if (this.readOnly) return; 
                        
                        // EFECTO MAGIA: Borrar rojo si empiezan a buscar un diagnóstico
                        this.classList.remove('is-invalid');
                        this.style.border = '';
                        var fb = selectOriginal.parentNode.querySelector('.invalid-feedback');
                        if (fb) fb.style.display = '';

                        var term = this.value.toLowerCase().trim();
                        listaFlotante.innerHTML = ''; 
                        
                        if (term === '') {
                            listaFlotante.style.display = 'none';
                            selectOriginal.value = ''; 
                            return;
                        }
                        
                        // Buscamos coincidencias de texto
                        var coincidencias = opciones.filter(opt => opt.text.toLowerCase().includes(term));
                        
                        if (coincidencias.length > 0) {
                            listaFlotante.style.display = 'block'; 
                            // Mostramos máximo 100 resultados para no colapsar la pantalla
                            coincidencias.slice(0, 100).forEach(function(opt) { 
                                var item = document.createElement('div');
                                item.textContent = opt.text;
                                item.style.padding = '8px 12px';
                                item.style.cursor = 'pointer';
                                item.style.borderBottom = '1px solid #eaecf4';
                                item.style.fontSize = '0.9rem';
                                item.style.color = '#5a5c69';
                                
                                // Efecto de iluminación al pasar el mouse (Hover)
                                item.addEventListener('mouseenter', function() { this.style.backgroundColor = '#eaecf4'; this.style.color = '#2e59d9'; });
                                item.addEventListener('mouseleave', function() { this.style.backgroundColor = 'transparent'; this.style.color = '#5a5c69'; });
                                
                                // Al hacer clic en una enfermedad
                                item.addEventListener('mousedown', function(e) {
                                    e.preventDefault(); 
                                    input.value = opt.text; // Mostramos el texto en el input visual
                                    selectOriginal.value = opt.value; // Guardamos el código real en el select oculto
                                    listaFlotante.style.display = 'none'; 

                                    // Aplicamos el Candado Visual (Color azul y bloqueado)
                                    input.readOnly = true;
                                    input.style.backgroundColor = '#eaecf4';
                                    input.style.color = '#2e59d9';
                                    input.style.cursor = 'not-allowed';
                                    input.title = "Doble clic o presione Borrar (Backspace) para cambiar el diagnóstico";
                                });
                                listaFlotante.appendChild(item);
                            });
                        } else {
                            listaFlotante.style.display = 'none';
                        }
                    });

                    // Función maestra para quitar el candado si se equivocaron
                    function desbloquearCIE() {
                        if (input.readOnly) {
                            input.readOnly = false;
                            input.value = '';
                            selectOriginal.value = '';
                            input.style.backgroundColor = '';
                            input.style.color = '';
                            input.style.cursor = 'text';
                            input.removeAttribute('title');
                            input.focus();
                        }
                    }

                    // Permitir borrar con tecla Backspace o Suprimir
                    input.addEventListener('keydown', function(e) {
                        if (input.readOnly) {
                            if (e.key === 'Backspace' || e.key === 'Delete') { 
                                e.preventDefault(); 
                                desbloquearCIE(); 
                            } else if (e.key !== 'Tab') { 
                                e.preventDefault(); 
                            }
                        }
                    });

                    // Permitir borrar con doble clic del mouse
                    input.addEventListener('dblclick', desbloquearCIE);

                    // Si el médico da clic afuera sin elegir nada, limpiamos la basura
                    input.addEventListener('blur', function() {
                        setTimeout(function() {
                            listaFlotante.style.display = 'none';
                            if (!input.readOnly) { 
                                input.value = ''; 
                                selectOriginal.value = ''; 
                            }
                        }, 200);
                    });
                });
            });
        </script>
</body>
</html>