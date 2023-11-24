<?php 
$iddepartamento_rep = $_POST["departamento_rep"];
?>
        <div class="form-group row">
            <div class="col-sm-6">
            <a class="btn btn-primary btn-icon-split" href="detalle_personal_departamento.php?iddepartamento_rep=<?php echo $iddepartamento_rep;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=700,scrollbars=YES,top=50,left=200'); return false;">
            <span class="icon text-white-50">
                <i class="fas fa-book"></i>
            </span>
            <span class="text">GENERAR LISTADO DEPARTAMENTO</span></a>
            </div>
            <div class="col-sm-6">
            <form name="DEPTO_PERSONAL" action="reporte_personal_departamento_excel.php" method="post">
                <input type="hidden" name="iddepartamento_rep" value="<?php echo $iddepartamento_rep;?>">
                <button type="submit" class="btn btn-success">REPORTE EN EXCEL</button>
            </form>
            </div>
        </div>
