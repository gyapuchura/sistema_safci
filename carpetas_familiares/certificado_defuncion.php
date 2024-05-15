<?php include("../inc.config.php"); ?>
<?php
$defuncion_cf = $_POST['defuncion_cf'];
if ($defuncion_cf == 'SI') { ?>
        <div class="col-sm-6">
            <h6 class="text-info">TIENE CERTIFICADO DE DEFUNCIÓN?</h6>
            <select name="certificado_defuncion_cf" id="certificado_defuncion_cf" class="form-control" required autofocus>
            <option value="">-SELECCIONE-</option>
            <option value="SI">SI</option>
            <option value="NO">NO</option>      
            </select>
        </div>
        <div class="col-sm-6"></br>
            <button type="submit" class="btn btn-info btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-file"></i>
            </span>
            <span class="text">REGISTRAR</span>    
            </button>
        </div>
<?php } else {  ?>
    <div class="col-sm-12"></br>

            <input name="certificado_defuncion_cf" type="hidden" value="">
            <button type="submit" class="btn btn-info btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-file"></i>
            </span>
            <span class="text">REGISTRAR</span>    
            </button>
        </div>

<?php } ?>