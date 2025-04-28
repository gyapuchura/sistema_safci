<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php
    $tratamientos_1 = $_POST['tratamientos'];

    if ($tratamientos_1 == '1') { ?>

<input type="hidden" name="tratamientos_1" value="1">
<input type="hidden" name="tratamientos_2" value="0">

        <div class="form-group row"> 
        <div class="col-sm-2"> 
        <h6 class="text-info">TRATAMIENTO 1,1 :</h6>
        </div> 
        <div class="col-sm-4">    
            <select name="idtipo_medicamento_11"  id="idtipo_medicamento_11" class="form-control" required>
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
        <h6 class="text-info">MEDICAMENTO 1,1 :</h6>
        </div> 
        <div class="col-sm-4">
            <select name="idmedicamento_11"  id="idmedicamento_11" class="form-control" required></select>
        </div> 
        </div> 

        <input type="hidden" name="idtipo_medicamento_12" value="0">
        <input type="hidden" name="idmedicamento_12" value="0">
        <input type="hidden" name="idtipo_medicamento_21" value="0">
        <input type="hidden" name="idmedicamento_21" value="0">
        <input type="hidden" name="idtipo_medicamento_22" value="0">
        <input type="hidden" name="idmedicamento_22" value="0">
        

<?php   } else {   ?>

    <input type="hidden" name="tratamientos_1" value="2">
    <input type="hidden" name="tratamientos_2" value="0">

<div class="form-group row"> 
    <div class="col-sm-2"> 
    <h6 class="text-info">TRATAMIENTO 1,1:</h6>
    </div> 
    <div class="col-sm-4">    
        <select name="idtipo_medicamento_11"  id="idtipo_medicamento_11" class="form-control" required>
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
    <h6 class="text-info">MEDICAMENTO 1,1:</h6>
    </div> 
    <div class="col-sm-4">
        <select name="idmedicamento_11"  id="idmedicamento_11" class="form-control" required></select>
    </div> 
    </div> 
<hr>
    <div class="form-group row"> 
    <div class="col-sm-2"> 
    <h6 class="text-info">TRATAMIENTO 1,2:</h6>
    </div>
    <div class="col-sm-4"> 
        <select name="idtipo_medicamento_12"  id="idtipo_medicamento_12" class="form-control" required>
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
    <h6 class="text-info">MEDICAMENTO 1,2:</h6>
    </div> 
    <div class="col-sm-4">
        <select name="idmedicamento_12"  id="idmedicamento_12" class="form-control" required></select>
    </div> 
    </div> 
        <input type="hidden" name="idtipo_medicamento_21" value="0">
        <input type="hidden" name="idmedicamento_21" value="0">
        <input type="hidden" name="idtipo_medicamento_22" value="0">
        <input type="hidden" name="idmedicamento_22" value="0">

    <?php  }  ?>




    <script language="javascript">
        $(document).ready(function(){
        $("#idtipo_medicamento_11").change(function () {
                    $("#idtipo_medicamento_11 option:selected").each(function () {
                        tipo_medicamento=$(this).val();
                    $.post("../eventos_safci/tipo_medicamento.php", {tipo_medicamento:tipo_medicamento}, function(data){
                    $("#idmedicamento_11").html(data);
                    });
                });
        })
        });
    </script>

    <script language="javascript">
        $(document).ready(function(){
        $("#idtipo_medicamento_12").change(function () {
                    $("#idtipo_medicamento_12 option:selected").each(function () {
                        tipo_medicamento=$(this).val();
                    $.post("../eventos_safci/tipo_medicamento.php", {tipo_medicamento:tipo_medicamento}, function(data){
                    $("#idmedicamento_12").html(data);
                    });
                });
        })
        });
    </script>

