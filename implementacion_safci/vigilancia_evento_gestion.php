<?php include("../cabf.php");?>
<?php 
include("../inc.config.php");
$gestion_ss     =  $_SESSION['gestion_ss'];
$idevento_notificacion = $_POST["evento_notificacion"];

$sql_ev = " SELECT idevento_notificacion, evento_notificacion FROM evento_notificacion WHERE idevento_notificacion='$idevento_notificacion' ";
$result_ev = mysqli_query($link,$sql_ev);
$row_ev = mysqli_fetch_array($result_ev);

$sql_c =" SELECT SUM(registro_evento_notificacion.numero_eventos) FROM notificacion_ep, registro_evento_notificacion  ";
$sql_c.=" WHERE registro_evento_notificacion.idnotificacion_ep=notificacion_ep.idnotificacion_ep ";
$sql_c.=" AND notificacion_ep.estado='CONSOLIDADO' AND registro_evento_notificacion.idevento_notificacion='$idevento_notificacion' ";
$sql_c.=" AND notificacion_ep.gestion='$gestion_ss'  ";
$result_c = mysqli_query($link,$sql_c);
$row_c = mysqli_fetch_array($result_c);
?>
        <div class="form-group row">
            <div class="col-sm-12">
                <h4 class="text-primary"><?php echo mb_strtoupper($row_ev[1]);?></h4>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-6">
            <a class="btn btn-primary btn-icon-split" href="marco_eventos_nacional_gestion.php?idevento_notificacion=<?php echo $idevento_notificacion;?>&gestion=<?php echo $gestion_ss;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=700,scrollbars=YES,top=50,left=300'); return false;">
            <span class="icon text-white-50">
                <i class="fas fa-book"></i>
            </span>
            <span class="text">REPORTE EVENTOS DE NOTIFICACIÓN INMEDIATA - GESTIÓN <?php echo $gestion_ss;?></span></a>
            </div>

            <div class="col-sm-4">
            <h5><?php echo $row_c[0];?> [Eventos]</h5>
            </div>

            <div class="col-sm-2">                
            <!---- <a class="btn btn-info btn-icon-split" href="piramide_sospechas_nal.php?sospecha_diag_nal=<?php echo $idsospecha_diag_nal;?>&departamento_ep=<?php echo $row[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=400,scrollbars=YES,top=50,left=300'); return false;">
            <span class="icon text-white-50">
                <i class="fas fa-book"></i>
            </span>
            <span class="text">GRUPOS ETAREOS</span></a> --->
            </div>

        </div>
        