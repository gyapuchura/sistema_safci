<?php include("../cabf.php");?>
<?php 
include("../inc.config.php");
$idprofesion = $_POST['profesion'];
if ($idprofesion == '1') {
    ?>
            <h6 class="text-primary">ESPECIALIDAD MÉDICA:</h6> 
                <select name="idespecialidad_medica"  id="idespecialidad_medica" class="form-control" required>
                    <option value="">ELEGIR</option>
                    <?php
                    $sql1 = "SELECT idespecialidad_medica, especialidad_medica FROM especialidad_medica WHERE idespecialidad_medica !='45' ORDER BY especialidad_medica ";
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
<input type="hidden" name="idespecialidad_medica" value="45">
        <?php
     }
        ?> 
        