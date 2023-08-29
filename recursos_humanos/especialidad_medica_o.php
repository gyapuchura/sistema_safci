<?php
include("../inc.config.php");

$idprofesion  = $_POST['profesion'];

if ($idprofesion != '1') {
  ?>

<input type="hidden" name="iddepartamento" value="4" >
<input type="hidden" name="idprovincia" value="52" >
<input type="hidden" name="idmunicipio" value="137" >

<?php 
} else {
    ?>  

            <div class="row">
            <div class="col-md-12"><h5> </h5></div>
            </div>
            <div class="row">
            <div class="col-md-12"><h5> </h5></div>
            </div>
            <div class="row">
            <div class="col-md-3"><h5 class="text-primary">ESPECIALIDAD MÉDICA:</h5></div>
            <div class="col-md-9">
                <select name="idespecialidad_medica"  id="idespecialidad_medica" class="form-control" required>
                    <option value="">ELEGIR</option>
                    <?php
                    $sql1 = "select idespecialidad_medica, especialidad_medica from especialidad_medica";
                    $result1 = mysqli_query($link,$sql1);
                    if ($row1 = mysqli_fetch_array($result1)){
                    mysqli_field_seek($result1,0);
                    while ($field1 = mysqli_fetch_field($result1)){
                    } do {
                    echo "<option value=". $row1[0]. ">". $row1[1]. "</option>";
                    } while ($row1 = mysqli_fetch_array($result1));
                    } else {
                    echo "No se encontraron resultados!";
                    }
                    ?>
                    </select>
            </div>
            </div>

 

        <?php    
        }
        ?>

