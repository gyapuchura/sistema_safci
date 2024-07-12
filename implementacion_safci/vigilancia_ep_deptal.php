<?php include("../inc.config.php");

$gestion = date("Y");
$idsospecha_diag_deptal = $_POST["sospecha_diag_deptal"];

$sql_sos = " SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idsospecha_diag='$idsospecha_diag_deptal' ";
$result_sos = mysqli_query($link,$sql_sos);
$row_sos = mysqli_fetch_array($result_sos);

?>

        <div class="form-group row">
            <div class="col-sm-12">
                <h4 class="text-primary"><?php echo mb_strtoupper($row_sos[1]);?></h4>
            </div>
        </div>

    <?php
    $numero=1; 
    $sql =" SELECT notificacion_ep.iddepartamento, departamento.departamento FROM notificacion_ep, registro_enfermedad, departamento ";
    $sql.=" WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND notificacion_ep.iddepartamento=departamento.iddepartamento ";
    $sql.=" AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_deptal' AND notificacion_ep.gestion='$gestion' GROUP BY notificacion_ep.iddepartamento ";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);           
    while ($field = mysqli_fetch_field($result)){
    } do {

        $sql_c =" SELECT SUM(registro_enfermedad.cifra) FROM notificacion_ep, registro_enfermedad ";
        $sql_c.=" WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep ";
        $sql_c.=" AND notificacion_ep.estado='CONSOLIDADO' AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_deptal' ";
        $sql_c.=" AND notificacion_ep.gestion='$gestion' AND notificacion_ep.iddepartamento='$row[0]' ";
        $result_c = mysqli_query($link,$sql_c);
        $row_c = mysqli_fetch_array($result_c);
    ?>

        <div class="form-group row">

            <div class="col-sm-2">
                <h5 class="text-secondary"><?php echo $row[1];?> </h5>
            </div>
            <div class="col-sm-2">
            <h5><?php echo $row_c[0];?> [Casos]</h5>
            </div>

            <div class="col-sm-3">
            <a class="btn btn-primary btn-icon-split" href="marco_ep_departamental.php?sospecha_diag_deptal=<?php echo $idsospecha_diag_deptal;?>&departamento_ep=<?php echo $row[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=480,scrollbars=YES,top=50,left=300'); return false;">
            <span class="icon text-white-50">
                <i class="fas fa-book"></i>
            </span>
            <span class="text">DEPARTAMENTAL</span></a>
            </div>

            <div class="col-sm-3">                
            <a class="btn btn-info btn-icon-split" href="piramide_sospechas_deptal.php?sospecha_diag_deptal=<?php echo $idsospecha_diag_deptal;?>&departamento_ep=<?php echo $row[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=500,scrollbars=YES,top=50,left=300'); return false;">
            <span class="icon text-white-50">
                <i class="fas fa-book"></i>
            </span>
            <span class="text">GRUPOS ETAREOS</span></a>
            </div>

            <div class="col-sm-2">                
            <a class="btn btn-warning btn-icon-split" href="mapasafci_ep_deptal.php?idsospecha_diag=<?php echo $idsospecha_diag_deptal;?>&iddepartamento=<?php echo $row[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=800,scrollbars=YES,top=50,left=300'); return false;">
            <span class="icon text-white-50">
                <i class="fas fa-book"></i>
            </span>
            <span class="text">MAPA</span></a> 
            </div>

        </div>

        <?php
        $numero=$numero+1;
        }
        while ($row = mysqli_fetch_array($result));
        } else {
        }
        ?>