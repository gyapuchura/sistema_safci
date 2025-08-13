<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); 
$iddepartamento = $_POST["departamento"];
?>
                <div class="text-center">
                <div class="form-group row"> 
                    <div class="col-sm-6">
                        <a class="btn btn-primary btn-icon-split" href="reporte_riesgos_dep.php?iddepartamento=<?php echo $iddepartamento;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=1000,scrollbars=YES,top=50,left=200'); return false;">
                        <span class="icon text-white-50">
                            <i class="fas fa-book"></i>
                        </span>
                        <span class="text">REPORTE DE RIÉSGOS EN EL DEPARTAMENTO</span></a>
                    </div>
                    <div class="col-sm-6">
                        <a class="btn btn-info btn-icon-split" href="visitas_safci_diarias_dep.php?iddepartamento=<?php echo $iddepartamento;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=1000,scrollbars=YES,top=50,left=200'); return false;">
                        <span class="icon text-white-50">
                            <i class="fas fa-book"></i>
                        </span>
                        <span class="text">REPORTE DE VISITAS EN EL DEPARTAMENTO</span></a>
                    </div>
                </div>   
                <hr>


