<?php include("../cabf.php"); ?>
<?php include("../inc.config.php");
$idcarpeta_familiar_ss  = $_SESSION['idcarpeta_familiar_ss'];
$idcat_determinante_salud = $_POST["cat_determinante_salud"];
?>
<?php
if ($idcat_determinante_salud == '17') { ?>
  
        <div class="col-sm-4">
        <h6 class="text-info">NÚMERO DE INTEGRANTES DE LA FAMILIA:</h6>
        </div>
        <div class="col-sm-2">   
            <?php 
                    $sql1 = "SELECT idintegrante_cf, idcarpeta_familiar FROM integrante_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                    $result1 = mysqli_query($link,$sql1);
                    $integrantes = mysqli_num_rows($result1);
                    echo $integrantes;
            ?>
            <input type="hidden" name="integrantes" value="<?php echo $integrantes;?>">
        </div>
        <div class="col-sm-4">
        <h6 class="text-info">CUANTOS CUARTOS O HABITACIONES DE LA VIVIENDA OCUPA PARA DORMIR</h6>
        </div>
        <div class="col-sm-2">   
        <input type="number" class="form-control" name="habitaciones" required>
        </div>
 
<?php } else {  if ($idcat_determinante_salud == '14') { ?>

        <div class="col-sm-3"></div>
        <div class="col-sm-3"><h6 class="text-info">1. Cerca al rio o charco: </h6>
                              <h6 class="text-info">2. Cerca al corral: </h6>
                              <h6 class="text-info">3. Cerca a basura: </h6>
                              <h6 class="text-info">4. Inseguridad ciudadana: </h6>
                              <h6 class="text-info">5. Otros: </h6>                         
        </div>        
        <div class="col-sm-4">
      <h6 class="text-info"> NO <input type="radio" name="campo[0]" value="1" checked> SI <input type="radio" name="campo[0]" value="5" ></h6>  
      <h6 class="text-info"> NO <input type="radio" name="campo[1]" value="1" checked> SI <input type="radio" name="campo[1]" value="5" ></h6>  
      <h6 class="text-info"> NO <input type="radio" name="campo[2]" value="1" checked> SI <input type="radio" name="campo[2]" value="5" ></h6> 
      <h6 class="text-info"> NO <input type="radio" name="campo[3]" value="1" checked> SI <input type="radio" name="campo[3]" value="5" ></h6>
      <h6 class="text-info"> NO <input type="radio" name="campo[4]" value="1" checked> SI <input type="radio" name="campo[4]" value="5" ></h6> 
        </div>

        <div class="col-sm-2"></div>
               
     <?php   } else {   if ($idcat_determinante_salud == '15') { ?>
               
        <div class="col-sm-3"></div>
        <div class="col-sm-4"><h6 class="text-info">1. Falta de higiene en la vivienda: </h6>
                              <h6 class="text-info">2. Gradas precarias: </h6>
                              <h6 class="text-info">3. Vivienda en construcción: </h6>
                              <h6 class="text-info">4. Animales de granja y corral en vivienda: </h6>
                              <h6 class="text-info">5. Otros: </h6>                         
        </div>        
        <div class="col-sm-4">
      <h6 class="text-info"> NO <input type="radio" name="valor2[0]" value="1" checked> SI <input type="radio" name="valor2[0]" value="5" ></h6>  
      <h6 class="text-info"> NO <input type="radio" name="valor2[1]" value="1" checked> SI <input type="radio" name="valor2[1]" value="5" ></h6>  
      <h6 class="text-info"> NO <input type="radio" name="valor2[2]" value="1" checked> SI <input type="radio" name="valor2[2]" value="5" ></h6> 
      <h6 class="text-info"> NO <input type="radio" name="valor2[3]" value="1" checked> SI <input type="radio" name="valor2[3]" value="5" ></h6>
      <h6 class="text-info"> NO <input type="radio" name="valor2[4]" value="1" checked> SI <input type="radio" name="valor2[4]" value="5" ></h6> 
        </div>

        <div class="col-sm-1"></div>    

       <?php } else {  if ($idcat_determinante_salud == '19') { ?>

        <div class="col-sm-3"></div>
        <div class="col-sm-7"><h6 class="text-info">1, ¿Se preocupó (sintió pena) que en su hogar quedaran sin alimentos? </h6>
                              <h6 class="text-info">2. ¿Realmente en su hogar se quedaron sin alimentos? </h6>
                              <h6 class="text-info">3. ¿Dejó de tener una alimentación nutritiva y saludable? </h6>
                              <h6 class="text-info">4. ¿Tuvo una alimentación con poca variedad de alimentos? </h6>
                              <h6 class="text-info">5. ¿Dejó de desayunar almorzar y cenar? </h6>   
                              <h6 class="text-info">6. ¿Comió menos de lo que está acostumbrado a comer?</h6>
                              <h6 class="text-info">7. ¿Sintió hambre pero no comió? </h6>
                              <h6 class="text-info">8. ¿Comió solo una vez al día o dejó de comer todo el día? </h6>                       
        </div>        
        <div class="col-sm-2">
      <h6 class="text-info"> NO <input type="radio" name="valor3[0]" value="0" checked> SI <input type="radio" name="valor3[0]" value="1" ></h6>  
      <h6 class="text-info"> NO <input type="radio" name="valor3[1]" value="0" checked> SI <input type="radio" name="valor3[1]" value="1" ></h6>  
      <h6 class="text-info"> NO <input type="radio" name="valor3[2]" value="0" checked> SI <input type="radio" name="valor3[2]" value="1" ></h6> 
      <h6 class="text-info"> NO <input type="radio" name="valor3[3]" value="0" checked> SI <input type="radio" name="valor3[3]" value="1" ></h6>
      <h6 class="text-info"> NO <input type="radio" name="valor3[4]" value="0" checked> SI <input type="radio" name="valor3[4]" value="1" ></h6> 
      <h6 class="text-info"> NO <input type="radio" name="valor3[5]" value="0" checked> SI <input type="radio" name="valor3[5]" value="1" ></h6> 
      <h6 class="text-info"> NO <input type="radio" name="valor3[6]" value="0" checked> SI <input type="radio" name="valor3[6]" value="1" ></h6>
      <h6 class="text-info"> NO <input type="radio" name="valor3[7]" value="0" checked> SI <input type="radio" name="valor3[7]" value="1" ></h6> 
        </div>  

        <?php } else {  if ($idcat_determinante_salud == '21') { ?>
 
        <div class="col-sm-3"></div>
        <div class="col-sm-5"><h6 class="text-info">1. Consumo de cereales, tubérculos y derivados </h6>
                              <h6 class="text-info">2. Consumo de verduras </h6>
                              <h6 class="text-info">3. Consumo de frutas </h6>
                              <h6 class="text-info">4. Consumo de lácteos </h6>
                              <h6 class="text-info">5. Consumo de carnes </h6>  
                              <h6 class="text-info">6. Consumo de sal yodada </h6>                        
        </div>        
        <div class="col-sm-3">
      <h6 class="text-info"> NO <input type="radio" name="valor4[0]" value="5" checked> SI <input type="radio" name="valor4[0]" value="1" ></h6>  
      <h6 class="text-info"> NO <input type="radio" name="valor4[1]" value="5" checked> SI <input type="radio" name="valor4[1]" value="1" ></h6>  
      <h6 class="text-info"> NO <input type="radio" name="valor4[2]" value="5" checked> SI <input type="radio" name="valor4[2]" value="1" ></h6> 
      <h6 class="text-info"> NO <input type="radio" name="valor4[3]" value="5" checked> SI <input type="radio" name="valor4[3]" value="1" ></h6>
      <h6 class="text-info"> NO <input type="radio" name="valor4[4]" value="5" checked> SI <input type="radio" name="valor4[4]" value="1" ></h6> 
      <h6 class="text-info"> NO <input type="radio" name="valor4[5]" value="5" checked> SI <input type="radio" name="valor4[5]" value="1" ></h6>
        </div>
        <div class="col-sm-1"></div>

        <?php } else {   ?>

    <div class="col-sm-3">
    <h6 class="text-info">FACTOR DETERMINANTE</h6>
    </div>
    <div class="col-sm-9">   
            <select name="iditem_determinante_salud" id="iditem_determinante_salud" class="form-control" required>
            <option value="">Elegir</option>
            <?php
            $sql2 = "SELECT iditem_determinante_salud, item_determinante_salud, valor FROM item_determinante_salud WHERE idcat_determinante_salud='$idcat_determinante_salud'";
            $result2 = mysqli_query($link,$sql2);
            if ($row2 = mysqli_fetch_array($result2)){
            mysqli_field_seek($result2,0);
            while ($field2 = mysqli_fetch_field($result2)){
            } do {
            echo "<option value=".$row2[0].">".$row2[1]."</option>";
            } while ($row2 = mysqli_fetch_array($result2));
            } else {
            echo "No se encontraron resultados!";
            }
            ?> 
                    </select>
                </div>
            </div>
            
<?php         } } } } } ?>


