<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
$idgrupo_cf = $_POST['grupo_cf'];

switch ($idgrupo_cf) {

    case 1: ?>

    <form name="GRUPO_I" action="guarda_grupo1_cf.php" method="post"> 
        <hr> 
        <div class="form-group row">  
        <div class="col-sm-3">
            <h6 class="text-info">GRUPO I :</h6> 
            <input type="hidden" name="idgrupo_cf" value="<?php echo $idgrupo_cf;?>">
        </div>
        <div class="col-sm-5">
            <h6>APARENTEMENTE SANO(A)</h6>
        </div>
        <div class="col-sm-4">    
        <input name="integrante_ap_sano" type="hidden" value="APARENTEMENTE SANO(A)">
            <button type="submit" class="btn btn-info btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-file"></i>
            </span>
            <span class="text">ADICIONAR GRUPO</span>    
            </button>
    </form> 
        </div>
        </div>     

        <?php
        break;
    case 2:
        ?>

    <form name="GRUPO_II" action="guarda_grupo2_cf.php" method="post"> 
        <hr> 
        <div class="form-group row">  
        <div class="col-sm-3">
            <h6 class="text-info">GRUPO II :</h6> 
            <input type="hidden" name="idgrupo_cf" value="<?php echo $idgrupo_cf;?>">
        </div>
        <div class="col-sm-9">
        <h6 class="text-info">FACTORES DE RIESGO</h6> 
        <select name="idfactor_riesgo_cf"  id="idfactor_riesgo_cf" class="form-control" required>
            <option value="">Seleccione</option>
            <?php
            $sql1 = " SELECT idfactor_riesgo_cf, factor_riesgo_cf FROM factor_riesgo_cf ";
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

        <div class="form-group row"> 
        <div class="col-sm-3">  
        </div> 
        <div class="col-sm-5" id="otro_factor_riesgo_cf">  
        </div> 

        <div class="col-sm-4">    
        </br>
            <button type="submit" class="btn btn-info btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-file"></i>
            </span>
            <span class="text">ADICIONAR GRUPO</span>    
            </button>
    </form> 
        </div>
        </div>    

        <?php
        break;
    case 3:
        ?>

    <form name="GRUPO_III" action="guarda_grupo3_cf.php" method="post"> 
        <hr> 
        <div class="form-group row">  
        <div class="col-sm-3">
            <h6 class="text-info">GRUPO III :</h6> 
            <input type="hidden" name="idgrupo_cf" value="<?php echo $idgrupo_cf;?>">
        </div>
        <div class="col-sm-9">
        <h6 class="text-info">MORBILIDAD</h6>   
        <select name="idmorbilidad_cf"  id="idmorbilidad_cf" class="form-control" required>
            <option value="">Seleccione</option>
            <?php
            $sql1 = " SELECT morbilidad_cf.idmorbilidad_cf, morbilidad_cf.morbilidad_cf, tipo_enfermedad_cf.tipo_enfermedad_cf ";
            $sql1.= " FROM morbilidad_cf, tipo_enfermedad_cf WHERE morbilidad_cf.idtipo_enfermedad_cf=tipo_enfermedad_cf.idtipo_enfermedad_cf ";
            $result1 = mysqli_query($link,$sql1);
            if ($row1 = mysqli_fetch_array($result1)){
            mysqli_field_seek($result1,0);
            while ($field1 = mysqli_fetch_field($result1)){
            } do {
            echo "<option value=".$row1[0].">".$row1[1]." .-  ".$row1[2]."</option>";
            } while ($row1 = mysqli_fetch_array($result1));
            } else {
            echo "No se encontraron resultados!";
            }
            ?>
        </select>
        </div>
        </div>  

        <div class="form-group row"> 
            <div class="col-sm-3"> 
            </div>
            <div class="col-sm-6" id="otra_enfermedad_cf"> 
            </div>
            <div class="col-sm-3">    
        </br>
            <button type="submit" class="btn btn-info btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-file"></i>
            </span>
            <span class="text">ADICIONAR GRUPO</span>    
            </button>
        </form> 
        </div>
        </div>
        
        <?php
        break;
    case 4:
        ?>

<form name="GRUPO_IV" action="guarda_grupo4_cf.php" method="post"> 
        <hr> 
        <div class="form-group row">  
        <div class="col-sm-3">
        <h6 class="text-info">GRUPO IV : </h6> 
        <input type="hidden" name="idgrupo_cf" value="<?php echo $idgrupo_cf;?>">
        </div>
        <div class="col-sm-3">   
        <h6 class="text-info">TIPO DE DISCAPACIDAD</h6>          
        <select name="idtipo_discapacidad_cf"  id="idtipo_discapacidad_cf" class="form-control" required>
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
        <div class="col-sm-3">  
        <h6 class="text-info">NIVEL DE DISCAPACIDAD</h6>           
        <select name="idnivel_discapacidad_cf"  id="idnivel_discapacidad_cf" class="form-control" required>
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
        <div class="col-sm-3">    
        </br>
            <button type="submit" class="btn btn-info btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-file"></i>
            </span>
            <span class="text">ADICIONAR GRUPO</span>    
            </button>
        </form> 
        </div>
        </div>       
      <?php
      break;
    }              
?>
<script language="javascript">
        $(document).ready(function(){
        $("#idfactor_riesgo_cf").change(function () {
                    $("#idfactor_riesgo_cf option:selected").each(function () {
                        factor_riesgo_cf=$(this).val();
                    $.post("otro_factor_riesgo_cf.php", {factor_riesgo_cf:factor_riesgo_cf}, function(data){
                    $("#otro_factor_riesgo_cf").html(data);
                    });
                });
        })
        });
    </script> 

<script language="javascript">
        $(document).ready(function(){
        $("#idmorbilidad_cf").change(function () {
                    $("#idmorbilidad_cf option:selected").each(function () {
                        morbilidad_cf=$(this).val();
                    $.post("otra_enfermedad_cf.php", {morbilidad_cf:morbilidad_cf}, function(data){
                    $("#otra_enfermedad_cf").html(data);
                    });
                });
        })
        });
    </script> 
