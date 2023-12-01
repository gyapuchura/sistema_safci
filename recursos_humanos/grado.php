<?php 
include("../inc.config.php");
$idformacion_academica = $_POST['formacion_academica'];
if ($idformacion_academica == '7' || $idformacion_academica == '8') {
    ?>
        <div class="col-sm-6">
            <h6 class="text-primary">DESCRIPCIÓN  
            <?php 
            switch ($idformacion_academica) {
            case 7:
            echo "DE LA MAESTRIA";
                break;
            case 8:
            echo "DEL DOCTORADO";
            break;
            }                       
            ?>    
            :</h6> 
            <textarea class="form-control" rows="2" name="descripcion_academica" required></textarea>
            </div>
            <div class="col-sm-4">
            <h6 class="text-primary">NOMBRE DE LA ENTIDAD DE FORMACIÓN:</h6> 
            <textarea class="form-control" rows="2" name="entidad_academica" required></textarea>
            </div>
            <div class="col-sm-2">
            <h6 class="text-primary">GESTIÓN:</h6>
            <input type="text" class="form-control" name="gestion_ac" required>
            </div>
    <?php
    } else {  
        ?>
            <div class="col-sm-8">
            <h6 class="text-primary">NOMBRE DE LA ENTIDAD DE FORMACIÓN  
            <?php 
        switch ($idformacion_academica) {
            case 1:
                echo "DEL BACHILLERATO";
                break;
            case 2:
                echo "DEL NIVEL TÉCNICO MEDIO";
                break;
            case 3:
                echo "DEL NIVEL TÉCNICO SUPERIOR";
                break;
            case 4:
            echo "UNIVERSITARIA (LICENCIATURA)";
            break;
            }                       
            ?>     
            :</h6> 
            <input type="hidden" name="descripcion_academica" value="FORMACIÓN DE PREGRADO/GRADO">
            <textarea class="form-control" rows="2" name="entidad_academica" required></textarea>
            </div>
            <div class="col-sm-4">
            <h6 class="text-primary">GESTIÓN:</h6>
            <input type="text" class="form-control" name="gestion_ac" required>
            </div>
        <?php
     }
        ?>
        