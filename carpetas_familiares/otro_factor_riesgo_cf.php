<?php
$idfactor_riesgo_cf = $_POST['factor_riesgo_cf'];
if ($idfactor_riesgo_cf == '15') { ?>

    <h6 class="text-info">DESCRIBIR OTRO FACTOR DE RIESGO</h6>
    <textarea class="form-control" rows="2" name="otro_factor_riesgo" placeholder="" required></textarea> 

<?php } else {  ?>

    <input name="otro_factor_riesgo" type="hidden" value=" ">

<?php } ?>