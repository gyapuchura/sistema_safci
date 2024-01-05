<?php 
$idmunicipio_salud = $_POST["municipio_salud"];
?>
        <div class="form-group row">
            <div class="col-sm-6">
            <a class="btn btn-primary btn-icon-split" href="mapa_municipio.php?idmunicipio_salud=<?php echo $idmunicipio_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=700,scrollbars=YES,top=50,left=200'); return false;">
            <span class="icon text-white-50">
                <i class="fas fa-book"></i>
            </span>
            <span class="text">GENERAR MAPA DEL MUNICIPIO</span></a>
            </div>
            <div class="col-sm-6">
            <!-- <form name="DEPTO_PERSONAL" action="reporte_personal_municipio_excel.php" method="post">
                 <input type="hidden" name="idmunicipio_salud" value="<?php echo $idmunicipio_salud;?>">
                 <button type="submit" class="btn btn-success">REPORTE EN EXCEL</button>
                 </form> -->
            </div>
        </div>
        