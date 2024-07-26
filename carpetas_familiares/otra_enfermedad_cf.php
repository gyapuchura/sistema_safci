<?php include("../cabf.php");?>
<?php
$idmorbilidad_cf = $_POST['morbilidad_cf'];
if ($idmorbilidad_cf == '19') { ?>

    <h6 class="text-info">DESCRIBIR LA OTRA ENFERMEDAD</h6>
    <textarea class="form-control" rows="2" name="otra_enfermedad" placeholder=""></textarea> 

<?php } else {  ?>

    <input name="otra_enfermedad" type="hidden" value=" ">

<?php } ?>