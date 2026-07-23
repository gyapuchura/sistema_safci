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
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idnombre_integrante_ss     = $_SESSION['idnombre_integrante_ss'];
$edad_ss                    = $_SESSION['edad_ss'];

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

    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/jquery-ui.min.css">
    <link rel="stylesheet" href="../css/boton_mic.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
    <style>
        /* Estilos del Drag & Drop Premium adaptado al color primario del sistema */
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
        
        /* Cuadrícula organizada para las miniaturas de los archivos */
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
        /* Botón elegante "X" flotante para eliminar miniaturas individualmente */
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
        
        /* Visor PDF integrado de última generación */
        #visor_pdf_final {
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
            <body class="bg-gradient-primary">
                
            <div class="container">
                    </br>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                            <div class="text-center">                          
                            <a href="../produccion_servicios/mostrar_atencion_psafci.php"><h6 class="text-info"><- VOLVER</h6></a>
                            <hr>  
                        <div class="text-center">
                        <h4 class="m-0 font-weight-bold text-primary">FORMULARIO DE REFERENCIA D7</h4>
                        </div>
                    </div>
                    <div class="card-body">

                     <form name="GUARDA_REFERENCIA" id="form_referencia" action="guarda_referencia.php" method="post" class="needs-validation" enctype="multipart/form-data" novalidate> 
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
                                    <select name="discapacidad" id="discapacidad" class="form-control" required> <!-- Modificado se volvio obligatorio-->
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
                                        name="nombre_acompanante" required>
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
                                        name="celular_acompanante">                
                                    </div>

                                    <div class="col-sm-6">
                                    <h6 class="text-primary">TEL/CEL DEL ESTABLECIMIENTO DE SALUD:</h6>
                                        <input type="text" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control" value=""             
                                        name="tel_establecimiento" required >                
                                    </div>
                                </div>
                                
                            </div>                                
                        </div>

                        <div class="card shadow mb-4"> <!-- Modificado toda la seccion -->
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">2.- DATOS CLÍNICOS Y SIGNOS VITALES</h6>
                            </div>
                            <div class="card-body">
                                
                                <div class="form-group row">  
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">TALLA </br>[Centímetros]:</h6>
                                        <input type="number" min="20" max="280" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 280) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 20) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En Centímetros"
                                            name="talla" value="" required>                
                                        <div class="invalid-feedback">Permitido: 20 a 280 cm</div>
                                    </div>                             
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">PESO </br>[kg]:</h6>
                                        <input type="number" step="any" min="0.2" max="650" onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();" oninput="if(this.value > 650) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0.2) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En kilogramos"            
                                            name="peso" required>                
                                        <div class="invalid-feedback">Permitido: 0.2 a 650 kg</div>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">TEMPERATURA</br>[°C]:</h6>
                                        <input type="number" step="any" min="10" max="47" onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();" oninput="if(this.value > 47) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 10) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En Grados Centígrados"
                                            name="temperatura" value="" required>                
                                        <div class="invalid-feedback">Permitido: 10°C a 47°C</div>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FRECUENCIA CARDIACA </br>[lpm]:</h6>
                                        <input type="number" min="0" max="350" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 350) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="Latidos por minuto"
                                            name="frec_cardiaca" value="" required>                
                                        <div class="invalid-feedback">Permitido: 0 a 350 lpm</div>
                                    </div>
                                </div>

                                <?php  if ($edad_ss > '5') {  //******* PARA MAYOR DE 5 ANOS */ ?>
                            
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                                        <input type="number" min="0" max="80" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 80) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="Ciclos por minuto"
                                            name="frec_respiratoria" value="" required>                
                                        <div class="invalid-feedback">Permitido: 0 a 80 cpm</div>
                                    </div> 
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>
                                        <input type="number" min="0" max="300" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 300) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control"           
                                            name="presion_arterial"  placeholder="Sistólica"  required>               
                                        <div class="invalid-feedback">Permitido: 0 a 300 mmHg</div>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary"> </br>diastólica [mmHg]</h6>
                                        <input type="number" min="0" max="200" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 200) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control"  placeholder="Diastólica"           
                                            name="presion_arterial_d" value="" required>                
                                        <div class="invalid-feedback">Permitido: 0 a 200 mmHg</div>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">SATURACIÓN</br>[% O2]:</h6>
                                        <input type="number" min="0" max="100" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 100) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="% de O2"
                                            name="saturacion" value="" required>                
                                        <div class="invalid-feedback">Permitido: 0% a 100%</div>
                                    </div>
                                </div>

                                <div class="form-group row">  
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">GLASGOW:</br> </h6>
                                        <input type="number" min="3" max="15" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 15) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 3) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="Glasgow"
                                            name="glascow" value="" required>                
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
                                    
                                    <div class="invalid-feedback">Debe especificar a qué es alérgico.</div> <!-- Modificado, agregado de aqui para abajo -->
                                    
                                    <button type="button" class="btn-mic" onclick="iniciarDictado('descripcion_alergia')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                                    </div>
                                </div>

                                <?php } else { ?>

                                <div class="form-group row">
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                                        <input type="number" min="0" max="80" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 80) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="Ciclos por minuto"
                                            name="frec_respiratoria" value="" required>                
                                        <div class="invalid-feedback">Permitido: 0 a 80 cpm</div>
                                    </div> 
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">SATURACIÓN</br>[% O2]:</h6>   
                                        <input type="number" min="0" max="100" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 100) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="% de O2"
                                            name="saturacion" value="" required>             
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
                                            name="glascow" value="" required>                
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

                        <?php  if ($row_n[7] == '1' && $edad > '12') {  //******* PARA MUJERES MAYORES A 12 AÑOS EN ESTADO DE EMBARAZO O NACIMIENTO */ ?>
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
                                        name="dias_internacion" min="1" > <!-- Modificado -->
                                        <div class="invalid-feedback">Indique los días de internación.</div>  <!-- Modificado -->               
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
                                
                                <div class="form-group row">                               
                                    <div class="col-sm-6">
                                    <h6 class="m-0 font-weight-bold text-primary">DIAGNÓSTICO ESPECÍFICO </h6>
                                    <textarea class="form-control" rows="3" name="diagnostico_presuntivo[0]" id="diagnostico_presuntivo[0]" placeholder="Escriba o utilice el botón de dictado por voz si corresponde" ></textarea>  <!-- Modificado, no es necesario que este sea obligatorio-->
                                    <button type="button" class="btn-mic" onclick="iniciarDictado('diagnostico_presuntivo[0]')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>    
                                    </div>
                                    <div class="col-sm-6">
                                        <h6 class="m-0 font-weight-bold text-primary">CIE - 10</h6>
                                        <div style="position: relative;">
                                            <input type="text" class="form-control buscador-cie-inteligente" data-target="idpatologia[0]" placeholder="Escriba para buscar patología o CIE-10..." autocomplete="off" required>
                                            <div class="lista-resultados-cie" style="display: none; position: absolute; z-index: 1000; background: white; border: 1px solid #d1d3e2; border-radius: 0.35rem; width: 100%; max-height: 200px; overflow-y: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"></div>
                                        </div>
                                        <select name="idpatologia[0]" id="idpatologia[0]" style="display: none;"> <!-- Modificado se quito required-->
                                        <option value="">-SELECCIONE-</option>
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
                                    <h6 class="m-0 font-weight-bold text-primary">DIAGNÓSTICO ESPECÍFICO </h6>
                                    <textarea class="form-control" rows="3" name="diagnostico_presuntivo[1]" id="diagnostico_presuntivo[1]" placeholder="Escriba o utilice el botón de dictado por voz si corresponde"></textarea>
                                    <button type="button" class="btn-mic" onclick="iniciarDictado('diagnostico_presuntivo[1]')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>   
                                    </div>
                                    <div class="col-sm-6">
                                        <h6 class="m-0 font-weight-bold text-primary">CIE - 10</h6>
                                        <div style="position: relative;">
                                            <input type="text" class="form-control buscador-cie-inteligente" data-target="idpatologia[1]" placeholder="Escriba para buscar patología o CIE-10..." autocomplete="off">
                                            <div class="lista-resultados-cie" style="display: none; position: absolute; z-index: 1000; background: white; border: 1px solid #d1d3e2; border-radius: 0.35rem; width: 100%; max-height: 200px; overflow-y: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"></div>
                                        </div>
                                        <select name="idpatologia[1]" id="idpatologia[1]" style="display: none;">
                                        <option value="">-SELECCIONE-</option>
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
                                    <h6 class="m-0 font-weight-bold text-primary">DIAGNÓSTICO DIAGNÓSTICO ESPECÍFICO </h6>
                                    <textarea class="form-control" rows="3" name="diagnostico_presuntivo[2]" id="diagnostico_presuntivo[2]" placeholder="Escriba o utilice el botón de dictado por voz si corresponde"></textarea>
                                    <button type="button" class="btn-mic" onclick="iniciarDictado('diagnostico_presuntivo[2]')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>      
                                    </div>
                                    <div class="col-sm-6">
                                        <h6 class="m-0 font-weight-bold text-primary">CIE - 10</h6>
                                        <div style="position: relative;">
                                            <input type="text" class="form-control buscador-cie-inteligente" data-target="idpatologia[2]" placeholder="Escriba para buscar patología o CIE-10..." autocomplete="off">
                                            <div class="lista-resultados-cie" style="display: none; position: absolute; z-index: 1000; background: white; border: 1px solid #d1d3e2; border-radius: 0.35rem; width: 100%; max-height: 200px; overflow-y: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"></div>
                                        </div>
                                        <select name="idpatologia[2]"  id="idpatologia[2]" style="display: none;">
                                        <option value="">-SELECCIONE-</option>
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

                        <div class="card shadow mb-4"> <!-- Modificado para que aparezca el asterizo y se marque de rojo al no ser llenado ya que es obligatorio-->
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

                        <div class="card shadow mb-4"> <!-- Modificado toda la seccion al igual que el tratamiento para que aparezca el asterizco-->
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
                                <h6 class="m-0 font-weight-bold text-primary">9.- ESTABLECIMIENTO RECEPTOR</h6> <!-- Modificado toda la seccion-->
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
                                            <p class="text-xs text-primary mt-1 font-weight-bold mb-0">Formatos permitidos: JPG, JPEG, PNG, PDF</p>
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
                                                posteriormenete no se podran realizar cambios.

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
<script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="../js/sb-admin-2.min.js"></script>

    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
        <script>$("#fecha1").datepicker($.datepicker.regional[ "es" ]);</script>
        <script src="../js/funciones.js"></script>

  <script>
            // LÓGICA: AJAX + Buscador Flotante con Bloqueo de Integridad
			$(document).ready(function(){
				var consulta;
				var inputBusqueda = $("#busqueda");
				var listaFlotante = $("#lista-flotante-eess");
				var selectResultado = $("#resultado");

				inputBusqueda.keyup(function(e){
                    // Si el candado está puesto, no buscamos nada
                    if($(this).prop('readonly')) return;

					consulta = inputBusqueda.val();
					
					if(consulta.trim() === '') {
					    listaFlotante.hide();
					    selectResultado.empty();
                        selectResultado.val('');
					    return;
					}

					$.ajax({
						type: "POST",
						url: "buscar_establecimiento.php",
						data: "b="+consulta,
						dataType: "html",
						beforeSend: function(){
							listaFlotante.show().html("<div style='padding: 10px; text-align: center; color: #858796;'><img src='ajax-loader.gif' style='width:20px;' alt='...'/> Buscando...</div>");
						},
						error: function(){
							listaFlotante.show().html("<div style='padding: 10px; color: #e74a3b;'>Error en la conexión</div>");
						},
						success: function(data){
							selectResultado.empty().append(data);
							listaFlotante.empty();
							var opciones = selectResultado.find('option');

                            if(opciones.length === 0 || (opciones.length === 1 && opciones.val() === '')) {
                                listaFlotante.show().html("<div style='padding: 10px; color: #858796;'>No se encontraron establecimientos</div>");
                                return;
                            }

                            opciones.each(function() {
                                var valorID = $(this).val();
                                var textoEESS = $(this).text().replace(/\s+/g, ' ').trim();
                                
                                if(valorID !== "") {
                                    var item = $("<div class='item-eess'></div>").text(textoEESS);
                                    
                                    item.css({
                                        'padding': '8px 12px', 'cursor': 'pointer',
                                        'border-bottom': '1px solid #eaecf4', 'font-size': '0.9rem', 'color': '#5a5c69'
                                    });
                                    
                                    item.hover(
                                        function() { $(this).css({'background-color': '#eaecf4', 'color': '#2e59d9'}); },
                                        function() { $(this).css({'background-color': 'transparent', 'color': '#5a5c69'}); }
                                    );
                                    
                                    // EL CLICK MÁGICO Y EL BLOQUEO
                                    item.mousedown(function(e) {
                                        e.preventDefault();
                                        inputBusqueda.val(textoEESS); 
                                        selectResultado.val(valorID); 
                                        listaFlotante.hide(); 
                                        
                                        // 🔒 ACTIVAR EL CANDADO
                                        inputBusqueda.prop('readonly', true);
                                        inputBusqueda.css({'background-color': '#eaecf4', 'color': '#2e59d9', 'cursor': 'not-allowed'});
                                        inputBusqueda.attr('title', 'Doble clic o presione Borrar (Backspace) para cambiar el establecimiento');
                                        
                                        // Disparamos la carga de especialidades
                                        selectResultado.trigger('change'); 
                                    });
                                    
                                    listaFlotante.append(item);
                                }
                            });
						}
					});
				});

                // 🔓 LÓGICA DE DESBLOQUEO Y LIMPIEZA
                function desbloquearEESS() {
                    if (inputBusqueda.prop('readonly')) {
                        inputBusqueda.prop('readonly', false);
                        inputBusqueda.val('');
                        selectResultado.val('');
                        inputBusqueda.css({'background-color': '', 'color': '', 'font-weight': 'normal', 'cursor': 'text'});
                        inputBusqueda.removeAttr('title');
                        $("#especialidad_eess").empty(); // Oculta las especialidades inferiores
                        inputBusqueda.focus(); // Le devuelve el cursor al médico
                    }
                }

                // Desbloqueo por teclado (Retroceso o Suprimir)
                inputBusqueda.keydown(function(e) {
                    if ($(this).prop('readonly')) {
                        if (e.which === 8 || e.which === 46) {
                            e.preventDefault(); 
                            desbloquearEESS();
                        } else if (e.which !== 9) { // 9 es Tabulador (dejamos que el tab funcione para navegar)
                            e.preventDefault(); // Bloquear cualquier otra tecla para no ensuciar
                        }
                    }
                });

                // Desbloqueo por ratón (Doble Clic)
                inputBusqueda.dblclick(function(e) {
                    desbloquearEESS();
                });

                // Validación de Blur (Limpiaparabrisas)
                inputBusqueda.blur(function() {
                    setTimeout(function() {
                        listaFlotante.hide();
                        // Si se sale de la casilla y NO tiene puesto el candado, significa 
                        // que escribió algo pero nunca le dio clic a la lista. Es basura, la borramos.
                        if (!inputBusqueda.prop('readonly')) {
                            inputBusqueda.val('');
                            selectResultado.val('');
                            $("#especialidad_eess").empty();
                        }
                    }, 200);
                });
			});
	    </script>

        <script language="javascript"> 
            $(document).ready(function(){
            $("#datos_perinatales").change(function () {
                        $("#datos_perinatales option:selected").each(function () {
                            datos_perinatales=$(this).val();
                        $.post("datos_perinatales.php", {datos_perinatales:datos_perinatales}, function(data){
                        $("#datos_embarazo").html(data);
                        });
                    });
            })
            });
        </script>

        <script> 
            // LÓGICA: AJAX Discapacidad + Maquillaje Visual (Corregido)
            $(document).ready(function(){
                $("#discapacidad").change(function () {
                    $("#discapacidad option:selected").each(function () {
                        var discapacidad = $(this).val();
                        
                        $.post("persona_discapacidad.php", {discapacidad: discapacidad}, function(data){
                            
                            // 1. Inyectamos el HTML que trae PHP
                            $("#persona_discapacidad").html(data);
                            
                            // 2. Buscamos SOLO los campos que TÚ ya hiciste obligatorios (con required)
                            $("#persona_discapacidad select[required], #persona_discapacidad input[required]").each(function() {
                                var campoActual = $(this);
                                var contenedor = campoActual.closest('[class*="col-sm-"]');
                                var titulo = contenedor.find('h6');
                                
                                // A) Inyectar Asterisco rojo visual si no lo tiene
                                if(titulo.length > 0 && !titulo.attr('data-asterisco')) {
                                    titulo.append(' <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span>');
                                    titulo.attr('data-asterisco', 'true');
                                }
                                
                                // B) Inyectar texto rojo oculto (invalid-feedback)
                                if(contenedor.find('.invalid-feedback').length === 0) {
                                    var nombreCampo = "esta opción";
                                    if(campoActual.attr('name') === 'idtipo_discapacidad') nombreCampo = "el tipo de discapacidad";
                                    if(campoActual.attr('name') === 'idnivel_discapacidad') nombreCampo = "el nivel de discapacidad";
                                    
                                    campoActual.after('<div class="invalid-feedback" style="margin-top: 5px;">Debe seleccionar ' + nombreCampo + '.</div>');
                                }
                            });
                            
                        });
                    });
                });
            });
        </script>

        <script> 
            // LÓGICA: AJAX Especialidades + Inyección Dinámica + Limpieza
            $(document).ready(function(){
                $("#resultado").change(function () {
                    // Usamos tu método original que nunca falla para leer el select
                    $("#resultado option:selected").each(function () {
                        var establecimiento_salud = $(this).val();
                        
                        $.post("establecimiento_salud_especialidad.php", {establecimiento_salud: establecimiento_salud}, function(data){
                            
                            // 1. Inyectamos el HTML que trae PHP
                            $("#especialidad_eess").html(data);
                            
                            // 2. La Magia: Pintar asteriscos, textos de error y LIMPIAR TEXTO
                            $("#especialidad_eess select[required]").each(function() {
                                var selectActual = $(this);
                                var contenedor = selectActual.parent(); 
                                var titulo = contenedor.find('h6');
                                
                                if(titulo.length > 0) {
                                    // 👉 TRUCO: Borramos cualquier número entre corchetes (ej. [933]) que traiga PHP
                                    var textoLimpio = titulo.html().replace(/\s*\[\d+\]/g, '');
                                    titulo.html(textoLimpio);
                                    
                                    // A) Inyectar Asterisco rojo si no lo tiene
                                    if(!titulo.attr('data-asterisco')) {
                                        titulo.append(' <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span>');
                                        titulo.attr('data-asterisco', 'true');
                                    }
                                }
                                
                                // B) Inyectar texto rojo oculto (invalid-feedback)
                                if(contenedor.find('.invalid-feedback').length === 0) {
                                    var nombreCampo = selectActual.attr('name') === 'idmotivo_referencia' ? 'el motivo' : 'la especialidad';
                                    selectActual.after('<div class="invalid-feedback" style="margin-top: 5px;">Debe seleccionar ' + nombreCampo + '.</div>');
                                }
                            });
                            
                        });
                    });
                });
            });
        </script>
        
        <script>
            // LÓGICA: Validación Táctica y Fuerza Bruta (Nivel Máximo)
            document.addEventListener('DOMContentLoaded', function() {
                
                // 1. Apuntamos EXCLUSIVAMENTE a tu formulario principal para evitar confusiones
                var form = document.querySelector('form[name="GUARDA_REFERENCIA"]');
                var btnConfirmar = document.getElementById('btn-confirmar-registro');
                
                if (form && btnConfirmar) {
                    btnConfirmar.addEventListener('click', function(e) {
                        e.preventDefault(); 
                        
                        var hayErrores = false;
                        var primerInvalido = null;
                        
                        // 2. Limpiamos alertas previas de toda la pantalla
                        form.querySelectorAll('.is-invalid').forEach(function(el) {
                            el.classList.remove('is-invalid');
                            el.style.border = ''; 
                        });
                        form.querySelectorAll('.invalid-feedback').forEach(function(el) {
                            el.style.display = ''; 
                        });
                        
                        // 3. REVISIÓN MANUAL CAMPO POR CAMPO (A prueba de balas)
                        var elementosObligatorios = form.querySelectorAll('input[required], select[required], textarea[required]');
                        
                        elementosObligatorios.forEach(function(el) {
                            // Si el campo está vacío, solo tiene espacios, o es inválido
                            if (!el.value || el.value.trim() === '' || !el.checkValidity()) {
                                hayErrores = true;
                                
                                // Si el campo está a la vista del médico (Tratamiento, Hospital, Consentimiento)
                                if (el.type !== 'hidden' && el.style.display !== 'none') {
                                    
                                    // A) Inyectamos el borde rojo sin que nada pueda borrarlo (!important)
                                    el.classList.add('is-invalid');
                                    el.style.setProperty('border', '2px solid #dc3545', 'important');
                                    
                                    // B) Obligamos a que el texto de ayuda rojo aparezca sí o sí
                                    var contenedor = el.parentNode;
                                    var feedback = contenedor.querySelector('.invalid-feedback');
                                    if (feedback) {
                                        feedback.style.setProperty('display', 'block', 'important');
                                    }
                                    
                                    // C) Guardamos el primer error para viajar hacia él
                                    if (!primerInvalido) primerInvalido = el;
                                }
                            }
                        });
                        
                        // 4. ACCIONES FINALES
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
                            // TODO ESTÁ PERFECTO: Bloqueamos y guardamos
                            btnConfirmar.innerHTML = "GUARDANDO...";
                            btnConfirmar.disabled = true;
                            form.submit(); 
                        }
                    });
                    
                    // 5. EFECTO MAGIA: Borrar el rojo individualmente cuando el médico empieza a escribir
                    form.addEventListener('input', function(e) {
                        if (e.target.hasAttribute('required') && e.target.value.trim() !== '') {
                            e.target.classList.remove('is-invalid');
                            e.target.style.border = '';
                            var feedback = e.target.parentNode.querySelector('.invalid-feedback');
                            if (feedback) feedback.style.display = '';
                        }
                    });
                    form.addEventListener('change', function(e) {
                        if (e.target.hasAttribute('required') && e.target.value.trim() !== '') {
                            e.target.classList.remove('is-invalid');
                            e.target.style.border = '';
                            var feedback = e.target.parentNode.querySelector('.invalid-feedback');
                            if (feedback) feedback.style.display = '';
                        }
                    });
                }
            });
        </script>

        <script>
            // LÓGICA: Autocompletado CIE-10 con Bloqueo de Integridad
            document.addEventListener('DOMContentLoaded', function() {
                var buscadores = document.querySelectorAll('.buscador-cie-inteligente');
                
                buscadores.forEach(function(input) {
                    var targetId = input.getAttribute('data-target');
                    var selectOriginal = document.getElementById(targetId);
                    var listaFlotante = input.nextElementSibling; 
                    
                    var opciones = Array.from(selectOriginal.options).filter(function(opt) {
                        return opt.value !== ""; 
                    });
                    
                    input.addEventListener('input', function() {
                        if (this.readOnly) return; // Si el candado está puesto, no buscamos

                        var term = this.value.toLowerCase().trim();
                        listaFlotante.innerHTML = ''; 
                        
                        if (term === '') {
                            listaFlotante.style.display = 'none';
                            selectOriginal.value = ''; 
                            return;
                        }
                        
                        var coincidencias = opciones.filter(function(opt) {
                            return opt.text.toLowerCase().includes(term);
                        });
                        
                        if (coincidencias.length > 0) {
                            listaFlotante.style.display = 'block'; 
                            
                            coincidencias.slice(0, 100).forEach(function(opt) { 
                                var item = document.createElement('div');
                                item.textContent = opt.text;
                                item.style.padding = '8px 12px';
                                item.style.cursor = 'pointer';
                                item.style.borderBottom = '1px solid #eaecf4';
                                item.style.fontSize = '0.9rem';
                                item.style.color = '#5a5c69';
                                
                                item.addEventListener('mouseenter', function() { this.style.backgroundColor = '#eaecf4'; this.style.color = '#2e59d9'; });
                                item.addEventListener('mouseleave', function() { this.style.backgroundColor = 'transparent'; this.style.color = '#5a5c69'; });
                                
                                // EL CLICK MÁGICO Y EL BLOQUEO
                                item.addEventListener('mousedown', function(e) {
                                    e.preventDefault(); 
                                    input.value = opt.text; 
                                    selectOriginal.value = opt.value; 
                                    listaFlotante.style.display = 'none'; 

                                    // 🔒 ACTIVAR EL CANDADO
                                    input.readOnly = true;
                                    input.style.backgroundColor = '#eaecf4';
                                    input.style.color = '#2e59d9';
                                    input.style.fontWeight = 'normal';
                                    input.style.cursor = 'not-allowed';
                                    input.title = "Doble clic o presione Borrar (Backspace) para cambiar el diagnóstico";
                                });
                                
                                listaFlotante.appendChild(item);
                            });
                        } else {
                            listaFlotante.style.display = 'none';
                        }
                    });

                    // 🔓 LÓGICA DE DESBLOQUEO Y LIMPIEZA
                    function desbloquearCIE() {
                        if (input.readOnly) {
                            input.readOnly = false;
                            input.value = '';
                            selectOriginal.value = '';
                            input.style.backgroundColor = '';
                            input.style.color = '';
                            input.style.fontWeight = 'normal';
                            input.style.cursor = 'text';
                            input.removeAttribute('title');
                            input.focus();
                        }
                    }

                    // Desbloqueo por teclado
                    input.addEventListener('keydown', function(e) {
                        if (input.readOnly) {
                            if (e.key === 'Backspace' || e.key === 'Delete') {
                                e.preventDefault();
                                desbloquearCIE();
                            } else if (e.key !== 'Tab') { // Permitimos usar Tab
                                e.preventDefault(); // Bloqueamos todo lo demás
                            }
                        }
                    });

                    // Desbloqueo por ratón
                    input.addEventListener('dblclick', function(e) {
                        desbloquearCIE();
                    });

                    // Limpiaparabrisas al perder el foco
                    input.addEventListener('blur', function() {
                        setTimeout(function() {
                            listaFlotante.style.display = 'none';
                            
                            // Si NO está bloqueado y el médico sale de la casilla, 
                            // significa que nunca le dio clic a la lista. Borramos lo escrito.
                            if (!input.readOnly) {
                                input.value = '';
                                selectOriginal.value = '';
                            }
                        }, 200);
                    });
                });
            });
        </script>

        <script>
            // LÓGICA: Asteriscos automáticos para campos obligatorios AGREGADO NUEVO
            document.addEventListener('DOMContentLoaded', function() {
                // 1. Buscamos todos los campos que el sistema reconoce como obligatorios
                var elementosObligatorios = document.querySelectorAll('input[required], select[required], textarea[required]');
                
                elementosObligatorios.forEach(function(el) {
                    // 2. Ignoramos campos que nosotros hayamos ocultado (como tus select del buscador)
                    if(el.style.display !== 'none' && el.type !== 'hidden') {
                        // 3. Buscamos el contenedor donde está encerrado el campo
                        var contenedor = el.closest('[class*="col-sm-"]'); 
                        if(contenedor) {
                            // 4. Buscamos el título (la etiqueta h6)
                            var titulo = contenedor.querySelector('h6');
                            // 5. Le inyectamos el asterisco sutilmente
                            if(titulo && !titulo.hasAttribute('data-asterisco')) {
                                titulo.innerHTML += ' <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span>';
                                titulo.setAttribute('data-asterisco', 'true');
                            }
                        }
                    }
                });
            });
        </script>

        <script>
            // LÓGICA: Campos Condicionales Automáticos
            document.addEventListener('DOMContentLoaded', function() {
                
                // Función maestra para vincular un Radio Button con un Campo Objetivo
                function vincularCondicional(nameRadio, nameCampo, valorCondicion) {
                    var radios = document.querySelectorAll('input[name="' + nameRadio + '"]');
                    var campo = document.querySelector('[name="' + nameCampo + '"]');
                    
                    if (radios.length > 0 && campo) {
                        var contenedor = campo.closest('[class*="col-sm-"]');
                        var titulo = contenedor ? contenedor.querySelector('h6') : null;

                        function evaluarCondicion() {
                            var seleccionado = document.querySelector('input[name="' + nameRadio + '"]:checked');
                            
                            if (seleccionado && seleccionado.value === valorCondicion) {
                                // 1. Hacer el campo obligatorio para la Validación Oficial
                                campo.setAttribute('required', 'true');
                                
                                // 2. Dibujar el asterisco rojo mágicamente si no lo tiene
                                if (titulo && !titulo.hasAttribute('data-asterisco-dinamico')) {
                                    titulo.innerHTML += ' <span class="ast-dinamico" style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span>';
                                    titulo.setAttribute('data-asterisco-dinamico', 'true');
                                }
                            } else {
                                // 1. Quitar la obligatoriedad
                                campo.removeAttribute('required');
                                
                                // 2. Quitar los bordes rojos si el médico había cometido un error y se arrepiente
                                campo.classList.remove('is-invalid');
                                campo.style.border = '';
                                
                                // 3. PROTECCIÓN ANTI-FANTASMAS: Si escribió algo y luego marcó "NO", borramos el texto.
                                campo.value = '';
                                
                                // 4. Desaparecer el asterisco
                                if (titulo && titulo.hasAttribute('data-asterisco-dinamico')) {
                                    var ast = titulo.querySelector('.ast-dinamico');
                                    if (ast) ast.remove();
                                    titulo.removeAttribute('data-asterisco-dinamico');
                                }
                            }
                        }

                        // Escuchamos cada vez que el médico hace clic en los radios (SI o NO)
                        radios.forEach(function(radio) {
                            radio.addEventListener('change', evaluarCondicion);
                        });
                        
                        // Evaluamos una vez al cargar la página por si "SI" ya venía marcado por defecto
                        evaluarCondicion();
                    }
                }

                // Inyectamos la magia a nuestros dos casos específicos:
                vincularCondicional('estuvo_internado', 'dias_internacion', 'SI');
                vincularCondicional('alergia', 'descripcion_alergia', 'SI');
                
            });
        </script>


        <script>
            document.addEventListener('DOMContentLoaded', async function() {
                let archivosAdjuntos = [];
                const dropzone = document.getElementById('dropzone');
                const inputArchivos = document.getElementById('input_archivos');
                const previewGallery = document.getElementById('preview-gallery');
                const btnPrevisualizar = document.getElementById('btn-previsualizar-pdf');
                const visorPdf = document.getElementById('visor_pdf_final');
                const inputOcultoPDF = document.getElementById('pdf_final_oculto');

                // --- GESTIÓN DE EVENTOS DRAG & DROP (ARRASTRAR Y SOLTAR) ---
                dropzone.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    dropzone.classList.add('dragover');
                });
                dropzone.addEventListener('dragleave', () => dropzone.classList.remove('dragover'));
                dropzone.addEventListener('drop', (e) => {
                    e.preventDefault();
                    dropzone.classList.remove('dragover');
                    manejarArchivos(e.dataTransfer.files);
                });
                inputArchivos.addEventListener('change', (e) => manejarArchivos(e.target.files));

                // --- MANEJO CENTRAL DE ARCHIVOS SUBIDOS ---
                function manejarArchivos(files) {
                    Array.from(files).forEach(file => {
                        // Filtro estricto de tipos MIME por motivos de ciberseguridad
                        if (file.type.match('image/image') || file.type.match('image/jpeg') || file.type.match('image/png') || file.type.match('application/pdf')) {
                            // Validación anti-duplicados (Evita procesar el mismo archivo dos veces)
                            if (!archivosAdjuntos.some(a => a.name === file.name && a.size === file.size)) {
                                archivosAdjuntos.push(file);
                                renderizarMiniatura(file, archivosAdjuntos.length - 1);
                            }
                        } else {
                            alert("Filtro de Seguridad: El formato del archivo no es soportado por el sistema SAFCI. Solo use imágenes JPG, PNG o documentos PDF.");
                        }
                    });
                    inputArchivos.value = ''; // Reseteo del input selector para cargas consecutivas
                    actualizarEstadoInterfaz();
                    generarPDFFinalEnMemoria(); // Genera y unifica de inmediato en segundo plano
                }

                // --- RENDERIZACIÓN DE MINIATURAS CON ELIMINACIÓN ASÍNCRONA ---
                function renderizarMiniatura(file, index) {
                    const div = document.createElement('div');
                    div.className = 'thumb-item';
                    div.setAttribute('data-index', index);

                    // Creación del gatillo de eliminación individual (La opción "X")
                    const btnDelete = document.createElement('button');
                    btnDelete.className = 'btn-remove-thumb';
                    btnDelete.innerHTML = '<i class="fas fa-times"></i>';
                    btnDelete.onclick = (e) => {
                        e.stopPropagation();
                        eliminarArchivoColeccion(file.name);
                    };

                    // Enrutamiento de previsualización según tipo de archivo
                    if (file.type.includes('image')) {
                        const img = document.createElement('img');
                        img.src = URL.createObjectURL(file);
                        div.appendChild(img);
                    } else if (file.type === 'application/pdf') {
                        div.innerHTML = `<i class="fas fa-file-pdf thumb-pdf-icon"></i>`;
                    }

                    const nameEtiqueta = document.createElement('div');
                    nameEtiqueta.className = 'thumb-name';
                    nameEtiqueta.innerText = file.name;

                    div.appendChild(btnDelete);
                    div.appendChild(nameEtiqueta);
                    previewGallery.appendChild(div);
                }

                function eliminarArchivoColeccion(nombreArchivo) {
                    archivosAdjuntos = archivosAdjuntos.filter(file => file.name !== nombreArchivo);
                    previewGallery.innerHTML = ''; // Limpieza total del contenedor de miniaturas
                    archivosAdjuntos.forEach((file, index) => renderizarMiniatura(file, index)); // Re-mapeo limpio
                    actualizarEstadoInterfaz();
                    generarPDFFinalEnMemoria(); // Regeneración del PDF resultante sin el archivo descartado
                }

                function actualizarEstadoInterfaz() {
                    if (archivosAdjuntos.length > 0) {
                        btnPrevisualizar.style.display = 'inline-block';
                    } else {
                        btnPrevisualizar.style.display = 'none';
                        $('#visorColapsableForm').collapse('hide'); // Ocultar acordeón si se vacía la galería
                        visorPdf.src = '';
                        // Reiniciar el input de archivos ocultos si el médico vacía la lista
                        const dt = new DataTransfer();
                        inputOcultoPDF.files = dt.files;
                    }
                }

                // --- UNIFICACIÓN DE BINARIOS EN MEMORIA RAM (CLIENT-SIDE PROCESSING VIA PDF-LIB) ---
                async function generarPDFFinalEnMemoria() {
                    if (archivosAdjuntos.length === 0) return;
                    
                    try {
                        // 1. Escudo anti-fallos de internet
                        if (typeof PDFLib === 'undefined') {
                            alert("⚠️ ERROR: La librería PDF-Lib no cargó. Revisa tu conexión a internet.");
                            return;
                        }

                        const pdfDoc = await PDFLib.PDFDocument.create();

                        for (let file of archivosAdjuntos) {
                            const arrayBuffer = await file.arrayBuffer();

                            if (file.type === 'application/pdf') {
                                const loadedPdf = await PDFLib.PDFDocument.load(arrayBuffer);
                                const copiedPages = await pdfDoc.copyPages(loadedPdf, loadedPdf.getPageIndices());
                                copiedPages.forEach((page) => pdfDoc.addPage(page));
                            } else if (file.type.includes('image')) {
                                let imagenObj;
                                if (file.type === 'image/jpeg' || file.type === 'image/jpg') {
                                    imagenObj = await pdfDoc.embedJpg(arrayBuffer);
                                } else if (file.type === 'image/png') {
                                    imagenObj = await pdfDoc.embedPng(arrayBuffer);
                                }

                                const page = pdfDoc.addPage([595.28, 841.89]); 
                                const { width, height } = page.getSize();
                                const scale = Math.min(width / imagenObj.width, height / imagenObj.height) * 0.9;
                                const dims = imagenObj.scale(scale);

                                page.drawImage(imagenObj, {
                                    x: page.getWidth() / 2 - dims.width / 2,
                                    y: page.getHeight() / 2 - dims.height / 2,
                                    width: dims.width,
                                    height: dims.height,
                                });
                            }
                        }

                        const pdfBytes = await pdfDoc.save();
                        const blob = new Blob([pdfBytes], { type: 'application/pdf' });
                        
                        // 2. Escudo de diagnóstico de XAMPP
                        const sizeMB = blob.size / (1024 * 1024);
                        if (sizeMB > 2) {
                            alert("⚠️ ATENCIÓN: El PDF que generaste pesa " + sizeMB.toFixed(2) + " MB.\n\nXAMPP por defecto solo permite subir archivos de máximo 2 MB. Si al guardar te sale que 'No hay archivo', debes aumentar el upload_max_filesize en tu archivo php.ini.");
                        }

                        const blobUrl = URL.createObjectURL(blob);
                        
                        const fileFinal = new File([blob], "Adjuntos_Referencia.pdf", { type: "application/pdf" });
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(fileFinal);
                        inputOcultoPDF.files = dataTransfer.files;

                        visorPdf.src = blobUrl;

                    } catch (error) {
                        console.error("Error crítico:", error);
                        alert("⚠️ ERROR FATAL AL CREAR EL PDF: " + error.message + "\nIntenta subir una imagen más pequeña o en otro formato.");
                    }
                }
            });
        </script>
