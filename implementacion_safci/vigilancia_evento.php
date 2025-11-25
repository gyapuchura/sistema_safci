<?php include("../cabf.php");?>
<?php 
include("../inc.config.php");
$gestion = date("Y");
$idevento_notificacion = $_POST["evento_notificacion"];

$sql_ev = " SELECT idevento_notificacion, evento_notificacion FROM evento_notificacion WHERE idevento_notificacion='$idevento_notificacion' ";
$result_ev = mysqli_query($link,$sql_ev);
$row_ev = mysqli_fetch_array($result_ev);

$sql_c =" SELECT SUM(registro_evento_notificacion.numero_eventos) FROM notificacion_ep, registro_evento_notificacion  ";
$sql_c.=" WHERE registro_evento_notificacion.idnotificacion_ep=notificacion_ep.idnotificacion_ep ";
$sql_c.=" AND notificacion_ep.estado='CONSOLIDADO' AND registro_evento_notificacion.idevento_notificacion='$idevento_notificacion' ";
$sql_c.=" AND notificacion_ep.gestion='$gestion'  ";
$result_c = mysqli_query($link,$sql_c);
$row_c = mysqli_fetch_array($result_c);
?>
        <div class="form-group row">
            <div class="col-sm-12">
                <h4 class="text-primary"><?php echo mb_strtoupper($row_ev[1]);?></h4>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
            <a class="btn btn-primary btn-icon-split" href="marco_eventos_nacional.php?idevento_notificacion=<?php echo $idevento_notificacion;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=700,scrollbars=YES,top=50,left=300'); return false;">
            <span class="icon text-white-50">
                <i class="fas fa-book"></i>
            </span>
            <span class="text">REPORTE EVENTOS DE NOTIFICACIÓN INMEDIATA</span></a>
            </div>

            <div class="col-sm-4">
            <h5><?php echo $row_c[0];?> [Eventos]</h5>
            </div>

            <div class="col-sm-4">                
            <a class="btn btn-warning btn-icon-split" href="mapa_eventos_nal.php?idevento_notificacion=<?php echo $idevento_notificacion;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=900,scrollbars=YES,top=50,left=300'); return false;">
            <span class="icon text-white-50">
                <i class="fas fa-book"></i>
            </span>
            <span class="text">MAPA DE EVENTOS DE NOTIFICACIÓN INMEDIATA</span></a> 
            </div>

        </div>
        