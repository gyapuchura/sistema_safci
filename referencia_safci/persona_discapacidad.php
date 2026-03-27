<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
$persona_discapacidad = $_POST['persona_discapacidad'];

if ($persona_discapacidad == 'SI') { ?>

                        <div class="col-sm-4">   
                        <h6 class="text-primary">TIPO DE DISCAPACIDAD</h6>          
                        <select name="idtipo_discapacidad"  id="idtipo_discapacidad" class="form-control" required>
                            <option value="">Seleccione Tipo</option>
                            <?php
                            $sql1 = " SELECT idtipo_discapacidad_cf, tipo_discapacidad_cf FROM tipo_discapacidad_cf ";
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
                        </div>
                        <div class="col-sm-4">  
                        <h6 class="text-primary">NIVEL DE DISCAPACIDAD</h6>           
                        <select name="idnivel_discapacidad"  id="idnivel_discapacidad" class="form-control" required>
                            <option value="">Seleccione Nivel</option>
                            <?php
                            $sql1 = " SELECT idnivel_discapacidad_cf, nivel_discapacidad_cf FROM nivel_discapacidad_cf ";
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
                        </div>
                        <div class="col-sm-4">
                        </div>

<?php } else { ?>
<input type="hidden" name="idtipo_discapacidad" value="0">
<?php } ?>
