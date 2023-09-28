
<?php 
include("../inc.config.php");
$idtipo_area_influencia = $_POST['tipo_area_influencia'];
if ($idtipo_area_influencia == '1') {
    ?>
        <h6 class="text-primary">NACIÓN:</h6> 
            <select name="idnacion"  id="idnacion" class="form-control" required>
                <option value="">ELEGIR</option>
                <?php
                $sql1 = "SELECT idnacion, nacion FROM nacion ";
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
    <?php
    } else {  
        ?>
<input type="hidden" name="idnacion" value="33">
        <?php
     }
        ?> 
        