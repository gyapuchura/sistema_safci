<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha 		= date("Y-m-d");
$idtema_encuesta = $_POST['tema_encuesta'];
$edad_ss = $_SESSION['edad_ss'];

switch ($idtema_encuesta) {
    case 1: ?>

<form name="ENCUESTA_1"  action="guarda_encuesta_cancer.php" method="post" >
    <input type="hidden" name="idtema_encuesta" value="<?php echo $idtema_encuesta;?>">
    
    <div class="form-group row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6 text-center">
            <h4 class="text-info">FORMULARIO DE REGISTRO DE DETECCIÓN DEL CÁNCER EN LA NIÑEZ Y ADOLESCENCIA</h4>
        </div>
        <div class="col-sm-3"></div>
    </div>
    <hr>
    
    <div class="form-group row">
        <div class="col-sm-4">
            <h6 class="text-info">INCIDENCIA DE LA ENCUESTA:</h6>
            <?php
            $sql_i =" SELECT idrepeticion, repeticion FROM repeticion ";
            $result_i = mysqli_query($link,$sql_i);
            if ($row_i = mysqli_fetch_array($result_i)){
                mysqli_field_seek($result_i,0);
                while ($field_i = mysqli_fetch_field($result_i)){ }
                do { 
            ?>
            <?php echo " - ".$row_i[1]." -> ";?> <input type="radio" name="idrepeticion" value="<?php echo $row_i[0];?>" <?php if ($row_i[0] == '1') { echo "checked";} else { } ?> > <br>
            <?php 
                } while ($row_i = mysqli_fetch_array($result_i));
            } else { } 
            ?>
        </div>
        <div class="col-sm-4">
            <h6 class="text-info">LUGAR DE LA ENCUESTA:</h6>
            <?php
            $sql_c =" SELECT idtipo_consulta, tipo_consulta FROM tipo_consulta ";
            $result_c = mysqli_query($link,$sql_c);
            if ($row_c = mysqli_fetch_array($result_c)){
                mysqli_field_seek($result_c,0);
                while ($field_c = mysqli_fetch_field($result_c)){ }
                do { 
            ?>
            <?php echo " - ".$row_c[1]." -> ";?> <input type="radio" name="idtipo_consulta" value="<?php echo $row_c[0];?>" <?php if ($row_c[0] == '1') { echo "checked";} else { } ?> > <br>
            <?php 
                } while ($row_c = mysqli_fetch_array($result_c));
            } else { } 
            ?>
        </div>
        <div class="col-sm-4">
            <h6 class="text-info">FECHA DE LA ENCUESTA:</h6>
            <input type="date" name="fecha_registro" value="<?php echo $fecha;?>" class="form-control" required>
            <div class="invalid-feedback">Requerido.</div>
        </div>
    </div>
    <br>
    <hr>
    
    <div class="form-group row">
        <div class="col-sm-12">
            <h6 class="text-info">EXAMEN FÍSICO - SIGNOS VITALES:</h6>
        </div>
    </div>
    <hr>
    
    <div class="form-group row">
        <div class="col-sm-3">
            <h6 class="text-info">TALLA </br>[Centímetros]:</h6>
            <input type="number" min="20" max="280" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 280) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 20) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En Centímetros" name="talla" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 20 a 280 cm</div>
        </div>
        <div class="col-sm-3">
            <h6 class="text-info">PESO </br>[kg]:</h6>
            <input type="number" step="any" min="0.2" max="650" onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();" oninput="if(this.value > 650) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0.2) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En kilogramos" name="peso" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0.2 a 650 kg</div>
        </div>
        <div class="col-sm-3">
            <h6 class="text-info">TEMPERATURA</br>[EN GRADOS CENTIGRADOS]:</h6>
            <input type="number" step="any" min="10" max="47" onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();" oninput="if(this.value > 47) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 10) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" name="temperatura" placeholder="En GRADOS CENTÍGRADOS" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 10°C a 47°C</div>
        </div>
        <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA CARDIACA </br>[LATIDOS POR MINUTO]:</h6>
            <input type="number" min="0" max="350" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 350) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="LATIDOS POR MINUTO" name="frec_cardiaca" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 350 lpm</div>
        </div>
    </div>
    
    <?php if ($edad_ss > '5') { ?>
    <div class="form-group row">
        <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[CICLOS POR MINUTO]:</h6>
            <input type="number" min="0" max="80" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 80) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="CICLOS POR MINUTO" name="frec_respiratoria" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 80 cpm</div>
        </div>
        <div class="col-sm-3">
            <h6 class="text-info">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>
            <input type="number" min="0" max="300" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 300) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" name="presion_arterial" placeholder="Sistólica" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 300</div>
        </div>
        <div class="col-sm-3">
            <h6 class="text-info"> </br>diastólica [mmHg]</h6>
            <input type="number" min="0" max="200" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 200) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" name="presion_arterial_d" placeholder="Diastólica" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 200</div>
        </div>
        <div class="col-sm-3">
            <h6 class="text-info">SATURACIÓN</br>[% DE O2]:</h6>
            <input type="number" min="0" max="100" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 100) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="% DE O2" name="saturacion" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0% a 100%</div>
        </div>
    </div>
    
    <?php } else { ?>
    <div class="form-group row">
        <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6>
            <input type="number" min="0" max="80" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 80) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="Cpm" name="frec_respiratoria" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 80 cpm</div>
        </div>
        <div class="col-sm-3">
            <h6 class="text-info">SATURACIÓN</br>[% O2]:</h6>
            <input type="number" min="0" max="100" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 100) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="% O2" name="saturacion" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0% a 100%</div>
        </div>
        <div class="col-sm-3">
            <input type="hidden" class="form-control" name="presion_arterial" value="0">
        </div>
        <div class="col-sm-3">
            <input type="hidden" class="form-control" name="presion_arterial_d" value="0">
        </div>
    </div>
    

    <?php } ?>
    
    <hr>
    
    <div class="form-group row">
        <div class="col-sm-12">
            <h6 class="text-info">PREGUNTAR (Marque y describa lo objetivo):</h6>
        </div>
    </div>

    <hr>

    <?php
        $numero=1;
        $sql5 =" SELECT idpregunta_encuesta, pregunta_encuesta, pregunta_complementaria FROM pregunta_encuesta ORDER BY idpregunta_encuesta ";
        $result5 = mysqli_query($link,$sql5);
        if ($row5 = mysqli_fetch_array($result5)){
        mysqli_field_seek($result5,0);
        while ($field5 = mysqli_fetch_field($result5)){
        } do { 
    ?>


        <div class="form-group row">
            <div class="col-sm-2">
                <h6 class="text-info">Pregunta <?php echo $numero;?></h6>
                <input type="hidden" name="idpregunta_encuesta[]" value="<?php echo $row5[0];?>">
            </div>
            <div class="col-sm-8">
                <h6 class="text-secundary"><?php echo $row5[1];?></h6>
            </div>
            <div class="col-sm-2">
                
                <h6 class="text-info">SI <input type="radio" name="respuesta[]" value="SI" required> 
                                      NO <input type="radio" name="respuesta[]" value="NO" required></h6>
            </div>
        </div>



    <?php
        $numero = $numero+1;
        }
        while ($row5 = mysqli_fetch_array($result5));
        } else {
        }
    ?>






    </form>
  <?php
    break;
    case 2:

    break;
    case 3:

    break; 
    case 4:

    break;
    case 5:

    break; 
    }     
    ?>


