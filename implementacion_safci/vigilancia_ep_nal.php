<?php 
include("../inc.config.php");
$gestion = date("Y");
$sospecha_diag_nal = $_POST["sospecha_diag_nal"];

$sql_sos = " SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idsospecha_diag='$idsospecha_diag_nal' ";
$result_sos = mysqli_query($link,$sql_sos);
$row_sos = mysqli_fetch_array($result_sos);

$sql_c =" SELECT SUM(registro_enfermedad.cifra) FROM notificacion_ep, registro_enfermedad ";
$sql_c.=" WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep ";
$sql_c.=" AND notificacion_ep.estado='CONSOLIDADO' AND registro_enfermedad.idsospecha_diag='$sospecha_diag_nal' ";
$sql_c.=" AND notificacion_ep.gestion='$gestion' ";
$result_c = mysqli_query($link,$sql_c);
$row_c = mysqli_fetch_array($result_c);
?>
        <div class="form-group row">
            <div class="col-sm-12">
                <h4 class="text-primary"><?php echo mb_strtoupper($row_sos[1]);?></h4>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-3">
            <a class="btn btn-primary btn-icon-split" href="marco_ep_nacional.php?sospecha_diag_nal=<?php echo $sospecha_diag_nal;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=400,scrollbars=YES,top=50,left=300'); return false;">
            <span class="icon text-white-50">
                <i class="fas fa-book"></i>
            </span>
            <span class="text">REPORTE NACIONAL</span></a>
            </div>

            <div class="col-sm-2">
            <h5><?php echo $row_c[0];?> [Casos]</h5>
            </div>

            <div class="col-sm-3">                
            <a class="btn btn-info btn-icon-split" href="piramide_sospechas_nal.php?sospecha_diag_nal=<?php echo $sospecha_diag_nal;?>&departamento_ep=<?php echo $row[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=400,scrollbars=YES,top=50,left=300'); return false;">
            <span class="icon text-white-50">
                <i class="fas fa-book"></i>
            </span>
            <span class="text">GRUPOS ETAREOS</span></a>
            </div>

            <div class="col-sm-2">                
            <a class="btn btn-warning btn-icon-split" href="piramide_sospechas_deptal.php?sospecha_diag_deptal=<?php echo $idsospecha_diag_deptal;?>&departamento_ep=<?php echo $row[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=400,scrollbars=YES,top=50,left=300'); return false;">
            <span class="icon text-white-50">
                <i class="fas fa-book"></i>
            </span>
            <span class="text">F-302A</span></a>
            </div>
        </div>
        