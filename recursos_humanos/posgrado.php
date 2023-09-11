<?php 
include("../inc.config.php");
$idformacion_academica = $_POST['formacion_academica'];
if ($idformacion_academica == '5' || $idformacion_academica == '6' || $idformacion_academica == '7' || $idformacion_academica == '8') {
    ?>
            <h6 class="text-primary">DESCRIPCIÓN  
            <?php 
   switch ($idformacion_academica) {
    case 5:
        echo "DEL DIPLOMADO";
        break;
    case 6:
        echo "DE LA ESPECIALIZACIÓN";
        break;
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
            <h6 class="text-primary">NOMBRE DE LA ENTIDAD DE FORMACIÓN ACADÉMICA :</h6> 
            <textarea class="form-control" rows="2" name="entidad_academica" required></textarea>
            <h6 class="text-primary">GESTIÓN:</h6>
            <input type="text" class="form-control" name="gestion_ac" required>
    <?php
    } else {  
        ?>
            <h6 class="text-primary">NOMBRE DE LA ENTIDAD DE FORMACIÓN  
            <?php 
   switch ($idformacion_academica) {
    case 1:
        echo "DEL BACHILLERATO";
        break;
    case 2:
        echo "DEL NIVEL TECNICO MEDIO";
        break;
    case 3:
        echo "DEL NIVEL TECNICO SUPERIOR";
        break;
    case 4:
      echo "UNIVERSITARIA (LICENCIATURA)";
      break;
}                       
            ?>     
            :</h6> 
            <input type="hidden" name="descripcion_academica" value="FORMACIÓN DE PREGRADO/GRADO">
            <textarea class="form-control" rows="2" name="entidad_academica" required></textarea>
            <h6 class="text-primary">GESTIÓN:</h6>
            <input type="text" class="form-control" name="gestion_ac" required>
        <?php
     }
        ?>
        