
<?php
$idcat_determinante_salud = $_POST['cat_determinante_salud'];

if ($idcat_determinante_salud == '14' || $idcat_determinante_salud == '15') {  ?>

    <div class="col-sm-3">
        <h6 class="text-info">VALOR 1 o 5 (NO=1, SI=5)</h6>
        </div>
        <div class="col-sm-9">    
        <select name="valor_cfe" class="form-control" required>
                <option value="">-SELECCIONE-</option>
                <option value="5">SI ( =5 )</option>
                <option value="1">NO ( =1 )</option>      
                </select>   
        </div>

<?php } else { if ($idcat_determinante_salud == '19') {  ?>

    <div class="col-sm-3">
        <h6 class="text-info">VALOR 0 o 1 (NO=0, SI=1)</h6>
        </div>
        <div class="col-sm-9">    
        <select name="valor_cfe" class="form-control" required>
                <option value="">-SELECCIONE-</option>
                <option value="1">SI ( =1 )</option>
                <option value="0">NO ( =0 )</option>      
                </select>   
        </div>
        
<?php  } else {  if ($idcat_determinante_salud == '21') { ?>

    <div class="col-sm-3">
        <h6 class="text-info">VALOR 1 o 5 (NO=5, SI=1)</h6>
        </div>
        <div class="col-sm-9">    
        <select name="valor_cfe" class="form-control" required>
                <option value="">-SELECCIONE-</option>
                <option value="1">SI ( =1 )</option>
                <option value="5">NO ( =5 )</option>      
                </select>   
        </div>
            
<?php  } else {  ?>
    <input type="hidden" name="valor_cfe" value="0">
<?php }}} ?>