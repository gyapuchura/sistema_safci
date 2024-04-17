<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idsospecha_diag = '23';
$iddepartamento  = '3';

?>

<?php
$numero = 0;
$sql0 = " SELECT estado_paciente.idestado_paciente, estado_paciente.estado_paciente FROM estado_paciente, seguimiento_ep, notificacion_ep ";
$sql0.= " WHERE estado_paciente.idestado_paciente=seguimiento_ep.idestado_paciente AND seguimiento_ep.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND notificacion_ep.estado='CONSOLIDADO' ";
$sql0.= " AND notificacion_ep.gestion='$gestion' AND notificacion_ep.iddepartamento='$iddepartamento' AND seguimiento_ep.idsospecha_diag='$idsospecha_diag' GROUP BY estado_paciente.idestado_paciente ";
$result0 = mysqli_query($link,$sql0);

 if ($row0 = mysqli_fetch_array($result0)){
mysqli_field_seek($result0,0);
while ($field0 = mysqli_fetch_field($result0)){
} do {

    $cantidad=0;
    $sql ="  SELECT ficha_ep.idficha_ep, ficha_ep.codigo FROM ficha_ep, registro_enfermedad, notificacion_ep, establecimiento_salud, red_salud, municipios, nombre ";
    $sql.=" WHERE ficha_ep.idregistro_enfermedad=registro_enfermedad.idregistro_enfermedad  AND registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND notificacion_ep.idmunicipio=municipios.idmunicipio ";
    $sql.=" AND notificacion_ep.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND establecimiento_salud.idred_salud=red_salud.idred_salud AND ficha_ep.idnombre=nombre.idnombre AND notificacion_ep.gestion='$gestion' ";
    $sql.=" AND ficha_ep.direccion !='' AND notificacion_ep.iddepartamento='$iddepartamento' AND registro_enfermedad.idsospecha_diag='$idsospecha_diag' ORDER BY ficha_ep.fecha_registro DESC ";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);
    while ($field = mysqli_fetch_field($result)){
    } do {

        $sql2 = " SELECT seguimiento_ep.idseguimiento_ep, semana_ep.semana_ep, estado_paciente.estado_paciente, seguimiento_ep.idestado_paciente FROM seguimiento_ep, semana_ep, estado_paciente ";
        $sql2.= " WHERE seguimiento_ep.idsemana_ep=semana_ep.idsemana_ep AND seguimiento_ep.idestado_paciente=estado_paciente.idestado_paciente AND";
        $sql2.= " seguimiento_ep.idficha_ep='$row[0]' ORDER BY seguimiento_ep.idseguimiento_ep DESC LIMIT 1 ";
        $result2 = mysqli_query($link,$sql2);
        $row2    = mysqli_fetch_array($result2);
        if ($row2[3] == $row0[0]) { $cantidad=$cantidad+1; } else { }  
 
    }
    while ($row = mysqli_fetch_array($result));
    } else {
    }        
    ?>
            
             ['<?php echo $row0[1];?>',<?php echo $cantidad;?>]

    <?php
        $numero++;

        if ($numero == $total) { echo ""; } else { echo ","; }

        } while ($row0 = mysqli_fetch_array($result0));
        } else {
        echo ",";
        }
    ?>