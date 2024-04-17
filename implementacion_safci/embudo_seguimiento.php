<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

$idsospecha_diag = $_GET['idsospecha_diag'];
$iddepartamento = $_GET['iddepartamento'];

$sql_sos = " SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idsospecha_diag='$idsospecha_diag' ";
$result_sos = mysqli_query($link,$sql_sos);
$row_sos = mysqli_fetch_array($result_sos);

$sql_dep = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento' ";
$result_dep = mysqli_query($link,$sql_dep);
$row_dep = mysqli_fetch_array($result_dep);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>SEGUIMIENTO PACIENTES</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {

    $('#container').highcharts({
        chart: {
            type: 'funnel',
            marginRight: 100
        },
        title: {
            text: 'SEGUIMIENTO : <?php echo $row_dep[1];?> - <?php echo $row_sos[1];?> ',
            x: -50
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b> ({point.y:,.0f})',
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                    softConnector: true
                },
                neckWidth: '30%',
                neckHeight: '25%'

                //-- Other available options
                // height: pixels or percent
                // width: pixels or percent
            }
        },
        legend: {
            enabled: false
        },
        series: [{
            name: 'Casos con seguimiento',
            data: [

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
            ]
        }]
    });
});
		</script>
	</head>
	<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/funnel.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="min-width: 500px; max-width: 600px; height: 450px; margin: 0 auto"></div>

</br>
<table width="768" border="1" align="center" bordercolor="#009999">

    <tr>
        <td width="22" bgcolor="#FFFFFF" class="Estilo8 Estilo1 Estilo2" style="font-family: Arial; font-size: 12px;"> N° </td>
        <td width="391" bgcolor="#FFFFFF" class="Estilo8 Estilo1 Estilo2" style="font-family: Arial; font-size: 12px;">SEGUIMIENTO EPIDEMIOLÓGICO</td>
        <td width="70" align="center" bgcolor="#FFFFFF" class="Estilo7" style="font-family: Arial; font-size: 12px;">CANTIDAD</td>
        <td width="173" align="center" bgcolor="#FFFFFF" class="Estilo7" style="font-family: Arial; font-size: 12px;">VER</td>
    </tr>

    <?php

$numero = 1;
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

        <tr>
          <td width="22" bgcolor="#FFFFFF" class="Estilo8 Estilo1 Estilo2"><?php echo $numero;?></td>
          <td width="391" bgcolor="#FFFFFF" class="Estilo8 Estilo1 Estilo2"><?php echo $row0[1];?></td>
          <td align="center" bgcolor="#FFFFFF" class="Estilo7"><?php echo $cantidad;?></td>
          <td bgcolor="#FFFFFF" align="center" class="Estilo8 Estilo1 Estilo2">
          <a class="btn btn-primary btn-icon-split" href="detalle_fichas_ep_deptal.php?idestado_paciente=<?php echo $row0[0];?>&iddepartamento=<?php echo $iddepartamento?>&idsospecha_diag=<?php echo $idsospecha_diag?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=850,scrollbars=YES,top=50,left=300'); return false;">
        REPORTE FICHAS</a>
        </td>
        </tr>   

        <?php
        $numero++;

        } while ($row0 = mysqli_fetch_array($result0));
        } else {
        echo ",";
        }
    ?>
    </table>

         


	</body>
</html>
