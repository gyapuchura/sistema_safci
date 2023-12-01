<?php 
include("../inc.config.php");
$idformacion_academica_p = $_POST['formacion_academica_p'];

if ($idformacion_academica_p == '9') {
?>
 <input type="hidden" name="descripcion_academica_p" value="NO CORRESPONDE">
 <input type="hidden" name="entidad_academica_p" value="NO CORRESPONDE">
 <input type="hidden" name="gestion_p" value="NO CORRESPONDE">
<?php
} else {
?>
    <div class="col-sm-6">
        <h6 class="text-primary">DESCRIPCIÓN  
        <?php 
        switch ($idformacion_academica_p) {
        case 5:
            echo "DEL DIPLOMADO";
            break;
        case 6:
            echo "DE LA ESPECIALIZACIÓN";
            break;
        } ?>    
        :</h6> 
    <textarea class="form-control" rows="2" name="descripcion_academica_p" required></textarea>
    </div>
    <div class="col-sm-4">
    <h6 class="text-primary">NOMBRE DE LA ENTIDAD DE FORMACIÓN:</h6> 
    <textarea class="form-control" rows="2" name="entidad_academica_p" required></textarea>
    </div>
    <div class="col-sm-2">
    <h6 class="text-primary">GESTIÓN:</h6>
    <input type="text" class="form-control" name="gestion_p" required>
    </div>
<?php
}
?>
     