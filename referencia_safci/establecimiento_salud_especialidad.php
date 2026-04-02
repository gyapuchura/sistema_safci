<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
$establecimiento_salud = $_POST['establecimiento_salud'];
?>
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">10.- MOTIVO DE REFERENCIA</h6>
                </div>
                <div class="card-body">
                    <div class="form-group row">                              
                        <div class="col-sm-6">  
                            <h6 class="text-primary">MOTIVO:</h6> 
                            <select name="idmotivo_referencia" id="idmotivo_referencia" class="form-control" required>
                            <option value="">-SELECCIONE-</option>
                            <?php
                            $numero_mr=1;
                            $sql_mr = " SELECT idmotivo_referencia, motivo_referencia FROM motivo_referencia ORDER BY idmotivo_referencia"; 
                            $result_mr = mysqli_query($link,$sql_mr);
                            if ($row_mr = mysqli_fetch_array($result_mr)){
                            mysqli_field_seek($result_mr,0);
                            while ($field_mr = mysqli_fetch_field($result_mr)){
                            } do {
                            echo "<option value=".$row_mr[0].">".$numero_mr.".- ".$row_mr[1]." </option>";
                            $numero_mr=$numero_mr+1;
                            } while ($row_mr = mysqli_fetch_array($result_mr));
                            } else {
                            echo "No se encontraron resultados!";
                            }
                            ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <h6 class="text-primary">ESPECIALIDAD MÉDICA [<?php echo $establecimiento_salud; ?>]:</h6> 
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
                        </div>   
        
                    </div>
                </div>
