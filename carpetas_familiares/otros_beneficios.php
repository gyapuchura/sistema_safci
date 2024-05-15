<?php
$idprograma_social = $_POST['programa_social'];
if ($idprograma_social == '10') { ?>

    <h6 class="text-info">DESCRIBIR OTROS BENEFICIOS</h6>
    <textarea class="form-control" rows="2" name="otros_beneficios" placeholder="" required></textarea> 

<?php } else {  ?>

    <input name="otros_beneficios" type="hidden" value="">

<?php } ?>