<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php
    $tratamientos = $_POST['tratamientos'];

    if ($tratamientos == '1') { ?>

        <div class="form-group row"> 
        <div class="col-sm-2"> 
        <h6 class="text-info">TRATAMIENTO 1:</h6>
        </div> 
        <div class="col-sm-4">    
            <select name="idtipo_medicamento_1"  id="idtipo_medicamento_1" class="form-control" required>
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
        <h6 class="text-info">MEDICAMENTO 1:</h6>
        </div> 
        <div class="col-sm-4">
            <select name="idmedicamento_1"  id="idmedicamento_11" class="form-control" required></select>
        </div> 
        </div> 

<?php   } else {   ?>

<div class="form-group row"> 
    <div class="col-sm-2"> 
    <h6 class="text-info">TRATAMIENTO 1:</h6>
    </div> 
    <div class="col-sm-4">    
        <select name="idtipo_medicamento_2"  id="idtipo_medicamento_2" class="form-control" required>
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
    <h6 class="text-info">MEDICAMENTO 1:</h6>
    </div> 
    <div class="col-sm-4">
        <select name="idmedicamento_2"  id="idmedicamento_2" class="form-control" required></select>
    </div> 
    </div> 
<hr>
    <div class="form-group row"> 
    <div class="col-sm-2"> 
    <h6 class="text-info">TRATAMIENTO 2:</h6>
    </div>
    <div class="col-sm-4"> 
        <select name="idtipo_medicamento_22"  id="idtipo_medicamento_22" class="form-control" >
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
    <h6 class="text-info">MEDICAMENTO 2:</h6>
    </div> 
    <div class="col-sm-4">
        <select name="idmedicamento_22"  id="idmedicamento_22" class="form-control" ></select>
    </div> 
    </div> 

    <?php  }  ?>

    <script language="javascript">
        $(document).ready(function(){
        $("#idtipo_medicamento_1").change(function () {
                    $("#idtipo_medicamento_1 option:selected").each(function () {
                        tipo_medicamento=$(this).val();
                    $.post("../eventos_safci/tipo_medicamento.php", {tipo_medicamento:tipo_medicamento}, function(data){
                    $("#idmedicamento_1").html(data);
                    });
                });
        })
        });
    </script>

    <script language="javascript">
        $(document).ready(function(){
        $("#idtipo_medicamento_2").change(function () {
                    $("#idtipo_medicamento_2 option:selected").each(function () {
                        tipo_medicamento=$(this).val();
                    $.post("../eventos_safci/tipo_medicamento.php", {tipo_medicamento:tipo_medicamento}, function(data){
                    $("#idmedicamento_2").html(data);
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
