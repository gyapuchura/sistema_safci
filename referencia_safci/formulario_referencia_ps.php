<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php include("inc_referencia.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');

$idusuario_ss  = (int)$_SESSION['idusuario_ss'];
$idnombre_ss   = $_SESSION['idnombre_ss'];
$perfil_ss     = $_SESSION['perfil_ss'];

// Paciente y atención que llegan al abrir el formulario
$idatencion_psafci_ss   = isset($_SESSION['idatencion_psafci_ss']) ? (int)$_SESSION['idatencion_psafci_ss'] : 0;
$idnombre_integrante_ss = isset($_SESSION['idnombre_integrante_ss']) ? (int)$_SESSION['idnombre_integrante_ss'] : 0;
$edad_ss                = isset($_SESSION['edad_ss']) ? $_SESSION['edad_ss'] : 0;

// La atención debe pertenecer al paciente: si no coinciden, la sesión mezcló datos de dos pacientes
// (por ejemplo, otra pestaña abierta) y no se permite elaborar la referencia.
$pac  = ref_paciente($link, $idnombre_integrante_ss);
$aten = cr_fila($link, "SELECT idatencion_psafci, idnombre FROM atencion_psafci WHERE idatencion_psafci = ?", 'i', array($idatencion_psafci_ss));
if (!$pac || !$aten || (int)$aten['idnombre'] !== $idnombre_integrante_ss) {
    error_log("[referencia] formulario con paciente/atencion inconsistente n=$idnombre_integrante_ss a=$idatencion_psafci_ss usuario=$idusuario_ss");
    ref_aviso("No se pudo confirmar a qué paciente corresponde la atención, por eso no se abrió el formulario de referencia.\n"
            . "Vuelva a abrir la atención del paciente y presione nuevamente el botón de referencia.\n"
            . "Si tiene abiertas otras pestañas con otros pacientes, ciérrelas antes.", 'Aviso del Sistema');
}

// Datos del paciente con los mismos índices de antes: 0 idnombre, 1 nombre, 2 paterno, 3 materno, 4 ci,
// 5 fecha_nac, 6 idnacionalidad, 7 idgenero
$row_n = array_values($pac);
$edad  = ref_edad($row_n[5], $edad_ss);   // calculada de la fecha de nacimiento

// El establecimiento de origen es el de trabajo del usuario: se revisa al abrir (no al guardar),
// para que el médico no llene todo el formulario y recién al registrar se entere del problema.
$eess_origen = cr_eess_usuario($link, $idusuario_ss);
if ($eess_origen <= 0 || !cr_fila($link, "SELECT idestablecimiento_salud FROM establecimiento_salud WHERE idestablecimiento_salud = ?", 'i', array($eess_origen))) {
    ref_aviso("Su usuario no tiene un establecimiento de trabajo registrado, por eso no se puede elaborar la referencia.\nComuníquese con el administrador.", 'Aviso del Sistema');
}

// Token del formulario: fija paciente, atención y usuario hasta que se registre la referencia
$ref_token = ref_token_crear($idnombre_integrante_ss, $idatencion_psafci_ss, $idusuario_ss, $edad);
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

    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/jquery-ui.min.css">
    <link rel="stylesheet" href="../css/boton_mic.css">

    <style>
        /* Zona para arrastrar o seleccionar archivos adjuntos */
        .dropzone-safci {
            border: 2px dashed #4e73df;
            border-radius: 10px;
            background-color: #f8f9fc;
            padding: 20px 10px;
            text-align: center;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
            position: relative;
        }
        .dropzone-safci:hover, .dropzone-safci.dragover {
            background-color: #eaecf4;
            border-color: #2e59d9;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .dropzone-icon {
            font-size: 3rem;
            color: #dddfeb;
            margin-bottom: 15px;
            transition: color 0.3s ease;
        }
        .dropzone-safci:hover .dropzone-icon { color: #4e73df; }
        
        /* Miniaturas de los archivos adjuntos */
        .preview-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }
        .thumb-item {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.15);
            overflow: hidden;
            border: 1px solid #d1d3e2;
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .thumb-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .thumb-pdf-icon {
            font-size: 2.5rem;
            color: #e74a3b;
        }
        .thumb-name {
            font-size: 0.7rem;
            text-align: center;
            padding: 5px;
            width: 100%;
            background: rgba(255,255,255,0.9);
            position: absolute;
            bottom: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        /* Botón para quitar un archivo adjunto */
        .btn-remove-thumb {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #e74a3b;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s;
            z-index: 10;
        }
        .btn-remove-thumb:hover {
            transform: scale(1.1);
            background: #be2617;
        }
        
        /* Vista previa del PDF de adjuntos */
        #visor_pdf_final {
            width: 100%;
            height: 550px;
            border: 1px solid #d1d3e2;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
    </style>

</head>

<body id="page-top">

    <div id="wrapper">

    <?php include("../menu.php");?>
    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">

            <?php include("../top_bar.php"); ?>

            <div class="container">
                    </br>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                            <div class="text-center">                          
                            <a href="javascript:history.back()"><h6 class="text-info"><- VOLVER</h6></a>
                            <hr>  
                        <div class="text-center">
                        <h4 class="m-0 font-weight-bold text-primary">FORMULARIO DE REFERENCIA D7</h4>
                        </div>
                    </div>
                    <div class="card-body">

                     <form name="GUARDA_REFERENCIA" id="form_referencia" action="guarda_referencia.php" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
                        <!-- Token del formulario: paciente y atención fijados al abrirlo (lo valida guarda_referencia.php) -->
                        <input type="hidden" name="ref_token" value="<?php echo cr_h($ref_token);?>">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
  
                                <h6 class="m-0 font-weight-bold text-primary">1.- IDENTIFICACIÓN DEL PACIENTE</h6>
                            </div>
                            <div class="card-body">

                                <div class="form-group row">                               
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">CÉDULA DE IDENTIDAD:</h6>
                                        <input type="text" class="form-control" value="<?php echo cr_h($row_n[4]);?>"
                                        name="ci" disabled>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">NOMBRES:</h6>
                                        <input type="text" class="form-control" value="<?php echo cr_h($row_n[1]);?>"
                                        name="nombre" disabled>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">PRIMER APELLIDO:</h6>
                                        <input type="text" class="form-control" value="<?php echo cr_h($row_n[2]);?>"
                                        name="paterno" disabled >
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">SEGUNDO APELLIDO:</h6>
                                        <input type="text" class="form-control" value="<?php echo cr_h($row_n[3]);?>"
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
                                    <input type="number" class="form-control" value="<?php echo (int)$edad;?>"
                                    name="edad_actual" disabled>
                                </div>
                                <div class="col-sm-4">
                                <h6 class="text-primary"></h6>

                                </div>
                                </div>  

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

                                <input type="hidden" name="idcarpeta_familiar" value="<?php echo $row_cf[0];?>">
                                <input type="hidden" name="idintegrante_cf" value="<?php echo $row_cf[2];?>">

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
                                        <a class="btn btn-primary btn-icon-split" href="../produccion_servicios/imprime_historia_clinica_ps.php?idnombre_integrante=<?php echo $idnombre_integrante_ss;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1000,height=1000,top=50, left=400, scrollbars=YES'); return false;">                        
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
                                        <a class="btn btn-primary btn-icon-split" href="../produccion_servicios/imprime_historia_clinica_ps.php?idnombre_integrante=<?php echo $idnombre_integrante_ss;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1000,height=1000,top=50, left=400, scrollbars=YES'); return false;">                        
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
                                    <select name="discapacidad" id="discapacidad" class="form-control" required>
                                        <option value="">Seleccione</option>
                                        <option value="NO">NO</option>
                                        <option value="SI">SI</option>
                                    </select>
                                    </div>
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-4"></div>
                                </div>
                                <div class="form-group row" id="persona_discapacidad"> 
                                </div>
                                <div class="form-group row">                               
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">NOMBRE DEL ACOMPAÑANTE:</h6>
                                        <input type="text" class="form-control" value="" 
                                        name="nombre_acompanante" maxlength="100" required>
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
                                        <input type="text" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control" value=""             
                                        name="celular_acompanante" maxlength="45">              
                                    </div>

                                    <div class="col-sm-6">
                                    <h6 class="text-primary">TEL/CEL DEL ESTABLECIMIENTO DE SALUD:</h6>
                                        <input type="text" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control" value=""             
                                        name="tel_establecimiento" maxlength="45" required >              
                                    </div>
                                </div>
                                
                            </div>                                
                        </div>

                        <?php
                        $sql_se =" SELECT idsigno_vital_psafci, talla, peso, temperatura, frec_cardiaca, frec_respiratoria, presion_arterial, presion_arterial_d, saturacion, glascow, alergia, ";
                        $sql_se.=" descripcion_alergia, imc FROM signo_vital_psafci WHERE idnombre ='$idnombre_integrante_ss' ORDER BY idsigno_vital_psafci DESC LIMIT 1 ";
                        $result_se = mysqli_query($link,$sql_se);
                        $row_se = mysqli_fetch_array($result_se);
                        if (!$row_se) { $row_se = array_fill(0, 13, ''); }   // paciente sin signos vitales registrados
                        ?>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">2.- DATOS CLÍNICOS Y SIGNOS VITALES</h6>
                            </div>
                            <div class="card-body">
                                
                                <div class="form-group row">  
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">TALLA </br>[Centímetros]:</h6>
                                        <input type="number" min="20" max="280" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 280) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 20) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En Centímetros"
                                            name="talla" value="<?php echo $row_se[1];?>" required>                
                                        <div class="invalid-feedback">Permitido: 20 a 280 cm</div>
                                    </div>                             
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">PESO </br>[kg]:</h6>
                                        <input type="number" step="any" min="0.2" max="650" onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();" oninput="if(this.value > 650) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0.2) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En kilogramos"            
                                            name="peso" value="<?php echo $row_se[2];?>" required>                
                                        <div class="invalid-feedback">Permitido: 0.2 a 650 kg</div>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">TEMPERATURA</br>[°C]:</h6>
                                        <input type="number" step="any" min="10" max="47" onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();" oninput="if(this.value > 47) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 10) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En Grados Centígrados"
                                            name="temperatura" value="<?php echo $row_se[3];?>" required>                
                                        <div class="invalid-feedback">Permitido: 10°C a 47°C</div>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FRECUENCIA CARDIACA </br>[lpm]:</h6>
                                        <input type="number" min="0" max="350" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 350) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="Latidos por minuto"
                                            name="frec_cardiaca" value="<?php echo $row_se[4];?>" required>                
                                        <div class="invalid-feedback">Permitido: 0 a 350 lpm</div>
                                    </div>
                                </div>

                                <?php  if ($edad > 5) {  // Mayores de 5 años: incluye presión arterial ?>
                            
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                                        <input type="number" min="0" max="80" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 80) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="Ciclos por minuto"
                                            name="frec_respiratoria" value="<?php echo $row_se[5];?>" required>                
                                        <div class="invalid-feedback">Permitido: 0 a 80 cpm</div>
                                    </div> 
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>
                                        <input type="number" min="0" max="300" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 300) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control"           
                                            name="presion_arterial" value="<?php echo $row_se[6];?>"  placeholder="Sistólica"  required>               
                                        <div class="invalid-feedback">Permitido: 0 a 300 mmHg</div>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary"> </br>diastólica [mmHg]</h6>
                                        <input type="number" min="0" max="200" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 200) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control"  placeholder="Diastólica"           
                                            name="presion_arterial_d" value="<?php echo $row_se[7];?>" required>                
                                        <div class="invalid-feedback">Permitido: 0 a 200 mmHg</div>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">SATURACIÓN</br>[% O2]:</h6>
                                        <input type="number" min="0" max="100" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 100) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="% de O2"
                                            name="saturacion" value="<?php echo $row_se[8];?>" required>                
                                        <div class="invalid-feedback">Permitido: 0% a 100%</div>
                                    </div>
                                </div>

                                <div class="form-group row">  
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">GLASGOW:</br> </h6>
                                        <input type="number" min="3" max="15" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 15) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 3) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="Glasgow"
                                            name="glascow" value="<?php echo $row_se[9];?>" required>                
                                        <div class="invalid-feedback">Permitido: 3 a 15</div>
                                    </div>  
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">ALÉRGIAS:</h6>
                                    SI <input type="radio" name="alergia" value="SI" > </br>
                                    NO <input type="radio" name="alergia" value="NO" checked >  
                                    </div>
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">DESCRIPCIÓN DE LA ALÉRGIA</h6>
                                    <textarea class="form-control" rows="3" name="descripcion_alergia" id="descripcion_alergia" placeholder="Escriba o utilice el botón de dictado por voz" ></textarea>
                                    
                                    <div class="invalid-feedback">Debe especificar a qué es alérgico.</div>
                                    
                                    <button type="button" class="btn-mic" onclick="iniciarDictado('descripcion_alergia')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                                    </div>
                                </div>

                                <?php } else { ?>

                                <div class="form-group row">
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                                        <input type="number" min="0" max="80" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 80) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="Ciclos por minuto"
                                            name="frec_respiratoria" value="<?php echo cr_h($row_se[5]);?>" required>              
                                        <div class="invalid-feedback">Permitido: 0 a 80 cpm</div>
                                    </div> 
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">SATURACIÓN</br>[% O2]:</h6>   
                                        <input type="number" min="0" max="100" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 100) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="% de O2"
                                            name="saturacion" value="<?php echo cr_h($row_se[8]);?>" required>           
                                        <div class="invalid-feedback">Permitido: 0% a 100%</div>
                                    </div>
                                    <div class="col-sm-3">
                                    <input type="hidden" class="form-control"              
                                            name="presion_arterial" value="0">               
                                    </div>
                                    <div class="col-sm-3">
                                    <input type="hidden" class="form-control"              
                                            name="presion_arterial_d" value="0">          
                                    </div>
                                </div>

                                <div class="form-group row">  
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">GLASGOW:</br> </h6>
                                        <input type="number" min="3" max="15" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 15) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 3) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="Glasgow"
                                            name="glascow" value="<?php echo cr_h($row_se[9]);?>" required>              
                                        <div class="invalid-feedback">Permitido: 3 a 15</div>
                                    </div>  
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">ALÉRGIAS:</h6>
                                    SI <input type="radio" name="alergia" value="SI" > </br>
                                    NO <input type="radio" name="alergia" value="NO" checked >  
                                    </div>
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">DESCRIPCIÓN DE LA ALÉRGIA</h6>
                                    <textarea class="form-control" rows="3" name="descripcion_alergia" id="descripcion_alergia" placeholder="Escriba o utilice el botón de dictado por voz"></textarea>
                                    <button type="button" class="btn-mic" onclick="iniciarDictado('descripcion_alergia')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>                            
                                    </div>
                                </div>

                            <?php } ?>

                        <?php  if ($row_n[7] == '1' && $edad >= 10) {  // Mujeres desde 10 años: pregunta de embarazo (mismo rango que los diagnósticos de embarazo) ?>
                        <hr>                              
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <h6 class="m-0 font-weight-bold text-danger">SE REFERIRÁ A UNA PERSONA EN ESTADO DE EMBARAZO?</h6>
                            </div>
                            <div class="col-sm-6">
                                <select name="datos_perinatales" id="datos_perinatales" class="form-control" required>
                                    <option value="">Seleccione</option>
                                    <option value="NO">NO</option>
                                    <option value="SI">SI</option>
                                </select>
                            </div>
                        </div>
 
                        <?php } else { ?>

                        <?php } ?>
                            </div>
                        </div>

                        <div id="datos_embarazo"></div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">3.- RESUMEN DE ANAMNESIS Y EXAMEN FISICO</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">¿ESTUVO INTERNADO?:</h6>
                                        SI <input type="radio" name="estuvo_internado" value="SI" > </br>
                                        NO <input type="radio" name="estuvo_internado" value="NO" checked >                
                                    </div>

                                    <div class="col-sm-3">
                                    <h6 class="text-primary">DÍAS DE INTERNACIÓN:</h6>
                                        <input type="number" class="form-control" value="" placeholder="Nº de Días"            
                                        name="dias_internacion" min="1" >
                                        <div class="invalid-feedback">Indique los días de internación.</div>               
                                    </div>
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-3"></div>
                                    </div>
                                    <div class="form-group row"> 
                                    <div class="col-sm-12">
                                    <h6 class="text-primary">RESUMEN ANAMNESIS Y EXAMEN FISICO</h6>
                                    <textarea class="form-control" rows="3" name="resumen_anamnesis" id="resumen_anamnesis" placeholder="Escriba o utilice el botón de dictado por voz"  required></textarea>
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
                                    $sql_c =" SELECT idexamen_complementario, examen_complementario FROM examen_complementario WHERE telesalud ='NO' ";
                                    $result_c = mysqli_query($link,$sql_c);
                                    if ($row_c = mysqli_fetch_array($result_c)){
                                    mysqli_field_seek($result_c,0);
                                    while ($field_c = mysqli_fetch_field($result_c)){
                                    } do { ?>                            
                                            <div class="col-sm-2">
                                            <h6 class="text-primary"><?php echo $row_c[1];?> : <input type="checkbox" class="chk-examen" data-nombre="<?php echo trim(strtoupper($row_c[1])); ?>" name="idexamen_complementario[<?php echo $numero_c;?>]" value="<?php echo $row_c[0];?>"></h6>    
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
                                    
                                    <textarea class="form-control" rows="3" name="especificacion_hallazgos" id="especificacion_hallazgos" placeholder="Escriba los hallazgos o utilice el botón de dictado por voz" required></textarea>
                                    
                                    <div class="invalid-feedback" style="margin-top: 5px;">Debe especificar a qué otros exámenes se refiere.</div>
                                    
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
                                
                                <!-- Diagnósticos: el 1 es obligatorio (CIE-10); el 2 y el 3 son opcionales, pero si tienen texto deben tener CIE-10.
                                     El buscador es el mismo de la contrarreferencia (catálogo en caché) y no muestra como elegibles
                                     los diagnósticos que no corresponden al sexo o la edad del paciente. -->
                                <?php for ($n = 0; $n < 3; $n++) { ?>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                    <h6 class="m-0 font-weight-bold text-primary">DIAGNÓSTICO ESPECÍFICO <?php echo $n + 1; ?></h6>
                                    <textarea class="form-control" rows="3" name="diagnostico_presuntivo[<?php echo $n; ?>]" id="diagnostico_presuntivo[<?php echo $n; ?>]" placeholder="Escriba o utilice el botón de dictado por voz si corresponde"></textarea>
                                    <button type="button" class="btn-mic" onclick="iniciarDictado('diagnostico_presuntivo[<?php echo $n; ?>]')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                                    </div>
                                    <div class="col-sm-6">
                                        <h6 class="m-0 font-weight-bold text-primary">CIE - 10<?php if ($n === 0) { ?> <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span><?php } ?></h6>
                                        <div style="position: relative;">
                                            <input type="text" class="form-control buscador-cie-inteligente" data-target="idpatologia_<?php echo $n; ?>" placeholder="Escriba para buscar patología o código CIE-10..." autocomplete="off">
                                            <div class="lista-flotante-cie" style="display: none; position: absolute; z-index: 1000; background: white; border: 1px solid #d1d3e2; border-radius: 0.35rem; width: 100%; max-height: 220px; overflow-y: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"></div>
                                        </div>
                                        <!-- ID del CIE-10 elegido (lo que recibe guarda_referencia.php, mismo nombre de siempre) -->
                                        <input type="hidden" name="idpatologia[<?php echo $n; ?>]" id="idpatologia_<?php echo $n; ?>" value=""<?php echo $n === 0 ? ' required' : ''; ?>>
                                        <?php if ($n === 0) { ?>
                                        <div class="invalid-feedback" style="margin-top: 5px;">Debe seleccionar de la lista el CIE-10 del diagnóstico principal.</div>
                                        <?php } else { ?>
                                        <div class="invalid-feedback" style="margin-top: 5px;">Este diagnóstico tiene texto pero no tiene CIE-10. Seleccione un CIE-10 de la lista o borre el texto.</div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php } ?>

                            </div>

                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">6.- TRATAMIENTO</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-12">
                                    <h6 class="text-primary mb-2">DETALLE DEL TRATAMIENTO:</h6>
                                    
                                    <textarea class="form-control" rows="3" name="tratamiento_ref" id="tratamiento_ref" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
                                    
                                    <div class="invalid-feedback">Por favor, escriba el tratamiento. Este campo es obligatorio.</div>
                                    
                                    <button type="button" class="btn-mic" onclick="iniciarDictado('tratamiento_ref')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>      
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">7.- OBSERVACIONES <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span></h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-12">
                                    <textarea class="form-control" rows="3" name="observaciones_ref" id="observaciones_ref" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
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
                                    <div class="col-sm-12">
                                        <h6 class="text-primary mb-3">SELECCIONE QUIEN FIRMARÁ EL CONSENTIMIENTO:</h6>
                                        
                                        <select name="idconsentimiento" id="idconsentimiento" class="form-control" required>
                                            <option value=""> - Seleccione - </option>
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
                                        
                                        <div class="invalid-feedback">Debe seleccionar quién firmará el consentimiento.</div>
                                        
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
                                        <h6 class="text-primary mb-3">ESCRIBA Y SELECCIONE EL ESTABLECIMIENTO:</h6>  
                                        
                                        <div style="position: relative;">
                                            <input type="text" class="form-control" placeholder="Escriba el nombre del establecimiento receptor..." id="busqueda" autocomplete="off" required/>
                                            
                                            <div class="invalid-feedback">Por favor, escriba y seleccione un establecimiento de la lista.</div>

                                            <div id="lista-flotante-eess" style="display: none; position: absolute; z-index: 1000; background: white; border: 1px solid #d1d3e2; border-radius: 0.35rem; width: 100%; max-height: 250px; overflow-y: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-top: 2px;"></div>
                                        </div>

                                        <select name="idestablecimiento_salud_r" id="resultado" style="display: none;"></select>                                    
                                    </div>   
                                </div> 
                            </div>
                        </div>

                        <div class="card shadow mb-4" id="especialidad_eess">                            
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-paperclip"></i> ARCHIVOS ADJUNTOS </h6>
                                <button type="button" id="btn-previsualizar-pdf" class="btn btn-sm btn-outline-info shadow-sm" data-toggle="collapse" data-target="#visorColapsableForm" aria-expanded="false" aria-controls="visorColapsableForm" style="display: none;">
                                    <i class="fas fa-eye"></i> VER / OCULTAR PDF
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-12">
                                        <h6 class="text-primary mb-3">ARRASTRE O SELECCIONE FOTOGRAFÍAS, EXÁMENES DE LABORATORIO O ECOGRAFÍAS DEL PACIENTE:</h6>
                                        
                                        <div id="dropzone" class="dropzone-safci" onclick="document.getElementById('input_archivos').click()">
                                            <i class="fas fa-cloud-upload-alt dropzone-icon" style="font-size: 2.5rem; margin-bottom: 5px;"></i>
                                            <h6 class="font-weight-bold text-secondary mb-1">Arrastre sus archivos aquí</h6>
                                            <p class="text-muted small mb-0">o haga clic para examinar el dispositivo</p>
                                            <p class="text-xs text-primary mt-1 font-weight-bold mb-0">Formatos permitidos: JPG, JPEG, PNG, PDF &middot; Tamaño máximo total: <?php echo cr_limite_adjunto_mb(); ?> MB</p>
                                            <input type="file" id="input_archivos" multiple accept="image/jpeg, image/png, application/pdf" style="display: none;">
                                        </div>

                                        <div id="preview-gallery" class="preview-grid"></div>

                                        <input type="file" id="pdf_final_oculto" name="archivo_referencia_pdf" style="display: none;">
                                        
                                        <div class="collapse mt-4" id="visorColapsableForm">
                                            <div class="embed-responsive" style="height: 500px; border: 1px solid #d1d3e2; border-radius: 8px; overflow: hidden; background-color: #eaecf4;">
                                                <iframe id="visor_pdf_final" src="" style="width: 100%; height: 100%; border: none;" allowfullscreen></iframe>
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
                                        REGISTRAR REFERENCIA
                                        </button>  
                                    </div>                              
                                </div>                            
                            </div>



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
                                                posteriormente no se podran realizar cambios.

                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                            <button type="button" id="btn-confirmar-registro" class="btn btn-primary pull-center">CONFIRMAR REGISTRO</button>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                </div>
                </div>


                </div>

                    <div class="text-center">
                        <a class="small" href="#">PROGRAMA SAFCI - MI SALUD</a>
                    </div>
                    <div class="text-center">
                        <a class="small" href="#">Ministerio de Salud y Deportes</a>
                    </div> 
                    </br> 
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
                        </div> 
    </div> 
</div>       
    <!-- Librerías base (jQuery se carga una sola vez para que los componentes de Bootstrap funcionen) -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Dictado por voz (iniciarDictado) -->
    <script src="../js/funciones.js"></script>

    <!-- Unión de adjuntos en un solo PDF (copia local, no depende de internet) -->
    <script src="../vendor/pdf-lib/pdf-lib-1.17.1.min.js"></script>

    <!-- Buscador CIE-10 compartido con la contrarreferencia (catálogo en caché del navegador).
         Con las reglas de sexo y edad, los diagnósticos que no corresponden al paciente no se pueden elegir. -->
    <script src="../comun/buscador_cie10.js"></script>
    <script>
        BuscadorCIE10.iniciar('<?php echo cie10_url_catalogo($link); ?>', {
            reglas: <?php echo json_encode(cie10_reglas_sexo_edad(), JSON_UNESCAPED_UNICODE); ?>,
            paciente: { genero: <?php echo (int)$row_n[7]; ?>, edad: <?php echo (int)$edad; ?> }
        });
    </script>

    <!-- Aviso de cierre de sesión por inactividad (la sesión se renueva sola mientras el médico trabaja) -->
    <script src="../comun/sesion_aviso.js"></script>
    <script>
        SesionAviso.iniciar({
            idusuario: <?php echo (int)$idusuario_ss; ?>,
            limiteServidor: <?php echo (int)ini_get('session.gc_maxlifetime'); ?>,
            formularioRecuperable: true
        });
    </script>

    <script>
        // ESTABLECIMIENTO RECEPTOR: búsqueda por nombre; se debe elegir de la lista.
        // Una vez elegido queda bloqueado; para cambiarlo: doble clic o tecla Borrar / Suprimir.
        $(document).ready(function () {
            var inputBusqueda  = $("#busqueda");
            var listaFlotante  = $("#lista-flotante-eess");
            var selectResultado = $("#resultado");

            inputBusqueda.keyup(function () {
                if ($(this).prop('readonly')) return;

                var consulta = inputBusqueda.val();
                if (consulta.trim() === '') {
                    listaFlotante.hide();
                    selectResultado.empty();
                    selectResultado.val('');
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "buscar_establecimiento.php",
                    data: { b: consulta },
                    dataType: "html",
                    beforeSend: function () {
                        listaFlotante.show().html("<div style='padding: 10px; text-align: center; color: #858796;'><img src='ajax-loader.gif' style='width:20px;' alt='...'/> Buscando...</div>");
                    },
                    error: function () {
                        listaFlotante.show().html("<div style='padding: 10px; color: #e74a3b;'>No se pudo realizar la búsqueda. Revise su conexión.</div>");
                    },
                    success: function (data) {
                        selectResultado.empty().append(data);
                        listaFlotante.empty();
                        var opciones = selectResultado.find('option');

                        if (opciones.length === 0 || (opciones.length === 1 && opciones.val() === '')) {
                            listaFlotante.show().html("<div style='padding: 10px; color: #858796;'>No se encontraron establecimientos</div>");
                            return;
                        }

                        opciones.each(function () {
                            var valorID = $(this).val();
                            var textoEESS = $(this).text().replace(/\s+/g, ' ').trim();
                            if (valorID === "") return;

                            var item = $("<div class='item-eess'></div>").text(textoEESS);
                            item.css({
                                'padding': '8px 12px', 'cursor': 'pointer',
                                'border-bottom': '1px solid #eaecf4', 'font-size': '0.9rem', 'color': '#5a5c69'
                            });
                            item.hover(
                                function () { $(this).css({'background-color': '#eaecf4', 'color': '#2e59d9'}); },
                                function () { $(this).css({'background-color': 'transparent', 'color': '#5a5c69'}); }
                            );

                            // Elegir el establecimiento (mousedown para que no se adelante el blur)
                            item.mousedown(function (e) {
                                e.preventDefault();
                                inputBusqueda.val(textoEESS);
                                selectResultado.val(valorID);
                                listaFlotante.hide();

                                inputBusqueda.prop('readonly', true);
                                inputBusqueda.css({'background-color': '#eaecf4', 'color': '#2e59d9', 'cursor': 'not-allowed'});
                                inputBusqueda.attr('title', 'Doble clic o presione Borrar (Backspace) para cambiar el establecimiento');
                                inputBusqueda.removeClass('is-invalid').css('border', '');

                                // Carga el motivo y la especialidad del establecimiento elegido
                                selectResultado.trigger('change');
                            });

                            listaFlotante.append(item);
                        });
                    }
                });
            });

            // Quitar el establecimiento elegido para buscar otro
            function desbloquearEESS() {
                if (inputBusqueda.prop('readonly')) {
                    inputBusqueda.prop('readonly', false);
                    inputBusqueda.val('');
                    selectResultado.val('');
                    inputBusqueda.css({'background-color': '', 'color': '', 'font-weight': 'normal', 'cursor': 'text'});
                    inputBusqueda.removeAttr('title');
                    $("#especialidad_eess").empty();
                    inputBusqueda.focus();
                }
            }

            inputBusqueda.keydown(function (e) {
                if ($(this).prop('readonly')) {
                    if (e.which === 8 || e.which === 46) {          // Borrar / Suprimir
                        e.preventDefault();
                        desbloquearEESS();
                    } else if (e.which !== 9) {                    // se permite Tab para avanzar
                        e.preventDefault();
                    }
                }
            });

            inputBusqueda.dblclick(function () {
                desbloquearEESS();
            });

            // Si sale del campo sin elegir de la lista, lo escrito se borra (solo vale un establecimiento de la lista)
            inputBusqueda.blur(function () {
                setTimeout(function () {
                    listaFlotante.hide();
                    if (!inputBusqueda.prop('readonly')) {
                        inputBusqueda.val('');
                        selectResultado.val('');
                        $("#especialidad_eess").empty();
                    }
                }, 200);
            });
        });
    </script>

    <script>
        // DATOS PERINATALES: al responder la pregunta de embarazo se cargan los campos correspondientes
        $(document).ready(function () {
            $("#datos_perinatales").change(function () {
                var datos_perinatales = $(this).val();
                $.post("datos_perinatales.php", { datos_perinatales: datos_perinatales }, function (data) {
                    $("#datos_embarazo").html(data);
                });
            });
        });
    </script>

    <script>
        // DISCAPACIDAD: si es SI se cargan el tipo y el nivel (obligatorios), con su asterisco y mensaje de ayuda
        $(document).ready(function () {
            $("#discapacidad").change(function () {
                var discapacidad = $(this).val();
                $.post("persona_discapacidad.php", { discapacidad: discapacidad }, function (data) {
                    $("#persona_discapacidad").html(data);

                    $("#persona_discapacidad select[required], #persona_discapacidad input[required]").each(function () {
                        var campoActual = $(this);
                        var contenedor = campoActual.closest('[class*="col-sm-"]');
                        var titulo = contenedor.find('h6');

                        if (titulo.length > 0 && !titulo.attr('data-asterisco')) {
                            titulo.append(' <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span>');
                            titulo.attr('data-asterisco', 'true');
                        }

                        if (contenedor.find('.invalid-feedback').length === 0) {
                            var nombreCampo = "esta opción";
                            if (campoActual.attr('name') === 'idtipo_discapacidad') nombreCampo = "el tipo de discapacidad";
                            if (campoActual.attr('name') === 'idnivel_discapacidad') nombreCampo = "el nivel de discapacidad";
                            campoActual.after('<div class="invalid-feedback" style="margin-top: 5px;">Debe seleccionar ' + nombreCampo + '.</div>');
                        }
                    });
                });
            });
        });
    </script>

    <script>
        // MOTIVO Y ESPECIALIDAD: se cargan según el establecimiento receptor elegido
        $(document).ready(function () {
            $("#resultado").change(function () {
                var establecimiento_salud = $(this).val();
                if (!establecimiento_salud) return;

                $.post("establecimiento_salud_especialidad.php", { establecimiento_salud: establecimiento_salud }, function (data) {
                    $("#especialidad_eess").html(data);

                    $("#especialidad_eess select[required]").each(function () {
                        var selectActual = $(this);
                        var contenedor = selectActual.parent();
                        var titulo = contenedor.find('h6');

                        if (titulo.length > 0) {
                            // Se quitan del título los códigos internos entre corchetes (ej. [933])
                            titulo.html(titulo.html().replace(/\s*\[\d+\]/g, ''));

                            if (!titulo.attr('data-asterisco')) {
                                titulo.append(' <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span>');
                                titulo.attr('data-asterisco', 'true');
                            }
                        }

                        if (contenedor.find('.invalid-feedback').length === 0) {
                            var nombreCampo = selectActual.attr('name') === 'idmotivo_referencia' ? 'el motivo' : 'la especialidad';
                            selectActual.after('<div class="invalid-feedback" style="margin-top: 5px;">Debe seleccionar ' + nombreCampo + '.</div>');
                        }
                    });
                });
            });
        });
    </script>

    <script>
        // VALIDACIÓN ANTES DE REGISTRAR
        // Revisa los campos obligatorios, los diagnósticos y los adjuntos; marca en rojo lo pendiente y lleva al primero.
        // Si todo está correcto, confirma que la sesión siga abierta y envía el formulario.
        document.addEventListener('DOMContentLoaded', function () {
            var form = document.querySelector('form[name="GUARDA_REFERENCIA"]');
            var btnConfirmar = document.getElementById('btn-confirmar-registro');
            if (!form || !btnConfirmar) return;

            var TEXTO_BOTON = btnConfirmar.innerHTML;

            function marcarInvalido(el, feedbackDesde) {
                el.classList.add('is-invalid');
                el.style.setProperty('border', '2px solid #dc3545', 'important');
                var contenedor = feedbackDesde || el.parentNode;
                var feedback = contenedor ? contenedor.querySelector('.invalid-feedback') : null;
                if (feedback) feedback.style.setProperty('display', 'block', 'important');
            }

            function cerrarModal() {
                try {
                    var btnCancelar = document.querySelector('#examplemodal_f [data-dismiss="modal"]');
                    if (btnCancelar) btnCancelar.click();
                    $('#examplemodal_f').modal('hide');
                } catch (err) { }
            }

            function restaurarBoton() {
                btnConfirmar.disabled = false;
                btnConfirmar.innerHTML = TEXTO_BOTON;
            }

            // Al volver con el botón ATRÁS del navegador, el botón queda habilitado otra vez
            window.addEventListener('pageshow', restaurarBoton);

            btnConfirmar.addEventListener('click', function (e) {
                e.preventDefault();

                var hayErrores = false;
                var primerInvalido = null;

                // 1. Limpiar marcas anteriores
                form.querySelectorAll('.is-invalid').forEach(function (el) {
                    el.classList.remove('is-invalid');
                    el.style.border = '';
                });
                form.querySelectorAll('.invalid-feedback').forEach(function (el) {
                    el.style.display = '';
                });

                // 2. Campos obligatorios (los deshabilitados no se revisan)
                var obligatorios = form.querySelectorAll('input[required]:not([disabled]), select[required]:not([disabled]), textarea[required]:not([disabled])');
                obligatorios.forEach(function (el) {
                    var valor = el.value ? el.value.trim() : '';
                    if (valor !== '' && el.checkValidity()) return;
                    hayErrores = true;

                    if (el.type === 'hidden' && el.id && el.id.indexOf('idpatologia_') === 0) {
                        // CIE-10 (campo oculto): se marca el buscador visible
                        var visual = document.querySelector('input[data-target="' + el.id + '"]');
                        if (visual) {
                            marcarInvalido(visual, el.parentNode);
                            if (!primerInvalido) primerInvalido = visual;
                        }
                    } else if (el.type !== 'hidden' && el.style.display !== 'none') {
                        marcarInvalido(el);
                        if (!primerInvalido) primerInvalido = el;
                    }
                });

                // 3. Diagnósticos 2 y 3 (opcionales): si tienen texto, deben tener CIE-10 elegido de la lista
                [1, 2].forEach(function (n) {
                    var texto = document.getElementById('diagnostico_presuntivo[' + n + ']');
                    var oculto = document.getElementById('idpatologia_' + n);
                    if (texto && oculto && texto.value.trim() !== '' && oculto.value === '') {
                        hayErrores = true;
                        var visual = document.querySelector('input[data-target="idpatologia_' + n + '"]');
                        if (visual) {
                            marcarInvalido(visual, oculto.parentNode);
                            if (!primerInvalido) primerInvalido = visual;
                        }
                    }
                });

                // 3b. Establecimiento receptor: debe estar elegido de la lista (no basta con el texto escrito;
                //     ej. al volver con ATRÁS el navegador puede conservar el texto pero no la selección)
                var busqueda = document.getElementById('busqueda');
                var resultado = document.getElementById('resultado');
                if (busqueda && resultado && !resultado.value) {
                    hayErrores = true;
                    marcarInvalido(busqueda);
                    if (!primerInvalido) primerInvalido = busqueda;
                }

                // 3c. Persona con discapacidad = SI: tipo y nivel deben estar cargados y elegidos
                var discapacidad = document.getElementById('discapacidad');
                if (discapacidad && discapacidad.value === 'SI') {
                    var faltanCampos = false;
                    ['idtipo_discapacidad', 'idnivel_discapacidad'].forEach(function (nombre) {
                        var sel = form.querySelector('select[name="' + nombre + '"]');
                        if (!sel) { faltanCampos = true; return; }
                        if (!sel.value) {
                            hayErrores = true;
                            marcarInvalido(sel);
                            if (!primerInvalido) primerInvalido = sel;
                        }
                    });
                    if (faltanCampos) {
                        hayErrores = true;
                        $(discapacidad).trigger('change');   // se vuelven a cargar tipo y nivel
                        marcarInvalido(discapacidad);
                        if (!primerInvalido) primerInvalido = discapacidad;
                    }
                }

                // 4. Adjuntos: deben estar listos y no superar el tamaño máximo
                var dropzone = document.getElementById('dropzone');
                if (!hayErrores && window.estadoAdjuntosRef === 'procesando') {
                    hayErrores = true;
                    alert('Los archivos adjuntos todavía se están preparando. Espere unos segundos y vuelva a presionar CONFIRMAR REGISTRO.');
                    if (!primerInvalido) primerInvalido = dropzone;
                } else if (!hayErrores && window.estadoAdjuntosRef === 'error') {
                    hayErrores = true;
                    alert('Hay un problema con los archivos adjuntos. Quite el último archivo agregado o vuelva a adjuntarlos.');
                    if (!primerInvalido) primerInvalido = dropzone;
                }
                var limiteAdjunto = <?php echo (int)cr_limite_adjunto(); ?>;
                var pdfOculto = document.getElementById('pdf_final_oculto');
                if (!hayErrores && limiteAdjunto > 0 && pdfOculto && pdfOculto.files && pdfOculto.files.length > 0
                    && pdfOculto.files[0].size > limiteAdjunto) {
                    hayErrores = true;
                    alert('Los archivos adjuntos suman ' + (pdfOculto.files[0].size / 1048576).toFixed(1) +
                          ' MB y el máximo permitido es ' + (limiteAdjunto / 1048576).toFixed(1) +
                          ' MB. Quite algunos archivos o use fotos de menor tamaño.');
                    if (!primerInvalido) primerInvalido = dropzone;
                }

                // 5. Con errores: cerrar la confirmación y llevar al primer campo pendiente
                if (hayErrores) {
                    cerrarModal();
                    setTimeout(function () {
                        document.body.classList.remove('modal-open');
                        document.body.style.paddingRight = '';
                        if (primerInvalido) {
                            primerInvalido.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            try { primerInvalido.focus({ preventScroll: true }); } catch (err) { primerInvalido.focus(); }
                        }
                    }, 400);
                    return;
                }

                // 6. Todo correcto: confirmar que la sesión siga abierta (si no, se avisa sin perder lo escrito) y enviar
                btnConfirmar.disabled = true;
                btnConfirmar.innerHTML = 'VERIFICANDO...';
                var verificacion = window.SesionAviso ? SesionAviso.verificar() : Promise.resolve(true);
                verificacion.then(function (sesionActiva) {
                    if (!sesionActiva) {
                        restaurarBoton();
                        cerrarModal();
                        return;
                    }
                    btnConfirmar.innerHTML = 'GUARDANDO...';
                    form.submit();
                });
            });

            // Al corregir un campo marcado en rojo, la marca desaparece
            function limpiarMarca(e) {
                if (e.target.hasAttribute('required') && e.target.value.trim() !== '') {
                    e.target.classList.remove('is-invalid');
                    e.target.style.border = '';
                    var feedback = e.target.parentNode.querySelector('.invalid-feedback');
                    if (feedback) feedback.style.display = '';
                }
            }
            form.addEventListener('input', limpiarMarca);
            form.addEventListener('change', limpiarMarca);
        });
    </script>

    <script>
        // ASTERISCO ROJO en los títulos de los campos obligatorios visibles
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('input[required], select[required], textarea[required]').forEach(function (el) {
                if (el.style.display === 'none' || el.type === 'hidden') return;
                var contenedor = el.closest('[class*="col-sm-"]');
                if (!contenedor) return;
                var titulo = contenedor.querySelector('h6');
                if (titulo && !titulo.hasAttribute('data-asterisco')) {
                    titulo.innerHTML += ' <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span>';
                    titulo.setAttribute('data-asterisco', 'true');
                }
            });
        });
    </script>

    <script>
        // CAMPO CONDICIONAL: los días de internación son obligatorios solo si ESTUVO INTERNADO = SI.
        // Si se cambia a NO, el valor escrito se borra.
        document.addEventListener('DOMContentLoaded', function () {
            function vincularCondicional(nameRadio, nameCampo, valorCondicion) {
                var radios = document.querySelectorAll('input[name="' + nameRadio + '"]');
                var campo = document.querySelector('[name="' + nameCampo + '"]');
                if (radios.length === 0 || !campo) return;

                var contenedor = campo.closest('[class*="col-sm-"]');
                var titulo = contenedor ? contenedor.querySelector('h6') : null;

                function evaluarCondicion() {
                    var seleccionado = document.querySelector('input[name="' + nameRadio + '"]:checked');
                    if (seleccionado && seleccionado.value === valorCondicion) {
                        campo.setAttribute('required', 'true');
                        if (titulo && !titulo.hasAttribute('data-asterisco-dinamico')) {
                            titulo.innerHTML += ' <span class="ast-dinamico" style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span>';
                            titulo.setAttribute('data-asterisco-dinamico', 'true');
                        }
                    } else {
                        campo.removeAttribute('required');
                        campo.classList.remove('is-invalid');
                        campo.style.border = '';
                        campo.value = '';
                        if (titulo && titulo.hasAttribute('data-asterisco-dinamico')) {
                            var ast = titulo.querySelector('.ast-dinamico');
                            if (ast) ast.remove();
                            titulo.removeAttribute('data-asterisco-dinamico');
                        }
                    }
                }

                radios.forEach(function (radio) { radio.addEventListener('change', evaluarCondicion); });
                evaluarCondicion();
            }

            vincularCondicional('estuvo_internado', 'dias_internacion', 'SI');
        });
    </script>

    <script>
        // ARCHIVOS ADJUNTOS (fotografías, laboratorios, ecografías)
        // Cada archivo se revisa al agregarlo (formato real, que se pueda abrir); todos se unen en un solo PDF
        // en el navegador, que es el que se envía. Tamaño máximo total: el indicado en la zona de arrastre.
        document.addEventListener('DOMContentLoaded', function () {
            const dropzone         = document.getElementById('dropzone');
            const inputArchivos    = document.getElementById('input_archivos');
            const previewGallery   = document.getElementById('preview-gallery');
            const inputOcultoPDF   = document.getElementById('pdf_final_oculto');
            const visorPdf         = document.getElementById('visor_pdf_final');
            const btnPrevisualizar = document.getElementById('btn-previsualizar-pdf');
            const LIMITE_ADJUNTO   = <?php echo (int)cr_limite_adjunto(); ?>;

            let archivosAdjuntos = [];
            let generacionPDF = 0;

            // Estado para la validación al registrar: 'listo' | 'procesando' | 'error'
            window.estadoAdjuntosRef = 'listo';

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(function (ev) {
                dropzone.addEventListener(ev, function (e) { e.preventDefault(); e.stopPropagation(); }, false);
            });
            ['dragenter', 'dragover'].forEach(function (ev) {
                dropzone.addEventListener(ev, function () { dropzone.classList.add('dragover'); }, false);
            });
            ['dragleave', 'drop'].forEach(function (ev) {
                dropzone.addEventListener(ev, function () { dropzone.classList.remove('dragover'); }, false);
            });

            dropzone.addEventListener('drop', function (e) {
                if (e.dataTransfer.files.length > 0) procesarArchivosNuevos(e.dataTransfer.files);
            });
            inputArchivos.addEventListener('change', function (e) {
                if (e.target.files.length > 0) procesarArchivosNuevos(e.target.files);
            });

            // Tipo real del archivo según sus primeros bytes (no por la extensión)
            function tipoReal(bytes) {
                if (bytes.length >= 5 && bytes[0] === 0x25 && bytes[1] === 0x50 && bytes[2] === 0x44 && bytes[3] === 0x46 && bytes[4] === 0x2D) return 'pdf';
                if (bytes.length >= 8 && bytes[0] === 0x89 && bytes[1] === 0x50 && bytes[2] === 0x4E && bytes[3] === 0x47) return 'png';
                if (bytes.length >= 3 && bytes[0] === 0xFF && bytes[1] === 0xD8 && bytes[2] === 0xFF) return 'jpg';
                return null;
            }

            // ¿El navegador puede dibujar la imagen? (detecta imágenes cortadas o dañadas)
            function imagenVisualizable(file) {
                if (window.createImageBitmap) {
                    return createImageBitmap(file)
                        .then(function (bmp) { const ok = bmp.width > 0 && bmp.height > 0; if (bmp.close) bmp.close(); return ok; })
                        .catch(function () { return false; });
                }
                return new Promise(function (resolve) {
                    const url = URL.createObjectURL(file);
                    const img = new Image();
                    const t = setTimeout(function () { fin(true); }, 15000);
                    function fin(ok) { clearTimeout(t); URL.revokeObjectURL(url); resolve(ok); }
                    img.onload = function () { fin(img.naturalWidth > 0 && img.naturalHeight > 0); };
                    img.onerror = function () { fin(false); };
                    img.src = url;
                });
            }

            // Revisa un archivo: devuelve {file, tipo, bytes} o {error: 'motivo'}
            async function revisarArchivo(file) {
                let bytes;
                try { bytes = new Uint8Array(await file.arrayBuffer()); }
                catch (e) { return { error: 'no se pudo leer el archivo' }; }
                if (bytes.length === 0) return { error: 'el archivo está vacío' };

                const tipo = tipoReal(bytes);
                if (!tipo) return { error: 'formato no válido o archivo dañado (solo JPG, PNG o PDF)' };

                if (tipo === 'pdf') {
                    try {
                        const doc = await PDFLib.PDFDocument.load(bytes);
                        if (doc.getPageCount() === 0) return { error: 'el PDF no tiene páginas' };
                    } catch (e) {
                        const msg = String(e && e.message || e);
                        if (/encrypt/i.test(msg)) return { error: 'el PDF está protegido con contraseña' };
                        return { error: 'el PDF está dañado o no se puede abrir' };
                    }
                } else {
                    if (!(await imagenVisualizable(file))) return { error: 'la imagen está dañada o no se puede visualizar' };
                    try {
                        const prueba = await PDFLib.PDFDocument.create();
                        if (tipo === 'png') await prueba.embedPng(bytes); else await prueba.embedJpg(bytes);
                    } catch (e) {
                        return { error: 'la imagen está dañada o no se puede convertir a PDF' };
                    }
                }
                return { file: file, tipo: tipo, bytes: bytes };
            }

            async function procesarArchivosNuevos(files) {
                const lista = Array.from(files);
                if (lista.length === 0) return;
                if (typeof PDFLib === 'undefined') {
                    alert('No se pudo cargar el componente de adjuntos. Recargue la página e intente nuevamente.');
                    return;
                }
                window.estadoAdjuntosRef = 'procesando';
                const rechazados = [];
                for (const file of lista) {
                    if (archivosAdjuntos.some(function (a) { return a.file.name === file.name && a.file.size === file.size; })) continue; // ya adjuntado
                    const r = await revisarArchivo(file);
                    if (r.error) rechazados.push('- ' + file.name + ': ' + r.error);
                    else archivosAdjuntos.push(r);
                }
                inputArchivos.value = ''; // permite volver a elegir el mismo archivo
                if (rechazados.length > 0) {
                    alert('Los siguientes archivos NO se adjuntaron:\n\n' + rechazados.join('\n') +
                          '\n\nVerifique que se abran correctamente en su equipo y vuelva a adjuntarlos.');
                }
                renderizarGaleriaYGenerarPDF();
            }

            function eliminarArchivo(index) {
                archivosAdjuntos.splice(index, 1);
                renderizarGaleriaYGenerarPDF();
            }

            async function renderizarGaleriaYGenerarPDF() {
                const miGeneracion = ++generacionPDF;
                previewGallery.innerHTML = '';

                if (archivosAdjuntos.length === 0) {
                    btnPrevisualizar.style.display = 'none';
                    $('#visorColapsableForm').collapse('hide');
                    visorPdf.src = '';
                    inputOcultoPDF.files = (new DataTransfer()).files;
                    window.estadoAdjuntosRef = 'listo';
                    return;
                }
                window.estadoAdjuntosRef = 'procesando';

                // Miniaturas
                archivosAdjuntos.forEach(function (adj, index) {
                    const div = document.createElement('div');
                    div.className = 'thumb-item';

                    if (adj.tipo === 'png' || adj.tipo === 'jpg') {
                        const img = document.createElement('img');
                        img.src = URL.createObjectURL(adj.file);
                        div.appendChild(img);
                    } else {
                        div.innerHTML = '<i class="fas fa-file-pdf thumb-pdf-icon"></i>';
                    }

                    const btnQuitar = document.createElement('button');
                    btnQuitar.type = 'button';
                    btnQuitar.className = 'btn-remove-thumb';
                    btnQuitar.title = 'Quitar este archivo';
                    btnQuitar.innerHTML = '<i class="fas fa-times"></i>';
                    btnQuitar.onclick = function (e) { e.stopPropagation(); eliminarArchivo(index); };

                    const nombre = document.createElement('div');
                    nombre.className = 'thumb-name';
                    nombre.textContent = adj.file.name;

                    div.appendChild(btnQuitar);
                    div.appendChild(nombre);
                    previewGallery.appendChild(div);
                });

                btnPrevisualizar.style.display = 'inline-block';

                // Unión de todos los archivos en un solo PDF
                try {
                    const pdfDoc = await PDFLib.PDFDocument.create();
                    for (const adj of archivosAdjuntos) {
                        if (adj.tipo === 'pdf') {
                            const cargado = await PDFLib.PDFDocument.load(adj.bytes);
                            const paginas = await pdfDoc.copyPages(cargado, cargado.getPageIndices());
                            paginas.forEach(function (p) { pdfDoc.addPage(p); });
                        } else {
                            const imagen = (adj.tipo === 'png') ? await pdfDoc.embedPng(adj.bytes) : await pdfDoc.embedJpg(adj.bytes);
                            const pagina = pdfDoc.addPage([595.28, 841.89]);   // tamaño A4
                            const ancho = pagina.getWidth(), alto = pagina.getHeight();
                            const dims = imagen.scaleToFit(ancho - 40, alto - 40);
                            pagina.drawImage(imagen, {
                                x: ancho / 2 - dims.width / 2,
                                y: alto / 2 - dims.height / 2,
                                width: dims.width,
                                height: dims.height
                            });
                        }
                    }

                    const pdfBytes = await pdfDoc.save();
                    if (miGeneracion !== generacionPDF) return;   // hubo un cambio más reciente
                    const blob = new Blob([pdfBytes], { type: 'application/pdf' });

                    visorPdf.src = URL.createObjectURL(blob);

                    const archivoFinal = new File([blob], "Adjuntos_Referencia.pdf", { type: "application/pdf" });
                    const dt = new DataTransfer();
                    dt.items.add(archivoFinal);
                    inputOcultoPDF.files = dt.files;
                    window.estadoAdjuntosRef = 'listo';

                    // Aviso inmediato si supera el límite (también se revisa al registrar)
                    if (LIMITE_ADJUNTO > 0 && blob.size > LIMITE_ADJUNTO) {
                        alert('Los archivos adjuntos suman ' + (blob.size / 1048576).toFixed(1) + ' MB y el máximo permitido es ' +
                              (LIMITE_ADJUNTO / 1048576).toFixed(1) + ' MB.\n\nQuite algún archivo (botón rojo X de la miniatura) o use fotos de menor tamaño.');
                    }
                } catch (error) {
                    if (miGeneracion !== generacionPDF) return;
                    console.error('Error al preparar los adjuntos de la referencia:', error);
                    inputOcultoPDF.files = (new DataTransfer()).files;   // no enviar un PDF incompleto
                    window.estadoAdjuntosRef = 'error';
                    alert('No se pudieron preparar los archivos adjuntos. Quite el último archivo agregado e intente nuevamente.');
                }
            }
        });
    </script>

    <script>
        // ACOMPAÑANTE: parentesco y teléfono se habilitan y son obligatorios solo si se escribió el nombre del acompañante.
        // Si se borra el nombre, esos campos se vacían y se bloquean.
        $(document).ready(function () {
            const nameAcompanante = 'nombre_acompanante';
            const nameParentesco  = 'idparentesco_acomp';
            const nameCelular     = 'celular_acompanante';

            function evaluarObligatoriedadAcompanante() {
                let campoNombre = $('input[name="' + nameAcompanante + '"]');
                let campoParentesco = $('select[name="' + nameParentesco + '"]');
                let campoCelular = $('input[name="' + nameCelular + '"]');
                if (campoNombre.length === 0) return;

                if (campoNombre.val().trim().length > 0) {
                    campoParentesco.prop('disabled', false).prop('required', true);
                    campoCelular.prop('disabled', false).prop('required', true);
                    anadirAsterisco(campoParentesco);
                    anadirAsterisco(campoCelular);
                } else {
                    campoParentesco.prop('disabled', true).val('').prop('required', false).removeClass('is-invalid');
                    campoCelular.prop('disabled', true).val('').prop('required', false).removeClass('is-invalid');
                    quitarAsterisco(campoParentesco);
                    quitarAsterisco(campoCelular);
                }
            }

            function anadirAsterisco(elemento) {
                let titulo = elemento.closest('div[class*="col-sm-"]').find('h6, label');
                if (titulo.length > 0 && titulo.find('.ast-dinamico').length === 0) {
                    titulo.append('<span class="ast-dinamico" style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio"> *</span>');
                }
            }

            function quitarAsterisco(elemento) {
                let titulo = elemento.closest('div[class*="col-sm-"]').find('h6, label');
                if (titulo.length > 0) titulo.find('.ast-dinamico').remove();
            }

            $(document).off('input', 'input[name="' + nameAcompanante + '"]').on('input', 'input[name="' + nameAcompanante + '"]', evaluarObligatoriedadAcompanante);
            setTimeout(evaluarObligatoriedadAcompanante, 300);
        });
    </script>

    <script>
        // ALERGIAS: la descripción se habilita y es obligatoria solo si ALERGIAS = SI (también el dictado por voz).
        // Si se cambia a NO, la descripción se borra y se bloquea.
        $(document).ready(function () {
            function evaluarAlergia() {
                let opcionMarcada = $('input[name="alergia"]:checked').val();
                let campoDescripcion = $('#descripcion_alergia');
                let contenedor = campoDescripcion.closest('.col-sm-6');
                let titulo = contenedor.find('h6.text-primary');
                let botonMic = contenedor.find('.btn-mic');

                if (opcionMarcada === 'SI') {
                    campoDescripcion.prop('disabled', false).prop('required', true);
                    botonMic.show();
                    if (titulo.find('.ast-dinamico').length === 0) {
                        titulo.append('<span class="ast-dinamico" style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio"> *</span>');
                    }
                } else {
                    campoDescripcion.prop('disabled', true).prop('required', false).removeClass('is-invalid');
                    campoDescripcion.val('');
                    botonMic.hide();
                    titulo.find('.ast-dinamico').remove();
                }
            }

            $(document).off('change', 'input[name="alergia"]').on('change', 'input[name="alergia"]', evaluarAlergia);
            setTimeout(evaluarAlergia, 200);
        });
    </script>

</body>
</html>
