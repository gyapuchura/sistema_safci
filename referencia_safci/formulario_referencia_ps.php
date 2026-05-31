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
                                    <select name="discapacidad" id="discapacidad" class="form-control">
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
                                        name="celular_acompanante" required>                
                                    </div>

                                    <div class="col-sm-6">
                                    <h6 class="text-primary">TEL/CEL DEL ESTABLECIMIENTO DE SALUD:</h6>
                                        <input type="text" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control" value=""             
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
                                        <input type="number" min="20" max="280" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 280) this.value = '';" onblur="if(this.value !== '' && this.value < 20) this.value = '';" class="form-control" placeholder="En Centímetros"
                                            name="talla" value="" required>                
                                        <div class="invalid-feedback">Permitido: 20 a 280 cm</div>
                                    </div>                             
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">PESO </br>[kg]:</h6>
                                        <input type="number" step="any" min="0.2" max="650" onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();" oninput="if(this.value > 650) this.value = '';" onblur="if(this.value !== '' && this.value < 0.2) this.value = '';" class="form-control" placeholder="En kilogramos"            
                                            name="peso" required>                
                                        <div class="invalid-feedback">Permitido: 0.2 a 650 kg</div>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">TEMPERATURA</br>[°C]:</h6>
                                        <input type="number" step="any" min="10" max="47" onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();" oninput="if(this.value > 47) this.value = '';" onblur="if(this.value !== '' && this.value < 10) this.value = '';" class="form-control" placeholder="En Grados Centígrados"
                                            name="temperatura" value="" required>                
                                        <div class="invalid-feedback">Permitido: 10°C a 47°C</div>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FRECUENCIA CARDIACA </br>[lpm]:</h6>
                                        <input type="number" min="0" max="350" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 350) this.value = '';" onblur="if(this.value !== '' && this.value < 0) this.value = '';" class="form-control" placeholder="Latidos por minuto"
                                            name="frec_cardiaca" value="" required>                
                                        <div class="invalid-feedback">Permitido: 0 a 350 lpm</div>
                                    </div>
                                </div>

                                <?php  if ($edad_ss > '5') {  //******* PARA MAYOR DE 5 ANOS */ ?>
                            
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                                        <input type="number" min="0" max="80" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 80) this.value = '';" onblur="if(this.value !== '' && this.value < 0) this.value = '';" class="form-control" placeholder="Ciclos por minuto"
                                            name="frec_respiratoria" value="" required>                
                                        <div class="invalid-feedback">Permitido: 0 a 80 cpm</div>
                                    </div> 
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>
                                        <input type="number" min="0" max="300" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 300) this.value = '';" onblur="if(this.value !== '' && this.value < 0) this.value = '';" class="form-control"           
                                            name="presion_arterial"  placeholder="Sistólica"  required>               
                                        <div class="invalid-feedback">Permitido: 0 a 300 mmHg</div>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary"> </br>diastólica [mmHg]</h6>
                                        <input type="number" min="0" max="200" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 200) this.value = '';" onblur="if(this.value !== '' && this.value < 0) this.value = '';" class="form-control"  placeholder="Diastólica"           
                                            name="presion_arterial_d" value="" required>                
                                        <div class="invalid-feedback">Permitido: 0 a 200 mmHg</div>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">SATURACIÓN</br>[% O2]:</h6>
                                        <input type="number" min="0" max="100" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 100) this.value = '';" onblur="if(this.value !== '' && this.value < 0) this.value = '';" class="form-control" placeholder="% de O2"
                                            name="saturacion" value="" required>                
                                        <div class="invalid-feedback">Permitido: 0% a 100%</div>
                                    </div>
                                </div>

                                <div class="form-group row">  
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">GLASGOW:</br> </h6>
                                        <input type="number" min="3" max="15" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 15) this.value = '';" onblur="if(this.value !== '' && this.value < 3) this.value = '';" class="form-control" placeholder="Glascow"
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
                                    <button type="button" class="btn-mic" onclick="iniciarDictado('descripcion_alergia')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                                    </div>
                                </div>

                                <?php } else { ?>

                                <div class="form-group row">
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                                        <input type="number" min="0" max="80" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 80) this.value = '';" onblur="if(this.value !== '' && this.value < 0) this.value = '';" class="form-control" placeholder="Ciclos por minuto"
                                            name="frec_respiratoria" value="" required>                
                                        <div class="invalid-feedback">Permitido: 0 a 80 cpm</div>
                                    </div> 
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">SATURACIÓN</br>[% O2]:</h6>   
                                        <input type="number" min="0" max="100" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 100) this.value = '';" onblur="if(this.value !== '' && this.value < 0) this.value = '';" class="form-control" placeholder="% de O2"
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
                                        <input type="number" min="3" max="15" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 15) this.value = '';" onblur="if(this.value !== '' && this.value < 3) this.value = '';" class="form-control" placeholder="Glascow"
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
                                        <input type="date" class="form-control" 
                                            name="fecha_fum" required>                
                                    </div>                             
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">G</br>[Gestaciones]:</h6>
                                        <input type="number" class="form-control" placeholder="Nº Gestaciones"           
                                            name="gestaciones" value="" required>                
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">P</br>[Partos]:</h6>
                                        <input type="number" class="form-control" placeholder="Nº Partos"
                                            name="partos" placeholder="" value="" required>                
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">A</br>[Abortos]:</h6>
                                        <input type="number" class="form-control" placeholder="Nº Abortos"
                                            name="abortos" value="" required>                
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">C</br>[Cesáreas]:</h6>
                                        <input type="number" class="form-control" placeholder="Nº Cesáreas"
                                            name="cesareas" placeholder="" value="0" required>                
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">F.P.P.</br>[fecha]</h6>
                                        <input type="date" class="form-control" 
                                            name="fecha_fpp" value="" required>                
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
                                        SI <input type="radio" name="estuvo_internado" value="SI" > </br>
                                        NO <input type="radio" name="estuvo_internado" value="NO" checked >                
                                    </div>

                                    <div class="col-sm-3">
                                    <h6 class="text-primary">DÍAS DE INTERNACIÓN:</h6>
                                        <input type="number" class="form-control" value="" placeholder="Nº de Días"            
                                        name="dias_internacion"  >                
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
                                            <h6 class="text-primary"><?php echo $row_c[1];?> : <input type="checkbox" name="idexamen_complementario[<?php echo $numero_c;?>]" value="<?php echo $row_c[0];?>"></h6>    
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
                                    <textarea class="form-control" rows="3" name="especificacion_hallazgos" id="especificacion_hallazgos" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
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
                                    <textarea class="form-control" rows="3" name="diagnostico_presuntivo[0]" id="diagnostico_presuntivo[0]" placeholder="Escriba o utilice el botón de dictado por voz si corresponde" required></textarea>
                                    <button type="button" class="btn-mic" onclick="iniciarDictado('diagnostico_presuntivo[0]')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>    
                                    </div>
                                    <div class="col-sm-6">
                                        <h6 class="m-0 font-weight-bold text-primary">CIE - 10</h6>
                                        <div style="position: relative;">
                                            <input type="text" class="form-control buscador-cie-inteligente" data-target="idpatologia[0]" placeholder="Escriba para buscar patología o CIE-10..." autocomplete="off" required>
                                            <div class="lista-resultados-cie" style="display: none; position: absolute; z-index: 1000; background: white; border: 1px solid #d1d3e2; border-radius: 0.35rem; width: 100%; max-height: 200px; overflow-y: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"></div>
                                        </div>
                                        <select name="idpatologia[0]" id="idpatologia[0]" style="display: none;" required>
                                        <option value="">-SELECCIONE-</option>
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
                                    <h6 class="m-0 font-weight-bold text-primary">DIAGNÓSTICO ESPECÍFICO </h6>
                                    <textarea class="form-control" rows="3" name="diagnostico_presuntivo[1]" id="diagnostico_presuntivo[1]" placeholder="Escriba o utilice el botón de dictado por voz si corresponde"></textarea>
                                    <button type="button" class="btn-mic" onclick="iniciarDictado('diagnostico_presuntivo[1]')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>   
                                    </div>
                                    <div class="col-sm-6">
                                        <h6 class="m-0 font-weight-bold text-primary">CIE - 10</h6>
                                        <div style="position: relative;">
                                            <input type="text" class="form-control buscador-cie-inteligente" data-target="idpatologia[1]" placeholder="Escriba para buscar patología o CIE-10..." autocomplete="off" >
                                            <div class="lista-resultados-cie" style="display: none; position: absolute; z-index: 1000; background: white; border: 1px solid #d1d3e2; border-radius: 0.35rem; width: 100%; max-height: 200px; overflow-y: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"></div>
                                        </div>
                                        <select name="idpatologia[1]" id="idpatologia[1]" style="display: none;">
                                        <option value="">-SELECCIONE-</option>
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
                                    <h6 class="m-0 font-weight-bold text-primary">DIAGNÓSTICO DIAGNÓSTICO ESPECÍFICO </h6>
                                    <textarea class="form-control" rows="3" name="diagnostico_presuntivo[2]" id="diagnostico_presuntivo[2]" placeholder="Escriba o utilice el botón de dictado por voz si corresponde"></textarea>
                                    <button type="button" class="btn-mic" onclick="iniciarDictado('diagnostico_presuntivo[2]')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>      
                                    </div>
                                    <div class="col-sm-6">
                                        <h6 class="m-0 font-weight-bold text-primary">CIE - 10</h6>
                                        <div style="position: relative;">
                                            <input type="text" class="form-control buscador-cie-inteligente" data-target="idpatologia[2]" placeholder="Escriba para buscar patología o CIE-10..." autocomplete="off" >
                                            <div class="lista-resultados-cie" style="display: none; position: absolute; z-index: 1000; background: white; border: 1px solid #d1d3e2; border-radius: 0.35rem; width: 100%; max-height: 200px; overflow-y: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"></div>
                                        </div>
                                        <select name="idpatologia[2]"  id="idpatologia[2]" style="display: none;">
                                        <option value="">-SELECCIONE-</option>
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
                                <h6 class="m-0 font-weight-bold text-primary">6.- TRATAMIENTO</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-12">
                                    <textarea class="form-control" rows="3" name="tratamiento_ref" id="tratamiento_ref" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
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
                                    <div class="col-sm-6">
                                        <h6 class="m-0 font-weight-bold text-primary">SELECCIONE QUIEN FIRMARÁ EL CONSENTIMIENTO : </h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <select name="idconsentimiento"  id="idconsentimiento" class="form-control" required>
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
                                        <h6 class="m-0 font-weight-bold text-primary">ESCRIBA Y SELECCIONE EL ESTABLECIMIENTO : </h6>  <br>                               
                                        
                                        <div style="position: relative;">
                                            <input type="text" class="form-control" placeholder="Escriba el nombre del establecimiento receptor..." id="busqueda" autocomplete="off" required/>
                                            
                                            <div id="lista-flotante-eess" style="display: none; position: absolute; z-index: 1000; background: white; border: 1px solid #d1d3e2; border-radius: 0.35rem; width: 100%; max-height: 250px; overflow-y: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-top: 2px;"></div>
                                        </div>

                                        <select name="idestablecimiento_salud_r" id="resultado" style="display: none;"></select>                                    
                                    </div>   
                                </div> 
                            </div>
                        </div>

            <div class="card shadow mb-4" > 
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
                                            <button type="submit" class="btn btn-primary pull-center">CONFIRMAR REGISTRO</button>    
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
            // LÓGICA: AJAX + Buscador Flotante para Establecimientos
			$(document).ready(function(){
				var consulta;
				var inputBusqueda = $("#busqueda");
				var listaFlotante = $("#lista-flotante-eess");
				var selectResultado = $("#resultado");

				inputBusqueda.keyup(function(e){
					consulta = inputBusqueda.val();
					
					// Si borra el texto, ocultamos la ventanita y limpiamos datos
					if(consulta.trim() === '') {
					    listaFlotante.hide();
					    selectResultado.empty();
                        selectResultado.val('');
					    return;
					}

                    // Hace la petición AJAX a tu backend original
					$.ajax({
						type: "POST",
						url: "buscar_establecimiento.php",
						data: "b="+consulta,
						dataType: "html",
						beforeSend: function(){
                            // Muestra mensaje de carga con buen diseño
							listaFlotante.show().html("<div style='padding: 10px; text-align: center; color: #858796;'><img src='ajax-loader.gif' style='width:20px;' alt='...'/> Buscando...</div>");
						},
						error: function(){
							listaFlotante.show().html("<div style='padding: 10px; color: #e74a3b;'>Error en la conexión</div>");
						},
						success: function(data){
                            // 1. Guardamos el resultado en el select oculto
							selectResultado.empty().append(data);
                            
                            // 2. Limpiamos la lista flotante para construirla
							listaFlotante.empty();
							var opciones = selectResultado.find('option');

                            // Si tu backend no devuelve nada
                            if(opciones.length === 0 || (opciones.length === 1 && opciones.val() === '')) {
                                listaFlotante.show().html("<div style='padding: 10px; color: #858796;'>No se encontraron establecimientos</div>");
                                return;
                            }

                            // 3. Construimos los items flotantes clickeables
                            opciones.each(function() {
                                var valorID = $(this).val();
                                var textoEESS = $(this).text();
                                
                                if(valorID !== "") {
                                    var item = $("<div class='item-eess'></div>").text(textoEESS);
                                    
                                    // Estilos del item
                                    item.css({
                                        'padding': '8px 12px', 'cursor': 'pointer',
                                        'border-bottom': '1px solid #eaecf4', 'font-size': '0.9rem', 'color': '#5a5c69'
                                    });
                                    
                                    // Efecto Hover (iluminar al pasar el ratón)
                                    item.hover(
                                        function() { $(this).css({'background-color': '#eaecf4', 'color': '#2e59d9'}); },
                                        function() { $(this).css({'background-color': 'transparent', 'color': '#5a5c69'}); }
                                    );
                                    
                                    // EL CLICK MÁGICO
                                    item.mousedown(function(e) {
                                        e.preventDefault();
                                        inputBusqueda.val(textoEESS); // Pone el texto en la barra
                                        selectResultado.val(valorID); // Asigna el ID numérico en secreto
                                        listaFlotante.hide(); // Oculta la lista
                                        
                                        // ¡DISPARADOR! Esto hace que tu script de especialidades funcione
                                        selectResultado.trigger('change'); 
                                    });
                                    
                                    listaFlotante.append(item);
                                }
                            });
						}
					});
				});

                // Validación: Si el usuario sale del cuadro sin elegir nada válido de la lista
                inputBusqueda.blur(function() {
                    setTimeout(function() {
                        listaFlotante.hide();
                        var selectedText = selectResultado.find("option:selected").text();
                        // Si lo escrito no concuerda con la opción oculta elegida, borramos todo
                        if(selectResultado.val() !== "" && inputBusqueda.val() !== selectedText) {
                            inputBusqueda.val('');
                            selectResultado.val('');
                            $("#especialidad_eess").empty(); // Oculta especialidades si las había
                        }
                    }, 200);
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
            $("#discapacidad").change(function () {
                        $("#discapacidad option:selected").each(function () {
                            discapacidad=$(this).val();
                        $.post("persona_discapacidad.php", {discapacidad:discapacidad}, function(data){
                        $("#persona_discapacidad").html(data);
                        });
                    });
            })
            });
        </script>

        
        <script>
            // Script nativo de validación Bootstrap 4 con Auto-Enfoque y cierre de modal
            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    var forms = document.getElementsByClassName('needs-validation');
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                                
                                // Ocultar el modal de confirmación si hay errores
                                if (typeof $ !== 'undefined' && $('#examplemodal_f').length) {
                                    $('#examplemodal_f').modal('hide');
                                }
                                
                                // Retardo para permitir que el modal desaparezca antes de hacer scroll
                                setTimeout(function() {
                                    var primerInvalido = form.querySelector(':invalid');
                                    if (primerInvalido) {
                                        primerInvalido.focus();
                                        primerInvalido.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                    }
                                }, 350);
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();
        </script>

        <script>
            // LÓGICA: Autocompletado Integrado Visualmente (Select Oculto)
            document.addEventListener('DOMContentLoaded', function() {
                var buscadores = document.querySelectorAll('.buscador-cie-inteligente');
                
                buscadores.forEach(function(input) {
                    var targetId = input.getAttribute('data-target');
                    var selectOriginal = document.getElementById(targetId);
                    var listaFlotante = input.nextElementSibling; // El div que funciona como desplegable
                    
                    // Copiamos en memoria las opciones traídas por PHP
                    var opciones = Array.from(selectOriginal.options).filter(function(opt) {
                        return opt.value !== ""; // Ignorar la opción "SELECCIONE"
                    });
                    
                    // Cuando el médico escribe
                    input.addEventListener('input', function() {
                        var term = this.value.toLowerCase().trim();
                        listaFlotante.innerHTML = ''; // Limpiar lista
                        
                        // Si borra todo, reseteamos el select oculto para que marque error de validación
                        if (term === '') {
                            listaFlotante.style.display = 'none';
                            selectOriginal.value = ''; 
                            return;
                        }
                        
                        // Buscar coincidencias
                        var coincidencias = opciones.filter(function(opt) {
                            return opt.text.toLowerCase().includes(term);
                        });
                        
                        if (coincidencias.length > 0) {
                            listaFlotante.style.display = 'block'; // Mostrar la ventanita
                            
                            // Crear opciones clickeables
                            coincidencias.slice(0, 100).forEach(function(opt) { // Mostrar max 100 para no trabar el navegador
                                var item = document.createElement('div');
                                item.textContent = opt.text;
                                item.style.padding = '8px 12px';
                                item.style.cursor = 'pointer';
                                item.style.borderBottom = '1px solid #eaecf4';
                                item.style.fontSize = '0.9rem';
                                item.style.color = '#5a5c69';
                                
                                // Efecto visual al pasar el ratón (Hover)
                                item.addEventListener('mouseenter', function() { this.style.backgroundColor = '#eaecf4'; this.style.color = '#2e59d9'; });
                                item.addEventListener('mouseleave', function() { this.style.backgroundColor = 'transparent'; this.style.color = '#5a5c69'; });
                                
                                // EL CLICK MÁGICO
                                item.addEventListener('mousedown', function(e) {
                                    e.preventDefault(); // Evitar que el input pierda el focus antes de tiempo
                                    input.value = opt.text; // Ponemos el nombre de la enfermedad a la vista
                                    selectOriginal.value = opt.value; // Guardamos silenciosamente el ID en el select oculto
                                    listaFlotante.style.display = 'none'; // Cerramos la lista
                                });
                                
                                listaFlotante.appendChild(item);
                            });
                        } else {
                            listaFlotante.style.display = 'none';
                        }
                    });

                    // Validar si sale del campo y no eligió una opción válida
                    input.addEventListener('blur', function() {
                        setTimeout(function() {
                            listaFlotante.style.display = 'none';
                            // Si lo que está escrito no coincide con la opción seleccionada ocultamente, vaciar
                            var selectedOption = selectOriginal.options[selectOriginal.selectedIndex];
                            if (selectedOption && selectedOption.value !== "" && input.value !== selectedOption.text) {
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