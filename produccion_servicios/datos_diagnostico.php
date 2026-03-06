<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php

$idnombre_integrante_ss     = $_SESSION['idnombre_integrante_ss'];
$edad_ss = $_SESSION['edad_ss'];

$idpatologia_ap_sano = $_POST['patologia_ap_sano'];

switch ($idpatologia_ap_sano) {
    case "239": //***** CONTROL DEL NIÑO SANO = 239 */  ?>  

  <hr>
    <div class="form-group row"> 
    <div class="col-sm-3"> 
    </div> 
    <div class="col-sm-6">
    <h6 class="text-info">CONTROL DEL NIÑO SANO - SIGNOS VITALES:</h6>
    </div> 
    <div class="col-sm-3"> 
    </div> 
    </div> 
<hr>  

    <div class="form-group row">  
        <div class="col-sm-3">
        <h6 class="text-info">TALLA </br>[Centímetros]:</h6>
            <input type="text" class="form-control" placeholder="En Centrimetros"
                name="talla" value="1">                
        </div>                             
        <div class="col-sm-3">
        <h6 class="text-info">PESO </br>[kg]:</h6>
            <input type="number" class="form-control"              
                name="peso" value="1">                
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">TEMPERATURA</br>[°C]:</h6>
            <input type="number" class="form-control" 
                name="temperatura" placeholder="" value="0">                
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">FRECUENCIA CARDIACA </br>[lpm]:</h6>
            <input type="text" class="form-control" 
                name="frec_cardiaca" value="0">                
        </div>
    </div>

    <?php  if ($edad_ss > '5') {  ?>
    
        <div class="form-group row">
            <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                <input type="text" class="form-control" 
                    name="frec_respiratoria" value="0">                
            </div> 
            <div class="col-sm-3">
            <h6 class="text-info">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>
                <input type="number" class="form-control"              
                    name="presion_arterial"  placeholder="Sistólica" value="0">               
            </div>
            <div class="col-sm-3">
            <h6 class="text-info"> </br>diastólica [mmHg]</h6>
                    <input type="number" class="form-control"              
                    name="presion_arterial_d" placeholder="Diastólica" value="0">                
            </div>
            <div class="col-sm-3">
            <h6 class="text-info">SATURACIÓN</br>[% O2]:</h6>
                <input type="number" class="form-control"
                    name="saturacion" value="0">                
            </div>
        </div>

                <div class="form-group row">    
                    <div class="col-sm-3">
                    <h6 class="text-info">ALÉRGIAS:</h6>
                    SI <input type="radio" name="alergia" value="SI" > </br>
                    NO <input type="radio" name="alergia" value="NO" checked >  
                    </div>
                    <div class="col-sm-6">
                    <h6 class="text-info">DESCRIPCIÓN DE LA ALÉRGIA</h6>
                    <textarea class="form-control" rows="2" name="descripcion_alergia"></textarea> 
                    </div>
                    <div class="col-sm-3">             
                    </div>
                </div>

    <?php } else { ?>

        <div class="form-group row">
            <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                <input type="text" class="form-control" 
                    name="frec_respiratoria" value="0">                
            </div> 
            <div class="col-sm-3">
            <h6 class="text-info">SATURACIÓN</br>[% O2]:</h6>   
                <input type="number" class="form-control"
                    name="saturacion" value="0">             
            </div>
            <div class="col-sm-3">
            <!-- <h6 class="text-info">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>  para menor de 5 anos -->
                <input type="hidden" class="form-control"              
                    name="presion_arterial"  placeholder="Sistólica" value="0">               
            </div>
            <div class="col-sm-3">
            <!-- <h6 class="text-info"> </br>diastólica [mmHg]</h6>   para menor de 5 anos    --> 
                    <input type="hidden" class="form-control"              
                    name="presion_arterial_d" placeholder="Diastólica" value="0">          
            </div>
        </div>

    <?php } ?>

            <div class="form-group row"> 
            <div class="col-sm-9"> 
            <h6 class="text-info">ORIENTACIÓN MÉDICA:</h6>
            <textarea class="form-control" rows="4" name="motivo_consulta" required></textarea>
            </div> 
            <div class="col-sm-3">
            </div> 
            </div>

    <?php
    break; 
    case "242": //***** CONTROL PRESION ARTERIAL = 242  */ ?>
      
  <hr>
    <div class="form-group row"> 
    <div class="col-sm-3"> 
    </div> 
    <div class="col-sm-6">
    <h6 class="text-info">CONTROL PRESION ARTERIAL - SIGNOS VITALES:</h6>
    </div> 
    <div class="col-sm-3"> 
    </div> 
    </div> 
<hr>  
        <div class="form-group row">  
            <div class="col-sm-3">
            <h6 class="text-info">TALLA </br>[Centímetros]:</h6>
                <input type="text" class="form-control" placeholder="En Centrimetros"
                    name="talla" value="1">                
            </div>                             
            <div class="col-sm-3">
            <h6 class="text-info">PESO </br>[kg]:</h6>
                <input type="number" class="form-control"              
                    name="peso" value="1">                
            </div>
            <div class="col-sm-3">
            <h6 class="text-info">TEMPERATURA</br>[°C]:</h6>
                <input type="number" class="form-control" 
                    name="temperatura" placeholder="" value="0">                
            </div>
            <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA CARDIACA </br>[lpm]:</h6>
                <input type="text" class="form-control" 
                    name="frec_cardiaca" value="0">                
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                <input type="text" class="form-control" 
                    name="frec_respiratoria" value="0">                
            </div> 
            <div class="col-sm-3">
            <h6 class="text-info">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>
                <input type="number" class="form-control"              
                    name="presion_arterial"  placeholder="Sistólica" value="0">               
            </div>
            <div class="col-sm-3">
            <h6 class="text-info"> </br>diastólica [mmHg]</h6>
                    <input type="number" class="form-control"              
                    name="presion_arterial_d" placeholder="Diastólica" value="0">                
            </div>
            <div class="col-sm-3">
            <h6 class="text-info">SATURACIÓN</br>[% O2]:</h6>
                <input type="number" class="form-control"
                    name="saturacion" value="0">                
            </div>
        </div>

            <div class="form-group row">    
                <div class="col-sm-3">
                <h6 class="text-info">ALÉRGIAS:</h6>
                SI <input type="radio" name="alergia" value="SI" > </br>
                NO <input type="radio" name="alergia" value="NO" checked >  
                </div>
                <div class="col-sm-6">
                <h6 class="text-info">DESCRIPCIÓN DE LA ALÉRGIA</h6>
                <textarea class="form-control" rows="2" name="descripcion_alergia"></textarea> 
                </div>
                <div class="col-sm-3">             
                </div>
            </div>

            <div class="form-group row"> 
                <div class="col-sm-9"> 
                <h6 class="text-info">ORIENTACIÓN MÉDICA:</h6>
                    <textarea class="form-control" rows="4" name="motivo_consulta" required></textarea>
                </div> 
                <div class="col-sm-3">
                </div> 
            </div>

    <?php
    break; 
    case "456": //***** EXAMEN MEDICO GRAL. = 456  */ ?>

        <hr>
            <div class="form-group row"> 
            <div class="col-sm-3"> 
            </div> 
            <div class="col-sm-6">
            <h6 class="text-info">EXAMEN MEDICO GRAL. - SIGNOS VITALES:</h6>
            </div> 
            <div class="col-sm-3"> 
            </div> 
            </div> 
        <hr>  
        <div class="form-group row">  
            <div class="col-sm-3">
            <h6 class="text-info">TALLA </br>[Centímetros]:</h6>
                <input type="text" class="form-control" placeholder="En Centrimetros"
                    name="talla" value="1">                
            </div>                             
            <div class="col-sm-3">
            <h6 class="text-info">PESO </br>[kg]:</h6>
                <input type="number" class="form-control"              
                    name="peso" value="1">                
            </div>
            <div class="col-sm-3">
            <h6 class="text-info">TEMPERATURA</br>[°C]:</h6>
                <input type="number" class="form-control" 
                    name="temperatura" placeholder="" value="0">                
            </div>
            <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA CARDIACA </br>[lpm]:</h6>
                <input type="text" class="form-control" 
                    name="frec_cardiaca" value="0">                
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                <input type="text" class="form-control" 
                    name="frec_respiratoria" value="0">                
            </div> 
            <div class="col-sm-3">
            <h6 class="text-info">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>
                <input type="number" class="form-control"              
                    name="presion_arterial"  placeholder="Sistólica" value="0">               
            </div>
            <div class="col-sm-3">
            <h6 class="text-info"> </br>diastólica [mmHg]</h6>
                    <input type="number" class="form-control"              
                    name="presion_arterial_d" placeholder="Diastólica" value="0">                
            </div>
            <div class="col-sm-3">
            <h6 class="text-info">SATURACIÓN</br>[% O2]:</h6>
                <input type="number" class="form-control"
                    name="saturacion" value="0">                
            </div>
        </div>

            <div class="form-group row">    
                <div class="col-sm-3">
                <h6 class="text-info">ALÉRGIAS:</h6>
                SI <input type="radio" name="alergia" value="SI" > </br>
                NO <input type="radio" name="alergia" value="NO" checked >  
                </div>
                <div class="col-sm-6">
                <h6 class="text-info">DESCRIPCIÓN DE LA ALÉRGIA</h6>
                <textarea class="form-control" rows="2" name="descripcion_alergia"></textarea> 
                </div>
                <div class="col-sm-3">             
                </div>
            </div>

            <div class="form-group row"> 
            <div class="col-sm-9"> 
            <h6 class="text-info">ORIENTACIÓN MÉDICA:</h6>
            <textarea class="form-control" rows="4" name="motivo_consulta" required></textarea>
            </div> 
            <div class="col-sm-3">
            </div> 
            </div>
      
    <?php
    break;
    case "238": //***** CONTROL MEDICO = 238  */ ?>

        <hr>
            <div class="form-group row"> 
            <div class="col-sm-3"> 
            </div> 
            <div class="col-sm-6">
            <h6 class="text-info">CONTROL MEDICO - SIGNOS VITALES:</h6>
            </div> 
            <div class="col-sm-3"> 
            </div> 
            </div> 
        <hr>  
        <div class="form-group row">  
            <div class="col-sm-3">
            <h6 class="text-info">TALLA </br>[Centímetros]:</h6>
                <input type="text" class="form-control" placeholder="En Centrimetros"
                    name="talla" value="1">                
            </div>                             
            <div class="col-sm-3">
            <h6 class="text-info">PESO </br>[kg]:</h6>
                <input type="number" class="form-control"              
                    name="peso" value="1">                
            </div>
            <div class="col-sm-3">
            <h6 class="text-info">TEMPERATURA</br>[°C]:</h6>
                <input type="number" class="form-control" 
                    name="temperatura" placeholder="" value="0">                
            </div>
            <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA CARDIACA </br>[lpm]:</h6>
                <input type="text" class="form-control" 
                    name="frec_cardiaca" value="0">                
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                <input type="text" class="form-control" 
                    name="frec_respiratoria" value="0">                
            </div> 
            <div class="col-sm-3">
            <h6 class="text-info">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>
                <input type="number" class="form-control"              
                    name="presion_arterial"  placeholder="Sistólica" value="0">               
            </div>
            <div class="col-sm-3">
            <h6 class="text-info"> </br>diastólica [mmHg]</h6>
                    <input type="number" class="form-control"              
                    name="presion_arterial_d" placeholder="Diastólica" value="0">                
            </div>
            <div class="col-sm-3">
            <h6 class="text-info">SATURACIÓN</br>[% O2]:</h6>
                <input type="number" class="form-control"
                    name="saturacion" value="0">                
            </div>
        </div>

            <div class="form-group row">    
                    <div class="col-sm-3">
                    <h6 class="text-info">ALÉRGIAS:</h6>
                    SI <input type="radio" name="alergia" value="SI" > </br>
                    NO <input type="radio" name="alergia" value="NO" checked >  
                    </div>
                    <div class="col-sm-6">
                    <h6 class="text-info">DESCRIPCIÓN DE LA ALÉRGIA</h6>
                    <textarea class="form-control" rows="2" name="descripcion_alergia"></textarea> 
                    </div>
                    <div class="col-sm-3">             
                    </div>
            </div>
 
            <div class="form-group row"> 
            <div class="col-sm-9"> 
            <h6 class="text-info">ORIENTACIÓN MÉDICA:</h6>
            <textarea class="form-control" rows="4" name="motivo_consulta" required></textarea>
            </div> 
            <div class="col-sm-3">
            </div> 
            </div>

    <?php
    break;
    case "362": //***** EMBARAZO CONFIRMADO = 362  */ ?>

        <hr>
            <div class="form-group row"> 
            <div class="col-sm-3"> 
            </div> 
            <div class="col-sm-6">
            <h6 class="text-info">EMBARAZO CONFIRMADO - SIGNOS VITALES:</h6>
            </div> 
            <div class="col-sm-3"> 
            </div> 
            </div> 
        <hr>  
        <div class="form-group row">  
            <div class="col-sm-3">
            <h6 class="text-info">TALLA </br>[Centímetros]:</h6>
                <input type="text" class="form-control" placeholder="En Centrimetros"
                    name="talla" value="1">                
            </div>                             
            <div class="col-sm-3">
            <h6 class="text-info">PESO </br>[kg]:</h6>
                <input type="number" class="form-control"              
                    name="peso" value="1">                
            </div>
            <div class="col-sm-3">
            <h6 class="text-info">TEMPERATURA</br>[°C]:</h6>
                <input type="number" class="form-control" 
                    name="temperatura" placeholder="" value="0">                
            </div>
            <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA CARDIACA </br>[lpm]:</h6>
                <input type="text" class="form-control" 
                    name="frec_cardiaca" value="0">                
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                <input type="text" class="form-control" 
                    name="frec_respiratoria" value="0">                
            </div> 
            <div class="col-sm-3">
            <h6 class="text-info">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>
                <input type="number" class="form-control"              
                    name="presion_arterial"  placeholder="Sistólica" value="0">               
            </div>
            <div class="col-sm-3">
            <h6 class="text-info"> </br>diastólica [mmHg]</h6>
                    <input type="number" class="form-control"              
                    name="presion_arterial_d" placeholder="Diastólica" value="0">                
            </div>
            <div class="col-sm-3">
            <h6 class="text-info">SATURACIÓN</br>[% O2]:</h6>
                <input type="number" class="form-control"
                    name="saturacion" value="0">                
            </div>
        </div>

        <div class="form-group row">    
            <div class="col-sm-3">
            <h6 class="text-info">ALÉRGIAS:</h6>
            SI <input type="radio" name="alergia" value="SI" > </br>
            NO <input type="radio" name="alergia" value="NO" checked >  
            </div>
            <div class="col-sm-6">
            <h6 class="text-info">DESCRIPCIÓN DE LA ALÉRGIA</h6>
            <textarea class="form-control" rows="2" name="descripcion_alergia"></textarea> 
            </div>
            <div class="col-sm-3">             
            </div>
        </div>

        <hr>
            <div class="form-group row"> 
            <div class="col-sm-3"> 
            </div> 
            <div class="col-sm-6">
            <h6 class="text-info">ANTECEDENTES OBSTÉTRICOS:</h6>
            </div> 
            <div class="col-sm-3"> 

            </div> 
            </div> 
        <hr>   
            <div class="form-group row">
                <div class="col-sm-3">
                <h6 class="text-info">Nº GESTACIONES</br>[G]:</h6> 
                    <input type="number" class="form-control" 
                        name="gestaciones" value="0">                
                </div> 
                <div class="col-sm-3">
                <h6 class="text-info">Nº PARTOS</br>[P]:</h6>   
                    <input type="number" class="form-control"
                        name="partos" value="0">             
                </div>
                <div class="col-sm-3">
                <h6 class="text-info">Nª ABORTOS</br>[A]</h6>
                    <input type="number" class="form-control"              
                        name="abortos"  placeholder="Sistólica" value="0">               
                </div>
                <div class="col-sm-3">
                <h6 class="text-info">Nº CESÁREAS</br>[C]</h6>
                        <input type="number" class="form-control"              
                        name="cesareas" placeholder="Diastólica" value="0">          
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-3">
                    <h6 class="text-info">FECHA ÚLTIMA MENSTRUACIÓN [FUM]:</h6> 
                    <input type="date" class="form-control" 
                        name="fecha_fum" >                
                </div> 
                <div class="col-sm-3">
                    <h6 class="text-info">FECHA PROBABLE DE PARTO</br>[FPP]:</h6>   
                    <input type="date" class="form-control"
                        name="fecha_fpp" >             
                </div>
                <div class="col-sm-3">
                    <h6 class="text-info">FRECUENCIA CARDIACA FETAL</br>[FCF]</h6>
                    <input type="number" class="form-control"              
                        name="frecuencia_fcf"  placeholder="Sistólica" value="0">               
                </div>
                <div class="col-sm-3">
                    <!-- <h6 class="text-info"></h6>  -->
                        <input type="hidden" name="presion_arterial_d"  value="0">  

                </div>
            </div>

            <div class="form-group row"> 
                <div class="col-sm-12"> 
                <h6 class="text-info">SUBJETIVO:</h6>
                <textarea class="form-control" rows="3" name="subjetivo" required></textarea>
                </div> 
                </div> 
                 <div class="form-group row"> 
                 <div class="col-sm-12"> 
                <h6 class="text-info">OBJETIVO:</h6>
                <textarea class="form-control" rows="3" name="objetivo" required></textarea>
                </div> 
                </div> 
                 <div class="form-group row"> 
                 <div class="col-sm-12"> 
                <h6 class="text-info">ANÁLISIS:</h6>
                <textarea class="form-control" rows="3" name="analisis" required></textarea>
                </div>
                </div>  
                 <div class="form-group row"> 
                 <div class="col-sm-12"> 
                <h6 class="text-info">PLAN:</h6>
                <textarea class="form-control" rows="3" name="plan" required></textarea>
                </div> 
            </div>

            <div class="form-group row"> 
                <div class="col-sm-12">
                <a href="nueva_historia_perinatal.php" target="_blank" onClick="window.open(this.href, this.target, 'width=800,height=700,top=50, left=500, scrollbars=YES'); return false;">
                    APERTURA HISTORIA CLÍNICA PERINATAL</a>  
                </div> 
            </div>

    <?php
    break;
    case "236": //***** CONTROL EMBARAZO = 236  */ ?>

<!---- ANTECEDENTES GINECO-OBSTETRICOS BEGIN ------>

        <?php
            $sql_gc =" SELECT idgineco_obstetrico, gestaciones, partos, abortos, cesareas, fecha_fum, fecha_fpp, frecuencia_fcf ";
            $sql_gc.=" FROM gineco_obstetrico WHERE idnombre ='$idnombre_integrante_ss' ORDER BY idgineco_obstetrico DESC LIMIT 1 ";
            $result_gc = mysqli_query($link,$sql_gc);
            if ($row_gc = mysqli_fetch_array($result_gc)){
            mysqli_field_seek($result_gc,0);           
            while ($field_gc = mysqli_fetch_field($result_gc)){
            } do {
        ?>
                <hr>
                <div class="text-center">                                     
                    <h6 class="text-info">ANTECEDENTES OBSTÉTRICOS::</h6>                    
                </div>
                <hr> 
 
            <div class="form-group row">
                <div class="col-sm-3">
                <h6 class="text-info">Nº GESTACIONES</br>[G]:</h6> 
                    <input type="number" class="form-control" 
                        name="gestaciones" value="<?php echo $row_gc[1];?>" disabled>                
                </div> 
                <div class="col-sm-3">
                <h6 class="text-info">Nº PARTOS</br>[P]:</h6>   
                    <input type="number" class="form-control"
                        name="partos" value="<?php echo $row_gc[2];?>" disabled>             
                </div>
                <div class="col-sm-3">
                <h6 class="text-info">Nª ABORTOS</br>[A]</h6>
                    <input type="number" class="form-control"              
                        name="abortos"  placeholder="Sistólica" value="<?php echo $row_gc[3];?>" disabled>               
                </div>
                <div class="col-sm-3">
                <h6 class="text-info">Nº CESÁREAS</br>[C]</h6>
                        <input type="number" class="form-control"              
                        name="cesareas" placeholder="Diastólica" value="<?php echo $row_gc[4];?>" disabled>          
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-3">
                    <h6 class="text-info">FECHA ÚLTIMA MENSTRUACIÓN [FUM]:</h6> 
                    <input type="date" class="form-control" value="<?php echo $row_gc[5];?>"
                        name="fecha_fum" disabled >                
                </div> 
                <div class="col-sm-3">
                    <h6 class="text-info">FECHA PROBABLE DE PARTO</br>[FPP]:</h6>   
                    <input type="date" class="form-control" value="<?php echo $row_gc[6];?>"
                        name="fecha_fpp" disabled >             
                </div>
                <div class="col-sm-3">
                    <h6 class="text-info">FRECUENCIA CARDIACA FETAL</br>[FCF]</h6>
                    <input type="number" class="form-control"              
                        name="frecuencia_fcf"  placeholder="Sistólica" value="<?php echo $row_gc[7];?>" disabled>               
                </div>
                <div class="col-sm-3">
                </div>
            </div>
                
           <?php
        }
        while ($row_gc = mysqli_fetch_array($result_gc));
        } else {
        }
        ?>

            <!---- ANTECEDENTES GINECO-OBSTETRICOS END ------>

   <hr>
            <div class="form-group row"> 
            <div class="col-sm-3"> 
            </div> 
            <div class="col-sm-6">
            <h6 class="text-info">CONSULTA ANTENATAL:</h6>
            </div> 
            <div class="col-sm-3"> 
            </div> 
            </div> 
        <hr>   
            <div class="form-group row">
                <div class="col-sm-3">
                <h6 class="text-info">Nº GESTACIONES</br>[G]:</h6> 
                    <input type="number" class="form-control" 
                        name="gestaciones" value="0">                
                </div> 
                <div class="col-sm-3">
                <h6 class="text-info">Nº PARTOS</br>[P]:</h6>   
                    <input type="number" class="form-control"
                        name="partos" value="0">             
                </div>
                <div class="col-sm-3">
                <h6 class="text-info">Nª ABORTOS</br>[A]</h6>
                    <input type="number" class="form-control"              
                        name="abortos"  placeholder="Sistólica" value="0">               
                </div>
                <div class="col-sm-3">
                <h6 class="text-info">Nº CESÁREAS</br>[C]</h6>
                        <input type="number" class="form-control"              
                        name="cesareas" placeholder="Diastólica" value="0">          
                </div>
            </div>




    <?php   
    break;
    default: ?>
 
    <div class="form-group row"> 
    <div class="col-sm-9"> 
    <h6 class="text-info">ORIENTACIÓN MÉDICA:</h6>
    <textarea class="form-control" rows="4" name="motivo_consulta" required></textarea>
    </div> 
    <div class="col-sm-3">
    </div> 
    </div>
   
    <input type="hidden" name="talla" value="0"> 
    <input type="hidden" name="peso" value="0"> 
    <input type="hidden" name="temperatura" value="0"> 
    <input type="hidden" name="frec_cardiaca" value="0"> 
    <input type="hidden" name="frec_respiratoria" value="0"> 
    <input type="hidden" name="presion_arterial" value="0"> 
    <input type="hidden" name="presion_arterial_d" value="0"> 
    <input type="hidden" name="saturacion" value="0">  
    <?php }  ?>

