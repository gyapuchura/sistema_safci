<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); 
$idestablecimiento_salud = $_POST["establecimiento_salud"];
?>
                <div class="text-center">
                <div class="form-group row"> 
                    <div class="col-sm-6">
                  <!--- <a class="btn btn-primary btn-icon-split" href="reporte_riesgos_dep.php?iddepartamento=<?php echo $iddepartamento;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=1000,scrollbars=YES,top=50,left=200'); return false;">
                        <span class="icon text-white-50">
                            <i class="fas fa-book"></i>
                        </span>
                        <span class="text">REPORTE DE RIÉSGOS EN EL DEPARTAMENTO</span></a>   --->
                    </div>
                    <div class="col-sm-6">
                        <a class="btn btn-info btn-icon-split" href="establecimiento_a_sala.php?idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1400,height=1000,scrollbars=YES,top=50,left=200'); return false;">
                        <span class="icon text-white-50">
                            <i class="fas fa-book"></i>
                        </span>
                        <span class="text">SALA SITUACIONAL DEL ESTABLECIMIENTO</span></a>
                    </div>
                </div>   
                <hr>