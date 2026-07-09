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
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
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
<style>
        /* ================= ESTILOS MÓDULO MULTIMEDIA SAFCI ================= */
        .dropzone-safci {
            border: 2px dashed #36b9cc;
            border-radius: 10px;
            background-color: #f8f9fc;
            padding: 20px 10px;
            text-align: center;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
            position: relative;
        }
        .dropzone-safci:hover {
            background-color: #eaecf4;
            border-color: #2c9faf;
        }
        .dropzone-icon {
            font-size: 2.5rem;
            color: #b7b9cc;
            margin-bottom: 5px;
            transition: all 0.3s;
        }
        .dropzone-safci:hover .dropzone-icon {
            color: #36b9cc;
            transform: scale(1.1);
        }
        .preview-grid {
            display: flex; flex-wrap: wrap; gap: 15px; margin-top: 15px;
        }
        .preview-item {
            position: relative; width: 120px; height: 120px;
            border-radius: 8px; overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: 1px solid #e3e6f0;
        }
        .preview-item img, .preview-item canvas {
            width: 100%; height: 100%; object-fit: cover;
        }
        .preview-item .file-name {
            position: absolute; bottom: 0; left: 0; right: 0;
            background: rgba(0,0,0,0.7); color: white; font-size: 0.6rem;
            padding: 3px; text-align: center; white-space: nowrap;
            overflow: hidden; text-overflow: ellipsis;
        }
        .btn-remove {
            position: absolute; top: 5px; right: 5px;
            background-color: rgba(231, 74, 59, 0.9); color: white;
            border: none; border-radius: 50%; width: 24px; height: 24px;
            font-size: 12px; cursor: pointer; display: flex;
            align-items: center; justify-content: center; transition: background 0.2s;
        }
        .btn-remove:hover { background-color: #e74a3b; transform: scale(1.1); }
        /* =================================================================== */
    </style>
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

                     <form name="GUARDA_CONTRAREFERENCIA" action="guarda_contrareferencia.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate> <!-- Modificado -->

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
                                <h6 class="text-primary"></h6>
                                </div>
                                </div>  

                                <!-------- DATOS PERSONALES DEL INTEGRANTE FAMILIAR (End) --------->  

                              <!-------- DATOS PERSONALES DEL INTEGRANTE FAMILIAR (End) --------->  
                                <?php
                                $sql_cf =" SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.codigo, integrante_cf.idintegrante_cf FROM carpeta_familiar, integrante_cf ";
                                $sql_cf.=" WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND integrante_cf.idnombre='$idnombre_integrante_ss' ";
                                $result_cf=mysqli_query($link,$sql_cf);
                                if ($row_cf=mysqli_fetch_array($result_cf)) { ?>

                                <?php
                                $sql4 =" SELECT integrante_datos_cf.idintegrante_datos_cf, estado_civil.estado_civil, nivel_instruccion.nivel_instruccion, profesion.profesion, integrante_datos_cf.ocupacion, contribuye_cf.contribuye_cf ";
                                $sql4.=" FROM integrante_datos_cf, estado_civil, nivel_instruccion, profesion, contribuye_cf WHERE integrante_datos_cf.idestado_civil=estado_civil.idestado_civil ";
                                $sql4.=" AND integrante_datos_cf.idnivel_instruccion=nivel_instruccion.idnivel_instruccion AND integrante_datos_cf.idprofesion=profesion.idprofesion ";
                                $sql4.=" AND integrante_datos_cf.idcontribuye_cf=contribuye_cf.idcontribuye_cf AND integrante_datos_cf.idintegrante_cf='$row_cf[2]' ORDER BY integrante_datos_cf.idintegrante_datos_cf DESC LIMIT 1 ";
                                $result4 = mysqli_query($link,$sql4);
                                if ($row4 = mysqli_fetch_array($result4)){
                                mysqli_field_seek($result4,0);
                                while ($field4 = mysqli_fetch_field($result4)){
                                } do { 
                                ?>
                               <div class="form-group row">                               
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">ESTADO CIVIL:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row4[1];?>" 
                                        name="" disabled>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">NIVEL DE INSTRUCCIÓN:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row4[2];?>"
                                        name="" disabled>                
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">PROFESIÓN:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row4[3];?>"             
                                        name="" disabled >                
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">OCUPACIÓN:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row4[4];?>" 
                                        name="" disabled>                
                                    </div>

                                </div>
                                <div class="form-group row"> 
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">CONTRIBUYE AL SUSTENTO FAMILIAR:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row4[5];?>" 
                                        name="" disabled>                
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">HISTORIA CLÍNICA:</h6>
                                        <a class="btn btn-primary btn-icon-split" href="../produccion_servicios/imprime_historia_clinica.php?idcarpeta_familiar=<?php echo $row_cf[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1000,height=1000,top=50, left=400, scrollbars=YES'); return false;">                        
                                        <span class="icon text-white-50">
                                            <i class="fas fa-book"></i>
                                        </span>
                                        <span class="text">HISTORIA CLÍNICA DIGITAL</span>
                                        </a>                                      
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-warning">VER CARPETA FAMILIAR:</h6>
                                    <a class="btn btn-warning btn-icon-split" href="../carpetas_familiares/imprime_carpeta_familiar.php?idcarpeta_familiar=<?php echo $row_cf[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1400,height=800,top=50, left=200, scrollbars=YES'); return false;">              
                                    <span class="icon text-white-50">
                                        <i class="fas fa-file"></i>
                                    </span>
                                    <span class="text"><?php echo $row_cf[1];?></span></a> 
                                    </div>
                                </div> 
                                <?php
                                }
                                while ($row4 = mysqli_fetch_array($result4));
                                } else {
                                }
                                ?>

                                <?php }  else { ?>

                                <div class="form-group row"> 
                                    <div class="col-sm-12"> 
                                        <h6 class="text-primary">HISTORIA CLÍNICA:</h6>
                                        <a class="btn btn-primary btn-icon-split" href="../produccion_servicios/imprime_historia_clinica_ncref.php" target="_blank" onClick="window.open(this.href, this.target, 'width=1000,height=1000,top=50, left=400, scrollbars=YES'); return false;">                        
                                        <span class="icon text-white-50">
                                            <i class="fas fa-book"></i>
                                        </span>
                                        <span class="text">HISTORIA CLÍNICA DIGITAL</span>
                                        </a> 
                                    </div>
                                </div> 

                                <?php } ?> 
                                                           
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

                            <?php
                            $sql_se =" SELECT idsigno_vital_psafci, talla, peso, temperatura, frec_cardiaca, frec_respiratoria, presion_arterial, presion_arterial_d, saturacion, glascow, alergia, ";
                            $sql_se.=" descripcion_alergia, imc FROM signo_vital_psafci WHERE idnombre ='$row_ref[7]' ORDER BY idsigno_vital_psafci DESC LIMIT 1 ";
                            $result_se = mysqli_query($link,$sql_se);
                            $row_se = mysqli_fetch_array($result_se);
                            ?> 

                        <div class="card shadow mb-4"> <!-- Modificado toda la seccion -->
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">DATOS CLÍNICOS DE ALTA </h6>
                                <h8 class="text-warning">(Se muestran los signos vitales de Referencia, modificar solo si existe variacion al egreso)</h8>
                            </div>
                            <div class="card-body">                             
                                <div class="form-group row">  
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">DÍAS DE INTERNACIÓN </br>[dias]:</h6>
                                        <input type="number" min="0" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value < 0) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" class="form-control"
                                            name="dias_internacion_ref" value="" required> <div class="invalid-feedback" style="margin-top: 5px;">Indique los días de internación.</div> 
                                    </div>  
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">TALLA </br>[Centímetros]:</h6>
                                        <input type="number" min="20" max="280" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 280) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 20) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En Centímetros"
                                            name="talla" value="<?php echo $row_se[1];?>" required> <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 20 a 280 cm</div> 
                                    </div>                             
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">PESO </br>[kg]:</h6>
                                        <input type="number" step="any" min="0.2" max="650" onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();" oninput="if(this.value > 650) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0.2) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En kilogramos"              
                                            name="peso" value="<?php echo $row_se[2];?>" required> <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0.2 a 650 kg</div> 
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">TEMPERATURA</br>[°C]:</h6>
                                        <input type="number" step="any" min="10" max="47" onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();" oninput="if(this.value > 47) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 10) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En grados celsius"
                                            name="temperatura" value="<?php echo $row_se[3];?>" required> <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 10°C a 47°C</div> 
                                    </div>

                                </div>
                            
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FRECUENCIA CARDIACA </br>[lpm]:</h6>
                                        <input type="number" min="0" max="350" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 350) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" 
                                            name="frec_cardiaca" value="<?php echo $row_se[4];?>" required> <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 350 lpm</div> 
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                                        <input type="number" min="0" max="80" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 80) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" 
                                            name="frec_respiratoria" value="<?php echo $row_se[5];?>" required> <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 80 cpm</div> 
                                    </div> 
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">SATURACIÓN</br>[% O2]:</h6>
                                        <input type="number" min="0" max="100" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 100) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control"
                                            name="saturacion" value="<?php echo $row_se[8];?>" required> <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0% a 100%</div> 
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">PRESIÓN ARTERIAL</br>[mmHg]:</h6>
                                        <input type="number" min="0" max="300" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 300) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control"              
                                            name="presion_arterial" value="<?php echo $row_se[6];?>"  placeholder="Sistólica" value="" required> <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 300 (Sistólica)</div> 
                                        </br>
                                        <input type="number" min="0" max="200" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 200) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control"              
                                            name="presion_arterial_d" value="<?php echo $row_se[7];?>" placeholder="Diastólica" value="" required> <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 200 (Diastólica)</div> 
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
                                        $sqlv = " SELECT idpatologia, patologia, cie FROM patologia ORDER BY patologia ";
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


