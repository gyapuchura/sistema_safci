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
 
<?php } else {  ?>
 
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
            
<?php } ?>


