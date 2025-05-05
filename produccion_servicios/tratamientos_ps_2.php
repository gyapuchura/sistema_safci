<?php include("../inc.config.php"); ?>
<?php
    $tratamientos_2 = $_POST['tratamientos'];

 ?>

<input type="hidden" name="tratamientos_2" value="<?php echo $tratamientos_2;?>">

        <div class="form-group row"> 
        <div class="col-sm-2"> 
        <h6 class="text-info">TRATAMIENTO 2,1 : </h6>
        </div> 
        <div class="col-sm-4">    
        <select name="idtipo_medicamento_21"  id="idtipo_medicamento_21" class="form-control" required>
            <option value="">-SELECCIONE-</option>
            <?php
            $numero=1;
            $sql1 = "SELECT idtipo_medicamento, tipo_medicamento FROM tipo_medicamento ORDER BY idtipo_medicamento";
            $result1 = mysqli_query($link,$sql1);
            if ($row1 = mysqli_fetch_array($result1)){
            mysqli_field_seek($result1,0);
            while ($field1 = mysqli_fetch_field($result1)){
            } do {
            echo "<option value=".$row1[0].">".$numero.".- ".$row1[1]."</option>";
            $numero=$numero+1;
            } while ($row1 = mysqli_fetch_array($result1));
            } else {
            echo "No se encontraron resultados!";
            }
            ?>
            </select>
        </div> 
        <div class="col-sm-2"> 
        <h6 class="text-info">MEDICAMENTO 2,1 :</h6>
        </div> 
        <div class="col-sm-4">
        <select name="idmedicamento_21"  id="idmedicamento_21" class="form-control" required></select>
        </div> 
        </div>         

<?php if ($tratamientos_2 == '2') {  ?>

<hr>
    <div class="form-group row"> 
    <div class="col-sm-2"> 
    <h6 class="text-info">TRATAMIENTO 2,2:</h6>
    </div>
    <div class="col-sm-4"> 
    <select name="idtipo_medicamento_22"  id="idtipo_medicamento_22" class="form-control" required>
        <option value="">-SELECCIONE-</option>
        <?php
        $numero=1;
        $sql1 = "SELECT idtipo_medicamento, tipo_medicamento FROM tipo_medicamento ORDER BY idtipo_medicamento";
        $result1 = mysqli_query($link,$sql1);
        if ($row1 = mysqli_fetch_array($result1)){
        mysqli_field_seek($result1,0);
        while ($field1 = mysqli_fetch_field($result1)){
        } do {
        echo "<option value=".$row1[0].">".$numero.".- ".$row1[1]."</option>";
        $numero=$numero+1;
        } while ($row1 = mysqli_fetch_array($result1));
        } else {
        echo "No se encontraron resultados!";
        }
        ?>
        </select>
    </div> 
    <div class="col-sm-2">
    <h6 class="text-info">MEDICAMENTO 2,2:</h6>
    </div> 
    <div class="col-sm-4">
        <select name="idmedicamento_22"  id="idmedicamento_22" class="form-control" required></select>
    </div> 
    </div> 

    <?php  } else {   }  ?> 

    <script language="javascript">
        $(document).ready(function(){
        $("#idtipo_medicamento_21").change(function () {
                    $("#idtipo_medicamento_21 option:selected").each(function () {
                        tipo_medicamento=$(this).val();
                    $.post("../eventos_safci/tipo_medicamento.php", {tipo_medicamento:tipo_medicamento}, function(data){
                    $("#idmedicamento_21").html(data);
                    });
                });
        })
        });
    </script>

    <script language="javascript">
        $(document).ready(function(){
        $("#idtipo_medicamento_22").change(function () {
                    $("#idtipo_medicamento_22 option:selected").each(function () {
                        tipo_medicamento=$(this).val();
                    $.post("../eventos_safci/tipo_medicamento.php", {tipo_medicamento:tipo_medicamento}, function(data){
                    $("#idmedicamento_22").html(data);
                    });
                });
        })
        });
    </script>

