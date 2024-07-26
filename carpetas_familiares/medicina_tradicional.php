<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php
$tradicional_cf = $_POST['tradicional_cf'];
if ($tradicional_cf == 'SI') { ?>

        <div class="col-sm-4"> 
        <h6 class="text-info">CATEGORÍA MEDICINA TRADICIONAL</h6>
        <select name="idmedicina_tradicional"  id="idmedicina_tradicional" class="form-control" required >
            <option value="">-SELECCIONE-</option>
            <?php
            $sql1 = " SELECT idmedicina_tradicional, medicina_tradicional FROM medicina_tradicional WHERE idmedicina_tradicional !='5' ";
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
        <h6 class="text-info">DONDE FUE ATENDIDO</h6>
        <select name="idlugar_atencion_trad"  id="idlugar_atencion_trad" class="form-control" required autofocus>
            <option value="">-SELECCIONE-</option>
            <?php
            $sql1 = " SELECT idlugar_atencion_trad, lugar_atencion_trad FROM lugar_atencion_trad WHERE idlugar_atencion_trad !='3'";
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
        <div class="col-sm-4"></br>
            <button type="submit" class="btn btn-info btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-file"></i>
            </span>
            <span class="text">REGISTRAR</span>    
            </button>
        </div>

<?php } else {  ?>

    <input name="idmedicina_tradicional" type="hidden" value="5">
    <input name="idlugar_atencion_trad" type="hidden" value="3">
    <div class="col-sm-4"></br>
        <button type="submit" class="btn btn-info btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-file"></i>
        </span>
        <span class="text">REGISTRAR</span>    
        </button>
    </div>

<?php } ?>