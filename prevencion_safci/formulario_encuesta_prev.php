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
            <h6 class="text-info">PERÍMETRO CEFÁLICO</br>[PC]:</h6>
            <input type="number" min="20" max="280" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 100) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 20) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En Centímetros" name="perimetro_cefalico" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 20 a 100 cm</div>
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
            <h6 class="text-info">PERÍMETRO CEFÁLICO</br>[PC]:</h6>
            <input type="number" min="20" max="280" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 100) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 20) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En Centímetros" name="perimetro_cefalico" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 20 a 100 cm</div>
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
        $numero=0;
        $sql5 =" SELECT idpregunta_encuesta, pregunta_encuesta, pregunta_complementaria FROM pregunta_encuesta ORDER BY idpregunta_encuesta ";
        $result5 = mysqli_query($link,$sql5);
        if ($row5 = mysqli_fetch_array($result5)){
        mysqli_field_seek($result5,0);
        while ($field5 = mysqli_fetch_field($result5)){
        } do { 
    ?>
        <div class="form-group row">
            <div class="col-sm-2">
                <h6 class="text-info">Pregunta <?php echo $numero+1;?></h6>
                <input type="hidden" name="idpregunta_encuesta[]" value="<?php echo $row5[0];?>">
            </div>
            <div class="col-sm-8">
                <h6 class="text-secundary"><?php echo $row5[1];?></h6>
            </div>
            <div class="col-sm-2">
                <h6 class="text-info">SI <input type="radio" name="respuesta[<?php echo $numero;?>]" value="SI" > 
                                      NO <input type="radio" name="respuesta[<?php echo $numero;?>]" value="NO" checked ></h6>
            </div>        
        </div>

        <?php

        if ($row5[2] == '') { ?>

            <input type="hidden" class="form-control" name="retroalimentacion[<?php echo $numero;?>]" value="">
  
        <?php } else { ?>
            
        <div class="form-group row">
            <div class="col-sm-2">
            </div>
            <div class="col-sm-3">
                <h6 class="text-secundary"><?php echo $row5[2];?></h6>
            </div>
            <div class="col-sm-5">
                <textarea class="form-control" rows="2" name="retroalimentacion[<?php echo $numero;?>]" placeholder="Describa aqui ..."></textarea>
            </div>
            <div class="col-sm-2">
            </div>
        </div>
      
        <?php }
        $numero = $numero+1;
        }
        while ($row5 = mysqli_fetch_array($result5));
        } else {
        } ?>
<hr>
        <div class="form-group row">
            <div class="col-sm-12">
                <h6 class="text-info">OBSERVAR Y DETERMINAR</h6>
                <h6 class="text-info">Marque o subraye lo objetivo</h6>
            </div>      
        </div>

        <div class="form-group row">
            <div class="col-sm-2">
                <h6 class="text-info"></h6>
            </div>
            <div class="col-sm-10">

    <?php
        $numero6=0;
        $sql6 =" SELECT idseccion_encuesta, seccion_encuesta FROM seccion_encuesta ORDER BY idseccion_encuesta ";
        $result6 = mysqli_query($link,$sql6);
        if ($row6 = mysqli_fetch_array($result6)){
        mysqli_field_seek($result6,0);
        while ($field6 = mysqli_fetch_field($result6)){
        } do { 
    ?>

                <h6 class="text-info"><?php echo $row6[1];?></h6>

            <?php
                $numero7=0;
                $sql7 =" SELECT iditem_senal_cancer, item_senal_cancer FROM item_senal_cancer WHERE idseccion_encuesta = '$row6[0]' ORDER BY iditem_senal_cancer ";
                $result7 = mysqli_query($link,$sql7);
                if ($row7 = mysqli_fetch_array($result7)){
                mysqli_field_seek($result7,0);
                while ($field7 = mysqli_fetch_field($result7)){
                } do { 
            ?>

                <h6 class="text-secundary"> - <?php echo $row7[1];?> -> <input type="checkbox" name="iditem_senal_cancer[]" value="<?php echo $row7[0];?>" ></h6>

            <?php 
                $numero7 = $numero7+1;
                }
                while ($row7 = mysqli_fetch_array($result7));
                } else {
                } 
            ?>

    <?php 
        $numero6 = $numero6+1;
        }
        while ($row6 = mysqli_fetch_array($result6));
        } else {
        } 
    ?>
    
            </div>      
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-2">
                <h6 class="text-info">CLASIFICACIÓN</h6>
            </div>  
            <div class="col-sm-10">
                <select name="idclasificacion_riesgo_cancer"  id="idclasificacion_riesgo_cancer" class="form-control" required>
                    <option value="">-SELECCIONE-</option>
                    <?php
                    $sql1 = "SELECT idclasificacion_riesgo_cancer, clasificacion_riesgo_cancer FROM clasificacion_riesgo_cancer ORDER BY idclasificacion_riesgo_cancer DESC ";
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


                <hr>
                   <div class="text-center">   
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                            REGISTRAR ENCUESTA
                            </button>  
                        </div>                              
                    </div>                            
                </div>
                   <!-- modal de confirmacion de envio de datos-->
                   <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">REGISTRAR ENCUESTA</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    
                                    Esta seguro de Registrar?
                                    posteriormenete no se podran realizar cambios.

                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                <button type="submit" class="btn btn-info pull-center">CONFIRMAR REGISTRO</button>    
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                    <!-- Modal -->



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


