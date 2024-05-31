<?php include("../inc.config.php");
$iddeterminante_salud = $_POST["determinante_salud"];
?>
<div class="form-group row">
<div class="col-sm-3">
<h6 class="text-info">ASPECTO DETERMINANTE</h6>
</div>
    <div class="col-sm-9">    
        <select name="idcat_determinante_salud" id="idcat_determinante_salud" class="form-control" required>
        <option value="">Elegir</option>
            <?php
            $sql2 = "SELECT idcat_determinante_salud, cat_determinante_salud FROM cat_determinante_salud WHERE iddeterminante_salud='$iddeterminante_salud' AND idcat_determinante_salud !='20'";
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

<div class="form-group row" id="factor_determinante"></div> 

<!-- <div class="form-group row" id='valor_determinante'></div> -->

        <script language="javascript">
            $(document).ready(function(){
            $("#idcat_determinante_salud").change(function () {
                        $("#idcat_determinante_salud option:selected").each(function () {
                            cat_determinante_salud=$(this).val();
                        $.post("factor_determinante.php", {cat_determinante_salud:cat_determinante_salud}, function(data){
                        $("#factor_determinante").html(data);
                        });
                    });
            })
            });
        </script> 

        <script language="javascript">
            $(document).ready(function(){
            $("#idcat_determinante_salud").change(function () {
                        $("#idcat_determinante_salud option:selected").each(function () {
                            cat_determinante_salud=$(this).val();
                        $.post("valor_determinante.php", {cat_determinante_salud:cat_determinante_salud}, function(data){
                        $("#valor_determinante").html(data);
                        });
                    });
            })
            });
        </script>