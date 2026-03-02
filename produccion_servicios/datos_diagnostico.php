<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php

$idpatologia_ap_sano = $_POST['patologia_ap_sano'];

$edad_ss = $_SESSION['edad_ss'];

//***** CONTROL DEL NIÑO SANO = 239 */
//***** CONTROL PRESION ARTERIAL = 242  */
//***** EXAMEN MEDICO GRAL. = 456  */
//***** CONTROL MEDICO = 238  */

//***** EMBARAZO CONFIRMADO = 362  */
//***** CONTROL EMBARAZO = 236  */




if ($idpatologia_ap_sano == '239' || $idpatologia_ap_sano == '242' || $idpatologia_ap_sano == '456' || $idpatologia_ap_sano == '238' || $idpatologia_ap_sano == '362' || $idpatologia_ap_sano == '236') 
{  ?>
    <hr>
    <div class="form-group row"> 
    <div class="col-sm-3"> 
    </div> 
    <div class="col-sm-6">
    <h4 class="text-info">SIGNOS VITALES:</h4>
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
        <!-- <h6 class="text-info">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6> -->
            <input type="hidden" class="form-control"              
                name="presion_arterial"  placeholder="Sistólica" value="0">               
        </div>
        <div class="col-sm-3">
        <!-- <h6 class="text-info"> </br>diastólica [mmHg]</h6>  --> 
                <input type="hidden" class="form-control"              
                name="presion_arterial_d" placeholder="Diastólica" value="0">          
        </div>
    </div>


<?php } ?>

<?php 

if ($idpatologia_ap_sano == '362') { ?>

<hr>
    <div class="form-group row"> 
    <div class="col-sm-3"> 
    </div> 
    <div class="col-sm-6">
    <h4 class="text-info">ANTECEDENTES OBSTÉTRICOS:</h4>
    </div> 
    <div class="col-sm-3"> 
    </div> 
    </div> 
<hr>   
    <div class="form-group row">
        <div class="col-sm-3">
        <h6 class="text-info">Nº GESTACIONES</br>[G]:</h6> 
            <input type="number" class="form-control" 
                name="frec_respiratoria" value="0">                
        </div> 
        <div class="col-sm-3">
         <h6 class="text-info">Nº PARTOS</br>[P]:</h6>   
            <input type="number" class="form-control"
                name="saturacion" value="0">             
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">Nª ABORTOS</br>[A]</h6>
            <input type="number" class="form-control"              
                name="presion_arterial"  placeholder="Sistólica" value="0">               
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">Nº CESÁREAS</br>[C]</h6>
                <input type="number" class="form-control"              
                name="presion_arterial_d" placeholder="Diastólica" value="0">          
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-3">
            <h6 class="text-info">FECHA ÚLTIMA MENSTRUACIÓN</br>[FUM]:</h6> 
            <input type="date" class="form-control" 
                name="fecha_fum" >                
        </div> 
        <div class="col-sm-3">
            <h6 class="text-info">FECHA PROBABLE DE PARTO</br>[FPP]:</h6>   
            <input type="date" class="form-control"
                name="saturacion" >             
        </div>
        <div class="col-sm-3">
            <!-- <h6 class="text-info">Nª ABORTOS</br>[A]</h6>  -->
            <input type="hidden" class="form-control"              
                name="presion_arterial"  placeholder="Sistólica" value="0">               
        </div>
        <div class="col-sm-3">
            <!-- <h6 class="text-info">Nº CESÁREAS</br>[C]</h6>  -->
                <input type="hidden" class="form-control"              
                name="presion_arterial_d" placeholder="Diastólica" value="0">          
        </div>
    </div>

<?php } else {  ?>
    

<?php } ?>


    <div class="form-group row"> 
    <div class="col-sm-9"> 
    <h6 class="text-info">ORIENTACIÓN MÉDICA:</h6>
    <textarea class="form-control" rows="4" name="motivo_consulta" required></textarea>
    </div> 
    <div class="col-sm-3">
    </div> 
    </div>

<?php } else { ?>
   
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
    
 