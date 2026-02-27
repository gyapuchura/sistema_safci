<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php

$idpatologia_ap_sano = $_POST['patologia_ap_sano'];

$edad_ss = $_SESSION['edad_ss'];

if ($idpatologia_ap_sano == '239' || $idpatologia_ap_sano == '242' || $idpatologia_ap_sano == '456' || $idpatologia_ap_sano == '238') {  ?>
    
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

<?php  if ($edad_ss >= '5') {  ?>
    
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
        <!-- <h6 class="text-info">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6> -->
            <input type="hidden" class="form-control"              
                name="presion_arterial"  placeholder="Sistólica" value="0">               
        </div>
        <div class="col-sm-3">
        <!-- <h6 class="text-info"> </br>diastólica [mmHg]</h6>  --> 
                <input type="hidden" class="form-control"              
                name="presion_arterial_d" placeholder="Diastólica" value="0">          
        </div>
        <div class="col-sm-3">
        <!-- <h6 class="text-info">SATURACIÓN</br>[% O2]:</h6>   --> 
            <input type="hidden" class="form-control"
                name="saturacion" value="0">                
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

<?php } else { ?>
   
    <div class="form-group row"> 
    <div class="col-sm-9"> 
    <h6 class="text-info">ORIENTACIÓN MÉDICA:</h6>
    <textarea class="form-control" rows="4" name="motivo_consulta" required></textarea>
    </div> 
    <div class="col-sm-3">
    </div> 
    </div>

<?php }  ?>
    
 