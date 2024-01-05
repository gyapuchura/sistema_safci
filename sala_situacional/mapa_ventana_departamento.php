<?php 
$iddepartamento_mapa = $_POST["departamento_mapa"];
?>
        <div class="form-group row">
            <div class="col-sm-6">
            <a class="btn btn-primary btn-icon-split" href="mapa_departamento.php?iddepartamento_mapa=<?php echo $iddepartamento_mapa;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=700,scrollbars=YES,top=50,left=200'); return false;">
            <span class="icon text-white-50">
                <i class="fas fa-book"></i>
            </span>
            <span class="text">GENERAR MAPA DEL DEPARTAMENTO</span></a>
            </div>
            <div class="col-sm-6">
            <!-- <form name="DEPTO_PERSONAL" action="reporte_personal_municipio_excel.php" method="post">
                 <input type="hidden" name="idmunicipio_salud" value="<?php echo $idmunicipio_salud;?>">
                 <button type="submit" class="btn btn-success">REPORTE EN EXCEL</button>
                 </form> -->
            </div>
        </div>
        