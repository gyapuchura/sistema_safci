<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php
$fecha 		= date("Y-m-d");
$idpatologia_ap_sano = $_POST['patologia_ap_sano'];

    switch ($idpatologia_ap_sano) {
    case 362: ?>

        <div class="form-group row"> 
            <div class="col-sm-6"> 
            <h6 class="text-warning">SE DEBE INICIAR LA HISTORIA CLINICA PERINATAL:</h6>
            
            </div>
            <div class="col-sm-6"> 
            <a class="btn btn-warning btn-icon-split" href="inicia_hc_perinatal.php" target="_blank" onClick="window.open(this.href, this.target, 'width=800,height=800,top=50, left=600, scrollbars=YES'); return false;">
            <span class="icon text-white-50">
                <i class="fas fa-book"></i>
            </span>
            <span class="text">NUEVA HISTORIA CLINICA PERINATAL</span></a> 
            
            </div> 
        </div>

    <?php   
    break;
    case 2: 
    ?>


    <?php    
    break; 
    } 
    ?>