<?php include("../inc.config.php");

$gestion = date("Y");
$idsospecha_diag_deptal = $_POST["sospecha_diag_deptal"];

?>

        <div class="form-group row">
            <div class="col-sm-12">
                <h5 class="text-primary">DEPARTAMENTOS DONDE SE PRESENTARON SOSPECHAS DIAGNÓSTICAS</h5>
            </div>
        </div>

    <?php
    $numero=1; 
    $sql =" SELECT departamento.iddepartamento, departamento.departamento FROM notificacion_ep, registro_enfermedad, departamento ";
    $sql.=" WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND notificacion_ep.iddepartamento=departamento.iddepartamento ";
    $sql.=" AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_deptal' AND notificacion_ep.gestion='$gestion' GROUP BY departamento.iddepartamento ";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);           
    while ($field = mysqli_fetch_field($result)){
    } do {

    ?>


        <div class="form-group row">
        <div class="col-sm-1">
                <h5 class="text-secondary"><?php echo $numero;?> </h5>
            </div>
            <div class="col-sm-4">
                <h5 class="text-secondary"><?php echo $row[1];?> </h5>
            </div>
            <div class="col-sm-4">
            <a class="btn btn-primary btn-icon-split" href="marco_ep_departamental.php?sospecha_diag_deptal=<?php echo $idsospecha_diag_deptal;?>&departamento_ep=<?php echo $row[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=400,scrollbars=YES,top=50,left=300'); return false;">
            <span class="icon text-white-50">
                <i class="fas fa-book"></i>
            </span>
            <span class="text">REPORTE DEPARTAMENTAL</span></a>
            </div>
            <div class="col-sm-3">
            </div>
        </div>

        <?php
        $numero=$numero+1;
        }
        while ($row = mysqli_fetch_array($result));
        } else {
        }
        ?>