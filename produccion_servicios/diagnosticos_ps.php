<?php include("../inc.config.php"); ?>
<?php
    $diagnosticos = $_POST['diagnosticos'];

    ?>      
       <input type="hidden" name="diagnosticos" value="<?php echo $diagnosticos;?>">
    

<!-------- 1 diagnostico - 1 o 2 tratamientos -----> 
    <div class="form-group row"> 
    <div class="col-sm-6">
    <h6 class="text-info">DIAGNÓSTICO 1 :</h6>
    </div> 
    <div class="col-sm-6"> 
    <h6 class="text-info">
    </div> 
    </div> 

    <div class="form-group row"> 
    <div class="col-sm-6">
    <h6 class="text-info">MOTIVO DE LA CONSULTA 1:</h6>
    <textarea class="form-control" rows="3" name="motivo_consulta1" required ></textarea>
    </div> 
    <div class="col-sm-6">
    <h6 class="text-info">C.I.E. :</h6>
    <select name="idpatologia1"  id="idpatologia1" class="form-control" required>
        <option value="">-SELECCIONE-</option>
        <?php
        $numero=1;
        $sql1 = "SELECT idpatologia, patologia, cie FROM patologia WHERE cie NOT LIKE '%Z%' ORDER BY patologia";
        $result1 = mysqli_query($link,$sql1);
        if ($row1 = mysqli_fetch_array($result1)){
        mysqli_field_seek($result1,0);
        while ($field1 = mysqli_fetch_field($result1)){
        } do {
        echo "<option value=".$row1[0].">".$row1[1]." - ".$row1[2]."</option>";
        $numero=$numero+1;
        } while ($row1 = mysqli_fetch_array($result1));
        } else {
        echo "No se encontraron resultados!";
        }
        ?>
        </select>
    </div> 
    </div> 
    <hr>
            <div class="form-group row"> 
            <div class="col-sm-3">
            <h6 class="text-info">NÚMERO DE TRATAMIENTOS:</h6>
            </div> 
            <div class="col-sm-3"> 
            <select name="tratamientos_1"  id="tratamientos_1" class="form-control" required>
            <option value="">-SELECCIONE-</option>
            <option value="1">1 TRATAMIENTO</option>
            <option value="2">2 TRATAMIENTOS</option>
            </select>
            </div> 
            <div class="col-sm-6">
            </div> 
            </div> 

            <div id="tratamientos_ps_1"></div>

 <?php  if ($diagnosticos == '2') {    ?>

<!-------- 2 diagnosticos - 1 o 2 tratamientos -----> 
    <hr>
    </br>
    </br>
    <div class="form-group row"> 
    <div class="col-sm-12">
    <h6 class="text-info">DIAGNÓSTICO 2 :</h6>
    </div> 
    </div> 

    <div class="form-group row"> 
    <div class="col-sm-6">
    <h6 class="text-info">MOTIVO DE LA CONSULTA 2:</h6>
    <textarea class="form-control" rows="3" name="motivo_consulta2" required></textarea>
    </div> 
    <div class="col-sm-6">
    <h6 class="text-info">C.I.E. :</h6>
    <select name="idpatologia2"  id="idpatologia2" class="form-control" required>
        <option value="">-SELECCIONE-</option>
        <?php
        $numero=1;
        $sql1 = "SELECT idpatologia, patologia, cie FROM patologia WHERE cie NOT LIKE '%Z%' ORDER BY patologia";
        $result1 = mysqli_query($link,$sql1);
        if ($row1 = mysqli_fetch_array($result1)){
        mysqli_field_seek($result1,0);
        while ($field1 = mysqli_fetch_field($result1)){
        } do {
        echo "<option value=".$row1[0].">".$row1[1]." - ".$row1[2]."</option>";
        $numero=$numero+1;
        } while ($row1 = mysqli_fetch_array($result1));
        } else {
        echo "No se encontraron resultados!";
        }
        ?>
        </select>
    </div> 
    </div> 
<hr>
<div class="form-group row"> 
            <div class="col-sm-3">
            <h6 class="text-info">NÚMERO DE TRATAMIENTOS:</h6>
            </div> 
            <div class="col-sm-3"> 
            <select name="tratamientos_2"  id="tratamientos_2" class="form-control" required>
            <option value="">-SELECCIONE-</option>
            <option value="1">1 TRATAMIENTO</option>
            <option value="2">2 TRATAMIENTOS</option>
            </select>
            </div> 
            <div class="col-sm-6">
            </div> 
            </div> 

            <div id="tratamientos_ps_2"></div>

<?php  } else { }  ?>

    <script language="javascript">
        $(document).ready(function(){
        $("#tratamientos_1").change(function () {
                    $("#tratamientos_1 option:selected").each(function () {
                        tratamientos=$(this).val();
                    $.post("tratamientos_ps_1.php", {tratamientos:tratamientos}, function(data){
                    $("#tratamientos_ps_1").html(data);
                    });
                });
        })
        });
    </script>

    <script language="javascript">
        $(document).ready(function(){
        $("#tratamientos_2").change(function () {
                    $("#tratamientos_2 option:selected").each(function () {
                        tratamientos=$(this).val();
                    $.post("tratamientos_ps_2.php", {tratamientos:tratamientos}, function(data){
                    $("#tratamientos_ps_2").html(data);
                    });
                });
        })
        });
    </script>