<script>
$(document).ready(function() {
    
    // 1. Identificamos los campos con los nombres exactos de tu HTML
    const nameAcompanante = 'nombre_acompanante'; 
    const nameParentesco  = 'idparentesco_acomp'; 
    const nameCelular     = 'celular_acompanante';

    function evaluarObligatoriedadAcompanante() {
        let campoNombre = $('input[name="' + nameAcompanante + '"]');
        let campoParentesco = $('select[name="' + nameParentesco + '"]');
        let campoCelular = $('input[name="' + nameCelular + '"]');

        if (campoNombre.length > 0) {
            // Si el médico escribió algo (y no solo espacios vacíos)
            if (campoNombre.val().trim().length > 0) {
                
                // 1. DESBLOQUEAMOS los campos para permitir escribir
                campoParentesco.prop('disabled', false);
                campoCelular.prop('disabled', false);

                // 2. Los hacemos obligatorios
                campoParentesco.prop('required', true);
                campoCelular.prop('required', true);
                
                // 3. Dibujamos los asteriscos rojos
                añadirAsterisco(campoParentesco);
                añadirAsterisco(campoCelular);
                
            } else {
                
                // 1. BLOQUEAMOS los campos (se pondrán en gris)
                campoParentesco.prop('disabled', true);
                campoCelular.prop('disabled', true);

                // 2. LIMPIEZA ANTI-FANTASMAS: Borramos lo que haya adentro por si se arrepintió
                campoParentesco.val('');
                campoCelular.val('');

                // 3. Quitamos la obligación y las alertas rojas de error
                campoParentesco.prop('required', false).removeClass('is-invalid');
                campoCelular.prop('required', false).removeClass('is-invalid');
                
                // 4. Borramos los asteriscos
                quitarAsterisco(campoParentesco);
                quitarAsterisco(campoCelular);
            }
        }
    }

    function añadirAsterisco(elemento) {
        let titulo = elemento.closest('div[class*="col-sm-"]').find('h6, label');
        if (titulo.length > 0 && titulo.find('.ast-dinamico').length === 0) {
            titulo.append('<span class="ast-dinamico" style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio"> *</span>');
        }
    }

    function quitarAsterisco(elemento) {
        let titulo = elemento.closest('div[class*="col-sm-"]').find('h6, label');
        if (titulo.length > 0) {
            titulo.find('.ast-dinamico').remove();
        }
    }

    // Escuchamos cada vez que el médico teclea en el nombre en tiempo real
    $(document).off('input', 'input[name="' + nameAcompanante + '"]').on('input', 'input[name="' + nameAcompanante + '"]', function() {
        evaluarObligatoriedadAcompanante();
    });

    // Ejecutamos una vez al iniciar la página para que nazcan bloqueados
    setTimeout(evaluarObligatoriedadAcompanante, 300);
});
</script>