<!-------------- ANTECDENTES OBSTETRICOS - BEGIN --------------->

            <?php
            $sql_h =" SELECT idhistoria_perinatal, fecha_registro FROM historia_perinatal WHERE idnombre='$idnombre_integrante_ss' ";
            $result_h = mysqli_query($link,$sql_h);
            if ($row_h = mysqli_fetch_array($result_h)){
            mysqli_field_seek($result_h,0);
            while ($field_h = mysqli_fetch_field($result_h)){
            } do { 
            ?>
                    <?php
                        $sql_g = " SELECT idgestacion, fecha_fum, fecha_fpp, controles_prenatales FROM gestacion WHERE idhistoria_perinatal='$row_h[0]' ORDER BY idgestacion DESC LIMIT 1 ";
                        $result_g = mysqli_query($link,$sql_g);
                        $row_g = mysqli_fetch_array($result_g);

                        $sql_a =" SELECT idantecedente_obstetrico, gestaciones, partos, abortos, cesareas  FROM antecedente_obstetrico WHERE idhistoria_perinatal='$row_h[0]' ";
                        $result_a = mysqli_query($link,$sql_a);
                        $row_a = mysqli_fetch_array($result_a);

                        ?> 

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">2.1.- ANTECEDENTES GINECO OBTETRICOS</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">  
                            <div class="col-sm-2">
                            <h6 class="text-primary">F.U.M. </br>[fecha]</h6>
                                <input type="date" class="form-control" value="<?php echo $row_g[1]?>"
                                    name="fecha_fum" disabled>                
                            </div>                             
                            <div class="col-sm-2">
                            <h6 class="text-primary">G</br>[Gestaciones]:</h6>
                                <input type="number" class="form-control" placeholder="Nº Gestaciones" value="<?php echo $row_a[1]?>"         
                                    name="gestaciones" value="" disabled>                
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-primary">P</br>[Partos]:</h6>
                                <input type="number" class="form-control" placeholder="Nº Partos" value="<?php echo $row_a[2]?>"
                                    name="partos" placeholder="" value="" disabled>                
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-primary">A</br>[Abortos]:</h6>
                                <input type="number" class="form-control" placeholder="Nº Abortos" value="<?php echo $row_a[3]?>"
                                    name="abortos" value="" disabled>                
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-primary">C</br>[Cesáreas]:</h6>
                                <input type="number" class="form-control" placeholder="Nº Cesáreas" value="<?php echo $row_a[4]?>"
                                    name="cesareas" placeholder="" value="0" disabled>                
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-primary">F.P.P.</br>[fecha]</h6>
                                <input type="date" class="form-control" value="<?php echo $row_g[2]?>"
                                    name="fecha_fpp" disabled>                
                            </div>
                        </div>

                        <?php
                            $sql_p =" SELECT idparto, hora_rpm, maduracion_pulmonar, idtipo_parto, fecha_parto, hora_parto FROM parto WHERE idnombre='$idnombre_integrante_ss' AND idgestacion='$row_g[0]' ORDER BY idparto DESC LIMIT 1  ";
                            $result_p = mysqli_query($link,$sql_p);
                            if ($row_p = mysqli_fetch_array($result_p)){
                            mysqli_field_seek($result_p,0);
                            while ($field_p = mysqli_fetch_field($result_p)){
                            } do { 

                                $sql_ca =" SELECT idconsulta_antenatal, frecuencia_fcf, edad_gestacional FROM consulta_antenatal WHERE idnombre='$idnombre_integrante_ss' AND idgestacion='$row_g[0]' ORDER BY idconsulta_antenatal DESC LIMIT 1 ";
                                $result_ca = mysqli_query($link,$sql_ca);
                                $row_ca = mysqli_fetch_array($result_ca);

                        ?>

                        <div class="form-group row">
                            <div class="col-sm-12">
                            <h6 class="text-info">YA SE HAN REGISTRADO LOS DATOS DEL PARTO ANTES DE LA REFERENCIA</h6> 
                            </div> 
                        </div> 
                    
                        <div class="form-group row">
                            <div class="col-sm-2">
                            <h6 class="text-primary">R.P.M. </br>[hrs.]:</h6> 
                                <input type="time" class="form-control" value="<?php echo $row_p[1]?>"
                                    name="hora_rpm" value="0" disabled>                
                            </div> 
                            <div class="col-sm-2">
                            <h6 class="text-primary">F.C.F.</h6>
                                <input type="number" class="form-control"              
                                    name="frecuencia_fcf"  placeholder="" value="<?php echo $row_ca[1]?>" disabled>               
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-primary">Nº CONTROLES</br>PRENATALES</h6>
                                <input type="number" class="form-control"              
                                    name="controles_prenatales"  placeholder="" value="<?php echo $row_g[3]?>" disabled>               
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-primary">MADURACIÓN PULMONAR:</h6>
                            SI <input type="radio" name="maduracion_pulmonar" value="SI" <?php if ($row_p[2] =='NO') { echo 'checked'; } ?> disabled> </br> 
                            NO <input type="radio" name="maduracion_pulmonar" value="NO" <?php if ($row_p[2] =='SI') { echo 'checked'; } ?> disabled> 
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-primary">PARTO:</h6>
                                <input type="text" name="parto" value="SI" class="form-control" disabled>
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-primary"></h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">           
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">2.2.- PARTO</h6>
                    </div>
                    <div class="card-body">                    
                            <div class="form-group row">  
                            <div class="col-sm-2">
                            <h6 class="text-primary">PARTO</br></h6>
                            EUTOCICO <input type="radio" name="idtipo_parto" value="1" <?php if ($row_p[3] =='1') { echo 'checked'; } ?> disabled> </br> 
                            CESÁREA <input type="radio" name="idtipo_parto" value="2" <?php if ($row_p[3] =='2') { echo 'checked'; } ?> disabled>               
                            </div>                             
                            <div class="col-sm-2">
                            <h6 class="text-primary">FECHA DEL PARTO</br>[Fecha]:</h6>
                                <input type="date" class="form-control" value="<?php echo $row_p[4]?>"             
                                    name="fecha_parto"  disabled>                
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-primary">HORA DEL PARTO</br>[hrs]:</h6>
                                <input type="time" class="form-control" value="<?php echo $row_p[5]?>" 
                                    name="hora_parto" disabled>                
                            </div>
                            <?php
                                $sql_rn =" SELECT idrecien_nacido, liq_amniotico, peso_rn, talla_rn, pc_rn, pt_rn, apgar_uno, apgar_cinco, indice_choque, criterio_sofa, edad_gestacional, idgenero FROM recien_nacido WHERE idgestacion='$row_g[0]' ORDER BY idrecien_nacido DESC LIMIT 1 ";
                                $result_rn = mysqli_query($link,$sql_rn);
                                $row_rn = mysqli_fetch_array($result_rn);
                            ?>
                            <div class="col-sm-2">
                            <h6 class="text-primary">EDAD GESTACIONAL</br>[Semanas]:</h6>
                                <input type="number" class="form-control" value="<?php echo $row_rn[10];?>""
                                    name="edad_gestacional" disabled>                 
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-primary">LÍQUIDO AMNIÓTICO:</br></h6> 
                                <input type="text" name="liq_amniotico" value="<?php echo $row_rn[1];?>" disabled>             
                            </div> 
                            <div class="col-sm-2">
                            <h6 class="text-primary">PESO</br>[gramos]</h6>
                                <input type="number" class="form-control"              
                                    name="peso_rn" value="<?php echo $row_rn[2];?>" disabled>               
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <div class="col-sm-2">
                            <h6 class="text-primary">TALLA</br>[centímetros]</h6>
                                <input type="number" class="form-control"              
                                    name="talla_rn" value="<?php echo $row_rn[3];?>" disabled>               
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-primary">P.C.:</br>[perimetro]</h6>
                                <input type="number" class="form-control"              
                                    name="pc_rn" value="<?php echo $row_rn[4];?>" disabled>  
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-primary">P.T.:</br>[perimetro]</h6>
                                <input type="number" class="form-control"              
                                    name="pt_rn" value="<?php echo $row_rn[5];?>" disabled>  
                            </div>
                            <div class="col-sm-3">
                            <h6 class="text-primary">APGAR:</br>[Primer Minuto]</h6>
                                <input type="number" class="form-control"              
                                    name="apgar_uno" value="<?php echo $row_rn[6];?>" disabled>  
                            </div>
                            <div class="col-sm-3">
                            <h6 class="text-primary">APGAR:</br>[5 minutos]</h6>
                                <input type="number" class="form-control"              
                                    name="apgar_cinco" value="<?php echo $row_rn[7];?>" disabled>  
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-3">
                            <h6 class="text-primary">INDICE DE CHOQUE:</br>[indice]</h6>
                                <input type="number" class="form-control"              
                                    name="indice_choque" value="<?php echo $row_rn[8];?>" disabled>               
                            </div>
                            <div class="col-sm-3">
                            <h6 class="text-primary">CRITERIOS SOFA:</br>[indice]</h6>
                                <input type="number" class="form-control"              
                                    name="criterio_sofa" value="<?php echo $row_rn[9];?>" disabled>  
                            </div>
                            <div class="col-sm-3">
                            <h6 class="text-primary">SEXO </br> RECIÉN NACIDO</h6>
                                <select name="idgenero" id="idgenero" class="form-control" disabled >
                                    <option selected>Seleccione</option>
                                    <?php
                                    $sqlv = " SELECT idgenero, genero FROM genero ";
                                    $resultv = mysqli_query($link,$sqlv);
                                    if ($rowv = mysqli_fetch_array($resultv)){
                                    mysqli_field_seek($resultv,0);
                                    while ($fieldv = mysqli_fetch_field($resultv)){
                                    } do {
                                    ?>
                                    <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_rn[11]) echo "selected";?> ><?php echo $rowv[1];?></option>
                                    <?php
                                    } while ($rowv = mysqli_fetch_array($resultv));
                                    } else {
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                            <h6 class="text-primary">PESO/EDAD GESTACIONAL</h6>
                                <select name="idpeso_eg" id="idpeso_eg" class="form-control" disabled >
                                    <option selected>Seleccione</option>
                                    <?php
                                    $sqlv = " SELECT idpeso_eg, peso_eg FROM peso_eg ";
                                    $resultv = mysqli_query($link,$sqlv);
                                    if ($rowv = mysqli_fetch_array($resultv)){
                                    mysqli_field_seek($resultv,0);
                                    while ($fieldv = mysqli_fetch_field($resultv)){
                                    } do {
                                    ?>
                                    <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_rn[11]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                }
                while ($row_p = mysqli_fetch_array($result_p));
                } else {  ?>

                    </div>
                </div>

               <?php } ?>

            <?php
            }
            while ($row_h = mysqli_fetch_array($result_h));
            } else { } 
            ?>

<!-------------- ANTECDENTES OBSTETRICOS - END --------------->

<!-------------- ARCHIVOS ADJUNTOS CONTRAREFERENCIA - BEGIN --------------->

   <?php 
                        $archivo_referencia_mostrar = "";
                        $sql_adj_mostrar = "SELECT file_ref FROM referencia_hc WHERE idreferencia_hc = '$idreferencia_hc_ss'";
                        $res_adj_mostrar = mysqli_query($link, $sql_adj_mostrar);
                        if ($res_adj_mostrar && mysqli_num_rows($res_adj_mostrar) > 0) {
                            $row_adj_mostrar = mysqli_fetch_assoc($res_adj_mostrar);
                            $archivo_referencia_mostrar = $row_adj_mostrar['file_ref'];
                        }

                        // Verificamos que el archivo exista en la carpeta física
                        if (!empty($archivo_referencia_mostrar) && file_exists("../files_ref/" . $archivo_referencia_mostrar)) { 
                        ?>
                            <div class="card border-left-success shadow h-100 py-2 mb-4 text-left">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                <i class="fas fa-paperclip"></i> ADJUNTOS DE LA REFERENCIA
                                            </div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                El personal de salud que realizó la referencia adjuntó documentos.
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button class="btn btn-sm btn-outline-success shadow-sm mr-2" type="button" data-toggle="collapse" data-target="#visorMostrar" aria-expanded="false" aria-controls="visorMostrar">
                                                <i class="fas fa-eye"></i> VER / OCULTAR
                                            </button>
                                            <a href="../files_ref/<?php echo $archivo_referencia_mostrar; ?>" target="_blank" class="btn btn-sm btn-success shadow-sm">
                                                <i class="fas fa-expand-arrows-alt"></i> PANTALLA COMPLETA
                                            </a>
                                        </div>
                                    </div>
                                    <div class="collapse mt-3" id="visorMostrar">
                                        <div class="embed-responsive" style="height: 500px; border: 1px solid #d1d3e2; border-radius: 8px; overflow: hidden; background-color: #eaecf4;">
                                            <iframe src="../files_ref/<?php echo $archivo_referencia_mostrar; ?>" style="width: 100%; height: 100%; border: none;" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

<!-------------- ARCHIVOS ADJUNTOS CONTRAREFERENCIA - END --------------->

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
                                        $sql1 = "SELECT idpatologia, patologia, cie FROM patologia ORDER BY patologia";
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
                                        $sql1 = "SELECT idpatologia, patologia, cie FROM patologia ORDER BY patologia";
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
                                        $sql1 = "SELECT idpatologia, patologia, cie FROM patologia ORDER BY patologia";
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
                                            NO <input type="radio" name="contacto_eess_cref" value="NO" >  
                                    </div> 
                                    <div class="col-sm-3"></br>  
                                        <h6 class="text-primary">POR TELESALUD:</h6>
                                        <input type="checkbox" id="check-telesalud" name="por_telesalud" value="SI">
                                    </div>   
                                </div> 

                                <div class="form-group row" id="contenedor-tiempo-telesalud" style="display: none;">
                                
                                    <div class="col-sm-4">
                                        <h6 class="text-primary" id="titulo-tiempo-telesalud">TIEMPO:</h6>
                                        <select name="idtiempo_ts" id="idtiempo_ts_contra" class="form-control" disabled>
                                            <option value="">-SELECCIONE-</option>
                                            <?php
                                            // TU LÓGICA NATIVA INTACTA
                                            $numero_tm=1;
                                            $sql_tm = "SELECT idtiempo_ts, tiempo_ts FROM tiempo_ts ORDER BY tiempo_ts";
                                            $result_tm = mysqli_query($link,$sql_tm);
                                            if ($row_tm = mysqli_fetch_array($result_tm)){
                                            mysqli_field_seek($result_tm,0);
                                            while ($field_tm = mysqli_fetch_field($result_tm)){
                                            } do {
                                            echo "<option value=".$row_tm[0].">".$row_tm[1]."</option>";
                                            $numero_tm=$numero_tm+1;
                                            } while ($row_tm = mysqli_fetch_array($result_tm));
                                            } else { }
                                            ?>
                                        </select>
                                        <div class="invalid-feedback">Obligatorio para Telesalud.</div>
                                    </div>

                                    <div class="col-sm-4">
                                        <h6 class="text-primary" id="titulo-atencion-sitio">ATENCIÓN EN SITIO:</h6>
                                        SI <input type="radio" name="atencion_sitio" id="sitio_si" value="SI" disabled> <br>
                                        NO <input type="radio" name="atencion_sitio" id="sitio_no" value="NO" checked disabled>  
                                    </div>

                                    <div class="col-sm-4">
                                        <h6 class="text-primary" id="titulo-tipo-tele">TIPO DE TELEINTERCONSULTA:</h6>
                                        <select name="idtipo_teleinterconsulta" id="idtipo_teleinterconsulta_contra" class="form-control" disabled>
                                            <option value="">-SELECCIONE-</option>
                                            <option value="1">Telediagnóstico Médico</option>
                                            <option value="2">Telediscusión</option>
                                            <option value="3">Teleemergencia</option>
                                        </select>
                                        <div class="invalid-feedback">Debe seleccionar el tipo.</div>
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

                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-paperclip"></i> EVIDENCIA CLÍNICA Y ARCHIVOS ADJUNTOS (OPCIONAL)</h6>
                                <button type="button" id="btn-previsualizar-pdf" class="btn btn-sm btn-outline-info shadow-sm" data-toggle="collapse" data-target="#visorColapsableFormContra" aria-expanded="false" aria-controls="visorColapsableFormContra" style="display: none;">
                                    <i class="fas fa-eye"></i> VER / OCULTAR PDF
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-12">
                                        <h6 class="text-info mb-3">ARRASTRE O SELECCIONE EPICRISIS, EXÁMENES DE LABORATORIO O RECETAS PARA EL MÉDICO DE ORIGEN:</h6>
                                        
                                        <div id="dropzone_contra" class="dropzone-safci" onclick="document.getElementById('input_archivos_contra').click()">
                                            <i class="fas fa-cloud-upload-alt dropzone-icon"></i>
                                            <h6 class="font-weight-bold text-secondary mb-1">Arrastre sus archivos aquí</h6>
                                            <p class="text-muted small mb-0">o haga clic para examinar el dispositivo</p>
                                            <p class="text-xs text-info mt-1 font-weight-bold mb-0">Formatos permitidos: JPG, JPEG, PNG, PDF</p>
                                            <input type="file" id="input_archivos_contra" multiple accept="image/jpeg, image/png, application/pdf" style="display: none;">
                                        </div>

                                        <div id="preview-gallery-contra" class="preview-grid"></div>

                                        <input type="file" id="pdf_final_oculto_contra" name="archivo_contrareferencia_pdf" style="display: none;">
                                        
                                        <div class="collapse mt-4" id="visorColapsableFormContra">
                                            <div class="embed-responsive" style="height: 500px; border: 1px solid #d1d3e2; border-radius: 8px; overflow: hidden; background-color: #eaecf4;">
                                                <iframe id="visor_pdf_final_contra" src="" style="width: 100%; height: 100%; border: none;" allowfullscreen></iframe>
                                            </div>
                                        </div>
                                    </div>
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
                var camposObligatorios = document.querySelectorAll('input[required]:not([disabled]), select[required]:not([disabled]), textarea[required]:not([disabled])');
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

                // =========================================================================================
                // 1.5. LÓGICA DINÁMICA: MOSTRAR TIEMPO, SITIO Y TIPO TELEINTERCONSULTA
                // =========================================================================================
                var checkTelesalud = document.getElementById('check-telesalud');
                var contenedorTiempo = document.getElementById('contenedor-tiempo-telesalud');
                
                // Elementos nuevos a controlar
                var selectTiempo = document.getElementById('idtiempo_ts_contra');
                var radiosSitio = document.querySelectorAll('input[name="atencion_sitio"]');
                var selectTipoTele = document.getElementById('idtipo_teleinterconsulta_contra');

                if(checkTelesalud && contenedorTiempo && selectTiempo && selectTipoTele) {
                    
                    function eval_telesalud(checkbox) {
                        var tituloTiempo = document.getElementById('titulo-tiempo-telesalud');
                        var tituloSitio = document.getElementById('titulo-atencion-sitio');
                        var tituloTipoTele = document.getElementById('titulo-tipo-tele');

                        if(checkbox.checked) {
                            // Mostrar fila
                            contenedorTiempo.style.display = 'flex';
                            
                            // Habilitar y hacer obligatorios los selects
                            selectTiempo.removeAttribute('disabled');
                            selectTiempo.setAttribute('required', 'required');
                            
                            selectTipoTele.removeAttribute('disabled');
                            selectTipoTele.setAttribute('required', 'required');
                            
                            // Habilitar y hacer obligatorios los radios (en sitio)
                            radiosSitio.forEach(r => {
                                r.removeAttribute('disabled');
                                r.setAttribute('required', 'required');
                            });
                            
                            // Poner asteriscos
                            [tituloTiempo, tituloSitio, tituloTipoTele].forEach(t => {
                                if(t && !t.hasAttribute('data-asterisco')) {
                                    t.innerHTML += ' <span class="asterisco-dinamico" style="color: #e74a3b; font-size: 1.1em; font-weight: bold;">*</span>';
                                    t.setAttribute('data-asterisco', 'true');
                                }
                            });
                        } else {
                            // Ocultar fila
                            contenedorTiempo.style.display = 'none';
                            
                            // Deshabilitar, quitar obligatoriedad y limpiar selects
                            selectTiempo.setAttribute('disabled', 'disabled');
                            selectTiempo.removeAttribute('required');
                            selectTiempo.value = ''; 
                            
                            selectTipoTele.setAttribute('disabled', 'disabled');
                            selectTipoTele.removeAttribute('required');
                            selectTipoTele.value = ''; 
                            
                            // Deshabilitar, quitar obligatoriedad y DESMARCAR los radios
                            radiosSitio.forEach(r => {
                                r.setAttribute('disabled', 'disabled');
                                r.removeAttribute('required');
                                r.checked = false; // <--- ESTO LOS DEJA TOTALMENTE EN BLANCO
                            });

                            // Limpiar rojo visual de los selects
                            [selectTiempo, selectTipoTele].forEach(el => {
                                el.classList.remove('is-invalid'); 
                                el.style.border = '';
                                var fb = el.parentNode ? el.parentNode.querySelector('.invalid-feedback') : null;
                                if (fb) fb.style.display = '';
                            });

                            // Quitar asteriscos
                            [tituloTiempo, tituloSitio, tituloTipoTele].forEach(t => {
                                if(t && t.hasAttribute('data-asterisco')) {
                                    var ast = t.querySelector('.asterisco-dinamico');
                                    if(ast) ast.remove();
                                    t.removeAttribute('data-asterisco');
                                }
                            });
                        }
                    }

                    eval_telesalud(checkTelesalud); 
                    checkTelesalud.addEventListener('change', function() { eval_telesalud(this); }); 
                }
                // =========================================================================================

                // 2. VALIDADOR ESTRICTO Y FUERZA BRUTA (Cierra modal, scroll y marca rojo)
                var form = document.querySelector('form[name="GUARDA_CONTRAREFERENCIA"]');
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
                        
                        // REVISIÓN MANUAL CAMPO POR CAMPO (Ignoramos los deshabilitados)
                        var elementosObligatorios = form.querySelectorAll('input[required]:not([disabled]), select[required]:not([disabled]), textarea[required]:not([disabled])');
                        
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
<script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dropzone = document.getElementById('dropzone_contra');
                const inputArchivos = document.getElementById('input_archivos_contra');
                const previewGallery = document.getElementById('preview-gallery-contra');
                const inputOcultoPDF = document.getElementById('pdf_final_oculto_contra');
                const visorPdf = document.getElementById('visor_pdf_final_contra');
                const btnPrevisualizar = document.getElementById('btn-previsualizar-pdf');
                
                let archivosAdjuntos = [];

                // Prevenir comportamientos por defecto del navegador al arrastrar
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropzone.addEventListener(eventName, preventDefaults, false);
                    document.body.addEventListener(eventName, preventDefaults, false);
                });

                function preventDefaults (e) { e.preventDefault(); e.stopPropagation(); }

                // Efectos visuales de la caja Drag & Drop
                ['dragenter', 'dragover'].forEach(eventName => {
                    dropzone.addEventListener(eventName, () => {
                        dropzone.style.backgroundColor = '#eaecf4';
                        dropzone.style.borderColor = '#36b9cc';
                    }, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropzone.addEventListener(eventName, () => {
                        dropzone.style.backgroundColor = '#f8f9fc';
                        dropzone.style.borderColor = '#36b9cc';
                    }, false);
                });

                // Escuchar cuando sueltan archivos o seleccionan por clic
                dropzone.addEventListener('drop', (e) => {
                    if (e.dataTransfer.files.length > 0) procesarArchivosNuevos(e.dataTransfer.files);
                });

                inputArchivos.addEventListener('change', (e) => {
                    if (e.target.files.length > 0) procesarArchivosNuevos(e.target.files);
                });

                function procesarArchivosNuevos(files) {
                    Array.from(files).forEach(file => {
                        if (file.type === 'application/pdf' || file.type.startsWith('image/')) {
                            archivosAdjuntos.push(file);
                        } else {
                            alert('El formato del archivo "' + file.name + '" no es válido.');
                        }
                    });
                    renderizarGaleriaYGenerarPDF();
                }

                function eliminarArchivo(index) {
                    archivosAdjuntos.splice(index, 1);
                    renderizarGaleriaYGenerarPDF();
                }

                async function renderizarGaleriaYGenerarPDF() {
                    previewGallery.innerHTML = '';
                    
                    if (archivosAdjuntos.length === 0) {
                        btnPrevisualizar.style.display = 'none';
                        $('#visorColapsableFormContra').collapse('hide');
                        visorPdf.src = '';
                        inputOcultoPDF.files = (new DataTransfer()).files;
                        return;
                    }

                    // Renderizar miniaturas en HTML
                    archivosAdjuntos.forEach((file, index) => {
                        const divItem = document.createElement('div');
                        divItem.className = 'preview-item';
                        
                        const btnClose = document.createElement('button');
                        btnClose.className = 'btn-remove';
                        btnClose.innerHTML = '<i class="fas fa-times"></i>';
                        btnClose.onclick = (e) => { e.stopPropagation(); eliminarArchivo(index); };
                        
                        const spanName = document.createElement('div');
                        spanName.className = 'file-name';
                        spanName.textContent = file.name;

                        if (file.type.startsWith('image/')) {
                            const img = document.createElement('img');
                            img.src = URL.createObjectURL(file);
                            divItem.appendChild(img);
                        } else if (file.type === 'application/pdf') {
                            const iconPdf = document.createElement('div');
                            iconPdf.style.display = 'flex'; iconPdf.style.alignItems = 'center';
                            iconPdf.style.justifyContent = 'center'; iconPdf.style.height = '100%';
                            iconPdf.style.backgroundColor = '#eaecf4'; iconPdf.style.color = '#e74a3b';
                            iconPdf.innerHTML = '<i class="fas fa-file-pdf fa-3x"></i>';
                            divItem.appendChild(iconPdf);
                        }
                        
                        divItem.appendChild(btnClose);
                        divItem.appendChild(spanName);
                        previewGallery.appendChild(divItem);
                    });

                    // Activar el botón de colapso
                    btnPrevisualizar.style.display = 'inline-block';

                    // ========== CONSOLIDACIÓN EN RAM CON PDF-LIB ==========
                    try {
                        const { PDFDocument } = PDFLib;
                        const pdfDoc = await PDFDocument.create();

                        for (const file of archivosAdjuntos) {
                            const arrayBuffer = await file.arrayBuffer();

                            if (file.type === 'application/pdf') {
                                const loadedPdf = await PDFDocument.load(arrayBuffer);
                                const pages = await pdfDoc.copyPages(loadedPdf, loadedPdf.getPageIndices());
                                pages.forEach(page => pdfDoc.addPage(page));
                            } else if (file.type.startsWith('image/')) {
                                let image = (file.type === 'image/png') 
                                    ? await pdfDoc.embedPng(arrayBuffer) 
                                    : await pdfDoc.embedJpg(arrayBuffer);

                                if (image) {
                                    const page = pdfDoc.addPage();
                                    const { width, height } = page.getSize();
                                    const imgDims = image.scaleToFit(width - 40, height - 40);
                                    page.drawImage(image, {
                                        x: width / 2 - imgDims.width / 2,
                                        y: height / 2 - imgDims.height / 2,
                                        width: imgDims.width,
                                        height: imgDims.height,
                                    });
                                }
                            }
                        }

                        const pdfBytes = await pdfDoc.save();
                        const blob = new Blob([pdfBytes], { type: 'application/pdf' });
                        
                        // Cargar en el Iframe para la vista previa
                        visorPdf.src = URL.createObjectURL(blob);
                        
                        // Inyectarlo en el input para que lo envíe el FORM
                        const fileFinal = new File([blob], "Adjuntos_Contrareferencia.pdf", { type: "application/pdf" });
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(fileFinal);
                        inputOcultoPDF.files = dataTransfer.files;

                    } catch (error) {
                        console.error("Error al generar PDF de contrareferencia:", error);
                    }
                }
            });
        </script>
</body>
</html>