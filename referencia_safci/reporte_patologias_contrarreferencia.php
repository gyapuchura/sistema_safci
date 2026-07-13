<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram      = date("Ymd");
$fecha          = date("Y-m-d");
$gestion        = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$inicio = $_GET['inicio'];
$finalizacion = $_GET['finalizacion'];

$fecha_i = explode('-',$inicio);
$f_inicio = $fecha_i[2].'/'.$fecha_i[1].'/'.$fecha_i[0];

$fecha_f = explode('-',$finalizacion);
$f_finalizacion = $fecha_f[2].'/'.$fecha_f[1].'/'.$fecha_f[0];

?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>REPORTE DIAGNOSTICOS CONTRARREFERENCIA</title>

        <script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
    <style type="text/css">
    ${demo.css}
            </style>
            <script type="text/javascript">
    $(function () {
    $('#container').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'REPORTE DIAGNÓSTICOS DE EGRESO A LA CONTRARREFERENCIA - NACIONAL'
        },
        subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-APS del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
        },
        xAxis: {
            categories: [
                <?php 
// CORRECCIÓN: Ordenamos por la cantidad total de diagnósticos de forma DESCENDENTE
$numero = 0;
$sql = " SELECT p.idpatologia, p.patologia, p.cie, COUNT(d.iddiagnostico_egreso) as total ";
$sql.= " FROM diagnostico_egreso d, patologia p, referencia_hc a ";
$sql.= " WHERE d.idpatologia=p.idpatologia AND d.idreferencia_hc=a.idreferencia_hc ";
$sql.= " AND d.fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY p.idpatologia ORDER BY total DESC ";
$result = mysqli_query($link,$sql);
$total = mysqli_num_rows($result);
 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
    ?>
 '<?php  echo $row[1];?> - <?php  echo $row[2];?>'
<?php 
$numero++;
if ($numero == $total) { echo ""; } else { echo ","; }
} while ($row = mysqli_fetch_array($result));
}
?>
            ],
            title: { text: null }
        },
        yAxis: {
            min: 0,
            title: { text: ' DIAGNÓSTICOS DE EGRESO ', align: 'high' },
            labels: { overflow: 'justify' }
        },
        tooltip: { valueSuffix: ' Diagnósticos' },
        plotOptions: {
            bar: { dataLabels: { enabled: true } }
        },
        legend: {
            layout: 'vertical', align: 'right', verticalAlign: 'top', x: -40, y: 100, floating: true, borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'), shadow: true
        },
        credits: { enabled: false },
        series: [{
            name: 'DIAGNÓSTICOS',
            data: [
                <?php 
                // Misma lógica de ordenamiento DESC para la serie de datos
                mysqli_data_seek($result, 0);
                $numero3 = 0;
                while ($row = mysqli_fetch_array($result)) {
                    echo $row[3];
                    $numero3++;
                    if ($numero3 < $total) echo ",";
                }
                ?> 
            ] 
        }]
    });
});
        </script>
</head>
    <body>
<script src="../js/contrarreferencia.js"></script>
<script src="../js/highcharts-3d.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; max-width: 850px; height: <?php echo ($numero3*60) + 100;?>px; margin: 0 auto"></div>

<h4 align="center" style="font-family: Arial;">Nº DIAGNÓSTICOS DE EGRESO PARA CONTRARREFERENCIA: 
<?php
$sql_dgt = " SELECT count(d.iddiagnostico_egreso) FROM diagnostico_egreso d, patologia p ";
$sql_dgt.= " WHERE d.idpatologia=p.idpatologia AND d.fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
$result_dgt = mysqli_query($link,$sql_dgt);
$row_dgt = mysqli_fetch_array($result_dgt);
echo $row_dgt[0];
?>
</h4>
<h4 align="center" style="font-family: Arial;"> DEL <?php echo $f_inicio;?> AL <?php echo $f_finalizacion;?></h4>

<table width="1000" border="1" align="center" bordercolor="#009999">
    <tr>
        <td width="50" bgcolor="#FFFFFF" style="font-family: Arial;"><span class="Estilo8" style="font-size: 12px"> N° </span></td>
        <td width="400" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8">DIAGNÓSTICOS DE EGRESO</span></td>
        <td width="50" bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><span class="Estilo8">CIE</span></td>
            <?php
            $sql_d = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento != '10' ORDER BY iddepartamento ";
            $result_d = mysqli_query($link,$sql_d);
            while ($row_d = mysqli_fetch_array($result_d)) { ?>
            <td width="200" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;">
            <a href="reporte_contrarreferencias_depto_fechas.php?iddepartamento=<?php echo $row_d[0];?>&inicio=<?php echo $inicio;?>&finalizacion=<?php echo $finalizacion;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1420,height=820,scrollbars=YES,top=50,left=200'); return false;"><?php echo $row_d[1] ?></a>
            </td>
            <?php } ?>
            <td width="200" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;">TOTAL.</td>
    </tr>
    <?php
    // Usamos el mismo resultado ordenado de la consulta inicial para la tabla
    mysqli_data_seek($result, 0);
    $numero = 1;
    while ($row = mysqli_fetch_array($result)) { ?>
        <tr>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $numero;?></td>
            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row[1];?></td>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;">
                 <a href="patologias_diario_nal_cref_fechas.php?idpatologia=<?php echo $row[0];?>&inicio=<?php echo $inicio;?>&finalizacion=<?php echo $finalizacion;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1420,height=820,scrollbars=YES,top=50,left=200'); return false;"><?php echo $row[2];?></a>
            </td>
            <?php
            mysqli_data_seek($result_d, 0); // Reiniciamos puntero de departamentos
            while ($row_d = mysqli_fetch_array($result_d)) {
                $sql_dg = " SELECT count(d.iddiagnostico_egreso) FROM diagnostico_egreso d, referencia_hc a ";
                $sql_dg.= " WHERE d.idreferencia_hc=a.idreferencia_hc AND a.iddepartamento='$row_d[0]' ";
                $sql_dg.= " AND d.fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND d.idpatologia = '$row[0]' ";
                $result_dg = mysqli_query($link,$sql_dg);
                $row_dg = mysqli_fetch_array($result_dg);
                echo "<td align='center'>".$row_dg[0]."</td>";
            }
            ?>
            <td bgcolor="#FFFFFF" align="center"><?php echo $row[3]; ?></td>
        </tr> 
        <?php $numero++; } ?>
</table>

</body>
</html>