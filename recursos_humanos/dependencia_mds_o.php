<?php include("../cabf.php");?>
<?php
include("../inc.config.php");

$iddependencia  = $_POST['dependencia'];

    if ($iddependencia == '1') {
?>
    <!----- begin departamento donde se inscribio ----->

    <div class="form-group row">
                    <div class="col-sm-6">
                    <h6 class="text-primary">DEPARTAMENTO EN EL QUE SE REGISTRA:</h6>
                    </div>
                    <div class="col-sm-6">
                    <select name="iddepartamento"  id="iddepartamento" class="form-control" required>
                        <option value="">-SELECCIONE-</option>
                        <?php
                        $sql1 = "SELECT iddepartamento, departamento FROM departamento ";
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

<!----- end departamento donde se inscribio ----->
                <div class="form-group row">
                    <div class="col-sm-6">
                    <h6 class="text-primary">ENTIDAD A LA QUE PERTENECE:</h6>
                    </div>
                    <div class="col-sm-6">
                    <textarea class="form-control" rows="3" name="entidad" required></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                    <h6 class="text-primary">CARGO EN LA ENTIDAD:</h6>
                    </div>
                    <div class="col-sm-6">
                    <textarea class="form-control" rows="2" name="cargo_entidad" required></textarea>
                    </div>
                </div>
<?php 
} else {
    if ($iddependencia == '2') {
        ?>
 
     <!----- begin departamento donde se inscribio ----->

                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">DEPARTAMENTO:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="iddepartamento"  id="iddepartamento" class="form-control" required>
                        <option value="">-SELECCIONE-</option>
                        <?php
                        $sql1 = "SELECT iddepartamento, departamento FROM departamento ";
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

<!----- end departamento donde se inscribio ----->

                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">DEPENDIENTE DEL:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idministerio" id="idministerio" class="form-control" required>
                        <option value="">ELEGIR</option>
                        <?php
                        $sql1 = "SELECT idministerio, ministerio, sigla FROM ministerio";
                        $result1 = mysqli_query($link,$sql1);
                        if ($row1 = mysqli_fetch_array($result1)){
                        mysqli_field_seek($result1,0);
                        while ($field1 = mysqli_fetch_field($result1)){
                        } do {
                        echo "<option value=".$row1[0].">".$row1[2].".- ".$row1[1]."</option>";
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
                    <h6 class="text-primary">DIRECCIÓN/INSTITUCIÓN:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="iddireccion" id="iddireccion" class="form-control" required></select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">UNIDAD ORGANIZACIONAL:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idarea" id="idarea" class="form-control" required></select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                    <h6 class="text-primary">CARGO</h6><h6 class="text-primary">(DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN):</h6>
                    </div>
                    <div class="col-sm-6">
                    <textarea class="form-control" rows="2" name="cargo_mds" required></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                    <h6 class="text-primary">NÚMERO DE ÍTEM:</h6><h6 class="text-primary">(DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN):</h6>
                    </div>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="item_mds" placeholder="N° de Ítem"
                    required pattern="[A-Z0-9_-]{5,12}$" 
                    title="El numero de ÍTEM solo puede contener DIGITOS numéricos." >
                    </div>
                </div>

    <?php } else { ?>

                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">DEPARTAMENTO:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="iddepartamento"  id="iddepartamento" class="form-control" required>
                        <option value="">ELEGIR</option>
                        <?php
                        $sql1 = "SELECT iddepartamento, departamento FROM departamento";
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
                    <h6 class="text-primary">RED DE SALUD:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idred_salud" id="idred_salud" class="form-control" required></select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">ESTABLECIMIENTO DE SALUD:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idestablecimiento_salud" id="idestablecimiento_salud" class="form-control" required></select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-4">
                    <h6 class="text-primary">CARGO:</h6><h6 class="text-primary">(DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN):</h6>
                    </div>
                    <div class="col-sm-8">
                    <textarea class="form-control" rows="2" name="cargo_red_salud" required></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4">
                    <h6 class="text-primary">NÚMERO DE ÍTEM:</h6><h6 class="text-primary">(DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN):</h6>
                    </div>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" name="item_red_salud" placeholder="N° de Ítem"
                    required pattern="[A-Z0-9_-]{5,12}$" 
                    title="El numero de ÍTEM solo puede contener DIGITOS numéricos." >
                    </div>
                </div>

    <?php    
    }}
    ?>

<script language="javascript">
$(document).ready(function(){
   $("#idministerio").change(function () {
           $("#idministerio option:selected").each(function () {
            ministerio=$(this).val();
            $.post("direccion_o.php", {ministerio:ministerio}, function(data){
            $("#iddireccion").html(data);
            });
        });
   })
});
</script>

<script language="javascript">
$(document).ready(function(){
   $("#iddireccion").change(function () {
            $("#iddireccion option:selected").each(function () {
            direccion=$(this).val();
            $.post("areas_o.php", {direccion:direccion}, function(data){
            $("#idarea").html(data);
            });
        });
   })
});
</script>

<!------- para REDES DE SALUD ----->

<script language="javascript">
$(document).ready(function(){
   $("#iddepartamento").change(function () {
            $("#iddepartamento option:selected").each(function () {
                departamento=$(this).val();
            $.post("red_salud_o.php", {departamento:departamento}, function(data){
            $("#idred_salud").html(data);
            });
        });
   })
});
</script> 

<script language="javascript">
$(document).ready(function(){
   $("#idred_salud").change(function () {
            $("#idred_salud option:selected").each(function () {
                red_salud=$(this).val();
            $.post("establecimiento_salud_o.php", {red_salud:red_salud}, function(data){
            $("#idestablecimiento_salud").html(data);
            });
        });
   })
});
</script>
