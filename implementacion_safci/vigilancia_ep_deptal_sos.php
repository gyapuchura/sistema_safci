
<?php include("../cabf.php"); ?>
<?php include("../inc.config.php");
$iddepartamento_ep = $_POST["departamento_ep"];
?>

        <div class="form-group row">
            <div class="col-sm-6">
            <a class="btn btn-primary btn-icon-split" href="marco_ep_departamental.php?sospecha_diag_nal=<?php echo $idusuario_ss;?>&departamento=<?php echo $iddepartamento_ep;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=650,scrollbars=YES,top=50,left=300'); return false;">
            <span class="icon text-white-50">
                <i class="fas fa-book"></i>
            </span>
            <span class="text">REPORTE DEPARTAMENTAL</span></a>
            </div>
            <div class="col-sm-6">
                <?php echo "Valor=".$iddepartamento_ep; ?>
            <!-- <form name="DEPTO_PERSONAL" action="reporte_personal_municipio_excel.php" method="post">
                 <input type="hidden" name="idmunicipio_salud" value="<?php echo $idmunicipio_salud;?>">
                 <button type="submit" class="btn btn-success">REPORTE EN EXCEL</button>
                 </form> -->
            </div>
        </div>
