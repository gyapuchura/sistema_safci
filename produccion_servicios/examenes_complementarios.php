<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php

$examen_complementario = $_POST['examen_complementario'];

if ($examen_complementario == 'SI') { ?>
    
    <div class="form-group row">                               
        <div class="col-sm-3">
        <h6 class="text-info">RX:</br></h6>
            <input type="checkbox" name="radiografia" id="radiografia">              
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">LABORATORIO:</br></h6>
            <input type="checkbox" name="laboratorio" id="laboratorio">                
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">ECOGRAFÍA:</br></h6>
            <input type="checkbox" name="ecografia" id="ecografia">                
        </div>        
        <div class="col-sm-3">
        <h6 class="text-info">TOMOGRAFÍA:</br></h6>
            <input type="checkbox" name="tomografia" id="tomografia">                
        </div>
    </div>
    <div class="form-group row">                               
        <div class="col-sm-3">
        <h6 class="text-info">OTROS:</br>[Especifique]</h6>
            <input type="text" name="otros_examenes" id="radiografia" class="form-control">              
        </div>
        <div class="col-sm-9">
        <h6 class="text-info">(Descripción Cualitativa):</br></h6>
            <textarea class="form-control" rows="3" name="descripcion_examenes"></textarea>                
        </div> 
    </div>
                

<?php } else {  ?>
    


<?php } ?>