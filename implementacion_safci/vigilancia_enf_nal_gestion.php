<?php include("../cabf.php"); ?>
<?php 
include("../inc.config.php");
$gestion_ss     =  $_SESSION['gestion_ss'];
$idcat_registro = $_POST["cat_registro"];
?>

        <div class="form-group row">
            <div class="col-sm-6">
            <a class="btn btn-info btn-icon-split" href="enfermedades_nacional_gestion.php?idcat_registro=<?php echo $idcat_registro;?>&gestion=<?php echo $gestion_ss;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=650,scrollbars=YES,top=50,left=300'); return false;">
            <span class="icon text-white-50">
                <i class="fas fa-book"></i>
            </span>
            <span class="text">GENERAR REPORTE NACIONAL F302A - GESTIÓN <?php echo $gestion_ss;?></span></a>
            </div>
            <div class="col-sm-6">           
            </div>
        </div>
        