<script>
$(document).ready(function() {
    
    // =====================================================================
    // LÓGICA CONDICIONAL PARA ALERGIAS
    // =====================================================================
    function evaluarAlergia() {
        // Obtenemos qué opción está marcada actualmente (SI o NO)
        let opcionMarcada = $('input[name="alergia"]:checked').val();
        
        // Seleccionamos los elementos con los que interactuaremos
        let campoDescripcion = $('#descripcion_alergia');
        let contenedor = campoDescripcion.closest('.col-sm-6');
        let titulo = contenedor.find('h6.text-primary');
        let botonMic = contenedor.find('.btn-mic');

        if (opcionMarcada === 'SI') {
            // 1. DESBLOQUEAR Y HACER OBLIGATORIO
            campoDescripcion.prop('disabled', false).prop('required', true);
            
            // 2. MOSTRAR EL MICRÓFONO
            botonMic.show();

            // 3. DIBUJAR ASTERISCO ROJO (Si no lo tiene ya)
            if (titulo.find('.ast-dinamico').length === 0) {
                titulo.append('<span class="ast-dinamico" style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio"> *</span>');
            }
        } else {
            // 1. BLOQUEAR, QUITAR OBLIGACIÓN Y LIMPIAR (Anti-fantasmas)
            campoDescripcion.prop('disabled', true).prop('required', false).removeClass('is-invalid');
            campoDescripcion.val(''); // Borra el texto si el doctor escribió algo y luego se arrepintió
            
            // 2. OCULTAR EL MICRÓFONO (Para que no intente dictar en un campo bloqueado)
            botonMic.hide();

            // 3. QUITAR ASTERISCO ROJO
            titulo.find('.ast-dinamico').remove();
        }
    }

    // Escuchamos el cambio en las opciones de "SI / NO" de Alergias
    $(document).off('change', 'input[name="alergia"]').on('change', 'input[name="alergia"]', function() {
        evaluarAlergia();
    });

    // Ejecutamos la función apenas carga la pantalla.
    // Como tu HTML tiene "NO" marcado por defecto, la caja nacerá bloqueada mágicamente.
    setTimeout(evaluarAlergia, 200);

});
</script>

</body>
</html>
